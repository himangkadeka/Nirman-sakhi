<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Auth\LogController;
use App\Models\aadharOtpModel;
use App\Models\RevertBack;
use App\Models\TemporaryWorkerForm;
use App\Services\AesCipher;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\AadharOtpLog;
use App\Models\OtpVerificationCode;
use App\Models\User;
use App\Models\UserLoginOtp;
use App\Models\WorkerLoginOtp;
use App\Models\WorkerModel;
use App\Services\SmsGatewayService;
use Carbon\Carbon;
use Database\Seeders\KeyValueSeeder;
use Illuminate\Http\Request;
use Illuminate\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class  AuthOtpController extends Controller
{



    protected $smsService;
    public function __construct(SmsGatewayService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function generate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'worker_id' => 'required|exists:pgsql.User.users,username',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        } else {
            $worker_mobile = User::where('username', $request->worker_id)->first()->phone;
            $lastFour = 'XXXXXX' . substr($worker_mobile, -4);
            $otp =  $this->generateOtp($request->worker_id);
            $this->smsService->loginOtpSMS($worker_mobile, $otp->otp);

            return response()->json([
                'status' => true,
                'message' => "OTP sent to the Mobile Number " . $lastFour . "! Your OTP will be valid for 5 minutes.",
                'time_minutes' => 5,
                'otp' => $otp->otp
            ]);
        }
    }

    public function genOTP(Request $request)
    {
        // 1. Validate the input
        $validator = Validator::make(
            $request->all(),
            [
                'mobile' => 'required|regex:/^[0-9]{10}$/'
            ]
        );

        // If validation fails, return early
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }

        $worker_mobile = $request->mobile;
        $lastFour = 'XXXXXX' . substr($worker_mobile, -4);

        $tempPhone = TemporaryWorkerForm::where('phone_no', $worker_mobile)->latest()->first();

        // 2. If phone exists, send OTP and return success
        if ($tempPhone) {
            $otp = $this->generateOtpWorker($worker_mobile);
            $this->smsService->loginOtpSMS($worker_mobile, $otp->otp);

            return response()->json([
                'status' => true,
                'message' => "OTP sent to the Mobile Number " . $lastFour . "! Your OTP will be valid for 5 minutes.",
                'time_minutes' => 5,
            ]);
        }

        // 3. If phone does NOT exist, return error
        return response()->json([
            'status' => false,
            'message' => "Mobile Number not available",
        ]);
    }

    //validate phone

    public function genOTPNew(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'mobile' => 'required|regex:/^[0-9]{10}$/'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        } else {
            $worker_mobile = $request->mobile;
            $lastFour = 'XXXXXX' . substr($worker_mobile, -4);
            $tempPhone = TemporaryWorkerForm::where('phone_no', $worker_mobile)->latest()->first();
            if ($worker_mobile) {
                $otp =  $this->generateOtpWorker($request->mobile);
                $this->smsService->loginOtpSMS($worker_mobile, $otp->otp);

                return response()->json([
                    'status' => true,
                    'message' => "OTP sent to the Mobile Number " . $lastFour . "! Your OTP will be valid for 2 minutes.",
                    'time_minutes' => 5,

                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Mobile Number not available",
                ]);
            }
        }
    }


    public function generateOtpWorker($worker_mobile)
    {
        $user_otp = UserLoginOtp::where('user_id', $worker_mobile)->latest()->first();
        $now = now();

        if ($user_otp && $now->isBefore($user_otp->expire_at)) {
            return $user_otp;
        }

        return UserLoginOtp::create([
            'user_id' => $worker_mobile,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(5)
        ]);
    }
    public function generateOtpWorkerNew($worker_mobile)
    {
        $user_otp = UserLoginOtp::where('user_id', $worker_mobile)->latest()->first();
        $now = now();

        if ($user_otp && $now->isBefore($user_otp->expire_at)) {
            return $user_otp;
        }

        return UserLoginOtp::create([
            'user_id' => $worker_mobile,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(5)
        ]);
    }

    public function otpVerificationWorker(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $submittedOtp = $request->input('otp');
        $mobileNumber = $request->input('mobile');
        $userOtp = UserLoginOtp::where('user_id', $mobileNumber)
            ->latest('created_at')
            ->first();


        if (!$userOtp) {
            // No OTP record found for the user
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired or was not generated. Please try again.',
            ], 400);
        }

        if ($userOtp->otp === $submittedOtp) {
            // OTP is valid
            // Optionally delete the record or mark it as used
            //            $userOtp->delete(); // Optional: remove the OTP record

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully!',
            ], 200);
        }

        // OTP is invalid
        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP. Please try again.',
        ], 400);
    }

    public function genRevertOtp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'worker_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        } else {
            $worker_id = $request->worker_id;
            $tempPhone = RevertBack::where('worker_id', $worker_id)->value('phone_no');
            $lastFour = 'XXXXXX' . substr($tempPhone, -4);
            if ($tempPhone) {
                $otp =  $this->generateOtpWorkerRevert($worker_id);
                $this->smsService->loginOtpSMS($tempPhone, $otp->otp);

                return response()->json([
                    'status' => true,
                    'message' => "OTP sent to the Mobile Number " . $lastFour . "! Your OTP will be valid for 5 minutes.",
                    'time_minutes' => 5,

                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Mobile Number not available",
                ]);
            }
        }
    }
    public function generateOtpWorkerRevert($tempPhone)
    {
        $user_otp = UserLoginOtp::where('user_id', $tempPhone)->latest()->first();
        $now = now();

        if ($user_otp && $now->isBefore($user_otp->expire_at)) {
            return $user_otp;
        }

        return UserLoginOtp::create([
            'user_id' => $tempPhone,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(5)
        ]);
    }

    public function otpVerificationRevert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_id' => 'required',
            'otp' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => "Invalid request!"]);
        }

        $worker_id = $request->worker_id;
        $enteredOtp = $request->otp;

        $userOtp = UserLoginOtp::where('user_id', $worker_id)
            ->where('otp', $enteredOtp)
            ->where('expire_at', '>', now())
            ->first();

        if ($userOtp) {
            session()->put('worker_id', $worker_id);
            //            $userOtp->delete(); // OTP used, remove from DB
            return response()->json([
                'success' => true,
                'message' => "OTP verified successfully.",
                //                'already_registered_status' => $this->checkWorkerStatus($worker_id) // Check status dynamically
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid or expired OTP!']);
        }
    }


    public function generateOtp($user_id)
    {
        $user = User::where('username', $user_id)->first();
        $user_otp = UserLoginOtp::where('user_id', $user->username)->latest()->first();
        $now = now();

        if ($user_otp && $now->isBefore($user_otp->expire_at)) {
            return $user_otp;
        }

        return UserLoginOtp::create([
            'user_id' => $user->username,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(5)
        ]);
    }

    public function generateAadharOtp(Request $request)
    {
        $uid = $request->input('uid');
        $nonceValue = session()->get('nonce_value');
        $securityController = new SecurityController();
        $decryptedUid = $securityController->decrypt($uid, $nonceValue);
        $request->session()->put('uid', $uid);
        $encryptedData = $this->otpgenerationEnc($decryptedUid);
        $transactionId = substr(md5(uniqid(mt_rand(), true)), 0, 23);
        $request->session()->put('transactionId', $transactionId);
        $agencyCode = env('AGENCY_CODE');


        $postData = [
            'encData' => $encryptedData,
            'transactionId' => $transactionId,
            'agencyCode' => $agencyCode,
        ];

        // return $postData;

        $url = "https://aua.assam.gov.in/ditecapi/v2/php/otp-generation";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json', // Set Content-Type header
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute cURL session
        $response = curl_exec($ch);



        if ($response === false) {
            $error = curl_error($ch);

            return response()->json(['error' => 'Failed to send post request', 'message' => $error]);
        }
        // Close cURL session
        curl_close($ch);

        $responseData = json_decode($response, true);


        if (isset($responseData['code']) && $responseData['code'] == '2000' || $responseData == null) {

            $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error has occurred.';

            return response()->json(['error' => $errorMessage]);
        }

        $request->session()->put('otpGenTxn', $responseData['otptrxId']);
        $request->session()->put('transactionId', $responseData['transactionId']);

        AadharOtpLog::create([
            'errorCode' => $responseData['errorCode'],
            'mobile' => $responseData['mobile'],
            'status' => $responseData['status'],
            'errorDescription' => $responseData['errorDescription'],
            'transaction_id' => $responseData['transactionId'],
            'ip' => $request->ip(),
        ]);
        return response()->json($responseData);
    }

    public function otpgenerationEnc($uid)
    {
        $string = '{"uid":"' . $uid . '","channel":"01"}';
        $securityController = new SecurityController();
        $licenceKeyEnc = DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->first()->value;
        $key = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
        $licenceKey = $securityController->decrypt($licenceKeyEnc, $key);
        $encrypted = AesCipher::encrypt($licenceKey, $string);
        return $encrypted->getData();
    }

    public function ekycEnc($dynamicPin)
    {
        $uid = Session::get('uid');
        $nonceValue = session()->get('nonce_value');
        $securityController = new SecurityController();
        $decryptedUid = $securityController->decrypt($uid, $nonceValue);

        $otpGenTxn = Session::get('otpGenTxn');

        if (!$uid) {

            return response()->json(['error' => 'UID not found in session']);
        }
        $string = '{"uid":"' . $decryptedUid . '","dynamicPin":"' . $dynamicPin . '","otpGenTxn": "' . $otpGenTxn . '"}';
        $securityController = new SecurityController();
        $licenceKeyEnc = DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->first()->value;
        $key = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;

        $licenceKey = $securityController->decrypt($licenceKeyEnc, $key);
        $encrypted = AesCipher::encrypt($licenceKey, $string);
        return $encrypted->getData();
    }



    public function ekycAadhaar(Request $request)
    {

        $transactionId = substr(md5(uniqid(mt_rand(), true)), 0, 23);
        $dynamicPin = $request->input('dynamicPin');
        $consent = $request->input('consent');
        $encryptedData = $this->ekycEnc($dynamicPin);
        $agencyCode = env('AGENCY_CODE');

        $postData = [
            'encData' => $encryptedData,
            'transactionId' => $transactionId,
            'agencyCode' => $agencyCode,
            'ekycStatus' => 'y',
            'citizenConsent' => $consent,
        ];

        $url = "https://aua.assam.gov.in/ditecapi/v2/php/authentication-otp";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json', // Set Content-Type header
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute cURL session
        $response = curl_exec($ch);


        if ($response === false) {
            $error = curl_error($ch);

            return response()->json(['error' => 'Failed to send post request', 'message' => $error]);
        }

        curl_close($ch);
        $responseData = json_decode($response, true);

        if (isset($responseData['code']) && $responseData['code'] == '2000') {

            $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error has occurred.';

            return response()->json(['error' => $errorMessage]);
        }


        session()->put('uid_data', json_encode($responseData));
        return response()->json($responseData);
    }


    public function ekycAadhaarWithDecrypt(Request $request)
    {

        $transactionId = substr(md5(uniqid(mt_rand(), true)), 0, 23);
        $dynamicPin = $request->input('dynamicPin');
        $consent = $request->input('consent');
        $encryptedData = $this->ekycEnc($dynamicPin);
        $agencyCode = env('AGENCY_CODE');

        $postData = [
            'encData' => $encryptedData,
            'transactionId' => $transactionId,
            'agencyCode' => $agencyCode,
            'ekycStatus' => 'y',
            'citizenConsent' => $consent,
        ];

        $url = "https://aua.assam.gov.in/ditecapi/v2/php/authentication-otp";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json', // Set Content-Type header
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute cURL session
        $response = curl_exec($ch);


        if ($response === false) {
            $error = curl_error($ch);

            return response()->json(['error' => 'Failed to send post request', 'message' => $error]);
        }

        curl_close($ch);
        $responseData = json_decode($response, true);

        if (isset($responseData['code']) && $responseData['code'] == '2000') {

            $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'An error has occurred.';

            return response()->json(['error' => $errorMessage]);
        }
        $securityController = new SecurityController();
        $licenceKeyEnc =  DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->first()->value;
        $key =  DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
        $secretkey = $securityController->decrypt($licenceKeyEnc, $key);

        $decryptedJsonString = AesCipher::decrypt($secretkey, $responseData['encResponseData']);
        $kycDetails = json_decode($decryptedJsonString);
        if (!$kycDetails) {
            return response()->json(['status' => 'error', 'message' => 'Failed to parse KYC data.'], 500);
        }
        $addressParts = [
            $kycDetails->careOf,
            $kycDetails->buildingName,
            $kycDetails->street,
            $kycDetails->locality,
            $kycDetails->subDistrict,
            $kycDetails->district,
            $kycDetails->state,
            $kycDetails->pinCode
        ];
        $fullAddress = implode(', ', array_filter($addressParts));

        $gender = 'UNKNOWN';
        if ($kycDetails->gender === 'M') {
            $gender = 'MALE';
        } elseif ($kycDetails->gender === 'F') {
            $gender = 'FEMALE';
        } elseif ($kycDetails->gender === 'T') {
            $gender = 'TRANSGENDER';
        }

        $finalResponse = [
            'status'        => $responseData['status'],
            'errorCode'     => $responseData['errorCode'],
            'errorMessage'  => $responseData['errorMessage'],
            'transactionID' => $responseData['transactionID'],
            'vaultToken'    => $responseData['vaultToken'],

            // Nest the clean, decrypted data in its own object for easy access
            'kycData' => [
                'photo'   => $kycDetails->photo,        // Base64 image string
                'name'    => $kycDetails->name,
                'dob'     => $kycDetails->dob,
                'gender'  => $gender,
                'address' => $fullAddress
            ]
        ];
        session()->put('uid_data', json_encode($responseData));
        return response()->json($finalResponse);
    }
}
