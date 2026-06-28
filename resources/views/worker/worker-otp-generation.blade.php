@extends('layouts.user-app')

@section('title', 'Worker')

@section('style')
@endsection
@section('content')
    <div class="container d-flex justify-content-center p-2 align-items-center" style="min-height: 50vh;">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 600px;">
            <h3 class="text-center mb-4">Verify Contact Number</h3>
            <form id="otpForm">
                <div class="mb-3">
                    <label for="mobileNumber" class="form-label">Contact Number</label>
                    <input type="hidden" value="{{$worker_id}}" id="hiddenWorkerId">
                    <input
                        type="tel"
                        id="mobileNumber"
                        class="form-control"
                        name="mobile"
                        value="{{$phone_no}}"
                        placeholder="Enter your mobile number"
                        pattern="[0-9]{10}"
                        required
                    readonly>

                </div>
                <button type="button" id="generateOtpButton" class="btn btn-warning btn-sm">Generate OTP <i class="fa fa-refresh" aria-hidden="true"></i></button>
            </form>
{{--            <div id="otpMessage" class="mt-3 text-success" style="display: none;">OTP has been sent to your mobile number!</div>--}}
{{--            <div id="otpSection" class="mt-3" style="display: none;">--}}
{{--                <div class="mb-3">--}}
{{--                    <label for="otpInput" class="form-label">Enter OTP</label>--}}
{{--                    <input type="text" id="otpInput" class="form-control" placeholder="Enter the 6-digit OTP" maxlength="6">--}}
{{--                </div>--}}
{{--                <button id="verifyOtpButton" class="btn btn-success w-100">Verify OTP <i class="fa fa-check-circle" aria-hidden="true"></i></button>--}}

{{--            </div>--}}
            <div class="justify-content-center">
                <button class="btn btn-warning w-40 mt-1" id="login-with-tempId" style="display: none;">Login <i class="fa fa-sign-in"></i></button>
            </div>
        </div>
    </div>


@endsection
@if (Route::is('account.details'))
    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
@endif

@section('footer')
    <script>
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('#generateOtpButton').click(function () {
            const mobileNumber = $('#mobileNumber').val();

            if (/^[0-9]{10}$/.test(mobileNumber)) {
                Swal.fire({
                    title: 'Sending OTP...',
                    text: 'Please wait while we generate your OTP.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '{{route('generate-otp')}}',
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    data: { mobile: mobileNumber },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Sent!',
                            text: response.message,
                            confirmButtonText: 'Enter OTP'
                        }).then(() => {
                            enterOtpPrompt(); // Prompt OTP input in Swal
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message || 'Failed to generate OTP. Please try again.',
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Number',
                    text: 'Please enter a valid 10-digit mobile number.'
                });
            }
        });

        function enterOtpPrompt() {
            const mobileNumber = $('#mobileNumber').val();

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
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        data: { otp: otpInput, mobile: mobileNumber },
                        success: function () {
                            Swal.fire({
                                icon: 'success',
                                title: 'OTP Verified!',
                                text: 'Your OTP has been verified successfully.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                $('#otpSection').hide();
                                $('#generateOtpButton').hide();
                                $('#login-with-tempId').show();
                                $('#verifyOtpButton').hide();
                                $('#otpMessage').text('');
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

        $('#login-with-tempId').on('click', function(e) {
            e.preventDefault();
            var workerId = $('#hiddenWorkerId').val();

            if (workerId) {
                Swal.fire({
                    title: 'Logging in...',
                    text: 'Please wait while we log you in.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('login-with-temp-id') }}",
                    type: 'post',
                    data: {
                        temp_worker_id: workerId,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.status === 'success' || response.status === 'pending' || response.status === 'proceed_to_login') {
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: 'Login Successful',
                            //     text: response.message,
                            //     confirmButtonText: 'OK'
                            // }).then(() => {
                                window.location.href = response.redirect;
                            // });
                        } else if (response.status === 'not_registered') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Not Registered',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong! Please try again later.'
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Account Selected',
                    text: 'Please select an account to login.'
                });
            }
        });


    </script>


    <script>
        var token = "{{ csrf_token() }}";
    </script>

@endsection
