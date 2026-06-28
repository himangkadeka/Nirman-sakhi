@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="container py-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Application for Marriage Assistance</h5>
                </div>

                <div class="card-body">
                    
                    @php
                        // CALCULATE THE 5-YEAR COMPLETION DATE
                        $workerSession = session()->get('worker');
                        $minMarriageDate = '';
                        if ($workerSession) {
                            $workerProfile = \App\Models\MainWorkerForm::where('worker_id', $workerSession->worker_id)->first();
                            if ($workerProfile && $workerProfile->last_registration_date) {
                                // Add exactly 5 years to their registration date
                                $minMarriageDate = \Carbon\Carbon::parse($workerProfile->last_registration_date)->addYears(5)->format('Y-m-d');
                            }
                        }
                    @endphp

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
                                <input type="text" name="application_number" class="form-control bg-light" value="{{ $submitted_data->application_number ?? 'MAR-' . time() }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Date <span class="text-danger">*</span></label>
                                <input type="date" name="application_date" class="form-control bg-light" value="{{ $submitted_data->application_date ? \Carbon\Carbon::parse($submitted_data->application_date)->format('Y-m-d') : date('Y-m-d') }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>District <span class="text-danger">*</span></label>
                                <input type="hidden" name="district_id" value="{{ $submitted_data->district_id ?? '' }}">
                                <input type="text" name="district_name" class="form-control bg-light" value="{{ $submitted_data->district->district_name ?? '' }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name of Applicant <span class="text-danger">*</span></label>
                                <input type="text" name="applicant_name" class="form-control bg-light" value="{{ $getVaultData['name'] ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Registration ID of Applicant <span class="text-danger">*</span></label>
                                <input type="text" name="registration_id" class="form-control bg-light" value="{{ $id_card ?? '' }}" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address of Applicant <span class="text-danger">*</span></label>
                                <textarea class="form-control bg-light" rows="2" readonly>{{ $getVaultData['landMark'] ?? '' }}, {{ $getVaultData['locality'] ?? '' }}, PO-{{ $getVaultData['postOffice'] ?? '' }}, PIN- {{ $getVaultData['pinCode'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="applicant_dob" class="form-control" value="{{ old('applicant_dob', $submitted_data->applicant_dob ?? '') }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Age <span class="text-danger">*</span></label>
                                <input type="number" name="applicant_age" class="form-control" value="{{ old('applicant_age', $submitted_data->applicant_age ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Social Category <span class="text-danger">*</span></label>
                                <select name="social_category" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Category::get() as $category)
                                        <option value="{{ $category->category_code }}" 
                                            {{ old('social_category', $submitted_data->social_category ?? '') == $category->category_code ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Date of Payment of Last Contribution <span class="text-danger">*</span></label>
                                <input type="date" name="last_contribution_date" class="form-control" value="{{ old('last_contribution_date', $submitted_data->last_contribution_date ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Duration of Membership (in years/months) <span class="text-danger">*</span></label>
                                <input type="text" name="membership_duration" class="form-control" value="{{ old('membership_duration', $submitted_data->membership_duration ?? '') }}" required>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">2. Marriage Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Application for Marriage of Son/Daughter? <span class="text-danger">*</span></label>
                                <select name="is_for_son_daughter" id="is_for_son_daughter" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('is_for_son_daughter', $submitted_data->is_for_son_daughter ?? '') == 'Yes' ? 'selected' : '' }}>Yes (Son/Daughter)</option>
                                    <option value="No" {{ old('is_for_son_daughter', $submitted_data->is_for_son_daughter ?? '') == 'No' ? 'selected' : '' }}>No (Marriage of Self - Female Worker)</option>
                                </select>
                            </div>
                        </div>

                        <div id="son_daughter_section" class="d-none bg-light p-3 rounded mb-3 border">
                            <h6 class="font-weight-bold text-secondary">Marriage of Son / Daughter Details</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Is Husband or Wife a Registered Beneficiary? <span class="text-danger">*</span></label>
                                    <select name="spouse_is_beneficiary" id="spouse_is_beneficiary" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 d-none" id="spouse_details_div">
                                    <label>Name and Reg. Number of Husband/Wife</label>
                                    <input type="text" name="spouse_reg_details" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Has Husband/Wife Applied for Financial Assistance?</label>
                                    <select name="spouse_applied_assistance" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Date of Birth of Son/Daughter <span class="text-danger">*</span></label>
                                    <input type="date" name="child_dob" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Name of Bride/Groom <span class="text-danger">*</span></label>
                                    <input type="text" name="child_spouse_name" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Address of Bride/Groom <span class="text-danger">*</span></label>
                                    <textarea name="child_spouse_address" class="form-control" rows="1"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Date of Marriage <span class="text-danger">*</span></label>
                                    <!-- RESTRICTION APPLIED HERE -->
                                    <input type="date" name="child_marriage_date" class="form-control" min="{{ $minMarriageDate }}">
                                    @if($minMarriageDate)
                                        <small class="text-muted">Must be after completing 5 years of membership ({{ \Carbon\Carbon::parse($minMarriageDate)->format('d-m-Y') }}).</small>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Number of Marriage (1st, 2nd, etc.) <span class="text-danger">*</span></label>
                                    <input type="number" name="child_marriage_number" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Date of Marriage Certificate</label>
                                    <input type="date" name="child_marriage_cert_date" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Marriage Certificate Number</label>
                                    <input type="text" name="child_marriage_cert_no" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Issuing Authority Name</label>
                                    <input type="text" name="child_marriage_cert_authority" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Issuing Authority Address</label>
                                    <textarea name="child_marriage_cert_auth_address" class="form-control" rows="1"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Applied for Marriage Assistance for Any Other Son/Daughter? (If Yes, Details)</label>
                                    <textarea name="other_child_assistance_details" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div id="self_section" class="d-none bg-light p-3 rounded mb-3 border">
                            <h6 class="font-weight-bold text-secondary">Marriage of Self (Female Worker Only)</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Name of Bridegroom <span class="text-danger">*</span></label>
                                    <input type="text" name="self_bridegroom_name" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Date of Marriage <span class="text-danger">*</span></label>
                                    <!-- RESTRICTION APPLIED HERE -->
                                    <input type="date" name="self_marriage_date" class="form-control" min="{{ $minMarriageDate }}">
                                    @if($minMarriageDate)
                                        <small class="text-muted">Must be after completing 5 years of membership ({{ \Carbon\Carbon::parse($minMarriageDate)->format('d-m-Y') }}).</small>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Place of Marriage <span class="text-danger">*</span></label>
                                    <input type="text" name="self_marriage_place" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Address of Bridegroom <span class="text-danger">*</span></label>
                                    <textarea name="self_bridegroom_address" class="form-control" rows="1"></textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Date of Marriage Certificate</label>
                                    <input type="date" name="self_marriage_cert_date" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Marriage Certificate Number</label>
                                    <input type="text" name="self_marriage_cert_no" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Issuing Authority Name</label>
                                    <input type="text" name="self_marriage_cert_authority" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Issuing Authority Address</label>
                                    <textarea name="self_marriage_cert_auth_address" class="form-control" rows="1"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Are You in Receipt of Any Financial Assistance for this Purpose from Govt or Any Other Institution? <span class="text-danger">*</span></label>
                                <select name="received_other_assistance" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('received_other_assistance', $submitted_data->received_other_assistance ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('received_other_assistance', $submitted_data->received_other_assistance ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">3. Attachments</h6>
                        <div class="row">
                            @php
                                $documents = [
                                    'doc_bank_passbook' => ['label' => 'Photocopy of A/c paybook (First page)', 'required' => true],
                                    'doc_invitation_card' => ['label' => 'Marriage Invitation Card', 'required' => true],
                                    'doc_age_proof' => ['label' => 'Age Proof of Bride/Groom (Birth Cert/Aadhaar)', 'required' => true],
                                    'doc_marriage_certificate' => ['label' => 'Copy of Marriage Certificate (If already married)', 'required' => false],
                                    'doc_photographs' => ['label' => 'Bride and Groom’s Photograph', 'required' => true],
                                    'doc_signatures' => ['label' => 'Bride and Groom’s Thumb Impression/Signature', 'required' => true],
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const selectSonDaughter = document.getElementById('is_for_son_daughter');
        const sonDaughterSection = document.getElementById('son_daughter_section');
        const selfSection = document.getElementById('self_section');

        const spouseIsBeneficiary = document.getElementById('spouse_is_beneficiary');
        const spouseDetailsDiv = document.getElementById('spouse_details_div');

        // Function to toggle marriage sections
        function toggleMarriageSections() {
            const val = selectSonDaughter.value;
            if (val === 'Yes') {
                sonDaughterSection.classList.remove('d-none');
                selfSection.classList.add('d-none');
            } else if (val === 'No') {
                selfSection.classList.remove('d-none');
                sonDaughterSection.classList.add('d-none');
            } else {
                sonDaughterSection.classList.add('d-none');
                selfSection.classList.add('d-none');
            }
        }

        // Function to toggle spouse beneficiary details
        function toggleSpouseDetails() {
            if (spouseIsBeneficiary.value === 'Yes') {
                spouseDetailsDiv.classList.remove('d-none');
            } else {
                spouseDetailsDiv.classList.add('d-none');
            }
        }

        // Event Listeners
        selectSonDaughter.addEventListener('change', toggleMarriageSections);
        spouseIsBeneficiary.addEventListener('change', toggleSpouseDetails);

        // Run on load in case of old() values or drafts
        toggleMarriageSections();
        toggleSpouseDetails();
    });
</script>