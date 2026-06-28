@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="container py-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">4. Application for Educational Scholarship</h5>
                    <small>Form No. IV</small>
                </div>

                <div class="card-body">
                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Added novalidate to handle validation via Laravel -->
                    <form action="{{ route('submit-benefit-application', $benefit_id) }}" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf

                        <input type="hidden" name="family_member_id" value="{{ $selected_member->id }}">

                        <!-- SECTION 1: BASIC DETAILS -->
                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3">1. Basic Details</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Application Number</label>
                                <!-- Uses Draft ID or Generates New One -->
                                <input type="text" name="application_number" class="form-control bg-light"
                                    value="{{ $submitted_data->application_number ?? 'SCH-'.time() }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Date of Application</label>
                                <input type="date" name="application_date" class="form-control bg-light"
                                    value="{{ $submitted_data->application_date ? $submitted_data->application_date->format('Y-m-d') : date('Y-m-d') }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>District <span class="text-danger">*</span></label>
                                <!-- Prefers Draft District, falls back to User District -->
                                <input type="text" name="district_id" class="form-control bg-light"
                                    value="{{ $submitted_data->district->district_name  }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name of Applicant (Worker)</label>
                                <input type="text" class="form-control bg-light" value="{{ $getVaultData['name'] }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>BOCW Registration No.</label>
                                <input type="text" class="form-control bg-light" value="{{ $id_card }}" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address of Applicant</label>
                                <textarea class="form-control bg-light" rows="2" readonly>{{ $getVaultData['landMark'] }}, {{ $getVaultData['locality'] }}, PO-{{ $getVaultData['postOffice'] }}, PIN- {{ $getVaultData['pinCode'] }}</textarea>
                            </div>
                        </div>

                        <!-- SECTION 2: STUDENT DETAILS -->
                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">2. Student Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name of Student <span class="text-danger">*</span></label>
                                <input type="text" name="student_name" class="form-control bg-light"
                                    value="{{ $selected_member->first_name }} {{ $selected_member->last_name }}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="text" name="student_dob" class="form-control bg-light"
                                    value="{{ $applicantVaultDetails['dob'] }}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Age <span class="text-danger">*</span></label>
                                <input type="text" name="student_age" class="form-control bg-light"
                                    value="{{ \Carbon\Carbon::parse($selected_member->dob)->age }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Social Category <span class="text-danger">*</span></label>
                                <select name="social_category" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Category::get() as $category)
                                        <option value="{{ $category->category_code }}"
                                            {{-- Logic: Check Old Input -> Check Draft -> Check nothing --}}
                                            {{ (old('social_category', $submitted_data->social_category ?? '') == $category->category_code) ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label>Name & Address of Parent <span class="text-danger">*</span></label>
                                {{-- Logic: Check Draft, if empty use Vault Data --}}
                                <textarea name="parent_address" class="form-control" rows="1" required>{{ old('parent_address', $submitted_data->parent_address ?? ($applicantVaultDetails['landMark'] . ', ' . $applicantVaultDetails['locality'] . ', PO-' . $applicantVaultDetails['postOffice'] . ', PIN-' . $applicantVaultDetails['pinCode'])) }}</textarea>
                            </div>
                        </div>

                        <!-- SECTION 3: COURSE DETAILS -->
                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">3. Course Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name of College/Institution <span class="text-danger">*</span></label>
                                <input type="text" name="college_name" class="form-control"
                                    placeholder="e.g. Cotton University"
                                    value="{{ old('college_name', $submitted_data->college_name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Affiliated University/Board <span class="text-danger">*</span></label>
                                <input type="text" name="university_board" class="form-control"
                                    placeholder="e.g. AHSEC / Gauhati University"
                                    value="{{ old('university_board', $submitted_data->university_board ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Name of Course Enrolled <span class="text-danger">*</span></label>
                                <input type="text" name="course_name" class="form-control"
                                    placeholder="e.g. B.Sc Physics"
                                    value="{{ old('course_name', $submitted_data->course_name ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Duration of Course (Years) <span class="text-danger">*</span></label>
                                <input type="number" name="course_duration_years" class="form-control"
                                    placeholder="e.g. 3"
                                    value="{{ old('course_duration_years', $submitted_data->course_duration_years ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Date of Admission <span class="text-danger">*</span></label>
                                <input type="date" name="admission_date" class="form-control"
                                    value="{{ old('admission_date', optional($submitted_data->admission_date ?? null)->format('Y-m-d') ?? '') }}" required>
                            </div>
                        </div>

                        <!-- SECTION 4: QUALIFYING EXAM -->
                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">4. Academic Record</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Name of Exam Passed <span class="text-danger">*</span></label>
                                <input type="text" name="qualifying_exam_name" class="form-control"
                                    placeholder="e.g. HSLC"
                                    value="{{ old('qualifying_exam_name', $submitted_data->qualifying_exam_name ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>University / Board <span class="text-danger">*</span></label>
                                <input type="text" name="qualifying_exam_board" class="form-control"
                                    placeholder="e.g. SEBA"
                                    value="{{ old('qualifying_exam_board', $submitted_data->qualifying_exam_board ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Month & Year of Passing <span class="text-danger">*</span></label>
                                <input type="month" name="qualifying_exam_year" class="form-control"
                                    value="{{ old('qualifying_exam_year', $submitted_data->qualifying_exam_year ?? '') }}" required>
                            </div>
                        </div>

                        <label class="font-weight-bold mt-2">Marks Obtained in Qualifying Exam:</label>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th>Subject</th>
                                        <th width="20%">Total Marks</th>
                                        <th width="20%">Marks Obtained</th>
                                        <th width="20%">Percentage (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Get the Marks Array from Draft if it exists --}}
                                    @php
                                        // Ensure exam_marks is cast to array in Model, or json_decode here
                                        $savedMarks = $submitted_data->exam_marks ?? [];
                                    @endphp

                                    @for ($i = 0; $i < 6; $i++)
                                        <tr>
                                            <td>
                                                <input type="text" name="exam_marks[{{ $i }}][subject]"
                                                    class="form-control form-control-sm" placeholder="Subject Name"
                                                    value="{{ old('exam_marks.'.$i.'.subject', $savedMarks[$i]['subject'] ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="number" name="exam_marks[{{ $i }}][total]"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('exam_marks.'.$i.'.total', $savedMarks[$i]['total'] ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="number" name="exam_marks[{{ $i }}][obtained]"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('exam_marks.'.$i.'.obtained', $savedMarks[$i]['obtained'] ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" name="exam_marks[{{ $i }}][percentage]"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('exam_marks.'.$i.'.percentage', $savedMarks[$i]['percentage'] ?? '') }}">
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <!-- SECTION 5: BANK DETAILS -->
                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">5. Bank & Contribution Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Are Parents Registered Beneficiaries? <span class="text-danger">*</span></label>
                                <select name="parents_are_beneficiaries" class="form-control" required>
                                    <option value="0" {{ (old('parents_are_beneficiaries', $submitted_data->parents_are_beneficiaries ?? 0) == 0) ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ (old('parents_are_beneficiaries', $submitted_data->parents_are_beneficiaries ?? 0) == 1) ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Date of Last Contribution Payment <span class="text-danger">*</span></label>
                                <input type="date" name="last_contribution_date" class="form-control"
                                    value="{{ old('last_contribution_date', optional($submitted_data->last_contribution_date ?? null)->format('Y-m-d') ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Bank Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_name" class="form-control"
                                    value="{{ old('bank_name', $submitted_data->bank_name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Branch Name <span class="text-danger">*</span></label>
                                <input type="text" name="branch_name" class="form-control"
                                    value="{{ old('branch_name', $submitted_data->branch_name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>IFSC Code <span class="text-danger">*</span></label>
                                <input type="text" name="ifsc_code" class="form-control"
                                    value="{{ old('ifsc_code', $submitted_data->ifsc_code ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Address of Branch</label>
                                <input type="text" name="branch_address" class="form-control"
                                    value="{{ old('branch_address', $submitted_data->branch_address ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Account Number <span class="text-danger">*</span></label>
                                <input type="text" name="account_number" class="form-control"
                                    value="{{ old('account_number', $submitted_data->account_number ?? '') }}" required>
                            </div>
                        </div>

                        <!-- SECTION 6: UPLOADS -->
                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">6. Attachments</h6>
                        <div class="row">
                            {{-- Helper Loop for files to reduce code repetition --}}
                            @php
                                $documents = [
                                    'doc_bank_passbook' => 'Photocopy of Bank Passbook',
                                    'doc_caste_certificate' => 'Caste Certificate of Student',
                                    'doc_pass_certificate' => 'Pass Certificate',
                                    'doc_study_certificate' => 'Study Certificate',
                                    'doc_admission_slip' => 'Admission Slip',
                                    'doc_marksheet' => 'Marksheet of Exam',
                                    'doc_student_photo' => 'Student Photograph',
                                    'doc_student_signature' => 'Student Signature',
                                    'doc_affidavit' => 'Affidavit of Parent'
                                ];
                            @endphp

                            @foreach($documents as $field => $label)
                                <div class="col-md-6 mb-4">
                                    <label>{{ $label }} <span class="text-danger">*</span></label>

                                    {{-- If file exists in draft, show link --}}
                                    @if(!empty($submitted_data->$field))
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $submitted_data->$field) }}" target="_blank" class="badge badge-success p-2">
                                                <i class="fa fa-check"></i> File Uploaded (View)
                                            </a>
                                        </div>
                                    @endif

                                    {{-- If file exists, input is NOT required. If empty, it IS required --}}
                                    <input type="file" name="{{ $field }}" class="form-control-file"
                                           {{ !empty($submitted_data->$field) ? '' : 'required' }}>
                                </div>
                            @endforeach
                        </div>

                        <!-- SUBMIT BUTTONS -->
                        <div class="card-footer bg-white text-center">
                            <!-- Draft button with formnovalidate -->
                            <button type="submit" name="action" value="draft"
                                class="btn btn-secondary btn-lg mr-3" formnovalidate>
                                <i class="fa fa-save"></i> Save as Draft
                            </button>

                            <!-- Submit button triggers validation -->
                            <button type="submit" name="action" value="preview" class="btn btn-primary btn-lg">
                                Submit & Preview <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
