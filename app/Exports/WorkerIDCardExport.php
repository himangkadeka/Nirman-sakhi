<?php

namespace App\Exports;

use App\Models\WorkerIDCard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkerIDCardExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return WorkerIDCard::select('worker_id', 'certificate_upload_date')->get();
    }

    public function headings(): array
    {
        return ['Worker ID', 'Certificate UploadDate'];
    }
}

