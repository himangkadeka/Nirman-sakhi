<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\UserLoginOtp;
use Illuminate\Http\Request;
use App\Models\MainWorkerForm;
use App\Models\RevertBack;
use App\Models\WorkerApplicationStatus;
use App\Services\AesCipher;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class MISDistrictWiseDataController extends Controller
{
    public function index()
    {
        $mainNew = MainWorkerForm::count();

        $countRejected = MainWorkerForm::where('status', 'D')->count();
        $countPending = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->count();
        $countApproved = MainWorkerForm::where('status', 'F')->count();

        $countReverted = RevertBack::where('status', 'G')->count();

        $countForwarded = MainWorkerForm::where('status', 'C')->count();
        $rowCount = $mainNew + $countReverted;

        $onboarding = MainWorkerForm::where('already_registered', 1)->count();

        $totalPendingOnboarding = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->where('already_registered', 1)->count();
        $approveOnboarding = MainWorkerForm::where('status', 'F')->where('already_registered', 1)->count();
        $onboardingRejected = MainWorkerForm::where('status', 'D')->where('already_registered', 1)->count();
        $onboardingReverted = RevertBack::where('status', 'G')->where('already_registered', 1)->count();
        $totalOnboarding = $onboarding + $onboardingReverted;

        $New = MainWorkerForm::where('already_registered', null)->count();
        $totalPendingNew = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->where('already_registered', null)->count();
        $approveNew = MainWorkerForm::where('status', 'F')->where('already_registered', null)->count();
        $newRejected = MainWorkerForm::where('status', 'D')->where('already_registered', null)->count();
        $newReverted = RevertBack::where('status', 'G')->where('already_registered', null)->count();
        $totalNew = $New + $newReverted;

        $data = MainWorkerForm::get();
        // return $data;
        return view('MIS', compact('onboardingReverted', 'newReverted', 'newRejected', 'onboardingRejected', 'approveOnboarding', 'approveNew', 'totalPendingOnboarding', 'totalPendingNew', 'totalOnboarding', 'totalNew', 'data', 'countApproved', 'countPending', 'countForwarded', 'countReverted', 'countRejected', 'rowCount'));
    }

    public function getDateRangeData(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $query = MainWorkerForm::query();

        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $filteredData = $query->get();

        return response()->json([
            'rowCount' => $filteredData->count(),
            'totalNew' => $filteredData->where('already_registered', null)->count(),
            'totalOnboarding' => $filteredData->where('already_registered', 1)->count(),
            'countApproved' => $filteredData->where('status', 'F')->count(),
            'countRejected' => $filteredData->where('status', 'D')->count(),
            'countReverted' => RevertBack::whereBetween('created_at', [$fromDate, $toDate])->where('status', 'G')->count(),
        ]);
    }

    public function getOtp()
    {
        $data = UserLoginOtp::orderBy('created_at', 'desc')->limit(20)->get();

        return view('admin.mis-data.all-users.user-otp',compact('data'));
    }



}
