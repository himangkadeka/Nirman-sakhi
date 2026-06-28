<?php

namespace App\Exports;

use App\Models\WorkerApplicationStatus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkerApplicationStatusExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return WorkerApplicationStatus::select('worker_id', 'ack_no', 'sender_role_id', 'sender_office_id', 'sender_user_id', 'application_from_user', 'application_receiver_user_id', 'application_receiver_role_id', 'application_status')->get();
    }

    public function headings(): array
    {
        return ['Worker Id', 'Ack No', 'Sender Role ID', 'Sender user ID', 'Sender office ID', 'Application from user', 'Application receiver user ID', 'Application receiver role ID', 'Application Status', 'Status'];
    }

}

