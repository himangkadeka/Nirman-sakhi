<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerForm;
use App\Models\MigrantWorkerData;
use App\Models\VaultVerification;
use App\Services\DitecService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BulkVaultDataController extends Controller
{
    protected $ditecService;

    public function __construct(DitecService $ditecService)
    {
        $this->ditecService = $ditecService;
    }

    // public function performVerification($limit, $offset)
    // {
    //     $data = MainWorkerForm::select('worker_id', 'vaultToken', 'vaultPassKey')
    //         ->where('status','F')
    //         ->limit($limit)
    //         ->offset($offset)
    //         ->orderBY('id', 'asc')
    //         ->get();
    //     $securityController = new SecurityController();
    //     $key1 = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->first()->value;
    //     $bulkRequestItems = [];

    //     foreach ($data as $item) {
    //         $vaultTokenMain = $securityController->decrypt($item->vaultToken, $key1);
    //         $vaultPasskeyMain = $securityController->decrypt($item->vaultPassKey, $key1);
    //         $bulkRequestItems[] = [
    //             'vaultToken'   => $vaultTokenMain,
    //             'vaultPassKey' => $vaultPasskeyMain,
    //             // We will generate the transactionId inside the Service to ensure uniqueness/prefixing
    //         ];
    //     }
    //     // return $bulkRequestItems;



    //     try {
    //         // 2. Call the service
    //         $response = $this->ditecService->sendBulkVaultData($bulkRequestItems);

    //         // 3. Handle Response
    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $response
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    // public function performVerification($limit, $offset)
    // {
    //     $data = MainWorkerForm::select('worker_id', 'vaultToken', 'vaultPassKey')
    //         ->limit($limit)
    //         ->offset($offset)
    //         ->orderBy('id', 'asc')
    //         ->get();

    //     $securityController = new SecurityController();
    //     $key1 = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->first()->value;

    //     $bulkRequestItems = [];
    //     foreach ($data as $item) {
    //         $bulkRequestItems[] = [
    //             'worker_id'    => $item->worker_id,
    //             'vaultToken'   => $securityController->decrypt($item->vaultToken, $key1),
    //             'vaultPassKey' => $securityController->decrypt($item->vaultPassKey, $key1),
    //         ];
    //     }

    //     try {
    //         // Call the service (Assuming Service logic from previous response is implemented)
    //         $result = $this->ditecService->sendBulkVaultData($bulkRequestItems);
    //         return $result;
    //         $apiData = $result['api_response'];
    //         $mapping = $result['mapping'];

    //         $resultsLog = [];

    //         foreach ($apiData as $resItem) {
    //             $txnId = $resItem['transactionID'];
    //             $workerId = $mapping[$txnId] ?? 'unknown';
    //             $encData = $resItem['encResponseData'];

    //             // 1. Decrypt
    //             $decryptedData = $this->ditecService->decryptResponse($encData);

    //             // 2. Logic for Status & Retry
    //             // If API returns "Vault Data Not Exist.", we mark it as 'retry'
    //             $status = ($decryptedData === "Vault Data Not Exist.") ? 'retry' : 'verified';

    //             // 3. Save to the NEW table
    //             VaultVerification::create([
    //                 'worker_id'         => $workerId,
    //                 'transaction_id'    => $txnId,
    //                 'enc_response_data' => $encData,
    //                 'decrypted_data'    => $decryptedData,
    //                 'status'            => $status,
    //                 'api_response_time' => $resItem['responseDateTime']
    //             ]);

    //             $resultsLog[] = [
    //                 'worker_id' => $workerId,
    //                 'status'    => $status
    //             ];
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Data processed and saved to VaultVerification table.',
    //             'processed' => $resultsLog
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function performVerification($limit, $offset)
    {
        $data = MainWorkerForm::select('worker_id', 'vaultToken', 'vaultPassKey')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('vault_verifications')
                    ->whereColumn('vault_verifications.worker_id', 'main_worker_forms.worker_id')
                    ->where('status', 'verified'); // Skip if already verified
            })
            ->limit($limit)
            ->offset($offset)
            ->orderBy('id', 'asc')
            ->where('status', 'F')
            ->get();
        if ($data->count() == 0) {
            return "No Data Available";
        }

        $securityController = new SecurityController();
        $key1 = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->first()->value;

        $bulkRequestItems = [];
        foreach ($data as $item) {
            $bulkRequestItems[] = [
                'worker_id'    => $item->worker_id,
                'vaultToken'   => $securityController->decrypt($item->vaultToken, $key1),
                'vaultPassKey' => $securityController->decrypt($item->vaultPassKey, $key1),
            ];
        }


        try {
            $result = $this->ditecService->sendBulkVaultData($bulkRequestItems);

            // Fix: Access keys from the array returned by service
            $apiData = $result['api_response'];
            $mapping = $result['mapping'];
            // return $apiData;

            foreach ($apiData as $resItem) {
                // Note: API returns 'transactionID' (capital ID)
                $txnId = $resItem['transactionID'];
                $workerId = $mapping[$txnId] ?? null;
                $encData = $resItem['encResponseData'];

                if (!$workerId) continue;

                // 1. Decrypt
                $decryptedData = $this->ditecService->decryptResponse($encData);

                // 2. Determine Status
                $status = ($decryptedData === "Vault Data Not Exist.") ? 'retry' : 'verified';

                // 3. Insert into the NEW table
                VaultVerification::updateOrCreate(
                    ['worker_id' => $workerId],
                    [
                        'transaction_id'    => $txnId,
                        'enc_response_data' => $encData,
                        'decrypted_data'    => $decryptedData,
                        'status'            => $status,
                        'api_response_time' => $resItem['responseDateTime']
                    ]
                );
            }

            $retryCount = VaultVerification::where('status', 'retry')->count();

            // 2. Count workers that have NEVER been attempted (not in the verification table at all)
            $neverAttemptedCount = MainWorkerForm::whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('vault_verifications')
                    ->whereColumn('vault_verifications.worker_id', 'main_worker_forms.worker_id');
            })->count();

            // 3. Count total successfully verified for context
            $verifiedCount = VaultVerification::where('status', 'verified')->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Processed ' . count($apiData) . ' records in this batch.',
                'data' => [
                    'batch_processed'    => count($apiData),
                    'total_verified'     => $verifiedCount,
                    'remaining_retries'  => $retryCount,
                    'never_attempted'    => $neverAttemptedCount,
                    'total_left_to_do'   => $retryCount + $neverAttemptedCount
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function getData(Request $request)
    {
        // Fetch only verified records with worker details
        $query = VaultVerification::whereIn('status', ['verified_local'])
            ->with('worker:worker_id,phone_no,id_card'); // Get specific columns from worker table

        // Handle Pagination (Batch-wise)
        $data = $query->latest()->paginate(50);

        // Provide office list for export filter dropdown
        $officeDetails = DB::table('Masterdata.offices')
            ->where('status', 1)
            ->orderBy('office_name')
            ->get();

        return view('admin.mis-data.vault-data.index', compact('data', 'officeDetails'));
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'vault_export_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Worker ID', 'Phone', 'ID Card', 'Vault UID', 'Name', 'DOB', 'Gender', 'Address', 'Office'];

        // Read filters from query
        $office = $request->query('office');
        $limit = $request->query('limit');
        $offset = $request->query('offset');

        $callback = function () use ($office, $limit, $offset) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Worker ID', 'Phone', 'ID Card', 'Vault UID', 'Name', 'DOB', 'Gender', 'Address', 'Office']);

            $query = VaultVerification::where('status', 'verified')->with('worker');

            if ($office) {
                $query->whereHas('worker', function ($q) use ($office) {
                    $q->where('office_id', $office);
                });
            }

            if ($limit) {
                $query->limit(intval($limit));
            }

            if ($offset) {
                $query->offset(intval($offset));
            }

            // Iterate results and stream
            $records = $query->orderBy('id')->get();
            foreach ($records as $row) {
                $details = $row->vault_details; // Uses the Accessor
                fputcsv($file, [
                    $row->worker_id,
                    $row->worker->phone_no ?? 'N/A',
                    $row->worker->id_card ?? 'N/A',
                    $details->uID ?? '',
                    $details->name ?? '',
                    $details->dob ?? '',
                    $details->gender ?? '',
                    ($details->buildingName ?? '') . ' ' . ($details->district ?? ''),
                    $row->worker->office_id ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }



    // Migrant

    public function performVerificationMigrant($limit, $offset)
    {
        // return MainWorkerBasicDetail::count();

        $data = MainWorkerForm::select('worker_id', 'vaultToken', 'vaultPassKey')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('Worker.migrant_worker_data as mw')
                    ->whereColumn('mw.worker_id', 'Worker.main_worker_forms.worker_id')
                    // ->where('mw.status', 'verified'); // ✅ fix here
                    ->whereNotIn('enc_response_data', ['', ' ']);
            })
            ->whereHas('basicDetail', function ($query) {
                $query->where('resident_type', 'rao');
            })
            // ->where('status', 'F')
            ->orderBy('id', 'asc')
            ->limit($limit)
            ->offset($offset)
            ->get();
        if ($data->count() == 0) {
            return "No Data Available";
        }

        $securityController = new SecurityController();
        $key1 = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->first()->value;

        $bulkRequestItems = [];
        foreach ($data as $item) {
            $bulkRequestItems[] = [
                'worker_id'    => $item->worker_id,
                'vaultToken'   => $securityController->decrypt($item->vaultToken, $key1),
                'vaultPassKey' => $securityController->decrypt($item->vaultPassKey, $key1),
            ];
        }


        try {
            $result = $this->ditecService->sendBulkVaultData($bulkRequestItems);

            // Fix: Access keys from the array returned by service
            $apiData = $result['api_response'];
            $mapping = $result['mapping'];
            // return $apiData;

            foreach ($apiData as $resItem) {
                // Note: API returns 'transactionID' (capital ID)
                $txnId = $resItem['transactionID'];
                $workerId = $mapping[$txnId] ?? null;
                $encData = $resItem['encResponseData'];

                if (!$workerId) continue;

                // 1. Decrypt
                $decryptedData = $this->ditecService->decryptResponse($encData);

                // 2. Determine Status
                $status = ($decryptedData === "Vault Data Not Exist.") ? 'retry' : 'verified';

                // 3. Insert into the NEW table
                MigrantWorkerData::updateOrCreate(
                    ['worker_id' => $workerId],
                    [
                        'transaction_id'    => $txnId,
                        'enc_response_data' => $encData,
                        'decrypted_data'    => $decryptedData,
                        'status'            => $status,
                        'api_response_time' => $resItem['responseDateTime']
                    ]
                );
            }

            $retryCount = MigrantWorkerData::where('enc_response_data',' ')->count();

            // 2. Count workers that have NEVER been attempted (not in the verification table at all)
            $neverAttemptedCount = MainWorkerForm::whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('Worker.migrant_worker_data as mw')
                    ->whereColumn('mw.worker_id', 'Worker.main_worker_forms.worker_id');
            })->count();

            // 3. Count total successfully verified for context
            $verifiedCount = MigrantWorkerData::whereNotNull('enc_response_data')
            ->whereNotIn('enc_response_data', ['', ' '])->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Processed ' . count($apiData) . ' records in this batch.',
                'data' => [
                    'batch_processed'    => count($apiData),
                    'total_verified'     => $verifiedCount,
                    'remaining_retries'  => $retryCount,
                    'never_attempted'    => $neverAttemptedCount,
                    'total_left_to_do'   => $retryCount + $neverAttemptedCount
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function getMigrantData(Request $request)
    {
        // Fetch only verified records with worker details
        // return MigrantWorkerData::get();
        $query = MigrantWorkerData::whereNotNull('enc_response_data')
            ->whereNotIn('enc_response_data', ['', ' '])
            ->with('worker:worker_id,phone_no,id_card'); // Get specific columns from worker table

        // Handle Pagination (Batch-wise)
        $data = $query->latest()->paginate(50);

        // Provide office list for export filter dropdown
        $officeDetails = DB::table('Masterdata.offices')
            ->where('status', 1)
            ->orderBy('office_name')
            ->get();

        return view('admin.mis-data.vault-data.index-migrant', compact('data', 'officeDetails'));
    }

    public function exportMigrantCsv(Request $request)
    {
        $fileName = 'migrant_vault_export_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Worker ID', 'Phone', 'ID Card', 'Vault UID', 'Name', 'DOB', 'Gender', 'Address', 'Office'];

        // Read filters from query
        $office = $request->query('office');
        $limit = $request->query('limit');
        $offset = $request->query('offset');

        $callback = function () use ($office, $limit, $offset) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Worker ID', 'Phone', 'ID Card', 'Vault UID', 'Name', 'DOB', 'Gender', 'Address', 'Office']);

            $query = MigrantWorkerData::where('enc_response_data','!=', ' ')->with('worker');

            // if ($office) {
            //     $query->whereHas('worker', function ($q) use ($office) {
            //         $q->where('office_id', $office);
            //     });
            // }

            // if ($limit) {
            //     $query->limit(intval($limit));
            // }

            // if ($offset) {
            //     $query->offset(intval($offset));
            // }

            // Iterate results and stream
            $records = $query->orderBy('id')->get();
            foreach ($records as $row) {
                $details = $row->vault_details; // Uses the Accessor
                fputcsv($file, [
                    $row->worker_id,
                    $row->worker->phone_no ?? 'N/A',
                    $row->worker->id_card ?? 'N/A',
                    $details->uID ?? '',
                    $details->name ?? '',
                    $details->dob ?? '',
                    $details->gender ?? '',
                    ($details->buildingName ?? '') . ' ' . ($details->district ?? ''),
                    $row->worker->office_id ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
