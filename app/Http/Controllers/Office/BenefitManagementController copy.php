<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\BenefitSubmissionLog;
use App\Models\FormSubmission;
use App\Models\FormSubmissionData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class BenefitManagementController extends Controller
{
    public function index(Request $request)
    {
        $role_id = Auth::user()->role_id;
        switch ($role_id) {
            case 2:
                $submittedApplications = FormSubmission::where('status', 'submitted')->with('benefit')->latest()->paginate(10);
                $availableBenefits = Benefit::where('status', 1)->get();
                $roles = Role::whereIn('id', [3, 4])->get();
                $users = User::where('office_id', Auth::user()->office_id)->whereIn('role_id', [3, 4])->where('status', 1)->get();
                break;

            case 3:
                $submittedApplications = FormSubmission::where('status', 'forwarded_to_ro')->where('assigned_to_user_id', Auth::user()->id)->with('benefit')->latest()->paginate(10);
                $availableBenefits = Benefit::where('status', 1)->get();
                $roles = Role::whereIn('id', [2, 4])->get();
                $users = User::where('office_id', Auth::user()->office_id)->whereIn('role_id', [2, 4])->where('status', 1)->get();
                break;
        }

        return view('office.benefits.index', [
            'submittedApplications' => $submittedApplications,
            'availableBenefits' => $availableBenefits,
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function filterApplications(Request $request)
    {
        $role_id = Auth::user()->role_id;

        switch ($role_id) {
            case 2:
                $query = FormSubmission::with('benefit')->where('status', 'submitted');
                break;

            case 3:
                $query = FormSubmission::with('benefit')->where('status', 'forwarded_to_ro')->where('assigned_to_user_id', Auth::user()->id);
                break;
        }



        if ($request->filled('benefit_id')) {
            $query->where('benefit_id', $request->benefit_id);
        }

        $submittedApplications = $query->latest()->paginate(10);
        $currentBenefit = $request->filled('benefit_id') ? Benefit::find($request->benefit_id) : null;
        $tableHtml = view('office.benefits._applications_table', compact('submittedApplications'))->render();
        $paginationHtml = $submittedApplications->appends($request->query())->links()->toHtml();

        return response()->json([
            'table_html'      => $tableHtml,
            'pagination_html' => $paginationHtml,
            'benefit_name'    => $currentBenefit ? $currentBenefit->name : 'All Schemes',
        ]);
    }


    public function forwardApplicationToRo(Request $request)
    {
        $userOfficeId = Auth::user()->office_id;

        $rules = [
            'ro_id' => [
                'required',
                Rule::exists('pgsql.User.users', 'id')->where(function ($query) use ($userOfficeId) {
                    $query->where('office_id', $userOfficeId);
                }),
            ],
            'comment' => 'required|string|max:500',
            'application_ids' => 'required|array|min:1',
            'application_ids.*' => 'required|numeric|exists:pgsql.Benefit.form_submissions,id'
            // [

            // Rule::exists('pgsql.Benefit.form_submissions', 'id')->where(function ($query) {
            //     $query->where('status', 'submitted');
            // })
            // ],
        ];

        $messages = [
            'application_ids.*.exists' => 'One or more selected applications are invalid or have already been processed.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed. Please check the errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $validatedData = $validator->validated();
            $roId = $validatedData['ro_id'];
            switch (Auth::user()->role_id) {
                case 2:
                    $action = 'FORWARD_TO_RO';
                    $to_status = 'forwarded_to_ro';
                    break;
                case 3:
                    if (User::where('id', $roId)->first()->role_id == 2) {
                        $action = 'FORWARD_TO_RO';
                        $to_status = 'forwarded_to_ro';
                        break;
                    } elseif (User::where('id', $roId)->first()->role_id == 4) {
                        $action = 'FORWARD_TO_DA';
                        $to_status = 'forwarded_to_da';
                        break;
                    }

                case 4:
                    if (User::where('id', $roId)->first()->role_id == 2) {
                        $action = 'FORWARD_TO_HRO';
                        $to_status = 'forwarded_to_hro';
                        break;
                    } elseif (User::where('id', $roId)->first()->role_id == 3) {
                        $action = 'FORWARD_TO_RO';
                        $to_status = 'forwarded_to_ro';
                        break;
                    }
            }


            $comment = $validatedData['comment'];
            $applicationIds = $validatedData['application_ids'];
            $currentUserId = Auth::id();
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
                'assigned_to_user_id' => $roId,
            ]);

            BenefitSubmissionLog::insert($logEntries);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Application(s) forwarded successfully.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
            \Log::error('Error forwarding applications: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while forwarding the applications.'
            ], 500);
        }
    }


    public function preview(FormSubmission $application)
    {

        $application->load(['formSubmissionData.formField' => function ($query) {
            $query->orderBy('order', 'asc');
        }]);


        $html = view('office.benefits.application-preview', compact('application'))->render();

        
        return response()->json([
            'html' => $html,
            'application_id' => $application->application_id
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
}
