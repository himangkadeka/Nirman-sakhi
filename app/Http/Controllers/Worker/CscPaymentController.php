<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerForm;
use App\Models\TemporaryWorkerForm;
use App\Models\WorkerPaymentSuccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\GetVaultDataService;
use App\Services\SmsGatewayService;

require_once(app_path('Libraries/CSCPay/BridgePGUtil.php'));


class CscPaymentController extends Controller
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
        $workerId = session('worker_id');
        Session::put('worker_id', $workerId);
//        return Carbon::now()->format('Y-m-d H:i:s');
//        return "CSC Payment is on maintenance mode";
        $timestamp = now('Asia/Kolkata')->addMinutes(5)->format('YmdHis');
        $data = TemporaryWorkerForm::where('worker_id', $workerId)->first();
        WorkerPaymentSuccess::where('worker_id', $workerId)
            ->where('STATUS', 'O')
            ->where('payment_type','1')
            ->whereNotNull('merchant_txn')
            ->delete();

        $bconn = new \BridgePGUtil();
//        if ($record) {
//            $merchantTxn = $record->merchant_txn;
//            $receiptNo   = $record->merchant_receipt_no;
//            $p = [
//                'csc_id' => $cscId,
//                'merchant_id' => env('CSC_MERCHANT_ID'),
//                'merchant_receipt_no' => $receiptNo,
//                'txn_amount' => 25,
//                'return_url' => route('payment.response'),
//                'cancel_url' => route('payment.response'),
//                'product_id' => '7028461779',
//                'merchant_txn' => $merchantTxn,
//            ];
//        } else {
            $p = [
                'csc_id' => $cscId,
                'merchant_id' => env('CSC_MERCHANT_ID'),
                'merchant_receipt_no' => 'ABOCW' . $data->application_no . $timestamp . Str::random(4),
                'txn_amount' => 25,
                'return_url' => route('payment.response'),
                'cancel_url' => route('payment.response'),
                'product_id' => '7028461779',

                'merchant_txn' => 'ABOCW' . $data->application_no . $timestamp . Str::random(4),
            ];


            WorkerPaymentSuccess::create([
                'csc_id' => $p['csc_id'],
                'payment_type'=>'1',
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
        $workerId = null;
        $merchantTxn = trim($fine_params['merchant_txn']);

        $merchant_transaction = WorkerPaymentSuccess::where('merchant_txn', $merchantTxn)->first();
////        $merchant_transaction = WorkerPaymentSuccess::where('merchant_txn', $fine_params['merchant_txn'])
//            ->where('payment_type', 1)
//            ->first();

        if ($merchant_transaction) {
            $workerId = $merchant_transaction->worker_id;
        } else {
            $merchant_receipt = WorkerPaymentSuccess::where('merchant_receipt_no', $fine_params['merchant_receipt_no'])
                ->where('payment_type', 1)
                ->first();

            if (!$merchant_receipt) {
                Log::error('Payment record not found', $fine_params);
                return response()->json([
                    'status'  => false,
                    'message' => 'No matching payment record found.',
                    'data'    => [
                        'fine_params' => $fine_params,
                        'merchant_transaction' => $merchant_transaction,
                    ],
                ], 400);
            }

            $workerId = $merchant_receipt->worker_id;
        }
        Session::put('worker_id', $workerId);

        $data['application_no'] = DB::table('Worker.temporary_worker_forms')
            ->where('worker_id', $workerId)
            ->pluck('application_no')
            ->first();


        if (strtolower($fine_params['txn_status_message']) === 'success') {

            WorkerPaymentSuccess::where('worker_id', $workerId)
                ->where('payment_type', 1)
                ->where('merchant_txn', $fine_params['merchant_txn'])
                ->update([
                'csc_id' => $fine_params['csc_id'],
                'payment_type'=>'1',
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

            MainWorkerForm::where('worker_id', $workerId)->update(['payment_status' => 'success']);
            $bconn->set_mid(env('CSC_MERCHANT_ID'));
            $status = $bconn->get_status($fine_params['merchant_txn'], $fine_params['csc_txn']);
            $statusData = json_decode($status, true);

            $data['transaction_status'] = $statusData;

            Log::info('Transaction Status Data:', $data);

            $data = MainWorkerForm::where('worker_id', $workerId)->first();

            if ($data) {
                $this->smsService->applicationSubmissionSMS($data->phone_no, $data->ack_no, '25');

                $vaultData = $this->getVaultDataService->getVaultData($workerId, "M");
                $record['getVaultData'] = json_decode($vaultData->getData(), true);
            }

            return view('partials.payment-response', [
                'encryptedValue' => $encryptedValue,
                'decryptedMessage' => $bridge_message,
                'parsedParameters' => $fine_params,
                'worker_id' => $workerId,
                'message' => 'Payment successful!'
            ]);

        } else {
            WorkerPaymentSuccess::where([
                ['worker_id', '=', $workerId],
                ['STATUS', '=', 'O'],
            ]) ->update([
                'csc_id' => $fine_params['csc_id'] ?? null,
                'DEPARTMENT_ID' => $fine_params['merchant_txn'],
                'payment_type' => '1',
                'csc_txn_id' => 'Cancelled by user',
                'merchant_txn' => $fine_params['merchant_txn'] ?? null,
                'enc_data' => json_encode($fine_params),
                'STATUS' => 'C',
            ]);

            return view('partials.payment-failed', [
                'encryptedValue' => $encryptedValue,
                'decryptedMessage' => $bridge_message,
                'parsedParameters' => $fine_params,
                'worker_id' => $workerId,
                'message' => 'Payment was unsuccessful'
            ]);
        }
    }

    public function status(){
        $bconn = new \BridgePGUtil();
        $merchant_id = env('CSC_MERCHANT_ID');
        $tid = 'ABOCW26190377320251211135302eBP7';
        $csc_txn = '';
        $product_id = '7028461779';
        $txn_amount = '25.00';
        $merchant_txn_status = 'S';
        $merchant_reference='ABOCW26190377320251211135302eBP7';
        $refund_mode='F';
        $refund_type='R';
        $refund_trigger='M';
        $refund_reason='unable to deliver service';
        $refund_deduction=$txn_amount;

        $bconn->set_mid($merchant_id);
        $refund = $bconn->get_status(
            $tid,
            $csc_txn,
            $product_id,
            $merchant_txn_status,
            $merchant_reference,
            $refund_deduction,
            $refund_mode,
            $refund_type,
            $refund_trigger,
            $refund_reason
        );
        print_r($refund);

    }
public function refundlog(Request $request){
    $bconn = new \BridgePGUtil();
    $merchant_id = env('CSC_MERCHANT_ID');
    $csc_txn = '5325152221971092';
    $tid = 'ABOCW51924147820251121151846DtEH';
    $txn_amount = '25.00';
    $merchant_txn_status='S';
    $refund_deduction=$txn_amount;
    $refund_mode='F';
    $refund_type='R';
    $refund_trigger='M';
    $refund_reason='unable to deliver service';
    $product_id='7028461779';
    $merchant_reference='ABOCW51924147820251121151846DtEH';
    $bconn->set_mid($merchant_id);
    $refund = $bconn->refund_log(
        $tid,
        $csc_txn,
        $product_id,
        $merchant_txn_status,
        $merchant_reference,
        $refund_deduction,
        $refund_mode,
        $refund_type,
        $refund_trigger,
        $refund_reason
    );
    print_r($refund);

}
}

