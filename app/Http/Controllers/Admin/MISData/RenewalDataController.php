<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerForm;
use App\Models\RenewWorkerForm;
use App\Services\GetVaultDataService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\WorkerApplicationStatus;
use App\Models\WorkerSubscription;
use Illuminate\Support\Facades\DB;
use App\Models\Office;
use App\Models\District;
use App\Models\User;
Use Illuminate\Support\Facades\Auth;
Use Spatie\Permission\Models\Role;
Use App\Models\Reasons;
Use App\Models\WorkerPaymentSuccess;


class RenewalDataController extends Controller
{
    protected $getVaultDataService;
    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService= $getVaultDataService;
    }
    public function index(Request $request)
    {
        $query = RenewWorkerForm::query()->with('officeName');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('ack_no', 'like', "%{$search}%")
                    ->orWhere('id_card', 'like', "%{$search}%");
            });
        }
        $workerdata = $query->orderBy('created_at', 'desc')->paginate(10); // 10 per page

        return view('admin.mis-data.renewal-data.index', compact('workerdata', 'search'));
    }

    public function previewRenewal(Request $request, $id)
    {
        try {
            $worker_id = decrypt($id);

            // 1. Fetch Vault Data Safely
            $vaultData = $this->getVaultDataService->getVaultData($worker_id, "M");

            // SAFEGUARD: If the service returned a string or arrays instead of a standard Response object
            if (is_string($vaultData)) {
                $getVaultData = json_decode($vaultData, true);
            } elseif (is_array($vaultData)) {
                $getVaultData = $vaultData;
            } elseif (method_exists($vaultData, 'getData')) {
                // It's a genuine Laravel Response object
                $getVaultData = json_decode($vaultData->getData(), true);
            } else {
                $getVaultData = null;
            }

            // SAFEGUARD: Check if the API returned an error string, a validation array, or is completely null
            if (
                empty($getVaultData) ||
                isset($getVaultData['response']) ||
                !isset($getVaultData['photo']) ||
                $getVaultData['response'] === "VALIDATION"
            ) {
                // Log the failure to your storage/logs/laravel.log for tracking
                logger()->error("Vault Verification Aborted for Worker ID: {$worker_id}. Profile contains missing identity details.");

                // Gracefully redirect back with an alert message instead of breaking the page
                return back()->with('error', 'Cannot open profile. This worker record lacks verified Identity Vault registration details.');
            }

            // 2. Proceed safely now that we are 100% sure 'uID' and 'photo' exist in the array
            if (isset($getVaultData['uID'])) {
                $getVaultData['uID'] = str_repeat('*', 8) . substr($getVaultData['uID'], 8);
            }

            $base64Image = $getVaultData['photo'];

            // 2. Eager-load Worker Details and Core Relationships in One Shot
            $worker_details = MainWorkerForm::with([
                'renewal',
                'subscriptions',
                'paymentSuccess',
                'applicationStatuses.sender.role'
            ])
                ->where('worker_id', $worker_id)
                ->firstOrFail();

            $subscription_data = $worker_details->subscriptions;
            $paymentDetails = $worker_details->paymentSuccess;
            $cardData = $worker_details->worker_id;

            // 3. Consolidate Duplicate Worker Renewal Queries
            $worker_renewal_details = RenewWorkerForm::where('worker_id', $worker_id)->first();
            $worker_details_renew = $worker_renewal_details;

            // 4. Optimize History Status Evaluation Using Selective Database Constraints
            $revert_count = RenewWorkerForm::where('worker_id', $worker_id)
                ->where('resubmit_status', '1')
                ->count();

            $remarks = null;
            $resubmit_remarks = null;

            if ($revert_count > 0) {
                $remarks = WorkerApplicationStatus::where('worker_id', $worker_id)
                    ->where('application_status', 'G')
                    ->where('is_renewal', 1)
                    ->latest()
                    ->first();

                $resubmit_remarks = WorkerApplicationStatus::where('worker_id', $worker_id)
                    ->where('application_status', 'A')
                    ->where('resubmit_status', 1)
                    ->where('is_renewal', 1)
                    ->latest()
                    ->first();
            }

            // 5. Lighten Master Data Retrieval Footprint
            $officeDetails = DB::table('Masterdata.offices')
                ->where('status', 1)
                ->orderBy('office_name')
                ->get();

            $dists = District::where('state_code', 18)
                ->orderBy('district_name', 'asc')
                ->get();

            // 6. User and Role Matrix Mapping (Optimized Queries)
            $currentUser = Auth::user();

            $das = User::where('status', 1)
                ->where('district', $currentUser->district)
                ->whereIn('role_id', [3, 4])
                ->distinct('role_id')
                ->get();

            $username = User::where('status', 1)
                ->where('district', $currentUser->district)
                ->whereIn('role_id', [3, 4])
                ->get();

            // Target application status metrics without scanning full table collections into memory
            $worker_app_status = WorkerApplicationStatus::with('sender.role')
                ->where('worker_id', $worker_id)
                ->latest()
                ->first();

            $user_id = $worker_app_status->sender_user_id ?? null;

            $worker_app_status1 = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->where('sender_role_id', 2)
                ->where('application_receiver_role_id', 3)
                ->first();

            $user_id_1 = $worker_app_status1->sender_user_id ?? null;

            $roleHro = $user_id_1 ? Role::find(User::find($user_id_1)->role_id ?? null) : null;
            $roleDa = $user_id ? Role::find(User::find($user_id)->role_id ?? null) : null;

            $userDa = $user_id ? User::find($user_id) : null;
            $userHro = $user_id_1 ? User::find($user_id_1) : null;

            $da = User::where('status', 1)
                ->where('office_id', $currentUser->office_id)
                ->where('role_id', 4)
                ->get();

            $user = User::where('status', 1)
                ->where('district', $currentUser->district)
                ->where('role_id', 3)
                ->get();

            $ros = User::where('status', 1)
                ->where('office_id', $currentUser->office_id)
                ->where('role_id', 4)
                ->first();

            $ro = User::where('status', 1)
                ->where('district', $currentUser->district)
                ->where('role_id', 3)
                ->first();

            $officeAdmin = User::where('status', 1)
                ->where('office_id', 67)
                ->where('role_id', 5)
                ->get();

            $pullDa = User::where('status', '1')
                ->where('office_id', $currentUser->office_id)
                ->where('role_id', $currentUser->role_id)
                ->first();

            $isRenewal = MainWorkerForm::where('worker_id', $worker_id)
                ->where('is_renewal', 1)
                ->exists();

            $renewalRemarks = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->where('application_status', '!=', 'A')
                ->where('is_renewal', 1)
                ->orderBy('created_at', 'asc')
                ->get();

            // 7. Group Reason Code Fetching
            $revertReasons = Reasons::where('type', 'Revert')->where('category', 'New Registration')->where('status', 1)->get();
            $revertReasonsOn = Reasons::where('type', 'Revert')->where('category', 'Onboarding')->where('status', 1)->get();
            $rejectReasons = Reasons::where('type', 'Reject')->where('category', 'New Registration')->where('status', 1)->get();
            $rejectReasonsOn = Reasons::where('type', 'Reject')->where('category', 'Onboarding')->where('status', 1)->get();
            $rejectReasonsRenew = Reasons::where('type', 'Revert')->where('category', 'Renewal')->where('status', 1)->get();

            // 8. Handle Auth Roles Allowed Variations
            $roles = [];
            if ($currentUser->role_id == 2) {
                $roles = Role::whereIn('id', [3, 4])->get();
            } elseif ($currentUser->role_id == 3) {
                $roles = Role::where('id', 4)->get();
            }

            return view('office.applications.preview-renewal', compact(
                'roles', 'worker_details', 'da', 'ro', 'pullDa', 'roleHro', 'userHro',
                'getVaultData', 'base64Image', 'worker_renewal_details', 'renewalRemarks',
                'isRenewal', 'das', 'worker_details_renew', 'officeDetails', 'dists',
                'user', 'username', 'roleDa', 'userDa', 'ros', 'revertReasons',
                'revertReasonsOn', 'rejectReasons', 'rejectReasonsOn', 'rejectReasonsRenew',
                'officeAdmin', 'paymentDetails', 'cardData', 'remarks', 'subscription_data',
                'resubmit_remarks'
            ));

        } catch (Exception $e) {
            // Log the structural error gracefully to prevent clean system drops
            logger()->error('Preview Renewal Crash: ' . $e->getMessage(), ['worker_id' => $id]);
            return back()->with('error', 'Unable to process request due to a system resource constraint.');
        }
    }
}
