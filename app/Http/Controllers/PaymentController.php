<?php

namespace App\Http\Controllers;

use App\Models\MainWorkerForm;
use App\Models\PfcKioskDetail;
use App\Models\WorkerIDCard;
use App\Models\WorkerPaymentSuccess;
use App\Models\WorkerSubscription;
use App\Models\WorkerTransaction;
use App\Rules\MatchAmount;
use App\Services\SmsGatewayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{


    protected $smsService;
    /**
     * @var AesCipher
     */


    public function __construct(SmsGatewayService $smsService)
    {
        $this->smsService = $smsService;
    }
    public function index()
    {
        $worker_id = session()->get('worker_id');
        $data = WorkerPaymentSuccess::where('worker_id', $worker_id)->first();
        $reg_pay_data = WorkerTransaction::where('id', 1)->first();
        $worker_data = DB::table('Worker.temporary_worker_forms')->where('worker_id', $worker_id)->first();
        return view('worker.worker-registration-payment', compact('data', 'reg_pay_data', 'worker_data'));
    }



    public function getSubsystemResponse(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'PORTAL_ENCDATA' => 'required',
                'MERCHANT_ID' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
            return back()->with('message', $validator->errors()->first());
        }


        $enc_data = $request->PORTAL_ENCDATA;

        $dec_data = $this->egrassDecrypt($enc_data);
        $stringData = $this->removeTilde($dec_data);
        $data = json_decode($stringData, true);

        $rules = [
            "GRN" => 'required',
            "AMOUNT" => "required",
            // "PARTYNAME" => 'required',
            // "TAXID" => 'required',
            "DEPARTMENT_ID" => 'required',
            "BANKNAME" => "required",
            "BANKCODE" => "required",
            "ENTRY_DATE" => "required",
            "STATUS" => "required",
            "PRN" => 'required_if:STATUS,Y',
            "TRANSCOMPLETIONDATETIME" => 'required_if:STATUS,Y',
            "BANKCIN" => 'required_if:STATUS,Y'
        ];




        $respondeValidator = Validator::make($data, $rules);
        if ($respondeValidator->fails()) {
            Alert::error($respondeValidator->errors()->first());
            return $respondeValidator->errors();
            return back();
        }

        try {


            $worker_payment_details = WorkerPaymentSuccess::where("DEPARTMENT_ID", $data['DEPARTMENT_ID'])->first();



            WorkerPaymentSuccess::where("DEPARTMENT_ID", $data['DEPARTMENT_ID'])->update([
                "GRN" => $data['GRN'],
                "AMOUNT" => $data['AMOUNT'],
                "BANKCODE" => $data['BANKCODE'],
                "BANKCIN" => $data['BANKCIN'],
                "PRN" => $data['PRN'],
                "TRANSCOMPLETIONDATETIME" => $data['TRANSCOMPLETIONDATETIME'],
                "STATUS" => $data['STATUS'],
                "PARTYNAME" => $data['PARTYNAME'],
                "TAXID" => $data['TAXID'],
                "BANKNAME" => $data['BANKNAME'],
                "ENTRY_DATE" => $data['ENTRY_DATE'],
            ]);

            $worker_data = MainWorkerForm::where('worker_id', $worker_payment_details->worker_id)->first();
            $subscription = WorkerSubscription::where('worker_id', $worker_data->worker_id)->latest()->first();
            if ($data['STATUS'] == 'Y') {

                if ($worker_payment_details->payment_type == 1) {

                    $worker_data->payment_status = "success";

                    $worker_data->save();

                    $this->smsService->applicationSubmissionSMS($worker_data->phone_no, $worker_data->ack_no, $data['AMOUNT']);

                    Alert::toast("Payment Successful", "success");


                    // $pfc_Data = PfcKioskDetail::where('worker_id', $worker_payment_details->worker_id)->first();

                    if ($worker_data->rtps_trans_id != null) {

                        session()->put('pfcData', $worker_data->rtps_trans_id);
                    }

                    session()->put('worker_id', $worker_payment_details->worker_id);

                    if ($worker_data->already_registered == 1) {

                        return redirect()->route('paymentSuccess');
                    } else {

                        return redirect()->route('payment-status');
                    }
                } elseif ($worker_payment_details->payment_type == 2) {
                    $subscription->transaction_id = $data['DEPARTMENT_ID'];
                    $subscription->payment_status = '1';
                    $subscription->save();
                    WorkerIDCard::where('worker_id',$worker_data->worker_id)->update([
                        'is_id_card_downloadble' => 1
                    ]);
                    MainWorkerForm::where('worker_id', $worker_data->worker_id)->update([
                        'subscription_status' => '1',
                        'active_status' => 1,
                    ]);
                    session()->put('worker', $worker_data);
                    session()->put('worker-session', true);
                    Alert::toast("Payment Successful!", "success");
                    return redirect()->route('payment-successful', $data['DEPARTMENT_ID']);
                }
            } elseif ($data['STATUS'] == "N") {
                if ($worker_payment_details->payment_type == 1) {

                    $worker_data->payment_status = "failed";

                    $worker_data->save();

                    Alert::toast("Payment Failed!", "error");


                    // $pfc_Data = PfcKioskDetail::where('worker_id', $worker_payment_details->worker_id)->first();

                    if ($worker_data->rtps_trans_id != null) {

                        session()->put('pfcData', $worker_data->rtps_trans_id);
                    }

                    session()->put('worker_id', $worker_payment_details->worker_id);

                    if ($worker_data->already_registered == 1) {


                        return redirect()->route('submit-existing-preview');
                    } else {

                        return redirect()->route('submit-worker-payment');
                    }
                } elseif ($worker_payment_details->payment_type == 2) {

                    //update status subscription
                    $subscription->payment_status = '0';
                    $subscription->save();
                    session()->put('worker', $worker_data);
                    session()->put('worker-session', true);
                    Alert::toast("Payment Failed!", "error");
                    return redirect()->route('my-subscription');
                }
            } elseif ($data['STATUS'] == "A") {

                if ($worker_payment_details->payment_type == 1) {

                    session()->put('worker_id', $worker_payment_details->worker_id);

                    if ($worker_data->already_registered == 1) {


                        return redirect()->route('submit-existing-preview');
                    } else {
                        $worker_data->payment_status = "Aborted";

                        $worker_data->save();

                        Alert::toast("Payment Aborted!", "error");
                        return redirect()->route('submit-worker-payment');
                    }
                } elseif ($worker_payment_details->payment_type == 2) {
                    //update payment subscription
                    $subscription->payment_status = '0';
                    $subscription->save();
                    session()->put('worker', $worker_data);
                    session()->put('worker-session', true);
                    Alert::toast("Payment Aborted!", "error");
                    return redirect()->route('my-subscription');
                }
            } elseif ($data['STATUS'] == "P") {


                Alert::toast("Payment Pending!", "error");

                if ($worker_payment_details->payment_type == 1) {
                    $worker_data->payment_status = "pending";

                    $worker_data->save();

                    session()->put('worker_id', $worker_payment_details->worker_id);

                    if ($worker_data->already_registered == 1) {


                        return redirect()->route('submit-existing-preview');
                    } else {

                        return redirect()->route('submit-worker-payment');
                    }
                } elseif ($worker_payment_details->payment_type == 2) {

                    //update payment subscription
                    $subscription->payment_status = '0';
                    $subscription->save();
                    session()->put('worker', $worker_data);
                    session()->put('worker-session', true);
                    Alert::toast("Payment Pending!", "error");
                    return redirect()->route('my-subscription');
                }
            }
        } catch (Exception $e) {

            Alert::toast($e->getMessage());

            if ($worker_payment_details->payment_type == 1) {
                session()->put('worker_id', $worker_payment_details->worker_id);
                return redirect()->route('submit-worker-payment');
            } else {
                session()->put('worker', $worker_data);
                session()->put('worker-session', true);
                return redirect()->route('my-subscription');
            }
        }
    }


    function removeTilde($input)
    {
        // Remove any trailing ~ characters (in case the string ends with ~)
        $input = rtrim($input, '~');

        // Split the string by ~ to get individual key=value pairs
        $pairs = explode('~', $input);

        // Initialize an associative array
        $data = [];

        // Loop through each pair and split it by = to form key => value
        foreach ($pairs as $pair) {
            list($key, $value) = explode('=', $pair);
            $data[$key] = $value;
        }

        // Convert the associative array to a JSON string
        return json_encode($data, JSON_PRETTY_PRINT);
    }


    public function paymentInitiate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'department_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }
        $payment_status = WorkerPaymentSuccess::where("DEPARTMENT_ID", $request->department_id)->first();

        if ($payment_status->STATUS != 'P') {
            WorkerPaymentSuccess::where("DEPARTMENT_ID", $request->department_id)->update([
                'STATUS' => 'F',
                'updated_at' => now()
            ]);
        }


        return response()->json([
            'status' => true,
            'results' => "Data Updated"
        ]);
    }



    public function getCin(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'PORTAL_ENCDATA' => 'required',
                'MERCHANT_ID' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
            return back()->with('message', $validator->errors()->first());
        }

        $enc_data = $request->PORTAL_ENCDATA;

        $dec_data = $this->egrassDecrypt($enc_data);
        $stringData = $this->removeTilde($dec_data);
        $data = json_decode($stringData, true);
        // return $request->all();
        $rules = [
            // "GRN" => 'required',
            // "AMOUNT" => "nullable",
            // // "PARTYNAME" => 'required',
            // // "TAXID" => 'required',
            "DEPARTMENT_ID" => 'required',
            // "BANKNAME" => "required",
            // "BANKCODE" => "required",
            // "ENTRY_DATE" => "required",
            "STATUS" => "required",
            // "PRN" => 'required',
            // "TRANSCOMPLETIONDATETIME" => 'required',
            // "BANKCIN" => 'required'
        ];

        $respondeValidator = Validator::make($data, $rules);
        if ($respondeValidator->fails()) {
            Alert::error($respondeValidator->errors()->first());
            return $respondeValidator->errors();
            return back();
        }
        // return $request->all();
        try {
            $worker_payment_details = WorkerPaymentSuccess::where("DEPARTMENT_ID", $data['DEPARTMENT_ID'])->first();

            WorkerPaymentSuccess::where("DEPARTMENT_ID", $data['DEPARTMENT_ID'])->update([
                "GRN" => $data['GRN'],
                "AMOUNT" => $data['AMOUNT'],
                "BANKCODE" => $data['BANKCODE'],
                "BANKCIN" => $data['BANKCIN'],
                "PRN" => $data['PRN'],
                "TRANSCOMPLETIONDATETIME" => $data['TRANSCOMPLETIONDATETIME'],
                "STATUS" => $data['STATUS'],
                "PARTYNAME" => $data['PARTYNAME'],
                "TAXID" => $data['TAXID'],
                "BANKNAME" => $data['BANKNAME'],
                "ENTRY_DATE" => $data['ENTRY_DATE'],
            ]);

            $worker_data = MainWorkerForm::where('worker_id', $worker_payment_details->worker_id)->first();


            if ($data['STATUS'] == 'Y') {

                if ($worker_payment_details->payment_type == 1) {

                    $worker_data->payment_status = "success";

                    $worker_data->save();

                    $this->smsService->applicationSubmissionSMS($worker_data->phone_no, $worker_data->ack_no, $data['AMOUNT']);

                    Alert::toast("Payment Successfull!", "success");


                    // $pfc_Data = PfcKioskDetail::where('worker_id', $worker_payment_details->worker_id)->first();

                    if ($worker_data->rtps_trans_id != null) {

                        session()->put('pfcData', $worker_data->rtps_trans_id);
                    }

                    session()->put('worker_id', $worker_payment_details->worker_id);

                    if ($worker_data->already_registered == 1) {

                        return redirect()->route('paymentSuccess');
                    } else {

                        return redirect()->route('payment-status');
                    }
                } elseif ($worker_payment_details->payment_type == 2) {

                    $subscription = WorkerSubscription::where('worker_id', $worker_data->worker_id)->latest()->first();
                    $subscription->transaction_id = $data['DEPARTMENT_ID'];
                    $subscription->payment_status = '1';
                    $subscription->save();
                    WorkerIDCard::where('worker_id',$worker_data->worker_id)->update([
                        'is_id_card_downloadble' => 1
                    ]);
                    MainWorkerForm::where('worker_id', $worker_data->worker_id)->update([
                        'subscription_status' => '1',
                        'active_status' => 1,
                    ]);
                    session()->put('worker', $worker_data);
                    session()->put('worker-session', true);
                    Alert::toast("Payment Successfull!", "success");
                    return redirect()->route('payment-successful', $data['DEPARTMENT_ID']);
                }
            } elseif ($data['STATUS'] == "N") {
                if ($worker_payment_details->payment_type == 1) {

                    $worker_data->payment_status = "0";

                    $worker_data->save();

                    Alert::toast("Payment Failed!", "error");


                    // $pfc_Data = PfcKioskDetail::where('worker_id', $worker_payment_details->worker_id)->first();

                    if ($worker_data->rtps_trans_id != null) {

                        session()->put('pfcData', $worker_data->rtps_trans_id);
                    }

                    session()->put('worker_id', $worker_payment_details->worker_id);

                    if ($worker_data->already_registered == 1) {


                        return redirect()->route('submit-existing-preview');
                    } else {

                        return redirect()->route('submit-worker-payment');
                    }
                } elseif ($worker_payment_details->payment_type == 2) {

                    session()->put('worker', $worker_data);
                    session()->put('worker-session', true);
                    Alert::toast("Payment Failed!", "error");
                    return redirect()->route('my-subscription');
                }
            } elseif ($data['STATUS'] == "A") {
                $worker_data->payment_status = "Aborted";

                $worker_data->save();

                Alert::toast("Payment Aborted!", "error");

                if ($worker_payment_details->payment_type == 1) {

                    session()->put('worker_id', $worker_payment_details->worker_id);

                    if ($worker_data->already_registered == 1) {


                        return redirect()->route('submit-existing-preview');
                    } else {

                        return redirect()->route('submit-worker-payment');
                    }
                } elseif ($worker_payment_details->payment_type == 2) {
                    session()->put('worker', $worker_data);
                    session()->put('worker-session', true);
                    Alert::toast("Payment Aborted!", "error");
                    return redirect()->route('my-subscription');
                }
            } elseif ($data['STATUS'] == "P") {
                $worker_data->payment_status = "pending";

                $worker_data->save();

                Alert::toast("Payment Pending!", "error");

                if ($worker_payment_details->payment_type == 1) {

                    session()->put('worker_id', $worker_payment_details->worker_id);

                    if ($worker_data->already_registered == 1) {


                        return redirect()->route('submit-existing-preview');
                    } else {

                        return redirect()->route('submit-worker-payment');
                    }
                } elseif ($worker_payment_details->payment_type == 2) {
                    session()->put('worker', $worker_data);
                    session()->put('worker-session', true);
                    Alert::toast("Payment Pending!", "error");
                    return redirect()->route('my-subscription');
                }
            }
        } catch (Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            if ($worker_payment_details->payment_type == 1) {
                session()->put('worker_id', $worker_payment_details->worker_id);
                return redirect()->route('submit-worker-payment');
            } else {
                session()->put('worker', $worker_data);
                session()->put('worker-session', true);
                return redirect()->route('my-subscription');
            }
        }
    }




    public function egrasEnc(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                "AC1_AMOUNT" => [
                    'required',
                    // new MatchAmount(
                    //     $request->input('NON_TREASURY_PAYMENT_TYPE'),
                    //     $request->input('TOTAL_NON_TREASURY_AMOUNT'),
                    //     $request->input('MOBILE_NO')
                    // )
                ],
                "ACCOUNT1" => ['required', 'in:LED13922,LED13359'],
                "AMOUNT1" => 'nullable',
                "CHALLAN_AMOUNT" => "required",
                "DEPARTMENT_ID" => "required|exists:pgsql.Worker.worker_payment_success,DEPARTMENT_ID",
                "DEPT_CODE" => "required",
                "FROM_DATE" => ['required', 'in:01/04/2024'],
                "HOA1" => 'nullable',
                "MAJOR_HEAD" => "nullable",
                // "MOBILE_NO" => "required|numeric|min:10|exists:pgsql.Worker.main_worker_forms,phone_no",
                "MOBILE_NO" => "required|numeric",
                "MULTITRANSFER" => "required",
                "NON_TREASURY_PAYMENT_TYPE" => ['required',
                // 'in:03,12'
            ],
                // 13,12
                "OFFICE_CODE" => "required|exists:pgsql.Masterdata.offices,egrass_office_code",
                "PARTY_NAME" => "required",
                "PAYMENT_TYPE" => "nullable",
                "PERIOD" => ["required", 'in:O'],
                "REC_FIN_YEAR" => ['required', 'in:2024-2025'],
                "REMARKS" => "nullable",
                "SUB_SYSTEM" => ["required", 'in:BOCW'],
                "TOTAL_NON_TREASURY_AMOUNT" => [
                    'required'
                    // ,
                    // new MatchAmount(
                    //     $request->input('NON_TREASURY_PAYMENT_TYPE'),
                    //     $request->input('AC1_AMOUNT'),
                    //     $request->input('MOBILE_NO')
                    // )
                ],
                "TO_DATE" => ["required", "in:31/03/2099"],
                "TREASURY_CODE" => "nullable",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }

        // return $request->all();
        try {
            $plainData = $this->formatRequestData($request);

            $publicKeyPath = storage_path('app/private/key-file/pub_key_egras.pem');
            $publicKey = file_get_contents($publicKeyPath);

            $randomSymmetricKey = openssl_random_pseudo_bytes(32);

            $initializationVector = openssl_random_pseudo_bytes(12);

            $encryptedPlainData = openssl_encrypt($plainData, 'aes-256-gcm', $randomSymmetricKey, OPENSSL_RAW_DATA, $initializationVector, $authenticationTag);

            $encryptedPlainData = openssl_encrypt($plainData, 'aes-256-gcm', $randomSymmetricKey, OPENSSL_RAW_DATA, $initializationVector, $authenticationTag);

            openssl_public_encrypt($randomSymmetricKey, $encryptedSymmetricKey, $publicKey);

            $finalRequest = base64_encode($encryptedSymmetricKey . $initializationVector . $encryptedPlainData . $authenticationTag);

            return response()->json([
                'status' => true,
                'results' => $finalRequest
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'results' => "Encryption Failed due to " . $e->getMessage()
            ]);
        }
    }


    public function formatRequestData(Request $request)
    {
        $data = $request->except('_token'); // Exclude the _token field if present

        $formattedString = '';

        foreach ($data as $key => $value) {
            if (!is_null($value)) {
                $formattedString .= $key . '=' . $value . '~';
            }
        }

        // Remove the trailing '~' character if not empty
        if (strlen($formattedString) > 0) {
            $formattedString = rtrim($formattedString, '~');
        }

        return $formattedString;
    }


    public function getCinEncrypt(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'DEPARTMENT_ID' => "required|exists:pgsql.Worker.worker_payment_success,DEPARTMENT_ID",
                'OFFICE_CODE' => "required|exists:pgsql.Masterdata.offices,egrass_office_code",
                "AMOUNT" => "required",
                'ACTION_CODE' => ["required", 'in:GETCIN'],
                'SUB_SYSTEM' => ["required", 'in:BOCW']
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }

        try {
            $plainData = $this->formatRequestData($request);

            $publicKeyPath = storage_path('app/private/key-file/pub_key_egras.pem');
            $publicKey = file_get_contents($publicKeyPath);

            $randomSymmetricKey = openssl_random_pseudo_bytes(32);

            $initializationVector = openssl_random_pseudo_bytes(12);

            $encryptedPlainData = openssl_encrypt($plainData, 'aes-256-gcm', $randomSymmetricKey, OPENSSL_RAW_DATA, $initializationVector, $authenticationTag);

            $encryptedPlainData = openssl_encrypt($plainData, 'aes-256-gcm', $randomSymmetricKey, OPENSSL_RAW_DATA, $initializationVector, $authenticationTag);

            openssl_public_encrypt($randomSymmetricKey, $encryptedSymmetricKey, $publicKey);

            $finalRequest = base64_encode($encryptedSymmetricKey . $initializationVector . $encryptedPlainData . $authenticationTag);

            return response()->json([
                'status' => true,
                'results' => $finalRequest
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'results' => "Encryption Failed due to " . $e->getMessage()
            ]);
        }
    }



    // receipt encryptiom

    public function paymentReceipt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'DEPARTMENT_ID' => 'required',
            'GRN' => 'required',
            'OFFICE_CODE' => 'required',
            'AMOUNT' => 'required',
            'VIEWCHALLAN' => 'required',
            'hcin_no' => 'required',
            'OUTSIDE' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' =>  false,
                'results' => $validator->errors()
            ]);
        }

        try {
            $plainData = $this->formatRequestData($request);

            $publicKeyPath = storage_path('app/private/key-file/pub_key_egras.pem');
            $publicKey = file_get_contents($publicKeyPath);

            $randomSymmetricKey = openssl_random_pseudo_bytes(32);

            $initializationVector = openssl_random_pseudo_bytes(12);

            $encryptedPlainData = openssl_encrypt($plainData, 'aes-256-gcm', $randomSymmetricKey, OPENSSL_RAW_DATA, $initializationVector, $authenticationTag);

            $encryptedPlainData = openssl_encrypt($plainData, 'aes-256-gcm', $randomSymmetricKey, OPENSSL_RAW_DATA, $initializationVector, $authenticationTag);

            openssl_public_encrypt($randomSymmetricKey, $encryptedSymmetricKey, $publicKey);

            $finalRequest = base64_encode($encryptedSymmetricKey . $initializationVector . $encryptedPlainData . $authenticationTag);

            return response()->json([
                'status' => true,
                'results' => $finalRequest
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'results' => "Encryption Failed due to " . $e->getMessage()
            ]);
        }
    }

    public function egrassDecrypt($encrypted_string)
    {



        $privateKeyPath = storage_path('app/private/key-file/pvt_key.pem');
        $privateKey = file_get_contents($privateKeyPath);

        $decodedData = base64_decode($encrypted_string);

        $privateKeyResource = openssl_pkey_get_private($privateKey);

        $privateKeyDetails = openssl_pkey_get_details($privateKeyResource);

        $encryptedSymmetricKeyLength = $privateKeyDetails['bits'] / 8;

        $encryptedSymmetricKey = substr($decodedData, 0, $encryptedSymmetricKeyLength);

        $initializationVector = substr($decodedData, $encryptedSymmetricKeyLength, 12);

        $encryptedPlainData = substr($decodedData, $encryptedSymmetricKeyLength + 12, -16);

        $authenticationTag = substr($decodedData, -16);

        openssl_private_decrypt($encryptedSymmetricKey, $symmetricKey, $privateKey);

        $decryptedPlainData = openssl_decrypt($encryptedPlainData, 'aes-256-gcm', $symmetricKey, OPENSSL_RAW_DATA, $initializationVector, $authenticationTag);

        return $decryptedPlainData;
    }
}
