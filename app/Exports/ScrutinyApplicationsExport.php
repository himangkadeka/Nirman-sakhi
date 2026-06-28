<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ScrutinyApplicationsExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    protected $submissions;

    public function __construct(Collection $submissions)
    {
        $this->submissions = $submissions;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->submissions;
    }

    public function headings(): array
    {
        return [
            'Application ID',
            'Applicant Name',
            'Applicant Aadhaar',
            'Benefit Scheme',
            'Submission Date',
            'Status',
        ];
    }

    public function map($submission): array
    {
        return [
            $submission->application_id,
            $submission->worker->name ?? 'N/A',
            $submission->worker->aadhaar_no ?? 'N/A', // Assuming you have aadhaar on the worker model
            $submission->benefit->name ?? 'N/A',
            $submission->created_at->format('Y-m-d H:i:s'),
            ucfirst($submission->status),
        ];
    }
}
