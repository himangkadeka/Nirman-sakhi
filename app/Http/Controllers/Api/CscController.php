<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GetVaultDataService;

class CscController extends Controller
{
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService)
    {

        $this->getVaultDataService = $getVaultDataService;
    }

    public function registration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'data' => 'required'
        ]);

        $validator = Validator::make(
            $request->all(),
            [
                'data' => 'required'
            ]
        );


        if ($validator->fails()) {
            Alert::error($validator->errors()->first());
            return back();
        }
        $enc_data = $request->data;
        // $enc_data = "AMNRaPa38i5fz39donI93spWDO8N8PvZuLZRN6ptuJ1mfaSWxwgE1+xDPLE5pBAjYnXdQVPdtUVV7rf17FrfPxtjN4X/f6LyP0KDKrfVDS2VnRabO4ImlvjJS21OcN9pYCYepNsFLvr0nEYDNOAgMLnUrI5E6r5eg/GvErWeuvS2DmetFgm9StiFeBU6Otb4/nlM8ZE8HxCkEdD43ZoRGS9AB2FZ9r1q0w0AsH007ZaDK9uHO6Mar9RT+e2B1DQprCuDmL/152ZZR1icLJmIQBoJj6m7SufDr3mFPJdxmnGNnxD2PodaT6VJKfUs/SpBs0I/Ad/QmiY1eOohsdfmS98mquDGmxMwIIW/rjuIOXq6CatjUZ9gJbxRPLpdGpRmzp1Vc8OXIWzF9u9PZsERzazDN7AsZ3qYDuA6BWhzHNtt4JmtyTXtVFWBdjrwOWpRybf5cUiII6T5x0MiMT8aVpSl8MUT5cAIy0tYErK4782qB9CIOKfpMIhdoZGxFa6t";
        // return $enc_data;
        try {
            $key = "1234567890123456";
            $aes = new AES($enc_data, $key);
            $decryptedData = $aes->decrypt();

            $data = json_decode($decryptedData, true);
            // return $data;
            // Validation rules
            $rules = [
                'rtps_trans_id' => 'required|string',
                'user_id' => 'required|string',
                'mobile' => 'required|string',
                'service_id' => 'required|integer',
                'portal_no' => 'required',
                'process' => 'required|string',
                'response_url' => 'required|string',
            ];

            // Validate data
            $respondeValidator = Validator::make($data, $rules);
            if ($respondeValidator->fails()) {
                Alert::error($respondeValidator->errors()->first());
                return $respondeValidator->errors();
                return back();
            }

            if ($data['process'] == 'N') {
                $pfcDataSet = [
                    'rtps_trans_id' => $data['rtps_trans_id'],
                    'user_id' => $data['user_id'],
                    'service_id' => $data['service_id'],
                    'portal_no' => $data['portal_no'],
                    'mobile' => $data['mobile'],
                    'process' => $data['process'],
                    'user_type' => $data['user_type'],
                    'response_url' => $data['response_url'],
                    'kiosk_email' => $data['kiosk_detail']['email'],
                    'kiosk_name' => $data['kiosk_detail']['name'],
                    'kiosk_registration_id' => $data['kiosk_detail']['registration_id'],
                    'office_address' => $data['kiosk_detail']['office_address'],
                    'is_worker_registered' => 'NA',
                    'isLoginWithPfc' => true
                ];

                PfcKioskDetail::create($pfcDataSet);
            } else {

                PfcKioskDetail::where('rtps_trans_id', $data['rtps_trans_id'])->update([
                    "user_id" => $data['user_id'],
                    "mobile" => $data['mobile'],
                    "service_id" => $data['service_id'],
                    "portal_no" => $data['portal_no'],
                    "process" => $data['process'],
                    'isLoginWithPfc' => true
                ]);
            }

            session()->put('pfcData', $data['rtps_trans_id']);
            Alert::success("Your RTPS Transaction ID is : " . $data['rtps_trans_id']);
            if ($data['service_id'] == 1) {
                // return $data['service_id'];
                return redirect()->route('home.index');
            } elseif ($data['service_id'] == 4) {
                return redirect()->route('home.onboarding-criteria');
            } else {
                $rtps_trans_id = encrypt($data['rtps_trans_id']);

                return redirect()->route('subscriptionLogin', $rtps_trans_id);
            }
        } catch (Exception $e) {
            // return $e;
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function encryptDataforTest(Request $request)
    {


        try {

            $key = "1234567890123456";
            $aes = new AES(json_encode($request->all()), $key);
            $decryptData = $aes->encrypt();

            return response()->json([
                'status' => true,
                'decrypted_data' => $decryptData
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Decryption failed.',
                'error' => $e->getMessage()
            ]);
        }
    }



}
