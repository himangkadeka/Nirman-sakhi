<?php

namespace App\Services;

use App\Services\AesCipher; // Import your existing class
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class DitecService
{
    protected $baseUrl;
    protected $agencyCode;
    protected $licenseKey;
    protected $password;
    protected $subAuaPin;

    // PDF Page 5: Language code for PHP is 'l3'
    protected $languageCode = 'l3';

    public function __construct()
    {
        $this->baseUrl = config('services.ditec.base_url');
        $this->agencyCode = config('services.ditec.agency_code');
        $this->licenseKey = config('services.ditec.license_key');
        $this->password = config('services.ditec.password');
        $this->subAuaPin = config('services.ditec.sub_aua_pin');
    }

    /**
     * Authenticate and get JWT Token
     * Ref: PDF Page 6
     */
    public function getAccessToken()
    {
        // Cache token to avoid frequent auth calls
        // return Cache::remember('ditec_token', 1200, function () {
        $url = "{$this->baseUrl}/api/v1/auth/authenticate";

        $response = Http::post($url, [
            'username' => $this->agencyCode,
            'password' => $this->password,
        ]);
        //  $json = $response->json();

        if ($response->successful()) {
            // dd($response->json());

            // return $response->token() ?? null;
            $res = json_decode($response, true);

            $data = $res['token'];

            return $data;
            //  return $json['token']->data;
        }

        throw new Exception('DITEC Auth Failed: ' . $response->body());
        // }
        // );
    }

    /**
     * Send Bulk Vault Data
     * Ref: PDF Page 6 - 4.2 Bulk Vault Data
     */
    // public function sendBulkVaultData(array $userDataItems)
    // {
    //     $token = $this->getAccessToken();
    //     // return $token;
    //     // URL Construction: {baseapi}/{languagecode}/vault/bulk-vault
    //     $url = "{$this->baseUrl}/v2/{$this->languageCode}/vault/bulk-vault";

    //     $requestBody = [];

    //     foreach ($userDataItems as $item) {
    //         $txnId = $this->generateTransactionId();
    //         $item['transactionId'] = $txnId;
    //         $jsonString = json_encode($item);

    //         $encryptedObject = AesCipher::encrypt($this->licenseKey, $jsonString);

    //         if ($encryptedObject->hasError()) {
    //             throw new Exception("Encryption Failed: " . $encryptedObject->getErrorMessage());
    //         }


    //         $requestBody[] = [
    //             'encData'       => $encryptedObject->getData(), // Get base64 string
    //             'agencyCode'    => $this->agencyCode,
    //             'transactionId' => $txnId
    //         ];
    //     }

    //     // 5. Send Request
    //     $response = Http::withToken($token)
    //         ->post($url, $requestBody);

    //     if ($response->successful()) {
    //         return $response->json();
    //     }

    //     Log::error('DITEC API Error', ['body' => $response->body()]);

    //     return [
    //         'error' => true,
    //         'status' => $response->status(),
    //         'message' => $response->body()
    //     ];
    // }
    public function sendBulkVaultData(array $userDataItems)
    {
        $token = $this->getAccessToken();
        $url = "{$this->baseUrl}/v2/{$this->languageCode}/vault/bulk-vault";

        $requestBody = [];
        $txnToWorkerMap = [];

        foreach ($userDataItems as $item) {
            $txnId = $this->generateTransactionId();

            // Save mapping: Which TxnID belongs to which WorkerID
            $txnToWorkerMap[$txnId] = $item['worker_id'];

            $workerId = $item['worker_id'];
            unset($item['worker_id']); // Remove it before sending to API

            $jsonString = json_encode($item);
            $encryptedObject = AesCipher::encrypt($this->licenseKey, $jsonString);

            if ($encryptedObject->hasError()) {
                throw new \Exception("Encryption Failed: " . $encryptedObject->getErrorMessage());
            }

            $requestBody[] = [
                'encData'       => $encryptedObject->getData(),
                'agencyCode'    => $this->agencyCode,
                'transactionId' => $txnId
            ];
        }

          $response = Http::withToken($token)->post($url, $requestBody);

        if ($response->successful()) {
            return [
                'api_response' => $response->json(), // This is the array you provided
                'mapping' => $txnToWorkerMap
            ];
        }

        throw new \Exception('DITEC API Error: ' . $response->body());
    }


    /**
     * Helper: Generate 16-digit Transaction ID
     * Format: [SUB_AUA_PIN][RANDOM_CHARS]
     */
    private function generateTransactionId()
    {
        $prefix = $this->subAuaPin; // e.g., DIFI
        $requiredLength = 16;
        $randomLength = $requiredLength - strlen($prefix);

        // Generate random numeric suffix (or alphanumeric if allowed)
        $suffix = '';
        for ($i = 0; $i < $randomLength; $i++) {
            $suffix .= mt_rand(0, 9);
        }

        return $prefix . $suffix;
    }

    /**
     * Decrypt the specific encResponseData field
     */
    public function decryptResponse($encryptedString)
    {
        // If it is the plain text error message, return as is
        if ($encryptedString === "Vault Data Not Exist.") {
            return $encryptedString;
        }

        $decryptedObject = AesCipher::decrypt($this->licenseKey, $encryptedString);

        if ($decryptedObject->hasError()) {
            return "Decryption Error: " . $decryptedObject->getErrorMessage();
        }

        return $decryptedObject->getData();
    }
}
