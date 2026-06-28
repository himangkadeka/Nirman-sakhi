<?php

namespace App\Exports;

use App\Models\WorkerApplicationStatus;
use Carbon\Carbon;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


// class ApplicationStatusReportExport implements FromCollection, WithHeadings, WithMapping
// {
//     protected $userId;
//     protected $registrationType;
//     protected $fromDate;
//     protected $toDate;

//     public function __construct($userId = null, $registrationType = null, $fromDate = null, $toDate = null)
//     {
//         $this->userId = $userId;
//         $this->registrationType = $registrationType;
//         $this->fromDate = $fromDate;
//         $this->toDate = $toDate;
//     }

//     public function collection()
//     {
//         if (!$this->userId) {
//             return collect();
//         }

//         $user = User::find($this->userId);
//         if (!$user) {
//             return collect();
//         }

//         // USE THE SAME LOGIC AS showOfficerApplications
//         $baseQuery = WorkerApplicationStatus::where(function ($q) use ($user) {
//     $q->where('application_receiver_user_id', $user->id)
//       ->orWhere('sender_user_id', $user->id);
// });

//         if (!empty($this->fromDate) && !empty($this->toDate)) {
//             $baseQuery->whereBetween('created_at', [
//                 Carbon::parse($this->fromDate)->startOfDay(),
//                 Carbon::parse($this->toDate)->endOfDay()
//             ]);
//         }

//         $applicationNumbers = $baseQuery->pluck('application_no')->unique();
//         $applications = collect();

//         foreach ($applicationNumbers as $appNo) {
//             $allRecordsForApp = WorkerApplicationStatus::with(['mainWorker', 'applicationFromUser'])
//                 ->where('application_no', $appNo)
//                 ->orderBy('created_at', 'asc')
//                 ->orderBy('id', 'asc')
//                 ->get();

//             if ($allRecordsForApp->isEmpty()) {
//                 continue;
//             }

//             $firstRecordForThisOfficer = $allRecordsForApp
//                 ->where('application_receiver_user_id', $user->id)
//                 ->first();

//             if (!$firstRecordForThisOfficer) {
//                 continue;
//             }

//             $latestRecord = $allRecordsForApp->last();

//             $isOnboarding = optional($latestRecord->mainWorker)->already_registered == 1;

//             if ($this->registrationType === 'onboarding' && !$isOnboarding) {
//                 continue;
//             }
//             if ($this->registrationType === 'new' && $isOnboarding) {
//                 continue;
//             }

//             $app = clone $latestRecord;
//             $app->original_received_at = $firstRecordForThisOfficer->created_at;
//             $app->latest_created_at = $latestRecord->created_at;
//             $app->latest_updated_at = $latestRecord->updated_at;

//             // Calculate forwarded from
//             if (is_numeric($firstRecordForThisOfficer->application_from_user)) {
//                 $fromUser = $firstRecordForThisOfficer->applicationFromUser;
//                 $app->forwarded_from_display = $fromUser
//                     ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
//                     : 'N/A';
//             } else {
//                 $username = $firstRecordForThisOfficer->application_from_user;
//                 if ($username) {
//                     $fromUser = User::where('username', $username)->first();
//                     $app->forwarded_from_display = $fromUser
//                         ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
//                         : $username;
//                 } else {
//                     $app->forwarded_from_display = 'N/A';
//                 }
//             }

//             $applications->push($app);
//         }

//         // STATUS TEXT
//         $applications = $applications->map(function ($app) {
//             $status = $app->mainWorker->status ?? $app->application_status;
//             $daForward = $app->mainWorker->da_forward ?? $app->da_forward ?? 0;
//             $pullBack = $app->mainWorker->pull_back ?? $app->pull_back ?? 0;

//             $app->status_text = match (true) {
//                 $status === 'A' => 'Application Submitted',
//                 $status === 'B' && $daForward == 1 => 'Sent By DA',
//                 $status === 'B' && $pullBack == 1 => 'Pulled Back',
//                 $status === 'B' => 'Forwarded By DA',
//                 $status === 'C' => 'Forwarded By RO',
//                 $status === 'D' => 'Application Rejected',
//                 $status === 'E' => 'Pulled Back from DA',
//                 $status === 'F' => 'Application Approved',
//                 $status === 'G' => 'Application Reverted',
//                 $status === 'H' => 'Pulled Back from RO',
//                 $status === 'O' => 'At Registering Officer',
//                 $status === 'M' => 'Office Admin',
//                 $status === 'N' => 'Head Office DA',
//                 $status === 'R' => 'Application Renewal',
//                 $status === 'X' => 'Application Cancelled',
//                 default => 'Unknown Status',
//             };
//             return $app;
//         });

//         // RECEIVED RANK
//         $applications = $applications->sortBy('original_received_at')->values()->map(function ($app, $index) {
//             $app->received_rank = $index + 1;
//             return $app;
//         });

//         // COMPLETED APPLICATIONS
//         $completedStatuses = ['B', 'C', 'D', 'F', 'G'];

//         $completedApps = $applications
//             ->filter(function ($app) use ($completedStatuses) {
//                 $status = $app->mainWorker->status ?? $app->application_status;
//                 $app->has_action_taken = in_array($status, $completedStatuses);
//                 return $app->has_action_taken;
//             })
//             ->sortBy('latest_updated_at')
//             ->values();

//         $completedApps->each(function ($app, $index) {
//             $app->action_taken_rank = $index + 1;
//         });

//         $applications = $applications->map(function ($app) use ($completedApps) {
//             $completed = $completedApps->firstWhere('id', $app->id);
//             if ($completed) {
//                 $app->action_taken_rank = $completed->action_taken_rank;
//                 $app->has_action_taken = true;
//             } else {
//                 $app->has_action_taken = false;
//             }
//             return $app;
//         });

//         // CALCULATE FIFO
//         $applications = $applications->map(function ($app) use ($applications) {
//             if ($app->has_action_taken && !empty($app->action_taken_rank)) {
//                 $app->fifo_status = $app->received_rank == $app->action_taken_rank ? 'Yes' : 'No';
//                 return $app;
//             }

//             $violated = $applications->first(function ($other) use ($app) {
//                 return
//                     $other->received_rank > $app->received_rank &&
//                     $other->has_action_taken &&
//                     !empty($other->action_taken_rank);
//             });

//             $app->fifo_status = $violated ? 'No' : 'Pending';
//             return $app;
//         });

//         return $applications;
//     }

//     public function headings(): array
//     {
//         return [
//             'Application No',
//             'Registration Type',
//             'Forwarded From',
//             'Received Date',
//             'Duration (Days)',
//             'Rank (Received)',
//             'Action Taken Date',
//             'Rank (Action Taken)',
//             'FIFO Compliant',
//             'Status',
//         ];
//     }

//     public function map($app): array
//     {
//         $isOnboarding = $app->mainWorker?->already_registered == 1;
//         $duration = Carbon::parse($app->original_received_at)->diffInDays(now());

//         return [
//             $app->application_no ?? 'N/A',
//             $isOnboarding ? 'Onboarding' : 'New Registration',
//             $app->forwarded_from_display ?? 'N/A',
//             Carbon::parse($app->original_received_at)->format('d-m-Y H:i'),
//             $duration,
//             $app->received_rank,
//             ($app->has_action_taken && $app->latest_updated_at)
//                 ? Carbon::parse($app->latest_updated_at)->format('d-m-Y H:i')
//                 : 'Pending',
//             $app->action_taken_rank ?? '-',
//             $app->fifo_status ?? 'Pending',
//             $app->status_text ?? 'Unknown',
//         ];
//     }
// }
// <?php

// namespace App\Exports;

// use App\Models\WorkerApplicationStatus;
// use Carbon\Carbon;
// use App\Models\User;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationStatusReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;
    protected $registrationType;
    protected $fromDate;
    protected $toDate;

    public function __construct($userId = null, $registrationType = null, $fromDate = null, $toDate = null)
    {
        $this->userId = $userId;
        $this->registrationType = $registrationType;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }
    public function collection()
    {
        if (!$this->userId)
            return collect();

        $user = User::find($this->userId);
        if (!$user)
            return collect();

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

        if (!empty($this->fromDate) && !empty($this->toDate)) {
            $baseQuery->whereBetween('created_at', [
                Carbon::parse($this->fromDate)->startOfDay(),
                Carbon::parse($this->toDate)->endOfDay()
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

            if ($this->registrationType === 'onboarding' && !$isOnboarding)
                continue;
            if ($this->registrationType === 'new' && $isOnboarding)
                continue;

            $app = clone $latestRecord;

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

            $isLatestSender = $app->sender_user_id == $user->id;
            $isLatestReceiver = $app->application_receiver_user_id == $user->id;

            $senderUser = User::find($app->sender_user_id);
            $receiverUser = User::find($app->application_receiver_user_id);

            $senderName = $senderUser
                ? trim($senderUser->firstname . ' ' . $senderUser->lastname)
                : 'System';

            $receiverRole = 'Next Officer';
            if ($receiverUser && $receiverUser->designation) {
                $receiverRole = is_object($receiverUser->designation)
                    ? ($receiverUser->designation->designation ?? 'Next Officer')
                    : $receiverUser->designation;
            }
            $resubmitStatus = $app->resubmit_status ?? 0;
          $app->status_text = match (true) {
    $app->application_status === 'A' && $resubmitStatus == 1 => 'Application Resubmitted',
    $status === 'A'       => 'Application Submitted',
    $status === 'G'       => 'Application Reverted by ' . $senderName,   // ← add
    $status === 'E'       => 'Pulled Back from DA',                        // ← add
    $status === 'H'       => 'Pulled Back from RO',                        // ← add
    $status === 'M'       => 'At Office Admin',                            // ← add
    $status === 'N'       => 'At Head Office DA',                          // ← add
    $status === 'R'       => 'Application Renewal',                        // ← add
    $status === 'X'       => 'Application Cancelled',                      // ← add
    in_array($status, ['B', 'C', 'O']) && $pullBack == 1 => 'Pulled Back',

                in_array($status, ['B', 'C', 'O']) && $isLatestSender
                => 'Forwarded To ' . $receiverRole . ' by ' . $senderName,

                in_array($status, ['B', 'C', 'O']) && $isLatestReceiver
                => 'Received from ' . $senderName,

                in_array($status, ['B', 'C', 'O'])
                => 'Forwarded To ' . $receiverRole . ' by ' . $senderName,

                $status === 'D' => 'Rejected by ' . $senderName,
                $status === 'F' => 'Approved by ' . $senderName,

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

        return $applications;
    }














    //     public function collection()
//     {
//         if (!$this->userId) return collect();

    //         $user = User::find($this->userId);
//         if (!$user) return collect();

    //         // ✅ FIX 1: SAME AS DASHBOARD (IMPORTANT)
//         $baseQuery = WorkerApplicationStatus::where(function ($q) use ($user) {
//             $q->where('application_receiver_user_id', $user->id)
//               ->orWhere('sender_user_id', $user->id);
//         });

    //         if (!empty($this->fromDate) && !empty($this->toDate)) {
//             $baseQuery->whereBetween('created_at', [
//                 Carbon::parse($this->fromDate)->startOfDay(),
//                 Carbon::parse($this->toDate)->endOfDay()
//             ]);
//         }

    //         $applicationNumbers = $baseQuery->pluck('application_no')->unique();

    //         $applications = collect();

    //         foreach ($applicationNumbers as $appNo) {

    //             $allRecordsForApp = WorkerApplicationStatus::with(['mainWorker', 'applicationFromUser'])
//                 ->where('application_no', $appNo)
//                 ->orderBy('created_at', 'asc')
//                 ->orderBy('id', 'asc')
//                 ->get();

    //             if ($allRecordsForApp->isEmpty()) continue;

    //             // ✅ FIX 2: HANDLE RECEIVER + SENDER (HRO FIX)
//             $receiverRecord = $allRecordsForApp
//                 ->where('application_receiver_user_id', $user->id)
//                 ->first();

    //             $senderRecord = $allRecordsForApp
//                 ->where('sender_user_id', $user->id)
//                 ->first();

    //             if ($receiverRecord) {
//                 $firstRecordForThisOfficer = $receiverRecord;
//                 $officerIsSender = false;
//             } elseif ($senderRecord) {
//                 $firstRecordForThisOfficer = $senderRecord;
//                 $officerIsSender = true;
//             } else {
//                 continue;
//             }

    //             $latestRecord = $allRecordsForApp->last();

    //             $isOnboarding = optional($latestRecord->mainWorker)->already_registered == 1;

    //             if ($this->registrationType === 'onboarding' && !$isOnboarding) continue;
//             if ($this->registrationType === 'new' && $isOnboarding) continue;

    //             $app = clone $latestRecord;

    //             $app->latest_created_at = $latestRecord->created_at;
//             $app->latest_updated_at = $latestRecord->updated_at;
//             $app->officer_is_sender = $officerIsSender;

    //             // ✅ FIRST ENTRY LOGIC (HRO / RO FIX)
//             if ($officerIsSender) {
//                 $app->original_received_at = $allRecordsForApp->first()->created_at;
//                 $app->officer_action_date = $firstRecordForThisOfficer->created_at;
//             } else {
//                 $app->original_received_at = $firstRecordForThisOfficer->created_at;
//                 $app->officer_action_date = null;
//             }

    //             // ✅ FORWARDED FROM
//             if (is_numeric($firstRecordForThisOfficer->application_from_user)) {
//                 $fromUser = $firstRecordForThisOfficer->applicationFromUser;
//                 $app->forwarded_from_display = $fromUser
//                     ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
//                     : 'N/A';
//             } else {
//                 $username = $firstRecordForThisOfficer->application_from_user;
//                 $fromUser = $username ? User::where('username', $username)->first() : null;

    //                 $app->forwarded_from_display = $fromUser
//                     ? trim($fromUser->firstname . ' ' . $fromUser->lastname)
//                     : ($username ?? 'N/A');
//             }

    //             $applications->push($app);
//         }

    //         // ✅ STATUS TEXT (SAME STYLE AS DASHBOARD)
//         $applications = $applications->map(function ($app) use ($user) {

    //             $status = $app->application_status;
//             $pullBack = $app->pull_back ?? 0;

    //             $isLatestSender   = $app->sender_user_id == $user->id;
//             $isLatestReceiver = $app->application_receiver_user_id == $user->id;

    //             $senderUser = User::find($app->sender_user_id);
// $receiverUser = User::find($app->application_receiver_user_id);

    // $senderName = $senderUser
//     ? trim($senderUser->firstname . ' ' . $senderUser->lastname)
//     : 'System';

    // $receiverRole = 'Next Officer';

    // if ($receiverUser && $receiverUser->designation) {
//     if (is_object($receiverUser->designation)) {
//         $receiverRole = $receiverUser->designation->designation ?? 'Next Officer';
//     } else {
//         $receiverRole = $receiverUser->designation;
//     }
// }

    // $status = $app->application_status;
// $pullBack = $app->pull_back ?? 0;

    // $isLatestSender   = $app->sender_user_id == $user->id;
// $isLatestReceiver = $app->application_receiver_user_id == $user->id;

    // if ($status === 'A') {

    //     $app->status_text = 'Application Submitted';

    // } elseif (in_array($status, ['B','C','O']) && $pullBack == 1) {

    //     $app->status_text = 'Pulled Back';

    // } elseif (in_array($status, ['B','C','O']) && $isLatestSender) {

    //     // ✅ MAIN FIX HERE
//     $app->status_text = "Forwarded To {$receiverRole} by {$senderName}";

    // } elseif (in_array($status, ['B','C','O']) && $isLatestReceiver) {

    //     $app->status_text = "Received from {$senderName}";

    // } elseif (in_array($status, ['B','C','O'])) {

    //     $app->status_text = "Forwarded To {$receiverRole} by {$senderName}";

    // } elseif ($status === 'D') {

    //     $app->status_text = "Rejected by {$senderName}";

    // } elseif ($status === 'F') {

    //     $app->status_text = "Approved by {$senderName}";

    // } else {

    //     $app->status_text = 'Unknown Status';
// }

    //             return $app;
//         });

    //         // ✅ RECEIVED RANK
//         $applications = $applications
//             ->sortBy('original_received_at')
//             ->values()
//             ->map(function ($app, $index) {
//                 $app->received_rank = $index + 1;
//                 return $app;
//             });

    //         // ✅ COMPLETED
//         $completedApps = $applications
//             ->filter(function ($app) {
//                 if ($app->officer_is_sender) {
//                     $app->has_action_taken = true;
//                     return true;
//                 }

    //                 $hasBeenActioned =
//                     $app->latest_updated_at &&
//                     $app->original_received_at &&
//                     $app->latest_updated_at->timestamp != $app->original_received_at->timestamp;

    //                 $app->has_action_taken = $hasBeenActioned;
//                 return $hasBeenActioned;
//             })
//             ->sortBy(function ($app) {
//                 return $app->officer_is_sender
//                     ? $app->officer_action_date
//                     : $app->latest_updated_at;
//             })
//             ->values();

    //         $completedApps->each(function ($app, $index) {
//             $app->action_taken_rank = $index + 1;
//         });

    //         $applications = $applications->map(function ($app) use ($completedApps) {
//             $completed = $completedApps->firstWhere('id', $app->id);
//             if ($completed) {
//                 $app->action_taken_rank = $completed->action_taken_rank;
//                 $app->has_action_taken = true;
//             } else {
//                 $app->has_action_taken = false;
//             }
//             return $app;
//         });

    //         // ✅ FIFO
//         $applications = $applications->map(function ($app) use ($applications) {

    //             if ($app->has_action_taken && !empty($app->action_taken_rank)) {
//                 $app->fifo_status = $app->received_rank == $app->action_taken_rank ? 'Yes' : 'No';
//                 return $app;
//             }

    //             $violated = $applications->first(function ($other) use ($app) {
//                 return
//                     $other->received_rank > $app->received_rank &&
//                     $other->has_action_taken &&
//                     !empty($other->action_taken_rank);
//             });

    //             $app->fifo_status = $violated ? 'No' : 'Pending';
//             return $app;
//         });

    //         return $applications;
//     }

    public function headings(): array
    {
        $dateRange = '';

        if ($this->fromDate && $this->toDate) {
            $dateRange = 'Date Range: ' .
                Carbon::parse($this->fromDate)->format('d-m-Y') .
                ' to ' .
                Carbon::parse($this->toDate)->format('d-m-Y');
        }
        return [
            [$dateRange], // 👈 FIRST ROW
            [],           // 👈 EMPTY ROW (spacing)
            [
                'Application No',
                'Registration Type',
                // 'Forwarded From',
                'Received Date',
                'Duration (Days)',
                'Rank (Received)',
                'Action Taken Date',
                'Rank (Action Taken)',
                'FIFO Compliant',
                'Status',
            ]
        ];
    }

    public function map($app): array
    {
        $isOnboarding = $app->mainWorker?->already_registered == 1;
        $duration = Carbon::parse($app->original_received_at)->diffInDays(now());

        return [
            $app->application_no ?? 'N/A',
            $isOnboarding ? 'Onboarding' : 'New Registration',
            // $app->forwarded_from_display ?? 'N/A',
            Carbon::parse($app->original_received_at)->format('d-m-Y H:i'),
            $duration,
            $app->received_rank,
            ($app->has_action_taken && $app->latest_updated_at)
            ? Carbon::parse($app->latest_updated_at)->format('d-m-Y H:i')
            : 'Pending',
            $app->action_taken_rank ?? '-',
            $app->fifo_status ?? 'Pending',
            $app->status_text ?? 'Unknown',
        ];
    }
}
