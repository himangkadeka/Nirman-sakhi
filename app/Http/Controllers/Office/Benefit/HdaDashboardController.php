<?php

namespace App\Http\Controllers\Office\Benefit;

use App\Exports\PpaExport;
use App\Http\Controllers\Controller;
use App\Models\BenefitSubmissionLog;
use App\Models\FormSubmission;
use App\Models\PpaBatchFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class HdaDashboardController extends Controller
{
    public function index()
    {
        $query = FormSubmission::with('benefit', 'worker')
            ->where('status', 'assigned_to_hda')->where('assigned_to_user_id', Auth::id());

        $submittedApplications = $query->latest()->paginate(20);
        return view('office.benefits.dealing-assistant.index', compact('submittedApplications'));
    }

    public function processBatch(Request $request)
    {
        $validated = $request->validate([
            'actions' => 'required|array',
            'actions.*.id' => 'required|exists:pgsql.Benefit.form_submissions,id',
            'actions.*.action' => 'required|in:approve,revert', // Only allow these two actions
            'actions.*.comment' => 'nullable|required_if:actions.*.action,revert|string|max:1000',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                foreach ($validated['actions'] as $actionData) {
                    $submission = FormSubmission::find($actionData['id']);
                    $fromStatus = $submission->status;

                    if ($actionData['action'] === 'approve') {
                        $submission->status = 'hda_approved';
                        $logAction = 'HDA_APPROVED';
                        $logComment = $actionData['comment'] ?? 'Marked as valid by Head Office Dealing Assistant.';
                    } else {
                        $submission->status = 'reverted_to_ho';
                        $logAction = 'HDA_REVERTED';
                        $logComment = $actionData['comment'];
                    }

                    $submission->save();

                    BenefitSubmissionLog::create([
                        'form_submission_id' => $submission->id,
                        'user_id'            => auth()->id(),
                        'action'             => $logAction,
                        'comment'            => $logComment,
                        'from_status'        => $fromStatus,
                        'to_status'          => $submission->status,
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Batch of ' . count($validated['actions']) . ' actions processed successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('DA Batch Processing Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'A server error occurred. Please try again.'
            ], 500);
        }
    }


    public function ppaGenration()
    {
        $query = FormSubmission::with('benefit', 'worker')
            // ->whereIn('status', ['reverted_to_ho','hda_approved']);
            ->whereIn('status', ['assigned_to_hda_for_ppa']);

        $applications = $query->latest()->paginate(20);

        return view('office.benefits.dealing-assistant.ppa-generation', compact('applications'));
    }

    public function exportForPpa()
    {
        try {
            // 1. Find all applications ready for PPA
            $applicationsToProcess = FormSubmission::whereIn('status', ['assigned_to_hda_for_ppa'])->get();

            if ($applicationsToProcess->isEmpty()) {
                return redirect()->back()->with('error', 'No applications are currently ready for PPA generation.');
            }

            // 2. Generate a new, unique Batch ID
            $batchId = 'PPA-' . now()->format('Ymd-His');
            $applicationIds = $applicationsToProcess->pluck('id');

            // 3. Update all these applications with the new batch_id and status
            DB::transaction(function () use ($applicationIds, $batchId) {
                FormSubmission::whereIn('id', $applicationIds)
                    ->update([
                        'status' => 'ppa_generated', // A new status to show it's in a batch
                        'batch_id' => $batchId,
                    ]);

                $logEntries = [];
                foreach ($applicationIds as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id,
                        'user_id'            => auth()->id(), // The HO user doing the assigning
                        'action'             => 'PPA_GENRATED',
                        'comment'            => $comment ?? 'PPA Generated',
                        'from_status'        => 'assigned_to_hda_for_ppa',
                        'to_status'          => 'ppa_generated',
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];
                }
                BenefitSubmissionLog::insert($logEntries);
            });

            // 4. Create a new instance of the PpaExport class, PASSING the application IDs
            $export = new PpaExport($applicationIds);

            // 5. Trigger the download and include the batch ID in the filename
            $fileName = 'PPA_Batch_' . $batchId . '.xlsx';
            return Excel::download($export, $fileName);
        } catch (\Exception $e) {
            Log::error('PPA Batch Generation Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate the PPA batch.');
        }
    }

    // Method to handle the PPA file upload
    public function uploadPpa(Request $request)
    {
        $request->validate([
            'ppa_file' => 'required|file|mimes:pdf,xlsx,xls',
            'ppa_batch_id' => 'required|string|exists:pgsql.Benefit.form_submissions,batch_id', // Ensure the batch ID is valid
            'comment'  => 'nullable|string',
        ]);

        try {
            // 1. Find all applications belonging to this specific batch ID
            $batchId = $request->ppa_batch_id;
            $applicationIds = FormSubmission::where('batch_id', $batchId)
                ->where('status', 'ppa_generated') // Ensure it's the correct status
                ->pluck('id');

            if ($applicationIds->isEmpty()) {
                return back()->with('error', 'No applications found for this Batch ID, or they have already been processed.');
            }

            // 2. Store the uploaded file
            $path = $request->file('ppa_file')->store('ppa_files', 'public');

            // 3. Update statuses within a transaction
            DB::transaction(function () use ($applicationIds, $path, $batchId, $request) {
                $newStatus = 'ppa_dispatched';
                FormSubmission::whereIn('id', $applicationIds)->update(['status' => $newStatus]);

                // Create log entries...
                $logEntries = [];
                foreach ($applicationIds as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id,
                        'user_id'            => auth()->id(),
                        'action'             => "PPA_DISPATCHED",
                        'comment' => $request->comment ?? 'PPA file uploaded for Batch ID: ' . $batchId,
                        'file_path' => $path,
                        'from_status' => 'ppa_generated',
                        'to_status' => $newStatus,
                    ];
                }
                BenefitSubmissionLog::insert($logEntries);
            });

            return redirect()->back()->with('success', 'PPA for Batch ' . $batchId . ' uploaded successfully!');
        } catch (\Exception $e) {
            Log::error('PPA Upload Failed: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during the PPA upload process.');
        }
    }


    public function finalDisbursed()
    {
        $user = Auth::user();
        $status = "forwarded_to_hda_for_disbursement";

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
        return view('office.benefits.dealing-assistant.final-disbursed', compact('applications', 'pendingSignatureBatches', 'budgetSummary', 'headDealingAssistants'));
    }


    public function markBatchAsDisbursed(Request $request)
    {
        $validated = $request->validate([
            'batch_id' => 'required|string|exists:pgsql.Benefit.ppa_batch_files,batch_id',
            'transaction_id' => 'required|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ]);

        $batchId = $validated['batch_id'];
        $transactionId = $validated['transaction_id'];

        try {
            DB::transaction(function () use ($batchId, $transactionId, $validated) {
                // 1. Find the PPA Batch record
                $ppaBatch = PpaBatchFile::where('batch_id', $batchId)->firstOrFail();

                // Prevent processing if already disbursed
                if ($ppaBatch->transaction_id) {
                    throw new \Exception('This batch has already been marked as disbursed.');
                }

                // 2. Update the PpaBatchFile with the transaction details
                $ppaBatch->transaction_id = $transactionId;
                $ppaBatch->disbursed_at = now();
                $ppaBatch->save();

                // 3. Find and update all applications in the batch
                $newStatus = 'disbursed';
                $fromStatus = 'forwarded_to_hda_for_disbursement';

                $applicationIds = FormSubmission::where('batch_id', $batchId)
                    ->where('status', $fromStatus)
                    ->pluck('id');

                if ($applicationIds->isEmpty()) {
                    throw new \Exception('No applications in the correct state were found for this batch.');
                }

                FormSubmission::whereIn('id', $applicationIds)->update(['status' => $newStatus]);

                // 4. Create log entries for every application in the batch
                $logEntries = [];
                $now = now();
                foreach ($applicationIds as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id,
                        'user_id'            => auth()->id(),
                        'action'             => 'DISBURSED',
                        'comment'            => $validated['comment'] ?? 'Payment disbursed. Transaction ID: ' . $transactionId,
                        'from_status'        => $fromStatus,
                        'to_status'          => $newStatus,
                        'created_at'         => $now,
                        'updated_at'         => $now,
                    ];
                }
                BenefitSubmissionLog::insert($logEntries);
            });

            return response()->json(['success' => true, 'message' => 'Batch successfully marked as disbursed!']);
        } catch (\Exception $e) {
            Log::error('Disbursement Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
