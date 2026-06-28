@extends('layouts.user-app')

@section('title', 'Worker')

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



        .checkAccount {
            background-color: var(--warning-color);
            border-radius: 0px !important;
            color: white;
        }

        .checkAccount:hover {
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

            font-family: "Roboto", sans-serif;

        }


        label.bold {
            font-weight: 600;
            font-family: "Roboto", sans-serif;
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
                            <span class="fw-normal">(New Registration)</span>
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
                                    $isReadonly = !empty($pfc_data);
                                     $mobileValue = $isReadonly ? $pfc_data->mobile : '';
                                @endphp

                                <div class="input-group" style="height: 45px;"> <!-- Set fixed height for the entire group -->
                                    <span class="input-group-text h-100"> <!-- h-100 makes it take full height of parent -->
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
                                    value="{{ $mobileValue }}"
                                    {{ $isReadonly ? 'readonly' : '' }}>

                                    <button class="btn btn-sm btn-lightgrey validate" type="button" title="Validate Number">
                                        <i class="fas fa-check-circle"></i> Validate
                                    </button>

                                    <button class="btn btn-sm btn-warning checkAccount" type="button" title="Check Record" style="display: none;">
                                        <i class="fas fa-search"></i> Check Record
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
                            <div class="accounts-container hidden" id="accounts-dropdown-container">
                                <label class="form-label fw-semibold mb-3">Select Your Application:</label>
                                <div id="accounts-radio-container" class="worker_id"></div>
                            </div>

                            <!-- Count Message -->
                            <div class="alert alert-info py-2 mb-0" id="countMsg" style="display: none;"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Account Details Modal -->
    <div class="modal fade" id="accountDetailsModal" tabindex="-1" aria-labelledby="accountDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Application Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6 account-detail-item">
                                <p class="mb-1"><span class="account-detail-label">Application No:</span>
                                    <span id="modalAccountName" class="account-detail-value"></span>
                                </p>
                            </div>
                            <div class="col-md-6 account-detail-item">
                                <p class="mb-1"><span class="account-detail-label">Applicant Name:</span>
                                    <span id="modalApplicationName" class="account-detail-value"></span>
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 account-detail-item">
                                <p class="mb-1"><span class="account-detail-label">Contact No:</span>
                                    <span id="modalAccountPhone" class="account-detail-value"></span>
                                </p>
                                <input type="hidden" id="hiddenContactNo">
                            </div>
                            <div class="col-md-6 account-detail-item">
                                <p class="mb-1"><span class="account-detail-label">Application Status:</span>
                                    <span id="modalApplicationStatus" class="badge badge-status bg-warning text-dark"></span>
                                </p>
                            </div>
                        </div>
                        <input type="hidden" id="hiddenWorkerId">
                        <div class="row mb-3">
                            <div class="col-12 account-detail-item">
                                <p class="mb-1"><span class="account-detail-label">Remarks:</span>
                                    <span id="modalApplicationRemarks" class="text-danger"></span>
                                </p>
                            </div>
                        </div>

                        <!-- OTP Form (hidden by default) -->
                        <div class="hidden" id="otp_form">
                            <div class="form-group otp">
                                <label for="phone_no" class="form-label fw-semibold">Please Enter OTP</label>
                                <div class="otp-input-container">
                                    <input type="number" id="otp_1" class="otp-input" maxlength="1" autocomplete="off" />
                                    <input type="number" id="otp_2" class="otp-input" maxlength="1" autocomplete="off" disabled />
                                    <input type="number" id="otp_3" class="otp-input" maxlength="1" autocomplete="off" disabled />
                                    <input type="number" id="otp_4" class="otp-input" maxlength="1" autocomplete="off" disabled />
                                    <input type="number" id="otp_5" class="otp-input" maxlength="1" autocomplete="off" disabled />
                                    <input type="number" id="otp_6" class="otp-input" maxlength="1" autocomplete="off" disabled />
                                </div>

                                <div class="d-flex justify-content-center py-3">
                                    <button type="button" id="verify_otp" class="btn btn-primary btn-action">
                                        <i class="fas fa-sign-in-alt me-1"></i> Verify OTP
                                    </button>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <p id="resend_timer" class="timer-text">
                                        Resend OTP in <span id="timer_1" class="text-success fw-bold">180</span> Seconds
                                    </p>
                                    <button type="button" id="resend_otp" class="btn btn-link hidden" disabled>
                                        Resend OTP
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-action" id="closeModalButton" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                    <a href="#" class="btn btn-danger btn-action hidden" id="erase-application">
                        <i class="fas fa-trash-alt me-1"></i> Delete Application
                    </a>
                    <a href="#" class="btn btn-success btn-action hidden" id="login-otp">
                        <i class="fas fa-sign-in-alt me-1"></i> Login through OTP
                    </a>
                    <a href="#" class="btn btn-success btn-action hidden" id="resubmit-app">
                        <i class="fas fa-redo me-1"></i> Re-Submit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Form for New Registration -->
    <form id="new-registration-form" action="{{ route('save-phone-no') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="phone_no" id="phone_no_to_save" value="{{ $mobileValue }}">
    </form>

@endsection

@if (Route::is('account.details'))
    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
@endif

@section('footer')
    {{--<script>--}}
        {{--$(document).ready(function () {--}}
            {{--let isOtpVerified = false;--}}
            {{--let verifiedMobile = '';--}}
            {{--let resendTimer;--}}
            {{--$('#phone_no').on('blur', function () {--}}
                {{--var phone = $(this).val();--}}

                {{--if (/^\d{10}$/.test(phone)) {--}}
                    {{--$('#phone-loader').show();--}}

                    {{--$.ajax({--}}
                        {{--url: 'check-phone-count',--}}
                        {{--type: 'GET',--}}
                        {{--data: { phone: phone },--}}
                        {{--success: function (response) {--}}
                            {{--if (response.count >= 4) {--}}
                                {{--$('.validate').hide();--}}
                                {{--$('.checkAccount').show();--}}
                            {{--} else {--}}
                                {{--$('.validate').show();--}}
                                {{--$('.checkAccount').hide();--}}
                            {{--}--}}
                        {{--},--}}
                        {{--error: function () {--}}
                            {{--console.log('Error checking phone count');--}}
                        {{--},--}}
                        {{--complete: function () {--}}
                            {{--$('#phone-loader').hide();--}}
                        {{--}--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}




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
                        url: '{{ 'check-phone-count' }}',
                        type: 'GET',
                        data: { phone: phone },
                        success: function (response) {
                            // This success callback can be used to display messages
                            // but should not alter the primary buttons.
                            if (response.count >= 4) {
                                $('#countMsg').text('This number has reached the maximum number of registrations.').show();
                                $('.validate').hide();
                                $('.checkAccount').show();

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

            $('.validate').on('click', function () {
                let mobile = $('#phone_no').val().trim();

                if (!/^\d{10}$/.test(mobile)) {
                    Swal.fire('Error', 'Please enter a valid 10-digit mobile number.', 'error');
                    return;
                }

                $('#spinner-old').show();

                // First, check if the phone number has existing records.
                $.ajax({
                    type: 'POST',
                    url: "{{ 'check-phone' }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        phone_no: mobile
                    },
                    success: function(response) {
                        $('#spinner-old').hide();
                        if (response.status === 'accounts_found' || response.status === 'limit') {
                            // If accounts are found, hide validate and show check record
                            $('.validate').hide();
                            $('#phone_no').prop('readonly', true);
                            $('#phone_no_to_save').val(mobile);
                            $('.checkAccount').click();
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
                    url: '{{route('generate-otp-new')}}',
                    type: 'POST',
                    data: {
                        mobile: mobile,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function () {
                        $('#spinner-old').hide();
                        startCountdownModal(mobile);
                    },
                    error: function (xhr) {
                        $('#spinner-old').hide();
                        Swal.fire('Error', xhr.responseJSON.message || 'Failed to send OTP.', 'error');
                    }
                });
            }

            function startCountdownModal(mobile) {
                let timeLeft = 120;

                Swal.fire({
                    title: 'Enter OTP',
                    html: `<p>An OTP has been sent to your mobile.</p>
                       <input id="otp-input" class="swal2-input" maxlength="6" placeholder="Enter 6-digit OTP">
                       <p id="timer-text">You can resend OTP in <b>${timeLeft}</b> seconds.</p>`,
                    showCancelButton: true,
                    showConfirmButton: true,
                    confirmButtonText: 'Submit OTP',
                    didOpen: () => {
                        const timerEl = Swal.getHtmlContainer().querySelector('#timer-text b');

                        resendTimer = setInterval(() => {
                            timeLeft--;
                            timerEl.textContent = timeLeft;
                            if (timeLeft <= 0) {
                                clearInterval(resendTimer);
                                Swal.update({
                                    html: `<p>An OTP has been sent to your mobile.</p>
                                       <input id="otp-input" class="swal2-input" maxlength="6" placeholder="Enter 6-digit OTP">
                                       <p><button id="resend-otp-btn" class="swal2-styled">Resend OTP</button></p>`
                                });

                                document.getElementById('resend-otp-btn').addEventListener('click', () => {
                                    Swal.close();
                                    sendOtp(mobile);
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
                    if (result.isConfirmed && result.value) {
                        verifyOtp(mobile, result.value);
                    }
                });
            }

            function verifyOtp(mobile, otp) {
                $.ajax({
                    url: '{{route('verify-otp-new')}}',
                    type: 'POST',
                    data: {
                        mobile: mobile,
                        otp: otp,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        Swal.fire('Success', res.message, 'success');
                        $('.validate').hide();
                        $('#phone_no').prop('readonly', true);
                        $('#phone_no_to_save').val(mobile);
                        $('.checkAccount').show();
                        isOtpVerified = true;
                        verifiedMobile = mobile;
                    },
                    error: function (xhr) {
                        Swal.fire('Error', xhr.responseJSON.message || 'OTP validation failed.', 'error');
                    }
                });
            }

            // Form submission check
            $('#your-form-id').on('submit', function (e) {
                let mobile = $('#phone_no').val().trim();

                if (!mobile) {
                    e.preventDefault();
                    Swal.fire('Error', 'Mobile number is required.', 'error');
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
            $('.checkAccount').on('click', function() {
                $('#spinner-old').show();
                var phoneNumber = $('#phone_no').val();

                $('#register-button').hide();
                $('#accounts-dropdown-container').hide();
                $('#accounts-radio-container').empty();

                if (phoneNumber.length === 10) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('check.phone') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            phone_no: phoneNumber
                        },
                        success: function(response) {
                            var radioHtml = '';

                            if (response.status === 'limit') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'New Register',
                                    text: response.msg,
                                })
                            } else if (response.status === 'new_register') {
                                $('#register-button').show();
                                $('#accounts-dropdown-container').hide();
                                $('#countMsg').text('');
                                $('#spinner-old').hide();
                                var remainingCount = 4;
                            } else if (response.status === 'accounts_found') {
                                if (response.show_login) {
                                    $('#register-button').show();
                                    $('#spinner-old').hide();
                                } else {
                                    $('#register-button').hide();
                                    $('#spinner-old').hide();
                                }

                                var accountsList = response.accounts;
                                var accountsCount = response.accounts_count;
                                var remainingCount = 4 - accountsCount;
                                console.log(remainingCount)
                                $.each(accountsList, function(index, account) {
                                    radioHtml += '<div class="form-check mt-3">';
                                    radioHtml +=
                                        '<input class="form-check-input" type="radio" name="worker_id" id="worker_id_' +
                                        account.worker_id + '" value="' + account
                                        .worker_id + '"' +
                                        (account.already_registered === 1 ?
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
                                    'New Registration' +
                                    '</label>';

                                radioHtml += '</div>';
                            }
                            $('#accounts-radio-container').html(radioHtml);
                            $('#accounts-dropdown-container').show();

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
                    alert('Please enter a valid 10-digits phone number.');
                }
            });
            var workerId = '';
            $(document).on('change', 'input[name="worker_id"]', function() {

                var workerId = $(this).val();
                console.log(workerId);
                if(workerId ){
                    $('#spinner-old').show();
                    $.ajax({
                        url: "{{ route('account.details') }}",
                        type: 'post',
                        data: {
                            worker_id: workerId,
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.status === 'payment_pending') {
                                $('#modalAccountName').text(response.account.worker_id);
                                $('#modalAccountPhone').text(response.account.phone_no);
                                $('#modalApplicationStatus').text(response.application_status);
                                $('#modalApplicationName').text(response.vaultData.name);
                                $('#spinner-old').show();
                                $('#accountDetailsModal').modal('show');
                                $('#spinner-old').hide();
                                $('#modalApplicationRemarks').hide();
                                $('#erase-application').hide();
                                $('#hiddenWorkerId').val(response.account.worker_id);
                                $('#hiddenContactNo').val(response.account.phone_no);
                            } else if (response.status === 'payment_success') {
                                $('#modalAccountName').text(response.account.application_no);
                                $('#modalAccountPhone').text(response.account.phone_no);
                                $('#modalApplicationName').text(response.vaultData.name);
                                $('#modalApplicationStatus').text(response.application_status);
                                $('#hiddenWorkerId').val(response.account.worker_id);
                                $('#hiddenContactNo').val(response.account.phone_no);
                                $('#spinner-old').show();
                                $('#accountDetailsModal').modal('show');
                                $('#modalApplicationRemarks').hide();
                                $('#erase-application').hide();
                                $('#spinner-old').hide();
                            } else if (response.status === 'application_reverted') {
                                $('#modalAccountName').text(response.account.account.application_no);
                                $('#modalAccountPhone').text(response.account.account.phone_no);
                                $('#modalApplicationName').text(response.vaultData.name);
                                $('#modalApplicationStatus').text(response.application_status);
                                $('#modalApplicationRemarks').text(response.message);
                                $('#hiddenWorkerId').val(response.account.account.worker_id);
                                $('#hiddenContactNo').val(response.account.account.phone_no);
                                $('#spinner-old').show();
                                $('#accountDetailsModal').modal('show');
                                $('#erase-application').hide();
                                $('#spinner-old').hide();
                            }
                            else if(response.status === 'application_pending')
                                {
                                    $('#modalAccountName').text(response.account.worker_id);
                                $('#modalAccountPhone').text(response.account.phone_no);
                                $('#modalApplicationStatus').text(response.application_status);
                                $('#modalApplicationName').text(response.vaultData.name);
                                $('#spinner-old').show();
                                $('#accountDetailsModal').modal('show');
                                $('#spinner-old').hide();
                                $('#modalApplicationRemarks').hide();
                                $('#erase-application').show();
                                $('#hiddenWorkerId').val(response.account.worker_id);
                                $('#hiddenContactNo').val(response.account.phone_no);
                                }



                            else {
                                // alert('Account details not found.');
                                Swal.fire({
                                    title: workerId,
                                    text: 'Failed to Load Aadhar Data!',
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
                            if(response.application_status === 'Reverted')
                            {
                                $('#login-otp').hide();
                                $('#resubmit-app').show();
                                $('#reregister-app').show();
                            }else{
                                $('#login-otp').show();
                                $('#resubmit-app').hide();
                                $('#reregister-app').hide();
                            }
                        }
                    });
                }
            });

            $('#resubmit-app').on('click', function(e) {
                e.preventDefault();

                const workerId = $('#hiddenWorkerId').val();
                const phone_no = $('#hiddenContactNo').val();

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to re-submit the application?",
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
                            beforeSend: function () {
                                Swal.fire({
                                    title: 'Sending OTP...',
                                    text: 'Please wait while we send the OTP to your mobile number.',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success: function (response) {
                                $('#accountDetailsModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'OTP Sent!',
                                    text: response.message,
                                }).then(() => {
                                    enterOtpPrompt(); // You can also validate phone_no here
                                });
                            },
                            error: function (xhr) {
                                const errorMsg = xhr.responseJSON?.message || 'Failed to generate OTP. Please try again.';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: errorMsg,
                                });
                            }
                        });
                    }
                });
            });



            function enterOtpPrompt() {
                const mobileNumber = $('#hiddenContactNo').val();
                const workerId = $('#hiddenWorkerId').val();
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
                            url: '{{route('verify-otp-new')}}',
                            method: 'POST',

                            data: { otp: otpInput, mobile: mobileNumber,
                                _token: "{{ csrf_token() }}"},
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
                                        window.location.href = "{{ route('login-with-resubmit', ':workerId') }}"
                                            .replace(':workerId', encodedId);
                                    }, 500); // 0.5 second delay
                                });
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Invalid OTP',
                                    text: 'The OTP entered is incorrect. Please try again.',
                                    confirmButtonText: 'Retry'
                                }).then(() => {
                                    enterOtpPrompt(); // If incorrect, prompt OTP input again
                                });
                            }
                        });
                    }
                });
            }




            $('#login-otp').on('click', function(e) {
                e.preventDefault();
                var workerId = $('#hiddenWorkerId').val();
                console.log(workerId);
                if (workerId) {
                    $.ajax({
                        url: "{{ route('auth-otp-worker') }}",
                        type: 'post',
                        data: {
                            temp_worker_id_otp: workerId,
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            console.log(response)
                            if (response.status === 'success') {
                                alert(response.message);
                                window.location.href = response.redirect;
                            } else if (response.status === 'pending') {
                                // alert(response.message);
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
                    $('#erase-application').on('click', function(e) {
                e.preventDefault();
                var workerId = $('#hiddenWorkerId').val();
                console.log(workerId);
                if (workerId) {

                    const confirmed = confirm('Are you sure you want to delete this worker and all related data? This action cannot be undone.');
                    if (!confirmed) {
                                    return; // Exit if user cancels
                                }
                    $.ajax({
                        url: "{{ route('delete-worker-data') }}",
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
