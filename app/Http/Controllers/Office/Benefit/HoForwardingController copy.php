<?php

namespace App\Http\Controllers\Office\Benefit;

use App\Http\Controllers\Controller;
use App\Models\BenefitSubmissionLog;
use App\Models\FormSubmission;
use App\Models\HoForwardingDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HoForwardingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Applications ready to be forwarded
        $hoForwardingApplications = FormSubmission::with(['benefit', 'worker.districtName'])
            ->where('status', 'under_scrutiny')
            ->whereHas('worker', function ($query) use ($user) {
                $query->where('office_id', $user->office_id);
            })
            ->latest()
            ->paginate(20);

        // History of previously uploaded document batches
        $uploadHistory = HoForwardingDocument::with('user')
            ->where('office_id', $user->office_id)
            ->latest()
            ->take(10)
            ->get();

        return view('office.benefits.ho-forwarding', compact('hoForwardingApplications', 'uploadHistory'));
    }

    public function uploadDocuments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meetingMinutes' => 'required|file|mimes:pdf,docx,xlsx|max:5120', // 5MB max
            'attendanceSheet' => 'required|file|mimes:pdf,docx,xlsx|max:5120',
            'acceptedList' => 'required|file|mimes:pdf,docx,xlsx|max:5120',
            'rejectedList' => 'required|file|mimes:pdf,docx,xlsx|max:5120',
            'submissionDateDocs' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $user = Auth::user();
            $data = [
                'office_id' => $user->office_id,
                'user_id' => $user->id,
                'submission_date' => $request->submissionDateDocs,
            ];

            // Store files and get their paths
            $data['meeting_minutes_path']  = $request->file('meetingMinutes')->store('ho_documents/minutes', 'public');
            $data['attendance_sheet_path'] = $request->file('attendanceSheet')->store('ho_documents/attendance', 'public');
            $data['accepted_list_path']    = $request->file('acceptedList')->store('ho_documents/accepted', 'public');
            $data['rejected_list_path']    = $request->file('rejectedList')->store('ho_documents/rejected', 'public');

            HoForwardingDocument::create($data);

            return response()->json(['success' => true, 'message' => 'Documents uploaded successfully!']);
        } catch (\Exception $e) {
            Log::error("HO Document Upload Failed: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred during file upload.'], 500);
        }
    }

    public function processBulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_ids' => 'required|array|min:1',
            'application_ids.*' => 'exists:pgsql.Benefit.form_submissions,id',
            'action' => 'required|string|in:forward,reject,revert',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $applicationIds = $request->application_ids;
            $action = $request->action;
            $newStatus = '';
            $logAction = '';
            $assigned_to_user_id = null;
            switch ($action) {
                case 'forward':
                    $newStatus = 'forwarded_to_ho';
                    $logAction = 'FORWARD_TO_HO';
                    $assigned_to_user_id = User::where('status', 1)->where('role_id', 7)->first()->id;
                    break;
                case 'reject':
                    $newStatus = 'rejected_by_scrutiny'; // A more specific rejected status
                    $logAction = 'REJECT_BY_SCRUTINY';
                    break;
                case 'revert':
                    // Reverting from 'under_scrutiny' should logically go back to 'approved'
                    $newStatus = 'reverted';
                    $logAction = 'REVERT_FROM_SCRUTINY';
                    break;
            }

            $submissions = FormSubmission::whereIn('id', $applicationIds)->get();
            $logEntries = [];
            $now = now();

            foreach ($submissions as $submission) {
                $logEntries[] = [
                    'form_submission_id' => $submission->id,
                    'user_id' => Auth::id(),
                    'action' => $logAction,
                    'comment' => "Bulk action '{$action}' performed by " . Auth::user()->username,
                    'from_status' => $submission->status,
                    'to_status' => $newStatus,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            FormSubmission::whereIn('id', $applicationIds)->update(['status' => $newStatus, 'assigned_to_user_id' => $assigned_to_user_id]);
            BenefitSubmissionLog::insert($logEntries);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Action performed successfully on ' . count($applicationIds) . ' applications.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("HO Bulk Action Failed: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function showDocument(HoForwardingDocument $document, string $type)
    {


        $path = null;

        // Determine the correct file path based on the 'type' parameter
        switch ($type) {
            case 'minutes':
                $path = $document->meeting_minutes_path;
                break;
            case 'attendance':
                $path = $document->attendance_sheet_path;
                break;
            case 'accepted':
                $path = $document->accepted_list_path;
                break;
            case 'rejected':
                $path = $document->rejected_list_path;
                break;
            default:
                // If an invalid type is provided, abort
                abort(404, 'Invalid document type specified.');
        }

        // Check if the path exists and the file is actually there
        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File not found on the server.');
        }

        // Return the file as a response.
        // This will display PDF/images in the browser and prompt a download for other file types.
        return response()->file(Storage::disk('public')->path($path));
    }
}
