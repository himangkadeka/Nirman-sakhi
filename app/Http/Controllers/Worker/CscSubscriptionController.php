<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerForm;
use App\Models\TemporaryWorkerFamily;
use App\Models\TemporaryWorkerForm;
use App\Models\WorkerPaymentSuccess;
use App\Models\WorkerSubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\GetVaultDataService;
use App\Services\SmsGatewayService;
require_once(app_path('Libraries/CSCPay/BridgePGUtil.php'));

class CscSubscriptionController extends Controller
{
    protected $smsService;
    protected $AuthOtpController;
    protected $getVaultDataService;

    public function __construct(SmsGatewayService $smsService, AuthOtpController $AuthOtpController, GetVaultDataService $getVaultDataService)
    {
        $this->smsService = $smsService;
        $this->AuthOtpController = $AuthOtpController;
        $this->getVaultDataService = $getVaultDataService;
    }
    public function index(Request $request, $cscId)
    {
       $workerId  = $request->get('worker_id') ?? session('worker_id');
        Session::put('workerId', $workerId);
        $data = TemporaryWorkerForm::where('worker_id', $workerId)->first();
        $timestamp = now('Asia/Kolkata')->addMinutes(5)->format('YmdHis');
//      $record = WorkerPaymentSuccess::where('worker_id', $workerId)
//            ->where('STATUS', 'O')
//            ->where('payment_type','2')
//            ->whereNotNull('merchant_txn')
//            ->latest()
//            ->first();
        $subscription = WorkerSubscription::where('worker_id',$workerId)->where('payment_status','0')->latest()->first();
        if(!$subscription){
            abort(400,'Subscription not found');
        }
        WorkerPaymentSuccess::where('worker_id', $workerId)
            ->where('STATUS', 'O')
            ->whereNotNull('merchant_txn')
            ->where('payment_type','2')
            ->delete();
        $uniqueId = now()->format('YmdHis') . Str::random(4);
        $bconn = new \BridgePGUtil();
//        if ($record) {
//            $merchantTxn = $record->merchant_txn;
//            $receiptNo   = $record->merchant_receipt_no;
//            $p = [
//                'csc_id' => $record->csc_id,
//                'merchant_id' => env('CSC_MERCHANT_ID'),
//                'merchant_receipt_no' => $receiptNo,
//                'txn_amount' => $subscription->total_amount,
//                'return_url' => route('sub-payment.sub-response'),
//                'cancel_url' => route('sub-payment.sub-response'),
//                'product_id' => '7028448553',
//                'merchant_txn' => $merchantTxn,
//            ];
//        } else {
            $p = [
                'csc_id' => $cscId,
                'merchant_id' => env('CSC_MERCHANT_ID'),
                'merchant_receipt_no' => 'ABOCW' . $data->application_no . $timestamp . Str::random(4),
                'txn_amount' => $subscription->total_amount,
                'return_url' => route('sub-payment.sub-response'),
                'cancel_url' => route('sub-payment.sub-response'),
                'product_id' => '7028448553',
                'merchant_txn' => 'ABOCW' . $data->application_no . $timestamp . Str::random(4),
            ];

            WorkerPaymentSuccess::create([
                'csc_id' => $p['csc_id'],
                'payment_type'=>'2',
                'DEPARTMENT_ID' => $p['merchant_txn'],
                'merchant_id' => $p['merchant_id'],
                'merchant_receipt_no' => $p['merchant_receipt_no'],
                'AMOUNT' => $p['txn_amount'],
                'merchant_txn' => $p['merchant_txn'],
                'PORTAL_ENCDATA' => json_encode($p),
                'worker_id' => $workerId,
                'STATUS' => 'O',
            ]);
//        }


        $bconn->set_params($p);
        $enc_text = $bconn->get_parameter_string();
        $frac = $bconn->get_fraction();
//
        $data['enc_text'] = $enc_text;
        $data['frac'] = $frac;

        return view('partials.payment-navigate', $data);
    }

    public function handlePaymentResponse(Request $request)
    {

        if (!$request->has('bridgeResponseMessage')) {
            return response('Error: No bridgeResponseMessage found in the request.', 400);
        }
        $bconn = new \BridgePGUtil();
        $bridge_message = $bconn->get_bridge_message();
        $encryptedValue = $request->input('bridgeResponseMessage');

        $params = explode('|', $bridge_message);
        $fine_params = [];

        foreach ($params as $param) {
            $param_parts = explode('=', $param);
            if (count($param_parts) === 2) {
                $fine_params[$param_parts[0]] = $param_parts[1];
            }
        }



//        $merchant_transaction = WorkerPaymentSuccess::where('merchant_txn', $fine_params['merchant_txn'])->where('payment_type',2)->first();
//
//        if (!$merchant_transaction) {
//            $merchant_receipt = WorkerPaymentSuccess::where('merchant_receipt_no', $fine_params['merchant_receipt_no'])->where('payment_type',2)->first();
//
//        }
        $workerId = null;
        $merchant_transaction = WorkerPaymentSuccess::where('merchant_txn', $fine_params['merchant_txn'])
            ->where('payment_type', 2)
            ->first();

        if ($merchant_transaction) {
            $workerId = $merchant_transaction->worker_id;
        } else {
            $merchant_receipt = WorkerPaymentSuccess::where('merchant_receipt_no', $fine_params['merchant_receipt_no'])
                ->where('payment_type', 2)
                ->first();

            if (!$merchant_receipt) {
                Log::error('Payment record not found', $fine_params);
                return response('Error: No matching payment record found.', 400);
            }

            $workerId = $merchant_receipt->worker_id;
        }

//        $workerId = $merchant_transaction->worker_id;
        Session::put('worker_id', $workerId);
        $vaultData = $this->getVaultDataService->getVaultData($workerId, "M");
        $record['getVaultData'] = json_decode($vaultData->getData(), true);
        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $workerId)
            ->pluck('application_no')
            ->first();


        if (strtolower($fine_params['txn_status_message']) === 'success') {

            WorkerPaymentSuccess::where('worker_id', $workerId)
                ->where('payment_type', 2)
                ->where('merchant_txn', $fine_params['merchant_txn'])
                ->update([
                    'csc_id' => $fine_params['csc_id'],
                    'payment_type'=>'2',
                    'DEPARTMENT_ID' => $fine_params['merchant_txn'],
                    'csc_txn_id' => $fine_params['csc_txn'],
                    'merchant_txn' => $fine_params['merchant_txn'],
                    'merchant_receipt_no' => $fine_params['merchant_receipt_no'],
                    'enc_data' => json_encode($fine_params),
                    'STATUS' => 'F',
                    'TRANSCOMPLETIONDATETIME' => now(),
                    'merchant_txn_datetime' => $fine_params['merchant_txn_date_time'],
                    'product_id' => $fine_params['product_id'],
                    'txn_mode' => $fine_params['txn_mode'],
                ]);

            MainWorkerForm::where('worker_id', $workerId)->update(['active_status' => 1]);
            WorkerSubscription::where('worker_id',$workerId)->where('payment_status','0')->first()
                ->update(
                    ['payment_status' => '1',
                        'transaction_id'=>$fine_params['csc_txn'],
                    ]

                );
            $bconn->set_mid(env('CSC_MERCHANT_ID'));
            $status = $bconn->get_status($fine_params['merchant_txn'], $fine_params['csc_txn']);
            $statusData = json_decode($status, true);
            $data['transaction_status'] = $statusData;
            Log::info('Transaction Status Data:', $data);
            $data = MainWorkerForm::where('worker_id', $workerId)->first();
            Session::put('worker-session', true);
            Session::put('worker', MainWorkerForm::where('worker_id', $workerId)->first());
            Session::put('pfcData', $record['getVaultData']);

            return view('partials.subscription-payment-response', [
                'encryptedValue' => $encryptedValue,
                'decryptedMessage' => $bridge_message,
                'parsedParameters' => $fine_params,
                'worker_id' => $workerId,
                'getVaultData' => $record['getVaultData'],
                'message' => 'Payment successful!'
            ]);

        } else {
            WorkerPaymentSuccess::where([
                ['worker_id', '=', $workerId],
                ['payment_type', '=' , '2'],
                ['STATUS', '=', 'O'],
            ])->update([
                'csc_id' => $fine_params['csc_id'],
                'DEPARTMENT_ID' => $fine_params['merchant_txn'],
                'payment_type' => '2',
                'csc_txn_id' => 'Cancelled by user',
                'merchant_txn' => $fine_params['merchant_txn'],
                'enc_data' => json_encode($fine_params),
                'STATUS' => 'C',
            ]);

            return view('partials.subscription-payment-failed', [
                'encryptedValue' => $encryptedValue,
                'decryptedMessage' => $bridge_message,
                'parsedParameters' => $fine_params,
                'worker_id' => $workerId,
                'getVaultData' => $record['getVaultData'],
                'message' => 'Payment was unsuccessful'
            ]);
        }
    }

}