<?php

namespace App\Http\Controllers\Worker\Benefits;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\CashAwardForEducationApplication;
use App\Models\EducationScholarshipApplication;
use App\Models\FormField;
use App\Models\FormSubmission;
use App\Models\GenaralPensionApplication;
use App\Models\MainWorkerBasicDetail;
use App\Models\MainWorkerFamily;
use App\Models\MainWorkerForm;
use App\Models\MarriageAssistanceApplication;
use App\Models\MaternityAssistanceApplication;
use App\Models\MedicalAssistanceApplication;
use App\Models\NomineeRegistration;
use App\Models\User;
use App\Services\GetVaultDataService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class BenefitsController extends Controller
{

    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService = $getVaultDataService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    // public function index($benefitId)
    // {
    //     try {
    //         $workerData = session()->get('worker');
    //         $worker_id = $workerData->worker_id;

    //         $benefit = Benefit::with(['formFields' => function ($query) {
    //             $query->orderBy('order', 'asc');
    //         }])->findOrFail($benefitId);

    //         $submission = FormSubmission::firstOrCreate(
    //             [

    //                 'worker_id' => $worker_id,
    //                 'benefit_id' => $benefitId,
    //             ],
    //             [

    //                 'application_id' => $this->getApplicationId($benefit->benefit_code, $workerData->office_id, $workerData->districtName->district_name),
    //             ]
    //         );

    //         // Display a message to the user based on whether the form is new or being continued.
    //         if ($submission->wasRecentlyCreated) {
    //             Alert::success("Application Started!", "Your Application ID is: " . $submission->application_id);
    //         }
    //         // else {
    //         //     Alert::info("Welcome Back!", "Continuing application: " . $submission->application_id);
    //         // }

    //         // Fetch all previously submitted data for this form submission in a single query.
    //         // This creates an efficient key-value array like: [ 'form_field_id' => 'submitted_value' ]
    //         $submittedData = $submission->formSubmissionData()->pluck('value', 'form_field_id')->all();

    //         // --- END OF REFACTORED LOGIC ---

    //         // Fetch other necessary data for pre-filling
    //         $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
    //         $getVaultData = json_decode($vaultData->getData(), true);
    //         $wmf = MainWorkerForm::where('worker_id', $worker_id)->first();

    //         // Pass the new $submittedData array to the view.
    //         return view('worker.benefits.index', compact(
    //             'benefit',
    //             'getVaultData',
    //             'wmf',
    //             'submittedData',
    //             'submission' // This array holds all the user's previous answers
    //         ));
    //     } catch (Exception $e) {
    //         // Log the detailed error for debugging
    //         Log::error('Benefit Form Error: ' . $e->getMessage());
    //         Alert::error("An error occurred", "Could not load the application form. Please try again later.");
    //         return back();
    //     }
    // }


    public function benefitLists($category_id)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $worker = session()->get('worker');
        $vaultData = $this->getVaultDataService->getVaultData($worker->worker_id, "F");

        $getVaultData = json_decode($vaultData->getData(), true);
        $benefit_lists = Benefit::where('category_id', $category_id)->where('status', 1)->get();
        return view('worker.benefits.benefit-list-by-category', compact('benefit_lists', 'worker','getVaultData'));
    }


    public function elegibleFamilyMember($benefit_id)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }

        $workerData = session()->get('worker');
        $worker_id = $workerData->worker_id;
        $benefit = Benefit::where('id', $benefit_id)->first();

        $isEligibleByYears = true;
        $isSpouseApplied = false;
        $familyMembers = collect();

        // --- 1. YEARS MEMBERSHIP & FAMILY MEMBER FILTERING ---
        $workerForm = MainWorkerForm::where('worker_id', $worker_id)->first();
        $regDate = null;
        $valDate = null;

        if ($workerForm && $workerForm->last_registration_date && $workerForm->subscription_validity_date) {
            $regDate = Carbon::parse($workerForm->last_registration_date);
            $valDate = Carbon::parse($workerForm->subscription_validity_date);
        }

        if ($benefit->benefit_code == 'MT') {
            if ($regDate && $valDate && $regDate->diffInYears($valDate) < 3) {
                $isEligibleByYears = false;
            }
            $familyMembers = MainWorkerFamily::where('worker_id', $worker_id)->whereIn('relation', [3, 6, 8, 16])->get();
        } elseif ($benefit->benefit_code == 'MR') {
            if ($regDate && $valDate && $regDate->diffInYears($valDate) < 5) {
                $isEligibleByYears = false;
            }
            $familyMembers = MainWorkerFamily::where('worker_id', $worker_id)->whereIn('relation', [3, 6])->get();
        } elseif (in_array($benefit->benefit_code, ['CE', 'EA'])) {
            // Must be a dependent child (relation 3 or 6)
            $familyMembers = MainWorkerFamily::where('worker_id', $worker_id)->whereIn('relation', [5, 6])->get();
        }elseif(in_array($benefit->benefit_code, ['MA'])){
            $familyMembers = MainWorkerFamily::where('worker_id', $worker_id)->get();
        }

        // --- 2. SPOUSE CROSS-CHECK (Shared for MR, CE, EA) ---
        if (in_array($benefit->benefit_code, ['MR', 'CE', 'EA'])) {
            $spouse = MainWorkerFamily::where('worker_id', $worker_id)
                ->where('relation', 5) // Ensure 5 is Wife/Husband in your DB
                ->where('already_registered', 'Yes')
                ->whereNotNull('bocwwb_id')
                ->first();

            if ($spouse) {
                $spouseWorker = MainWorkerForm::where('id_card', $spouse->bocwwb_id)
                    ->orWhere('worker_id', $spouse->bocwwb_id)
                    ->first();

                if ($spouseWorker) {
                    $spouseAppCount = FormSubmission::where('worker_id', $spouseWorker->worker_id)
                        ->where('benefit_id', $benefit_id)
                        ->whereNotNull('submitted_at')
                        ->whereNotIn('status', ['draft', 'rejected'])
                        ->count();

                    if ($spouseAppCount > 0) {
                        $isSpouseApplied = true;
                    }
                }
            }
        }

        // --- 3. COUNT EXISTING APPLICATIONS ---
        // Note for EA: If "Reapply next year" means the max 2 limit resets every year,
        // you would add ->whereYear('submitted_at', date('Y')) to this query.
        $existingApplications = FormSubmission::where('worker_id', $worker_id)
            ->where('benefit_id', $benefit_id)
            ->whereNotNull('submitted_at')
            ->whereNotIn('status', ['draft'])
            ->get();

        $totalWorkerApplications = $existingApplications->count();
        $applicationsPerMember = $existingApplications->countBy('applicant_family_member_id')->toArray();

        // --- 4. PREPARE VIEW DATA ---
        $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);
        $is_paid = false;
        $nonceValue = Str::random(16);
        session()->put('nonce_value', $nonceValue);

        return view('worker.benefits.select-applicant', compact(
            'benefit',
            'familyMembers',
            'getVaultData',
            'is_paid',
            'nonceValue',
            'isEligibleByYears',
            'isSpouseApplied',
            'totalWorkerApplications',
            'applicationsPerMember'
        ));
    }


    public function completeApplication($applicationId){
        $data = FormSubmission::findOrFail($applicationId);
        if($data->status=='submitted'){
            Alert::success("Your Application is Already Submitted");
            return back();
        }
        if($data){
            Alert::success('Your Application Id is '.$data->application_id);
            return $this->viewForm($data->benefit_id, $data->applicant_family_member_id);
        }else{
            abort(404);
        }
    }


    public function viewForm($benefit_id, $member_id)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $workerData = session()->get('worker');
        $district_id =  $workerData->district;
        $id_card = $workerData->id_card;

        $worker_id = $workerData->worker_id; // Get worker_id early
        $benefit = Benefit::find($benefit_id);
        $selected_member = MainWorkerFamily::where('id', $member_id)->first();

        $submission = $this->createOrGetFormSubmission(
            [
                'worker_id' => $worker_id,
                'benefit_id' => $benefit_id,
                'applicant_family_member_id' => $member_id,
                // Important: Only create a new draft if one doesn't already exist.
                // We add status to the search criteria to avoid matching a 'submitted' record.
                'status' => null
            ],
            $workerData,
            $benefit
        );
        $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);
        // return $getVaultData;
        if ($benefit->benefit_code == "EA") {
            if (EducationScholarshipApplication::where('application_number', $submission->application_id)->exists()) {
                $submitted_data = EducationScholarshipApplication::where('application_number', $submission->application_id)->first();
            } else {
                // return $district_id;
                $submitted_data = EducationScholarshipApplication::create([
                    'worker_id' => $worker_id,
                    'family_member_id' => $member_id,
                    'application_number' => $submission->application_id,
                    'district_id' => $district_id
                ]);
            }
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($member_id);
            $applicantVaultDetails = json_decode($familyVaultData->getData(), true);
            return view('worker.benefits.forms.education-scholarship.form', compact('selected_member', 'getVaultData', 'submitted_data', 'applicantVaultDetails', 'id_card', 'benefit_id'));
        } elseif ($benefit->benefit_code == "CE") {
            if (CashAwardForEducationApplication::where('application_number', $submission->application_id)->exists()) {
                $submitted_data = CashAwardForEducationApplication::where('application_number', $submission->application_id)->first();
            } else {
                // return $district_id;
                $submitted_data = CashAwardForEducationApplication::create([
                    'worker_id' => $worker_id,
                    'family_member_id' => $member_id,
                    'application_number' => $submission->application_id,
                    'district_id' => $district_id
                ]);
            }
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($member_id);
            $applicantVaultDetails = json_decode($familyVaultData->getData(), true);
            return view('worker.benefits.forms.cash-award-application.form', compact('selected_member', 'getVaultData', 'submitted_data', 'applicantVaultDetails', 'id_card', 'benefit_id'));
        } elseif ($benefit->benefit_code == "MR") {
            // dd($worker_id);
            if (MarriageAssistanceApplication::where('application_number', $submission->application_id)->exists()) {
                $submitted_data = MarriageAssistanceApplication::where('application_number', $submission->application_id)->first();
            } else {
                // return $district_id;
                $submitted_data = MarriageAssistanceApplication::create([
                    'worker_id' => $worker_id,
                    'family_member_id' => $member_id,
                    'application_number' => $submission->application_id,
                    'district_id' => $district_id
                ]);
            }
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($member_id);
            $applicantVaultDetails = json_decode($familyVaultData->getData(), true);
            return view('worker.benefits.forms.marriage-assistance.form', compact('selected_member', 'getVaultData', 'submitted_data', 'applicantVaultDetails', 'id_card', 'benefit_id'));
        } elseif ($benefit->benefit_code == "MT") {
            $workerForm = MainWorkerForm::where('worker_id', $worker_id)->first();
            $regDate = null;
            if ($workerForm && $workerForm->last_registration_date) {
                $regDate = Carbon::parse($workerForm->last_registration_date);
            }
            if (MaternityAssistanceApplication::where('application_number', $submission->application_id)->exists()) {
                $submitted_data = MaternityAssistanceApplication::where('application_number', $submission->application_id)->first();
            } else {
                // return $district_id;
                $submitted_data = MaternityAssistanceApplication::create([
                    'worker_id' => $worker_id,
                    'family_member_id' => $member_id,
                    'application_number' => $submission->application_id,
                    'district_id' => $district_id
                ]);
            }
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($member_id);
            $applicantVaultDetails = json_decode($familyVaultData->getData(), true);
            $last_subscription_date = $workerData->subscription_validity_date;
            $minConfinementDate = $regDate ? $regDate->copy()->addYears(3)->format('Y-m-d') : null;
            return view('worker.benefits.forms.maternity-assistance.form', compact('selected_member', 'getVaultData', 'submitted_data', 'applicantVaultDetails', 'id_card', 'benefit_id', 'last_subscription_date', 'minConfinementDate'));
        } elseif ($benefit->benefit_code == "MA") {
            if (MedicalAssistanceApplication::where('application_number', $submission->application_id)->exists()) {
                $submitted_data = MedicalAssistanceApplication::where('application_number', $submission->application_id)->first();
            } else {
                // return $district_id;
                $submitted_data = MedicalAssistanceApplication::create([
                    'worker_id' => $worker_id,
                    'family_member_id' => $member_id,
                    'application_number' => $submission->application_id,
                    'district_id' => $district_id
                ]);
            }
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($member_id);
            $applicantVaultDetails = json_decode($familyVaultData->getData(), true);
            return view('worker.benefits.forms.medical-assistance.form', compact('selected_member', 'getVaultData', 'submitted_data', 'applicantVaultDetails', 'id_card', 'benefit_id'));
        } elseif ($benefit->benefit_code == "GP") {
            if (GenaralPensionApplication::where('application_number', $submission->application_id)->exists()) {
                $submitted_data = GenaralPensionApplication::where('application_number', $submission->application_id)->first();
            } else {
                // return $district_id;
                $submitted_data = GenaralPensionApplication::create([
                    'worker_id' => $worker_id,
                    'family_member_id' => $member_id,
                    'application_number' => $submission->application_id,
                    'district_id' => $district_id
                ]);
            }
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($member_id);
            $applicantVaultDetails = json_decode($familyVaultData->getData(), true);
            return view('worker.benefits.forms.general-pension.form', compact('selected_member', 'getVaultData', 'submitted_data', 'applicantVaultDetails', 'id_card', 'benefit_id'));
        }
    }


    public function submitBenefitApplication(Request $request, $benefit_id)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        // return $request->all();
        $benefit_code = Benefit::where('id', $benefit_id)->first()->benefit_code;

        if ($benefit_code == 'EA') {
            $form_submission = app(BenefitFormSubmissionController::class);
            return $form_submission->educationBenefitstoreOrUpdate($request);
        } elseif ($benefit_code == 'CE') {
            $form_submission = app(CashAwardFormSubmissionController::class);
            return $form_submission->cashAwardBenefitstoreOrUpdate($request);
        } elseif ($benefit_code == "MR") {
            $form_submission = app(MarriageAssistanceFormSubmissionController::class);
            return $form_submission->marriageAssistanceBenefitstoreOrUpdate($request);
        } elseif ($benefit_code == "MT") {
            $form_submission = app(MaternityAssistanceFormSubmissionController::class);
            return $form_submission->maternityAssistanceBenefitstoreOrUpdate($request);
        }
    }






    public function index($benefitId)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        try {
            $workerData = session()->get('worker');
            $worker_id = $workerData->worker_id; // Get worker_id early
            $benefit = Benefit::findOrFail($benefitId);
            $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
            $getVaultData = json_decode($vaultData->getData(), true);
            $is_paid = false;


            // --- AUTHORIZATION CHECK 1: ROLE ELIGIBILITY ---
            // if (!$benefit->isAccessibleByWorker($workerData)) {
            //     Alert::error("Access Denied", "You are not eligible to apply for this scheme.");
            //     return redirect()->back();
            // }

            // =================================================================
            // == START: NEW MAXIMUM APPLICATION CHECK ==
            // =================================================================
            // We check this BEFORE creating a new submission record.
            // if ($benefit->hasReachedApplicationLimit($worker_id)) {
            //     Alert::error("Limit Reached", "You have already reached the maximum number of applications for this scheme.");
            //     return redirect()->back();
            // }
            // =================================================================
            // == END: NEW MAXIMUM APPLICATION CHECK ==
            // =================================================================

            $nonceValue = Str::random(16);
            session()->put('nonce_value', $nonceValue);
            $applicant_family_member_id = null;
            // Educational assistance
            if ($benefit->benefit_code === 'EA') {

                $familyMembers = MainWorkerFamily::where('worker_id', $worker_id)->get();
                if ($familyMembers->isEmpty()) {
                    Alert::info("No Family Members Found", "You must add family members in your profile to apply for this scheme.");
                    return redirect()->back();
                }

                return view('worker.benefits.select-applicant', compact('benefit', 'familyMembers', 'getVaultData', 'is_paid', 'nonceValue'));
            } elseif ($benefit->benefit_code === 'DB' || $benefit->benefit_code === 'FA') {
                $nominee = session()->get('nominee');
                $applicant_family_member_id = NomineeRegistration::where('nomine_id', $nominee)->first()->family_id;
                $familyVaultData = $this->getVaultDataService->getFamilyVaultData($applicant_family_member_id);
                $data['applicantVaultDetails'] = json_decode($familyVaultData->getData(), true);
                $this->startEaApplication($benefitId, $applicant_family_member_id);
            }



            $benefit->load(['formFields' => function ($query) {
                $query->orderBy('order', 'asc');
            }]);

            // ... (rest of your existing controller logic) ...
            $submission = $this->createOrGetFormSubmission(
                [
                    'worker_id' => $worker_id,
                    'benefit_id' => $benefitId,
                    'applicant_family_member_id' => $applicant_family_member_id,
                    // Important: Only create a new draft if one doesn't already exist.
                    // We add status to the search criteria to avoid matching a 'submitted' record.
                    'status' => null
                ],
                $workerData,
                $benefit
            );

            if ($submission->wasRecentlyCreated) {
                Alert::success("Application Started!", "Your Application ID is: " . $submission->application_id);
            }
            // else {
            //     Alert::info("Welcome Back!", "Continuing application: " . $submission->application_id);
            // }

            // Fetch all previously submitted data for this form submission in a single query.
            // This creates an efficient key-value array like: [ 'form_field_id' => 'submitted_value' ]
            $submittedData = $submission->formSubmissionData()->pluck('value', 'form_field_id')->all();

            // --- END OF REFACTORED LOGIC ---

            // Fetch other necessary data for pre-filling

            $wmf = MainWorkerForm::where('worker_id', $worker_id)->first();

            // Pass the new $submittedData array to the view.
            return view('worker.benefits.index', compact(
                'benefit',
                'getVaultData',
                'wmf',
                'submittedData',
                'submission',
                'data'
            ));
        } catch (Exception $e) {
            Log::error('Benefit Form Error: ' . $e->getMessage());
            Alert::error("An error occurred", "Could not load the application form. Please try again later.");
            return back();
        }
    }


    public function startEaApplication($benefitId, $familyMemberId)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        try {
            $workerData = session()->get('worker');
            $worker_id = $workerData->worker_id;

            $benefit = Benefit::findOrFail($benefitId);
            $familyMember = MainWorkerFamily::where('id', $familyMemberId)
                ->where('worker_id', $worker_id) // Security check
                ->firstOrFail();

            // ================================================================
            // == TODO: TRIGGER AADHAAR KYC FOR THE FAMILY MEMBER HERE ==
            // ================================================================
            // You would typically redirect to a KYC service or call an API.
            // For now, we will proceed assuming KYC is successful.
            // Example:
            // $kycService = new AadhaarKycService();
            // if (!$kycService->verify($familyMember->aadhaar_no)) {
            //     Alert::error("KYC Failed", "Aadhaar KYC for the selected family member failed.");
            //     return redirect()->route('worker.dashboard'); // or back
            // }
            // ================================================================


            // Now, create the specific form submission record for this family member
            // $applicationId = $this->getApplicationId($benefit->benefit_code, $workerData->office_id, $workerData->districtName->district_name);
            $submission = $this->createOrGetFormSubmission(
                [
                    'worker_id' => $worker_id,
                    'benefit_id' => $benefitId,
                    'applicant_family_member_id' => $familyMember->id, // <-- This is the key part
                    'status' => null
                ],
                $workerData,
                $benefit
            );

            if ($submission->wasRecentlyCreated) {
                Alert::success("Application Started for " . $familyMember->name, "Application ID: " . $submission->application_id);
            }

            // The rest of the logic is the same as the original method
            $benefit->load(['formFields' => fn($query) => $query->orderBy('order', 'asc')]);
            $submittedData = $submission->formSubmissionData()->pluck('value', 'form_field_id')->all();
            $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
            $getVaultData = json_decode($vaultData->getData(), true);
            $wmf = MainWorkerForm::where('worker_id', $worker_id)->first();
            $data = [];
            if ($benefit->benefit_code == 'EA') {
                $familyVaultData = $this->getVaultDataService->getFamilyVaultData($familyMember->id);
                $data['applicantVaultDetails'] = json_decode($familyVaultData->getData(), true);
                // $data['applicantDetails'] = $familyMember;
            }


            $is_paid = false;
            return view('worker.benefits.index', compact(
                'benefit',
                'getVaultData',
                'wmf',
                'submittedData',
                'submission',
                'data',
                'is_paid',
                // 'applicationId'
            ));
        } catch (Exception $e) {
            // return $e;
            Log::error('EA Benefit Form Error: ' . $e->getMessage());
            Alert::error("An error occurred", "Could not load the application form. Please try again later.");
            return back();
        }
    }


    public function editNow($application_id)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        try {
            $workerData = session()->get('worker');
            $worker_id = $workerData->worker_id;
            $submission = FormSubmission::where('application_id', $application_id)->first();
            $benefit = Benefit::findOrFail($submission->benefit_id);
            $familyMember = MainWorkerFamily::where('id', $submission->applicant_family_member_id)
                ->where('worker_id', $worker_id) // Security check
                ->firstOrFail();

            // ================================================================
            // == TODO: TRIGGER AADHAAR KYC FOR THE FAMILY MEMBER HERE ==
            // ================================================================
            // You would typically redirect to a KYC service or call an API.
            // For now, we will proceed assuming KYC is successful.
            // Example:
            // $kycService = new AadhaarKycService();
            // if (!$kycService->verify($familyMember->aadhaar_no)) {
            //     Alert::error("KYC Failed", "Aadhaar KYC for the selected family member failed.");
            //     return redirect()->route('worker.dashboard'); // or back
            // }
            // ================================================================


            // Now, create the specific form submission record for this family member
            // $applicationId = $this->getApplicationId($benefit->benefit_code, $workerData->office_id, $workerData->districtName->district_name);
            // $submission = FormSubmission::firstOrCreate(
            //     [
            //         'worker_id' => $worker_id,
            //         'benefit_id' => $benefitId,
            //         'applicant_family_member_id' => $familyMember->id, // <-- This is the key part
            //         'status' => null
            //     ],
            //     [
            //         'application_id' => $this->getApplicationId($benefit->benefit_code, $workerData->office_id, $workerData->districtName->district_name),
            //     ]
            // );

            // if ($submission->wasRecentlyCreated) {
            //     Alert::success("Application Started for " . $familyMember->name, "Application ID: " . $submission->application_id);
            // }

            // The rest of the logic is the same as the original method
            $benefit->load(['formFields' => fn($query) => $query->orderBy('order', 'asc')]);
            $submittedData = $submission->formSubmissionData()->pluck('value', 'form_field_id')->all();
            $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
            $getVaultData = json_decode($vaultData->getData(), true);
            $wmf = MainWorkerForm::where('worker_id', $worker_id)->first();
            $data = [];
            if ($benefit->benefit_code == 'EA' || $benefit->benefit_code == 'DB' || $benefit->benefit_code == 'FA') {
                $familyVaultData = $this->getVaultDataService->getFamilyVaultData($familyMember->id);
                $data['applicantVaultDetails'] = json_decode($familyVaultData->getData(), true);
                // $data['applicantDetails'] = $familyMember;
            }


            $is_paid = false;
            return view('worker.benefits.index', compact(
                'benefit',
                'getVaultData',
                'wmf',
                'submittedData',
                'submission',
                'data',
                'is_paid',
                // 'applicationId'
            ));
        } catch (Exception $e) {
            // return $e;
            Log::error('EA Benefit Form Error: ' . $e->getMessage());
            Alert::error("An error occurred", "Could not load the application form. Please try again later.");
            return back();
        }
    }


    public function getApplicationId($benefit_code, $office_id, $district_name)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $schemeCode = $benefit_code;
        $now = Carbon::now();
        $monthCode = strtoupper($now->format('M'));
        $monthCode = strtoupper(Str::substr($monthCode, 0, 2));
        $yearCode = $now->format('y');
        $officeCode = str_pad($office_id, 3, '0', STR_PAD_LEFT);
        $districtCode = strtoupper(Str::substr($district_name, 0, 3));
        $baseCode = $schemeCode . $monthCode . $yearCode . $officeCode . $districtCode;
        $count = FormSubmission::where('application_id', 'LIKE', $baseCode . '%')->count() + 1;
        $sequence = str_pad($count, 4, '0', STR_PAD_LEFT); // e.g. "001"
        $applicationId = $baseCode . $sequence;
        return $applicationId;
    }

    /**
     * Create or return existing FormSubmission while ensuring generated application_id is unique.
     * Retries a few times if a duplicate application_id is generated due to race conditions.
     */
    private function createOrGetFormSubmission(array $search, $workerData, $benefit, $maxAttempts = 5)
    {
        $attempt = 0;
        while ($attempt < $maxAttempts) {
            $attempt++;

            $query = FormSubmission::query();
            foreach ($search as $col => $val) {
                if (is_null($val)) {
                    $query->whereNull($col);
                } else {
                    $query->where($col, $val);
                }
            }
            $existing = $query->first();
            if ($existing) {
                return $existing;
            }

            $applicationId = $this->getApplicationId($benefit->benefit_code, $workerData->office_id, $workerData->districtName->district_name);
            $createAttrs = array_merge($search, ['application_id' => $applicationId]);
            try {
                return FormSubmission::create($createAttrs);
            } catch (\Illuminate\Database\QueryException $e) {
                $msg = $e->getMessage();
                if (stripos($msg, 'duplicate') !== false || stripos($msg, 'unique') !== false) {
                    // If another process inserted the same application_id, try to fetch it and return it.
                    $conflict = FormSubmission::where('application_id', $applicationId)->first();
                    if ($conflict) {
                        return $conflict;
                    }
                    // otherwise wait a short time and retry (regenerate application id)
                    usleep(50000);
                    continue;
                }
                throw $e;
            }
        }

        throw new Exception("Could not generate unique application id after {$maxAttempts} attempts");
    }

    public function getDependentField(Request $request)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $validator = Validator::make($request->all(), [
            'fieldId' => 'required|exists:pgsql.Benefit.form_fields,id',
            'selectedValue' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'error' => $validator->errors()
            ]);
        }

        // Fetch the dependent field data based on the field ID and value
        $dependentFieldData = FormField::where('dependent_field_id', $request->fieldId)
            // ->where('dependent_field_value', $request->selectedValue)
            ->get();
        if ($dependentFieldData->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No dependent field data found',
            ]);
        }

        return response()->json([
            'status' => true,
            'results' => $dependentFieldData
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




    // public function submitForm(Request $request, $benefitId,$applicationId)
    // {
    //     $benefit = Benefit::with('formFields')->findOrFail($benefitId);
    //     $workerData = session()->get('worker');
    //     $worker_id = $workerData->worker_id;
    //     $action = $request->input('action', 'draft');

    //     if ($action == 'preview') {
    //         $rules = [];
    //         $messages = [];

    //         foreach ($benefit->formFields as $field) {
    //             // Decode the custom JSON object: {"required": true, "min": 5}
    //             $customFormatRules = json_decode($field->validation_rules, true);

    //             if (is_array($customFormatRules) && !empty($customFormatRules)) {

    //                 // --- START OF NEW TRANSLATION LOGIC ---
    //                 $laravelRules = [];
    //                 foreach ($customFormatRules as $rule => $param) {
    //                     if ($param === true) {
    //                         $laravelRules[] = $rule;
    //                     } else {

    //                         $laravelRules[] = "{$rule}:{$param}";
    //                     }
    //                 }
    //                 if ($field->type === 'file') {
    //                     $existingFile = FormSubmission::where('application_id', $applicationId)
    //                     ->first()
    //                         ?->formSubmissionData()->where('form_field_id', $field->id)->value('value');

    //                     if ($existingFile) {
    //                         $requiredKey = array_search('required', $laravelRules);
    //                         if ($requiredKey !== false) {
    //                             unset($laravelRules[$requiredKey]);
    //                         }
    //                     }
    //                 }

    //                 // Assign the correctly formatted rules to the main rules array
    //                 $rules[$field->name] = $laravelRules;

    //                 // The error message logic remains the same and is correct
    //                 $customMessages = json_decode($field->error_messages, true);
    //                 if (is_array($customMessages)) {
    //                     foreach ($customMessages as $ruleName => $message) {
    //                         $messages["{$field->name}.{$ruleName}"] = $message;
    //                     }
    //                 }
    //             }
    //         }

    //         // This validates the request. Laravel automatically handles redirection on failure.
    //         $validatedData = $request->validate($rules, $messages);

    //         $dataToSave = $validatedData;
    //         $redirectAction = redirect()->route('worker.preview-application', $applicationId);
    //     } else {
    //         // ACTION: SAVE AS DRAFT (no validation)
    //         $dataToSave = $request->except('_token', 'action');
    //         Alert::success("Draft Saved!", "Your progress has been saved successfully.");
    //         $redirectAction = redirect()->back();
    //     }

    //     // --- SHARED DATABASE SAVING LOGIC ---
    //     DB::beginTransaction();
    //     try {
    //         $submission = FormSubmission::where('application_id', $applicationId)
    //             ->where('benefit_id', $benefitId)
    //             ->firstOrFail();

    //         foreach ($benefit->formFields as $field) {
    //             if ($field->type == 'file' && $request->hasFile($field->name)) {
    //                 $value = $request->file($field->name)->store('private/uploads');
    //                 $submission->formSubmissionData()->updateOrCreate(
    //                     ['form_field_id' => $field->id],
    //                     ['value' => $value]
    //                 );
    //             } elseif (array_key_exists($field->name, $dataToSave)) {
    //                 $value = $dataToSave[$field->name];
    //                 if (is_array($value)) {
    //                     $value = json_encode($value);
    //                 }
    //                 $submission->formSubmissionData()->updateOrCreate(
    //                     ['form_field_id' => $field->id],
    //                     ['value' => $value]
    //                 );
    //             }
    //         }

    //         DB::commit();
    //         return $redirectAction;
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('Form Submission Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    //         Alert::error("An Error Occurred", "Could not save your data. Please try again.");
    //         return back()->withInput();
    //     }
    // }

    // public function submitForm(Request $request, $benefitId, $applicationId)
    // {
    //     // dd($benefitId, $applicationId);
    //     return $request->all();
    //     $benefit = Benefit::with('formFields')->findOrFail($benefitId);
    //     $workerData = session()->get('worker');
    //     $worker_id = $workerData->worker_id;
    //     $action = $request->input('action', 'draft');

    //     $submission = FormSubmission::where('application_id', $applicationId)
    //         ->where('benefit_id', $benefitId)
    //         ->first();
    //     // return $submission;

    //     if ($action == 'preview') {
    //         $rules = [];
    //         $messages = [];

    //         foreach ($benefit->formFields as $field) {
    //             $customFormatRules = json_decode($field->validation_rules, true);

    //             if (is_array($customFormatRules) && !empty($customFormatRules)) {
    //                 $laravelRules = [];
    //                 foreach ($customFormatRules as $rule => $param) {
    //                     $actualRule = $rule;
    //                     if ($rule === 'mimes' && is_string($param) && strpos($param, '/') !== false) {
    //                         $actualRule = 'mimetypes';
    //                     }
    //                     $laravelRules[] = ($param === true) ? $actualRule : "{$actualRule}:{$param}";
    //                 }

    //                 // === FIX 2: Correctly check for an existing file ===
    //                 if ($field->type === 'file') {
    //                     $existingFile = null;
    //                     // Only check for a file if a submission record already exists
    //                     if ($submission) {
    //                         $existingFile = $submission->formSubmissionData()
    //                             ->where('form_field_id', $field->id)
    //                             ->value('value');
    //                         // return $existingFile;
    //                     }

    //                     // If a file already exists in the database, make it not required for this request.
    //                     if ($existingFile) {
    //                         $requiredKey = array_search('required', $laravelRules);
    //                         if ($requiredKey !== false) {
    //                             unset($laravelRules[$requiredKey]);
    //                             // Re-index the array to prevent potential issues
    //                             $laravelRules = array_values($laravelRules);
    //                         }
    //                     }
    //                 }

    //                 $rules[$field->name] = $laravelRules;

    //                 $customMessages = json_decode($field->error_messages, true);
    //                 if (is_array($customMessages)) {
    //                     foreach ($customMessages as $ruleName => $message) {
    //                         $messages["{$field->name}.{$ruleName}"] = $message;
    //                     }
    //                 }
    //             }
    //         }

    //         $validatedData = $request->validate($rules, $messages);
    //         $dataToSave = $validatedData;
    //         $redirectAction = redirect()->route('worker.preview-application', [$benefitId, $applicationId]);
    //     } else { // ACTION: SAVE AS DRAFT
    //         $dataToSave = $request->except('_token', 'action');
    //         Alert::success("Draft Saved!", "Your progress has been saved successfully.");
    //         $redirectAction = redirect()->back();
    //     }

    //     DB::beginTransaction();
    //     try {
    //         // === FIX 3: Use updateOrCreate for the main submission record ===
    //         // This is more robust. It finds the submission or creates it if it doesn't exist.
    //         $submission = FormSubmission::updateOrCreate(
    //             [
    //                 'application_id' => $applicationId,
    //                 'benefit_id' => $benefitId,
    //             ],
    //             [
    //                 'worker_id' => $worker_id,
    //                 // you can add/update other fields here like 'status' => 'draft' if needed
    //             ]
    //         );

    //         foreach ($benefit->formFields as $field) {
    //             // Check for file uploads first
    //             if ($field->type == 'file' && $request->hasFile($field->name)) {
    //                 $value = $request->file($field->name)->store('private/uploads');
    //                 $submission->formSubmissionData()->updateOrCreate(
    //                     ['form_field_id' => $field->id],
    //                     ['value' => $value]
    //                 );
    //                 // Then check for other fields that were actually submitted
    //             } elseif (array_key_exists($field->name, $dataToSave)) {
    //                 $value = $dataToSave[$field->name];
    //                 $submission->formSubmissionData()->updateOrCreate(
    //                     ['form_field_id' => $field->id],
    //                     ['value' => is_array($value) ? json_encode($value) : $value]
    //                 );
    //             }
    //         }

    //         DB::commit();
    //         return $redirectAction;
    //     } catch (Exception $e) {
    //         return $e;
    //         DB::rollBack();
    //         Log::error('Form Submission Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    //         Alert::error("An Error Occurred", "Could not save your data. Please try again.");
    //         return back()->withInput();
    //     }
    // }

    public function submitForm(Request $request, $benefitId, $applicationId)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        // 1. Initial Setup: Fetch essential data
        $benefit = Benefit::with('formFields')->findOrFail($benefitId);
        $workerData = session()->get('worker');
        $worker_id = $workerData->worker_id;
        $action = $request->input('action', 'draft');

        $submission = FormSubmission::where('application_id', $applicationId)
            ->where('benefit_id', $benefitId)
            ->first();

        // 2. Handle 'Preview' Action (Validation-heavy)
        if ($action == 'preview') {
            $rules = [];
            $messages = [];

            // Build validation rules and messages dynamically
            foreach ($benefit->formFields as $field) {
                $customFormatRules = json_decode($field->validation_rules, true);

                if (!is_array($customFormatRules) || empty($customFormatRules)) {
                    continue; // Skip if no validation rules are defined
                }

                $laravelRules = [];
                foreach ($customFormatRules as $rule => $param) {
                    // Automatically switch between 'mimes' and 'mimetypes'
                    $actualRule = ($rule === 'mimes' && is_string($param) && strpos($param, '/') !== false)
                        ? 'mimetypes'
                        : $rule;

                    $laravelRules[] = ($param === true) ? $actualRule : "{$actualRule}:{$param}";
                }

                // Handle optional file validation:
                // If a file already exists, it is no longer 'required' for this submission.
                if ($field->type === 'file') {
                    $hasExistingFile = $submission && $submission->formSubmissionData()->where('form_field_id', $field->id)->exists();

                    // If the user isn't uploading a new file AND one already exists, make it optional.
                    if (!$request->hasFile($field->name) && $hasExistingFile) {
                        $requiredKey = array_search('required', $laravelRules);
                        if ($requiredKey !== false) {
                            unset($laravelRules[$requiredKey]);
                            $laravelRules = array_values($laravelRules);
                        }
                    }
                }

                $rules[$field->name] = $laravelRules;

                // Build custom error messages
                $customMessages = json_decode($field->error_messages, true);
                if (is_array($customMessages)) {
                    foreach ($customMessages as $ruleName => $message) {
                        $messages["{$field->name}.{$ruleName}"] = $message;
                    }
                }
            }

            // Manually create and run the validator
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $dataToSave = $validator->validated();
            $redirectAction = redirect()->route('worker.preview-application', [$benefitId, $applicationId]);
        } else { // Handle 'Save as Draft' Action (No validation)
            $dataToSave = $request->except('_token', 'action');
            Alert::success("Draft Saved!", "Your progress has been saved successfully.");
            $redirectAction = redirect()->back();
        }

        // 3. Database Transaction: Save the data for both Draft and Preview
        DB::beginTransaction();
        try {
            // Use updateOrCreate for the main submission record for robustness
            $submission = FormSubmission::updateOrCreate(
                [
                    'application_id' => $applicationId,
                    'benefit_id' => $benefitId,
                ],
                [
                    'worker_id' => $worker_id,
                    'status' => 'draft', // Always save as draft until final submission
                ]
            );

            foreach ($benefit->formFields as $field) {
                // Priority 1: Handle file uploads
                if ($field->type == 'file' && $request->hasFile($field->name)) {
                    $filePath = $request->file($field->name)->store('private/uploads');
                    $submission->formSubmissionData()->updateOrCreate(
                        ['form_field_id' => $field->id],
                        ['value' => $filePath]
                    );

                    // Priority 2: Handle other form data that was actually submitted
                } elseif (array_key_exists($field->name, $dataToSave)) {
                    $value = $dataToSave[$field->name];

                    // CRITICAL FIX: Do not save null or empty values that might violate DB constraints
                    if ($value === null || $value === '') {
                        continue; // Skip this field
                    }

                    $submission->formSubmissionData()->updateOrCreate(
                        ['form_field_id' => $field->id],
                        ['value' => is_array($value) ? json_encode($value) : $value]
                    );
                }
            }

            DB::commit();
            return $redirectAction;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Form Submission Error: ' . $e->getMessage(), [
                'applicationId' => $applicationId,
                'benefitId' => $benefitId,
                'trace' => $e->getTraceAsString()
            ]);

            Alert::error("An Error Occurred", "Could not save your data. Please try again or contact support.");
            return back()->withInput();
        }
    }



    public function printApplicationBenefitPdf(FormSubmission $application)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        // $application->load(['benefit', 'formSubmissionData.formField' => function ($query) {
        //     $query->orderBy('order', 'asc');
        // }]);
        // return $application->application_id;
        $workerData = session()->get('worker');
        $worker_id = $workerData->worker_id;
        $vaultData = $this->getVaultDataService->getVaultData($worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);

        $emblem = public_path('/assets/template/images/bocw.png');

        // $application = FormSubmission::where('application_id',$application->application_id)->first();
        $benefit = Benefit::where('id', $application->benefit_id)->first();
        // return $benefit;
        switch ($benefit->benefit_code) {
            case 'EA':
                $application_data = EducationScholarshipApplication::where('application_number', $application->application_id)
                    ->firstOrFail();
                $view = 'worker.benefits.pdf.print-application';
                break;
            case 'CE':
                $application_data = CashAwardForEducationApplication::where('application_number', $application->application_id)
                    ->firstOrFail();
                $view = 'worker.benefits.forms.cash-award-application.print-application';
                break;
            case 'MT':
                $application_data = MaternityAssistanceApplication::where('application_number', $application->application_id)
                    ->firstOrFail();
                $view = 'worker.benefits.forms.maternity-assistance.print-application';
                break;
            case 'MR':
                $application_data = MarriageAssistanceApplication::where('application_number', $application->application_id)
                    ->firstOrFail();
                $view = 'worker.benefits.forms.marriage-assistance.print-application';
        }

        $html = view($view, compact(
            'application',
            'getVaultData',
            'emblem',
            'application_data',
            'workerData'
        ))->render();

        $options = [
            'encoding' => 'utf-8',
            'enable-local-file-access' => true,
        ];
        $fileName = 'Application-' . $application->application_id . '.pdf';

        $pdfContent =  Pdf::loadHTML($html)
            ->setOptions($options)
            ->output();

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }



    public function previewApplication($benefitId, $application_id)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $workerData = session()->get('worker');
        $submission = FormSubmission::where('application_id', $application_id)
            ->where('benefit_id', $benefitId)
            ->with(['benefit', 'formSubmissionData.formField' => fn($q) => $q->orderBy('order')])
            ->firstOrFail();
        // return $submission;
        $data = [];
        if ($submission->benefit->benefit_code == 'EA' || $submission->benefit->benefit_code == 'DB' || $submission->benefit->benefit_code == 'FA') {
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($submission->applicant_family_member_id);
            $data['applicantVaultDetails'] = json_decode($familyVaultData->getData(), true);
        }
        // You can also pass vault data if needed for the preview header
        $vaultData = $this->getVaultDataService->getVaultData($workerData->worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);

        return view('worker.benefits.preview', compact('submission', 'getVaultData', 'data'));
    }


    public function finalSubmit(FormSubmission $application)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $workerData = session()->get('worker');
        if ($application->worker_id !== $workerData->worker_id) {
            abort(403, 'Unauthorized Action');
        }

        // if ($application->status != 'reverted' || $application->status != null) {
        //     Alert::warning("Already Submitted", "This application has already been submitted.");
        //     return redirect()->route('worker-dashboard');
        // }

        try {
            // return $application;
            if ($application->status == 'reverted' || $application->status == null || $application->status == 'draft') {
                $application->update([
                    'status' => 'submitted',
                    'submitted_at' => Carbon::now()
                ]);

                Alert::success("Application Submitted!", "Your application has been successfully sent to the office for review.");
                return redirect()->route('worker.show-acknowledgment', $application->id);
            } else {
                Alert::warning("Already Submitted", "This application has already been submitted.");
                return redirect()->route('worker-dashboard');
            }
        } catch (\Exception $e) {
            Log::error('Final Submit Error: ' . $e->getMessage());
            Alert::error("Submission Failed", "An unexpected error occurred. Please try again.");
            return redirect()->back();
        }
    }

    public function showAcknowledgment(FormSubmission $application)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $workerData = session()->get('worker');
        $data = [];
        if (session()->has('nominee')) {
            $nominee = session()->get('nominee');
            $nomineeDetails = NomineeRegistration::where('nomine_id', $nominee)->first();
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($nomineeDetails->family_id);
            $data['applicantVaultDetails'] = json_decode($familyVaultData->getData(), true);
        }
        if ($application->worker_id !== $workerData->worker_id) {
            abort(403);
        }

        $application->load('benefit');
        $vaultData = $this->getVaultDataService->getVaultData($workerData->worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);

        return view('worker.benefits.acknowledgment', compact('application', 'getVaultData', 'data', 'workerData'));
    }

    /**
     * Generates and streams the Acknowledgment Slip PDF.
     */
    public function downloadAcknowledgment(FormSubmission $application)
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $workerData = session()->get('worker');
        // return $application;
        if ($application->worker_id !== $workerData->worker_id) {
            abort(403);
        }
        $data = [];
        if (session()->has('nominee')) {
            $nominee = session()->get('nominee');
            $nomineeDetails = NomineeRegistration::where('nomine_id', $nominee)->first();
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($nomineeDetails->family_id);
            $applicantVaultDetails = json_decode($familyVaultData->getData(), true);
        } else {
            $familyMemberId = $application->applicant_family_member_id;
            $familyVaultData = $this->getVaultDataService->getFamilyVaultData($familyMemberId);
            $applicantVaultDetails = json_decode($familyVaultData->getData(), true);
        }
        $emblemPath = public_path('/assets/template/images/bocw.png');

        // --- START OF FIX ---
        // Check if the file exists before trying to read it
        if (!file_exists($emblemPath)) {
            // Handle the error gracefully, maybe log it or use a placeholder
            Log::error("Emblem file not found at: " . $emblemPath);
            $emblemData = ''; // No emblem if not found
        } else {
            // Read the image file and encode it in Base64
            $type = pathinfo($emblemPath, PATHINFO_EXTENSION);
            $data = file_get_contents($emblemPath);
            $emblem = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        $vaultData = $this->getVaultDataService->getVaultData($workerData->worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);

        $html = view('worker.benefits.pdf.print-acknowledgment', compact(
            'application',
            'getVaultData',
            'emblem',
            'data',
            'applicantVaultDetails',
            'workerData'
        ))->render();

        $fileName = 'Acknowledgment-Slip-' . $application->application_id . '.pdf';

        $pdfContent =  Pdf::loadHTML($html)->output();

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }


    public function track(FormSubmission $application)
    {

        // Security Check: Ensure the logged-in user can view this tracking info.
        $workerData = session()->get('worker');
        if ($application->worker_id !== $workerData->worker_id) {
            abort(403, 'Unauthorized Action');
        }

        // Eager load the logs and the user associated with each log.
        // We get the logs in oldest-to-newest order for a proper timeline.
        $application->load(['logs' => function ($query) {
            $query->with('user')->oldest();
        }]);
        $vaultData = $this->getVaultDataService->getVaultData($workerData->worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);

        // Render a "partial" view (just the HTML for the timeline).
        $html = view('worker.benefits.tracking-timeline', compact('application', 'getVaultData'))->render();

        // Return the HTML in a JSON response.
        return response()->json(['html' => $html]);
    }


    public function viewDocs($path){
        if (! Storage::disk('private')->exists($path)) {
        abort(404, 'File not found');
    }

    return Storage::disk('private')->response($path);
    }
}
