<?php

namespace App\Http\Controllers\Worker\Benefits;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\MainWorkerFamily;
use App\Services\AesCipher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FamilyAadhaarVerificationController extends Controller
{
    /**
     * Generate OTP for a family member's Aadhaar.
     * Adapted from AuthOtpController@generateAadharOtp
     */
    public function sendFamilyMemberOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid_enc' => 'required|string',
            'family_member_id' => 'required|exists:pgsql.Worker.main_worker_families,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        // We receive the already-encrypted UID from the frontend
        $uid = $request->input('uid_enc');
        $nonceValue = session()->get('nonce_value');

        // Decrypt to get the plain Aadhaar number for storage and re-encryption
        $securityController = new SecurityController();
        $decryptedUid = $securityController->decrypt($uid, $nonceValue);

        if (strlen($decryptedUid) !== 12) {
             return response()->json(['errorCode' => '998', 'message' => 'Invalid Aadhaar Number!']);
        }

        // Store necessary info in session for the next step
        $request->session()->put('family_kyc_uid_plain', $decryptedUid);
        $request->session()->put('family_kyc_uid_enc', $uid);
        $request->session()->put('family_kyc_member_id', $request->family_member_id);

        // Re-encrypt for the DITEC API
        $encryptedData = $this->otpgenerationEnc($decryptedUid);
        $transactionId = substr(md5(uniqid(mt_rand(), true)), 0, 23);
        $agencyCode = env('AGENCY_CODE');

        $postData = [
            'encData' => $encryptedData,
            'transactionId' => $transactionId,
            'agencyCode' => $agencyCode,
        ];

        // The cURL call to the Aadhaar API
        $response = $this->makeDitecApiCall("https://aua.assam.gov.in/ditecapi/v2/php/otp-generation", $postData);
        $responseData = json_decode($response, true);
// return $responseData;
        if (isset($responseData['code']) && $responseData['code'] == '2000' || $responseData == null) {
            $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error has occurred.';
            return response()->json(['error' => $errorMessage]);
        }

        // Save the transaction ID from the API response to the session
        $request->session()->put('family_kyc_otpGenTxn', $responseData['otptrxId']);

        return response()->json($responseData);
    }

    /**
     * Verify OTP and perform e-KYC for a family member.
     * Adapted from AuthOtpController@ekycAadhaarWithDecrypt
     */
    public function verifyFamilyMemberOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dynamicPin' => 'required|digits:6',
            'consent' => 'required|in:y,Y',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        $dynamicPin = $request->input('dynamicPin');
        $encryptedData = $this->ekycEnc($dynamicPin); // This helper function will use session data
        $agencyCode = env('AGENCY_CODE');
        $transactionId = substr(md5(uniqid(mt_rand(), true)), 0, 23);

        $postData = [
            'encData' => $encryptedData,
            'transactionId' => $transactionId,
            'agencyCode' => $agencyCode,
            'ekycStatus' => 'y',
            'citizenConsent' => $request->input('consent'),
        ];

        // The cURL call to the Aadhaar API
        $response = $this->makeDitecApiCall("https://aua.assam.gov.in/ditecapi/v2/php/authentication-otp", $postData);
        $responseData = json_decode($response, true);

        if (isset($responseData['code']) && $responseData['code'] == '2000' || !isset($responseData['encResponseData'])) {
            $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error has occurred.';
            return response()->json(['error' => $errorMessage, 'errorCode' => $responseData['errorCode'] ?? '999']);
        }

        // Decrypt the response from the API
        $securityController = new SecurityController();
        $licenceKeyEnc = DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->first()->value;
        $key = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
        $secretkey = $securityController->decrypt($licenceKeyEnc, $key);

        $decryptedJsonString = AesCipher::decrypt($secretkey, $responseData['encResponseData']);
        $kycDetails = json_decode($decryptedJsonString);

        if (!$kycDetails) {
            return response()->json(['status' => 'error', 'message' => 'Failed to parse KYC data.'], 500);
        }

        // Format the final clean response to send to the frontend
        $finalResponse = $this->formatKycResponse($responseData, $kycDetails);

        return response()->json($finalResponse);
    }

    /**
     * Save the verified details to the database.
     */
    public function saveKycDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vaultToken' => 'required|string',
            'vaultPassKey' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $familyMemberId = session('family_kyc_member_id');
        $aadhaarNo = session('family_kyc_uid_plain');

        if (!$familyMemberId || !$aadhaarNo) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please start over.'], 400);
        }

        $familyMember = MainWorkerFamily::findOrFail($familyMemberId);
        $familyMember->update([
            'is_aadhar_verified' => true,
            'vault_data' => $request->vaultToken, // Store the vault token
            'vault_pass_key' => $request->vaultPassKey,
            'aadhar_verified_at' => now()
        ]);

        // Clean up session data
        session()->forget(['family_kyc_uid_plain', 'family_kyc_uid_enc', 'family_kyc_member_id', 'family_kyc_otpGenTxn']);

        return response()->json(['success' => true, 'message' => 'Details saved. You can now proceed.']);
    }


    // --- HELPER METHODS ADAPTED FROM AuthOtpController ---

    private function otpgenerationEnc($uid)
    {
        $string = '{"uid":"' . $uid . '","channel":"01"}';
        $securityController = new SecurityController();
        $licenceKeyEnc = DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->first()->value;
        $key = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
        $licenceKey = $securityController->decrypt($licenceKeyEnc, $key);
        $encrypted = AesCipher::encrypt($licenceKey, $string);
        return $encrypted->getData();
    }

    private function ekycEnc($dynamicPin)
    {
        // This function now relies on session data set in the first step
        $uid = Session::get('family_kyc_uid_plain');
        $otpGenTxn = Session::get('family_kyc_otpGenTxn');

        if (!$uid || !$otpGenTxn) {
            throw new \Exception('Required KYC session data not found.');
        }

        $string = '{"uid":"' . $uid . '","dynamicPin":"' . $dynamicPin . '","otpGenTxn": "' . $otpGenTxn . '"}';
        $securityController = new SecurityController();
        $licenceKeyEnc = DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->first()->value;
        $key = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
        $licenceKey = $securityController->decrypt($licenceKeyEnc, $key);
        $encrypted = AesCipher::encrypt($licenceKey, $string);
        return $encrypted->getData();
    }

    private function makeDitecApiCall(string $url, array $postData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function formatKycResponse(array $responseData, $kycDetails)
    {
        $addressParts = [$kycDetails->careOf, $kycDetails->buildingName, $kycDetails->street, $kycDetails->locality, $kycDetails->subDistrict, $kycDetails->district, $kycDetails->state, $kycDetails->pinCode];
        $gender = match ($kycDetails->gender) { 'M' => 'MALE', 'F' => 'FEMALE', 'T' => 'TRANSGENDER', default => 'UNKNOWN' };

        return [
            'status' => $responseData['status'],
            'errorCode' => $responseData['errorCode'],
            'errorMessage' => $responseData['errorMessage'],
            'vaultToken' => $responseData['vaultToken'],
            'vaultPasskey' => $responseData['vaultPassKey'],
            'kycData' => [
                'photo'   => $kycDetails->photo,
                'name'    => $kycDetails->name,
                'dob'     => $kycDetails->dob,
                'gender'  => $gender,
                'address' => implode(', ', array_filter($addressParts))
            ]
        ];
    }
}
