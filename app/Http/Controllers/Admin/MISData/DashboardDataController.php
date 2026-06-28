<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\CancelledAppModal;
use App\Models\MainWorkerForm;
use App\Models\Office;
use App\Models\RevertBack;
use App\Models\User;
use App\Models\WorkerApplicationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardDataController extends Controller
{
    public function index(Request $request, $application_type)
    {
        $fromDateInput = $request->input('fromDate');
        $toDateInput = $request->input('toDate');
        $fromDate = $fromDateInput ? \Carbon\Carbon::parse($fromDateInput)->startOfDay() : null;
        $toDate = $toDateInput ? \Carbon\Carbon::parse($toDateInput)->endOfDay() : null;

        // Build base conditions for application type
        $mainFormConditions = function($query) use ($application_type) {
            if ($application_type == 'onboarding') {
                $query->where('already_registered', 1);
            } elseif ($application_type == 'new') {
                $query->whereNull('already_registered');
            }
        };

        $revertConditions = function($query) use ($application_type) {
            $query->where('ack_no', 'ILIKE', '%/reg/%');
            if ($application_type == 'onboarding') {
                $query->where('already_registered', 1);
            } elseif ($application_type == 'new') {
                $query->whereNull('already_registered');
            }
        };

        $cancelledConditions = function($query) use ($application_type) {
            if ($application_type == 'onboarding') {
                $query->where('already_registered', 1);
            } elseif ($application_type == 'new') {
                $query->whereNull('already_registered');
            }
        };

        // Date conditions
        $dateRange = ($fromDate && $toDate) ? [$fromDate, $toDate] : null;

        // SINGLE QUERY: Get all counts grouped by office_id from MainWorkerForm
        $mainStats = MainWorkerForm::select('office_id')
            ->selectRaw("
                COUNT(*) as total_count,
                SUM(CASE WHEN status NOT IN ('F', 'D', 'G') THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'F' THEN 1 ELSE 0 END) as approved
            ")
            ->when($dateRange, function($q) use ($dateRange) {
                $q->whereBetween('created_at', $dateRange);
            })
            ->tap($mainFormConditions)
            ->groupBy('office_id')
            ->get()
            ->keyBy('office_id');

        // SINGLE QUERY: Get approved counts by id_card_created_at (separate due to different date column)
        $approvedByIdCard = MainWorkerForm::select('office_id')
            ->selectRaw("COUNT(*) as approved_by_id_card")
            ->where('status', 'F')
            ->when($application_type == 'onboarding', function($q) {
                $q->where('already_registered', 1);
            })
            ->when($application_type == 'new', function($q) {
                $q->where(function($sq) {
                    $sq->whereNull('already_registered')->orWhere('already_registered', 0);
                });
            })
            ->when($dateRange, function($q) use ($dateRange) {
                $q->whereBetween('id_card_created_at', $dateRange);
            })
            ->groupBy('office_id')
            ->get()
            ->keyBy('office_id');

        // SINGLE QUERY: Reverted counts from RevertBack
        $revertStats = RevertBack::select('office_id')
            ->selectRaw("
                COUNT(*) as reverted,
                SUM(CASE WHEN resubmit_status = 0 THEN 1 ELSE 0 END) as revert_not_resubmitted,
                SUM(CASE WHEN resubmit_status = 1 THEN 1 ELSE 0 END) as resubmitted
            ")
            ->where('status', 'G')
            ->tap($revertConditions)
            ->when($dateRange, function($q) use ($dateRange) {
                $q->whereBetween('created_at', $dateRange);
            })
            ->groupBy('office_id')
            ->get()
            ->keyBy('office_id');

        // SINGLE QUERY: Rejected counts from CancelledAppModal
        $rejectedStats = CancelledAppModal::select('office_id')
            ->selectRaw("COUNT(*) as rejected")
            ->where('status', 'D')
            ->tap($cancelledConditions)
            ->when($dateRange, function($q) use ($dateRange) {
                $q->whereBetween('created_at', $dateRange);
            })
            ->groupBy('office_id')
            ->get()
            ->keyBy('office_id');

        // Fetch offices (single query)
        $offices = Office::select('office_id', 'office_name')
            ->where('status', 1)
            ->orderBy('office_id')
            ->get();

        // Merge all stats into offices collection
        foreach ($offices as $office) {
            $main = $mainStats[$office->office_id] ?? (object)['total_count' => 0, 'pending' => 0, 'approved' => 0];
            $approvedIdCard = $approvedByIdCard[$office->office_id]->approved_by_id_card ?? 0;
            $revert = $revertStats[$office->office_id] ?? (object)['reverted' => 0, 'revert_not_resubmitted' => 0, 'resubmitted' => 0];
            $rejected = $rejectedStats[$office->office_id]->rejected ?? 0;

            // Use id_card_created_at based approved count if date filter is active, else use status-based
            $office->approved = $dateRange ? $approvedIdCard : $main->approved;
            $office->pending = $main->pending;
            $office->rejected = $rejected;
            $office->reverted = $revert->reverted;
            $office->revert_resubmitted = $revert->resubmitted;

            // Total = main forms + not resubmitted reverts + rejected
            $office->total_count = $main->total_count + $revert->revert_not_resubmitted + $rejected;
        }

        return view('admin.mis-data.dashboard-details.index', compact('offices', 'application_type', 'fromDate', 'toDate'));
    }

    // Keep helper methods for UserWiseData or remove if unused elsewhere
    public function UserWiseData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fromDate' => 'nullable|date',
            'toDate' => 'nullable|date',
            'office_id' => 'required|exists:pgsql.Masterdata.offices,office_id',
            'application_type' => 'required|in:onboarding,new,all',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $fromDate = $request->input('fromDate') ? \Carbon\Carbon::parse($request->input('fromDate'))->startOfDay() : null;
            $toDate = $request->input('toDate') ? \Carbon\Carbon::parse($request->input('toDate'))->endOfDay() : null;

            if ($fromDate && $toDate && $fromDate->greaterThan($toDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'From date cannot be greater than To date.',
                ]);
            }

            $users = User::where('office_id', $request->office_id)
                ->whereIn('role_id', [2, 3, 4])
                ->orderBy('role_id')
                ->get();

            $userIds = $users->pluck('id')->toArray();

            // SINGLE AGGREGATED QUERY for MainWorkerForm stats
            $mainStats = MainWorkerForm::select('application_receiver_user_id')
                ->selectRaw("
                    COUNT(*) as total,
                    SUM(CASE WHEN status NOT IN ('F', 'D', 'G') THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'F' THEN 1 ELSE 0 END) as approved,
                    SUM(CASE WHEN resubmit_status = 1 THEN 1 ELSE 0 END) as resubmitted
                ")
                ->whereIn('application_receiver_user_id', $userIds)
                ->when($request->application_type == 'onboarding', function($q) {
                    $q->where('already_registered', 1);
                })
                ->when($request->application_type == 'new', function($q) {
                    $q->whereNull('already_registered');
                })
                ->when($fromDate && $toDate, function($q) use ($fromDate, $toDate) {
                    $q->whereBetween('created_at', [$fromDate, $toDate]);
                })
                ->groupBy('application_receiver_user_id')
                ->get()
                ->keyBy('application_receiver_user_id');

            // Handle role_id=2 null receiver case
            $nullReceiverStats = null;
            if ($users->contains('role_id', 2)) {
                $nullReceiverStats = MainWorkerForm::selectRaw("
                    COUNT(*) as total,
                    SUM(CASE WHEN status NOT IN ('F', 'D', 'G') THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'F' THEN 1 ELSE 0 END) as approved,
                    SUM(CASE WHEN resubmit_status = 1 THEN 1 ELSE 0 END) as resubmitted
                ")
                    ->whereNull('application_receiver_user_id')
                    ->where('office_id', $request->office_id)
                    ->when($request->application_type == 'onboarding', function($q) {
                        $q->where('already_registered', 1);
                    })
                    ->when($request->application_type == 'new', function($q) {
                        $q->whereNull('already_registered');
                    })
                    ->when($fromDate && $toDate, function($q) use ($fromDate, $toDate) {
                        $q->whereBetween('created_at', [$fromDate, $toDate]);
                    })
                    ->first();
            }

            // SINGLE QUERY for rejected (status D)
            $rejectedStats = WorkerApplicationStatus::select('application_receiver_user_id')
                ->selectRaw("COUNT(*) as rejected")
                ->where('application_status', 'D')
                ->where('is_renewal', 0)
                ->whereIn('application_receiver_user_id', $userIds)
                ->when($fromDate && $toDate, function($q) use ($fromDate, $toDate) {
                    $q->whereBetween('created_at', [$fromDate, $toDate]);
                })
                ->groupBy('application_receiver_user_id')
                ->get()
                ->keyBy('application_receiver_user_id');

            // SINGLE QUERY for reverted (status G)
            $revertedStats = WorkerApplicationStatus::select('application_receiver_user_id')
                ->selectRaw("COUNT(*) as reverted")
                ->where('application_status', 'G')
                ->where('is_renewal', 0)
                ->whereIn('application_receiver_user_id', $userIds)
                ->when($fromDate && $toDate, function($q) use ($fromDate, $toDate) {
                    $q->whereBetween('created_at', [$fromDate, $toDate]);
                })
                ->groupBy('application_receiver_user_id')
                ->get()
                ->keyBy('application_receiver_user_id');

            foreach ($users as $user) {
                $main = $mainStats[$user->id] ?? (object)['total' => 0, 'pending' => 0, 'approved' => 0, 'resubmitted' => 0];

                // Add null receiver stats for role_id=2
                if ($user->role_id == 2 && $nullReceiverStats) {
                    $main->total += $nullReceiverStats->total;
                    $main->pending += $nullReceiverStats->pending;
                    $main->approved += $nullReceiverStats->approved;
                    $main->resubmitted += $nullReceiverStats->resubmitted;
                }

                $rejected = $rejectedStats[$user->id]->rejected ?? 0;
                $reverted = $revertedStats[$user->id]->reverted ?? 0;

                $user->pendingApplicationCount = $main->pending;
                $user->approvedApplicationCount = $main->approved;
                $user->rejectedApplicationCount = $rejected;
                $user->revertedApplicationCount = $reverted;
                $user->revert_resubmitted = $main->resubmitted;
                $user->revertNotResubmittedCount = $reverted - $main->resubmitted;
                $user->total_count = $main->pending + $main->approved + $rejected + $reverted - $main->resubmitted;
            }

            return response()->json([
                'status' => true,
                'message' => 'User data retrieved successfully.',
                'data' => $users,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
