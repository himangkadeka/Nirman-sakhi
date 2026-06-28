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

class AllUsersDataController extends Controller
{
    public function index(Request $request)
    {
        $users = User::whereIn('role_id', [2, 3, 4])
            ->orderBy('role_id')
            ->get();

        return view('admin.mis-data.all-users.index', compact('users'));
    }



    public function getUserCount($fromDate = null, $toDate = null, $user = null)
    {
        $query = MainWorkerForm::query();

        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        if ($user) {
            $query->where(function ($q) use ($user) {
                $q->when($user->role_id == 2, function ($q2) use ($user) {
                    $q2->where('application_receiver_user_id', $user->id)
                        ->orWhereNull('application_receiver_user_id');
                }, function ($q2) use ($user) {
                    $q2->where('application_receiver_user_id', $user->id);
                });
            });
        }

        return $query->count();
    }


    // public function getrevertNotResubmittedCount($fromDate = null, $toDate = null, $user = null)
    // {
    //     $query = RevertBack::where('resubmit_status', 0);

    //     if ($fromDate && $toDate) {
    //         $query->whereBetween('created_at', [$fromDate, $toDate]);
    //     }

    //     if ($user) {
    //         $query->where('office_id', $user->office_id)
    //             ->where('application_receiver_user_id', $user->id);
    //     }

    //     return $query->count();
    // }


    public function pendingApplicationCount($fromDate = null, $toDate = null, $user = null)
    {
        $query = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G']);

        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        if ($user) {
            $query->where('office_id', $user->office_id)
                ->where(function ($q) use ($user) {
                    $q->when($user->role_id == 2, function ($q2) use ($user) {
                        $q2->where('application_receiver_user_id', $user->id)
                            ->orWhereNull('application_receiver_user_id');
                    }, function ($q2) use ($user) {
                        $q2->where('application_receiver_user_id', $user->id);
                    });
                });
        }

        return $query->count();
    }


    public function approvedApplicationCount($fromDate = null, $toDate = null, $user = null)
    {
        $query = MainWorkerForm::where('status', 'F');

        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        if ($user) {
            $query->where('office_id', $user->office_id)
                ->where(function ($q) use ($user) {
                    $q->when($user->role_id == 2, function ($q2) use ($user) {
                        $q2->where('application_receiver_user_id', $user->id)
                            ->orWhereNull('application_receiver_user_id');
                    }, function ($q2) use ($user) {
                        $q2->where('application_receiver_user_id', $user->id);
                    });
                });
        }

        return $query->count();
    }


    public function rejectedApplicationCount($fromDate = null, $toDate = null, $user = null)
    {
        $query = CancelledAppModal::where('status', 'D');

        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        if ($user) {
            $query->where('office_id', $user->office_id)
                ->where('application_receiver_user_id', $user->id);
        }

        return $query->count();
    }


    // public function revertedApplicationCount($fromDate = null, $toDate = null, $user = null)
    // {
    //     $query = RevertBack::where('status', 'G');

    //     if ($fromDate && $toDate) {
    //         $query->whereBetween('created_at', [$fromDate, $toDate]);
    //     }

    //     if ($user) {
    //         $query->where('office_id', $user->office_id)
    //             ->where('application_receiver_user_id', $user->id);
    //     }

    //     return $query->count();
    // }

    public function filterUserData(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        if (!$fromDate || !$toDate) {
            return redirect()->back()->with('error', 'Please select both dates.');
        }

        $fromDate = \Carbon\Carbon::parse($fromDate)->startOfDay();
        $toDate = \Carbon\Carbon::parse($toDate)->endOfDay();

        $users = User::whereIn('role_id', [2, 3, 4])
            ->orderBy('role_id')
            ->get();

        foreach ($users as $user) {
            // Total count
            $totalQuery = MainWorkerForm::where('office_id', $user->office_id)
                ->whereBetween('created_at', [$fromDate, $toDate]);

            if ($user->role_id == 2) {
                $totalQuery->where(function ($q) use ($user) {
                    $q->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user->id);
                });
            } else {
                $totalQuery->where('application_receiver_user_id', $user->id);
            }
            $user->total_count = $totalQuery->count();

            // New registrations
            $newRegQuery = MainWorkerForm::where('office_id', $user->office_id)
                ->whereNull('already_registered')
                ->whereBetween('created_at', [$fromDate, $toDate]);

            if ($user->role_id == 2) {
                $newRegQuery->where(function ($q) use ($user) {
                    $q->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user->id);
                });
            } else {
                $newRegQuery->where('application_receiver_user_id', $user->id);
            }
            $user->new_registrations = $newRegQuery->count();

            // Onboarding
            $onboardingQuery = MainWorkerForm::where('office_id', $user->office_id)
                ->where('already_registered', 1)
                ->whereBetween('created_at', [$fromDate, $toDate]);

            if ($user->role_id == 2) {
                $onboardingQuery->where(function ($q) use ($user) {
                    $q->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user->id);
                });
            } else {
                $onboardingQuery->where('application_receiver_user_id', $user->id);
            }
            $user->onboarding = $onboardingQuery->count();

            // Pending
            $pendingQuery = MainWorkerForm::where('office_id', $user->office_id)
                ->whereNotIn('status', ['F', 'D', 'G'])
                ->whereBetween('created_at', [$fromDate, $toDate]);

            if ($user->role_id == 2) {
                $pendingQuery->where(function ($q) use ($user) {
                    $q->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user->id);
                });
            } else {
                $pendingQuery->where('application_receiver_user_id', $user->id);
            }
            $user->pending = $pendingQuery->count();

            // New Approved
            $newApprovedQuery = MainWorkerForm::where('office_id', $user->office_id)
                ->where('status', 'F')
                ->whereNull('already_registered')
                ->whereBetween('created_at', [$fromDate, $toDate]);

            if ($user->role_id == 2) {
                $newApprovedQuery->where(function ($q) use ($user) {
                    $q->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user->id);
                });
            } else {
                $newApprovedQuery->where('application_receiver_user_id', $user->id);
            }
            $user->new_approved = $newApprovedQuery->count();

            // Onboarding Approved
            $onApprovedQuery = MainWorkerForm::where('office_id', $user->office_id)
                ->where('status', 'F')
                ->where('already_registered', 1)
                ->whereBetween('created_at', [$fromDate, $toDate]);

            if ($user->role_id == 2) {
                $onApprovedQuery->where(function ($q) use ($user) {
                    $q->whereNull('application_receiver_user_id')
                        ->orWhere('application_receiver_user_id', $user->id);
                });
            } else {
                $onApprovedQuery->where('application_receiver_user_id', $user->id);
            }
            $user->on_approved = $onApprovedQuery->count();
        }

        return view('admin.mis-data.all-users.index', [
            'users' => $users,
            'fromDate' => $fromDate,
            'toDate' => $toDate
        ]);
    }
}
