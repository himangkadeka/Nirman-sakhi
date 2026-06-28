<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerForm;
use App\Models\Office;
use App\Models\RenewWorkerForm;
use App\Models\RevertBack;
use App\Models\WorkerApplicationStatus;
use App\Models\CancelledAppModal;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Exports\OfficeExport;
use Maatwebsite\Excel\Facades\Excel;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class OfficeWiseDataController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $query = Office::orderBy('office_id');


        if ($search) {
            // $query->where('office_name', 'like', "%{$search}%");
            $query->whereRaw('LOWER(office_name) LIKE ?', ['%' . strtolower($search) . '%']);

        }

        $offices = $query->paginate(10)->appends([
            'search' => $search,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ]);

        if ($fromDate && $toDate) {
            $fromDate = \Carbon\Carbon::parse($fromDate)->startOfDay();
            $toDate = \Carbon\Carbon::parse($toDate)->endOfDay();

            $offices->getCollection()->transform(function ($office) use ($fromDate, $toDate) {
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

                $office->new_approved = MainWorkerForm::where('office_id', $office->office_id)
                    ->where('status', 'F')
                    ->whereNull('already_registered')
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->on_approved = MainWorkerForm::where('office_id', $office->office_id)
                    ->where('status', 'F')
                    ->where('already_registered', 1)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->rejected = CancelledAppModal::where('office_id', $office->office_id)
                    ->where('status', 'D')
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->reverted = RevertBack::where('office_id', $office->office_id)
                    ->where('status', 'G')
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                return $office;
            });
        } else {
            foreach ($offices as $office) {
                $office->total_count = $office->getCount($office->office_id);
                $office->new_registrations = $office->newRegistrationsCount($office->office_id);
                $office->onboarding = $office->alreadyRegisteredCount($office->office_id);
                $office->pending = $office->pendingApplicationCount($office->office_id);
                $office->new_approved = $office->newApprovedApplicationCount($office->office_id);
                $office->on_approved = $office->OnApprovedApplicationCount($office->office_id);
                $office->approved = $office->approvedApplicationCount($office->office_id);
                $office->rejected = $office->rejectedApplicationCount($office->office_id);
                $office->reverted = $office->revertedApplicationCount($office->office_id);
            }
        }
        return view('admin.mis-data.office-wise-data.index', compact('offices'));
    }


    public function export(Request $request, $type)
    {
        $fromDate = $request->fromDate ? \Carbon\Carbon::parse($request->fromDate)->startOfDay() : null;
        $toDate = $request->toDate ? \Carbon\Carbon::parse($request->toDate)->endOfDay() : null;
        $search = $request->search;

        $query = Office::orderBy('office_id');

        if ($search) {
            $query->whereRaw('LOWER(office_name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $offices = $query->get();

        foreach ($offices as $office) {
            if ($fromDate && $toDate) {
                $office->total_count = MainWorkerForm::where('office_id', $office->office_id)->whereBetween('created_at', [$fromDate, $toDate])->count();
                $office->new_registrations = MainWorkerForm::where('office_id', $office->office_id)->whereNull('already_registered')->whereBetween('created_at', [$fromDate, $toDate])->count();
                $office->onboarding = MainWorkerForm::where('office_id', $office->office_id)->where('already_registered', 1)->whereBetween('created_at', [$fromDate, $toDate])->count();
                $office->pending = MainWorkerForm::where('office_id', $office->office_id)->whereNotIn('status', ['F', 'D', 'G'])->whereBetween('created_at', [$fromDate, $toDate])->count();
                $office->new_approved = MainWorkerForm::where('office_id', $office->office_id)->where('status', 'F')->whereNull('already_registered')->whereBetween('created_at', [$fromDate, $toDate])->count();
                $office->on_approved = MainWorkerForm::where('office_id', $office->office_id)->where('status', 'F')->where('already_registered', 1)->whereBetween('created_at', [$fromDate, $toDate])->count();
                $office->rejected = CancelledAppModal::where('office_id', $office->office_id)->where('status', 'D')->whereBetween('created_at', [$fromDate, $toDate])->count();
                $office->reverted = RevertBack::where('office_id', $office->office_id)->where('status', 'G')->whereBetween('created_at', [$fromDate, $toDate])->count();
            } else {
                $office->total_count = $office->getCount($office->office_id);
                $office->new_registrations = $office->newRegistrationsCount($office->office_id);
                $office->onboarding = $office->alreadyRegisteredCount($office->office_id);
                $office->pending = $office->pendingApplicationCount($office->office_id);
                $office->new_approved = $office->newApprovedApplicationCount($office->office_id);
                $office->on_approved = $office->OnApprovedApplicationCount($office->office_id);
                $office->rejected = $office->rejectedApplicationCount($office->office_id);
                $office->reverted = $office->revertedApplicationCount($office->office_id);
            }

            $office->approved = $office->new_approved + $office->on_approved;
        }

        if ($type === 'pdf') {
            $pdf = PDF::loadView('admin.mis-data.office-wise-data.export-pdf', ['data' => $offices]);
            return $pdf->download('ABOCWWB Admin Office Wise Data.pdf');
        }

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(new OfficeExport($offices), 'offices.' . $type);
        }

        abort(404, 'Invalid export format.');
    }


    public function getUserData($office_id)
    {
        $users = User::where('office_id', $office_id)
            ->whereIn('role_id', [2, 3, 4])
            ->where('status', 1)
            ->orderBy('role_id')
            ->get();

        return view('admin.mis-data.office-wise-data.user-wise', compact('users', 'office_id'));
    }

    public function filterData(Request $request)
    {
        $fromDateInput = $request->input('fromDate');
        $toDateInput = $request->input('toDate');
        $search = $request->input('search');

        if (($fromDateInput && !$toDateInput) || (!$fromDateInput && $toDateInput)) {
            return redirect()->route('admin.officewise.index')->with('error', 'Please select both dates.');
        }

        $hasDateRange = $fromDateInput && $toDateInput;

        $fromDate = $hasDateRange ? \Carbon\Carbon::parse($fromDateInput)->startOfDay() : null;
        $toDate = $hasDateRange ? \Carbon\Carbon::parse($toDateInput)->endOfDay() : null;

        $query = Office::orderBy('office_id');

        if ($search) {
            $query->whereRaw('LOWER(office_name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $offices = $query->paginate(10)->appends([
            'fromDate' => $fromDateInput,
            'toDate' => $toDateInput,
            'search' => $search,
        ]);

        $offices->getCollection()->transform(function ($office) use ($hasDateRange, $fromDate, $toDate) {
            if ($hasDateRange) {
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

                $office->new_approved = MainWorkerForm::where('office_id', $office->office_id)
                    ->where('status', 'F')
                    ->whereNull('already_registered')
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->on_approved = MainWorkerForm::where('office_id', $office->office_id)
                    ->where('status', 'F')
                    ->where('already_registered', 1)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->rejected = CancelledAppModal::where('office_id', $office->office_id)
                    ->where('status', 'D')
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->reverted = RevertBack::where('office_id', $office->office_id)
                    ->where('status', 'G')
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();
            } else {
                $office->total_count = $office->getCount($office->office_id);
                $office->new_registrations = $office->newRegistrationsCount($office->office_id);
                $office->onboarding = $office->alreadyRegisteredCount($office->office_id);
                $office->pending = $office->pendingApplicationCount($office->office_id);
                $office->new_approved = $office->newApprovedApplicationCount($office->office_id);
                $office->on_approved = $office->OnApprovedApplicationCount($office->office_id);
                $office->rejected = $office->rejectedApplicationCount($office->office_id);
                $office->reverted = $office->revertedApplicationCount($office->office_id);
            }

            return $office;
        });

        return view('admin.mis-data.office-wise-data.index', compact('offices', 'fromDate', 'toDate', 'search'));
    }

    public function indexRenewal(Request $request)
    {
        $search = $request->input('search');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $query = Office::orderBy('office_id');


        if ($search) {
            // $query->where('office_name', 'like', "%{$search}%");
            $query->whereRaw('LOWER(office_name) LIKE ?', ['%' . strtolower($search) . '%']);

        }

        $offices = $query->paginate(10)->appends([
            'search' => $search,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ]);

        if ($fromDate && $toDate) {
            $fromDate = \Carbon\Carbon::parse($fromDate)->startOfDay();
            $toDate = \Carbon\Carbon::parse($toDate)->endOfDay();

            $offices->getCollection()->transform(function ($office) use ($fromDate, $toDate) {
                $office->total_count = RenewWorkerForm::where('office_id', $office->office_id)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->new_registrations = RenewWorkerForm::where('office_id', $office->office_id)
                    ->whereNull('already_registered')
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->onboarding = RenewWorkerForm::where('office_id', $office->office_id)
                    ->where('already_registered', 1)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->pending = RenewWorkerForm::where('office_id', $office->office_id)
                    ->whereNotIn('status', ['F', 'D', 'G'])
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->new_approved = RenewWorkerForm::where('office_id', $office->office_id)
                    ->where('status', 'F')
                    ->whereNull('already_registered')
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $office->on_approved = RenewWorkerForm::where('office_id', $office->office_id)
                    ->where('status', 'F')
                    ->where('already_registered', 1)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

//                $office->rejected = CancelledAppModal::where('office_id', $office->office_id)
//                    ->where('status', 'D')
//                    ->whereBetween('created_at', [$fromDate, $toDate])
//                    ->count();
                $office->rejected = 0;

                $office->reverted = RevertBack::where('office_id', $office->office_id)
                    ->where('status', 'G')
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                return $office;
            });
        } else {
            foreach ($offices as $office) {
                $office->total_count = $office->getCount($office->office_id);
                $office->new_registrations = $office->newRegistrationsCount($office->office_id);
                $office->onboarding = $office->alreadyRegisteredCount($office->office_id);
                $office->pending = $office->pendingApplicationCount($office->office_id);
                $office->new_approved = $office->newApprovedApplicationCount($office->office_id);
                $office->on_approved = $office->OnApprovedApplicationCount($office->office_id);
                $office->approved = $office->approvedApplicationCount($office->office_id);
                $office->rejected = $office->rejectedApplicationCount($office->office_id);
                $office->reverted = $office->revertedApplicationCount($office->office_id);
            }
        }
        return view('admin.mis-data.office-wise-data.renewal.index', compact('offices'));
    }



    // public function filterData(Request $request)
    // {
    //     $fromDate = $request->input('fromDate');
    //     $toDate = $request->input('toDate');


    //     if (!$fromDate || !$toDate) {
    //         return redirect()->route('admin.officewise.index')->with('error', 'Please select both dates.');
    //     }

    //     $fromDate = \Carbon\Carbon::parse($fromDate)->startOfDay();
    //     $toDate = \Carbon\Carbon::parse($toDate)->endOfDay();

    //     $offices = Office::orderBy('office_id')->get();

    //     foreach ($offices as $office) {
    //         $office->total_count = RenewWorkerForm::where('office_id', $office->office_id)
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->count();

    //         $office->new_registrations = MainWorkerForm::where('office_id', $office->office_id)
    //             ->whereNull('already_registered')
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->count();

    //         $office->onboarding = MainWorkerForm::where('office_id', $office->office_id)
    //             ->where('already_registered', 1)
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->count();

    //         $office->pending = MainWorkerForm::where('office_id', $office->office_id)
    //             ->whereNotIn('status', ['F', 'D', 'G'])
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->count();

    //         $office->new_approved = MainWorkerForm::where('office_id', $office->office_id)
    //             ->where('status', 'F')
    //             ->whereNull('already_registered')
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->count();

    //         $office->on_approved = MainWorkerForm::where('office_id', $office->office_id)
    //             ->where('status', 'F')
    //             ->where('already_registered', 1)
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->count();

    //         $office->rejected = CancelledAppModal::where('office_id', $office->office_id)
    //             ->where('status', 'D')
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->count();

    //         $office->reverted = RevertBack::where('office_id', $office->office_id)
    //             ->where('status', 'G')
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->count();
    //     }

    //     return view('admin.mis-data.office-wise-data.index', compact('offices', 'fromDate', 'toDate'));
    // }

    public function filterUserData(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $office_id = $request->input('office_id');

        if (!$fromDate || !$toDate || !$office_id) {
            return redirect()->back()->with('error', 'Please select office and both dates.');
        }

        $office = Office::find($office_id);
        if (!$office) {
            return redirect()->back()->with('error', 'Invalid office selected.');
        }

        $fromDate = \Carbon\Carbon::parse($fromDate)->startOfDay();
        $toDate = \Carbon\Carbon::parse($toDate)->endOfDay();

        $users = User::where('office_id', $office_id)
            ->whereIn('role_id', [2, 3, 4])
            // ->where('status', 1)
            ->orderBy('role_id')
            ->get();

        foreach ($users as $user) {

            $user->total_count = MainWorkerForm::where('office_id', $user->office_id)->where(function ($query) use ($user) {
                $query->when($user->role_id == 2, function ($q) use ($user) {
                    $q->where('application_receiver_user_id', $user->id)
                        ->orWhereNull('application_receiver_user_id');
                }, function ($q) use ($user) {
                    $q->where('application_receiver_user_id', $user->id);
                });
            })
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->count();

            $user->new_registrations = MainWorkerForm::where('office_id', $user->office_id)->where(function ($query) use ($user) {
                $query->when($user->role_id == 2, function ($q) use ($user) {
                    $q->where('application_receiver_user_id', $user->id)
                        ->orWhereNull('application_receiver_user_id');
                }, function ($q) use ($user) {
                    $q->where('application_receiver_user_id', $user->id);
                });
            })
                ->whereNull('already_registered')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->count();

            $user->onboarding = MainWorkerForm::where('office_id', $user->office_id)->where(function ($query) use ($user) {
                $query->when($user->role_id == 2, function ($q) use ($user) {
                    $q->where('application_receiver_user_id', $user->id)
                        ->orWhereNull('application_receiver_user_id');
                }, function ($q) use ($user) {
                    $q->where('application_receiver_user_id', $user->id);
                });
            })
                ->where('already_registered', 1)
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->count();

            $user->pending = MainWorkerForm::where('office_id', $user->office_id)->where(function ($query) use ($user) {
                $query->when($user->role_id == 2, function ($q) use ($user) {
                    $q->where('application_receiver_user_id', $user->id)
                        ->orWhereNull('application_receiver_user_id');
                }, function ($q) use ($user) {
                    $q->where('application_receiver_user_id', $user->id);
                });
            })
                ->whereNotIn('status', ['F', 'D', 'G'])
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->count();

            $user->new_approved = MainWorkerForm::where('office_id', $user->office_id)
                ->where('application_receiver_user_id', $user->id)
                ->where('status', 'F')
                ->whereNull('already_registered')
                ->whereBetween('id_card_created_at', [$fromDate, $toDate])
                ->count();

            $user->on_approved = MainWorkerForm::where('office_id', $user->office_id)
                ->where('application_receiver_user_id', $user->id)
                ->where('status', 'F')
                ->where('already_registered',1)
                ->whereBetween('id_card_created_at', [$fromDate, $toDate])
                ->count();
        }


        return view('admin.mis-data.office-wise-data.user-wise', ['users' => $users, 'office_id' => $office_id, 'fromDate' => $fromDate, 'toDate' => $toDate]);
    }
}
