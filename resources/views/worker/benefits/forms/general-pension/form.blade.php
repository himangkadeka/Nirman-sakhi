@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="container py-5">
            <div class="card shadow border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Application for General Pension</h5>
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
                                <input type="text" name="application_number" class="form-control bg-light" value="{{ $submitted_data->application_number ?? 'PEN-' . time() }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Date of Application <span class="text-danger">*</span></label>
                                <input type="date" name="application_date" class="form-control bg-light" value="{{ $submitted_data->application_date ? \Carbon\Carbon::parse($submitted_data->application_date)->format('Y-m-d') : date('Y-m-d') }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>District <span class="text-danger">*</span></label>
                                <input type="hidden" name="district_id" value="{{ $submitted_data->district_id ?? $getVaultData['district_id'] ?? '' }}">
                                <input type="text" name="district_name" class="form-control bg-light" value="{{ $submitted_data->district->district_name ?? $getVaultData['district_name'] ?? '' }}" disabled>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Applicant's First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $submitted_data->first_name ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Applicant's Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $submitted_data->last_name ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Registration Number <span class="text-danger">*</span></label>
                                <input type="text" name="registration_number" class="form-control bg-light" value="{{ $id_card ?? '' }}" readonly>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Address of Applicant <span class="text-danger">*</span></label>
                                <textarea name="applicant_address" class="form-control bg-light" rows="2" readonly>{{ $getVaultData['landMark'] ?? '' }}, {{ $getVaultData['locality'] ?? '' }}, PO-{{ $getVaultData['postOffice'] ?? '' }}, PIN- {{ $getVaultData['pinCode'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="mobile_number" class="form-control bg-light" value="{{ $getVaultData['mobile'] ?? '' }}" readonly>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">2. Qualification Details</h6>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="applicant_dob" id="applicant_dob" class="form-control bg-light" value="{{ old('applicant_dob', $submitted_data->applicant_dob ?? $getVaultData['dob'] ?? '') }}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Age <span class="text-danger">*</span></label>
                                <input type="number" name="applicant_age" id="applicant_age" class="form-control bg-light" value="{{ old('applicant_age', $submitted_data->applicant_age ?? '') }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Date of completion of 60 years <span class="text-danger">*</span></label>
                                <input type="date" name="date_of_60_years" id="date_of_60_years" class="form-control bg-light" value="{{ old('date_of_60_years', $submitted_data->date_of_60_years ?? '') }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Date of Last Contribution Payment <span class="text-danger">*</span></label>
                                <input type="date" name="last_contribution_date" class="form-control bg-light" value="{{ old('last_contribution_date', $submitted_data->last_contribution_date ?? '') }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Loan/advance amount remaining to be recovered (if any) <span class="text-danger">*</span></label>
                                <input type="text" name="recovered_loan_amount" class="form-control" value="{{ old('recovered_loan_amount', $submitted_data->recovered_loan_amount ?? '0') }}" required>
                            </div>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">3. Details of Family Members</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-sm" id="familyTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Relation</th>
                                        <th>Age</th>
                                        <th>Occupation</th>
                                        <th class="text-center" style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Handle existing array or JSON string if validation fails or editing draft
                                        $familyMembers = old('family_members_details', $submitted_data->family_members_details ?? []);
                                        if (is_string($familyMembers)) {
                                            $familyMembers = json_decode($familyMembers, true);
                                        }
                                    @endphp

                                    @if(is_array($familyMembers) && count($familyMembers) > 0)
                                        @foreach($familyMembers as $index => $member)
                                            <tr>
                                                <td><input type="text" name="family_members_details[{{$index}}][name]" class="form-control form-control-sm" value="{{ $member['name'] ?? '' }}" required></td>
                                                <td><input type="text" name="family_members_details[{{$index}}][relation]" class="form-control form-control-sm" value="{{ $member['relation'] ?? '' }}" required></td>
                                                <td><input type="number" name="family_members_details[{{$index}}][age]" class="form-control form-control-sm" value="{{ $member['age'] ?? '' }}" required></td>
                                                <td><input type="text" name="family_members_details[{{$index}}][occupation]" class="form-control form-control-sm" value="{{ $member['occupation'] ?? '' }}" required></td>
                                                <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td><input type="text" name="family_members_details[0][name]" class="form-control form-control-sm" required></td>
                                            <td><input type="text" name="family_members_details[0][relation]" class="form-control form-control-sm" required></td>
                                            <td><input type="number" name="family_members_details[0][age]" class="form-control form-control-sm" required></td>
                                            <td><input type="text" name="family_members_details[0][occupation]" class="form-control form-control-sm" required></td>
                                            <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-info" id="addFamilyRow"><i class="fa fa-plus"></i> Add Family Member</button>
                        </div>

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">4. Bank & Pension Details</h6>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Address where pension is to be sent <span class="text-danger">*</span></label>
                                <textarea name="pension_address" class="form-control" rows="2" required>{{ old('pension_address', $submitted_data->pension_address ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Bank Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $submitted_data->bank_name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Bank Branch Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_branch_name" class="form-control" value="{{ old('bank_branch_name', $submitted_data->bank_branch_name ?? '') }}" required>
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

                        <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3 mt-4">5. Attachments</h6>
                        <div class="row">
                            @php
                                $documents = [
                                    'doc_account_paybook' => ['label' => 'Photocopy of A/c pay book (First page)', 'required' => true],
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

        // --- Logic for Calculate 60 Years Date ---
        const dobInput = document.getElementById('applicant_dob');
        const date60Input = document.getElementById('date_of_60_years');
        const ageInput = document.getElementById('applicant_age');

        function calculate60thBirthday() {
            if (dobInput.value) {
                const dob = new Date(dobInput.value);
                const date60 = new Date(dob);
                date60.setFullYear(date60.getFullYear() + 60);

                // Format correctly as YYYY-MM-DD for the input
                const formattedDate = date60.toISOString().split('T')[0];
                date60Input.value = formattedDate;

                // Simple age calculation for visual reference
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const m = today.getMonth() - dob.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                ageInput.value = age;
            }
        }

        // Run on load if DOB exists
        if(dobInput.value) {
            calculate60thBirthday();
        }


        // --- Logic for Dynamic Family Members Table ---
        let rowIndex = {{ count(is_array(old('family_members_details', $submitted_data->family_members_details ?? [])) ? old('family_members_details', $submitted_data->family_members_details ?? []) : []) ?: 1 }};
        const tableBody = document.querySelector('#familyTable tbody');
        const addBtn = document.getElementById('addFamilyRow');

        addBtn.addEventListener('click', function() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="family_members_details[${rowIndex}][name]" class="form-control form-control-sm" required></td>
                <td><input type="text" name="family_members_details[${rowIndex}][relation]" class="form-control form-control-sm" required></td>
                <td><input type="number" name="family_members_details[${rowIndex}][age]" class="form-control form-control-sm" required></td>
                <td><input type="text" name="family_members_details[${rowIndex}][occupation]" class="form-control form-control-sm" required></td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fa fa-trash"></i></button></td>
            `;
            tableBody.appendChild(newRow);
            rowIndex++;
        });

        tableBody.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                // Keep at least one row
                if (tableBody.children.length > 1) {
                    e.target.closest('tr').remove();
                } else {
                    alert("You must include at least one family member, or leave the fields blank if none.");
                }
            }
        });


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
                submitBtn.disabled = true;
            }
        }

        accNumber.addEventListener('input', checkAccountsMatch);
        confirmAccNumber.addEventListener('input', checkAccountsMatch);
    });
</script>
