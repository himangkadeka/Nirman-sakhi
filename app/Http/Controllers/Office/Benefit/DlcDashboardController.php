<?php

namespace App\Http\Controllers\Office\Benefit;

use App\Http\Controllers\Controller;
use App\Models\BenefitSubmissionLog;
use App\Models\FormSubmission;
use App\Models\PpaBatchFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DlcDashboardController extends Controller
{
    public function index()
    {
        $applications = FormSubmission::with(['worker', 'benefit'])
            ->where('status', 'forwarded_to_dlc')
            ->latest()
            ->paginate(20);
        return view('office.benefits.dlc-dashboard.index', compact('applications'));
    }

    public function forwardToLc(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:pgsql.Benefit.form_submissions,id',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $submission = FormSubmission::findOrFail($validated['application_id']);

                // Ensure we are forwarding from the correct status
                if ($submission->status !== 'forwarded_to_dlc') {
                    // This is a server-side check to prevent invalid actions
                    throw new \Exception('Application is not in the correct state to be forwarded.');
                }

                $fromStatus = $submission->status;
                $toStatus = 'forwarded_to_lc';

                // Update the status
                $submission->update(['status' => $toStatus]);

                // Create log entry
                BenefitSubmissionLog::create([
                    'form_submission_id' => $submission->id,
                    'user_id'            => auth()->id(),
                    'action'             => 'FORWARDED_TO_LC',
                    'comment'            => 'Forwarded to Labour Commissioner by DLC.',
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

    public function forwardedToLc()
    {
        $applications = FormSubmission::with(['worker', 'benefit'])
            ->where('status', 'forwarded_to_lc')
            ->latest()
            ->paginate(20);
        return view('office.benefits.dlc-dashboard.forwarded-to-lc', compact('applications'));
    }

    public function signedPPA()
    {
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

        $batchIds = $pendingSignatureBatches->pluck('batch_id');
        $ppaBatchFiles = PpaBatchFile::whereIn('batch_id', $batchIds)
            ->get()
            ->keyBy('batch_id');

        return view('office.benefits.dlc-dashboard.ppa-voucher', compact('applications', 'pendingSignatureBatches', 'budgetSummary'));
    }

    public function forwardToLcForSign(Request $request)
    {
        $validated = $request->validate([
            'batch_id' => 'required|string|exists:pgsql.Benefit.form_submissions,batch_id',
        ]);

        $batchId = $validated['batch_id'];

        try {
            DB::transaction(function () use ($batchId) {
                // 1. Find all applications in this batch that are ready to be forwarded
                $applicationIds = FormSubmission::where('batch_id', $batchId)
                    ->where('status', 'ppa_signed_by_accounts')
                    ->pluck('id');

                if ($applicationIds->isEmpty()) {
                    throw new \Exception('No applications found for this batch in the correct state, or they have already been forwarded.');
                }

                // 2. Define the new status and update all applications in the batch
                $newStatus = 'forwarded_to_lc_for_sign';
                FormSubmission::whereIn('id', $applicationIds)->update(['status' => $newStatus]);

                // 3. Create log entries for every application in the batch
                $logEntries = [];
                foreach ($applicationIds as $id) {
                    $logEntries[] = [
                        'form_submission_id' => $id,
                        'user_id'            => auth()->id(),
                        'action'             => 'FORWARDED_TO_LC_FOR_SIGN',
                        'comment'            => 'Batch ' . $batchId . ' forwarded to LC for signature.',
                        'from_status'        => 'ppa_signed_by_accounts',
                        'to_status'          => $newStatus,
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];
                }
                BenefitSubmissionLog::insert($logEntries);
            });

            return response()->json(['success' => true, 'message' => 'Batch ' . $batchId . ' has been successfully forwarded to the LC for signature.']);
        } catch (\Exception $e) {
            Log::error('Forward to LC failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
