<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\BocwCard;
use App\Models\CancelledAppModal;
use App\Models\District;
use App\Models\MainWorkerDocument;
use App\Models\MainWorkerForm;
use App\Models\Office;
use App\Models\Reasons;
use App\Models\RenewWorkerForm;
use App\Models\User;
use App\Models\RevertBack;
use App\Models\UserTransfer;
use App\Models\WorkerApplicationStatus;
use App\Models\WorkerNinetyDaysCertificate;
use App\Models\WorkerPaymentSuccess;
use App\Models\WorkerSubscription;
use App\Services\AesCipher;
use App\Services\GetVaultDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Nette\Utils\first;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Encryption\DecryptException;


class ApplicationController extends Controller
{
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService)
    {

        $this->getVaultDataService = $getVaultDataService;
        $this->middleware('permission:view application list', ['only' => ['index']]);
        $this->middleware('permission:view office mis dashboard', ['only' => ['misData']]);
        $this->middleware('permission:preview application', ['only' => ['preview']]);
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

    public function index($status,Request $request)
    {
        $userDetails = Auth::user();

        $filter = $request->input('filter', 'all');
        $searchAck = $request->input('ack_no');
        $this->checkPermission($status);

        $applicationsQuery = $this->getApplicationsByStatus($status, $userDetails);


        if ($filter !== 'all') {
            $applicationsQuery = $this->applyRegistrationFilter($applicationsQuery, $filter);

        }
        if (!empty($searchAck)) {
            $applicationsQuery = $applicationsQuery->where('ack_no', 'ILIKE', "%{$searchAck}%");
            // For MySQL, use ->where('ack_no', 'like', "%{$searchAck}%");
        }
//        return $filter;
        $applicationsQuery = $this->applyRoleRestrictions($applicationsQuery, $userDetails);


        $applications = $this->paginateResults($applicationsQuery);

        $statusApp = WorkerApplicationStatus::where('sender_office_id', $userDetails->office_id)
            ->latest('created_at')
            ->first();

        return view('office.applications.index', [
            'status' => $status,
            'applications' => $applications,
            'user_details' => $userDetails,
            'currentFilter' => $filter,
            'searchAck' => $searchAck,
        ]);
    }

    /**
     * Check user permission for the requested status
     */
    protected function checkPermission($status)
    {
        $permissionMap = [
            'received' => 'view received application',
            'receivedReroute' => 'view received reroute app',
            'reverted' => 'view reverted application',
            'totalreceived' => 'view total received application',
            'approved' => 'view approved application',
            'rejected' => 'view rejected application',
            'pending' => 'view pending application',
            'forwarded' => 'view forwarded application',
            'pulledback' => 'view pull back application',
            'forwardedByDa' => 'view forwardedbyda application',
            'resubmitted' => 'view resubmitted application',
            'rerouted' => 'view rerouted application'
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
            case "received":
                return $this->getReceivedApplications($user);
            case "receivedReroute" :
                return $this->getReceivedRerouteApplications($user);
            case "reverted":
                return $this->getRevertedApplications($user);
            case "totalreceived":
                return $this->getTotalReceivedApplications($user);
            case "approved":
                return $this->getApprovedApplications($user);
            case "rejected":
                return $this->getRejectedApplications($user);
            case "pending":
                return $this->getPendingApplications($user);
            case "forwarded":
                return $this->getForwardedApplications($user);
            case "pulledback":
                return $this->getPulledBackApplications($user);
            case "forwardedByDa":
                return $this->getForwardedByDaApplications($user);

            case "resubmitted":
                return $this->getResubmitedApplications($user);

            case "rerouted":
                return $this->getReroutedApplications($user);

            default:
                Alert::toast("404! Not Found!", "error");
                return back();
        }
    }
    protected function applyRegistrationFilter($query, $filter)
    {
        switch ($filter) {
            case 'New Register':
                return $query->where(function ($q) {
                    $q->where(function ($sub) {
                        $sub->where('already_registered', 0)
                            ->orWhereNull('already_registered');
                    });
                });

            case 'On Boarding': // Match the exact string from your radio buttons
                return $query->where('already_registered', 1);


            case 'Re-Submitted':
                return $query->where('resubmit_status', 1);

            default:
                return $query;
        }
    }

    protected function applyRoleRestrictions($query, $user)
    {

        $officeId = $user->office_id;
        switch ($user->role_id) {
            case 2:
                return $query;
            case 3:
                return $query;
            case 4: // Admin
                return $query;
            case 5:
                return $query;

            case 18:
                return $query;
            default:
                return $query->where('created_by', $user->id);
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

    protected  function getReceivedRerouteApplications($user)
        {


            if($user->role_id == 5)
            {
                $officeId = $user->office_id;
                return MainWorkerForm::where('status', 'M')
                    ->orderBy('created_at','asc');
            }
//            elseif($user->role_id = 18)
//            {
//                $officeId = $user->office_id;
//                return WorkerApplicationStatus::where('application_receiver_user_id', $user->id)
//                    ->orderBy('created_at','asc')
//                    ->where('application_status', 'N');
//            }
        }



    protected function getReceivedApplications($user)
    {
        if ($user->role_id == 2) {
            $officeId = $user->office_id;

            return MainWorkerForm::where('office_id', $user->office_id)
                ->orderBy('created_at', 'asc')
                ->where('status', 'A')
                ->where('payment_status', 'success');

        } elseif ($user->role_id == 3) {
            return MainWorkerForm::where('office_id', $user->office_id)
                ->orderBy('created_at', 'asc')
                ->where('application_receiver_user_id', $user->id)
                ->where('status', 'O')
                ->whereNull('da_forward')
                ->where('payment_status', 'success');
        } elseif ($user->role_id == 4) {
            return WorkerApplicationStatus::where('application_receiver_user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->where('application_status', 'C');
        }
    }

    protected function getReroutedApplications($user)
    {
        if ($user->role_id == 2) {
            $officeId = $user->office_id;

            return MainWorkerForm::where('office_id', $officeId)
                ->orderBy('created_at', 'asc')
                ->where('re_route',1)
                ->where('status', 'B')
                ->whereNull('da_forward')
                ->where('payment_status', 'success');

        }
    }

    protected function getRevertedApplications($user)
    {


        return WorkerApplicationStatus::where('sender_user_id', $user->id)
            ->where('application_status', 'G')
            ->orderBy('created_at', 'asc')
            ->where('is_renewal',0);

    }

    protected function getTotalReceivedApplications($user)
    {
        if ($user->role_id == 2) {


            return MainWorkerForm::where('office_id',  $user->office_id)
                ->orderBy('created_at', 'asc')
                ->where('payment_status', 'success');
        } elseif ($user->role_id == 3) {
            return WorkerApplicationStatus::where('application_receiver_user_id', $user->id)
                ->where('ack_no', 'LIKE', '%/REG/%')
                ->orderBy('created_at', 'asc');
        } elseif ($user->role_id == 4) {
            return WorkerApplicationStatus::where('application_receiver_user_id', $user->id)
                ->where('ack_no', 'LIKE', '%/REG/%')
            ->orderBy('created_at', 'asc');
        }
    }

    public function getApprovedApplications($user)
    {
        if (Auth::user()->role_id == 2) {
            Return MainWorkerForm::where('status', 'F')
                ->where('office_id', $user->office_id)
                ->where('application_receiver_user_id', $user->id)
                ->orderBy('created_at', 'asc');
        } elseif (Auth::user()->role_id == 3) {
            Return MainWorkerForm::where('status', 'F')
                ->where('office_id', $user->office_id)
                ->orderBy('created_at', 'asc')
                ->where('application_receiver_user_id', $user->id);
        }
    }

    public function getRejectedApplications($user)
    {
        Return WorkerApplicationStatus::where('sender_user_id', $user->id)
            ->where('application_status', 'D')
            ->orderBy('created_at', 'asc');


    }

    public  function getForwardedApplications($user)
    {
        if ($user->role_id == '2') {
            Return MainWorkerForm::where('application_sender_user_id', $user->id)
                ->whereIn('status', ['O', 'C'])
                ->orderBy('created_at', 'asc')
                ->where('is_renewal',0);

        } elseif ($user->role_id == '3') {
            Return MainWorkerForm::where('application_sender_user_id', $user->id)
                ->where('status', 'C')
                ->orderBy('created_at', 'asc')
                ->where('is_renewal',0);


        } elseif ($user->role_id == '4') {
            Return WorkerApplicationStatus::where('sender_user_id', $user->id)
                ->where('is_renewal',0)
                ->orderBy('created_at', 'asc');
        }
    }

    public function getPulledBackApplications($user)
    {
        if ($user->role_id == '2') {
            Return MainWorkerForm::where('application_receiver_user_id', $user->id)
                ->where('status', 'B')
                ->where('pull_back', 1)
                ->where('is_renewal',0)
                ->orderBy('created_at', 'asc');
        } elseif ($user->role_id == '3') {
            Return MainWorkerForm::where('application_receiver_user_id', $user->id)
                ->where('status', 'O')
                ->where('pull_back', 1)
                ->where('is_renewal',0)
                ->orderBy('created_at', 'asc');

        } elseif ($user->role_id == '4') {
            Return null;
        }
    }

    public function getForwardedByDaApplications($user)
    {
        if ($user->role_id == '2') {
            Return MainWorkerForm::where('status', 'B')
                ->where('office_id', $user->office_id)
                ->where('application_receiver_user_id', $user->id)
                ->where('payment_status', 'success')
                ->where('da_forward', 1)
                ->where('is_renewal',0)
                ->orderBy('created_at', 'asc')
                ->where('pull_back', null);
        } elseif ($user->role_id == '3') {
            Return MainWorkerForm::where('status', 'O')
                ->where('application_receiver_user_id', $user->id)
                ->where('office_id', $user->office_id)
                ->where('da_forward', 1)
                ->where('is_renewal',0)
                ->where('pull_back', null)
                ->orderBy('created_at', 'asc')
                ->where('payment_status', 'success');
        }
    }

    public function getResubmitedApplications($user)
    {
        if ($user->role_id == '2') {
            Return MainWorkerForm::whereIn('status',['A', 'B'])
                ->where('office_id', $user->office_id)
                ->where('application_receiver_user_id',$user->id)
                ->where('resubmit_status',1)
                ->orderBy('created_at', 'asc');
        } elseif ($user->role_id == '3') {
            Return MainWorkerForm::where('status', 'O')
                ->where(function ($q) use ($user) {
                    $q->where('application_receiver_user_id', $user->id)
                        ->orWhereNull('application_receiver_user_id');
                })
                ->where('office_id', $user->office_id)
                ->where('resubmit_status',1)
                ->orderBy('created_at', 'asc')
                ->where('payment_status', 'success');
        }
    }

// ... (similar methods for other status types)


    public function getOffices(Request $request)
    {
        $data['office'] = DB::table('Masterdata.offices')
            ->where('district_code', $request->district_code)
            ->where('status', 1)
            ->select('office_id', 'office_name')->orderBy('office_name')->get();
        return response()->json($data);
    }

    public function preview(Request $request, $id)
    {
        try {
            $worker_id = decrypt($id);

            // ─── Vault Data ───
            $getVaultData = [];
            try {
                $vaultData = $this->getVaultDataService->getVaultData($worker_id, "M");
                $getVaultData = json_decode($vaultData->getData(), true) ?? [];
            } catch (\Exception $e) {
                \Log::error('Vault data fetch failed', ['worker_id' => $worker_id, 'error' => $e->getMessage()]);
                Alert::toast('Failed to load the Aadhar data, Please try again later.', 'error');
                return back();
            }

            // ─── Worker Details (polymorphic) ───
            $worker_details = MainWorkerForm::where('worker_id', $worker_id)->first()
                ?? RevertBack::where('worker_id', $worker_id)->first()
                ?? CancelledAppModal::where('worker_id', $worker_id)->first();

            // ─── Remarks ───
            $remarks = null;
            $revert_count = 0;
            if ($worker_details) {
                $revert_count = MainWorkerForm::where('worker_id', $worker_id)
                    ->where('resubmit_status', '1')
                    ->count();

                if ($revert_count > 0 && WorkerApplicationStatus::where('worker_id', $worker_id)
                        ->where('application_status', 'G')
                        ->where('is_renewal', 0)
                        ->exists()) {
                    $remarks = WorkerApplicationStatus::where('worker_id', $worker_id)
                        ->where('application_status', 'G')
                        ->where('is_renewal', 0)
                        ->latest()
                        ->first();
                }
            }

            // ─── Card Data ───
            $cardData = BocwCard::where('worker_id', $worker_id)->first();

            // ─── Master Data ───
            $officeDetails = DB::table('Masterdata.offices')
                ->where('status', 1)
                ->orderBy('office_name')
                ->get();

            $dists = District::where('state_code', 18)
                ->orderBy('district_name', 'asc')
                ->get();

            // ─── Users (OPTIMIZED: single query for both) ───
            $districtUsers = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->whereIn('role_id', [3, 4])
                ->get();

            $das = $districtUsers->unique('role_id')->values();
            $username = $districtUsers;

            // ─── Application Status ───
            $worker_app_status = WorkerApplicationStatus::where('worker_id', $worker_id)->latest()->first();
            $user_id = $worker_app_status->sender_user_id ?? null;

            $worker_app_status1 = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->where('sender_role_id', 2)
                ->where('application_receiver_role_id', 3)
                ->first();
            $user_id_1 = $worker_app_status1->sender_user_id ?? null;

            // ─── Role Resolution (safe null checks) ───
            $roleHro = $user_id_1 ? optional(User::find($user_id_1))->role : null;
            $roleDa = $user_id ? optional(User::find($user_id))->role : null;
            $userHro = $user_id_1 ? User::find($user_id_1) : null;
            $userDa = $user_id ? User::find($user_id) : null;

            // ─── Office Staff ───
            $da = User::where('status', 1)
                ->where('office_id', Auth::user()->office_id)
                ->where('role_id', 4)
                ->get();

            $user = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->where('role_id', 3)
                ->get();

            $ros = User::where('status', 1)
                ->where('office_id', Auth::user()->office_id)
                ->where('role_id', 4)
                ->first();

            $ro = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->where('role_id', 3)
                ->first();

            $officeAdmin = User::where('status', 1)
                ->where('office_id', 67)
                ->where('role_id', 5)
                ->get();

            $office_da = User::where('status', 1)
                ->where('office_id', 67)
                ->where('role_id', 18)
                ->get();

            $pullDa = User::where('status', 1)
                ->where('office_id', Auth::user()->office_id)
                ->where('role_id', Auth::user()->role_id)
                ->first();

            // ─── Aadhar Masking ───
            if (isset($getVaultData['uID'])) {
                $getVaultData['uID'] = str_repeat('*', 8) . substr($getVaultData['uID'], 8);
            }

            $base64Image = $getVaultData['photo'] ?? null;

            // ─── Receipt ───
            $subscription_receipt = MainWorkerDocument::whereNotNull('subscription_payment_receipt')
                ->where('worker_id', $worker_id)
                ->exists();

            // ─── Reasons ───
            $revertReasons = Reasons::where('type', 'Revert')->where('category', 'New Registration')->where('status', 1)->get();
            $revertReasonsOn = Reasons::where('type', 'Revert')->where('category', 'Onboarding')->where('status', 1)->get();
            $rejectReasons = Reasons::where('type', 'Reject')->where('category', 'New Registration')->where('status', 1)->get();
            $rejectReasonsOn = Reasons::where('type', 'Reject')->where('category', 'Onboarding')->where('status', 1)->get();
            $rejectReasonsRenew = Reasons::where('type', 'Reject')->where('category', 'Renewal')->where('status', 1)->get();

            // ─── Roles for dropdown ───
            if (Auth::user()->role_id == 2) {
                $roles = Role::whereIn('id', [3, 4])->get();
            } elseif (Auth::user()->role_id == 3) {
                $roles = Role::where('id', 4)->get();
            } else {
                $roles = collect();
            }

            // ─── Payment & Date ───
            $app_date = WorkerApplicationStatus::select('created_at')
                ->where('worker_id', $worker_id)
                ->where('application_status', 'A')
                ->first();

           $paymentDetails = WorkerPaymentSuccess::where('worker_id', $worker_id)
//                ->where('STATUS', 'Y')
                ->where('payment_type', 1)
                ->first();

            $isRenewal = null;

            return view('office.applications.preview', compact(
                'roles', 'worker_details', 'da', 'ro', 'pullDa', 'roleHro', 'userHro',
                'getVaultData', 'base64Image', 'isRenewal', 'das', 'officeDetails',
                'dists', 'user', 'username', 'roleDa', 'userDa', 'ros', 'revertReasons',
                'revertReasonsOn', 'rejectReasons', 'rejectReasonsOn', 'rejectReasonsRenew',
                'officeAdmin', 'paymentDetails', 'cardData', 'remarks', 'office_da',
                'subscription_receipt', 'app_date'
            ));

        } catch (\Exception $e) {
            \Log::error('previewAdmin error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            Alert::toast('Something went wrong, please try again later.', 'error');
            return back();
        }
    }

//    public function getRemarks($worker_id)
//    {
//
//
//        $remarksMain = WorkerApplicationStatus::with('getSenderUserName','getReceiver')
//            ->where('worker_id', $worker_id)
//            ->where('application_status', '!=', 'A')
//            ->orderBy('created_at', 'asc')
//            ->get();
//
//
//        $renewalRemarks = WorkerApplicationStatus::with('getSenderUserName','getReceiver')
//            ->where('worker_id', $worker_id)
//            ->where('application_status', 'A')
//            ->where('is_renewal', 1)
//            ->orderBy('created_at', 'asc')
//            ->get();
//
//        $remarks = WorkerApplicationStatus::with('getSenderUserName','getReceiver')
//            ->where('worker_id', $worker_id)
//            ->where('application_status', 'G')
//            ->where('is_renewal', 0)
//            ->first();
//
//        $revertReasons = Reasons::where('type', 'Revert')->where('category', 'New Registration')->where('status', 1)->get();
//        $revertReasonsOn = Reasons::where('type', 'Revert')->where('category', 'Onboarding')->where('status', 1)->get();
//        $rejectReasons = Reasons::where('type', 'Reject')->where('category', 'New Registration')->where('status', 1)->get();
//        $rejectReasonsOn = Reasons::where('type', 'Reject')->where('category', 'Onboarding')->where('status', 1)->get();
//        $rejectReasonsRenew = Reasons::where('type', 'Reject')->where('category', 'Renewal')->where('status', 1)->get();
//
//        return response()->json([
//            'remarksMain'    => $remarksMain,
//            'renewalRemarks' => $renewalRemarks,
//            'remarks'        => $remarks,
//        ]);
//    }

    public function getRemarks($worker_id)
    {
        $user = Auth::user();
        $currentTransfer = UserTransfer::where('transfer_from_office',$user->office_id)->orderBy('tenure_end_date', 'desc')->first();
        $remarksMain =WorkerApplicationStatus::with('getSenderUserName', 'getReceiver')
            ->where('worker_id', $worker_id)
            ->where('application_status', '!=', 'A')
            ->orderBy('created_at', 'asc')
            ->get();

        // Get all transfer records for the current office
        $officeId = Auth::user()->office_id;
        $transferRecords = UserTransfer::where('transfer_from_office', $officeId)
            ->orderBy('tenure_end_date', 'asc')
            ->get();

        // Map remarks with correct user timeline
        $remarksMain = $remarksMain->map(function ($remark) use ($currentTransfer) {
            $remark->timeline = 'Current User';

            // 🧩 Default: from Eloquent relations
            $remark->sender_name = $remark->getSenderUserName
                ? trim($remark->getSenderUserName->firstname . ' ' . $remark->getSenderUserName->lastname)
                : 'Unknown User';

            $remark->receiver_name = $remark->getReceiver
                ? trim($remark->getReceiver->firstname . ' ' . $remark->getReceiver->lastname)
                : 'N/A';

            // 🧩 Get current office ID
            $officeId = Auth::user()->office_id;

            // 🧩 Ensure current transfer exists and has valid tenure_end_date
            if ($currentTransfer && $currentTransfer->tenure_end_date) {
                $tenureEnd = \Carbon\Carbon::parse($currentTransfer->tenure_end_date);

                // ✅ If remark is before current user's tenure, mark as previous
                if ($remark->created_at < $tenureEnd) {
                    $remark->timeline = 'Previous User';

                    // 🔹 Check if sender belongs to a transferred user for this office
                    $senderTransfer = \App\Models\UserTransfer::where('user_id', $remark->sender_user_id)
                        ->where(function ($q) use ($officeId) {
                            $q->where('transfer_from_office', $officeId)
                                ->orWhere('transfer_to_office', $officeId);
                        })
                        ->latest('tenure_end_date')
                        ->first();

                    // If sender is transferred → use transfer table name
                    if ($senderTransfer) {
                        $remark->sender_name = trim($senderTransfer->firstname . ' ' . $senderTransfer->lastname);
                        $remark->user_was_transferred = true; // 👈 Add a flag for frontend
                    } else {
                        $remark->user_was_transferred = false;
                    }

                    // 🔹 Check if receiver was also transferred for this office
                    $receiverTransfer = \App\Models\UserTransfer::where('user_id', $remark->application_receiver_user_id)
                        ->where(function ($q) use ($officeId) {
                            $q->where('transfer_from_office', $officeId)
                                ->orWhere('transfer_to_office', $officeId);
                        })
                        ->latest('tenure_end_date')
                        ->first();

                    if ($receiverTransfer) {
                        $remark->receiver_name = trim($receiverTransfer->firstname . ' ' . $receiverTransfer->lastname);
                    }
                } else {
                    $remark->user_was_transferred = false;
                }
            }

            return $remark;
        });



        // --- Step 4: Renewal remarks (application_status = 'A' && is_renewal = 1) ---
        $renewalRemarks = WorkerApplicationStatus::with('getSenderUserName', 'getReceiver')
            ->where('worker_id', $worker_id)
            ->where('application_status', 'A')
            ->where('is_renewal', 1)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($remark) {
                $transfer = UserTransfer::where('user_id', $remark->created_at)
                    ->orderBy('tenure_end_date', 'desc')
                    ->first();
                $remark->user_name = $transfer
                    ? trim($transfer->firstname . ' ' . $transfer->lastname)
                    : 'Unknown User';
                return $remark;
            });

        // --- Step 5: Single “G” remark for non-renewal ---
        $remarks = WorkerApplicationStatus::with('getSenderUserName', 'getReceiver')
            ->where('worker_id', $worker_id)
            ->where('application_status', 'G')
            ->where('is_renewal', 0)
            ->first();



        if ($remarks) {
//            $transfer = UserTransfer::where('user_id', $remarks->created_at)
//                ->orderBy('tenure_end_date', 'desc')
//                ->first();
//            if ($transfer)
            $remarks->sender_name = $remarks->getSenderUserName
                ? trim($remarks->getSenderUserName->firstname . ' ' . $remarks->getSenderUserName->lastname)
                : 'Unknown User';
        }

        // --- Step 6: Return the combined data ---
        return response()->json([
            'remarksMain'    => $remarksMain,
            'renewalRemarks' => $renewalRemarks,
            'remarks'        => $remarks,
        ]);
    }


    public function previewRenewal(Request $request, $id)
    {

        try {
            $worker_id = decrypt($id);
            try {
                $vaultData = $this->getVaultDataService->getVaultData($worker_id, "M");
                $getVaultData = json_decode($vaultData->getData(), true);
            } catch (Exception $e) {

                Alert::toast('Failed to load application, ADV Server is busy. Please try again later.', 'error');
                return back();
            }


            $worker_details = MainWorkerForm::where('worker_id', $worker_id)->first();
            $worker_renewal_details = RenewWorkerForm::where('worker_id', $worker_id)->first();
            $remarks = null;
            $resubmit_remarks = null;
            $revert_count = RenewWorkerForm::where('worker_id', $worker_id)->where('resubmit_status', '1')->count();
//            return $revert_count;
            if ($revert_count > 0) {
//                $remarksData = WorkerApplicationStatus::where('worker_id', $worker_id)->where('application_status', 'G')->where('is_renewal',1)->count();
//                return $remarksData;

//                if ($remarksData > 0) {
                    $remarks = WorkerApplicationStatus::where('worker_id', $worker_id)
                        ->where('application_status', 'G')
                        ->where('is_renewal',1)
                        ->latest()
                    ->first();

                    $resubmit_remarks = WorkerApplicationStatus::where('worker_id', $worker_id)
                        ->where('application_status', 'A')
                        ->where('resubmit_status',1)
                        ->where('is_renewal',1)
                        ->latest()
                        ->first();

                }
//            }


            $certificate_proof = WorkerNinetyDaysCertificate::where('worker_id', $worker_id)->get();
            $worker_details_renew = RenewWorkerForm::where('worker_id', $worker_id)->first();
            $subscription_data = WorkerSubscription::where('worker_id',$worker_id)->get();

            $bocwCard = BocwCard::where('worker_id', $worker_id)->count();

            $cardData = null;

            if ($bocwCard > 0) {
                $cardData = BocwCard::where('worker_id', $worker_id)->value('existing_card');
            }

            $officeDetails = DB::table('Masterdata.offices')
                ->where('status', 1)
                ->orderBy('office_name')
                ->get();
            $dists = District::where('state_code', 18)
                ->orderBy('district_name', 'asc')
                ->get();

            //role for hro
            $das = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->whereIn('role_id', [3, 4])
                ->distinct('role_id')
                ->get();

            //username for hro
            $username = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->whereIn('role_id', [3, 4])
                ->get();

            //role for da

            //            $roleDa = MainWorkerForm::where('payment_status' == 'success')
            //                ->where('office_id',Auth::user()->office_id)
            //                ->where('');
            //            dd($worker_details);
            $worker_app_status = WorkerApplicationStatus::where('worker_id', $worker_id)->latest()->first();
            $user_id = $worker_app_status->sender_user_id ?? null;
            $worker_app_status1 = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->where('sender_role_id', 2)
                ->where('application_receiver_role_id', 3)
                ->first();
            $user_id_1 = $worker_app_status1->sender_user_id ?? null;

            if ($user_id_1 == null) {
                $roleHro = null;
            } else {
                $roleHro = Role::where('id', User::find($user_id_1)->role_id)->first();
            }


            if ($user_id == null) {
                $roleDa = null;
            } else {
                $roleDa = Role::where('id', User::find($user_id)->role_id)->first();
            }


            $userDa = User::where('id', $user_id)->first();
            $userHro = User::where('id', $user_id_1)->first();


            $da = User::where('status', 1)
                ->where('office_id', Auth::user()->office_id)
                ->where('role_id', 4)
                ->distinct()
                ->get();

            $user = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->where('role_id', 3)
                ->distinct()
                ->get();

            $ros = User::where('status', 1)
                ->where('office_id', Auth::user()->office_id)
                ->where('role_id',  4)
                ->distinct('role_id')
                ->first();

            $ro = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->where('role_id', 3)
                ->distinct()
                ->first();

            $officeAdmin =  User::where('status', 1)
                ->where('office_id', 67)
                ->where('role_id', 5)
                ->distinct()
                ->get();

            $pullDa = User::where('status', '=', '1')
                ->where('office_id', Auth::user()->office_id)
                ->where('role_id', '=', Auth::user()->role_id)
                ->first();


            // return $worker_details;
            $maskAadharNumber = function ($aadharNumber) {
                return str_repeat('*', 8) . substr($aadharNumber, 8);
            };
            $maskAadharNumber = function ($aadharNumber) {
                return str_repeat('*', 8) . substr($aadharNumber, 8);
            };
            if (isset($getVaultData['uID'])) {
                $getVaultData['uID'] = $maskAadharNumber($getVaultData['uID']);
            }

            $base64Image = $getVaultData['photo'];

            $isRenewal = MainWorkerForm::where('worker_id', $worker_id)
                ->where('is_renewal', 1)->exists();

            $renewalRemarks = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->where('application_status', '!=', 'A')
                ->where('is_renewal', 1)
                ->orderBy('created_at','asc')
                ->get();


//            return $remarks;



            $revertReasons = Reasons::where('type', 'Revert')->where('category', 'New Registration')->where('status', 1)->get();
            $revertReasonsOn = Reasons::where('type', 'Revert')->where('category', 'Onboarding')->where('status', 1)->get();
            $rejectReasons = Reasons::where('type', 'Reject')->where('category', 'New Registration')->where('status', 1)->get();
            $rejectReasonsOn = Reasons::where('type', 'Reject')->where('category', 'Onboarding')->where('status', 1)->get();
            $rejectReasonsRenew = Reasons::where('type', 'Revert')->where('category', 'Renewal')->where('status', 1)->get();
            if (Auth::user()->role_id == 2) {
                $roles = Role::whereIn('id', [3, 4])->get();
            } elseif (Auth::user()->role_id == 3) {
                $roles = Role::where('id', 4)->get();
            } else {
                $roles = [];
            }

            $paymentDetails = WorkerPaymentSuccess::where('worker_id', $worker_id)->where('STATUS', 'Y')->where('payment_type', 1)->first();

            return view('office.applications.preview-renewal', compact(
                'roles',
                'worker_details',
                'da',
                'ro',
                'pullDa',
                'roleHro',
                'userHro',
                'getVaultData',
                'base64Image',
                  'worker_renewal_details',
                'renewalRemarks',
                'isRenewal',
                'das',
                'worker_details_renew',
                'officeDetails',
                'dists',
                'certificate_proof',
                'user',
                'username',
                'roleDa',
                'userDa',
                'ros',
                'revertReasons',
                'revertReasonsOn',
                'rejectReasons',
                'rejectReasonsOn',
                'rejectReasonsRenew',
                'officeAdmin',
                'paymentDetails',
                'cardData',
                'remarks',
                'subscription_data',
                'resubmit_remarks'
            ));
        } catch (Exception $e) {
//            return $e;

           // return $e;
            Alert::toast('Please try again later.', 'error');
            return back();
        }
    }

    public function getLogsApi($id): JsonResponse
    {
        try {
            $worker_id = decrypt($id);

            $logs = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->select('application_status', 'remarks', 'created_at','sender_user_id','application_from_user')
                ->where('is_renewal',0)// Adjust column names if needed
                    ->orderBy('created_at','asc')
//                ->latest() // Same as ->orderBy('created_at', 'desc')
                ->get();

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


    public function misData(Request $request, $application_type)
    {

        $office_id = Auth::user()->office_id;
        $fromDateInput = $request->input('fromDate');
        $toDateInput = $request->input('toDate');
        $fromDate = $fromDateInput ? \Carbon\Carbon::parse($fromDateInput)->startOfDay() : null;
        $toDate = $toDateInput ? \Carbon\Carbon::parse($toDateInput)->endOfDay() : null;
        // dd($office_id);
        $office = Office::where('office_id', $office_id)->first();

//        $office->total_count = $office->getCount($office_id) + $office->notResubmittedCount($office_id) + $office->rejectedApplicationCount($office_id);
//        $office->new_registrations = $office->newRegistrationsCount($office_id);
//        $office->onboarding = $office->alreadyRegisteredCount($office_id);
//        $office->pending = $office->pendingApplicationCount($office_id);
//        $office->approved = $office->approvedApplicationCount($office_id);
//        $office->rejected = $office->rejectedApplicationCount($office_id);
//        $office->reverted = $office->revertedApplicationCount($office_id);
//        $office->resubmitted =$office->revertedApplicationCount($office_id) - $office->notResubmittedCount($office_id);
        $office->total_count = $this->getCount($office->office_id, $application_type, $fromDate, $toDate) + $this->getrevertNotResubmittedCount($office->office_id, $application_type, $fromDate, $toDate) + $this->rejectedApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
        $office->pending = $this->pendingApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
        $office->approved = $this->approvedApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
        $office->rejected = $this->rejectedApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
        $office->reverted = $this->revertedApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
        $office->revert_resubmitted =  $this->revertedApplicationCount($office->office_id, $application_type, $fromDate, $toDate) - $this->getrevertNotResubmittedCount($office->office_id, $application_type, $fromDate, $toDate);

        return view('office.mis-data.index', compact('office', 'application_type', 'fromDate', 'toDate'));
    }

    public function getCount($office_id, $application_type='all',$fromDate = null, $toDate = null)
    {
        $query = MainWorkerForm::where('office_id', $office_id);
        if ($application_type == 'onboarding') {
            $query->where('already_registered', 1);
        } elseif ($application_type == 'new') {
            $query->where('already_registered', null);
        }
        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
        $count = $query->count();
        return $count;
    }
    public function getrevertNotResubmittedCount($office_id, $application_type, $fromDate = null, $toDate = null)
    {

        $query = RevertBack::where('office_id', $office_id)
            ->where('resubmit_status', 0)
            ->where('ack_no', 'ILIKE', '%/reg/%');


        if ($application_type == 'onboarding') {
            $query->where('already_registered', 1);
        } elseif ($application_type == 'new') {
            $query->where('already_registered', null);
        }
        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
        return $query->count();
    }
    public function getResubmittedCount($office_id, $application_type, $fromDate = null, $toDate = null)
    {
        $query = RevertBack::where('office_id', $office_id)
            ->where('resubmit_status', 1)
            ->where('ack_no', 'ILIKE', '%/reg/%');
        if ($application_type == 'onboarding') {
            $query->where('already_registered', 1);
        } elseif ($application_type == 'new') {
            $query->where('already_registered', null);
        }
        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
        return $query->count();
    }


    public function pendingApplicationCount($office_id, $application_type, $fromDate = null, $toDate = null)
    {
        $query = MainWorkerForm::where('office_id', $office_id)->whereNotIn('status', ['F', 'D', 'G']);
        if ($application_type == 'onboarding') {
            $query->where('already_registered', 1);
        } elseif ($application_type == 'new') {
            $query->where('already_registered', null);
        }
        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
        return $query->count();
    }

    public function approvedApplicationCount($office_id, $application_type, $fromDate = null, $toDate = null)
    {
        $query = MainWorkerForm::where('office_id', $office_id)->where('status', 'F');
        if ($application_type == 'onboarding') {
            $query->where('already_registered', 1);
        } elseif ($application_type == 'new') {
            $query->where('already_registered', null);
        }
        if ($fromDate && $toDate) {
            $query->whereBetween('id_card_created_at', [$fromDate, $toDate]);
        }
        return $query->count();
    }
    public function rejectedApplicationCount($office_id, $application_type, $fromDate = null, $toDate = null)
    {
        $query = CancelledAppModal::where('office_id', $office_id)->where('status', 'D');
        if ($application_type == 'onboarding') {
            $query->where('already_registered', 1);
        } elseif ($application_type == 'new') {
            $query->where('already_registered', null);
        }
        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
        return $query->count();
    }
    public function revertedApplicationCount($office_id, $application_type, $fromDate = null, $toDate = null)
    {
        $query = RevertBack::where('office_id', $office_id)->where('status', 'G')
            ->where('ack_no', 'ILIKE', '%/reg/%');
        if ($application_type == 'onboarding') {
            $query->where('already_registered', 1);
        } elseif ($application_type == 'new') {
            $query->where('already_registered', null);
        }
        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
        return $query->count();
    }


    public function filterData(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        if (!$fromDate || !$toDate) {
            return redirect()->route('office.mis-data.index')->with('error', 'Please select both dates.');
        }

        $office_id = Auth::user()->office_id;

        $office = Office::where('office_id', $office_id)->first();

        $office->total_count = MainWorkerForm::where('office_id', $office->office_id)
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();

        $office->new_registrations = MainWorkerForm::where('office_id', $office->office_id)
            ->whereNull('already_registered')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();

        $office->onboarding = MainWorkerForm::where('office_id', $office->office_id)
            ->where('already_registered', 1)
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();

        $office->pending = MainWorkerForm::where('office_id', $office->office_id)
            ->whereNotIn('status', ['F', 'D', 'G'])
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();

        $office->approved = WorkerApplicationStatus::where('sender_office_id', $office->office_id)
            ->where('application_status', 'F')
            ->whereBetween('id_card_created_at', [$fromDate, $toDate])
            ->distinct('ack_no')
            ->count();

        $office->rejected = CancelledAppModal::where('office_id', $office->office_id)
            ->where('status', 'D')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();

        $office->reverted = RevertBack::where('office_id', $office->office_id)
            ->where('status', 'G')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();

        return view('office.mis-data.index', compact('office', 'fromDate', 'toDate'));
    }


    public function filterApplications(Request $request)
    {
        $user = Auth::user();
        $status = $request->input('status', 'all');
        $filter = $request->input('filter', 'all');

        $query = DB::table('main_worker_forms');

        switch ($filter) {
            case 'new_register':
                $query->where(function($q) {
                    $q->where('already_registered', 0)
                        ->where('resubmit_status',0)
                        ->orWhereNull('already_registered');
                });


                if ($user->role_id == 2) {
                    $query->where('office_id', $user->office_id);
                } elseif ($user->role_id == 3) {
                    $query->where('application_receiver_user_id', $user->id);
                }
                break;

            case 'onboarding':
                $query->where('already_registered', 1)
                    ->where('resubmit_status',0);


                if ($user->role_id == 2) {
                    $query->where('office_id', $user->office_id);
                } elseif ($user->role_id == 3) {
                    $query->where('application_receiver_user_id', $user->id);
                }
                break;

            case 'resubmitted':
                $query->where('resubmit_status', 1);

                if ($user->role_id == 2) {
                    $query->where('office_id', $user->office_id);

                } elseif ($user->role_id == 3) {
                    $query->where('application_receiver_user_id', $user->id);
                }
                break;

            default:

                break;
        }

        $applications = $query->orderBy('created_at', 'desc')->get();

        $applications = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('office.applications.index', [
            'applications' => $applications,
            'status' => $status,
            'currentFilter' => $filter
        ]);
    }
}
