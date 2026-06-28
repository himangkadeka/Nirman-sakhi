<?php

namespace App\Exports;

use App\Models\PfcList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class PfcListExport implements FromCollection, WithHeadings
{

    public function collection()
    // {
    //     return PfcList::select('*')->get();
    // }
    {
        return PfcList::select('name_of_pfc', 'pfc_name', 'postal_address', 'pin_code', 'nearby_landmark', 'latitude', 'longitude')->get();
    }
     public function headings(): array
    {
        return ['District', 'PFC Name', 'Address', 'PIN', 'Landmark', 'Latitude', 'Longitude'];
    }
}
