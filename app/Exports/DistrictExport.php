<?php

namespace App\Exports;

use App\Models\District;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DistrictExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $districts = District::where('state_code', 18)
            ->select('district_name', 'district_code')
            ->get();

        // Append worker count to each district
        foreach ($districts as $district) {
            $district->worker_count = $district->getCount($district->district_code);
        }

        // Return mapped collection with 0 properly handled
        return $districts->map(function ($district) {
            return [
                'District Name' => $district->district_name,
                'District Code' => $district->district_code,
                'Worker Count' => $district->worker_count === 0 ? '0' : $district->worker_count,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'District Name',
            'District Code',
            'Worker Count',
        ];
    }
}
