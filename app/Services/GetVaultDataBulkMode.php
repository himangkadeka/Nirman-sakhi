<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 21-07-2025
 * Time: 15:37
 */

namespace App\Services;
use App\Http\Controllers\SecurityController;
use App\Models\KeyValue;
use App\Models\MainWorkerForm;
use App\Models\TemporaryWorkerForm;
use App\Models\VaultData;
use Database\Seeders\KeyValueSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GetVaultDataBulkMode
{
    private $securityController;
    private $agencyCode;
    private $secretKey;

    public function __construct(SecurityController $securityController)
    {
        $this->securityController = $securityController;
        $this->agencyCode = env('AGENCY_CODE', '');

        $licenceKeyEnc = DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->value('value');
        $salt = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->value('value');
        $this->secretKey = $this->securityController->decrypt($licenceKeyEnc, $salt);
    }

    /**
     * Fetch and decrypt vault data for multiple workers.
     *
     * @param array $workerIds
     * @return array
     */
    public function getBulkVaultData(array $workerIds): array
    {
        $decryptedVaultData = [];

        // 1. Fetch existing vault data from DB
        $existingVaultData = VaultData::whereIn('worker_id', $workerIds)
            ->whereNotNull('enc_data')
            ->pluck('enc_data', 'worker_id');

        foreach ($existingVaultData as $workerId => $encData) {
            $decryptedJson = AesCipher::decrypt($this->secretKey, $encData);
            $decryptedVaultData[$workerId] = json_decode($decryptedJson, true);
        }

        // 2. Determine which workers need an API call
        $workersForApiCall = array_diff($workerIds, $existingVaultData->keys()->all());

        if (!empty($workersForApiCall)) {
            $postDataForApi = $this->prepareBulkApiData($workersForApiCall);

            if (!empty($postDataForApi)) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post(
                    'https://aua.assam.gov.in/ditecapi/v2/php/get-vault-data',
                    ['requests' => $postDataForApi]
                );

                if ($response->ok()) {
                    $bulkResponseData = $response->json();

                    if (!is_array($bulkResponseData)) {
                        // Decode in case response is string
                        $bulkResponseData = json_decode($response->body(), true) ?? [];
                    }

                    foreach ($bulkResponseData as $workerResponse) {
                        if (is_array($workerResponse) && isset($workerResponse['workerId'], $workerResponse['encResponseData'])) {
                            $workerId = $workerResponse['workerId'];
                            $encResponseData = $workerResponse['encResponseData'];
                            $decryptedJson = AesCipher::decrypt($this->secretKey, $encResponseData);
                            $decryptedVaultData[$workerId] = json_decode($decryptedJson, true);
                        } else {
                            \Log::warning('Unexpected API workerResponse format: ', ['response' => $workerResponse]);
                        }
                    }
                } else {
                    \Log::error('Vault API call failed', ['status' => $response->status(), 'body' => $response->body()]);
                }
            }
        }

        return $decryptedVaultData;
    }

    /**
     * Prepare payload for vault API in bulk.
     *
     * @param array $workerIds
     * @return array
     */
    private function prepareBulkApiData(array $workerIds): array
    {
        $apiRequests = [];

        $mainWorkerData = MainWorkerForm::whereIn('worker_id', $workerIds)->get()->keyBy('worker_id');
        $tempWorkerData = TemporaryWorkerForm::whereIn('worker_id', $workerIds)->get()->keyBy('worker_id');

        $key1 = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->value('value');
        $licenceKeyEnc = DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->value('value');
        $salt = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->value('value');
        $licenceKey = $this->securityController->decrypt($licenceKeyEnc, $salt);

        foreach ($workerIds as $workerId) {
            $data = $mainWorkerData->get($workerId) ?? $tempWorkerData->get($workerId);

            if ($data && isset($data->vaultToken, $data->vaultPassKey)) {
                $vaultToken = $this->securityController->decrypt($data->vaultToken, $key1);
                $vaultPass = $this->securityController->decrypt($data->vaultPassKey, $key1);

                $payload = json_encode([
                    'vaultToken' => $vaultToken,
                    'vaultPassKey' => $vaultPass
                ]);

                $encrypted = AesCipher::encrypt($licenceKey, $payload);

                $apiRequests[] = [
                    'encData' => $encrypted->getData(),
                    'transactionId' => substr(md5(uniqid(mt_rand(), true)), 0, 23),
                    'agencyCode' => $this->agencyCode,
                    'workerId' => $workerId,
                ];
            }
        }

        return $apiRequests;
    }

}