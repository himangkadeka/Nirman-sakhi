<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\MainVaultData;
use App\Models\MainWorkerCertificate;
use App\Models\MainWorkerFamily;
use App\Models\MainWorkerForm;
use App\Models\TemporaryWorkerCertificate;
use App\Models\TemporaryWorkerForm;
use App\Models\VaultData;
use App\Models\WorkerApplicationStatus;
use App\Models\WorkerIDCard;
use App\Models\WorkerSubscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\CancelledAppModal;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Exports\WorkerIDCardExport;
use App\Exports\DataUpdateExport;
use App\Exports\WorkerApplicationStatusExport;
use Maatwebsite\Excel\Facades\Excel;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\DB;


class IdCardDataController extends Controller
{
    // public function index()
    // {
    //     $idCards = WorkerIDCard::select('certificate_upload_date', 'id', 'worker_id')->paginate(1);
    //     $count = WorkerIDCard::count();
    //     // return $idCards;
    //     return view('admin.mis-data.id-card-data.index', compact('idCards', 'count'));
    // }




    public function index(Request $request)
    {
        $query = WorkerIDCard::select('certificate_upload_date', 'id', 'worker_id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('worker_id', 'like', "%{$search}%");
        }

        $idCards = $query->paginate(10)->appends(['search' => $request->search]);
        $count = WorkerIDCard::count();

        return view('admin.mis-data.id-card-data.index', compact('idCards', 'count'));
    }

    public function export($type)
    {
        $fileName = 'ABOCWWB Admin Id Card Data.' . $type;

        if ($type === 'pdf') {
            $data = WorkerIDCard::select('worker_id', 'certificate_upload_date')->get();
            $pdf = PDF::loadView('admin.mis-data.id-card-data.export-pdf', compact('data'));
            return $pdf->download($fileName);
        }

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(new WorkerIDCardExport, $fileName); // ✅ No ->header() here
        }

        abort(404, 'Invalid export format.');
    }





    // public function viewData()
    // {
    //     $datas = MainWorkerForm::get();
    //     return view('admin.mis-data.data-update.index', compact('datas'));
    // }
    public function viewData(Request $request)
    {
        $query = MainWorkerForm::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('ack_no', 'ILIKE', "%{$search}%")
                    ->orWhere('worker_id', 'ILIKE', "%{$search}%");
            });
        }

        $datas = $query->orderBy('id', 'desc')->paginate(10)->appends(['search' => $request->search]);
        $count = MainWorkerForm::count();

        return view('admin.mis-data.data-update.index', compact('datas', 'count'));
    }


    public function exportviewData($type)
    {
        $fileName = 'ABOCWWB Admin Data Update.' . $type;

        if ($type === 'pdf') {
            $data = MainWorkerForm::select('worker_id', 'ack_no', 'office_id', 'application_receiver_user_id', 'application_sender_user_id', 'id_card', 'status', 'status', 'rtps_trans_id', 'created_at')->get();
            $pdf = PDF::loadView('admin.mis-data.data-update.export-pdf', compact('data'));
            return $pdf->download($fileName);
        }

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(new DataUpdateExport, $fileName); // ✅ No ->header() here
        }

        abort(404, 'Invalid export format.');
    }

    public function editFamilyDetails($id)
    {
        $worker = MainWorkerForm::where('id', $id)->first();
        $datas = MainWorkerFamily::where('worker_id', $worker->worker_id)->paginate(10);
        return view('admin.mis-data.data-update.view-family-details', compact('datas', 'worker'));
    }

    public function editCertificateDetails($id)
    {
        $worker = MainWorkerForm::where('id', $id)->first();
        $datas = MainWorkerCertificate::where('worker_id', $worker->worker_id)->paginate(10);
        return view('admin.mis-data.data-update.view-certificate-details', compact('datas', 'worker'));
    }

    public function deleteFamilyDetails($id)
    {
        $workerFamily = MainWorkerFamily::where('id', $id)->first();
        if ($workerFamily) {
            $workerFamily->delete();
            Alert::toast("Family Details Deleted Successfully", 'success');
            return back();
        } else {
            Alert::toast("Something went Wrong", 'error');
            return back();
        }
    }

    public function deleteCertificateDetails($id)
    {
        $workerCertificate = MainWorkerCertificate::where('id', $id)->first();
        if ($workerCertificate) {
            $workerCertificate->delete();
            Alert::toast("Certificate Details Deleted Successfully", 'success');
            return back();
        } else {
            Alert::toast("Something went Wrong", 'error');
            return back();
        }
    }

    // public function ViewApplicationData()
    // {
    //     $dataA = WorkerApplicationStatus::paginate(5);
    //     return view('admin.mis-data.data-update.app-history', compact('dataA'));
    // }
    public function ViewApplicationData(Request $request)
    {
        $search = trim($request->search);

        $query = WorkerApplicationStatus::query();

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('worker_id', 'ILIKE', "%{$search}%")
                    ->orWhere('ack_no', 'ILIKE', "%{$search}%")
                    ->orWhere('application_no', 'ILIKE', "%{$search}%");

            });
        }

        /*
        |--------------------------------------------------------------------------
        | One Latest Record Per Worker
        |--------------------------------------------------------------------------
        */

        $groupedApplications = $query
            ->select(
                'worker_id',
                DB::raw('MAX(id) as latest_id'),
                DB::raw('COUNT(*) as total_movements')
            )
            ->groupBy('worker_id')
            ->orderByRaw('MAX(id) DESC')
            ->paginate(20);

        /*
        |--------------------------------------------------------------------------
        | Latest Records
        |--------------------------------------------------------------------------
        */

        $latestRecords = WorkerApplicationStatus::whereIn(
            'id',
            $groupedApplications->pluck('latest_id')
        )
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | History Per Worker
        |--------------------------------------------------------------------------
        */

        $historyData = [];

        foreach ($groupedApplications as $app) {

            $historyData[$app->worker_id] =
                WorkerApplicationStatus::where(
                    'worker_id',
                    $app->worker_id
                )
                    ->orderBy('id', 'ASC')
                    ->get();
        }

        return view(
            'admin.mis-data.data-update.app-history',
            compact(
                'groupedApplications',
                'latestRecords',
                'historyData'
            )
        );
    }


    public function exportviewApplicationData($type)
    {
        $fileName = 'ABOCWWB Admin App History.' . $type;

        if ($type === 'pdf') {
            $data = WorkerApplicationStatus::select('worker_id', 'ack_no', 'sender_role_id', 'sender_office_id', 'sender_user_id', 'application_from_user', 'application_receiver_user_id', 'application_receiver_role_id', 'application_status')->get();
            $pdf = PDF::loadView('admin.mis-data.data-update.WorkerApplicationStatus-export-pdf', compact('data'));
            return $pdf->download($fileName);
        }

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(new WorkerApplicationStatusExport, $fileName); // ✅ No ->header() here
        }

        abort(404, 'Invalid export format.');
    }
    // public function index(Request $request)
    // {
    //     $query = WorkerIDCard::select('certificate_upload_date', 'id', 'worker_id');

    //     if ($request->filled('search')) {
    //         $search = $request->input('search');
    //         $query->where('worker_id', 'like', "%{$search}%");
    //     }

    //     $idCards = $query->paginate(10)->appends(['search' => $request->search]);
    //     $count = WorkerIDCard::count();

    //     return view('admin.mis-data.id-card-data.index', compact('idCards', 'count'));
    // }
    public function getTokenData()
    {
        return view('admin.mis-data.data-update.search-token');
    }

    public function searchTokenData(Request $request)
    {
        $request->validate([
            'ack_no' => 'required|string'
        ]);

        $ackNo = $request->input('ack_no');
        $worker = MainWorkerForm::where('ack_no', $ackNo)->with('vaultDataToken')->first();


        if ($worker && $worker->vaultToken) {
            return response()->json(['vault_token' => $worker->vaultToken]);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }


    public function editData($id)
    {
        $data = MainWorkerForm::where('id', $id)->first();
        // return $data;
        return view('admin.mis-data.data-update.edit', compact('data'));
    }

    public function editApplicationData($id)
    {
        $data = WorkerApplicationStatus::where('id', $id)->first();
        // return $data;
        return view('admin.mis-data.data-update.edit-app', compact('data'));
    }

    public function updateApplicationData(Request $request)
    {
        // return $request->all();
        $validator = Validator::make(
            $request->all(),
            [
                'active_status' => 'required',

            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            WorkerApplicationStatus::where('worker_id', $request->worker_id)->update([
                'application_receiver_user_id' => $request->application_receiver_user_id,
                'application_receiver_role_id' => $request->application_receiver_role_id,

            ]);
        } catch (Exception $e) {
            return redirect()->route('admin.dataupdate.app-history')->with('error', 'Failed to update worker data.');
        }

        // Redirect back with success message
        return redirect()->route('admin.dataupdate.app-history')->with('success', 'Worker data updated successfully.');
    }

    public function updateData(Request $request)
    {
        // return $request->all();
        $validator = Validator::make(
            $request->all(),
            [
                'active_status' => 'required',

            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            MainWorkerForm::where('worker_id', $request->worker_id)->update([
                'active_status' => $request->active_status,
                'payment_status' => $request->payment_status,
                'subscription_validity_date' => $request->subscription_validity_date,
                'last_registration_date' => $request->last_registration_date,
                'id_card_expiry_date' => $request->id_card_expiry_date,
                'renewal_date' => $request->renewal_date,
                'date_of_retirement' => $request->date_of_retirement,
                'application_receiver_user_id' => $request->application_receiver_user_id,
                'application_sender_user_id' => $request->application_sender_user_id
            ]);
        } catch (Exception $e) {
            return redirect()->route('admin.dataupdate.index')->with('error', 'Failed to update worker data.');
        }

        // Redirect back with success message
        return redirect()->route('admin.dataupdate.index')->with('success', 'Worker data updated successfully.');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'worker_id' => 'required|exists:pgsql.Worker.worker_id_cards,worker_id'
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                WorkerIDCard::where('worker_id', $request->worker_id)->delete();
                Alert::toast("Id Card Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }


    public function updateStatus($userId)
    {
        $data = MainWorkerForm::where('application_receiver_user_id', $userId)->where('status', 'O')->update(
            [
                'status' => 'C'
            ]
        );
        WorkerApplicationStatus::where('application_receiver_user_id', $userId)->where('application_status', 'O')->update(
            [
                'application_status' => 'C'
            ]
        );


        return "Data Updated Successfully";
    }


    public function searchVaultTokenWithWorkerID(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|string'
        ]);

        $workerId = $request->input('worker_id');
        $mainVaultData = MainVaultData::where('worker_id', $workerId)->pluck('vaultToken')->first();
        $vaultData = VaultData::where('worker_id', $workerId)->pluck('vault_token')->first();


        if ($mainVaultData && $vaultData) {
            return response()->json(['main_vault_token' => $mainVaultData, 'vault_token' => $vaultData]);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function searchMainVaultTokenWithWorkerID(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|string'
        ]);

        $workerId = $request->input('worker_id');
        $mainVaultData = MainVaultData::where('worker_id', $workerId)->pluck('vaultToken')->first();


        if ($mainVaultData) {
            return response()->json(['main_vault_token' => $mainVaultData]);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function searchAndDeleteMainVaultToken(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|string'
        ]);

        $workerId = $request->input('worker_id');
        $mainVaultData = MainVaultData::where('worker_id', $workerId)->first();

        if ($mainVaultData) {
            $vaultToken = $mainVaultData->vaultToken;
            $mainVaultData->delete();
            return response()->json([
                'message' => 'Vault token deleted successfully',
                'deleted_vault_token' => $vaultToken
            ]);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }



    public function getWorkerIdByPhoneNumber(Request $request)
    {
        $request->validate([
            'phone_no' => 'required|string'
        ]);

        $phoneNumber = $request->input('phone_no');
        $workerIds = TemporaryWorkerForm::where('phone_no', $phoneNumber)->pluck('worker_id')->toArray();

        if (!empty($workerIds)) {
            return response()->json(['worker_ids' => $workerIds]);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function getSubscriptions(Request $request)
    {
        $request->validate([
            'worker_id' => 'nullable|string',
            'id_card_no' => 'nullable|string'
        ]);

        $workerId = $request->input('worker_id');
        $idCardNumber = $request->input('id_card_no');

        $query = WorkerSubscription::query();

        if ($workerId) {
            $query->where('worker_id', $workerId);
        }

        if ($idCardNumber) {
            $query->orWhere('id_card_no', $idCardNumber);
        }

        $subscriptions = $query->get();

        if ($subscriptions->isNotEmpty()) {
            return response()->json(['subscriptions' => $subscriptions]);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function getWorkerIdVaultToken(Request $request)
    {
        $request->validate([
            'vault_token' => 'required|string'
        ]);

        $vaultToken = $request->input('vault_token');
        $workerId = VaultData::where('vault_token', $vaultToken)->pluck('worker_id')->first();


        if ($vaultToken && $workerId) {
            return response()->json(['worker_id' => $workerId, 'vault_token' => $vaultToken]);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function getRejected(Request $request)
    {


        $count = CancelledAppModal::count();


        $data = CancelledAppModal::with('workerStatus')->get();


        return view('admin.mis-data.rejected-list.index', compact('data', 'count'));
    }
}
