<?php

namespace App\Exports;

use App\Models\WorkerApplicationStatus;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;


class OneClickApplicationStatusExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $exportData = collect();

        // ── Build officer query ──────────────────────────────────────────────
        $officerQuery = User::whereIn('role_id', [2, 3, 4])->with(['office', 'roles']);

        if (!empty($this->filters['office_id']))
            $officerQuery->where('office_id', $this->filters['office_id']);
        if (!empty($this->filters['role_id']))
            $officerQuery->where('role_id', $this->filters['role_id']);
        if (!empty($this->filters['officer_id']))
            $officerQuery->where('id', $this->filters['officer_id']);

        $officers = $officerQuery->get();

        foreach ($officers as $officer) {

            $officeName = $officer->office->office_name ?? 'N/A';
            $officerName = trim(($officer->firstname ?? '') . ' ' . ($officer->lastname ?? '')) ?: 'N/A';

            // ✅ HRO DETECTION via Spatie roles
            $isHro = $officer->roles->pluck('id')->contains(2);

            // ── STEP 1: Base query with HRO fallback ────────────────────────
            $baseQuery = WorkerApplicationStatus::where(function ($q) use ($officer, $isHro) {
                $q->where('application_receiver_user_id', $officer->id)
                    ->orWhere('sender_user_id', $officer->id);

                // ✅ HRO FALLBACK: catch applications submitted to this HRO's office
                // where application_receiver_user_id was never saved (routing bug)
                if ($isHro && $officer->office_id) {
                    $q->orWhere(function ($q2) use ($officer) {
                        $q2->where('office_id', $officer->office_id)
                            ->whereNull('application_receiver_user_id');
                    });
                }
            })
                ->when(
                    !empty($this->filters['fromDate']) && !empty($this->filters['toDate']),
                    function ($q) {
                        $q->whereBetween('created_at', [
                            Carbon::parse($this->filters['fromDate'])->startOfDay(),
                            Carbon::parse($this->filters['toDate'])->endOfDay(),
                        ]);
                    }
                );

            $applicationNumbers = $baseQuery->pluck('application_no')->unique();

            // if ($applicationNumbers->isEmpty()) continue;
            if ($applicationNumbers->isEmpty()) {
                $exportData->push([
                    $officerName,
                    $officeName,
                    0, // total
                    0, // acted
                    0, // fifo yes
                    0, // fifo no
                    0, // pending
                    '0%',
                ]);
                continue;
            }

            // ── STEP 2: Rebuild applications collection ──────────────────────
            $applications = collect();

            foreach ($applicationNumbers as $appNo) {

                $allRecordsForApp = WorkerApplicationStatus::with(['mainWorker'])
                    ->where('application_no', $appNo)
                    ->orderBy('created_at', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();

                if ($allRecordsForApp->isEmpty())
                    continue;

                // First try: app was explicitly routed to this officer
                $receiverRecord = $allRecordsForApp
                    ->where('application_receiver_user_id', $officer->id)
                    ->first();

                // ✅ HRO FALLBACK: receiver was never saved but app belongs to this office
                if (!$receiverRecord && $isHro && $officer->office_id) {
                    $receiverRecord = $allRecordsForApp
                        ->filter(
                            fn($r) =>
                            $r->office_id == $officer->office_id &&
                            is_null($r->application_receiver_user_id)
                        )
                        ->first();
                }

                $senderRecord = $allRecordsForApp
                    ->where('sender_user_id', $officer->id)
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

                // Registration type filter
                $isOnboarding = optional($latestRecord->mainWorker)->already_registered == 1;
                if (!empty($this->filters['registration_type'])) {
                    if ($this->filters['registration_type'] === 'onboarding' && !$isOnboarding)
                        continue;
                    if ($this->filters['registration_type'] === 'new' && $isOnboarding)
                        continue;
                }

                $app = clone $latestRecord;

                if ($officerIsSender) {
                    $app->original_received_at = $allRecordsForApp->first()->created_at;
                    $app->officer_action_date = $firstRecordForThisOfficer->created_at;
                } else {
                    $app->original_received_at = $firstRecordForThisOfficer->created_at;
                    $app->officer_action_date = null;
                }

                $app->latest_updated_at = $latestRecord->updated_at;
                $app->officer_is_sender = $officerIsSender;

                $applications->push($app);
            }

            if ($applications->isEmpty())
                continue;

            // ── STEP 3: Rank by original_received_at ────────────────────────
            $applications = $applications
                ->sortBy('original_received_at')
                ->values()
                ->map(function ($app, $index) {
                    $app->received_rank = $index + 1;
                    return $app;
                });

            // ── STEP 4: has_action_taken — mirrors controller exactly ────────
            $applications = $applications->map(function ($app) {
                $resubmitStatus = $app->resubmit_status ?? 0;
                if ($app->officer_is_sender) {
                    $app->has_action_taken = true;
                    return $app;
                }

                $app->has_action_taken =
                    $app->latest_updated_at &&
                    $app->original_received_at &&
                    $app->latest_updated_at->timestamp != $app->original_received_at->timestamp;

                return $app;
            });

            // ── STEP 5: Action taken rank ────────────────────────────────────
            $completedApps = $applications
                ->filter(fn($a) => $a->has_action_taken)
                ->sortBy(function ($app) {
                    return $app->officer_is_sender
                        ? $app->officer_action_date
                        : $app->latest_updated_at;
                })
                ->values();

            $completedApps->each(function ($app, $index) {
                $app->action_taken_rank = $index + 1;
            });

            $applications = $applications->map(function ($app) use ($completedApps) {
                $done = $completedApps->firstWhere('id', $app->id);
                $app->action_taken_rank = $done->action_taken_rank ?? null;
                return $app;
            });

            // ── STEP 6: FIFO — mirrors controller exactly ────────────────────
            $fifoYes = 0;
            $fifoNo = 0;
            $fifoPending = 0;

            foreach ($applications as $app) {
                if ($app->has_action_taken && !empty($app->action_taken_rank)) {
                    if ($app->received_rank == $app->action_taken_rank) {
                        $fifoYes++;
                    } else {
                        $fifoNo++;
                    }
                } else {
                    $violated = $applications->first(function ($other) use ($app) {
                        return
                            $other->received_rank > $app->received_rank &&
                            $other->has_action_taken &&
                            !empty($other->action_taken_rank);
                    });

                    if ($violated) {
                        $fifoNo++;
                    } else {
                        $fifoPending++;
                    }
                }
            }

            $totalApplications = $applications->count();
            $acted = $applications->filter(fn($a) => $a->has_action_taken)->count();
            $fifoPercent = $totalApplications > 0
                ? round(($fifoYes / $totalApplications) * 100, 2) . '%'
                : '0%';

            $exportData->push([
                $officerName,
                $officeName,
                $totalApplications,
                $acted,
                $fifoYes,
                $fifoNo,
                $fifoPending,
                $fifoPercent,
            ]);
        }

        return $exportData;
    }

    public function headings(): array
    {
        $dateRange = '';

        if (!empty($this->filters['fromDate']) && !empty($this->filters['toDate'])) {
            $dateRange = 'Date Range: ' .
                Carbon::parse($this->filters['fromDate'])->format('d-m-Y') .
                ' to ' .
                Carbon::parse($this->filters['toDate'])->format('d-m-Y');
        }
        return [
            [$dateRange],
            [],
            [
                'Officer',
                'Office',
                'Total Applications (in range)',
                'Acted (count)',
                'FIFO = YES',
                'FIFO = NO',
                'Pending (no action)',
                'FIFO %',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle("A2:H{$highestRow}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle("H2:H{$highestRow}")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D1FAE5']],
            'font' => ['bold' => true],
        ]);

        return [];
    }

    public function columnWidths(): array
    {
        return ['A' => 28, 'B' => 24, 'C' => 28, 'D' => 16, 'E' => 14, 'F' => 14, 'G' => 20, 'H' => 12];
    }
}
