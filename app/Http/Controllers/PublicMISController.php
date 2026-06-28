<?php

namespace App\Http\Controllers;

use App\Models\MainWorkerForm;
use App\Models\RevertBack;

class PublicMISController extends Controller
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
        $totalOnboarding =   $onboarding + $onboardingReverted;

        $New = MainWorkerForm::where('already_registered', null)->count();
        $totalPendingNew = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->where('already_registered', null)->count();
        $approveNew = MainWorkerForm::where('status', 'F')->where('already_registered', null)->count();
        $newRejected = MainWorkerForm::where('status', 'D')->where('already_registered', null)->count();
        $newReverted = RevertBack::where('status', 'G')->where('already_registered', null)->count();
        $totalNew = $New + $newReverted;

        $data = MainWorkerForm::get();

        return view('MIS', compact('onboardingReverted','newReverted','newRejected','onboardingRejected','approveOnboarding','approveNew','totalPendingOnboarding', 'totalPendingNew', 'totalOnboarding', 'totalNew', 'data', 'countApproved', 'countPending', 'countForwarded', 'countReverted', 'countRejected', 'rowCount'));

    }

}
