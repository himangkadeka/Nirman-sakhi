<?php

namespace App\Http\Controllers\Office\Benefit;

use App\Exports\AccountsApplicationsExport;
use App\Http\Controllers\Controller;
use App\Models\BenefitSubmissionLog;
use App\Models\FormSubmission;
use App\Models\PpaBatchFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AccountsController extends Controller
{
    public function index()
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

        return view('office.benefits.accounts.index', compact('applications', 'budgetSummary'));
    }

    public function exportAccountsExcel()
    {
        // Generate a user-friendly filename with the current date
        $fileName = 'accounts-applications-' . now()->format('Y-m-d') . '.xlsx';

        // Trigger the download by returning the Export class instance
        return Excel::download(new AccountsApplicationsExport, $fileName);
    }

    public function processAccountAction(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'application_id' => 'required|exists:pgsql.Benefit.form_submissions,id',
            'action'         => 'required|in:approve,reject,revert',
            // The comment is required only if the action is 'reject' or 'revert'
            'comment'        => 'nullable|required_if:action,reject|required_if:action,revert|string|max:1000',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $submission = FormSubmission::findOrFail($validated['application_id']);
                $fromStatus = $submission->status;

                $action = $validated['action'];
                $comment = $validated['comment'];

                // 2. Determine the new status and log details based on the action
                if ($action === 'approve') {
                    $toStatus = 'forwarded_to_dlc';
                    $logAction = 'ACCOUNTS_APPROVED';
                    $logComment = $comment ?: 'Approved at Accounts and forwarded to DLC.';
                } elseif ($action === 'reject') {
                    $toStatus = 'reject_at_accounts';
                    $logAction = 'ACCOUNTS_REJECTED';
                    $logComment = $comment;
                } else { // action is 'revert'
                    $toStatus = 'revert_at_accounts';
                    $logAction = 'ACCOUNTS_REVERTED';
                    $logComment = $comment;
                }

                // 3. Update the application status
                $submission->update(['status' => $toStatus]);

                // 4. Create a detailed log entry
                BenefitSubmissionLog::create([
                    'form_submission_id' => $submission->id,
                    'user_id'            => auth()->id(),
                    'action'             => $logAction,
                    'comment'            => $logComment,
                    'from_status'        => $fromStatus,
                    'to_status'          => $toStatus,
                ]);
            });

            return response()->json(['success' => true, 'message' => 'Action completed successfully!']);
        } catch (\Exception $e) {
            Log::error('Accounts action failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }

    /**
     * Process multiple account decisions in one request.
     * Expects `decisions` => [id => decision], and optional `comments` => [id => comment]
     */
    public function processBulkActions(Request $request)
    {
        $validated = $request->validate([
            'decisions' => 'required|array',
            'decisions.*' => 'required|in:approve,reject,revert',
            'comments' => 'nullable|array',
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {
                $now = now();
                $logEntries = [];

                foreach ($validated['decisions'] as $appId => $decision) {
                    $submission = FormSubmission::find($appId);
                    if (!$submission) continue;

                    $fromStatus = $submission->status;
                    if ($decision === 'approve') {
                        $toStatus = 'forwarded_to_dlc';
                        $logAction = 'ACCOUNTS_APPROVED';
                        $logComment = 'Approved at Accounts and forwarded to DLC.';
                    } elseif ($decision === 'reject') {
                        $toStatus = 'reject_at_accounts';
                        $logAction = 'ACCOUNTS_REJECTED';
                        $logComment = $request->input('comments.' . $appId, 'Rejected by Accounts.');
                    } else { // revert
                        $toStatus = 'revert_at_accounts';
                        $logAction = 'ACCOUNTS_REVERTED';
                        $logComment = $request->input('comments.' . $appId, 'Reverted by Accounts.');
                    }

                    $submission->update(['status' => $toStatus]);

                    $logEntries[] = [
                        'form_submission_id' => $submission->id,
                        'user_id' => auth()->id(),
                        'action' => $logAction,
                        'comment' => $logComment,
                        'from_status' => $fromStatus,
                        'to_status' => $toStatus,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if (!empty($logEntries)) {
                    BenefitSubmissionLog::insert($logEntries);
                }
            });

            return response()->json(['success' => true, 'message' => 'Decisions processed successfully.']);
        } catch (\Exception $e) {
            Log::error('Bulk accounts action failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while processing decisions.'], 500);
        }
    }


    public function forwardedToDlc()
    {
        $applications = FormSubmission::with(['worker', 'benefit'])
            ->where('status', 'forwarded_to_dlc')
            ->latest()
            ->paginate(20);
        $pendingSignatureBatches = FormSubmission::where('status', 'ppa_dispatched')
            ->whereNotNull('batch_id')
            ->select('batch_id', DB::raw('COUNT(*) as application_count'), DB::raw('MAX(updated_at) as dispatched_at'))
            ->groupBy('batch_id')
            ->orderBy('dispatched_at', 'desc')
            ->get();
            $budgetSummary = FormSubmission::join('Benefit.benefits', 'Benefit.form_submissions.benefit_id', '=', 'benefits.id')
            ->where('form_submissions.status', 'forwarded_to_accounts')
            ->select('benefits.name as scheme_name', DB::raw('SUM(form_submissions.sanctioned_amount) as total_budget'))
            ->groupBy('benefits.name')
            ->orderBy('scheme_name')
            ->get();

        return view('office.benefits.accounts.forwarded-to-dlc', compact('applications','pendingSignatureBatches','budgetSummary'));
    }

    public function receivedPPA()
    {
        $applications = FormSubmission::with(['worker', 'benefit'])
            ->where('status', 'ppa_dispatched')
            ->latest()
            ->paginate(20);
        $pendingSignatureBatches = FormSubmission::where('status', 'ppa_dispatched')
            ->whereNotNull('batch_id')
            ->select('batch_id', DB::raw('COUNT(*) as application_count'), DB::raw('MAX(updated_at) as dispatched_at'))
            ->groupBy('batch_id')
            ->orderBy('dispatched_at', 'desc')
            ->get();

        $budgetSummary = FormSubmission::join('Benefit.benefits', 'Benefit.form_submissions.benefit_id', '=', 'benefits.id')
            ->where('form_submissions.status', 'ppa_dispatched')
            ->select('benefits.name as scheme_name', DB::raw('SUM(form_submissions.sanctioned_amount) as total_budget'))
            ->groupBy('benefits.name')
            ->orderBy('scheme_name')
            ->get();

        return view('office.benefits.accounts.received-ppa', compact('applications', 'pendingSignatureBatches', 'budgetSummary'));
    }


    public function downloadPpaFile($batch_id)
    {
        // Find the log entry that contains the file path for this batch
        $log = BenefitSubmissionLog::whereHas('formSubmission', function ($query) use ($batch_id) {
            $query->where('batch_id', $batch_id);
        })
            ->where('action', 'PPA_DISPATCHED') // The action when the file was first uploaded
            ->whereNotNull('file_path')
            ->firstOrFail();

        // Check if the file exists and return it for download
        if (Storage::disk('public')->exists($log->file_path)) {
            return Storage::disk('public')->download($log->file_path);
        }

        abort(404, 'PPA file not found for this batch.');
    }



    // The downloadPpaFile() method remains the same.

    // REFACTORED METHOD: To handle the upload into the new table
    public function uploadSignedPpa(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|string|exists:pgsql.Benefit.form_submissions,batch_id',
            'signed_ppa_file' => 'required|file|mimes:pdf,jpeg,png,jpg',
        ]);

        $batchId = $request->batch_id;

        try {
            // Start a database transaction to ensure all or no changes are made
            DB::transaction(function () use ($request, $batchId) {
                // 1. Check if a record for this batch already exists in PpaBatchFile
                $ppaBatch = PpaBatchFile::firstOrNew(['batch_id' => $batchId]);

                // Prevent re-uploading if it's already signed by accounts
                if ($ppaBatch->ppa_signed_by_accounts) {
                    // We throw an exception to be caught and shown as an error message
                    throw new \Exception('This batch has already been signed and uploaded by Accounts.');
                }

                // 2. Store the uploaded signed file
                $path = $request->file('signed_ppa_file')->store('signed_ppa_files/accounts', 'public');

                // 3. Update the PpaBatchFile record
                $ppaBatch->ppa_signed_by_accounts = $path;
                $ppaBatch->accounts_signed_at = now();
                $ppaBatch->save();

                // 4. Find and update all applications associated with this batch
                $newStatus = 'ppa_signed_by_accounts';
                $applicationIds = FormSubmission::where('batch_id', $batchId)
                    ->where('status', 'ppa_dispatched')
                    ->pluck('id');

                if ($applicationIds->isEmpty()) {
                    throw new \Exception('No applications in the correct status were found for this batch.');
                }

                FormSubmission::whereIn('id', $applicationIds)->update(['status' => $newStatus]);

                $logEntries = [];
                foreach ($applicationIds as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id,
                        'user_id'            => auth()->id(),
                        'action'             => "PPA_SIGNED_BY_ACCOUNTS",
                        'comment' => 'Signed PPA uploaded for Batch ID: ' . $batchId,
                        'file_path' => $path,
                        'from_status' => 'ppa_dispatched',
                        'to_status' => $newStatus,
                    ];
                }
                BenefitSubmissionLog::insert($logEntries);
            });

            return redirect()->back()->with('success', 'Signed PPA for Batch ' . $batchId . ' uploaded and forwarded to DLC for review!');
        } catch (\Exception $e) {
            Log::error('Signed PPA Upload Failed: ' . $e->getMessage());
            // Return the specific exception message for better user feedback
            return back()->with('error', $e->getMessage());
        }
    }


    public function forwardToDlcForReview(){
        $applications = FormSubmission::with(['worker', 'benefit'])
            ->where('status', 'ppa_signed_by_accounts')
            ->latest()
            ->paginate(20);
        $pendingSignatureBatches = FormSubmission::where('status', 'ppa_signed_by_accounts')
            ->whereNotNull('batch_id')
            ->select('batch_id', DB::raw('COUNT(*) as application_count'), DB::raw('MAX(updated_at) as dispatched_at'))
            ->groupBy('batch_id')
            ->orderBy('dispatched_at', 'desc')
            ->get();

        $budgetSummary = FormSubmission::join('Benefit.benefits', 'Benefit.form_submissions.benefit_id', '=', 'benefits.id')
            ->where('form_submissions.status', 'ppa_signed_by_accounts')
            ->select('benefits.name as scheme_name', DB::raw('SUM(form_submissions.sanctioned_amount) as total_budget'))
            ->groupBy('benefits.name')
            ->orderBy('scheme_name')
            ->get();

        return view('office.benefits.accounts.forwarded-to-dlc', compact('applications', 'pendingSignatureBatches', 'budgetSummary'));
    }


    public function downloadSignedPpaFile($batch_id){
        // Find the log entry that contains the file path for this batch
        $log = PpaBatchFile::where('batch_id',$batch_id)->first();

        // Check if the file exists and return it for download
        if (Storage::disk('public')->exists($log->ppa_signed_by_accounts)) {
            return Storage::disk('public')->download($log->ppa_signed_by_accounts);
        }

        abort(404, 'PPA file not found for this batch.');
    }
}
