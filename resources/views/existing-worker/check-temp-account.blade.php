@extends('layouts.user-app')

@section('title', 'Existing Worker')

@section('style')
    <style>

        :root {
            --primary-color: #2badee;
            --secondary-color: #0f4547;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #fd7e14;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Roboto', sans-serif;
        }

        .registration-card {
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
        }

        .card-header {
            background-color: var(--primary-color);
            /*padding: 1.25rem 1.5rem;*/
            border-bottom: none;
        }

        .card-header h5 {
            font-weight: 600;
            margin-bottom: 0;
        }

        .card-header i {
            font-size: 1.25rem;
            margin-right: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }

        .form-control {
            border-left: none;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(43, 173, 238, 0.25);
            border-color: var(--primary-color);
        }

        .validate {
            background-color: #e9ecef;
            color: #495057;
            border-radius: 0px !important;
            border-color: #ced4da;
        }

        .validate:hover {
            background-color: #dee2e6;
        }

        .checkOnboarding {
            background-color: var(--warning-color);
            border-radius: 0px !important;
            color: white;
        }

        .checkOnboarding:hover {
            background-color: #e67300;
            color: white;
        }

        .invalid-feedback {
            font-size: 0.875rem;
        }

        .accounts-container {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-top: 1rem;
            background-color: white;
        }

        .form-check-label {
            cursor: pointer;
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }

        .modal-title {
            font-weight: 600;
        }

        .account-detail-item {
            margin-bottom: 0.75rem;
        }

        .account-detail-label {
            font-weight: 600;
            color: #495057;
        }

        .account-detail-value {
            color: var(--primary-color);
        }

        .otp-input-container {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin: 1.5rem 0;
        }

        .otp-input {
            width: 3rem;
            height: 3.5rem;
            text-align: center;
            font-size: 1.5rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            transition: all 0.3s;
        }

        .otp-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(43, 173, 238, 0.25);
            outline: none;
        }

        .timer-text {
            color: #6c757d;
            font-size: 0.875rem;
            text-align: center;
            margin-top: 1rem;
        }

        #resend-otp-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            text-decoration: underline;
        }

        .loading-spinner {
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
            vertical-align: text-bottom;
            margin-right: 0.5rem;
        }

        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }

        /*.hidden {*/
            /*display: none !important;*/
        /*}*/

        .badge-status {
            padding: 0.35em 0.65em;
            font-size: 0.875em;
            font-weight: 600;
        }

        .btn-action {
            min-width: 120px;
        }

        .otp-inputs {
            display: flex;
            justify-content: space-between;
            width: 220px;
            /* Adjust as needed */
            margin-bottom: 20px;
            /* Add some space below the inputs */
        }

        .hidden {
            display: none;
        }

        .audio-control {
            cursor: pointer;
            font-size: 40px;
            /* Adjust the size of the icon */
            color: #333;
            /* Change the icon color */
        }

        .audio-control:hover {
            color: #007bff;
            /* Change the icon color on hover */
        }

        .timeframe {
            margin-top: 10px;
            font-size: 16px;
            color: #555;
        }

        .otp-input {
            width: 30px;
            /* Adjust width as needed */
            height: 40px;
            /* Adjust height as needed */
            text-align: center;
            font-size: 20px;
            margin-right: 5px;
            border: 1px solid #ccc;
            /* Light gray border */
            border-radius: 5px;
            /* Rounded corners */
            transition: border-color 0.3s, background-color 0.3s;
            /* Smooth transition for border and background */
        }

        .otp-input:focus {
            border-color: #007bff;
            /* Blue border on focus */
            background-color: #e7f0fe;
            /* Light blue background on focus */
            outline: none;
            /* Remove default outline */
        }

        .otp-input:last-child {
            margin-right: 0;
        }



        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }


        label.bold {
            font-weight: 600;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }

        .btn-primary {
            background-color: #0f4547;
        }

        .toastify-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: rgba(255, 255, 255, 0.7);
            animation: progressBar 3s linear forwards;
            /* Adjust duration to match the toast duration */
        }

        @keyframes progressBar {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        .change .bar1 {
            -webkit-transform: rotate(-45deg) translate(-5px, 5px);
            transform: rotate(-45deg) translate(-5px, 5px);
        }

        .change .bar2 {
            opacity: 0;
        }

        .change .bar3 {
            -webkit-transform: rotate(45deg) translate(-5px, -7px);
            transform: rotate(45deg) translate(-5px, -7px);
        }

        .modal-body {
            max-height: 400px;
            /* Adjust this value as needed */
            overflow-y: auto;
        }

        .btn-lightgrey{
            background: lightgrey;
        }

        .swal-otp-popup {
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        }

        .swal-otp-title {
            color: #333;
            font-size: 24px;
        }

        .swal-otp-html-container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .swal-otp-input-container {
            margin: 20px 0;
        }

        #otp-input {
            letter-spacing: 10px;
            text-align: center;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px;
            width: 80%;
            margin: 0 auto;
        }

        #timer-text {
            color: #555;
        }

        .swal-otp-confirm-button {
            background-color: #4CAF50 !important;
            border-radius: 8px !important;
        }

        .swal-otp-cancel-button {
            border-radius: 8px !important;
        }

        .swal-otp-resend-button {
            background: none !important;
            border: none !important;
            color: #3498db !important;
            text-decoration: underline !important;
            cursor: pointer !important;
            padding: 0 !important;
            font-size: 1em !important;
        }
    </style>
@endsection


@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card registration-card">
                    <div class="card-header">
                        <h6 class="mb-0 text-white">
                            <i class="fas fa-hard-hat"></i> Construction Workers Registration
                            <span class="fw-normal">(Onboarding)</span>
                        </h6>
                    </div>

                    <div class="card-body p-4">
                        <form id="workerRegistrationForm">
                        @csrf
                        <!-- Phone Number Section -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label" for="phone_no">
                                        Phone Number <span class="text-danger">*</span>
                                    </label>
                                    <span class="badge bg-danger text-light">
                                    <small>Upto 4 registrations allowed per number</small>
                                </span>
                                </div>

                                @php
                                    $isReadonly = session()->has('pfcData');
                                    $mobileValue = $isReadonly ? $pfc_data->mobile : '';
                                @endphp

                                <div class="input-group" style="height: 45px;">
                               <span class="input-group-text h-100">
                                    <i class="fas fa-mobile-alt"></i>
                                </span>
                                    <input type="text"
                                           class="form-control h-100"
                                           id="phone_no"
                                           name="phone_no"
                                           placeholder="Enter 10-digit mobile number"
                                           maxlength="10"
                                           inputmode="numeric"
                                           pattern="\d*"
                                           value="{{ $mobileValue }}" {{ $isReadonly ? 'readonly' : '' }} >

                                    <button class="btn btn-sm btn-lightgrey validate" type="button" id="validateBtn" title="Validate Number">
                                        <i class="fas fa-check-circle me-1"></i> Validate
                                    </button>
                                    <button class="btn btn-sm btn-warning checkOnboarding" type="button" id="checkRecordBtn" title="Check Record" style="display: none;">
                                        <i class="fas fa-search me-1"></i> Check Record
                                    </button>
                                </div>

                                <!-- Loading and Error States -->
                                <div id="phone-loader" class="mt-2" style="display: none;">
                                    <div class="d-flex align-items-center text-primary">
                                        <span class="loading-spinner"></span>
                                        <span>Checking phone number...</span>
                                    </div>
                                </div>

                                <div id="phone_noError" class="invalid-feedback d-block"></div>
                                @if ($errors->has('phone_no'))
                                    <div class="text-warning small mt-1">{{ $errors->first('phone_no') }}</div>
                                @endif
                            </div>

                            <!-- Existing Accounts Section -->
                            <div class="accounts-container hidden" id="ex-accounts-dropdown-container">
                                <label class="form-label fw-semibold mb-3">Select Your Application:</label>
                                <div id="ex-accounts-radio-container" class="worker_id"></div>
                            </div>

                            <!-- Count Message -->
                            <div class="alert alert-info py-2 mb-0" id="countMsg" style="display: none;"></div>
                            <div class="d-flex justify-content-center mt-4 mb-2">
                                <button id="ex-register-button" type="submit" class="btn btn-success"
                                        style="display: none;">Proceed</button>

                                <a href="{{ route('home.index') }}" id="exit" type="submit"
                                   class="btn btn-danger ml-2" style="display: none;">Exit</a>

                                <div id="spinner-old" style="display:none;">
                                    <i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Please Wait...
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->

    <div class="modal fade" id="accountDetailsModal" tabindex="-1" role="dialog" aria-labelledby="accountDetailsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Account Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Application No:</strong> <span id="modalAccountName" class="text-primary"></span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Applicant Name:</strong> <span id="modalApplicationName"
                                        class="text-primary"></span></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Contact No:</strong> <span id="modalAccountPhone" class="text-primary"></span>
                                </p>
                                <input type="hidden" id="hiddenContactNo" value="">
                            </div>
                            <div class="col-md-6">
                                <p><strong>Application Status:</strong> <span id="modalApplicationStatus"
                                        class="badge bg-warning"></span></p>
                            </div>
                        </div>
                        <input type="hidden" id="hiddenWorkerIdEx" value="">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p><strong>Remarks:</strong> <span id="modalApplicationRemarks"
                                        class="text-danger"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="" id="otp_form" style="display: none;">
                        <div class="form-group otp">
                            <label for="phone_no" class="bold">Please Enter Otp</label>
                            <div class="input-field-otp">
                                <input type="number" id="otp_1" />
                                <input type="number" id="otp_2" disabled />
                                <input type="number" id="otp_3" disabled />
                                <input type="number" id="otp_4" disabled />
                                <input type="number" id="otp_5" disabled />
                                <input type="number" id="otp_6" disabled />
                            </div>

                        </div>

                        <div class="d-flex justify-content-center py-4">
                            <button type="button" id="verify_otp" class="verify_button btn btn-primary"><i
                                    class="fas fa-sign-in-alt"></i>&nbsp;Verify OTP</button>
                        </div>
                        <div class="d-flex justify-content-center">
                            <p id="resend_timer"> Resend OTP in <span id="timer_1" class="text-success">180 </span>
                                Seconds</p>
                            <button type="button" id="resend_otp" class="resend_button btn btn-outlined-primary"
                                style="display: none;" disabled>&nbsp;Resend OTP</button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalButton"
                        data-dismiss="modal">Close</button>
                    <a href="" class="btn btn-sm btn-danger" id="erase-application-ex">Delete Application</a>
                    <a href="" class="btn btn-sm btn-success" id="login-otp-ex">Login through OTP</a>
                    <a href="" class="btn btn-sm btn-success" id="resubmit-app">Re-Submit</a>
                </div>

            </div>
        </div>
    </div>


    <form id="new-registration-form" action="{{ route('save-ex-phone-no') }}" method="POST">
        @csrf
        <input type="hidden" name="phone_no" id="phone_no_to_save" value="{{ $mobileValue }}">

    </form>
@endsection

@section('footer')
<script>
    $(document).ready(function () {
        let isOtpVerified = false;
        let verifiedMobile = '';
        let resendTimer;

        // This function now only handles the visual cue of checking the phone number
        $('#phone_no').on('blur', function () {
                var phone = $(this).val();
                console.log(phone)
                if (/^\d{10}$/.test(phone)) {
                $('#phone-loader').show();
                    $.ajax({
                        url: '{{ 'check-phone-count-ex' }}',
                        type: 'GET',
                        data: { phone: phone },
                        success: function (response) {
        // This success callback can be used to display messages
        // but should not alter the primary buttons.
                        if (response.count >= 4) {
                            $('#countMsg').text('This number has reached the maximum number of registrations.').show();
                            $('#validateBtn').hide();
                            $('.checkOnboarding').show();

                        } else {
                             $('#countMsg').text(`This number can be used for ${4 - response.count} more registrations.`).show();
                        }
                        },
                                 error: function () {
                                    console.log('Error checking phone count');
                        },
                                 complete: function () {
                                $('#phone-loader').hide();
                        }
                        });
                        }
                        });

                    $('#validateBtn').on('click', function () {
                    let mobile = $('#phone_no').val().trim();

                    if (!/^\d{10}$/.test(mobile)) {
                    Swal.fire('Error', 'Please enter a valid 10-digit mobile number.', 'error');
                    return;
                    }

                    $('#spinner-old').show();

        // First, check if the phone number has existing records.
                $.ajax({
                type: 'POST',
                url: "{{ route('check-phone-ex') }}",
                data: {
                _token: "{{ csrf_token() }}",
                phone_no: mobile
                },
                success: function(response) {
                $('#spinner-old').hide();
                if (response.status === 'accounts_found' || response.status === 'limit') {
                // If accounts are found, hide validate and show check record
                    $('#validateBtn').hide();
                    $('#phone_no').prop('readonly', true);
                    $('#phone_no_to_save').val(mobile);
                    $('.checkOnboarding').click();
                } else if (response.status === 'new_register') {
                // If it's a new number, proceed with OTP validation
                sendOtp(mobile);
                    $('#spinner-old').show();
                }
                },
                error: function (xhr) {
                $('#spinner-old').hide();
                Swal.fire('Error', xhr.responseJSON.message || 'An error occurred.', 'error');
                }
                });
                });

    function sendOtp(mobile) {
    $.ajax({
    url: '{{ route('generate-otp-new') }}',
    type: 'POST',
    data: {
    mobile: mobile,
    _token: '{{ csrf_token() }}'
    },
    success: function () {
    $('#spinner-old').hide();
    showOtpModalWithCountdown(mobile);
    },
    error: function (xhr) {
    $('#spinner-old').hide();
    Swal.fire('Error', xhr.responseJSON.message || 'Failed to send OTP.', 'error');
    }
    });
    }

        function showOtpModalWithCountdown(mobile) {
            let timeLeft = 120; // 2 minutes
            let resendTimer;

            Swal.fire({
                title: 'Enter OTP',
                html: `
            <p>An OTP has been sent to your mobile number.</p>
            <div class="swal-otp-input-container">
                <input id="otp-input" class="swal2-input" maxlength="6" placeholder="Enter 6-digit OTP">
            </div>
            <p id="timer-text">You can resend OTP in <b>${timeLeft}</b> seconds.</p>
        `,
                customClass: {
                    popup: 'swal-otp-popup',
                    title: 'swal-otp-title',
                    htmlContainer: 'swal-otp-html-container',
                    confirmButton: 'swal-otp-confirm-button',
                    cancelButton: 'swal-otp-cancel-button'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit OTP',
                didOpen: () => {
                    const timerEl = Swal.getHtmlContainer().querySelector('#timer-text b');
                    resendTimer = setInterval(() => {
                        timeLeft--;
                        timerEl.textContent = timeLeft;
                        if (timeLeft <= 0) {
                            clearInterval(resendTimer);
                            Swal.getHtmlContainer().querySelector('#timer-text').innerHTML = `<button id="resend-otp-btn" class="swal2-styled swal-otp-resend-button">Resend OTP</button>`;

                            document.getElementById('resend-otp-btn').addEventListener('click', (e) => {
                                e.preventDefault();
                                Swal.close();
                                sendOtp(mobile); // Resend the OTP
                            });
                        }
                    }, 1000);
                },
                preConfirm: () => {
                    const otp = document.getElementById('otp-input').value.trim();
                    if (!otp) {
                        Swal.showValidationMessage('Please enter the OTP.');
                        return false;
                    }
                    return otp;
                }
            }).then((result) => {
                clearInterval(resendTimer);
                if (result.isConfirmed && result.value) {
                    verifyOtp(mobile, result.value);
                }
            });
        }

             function verifyOtp(mobile, otp) {
                    $.ajax({
                        url: '{{ route('verify-otp-new') }}',
                        type: 'POST',
                        data: {
                        mobile: mobile,
                        otp: otp,
                        _token: '{{ csrf_token() }}'
                    },
                        success: function (res) {
                        Swal.fire('Success', res.message, 'success');
                        $('#validateBtn').hide();
                        $('#phone_no').prop('readonly', true);
                        $('.checkOnboarding').show();
                        $('#phone_no_to_save').val(mobile);
                        isOtpVerified = true;
                        verifiedMobile = mobile;
                        clearInterval(resendTimer);
                    },
                        error: function (xhr) {
                        Swal.fire('Error', xhr.responseJSON.message || 'OTP validation failed.', 'error');
                   }
         });
    }

            // Prevent unverified or empty mobile form submission
            $('#your-form-id').on('submit', function (e) {
                let mobile = $('#phone_no').val().trim();

                if (!mobile) {
                    e.preventDefault();
                    Swal.fire('Error', 'Please enter your mobile number.', 'error');
                    return;
                }

                if (!isOtpVerified || verifiedMobile !== mobile) {
                    e.preventDefault();
                    Swal.fire('Error', 'Please verify your mobile number with OTP before submitting.', 'error');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.checkOnboarding').on('click', function() {
                $('#spinner-old').show();
                var phoneNumber = $('#phone_no').val();
                $('#ex-register-button').hide();
                $('#ex-accounts-dropdown-container').hide();
                $('#ex-accounts-radio-container').empty();
                $('#exit').hide();
                if (phoneNumber.length === 10) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('check-phone-ex') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            phone_no: phoneNumber
                        },
                        success: function(response) {
                            var radioHtml = '';
                            if (response.status === 'limit') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Onboarding',
                                    text: response.msg,
                                })
                            } else if (response.status === 'new_register') {
                                $('#ex-register-button').show();
                                $('#ex-accounts-dropdown-container').hide();
                                $('#countMsg').text('');
                                $('#spinner-old').hide();

                                var remainingCount = 4;
                            } else if (response.status === 'accounts_found') {
                                if (response.show_login) {
                                    $('#ex-register-button').show();
                                    $('#spinner-old').hide();
                                } else {
                                    $('#ex-register-button').hide();
                                    $('#spinner-old').hide();
                                }

                                var accountsList = response.accounts;
                                var accountsCount = response.accounts_count;
                                var remainingCount = 4 - accountsCount;
                                console.log(remainingCount);
                                // $('#countMsg').text(
                                //     'Number of new register remaining in this phone no: ' +
                                //     remainingCount);


                                $.each(accountsList, function(index, account) {
                                    radioHtml += '<div class="form-check mt-3">';
                                    radioHtml +=
                                        '<input class="form-check-input" type="radio" name="worker_id" id="worker_id_' +
                                        account.worker_id + '" value="' + account
                                            .worker_id + '"' +
                                        (account.already_registered !== 1 ?
                                            ' disabled' : '') + '>';
                                    radioHtml +=
                                        '&nbsp;&nbsp;<label class="form-check-label" for="worker_id_' +
                                        account.worker_id + '">' + account.ack_no +
                                        '</label>';
                                    radioHtml += '</div>';
                                });


                            }
                            if (remainingCount <= 4 && remainingCount !== 0) {
                                radioHtml += '<div class="form-check mt-3">';
                                radioHtml +=
                                    '<input class="form-check-input" type="radio"  name="worker_id_new" id="new_worker_ext" onchange="newRegistrationSubmit()" value="' +
                                    1
                                        .worker_id + '">';
                                radioHtml +=
                                    '&nbsp;&nbsp;<label class="form-check-label" for="worker_id_new">' +
                                    'New Onboarding' +
                                    '</label>';

                                radioHtml += '</div>';

                            }
                            $('#ex-accounts-radio-container').html(radioHtml);
                            $('#ex-accounts-dropdown-container').show();
                            $('#ex-register-button').hide();
                            $('#exit').hide();

                            const closeButton = document.getElementById('closeModalButton');
                            closeButton.addEventListener('click', () => {
                                $('input[name="worker_id"]:checked').prop('checked',
                                    false);
                            });

                            function closeModal() {
                                $('#accountDetailsModal').modal('hide');
                                $('#spinner-old').hide();
                            }
                            $('#closeModalButton').on('click', function() {
                                closeModal();
                            });

                        }
                    });
                } else {
                    alert('Please enter a valid 10-digit phone number.');
                }
                $(document).on('change', 'input[name="worker_id"]', function() {
                    var workerId = $(this).val();

                    if (workerId) {
                        $('#spinner-old').show();
                        $.ajax({
                            url: "{{ route('account.details_ex') }}",
                            type: 'post',
                            data: {
                                worker_id: workerId,
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                if (response.status === 'payment_pending') {
                                    $('#modalAccountName').text(response.account
                                        .worker_id);
                                    $('#modalAccountPhone').text(response.account
                                        .phone_no);
                                    $('#modalApplicationStatus').text(response
                                        .application_status);
                                    $('#modalApplicationName').text(response.vaultData
                                        .name);
                                    $('#spinner-old').show();
                                    $('#accountDetailsModal').modal('show');
                                    $('#spinner-old').hide();
                                    $('#modalApplicationRemarks').hide();
                                    $('#erase-application-ex').hide();
                                    $('#hiddenContactNo').val(response.account
                                        .phone_no);
                                    $('#hiddenWorkerIdEx').val(response.account
                                        .worker_id);
                                } else if (response.status === 'payment_success') {


                                    $('#modalAccountName').text(response.account
                                        .worker_id);
                                    $('#modalAccountPhone').text(response.account
                                        .phone_no);
                                    $('#modalApplicationName').text(response.vaultData
                                        .name);
                                    $('#modalApplicationStatus').text(response
                                        .application_status);
                                    $('#hiddenWorkerIdEx').val(response.account
                                        .worker_id);
                                    $('#spinner-old').show();
                                    $('#accountDetailsModal').modal('show');
                                    $('#erase-application-ex').hide();
                                    $('#modalApplicationRemarks').hide();
                                    $('#spinner-old').hide();
                                } else if (response.status === 'application_reverted') {
                                    $('#modalAccountName').text(response.account.account
                                        .application_no);
                                    $('#modalAccountPhone').text(response.account
                                        .account.phone_no);
                                    $('#modalApplicationName').text(response.vaultData
                                        .name);
                                    $('#modalApplicationStatus').text(response
                                        .application_status);
                                    $('#modalApplicationRemarks').text(response.account
                                        .app_status);
                                    $('#hiddenWorkerIdEx').val(response.account.account
                                        .worker_id);
                                    $('#hiddenContactNo').val(response.account.account
                                        .phone_no);
                                    $('#spinner-old').show();
                                    $('#erase-application-ex').hide();
                                    $('#accountDetailsModal').modal('show');
                                    $('#spinner-old').hide();
                                } else if (response.status === 'application_pending') {
                                    $('#modalAccountName').text(response.account
                                        .worker_id);
                                    $('#modalAccountPhone').text(response.account
                                        .phone_no);
                                    $('#modalApplicationStatus').text(response
                                        .application_status);
                                    $('#modalApplicationName').text(response.vaultData
                                        .name);
                                    $('#spinner-old').show();
                                    $('#accountDetailsModal').modal('show');
                                    $('#spinner-old').hide();
                                    $('#modalApplicationRemarks').hide();
                                    $('#erase-application-ex').show();
                                    $('#hiddenContactNo').val(response.account
                                        .phone_no);
                                    $('#hiddenWorkerIdEx').val(response.account
                                        .worker_id);
                                } else {
                                    // alert('Account details not found.');
                                    Swal.fire({
                                        title: workerId,
                                        text: 'Failed to Load Data!',
                                        icon: 'warning',
                                        showCancelButton: false,
                                        confirmButtonText: 'Ok',
                                        reverseButtons: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload()
                                        }
                                    });
                                }
                                if (response.application_status === 'Reverted') {
                                    $('#login-otp-ex').hide();
                                    $('#resubmit-app').show();

                                } else {
                                    $('#login-otp-ex').show();
                                    $('#resubmit-app').hide();

                                }

                            }
                        });
                    }
                });
                $('#resubmit-app').on('click', function(e) {
                    e.preventDefault();

                    var workerId = $('#hiddenWorkerIdEx').val();
                    var phone_no = $('#hiddenContactNo').val();
                    console.log(phone_no);


                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to re submit application?.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#28a745",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, Submit!",
                        cancelButtonText: "No, cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('generate-otp') }}',
                                method: 'POST',

                                data: {
                                    mobile: phone_no,
                                    _token: "{{ csrf_token() }}",
                                },

                                beforeSend: function() {
                                    // Show loading state before making the request
                                    Swal.fire({
                                        title: 'Sending OTP...',
                                        text: 'Please wait while we send the OTP to your mobile number.',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal
                                                .showLoading(); // Show loading animation
                                        }
                                    });
                                },

                                success: function(response) {
                                    $('#accountDetailsModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'OTP Sent!',
                                        text: response.message,

                                    }).then(() => {
                                        enterOtpPrompt();
                                    });
                                },

                                error: function(xhr) {
                                    Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: xhr.responseJSON
                                                ?.message ||
                                        'Failed to generate OTP. Please try again.',
                                });
                                }
                            });

                        }
                    });
                });

                function enterOtpPrompt() {
                    const mobileNumber = $('#hiddenContactNo').val();
                    const workerId = $('#hiddenWorkerIdEx').val();
                    let encodedId = btoa(workerId);
                    console.log(mobileNumber);
                    console.log(workerId);

                    Swal.fire({
                        title: 'Enter OTP',
                        input: 'text',
                        inputPlaceholder: 'Enter the 6-digit OTP',
                        inputAttributes: {
                            maxlength: 6,
                            pattern: '[0-9]*',
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Verify OTP',
                        cancelButtonText: 'Cancel',
                        allowOutsideClick: false,
                        inputValidator: (otpInput) => {
                            if (!/^\d{6}$/.test(otpInput)) {
                                return 'Please enter a valid 6-digit OTP.';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const otpInput = result.value;

                            Swal.fire({
                                title: 'Verifying OTP...',
                                text: 'Please wait while we verify your OTP.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            $.ajax({
                                url: '{{ route('verify-otp-new') }}',
                                method: 'POST',

                                data: {
                                    otp: otpInput,
                                    mobile: mobileNumber,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'OTP Verified!',
                                        text: 'Your OTP has been verified successfully.',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Show a loader (fullscreen or inline)
                                        Swal.fire({
                                            title: 'Redirecting...',
                                            text: 'Please wait while we redirect you.',
                                            allowOutsideClick: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                            }
                                        });

                                        // Redirect after short delay to show loader clearly
                                        setTimeout(function () {
                                            window.location.href = "{{ route('login-with-resubmit-ex', ':workerId') }}"
                                                .replace(':workerId', encodedId);
                                        }, 500); // 0.5 second delay
                                    });
                                },

                                error: function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid OTP',
                                        text: 'The OTP entered is incorrect. Please try again.',
                                        confirmButtonText: 'Retry'
                                    }).then(() => {
                                        enterOtpPrompt();
                                    });
                                }
                            });
                        }
                    });
                }




                $('#login-otp-ex').on('click', function(e) {
                    e.preventDefault();
                    var workerId = $('#hiddenWorkerIdEx').val();
                    console.log(workerId);
                    if (workerId) {
                        $.ajax({
                            url: "{{ route('auth-otp-worker-on') }}",
                            type: 'post',
                            data: {
                                temp_worker_id_otp: workerId,
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    alert(response.message);
                                    window.location.href = response.redirect;
                                } else if (response.status === 'pending') {
                                    alert(response.message);
                                    window.location.href = response.redirect;
                                } else if (response.status === 'proceed_to_login') {
                                    window.location.href = response.redirect;
                                } else if (response.status === 'not_registered') {
                                    alert(response.message);
                                }
                            },
                            error: function() {
                                alert('Something went wrong! Please try again later.');
                            }
                        });
                    } else {
                        alert('No account selected. Please select an account to login.');
                    }
                });

                //delete temp-application
                $('#erase-application-ex').on('click', function(e) {
                    e.preventDefault();
                    var workerId = $('#hiddenWorkerIdEx').val();
                    console.log(workerId);
                    if (workerId) {

                        const confirmed = confirm(
                            'Are you sure you want to delete this worker and all related data? This action cannot be undone.'
                        );
                        if (!confirmed) {
                            return; // Exit if user cancels
                        }
                        $.ajax({
                            url: "{{ route('delete-worker-data-ex') }}",
                            type: 'post',
                            data: {
                                temp_worker_id: workerId,
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                console.log(response);
                                if (response.status === 'success') {
                                    alert(response.message);
                                    window.location.href = response.redirect;
                                } else {
                                    alert(response.message || 'Deletion failed.');
                                }
                            },
                            error: function() {
                                alert('Something went wrong! Please try again later.');
                            }
                        });
                    } else {
                        alert('No account selected. Please select an account to login.');
                    }
                });


            });

        });



        function newRegistrationSubmit() {
            $("#new-registration-form").submit();
        }
    </script>


    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>


    {{--    @if (session()->has('worker_id')) --}}
    {{--        <script> --}}
    {{--            Swal.fire({ --}}
    {{--                title: 'Worker Registered Successfully', --}}
    {{--                text: 'Note Down Your Temporary ID: {{ session('worker_id') }}', --}}
    {{--                icon: 'success', --}}
    {{--                confirmButtonText: 'OK' --}}
    {{--            }).then((result) => { --}}
    {{--                if (result.isConfirmed) { --}}
    {{--                    window.location.href = '{{ route('main-page') }}'; --}}
    {{--                } --}}
    {{--            }); --}}
    {{--        </script> --}}
    {{--    @endif --}}

    <script>
        var token = "{{ csrf_token() }}";
    </script>

@endsection