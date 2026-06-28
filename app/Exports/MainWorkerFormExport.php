<?php

namespace App\Exports;

use App\Models\MainWorkerForm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MainWorkerFormExport implements FromCollection , WithHeadings
{

    public function collection()
     {
        // return MainWorkerForm::select('ack_no', 'status')->get();
        $data = MainWorkerForm::select('ack_no', 'status', 'da_forward', 'pull_back')->get();
         foreach ($data as $item) {
            $item->status = match (true) {
                $item->status === 'A' => 'Application Submitted',
                $item->status === 'B' && $item->pull_back == 1 => 'Pulled Back',
                $item->status === 'B' && $item->da_forward == 1 => 'Sent By DA',
                $item->status === 'B' => 'Forwarded By DA',
                $item->status === 'C' => 'Forwarded By RO',
                $item->status === 'D' => 'Application Rejected',
                $item->status === 'E' => 'Pulled Back from DA',
                $item->status === 'F' => 'Application Approved',
                $item->status === 'G' => 'Application Reverted',

            };
        }
        return $data;
    }
     public function headings(): array
    {
        return ['Acknowledgement Number', 'Status'];
    }
    // {
    //     return MainWorkerForm::all();
    // }
}
