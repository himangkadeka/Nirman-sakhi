<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\District;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Exports\DistrictExport;
use Maatwebsite\Excel\Facades\Excel;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;


class DistrictWiseDataController extends Controller
{
    public function index(Request $request)
    {
        $districts = District::where('state_code', 18)
            ->orderBy('district_name')
            ->get();

        foreach ($districts as $district) {
            $code = $district->district_code;

            $district->new_count          = $district->getCountNew($code);
            $district->onboarding_count   = $district->getCountOnboarding($code);
            $district->total_count        = $district->getCount($code) + $district->getCountReject($code) + $district->getRevertNotSubmitted($code);
            $district->approved_count     = $district->getCountApp($code);
            $district->pending_count      = $district->getCountPending($code);
            $district->reverted_count     = $district->getCountReverted($code);
            $district->resubmitted_count  = $district->getResubmittedCount($code);
            $district->rejected_count     = $district->getCountReject($code);
        }

        $count = $districts->count();

        return view(
            'admin.mis-data.district-wise-data.index',
            compact('districts', 'count')
        );
    }


    public function export($type)
    {
        $fileName = 'Nirman Sakhi District Wise Data.' . $type;

        if ($type === 'pdf') {
            $districts = District::where('state_code', 18)
                ->select('district_name', 'district_code')
                ->get();
            foreach ($districts as $district) {
                $district->worker_count = $district->getCount($district->district_code);
            }
            $pdf = PDF::loadView('admin.mis-data.district-wise-data.export-pdf', [
                'data' => $districts
            ]);

            return $pdf->download($fileName);
        }

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(new DistrictExport, $fileName); // ✅ No ->header() here
        }

        abort(404, 'Invalid export format.');
    }


}
