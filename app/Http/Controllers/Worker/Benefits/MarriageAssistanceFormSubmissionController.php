<?php

namespace App\Http\Controllers\Worker\Benefits;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\FormSubmission;
use App\Models\MainWorkerForm;
use App\Models\MarriageAssistanceApplication;
use App\Services\GetVaultDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarriageAssistanceFormSubmissionController extends Controller
{
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService = $getVaultDataService;
    }
    public function marriageAssistanceBenefitstoreOrUpdate(Request $request)
    {
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
            $workerForm = MainWorkerForm::where('worker_id', $worker_id)->first();
            $minMarriageDate = null;
            if ($workerForm && $workerForm->last_registration_date) {
                $minMarriageDate = Carbon::parse($workerForm->last_registration_date)->addYears(5)->format('Y-m-d');
            }

            $rules = array_merge($rules, [
                // Basic Applicant Details
                'application_date'       => 'required|date',
                'applicant_name'         => 'required|string|max:255',
                'applicant_dob'          => 'required|date',
                'applicant_age'          => 'required|numeric',
                'social_category'        => 'required',
                'last_contribution_date' => 'required|date',
                'membership_duration'    => 'required|string',
                'received_other_assistance' => 'required|in:Yes,No',

                // Core Conditional Toggle
                'is_for_son_daughter'    => 'required|in:Yes,No',

                // Conditional Validation: Marriage of Son/Daughter
                'spouse_is_beneficiary'  => 'required_if:is_for_son_daughter,Yes',
                'child_dob'              => 'required_if:is_for_son_daughter,Yes|nullable|date',
                'child_spouse_name'      => 'required_if:is_for_son_daughter,Yes|nullable|string',
                'child_spouse_address'   => 'required_if:is_for_son_daughter,Yes|nullable|string',
                'child_marriage_date' => 'required_if:is_for_son_daughter,Yes|nullable|date|after_or_equal:' . $minMarriageDate,

                'child_marriage_number'  => 'required_if:is_for_son_daughter,Yes|nullable|numeric|min:1',

                // Conditional Validation: Marriage of Self (Female Worker)
                'self_bridegroom_name'    => 'required_if:is_for_son_daughter,No|nullable|string',
                'self_marriage_date'  => 'required_if:is_for_son_daughter,No|nullable|date|after_or_equal:' . $minMarriageDate,
                'self_marriage_place'     => 'required_if:is_for_son_daughter,No|nullable|string',
                'self_bridegroom_address' => 'required_if:is_for_son_daughter,No|nullable|string',
            ]);

            // File Validation Logic
            $existingApp = MarriageAssistanceApplication::where('application_number', $request->application_number)->first();

            // Define which documents are strictly required vs optional
            $documents = [
                'doc_bank_passbook'        => true,  // Required
                'doc_invitation_card'      => true,  // Required
                'doc_age_proof'            => true,  // Required
                'doc_marriage_certificate' => false, // Optional (Conditional based on user scenario)
                'doc_photographs'          => true,  // Required
                'doc_signatures'           => true,  // Required
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
            // 2. Handle File Uploads (Only add to array if file is actually uploaded)
            $filePaths = [];
            $documentFields = [
                'doc_bank_passbook',
                'doc_invitation_card',
                'doc_age_proof',
                'doc_marriage_certificate',
                'doc_photographs',
                'doc_signatures'
            ];

            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    // Saving to a distinct folder for marriage assistance
                    $path = $file->storeAs('documents/marriage_assistance/' . $worker_id, $filename, 'public');
                    $filePaths[$field] = $path;
                }
            }

            // 3. Prepare Data for Save
            $dataToSave = [
                // Applicant Basic Details
                'district_id'            => $request->district_id,
                'application_date'       => $request->application_date ?? Carbon::now(),
                'applicant_name'         => $request->applicant_name,
                'applicant_address'      => $request->applicant_address,
                'applicant_dob'          => $request->applicant_dob,
                'applicant_age'          => $request->applicant_age,
                'social_category'        => $request->social_category,
                'last_contribution_date' => $request->last_contribution_date,
                'membership_duration'    => $request->membership_duration,

                // Core Conditional Toggle
                'is_for_son_daughter'    => $request->is_for_son_daughter,

                // Son / Daughter Details
                'spouse_is_beneficiary'            => $request->spouse_is_beneficiary,
                'spouse_reg_details'               => $request->spouse_reg_details,
                'spouse_applied_assistance'        => $request->spouse_applied_assistance,
                'child_dob'                        => $request->child_dob,
                'child_spouse_name'                => $request->child_spouse_name,
                'child_spouse_address'             => $request->child_spouse_address,
                'child_marriage_date'              => $request->child_marriage_date,
                'child_marriage_number'            => $request->child_marriage_number,
                'child_marriage_cert_date'         => $request->child_marriage_cert_date,
                'child_marriage_cert_no'           => $request->child_marriage_cert_no,
                'child_marriage_cert_authority'    => $request->child_marriage_cert_authority,
                'child_marriage_cert_auth_address' => $request->child_marriage_cert_auth_address,
                'other_child_assistance_details'   => $request->other_child_assistance_details,

                // Self (Female Worker Only) Details
                'self_bridegroom_name'             => $request->self_bridegroom_name,
                'self_marriage_date'               => $request->self_marriage_date,
                'self_marriage_place'              => $request->self_marriage_place,
                'self_bridegroom_address'          => $request->self_bridegroom_address,
                'self_marriage_cert_date'          => $request->self_marriage_cert_date,
                'self_marriage_cert_no'            => $request->self_marriage_cert_no,
                'self_marriage_cert_authority'     => $request->self_marriage_cert_authority,
                'self_marriage_cert_auth_address'  => $request->self_marriage_cert_auth_address,

                // Other Details
                'received_other_assistance'        => $request->received_other_assistance,

                // Assuming Draft status if saved as draft
                'status'                           => ($action === 'draft') ? 'Draft' : 'Submitted',
            ];

            // 4. Update or Create (Merge file paths only if they exist in the $filePaths array)
            $application = MarriageAssistanceApplication::updateOrCreate(
                ['application_number' => $request->application_number],
                array_merge($dataToSave, $filePaths)
            );

            DB::commit();

            if ($action === 'draft') {
                return redirect()->route('worker-dashboard')->with('success', 'Application saved as Draft.');
            } else {
                // Assuming you have a preview method/route setup similar to the reference
                return $this->preview($application->id);
            }
        } catch (\Exception $e) {
            DB::rollback();
            // Returning the error in dev mode, but you might want to uncomment the fallback for production
            return $e;
            // return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }


    public function preview($id)
    {
        $workerData = session()->get('worker');
        $application = MarriageAssistanceApplication::where('id', $id)
            ->where('worker_id', $workerData->worker_id)
            ->firstOrFail();
        $application_name = Benefit::where('benefit_code', "CE")->first();
        // return $application_name;
        return view('worker.benefits.forms.marriage-assistance.preview-scholarship', compact('application', 'application_name'));
    }


    public function finalSubmitMarriageAssistance($id)
    {
        $application = MarriageAssistanceApplication::findOrFail($id);
        $submission = FormSubmission::where('application_id', $application->application_number)->first();

        // Prevent double submission (Checking against the 'Submitted' enum we defined)
        if ($application->status === 'Submitted' && $submission->status === 'submitted') {
            return redirect()->route('acknowledgement-marriage', $id);
        }

        DB::beginTransaction();
        try {
            // 1. Update Master FormSubmission Entry
            FormSubmission::where('application_id', $application->application_number)->update([
                'status' => 'submitted',
                'submitted_at' => Carbon::now(),
                'sanctioned_amount' => 25000
                // Note: Removed 'applicant_family_member_id' as Marriage Assistance doesn't use the family dropdown
                // in the same way the Education form does. Uncomment/adapt if you added it to your master table.
            ]);

            // 2. Update Application Status
            $application->update(['status' => 'Submitted']);

            DB::commit();

            return redirect()->route('acknowledgement-marriage', $application->id);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function acknowledgementMarriageAssistance($id)
    {
        $workerData = session()->get('worker');
        $worker_id = $workerData->worker_id;

        $application = MarriageAssistanceApplication::findOrFail($id);
        $submission = FormSubmission::where('application_id', $application->application_number)->first();

        // Get Worker Vault Data
        $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);

        // Note: I removed the $familyVaultData logic here. For marriage assistance, the child details
        // are stored directly in the $application model rather than referencing a family vault ID.

        return view('worker.benefits.forms.marriage-assistance.marriage-assistance-acknowledgment', compact(
            'application',
            'submission',
            'getVaultData',
            'workerData'
        ));
    }
}
