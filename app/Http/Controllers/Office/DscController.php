<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Worker\AuthOtpController;
use App\Models\DscRegistration;
use App\Models\MainWorkerDocument;
use App\Models\MainWorkerAddress;
use App\Models\MainWorkerForm;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerCertificate;
use App\Models\Profession;
use App\Models\RenewWorkerForm;
use App\Models\User;
use App\Models\WorkerApplicationStatus;
use App\Models\WorkerIDCard;
use App\Services\AesCipher;
use App\Services\SmsGatewayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\GetVaultDataService;
use App\Services\GetVaultDataBulkMode;
// use Knp\Snappy\Pdf;

use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\WorkerIDCardHistory;

class DscController extends Controller
{

    protected $smsService;
    protected $AuthOtpController;
    protected $getVaultDataService;
    protected $getVaultDataBulkMode;
    /**
     * @var AesCipher
     */


    public function __construct(SmsGatewayService $smsService, AuthOtpController $AuthOtpController, GetVaultDataService $getVaultDataService, GetVaultDataBulkMode $getVaultDataBulkMode)
    {
        $this->middleware('permission:digital signature', ['only' => ['index', 'applicationsToSign', 'register', 'eSign', 'idCard', 'qrCode', 'signedId', 'getPdfString']]);
        $this->middleware('permission:dsc registration', ['only' => ['index', 'register']]);
        $this->middleware('permission:sign application', ['only' => ['applicationsToSign']]);
        $this->smsService = $smsService;
        $this->AuthOtpController = $AuthOtpController;
        $this->getVaultDataService = $getVaultDataService;
        $this->getVaultDataBulkMode = $getVaultDataBulkMode;
    }




    public function index()
    {
        return view('office.dsc-registration.registration');
    }


    public function iframe()
    {
        return view('office.dsc-registration.iframe-view');
    }


    public function register(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make(
            $request->all(),
            [
                'cname' => 'required',
                'serialNum' => 'required',
                'validFrom' => 'required',
                'validTo' => 'required',
                'cert' => 'required',
                'sts' => 'required',
                'pan' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }

        try {

            if ($request->sts == "ACTIVE") {
                $status = true;
            } else {
                $status = false;
            }
            $count = DscRegistration::where('user_id', Auth::user()->id)->count();

            if ($count > 0) {
                $data = DscRegistration::where('user_id', Auth::user()->id)->first();
            } else {
                $data = new DscRegistration();
            }


            $data->user_id = Auth::user()->id;
            $data->name = $request->cname;
            $data->seriel_number = $request->serialNum;
            $data->valid_from = $request->validFrom;
            $data->valid_to = $request->validTo;
            $data->certificate = $request->cert;
            $data->status = $status;
            $data->pan = $request->pan;
            $data->save();

            return response()->json([
                'status' => true,
                'results' => "Data Updated!"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }


    public function applicationsToSign()
    {
        $certificate_count = DscRegistration::where('user_id', Auth::user()->id)->first();
        if (!$certificate_count) {
            Alert::toast('Register your Token First', 'error');
            return view('office.dsc-registration.registration');
        }

        $renewApplications = collect([]);
        $mainApplications = collect([]);

        if (RenewWorkerForm::count()>0)
        {
            $renewApplications = RenewWorkerForm::where('status', 'F')
                ->where('office_id', Auth::user()->office_id)
                ->where('application_sender_user_id', Auth::user()->id)
                ->get();

        }



        $mainApplications = MainWorkerForm::where('status', 'F')
            ->where('office_id', Auth::user()->office_id)
            ->where('application_receiver_user_id', Auth::user()->id)
            ->get();

        $applications = $renewApplications->merge($mainApplications);
        $workerIds = $applications->pluck('worker_id')->toArray();
        $vaultData = [];
        $professions = [];

        if (!empty($workerIds)) {

            $vaultData = $this->getVaultDataBulkMode->getBulkVaultData($workerIds);

            $basicDetails = MainWorkerBasicDetail::whereIn('worker_id', $workerIds)
                ->select('worker_id', 'profession', 'profession_others')
                ->leftJoin('Masterdata.professions', 'Worker.main_worker_basic_details.profession', '=', 'Masterdata.professions.profession_code')
                ->addSelect('Masterdata.professions.profession_name')
                ->get()
                ->keyBy('worker_id');

            $certificateDetails = MainWorkerCertificate::whereIn('worker_id', $workerIds)
                ->select('worker_id', 'profession', 'profession_others')
                ->leftJoin('Masterdata.professions', 'Worker.main_worker_certificates.profession', '=', 'Masterdata.professions.profession_code')
                ->addSelect('Masterdata.professions.profession_name')
                ->get()
                ->keyBy('worker_id');


            foreach ($workerIds as $workerId) {

                $basic = $basicDetails[$workerId] ?? null;
                $cert  = $certificateDetails[$workerId] ?? null;

                $basicProfession = $basic
                    ? ($basic->profession_others ?: ($basic->profession_name ?: $basic->profession))
                    : null;

                $certProfession = $cert
                    ? ($cert->profession_others ?: ($cert->profession_name ?: $cert->profession))
                    : null;

                // 🔥 FINAL DECISION
                $professions[$workerId] = $basicProfession ?: $certProfession ?: null;
            }
        }

        session()->put('route', 1);
        return view('office.dsc-registration.applications', compact('applications', 'vaultData', 'professions'));
    }


    public function eSign($application_id)
    {
        $id = decrypt($application_id);
        $worker = MainWorkerForm::where('worker_id', $id)->first();

        // 1. Get the latest signature record for this worker
        $lastSignature = WorkerIDCard::where('worker_id', $id)
            ->orderBy('id_card_status', 'desc')
            ->first();

        $isRenewal = ($worker->is_renewal == '1');
        $alreadySigned = false;

        if (!$isRenewal) {
            // For Registration: We only care about status 0
            if ($lastSignature && $lastSignature->id_card_status == 0 && $lastSignature->signature_status == 1) {
                $alreadySigned = true;
            }
        } else {
            // For Renewal: Get the current renewal application submission date
            $currentApp = RenewWorkerForm::where('worker_id', $id)->latest()->first();

            if ($lastSignature && $currentApp) {
                // If the latest signature was uploaded AFTER the current application was submitted,
                // it means this specific renewal has already been signed.
                if (Carbon::parse($lastSignature->certificate_upload_date)->gt($currentApp->created_at)) {
                    $alreadySigned = true;
                }
            }
        }

        if ($alreadySigned) {
            session()->put('worker_id', $id);
            Alert::success("ID Card Signed");

            if (session()->has('route')) {
                if (session()->get('route') == 1) {
                    return redirect()->route('office.dsc.applications');
                }
                return ($isRenewal)
                    ? redirect()->route('office.applications.preview-applications', encrypt($id))
                    : redirect()->route('office.applications.preview', encrypt($id));
            }
        }

        // If not signed, show the signing view
        return view('office.dsc-registration.e-sign-id.index', compact('id'));
    }

    public function idCard($id)
    {
        try {
            $userDetails = Auth::user();
            $workerId = decrypt($id);
            $office_id = Auth::user()->office_id;
            $designation_id = Auth::user()->designation_id;



            $vaultData = $this->getVaultDataService->getVaultData($workerId, "M");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);


            $data['simple'] = QrCode::size(100)->generate(route('home.qrCode', ['id' => $id]));
            $data['user'] = MainWorkerForm::where('worker_id', $workerId)->first();
            if ($data['user']->already_registered == 1) {
                $today = Carbon::today();
                $data['today'] = $today->format('Y-m-d');
                $data['card_validity_date'] = $data['user']->id_card_expiry_date;
                $data['renewal_date'] = Carbon::parse($today)->addYears(2)->format('Y-m-d');
                $data['last_reg_date'] = Carbon::parse($data['user']->last_registration_date)->format('Y-m-d');
                $data['formatted_date'] = Carbon::parse($data['card_validity_date'])->format('Y-m-d');
                $data['profession_already'] = DB::table('Worker.temporary_worker_basic_details as mwc')
                    ->leftJoin('Masterdata.professions as pro', 'mwc.profession', '=', 'pro.profession_code')
                    ->where('mwc.worker_id', $workerId)
                    ->select(
                        'mwc.profession',
                        'mwc.profession_others',
                        'pro.*'
                    )
                    ->first();

            } else {
                $today = Carbon::today();
                $data['card_validity_date'] = Carbon::parse($today)->subDay()->addYears(2);
                $data['renewal_date'] = Carbon::parse($today)->addYears(2)->format('Y-m-d');
                $data['formatted_date'] = $data['card_validity_date']->format('Y-m-d');
                $data['today'] = $today->format('Y-m-d');
                $data['profession'] = DB::table('Worker.main_worker_certificates as mwc')
                    ->leftJoin('Masterdata.professions as pro', 'mwc.profession', '=', 'pro.profession_code')
                    ->where('mwc.worker_id', $workerId)
                    ->select(
                        'mwc.profession',
                        'pro.*'
                    )->first();
            }

            // return $data['user'];
            $data['emblem'] = public_path('/assets/template/images/emblem-dark.png');
            $data['flag'] = public_path('/assets/template/images/flag3.png');
            $data['logo'] = public_path('assets/template/images/bocw-1.png');

            //            $data['add'] = MainworkerAddress::where('worker_id', $workerId)->first();

            $data['add'] = DB::table('Worker.main_worker_addresses as mwa')
                ->leftJoin('Masterdata.districts as ds', DB::raw('mwa.c_district::BIGINT'), '=', 'ds.district_code')
                ->where('mwa.worker_id', $workerId)
                ->select('mwa.*', 'ds.*')
                ->first();
            $data['base64Image'] = $data['getVaultData']['photo'];

            $options = [
                'encoding' => 'utf-8',
                'enable-local-file-access' => true,
                'enable-javascript' => false,
            ];






            $html = view('office.dsc-registration.e-sign-id.id-card', $data)->render();
            $pdfContent =  Pdf::loadHTML($html)
                ->setOptions($options)
                ->output();
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="id-card.pdf"',
            ]);
        } catch (Exception $e) {
//            return $e;
            return back();
        }
    }

    public function getPdfString(Request $request)
    {
        try {
            $workerId = $request->id;
            $vaultData = $this->getVaultDataService->getVaultData($workerId, "F");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);

            $data['simple'] = QrCode::size(100)->generate(route('home.qrCode', ['id' => encrypt($workerId)]));
            $data['user'] = MainWorkerForm::where('worker_id', $workerId)->first();
            $data['emblem'] = public_path('/assets/template/images/emblem-dark.png');
            $data['logo'] = public_path('assets/template/images/bocw.png');
            $data['add'] = MainworkerAddress::where('worker_id', $workerId)->first();
            $data['base64Image'] = $data['getVaultData']['photo'];
            $data['flag'] = public_path('/assets/template/images/flag3.png');


            if ($data['user']->already_registered == 1) {
                $today = Carbon::today();
                $data['today'] = $today->format('Y-m-d');
                $data['card_validity_date'] = $data['user']->id_card_expiry_date;
                $data['renewal_date'] = Carbon::parse($today)->addYears(2)->format('Y-m-d');
                $data['last_reg_date'] = Carbon::parse($data['user']->last_registration_date)->format('Y-m-d');
                $data['formatted_date'] = Carbon::parse($data['card_validity_date'])->format('Y-m-d');
                $data['profession_already'] = DB::table('Worker.temporary_worker_basic_details as mwc')
                    ->leftJoin('Masterdata.professions as pro', 'mwc.profession', '=', 'pro.profession_code')
                    ->where('mwc.worker_id', $workerId)
                    ->select(
                        'mwc.profession',
                        'mwc.profession_others',
                        'pro.*'
                    )
                    ->first();

            } else {
                $today = Carbon::today();
                $data['card_validity_date'] = Carbon::parse($today)->subDay()->addYears(2);
                $data['renewal_date'] = Carbon::parse($today)->addYears(2)->format('Y-m-d');
                $data['formatted_date'] = $data['card_validity_date']->format('Y-m-d');
                $data['today'] = $today->format('Y-m-d');
                $data['profession'] = DB::table('Worker.main_worker_certificates as mwc')
                    ->leftJoin('Masterdata.professions as pro', 'mwc.profession', '=', 'pro.profession_code')
                    ->where('mwc.worker_id', $workerId)
                    ->select(
                        'mwc.profession',
                        'pro.*'
                    )->first();
            }



            $html = view('office.dsc-registration.e-sign-id.id-card', $data)->render();
            $options = [
                'encoding' => 'utf-8',
                'enable-local-file-access' => true,
                'enable-javascript' => false,
            ];

            $pdfOutput =  Pdf::loadHTML($html)
                ->setOptions($options)
                ->output();

            $pdfBase64 = base64_encode($pdfOutput);

            return response()->json([
                'status' => true,
                'string' => $pdfBase64
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function signedId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'string' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'results' => $validator->errors()->first()]);
        }

        try {
            DB::beginTransaction();
            $user = Auth::user();
             $idCard = MainWorkerForm::where('worker_id', $request->id)->first();

            // 1. Calculate the next id_card_status (version)
            $maxStatus = WorkerIDCard::where('worker_id', $request->id)->max('id_card_status');

            if ($idCard->is_renewal == '0') {
                $newStatus = 0; // Fresh Registration
            } else {
                // For renewal, if a registration (0) or previous renewal (1) exists,
                // increment the number for the new record.
                $newStatus = (is_null($maxStatus)) ? 1 : $maxStatus + 1;
            }

            // 2. Always create a NEW record for every signature cycle
            $id_card_data = new WorkerIDCard();
            $id_card_data->worker_id = $request->id;
            $id_card_data->id_card_status = $newStatus;
            $id_card_data->signature_status = 1;
            $id_card_data->certificate = $request->string;
            $id_card_data->certificate_upload_date = Carbon::now();
            $id_card_data->save();

            /*
            |--------------------------------------------------------------------------
            | APPLICATION UPDATES (Your existing logic)
            |--------------------------------------------------------------------------
            */
            $onboarding = $idCard->already_registered;

            if ($idCard->is_renewal == '1') {
                $idCardN = RenewWorkerForm::where('worker_id', $request->id)->latest()->firstOrFail();
                $oldUsername = $idCard->id_card;
                $newUsername = $idCardN->id_card;

                // User management logic (Update phone/office or Create new user if ID changed)
                if ($oldUsername === $newUsername) {
                    User::where('username', $oldUsername)->update([
                        'phone' => $idCardN->phone_no,
                        'office_id' => $idCardN->office_id,
                        'status' => 1
                    ]);
                } else {
                    User::where('username', $oldUsername)->update(['status' => 0]);
                    User::firstOrCreate(['username' => $newUsername], [
                        'password' => Hash::make($request->id),
                        'phone' => $idCardN->phone_no,
                        'role_id' => 6,
                        'status' => 1,
                        'office_id' => $idCardN->office_id,
                        'password_change_first_attempt' => true
                    ]);
                }

                // Update application status
                $idCardN->update([
                    'status' => env('APPLICATION_FINAL_APPROVED'),
                    'application_sender_user_id' => $user->id
                ]);

                $idCard->update([
                    'active_status' => 0,
                    'id_card' => $newUsername,
                ]);

                WorkerApplicationStatus::create([
                    'worker_id' => $request->id,
                    'ack_no' => $idCardN->ack_no,
                    'application_no' => $idCardN->application_no,
                    'application_status' => env('APPLICATION_FINAL_APPROVED'),
                    'remarks' => 'Renewal Application Approved',
                    'sender_role_id' => $user->role_id,
                    'sender_office_id' => $user->office_id,
                    'sender_user_id' => $user->id,
                    'is_renewal' => 1,
                    'ro_approval_time' => now(),
                ]);

                $this->smsService->renewalApplicationApprovedSMS($idCardN->phone_no, $idCardN->ack_no, $idCardN->id_card);
            } else {
                // New Registration Logic... (Keeping your existing User creation and Status update code)
                // [ ... Insert your existing registration logic here ... ]
                if ($idCard->already_registered == 1) {
                    $approve =  WorkerApplicationStatus::updateOrCreate(
                        ['worker_id' => $request->id,
                            'application_status' => env('APPLICATION_FINAL_APPROVED'),],
                        [
                            'ack_no' => $idCard->ack_no,
                            'application_no' => $idCard->application_no,
                            'is_renewal' => 0,
                            'remarks' => "Onboarding Approved",
                            'sender_role_id' => $user->role_id,
                            'sender_office_id' => $user->office_id,
                            'sender_user_id' => $user->id,
                            'application_from_user' => $user->id,
                            'ro_approval_time' => now(),
                            'already_registered' => $onboarding ? 1 : 0 ,
                        ]
                    );
                    //user data

                    $user_data = User::updateOrCreate(
                        [
                            'username' => $idCard->id_card,
                        ],
                        [
                            'password' => Hash::make($request->id),
                            'phone' => $idCard->phone_no,
                            'role_id' => 6,
                            'status' => 1,
                            'office_id' => $idCard->office_id,
                            'password_change_first_attempt' => true
                        ]
                    );
                    // 1111111111111111111

                    // Main-worker-update

                    $data = MainWorkerForm::where('worker_id', $request->id)->update([
                        'status' => env('APPLICATION_FINAL_APPROVED'),
                        'id_card_created_at' => now(),
                        'ro_approval_time' => now(),

                    ]);

                    $today = Carbon::today();
                    $card_validity_date = $idCard->id_card_expiry_date;
                    $renewal_date = Carbon::parse($today)->addYears(2)->format('Y-m-d');
                    $formatted_date = Carbon::parse($card_validity_date)->format('Y-m-d');
                } else {
                    $approve =  WorkerApplicationStatus::updateOrCreate([
                        'worker_id' => $request->id,
                        'application_status' => env('APPLICATION_FINAL_APPROVED'),
                    ], [
                        'ack_no' => $idCard->ack_no,
                        'application_no' => $idCard->application_no,
                        'is_renewal' => 0,
                        'remarks' => "New Register Approved",
                        'sender_role_id' => $user->role_id,
                        'sender_office_id' => $user->office_id,
                        'sender_user_id' => $user->id,
                        'application_from_user' => $user->id,
                        'ro_approval_time' => now(),

                    ]);

                    $user_data = User::updateOrCreate([
                        'username' => $idCard->id_card,
                    ], [
                        'password' => Hash::make($request->id),
                        'phone' => $idCard->phone_no,
                        'role_id' => 6,
                        'status' => 1,
                        'office_id' => $idCard->office_id,
                        'password_change_first_attempt' => true
                    ]);
                    $today = Carbon::today();
                    $card_validity_date = Carbon::parse($today)->subDay()->addYears(2);
                    $renewal_date = Carbon::parse($today)->addYears(2)->format('Y-m-d');
                    $formatted_date = $card_validity_date->format('Y-m-d');

                    $data = MainWorkerForm::where('worker_id', $request->id)->update([
                        'status' => env('APPLICATION_FINAL_APPROVED'),
                        'id_card_expiry_date' => $formatted_date,
                        'application_receiver_user_id' => $user->id,
                        'id_card' => $idCard->id_card,
                        'renewal_date' => $renewal_date,
                        'id_card_created_at' => now(),
                        'ro_approval_time' => now(),
                    ]);
                }
                $this->smsService->appliacationApprovalSMS($idCard->phone_no, $idCard->id_card, 'https://abocwwb.assam.gov.in/');
            }

            DB::commit();
            return response()->json(['status' => true, 'results' => "Signed Successfully!"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'results' => $e->getMessage()]);
        }
    }
    public function getIdCard($workerId)
    {
        $id = decrypt($workerId);

        // Fetch the ID card record
        $idcard = WorkerIDCard::where('worker_id', $id)->latest()->first();

        if (!$idcard || empty($idcard->certificate)) {
            return response()->json([
                'status' => false,
                'message' => 'Certificate not found.',
            ], 404);
        }

        // Decode the Base64 certificate
        $pdfContent = base64_decode(
            preg_replace('#^data:application/pdf;base64,#', '', $idcard->certificate)
        );

        $filename = $id . '.pdf';

        return response($pdfContent, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}