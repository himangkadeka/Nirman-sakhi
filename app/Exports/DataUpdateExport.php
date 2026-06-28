<?php

namespace App\Exports;

use App\Models\MainWorkerForm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class DataUpdateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return MainWorkerForm::select(
            'worker_id',
            'ack_no',
            'office_id',
            'application_receiver_user_id',
            'application_sender_user_id',
            'id_card',
            'status',
            'rtps_trans_id',
            'created_at'
        )->get()->map(function ($item) {
            // Derive "Download ID Card" field (you can adjust logic here)
            $item->download_id_card = $item->id_card ? 'F' : 'A';
            return [
                $item->worker_id,
                $item->ack_no,
                $item->office_id,
                $item->application_receiver_user_id,
                $item->application_sender_user_id,
                $item->id_card,
                $item->download_id_card,
                $item->status,
                $item->rtps_trans_id,
                \Carbon\Carbon::parse($item->created_at)->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Application Number',
            'Ack No',
            'Office Code',
            'Application Receiver User ID',
            'Application Sender User ID',
            'ID Card',
            'Download ID Card',
            'Status',
            'RTPS Status',
            'Created At',
        ];
    }
}
