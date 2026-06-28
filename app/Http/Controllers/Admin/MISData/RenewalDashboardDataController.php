<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\RenewWorkerForm;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\RevertBack;
use App\Models\CancelledAppModal;
use App\Models\MainWorkerForm;
use App\Models\User;
use App\Models\WorkerApplicationStatus;
use Illuminate\Support\Facades\Validator;

class RenewalDashboardDataController extends Controller
{
    public function index(Request $request, $application_type)
    {
        $fromDateInput = $request->input('fromDate');
        $toDateInput = $request->input('toDate');
        $fromDate = $fromDateInput ? \Carbon\Carbon::parse($fromDateInput)->startOfDay() : null;
        $toDate = $toDateInput ? \Carbon\Carbon::parse($toDateInput)->endOfDay() : null;


        $offices = Office::select('office_id', 'office_name')->orderBy('office_id')->get();
        foreach ($offices as $office) {
//            $office->total_count = $this->getCount($office->office_id, $application_type, $fromDate, $toDate) + $this->getrevertNotResubmittedCount($office->office_id, $application_type, $fromDate, $toDate) + $this->rejectedApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
            $office->total_count = $this->getCount($office->office_id, $application_type, $fromDate, $toDate);
            $office->pending = $this->pendingApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
            $office->approved = $this->approvedApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
            $office->rejected = $this->rejectedApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
            $office->reverted = $this->revertedApplicationCount($office->office_id, $application_type, $fromDate, $toDate);
            $office->revert_resubmitted =  $this->revertedApplicationCount($office->office_id, $application_type, $fromDate, $toDate) - $this->getrevertNotResubmittedCount($office->office_id, $application_type, $fromDate, $toDate);
        }

        // return response()->json([
        //     'offices' => $offices,
        // ]);
        return view('admin.mis-data.dashboard-details.renewal-index', compact('offices', 'application_type', 'fromDate', 'toDate'));
    }


    public function getCount($office_id, $application_type, $fromDate = null, $toDate = null)
    {
        $query = RenewWorkerForm::where('office_id', $office_id);
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
            ->where('ack_no', 'LIKE', '%/REN/%');

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
        $query = RenewWorkerForm::where('office_id', $office_id)->whereNotIn('status', ['F', 'D', 'G']);
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
        $query = RenewWorkerForm::where('office_id', $office_id)->where('status', 'F');
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
        $query = RevertBack::where('office_id', $office_id)
            ->where('status', 'G')
            ->where('ack_no', 'LIKE', '%REN%');

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


    public function UserWiseData(Request $request)
    {
        // return "fdh";
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
            $users = User::where('office_id', $request->office_id)
                ->whereIn('role_id', [2, 3, 4])
                ->orderBy('role_id')
                ->get();

            $fromDate = $request->input('fromDate') ? \Carbon\Carbon::parse($request->input('fromDate'))->startOfDay() : null;
            $toDate = $request->input('toDate') ? \Carbon\Carbon::parse($request->input('toDate'))->endOfDay() : null;
            if ($fromDate && $toDate && $fromDate->greaterThan($toDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'From date cannot be greater than To date.',
                ]);
            }
            foreach ($users as $user) {
                $query = RenewWorkerForm::where('application_receiver_user_id', $user->id);
                $query1 = WorkerApplicationStatus::where('application_status', 'D')->where('application_receiver_user_id', $user->id)->where('is_renewal',1);
                $query2 = WorkerApplicationStatus::where('application_status', 'G')->where('application_receiver_user_id', $user->id)->where('is_renewal',1);
                if ($fromDate && $toDate) {
                    $query->whereBetween('created_at', [$fromDate, $toDate]);
                    $query1->whereBetween('created_at', [$fromDate, $toDate]);
                    $query2->whereBetween('created_at', [$fromDate, $toDate]);
                }
                if($user->role_id==2){
                    $query->orWhere('application_receiver_user_id', null)->where('office_id', $user->office_id);
                }

                // Filter by application_type
                if ($request->application_type == 'onboarding') {
                    $query->where('already_registered', 1);
                } elseif ($request->application_type == 'new') {
                    $query->whereNull('already_registered');
                }
                $user->pendingApplicationCount = (clone $query)->whereNotIn('status', ['F', 'D', 'G'])->count();
                $user->approvedApplicationCount = (clone $query)->where('status', 'F')->count();
                $user->rejectedApplicationCount = (clone $query1)->count();
                $user->revertedApplicationCount = (clone $query2)->count();
                $user->revert_resubmitted = (clone $query)->where('resubmit_status', 1)->count();
                $user->revertNotResubmittedCount = $user->revertedApplicationCount-$user->revert_resubmitted;
                $user->total_count = $user->pendingApplicationCount+$user->approvedApplicationCount+$user->rejectedApplicationCount+$user->revertedApplicationCount-$user->revert_resubmitted;
            }

            return response()->json([
                'status' => true,
                'message' => 'User data retrieved successfully.',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e,
            ]);
        }
    }
}
