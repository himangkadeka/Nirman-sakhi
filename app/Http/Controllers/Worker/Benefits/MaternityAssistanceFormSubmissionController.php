<?php

namespace App\Http\Controllers\Worker\Benefits;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\FormSubmission;
use App\Models\MaternityAssistanceApplication;
use App\Models\MainWorkerForm;
use App\Services\GetVaultDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MaternityAssistanceFormSubmissionController extends Controller
{
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService = $getVaultDataService;
    }

    public function maternityAssistanceBenefitStoreOrUpdate(Request $request)
    {
         if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $action = $request->input('action'); // 'draft' or 'preview'
        $workerData = session()->get('worker');
        $worker_id = $workerData->worker_id;

        // 1. Define Base Validation Rules (Always required for Drafts & Submissions)
        $rules = [
            'application_number' => 'required',
            'district_id'        => 'required',
        ];

        // Only apply strict validation if the user is trying to "Submit & Preview"
        if ($action === 'preview') {
            $rules = array_merge($rules, [
                // Applicant Details
                'application_date'         => 'required|date',
                'applicant_name'           => 'required|string|max:255',
                'applicant_dob'            => 'required|date',
                'applicant_age'            => 'required|numeric',
                'last_contribution_date'   => 'required|date',
                'husband_name'             => 'required|string|max:255',

                // Maternity Information
                'hospital_name'            => 'required|string|max:255',
                'hospital_address'         => 'required|string',
                'date_of_confinement'      => 'required|date',
                'applied_earlier'          => 'required|in:Yes,No',

                // Conditional Validation: Previous Application Details
                'times_applied_earlier'        => 'required_if:applied_earlier,Yes|nullable|numeric|min:1',
                'previous_application_details' => 'required_if:applied_earlier,Yes|nullable|string',

                // Bank Details
                'bank_name'                => 'required|string|max:255',
                'ifsc_code'                => 'required|string|max:20',
                'branch_address'           => 'required|string',
                'bank_account_number'      => 'required|string|same:bank_account_number_confirmation',
            ]);

            $workerForm = MainWorkerForm::where('worker_id', $worker_id)->first();
            if ($workerForm && $workerForm->last_registration_date) {
                $minDate = Carbon::parse($workerForm->last_registration_date)->addYears(3)->format('Y-m-d');
                $rules['date_of_confinement'] = 'required|date|after_or_equal:' . $minDate;
            }

            // File Validation Logic
            $existingApp = MaternityAssistanceApplication::where('application_number', $request->application_number)->first();

            $documents = [
                'doc_account_paybook'     => true, // Required
                'doc_medical_certificate' => true, // Required
            ];

            foreach ($documents as $doc => $isStrictlyRequired) {
                // If strictly required AND not already uploaded, enforce 'required'. Otherwise 'nullable'.
                $isRequired = ($isStrictlyRequired && (!$existingApp || empty($existingApp->$doc))) ? 'required' : 'nullable';
                $rules[$doc] = $isRequired . '|file|mimes:jpg,jpeg,png,pdf|max:2048';
            }
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            // 2. Handle File Uploads
            $filePaths = [];
            $documentFields = [
                'doc_account_paybook',
                'doc_medical_certificate'
            ];

            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    // Saving to a distinct folder for maternity assistance
                    $path = $file->storeAs('documents/maternity_assistance/' . $worker_id, $filename, 'public');
                    $filePaths[$field] = $path;
                }
            }

            // 3. Prepare Data for Save
            $dataToSave = [
                'worker_id'                    => $worker_id,
                // Note: If you have a hidden input for family_member_id in your blade, catch it here.
                // 'family_member_id'             => $request->family_member_id,

                'district_id'                  => $request->district_id,
                'application_date'             => $request->application_date ?? Carbon::now(),
                'applicant_name'               => $request->applicant_name,
                'applicant_address'            => $request->applicant_address,
                // 'bocw_registration_number'     => $request->bocw_registration_number,

                'hospital_name'                => $request->hospital_name,
                'hospital_address'             => $request->hospital_address,
                'applicant_age'                => $request->applicant_age,
                'applicant_dob'                => $request->applicant_dob,
                'husband_name'                 => $request->husband_name,
                'date_of_confinement'          => $request->date_of_confinement,

                'applied_earlier'              => $request->applied_earlier,
                'times_applied_earlier'        => $request->times_applied_earlier,
                'previous_application_details' => $request->previous_application_details,

                'last_contribution_date'       => $request->last_contribution_date,

                'bank_name'                    => $request->bank_name,
                'ifsc_code'                    => $request->ifsc_code,
                'branch_address'               => $request->branch_address,
                'bank_account_number'          => $request->bank_account_number,

                'status'                       => ($action === 'draft') ? 'Draft' : 'Submitted',
            ];

            // 4. Update or Create Application Data
            $application = MaternityAssistanceApplication::updateOrCreate(
                ['application_number' => $request->application_number],
                array_merge($dataToSave, $filePaths)
            );

            DB::commit();

            if ($action === 'draft') {
                return redirect()->route('worker-dashboard')->with('success', 'Application saved as Draft.');
            } else {
                return $this->preview($application->id);
            }
        } catch (\Exception $e) {
            DB::rollback();
            // Return error to the form with old inputs
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function preview($id)
    {
         if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $workerData = session()->get('worker');
        $application = MaternityAssistanceApplication::where('id', $id)
            ->where('worker_id', $workerData->worker_id)
            ->firstOrFail();

        $application_name = Benefit::where('benefit_code', "MT")->first();

        // Ensure you create this blade file matching the path
        return view('worker.benefits.forms.maternity-assistance.preview-scholarship', compact('application', 'application_name'));
    }

    public function finalSubmitMaternityAssistance($id)
    {
         if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $application = MaternityAssistanceApplication::findOrFail($id);

        $workerData = session()->get('worker');
        $worker_id = $workerData->worker_id;

        // Eligibility check: ensure worker meets minimum years criteria (same logic as selection step)
        $isEligibleByYears = true;
        $workerForm = MainWorkerForm::where('worker_id', $worker_id)->first();
        if ($workerForm && $workerForm->last_registration_date && $workerForm->subscription_validity_date) {
            $regDate = Carbon::parse($workerForm->last_registration_date);
            $valDate = Carbon::parse($workerForm->subscription_validity_date);
            if ($regDate->diffInYears($valDate) < 3) {
                $isEligibleByYears = false;
            }
        }

        if (!$isEligibleByYears) {
            return back()->with('error', 'You are not eligible to apply for this benefit yet (minimum subscription period not met).');
        }

        // Prevent duplicate final submissions by the same worker for this benefit
        $benefitId = Benefit::where('benefit_code', 'MT')->value('id');
        // Count distinct family members for which this worker already has submitted applications
        $existingDistinctApplicants = FormSubmission::where('worker_id', $worker_id)
            ->where('benefit_id', $benefitId)
            ->whereNotNull('submitted_at')
            ->distinct()
            ->count('applicant_family_member_id');

        // Allow if the current application belongs to a family member who already has a submitted application
        $currentFamilyMemberId = $application->family_member_id ?? null;
        $currentAlreadySubmitted = false;
        if ($currentFamilyMemberId) {
            $currentAlreadySubmitted = FormSubmission::where('worker_id', $worker_id)
                ->where('benefit_id', $benefitId)
                ->where('applicant_family_member_id', $currentFamilyMemberId)
                ->whereNotNull('submitted_at')
                ->exists();
        }

        // Enforce maximum of 2 distinct family members per worker for this benefit
        if ($existingDistinctApplicants >= 2 && !$currentAlreadySubmitted) {
            return back()->with('error', 'Maximum of 2 family members can apply for this benefit.');
        }

        // Locate or setup the master form submission
        $submission = FormSubmission::where('application_id', $application->application_number)->first();

        // Prevent double submission
        if ($application->status === 'Submitted' && $submission && $submission->status === 'submitted') {
            return redirect()->route('acknowledgement-maternity', $id);
        }

        DB::beginTransaction();
        try {
            // 1. Update or Create Master FormSubmission Entry
            if ($submission) {
                $submission->update([
                    'status' => 'submitted',
                    'sanctioned_amount' => 20000,
                    'submitted_at' => Carbon::now(),
                ]);
            } else {
                // If it doesn't exist, create it (depends on how your prior setup handles initial creation)
                FormSubmission::create([
                    'application_id' => $application->application_number,
                    'worker_id' => $application->worker_id,
                    'benefit_id' => Benefit::where('benefit_code', 'MT')->value('id'),
                    'sanctioned_amount' => 20000,
                    'status' => 'submitted',
                    'submitted_at' => Carbon::now(),
                ]);
            }

            // 2. Update Application Status
            $application->update(['status' => 'Submitted']);

            DB::commit();

            return redirect()->route('acknowledgement-maternity', $application->id);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function acknowledgementMaternityAssistance($id)
    {
        $workerData = session()->get('worker');
        $worker_id = $workerData->worker_id;

        $application = MaternityAssistanceApplication::findOrFail($id);
        $submission = FormSubmission::where('application_id', $application->application_number)->first();

        // Get Worker Vault Data
        $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);

        // Ensure you create this blade file matching the path
        return view('worker.benefits.forms.maternity-assistance.maternity-acknowledgment', compact(
            'application',
            'submission',
            'getVaultData',
            'workerData'
        ));
    }
}
