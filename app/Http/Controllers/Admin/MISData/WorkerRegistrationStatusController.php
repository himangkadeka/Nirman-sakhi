<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerForm;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\MainWorkerFormExport;
use Maatwebsite\Excel\Facades\Excel;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class WorkerRegistrationStatusController extends Controller
{
    // public function index(Request $request)
    // {
    //     $workerdata = MainWorkerForm::orderBy('id', 'desc')->paginate(2);
    //     return view('admin.mis-data.worker-registration-status.index', compact('workerdata'));


    // }
    public function index(Request $request)
    {
        $query = MainWorkerForm::query();


        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('ack_no', 'Ilike', "%{$search}%");

        }


        $workerdata = $query->orderBy('id', 'desc')->paginate(10)->appends(['search' => $request->search]);


        $count = MainWorkerForm::count();

        return view('admin.mis-data.worker-registration-status.index', compact('workerdata', 'count'));
    }

    public function export($type)
    {
        $fileName = 'ABOCWWB Admin Worker Registration Status.' . $type;

        if ($type === 'pdf') {
            $data = MainWorkerForm::select('ack_no', 'status')->get();
            $pdf = PDF::loadView('admin.mis-data.worker-registration-status.export-pdf', compact('data'));
            return $pdf->download($fileName);
        }

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(new MainWorkerFormExport, $fileName); // ✅ No ->header() here
        }

        abort(404, 'Invalid export format.');
    }
}
