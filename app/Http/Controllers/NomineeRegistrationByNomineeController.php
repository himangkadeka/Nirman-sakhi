<?php

namespace App\Http\Controllers;

use App\Models\MainWorkerFamily;
use App\Models\MainWorkerForm;
use App\Models\NomineeRegistration;
use App\Services\GetVaultDataService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class NomineeRegistrationByNomineeController extends Controller
{

    protected $getVaultDataService;
    /**
     * @var AesCipher
     */


    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService = $getVaultDataService;
    }


    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $nonceValue = session()->get('nonce_value');
            return view('worker.benefits.nominee.nominee-registration-by-nominee', compact('nonceValue'));
        } else {
            // return  $request->all();
            $validator = Validator::make($request->all(), [
                'applicant_name' => 'required',
                'applicant_phone' => 'required',
                'reg_type_choice' => 'required',

            ]);

            if ($validator->fails()) {
                Alert::error($validator->errors()->first());
                return redirect()->back();
            }

            try {
                DB::beginTransaction();
                $uid_data = json_decode(session()->get('uid_data'), true);
                $worker_id = MainWorkerForm::where('id_card', $request->id_no_search)->first()->worker_id;
                $nomine = NomineeRegistration::create([
                    'worker_id' => $worker_id,
                    'name' => $request->applicant_name,
                    'phone' => $request->applicant_phone,
                    'nominee_percentage' => $request->reg_type_choice == 'nominee' ? MainWorkerFamily::where('id', $request->nominee_id)->first()->nominee_percentage : null,
                    'family_id' => $request->reg_type_choice == 'nominee' ? $request->nominee_id : null,
                    'nominee_or_legal' => $request->reg_type_choice == 'nominee' ? 0 : 1,
                    'vault_token' => $uid_data['vaultToken'],
                    'valut_passkey' => $uid_data['vaultPassKey']

                ]);
                if ($request->reg_type_choice == 'nominee') {
                    MainWorkerFamily::where('id', $request->nominee_id)->update([
                        'is_nominee_registered' => true,
                        'is_aadhar_verified' => true,
                        'vault_data' => $uid_data['vaultToken'], // Store the vault token
                        'vault_pass_key' => $uid_data['vaultPassKey'],
                        'aadhar_verified_at' => now()
                    ]);
                }

                DB::commit();
                Alert::success("Nominee Registration Successfull");
                return redirect()->route('ekyc-thanks',$nomine->id);
            } catch (Exception $e) {
                DB::rollBack();
                return $e;
            }
        }
    }



    public function downloadKycAcknowledgment($nomine_id)
    {
        // 1. Get the authenticated worker's data from the session
        $nomineeDetail = NomineeRegistration::where('id',$nomine_id)->first();

        // 2. Fetch the full worker record to get the KYC timestamp
        // NOTE: Replace 'kyc_verified_at' with the actual column name in your database
        $wmf = MainWorkerForm::where('worker_id', $nomineeDetail->worker_id)->firstOrFail();

        // 3. Prepare the emblem image for the PDF
        $emblemPath = public_path('/assets/template/images/bocw.png');
        $emblem = ''; // Default to empty string
        if (file_exists($emblemPath)) {
            $type = pathinfo($emblemPath, PATHINFO_EXTENSION);
            $data = file_get_contents($emblemPath);
            $emblem = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            Log::error("Emblem file not found for PDF generation at: " . $emblemPath);
        }

        $nominee_id = NomineeRegistration::where('family_id',$nomineeDetail->family_id)->where('nomine_id',"!=",null)->exists();
        if($nominee_id){
            $nominee_detail = NomineeRegistration::where('family_id',$nomineeDetail->family_id)->first();
        }else{
            $nominee_detail = null;
        }
        $familyDetail = MainWorkerFamily::find($nomineeDetail->family_id);
        $vaultData = $this->getVaultDataService->getVaultData($nomineeDetail->worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);
        $familyVaultData = $this->getVaultDataService->getFamilyVaultData($nomineeDetail->family_id);
        $applicantVaultDetails = json_decode($familyVaultData->getData(), true);

        // 5. Render the new Blade view
        $html = view('worker.benefits.nominee.ekyc-acknowledgement', compact(
            'nominee_detail',
            'familyDetail',
            'wmf',
            'getVaultData',
            'applicantVaultDetails',
            'emblem'
        ))->render();

        $fileName = 'KYC-Acknowledgment-' . $wmf->id_card . '.pdf';

        // 6. Generate and stream the PDF
        $pdfContent = Pdf::loadHTML($html)->output();

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }


    public function checkIdCard(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id_card' => 'required'
            ]
        );

        if (($validator->fails())) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $dataExist = MainWorkerForm::where('id_card', $request->id_card)->exists();
        if ($dataExist) {
            $data['mainWorkerData'] = MainWorkerForm::select('worker_id', 'phone_no', 'district', 'office_id', 'id_card')->where('id_card', $request->id_card)->first();
            $data['families'] = MainWorkerFamily::where('worker_id', $data['mainWorkerData']->worker_id)->where('is_nominee_registered',false)->get();
            $vaultData = $this->getVaultDataService->getVaultData($data['mainWorkerData']->worker_id, "F");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            return response()->json([
                'status' => true,
                'results' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'results' => "No data found!"
            ]);
        }
    }
}
