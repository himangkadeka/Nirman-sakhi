<?php

namespace App\Exports;

use App\Models\Office;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OfficeExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $offices = $this->data ?: Office::orderBy('office_id')->get();

        return collect($offices)->map(function ($office, $index) {
            return [
                'S.No' => $index + 1,
                'Office Name' => $office->office_name,
                'Total Count' =>  $office->total_count  === 0 ? '0' : $office->total_count,
                'New Registrations' => $office->new_registrations  === 0 ? '0' : $office->new_registrations,
                'Onboarding' => $office->onboarding  === 0 ? '0' : $office->onboarding,
                'Pending' => $office->pending  === 0 ? '0' : $office->pending,
                'New Approved' => $office->new_approved  === 0 ? '0' : $office->new_approved,
                'On Approved' =>$office->on_approved  === 0 ? '0' : $office->on_approved,
                // 'Approved' => (int) (($office->new_approved ?? 0) + ($office->on_approved ?? 0)),
                'Approved' => (($office->new_approved ?? 0) + ($office->on_approved ?? 0)) === 0 ? '0' : ($office->new_approved + $office->on_approved),
                'Rejected' => $office->rejected === 0 ? '0' : $office->rejected,
                'Reverted' =>$office->reverted === 0 ? '0' : $office->reverted,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Office Name',
            'Total Count',
            'New Registrations',
            'Onboarding',
            'Pending',
            'New Approved',
            'On Approved',
            'Approved',
            'Rejected',
            'Reverted',
        ];
    }
}
