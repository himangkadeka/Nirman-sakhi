<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Relation;
use Illuminate\Http\Request;
use App\Models\MainWorkerForm;
use App\Models\MainWorkerFamily;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\GetVaultDataService;


class AsdmController extends Controller
{
    public function verifyWorker(Request $request)
    {
        Log::info('ASDM API HIT', $request->all());

        // Validation
        $request->validate([
            'type' => 'required|in:self,dependent',
            'id_card_no' => 'required_if:type,self,dependent|string',
            'name' => 'required_if:type,self|string',
            'first_name' => 'required_if:type,dependent',
            'gender' => 'required_if:type,self,dependent|in:M,F,O',
            'relation' => 'required_if:type,dependent',
            'dob' => 'required_if:type,self,dependent|date'
        ]);

        if ($request->type === 'self') {
            return $this->verifySelf($request);
        }

        return $this->verifyDependent($request);
    }

    private function verifySelf($request)
    {
        $worker = MainWorkerForm::where('ack_no', $request->id_card_no)
            ->where('status', 'F')
            ->first();

        if (!$worker) {
            return response()->json([
                'status' => false,
                'message' => 'Worker not found or not onboarded'
            ]);
        }

        $vaultService = new GetVaultDataService();
        $vaultResponse = $vaultService->getVaultData($worker->worker_id, $worker->status);

        if (!$vaultResponse) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to fetch Aadhaar data'
            ]);
        }

        $vaultData = json_decode($vaultResponse, true);

        // ✅ Aadhaar data
        $aadhaarName = strtolower(trim($vaultData['name'] ?? ''));
        $aadhaarDob = isset($vaultData['dob'])
            ? \Carbon\Carbon::parse($vaultData['dob'])->format('Y-m-d')
            : null;

        $aadhaarGender = strtoupper(substr($vaultData['gender'] ?? '', 0, 1));
        // Male → M, Female → F

        // ✅ Request data
        $reqName = strtolower(trim($request->name));
        $reqDob = \Carbon\Carbon::parse($request->dob)->format('Y-m-d');
        $reqGender = strtoupper(trim($request->gender));

        // ✅ Compare fields
        $mismatch = [];

        if ($aadhaarName !== $reqName) {
            $mismatch['name'] = 'Name does not match Aadhaar';
        }

        if ($aadhaarDob !== $reqDob) {
            $mismatch['dob'] = 'DOB does not match Aadhaar';
        }

        if ($aadhaarGender !== $reqGender) {
            $mismatch['gender'] = 'Gender does not match Aadhaar';
        }

        // ❌ If any mismatch
        if (!empty($mismatch)) {
            return response()->json([
                'status' => false,
                'message' => 'Aadhaar data mismatch',
                'mismatch_fields' => $mismatch,
                'data' => [
                    'id_card_no' => $worker->id_card,
                    'aadhaar_name' => $vaultData['name'] ?? null,
                    'aadhaar_dob' => $aadhaarDob,
                    'aadhaar_gen' => $vaultData['gender'] ?? null,
                ]
            ]);
        }

        // ✅ Success
        return response()->json([
            'status' => true,
            'type' => 'Self',
            'message' => 'Worker verified',
            'data' => [
                'id_card_no' => $worker->id_card,
                'aadhaar_name' => $vaultData['name'] ?? null,
                'aadhaar_dob' => $aadhaarDob,
                'aadhaar_gen' => $vaultData['gender'] ?? null,
                'onboarded' => true
            ]
        ]);
    }

    private function verifyDependent($request)
    {
        $reqName = strtolower(trim($request->first_name));
        $reqGender = strtoupper(trim($request->gender));
        $reqCard = strtolower(trim($request->id_card_no));

        try {
            $reqDob = \Carbon\Carbon::parse($request->dob)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid DOB format'
            ]);
        }

        $relation = $this->getRelation($request->relation);

        if (!$relation) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid relation'
            ]);
        }

        $relationCode = $relation->relation_code;
        $relationGender = $this->mapGender($relation->gender);

        // ✅ STEP 1: Check parent using ID card
        $records = MainWorkerFamily::select(
            'main_worker_families.*',
            'main_worker_forms.id_card as parent_id_card',
            'main_worker_forms.status as parent_status',
            'main_worker_forms.ack_no'
        )
            ->join('Worker.main_worker_forms', 'main_worker_forms.worker_id', '=', 'main_worker_families.worker_id')
            ->whereRaw('LOWER(TRIM(main_worker_forms.ack_no)) = ?', [$reqCard])
            ->get();

        if ($records->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid ID card number'
            ]);
        }

        // ✅ STEP 2: Check parent approval
        if ($records->first()->parent_status !== 'F') {
            return response()->json([
                'status' => false,
                'message' => 'Parent ID card not approved'
            ]);
        }

        // ✅ STEP 3: Validate each field
        $matchedRecord = null;
        $errors = [];

        foreach ($records as $record) {

            $dbName = strtolower(trim($record->first_name));
            $dbRelation = $record->relation;

            try {
                $dbDob = \Carbon\Carbon::createFromFormat('d-m-Y', trim($record->dob))->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }

            // perfect match
            if (
                $dbName === $reqName &&
                $dbRelation == $relationCode &&
                $dbDob === $reqDob &&
                $relationGender === $reqGender
            ) {
                $matchedRecord = $record;
                break;
            }

            // collect mismatches
            if ($dbName !== $reqName) $errors['name'] = 'Name does not match';
            if ($dbRelation != $relationCode) $errors['relation'] = 'Relation does not match';
            if ($dbDob !== $reqDob) $errors['dob'] = 'DOB does not match';
            if ($relationGender !== $reqGender) $errors['gender'] = 'Gender does not match relation';
        }

        // ✅ STEP 4: If match found
        if ($matchedRecord) {
            return response()->json([
                'status' => true,
                'type' => 'Dependent',
                'message' => 'Dependent verified',
                'data' => [
                    'first_name' => $matchedRecord->first_name,
                    'last_name' => $matchedRecord->last_name,
                    'relation' => $relation->relation_name,
                    'gender' => $relation->gender,
                    'dob' => \Carbon\Carbon::parse($matchedRecord->dob)->format('Y-m-d'),
                    'parent_id_card_no' => $matchedRecord->parent_id_card,
                ]
            ]);
        }

        // ❌ STEP 5: Return detailed mismatch
        return response()->json([
            'status' => false,
            'message' => 'Parent ID card matched but data mismatch',
            'mismatch_fields' => $errors
        ]);
    }

    private function getRelation($relationName)
    {
        return Relation::where('relation_name', trim($relationName))->first();
    }

    private function mapGender($gender)
    {
        $g = strtolower(trim($gender));

        switch ($g) {
            case 'male':
                return 'M';
            case 'female':
                return 'F';
            default:
                return 'O';
        }
    }

}
