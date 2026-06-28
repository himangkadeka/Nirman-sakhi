@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="container py-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Application for Maternity Benefit</h5>
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
                                <input type="text" name="application_number" class="form-control bg-light" value="{{ $submitted_data->application_number ?? 'MAT-' . time() }}" readonly>
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
                                <input type="text" name="applicant_name" class="form-control bg-light" value="{{ $applicantVaultDetails['name'] ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>BOCW Registration Number <span class="text-danger">*</span></label>
                                <input type="text" name="bocw_registration_number" class="form-control bg-light" value="{{ $id_card ?? '' }}" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address of Applicant <span class="text-danger">*</span></label>
                                <textarea name="applicant_address" class="form-control bg-light" rows="2" readonly>{{ $applicantVaultDetails['landMark'] ?? '' }}, {{ $applicantVaultDetails['locality'] ?? '' }}, PO-{{ $applicantVaultDetails['postOffice'] ?? '' }}, PIN- {{ $applicantVaultDetails['pinCode'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="text" id="applicant_dob" readonly name="applicant_dob" class="form-control" value="{{ old('applicant_dob', $submitted_data->applicant_dob ?? $applicantVaultDetails['dob'] ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Age <span class="text-danger">*</span></label>
                                @php
                                    $dobValue = old('applicant_dob', $submitted_data->applicant_dob ?? $applicantVaultDetails['dob'] ?? null);
                                    try {
                                        $calculated_age = $dobValue ? \Carbon\Carbon::parse($dobValue)->age : old('applicant_age', $submitted_data->applicant_age ?? '');
                                    } catch (Exception $e) {
                                        $calculated_age = old('applicant_age', $submitted_data->applicant_age ?? '');
                                    }
                                @endphp
                                <input type="number" id="applicant_age" name="applicant_age" class="form-control" value="{{ $calculated_age }}" readonly required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Date of Payment of Last Contribution <span class="text-danger">*</span></label>
                                @php
                                    try {
                                        $lastContributionValue = old('last_contribution_date', isset($last_subscription_date) && $last_subscription_date ? \Carbon\Carbon::parse($last_subscription_date)->format('Y-m-d') : '');
                                    } catch (Exception $e) {
                                        $lastContributionValue = old('last_contribution_date', $submitted_data->last_contribution_date ?? '');
                                    }
                                @endphp
                                <input type="date" readonly name="last_contribution_date" class="form-control bg-light" value="{{ $lastContributionValue }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name of Husband <span class="text-danger">*</span></label>
                                <input type="text" name="husband_name" class="form-control" value="{{ old('husband_name', $submitted_data->husband_name ?? '') }}" required>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">2. Maternity Information</h6>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Name of Hospital Where Child was Born <span class="text-danger">*</span></label>
                                <input type="text" name="hospital_name" class="form-control" value="{{ old('hospital_name', $submitted_data->hospital_name ?? '') }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address of Hospital <span class="text-danger">*</span></label>
                                <textarea name="hospital_address" class="form-control" rows="2" required>{{ old('hospital_address', $submitted_data->hospital_address ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Date of Confinement (Childbirth) <span class="text-danger">*</span></label>
                                @php
                                    try {
                                        $dateOfConfinementValue = old('date_of_confinement', isset($submitted_data->date_of_confinement) && $submitted_data->date_of_confinement ? \Carbon\Carbon::parse($submitted_data->date_of_confinement)->format('Y-m-d') : '');
                                    } catch (Exception $e) {
                                        $dateOfConfinementValue = old('date_of_confinement', $submitted_data->date_of_confinement ?? '');
                                    }
                                @endphp
                                <input type="date" name="date_of_confinement" class="form-control" value="{{ $dateOfConfinementValue }}" min="{{ $minConfinementDate ?? '' }}" required>
                                @if($minConfinementDate)
                                    <small class="text-muted">Must be after completing 3 years of membership ({{ \Carbon\Carbon::parse($minConfinementDate)->format('d-m-Y') }}).</small>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Have You Applied for This Benefit Earlier? <span class="text-danger">*</span></label>
                                <select name="applied_earlier" id="applied_earlier" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('applied_earlier', $submitted_data->applied_earlier ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('applied_earlier', $submitted_data->applied_earlier ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>

                        <div id="previous_application_section" class="d-none bg-light p-3 rounded mb-3 border">
                            <h6 class="font-weight-bold text-secondary">Previous Application Details</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>If So, How Many Times? <span class="text-danger">*</span></label>
                                    <input type="number" name="times_applied_earlier" class="form-control" value="{{ old('times_applied_earlier', $submitted_data->times_applied_earlier ?? '') }}">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label>Details of Previous Application <span class="text-danger">*</span></label>
                                    <textarea name="previous_application_details" class="form-control" rows="1">{{ old('previous_application_details', $submitted_data->previous_application_details ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">3. Bank Account Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name of Bank Where Amount to be Deposited <span class="text-danger">*</span></label>
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
                                <label>Bank Account Number <span class="text-danger">*</span></label>
                                <input type="password" name="bank_account_number" id="bank_account_number" class="form-control" value="{{ old('bank_account_number', $submitted_data->bank_account_number ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Confirm Bank Account Number <span class="text-danger">*</span></label>
                                <input type="text" name="bank_account_number_confirmation" id="bank_account_number_confirmation" class="form-control" value="{{ old('bank_account_number_confirmation', $submitted_data->bank_account_number ?? '') }}" required>
                                <small id="account_match_msg" class="form-text"></small>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">4. Attachments</h6>
                        <div class="row">
                            @php
                                $documents = [
                                    'doc_account_paybook' => ['label' => 'Photocopy of Account Paybook (First page showing details)', 'required' => true],
                                    'doc_medical_certificate' => ['label' => 'Medical Certificate / Birth Certificate of Child', 'required' => true],
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
        // --- Logic for Previous Application Section ---
        const appliedEarlierSelect = document.getElementById('applied_earlier');
        const previousAppSection = document.getElementById('previous_application_section');

        function togglePreviousApplication() {
            if (appliedEarlierSelect.value === 'Yes') {
                previousAppSection.classList.remove('d-none');
            } else {
                previousAppSection.classList.add('d-none');
            }
        }

        appliedEarlierSelect.addEventListener('change', togglePreviousApplication);
        togglePreviousApplication(); // Run on load for old() or draft values


        // --- Logic for Bank Account Confirmation ---
        const accNumber = document.getElementById('bank_account_number');
        const confirmAccNumber = document.getElementById('bank_account_number_confirmation');
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

        accNumber.addEventListener('input', checkAccountsMatch);
        confirmAccNumber.addEventListener('input', checkAccountsMatch);

        // --- Prefill Age from DOB (in case DOB is provided by vault) ---
        function parseDateFlexible(s) {
            if (!s) return null;
            // Try native parse for ISO-like strings
            let d = new Date(s);
            if (!isNaN(d)) return d;
            // Fallback: split by non-digit
            const parts = s.split(/[^0-9]/).filter(Boolean);
            if (parts.length !== 3) return null;
            // If first part looks like year (4 digits)
            if (parts[0].length === 4) {
                return new Date(parts[0], parts[1] - 1, parts[2]);
            }
            // assume DD-MM-YYYY or DD/MM/YYYY
            return new Date(parts[2], parts[1] - 1, parts[0]);
        }

        function calculateAge(dob) {
            if (!dob) return '';
            const now = new Date();
            let age = now.getFullYear() - dob.getFullYear();
            const m = now.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && now.getDate() < dob.getDate())) {
                age--;
            }
            return age >= 0 ? age : '';
        }

        (function fillAgeFromDob() {
            const dobEl = document.getElementById('applicant_dob');
            const ageEl = document.getElementById('applicant_age');
            if (!dobEl || !ageEl) return;
            const raw = dobEl.value && dobEl.value.trim();
            if (!raw) return;
            const parsed = parseDateFlexible(raw);
            const age = calculateAge(parsed);
            if (age !== '' && ageEl.value !== String(age)) {
                ageEl.value = age;
            }
        })();
    });
</script>
