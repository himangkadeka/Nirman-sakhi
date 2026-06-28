@extends('layouts.user-app')

@section('title', 'Nominee / legal registration')

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

        .modal-content {
            border: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
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

        label {
            font-weight: 500;
        }

        .input-group .form-control {
            border-right: 0;
        }

        .input-group-append .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #495057;
        }

        .card-header {
            border-radius: 12px 12px 0 0;
        }
    </style>
@endsection

@section('content')
    <div class="container mb-5 mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #2badee;">
                        <i class="fa fa-plus-circle"></i> &nbsp; Nominee / Legal Registration Form
                    </div>
                    <div class="card-body">
                        <form class="form-group" id="" action="#" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="id_no">Enter ID card number <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2">
                                    <input type="text" class="form-control @error('id_no') is-invalid @enderror"
                                        id="id_no" value="ABOCWWB/26/2025/1/19259474" name="id_no" placeholder=""
                                        style="width: 80%;">
                                    <button class="btn btn-outline-primary btn-sm px-1 py-0 mx-2 validate" type="button"
                                        style="font-size: 1rem;">
                                        <i class="fas fa-check-circle"></i> Validate
                                    </button>

                                </div>
                                <div id="id-error" class="text-danger mt-1" style="display: none;"></div>
                                <div id="id-loader" style="display: none;" class="mt-2">
                                    <span class="spinner-border spinner-border-sm text-primary"></span>
                                    <span>Checking...</span>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>

                <div id="nominee-section" class="card mt-4" style="display: none;">
                    <div class="card-body">
                        <h5>Worker Details</h5>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Name of Worker</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="worker_name"
                                    placeholder="Enter name of the worker" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Worker Phone Number</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="worker_phone"
                                    placeholder="Enter worker phone number" maxlength="10" pattern="\d*"
                                    inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'')" readonly>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Select Nominee</label>
                            <div class="col-sm-6">
                                <select id="nominee-type" class="form-select w-50">
                                    <option selected disabled>Select Nominee</option>
                                </select>
                            </div>
                        </div>



                    </div>
                </div>

                <div id="nominee-details" class="card mt-4" style="display: none;">
                    <div class="card-body">
                        <div class="section-title">Nominee Details</div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Nominee Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nominee_name"
                                    placeholder="Enter nominee name" readonly>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Nominee Phone Number</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nominee_phone"
                                    placeholder="Enter nominee phone number" maxlength="10" pattern="\d*"
                                    inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'')">



                            </div>
                            {{-- <div class="col-sm-3 d-flex align-items-center">
                                <button type="button" class="btn btn-primary w-100 rounded-pill shadow-sm"
                                    id="copyPhoneBtn">
                                    <i class="fas fa-copy me-2"></i> Copy Contact Number
                                </button>
                            </div> --}}



                        </div>


                        <div class="mb-3">
                            <label>Citizen Aadhaar Consent <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="y" id="aadhar_consent"
                                    name="aadhar_consent" required>
                                <label class="form-check-label" for="aadhar_consent" id="terms_label">
                                    {{ trans('worker-registration/worker_new_registration.agree') }}
                                    <span class="text-danger hover-trigger"
                                        id="terms">{{ trans('worker-registration/worker_new_registration.terms') }}</span>
                                    {{ trans('worker-registration/worker_new_registration.and') }}
                                    <span class="text-danger hover-trigger"
                                        id="conditions">{{ trans('worker-registration/worker_new_registration.conditions') }}</span>
                                    {{ trans('worker-registration/worker_new_registration.uidai') }}
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-sm-3 col-form-label">Aadhaar Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="aadhaar_number"
                                    placeholder="Enter Aadhaar number" maxlength="12" pattern="\d*" inputmode="numeric"
                                    oninput="this.value=this.value.replace(/\D/g,'')">

                                {{-- <input type="number" class="form-control" inputmode="numeric" id="aadhaar_number"
                                    placeholder="Enter Aadhaar number"> --}}
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" id="aadhaar-validate">
                                        <i class="fas fa-check-circle"></i> Validate
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="aadhaar-otp-section" style="display: none;">
                            <div class="mb-3">
                                <label class="col-sm-3 col-form-label enterotplabel">Enter OTP</label>
                                <input type="text" class="form-control" id="aadhaar_otp"
                                    placeholder="Enter 6-digit OTP" pattern="\d*" inputmode="numeric"
                                    oninput="this.value=this.value.replace(/\D/g,'')">

                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-primary" id="verify-otp">Verify OTP</button>
                                <button type="submit" class="btn btn-success" id="submit-form"
                                    style="display: none">Submit Form</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OTP Verified Modal -->
                <div class="modal fade" id="otpVerifiedModal" tabindex="-1" aria-labelledby="otpVerifiedModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-center p-4" style="border-radius: 10px;">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <img src="https://img.icons8.com/color/96/000000/ok--v1.png" alt="Success"
                                        width="80">
                                </div>
                                <h4 class="fw-bold mb-2">Success</h4>
                                <p class="text-muted">OTP verified successfully!</p>
                                <button type="button" class="btn btn-primary px-4 rounded-pill mt-3"
                                    data-bs-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Submission Modal -->
                <div class="modal fade" id="formSubmittedModal" tabindex="-1" aria-labelledby="formSubmittedModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-center p-4" style="border-radius: 10px;">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <img src="https://img.icons8.com/color/96/000000/ok--v1.png" alt="Success"
                                        width="80">
                                </div>
                                <h4 class="fw-bold mb-2">Success</h4>
                                <p class="text-muted">Form submitted successfully!</p>
                                <button type="button" class="btn btn-primary px-4 rounded-pill mt-3"
                                    data-bs-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.aadhar-consent')
@endsection

@section('footer')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ asset('assets/template/js/toastify-js.js') }}"></script>
    <script>
        $(document).ready(function() {

            function showToast(message, type = 'info') {
                let bgColor = '#007bff'; // default blue
                if (type === 'error') bgColor = '#dc3545';
                else if (type === 'success') bgColor = '#28a745';
                else if (type === 'warning') bgColor = '#ffc107';

                Toastify({
                    text: message,
                    duration: 5000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: bgColor,
                    stopOnFocus: true
                }).showToast();
            }
            $('.validate').on('click', function() {
                let idNo = $('#id_no').val().trim();

                $('#id_no').removeClass('is-invalid');
                $('#id-error').hide().text('');

                const idPattern = /^[a-zA-Z0-9\/]{6,40}$/;

                if (idNo === '' || !idPattern.test(idNo)) {
                    $('#id_no').addClass('is-invalid');
                    $('#id-error').text('Please enter a valid ID card number.').show();
                    return;
                }

                $.ajax({
                    url: "{{ route('check-id-card') }}",
                    method: 'POST',
                    data: {
                        id_card: idNo,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $('#id_no').prop('disabled', true);
                            $('#id-loader').show();
                            setTimeout(() => {
                                $('#id-loader').hide();
                                $("#worker_name").val(response.results.getVaultData
                                    .name);
                                $("#worker_phone").val(response.results.mainWorkerData
                                    .phone_no)
                                $("#nominee_phone").val(response.results.mainWorkerData
                                    .phone_no)
                                var select = document.getElementById('nominee-type');
                                response.results.families.forEach(function(nominee) {
                                    var option = document.createElement(
                                        'option');
                                    option.value = nominee.id;
                                    option.text = nominee.first_name + ' ' +
                                        nominee.last_name;
                                    select.appendChild(option);
                                });

                                $('#nominee-section').slideDown();
                            }, 800);
                        } else {
                            $('#id_no').addClass('is-invalid');
                            $('#id-error').text(response.results).show();
                            return;
                        }
                    },


                });


            });


            $('#nominee-type').on('change', function() {
                if ($(this).val()) {
                    var selectedText = $(this).find("option:selected").text();
                    $("#nominee_name").val(selectedText);
                    $('#nominee-details').slideDown();
                } else {
                    $('#nominee-details').hide();
                }
            });

            $('#aadhaar-validate').on('click', function() {
                const aadhaar = $('#aadhaar_number').val().trim();
                if (!/^\d{12}$/.test(aadhaar)) {
                    showToast('Please enter a valid 12-digit Aadhaar number', 'error');
                    return;
                }
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
                            setTimeout(function() {
                                $('#spinner').hide();
                                $('#buttonText').text('OTP Sent');
                                showToast(
                                    'OTP has been sent to your registered mobile number' +
                                    mobile, 'success');
                                $('#aadhaar-otp-section').slideDown();
                                $('#otpSection').slideDown();
                                $('#verifyButton').prop('disabled', true);
                            }, 2000);
                            // startOtpTimer();
                        } else if (response.errorCode === '565') {
                            // Hide OTP input field if status is not 0
                            showToast('License key has expired ', 'error');

                            $('#otpExVerification').hide();
                        } else {
                            // Hide OTP input field if status is not 0
                            toastr.error('Failed To Generate OTP,please try again!', 'error');
                            $('#otpVerification').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#spinner').hide();
                        $('#verifyButton').prop('disabled', false);
                        console.error('Error:', error);

                        if (xhr.status >= 500) {
                            console.error(
                                'Server Error: An error occurred on the server, please try again later.'
                            );
                        } else {
                            console.error('Request Error:', error);
                        }
                    },
                    complete: function() {
                        // Restore button text and hide the spinner
                        // $button.prop('disabled', false);
                        // $buttonText.text('Generate OTP');
                        // $spinner.hide();
                    }
                });

            });

            $('#verify-otp').on('click', function() {
                const otp = $('#aadhaar_otp').val().trim();
                const consent = 'y';
                if (!/^\d{6}$/.test(otp)) {
                    showToast('Please enter a valid 6-digit OTP', 'error');
                    return;
                }

                $.ajax({
                    url: "{{ route('otp-verification') }}",
                    method: 'POST',
                    data: {
                        dynamicPin: otp,
                        consent: consent,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        // Show the loader
                        $('#spinner-old-auth').show();
                        // Disable the button
                        $('#submitOTP').prop('disabled', true);
                    },

                    success: function(response) {
                        // Hide the loader
                        $('#spinner-old-auth').hide();
                        // Re-enable the button
                        $('#submitOTP').prop('disabled', true);

                        if (response.errorCode === '000') {
                            setTimeout(function() {
                                $('#aadhaar-validate').closest('.input-group-append')
                                    .hide();
                                $('#aadhaar_otp').hide();
                                $('#verify-otp').hide();
                                $('.enterotplabel').hide();
                                $('#aadhaar_number').prop('disabled', true);
                                new bootstrap.Modal(document.getElementById(
                                    'otpVerifiedModal')).show();
                                $("#submit-form").show();
                                $('#finalSubmitSection').slideDown();
                            }, 2000);
                            $('#otpVerification').hide();
                            $('#register-btn-worker').show();
                            $('.captcha').show();
                            $('.captcha-submit').show();
                        } else {
                            toastr.error('Aadhaar eKyc Failed!');
                            $('#submitOTP').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        // Hide the loader
                        $('#spinner-old-auth').hide();
                        // Re-enable the button
                        $('#submitOTP').prop('disabled', false);

                        if (xhr.status >= 500) {
                            toastr.error('Server error, please try again later.');
                        } else {
                            toastr.error('An error occurred, please try again.');
                        }
                    }
                });



            });



            $('.btn-success[type="submit"]').on('click', function(e) {
                e.preventDefault();
                new bootstrap.Modal(document.getElementById('formSubmittedModal')).show();
            });

            $('#copyPhoneBtn').on('click', function() {
                const workerPhone = $('#worker_phone').val();
                $('#nominee_phone').val(workerPhone);
            });
        });

        document.getElementById('aadhar_consent').addEventListener('click', function(event) {
            if (this.checked) {
                $('#termsModal').modal('show');
                this.checked = false;
            } else {
                document.getElementById('uid').disabled = true;
            }
        });

        document.getElementById('understand').addEventListener('click', function() {
            document.getElementById('aadhar_consent').checked = true;
            document.getElementById('uid').disabled = false;
        });
    </script>

    <script>
        document.getElementById('aadhar_consent').addEventListener('click', function(event) {
            if (this.checked) {
                $('#termsModal').modal('show');
                this.checked = false;
            } else {
                document.getElementById('uid').disabled = true;
            }
        });

        document.getElementById('understand').addEventListener('click', function() {
            document.getElementById('aadhar_consent').checked = true;
            document.getElementById('uid').disabled = false;
        });
    </script>

    <script>
        // Copy phone number from worker to nominee
        document.getElementById('copyPhoneBtn').addEventListener('click', function() {
            const workerPhone = document.getElementById('worker_phone').value;
            document.getElementById('nominee_phone').value = workerPhone;
        });
    </script>

@endsection
