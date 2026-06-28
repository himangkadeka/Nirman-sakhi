<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Http\Requests\validationRequest;
use App\Models\AadharLogModel;
use App\Models\Bank;
use App\Models\KeyValue;
use App\Models\RevertBack;
use App\Models\TempData;
use App\Services\AesCipher;
use Database\Seeders\KeyValueSeeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use App\Models\Amount;
use App\Models\District;
use App\Models\MainVaultData;
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
use App\Models\Office;
use App\Models\PfcKioskDetail;
use App\Models\State;
use App\Models\TemporaryWorkerCertificate;
use App\Models\User;
use App\Models\VaultData;
use App\Models\WorkerApplicationStatus;
use App\Models\WorkerNinetyDaysCertificate;
use App\Services\AES;
use Illuminate\Support\Facades\Hash;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use Carbon\Carbon;
use DateTime;
use Faker\Core\File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use PhpParser\Node\Expr\Cast;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\ApiCurlService;
use App\Services\SmsGatewayService;
use App\Services\GetVaultDataService;
use Exception;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Storage\AlertSessionStore;
use App\Models\WorkerPaymentSuccess;
use Illuminate\Validation\Rule;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
require_once(app_path('Libraries/CSCPay/BridgePGUtil.php'));
class MasterWorkerController extends Controller
{
    protected $smsService;
    protected $AuthOtpController;
    protected $getVaultDataService;
    /**
     * @var AesCipher
     */


    public function __construct(SmsGatewayService $smsService, AuthOtpController $AuthOtpController, GetVaultDataService $getVaultDataService)
    {
        $this->smsService = $smsService;
        $this->AuthOtpController = $AuthOtpController;
        $this->getVaultDataService = $getVaultDataService;
    }




    public function sessionFlash()
    {
        Session::flush();
        session()->regenerate();
        return redirect()->route('home.index');
    }

    public function registrationConsent()
    {
        if (session()->has('pfcData')) {
            $session_rtps_trans_id = session()->get('pfcData');
            $data['pfc_data'] = PfcKioskDetail::where('rtps_trans_id', $session_rtps_trans_id)->first();
        }

        return view('worker.new-registration-consent');
    }

    public function checkBeforeNewRegister()
    {

        $data['pfc_data'] = null;
        if (session()->has('pfcData')) {
            $data['pfcData'] = session()->get('pfcData');
            if ($data['pfcData'])
            {
                $rtpstrans_id = $data['pfcData']['rtps_trans_id'];

                if ($rtpstrans_id)
                {
                    if (PfcKioskDetail::where('rtps_trans_id', $rtpstrans_id)->exists())
                    {
                        $data['pfc_data'] = PfcKioskDetail::where('rtps_trans_id', $rtpstrans_id)->first();
                    }
                    else{

                    }



                }
            }


//            return $data['pfc_data'];

        }
        $data['districts'] = DB::table('Masterdata.districts')
            ->where('state_code', '=', 18)
            ->orderBy('district_name')
            ->get();
        return view('worker.check_temp_account_exist', $data);
    }

    public function savePhone(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'phone_no' => 'required|digits:10'
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }

        try {
            $phone_no = $request->phone_no;
            // $data = TempData::Create([
            //     'phone_number'=> $phone_no,

            // ]);
            Cookie::queue('phoneNo', $request->phone_no, 60);
            return redirect()->route('new-registration-consent');
            // return redirect()->route('new-auth-uidai-worker');
        } catch (Exception $e) {
//                        return $e;
            DB::rollBack();
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }


    public function sendToOnboarding()
    {
        session()->put('from_onboarding', true);
        return redirect()->route('home.index');
    }



    /****View aadhar auth page****/
    public function NewRegWorker(Request $request)
    {

        if (session()->has('pfcData')) {
            $session_rtps_trans_id = session()->get('pfcData');
            $data['pfc_data'] = PfcKioskDetail::where('rtps_trans_id', $session_rtps_trans_id)->first();
        }

        //        $data['phoneNo'] = TempData::findorFail($id);
        $data['phoneNo'] = $request->cookie('phoneNo');
        $data['districts'] = DB::table('Masterdata.districts')
            ->where('state_code', '=', 18)
            ->orderBy('district_name')
            ->get();
        $nonce = substr(md5(uniqid(mt_rand(), true)), 0, 23);
        session()->put('nonce_value', $nonce);
        return view('worker.register-new-worker', $data);
    }


    public function checkPhone(Request $request)
    {

        $validate = $request->validate([
            'phone_no' => 'required|digits:10'
        ]);



        $mainData = DB::table('Worker.main_worker_forms')
            ->where('phone_no', $validate['phone_no'])
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
                    'already_registered' => MainWorkerForm::where('worker_id', $account->worker_id)->first()->already_registered,

                ];
            } elseif (RevertBack::where('worker_id', $account->worker_id)->exists()) {
                $modified_app[] = [
                    'worker_id' => $account->worker_id,
                    'ack_no' => RevertBack::where('worker_id', $account->worker_id)->first()->ack_no,
                    'already_registered' => RevertBack::where('worker_id', $account->worker_id)->first()->already_registered,
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
    }

    public function getAccountDetails(Request $request)
    {

        $worker_id = $request->input('worker_id');



        $account = MainWorkerForm::where('worker_id', $worker_id)
            ->where('already_registered', NULL)
            ->select('worker_id', 'status', 'ack_no', 'phone_no', 'application_no', 'payment_status')
            ->first();
        if (!$account) {
            $tempaccount = TemporaryWorkerForm::where('worker_id', $worker_id)
                ->whereNull('already_registered')
                ->select(
                    'worker_id',
                    DB::raw('NULL as status'),
                    DB::raw('NULL as ack_no'),
                    DB::raw('NULL as payment_status'),
                    'phone_no',
                    'application_no'

                )
                ->first();
        }
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
                        'application_status' => 'Payment is Pending'
                    ]);
                }
                // elseif(!account)
                // {
                //     return response()->json([
                //     'status' => 'unfinished',
                //     'account' => $tempaccount,
                //     'vaultData' => $vaultData,
                //     'message' => 'Application is in draft.',
                //     'application_status' => 'Draft Application found'
                //     ]);
                // }
            }
            $account = RevertBack::Where('worker_id', $worker_id)
                ->where('already_registered', NULL)
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
                ->where('already_registered', NULL)
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
            return response()->json([
                'status' => false,
                'results' => $e->getMessage()
            ]);
        }
    }

    public function deleteWorkerData(Request $request)
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
            $temp_certificate = TemporaryWorkerCertificate::where('worker_id', $workerId)->get();
            if ($temp_certificate) {
                DB::table('Worker.temporary_worker_certificates')->where('worker_id', $workerId)->delete();
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

    public function changeRoute(Request $request)
    {
        $route = $request->input('route');
        $workerId = $request->input('worker_id');

        $workerForm = TemporaryWorkerForm::where('worker_id', $workerId)->first();

        if ($workerForm) {
            $workerForm->already_registered = ($route === '1') ? 1 : null;
            $workerForm->save();
        }

        $redirectUrl = ($route === '0')
            ? url("worker/worker-basic-details")
            : url("existing-worker/existing-worker-basic-details");

        return response()->json(['redirectUrl' => $redirectUrl]);
    }

    public function checkPhoneCount(Request $request)
    {
        $phone = $request->query('phone');

        $count = TemporaryWorkerForm::where('phone_no', $phone)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function verifyWorkerMobile(Request $request)
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
                } elseif ($userFinalData->payment_status == NULL || $userFinalData->payment_status == 'failed' || $userFinalData->payment_status == 'Aborted' || $userFinalData->payment_status == 'pending') {
                    session()->put('worker_id', $userFinalData->worker_id);
                    return response()->json(['status' => 'pending', 'redirect' => route('OTP-gen-page')]);
                }
            }
            if ($userTempData) {
                session()->put('worker_id', $userTempData->worker_id);
                return response()->json(['status' => 'proceed_to_login', 'redirect' => route('OTP-gen-page')]);
            } else {
                return response()->json(['status' => 'not_registered', 'message' => 'You have not registered.']);
            }
        } catch (Exception $e) {
            Log::error('Error in loginWithTempId: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Please try again later.'], 500);
        }
    }

    public function OTPPage(Request $request)
    {

        $temp_worker_id = session()->get('worker_id');
        $data['worker_id'] = $temp_worker_id;
        $data['phone_no'] = TemporaryWorkerForm::where('worker_id', $temp_worker_id)->pluck('phone_no')->first();
        return view('worker.worker-otp-generation', $data);
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

    public function newRegister(Request $request)
    {
        try {
//            DB::beginTransaction();

            $this->validateRequest($request);

            $uid = $request->uid;
             $uidData = $this->getSessionAadhaarData();
            $decryptedData = $this->decryptAadhaarData($uidData);
            $dob = Carbon::parse($decryptedData->dob);

// Age range limits
            $maxDob = now()->subYears(55);   // Person must be born ON or AFTER this date
            $minDob = now()->subYears(18);   // Person must be born ON or BEFORE this date

// Validate using strict date comparison
            if ($dob->lt($maxDob) || $dob->gt($minDob)) {
                DB::rollBack();
                Alert::toast('Sorry, your age does not meet the eligibility criteria', 'error');
                return redirect()->route('error-show-worker', 0);
            }
            session()->put('uid', $uid);
//            return 'hii';
            $tokenKey = $uidData['vaultToken'];
            $tokenPasskey = $uidData['vaultPassKey'];
            $encData = $uidData['encResponseData'];
            $existingVault = VaultData::where('vault_token', $tokenKey)->first();

            if ($existingVault) {
                $workerId = $existingVault->worker_id;
                if (MainVaultData::where('vaultToken', $tokenKey)->exists()) {
                    $contact = MainWorkerForm::where('worker_id',$workerId)->value('phone_no');
                    DB::rollBack();
                    Alert::toast('Duplicate Data Found', 'error');
                    return redirect()->route('error-show-worker', [
                        'id' => 1,
                        'contact' => $contact
                    ]);
                }

                $alreadyRegistered = TemporaryWorkerForm::where('worker_id', $workerId)->value('already_registered');

                if ($alreadyRegistered === 1) {
                    session()->put('worker_id', $workerId);
                    return redirect()->route('submit-basic-page')->with('toast', 'Draft application found!');
                } elseif (is_null($alreadyRegistered)) {
                    session()->put('worker_id', $workerId);
                    return redirect()->route('main-page')->with('toast', 'Draft application found!');
                } else {
                    return redirect()->route('home.index');
                }
            }

            $this->checkPhoneLimits($request->phone_no);

            $workerId = $this->generateUniqueWorkerID($request);
            $applicationId = rand(111111111, 999999999);

            if (session()->has('pfcData')) {
                $this->updatePfcKioskDetail(session()->get('pfcData'), $workerId);
            }

            // Encrypt sensitive data
//            $secretKey = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->value('value');
            $secretKey = Cache::remember('secret_key_token', 3600, function () {
                return DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->value('value');
            });
            $security = new SecurityController();
            $encryptedToken = $security->encrypt($tokenKey, $secretKey);
            $encryptedPass = $security->encrypt($tokenPasskey, $secretKey);
            DB::beginTransaction();
            // Store user form
            $form = TemporaryWorkerForm::create([
                'worker_id' => $workerId,
                'application_no' => $applicationId,
                'phone_no' => $request->phone_no,
                'district_id' => $request->district,
                'office_id' => $request->office_id,
                'aadhaar_auth' => 1,
                'vaultToken' => $encryptedToken,
                'vaultPassKey' => $encryptedPass,
            ]);

            // Store vault info
            VaultData::create([
                'worker_id' => $workerId,
                'vault_token' => $tokenKey,
                'enc_data' => $encData,
            ]);

            // Log Aadhaar event
            AadharLogModel::create([
                'ip_address' => request()->ip(),
                'consent' => $request->aadhar_consent,
                'token_id' => $tokenKey,
            ]);

            session()->put('worker_id', $form->worker_id);

            DB::commit();
            return redirect()->route('main-page');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Registration Error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            Alert::toast('Something went wrong!', 'error');

            return redirect()->back();
        }
    }

    protected function validateRequest(Request $request)
    {
        $rules = [
            'phone_no' => 'required|digits:10',
            'office_id' => 'required|exists:pgsql.Masterdata.offices,office_id',
            'district' => 'required|exists:pgsql.Masterdata.districts,district_code',
        ];

        $phoneExists = DB::table('Worker.main_worker_forms')
            ->where('phone_no', $request->phone_no)
            ->exists();

        if (!$phoneExists) {
            $rules['uid'] = ['required', 'regex:/^\d{12}$|^\d{16}$/'];
        }

        $request->validate($rules);
    }

    protected function getSessionAadhaarData(): array
    {
        return json_decode(session('uid_data'), true);
    }

    protected function decryptAadhaarData(array $uidData)
    {
        $security = new SecurityController();
        $salt = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->value('value');
        $licenseKeyEnc = DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->value('value');
        $licenseKey = $security->decrypt($licenseKeyEnc, $salt);

        $encryptedData = $uidData['encResponseData'] ?? null;
        return json_decode(AesCipher::decrypt($licenseKey, $encryptedData));
    }

    protected function checkPhoneLimits(string $phone)
    {
        $count = TemporaryWorkerForm::where('phone_no', $phone)->count();
        if ($count >= 4) {
            throw new \Exception('Maximum number of registrations reached for this phone number.');
        }
    }

    protected function updatePfcKioskDetail($rtpsTransId, $workerId)
    {
        PfcKioskDetail::where('rtps_trans_id', $rtpsTransId)->update([
            'worker_id' => $workerId,
        ]);
    }



    public function errorThrow($id,$contact = null)
    {
        $aadhar_data = session()->get('uid_data');
        if ($aadhar_data) {
            if ($id == 0) {
                $msg = 'Your age as per Aadhar does not meet the eligibility criteria to be an Assam BOCW worker.';
            } elseif ($id == 1) {
                $msg = 'You have already submitted your application';
                if (!empty($contact)) {
                    $msg .= ' under registered phone number ' . $contact;
                }
            } elseif ($id == 2) {
                $msg = 'This phone number has reached the maximum number of registrations allowed.';
            } elseif ($id == 3) {
                $msg = 'You have completed your registration successfully. You will be notified as your application is approved.';
            }
        } else {
            return redirect('home.index');
        }
        return view('error-return-page-worker', compact('msg'));
    }


    public function loginWithTempId(Request $req)
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
                return response()->json(['status' => 'proceed_to_login', 'redirect' => route('main-page')]);
            } else {
                return response()->json(['status' => 'not_registered', 'message' => 'You have not registered.']);
            }
        } catch (Exception $e) {
            Log::error('Error in loginWithTempId: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Please try again later.'], 500);
        }
    }
    public function loginWithResubmit($encodedId)
    {
        $base64_decode_id = base64_decode($encodedId);
        try {

            $tempWorkerId =  $base64_decode_id;
            Session::put('worker_id', $tempWorkerId);
            return redirect()->route('main-page');
        } catch (Exception $e) {
            Log::error('Error in loginWithTempId: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Please try again later.'], 500);
        }
    }




    /**Redirect To Worker Basic Details page**/
    public function mainPage(Request $request)
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

            $data['alreadyPaymentStatus'] = TemporaryWorkerForm::where('worker_id', $session_worker_id)->pluck('already_payment_status')->first();


            $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_basic_details as twbd')
                ->leftJoin('Worker.temporary_worker_forms as tfm', 'twbd.worker_id', '=', 'tfm.worker_id')
                ->leftJoin('Masterdata.marital_statuses as ms', 'twbd.maritial_status_id', '=', 'ms.marital_code')
                ->leftJoin('Masterdata.educations as edu', 'twbd.education_id', '=', 'edu.education_code')
                ->leftJoin('Masterdata.categories as cat', 'twbd.category', '=', 'cat.category_code')
                ->leftJoin('Masterdata.skills as ski', 'twbd.skill_id', '=', 'ski.skill_code')
                ->leftjoin('Masterdata.blood_groups as bg', 'twbd.blood_group', '=', 'bg.id')
                ->leftJoin('Masterdata.ration_types as rt', 'twbd.ration_type', '=', 'rt.ration_code')
                ->leftJoin('Masterdata.states as st', 'twbd.state_id', '=', 'st.state_code')
                ->where('twbd.worker_id', $session_worker_id)
                ->select('twbd.*', 'tfm.*', 'ms.*', 'cat.*', 'edu.*', 'ski.*', 'st.*', 'rt.*', 'bg.*')
                ->first();

            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);



            if ($data['formdata']) {
                $data['marital'] = DB::table('Masterdata.marital_statuses')
                    ->where('marital_code', '!=', $formdata->marital_code)
                    ->get();
                $data['category'] = DB::table('Masterdata.categories')
                    ->where('category_code', '!=', $formdata->category_code)
                    ->get();
                $data['education'] = DB::table('Masterdata.educations')
                    ->where('education_code', '!=', $formdata->education_code)
                    ->get();
                $data['skills'] = DB::table('Masterdata.skills')
                    ->where('skill_code', '!=', $formdata->skill_code)
                    ->get();
                $data['blood'] = DB::table('Masterdata.blood_groups')
                    ->where('id', '!=', $formdata->id)
                    ->get();
                $data['states'] = DB::table('Masterdata.states')
                    ->where('state_code', '!=', $formdata->state_code)
                    ->orderBy('state_name', 'asc')
                    ->get();
                $data['ration'] = DB::table('Masterdata.ration_types')->get();
                $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->pluck('application_no')
                    ->first();
                // dd($data['getVaultData']);
                return view('worker/edit.edit-worker-basic-details', $data);
            } else {
                $data['blood'] = DB::table('Masterdata.blood_groups')->get();
                $data['gender'] = DB::table('Masterdata.genders')->get();
                $data['category'] = DB::table('Masterdata.categories')->get();
                $data['marital'] = DB::table('Masterdata.marital_statuses')->get();
                $data['education'] = DB::table('Masterdata.educations')->get();
                $data['skills'] = DB::table('Masterdata.skills')->get();
                $data['ration'] = DB::table('Masterdata.ration_types')->get();
                $data['states'] = DB::table('Masterdata.states')->orderBy('state_name', 'asc')->get();
                $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_forms')->where('worker_id', $session_worker_id)->first();
                return view('worker.worker-basic-details', $data);
            }
        } catch (Exception $e) {
//                return $e;
            DB::rollBack();
            Alert::toast('Something went wrong', 'error');
            return back();
        }
    }

    public function updatePayementDetails()
    {
        try {
            $session_worker_id = session()->get('worker_id');

            if (!$session_worker_id) {
                return $this->sessionFlash();
            }

            TemporaryWorkerForm::where('worker_id', $session_worker_id)->update([
                'already_payment_status' => true
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

    public function updatePreviousPayementDetails()
    {
        try {
            $session_worker_id = session()->get('worker_id');

            if (!$session_worker_id) {
                return $this->sessionFlash();
            }

            TemporaryWorkerForm::where('worker_id', $session_worker_id)->update([
                'already_payment_status' => false
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


    public function updateAcknowledgementNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ack_no' => 'required|string|max:255', // Add max length and type validation
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

            TemporaryWorkerForm::where('worker_id', $session_worker_id)->update([
                'previous_acknowledgement_number' => $request->ack_no,
                'ack_transaction_id' => $request->ack_transaction_id,
                'ack_payment_amount' => $request->ack_amount,
                'ack_payment_date' => $request->ack_payment_date,
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
        return view('worker.edit.edit-worker-district-and-office', $data);
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

            return redirect()->route('main-page');
        } catch (\Exception $e) {
            // return $e;
            DB::rollBack();
            Alert::toast('Something went wrong', 'error');
            return back();
        }
    }

    /** save basic worker basic data */
    public function saveBasic(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }

            $validate = $request->validate([
                'worker_id' => 'unique:pgsql.Worker.temporary_worker_basic_details',
                'maritial_status_id' => 'required|exists:pgsql.Masterdata.marital_statuses,marital_code',
                'category' => 'required|exists:pgsql.Masterdata.categories,category_code',
                'eshram_no' => 'required|numeric|digits:12',
                'education_id' => 'required|exists:pgsql.Masterdata.educations,education_code',
                'email' => 'nullable|regex:/(.+)@(.+)\.(.+)/i',
                'pan' => 'required|in:1,0',
                'pan_no' => $request->input('pan') == '1' ? 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/|max:10' : '',
                'resident_type' => 'required|in:raa,rao',
                'state_id' => $request->input('resident_type') == 'rao' ? 'required|exists:pgsql.Masterdata.states,state_code' : '',
                'boc' => 'required|in:1,0',
                'boc_no' => $request->input('boc') == '1' ? 'required|string' : '',
                'has_ration_card' => 'required|in:0,1',
                'ration_no' => $request->has_ration_card == '1' ? 'required|string|max:255|regex:/^[a-zA-Z0-9\-\/]+$/'  // Adjust the regex pattern as needed
                    : 'nullable',
                'ration_type' => $request->has_ration_card == '1' ? 'required|string|max:255' : '',
                'blood_group' => 'required|exists:pgsql.Masterdata.blood_groups,id',
                'other_state' => $request->input('boc') == '1' ? 'required|exists:pgsql.Masterdata.states,state_code' : '',
                'payment_acknowledgement_slip' => $request->input('alreadyPaymentStatus') == '1' ? 'required|file|mimes:pdf|max:2048' : 'nullable|file|mimes:pdf|max:2048',
            ], [
                'worker_id.unique' => '⚠ The Worker is already registered!',
                'maritial_status_id.required' => '⚠ Please Select Marital Status',
                'category.required' => '⚠ Please Select Category',
                'education_id.required' => '⚠ Education Cannot Be Blank',
                'eshram_no.required' => '⚠ e-Shram No Cannot Be Blank',
                'eshram_no.digits' => 'e-Shram number must have exactly 12 digits',
                'state_id.required_if' => '⚠ State is required for the selected resident type.',
                'resident_type.required' => '⚠ Please select whether you are a Permanent Resident Of Assam or not',
                'pan.required' => '⚠ Please Select if you have pan card or not',
                'boc.required' => '⚠ Please Select if you are already registered with BOCW Board',
                'has_ration_card.required' => '⚠ Please Select whether you have a ration card or not',
                'ration_no.required' => '⚠ The Ration Card Number Cannot Be Blank',
                'ration_type.required' => '⚠ Please Select Ration Type',
                'blood_group.required' => '⚠ Please Select Blood Group ',
                'other_state.required' => '⚠ Select the State of the board under which you are registered with',
                'payment_acknowledgement_slip.required' => '⚠ Payment acknowledgement slip is required when payment status is already completed.',
                'payment_acknowledgement_slip.mimes' => '⚠ Payment slip must be a PDF file.',
                'payment_acknowledgement_slip.max' => '⚠ Payment slip size must not exceed 2MB.',
            ]);
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();



            $generateUUID = (string)Str::orderedUuid();

            if ($request->hasFile('payment_acknowledgement_slip')) {
                $file = $request->file('payment_acknowledgement_slip');
                $payment_acknowledgement_slip = 'payment_acknowledgement_slip/' . $session_worker_id . $generateUUID . '.' . $file->extension();

                Storage::disk('public')->put($payment_acknowledgement_slip, file_get_contents($file->getRealPath()));

                $payment_acknowledgement_slip_path = "/private/{$payment_acknowledgement_slip}";
                $payment_acknowledgement_slip_ext = $file->extension();
            }

            $data = TemporaryWorkerBasicDetail::Create([
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
                'other_state' => $request->other_state,
                'date_of_retirement' => $request->date_of_retirement
                    ? Carbon::parse($request->date_of_retirement)->format('Y-m-d')
                    : null,
                'payment_acknowledgement_slip' => $payment_acknowledgement_slip_path ?? null,
                'payment_acknowledgement_slip_ext' => $payment_acknowledgement_slip_ext ?? null,
            ]);


            Alert::toast('Basic Details Submitted Successfully', 'success');

            return redirect()->route('submit-basic-details');
        } catch (Exception $e) {
//             return $e;
            DB::rollBack();
            Alert::toast('Something went wrong', 'error');
            return back();
        }
    }

    /** end */
    /** update worker data if data already exists */
    public function updateBasic(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        // dd($request->resident_type);



        $validate = $request->validate([
            // 'worker_id' => 'unique:pgsql.Worker.temporary_worker_basic_details',
            'maritial_status_id' => 'required|exists:pgsql.Masterdata.marital_statuses,marital_code',
            'category' => 'required|exists:pgsql.Masterdata.categories,category_code',
            'eshram_no' => 'required|numeric|digits:12',
            'education_id' => 'required|exists:pgsql.Masterdata.educations,education_code',
            'email' => 'nullable|regex:/(.+)@(.+)\.(.+)/i',
            'pan' => 'required|in:1,0',
            'pan_no' => $request->input('pan') == '1' ? 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/|max:10' : '',
            'resident_type' => 'required|in:raa,rao',
            'state_id' => $request->input('resident_type') == 'rao' ? 'required|exists:pgsql.Masterdata.states,state_code' : '',
            'boc' => 'required|in:1,0',
            'boc_no' => $request->input('boc') == '1' ? 'required|string' : '',
            'has_ration_card' => 'required|in:0,1',
            'ration_no' => $request->has_ration_card == '1' ? 'required|string|max:255|regex:/^[a-zA-Z0-9\-\/]+$/'  // Adjust the regex pattern as needed
                : 'nullable',
            'ration_type' => $request->has_ration_card == '1' ? 'required|string|max:255' : '',
            'blood_group' => 'required|exists:pgsql.Masterdata.blood_groups,id',
            'other_state' => $request->input('boc') == '1' ? 'required|exists:pgsql.Masterdata.states,state_code' : ''
        ], [
            // 'worker_id.unique' => '⚠ The Worker is already registered!',
            'maritial_status_id.required' => '⚠ Please Select Marital Status',
            'category.required' => '⚠ Please Select Category',
            'education_id.required' => '⚠ Education Cannot Be Blank',
            'eshram_no.required' => '⚠ e-Shram No Cannot Be Blank',
            'eshram_no.digits' => 'e-Shram number must have exactly 12 digits',
            'state_id.required_if' => '⚠ State is required for the selected resident type.',
            'resident_type.required' => '⚠ Please select whether you are a Permanent Resident Of Assam or not',
            'pan.required' => '⚠ Please Select if you have pan card or not',
            'boc.required' => '⚠ Please Select if you are already registered with BOCW Board',
            'has_ration_card.required' => '⚠ Please Select whether you have a ration card or not',
            'ration_no.required' => '⚠ The Ration Card Number Cannot Be Blank',
            'ration_type.required' => '⚠ Please Select Ration Type',
            'blood_group.required' => '⚠ Please Select Blood Group ',
            'other_state.required' => '⚠ Select the State of the board under which you are registered with'

        ]);

        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->pluck('application_no')
            ->first();
        try {
            $data = TemporaryWorkerBasicDetail::where('worker_id', $session_worker_id)->update([
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
                'other_state' => $request->other_state,
                'date_of_retirement' => $request->date_of_retirement
                    ? Carbon::parse($request->date_of_retirement)->format('Y-m-d')
                    : null,
            ]);
        } catch (\Exception $e) {
//            return $e;
            DB::rollBack();

            Alert::toast('Something Went Wrong', 'error');
            return back();
        }
        Alert::toast('Basic Details Updated Successfully', 'success');
        return redirect()->route('submit-basic-details')->with('success');
    }

    /** Redirect to address page **/
    public function pageAddress(Request $request)
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
                $data['districts'] = DB::table('Masterdata.districts')
                    ->where('state_code', '=', 18)
                    ->orderBy('district_name')
                    ->get();

                return view('worker/edit.edit-worker-address-details', $data);
            } else {

                $data['residence'] = DB::table('Masterdata.residences')->get();
                $data['house'] = DB::table('Masterdata.houses')->get();
                $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                    ->where('worker_id', $session_worker_id)
                    ->pluck('application_no')
                    ->first();
                $data['resident_type'] = TemporaryWorkerBasicDetail::where('worker_id', $session_worker_id);
                $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_basic_details')->where('worker_id', $session_worker_id)->first();
                $data['districts'] = DB::table('Masterdata.districts')
                    ->where('state_code', '=', 18)
                    ->orderBy('district_name')
                    ->get();

                return view('worker.worker-address', $data);
            }
        } catch (Exception $e) {
            // return $e;
            DB::rollBack();
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }


    /** Save worker Address */
    public function saveAddress(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }

            // Validation rules
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

            TemporaryWorkerAddress::create([
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
                'landmark' => $request->landmark,
                'do' => $request->do,
                'type_of_document' => $request->type_of_document
            ]);

            Alert::toast('Address Details Submitted Successfully', 'success');
            return redirect()->route('save-address')->with('success');
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }


    public function updateAddress(Request $request)
    {

        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $checkboxChecked = $request->has('do') && $request->input('do') == 1;

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

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

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
                'landmark' => $request->landmark,
                'do' => $request->do,
                'type_of_document' => $request->type_of_document

            ]);
            Alert::toast('Address Details Updated Successfully', 'success');
            return redirect()->route('save-address')->with('success');
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }

    /** passing id to bank details page */
    public function pageBank(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_banks')
                ->where('worker_id', $session_worker_id)->first();
            if ($formdata) {
                $data['ifsc'] = DB::table('Worker.temporary_worker_banks as twbm')
                    // ->join('Masterdata.banks as bank', 'twbm.ifsc_pk', '=', 'bank.id')
                    ->where('worker_id', $session_worker_id)
                    ->select('twbm.*')
                    ->first();


                return view('worker/edit.edit-worker-bank-details', $data);
            } else {

                $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_addresses')->where('worker_id', $session_worker_id)->first();
                return view('worker.worker-bank-details', $data);
            }
        } catch (Exception $e) {
            //            return $e;
            DB::rollBack();
            Alert::toast('Something went wrong!', 'error');
            return back();
        }
    }

    public function saveBankDetails(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $validate = $request->validate([

                'bank_name' => 'required',
                'branch_name' => 'required',
                'bank_address' => 'required',
                'account_no' => 'required|numeric|digits_between:8,20',
                'account_no_confirmation' => 'required|numeric|digits_between:8,20'

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
            return redirect()->route('submit-bank')->with('success');
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }

    public function updateBank(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $validate = $request->validate([
                'bank_name' => 'required',
                'branch_name' => 'required',
                'bank_address' => 'required',
                'account_no' => 'required|numeric|digits_between:8,20',
                'account_no_confirmation' => 'required|numeric|digits_between:8,20'

            ], [
                'bank_name.required' => '⚠ Bank Number Cannot Be Blank',
                'branch_name.required' => '⚠ Branch Name Cannot Be Blank',
                'bank_address.required' => '⚠ Bank Address Cannot Be Blank',
                'account_no.required' => '⚠ Account No Cannot Be Blank',
                'account_no_confirmation.required' => '⚠ Confirmation of Account No Cannot Be Blank'

            ]);
            $data = TemporaryWorkerBank::where('worker_id', $session_worker_id)->update([
                'ifsc_pk' => 000,
                'ifsc_code' => $request->ifsc_code,
                'bank_name' => $request->bank_name,
                'branch_name' => $request->branch_name,
                'bank_address' => $request->bank_address,
                'account_no' => $request->account_no,
            ]);
            Alert::toast('Bank Details Updated Successfully', 'success');
            return redirect()->route('submit-bank')->with('success');
        } catch (Exception $e) {
            Alert::toast('Something went wrong', 'error');
            return back();
        }
        //        return redirect()->route('submit-bank')->with('success');
    }

    public function pageFamily(Request $request)
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
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            $data['formdata'] = $formdata = TemporaryWorkerFamily::where('worker_id', $session_worker_id)->first();
            $data['states'] = State::all();
            if ($formdata) {
                $data['formdata'] = DB::table('Worker.temporary_worker_families as twfm')
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
                return view('worker/edit.edit-worker-family-details', $data);
            } else {

                $data['relations'] = DB::table('Masterdata.relations')
                    ->select('relation_code', 'relation_name')
                    ->get();
                $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_forms as tfm')
                    ->join('Worker.temporary_worker_basic_details as twbd', 'tfm.worker_id', '=', 'twbd.worker_id')
                    ->where('tfm.worker_id', $session_worker_id)
                    ->select('tfm.*', 'twbd.*')
                    ->first();
                return view('worker.worker-family-details', $data);
            }
        } catch (Exception $e) {
            Alert::toast("Something went wrong", 'error');
            return back();
        }
    }

    public function saveFamily(Request $request)
    {
        // dd($request->all());
        try {
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
                //                'guardain_name.*' => 'nullable|regex:/^[a-zA-Z ]+$/',
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
                // 'already_registered' => 'required|array',
                // 'already_registered.*' => 'required|in:0,1',
                'bocwwb_id' => 'array',
                'bocwwb_id.*' => function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1]; // Get the index
                    $already_registered = $request->input('already_registered')[$index] ?? null;
                    $session_worker_id = session()->get('worker_id');

                    // Skip validation if value is null or not marked as already registered
                    if (is_null($value) || $already_registered != 1) {
                        return;
                    }


                    // Only validate if marked as already registered
                    if ($already_registered == 1) {
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
                            ->where('worker_id', '!=', $session_worker_id) // Exclude self
                            ->count();

                        $inMain = DB::table('Worker.main_worker_families')
                            ->where('bocwwb_id', $value)
                            ->where('worker_id', '!=', $session_worker_id) // Exclude self
                            ->count();

                        if ($inTemp > 0 || $inMain > 0) {
                            return $fail("⚠ BOCWWB ID {$value} already exists in database");
                        }
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
                'relation_others.*.regex' => '⚠ Invalid Name',
                'dob.*.required' => '⚠ Date of birth cannot be blank',
                'dob.*.date' => '⚠ The date of birth must be a valid date',
                'nominee.*.required' =>  '⚠ Please Select',
                'nominee_percentage.*.required_if' => '⚠ Nominee percentage field is required',
                'bocwwb_id.*.required_if' => '⚠ BOC Id field is required',
                // 'already_registered.*.required' => '⚠ Please Select',
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
                $normalized_name = strtolower($full_name); // Normalize to lowercase for comparison

                if (in_array($normalized_name, $names)) {
                    return response()->json(['errors' => ['name' => "⚠ Duplicate entry for $f_name {$l_names[$key]}"]], 200);
                }

                if ($normalized_name === strtolower($applicant_name)) {
                    return response()->json(['errors' => ['name' => "⚠ Applicant's name cannot be added as a family member"]], 200);
                }

                $names[] = $normalized_name;
            }


            $bocwwbIds = $request->bocwwb_id;
            DB::beginTransaction();

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
                        'bocwwb_id' => $bocwwbId ?? null,
                    ]);
                    // }

                    if ($data != true) {
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'WTF001 Error Code']);
                    }
                }
            }

            DB::commit();
            Alert::toast('Family Details Submitted Successfully', 'success');
            return response()->json(['success' => true, 'msg' => 'Family Details Submitted Successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast("Something went wrong!", 'error');
            return back();
        }

    }

    public function deleteFamilyMember(Request $request)
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


    public function updateFamily(Request $request)
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

                // Only validate if marked as already registered
                if ($already_registered == 1) {
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
                        ->where('worker_id', '!=', $session_worker_id) // Exclude self
                        ->count();

                    $inMain = DB::table('Worker.main_worker_families')
                        ->where('bocwwb_id', $value)
                        ->where('worker_id', '!=', $session_worker_id) // Exclude self
                        ->count();

                    if ($inTemp > 0 || $inMain > 0) {
                        return $fail("⚠ BOCWWB ID {$value} already exists in database");
                    }
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
            $normalized_name = strtolower($full_name); // Normalize to lowercase for comparison

            if (in_array($normalized_name, $names)) {
                return response()->json(['errors' => ['name' => "⚠ Duplicate entry for $f_name {$l_names[$key]}"]], 200);
            }

            if ($normalized_name === strtolower($applicant_name)) {
                return response()->json(['errors' => ['name' => "⚠ Applicant's name cannot be added as a family member"]], 200);
            }

            $names[] = $normalized_name;
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


    public function pageEmployer()
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
            $data['temp_employer'] = $employer = DB::table('Worker.temporary_worker_employer_details')
                ->where('worker_id', $session_worker_id)
                ->first();

            $temporary_certificate_data = DB::table('Worker.temporary_worker_certificates')
                ->where('worker_id', $session_worker_id)
                ->get();
            $employer_data = $employer ? json_decode(json_encode($employer), true) : [];
            $temporary_certificate_data = json_decode(json_encode($temporary_certificate_data), true);
            $data['formdata'] = $formdata = array_merge($employer_data, $temporary_certificate_data);
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            if ($formdata) {
                $data['twed'] = DB::table('Worker.temporary_worker_employer_details as twed')
                    ->join('Masterdata.type_of_works as tow', 'twed.type_of_work', '=', 'tow.work_type_code')
                    ->join('Masterdata.nature_of_works as now', 'twed.nature_of_work', '=', 'now.nature_of_work_code')
                    ->join('Masterdata.type_of_employers as toe', 'twed.type_of_employer', '=', 'toe.employer_code')
                    ->where('worker_id', $session_worker_id)
                    ->select(
                        'twed.*',
                        'tow.*',
                        'now.*',
                        'toe.employer_code',
                        'toe.employer_name AS empname'
                    )
                    ->first();

                $data['twc'] = DB::table('Worker.temporary_worker_certificates as twc')
                    ->join('Masterdata.type_of_issuers as tot', 'twc.type_of_issuer', '=', 'tot.issuer_code')
                    ->join('Masterdata.type_of_employers as toe', 'twc.type_of_employer', '=', 'toe.employer_code')
                    ->join('Masterdata.type_of_works as tow', 'twc.type_of_work', '=', 'tow.work_type_code')
                    ->join('Masterdata.professions as pro', 'twc.profession', '=', 'pro.profession_code')
                    ->where('twc.worker_id', $session_worker_id)
                    ->select(
                        'twc.id',
                        'twc.worker_id',
                        'twc.application_no',
                        'twc.type_of_issuer',
                        'twc.issuing_org',
                        'twc.issue_date',
                        'twc.issuing_person',
                        'twc.contact_issuing_person',
                        'twc.is_same',
                        'twc.employer_name AS emp',
                        'twc.employer_contact_number',
                        'twc.from_date',
                        'twc.to_date',
                        'twc.type_of_employer',
                        'twc.certificate_proof',
                        'twc.id as certificate_proof_id',
                        'twc.profession',
                        'twc.profession_others',
                        'twc.date_count',
                        'tot.*',
                        'toe.employer_code',
                        'toe.employer_name AS empname',
                        'twc.type_of_work',
                        'tow.work_type_code',
                        'tow.work_type_name',
                        'pro.*'
                    )
                    ->get();

                $data['ndc'] = WorkerNinetyDaysCertificate::where('worker_id', $session_worker_id)->get();

                foreach ($data['twc'] as $record) {
                    // Assuming you have start_date and end_date columns in your database
                    $startDate = new DateTime($record->from_date);
                    $endDate = new DateTime($record->to_date);

                    $dateInterval = $startDate->diff($endDate);
                    $record->number_of_days = $dateInterval->days;
                }


                $data['type_of_issuer'] = DB::table('Masterdata.type_of_issuers')
                    ->select('issuer_code', 'issuer_name')
                    ->orderBy('issuer_name','asc')
                    ->get();

                $data['worktype'] = DB::table('Masterdata.type_of_works')
                    ->select('work_type_code', 'work_type_name')
                    ->orderBy('work_type_name','asc')
                    ->get();
                $data['worknature'] = DB::table('Masterdata.nature_of_works')
                    ->select('nature_of_work_code', 'nature_of_work')
                    ->orderBy('nature_of_work','asc')
                    ->get();
                $data['type_of_employers'] = DB::table('Masterdata.type_of_employers')
                    ->select('employer_code', 'employer_name')
                    ->get();

                $data['professions'] = DB::table('Masterdata.professions')
                    ->select('profession_code', 'profession_name')
                    ->orderBy('profession_name','asc')
                    ->get();

                return view('worker/edit.edit-worker-employer-details', $data);
            } else {
                $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_families')
                    ->where('worker_id', $session_worker_id)
                    ->first();
                $data['type_of_issuer'] = DB::table('Masterdata.type_of_issuers')
                    ->select('issuer_code', 'issuer_name')
                    ->orderBy('issuer_name','asc')
                    ->get();

                $data['worktype'] = DB::table('Masterdata.type_of_works')
                    ->select('work_type_code', 'work_type_name')
                    ->get();
                $data['worknature'] = DB::table('Masterdata.nature_of_works')
                    ->select('nature_of_work_code', 'nature_of_work')
                    ->orderBy('nature_of_work','asc')
                    ->get();
                $data['type_of_employers'] = DB::table('Masterdata.type_of_employers')
                    ->select('employer_code', 'employer_name')
                    ->get();
                $data['professions'] = DB::table('Masterdata.professions')
                    ->select('profession_code', 'profession_name')
                    ->orderBy('profession_name','asc')
                    ->get();
                return view('worker.worker-employer-details', $data);
            }
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }



    public function saveEmployer(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }


        $employerValidator = Validator::make(
            $request->all(),
            [
                'type_of_issuer.*' => 'required|exists:pgsql.Masterdata.type_of_issuers,issuer_code',
                'issuing_org.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'issue_date.*' => 'required|date',
                'issuing_person.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'contact_issuing_person.*' => 'required|digits:10',
                'type_of_work.*' => 'required|exists:pgsql.Masterdata.type_of_works,work_type_code',
                'is_same.*' => 'required',
                'employer_name_certi.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                // 'employer_contact_name.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'employer_contact_number.*' => 'required|numeric',
                'from_date.*' => 'required|date',
                'to_date.*' => 'required|date',
                'date_count.*' => 'required|numeric',
                'type_of_employer.*' => 'required|exists:pgsql.Masterdata.type_of_employers,employer_code',
                'certificate_proof.*' => 'required|file|mimes:pdf|max:1000',
                'profession.*' => 'exists:pgsql.Masterdata.professions,profession_code', // Validate each profession code
                'profession_others.*' => function ($attribute, $value, $fail) use ($request) {
                    if (is_array($request->input('profession')) && in_array('28', $request->input('profession'))) {
                        if (empty($value)) {
                            $fail('The profession others field is required when profession is Others');
                        } elseif (!is_string($value)) {
                            $fail('The profession others field must be a string.');
                        }
                    }
                }
            ],
            [

                'type_of_issuer.*.required' => '⚠ Please Select.',
                'issuing_org.*.required' => '⚠ The Name of Issuing Organization Cannot Be Blank.',

                'issue_date.*.required' => '⚠ The Date of issue Cannot Be Blank.',
                'issuing_person.*.required' => '⚠ The Name of Issuing Person Cannot Be Blank.',
                'contact_issuing_person.*.required' => '⚠ The Contact No of Issuing Person Cannot Be Blank.',
                'contact_issuing_person.*.numeric' => '⚠ Contact No of Issuing Person Should be a number.',
                'type_of_work.*.required' => '⚠ Please Select.',
                'is_same.*.required' => '⚠ Please Select.',
                'employer_name_certi.*.required' => '⚠ The Employer Name Cannot Be Blank.',
                'employer_contact_number.*.required' => '⚠ The Employer Contact Number Cannot Be Blank.',
                'employer_contact_number.*.numeric' => '⚠ Employer Contact Number Should be a number',
                'from_date.*.required' => '⚠ The From Date Cannot Be Blank.',
                'from_date.*.date' => '⚠ Please enter a valid date.',
                'to_date.*.required' => '⚠ The To Date Cannot Be Blank.',
                'to_date.*.date' => '⚠ Please enter a valid date.',
                'date_count.*.required' => '⚠ Please enter the number of days',
                'type_of_employer.*.required' => '⚠ Please Select.',
                'profession.*.required' => '⚠ Please Select Profession',
                'certificate_proof.*.required' => '⚠ Please upload a certificate proof.',
                'certificate_proof.*.file' => '⚠ The certificate proof must be a valid file.',
                'certificate_proof.*.mimes' => '⚠ The certificate proof must be a PDF file.',
                'certificate_proof.*.max' => '⚠ The certificate proof file size must not exceed 1MB.',

            ]
        );

        if ($employerValidator->fails()) {
            return response()->json(['errors' => $employerValidator->errors()], 200);
        }
        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->pluck('application_no')
            ->first();
        DB::beginTransaction();
        try {
            $certificateData = [];
            $f_names = $request->type_of_issuer;  // Assuming type_of_issuer is an array

            if (is_array($f_names) && !empty($f_names)) {
                $files = $request->file('certificate_proof');  // Retrieve the uploaded files

                foreach ($f_names as $key => $f_name) {
                    // Check if a file is uploaded for this entry
                    if (isset($files[$key])) {
                        $file = $files[$key];
                        if ($file) {
                            $originalName = $file->extension();
                            $string = Str::uuid();
                            $certificate_proof_name = 'certificate-proof/' . $session_worker_id . '.' . $string . '.' . $originalName;
                            Storage::disk('public')->put($certificate_proof_name, file_get_contents($file->getRealPath()));
                            $filePath = "/private/{$certificate_proof_name}";
                            $filePaths[$key] = $filePath;
                        }
                    } else {
                        // If no file is uploaded for this entry, return an error response
                        return response()->json([
                            'success' => false,
                            'errors' => [
                                "certificate_proof.$key" => ["⚠ Certificate proof is required."]
                            ]
                        ], 200);
                    }

                    // Insert the data into the database
                    $certificateData[] = TemporaryWorkerCertificate::Create([
                        'worker_id' => $session_worker_id,
                        'type_of_issuer' => $f_names[$key],
                        'application_no' => $data['application_no'],
                        'issuing_org' => $request->issuing_org[$key],
                        'issue_date' => $request->issue_date[$key],
                        'issuing_person' => $request->issuing_person[$key],
                        'contact_issuing_person' => $request->contact_issuing_person[$key],
                        'is_same' => $request->is_same[$key],
                        'type_of_work' => $request->type_of_work[$key],
                        'type_of_work_others' => $request->type_of_work_others[$key],
                        'employer_name' => $request->employer_name_certi[$key],
                        'employer_contact_number' => $request->employer_contact_number[$key],
                        'from_date' => $request->from_date[$key],
                        'to_date' => $request->to_date[$key],
                        'date_count' => $request->date_count[$key],
                        'type_of_employer' => $request->type_of_employer[$key],
                        'certificate_proof' => $filePaths[$key],
                        'profession' => $request->profession[$key],
                        'profession_others' => $request->profession_others[$key]
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WEC001,Database Exception Error']);
        }
        Alert::toast('Certificate Details Saved Successfully', 'success');
        return response()->json(['success' => true, 'msg' => 'Certificate Details Updated!']);
    }
    public function destroyCertificate($id)
    {
        $certificate = DB::table('Worker.temporary_worker_certificates')->first();



        if ($certificate->certificate_proof && Storage::disk('public')->exists($certificate->certificate_proof)) {
            Storage::disk('public')->delete($certificate->certificate_proof);
        }


        DB::table('Worker.temporary_worker_certificates')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Certificate deleted successfully.']);
    }



    public function updateEmployer(Request $request)
    {

        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }


        $employerValidator = Validator::make(
            $request->all(),
            [
                'type_of_issuer.*' => 'required|exists:pgsql.Masterdata.type_of_issuers,issuer_code',
                'issuing_org.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'issue_date.*' => 'required|date',
                'issuing_person.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'contact_issuing_person.*' => 'required|digits:10',
                'type_of_work.*' => 'required|exists:pgsql.Masterdata.type_of_works,work_type_code',
                'is_same.*' => 'required',
                'employer_name_certi.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                // 'employer_contact_name.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'employer_contact_number.*' => 'required|numeric',
                'from_date.*' => 'required|date',
                'to_date.*' => 'required|date',
                'type_of_employer.*' => 'required|exists:pgsql.Masterdata.type_of_employers,employer_code',
                'certificate_proof.*' => 'required|file|mimes:pdf|max:1000',
                'profession.*' => 'exists:pgsql.Masterdata.professions,profession_code', // Validate each profession code
                'profession_others.*' => function ($attribute, $value, $fail) use ($request) {
                    if (is_array($request->input('profession')) && in_array('28', $request->input('profession'))) {
                        if (empty($value)) {
                            $fail('The profession others field is required when profession is Others');
                        } elseif (!is_string($value)) {
                            $fail('The profession others field must be a string.');
                        }
                    }
                }
            ],
            [
                'type_of_issuer.*.required' => '⚠ Please Select.',
                'issuing_org.*.required' => '⚠ The Name of Issuing Organization Cannot Be Blank.',

                'issue_date.*.required' => '⚠ The Date of issue Cannot Be Blank.',
                'issuing_person.*.required' => '⚠ The Name of Issuing Person Cannot Be Blank.',
                'contact_issuing_person.*.required' => '⚠ The Contact No of Issuing Person Cannot Be Blank.',
                'contact_issuing_person.*.numeric' => '⚠ Contact No of Issuing Person Should be a number.',
                'type_of_work.*.required' => '⚠ Please Select.',
                'is_same.*.required' => '⚠ Please Select.',
                'employer_name_certi.*.required' => '⚠ The Employer Name Cannot Be Blank.',
                // 'employer_contact_name.*.required' => '⚠ The Employer Contact Name Cannot Be Blank.',
                'employer_contact_number.*.required' => '⚠ The Employer Contact Number Cannot Be Blank.',
                'employer_contact_number.*.numeric' => '⚠ Employer Contact Number Should be a number',
                'from_date.*.required' => '⚠ The From Date Cannot Be Blank.',
                'from_date.*.date' => '⚠ Please enter a valid date.',
                'to_date.*.required' => '⚠ The To Date Cannot Be Blank.',
                'to_date.*.date' => '⚠ Please enter a valid date.',
                'type_of_employer.*.required' => '⚠ Please Select.',
                'certificate_proof.*.required' => '⚠ File Cannot be Blank',
                'certificate_proof.*.file' => '⚠ Invalid File type',
                'certificate_proof.*.mimes' => '⚠ Only PDF files are allowed',
                'certificate_proof.*.max' => '⚠ File size cannot exceed 2MB',
                'profession.*.required' => '⚠ Please Select Profession',
            ]
        );
        if ($employerValidator->fails()) {
            return response()->json(['errors' => $employerValidator->errors()], 200);
        }
        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->pluck('application_no')
            ->first();

        DB::beginTransaction();
        try {

            $certificateData = [];
            $f_names = $request->type_of_issuer;
            if (is_array($f_names) && !empty($f_names)) {
                $files = $request->file('certificate_proof');


                foreach ($f_names as $key => $f_name) {
                    if (!isset($request->certificate_proof_id[$key])) {
                        if (!isset($files[$key]) || !$files[$key]) {
                        }

                        $file = $files[$key];

                        $originalName = $file->extension();
                        $string = Str::uuid();
                        $certificate_proof_name = 'certificate-proof/' . $session_worker_id . '.' . $string . '.' . $originalName;
                        Storage::disk('public')->put($certificate_proof_name, file_get_contents($file->getRealPath()));
                        $filePath = "/private/{$certificate_proof_name}";
                        $filePaths[$key] = $filePath;
                        $certificateData1[] = TemporaryWorkerCertificate::Create([
                            'worker_id' => $session_worker_id,
                            'type_of_issuer' => $f_names[$key],
                            'application_no' => $data['application_no'],
                            'issuing_org' => $request->issuing_org[$key],
                            'issue_date' => $request->issue_date[$key],
                            'issuing_person' => $request->issuing_person[$key],
                            'contact_issuing_person' => $request->contact_issuing_person[$key],
                            'is_same' => $request->is_same[$key],
                            'type_of_work' => $request->type_of_work[$key],
                            'type_of_work_others' => $request->type_of_work_others[$key],
                            'employer_name' => $request->employer_name_certi[$key],
                            'employer_contact_number' => $request->employer_contact_number[$key],
                            'from_date' => $request->from_date[$key],
                            'to_date' => $request->to_date[$key],
                            'date_count' => $request->date_count[$key],
                            'type_of_employer' => $request->type_of_employer[$key],
                            'certificate_proof' => $filePaths[$key],
                            'profession' => $request->profession[$key],
                            'profession_others' => $request->profession_others[$key]
                        ]);
                    } else {
                        if (isset($files[$key])) {
                            $file = $files[$key];
                            $originalName = $file->extension();
                            $string = Str::uuid();
                            $certificate_proof_name = 'certificate-proof/' . $session_worker_id . '.' . $string . '.' . $originalName;
                            Storage::disk('public')->put($certificate_proof_name, file_get_contents($file->getRealPath()));
                            $filePath = "/private/{$certificate_proof_name}";
                            $filePaths[$key] = $filePath;


                            $certificateData[] = TemporaryWorkerCertificate::where('worker_id', $session_worker_id)
                                ->where('id', $request->certificate_proof_id[$key])
                                ->update([
                                    'worker_id' => $session_worker_id,
                                    'type_of_issuer' => $f_names[$key],
                                    'application_no' => $data['application_no'],
                                    'issuing_org' => $request->issuing_org[$key],
                                    'issue_date' => $request->issue_date[$key],
                                    'issuing_person' => $request->issuing_person[$key],
                                    'contact_issuing_person' => $request->contact_issuing_person[$key],
                                    'is_same' => $request->is_same[$key],
                                    'type_of_work' => $request->type_of_work[$key],
                                    'type_of_work_others' => $request->type_of_work_others[$key],
                                    'employer_name' => $request->employer_name_certi[$key],
                                    'employer_contact_number' => $request->employer_contact_number[$key],
                                    'from_date' => $request->from_date[$key],
                                    'to_date' => $request->to_date[$key],
                                    'date_count' => $request->date_count[$key],
                                    'type_of_employer' => $request->type_of_employer[$key],
                                    'certificate_proof' => $filePaths[$key],
                                    'profession' => $request->profession[$key],
                                    'profession_others' => $request->profession_others[$key]
                                ]);
                        } else {

                            $certificateData3[] = TemporaryWorkerCertificate::where('worker_id', $session_worker_id)
                                ->where('id', $request->certificate_proof_id[$key])
                                ->update([
                                    'worker_id' => $session_worker_id,
                                    'type_of_issuer' => $f_names[$key],
                                    'application_no' => $data['application_no'],
                                    'issuing_org' => $request->issuing_org[$key],
                                    'issue_date' => $request->issue_date[$key],
                                    'issuing_person' => $request->issuing_person[$key],
                                    'contact_issuing_person' => $request->contact_issuing_person[$key],
                                    'is_same' => $request->is_same[$key],
                                    'type_of_work' => $request->type_of_work[$key],
                                    'type_of_work_others' => $request->type_of_work_others[$key],
                                    'employer_name' => $request->employer_name_certi[$key],
                                    'employer_contact_number' => $request->employer_contact_number[$key],
                                    'from_date' => $request->from_date[$key],
                                    'to_date' => $request->to_date[$key],
                                    'date_count' => $request->date_count[$key],
                                    'type_of_employer' => $request->type_of_employer[$key],
                                    // 'certificate_proof' => $filePaths[$key],
                                    'profession' => $request->profession[$key],
                                    'profession_others' => $request->profession_others[$key]

                                ]);
                        }
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WEC001,Database Exception Error']);
        }
        Alert::toast('Certificate Details Updated Successfully', 'success');
        return response()->json(['success' => true, 'msg' => 'Certificate Details Updated!']);
    }





    public function pageSchemes(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_schemes')->where('worker_id', $session_worker_id)->first();
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            if ($formdata) {
                $data['tws'] = DB::table('Worker.temporary_worker_schemes as tws')
                    ->leftjoin('Masterdata.schemes as sch', 'tws.scheme_name', '=', 'sch.scheme_code')
                    ->where('tws.worker_id', $session_worker_id)
                    ->select('tws.*', 'sch.*')
                    ->get();
                $data['schemes'] = DB::table('Masterdata.schemes')
                    ->select('scheme_code', 'scheme_name')->get();
                return view('worker.edit.edit-worker-schemes', $data);
            } else {
                $data['schemes'] = DB::table('Masterdata.schemes')
                    ->select('scheme_code', 'scheme_name')->get();
                return view('worker.worker-schemes', $data);
            }
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }

    public function saveScheme(Request $request)
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

        DB::beginTransaction();
        try {
            $session_worker_id = session()->get('worker_id');
            $application_no = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();

            $schemes = $request->scheme_name;

            if (is_array($schemes) && !empty($schemes)) {
                foreach ($schemes as $key => $scheme) {
                    TemporaryWorkerScheme::create([
                        'worker_id' => $session_worker_id,
                        'application_no' => $application_no,
                        'enrolled' => $request->enrolled,
                        'scheme_name' => $scheme,
                        'registration_id' => $request->registration_id[$key],
                        'date' => $request->date[$key],
                    ]);
                }
            }

            DB::commit();

            Alert::toast('Scheme Details Submitted Successfully', 'success');
            return response()->json(['success' => true, 'msg' => 'Scheme Details Submitted!']);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollback();
            return redirect()->back()->with('error', '#WSM0002 DB exception error!');
        }
    }



    public function updateScheme(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'enrolled' => 'required|in:1,0',
            'scheme_name' => 'required_if:enrolled,1|array',
            'scheme_name.*' => 'nullable|required_if:enrolled,1', // Added string|max:255 for completeness
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
        try {
            $session_worker_id = session()->get('worker_id');
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            $schemes = $request->scheme_name;
            $session_worker_id = session()->get('worker_id');

            DB::beginTransaction();
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

            Alert::toast('Scheme Details Updated Successfully', 'success');
            return response()->json(['success' => true, 'msg' => 'Scheme Details Updated!']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WSD001,Something Went Wrong!']);
        }
    }


    public function pageDocument(Request $request)
    {
        try {
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
            $formdata = TemporaryWorkerDocument::where('worker_id', $session_worker_id)->first();

            $has_do_address = DB::table('Worker.temporary_worker_addresses')
                ->where('worker_id', $session_worker_id)
                ->pluck('do')
                ->first();

            $has_type_of_document = DB::table('Worker.temporary_worker_addresses')
                ->where('worker_id', $session_worker_id)
                ->pluck('type_of_document')
                ->first();
            // dd($has_ration_card);



            $has_ration_card = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('has_ration_card')
                ->first();

            $has_pan = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('pan')
                ->first();

            // $has_ack_no = TemporaryWorkerForm::where('worker_id', $session_worker_id)
            //     ->where('already_payment_status', true)
            //     ->exists();



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

            if (($emptyField == 'ration_card' && $has_ration_card == 0) || ($emptyField == 'pan_card' && $has_pan == 0) || ($emptyField == 'do' && $has_do_address == 1)) {
                $readonly = false;
            }

            $application_no = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();

            $twd = DB::table('Worker.temporary_worker_documents as twd')
                ->where('worker_id', $session_worker_id)
                ->first();

            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $getVaultData = json_decode($vaultData->getData(), true);
            $base64Image = $getVaultData['photo'];
            $documents = collect([
                ['id' => 1, 'name' => 'residential_proof', 'label' => 'Present Address Proof ', 'uploaded' => !empty($twd->residential_proof)],
                ['id' => 2, 'name' => 'worker_bank_copy', 'label' => 'Bank Passbook Copy (Aadhar Linked Bank Account)', 'uploaded' => !empty($twd->worker_bank_copy)],
                ['id' => 3, 'name' => 'ration_card', 'label' => 'Ration Card', 'uploaded' => !empty($twd->ration_card)],
                ['id' => 5, 'name' => 'pan_card', 'label' => 'PAN Card', 'uploaded' => !empty($twd->pan_card)],
            ]);

            return view('worker.worker-documents', compact(
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
                'remarks'
            ));
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }



    public function saveDocument(Request $request)
    {
        try {
            $mimes = env('DOCUMENT_MIME_TYPES');

            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }


            $validator = Validator::make(
                $request->all(),
                [
                    "document_id" => ['required', 'in:1,2,3,4,5,6'],
                    "residential_proof" => 'required_if:document_id,1|mimes:pdf',
                    "worker_bank_copy" => 'required_if:document_id,2|mimes:pdf',
                    "ration_card" => 'required_if:document_id,3|mimes:pdf',
                    "nominee_bank_copy" => 'required_if:document_id,4|mimes:pdf',
                    "pan_card" => 'required_if:document_id,5|mimes:pdf',
                    "payment_acknowledgement_slip" => 'required_if:document_id,6|mimes:pdf'
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

                $worker_bank_copy =  'worker-bank-photocopy/' . $session_worker_id . $generateUUID . '.' . $request->worker_bank_copy->extension();
                Storage::disk('public')->put($worker_bank_copy, file_get_contents($request->worker_bank_copy->getRealPath()));

                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->worker_bank_copy = "/private/{$worker_bank_copy}";
                $temporaryWorker->worker_bank_copy_ext = $request->worker_bank_copy->extension();
                $temporaryWorker->save();
                Alert::toast("Bank Copy Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 3) {

                $ration_card =  'ration-card/' . $session_worker_id . $generateUUID . '.' . $request->ration_card->extension();
                Storage::disk('public')->put($ration_card, file_get_contents($request->ration_card->getRealPath()));


                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->ration_card = "/private/{$ration_card}";
                $temporaryWorker->ration_card_ext = $request->ration_card->extension();
                $temporaryWorker->save();

                Alert::toast("Ration Card Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 4) {

                $nominee_bank_copy =  'nominee-bank-copy/' . $session_worker_id . $generateUUID . '.' . $request->nominee_bank_copy->extension();
                Storage::disk('public')->put($nominee_bank_copy, file_get_contents($request->nominee_bank_copy->getRealPath()));

                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->nominee_bank_copy = "/private/{$nominee_bank_copy}";
                $temporaryWorker->nominee_bank_copy_ext = $request->nominee_bank_copy->extension();
                $temporaryWorker->save();

                Alert::toast("Nominee Bank Copy Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 5) {
                $pan_card =  'pan-card/' . $session_worker_id . $generateUUID . '.' . $request->pan_card->extension();
                Storage::disk('public')->put($pan_card, file_get_contents($request->pan_card->getRealPath()));


                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->pan_card = "/private/{$pan_card}";
                $temporaryWorker->pan_card_ext = $request->pan_card->extension();
                $temporaryWorker->save();

                Alert::toast("Nominee Bank Copy Uploaded successfully", "success");
                return redirect()->back();
            }

            if ($request->document_id == 6) {
                $validate = $request->validate([
                    'payment_acknowledgement_slip' => 'required|' . $mimes . '|' . env('DOCUMENT_UPLOAD_SIZE')
                ]);

                $payment_acknowledgement_slip =  'payment_acknowledgement_slip/' . $session_worker_id . $generateUUID . '.' . $request->payment_acknowledgement_slip->extension();
                Storage::disk('public')->put($payment_acknowledgement_slip, file_get_contents($request->payment_acknowledgement_slip->getRealPath()));


                $temporaryWorker->worker_id = $session_worker_id;
                $temporaryWorker->payment_acknowledgement_slip = "/private/{$payment_acknowledgement_slip}";
                $temporaryWorker->payment_acknowledgement_slip_ext = $request->payment_acknowledgement_slip->extension();
                $temporaryWorker->save();

                Alert::toast("Acknowledgement slip uploaded successfully", "success");
                return redirect()->back();
            }
        } catch (Exception $e) {
            //            return $e;
            DB::rollBack();
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }

    /** Go to preview page */
    public  function previewPage(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $maskAadharNumber = function ($aadharNumber) {
                return str_repeat('*', 8) . substr($aadharNumber, 8);
            };
            $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('application_status', 'G')->count();
            $data['remarks'] = '';
            if ($remarks > 0) {
                $remarks = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                    ->where('application_status', 'G')
                    ->first();
            }

            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $getVaultData = json_decode($vaultData->getData(), true);

            if (isset($getVaultData['uID'])) {
                $getVaultDatauID = $maskAadharNumber($getVaultData['uID']);
            }

            $dists = District::where('state_code', '=', 18)->get();

            $worker_details = TemporaryWorkerForm::where('worker_id', $session_worker_id)->first();
            $has_ration_card = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('has_ration_card')
                ->first();

            $has_pan = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('pan')
                ->first();

            $has_ack_no = TemporaryWorkerForm::where('worker_id', $session_worker_id)
                ->where('already_payment_status', true)
                ->exists();

            $aadhar_photo = $getVaultData['photo'];

            return view('worker.worker-preview-details', compact('worker_details', 'getVaultData', 'has_ration_card', 'has_pan', 'aadhar_photo', 'getVaultDatauID', 'has_ack_no', 'remarks', 'dists'));
        } catch (Exception $e) {
            //            return $e;
            DB::rollBack();
            Alert::toast("Something went wrong!", "error");
            return back();
        }
    }

    public function getIdProof()
    {
        $session_worker_id = session()->get('worker_id');

        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $id_proof = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$id_proof || !$id_proof->id_proof) {
            abort(404, 'ID Proof not found');
        }

        $dbPath = $id_proof->id_proof;

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

        abort(404, 'ID Proof file not found');
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

    public function getAgeProof()
    {
        $session_worker_id = session()->get('worker_id');

        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $age_proof = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$age_proof || !$age_proof->age_proof) {
            abort(404, 'Age proof not found');
        }

        $dbPath = $age_proof->age_proof;

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

        abort(404, 'Age proof file not found');
    }
    public function getWorkerBankCopy()
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

    public function paymentAcknowledgementSlip($id)
    {
        $session_worker_id = session()->get('worker_id');

        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $paymentSlip = DB::table('Worker.temporary_worker_basic_details')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$paymentSlip || !$paymentSlip->payment_acknowledgement_slip) {
            abort(404, 'Payment acknowledgement slip not found');
        }

        $dbPath = $paymentSlip->payment_acknowledgement_slip;

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

        abort(404, 'Payment acknowledgement slip file not found');
    }

    public function getCertProof($id)
    {
        $session_worker_id = session()->get('worker_id');

        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $cert_proof = DB::table('Worker.temporary_worker_certificates')
            ->where('worker_id', $session_worker_id)
            ->where('id', $id)
            ->first();

        if (!$cert_proof || !$cert_proof->certificate_proof) {
            abort(404, 'Certificate proof not found');
        }

        $dbPath = $cert_proof->certificate_proof;

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

        abort(404, 'Certificate proof file not found');
    }


    public function getNomineeBankCopy()
    {
        $session_worker_id = session()->get('worker_id');

        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $bank_copy = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();

        if (!$bank_copy || !$bank_copy->nominee_bank_copy) {
            abort(404, 'Nominee bank copy not found');
        }

        $dbPath = $bank_copy->nominee_bank_copy;

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

        abort(404, 'Nominee bank copy file not found');
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

    public function getWorkBook($worker_id)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $workbook = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($workbook->work_book);
        return response()->file($file);
    }

    public function finalSubmit(Request $request)
    {

        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

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
            //
            $query  = MainVaultData::where('vaultToken', $tokensOld)->first();
            $vaultTokenMain = MainVaultData::where('vaultToken', $tokensOld)->count();

            if ($vaultTokenMain > 0) {
                $workerId = $query->worker_id;
                $contactNo = $query->workerPhone->phone_no ?? 'Not Available';
                Alert::error(
                    "Application Data Found!
                    Worker ID: {$workerId}
                    Mobile No: {$contactNo}
                    Please Login and Pay the Registration Fee!",
                    'error'
                );
                return redirect()->route('home.index');
            }
            $result = MainVaultData::create([
                'worker_id' => $session_worker_id,
                'vaultToken' => $tokensOld,
            ]);

            if (!$result) {
                DB::rollBack();
                Alert::error('Something Went Wrong!', 'error');
                return redirect()->route('home.index');
            }
            $tfm = DB::table('Worker.temporary_worker_forms')->where('worker_id', $session_worker_id)->first();
            if ($tfm) {
                $revert_status = RevertBack::where('worker_id', $session_worker_id)->count();
                if ($revert_status>0)
                {
                    $ackNo = RevertBack::where('worker_id', $session_worker_id)->value('ack_no');
                }
                else{
                    $application_no = $tfm->application_no;
                    $district = $tfm->office_id;
                    $year = Carbon::now()->format('Y');
                    $string = 'ABOCWWB';
                    $text = 'REG';
                    $ackNo = $string . '/' . $district . '/' . $year . '/' . $text . '/' . $application_no;
                }

            } else {
                // Handle case where no record is found for the provided worker ID
                $ackNo = 'Error: No record found';
            }


            $twbd = DB::table('Worker.temporary_worker_basic_details')->where('worker_id', $session_worker_id)->first();
            if (session()->has('pfcData')) {
                $isSewaSetu = true;
            }
            $data = MainWorkerForm::Create([
                'worker_id' => $session_worker_id,
                'office_id' => $tfm->office_id,
                'phone_no' => $tfm->phone_no,
                'district' => $tfm->district_id,
                'application_no' => $tfm->application_no,
                'ack_no' => $ackNo,
                'already_payment_status' => $tfm->already_payment_status,
                'ack_transaction_id' => $tfm->ack_transaction_id,
                'ack_payment_date' => $tfm->ack_payment_date,
                'ack_payment_amount' => $tfm->ack_payment_amount,
                'previous_acknowledgement_number' => $tfm->previous_acknowledgement_number,
                'status' => env('APPLICATION_SUBMIT_STATUS'),
                'active_status' => '0',
                'date_of_retirement' => $twbd->date_of_retirement,
                'application_type' => 1,
                'vaultToken' => $tfm->vaultToken,
                'vaultPassKey' => $tfm->vaultPassKey,


            ]);

            $cardValidityDate = Carbon::parse($data->created_at)->addYears(2)->subDay();

            $data->update([
                'id_card_expiry_date' => $cardValidityDate,
            ]);

//            $data = WorkerApplicationStatus::Create([
//                'worker_id' => $session_worker_id,
//                'application_no' => $tfm->application_no,
//                'ack_no' => $ackNo,
//                'office_id' => $tfm->office_id,
//                'application_status' => env('APPLICATION_SUBMIT_STATUS'),
//                'remarks' => 'Application Submitted',
//            ]);

            // User
            $data = MainWorkerBasicDetail::Create([
                'worker_id' => $twbd->worker_id,
                'application_no' => $tfm->application_no,
                'date_of_retirement' => $twbd->date_of_retirement,
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
                'other_state' => $twbd->other_state,
                'payment_acknowledgement_slip' => $twbd->payment_acknowledgement_slip,
                'payment_acknowldegement_slip_ext' => $twbd->payment_acknowledgement_slip_ext
            ]);
            $twam = DB::table('Worker.temporary_worker_addresses')->where('worker_id', $session_worker_id)->first();
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
                'landmark' => $twam->landmark,
                'do' => $twam->do,

            ]);
            $data['twfms'] =  DB::table('Worker.temporary_worker_families')->where('worker_id', $session_worker_id)->get();
            foreach ($data['twfms'] as $twfm) {
                $data = MainWorkerFamily::Create([
                    'worker_id' => $session_worker_id,
                    'application_no' => $tfm->application_no,
                    'first_name' => $twfm->first_name,
                    'last_name' => $twfm->last_name,
                    'guardain_name' => $twfm->guardain_name ?? '',
                    'dob' => $twfm->dob,
                    'relation' => $twfm->relation,
                    'relation_others' => $twfm->relation_others,
                    'nominee_percentage' => $twfm->nominee_percentage,
                    'nominee' => $twfm->nominee,
                    'already_registered' => $twfm->already_registered,
                    'already_registered_state' => $twfm->already_registered_state,
                    'bocwwb_id' => $twfm->bocwwb_id,
                ]);
            }

            $twbm = DB::table('Worker.temporary_worker_banks')->where('worker_id', $session_worker_id)->first();
            $data = MainWorkerBank::Create([
                'worker_id' => $session_worker_id,
                'application_no' => $tfm->application_no,
                'ifsc_pk' => $twbm->ifsc_pk,
                'bank_name' => $twbm->bank_name,
                'branch_name' => $twbm->branch_name,
                'bank_address' => $twbm->bank_address,
                'account_no' => $twbm->account_no,
            ]);

            $data['twc'] =  DB::table('Worker.temporary_worker_certificates')->where('worker_id', $session_worker_id)->get();
            foreach ($data['twc'] as $twc) {
                $data = MainWorkerCertificate::Create([
                    'worker_id' => $session_worker_id,
                    'application_no' => $tfm->application_no,
                    'type_of_issuer' => $twc->type_of_issuer,
                    'issuing_org' => $twc->issuing_org,
                    'issue_date' => $twc->issue_date,
                    'issuing_person' => $twc->issuing_person,
                    'contact_issuing_person' => $twc->contact_issuing_person,
                    'is_same' => $twc->is_same,
                    'employer_name' => $twc->employer_name,
                    'employer_contact_number' => $twc->employer_contact_number,
                    'from_date' => $twc->from_date,
                    'to_date' => $twc->to_date,
                    'date_count' => $twc->date_count,
                    'type_of_employer' => $twc->type_of_employer,
                    'type_of_work' => $twc->type_of_work,
                    'certificate_proof' => $twc->certificate_proof,
                    'profession' => $twc->profession,
                    'profession_others' => $twc->profession_others
                ]);
            }
            $data['tws'] = DB::table('Worker.temporary_worker_schemes')->where('worker_id', $session_worker_id)->get();
            foreach ($data['tws'] as $tws) {
                $data = MainWorkerScheme::Create([
                    'worker_id' => $session_worker_id,
                    'application_no' => $tfm->application_no,
                    'scheme_name' => $tws->scheme_name,
                    'registration_id' => $tws->registration_id,
                    'date' => $tws->date,
                    'enrolled' => $tws->enrolled,
                ]);
            }
            $twd = DB::table('Worker.temporary_worker_documents')->where('worker_id', $session_worker_id)->first();
            $data = MainWorkerDocument::Create([
                'worker_id' => $session_worker_id,
                'application_no' => $tfm->application_no,
                'residential_proof' => $twd->residential_proof,
                'res_proof_ext' => $twd->res_proof_ext,
                'worker_bank_copy' => $twd->worker_bank_copy,
                'worker_bank_copy_ext' => $twd->worker_bank_copy_ext,
                'ration_card' => $twd->ration_card,
                'ration_card_ext' => $twd->ration_card_ext,
                'pan_card' => $twd->pan_card,
                'pan_card_ext' => $twd->pan_card_ext,
                'nominee_bank_copy' => $twd->nominee_bank_copy,
                'nominee_bank_copy_ext' => $twd->nominee_bank_copy_ext,
                'payment_acknowledgement_slip' => $twbd->payment_acknowledgement_slip,
                'payment_acknowledgement_slip_ext' => $twbd->payment_acknowledgement_slip_ext

            ]);

            DB::commit();
            // For PFC
            // End For PFC
//            $revert_status = RevertBack::where('worker_id', $session_worker_id)->count();
//            if ($revert_status > 0) {
//                $update = MainWorkerForm::where('worker_id', $session_worker_id)->update([
//                    'payment_status' => 'success',
//                    'resubmit_status' => 1
//                ]);
//                $update = RevertBack::where('worker_id', $session_worker_id)->update([
//                    'payment_status' => 'success',
//                    'resubmit_status' => 1
//                ]);
//                $this->smsService->applicationSubmissionSMS($tfm->phone_no, $ackNo, '0');
//                Alert::toast('Application Submitted Successfully!', 'success');
//                DB::commit();
//                return redirect()->route('print-ack');
//            }
            $revert_status = RevertBack::where('worker_id', $session_worker_id)->count();
            if ($revert_status > 0) {

                $user_details = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                    ->where('application_status', 'G')
                    ->latest()
                    ->first();
                if ($user_details) {
                    $receiverRoleId = $user_details->sender_role_id;
                    $receiverUserId = $user_details->sender_user_id;


                    $status = null;
                    if ($receiverRoleId == 2) {
                        $status = env('HEAD_REGISTERING_OFFICER');
                    } elseif ($receiverRoleId == 3) {
                        $status = env('REGISTERING_OFFICER');
                    }
                    $ack_No = RevertBack::where('worker_id', $session_worker_id)->value('ack_no');
                    $update = MainWorkerForm::where('worker_id', $session_worker_id)->update([
                        'payment_status' => 'success',
                        'resubmit_status' => 1,
                        'ack_no' =>  $ack_No,
                        'application_receiver_user_id' => $receiverUserId,
                        'status' => $status,
                    ]);
                    $data = WorkerApplicationStatus::Create([
                        'worker_id' => $session_worker_id,
                        'sender_office_id' => $tfm->office_id,
                        'sender_user_id' => $receiverUserId,
                        'application_no' => $tfm->application_no,
                        'ack_no' =>  $ack_No,
                        'application_status' => $status,
                        'remarks' => 'Application Submitted',
                    ]);
                    $update = RevertBack::where('worker_id', $session_worker_id)->update([
                        'payment_status' => 'success',
                        'resubmit_status' => 1
                    ]);
                }

                $this->smsService->applicationSubmissionSMS($tfm->phone_no, $ackNo, '0');
                Alert::toast('Application Submitted Successfully!', 'success');
                DB::commit();
                return redirect()->route('print-ack');
            } else {
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $session_worker_id,
                    'application_no' => $tfm->application_no,
                    'ack_no' => $ackNo,
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


//            if ($pfc_details['is_login_csc'])
//            {
//                if ($tfm->already_payment_status == true) {
//                    $update = MainWorkerForm::where('worker_id', $session_worker_id)->update([
//                        'payment_status' => 'success'
//                    ]);
//                    $this->smsService->applicationSubmissionSMS($tfm->phone_no, $ackNo, '0');
//                    Alert::toast('Application Submitted Successfully!', 'success');
//                    DB::commit();
//                    return redirect()->route('print-ack');
//                }
//                Session::put('csc_id',$pfc_details->csc_id);
//                return redirect()->route('payment.initiate');
//            }else{
                if ($tfm->already_payment_status == true) {
                    $update = MainWorkerForm::where('worker_id', $session_worker_id)->update([
                        'payment_status' => 'success'
                    ]);
                    $this->smsService->applicationSubmissionSMS($tfm->phone_no, $ackNo, '0');
                    Alert::toast('Application Submitted Successfully!', 'success');
                    DB::commit();
                    return redirect()->route('print-ack');
                } else {

                    Alert::toast('Application Submitted Successfully ,Please Pay the registration fees!', 'success');
                    DB::commit();
                    return redirect()->route('submit-worker-payment')->with('success', 'Successfully Submitted !');
                }
//            }

//            if ($tfm->already_payment_status == true) {
//                $update = MainWorkerForm::where('worker_id', $session_worker_id)->update([
//                    'payment_status' => 'success'
//                ]);
//                $this->smsService->applicationSubmissionSMS($tfm->phone_no, $ackNo, '0');
//                Alert::toast('Application Submitted Successfully!', 'success');
//                DB::commit();
//                return redirect()->route('print-ack');
//            } else {
//
//                Alert::toast('Application Submitted Successfully ,Please Pay the registration fees!', 'success');
//                DB::commit();
//                return redirect()->route('submit-worker-payment')->with('success', 'Successfully Submitted !');
//            }
        } catch (Exception $e) {
//            return $e;
            DB::rollBack();
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('home.index');
        }
    }

    public function registrationPayment(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            $data['worker_id'] = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }

            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $session_worker_id)
                ->pluck('application_no')
                ->first();
            $data['phone'] = MainWorkerForm::where('worker_id', $session_worker_id)->pluck('phone_no')->first();

            $data['basic'] = DB::table('Worker.main_worker_basic_details')
                ->where('worker_id', $session_worker_id)->first();
            $data['amount'] = Amount::where('amount_description', 'Registration Amount')->first()->amount;

            if (PfcKioskDetail::where('worker_id',$session_worker_id)->exists()) {
                $data['pfc_details'] = PfcKioskDetail::where('worker_id',$session_worker_id)->first();
                Session::put('csc_id', $data['pfc_details']->kiosk_registration_id); // <-- set before rendering view
                $data['pfc_details']->is_login_csc = true;
            }else{
                $data['pfc_details'] = null;
            }
            $paymentData = WorkerPaymentSuccess::where('worker_id', $session_worker_id)
                ->where('payment_type', 1)
                ->where(function ($query) {
                    $query->where('STATUS', 'O')
                        ->orWhere('STATUS', 'P');
                })
                ->latest()
                ->first();





            $paymentStartCount = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->where('payment_type', 1)->where('STATUS', 'O')->count();

            $paymentInitiatedCount = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->where('payment_type', 1)->where('STATUS', 'F')->count();

            $paymentPendingDataCount = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->where('payment_type', 1)->where('STATUS', 'P')->count();

            // return $paymentStartCount.','.$paymentInitiatedCount.'.'.$paymentPendingDataCount;
            if ($paymentStartCount == 1) {

                $data['department_id'] = WorkerPaymentSuccess::where('worker_id', $session_worker_id)
                    ->where('payment_type', 1)
                    ->where('STATUS', 'O')
                    ->latest()
                    ->first();

                $data['payment_type'] = "Pay Now";
                $data['time'] = false;
                $data['disabled'] = false;
            } elseif ($paymentInitiatedCount == 1) {

                $data['payment_type'] = "Retry Payment";
                $data['time'] = true;
                $paymentStatus = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->where('payment_type', 1)->where('STATUS', 'F')->latest()->first();
                $targetTime = Carbon::parse($paymentStatus->updated_at)->addMinutes(15);
                $remainingTimeInSeconds = Carbon::now()->diffInSeconds($targetTime, false); // Calculate remaining time in seconds
                // Convert the remaining time to minutes and seconds
                $data['minute'] = floor($remainingTimeInSeconds / 60);
                $data['seconds'] = $remainingTimeInSeconds % 60;
                $data['department_id'] = $paymentStatus;
                $data['disabled'] = true;
            } elseif ($paymentPendingDataCount == 1) {
                $data['payment_type'] = "Retry Payment";
                $data['time'] = true;
                $paymentStatus = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->where('payment_type', 1)->where('STATUS', 'P')->latest()->first();
                $targetTime = Carbon::parse($paymentStatus->updated_at)->addMinutes(15);
                $remainingTimeInSeconds = Carbon::now()->diffInSeconds($targetTime, false); // Calculate remaining time in seconds
                // Convert the remaining time to minutes and seconds
                $data['minute'] = 0;
                $data['seconds'] = $remainingTimeInSeconds;
                $data['department_id'] = $paymentStatus;
                $data['disabled'] = false;
            } else {
                if ( !$data['pfc_details'])
                {
                    WorkerPaymentSuccess::create([
                        'worker_id' => $session_worker_id,
                        'payment_type' => 1,
                        'DEPARTMENT_ID' => "ABOCWWB" . date('YmdHis') . rand(1000, 9999),
                        'STATUS' => 'O'
                    ]);
                }


                $data['department_id'] = WorkerPaymentSuccess::where('worker_id', $session_worker_id)
                    ->where('payment_type', 1)
                    ->latest()
                    ->first();
                $data['payment_type'] = "Pay Now";
                $data['time'] = false;
                $data['disabled'] = false;
            }



            $data['payment_type_code'] = '03';
            $office_id = MainWorkerForm::where('worker_id', $session_worker_id)->first()->office_id;
            $data['egrass_office_code'] = Office::where('office_id', $office_id)->first()->egrass_office_code;
            //         return $data;
            return view('worker.payment-page', $data);
        } catch (Exception $e) {
//                        return $e;
            DB::rollBack();
            Alert::toast("Something went wrong!", 'error');
//            return redirect()->route('home.index');
        }
    }

//    public  function testWalletCsc(Request $request)
//    {
//                    $data['csc_id']= '500100100014';
//                if ($data['csc_id'])
//                {
//                    return redirect()->route('payment.initiate');
//                }
//
//    }

    public function paymentSuccessful(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "M");
            $record['getVaultData'] = json_decode($vaultData->getData(), true);

            $record['wmf'] = MainWorkerForm::where('worker_id', $session_worker_id)->first();
            $record['renewal_date'] = Carbon::parse($record['wmf']->renewal_date);
            $record['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $session_worker_id)->first();
            $record['current_date'] = now();
            $record['paymentDetails'] = WorkerPaymentSuccess::where('worker_id', $session_worker_id)
                ->where('payment_type', 1)
                ->where('STATUS', "Y")
                ->latest()
                ->first();

            return view('worker.payment-receipt', $record);
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }


    public function ackPage(Request $request)
    {
        try {
            $session_worker_id = session()->get('worker_id');
            if (!$session_worker_id) {
                return $this->sessionFlash();
            }
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "M");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['aadharPhoto'] = $data['getVaultData']['photo'];
            $data['worker'] = MainWorkerForm::where('worker_id', $session_worker_id)->first();
            $data['mwf'] = DB::table('Worker.main_worker_forms as wmfm')
                ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
                ->where('worker_id', $session_worker_id)
                ->select('wmfm.*', 'ofc.*')
                ->first();
            $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
                ->where('worker_id', $session_worker_id)
                ->select('wmbd.*')
                ->first();
            $data['district_name'] = $data['worker']->districtName->district_name;
            $data['office_name'] = $data['worker']->officeName->office_name;
            $pfcData = PfcKioskDetail::where('worker_id', $session_worker_id);
            $data['pfcData'] = PfcKioskDetail::where('worker_id', $session_worker_id)->exists();
            $data['is_csc_login'] = null;
            $data['transaction_status'] = null;
            if ($pfcData->count() > 0) {
                $data['is_csc_login'] = $pfcData->first()->is_login_csc;
                if ($data['is_csc_login']) {
                    $rtps_trans_id = $pfcData->first()->rtps_trans_id;
                    session()->put('pfcData', $rtps_trans_id);

                    $pfcData = PfcKioskDetail::where('rtps_trans_id', $rtps_trans_id)->first();
                    $data['pfcData'] = $pfcData;
                    MainWorkerForm::where('worker_id', $session_worker_id)->update([
                        'rtps_trans_id' => $rtps_trans_id
                    ]);
                    $encryption_key = "1234567890123456";
                    if ($data['getVaultData']['gender'] == "M") {
                        $gender_data = "male";
                    } elseif ($data['getVaultData']['gender'] == "F") {
                        $gender_data = "female";
                    } else {
                        $gender_data = "others";
                    }
                    $userDetails = array();
                    array_push(
                        $userDetails,
                        array(
                            "gender" => $gender_data,
                            "applicant_name" => $data['getVaultData']['name'],
                            "fathers_name" => $data['getVaultData']['careOf'],
                            "mobile_number" => $pfcData->mobile,
                            "address_line_1" => $data['getVaultData']['street'] ? $data['getVaultData']['street'] : "NA",
                            "address_line_2" => $data['getVaultData']['locality'] ? $data['getVaultData']['locality'] : "NA",
                            "state" => $data['getVaultData']['state'],
                            "district" => $data['worker']->districtName->district_name,
                            "pin_code" => $data['getVaultData']['pinCode']
                        )
                    );
                    $application_details = array(
                        "slno" => $data['worker']->ack_no . rand(0000, 9999),
                    );
                    if ($data['worker']->payment_acknowledgement_slip == false) {
                        $payment = WorkerPaymentSuccess::where('worker_id', $session_worker_id)
                            ->where('payment_type', 1)
                            ->whereIn('STATUS', ['Y', 'F'])
                            ->latest('created_at')// Replace 'created_at' with your timestamp field if different
                            ->first();
                    }

                    $output = array(
                        "rtps_trans_id" => $pfcData->rtps_trans_id,
                        "user_id" => $pfcData->mobile,
                        "service_id" => $pfcData->service_id,
                        "app_ref_no" => $data['worker']->ack_no,
                        "status" => "S",
                        "submission_date" => Carbon::now()->format('Y-m-d H:i:s'),
                        "payment_mode" => "online",
                        "payment_ref_no" => $payment->merchant_txn ?? 'NA',
                        "payment_date" => $payment->TRANSCOMPLETIONDATETIME ?? 'NA',
                        "amount" => $payment->AMOUNT ?? 'NA',
                        "application_details" => $application_details,
                        "applicant_details" => $userDetails,
                        "portal_no" => $pfcData->portal_no,
                        "submission_location" => $data['office_name'],
                        "district" => $data['worker']->districtName->district_name,
                        "circle" => $data['getVaultData']['subDistrict'] ? $data['getVaultData']['subDistrict'] : ""
                    );


                    $output = json_encode(array("response_data" => $output));


                    $aes = new AES($output, $encryption_key);
                    $data['encrypted_data'] = $aes->encrypt();
                    $data['url'] = $pfcData->response_url;


                } else {
                    $rtps_trans_id = $pfcData->first()->rtps_trans_id;
                    session()->put('pfcData', $rtps_trans_id);

                    $pfcData = PfcKioskDetail::where('rtps_trans_id', $rtps_trans_id)->first();
                    $data['pfcData'] = $pfcData;
                    MainWorkerForm::where('worker_id', $session_worker_id)->update([
                        'rtps_trans_id' => $rtps_trans_id
                    ]);
                    $encryption_key = "1234567890123456";
                    if ($data['getVaultData']['gender'] == "M") {
                        $gender_data = "male";
                    } elseif ($data['getVaultData']['gender'] == "F") {
                        $gender_data = "female";
                    } else {
                        $gender_data = "others";
                    }
                    $userDetails = array();
                    array_push(
                        $userDetails,
                        array(
                            "gender" => $gender_data,
                            "applicant_name" => $data['getVaultData']['name'],
                            "fathers_name" => $data['getVaultData']['careOf'],
                            "mobile_number" => $pfcData->mobile,
                            "address_line_1" => $data['getVaultData']['street'] ? $data['getVaultData']['street'] : "NA",
                            "address_line_2" => $data['getVaultData']['locality'] ? $data['getVaultData']['locality'] : "NA",
                            "state" => $data['getVaultData']['state'],
                            "district" => $data['worker']->districtName->district_name,
                            "pin_code" => $data['getVaultData']['pinCode']
                        )
                    );
                    $application_details = array(
                        "slno" => $data['worker']->ack_no . rand(0000, 9999),
                    );
                    if ($data['worker']->payment_acknowledgement_slip == false) {
                        $payment = WorkerPaymentSuccess::where('worker_id', $session_worker_id)
                            ->where('payment_type', 1)
                            ->where('STATUS', "Y")
                            ->latest('created_at')// Replace 'created_at' with your timestamp field if different
                            ->first();
                    }

                    $output = array(
                        "rtps_trans_id" => $pfcData->rtps_trans_id,
                        "user_id" => $pfcData->mobile,
                        "service_id" => $pfcData->service_id,
                        "app_ref_no" => $data['worker']->ack_no,
                        "status" => "S",
                        "submission_date" => Carbon::now()->format('Y-m-d H:i:s'),
                        "payment_mode" => "online",
                        "payment_ref_no" => $payment->PRN ?? 'NA',
                        "payment_date" => $payment->TRANSCOMPLETIONDATETIME ?? 'NA',
                        "amount" => $payment->AMOUNT ?? 'NA',
                        "application_details" => $application_details,
                        "applicant_details" => $userDetails,
                        "portal_no" => $pfcData->portal_no,
                        "submission_location" => $data['office_name'],
                        "district" => $data['worker']->districtName->district_name,
                        "circle" => $data['getVaultData']['subDistrict'] ? $data['getVaultData']['subDistrict'] : ""
                    );


                    $output = json_encode(array("response_data" => $output));


                    $aes = new AES($output, $encryption_key);
                    $data['encrypted_data'] = $aes->encrypt();
                    $data['url'] = $pfcData->response_url;
                }
            }


            if ($data['worker']->already_payment_status != true) {
                // return '1';

                $data['department_id'] = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->where('payment_type', 1)->where('STATUS', 'Y')->latest()->first();
                $data['egrass_office_code'] = Office::where('office_id', $data['worker']->office_id)->first()->egrass_office_code;
            }
            $data['revert_back'] = RevertBack::where('worker_id', $session_worker_id)->count();


            if ($data['revert_back'] > 0) {
                $data['department_id'] = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->where('payment_type', 1)->where('STATUS', 'Y')->latest()->first();
                $data['egrass_office_code'] = Office::where('office_id', $data['worker']->office_id)->first()->egrass_office_code;
                return view('worker.worker-acknowledgement', $data);
            }
            $successMessage = session('success', 'Default success message if not set');
            return view('worker.worker-acknowledgement', $data);
        } catch (Exception $e) {
            Alert::toast('Something went wrong!', 'error');
            return back();
        }
    }





    public function previewFromDoc()
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $worker_details = TemporaryWorkerForm::where('worker_id')->first();
        return view('worker.worker-preview-details');
    }


    public function getSkills(Request $request)
    {
        $data['skills'] = DB::table('Masterdata.skills')
            ->select('skill_code', 'skill_name')
            ->orderBy('skill_name')
            ->get();

        return response()->json($data);
    }
    public function getRationType(Request $request)
    {
        $data['ration_type'] = DB::table('Masterdata.ration_types')
            ->select('ration_code', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($data);
    }
    /** Display districts */
    public function getDistricts(Request $request)
    {
        $districts['districts'] = DB::table('Masterdata.districts')
            ->where('state_code', $request->state_code)
            ->select('district_code', 'district_name')->orderBy('district_name')->get();
        return response()->json($districts);
    }
    /** Display Office **/
    public function getOffice(Request $request)
    {
        $data['office'] = DB::table('Masterdata.offices')
            ->where('district_code', $request->district_code)
            ->where('status', 1)
            ->select('office_id', 'office_name')->orderBy('office_name')->get();
        return response()->json($data);
    }
    /** Display sub-districts */
    public function getSubDist(Request $request)
    {
        $data['subdist'] = DB::table('Masterdata.sub_districts')
            ->where('district_code', $request->district_code)
            ->select('subdistrict_code', 'subdistrict_name')->orderBy('subdistrict_name')->get();
        return response()->json($data);
    }
    /** Display sub-districts post-office */
    public function getSubdistPostOffc(Request $request)
    {
        $data['subdist'] = DB::table('Masterdata.sub_districts')
            ->where('state_code', $request->state_code)
            ->where('district_code', $request->district_code)
            ->select('subdistrict_code', 'subdistrict_name')->orderBy('subdistrict_name')->get();
        $data['postoffice'] = DB::table('Masterdata.post_offices')
            ->where('state_code', $request->state_code)
            ->where('district_code', $request->district_code)
            ->select('post_office_id', 'post_office_name', 'pin_code')->orderBy('post_office_name')
            ->get();
        return response()->json($data);
    }
    /** Display pin-codes */
    public function getPin(Request $request)
    {
        $data['pincode'] = DB::table('Masterdata.post_offices')
            ->where('state_code', $request->state_code)
            ->where('district_code', $request->district_code)
            ->where('post_office_id', $request->poid)
            ->select('pin_code')
            ->first();
        return response()->json($data);
    }
    public function getBank(Request $request)
    {
        $request->validate([
            'ifsc' => 'required|string'
        ]);
//        return $request->ifsc;

        $bank = Bank::where('ifsc', strtoupper($request->ifsc))->first();

        if (!$bank) {
            return response()->json([
                'status' => false,
                'message' => 'Bank not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'IFSC'        => $bank->ifsc,
                'BANK'        => $bank->bank_name,
                'BRANCH'      => $bank->branch_name,
                'ADDRESS'     => $bank->branch_name,
            ]
        ]);
    }

    /** Download Preview As pdf */
    /** Download Preview As pdf */


    public function downloadPreviewPagePDF(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $maskAadharNumber = function ($aadharNumber) {
            return substr($aadharNumber, 0, 4) . str_repeat('*', strlen($aadharNumber) - 8) . substr($aadharNumber, -4);
        };

        $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "T");
        $getVaultData = json_decode($vaultData->getData(), true);

        if (isset($getVaultData['uID'])) {
            $getVaultData['uID'] = $maskAadharNumber($getVaultData['uID']);
        }

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
        $has_do_address = DB::table('Worker.temporary_worker_addresses')
            ->where('worker_id', $session_worker_id)
            ->pluck('do')
            ->first();


        $twd = DB::table('Worker.temporary_worker_documents as twd')->where('twd.worker_id', $session_worker_id)->first();

        $documents = collect([
            ['id' => 1, 'name' => 'residential_proof', 'label' => 'Present Address Proof ', 'uploaded' => !empty($twd->residential_proof)],
            ['id' => 2, 'name' => 'worker_bank_copy', 'label' => 'Aadhaar Linked Bank Copy', 'uploaded' => !empty($twd->worker_bank_copy)],
            ['id' => 3, 'name' => 'ration_card', 'label' => 'Ration Card', 'uploaded' => !empty($twd->ration_card)],
            ['id' => 4, 'name' => 'nominee_bank_copy', 'label' => 'Nominee Bank Copy', 'uploaded' => !empty($twd->nominee_bank_copy)],
            ['id' => 5, 'name' => 'pan_card', 'label' => 'PAN Card', 'uploaded' => !empty($twd->pan_card)],
            ['id' => 6, 'name' => 'work_book', 'label' => 'Work Book/90 days Certificate', 'uploaded' => !empty($twd->work_book)],
        ]);


        $html = view('worker.pdf.worker-preview-details-pdf', compact('emblem', 'worker_details', 'getVaultData', 'has_ration_card', 'has_pan', 'documents', 'has_do_address'))->render();
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
    }

    public function downloadAckPdf(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data['revert_back'] = RevertBack::where('worker_id', $session_worker_id)->count();
        $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "M");
        $data['getVaultData'] = json_decode($vaultData->getData(), true);
        $data['payment_date'] = null;
        $payment_date = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->count();
        if ($payment_date > 0) {
            $data['payment_date'] = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->first();
        } else {
            $data['payment_date'] = null;
        }

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

        $data['emblem'] = public_path('/assets/template/images/bocw.png');
        $data['isRenew'] = null;

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

    public function paymentReceiptPdf(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "M");
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

        $data['emblem'] = public_path('/assets/template/images/bocw.png');

        $options = [
            'encoding' => 'utf-8', // Set encoding to UTF-8
            'enable-local-file-access' => true, // Enable external links
        ];
        // The Blade view you provided
        $html = view('worker.pdf.receipt.payment-receipt', $data)->render();

        // Generate PDF from HTML content
        $pdfContent =  Pdf::loadHTML($html)
            ->setOptions($options)
            ->output();

        // Set response headers to indicate PDF content
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="payment_receipt.pdf"',
        ]);
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

    public function returnHomeNew(Request $request)
    {
        // Completely destroy the session
        Session::flush();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
