<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerForm;
use App\Models\Office;
use App\Models\District;
use App\Models\WorkerApplicationStatus;
use App\Exports\ApplicationStatusReportExport;
use App\Exports\CombinedApplicationStatusExport;
use App\Exports\OneClickApplicationStatusExport;
use App\Exports\OfficeRoleApplicationExport;
use Maatwebsite\Excel\Facades\Excel;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Carbon\Carbon; // Import Carbon for date calculations
use Illuminate\Http\Request;

class AppliucationStatusDataController extends Controller
{


    public function index()
    {
        $users = User::where('role_id', '<>', 6)->orderBY('id')->get();
        $offices = Office::orderBy('office_id')->get();
        $districts = District::where('status', 1)->where('state_code', 18)->orderBy('district_name')->get();
        //   $roles     = Role::get();

        $roles = Role::where('id', '<>', 6)->get();
        return view('admin.mis-data.application-statuses.index', compact('offices', 'districts', 'roles','users'));
    }
    public function getRolesByOffice($office_id)
    {
        $roles = Role::whereIn('id', [2, 3, 4])
            ->whereIn('id', function ($query) use ($office_id) {
                $query->select('role_id')
                    ->from('User.users')
                    ->where('office_id', $office_id)
                    ->where('role_id', '<>', 6)
                    ->distinct();
            })->get(['id', 'name']);

        return response()->json($roles);
    }


    // public function exportFiltered(Request $request, $type)
    // {
    //     $officerId = $request->query('officer');
    //     $officeId = $request->query('office');
    //     $roleId = $request->query('role');
    //     $registrationType = $request->query('type');
    //     $fromDate = $request->query('fromDate');
    //     $toDate = $request->query('toDate');

    //     // Validate officer selection
    //     if (!$officerId) {
    //         return back()->with('error', 'Please select an officer to export data.');
    //     }

    //     $officer = User::find($officerId);
    //     if (!$officer) {
    //         return back()->with('error', 'Officer not found.');
    //     }

    //     $export = new \App\Exports\FilteredApplicationStatusExport(
    //         $officerId,
    //         $officeId,
    //         $roleId,
    //         $registrationType,
    //         $fromDate,
    //         $toDate
    //     );

    //     $fileName = 'Application_Status_' .
    //         str_replace(' ', '_', $officer->firstname . '_' . $officer->lastname) .
    //         '_' . date('Y-m-d_His') .
    //         '.' . $type;

    //     // For Excel/CSV exports
    //     if ($type === 'xlsx' || $type === 'csv') {
    //         return Excel::download($export, $fileName);
    //     }

    //     // For PDF export
    //     if ($type === 'pdf') {
    //         // Build query same as export
    //         $query = WorkerApplicationStatus::with(['mainWorker'])
    //             ->where('application_receiver_user_id', $officerId);

    //         // Apply registration type filter
    //         if ($registrationType === 'onboarding') {
    //             $query->whereHas('mainWorker', fn($q) => $q->where('already_registered', 1));
    //         } elseif ($registrationType === 'new') {
    //             $query->whereHas('mainWorker', function ($q) {
    //                 $q->where(fn($sq) => $sq->where('already_registered', 0)->orWhereNull('already_registered'));
    //             });
    //         }

    //         // Apply date filters
    //         if ($fromDate && $toDate) {
    //             $query->whereBetween('created_at', [
    //                 Carbon::parse($fromDate)->startOfDay(),
    //                 Carbon::parse($toDate)->endOfDay()
    //             ]);
    //         }

    //         $applications = $query->orderBy('created_at', 'asc')->get();

    //         // Add ranks and status
    //         $applications = $applications->map(function ($app, $index) {
    //             $app->received_rank = $index + 1;

    //             // Calculate duration
    //             $app->duration_days = Carbon::parse($app->created_at)->diffInDays(Carbon::now());

    //             // Registration type
    //             $app->registration_type = ($app->mainWorker && $app->mainWorker->already_registered == 1)
    //                 ? 'Onboarding'
    //                 : 'New Registration';

    //             // Action taken date
    //             $app->action_taken_date = ($app->updated_at && $app->updated_at != $app->created_at)
    //                 ? $app->updated_at
    //                 : null;

    //             // FIFO
    //             if (isset($app->action_taken_rank)) {
    //                 $app->fifo = ($app->received_rank == $app->action_taken_rank) ? 'Yes' : 'No';
    //             } else {
    //                 $app->fifo = 'Pending';
    //             }

    //             // Status text
    //             $app->status_text = match (true) {
    //                 $app->application_status === 'A' => 'Application Submitted',
    //                 $app->application_status === 'B' && $app->da_forward == 1 => 'Sent By DA',
    //                 $app->application_status === 'B' && $app->pull_back == 1 => 'Pulled Back',
    //                 $app->application_status === 'B' => 'Forwarded By DA',
    //                 $app->application_status === 'C' => 'Forwarded By RO',
    //                 $app->application_status === 'D' => 'Application Rejected',
    //                 $app->application_status === 'E' => 'Pulled Back from DA',
    //                 $app->application_status === 'F' => 'Application Approved',
    //                 $app->application_status === 'G' => 'Application Reverted',
    //                 default => 'Unknown Status',
    //             };

    //             return $app;
    //         });

    //         $filterInfo = [
    //             'office' => $officer->office->office_name ?? 'N/A',
    //             'officer' => trim(($officer->firstname ?? '') . ' ' . ($officer->lastname ?? '')) ?: 'N/A',
    //             'role' => $officer->roles->first()->name ?? 'N/A',
    //             'registration_type' => $registrationType ? ($registrationType === 'onboarding' ? 'Onboarding' : 'New Registration') : 'All',
    //             'date_range' => ($fromDate && $toDate)
    //                 ? Carbon::parse($fromDate)->format('d-m-Y') . ' to ' . Carbon::parse($toDate)->format('d-m-Y')
    //                 : 'All Dates',
    //             'total' => $applications->count(),
    //         ];

    //         $pdf = PDF::loadView(
    //             'admin.mis-data.application-statuses.export-filtered-pdf',
    //             compact('applications', 'officer', 'filterInfo')
    //         )->setPaper('a4', 'landscape');

    //         return $pdf->download($fileName);
    //     }

    //     abort(404, 'Invalid export format');
    // }

    // public function exportCombined(Request $request, $type)
    // {

    //     $filters = [
    //         'fromDate' => $request->query('fromDate'),
    //         'toDate' => $request->query('toDate'),
    //         'office_id' => $request->query('office_id'),
    //         'role_id' => $request->query('role_id'),
    //         'officer_id' => $request->query('officer_id'),
    //         'registration_type' => $request->query('registration_type'),
    //     ];

    //     $export = new CombinedApplicationStatusExport($filters);

    //     $fileName = 'Filtered_Application_Report_' . date('Y-m-d_His') . '.' . $type;

    //     if ($type === 'pdf') {

    //         $data = $export->collection();
    //         $pdf = PDF::loadView('admin.mis-data.application-statuses.export-combined-pdf', compact('data'))
    //             ->setPaper('a4', 'landscape');
    //         return $pdf->download($fileName);
    //     }

    //     return Excel::download($export, $fileName);
    // }

    public function exportOfficeRoleApplications(Request $request)
    {
        $request->validate([
            'office_id' => 'required',
            'role_id' => 'required',
        ]);

        $filters = [
            'office_id' => $request->office_id,
            'role_id' => $request->role_id,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
        ];

        $fileName = 'Officer_Wise_Report_' . now()->format('d-m-Y') . '.xlsx';

        return Excel::download(
            new OfficeRoleApplicationExport($filters),
            $fileName
        );
    }
    public function export(Request $request, $type)
    {
        $fileName = 'ABOCWWB_Application_Status_Report.' . $type;

        $export = new ApplicationStatusReportExport(
            $request->query('user'),
            $request->query('type'),
            $request->query('fromDate'),
            $request->query('toDate')
        );
        if ($type === 'pdf') {

            $applications = $export->collection();

            $applications = $applications->values()->map(function ($app, $index) use ($applications) {

                $app->sno = $index + 1;


                $app->received_date = $app->created_at
                    ? Carbon::parse($app->created_at)
                    : null;


                $app->duration_days = Carbon::parse($app->created_at)
                    ->startOfDay()
                    ->diffInDays(now()->startOfDay());


                $app->registration_type =
                    $app->mainWorker && $app->mainWorker->already_registered == 1
                    ? 'Onboarding'
                    : 'New Registration';


                $app->received_rank = $app->received_rank ?? ($index + 1);


                $app->action_taken_date =
                    ($app->updated_at && $app->updated_at->ne($app->created_at))
                    ? Carbon::parse($app->updated_at)
                    : null;


                if ($app->action_taken_rank) {


                    $app->fifo =
                        ($app->received_rank === $app->action_taken_rank) ? 'Yes' : 'No';

                } else {


                    $violated = $applications->first(function ($other) use ($app) {
                        return
                            $other->received_rank > $app->received_rank &&
                            !empty($other->action_taken_rank);
                    });

                    $app->fifo = $violated ? 'No' : 'Pending';
                }

 // ✅ Resubmit-aware status_text
            $resubmitStatus = $app->resubmit_status ?? 0;
                $app->status_text = match (true) {
                    $app->application_status === 'A' => 'Application Submitted',

                    $app->application_status === 'B' && $app->da_forward == 1 => 'Sent By DA',
                    $app->application_status === 'B' && $app->pull_back == 1 => 'Pulled Back',
                    $app->application_status === 'B' => 'Forwarded By DA',

                    $app->application_status === 'C' => 'Forwarded By RO',
                    $app->application_status === 'D' => 'Application Rejected',
                    $app->application_status === 'E' => 'Pulled Back from DA',
                    $app->application_status === 'F' => 'Application Approved',
                    $app->application_status === 'G' => 'Application Reverted',

                    default => 'Unknown',
                };

                return $app;
            });


            $pdf = PDF::loadView(
                'admin.mis-data.application-statuses.export-pdf',
                compact('applications')
            )->setPaper('a4', 'landscape');

            return $pdf->download($fileName);
        }



        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download($export, $fileName);
        }

        abort(404, 'Invalid export format.');
    }


    public function oneClickExport(Request $request)
    {

        $request->validate([
            'role' => 'required|in:HRO,RO,DA',
            'type' => 'required|in:new,onboarding',
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
        ]);


        $roleId = match ($request->role) {
            'HRO' => 2,
            'RO' => 3,
            'DA' => 4,
        };


        // $filters = [
        //     'role_id' => $roleId,
        //     'registration_type' => $request->type,
        //     'fromDate' => $request->fromDate,
        //     'toDate' => $request->toDate,


        //     'office_id' => null,
        //     'officer_id' => null,
        // ];

        $filters = [
            'role_id' => $roleId,
            'registration_type' => $request->type,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'office_id' => $request->office_id, // ✅ ADD THIS
            'officer_id' => null,
        ];

        $fileName =
            'FIFO_' .
            $request->role . '_' .
            strtoupper($request->type) . '_' .
            now()->format('d-m-Y') .
            '.xlsx';

        return Excel::download(
            new OneClickApplicationStatusExport($filters),
            $fileName
        );
    }




    // {

    //     // dd($user->id
    //     // dd($request->all());

    //     $registrationType = $request->query('type');

    //     $fromDate = $request->query('fromDate');
    //     $toDate = $request->query('toDate');

    //    $data = WorkerApplicationStatus::where('application_receiver_user_id', $user->id)->get();
    //    dd($data->toArray());


    //     abort(404);
    // }

    public function getOfficeOfficers(Request $request, $office_id)
    {
        // Role IDs for HRO (2), RO (3), DA (4)
        $targetRoleIds = [2, 3, 4];

        $officers = User::where('office_id', $office_id)
            ->whereIn('role_id', $targetRoleIds)
            ->with('designation', 'roles') // Eager load roles to get role name
            ->get();

        $officerData = [];
        foreach ($officers as $officer) {
            $roleName = $officer->roles->first() ? $officer->roles->first()->name : 'N/A';
            $officerData[] = [
                'id' => $officer->id,
                'office_name' => $officer->office->office_name ?? 'N/A', // Assuming User model has an office relationship
                'firstname' => $officer->firstname,
                'lastname' => $officer->lastname,
                'role_name' => $roleName,
                'designation_name' => $officer->designation->designation_name ?? 'N/A',
                'total_applications' => $officer->getReceivedApplicationsCount(), // This method should exist on your User model
            ];
        }

        return response()->json([
            'officers' => $officerData
        ]);
    }



    public function showByRole(Request $request, $role_id)
    {
        $office_id = $request->query('office'); // get office_id from query
        $role = Role::find($role_id);
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $officers = User::where('role_id', $role_id)
            ->where('office_id', $office_id)
            ->with('designation', 'office')
            ->get();

        $officerData = [];
        foreach ($officers as $officer) {
            $officerData[] = [
                'id' => $officer->id,
                'office_name' => $officer->office->office_name ?? 'N/A',
                'firstname' => $officer->firstname,
                'lastname' => $officer->lastname,
                'designation_name' => $officer->designation->designation_name ?? 'N/A',
                'total_applications' => $officer->getReceivedApplicationsCount(), // Assuming this method exists in User model
            ];
        }

        return response()->json([
            'role_name' => $role->name,
            'officers' => $officerData
        ]);
    }


    // public function showOfficerApplications(Request $request, User $user)
    // {
    //     \Log::info('Displaying applications for User ID: ' . $user->id);

    //     $registrationType = $request->query('type');
    //     $fromDate = $request->query('fromDate');
    //     $toDate = $request->query('toDate');

    //     $query = WorkerApplicationStatus::with('mainWorker')
    //         ->where('application_receiver_user_id', $user->id);

    //     // REGISTRATION TYPE FILTER
    //     if ($registrationType === 'onboarding') {
    //         $query->whereHas('mainWorker', fn($q) => $q->where('already_registered', 1));
    //     } elseif ($registrationType === 'new') {
    //         $query->whereHas(
    //             'mainWorker',
    //             fn($q) =>
    //             $q->where(
    //                 fn($sq) =>
    //                 $sq->where('already_registered', 0)->orWhereNull('already_registered')
    //             )
    //         );
    //     }

    //     // DATE FILTER
    //     if ($fromDate && $toDate) {
    //         $query->whereBetween('created_at', [
    //             Carbon::parse($fromDate)->startOfDay(),
    //             Carbon::parse($toDate)->endOfDay()
    //         ]);
    //     }

    //     // FIFO base order: RECEIVED order
    //     $applications = $query->orderBy('created_at', 'asc')->get();

    //     // STATUS TEXT
    //     $applications = $applications->map(function ($app) {
    //         $app->status_text = match (true) {
    //             $app->application_status === 'A' => 'Application Submitted',
    //             $app->application_status === 'B' && $app->da_forward == 1 => 'Sent By DA',
    //             $app->application_status === 'B' && $app->pull_back == 1 => 'Pulled Back',
    //             $app->application_status === 'B' => 'Forwarded By DA',
    //             $app->application_status === 'C' => 'Forwarded By RO',
    //             $app->application_status === 'D' => 'Application Rejected',
    //             $app->application_status === 'E' => 'Pulled Back from DA',
    //             $app->application_status === 'F' => 'Application Approved',
    //             $app->application_status === 'G' => 'Application Reverted',
    //             default => 'Unknown Status',
    //         };
    //         return $app;
    //     });

    //     // RECEIVED RANK
    //     $applications = $applications->values()->map(function ($app, $index) {
    //         $app->received_rank = $index + 1;
    //         return $app;
    //     });

    //     // COMPLETED APPLICATIONS (ACTION TAKEN)
    //     $completedApps = $applications
    //         ->filter(
    //             fn($app) =>
    //             $app->updated_at &&
    //             $app->updated_at != $app->created_at
    //         )
    //         ->sortBy('updated_at')
    //         ->values();

    //     // ACTION TAKEN RANK
    //     $completedApps->each(function ($app, $index) {
    //         $app->action_taken_rank = $index + 1;
    //     });

    //     // MERGE ACTION RANK BACK
    //     $applications = $applications->map(function ($app) use ($completedApps) {
    //         $completed = $completedApps->firstWhere('id', $app->id);
    //         if ($completed) {
    //             $app->action_taken_rank = $completed->action_taken_rank;
    //         }
    //         return $app;
    //     });

    //     // 🔥 FINAL FIX: PUSH PENDING TO BOTTOM (DISPLAY RULE)
    //     $applications = $applications
    //         ->map(function ($app) {
    //             $app->is_pending = empty($app->action_taken_rank);
    //             return $app;
    //         })
    //         ->sortBy(fn($app) => $app->is_pending ? 1 : 0)
    //         ->values();


    //     $applications = $applications->map(function ($app) use ($applications) {

    //         // Case 1: Action already taken → normal FIFO check
    //         if (!empty($app->action_taken_rank)) {
    //             $app->fifo_status =
    //                 $app->received_rank == $app->action_taken_rank ? 'Yes' : 'No';
    //             return $app;
    //         }

    //         // Case 2: Pending app — check if any later app jumped the queue
    //         $violated = $applications->first(function ($other) use ($app) {
    //             return
    //                 $other->received_rank > $app->received_rank && // came later
    //                 !empty($other->action_taken_rank);              // but got action
    //         });

    //         $app->fifo_status = $violated ? 'No' : 'Pending';

    //         return $app;
    //     });


    //     return view(
    //         'admin.mis-data.application-statuses.officer-applications',
    //         compact('user', 'applications', 'registrationType')
    //     );
    // }


    // public function showOfficerApplications(Request $request, User $user)
    // {
    //     \Log::info('Displaying applications for User ID: ' . $user->id);

    //     $registrationType = $request->query('type');
    //     $fromDate = $request->query('fromDate');
    //     $toDate = $request->query('toDate');

    //     // First, get all application numbers that this officer has received
    //     $baseQuery = WorkerApplicationStatus::where('application_receiver_user_id', $user->id);

    //     // Apply date filter only if dates are provided and not empty
    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $baseQuery->whereBetween('created_at', [
    //             Carbon::parse($fromDate)->startOfDay(),
    //             Carbon::parse($toDate)->endOfDay()
    //         ]);
    //     }

    //     // Get unique application numbers
    //     $applicationNumbers = $baseQuery->pluck('application_no')->unique();

    //     \Log::info('Found application numbers for officer ' . $user->id . ': ' . $applicationNumbers->implode(', '));

    //     // Now for each application number, get ALL records (not just for this officer)
    //     $applications = collect();

    //     foreach ($applicationNumbers as $appNo) {
    //         // Get ALL records for this application number across all officers
    //         $allRecordsForApp = WorkerApplicationStatus::with(['mainWorker', 'applicationFromUser'])
    //             ->where('application_no', $appNo)
    //             ->orderBy('created_at', 'asc')
    //             ->orderBy('id', 'asc')
    //             ->get();

    //         if ($allRecordsForApp->isEmpty()) {
    //             continue;
    //         }

    //         // Get the FIRST record where this officer received it (for original received date)
    //         $firstRecordForThisOfficer = $allRecordsForApp
    //             ->where('application_receiver_user_id', $user->id)
    //             ->first();

    //         if (!$firstRecordForThisOfficer) {
    //             \Log::warning("No record found for officer {$user->id} for application $appNo");
    //             continue;
    //         }

    //         // Get the LATEST record overall (for current status)
    //         $latestRecord = $allRecordsForApp->last();

    //         // Check registration type filter
    //         $isOnboarding = optional($latestRecord->mainWorker)->already_registered == 1;

    //         if ($registrationType === 'onboarding' && !$isOnboarding) {
    //             continue;
    //         }
    //         if ($registrationType === 'new' && $isOnboarding) {
    //             continue;
    //         }

    //         // Use latest record as base
    //         $app = clone $latestRecord;

    //         // Store the dates
    //         $app->original_received_at = $firstRecordForThisOfficer->created_at;
    //         $app->latest_created_at = $latestRecord->created_at;
    //         $app->latest_updated_at = $latestRecord->updated_at;

    //         // Calculate "Forwarded From"
    //         if (is_numeric($firstRecordForThisOfficer->application_from_user)) {
    //             $fromUser = $firstRecordForThisOfficer->applicationFromUser;
    //             $app->forwarded_from_display = $fromUser
    //                 ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
    //                 : 'N/A';
    //         } else {
    //             $username = $firstRecordForThisOfficer->application_from_user;
    //             if ($username) {
    //                 $fromUser = User::where('username', $username)->first();
    //                 $app->forwarded_from_display = $fromUser
    //                     ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
    //                     : $username;
    //             } else {
    //                 $app->forwarded_from_display = 'N/A';
    //             }
    //         }

    //         $applications->push($app);
    //     }

    //     // STATUS TEXT
    //     $applications = $applications->map(function ($app) {
    //         $status = $app->mainWorker->status ?? $app->application_status;
    //         $daForward = $app->mainWorker->da_forward ?? $app->da_forward ?? 0;
    //         $pullBack = $app->mainWorker->pull_back ?? $app->pull_back ?? 0;

    //         $app->status_text = match (true) {
    //             $status === 'A' => 'Application Submitted',
    //             $status === 'B' && $daForward == 1 => 'Sent By DA',
    //             $status === 'B' && $pullBack == 1 => 'Pulled Back',
    //             $status === 'B' => 'Forwarded By DA',
    //             $status === 'C' => 'Forwarded By RO',
    //             $status === 'D' => 'Application Rejected',
    //             $status === 'E' => 'Pulled Back from DA',
    //             $status === 'F' => 'Application Approved',
    //             $status === 'G' => 'Application Reverted',
    //             $status === 'H' => 'Pulled Back from RO',
    //             $status === 'O' => 'At Registering Officer',
    //             $status === 'M' => 'Office Admin',
    //             $status === 'N' => 'Head Office DA',
    //             $status === 'R' => 'Application Renewal',
    //             $status === 'X' => 'Application Cancelled',
    //             default => 'Unknown Status',
    //         };
    //         return $app;
    //     });

    //     // RECEIVED RANK - Sort by ORIGINAL received date
    //     $applications = $applications->sortBy('original_received_at')->values()->map(function ($app, $index) {
    //         $app->received_rank = $index + 1;
    //         return $app;
    //     });

    //     // COMPLETED APPLICATIONS (ACTION TAKEN)
    //     // Use the ORIGINAL logic: updated_at != created_at
    //     $completedApps = $applications
    //         ->filter(function ($app) {
    //             // Check if this officer took action (updated_at changed from when they received it)
    //             $hasBeenActioned = $app->latest_updated_at &&
    //                 $app->original_received_at &&
    //                 $app->latest_updated_at->timestamp != $app->original_received_at->timestamp;

    //             $app->has_action_taken = $hasBeenActioned;
    //             return $hasBeenActioned;
    //         })
    //         ->sortBy('latest_updated_at')
    //         ->values();

    //     // ACTION TAKEN RANK
    //     $completedApps->each(function ($app, $index) {
    //         $app->action_taken_rank = $index + 1;
    //     });

    //     // MERGE ACTION RANK BACK
    //     $applications = $applications->map(function ($app) use ($completedApps) {
    //         $completed = $completedApps->firstWhere('id', $app->id);
    //         if ($completed) {
    //             $app->action_taken_rank = $completed->action_taken_rank;
    //             $app->has_action_taken = true;
    //         } else {
    //             $app->has_action_taken = false;
    //         }
    //         return $app;
    //     });

    //     // CALCULATE FIFO STATUS (same as old code)
    //     $applications = $applications->map(function ($app) use ($applications) {

    //         // Case 1: Action already taken → normal FIFO check
    //         if ($app->has_action_taken && !empty($app->action_taken_rank)) {
    //             $app->fifo_status = $app->received_rank == $app->action_taken_rank ? 'Yes' : 'No';
    //             return $app;
    //         }

    //         // Case 2: Pending app — check if any later app jumped the queue
    //         $violated = $applications->first(function ($other) use ($app) {
    //             return
    //                 $other->received_rank > $app->received_rank && // came later
    //                 $other->has_action_taken &&                     // but got actioned
    //                 !empty($other->action_taken_rank);              // and has action rank
    //         });

    //         $app->fifo_status = $violated ? 'No' : 'Pending';

    //         return $app;
    //     });

    //     // PUSH PENDING TO BOTTOM (DISPLAY RULE)
    //     $applications = $applications
    //         ->sortBy(fn($app) => $app->has_action_taken ? 0 : 1)
    //         ->values();

    //     return view(
    //         'admin.mis-data.application-statuses.officer-applications',
    //         compact('user', 'applications', 'registrationType')
    //     );
    // }

    // public function applicationHistory($applicationNo)
    // {
    //     $records = WorkerApplicationStatus::with(['applicationFromUser', 'applicationReceiverUser'])
    //         ->where('application_no', $applicationNo)
    //         ->orderBy('created_at', 'asc')
    //         ->orderBy('id', 'asc')
    //         ->get()
    //         ->map(function ($record) {

    //             $terminalStatuses = ['F', 'D', 'X', 'G'];
    //             $isTerminal = in_array($record->application_status, $terminalStatuses);

    //             // Resolve "From" name
    //             if (is_numeric($record->application_from_user)) {
    //                 $from = $record->applicationFromUser;
    //                 $fromName = $from
    //                     ? trim($from->firstname . ' ' . $from->lastname)
    //                     : 'N/A';
    //             } else {
    //                 $username = $record->application_from_user;
    //                 if ($username) {
    //                     $fromUser = User::where('username', $username)->first();
    //                     $fromName = $fromUser
    //                         ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
    //                         : $username;
    //                 } else {
    //                     $fromName = 'Applicant / System';
    //                 }
    //             }

    //             $statusMap = [
    //                 'A' => 'Application Submitted',
    //                 'B' => 'Forwarded By DA',
    //                 'C' => 'Forwarded By RO',
    //                 'D' => 'Application Rejected',
    //                 'E' => 'Pulled Back from DA',
    //                 'F' => 'Application Approved',
    //                 'G' => 'Application Reverted',
    //                 'H' => 'Pulled Back from RO',
    //                 'O' => 'At Registering Officer',
    //                 'M' => 'Office Admin',
    //                 'N' => 'Head Office DA',
    //                 'R' => 'Application Renewal',
    //                 'X' => 'Application Cancelled',
    //             ];

    //             // Resolve "To" name only for non-terminal statuses
    //             $toName = '';
    //             if (!$isTerminal) {
    //                 $to = $record->applicationReceiverUser;
    //                 if ($to) {
    //                     $toName = trim($to->firstname . ' ' . $to->lastname);
    //                 } elseif ($record->application_status === 'A' && $record->office_id) {
    //                     $hro = (new WorkerApplicationStatus)->getHro($record->office_id);
    //                     $toName = $hro
    //                         ? trim($hro->firstname . ' ' . $hro->lastname)
    //                         : '';
    //                 }
    //             }

    //             return [
    //                 'from' => $fromName,
    //                 'to' => $toName,         // always present but empty string for terminal
    //                 'is_terminal' => $isTerminal,      // explicit boolean flag
    //                 'status' => $statusMap[$record->application_status] ?? 'Unknown',
    //                 'status_raw' => $record->application_status,
    //                 'date' => Carbon::parse($record->created_at)->format('d-m-Y h:i A'),
    //             ];
    //         });

    //     return response()->json(['success' => true, 'history' => $records]);
    // }

    /**
     * Resolve "Forwarded By {Role}" from the sender_role_id
     * already stored on the WorkerApplicationStatus record.
     */
    /**
     * Resolve "Forwarded By {Role}" from sender_role_id
     */
    private function resolveForwarderRoleLabel(?int $senderRoleId): string
    {
        if (!$senderRoleId)
            return 'Unknown';

        $role = \Spatie\Permission\Models\Role::find($senderRoleId);
        return $role ? $role->name : 'Unknown';
    }

    /**
     * Resolve "Forwarded To {Role}" from application_receiver_role_id
     * Used when the officer is the SENDER (e.g. HRO forwarding to RO)
     */
    private function resolveReceiverRoleLabel(?int $receiverRoleId): string
    {
        if (!$receiverRoleId)
            return 'Unknown';

        $role = \Spatie\Permission\Models\Role::find($receiverRoleId);
        return $role ? $role->name : 'Unknown';
    }


    public function showOfficerApplications(Request $request, User $user)
    {
        \Log::info('Displaying applications for User ID: ' . $user->id);

        $registrationType = $request->query('type');
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');

        // ✅ HRO DETECTION via Spatie roles
        $isHro = $user->roles->pluck('id')->contains(2);

        // ✅ BASE QUERY: receiver OR sender OR HRO office fallback
        $baseQuery = WorkerApplicationStatus::where(function ($q) use ($user, $isHro) {
            $q->where('application_receiver_user_id', $user->id)
                ->orWhere('sender_user_id', $user->id);

            // HRO FALLBACK: catch applications submitted to this HRO's office
            // where application_receiver_user_id was never saved (the routing bug)
            if ($isHro && $user->office_id) {
                $q->orWhere(function ($q2) use ($user) {
                    $q2->where('office_id', $user->office_id)
                        ->whereNull('application_receiver_user_id');
                });
            }
        });

        if (!empty($fromDate) && !empty($toDate)) {
            $baseQuery->whereBetween('created_at', [
                Carbon::parse($fromDate)->startOfDay(),
                Carbon::parse($toDate)->endOfDay()
            ]);
        }

        $applicationNumbers = $baseQuery->pluck('application_no')->unique();

        $applications = collect();

        foreach ($applicationNumbers as $appNo) {

            $allRecordsForApp = WorkerApplicationStatus::with(['mainWorker', 'applicationFromUser'])
                ->where('application_no', $appNo)
                ->orderBy('created_at', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            if ($allRecordsForApp->isEmpty())
                continue;

            // First try: app was explicitly routed to this officer
            $receiverRecord = $allRecordsForApp
                ->where('application_receiver_user_id', $user->id)
                ->first();

            // ✅ HRO FALLBACK: receiver was never saved but app belongs to this office
            if (!$receiverRecord && $isHro && $user->office_id) {
                $receiverRecord = $allRecordsForApp
                    ->filter(
                        fn($r) =>
                        $r->office_id == $user->office_id &&
                        is_null($r->application_receiver_user_id)
                    )
                    ->first();
            }

            $senderRecord = $allRecordsForApp
                ->where('sender_user_id', $user->id)
                ->first();

            if ($receiverRecord) {
                $firstRecordForThisOfficer = $receiverRecord;
                $officerIsSender = false;
            } elseif ($senderRecord) {
                $firstRecordForThisOfficer = $senderRecord;
                $officerIsSender = true;
            } else {
                continue;
            }

            $latestRecord = $allRecordsForApp->last();

            $isOnboarding = optional($latestRecord->mainWorker)->already_registered == 1;

            if ($registrationType === 'onboarding' && !$isOnboarding)
                continue;
            if ($registrationType === 'new' && $isOnboarding)
                continue;

            $app = clone $latestRecord;
            $app->load('applicationFromUser');

            $app->latest_created_at = $latestRecord->created_at;
            $app->latest_updated_at = $latestRecord->updated_at;
            $app->officer_is_sender = $officerIsSender;

            if ($officerIsSender) {
                $app->original_received_at = $allRecordsForApp->first()->created_at;
                $app->officer_action_date = $firstRecordForThisOfficer->created_at;
            } else {
                $app->original_received_at = $firstRecordForThisOfficer->created_at;
                $app->officer_action_date = null;
            }

            // Forwarded from display name
            if (is_numeric($firstRecordForThisOfficer->application_from_user)) {
                $fromUser = $firstRecordForThisOfficer->applicationFromUser;
                $app->forwarded_from_display = $fromUser
                    ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
                    : 'N/A';
            } else {
                $username = $firstRecordForThisOfficer->application_from_user;
                $fromUser = $username ? User::where('username', $username)->first() : null;
                $app->forwarded_from_display = $fromUser
                    ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
                    : ($username ?? 'N/A');
            }

            $applications->push($app);
        }

        // ✅ STATUS TEXT
        $applications = $applications->map(function ($app) use ($user) {

            $status = $app->application_status;
            $pullBack = $app->pull_back ?? 0;
            $resubmitStatus = $app->resubmit_status ?? 0;

            $receiverRoleId = $app->receiver_role_id ?? $app->application_receiver_role_id ?? null;
            $forwardedToLabel = $this->resolveReceiverRoleLabel($receiverRoleId);

            if (is_numeric($app->application_from_user)) {
                $fromUser = $app->applicationFromUser;
                $forwardedByLabel = $fromUser
                    ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
                    : $this->resolveForwarderRoleLabel($app->sender_role_id);
            } else {
                $username = $app->application_from_user;
                if ($username) {
                    $fromUser = User::where('username', $username)->first();
                    $forwardedByLabel = $fromUser
                        ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
                        : $username;
                } else {
                    $forwardedByLabel = 'Applicant/System';
                }
            }

            $isLatestSender = $app->sender_user_id == $user->id;
            $isLatestReceiver = $app->application_receiver_user_id == $user->id;

            $app->status_text = match (true) {

                $status === 'A' && $resubmitStatus == 1
                => 'Application Resubmitted',
                $status === 'A'
                => 'Application Submitted',

                in_array($status, ['B', 'C', 'O']) && $pullBack == 1
                => 'Pulled Back',

                in_array($status, ['B', 'C', 'O']) && $isLatestSender
                => 'Forwarded To ' . $forwardedToLabel . ' by ' . $forwardedByLabel,

                in_array($status, ['B', 'C', 'O']) && $isLatestReceiver
                => 'Received from ' . $forwardedByLabel,

                in_array($status, ['B', 'C', 'O'])
                => 'Forwarded To ' . $forwardedToLabel . ' by ' . $forwardedByLabel,

                $status === 'D' => 'Application Rejected',
                $status === 'E' => 'Pulled Back from DA',
                $status === 'F' => 'Application Approved',
'G' => 'Application Reverted',
                'H' => 'Pulled Back from RO',
                default => 'Unknown Status',
            };

            return $app;
        });

        // ✅ RECEIVED RANK
        $applications = $applications
            ->sortBy('original_received_at')
            ->values()
            ->map(function ($app, $index) {
                $app->received_rank = $index + 1;
                return $app;
            });

        // ✅ COMPLETED APPLICATIONS
        $completedApps = $applications
            ->filter(function ($app) {
                if ($app->officer_is_sender) {
                    $app->has_action_taken = true;
                    return true;
                }

                $hasBeenActioned =
                    $app->latest_updated_at &&
                    $app->original_received_at &&
                    $app->latest_updated_at->timestamp != $app->original_received_at->timestamp;

                $app->has_action_taken = $hasBeenActioned;
                return $hasBeenActioned;
            })
            ->sortBy(function ($app) {
                return $app->officer_is_sender
                    ? $app->officer_action_date
                    : $app->latest_updated_at;
            })
            ->values();

        $completedApps->each(function ($app, $index) {
            $app->action_taken_rank = $index + 1;
        });

        // ✅ MERGE ACTION RANK BACK
        $applications = $applications->map(function ($app) use ($completedApps) {
            $completed = $completedApps->firstWhere('id', $app->id);
            if ($completed) {
                $app->action_taken_rank = $completed->action_taken_rank;
                $app->has_action_taken = true;
            } else {
                $app->has_action_taken = false;
            }
            return $app;
        });

        // ✅ FIFO STATUS
        $applications = $applications->map(function ($app) use ($applications) {

            if ($app->has_action_taken && !empty($app->action_taken_rank)) {
                $app->fifo_status = $app->received_rank == $app->action_taken_rank ? 'Yes' : 'No';
                return $app;
            }

            $violated = $applications->first(function ($other) use ($app) {
                return
                    $other->received_rank > $app->received_rank &&
                    $other->has_action_taken &&
                    !empty($other->action_taken_rank);
            });

            $app->fifo_status = $violated ? 'No' : 'Pending';
            return $app;
        });

        // ✅ PENDING TO BOTTOM
        $applications = $applications
            ->sortBy(fn($app) => $app->has_action_taken ? 0 : 1)
            ->values();

        return view(
            'admin.mis-data.application-statuses.officer-applications',
            compact('user', 'applications', 'registrationType')
        );
    }


    // public function showOfficerApplications(Request $request, User $user)
    // {
    //     \Log::info('Displaying applications for User ID: ' . $user->id);

    //     $registrationType = $request->query('type');
    //     $fromDate = $request->query('fromDate');
    //     $toDate = $request->query('toDate');

    //     $baseQuery = WorkerApplicationStatus::where(function ($q) use ($user) {
    //         $q->where('application_receiver_user_id', $user->id)
    //             ->orWhere('sender_user_id', $user->id);
    //     });

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $baseQuery->whereBetween('created_at', [
    //             Carbon::parse($fromDate)->startOfDay(),
    //             Carbon::parse($toDate)->endOfDay()
    //         ]);
    //     }

    //     $applicationNumbers = $baseQuery->pluck('application_no')->unique();

    //     $applications = collect();

    //     foreach ($applicationNumbers as $appNo) {

    //         $allRecordsForApp = WorkerApplicationStatus::with(['mainWorker', 'applicationFromUser'])
    //             ->where('application_no', $appNo)
    //             ->orderBy('created_at', 'asc')
    //             ->orderBy('id', 'asc')
    //             ->get();

    //         if ($allRecordsForApp->isEmpty())
    //             continue;

    //         $receiverRecord = $allRecordsForApp
    //             ->where('application_receiver_user_id', $user->id)
    //             ->first();

    //         $senderRecord = $allRecordsForApp
    //             ->where('sender_user_id', $user->id)
    //             ->first();

    //         if ($receiverRecord) {
    //             $firstRecordForThisOfficer = $receiverRecord;
    //             $officerIsSender = false;
    //         } elseif ($senderRecord) {
    //             $firstRecordForThisOfficer = $senderRecord;
    //             $officerIsSender = true;
    //         } else {
    //             continue;
    //         }

    //         $latestRecord = $allRecordsForApp->last();

    //         $isOnboarding = optional($latestRecord->mainWorker)->already_registered == 1;

    //         if ($registrationType === 'onboarding' && !$isOnboarding)
    //             continue;
    //         if ($registrationType === 'new' && $isOnboarding)
    //             continue;

    //         $app = clone $latestRecord;
    //         // ✅ ensure latest record relation is loaded
    //         $app->load('applicationFromUser');

    //         $app->latest_created_at = $latestRecord->created_at;
    //         $app->latest_updated_at = $latestRecord->updated_at;
    //         $app->officer_is_sender = $officerIsSender;

    //         if ($officerIsSender) {
    //             $app->original_received_at = $allRecordsForApp->first()->created_at;
    //             $app->officer_action_date = $firstRecordForThisOfficer->created_at;
    //         } else {
    //             $app->original_received_at = $firstRecordForThisOfficer->created_at;
    //             $app->officer_action_date = null;
    //         }

    //         // Forwarded from name
    //         if (is_numeric($firstRecordForThisOfficer->application_from_user)) {
    //             $fromUser = $firstRecordForThisOfficer->applicationFromUser;
    //             $app->forwarded_from_display = $fromUser
    //                 ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
    //                 : 'N/A';
    //         } else {
    //             $username = $firstRecordForThisOfficer->application_from_user;
    //             $fromUser = $username ? User::where('username', $username)->first() : null;

    //             $app->forwarded_from_display = $fromUser
    //                 ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
    //                 : ($username ?? 'N/A');
    //         }

    //         $applications->push($app);
    //     }

    //     // ✅ STATUS TEXT (FINAL FIX)
    //     $applications = $applications->map(function ($app) use ($user) {

    //         $status = $app->application_status;
    //         $pullBack = $app->pull_back ?? 0;

    //         $receiverRoleId = $app->receiver_role_id ?? $app->application_receiver_role_id ?? null;

    //         $forwardedToLabel = $this->resolveReceiverRoleLabel($receiverRoleId);
    //         // ✅ SAME LOGIC AS HISTORY (source of truth)
    //         if (is_numeric($app->application_from_user)) {
    //             $fromUser = $app->applicationFromUser;

    //             $forwardedByLabel = $fromUser
    //                 ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
    //                 : $this->resolveForwarderRoleLabel($app->sender_role_id);

    //         } else {
    //             $username = $app->application_from_user;

    //             if ($username) {
    //                 $fromUser = \App\Models\User::where('username', $username)->first();

    //                 $forwardedByLabel = $fromUser
    //                     ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
    //                     : $username;
    //             } else {
    //                 $forwardedByLabel = 'Applicant/System'; // ✅ FIXED
    //             }
    //         }

    //         // ✅ KEY FIX: latest action check
    //         // ✅ identify user's relation to latest action
    //         $isLatestSender = $app->sender_user_id == $user->id;
    //         $isLatestReceiver = $app->application_receiver_user_id == $user->id;

    //         $app->status_text = match (true) {

    //             $status === 'A' => 'Application Submitted',

    //             in_array($status, ['B', 'C', 'O']) && $pullBack == 1
    //             => 'Pulled Back',

    //             // ✅ Current sender (RO)
    //             in_array($status, ['B', 'C', 'O']) && $isLatestSender
    //             => 'Forwarded To ' . $forwardedToLabel . ' by ' . $forwardedByLabel,

    //             // ✅ Current receiver (DA)
    //             in_array($status, ['B', 'C', 'O']) && $isLatestReceiver
    //             => 'Received from ' . $forwardedByLabel,

    //             // ✅ Previous actor (HRO case)
    //             in_array($status, ['B', 'C', 'O'])
    //             => 'Forwarded To ' . $forwardedToLabel . ' by ' . $forwardedByLabel,

    //             $status === 'D' => 'Application Rejected',
    //             $status === 'E' => 'Pulled Back from DA',
    //             $status === 'F' => 'Application Approved',

    //             default => 'Unknown Status',
    //         };

    //         return $app;
    //     });

    //     // SORT & FIFO (unchanged)
    //     $applications = $applications
    //         ->sortBy('original_received_at')
    //         ->values()
    //         ->map(function ($app, $index) {
    //             $app->received_rank = $index + 1;
    //             return $app;
    //         });

    //     $completedApps = $applications
    //         ->filter(function ($app) {
    //             if ($app->officer_is_sender) {
    //                 $app->has_action_taken = true;
    //                 return true;
    //             }

    //             $hasBeenActioned =
    //                 $app->latest_updated_at &&
    //                 $app->original_received_at &&
    //                 $app->latest_updated_at->timestamp != $app->original_received_at->timestamp;

    //             $app->has_action_taken = $hasBeenActioned;
    //             return $hasBeenActioned;
    //         })
    //         ->sortBy(function ($app) {
    //             return $app->officer_is_sender
    //                 ? $app->officer_action_date
    //                 : $app->latest_updated_at;
    //         })
    //         ->values();

    //     $completedApps->each(function ($app, $index) {
    //         $app->action_taken_rank = $index + 1;
    //     });

    //     $applications = $applications->map(function ($app) use ($completedApps) {
    //         $completed = $completedApps->firstWhere('id', $app->id);
    //         if ($completed) {
    //             $app->action_taken_rank = $completed->action_taken_rank;
    //             $app->has_action_taken = true;
    //         } else {
    //             $app->has_action_taken = false;
    //         }
    //         return $app;
    //     });

    //     $applications = $applications->map(function ($app) use ($applications) {

    //         if ($app->has_action_taken && !empty($app->action_taken_rank)) {
    //             $app->fifo_status = $app->received_rank == $app->action_taken_rank ? 'Yes' : 'No';
    //             return $app;
    //         }

    //         $violated = $applications->first(function ($other) use ($app) {
    //             return
    //                 $other->received_rank > $app->received_rank &&
    //                 $other->has_action_taken &&
    //                 !empty($other->action_taken_rank);
    //         });

    //         $app->fifo_status = $violated ? 'No' : 'Pending';
    //         return $app;
    //     });

    //     $applications = $applications
    //         ->sortBy(fn($app) => $app->has_action_taken ? 0 : 1)
    //         ->values();

    //     return view(
    //         'admin.mis-data.application-statuses.officer-applications',
    //         compact('user', 'applications', 'registrationType')
    //     );
    // }




    public function applicationHistory($applicationNo)
    {
        $records = WorkerApplicationStatus::with(['applicationFromUser', 'applicationReceiverUser'])
            ->where('application_no', $applicationNo)
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            // Keep only the first 'A' status record — all other statuses remain distinct
            ->unique(function ($record) {
                return $record->application_status === 'A' ? 'A' : $record->id;
            })
            ->values()
            ->map(function ($record) {

                $terminalStatuses = ['F', 'D', 'X', 'G'];
                $isTerminal = in_array($record->application_status, $terminalStatuses);

                // Resolve "From" name
                if (is_numeric($record->application_from_user)) {
                    $from = $record->applicationFromUser;
                    $fromName = $from
                        ? trim($from->firstname . ' ' . $from->lastname)
                        : 'N/A';
                } else {
                    $username = $record->application_from_user;
                    if ($username) {
                        $fromUser = User::where('username', $username)->first();
                        $fromName = $fromUser
                            ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
                            : $username;
                    } else {
                        $fromName = 'Applicant / System';
                    }
                }

                // Resolve "Forwarded By {Role}" dynamically from sender_role_id
                $forwardedByLabel = $this->resolveForwarderRoleLabel($record->sender_role_id);

                $statusMap = [
                    // 'A' => 'Application Submitted',
                    'A' => ($record->resubmit_status == 1) ? 'Application Resubmitted' : 'Application Submitted',
                    'B' => $forwardedByLabel,
                    'C' => $forwardedByLabel,
                    'D' => 'Application Rejected',
                    'E' => 'Pulled Back from DA',
                    'F' => 'Application Approved',
                    'G' => 'Application Reverted',
                    'H' => 'Pulled Back from RO',
                    'O' => $forwardedByLabel,
                    'M' => 'Office Admin',
                    'N' => 'Head Office DA',
                    'R' => 'Application Renewal',
                    'X' => 'Application Cancelled',
                ];

                // Resolve "To" name only for non-terminal statuses
                $toName = '';
                if (!$isTerminal) {
                    $to = $record->applicationReceiverUser;
                    if ($to) {
                        $toName = trim($to->firstname . ' ' . $to->lastname);
                    } elseif ($record->application_status === 'A' && $record->office_id) {
                        $hro = (new WorkerApplicationStatus)->getHro($record->office_id);
                        $toName = $hro
                            ? trim($hro->firstname . ' ' . $hro->lastname)
                            : '';
                    }
                }

                return [
                    'from' => $fromName,
                    'to' => $toName,
                    'is_terminal' => $isTerminal,
                    'status' => $statusMap[$record->application_status] ?? 'Unknown',
                    'status_raw' => $record->application_status,
                    'date' => Carbon::parse($record->created_at)->format('d-m-Y h:i A'),
                ];
            });

        return response()->json(['success' => true, 'history' => $records]);
    }


    // public function showOfficerApplications(Request $request, User $user)
// {
//     \Log::info('Displaying applications for User ID: ' . $user->id);

    //     $registrationType = $request->query('type');
//     $fromDate         = $request->query('fromDate');
//     $toDate           = $request->query('toDate');

    //     // Get all application numbers where this officer was EITHER receiver OR sender
//     $baseQuery = WorkerApplicationStatus::where('application_receiver_user_id', $user->id)
//         ->orWhere('sender_user_id', $user->id);

    //     if (!empty($fromDate) && !empty($toDate)) {
//         $baseQuery->whereBetween('created_at', [
//             Carbon::parse($fromDate)->startOfDay(),
//             Carbon::parse($toDate)->endOfDay()
//         ]);
//     }

    //     $applicationNumbers = $baseQuery->pluck('application_no')->unique();

    //     \Log::info('Found application numbers for officer ' . $user->id . ': ' . $applicationNumbers->implode(', '));

    //     $applications = collect();

    //     foreach ($applicationNumbers as $appNo) {

    //         $allRecordsForApp = WorkerApplicationStatus::with(['mainWorker', 'applicationFromUser'])
//             ->where('application_no', $appNo)
//             ->orderBy('created_at', 'asc')
//             ->orderBy('id', 'asc')
//             ->get();

    //         if ($allRecordsForApp->isEmpty()) {
//             continue;
//         }

    //         // First try to find the record where this officer was the RECEIVER
//         $firstRecordForThisOfficer = $allRecordsForApp
//             ->where('application_receiver_user_id', $user->id)
//             ->first();

    //         // If officer was never a receiver (e.g. HRO who only forwarded),
//         // fall back to the first record where they were the SENDER
//         if (!$firstRecordForThisOfficer) {
//             $firstRecordForThisOfficer = $allRecordsForApp
//                 ->where('sender_user_id', $user->id)
//                 ->first();
//         }

    //         if (!$firstRecordForThisOfficer) {
//             \Log::warning("No record found for officer {$user->id} for application $appNo");
//             continue;
//         }

    //         $latestRecord = $allRecordsForApp->last();

    //         // Registration type filter
//         $isOnboarding = optional($latestRecord->mainWorker)->already_registered == 1;

    //         if ($registrationType === 'onboarding' && !$isOnboarding) {
//             continue;
//         }
//         if ($registrationType === 'new' && $isOnboarding) {
//             continue;
//         }

    //         $app = clone $latestRecord;

    //         $app->original_received_at = $firstRecordForThisOfficer->created_at;
//         $app->latest_created_at    = $latestRecord->created_at;
//         $app->latest_updated_at    = $latestRecord->updated_at;

    //         // Resolve "Forwarded From" display name
//         if (is_numeric($firstRecordForThisOfficer->application_from_user)) {
//             $fromUser                    = $firstRecordForThisOfficer->applicationFromUser;
//             $app->forwarded_from_display = $fromUser
//                 ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
//                 : 'N/A';
//         } else {
//             $username = $firstRecordForThisOfficer->application_from_user;
//             if ($username) {
//                 $fromUser                    = User::where('username', $username)->first();
//                 $app->forwarded_from_display = $fromUser
//                     ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
//                     : $username;
//             } else {
//                 $app->forwarded_from_display = 'N/A';
//             }
//         }

    //         // Resolve "Forwarded By {Role}" from sender_role_id
//         $app->forwarded_from_role_label = $this->resolveForwarderRoleLabel(
//             $firstRecordForThisOfficer->sender_role_id
//         );

    //         $applications->push($app);
//     }

    //     // STATUS TEXT — dynamic role label for all forwarding statuses (B, C, O)
//     $applications = $applications->map(function ($app) {
//         $status    = $app->mainWorker->status ?? $app->application_status;
//         $daForward = $app->mainWorker->da_forward ?? $app->da_forward ?? 0;
//         $pullBack  = $app->mainWorker->pull_back  ?? $app->pull_back  ?? 0;

    //         $forwardedByLabel = $app->forwarded_from_role_label ?? 'Forwarded';

    //         $app->status_text = match (true) {
//             $status === 'A'                    => 'Application Submitted',
//             $status === 'B' && $daForward == 1 => $forwardedByLabel,
//             $status === 'B' && $pullBack  == 1 => 'Pulled Back',
//             $status === 'B'                    => $forwardedByLabel,
//             $status === 'C'                    => $forwardedByLabel,
//             $status === 'D'                    => 'Application Rejected',
//             $status === 'E'                    => 'Pulled Back from DA',
//             $status === 'F'                    => 'Application Approved',
//             $status === 'G'                    => 'Application Reverted',
//             $status === 'H'                    => 'Pulled Back from RO',
//             $status === 'O'                    => $forwardedByLabel,
//             $status === 'M'                    => 'Office Admin',
//             $status === 'N'                    => 'Head Office DA',
//             $status === 'R'                    => 'Application Renewal',
//             $status === 'X'                    => 'Application Cancelled',
//             default                            => 'Unknown Status',
//         };
//         return $app;
//     });

    //     // RECEIVED RANK — sort by original received date
//     $applications = $applications
//         ->sortBy('original_received_at')
//         ->values()
//         ->map(function ($app, $index) {
//             $app->received_rank = $index + 1;
//             return $app;
//         });

    //     // COMPLETED APPLICATIONS
//     $completedApps = $applications
//         ->filter(function ($app) {
//             $hasBeenActioned =
//                 $app->latest_updated_at &&
//                 $app->original_received_at &&
//                 $app->latest_updated_at->timestamp != $app->original_received_at->timestamp;

    //             $app->has_action_taken = $hasBeenActioned;
//             return $hasBeenActioned;
//         })
//         ->sortBy('latest_updated_at')
//         ->values();

    //     // ACTION TAKEN RANK
//     $completedApps->each(function ($app, $index) {
//         $app->action_taken_rank = $index + 1;
//     });

    //     // MERGE ACTION RANK BACK
//     $applications = $applications->map(function ($app) use ($completedApps) {
//         $completed = $completedApps->firstWhere('id', $app->id);
//         if ($completed) {
//             $app->action_taken_rank = $completed->action_taken_rank;
//             $app->has_action_taken  = true;
//         } else {
//             $app->has_action_taken = false;
//         }
//         return $app;
//     });

    //     // FIFO STATUS
//     $applications = $applications->map(function ($app) use ($applications) {

    //         if ($app->has_action_taken && !empty($app->action_taken_rank)) {
//             $app->fifo_status = $app->received_rank == $app->action_taken_rank ? 'Yes' : 'No';
//             return $app;
//         }

    //         $violated = $applications->first(function ($other) use ($app) {
//             return
//                 $other->received_rank > $app->received_rank &&
//                 $other->has_action_taken &&
//                 !empty($other->action_taken_rank);
//         });

    //         $app->fifo_status = $violated ? 'No' : 'Pending';
//         return $app;
//     });

    //     // PUSH PENDING TO BOTTOM
//     $applications = $applications
//         ->sortBy(fn($app) => $app->has_action_taken ? 0 : 1)
//         ->values();

    //     return view(
//         'admin.mis-data.application-statuses.officer-applications',
//         compact('user', 'applications', 'registrationType')
//     );
// }

    public function PanRation(Request $request)
    {

        $data['pan'] = MainWorkerBasicDetail::where('pan', 1)->count();
        $data['ration'] = MainWorkerBasicDetail::where('has_ration_card', 1)->count();


        return view('admin.mis-data.pan-ration.index', compact('data'));
    }
}
