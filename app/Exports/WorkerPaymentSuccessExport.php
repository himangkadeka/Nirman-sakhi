<?php

namespace App\Exports;

use App\Models\WorkerPaymentSuccess;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class WorkerPaymentSuccessExport implements FromCollection, WithHeadings
{
     public function collection()
    {
        return WorkerPaymentSuccess::select(
        'worker_id',
        'PARTYNAME',
        'DEPARTMENT_ID',
        'payment_type',
        'STATUS',

        'AMOUNT',
        'BANKNAME',
        'GRN',
        'PRN',
        'created_at'
    )->get()->map(function ($payment) {
            return [
                $payment->worker_id,
                $payment->PARTYNAME,
                $payment->DEPARTMENT_ID,
                $payment->payment_type == 1 ? 'Registration' : 'Subscription',
                match ($payment->STATUS) {
                    'Y' => 'Success',
                    'N' => 'Failed',
                    'A' => 'Aborted',
                    default => 'Pending',
                },
                $payment->status,
                $payment->AMOUNT,
                $payment->BANKNAME,
                $payment->GRN,
                $payment->PRN,
                Carbon::parse($payment->created_at)->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Worker ID',
            'Party Name',
            'Transaction ID',
            'Payment Type',
            'Status',
            'Status',
            'Amount',
            'Bank Name',
            'GRN',
            'PRN',
            'Created At',
        ];
    }
}
