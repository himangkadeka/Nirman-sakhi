<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\Worker\MasterWorkerController;
use App\Models\AadharLogModel;
use App\Models\Amount;
use App\Models\Bank;
use App\Models\BloodGroup;
use App\Models\BocwCard;
use App\Models\Category;
use App\Models\District;
use App\Models\Education;
use App\Models\Gender;
use App\Models\KeyValue;
use App\Models\MainVaultData;
use App\Models\MaritalStatus;
use App\Models\Office;
use App\Models\OldWorkers;
use App\Models\PostOffice;
use App\Models\Profession;
use App\Models\RationType;
use App\Models\RevertBack;
use App\Models\Skill;
use App\Models\SubDistrict;
use App\Models\TempData;
use App\Models\TemporaryWorkerAddress;
use App\Models\TemporaryWorkerBank;
use App\Models\TemporaryWorkerDocument;
use App\Models\TemporaryWorkerEmployerDetail;
use App\Models\TemporaryWorkerFamily;
use App\Models\TemporaryWorkerForm;
use App\Models\MainWorkerAddress;
use App\Models\MainWorkerBank;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerCertificate;
use App\Models\MainWorkerDocument;
use App\Models\MainWorkerEmployerDetail;
use App\Models\MainWorkerFamily;
use App\Models\MainWorkerForm;
use App\Models\TemporaryWorkerScheme;
use App\Models\TemporaryWorkerBasicDetail;

use App\Models\MainWorkerScheme;
use App\Models\PfcKioskDetail;
use App\Models\State;
use App\Models\TemporaryWorkerCertificate;
use App\Models\User;
use App\Models\VaultData;
use App\Models\WorkerApplicationStatus;
use App\Models\WorkerNinetyDaysCertificate;
use App\Models\WorkerPaymentSuccess;
use App\Models\WorkerSubscription;
use App\Services\AES;
use App\Services\AesCipher;
use App\Services\ApiCurlService;
use App\Services\SmsGatewayService;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use Carbon\Carbon;
use Database\Seeders\KeyValueSeeder;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Services\GetVaultDataService;

class ExistingWorkerController extends Controller
{
    protected $smsService;
    protected $apiCurlService;
    protected $getVaultDataService;

    public function __construct(SmsGatewayService $smsService, ApiCurlService $apiCurlService, GetVaultDataService $getVaultDataService)
    {
        $this->apiCurlService = $apiCurlService;
        $this->smsService = $smsService;
        $this->getVaultDataService = $getVaultDataService;
    }

    public function getDistricts(Request $request)
    {
        $districts['districts'] = District::where('state_code', $request->state_code)
            ->select('district_code', 'district_name')->orderBy('district_name')->get();
        return response()->json($districts);
    }

    /** Display sub-districts */
    public function getSubDist(Request $request)
    {
        $data['subdist'] = SubDistrict::where('district_code', $request->district_code)
            ->select('subdistrict_code', 'subdistrict_name')->orderBy('subdistrict_name')->get();
        return response()->json($data);
    }


    /** Display sub-districts post-office */
    public function getSubdistPostOffc(Request $request)
    {
        $data['subdist'] = SubDistrict::where('state_code', $request->state_code)
            ->where('district_code', $request->district_code)
            ->select('subdistrict_code', 'subdistrict_name')->orderBy('subdistrict_name')->get();
        $data['postoffice'] = PostOffice::where('state_code', $request->state_code)
            ->where('district_code', $request->district_code)
            ->select('post_office_id', 'post_office_name', 'pin_code')->orderBy('post_office_name')
            ->get();
        return response()->json($data);
    }
    /** Display pin-codes */
    public function getPin(Request $request)
    {
        $data['pincode'] = PostOffice::where('state_code', $request->state_code)
            ->where('district_code', $request->district_code)
            ->where('post_office_id', $request->poid)
            ->select('pin_code')
            ->first();
        return response()->json($data);
    }
    public function getBank(Request $request)
    {
        $data['ifsc'] = Bank::where('ifsc', $request->ifsc)
            ->first();
        return response()->json($data);
    }
    public function getSkills(Request $request)
    {
        $data['skills'] = Skill::select('skill_code', 'skill_name')
            ->orderBy('skill_name')
            ->get();

        return response()->json($data);
    }
    public function getRationType(Request $request)
    {
        $data['ration_type'] = RationType::select('ration_code', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($data);
    }

    public function checkBeforeOnboarding(Request $request)
    {
        try {
            session()->forget('from_onboarding');
            if (session()->has('pfcData')) {
                $session_rtps_trans_id = session()->get('pfcData');
                $data['pfc_data'] = PfcKioskDetail::where('rtps_trans_id', $session_rtps_trans_id)->first();
            }
            $data['districts'] = District::where('state_code', '=', 18)
                ->orderBy('district_name')
                ->get();
            return view('existing-worker.check-temp-account', $data);
        } catch (Exception $e) {
            Alert::toast('Something went wrong!', 'error');
            return back();
        }
    }

    public function savePhoneEx(Request $request)
    {


        $validate = $request->validate([
            'phone_no' => 'required|digits:10'
        ]);
        Cookie::queue('phoneNo', $request->phone_no, 60);
        return redirect()->route('ex-reg-worker');
    }

    public function  checkPhoneCountEx(Request $request)
    {
        $phone = $request->query('phone');

        $count = TemporaryWorkerForm::where('phone_no', $phone)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function checkPhoneEx(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'phone_no' => 'required|digits:10'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'exists' => false,
                'msg' => $validator->errors()->first(),
            ]);
        }


        try {
            $mainData = DB::table('Worker.main_worker_forms')
                ->where('phone_no', $request->phone_no)
                ->count();


            if ($mainData == 4) {
                return response()->json([
                    'exists' => true,
                    'status' => 'limit',
                    'msg' => 'Already 4 applications have been registered under this phone number.No more applications are allowed under this phone number.',
                ]);
            }

            $accountsList = TemporaryWorkerForm::where('phone_no', $request->phone_no)->get();
            $modified_app = [];
            foreach ($accountsList as $account) {
                if (MainWorkerForm::where('worker_id', $account->worker_id)->exists()) {
                    $modified_app[] = [
                        'worker_id' => $account->worker_id,
                        'ack_no' => MainWorkerForm::where('worker_id', $account->worker_id)->first()->ack_no,
                        'already_registered' =>  MainWorkerForm::where('worker_id', $account->worker_id)->first()->already_registered,

                    ];
                } elseif (RevertBack::where('worker_id', $account->worker_id)->exists()) {
                    $modified_app[] = [
                        'worker_id' => $account->worker_id,
                        'ack_no' => RevertBack::where('worker_id', $account->worker_id)->first()->ack_no,
                        'already_registered' =>  RevertBack::where('worker_id', $account->worker_id)->first()->already_registered,
                    ];
                } else {
                    $modified_app[] = [
                        'worker_id' => $account->worker_id,
                        'ack_no' => $account->worker_id,
                        'already_registered' => $account->already_registered,
                    ];
                }
            }

            if ($accountsList->isEmpty()) {
                return response()->json(['status' => 'new_register']);
            }
            $accountsCount = TemporaryWorkerForm::where('phone_no', $request->phone_no)->count();
            $showLogin = $accountsCount <= 4;

            return response()->json([
                'status' => 'accounts_found',
                'accounts' => $modified_app,
                'show_login' => $showLogin,
                'accounts_count' => $accountsCount
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function verifyWorkerMobileEx(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'temp_worker_id_otp' => 'required'
            ]);
            $data['tempWorkerId'] = $validatedData['temp_worker_id_otp'];

            $data['phone_no'] = TemporaryWorkerForm::where('worker_id', $data['tempWorkerId'])->first();


            $userFinalData = MainWorkerForm::where('worker_id', $data['tempWorkerId'])->first();

            $userTempData = TemporaryWorkerForm::where('worker_id', $data['tempWorkerId'])->first();
            if ($userFinalData) {
                if ($userFinalData->payment_status == 'success') {
                    return response()->json(['status' => 'success', 'message' => 'You have Completed the Registration Process', 'redirect' => route('home.index')]);
                } elseif ($userFinalData->payment_status == NULL) {
                    session()->put('worker_id', $userFinalData->worker_id);
                    return response()->json(['status' => 'pending', 'redirect' => route('OTP-gen-page-on')]);
                }
            }
            if ($userTempData) {
                session()->put('worker_id', $userTempData->worker_id);
                return response()->json(['status' => 'proceed_to_login', 'redirect' => route('OTP-gen-page-on')]);
            } else {
                return response()->json(['status' => 'not_registered', 'message' => 'You have not registered.']);
            }
        } catch (Exception $e) {
            Log::error('Error in loginWithTempId: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Please try again later.'], 500);
        }
    }

    public function OTPPageEx(Request $request)
    {

        $temp_worker_id = session()->get('worker_id');
        $data['worker_id'] = $temp_worker_id;
        $data['phone_no'] = TemporaryWorkerForm::where('worker_id', $temp_worker_id)->pluck('phone_no')->first();
        return view('existing-worker.worker-otp-generation', $data);
    }

    public function getAccountDetailsEx(Request $request)
    {

        $worker_id = $request->input('worker_id');

        $account = MainWorkerForm::where('worker_id', $worker_id)
            ->where('already_registered', 1)
            ->select('worker_id', 'status', 'ack_no', 'phone_no', 'application_no', 'payment_status')
            ->first();

        try {
            $getVaultData = $this->getVaultDataService->getVaultData($worker_id, "T");
            $vaultData = json_decode($getVaultData->getData(), true);
            if ($account) {
                if ($account->payment_status == 'success') {

                    return response()->json([
                        'status' => 'payment_success',
                        'account' => $account,
                        'vaultData' => $vaultData,
                        'message' => 'Application Submitted',
                        'application_status' => 'Successfully Submitted'
                    ]);
                } elseif ($account->payment_status == NULL) {
                    return response()->json([
                        'status' => 'payment_pending',
                        'account' => $account,
                        'vaultData' => $vaultData,
                        'message' => 'Payment is pending. Please complete the payment to proceed.',
                        'application_status' => 'Pending'
                    ]);
                }
            }
            $account = RevertBack::Where('worker_id', $worker_id)
                ->where('already_registered', 1)
                ->select('worker_id', 'status', 'ack_no', 'phone_no', 'application_no')
                ->first();
            if ($account) {
                $application_status = WorkerApplicationStatus::where('worker_id', $worker_id)->where('application_status', 'G')
                    ->value('remarks');

                return response()->json([
                    'status' => 'application_reverted',
                    'account' => [
                        'account' => $account,
                        'app_status' => $application_status
                    ],
                    'vaultData' => $vaultData,
                    'message' => 'Application is reverted.',
                    'application_status' => 'Reverted'
                ]);
            }


            $account = TemporaryWorkerForm::Where('worker_id', $worker_id)
                ->where('already_registered', 1)
                ->select('worker_id', 'phone_no', 'application_no')
                ->first();

            if ($account) {
                return response()->json([
                    'status' => 'application_pending',
                    'account' => $account,
                    'vaultData' => $vaultData,
                    'message' => 'Application is pending. Please complete your application.',
                    'application_status' => 'Not Submitted'
                ]);
            }

            return response()->json(['status' => 'not_found']);
        } catch (Exception $e) {
            //            return $e;
            return response()->json([
                'status' => false,
                'results' => $e->getMessage()
            ]);
        }
    }

    public function deleteWorkerDataEx(Request $request)
    {
        $workerId = $request->input('temp_worker_id');

        if (!$workerId) {
            return response()->json([
                'status' => 'error',
                'message' => 'No worker ID provided.',
            ], 400);
        }

        try {
            $temp = TemporaryWorkerForm::where('worker_id', $workerId)->exists();
            if ($temp) {
                DB::table('Worker.temporary_worker_forms')->where('worker_id', $workerId)->delete();
            }
            $temp_basic = TemporaryWorkerBasicDetail::where('worker_id', $workerId)->exists();
            if ($temp_basic) {
                DB::table('Worker.temporary_worker_basic_details')->where('worker_id', $workerId)->delete();
            }
            $temp_address = TemporaryWorkerAddress::where('worker_id', $workerId)->first();
            if ($temp_address) {
                DB::table('Worker.temporary_worker_addresses')->where('worker_id', $workerId)->delete();
            }
            $temp_bank = TemporaryWorkerBank::where('worker_id', $workerId)->first();
            if ($temp_bank) {
                DB::table('Worker.temporary_worker_banks')->where('worker_id', $workerId)->delete();
            }
            $temp_document = TemporaryWorkerDocument::where('worker_id', $workerId)->first();
            if ($temp_document) {
                DB::table('Worker.temporary_worker_documents')->where('worker_id', $workerId)->delete();
            }
            $temp_family = TemporaryWorkerFamily::where('worker_id', $workerId)->get();
            if ($temp_family) {
                DB::table('Worker.temporary_worker_families')->where('worker_id', $workerId)->delete();
            }
            $temp_scheme = TemporaryWorkerScheme::where('worker_id', $workerId)->get();
            if ($temp_scheme) {
                DB::table('Worker.temporary_worker_schemes')->where('worker_id', $workerId)->delete();
            }
            $temp_vault = VaultData::where('worker_id', $workerId)->first();
            if ($temp_vault) {
                DB::table('Worker.vault_data')->where('worker_id', $workerId)->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Worker and related data deleted successfully.',
                'redirect' => route('new-register') // adjust as needed
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete data: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function loginWithResubmitEx($encodedId)
    {

      $base64_decode_id = base64_decode($encodedId);
//        try {

            $tempWorkerId =  $base64_decode_id;
        Session::put('worker_id', $tempWorkerId);
            return redirect()->route('submit-basic-page');
//        } catch (Exception $e) {
//             return $e;
//            Log::error('Error in loginWithTempId: ' . $e->getMessage());
//            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Please try again later.'], 500);
//        }
    }
    public function ExRegisterWorker(Request $request)
    {
        try {
            $data['districts'] = District::where('state_code', '=', 18)
                ->orderBy('district_name')
                ->get();

            $nonce = substr(md5(uniqid(mt_rand(), true)), 0, 23);
            session()->put('nonce_value', $nonce);
            //            $decryptedId = decrypt($id);
            //            $data['phoneNo'] = tempData::findorFail($decryptedId);
            $data['phoneNo'] = $request->cookie('phoneNo');
            if (session()->has('pfcData')) {
                $session_rtps_trans_id = session()->get('pfcData');
                $data['pfc_data'] = PfcKioskDetail::where('rtps_trans_id', $session_rtps_trans_id)->first();
            }
            return view('existing-worker.register_old_worker', $data);
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }



    public function saveExReg(Request $request)
    {


        try {
            $request->validate([
                'district' => 'required|exists:pgsql.Masterdata.districts,district_code',
                'office_id' => 'required|exists:pgsql.Masterdata.offices,office_id',
                'phone_no' => 'required|digits:10',
                'aadhar_consent' => 'required',
                'uid' => 'required|numeric',


            ]);

            session()->put('form_data', $request->all());

            return redirect()->route('existing-data');
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }

    public function getDetails(Request $request)
    {

        try {
            $data['formdata'] = session()->get('form_data');

            $aadhar_data = session()->get('uid_data');
            $decoded_data = json_decode($aadhar_data, true);
            if (isset($decoded_data['encResponseData'])) {
                $encrypted_data = $decoded_data['encResponseData'];
            }
            $securityController = new SecurityController();
            $key = KeyValue::where('key', 'SALT_VALUE')->first()->value;
            $licenceKeyEnc = KeyValue::where('key', 'LICENSE_KEY')->first()->value;
            $licenceKey = $securityController->decrypt($licenceKeyEnc, $key);
            $decrypted = AesCipher::decrypt($licenceKey, $encrypted_data);
            $data['uid_data'] = json_decode($decrypted);
            $tokennew = $data['uid_data']->vaultToken;
            $data['api_response'] = json_decode(session('api_response'));
            session()->flash('api_response');

            return view('existing-worker.existing-worker-details', $data);
        } catch (Exception $e) {

            Alert::toast("Something went Wrong!", "error");
            return back();
        }
    }

    public function checkRecord(Request $request)
    {
        try {
            $validate = $request->validate([
                'phone_no' => 'required|digits:10'
            ]);

            $phone = MainWorkerForm::where('phone_no', $validate['phone_no'])
                ->first();

            if (!$phone) {
                return response()->json([
                    'exists' => false,
                    'msg' => 'Please enter valid aadhaar no to register',
                ]);
            }
            switch ($phone->payment_status) {
                case NULL:
                    return response()->json([
                        'exists' => true,
                        'msg' => 'Payment pending, please login and pay the fees!',
                    ]);
                case 'success':
                    return response()->json([
                        'exists' => true,
                        'msg' => 'You have completed your registration successfully!',
                    ]);
                default:
                    return response()->json([
                        'exists' => true,
                        'msg' => 'Please Register',
                    ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'exists' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function checkIdCard(Request $request)
    {

        $validate = $request->validate([
            'worker_id' => 'required',
        ]);
        $idcard = MainWorkerForm::where('worker_id', $validate['worker_id'])
            ->first();


        if (!$idcard) {
            // return false;
            return response()->json([
                'status' => false,
                'msg' => "NO Data"
            ]);
            return $this->postDetails($request);
        }
        session()->put('worker_id', $idcard->worker_id);
        switch ($idcard->payment_status) {
            case 'pending':
                return response()->json([
                    'exists' => true,
                    'msg' => 'Payment pending, please login and pay the fees!',
                    'redirect' => route('submit-existing-preview')
                ]);
            case 'success':
                return response()->json([
                    'exists' => true,
                    'msg' => 'You have completed your registration successfully!',
                    'redirect' => route('home.index')
                ]);

            default:
                return response()->json([
                    'exists' => true,
                    'msg' => 'Please Register',
                ]);
        }
    }


    public function postDetails(Request $request)
    {

        $validate = $request->validate([
            'worker_id' => 'required',
        ]);

        //    $url = "http://localhost/testapi/getOneUser.php";
        $url = "http://103.158.205.175/testapi/getOneUser.php";
        //         $url = "http://localhost/labour_old/api/getOneUser.php";



        $data = [
            'id_card' => $request->worker_id,
        ];

        $response = $this->apiCurlService->sendPostRequest($url, $data);
        // return $response;

        if (isset($response->id_card)) {
            $data = session()->put('api_response', json_encode($response));
            return response()->json(['data' => $response], 200);
        } else {

            return response()->json(['error' => 'No ID Card Found,Please enter valid ID Card.']);
        }
    }

    public function setSessionData(Request $request)
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
                'message' => $validator->errors()->first()
            ]);
        }

        session()->put('api_response', json_encode($request->data));
        return response()->json([
            'status' => true,
            'message' => "Stored Successfully"
        ]);
    }

    public function loginWithTempIdEx(Request $req)
    {
        try {
            $validatedData = $req->validate([
                'temp_worker_id' => 'required'
            ]);


            $tempWorkerId = $validatedData['temp_worker_id'];


            $userFinalData = MainWorkerForm::where('worker_id', $tempWorkerId)->first();

            $userTempData = TemporaryWorkerForm::where('worker_id', $tempWorkerId)->first();



            if ($userFinalData) {
                if ($userFinalData->payment_status == 'success') {
                    return response()->json(['status' => 'success', 'message' => 'You have Completed the Registration Process', 'redirect' => route('home.index')]);
                } elseif ($userFinalData->payment_status == NULL || $userFinalData->payment_status == 'failed' || $userFinalData->payment_status == 'Aborted' || $userFinalData->payment_status == 'pending') {
                    session()->put('worker_id', $userFinalData->worker_id);
                    return response()->json(['status' => 'pending', 'message' => 'Payment is Pending,login and pay the registration fees', 'redirect' => route('submit-worker-payment')]);
                }
            }


            if ($userTempData) {
                session()->put('worker_id', $userTempData->worker_id);
                return response()->json(['status' => 'proceed_to_login', 'redirect' => route('submit-basic-page')]);
            } else {
                return response()->json(['status' => 'not_registered', 'message' => 'You have not registered.']);
            }
        } catch (Exception $e) {
            Log::error('Error in loginWithTempId: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Please try again later.'], 500);
        }
    }

    public function generateUniqueWorkerID($request)
    {
        $prefix = "TICKET/";
        $prefix_with_dist = $prefix . date("d/m/Y/") . $request->office_id;

        do {
            $rand_no = rand(111111111, 999999999);
            $worker_id_with_district_office = $prefix_with_dist . $rand_no;

            $id_exist = TemporaryWorkerForm::where('worker_id', $worker_id_with_district_office)->count();
        } while ($id_exist > 0);

        return $worker_id_with_district_office;
    }

    public function RegisterWorker(Request $request)
    {
        try {
            DB::beginTransaction();

            $formData = session()->get('form_data');
            $aadhar_data = session()->get('uid_data');
            $decoded_data = json_decode($aadhar_data, true);
            $encrypted_data = $decoded_data['encResponseData'] ?? null;

            // Fetch security keys
            $securityController = new SecurityController();
            $saltKey = KeyValue::where('key', 'SALT_VALUE')->first()->value;
            $licenceKeyEnc = KeyValue::where('key', 'LICENSE_KEY')->first()->value;
            $licenceKey = $securityController->decrypt($licenceKeyEnc, $saltKey);
            $tokenKey = $decoded_data['vaultToken'];
            $tokenPasskey = $decoded_data['vaultPassKey'];
            $secretKey = KeyValue::where('key', 'SECRET_KEY_TOKEN')->first()->value;

            // Decrypt Aadhaar data and check age
            $decrypted = AesCipher::decrypt($licenceKey, $encrypted_data);
            $uid_data = json_decode($decrypted);
            $dob = Carbon::parse($uid_data->dob);
            if ($dob->age < 18) {
                DB::rollBack();
                Alert::toast('Age eligibility criteria not met.', 'error');
                return redirect()->route('error-show-worker', 0);
            }

            // Check for duplicate vault token
            if (VaultData::where('vault_token', $tokenKey)->exists()) {
                $main_vault_token = MainVaultData::where('vaultToken', $tokenKey)->count();
                if ($main_vault_token > 0) {
                    $workerId = MainVaultData::where('vaultToken', $tokenKey)
                        ->value('worker_id');
                  $contact = MainWorkerForm::where('worker_id',$workerId)->value('phone_no');
                    DB::rollBack();
                    Alert::toast('Duplicate data found.', 'error');
                    return redirect()->route('error-show-worker', [
                        'id' => 1,
                        'contact' => $contact
                    ]);
                }

                $worker_id = VaultData::where('vault_token', $tokenKey)->value('worker_id');
                $already_registered = TemporaryWorkerForm::where('worker_id', $worker_id)->value('already_registered');

                if ($already_registered === 1 || is_null($already_registered)) {
                    session()->put('worker_id', $worker_id);
                    Alert::toast('Draft application found!', 'info');
                    return redirect()->route($already_registered === 1 ? 'submit-basic-page' : 'main-page');
                }
            }

            $apiResponse = json_decode(session()->get('api_response'), true);
            $applicationId = rand(10000000, 99999999); // Ensure 8-digit number
            $phone_no = $formData['phone_no'];

            // Check phone number registration limit
            if (TemporaryWorkerForm::where('phone_no', $phone_no)->count() >= 4) {
                DB::rollBack();
                Alert::toast('Phone number has reached maximum registrations.', 'error');
                return redirect()->route('error-show-worker', 2);
            }

            // Case 1: API response exists
            if (is_array($apiResponse)) {
                $validate = $request->validate(['worker_id' => 'required']);
                $worker_id = $validate['worker_id'];

                if (DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->exists()) {
                    DB::rollBack();
                    Alert::toast('You have already registered!', 'error');
                    return redirect()->back();
                }

                $userExistsTemp = TemporaryWorkerForm::where('worker_id', $worker_id)->first();
                if (!$userExistsTemp) {
                    $this->createWorkerRecord($request, $formData, $applicationId, $tokenKey, $tokenPasskey, $secretKey, $encrypted_data);
                    Alert::toast('Worker registered successfully.', 'success');
                    return redirect()->route('submit-basic-page');
                }

                session()->put('worker_id', $userExistsTemp->worker_id);
                DB::rollBack();
                Alert::toast('Draft application found.', 'info');
                return redirect()->route('submit-basic-page');
            }

            // Case 2: No API response, worker_id provided
            if (!is_array($apiResponse) && !empty($request->worker_id)) {
                $validate = $request->validate(['worker_id' => 'required']);
                $worker_id = $validate['worker_id'];

                if (MainWorkerForm::where('worker_id', $worker_id)->exists()) {
                    DB::rollBack();
                    Alert::toast('You have already registered!', 'error');
                    return redirect()->back();
                }

                $userExistsTemp = TemporaryWorkerForm::where('worker_id', $worker_id)->first();
                if (!$userExistsTemp) {
                    $this->createWorkerRecord($request, $formData, $applicationId, $tokenKey, $tokenPasskey, $secretKey, $encrypted_data);
                    Alert::toast('Worker registered successfully.', 'success');
                    return redirect()->route('submit-basic-page');
                }

                session()->put('worker_id', $userExistsTemp->worker_id);
                DB::rollBack();
                Alert::toast('Draft application found.', 'info');
                return redirect()->route('submit-basic-page');
            }

            // Case 3: No API response, no worker_id
            if (!is_array($apiResponse) && empty($request->worker_id)) {
                $worker_id = $this->generateUniqueWorkerID($request);

                if (MainWorkerForm::where('phone_no', $phone_no)
                    ->whereIn('payment_status', [null, 'success'])
                    ->exists()
                ) {
                    DB::rollBack();
                    Alert::toast('You have already registered.', 'error');
                    return redirect()->route('error-show-worker', 3);
                }

                $userExistsTemp = TemporaryWorkerForm::where('phone_no', $phone_no)->first();
                if (!$userExistsTemp) {
                    $this->createWorkerRecord($request, $formData, $applicationId, $tokenKey, $tokenPasskey, $secretKey, $encrypted_data, $worker_id);
                    Alert::toast('Worker registered successfully.', 'success');
                    return redirect()->route('main-page');
                }

                session()->put('worker_id', $userExistsTemp->worker_id);
                DB::rollBack();
                Alert::toast('Draft application found.', 'info');
                return redirect()->route('main-page');
            }

            // Fallback for invalid cases
            DB::rollBack();
            Alert::toast('Invalid request.', 'error');
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            Log::error('Database error during worker registration: ' . $e->getMessage());
            Alert::toast('Database error: ' . $e->getMessage(), 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during worker registration: ' . $e->getMessage());
            Alert::toast('Something went wrong!: ' .$e->getMessage() , 'error');
            return redirect()->back();
        }
    }

    /**
     * Helper function to create worker records
     */
    private function createWorkerRecord($request, $formData, $applicationId, $tokenKey, $tokenPasskey, $secretKey, $encrypted_data, $worker_id = null)
    {
        $worker_id = $worker_id ?? $request->worker_id;
        $securityController = new SecurityController();
        $vTokenkey = $securityController->encrypt($tokenKey, $secretKey);
        $passKey = $securityController->encrypt($tokenPasskey, $secretKey);

        $data = TemporaryWorkerForm::create([
            'worker_id' => $worker_id,
            'phone_no' => $formData['phone_no'],
            'office_id' => $formData['office_id'],
            'district_id' => $formData['district'],
            'application_no' => $applicationId,
            'already_registered' => '1',
            'aadhaar_auth' => 1,
            'vaultToken' => $vTokenkey,
            'vaultPassKey' => $passKey,
        ]);

        AadharLogModel::create([
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'consent' => $formData['aadhar_consent'],
            'token_id' => $vTokenkey,
        ]);

        VaultData::create([
            'worker_id' => $worker_id,
            'vault_token' => $tokenKey,
            'enc_data' => $encrypted_data,
        ]);

        if (session()->has('pfcData')) {
            $session_rtps_trans_id = session()->get('pfcData');
            PfcKioskDetail::where('rtps_trans_id', $session_rtps_trans_id)->update([
                'worker_id' => $worker_id,
            ]);
        }

        session()->put('worker_id', $data->worker_id);
        session()->put('api_response', json_encode(session()->get('api_response')));
        DB::commit();
    }

    public function sessionFlash()
    {
        Session::flush();
        session()->regenerate();
        return redirect()->route('home.index');
    }

    public function updateBocwNo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'existing_id' => 'required|string|max:255', // Add max length and type validation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'result' => $validator->errors()->first(),
            ]); // HTTP 400 for validation errors
        }

        try {
            $session_worker_id = session()->get('worker_id');

            if (!$session_worker_id) {
                return $this->sessionFlash();
            }

            BocwCard::updateOrCreate(
                [
                    'worker_id' => $request->worker_id_revert,
                ],
                [
                    'existing_card' => $request->existing_id,


                ]
            );
            TemporaryWorkerForm::where('worker_id', $session_worker_id)->update([
                'already_registered' => '1',
            ]);


            return response()->json([
                'status' => true,
                'result' => "Data Updated"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'result' => $e->getMessage()
            ]);
        }
    }

    public function officeAddress()
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
        $data['getVaultData'] = json_decode($vaultData->getData(), true);
        $data['dists'] = District::where('state_code', '=', 18)->get();
        return view('existing-worker.edit.edit-worker-district-and-office', $data);
    }

    public function updateWorkerOffice(Request $request)
    {
        $session_worker_id = session()->get('worker_id');

        if (!$session_worker_id) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please log in again.'
            ], 401);
        }

        try {
            // Update the worker's office details
            TemporaryWorkerForm::where('worker_id', $session_worker_id)->update([
                'district_id' => $request->district_id,
                'office_id' => $request->office_id
            ]);

            Alert::toast('Office Applied for Updated Successfully', 'success');

            return redirect()->route('submit-basic-page');
        } catch (\Exception $e) {
            // return $e;
            Alert::toast('Something went wrong', 'error');
            return back();
        }
    }

    public function basicPage(Request $request)
    {
        try {
          $session_worker_id = session()->get('worker_id');

            if (!$session_worker_id) {
                return $this->sessionFlash();
            }


            $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('application_status', 'G')->count();
            $data['remarks'] = '';
            if ($remarks > 0) {
                $data['remarks'] = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                    ->where('application_status', 'G')
                    ->first();
            }




            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");

            $data['getVaultData'] = json_decode($vaultData->getData(), true);

           $data['formdata'] = $formdata = TemporaryWorkerBasicDetail::with([
                'form',
                'gender',
                'maritalStatus',
                'eduCation',
                'bloodGroup',
                'cateGory',
                'skill',
                'state',
                'Profession',
                'rationType'
            ])
                ->where('worker_id', $session_worker_id)
                ->first();

            if ($data['formdata']) {
                $data['gender']      = Gender::where('gender_code', '!=', optional($formdata->gender)->gender_code)
                    ->orderBy('gender_name', 'asc')
                    ->get();

                $data['marital']     = MaritalStatus::where('marital_code', '!=', optional($formdata->maritalStatus)->marital_code)
                    ->orderBy('marital_status', 'asc')
                    ->get();

                $data['category']    = Category::where('category_code', '!=', optional($formdata->cateGory)->category_code)
                    ->orderBy('category_name', 'asc')
                    ->get();

                $data['education']   = Education::where('education_code', '!=', optional($formdata->eduCation)->education_code)
                    ->orderBy('education_name', 'asc')
                    ->get();

                $data['skills']      = Skill::where('skill_code', '!=', optional($formdata->skill)->skill_code)
                    ->orderBy('skill_name', 'asc')
                    ->get();

                $data['blood']       = BloodGroup::where('id', '!=', optional($formdata->bloodGroup)->id)
                    ->orderBy('blood_group', 'asc')
                    ->get();

                $data['professions'] = Profession::where('profession_code', '!=', optional($formdata->Profession)->profession_code)
                    ->orderBy('profession_name', 'asc')
                    ->get();

                $data['states']      = State::orderBy('state_name', 'asc')->get();

                $data['ration']      = RationType::orderBy('name', 'asc')->get();


                $data['xyz'] = TemporaryWorkerForm::where('worker_id', $session_worker_id)
                    ->first(['application_no', 'phone_no', 'worker_id']);


                return view('existing-worker.edit.edit-worker-basic-details', $data);
            } else {
             $apiResponse = json_decode(session('api_response',true));
                if (is_string($apiResponse)) {
                    $apiResponse = json_decode($apiResponse, true);
                }
                if (is_array($apiResponse)) {
                    $fullName = $apiResponse['Name'] ?? '';
                    $careOf = $apiResponse['father_husband'] ?? '';

                    $nameParts = explode(' ', $fullName, 2);
                    $firstName = $nameParts[0] ?? '';
                    $lastName = $nameParts[1] ?? '';

                    $data['name'] = $fullName;
                    $data['careOf'] = $careOf;
                } else {
                    $firstName = '';
                    $lastName = '';
                    $data['name'] = '';
                    $data['careOf'] = '';
                }
                if (isset($apiResponse->dob)) {
                    $dob = $apiResponse->dob;
                    $data['age'] = Carbon::parse($dob)->age;
                }

                $data['firstName'] = $firstName ?: '';
                $data['lastName'] = $lastName ?: '';
                $data['gender'] = Gender::all();
                $data['category'] = Category::all();
                $data['marital'] = MaritalStatus::all();
                $data['education'] = Education::all();
                $data['skills'] = Skill::all();
                $data['states'] = State::all();
                $data['ration'] = RationType::all();
                $data['blood'] = BloodGroup::orderBy('blood_group', 'asc')->get();
                $data['professions'] = Profession::orderBy('profession_name', 'asc')
                    ->get();
                $data['xyz'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->first(['application_no', 'phone_no', 'worker_id']);

                return view('existing-worker.worker-basic-details', $data, ['apiResponse' => $apiResponse]);

            }
        } catch (Exception $e) {
            return $e;
            Alert::toast("Something Went Wrong!", "error");
//            return back();
        }
    }



    /** save basic worker basic data */
    public function saveExistingBasic(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }



        $old_dob_formatted = $request->old_dob
            ? Carbon::parse($request->old_dob)->format('Y-m-d')
            : null;

        $card_validity_date = $request->card_validity_date
            ? Carbon::parse($request->card_validity_date)->format('Y-m-d')
            : null;

        $last_registration_date = $request->last_registration_date
            ? Carbon::parse($request->last_registration_date)->format('Y-m-d')
            : null;

        $subscription_payment_date = $request->subscription_payment_date
            ? Carbon::parse($request->subscription_payment_date)->format('Y-m-d')
            : null;
        $age_aadhar = $request->age_aadhar;

        $validate = Validator::make($request->all(), [
            'worker_id' => 'unique:pgsql.Worker.temporary_worker_basic_details',
            'maritial_status_id' => 'required|exists:pgsql.Masterdata.marital_statuses,marital_code',
            'old_name' => 'nullable|string',
            'care_of_old' => 'nullable|string',
            'date_of_retirement' => 'required|date',
            'old_dob' => 'nullable',
            //            'gender_id' => 'required|exists:pgsql.Masterdata.genders,genders_code',
            'gender_id' => 'required',
            'category' => 'required|exists:pgsql.Masterdata.categories,category_code',
            'eshram_no' => $age_aadhar >= 59 ? 'nullable|digits:12' : 'required|digits:12',
            'education_id' => 'required|exists:pgsql.Masterdata.educations,education_code',
            'email' => 'nullable|regex:/(.+)@(.+)\.(.+)/i',
            'pan' => 'required|in:1,0',
            'pan_no' => $request->input('pan') == '1' ? 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/|max:10' : '',
            'resident_type' => 'required|in:raa,rao',
            'state_id' => $request->input('resident_type') == 'rao' ? 'required|exists:pgsql.Masterdata.states,state_code' : '',
            'boc' => 'required|in:1,0',
            'boc_no' => $request->input('boc') == '1' ? 'required|string' : '',
            'has_ration_card' => 'required|in:0,1',
            'ration_no' => $request->has_ration_card == '1' ? 'required|string|max:255' : '',
            'ration_type' => $request->has_ration_card == '1' ? 'required|exists:pgsql.Masterdata.ration_types,ration_code' : '',
            'blood_group' => 'required|exists:pgsql.Masterdata.blood_groups,id',
            'card_validity_date' => 'required|date',
            'last_registration_date' => 'required|date',
            'subscription_receipt' => 'required|in:1,0',
            'subscription_payment_date' => 'required_if:subscription_receipt,1|date|nullable',
            'subscription_amount_paid'  => 'required_if:subscription_receipt,1|numeric|nullable',

            // 'profession' => 'required|exists:pgsql.Masterdata.professions,profession_code',
            // 'profession_others' => 'nullable',
            'profession' => 'exists:pgsql.Masterdata.professions,profession_code', // Validate profession code
            'profession_others' => function ($attribute, $value, $fail) use ($request) {
                if ($request->input('profession') == '28') {
                    if (empty($value)) {
                        $fail('The profession others field is required when profession is Others.');
                    } elseif (!is_string($value)) {
                        $fail('The profession others field must be a string.');
                    }
                }
            },
            'other_state' => $request->input('boc') == '1' ? 'required|exists:pgsql.Masterdata.states,state_code' : '',
        ], [
            'worker_id.unique' => '⚠ The Worker is already registered!',
            'old_name.required' => '⚠ Name Cannot be blank',
            'maritial_status_id.required' => '⚠ Please Select',
            'category.required' => '⚠ Please select',
            'gender_id' => '⚠ Please select',
            'education_id.required' => '⚠ Education cannot be blank',
            'eshram_no.required' => '⚠ e-Shram no cannot be blank',
            'state_id.required_if' => '⚠ State is required for the selected resident type.',
            'resident_type.required' => '⚠ Please select whether you are a Permanent Resident Of Assam or not',
            'pan.required' => '⚠ Please Select',
            'boc.required' => '⚠ Please Select',
            'has_ration_card.required' => '⚠ Please Select whether you have a ration card or not',
            'ration_no.required' => '⚠ The Ration Card Number Cannot Be Blank',
            'ration_type.required' => '⚠ Please Select',
            'blood_group.required' => '⚠ Please Select',
            'other_state.required' => '⚠ Please Select',
            'subscription_payment_date.required' => 'subscription payment date is required',
            'subscription_amount_paid.required' => 'subscription amount is required',
            'profession.required' => '⚠ Please select profession'
        ]);




        //        $validate->after(function ($validator) use ($request) {
        //            $issueDate = $request->input('last_registration_date');
        //            $validityDate = $request->input('card_validity_date');
        //            $renewalDate = $request->input('last_renewal_date');
        //
        //            if ($issueDate && $validityDate) {
        //                $issueDate = new DateTime($issueDate);
        //                $validityDate = new DateTime($validityDate);
        //                $differenceInYears = $validityDate->diff($issueDate)->y;
        //
        //                if ($differenceInYears > 2 && !$renewalDate) {
        //                    $validator->errors()->add('last_renewal_date', 'The last renewal date is required when the card validity is more than 2 years.');
        //                }
        //            }
        //        });

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }


        $inputGender = strtolower(trim($request->gender_id));


        if ($inputGender == 'male' || $inputGender == '1') {
            $gender_id = 1;
        } elseif ($inputGender == 'female' || $inputGender == '2') {
            $gender_id = 2;
        } else {
            $gender_id = 3; // Other or unspecified
        }


        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->pluck('application_no')
            ->first();

        DB::beginTransaction();
        try {

            $data = TemporaryWorkerBasicDetail::Create([
                'worker_id' => $session_worker_id,
                'application_no' => $data['application_no'],
                'maritial_status_id' => $request->maritial_status_id,
                'category' => $request->category,
                'eshram_no' => $request->eshram_no,
                'education_id' => $request->education_id,
                'pf_no' => $request->pf_no,
                'esic_no' => $request->esic_no,
                'email' => $request->email,
                'pan_no' => $request->pan_no,
                'pan' => $request->pan,
                'state_id' => $request->state_id,
                'resident_type' => $request->resident_type,
                'boc' => $request->boc,
                'boc_no' => $request->boc_no,
                'has_ration_card' => $request->has_ration_card,
                'ration_type' => $request->ration_type,
                'ration_no' => $request->ration_no,
                'blood_group' => $request->blood_group,
                'old_name' => $request->old_name,
                'old_care_of' => $request->care_of_old,
                'old_dob' => $old_dob_formatted,
                'date_of_retirement' => $request->date_of_retirement
                    ? Carbon::parse($request->date_of_retirement)->format('Y-m-d')
                    : null,
                'gender_id' => $gender_id,
                'card_validity_date' => $card_validity_date,
                'last_registration_date' => $last_registration_date,
                'other_state' => $request->other_state,
                'subscription_payment_date' => $subscription_payment_date,
                'subscription_amount_paid' => $request->subscription_amount_paid,
                'subscription_receipt' => $request->subscription_receipt,
                'profession' => $request->profession,
                'profession_others' => $request->profession_others,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
        DB::commit();
        Alert::toast('Basic Details Submitted Successfully', 'success');

        return redirect()->route('submit-existing-basic-details');
    }


    public function updateExistingBasic(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $old_dob_formatted = $request->old_dob
            ? Carbon::parse($request->old_dob)->format('Y-m-d')
            : null;

        $card_validity_date = $request->card_validity_date
            ? Carbon::parse($request->card_validity_date)->format('Y-m-d')
            : null;

        $last_registration_date = $request->last_registration_date
            ? Carbon::parse($request->last_registration_date)->format('Y-m-d')
            : null;

        $subscription_payment_date = $request->subscription_payment_date
            ? Carbon::parse($request->subscription_payment_date)->format('Y-m-d')
            : null;

        $age_aadhar = $request->age_aadhar;
        // $age_aadhar = 60;
        $validate = Validator::make($request->all(), [


            'maritial_status_id' => 'required|exists:pgsql.Masterdata.marital_statuses,marital_code',
            'old_name' => 'nullable|string',
            'care_of_old' => 'nullable|string',
            'date_of_retirement' => 'required|date',
            'old_dob' => 'nullable',
            // 'gender_id' => 'nullable|exists:pgsql.Masterdata.genders,id',
            'category' => 'required|exists:pgsql.Masterdata.categories,category_code',
            'eshram_no' => $age_aadhar >= 59 ? 'nullable|digits:12' : 'required|digits:12',
            'education_id' => 'required|exists:pgsql.Masterdata.educations,education_code',
            'email' => 'nullable|regex:/(.+)@(.+)\.(.+)/i',
            'pan' => 'required|in:1,0',
            'pan_no' => $request->input('pan') == '1' ? 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/|max:10' : '',
            'resident_type' => 'required|in:raa,rao',
            'state_id' => $request->input('resident_type') == 'rao' ? 'required|exists:pgsql.Masterdata.states,state_code' : '',
            'boc' => 'required|in:1,0',
            'boc_no' => $request->input('boc') == '1' ? 'required|string' : '',
            'has_ration_card' => 'required|in:0,1',
            'ration_no' => $request->has_ration_card == '1' ? 'required|string|max:255' : '',
            'ration_type' => $request->has_ration_card == '1' ? 'required|exists:pgsql.Masterdata.ration_types,ration_code' : '',
            'blood_group' => 'required|exists:pgsql.Masterdata.blood_groups,id',
            'card_validity_date' => 'required|date',
            'other_state' => $request->input('boc') == '1' ? 'required|exists:pgsql.Masterdata.states,state_code' : '',
            'subscription_receipt' => 'required|in:1,0',
            'subscription_payment_date' => 'required_if:subscription_receipt,1|date|nullable',
            'subscription_amount_paid'  => 'required_if:subscription_receipt,1|numeric|nullable',
            'profession' => 'exists:pgsql.Masterdata.professions,profession_code', // Validate profession code
            'profession_others' => function ($attribute, $value, $fail) use ($request) {
                if ($request->input('profession') == '28') {
                    if (empty($value)) {
                        $fail('The profession others field is required when profession is Others.');
                    } elseif (!is_string($value)) {
                        $fail('The profession others field must be a string.');
                    }
                }
            },
        ], [


            'old_name.required' => '⚠ Name Cannot be blank',
            'maritial_status_id.required' => '⚠ Please Select',
            'category.required' => '⚠ Please select',
            'education_id.required' => '⚠ Education cannot be blank',
            'eshram_no.required' => '⚠ e-Shram no cannot be blank',
            'state_id.required_if' => '⚠ State is required for the selected resident type.',
            'resident_type.required' => '⚠ Please select whether you are a Permanent Resident Of Assam or not',
            'pan.required' => '⚠ Please Select',
            'boc.required' => '⚠ Please Select',
            'has_ration_card.required' => '⚠ Please Select whether you have a ration card or not',
            'ration_no.required' => '⚠ The Ration Card Number Cannot Be Blank',
            'ration_type.required' => '⚠ Please Select',
            'blood_group.required' => '⚠ Please Select',
            'other_state.required' => '⚠ Please Select',
            'subscription_payment_date.required' => 'subscription payment date is required',
            'subscription_amount_paid.required' => 'subscription amount is required',
            'profession.required' => '⚠ Please select profession'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }


        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->pluck('application_no')
            ->first();

        $inputGender = strtolower(trim($request->gender_id));


        if ($inputGender == 'male' || $inputGender == '1') {
            $gender_id = 1;
        } elseif ($inputGender == 'female' || $inputGender == '2') {
            $gender_id = 2;
        }
//        return $gender_id;

        $gender = TemporaryWorkerBasicDetail::where('worker_id', $session_worker_id)->pluck('gender_id')->first();
        DB::beginTransaction();
        try {
            $basic = TemporaryWorkerBasicDetail::where('worker_id', $session_worker_id)->update([
                'worker_id' => $session_worker_id,
                'application_no' => $data['application_no'],
                'maritial_status_id' => $request->maritial_status_id,
                'category' => $request->category,
                'eshram_no' => $request->eshram_no,
                'education_id' => $request->education_id,
                'email' => $request->email,
                'pan_no' => $request->pan_no,
                'pan' => $request->pan,
                'state_id' => $request->state_id,
                'resident_type' => $request->resident_type,
                'boc' => $request->boc,
                'boc_no' => $request->boc_no,
                'has_ration_card' => $request->has_ration_card,
                'ration_type' => $request->ration_type,
                'ration_no' => $request->ration_no,
                'blood_group' => $request->blood_group,
                'old_name' => $request->old_name,
                'old_care_of' => $request->care_of_old,
                'old_dob' => $old_dob_formatted,
                'date_of_retirement' => $request->date_of_retirement
                    ? Carbon::parse($request->date_of_retirement)->format('Y-m-d')
                    : null,
                'gender_id' =>  $gender,
                'card_validity_date' => $card_validity_date,
                'last_registration_date' => $last_registration_date,
                'other_state' => $request->other_state,
                'subscription_payment_date' => $subscription_payment_date,
                'subscription_amount_paid' => $request->subscription_amount_paid,
                'subscription_receipt' => $request->subscription_receipt,
                'profession' => $request->profession,
                'profession_others' => $request->profession_others,
            ]);
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
        DB::commit();
        Alert::toast('Basic Details Updated Successfully', 'success');
        return redirect()->route('submit-existing-basic-details')->with('success');
    }
    /** Redirect to address page **/
    public function pageExistingAddress(Request $request)
    {

        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('application_status', 'G')->count();
            $data['remarks'] = '';
            if ($remarks > 0) {
                $data['remarks'] = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                    ->where('application_status', 'G')
                    ->first();
            }
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['resident_type'] = TemporaryWorkerBasicDetail::where('worker_id', $session_worker_id);
            $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_addresses as twam')
                ->leftJoin('Masterdata.residences as cres', 'twam.c_residence', '=', 'cres.residence_code')
                ->leftjoin('Masterdata.houses as chs', 'twam.c_house_type', '=', 'chs.house_code')
                ->where('twam.worker_id', $session_worker_id)
                ->select('twam.*', 'cres.*', 'chs.*')
                ->first();
            $data['districts'] = DB::table('Masterdata.districts')
                ->where('state_code', '=', 18)
                ->orderBy('district_name')
                ->get();
            if ($formdata) {
                $data['residence'] = DB::table('Masterdata.residences')->where('residence_code', '!=', $formdata->residence_code)->get();
                $data['house'] = DB::table('Masterdata.houses')->where('house_code', '!=', $formdata->house_code)->get();
                $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->pluck('application_no')
                    ->first();
                $data['xyz'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->first(['application_no', 'phone_no', 'worker_id']);

                return view('existing-worker/edit.edit-worker-address-details', $data);
            } else {

                $apiResponse = json_decode(session('api_response'));
                $data['residence'] = DB::table('Masterdata.residences')->get();
                $data['house'] = DB::table('Masterdata.houses')->get();
                $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->pluck('application_no')
                    ->first();
                $data['xyz'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->first(['application_no', 'phone_no', 'worker_id']);
                $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_basic_details')->where('worker_id', $session_worker_id)->first();
                return view('existing-worker.worker-address-details', $data);
            }
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }


    public function saveExistingAddress(Request $request)
    {
        // dd($request->all());
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }

            $checkboxChecked = $request->has('do') && $request->input('do') == 1; // Replace 'do' with your actual checkbox field name

            $rules = [
                'worker_id' => 'unique:pgsql.Worker.temporary_worker_addresses',
                'c_residence' => 'required|string|exists:pgsql.Masterdata.residences,residence_code',
                'c_house_type' => 'required|exists:pgsql.Masterdata.houses,house_code',
                'c_house_no' => 'nullable|regex:/^\d+[a-zA-Z0-9\s\-\@#\$%\&\*\(\)\.\,\!\?\:]*$/',
                'c_road' => 'nullable',
                'c_area' => 'required',
                'c_city' => 'required',
                'c_state' => 'required',
                'c_district' => 'required',
                'c_post_office' => 'required',
                'c_pin' => 'required|digits:6',
                'landmark' => 'nullable',
                'c_circle' => 'required',

                // Custom validation for 'do' and 'type_of_document'
                'do' => 'nullable|boolean',
                'type_of_document' => 'nullable|integer',
            ];

            $messages = [
                'c_residence.required' => '⚠ Please Select',
                'c_house_type.required' => '⚠ Please Select',
                'c_house_no.required' => '⚠ House No Cannot be blank',
                'c_area.required' => '⚠ Area Name Cannot be blank',
                'c_city.required' => '⚠ Locality Cannot Be Blank',
                'c_district.required' => '⚠ District Cannot be blank',
                'c_circle.required' => '⚠ Sub-District Cannot be blank',
                'c_post_office.required' => '⚠ Post Office Cannot Be Blank',
                'c_pin.required' => '⚠ Pin Code Cannot Be Blank',
                'c_state.required' => '⚠ State Cannot be blank',
            ];

            // Validator instance
            $validator = Validator::make($request->all(), $rules, $messages);

            // Custom validation rule
            $validator->after(function ($validator) use ($request) {
                $doSelected = $request->has('do') && $request->input('do') == 1;
                $typeOfDocumentSelected = $request->filled('type_of_document');

                if (!$doSelected && !$typeOfDocumentSelected) {
                    $validator->errors()->add(
                        'do_or_type_of_document',
                        '⚠ Either "Copy Address" checkbox or "Type of Document" must be selected.'
                    );
                }
            });

            // Validation check
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            $data = TemporaryWorkerAddress::Create([
                'worker_id' => $request->worker_id,
                'application_no' => $data['application_no'],
                'c_residence' => $request->c_residence,
                'c_house_type' => $request->c_house_type,
                'c_house_no' => $request->c_house_no,
                'c_road' => $request->c_road,
                'c_area' => $request->c_area,
                'c_city' => $request->c_city,
                'c_state' => $request->c_state,
                'c_district' => $request->c_district,
                'c_post_office' => $request->c_post_office,
                'c_pin' => $request->c_pin,
                'c_circle' => $request->c_circle,
                'building' => $request->building_name,
                'landmark' => $request->landmark,
                'do' => $request->do,
                'type_of_document' => $request->type_of_document

            ]);
            Alert::toast('Address Details Submitted Successfully', 'success');
            return redirect()->route('submit-worker-address-details')->with('success');
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return back();
        }
    }

    public function updateExistingAddress(Request $request)
    {
        // dd($request->all());
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $rules = [
                'worker_id' => 'unique:pgsql.Worker.temporary_worker_addresses',
                'c_residence' => 'required|string|exists:pgsql.Masterdata.residences,residence_code',
                'c_house_type' => 'required|exists:pgsql.Masterdata.houses,house_code',
                'c_house_no' => 'nullable|regex:/^\d+[a-zA-Z0-9\s\-\@#\$%\&\*\(\)\.\,\!\?\:]*$/',
                'c_road' => 'nullable',
                'c_area' => 'required',
                'c_city' => 'required',
                'c_state' => 'required',
                'c_district' => 'required',
                'c_post_office' => 'required',
                'c_pin' => 'required|digits:6',
                'landmark' => 'nullable',
                'c_circle' => 'required',

                // Custom validation for 'do' and 'type_of_document'
                'do' => 'nullable|boolean',
                'type_of_document' => 'nullable|integer',
            ];

            $messages = [
                'c_residence.required' => '⚠ Please Select',
                'c_house_type.required' => '⚠ Please Select',
                'c_house_no.required' => '⚠ House No Cannot be blank',
                'c_area.required' => '⚠ Area Name Cannot be blank',
                'c_city.required' => '⚠ Locality Cannot Be Blank',
                'c_district.required' => '⚠ District Cannot be blank',
                'c_circle.required' => '⚠ Sub-District Cannot be blank',
                'c_post_office.required' => '⚠ Post Office Cannot Be Blank',
                'c_pin.required' => '⚠ Pin Code Cannot Be Blank',
                'c_state.required' => '⚠ State Cannot be blank',
            ];

            // Validator instance
            $validator = Validator::make($request->all(), $rules, $messages);

            // Custom validation rule
            $validator->after(function ($validator) use ($request) {
                $doSelected = $request->has('do') && $request->input('do') == 1;
                $typeOfDocumentSelected = $request->filled('type_of_document');

                if (!$doSelected && !$typeOfDocumentSelected) {
                    $validator->errors()->add(
                        'do_or_type_of_document',
                        '⚠ Either "Copy Address" checkbox or "Type of Document" must be selected.'
                    );
                }
            });

            // Validation check
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();

            $data = TemporaryWorkerAddress::where('worker_id', $session_worker_id)->update([
                'worker_id' => $session_worker_id,
                'c_residence' => $request->c_residence,
                'c_house_type' => $request->c_house_type,
                'c_house_no' => $request->c_house_no,
                'c_road' => $request->c_road,
                'c_area' => $request->c_area,
                'c_city' => $request->c_city,
                'c_state' => $request->c_state,
                'c_district' => $request->c_district,
                'c_post_office' => $request->c_post_office,
                'c_pin' => $request->c_pin,
                'c_circle' => $request->c_circle,
                'building' => $request->building_name,
                'landmark' => $request->landmark,
                'do' => $request->do,
                'type_of_document' => $request->type_of_document
            ]);

            Alert::toast('Address Details Updated Successfully', 'success');
            return redirect()->route('submit-worker-address-details')->with('success');
        } catch (Exception $e) {
//            return $e;
            Alert::toast("Something went Wrong", 'error');
            return back();
        }
    }

    /** passing id to bank details page */
    public function pageExistingBank(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_banks')
                ->where('worker_id', $session_worker_id)->first();

            if ($formdata) {
                $data['ifsc'] = DB::table('Worker.temporary_worker_banks as twbm')
                    // ->join('Masterdata.banks as bank', 'twbm.ifsc_pk', '=', 'bank.id')
                    ->where('worker_id', $session_worker_id)
                    ->select('twbm.*')
                    ->first();
                $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->pluck('application_no')
                    ->first();
                $data['xyz'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->first(['application_no', 'phone_no', 'worker_id']);
                return view('existing-worker/edit.edit-worker-bank-details', $data);

            } else {
                $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->pluck('application_no')
                    ->first();
                $apiResponse = json_decode(session('api_response'));
                $data['xyz'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->first(['application_no', 'phone_no', 'worker_id']);
                $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_addresses')->where('worker_id', $session_worker_id)->first();
                return view('existing-worker.worker-bank-details', $data, ['apiResponse' => $apiResponse]);
            }
        } catch (Exception $e) {
            // return $e;
            Alert::toast("Something went Wrong!", 'error');
            return back();
        }
    }

    public function saveExistingBank(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $validate = $request->validate([

            'bank_name' => 'required',
            'branch_name' => 'required',
            'bank_address' => 'required',
            'account_no' => 'required|numeric|digits_between:10,20',
            'account_no_confirmation' => 'required|numeric|digits_between:10,20'

        ], [
            'bank_name.required' => '⚠ Bank Number Cannot Be Blank',
            'branch_name.required' => '⚠ Branch Name Cannot Be Blank',
            'bank_address.required' => '⚠ Bank Address Cannot Be Blank',
            'account_no.required' => '⚠ Account No Cannot Be Blank',
            'account_no_confirmation.required' => '⚠ Confirmation of Account No Cannot Be Blank'

        ]);
        try {
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            $data = TemporaryWorkerBank::Create([
                'worker_id' => $session_worker_id,
                'application_no' => $data['application_no'],
                'ifsc_pk' => 000,
                'ifsc_code' => $request->ifsc_pk,
                'bank_name' => $request->bank_name,
                'branch_name' => $request->branch_name,
                'bank_address' => $request->bank_address,
                'account_no' => $request->account_no,

            ]);
            Alert::toast('Bank Details Submitted Successfully', 'success');
            return redirect()->route('submit-bank-details')->with('success');
        } catch (Exception $e) {
            Alert::toast("Something went Wrong!", 'error');
            return back();
        }
    }
    public function updateExistingBank(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        try {
            $validate = $request->validate([
                'bank_name' => 'required',
                'branch_name' => 'required',
                'bank_address' => 'required',
                'account_no' => 'required|numeric|digits_between:10,20',
                'account_no_confirmation' => 'required|numeric|digits_between:10,20'

            ], [
                'bank_name.required' => '⚠ Bank Number Cannot Be Blank',
                'branch_name.required' => '⚠ Branch Name Cannot Be Blank',
                'bank_address.required' => '⚠ Bank Address Cannot Be Blank',
                'account_no.required' => '⚠ Account No Cannot Be Blank',
                'account_no_confirmation.required' => '⚠ Confirmation of Account No Cannot Be Blank'

            ]);
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            $data = TemporaryWorkerBank::where('worker_id', $session_worker_id)->update([
                'ifsc_pk' => 000,
                'ifsc_code' => $request->ifsc_code,
                'application_no' => $data['application_no'],
                'bank_name' => $request->bank_name,
                'branch_name' => $request->branch_name,
                'bank_address' => $request->bank_address,
                'account_no' => $request->account_no,
            ]);
            Alert::toast('Bank Details Updated Successfully', 'success');
            return redirect()->route('submit-bank-details')->with('success');
        } catch (Exception $e) {
            Alert::toast("Something went Wrong!", 'error');
            return back();
        }
        //        return redirect()->route('submit-bank')->with('success');
    }

    public function pageExistingFamily(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('application_status', 'G')->count();
        $data['remarks'] = '';
        if ($remarks > 0) {
            $data['remarks'] = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                ->where('application_status', 'G')
                ->first();
        }

        try {

            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            // $vaultData = $this->getVaultData($request);
            // $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_families')->where('worker_id', $session_worker_id)->first();
            $data['states'] = State::all();
            $data['xyz'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->first(['application_no', 'phone_no', 'worker_id']);
            if ($formdata) {
                $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_families as twfm')
                    ->leftJoin('Worker.temporary_worker_forms as tfm', 'twfm.worker_id', '=', 'tfm.worker_id')
                    ->leftJoin('Worker.temporary_worker_basic_details as twbd', 'twfm.worker_id', '=', 'twbd.worker_id')
                    ->leftJoin('Masterdata.states as sta', 'twfm.already_registered_state', '=', 'sta.state_code')
                    ->leftJoin('Masterdata.relations as rel', 'twfm.relation', '=', 'rel.relation_code')
                    ->where('twfm.worker_id', $session_worker_id)
                    ->select('tfm.worker_id', 'twfm.*', 'rel.*', 'sta.*')
                    ->get();

                foreach ($data['formdata'] as $familyMember) {
                    $familyMember->age = Carbon::parse($familyMember->dob)->age;
                }

                $data['relations'] = DB::table('Masterdata.relations')
                    ->select('relation_code', 'relation_name')
                    ->get();

                return view('existing-worker/edit.edit-worker-family-details', $data);
            } else {
                $apiResponse = json_decode(session('api_response'));
                if (isset($apiResponse->nominee_name)) {
                    $fullName = $apiResponse->nominee_name;
                    $nameParts = explode(' ', $fullName, 2);
                    $firstName = isset($nameParts[0]) ? $nameParts[0] : '';
                    $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
                } else {
                    $firstName = '';
                    $lastName = '';
                }
                $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_forms as tfm')
                    ->join('Worker.temporary_worker_basic_details as twbd', 'tfm.worker_id', '=', 'twbd.worker_id')
                    ->where('tfm.worker_id', $session_worker_id)
                    ->select('tfm.*', 'twbd.*')
                    ->first();
                $data['relations'] = DB::table('Masterdata.relations')
                    ->select('relation_code', 'relation_name')
                    ->get();
                $data['firstName'] = $firstName;
                $data['lastName'] = $lastName;

                return view('existing-worker.worker-family-details', $data, ['apiResponse' => $apiResponse]);
            }
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", "error");
            return back();
        }
    }

    public function saveExistingFamily(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $familyValidator = Validator::make($request->all(), [
            'first_name' => 'required|array',
            'first_name.*' => 'required|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|array',
            'last_name.*' => 'required|regex:/^[a-zA-Z ]+$/',
            'guardain_name' => 'nullable|array',
            //            'guardain_name.*' => 'nullable|regex:/^[a-zA-Z ]+$/',
            'dob' => 'required|array',
            'age' => 'required|array',
            'age.*' => 'required|numeric',
            'dob.*' => 'required|date',
            'relation.*' => 'exists:pgsql.Masterdata.relations,relation_code',
            'relation_others.*' => function ($attribute, $value, $fail) use ($request) {
                if (is_array($request->input('relation')) && in_array('17', $request->input('relation'))) {
                    if (empty($value)) {
                        $fail('The relation others field is required when relation is Others');
                    } elseif (!is_string($value)) {
                        $fail('The relation others field must be a string.');
                    }
                }
            },
            'nominee' => 'required|array',
            'nominee.*' => 'required|in:0,1|regex:/^[01]$/',
            'bocwwb_id' => 'array',
            'bocwwb_id.*' => function ($attribute, $value, $fail) use ($request) {
                $index = explode('.', $attribute)[1]; // Get the index
                $already_registered = $request->input('already_registered')[$index] ?? null;
                $session_worker_id = session()->get('worker_id');

                // Skip validation if value is null or not marked as already registered
                if (is_null($value) || $already_registered != 1) {
                    return;
                }

                // Check for duplicate in the request itself
                $allBocIds = $request->input('bocwwb_id');
                foreach ($allBocIds as $i => $bocId) {
                    if ($i != $index && $value === $bocId) {
                        return $fail("⚠ BOCWWB ID {$value} is duplicated");
                    }
                }

                // Check uniqueness in the database (excluding current request)
                $inTemp = DB::table('Worker.temporary_worker_families')
                    ->where('bocwwb_id', $value)
                    ->where('worker_id', '!=', $session_worker_id)
                    ->count();

                $inMain = DB::table('Worker.main_worker_families')
                    ->where('bocwwb_id', $value)
                    ->where('worker_id', '!=', $session_worker_id)
                    ->count();

                if ($inTemp > 0 || $inMain > 0) {
                    return $fail("⚠ BOCWWB ID {$value} already exists in database");
                }
            },

            'nominee_percentage' => 'array',
            'nominee_percentage.*' => 'required_if:nominee.*,1',

            // Custom conditional validation for guardian name
            'guardain_name.*' => function ($attribute, $value, $fail) use ($request) {
                $index = explode('.', $attribute)[1]; // Get index of the array for individual row
                $age = $request->input('age')[$index];
                $nominee = $request->input('nominee')[$index];

                if ($age < 18 && $nominee == 1 && empty($value)) {
                    return $fail('⚠ Guardian name is required when age is below 18 and nominee is selected');
                }
            },
        ], [
            'first_name.*.required' => '⚠ First name cannot be blank',
            'last_name.*.required' => '⚠ Last name cannot be blank',
            'guardain_name.*.regex' => '⚠ Invalid Name',
            'relation.*.required' => '⚠ Please Select',
            'dob.*.required' => '⚠ Date of birth cannot be blank',
            'dob.*.date' => '⚠ The date of birth must be a valid date',
            'nominee.*.required' =>  '⚠ Please Select',
            'nominee_percentage.*.required_if' => '⚠ Nominee percentage field is required',
            'bocwwb_id.*.required_if' => '⚠ BOC Id field is required',
        ]);

        // Check if any validation fails (including the custom error)
        if ($familyValidator->fails()) {
            $errors = $familyValidator->errors()->messages();
            return response()->json(['success' => false, 'errors' => $errors], 200);
        }

        if (array_sum($request->input('nominee_percentage')) !== 100) {
            return response()->json([
                'success' => false,
                'errors' => ['nominee_percentage' => 'Total nominee share shall not be below 100']
            ], 200);
        }
        if (($request->input('age')) < 18) {
            return response()->json([
                'success' => false,
                'errors' => ['nominee_percentage' => 'Total nominee share shall not be below 100']
            ], 200);
        }

        $getVaultData = json_decode($this->getVaultDataService->getVaultData($session_worker_id, "T")->getData(), true);
        $applicant_name = trim($getVaultData['name']);


        $f_names = $request->first_name;
        $l_names = $request->last_name;

        $names = [];
        foreach ($f_names as $key => $f_name) {
            $full_name = trim($f_name . ' ' . $l_names[$key]);
            if (in_array($full_name, $names)) {
                return response()->json(['errors' => ['name' => "⚠ Duplicate entry for $f_name $l_names[$key]"]], 200);
            }
            if ($full_name === $applicant_name) {
                return response()->json(['errors' => ['name' => "⚠ Applicant's name cannot be added as a family member"]], 200);
            }

            $names[] = $full_name;
        }

        $bocwwbIds = $request->bocwwb_id;
        DB::beginTransaction();
        try {
            if (is_array($f_names) && !empty($f_names)) {
                foreach ($f_names as $key => $f_name) {
                    $bocwwbId = $bocwwbIds[$key];
                    // $existingRecordTemp = DB::table('Worker.temporary_worker_families')
                    //     ->whereIn('bocwwb_id', [$bocwwbId])
                    //     ->count();

                    // $existingRecordMain = DB::table('Worker.main_worker_families')
                    //     ->whereIn('bocwwb_id', [$bocwwbId])
                    //     ->count();
                    // if (($existingRecordTemp !== null && $existingRecordTemp > 0) || ($existingRecordMain !== null && $existingRecordMain > 0)) {
                    //     // DB::rollback();
                    //     return response()->json(['success' => false, 'msg' => 'false']);
                    // } else {
                    $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                        ->where('worker_id', $session_worker_id)
                        ->pluck('application_no')
                        ->first();
                    $data = TemporaryWorkerFamily::Create([
                        'worker_id' => $session_worker_id,
                        'application_no' => $data['application_no'],
                        'first_name' => $f_names[$key],
                        'last_name' => $l_names[$key],
                        'guardain_name' => $request->guardain_name[$key],
                        'dob' => $request->dob[$key],
                        'relation' => $request->relation[$key],
                        'relation_others' => $request->relation_others[$key] ?? null,
                        'nominee' => $request->nominee[$key],
                        'nominee_percentage' => $request->nominee_percentage[$key],
                        'already_registered' => $request->already_registered[$key] ?? null,
                        'already_registered_state' => $request->already_registered_state[$key] ?? null,
                        'bocwwb_id' => $request->bocwwb_id[$key] ?? null,
                    ]);
                    // }

                    if ($data != true) {
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'WTF001 Error Code']);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WTF002 Error Code']);
        }
        Alert::toast('Family Details Submitted Successfully', 'success');
        return response()->json(['success' => true, 'msg' => 'Family Details Submitted Successfully']);
    }

    public function deleteExFamilyMember(Request $request)
    {
        try {
            // Validate the ID
            $request->validate([
                'id' => 'required|integer|exists:pgsql.Worker.temporary_worker_families,id', // Replace 'family_members' with your actual table name
            ]);

            // Find the record and delete it
            $familyMember = TemporaryWorkerFamily::findOrFail($request->id); // Replace 'FamilyMember' with your actual model
            $familyMember->delete();

            return response()->json(['success' => true, 'message' => 'Family member deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete the family member.']);
        }
    }

    public function updateExistingFamily(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $familyValidator = Validator::make($request->all(), [
            'first_name' => 'required|array',
            'first_name.*' => 'required|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|array',
            'last_name.*' => 'required|regex:/^[a-zA-Z ]+$/',
            'guardain_name' => 'nullable|array',
            'dob' => 'required|array',
            'dob.*' => 'required|date',
            'relation.*' => 'exists:pgsql.Masterdata.relations,relation_code',
            'relation_others.*' => function ($attribute, $value, $fail) use ($request) {
                if (is_array($request->input('relation')) && in_array('17', $request->input('relation'))) {
                    if (empty($value)) {
                        $fail('The relation others field is required when relation is Others');
                    } elseif (!is_string($value)) {
                        $fail('The relation others field must be a string.');
                    }
                }
            },
            'nominee' => 'required|array',
            'nominee.*' => 'required|in:0,1|regex:/^[01]$/',
            'already_registered' => 'required|array',
            'already_registered.*' => 'required|in:0,1',
            'bocwwb_id' => 'array',
            'bocwwb_id.*' => function ($attribute, $value, $fail) use ($request) {
                $index = explode('.', $attribute)[1]; // Get the index
                $already_registered = $request->input('already_registered')[$index] ?? null;
                $session_worker_id = session()->get('worker_id');

                // Skip validation if value is null or not marked as already registered
                if (is_null($value) || $already_registered != 1) {
                    return;
                }

                // Check for duplicate in the request itself
                $allBocIds = $request->input('bocwwb_id');
                foreach ($allBocIds as $i => $bocId) {
                    if ($i != $index && $value === $bocId) {
                        return $fail("⚠ BOCWWB ID {$value} is duplicated");
                    }
                }

                // Check uniqueness in the database (excluding current request)
                $inTemp = DB::table('Worker.temporary_worker_families')
                    ->where('bocwwb_id', $value)
                    ->where('worker_id', '!=', $session_worker_id)
                    ->count();

                $inMain = DB::table('Worker.main_worker_families')
                    ->where('bocwwb_id', $value)
                    ->where('worker_id', '!=', $session_worker_id)
                    ->count();

                if ($inTemp > 0 || $inMain > 0) {
                    return $fail("⚠ BOCWWB ID {$value} already exists in database");
                }
            },

            'nominee_percentage' => 'array',
            'nominee_percentage.*' => 'required_if:nominee.*,1',
            'guardain_name.*' => function ($attribute, $value, $fail) use ($request) {
                $index = explode('.', $attribute)[1]; // Get index of the array for individual row
                $age = $request->input('age')[$index];
                $nominee = $request->input('nominee')[$index];

                if ($age < 18 && $nominee == 1 && empty($value)) {
                    return $fail('⚠ Guardian name is required when age is below 18 and nominee is selected');
                }
            },
        ], [
            'first_name.*.required' => '⚠ First name cannot be blank',
            'last_name.*.required' => '⚠ Last name cannot be blank',
            'guardain_name.*.regex' => '⚠ Invalid Name',
            'relation.*.required' => '⚠ Please Select',
            'dob.*.required' => '⚠ Date of birth cannot be blank',
            'dob.*.date' => '⚠ The date of birth must be a valid date',
            'nominee.*.required' =>  '⚠ Please Select',
            'nominee_percentage.*.required_if' => '⚠ Nominee percentage field is required',
            'bocwwb_id.*.required_if' => '⚠ BOC Id field is required',
            'already_registered.*.required' => '⚠ Please Select',
        ]);



        if ($familyValidator->fails()) {
            $errors = $familyValidator->errors()->messages();
            return response()->json(['success' => false, 'errors' => $errors], 200);
        }

        if (array_sum($request->input('nominee_percentage')) !== 100) {
            return response()->json([
                'success' => false,
                'errors' => ['nominee_percentage' => 'Total nominee share shall not be below 100']
            ], 200);
        }

        $getVaultData = json_decode($this->getVaultDataService->getVaultData($session_worker_id, "T")->getData(), true);
        $applicant_name = trim($getVaultData['name']);


        $f_names = $request->first_name;
        $l_names = $request->last_name;

        $names = [];
        foreach ($f_names as $key => $f_name) {
            $full_name = trim($f_name . ' ' . $l_names[$key]);
            if (in_array($full_name, $names)) {
                return response()->json(['errors' => ['name' => "⚠ Duplicate entry for $f_name $l_names[$key]"]], 200);
            }
            if ($full_name === $applicant_name) {
                return response()->json(['errors' => ['name' => "⚠ Applicant's name cannot be added as a family member"]], 200);
            }

            $names[] = $full_name;
        }
        DB::beginTransaction();
        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->pluck('application_no')
            ->first();

        try {
            if (is_array($f_names) && !empty($f_names)) {
                $affectedRows = DB::table('Worker.temporary_worker_families')
                    ->where('worker_id', $session_worker_id)->delete();
                foreach ($f_names as $key => $f_name) {
                    // $bocwwbId = $request->bocwwb_id[$key];
                    // $existingRecordTemp = DB::table('Worker.temporary_worker_families')
                    //     ->whereIn('bocwwb_id', [$bocwwbId])
                    //     ->count();

                    // $existingRecordMain = DB::table('Worker.main_worker_families')
                    //     ->whereIn('bocwwb_id', [$bocwwbId])
                    //     ->count();
                    // if (($existingRecordTemp !== null && $existingRecordTemp > 0) || ($existingRecordMain !== null && $existingRecordMain > 0)) {
                    //     // DB::rollback();
                    //     return response()->json(['success' => false, 'msg' => 'false']);
                    // } else {
                    $data = TemporaryWorkerFamily::Create([
                        'worker_id' => $session_worker_id,
                        'application_no' => $data['application_no'],
                        'first_name' => $f_names[$key],
                        'last_name' => $l_names[$key],
                        'guardain_name' => $request->guardain_name[$key],
                        'dob' => $request->dob[$key],
                        'relation' => $request->relation[$key],
                        'relation_others' => $request->relation_others[$key] ?? null,
                        'nominee' => $request->nominee[$key],
                        'nominee_percentage' => $request->nominee_percentage[$key],
                        'already_registered' => $request->already_registered[$key] ?? null,
                        'already_registered_state' => $request->already_registered_state[$key] ?? null,
                        'bocwwb_id' => $request->bocwwb_id[$key] ?? null,
                    ]);
                    // }

                    if ($data === false) {
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'WTF001 Error Code']);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WTF002 Database error']);
        }

        Alert::toast('Family Details Updated Successfully', 'success');
        return response()->json(['success' => true]);
    }


    public function showFiles($worker_id)
    {
        $twc = TemporaryWorkerCertificate::where('worker_id', $worker_id)->get();

        $filesForCertificates = [];

        foreach ($twc as $certificate) {

            $directory = 'private/certificate_proof/' . $worker_id . '/' . $certificate->worker_id;

            $files = [];

            // Check Local/Private Disk
            if (Storage::disk('local')->exists($directory)) {
                $files = Storage::disk('local')->files($directory);
            }

            // If not found, check Public Disk
            if (empty($files)) {

                $publicDirectory = str_replace('private/', '', $directory);

                if (Storage::disk('public')->exists($publicDirectory)) {
                    $files = Storage::disk('public')->files($publicDirectory);
                }
            }

            $filesForCertificates[$certificate->id] = $files;
        }

        return view('existing-worker/edit.edit-worker-employer-details', [
            'twc' => $twc,
            'filesForCertificates' => $filesForCertificates,
            'worker_id' => $worker_id
        ]);
    }


    // public function pageExistingEmployer(Request $request)
    // {
    //     $session_worker_id = session()->get('worker_id');
    //     if (!$session_worker_id) {
    //         return $this->sessionFlash();
    //     }
    //     try {
    //         $data['temp_employer'] = $employer = DB::table('Worker.temporary_worker_employer_details')
    //             ->where('worker_id', $session_worker_id)
    //             ->first();
    //         $data['application_no'] = DB::table('Worker.temporary_worker_forms')
    //             ->where('worker_id', $session_worker_id)
    //             ->pluck('application_no')
    //             ->first();
    //         $aadhar_data = session()->get('uid_data');
    //         $decoded_data = json_decode($aadhar_data, true);
    //         $encrypted_data = null;
    //         if (isset($decoded_data['encResponseData'])) {
    //             $encrypted_data = $decoded_data['encResponseData'];
    //         }
    //         $securityController = new SecurityController();
    //         $key = "VGHJnjhgvhfGCGVBhjghh45678iHgTFgvhbjnFFGHJ87FGHJRTYUIO";
    //         $licenceKey = $securityController->decrypt(env('LICENSE_KEY'), $key);
    //         $decrypted = AesCipher::decrypt($licenceKey, $encrypted_data);
    //         $data['uid_data'] = json_decode($decrypted);
    //         $vaultData = $this->getVaultData($request);
    //         $data['getVaultData'] = json_decode($vaultData->getData(), true);

    //         $temporary_certificate_data = DB::table('Worker.temporary_worker_certificates')
    //             ->where('worker_id', $session_worker_id)
    //             ->get();
    //         $employer_data = $employer ? json_decode(json_encode($employer), true) : [];
    //         $temporary_certificate_data = json_decode(json_encode($temporary_certificate_data), true);
    //         $data['formdata'] = $formdata = array_merge($employer_data, $temporary_certificate_data);
    //         $data['ndc'] = WorkerNinetyDaysCertificate::where('worker_id', $session_worker_id)->get();
    //         if ($formdata) {

    //             $data['twc'] = DB::table('Worker.temporary_worker_certificates as twc')
    //                 ->join('Masterdata.type_of_employers as toe', 'twc.type_of_employer', '=', 'toe.employer_code')
    //                 ->join('Masterdata.type_of_works as tow', 'twc.type_of_work', '=', 'tow.work_type_code')
    //                 ->join('Masterdata.professions as pro', 'twc.profession', '=', 'pro.profession_code')
    //                 ->where('twc.worker_id', $session_worker_id)
    //                 ->select(
    //                     'twc.worker_id',
    //                     'twc.application_no',
    //                     'twc.issue_date',
    //                     'twc.employer_name AS emp',
    //                     'twc.employer_contact_number',
    //                     'twc.from_date',
    //                     'twc.to_date',
    //                     'twc.type_of_employer',
    //                     'twc.date_count',
    //                     'twc.profession',
    //                     'toe.employer_code',
    //                     'toe.employer_name AS empname',
    //                     'twc.type_of_work',
    //                     'tow.work_type_code',
    //                     'tow.work_type_name',
    //                     'pro.*',
    //                 )
    //                 ->get();

    //             //            $filesForCertificates = [];
    //             //            foreach ($data['twc'] as $certificate) {
    //             //                $directory = 'private/certificate-proof/' . $session_worker_id;
    //             //
    //             //                $filesForCertificates[$certificate->worker_id] = Storage::files($directory);
    //             //            }

    //             //            foreach ($data['twc'] as &$certificate) {
    //             //                $certificate->files = $filesForCertificates[$certificate->worker_id] ?? [];
    //             //            }
    //             foreach ($data['twc'] as &$record) {

    //                 try {
    //                     $startDate = new DateTime($record->from_date);
    //                 } catch (\Exception $e) {
    //                 }
    //                 try {
    //                     $endDate = new DateTime($record->to_date);
    //                 } catch (\Exception $e) {
    //                 }
    //                 $dateInterval = $startDate->diff($endDate);
    //                 $record->number_of_days = $dateInterval->days;
    //             }
    //             $data['type_of_issuer'] = DB::table('Masterdata.type_of_issuers')
    //                 ->select('issuer_code', 'issuer_name')
    //                 ->get();
    //             $data['type_of_employers'] = DB::table('Masterdata.type_of_employers')
    //                 ->select('employer_code', 'employer_name')
    //                 ->get();
    //             $data['professions'] = DB::table('Masterdata.professions')
    //                 ->select('profession_code', 'profession_name')
    //                 ->get();
    //             $data['worktype'] = DB::table('Masterdata.type_of_works')
    //                 ->select('work_type_code', 'work_type_name')
    //                 ->get();
    //             $data['worknature'] = DB::table('Masterdata.nature_of_works')
    //                 ->select('nature_of_work_code', 'nature_of_work')
    //                 ->get();
    //             $data['application_no'] = DB::table('Worker.temporary_worker_forms')
    //                 ->where('worker_id', $session_worker_id)
    //                 ->pluck('application_no')
    //                 ->first();

    //             return view('existing-worker/edit.edit-worker-employer-details', $data);
    //         } else {
    //             $apiResponse = json_decode(session('api_response'));

    //             $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_families')
    //                 ->where('worker_id', $session_worker_id)
    //                 ->first();
    //             $data['type_of_issuer'] = DB::table('Masterdata.type_of_issuers')
    //                 ->select('issuer_code', 'issuer_name')
    //                 ->get();

    //             $data['worktype'] = DB::table('Masterdata.type_of_works')
    //                 ->select('work_type_code', 'work_type_name')
    //                 ->get();
    //             $data['worknature'] = DB::table('Masterdata.nature_of_works')
    //                 ->select('nature_of_work_code', 'nature_of_work')
    //                 ->get();
    //             $data['type_of_employers'] = DB::table('Masterdata.type_of_employers')
    //                 ->select('employer_code', 'employer_name')
    //                 ->get();
    //             $data['professions'] = DB::table('Masterdata.professions')
    //                 ->select('profession_code', 'profession_name')
    //                 ->get();
    //             return view('existing-worker.worker-employer-certificate', $data);
    //         }
    //     } catch (Exception $e) {
    //         Alert::toast('Something went wrong!', 'error');
    //         return back();
    //     }
    // }

    // public function saveExistingEmployer(Request $request)
    // {
    //     $session_worker_id = session()->get('worker_id');
    //     if (!$session_worker_id) {
    //         return $this->sessionFlash();
    //     }


    //     $employerValidator = Validator::make(
    //         $request->all(),
    //         [
    //             'type_of_issuer.*' => 'nullable|exists:pgsql.Masterdata.type_of_issuers,issuer_code',
    //             'issuing_org.*' => 'nullable|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
    //             'issue_date.*' => 'required|date',
    //             'issuing_person.*' => 'nullable|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
    //             'contact_issuing_person.*' => 'nullable|digits:10',
    //             'type_of_work.*' => 'required|exists:pgsql.Masterdata.type_of_works,work_type_code',
    //             'is_same.*' => 'nullable',
    //             'employer_name_certi.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
    //             'employer_contact_number.*' => 'required|numeric',
    //             'from_date.*' => 'required|date',
    //             'to_date.*' => 'required|date',
    //             'date_count.*' => 'required|numeric',
    //             'type_of_employer.*' => 'required|exists:pgsql.Masterdata.type_of_employers,employer_code',
    //         ],
    //         [
    //             'type_of_issuer.*' => '⚠ Please Select.',
    //             'issuing_org.*' => '⚠ The Name of Issuing Organization Cannot Be Blank.',
    //             'issue_date.*.required' => '⚠ The Date of issue Cannot Be Blank.',
    //             'issuing_person.*' => '⚠ The Name of Issuing Person Cannot Be Blank.',
    //             'contact_issuing_person.*' => '⚠ The Contact No of Issuing Person Cannot Be Blank.',
    //             'contact_issuing_person.*.numeric' => '⚠ Contact No of Issuing Person Should be a number.',
    //             'type_of_work.*.required' => '⚠ Please Select.',
    //             'is_same.*' => '⚠ Please Select.',
    //             'employer_name_certi.*.required' => '⚠ The Employer Name Cannot Be Blank.',
    //             'employer_contact_number.*.required' => '⚠ The Employer Contact Number Cannot Be Blank.',
    //             'employer_contact_number.*.numeric' => '⚠ Employer Contact Number Should be a number',
    //             'from_date.*.required' => '⚠ The From Date Cannot Be Blank.',
    //             'from_date.*.date' => '⚠ Please enter a valid date.',
    //             'to_date.*.required' => '⚠ The To Date Cannot Be Blank.',
    //             'to_date.*.date' => '⚠ Please enter a valid date.',
    //             'date_count.*.required' => '⚠ The Date Count Cannot Be Blank.',
    //             'type_of_employer.*.required' => '⚠ Please Select.',
    //         ]
    //     );

    //     if ($employerValidator->fails()) {
    //         return response()->json(['errors' => $employerValidator->errors()], 200);
    //     }
    //     $data['application_no'] = DB::table('Worker.temporary_worker_forms')
    //         ->where('worker_id', $session_worker_id)
    //         ->pluck('application_no')
    //         ->first();

    //     try {
    //         DB::beginTransaction();
    //         $certificateData = [];
    //         $filePaths = [];
    //         $f_names = $request->issue_date;
    //         if (is_array($f_names) && !empty($f_names)) {
    //             $files = $request->file('certificate_proof');
    //             foreach ($files as $key => $file) {
    //                 if ($file) {
    //                     $originalName = $file->extension();
    //                     $string = Str::uuid();
    //                     $certificate_proof_name = 'certificate-proof/' . $session_worker_id . '/' . $string . '.' . $originalName;
    //                     Storage::disk('public')->put($certificate_proof_name, file_get_contents($file->getRealPath()));
    //                     $filePaths[] = "/private/{$certificate_proof_name}";
    //                 }
    //             }
    //             foreach ($f_names as $key => $f_name) {
    //                 $certificateData[] = TemporaryWorkerCertificate::create([
    //                     'worker_id' => $session_worker_id,
    //                     'application_no' => $data['application_no'],
    //                     'issue_date' => $request->issue_date[$key],
    //                     'type_of_work' => $request->type_of_work[$key],
    //                     'employer_name' => $request->employer_name_certi[$key],
    //                     'employer_contact_number' => $request->employer_contact_number[$key],
    //                     'from_date' => $request->from_date[$key],
    //                     'to_date' => $request->to_date[$key],
    //                     'date_count' => $request->date_count[$key],
    //                     'type_of_employer' => $request->type_of_employer[$key],
    //                     'profession' => $request->profession[$key],
    //                     'profession_others' => $request->profession_others[$key] ?? null,
    //                 ]);
    //             }
    //             foreach ($filePaths as $filePath) {
    //                 WorkerNinetyDaysCertificate::create([
    //                     'worker_id' => $session_worker_id,
    //                     'ninety_days_certificate' => $filePath
    //                 ]);
    //             }
    //             if (empty($certificateData)) {
    //                 DB::rollback();
    //                 return response()->json(['success' => false, 'msg' => 'WEC001, Something Went Wrong!']);
    //             }
    //         }
    //         DB::commit();
    //         Alert::toast('Certificate Details Submitted!', 'success');
    //         return response()->json(['success' => true, 'msg' => 'Certificates uploaded successfully.']);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json(['success' => false, 'msg' => 'WEC002, Something Went Wrong!', 'error' => $e->getMessage()]);
    //     }
    // }


    // public function updateExistingEmployer(Request $request)
    // {
    //     // dd($request->all());
    //     $session_worker_id = session()->get('worker_id');
    //     if (!$session_worker_id) {
    //         return $this->sessionFlash();
    //     }


    //     $employerValidator = Validator::make(
    //         $request->all(),
    //         [
    //             'type_of_issuer.*' => 'nullable|exists:pgsql.Masterdata.type_of_issuers,issuer_code',
    //             'issuing_org.*' => 'nullable|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
    //             'issue_date.*' => 'required|date',
    //             'issuing_person.*' => 'nullable|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
    //             'contact_issuing_person.*' => 'nullable|digits:10',
    //             'type_of_work.*' => 'required|exists:pgsql.Masterdata.type_of_works,work_type_code',
    //             'is_same.*' => 'nullable',
    //             'employer_name_certi.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
    //             'employer_contact_number.*' => 'required|numeric',
    //             'from_date.*' => 'required|date',
    //             'to_date.*' => 'required|date',
    //             'date_count.*' => 'required|numeric',
    //             'type_of_employer.*' => 'required|exists:pgsql.Masterdata.type_of_employers,employer_code',
    //         ],
    //         [
    //             'type_of_issuer.*' => '⚠ Please Select.',
    //             'issuing_org.*' => '⚠ The Name of Issuing Organization Cannot Be Blank.',
    //             'issue_date.*.required' => '⚠ The Date of issue Cannot Be Blank.',
    //             'issuing_person.*' => '⚠ The Name of Issuing Person Cannot Be Blank.',
    //             'contact_issuing_person.*' => '⚠ The Contact No of Issuing Person Cannot Be Blank.',
    //             'contact_issuing_person.*.numeric' => '⚠ Contact No of Issuing Person Should be a number.',
    //             'type_of_work.*.required' => '⚠ Please Select.',
    //             'is_same.*' => '⚠ Please Select.',
    //             'employer_name_certi.*.required' => '⚠ The Employer Name Cannot Be Blank.',
    //             'employer_contact_number.*.required' => '⚠ The Employer Contact Number Cannot Be Blank.',
    //             'employer_contact_number.*.numeric' => '⚠ Employer Contact Number Should be a number',
    //             'from_date.*.required' => '⚠ The From Date Cannot Be Blank.',
    //             'from_date.*.date' => '⚠ Please enter a valid date.',
    //             'to_date.*.required' => '⚠ The To Date Cannot Be Blank.',
    //             'to_date.*.date' => '⚠ Please enter a valid date.',
    //             'date_count.*.required' => '⚠ The Date Count Cannot Be Blank.',
    //             'type_of_employer.*.required' => '⚠ Please Select.',
    //         ]
    //     );

    //     if ($employerValidator->fails()) {
    //         return response()->json(['errors' => $employerValidator->errors()], 200);
    //     }
    //     $data['application_no'] = DB::table('Worker.temporary_worker_forms')
    //         ->where('worker_id', $session_worker_id)
    //         ->pluck('application_no')
    //         ->first();
    //     DB::beginTransaction();
    //     try {
    //         $certificateData = [];
    //         $filePaths = [];
    //         $f_names = $request->issue_date;

    //         if (is_array($f_names) && !empty($f_names)) {
    //             $files = $request->file('certificate_proof');
    //             $filePaths = [];
    //             if ($files) {
    //                 foreach ($files as $key => $file) {
    //                     if ($file) {
    //                         $originalName = $file->extension();
    //                         $string = Str::uuid();
    //                         $certificate_proof_name = 'certificate-proof/' . $session_worker_id . '/' . $string . '.' . $originalName;
    //                         Storage::disk('public')->put($certificate_proof_name, file_get_contents($file->getRealPath()));
    //                         $filePaths[$key] = "/private/{$certificate_proof_name}";
    //                     }
    //                 }
    //             }
    //             foreach ($f_names as $key => $f_name) {
    //                 $existingRecord = TemporaryWorkerCertificate::where('worker_id', $session_worker_id)
    //                     ->where('issue_date', $f_name)
    //                     ->first();

    //                 $data = [
    //                     'worker_id' => $session_worker_id,
    //                     'application_no' => $data['application_no'],
    //                     'issue_date' => $request->issue_date[$key],
    //                     'type_of_work' => $request->type_of_work[$key],
    //                     'employer_name' => $request->employer_name_certi[$key],
    //                     'employer_contact_number' => $request->employer_contact_number[$key],
    //                     'from_date' => $request->from_date[$key],
    //                     'to_date' => $request->to_date[$key],
    //                     'date_count' => $request->date_count[$key],
    //                     'type_of_employer' => $request->type_of_employer[$key],
    //                     'profession' => $request->profession[$key],
    //                     'profession_others' => $request->profession_others[$key] ?? null,
    //                 ];

    //                 // Add file path if available
    //                 if (isset($filePaths[$key])) {
    //                     $data['certificate_proof'] = $filePaths[$key];
    //                 }

    //                 if ($existingRecord) {
    //                     // If the record exists, update it
    //                     $existingRecord->update($data);
    //                 } else {
    //                     // If the record does not exist, create a new one
    //                     TemporaryWorkerCertificate::create($data);
    //                 }
    //             }

    //             // Save file paths for WorkerNinetyDaysCertificate
    //             foreach ($filePaths as $filePath) {
    //                 WorkerNinetyDaysCertificate::create([
    //                     'worker_id' => $session_worker_id,
    //                     'ninety_days_certificate' => $filePath,
    //                 ]);
    //             }
    //         }
    //         DB::commit();
    //     } catch (\Exception $e) {

    //         DB::rollback();
    //         return response()->json(['success' => false, 'msg' => 'WEC001,Database Exception Error']);
    //     }
    //     Alert::toast('Certificate Details Updated Successfully', 'success');
    //     return response()->json(['success' => true, 'msg' => 'Certificate Details Updated!']);
    // }

    public function pageExistingSchemes(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
        $data['getVaultData'] = json_decode($vaultData->getData(), true);
        try {
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();

            $data['xyz'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->first(['application_no', 'phone_no', 'worker_id']);

            $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_schemes')->where('worker_id', $session_worker_id)->first();
            if ($formdata) {
                $data['tws'] = DB::table('Worker.temporary_worker_schemes as tws')
                    ->leftjoin('Masterdata.schemes as sch', 'tws.scheme_name', '=', 'sch.scheme_code')
                    ->where('tws.worker_id', $session_worker_id)
                    ->select('tws.*', 'sch.*')
                    ->get();

                $data['schemes'] = DB::table('Masterdata.schemes')
                    ->select('scheme_code', 'scheme_name')->get();
                return view('existing-worker.edit.edit-worker-schemes', $data);
            } else {

                $data['schemes'] = DB::table('Masterdata.schemes')
                    ->select('scheme_code', 'scheme_name')->get();
                return view('existing-worker.worker-schemes-details', $data);
            }
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }

    public function saveExistingScheme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enrolled' => 'required|in:1,0',
            'scheme_name' => 'nullable|array',
            'scheme_name.*' => 'nullable|exists:pgsql.Masterdata.schemes,scheme_code',
            'registration_id' => 'required_if:enrolled,1|array',
            'registration_id.*' => 'nullable|required_if:enrolled,1|regex:/^[A-Za-z0-9\-]+$/',
            'date.*' => 'nullable|date',
        ], [
            'enrolled.required' => '⚠ The Enrolled field is required.',
            'enrolled.in' => '⚠ The selected enrolled value is invalid.',

            'scheme_name.required_if' => '⚠ Scheme Name cannot be blank.',
            'scheme_name.*.required_if' => '⚠ Scheme Name cannot be blank.',
            'scheme_name.*.string' => '⚠ Scheme Name must be a string.',
            'scheme_name.*.max' => '⚠ Scheme Name may not be greater than 255 characters.',

            'registration_id.required_if' => '⚠ The Registration ID cannot be blank.',
            'registration_id.*.required_if' => '⚠ Registration ID cannot be blank.',
            'registration_id.*.regex' => '⚠ Registration ID must consist of letters, numbers, and hyphens only.',
            'date.*.date' => '⚠ Date of Registration must be a valid date.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            return response()->json(['errors' => $errors], 200);
        }
        $schemes = $request->scheme_name;
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->pluck('application_no')
            ->first();
        DB::beginTransaction();
        try {
            if (is_array($schemes) && !empty($schemes)) {
                foreach ($schemes as $key => $scheme) {
                    $enrolled = $request->enrolled;
                    if ($enrolled == 0) {
                        $schemeName = null;
                        $registrationId = null;
                        $date = null;
                    } else {
                        $schemeName = $schemes[$key];
                        $registrationId = $request->registration_id[$key];
                        $date = $request->date[$key];
                    }
                    $data[] = TemporaryWorkerScheme::create([
                        'worker_id' => $session_worker_id,
                        'application_no' => $data['application_no'],
                        'scheme_name' => $schemeName,
                        'enrolled' => $enrolled,
                        'registration_id' => $registrationId,
                        'date' => $date,
                    ]);
                    if ($data != true) {
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'WSC001,Database Exception Error']);
                    }
                }
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WSC001,Database Exception Error']);
        }
        Alert::toast('Scheme Details Submitted Successfully', 'success');
        return response()->json(['success' => true, 'msg' => 'Scheme Details Submitted!']);
    }

    public function updateExistingScheme(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'enrolled' => 'required|in:1,0',
            'scheme_name' => 'required_if:enrolled,1|array',
            'scheme_name.*' => 'nullable|required_if:enrolled,1|exists:pgsql.Masterdata.schemes,scheme_code',
            'registration_id' => 'required_if:enrolled,1|array',
            'registration_id.*' => 'nullable|required_if:enrolled,1|regex:/^[A-Za-z0-9\-]+$/',
            'date.*' => 'nullable|date',
        ], [
            'enrolled.required' => '⚠ The Enrolled field is required.',
            'enrolled.in' => '⚠ The selected enrolled value is invalid.',

            'scheme_name.required_if' => '⚠ Scheme Name cannot be blank.',
            'scheme_name.*.required_if' => '⚠ Scheme Name cannot be blank.',
            'scheme_name.*.string' => '⚠ Scheme Name must be a string.',
            'scheme_name.*.max' => '⚠ Scheme Name may not be greater than 255 characters.',

            'registration_id.required_if' => '⚠ The Registration ID cannot be blank.',
            'registration_id.*.required_if' => '⚠ Registration ID cannot be blank.',
            'registration_id.*.regex' => '⚠ Registration ID must consist of letters, numbers, and hyphens only.',
            'date.*.date' => '⚠ Date of Registration must be a valid date.',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            return response()->json(['errors' => $errors], 200);
        }

        $schemes = $request->scheme_name;
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->pluck('application_no')
            ->first();
        try {
            if (is_array($schemes) && !empty($schemes)) {
                $affectedRows = DB::table('Worker.temporary_worker_schemes')
                    ->where('worker_id', $session_worker_id)->delete();

                foreach ($schemes as $key => $scheme) {
                    $enrolled = $request->enrolled;

                    if ($enrolled == 0) {
                        $schemeName = null;
                        $registrationId = null;
                        $date = null;
                    } else {
                        $schemeName = $schemes[$key];
                        $registrationId = $request->registration_id[$key];
                        $date = $request->date[$key];
                    }
                    $data[] = TemporaryWorkerScheme::create([
                        'worker_id' => $session_worker_id,
                        'application_no' => $data['application_no'],
                        'scheme_name' => $schemeName,
                        'enrolled' => $enrolled,
                        'registration_id' => $registrationId,
                        'date' => $date,
                    ]);

                    if ($data != true) {
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'WSD001,Something Went Wrong!']);
                    }
                }
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WSC001,Database Exception Error']);
        }
        Alert::toast('Scheme Details Updated Successfully', 'success');
        return response()->json(['success' => true]);
    }

    public function pageExistingDocument(Request $request)
    {

        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('application_status', 'G')->count();
        $data['remarks'] = '';
        if ($remarks > 0) {
            $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                ->where('application_status', 'G')
                ->first();
        }

        try {
            $formdata = TemporaryWorkerDocument::where('worker_id', $session_worker_id)->first();

            $has_ration_card = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('has_ration_card')
                ->first();

            $has_do_address = DB::table('Worker.temporary_worker_addresses')
                ->where('worker_id', $session_worker_id)
                ->pluck('do')
                ->first();



            $has_pan = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('pan')
                ->first();

            $has_type_of_document = DB::table('Worker.temporary_worker_addresses')
                ->where('worker_id', $session_worker_id)
                ->pluck('type_of_document')
                ->first();

            $has_subscription_receipt = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('subscription_receipt')
                ->first();

            $readonly = true;
            $emptyField = null;

            if ($formdata) {
                foreach ($formdata->getAttributes() as $key => $value) {
                    if (trim($value) === '') {
                        $emptyField = $key;
                        $readonly = true;
                        break;
                    } else {
                        $readonly = false;
                    }
                }
            }
            //        try {
            //
            //            $vaultData = $this->getVaultData($request);
            //            if ($vaultData->getS === 200) {
            //                $getVaultData = json_decode($vaultData->getData(), true);
            //            } else {
            //                return response()->json(['error' => 'Failed to fetch data from vault.'], 500);
            //            }
            //        } catch (\Exception $e) {
            //            return response()->json(['error' => 'Unable to connect to the vault service. Please try again later.'], 500);
            //        }
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $getVaultData = $data['getVaultData'] = json_decode($vaultData->getData(), true);
            //
            $base64Image = $getVaultData['photo'];
            if (($emptyField == 'ration_card' && $has_ration_card == 0) || ($emptyField == 'pan_card' && $has_pan == 0) || ($emptyField == 'do' && $has_do_address == 1)) {
                $readonly = false;
            }

            $application_no = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            $worker_id = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('worker_id')
                ->first();
            $twd = DB::table('Worker.temporary_worker_documents as twd')
                ->where('worker_id', $session_worker_id)
                ->first();

            $documents = collect([
                ['id' => 1, 'name' => 'residential_proof', 'label' => 'Present Address Proof ', 'uploaded' => !empty($twd->residential_proof)],
                ['id' => 2, 'name' => 'old_id_card', 'label' => 'Existing Assam BOCW ID Card', 'uploaded' => !empty($twd->old_id_card)],
                ['id' => 3, 'name' => 'subscription_payment_receipt', 'label' => 'Subscription Payment receipt', 'uploaded' => !empty($twd->subscription_payment_receipt)],
                ['id' => 4, 'name' => 'worker_bank_copy', 'label' => 'Bank Passbook Copy (Aadhar Linked Bank Account)', 'uploaded' => !empty($twd->worker_bank_copy)],
                ['id' => 5, 'name' => 'ration_card', 'label' => 'Ration Card', 'uploaded' => !empty($twd->ration_card)],
                ['id' => 7, 'name' => 'pan_card', 'label' => 'PAN Card', 'uploaded' => !empty($twd->pan_card)],

            ]);
            // return $has_ration_card;
            return view('existing-worker.worker-documents-details', compact(
                'twd',
                'readonly',
                'application_no',
                'has_ration_card',
                'has_pan',
                'documents',
                'has_do_address',
                'has_type_of_document',
                'base64Image',
                'getVaultData',
                'worker_id',
                'remarks',
                'has_subscription_receipt'
            ));
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }

    public function saveExistingDocument(Request $request)
    {
        try {
            $mimes = env('DOCUMENT_MIME_TYPES');

            $session_worker_id = session()->get('worker_id');

            $validator = Validator::make(
                $request->all(),
                [
                    "document_id" => ['required', 'in:1,2,3,4,5,6,7,8'],
                    "residential_proof" => 'required_if:document_id,1|mimes:pdf',
                    "old_id_card" => 'required_if:document_id,2|mimes:pdf',
                    "subscription_payment_receipt" => 'required_if:document_id,3|mimes:pdf',
                    "worker_bank_copy" => 'required_if:document_id,4|mimes:pdf',
                    "ration_card" => 'required_if:document_id,5|mimes:pdf',
                    "nominee_bank_copy" => 'required_if:document_id,6|mimes:pdf',
                    "pan_card" => 'required_if:document_id,7|mimes:pdf',
                    "work_book" => 'required_if:document_id,8|mimes:pdf'
                ]
            );

            if ($validator->fails()) {
                Alert::toast($validator->errors()->first());
                return back()->with('message', $validator->errors()->first());
            }


            $generateUUID = (string)Str::orderedUuid();

            $count = TemporaryWorkerDocument::where('worker_id', $session_worker_id);
            if ($count->count() > 0) {
                $temporaryWorker = $count->first();
            } else {
                $temporaryWorker = new TemporaryWorkerDocument();
            }
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();

            $temporaryWorker->application_no = $data['application_no'];


            if ($request->document_id == 1) {

                $residential_proof_name =  'Present-address-proof/' . $session_worker_id . $generateUUID . '.' . $request->residential_proof->extension();

                Storage::disk('public')->put($residential_proof_name, file_get_contents($request->residential_proof->getRealPath()));

                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->residential_proof = "/private/{$residential_proof_name}";
                $temporaryWorker->res_proof_ext = $request->residential_proof->extension();
                $temporaryWorker->save();
                Alert::toast("Present Address Proof Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 2) {

                $sessionWorkerId = $request->session()->get('worker_id'); // or however you're getting the session worker ID
                $generateUUID = (string) \Illuminate\Support\Str::uuid();

                $oldIdCard = 'BOC-Card/' . $sessionWorkerId . $generateUUID . '.' . $request->old_id_card->extension();
                Log::info('Old ID Card Path: ' . $oldIdCard);
                Storage::disk('public')->put($oldIdCard, file_get_contents($request->old_id_card->getRealPath()));

                $temporaryWorker->worker_id = $sessionWorkerId;
                $temporaryWorker->old_id_card = "/private/{$oldIdCard}";
                $temporaryWorker->old_id_card_ext = $request->old_id_card->extension();
             $temporaryWorker->save();

                Alert::toast("BOC ID Card Uploaded successfully", "success");
                return redirect()->back();
            }


            if ($request->document_id == 3) {


                $subscription_payment_receipt =  'Subscription-Receipt/' . $session_worker_id . $generateUUID . '.' . $request->subscription_payment_receipt->extension();
                Storage::disk('public')->put($subscription_payment_receipt, file_get_contents($request->subscription_payment_receipt->getRealPath()));

                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->subscription_payment_receipt = "/private/{$subscription_payment_receipt}";
                $temporaryWorker->subscription_ext = $request->subscription_payment_receipt->extension();
                $temporaryWorker->save();
                Alert::toast("Subscription Receipt Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 4) {

                $worker_bank_copy =  'worker-bank-photocopy/' . $session_worker_id . $generateUUID . '.' . $request->worker_bank_copy->extension();
                Storage::disk('public')->put($worker_bank_copy, file_get_contents($request->worker_bank_copy->getRealPath()));

                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->worker_bank_copy = "/private/{$worker_bank_copy}";
                $temporaryWorker->worker_bank_copy_ext = $request->worker_bank_copy->extension();
                $temporaryWorker->save();
                Alert::toast("Bank Copy Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 5) {
                $ration_card =  'ration-card/' . $session_worker_id . $generateUUID . '.' . $request->ration_card->extension();
                Storage::disk('public')->put($ration_card, file_get_contents($request->ration_card->getRealPath()));


                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->ration_card = "/private/{$ration_card}";
                $temporaryWorker->ration_card_ext = $request->ration_card->extension();
                $temporaryWorker->save();

                Alert::toast("Ration Card Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 6) {


                $nominee_bank_copy =  'nominee-bank-copy/' . $session_worker_id . $generateUUID . '.' . $request->nominee_bank_copy->extension();
                Storage::disk('public')->put($nominee_bank_copy, file_get_contents($request->nominee_bank_copy->getRealPath()));


                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->nominee_bank_copy = "/private/{$nominee_bank_copy}";
                $temporaryWorker->nominee_bank_copy_ext = $request->nominee_bank_copy->extension();
                $temporaryWorker->save();

                Alert::toast("Nominee Bank Copy Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 7) {

                $pan_card =  'pan-card/' . $session_worker_id . $generateUUID . '.' . $request->pan_card->extension();
                Storage::disk('public')->put($pan_card, file_get_contents($request->pan_card->getRealPath()));


                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->pan_card = "/private/{$pan_card}";
                $temporaryWorker->pan_card_ext = $request->pan_card->extension();
                $temporaryWorker->save();

                Alert::toast("Pan Card Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 8) {

                $work_book =  'work-book/' . $session_worker_id . $generateUUID . '.' . $request->work_book->extension();
                Storage::disk('public')->put($work_book, file_get_contents($request->work_book->getRealPath()));


                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->work_book = "/private/{$work_book}";
                $temporaryWorker->work_book_ext = $request->work_book->extension();
                $temporaryWorker->save();

                Alert::toast("Work Book Uploaded successfully", "success");
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::toast('Something went wrong!', 'error');
            return back();
        }
    }


    /** Go to preview page */
    public  function previewPageExisting(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('application_status', 'G')->count();
        $data['remarks'] = '';
        if ($remarks > 0) {
            $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                ->where('application_status', 'G')
                ->first();
        }

        try {
            $apiResponse = json_decode(session('api_response'));
            $maskAadharNumber = function ($aadharNumber) {
                return str_repeat('*', 8) . substr($aadharNumber, 8);
            };

            //$vaultData = $this->getVaultData($request);
            //$getVaultData = json_decode($vaultData->getData(), true);
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $getVaultData = json_decode($vaultData->getData(), true);

            $base64Image = $getVaultData['photo'];


            if (isset($getVaultData['uID'])) {
                $getVaultData['uID'] = $maskAadharNumber($getVaultData['uID']);
            }

            $ndc = WorkerNinetyDaysCertificate::where('worker_id', $session_worker_id)->get();
            $dists = District::where('state_code', '=', 18)->get();

            $worker_details = TemporaryWorkerForm::where('worker_id', $session_worker_id)->first();
            $card = BocwCard::where('worker_id', $session_worker_id)->count();
            $existing_card = '';
            if ($card) {
                $existing_card = BocwCard::where('worker_id', $session_worker_id)->first();
            }
            $hasReceipt = null;
            $subscription_receipt = null;
            $hasReceipt = TemporaryWorkerDocument::whereNotNull('subscription_payment_receipt')->where('worker_id', $session_worker_id)->exists();
            if ($hasReceipt) {
                $subscription_receipt = true;
            } else {
                $subscription_receipt = false;
            }

            return view('existing-worker.worker-application-preview', compact('worker_details', 'getVaultData', 'apiResponse', 'base64Image', 'ndc', 'remarks', 'existing_card', 'dists','subscription_receipt'));
        } catch (Exception $e) {
//            return $e;
            Alert::toast('Something went Wrong!', 'error');
            return back();
        }
    }

    private function getDocumentFile($dbPath)
    {
        $localPath = ltrim($dbPath, '/');

        if (Storage::disk('local')->exists($localPath)) {
            return Storage::disk('local')->path($localPath);
        }

        $publicPath = str_replace('/private/', '', $dbPath);

        if (Storage::disk('public')->exists($publicPath)) {
            return Storage::disk('public')->path($publicPath);
        }

        return null;
    }


    public function getSubscription()
    {
        $session_worker_id = session()->get('worker_id');

        $subscription = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$subscription || !$subscription->subscription_payment_receipt) {
            abort(404, 'Subscription receipt not found');
        }

        $dbPath = $subscription->subscription_payment_receipt;

        // Check Local/Private Storage
        $localPath = ltrim($dbPath, '/');

        if (Storage::disk('local')->exists($localPath)) {
            return response()->file(
                Storage::disk('local')->path($localPath)
            );
        }

        // Check Public Storage
        $publicPath = str_replace('/private/', '', $dbPath);

        if (Storage::disk('public')->exists($publicPath)) {
            return response()->file(
                Storage::disk('public')->path($publicPath)
            );
        }

        abort(404, 'Subscription receipt file not found');
    }


    public function getCertificate($id)
    {
        $session_worker_id = session()->get('worker_id');

        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $cert_proof = WorkerNinetyDaysCertificate::where('worker_id', $session_worker_id)
            ->where('id', $id)
            ->first();

        if (!$cert_proof || !$cert_proof->ninety_days_certificate) {
            abort(404, 'Certificate not found');
        }

        $dbPath = $cert_proof->ninety_days_certificate;

        // Check Local/Private Storage
        $localPath = ltrim($dbPath, '/');

        if (Storage::disk('local')->exists($localPath)) {
            return response()->file(
                Storage::disk('local')->path($localPath)
            );
        }

        // Check Public Storage
        $publicPath = str_replace('/private/', '', $dbPath);

        if (Storage::disk('public')->exists($publicPath)) {
            return response()->file(
                Storage::disk('public')->path($publicPath)
            );
        }

        abort(404, 'Certificate file not found');
    }

    public function getResProof()
    {
        $session_worker_id = session()->get('worker_id');

        $res_proof = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$res_proof || !$res_proof->residential_proof) {
            abort(404, 'Residential proof not found');
        }

        $dbPath = $res_proof->residential_proof;

        // Check private/local storage first
        $localPath = ltrim($dbPath, '/');

        if (Storage::disk('local')->exists($localPath)) {
            return response()->file(
                Storage::disk('local')->path($localPath)
            );
        }

        // Fallback to public storage
        $publicPath = str_replace('/private/', '', $dbPath);

        if (Storage::disk('public')->exists($publicPath)) {
            return response()->file(
                Storage::disk('public')->path($publicPath)
            );
        }

        abort(404, 'Residential proof file not found');
    }

    public function getBOCCard()
    {
        $session_worker_id = session()->get('worker_id');

        $boc = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        $dbPath = $boc->old_id_card; // /private/pan-card/abc.pdf

        // Check private/local location first
        if (Storage::disk('local')->exists(ltrim($dbPath, '/'))) {
            return response()->file(
                Storage::disk('local')->path(ltrim($dbPath, '/'))
            );
        }

        // Convert /private/... to actual public disk path
        $publicPath = str_replace('/private/', '', $dbPath);

        if (Storage::disk('public')->exists($publicPath)) {
            return response()->file(
                Storage::disk('public')->path($publicPath)
            );
        }

        abort(404, 'Document not found');
    }

    public function getBankXerox()
    {
        $session_worker_id = session()->get('worker_id');

        $bank_copy = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$bank_copy || !$bank_copy->worker_bank_copy) {
            abort(404, 'Document not found');
        }

        $dbPath = $bank_copy->worker_bank_copy;

        // Check local/private storage first
        $localPath = ltrim($dbPath, '/');

        if (Storage::disk('local')->exists($localPath)) {
            return response()->file(
                Storage::disk('local')->path($localPath)
            );
        }

        // Fallback: file may actually be in public storage
        $publicPath = str_replace('/private/', '', $dbPath);

        if (Storage::disk('public')->exists($publicPath)) {
            return response()->file(
                Storage::disk('public')->path($publicPath)
            );
        }

        abort(404, 'Document file not found');
    }

    public function getWorkBook()
    {
        $session_worker_id = session()->get('worker_id');
        $workbook = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$workbook || !$workbook->work_book) {
            abort(404, 'Document not found');
        }

        $dbPath = $workbook->work_book;

        // Check local/private storage first
        $localPath = ltrim($dbPath, '/');

        if (Storage::disk('local')->exists($localPath)) {
            return response()->file(
                Storage::disk('local')->path($localPath)
            );
        }

        // Fallback: file may actually be in public storage
        $publicPath = str_replace('/private/', '', $dbPath);

        if (Storage::disk('public')->exists($publicPath)) {
            return response()->file(
                Storage::disk('public')->path($publicPath)
            );
        }

        abort(404, 'Document file not found');
    }


    public function getNomineeBankCopy()
    {
        $session_worker_id = session()->get('worker_id');
        $bank_copy = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($bank_copy->worker_bank_copy);
        return response()->file($file);
    }
    public function getRation()
    {
        $session_worker_id = session()->get('worker_id');

        $ration = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$ration || !$ration->ration_card) {
            abort(404, 'Ration card not found');
        }

        $dbPath = $ration->ration_card;

        // Check private/local storage first
        $localPath = ltrim($dbPath, '/');

        if (Storage::disk('local')->exists($localPath)) {
            return response()->file(
                Storage::disk('local')->path($localPath)
            );
        }

        // Fallback to public storage
        $publicPath = str_replace('/private/', '', $dbPath);

        if (Storage::disk('public')->exists($publicPath)) {
            return response()->file(
                Storage::disk('public')->path($publicPath)
            );
        }

        abort(404, 'Ration card file not found');
    }
    public function getPan()
    {
        $session_worker_id = session()->get('worker_id');

        $pan = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$pan || !$pan->pan_card) {
            abort(404, 'PAN card not found');
        }

        $dbPath = $pan->pan_card;

        // Check private/local storage first
        $localPath = ltrim($dbPath, '/');

        if (Storage::disk('local')->exists($localPath)) {
            return response()->file(
                Storage::disk('local')->path($localPath)
            );
        }

        // Fallback to public storage
        $publicPath = str_replace('/private/', '', $dbPath);

        if (Storage::disk('public')->exists($publicPath)) {
            return response()->file(
                Storage::disk('public')->path($publicPath)
            );
        }

        abort(404, 'PAN card file not found');
    }


    public function FinalExSubmit(Request $request)
    {
        $apiResponse = json_decode(session('api_response'));
        $session_worker_id = session()->get('worker_id');

        $tfm = TemporaryWorkerForm::where('worker_id', $session_worker_id)->first();
        if (!$tfm) {
            Alert::error('Application Error', 'Temporary form data not found.');
            return redirect()->route('home.index');
        }

        $twbd = TemporaryWorkerBasicDetail::where('worker_id', $session_worker_id)->first();
        if (!$twbd) {
            Alert::error('Application Error', 'Temporary basic details not found.');
            return redirect()->route('home.index');
        }

        $twam = TemporaryWorkerAddress::where('worker_id', $session_worker_id)->first();
        if (!$twam) {
            Alert::error('Application Error', 'Temporary address data not found.');
            return redirect()->route('home.index');
        }

        $twbm = TemporaryWorkerBank::where('worker_id', $session_worker_id)->first();
        if (!$twbm) {
            Alert::error('Application Error', 'Temporary bank data not found.');
            return redirect()->route('home.index');
        }

        $twd = TemporaryWorkerDocument::where('worker_id', $session_worker_id)->first();
        if (!$twd) {
            Alert::error('Application Error', 'Temporary document data not found.');
            return redirect()->route('home.index');
        }

        // Calculate ackNo once
        $year = Carbon::now()->format('Y');
        $ackNo = 'ABOCWWB/' . $tfm->office_id . '/' . $year . '/REG/' . $tfm->application_no;

        $isSewaSetu = null;
        DB::beginTransaction();
        try {

            $securityController = new SecurityController();

            // Fetch the SECRET_KEY_TOKEN value
            $key1 = DB::table('Masterdata.key_values')
                ->where('key', 'SECRET_KEY_TOKEN')
                ->first()
                ->value;

            // Fetch tokens from both tables
            $tokensOld = VaultData::where('worker_id', $session_worker_id)->first()->vault_token;
            $tokensNew = MainWorkerForm::all()->pluck('vaultToken');
            $vaultTokenMain = MainVaultData::where('vaultToken', $tokensOld)->count();

            if ($vaultTokenMain > 0) {
                $vaultMatches = MainVaultData::where('vaultToken', $tokensOld)->get();
                $workerIds = $vaultMatches->pluck('worker_id')->implode(', ');

                Alert::error(
                    'Application Data Found',
                    "Existing application found for Worker ID: $workerIds. Track Application to download the receipt."
                );

                return redirect()->route('home.index');
            }
            if (session()->has('pfcData')) {
                $isSewaSetu = true;
            }
            MainVaultData::create([
                'worker_id' => $session_worker_id,
                'vaultToken' => $tokensOld,
            ]);
            $revert_status = RevertBack::where('worker_id', $session_worker_id)->count();
            if($revert_status>0)
            {

                $ackNo = RevertBack::where('worker_id', $session_worker_id)->value('ack_no');

            }else{
                $application_no = $tfm->application_no;
                $district = $tfm->office_id;
                $year = Carbon::now()->format('Y');
                $string = 'ABOCWWB';
                $text = 'REG';
                $ackNo = $string . '/' . $district . '/' . $year . '/' . $text . '/' . $application_no;
            }



            $data = MainWorkerForm::Create([
                'worker_id' => $session_worker_id,
                'office_id' => $tfm->office_id,
                'phone_no' => $tfm->phone_no,
                'district' => $tfm->district_id,
                'application_no' => $tfm->application_no,
                'already_registered' => $tfm->already_registered,
                'ack_no' => $ackNo,
                'status' => env('APPLICATION_SUBMIT_STATUS'),
                'active_status' => '0',
                'payment_status' => 'success',
                'vaultToken' => $tfm->vaultToken,
                'vaultPassKey' => $tfm->vaultPassKey,
                'date_of_retirement' => $twbd->date_of_retirement,
                'id_card_expiry_date' => $twbd->card_validity_date,
                'renewal_date' => Carbon::parse($twbd->card_validity_date)->addDay()->format('Y-m-d'),
                'last_registration_date' => $twbd->last_registration_date,
                'application_type' => 3,

            ]);

            $data = MainWorkerBasicDetail::Create([
                'worker_id' => $twbd->worker_id,
                'application_no' => $tfm->application_no,
                'old_name' => $twbd->old_name,

                'old_care_of' => $twbd->old_care_of,
                'old_dob' => $twbd->old_dob,
                'date_of_retirement' => $twbd->date_of_retirement,
                'gender_id' => $twbd->gender_id,
                'maritial_status_id' => $twbd->maritial_status_id,
                'category' => $twbd->category,
                'eshram_no' => $twbd->eshram_no,
                'education_id' => $twbd->education_id,
                'email' => $twbd->email,
                'pan' => $twbd->pan,
                'pan_no' => $twbd->pan_no,
                'skill_id' => $twbd->skill_id,
                'boc' => $twbd->boc,
                'boc_no' => $twbd->boc_no,
                'state_id' => $twbd->state_id,
                'resident_type' => $twbd->resident_type,
                'has_ration_card' => $twbd->has_ration_card,
                'ration_type' => $twbd->ration_type,
                'ration_no' => $twbd->ration_no,
                'blood_group' => $twbd->blood_group,
                'last_registration_date' => $twbd->last_registration_date,
                'card_validity_date' => $twbd->card_validity_date,
                'other_state' => $twbd->other_state,
                'subscription_payment_date' => $twbd->subscription_payment_date,
                'subscription_amount_paid' => $twbd->subscription_amount_paid,
                'subscription_receipt' => $twbd->subscription_receipt,
                'profession' => $twbd->profession,
                'profession_others' => $twbd->profession_others
            ]);

            $data = MainWorkerAddress::Create([
                'worker_id' => $session_worker_id,
                'application_no' => $tfm->application_no,
                'c_residence' => $twam->c_residence,
                'c_house_type' => $twam->c_house_type,
                'c_house_no' => $twam->c_house_no,
                'c_road' => $twam->c_road,
                'c_area' => $twam->c_area,
                'c_city' => $twam->c_city,
                'c_state' => $twam->c_state,
                'c_district' => $twam->c_district,
                'c_post_office' => $twam->c_post_office,
                'c_pin' => $twam->c_pin,
                'c_circle' => $twam->c_circle,
                'building' => $twam->building,
                'landmark' => $twam->landmark,
                'do' => $twam->do,
                'type_of_document' => $twam->type_of_document
            ]);


            $data = MainWorkerBank::Create([
                'worker_id' => $session_worker_id,
                'application_no' => $tfm->application_no,
                'ifsc_pk' => $twbm->ifsc_pk,
                'ifsc_code' => $twbm->ifsc_code,
                'bank_name' => $twbm->bank_name,
                'branch_name' => $twbm->branch_name,
                'bank_address' => $twbm->bank_address,
                'account_no' => $twbm->account_no,
            ]);

            $temporaryWorkerFamilies  =  TemporaryWorkerFamily::where('worker_id', $session_worker_id)->get();
            $familyData = [];
            foreach ($temporaryWorkerFamilies as $twfm) {
                $familyData[] = [
                    'worker_id' => $session_worker_id,
                    'application_no' => $tfm->application_no,
                    'first_name' => $twfm->first_name,
                    'last_name' => $twfm->last_name,
                    'guardain_name' => $twfm->guardain_name ?? 'NA',
                    'dob' => $twfm->dob,
                    'relation' => $twfm->relation,
                    'relation_others' => $twfm->relation_others,
                    'nominee_percentage' => $twfm->nominee_percentage,
                    'nominee' => $twfm->nominee,
                    'already_registered' => $twfm->already_registered,
                    'already_registered_state' => $twfm->already_registered_state,
                    'bocwwb_id' => $twfm->bocwwb_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ];
            }
            if (!empty($familyData)) {
                MainWorkerFamily::insert($familyData); // Use actual table name if not following Laravel conventions
            }

            $temporaryWorkerSchemes = DB::table('Worker.temporary_worker_schemes')->where('worker_id', $session_worker_id)->get();
            $schemeData = [];
            foreach ($temporaryWorkerSchemes as $tws) {
                $schemeData[] = [
                    'worker_id' => $session_worker_id,
                    'application_no' => $tfm->application_no,
                    'scheme_name' => $tws->scheme_name,
                    'registration_id' => $tws->registration_id,
                    'date' => $tws->date,
                    'enrolled' => $tws->enrolled,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            if (!empty($schemeData)) {
               MainWorkerScheme::insert($schemeData);
            }
            $twd = DB::table('Worker.temporary_worker_documents')->where('worker_id', $session_worker_id)->first();
            $data = MainWorkerDocument::Create([
                'worker_id' => $session_worker_id,
                'application_no' => $tfm->application_no,
                'residential_proof' => $twd->residential_proof,
                'old_id_card' => $twd->old_id_card,
                'old_id_card_ext' => $twd->old_id_card_ext,
                'res_proof_ext' => $twd->res_proof_ext,
                'subscription_payment_receipt' => $twd->subscription_payment_receipt,
                'subscription_ext' => $twd->subscription_ext,
                'work_book' => $twd->work_book,
                'work_book_ext' => $twd->work_book_ext,
                'worker_bank_copy' => $twd->worker_bank_copy,
                'worker_bank_copy_ext' => $twd->worker_bank_copy_ext,
                'ration_card' => $twd->ration_card,
                'ration_card_ext' => $twd->ration_card_ext,
                'pan_card' => $twd->pan_card,
                'pan_card_ext' => $twd->pan_card_ext,
                'nominee_bank_copy' => $twd->nominee_bank_copy,
                'nominee_bank_copy_ext' => $twd->nominee_bank_copy_ext,

            ]);
            $revert_status = RevertBack::where('worker_id', $session_worker_id)->count();
            if ($revert_status > 0) {
//                $certificate_data = MainWorkerCertificate::where('worker_id', $session_worker_id)->delete();
//                $certificate_data1 = TemporaryWorkerCertificate::where('worker_id', $session_worker_id)->delete();
                $user_details = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                    ->where('application_status', 'G')
                    ->latest()
                    ->first();
                if ($user_details) {
                    $receiverRoleId = $user_details->sender_role_id;
                    $receiverUserId = $user_details->sender_user_id;

                    // Determine status based on sender_user_id
                    $status = null;
                    if ($receiverRoleId == 2) {
                        $status = env('HEAD_REGISTERING_OFFICER');
                    } elseif ($receiverRoleId == 3) {
                        $status = env('REGISTERING_OFFICER');
                    }
                    $ack_no = RevertBack::where('worker_id', $session_worker_id)->value('ack_no');

                    $update = MainWorkerForm::where('worker_id', $session_worker_id)->update([
                        'payment_status' => 'success',
                        'resubmit_status' => 1,
                        'application_receiver_user_id' => $receiverUserId,
                        'status' => $status,
                        'ack_no' => $ack_no
                    ]);
                    $data = WorkerApplicationStatus::Create([
                        'worker_id' => $session_worker_id,
                        'sender_office_id' => $tfm->office_id,
                        'sender_user_id' => $receiverUserId,
                        'application_no' => $tfm->application_no,
                        'ack_no' => $ack_no,
                        'application_status' => $status,
                        'remarks' => 'Application Submitted',
                    ]);
                }
                $update = RevertBack::where('worker_id', $session_worker_id)->update([
                    'payment_status' => 'success',
                    'resubmit_status' => 1
                ]);

                DB::commit();
                $this->smsService->applicationSubmissionSMS($tfm->phone_no, $ackNo, '0');
                Alert::toast('Application Submitted Successfully!', 'success');
                return redirect()->route('print-acknowledgement');
            } else {
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $session_worker_id,
                    'application_no' => $tfm->application_no,
                    'ack_no' => $ackNo,
                    'already_registered' => 1,
                    'application_status' => env('APPLICATION_SUBMIT_STATUS'),
                    'remarks' => 'Application Submitted',
                ]);
            }
            if(PfcKioskDetail::where('worker_id',$session_worker_id)->exists())
            {
                $pfc_details = PfcKioskDetail::where('worker_id',$session_worker_id)->first();
                $pfc_details['is_login_csc']=true;
            }
            else{
                $pfc_details['is_login_csc']=false;
            }
            DB::commit();
            $this->smsService->applicationSubmissionSMS($tfm->phone_no, $ackNo, '0');
            Alert::toast('Application Submitted Successfully!', 'success');
            return redirect()->route('print-acknowledgement');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }



    public function acknowledgementPage(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        try {
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['base64image'] = $data['getVaultData']['photo'];

            $data['worker'] = MainWorkerForm::where('worker_id', $session_worker_id)
                ->first();
            $data['mwf'] = DB::table('Worker.main_worker_forms as wmfm')
                ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
                ->where('worker_id', $session_worker_id)
                ->select('wmfm.*', 'ofc.*')
                ->first();
            $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
                ->where('worker_id', $session_worker_id)
                ->select('wmbd.*')
                ->first();
            // return $data['worker'];
            $ack_no = $data['worker']->ack_no;
            if (session()->has('pfcData')) {
                $rtpsdata = session()->get('pfcData');
                $rtps_trans_id = $rtpsdata['rtps_trans_id'];
                $pfcData = PfcKioskDetail::where('rtps_trans_id', $rtps_trans_id)->first();
                MainWorkerForm::where('worker_id', $session_worker_id)->update([
                    'rtps_trans_id' => $rtps_trans_id
                ]);
                $encryption_key = "1234567890123456";
                $userDetails = array();
                array_push(
                    $userDetails,
                    array(
                        "gender" => $data['getVaultData']['gender'],
                        "applicant_name" => $data['getVaultData']['name'],
                        "fathers_name" => $data['getVaultData']['careOf'],
                        "mobile_number" => $pfcData->mobile,
                        "address_line_1" => $data['getVaultData']['street'],
                        "address_line_2" => $data['getVaultData']['locality'],
                        "state" => $data['getVaultData']['state'],
                        "district" => $data['worker']->districtName->district_name,
                        "pin_code" => $data['getVaultData']['pinCode']
                    )
                );
                $application_details = array(
                    "slno" => $ack_no,
                );

                $output = array(
                    "rtps_trans_id" => $pfcData->rtps_trans_id,
                    "user_id" => $pfcData->mobile,
                    "service_id" => $pfcData->service_id,
                    "app_ref_no" => $ack_no,
                    "status" => "S",
                    "submission_date" => Carbon::now()->format('Y-m-d H:i:s'),
                    "payment_mode" => "NA",
                    "payment_ref_no" => "NA",
                    "payment_date" => "NA",
                    "amount" => "0.",
                    "application_details" => $application_details,
                    "applicant_details" => $userDetails,
                    "portal_no" => $pfcData->portal_no,
                    "submission_location" => $data['worker']->officeName->office_name,
                    "district" => $data['worker']->districtName->district_name,
                    "circle" => $data['getVaultData']['subDistrict'] ? $data['getVaultData']['subDistrict'] : ""
                );


                $output = json_encode(array("response_data" => $output));
                $aes = new AES($output, $encryption_key);
                $data['encrypted_data'] = $aes->encrypt();
                $data['url'] = $pfcData->response_url;
            }
            $data['revert_back'] = RevertBack::where('worker_id', $session_worker_id)->count();


            if ($data['revert_back'] > 0) {
                $data['department_id'] = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->where('payment_type', 1)->where('STATUS', 'Y')->latest()->first();
                $data['egrass_office_code'] = Office::where('office_id', $data['worker']->office_id)->first()->egrass_office_code;
                return view('existing-worker.worker-acknowledgement-page', $data);
            }
            $successMessage = session('success', 'Default success message if not set');
            return view('existing-worker.worker-acknowledgement-page', $data);
        } catch (Exception $e) {
//             return $e;
            Alert::toast("Something went wrong!", 'error');
//            return back();
        }
    }
    public function returnHome(Request $request)
    {
        // Completely destroy the session
        Session::flush();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function downloadPreviewPDF(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        try {
            $maskAadharNumber = function ($aadharNumber) {
                return str_repeat('*', 8) . substr($aadharNumber, 8);
            };

            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $getVaultData = json_decode($vaultData->getData(), true);

            //        if (isset($getVaultData['uID'])) {
            //            $getVaultData['uID'] = $maskAadharNumber($getVaultData['uID']);
            //        }

            $worker_details = TemporaryWorkerForm::where('worker_id', $session_worker_id)->first();

            $emblem = public_path('/assets/template/images/bocw.png');

            $has_ration_card = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('has_ration_card')
                ->first();

            $has_pan = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('pan')
                ->first();

            $twd = DB::table('Worker.temporary_worker_documents as twd')->where('twd.worker_id', $session_worker_id)->first();

            $documents = collect([
                ['id' => 1, 'name' => 'residential_proof', 'label' => 'Present Address Proof ', 'uploaded' => !empty($twd->residential_proof)],
                ['id' => 2, 'name' => 'old_id_card', 'label' => 'BOC ID Card', 'uploaded' => !empty($twd->old_id_card)],
                ['id' => 3, 'name' => 'subscription_payment_receipt', 'label' => 'Subscription Payment receipt', 'uploaded' => !empty($twd->subscription_payment_receipt)],
                ['id' => 4, 'name' => 'worker_bank_copy', 'label' => 'Aadhaar Linked Bank Copy', 'uploaded' => !empty($twd->worker_bank_copy)],
                ['id' => 5, 'name' => 'ration_card', 'label' => 'Ration Card', 'uploaded' => !empty($twd->ration_card)],
                ['id' => 6, 'name' => 'nominee_bank_copy', 'label' => 'Nominee Bank Copy', 'uploaded' => !empty($twd->nominee_bank_copy)],
                ['id' => 7, 'name' => 'pan_card', 'label' => 'PAN Card', 'uploaded' => !empty($twd->pan_card)],
                ['id' => 8, 'name' => 'work_book', 'label' => 'Work Book/90 days Certificate', 'uploaded' => !empty($twd->work_book)],
            ]);

            $ndc = WorkerNinetyDaysCertificate::where('worker_id', $session_worker_id)->get();
            $serialNumber = 1;
            $html = view('existing-worker.pdf.worker-preview-details-pdf', compact('emblem', 'worker_details', 'getVaultData', 'has_ration_card', 'has_pan', 'documents', 'ndc', 'serialNumber'))->render();
            $options = [
                'encoding' => 'utf-8', // Set encoding to UTF-8
                'enable-local-file-access' => true, // Enable external links
            ];
            // Generate PDF from HTML content
            $pdfContent =  Pdf::loadHTML($html)
                ->setOptions($options)
                ->output();

            // Set response headers to indicate PDF content
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="application.pdf"',
            ]);
        } catch (Exception $e) {
//            return $e;
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }


    public function previewFromDoc()
    {
        return view('worker.worker-preview-details');
    }

    public function downloadAckPdf(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        try {
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);

            $data['worker'] = DB::table('Worker.main_worker_forms')->where('worker_id', $session_worker_id)->first();
            $data['mwf'] = DB::table('Worker.main_worker_forms as wmfm')
                ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
                ->where('worker_id', $session_worker_id)
                ->select('wmfm.*', 'ofc.*')
                ->first();
            $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
                ->where('worker_id', $session_worker_id)
                ->select('wmbd.*')
                ->first();
            $data['revert_back'] = RevertBack::where('worker_id', $session_worker_id)->count();
            $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('application_status', 'G')->count();
            $data['bocwCard'] = null;
            if ($remarks > 0) {

                $data['old_card'] = BocwCard::where('worker_id', $session_worker_id)->count();
                if ($data['old_card'] > 0) {
                    $data['bocwCard'] = BocwCard::where('worker_id', $session_worker_id)->first();
                }
            }
            $data['emblem'] = public_path('/assets/template/images/bocw.png');
            $options = [
                'encoding' => 'utf-8', // Set encoding to UTF-8
                'enable-local-file-access' => true, // Enable external links
            ];
            // The Blade view you provided
            $html = view('existing-worker.pdf.download-as-pdf', $data)->render();

            // Generate PDF from HTML content
            $pdfContent =  Pdf::loadHTML($html)
                ->setOptions($options)
                ->output();

            // Set response headers to indicate PDF content
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Acknowledgement_Receipt.pdf"',
            ]);
        } catch (Exception $e) {
            //            return $e;
            Alert::toast('Something went wrong', 'error');
            return back();
        }
    }

    public function updateOffice(Request $request)
    {
        $session_worker_id = session()->get('worker_id');

        if (!$session_worker_id) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please log in again.'
            ], 401);
        }


        try {
            // Update the worker's office details
            TemporaryWorkerForm::where('worker_id', $session_worker_id)->update([
                'district_id' => $request->district_id,
                'office_id' => $request->office_id
            ]);

            // Retrieve updated office name
            $updatedOffice = Office::find($request->office_id);

            return response()->json([
                'success' => true,
                'office_id' => $updatedOffice->office_id,
                'office_name' => $updatedOffice->office_name
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
