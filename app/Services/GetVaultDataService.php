<?php


namespace App\Services;

use App\Http\Controllers\SecurityController;
use App\Models\KeyValue;
use App\Models\MainWorkerFamily;
use App\Models\MainWorkerForm;
use App\Models\TemporaryWorkerForm;
use App\Models\VaultData;
use Database\Seeders\KeyValueSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VaultAccessLog;
use App\Services\VaultAuditService;
use Illuminate\Support\Facades\Log;

class GetVaultDataService
{
    protected $vaultAuditService;

    public function __construct(VaultAuditService $vaultAuditService)
    {
        $this->vaultAuditService = $vaultAuditService;
    }

    public function getVaultData($worker_id, $worker_status)
    {


        $transactionId = substr(md5(uniqid(mt_rand(), true)), 0, 23);
        $agencyCode = env('AGENCY_CODE');
        $securityController = new SecurityController();
        $licenceKeyEnc =  DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->first()->value;
        $key =  DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
        $secretkey = $securityController->decrypt($licenceKeyEnc, $key);
        $encryptedData = $this->vaultEnc($worker_id, $worker_status);
        if (empty($encryptedData)) {
            Log::channel('audit-log')->warning("Vault execution aborted. Local structural data or Aadhaar identifiers missing for Worker ID: {$worker_id}");

            // Return a structured JSON response that your previewRenewal method can intercept
            return response()->json([
                'response' => 'VALIDATION',
                'message'  => 'Missing critical identity documentation records in the database.'
            ]);
        }

        $encData = VaultData::where('worker_id', $worker_id)->whereNotNull('enc_data')->exists();

        if ($encData) {
            // return 'dd';

            $encData1 = VaultData::where('worker_id', $worker_id)->first()->enc_data;
            $encResponseData = $encData1;
            $this->vaultAuditService->log(
                'VIEW_VAULT_DATA',
                $worker_id,
                null,
                'CACHE',
                request()->path(),
                $transactionId
            );
            Log::channel('audit-log')->info('Vault Access', [
                'worker_id'      => $worker_id,
                'user_id'        => auth()->id(),
                'action'         => 'VIEW_VAULT_DATA',
                'transaction_id' => $transactionId,
                'ip_address'     => request()->ip(),
                'session_id'     => session()->getId(),
            ]);
            return AesCipher::decrypt($secretkey, $encResponseData);
        } else {

            $postData =
                [
                    'encData' => $encryptedData,
                    'transactionId' => $transactionId,
                    'agencyCode' => $agencyCode,
                ];

            $url = "https://aua.assam.gov.in/ditecapi/v2/php/get-vault-data";

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json', // Set Content-Type header
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);

                return response()->json(['error' => 'Failed to send post request', 'message' => $error]);
            }

            curl_close($ch);
            $vaultData = json_decode($response, true);
            $encResponseData = $vaultData['encResponseData'];
            $this->vaultAuditService->log(
                'VIEW_VAULT_DATA',
                $worker_id,
                null,
                'CACHE',
                request()->path(),
                $transactionId
            );
            Log::channel('audit-log')->info('Vault Access', [
                'worker_id'      => $worker_id,
                'user_id'        => auth()->id(),
                'action'         => 'VIEW_VAULT_DATA',
                'transaction_id' => $transactionId,
                'ip_address'     => request()->ip(),
                'session_id'     => session()->getId(),
            ]);
            return AesCipher::decrypt($secretkey, $encResponseData);
        }
    }


    public function vaultEnc($worker_id, $worker_status)
    {


        if ($worker_status !== 'T') {
            $data = MainWorkerForm::where('worker_id', $worker_id)->first();
            if (!$data) {
                $data = TemporaryWorkerForm::where('worker_id', $worker_id)->first();
            }
        } else {
            $data = TemporaryWorkerForm::where('worker_id', $worker_id)->first();
            if (!$data) {
                $data = MainWorkerForm::where('worker_id', $worker_id)->first();
            }
        }
        if ($data) {
            $securityController = new SecurityController();
            $key1 = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->first()->value;
            $vaultToken = $securityController->decrypt($data->vaultToken, $key1);
            $vaultPass = $securityController->decrypt($data->vaultPassKey, $key1);

            $string = '{"vaultToken":"' . $vaultToken . '","vaultPassKey":"' . $vaultPass . '"}';
            $key = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
            $licenceKeyEnc = KeyValue::where('key', 'LICENSE_KEY')->first()->value;
            $licenceKey = $securityController->decrypt($licenceKeyEnc, $key);

            $encrypted = AesCipher::encrypt($licenceKey, $string);
            return $encrypted->getData();
        }
        return null;
    }


    public function getFamilyVaultData($family_id){
        $transactionId = substr(md5(uniqid(mt_rand(), true)), 0, 23);
        $agencyCode = env('AGENCY_CODE');
        $securityController = new SecurityController();
        $licenceKeyEnc =  DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->first()->value;
        $key =  DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
        $secretkey = $securityController->decrypt($licenceKeyEnc, $key);
        $encryptedData = $this->FamilyVaultEnc($family_id);
// return $encryptedData;
        // $encData = VaultData::where('worker_id', $worker_id)->whereNotNull('enc_data')->exists();

        $postData =
                [
                    'encData' => $encryptedData,
                    'transactionId' => $transactionId,
                    'agencyCode' => $agencyCode,
                ];

            $url = "https://aua.assam.gov.in/ditecapi/v2/php/get-vault-data";

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json', // Set Content-Type header
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);

                return response()->json(['error' => 'Failed to send post request', 'message' => $error]);
            }

            curl_close($ch);
            $vaultData = json_decode($response, true);
            // return $secretkey;
            $encResponseData = $vaultData['encResponseData'];
        Log::channel('audit-log')->info('Vault Access', [
            'family_id'      => $family_id,
            'user_id'        => auth()->id(),
            'action'         => 'VIEW_VAULT_DATA',
            'transaction_id' => $transactionId,
            'ip_address'     => request()->ip(),
            'session_id'     => session()->getId(),
        ]);
            return AesCipher::decrypt($secretkey, $encResponseData);
    }



    public function FamilyVaultEnc($family_id){
        $data = MainWorkerFamily::find($family_id);

        if ($data) {
            $securityController = new SecurityController();
            $key1 = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->first()->value;
            // $vaultToken = $securityController->decrypt($data->vault_data, $key1);
            // $vaultPass = $securityController->decrypt($data->vault_pass_key, $key1);
            $vaultToken = $data->vault_data;
            $vaultPass = $data->vault_pass_key;
// return $vaultToken;
            $string = '{"vaultToken":"' . $vaultToken . '","vaultPassKey":"' . $vaultPass . '"}';
            $key = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
            $licenceKeyEnc = KeyValue::where('key', 'LICENSE_KEY')->first()->value;
            $licenceKey = $securityController->decrypt($licenceKeyEnc, $key);

            $encrypted = AesCipher::encrypt($licenceKey, $string);
            return $encrypted->getData();
        }
        return null;
    }
}
