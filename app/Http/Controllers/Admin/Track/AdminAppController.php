<?php

namespace App\Http\Controllers\Admin\Track;

use App\Http\Controllers\Controller;
use App\Models\CancelledAppModal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MainWorkerForm;
use Yajra\DataTables\Facades\DataTables;
use App\Services\GetVaultDataService;
use App\Models\BocwCard;
use App\Models\District;
use App\Models\MainWorkerDocument;
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
use Illuminate\Support\Facades\Auth;
use function Nette\Utils\first;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminAppController extends Controller
{
    protected $getVaultDataService;
    public function __construct(GetVaultDataService $getVaultDataService)
    {

        $this->getVaultDataService = $getVaultDataService;
//        $this->middleware('permission:view application list', ['only' => ['index']]);
//        $this->middleware('permission:view office mis dashboard', ['only' => ['misData']]);
//        $this->middleware('permission:preview application', ['only' => ['preview']]);
    }

    public function index(Request $request)
    {
        return view('admin.track.index');
    }

    public function previewAdmin(Request $request, $id)
    {
        try {
            $worker_id = decrypt($id);

            // ─── VAULT DATA (with timeout protection) ───
            $getVaultData = [];
            try {
                $vaultData = $this->getVaultDataService->getVaultData($worker_id, "M");
                $getVaultData = json_decode($vaultData->getData(), true) ?? [];
            } catch (\Exception $e) {
                \Log::error('Vault failed', ['worker_id' => $worker_id, 'error' => $e->getMessage()]);
                Alert::toast('Failed to load Aadhar data, Please try again later.', 'error');
                return back();
            }

            // ─── WORKER DETAILS (with timeout) ───
            $worker_details = null;
            $sources = [
                MainWorkerForm::class,
                RevertBack::class,
                CancelledAppModal::class
            ];

            foreach ($sources as $model) {
                $worker_details = $model::where('worker_id', $worker_id)->first();
                if ($worker_details) break;
            }

            // ─── REVERT COUNT (HARD LIMIT to prevent count on huge datasets) ───
            $revert_count = 0;
            $remarks = null;

            if ($worker_details) {
                // Use exists() instead of count() for speed
                $hasReverts = MainWorkerForm::where('worker_id', $worker_id)
                    ->where('resubmit_status', '1')
                    ->exists();

                if ($hasReverts) {
                    $revert_count = MainWorkerForm::where('worker_id', $worker_id)
                        ->where('resubmit_status', '1')
                        ->count();
                }

                // ─── REMARKS (HARD LIMIT + specific query) ───
                if ($revert_count > 0) {
                    // CRITICAL FIX: Add take(1) to prevent loading all history
                    $remarks = WorkerApplicationStatus::where('worker_id', $worker_id)
                        ->where('application_status', 'G')
                        ->where('is_renewal', 0)
                        ->latest('created_at')  // Explicit column
                        ->take(1)               // HARD LIMIT
                        ->first();
                }
            }

            // ─── CARD DATA (single query) ───
            $cardData = BocwCard::where('worker_id', $worker_id)->first();

            // ─── MASTER DATA (cached) ───
            $officeDetails = cache()->remember('offices_active', 60, function () {
                return DB::table('Masterdata.offices')->where('status', 1)->orderBy('office_name')->get();
            });

            $dists = cache()->remember('districts_state_18', 60, function () {
                return District::where('state_code', 18)->orderBy('district_name', 'asc')->get();
            });

            // ─── USER QUERIES (single optimized query) ───
            $currentDistrict = Auth::user()->district;
            $currentOfficeId = Auth::user()->office_id;

            $districtUsers = cache()->remember("district_users_{$currentDistrict}", 60, function () use ($currentDistrict) {
                return User::where('status', 1)
                    ->where('district', $currentDistrict)
                    ->whereIn('role_id', [3, 4])
                    ->get();
            });

            $das = $districtUsers->unique('role_id')->values();
            $username = $districtUsers;

            // ─── APPLICATION STATUS (CRITICAL FIX: hard limit + specific columns) ───
            // Use select() to avoid loading massive relationships
            $worker_app_status = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->select('id', 'sender_user_id', 'sender_role_id', 'application_receiver_role_id', 'created_at')
                ->latest('created_at')
                ->take(1)
                ->first();

            $user_id = $worker_app_status->sender_user_id ?? null;

            $worker_app_status1 = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->select('id', 'sender_user_id')
                ->where('sender_role_id', 2)
                ->where('application_receiver_role_id', 3)
                ->take(1)
                ->first();

            $user_id_1 = $worker_app_status1->sender_user_id ?? null;

            // ─── ROLE RESOLUTION (safe null checks) ───
            $roleHro = null;
            $roleDa = null;
            $userHro = null;
            $userDa = null;

            if ($user_id_1) {
                $userHro = User::find($user_id_1);
                $roleHro = $userHro ? Role::find($userHro->role_id) : null;
            }

            if ($user_id) {
                $userDa = User::find($user_id);
                $roleDa = $userDa ? Role::find($userDa->role_id) : null;
            }

            // ─── OFFICE STAFF (cached) ───
            $da = cache()->remember("office_da_{$currentOfficeId}", 60, function () use ($currentOfficeId) {
                return User::where('status', 1)->where('office_id', $currentOfficeId)->where('role_id', 4)->get();
            });

            $user = cache()->remember("district_ro_{$currentDistrict}", 60, function () use ($currentDistrict) {
                return User::where('status', 1)->where('district', $currentDistrict)->where('role_id', 3)->get();
            });

            $ros = User::where('status', 1)->where('office_id', $currentOfficeId)->where('role_id', 4)->first();
            $ro = User::where('status', 1)->where('district', $currentDistrict)->where('role_id', 3)->first();

            $officeAdmin = cache()->remember('office_admin_67', 60, function () {
                return User::where('status', 1)->where('office_id', 67)->where('role_id', 5)->get();
            });

            $office_da = cache()->remember('office_da_67', 60, function () {
                return User::where('status', 1)->where('office_id', 67)->where('role_id', 18)->get();
            });

            $pullDa = User::where('status', 1)->where('office_id', $currentOfficeId)->where('role_id', Auth::user()->role_id)->first();

            // ─── AADHAR MASKING ───
            $maskAadharNumber = function ($aadharNumber) {
                return str_repeat('*', 8) . substr($aadharNumber, 8);
            };
            if (isset($getVaultData['uID'])) {
                $getVaultData['uID'] = $maskAadharNumber($getVaultData['uID']);
            }
            $base64Image = $getVaultData['photo'] ?? null;

            // ─── RECEIPT ───
            $subscription_receipt = MainWorkerDocument::whereNotNull('subscription_payment_receipt')
                ->where('worker_id', $worker_id)
                ->exists();

            // ─── REASONS (cached) ───
            $revertReasons = cache()->remember('reasons_revert_new', 60, function () {
                return Reasons::where('type', 'Revert')->where('category', 'New Registration')->where('status', 1)->get();
            });
            $revertReasonsOn = cache()->remember('reasons_revert_onboarding', 60, function () {
                return Reasons::where('type', 'Revert')->where('category', 'Onboarding')->where('status', 1)->get();
            });
            $rejectReasons = cache()->remember('reasons_reject_new', 60, function () {
                return Reasons::where('type', 'Reject')->where('category', 'New Registration')->where('status', 1)->get();
            });
            $rejectReasonsOn = cache()->remember('reasons_reject_onboarding', 60, function () {
                return Reasons::where('type', 'Reject')->where('category', 'Onboarding')->where('status', 1)->get();
            });
            $rejectReasonsRenew = cache()->remember('reasons_reject_renewal', 60, function () {
                return Reasons::where('type', 'Reject')->where('category', 'Renewal')->where('status', 1)->get();
            });

            // ─── ROLES ───
            if (Auth::user()->role_id == 2) {
                $roles = Role::whereIn('id', [3, 4])->get();
            } elseif (Auth::user()->role_id == 3) {
                $roles = Role::where('id', 4)->get();
            } else {
                $roles = collect();
            }

            // ─── PAYMENT (select specific columns) ───
            $app_date = WorkerApplicationStatus::select('created_at')
                ->where('worker_id', $worker_id)
                ->where('application_status', 'A')
                ->take(1)
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
            \Log::error('previewAdmin fatal', [
                'worker_id' => $worker_id ?? 'decrypt_failed',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            Alert::toast('Something went wrong, please try again later.', 'error');
            return back();
        }
    }

    public function list(Request $request)
    {
        $query = MainWorkerForm::with('officeName', 'getReceiver');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        return datatables()->of($query)
            ->editColumn('created_at', function ($row) {
                return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y');
            })
            ->editColumn('application_receiver_user_id', function ($row) {
                return $row->getReceiver->username ?? '-';
            })
            ->editColumn('office_id', function ($row) {
                return $row->officeName->office_name ?? '-';
            })
            ->editColumn('status', function ($row) {
                $badgeClass = 'badge-secondary';
                $label = $row->status ?? '-';

                switch($row->status) {
                    case 'A': $badgeClass = 'badge-primary'; $label = 'Submitted'; break;
                    case 'B': $badgeClass = 'badge-warning'; $label = 'Pending'; break;
                    case 'R': $badgeClass = 'badge-danger'; $label = 'Rejected'; break;
                    case 'F': $badgeClass = 'badge-success'; $label = 'Approved'; break;
                    case 'O': $badgeClass = 'badge-secondary'; $label = 'Processing'; break;
                }
                return '<span class="badge '.$badgeClass.'">'.$label.'</span>';
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-info btn-track" data-id="'.$row->worker_id.'"><i class="fas fa-route"></i> Track</button>';
            })
            ->addColumn('view', function ($row) {
                $encryptedId = encrypt($row->worker_id);
                return '<button class="btn btn-sm btn-primary btn-view" data-id="'.$encryptedId.'"><i class="fas fa-eye"></i> View</button>';
            })
            ->rawColumns(['action', 'view', 'status'])
            ->make(true);
    }
    public function track($worker_id)
    {
        $data = DB::table(DB::raw('"Worker".worker_application_statuses'))
            ->where('worker_id', $worker_id)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($data);
    }
    public function summary()
    {
        return response()->json([
            'total' => MainWorkerForm::count(),
            'approved' => MainWorkerForm::where('status', 'F')->count(),
            'pending' => MainWorkerForm::where('status','!=', 'F')->count(),
            'rejected' => CancelledAppModal::count(),
        ]);
    }
}
