<?php

namespace App\Http\Controllers\Office\Benefit;

use App\Exports\AccountsApplicationsExport;
use App\Http\Controllers\Controller;
use App\Models\BenefitSubmissionLog;
use App\Models\FormSubmission;
use App\Models\PpaBatchFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class HoDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pendingCount = FormSubmission::where('assigned_to_user_id', $user->id)
            ->whereIn('status', ['processing'])
            ->count();


        $hasPendingBatch = ($pendingCount > 0);

        $query = FormSubmission::with('benefit', 'worker')
            ->where('status', 'forwarded_to_ho');

        $submittedApplications = $query->latest()->paginate(20);

        return view('office.benefits.head-office.index', compact('submittedApplications', 'hasPendingBatch'));
    }


    public function lockBatch(Request $request)
    {
        // 1. Validate the incoming request for 'batch_size'
        $request->validate([
            'batch_size' => 'required|integer|min:1',
        ]);

        try {
            $applicationIds = FormSubmission::where('status', 'forwarded_to_ho')
                ->orderBy('submitted_at', 'asc')
                ->limit($request->batch_size)
                ->pluck('id');


            if ($applicationIds->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'There are no incoming applications available to lock.'
                ], 404);
            }

            $logEntries = [];
            DB::transaction(function () use ($applicationIds, &$logEntries) {
                // Generate a unique lock_batch_number in format ddmmyyyy-000001
                $datePrefix = Carbon::now()->format('dmY'); // ddmmyyyy

                // Fetch existing batch numbers for today and compute the max serial
                $existing = FormSubmission::where('lock_batch_number', 'like', $datePrefix . '-%')
                    ->pluck('lock_batch_number')
                    ->filter()
                    ->values();

                $maxSerial = 0;
                foreach ($existing as $bn) {
                    $parts = explode('-', $bn);
                    if (count($parts) === 2) {
                        $num = intval($parts[1]);
                        if ($num > $maxSerial) $maxSerial = $num;
                    }
                }

                $nextSerial = str_pad($maxSerial + 1, 6, '0', STR_PAD_LEFT);
                $batchNumber = $datePrefix . '-' . $nextSerial;

                FormSubmission::whereIn('id', $applicationIds)
                    ->update([
                        'status' => 'lock_for_processing',
                        'lock_batch_number' => $batchNumber,
                        'assigned_to_user_id' => Auth::id()
                    ]);

                foreach ($applicationIds as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id,
                        'user_id'            => Auth::id(),
                        'action'             => 'LOCK_FOR_PROCESSING',
                        'comment'            => 'HO locked for processing via automated batch. Batch: ' . $batchNumber,
                        'from_status'        => 'forwarded_to_ho',
                        'to_status'          => 'lock_for_processing',
                        'created_at'         => Carbon::now(),
                        'updated_at'         => Carbon::now(),
                    ];
                }

                BenefitSubmissionLog::insert($logEntries);
            });


            $lockedCount = $applicationIds->count();
            return response()->json([
                'success' => true,
                'message' => "Batch of {$lockedCount} application(s) locked successfully and assigned for processing."
            ]);
        } catch (\Exception $e) {
            Log::error('Batch lock failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while locking the batch. Please try again.'
            ], 500);
        }
    }


    public function processingApplications()
    {
        $query = FormSubmission::with('benefit', 'worker')
            ->where('status', 'lock_for_processing');

        $processingApplications = $query->latest()->paginate(20);

        $dealingAssistants = User::where('role_id', 12)->get();

        return view('office.benefits.head-office.processing', compact('processingApplications', 'dealingAssistants'));
    }

    public function assignToDa(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:pgsql.Benefit.form_submissions,id',
            'da_user_id' => 'required|exists:pgsql.User.users,id',
            'comment' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $ids = $request->application_ids;
                $daUserId = $request->da_user_id;
                $comment = $request->comment;

                // 1. Update the submissions
                FormSubmission::whereIn('id', $ids)
                    ->update([
                        'status' => 'assigned_to_hda', // New status
                        'assigned_to_user_id' => $daUserId,
                        // You might want to clear the previous assigned_to_user_id if it's a different column
                    ]);

                // 2. Create log entries
                $logEntries = [];
                foreach ($ids as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id,
                        'user_id'            => auth()->id(), // The HO user doing the assigning
                        'action'             => 'ASSIGN_TO_HDA',
                        'comment'            => $comment ?? 'Assigned to Dealing Assistant for review.',
                        'from_status'        => 'lock_for_processing',
                        'to_status'          => 'assigned_to_hda',
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];
                }
                BenefitSubmissionLog::insert($logEntries);
            });

            return response()->json(['success' => true, 'message' => 'Applications successfully assigned.']);
        } catch (\Exception $e) {
            Log::error('DA Assignment Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred during assignment.'], 500);
        }
    }


    public function hoDaReview()
    {
        $query = FormSubmission::with('benefit', 'worker')
            // ->whereIn('status', ['reverted_to_ho','hda_approved']);
            ->whereIn('status', ['hda_approved']);

        $hdoReviewedApplications = $query->latest()->paginate(20);

        return view('office.benefits.head-office.ho-da-review', compact('hdoReviewedApplications'));
    }


    public function forwardToAccounts(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:pgsql.Benefit.form_submissions,id',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $ids = $request->application_ids;
                // $dummyAmount = 10000.00; // Define your dummy amount here

                // 1. Update all selected applications in a single query
               FormSubmission::whereIn('id', $ids)
                    ->where('status', 'hda_approved') // IMPORTANT: Ensure we only forward from the correct status
                    ->update([
                        'status' => 'forwarded_to_accounts', // The new status
                        // 'sanctioned_amount' => $dummyAmount,
                    ]);

                // 2. Create log entries for each forwarded application
                $logEntries = [];
                foreach ($ids as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id,
                        'user_id'            => auth()->id(),
                        'action'             => 'FORWARDED_TO_ACCOUNTS',
                        'comment'            => 'Forwarded to Accounts with a sanctioned amount of ' .FormSubmission::where('id',$id)->first()->sanctioned_amount,
                        'from_status'        => 'hda_approved',
                        'to_status'          => 'forwarded_to_accounts',
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];
                }
                BenefitSubmissionLog::insert($logEntries);
            });

            return response()->json(['success' => true, 'message' => 'Selected applications have been successfully forwarded to Accounts.']);
        } catch (\Exception $e) {
            Log::error('Forward to Accounts Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred during the process.'], 500);
        }
    }


    public function accounts()
    {
        $applications = FormSubmission::with(['worker', 'benefit'])
            ->where('status', 'forwarded_to_accounts')
            ->latest()
            ->paginate(20);

        $budgetSummary = FormSubmission::join('Benefit.benefits', 'Benefit.form_submissions.benefit_id', '=', 'benefits.id')
            ->where('form_submissions.status', 'forwarded_to_accounts')
            ->select('benefits.name as scheme_name', DB::raw('SUM(form_submissions.sanctioned_amount) as total_budget'))
            ->groupBy('benefits.name')
            ->orderBy('scheme_name')
            ->get();

        return view('office.benefits.head-office.accounts', compact('applications', 'budgetSummary'));
    }

    public function exportAccountsExcel()
    {
        // Generate a user-friendly filename with the current date
        $fileName = 'accounts-applications-' . now()->format('Y-m-d') . '.xlsx';

        // Trigger the download by returning the Export class instance
        return Excel::download(new AccountsApplicationsExport, $fileName);
    }


    public function LmApprovedApplications()
    {
        $applications = FormSubmission::with(['worker', 'benefit'])
            ->where('status', 'forwarded_to_ho_for_ppa')
            ->latest()
            ->paginate(20);
        $dealingAssistants = User::where('role_id', 12)->get();


        return view('office.benefits.head-office.lm-approved', compact('applications', 'dealingAssistants'));
    }


    public function assignToDaforPPA(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:pgsql.Benefit.form_submissions,id',
            'da_user_id' => 'required|exists:pgsql.User.users,id',
            'comment' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $ids = $request->application_ids;
                $daUserId = $request->da_user_id;
                $comment = $request->comment;

                // 1. Update the submissions
                FormSubmission::whereIn('id', $ids)
                    ->update([
                        'status' => 'assigned_to_hda_for_ppa', // New status
                        'assigned_to_user_id' => $daUserId,
                        // You might want to clear the previous assigned_to_user_id if it's a different column
                    ]);

                // 2. Create log entries
                $logEntries = [];
                foreach ($ids as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id,
                        'user_id'            => auth()->id(), // The HO user doing the assigning
                        'action'             => 'ASSIGN_TO_HDA_FOR_PPA',
                        'comment'            => $comment ?? 'Assigned to Dealing Assistant for PPA.',
                        'from_status'        => 'forwarded_to_ho_for_ppa',
                        'to_status'          => 'assigned_to_hda_for_ppa',
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];
                }
                BenefitSubmissionLog::insert($logEntries);
            });

            return response()->json(['success' => true, 'message' => 'Applications successfully assigned.']);
        } catch (\Exception $e) {
            Log::error('DA Assignment Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred during assignment.'], 500);
        }
    }

    public function ppaDispatchApplications()
    {
        $query = FormSubmission::with('benefit', 'worker')
            // ->whereIn('status', ['reverted_to_ho','hda_approved']);
            ->whereIn('status', ['assigned_to_hda_for_ppa']);

        $applications = $query->latest()->paginate(20);

        return view('office.benefits.head-office.ppa-dispatch', compact('applications'));
    }

    public function lmSigned()
    {
        $user = Auth::user();
        $status = "forwarded_to_ho_for_disbursed";

        $applications = FormSubmission::with(['worker', 'benefit'])
            ->where('status', $status)
            ->latest()
            ->paginate(20);
        $pendingSignatureBatches = FormSubmission::where('status', $status)
            ->whereNotNull('batch_id')
            ->select('batch_id', DB::raw('COUNT(*) as application_count'), DB::raw('MAX(updated_at) as dispatched_at'))
            ->groupBy('batch_id')
            ->orderBy('dispatched_at', 'desc')
            ->paginate(20);

        $budgetSummary = FormSubmission::join('Benefit.benefits', 'Benefit.form_submissions.benefit_id', '=', 'benefits.id')
            ->where('form_submissions.status', $status)
            ->select('benefits.name as scheme_name', DB::raw('SUM(form_submissions.sanctioned_amount) as total_budget'))
            ->groupBy('benefits.name')
            ->orderBy('scheme_name')
            ->get();

        $batchIds = $pendingSignatureBatches->pluck('batch_id');
        $ppaBatchFiles = PpaBatchFile::whereIn('batch_id', $batchIds)
            ->get()
            ->keyBy('batch_id');
        $headDealingAssistants = User::where('role_id', 12)->orderBy('firstname')->get();
        return view('office.benefits.head-office.ppa-received', compact('applications', 'pendingSignatureBatches', 'budgetSummary','headDealingAssistants'));
    }

    public function forwardBatchToHda(Request $request)
    {
        $validated = $request->validate([
            'batch_id' => 'required|string|exists:pgsql.Benefit.form_submissions,batch_id',
            'hda_user_id' => 'required|exists:pgsql.User.users,id', // Ensure the selected user exists
            'comment' => 'nullable|string|max:1000',
        ]);

        $batchId = $validated['batch_id'];
        $hdaUserId = $validated['hda_user_id'];
        $comment = $validated['comment'];

        try {
            DB::transaction(function () use ($batchId, $hdaUserId, $comment) {
                // 1. Get all applications in the batch that are ready to be forwarded
                $applications = FormSubmission::where('batch_id', $batchId)
                    ->where('status', 'forwarded_to_ho_for_disbursed')
                    ->get();

                if ($applications->isEmpty()) {
                    throw new \Exception('This batch is not in the correct state for forwarding or has already been forwarded.');
                }

                // 2. Update status and assign the HDA user to all applications in the batch
                $newStatus = 'forwarded_to_hda_for_disbursement';
                foreach ($applications as $submission) {
                    $submission->status = $newStatus;
                    $submission->assigned_to_user_id = $hdaUserId; // Assigning the specific HDA
                    $submission->save();
                }

                // 3. Create log entries for every application
                $logEntries = [];
                $now = now();
                foreach ($applications as $submission) {
                    $logEntries[] = [
                        'form_submission_id' => $submission->id,
                        'user_id'            => auth()->id(),
                        'action'             => 'FORWARDED_FOR_DISBURSEMENT',
                        'comment'            => $comment ?? 'Batch ' . $batchId . ' forwarded to HDA for disbursement.',
                        'from_status'        => 'ppa_signed_by_lm',
                        'to_status'          => $newStatus,
                        'created_at'         => $now,
                        'updated_at'         => $now,
                    ];
                }
                BenefitSubmissionLog::insert($logEntries);
            });

            return response()->json(['success' => true, 'message' => 'Batch has been successfully assigned to the HDA for disbursement.']);
        } catch (\Exception $e) {
            Log::error('Forward to HDA failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
