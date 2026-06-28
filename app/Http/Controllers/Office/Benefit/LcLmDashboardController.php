<?php

namespace App\Http\Controllers\Office\Benefit;

use App\Http\Controllers\Controller;
use App\Models\BenefitSubmissionLog;
use App\Models\FormSubmission;
use App\Models\PpaBatchFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LcLmDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 16) {
            $applications = FormSubmission::with(['worker', 'benefit'])
                ->where('status', 'forwarded_to_lc')
                ->latest()
                ->paginate(20);
        } elseif ($user->role_id == 17) {
            $applications = FormSubmission::with(['worker', 'benefit'])
                ->where('status', 'forwarded_to_lm')
                ->latest()
                ->paginate(20);
        }

        return view('office.benefits.lc-lm-dashboard.index', compact('applications'));
    }

    public function forwardToLmApproved(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:pgsql.Benefit.form_submissions,id',
        ]);



        try {
            DB::transaction(function () use ($validated) {
                $user = Auth::user();
                $submission = FormSubmission::findOrFail($validated['application_id']);

                if ($user->role_id == 16) {
                    if ($submission->status !== 'forwarded_to_lc') {
                        // This is a server-side check to prevent invalid actions
                        throw new \Exception('Application is not in the correct state to be forwarded.');
                    }
                    $fromStatus = $submission->status;
                    $toStatus = 'forwarded_to_lm';
                    $action = "FORWARD_TO_LM";
                    $comment = "Forwarded to Labour Minister by LC.";
                } elseif ($user->role_id == 17) {
                    if ($submission->status !== 'forwarded_to_lm') {
                        // This is a server-side check to prevent invalid actions
                        throw new \Exception('Application is not in the correct state to be forwarded.');
                    }
                    $fromStatus = $submission->status;
                    $toStatus = 'forwarded_to_ho_for_ppa';
                    $action = "FORWARD_TO_HO_FOR_PPA";
                    $comment = "Forwarded to Head Office for PPA by LM.";
                }
                // Ensure we are forwarding from the correct status




                // Update the status
                $submission->update(['status' => $toStatus]);

                // Create log entry
                BenefitSubmissionLog::create([
                    'form_submission_id' => $submission->id,
                    'user_id'            => auth()->id(),
                    'action'             => $action,
                    'comment'            => $comment,
                    'from_status'        => $fromStatus,
                    'to_status'          => $toStatus,
                ]);
            });

            return response()->json(['success' => true, 'message' => 'Application successfully forwarded to LC.']);
        } catch (\Exception $e) {
            Log::error('Forward to LC failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }


    public function applicationsTosign()
    {
        $user = Auth::user();
        if ($user->role_id == 16) {
            $status = "forwarded_to_lc_for_sign";
        } elseif ($user->role_id == 17) {
            $status = "forwarded_to_lm_for_sign";
        }
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

        return view('office.benefits.lc-lm-dashboard.ppa-signing', compact('applications', 'pendingSignatureBatches', 'budgetSummary'));
    }

    public function downloadForSigning($batch_id)
    {
        $user = auth()->user();
        $ppaBatch = PpaBatchFile::where('batch_id', $batch_id)->firstOrFail();

        $filePath = null;
        if ($user->role_id == 16 && $ppaBatch->ppa_signed_by_accounts) { // LC downloads the Accounts-signed version
            $filePath = $ppaBatch->ppa_signed_by_accounts;
        } elseif ($user->role_id == 17 && $ppaBatch->ppa_signed_by_lc) { // LM downloads the LC-signed version
            $filePath = $ppaBatch->ppa_signed_by_lc;
        }

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath);
        }

        abort(404, 'The required signed PPA file was not found.');
    }

    public function uploadFinalSignature(Request $request)
    {
        $request->validate([
            'batch_id'          => 'required|string|exists:pgsql.Benefit.ppa_batch_files,batch_id',
            'signed_ppa_file'   => 'required|file|mimes:pdf,jpeg,png,jpg',
        ]);

        $batchId = $request->batch_id;
        $user = auth()->user();

        try {
            DB::transaction(function () use ($request, $batchId, $user) {
                $ppaBatch = PpaBatchFile::where('batch_id', $batchId)->firstOrFail();

                // Determine actions and statuses based on the user's role
                if ($user->role_id == 16) { // Labour Commissioner (LC)
                    $fromStatus = 'forwarded_to_lc_for_sign';
                    $toStatus = 'forwarded_to_lm_for_sign';
                    $action = 'PPA_SIGNED_BY_LC';
                    $comment = 'PPA signed by LC and forwarded to LM for Batch ID: ' . $batchId;
                    $filePathColumn = 'ppa_signed_by_lc';
                    $timestampColumn = 'lc_signed_at';
                    $storagePath = 'signed_ppa_files/lc';
                } elseif ($user->role_id == 17) { // Labour Minister (LM)
                    $fromStatus = 'forwarded_to_lm_for_sign';
                    $toStatus = 'forwarded_to_ho_for_disbursed';
                    $action = 'PPA_SIGNED_BY_LM';
                    $comment = 'PPA signed by LM and forwarded for disbursement for Batch ID: ' . $batchId;
                    $filePathColumn = 'ppa_signed_by_lm';
                    $timestampColumn = 'lm_signed_at';
                    $storagePath = 'signed_ppa_files/lm';
                } else {
                    throw new \Exception('You do not have permission to perform this action.');
                }

                // Prevent re-uploading
                if ($ppaBatch->$filePathColumn) {
                    throw new \Exception('This batch has already been signed by your office.');
                }

                // Store the uploaded file
                $path = $request->file('signed_ppa_file')->store($storagePath, 'public');

                // Update the PpaBatchFile record
                $ppaBatch->$filePathColumn = $path;
                $ppaBatch->$timestampColumn = now();
                $ppaBatch->save();

                // Get all application IDs in the batch that are in the correct state
                $applicationIds = FormSubmission::where('batch_id', $batchId)
                    ->where('status', $fromStatus)
                    ->pluck('id');

                if ($applicationIds->isEmpty()) {
                    throw new \Exception('No applications in the correct state were found for this batch.');
                }

                // Update all form submissions in the batch
                FormSubmission::whereIn('id', $applicationIds)->update(['status' => $toStatus]);

                // ===================================================================
                // NEW AND IMPROVED LOGGING LOGIC
                // ===================================================================
                $logEntries = [];
                $now = now(); // Use a single timestamp for all logs in this transaction

                // Loop through each application ID to prepare a log entry
                foreach ($applicationIds as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id, // Log against the specific application
                        'user_id'            => $user->id,
                        'action'             => $action,
                        'comment'            => $comment,
                        'file_path'          => $path, // Associate the uploaded file with every log
                        'from_status'        => $fromStatus,
                        'to_status'          => $toStatus,
                        'created_at'         => $now,
                        'updated_at'         => $now,
                    ];
                }

                // Insert all log entries in a single, efficient database query
                if (!empty($logEntries)) {
                    BenefitSubmissionLog::insert($logEntries);
                }
                // ===================================================================

            });

            return redirect()->back()->with('success', 'Signed PPA uploaded and batch forwarded successfully!');
        } catch (\Exception $e) {
            Log::error('Final PPA Signature Upload Failed: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
}
