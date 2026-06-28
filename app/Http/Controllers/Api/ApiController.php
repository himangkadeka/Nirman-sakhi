<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\Bank;
use App\Models\CancelledAppModal;
use App\Models\KeyValue;
use App\Models\MainVaultData;
use App\Models\MainWorkerAddress;
use App\Models\MainWorkerBank;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerCertificate;
use App\Models\MainWorkerDocument;
use App\Models\MainWorkerFamily;
use App\Models\MainWorkerForm;
use App\Models\MainWorkerScheme;
use App\Models\RevertBack;
use App\Models\TemporaryWorkerAddress;
use App\Models\TemporaryWorkerBank;
use App\Models\TemporaryWorkerBasicDetail;
use App\Models\TemporaryWorkerCertificate;
use App\Models\TemporaryWorkerDocument;
use App\Models\TemporaryWorkerFamily;
use App\Models\TemporaryWorkerForm;
use App\Models\TemporaryWorkerScheme;
use App\Models\User;
use App\Models\VaultData;
use App\Models\WorkerApplicationStatus;
use App\Services\AesCipher;
use App\Services\GetVaultDataService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    protected $getVaultDataService;
    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService = $getVaultDataService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function destroy($id)
    {
        //
    }


    public function updateIfscCodeTemp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offset' => 'required',
            'limit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        try {
            DB::beginTransaction();
            $data = TemporaryWorkerBank::select('ifsc_pk')->limit($request->limit)       // change this to your desired limit
                ->offset($request->offset)->get();
            // return $data;
            foreach ($data as $item) {
                $ifsc_code = Bank::where('id', $item->ifsc_pk)->first();
                // return $ifsc_code;
                if ($ifsc_code) {
                    TemporaryWorkerBank::where('ifsc_pk', $item->ifsc_pk)->update([
                        'ifsc_code' => $ifsc_code->ifsc,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['error' => 'IFSC code not found'], 404);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function updateIfscCodeMain(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offset' => 'required',
            'limit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        try {
            DB::beginTransaction();
            $data = MainWorkerBank::select('ifsc_pk')->limit($request->limit)       // change this to your desired limit
                ->offset($request->offset)->get();
            // return $data;
            foreach ($data as $item) {
                $ifsc_code = Bank::where('id', $item->ifsc_pk)->first();

                if ($ifsc_code) {
                    MainWorkerBank::where('ifsc_pk', $item->ifsc_pk)->update([
                        'ifsc_code' => $ifsc_code->ifsc,
                    ]);
                    // return $ifsc_code;
                } else {
                    DB::rollBack();
                    return response()->json(['error' => 'IFSC code not found'], 404);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function SearchPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ack_no' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        $main_worker_forms = MainWorkerForm::where('ack_no', $request->ack_no)->first();
        $temporary_worker_forms = TemporaryWorkerForm::where('phone_no', $main_worker_forms->phone_no)->get();
        $users = User::where('phone', $main_worker_forms->phone_no)->get();

        return response()->json([
            'main_worker_forms' => $main_worker_forms,
            'temporary_worker_forms' => $temporary_worker_forms,
            'users' => $users
        ]);
    }


    public function UpdateVaultData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|integer',
            'offset' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        try {
            DB::beginTransaction();
            $data = TemporaryWorkerForm::select('worker_id', 'vaultToken')
                ->limit($request->limit)
                ->offset($request->offset)
                ->orderBY('id', 'asc')
                ->get();
            $securityController = new SecurityController();
            $key1 = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->first()->value;

            foreach ($data as $item) {
                $vaultTokenMain = $securityController->decrypt($item->vaultToken, $key1);
                VaultData::Create([
                    'worker_id' => $item->worker_id,
                    'vault_token' => $vaultTokenMain
                ]);
            }

            DB::commit();
            return response()->json(
                [
                    'message' => 'Data saved successfully',
                    'vaultData' => VaultData::count(),
                    'temporaryWorkerForm' => TemporaryWorkerForm::count()
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function UpdateVaultDataMain(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|integer',
            'offset' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        try {
            DB::beginTransaction();
            $data = MainWorkerForm::select('worker_id', 'vaultToken')
                ->limit($request->limit)
                ->offset($request->offset)
                ->orderBy('id', 'asc')
                ->get();
            $securityController = new SecurityController();
            $key1 = KeyValue::where('key', 'SECRET_KEY_TOKEN')->first()->value;

            foreach ($data as $item) {
                $vaultTokenMain = $securityController->decrypt($item->vaultToken, $key1);
                MainVaultData::Create([
                    'worker_id' => $item->worker_id,
                    'vaultToken' => $vaultTokenMain
                ]);
            }

            DB::commit();
            return response()->json(
                [
                    'message' => 'Data saved successfully',
                    'vaultData' => MainVaultData::count(),
                    'temporaryWorkerForm' => MainWorkerForm::count()
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function updateRejectData()
    {
        $main_worker_forms = MainWorkerForm::where('status', 'D')->get();


        try {
            foreach ($main_worker_forms as $main_worker_form) {
                CancelledAppModal::updateOrCreate(
                    [
                        'worker_id' => $main_worker_form->worker_id
                    ],
                    [
                        'phone_no' => $main_worker_form->phone_no,
                        'district' => $main_worker_form->district,
                        'status' => $main_worker_form->status,
                        'office_id' => $main_worker_form->office_id,
                        'ack_no' => $main_worker_form->ack_no,
                        'application_no' => $main_worker_form->application_no,
                        'already_registered' => $main_worker_form->already_registered,
                        'payment_status' => $main_worker_form->payment_status,
                        'vaultToken' => $main_worker_form->vaultToken,
                        'vaultPassKey' => $main_worker_form->vaultPassKey,
                        'remarks' => $main_worker_form->remarks
                    ]
                );

                MainWorkerForm::where('worker_id', $main_worker_form->worker_id)->delete();
                MainWorkerBasicDetail::where('worker_id', $main_worker_form->worker_id)->delete();
                MainWorkerAddress::where('worker_id', $main_worker_form->worker_id)->delete();
                MainWorkerBank::where('worker_id', $main_worker_form->worker_id)->delete();
                MainWorkerFamily::where('worker_id', $main_worker_form->worker_id)->delete();
                MainWorkerCertificate::where('worker_id', $main_worker_form->worker_id)->delete();
                MainWorkerScheme::where('worker_id', $main_worker_form->worker_id)->delete();
                MainWorkerDocument::where('worker_id', $main_worker_form->worker_id)->delete();
                MainVaultData::where('worker_id', $main_worker_form->worker_id)->delete();
                TemporaryWorkerForm::where('worker_id', $main_worker_form->worker_id)->delete();
                TemporaryWorkerBasicDetail::where('worker_id', $main_worker_form->worker_id)->delete();
                TemporaryWorkerAddress::where('worker_id', $main_worker_form->worker_id)->delete();
                TemporaryWorkerBank::where('worker_id', $main_worker_form->worker_id)->delete();
                TemporaryWorkerFamily::where('worker_id', $main_worker_form->worker_id)->delete();
                TemporaryWorkerCertificate::where('worker_id', $main_worker_form->worker_id)->delete();
                TemporaryWorkerScheme::where('worker_id', $main_worker_form->worker_id)->delete();
                TemporaryWorkerDocument::where('worker_id', $main_worker_form->worker_id)->delete();
                VaultData::where('worker_id', $main_worker_form->worker_id)->delete();
            }
            return "SUCCESS";
        } catch (Exception $e) {
            return $e;
        }
    }


    public function removeVault()
    {
        $revert_backs = RevertBack::get();

        foreach ($revert_backs as $revert_back) {
            if (MainVaultData::where('worker_id', $revert_back->worker_id)->exists()) {
                MainVaultData::where('worker_id', $revert_back->worker_id)->delete();
            }
        }

        return response()->json([
            'status' => true
        ]);
    }


    public function updatePhone(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'phone_number_old' => 'required',
                'phone_number_new' => 'required'
            ]
        );

        try {
            DB::beginTransaction();
            $temp = TemporaryWorkerForm::where('phone_no', $request->phone_number_old)->exists();
            if ($temp) {
                $data = TemporaryWorkerForm::where('phone_no', $request->phone_number_old)->first();
                $data->phone_no = $request->phone_number_new;
                $data->save();
                $mainWorker_data = MainWorkerForm::where('phone_no', $request->phone_number_old);
                if ($mainWorker_data->exists()) {
                    $mainWorker_data1 = $mainWorker_data->first();
                    $mainWorker_data1->phone_no = $request->phone_number_new;
                    $mainWorker_data1->save();
                    if (User::where('username', $mainWorker_data1->id_card)->exists()) {
                        $user = User::where('username', $mainWorker_data1->id_card)->first();
                        $user->phone = $request->phone_number_new;
                        $user->save();
                    } else {
                        DB::commit();
                        // return "Not Found in User";
                    }
                } else {
                    DB::commit();
                    // return "Not Found in Main Worker";
                }
            }
            if (RevertBack::where('phone_no', $request->phone_number_old)->exists()) {
                $revert_back = RevertBack::where('phone_no', $request->phone_number_old)->first();
                $revert_back->phone_no = $request->phone_number_new;
                $revert_back->save();
            }

            DB::commit();
            return "Updated";
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function getApplicationCount()
    {
        $mainNew = MainWorkerForm::count();
        $temp_data = TemporaryWorkerForm::count();

        $temp_onboarding = TemporaryWorkerForm::where('already_registered', 1)->count();
        $temp_new = TemporaryWorkerForm::where('already_registered', null)->count();

        $countRejected = CancelledAppModal::count();
        $countPending = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->count();
        $countApproved = MainWorkerForm::where('status', 'F')->count();

        $countReverted = RevertBack::where('status', 'G')->count();

        $countForwarded = MainWorkerForm::where('status', 'C')->count();
        $rowCount = $mainNew + $countReverted;

        $onboarding = MainWorkerForm::where('already_registered', 1)->count();
        $resubmit_count = MainWorkerForm::where('resubmit_status', 1)->count();
        $rowCount = $mainNew + $countReverted - $resubmit_count;
        $totalPendingOnboarding = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->where('already_registered', 1)->count();
        $approveOnboarding = MainWorkerForm::where('status', 'F')->where('already_registered', 1)->count();
        $onboardingRejected = CancelledAppModal::where('already_registered', 1)->count();
        $onboardingReverted = RevertBack::where('status', 'G')->where('already_registered', 1)->count();
        $totalOnboarding = $onboarding + $onboardingReverted;

        $New = MainWorkerForm::where('already_registered', null)->count();
        $totalPendingNew = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->where('already_registered', null)->count();
        $approveNew = MainWorkerForm::where('status', 'F')->where('already_registered', null)->count();
        $newRejected = CancelledAppModal::where('already_registered', null)->count();
        $newReverted = RevertBack::where('status', 'G')->where('already_registered', null)->count();
        $totalNew = $New + $newReverted;

        // $data = MainWorkerForm::get();
        return response()->json([
            'Total Applications Received' => $rowCount,
            'Onboarding Applications Received' => $totalOnboarding,
            'New Applications Received' => $totalNew,
            'Total Applications Pending' => $countPending,
            'Onboarding Applications Pending' => $totalPendingOnboarding,
            'New Applications Pending' => $totalPendingNew,
            'No of Applications Approved' => $countApproved,
            'Onboarding Applications Approved' => $approveOnboarding,
            'New Applications Approved' => $approveNew,
            'Total Applications Rejected' => $countRejected,
            'Onboarding Applications Rejected' => $onboardingRejected,
            'New Applications Rejected' => $newRejected,
            'Total Applications Reverted' => $countReverted,
            'Onboarding Applications Reverted' => $onboardingReverted,
            'New Applications Reverted' => $newReverted,
            'Resubmitted Applications' => $resubmit_count,
            'Temporary Applications' => $temp_data,
            'Temporary New Applications' => $temp_new,
            'Temporary Onbarding Applications' => $temp_onboarding
        ]);
    }


    public function encryptDataVault(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'passkey' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        try {
            $securityController = new SecurityController();
            $key1 = DB::table('Masterdata.key_values')->where('key', 'SECRET_KEY_TOKEN')->first()->value;
            $vaultToken = $request->token;
            $vaultPassKey = $request->passkey;

            $string = '{"vaultToken":"' . $vaultToken . '","vaultPassKey":"' . $vaultPassKey . '"}';
            $key = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
            $licenceKeyEnc = KeyValue::where('key', 'LICENSE_KEY')->first()->value;
            $licenceKey = $securityController->decrypt($licenceKeyEnc, $key);

            $encrypted = AesCipher::encrypt($licenceKey, $string);
            return $encrypted->getData();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function decryptDataVault(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'encResponseData' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        try {
            $securityController = new SecurityController();
            $key = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->first()->value;
            $licenceKeyEnc = KeyValue::where('key', 'LICENSE_KEY')->first()->value;
            $licenceKey = $securityController->decrypt($licenceKeyEnc, $key);
             return $vaultData = AesCipher::decrypt($licenceKey, $request->encResponseData);
            // \
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateAlreadyReg(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'limit' => 'required|integer',
                'offset' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 400);
            }
            $limit = $request->input('limit', 100);
            $offset = $request->input('offset', 0);

            if (!is_numeric($limit) || $limit <= 0) {
                return response()->json([
                    'error' => 'Invalid limit value',
                    'message' => 'Limit must be a positive integer.'
                ], 400);
            }
            if (!is_numeric($offset) || $offset < 0) {
                return response()->json([
                    'error' => 'Invalid offset value',
                    'message' => 'Offset must be a non-negative integer.'
                ], 400);
            }

            $totalUpdated = 0;

            $mainForms = MainWorkerForm::whereNotNull('already_registered')
                ->select('worker_id', 'already_registered')
                ->orderBy('worker_id')
                ->offset($offset)
                ->limit($limit)
                ->get();

            $totalProcessed = count($mainForms);

            if ($totalProcessed === 0) {
                return response()->json([
                    'success' => true,
                    'stats' => [
                        'forms_processed' => 0,
                        'statuses_updated' => 0,
                        'limit_used' => $limit,
                        'offset_used' => $offset,
                        'message' => 'No records found for the given offset and limit.'
                    ]
                ]);
            }

            $workerIds = $mainForms->pluck('worker_id')->toArray();

            $existingStatuses = WorkerApplicationStatus::whereIn('worker_id', $workerIds)
                ->pluck('worker_id')
                ->toArray();

            $updates = [];
            foreach ($mainForms as $form) {
                if (in_array($form->worker_id, $existingStatuses)) {
                    $updates[] = [
                        'worker_id' => $form->worker_id,
                        'already_registered' => $form->already_registered
                    ];
                }
            }

            DB::transaction(function () use ($updates, &$totalUpdated) {
                foreach ($updates as $update) {
                    $affected = WorkerApplicationStatus::where('worker_id', $update['worker_id'])
                        ->update(['already_registered' => $update['already_registered']]);

                    $totalUpdated += $affected;
                }
            });

            return response()->json([
                'success' => true,
                'stats' => [
                    'forms_processed' => $totalProcessed,
                    'statuses_updated' => $totalUpdated,
                    'limit_used' => $limit,
                    'offset_used' => $offset
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Bulk update failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateOfficeId(Request $request)
    {
        $request->validate([
            'old_office_id' => 'required|integer',
            'new_office_id' => 'required|integer',
        ]);

        $oldOfficeId = $request->old_office_id;
        $newOfficeId = $request->new_office_id;

        // Update MainWorkerForms
        $mainUpdated = MainWorkerForm::where('office_id', $oldOfficeId)
            ->update(['office_id' => $newOfficeId]);

        // Update TemporaryWorkerForms
        $tempUpdated = TemporaryWorkerForm::where('office_id', $oldOfficeId)
            ->update(['office_id' => $newOfficeId]);

        return response()->json([
            'status' => 'success',
            'message' => 'Office ID updated successfully.',
            'details' => [
                'main_worker_forms_updated' => $mainUpdated,
                'temporary_worker_forms_updated' => $tempUpdated,
            ],
        ]);
    }
    public function updateReceiverUserIds(Request $request)
    {
        $oldUserId = $request->input('old_user_id');  // value to replace
        $newUserId = $request->input('new_user_id');

        if (!$newUserId) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide new_user_id'
            ], 400);
        }

        // Update in MainWorkerForms
        $mwf = MainWorkerForm::where('application_receiver_user_id', $oldUserId)
            ->update(['application_receiver_user_id' => $newUserId]);

        $wwf = MainWorkerForm::where('application_sender_user_id', $oldUserId)
            ->update(['application_sender_user_id' => $newUserId]);

        // Update in WorkerApplicationStatuses (receiver)
        $was1 = WorkerApplicationStatus::where('application_receiver_user_id', $oldUserId)
            ->update(['application_receiver_user_id' => $newUserId]);

        // Update in WorkerApplicationStatuses (sender)
        $was2 = WorkerApplicationStatus::where('sender_user_id', $oldUserId)
            ->update(['sender_user_id' => $newUserId]);

        return response()->json([
            'status' => true,
            'message' => 'User IDs updated successfully',
            'updated' => [
                'MainWorkerForms' => $mwf,
                'Sender_user_id' => $wwf,
                'WorkerApplicationStatuses_receiver' => $was1,
                'WorkerApplicationStatuses_sender' => $was2
            ]
        ]);
    }

    public function updateUserIds(Request $request)
    {
        $request->validate([
            'old_user_id' => 'required|integer',
            'new_user_id' => 'required|integer',
            'office_id'   => 'required|integer'
        ]);

        $oldUserId = $request->old_user_id;
        $newUserId = $request->new_user_id;
        $officeId  = $request->office_id;

        DB::beginTransaction();

        try {

            // Update in MainWorkerForms (receiver)
            $mwf = MainWorkerForm::where('application_receiver_user_id', $oldUserId)
                ->where('office_id', $officeId)
                ->update(['application_receiver_user_id' => $newUserId]);

            // Update in MainWorkerForms (sender)
            $mwfSender = MainWorkerForm::where('application_sender_user_id', $oldUserId)
                ->where('office_id', $officeId)
                ->update(['application_sender_user_id' => $newUserId]);

            // Update in WorkerApplicationStatuses (receiver)
            $wasReceiver = WorkerApplicationStatus::where('application_receiver_user_id', $oldUserId)
                ->where('sender_office_id', $officeId)
                ->update(['application_receiver_user_id' => $newUserId]);

            // Update in WorkerApplicationStatuses (sender)
            $wasSender = WorkerApplicationStatus::where('sender_user_id', $oldUserId)
                ->where('sender_office_id', $officeId)
                ->update(['sender_user_id' => $newUserId]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User IDs updated successfully',
                'updated' => [
                    'MainWorkerForms_receiver' => $mwf,
                    'MainWorkerForms_sender' => $mwfSender,
                    'WorkerApplicationStatuses_receiver' => $wasReceiver,
                    'WorkerApplicationStatuses_sender' => $wasSender,
                ]
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function vaultDecrypt($limit, $offset)
    {
        // retrieve a batch of vault data rows
        $rows = \App\Models\VaultData::limit(intval($limit))
            ->offset(intval($offset))
            ->get();

        $processed = 0;
        foreach ($rows as $row) {
            $workerId = $row->worker_id;

            // only operate when a corresponding verification already exists
            $vaultVerif = \App\Models\VaultVerification::where('worker_id', $workerId)->first();
            if (!$vaultVerif) {
                continue;
            }

            // decrypt the enc_data from vault_data
            try {
                $decrypted = \App\Models\VaultData::getDecryptedAadhaarDataByWorkerId($workerId);
            } catch (\Exception $e) {
                // if decryption fails, skip this row
                continue;
            }

            // update the verification record
            $vaultVerif->enc_response_data = $row->enc_data;
            $vaultVerif->decrypted_data = is_array($decrypted) ? json_encode($decrypted) : $decrypted;
            $vaultVerif->status = 'verified_local';
            $vaultVerif->save();

            $processed++;
        }

        return response()->json([
            'status'    => true,
            'processed' => $processed,
            'total'     => $rows->count()
        ]);
    }

}
