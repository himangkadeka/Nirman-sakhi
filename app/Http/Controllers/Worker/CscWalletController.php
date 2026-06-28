<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AbhaDetail;
use App\Models\PgRequest;
use App\Models\PgResponse;
use App\Services\BridgePGUtil; // You may need to write this Laravel service


class CscWalletController extends Controller
{
    public function index(Request $request, $id, $healthID)
    {
        Session::put('HEALTH_ID', $healthID);

        $userId = Session::get('USER_ID');
        $abhaRecord = AbhaDetail::where('id', $id)
            ->where('health_id_number', $healthID)
            ->where('payment_status', '0')
            ->where('added_by', $userId)
            ->first();

        if ($abhaRecord) {
            $addDate = Carbon::parse($abhaRecord->add_date);

            if (now()->diffInMinutes($addDate) > 15) {
                Session::flash('error', 'No Record available for payment');
                return redirect()->route('abha.list_abha'); // or url('abha/list_abha')
            }

            $bconn = new BridgePGUtil();
            $timestamp = time();
            $merchantReceiptNo = 'ABHA#' . $id . $timestamp;
            $merchantTxn = 'ABHA' . $id . $timestamp;

            $params = [
                'csc_id' => $userId,
                'merchant_id' => '28821',
                'merchant_receipt_no' => $merchantReceiptNo,
                'txn_amount' => 25.00,
                'return_url' => route('payment.success'),
                'cancel_url' => route('payment.success'),
                'product_id' => '2882184246',
                'merchant_txn' => $merchantTxn,
                'param_1' => $healthID,
            ];

            $bconn->set_params($params);
            $enc_text = $bconn->get_parameter_string();
            $frac = $bconn->get_fraction();

            PgRequest::create([
                'csc_id' => $params['csc_id'],
                'health_id' => $healthID,
                'merchant_receipt' => $merchantReceiptNo,
                'amount' => $params['txn_amount'],
                'merchant_txn' => $merchantTxn,
                'request' => json_encode($params),
                'transaction_status' => '0',
                'reversal_txn' => '',
                'add_date' => now()
            ]);

            return view('payment_navigate', [
                'enc_text' => $enc_text,
                'frac' => $frac
            ]);

        } else {
            Session::flash('error', 'No Record available for payment');
            return redirect()->route('abha.list_abha');
        }
    }

    public function success(Request $request)
    {
        $healthID = Session::get('HEALTH_ID');
        if (!$healthID) {
            return redirect()->route('abha.list_abha');
        }

        $bconn = new BridgePGUtil();
        $bridge_message = $bconn->get_bridge_message();
        $params = explode('|', $bridge_message);

        $fine_params = [];
        foreach ($params as $param) {
            $pair = explode('=', $param, 2);
            $fine_params[$pair[0]] = $pair[1] ?? null;
        }

        if (isset($fine_params['txn_status']) && $fine_params['txn_status_message'] === 'Success') {
            PgResponse::create([
                'csc_id' => $fine_params['csc_id'] ?? '',
                'csc_txn' => $fine_params['csc_txn'] ?? '',
                'merchant_txn' => $fine_params['merchant_txn'] ?? '',
                'health_id' => $healthID,
                'response' => json_encode($fine_params),
                'date' => now(),
            ]);

            AbhaDetail::where('health_id_number', $healthID)
                ->update(['payment_status' => '1']);

            Session::forget('HEALTH_ID');
            return redirect()->route('abha.list_abha');
        } else {
            PgResponse::create([
                'csc_id' => $fine_params['csc_id'] ?? '',
                'csc_txn' => 'Cancelled by user',
                'merchant_txn' => $fine_params['merchant_txn'] ?? '',
                'response' => json_encode($fine_params),
                'date' => now(),
            ]);

            Session::flash('error', 'Payment was unsuccessful');
            Session::forget('HEALTH_ID');
            return redirect()->route('abha.list_abha');
        }
    }
}
