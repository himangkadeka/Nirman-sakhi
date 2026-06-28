<?php

namespace App\Http\Controllers\Worker\pdfs;

use App\Http\Controllers\Controller;
use App\Models\WorkerReceipt;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function index()
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
        $expiry_date = Carbon::parse($data['wmf']->created_at);
        $data['renewal_date'] = Carbon::parse($data['wmf']->renewal_date);
        $renewal_date = Carbon::parse($data['wmf']->renewal_date);
        $daysUntilRenewal = $renewal_date->diffInDays($expiry_date);
        // Check if renewal date has exceeded the expiry date
        if ($renewal_date->gt($expiry_date)) {
            $no_of_penalty_month = (int) ($daysUntilRenewal / 30);
        } else {
            $no_of_penalty_month = 0;
        }

        $penalty_amount = 0;
        $subscription_amount = 20 * $no_of_penalty_month;

        for ($i = 0; $i < $no_of_penalty_month; $i++) {
            $penalty_amount += 2 * ($i + 1);
        }
        $data['penalty_amount'] = $penalty_amount;
        $data['gender'] = DB::table('Masterdata.genders')->get();
        $data['user'] = DB::table('Worker.main_worker_forms as wfm')
            ->where('wfm.worker_id', $workerId)
            ->first();
        $data['subscription_amount'] = $subscription_amount;
        $data['subscriptionreciept'] = DB::table('Worker.worker_receipts')->where('worker_id',$workerId)->get();
        $data['current_date'] = now();
        return view('worker.pdf.receipt.index', $data);
    }

    public function store(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerValue = session()->get('worker');
        $workerId = $record['worker']->worker_id;
        $data['worker'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $data['mwf'] = DB::table('Worker.main_worker_forms as wmfm')
            ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
            ->where('worker_id', $workerId)
            ->select('wmfm.*', 'ofc.*')
            ->first();
        $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
            ->where('worker_id', $workerId)
            ->select('wmbd.*')
            ->first();
        $passport = DB::table('Worker.temporary_worker_documents')
            ->where('worker_id', $workerId)
            ->first()->passport_image;

        $data['passport'] = Storage::path($passport);
        // The Blade view you provided
        $html = view('worker.pdf.receipt.create', $data)->render();

        // Generate the PDF
        $pdf = PDF::loadHtml($html);

        return $pdf->download('acknowledgement_receipt.pdf');
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'gallery_category_name' => 'required'
            ],
            [
                'gallery_category_name.required' => "Category Name cannot be empty"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }

        try {
            GalleryCategory::where('id', $request->id)->update([
                'category_name' => $request->gallery_category_name
            ]);
            Alert::toast("Gallery Category Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Gallery Category Updated Successfully!"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'gallery_category_id' => 'required|numeric|exists:pgsql.Content.gallery_categories,id'
            ],
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                GalleryCategory::where('id', $request->gallery_category_id)->delete();
                Alert::toast("Gallery Category Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
