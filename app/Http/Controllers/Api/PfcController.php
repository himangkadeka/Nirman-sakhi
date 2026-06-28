<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerAddress;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerForm;
use App\Models\PfcKioskDetail;
use App\Models\WorkerApplicationStatus;
use App\Models\WorkerSubscription;
use App\Services\AES;
use App\Services\GetVaultDataService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use function PHPUnit\Framework\isEmpty;

class PfcController extends Controller
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
//         $enc_data = "AMNRaPa38i5fz39donI93spWDO8N8PvZuLZRN6ptuJ1mfaSWxwgE1+xDPLE5pBAjYnXdQVPdtUVV7rf17FrfPxtjN4X/f6LyP0KDKrfVDS2VnRabO4ImlvjJS21OcN9pYCYepNsFLvr0nEYDNOAgMLnUrI5E6r5eg/GvErWeuvS2DmetFgm9StiFeBU6Otb4/nlM8ZE8HxCkEdD43ZoRGS9AB2FZ9r1q0w0AsH007ZaDK9uHO6Mar9RT+e2B1DQprCuDmL/152ZZR1icLJmIQBoJj6m7SufDr3mFPJdxmnGNnxD2PodaT6VJKfUs/SpBs0I/Ad/QmiY1eOohsdfmS98mquDGmxMwIIW/rjuIOXq6CatjUZ9gJbxRPLpdGpRmzp1Vc8OXIWzF9u9PZsERzazDN7AsZ3qYDuA6BWhzHNtt4JmtyTXtVFWBdjrwOWpRybf5cUiII6T5x0MiMT8aVpSl8MUT5cAIy0tYErK4782qB9CIOKfpMIhdoZGxFa6t";

        try {
            $key = "1234567890123456";
            $aes = new AES($enc_data, $key);
            $decryptedData = $aes->decrypt();

           $data = json_decode($decryptedData, true);

            // Validation rules
            $rules = [
                'rtps_trans_id' => 'required|string',
                'user_id' => 'required|string',
                'mobile' => 'required|string',
                'service_id' => 'required|integer',
                'portal_no' => 'required',
                'process' => 'required|string',
                'response_url' => 'required|string',
//                 'kiosk_detail' => 'required',
                // 'is_worker_registered' => 'required'
            ];

            // Validate data
//            $respondeValidator = Validator::make($data, $rules);
//            if ($respondeValidator->fails()) {
//                Alert::error($respondeValidator->errors()->first());
//                return $respondeValidator->errors();
//                return back();
//            }

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
                    'isLoginWithPfc' => true,
                    'is_login_csc' => $data['is_csc_login'],
                ];

                PfcKioskDetail::create($pfcDataSet);
            } else {

                PfcKioskDetail::where('rtps_trans_id', $data['rtps_trans_id'])->update([
                    "user_id" => $data['user_id'],
                    "mobile" => $data['mobile'],
                    "service_id" => $data['service_id'],
                    "portal_no" => $data['portal_no'],
                    "process" => $data['process'],
                    'isLoginWithPfc' => true,
//                    'is_login_csc' => $data['is_csc_login'],
                ]);
            }

            session()->put('pfcData', $data);
            Alert::success("Your RTPS Transaction ID is : " . $data['rtps_trans_id']);
            if ($data['service_id'] == 1) {
//                 return $data;
                return redirect()->route('home.index');
            } elseif ($data['service_id'] == 4) {
                return redirect()->route('home.onboarding-criteria');
            } else {
                $rtps_trans_id = encrypt($data['rtps_trans_id']);

                return redirect()->route('subscriptionLogin', $rtps_trans_id);
            }
        } catch (Exception $e) {
             return $e;
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

    public function loginforSubscription($enc_data)
    {
        $rtps_trans_id = decrypt($enc_data);
        $rtpsData = PfcKioskDetail::where('rtps_trans_id', $rtps_trans_id)->first();
        $idCards = MainWorkerForm::select('id_card')->where('phone_no', $rtpsData->mobile)->where('id_card', '!=', null);
        if ($idCards->count() == 0) {
            Alert::warning('Sorry', 'No Id Card Found!');
            return redirect()->route('home.index');
        } else {
            if ($rtpsData->worker_id != null) {
                $id_cardDatas = MainWorkerForm::select('id_card')->where('phone_no', $rtpsData->mobile)->where('id_card', $rtpsData->worker_id)->get();
            } else {
                $id_cardDatas = $idCards->get();
            }


            session()->put('pfcData', $rtpsData);
            Alert::success("Your RTPS Transaction ID is : " . $rtps_trans_id);
            return view('worker.subscription.subscription-login', compact('id_cardDatas','rtpsData'));
        }
    }


    public function getAccountDetails(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id_card' => 'required|exists:pgsql.Worker.main_worker_forms,id_card'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }

        $accountData = MainWorkerForm::where('id_card', $request->id_card);

        if ($accountData->count()) {
            $getVaultData = $this->getVaultDataService->getVaultData($accountData->first()->worker_id, "M");
            $vaultData = json_decode($getVaultData->getData(), true);
            return response()->json([
                'status' => true,
                'results' => $vaultData
            ]);
        } else {
            return response()->json([
                'status' => false,
                'results' => "No Data Found"
            ]);
        }
    }


    // public function postSubmissionEnc(Request $request)
    // {
    //     try {
    //         $applicant_details = '{
    //                         "gender": "male",
    //                         "email": "promit_2480@testmail.com",
    //                         "applicant_name": "Pritish Ranjan Barman",
    //                         "fathers_name": "Lt Pulin Barman",
    //                         "mobile_number": "9864098640",
    //                         "address_line_1": "Vill-Gadain Raji",
    //                         "address_line_2": "Town- Haflong",
    //                         "country": "India",
    //                         "state": "ASSAM",
    //                         "district": "Kamrup",
    //                         "pin_code": "788819"
    //                             }';
    //         $applicant_details_array = json_decode($applicant_details, true);

    //         $data = json_encode([
    //             "rtps_trans_id" => "ADSFF01",
    //             "user_id" => "9864098640",
    //             "service_id" => 5,
    //             "app_ref_no" => "NOC/KAM/2020/123",
    //             "status" => "S",
    //             "submission_date" => "2018-12-31 13:05:21",
    //             "payment_mode" => "ON",
    //             "payment_ref_no" => "001122",
    //             "payment_date" => "2018-12-31 13:05:21",
    //             "amount" => 20,
    //             "applicant_details" => $applicant_details_array,
    //             "portal_no" => 3,
    //             "payment_status" => "Y",
    //             "submission_location" => "guwahati"
    //         ]);

    //         $key = "1234567890123456";
    //         // return $data;
    //         $aes = new AES($data, $key);
    //         $encryptedData = $aes->encrypt();
    //         return response()->json([
    //             'status' => true,
    //             'encrypted_data' => $encryptedData
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Encryption failed.',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }



    public function submitApplicationStatus($worker_id_status)
    {
        try {


            $key = "1234567890123456";
            // $aes = new AES($request->data, $key);

            $trackDetails = WorkerApplicationStatus::where('worker_id', $worker_id_status)
                ->orderBy('created_at', 'asc')
                ->get();
            $worker_id = MainWorkerForm::where('worker_id', $worker_id_status);
            if ($worker_id->count() == 0) {
                return "No Data Found";
            }
            $vaultData = $this->getVaultDataService->getVaultData($worker_id->first()->worker_id, "M");
            $data['vaultData'] = json_decode($vaultData->getData(), true);

            $modifiedTrackDetails = [];

            foreach ($trackDetails as $trackDetail) {
                if ($trackDetail->application_status == "A" || $trackDetail->application_status == "G") {
                    $status = "Q";
                } elseif ($trackDetail->application_status == "F") {
                    $status = "D";
                } elseif ($trackDetail->application_status == "B" || $trackDetail->application_status == "C" || $trackDetail->application_status == "E") {
                    $status = "F";
                } elseif ($trackDetail->application_status == "D") {
                    $status = "R";
                }
                $modifiedTrackDetails[] = [
                    'user_name' => $data['vaultData']['name'],
                    'user_designation' => 'Worker',
                    'user_office' => $trackDetail->mainWorker->officeName->office_name,
                    'action' => $status,
                    'received_time' => Carbon::parse($trackDetail->created_at)->format('Y-m-d H:i:s'),
                    'executed_time' =>  Carbon::parse($trackDetail->updated_at)->format('Y-m-d H:i:s'),
                    'remark' => $trackDetail->remarks,
                    'url' => env("APP_URL"),
                ];
            }

            $data_to_encrypt = json_encode([
                'app_ref_no' => $worker_id->first()->ack_no,
                'mobile' => $worker_id->first()->phone_no,
                'task_details' => $modifiedTrackDetails,
            ]);

            //  return $data_to_encrypt;

            $aes_encrypt = new AES($data_to_encrypt, $key);
            $encryptedData = $aes_encrypt->encrypt();
//             return $encryptedData;
                //PRODUCTION
            $response = Http::post('https://sewasetu.assam.gov.in/iservices/rtpsapi/push_app_status', [
                'data' => "$encryptedData"
            ]);
            //STAGING API
//             $response = Http::post('https://sewasetu.assam.statedatacenter.in/iservices/rtpsapi/push_app_status', [
//                 'data' => $encryptedData
//             ]);
//             return $response;
            // Handle the response
             if ($response->successful()) {
                 return json_decode($response);
                 // return the API response directly
             } else {
                 return response()->json([
                     'status' => false,
                     'message' => 'Failed to post data to the external API.',
                     'error' => $response->body()
                 ]);
             }
        } catch (Exception $e) {
             return response()->json([
                 'status' => false,
                 'message' => 'Decryption failed.',
                 'error' => $e->getMessage()
             ]);
        }
    }


    public function trackApplication(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'data' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }

        try {
            $key = "1234567890123456";
            $aes = new AES($request->data, $key);
            $decryptedData = $aes->decrypt();
            $data = json_decode($decryptedData, true);
            $rules = [
                'app_ref_no' => 'required|string',
                'mobile' => 'required|string',
            ];

            // Validate data
            $respondeValidator = Validator::make($data, $rules);
            if ($respondeValidator->fails()) {
                return response()->json([
                    'status' => false,
                    'results' => $respondeValidator->errors()->first()
                ]);
            }

            $count = MainWorkerForm::where('ack_no', $data['app_ref_no'])->count();
            if ($count > 0) {
                $ack_no = $data['app_ref_no'];
            } else {
                $countSubscription = WorkerSubscription::where('transaction_id', $data['app_ref_no'])->count();
                if ($countSubscription > 0) {
                }
            }
            // $data['app_ref_no'] = substr($data['app_ref_no'], 0, -4);
            $trackDetails = WorkerApplicationStatus::where('ack_no', $data['app_ref_no'])
                ->orderBy('created_at', 'asc')
                ->get();
            $worker_id = MainWorkerForm::where('ack_no', $data['app_ref_no']);
            if ($worker_id->count() == 0) {
                return "No Data Found";
            }
            $vaultData = $this->getVaultDataService->getVaultData($worker_id->first()->worker_id, "M");
            $data['vaultData'] = json_decode($vaultData->getData(), true);

            $modifiedTrackDetails = [];

            foreach ($trackDetails as $trackDetail) {
                if ($trackDetail->application_status == "A" || $trackDetail->application_status == "G") {
                    $status = "Q";
                } elseif ($trackDetail->application_status == "F") {
                    $status = "D";
                } elseif ($trackDetail->application_status == "B" || $trackDetail->application_status == "C" || $trackDetail->application_status == "E") {
                    $status = "F";
                } elseif ($trackDetail->application_status == "D") {
                    $status = "R";
                }
                $modifiedTrackDetails[] = [
                    'user_name' => $data['vaultData']['name'],
                    'user_designation' => 'Worker',
                    'user_office' => $trackDetail->mainWorker->officeName->office_name,
                    'action' => $status,
                    'received_time' => Carbon::parse($trackDetail->created_at)->format('Y-m-d H:i:s'),
                    'executed_time' =>  Carbon::parse($trackDetail->updated_at)->format('Y-m-d H:i:s'),
                    'remark' => $trackDetail->remarks,
                    'url' => $trackDetail->application_status == "F" ? env("APP_URL") . 'api/sewasetu/acknowledgement/' . encrypt($worker_id->first()->worker_id) : "NA",
                ];
            }

            $data_to_encrypt = json_encode([
                'app_ref_no' => $data['app_ref_no'],
                'mobile' => $data['mobile'],
                'task_details' => $modifiedTrackDetails,
            ]);

            // return $data_to_encrypt;


            $aes_encrypt = new AES($data_to_encrypt, $key);
            $encryptedData = $aes_encrypt->encrypt();

            return response()->json([
                'data' => $encryptedData
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Decryption failed.',
                'error' => $e->getMessage()
            ]);
        }
    }



    public function postSubmissionDec(Request $request)
    {
        try {

            $key = "1234567890123456";
            $encryptedData = $request->data;
            //            dd($encryptedData);


            $aes = new AES($encryptedData, $key);
            $decryptData = $aes->decrypt();

            $decryptedArray = json_decode($decryptData, true);

            // Check for JSON decoding errors
            // if (json_last_error() !== JSON_ERROR_NONE) {
            //     throw new Exception('Error decoding JSON: ' . json_last_error_msg());
            // }

            // if (!isset($decryptedArray['applicant_details'])) {
            //     throw new Exception('applicant_details is missing in decrypted data');
            // }


            return response()->json([
                'status' => true,
                'decrypted_data' => $decryptedArray
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Decryption failed.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function testEncrypt(Request $request)
    {
        $data = encrypt($request->all());
        return $data;
    }


    public function getCertificate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'data' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }

        try {
            $key = "1234567890123456";
            $aes = new AES($request->data, $key);
            $decryptedData = $aes->decrypt();
            $data = json_decode($decryptedData, true);
            $rules = [
                'app_ref_no' => 'required|string',
                'mobile' => 'required|string',
            ];



            // Validate data
            $respondeValidator = Validator::make($data, $rules);
            if ($respondeValidator->fails()) {
                return response()->json([
                    'status' => false,
                    'results' => $respondeValidator->errors()->first()
                ]);
            }



            $data_to_encrypt = json_encode([
                'app_ref_no' => $data['app_ref_no'],
                'mobile' => "mmmm"
            ]);


            $aes_encrypt = new AES($data_to_encrypt, $key);
            $encryptedData = $aes_encrypt->encrypt();

            return response()->json([
                'status' => true,
                'results' => $encryptedData
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Decryption failed.',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function decryptTest(Request $request)
    {
        $key = "1234567890123456";
        $aes = new AES($request->data, $key);
        $decryptedData = $aes->decrypt();

        return $decryptedData;
    }


    public function getAcknowledgement($encId)
    {
        $workerId = decrypt($encId);
        $vaultData = $this->getVaultDataService->getVaultData($workerId, "M");
        $data['getVaultData'] = json_decode($vaultData->getData(), true);

        $data['worker'] = MainWorkerForm::where('worker_id', $workerId)->first();
        $data['mwf'] = DB::table('Worker.main_worker_forms as wmfm')
            ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
            ->where('worker_id', $workerId)
            ->select('wmfm.*', 'ofc.*')
            ->first();
        $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
            ->where('worker_id', $workerId)
            ->select('wmbd.*')
            ->first();

        $data['emblem'] = public_path('/assets/template/images/bocw.png');

        $options = [
            'encoding' => 'utf-8',
            'enable-local-file-access' => true,
        ];

        $html = view('worker.pdf.download-as-pdf', $data)->render();
        $pdfContent =  Pdf::loadHTML($html)
            ->setOptions($options)
            ->output();
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Acknowledgement_Receipt.pdf"',
        ]);
    }

    public function getIdCard($encId)
    {
        $workerId = decrypt($encId);
        $vaultData = $this->getVaultDataService->getVaultData($workerId, "M");
        $data['getVaultData'] = json_decode($vaultData->getData(), true);

        $data['simple'] = QrCode::size(120)->generate(route('home.qrCode', ['id' => $encId]));
        $data['user'] = MainWorkerForm::where('worker_id', $workerId)->first();
        $data['emblem'] = public_path('/assets/template/images/emblem-dark.png');
        $data['logo'] = public_path('assets/template/images/bocw.png');
        $data['add'] = MainWorkerAddress::where('worker_id', $workerId)->first();
        $options = [
            'encoding' => 'utf-8',
            'enable-local-file-access' => true,
            'enable-javascript' => true
        ];
        $html = view('office.dsc-registration.e-sign-id.id-card', $data)->render();
        $pdfContent =  Pdf::loadHTML($html)
            ->setOptions($options)
            ->output();
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="id-card.pdf"',
        ]);
    }
}
