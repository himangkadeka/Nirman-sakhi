<?php

namespace App\Http\Controllers\Worker\pdfs;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\CancelledAppModal;
use App\Models\MainWorkerForm;
use App\Models\WorkerIDCard;
use App\Services\AesCipher;
use App\Services\GetVaultDataService;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Knp\Snappy\Pdf;

class IdCardController extends Controller
{
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService = $getVaultDataService;
    }

    public function downloadIdCard()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerValue = session()->get('worker');
        $workerId = $record['worker']->worker_id;
        $vaultData = $this->getVaultData($workerId);
        $data['getVaultData'] = json_decode($vaultData->getData(), true);
        $data['user'] = DB::table('Worker.main_worker_forms as wfm')
            ->where('wfm.worker_id', $workerId)
            ->first();
        $record['worker'] = $workerValue = session()->get('worker');

        $data['gender'] = DB::table('Masterdata.genders')->get();
        $data['current_date'] = now();
        $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        return view('worker.pdf.download-id-card', $data);
    }



    public function index()
    {

        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        try {
            $record['worker'] = $workerValue = session()->get('worker');
            $workerId = $record['worker']->worker_id;

            $vaultData = $this->getVaultDataService->getVaultData($workerId, "F");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);

            $data['user'] = DB::table('Worker.main_worker_forms as wfm')
                ->where('wfm.worker_id', $workerId)
                ->select('wfm.status')
                ->first();

            $record['worker'] = $workerValue = session()->get('worker');

            $data['passport'] = $data['getVaultData']['photo'];
            $data['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
            $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
            $data['id'] = DB::table('Worker.worker_id_cards')->where('worker_id', $workerId)->latest()->first();

            $expiry_date = Carbon::parse($data['wmf']->created_at);
            $data['renewal_date'] = Carbon::parse($data['wmf']->renewal_date);
            $renewal_date = Carbon::parse($data['wmf']->renewal_date);
            $daysUntilRenewal = $renewal_date->diffInDays($expiry_date);


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
            $data['current_date'] = now();

            $certificate = WorkerIDCard::where('worker_id', $workerId)->latest()->first();
            if (!$certificate) {
                Alert::toast("ID Card not Generated", 'error');
                return redirect()->route('worker-dashboard');
            }

            $data['idcard'] = $certificate->certificate;
            $data['decodedIdCard'] = base64_decode($data['idcard']);

            return view('worker.pdf.id-card.index', $data);

        } catch (\Exception $e) {
            Alert::toast('An error occurred while generating the ID Card. Please try again.', 'error');
            return redirect()->route('worker-dashboard');
        }
    }

    public function view()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }

        // Get worker data from session
        $record['worker'] = $workerValue = session()->get('worker');
        $workerId = $record['worker']->worker_id;

        // Retrieve data needed for the PDF
        $data['user'] = DB::table('Worker.main_worker_forms as wfm')
            ->where('wfm.worker_id', $workerId)
            ->first();
        $data['gender'] = DB::table('Masterdata.genders')->get();
        $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        $passport = DB::table('Worker.main_worker_documents')
            ->where('worker_id', $workerId)
            ->first()->passport_image;
        $data['emblem'] = Storage::path('/private/emblem/emblem-dark.png');
        $data['logo'] = Storage::path('/private/logo/logo.png');
        // return $data['logo'];
//        $data['passport'] = Storage::path($passport);
        // return $data;

        // Create a new Dompdf instance
        $snappy = new Pdf('C:/xampp/htdocs/Labour/public/assets/wkhtmltopdf/bin/wkhtmltopdf.exe');

        $options = [
            'encoding' => 'UTF-8', // Set encoding to UTF-8
            'enable-local-file-access' => true, // Enable external links
        ];
         // Generate PDF from HTML content
        //  return  view('worker.pdf.id-card.create', $data);
         $html = view('worker.pdf.id-card.create', $data)->render();

         // Generate PDF from HTML content
         $pdfContent = $snappy->getOutputFromHtml($html, $options);

         // Set response headers to indicate PDF content
         return response($pdfContent, 200, [
             'Content-Type' => 'application/pdf',
             'Content-Disposition' => 'inline; filename="id-card.pdf"',
         ]);
    }


}
