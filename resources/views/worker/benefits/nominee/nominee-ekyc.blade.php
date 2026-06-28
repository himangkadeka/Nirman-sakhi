@include('layout.workerheader')

<style>
    /* --- CSS Variables for easy theming --- */
    :root {
        --primary-color: #007bff;
        --primary-hover: #0056b3;
        --secondary-color: #6c757d;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --light-bg: #f8f9fa;
        --white-bg: #ffffff;
        --border-color: #dee2e6;
        --input-bg: #fdfdff;
        --text-dark: #343a40;
        --text-muted: #6c757d;
        --font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
    }

    body {
        font-family: var(--font-family);
        background-color: var(--light-bg);
        color: var(--text-dark);
    }

    /* --- Page Wrapper & Content --- */
    #page-content-wrapper {
        background-color: var(--light-bg);
    }

    .container-fluid.py-4 {
        padding: 1.5rem 2rem !important;
    }

    /* --- Breadcrumbs --- */
    ul.breadcrumb {
        padding: 0;
        margin-bottom: 1.5rem;
        list-style: none;
        display: flex;
        gap: 8px;
        font-size: 14px;
        color: var(--text-muted);
    }

    ul.breadcrumb li::after {
        content: "/";
        padding-left: 12px;
        color: #ccc;
    }

    ul.breadcrumb li:last-child::after {
        content: '';
    }

    ul.breadcrumb li:last-child {
        font-weight: 600;
        color: var(--text-dark);
    }

    /* --- Main Card Styling --- */
    .form-card {
        background: var(--white-bg);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.07);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 40px;
    }

    .benefit-heading {
        background: linear-gradient(45deg, var(--primary-color), #0069d9);
        padding: 25px 30px;
        color: white;
    }

    .benefit-heading h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .form_section {
        padding: 30px 30px 40px;
    }

    /* --- Form Elements --- */
    .form_control {
        margin-bottom: 25px;
    }

    .form_control label {
        font-size: 15px;
        color: var(--text-dark);
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form_control input[type="text"],
    .form_control input[type="numeric"] {
        width: 100%;
        height: 48px;
        padding: 10px 16px;
        font-size: 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        background-color: var(--input-bg);
    }

    .form_control input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
    }

    .input-group .form-control {
        border-right: 0;
    }

    .input-group .btn {
        height: 48px;
        border-radius: 0 8px 8px 0;
        box-shadow: none;
    }

    .form-control button, .btn-primary {
        background-color: var(--primary-color);
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 500;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .form-control button:hover:not(:disabled), .btn-primary:hover:not(:disabled) {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.25);
    }

    .form-control button:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
    }

    .btn-success {
        background-color: var(--success-color);
    }

    .btn-success:hover:not(:disabled) {
        background-color: #218838;
    }

    /* --- Helper & Error Text --- */
    .error-message {
        color: var(--danger-color);
        font-size: 13px;
        margin-top: 6px;
        display: none;
    }

    .text-muted-helper {
        margin-top: 8px;
        display: block;
        font-size: 13px;
        color: var(--text-muted);
    }

    /* --- Special Sections & Animations --- */
    #otpSection,
    #finalSubmitSection {
        display: none;
        animation: fadeIn 0.6s ease-in-out;
        border-top: 1px solid var(--border-color);
        padding-top: 25px;
        margin-top: 30px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- Consent Checkbox --- */
    .consent-checkbox {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .consent-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-right: 12px;
        accent-color: var(--primary-color);
        cursor: pointer;
    }

    .consent-text {
        font-size: 14px;
        color: var(--text-muted);
    }

    .consent-text .hover-trigger {
        color: var(--primary-color);
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
    }
    .consent-text .hover-trigger:hover {
        text-decoration: underline;
    }

    /* --- Modal Styling --- */
    .modal-header {
        background-color: var(--primary-color);
        color: white;
    }
    .modal-header .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    .modal-body-tc {
        max-height: 450px;
        overflow-y: auto;
        padding: 20px;
        line-height: 1.6;
    }
    .modal-body-tc ol {
        padding-left: 20px;
    }
    .modal-footer {
        border-top: 1px solid var(--border-color);
    }
</style>

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="container-fluid py-4">
            <ul class="breadcrumb">
                <li>Dashboard</li>
                <li>Nominee Registration</li>
            </ul>

            <div class="form-card">
                <div class="benefit-heading">
                    <h3>Nominee Registration</h3>
                </div>

                <section class="form_section">
                    <form id="nomineeForm" action="{{ route('nominee.ekyc', $nominee->id) }}" method="post">
                        @csrf
                        <div class="form_control">
                            <label for="Name">Name <span class="text-danger">*</span></label>
                            <input type="text" id="Name" name="Name" placeholder="Enter Your Name"
                                value="{{ $nominee->first_name }} {{ $nominee->last_name }}" readonly>
                        </div>

                        <div class="form_control">
                            <label for="phone">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" id="phone" name="phone" value="{{ $workerData->phone_no }}"
                                placeholder="Enter 10-digit phone number" maxlength="10">
                            <small class="text-muted-helper">
                                We have pre-filled the worker's phone number. You can change it if needed.
                            </small>
                            <div id="phoneError" class="error-message"></div>
                        </div>

                        <div class="form_control">
                            <div class="consent-checkbox">
                                <input type="checkbox" id="aadhar_consent" name="aadhar_consent" required>
                                <label for="aadhar_consent" class="consent-text">
                                    I agree to the <span class="hover-trigger" data-bs-toggle="modal"
                                        data-bs-target="#termsModal">Terms and Conditions</span> of UIDAI
                                </label>
                            </div>
                            <div id="consentError" class="error-message">You must agree to the terms and conditions.</div>
                        </div>

                        <div class="form_control">
                            <label for="uid">Aadhaar Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="uid" name="uid"
                                    placeholder="Enter 12-digit Aadhaar Number" maxlength="12" inputmode="numeric">
                                <button class="btn btn-primary" type="button" id="verifyButton" disabled>
                                    <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true" style="display: none;"></span>
                                    <span id="buttonText">Generate OTP</span>
                                </button>
                            </div>
                            <div id="aadhaarError" class="error-message"></div>
                        </div>

                        <div id="otpSection">
                            <div class="form_control">
                                <label for="otp">Enter OTP <span class="text-danger">*</span></label>
                                <input type="text" id="otp" name="otp"
                                    placeholder="Enter 6-digit OTP from your phone" maxlength="6" inputmode="numeric">
                                <div id="otpError" class="error-message"></div>
                            </div>

                            <div class="form_control">
                                <button type="button" id="submitOtpBtn" disabled>
                                    <span id="otpSpinner" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true" style="display: none;"></span>
                                    <span id="otpButtonText">Verify OTP</span>
                                </button>
                            </div>
                        </div>

                        <div id="finalSubmitSection">
                            <div class="form_control mb-0">
                                <button type="submit" id="finalSubmitBtn" class="btn-success">
                                    Complete Registration
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Aadhaar Terms & Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-tc">
                <ol>
                    <li>I understand that my Aadhaar number, biometric information and/or One-Time Password (OTP) and
                        demographic information, as understood under the Aadhaar (Targeted Delivery of Financial and
                        Other Subsidies, Benefits and Services) Act, 2016 and regulations framed thereunder, is being
                        collected by the Assam Building and Other Construction Workers Welfare Board(ABOCWWB) for the
                        following purposes:</li>
                    <ol type="a">
                        <li>Authenticating my identity by way of the Aadhaar number authentication system</li>
                        <li>Registering on the Nirman Sakhi Portal for Assam Building and Other Construction Worker's ID
                            and for availing benefits under the Building and Other Construction Workers Act 1996;</li>
                        <li>Seeding of Aadhaar number with my bank account;</li>
                        <li>Assessing my status of "Unorganised" worker and eligibility across Government programmes run
                            by the Assam Building and Other Construction Workers' Welfare Board under the Building and
                            Other Construction Workers Act 1996, or other similar welfare programmes run by other
                            Departments/Ministries of the Central Government and State Governments;</li>
                        <li>Delivering the benefits of various schemes of Departments/Ministries of Union and State
                            Governments framed for welfare of citizens;</li>
                        <li>Sharing of my Aadhaar number and demographic information with other Departments/Ministries
                            of the Central Government, State Governments and local bodies for formulation or
                            implementation of suitable welfare scheme(s);</li>
                        <li>Cross-verifying the collected Aadhaar number and associated identity information with the
                            Aadhaar-seeded database of other Departments/Ministries of the Central Government and State
                            Governments associated with the welfare scheme(s);</li>
                        <li>Measuring trends related to disbursement and effectiveness of social welfare benefits and
                            services and improving the quality of such benefits and services;</li>
                        <li>Resolving security or technical issues associated with disbursement of social welfare
                            benefits and services;</li>
                        <li>Strengthening digital platforms to ensure good governance and preventing dissipation of
                            social welfare benefits;</li>
                        <li>Detecting, preventing, and otherwise addressing malpractices and harmful conduct associated
                            with disbursement of social welfare benefits and services; and</li>
                        <li>All such purposes incidental thereto.</li>
                    </ol>
                    <li>I understand that the Assam Building and Other Construction Workers' Welfare Board shall create
                        an Aadhaar-seeded database containing my Aadhaar number, biometric and/or One-Time Password
                        (OTP) and demographic information for all or any of the purposes enlisted in paragraphs 1
                        (a)-(l) of this consent form, that the Assam Building and Other Construction Workers' Welfare
                        Board shall ensure that requisite mechanisms have been put in place to ensure safety, security
                        and privacy of such information in accordance with applicable laws and regulations and the Assam
                        Building and Other Construction Workers' Welfare Board shall not share my biometric information
                        with anyone for any reason whatsoever, or use it for any purpose other than authentication.</li>
                    <li>I understand that in case of failure to authenticate due to illness, injury or infirmity owing
                        to old age or otherwise or any technical reasons, the Assam Building and Other Construction
                        Workers' Welfare Board shall allow the following alternate means of identification for availing
                        benefits under the Bocw act 1996:</li>
                    <ol type="a">
                        <li>Voter ID card;</li>
                        <li>Ration card;</li>
                        <li>Passport;</li>
                        <li>Driving License;</li>
                        <li>Any Photo Identity Card issued by the Central Government, State Governments, or Union
                            Territory Administrations; Certificate of identity with photograph issued by a Gazetted
                            Officer on an official letterhead.</li>
                    </ol>
                    <li>I have no objection to authenticating myself with Aadhaar based authentication system and give
                        my consent to provide my Aadhaar Number, biometric information and/ or One-Time password (OTP)
                        and demographic information for Aadhaar based authentication for the purposes enlisted in
                        paragraphs 1 (a)-(l) of this consent form and for creation of an Aadhaar-seeded database as
                        described in Paragraph 2 of this consent form.</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

@include('components.footer')

<script src="{{ asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/template/js/sweetAlert.js') }}"></script>
<script src="{{ asset('assets/template/js/toastify-js.js') }}"></script>
<script src="{{ URL::asset('assets/encrypt/crypto-js.min.js') }}"></script>
<script src="{{ URL::asset('assets/encrypt/Encryption.js') }}"></script>


<script>
    $(document).ready(function() {
        // --- Toastify Helper ---
        function showToast(message, type = 'success') {
            const colors = {
                success: 'linear-gradient(to right, #00b09b, #96c93d)',
                error: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                info: 'linear-gradient(to right, #007bff, #0056b3)',
            };
            Toastify({
                text: message,
                duration: 5000,
                gravity: "top",
                position: "right",
                style: {
                    background: colors[type] || colors.info,
                },
                stopOnFocus: true
            }).showToast();
        }

        // --- Input Validation ---
        const validatePhone = () => {
            const phone = $('#phone').val().trim();
            const phoneRegex = /^\d{10}$/;
            const isValid = phoneRegex.test(phone);
            $('#phoneError').text(isValid ? '' : 'Please enter a valid 10-digit phone number.').toggle(!isValid);
            return isValid;
        };

        const validateAadhaar = () => {
            const aadhaar = $('#uid').val().trim();
            const aadhaarRegex = /^\d{12}$/;
            const isValid = aadhaarRegex.test(aadhaar);
            $('#aadhaarError').text(isValid ? '' : 'Please enter a valid 12-digit Aadhaar number.').toggle(!isValid);
            return isValid;
        };

        const validateConsent = () => {
            const isChecked = $('#aadhar_consent').is(':checked');
            $('#consentError').toggle(!isChecked);
            return isChecked;
        }

        // --- Enable/Disable Generate OTP Button ---
        const toggleVerifyButton = () => {
            const isPhoneValid = validatePhone();
            const isAadhaarValid = validateAadhaar();
            const isConsentChecked = $('#aadhar_consent').is(':checked');
            $('#verifyButton').prop('disabled', !(isPhoneValid && isAadhaarValid && isConsentChecked));
        };

        $('#phone, #uid, #aadhar_consent').on('input change', toggleVerifyButton);

        // --- Generate OTP Button Click Handler ---
        $('#verifyButton').click(function() {
            if (!validatePhone() || !validateAadhaar() || !validateConsent()) {
                 showToast('Please correct the errors before proceeding.', 'error');
                 return;
            }

            const $button = $(this);
            const $spinner = $('#spinner');
            const $buttonText = $('#buttonText');

            $spinner.show();
            $buttonText.text('Sending...');
            $button.prop('disabled', true);

            var nonceValue = "{{ $nonceValue }}";
            let encryption = new Encryption();
            var uidEnc = encryption.encrypt($('#uid').val().trim(), nonceValue);

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
                        showToast('OTP sent to your Aadhaar registered mobile ' + mobile, 'success');
                        $('#otpSection').slideDown();
                        $buttonText.text('OTP Sent');
                    } else {
                        showToast(response.message || 'Failed to generate OTP. Please try again.', 'error');
                        $button.prop('disabled', false); // Re-enable on failure
                        $buttonText.text('Generate OTP');
                    }
                },
                error: function(xhr) {
                    showToast('An error occurred. Please try again later.', 'error');
                    $button.prop('disabled', false); // Re-enable on error
                    $buttonText.text('Generate OTP');
                },
                complete: function() {
                    $spinner.hide();
                }
            });
        });

        // --- OTP Input Validation ---
        $('#otp').on('input', function() {
            const otp = $(this).val().trim();
            $('#submitOtpBtn').prop('disabled', otp.length !== 6);
        });

        // --- Submit OTP Button Click Handler ---
        $('#submitOtpBtn').click(function() {
            const otp = $('#otp').val().trim();
            if (!/^\d{6}$/.test(otp)) {
                showToast('Please enter a valid 6-digit OTP.', 'error');
                return;
            }

            const $button = $(this);
            const $spinner = $('#otpSpinner');
            const $buttonText = $('#otpButtonText');

            $spinner.show();
            $buttonText.text('Verifying...');
            $button.prop('disabled', true);

            $.ajax({
                url: "{{ route('otp-verification') }}",
                method: 'POST',
                data: {
                    dynamicPin: otp,
                    consent: 'y',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.errorCode === '000') {
                        showToast('Aadhaar e-KYC successful!', 'success');
                        $buttonText.text('Verified');
                        $('#finalSubmitSection').slideDown();
                        $('#otp').prop('readonly', true); // Make OTP field readonly
                    } else {
                        showToast(response.message || 'Invalid OTP or e-KYC failed.', 'error');
                        $button.prop('disabled', false); // Re-enable on failure
                        $buttonText.text('Verify OTP');
                    }
                },
                error: function(xhr) {
                    showToast('An error occurred during verification.', 'error');
                    $button.prop('disabled', false); // Re-enable on error
                    $buttonText.text('Verify OTP');
                },
                complete: function() {
                    $spinner.hide();
                }
            });
        });

        // // --- Final Form Submission ---
        // $('#nomineeForm').on('submit', function(e) {
        //     e.preventDefault();

        //     // Here you would add the final AJAX call to your server to save all the data
        //     // For demonstration, we'll show a success message and simulate a redirect.

        //     showToast('Nominee registration submitted successfully!', 'success');

        //     $('#finalSubmitBtn').prop('disabled', true).text('Submitting...');

        //     setTimeout(function() {
        //         // In a real application, you would submit the form data to the server
        //         // and then redirect based on the response.
        //         // e.g., this.submit(); or an AJAX call.
        //         // window.location.href = "/dashboard"; // Example redirect
        //          console.log("Form submitted. Implement final server call.");
        //     }, 2000);
        // });

        // Initial check on page load
        toggleVerifyButton();
    });
</script>
