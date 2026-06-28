<?php

namespace App\Http\Controllers\Office\Benefit;

use App\Exports\ScrutinyApplicationsExport;
use App\Http\Controllers\Controller;
use App\Mail\ScrutinyCommitteeNotification;
use App\Models\BenefitSubmissionLog;
use App\Models\FormSubmission;
use App\Models\ScrutinyCommitteeMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ScrutinyManagementController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // List 1: Applications waiting to be scheduled
        $pendingScrutinyApplications = FormSubmission::with(['benefit', 'worker'])
            ->whereIn('status', ['approved', 'rejected'])
            ->whereHas('worker', function ($query) use ($user) {
                $query->where('office_id', $user->office_id);
            })
            ->latest()
            ->paginate(10, ['*'], 'pending_page'); // Distinct pagination parameter

        // List 2: Applications already scheduled (Under Scrutiny)
        $scheduledScrutinyApplications = FormSubmission::with(['benefit', 'worker'])
            ->where('status', 'under_scrutiny')
            ->whereHas('worker', function ($query) use ($user) {
                $query->where('office_id', $user->office_id);
            })
            ->latest()
            ->paginate(10, ['*'], 'scheduled_page'); // Distinct pagination parameter

        return view('office.benefits.scrutiny-scheduling', compact(
            'pendingScrutinyApplications',
            'scheduledScrutinyApplications'
        ));
    }

    public function sendToCommittee(Request $request)
    {
        // Add validation for the new fields
        $validator = Validator::make($request->all(), [
            'application_ids'   => 'required|array|min:1',
            'application_ids.*' => 'exists:pgsql.Benefit.form_submissions,id',
            'subject'           => 'required|string|max:255',
            'message'           => 'required|string|max:2000',
            'meeting_date'      => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $validatedData = $validator->validated();
            $applicationIds = $validatedData['application_ids'];
            $subject = $validatedData['subject'];
            $message = $validatedData['message'];

            $submissions = FormSubmission::with(['worker', 'benefit'])->whereIn('id', $applicationIds)->get();

            // 1. Generate the Excel file in memory
            $fileName = 'scrutiny_applications_' . now()->format('Y_m_d_His') . '.xlsx';
            $excelData = Excel::raw(new ScrutinyApplicationsExport($submissions), \Maatwebsite\Excel\Excel::XLSX);

            // 2. Prepare and send the email
            // $committeeEmails = [
            //     'adreetgog@gmail.com',
            //     'himangkadeka5@gmail.com',
            //     'sauviknath2023@gmail.com' // Add as many emails as you need
            // ];

            $committeeEmails = ScrutinyCommitteeMember::where('office_id', Auth::user()->office_id)
                ->pluck('email')
                ->toArray();

            // 2. Only attempt to send the email if the array is not empty
            // if (!empty($committeeEmails)) {
            //     Mail::to($committeeEmails)->send(new ScrutinyCommitteeNotification($subject, $message, $excelData, $fileName));
            // } else {
            //     Log::warning("Tried to send scrutiny notification, but no committee members exist for Office ID: " . Auth::user()->office_id);
            //     return response()->json(['success' => false, 'message' => "Tried to send scrutiny notification, but no committee members exist for Office ID: " . Auth::user()->office_id], 500);
            //     // Optional: You could also throw an exception here to alert the user that they need to add members first.
            // }

            // 3. Update application status and log the action
            $newStatus = 'under_scrutiny';
            $logEntries = [];
            $now = now();
            $currentUser = Auth::id();

            foreach ($submissions as $submission) {
                $logEntries[] = [
                    'form_submission_id' => $submission->id,
                    'user_id'            => $currentUser,
                    'action'             => 'FORWARD_TO_SCRUTINY',
                    'comment'            => 'Forwarded via modal: Subject - "' . $subject . '"',
                    'from_status'        => $submission->status,
                    'to_status'          => $newStatus,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ];
            }

            FormSubmission::whereIn('id', $applicationIds)->update([
                'status' => 'under_scrutiny',
                'scrutiny_meeting_date' => $request->meeting_date // <-- Save the date here!
            ]);
            BenefitSubmissionLog::insert($logEntries);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Successfully sent ' . count($applicationIds) . ' application(s) to the Scrutiny Committee.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to send applications to Scrutiny Committee: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please check mail configuration and try again.'], 500);
        }
    }


    public function reschedule(Request $request)
    {
        // 1. Change validation to expect an array of IDs
        $validator = Validator::make($request->all(), [
            'application_ids'   => 'required|array|min:1',
            'application_ids.*' => 'exists:pgsql.Benefit.form_submissions,id',
            'subject'           => 'required|string|max:255',
            'message'           => 'required|string|max:2000',
            'meeting_date'      => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $validatedData = $validator->validated();
            $applicationIds = $validatedData['application_ids'];

            // 2. Fetch all selected submissions
            $submissions = FormSubmission::with(['worker', 'benefit'])->whereIn('id', $applicationIds)->get();

            // Generate Excel for the rescheduled applications
            $fileName = 'rescheduled_scrutiny_' . now()->format('Y_m_d_His') . '.xlsx';
            $excelData = Excel::raw(new ScrutinyApplicationsExport($submissions), \Maatwebsite\Excel\Excel::XLSX);

            // Send Email
            $committeeEmails = 'dhrubajyoti225@gmail.com';

            $committeeEmails = ScrutinyCommitteeMember::where('office_id', Auth::user()->office_id)
                ->pluck('email')
                ->toArray();

            // 2. Only attempt to send the email if the array is not empty
            if (!empty($committeeEmails)) {
                Mail::to($committeeEmails)->send(new ScrutinyCommitteeNotification($request->subject, $request->message, $excelData, $fileName));
            } else {
                Log::warning("Tried to send scrutiny notification, but no committee members exist for Office ID: " . Auth::user()->office_id);
                return response()->json(['success' => false, 'message' => "Tried to send scrutiny notification, but no committee members exist for Office ID: " . Auth::user()->office_id], 500);
                // Optional: You could also throw an exception here to alert the user that they need to add members first.
            }

            // 3. Log the Reschedule Action for EACH application
            $logEntries = [];
            $now = now();
            $currentUser = Auth::id();

            foreach ($submissions as $submission) {
                $logEntries[] = [
                    'form_submission_id' => $submission->id,
                    'user_id'            => $currentUser,
                    'action'             => 'RESCHEDULE_SCRUTINY',
                    'comment'            => 'Rescheduled: Subject - "' . $request->subject . '"',
                    'from_status'        => $submission->status,
                    'to_status'          => 'under_scrutiny', // Status stays the same
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ];
            }

            BenefitSubmissionLog::insert($logEntries);
            FormSubmission::whereIn('id', $applicationIds)->update([
                'status' => 'under_scrutiny',
                'scrutiny_meeting_date' => $request->meeting_date // <-- Save the date here!
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully rescheduled ' . count($applicationIds) . ' application(s).']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reschedule failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred during rescheduling.'], 500);
        }
    }


    public function getCommitteeMembers()
    {
        $members = ScrutinyCommitteeMember::where('office_id', Auth::user()->office_id)->latest()->get();
        return response()->json(['success' => true, 'members' => $members]);
    }

    public function storeCommitteeMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $member = ScrutinyCommitteeMember::create([
            'office_id' => Auth::user()->office_id,
            'name' => $request->name,
            'email' => $request->email,
            'designation' => $request->designation,
            'department' => $request->department,
            'phone' => $request->phone,
        ]);

        return response()->json(['success' => true, 'message' => 'Member added successfully!', 'member' => $member]);
    }

    public function deleteCommitteeMember($id)
    {
        $member = ScrutinyCommitteeMember::where('office_id', Auth::user()->office_id)->findOrFail($id);
        $member->delete();

        return response()->json(['success' => true, 'message' => 'Member removed successfully!']);
    }

    public function updateCommitteeMember(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $member = ScrutinyCommitteeMember::where('office_id', Auth::user()->office_id)->findOrFail($id);

        $member->update([
            'name' => $request->name,
            'email' => $request->email,
            'designation' => $request->designation,
            'department' => $request->department,
            'phone' => $request->phone,
        ]);

        return response()->json(['success' => true, 'message' => 'Member updated successfully!']);
    }
}
