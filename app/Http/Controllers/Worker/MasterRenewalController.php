<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\MainWorkerAddress;
use App\Models\MainWorkerBank;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerCertificate;
use App\Models\MainWorkerDocument;
use App\Models\MainWorkerEmployerDetail;
use App\Models\MainWorkerFamily;
use App\Models\MainWorkerForm;
use App\Models\MainWorkerScheme;
use App\Models\PfcKioskDetail;
use App\Models\RenewWorkerForm;
use App\Models\TemporaryWorkerBank;
use App\Models\TemporaryWorkerFamily;
use App\Models\WorkbookModel;
use App\Models\WorkerApplicationStatus;
use App\Models\WorkerNinetyDaysCertificate;
use App\Models\WorkerPaymentSuccess;
use App\Models\WorkerSubscription;
use App\Services\AES;
use App\Services\AesCipher;
use App\Services\GetVaultDataService;
use App\Services\SmsGatewayService;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class MasterRenewalController extends Controller
{
    private $smsService;
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService,SmsGatewayService $smsService)
    {
        $this->getVaultDataService = $getVaultDataService;
        $this->smsService = $smsService;
    }



    public function fetchWorkerData(Request $request)
    {
        $request->validate([
            'id_card' => 'required',
        ]);

        $idCard = $request->input('id_card');
        $worker = DB::table('Worker.main_worker_forms as wmf')
            ->where('wmf.id_card', $idCard)
            ->first();

        if ($worker) {
            Session::put('workerData', $worker);
            return response()->json([
                'success' => true,
                'msg' => 'Worker record found.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Worker data not found.'
            ], 404);
        }
    }

    public function sessionFlash()
    {
        Session::flush();
        session()->regenerate();
        return redirect()->route('home.index');
    }

    public function showData(Request $request)
    {
        $workerData = session()->get('worker');

        if (!$workerData || !$workerData->id_card) {
            return $this->sessionFlash();
        }

        try {
            $vaultDataNew = $this->getVaultDataService->getVaultData($workerData->worker_id, "F");

            $getVaultData = json_decode($vaultDataNew->getData(), true);

//            switch ($workerData->already_registered) {
//                case 1:
//                    if ($workerData) {
//
//                        $subscriptionData = MainWorkerForm::where('id_card', $workerData->id_card)->first();
//                        $now = Carbon::now();
//                        $card_validity_date = Carbon::parse($subscriptionData->id_card_expiry_date);
//                        $renewal_date_n = Carbon::parse($subscriptionData->renewal_date)->format('d-m-Y');
//
//
//                        if ($subscriptionData->active_status == 1) {
//                            $cardStatus = [
//                                'message' => "Active",
//                                'date' => $card_validity_date->format('d-m-Y'),
//                                'color' => 'red'
//                            ];
//                        } else
//                        {
//                            $cardStatus = [
//                                'message' => "Inactive",
//                                'date' => $card_validity_date->format('d-m-Y'),
//                                'color' => 'red'
//                            ];
//                        }
//
//
//                        if (!empty($subscriptionData->subscription_validity_date) && strtotime($subscriptionData->subscription_validity_date)) {
//                            $subscription_validity = Carbon::parse($subscriptionData->subscription_validity_date)->format('d-m-Y');
//                        } else {
//                            $subscription_validity = 'Not Paid';
//                        }
//
//                        $subscription_paid_till = Carbon::parse($subscriptionData->subscription_validity_date);
//                        $card_issue_date = Carbon::parse($subscriptionData->last_registration_date);
//                        $cardIssueDate = $card_issue_date->format('d-m-Y');
//                        $onboarding_date = Carbon::parse($subscriptionData->created_at);
//                        $id_card_validity_date = Carbon::parse($subscriptionData->id_card_expiry_date)->format('d-m-Y');
//
//                        $status = '';
//                        if ($subscription_paid_till->isAfter($now)) {
//                            $subscription_paid_upto_in_months = $card_issue_date->diffInMonths($subscription_paid_till);
//                            $advancedPaid = $onboarding_date->diffInMonths($subscription_paid_till);
//
//                            if ($advancedPaid >= 3 && $subscriptionData->active_status == 1) {
//                                $status = 'Active';
//                            }
//
//
//                        } else {
//
//                            $subscription_paid_upto_in_months = $card_issue_date->diffInMonths($subscription_paid_till);
//
//                            $lapsed = $subscription_paid_till->diffInMonths($now);
//                            if ($lapsed > 3) {
//                                $status = 'Lapsed';
//                            } elseif ($lapsed > 3 && $lapsed < 12) {
//                                $status = 'Lapsed and suspended';
//                            } elseif ($lapsed == 12) {
//                                $status = 'Lapsed and Ceased';
//                            }
//
//                        }
//
//
//                        $subscriptionLapse = $subscription_paid_till->diffInDays($now);
//
//                        $monthsDifference = floor($subscriptionLapse / 30);
//
//                        $remainingDays = $subscriptionLapse % 30;
//
//                        $totalMonths = $monthsDifference;
//                    }
//
//                    break;
//
//                case NULL :
            $data = MainWorkerForm::where('worker_id', $workerData->worker_id)->first();
            $record['remaining_months_to_pay'] = 24;
            $record['today'] = Carbon::today()->startOfDay();
            $record['renewal_date'] = Carbon::parse($data->renewal_date)->startOfDay();
            $record['diffInUpToRenew'] = $record['renewal_date']->diffInMonths($record['today']);
            $record['advancedPaymentDate'] = null;
            $record['arithmeticSum'] = 0;
            $record['constantSum'] = 0;
            $record['totalSum'] = 0;

                    if ($workerData) {

                        $isPaidAllAmount = WorkerSubscription::where('worker_id', $workerData->worker_id)->where('payment_status', 0)->count();
                        if ($isPaidAllAmount > 0) {
                            $isPaid = '1';
                        }else{
                            $isPaid = '0';
                        }

                        $subscription = WorkerSubscription::where('worker_id', $workerData->worker_id)->get();
                        $renewals = MainWorkerForm::where('worker_id', $workerData->worker_id)->first();
                        $cardIssueDate = Carbon::parse($renewals->id_card_created_at)->format('d-m-Y');
                        $renewal_date_n = Carbon::parse($renewals->renewal_date)->format('d-m-Y');
                        $now = Carbon::now();
                        $finalData = [];
                        $card_validity_date = Carbon::parse($renewals->id_card_expiry_date);
                        if ($renewals->active_status == 1) {
                            $cardStatus = [
                                'message' => "Active",
                                'date' => $card_validity_date->format('d-m-Y'),
                                'color' => 'red'
                            ];
                        } elseif($renewals->active_status == 0)
                        {
                            $cardStatus = [
                                'message' => "Inactive",
                                'date' => $card_validity_date->format('d-m-Y'),
                                'color' => 'red'
                            ];
                        }
                        if (!empty($renewals->subscription_validity_date) && strtotime($renewals->subscription_validity_date)) {
                            $subscription_validity = Carbon::parse($renewals->subscription_validity_date)->format('d-m-Y');
                        } else {
                            $subscription_validity = 'Not Paid';
                        }
                        $subscription_paid_till = Carbon::parse($renewals->subscription_validity_date);
                        $issue_date = Carbon::parse($cardIssueDate);
                        $id_card_validity_date = Carbon::parse($renewals->id_card_expiry_date)->format('d-m-Y');
                        $subscription_paid_upto_in_months = $issue_date->diffInMonths($subscription_paid_till);
                        $status = '';
                        if ($subscription_paid_upto_in_months>=3 && $renewals->active_status == 1)
                        {
                            $status ='Active';


                        }
                        else{
                            $status = 'Inactive';

                        }

                        if ($subscription->count() == 0) {

                            $subscription_date = $subscription_paid_till->format('d');

                            $onboardingDate = Carbon::parse($renewals->id_card_created_at)->startOfDay();

                            $onboarding_date = $onboardingDate->format('d');
//                dd($onboarding_date);

//                 if ($subscription_date + 1 < $onboarding_date) {
//
//                     $no_of_month = 3;
//                 } elseif ($subscription_date == $onboarding_date) {
//
//                     $no_of_month = 3;
//                 } else {
//
//                     $no_of_month = 3;
//                 }
                            $no_of_month = 3;

                            $advancedPaymentDate = Carbon::parse($onboardingDate)
                                ->subDay()// Subtract one day from the onboarding date
                                ->startOfDay()
                                ->addMonths($no_of_month);
                            // ->day($subscription_date);

                            //    dd($advancedPaymentDate);


                            $subscription_day_upto = Carbon::parse($renewals->subscription_validity_date)->format('d');

                            $todaysdate = $record['today']->format('d');

                            //first Scenario
                            $current_year = $record['today']->format('Y');

                            if ($subscription_day_upto < $todaysdate) {


                                $paymentMonth = $record['today']->format('m');
//                    dd($paymentMonth);
                                $pendingPaymentDate = Carbon::parse($subscription_paid_till)->year($current_year)->month($paymentMonth);
//                    dd($pendingPaymentDate);
                            } else {

                                $paymentMonth = $record['today']->format('m') - 1;

                                $pendingPaymentDate = Carbon::parse($subscription_paid_till)->month($paymentMonth);
                            }
//                dd($pendingPaymentDate);

                            if ($pendingPaymentDate > $advancedPaymentDate) {

                                $intial_payment_date = $pendingPaymentDate;
                            } else {

                                $intial_payment_date = $advancedPaymentDate;
                                //    dd($intial_payment_date);
                            }

                            $final_payment_date = $intial_payment_date;
                            $id_expiry_date = Carbon::parse($renewals->id_card_expiry_date);
                            //    dd($id_expiry_date);

                            //2nd scenario

                            // if ($intial_payment_date > $id_expiry_date) {

                            //     $final_payment_date = $intial_payment_date;
                            // } else {

                            //     $final_payment_date = $id_expiry_date;
                            // }

                            $record['advancedPaymentDate'] = $final_payment_date;
//                dd($final_payment_date);
//                dd($subscription_paid_upto);

                            $no_of_months = $subscription_paid_till->diffInMonths($final_payment_date, false);
                            //    dd($no_of_months);


                            $record['no_of_months'] = max(0, $no_of_months);


                            $month = $record['today']->format('m');

                            $year = $record['today']->format('Y');
//                    dd($todaysdate);
//                    dd($subscription_day_upto);
                            if ($todaysdate > $subscription_day_upto) {

                                $record['latest_penalty_month'] = $month;
//                    dd($record['latest_penalty_month']);
                                $date = $subscription_day_upto;
                                $CurrentYear = $year;
                                $fullDate = $CurrentYear . '-' . $record['latest_penalty_month'] . '-' . $date;
                                $Ndate = Carbon::parse($fullDate);
//                    dd($Ndate);

                            } else {

                                $record['latest_penalty_month'] = $month - 1;
                                $date = $subscription_day_upto;
                                $CurrentYear = $year;
                                $fullDate = $CurrentYear . '-' . $record['latest_penalty_month'] . '-' . $date;
                                $Ndate = Carbon::parse($fullDate);
                            }
                            $advancedPaymentDate = Carbon::parse($record['advancedPaymentDate']);
//                dd($advancedPaymentDate);
//               dd($id_expiry_date);

                            $record['remaining_months_to_pay'] = $advancedPaymentDate->diffInMonths($id_expiry_date);
//                dd($record['remaining_months_to_pay']);
//                dd($Ndate);
//                    dd($subscription_paid_upto);
                            if ($subscription_paid_till->isAfter($advancedPaymentDate) || $subscription_paid_till == $advancedPaymentDate) {
                                $no_of_months = 0;
                                $record['flag'] = true;
                            }

                            if ($subscription_paid_till->isAfter($Ndate) || $subscription_paid_till == $Ndate) {

                                $record['no_of_penalty_months'] = 0;
                                $no_of_penalty_months = $record['no_of_penalty_months'];
                            } else {
                                $record['no_of_penalty_months'] = $subscription_paid_till->diffInMonths($Ndate);
                                $no_of_penalty_months = $record['no_of_penalty_months'];
                            }

                            $fine = 0;

                            if ($record['advancedPaymentDate'] >= $Ndate) {
                                for ($i = $record['no_of_penalty_months']; $i >= 0; $i--) {
                                    $fine += 2 * $i;
                                }
                            } else {

                                for ($i = ($record['no_of_penalty_months'] - $no_of_months) + 1; $i <= $record['no_of_penalty_months']; $i++) {
                                    $fine += 2 * $i;
                                }
                            }

                            //            $record['todaysDate'] = ($record['today'])->day($subscription_day_upto);

                            //            $record['no_of_penalty_months'] = $subscription_paid_upto->diffInMonths($record['todaysDate']);


                            $record['constantSum'] = 20 * $no_of_months;

                            $record['arithmeticSum'] = $fine;

                            $record['totalSum'] = $record['constantSum'] + $record['arithmeticSum'];

                            $record['no_of_months'] = $no_of_months;

                        } elseif ($subscription->count() > 0) {


                            $latestSubscription = WorkerSubscription::Where('worker_id', $workerData->worker_id)->orderBy('created_at', 'desc')->latest()->first();

                            $record['start_date'] = $startDate = Carbon::parse($latestSubscription->to_period)->format('Y-m-d');

                            $record['from_period'] = Carbon::parse($renewals->subscription_validity_date)->addDay();

                            $record['card_expiry_date'] = $endDate = Carbon::parse($renewals->id_card_expiry_date);

                            $total_months = $record['from_period']->diffInMonths($record['card_expiry_date']);

                            //              $months_paid = $subscription->skip(1)->sum('month_paid');
                            $months_paid = $subscription->sum('month_paid');

                            if ($subscription_paid_till != $record['card_expiry_date']) {

                                $record['remaining_months_to_pay'] = $total_months + 1;
                            } else {
                                $record['remaining_months_to_pay'] = $total_months;
                            }
                            //              $record['remaining_months_to_pay'] = $total_months - $months_paid;

                            //                 dd($record['remaining_months_to_pay']);

                            //first scenario

                            $subscription_day_upto = Carbon::parse($renewals->subscription_validity_date)->format('d');

                            $todaysdate = $record['today']->format('d');

                        }

                    }



            if (is_null($getVaultData)) {
                Alert::toast('Aadhaar data not found,Please try after sometime', 'error');
                return redirect()->back();

            } else {

                $aadhar_photo = $getVaultData['photo'];

                return view('worker.show-worker-data', compact('workerData', 'cardIssueDate','id_card_validity_date',
                    'cardStatus', 'getVaultData', 'status', 'aadhar_photo', 'card_validity_date', 'subscription_validity',
                    'renewal_date_n','isPaid','advancedPaymentDate','no_of_penalty_months'));
            }
        }catch (exception $e)
        {
            return $e;
            Alert::toast('Failed to load application, UIDAI Server is busy. Please try again later.','error');
//            return back();
        }
        }

    function calculatePendingDuesBeforeRenewal($subscriptionPaidTill, $cardValidityDate)
    {
        // If subscription paid date is before the ID card expiry, then dues exist
        if ($subscriptionPaidTill->lt($cardValidityDate)) {
            $pendingMonths = $subscriptionPaidTill->diffInMonths($cardValidityDate);

            // Subscription fee = Rs 20 per month
            $subscriptionDue = $pendingMonths * 20;

            // Penalty = Rs 2 per month, cumulative: sum of 1..pendingMonths * 2
            $penalty = 2 * ($pendingMonths * ($pendingMonths + 1)) / 2;

            return [
                'pending_months' => $pendingMonths,
                'subscription_due' => $subscriptionDue,
                'penalty' => $penalty,
                'total_due' => $subscriptionDue + $penalty,
                'due_period' => $subscriptionPaidTill->format('d-m-Y') . ' to ' . $cardValidityDate->format('d-m-Y'),
            ];
        }
        return null; // no pending dues
    }


    public function basicPage(Request $request)
    {
        $workerData = Session::get('worker_id');
        // dd($workerData);

        if (!$workerData) {
            return $this->sessionFlash();
        }
        $worker_id = $workerData;

        $data['formdata'] = $formdata = DB::table('Worker.main_worker_basic_details as twbd')
            ->leftJoin('Worker.main_worker_forms as tfm', 'twbd.worker_id', '=', 'tfm.worker_id')
            ->leftJoin('Masterdata.marital_statuses as ms', 'twbd.maritial_status_id', '=', 'ms.marital_code')
            ->leftJoin('Masterdata.educations as edu', 'twbd.education_id', '=', 'edu.education_code')
            ->leftJoin('Masterdata.categories as cat', 'twbd.category', '=', 'cat.category_code')
            ->leftJoin('Masterdata.skills as ski', 'twbd.skill_id', '=', 'ski.skill_code')
            ->leftjoin('Masterdata.blood_groups as bg', 'twbd.blood_group', '=', 'bg.id')
            ->leftJoin('Masterdata.ration_types as rt', 'twbd.ration_type', '=', 'rt.ration_code')
            ->leftJoin('Masterdata.states as st', 'twbd.state_id', '=', 'st.state_code')
            ->where('twbd.worker_id', $worker_id)
            ->select('twbd.*', 'tfm.*', 'ms.*', 'cat.*', 'edu.*', 'ski.*', 'st.*', 'rt.*', 'bg.*')
            ->first();

        if ($data['formdata']) {

            $data['marital'] = DB::table('Masterdata.marital_statuses')
                ->where('marital_code', '!=', $formdata->marital_code)
                ->get();
            $data['category'] = DB::table('Masterdata.categories')
                ->where('category_code', '!=', $formdata->category_code)
                ->get();
            $data['education'] = DB::table('Masterdata.educations')
                ->where('education_code', '!=', $formdata->education_code)
                ->get();
            $data['skills'] = DB::table('Masterdata.skills')
                ->where('skill_code', '!=', $formdata->skill_code)
                ->get();
            $data['blood'] = DB::table('Masterdata.blood_groups')
                ->where('id', '!=', $formdata->id)
                ->get();
            $data['states'] = DB::table('Masterdata.states')
                ->where('state_code', '!=', $formdata->state_code)
                ->orderBy('state_name', 'asc')
                ->get();
            $data['ration'] = DB::table('Masterdata.ration_types')->get();
            $data['application_no'] = DB::table('Worker.main_worker_forms')
                ->where('worker_id', $worker_id)
                ->pluck('application_no')
                ->first();

        }
            $vaultDataNew = $this->getVaultDataService->getVaultData($worker_id, "F");

            $data['getVaultData'] = json_decode($vaultDataNew->getData(), true);
        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $worker_id)
            ->pluck('application_no')
            ->first();

        return view('worker-renewal.basic-details', $data);
    }

    public function updateBasicDetails(Request $request)
    {
        $workerData = Session::get('workerData');

        if (!$workerData->worker_id) {
            return $this->sessionFlash();
        }
        $worker_id = $workerData->worker_id;

        $validate = $request->validate([

            'maritial_status_id' => 'required|exists:pgsql.Masterdata.marital_statuses,marital_code',
            'category' => 'required|exists:pgsql.Masterdata.categories,category_code',
            'eshram_no' => 'required|numeric|digits:12',
            'education_id' => 'required|exists:pgsql.Masterdata.educations,education_code',
            'skill_id' => 'required|exists:pgsql.Masterdata.skills,skill_code',
            'email' => 'nullable|regex:/(.+)@(.+)\.(.+)/i',
            'pan' => 'required|in:1,0',
            'pan_no' => $request->input('pan') == '1' ? 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/|max:10' : '',
            'resident_type' => 'required|in:raa,rao',
            'state_id' => $request->input('resident_type') == 'rao' ? 'required|exists:pgsql.Masterdata.states,state_code' : '',
            'boc' => 'required|in:1,0',
            'boc_no' => $request->input('boc') == '1' ? 'required|string' : '',
            'has_ration_card' => 'required|in:0,1',
            'ration_no' => $request->has_ration_card == '1' ? 'required|string|max:255|regex:/^[a-zA-Z0-9\-\/]+$/'  // Adjust the regex pattern as needed
                : 'nullable',
            'ration_type' => $request->has_ration_card == '1' ? 'required|string|max:255' : '',
            'blood_group' => 'required|exists:pgsql.Masterdata.blood_groups,id'
        ], [
            'worker_id.unique' => '⚠ The Worker is already registered!',
            'maritial_status_id.required' => '⚠ Please Select',
            'category.required' => '⚠ Please Select',
            'education_id.required' => '⚠ Education Cannot Be Blank',
            'eshram_no.required' => '⚠ e-Shram No Cannot Be Blank',
            'eshram_no.digits' => 'e-Shram number must have exactly 12 digits',
            'skill_id.required' => '⚠ Please Select',
            'state_id.required_if' => '⚠ State is required for the selected resident type.',
            'resident_type.required' => '⚠ Please select whether you are a Permanent Resident Of Assam or not',
            'pan.required' => '⚠ Please Select',
            'boc.required' => '⚠ Please Select',
            'has_ration_card.required' => '⚠ Please Select whether you have a ration card or not',
            'ration_no.required' => '⚠ The Ration Card Number Cannot Be Blank',
            'ration_type.required' => '⚠ Please Select',
            'blood_group.required' => '⚠ Please Select'
        ]);
        DB::beginTransaction();
        try {
            $data = MainWorkerBasicDetail::where('worker_id', $worker_id)->update([
                'worker_id' => $worker_id,
                'maritial_status_id' => $request->maritial_status_id,
                'category' => $request->category,
                'eshram_no' => $request->eshram_no,
                'education_id' => $request->education_id,
                'email' => $request->email,
                'pan' => $request->pan,
                'pan_no' => $request->pan_no,
                'skill_id' => $request->skill_id,
                'state_id' => $request->state_id,
                'resident_type' => $request->resident_type,
                'boc' => $request->boc,
                'boc_no' => $request->boc_no,
                'has_ration_card' => $request->has_ration_card,
                'ration_type' => $request->ration_type,
                'ration_no' => $request->ration_no,
                'blood_group' => $request->blood_group,

            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Alert::Toast($e->getMessage(),'error');
        }
        Alert::toast('Basic Details Updated Successfully', 'success');
        return redirect()->route('preview-renewal-application')->with('success');
    }

    public function addressDetails(Request $request)
    {
        $workerData = Session::get('workerData');
        if (!$workerData->worker_id) {
            return $this->sessionFlash();
        }
        $worker_id = $workerData->worker_id;
        $vaultDataNew = $this->getVaultData($worker_id);
        $data['getVaultData'] = json_decode($vaultDataNew, true);
        $data['formdata'] = $formdata = DB::table('Worker.main_worker_addresses as twam')
            ->leftJoin('Masterdata.residences as cres', 'twam.c_residence', '=', 'cres.residence_code')
            ->leftjoin('Masterdata.houses as chs', 'twam.c_house_type', '=', 'chs.house_code')
            ->where('twam.worker_id', $worker_id)
            ->select('twam.*', 'cres.*', 'chs.*')
            ->first();
        if ($formdata) {
            $data['residence'] = DB::table('Masterdata.residences')->where('residence_code', '!=', $formdata->residence_code)->get();
            $data['house'] = DB::table('Masterdata.houses')->where('house_code', '!=', $formdata->house_code)->get();
            $data['application_no'] = DB::table('Worker.temporary_worker_forms')
                ->where('worker_id', $worker_id)
                ->pluck('application_no')
                ->first();
            return view('worker-renewal.address-details', $data);
        }
    }

    public function updateAddressDetails(Request $request)
    {
        $workerData = Session::get('workerData');
        if (!$workerData->worker_id) {
            return $this->sessionFlash();
        }
        $worker_id = $workerData->worker_id;
        $validate = $request->validate(
            [
                'c_residence' => 'required|string',
                'c_house_type' => 'required|string',
                'c_house_no' => 'required|string',  // Example pattern: Starts with numbers, followed by optional letters and spaces
                'c_road' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/',  // Example pattern: Letters, numbers, and spaces allowed
                'c_area' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'c_city' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'c_state' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'c_district' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'c_post_office' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'c_pin' => 'required|min:6|numeric|regex:/^\d{6}$/',  // Example pattern: Exactly 6 digits
                'landmark' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'c_std' => 'nullable|numeric|regex:/^\d{2,5}$/',  // Example pattern: Between 2 and 5 digits
                'c_circle' => 'required|string|regex:/^[a-zA-Z\s]+$/',

            ],
            [
                'c_residence.required' => '⚠ Please Select',
                'c_house_type.required' => '⚠ Please Select',
                'c_house_no.numeric' => '⚠ House No Should Be Numbers',
                'c_area.required' => '⚠ Area Name Cannot Be Blank',
                'c_area.alpha' => '⚠ Area Name Cannot Be a Number',
                'c_city.required' => '⚠ City Cannot Be Blank',
                'c_city.regex' => '⚠ Invalid Format',
                'c_district.required' => '⚠ Please Select',
                'c_circle.required' => '⚠ Please Select',
                'c_post_office.required' => '⚠ Post Office Cannot Be Blank',
                'c_pin.required' => '⚠ Pin Code Cannot Be Blank',
                'c_road.required' => '⚠ Road Name Cannot Be Blank',
                'c_std.numeric' => '⚠ STD Code Should Be a NUmber',
                'c_state.required' => '⚠ Please Select'
            ]
        );
        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $worker_id)
            ->pluck('application_no')
            ->first();
        MainWorkerAddress::where('worker_id', $worker_id)->update([
            'worker_id' => $worker_id,
            'application_no' => $data['application_no'],
            'c_residence' => $request->c_residence,
            'c_house_type' => $request->c_house_type,
            'c_house_no' => $request->c_house_no,
            'c_road' => $request->c_road,
            'c_area' => $request->c_area,
            'c_city' => $request->c_city,
            'c_state' => $request->c_state,
            'c_district' => $request->c_district,
            'c_post_office' => $request->c_post_office,
            'c_pin' => $request->c_pin,
            'c_circle' => $request->c_circle,
            'landmark' => $request->landmark,

        ]);

        Alert::toast('Address Details Updated Successfully', 'success');
        return redirect()->route('preview-renewal-application')->with('success');
    }

    public  function bankDetails(Request $request)
    {
        $workerData = Session::get('workerData');
        if (!$workerData->worker_id) {
            return $this->sessionFlash();
        }
        $worker_id = $workerData->worker_id;
        $data['formdata'] = $formdata = DB::table('Worker.main_worker_banks')
            ->where('worker_id', $worker_id)->first();
        if ($formdata) {
            $data['ifsc'] = DB::table('Worker.main_worker_banks as twbm')
                ->join('Masterdata.banks as bank', 'twbm.ifsc_pk', '=', 'bank.id')
                ->where('worker_id', $worker_id)
                ->select('twbm.*', 'bank.*')
                ->first();
            $data['application_no'] = DB::table('Worker.main_worker_forms')
                ->where('worker_id', $worker_id)
                ->pluck('application_no')
                ->first();

            $data['application_no'] = DB::table('Worker.main_worker_forms')
                ->where('worker_id', $worker_id)
                ->pluck('application_no')
                ->first();

            return view('worker-renewal/bank-details', $data);
        }
    }

    public function UpdateBankDetails(Request $request)
    {
        $workerData = Session::get('workerData');
        if (!$workerData->worker_id) {
            return $this->sessionFlash();
        }
        $worker_id = $workerData->worker_id;
        $validate = $request->validate([

            'bank_name' => 'required|exists:pgsql.Masterdata.banks,bank_name',
            'branch_name' => 'required|exists:pgsql.Masterdata.banks,branch_name',
            'bank_address' => 'required|exists:pgsql.Masterdata.banks,state',
            'account_no' => 'required|numeric|digits_between:1,20',
            'account_no_confirmation' => 'required|numeric|digits_between:1,20'

        ], [
            'bank_name.required' => '⚠ Bank Number Cannot Be Blank',
            'branch_name.required' => '⚠ Branch Name Cannot Be Blank',
            'bank_address.required' => '⚠ Bank Address Cannot Be Blank',
            'account_no.required' => '⚠ Account No Cannot Be Blank',
            'account_no_confirmation.required' => '⚠ Confirmation of Account No Cannot Be Blank'

        ]);
        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $worker_id)
            ->pluck('application_no')
            ->first();
        $data = MainWorkerBank::where('worker_id', $worker_id)->update([
            'ifsc_pk' => $request->ifsc_pk,
            'application_no' => $data['application_no'],
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'bank_address' => $request->bank_address,
            'account_no' => $request->account_no,

        ]);
        Alert::toast('Bank Details Submitted Successfully', 'success');
        return redirect()->route('preview-renewal-application')->with('success');
    }

    public function FamilyDetails(Request $request)
    {
        $workerData = Session::get('workerData');

        if (!$workerData) {
            return $this->sessionFlash();
        }

        $worker_id = $workerData->worker_id;
        $vaultDataNew = $this->getVaultData($worker_id);
        $data['getVaultData'] = json_decode($vaultDataNew, true);
        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $worker_id)
            ->pluck('application_no')
            ->first();
      $formdata = MainWorkerFamily::where('worker_id', $worker_id)->first();

        if ($formdata) {
            $data['formdata'] = DB::table('Worker.main_worker_families as twfm')
                ->join('Worker.temporary_worker_forms as tfm', 'twfm.worker_id', '=', 'tfm.worker_id')
                ->join('Worker.temporary_worker_basic_details as twbd', 'twfm.worker_id', '=', 'twbd.worker_id')

                ->join('Masterdata.relations as rel', 'twfm.relation', '=', 'rel.relation_code')
                ->where('twfm.worker_id', $worker_id)
                ->select('tfm.worker_id', 'twfm.*', 'rel.*')
                ->get();
            foreach ($data['formdata'] as $familyMember) {
                $familyMember->age = Carbon::parse($familyMember->dob)->age;
            }

            $data['relations'] = DB::table('Masterdata.relations')
                ->select('relation_code', 'relation_name')
                ->get();

            return view('worker-renewal/family-details', $data);
        }
    }

    public function updateFamilyDetails(Request $request)
    {
        $workerData = Session::get('workerData');
        if (!$workerData) {
            return $this->sessionFlash();
        }
        $worker_id = $workerData->worker_id;
        $familyValidator = Validator::make($request->all(), [
            'first_name' => 'required|array',
            'first_name.*' => 'required|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|array',
            'last_name.*' => 'required|regex:/^[a-zA-Z ]+$/',
            'guardain_name' => 'nullable|array',
            'guardain_name.*' => 'nullable|regex:/^[a-zA-Z ]+$/',
            'dob' => 'required|array',
            'dob.*' => 'required|date',
            'relation.*' => 'required|exists:pgsql.Masterdata.relations,relation_code',
            'nominee' => 'required|array',
            'nominee.*' => 'required|in:0,1|regex:/^[01]$/',
            'already_registered' => 'required|array',
            'already_registered.*' => 'required|in:0,1',
            'bocwwb_id' => 'array',
            'bocwwb_id.*' => 'required_if:already_registered.*,1',
            'nominee_percentage' => 'array',
            'nominee_percentage.*' => 'required_if:nominee.*,1',
        ], [
            'first_name.*.required' => '⚠ First name cannot be blank',
            'last_name.*.required' => '⚠ Last name cannot be blank',
            'guardain_name.*.regex' => '⚠ Invalid Name',
            'relation.*.required' => '⚠ Please Select',
            'dob.*.required' => '⚠ Date of birth cannot be blank',
            'dob.*.date' => '⚠ The date of birth must be a valid date',
            'nominee.*.required' =>  '⚠ Please Select',
            'nominee_percentage.*.required_if' => '⚠ Nominee percentage field is required',
            'bocwwb_id.*.required_if' => '⚠ BOC Id field is required',
            'already_registered.*.required' => '⚠ Please Select',
        ]);



        if ($familyValidator->fails()) {
            $errors = $familyValidator->errors()->messages();
            return response()->json(['success' => false, 'errors' => $errors], 200);
        }

        if (array_sum($request->input('nominee_percentage')) !== 100) {
            return response()->json([
                'success' => false,
                'errors' => ['nominee_percentage' => 'Total nominee share shall not be below 100']
            ], 200);
        }
        $f_names = $request->first_name;
        $l_names = $request->last_name;

        // Check for duplicate first and last names
        $names = [];
        foreach ($f_names as $key => $f_name) {
            $full_name = $f_name . ' ' . $l_names[$key];
            if (in_array($full_name, $names)) {
                return response()->json(['errors' => ['name' => "⚠ Duplicate entry for $f_name $l_names[$key]"]], 200);
            }
            $names[] = $full_name;
        }
        DB::beginTransaction();
        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $worker_id)
            ->pluck('application_no')
            ->first();
        try {
            if (is_array($f_names) && !empty($f_names)) {
                $affectedRows = DB::table('Worker.main_worker_families')
                    ->where('worker_id', $worker_id)->delete();
                foreach ($f_names as $key => $f_name) {
                    $bocwwbId = $request->bocwwb_id[$key];
                    $existingRecordTemp = DB::table('Worker.main_worker_families')
                        ->whereIn('bocwwb_id', [$bocwwbId])
                        ->count();

                    $existingRecordMain = DB::table('Worker.main_worker_families')
                        ->whereIn('bocwwb_id', [$bocwwbId])
                        ->count();
                    if (($existingRecordTemp !== null && $existingRecordTemp > 0) || ($existingRecordMain !== null && $existingRecordMain > 0)) {
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'true']);
                    } else {
                        $data = MainWorkerFamily::Create([
                            'worker_id' => $worker_id,
                            'application_no' => $data['application_no'],
                            'first_name' => $f_names[$key],
                            'last_name' => $request->last_name[$key],
                            'guardain_name' => $request->guardain_name[$key],
                            'dob' => $request->dob[$key],
                            'relation' => $request->relation[$key],
                            'nominee' => $request->nominee[$key],
                            'nominee_percentage' => $request->nominee_percentage[$key],
                            'already_registered' => $request->already_registered[$key],
                            'bocwwb_id' => $bocwwbId,
                        ]);
                    }

                    if ($data === false) {
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'WTF001 Error Code']);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WTF002 Database error']);
        }

        Alert::toast('Family Details Updated Successfully', 'success');
        return response()->json(['success' => true]);
    }


    public function CertificateDetails(Request $request)
    {

        $workerData = Session::get('workerData');
        if (!$workerData) {
            return $this->sessionFlash();
        }

        $worker_id = $workerData->worker_id;
        $data['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $data['current_date'] = now();
        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $worker_id)
            ->pluck('application_no')
            ->first();
        $data['ndc'] = WorkerNinetyDaysCertificate::where('worker_id', $worker_id)->get();
        $vaultDataNew = $this->getVaultData($worker_id);
        $data['getVaultData'] = json_decode($vaultDataNew, true);

            $data['mwc'] = DB::table('Worker.main_worker_certificates as twc')
                ->join('Masterdata.type_of_issuers as tot', 'twc.type_of_issuer', '=', 'tot.issuer_code')
                ->join('Masterdata.type_of_employers as toe', 'twc.type_of_employer', '=', 'toe.employer_code')
                ->join('Masterdata.type_of_works as tow', 'twc.type_of_work', '=', 'tow.work_type_code')
                ->where('twc.worker_id', $worker_id)
                ->select(
                    'twc.worker_id',
                    'twc.application_no',
                    'twc.type_of_issuer',
                    'twc.issuing_org',
                    'twc.issue_date',
                    'twc.issuing_person',
                    'twc.contact_issuing_person',
                    'twc.is_same',
                    'twc.employer_name AS emp',
                    'twc.employer_contact_number',
                    'twc.from_date',
                    'twc.to_date',
                    'twc.type_of_employer',
                    'tot.*',
                    'toe.employer_code',
                    'toe.employer_name AS empname',
                    'twc.type_of_work',
                    'tow.work_type_code',
                    'tow.work_type_name'
                )
                ->get();
        foreach ($data['mwc'] as $record) {
            // Assuming you have start_date and end_date columns in your database
            $startDate = new DateTime($record->from_date);
            $endDate = new DateTime($record->to_date);
            $dateInterval = $startDate->diff($endDate);
            $data['no_of_days'] = $record->number_of_days = $dateInterval->days;

        }

        $data['type_of_issuer'] = DB::table('Masterdata.type_of_issuers')
            ->select('issuer_code', 'issuer_name')
            ->get();
        $data['type_of_employers'] = DB::table('Masterdata.type_of_employers')
            ->select('employer_code', 'employer_name')
            ->get();

        $data['worktype'] = DB::table('Masterdata.type_of_works')
            ->select('work_type_code', 'work_type_name')
            ->get();
        $data['worknature'] = DB::table('Masterdata.nature_of_works')
            ->select('nature_of_work_code', 'nature_of_work')
            ->get();

        return view('worker-renewal.certificate-details', $data);
    }

    public function updateCertificate(Request $request)
    {

        $workerData = Session::get('workerData');
        if (!$workerData) {
            return $this->sessionFlash();
        }
        $workerId = $workerData->worker_id;
        $certificateValidator = Validator::make(
            $request->all(),
            [


                'type_of_issuer.*' => 'required|exists:pgsql.Masterdata.type_of_issuers,issuer_code',
                'issuing_org.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'issue_date.*' => 'required|date',
                'issuing_person.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'contact_issuing_person.*' => 'required|digits:10',
                'type_of_work.*' => 'required|exists:pgsql.Masterdata.type_of_works,work_type_code',
                'is_same.*' => 'required',
                'employer_name_certi.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                // 'employer_contact_name.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'employer_contact_number.*' => 'required|numeric',
                'from_date.*' => 'required|date',
                'to_date.*' => 'required|date',
                'date_count.*' => 'required|numeric',
                'type_of_employer.*' => 'required|exists:pgsql.Masterdata.type_of_employers,employer_code',
                //                'certificate_proof.*' => 'required|file|mimes:pdf|max:2048',
            ],
            [


                'type_of_issuer.*.required' => '⚠ Please Select.',
                'issuing_org.*.required' => '⚠ The Name of Issuing Organization Cannot Be Blank.',

                'issue_date.*.required' => '⚠ The Date of issue Cannot Be Blank.',
                'issuing_person.*.required' => '⚠ The Name of Issuing Person Cannot Be Blank.',
                'contact_issuing_person.*.required' => '⚠ The Contact No of Issuing Person Cannot Be Blank.',
                'contact_issuing_person.*.numeric' => '⚠ Contact No of Issuing Person Should be a number.',
                'type_of_work.*.required' => '⚠ Please Select.',
                'is_same.*.required' => '⚠ Please Select.',
                'employer_name_certi.*.required' => '⚠ The Employer Name Cannot Be Blank.',
                // 'employer_contact_name.*.required' => '⚠ The Employer Contact Name Cannot Be Blank.',
                'employer_contact_number.*.required' => '⚠ The Employer Contact Number Cannot Be Blank.',
                'employer_contact_number.*.numeric' => '⚠ Employer Contact Number Should be a number',
                'from_date.*.required' => '⚠ The From Date Cannot Be Blank.',
                'from_date.*.date' => '⚠ Please enter a valid date.',
                'to_date.*.required' => '⚠ The To Date Cannot Be Blank.',
                'to_date.*.date' => '⚠ Please enter a valid date.',
                'date_count.*.required' => '⚠ The Date Count Cannot Be Blank.',
                'type_of_employer.*.required' => '⚠ Please Select.',
            ]
        );
        if ($certificateValidator->fails()) {
            $errors = ($certificateValidator->errors());

            return response()->json(['errors' => $errors], 200);
        }
        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $workerId)
            ->pluck('application_no')
            ->first();

        DB::beginTransaction();
        try {

            $certificateData = [];
            $f_names = $request->type_of_issuer;
            if (is_array($f_names) && !empty($f_names)) {
                foreach ($f_names as $key => $f_name) {
                    $certificateData[] =MainWorkerCertificate::where('worker_id', $workerId)
                        ->update([
                            'worker_id' => $workerId,
                            'type_of_issuer' => $f_names[$key],
                            'application_no' => $data['application_no'],
                            'issuing_org' => $request->issuing_org[$key],
                            'issue_date' => $request->issue_date[$key],
                            'issuing_person' => $request->issuing_person[$key],
                            'contact_issuing_person' => $request->contact_issuing_person[$key],
                            'is_same' => $request->is_same[$key],
                            'type_of_work' => $request->type_of_work[$key],
                            'employer_name' => $request->employer_name_certi[$key],
                            // 'employer_contact_name' => $request->employer_contact_name[$key],
                            'employer_contact_number' => $request->employer_contact_number[$key],
                            'from_date' => $request->from_date[$key],
                            'to_date' => $request->to_date[$key],
                            'date_count' => $request->date_count[$key],
                            'type_of_employer' => $request->type_of_employer[$key],

                        ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WEC001,Database Exception Error']);
        }
        Alert::toast('Certificate Details Updated Successfully', 'success');
        return response()->json(['success' => true, 'msg' => 'Certificate Details Updated!']);

    }

    public function schemeDetails(Request $request)
    {
        $workerData = Session::get('workerData');
        if (!$workerData) {
            return $this->sessionFlash();
        }
        $vaultData = $this->getVaultData($request);
        $data['getVaultData'] = json_decode($vaultData->getData(), true);
        $worker_id = $workerData->worker_id;
        $data['formdata'] = $formdata = DB::table('Worker.main_worker_schemes')->where('worker_id', $worker_id)->first();
        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $worker_id)
            ->pluck('application_no')
            ->first();
        if ($formdata) {
            $data['tws'] = DB::table('Worker.main_worker_schemes as tws')
                ->leftjoin('Masterdata.schemes as sch', 'tws.scheme_name', '=', 'sch.scheme_code')
                ->where('tws.worker_id', $worker_id)
                ->select('tws.*', 'sch.*')
                ->get();
            $data['schemes'] = DB::table('Masterdata.schemes')
                ->select('scheme_code', 'scheme_name')->get();

            return view('worker-renewal.scheme-details', $data);
        }
    }

    public function updateScheme(Request $request)
    {
        $workerData = Session::get('workerData');
        if (!$workerData) {
            return $this->sessionFlash();
        }
        $workerId = $workerData->worker_id;

        $validator = Validator::make($request->all(), [
            'enrolled' => 'required|in:1,0',
            'scheme_name' => 'required_if:enrolled,1|array',
            'scheme_name.*' => 'nullable|required_if:enrolled,1', // Added string|max:255 for completeness
            'registration_id' => 'required_if:enrolled,1|array',
            'registration_id.*' => 'nullable|required_if:enrolled,1|regex:/^[A-Za-z0-9\-]+$/',
            'date' => 'required_if:enrolled,1|array',
            'date.*' => 'nullable|date|required_if:enrolled,1',
        ], [
            'enrolled.required' => '⚠ The Enrolled field is required.',
            'enrolled.in' => '⚠ The selected enrolled value is invalid.',

            'scheme_name.required_if' => '⚠ Scheme Name cannot be blank.',
            'scheme_name.*.required_if' => '⚠ Scheme Name cannot be blank.',
            'scheme_name.*.string' => '⚠ Scheme Name must be a string.',
            'scheme_name.*.max' => '⚠ Scheme Name may not be greater than 255 characters.',

            'registration_id.required_if' => '⚠ The Registration ID cannot be blank.',
            'registration_id.*.required_if' => '⚠ Registration ID cannot be blank.',
            'registration_id.*.regex' => '⚠ Registration ID must consist of letters, numbers, and hyphens only.',

            'date.required_if' => '⚠ The Date of Registration cannot be blank.',
            'date.*.required_if' => '⚠ Date of Registration cannot be blank.',
            'date.*.date' => '⚠ Date of Registration must be a valid date.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            return response()->json(['errors' => $errors], 200);
        }

        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $workerId )
            ->pluck('application_no')
            ->first();
        $schemes = $request->scheme_name;


//        DB::beginTransaction();
//        try {
            if (is_array($schemes) && !empty($schemes)) {
                $affectedRows = DB::table('Worker.main_worker_schemes')
                    ->where('worker_id', $workerId)->delete();

                foreach ($schemes as $key => $scheme) {
                    $enrolled = $request->enrolled;

                    if ($enrolled == 0) {
                        $schemeName = null;
                        $registrationId = null;
                        $date = null;
                    } else {
                        $schemeName = $schemes[$key];
                        $registrationId = $request->registration_id[$key];
                        $date = $request->date[$key];
                    }
                    $data[] = MainWorkerScheme::create([
                        'worker_id' => $workerId,
                        'application_no' => $data['application_no'],
                        'scheme_name' => $schemeName,
                        'enrolled' => $enrolled,
                        'registration_id' => $registrationId,
                        'date' => $date,
                    ]);

                    if ($data != true) {
                        DB::rollback();
                        return response()->json(['success' => false, 'msg' => 'WSD001,Something Went Wrong!']);
                    }
                }
                DB::commit();
            }
//        }catch (Exception $e)
//            {
//                DB::rollback();
//                Alert::Toast($e->getMessage(),'error');
//            }

        Alert::toast('Scheme Details Updated Successfully', 'success');
        return response()->json(['success' => true, 'msg' => 'Scheme Details Updated!']);
    }

    public function documentDetails(Request $request)
    {
        $workerData = Session::get('workerData');

        if (!$workerData) {
            return $this->sessionFlash();
        }
        $workerId = $workerData->worker_id;
        $formdata = MainWorkerDocument::where('worker_id', $workerId)->first();

        $has_do_address = DB::table('Worker.main_worker_addresses')
            ->where('worker_id', $workerId)
            ->pluck('do')
            ->first();


        $has_ration_card = DB::table('Worker.main_worker_basic_details')
            ->where('worker_id', $workerId)
            ->pluck('has_ration_card')
            ->first();

        $has_pan = DB::table('Worker.main_worker_basic_details')
            ->where('worker_id', $workerId)
            ->pluck('pan')
            ->first();

        $readonly = true;
        $emptyField = null;

        if ($formdata) {
            foreach ($formdata->getAttributes() as $key => $value) {
                if (trim($value) === '') {
                    $emptyField = $key;
                    $readonly = true;
                    break;
                } else {
                    $readonly = false;
                }
            }
        }

        if (($emptyField == 'ration_card' && $has_ration_card == 0) || ($emptyField == 'pan_card' && $has_pan == 0) || ($emptyField == 'do' && $has_do_address == 1)) {
            $readonly = false;
        }

        $application_no = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $workerId)
            ->pluck('application_no')
            ->first();

        $twd = DB::table('Worker.main_worker_documents as twd')
            ->where('worker_id', $workerId)
            ->first();

        $vaultData = $this->getVaultData($request);
        $getVaultData = json_decode($vaultData->getData(), true);
        $base64Image = $getVaultData['photo'];
        $documents = collect([
                ['id' => 1, 'name' => 'residential_proof', 'label' => 'Present Address Proof ', 'uploaded' => !empty($twd->residential_proof)],
                ['id' => 2, 'name' => 'worker_bank_copy', 'label' => 'Aadhaar Linked Bank Copy', 'uploaded' => !empty($twd->worker_bank_copy)],
                ['id' => 3, 'name' => 'ration_card', 'label' => 'Ration Card', 'uploaded' => !empty($twd->ration_card)],
                ['id' => 4, 'name' => 'pan_card', 'label' => 'PAN Card', 'uploaded' => !empty($twd->pan_card)],
                ['id' => 5, 'name' => 'work_book', 'label' => 'Work Book/90 days Certificate', 'uploaded' => !empty($twd->work_book)]

        ]);


        return view('worker-renewal.worker-documents', compact('twd',  'readonly', 'application_no', 'has_ration_card','has_do_address', 'has_pan', 'documents','getVaultData','base64Image'));
    }

    public function updateDocumentDetails(Request $request)
    {
        $mimes = env('DOCUMENT_MIME_TYPES');

        $workerData = Session::get('workerData');
        if (!$workerData) {
            return $this->sessionFlash();
        }
        $worker_id = $workerData->worker_id;

        $validator = Validator::make(
            $request->all(),
            [
                "document_id" => ['required', 'in:1,2,3,4,5,'],
                "residential_proof" => 'required_if:document_id,1|mimes:pdf',
                "worker_bank_copy" => 'required_if:document_id,2|mimes:pdf',
                "ration_card" => 'required_if:document_id,3|mimes:pdf',
                "pan_card" => 'required_if:document_id,4|mimes:pdf',
                "work_book" => 'required_if:document_id,5|mimes:pdf'
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first());
            return back()->with('message', $validator->errors()->first());
        }


        $generateUUID = (string)Str::orderedUuid();

        $count = MainWorkerDocument::where('worker_id', $worker_id);
        if ($count->count() > 0) {
            $temporaryWorker = $count->first();
        } else {
            $temporaryWorker = new MainWorkerDocument();
        }
        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $worker_id)
            ->pluck('application_no')
            ->first();

        $temporaryWorker->application_no = $data['application_no'];


        if ($request->document_id == 1) {

            $residential_proof_name =  'Present-address-proof/' . $worker_id . $generateUUID . '.' . $request->residential_proof->extension();

            Storage::disk('public')->put($residential_proof_name, file_get_contents($request->residential_proof->getRealPath()));

            $temporaryWorker->worker_id = $worker_id;
            $temporaryWorker->residential_proof = "/private/{$residential_proof_name}";
            $temporaryWorker->res_proof_ext = $request->residential_proof->extension();
            $temporaryWorker->save();
            Alert::toast("Present Address Proof Uploaded successfully", "success");
            return redirect()->back();
        }

        if ($request->document_id == 2) {

            $worker_bank_copy =  'worker-bank-photocopy/' . $worker_id . $generateUUID . '.' . $request->worker_bank_copy->extension();
            Storage::disk('public')->put($worker_bank_copy, file_get_contents($request->worker_bank_copy->getRealPath()));

            $temporaryWorker->worker_id = $worker_id;
            $temporaryWorker->worker_bank_copy = "/private/{$worker_bank_copy}";
            $temporaryWorker->worker_bank_copy_ext = $request->worker_bank_copy->extension();
            $temporaryWorker->save();
            Alert::toast("Bank Copy Uploaded successfully", "success");
            return redirect()->back();
        }

        if ($request->document_id == 3) {
            $ration_card =  'ration-card/' . $worker_id . $generateUUID . '.' . $request->ration_card->extension();
            Storage::disk('public')->put($ration_card, file_get_contents($request->ration_card->getRealPath()));


            $temporaryWorker->worker_id = $worker_id;
            $temporaryWorker->ration_card = "/private/{$ration_card}";
            $temporaryWorker->ration_card_ext = $request->ration_card->extension();
            $temporaryWorker->save();

            Alert::toast("Ration Card Uploaded successfully", "success");
            return redirect()->back();
        }



        if ($request->document_id == 4) {

            $pan_card =  'pan-card/' . $worker_id . $generateUUID . '.' . $request->pan_card->extension();
            Storage::disk('public')->put($pan_card, file_get_contents($request->pan_card->getRealPath()));


            $temporaryWorker->worker_id = $worker_id;
            $temporaryWorker->pan_card = "/private/{$pan_card}";
            $temporaryWorker->pan_card_ext = $request->pan_card->extension();
            $temporaryWorker->save();

            Alert::toast("Pan Card Uploaded successfully", "success");
            return redirect()->back();
        }

        if ($request->document_id == 5) {

            $work_book =  'work-book/' . $worker_id . $generateUUID . '.' . $request->work_book->extension();
            Storage::disk('public')->put($work_book, file_get_contents($request->work_book->getRealPath()));


            $temporaryWorker->worker_id = $worker_id;
            $temporaryWorker->work_book = "/private/{$work_book}";
            $temporaryWorker->work_book_ext = $request->work_book->extension();
            $temporaryWorker->save();

            Alert::toast("Work Book Uploaded successfully", "success");
            return redirect()->back();
        }
    }

    /** Go to preview page */
    public  function preview(Request $request)
    {

        $worker_id = $request->query('worker_id');


        if ($worker_id) {
            session()->put('worker_id', $worker_id);
        }


        if (!$worker_id) {
            return $this->sessionFlash();
        }


        $maskAadharNumber = function ($aadharNumber) {
            return str_repeat('*', 8) . substr($aadharNumber, 8);
        };

        $vaultDataNew = $this->getVaultDataService->getVaultData($worker_id, "F");

        $getVaultData = json_decode($vaultDataNew->getData(), true);

        if (isset($getVaultData['uID'])) {
            $getVaultDatauID = $maskAadharNumber($getVaultData['uID']);
        }
        $aadhar_photo = $getVaultData['photo'];

        $worker_details = MainWorkerForm::where('worker_id', $worker_id)->first();

        $has_ration_card = DB::table('Worker.temporary_worker_basic_details')
            ->where('worker_id', $worker_id)
            ->pluck('has_ration_card')
            ->first();

        $has_pan = DB::table('Worker.temporary_worker_basic_details')
            ->where('worker_id', $worker_id)
            ->pluck('pan')
            ->first();
        return view('worker-renewal.preview-renewal-application', compact('worker_details','worker_id', 'getVaultData', 'aadhar_photo','getVaultDatauID','has_pan','has_ration_card'));
    }

    public function workBookDetails(Request $request)
    {
        $worker_id = session('worker')->worker_id;

        $vaultDataNew = $this->getVaultDataService->getVaultData($worker_id, "F");

        $data['getVaultData'] = json_decode($vaultDataNew->getData(), true);

        $data['details'] = MainWorkerForm::where('worker_id',$worker_id)->first();
        $lastRenewalDateOn = Carbon::parse($data['details']->id_card_expiry_date)
            ->subYears(2)
            ->addDay()
            ->toDateString();
        $data['last_renewal_date'] = $lastRenewalDateOn ?? $data['details']->id_card_created_at;

//        dd($lastRenewalDateOn);
        $data['existing_card_validity'] = $data['details']->id_card_expiry_date;
        $data['renewal_date'] = $data['details']->renewal_date;
        $data['application_submit_date'] = now();


        $lastRenewal = Carbon::parse($data['last_renewal_date']);
        $applicationSubmit = Carbon::parse($data['application_submit_date']);


        $totalYears = $lastRenewal->diffInYears($applicationSubmit);
        $data['total_years_since_last_renewal'] = $totalYears;
        $dateRanges = [];

        for ($i = 0; $i < $totalYears; $i++) {
            // Calculate from_date and to_date
            $from = $lastRenewal->copy()->addYears($i);
            $to = $lastRenewal->copy()->addYears($i + 1)->subDay();
            $dateRanges[] = [
                'from' => $from->format('d-m-Y'),
                'to' => $to->format('d-m-Y'),
            ];
        }

        $data['date_ranges'] = $dateRanges;




        $data['worktype'] = DB::table('Masterdata.type_of_works')
            ->select('work_type_code', 'work_type_name')
            ->get();
        $data['worknature'] = DB::table('Masterdata.nature_of_works')
            ->select('nature_of_work_code', 'nature_of_work')
            ->get();
        $data['type_of_employers'] = DB::table('Masterdata.type_of_employers')
            ->select('employer_code', 'employer_name')
            ->get();
        $data['professions'] = DB::table('Masterdata.professions')
            ->select('profession_code', 'profession_name')
            ->get();
        $data['ndc'] = WorkerNinetyDaysCertificate::where('worker_id', $worker_id)->get();


        $data['twed'] = DB::table('Worker.workers_workbook_details as twed')
            ->leftjoin('Masterdata.type_of_works as tow', 'twed.type_of_work', '=', 'tow.work_type_code')
            ->leftjoin('Masterdata.type_of_employers as toe', 'twed.type_of_employer', '=', 'toe.employer_code')
            ->where('worker_id', $worker_id)
            ->select(
                'twed.*',
                'tow.*',
                'toe.employer_code',
                'toe.employer_name AS empname'
            )
            ->first();

        $data['twc'] = DB::table('Worker.workers_workbook_details as twc')
            ->join('Masterdata.type_of_employers as toe', 'twc.type_of_employer', '=', 'toe.employer_code')
            ->join('Masterdata.type_of_works as tow', 'twc.type_of_work', '=', 'tow.work_type_code')
            ->join('Masterdata.professions as pro', 'twc.profession', '=', 'pro.profession_code')
            ->where('twc.worker_id', $worker_id)
            ->select(
                'twc.id',
                'twc.worker_id',
                'twc.application_no',
                'twc.employer_name AS emp',
                'twc.employer_contact_number',
                'twc.from_date',
                'twc.to_date',
                'twc.type_of_employer',
                'twc.profession',
                'twc.profession_others',
                'twc.date_count',
                'twc.certificate_proof',
                'twc.id as certificate_proof_id',
                'toe.employer_code',
                'toe.employer_name AS empname',
                'twc.type_of_work',
                'tow.work_type_code',
                'tow.work_type_name',
                'pro.*'
            )
            ->get();




        $data['ndc'] = WorkerNinetyDaysCertificate::where('worker_id', $worker_id)->get();

        foreach ($data['twc'] as $record) {
            // Assuming you have start_date and end_date columns in your database
            $startDate = new DateTime($record->from_date);
            $endDate = new DateTime($record->to_date);

            $dateInterval = $startDate->diff($endDate);
            $record->number_of_days = $dateInterval->days;
        }

        return view('worker-renewal.workbook-details',$data);
    }

    public function saveWorkBook(Request $request)
    {


        $worker_id = session('worker')->worker_id;
        $employerValidator = Validator::make(
            $request->all(),
            [

                'type_of_work.*' => 'required|exists:pgsql.Masterdata.type_of_works,work_type_code',
                'employer_name_certi.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'employer_contact_number.*' => 'required|numeric',
                'from_date.*' => 'required|date',
                'to_date.*' => 'required|date',
                'date_count.*' => 'required|numeric',
                'type_of_employer.*' => 'required|exists:pgsql.Masterdata.type_of_employers,employer_code',
                'certificate_proof.*' => 'required|file|mimes:pdf|max:2048', // 2MB

                'profession.*' => 'required|exists:pgsql.Masterdata.professions,profession_code',
                'profession_others.*' => function ($attribute, $value, $fail) use ($request) {
                    if (is_array($request->input('profession')) && in_array('28', $request->input('profession'))) {
                        if (empty($value)) {
                            $fail('The profession others field is required when profession is Others');
                        } elseif (!is_string($value)) {
                            $fail('The profession others field must be a string.');
                        }
                    }
                }
            ],
            [


                'type_of_work.*.required' =>'Field Cannot be blank',
                'employer_name_certi.*.required' => 'Field Cannot be blank.',
                'employer_contact_number.*.required' => 'Field Cannot be blank',
                'employer_contact_number.*.numeric' => 'Field Cannot be blank',
                'from_date.*.required' => 'Field Cannot be blank',
                'from_date.*.date' => 'Field Cannot be blank',
                'to_date.*.required' => 'Field Cannot be blank',
                'to_date.*.date' => 'Field Cannot be blank',
                'date_count.*.required' => 'Field Cannot be blank',
                'type_of_employer.*.required' => 'Field Cannot be blank',
                'profession.*.required' => 'Field Cannot be blank',
                'certificate_proof.*.required' => '⚠ Please upload a certificate proof.',
                'certificate_proof.*.file' => '⚠ The certificate proof must be a valid file.',
                'certificate_proof.*.mimes' => '⚠ The certificate proof must be a PDF file.',
                'certificate_proof.*.max' => '⚠ The certificate proof file size must not exceed 1MB.',


            ]
        );


        if ($employerValidator->fails()) {
            return response()->json(['errors' => $employerValidator->errors()], 200);
        }
        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $worker_id)
            ->value('application_no');

        DB::beginTransaction();
        try {
            $certificateData = [];
            $filePaths = []; // Initialize
            $f_names = $request->type_of_work;

            if (is_array($f_names) && !empty($f_names)) {
                $files = $request->file('certificate_proof');

                foreach ($f_names as $key => $f_name) {
                    // Check for required file
                    if (!isset($files[$key]) || !$files[$key]->isValid()) {
                        return response()->json([
                            'success' => false,
                            'errors' => [
                                "certificate_proof.$key" => ["⚠ Certificate proof is required."]
                            ]
                        ], 200);
                    }

                    // Process the file
                    $file = $files[$key];
                    $extension = $file->extension();
                    $uuid = Str::uuid();
                    $certificateFileName = "workbook-proof/{$worker_id}.{$uuid}.{$extension}";

                    Storage::disk('public')->put($certificateFileName, file_get_contents($file->getRealPath()));
                    $filePath = "/private/{$certificateFileName}";
                    $filePaths[$key] = $filePath;

                    // Store entry
                    $certificateData[] = WorkbookModel::create([
                        'worker_id' => $worker_id,
                        'application_no' => $data['application_no'],

                        'from_date' => Carbon::parse($request->from_date[$key])->format('Y-m-d'),
                        'to_date' => Carbon::parse($request->to_date[$key])->format('Y-m-d'),

                        'type_of_work' => $f_name,
                        'employer_name' => $request->employer_name_certi[$key],
                        'employer_contact_number' => $request->employer_contact_number[$key],
                        'date_count' => $request->date_count[$key],
                        'type_of_employer' => $request->type_of_employer[$key],
                        'certificate_proof' => $filePaths[$key],
                        'profession' => $request->profession[$key],
                        'profession_others' => $request->profession_others[$key],
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Entries saved successfully']);
        } catch (\Exception $e) {
//            return $e;
            DB::rollback();
            return response()->json(['success' => false, 'msg' => 'WEC001, Database Exception Error']);
        }

        Alert::toast('Workbook Details Saved Successfully', 'success');
        return response()->json(['success' => true, 'msg' => 'Workbook Details Updated!']);
    }


    public function ViewResProof()
    {
        $worker_id = session()->get('worker_id');
        $res_proof = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($res_proof->residential_proof);
        return response()->file($file);
    }



    public function ViewBankCopy()
    {
        $worker_id = session()->get('worker_id');
        $bank_copy = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($bank_copy->worker_bank_copy);
        return response()->file($file);
    }
    public function ViewWorkBook($id)
    {
        $workbook_proof = DB::table('Worker.workers_workbook_details')
            ->where('id', $id)
            ->first();

        if (!$workbook_proof || !$workbook_proof->certificate_proof) {
            abort(404, 'Workbook proof not found');
        }

        $path = ltrim($workbook_proof->certificate_proof, '/');

        // Check storage/app/private
        $privatePath = storage_path('app/' . $path);

        if (file_exists($privatePath)) {
            return response()->file($privatePath);
        }

        // Check storage/app/public
        $publicPath = storage_path(
            'app/public/' . str_replace('private/', '', $path)
        );

        if (file_exists($publicPath)) {
            return response()->file($publicPath);
        }

        abort(404, 'Workbook proof file not found');
    }


    public function ViewRation()
    {
        $worker_id = session()->get('worker_id');
        $ration = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($ration->ration_card);
        return response()->file($file);
    }
    public function ViewPan()
    {
        $worker_id = session()->get('worker_id');
        $pan = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($pan->pan_card);
        return response()->file($file);
    }


    public function SubmitRenewal(Request $request)
    {

        $worker_id = session('worker')->worker_id;


//        DB::beginTransaction();
//        try {
            $tfm = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
            if ($tfm) {
                $application_no = $tfm->application_no;
                $district = $tfm->district;
                $year = Carbon::now()->format('Y');
                $string = 'ABOCW';
                $text = 'REN';
                $ackNo = $string . '/' . $district . '/' . $year . '/' . $text . '/' . $application_no;
            } else {

                $ackNo = 'Error: No record found';
            }

            $data = RenewWorkerForm::updateOrCreate([
                'worker_id' => $worker_id,
                'office_id' => $tfm->office_id,
                'phone_no' => $tfm->phone_no,
                'district' => $tfm->district,
                'application_no' => $tfm->application_no,
                'id_card' => $tfm->id_card,
                'ack_no' => $ackNo,
                'status' => env('APPLICATION_RENEWAL_STATUS'),
                'active_status' => '0',
                'payment_status' => 'success',
                'vaultToken' => $tfm->vaultToken,
                'vaultPassKey' => $tfm->vaultPassKey,
            ]);
            $renewalDate = Carbon::parse($data->created_at)->addYears(2);
            $data->update(['renewal_date' => $renewalDate]);
            $data1 = MainWorkerForm::where('worker_id', $worker_id)->update([

                'application_no' => $tfm->application_no,
                'ack_no' => $ackNo,
                'renewal_status' => '1',
                'vaultToken' => $tfm->vaultToken,
                'vaultPassKey' => $tfm->vaultPassKey,

            ]);

            $data2 = WorkerApplicationStatus::updateOrCreate([
                'worker_id' => $worker_id,
                'application_no' => $tfm->application_no,
                'ack_no' => $ackNo,
                'sender_office_id' => $tfm->office_id,
                'application_status' => env('APPLICATION_RENEWAL_STATUS'),
                'remarks' => 'Application Submitted',
            ]);

            DB::commit();
            $phoneNumber = $tfm->phone_no;
            $application_no = $tfm->application_no;
            $bocw_card = $tfm->id_card;
            $response = $this->smsService->renewalApplicationSubmitSMS($phoneNumber, $application_no, $bocw_card);
            if ($response == true)
            {
                return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
            }
            else{
                Alert::toast('Application Submitted Successfully!', 'success');
                return redirect()->route('acknowledgement-renewal')->with('success', 'Successfully Submitted !');

            }
//        } catch (Exception $e) {
//            DB::rollBack();
//            Alert::toast('Something Went Wronng!', 'error');
//            return back();
//        }
    }

    public function acknowledgement(Request $request)
    {
        $worker_id = session('worker')->worker_id;
        // return PfcKioskDetail::get();
        $vaultDataNew = $this->getVaultDataService->getVaultData($worker_id, "F");
        $data['getVaultData'] = json_decode($vaultDataNew->getData(), true);
        $data['aadharPhoto'] = $data['getVaultData']['photo'];
        $data['worker'] = RenewWorkerForm::where('worker_id', $worker_id)->first();
        $data['mwf'] = DB::table('Worker.renew_worker_forms as wmfm')
            ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
            ->where('worker_id', $worker_id)
            ->select('wmfm.*', 'ofc.*')
            ->first();
        $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
            ->where('worker_id', $worker_id)
            ->select('wmbd.*')
            ->first();
//        $data['district_name'] = $data['worker']->districtName->district_name;
//        $data['office_name'] = $data['worker']->officeName->office_name;
        // return $pfcData->first();
        return view('worker-renewal.worker-acknowledgement', $data);
    }
    public function downloadAck(Request $request)
    {
        $workerData = Session::get('workerData');
        $worker_id = $workerData->worker_id;
        $vaultData = $this->getVaultData($request);
        $data['getVaultData'] = json_decode($vaultData->getData(), true);

        $data['worker'] = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
        $data['mwf'] = DB::table('Worker.main_worker_forms as wmfm')
            ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
            ->where('worker_id', $worker_id)
            ->select('wmfm.*', 'ofc.*')
            ->first();
        $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
            ->where('worker_id', $worker_id)
            ->select('wmbd.*')
            ->first();

        $data['emblem'] = public_path('/assets/template/images/bocw.png');

        $options = [
            'encoding' => 'utf-8',
            'enable-local-file-access' => true,
        ];

        $html = view('worker.pdf.download-as-pdf', $data)->render();
        $pdfContent =  Pdf::loadHTML($html)
            ->setOptions($options)
            ->output();
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Acknowledgement_Receipt.pdf"',
        ]);
    }



        public function renewalFee(Request $request)
        {
            $workerData = Session::get('workerData');
            $worker_id = $workerData->worker_id;

            $vaultData= $this->getVaultData($request);
            $getVaultData = json_decode($vaultData->getData(), true);
            $formattedCreatedAt['date'] = Carbon::parse($workerData->created_at)->format('d-m-Y h:i:s A');

            $data['status'] = DB::table('Worker.worker_application_statuses as was')
                ->join('Masterdata.roles as role', 'was.role_id', '=', 'role.id')
                ->where('worker_id', $workerData->worker_id)
                ->select('was.*', 'role.*', DB::raw("TO_CHAR(was.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at"))
                ->get();

            $data['subscription'] = DB::table('Worker.worker_subscriptions')->where('worker_id', $worker_id)->first();
            if ($data['subscription']) {
                $date = $data['subscription']->created_at;
                $data['dated'] = Carbon::parse($date)->format('d-m-Y h:i:s A');
            } else {
                $data['dated'] = Null; // or any default value you want to set
            }
            $data['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $worker_id)->first();
            $data['renewal_date'] = Carbon::parse($data['wmf']->renewal_date);
            $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $worker_id)->first();

            $registration_date = Carbon::parse($data['wmf']->created_at);
            $renewal_date = Carbon::parse($data['wmf']->renewal_date);
            $total_month = 0;
            $total_month = $renewal_date->diffInDays($registration_date);

            $subscription_amount = 0;

            $no_of_penalty_month = (int) ($total_month/30);
            $data['no_of_penalty_month'] = $no_of_penalty_month;
            $penalty_amount = 0;

            $subscription_amount = 20 * $no_of_penalty_month;

            for ($i = 0; $i < $no_of_penalty_month; $i++) {

                $penalty_amount += 2 * ($i + 1);
            }

            $data['penalty_amount'] = $penalty_amount;

            $data['subscription_amount'] = $subscription_amount;

            // return $penalty_amount;

            $data['current_date'] = now();

            return redirect()->route('worker-renewal.worker-renewal-payment',$data);

        }


}
