<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerCertificate;
use App\Models\MainWorkerForm;
use App\Models\Office;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfessionWiseDataController extends Controller
{
 public function index()
{
    $offices = Office::orderBy('office_name')->where('status',1)->get();
    $onboardingQuery = DB::table('Worker.main_worker_basic_details as basic')
        ->join('Worker.main_worker_forms as forms', 'basic.worker_id', '=', 'forms.worker_id')
        ->select('basic.profession', 'forms.office_id')
        ->whereNotNull('basic.profession')
        ->whereNotNull('forms.office_id');

    $allWorkersQuery = DB::table('Worker.main_worker_certificates as certs')
        ->join('Worker.main_worker_forms as forms', 'certs.worker_id', '=', 'forms.worker_id')
        ->select('certs.profession', 'forms.office_id')
        ->whereNotNull('certs.profession')
        ->whereNotNull('forms.office_id')
        ->unionAll($onboardingQuery);

    $counts = DB::query()
        ->fromSub($allWorkersQuery, 'all_workers')
        ->join('Masterdata.professions as professions', 'all_workers.profession', '=', 'professions.profession_code')
        ->join('Masterdata.offices as offices', 'all_workers.office_id', '=', 'offices.office_id')
        ->select(
            'professions.profession_name',
            'offices.office_id',
            DB::raw('COUNT(*) as worker_count')
        )
        ->groupBy('professions.profession_name', 'offices.office_id')
        ->get();

    $reportData = [];
    $professions = Profession::orderBy('profession_name')->get();

    foreach ($professions as $profession) {
        $reportData[$profession->profession_name] = ['total' => 0];
        foreach ($offices as $office) {
            $reportData[$profession->profession_name][$office->office_id] = 0;
        }
    }

    foreach ($counts as $count) {
        if (isset($reportData[$count->profession_name])) {
            $reportData[$count->profession_name][$count->office_id] = $count->worker_count;
        }
    }

    foreach ($reportData as $professionName => &$data) {
        $rowTotal = 0;
        foreach ($offices as $office) {
            $rowTotal += $data[$office->office_id]; // <-- FIX
        }
        $data['total'] = $rowTotal;
    }

    $columnTotals = ['grand_total' => 0];
    foreach ($offices as $office) {
        $totalForOffice = array_sum(array_column($reportData, $office->office_id));
        $columnTotals[$office->office_id] = $totalForOffice;
        $columnTotals['grand_total'] += $totalForOffice;
    }

    return view('admin.mis-data.profession-wise-data.index', [
        'offices' => $offices,
        'reportData' => $reportData,
        'columnTotals' => $columnTotals,
    ]);
}
}
