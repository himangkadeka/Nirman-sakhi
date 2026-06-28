<?php

namespace App\Http\Controllers\Worker\Benefits;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\CashAwardForEducationApplication;
use App\Models\FormSubmission;
use App\Models\MainWorkerFamily;
use App\Services\GetVaultDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashAwardFormSubmissionController extends Controller
{
     protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService = $getVaultDataService;
    }
    // public function cashAwardBenefitstoreOrUpdate(Request $request)
    // {
    //     // 1. Validation
    //     $request->validate([
    //         'family_member_id' => 'required',
    //         // 'district' => 'required',
    //         'college_name' => 'required',
    //         'qualifying_exam_name' => 'required',
    //         'exam_marks' => 'required|array',
    //         'bank_name' => 'required',
    //         'account_number' => 'required',
    //         'doc_bank_passbook' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
    //         // Add other validation rules as needed...
    //     ]);
    //     $existingApp = Cas::where('application_number', $request->application_number)->first();
    //         $documents = [
    //             'doc_bank_passbook',
    //             'doc_caste_certificate',
    //             'doc_pass_certificate',
    //             'doc_study_certificate',
    //             'doc_admission_slip',
    //             'doc_marksheet',
    //             'doc_student_photo',
    //             'doc_student_signature',
    //             'doc_affidavit'
    //         ];

    //         foreach ($documents as $doc) {
    //             // If the document doesn't exist in DB, it is required in the request
    //             $isRequired = ($existingApp && !empty($existingApp->$doc)) ? 'nullable' : 'required';
    //             $rules[$doc] = $isRequired . '|file|mimes:jpg,jpeg,png,pdf|max:2048';
    //         }

    //     DB::beginTransaction();

    //     try {
    //         $action = $request->input('action'); // 'draft' or 'preview'
    //         $workerData = session()->get('worker');
    //         $worker_id = $workerData->worker_id;

    //         // 2. Calculate Percentage & Sanctioned Amount
    //         $totalMax = 0;
    //         $totalObtained = 0;

    //         // Loop through the exam marks JSON/Array to calculate aggregate
    //         foreach ($request->exam_marks as $mark) {
    //             $totalMax += (float) $mark['total'];
    //             $totalObtained += (float) $mark['obtained'];
    //         }

    //         // 3. Handle File Uploads
    //         $filePaths = [];
    //         $documents = [
    //             'doc_bank_passbook',
    //             'doc_caste_certificate',
    //             'doc_pass_certificate',
    //             'doc_study_certificate',
    //             'doc_admission_slip',
    //             'doc_marksheet',
    //             'doc_student_photo',
    //             'doc_student_signature',
    //             'doc_affidavit'
    //         ];

    //         foreach ($documents as $doc) {
    //             if ($request->hasFile($doc)) {
    //                 $file = $request->file($doc);
    //                 $filename = time() . '_' . $doc . '.' . $file->getClientOriginalExtension();
    //                 $path = $file->storeAs('documents/scholarship/' . $worker_id, $filename, 'public');
    //                 $filePaths[$doc] = $path;
    //             } else {
    //                 $filePaths[$doc] = null;
    //             }
    //         }

    //         // 4. Save to EducationScholarshipApplication Table
    //         $application = CashAwardForEducationApplication::updateOrCreate(
    //             [
    //                 'application_number' => $request->application_number,
    //             ],
    //             [
    //                 'worker_id' => $worker_id,
    //                 'family_member_id' => $request->family_member_id,

    //                 'application_date' => Carbon::now(),
    //                 'district' => $request->district,
    //                 'student_name' => $request->student_name,
    //                 'student_age' => $request->student_age,
    //                 'student_dob' => $request->student_dob,
    //                 'social_category' => $request->social_category,
    //                 'parent_address' => $request->parent_address,
    //                 'college_name' => $request->college_name,
    //                 'university_board' => $request->university_board,
    //                 'course_name' => $request->course_name,
    //                 'course_duration_years' => $request->course_duration_years,
    //                 'admission_date' => $request->admission_date,
    //                 'qualifying_exam_name' => $request->qualifying_exam_name,
    //                 'qualifying_exam_board' => $request->qualifying_exam_board,
    //                 'qualifying_exam_year' => $request->qualifying_exam_year,
    //                 'exam_marks' => $request->exam_marks, // JSON array
    //                 'parents_are_beneficiaries' => $request->parents_are_beneficiaries,
    //                 'last_contribution_date' => $request->last_contribution_date,
    //                 'bank_name' => $request->bank_name,
    //                 'branch_name' => $request->branch_name,
    //                 'branch_address' => $request->branch_address,
    //                 'ifsc_code' => $request->ifsc_code,
    //                 'account_number' => $request->account_number,
    //                 // Merging file paths
    //                 ...$filePaths,
    //             ]
    //         );


    //         DB::commit();

    //         if ($action === 'draft') {
    //             return redirect()->route('worker-dashboard')->with('success', 'Application saved as Draft.');
    //         } else {
    //             return $this->preview($application->id);
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
    //     }
    // }

    public function cashAwardBenefitstoreOrUpdate(Request $request){
        // return $request->all();
        $action = $request->input('action'); // 'draft' or 'preview'
        $workerData = session()->get('worker');
        $worker_id = $workerData->worker_id;

        // 1. Define Validation Rules
        $rules = [
            'family_member_id'     => 'required|exists:pgsql.Worker.main_worker_families,id',
            'application_number'   => 'required',
            'district_id'          => 'required',
        ];

        // Only apply strict validation if the user is trying to "Submit & Preview"
        if ($action === 'preview') {
            $rules = array_merge($rules, [
                'student_name'              => 'required|string|max:255',
                'student_dob'               => 'required|date',
                'student_age'               => 'required|numeric',
                'social_category'           => 'required',
                'parent_address'            => 'required|string',
                'college_name'              => 'required|string',
                'university_board'          => 'required|string',
                'course_name'               => 'required|string',
                'course_duration_years'     => 'required|numeric|min:1',
                'admission_date'            => 'required|date',
                'qualifying_exam_name'      => 'required',
                'qualifying_exam_board'     => 'required',
                'qualifying_exam_year'      => 'required',
                'exam_marks'                => 'required|array|min:1',
                'exam_marks.*.subject'      => 'required_with:exam_marks.*.total|string',
                'exam_marks.*.total'        => 'required_with:exam_marks.*.subject|numeric',
                'exam_marks.*.obtained'     => 'required_with:exam_marks.*.subject|numeric',
                'parents_are_beneficiaries' => 'required|boolean',
                'last_contribution_date'    => 'required|date',
                'bank_name'                 => 'required|string',
                'branch_name'               => 'required|string',
                'ifsc_code'                 => 'required|string|max:11',
                'account_number'            => 'required|string',
            ]);

            // File Validation Logic: Required only if not already uploaded in the database
            $existingApp = CashAwardForEducationApplication::where('application_number', $request->application_number)->first();
            $documents = [
                'doc_bank_passbook',
                'doc_caste_certificate',
                'doc_pass_certificate',
                'doc_study_certificate',
                'doc_admission_slip',
                'doc_marksheet',
                'doc_student_photo',
                'doc_student_signature',
                'doc_affidavit'
            ];

            foreach ($documents as $doc) {
                // If the document doesn't exist in DB, it is required in the request
                $isRequired = ($existingApp && !empty($existingApp->$doc)) ? 'nullable' : 'required';
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
                'doc_caste_certificate',
                'doc_pass_certificate',
                'doc_study_certificate',
                'doc_admission_slip',
                'doc_marksheet',
                'doc_student_photo',
                'doc_student_signature',
                'doc_affidavit'
            ];

            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('documents/scholarship/' . $worker_id, $filename, 'public');
                    $filePaths[$field] = $path;
                }
            }

            // 3. Prepare Data for Save
            $dataToSave = [
                'worker_id'                 => $worker_id,
                'family_member_id'          => $request->family_member_id,
                'application_date'          => $request->application_date ?? Carbon::now(),
                'district_id'               => $request->district_id, // Matches Blade name
                'student_name'              => $request->student_name,
                'student_age'               => $request->student_age,
                'student_dob'               => $request->student_dob,
                'social_category'           => $request->social_category,
                'parent_address'            => $request->parent_address,
                'college_name'              => $request->college_name,
                'university_board'          => $request->university_board,
                'course_name'               => $request->course_name,
                'course_duration_years'     => $request->course_duration_years,
                'admission_date'            => $request->admission_date,
                'qualifying_exam_name'      => $request->qualifying_exam_name,
                'qualifying_exam_board'     => $request->qualifying_exam_board,
                'qualifying_exam_year'      => $request->qualifying_exam_year,
                'exam_marks'                => $request->exam_marks,
                'parents_are_beneficiaries' => $request->parents_are_beneficiaries,
                'last_contribution_date'    => $request->last_contribution_date,
                'bank_name'                 => $request->bank_name,
                'branch_name'               => $request->branch_name,
                'branch_address'            => $request->branch_address,
                'ifsc_code'                 => $request->ifsc_code,
                'account_number'            => $request->account_number,
            ];

            // 4. Update or Create (Merge file paths only if they exist in the $filePaths array)
            $application = CashAwardForEducationApplication::updateOrCreate(
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
            return $e;
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function preview($id)
    {
        $workerData = session()->get('worker');
        $application = CashAwardForEducationApplication::where('id', $id)
            ->where('worker_id', $workerData->worker_id)
            ->firstOrFail();
        $application_name = Benefit::where('benefit_code',"CE")->first();
        // return $application_name;
        return view('worker.benefits.forms.cash-award-application.preview-scholarship', compact('application','application_name'));
    }

    public function finalSubmitCashAward($id)
    {
        $application = CashAwardForEducationApplication::findOrFail($id);
        $submission = FormSubmission::where('application_id',$application->application_number)->first();
        //  dd('ssss');
        // Prevent double submission
        if ($application->status === 'submitted' && $submission->status === 'submitted') {
            // dd('sss');
            return redirect()->route('acknowledgement-cash', $id);
        }

        DB::beginTransaction();
        try {
            // 1. Calculate Percentage & Sanctioned Amount
            $totalMax = 0;
            $totalObtained = 0;
            if ($application->exam_marks) {
                foreach ($application->exam_marks as $mark) {
                    $totalMax += (float) ($mark['total'] ?? 0);
                    $totalObtained += (float) ($mark['obtained'] ?? 0);
                }
            }

            $percentage = ($totalMax > 0) ? ($totalObtained / $totalMax) * 100 : 0;
            $sanctioned_amount = 0;



            // 2. Create Master FormSubmission Entry
            FormSubmission::where('application_id',$application->application_number)->update([
                // 'benefit_id' => 4, // Education Scholarship ID
                // 'application_id' => $application->id,
                // 'worker_id' => $application->worker_id,
                'status' => 'submitted',
                // 'sanctioned_amount' => $sanctioned_amount,
                'applicant_family_member_id' => $application->family_member_id,
                'submitted_at' => Carbon::now(),
            ]);

            // 3. Update Application Status
            $application->update(['status' => 'submitted']);

            DB::commit();

            return redirect()->route('acknowledgement-cash', $application->id);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function acknowledgementCash($id)
    {
        $workerData = session()->get('worker');
        $worker_id = $workerData->worker_id;
        $application = CashAwardForEducationApplication::findOrFail($id);
        $submission = FormSubmission::where('application_id', $application->application_number)->first();
        $selected_member = MainWorkerFamily::where('id', $submission->applicant_family_member_id)->first();
        $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);

        $familyVaultData = $this->getVaultDataService->getFamilyVaultData($submission->applicant_family_member_id);
        $applicantVaultDetails = json_decode($familyVaultData->getData(), true);
        // return $applicantVaultDetails
        return view('worker.benefits.forms.cash-award-application.cash-award-scholarship-acknowledgment', compact('application', 'submission', 'getVaultData', 'applicantVaultDetails', 'workerData'));
    }

}
