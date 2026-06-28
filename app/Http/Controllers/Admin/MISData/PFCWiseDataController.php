<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\PfcKioskDetail;
use App\Models\MainWorkerForm;
use App\Models\RenewWorkerForm;
use App\Models\WorkerPaymentSuccess;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\PfcKioskDetailExport;
use Maatwebsite\Excel\Facades\Excel;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Symfony\Component\HttpFoundation\StreamedResponse;


class PFCWiseDataController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // $pfcs = PfcKioskDetail::orderBy('id')->distinct('kiosk_registration_id')->get();
        $query = PfcKioskDetail::select(
            'kiosk_registration_id',
            DB::raw('MIN(kiosk_name) as kiosk_name'),
            DB::raw('MIN(user_type) as user_type'),
            DB::raw('MIN(id) as id'),
            DB::raw('MIN(created_at) as created_at') // Adjust aggregates as needed
        )
            ->where('is_login_csc', true)
            ->groupBy('kiosk_registration_id');
        // ->paginate(10);
        if (!empty($search)) {
            $query->havingRaw('MIN(kiosk_name) LIKE ?', ["%{$search}%"])
                ->orHavingRaw('MIN(user_type) LIKE ?', ["%{$search}%"]);
        }
        $pfcs = $query->paginate(10)->appends(['search' => $search]);
        $cscRtpsIds = PfcKioskDetail::where('is_login_csc', true)
            ->pluck('rtps_trans_id')
            ->filter(); // remove nulls

//        $main = MainWorkerForm::where('rtps_trans_id', '!=', null)->count();
        $totalNewWorkers = WorkerPaymentSuccess::where('csc_txn_id', '!=', null)->where('payment_type', 1)->count();
        $totalOnboarding = MainWorkerForm::whereIn('rtps_trans_id', $cscRtpsIds)
            ->where('already_registered', 1)
            ->count();
        $totalSubscriptions = WorkerPaymentSuccess::where('csc_txn_id', '!=', null)->where('payment_type', 2)->count();
        $totalRenewals = RenewWorkerForm::where('worker_id', '!=', null)->where('rtps_trans_id', '!=', null)->count();
        $totalTransactions = $totalNewWorkers + $totalSubscriptions + $totalRenewals + $totalOnboarding;

        $pfcList = PfcKioskDetail::where('is_login_csc', true)->get();

        return view('admin.mis-data.pfc-wise-data.index', compact('pfcList', 'pfcs', 'totalTransactions', 'totalNewWorkers', 'totalOnboarding', 'totalSubscriptions', 'totalRenewals'));
    }

    // In app/Models/PfcKioskDetail.php

    public function getNewWorkerCountTemp($kiosk_registration_id)
    {
        return WorkerPaymentSuccess::whereNotNull('csc_txn_id')
            ->where('payment_type', 1)// New worker
            ->where('kiosk_registration_id', $kiosk_registration_id)
            ->count();
    }

    public function getSubscriptionCount($kiosk_registration_id)
    {
        return WorkerPaymentSuccess::where('STATUS', 'F')
            ->whereNotNull('csc_txn_id')
            ->where('payment_type', 2)// Subscription
            ->where('kiosk_registration_id', $kiosk_registration_id)
            ->count();
    }

    public function getRenewalCount($kiosk_registration_id)
    {
        return RenewWorkerForm::whereNotNull('worker_id')
            ->whereNotNull('rtps_trans_id')
            ->where('kiosk_registration_id', $kiosk_registration_id)
            ->count();
    }

    public function getOnboardingCountTemp($kiosk_registration_id)
    {
        // 1. Get all rtps_trans_id from this kiosk where CSC login is true
        $rtpsIds = PfcKioskDetail::where('is_login_csc', true)
            ->where('kiosk_registration_id', $kiosk_registration_id)
            ->pluck('rtps_trans_id')
            ->filter();

        // 2. Count onboarding from MainWorkerForm
        return MainWorkerForm::whereIn('rtps_trans_id', $rtpsIds)
            ->where('already_registered', 1)
            ->count();
    }

    public function getCountTemp($kiosk_registration_id)
    {
        // Total transactions: new + onboarding + subscription + renewal
        return
            $this->getNewWorkerCountTemp($kiosk_registration_id) +
            $this->getOnboardingCountTemp($kiosk_registration_id) +
            $this->getSubscriptionCount($kiosk_registration_id) +
            $this->getRenewalCount($kiosk_registration_id);
    }

    public function districtWise(Request $request)
    {
        $districts = DB::table('Worker.pfc_kiosk_details as pk')
            ->join('Worker.main_worker_forms as mw', 'pk.rtps_trans_id', '=', 'mw.rtps_trans_id')
            ->join('Masterdata.districts as d', 'mw.district', '=', 'd.district_code')
            ->where('pk.is_login_csc', true)
            ->select(
                'd.district_code',
                'd.district_name',
                DB::raw('COUNT(*) as total_transactions')
            )
            ->groupBy('d.district_code', 'd.district_name')
            ->orderByDesc('total_transactions')
            ->paginate(20);

        return view('admin.mis-data.pfc-wise-data.district', compact('districts'));
    }

    public function officeWise(Request $request, $district_code)
    {
        $offices = DB::table('Worker.pfc_kiosk_details as pk')
            ->join('Worker.main_worker_forms as mw', 'pk.rtps_trans_id', '=', 'mw.rtps_trans_id')
            ->join('Masterdata.offices as o', 'mw.office_id', '=', 'o.office_id')
            ->where('pk.is_login_csc', true)
            ->where('o.district_code', $district_code)
            ->select(
                'o.office_id',
                'o.office_name',
                DB::raw('COUNT(*) as total_transactions')
            )
            ->groupBy('o.office_id', 'o.office_name')
            ->orderByDesc('total_transactions')
            ->paginate(20);

        $district = DB::table('Masterdata.districts')
            ->where('district_code', $district_code)
            ->first();

        return view('admin.mis-data.pfc-wise-data.office', compact('offices', 'district'));
    }


    public function export($type)
    {
        $fileName = 'ABOCWWB_Admin_PFC_Wise_Data_' . now()->format('Ymd_His') . '.' . $type;

        // Safety limits
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        // ================= PDF =================
        if ($type === 'pdf') {

            $rawData = PfcKioskDetail::select(
                'kiosk_registration_id',
                DB::raw('MIN(kiosk_name) as kiosk_name'),
                DB::raw('MIN(user_type) as user_type')
            )
                ->where('is_login_csc', true)
                ->groupBy('kiosk_registration_id')
                ->orderBy('kiosk_registration_id')
                ->get()
                ->mapInto(PfcKioskDetail::class);

            // ⚠️ Keep limited for PDF (important)
            $data = $rawData->take(500)->map(function ($item) {
                return [
                    'kiosk_name' => $item->kiosk_name ?? 'NA',
                    'user_type' => $item->user_type,
                    'new_worker' => $item->getNewWorkerCountTemp($item->kiosk_registration_id),
                    'onboarding' => $item->getOnboardingCountTemp($item->kiosk_registration_id),
                    'subscription' => $item->getSubscriptionCount($item->kiosk_registration_id),
                    'renewal' => $item->getRenewalCount($item->kiosk_registration_id),
                    'total' => $item->getCountTemp($item->kiosk_registration_id),
                ];
            });

            $pdf = PDF::loadView('admin.mis-data.pfc-wise-data.export-pdf', compact('data'))
                ->setPaper('a4', 'landscape');

            return $pdf->download($fileName);
        }

        // ================= CSV (FAST + STREAM) =================
        if ($type === 'csv') {

            return new StreamedResponse(function () {

                $handle = fopen('php://output', 'w');

                // Header
                fputcsv($handle, [
                    'Sno',
                    'PFC/CSC Name',
                    'User Type',
                    'Total No. of Transactions',
                    'Onboarding Registration',
                    'New Worker Registration',
                    'Worker Subscription',
                    'Worker Renewal'
                ]);

                $counter = 1;

                PfcKioskDetail::select(
                    'kiosk_registration_id',
                    DB::raw('MIN(kiosk_name) as kiosk_name'),
                    DB::raw('MIN(user_type) as user_type')
                )
                    ->where('is_login_csc', true)
                    ->groupBy('kiosk_registration_id')
                    ->orderBy('kiosk_registration_id')
                    ->chunk(200, function ($rows) use (&$counter, $handle) {

                        foreach ($rows as $pfc) {

                            fputcsv($handle, [
                                $counter++,
                                $pfc->kiosk_name ?? 'NA',
                                $pfc->user_type,
                                $pfc->getCountTemp($pfc->kiosk_registration_id),
                                $pfc->getOnboardingCountTemp($pfc->kiosk_registration_id),
                                $pfc->getNewWorkerCountTemp($pfc->kiosk_registration_id),
                                $pfc->getSubscriptionCount($pfc->kiosk_registration_id),
                                $pfc->getRenewalCount($pfc->kiosk_registration_id),
                            ]);
                        }
                    });

                fclose($handle);

            }, 200, [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
            ]);
        }

        // ================= EXCEL =================
        if ($type === 'xlsx') {

            return Excel::download(new \App\Exports\PfcKioskDetailExport, $fileName);
        }

        abort(404, 'Invalid export format.');
    }


}
