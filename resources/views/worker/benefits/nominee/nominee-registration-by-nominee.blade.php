@extends('layouts.user-app')

@section('title', 'Nominee / Legal Heir Registration')

@section('style')
    <style>
        body {
            background-color: #f4f7fa;
        }

        .btn-primary {
            background-color: #7a5fff;
            border: none;
            box-shadow: 0 4px 10px rgba(122, 95, 255, 0.3);
        }

        .btn-primary:hover {
            background-color: #684dff;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 12px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #7a5fff;
            box-shadow: 0 0 0 0.2rem rgba(122, 95, 255, 0.25);
        }

        .form-control:read-only {
            background-color: #e9ecef;
            opacity: 1;
        }

        label {
            font-weight: 500;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eee;
            color: #495057;
        }

        .card-header {
            border-bottom: 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .card-header.completed {
            background-color: #d1e7dd !important;
            /* Light green for completed steps */
            /* color: #0f5132 !important; */
        }

        .form-check-input:checked {
            background-color: #7a5fff;
            border-color: #7a5fff;
        }
    </style>
@endsection

@section('content')
    <div class="container mb-5 mt-4 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <form id="mainRegistrationForm" action="{{route('nominee-registration-by-nominee')}}" method="POST">
                    @csrf
                    <input type="hidden" name="worker_id_card" id="worker_id_card_hidden">
                    <input type="hidden" name="registration_type" id="registration_type">

                    <!-- Step 1: Worker ID Validation (Always visible) -->
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #2badee;">
                            <i class="fas fa-search"></i>   Step 1: Find Worker by ID
                            <span class="header-icon float-end"></span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="id_no">Enter Worker ID card number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="id_no" name="id_no_search"
                                        value="ABOCWWB/26/2025/1/19259474" placeholder="Enter worker ID and click Validate">
                                    <button class="btn btn-outline-primary" type="button" id="validateBtn"><i
                                            class="fas fa-check-circle"></i> Validate</button>
                                </div>
                                <div id="id-error" class="text-danger mt-1" style="display: none;"></div>
                                <div id="id-loader" style="display: none;" class="mt-2">
                                    <span class="spinner-border spinner-border-sm text-primary"></span>
                                    <span>Validating...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Choose Registration Type -->
                    <div id="registration-choice-section" class="card mt-4 step-card" style="display: none;">
                        <div class="card-header text-white" style="background-color: #6c757d;">
                            <i class="fas fa-user-check"></i>   Step 2: Select Registration Type
                            <span class="header-icon float-end"></span>
                        </div>
                        <div class="card-body" style="display: none;">
                            <!-- Worker Details are shown inside this step now -->
                            <div class="section-title">Worker Details</div>
                            <div class="row mb-3">
                                <div class="col-md-6"><label class="form-label">Name of Worker</label><input type="text"
                                        class="form-control" id="worker_name" readonly></div>
                                <div class="col-md-6"><label class="form-label">Worker Phone</label><input type="text"
                                        class="form-control" id="worker_phone" readonly></div>
                            </div>
                            <hr>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="reg_type_choice" id="choice_nominee"
                                    value="nominee">
                                <label class="form-check-label" for="choice_nominee">Register an existing Nominee</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reg_type_choice" id="choice_legal_heir"
                                    value="legal_heir">
                                <label class="form-check-label" for="choice_legal_heir">Register as a new Legal Heir</label>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Detail Entry (Nominee or Legal Heir) -->
                    <div id="detail-entry-section" class="card mt-4 step-card" style="display: none;">
                        <div class="card-header text-white" style="background-color: #0d6efd;">
                            <i class="fas fa-edit"></i>   Step 3: Provide Details
                            <span class="header-icon float-end"></span>
                        </div>
                        <div class="card-body" style="display: none;">
                            <!-- Nominee Selection (conditionally shown) -->
                            <div id="nominee-select-subsection" style="display: none;">
                                <label for="nominee-dropdown" class="form-label">Select Nominee from Family</label>
                                <select id="nominee-dropdown" name="nominee_id" class="form-select">
                                    <option value="" selected disabled>-- Select a Nominee --</option>
                                </select>
                            </div>
                            <!-- Legal Heir Form (conditionally shown) -->
                            <div id="legal-heir-form-subsection" style="display: none;">
                                <div class="mb-3">
                                    <label for="legal_heir_name" class="form-label">Legal Heir Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="legal_heir_name"
                                        name="legal_heir_name" placeholder="Enter full name">
                                </div>
                                <div>
                                    <label for="legal_heir_phone" class="form-label">Legal Heir Phone <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="legal_heir_phone"
                                        name="legal_heir_phone" placeholder="Enter 10-digit mobile number" maxlength="10"
                                        pattern="\d*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Applicant Aadhaar Verification -->
                    <div id="applicant-verification-section" class="card mt-4 step-card" style="display: none;">
                        <div class="card-header text-white" style="background-color: #198754;">
                            <i class="fas fa-fingerprint"></i>   Step 4: Applicant e-KYC Verification
                        </div>
                        <div class="card-body" style="display: none;">
                            <div class="section-title">Applicant to be Verified</div>
                            <div class="row">
                                <div class="col-md-6 mb-3"><label class="form-label">Applicant Name</label><input
                                        type="text" class="form-control" name="applicant_name" id="applicant_name"
                                        readonly></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Applicant Phone</label><input
                                        type="text" class="form-control" name="applicant_phone" id="applicant_phone"
                                        maxlength="10" pattern="\d*"></div>
                            </div>
                            <hr class="my-4">

                            <div id="aadhaar-input-section">
                                <div class="mb-3"><label>Citizen Aadhaar Consent <span
                                            class="text-danger">*</span></label>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            id="aadhar_consent" name="aadhar_consent" required><label
                                            class="form-check-label" for="aadhar_consent">I agree to the <span
                                                class="text-primary" style="cursor: pointer;" data-bs-toggle="modal"
                                                data-bs-target="#termsModal">terms and conditions</span>.</label></div>
                                </div>
                                <div class="mb-3"><label class="form-label">Applicant's Aadhaar Number <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group"><input type="text" class="form-control"
                                            id="aadhaar_number" name="aadhaar_number"
                                            placeholder="Enter 12-digit Aadhaar number" maxlength="12"
                                            pattern="\d*"><button class="btn btn-outline-success" type="button"
                                            id="aadhaar-validate"><i class="fas fa-paper-plane"></i> Send OTP</button>
                                    </div>
                                </div>
                            </div>
                            <div id="aadhaar-otp-section" style="display: none;">
                                <div class="mb-3"><label class="form-label">Enter OTP</label><input type="text"
                                        class="form-control" id="aadhaar_otp" placeholder="Enter 6-digit OTP"
                                        maxlength="6" pattern="\d*"></div><button type="button"
                                    class="btn btn-primary" id="verify-otp">Verify OTP</button>
                            </div>

                            <div id="verified-aadhaar-details" class="mt-4" style="display: none;">
                                <div class="section-title text-success"><i class="fas fa-check-circle"></i> Aadhaar e-KYC
                                    Successful</div>
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center"><img id="verified-photo" src=""
                                            alt="Photo" class="img-thumbnail rounded-circle mb-3"
                                            style="width: 120px; height: 120px; object-fit: cover;"></div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-12 mb-3"><label class="form-label">Name</label><input
                                                    type="text" id="verified-name" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3"><label class="form-label">Date of
                                                    Birth</label><input type="text" id="verified-dob"
                                                    class="form-control" readonly></div>
                                            <div class="col-md-6 mb-3"><label class="form-label">Gender</label><input
                                                    type="text" id="verified-gender" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3"><label class="form-label">Address</label>
                                        <textarea id="verified-address" class="form-control" rows="3" readonly></textarea>
                                    </div>
                                </div>
                                <div class="text-center mt-4"><button type="submit" class="btn btn-success btn-lg"
                                        id="submit-form"><i class="fas fa-check"></i> Submit Final Registration</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('components.aadhar-consent')
    <div class="modal fade" id="formSubmittedModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-body"><img src="https://img.icons8.com/color/96/000000/ok--v1.png" alt="Success"
                        width="80" class="mb-3">
                    <h4 class="fw-bold mb-2">Registration Submitted!</h4>
                    <p class="text-muted">Application submitted successfully.</p><a href="{{ url('/') }}"
                        class="btn btn-primary px-4 mt-3">Go Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('assets/template/js/toastify-js.js') }}"></script>
    <script>
        $(document).ready(function() {

            function showToast(message, type = 'info') {
                const colors = {
                    error: '#dc3545',
                    success: '#28a745',
                    warning: '#ffc107',
                    info: '#0d6efd'
                };
                Toastify({
                    text: message,
                    duration: 4000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: colors[type]
                }).showToast();
            }

            // Core UI function to transition between steps
            function transitionToStep(targetSelector) {
                const activeStep = $('.step-card').filter((i, el) => $(el).find('.card-body').is(':visible'));

                if (activeStep.length && activeStep.attr('id') !== $(targetSelector).attr('id')) {
                    activeStep.find('.card-body').slideUp(300, function() {
                        activeStep.find('.card-header').addClass('completed');
                        activeStep.find('.header-icon').html('<i class="fas fa-check-circle"></i>');
                        $(targetSelector).slideDown(300).find('.card-body').slideDown(300);
                    });
                } else {
                    $(targetSelector).slideDown(300).find('.card-body').slideDown(300);
                }
            }

            // --- Event Handlers ---

            // 1. Validate Worker ID
            // --- Event Handlers ---

            // 1. Validate Worker ID
            $('#validateBtn').on('click', function() {
                const idNo = $('#id_no').val().trim();
                if (!idNo) {
                    showToast('Please enter a worker ID.', 'error');
                    return;
                }

                const $button = $(this);

                $.ajax({
                    url: "{{ route('check-id-card') }}",
                    method: 'POST',
                    data: {
                        id_card: idNo,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        // Disable button and show loader before the request is sent
                        $button.prop('disabled', true);
                        $('#id-error').hide();
                        $('#id_no').removeClass('is-invalid'); // Reset validation state
                        $('#id-loader').show();
                    },
                    success: function(response) {
                        // Check the business logic status from the server's response
                        if (response.status == true) {
                            // SUCCESS PATH: Data is valid.
                            // Use a short timeout for better user experience before transitioning.
                            setTimeout(() => {
                                $('#id-loader').hide();
                                showToast('Worker validated successfully!', 'success');

                                // --- Update UI to show completion ---
                                $('#id_no').prop('readonly', true);
                                $button.html('<i class="fas fa-lock"></i> Validated')
                                    .addClass('btn-success').removeClass(
                                        'btn-outline-primary');
                                $('.card:first .card-header').addClass('completed')
                                    .find('.header-icon').html(
                                        '<i class="fas fa-check-circle"></i>');

                                // --- Populate next step with data from the response ---
                                $("#worker_name").val(response.results.getVaultData
                                    .name);
                                $("#worker_phone").val(response.results.mainWorkerData
                                    .phone_no);

                                const select = $('#nominee-dropdown');
                                select.html(
                                    '<option value="" selected disabled>-- Select a Nominee --</option>'
                                ); // Clear previous options
                                response.results.families.forEach(nominee => {
                                    const optionText =
                                        `${nominee.first_name} ${nominee.last_name}`;
                                    select.append(new Option(optionText, nominee
                                        .id));
                                });

                                // --- Transition to the next step ---
                                transitionToStep('#registration-choice-section');

                            }, 800); // A small delay to make the loader feel responsive

                        } else {
                            // FAILURE PATH: The server responded, but the ID was invalid.
                            // This executes immediately, no timeout needed.
                            $('#id-loader').hide();
                            $('#id_no').addClass('is-invalid');
                            $('#id-error').text(response.results ||
                                "The provided ID is not valid.").show();
                            $button.prop('disabled',
                                false); // Re-enable button for user to try again
                        }
                    },
                    error: function(xhr, status, error) {
                        // AJAX ERROR PATH: The request itself failed (e.g., 500 error, network issue)
                        $('#id-loader').hide();
                        showToast('A server error occurred. Please try again later.', 'error');
                        $button.prop('disabled', false); // Re-enable button
                    }
                });
            });

            // 2. Handle Choice: Nominee vs Legal Heir
            $('input[name="reg_type_choice"]').on('change', function() {
                const choice = $(this).val();
                $('#registration_type').val(choice);

                if (choice === 'nominee') {
                    $('#legal-heir-form-subsection').hide();
                    $('#nominee-select-subsection').show();
                } else {
                    $('#nominee-select-subsection').hide();
                    $('#legal-heir-form-subsection').show();
                }
                transitionToStep('#detail-entry-section');
            });

            // 3. Handle Detail Entry completion
            $('#nominee-dropdown, #legal_heir_phone').on('change keyup', function() {
                const type = $('input[name="reg_type_choice"]:checked').val();
                let isReady = false;

                if (type === 'nominee' && $('#nominee-dropdown').val()) {
                    $('#applicant_name').val($('#nominee-dropdown option:selected').text()).prop(
                        'readonly', true);
                    $('#applicant_phone').val($("#worker_phone").val()).prop('readonly', false);
                    isReady = true;
                } else if (type === 'legal_heir' && $('#legal_heir_name').val() && /^\d{10}$/.test($(
                        '#legal_heir_phone').val())) {
                    $('#applicant_name').val($('#legal_heir_name').val()).prop('readonly', true);
                    $('#applicant_phone').val($('#legal_heir_phone').val()).prop('readonly', true);
                    isReady = true;
                }

                if (isReady && !$('#applicant-verification-section').is(':visible')) {
                    transitionToStep('#applicant-verification-section');
                }
            });

            // 4. Handle Aadhaar OTP Generation
            $('#aadhaar-validate').on('click', function() {
                if (!$('#aadhar_consent').is(':checked')) return showToast(
                    'Please provide Aadhaar consent.', 'warning');
                if (!/^\d{12}$/.test($('#aadhaar_number').val().trim())) return showToast(
                    'Enter a valid 12-digit Aadhaar number.', 'error');
                showToast('Sending OTP...', 'info');
                const aadhaar = $('#aadhaar_number').val().trim();
                var nonceValue = "{{ $nonceValue }}";
                let encryption = new Encryption();
                var uidEnc = encryption.encrypt(aadhaar, nonceValue);
                $.ajax({
                    url: "{{ route('generate-otp-aadhaar') }}",
                    method: 'POST',
                    data: {
                        uid: uidEnc,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === '0') {
                            var mobile = response.mobile;
                            setTimeout(() => {
                                showToast(
                                    'OTP sent to Aadhaar registered mobile number ' +
                                    mobile,
                                    'success');
                                $('#aadhaar-otp-section').slideDown();
                            }, 1500);
                        } else if (response.errorCode === '565') {
                            showToast('License key has expired ', 'error');

                            $('#aadhaar-otp-section').slideUp();
                        } else {
                            // Hide OTP input field if status is not 0
                            showToast('Failed To Generate OTP,please try again!', 'error');
                            $('#aadhaar-otp-section').slideUp();
                        }
                    }
                });


                // setTimeout(() => {
                //     showToast('OTP sent to Aadhaar registered mobile number.', 'success');
                //     $('#aadhaar-otp-section').slideDown();
                // }, 1500);
            });

            // 5. Handle OTP Verification
            $('#verify-otp').on('click', function() {
                if (!/^\d{6}$/.test($('#aadhaar_otp').val().trim())) return showToast(
                    'Enter a valid 6-digit OTP.', 'error');
                const $btn = $(this);
                const otp = $('#aadhaar_otp').val().trim();
                const consent = 'y';

                $.ajax({
                    url: "{{ route('aadhar-otp-verify-nominee') }}",
                    method: 'POST',
                    data: {
                        dynamicPin: otp,
                        consent: consent,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        // Show the loader
                        $btn.prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm"></span> Verifying...'
                        );
                        // Disable the button
                        $('#submitOTP').prop('disabled', true);
                    },

                    success: function(response) {
                        if (response.errorCode === '000') {
                            setTimeout(() => { // Simulate AJAX
                                $('#aadhaar-input-section, #aadhaar-otp-section')
                                    .slideUp();

                                $('#verified-photo').attr('src', 'data:image/jpeg;base64,' + response.kycData.photo);
                                $('#verified-name').val(response.kycData.name);
                                $('#verified-dob').val(response.kycData.dob);
                                $('#verified-gender').val(response.kycData.gender);
                                $('#verified-address').val(response.kycData.address);
                                $('#verified-aadhaar-details').slideDown();
                                showToast('e-KYC Verification Successful!', 'success');
                            }, 1500);
                        } else {
                            showToast('Invalid Otp', 'error');
                            $btn.prop('disabled', false).html(
                                'Verify Otp'
                            );
                            // Disable the button
                            $('#submitOTP').prop('disabled', false);
                        }
                    }
                });


            });

            // 6. Final Form Submission
            // $('#mainRegistrationForm').on('submit', function(e) {
            //     e.preventDefault();
            //     new bootstrap.Modal('#formSubmittedModal').show();
            // });
        });
    </script>
@endsection
