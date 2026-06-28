<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerForm;
use App\Models\PfcKioskDetail;
use App\Models\PfcList;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\PfcListExport;
use Maatwebsite\Excel\Facades\Excel;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class PFCDataController extends Controller
{
    // public function index()
    // {

    //     $pfcdata = PfcList::all();
    //     return view('admin.mis-data.pfc-data.index', compact('pfcdata'));
    // }

    public function index(Request $request)
    {
        $query = PfcList::select('id', 'name_of_pfc', 'pfc_name', 'postal_address', 'pin_code','nearby_landmark', 'latitude', 'longitude','district_code');


        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name_of_pfc', 'like', "%{$search}%")
                    ->orWhere('pfc_name', 'like', "%{$search}%")
                    ->orWhere('postal_address', 'like', "%{$search}%")
                    ->orWhere('pin_code', 'like', "%{$search}%");
            });
        }

        $pfcdata = $query->paginate(10)->appends(['search' => $request->search]);
        $count = PfcList::count();

        return view('admin.mis-data.pfc-data.index', compact('pfcdata', 'count'));
    }

    public function export($type)
    {
        $fileName = 'ABOCWWB Admin PFC Data.' . $type;

        if ($type === 'pdf') {
            $data = PfcList::select('name_of_pfc', 'pfc_name', 'postal_address', 'pin_code', 'nearby_landmark', 'latitude', 'longitude')->get();
            // $pdf = Pdf::loadView('admin.mis-data.pfc-data.export-pdf', compact('data'));
            $pdf = PDF::loadView('admin.mis-data.pfc-data.export-pdf', compact('data'));
            return $pdf->download($fileName);
        }

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(new PfcListExport, $fileName); // ✅ No ->header() here
        }

        abort(404, 'Invalid export format.');
    }

}
