<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Api\PfcController;
use App\Http\Controllers\Controller;
use App\Models\applicationStatus;
use App\Models\CancelledAppModal;
use App\Models\DscRegistration;
use App\Models\employerModel;
use App\Models\MainVaultData;
use App\Models\MainWorkerForm;
use App\Models\RenewWorkerForm;
use App\Models\RevertBack;
use App\Models\TemporaryWorkerAddress;
use App\Models\TemporaryWorkerBank;
use App\Models\TemporaryWorkerBasicDetail;
use App\Models\TemporaryWorkerCertificate;
use App\Models\TemporaryWorkerDocument;
use App\Models\TemporaryWorkerFamily;
use App\Models\TemporaryWorkerForm;
use App\Models\TemporaryWorkerScheme;
use App\Models\User;
use App\Models\VaultData;
use App\Models\WorkerPaymentSuccess;
use App\Services\AesCipher;
use App\Services\SmsGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Abaocwwb;
use App\Models\MainWorkerDocument;
use App\Models\WorkerApplicationStatus;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerCertificate;
use App\Models\MainWorkerAddress;
use App\Models\MainWorkerBank;
use App\Models\MainWorkerEmployerDetail;
use App\Models\MainWorkerFamily;
use App\Models\MainWorkerScheme;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OfficeinfoController extends Controller
{
    protected $officeinfo;
    private $smsService;
    protected $pfcController;

    public function __construct(Abaocwwb $officedata, SmsGatewayService $smsService, PfcController $pfcController)
    {
        $this->officeinfo = $officedata;
        $this->smsService = $smsService;
        $this->pfcController = $pfcController;
        $this->middleware('permission:approve application', ['only' => ['approveApplication']]);
        $this->middleware('permission:approve onboardingapplication', ['only' => ['approveApplicationOnboarding',]]);
        $this->middleware('permission:reject application', ['only' => ['rejectApplication']]);
        $this->middleware('permission:forward application', ['only' => ['forwardApplication']]);
        $this->middleware('permission:forward to ro application', ['only' => ['forwardApplicationToRo']]);
        $this->middleware('permission:pull back application from da', ['only' => ['pullBackApplication']]);
        $this->middleware('permission:revert back application', ['only' => ['revertBackApplication']]);
        $this->middleware('permission:send application', ['only' => ['sendApplications']]);
    }


    public function logout()
    {
        $sessionvalue = session()->all();
        $tablename = 'User.users';
        $userid =  Auth::user()->username;
        $checkuser = $this->officeinfo->getUserInfobyId($tablename, $userid);
        Session::flush();
        $status = 'sucess';
        $action = 'logout';
        $this->userlog($checkuser, $status, $action);
        return Redirect::to('/');
    }
    public function changePassword(Request $request)
    {
        $sessionvalue = session()->all();
        $oldpassword = $request->input('oldusrpwd');
        $newpassword = $request->input('newusrpwd');
        $hashpwd = Hash::make($newpassword);
        $confirmpassword = $request->input('confusrpwd');
        $tablename = 'User.users';
        $userid =  $sessionvalue['usersessionvalue']['user_id'];
        $checkuser = $this->officeinfo->getUserInfobyId($tablename, $userid);
        if (Hash::check($oldpassword, $checkuser[0]->password)) {
            if ($oldpassword != $newpassword) {
                if ($newpassword == $confirmpassword) {
                    $validated = $request->validate(
                        [
                            'newusrpwd' => 'required|min:8',
                            'confusrpwd' => 'required|min:8'
                        ],
                        [

                            'newusrpwd.required' => 'New Password Cannot Be Blank',
                            'newusrpwd.min' => 'New Password Must Contain Minimum 8 Characters',
                            'confusrpwd.required' => 'Confirm Password Cannot Be Blank',
                            'confusrpwd.min' => 'Confirm Password Must Contain Minimum 8 Characters'
                        ]
                    );
                    if ($validated == TRUE) {
                        $updatearr = array('password' => $hashpwd, 'password_change_first_attempt' => true);
                        $wherearr = array(['id', '=', $userid]);
                        $this->officeinfo->updateData($tablename, $updatearr, $wherearr);
                        return response()->json(['msg' => 'Password Changed Successfully.'], 200);
                    }
                } else {
                    $msgarr = array('message' => 'The given data was invalid.', 'errors' => array('conf_pwd_match' => array('0' => '**New Password and Confirm Password Doesnot match.')));
                    return response()->json($msgarr, 422);
                }
            } else {
                $msgarr = array('message' => 'The given data was invalid.', 'errors' => array('new_pwd_match' => array('0' => '**New Password should not be same as  old Password.')));
                return response()->json($msgarr, 422);
            }
        } else {
            $msgarr = array('message' => 'The given data was invalid.', 'errors' => array('old_pwd_match' => array('0' => '**Old Password Doesnot Match')));
            return response()->json($msgarr, 422);
        }
    }

    public function applicationReceived()
    {
        $sessionvalue = session()->all();
        $usernamedisplay = Auth::user()->username;
        $data['users'] = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        //        dd($data);
        $loginfirstattemptvalue = Auth::user()->password_change_first_attempt;

        $data = DB::table('Worker.main_worker_forms as wfm')
            ->join('Worker.main_worker_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
            ->where('wfm.office_id', $data['users']->office_id)
            ->select(
                'wfm.worker_id',
                'wfm.phone_no',
                'wfm.created_at',
                'wmbd.first_name',
                'wmbd.last_name',
                'wfm.status',
                'wfm.already_registered',
                DB::raw("TO_CHAR(wfm.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at")
            )
            ->distinct()
            ->get();


        return view('office.application-received', compact('usernamedisplay', 'loginfirstattemptvalue', 'data'));
    }

    public function applicationReverted()
    {
        $sessionvalue = session()->all();
        $usernamedisplay = $sessionvalue["usersessionvalue"]["username"];
        $data['users'] = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $loginfirstattemptvalue = $sessionvalue["usersessionvalue"]["password_change_first_attempt"];


        $data = DB::table('Worker.worker_main_form_models as wfm')
            ->join('Worker.worker_main_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
            ->join('User.users as user', 'wfm.office_id', '=', 'user.office_id')
            ->where('wfm.status', '=', 'G')
            ->where('wfm.office_id', $data['users']->office_id)
            ->where('user.role_id', $data['users']->role_id)
            ->select(
                'wfm.worker_id',
                'wfm.phone_no',
                'wfm.created_at',
                'wmbd.first_name',
                'wmbd.last_name',
                'wfm.status',
                DB::raw("TO_CHAR(wfm.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at")
            )
            ->distinct()
            ->get();


        return view('office.application_reverted', compact('usernamedisplay', 'loginfirstattemptvalue', 'data'));
    }

    public function applicationApproved()
    {
        $sessionvalue = session()->all();
        $usernamedisplay = Auth::user()->username;
        $data['users'] = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $loginfirstattemptvalue = $sessionvalue["usersessionvalue"]["password_change_first_attempt"];

        try {

            $data = DB::table('Worker.main_worker_forms as wfm')
                ->join('Worker.main_worker_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
                ->join('User.users as user', 'wfm.office_id', '=', 'user.office_id')
                ->where('wfm.status', '=', 'F')
                ->where('wfm.office_id', $data['users']->office_id)
                ->where('user.role_id', $data['users']->role_id)
                ->select(
                    'wfm.worker_id',
                    'wfm.phone_no',
                    'wfm.created_at',
                    'wmbd.first_name',
                    'wmbd.last_name',
                    'wfm.status',
                    DB::raw("TO_CHAR(wfm.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at")
                )
                ->distinct()
                ->get();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Database error'], 500);
        }


        return view('office.application-approved', compact('usernamedisplay', 'loginfirstattemptvalue', 'data'));
    }
    public function applicationRejected()
    {
        $sessionvalue = session()->all();
        $usernamedisplay = $sessionvalue["usersessionvalue"]["username"];
        $data['users'] = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $loginfirstattemptvalue = $sessionvalue["usersessionvalue"]["password_change_first_attempt"];

        try {

            $data = CancelledAppModal::all();
            dd($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Database error'], 500);
        }


        return view('office.application-rejected', compact('usernamedisplay', 'loginfirstattemptvalue', 'data'));
    }
    public function applicationPending()
    {
        $sessionvalue = session()->all();
        $usernamedisplay = $sessionvalue["usersessionvalue"]["username"];
        $data['users'] = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $loginfirstattemptvalue = $sessionvalue["usersessionvalue"]["password_change_first_attempt"];

        try {

            $data = DB::table('Worker.main_worker_forms as wfm')
                ->join('Worker.main_worker_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
                ->join('User.users as user', 'wfm.office_id', '=', 'user.office_id')
                ->where('wfm.status', '!=', 'F')
                ->where('wfm.office_id', $data['users']->office_id)
                ->where('user.role_id', $data['users']->role_id)
                ->select(
                    'wfm.worker_id',
                    'wfm.phone_no',
                    'wfm.created_at',
                    'wmbd.first_name',
                    'wmbd.last_name',
                    DB::raw("TO_CHAR(wfm.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at")
                )
                ->distinct()
                ->get();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Database error'], 500);
        }


        return view('office.application-pending', compact('usernamedisplay', 'loginfirstattemptvalue', 'data'));
    }
    public function applicationForwarded()
    {
        $sessionvalue = session()->all();
        $usernamedisplay = $sessionvalue["usersessionvalue"]["username"];
        $data['users'] = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $loginfirstattemptvalue = $sessionvalue["usersessionvalue"]["password_change_first_attempt"];

        try {

            $data = DB::table('Worker.main_worker_forms as wfm')
                ->join('Worker.main_worker_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
                ->join('User.users as user', 'wfm.office_id', '=', 'user.office_id')
                ->where('wfm.office_id', $data['users']->office_id)
                ->where('wfm.status', '=', 'C')
                ->where('user.role_id', $data['users']->role_id)
                ->select(
                    'wfm.worker_id',
                    'wfm.phone_no',
                    'wfm.created_at',
                    'wmbd.first_name',
                    'wmbd.last_name',
                    'wfm.status',
                    DB::raw("TO_CHAR(wfm.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at"),
                    DB::raw("TO_CHAR(wfm.updated_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_updated_at"),
                    DB::raw("TO_CHAR(wfm.updated_at + INTERVAL '3 days', 'DD-MM-YYYY HH:MI:SS AM') as formatted_expiration_time")
                )
                ->distinct()
                ->get();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Database error'], 500);
        }

        return view('office.application-forwarded', compact('usernamedisplay', 'loginfirstattemptvalue', 'data'));
    }

    public function applicationDetails($id)
    {
        $id = decrypt($id);
        $sessionvalue = session()->all();
        $usernamedisplay = Auth::user()->username;
        $data['username'] = DB::table('User.users')->where('users.username', '=', $usernamedisplay)->first();
        $data['status'] = DB::table('Worker.main_worker_forms')->where('worker_id', $id)->first();

        $data['da'] = DB::table('User.users as user')
            ->join('Masterdata.roles as role', 'user.role_id', '=', 'role.id')
            ->where('user.status', '=', '1')
            ->where('user.office_id', $data['username']->office_id)
            ->where('role_id', '!=', $data['username']->role_id)
            ->get();

        /** RO will Pull application from DA */
        $data['pullDa'] = DB::table('User.users as user')
            ->join('Masterdata.roles as role', 'user.role_id', '=', 'role.id')
            ->where('user.status', '=', '1')
            ->where('user.office_id', $data['username']->office_id)
            ->where('role_id', '=', $data['username']->role_id)
            ->get();

        $data['ro'] = DB::table('User.users as user')
            ->join('Masterdata.roles as role', 'user.role_id', '=', 'role.id')
            ->where('user.office_id', $data['username']->office_id)
            ->where('user.status', '=', '1')
            ->where('role_id', '!=', $data['username']->role_id)
            ->get();

        $data['tfm'] = DB::table('Worker.main_worker_forms')->where('worker_id', $id)->first();
        $data['twbd'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $id)->first();
        $data['twam'] = DB::table('Worker.main_worker_addresses')->where('worker_id', $id)->first();
        $data['twfm'] =  DB::table('Worker.main_worker_families')->where('worker_id', $id)->get();
        $data['twbm'] = DB::table('Worker.main_worker_banks')->where('worker_id', $id)->first();
        $data['twed'] = DB::table('Worker.main_worker_employer_details')->where('worker_id', $id)->first();
        $data['twc'] =  DB::table('Worker.main_worker_certificates')->where('worker_id', $id)->get();
        $data['tws'] = DB::table('Worker.main_worker_schemes')->where('worker_id', $id)->get();
        $data['twd'] = DB::table('Worker.main_worker_documents')->where('worker_id', $id)->first();
        //        DB::enableQueryLog();

        $data['twbdjoin']
            = DB::table('Worker.temporary_worker_basic_details as twbd')
            ->leftjoin('Masterdata.marital_statuses as ms', 'twbd.maritial_status_id', '=', 'ms.marital_code')
            ->leftjoin('Masterdata.educations as edu', 'twbd.education_id', '=', 'edu.education_code')
            ->leftjoin('Masterdata.categories as cat', 'twbd.category', '=', 'cat.category_code')
            ->leftjoin('Masterdata.skills as sk', 'twbd.skill_id', '=', 'sk.skill_code')
            ->leftjoin('Masterdata.states as st', 'twbd.state_id', '=', 'st.state_code')
            ->where('twbd.worker_id', $id)
            ->select('twbd.*', 'ms.*', 'cat.*', 'edu.*', 'sk.*', 'st.*')
            ->first();

        $data['twamjoin'] = DB::table('Worker.main_worker_addresses as twam')
            ->leftjoin('Masterdata.residences as cres', 'twam.c_residence', '=', 'cres.residence_code')
            ->leftjoin('Masterdata.houses as chs', 'twam.c_house_type', '=', 'chs.house_code')
            ->leftjoin('Masterdata.ration_types as rt', 'twam.ration_type', '=', 'rt.ration_code')
            ->where('twam.worker_id', $id)
            ->select('twam.*', 'cres.*', 'pres.*', 'chs.*', 'phs.*', 'cst.*', 'pst.*', 'cds.*', 'pds.*', 'scds.*', 'spds.*', 'cpo.*', 'ppo.*', 'rt.*')
            ->first();
        $data['twedjoin'] = DB::table('Worker.main_worker_employer_details as twed')
            ->join('Masterdata.type_of_works as tow', 'twed.type_of_work', '=', 'tow.work_type_code')
            ->join('Masterdata.nature_of_works as now', 'twed.nature_of_work', '=', 'now.nature_of_work_code')
            ->join('Masterdata.districts as cds', 'twed.district', '=', 'cds.district_code')
            ->join('Masterdata.sub_districts as sd', 'twed.subdistrict', '=', 'sd.subdistrict_code')
            ->where('twed.worker_id', $id)
            ->select('twed.*', 'tow.*', 'now.*', 'cds.*', 'sd.*')
            ->first();
        $data['twfjoin'] = DB::table('Worker.main_worker_families as twf')
            ->leftjoin('Masterdata.relations as rel', 'twf.relation', '=', 'rel.relation_code')
            ->leftjoin('Masterdata.educations as edu', 'twf.education', '=', 'edu.education_code')
            ->leftjoin('Masterdata.professions as pro', 'twf.profession', '=', 'pro.profession_code')
            ->where('twf.worker_id', $id)
            ->select('twf.*', 'edu.*', 'rel.*', 'pro.*')
            ->get();

        $data['twcjoin'] = DB::table('Worker.main_worker_certificates as twc')
            ->join('Masterdata.type_of_issuers as toi', 'twc.type_of_issuer', '=', 'toi.issuer_code')
            ->where('twc.worker_id', $id)
            ->select('twc.*', 'toi.*')
            ->get();
        $data['twsjoin'] = DB::table('Worker.main_worker_schemes as tws')
            ->join('Masterdata.schemes as sc', 'tws.scheme_name', '=', 'sc.scheme_code')
            ->where('tws.worker_id', $id)
            ->select('tws.*', 'sc.*')
            ->get();
        $data['twdcj'] = DB::table('Worker.main_worker_documents as twdc')
            ->join('Masterdata.age_proofs as apt', 'twdc.age_proof_id', '=', 'apt.age_proof_code')
            ->where('twdc.worker_id', $id)
            ->select('twdc.*', 'apt.*')
            ->get();
        $data['documents'] = MainWorkerDocument::where('worker_id', $id)->first();
        $data['states'] = DB::table('Masterdata.states')->select('state_code', 'state_name')->orderBy('state_name')->get();
        $data['districts'] = DB::table('Masterdata.districts')->select('district_code', 'district_name')->orderBy('district_name')->get();
        $data['residence'] = DB::table('Masterdata.residences')->where('residence_code', '!=', $data['twamjoin']->residence_code)->get();
        $data['house'] = DB::table('Masterdata.houses')->where('house_code', '!=', $data['twamjoin']->house_code)->get();
        $data['marital'] = DB::table('Masterdata.marital_statuses')->where('marital_code', '!=',  $data['twbdjoin']->marital_code)->get();
        $data['category'] = DB::table('Masterdata.categories')->where('category_code', '!=',  $data['twbdjoin']->category_code)->get();
        $data['education'] = DB::table('Masterdata.educations')->where('education_code', '!=',  $data['twbdjoin']->education_code)->get();
        $data['now'] = DB::table('Masterdata.nature_of_works')->where('nature_of_work_code', '!=', $data['twedjoin']->nature_of_work_code)->get();
        $data['tow'] = DB::table('Masterdata.type_of_works')->where('work_type_code', '!=', $data['twedjoin']->work_type_code)->get();

        return view('office.office-applications', $data, $sessionvalue);
    }

    public function getWOldIdCard($worker_id)
    {
        $worker = decrypt($worker_id);

        $boc_card = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker)
            ->first();

        if (!$boc_card || !$boc_card->old_id_card) {
            abort(404, 'BOCW ID Card not found');
        }

        $path = ltrim($boc_card->old_id_card, '/');

        // Check storage/app/private
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check storage/app/public
        $publicPath = storage_path(
            'app/public/' . str_replace('private/', '', $path)
        );

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'BOCW ID Card file not found');
    }

    public function getResProof($worker_id)
    {
        $worker = decrypt($worker_id);

        $res_proof = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker)
            ->first();

        if (!$res_proof || !$res_proof->residential_proof) {
            abort(404, 'Residential proof not found');
        }

        $path = ltrim($res_proof->residential_proof, '/');

        // Check storage/app/private
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check storage/app/public
        $publicPath = storage_path(
            'app/public/' . str_replace('private/', '', $path)
        );

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Residential proof file not found');
    }

    public function getBankCopy($worker_id)
    {
        $worker = decrypt($worker_id);

        $bank_copy = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker)
            ->first();

        if (!$bank_copy || !$bank_copy->worker_bank_copy) {
            abort(404, 'Bank copy not found');
        }

        $path = ltrim($bank_copy->worker_bank_copy, '/');

        // Check storage/app/private
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check storage/app/public
        $publicPath = storage_path(
            'app/public/' . str_replace('private/', '', $path)
        );

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Bank copy file not found');
    }
//    public function getOfficeCertProof($worker_id)
//    {
//        $worker = decrypt($worker_id);
//
//        $cert_proof = DB::table('Worker.worker_ninety_days_certificates')
//            ->where('worker_id', $worker)
//            ->first();
//
//        if (!$cert_proof || !$cert_proof->ninety_days_certificate) {
//            abort(404, 'Certificate not found');
//        }
//
//        $dbPath = $cert_proof->ninety_days_certificate;
//
//        // Check Local/Private Storage
//        $localPath = ltrim($dbPath, '/');
//
//        if (Storage::disk('local')->exists($localPath)) {
//            return response()->file(
//                Storage::disk('local')->path($localPath)
//            );
//        }
//
//        // Check Public Storage
//        $publicPath = str_replace('/private/', '', $dbPath);
//
//        if (Storage::disk('public')->exists($publicPath)) {
//            return response()->file(
//                Storage::disk('public')->path($publicPath)
//            );
//        }
//
//        abort(404, 'Certificate file not found');
//    }


    public function getOfficeSubscription($worker_id)
    {
        $worker = decrypt($worker_id);

        $subscription = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker)
            ->first();

        if (!$subscription || !$subscription->subscription_payment_receipt) {
            abort(404, 'Subscription receipt not found');
        }

        $path = ltrim($subscription->subscription_payment_receipt, '/');

        // Check storage/app/private
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check storage/app/public
        $publicPath = storage_path(
            'app/public/' . str_replace('private/', '', $path)
        );

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Subscription receipt file not found');
    }

    public function getOfficeWorkBook($worker_id)
    {
        $worker = decrypt($worker_id);

        $workbook = DB::table('Worker.workers_workbook_details')
            ->where('worker_id', $worker)
            ->first();

        if (!$workbook || !$workbook->certificate_proof) {
            abort(404, 'Work book not found');
        }

        $path = ltrim($workbook->certificate_proof, '/');

        // Check storage/app/private
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check storage/app/public
        $publicPath = storage_path(
            'app/public/' . str_replace('private/', '', $path)
        );

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Work book file not found');
    }

    public function getNomineeBankCopy($worker_id)
    {
        $worker = decrypt($worker_id);

        $bank_copy = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker)
            ->first();

        if (!$bank_copy || !$bank_copy->nominee_bank_copy) {
            abort(404, 'Nominee bank copy not found');
        }

        $path = ltrim($bank_copy->nominee_bank_copy, '/');

        // Check storage/app/private
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check storage/app/public
        $publicPath = storage_path(
            'app/public/' . str_replace('private/', '', $path)
        );

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Nominee bank copy file not found');
    }

    public function getRation($worker_id)
    {
        $worker = decrypt($worker_id);

        $ration = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker)
            ->first();

        if (!$ration || !$ration->ration_card) {
            abort(404, 'Ration card not found');
        }

        $path = ltrim($ration->ration_card, '/');

        // Check storage/app/private
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check storage/app/public
        $publicPath = storage_path(
            'app/public/' . str_replace('private/', '', $path)
        );

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Ration card file not found');
    }

    public function getPan($worker_id)
    {
        $worker = decrypt($worker_id);

        $pan = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker)
            ->first();

        if (!$pan || !$pan->pan_card) {
            abort(404, 'PAN card not found');
        }

        $path = ltrim($pan->pan_card, '/');

        // Check storage/app/private
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check storage/app/public
        $publicPath = storage_path(
            'app/public/' . str_replace('private/', '', $path)
        );

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'PAN card file not found');
    }

    public function getCertificateNew($worker_id)
    {
        $worker = decrypt($worker_id);

        $certificate = DB::table('Worker.main_worker_certificates')
            ->where('worker_id', $worker)
            ->first();

        if (!$certificate || !$certificate->certificate_proof) {
            abort(404, 'Certificate proof not found');
        }

        $dbPath = $certificate->certificate_proof;

        // Remove leading slash
        $path = ltrim($dbPath, '/');

        // Check Private Storage (storage/app/private)
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check Public Storage (storage/app/public)
        $publicRelativePath = str_replace('private/', '', $path);
        $publicPath = storage_path('app/public/' . $publicRelativePath);

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Certificate proof file not found');
    }

    public function getAckReceipt($worker_id)
    {
        $worker = decrypt($worker_id);

        $ack = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker)
            ->first();

        if (!$ack || !$ack->payment_acknowledgement_slip) {
            abort(404, 'Acknowledgement receipt not found');
        }

        $dbPath = $ack->payment_acknowledgement_slip;

        // Remove leading slash
        $path = ltrim($dbPath, '/');

        // 1. Check Private Storage (storage/app/private)
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // 2. Check Public Storage (storage/app/public)
        $publicRelativePath = str_replace('private/', '', $path);
        $publicPath = storage_path('app/public/' . $publicRelativePath);

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Acknowledgement receipt file not found');
    }

    public function approveApplicationOnboarding(Request $request)
    {
        $usernamedisplay = Auth::user()->username;
        $today = Carbon::today();
        $subscription_validity_date = $request->subscription_validity_date;
        $card_validity_date = $request->card_validity_date;
        $last_registration_date = $request->last_registration_date;
        $subscriptionDate = Carbon::parse($subscription_validity_date);
        $cardDate = Carbon::parse($card_validity_date);


        $renewal_date = null;
        $new_cvd = null;
        if ($cardDate->gt($today) && $subscriptionDate->gt($today)) {

            if ($cardDate->gt($today) && $cardDate->diffInMonths($today) < 3) {
                $new_cvd = $cardDate;


            } else {
                $new_cvd = $cardDate;

            }
        }
        elseif($cardDate->gt($today) && $subscriptionDate->lt($today))
        {
            if ($cardDate->gt($today) && $cardDate->diffInMonths($today) < 3) {
                $new_cvd = $cardDate;


            } else {
                $new_cvd = $cardDate;

            }
        }
         elseif ($cardDate->lt($today) && $subscriptionDate->lt($today)) {

            $new_cvd = $cardDate;

        } elseif ($cardDate->lt($today) && $subscriptionDate->gt($today)) {

            $new_cvd = $cardDate;

        }

        $cvd = Carbon::parse($new_cvd);

        $renewal_date = Carbon::parse($cvd)->addDay()->format('Y-m-d');
        $validator = Validator::make(
            $request->all(),
            [
                'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
//                'remarks' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }

        try {
            DB::beginTransaction();
            $data = DB::table('User.users')->where('username', $usernamedisplay)->first();


            $worker_id = $request->application_id;

              $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
            $onboarding = $wfm->already_registered == 1;
            $retirement_date = Carbon::parse($wfm->date_of_retirement);
            $card_date = Carbon::parse($card_validity_date);

//            while ($cvd->lt($today)) {
//                $cvd = $card_date->addYears(2);
//            }
            $next_card_validity_date = $retirement_date->lt($cvd)
                ? $retirement_date
                : $cvd;

            $next_card_validity_date = $next_card_validity_date->format('Y-m-d');
            $next_renewal_date = Carbon::parse($next_card_validity_date);
            $final_renewal_date = $next_renewal_date->copy()->addDay();

            if ($wfm) {

                $wbd = DB::table('Worker.main_worker_basic_details')
                    ->where('worker_id', $worker_id)
                    ->first();

                if (!$wbd) {
                    return 'Worker basic details not found';
                }

                $application_no = $wfm->application_no;
                $district = $wfm->office_id;
                $year = Carbon::now()->format('Y');
                $string = 'ABOCWWB';
                $is_migrant = ($wbd->resident_type === 'raa') ? 1 : 2;

             $idCard = $string.'/'.$district.'/'.$year.'/'.$is_migrant.'/'.$application_no;

            } else {
                return 'Error: No record found';
            }

       $updated = MainWorkerForm::where('worker_id', $worker_id)->update([
                'subscription_validity_date' => $subscription_validity_date,
                'last_registration_date' => $last_registration_date,
                'id_card_expiry_date' => $next_card_validity_date,
                'application_receiver_user_id' => Auth::id(),
                'renewal_date' => $renewal_date,
                'id_card' => $idCard,
                'active_status' => 1,
                'id_card_created_at' => now(),
                'ro_approval_time' => now(),
            ]);





            $data = MainWorkerBasicDetail::where('worker_id', $worker_id)->update([

                'card_validity_date' => $new_cvd,
                'last_registration_date' => $last_registration_date,


            ]);

//            $csc_data = WorkerPaymentSuccess::where('worker_id', $worker_id)
//                ->whereNotNull('csc_txn_id')
//                ->exists();
            $rtps_data = MainWorkerForm::where('worker_id', $worker_id)
                ->whereNotNull('rtps_trans_id')
                ->first();
            if ($rtps_data)
            {


                if ($rtps_data->rtps_trans_id != null) {
                    $response = $this->pfcController->submitApplicationStatus($worker_id);
                    if ($response->status == true) {
                        DB::commit();
                        Alert::toast('Application Approved Successfully', 'success');
                        session()->put('route', route('office.applications.preview', encrypt($worker_id)));
//                        return redirect()->route('office.applications.preview', encrypt($worker_id));

                    } else {
//                        DB::rollBack();
//                        Alert::toast($response['message'] . ' in Sewasetu', 'error');
//                        return back();
//                        session()->put('route', 0);
//                        return redirect()->route('office.dsc.eSign', encrypt($worker_id))->with('msg', 'Application Approved Successfully');
                        DB::commit();
                        Alert::toast('Application Approved Successfully', 'success');
                        session()->put('route', route('office.applications.preview', encrypt($worker_id)));
                    }
                }
            }

            DB::commit();
            Alert::toast('Application Approved Successfully', 'success');
            $certificate_count = DscRegistration::where('user_id', Auth::user()->id)->first();
            if (!$certificate_count) {
                Alert::toast('Register your Token First', 'error');
                return view('office.dsc-registration.registration');
            } else {
                session()->put('route', route('office.applications.preview', encrypt($worker_id)));
                return redirect()->route('office.dsc.eSign', encrypt($worker_id))->with('msg', 'Application Approved Successfully');
            }


            // return redirect()->route('office.dashboard.index')->with('msg', 'Application Approved Successfully');
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;

            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }
    public function approveApplication(Request $request)
    {

        $usernamedisplay = Auth::user()->username;
        $validator = Validator::make(
            $request->all(),
            [
                'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
//                'remarks' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }

        try {
            DB::beginTransaction();
//            $data = DB::table('User.users')->where('username', $usernamedisplay)->first();


            $worker_id = $request->application_id;

            $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();

            if ($wfm) {

                $wbd = DB::table('Worker.main_worker_basic_details')->where('worker_id', $worker_id)->first();

                $application_no = $wfm->application_no;
                $district = $wfm->office_id;
                $year = Carbon::now()->format('Y');
                $string = 'ABOCWWB';
                $is_migrant = ($wbd->resident_type === 'raa') ? 1 : 2;
                $idCard = $string . '/' . $district . '/' . $year . '/' . $is_migrant . '/' . $application_no;
            } else {
                $idCard = null;
                DB::rollBack();
                Alert::toast('Application not found', 'error');
                return back();
            }

            //application-status

            //user data


            // Main-worker-update
            $dataUser = DB::table('User.users')->where('users.username', $usernamedisplay)->first();

            $data = MainWorkerForm::where('worker_id', $worker_id)->update([
                'id_card' => $idCard
            ]);
            if($idCard == null || $idCard == ''){
                DB::rollBack();
                Alert::toast('Id Card is not generated', 'error');
                return back();
            }

           $csc_data = WorkerPaymentSuccess::where('worker_id', $worker_id)
                ->where('STATUS', 'F')
                ->whereNotNull('merchant_txn')
                ->exists();
            if ($csc_data)
            {
                $rtps = WorkerPaymentSuccess::where('worker_id', $worker_id)
                    ->whereNotNull('csc_txn_id')
                    ->first();
                $rtps_data = MainWorkerForm::where('worker_id', $rtps->worker_id)->first();

                if ($rtps_data->rtps_trans_id != null) {
                    $response = $this->pfcController->submitApplicationStatus($worker_id);

                    if ($response->status == true) {
                        DB::commit();
                        Alert::toast('Application Approved Successfully Sewasetu', 'success');
                        session()->put('route', 0);
//
                         return redirect()->route('office.dsc.eSign', encrypt($worker_id))->with('msg', 'Application Approved Successfully Sewasetu');

                    } else {
//                        DB::rollBack();
//                        Alert::toast($response->message . ' in Sewasetu', 'error');
//                        return back();
                        DB::commit();
                        session()->put('route', 0);
                        return redirect()->route('office.dsc.eSign', encrypt($worker_id))->with('msg', 'Application Approved Successfully');
                    }
                }
            }
//
            DB::commit();
            Alert::toast('Application Approved Successfully', 'success');
            $certificate_count = DscRegistration::where('user_id', Auth::user()->id)->first();
            if (!$certificate_count) {
                Alert::toast('Register your Token First', 'error');
                return view('office.dsc-registration.registration');
            } else {
                session()->put('route', 0);
                return redirect()->route('office.dsc.eSign', encrypt($worker_id))->with('msg', 'Application Approved Successfully');
            }


//             return redirect()->route('office.dashboard.index')->with('msg', 'Application Approved Successfully');
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }
    public function approveRenewApplication(Request $request)
    {
        $usernamedisplay = Auth::user()->username;

        $validator = Validator::make(
            $request->all(),
            [
                'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
//                'remarks' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }

        try {
            DB::beginTransaction();
            $userdata = DB::table('User.users')->where('username', $usernamedisplay)->first();

            $worker_id = $request->application_id;

            $idCard = MainWorkerForm::where('worker_id', $worker_id)->pluck('id_card')->first();
            $wfm = RenewWorkerForm::where('worker_id', $worker_id)->first();
            $data = MainWorkerForm::where('worker_id',$worker_id)->first();
            $onboarding = $data->already_registered == 1;
            $card_validity_date = Carbon::parse($data->id_card_expiry_date) ;
            $today = now();
            $year_cycle = Carbon::parse($data->id_card_expiry_date)->format('Y');
            $todaysCycle = Carbon::parse(now()->format('Y'));
            $day_cycle = Carbon::parse($data->id_card_expiry_date)->format('d') ;
            $retirement_date = Carbon::parse($data->date_of_retirement);

            while ($card_validity_date->lt($today)) {

                $card_validity_date->addYears(2);
            }
            if ($retirement_date->lt($card_validity_date)) {

                $next_card_validity_date = Carbon::parse($retirement_date)->format('Y-m-d');
            } else {
                $next_card_validity_date = Carbon::parse($card_validity_date)->format('Y-m-d');
            }
            $next_renewal_date = Carbon::parse($next_card_validity_date);
            $renewalDate = $next_renewal_date->copy()->addDay();
            $final_renewal_date = Carbon::parse($renewalDate)->format('Y-m-d');



            //application-status


            $update = MainWorkerForm::where('worker_id', $worker_id)->update([
                'id_card_expiry_date' => $next_card_validity_date,
                'renewal_date' => $final_renewal_date,

            ]);
            $wbd = MainWorkerBasicDetail::where('worker_id', $worker_id)->first();
            $application_no = $wfm->application_no;
            $district = $wfm->office_id;
            $year = Carbon::now()->format('Y');
            $string = 'ABOCWWB';
            $is_migrant = ($wbd->resident_type === 'raa') ? 1 : 2;
            $idCard = $string . '/' . $district . '/' . $year . '/' . $is_migrant . '/' . $application_no;

            // Main-worker-update
            $data = RenewWorkerForm::where('worker_id', $worker_id)->update([

                'id_card' => $idCard,
                'id_card_created_at' => now(),
                'ro_approval_time' => now(),
                'next_renewal_date' => $final_renewal_date,
                'id_card_expiry_date' => $next_card_validity_date,
                'is_renewal' => 1,
            ]);

//            WorkerApplicationStatus::create(
//                [
//                    'worker_id' => $worker_id,
//                    'ack_no' => $wfm->ack_no,
//                    'application_no' => $wfm->application_no,
//                    'application_status' => env('APPLICATION_FINAL_APPROVED'),
//                    'remarks' => 'Renewal Application Approved',
//                    'sender_role_id' => $userdata->role_id,
//                    'sender_office_id' => $userdata->office_id,
//                    'sender_user_id' => $userdata->id,
//                    'application_from_user' => $userdata->id,
//                    'is_renewal' => 1,
//                    'ro_approval_time' => now(),
//                    'already_registered' => $onboarding ? 1 : 0,
//                ]
//            );


            if ($wfm->rtps_trans_id !== null)
           {
               $response = $this->pfcController->submitApplicationStatus($worker_id);
//               $rtps_response = json_decode($response, true);
               if ($response->status == true) {
                   DB::commit();
                   Alert::toast('Application Approved Successfully Sewasetu', 'success');
                   session()->put('route', 0);
//                        session()->put('route', route('office.applications.preview', encrypt($worker_id)));
                   return redirect()->route('office.dsc.eSign', encrypt($worker_id))->with('msg', 'Application Approved Successfully Sewasetu');

                   // return redirect()->route('office.dashboard.index')->with('msg', 'Application Approved Successfully');
               } else {
//                   DB::rollBack();
//                   Alert::toast($response->message . ' in Sewasetu', 'error');
//                   return back();
                   DB::commit();
                   Alert::toast('Application Approved Successfully', 'success');
                   session()->put('route', 0);
//                        session()->put('route', route('office.applications.preview', encrypt($worker_id)));
                   return redirect()->route('office.dsc.eSign', encrypt($worker_id))->with('msg', 'Application Approved Successfully Sewasetu');
               }

           }

            DB::commit();
            Alert::toast('Application Approved Successfully', 'success');
            $certificate_count = DscRegistration::where('user_id', Auth::user()->id)->first();
            if (!$certificate_count) {

                Alert::toast('Register your Token First', 'error');
                return view('office.dsc-registration.registration');
            } else {
                session()->put('route', 0);

                return redirect()->route('office.dsc.eSign', encrypt($worker_id))->with('msg', 'Application Approved Successfully');
            }
        } catch (Exception $e) {
//            return $e;
            DB::rollBack();
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }

        // SMS sent successfully

    }

    public function rejectApplication(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'reject_reasons' => 'required|array|min:1',
                'reject_reasons.*' => 'required|exists:pgsql.Masterdata.reasons,id',
                'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
                'remarks' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;
        try {
            DB::beginTransaction();
            $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
            $worker_id = $request->application_id;
            $main = MainWorkerForm::where('worker_id', $worker_id)->first();
            $main_basic = MainWorkerBasicDetail::where('worker_id', $worker_id)->first();
            $main_address = MainWorkerAddress::where('worker_id', $worker_id)->first();
            $main_bank = MainWorkerBank::where('worker_id', $worker_id)->first();
            $main_certificate = MainWorkerCertificate::where('worker_id', $worker_id)->first();
            $main_document = MainWorkerDocument::where('worker_id', $worker_id)->first();
            $main_family = MainWorkerFamily::where('worker_id', $worker_id)->first();
            $main_scheme = MainWorkerScheme::where('worker_id', $worker_id)->first();
            $main_vault = MainVaultData::where('worker_id', $worker_id)->first();
            $temp = TemporaryWorkerForm::where('worker_id', $worker_id)->first();
            $temp_basic = TemporaryWorkerBasicDetail::where('worker_id', $worker_id)->first();
            $temp_address = TemporaryWorkerAddress::where('worker_id', $worker_id)->first();
            $temp_bank = TemporaryWorkerBank::where('worker_id', $worker_id)->first();
            $temp_certificate = TemporaryWorkerCertificate::where('worker_id', $worker_id)->first();
            $temp_document = TemporaryWorkerDocument::where('worker_id', $worker_id)->first();
            $temp_family = TemporaryWorkerFamily::where('worker_id', $worker_id)->first();
            $temp_scheme = TemporaryWorkerScheme::where('worker_id', $worker_id)->first();
            $temp_vault = VaultData::where('worker_id', $worker_id)->first();

            $onboarding = $temp->already_registered == 1;

            $data = WorkerApplicationStatus::Create([
                'worker_id' => $worker_id,
                'ack_no' => $main->ack_no,
                'application_no' => $main->application_no,
                'application_status' => env('APPLICATION_REJECT'),
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id,
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id,
                'application_from_user' => $data->id,
                'already_registered' => $onboarding ? 1 : 0 ,
                'reasons' => implode(',', $request->reject_reasons),
            ]);
            $cancelled = CancelledAppModal::Create([
                'worker_id' => $main->worker_id,
                'ack_no' => $main->ack_no,
                'application_no' => $main->application_no,
                'remarks' => $data->remarks,
                'phone_no' => $main->phone_no,
                'office_id' => $main->office_id,
                'district' => $main->district,
                'already_registered' => $main->already_registered,
                'vaultToken' => $main->vaultToken,
                'vaultPassKey' => $main->vaultPassKey,
                'status' => env('APPLICATION_REJECT'),
            ]);

            $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
            $phoneNumber = $cancelled->phone_no;
            $application_no = $cancelled->application_no;

            $remarks = 'Rejected';
            $temp->forceDelete();
            $temp_basic->forceDelete();
            $temp_address->forceDelete();
            $temp_bank->forceDelete();

            if ($temp_certificate && $temp_certificate->already_registered == '1') {
                $temp_certificate->forceDelete();
            }

            $temp_document->forceDelete();
            $temp_family->forceDelete();
            $temp_scheme->forceDelete();
            $temp_vault->forceDelete();
            $main->delete();
            $main_basic->delete();
            $main_address->delete();
            $main_bank->delete();
            if ($main_certificate && $main_certificate->already_registered == '1') {
                $main_certificate->delete();
            }
            $main_document->delete();

            $main_family->delete();
            $main_scheme->delete();
            if ($main_vault) {
                $main_vault->delete();
            }



//            if ($rtps_data->rtps_trans_id != null) {
//                $response = $this->pfcController->submitApplicationStatus($worker_id);
////                $rtps_response = json_decode($response_data, true);
//                // dd($rtps_response['status']);
//                // return $rtps_response['status'];
//                if ($response->status == true) {
//                    DB::commit();
//                    $response_sms = $this->smsService->applicationRejectedSMS($phoneNumber, $application_no, $remarks);
//                    if ($response_sms === false) {
//                        return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
//                    } else {
//                        // SMS sent successfully
//                        Alert::toast('Application Rejected Successfully', 'success');
//                        return redirect()->route('office.dashboard.index')->with('msg', 'Application Rejected');
//                    }
//                } else {
//                    DB::rollBack();
//                    Alert::toast($response->message . ' in Sewasetu', 'error');
//                    return back();
//                }
//            }
            DB::commit();
            $response_sms = $this->smsService->applicationRejectedSMS($phoneNumber, $application_no, $remarks);
            if ($response_sms === false) {
                return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
            } else {
                // SMS sent successfully
                Alert::toast('Application Rejected Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Rejected');
            }
        } catch (Exception $e) {
//            return $e;
            DB::rollBack();

            Alert::toast('Something Went Wrong', 'error');
            return back();
        }
    }


    /** RO To Da */
    public function forwardApplication(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'remarks' => 'required|string',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',

        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;
        $rfm = null;

        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $worker_id = $request->application_id;
        $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        if (RenewWorkerForm::where('worker_id',$worker_id)->exists())
        {
           $rfm = RenewWorkerForm::where('worker_id',$worker_id)->first();
        }

        $application_no = $wfm->application_no;


        try {
            if ($wfm)
            {
                $isRenewal = $wfm->is_renewal == 1;
                $onboarding = $wfm->already_registered == 1;

            DB::beginTransaction();
            $forwardRo = WorkerApplicationStatus::Create([
                'worker_id' => $worker_id,
                'application_no' => $application_no,
                'ack_no' => $isRenewal ? $rfm->ack_no : $wfm->ack_no,
                'application_status' => env('DEALING_ASSISTANT'),
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id, //RO Role ID
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id, //Ro user id
                'application_from_user' => $data->username,
                'application_receiver_user_id' => $request->user_id,
                'application_receiver_role_id' => $request->role_id,
                'is_renewal' => $isRenewal ? 1 : 0,
                'already_registered' => $onboarding ?1 :0,
            ]);
                $workerId = $request->application_id;
            if ($isRenewal)
            {
                $data = RenewWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('DEALING_ASSISTANT'),
                    'application_receiver_user_id' => $forwardRo->application_receiver_user_id,
                    'application_sender_user_id' => $forwardRo->sender_user_id,
                    'sender_role_id' => Auth::user()->role_id, //RO Role ID
                    'application_receiver_role_id' => $request->role_id,
                    'forward_to_da' => now(),
                ]);


            }else{
                MainWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('DEALING_ASSISTANT'),
                    'application_receiver_user_id' => $forwardRo->application_receiver_user_id,
                    'application_sender_user_id' => $forwardRo->sender_user_id,
                    'forward_to_da' => now(),
                ]);
            }



            $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
            if ($rtps_data->rtps_trans_id != null) {
                $response = $this->pfcController->submitApplicationStatus($worker_id);
                // $rtps_response = json_decode($response, true);
                // // dd($rtps_response['status']);
                // // return $rtps_response['status'];
                // if ($rtps_response['status'] == true) {
                //     DB::commit();
                //     Alert::toast('Application Forwarded Successfully', 'success');
                //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded Successfully');
                // } else {
                //     DB::rollBack();
                //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                //     return back();
                // }
            }
            }
            DB::commit();
            Alert::toast('Application Forwarded To Dealing Assistant Successfully', 'success');
            return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded Successfully');
        } catch (Exception $e) {
            return $e;
            DB::rollBack();
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }
    /***Forward To RO and DA By HRO **/
    public function forwardApplicationToRo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'remarks' => 'required|string',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
            'role_id' => 'required|exists:pgsql.User.roles,id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;

        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $worker_id = $request->application_id;
        $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $application_no = $wfm->application_no;
        $rfm = false;
        if (RenewWorkerForm::where('worker_id',$worker_id)->exists())
        {
           $rfm = RenewWorkerForm::where('worker_id',$worker_id)->first();
        }

        if ($request->role_id == 3) {
            try {
                if ($wfm) {
                    $isRenewal = $wfm->is_renewal == 1;
                    $onboarding = $wfm->already_registered == 1;

                    DB::beginTransaction();
                    $forward = WorkerApplicationStatus::Create([
                        'worker_id' => $worker_id,
                        'application_no' => $application_no,
                        'ack_no' => $isRenewal ? $rfm->ack_no : $wfm->ack_no,
                        'application_status' => env('REGISTERING_OFFICER'),
                        'remarks' => $request->remarks,
                        'sender_role_id' => Auth::user()->role_id, //RO Role ID
                        'sender_office_id' => $data->office_id,
                        'sender_user_id' => $data->id, //user id
                        'application_from_user' => $data->username,
                        'application_receiver_user_id' => $request->user_id,
                        'application_receiver_role_id' => $request->role_id,
                        'is_renewal' => $isRenewal ? 1 : 0,
                        'already_registered' => $onboarding ?1 :0,
                    ]);

                    $workerId = $request->application_id;
                    if ($isRenewal)
                    {
                        $data = RenewWorkerForm::where('worker_id', $workerId)->update([
                            'status' => env('REGISTERING_OFFICER'),
                            'application_receiver_user_id' => $forward->application_receiver_user_id,
                            'application_sender_user_id' => $forward->sender_user_id,
                            'sender_role_id' => Auth::user()->role_id, //RO Role ID
                            'application_receiver_role_id' => $request->role_id,
                            'forward_to_da' => now(),
                        ]);
                    }else{
                        $data = MainWorkerForm::where('worker_id', $workerId)->update([
                            'status' => env('REGISTERING_OFFICER'),
                            'application_receiver_user_id' => $forward->application_receiver_user_id,
                            'application_sender_user_id' => $forward->sender_user_id,
                            'forward_to_ro' => now(),
                        ]);
                    }



//                    $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
//                    if ($rtps_data->rtps_trans_id != null) {
//                        $response = $this->pfcController->submitApplicationStatus($worker_id);
//                        // $rtps_response = json_decode($response, true);
//                        // DB::rollBack();
//
//                        // // dd($rtps_response['status']);
//                        // // return $rtps_response['status'];
//                        // if ($rtps_response['status'] == true) {
//                        //     DB::commit();
//                        //     Alert::toast('Application Forwarded To Registering Officer Successfully', 'success');
//                        //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded Successfully');
//                        // } else {
//                        //     DB::rollBack();
//                        //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
//                        //     return back();
//                        // }
//                    }
                }
                DB::commit();
                Alert::toast('Application Forwarded Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded Successfully');
            } catch (Exception $e) {
//                return $e;
                DB::rollBack();
                Alert::toast('Something Went Wrong!', 'error');
                return back();
            }
        } else if ($request->role_id == 4) {
            try {
                if ($wfm) {
                    $isRenewal = $wfm->is_renewal == 1;
                    $onboarding = $wfm->already_registered == 1;
                    DB::beginTransaction();
                    $forward = WorkerApplicationStatus::Create([
                        'worker_id' => $worker_id,
                        'application_no' => $application_no,
                        'ack_no' => $isRenewal ? $rfm->ack_no : $wfm->ack_no,
                        'application_status' => env('DEALING_ASSISTANT'),
                        'remarks' => $request->remarks,
                        'sender_role_id' => Auth::user()->role_id, //RO Role ID
                        'sender_office_id' => $data->office_id,
                        'sender_user_id' => $data->id, //user id
                        'application_from_user' => $data->username,
                        'application_receiver_user_id' => $request->user_id,
                        'application_receiver_role_id' => $request->role_id,
                        'is_renewal' => $isRenewal ? 1 : 0,
                        'already_registered' => $onboarding ? 1 : 0,
                    ]);

                    $workerId = $request->application_id;
                    if ($isRenewal)
                    {
                        $data = RenewWorkerForm::where('worker_id', $workerId)->update([
                            'status' => env('DEALING_ASSISTANT'),
                            'application_receiver_user_id' => $forward->application_receiver_user_id,
                            'application_sender_user_id' => $forward->sender_user_id,
                            'sender_role_id' => $forward->role_id, //RO Role ID
                            'application_receiver_role_id' => $request->role_id,
                            'forward_to_da' => now(),
                        ]);
                    }else{
                        $data = MainWorkerForm::where('worker_id', $workerId)->update([
                            'status' => env('DEALING_ASSISTANT'),
                            'application_receiver_user_id' => $forward->application_receiver_user_id,
                            'application_sender_user_id' => $forward->sender_user_id,
                            'forward_to_ro' => now(),
                        ]);
                    }


                    $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
//                    if ($rtps_data->rtps_trans_id != null) {
//                        $response = $this->pfcController->submitApplicationStatus($worker_id);
                        // $rtps_response = json_decode($response, true);
                        // // DB::rollBack();
                        // // dd($rtps_response);
                        // // dd($rtps_response['status']);
                        // // return $rtps_response['status'];
                        // if ($rtps_response['status'] == true) {
                        //     DB::commit();
                        //     Alert::toast('Application Forwarded To Dealing Assistant Successfully', 'success');
                        //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded to Dealing Assistant Successfully');
                        // } else {
                        //     DB::rollBack();
                        //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                        //     return back();
                        // }
//                    }
                }
                DB::commit();
                Alert::toast('Application Forwarded to Dealing Assistant Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded to Dealing Assistant Successfully');
            } catch (Exception $e) {
                DB::rollBack();
//                return $e;
                Alert::toast('Something Went Wrong!', 'error');
                return back();
            }
        }
    }

    public function forwardRenewApplication(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'remarks' => 'required|string',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;

        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $worker_id = $request->application_id;
        $wfm=MainWorkerForm::where('worker_id',$worker_id)->first();
        $rfm = false;
        $isRenewal = false;
        if (RenewWorkerForm::where('worker_id',$worker_id)->exists())
        {
            $rfm = RenewWorkerForm::where('worker_id',$worker_id)->first();
            $isRenewal = $wfm->is_renewal == 1;
        }
        $application_no = $wfm->application_no;


        try {

            $onboarding = $wfm->already_registered == 1;
            DB::beginTransaction();
            $forward = WorkerApplicationStatus::Create([
                'worker_id' => $worker_id,
                'application_no' => $application_no,
                'ack_no' => $isRenewal ? $rfm->ack_no : $wfm->ack_no,
                'application_status' => env('DEALING_ASSISTANT'),
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id, //RO Role ID
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id, //Ro user id
                'application_from_user' => $data->username,
                'application_receiver_user_id' => $request->user_id,
                'application_receiver_role_id' => $request->role_id,
                'is_renewal' => 1,

            ]);
            $workerId = $request->application_id;
            $data = RenewWorkerForm::where('worker_id', $worker_id)->update([
                'status' => env('DEALING_ASSISTANT'),
                'application_receiver_user_id' => $forward->application_receiver_user_id,
                'sender_role_id' => Auth::user()->role_id, //RO Role ID
                'application_receiver_role_id' => $request->role_id,
                'forward_to_da' => now(),
            ]);

            $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
            if ($rtps_data->rtps_trans_id != null) {
                $response = $this->pfcController->submitApplicationStatus($worker_id);
                // $rtps_response = json_decode($response, true);
                // // dd($rtps_response['status']);
                // // return $rtps_response['status'];
                // if ($rtps_response['status'] == true) {
                //     DB::commit();
                //     Alert::toast('Application Forwarded Successfully', 'success');
                //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded Successfully');
                // } else {
                //     DB::rollBack();
                //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                //     return back();
                // }
            }
            DB::commit();
            Alert::toast('Application Forwarded Successfully', 'success');
            return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }
    public function sendBackApplicationHroRenewal(Request $request)
    {


        $validate = Validator::make($request->all(), [

            'remarks' => 'required|string',
            'role_id' => 'required|exists:pgsql.User.users,role_id',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id'
        ]);
        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;
        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $worker_id = $request->application_id;
        $wfm = RenewWorkerForm::where('worker_id', $worker_id)->first();
        $rfm = false;
        $isRenewal = false;
        if (RenewWorkerForm::where('worker_id',$worker_id)->exists())
        {
            $rfm = RenewWorkerForm::where('worker_id',$worker_id)->first();
            $isRenewal = true;
        }
        $application_no = $wfm->application_no;
        try {
            DB::beginTransaction();
            $data = WorkerApplicationStatus::Create([
                'worker_id' => $worker_id,
                'application_no' => $application_no,
                'application_status' => env('HEAD_REGISTERING_OFFICER'),
                'ack_no' => $isRenewal ? $rfm->ack_no : $wfm->ack_no,
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id,
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id,
                'application_from_user' => $data->username,
                'application_receiver_role_id' => $request->role_id,
                'application_receiver_user_id' => $request->user_id,
                'da_forward' => 1,
                'is_renewal' => 1,

            ]);

            $workerId = $request->application_id;
            $data1 = RenewWorkerForm::where('worker_id', $workerId)->update([
                'status' => env('HEAD_REGISTERING_OFFICER'),
                'application_receiver_user_id' => $data->application_receiver_user_id,
                'application_sender_user_id' => $data->sender_user_id,
                'sender_role_id' => Auth::user()->role_id, //RO Role ID
                'application_receiver_role_id' => $request->role_id,
                'da_forward' => 1,
                'is_renewal' => 1,
            ]);

            $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
            if ($rtps_data->rtps_trans_id != null) {
                $response = $this->pfcController->submitApplicationStatus($worker_id);
                // $rtps_response = json_decode($response, true);
                // // dd($rtps_response['status']);
                // // return $rtps_response['status'];
                // if ($rtps_response['status'] == true) {
                //     DB::commit();
                //     Alert::toast('Application Send Back to HRO Successfully', 'success');
                //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Send Back to HRO Successfully');
                // } else {
                //     DB::rollBack();
                //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                //     return back();
                // }
            }
            DB::commit();
            Alert::toast('Application Send Back to HRO Successfully', 'success');
            return redirect()->route('office.dashboard.index')->with('msg', 'Application Send Back to HRO Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }

    /** forward to RO by Da */
    public function sendBackApplication(Request $request)
    {


        $validate = Validator::make($request->all(), [

            'remarks' => 'required|string',
            'role_id' => 'required|exists:pgsql.User.users,role_id',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id'
        ]);
        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;
        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $worker_id = $request->application_id;
        $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $application_no = $wfm->application_no;
        $onboarding = $wfm->already_registered == 1;

        if ($request->role_id == 3) {
            try {
                DB::beginTransaction();
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $worker_id,
                    'application_no' => $application_no,
                    'application_status' => env('REGISTERING_OFFICER'),
                    'ack_no' => $wfm->ack_no,
                    'remarks' => $request->remarks,
                    'sender_role_id' => Auth::user()->role_id,
                    'sender_office_id' => $data->office_id,
                    'sender_user_id' => $data->id,
                    'application_from_user' => $data->username,
                    'application_receiver_role_id' => $request->role_id,
                    'application_receiver_user_id' => $request->user_id,
                    'already_registered' => $onboarding ? 1 : 0,
                    'da_forward' => '1',

                ]);

                $workerId = $request->application_id;
                $data = MainWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('REGISTERING_OFFICER'),
                    'application_receiver_user_id' => $data->application_receiver_user_id,
                    'application_sender_user_id' => $data->sender_user_id,
                    'da_forward' => 1,
                ]);

                $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
                if ($rtps_data->rtps_trans_id != null) {
                    $response = $this->pfcController->submitApplicationStatus($worker_id);
                    // $rtps_response = json_decode($response, true);
                    // // dd($rtps_response['status']);
                    // // return $rtps_response['status'];
                    // if ($rtps_response['status'] == true) {
                    //     DB::commit();
                    //     Alert::toast('Application Send Back to RO Successfully', 'success');
                    //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Send Back to RO Successfully');
                    // } else {
                    //     DB::rollBack();
                    //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                    //     return back();
                    // }
                }
                DB::commit();
                Alert::toast('Application Send Back to RO Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Send Back to RO Successfully');
            } catch (Exception $e) {
                DB::rollBack();
                Alert::toast('Something Went Wrong!', 'error');
                return back();
            }
        } elseif ($request->role_id == 2) {
            try {
                DB::beginTransaction();
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $worker_id,
                    'application_no' => $application_no,
                    'application_status' => env('HEAD_REGISTERING_OFFICER'),
                    'ack_no' => $wfm->ack_no,
                    'remarks' => $request->remarks,
                    'sender_role_id' => Auth::user()->role_id,
                    'sender_office_id' => $data->office_id,
                    'sender_user_id' => $data->id,
                    'application_from_user' => $data->username,
                    'application_receiver_role_id' => $request->role_id,
                    'application_receiver_user_id' => $request->user_id,
                    'already_registered' => $onboarding ? 1 : 0,

                ]);

                $workerId = $request->application_id;
                $data1 = MainWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('HEAD_REGISTERING_OFFICER'),
                    'application_receiver_user_id' => $data->application_receiver_user_id,
                    'application_sender_user_id' => $data->sender_user_id,
                    'da_forward' => 1,
                ]);

                $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
                if ($rtps_data->rtps_trans_id != null) {
                    $response = $this->pfcController->submitApplicationStatus($worker_id);
                    // $rtps_response = json_decode($response, true);
                    // // dd($rtps_response['status']);
                    // // return $rtps_response['status'];
                    // if ($rtps_response['status'] == true) {
                    //     DB::commit();
                    //     Alert::toast('Application Send Back to HRO Successfully', 'success');
                    //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Send Back to HRO Successfully');
                    // } else {
                    //     DB::rollBack();
                    //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                    //     return back();
                    // }
                }
                DB::commit();
                Alert::toast('Application Send Back to HRO Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Send Back to HRO Successfully');
            } catch (Exception $e) {
                DB::rollBack();
                Alert::toast('Something Went Wrong!', 'error');
                return back();
            }
        }
    }

    public function sendBackApplicationRenewal(Request $request)
    {


        $validate = Validator::make($request->all(), [

            'remarks' => 'required|string',
            'role_id' => 'required|exists:pgsql.User.users,role_id',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id'
        ]);
        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;
        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $worker_id = $request->application_id;
        $reg = MainWorkerForm::where('worker_id', $worker_id)->first();
//        $wfm = RenewWorkerForm::where('worker_id', $worker_id)->first();
        $rfm = false;
        $isRenewal = false;
        if (RenewWorkerForm::where('worker_id',$worker_id)->exists())
        {
            $rfm = RenewWorkerForm::where('worker_id',$worker_id)->first();
            $isRenewal = true;
        }
        $application_no = $reg->application_no;
        $onboarding = $reg->already_registered == 1;

        if ($request->role_id == 3) {
            try {
                DB::beginTransaction();
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $worker_id,
                    'application_no' => $application_no,
                    'application_status' => env('REGISTERING_OFFICER'),
                    'ack_no' => $isRenewal ?  $rfm->ack_no : $reg->ack_no,
                    'remarks' => $request->remarks,
                    'sender_role_id' => Auth::user()->role_id,
                    'sender_office_id' => $data->office_id,
                    'sender_user_id' => $data->id,
                    'application_from_user' => $data->username,
                    'application_receiver_role_id' => $request->role_id,
                    'application_receiver_user_id' => $request->user_id,
                    'is_renewal' => 1,
                    'already_registered' => $onboarding ? 1 : 0,
                    'da_forward' => 1,

                ]);

                $workerId = $request->application_id;
                $data = RenewWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('REGISTERING_OFFICER'),
                    'application_receiver_user_id' => $data->application_receiver_user_id,
                    'application_sender_user_id' => $data->sender_user_id,
                    'sender_role_id' => Auth::user()->role_id, //RO Role ID
                    'application_receiver_role_id' => $request->role_id,
                    'da_forward' => 1,
                ]);

                DB::commit();
                Alert::toast('Application Send Back to RO Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Send Back to RO Successfully');
            } catch (Exception $e) {
                DB::rollBack();
                Alert::toast('Something Went Wrong!', 'error');
                return back();
            }
        } elseif ($request->role_id == 2) {
            try {
                DB::beginTransaction();
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $worker_id,
                    'application_no' => $application_no,
                    'application_status' => env('HEAD_REGISTERING_OFFICER'),
                    'ack_no' => $isRenewal ? $rfm->ack_no : $reg->ack_no,
                    'remarks' => $request->remarks,
                    'sender_role_id' => Auth::user()->role_id,
                    'sender_office_id' => $data->office_id,
                    'sender_user_id' => $data->id,
                    'application_from_user' => $data->username,
                    'application_receiver_role_id' => $request->role_id,
                    'application_receiver_user_id' => $request->user_id,
                    'is_renewal' => 1,
                    'da_forward' => 1,
                    'already_registered' => $onboarding ? 1 : 0,

                ]);

                $workerId = $request->application_id;
                $data1 = RenewWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('HEAD_REGISTERING_OFFICER'),
                    'application_receiver_user_id' => $data->application_receiver_user_id,
                    'application_sender_user_id' => $data->sender_user_id,
                    'sender_role_id' => Auth::user()->role_id, //RO Role ID
                    'application_receiver_role_id' => $request->role_id,
                    'da_forward' => 1,
                ]);
                DB::commit();
                Alert::toast('Application Send Back to HRO Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Send Back to HRO Successfully');
            } catch (Exception $e) {

                DB::rollBack();
                Alert::toast('Something Went Wrong!', 'error');
                return back();
            }
        }
    }


    public function forwardToRoRenewApplication(Request $request)
    {
        $validate = Validator::make($request->all(), [

            'remarks' => 'required|string',
            'role_id' => 'required|exists:pgsql.User.users,role_id',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id'
        ]);
        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;
        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $worker_id = $request->application_id;
        $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $rfm = false;
        $isRenewal = false;
        if (RenewWorkerForm::where('worker_id',$worker_id)->exists())
        {
            $rfm = RenewWorkerForm::where('worker_id',$worker_id)->first();
            $isRenewal = true;
        }
        $application_no = $wfm->application_no;
        $onboarding = $wfm->already_registered == 1;


        try {
            DB::beginTransaction();
            $data = WorkerApplicationStatus::Create([
                'worker_id' => $worker_id,
                'application_no' => $application_no,
                'application_status' => env('REGISTERING_OFFICER'),
                'ack_no' => $isRenewal ? $rfm->ack_no : $wfm->ack_no,
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id,
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id,
                'application_from_user' => $data->username,
                'application_receiver_role_id' => $request->role_id,
                'already_registered' => $onboarding ? 1 : 0,
                'is_renewal' => '1'
            ]);

            $workerId = $request->application_id;
            $data = MainWorkerForm::where('worker_id', $workerId)->update([
                'status' => env('REGISTERING_OFFICER'),
                'da_forward' => 1,
            ]);

            $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
            if ($rtps_data->rtps_trans_id != null) {
                $response = $this->pfcController->submitApplicationStatus($worker_id);
                // $rtps_response = json_decode($response, true);
                // // dd($rtps_response['status']);
                // // return $rtps_response['status'];
                // if ($rtps_response['status'] == true) {
                //     DB::commit();
                //     Alert::toast('Application Forwarded Successfully', 'success');
                //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded to RO Successfully');
                // } else {
                //     DB::rollBack();
                //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                //     return back();
                // }
            }
            DB::commit();
            Alert::toast('Application Forwarded Successfully', 'success');
            return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded to RO Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }

    /** Pulling Application Back From DA/RO */
    public function pullBackApplication(Request $request)
    {
        $sessionvalue = session()->all();
        $validate = Validator::make($request->all(), [

            'remarks' => 'required|string',
            'role_id' => 'required|exists:pgsql.User.users,role_id',
            'user_id' => 'required|exists:pgsql.User.users,id',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
            'pull_back' => 'required|in:1'
        ]);

        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }


        $usernamedisplay = Auth::user()->username;
        $worker_id = $request->application_id;
        $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $appdata = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $onboarding = $wfm->already_registered == 1;

        $application_no = $wfm->application_no;


        try {
            DB::beginTransaction();
            if (Auth::user()->role_id == 3) {


                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $worker_id,
                    'ack_no' => $wfm->ack_no,
                    'application_no' => $application_no,
                    'application_status' => env('REGISTERING_OFFICER'),
                    'remarks' => $request->remarks,
                    'sender_role_id' => $appdata->role_id,
                    'sender_office_id' => $appdata->office_id,
                    'sender_user_id' => $wfm->application_receiver_user_id,
                    'application_from_user' => $appdata->username,
                    'application_receiver_role_id' => $wfm->role_id,
                    'application_receiver_user_id' => $wfm->application_sender_user_id,
                    'pull_back' => $request->pull_back,
                    'already_registered' => $onboarding ? 1 : 0,
                ]);
                $workerId = $request->application_id;
                $data = MainWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('REGISTERING_OFFICER'),
                    'pull_back' => '1',
                    'application_receiver_user_id' => $data->application_receiver_user_id,
                    'application_sender_user_id' => $data->sender_office_id,
                ]);

                $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
                if ($rtps_data->rtps_trans_id != null) {
                    $response = $this->pfcController->submitApplicationStatus($worker_id);
                    $rtps_response = json_decode($response, true);
                    // dd($rtps_response['status']);
                    // return $rtps_response['status'];
                    if ($rtps_response['status'] == true) {
                        DB::commit();
                        Alert::toast('Application Pulled Successfully', 'success');
                        return redirect()->route('office.dashboard.index')->with('msg', 'Application Pulled Back Successfully');
                    } else {
                        DB::rollBack();
                        Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                        return back();
                    }
                }
                DB::commit();
                Alert::toast('Application Pulled Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Pulled Back Successfully');
            } elseif (Auth::user()->role_id == 2) {
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $worker_id,
                    'ack_no' => $wfm->ack_no,
                    'application_no' => $application_no,
                    'application_status' => env('HEAD_REGISTERING_OFFICER'),
                    'remarks' => $request->remarks,
                    'sender_role_id' => $appdata->role_id,
                    'sender_office_id' => $wfm->office_id,
                    'sender_user_id' => $wfm->application_receiver_user_id,
                    'application_from_user' => $appdata->username,
                    'application_receiver_role_id' => $request->role_id,
                    'application_receiver_user_id' => $wfm->application_sender_user_id,
                    'pull_back' => $request->pull_back,
                    'already_registered' => $onboarding ? 1 : 0,

                ]);
                $workerId = $request->application_id;
                $data = MainWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('HEAD_REGISTERING_OFFICER'),
                    'pull_back' => '1',
                    'application_receiver_user_id' => $data->application_receiver_user_id,
                    'application_sender_user_id' => $data->sender_office_id,
                ]);

                $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
                if ($rtps_data->rtps_trans_id != null) {
                    $response = $this->pfcController->submitApplicationStatus($worker_id);
                    // $rtps_response = json_decode($response, true);
                    // // dd($rtps_response['status']);
                    // // return $rtps_response['status'];
                    // if ($rtps_response['status'] == true) {
                    //     DB::commit();
                    //     Alert::toast('Application Pulled Successfully', 'success');
                    //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Pulled Back Successfully');
                    // } else {
                    //     DB::rollBack();
                    //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                    //     return back();
                    // }
                }
                DB::commit();
                Alert::toast('Application Pulled Back Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Pulled Back Successfully');
            }
        } catch (Exception $e) {
            DB::rollBack();

            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }

    /** Pulling Application Back From DA/RO */
    public function pullBackApplicationRenewal(Request $request)
    {
//        return $request->all();
        $sessionvalue = session()->all();
        $validate = Validator::make($request->all(), [

            'remarks' => 'required|string',
            'role_id' => 'required|exists:pgsql.User.users,role_id',
            'user_id' => 'required|exists:pgsql.User.users,id',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
            'pull_back' => 'required|in:1'
        ]);

        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }


        $usernamedisplay = Auth::user()->username;
        $worker_id = $request->application_id;
        $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $renewal = RenewWorkerForm::where('worker_id', $worker_id)->first();
        $appdata = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $onboarding = $wfm->already_registered == 1;

        $application_no = $wfm->application_no;


        try {
            DB::beginTransaction();
            if (Auth::user()->role_id == 3) {


                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $worker_id,
                    'ack_no' => $renewal->ack_no,
                    'application_no' => $application_no,
                    'application_status' => env('REGISTERING_OFFICER'),
                    'remarks' => $request->remarks,
                    'sender_role_id' => $renewal->application_receiver_role_id,
                    'sender_office_id' => $appdata->office_id,
                    'sender_user_id' => $renewal->application_receiver_user_id,
                    'application_from_user' => $appdata->username,
                    'application_receiver_role_id' => Auth::user()->role_id,
                    'application_receiver_user_id' => Auth::user()->id,
                    'pull_back' => 1,
                    'is_renewal' => 1,
                    'already_registered' => $onboarding ? 1 : 0,
                ]);
                $workerId = $request->application_id;
//                $data = MainWorkerForm::where('worker_id', $workerId)->update([
//                    'status' => env('REGISTERING_OFFICER'),
//                    'pull_back' => '1',
//                    'application_receiver_user_id' => $data->application_receiver_user_id,
//                    'application_sender_user_id' => $data->sender_office_id,
//                ]);
                $dataR = RenewWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('REGISTERING_OFFICER'),
                    'pull_back' => '1',
                    'application_receiver_user_id' => Auth::user()->id,
                    'application_sender_user_id' => $renewal->application_receiver_user_id,
                    'sender_role_id' => $renewal->application_receiver_role_id, //RO Role ID
                    'application_receiver_role_id' =>  Auth::user()->role_id,
                ]);

                $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
//                if ($rtps_data->rtps_trans_id != null) {
//                    $response = $this->pfcController->submitApplicationStatus($worker_id);
//                    $rtps_response = json_decode($response, true);
//                    // dd($rtps_response['status']);
//                    // return $rtps_response['status'];
//                    if ($rtps_response['status'] == true) {
//                        DB::commit();
//                        Alert::toast('Application Pulled Successfully', 'success');
//                        return redirect()->route('office.dashboard.index')->with('msg', 'Application Pulled Back Successfully');
//                    } else {
//                        DB::rollBack();
//                        Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
//                        return back();
//                    }
//                }
                DB::commit();
                Alert::toast('Application Pulled Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Pulled Back Successfully');
            } elseif (Auth::user()->role_id == 2) {
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $worker_id,
                    'ack_no' => $renewal->ack_no,
                    'application_no' => $application_no,
                    'application_status' => env('HEAD_REGISTERING_OFFICER'),
                    'remarks' => $request->remarks,
                    'sender_role_id' => $renewal->application_receiver_role_id,
                    'sender_office_id' => $appdata->office_id,
                    'sender_user_id' => $renewal->application_receiver_user_id,
                    'application_from_user' => $appdata->username,
                    'application_receiver_role_id' => Auth::user()->role_id,
                    'application_receiver_user_id' => Auth::user()->id,
                    'pull_back' => 1,
                    'is_renewal' => 1,
                    'already_registered' => $onboarding ? 1 : 0,
                ]);
                $workerId = $request->application_id;
                $dataR = RenewWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('HEAD_REGISTERING_OFFICER'),
                    'pull_back' => '1',
                    'application_receiver_user_id' => Auth::user()->id,
                    'application_sender_user_id' => $renewal->application_receiver_user_id,
                    'sender_role_id' => $renewal->application_receiver_role_id, //RO Role ID
                    'application_receiver_role_id' =>  Auth::user()->role_id,
                ]);

                $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
                if ($rtps_data->rtps_trans_id != null) {
                    $response = $this->pfcController->submitApplicationStatus($worker_id);
                    // $rtps_response = json_decode($response, true);
                    // // dd($rtps_response['status']);
                    // // return $rtps_response['status'];
                    // if ($rtps_response['status'] == true) {
                    //     DB::commit();
                    //     Alert::toast('Application Pulled Successfully', 'success');
                    //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Pulled Back Successfully');
                    // } else {
                    //     DB::rollBack();
                    //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                    //     return back();
                    // }
                }
                DB::commit();
                Alert::toast('Application Pulled Back Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Pulled Back Successfully');
            }
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }
    ////ReRouting for onboarding
       public function reRouteApplicationOnboarding(Request $request)
       {

           $validate = Validator::make($request->all(), [

              'remarks' => 'required|string',
               'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
               're_route' => 'required|in:1',
               'office_id' => 'required|exists:pgsql.Masterdata.offices,office_id',
               'district_code' => 'required|exists:pgsql.Masterdata.districts,district_code',

           ]);
           if ($validate->fails()) {
               Alert::toast($validate->errors()->first(), 'error');
               return back();
           }
           $usernamedisplay = Auth::user()->username;
           $worker_id = $request->application_id;
           $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
           $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
//           $onboarding = $wfm->already_registered == 1;
           $application_no = $wfm->application_no;

           try {
               DB::beginTransaction();
               $data = WorkerApplicationStatus::Create([
                   'worker_id' => $worker_id,
                   'ack_no' => $wfm->ack_no,
                   'application_no' => $application_no,
                   'application_status' => env('HEAD_REGISTERING_OFFICER'),
                   'remarks' => $request->remarks,
                   'sender_role_id' => Auth::user()->role_id,
                   'sender_office_id' => $data->office_id,
                   'sender_user_id' => $data->id,
                   'application_from_user' => $data->username,
                   'application_receiver_role_id' => $request->role_id,
                   're_route' => 1,
                   're_route_time' => now(),
                   'already_registered' => 1,

               ]);
               $workerId = $request->application_id;
               $data = MainWorkerForm::where('worker_id', $workerId)->update([
                   'status' => env('HEAD_REGISTERING_OFFICER'),
                   'district' => $request->district_code,
                   'office_id' => $request->office_id,
                   're_route' => '1',
                   're_route_time' => now(),
                   'application_receiver_user_id'=>null,
               ]);
                 $dataT = TemporaryWorkerForm::where('worker_id', $workerId)->update([
                   
                   'district' => $request->district_code,
                   'office_id' => $request->office_id,

               ]);
               DB::commit();
               Alert::toast('Application Re Routed Successfully', 'success');
               return redirect()->route('office.dashboard.index')->with('msg', 'Application Re Routed Successfully');
           } catch (Exception $e) {
//               return $e;
               DB::rollBack();

               Alert::toast('Something Went Wrong!', 'error');
               return back();
           }


       }
    public function reRouteApplicationNew(Request $request)
    {

        $validate = Validator::make($request->all(), [

            //            'district_code' => 'required|exists:pgsql.Masterdata.districts,district_code',
            'remarks' => 'required|string',
            'role_id' => 'required|exists:pgsql.User.users,role_id',
            'user_id' => 'required|exists:pgsql.User.users,id',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
            're_route' => 'required|in:1',


        ]);

        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;
        $worker_id = $request->application_id;
        $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();

        $application_no = $wfm->application_no;
        //
        try {
            DB::beginTransaction();
            $data = WorkerApplicationStatus::Create([
                'worker_id' => $worker_id,
                'ack_no' => $wfm->ack_no,
                'application_no' => $application_no,
                'application_status' => env('OFFICE_ADMIN'),
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id,
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id,
                'application_from_user' => $data->username,
                'application_receiver_role_id' => $request->role_id,
                'application_receiver_user_id' => $request->user_id,
                're_route' => '1',
                're_route_time' => now(),

            ]);
            $workerId = $request->application_id;
            $data = MainWorkerForm::where('worker_id', $workerId)->update([
                'status' => env('OFFICE_ADMIN'),
                're_route' => '1',
                're_route_time' => now(),
                'district' => $request->district_code,
                'office_id' => $request->office_id,
                'application_receiver_user_id'=>null,
            ]);

            DB::commit();
            Alert::toast('Application Re-Routed Successfully', 'success');
            return redirect()->route('office.dashboard.index')->with('msg', 'Application Re Routed Successfully');
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }
    public function forwardApplicationFromStateOffice(Request $request)
    {
        //        dd($request->all());
        $validate = Validator::make($request->all(), [

            'district_code' => 'required|exists:pgsql.Masterdata.districts,district_code',
            'remarks' => 'required|string',
            'office_id_r' => 'required|exists:pgsql.Masterdata.offices,office_id',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
            //            're_route' => 'required|in:1',


        ]);

        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;
        $worker_id = $request->application_id;
        $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $onboarding = $wfm->already_registered == 1;
        $application_no = $wfm->application_no;
        //
        try {
            DB::beginTransaction();
            $data = WorkerApplicationStatus::Create([
                'worker_id' => $worker_id,
                'ack_no' => $wfm->ack_no,
                'application_no' => $application_no,
                'application_status' => env('HEAD_REGISTERING_OFFICER'),
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id,
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id,
                'application_from_user' => $data->username,
                'already_registered' => $onboarding ? 1 : 0,


            ]);
            $workerId = $request->application_id;
            $data = MainWorkerForm::where('worker_id', $workerId)->update([
                'status' => env('HEAD_REGISTERING_OFFICER'),
                'district' => $request->district_code,
                'office_id' => $request->office_id_r,
            ]);

            $dataT = TemporaryWorkerForm::where('worker_id', $workerId)->update([
                'district' => $request->district_code,
                'office_id' => $request->office_id_r,
            ]);

            DB::commit();
            Alert::toast('Application Forwarded Successfully', 'success');
            return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded Successfully');
        } catch (Exception $e) {
            // return $e;
            DB::rollBack();
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }

    /** Run this function after 3 days */
    public function scheduleApplication(Request $request)
    {
        //        $sessionvalue = session()->all();
        //        $usernamedisplay = Auth::user()->username;
        //        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        //        $data = WorkerApplicationStatus::Create([
        //            'application_id' => $request->application_id,
        //            'application_status' => env('REGISTERING_OFFICER'),
        //            'remarks' => $request->remarks,
        //            'role_id' => Auth::user()->role_id,
        //            'office_id' => $data->office_id,
        //            'user_id' => $data->id,
        //            'from_user' => $data->username,
        //            'to_user' => $request->role_id,
        //            'pull_back' => $request->pull_back,
        //        ]);
        $threeDaysAgo = Carbon::now()->subDays(3);
        $workers = MainWorkerForm::where('status', 'C')
            ->where('updated_at', '<', $threeDaysAgo)
            ->get();

        $application = $request->application_id;
        $data = MainWorkerForm::where('worker_id', $application)->update([
            'status' => env('REGISTERING_OFFICER'),
        ]);
        return redirect()->route('office.dashboard.index')->with('msg', 'Application Pulled Back Successfully');
    }

    public function revertBackApplication(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'revert_reasons' => 'required|array|min:1',
            'revert_reasons.*' => 'required|exists:pgsql.Masterdata.reasons,id',
            'remarks' => 'required|string',
            'revert_back' => 'required|in:1',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',

        ]);




        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }

        $usernamedisplay = Auth::user()->username;
        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();



        $application = $request->application_id;
        DB::beginTransaction();
        try {

            $main = MainWorkerForm::where('worker_id', $application)->first();
            $isOnboarding = $main->already_registered == 1;
            $main_basic = MainWorkerBasicDetail::where('worker_id', $application)->first();
            $main_address = MainWorkerAddress::where('worker_id', $application)->first();
            $main_bank = MainWorkerBank::where('worker_id', $application)->first();
            $main_certificate = MainWorkerCertificate::where('worker_id', $application)
                ->get();
            $main_document = MainWorkerDocument::where('worker_id', $application)->first();
            $main_family = MainWorkerFamily::where('worker_id', $application)->get();
            $main_scheme = MainWorkerScheme::where('worker_id', $application)->get();
            $main_vault = MainVaultData::where('worker_id', $application)->first();

            $data = WorkerApplicationStatus::Create([

                'worker_id' => $application,
                'application_no' => $main->application_no,
                'ack_no' => $main->ack_no,
                'application_status' => env('APPLICATION_REVERTED'),
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id,
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id,
                'application_from_user' => $data->username,
                'revert_back' => $request->revert_back,
                'reasons' => implode(',', $request->revert_reasons),
                'already_registered' => $isOnboarding ? 1 : 0,

            ]);

            $data = RevertBack::create([
                'worker_id' => $application,
                'office_id' => $main->office_id,
                'phone_no' => $main->phone_no,
                'district' => $main->district,
                'application_no' => $main->application_no,
                'already_registered' => $main->already_registered,
                'ack_no' => $main->ack_no,
                'status' => env('APPLICATION_REVERTED'),
                'active_status' => $main->active_status,
                'payment_status' => $main->payment_status,
                'vaultToken' => $main->vaultToken,
                'vaultPassKey' => $main->vaultPassKey,
                'id_card_created_at' => $main->id_card_created_at,
                'application_type' => $main->application_type,
                'reasons' => $data->reasons,
            ]);
            $rtps_data = MainWorkerForm::where('worker_id', $application)->first();


            optional($main)->delete();
            optional(MainWorkerBasicDetail::where('worker_id', $application)->first())->delete();
            optional(MainWorkerAddress::where('worker_id', $application)->first())->delete();
            optional(MainWorkerBank::where('worker_id', $application)->first())->delete();
            optional(MainWorkerDocument::where('worker_id', $application)->first())->delete();
            optional(MainVaultData::where('worker_id', $application)->first())->delete();
            MainWorkerCertificate::where('worker_id', $application)->delete();
            MainWorkerFamily::where('worker_id', $application)->delete();
            MainWorkerScheme::where('worker_id', $application)->delete();

            $phoneNumber = $data->phone_no;
            $application_no = $data->ack_no;
            $remarks = 'Re Submit';


// return $rtps_data;
            // if ($rtps_data->rtps_trans_id != null) {
            //     $response_data = $this->pfcController->submitApplicationStatus($application);
            //     $rtps_response = json_decode($response_data, true);
            //     // DB::rollBack();
            //     dd($rtps_response);
            //     // return $rtps_response['status'];
            //     if ($rtps_response['status'] == true) {
            //         DB::commit();
            //         $response = $this->smsService->applicationRevertedSMS($phoneNumber, $application_no, $remarks);


            //         if ($response === false) {
            //             return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
            //         } else {
            //             Alert::toast('Application Revert Back Successfully', 'success');
            //             return redirect()->route('office.dashboard.index')->with('msg', 'Application Reverted');
            //         }
            //     } else {
            //         DB::rollBack();
            //         Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
            //         return back();
            //     }
            // }
            DB::commit();
            $response = $this->smsService->applicationRevertedSMS($phoneNumber, $application_no, $remarks);

            if ($response === false) {
                return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
            } else {
                Alert::toast('Application Revert Back Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Reverted');
            }
        } catch (Exception $e) {
            // return $e;
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function revertRenewalApp(Request $request)
    {


        $validate = Validator::make($request->all(), [
            'revert_reasons' => 'required|array|min:1',
            'revert_reasons.*' => 'required|exists:pgsql.Masterdata.reasons,id',
            'remarks' => 'required|string',
            'revert_back' => 'required|in:1',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',

        ]);

        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }

        $usernamedisplay = Auth::user()->username;
        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $application = $request->application_id;
        $renewal = RenewWorkerForm::where('worker_id', $application)->first();
        $onboarding = $renewal->already_registered == 1;
        DB::beginTransaction();
        try{

            $status = WorkerApplicationStatus::Create([

                'worker_id' => $application,
                'application_no' => $renewal->application_no,
                'ack_no' => $renewal->ack_no,
                'application_status' => env('APPLICATION_REVERTED'),
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id,
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id,
                'application_from_user' => $data->username,
                'revert_back' => $request->revert_back,
                'reasons' => implode(',', $request->revert_reasons),
                'is_renewal' => '1',
                'already_registered' => $onboarding ? 1: 0,

            ]);

            $data = RevertBack::create([
                'worker_id' => $application,
                'office_id' => $renewal->office_id,
                'phone_no' => $renewal->phone_no,
                'district' => $renewal->district,
                'application_no' => $renewal->application_no,
                'already_registered' => $renewal->already_registered,
                'ack_no' => $renewal->ack_no,
                'status' => env('APPLICATION_REVERTED'),
                'active_status' => $renewal->active_status,
                'payment_status' => $renewal->payment_status,
                'vaultToken' => $renewal->vaultToken,
                'vaultPassKey' => $renewal->vaultPassKey,
                'id_card_created_at' => $renewal->id_card_created_at,
                'application_type' => $renewal->application_type,
                'reasons' => $status->reasons,
            ]);

            $data1 = RenewWorkerForm::where('worker_id',$application)->update([

                'application_receiver_user_id' => Auth::user()->id,
                'status' => env('APPLICATION_REVERTED'),
                'application_sender_user_id' => Auth::user()->id,
                'sender_role_id'=> Auth::user()->role_id,
                'revert_back' => '1'
            ]);
            DB::commit();
            $phoneNumber = $data->phone_no;
            $application_no = $data->ack_no;
            $remarks = 'Re Submit';
            $response = $this->smsService->renewalApplicationRevertedSMS($phoneNumber, $application_no, $remarks);

            if ($response === false) {
                return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
            } else {
                Alert::toast('Application Revert Back Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Reverted');
            }

        } catch (Exception $e)
        {
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }


    /** Send Bulk application */
    public function sendApplications(Request $request)
    {


        $validate = Validator::make($request->all(), [
            'num_applications' => 'required|integer|min:1',
            'receiver_role_id' => 'required|exists:pgsql.User.users,role_id',
            'user_id' => 'required|exists:pgsql.User.users,id',
            'remarks' => 'required|string',


        ], [
            'remarks.required' => 'Remarks field is required.',


            'user_id.required' => 'User Name is required.',
            'user_id.exists' => 'The selected User Name does not exist.',

            'receiver_role_id.required' => 'Receiver Role Name is required.',
            'receiver_role_id.exists' => 'The selected Receiver Role Name does not exist.',

            'num_applications.required' => 'Number of applications is required.',
            'num_applications.integer' => 'Number of applications must be an integer.',
            'num_applications.min' => 'Number of applications must be at least 1.'
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => $validate->errors()->first()]);
        }
        $usernamedisplay = Auth::user()->username;
        $data = Auth::user();

        $numApplications = (int)$request->input('num_applications');
        if (Auth::user()->role_id == 2) {
            if ($request->type == 1) {
                $applications = MainWorkerForm::where('office_id', $data->office_id)
                    ->where('status', 'A')
                    ->where('payment_status', 'success')
                    ->where('already_registered', null)
                    ->where('da_forward', null)
                    ->where('resubmit_status', 0)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->get();

                $noOfApplications =  MainWorkerForm::where('office_id', $data->office_id)
                    ->where('status', 'A')
                    ->where('payment_status', 'success')
                    ->where('already_registered', null)
                    ->where('da_forward', null)
                    ->where('resubmit_status', 0)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->count();
            } elseif ($request->type == 2) {
                $applications = MainWorkerForm::where('office_id', $data->office_id)
                    ->where('status', 'A')
                    ->where('payment_status', 'success')
                    ->where('already_registered', 1)
                    ->where('da_forward', null)
                    ->where('resubmit_status', 0)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->get();

                $noOfApplications =  MainWorkerForm::where('office_id', $data->office_id)
                    ->where('status', 'A')
                    ->where('payment_status', 'success')
                    ->where('da_forward', null)
                    ->where('already_registered', 1)
                    ->where('resubmit_status', 0)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->count();
            } elseif ($request->type == 3) {
                $applications = MainWorkerForm::where('office_id', $data->office_id)
                    ->where('status', 'A')
                    ->where('payment_status', 'success')
                    ->where('resubmit_status', 1)
                    ->where('da_forward', null)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->get();

                $noOfApplications =  MainWorkerForm::where('office_id', $data->office_id)
                    ->where('status', 'A')
                    ->where('payment_status', 'success')
                    ->where('resubmit_status', 1)
                    ->where('da_forward', null)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->count();
            }elseif($request->type == 4)
            {
                $applications = RenewWorkerForm::where('office_id', $data->office_id)
                    ->where('status', 'A')
                    ->where('payment_status', 'success')
                    ->where('da_forward', null)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->get();

                $noOfApplications =  RenewWorkerForm::where('office_id', $data->office_id)
                    ->where('status', 'A')
                    ->where('payment_status', 'success')
                    ->where('da_forward', null)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->count();
            }
        } elseif (Auth::user()->role_id == 3) {


            if ($request->type == 1) {
                $applications = MainWorkerForm::where('office_id', $data->office_id)
                    ->where('application_receiver_user_id', Auth::user()->id)
                    ->where('status', 'O')
                    ->where('payment_status', 'success')
                    ->where('already_registered', null)
                    ->where('da_forward', null)
                    ->where('resubmit_status', 0)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->get();

                $noOfApplications =  MainWorkerForm::where('office_id', $data->office_id)
                    ->where('application_receiver_user_id', Auth::user()->id)
                    ->where('status', 'O')
                    ->where('payment_status', 'success')
                    ->where('already_registered', null)
                    ->where('da_forward', null)
                    ->where('resubmit_status', 0)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->count();
            } elseif ($request->type == 2) {
                $applications = MainWorkerForm::where('office_id', $data->office_id)
                    ->where('application_receiver_user_id', Auth::user()->id)
                    ->where('status', 'O')
                    ->where('payment_status', 'success')
                    ->where('already_registered', 1)
                    ->where('da_forward', null)
                    ->where('resubmit_status', 0)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->get();

                $noOfApplications =  MainWorkerForm::where('office_id', $data->office_id)
                    ->where('application_receiver_user_id', Auth::user()->id)
                    ->where('status', 'O')
                    ->where('payment_status', 'success')
                    ->where('already_registered', 1)
                    ->where('resubmit_status', 0)
                    ->where('da_forward', null)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->count();
            } elseif ($request->type == 3) {
                $applications = MainWorkerForm::where('office_id', $data->office_id)
                    ->where('application_receiver_user_id', Auth::user()->id)
                    ->where('status', 'O')
                    ->where('payment_status', 'success')
                    ->where('resubmit_status', 1)
                    ->where('da_forward', null)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->get();

                $noOfApplications =  MainWorkerForm::where('office_id', $data->office_id)
                    ->where('application_receiver_user_id', Auth::user()->id)
                    ->where('status', 'A')
                    ->where('payment_status', 'success')
                    ->where('resubmit_status', 1)
                    ->where('da_forward', null)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->count();
            }
            elseif($request->type == 4)
            {
                $applications = RenewWorkerForm::where('office_id', $data->office_id)
                    ->where('application_receiver_user_id', Auth::user()->id)
                    ->where('status', 'O')
                    ->where('payment_status', 'success')
                    ->where('da_forward', null)
                    ->limit($numApplications)
                    ->get();


            $noOfApplications =  RenewWorkerForm::where('office_id', $data->office_id)
                    ->where('status', 'O')
                    ->where('da_forward', null)
                    ->orderBy('created_at', 'asc')
                    ->limit($numApplications)
                    ->count();
            }
        }

        if ($numApplications > $noOfApplications) {
            return response()->json(['status' => false, 'message' => 'Total Applications are less than selected number']);
        }

        if ($applications->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No applications available to process']);
        }



        DB::beginTransaction();

        try {
            foreach ($applications as $wfm) {
                $worker_id = $wfm->worker_id;
                $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
                $isRenewal = false;
                if (RenewWorkerForm::where('worker_id',$worker_id)->exists())
                {
                    $isRenewal = true;
                }

                $onboarding = $wfm->already_registered == 1;


                if ($wfm) {
                    $isRenewal = $wfm->is_renewal == 1;
                    if (Auth::user()->role_id == 2) {
                        if ($request->receiver_role_id == 3) {
                            $status = WorkerApplicationStatus::create([
                                'worker_id' => $worker_id,
                                'application_no' => $wfm->application_no,
                                'ack_no' => $wfm->ack_no,
                                'application_status' => env('REGISTERING_OFFICER'),
                                'remarks' => $request->remarks,
                                'sender_role_id' => Auth::user()->role_id, //RO Role ID
                                'sender_office_id' => $data->office_id,
                                'sender_user_id' => $data->id, //Ro user id
                                'application_from_user' => $data->username,
                                'application_receiver_user_id' => $request->user_id,
                                'application_receiver_role_id' => $request->receiver_role_id,
                                'is_renewal' => $isRenewal ? 1 : 0,
                                'already_registered' => $onboarding ? 1 : 0,
                            ]);


                            if ($isRenewal) {

                                RenewWorkerForm::where('worker_id', $worker_id)->update([
                                    'status' => env('REGISTERING_OFFICER'),
                                    'application_receiver_user_id' => $status->application_receiver_user_id,
                                    'application_sender_user_id' => $status->sender_user_id,

                                ]);

                            }else{

                                MainWorkerForm::where('worker_id', $worker_id)->update([
                                    'status' => env('REGISTERING_OFFICER'),
                                    'application_receiver_user_id' => $status->application_receiver_user_id,
                                    'application_sender_user_id' => $status->sender_user_id,

                                ]);
                            }


                        } elseif ($request->receiver_role_id == 4) {
                            $status = WorkerApplicationStatus::create([
                                'worker_id' => $worker_id,
                                'application_no' => $wfm->application_no,
                                'ack_no' => $wfm->ack_no,
                                'application_status' => env('DEALING_ASSISTANT'),
                                'remarks' => $request->remarks,
                                'sender_role_id' => Auth::user()->role_id, //RO Role ID
                                'sender_office_id' => $data->office_id,
                                'sender_user_id' => $data->id, //Ro user id
                                'application_from_user' => $data->username,
                                'application_receiver_user_id' => $request->user_id,
                                'application_receiver_role_id' => $request->receiver_role_id,
                                'is_renewal' => $isRenewal ? 1 : 0,
                                'already_registered' => $onboarding ? 1 : 0,
                            ]);
                            if ($isRenewal) {


                                RenewWorkerForm::where('worker_id', $worker_id)->update([

                                    'status' => env('DEALING_ASSISTANT'),
                                    'application_receiver_user_id' => $status->application_receiver_user_id,
                                    'application_sender_user_id' => $status->sender_user_id,

                                ]);

                            }else{

                                MainWorkerForm::where('worker_id', $worker_id)->update([
                                    'status' => env('DEALING_ASSISTANT'),
                                    'application_receiver_user_id' => $status->application_receiver_user_id,
                                    'application_sender_user_id' => $status->sender_user_id,

                                ]);
                            }


                        }

                    } elseif (Auth::user()->role_id == 3) {
                        $status = WorkerApplicationStatus::create([
                            'worker_id' => $worker_id,
                            'application_no' => $wfm->application_no,
                            'ack_no' => $wfm->ack_no,
                            'application_status' => env('DEALING_ASSISTANT'),
                            'remarks' => $request->remarks,
                            'sender_role_id' => Auth::user()->role_id, //RO Role ID
                            'sender_office_id' => $data->office_id,
                            'sender_user_id' => $data->id, //Ro user id
                            'application_from_user' => $data->username,
                            'application_receiver_user_id' => $request->user_id,
                            'application_receiver_role_id' => $request->receiver_role_id,
                            'forward_to_da' => now(),
                            'is_renewal' => $isRenewal ? 1 : 0,
                            'already_registered' => $onboarding ? 1 : 0,
                        ]);

                        if ($isRenewal) {

                            RenewWorkerForm::where('worker_id', $worker_id)->update([

                                'status' => env('DEALING_ASSISTANT'),
                                'application_receiver_user_id' => $status->application_receiver_user_id,
                                'application_sender_user_id' => $status->sender_user_id,
                                'forward_to_da' => now(),

                            ]);

                        }else{

                            MainWorkerForm::where('worker_id', $worker_id)->update([
                                'status' => env('DEALING_ASSISTANT'),
                                'application_receiver_user_id' => $status->application_receiver_user_id,
                                'application_sender_user_id' => $status->sender_user_id,
                                'forward_to_da' => now(),

                            ]);
                        }


                    }
                } else {
                    Log::warning("Worker main form not found for worker_id: {$worker_id}");
                }
            }

            DB::commit();

            return response()->json(['status' => true, 'message' => 'Applications Forwarded Successfully']);
        } catch (\Exception $e) {
            // return $e;
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public  function forwardHDA(Request $request)
    {

        $validate = Validator::make($request->all(), [

            'remarks' => 'required|string',
            'role_id' => 'required|exists:pgsql.User.users,role_id',
            'user_id' => 'required|exists:pgsql.User.users,id',
            'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id'
        ]);
        if ($validate->fails()) {
            Alert::toast($validate->errors()->first(), 'error');
            return back();
        }
        $usernamedisplay = Auth::user()->username;
        $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $worker_id = $request->application_id;
        $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $application_no = $wfm->application_no;

        try {
            DB::beginTransaction();
            $data = WorkerApplicationStatus::Create([
                'worker_id' => $worker_id,
                'application_no' => $application_no,
                'application_status' => env('HEAD_OFFICE_DA'),
                'ack_no' => $wfm->ack_no,
                'remarks' => $request->remarks,
                'sender_role_id' => Auth::user()->role_id,
                'sender_office_id' => $data->office_id,
                'sender_user_id' => $data->id,
                'application_from_user' => $data->username,
                'application_receiver_user_id'=> $request->user_id,
                'application_receiver_role_id' => $request->role_id,
            ]);

            $workerId = $request->application_id;
            $data = MainWorkerForm::where('worker_id', $workerId)->update([
                'status' => env('HEAD_OFFICE_DA'),
                'application_receiver_user_id'=> $data->user_id,
                'application_sender_user_id' => $data->id,
//                'da_forward' => 1,
            ]);

            $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
            if ($rtps_data->rtps_trans_id != null) {
                $response = $this->pfcController->submitApplicationStatus($worker_id);
                // $rtps_response = json_decode($response, true);
                // // dd($rtps_response['status']);
                // // return $rtps_response['status'];
                // if ($rtps_response['status'] == true) {
                //     DB::commit();
                //     Alert::toast('Application Forwarded Successfully', 'success');
                //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded to RO Successfully');
                // } else {
                //     DB::rollBack();
                //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                //     return back();
                // }
            }
            DB::commit();
            Alert::toast('Application Forwarded Successfully', 'success');
            return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded to RO Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast('Something Went Wrong!', 'error');
            return back();
        }
    }

        public function forwardDaHo(Request $request)
        {
            $validate = Validator::make($request->all(), [

                'remarks' => 'required|string',
                'role_id' => 'required|exists:pgsql.User.users,role_id',
                'user_id' => 'required|exists:pgsql.User.users,id',
                'application_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id'
            ]);
            if ($validate->fails()) {
                Alert::toast($validate->errors()->first(), 'error');
                return back();
            }
            $usernamedisplay = Auth::user()->username;
            $data = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
            $worker_id = $request->application_id;
            $wfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
            $application_no = $wfm->application_no;

            try {
                DB::beginTransaction();
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $worker_id,
                    'application_no' => $application_no,
                    'application_status' => env('OFFICE_ADMIN'),
                    'ack_no' => $wfm->ack_no,
                    'remarks' => $request->remarks,
                    'sender_role_id' => Auth::user()->role_id,
                    'sender_office_id' => $data->office_id,
                    'sender_user_id' => $data->id,
                    'application_from_user' => $data->username,
                    'application_receiver_user_id'=> $request->user_id,
                    'application_receiver_role_id' => $request->role_id,
                ]);

                $workerId = $request->application_id;
                $data = MainWorkerForm::where('worker_id', $workerId)->update([
                    'status' => env('OFFICE_ADMIN'),
                    'application_receiver_user_id'=> $data->user_id,
                    'application_sender_user_id' => $data->id,
                    'da_forward' => 1,
                ]);

                $rtps_data = MainWorkerForm::where('worker_id', $worker_id)->first();
                if ($rtps_data->rtps_trans_id != null) {
                    $response = $this->pfcController->submitApplicationStatus($worker_id);
                    // $rtps_response = json_decode($response, true);
                    // // dd($rtps_response['status']);
                    // // return $rtps_response['status'];
                    // if ($rtps_response['status'] == true) {
                    //     DB::commit();
                    //     Alert::toast('Application Forwarded Successfully', 'success');
                    //     return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded to RO Successfully');
                    // } else {
                    //     DB::rollBack();
                    //     Alert::toast($rtps_response['message'] . ' in Sewasetu', 'error');
                    //     return back();
                    // }
                }
                DB::commit();
                Alert::toast('Application Forwarded Successfully', 'success');
                return redirect()->route('office.dashboard.index')->with('msg', 'Application Forwarded to RO Successfully');
            } catch (Exception $e) {
                DB::rollBack();
                Alert::toast('Something Went Wrong!', 'error');
                return back();
            }
        }


}
