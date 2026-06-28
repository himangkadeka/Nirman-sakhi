<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\CancelledAppModal;
use App\Models\MainWorkerForm;
use App\Models\Reasons;
use App\Models\RenewWorkerForm;
use App\Models\RevertBack;
use App\Models\User;
use App\Models\WorkerApplicationStatus;
use App\Services\AesCipher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mpdf\Tag\Main;
use Spatie\Permission\Models\Role;
use Illuminate\Pagination\Paginator;
use RealRashid\SweetAlert\Facades\Alert;

class OfficeDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:office dashboard', ['only' => ['index']]);
    }



    public function index(Request $request)
    {
        $userDetails = Auth::user();
        Paginator::useBootstrap();

        try {

            switch ($userDetails->role_id) {
                case 2:

                    //head & registering Officer
                    $rowCount = 0;
                    $countResubmitted = 0;
                    $new = MainWorkerForm::where('office_id', $userDetails->office_id)
//                        ->where('resubmit_status',0)
////                        ->distinct('ack_no')
                        ->where('payment_status', 'success')->count();
                    $countRejected = WorkerApplicationStatus::where('application_status', 'D')
                        ->where('sender_user_id', $userDetails->id)
//                        ->distinct('ack_no')
                        ->count();

                    $countReverted = WorkerApplicationStatus::where('application_status', 'G')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',0)
//                        ->distinct('ack_no')
                        ->count();

                    $countResubmitted = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('resubmit_status', 1)
                        ->where('application_receiver_user_id', $userDetails->id)
//                        ->where('payment_status', 'success')
                        ->whereIn('status', ['A', 'B'])
                        ->count();



                    $countReRouted = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('re_route',1)
//                        ->distinct('ack_no')
                        ->whereNull('da_forward')
                        ->where('status', 'B')
                        ->where('payment_status', 'success')->count();


//                   $countReviewed =  MainWorkerForm::where('status', 'B')
//                        ->where('office_id', Auth::user()->office_id)
//                        ->where('application_receiver_user_id', $userDetails->id)
//
//                        ->where('payment_status', 'success')
//                        ->count();
                       $countReviewed = MainWorkerForm::where('status', 'B')
                        ->where('office_id', Auth::user()->office_id)
                        ->where('application_receiver_user_id', Auth::user()->id)
                        ->where('payment_status', 'success')
                        ->where('da_forward', 1)
                        ->where('is_renewal',0)
                        ->orderBy('created_at', 'asc')
                        ->where('pull_back', null)
                        ->count();

                        $countPullBack = MainWorkerForm::where('status', 'B')
                        ->where('office_id', Auth::user()->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('pull_back',1)
                        ->where('is_renewal',0)
                        ->where('payment_status', 'success')
                        ->count();


                    $rowMain = WorkerApplicationStatus::where('application_status', 'A')
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('is_renewal',0)
                        ->distinct('worker_id')
                        ->count();
                    $chartData = MainWorkerForm::select(
                        DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                        DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                        DB::raw('COUNT(*) as count')
                    )
                        ->where('office_id', $userDetails->office_id)
                        ->where('payment_status', 'success')
                        ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)'))
                        ->get();

                    $countApproved = MainWorkerForm::where('status', 'F')
                        ->where('office_id', $userDetails->office_id)
//                        ->where('is_renewal',0)
//                        ->where('sender_user_id',$userDetails->id)
                        ->count();

                    $countPending = MainWorkerForm::where('status', 'A')
                        ->where('office_id', $userDetails->office_id)
                        ->whereNull('da_forward')
                        ->where('payment_status', 'success')
                        ->count();

                    $NewRejected = CancelledAppModal::where('district', $userDetails->district)
                        ->where('office_id', $userDetails->office_id)
                        ->count();
                    $reject_old = MainWorkerForm::where('status',  'D')
                        ->where('district', $userDetails->district)
                        ->where('office_id', $userDetails->office_id)
                        ->where('payment_status', 'success')
                        ->count();


                    // $countForwarded = MainWorkerForm::whereIn('status', ['O', 'C'])
                    //     ->where('district', $userDetails->district)
                    //     ->where('office_id', $userDetails->office_id)
                    //     ->where('payment_status', 'success')
                    //     ->count();
                        $countForwarded = MainWorkerForm::where('application_sender_user_id', Auth::user()->id)
                        ->whereIn('status', ['O', 'C'])
                        ->where('is_renewal',0)
                        ->count();
                    $rowCount = $new;
//                        $rowCount = $new + $countResubmitted;
                    $data = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('already_registered', null)
                        ->where('resubmit_status', 0)
                        ->where('status', 'A')
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')
                        ->get(); // 10 per page, change as needed




                    $onboarding_data = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('already_registered',1)
                        ->where('resubmit_status',0)
                        ->where('status', 'A')
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')
                        ->get();

                    $resubmitted_data = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('resubmit_status',1)
                        ->where('application_receiver_user_id',$userDetails->id)
                        ->whereIn('status', ['A', 'B'])
                        ->orderBy('created_at','asc')
//                        ->where('payment_status', 'success')
                        ->get();

                    $new_Pending = MainWorkerForm::where('status', 'A')
                        ->where('office_id', $userDetails->office_id)
                        ->where('already_registered',null)
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')

                        ->count();
                    $onboarding_Pending = MainWorkerForm::where('status', 'A')
                        ->where('office_id', $userDetails->office_id)
                        ->where('already_registered',1)
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->count();
                    $resubmitted_Pending = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('resubmit_status',1)
                        ->where('application_receiver_user_id',$userDetails->id)
                        ->whereIn('status', ['A', 'B'])
                        ->orderBy('created_at','asc')
//                        ->where('payment_status', 'success')
                        ->count();
                    //Renewal Details

                    $newRenewal = RenewWorkerForm::where('office_id', $userDetails->office_id)
//                        ->distinct('ack_no')
                        ->where('payment_status', 'success')->count();
                    $revertedRenewal = WorkerApplicationStatus::where('application_status', 'G')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',1)
//                        ->distinct('ack_no')
                        ->count();

                    $countRenewal = $newRenewal;

                    $renewal_Pending = RenewWorkerForm::where('status', 'A')
                        ->where('office_id', $userDetails->office_id)
                        ->where('payment_status', 'success')
                        ->count();

                    $countForwardedRenewal = RenewWorkerForm::where('application_sender_user_id', Auth::user()->id)
                        ->whereIn('status', ['O', 'C'])
                        ->where('office_id', $userDetails->office_id)
//                        ->distinct('ack_no')
                        ->count();

                    $countApprovedRenewal = RenewWorkerForm::where('status', 'F')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_sender_user_id',$userDetails->id)
                        ->count();

                    $countRejectedRenewal = WorkerApplicationStatus::where('application_status', 'D')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',1)
//                        ->distinct('ack_no')
                        ->count();

                    $countRevertedRenewal = WorkerApplicationStatus::where('application_status', 'G')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',1)
//                        ->distinct('ack_no')
                        ->count();
                    $countResubmittedRenewal = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('resubmit_status',1)
                        ->whereIn('status',['A','B'])
                        ->where('application_receiver_user_id',$userDetails->id)
                        ->count();

                    $countReviewedRenewal =  RenewWorkerForm::where('status', 'B')
                        ->where('office_id', Auth::user()->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('da_forward',1)
                        ->count();

                    $countPullBackRenewal = RenewWorkerForm::where('status', 'B')
                        ->where('office_id', Auth::user()->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('pull_back',1)
                        ->where('payment_status', 'success')
                        ->count();


                    // $status = WorkerApplicationStatus::where('worker_id', $userDetails->worker_id)->first();

                    $dataRen = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('status', 'A')
                        ->orderBy('created_at','asc')
                        ->get();
                    $notificationCount = MainWorkerForm::where('district', $userDetails->district)
                        ->where('office_id', $userDetails->office_id)
                        ->where('status', 'A')
                        ->where('payment_status', 'success')
                        ->count();
                    break;


                case 3:

                    // RO
                    $countResubmitted = 0;
                    $countReRouted = 0;
                    $rowCountMain = WorkerApplicationStatus::where('application_receiver_user_id', $userDetails->id)
                        ->where('is_renewal',0)
                        ->distinct('worker_id')
                        ->count();
                    $NewRejected = CancelledAppModal::where('office_id', $userDetails->office_id)
                        ->count();

                    $countReviewed =  MainWorkerForm::where('status', 'O')
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('office_id', $userDetails->office_id)
                        ->where('da_forward', 1)
                        ->where('is_renewal',0)
                        ->where('pull_back', null)
                        ->orderBy('created_at', 'asc')
                        ->where('payment_status', 'success')
                        ->count();

                    $countResubmitted = MainWorkerForm::where('status', 'O')
                        ->where('office_id', $userDetails->office_id)
                        ->where('resubmit_status',1)
                        ->where('application_receiver_user_id',$userDetails->id)
                        ->where('payment_status', 'success')
                        ->count();

                    $rowCountRen = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')->count();

                    $countReverted = WorkerApplicationStatus::where('application_status', 'G')
                        ->where('sender_office_id', $userDetails->office_id)
                        ->where('sender_user_id', $userDetails->id)
//                        ->distinct('ack_no')
                        ->count();



                    $countPullBack = MainWorkerForm::where('status', 'O')
                    ->where('office_id', Auth::user()->office_id)
                    ->where('application_receiver_user_id', $userDetails->id)
                    ->where('pull_back',1)

                    ->where('payment_status', 'success')
                    ->count();


                    $chartData = MainWorkerForm::select(
                        DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                        DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                        DB::raw('COUNT(*) as count')
                    )
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')
                        ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)'))
                        ->get();

                    $countApprovedMain = MainWorkerForm::where('status', 'F')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')->count();


                    $countApproved = $countApprovedMain;


                    $mainPending = MainWorkerForm::where('office_id', Auth::user()->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('status', 'O')
                        ->whereNull('da_forward')
                        ->where('payment_status', 'success')->count();

                    $countPending =  $mainPending;




                    $reject_old = MainWorkerForm::where('status',  'D')
                        ->where('district', $userDetails->district)
                        ->where('office_id', $userDetails->office_id)
                        ->where('payment_status', 'success')
                        ->count();


                    $countRejected = WorkerApplicationStatus::where('application_status', 'D')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',0)
////                        ->distinct('ack_no')
                        ->count();

                    $countReverted = WorkerApplicationStatus::where('application_status', 'G')
                        ->where('sender_office_id', $userDetails->office_id)
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',0)
////                        ->distinct('ack_no')
                        ->count();
                    $MainForwarded = MainWorkerForm::where('application_sender_user_id', Auth::user()->id)
                        ->where('status', 'C')
                        ->where('is_renewal',0)
                        ->count();
////                        ->distinct('ack_no')

                    $RenewForwarded = RenewWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')->count();
                    $countForwarded = $MainForwarded;

                    //total applications

                    $rowCount = $rowCountMain + $countReverted + $countRejected - $countResubmitted;
                    $data = MainWorkerForm::where('status', 'O')
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('office_id', $userDetails->office_id)
                        ->where('already_registered',null)
                        ->whereNull('da_forward')
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')
                        ->get();


                    $onboarding_data = MainWorkerForm::where('status', 'O')
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('office_id', $userDetails->office_id)
                        ->where('already_registered',1)
                        ->where('resubmit_status',0)
                        ->whereNull('da_forward')
                        ->where('payment_status', 'success')
                        ->orderBy('created_at')
                        ->get();

                    $resubmitted_data = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('resubmit_status',1)
                        ->where('status', 'O')
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')
                        ->get();

                    $new_Pending = MainWorkerForm::where('status', 'O')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',null)
                        ->whereNull('da_forward')
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->count();
                    $onboarding_Pending = MainWorkerForm::where('status', 'O')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',1)
                        ->whereNull('da_forward')
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->count();
                    $resubmitted_Pending = MainWorkerForm::where('status', 'O')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('resubmit_status',1)
                        ->whereNull('da_forward')
                        ->where('payment_status', 'success')
                        ->count();

//                    $newRenewal = RenewWorkerForm::where('office_id', $userDetails->office_id)
////                        ->distinct('ack_no')
//                        ->where('payment_status', 'success')->count();
                    $revertedRenewal = WorkerApplicationStatus::where('application_status', 'G')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',1)
////                        ->distinct('ack_no')
                        ->count();

//                    $countRenewal = $newRenewal+$revertedRenewal;
                    $countRenewal = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('status', 'O')
                        ->whereNull('da_forward')
                        ->orderBy('created_at', 'asc')
                        ->where('payment_status', 'success')
                        ->count();

                    $renewal_Pending = RenewWorkerForm::where('office_id', Auth::user()->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('status', 'O')
                        ->whereNull('da_forward')
                        ->where('payment_status', 'success')->count();

                    $countForwardedRenewal = RenewWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_sender_user_id', $userDetails->id)
                        ->where('payment_status', 'success')->count();

                    $countApprovedRenewal = WorkerApplicationStatus::where('application_status', 'F')
                        ->where('sender_office_id', $userDetails->office_id)
                        ->where('sender_user_id',$userDetails->id)
                        ->where('is_renewal',1)
                        ->count();

                    $countRejectedRenewal = WorkerApplicationStatus::where('application_status', 'D')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',1)
////                        ->distinct('ack_no')
                        ->count();

                    $countRevertedRenewal = WorkerApplicationStatus::where('application_status', 'G')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',1)
////                        ->distinct('ack_no')
                        ->count();
                    $countResubmittedRenewal = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('resubmit_status',1)
                      ->where('status', 'O')
                        ->where('application_receiver_user_id',$userDetails->id)
                        ->count();

                    $countReviewedRenewal =  RenewWorkerForm::where('status', 'O')
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('office_id', Auth::user()->office_id)
                        ->where('da_forward', 1)
                        ->where('payment_status', 'success')
                        ->count();

                    $countPullBackRenewal = RenewWorkerForm::where('status', 'O')
                        ->where('office_id', Auth::user()->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('pull_back',1)
//                        ->where('is_renewal',1)
                        ->where('payment_status', 'success')
                        ->count();


                    $notificationCount = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('status', 'O')
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')
                        ->count();

                    $dataRen = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('status', 'O')
                        ->whereNull('da_forward')
                        ->orderBy('created_at', 'asc')
                        ->where('payment_status', 'success')
                        ->get();
                        // if($userDetails->id==24){
                        //     return $notificationCount;
                        // }

                    // $status = WorkerApplicationStatus::where('office_id',$userDetails->office_id)->first();
                    // $created_at = $status->created_at;
                    //                    dd($created_at);
                    break;

                case 4:
                    // DA
                    $countPullBack = 0;
                    $countReviewed = 0;
                    $countRejected = 0;
                    $countResubmitted = 0;
                    $countReRouted = 0;
                    $countRenewal = 0;
                    $mainPending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')->count();
                    $renewPending = RenewWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')->count();
                    $countPending = $mainPending;
                    $countApproved = 0;
                    $countReverted = 0;
                    //                    $countForwarded = 0;
                    $countForwarded = MainWorkerForm::where('application_sender_user_id', $userDetails->id)
                        ->where('is_renewal',0)
                        ->where('da_forward',1)
                        ->where('payment_status', 'success')
                        ->count();
                    $rowMain = WorkerApplicationStatus::where('application_receiver_user_id', $userDetails->id)
                        ->where('application_status','C')
                        ->where('is_renewal',0)
//                        ->distinct('worker_id')
                        ->count();
//                    $countRenewal = RenewWorkerForm::where('status', 'C')
//                        ->where('application_receiver_user_id', $userDetails->id)
//                        ->where('is_renewal',1)
//                        ->where('payment_status', 'success')
//                        ->count();

                    $rowCount = $rowMain;

                    $chartData = MainWorkerForm::select(
                        DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                        DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                        DB::raw('COUNT(*) as count')
                    )
                        ->where('status', 'C')
                        ->where('payment_status', 'success')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)'))->where('payment_status', 'success')
                        ->get();

                    $data = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('already_registered',null)
                        ->where('resubmit_status',0)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')
                        ->orderBy('created_at')->get();


                    $dataRen = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('status', 'C')
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')->get();
                    $onboarding_data = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',1)
                        ->where('resubmit_status',0)
                        ->where('status', 'C')
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')->get();

                    $resubmitted_data = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('resubmit_status',1)
                        ->where('status', 'C')
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')
                        ->get();

                    $new_Pending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',null)
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->count();
                    $onboarding_Pending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',1)
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->count();
                    $resubmitted_Pending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('resubmit_status',1)
                        ->where('payment_status', 'success')
                        ->count();

                    $renewal_Pending = RenewWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')
                        ->count();

                    $countRenewal = WorkerApplicationStatus::where('application_receiver_user_id', $userDetails->id)
                        ->where('is_renewal', 1)
                        ->whereIn('resubmit_status', [0, 1])
//                        ->distinct('worker_id')
                        ->count();


                    $renewal_Pending = RenewWorkerForm::where('office_id', Auth::user()->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->whereNull('da_forward')
                        ->where('payment_status', 'success')->count();


                    $countForwardedRenewal = WorkerApplicationStatus::where('sender_user_id', $userDetails->id)
                    ->whereIn('application_status', ['O', 'B'])
                    ->where('is_renewal',1)
                        ->where('da_forward',1)
                        ->count();

                    $countApprovedRenewal = WorkerApplicationStatus::where('application_status', 'F')
                        ->where('sender_office_id', $userDetails->office_id)
                        ->where('sender_user_id',$userDetails->id)
                        ->where('is_renewal',1)
                        ->count();

                    $countRejectedRenewal = WorkerApplicationStatus::where('application_status', 'D')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',1)
////                        ->distinct('ack_no')
                        ->count();

                    $countRevertedRenewal = WorkerApplicationStatus::where('application_status', 'G')
                        ->where('sender_user_id', $userDetails->id)
                        ->where('is_renewal',1)
//                        ->distinct('ack_no')
                        ->count();
                    $countResubmittedRenewal = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('resubmit_status',1)
                        ->where('application_receiver_user_id',$userDetails->id)
                        ->count();
                    $countPullBackRenewal = MainWorkerForm::where('status', 'B')
                        ->where('office_id', Auth::user()->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('pull_back',1)
                        ->where('is_renewal',1)
                        ->where('payment_status', 'success')
                        ->count();

                    $countReviewedRenewal =  0;


                    $notificationCount = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->whereIn('status', ['C'])
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')
                        ->count();
                    // $status = WorkerApplicationStatus::where('sender_office_id',$userDetails->office_id)
                    //     ->where('application_receiver_user_id',$userDetails->id)
                    //     ->first();

                    // $created_at = $status->created_at;
                    break;

                case 5:
                    //head office
                    $dataRen = [];
                    $countPullBack = 0;
                    $countReviewed = 0;
                    $countReRouted = 0;
                    $chartData = [];
                    $rowCount = WorkerApplicationStatus::where('application_status', 'M')->count();
                    $chartData = MainWorkerForm::select(
                        DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                        DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                        DB::raw('COUNT(*) as count')
                    )
                        ->where('district', $userDetails->district)
                        ->where('payment_status', 'success')
                        ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)'))
                        ->get();
                    $notificationCount = MainWorkerForm::where('district', $userDetails->district)
                        ->whereIn('status', ['N'])
                        ->where('payment_status', 'success')
                        ->count();


                    $countApproved = MainWorkerForm::where('status', 'F')->where('office_id', $userDetails->office_id)->where('payment_status', 'success')->count();
                    $countPending = MainWorkerForm::where('status', 'N')->count();
                    $countRejected = MainWorkerForm::where('status', 'D')->where('office_id', $userDetails->office_id)->where('payment_status', 'success')->count();
                    $countReverted = RevertBack::where('status', 'G')
                        ->where('office_id', $userDetails->office_id)
////                        ->distinct('ack_no')
                        ->count('ack_no');

                    $countForwarded = WorkerApplicationStatus::where('sender_user_id', $userDetails->id)->where('application_status','N')->count();
                    $onboarding_data = MainWorkerForm::where('office_id', $userDetails->office_id)
                    ->where('application_receiver_user_id', $userDetails->id)
                    ->where('already_registered',1)
                    ->where('resubmit_status',0)
                    ->where('status', 'C')
                    ->where('payment_status', 'success')
                    ->orderBy('created_at','asc')
                    ->get();

                $resubmitted_data = MainWorkerForm::where('office_id', $userDetails->office_id)
                    ->where('application_receiver_user_id', $userDetails->id)
                    ->where('resubmit_status',1)
                    ->where('status', 'C')
                    ->where('payment_status', 'success')
                    ->orderBy('created_at','asc')
                    ->get();

                    $new_Pending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',null)
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->count();
                    $onboarding_Pending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',1)
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->count();
                    $resubmitted_Pending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('resubmit_status',1)
                        ->where('payment_status', 'success')
                        ->count();

                    $renewal_Pending = RenewWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')
                        ->count();
                    $countResubmitted = 0;
                    $countRenewal =0;

                    $renewal_Pending = 0;

                    $countForwardedRenewal =0;

                    $countApprovedRenewal = 0;

                    $countRejectedRenewal = 0;

                    $countRevertedRenewal = 0;
                    $countResubmittedRenewal = 0;

                    $countReviewedRenewal = 0;
                    $countPullBackRenewal = 0;


                    // $status = WorkerApplicationStatus::where('worker_id', $userDetails->worker_id)->first();

                    $dataRen = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->whereIn('status', ['A'])
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')
                        ->get();

                    $data = MainWorkerForm::where('district', $userDetails->district)->whereIn('status', ['M'])->where('payment_status', 'success')->orderBy('created_at')->get();
                    // $status = WorkerApplicationStatus::where('office_id',$userDetails->office_id)->first();
                    // $created_at = $status->created_at;
                    //                    dd($created_at);
                    break;
                case 18:
                    //head office Da
                    $dataRen = [];
                    $countPullBack = 0;
                    $countReviewed = 0;
                    $chartData = [];
                    $rowCount = WorkerApplicationStatus::where('application_receiver_user_id',$userDetails->id)->where('application_status', 'N')->count();
                    $chartData = MainWorkerForm::select(
                        DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                        DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                        DB::raw('COUNT(*) as count')
                    )
                        ->where('district', $userDetails->district)
                        ->where('payment_status', 'success')
                        ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)'))
                        ->get();
                    $notificationCount = MainWorkerForm::where('district', $userDetails->district)
                        ->whereIn('status', ['M'])
                        ->where('payment_status', 'success')
                        ->count();


                    $countApproved = MainWorkerForm::where('status', 'F')->where('office_id', $userDetails->office_id)->where('payment_status', 'success')->count();
                    $countPending = MainWorkerForm::where('application_receiver_user_id',$userDetails->id)->where('status', 'N')->count();
                    $countRejected = MainWorkerForm::where('status', 'D')->where('office_id', $userDetails->office_id)->where('payment_status', 'success')->count();
                    $countReverted = RevertBack::where('status', 'G')
                        ->where('office_id', $userDetails->office_id)
////                        ->distinct('ack_no')
                        ->count('ack_no');

                    $countForwarded = WorkerApplicationStatus::where('sender_user_id', $userDetails->id)->where('application_status','M')->count();
                    $onboarding_data = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',1)
                        ->where('resubmit_status',0)
                        ->where('status', 'C')
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')
                        ->get();

                    $resubmitted_data = MainWorkerForm::where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('resubmit_status',1)
                        ->where('status', 'C')
                        ->where('payment_status', 'success')
                        ->orderBy('created_at')
                        ->get();

                    $new_Pending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',null)
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->count();
                    $onboarding_Pending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('already_registered',1)
                        ->where('resubmit_status',0)
                        ->where('payment_status', 'success')
                        ->count();
                    $resubmitted_Pending = MainWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('resubmit_status',1)
                        ->where('payment_status', 'success')
                        ->count();

                    $renewal_Pending = RenewWorkerForm::where('status', 'C')
                        ->where('office_id', $userDetails->office_id)
                        ->where('application_receiver_user_id', $userDetails->id)
                        ->where('payment_status', 'success')
                        ->count();
                    $countResubmitted = 0;
                    $countRenewal =0;

                    $renewal_Pending = 0;

                    $countForwardedRenewal =0;

                    $countApprovedRenewal = 0;

                    $countRejectedRenewal = 0;

                    $countRevertedRenewal = 0;
                    $countResubmittedRenewal = 0;

                    $countReviewedRenewal = 0;
                    $countPullBackRenewal = 0;
                    // $status = WorkerApplicationStatus::where('worker_id', $userDetails->worker_id)->first();

                    $dataRen = RenewWorkerForm::where('office_id', $userDetails->office_id)
                        ->whereIn('status', ['A'])
                        ->where('payment_status', 'success')
                        ->orderBy('created_at','asc')
                        ->get();

                    $data = MainWorkerForm::where('district', $userDetails->district)->whereIn('status', ['N'])->where('payment_status', 'success')->orderBy('created_at','asc')->get();
                // $status = WorkerApplicationStatus::where('office_id',$userDetails->office_id)->first();
                // $created_at = $status->created_at;
                //                    dd($created_at);
                    break;

                case 7: return redirect()->route('office.head-office.dashboard.index');
                        break;

                case 12: return redirect()->route('office.head-office-da.dashboard.index');
                        break;

                case 14: return redirect()->route('office.accounts.dashboard.index');
                        break;
                case 15: return redirect()->route('office.dlc-dashboard.dashboard.index');
                        break;
                case 16: return redirect()->route('office.lc-lm-dashboard.dashboard.index');
                        break;
                case 17: return redirect()->route('office.lc-lm-dashboard.dashboard.index');
                        break;


                default:
                    // Office Admin
                    //                    $countRejected = MainWorkerForm::where('status', 'D')->count();
                    //
                    //                    $countPending = MainWorkerForm::where('status', 'C')->count();
                    //                    $countApproved = MainWorkerForm::where('status', 'B')->count();
                    //                    $countReverted = RevertBack::where('status', 'G')
                    //                                        ->where('office_id', $userDetails->office_id)
//                    //                                        ->distinct('ack_no')
                    //                                        ->count('ack_no');
                    //                    $countForwarded = MainWorkerForm::where('status','C')->count();
                    //                    $rowCount = MainWorkerForm::where('status', 'C')->count();
                    //                    $chartData = MainWorkerForm::select(
                    //                        DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                    //                        DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                    //                        DB::raw('COUNT(*) as count')
                    //                    )
                    //                    ->where('status', 'C')
                    //                    ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)'))
                    //                    ->get();
                    //                    $data = MainWorkerForm::get();
                    //                    $status = WorkerApplicationStatus::where('sender_office_id',$userDetails->office_id)->latest();
                    //                    $created_at = $status->created_at;
                    break;
            }
            $das = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->whereIn('role_id', [3, 4])
                ->distinct('role_id')
                ->get();


            $ros = User::where('status', 1)
                ->where('office_id', Auth::user()->office_id)
                ->where('role_id',  4)
                ->distinct('role_id')
                ->first();

            $username = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->whereIn('role_id', [3, 4])
                ->get();

            if (Auth::user()->role_id == 2) {
                $roles = Role::whereIn('id', [3, 4])->get();
            } elseif (Auth::user()->role_id == 3) {
                $roles = Role::where('id', 4)->get();
            } else {
                $roles = [];
            }



            $da = User::where('status', 1)
                ->where('office_id', Auth::user()->office_id)
                ->where('role_id', 4)
                ->distinct()
                ->get();

            $ro = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->where('role_id', 3)
                ->distinct()
                ->first();

            $user = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->where('role_id', 3)
                ->distinct()
                ->get();


            $roUser = User::where('status', 1)
                ->where('district', Auth::user()->district)
                ->where('role_id', 3)
                ->groupBy('role_id')
                ->get(['role_id']);

            // return $das;
            return view('office.dashboard.index', compact(
                'roles',
                'data',
                'countApproved',
                'countPending',
                'countForwarded',
                'countReverted',
                'countRejected',
                'rowCount',
                'chartData',
                'da',
                'das',
                'userDetails',
                'ro',
                'roUser',
                'dataRen',
                'notificationCount',
                'user',
                'username',
                'ros',
                'onboarding_data',
                'resubmitted_data',
                'new_Pending',
                'onboarding_Pending',
                'resubmitted_Pending',
                'renewal_Pending',
                'countReviewed',
                'countPullBack',
                'countResubmitted',
                'countRenewal',
                'countForwardedRenewal',
                'countApprovedRenewal',
                'countRejectedRenewal',
                'countRevertedRenewal','countResubmittedRenewal','countReviewedRenewal','countPullBackRenewal','countReRouted'
            ));
        } catch (Exception $e) {
//            return $e;
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }


    public function getUserByRole(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role_id' => 'required|exists:pgsql.User.roles,id'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }
        try {
            $users = User::where('id', '!=', Auth::user()->id)->where('role_id', $request->role_id)->where('office_id', Auth::user()->office_id)->get();
            return response()->json([
                'status' => true,
                'results' => $users
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'results' => $e->getMessage()
            ]);
        }
    }
}
