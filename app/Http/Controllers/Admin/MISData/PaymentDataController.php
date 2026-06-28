<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\WorkerPaymentSuccess;
use Illuminate\Http\Request;
use App\Exports\WorkerPaymentSuccessExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;


class PaymentDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $payments = WorkerPaymentSuccess::paginate(5);
        // $total = WorkerPaymentSuccess::where('STATUS', 'Y')->sum('AMOUNT');
        // $totalRegistration = WorkerPaymentSuccess::where('STATUS', 'Y')->where('payment_type', 1)->sum('AMOUNT');
        // $totalSubscription = WorkerPaymentSuccess::where('STATUS', 'Y')->where('payment_type', 2)->sum('AMOUNT');
        // return view('admin.mis-data.payment-transaction.index', compact('payments', 'total', 'totalRegistration', 'totalSubscription'));
        $query = WorkerPaymentSuccess::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('worker_id', 'ILIKE', "%{$search}%")
                    ->orWhere('DEPARTMENT_ID', 'ILIKE', "%{$search}%")
                    ->orWhere('PRN', 'ILIKE', "%{$search}%")
                    ->orWhere('GRN', 'ILIKE', "%{$search}%");
            });
        }

        $payments = $query->orderBy('id', 'desc')->paginate(10)->appends(['search' => $request->search]);

        $total = $query->where('STATUS', 'Y')->sum('AMOUNT');
        $totalRegistration = $query->where('STATUS', 'Y')->where('payment_type', 1)->sum('AMOUNT');
        $totalSubscription = $query->where('STATUS', 'Y')->where('payment_type', 2)->sum('AMOUNT');

        return view('admin.mis-data.payment-transaction.index', compact('payments', 'total', 'totalRegistration', 'totalSubscription'));
    }

    public function destroy($id)
    {
        try {
            $payment = WorkerPaymentSuccess::findOrFail($id);
            $payment->delete();

            return redirect()->back()->with('success', 'Payment record deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete payment record: ' . $e->getMessage());
        }
    }


    public function export($type)
    {
        $fileName = 'ABOCWWB Admin Id Card Data.' . $type;

        if ($type === 'pdf') {
            $data = WorkerPaymentSuccess::select(

                'worker_id',
                'PARTYNAME',
                'DEPARTMENT_ID',
                'payment_type',
                'STATUS',
                'AMOUNT',
                'BANKNAME',
                'GRN',
                'PRN',
                'created_at'
            )->get();
            $pdf = PDF::loadView('admin.mis-data.payment-transaction.export-pdf', compact('data'));
            return $pdf->download($fileName);
        }

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(new WorkerPaymentSuccessExport, $fileName); // ✅ No ->header() here
        }

        abort(404, 'Invalid export format.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//
//    public function destroy($id)
////    {
////        //
////    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|integer|exists:pgsql.Worker.worker_payment_success,id',
            'payment_status' => 'required|in:Y,N,A,P'
        ]);

        $payment = WorkerPaymentSuccess::findOrFail($request->payment_id);
        $payment->STATUS = $request->payment_status;
        $payment->save();

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }
    public function cscWallet(Request $request)
    {
        $query = WorkerPaymentSuccess::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('worker_id', 'ILIKE', "%{$search}%")
                    ->orWhere('csc_txn_id', 'ILIKE', "%{$search}%")
                    ->orWhere('merchant_id', 'ILIKE', "%{$search}%")
                    ->orWhere('csc_id', 'ILIKE', "%{$search}%");
            });
        }

        $payments = $query
            ->whereNotNull('csc_id')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(['search' => $request->search]);

        $total = (clone $query)
            ->where('STATUS', 'F')
            ->whereNotNull('csc_txn_id')
            ->sum('AMOUNT');
        $applications = (clone $query)
            ->whereNotNull('csc_id')
            ->count();


        $totalRegistration = (clone $query)
            ->where('STATUS', 'F')
            ->whereNotNull('csc_txn_id')
            ->where('payment_type', 1)
            ->sum('AMOUNT');

        $totalSubscription = (clone $query)
            ->where('STATUS', 'F')
            ->whereNotNull('csc_txn_id')
            ->where('payment_type', 2)
            ->sum('AMOUNT');

        return view('admin.mis-data.csc-payment-data.index', compact('payments', 'total', 'totalRegistration', 'totalSubscription','applications'));
    }
}
