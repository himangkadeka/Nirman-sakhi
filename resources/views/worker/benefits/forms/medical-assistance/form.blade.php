@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="container py-5">
            <div class="card shadow border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Application for Medical / Disability Assistance</h5>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('submit-benefit-application', $benefit_id) }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3">1. Applicant Details</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Application Number <span class="text-danger">*</span></label>
                                <input type="text" name="application_number" class="form-control bg-light" value="{{ $submitted_data->application_number ?? 'MED-' . time() }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Date <span class="text-danger">*</span></label>
                                <input type="date" name="application_date" class="form-control bg-light" value="{{ $submitted_data->application_date ? \Carbon\Carbon::parse($submitted_data->application_date)->format('Y-m-d') : date('Y-m-d') }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>District <span class="text-danger">*</span></label>
                                <input type="hidden" name="district_id" value="{{ $submitted_data->district_id ?? $getVaultData['district_id'] ?? '' }}">
                                <input type="text" name="district_name" class="form-control bg-light" value="{{ $submitted_data->district->district_name ?? $getVaultData['district_name'] ?? '' }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name of Applicant <span class="text-danger">*</span></label>
                                <input type="text" name="applicant_name" class="form-control bg-light" value="{{ $getVaultData['name'] ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Registration Number <span class="text-danger">*</span></label>
                                <input type="text" name="registration_number" class="form-control bg-light" value="{{ $id_card ?? '' }}" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address of Applicant <span class="text-danger">*</span></label>
                                <textarea name="applicant_address" class="form-control bg-light" rows="2" readonly>{{ $getVaultData['landMark'] ?? '' }}, {{ $getVaultData['locality'] ?? '' }}, PO-{{ $getVaultData['postOffice'] ?? '' }}, PIN- {{ $getVaultData['pinCode'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="applicant_dob" class="form-control" value="{{ old('applicant_dob', $submitted_data->applicant_dob ?? $getVaultData['dob'] ?? '') }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Age <span class="text-danger">*</span></label>
                                <input type="number" name="applicant_age" class="form-control" value="{{ old('applicant_age', $submitted_data->applicant_age ?? '') }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Social Category <span class="text-danger">*</span></label>
                                <select name="social_category" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="SC" {{ old('social_category', $submitted_data->social_category ?? '') == 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="ST" {{ old('social_category', $submitted_data->social_category ?? '') == 'ST' ? 'selected' : '' }}>ST</option>
                                    <option value="OBC" {{ old('social_category', $submitted_data->social_category ?? '') == 'OBC' ? 'selected' : '' }}>OBC</option>
                                    <option value="General" {{ old('social_category', $submitted_data->social_category ?? '') == 'General' ? 'selected' : '' }}>General</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Last Contribution Date <span class="text-danger">*</span></label>
                                <input type="date" name="last_contribution_date" class="form-control" value="{{ old('last_contribution_date', $submitted_data->last_contribution_date ?? '') }}" required>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">2. Medical & Hospital Details</h6>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Details Regarding Disease / Surgery / Accident <span class="text-danger">*</span></label>
                                <textarea name="medical_condition_details" class="form-control" rows="2" required>{{ old('medical_condition_details', $submitted_data->medical_condition_details ?? '') }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Disability (if any) Due to Disease / Surgery / Accident <small class="text-muted">(Optional)</small></label>
                                <textarea name="disability_details" class="form-control" rows="2">{{ old('disability_details', $submitted_data->disability_details ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name of Government Hospital Where Admitted <span class="text-danger">*</span></label>
                                <input type="text" name="hospital_name" class="form-control" value="{{ old('hospital_name', $submitted_data->hospital_name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Period of Treatment as Indoor Patient (in days) <span class="text-danger">*</span></label>
                                <input type="number" name="treatment_period_days" class="form-control" value="{{ old('treatment_period_days', $submitted_data->treatment_period_days ?? '') }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address of Hospital <span class="text-danger">*</span></label>
                                <textarea name="hospital_address" class="form-control" rows="1" required>{{ old('hospital_address', $submitted_data->hospital_address ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Date of Admission in the Hospital <span class="text-danger">*</span></label>
                                <input type="date" name="admission_date" class="form-control" value="{{ old('admission_date', $submitted_data->admission_date ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Date of Discharge from the Hospital <span class="text-danger">*</span></label>
                                <input type="date" name="discharge_date" class="form-control" value="{{ old('discharge_date', $submitted_data->discharge_date ?? '') }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Details of Benefits Received Earlier (if any) <small class="text-muted">(Optional)</small></label>
                                <textarea name="previous_benefits_details" class="form-control" rows="2">{{ old('previous_benefits_details', $submitted_data->previous_benefits_details ?? '') }}</textarea>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">3. Bank Account Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name of the Bank <span class="text-danger">*</span></label>
                                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $submitted_data->bank_name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>IFSC Code <span class="text-danger">*</span></label>
                                <input type="text" name="ifsc_code" class="form-control" value="{{ old('ifsc_code', $submitted_data->ifsc_code ?? '') }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address of Branch <span class="text-danger">*</span></label>
                                <textarea name="branch_address" class="form-control" rows="1" required>{{ old('branch_address', $submitted_data->branch_address ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Account Number <span class="text-danger">*</span></label>
                                <input type="password" name="account_number" id="account_number" class="form-control" value="{{ old('account_number', $submitted_data->account_number ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Confirm Account Number <span class="text-danger">*</span></label>
                                <input type="text" name="account_number_confirmation" id="account_number_confirmation" class="form-control" value="{{ old('account_number_confirmation', $submitted_data->account_number ?? '') }}" required>
                                <small id="account_match_msg" class="form-text"></small>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">4. Attachments</h6>
                        <div class="row">
                            @php
                                $documents = [
                                    'doc_account_paybook' => ['label' => 'Photocopy of A/c pay book (First page)', 'required' => true],
                                    'doc_accident_report' => ['label' => 'Accident report (from employer/police)', 'required' => true],
                                    'doc_treatment_documents' => ['label' => 'All treatment documents from Govt. Hospital', 'required' => true],
                                    'doc_affected_person_photograph' => ['label' => 'Photographs of the affected part of the person', 'required' => true],
                                    'doc_disability_certificate' => ['label' => 'Percentage of disability certificate', 'required' => true],
                                ];
                            @endphp

                            @foreach ($documents as $field => $config)
                                <div class="col-md-6 mb-4">
                                    <label>{{ $config['label'] }} {!! $config['required'] ? '<span class="text-danger">*</span>' : '<small class="text-muted">(Optional)</small>' !!}</label>

                                    @if (!empty($submitted_data->$field))
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $submitted_data->$field) }}" target="_blank" class="badge badge-success p-2">
                                                <i class="fa fa-check"></i> File Uploaded (View)
                                            </a>
                                        </div>
                                    @endif

                                    <input type="file" name="{{ $field }}" class="form-control-file" {{ ($config['required'] && empty($submitted_data->$field)) ? 'required' : '' }}>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer bg-white text-center mt-3">
                            <button type="submit" name="action" value="draft" class="btn btn-secondary btn-lg mr-3" formnovalidate>
                                <i class="fa fa-save"></i> Save as Draft
                            </button>
                            <button type="submit" name="action" value="preview" id="submit_btn" class="btn btn-primary btn-lg">
                                Submit & Preview <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Logic for Bank Account Confirmation Validation ---
        const accNumber = document.getElementById('account_number');
        const confirmAccNumber = document.getElementById('account_number_confirmation');
        const matchMsg = document.getElementById('account_match_msg');
        const submitBtn = document.getElementById('submit_btn');

        function checkAccountsMatch() {
            if (confirmAccNumber.value === '') {
                matchMsg.innerText = '';
                submitBtn.disabled = false;
                return;
            }

            if (accNumber.value === confirmAccNumber.value) {
                matchMsg.innerText = 'Account numbers match.';
                matchMsg.className = 'form-text text-success font-weight-bold';
                submitBtn.disabled = false;
            } else {
                matchMsg.innerText = 'Account numbers do not match!';
                matchMsg.className = 'form-text text-danger font-weight-bold';
                submitBtn.disabled = true; // Prevent submission if they don't match
            }
        }

        // Add event listeners to trigger on input change
        accNumber.addEventListener('input', checkAccountsMatch);
        confirmAccNumber.addEventListener('input', checkAccountsMatch);
    });
</script>
