<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\BenefitSubmissionLog;
use App\Models\CashAwardForEducationApplication;
use App\Models\EducationScholarshipApplication;
use App\Models\FormSubmission;
use App\Models\FormSubmissionData;
use App\Models\User;
use App\Services\GetVaultDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class BenefitManagementController extends Controller
{
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService = $getVaultDataService;
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = FormSubmission::with('benefit', 'worker');
        $data = [];

        // Role-based filtering for which applications to show
        switch ($user->role_id) {
            case 2: // HRO sees newly submitted and reverted applications
                $query->whereIn('status', ['submitted', 'send_back_to_hro']);
                $data['forwardedApplications'] = FormSubmission::with('benefit', 'worker')->whereIn('status', ['forwarded_to_ro', 'send_back_to_ro'])->latest()->paginate(20);
                break;
            case 3: // RO sees applications forwarded to them
                $query->whereIn('status', ['forwarded_to_ro', 'send_back_to_ro'])->where('assigned_to_user_id', $user->id);
                break;
            case 4: // DA sees applications forwarded to them
                $query->where('status', 'forwarded_to_da')->where('assigned_to_user_id', $user->id);
                break;
            default:
                $query->whereRaw('1 = 0');
                break;
        }

        $submittedApplications = $query->latest()->paginate(10);
        $availableBenefits = Benefit::where('status', 1)->get();

        // Ensure $data has keys for optional lists to avoid undefined index in views
        // Forwarded may already be set above for certain roles; normalize it.
        $data['forwardedApplications'] = $data['forwardedApplications'] ?? collect();

        // Approved applications for this office (visible to HRO and others for reporting)
        $data['approvedApplications'] = FormSubmission::with(['benefit', 'worker'])
            ->where('status', 'approved')
            ->whereHas('worker', function ($q) use ($user) {
                $q->where('office_id', $user->office_id);
            })
            ->latest()
            ->paginate(20);

        // Rejected applications for this office
        $data['rejectedApplications'] = FormSubmission::with(['benefit', 'worker'])
            ->where('status', 'rejected')
            ->whereHas('worker', function ($q) use ($user) {
                $q->where('office_id', $user->office_id);
            })
            ->latest()
            ->paginate(20);
        $data['revertedApplications'] = FormSubmission::with(['benefit', 'worker'])
            ->where('status', 'reverted')
            ->whereHas('worker', function ($q) use ($user) {
                $q->where('office_id', $user->office_id);
            })
            ->latest()
            ->paginate(20);

        // Reverted / Sent-back applications (include common reverted/send_back statuses)
        $revertedStatuses = ['send_back_to_hro', 'send_back_to_ro', 'reverted_to_hro', 'reverted_to_ro', 'send_back'];
        $data['sendBackApplications'] = FormSubmission::with(['benefit', 'worker'])
            ->whereIn('status', $revertedStatuses)
            ->whereHas('worker', function ($q) use ($user) {
                $q->where('office_id', $user->office_id);
            })
            ->latest()
            ->paginate(20);

        // --- START OF REVISED LOGIC FOR ROLES AND USERS ---

        $forwardableRoleIds = [];
        $scrutinyApplications = collect();
        switch ($user->role_id) {
            case 2: // HRO can forward to RO (3) and DA (4)
                $forwardableRoleIds = [3, 4];
                $scrutinyApplications = FormSubmission::with(['benefit', 'worker'])
                    ->where('status', 'approved')
                    ->whereHas('worker', function ($query) use ($user) {
                        $query->where('office_id', $user->office_id);
                    })
                    ->latest()
                    ->paginate(1, ['*'], 'scrutiny_page');
                $scrutinyApplications->withPath(route('office.dashboard.benefits.scrutiny-data'));
                break;
            case 3:
                $forwardableRoleIds = [4];
                break;
            case 4:
                $forwardableRoleIds = [2, 3];
                break;
        }

        // Fetch the Role models for the dropdown
        $roles = Role::whereIn('id', $forwardableRoleIds)->get();

        // Fetch all possible users for those roles in the same office
        $users = User::with('role')->where('office_id', $user->office_id)
            ->whereIn('role_id', $forwardableRoleIds)
            ->where('status', 1)
            ->where('id', '!=', $user->id)
            ->get();

        // --- END OF REVISED LOGIC ---
        // return $submittedApplications;
        // return $data['forwardedApplications'];
        return view('office.benefits.index', [
            'submittedApplications' => $submittedApplications,
            'availableBenefits' => $availableBenefits,
            'users' => $users,
            'roles' => $roles,
            'scrutinyApplications' => $scrutinyApplications,
            'data' => $data
        ]);
    }




    public function filterApplications(Request $request)
    {

        $user = Auth::user();
        $query = FormSubmission::with('benefit', 'worker');

        switch ($user->role_id) {
            case 2:
                $query->whereIn('status', ['submitted', 'send_back_to_hro']);
                break;
            case 3:
                $query->whereIn('status', ['forwarded_to_ro', 'send_back_to_ro'])->where('assigned_to_user_id', $user->id);
                break;
            case 4:
                $query->where('status', 'forwarded_to_da')->where('assigned_to_user_id', $user->id);
                break;
            default:
                $query->whereRaw('1 = 0');
                break;
        }

        if ($request->filled('benefit_id')) {
            $query->where('benefit_id', $request->benefit_id);
        }

        $submittedApplications = $query->latest()->paginate(10);
        $currentBenefit = $request->filled('benefit_id') ? Benefit::find($request->benefit_id) : null;
        $tableHtml = view('office.benefits._applications_table', [
            'submittedApplications' => $submittedApplications,
            'showCheckboxes' => true // <-- ADD THIS LINE
        ])->render();
        // $tableHtml = view('office.benefits._applications_table', compact('submittedApplications'))->render();
        $paginationHtml = $submittedApplications->appends($request->query())->links()->toHtml();

        return response()->json([
            'table_html' => $tableHtml,
            'pagination_html' => $paginationHtml,
            'benefit_name' => $currentBenefit ? $currentBenefit->name : 'All Schemes',
        ]);
    }


    public function forwardApplication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:pgsql.User.users,id',
            'comment' => 'required|string|max:500',
            'application_ids' => 'required|array|min:1',
            'application_ids.*' => 'required|numeric|exists:pgsql.Benefit.form_submissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $validatedData = $validator->validated();
            $targetUserId = $validatedData['user_id'];
            $targetUser = User::findOrFail($targetUserId);
            $applicationIds = $validatedData['application_ids'];
            $comment = $validatedData['comment'];
            $currentUserId = Auth::id();

            $to_status = '';
            $action = 'FORWARD';
            switch ($targetUser->role_id) {
                case 2:
                    $to_status = 'reverted_to_hro';
                    $action = 'REVERT_TO_HRO';
                    break;
                case 3:
                    $to_status = 'forwarded_to_ro';
                    $action = 'FORWARD_TO_RO';
                    break;
                case 4:
                    $to_status = 'forwarded_to_da';
                    $action = 'FORWARD_TO_DA';
                    break;
                default:
                    throw new \Exception("Invalid target role for forwarding.");
            }

            $logEntries = [];
            $now = now();
            $submissionsToUpdate = FormSubmission::whereIn('id', $applicationIds)->get();

            foreach ($submissionsToUpdate as $submission) {
                $logEntries[] = [
                    'form_submission_id' => $submission->id,
                    'user_id'            => $currentUserId,
                    'action'             => $action,
                    'comment'            => $comment,
                    'from_status'        => $submission->status,
                    'to_status'          => $to_status,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ];
            }

            FormSubmission::whereIn('id', $applicationIds)->update([
                'status' => $to_status,
                'assigned_to_user_id' => $targetUserId,
            ]);
            BenefitSubmissionLog::insert($logEntries);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Application(s) forwarded successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error forwarding applications: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred.'], 500);
        }
    }


    public function preview($application_number)
    {

        // $application->load(['formSubmissionData.formField' => function ($query) {
        //     $query->orderBy('order', 'asc');
        // }]);


        // $html = view('office.benefits.application-preview', compact('application'))->render();
        $application_data = FormSubmission::where('application_id', $application_number)->first();
        $benefit = Benefit::where('id', $application_data->benefit_id)->first();
        // return $benefit;
        switch ($benefit->benefit_code) {
            case 'EA':
                $application = EducationScholarshipApplication::where('application_number', $application_data->application_id)
                    ->firstOrFail();

                $html = view('office.benefits.partials.previews.ea-preview', compact('application'))->render();

                break;

            case 'CE':
                $application = CashAwardForEducationApplication::where('application_number', $application_data->application_id)
                    ->firstOrFail();

                $html = view('office.benefits.partials.previews.ea-preview', compact('application'))->render();

                break;
        }



        return response()->json([
            'html' => $html,
            'application_id' => $application_number
        ]);
    }

    public function showFile(FormSubmissionData $data)
    {

        $submission = $data->formSubmission;


        $filePath = $data->value;


        if (Storage::exists($filePath)) {
            // Get full path
            $fullPath = Storage::path($filePath);

            return response()->file($fullPath);
        } else {
            abort(404, 'File not found');
        }
    }


    public function logs(FormSubmission $application)
    {
        $application->load(['logs' => function ($query) {
            $query->with('user')->oldest();
        }]);
        $vaultData = $this->getVaultDataService->getVaultData($application->worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);
        // return $application;
        // Render a "partial" view (just the HTML for the timeline).
        $html = view('worker.benefits.tracking-timeline', compact('application', 'getVaultData'))->render();

        // Return the HTML in a JSON response.
        return response()->json(['html' => $html]);
    }


    public function sendBackApplication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'target_user_id' => 'required|exists:pgsql.User.users,id',
            'application_id' => 'required|exists:pgsql.Benefit.form_submissions,id',
            'comment' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid data provided.'], 422);
        }

        DB::beginTransaction();
        try {
            $validatedData = $validator->validated();
            $applicationId = $validatedData['application_id'];
            $targetUserId = $validatedData['target_user_id'];

            if (Auth::user()->role_id == 3) {
                $targetUserId = BenefitSubmissionLog::where('form_submission_id', $applicationId)->first()->user_id;
            }
            $targetUser = User::findOrFail($targetUserId);
            $submission = FormSubmission::findOrFail($applicationId);

            // Determine the "reverted" status based on the target user's role
            $to_status = 'send_back'; // A generic fallback
            switch ($targetUser->role_id) {
                case 2:
                    $to_status = 'send_back_to_hro';
                    $action = 'SEND_BACK_TO_HRO';
                    break;
                case 3:
                    $to_status = 'send_back_to_ro';
                    $action = 'SEND_BACK_TO_RO';
                    break;
            }

            // Update the submission
            $submission->update([
                'status' => $to_status,
                'assigned_to_user_id' => $targetUserId,
            ]);

            // Create a log entry for this action
            BenefitSubmissionLog::create([
                'form_submission_id' => $applicationId,
                'user_id'            => Auth::id(),
                'action'             => $action,
                'comment'            => $validatedData['comment'],
                'from_status'        => $submission->getOriginal('status'), // Get status before the update
                'to_status'          => $to_status,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Application sent back successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error sending application back: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred.'], 500);
        }
    }


    public function approveApplication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_id' => 'required|exists:pgsql.Benefit.form_submissions,id',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid data provided.'], 422);
        }

        DB::beginTransaction();
        try {
            $validatedData = $validator->validated();
            $submission = FormSubmission::findOrFail($validatedData['application_id']);
            $currentUser = Auth::user();

            // Security Check: Ensure the user is authorized to approve this.
            // For example, they must be the person it's assigned to.
            if (Auth::user()->role_id != 2) {
                if ($submission->assigned_to_user_id !== $currentUser->id) {
                    return response()->json(['success' => false, 'message' => 'You are not assigned to this application.'], 403);
                }
            }

            $fromStatus = $submission->status;

            // Update the submission
            $submission->update([
                'status' => 'approved',
                'assigned_to_user_id' => null, // The workflow ends, so un-assign it.
            ]);

            // Create a log entry for this action
            BenefitSubmissionLog::create([
                'form_submission_id' => $submission->id,
                'user_id'            => $currentUser->id,
                'action'             => 'APPROVE',
                'comment'            => $validatedData['comment'],
                'from_status'        => $fromStatus,
                'to_status'          => 'approved',
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Application approved successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error approving application: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred.'], 500);
        }
    }


    public function rejectApplication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_id' => 'required|exists:pgsql.Benefit.form_submissions,id',
            'comment' => 'required|string|min:10|max:500',
        ], [
            'comment.required' => 'A reason for rejection is mandatory.',
            'comment.min' => 'The rejection reason must be at least 10 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {
            $validatedData = $validator->validated();
            $submission = FormSubmission::findOrFail($validatedData['application_id']);
            $currentUser = Auth::user();

            // Security Check: Ensure the assigned user is rejecting it
            if (Auth::user()->role_id != 2) {
                if ($submission->assigned_to_user_id !== $currentUser->id) {
                    return response()->json(['success' => false, 'message' => 'You are not assigned to this application.'], 403);
                }
            }

            $fromStatus = $submission->status;

            // Update the submission status
            $submission->update([
                'status' => 'rejected',
                'assigned_to_user_id' => null, // Workflow ends
            ]);

            // Create a log entry
            BenefitSubmissionLog::create([
                'form_submission_id' => $submission->id,
                'user_id'            => $currentUser->id,
                'action'             => 'REJECT',
                'comment'            => $validatedData['comment'],
                'from_status'        => $fromStatus,
                'to_status'          => 'rejected',
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Application rejected successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error rejecting application: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred.'], 500);
        }
    }


    public function getScrutinyData(Request $request)
    {
        // The security check is fine.
        if (Auth::user()->role_id != 2) {
            abort(403, 'You are not authorized to view this data.');
        }

        $user = Auth::user();

        // The base query is also fine.
        $query = FormSubmission::with(['benefit', 'worker'])
            ->where('status', 'approved')
            ->whereHas('worker', function ($query) use ($user) {
                $query->where('office_id', $user->office_id);
            });

        // --- THIS IS THE SECTION WE NEED TO FIX AND MAKE ROBUST ---

        // 1. Fetch the paginated data, using our custom page name.
        $scrutinyApplications = $query->latest()->paginate(1, ['*'], 'scrutiny_page');

        // 2. IMPORTANT: Append all current query string parameters (except for the page itself)
        //    to the pagination links. This ensures that any filters will persist across pages.
        $scrutinyApplications->appends($request->except('scrutiny_page'));

        // We no longer need withPath() because appends() handles the base path correctly on AJAX requests.

        // 3. Render the partials as before.
        $tableHtml = view('office.benefits._scrutiny_table', compact('scrutinyApplications'))->render();
        $paginationHtml = $scrutinyApplications->links()->toHtml();

        // 4. Return the JSON.
        return response()->json([
            'table_html' => $tableHtml,
            'pagination_html' => $paginationHtml,
        ]);
    }


    public function pullBackApplication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_id' => 'required|exists:pgsql.Benefit.form_submissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid application ID.'], 422);
        }

        DB::beginTransaction();
        try {
            $submission = FormSubmission::findOrFail($request->application_id);
            $currentUser = Auth::user();

            // 1. Security Check: Only HRO (Role 2) can pull back
            if ($currentUser->role_id != 2) {
                return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
            }

            // 2. Status Check: Can only pull back if it's currently with an RO or DA
            $pullableStatuses = ['forwarded_to_ro', 'forwarded_to_da', 'send_back_to_ro'];
            if (!in_array($submission->status, $pullableStatuses)) {
                return response()->json(['success' => false, 'message' => 'This application cannot be pulled back as it is already being processed or has been approved/rejected.'], 422);
            }

            $fromStatus = $submission->status;
            $toStatus = 'submitted'; // Returning to the HRO's main list

            // 3. Update the submission
            $submission->update([
                'status' => $toStatus,
                'assigned_to_user_id' => $currentUser->id,
            ]);

            // 4. Log the Pull Back action
            BenefitSubmissionLog::create([
                'form_submission_id' => $submission->id,
                'user_id'            => $currentUser->id,
                'action'             => 'PULL_BACK',
                'comment'            => 'Application pulled back by HRO.',
                'from_status'        => $fromStatus,
                'to_status'          => $toStatus,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Application pulled back successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error pulling back application: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred.'], 500);
        }
    }

    public function revertApplication(Request $request)
    {
        // 1. Validate the request
        $validator = Validator::make($request->all(), [
            // Note: Adjust the table name if you aren't using the pgsql.Benefit prefix here
            'application_id' => 'required|exists:pgsql.Benefit.form_submissions,id',
            'comment'        => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        DB::beginTransaction();
        try {
            $submission = FormSubmission::findOrFail($request->application_id);
            $oldStatus = $submission->status;

            // The exact status name you use when sending back to the citizen/applicant
            $newStatus = 'reverted';

            // 2. Update the submission status
            $submission->status = $newStatus;
            $submission->assigned_to_user_id = null; // Clear the assignment since it's back with the applicant
            $submission->save();

            // 3. Log the action
            BenefitSubmissionLog::create([
                'form_submission_id' => $submission->id,
                'user_id'            => Auth::id(),
                'action'             => 'REVERT_TO_APPLICANT',
                'comment'            => $request->comment,
                'from_status'        => $oldStatus,
                'to_status'          => $newStatus,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Application successfully reverted to the applicant.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Application Revert Failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while reverting the application.'
            ], 500);
        }
    }
}
