<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\JwtToken;
use App\Services\Cipher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\ApiLog;
use Illuminate\Support\Facades\Log;

class eShramController extends Controller
{
    protected $cipher;
    public function __construct(Cipher $cipher)
    {
        $this->cipher = $cipher;
    }
    public function encryptData( Cipher $cipher)
    {
        $userName = 'anamika.acs@assam.gov.in';
        $password = 'anamika@8765!&*acs';
        $dataToEncrypt = [
            'email' => $userName,
            'pwd' => $password,
        ];


        $jsonDataToEncrypt = json_encode($dataToEncrypt);

        $encryptedRequest = $cipher->encrypt($jsonDataToEncrypt,'ikjnbvd!@#$%^iojkEFV087xyuikk7',530819052);



        if (!$encryptedRequest) {
            return response()->json(['error' => 'Encryption failed'], 400);
        }

        return response()->json(['encRequest' => $encryptedRequest]);
    }


    public function generateAuthToken(Cipher $cipher)
    {
        DB::beginTransaction();
        try {
            $existingToken = JwtToken::lockForUpdate()->first();

            if ($existingToken && Carbon::now()->lt($existingToken->expires_at)) {
                DB::commit();
                return response()->json(['jwtToken' => $existingToken->token]);
            }

            $encryptResponse = $this->encryptData($cipher);
            if ($encryptResponse->status() !== 200) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to encrypt data'], 400);
            }

            $responseData = $encryptResponse->getData(true);
            $encryptedRequest = $responseData['encRequest'] ?? null;

            if (!$encryptedRequest) {
                DB::rollBack();
                return response()->json(['error' => 'Encrypted data not found'], 400);
            }

            $headers = [
                'Ocp-Apim-Subscription-Key: a6c5ff7810b04f1db6a8c71bf298fdd3',
                'Origin: https://register.eshram.gov.in',
                'Referer: https://register.eshram.gov.in/',
                'Content-Type: application/json',
            ];

            $data = ['encRequest' => $encryptedRequest];

            $ch = curl_init('https://registerapi.eshram.gov.in/externalscheme-service/api/v1/generateAuthToken/');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                DB::rollBack();
                return response()->json(['error' => curl_error($ch)], 400);
            }

            curl_close($ch);

            $response_data = json_decode($response, true);

            if (isset($response_data['jwtToken'])) {
                $jwtToken = $response_data['jwtToken'];
                $expiryTime = isset($response_data['expires_in'])
                    ? Carbon::now()->addSeconds($response_data['expires_in'])
                    : Carbon::now()->addMinutes(60);

                JwtToken::updateOrCreate([], [
                    'token' => $jwtToken,
                    'expires_at' => $expiryTime
                ]);

                // 🟢 Store the token in cache
                Cache::put('jwt_token', $jwtToken, $expiryTime);

                DB::commit();
                return response()->json(['jwtToken' => $jwtToken]);
            }

            DB::rollBack();
            return response()->json(['error' => 'Failed to get auth token'], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    public function getValidJwtToken(Cipher $cipher)
    {
        return Cache::remember('jwt_token', 3600, function () use ($cipher) {
            return $this->generateAuthToken($cipher)->getData(true)['jwtToken'] ?? null;
        });
    }



    public function encryptUan(Request $request, Cipher $cipher)
    {

        $encryptData = [
            'uanNo' => $request->input('uanNo'),
//            'dob'   => date('Y', strtotime($request->input('dob'))),
            'dob'   => $request->input('dob'),
            'name' => $request->input('name'),
        ];

        $jsonDataToEncryptUan = json_encode($encryptData);

        $encryptedDataUan = $cipher->encrypt($jsonDataToEncryptUan, 'ikjnbvd!@#$%^iojkEFV087xyuikk7',530819052);


        if (!$encryptedDataUan) {
            return response()->json(['error' => 'Encryption failed'], 400);
        }

        return response()->json(['encRequest' => $encryptedDataUan]);

    }


//
//    public function validateUan(Request $request, Cipher $cipher)
//    {
//        $jwtToken = $this->getValidJwtToken($cipher);
//
//        if (!$jwtToken) {
//            return response()->json(['error' => 'Auth token not available'], 400);
//        }
//
//        $encRequest = $request->input('encRequest');
//        if (!$encRequest) {
//            return response()->json(['error' => 'Encrypted data not found'], 400);
//        }
//
//        $url = 'https://registerapi.eshram.gov.in/externalscheme-service/api/v1/validateUserByUanAndDob/';
//        $headers = [
//            'Ocp-Apim-Subscription-Key: a6c5ff7810b04f1db6a8c71bf298fdd3',
//            'Origin: https://register.eshram.gov.in',
//            'Referer: https://register.eshram.gov.in/',
//            'Content-Type: application/json',
//            'X-User-INFO: anamika.acs@assam.gov.in',
//            'Authorization: ' . $jwtToken,
//        ];
//
//        $data = ['encRequest' => $encRequest];
//
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//
//        $response = curl_exec($ch);
//
//        if (curl_errno($ch)) {
//            $error_msg = curl_error($ch);
//            curl_close($ch);
//            return response()->json(['error' => $error_msg], 400);
//        }
//
//        curl_close($ch);
//
//        $response_data = json_decode($response, true);
//        return response()->json($response_data);
//    }

    public function validateUan(Request $request, Cipher $cipher)
    {
        try {
            $jwtToken = $this->getValidJwtToken($cipher);

            if (!$jwtToken) {
                ApiLog::create([
                    'endpoint' => 'validateUan',
//                    'uan_no' => $request->input('uanNo'),
                    'payload' => json_encode($request->all()),
                    'status' => 'error',
                    'error_message' => 'Auth token not available',
                ]);
                return response()->json(['error' => 'Auth token not available'], 400);
            }

            $encRequest = $request->input('encRequest');
            if (!$encRequest) {
                ApiLog::create([
                    'endpoint' => 'validateUan',
//                    'uan_no' => $request->input('uanNo'),
                    'payload' => json_encode($request->all()),
                    'status' => 'error',
                    'error_message' => 'Encrypted data not found',
                ]);
                return response()->json(['error' => 'Encrypted data not found'], 400);
            }

            $data = ['encRequest' => $encRequest];
            $url = 'https://registerapi.eshram.gov.in/externalscheme-service/api/v1/validateUserByUanAndDob/';
            $headers = [
                'Ocp-Apim-Subscription-Key: a6c5ff7810b04f1db6a8c71bf298fdd3',
                'Origin: https://register.eshram.gov.in',
                'Referer: https://register.eshram.gov.in/',
                'Content-Type: application/json',
                'X-User-INFO: anamika.acs@assam.gov.in',
                'Authorization: ' . $jwtToken,
            ];

            Log::info('Sending validateUan request', [
                'payload' => $data,
            ]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                curl_close($ch);

                ApiLog::create([
                    'endpoint' => 'validateUan',
//                    'uan_no' => $request->input('uanNo'),
                    'payload' => json_encode($data),
                    'status' => 'error',
                    'error_message' => $error_msg,
                ]);

                return response()->json(['error' => $error_msg], 400);
            }

            curl_close($ch);
            $response_data = json_decode($response, true);

            ApiLog::create([
                'endpoint' => 'validateUan',
                'uan_no' => $request->input('uanNo'),
                'payload' => json_encode($data),
                'response' => json_encode($response_data),
                'status' => $response_data['status'] ?? 'unknown',
            ]);

            return response()->json($response_data);
        } catch (\Exception $e) {
            ApiLog::create([
                'endpoint' => 'validateUan',
//                'uan_no' => $request->input('uanNo'),
                'payload' => json_encode($request->all()),
                'status' => 'error',
                'error_message' => $e->getMessage(),
            ]);

            Log::error('Exception in validateUan: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
}