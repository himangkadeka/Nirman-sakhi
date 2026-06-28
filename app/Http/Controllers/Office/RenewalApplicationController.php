<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\BocwCard;
use App\Models\CancelledAppModal;
use App\Models\District;
use App\Models\MainWorkerForm;
use App\Models\Office;
use App\Models\Reasons;
use App\Models\RenewWorkerForm;
use App\Models\User;
use App\Models\RevertBack;
use App\Models\WorkerApplicationStatus;
use App\Models\WorkerNinetyDaysCertificate;
use App\Models\WorkerPaymentSuccess;
use App\Models\WorkerSubscription;
use App\Services\AesCipher;
use App\Services\GetVaultDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Encryption\DecryptException;
class RenewalApplicationController extends Controller
{
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService)
    {

        $this->getVaultDataService = $getVaultDataService;
        $this->middleware('permission:view application list', ['only' => ['index']]);
        $this->middleware('permission:view office mis dashboard', ['only' => ['misData']]);
        $this->middleware('permission:preview application', ['only' => ['preview']]);
        $this->middleware('permission:application history da',['only' =>['getApplicationHistoryDa'] ]);
    }

    public function dscManual()
    {

        return view('office.dashboard.user-manual', ['type' => 'dsc']);
    }

    public function userManual()
    {
        return view('office.dashboard.user-manual', ['type' => 'manual']);
    }

    public function userManualDa()
    {
        return view('office.dashboard.user-manual-da', ['type' => 'manual']);
    }

    public function index($status, Request $request)
    {
        $userDetails = Auth::user();
        $filter = $request->input('filter', 'all');
        $searchAck = $request->input('ack_no');
        $this->checkPermission($status);


        $applications = $this->getApplicationsByStatus($status, $userDetails);

        if (!empty($searchAck)) {
            $applications = $applications->where('ack_no', 'ILIKE', "%{$searchAck}%");
            // For MySQL, use ->where('ack_no', 'like', "%{$searchAck}%");
        }


       $paginatedApplications = $this->paginateResults($applications);


        $statusApp = WorkerApplicationStatus::where('sender_office_id', $userDetails->office_id)
            ->latest('created_at')
            ->first();

        return view('office.applications.renewal-index', [
            'status' => $status,
            'user_details' => $userDetails,
            'applications' => $paginatedApplications,
            'currentFilter' => $filter,
            'searchAck' => $searchAck,
            'created_at' => now()
        ]);
    }

    /**
     * Check user permission for the requested status
     */
    protected function checkPermission($status)
    {
        $permissionMap = [
            //HRO
            //pending review
            'receivedRenewal' => 'view received renewal application',
            //Fresh submissions + resubmissions that returned to HRO after a Revert
            'pendingReviewRenewal' => 'pendingReviewRenewal',
            "resubmittedRenewal"=> 'renewal resubmitted',

            'totalreceivedRenewal' => 'view total received renewal application',
           // Applications the HRO had sent for document verification and have now come back, ready for a decision
            'verifiedByDaRenewal' => 'verifiedByDaRenewal',
            // under RO Review
            //All applications currently assigned to any RO (this list also shows items that DA has just sent back to an RO)
            'underROReviewRenewal' => 'underROReviewRenewal',
            'UnderDocumentVerificationRenewal' => 'UnderDocumentVerificationRenewal',
            'forwardedRenewal' => 'view total forwarded renewal application',
            'forwardedByDaRenewal' => 'view total forwarded by da renewal application',
            'approvedRenewal' => 'view total approved renewal application',
            'pullBackRenewal' => 'view total pull back renewal',
            'revertedBackRenewal' => 'revertedBackRenewal',
            'rejectRenewal' => 'view rejected renewal',
            //RO
            'RoReviewQueue' => 'view ro review pending queue',
            'VerifiedByDaRo' => 'view ro verified by da',
            'UnderDocumentVerificationRo' => 'under document verification ro da',
            'RevertedtoApplicantByRo' => 'reverted by ro',
            'ApplicationHistoryRo' => 'view all application under ro',

            //DA
            'PendingDocumentVerificationQueue' => 'pending at da end renewal',
            'VerifiedApplicationsHistory' => 'verified applications history'


        ];

        if (isset($permissionMap[$status]) && !Auth::user()->can($permissionMap[$status])) {
            abort(403);
        }
    }

    /**
     * Get applications based on status and user role
     */
    protected function getApplicationsByStatus($status, $user)
    {
        switch ($status) {
//            case "received":
//                return $this->getReceivedApplications($user);
            case "receivedRenewal":
                return $this->getRenewalReceivedApplications($user);

            case "revertedBackRenewal":
                return $this->getRevertedApplicationsRenewal($user);

            case "pendingReviewRenewal":
                return $this->getPendingReviewApplications($user);
//            case "totalreceived":
//                return $this->getTotalReceivedApplications($user);
            case "totalreceivedRenewal":
                return $this->getTotalReceivedRenewalApplications($user);
            case "approvedRenewal":
                return $this->getApprovedRenewalApplications($user);
            case "verifiedByDaRenewal":
                return $this->getVerifiedByDaHroRenewal($user);
//            case "pending":
//                return $this->getPendingApplications($user);
            case "forwardedRenewal":
                return $this->getRenewalForwardedApplications($user);
            case "pullBackRenewal":
                return $this->getPulledBackRenewalApplications($user);
            case "forwardedByDaRenewal":
                return $this->getRenewalForwardedByDaApplications($user);
//
            case "resubmittedRenewal":
                return $this->getResubmitedRenewalApplications($user);

            case "UnderDocumentVerificationRenewal":
                return $this->getUnderDocumentverificationRenewal($user);

            case "RoReviewQueue":
                return $this->getPendingAtRoRenewal($user);

            case "VerifiedByDaRo":
                return $this->getVerifiedByDaRoRenewal($user);

            case "UnderDocumentVerificationRo":
                return $this->getUnderDocumentVerificationDaRenewal($user);

            case "RevertedtoApplicantByRo":
                return $this->getRevertedtoApplicantByRo($user);

            case "ApplicationHistoryRo":
                return $this->getApplicationHistoryRo($user);

            case "PendingDocumentVerificationQueue":
                return $this->getPendingDocumentVerificationQueue($user);

            case "VerifiedApplicationsHistory":
                return $this->getVerifiedApplicationsHistory($user);

            default:
                Alert::toast("404! Not Found!", "error");
                return back();
        }
    }

    /**
     * Paginate the results (handles both query builder and collection)
     */
    protected function paginateResults($applications, $perPage = 10)
    {
        if ($applications instanceof \Illuminate\Database\Eloquent\Builder) {
            return $applications->paginate($perPage);
        }

        if ($applications instanceof \Illuminate\Support\Collection) {
            $page = LengthAwarePaginator::resolveCurrentPage();
            $total = $applications->count();
            $results = $applications->slice(($page - 1) * $perPage, $perPage)->values();

            return new LengthAwarePaginator($results, $total, $perPage, $page, [
                'path' => LengthAwarePaginator::resolveCurrentPath()
            ]);
        }

        return collect()->paginate($perPage);
    }

    public function getPendingReviewApplications($user)
    {
        if ($user->role_id == 2) {
            $officeId = $user->office_id;

            return RenewWorkerForm::where('office_id', $officeId)
                ->where(function ($query) use ($user) {
                    $query->where(function ($q) {
                        $q->where('status', 'A')
                            ->where('payment_status', 'success');
                    })
                        ->orWhere(function ($q) {
                            $q->where('status', 'B')
                                ->where('resubmit_status', 1);
                        })
                        ->orWhere(function ($q) use ($user) {
                            $q->where('status', 'B')
                                ->where('application_receiver_user_id', $user->id)
                                ->where('pull_back', 1);
                        });
                })
                ->orderBy('created_at', 'asc');




        } elseif ($user->role_id == 3) {
            return RenewWorkerForm::where('office_id', $user->office_id)
                ->where('application_receiver_user_id', $user->id)
                ->where('status', 'O')
                ->where('da_forward', null)
                ->orderBy('created_at', 'asc')
                ->where('payment_status', 'success');
        } elseif ($user->role_id == 4) {
            return WorkerApplicationStatus::where('application_receiver_user_id', $user->id)
                ->where('application_status', 'C')
                ->orderBy('created_at', 'asc')
                ->where('is_renewal',1)
                ->distinct('ack_no');
        }
    }

    public function getUnderDocumentverificationRenewal($user)
    {
        if ($user->role_id == 2){
            $officeId = $user->office_id;
            return RenewWorkerForm::where('office_id',$officeId)
                ->whereIn('status',['O','C'])
                ->orderBy('created_at','asc')
                ->where('payment_status','success');

        }
    }

    protected  function getResubmitedRenewalApplications($user)
    {
        if ($user->role_id == 2) {
            $officeId = $user->office_id;

            return RenewWorkerForm::where('office_id', $officeId)
                ->where('application_receiver_user_id', $user->id)
                ->whereIn('status',['A','B'])
                ->where('resubmit_status',1)
                ->orderBy('created_at', 'asc');


        } elseif ($user->role_id == 3) {
            return RenewWorkerForm::where('office_id', $user->office_id)
                ->where('application_receiver_user_id', $user->id)
                ->where('status', 'O')
                ->where('resubmit_status',1)
                ->orderBy('created_at', 'asc');
        }
    }

    protected  function  getRenewalReceivedApplications($user)
    {
        if ($user->role_id == 2) {
            $officeId = $user->office_id;

            return RenewWorkerForm::where('office_id', $officeId)
                ->where('status', 'A')
                ->orderBy('created_at', 'asc')
                ->where('payment_status', 'success');


        } elseif ($user->role_id == 3) {
            return RenewWorkerForm::where('office_id', $user->office_id)
                ->where('application_receiver_user_id', $user->id)
                ->where('status', 'O')
                ->whereNull('da_forward')
                ->orderBy('created_at', 'asc')
                ->where('payment_status', 'success');
        } elseif ($user->role_id == 4) {
            return WorkerApplicationStatus::where('application_receiver_user_id', $user->id)
                ->where('application_status', 'C')
                ->orderBy('created_at', 'asc')
                ->where('is_renewal',1);
//                ->distinct('ack_no');
        }
    }

    protected  function  getVerifiedByDaHroRenewal($user)
    {
        return RenewWorkerForm::where([
            ['office_id', '=', $user->office_id],
            ['status', '=', 'B'],
            ['da_forward', '=', 1],
        ])
            ->orderBy('created_at', 'asc');

    }

    protected function getTotalReceivedRenewalApplications($user)
    {
        if ($user->role_id == 2) {
            $officeId = $user->office_id;

            return RenewWorkerForm::where('office_id', $user->office_id)
                ->orderBy('created_at', 'asc');
        } elseif ($user->role_id == 3) {
            return WorkerApplicationStatus::where('application_receiver_user_id', $user->id)

                ->where('is_renewal',1)
                ->distinct('worker_id');
        } elseif ($user->role_id == 4) {
            return WorkerApplicationStatus::where('application_receiver_user_id', $user->id)
                ->where('is_renewal',1)
                ->distinct('worker_id');
        }
    }


    public function getApprovedRenewalApplications($user)
    {
        if (Auth::user()->role_id == 2) {
            Return RenewWorkerForm::where('status', 'F')
                ->where('office_id', $user->office_id)
//                ->where('application_sender_user_id', $user->id)
                ->distinct('ack_no');
        } elseif (Auth::user()->role_id == 3) {
            Return WorkerApplicationStatus::where('application_status', 'F')
                ->where('sender_office_id', $user->office_id)
                ->where('sender_user_id', $user->id)
                ->where('is_renewal',1)
                ->distinct('ack_no');
        }
    }
    public function getApplicationHistoryHro(){
        $user_details = Auth::user();

        $applicationsQuery = WorkerApplicationStatus::where('is_renewal', 1)
            ->where('sender_user_id', $user_details->id)
            ->addSelect([
                'receiver_created_at' => WorkerApplicationStatus::select('created_at')
                    ->where('application_status', 'C')
                    ->where('application_receiver_user_id', $user_details->id)
                    ->whereColumn('worker_id', 'Worker.worker_application_statuses.worker_id') // match same worker/application
                    ->limit(1),
            ])

            ->orderBy('created_at', 'asc');
//        return $applicationsQuery;
        $applications = $applicationsQuery->paginate(15);
        $status = 'Application History';


        return view('office.applications.application-history-da',compact('applications','status','user_details'));
    }

    public function getApplicationHistoryDa()
    {
//        $user = Auth::user();
        $user_details = Auth::user();

        $applicationsQuery = WorkerApplicationStatus::where('is_renewal', 1)
            ->where('sender_user_id', $user_details->id)
            ->addSelect([
                'receiver_created_at' => WorkerApplicationStatus::select('created_at')
                    ->where('application_status', 'C')
                    ->where('application_receiver_user_id', $user_details->id)
                    ->whereColumn('worker_id', 'Worker.worker_application_statuses.worker_id') // match same worker/application
                    ->limit(1),
            ])

            ->orderBy('created_at', 'asc');
//        return $applicationsQuery;
        $applications = $applicationsQuery->paginate(15);
        $status = 'Application History';


        return view('office.applications.application-history-da',compact('applications','status','user_details'));
    }


//
//    protected function getRevertedApplications($user)
//    {
//        return WorkerApplicationStatus::where('sender_user_id', $user->id)
//            ->where('application_status', 'G')
//            ->distinct('ack_no');
//    }
//
    protected function getRevertedApplicationsRenewal($user)
    {


        return WorkerApplicationStatus::where('sender_user_id', $user->id)
            ->where('application_status', 'G')
            ->orderBy('created_at', 'asc')
            ->where('is_renewal',1);

    }

//
    public function getRenewalForwardedApplications($user)
    {
        $subquery = WorkerApplicationStatus::selectRaw('MAX(id) as latest_id')
            ->groupBy('worker_id');

        if (Auth::user()->role_id == 2) {
            return RenewWorkerForm::whereIn('status', ['O', 'C'])
                ->where('office_id', $user->office_id)
                ->where('application_sender_user_id', $user->id)
//                ->whereIn('id', $subquery)
                ->latest('created_at');
        } elseif (Auth::user()->role_id == 3) {
            return RenewWorkerForm::with('latestStatusRelation')
                ->where('status', 'C')
                ->where('office_id', $user->office_id)
                ->where('application_sender_user_id', $user->id)
                ->latest('created_at');
        } elseif ($user->role_id == '4') {
            return WorkerApplicationStatus::where('sender_user_id', $user->id)
                ->whereIn('application_status', ['O', 'B'])
                ->where('is_renewal', 1)
                ->where('da_forward', 1)
                ->whereIn('id', $subquery)
                ->latest('created_at');
        }

//           Return $data2 = RenewWorkerForm::where('application_sender_user_id',$user->id)
//                ->whereIn('status', ['O', 'B'])
//                ->distinct('ack_no');
    }

    public function getRenewalForwardedByDaApplications($user)
    {
        if ($user->role_id == '2') {
            Return RenewWorkerForm::where('status', 'B')
                ->where('office_id', $user->office_id)
                ->where('application_receiver_user_id', $user->id)
                ->where('payment_status', 'success')
                ->where('da_forward', 1);
        } elseif ($user->role_id == '3') {
            Return RenewWorkerForm::where('status', 'O')
                ->where('application_receiver_user_id', $user->id)
                ->where('office_id', $user->office_id)
                ->where('da_forward', 1)
                ->where('payment_status', 'success');
        }
    }


    public function getPulledBackRenewalApplications($user)
    {
        if ($user->role_id == '2') {
            Return RenewWorkerForm::where('application_receiver_user_id', $user->id)
                ->where('status', 'B')
                ->where('pull_back', 1)
                ->distinct('ack_no');
        } elseif ($user->role_id == '3') {
            Return RenewWorkerForm::where('application_receiver_user_id', $user->id)
                ->where('status', 'O')
                ->where('pull_back', 1)
                ->distinct('ack_no');
        } elseif ($user->role_id == '4') {
            Return null;
        }
    }

    public function getPendingAtRoRenewal($user)
    {
        return RenewWorkerForm::where('application_receiver_user_id',$user->id)
            ->where('status','O')
            ->orderBy('created_at', 'asc');
    }

    public function getVerifiedByDaRoRenewal($user)
    {
        return RenewWorkerForm::where('application_receiver_user_id',$user->id)
            ->where('status','O')
            ->where('da_forward',1)
            ->orderBy('created_at', 'asc');

    }

    public function getRevertedtoApplicantByRo($user)
    {
        return RenewWorkerForm::where('application_sender_user_id',$user->id)
            ->where('status','G')
            ->orderBy('created_at', 'asc');
    }

    public function getUnderDocumentVerificationDaRenewal($user)
    {
        $officeId = $user->office_id;
        return RenewWorkerForm::where('application_sender_user_id',$user->id)
            ->where('status','C')
            ->where('office_id',$officeId)
            ->orderBy('created_at', 'asc');
    }

    public function getPendingDocumentVerificationQueue($user)
    {
        $officeId = $user->office_id;
        return RenewWorkerForm::where('application_receiver_user_id',$user->id)
            ->where('status','C')
            ->where('office_id',$officeId)
            ->orderBy('created_at', 'asc');
    }
    public function getVerifiedApplicationsHistory($user)
    {
        $officeId = $user->office_id;
        Return WorkerApplicationStatus::where('sender_user_id', $user->id)
            ->whereIn('application_status', ['O', 'B'])
            ->where('is_renewal',1)
            ->where('da_forward',1)
            ->orderBy('created_at', 'asc');
    }
//
//    public function getResubmitedApplications($user)
//    {
//        if ($user->role_id == '2') {
//            Return MainWorkerForm::where('status', 'A')
//                ->where('office_id', $user->office_id)
//                ->where('application_receiver_user_id', $user->id)
//                ->where('payment_status', 'success')
//                ->where('resubmit_status',1)
//                ->where('pull_back', null);
//        } elseif ($user->role_id == '3') {
//            Return MainWorkerForm::where('status', 'O')
//                ->where('application_receiver_user_id', $user->id)
//                ->where('office_id', $user->office_id)
//                ->where('pull_back', null)
//                ->where('resubmit_status',1)
//                ->where('payment_status', 'success');
//        }
//    }

// ... (similar methods for other status types)
    public function getLogsApiRenew($id): JsonResponse
    {
        try {
            $worker_id = decrypt($id);

            $logs = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->select('application_status', 'remarks', 'created_at','sender_user_id')
                ->where('is_renewal',1)// Adjust column names if needed
//                ->latest() // Same as ->orderBy('created_at', 'desc')
                ->orderBy('created_at', 'asc')
                ->get();
//            return $logs;

            // Format the date for cleaner display on the frontend
            $logs->transform(function ($log) {
                $log->formatted_date = $log->created_at->format('d M Y, h:i A');
                return $log;
            });

            return response()->json(['success' => true, 'logs' => $logs]);

        } catch (DecryptException $e) {
            Log::error("API Log Fetch: Decryption failed for ID: {$id}");
            return response()->json(['success' => false, 'message' => 'Invalid ID provided.'], 400);
        } catch (\Exception $e) {
            Log::error("API Log Fetch Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving logs.'], 500);
        }
    }

    public function getOffices(Request $request)
    {
        $data['office'] = DB::table('Masterdata.offices')
            ->where('district_code', $request->district_code)
            ->select('office_id', 'office_name')->orderBy('office_name')->get();
        return response()->json($data);
    }
}
