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
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Get all unique scheduled meeting dates that have pending applications
        $availableDates = FormSubmission::where('status', 'under_scrutiny')
            ->whereHas('worker', function ($query) use ($user) {
                $query->where('office_id', $user->office_id);
            })
            ->whereNotNull('scrutiny_meeting_date')
            ->orderBy('scrutiny_meeting_date', 'asc')
            ->pluck('scrutiny_meeting_date')
            ->unique()
            ->values();

        // 2. Set the selected date (either from the dropdown filter, or default to the oldest date)
        $selectedDate = $request->input('meeting_date', $availableDates->first());

        // 3. Fetch applications ONLY for the selected date
        $hoForwardingApplications = collect();
        if ($selectedDate) {
            $hoForwardingApplications = FormSubmission::with(['benefit', 'worker.districtName'])
                ->where('status', 'under_scrutiny')
                ->where('scrutiny_meeting_date', $selectedDate)
                ->whereHas('worker', function ($query) use ($user) {
                    $query->where('office_id', $user->office_id);
                })
                ->latest()
                ->get(); // Using get() instead of paginate so they can submit the whole meeting at once
        }

        // History of previously uploaded document batches
        $uploadHistory = HoForwardingDocument::with('user')
            ->where('office_id', $user->office_id)
            ->latest()
            ->take(10)
            ->get();

        return view('office.benefits.ho-forwarding', compact('hoForwardingApplications', 'uploadHistory', 'availableDates', 'selectedDate'));
    }

    // Combine Upload and Status changes into ONE action
    public function processMeetingResults(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meeting_date' => 'required|date',
            'meetingMinutes' => 'required|file|mimes:pdf,docx,xlsx|max:5120',
            'attendanceSheet' => 'required|file|mimes:pdf,docx,xlsx|max:5120',
            'acceptedList' => 'required|file|mimes:pdf,docx,xlsx|max:5120',
            'rejectedList' => 'required|file|mimes:pdf,docx,xlsx|max:5120',
            'decisions' => 'required|array', // Array of application IDs and their decisions
            'decisions.*' => 'required|in:forward,reject,revert',
            'sanctioned_amounts' => 'nullable|array',
            'sanctioned_amounts.*' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();

            // 1. Handle File Uploads
            $documentData = [
                'office_id' => $user->office_id,
                'user_id' => $user->id,
                'submission_date' => $request->meeting_date, // Tie the docs to the meeting date
                'meeting_minutes_path' => $request->file('meetingMinutes')->store('ho_documents/minutes', 'public'),
                'attendance_sheet_path' => $request->file('attendanceSheet')->store('ho_documents/attendance', 'public'),
                'accepted_list_path' => $request->file('acceptedList')->store('ho_documents/accepted', 'public'),
                'rejected_list_path' => $request->file('rejectedList')->store('ho_documents/rejected', 'public'),
            ];
            HoForwardingDocument::create($documentData);

            // 2. Process Decisions
            $logEntries = [];
            $now = now();
            $assigned_to_user_id = User::where('status', 1)->where('role_id', 7)->first()->id ?? null;

            foreach ($request->decisions as $applicationId => $decision) {
                $newStatus = '';
                $logAction = '';

                switch ($decision) {
                    case 'forward':
                        $newStatus = 'forwarded_to_ho';
                        $logAction = 'FORWARD_TO_HO';
                        break;
                    case 'reject':
                        $newStatus = 'rejected_by_scrutiny';
                        $logAction = 'REJECT_BY_SCRUTINY';
                        break;
                    case 'revert':
                        $newStatus = 'reverted_by_scrutiny';
                        $logAction = 'REVERT_FROM_SCRUTINY';
                        break;
                }

                // Update individual application and optionally save sanctioned amount
                $updateData = [
                    'status' => $newStatus,
                    'assigned_to_user_id' => ($decision === 'forward') ? $assigned_to_user_id : null
                ];

                $sanctioned = $request->input('sanctioned_amounts.' . $applicationId, null);
                if ($sanctioned !== null && $sanctioned !== '') {
                    // cast to proper numeric format
                    $updateData['sanctioned_amount'] = $sanctioned;
                }

                FormSubmission::where('id', $applicationId)->update($updateData);

                // Prepare Log
                $logEntries[] = [
                    'form_submission_id' => $applicationId,
                    'user_id' => Auth::id(),
                    'action' => $logAction,
                    'comment' => "Meeting decision applied by " . $user->username,
                    'from_status' => 'under_scrutiny',
                    'to_status' => $newStatus,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            BenefitSubmissionLog::insert($logEntries);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Meeting results processed and documents uploaded successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            // return $e;
            Log::error("HO Meeting Processing Failed: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while saving the meeting data.'], 500);
        }
    }

    public function exportMeetingReport($date)
    {
        // 1. Fetch all applications that were processed on this meeting date
        $applications = FormSubmission::with(['benefit', 'worker'])
            ->where('scrutiny_meeting_date', $date)
            ->whereIn('status', ['forwarded_to_ho', 'rejected_by_scrutiny', 'reverted'])
            ->get();

        // 2. Setup the CSV headers
        $fileName = 'Meeting_Report_' . \Carbon\Carbon::parse($date)->format('Y_m_d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // 3. Define the column headers for the Excel/CSV file
        $columns = ['Application ID','ID Card', 'Applicant Name', 'Benefit Scheme', 'Final Decision', 'Processed At'];

        // 4. Generate the file in memory
        $callback = function() use($applications, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($applications as $app) {
                // Format the status cleanly (e.g., "FORWARDED TO HO")
                $decision = str_replace('_', ' ', strtoupper($app->status));

                fputcsv($file, [
                    $app->application_id,
                    $app->worker->id_card,
                    $app->getApplicantDetails()->name ?? 'N/A',
                    $app->benefit->name ?? 'N/A',
                    $decision,
                    $app->updated_at->format('M d, Y - h:i A')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
