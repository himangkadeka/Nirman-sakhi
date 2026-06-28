<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CancelledAppModal;
use App\Models\MainWorkerForm;
use App\Models\RenewWorkerForm;
use App\Models\RevertBack;
use App\Models\WorkerApplicationStatus;
use App\Services\AesCipher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $mainNew = 0;
        $countRejected = 0;
        $countPending = 0;
        $countApproved = 0;
        $countReverted = 0;
        $countNotResubmitted = 0;
        $countForwarded = 0;
        $rowCount = 0;

        $onboarding = 0;
        $resubmit_count = 0;
        $totalPendingOnboarding = 0;
        $approveOnboarding = 0;
        $onboardingRejected = 0;
        $onboardingReverted = 0;
        $onboardingNotResubmitted = 0;
        $totalOnboarding = 0;

        $New = 0;
        $totalPendingNew = 0;
        $approveNew = 0;
        $newRejected = 0;
        $newReverted = 0;
        $newNotResubmitted = 0;
        $totalNew = 0;
        $totalRenewal = 0;


        $mainNew = MainWorkerForm::count();

        $countRejected = CancelledAppModal::count();
        $countPending = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->count();
        $countApproved = MainWorkerForm::where('status', 'F')->count();
        $countReverted = RevertBack::where('status', 'G')->count();
        $newNotResubmitted =  RevertBack::where('status', 'G')->whereNull('already_registered')->count();
        $totalNotResubmitted = RevertBack::where('resubmit_status',0)->count();
        $countForwarded = MainWorkerForm::where('status', 'C')->count();
        $rowCount = $mainNew + $totalNotResubmitted + $countRejected;

        $onboarding = MainWorkerForm::where('already_registered', 1)->count();
//        $resubmit_count = MainWorkerForm::where('resubmit_status',1)->count();

        $totalPendingOnboarding = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->where('already_registered', 1)->count();
        $approveOnboarding = MainWorkerForm::where('status', 'F')->where('already_registered', 1)->count();
        $onboardingRejected = CancelledAppModal::where('already_registered', 1)->count();
        $onboardingReverted = RevertBack::where('status', 'G')->where('already_registered', 1)->count();
        $onboardingNotResubmitted = RevertBack::where('resubmit_status', 0)->where('already_registered', 1)->count();
        $totalOnboarding =   $onboarding + $onboardingNotResubmitted + $onboardingRejected;

        $New = MainWorkerForm::where('already_registered', null)->count();
        $totalPendingNew = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->whereNull('already_registered')->count();
        $approveNew = MainWorkerForm::where('status', 'F')->whereNull('already_registered')->count();
        $newRejected = CancelledAppModal::whereNull('already_registered')->count();
        $newReverted = RevertBack::where('status', 'G')->whereNull('already_registered')->count();
//        $newNotResubmitted = RevertBack::where('resubmit_status', 0)->where('already_registered', null)->count();

        $totalNew = $New + $newNotResubmitted + $newRejected;
//        $totalNotResubmitted = $onboardingNotResubmitted + $newNotResubmitted;
//        $countNotResubmitted = RevertBack::where('resubmit_status', 0)->count();

        $resubmit_count = $countReverted - $totalNotResubmitted;

        $totalRenewal = RenewWorkerForm::count();
        $todaysCount = MainWorkerForm::where('status', 'A')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $totals = MainWorkerForm::selectRaw('COUNT(*) as total, MIN(DATE(created_at)) as first_date, MAX(DATE(created_at)) as last_date')
            ->first();
        $days = Carbon::parse($totals->first_date)->diffInDays(Carbon::parse($totals->last_date)) + 1;

        $dailyAvg = round($totals->total / $days);


        $data = 0;   // same as get()

        // return $data;
        return view('admin.dashboard.index', compact('onboardingReverted','newReverted','newRejected',
            'onboardingRejected','approveOnboarding','approveNew','totalPendingOnboarding', 'totalPendingNew',
            'totalOnboarding', 'totalNew', 'data', 'countApproved', 'countPending', 'countForwarded',
            'countReverted', 'countRejected', 'rowCount','resubmit_count','totalRenewal','todaysCount','dailyAvg'));

    }
}
