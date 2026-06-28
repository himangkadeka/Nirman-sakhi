<?php

namespace App\Exports;

use App\Models\WorkerApplicationStatus;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class CombinedApplicationStatusExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithEvents
{
    protected array $filters;
    protected array $mergeRanges = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $exportData = collect();
        $currentRow = 2;

        $officerQuery = User::whereIn('role_id', [2, 3, 4])
            ->with(['office', 'roles']);

        if (!empty($this->filters['office_id'])) {
            $officerQuery->where('office_id', $this->filters['office_id']);
        }
        if (!empty($this->filters['role_id'])) {
            $officerQuery->where('role_id', $this->filters['role_id']);
        }
        if (!empty($this->filters['officer_id'])) {
            $officerQuery->where('id', $this->filters['officer_id']);
        }

        $officers = $officerQuery->get();

        foreach ($officers as $officer) {

            /** Officer Meta */
            $officeName  = $officer->office->office_name ?? 'N/A';
            $roleName    = $officer->roles->first()->name ?? 'N/A';
            $officerName = trim(($officer->firstname ?? '') . ' ' . ($officer->lastname ?? '')) ?: 'N/A';

            /** Applications Query */
            $query = WorkerApplicationStatus::with('mainWorker')
                ->where('application_receiver_user_id', $officer->id);

            if (!empty($this->filters['fromDate'])) {
                $query->whereDate('created_at', '>=', $this->filters['fromDate']);
            }
            if (!empty($this->filters['toDate'])) {
                $query->whereDate('created_at', '<=', $this->filters['toDate']);
            }

            $applications = $query
                ->orderBy('created_at')
                ->get()
                ->groupBy(fn ($app) =>
                    ((int) optional($app->mainWorker)->already_registered === 1)
                        ? 'Onboarding'
                        : 'New Registration'
                );

            if ($applications->isEmpty()) {
                continue;
            }

            /** ================= GROUP BY REGISTRATION TYPE ================= */
            foreach ($applications as $regType => $appsByType) {

                $applicationCount = $appsByType->count();
                $startRow = $currentRow;

                $appsByType = $appsByType->values();

                /** ===== Rank by Received Date ===== */
                $appsByType->each(function ($app, $i) {
                    $app->received_rank = $i + 1;
                });

                /** ===== Rank by Action Taken ===== */
                $completed = $appsByType
                    ->filter(fn ($a) => $a->updated_at && $a->updated_at->ne($a->created_at))
                    ->sortBy('updated_at')
                    ->values();

                $completed->each(function ($app, $i) {
                    $app->action_taken_rank = $i + 1;
                });

                $appsByType = $appsByType->map(function ($app) use ($completed) {
                    $done = $completed->firstWhere('id', $app->id);
                    $app->action_taken_rank = $done->action_taken_rank ?? null;
                    return $app;
                });

                /** ===== Export Rows ===== */
                foreach ($appsByType as $app) {

                    $duration = Carbon::parse($app->created_at)->diffInDays(now()) . ' days';

                    $statusText = match ($app->application_status) {
                        'A' => 'Submitted',
                        'B' => 'Forwarded (DA)',
                        'C' => 'Forwarded (RO)',
                        'D' => 'Rejected',
                        'F' => 'Approved',
                        'G' => 'Reverted',
                        default => 'Pending',
                    };

                    /** FIFO Logic */
                    if ($app->action_taken_rank) {
                        $fifo = ($app->received_rank === $app->action_taken_rank) ? 'Yes' : 'No';
                    } else {
                        $violated = $appsByType->first(fn ($o) =>
                            $o->received_rank > $app->received_rank &&
                            !empty($o->action_taken_rank)
                        );
                        $fifo = $violated ? 'No' : 'Pending';
                    }

                    $exportData->push([
                        $officeName,
                        $roleName,
                        $officerName,
                        $regType,
                        $applicationCount,
                        $app->application_no ?? 'N/A',
                        Carbon::parse($app->created_at)->format('d-m-Y'),
                        $duration,
                        $app->received_rank,
                        $app->action_taken_rank
                            ? Carbon::parse($app->updated_at)->format('d-m-Y h:i A')
                            : 'Pending',
                        $app->action_taken_rank ?? 'Pending',
                        $fifo,
                        $statusText,
                    ]);

                    $currentRow++;
                }

                $endRow = $currentRow - 1;

                if ($endRow > $startRow) {
                    $this->mergeRanges[] = [
                        "A{$startRow}:A{$endRow}",
                        "B{$startRow}:B{$endRow}",
                        "C{$startRow}:C{$endRow}",
                        "D{$startRow}:D{$endRow}",
                        "E{$startRow}:E{$endRow}",
                    ];
                }
            }
        }

        return $exportData;
    }

    public function headings(): array
    {
        return [
            'Office',
            'Role',
            'Officer',
            'Registration Type',
            'Count',
            'Application No',
            'Received Date',
            'Duration',
            'Rank (Received)',
            'Action Taken Date',
            'Rank (Action Taken)',
            'FIFO Compliant',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle("A2:M{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 28, 'B' => 22, 'C' => 25, 'D' => 20, 'E' => 10,
            'F' => 18, 'G' => 15, 'H' => 12, 'I' => 10,
            'J' => 18, 'K' => 18, 'L' => 15, 'M' => 18,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                foreach ($this->mergeRanges as $ranges) {
                    foreach ($ranges as $range) {
                        $sheet->mergeCells($range);
                        $sheet->getStyle($range)->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                            ->setVertical(Alignment::VERTICAL_CENTER);
                    }
                }
            },
        ];
    }
}
