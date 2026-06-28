<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Admin\MasterdataControllers\ResidenceTypeController;
use App\Models\MainAddressModel;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\AddressModel;
use App\Models\MainFamilyModel;
use App\Models\MainFormModel;
use App\Models\MainWorkerAddress;
use App\Models\MainWorkerDocument;
use App\Models\MainWorkerFamily;
use App\Models\MainWorkerForm;
use App\Models\RenewWorkerFormHistory;
use App\Models\TemporaryWorkerDocument;
use App\Models\TemporaryWorkerForm;
use App\Models\UserLoginOtp;
use App\Models\WorkbookUpload;
use App\Models\WorkerLoginOtp;
use App\Models\WorkerPaymentTransaction;
use App\Models\WorkerIDCard;
use App\Models\WorkerReceipt;
use App\Models\WorkerRenewal;
use App\Models\WorkerSubscription;
use App\Models\MainWorkerCertificate;
use App\Models\WorkerPaymentSuccess;
use App\Models\Amount;
use App\Models\User;
use App\Models\Benefit;
use App\Models\FormSubmission;
use App\Models\MainWorkerBasicDetail;
use App\Models\Office;
use App\Models\PfcKioskDetail;
use App\Services\AES;
use App\Services\AesCipher;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\GetVaultDataService;
use App\Models\WorkerNinetyDaysCertificate;
use App\Models\WorkbookModel;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Log;
use App\Models\RenewWorkerForm;
use App\Models\WorkerApplicationStatus;
use App\Services\SmsGatewayService;
use App\Models\RevertBack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class WorkerLoginController extends Controller
{
    private $smsService;
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService, SmsGatewayService $smsService)
    {
        $this->getVaultDataService = $getVaultDataService;
        $this->smsService = $smsService;
    }


    public function index()
    {
        if (session()->get('worker-session') == true) {
            return redirect()->route('worker-dashboard');
        }
        return view('worker.workerLogin');
    }

    /** Worker Login
     * @param Request $request
     * @return JsonResponse
     */

    public function workerLogin(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'worker_id' => 'required|exists:pgsql.Worker.main_worker_forms,worker_id',
                'otp' => 'required|numeric|digits:6'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        } else {
            $loginOtp = UserLoginOtp::where('user_id', $request->worker_id)->where('otp', $request->otp)->first();
            $now = now();

            if (!$loginOtp) {
                return response()->json([
                    'status' => false,
                    'message' => "Your OTP is not Correct!"
                ]);
            } else if ($loginOtp && $now->isAfter($loginOtp->expire_at)) {
                return response()->json([
                    'status' => false,
                    'message' => "Your OTP has been Expired!"
                ]);
            }

            $worker = DB::table('Worker.main_worker_forms')
                ->where('worker_id', $request->worker_id)
                ->first();
            $rtpsData = session()->get('pfcData');
            if ($worker) {
                $loginOtp->update([
                    'expire_at' => now()
                ]);
                session()->put('worker', $worker);
                // $test = session()->get('worker');
                // return $test;
                session()->put('worker-session', true);
                return response()->json([
                    'status' => true,
                    'message' => "Login Successful!",
                    'redirect' => "/worker-dashboard"
                ]);
            } else {
                $nominee = User::where('user_name', $request->worker_id)->whereIn('role_id', [10, 11])->where('status', 1)->first();
                if ($nominee) {
                    Auth::loginUsingId($nominee->id);
                    return response()->json([
                        'status' => true,
                        'message' => "Login Successful!",
                        'redirect' => route('nominee.dashboard')
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "Invalida Credential"
                    ]);
                }
            }
        }
    }

    public function workerAppHistory(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }

        $record['worker'] = session()->get('worker');
        $formattedCreatedAt['date'] = Carbon::parse($record['worker']->created_at)->format('d-m-Y h:i:s A');

        $record['status'] = DB::table('Worker.worker_application_statuses as was')
            ->join('Masterdata.roles as role', 'was.sender_role_id', '=', 'role.id')
            ->where('worker_id', $record['worker']->worker_id)
            ->select('was.*', 'role.*', DB::raw("TO_CHAR(was.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at"))
            ->get();

        $record['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $record['worker']->worker_id)->first();
        $record['current_date'] = now();
        return view('worker.worker-application-history', $record, $formattedCreatedAt);
    }


    public function loginDash(Request $request)
    {

        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }


        $expiresAt = now()->addMinutes(config('session.lifetime'));
        $rtpsData = session()->get('pfcData');
        $workerData = session()->get('worker');
        // return $workerData;
        $worker_id = $workerData->worker_id;
        // for demo only..need to verify with himangka
        $renewal_date = null;
        $current_date = null;
        $cardIssueDate = null;
        $cardStatus = null;
        $status = null;
        $trigger = null;
        $trigger1 = null;
        $subscription_paid_till = null;
        $penalty_months = null;
        $no_of_penalty_from_last = null;
        $remaining_months_to_pay = null;
        $payment_subscription = null;
        $subscription = null;
        $isRenewal = false;
        $isRenewApplied = false;
        $isRenewalApproved = false;
        $renewal_data = null;
        $isWorkbookApplied = false;
        $is_paid = false;
        $last_sub = null;
        $first_paid = null;
        $is_app_paid = null;
        $duesCleared = null;
        $hasBeenResubmitted = null;
        $is_retired = null;
        $subscription_clear = null;
        $isSubscriptionApplied = null;
        $benefits = Benefit::where('status', 1)->orderBy('id')->get();
        $applications = FormSubmission::where('worker_id', $workerData->worker_id)->get();
        $latestResubmitStatus = null;
        $latestStatus = null;
        try {
            $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");

            $getVaultData = json_decode($vaultData->getData(), true);
            //        } catch (\Exception $e) {
            //            Alert::toast('Failed to load application, UIDAI Server is busy. Please try again later.', 'error');
            //        }
            //
            //        try {

            //            $getVaultData = null;

            $hasBeenResubmitted = null;
            $wmf = MainWorkerForm::where('worker_id', $workerData->worker_id)->first();
            $worker = MainWorkerBasicDetail::where('worker_id', $worker_id)->first();
            $app_status = DB::table('Worker.worker_application_statuses as was')
                ->join('Masterdata.roles as role', 'was.sender_role_id', '=', 'role.id')
                ->where('worker_id', $workerData->worker_id)
                ->select('was.*', 'role.*', DB::raw("TO_CHAR(was.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at"))
                ->get();
            $renewal_app_status = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->where('is_renewal', 1)
                ->where('ack_no', 'like', '%/REN/%')
                ->orderBy('created_at', 'asc')
                ->get();
            $renewal_status = RenewWorkerForm::where('worker_id', $worker_id)->first();
            $latestResubmitStatus = WorkerApplicationStatus::where('worker_id', $worker_id)
                ->where('is_renewal', 1)
                ->where('ack_no', 'like', '%/REN/%')
                ->latest('created_at')
                ->value('resubmit_status') ?? 0;

            $latestStatus = $renewal_app_status->last();


            $hasBeenResubmitted = $renewal_app_status->where('resubmit_status', 1)->isNotEmpty();
            //            return $renewal_app_status;





            $cardStatus = null;
            $cardIssueDate = null;
            $status = null;
            $isRenewal = false;
            $isSubscriptionApplied = false;
            $isRenewApplied = false;
            $isRenewalApproved = false;
            $renewal_data = null;
            $isWorkbookApplied = false;
            $no_of_penalty_from_last = 0;
            $penalty_months = 0;
            $subscription_paid_till = null;
            $is_paid = false;
            $last_sub = null;
            $first_paid = null;
            $is_app_paid = false;
            $duesCleared = false;
            $is_retired = false;
            $subscription_clear = false;
            $payment_subscription = WorkerSubscription::where('worker_id', $worker_id)->latest()->first();

            if ($payment_subscription) {
                $last_sub = Carbon::parse($payment_subscription->from_period)->subDay()->format('Y-m-d');
                $first_paid = true;
            } else {
                $last_sub = null;
                $first_paid = false;
            }

            //            $record['from_period'] = $payment_subscription->from_period;
            $record['subscription_paid_upto'] = Carbon::parse($wmf->subscription_validity_date)->startOfDay();
            $record['today'] = Carbon::today()->startOfDay();
            //            $record['renewal_date'] = Carbon::parse($wmf->renewal_date);
            $retirement_date = Carbon::parse($wmf->date_of_retirement);
            $expiryDate = Carbon::parse($wmf->id_card_expiry_date);
            $record['renewal_date'] = $expiryDate->copy()->addDay();
            $renewal_date = $record['renewal_date'];
            $current_date = Carbon::now();
            if ($renewal_date <= $current_date) {

                if ($retirement_date == $expiryDate) {

                    $is_retired = true;
                    $isRenewal = false;
                    $isWorkbookApplied = false;
                    if ($record['subscription_paid_upto'] == $expiryDate) {
                        $subscription_clear = true;
                    } else {
                        $subscription_clear = false;
                    }
                } else {
                    $is_retired = false;
                    $isRenewal = true;

                    if ($isRenewal) {
                        $isWorkbookApplied     = WorkbookModel::where('worker_id', $worker_id)->exists() ? true : false;
                        $isSubscriptionApplied = WorkerSubscription::where('worker_id', $worker_id)->exists() ? true : false;
                    }
                }
            }

            $is_paid = false;
            $latestSubscription = WorkerSubscription::where('worker_id', $worker_id)
                ->latest()
                ->first();

            if ($latestSubscription && $latestSubscription->payment_status == '1') {
                $is_paid = true;
            }
            //            Log::channel('admin-log')->info('log created');
            if (RenewWorkerForm::where('worker_id', $worker_id)->exists()) {
                $renewal_data = RenewWorkerForm::where('worker_id', $worker_id)->latest()->first();
                if ($renewal_data->status != 'F') {
                    $isRenewal = false;
                    $isRenewApplied = true;
                }
            }
            //            Log::channel('admin-log')->info('not equal to F');

            if (RenewWorkerForm::where('worker_id', $workerData->worker_id)->exists()) {
                $renewal_app = RenewWorkerForm::where('worker_id', $workerData->worker_id)->latest()->first();
                if ($renewal_app->status == 'F') {
                    $isRenewalApproved = true;
                    $validityDate = Carbon::parse($wmf->id_card_expiry_date);

                    $subscription_validity = Carbon::parse($wmf->subscription_validity_date);
                    if ($validityDate == $subscription_validity) {
                        $duesCleared = true;
                    } else {
                        $duesCleared = false;
                    }


                    $sub = WorkerSubscription::where('worker_id', $worker_id)->latest()->first();
                    if ($sub) {
                        if ($sub->payment_status == 1) {
                            $is_app_paid = true;
                        } else {
                            $is_app_paid = false;
                        }
                    } else {
                        $is_app_paid = false;
                    }
                } else {
                    $isRenewalApproved = false;
                    $is_app_paid = false;
                }
            }
            //            Log::channel('admin-log')->info('equal to F');
            $record['diffInUpToRenew'] = $record['renewal_date']->diffInMonths($record['today']);
            //            Log::channel('admin-log')->info('diffInUpToRenew');
            $record['advancedPaymentDate'] = null;
            $record['arithmeticSum'] = 0;
            $record['constantSum'] = 0;
            $record['totalSum'] = 0;
            $trigger = false;
            $trigger1 = false;
            $remaining_months_to_pay = 0;

            $subscription = WorkerSubscription::where('worker_id', $wmf->worker_id)->get();
            //            Log::channel('admin-log')->info('subscription');
            if ($record['subscription_paid_upto'] > $record['today']) {

                $status = 'Active';
            } else {
                if ($workerData->already_registered == 1) {
                    if ($subscription->count() == 0) {
                        $subscription_paid_upto = Carbon::parse($wmf->subscription_validity_date);
                        //                        Log::channel('admin-log')->info('subscription_paid_upto');
                        $subscription_date = $subscription_paid_upto->format('d');

                        $onboardingDate = Carbon::parse($wmf->created_at)->startOfDay();

                        $onboarding_date = $onboardingDate->format('d');


                        $differenceFromOnboardingTillToday = $onboardingDate->diffInMonths($record['today'], false);


                        if ($subscription_date + 1 < $onboarding_date) {

                            $no_of_month = 4;
                        } elseif ($subscription_date == $onboarding_date) {

                            $no_of_month = 3;
                        } else {

                            $no_of_month = 3;
                        }
                        $advancedPaymentDate = Carbon::parse($onboardingDate)->startOfDay()->addMonths($no_of_month)->day($subscription_date);
                        $subscription_day_upto = Carbon::parse($wmf->subscription_validity_date)->format('d');

                        $todaysdate = $record['today']->format('d');

                        //first Scenario

                        if ($subscription_day_upto < $todaysdate) {
                            //pay upto same month
                            $paymentMonth = $record['today']->format('m');

                            $pendingPaymentDate = Carbon::parse($subscription_paid_upto)->month($paymentMonth);
                        } else {

                            $paymentMonth = $record['today']->format('m') - 1;

                            $pendingPaymentDate = Carbon::parse($subscription_paid_upto)->month($paymentMonth);
                        }


                        if ($pendingPaymentDate > $advancedPaymentDate) {

                            $intial_payment_date = $pendingPaymentDate;
                        } else {

                            $intial_payment_date = $advancedPaymentDate;
                        }

                        $id_expiry_date = Carbon::parse($wmf->id_card_expiry_date);

                        //2nd scenario

                        if ($intial_payment_date < $id_expiry_date) {

                            $final_payment_date = $intial_payment_date;
                        } else {

                            $final_payment_date = $id_expiry_date;
                        }


                        $record['advancedPaymentDate'] = $final_payment_date;

                        $no_of_months = $subscription_paid_upto->diffInMonths($final_payment_date, false);


                        $record['no_of_months'] = max(0, $no_of_months);

                        $month = $record['today']->format('m');
                        $year = $record['today']->format('Y');

                        if ($todaysdate > $subscription_day_upto) {

                            $record['latest_penalty_month'] = $month;
                            $date = $subscription_day_upto;
                            $CurrentYear = $year;
                            $fullDate = $CurrentYear . '-' . $record['latest_penalty_month'] . '-' . $date;
                            $Ndate = Carbon::parse($fullDate);
                        } else {

                            $record['latest_penalty_month'] = $month - 1;
                            $date = $subscription_day_upto;
                            $CurrentYear = $year;
                            $fullDate = $CurrentYear . '-' . $record['latest_penalty_month'] . '-' . $date;
                            $Ndate = Carbon::parse($fullDate);
                        }


                        /** Case 1  for penalty calculation*/
                        $record['no_of_penalty_months'] = $penalty_months = $subscription_paid_upto->diffInMonths($Ndate);
                        $remaining_months_to_pay = $record['no_of_penalty_months'];


                        if ($penalty_months >= 12) {
                            $status = "Lapsed";
                        } elseif ($penalty_months >= 12) {
                            $status = "Lapsed & Suspended";
                        }


                        if ($subscription_paid_upto <= $Ndate) {
                            $trigger = true;
                        } else {
                            $trigger = false;
                        }


                        $fine = 0;

                        if ($record['advancedPaymentDate'] >= $Ndate) {
                            for ($i = 1; $i <= $record['no_of_penalty_months']; $i++) {
                                $fine += 2 * $i;
                            }
                        } else {

                            for ($i = ($record['no_of_penalty_months'] - $no_of_months) + 1; $i <= $record['no_of_penalty_months']; $i++) {
                                $fine += 2 * $i;
                            }
                        }


                        $record['constantSum'] = 20 * $no_of_months;

                        $record['arithmeticSum'] = $fine;

                        $record['totalSum'] = $record['constantSum'] + $record['arithmeticSum'];


                        if ($current_date->isAfter($renewal_date)) {
                            $cardStatus = [
                                'message' => "Inactive",
                                'date' => $renewal_date->format('d-m-Y'),
                                'color' => 'red'
                            ];
                        } elseif ($renewal_date == $current_date) {
                            $cardStatus = [
                                'message' => "Active",
                                'date' => $renewal_date->format('d-m-Y'),
                                'color' => 'green'
                            ];
                        } else {
                            $cardStatus = [
                                'message' => "Active",
                                'date' => $renewal_date->format('d-m-Y'),
                                'color' => 'green'
                            ];
                        }
                        //dd($remaining_months_to_pay);
                    } else {

                        $latestSubscription = WorkerSubscription::Where('worker_id', $wmf->worker_id)->orderBy('created_at', 'desc')->latest()->first();

                        $record['start_date'] = $startDate = Carbon::parse($latestSubscription->to_period)->format('Y-m-d');

                        $record['from_period'] = Carbon::parse($wmf->subscription_validity_date)->addDay();

                        $record['card_expiry_date'] = $endDate = Carbon::parse($wmf->id_card_expiry_date);

                        $total_months = $record['from_period']->diffInMonths($record['card_expiry_date']);

                        //              $months_paid = $subscription->skip(1)->sum('month_paid');
                        $months_paid = $subscription->sum('month_paid');

                        if ($record['start_date'] != $record['card_expiry_date']) {

                            $remaining_months_to_pay = $total_months + 1;
                        } else {

                            $remaining_months_to_pay = $total_months;
                        }


                        if ($remaining_months_to_pay > 0) {
                            $trigger1 = true;
                        } else {

                            $trigger1 = false;
                        }

                        $subscription = DB::table('Worker.worker_subscriptions')->where('worker_id', $wmf->worker_id)->latest()->first();

                        $startDate = Carbon::parse($subscription->to_period)->startOfDay();


                        if ($current_date->isBefore($startDate)) {

                            $penalty_months = 0;
                        } else {

                            $penalty_months = $current_date->diffInMonths($startDate);

                            if ($penalty_months >= 3 && $payment_subscription->payment_status == '0') {
                                $status = 'Lapsed & Suspended';
                            } elseif ($penalty_months = 12 && $payment_subscription->payment_status == '0') {
                                $status = 'Lapsed & Ceased';
                            }
                        }


                        if ($current_date->isAfter($renewal_date)) {
                            $cardStatus = [
                                'message' => "Inactive",
                                'date' => $renewal_date->format('d-m-Y'),
                                'color' => 'red'
                            ];
                        } elseif ($renewal_date == $current_date) {
                            $cardStatus = [
                                'message' => "Active",
                                'date' => $renewal_date->format('d-m-Y'),
                                'color' => 'green'
                            ];
                        } else {
                            $cardStatus = [
                                'message' => "Active",
                                'date' => $renewal_date->format('d-m-Y'),
                                'color' => 'green'
                            ];
                        }
                    }
                } else {
                    //new worker


                    $MainData = MainWorkerForm::where('worker_id', $wmf->worker_id)->first();

                    $subscription = DB::table('Worker.worker_subscriptions')->where('worker_id', $wmf->worker_id)->latest()->first();

                    if (!isEmpty($subscription)) {

                        $startDate = Carbon::parse($subscription->to_period)->startOfDay();

                        if ($current_date->isBefore($startDate)) {

                            $penalty_months = 0;
                            $status = 'Active';
                        } else {

                            $penalty_months = $current_date->diffInMonths($startDate);
                            if ($penalty_months >= 3 && $payment_subscription->payment_status == '0') {
                                $status = 'Lapsed & Suspended';
                            } elseif ($penalty_months = 12 && $payment_subscription->payment_status == '0') {
                                $status = 'Lapsed & Ceased';
                            }
                        }


                        $paymentDeadline = $startDate->copy()->addMonths(3);
                    } else {

                        $startDate = Carbon::parse($MainData->id_card_created_at)->startOfDay();
                        $advancedPaymentDate = $startDate->copy()->addMonths(3);


                        if ($current_date->isBefore($advancedPaymentDate)) {

                            $penalty_months = $current_date->diffInMonths($advancedPaymentDate);

                            $status = "Advanced Due";
                        }
                    }
                    $expiry_date = Carbon::parse($wmf->created_at);
                    $renewal_date = Carbon::parse($wmf->renewal_date);
                }
            }
        } catch (exception $e) {
            //                         return $e;
            Alert::toast('Failed to load application, UIDAI Server is busy. Please try again later.', 'error');
            //            return back();
        }
        // demo

        $isRenewalApplied = false;
        return view('worker.workerdashboard', compact(
            'workerData',
            'getVaultData',
            'worker',
            'app_status',
            'renewal_date',
            'current_date',
            'cardIssueDate',
            'cardStatus',
            'status',
            'trigger',
            'trigger1',
            'subscription_paid_till',
            'penalty_months',
            'no_of_penalty_from_last',
            'wmf',
            'remaining_months_to_pay',
            'payment_subscription',
            'subscription',
            'isRenewal',
            'isRenewApplied',
            'isRenewalApproved',
            'renewal_data',
            'renewal_app_status',
            'isWorkbookApplied',
            'is_paid',
            'last_sub',
            'first_paid',
            'is_app_paid',
            'duesCleared',
            'hasBeenResubmitted',
            'is_retired',
            'subscription_clear',
            'isSubscriptionApplied',
            'benefits',
            'applications',
            'latestResubmitStatus',
            'latestStatus',
            'expiresAt',
            'renewal_status'
        ))
            ->with('success', 'User logged in successfully!');
    }




    public function getScheme()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerId = session()->get('worker');

        $record['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $record['worker']->worker_id)->first();
        $record['renewal_date'] = Carbon::parse($record['wmf']->renewal_date);
        $renewal_date = Carbon::parse($record['wmf']->renewal_date);
        $record['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $record['worker']->worker_id)->first();
        $record['schemes'] = DB::table('Worker.main_worker_schemes as wms')
            ->join('Masterdata.schemes as sc', 'wms.scheme_name', '=', 'sc.scheme_code')
            ->where('worker_id', $record['worker']->worker_id)->get();
        $record['current_date'] = now();
        return view('worker.worker-claimed-schemes', $record);
    }

    public function logoutUser(Request $request)
    {
        session::flush();
        session()->flush();
        session()->regenerate(true);
        return Redirect::to('/');
    }

    public function getProfile(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        };
        $record['worker'] = $workerData = session()->get('worker');
        $workerId = $workerData->worker_id;
        $data['wmf'] = MainWorkerForm::where('worker_id', $workerId);


        $data['user'] = DB::table('Worker.main_worker_forms as wfm')
            ->leftjoin('Worker.main_worker_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
            ->leftjoin('Masterdata.genders as gen', 'wmbd.gender_id', '=', 'gen.gender_code')
            ->leftjoin('Masterdata.categories as cat', 'wmbd.category', '=', 'cat.category_code')
            ->where('wfm.worker_id', $workerId)
            ->select('wfm.*', 'wmbd.*', 'gen.*', 'cat.*')
            ->first();
        $data['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $data['renewal_date'] = Carbon::parse($data['wmf']->renewal_date);
        $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        $data['add'] = DB::table('Worker.main_worker_addresses as twam')
            ->leftJoin('Masterdata.residences as cres', 'twam.c_residence', '=', 'cres.residence_code')
            ->leftjoin('Masterdata.houses as chs', 'twam.c_house_type', '=', 'chs.house_code')
            ->where('twam.worker_id', $workerId)
            ->select('twam.*', 'cres.*', 'chs.*')
            ->first();
        $data['wfd'] = DB::table('Worker.main_worker_families as mwf')
            ->leftjoin('Worker.main_worker_basic_details as twbd', 'mwf.worker_id', '=', 'twbd.worker_id')
            ->leftjoin('Masterdata.educations as edu', 'mwf.education', '=', 'edu.education_code')
            ->leftjoin('Masterdata.professions as prof', 'mwf.profession', '=', 'prof.profession_code')
            ->leftjoin('Masterdata.relations as rel', 'mwf.relation', '=', 'rel.relation_code')
            ->where('mwf.worker_id', $workerId)
            ->select('mwf.*', 'edu.*', 'prof.*', 'rel.*', DB::raw('mwf.id as family_db_id'))
            ->get();
        // Log the ids that will be rendered to help debug incorrect id values in the form
        try {
            $logArr = [];
            foreach ($data['wfd'] as $fm) {
                $logArr[] = [
                    'family_db_id' => $fm->family_db_id ?? null,
                    'id' => $fm->id ?? null,
                ];
            }
            Log::info('Rendering workerProfile family rows: ' . json_encode($logArr));
        } catch (\Exception $e) {
            Log::error('Failed to log wfd ids: ' . $e->getMessage());
        }

        $data['current_date'] = now();
        $data['professions'] = DB::table('Masterdata.professions')
            ->select('profession_code', 'profession_name')
            ->where('profession_code', '!=', 0)
            ->get();
        $data['educations'] = DB::table('Masterdata.educations')
            ->select('education_code', 'education_name')
            ->get();
        $data['relations'] = DB::table('Masterdata.relations')
            ->select('relation_code', 'relation_name')
            ->get();
        $data['states'] = DB::table('Masterdata.states')
            ->orderBy('state_name', 'asc')
            ->get();
        $vaultData = $this->getVaultDataService->getVaultData($workerId, "F");
        $data['getVaultData'] = json_decode($vaultData->getData(), true);
        $data['residence'] = DB::table('Masterdata.residences')->where('residence_code', '!=', $data['add']->residence_code)->get();
        $data['house'] = DB::table('Masterdata.houses')->where('house_code', '!=', $data['add']->house_code)->get();
        return view('worker.workerProfile', $data);
    }


    public function downloadIdCard()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerValue = session()->get('worker');
        $workerId = $record['worker']->worker_id;
        $data['user'] = DB::table('Worker.main_worker_forms as wfm')
            ->where('wfm.worker_id', $workerId)
            ->first();
        $record['worker'] = $workerValue = session()->get('worker');
        $passport = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $workerId)
            ->first()->passport_image;
        $data['gender'] = DB::table('Masterdata.genders')->get();
        // dd($data['gender']);
        $data['passport'] = Storage::path($passport);
        //        $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        $data['wrkr'] = DB::table('Worker.main_worker_basic_details as twbd')
            ->leftjoin('Masterdata.genders as gen', 'twbd.gender_id', '=', 'gen.gender_code')->where('worker_id', $workerId)->first();
        $data['current_date'] = now();
        return view('worker.pdf.download-id-card', $data);
    }

    public function generateIDCard(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerValue = session()->get('worker');
        $workerId = $record['worker']->worker_id;
        $mimes_pdf = env('PDF_MIME_TYPES');
        DB::beginTransaction();
        try {
            $generateUUID = Str::orderedUuid();

            // Store the generated ID card PDF
            $generated_id_card_path = 'generated_id_card/' . $workerId . '_' . $generateUUID . '.pdf';
            $pdf = $this->downloadIdCard(); // Call your existing method to generate the PDF
            Storage::disk('public')->put($generated_id_card_path, $pdf);

            // Save the path to the generated ID card in the database
            $data = WorkerIDCard::create([
                'worker_id' => $workerId,
                'generated_id_card' => "/private/$generated_id_card_path",
            ]);

            if (!$data) {
                DB::rollback();
                return redirect()->back()->with('error', '#WFM0003 Unable to insert data!');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', '#WFM000 DB exception error!');
        }
        $data['user'] = DB::table('Worker.main_worker_forms as wfm')
            ->where('wfm.worker_id', $workerId)
            ->select('wfm.status')
            ->first();
        $data['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        $data['current_date'] = now();
        return view('worker.worker-id-card', $data);
    }

    public function getWorkerId()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerValue = session()->get('worker');
        $workerId = $record['worker']->worker_id;
        $data['user'] = DB::table('Worker.main_worker_forms as wfm')
            ->where('wfm.worker_id', $workerId)
            ->select('wfm.status')
            ->first();
        $record['worker'] = $workerValue = session()->get('worker');
        $passport = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $workerId)
            ->first()->passport_image;
        $data['passport'] = Storage::path($passport);
        $data['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();

        $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        $data['id'] = DB::table('Worker.worker_id_cards')->where('worker_id', $workerId)->first();
        $data['idpdf'] = Storage::path($data['id']->generated_id_card);
        $expiry_date = Carbon::parse($data['wmf']->created_at);
        $data['renewal_date'] = Carbon::parse($data['wmf']->renewal_date);
        $renewal_date = Carbon::parse($data['wmf']->renewal_date);
        $daysUntilRenewal = $renewal_date->diffInDays($expiry_date);
        // Check if renewal date has exceeded the expiry date
        if ($renewal_date->gt($expiry_date)) {
            $no_of_penalty_month = (int)($daysUntilRenewal / 30);
        } else {
            $no_of_penalty_month = 0;
        }

        $penalty_amount = 0;
        $subscription_amount = 20 * $no_of_penalty_month;

        for ($i = 0; $i < $no_of_penalty_month; $i++) {
            $penalty_amount += 2 * ($i + 1);
        }
        $data['penalty_amount'] = $penalty_amount;
        $data['subscription_amount'] = $subscription_amount;
        $data['current_date'] = now();
        return view('worker.worker-id-card', $data);
    }

    public function getIdCard()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }

        $record['worker'] = $workerValue = session()->get('worker');
        $workerId = $record['worker']->worker_id;

        $data = DB::table('Worker.worker_id_cards')
            ->where('worker_id', $workerId)
            ->first();

        $file = Storage::path($data->generated_id_card);

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="filename.pdf"',
        ];

        return response()->file($file, $headers);
    }

    public function updateFamily(Request $request)
    {
        $record['worker'] = session()->get('worker');
        $session_worker_id = $record['worker']->worker_id;
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $familyValidator = Validator::make(
            $request->all(),
            [

                'first_name' => 'required|array',
                'first_name.*' => 'required|regex:/^[\pL\s]+$/u',
                'last_name' => 'required|array',
                'last_name.*' => 'required||regex:/^[\pL\s.-]+$/u|max:255',
                'guardain_name' => 'nullable|array',
                // 'guardain_name.*' => 'nullable|regex:/^[a-zA-Z ]+$/',
                'guardain_name.*' => [
    'nullable',
    function ($attribute, $value, $fail) use ($request) {
        // Extract the index from "guardain_name.0", "guardain_name.1", etc.
        $index = explode('.', $attribute)[1];
        $dob = $request->input("dob.$index");

        if (!$dob) return;

        $age = \Carbon\Carbon::parse($dob)->age;

        if ($age < 18 && empty($value)) {
            $fail('Guardian name is required for members under 18 years old.');
        }
    },
    'regex:/^[a-zA-Z ]+$/',
],
                'dob' => 'required|array',
                'dob.*' => 'required|date',
                'relation' => 'required|array',
                // 'profession' => 'required|array',
                // 'profession.*' => 'required|string|max:255',
                // 'education' => 'required|array',
                // 'education.*' => 'required|string|max:255',
                'nominee' => 'required|array',
                'nominee.*' => 'required|in:0,1',
                'already_registered' => 'required|array',
                'already_registered.*' => 'required|in:0,1',
                'bocwwb_id' => 'array',
                'bocwwb_id.*' => 'required_if:already_registered.*,1',
                'nominee_percentage' => 'array',
                'nominee_percentage.*' => 'required_if:nominee.*,1',
                'nominee_account.*' => 'nullable|numeric'
            ],

            [
                'first_name.*.required' => '⚠ First name cannot be blank',
                'last_name.*.required' => '⚠ Last name cannot be blank',
                'guardain_name.*.regex' => '⚠ Invalid Format',
                'relation.*.required' => '⚠ Please Select',
                'profession.*.required' => '⚠ Please Select',
                'education.*.required' => '⚠ Please Select',
                'dob.*.required' => '⚠ Date of birth cannot be blank',
                'dob.*.date' => '⚠ The date of birth must be a valid date',
                'nominee.*.required' => '⚠ Please Select',
                'nominee_percentage.*.required_if' => '⚠ Nominee percentage field is required',
                'bocwwb_id.*.required_if' => '⚠ BOC Id field is required',
                'already_registered.*.required' => '⚠ Please Select',
                'nominee_account.*.numeric' => '⚠ Invalid Account Type'
            ]
        );
        if ($familyValidator->fails()) {
            $errors = $familyValidator->errors()->messages();
            return response()->json(['errors' => $errors], 200);
        }


        $familyData = $request->all();
        $applicationNo = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->pluck('application_no')
            ->first();
        $existingFamilyMembers = MainWorkerFamily::where('worker_id', $session_worker_id)->get()->keyBy('id');

        // Defensive: normalize incoming family ids to integers and log for debugging
        if (!isset($familyData['family_id'])) {
            $familyData['family_id'] = [];
        }
        if (!is_array($familyData['family_id'])) {
            $familyData['family_id'] = [$familyData['family_id']];
        }
        $receivedIds = array_values(array_filter(array_map('intval', $familyData['family_id'])));
        Log::info('Family update - received family_ids: ' . json_encode($receivedIds));
        Log::info('Family update - existing ids: ' . json_encode($existingFamilyMembers->keys()->toArray()));

        // Use explicit DB lookup by id+worker to avoid collisions and ensure correct updates
        DB::beginTransaction();
        try {
            foreach ($familyData['first_name'] as $index => $value) {
                $familyMemberId = isset($familyData['family_id'][$index]) && $familyData['family_id'][$index] !== '' ? (int)$familyData['family_id'][$index] : null;

                $payload = [
                    'first_name' => $familyData['first_name'][$index],
                    'last_name' => $familyData['last_name'][$index],
                    'dob' => $familyData['dob'][$index],
                    'guardain_name' => $familyData['guardain_name'][$index] ?? null,
                    'application_no' => $applicationNo,
                    'relation' => $familyData['relation'][$index],
                    'nominee' => $familyData['nominee'][$index],
                    'nominee_percentage' => $familyData['nominee_percentage'][$index] ?? null,
                    'nominee_account' => $familyData['nominee_account'][$index] ?? null,
                    'already_registered' => $familyData['already_registered'][$index],
                    'bocwwb_id' => $familyData['bocwwb_id'][$index] ?? null,
                ];

                if ($familyMemberId) {
                    $member = MainWorkerFamily::where('id', $familyMemberId)->where('worker_id', $session_worker_id)->first();
                    if ($member) {
                        $member->update($payload);
                        Log::info('Family update - updated member id: ' . $familyMemberId);
                    } else {
                        $new = MainWorkerFamily::create(array_merge(['worker_id' => $session_worker_id, 'application_no' => $applicationNo], $payload));
                        Log::warning('Family update - provided family_id not found for worker, created new id: ' . $new->id);
                    }
                } else {
                    $new = MainWorkerFamily::create(array_merge(['worker_id' => $session_worker_id, 'application_no' => $applicationNo], $payload));
                    Log::info('Family update - created new member id: ' . $new->id);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Family update failed: ' . $e->getMessage());
            throw $e;
        }

        // Determine which existing ids were removed from the submitted form and delete them
        $existingIds = $existingFamilyMembers->keys()->map(fn($v) => (int)$v)->toArray();
        $submittedFamilyIds = array_values(array_filter(array_map('intval', $familyData['family_id'] ?? [])));
        $idsToDelete = array_diff($existingIds, $submittedFamilyIds);

        if (!empty($idsToDelete)) {
            MainWorkerFamily::whereIn('id', $idsToDelete)
                ->where('worker_id', $session_worker_id)
                ->delete();
            Log::info('Family update - deleted member ids: ' . json_encode(array_values($idsToDelete)));
        }
        Alert::toast('Family Details Updated Successfully', 'success');
        return response()->json([
            'status' => 'success',
            'redirect_url' => route('worker-profile'),
            'message' => 'Family details updated successfully.'
        ]);
    }


    /** Update Current Address */
    public function updateWorkerAddress(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerValue = session()->get('worker');
        $validate = $request->validate(
            [
                'c_residence' => 'required',
                'c_house_type' => 'required',
                'c_house_no' => 'numeric',
                'c_road' => 'required|custom_rule',
                'c_area' => 'required|custom_rule',
                'c_city' => 'required|regex:/^[\pL\s]+$/u',
                'c_state' => 'required',
                'c_district' => 'required',
                'c_post_office' => 'required',
                'c_pin' => 'required|min:6|numeric',
                'c_std' => 'numeric',
                'c_circle' => 'required',
            ],
            [
                'c_residence.required' => 'Residence Type Cannot Be Blank',
                'c_house_type.required' => 'House Type Cannot Be Blank',
                'c_house_no.numeric' => 'House No Should Be Numbers',
                'c_area.required' => 'Area Name Cannot Be Blank',
                'c_area.alpha' => 'Area Name Cannot Be a Number',
                'c_city.required' => 'City Cannot Be Blank',
                'c_city.alpha' => 'City Cannot Be a Number',
                'c_district.required' => 'District Cannot Be blank',
                'c_circle.required' => 'Sub-District Cannot Be blank',
                'c_post_office.required' => 'Post Office Cannot Be Blank',
                'c_pin.required' => 'Pin Code Cannot Be Blank',
                'c_road.required' => 'Road Name Cannot Be Blank',
                'c_std.numeric' => 'STD Code Should Be a NUmber',
                'c_state.required' => 'State Cannot Be Blank',
                'c_road.custom_rule' => 'Road Contains Invalid Character',
            ]
        );
        $formData = DB::table('Worker.main_worker_addresses')->where('worker_id', $record['worker']->worker_id)->first();
        $data = MainWorkerAddress::where('worker_id', $record['worker']->worker_id)->update([
            'worker_id' => $record['worker']->worker_id,
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
            'building' => $request->building_name,
            'landmark' => $request->landmark,
            'do' => $request->do,
        ]);
        return redirect()->route('worker-profile')->with('success');
    }

    public function addFamily(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerValue = session()->get('worker');
        $rules = [
            'first_name.*' => 'required|string|max:255',
            'last_name.*' => 'required|string|max:255',
            'gurdain_name.*' => 'required|string|max:255',
            'dob.*' => 'required|date',
            'relation.*' => 'required|string|max:255',
            'profession.*' => 'nullable|string|max:255',
            'education.*' => 'nullable|string|max:255',
            'nominee.*' => 'nullable|string|max:255',
            'already_registered.*' => 'required|boolean',
            'bocwwb_id.*' => 'nullable|string|max:255',
        ];
        $messages = [
            'first_name.*.required' => 'First name cannot be blank',
            'last_name.*.required' => 'Last name cannot be blank',
            'gurdain_name.*.required' => 'Guardian name cannot be blank',
            'relation.*.required' => 'Relation cannot be blank',
            'profession.*.required' => 'Profession cannot be blank',
            'education.*.required' => 'Education cannot be blank',
            'dob.*.required' => 'Date of birth cannot be blank',
            'dob.*.date' => 'The date of birth must be a valid date.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $f_names = $request->first_name;
        $bocwwbIds = $request->bocwwb_id;
        DB::beginTransaction();
        try {
            if (is_array($f_names) && !empty($f_names)) {
                foreach ($f_names as $key => $f_name) {
                    $bocwwbId = $bocwwbIds[$key];
                    $existingRecord = DB::table('Worker.main_worker_families')
                        ->whereIn('bocwwb_id', [$bocwwbId])
                        ->count();
                    if ($existingRecord !== null && $existingRecord > 0) {
                        DB::rollback();
                        return redirect()->back()->with('error', 'Value already exists in the database');
                    } else {
                        $data = MainWorkerFamily::Create([
                            'worker_id' => $record['worker']->worker_id,
                            'first_name' => $f_names[$key],
                            'last_name' => $request->last_name[$key],
                            'gurdain_name' => $request->gurdain_name[$key],
                            'dob' => $request->dob[$key],
                            'relation' => $request->relation[$key],
                            'profession' => $request->profession[$key],
                            'education' => $request->education[$key],
                            'nominee' => $request->nominee[$key],
                            'nominee_percentage' => $request->nominee_percentage[$key],
                            'nominee_account' => $request->nominee_account[$key],
                            'already_registered' => $request->already_registered[$key] ?? null,
                            'already_registered_state' => $request->already_registered[$key] ?? null,
                            'bocwwb_id' => $bocwwbId,

                        ]);
                    }

                    if ($data != true) {
                        DB::rollback();
                        return redirect()->back()->with('error', '#WFM0001 Unable to insert data!');
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', '#WFM0002 DB exception error!');
        }
        session()->flash('alert_shown', true);
        session()->flash('success', 'Family Details Submitted!');
        return redirect()->route('worker-profile')->with('success');
    }

    public function ShowSubscription(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }

        $record['workerData'] = session()->get('worker');
        $record['phone'] = $record['workerData']->phone_no;
        $workerId = $record['workerData']->worker_id;
        $isPaidAllAmount = WorkerSubscription::where('worker_id', $workerId)->where('payment_status', 0)->count();
        if ($isPaidAllAmount > 0) {
            Alert::toast('Please Pay the Amount', 'warning');
            return redirect()->route('my-subscription');
        }
        $payment_subscription = WorkerSubscription::where('worker_id', $workerId)->latest()->first();
        if (!isEmpty($payment_subscription)) {
            if ($payment_subscription->payment_status == 0) {
                return redirect()->route('my-subscription');
            }
        }
        $vaultData = $this->getVaultDataService->getVaultData($workerId, "F");

        $record['getVaultData'] = json_decode($vaultData->getData(), true);
        $record['subscription'] = WorkerSubscription::where('worker_id', $workerId)->latest()->first();
        $data = MainWorkerForm::where('worker_id', $workerId)->first();
        $record['subscription_paid_upto'] = Carbon::parse($data->subscription_validity_date)->startOfDay();
        $record['today'] = Carbon::today()->startOfDay();
        $record['renewal_date'] = Carbon::parse($data->renewal_date)->startOfDay();
        $record['diffInUpToRenew'] = $record['renewal_date']->diffInMonths($record['today']);
        $record['advancedPaymentDate'] = null;
        $record['arithmeticSum'] = 0;
        $record['constantSum'] = 0;
        $record['totalSum'] = 0;
        $subscription = WorkerSubscription::where('worker_id', $workerId)->get();
        $record['remaining_months_to_pay'] = 24;
        $advanceMonth = 0;
        $subscription_paid_upto = Carbon::parse($data->subscription_validity_date);


        if ($data->already_registered == 1) {

            if ($subscription->count() == 0) {

                $subscription_date = $subscription_paid_upto->format('d');

                $onboardingDate = Carbon::parse($data->id_card_created_at)->startOfDay();

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
                    ->subDay() // Subtract one day from the onboarding date
                    ->startOfDay()
                    ->addMonths($no_of_month);
                // ->day($subscription_date);

                //    dd($advancedPaymentDate);


                $subscription_day_upto = Carbon::parse($data->subscription_validity_date)->format('d');

                $todaysdate = $record['today']->format('d');

                //first Scenario
                $current_year = $record['today']->format('Y');

                if ($subscription_day_upto < $todaysdate) {


                    $paymentMonth = $record['today']->format('m');
                    //                    dd($paymentMonth);
                    $pendingPaymentDate = Carbon::parse($subscription_paid_upto)->year($current_year)->month($paymentMonth);
                    //                    dd($pendingPaymentDate);
                } else {

                    $paymentMonth = $record['today']->format('m') - 1;

                    $pendingPaymentDate = Carbon::parse($subscription_paid_upto)->month($paymentMonth);
                }
                //                dd($pendingPaymentDate);

                if ($pendingPaymentDate > $advancedPaymentDate) {

                    $intial_payment_date = $pendingPaymentDate;
                } else {

                    $intial_payment_date = $advancedPaymentDate;
                    //    dd($intial_payment_date);
                }

                $final_payment_date = $intial_payment_date;
                $id_expiry_date = Carbon::parse($data->id_card_expiry_date);
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

                $no_of_months = $subscription_paid_upto->diffInMonths($final_payment_date, false);
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
                if ($subscription_paid_upto->isAfter($advancedPaymentDate) || $subscription_paid_upto == $advancedPaymentDate) {
                    $no_of_months = 0;
                    $record['flag'] = true;
                }

                if ($subscription_paid_upto->isAfter($Ndate) || $subscription_paid_upto == $Ndate) {

                    $record['no_of_penalty_months'] = 0;
                } else {
                    $record['no_of_penalty_months'] = $subscription_paid_upto->diffInMonths($Ndate);
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
                //                dd($record['remaining_months_to_pay']);
                //                dd($record['no_of_months']);
            } elseif ($subscription->count() > 0) {


                $latestSubscription = WorkerSubscription::Where('worker_id', $workerId)->orderBy('created_at', 'desc')->latest()->first();

                $record['start_date'] = $startDate = Carbon::parse($latestSubscription->to_period)->format('Y-m-d');

                $record['from_period'] = Carbon::parse($data->subscription_validity_date)->addDay();

                $record['card_expiry_date'] = $endDate = Carbon::parse($data->id_card_expiry_date);

                $total_months = $record['from_period']->diffInMonths($record['card_expiry_date']);

                //              $months_paid = $subscription->skip(1)->sum('month_paid');
                $months_paid = $subscription->sum('month_paid');

                if ($subscription_paid_upto != $record['card_expiry_date']) {

                    $record['remaining_months_to_pay'] = $total_months + 1;
                } else {
                    $record['remaining_months_to_pay'] = $total_months;
                }
                //              $record['remaining_months_to_pay'] = $total_months - $months_paid;

                //                 dd($record['remaining_months_to_pay']);

                //first scenario

                $subscription_day_upto = Carbon::parse($data->subscription_validity_date)->format('d');

                $todaysdate = $record['today']->format('d');
            }
        } elseif ($data->already_registered != 1) {


            if ($subscription->count() > 0) {

                //already subscribed worker
                $latestSubscription = WorkerSubscription::Where('worker_id', $workerId)->orderBy('created_at', 'desc')->first();

                $record['start_date'] = $startDate = Carbon::parse($latestSubscription->to_period)->addDay()->format('Y-m-d');

                $total_subscription_months = 24;

                $months_paid = $subscription->sum('month_paid');


                $record['remaining_months_to_pay'] = $total_subscription_months - $months_paid;
            } else {
                //fresh subscription
                //                $record['remaining_months_to_pay'] =  0;
                $record['start_date'] = Carbon::parse($data->id_card_created_at);

                $record['advancedPaymentDate'] = $record['start_date']->copy()->addMonthsNoOverflow(3);

                $months_in_adv_payment_period = $record['start_date']->diffInMonths($record['advancedPaymentDate']);
                $record['remaining_months_to_pay'] = 21;
                $months_since_issue = $record['start_date']->diffInMonths(Carbon::now());


                if ($record['advancedPaymentDate']->isBefore($record['today'])) {
                    $differeneFromAdvPay = $record['advancedPaymentDate']->diffInDays($record['today']);
                }
                $record['start_date'] = Carbon::parse($data->id_card_created_at)->format('Y-m-d');
            }
        }

        $lasSubscription = WorkerSubscription::where('worker_id', $workerId)->latest()->first();
        $record['status'] = DB::table('Worker.worker_application_statuses as was')
            ->join('Masterdata.roles as role', 'was.sender_role_id', '=', 'role.id')
            ->where('worker_id', $record['workerData']->worker_id)
            ->select('was.*', 'role.*', DB::raw("TO_CHAR(was.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at"))
            ->get();
        $record['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $record['renewal_date'] = Carbon::parse($record['wmf']->renewal_date);
        $record['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $record['workerData']->worker_id)->first();
        $record['current_date'] = now();
        $total_amount = WorkerSubscription::where('worker_id', $workerId)->where('payment_status', 0)->latest()->first();
        // Payment

        if ($total_amount != null) {
            $record['amount'] = $total_amount->total_amount;
        } else {
            $record['amount'] = 0;
        }


        $paymentStartCount = WorkerPaymentSuccess::where('worker_id', $workerId)->where('payment_type', 2)->where('STATUS', 'O')->count();

        $paymentInitiatedCount = WorkerPaymentSuccess::where('worker_id', $workerId)->where('payment_type', 2)->where('STATUS', 'F')->count();

        $paymentPendingDataCount = WorkerPaymentSuccess::where('worker_id', $workerId)->where('payment_type', 2)->where('STATUS', 'P')->count();

        if ($paymentStartCount == 1) {

            $record['department_id'] = WorkerPaymentSuccess::where('worker_id', $workerId)
                ->where('payment_type', 2)
                ->where('STATUS', 'O')
                ->latest()
                ->first();
            $record['payment_type'] = "Pay Now";
            $record['time'] = false;
        } elseif ($paymentInitiatedCount == 1) {

            $record['payment_type'] = "Retry Payment";
            $record['time'] = true;
            $paymentStatus = WorkerPaymentSuccess::where('worker_id', $workerId)->where('payment_type', 2)->where('STATUS', 'F')->first();
            $targetTime = Carbon::parse($paymentStatus->updated_at)->addMinutes(1);
            $remainingTimeInSeconds = Carbon::now()->diffInSeconds($targetTime, false); // Calculate remaining time in seconds
            // Convert the remaining time to minutes and seconds
            $record['minute'] = floor($remainingTimeInSeconds / 60);
            $record['seconds'] = $remainingTimeInSeconds % 60;
            $record['department_id'] = $paymentStatus;
            $record['disabled'] = true;
        } elseif ($paymentPendingDataCount == 1) {
            $record['payment_type'] = "Retry Payment";
            $record['time'] = true;
            $paymentStatus = WorkerPaymentSuccess::where('worker_id', $workerId)->where('payment_type', 2)->where('STATUS', 'P')->first();
            $targetTime = Carbon::parse($paymentStatus->updated_at)->addMinutes(15);
            $remainingTimeInSeconds = Carbon::now()->diffInSeconds($targetTime, false); // Calculate remaining time in seconds
            // Convert the remaining time to minutes and seconds
            $record['minute'] = floor($remainingTimeInSeconds / 60);
            $record['seconds'] = $remainingTimeInSeconds % 60;
            $record['department_id'] = $paymentStatus;
            $record['disabled'] = false;
        } else {
            WorkerPaymentSuccess::create([
                'worker_id' => $workerId,
                'payment_type' => 2,
                'DEPARTMENT_ID' => "ABOCWWB" . date('YmdHis') . rand(1000, 9999),
                'STATUS' => 'O'
            ]);
            $record['department_id'] = WorkerPaymentSuccess::where('worker_id', $workerId)
                ->where('payment_type', 2)
                ->latest()
                ->first();
            $record['payment_type'] = "Pay Now";
            $record['time'] = false;
        }
        $record['payment_type_code'] = '03';

        $office_id = MainWorkerForm::where('worker_id', $workerId)->first()->office_id;
        $record['egrass_office_code'] = Office::where('office_id', $office_id)->first()->egrass_office_code;
        // return $record;
        return view('worker.worker-subscription', $record);
    }

    public function createPayment()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }

        $payment_status = 1;
        $record['worker'] = session()->get('worker');
        $workerId = $record['worker']->worker_id;
        $workerSubscription = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $applicationNo = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $workerId)
            ->pluck('application_no')
            ->first();
        $ackNo = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $workerId)
            ->pluck('ack_no')
            ->first();
        WorkerSubscription::where('worker_id', $workerId)->update([
            'payment_status' => $payment_status,
        ]);
        $subscription_data = WorkerSubscription::where('worker_id', $workerId)->first();

        $data = MainWorkerForm::where('worker_id', $workerId)->update([
            'active_status' => '1',
            'subscription_status' => $subscription_data->subscription_type,
            'subscription_validity_date' => $subscription_data->from_date, // Update the expiry date in MainWorkerForm
        ]);

        $data = WorkerReceipt::create([
            'worker_id' => $workerId,
            'application_no' => $applicationNo,
            'receipt_name' => "Subscription Receipt",
            'status' => "Generated"
        ]);
        $record['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $record['worker']->worker_id)->first();
        $record['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $record['id'] = DB::table('Worker.worker_id_cards')->where('worker_id', $workerId)->first();
        $expiry_date = Carbon::parse($record['wmf']->created_at);
        $record['renewal_date'] = Carbon::parse($record['wmf']->renewal_date);
        $vaultData = $this->getVaultDataService->getVaultData($workerId, "F");

        $record['getVaultData'] = json_decode($vaultData->getData(), true);
        // session()->flash('alert_shown', true);
        session()->flash('success', 'You have completed your subscription!');
        return redirect()->route('my-subscription');
    }

    public function createSubscriptionEx(Request $request)
    {
        //                     return $request->all();
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $sessionData = session()->get('worker');
        $workerId = $sessionData->worker_id;
        $update_active_status = false;

        //        return $request->all();
        $validator = validator::make(
            $request->all(),
            [
                'from_period' => 'required|date',
                'to_period' => 'required|date',
                'fine' => 'required|numeric',
                'total_amount' => 'required|numeric|gt:0',
                'subscription_type' => 'numeric',
                'penalty_months' => 'nullable|numeric',
            ],
            [
                'from_period.required' => 'Please provide the start date.',
                'from_period.date' => 'Start date must be a valid date.',
                'to_period.required' => 'Please provide the end date.',
                'to_period.date' => 'End date must be a valid date.',
                'fine.required' => 'Fine amount is required.',
                'fine.numeric' => 'Fine must be a number.',
                'total_amount.required' => 'Total amount is required.',
                'total_amount.numeric' => 'Total amount must be a number.',
                'subscription_type.numeric' => 'Subscription type must be a valid number.',
                'penalty_months.numeric' => 'Penalty months must be a valid number.',
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }
        $active_status = $request->active_status;
        $update_active_status = ($active_status == 1) ? 1 : 0;

        $from_period = Carbon::parse($request->from_period);
        $to_period = Carbon::parse($request->to_period);
        $no_of_months = $from_period->diffInMonths($to_period);

        try {
            DB::beginTransaction();
            $subscription_count = WorkerSubscription::where('worker_id', $workerId)
                ->where('payment_status', 0)
                ->count();

            if ($subscription_count == 0) {

                $sub = WorkerSubscription::Create(

                    [

                        'application_no' => $sessionData->application_no,
                        'ack_no' => $sessionData->ack_no,
                        'id_card_no' => $sessionData->id_card,
                        'office_id' => $sessionData->office_id,
                        'from_period' => $request->from_period,
                        'to_period' => $request->to_period,
                        'fine' => $request->fine,
                        'total_amount' => $request->total_amount,
                        'amount_paid' => $request->total_amount,
                        'subscription_type' => $request->subscription_type,
                        'worker_id' => $workerId,
                        'month_paid' => $request->month_paid,
                        'penalty_months' => $request->penalty_months,
                        'payment_status' => 0,
                        'no_of_delayed_months' => $request->no_of_delayed_months,

                    ]
                );
                MainWorkerForm::where('worker_id', $workerId)->update([
                    'subscription_validity_date' => Carbon::parse($sub->to_period)->format('Y-m-d'),
                    'active_status' => $update_active_status,

                ]);
                Alert::toast('Subscription Created,Pay the amount!', 'success');
            } else {
                Alert::toast('Please Pay the Amount First', 'warning');
            }
            DB::commit();

            return redirect()->route('my-subscription');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function createSubscription(Request $request)
    {

        /*** Subscription and fine calculation  **/
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }


        $sessionData = session()->get('worker');


        //        switch ($sessionData->already_registered) {
        //            case 1:
        //                if ($sessionData) {
        //
        //                    $subscriptionData = MainWorkerForm::where('worker_id', $sessionData->worker_id)->first();
        //                    $now = Carbon::now();
        //                    $card_validity_date = Carbon::parse($subscriptionData->card_validity_date);
        //
        //
        //                    if ($now->greaterThan($card_validity_date)) {
        //                        $cardStatus = [
        //                            'message' => "Inactive",
        //                            'date' => $card_validity_date->format('d-m-Y'),
        //                            'color' => 'red'
        //                        ];
        //                    } elseif ($card_validity_date->equalTo($now)) {
        //                        $cardStatus = [
        //                            'message' => "Active",
        //                            'date' => $card_validity_date->format('d-m-Y'),
        //                            'color' => 'green'
        //                        ];
        //                    } else {
        //                        $cardStatus = [
        //                            'message' => "Active",
        //                            'date' => $card_validity_date->format('d-m-Y'),
        //                            'color' => 'green'
        //                        ];
        //                    }
        //
        //                    $subscription_paid_till = Carbon::parse($subscriptionData->subscription_validity_date);
        //
        //                    $card_issue_date = Carbon::parse($subscriptionData->last_registration_date);
        //                    $cardIssueDate = $card_issue_date->format('d-m-Y');
        //                    $subscriptionPaidFor = ($card_issue_date && $subscription_paid_till)
        //                        ? $card_issue_date->diffInDays($subscription_paid_till)
        //                        : null;
        //                    $totalPaidInMonths = floor($subscriptionPaidFor / 30);
        //
        //                    $paidDays = $subscriptionPaidFor % 30;
        //
        //                    $subscriptionLapse = $subscription_paid_till->diffInDays($card_validity_date);
        //                    $monthsDifference = floor($subscriptionLapse / 30);
        //                    $remainingDays = $subscriptionLapse % 30;
        //                    $totalMonths = $monthsDifference;
        //                    if ($remainingDays > 0 && $monthsDifference == 11) {
        //                        $totalMonths++;
        //                    }
        //                    if ($totalMonths > 12) {
        //                        $totalMonths = 12;
        //                    }
        //
        //                    $status = '';
        //                    if ($totalPaidInMonths == 24) {
        //                        $status = 'Active';
        //                    } elseif ($totalMonths >= 3 && $totalMonths < 12) {
        //                        $status = 'Lapsed and suspended';
        //                    } elseif ($totalMonths < 3) {
        //                        $status = 'Lapsed';
        //                    } elseif ($totalMonths == 12) {
        //                        $status = 'Lapsed and ceased';
        //                    }
        //
        //
        //                }
        //
        //                break;
        //        }
        $workerId = $sessionData->worker_id;
        $subscriptionType = $request->subscription_type;
        $subscriptionFee = Amount::where('amount_description', 'Subscription Amount')->first()->amount;
        $workerData = MainWorkerForm::where('worker_id', $workerId)->first();
        $alreadyRegWorkerSub = MainWorkerForm::where('worker_id', $workerId)->first()->subscription_validity_date;


        if ($workerData->already_registered != 1) {
            $validator = Validator::make($request->all(), [
                'from_period' => 'required|date',
                'to_period' => 'required|date|after_or_equal:from_period',
                'amount' => 'required|numeric|min:0',
                'amount_paid' => 'required|numeric|min:0',
                'subscription_type' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }
            $payment_status_count = WorkerSubscription::where('worker_id', $workerId)->where('payment_status', 0)->count();
            if ($payment_status_count == 0) {
                $data = WorkerSubscription::Create(
                    // [
                    //     'worker_id' => $workerId,
                    //     'payment_status' => 0
                    // ],
                    [
                        'from_period' => $request->from_period,
                        'to_period' => $request->to_period,
                        'total_amount' => $request->amount,
                        'amount_paid' => $request->amount_paid,
                        'subscription_type' => $request->subscription_type,
                        'fine' => $request->fine,
                        'worker_id' => $workerId,
                        'application_no' => $workerData->application_no,
                        'ack_no' => $workerData->ack_no,
                        'id_card_no' => $workerData->id_card,
                        'office_id' => $workerData->office_id,
                        'month_paid' => $request->subscription_type,
                    ]
                );

                MainWorkerForm::where('worker_id', $workerId)->update([
                    'subscription_validity_date' => $data->to_period
                ]);
            } else {
                Alert::toast('Please Pay the Remaining Amount', 'warning');
            }

            //            $from_period = Carbon::parse($workerData->id_card_created_at);
            //            $totalSubscriptionMonths = DB::table('Worker.worker_subscriptions')
            //                ->where('worker_id', $workerId)
            //                ->sum(DB::raw("EXTRACT(YEAR FROM AGE(to_period::date, from_period::date)) * 12 + EXTRACT(MONTH FROM AGE(to_period::date, from_period::date))"));
            //
            //            $newSubscriptionMonths = $from_period->diffInMonths($data->to_period);
            //            if (($totalSubscriptionMonths + $newSubscriptionMonths) > 24) {
            //                Alert::toast('Total subscription period cannot exceed 24 months.', 'error');
            //                return back()->withErrors(['error' => 'Total subscription period cannot exceed 24 months.']);
            //            }
            //
            //            $currentDate = Carbon::now();
            //            $fine = $this->calculateFine($from_period, $currentDate, 2);


            //            try {
            //                $payment_status = WorkerPaymentSuccess::where('worker_id', $workerId)->where('STATUS', '<>', 'Y')->latest()->first();
            //                $payment_status->STATUS = "N";
            //                $payment_status->save();
            //                $worker_subscription = new WorkerSubscription();
            //                $worker_subscription->subscription_type = $subscriptionType;
            //                $worker_subscription->worker_id = $workerId;
            //                $worker_subscription->application_no = MainWorkerForm::where('worker_id', $workerId)->pluck('application_no')->first();
            //                $worker_subscription->ack_no = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->pluck('ack_no')->first();
            //                $worker_subscription->from_period = $from_period;
            //                $worker_subscription->to_period = $to_period;
            //                $worker_subscription->total_amount = $amount;
            //                $worker_subscription->fine = $fine;
            //                $worker_subscription->save();
            //
            //                MainWorkerForm::where('worker_id', $workerId)->update([
            //                    'subscription_validity_date' => $to_period
            //                ]);
            //
            //                $record['worker'] = session()->get('worker');
            //                $record['payment'] = WorkerSubscription::where('worker_id', $workerId)->latest()->first();
            //                $record['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $record['worker']->worker_id)->first();
            //                $record['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
            //                $record['id'] = DB::table('Worker.worker_id_cards')->where('worker_id', $workerId)->first();
            //                $record['renewal_date'] = Carbon::parse($record['wmf']->renewal_date);
            //                return redirect()->back();
            //            } catch (\Exception $e) {
            //
            //            }

            return redirect()->route('my-subscription');
        }
    }


    public function registrationPaymentDetails()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = session()->get('worker');

        $workerId = $record['worker']->worker_id;
        $formattedCreatedAt['date'] = Carbon::parse($record['worker']->created_at)->format('d-m-Y h:i:s A');

        $record['status'] = DB::table('Worker.worker_application_statuses as was')
            ->join('Masterdata.roles as role', 'was.sender_role_id', '=', 'role.id')
            ->where('application_id', $record['worker']->worker_id)
            ->select('was.*', 'role.*', DB::raw("TO_CHAR(was.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at"))
            ->get();

        $record['subscription'] = DB::table('Worker.worker_subscriptions')->where('worker_id', $workerId)->first();
        if ($record['subscription']) {
            $date = $record['subscription']->created_at;
            $record['dated'] = Carbon::parse($date)->format('d-m-Y h:i:s A');
        } else {
            $record['dated'] = Null; // or any default value you want to set
        }
        $record['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $record['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();

        $expiry_date = Carbon::parse($record['wmf']->created_at);
        $record['renewal_date'] = Carbon::parse($record['wmf']->renewal_date);
        $renewal_date = Carbon::parse($record['wmf']->renewal_date);
        $daysUntilRenewal = $renewal_date->diffInDays($expiry_date);
        // Check if renewal date has exceeded the expiry date
        if ($renewal_date->gt($expiry_date)) {
            $no_of_penalty_month = (int)($daysUntilRenewal / 30);
        } else {
            $no_of_penalty_month = 0;
        }

        $penalty_amount = 0;
        $subscription_amount = 20 * $no_of_penalty_month;

        for ($i = 0; $i < $no_of_penalty_month; $i++) {
            $penalty_amount += 2 * ($i + 1);
        }
        $record['penalty_amount'] = $penalty_amount;
        $record['subscription_amount'] = $subscription_amount;

        // update payment status
        $pay_success = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $workerId)
            ->update([
                'payment_status' => 'successfull',
            ]);

        $record['current_date'] = now();
        return view('worker.payment-page', $record);
    }

    public function paymentSuccessful($department_id)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = session()->get('worker');
        $workerId = $record['worker']->worker_id;
        $record['subscription'] = DB::table('Worker.worker_subscriptions')->where('worker_id', $workerId)->first();
        $record['department_id'] = WorkerPaymentSuccess::where('DEPARTMENT_ID', $department_id)->first();
        $record['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $vaultData = $this->getVaultDataService->getVaultData($workerId, "F");
        $record['getVaultData'] = json_decode($vaultData->getData(), true);
        $record['renewal_date'] = Carbon::parse($record['wmf']->renewal_date);
        $record['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        $record['office_name'] = Office::where('office_id', $record['wmf']->office_id)->first()->office_name;
        $record['current_date'] = now();
        $record['paymentDetails'] = WorkerPaymentSuccess::where('DEPARTMENT_ID', $department_id)
            ->where('payment_type', 2)
            ->where('STATUS', "Y")
            ->latest()
            ->first();
        $record['egrass_office_code'] = Office::where('office_id', $record['wmf']->office_id)->first()->egrass_office_code;
        $pfcData = PfcKioskDetail::where('service_id', 3)->where('worker_id', $record['wmf']->id_card)->where('isLoginWithPfc', true);
        // return $pfcData->first();
        if ($pfcData->count() > 0) {
            $rtps_trans_id = $pfcData->first()->rtps_trans_id;

            // session()->put('pfcData', $rtps_trans_id);
            $pfcData = PfcKioskDetail::where('rtps_trans_id', $rtps_trans_id)->first();
            $record['pfcData'] = $pfcData;
            // MainWorkerForm::where('worker_id', $workerId)->update([
            //     'rtps_trans_id' => $rtps_trans_id
            // ]);
            $encryption_key = "1234567890123456";
            if ($record['getVaultData']['gender'] == "M") {
                $gender_data = "male";
            } elseif ($record['getVaultData']['gender'] == "F") {
                $gender_data = "female";
            } else {
                $gender_data = "others";
            }
            $userDetails = array();
            array_push(
                $userDetails,
                array(
                    "gender" => $gender_data,
                    "applicant_name" => $record['getVaultData']['name'],
                    "fathers_name" => $record['getVaultData']['careOf'],
                    "mobile_number" => $pfcData->mobile,
                    "address_line_1" => $record['getVaultData']['street'] ? $record['getVaultData']['street'] : "NA",
                    "address_line_2" => $record['getVaultData']['locality'] ? $record['getVaultData']['locality'] : "NA",
                    "state" => $record['getVaultData']['state'],
                    "district" => $record['worker']->districtName->district_name,
                    "pin_code" => $record['getVaultData']['pinCode']
                )
            );
            $application_details = array(
                "slno" => $department_id . rand(0000, 9999),
            );
            // $payment = WorkerPaymentSuccess::where('worker_id', $session_worker_id)
            //     ->where('payment_type', 2)
            //     ->where('STATUS', "Y")
            //     ->latest('created_at') // Replace 'created_at' with your timestamp field if different
            //     ->first();

            $output = array(
                "rtps_trans_id" => $pfcData->rtps_trans_id,
                "user_id" => $pfcData->mobile,
                "service_id" => $pfcData->service_id,
                "app_ref_no" => $department_id,
                "status" => "S",
                "submission_date" => Carbon::now()->format('Y-m-d H:i:s'),
                "payment_mode" => "online",
                "payment_ref_no" => $record['paymentDetails']->PRN,
                "payment_date" => $record['paymentDetails']->TRANSCOMPLETIONDATETIME,
                "amount" => $record['paymentDetails']->AMOUNT,
                "application_details" => $application_details,
                "applicant_details" => $userDetails,
                "portal_no" => $pfcData->portal_no,
                "submission_location" => $record['office_name'],
                "district" => $record['worker']->districtName->district_name,
                "circle" => $record['getVaultData']['subDistrict'] ? $record['getVaultData']['subDistrict'] : ""
            );


            $output = json_encode(array("response_data" => $output));


            $aes = new AES($output, $encryption_key);
            $record['encrypted_data'] = $aes->encrypt();
            $record['url'] = $pfcData->response_url;
        }
        return view('worker.subscription-payment-receipt', $record);
    }

    public function mySubscription(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }

        $record['pfcData'] = session()->get('pfcData'); // RTPS login data
        $record['workerData'] = session()->get('worker');
        $record['phone'] = $record['workerData']->phone_no;
        $record['workerId'] = $record['workerData']->worker_id;
        //        $pfc = PfcKioskDetail::where('worker_id', $workerId)->where('isLoginWithPfc', true)->where('service_id', '2')->first();
        //        if (!isEmpty($pfc)) {
        //        }

        $vaultData = $this->getVaultDataService->getVaultData($record['workerId'], "F");
        $record['getVaultData'] = json_decode($vaultData->getData(), true);
        $record['subscription'] = DB::table('Worker.worker_subscriptions')->where('worker_id', $record['workerId'])->get();

        foreach ($record['subscription'] as $subscription) {
            $date = $subscription->created_at;
            $subscription->formatted_date = Carbon::parse($date)->format('d-m-Y h:i:s A');
        }

        // dd($record['subscriptions']);
        $record['wmf'] = MainWorkerForm::where('worker_id', $record['workerId'])->first();
        $record['renewal_date'] = Carbon::parse($record['wmf']->renewal_date);
        $record['wrkr'] = MainWorkerBasicDetail::where('worker_id', $record['workerId'])->first();
        $record['current_date'] = now();
        $record['status'] = DB::table('Worker.worker_application_statuses as was')
            ->join('Masterdata.roles as role', 'was.sender_role_id', '=', 'role.id')
            ->where('worker_id', $record['workerData']->worker_id)
            ->select('was.*', 'role.*', DB::raw("TO_CHAR(was.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at"))
            ->get();
        $total_amount = WorkerSubscription::where('worker_id', $record['workerId'])->where('payment_status', 0)->latest()->first();
        // Payment
        //         return $total_amount;

        if ($total_amount != null) {
            $record['amount'] = $total_amount->total_amount;
        } else {
            $record['amount'] = 0;
        }
        if ($record['pfcData']) {
            $record['time'] = '';
            $record['payment_type'] = '';
        } else {
            $paymentStartCount = WorkerPaymentSuccess::where('worker_id', $record['workerId'])->where('payment_type', 2)->where('STATUS', 'O')->count();

            $paymentInitiatedCount = WorkerPaymentSuccess::where('worker_id', $record['workerId'])->where('payment_type', 2)->where('STATUS', 'F')->count();

            $paymentPendingDataCount = WorkerPaymentSuccess::where('worker_id', $record['workerId'])->where('payment_type', 2)->where('STATUS', 'P')->count();

            if ($paymentStartCount == 1) {

                $record['department_id'] = WorkerPaymentSuccess::where('worker_id', $record['workerId'])
                    ->where('payment_type', 2)
                    ->where('STATUS', 'O')
                    ->latest()
                    ->first();
                $record['payment_type'] = "Pay Now";
                $record['time'] = false;
                $record['disabled'] = false;
            } elseif ($paymentInitiatedCount == 1) {

                $record['payment_type'] = "Retry Payment";
                $record['time'] = true;
                $paymentStatus = WorkerPaymentSuccess::where('worker_id', $record['workerId'])->where('payment_type', 2)->where('STATUS', 'F')->latest()->first();
                $targetTime = Carbon::parse($paymentStatus->updated_at)->addMinutes(15);
                $remainingTimeInSeconds = Carbon::now()->diffInSeconds($targetTime, false); // Calculate remaining time in seconds
                // Convert the remaining time to minutes and seconds
                $record['minute'] = floor($remainingTimeInSeconds / 60);
                $record['seconds'] = $remainingTimeInSeconds % 60;
                $record['department_id'] = $paymentStatus;
                $record['disabled'] = true;
            } elseif ($paymentPendingDataCount == 1) {
                $record['payment_type'] = "Retry Payment";
                $record['time'] = true;
                $paymentStatus = WorkerPaymentSuccess::where('worker_id', $record['workerId'])->where('payment_type', 2)->where('STATUS', 'P')->latest()->first();
                $targetTime = Carbon::parse($paymentStatus->updated_at)->addMinutes(15);
                $remainingTimeInSeconds = Carbon::now()->diffInSeconds($targetTime, false); // Calculate remaining time in seconds
                // Convert the remaining time to minutes and seconds
                $record['minute'] = 0;
                $record['seconds'] = $remainingTimeInSeconds;
                $record['department_id'] = $paymentStatus;
                $record['disabled'] = false;
            } else {
                WorkerPaymentSuccess::create([
                    'worker_id' => $record['workerId'],
                    'payment_type' => 2,
                    'DEPARTMENT_ID' => "ABOCWWB" . date('YmdHis') . rand(1000, 9999),
                    'STATUS' => 'O'
                ]);
                $record['department_id'] = WorkerPaymentSuccess::where('worker_id', $record['workerId'])
                    ->where('payment_type', 2)
                    ->latest()
                    ->first();
                $record['payment_type'] = "Pay Now";
                $record['time'] = false;
                $record['disabled'] = false;
            }
            $record['payment_type_code'] = '03';

            $office_id = MainWorkerForm::where('worker_id', $record['workerId'])->first()->office_id;
            $record['egrass_office_code'] = Office::where('office_id', $office_id)->first()->egrass_office_code;
        }


        // return $record;
        return view('worker.my-subscription', $record);
    }


    public function calculateDayCycleStartDate($subscription_validity_date, $id_card_created_at)
    {
        //            $day_last_registration_date = Carbon::parse($last_registration_date)->format('d');
        $day_subscription_validity_date = Carbon::parse($subscription_validity_date)->format('d');
        $day_id_card_created_at = Carbon::parse($id_card_created_at)->format('d');
        if ($day_id_card_created_at <= $day_subscription_validity_date) {
            $advance_period_start_day = Carbon::parse($subscription_validity_date)->addDay()->format('d');
            $advance_period_start_month = Carbon::parse($id_card_created_at)->format('m-Y');
            $advance_period_start_date = Carbon::createFromFormat('d-m-Y', $advance_period_start_day . '-' . $advance_period_start_month)->format('d-m-Y');
        } else {
            $advance_period_start_day = Carbon::parse($subscription_validity_date)->addDay()->format('d');
            $advance_period_start_month = Carbon::parse($id_card_created_at)->addMonths(1)->format('m-Y');
            $advance_period_start_date = Carbon::createFromFormat('d-m-Y', $advance_period_start_day . '-' . $advance_period_start_month)->format('d-m-Y');
        }
        return $advance_period_start_date;
    }


    public function calculateDayCycleEndDate($subscription_validity_date, $id_card_created_at)
    {
        //            $day_last_registration_date = Carbon::parse($last_registration_date)->format('d');
        $day_subscription_validity_date = Carbon::parse($subscription_validity_date)->format('d');
        $day_id_card_created_at = Carbon::parse($id_card_created_at)->format('d');
        if ($day_id_card_created_at <= $day_subscription_validity_date) {
            $advance_period_end_day = Carbon::parse($subscription_validity_date)->format('d');
            $advance_period_end_month = Carbon::parse($id_card_created_at)->addMonths(3)->format('m-Y');
            $advance_period_end_date = Carbon::createFromFormat('d-m-Y', $advance_period_end_day . '-' . $advance_period_end_month)->format('d-m-Y');
        } else {
            $advance_period_end_day = Carbon::parse($subscription_validity_date)->addDay()->format('d');
            $advance_period_end_month = Carbon::parse($id_card_created_at)->addMonths(4)->format('m-Y');
            $advance_period_end_date = Carbon::createFromFormat('d-m-Y', $advance_period_end_day . '-' . $advance_period_end_month)->format('d-m-Y');
        }
        return $advance_period_end_date;
    }

    public function calculatePenaltySubscription($subscription_validity_date, $id_card_expiry_date)
    {

        if ($subscription_validity_date < $id_card_expiry_date) {
            $monthDiff = Carbon::parse($subscription_validity_date)->diffInMonths($id_card_expiry_date);

            return $monthDiff;
        } else {
            $monthDiff = 0;
            return $monthDiff;
        }
    }

    public function delayedMonths($subscription_validity_date, $today)
    {
        $monthDelayed = Carbon::parse($subscription_validity_date)->diffInMonths($today);
        return $monthDelayed;
    }

    public function calculatePenalty($delayed_month, $no_of_month)
    {

        if ($delayed_month > 0 && $no_of_month == 0) {

            $penalty_amount = 0;
            for ($i = 0; $i < $delayed_month; $i++) {
                $penalty_amount += 2 * ($i + 1);
            }
            return $penalty_amount;
        }

        $first_term = $delayed_month;
        $last_term = $delayed_month - $no_of_month + 1;

        $sum = ($no_of_month * ($first_term + $last_term)) / 2;

        return 0 * $sum;
    }




    public function ShowSubscriptionNew(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }

        $record['isRenewal'] = 'true';
        $workerData = session()->get('worker');
        $workerId = $workerData;
        $record['wmf'] = MainWorkerForm::where('worker_id', $workerData->worker_id)->first();


        $today = now();
        $isRenewal = false;
        $isRenewalApproved = false;
        $expiryDate = Carbon::parse($record['wmf']->id_card_expiry_date);
        $record['renewal_date'] = $expiryDate->copy()->addDay();
        $renewal_date = $record['renewal_date'];
        $current_date = Carbon::now();
        $validity_date = $record['wmf']->id_card_expiry_date;
        $subscription_validity = $record['wmf']->subscription_validity_date;
        $retirement_dates = $record['wmf']->date_of_retirement;


        //        $vaultData = $this->getVaultDataService->getVaultData($workerId->worker_id, "F");
        //        $record['getVaultData'] = json_decode($vaultData->getData(), true);
        try {
            $vaultData = $this->getVaultDataService->getVaultData($workerId->worker_id, "F");

            $record['getVaultData'] = json_decode($vaultData->getData(), true);
        } catch (Exception $e) {
            // return $e;
            Alert::toast('Failed to load application, ADV Server is busy. Please try again later.', 'error');
            return back();
        }

        if ($renewal_date <= $current_date) {
            $isRenewal = true;
        }

        if (RenewWorkerForm::where('worker_id', $workerData->worker_id)->exists()) {
            $renewal_data = RenewWorkerForm::where('worker_id', $workerData->worker_id)->latest()->first();
            if ($renewal_data->status = 'F') {

                $isRenewalApproved = true;
            }
        }

        if ($isRenewalApproved) {
            $payment_status = WorkerSubscription::where('worker_id', $workerData->worker_id)->where('payment_status', 0)
                ->count();
            if ($payment_status > 0) {
                Alert::toast('Please clear the pending transaction!', 'error');
                return back();
            }


            //            $validity_date = $record['wmf']->id_card_expiry_date;
            //            $subscription_validity = $record['wmf']->subscription_validity_date;
            //            $retirement_dates = $record['wmf']->date_of_retirement;


            if ($validity_date == $subscription_validity) {
                $vaultData = $this->getVaultDataService->getVaultData($workerId->worker_id, "F");

                $record['getVaultData'] = json_decode($vaultData->getData(), true);
                return view('worker.subscription-upto-date', $record);
            }
            //need to work on this part
            //            if ($validity_date == $retirement_dates)
            //            {
            //                $vaultData = $this->getVaultDataService->getVaultData($workerId->worker_id, "F");
            //
            //                $record['getVaultData'] = json_decode($vaultData->getData(), true);
            //                return view('worker.subscription-upto-date',$record);
            //            }

            $id_card_created_at = $record['wmf']->id_card_created_at;
            $subscription_validity_date = Carbon::parse($record['wmf']->subscription_validity_date)->format('Y-m-d');
            $record['subscription_validity_date'] = Carbon::parse($subscription_validity_date)->format('d-m-Y');
            $id_card_expiry_date = $record['wmf']->id_card_expiry_date;
//            $date_cycle_start = $this->calculateDayCycleStartDate($subscription_validity_date, $id_card_created_at);

//            $date_cycle_end = $this->calculateDayCycleEndDate($subscription_validity_date, $id_card_created_at);

            $pending_subscription = $this->calculatePenaltySubscription($subscription_validity_date, $id_card_expiry_date);

            $expiry_day = Carbon::parse($id_card_expiry_date)->format('d');

            $record['is_retired'] = false;
            $cvd = Carbon::parse($id_card_expiry_date);

            $svd = Carbon::parse($record['wmf']->subscription_validity_date);
            $totalMonthsDiff = $svd->diffInMonths($cvd);
            $retirement_date = Carbon::parse($record['wmf']->date_of_retirement);
            if ($retirement_date > $today) {

                $record['penalty_to'] = Carbon::parse($today)
                    ->day($expiry_day)
                    ->format('d-m-Y');
                $record['is_retired'] = false;
            } else {

                $record['penalty_to'] = Carbon::parse($retirement_date)
                    ->day($expiry_day)
                    ->format('d-m-Y');
                $record['is_retired'] = true;
            }
            //            return $record['penalty_to'];

            $record['penalty_from'] = Carbon::parse($subscription_validity_date)->addDay()->format('d-m-Y');
            $record['remaining_months'] = $totalMonthsDiff;
            $record['no_of_month'] = $pending_subscription;


            if (
                Carbon::parse($subscription_validity_date)->equalTo(Carbon::parse($id_card_expiry_date)) ||
                Carbon::parse($subscription_validity_date)->gte(Carbon::today())
            ) {
                $record['delayed_month'] = 0;
            } else {
                if (Carbon::parse($retirement_date)->lt(Carbon::parse($today))) {

                    $record['delayed_month'] = $this->delayedMonths($subscription_validity_date, $record['penalty_to']);
                    //                    return $record['delayed_month'];

                } else {
                    $record['delayed_month'] = $this->delayedMonths($subscription_validity_date, $today);
                }
            }
            if ($record['remaining_months'] > $record['delayed_month'] + 3) {
                $record['adv'] = true;
            } else {
                $record['adv'] = false;
            }

            $subscription_amount = Amount::where('id', 2)->first()->amount;
            $record['penalty_amount'] = $this->calculatePenalty($record['delayed_month'], $record['no_of_month']);
            //            $record['penalty_amount'] = 0;
            $record['total_amount'] =  $record['penalty_amount'] + ($record['no_of_month'] * $subscription_amount);
            $record['subscription_amount'] = $record['no_of_month'] * $subscription_amount;
            $record['card_validity_date'] = Carbon::parse($record['wmf']->id_card_expiry_date)->format('d-m-Y');

            $lastRenewalDateOn = Carbon::parse($record['wmf']->id_card_expiry_date)
                ->subYears(2)
                ->addDay()
                ->toDateString();
            $record['last_renewal_date'] = $lastRenewalDateOn ?? $record['details']->id_card_created_at;

            if (!empty($record['wmf']->subscription_validity_date)) {
                $record['last_subscription_date'] = $record['wmf']->subscription_validity_date;
            } else {
                $record['last_subscription_date'] = $record['wmf']->id_card_created_at;
            }

            $record['active_status'] = '1';


            return view('worker.worker-after-renewal-susbscription', $record);
        } elseif ($isRenewal) {

            //Pre renewal Scenario

            if ($subscription_validity > $validity_date) {
                $vaultData = $this->getVaultDataService->getVaultData($workerId->worker_id, "F");

                $record['getVaultData'] = json_decode($vaultData->getData(), true);
                return view('worker.subscription-upto-date', $record);
            }
            $id_card_created_at = $record['wmf']->id_card_created_at;
            $subscription_validity_date = Carbon::parse($record['wmf']->subscription_validity_date)->format('Y-m-d');
            $record['subscription_validity_date'] = Carbon::parse($subscription_validity_date)->format('d-m-Y');
            $id_card_expiry_date = $record['wmf']->id_card_expiry_date;
            $date_cycle_start = $this->calculateDayCycleStartDate($subscription_validity_date, $id_card_created_at);

            $date_cycle_end = $this->calculateDayCycleEndDate($subscription_validity_date, $id_card_created_at);

            $pending_subscription = $this->calculatePenaltySubscription($subscription_validity_date, $id_card_expiry_date);

            $expiry_day = Carbon::parse($id_card_expiry_date)->format('d');
            $retirement_date = Carbon::parse($record['wmf']->date_of_retirement);
            if ($retirement_date > $today) {

                $record['penalty_to'] = Carbon::parse($today)
                    ->day($expiry_day)
                    ->format('d-m-Y');
            } else {

                $record['penalty_to'] = Carbon::parse($today)
                    ->day($expiry_day)
                    ->format('d-m-Y');
            }

            $record['penalty_from'] = Carbon::parse($subscription_validity_date)->addDay()->format('d-m-Y');
            $record['no_of_month'] = $pending_subscription;


            if (Carbon::parse($subscription_validity_date)->eq(Carbon::parse($id_card_expiry_date))) {
                $record['delayed_month'] = 0;
            } else {
                if (Carbon::parse($retirement_date)->lt(Carbon::parse($today))) {
                    $record['delayed_month'] = $this->delayedMonths($subscription_validity_date, $today);
                } else {
                    $record['delayed_month'] = $this->delayedMonths($subscription_validity_date, $today);
                }
            }

            $subscription_amount = Amount::where('id', 2)->first()->amount;
            $record['penalty_amount'] = $this->calculatePenalty($record['delayed_month'], $record['no_of_month']);
            //            $record['penalty_amount'] = 0;
            $record['total_amount'] =  $record['penalty_amount'] + ($record['no_of_month'] * $subscription_amount);
            $record['subscription_amount'] = $record['no_of_month'] * $subscription_amount;
            $record['card_validity_date'] = Carbon::parse($record['wmf']->id_card_expiry_date)->format('d-m-Y');

            $lastRenewalDateOn = Carbon::parse($record['wmf']->id_card_expiry_date)
                ->subYears(2)
                ->addDay()
                ->toDateString();
            $record['last_renewal_date'] = $lastRenewalDateOn ?? $record['details']->id_card_created_at;

            if (!empty($record['wmf']->subscription_validity_date)) {
                $record['last_subscription_date'] = $record['wmf']->subscription_validity_date;
            } else {
                $record['last_subscription_date'] = $record['wmf']->id_card_created_at;
            }


            return view('worker.worker-subscription-new', $record);
        } else {

            //subscription payment

            $id_card_created_at = $record['wmf']->id_card_created_at;
            $subscriptionValidity = Carbon::parse($record['wmf']->subscription_validity_date);
            $id_card_expiry_date = Carbon::parse($record['wmf']->id_card_expiry_date);
            $retirement_dates = $record['wmf']->date_of_retirement;
            // Now it's a Carbon object, so ->day works fine
            $idCardDay = $id_card_expiry_date->day;

            $subscription_validity_date = $subscriptionValidity->copy()->day($idCardDay);

            // Format as needed
            $record['subscription_validity_date'] = $subscription_validity_date->format('d-m-Y');
            //            $id_card_expiry_date = $record['wmf']->id_card_expiry_date;
            $cvd = Carbon::parse($id_card_expiry_date);
            $svd = $subscription_validity_date;
            $totalMonthsDiff = $svd->diffInMonths($cvd);
            //            return $totalMonthsDiff;

            $date_cycle_start = $this->calculateDayCycleStartDate($subscription_validity_date, $id_card_created_at);

            $date_cycle_end = $this->calculateDayCycleEndDate($subscription_validity_date, $id_card_created_at);

            $pending_subscription = $this->calculatePenaltySubscription($subscription_validity_date, $id_card_expiry_date);

            $expiry_day = Carbon::parse($id_card_expiry_date)->format('d');
            $retirement_date = Carbon::parse($record['wmf']->date_of_retirement);
            if ($retirement_date > $today) {

                $record['penalty_to'] = Carbon::parse($today)
                    ->day($expiry_day)
                    ->format('d-m-Y');
            } else {

                $record['penalty_to'] = Carbon::parse($retirement_date)
                    ->day($expiry_day)
                    ->format('d-m-Y');
            }

            $record['penalty_from'] = Carbon::parse($subscription_validity_date)->addDay()->format('d-m-Y');
            $record['remaining_months'] = $totalMonthsDiff;
            $record['no_of_month'] = $pending_subscription;

            $subscriptionValidity = Carbon::parse($subscription_validity_date);
            $idCardExpiry = Carbon::parse($id_card_expiry_date);
            $retirement = Carbon::parse($retirement_date);
            $today = Carbon::today();

            if ($subscriptionValidity->eq($idCardExpiry)) {
                $record['delayed_month'] = 0;
            } else {
                if ($subscriptionValidity->lt($today)) {
                    $endDate = $retirement->lt($today) ? $retirement : $today;
                    $record['delayed_month'] = $this->delayedMonths($subscriptionValidity, $endDate);
                } else {
                    $record['delayed_month'] = 0;
                }
            }

            //            if (Carbon::parse($subscription_validity_date)->eq(Carbon::parse($id_card_expiry_date))) {
            //                $record['delayed_month'] = 0;
            //            } else {
            //                if (Carbon::parse($retirement_date)->lt(Carbon::parse($today))) {
            //                    $record['delayed_month'] = $this->delayedMonths($subscription_validity_date, $retirement_date);
            //                } else {
            //                    $record['delayed_month'] = $this->delayedMonths($subscription_validity_date, $today);
            //                }
            //            }
            if ($idCardExpiry == $subscriptionValidity) {
                $vaultData = $this->getVaultDataService->getVaultData($workerId->worker_id, "F");

                $record['getVaultData'] = json_decode($vaultData->getData(), true);
                return view('worker.subscription-upto-date', $record);
            }
            if ($idCardExpiry == $retirement_dates && $retirement_dates == $subscriptionValidity) {
                $vaultData = $this->getVaultDataService->getVaultData($workerId->worker_id, "F");

                $record['getVaultData'] = json_decode($vaultData->getData(), true);
                return view('worker.subscription-upto-date', $record);
            }

            $subscription_amount = Amount::where('id', 2)->first()->amount;
            //            $record['penalty_amount'] = $this->calculatePenalty($record['delayed_month'], $record['no_of_month']);
            $record['penalty_amount'] = 0;
            $record['total_amount'] =  $record['penalty_amount'] + ($record['no_of_month'] * $subscription_amount);
            $record['subscription_amount'] = $record['no_of_month'] * $subscription_amount;
            $record['card_validity_date'] = Carbon::parse($record['wmf']->id_card_expiry_date)->format('d-m-Y');

            $lastRenewalDateOn = Carbon::parse($record['wmf']->id_card_expiry_date)
                ->subYears(2)
                ->addDay()
                ->toDateString();
            $record['last_renewal_date'] = $lastRenewalDateOn ?? $record['details']->id_card_created_at;

            if (!empty($record['wmf']->subscription_validity_date)) {
                $record['last_subscription_date'] = $record['wmf']->subscription_validity_date;
            } else {
                $record['last_subscription_date'] = $record['wmf']->id_card_created_at;
            }


            return view('worker.worker-before-renewal-subscription', $record);
        }

        //after renewal approval


    }

    public function paymentTable(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }


        $workerData = session()->get('worker');
        $workerId = $workerData;
        $vaultData = $this->getVaultDataService->getVaultData($workerId, "F");
        $record['getVaultData'] = json_decode($vaultData->getData(), true);
        //        $formattedCreatedAt['date'] = Carbon::parse($record['worker']->created_at)->format('d-m-Y h:i:s A');
        $record['subscription'] = DB::table('Worker.worker_subscriptions')->where('worker_id', $workerId)->first();
        $record['status'] = DB::table('Worker.worker_application_statuses as was')
            ->join('Masterdata.roles as role', 'was.sender_role_id', '=', 'role.id')
            ->where('worker_id', $workerId)
            ->select('was.*', 'role.*', DB::raw("TO_CHAR(was.created_at, 'DD-MM-YYYY HH:MI:SS AM') as formatted_created_at"))
            ->get();
        $record['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $renewal_date = Carbon::parse($record['wmf']->renewal_date);
        //        dd($record['renewal_date']);
        $record['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        $current_date = now();
        return view('worker.payment-table', compact('workerData', 'record', 'getVaultData', 'current_date', 'renewal_date'));
    }

    public function subscriptionReceipt(Request $request, $id)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $data['worker'] = session()->get('worker');
        $session_worker_id = $data['worker']->worker_id;
        $subscription = WorkerSubscription::findOrFail($id);
        $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "F");
        $data['getVaultData'] = json_decode($vaultData->getData(), true);
        $data['worker'] = DB::table('Worker.main_worker_forms')->where('worker_id', $session_worker_id)->first();
        $data['mwf'] = DB::table('Worker.main_worker_forms as wmfm')
            ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
            ->where('worker_id', $session_worker_id)
            ->select('wmfm.*', 'ofc.*')
            ->first();
        $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
            ->where('worker_id', $session_worker_id)
            ->select('wmbd.*')
            ->first();

        $data['emblem'] = public_path('/assets/template/images/emblem-dark.png');

        //        su

        //        $data['passport'] = Storage::path($passportPath);

        $data['subscription'] = $subscription;
        $options = [
            'encoding' => 'utf-8', // Set encoding to UTF-8
            'enable-local-file-access' => true, // Enable external links
        ];
        // The Blade view you provided
        $html = view('worker.pdf.receipt.subscription-receipt', $data)->render();

        // Generate PDF from HTML content
        $pdfContent = Pdf::loadHTML($html)
            ->setOptions($options)
            ->output();

        // Set response headers to indicate PDF content
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="payment_receipt.pdf"',
        ]);
    }


    public function renewApplication(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }

        $record['worker'] = session()->get('worker');
        $session_worker_id = $record['worker']->worker_id;

        try {
            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "M");
            $record['getVaultData'] = json_decode($vaultData->getData(), true);
        } catch (\Exception $e) {
            Alert::toast('Failed to load Aadhar data, ADV Server is busy. Please try again later.', 'error');
            return back();
        }

        $record['wmf'] = MainWorkerForm::where('worker_id', $session_worker_id)->first();
        $record['subscription'] = WorkerSubscription::where('worker_id', $session_worker_id)->latest()->first();
        $formdata = WorkbookModel::where('worker_id', $session_worker_id)->first();

        $record['details'] = MainWorkerForm::where('worker_id', $session_worker_id)->first();

        if (!$record['details']) {
            return back();
        }

        /*
        |--------------------------------------------------------------------------
        | Global Date Calculations
        |--------------------------------------------------------------------------
        */

        $idCardExpiry = Carbon::parse($record['details']->id_card_expiry_date)->startOfDay();
        $subscriptionValidity = Carbon::parse($record['details']->subscription_validity_date)->startOfDay();
        $date_of_retirement = Carbon::parse($record['details']->date_of_retirement)->startOfDay();
        $lastRegDate = Carbon::parse($record['details']->last_registration_date)->startOfDay();

        if ($lastRegDate->equalTo($idCardExpiry)) {
            $lastRenewalDate = $lastRegDate->copy()->addDay();
        } elseif ($idCardExpiry->equalTo($subscriptionValidity)) {
            $lastRenewalDate = $subscriptionValidity->copy()->subYears(2)->addDay();
        } else {
            $lastRenewalDate = $idCardExpiry->copy()->subYears(2)->addDay();
        }

        $applicationDate = now();
        $effectiveApplicationDate = $applicationDate;

        if ($date_of_retirement->lt($applicationDate)) {
            $effectiveApplicationDate = $date_of_retirement->copy();
        }

        $record['application_submit_date'] = $applicationDate->toDateString();

        /*
        |--------------------------------------------------------------------------
        | Fetch Master Data
        |--------------------------------------------------------------------------
        */
        $record['worktype'] = DB::table('Masterdata.type_of_works')
            ->select('work_type_code', 'work_type_name')
            ->orderBy('work_type_name', 'asc')
            ->get();

        $record['worknature'] = DB::table('Masterdata.nature_of_works')
            ->select('nature_of_work_code', 'nature_of_work')
            ->orderBy('nature_of_work', 'asc')
            ->get();

        $record['type_of_employers'] = DB::table('Masterdata.type_of_employers')
            ->select('employer_code', 'employer_name')
            ->orderBy('employer_name', 'asc')
            ->get();

        $record['professions'] = DB::table('Masterdata.professions')
            ->select('profession_code', 'profession_name')
            ->orderBy('profession_name', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | If Workbook Exists (Edit / Reverted Flow)
        |--------------------------------------------------------------------------
        */
        if ($formdata) {

            if (WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('is_renewal', 1)->where('application_status', 'G')->exists()) {
                $record['remarks'] = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                    ->where('application_status', 'G')
                    ->where('is_renewal', 1)
                    ->first();
            }

            // if (Carbon::parse($record['details']->subscription_validity_date)->lt(Carbon::parse($record['details']->id_card_expiry_date))) {
            //     Alert::toast("Please clear your subscription dues before applying for renewal", 'warning');
            //     return redirect()->route("worker-subscription-new");
            // }

            $record['twc'] = DB::table('Worker.workers_workbook_details as twc')
                ->join('Masterdata.type_of_employers as toe', 'twc.type_of_employer', '=', 'toe.employer_code')
                ->join('Masterdata.type_of_works as tow', 'twc.type_of_work', '=', 'tow.work_type_code')
                ->join('Masterdata.professions as pro', 'twc.profession', '=', 'pro.profession_code')
                ->where('twc.worker_id', $session_worker_id)
                ->select(
                    'twc.id',
                    'twc.row_id',
                    'twc.group_id',
                    'twc.sub_row',
                    'twc.worker_id',
                    'twc.from_date',
                    'twc.to_date',
                    'twc.type_of_employer',
                    'twc.type_of_work',
                    'twc.profession',
                    'twc.profession_others',
                    'twc.date_count',
                    'twc.employer_name as emp',
                    'twc.employer_contact_number',
                    'twc.certificate_proof',
                    'twc.id as certificate_proof_id',
                    'toe.employer_name as empname',
                    'tow.work_type_name',
                    'pro.profession_name'
                )
                ->orderBy('twc.id', 'asc')
                ->orderBy('twc.group_id', 'asc')
                ->orderBy('twc.sub_row', 'asc')
                ->get();

//            $twc = collect($record['twc']);
            $twc = collect($record['twc']);

            $expiry = Carbon::parse(
                $record['details']->id_card_expiry_date
            );

            $expiryDay = $expiry->day;
            $expiryMonth = $expiry->month;

            $cycleStart = $expiry->copy()->addDay();

            $cycleStartDay = $cycleStart->day;
            $cycleStartMonth = $cycleStart->month;

            $cycleEndDay = $expiry->day;
            $cycleEndMonth = $expiry->month;

            $maxExistingGroup = (int) $twc->max('group_id');

            $baseFromDate = Carbon::parse($record['details']->id_card_expiry_date)
                ->subYears($maxExistingGroup + 1)
                ->addDay();

            $startYear = $baseFromDate->year;

            $allRanges = [];

            $parentRows = $twc
                ->where('sub_row', 0)
                ->sortBy('group_id');

            foreach ($parentRows as $parent) {

                if (!$parent->from_date) {
                    continue;
                }

                $from = Carbon::parse($parent->from_date);

                // derive end date using expiry month/day
                $to = Carbon::create(
                    $from->year + 1,
                    $expiryMonth,
                    $expiryDay
                );

                $allRanges[$parent->group_id] = [
                    'group_id' => $parent->group_id,
                    'from' => $from->format('d-m-Y'),
                    'to'   => $to->format('d-m-Y'),
                ];
            }

            $existingParentGroups = $twc
                ->where('sub_row', 0)
                ->pluck('group_id')
                ->toArray();

            foreach ($allRanges as $groupId => $range) {

                if (!in_array($groupId, $existingParentGroups)) {

                    $twc->push((object)[
                        'id' => null,
                        'worker_id' => $session_worker_id,
                        'group_id' => $groupId,
                        'sub_row' => 0,
                        'row_id' => $groupId . '.0',

                        'from_date' => null,
                        'to_date' => null,
                        'type_of_work' => null,
                        'work_type_name' => null,
                        'type_of_employer' => null,
                        'empname' => null,
                        'profession' => null,
                        'profession_name' => null,
                        'profession_others' => null,
                        'date_count' => null,
                        'emp' => null,
                        'employer_contact_number' => null,
                        'certificate_proof' => null,
                        'certificate_proof_id' => null,
                    ]);
                }
            }

            $twc = $twc
                ->sortBy([
                    ['group_id', 'asc'],
                    ['sub_row', 'asc']
                ])
                ->values();

            foreach ($twc as $workbook) {

                $workbook->row_id = $workbook->group_id . '.' . $workbook->sub_row;

                $workbook->date_range_key = $workbook->group_id;

                $workbook->current_range =
                    $allRanges[$workbook->group_id] ?? null;

                $workbook->is_parent =
                    $workbook->sub_row == 0;
            }

          $record['twc'] = $twc;
            $record['date_ranges'] = $allRanges;

    $view = 'worker.edit.edit-worker-renewal-application';
        } else {
            /*
            |--------------------------------------------------------------------------
            | New Renewal Application Flow
            |--------------------------------------------------------------------------
            */
            if (Carbon::parse($record['wmf']->subscription_validity_date)->lt(Carbon::parse($record['wmf']->id_card_expiry_date))) {
                Alert::toast("Please clear your subscription dues before applying for renewal", 'warning');
                return redirect()->route("worker-subscription-new");
            }

            if ($record['subscription'] && $record['subscription']->payment_status == 0) {
                Alert::toast("Please clear your Pending Payment first", 'warning');
                return redirect()->route("my-subscription");
            }

            if (RenewWorkerForm::where('worker_id', $session_worker_id)->exists()) {
                $renewal_data = RenewWorkerForm::where('worker_id', $session_worker_id)->latest()->first();
                if ($renewal_data->status != 'F') {
                    // isRenewal / isRenewApplied logic handled here
                }
            }

            $diffInYears = $lastRenewalDate->diffInYears($effectiveApplicationDate);
            $currentCycleStart = $lastRenewalDate->copy()->addYears(floor($diffInYears / 2) * 2);

            $currentPointer = $lastRenewalDate->copy();
            $dateRanges = [];
            $completedYears = 0;

            while (true) {
                $yearStart = $currentPointer->copy();
                $yearEnd = $currentPointer->copy()->addYear()->subDay();

                if ($yearEnd->gte($effectiveApplicationDate)) {
                    break;
                }
                if ($yearEnd->gte($currentCycleStart)) {
                    break;
                }

                $dateRanges[] = [
                    'from' => $yearStart->format('d-m-Y'),
                    'to' => $yearEnd->format('d-m-Y'),
                ];
                $completedYears++;
                $currentPointer->addYear();
            }

            $record['total_years_since_last_renewal'] = $completedYears;
            $record['date_ranges'] = $dateRanges;

            $record['twed'] = DB::table('Worker.workers_workbook_details as twed')
                ->leftjoin('Masterdata.type_of_works as tow', 'twed.type_of_work', '=', 'tow.work_type_code')
                ->leftjoin('Masterdata.type_of_employers as toe', 'twed.type_of_employer', '=', 'toe.employer_code')
                ->where('worker_id', $session_worker_id)
                ->select(
                    'twed.*',
                    'tow.*',
                    'toe.employer_code',
                    'toe.employer_name AS empname'
                )
                ->first();

            $view = 'worker.worker-renew-application';
        }

        return view($view, $record);
    }

    public function clearWorkbookData(Request $request)
    {
        try {

            WorkbookModel::where('worker_id', $request->worker_id)
                ->delete(); // Soft Delete

            return response()->json([
                'success' => true,
                'message' => 'Workbook data removed successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }



    //     public function renewApplication(Request $request)
    //     {
    //         if (session()->get('worker-session') != true) {
    //             return Redirect::to('/');
    //         }

    //         $record['worker'] = session()->get('worker');
    //         $session_worker_id = $record['worker']->worker_id;
    //         try {
    //             $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "M");
    //             $record['getVaultData'] = json_decode($vaultData->getData(), true);
    //         } catch (Exception $e) {
    //             //                    return $e;
    //             Alert::toast('Failed to load Aadhar data, ADV Server is busy. Please try again later.', 'error');
    //             return back();
    //         }
    //         $record['wmf'] = MainWorkerForm::where('worker_id', $session_worker_id)->first();
    //         $record['subscription'] = WorkerSubscription::where('worker_id', $session_worker_id)->latest()->first();
    //         $formdata = WorkbookModel::where('worker_id', $session_worker_id)->first();
    //         $lastRenewalDate = null;
    //         $isReverted = false;
    //         if ($formdata) {
    //             if (WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('is_renewal', 1)->where('application_status', 'G')->exists()) {
    //                 $record['remarks'] = WorkerApplicationStatus::where('worker_id', $session_worker_id)
    //                     ->where('application_status', 'G')
    //                     ->where('is_renewal', 1)

    //                     ->first();

    //                 $isReverted = true;
    //             }
    //             $record['details'] = MainWorkerForm::where('worker_id', $session_worker_id)->first();
    // //            $idCardExpiry = Carbon::parse($record['details']->id_card_expiry_date);
    // //            $subscriptionValidity = Carbon::parse($record['details']->subscription_validity_date);
    // //            $date_of_retirement = Carbon::parse($record['details']->date_of_retirement);
    // //            $record['existing_card_validity'] = $idCardExpiry->toDateString();
    // //            //need to check
    // //            $record['subscription_validity_date'] = $idCardExpiry->toDateString();
    // //            if ($idCardExpiry->equalTo($subscriptionValidity)){
    // //                $lastRenewalDate = $subscriptionValidity->copy()->addDay();
    // //
    // //            }else{
    // //                $lastRenewalDate = $idCardExpiry->copy()->subYears(2)->addDay();
    // //
    // //            }
    // //
    // //            $applicationDate = now();
    // //            $effectiveApplicationDate = $applicationDate;
    // //
    // //            if ($date_of_retirement->lt($applicationDate)) {
    // //                $effectiveApplicationDate = $date_of_retirement->copy();
    // //            }
    // //
    // //            $record['application_submit_date'] = $applicationDate->toDateString();
    // //
    // //// Use effective application date for diff calculation
    // //            $diffInYears = $lastRenewalDate->diffInYears($effectiveApplicationDate);
    // //
    // //            $currentCycleStart = $lastRenewalDate->copy()->addYears(floor($diffInYears / 2) * 2);
    // //            $currentCycleEnd = $currentCycleStart->copy()->addYears(2)->subDay();
    // //
    // //            $currentPointer = $lastRenewalDate->copy();
    // //            $dateRanges = [];
    // //            $completedYears = 0;
    // //
    // //            while (true) {
    // //                $yearStart = $currentPointer->copy();
    // //                $yearEnd = $currentPointer->copy()->addYear()->subDay();
    // //
    // //
    // //                if ($yearEnd->gte($effectiveApplicationDate)) {
    // //                    break;
    // //                }
    // //
    // //                if ($yearEnd->gte($currentCycleStart)) {
    // //                    break;
    // //                }
    // //
    // //                $dateRanges[] = [
    // //                    'from' => $yearStart->format('d-m-Y'),
    // //                    'to' => $yearEnd->format('d-m-Y'),
    // //                ];
    // //
    // //                $completedYears++;
    // //                $currentPointer->addYear();
    // //            }
    // //
    // //            $record['total_years_since_last_renewal'] = $completedYears;
    // //
    // //            $record['date_ranges'] = $dateRanges;
    //             $idCardExpiry = Carbon::parse($record['details']->id_card_expiry_date)->startOfDay();
    //             $subscriptionValidity = Carbon::parse($record['details']->subscription_validity_date)->startOfDay();
    //             $date_of_retirement = Carbon::parse($record['details']->date_of_retirement)->startOfDay();
    //             $lastRegDate = Carbon::parse($record['details']->last_registration_date)->startOfDay();

    //             /*
    //             |--------------------------------------------------------------------------
    //             | Determine Last Renewal Date
    //             |--------------------------------------------------------------------------
    //             */

    //             if ($lastRegDate->equalTo($idCardExpiry)) {

    //                 $lastRenewalDate = $lastRegDate->copy()->addDay();

    //             } elseif ($idCardExpiry->equalTo($subscriptionValidity)) {

    //                 $lastRenewalDate = $subscriptionValidity->copy()->subYears(2)->addDay();

    //             } else {

    //                 $lastRenewalDate = $idCardExpiry->copy()->subYears(2)->addDay();
    //             }



    //             $applicationDate = now();
    //             $effectiveApplicationDate = $applicationDate;

    //             if ($date_of_retirement->lt($applicationDate)) {
    //                 $effectiveApplicationDate = $date_of_retirement->copy();
    //             }

    //             $record['application_submit_date'] = $applicationDate->toDateString();

    //             // Use effective application date for diff calculation
    //             $diffInYears = $lastRenewalDate->diffInYears($effectiveApplicationDate);

    //             $currentCycleStart = $lastRenewalDate->copy()->addYears(floor($diffInYears / 2) * 2);
    //             $currentCycleEnd = $currentCycleStart->copy()->addYears(2)->subDay();

    //             $currentPointer = $lastRenewalDate->copy();
    //             $dateRanges = [];
    //             $completedYears = 0;

    //             while (true) {
    //                 $yearStart = $currentPointer->copy();
    //                 $yearEnd = $currentPointer->copy()->addYear()->subDay();


    //                 if ($yearEnd->gte($effectiveApplicationDate)) {
    //                     break;
    //                 }

    //                 if ($yearEnd->gte($currentCycleStart)) {
    //                     break;
    //                 }

    //                 $dateRanges[] = [
    //                     'from' => $yearStart->format('d-m-Y'),
    //                     'to' => $yearEnd->format('d-m-Y'),
    //                 ];

    //                 $completedYears++;
    //                 $currentPointer->addYear();
    //             }

    //             $record['total_years_since_last_renewal'] = $completedYears;

    //             $record['date_ranges'] = $dateRanges;


    //             $record['worktype'] = DB::table('Masterdata.type_of_works')
    //                 ->select('work_type_code', 'work_type_name')
    //                 ->get();
    //             $record['worknature'] = DB::table('Masterdata.nature_of_works')
    //                 ->select('nature_of_work_code', 'nature_of_work')
    //                 ->orderBy('nature_of_work', 'asc')
    //                 ->get();
    //             $record['type_of_employers'] = DB::table('Masterdata.type_of_employers')
    //                 ->select('employer_code', 'employer_name')
    //                 ->get();
    //             $record['professions'] = DB::table('Masterdata.professions')
    //                 ->select('profession_code', 'profession_name')
    //                 ->orderBy('profession_name', 'asc')
    //                 ->get();


    //             $record['twed'] = DB::table('Worker.workers_workbook_details as twed')
    //                 ->leftjoin('Masterdata.type_of_works as tow', 'twed.type_of_work', '=', 'tow.work_type_code')
    //                 ->leftjoin('Masterdata.type_of_employers as toe', 'twed.type_of_employer', '=', 'toe.employer_code')
    //                 ->where('worker_id', $session_worker_id)
    //                 ->select(
    //                     'twed.*',
    //                     'tow.*',
    //                     'toe.employer_code',
    //                     'toe.employer_name AS empname'
    //                 )
    //                 ->first();

    //             $record['twc'] = DB::table('Worker.workers_workbook_details as twc')
    //                 ->join('Masterdata.type_of_employers as toe', 'twc.type_of_employer', '=', 'toe.employer_code')
    //                 ->join('Masterdata.type_of_works as tow', 'twc.type_of_work', '=', 'tow.work_type_code')
    //                 ->join('Masterdata.professions as pro', 'twc.profession', '=', 'pro.profession_code')
    //                 ->where('twc.worker_id', $session_worker_id)
    //                 ->select(
    //                     'twc.id',
    //                     'twc.row_id',
    //                     'twc.worker_id',
    //                     'twc.application_no',
    //                     'twc.employer_name AS emp',
    //                     'twc.employer_contact_number',
    //                     'twc.from_date',
    //                     'twc.to_date',
    //                     'twc.type_of_employer',
    //                     'twc.profession',
    //                     'twc.profession_others',
    //                     'twc.date_count',
    //                     'twc.certificate_proof',
    //                     'twc.id as certificate_proof_id',
    //                     'toe.employer_code',
    //                     'toe.employer_name AS empname',
    //                     'twc.type_of_work',
    //                     'tow.work_type_code',
    //                     'tow.work_type_name',
    //                     'pro.*'
    //                 )
    //                 ->orderBy('id', 'asc')
    //                 ->get();

    //             foreach ($record['twc'] as $workbook) {
    //                 // Manually create the 'date_range_key' property
    //                 $workbook->date_range_key = (int) $workbook->row_id;

    //                 // Manually create the 'is_parent' property
    //                 $workbook->is_parent = str_ends_with((string) $workbook->row_id, '.0');
    //                 $workbook->current_range = $dateRanges[$workbook->date_range_key] ?? null;
    //             }


    //             return view('worker.edit.edit-worker-renewal-application', $record);
    //         } else {
    //             $isRenewal = false;
    //             $isRenewApplied = false;
    //             $lastRenewalDate = false;
    //             $validityDate = Carbon::parse($record['wmf']->subscription_validity_date);
    //             $expiryDate = Carbon::parse($record['wmf']->id_card_expiry_date);
    //             if (Carbon::parse($record['wmf']->subscription_validity_date)->lt(Carbon::parse($record['wmf']->id_card_expiry_date))) {
    //                 Alert::toast("Please clear your subscription dues before applying for renewal", 'warning');
    //                 return redirect()->route("worker-subscription-new");
    //             }


    //             if ($record['subscription'] && $record['subscription']->payment_status == 0) {
    //                 Alert::toast("Please clear your Pending Payment first", 'warning');
    //                 return redirect()->route("my-subscription");
    //             }
    //             if (RenewWorkerForm::where('worker_id', $session_worker_id)->exists()) {
    //                 $renewal_data = RenewWorkerForm::where('worker_id', $session_worker_id)->latest()->first();
    //                 if ($renewal_data->status != 'F') {
    //                     $isRenewal = false;
    //                     $isRenewApplied = true;
    //                 }
    //             }

    //             $record['details'] = MainWorkerForm::where('worker_id', $session_worker_id)->first();
    //             $nnDate =  $record['details']->id_card_expiry_date;
    //             $idCardExpiry = Carbon::parse($record['details']->id_card_expiry_date)->startOfDay();
    //             $subscriptionValidity = Carbon::parse($record['details']->subscription_validity_date)->startOfDay();
    //             $date_of_retirement = Carbon::parse($record['details']->date_of_retirement)->startOfDay();
    //             $lastRegDate = Carbon::parse($record['details']->last_registration_date)->startOfDay();

    //             /*
    //             |--------------------------------------------------------------------------
    //             | Determine Last Renewal Date
    //             |--------------------------------------------------------------------------
    //             */

    //             if ($lastRegDate->equalTo($idCardExpiry)) {

    //                 $lastRenewalDate = $lastRegDate->copy()->addDay();
    //             } elseif ($idCardExpiry->equalTo($subscriptionValidity)) {

    //                 $lastRenewalDate = $subscriptionValidity->copy()->subYears(2)->addDay();

    //             } else {

    //                 $lastRenewalDate = $idCardExpiry->copy()->subYears(2)->addDay();
    //             }



    //             $applicationDate = now();
    //          $effectiveApplicationDate = $applicationDate;

    //             if ($date_of_retirement->lt($applicationDate)) {
    //                 $effectiveApplicationDate = $date_of_retirement->copy();
    //             }

    //                 $record['application_submit_date'] = $applicationDate->toDateString();

    //                 $diffInYears = $lastRenewalDate->diffInYears($effectiveApplicationDate);

    //                 $currentCycleStart = $lastRenewalDate->copy()->addYears(floor($diffInYears / 2) * 2);
    //                 $currentCycleEnd = $currentCycleStart->copy()->addYears(2)->subDay();

    //                 $currentPointer = $lastRenewalDate->copy();
    //                 $yearStart = $currentPointer->copy();
    //                 $yearEnd = $currentPointer->copy()->addYear()->subDay();

    //                 if ($yearEnd->gte($effectiveApplicationDate)) {
    //                     break;
    //                 }

    //                 if ($yearEnd->gte($currentCycleStart)) {
    //                     break;
    //                 }

    //                 $dateRanges[] = [
    //                     'from' => $yearStart->format('d-m-Y'),
    //                     'to' => $yearEnd->format('d-m-Y'),
    //                 ];

    //                 $completedYears++;
    //                 $currentPointer->addYear();
    //             }

    //             $record['total_years_since_last_renewal'] = $completedYears;

    //             $record['date_ranges'] = $dateRanges;


    //             $record['worktype'] = DB::table('Masterdata.type_of_works')
    //                 ->select('work_type_code', 'work_type_name')
    //                 ->orderBy('work_type_name', 'asc')
    //                 ->get();
    //             $record['worknature'] = DB::table('Masterdata.nature_of_works')
    //                 ->select('nature_of_work_code', 'nature_of_work')
    //                 ->orderBy('nature_of_work', 'asc')
    //                 ->get();
    //             $record['type_of_employers'] = DB::table('Masterdata.type_of_employers')
    //                 ->select('employer_code', 'employer_name')
    //                 ->orderBy('employer_name', 'asc')
    //                 ->get();
    //             $record['professions'] = DB::table('Masterdata.professions')
    //                 ->select('profession_code', 'profession_name')
    //                 ->orderBy('profession_name', 'asc')
    //                 ->get();

    //             $record['twed'] = DB::table('Worker.workers_workbook_details as twed')
    //                 ->leftjoin('Masterdata.type_of_works as tow', 'twed.type_of_work', '=', 'tow.work_type_code')
    //                 ->leftjoin('Masterdata.type_of_employers as toe', 'twed.type_of_employer', '=', 'toe.employer_code')
    //                 ->where('worker_id', $session_worker_id)
    //                 ->select(
    //                     'twed.*',
    //                     'tow.*',
    //                     'toe.employer_code',
    //                     'toe.employer_name AS empname'
    //                 )
    //                 ->first();



    //             return view('worker.worker-renew-application', $record);
    //         }
    //     }

    //    public function renewApplicationUpdate(Request $request)
    //    {
    //        if (session()->get('worker-session') != true) {
    //            return Redirect::to('/');
    //        }
    //
    //        $record['worker'] = session()->get('worker');
    //        $session_worker_id = $record['worker']->worker_id;
    //        $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "F");
    //        $record['getVaultData'] = json_decode($vaultData->getData(), true);
    //        $record['wmf'] = MainWorkerForm::where('worker_id', $session_worker_id)->first();
    //        $record['subscription'] = WorkerSubscription::where('worker_id', $session_worker_id)->latest()->first();
    //
    //        if (WorkerApplicationStatus::where('worker_id',$session_worker_id)->where('is_renewal',1)->where('application_status','G')->exists())
    //                {
    //                    $record['remarks'] = WorkerApplicationStatus::where('worker_id', $session_worker_id)
    //                            ->where('application_status', 'G')
    //                            ->where('is_renewal',1)
    //                            ->first();
    //
    //                }
    //
    //
    //        $record['worktype'] = DB::table('Masterdata.type_of_works')
    //            ->select('work_type_code', 'work_type_name')
    //            ->get();
    //        $record['worknature'] = DB::table('Masterdata.nature_of_works')
    //            ->select('nature_of_work_code', 'nature_of_work')
    //            ->get();
    //        $record['type_of_employers'] = DB::table('Masterdata.type_of_employers')
    //            ->select('employer_code', 'employer_name')
    //            ->get();
    //        $record['professions'] = DB::table('Masterdata.professions')
    //            ->select('profession_code', 'profession_name')
    //            ->get();
    //
    //        $record['twed'] = DB::table('Worker.workers_workbook_details as twed')
    //            ->leftjoin('Masterdata.type_of_works as tow', 'twed.type_of_work', '=', 'tow.work_type_code')
    //            ->leftjoin('Masterdata.type_of_employers as toe', 'twed.type_of_employer', '=', 'toe.employer_code')
    //            ->where('worker_id', $session_worker_id)
    //            ->select(
    //                'twed.*',
    //                'tow.*',
    //                'toe.employer_code',
    //                'toe.employer_name AS empname'
    //            )
    //            ->first();
    //
    //        $record['twc'] = DB::table('Worker.workers_workbook_details as twc')
    //            ->join('Masterdata.type_of_employers as toe', 'twc.type_of_employer', '=', 'toe.employer_code')
    //            ->join('Masterdata.type_of_works as tow', 'twc.type_of_work', '=', 'tow.work_type_code')
    //            ->join('Masterdata.professions as pro', 'twc.profession', '=', 'pro.profession_code')
    //            ->where('twc.worker_id', $session_worker_id)
    //            ->select(
    //                'twc.id',
    //                'twc.worker_id',
    //                'twc.application_no',
    //                'twc.employer_name AS emp',
    //                'twc.employer_contact_number',
    //                'twc.from_date',
    //                'twc.to_date',
    //                'twc.type_of_employer',
    //                'twc.profession',
    //                'twc.profession_others',
    //                'twc.date_count',
    //                'twc.certificate_proof',
    //                'twc.id as certificate_proof_id',
    //                'toe.employer_code',
    //                'toe.employer_name AS empname',
    //                'twc.type_of_work',
    //                'tow.work_type_code',
    //                'tow.work_type_name',
    //                'pro.*'
    //            )
    //            ->orderBy('id','asc')
    //            ->get();
    //        return view('worker.edit.edit-worker-renewal-application', $record);
    //    }

    public function saveWorkBook(Request $request)
    {

        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }


        $record['worker'] = session()->get('worker');
        $session_worker_id = $record['worker']->worker_id;

        $employerValidator = Validator::make(
            $request->all(),
            [

                'type_of_work.*' => 'required|exists:pgsql.Masterdata.type_of_works,work_type_code',
                'employer_name_certi.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'employer_contact_number.*' => [
                    'required',
                    'numeric',
                    'digits:10',
                    'regex:/^[6-9]\d{9}$/'
                ],
                'from_date.*' => 'required',
                'to_date.*' => 'required',
                'date_count.*' => 'required|numeric',


                'type_of_employer.*' => 'required|exists:pgsql.Masterdata.type_of_employers,employer_code',
                'certificate_proof.0' => [
                    function ($attribute, $value, $fail) {
                        if (!$value || !$value->getClientOriginalName()) {
                            $fail("The file for $attribute is required.");
                        }
                    },
                    'file',
                    'mimetypes:application/pdf,image/jpeg,image/jpg',
                    'max:1048',
                ],


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


                'type_of_work.*.*.required' => 'Field cannot be blank.',
                'employer_name_certi.*.*.required' => 'Field cannot be blank.',
                'employer_name_certi.*.*.regex' => 'Only alphabets are allowed.',
                'employer_contact_number.*.*.required' => 'Field cannot be blank.',
                'employer_contact_number.*.*.numeric' => 'Only numbers are allowed.',
                'employer_contact_number.*.*.digits' => 'Contact number should be 10 digit.',
                'employer_contact_number.*.*.regex' => 'Invalid contact number.',
                'from_date.*.*.required' => 'Field cannot be blank.',
                'from_date.*.*.date' => 'Invalid date format.',
                'to_date.*.*.required' => 'Field cannot be blank.',
                'to_date.*.*.date' => 'Invalid date format.',
                'date_count.*.*.required' => 'Field cannot be blank.',
                'date_count.*.*.numeric' => 'Only numbers are allowed.',
                'type_of_employer.*.*.required' => 'Field cannot be blank.',
                'profession.*.*.required' => 'Field cannot be blank.',
                'certificate_proof.*.*.required' => 'A PDF file is required.',
                'certificate_proof.*.*.mimes' => 'Only PDF files are allowed.',
                'certificate_proof.*.*.max' => 'The PDF must not exceed 1MB in size.',


            ]
        );

        $employerValidator->after(function ($validator) use ($request) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $dateCounts = $request->input('date_count', []);

            $grouped = [];

            foreach ($dateCounts as $compositeKey => $value) {
                // Split composite key like "1.2" into [1, 2]
                $parts = explode('.', $compositeKey);

                if (count($parts) === 2) {
                    $group = $parts[0];
                    $sub = $parts[1];

                    // Group values by the main group
                    $grouped[$group][$sub] = floatval($value);
                }
            }

            foreach ($grouped as $groupKey => $values) {
                $sum = array_sum($values);

                if ($sum < 90) {
                    foreach ($values as $subKey => $val) {
                        $fieldKey = "date_count.$groupKey.$subKey";
                        $validator->errors()->add($fieldKey, "Total experience for group must be at least 90 days. Currently: $sum.");
                    }
                }
            }
        });

        if ($employerValidator->fails()) {
            return response()->json(['errors' => $employerValidator->errors()], 200);
        }

        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $session_worker_id)
            ->value('application_no');

        DB::beginTransaction();
        try {
            $certificateData = [];
            $filePaths = [];
            $f_names = $request->type_of_work;


            if (is_array($f_names) && !empty($f_names)) {
                $files = $request->file('certificate_proof');

                foreach ($f_names as $key => $f_name) {
                    // Mandatory validation for "0.0", "1.0", etc.
                    if (
                        is_string($key) &&
                        preg_match('/^\d+\.0$/', $key) &&
                        (!isset($files[$key]) || !$files[$key] || !$files[$key]->isValid())
                    ) {
                        return response()->json([
                            'success' => false,
                            'errors' => [
                                "certificate_proof.$key" => ["Certificate proof is required."]
                            ]
                        ], 200);
                    }

                    // Safe check for file presence
                    $file = isset($files[$key]) ? $files[$key] : null;

                    if ($file) {
                        $extension = $file->extension();
                        $uuid = Str::uuid();
                        $certificateFileName = "workbook-proof/{$session_worker_id}.{$uuid}.{$extension}";

                        Storage::disk('public')->put($certificateFileName, file_get_contents($file->getRealPath()));
                        $filePath = "/private/{$certificateFileName}";
                        $filePaths[$key] = $filePath;
                    } else {
                        $filePath = null; // if not uploaded, set null or skip
                    }
                    $parts = explode('.', $key);
                    // Store entry
                    $certificateData[] = WorkbookModel::create([
                        'worker_id' => $session_worker_id,
                        'application_no' => $data['application_no'],

                        'from_date' => Carbon::parse($request->from_date[$key])->format('Y-m-d'),
                        'to_date' => Carbon::parse($request->to_date[$key])->format('Y-m-d'),

                        'type_of_work' => $f_name,
                        'employer_name' => $request->employer_name_certi[$key],
                        'employer_contact_number' => $request->employer_contact_number[$key],
                        'date_count' => $request->date_count[$key],
                        'type_of_employer' => $request->type_of_employer[$key],
                        'certificate_proof' => $filePath,
                        'profession' => $request->profession[$key],
                        'profession_others' => $request->profession_others[$key],
                        'row_id' => $key,
                        'group_id' => (int)$parts[0],
                        'sub_row' => (int)$parts[1],
                    ]);
                }
            }

            DB::commit();
            Alert::toast('Workbook Details Updated Successfully', 'success');
            return response()->json(['success' => true, 'msg' => 'Workbook Details Updated!']);
        } catch (\Exception $e) {
            DB::rollback();
            //            return $e;
            return response()->json([
                'success' => false,
                'msg' => 'WEC001, Database Exception Error',
                'error' => $e->getMessage() // helpful in development
            ]);
        }
    }



    public function updateWorkbook(Request $request)
    {
//        dd([
//            'ALL_LARAVEL_FILES' => $request->allFiles(),
//            'RAW_PHP_FILES' => $_FILES
//        ]);

        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }


        $record['worker'] = session()->get('worker');
        $worker_id = $record['worker']->worker_id;

        $employerValidator = Validator::make(
            $request->all(),
            [

                'type_of_work.*' => 'required|exists:pgsql.Masterdata.type_of_works,work_type_code',
                'employer_name_certi.*' => 'required|regex:/^[\pL]+(?:[\s][\pL]+)*$/u',
                'employer_contact_number.*' => [
                    'required',
                    'numeric',
                    'digits:10',
                    'regex:/^[6-9]\d{9}$/'
                ],
                'from_date.*' => 'required',
                'to_date.*' => 'required',
                'date_count.*' => 'required|numeric',


                'type_of_employer.*' => 'required|exists:pgsql.Masterdata.type_of_employers,employer_code',
                'certificate_proof.0' => [
                    function ($attribute, $value, $fail) {
                        if (!$value || !$value->getClientOriginalName()) {
                            $fail("The file for $attribute is required.");
                        }
                    },
                    'file',
                    'mimetypes:application/pdf,image/jpeg,image/jpg',
                    'max:1048',
                ],


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


                'type_of_work.*.*.required' => 'Field cannot be blank.',
                'employer_name_certi.*.*.required' => 'Field cannot be blank.',
                'employer_name_certi.*.*.regex' => 'Only alphabets are allowed.',
                'employer_contact_number.*.*.required' => 'Field cannot be blank.',
                'employer_contact_number.*.*.numeric' => 'Only numbers are allowed.',
                'employer_contact_number.*.*.digits' => 'Contact number should be 10 digit.',
                'employer_contact_number.*.*.regex' => 'Invalid contact number.',
                'from_date.*.*.required' => 'Field cannot be blank.',
                'from_date.*.*.date' => 'Invalid date format.',
                'to_date.*.*.required' => 'Field cannot be blank.',
                'to_date.*.*.date' => 'Invalid date format.',
                'date_count.*.*.required' => 'Field cannot be blank.',
                'date_count.*.*.numeric' => 'Only numbers are allowed.',
                'type_of_employer.*.*.required' => 'Field cannot be blank.',
                'profession.*.*.required' => 'Field cannot be blank.',
                'certificate_proof.*.*.required' => 'A PDF file is required.',
                'certificate_proof.*.*.mimes' => 'Only PDF files are allowed.',
                'certificate_proof.*.*.max' => 'The PDF must not exceed 1MB in size.',


            ]
        );

        $employerValidator->after(function ($validator) use ($request) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $dateCounts = $request->input('date_count', []);
            $grouped = [];

            foreach ($dateCounts as $compositeKey => $value) {
                // Split composite key like "1.2" into [1, 2]
                $parts = explode('.', $compositeKey);

                if (count($parts) === 2) {
                    $group = $parts[0];
                    $sub = $parts[1];

                    // Group values by the main group
                    $grouped[$group][$sub] = floatval($value);
                }
            }

            foreach ($grouped as $groupKey => $values) {
                $sum = array_sum($values);

                if ($sum < 90) {
                    foreach ($values as $subKey => $val) {
                        $fieldKey = "date_count.$groupKey.$subKey";
                        $validator->errors()->add($fieldKey, "Total experience for group must be at least 90 days. Currently: $sum.");
                    }
                }
            }
        });

        if ($employerValidator->fails()) {
            return response()->json(['errors' => $employerValidator->errors()], 200);
        }

        $data['application_no'] = DB::table('Worker.main_worker_forms')
            ->where('worker_id', $worker_id)
            ->value('application_no');
        DB::beginTransaction();
        try {


            $certificateData = [];
            $certificateData3 = [];
            $filePaths = [];

          $f_names = $request->type_of_work;

//            $files = $request->hasFile('certificate_proof') ? $request->file('certificate_proof') : [];
            $data['application_no'] = DB::table('Worker.main_worker_forms')
                ->where('worker_id', $worker_id)
                ->value('application_no');
            $i = 0;
            if (is_array($f_names) && !empty($f_names)) {


//                dd(array_keys($files));


                $files = $request->file('certificate_proof', []);

                foreach ($f_names as $key => $f_name) {

                    $id = $request->certificate_proof_id[$key] ?? null;

                    if (!$id) continue;

                    $certificateData = WorkbookModel::find($id);

                    if (!$certificateData) continue;

                    $certificateData->type_of_work = $request->type_of_work[$key] ?? null;
                    $certificateData->employer_name = $request->employer_name_certi[$key] ?? null;
                    $certificateData->from_date = $request->from_date[$key] ?? null;
                    $certificateData->to_date = $request->to_date[$key] ?? null;

                    if (isset($files[$key])) {

                        $file = $files[$key];

                        $name = 'workbook-proof/' . $worker_id . '.' . Str::uuid() . '.' . $file->extension();

                        Storage::disk('public')->put($name, file_get_contents($file->getRealPath()));

                        $certificateData->certificate_proof = "/private/{$name}";
                    }

                    $certificateData->save();
                }



            }

            //            return $i;

            DB::commit();
            Alert::toast('Workbook Details Updated Successfully', 'success');
            return response()->json(['success' => true, 'msg' => 'Workbook Details Updated!']);
            //            return 'Y';
        } catch (\Exception $e) {
            //            return $e;
            DB::rollback();
            Log::error('Certificate Update Error: ' . $e->getMessage());
            return back();
            //            return 'N';
        }
    }

    public function previewRenewal(Request $request)
    {
        // 1. Session validation
        if (!session()->get('worker-session')) {
            return redirect('/');
        }

        $workerSession = session()->get('worker');
        $session_worker_id = $workerSession->worker_id ?? null;

        if (!$session_worker_id) {
            return redirect()->back()->with('error', 'Invalid worker session.');
        }

        try {

            // 2. Fetch worker with ALL required relations
            $worker_details = MainWorkerForm::with([
                'basicDetail.state',
                'basicDetail.maritalStatus',
                'basicDetail.cateGory',
                'basicDetail.education',
                'basicDetail.bloodGroup',
                'officeName',
                'address.currentResidence',
                'address.currentHouse',
                'address.currentDistrict',
                'bankDetail',
                'familyDetails.relationDetails',
                'certificates.typeOfIssuer',
                'certificates.typeOfEmployer',
                'workbooks.typeOfWork',
                'workbooks.typeOfEmployer',
                'workbooks.professions',
                'schemeDetails.scheme',
            ])->where('worker_id', $session_worker_id)->first();

            if (!$worker_details) {
                return redirect()->back()->with('error', 'Worker record not found.');
            }

            // 3. Temporary worker (may be null – that is OK)
            $temp_worker_details = TemporaryWorkerForm::with([
                'basicDetail.Profession'
            ])->where('worker_id', $session_worker_id)->first();

            // 4. Vault Data (fully guarded)
            try {
                $vaultResponse = $this->getVaultDataService
                    ->getVaultData($session_worker_id, 'F');
            } catch (\Throwable $e) {
                Log::error('Vault API Error', ['msg' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Vault service unavailable.');
            }

            $getVaultData = json_decode($vaultResponse->getData(), true);

            if (!is_array($getVaultData)) {
                throw new \Exception('Invalid vault response');
            }

            // 5. Normalize vault keys (VERY IMPORTANT)
            $getVaultData = [
                'name'        => $getVaultData['name']        ?? null,
                'careOf'      => $getVaultData['careOf']      ?? null,
                'gender'      => $getVaultData['gender']      ?? null,
                'dob'         => $getVaultData['dob']         ?? null,
                'state'       => $getVaultData['state']       ?? null,
                'district'    => $getVaultData['district']    ?? null,
                'subDistrict' => $getVaultData['subDistrict'] ?? null,
                'postOffice'  => $getVaultData['postOffice']  ?? null,
                'village'     => $getVaultData['village']     ?? null,
                'street'      => $getVaultData['street']      ?? null,
                'locality'    => $getVaultData['locality']    ?? null,
                'landMark'    => $getVaultData['landMark']    ?? null,
                'pinCode'     => $getVaultData['pinCode']     ?? null,
                'photo'       => $getVaultData['photo']       ?? null,
                'uID'         => $getVaultData['uID']          ?? null,
            ];

            // 6. Mask Aadhaar safely
            $getVaultDatauID = null;
            if (!empty($getVaultData['uID']) && strlen($getVaultData['uID']) >= 12) {
                $getVaultDatauID =
                    str_repeat('*', 8) . substr($getVaultData['uID'], -4);
            }

            // 7. Aadhar photo
            $aadhar_photo = $getVaultData['photo'];

            // 8. Flags for blade
            $has_ration_card = data_get($worker_details, 'basicDetail.has_ration_card');
            $has_pan         = data_get($worker_details, 'basicDetail.pan');

            return view('worker.preview-renewal-application', compact(
                'worker_details',
                'session_worker_id',
                'getVaultData',
                'aadhar_photo',
                'getVaultDatauID',
                'has_pan',
                'has_ration_card',
                'temp_worker_details'
            ));
        } catch (Exception $e) {
            //            return $e;

            Log::error('Preview Renewal Error', [
                'worker_id' => $session_worker_id,
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Unable to load preview. Please try again.');
        }
    }




    public function SubmitRenewal(Request $request)
    {

        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $pfcData = session()->get('pfcData');
        $record['worker'] = session()->get('worker');
        $session_worker_id = $record['worker']->worker_id;
        $isReverted = false;
        if (WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('is_renewal', 1)->where('application_status', 'G')->exists()) {
            $record['remarks'] = WorkerApplicationStatus::where('worker_id', $session_worker_id)
                ->where('application_status', 'G')
                ->where('is_renewal', 1)
                ->latest()  // Orders by `created_at` DESC (most recent first)
                ->first();  // Gets only the latest matching record

            $isReverted = true;
        }
        $status = env('APPLICATION_SUBMIT_STATUS'); // default status

        if ($isReverted) {
            $renewal = RenewWorkerForm::where('worker_id', $session_worker_id)->first();
            if ($renewal) {
                $role = $renewal->sender_role_id;

                if ($role == 2) {
                    $status = env('HEAD_REGISTERING_OFFICER');
                } elseif ($role == 3) {
                    $status = env('REGISTERING_OFFICER');
                }
            }
        }
        DB::beginTransaction();
        try {
            $data = MainWorkerBasicDetail::where('worker_id', $session_worker_id)->first();
            $retirement_date = Carbon::parse($data->date_of_retirement)->format('Y-m-d');
            $tfm = DB::table('Worker.main_worker_forms')->where('worker_id', $session_worker_id)->first();
            if (WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('is_renewal', 1)->where('application_status', 'G')->exists()) {
                $users = WorkerApplicationStatus::where('worker_id', $session_worker_id)->where('is_renewal', 1)->where('application_status', 'G')->latest()->first();
            } else {
                $users = null;
            }
            $onboarding = $tfm->already_registered == 1;
            //            if ($tfm) {
            //                $application_no = $tfm->application_no;
            //                $district = $tfm->office_id;
            //                $year = Carbon::now()->format('Y');
            //                $string = 'ABOCWWB';
            //                $text = 'REN';
            //                $ackNo = $string . '/' . $district . '/' . $year . '/' . $text . '/' . $application_no;
            //            } else {
            //
            //                $ackNo = 'Error: No record found';
            //            }

            $revert_status = RevertBack::where('worker_id', $session_worker_id)
                ->where('ack_no', 'like', '%/REN/%')
                ->count();
            if ($revert_status > 0) {

                $ackNo = RenewWorkerForm::where('worker_id', $session_worker_id)->value('ack_no');
            } else {
                $application_no = $tfm->application_no;
                $district = $tfm->office_id;
                $year = Carbon::now()->format('Y');
                $string = 'ABOCWWB';
                $text = 'REN';
                $ackNo = $string . '/' . $district . '/' . $year . '/' . $text . '/' . $application_no;
            }
            $existingRenewal = RenewWorkerForm::where('worker_id', $session_worker_id)->first();

            if ($isReverted && $existingRenewal) {

                // ✅ CASE 1: REVERT → UPDATE SAME ROW
                $existingRenewal->update([
                    'office_id' => $tfm->office_id,
                    'phone_no' => $tfm->phone_no,
                    'district' => $tfm->district,
                    'application_no' => $tfm->application_no,
                    'already_registered' => $tfm->already_registered,
                    'id_card' => $tfm->id_card,
                    'ack_no' => $ackNo,
                    'date_of_retirement' => $retirement_date,
                    'status' => $status, // will go to A
                    'active_status' => '0',
                    'payment_status' => 'success',
                    'vaultToken' => $tfm->vaultToken,
                    'vaultPassKey' => $tfm->vaultPassKey,
                    'resubmit_status' => 1,
                ]);
            } else {

                // ✅ CASE 2: NEW RENEWAL CYCLE

                if ($existingRenewal) {


                    $historyColumns = DB::select("SELECT column_name
                                        FROM information_schema.columns
                                        WHERE table_schema = 'Worker'
                                        AND table_name = 'renew_worker_forms_history'
                                    ");

                    $historyColumns = collect($historyColumns)
                        ->pluck('column_name')
                        ->reject(fn($col) => $col === 'id')
                        ->toArray();

                    $historyData = collect($existingRenewal->getAttributes())
                        ->only($historyColumns)
                        ->toArray();

                    if (empty($historyData)) {
                        throw new \Exception('History data empty');
                    }

                    $inserted = DB::table('Worker.renew_worker_forms_history')->insert($historyData);

                    if (!$inserted) {
                        throw new \Exception('History insert failed');
                    }

                    $existingRenewal->delete();
                }

                // ✅ Fresh insert
                $data = RenewWorkerForm::create([
                    'worker_id' => $session_worker_id,
                    'office_id' => $tfm->office_id,
                    'phone_no' => $tfm->phone_no,
                    'district' => $tfm->district,
                    'application_no' => $tfm->application_no,
                    'already_registered' => $tfm->already_registered,
                    'id_card' => $tfm->id_card,
                    'ack_no' => $ackNo,
                    'date_of_retirement' => $retirement_date,
                    'status' => $status, // F → A handled below
                    'active_status' => '0',
                    'payment_status' => 'success',
                    'vaultToken' => $tfm->vaultToken,
                    'vaultPassKey' => $tfm->vaultPassKey,
                    'resubmit_status' => 0,
                ]);
            }
            //            return $data;


            $data1 = MainWorkerForm::where('worker_id', $session_worker_id)->update([

                'application_no' => $tfm->application_no,
                'is_renewal' => '1',

            ]);

            if ($isReverted == true) {

                //                $onboarding = $tfm->already_registered == 1;
                $data = WorkerApplicationStatus::Create([
                    'worker_id' => $session_worker_id,
                    'application_no' => $tfm->application_no,
                    'ack_no' => $ackNo,
                    'sender_office_id' => $tfm->office_id,
                    'application_status' => $status,
                    'remarks' => 'Renewal Application Re-Submitted',
                    'already_registered' => $onboarding,
                    'sender_user_id' => $renewal->sender_user_id,
                    'application_receiver_user_id' => $renewal->application_receiver_user_id,
                    'sender_role_id' => null,
                    'application_receiver_role_id' => $renewal->application_receiver_role_id,
                    'is_renewal' => 1,
                    'resubmit_status' => 1,

                ]);
            } else {
                $datan = WorkerApplicationStatus::Create([
                    'worker_id' => $session_worker_id,
                    'application_no' => $tfm->application_no,
                    'ack_no' => $ackNo,
                    'sender_office_id' => $tfm->office_id,
                    'application_status' => env('APPLICATION_SUBMIT_STATUS'),
                    'remarks' => 'Renewal Application Submitted',
                    'already_registered' => $data->already_registered,
                    'is_renewal' => 1,
                    'resubmit_status' => 0,
                ]);
            }


            DB::commit();
            session()->put('pfcData', $pfcData);
            $phoneNumber = $tfm->phone_no;
            $application_no = $tfm->application_no;
            $bocw_card = $tfm->id_card;
            $response = $this->smsService->renewalApplicationSubmitSMS($phoneNumber, $application_no, $bocw_card);
            if ($response == true) {
                return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
            } else {
                Alert::toast('Application Submitted Successfully!', 'success');

                return redirect()->route('acknowledgement-renewal')->with('success', 'Successfully Submitted !');
            }
        } catch (Exception $e) {

            DB::rollBack();
            //            return $e;
            Alert::toast('Something Went Wrong!', 'error');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function acknowledgementRenewal(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $rtps_trans_id = session()->get('pfcData');
        $record['worker'] = session()->get('worker');
        $session_worker_id = $record['worker']->worker_id;
        $vaultDataNew = $this->getVaultDataService->getVaultData($session_worker_id, "F");
        $data['getVaultData'] = json_decode($vaultDataNew->getData(), true);
        $data['wmf'] = MainWorkerForm::where('worker_id', $session_worker_id)->first();
        $data['aadharPhoto'] = $data['getVaultData']['photo'];
        $data['worker'] = RenewWorkerForm::where('worker_id', $session_worker_id)
            ->first();
        $data['office_name'] = $data['worker']->officeName->office_name;
        $data['mwf'] = DB::table('Worker.renew_worker_forms as wmfm')
            ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
            ->where('worker_id', $session_worker_id)
            ->select('wmfm.*', 'ofc.*')
            ->first();
        $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
            ->where('worker_id', $session_worker_id)
            ->select('wmbd.*')
            ->first();
        $data['pfcData'] = null;



        if ($rtps_trans_id) {
            $pfcData = PfcKioskDetail::where('rtps_trans_id', $rtps_trans_id)->first();
            $data['is_csc_login'] = $pfcData->is_login_csc;
            if ($data['is_csc_login'] && $pfcData->service_id == '3') {
                $rtps_trans_id = $pfcData->rtps_trans_id;
                session()->put('pfcData', $rtps_trans_id);
                $data['pfcData'] = $pfcData;
                RenewWorkerForm::where('worker_id', $session_worker_id)->update([
                    'rtps_trans_id' => $rtps_trans_id
                ]);
                $data['pfcData'] = $pfcData;
                $encryption_key = "1234567890123456";
                if ($data['getVaultData']['gender'] == "M") {
                    $gender_data = "male";
                } elseif ($data['getVaultData']['gender'] == "F") {
                    $gender_data = "female";
                } else {
                    $gender_data = "others";
                }
                $userDetails = array();
                array_push(
                    $userDetails,
                    array(
                        "gender" => $gender_data,
                        "applicant_name" => $data['getVaultData']['name'],
                        "fathers_name" => $data['getVaultData']['careOf'],
                        "mobile_number" => $pfcData->mobile,
                        "address_line_1" => $data['getVaultData']['street'] ? $data['getVaultData']['street'] : "NA",
                        "address_line_2" => $data['getVaultData']['locality'] ? $data['getVaultData']['locality'] : "NA",
                        "state" => $data['getVaultData']['state'],
                        "district" => $data['worker']->districtName->district_name,
                        "pin_code" => $data['getVaultData']['pinCode']
                    )
                );
                $application_details = array(
                    "slno" => $data['worker']->ack_no . rand(0000, 9999),
                );


                $output = array(
                    "rtps_trans_id" => $pfcData->rtps_trans_id,
                    "user_id" => $pfcData->mobile,
                    "service_id" => $pfcData->service_id,
                    "app_ref_no" => $data['worker']->ack_no,
                    "status" => "S",
                    "submission_date" => Carbon::now()->format('Y-m-d H:i:s'),
                    "payment_mode" => "online",
                    "payment_ref_no" => 'NA',
                    "payment_date" => 'NA',
                    "amount" => '0.',
                    "application_details" => $application_details,
                    "applicant_details" => $userDetails,
                    "portal_no" => $pfcData->portal_no,
                    "submission_location" => $data['office_name'],
                    "district" => $data['worker']->districtName->district_name,
                    "circle" => $data['getVaultData']['subDistrict'] ? $data['getVaultData']['subDistrict'] : ""
                );


                $output = json_encode(array("response_data" => $output));


                $aes = new AES($output, $encryption_key);
                $data['encrypted_data'] = $aes->encrypt();
                $data['url'] = $pfcData->response_url;
            } else {
                $rtps_trans_id = $pfcData->rtps_trans_id;
                session()->put('pfcData', $rtps_trans_id);

                $pfcData = PfcKioskDetail::where('rtps_trans_id', $rtps_trans_id)->first();
                $data['pfcData'] = $pfcData;
                RenewWorkerForm::where('worker_id', $session_worker_id)->update([
                    'rtps_trans_id' => $rtps_trans_id
                ]);
                $encryption_key = "1234567890123456";
                if ($data['getVaultData']['gender'] == "M") {
                    $gender_data = "male";
                } elseif ($data['getVaultData']['gender'] == "F") {
                    $gender_data = "female";
                } else {
                    $gender_data = "others";
                }
                $userDetails = array();
                array_push(
                    $userDetails,
                    array(
                        "gender" => $gender_data,
                        "applicant_name" => $data['getVaultData']['name'],
                        "fathers_name" => $data['getVaultData']['careOf'],
                        "mobile_number" => $pfcData->mobile,
                        "address_line_1" => $data['getVaultData']['street'] ? $data['getVaultData']['street'] : "NA",
                        "address_line_2" => $data['getVaultData']['locality'] ? $data['getVaultData']['locality'] : "NA",
                        "state" => $data['getVaultData']['state'],
                        "district" => $data['worker']->districtName->district_name,
                        "pin_code" => $data['getVaultData']['pinCode']
                    )
                );
                $application_details = array(
                    "slno" => $data['worker']->ack_no . rand(0000, 9999),
                );


                $output = array(
                    "rtps_trans_id" => $pfcData->rtps_trans_id,
                    "user_id" => $pfcData->mobile,
                    "service_id" => $pfcData->service_id,
                    "app_ref_no" => $data['worker']->ack_no,
                    "status" => "S",
                    "submission_date" => Carbon::now()->format('Y-m-d H:i:s'),
                    "payment_mode" => "online",
                    "payment_ref_no" => 'NA',
                    "payment_date" => 'NA',
                    "amount" => '0.',
                    "application_details" => $application_details,
                    "applicant_details" => $userDetails,
                    "portal_no" => $pfcData->portal_no,
                    "submission_location" => $data['office_name'],
                    "district" => $data['worker']->districtName->district_name,
                    "circle" => $data['getVaultData']['subDistrict'] ? $data['getVaultData']['subDistrict'] : ""
                );


                $output = json_encode(array("response_data" => $output));


                $aes = new AES($output, $encryption_key);
                $data['pfcData'] = $pfcData;
                $data['encrypted_data'] = $aes->encrypt();
                $data['url'] = $pfcData->response_url;
            }
        }
        //        return $data;

        return view('worker.worker-renewal-ack', $data);
    }

    public function downloadAckPdfRenewal(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = session()->get('worker');
        $session_worker_id = $record['worker']->worker_id;
        $data['revert_back'] = RevertBack::where('worker_id', $session_worker_id)->count();
        $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "M");
        $data['getVaultData'] = json_decode($vaultData->getData(), true);
        $data['payment_date'] = null;
        $payment_date = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->count();
        if ($payment_date > 0) {
            $data['payment_date'] = WorkerPaymentSuccess::where('worker_id', $session_worker_id)->first();
        } else {
            $data['payment_date'] = null;
        }

        $data['worker'] = DB::table('Worker.renew_worker_forms')->where('worker_id', $session_worker_id)->first();
        $data['mwf'] = DB::table('Worker.renew_worker_forms as wmfm')
            ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
            ->where('worker_id', $session_worker_id)
            ->select('wmfm.*', 'ofc.*')
            ->first();
        $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
            ->where('worker_id', $session_worker_id)
            ->select('wmbd.*')
            ->first();

        $data['emblem'] = public_path('/assets/template/images/bocw.png');

        $options = [
            'encoding' => 'utf-8',
            'enable-local-file-access' => true,
        ];

        $html = view('worker.pdf.download-as-pdf-renewal', $data)->render();
        $pdfContent =  Pdf::loadHTML($html)
            ->setOptions($options)
            ->output();
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Acknowledgement_Receipt.pdf"',
        ]);
    }

    //    public function getStatus(Request $request)
    //    {
    //        $status = WorkerApplicationStatus::where('worker_id', auth()->id())
    //            ->value('application_status');
    //
    //        return view('application-status', [
    //            'application_status' => $status ?? 'No application found'
    //        ]);
    //    }


    public function downloadPreviewPDFRen(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = session()->get('worker');
        $session_worker_id = $record['worker']->worker_id;
        try {
            $maskAadharNumber = function ($aadharNumber) {
                return str_repeat('*', 8) . substr($aadharNumber, 8);
            };

            $vaultData = $this->getVaultDataService->getVaultData($session_worker_id, "M");
            $getVaultData = json_decode($vaultData->getData(), true);

            //        if (isset($getVaultData['uID'])) {
            //            $getVaultData['uID'] = $maskAadharNumber($getVaultData['uID']);
            //        }

            $worker_details = MainWorkerForm::with([
                'basicDetail.state',
                'basicDetail.maritalStatus',
                'basicDetail.cateGory',
                'basicDetail.education',
                'basicDetail.bloodGroup',
                'officeName',
                'address.currentResidence',
                'address.currentHouse',
                'address.currentDistrict',
                'bankDetail',
                'familyDetails.relationDetails',
                'certificates.typeOfIssuer',
                'certificates.typeOfEmployer',
                'workbooks.typeOfWork',
                'workbooks.typeOfEmployer',
                'workbooks.professions',
                'schemeDetails.scheme',
            ])->where('worker_id', $session_worker_id)->first();
            $temp_worker_details = TemporaryWorkerForm::where('worker_id', $session_worker_id)->first();

            $emblem = public_path('/assets/template/images/bocw.png');

            $has_ration_card = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('has_ration_card')
                ->first();

            $has_pan = DB::table('Worker.temporary_worker_basic_details')
                ->where('worker_id', $session_worker_id)
                ->pluck('pan')
                ->first();

            $twd = DB::table('Worker.temporary_worker_documents as twd')->where('twd.worker_id', $session_worker_id)->first();

            $documents = collect([
                ['id' => 1, 'name' => 'residential_proof', 'label' => 'Present Address Proof ', 'uploaded' => !empty($twd->residential_proof)],
                ['id' => 2, 'name' => 'old_id_card', 'label' => 'BOC ID Card', 'uploaded' => !empty($twd->old_id_card)],
                ['id' => 3, 'name' => 'subscription_payment_receipt', 'label' => 'Subscription Payment receipt', 'uploaded' => !empty($twd->subscription_payment_receipt)],
                ['id' => 4, 'name' => 'worker_bank_copy', 'label' => 'Aadhaar Linked Bank Copy', 'uploaded' => !empty($twd->worker_bank_copy)],
                ['id' => 5, 'name' => 'ration_card', 'label' => 'Ration Card', 'uploaded' => !empty($twd->ration_card)],
                ['id' => 6, 'name' => 'nominee_bank_copy', 'label' => 'Nominee Bank Copy', 'uploaded' => !empty($twd->nominee_bank_copy)],
                ['id' => 7, 'name' => 'pan_card', 'label' => 'PAN Card', 'uploaded' => !empty($twd->pan_card)],
                ['id' => 8, 'name' => 'work_book', 'label' => 'Work Book/90 days Certificate', 'uploaded' => !empty($twd->work_book)],
            ]);

            $ndc = WorkerNinetyDaysCertificate::where('worker_id', $session_worker_id)->get();
            $serialNumber = 1;
            $html = view('worker-renewal.pdf.worker-preview-details-renewal-pdf', compact('emblem', 'worker_details', 'getVaultData', 'has_ration_card', 'has_pan', 'documents', 'ndc', 'serialNumber'))->render();
            $options = [
                'encoding' => 'utf-8', // Set encoding to UTF-8
                'enable-local-file-access' => true, // Enable external links
            ];
            // Generate PDF from HTML content
            $pdfContent =  Pdf::loadHTML($html)
                ->setOptions($options)
                ->output();

            // Set response headers to indicate PDF content
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="application.pdf"',
            ]);
        } catch (Exception $e) {
            //            return $e;
            DB::rollBack();
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }

    public function renewalHistory(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = session()->get('worker');
        $session_worker_id = $record['worker']->worker_id;

        try {
            $vaultDataNew = $this->getVaultDataService->getVaultData($session_worker_id, "F");
            $data['getVaultData'] = json_decode($vaultDataNew->getData(), true);
            $data['history'] = RenewWorkerFormHistory::where('worker_id', $session_worker_id)->get();

            return view('worker.worker-renewal-history', $data);
        } catch (Exception $e) {
            Alert::toast("Something went wrong!", 'error');
            return back();
        }
    }
}

