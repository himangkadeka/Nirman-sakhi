@extends('layouts.user-app')

@section('title', ' Existing Worker')

@section('style')
    <style>
        .otp-inputs {
            display: flex;
            justify-content: space-between;
            width: 220px;
            margin-bottom: 20px;
        }

        .otp-input {
            width: 30px;
            height: 40px;
            text-align: center;
            font-size: 20px;
            margin-right: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s, background-color 0.3s;
        }

        .otp-input:focus {
            border-color: #007bff;
            background-color: #e7f0fe;
            outline: none;
        }

        .otp-input:last-child {
            margin-right: 0;
        }
        .otp-box {
            width: 45px;
            height: 45px;
            font-size: 18px;
            font-weight: 600;
        }

        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Roboto", sans-serif;

        }


        label.bold {
            font-weight: 600;
            font-family: "Roboto", sans-serif;

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
            overflow-y: auto;
        }
    </style>
@endsection


@section('content')
    @include('components.aadhar-consent')
    <div class="container mb-4 mt-2">
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                    style="background-color: #2badee;">
                                    <span>
                                        <i class="fa fa-plus-circle"
                                            aria-hidden="true"></i>&nbsp;{{ trans('worker-registration/worker-existing-registration.headline') }}
                                    </span>
                                </div>

                                {{--                                <div class="newregex" style="display: none;"> --}}
                                <form action="{{ route('save-existing-reg') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="container-fluid">
                                        <div class="row align-items-stretch">

                                            <!-- LEFT COLUMN -->
                                            <div class="col-lg-6 d-flex flex-column">

                                                <!-- Office Details -->
                                                <div class="card shadow-sm mb-4 flex-fill">
                                                    <div class="card-header bg-light">
                                                        <h5 class="mb-0 font-weight-bold">
                                                            <i class="fa fa-building mr-2 text-primary"></i>
                                                            Office Details
                                                        </h5>
                                                    </div>

                                                    <div class="card-body">

                                                        <!-- District -->
                                                        <div class="form-group">
                                                            <label class="font-weight-semibold">
                                                                {{ trans('worker-registration/worker-existing-registration.district') }}
                                                                <span class="text-danger">*</span>
                                                                ({{ trans('worker-registration/worker-existing-registration.dist_span') }})
                                                            </label>

                                                            <select name="district"
                                                                    class="form-control @if ($errors->has('district')) is-invalid @endif"
                                                                    id="district_code">
                                                                <option value="">Select District</option>
                                                                @foreach ($districts as $district)
                                                                    <option value="{{ $district->district_code }}">
                                                                        {{ $district->district_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Office -->
                                                        <div class="form-group">
                                                            <label class="font-weight-semibold">
                                                                {{ trans('worker-registration/worker-existing-registration.office') }}
                                                                <span class="text-danger">*</span>
                                                                ({{ trans('worker-registration/worker-existing-registration.office_span') }})
                                                            </label>

                                                            <select name="office_id"
                                                                    class="form-control @if ($errors->has('office_id')) is-invalid @endif"
                                                                    id="office_id">
                                                                <option value="">Select Office</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>


                                                <!-- Contact Information -->
                                                <div class="card shadow-sm mb-4">
                                                    <div class="card-header bg-light">
                                                        <h5 class="mb-0 font-weight-bold">
                                                            <i class="fa fa-phone mr-2 text-primary"></i>
                                                            Contact Information
                                                        </h5>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="form-group mb-0">
                                                            <label class="font-weight-semibold">Phone Number</label>

                                                            <input type="text"
                                                                   value="{{ $phoneNo }}"
                                                                   class="form-control bg-light"
                                                                   name="phone_no"
                                                                   readonly>

                                                            <small class="form-text text-muted">
                                                                This number will be used for communication.
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <!-- RIGHT COLUMN -->
                                            <div class="col-lg-6 d-flex flex-column">

                                                <!-- Aadhaar eKYC -->
                                                <div class="card shadow-sm mb-4">
                                                    <div class="card-header bg-light">
                                                        <h5 class="mb-0 font-weight-bold">
                                                            <i class="fa fa-id-card mr-2 text-primary"></i>
                                                            Aadhaar eKYC Verification
                                                        </h5>
                                                    </div>

                                                    <div class="card-body">

                                                        <!-- Consent -->
                                                        <div class="form-group">
                                                            <label class="font-weight-semibold">
                                                                {{ trans('worker-registration/worker-existing-registration.aadhar_consent') }}
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input"
                                                                       type="checkbox"
                                                                       value="y"
                                                                       id="aadhar_consent"
                                                                       name="aadhar_consent"
                                                                       required>

                                                                <label class="form-check-label" for="aadhar_consent">
                                                                    {{ trans('worker-registration/worker-existing-registration.agree') }}
                                                                    <span class="text-primary font-weight-semibold">
                                    {{ trans('worker-registration/worker-existing-registration.terms') }}
                                </span>
                                                                    {{ trans('worker-registration/worker-existing-registration.and') }}
                                                                    <span class="text-primary font-weight-semibold">
                                    {{ trans('worker-registration/worker-existing-registration.conditions') }}
                                </span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <!-- ID Type -->
                                                        <div class="form-group">
                                                            <label class="font-weight-semibold">
                                                                Select ID Type <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="mt-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input"
                                                                           type="radio"
                                                                           name="idType"
                                                                           value="aadhar"
                                                                           checked>
                                                                    <label class="form-check-label">Aadhaar</label>
                                                                </div>

                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input"
                                                                           type="radio"
                                                                           name="idType"
                                                                           value="vid">
                                                                    <label class="form-check-label">VID</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- UID Input -->
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text"
                                                                       class="form-control"
                                                                       id="uid"
                                                                       name="uid"
                                                                       disabled
                                                                       placeholder="Enter 12 Digit UID"
                                                                       maxlength="12">

                                                                <div class="input-group-append">
                                                                    <button class="btn btn-primary"
                                                                            type="button"
                                                                            id="verifyExButton">
                                    <span id="spinner"
                                          class="spinner-border spinner-border-sm"
                                          style="display:none;"></span>
                                                                        Generate OTP
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <!-- OTP Verification -->
                                                <div id="otpExVerification" class="card shadow-sm mb-4" style="display:none;">

                                                    <div class="card-header bg-light">
                                                        <h5 class="mb-0 font-weight-bold text-success">
                                                            <i class="fa fa-key mr-2"></i>
                                                            OTP Verification
                                                        </h5>
                                                    </div>

                                                    <div class="card-body">

                                                        <!-- OTP Consent -->
                                                        <div class="form-group">
                                                            <label class="font-weight-semibold">
                                                                {{ trans('worker-registration/worker_new_registration.consentOTP') }}
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input"
                                                                       type="checkbox"
                                                                       value="y"
                                                                       id="consent"
                                                                       name="consent"
                                                                       required>
                                                                <label class="form-check-label" for="consent">
                                                                    {{ trans('worker-registration/worker_new_registration.agree') }}
                                                                    {{ trans('worker-registration/worker_new_registration.terms') }}
                                                                    {{ trans('worker-registration/worker_new_registration.and') }}
                                                                    {{ trans('worker-registration/worker_new_registration.conditions') }}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <!-- OTP Input -->
                                                        <div class="form-group">
                                                            <label class="font-weight-semibold">
                                                                Enter OTP <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="d-flex justify-content-between mt-2" style="max-width:300px;">
                                                                <div id="otpInputs" class="otp-inputs">

                                                                    <input type="text" class="otp-input" maxlength="1"
                                                                           disabled />
                                                                    <input type="text" class="otp-input" maxlength="1"
                                                                           disabled />
                                                                    <input type="text" class="otp-input" maxlength="1"
                                                                           disabled />
                                                                    <input type="text" class="otp-input" maxlength="1"
                                                                           disabled />
                                                                    <input type="text" class="otp-input" maxlength="1"
                                                                           disabled />
                                                                    <input type="text" class="otp-input" maxlength="1"
                                                                           disabled />

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-3">
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                    id="submitExOTP">Submit OTP&nbsp;<i class="fa fa-check-circle"
                                                                                                        aria-hidden="true"></i></button>
                                                            <button type="button" class="btn btn-sm btn-secondary ml-2"
                                                                    id="resendOtpButton" disabled>Resend OTP&nbsp;<i
                                                                        class="fa fa-refresh" aria-hidden="true"></i> </button>
                                                            <span id="otpTimer" class="ml-2"></span>
                                                            <div id="spinner-old-auth" style="display:none;">
                                                                <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                                                                Please Wait...
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <!-- Bottom Submit -->
                                        <div class="row">
                                            <div class="col-12 text-center mt-3">
                                                <button type="submit"
                                                        id="register-btn-worker-old"
                                                        class="btn btn-primary px-4"
                                                        style="display:none;">
                                                    Save & Next
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                                {{--                                </div> --}}
                                {{--                                <div class="noregex" style="display: none;"> --}}
                                {{--                                    <div class="row justify-content-md-center mt-2 ml-5"> --}}

                                {{--                                        <div class="form-group col-md-12 col-sm-12 mr-4"> --}}
                                {{--                                            <label for="inputDob" class="bold">Enter Temporary ID</label>&nbsp;<span class="text-danger" style="font-size:20px;">*</span> --}}
                                {{--                                            <input type="text"  class="form-control" name="temp_worker_id" id="temp_worker_id" value="{{ old('temp_worker_id') }}" --}}
                                {{--                                                   placeholder="Enter Temporary Registration ID" oninput="this.value = this.value.toUpperCase()"> --}}
                                {{--                                        </div> --}}
                                {{--                                    </div> --}}
                                {{--                                    <div class="d-flex justify-content-center mb-3"> --}}
                                {{--                                        <button type="button" class="btn btn-sm btn-warning temp-id" id="submit-temp-form" aria-label="Proceed"> --}}
                                {{--                                            <i class="fas fa-spinner fa-spin d-none" id="loading-spinner"></i> --}}
                                {{--                                            &nbsp;Login&nbsp; --}}
                                {{--                                        </button> --}}
                                {{--                                        <div id="spinner-old" style="display:none;"> --}}
                                {{--                                            <i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Please Wait... --}}
                                {{--                                        </div> --}}
                                {{--                                    </div> --}}

                                {{--                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div><!-- End Left side columns -->
            </div>
        </div>
    </div>


@endsection


@section('footer')
    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/aadharExAuth.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const aadharRadio = document.getElementById('aadharRadio');
            const vidRadio = document.getElementById('vidRadio');
            const uidInput = document.getElementById('uid');

            aadharRadio.addEventListener('change', function() {
                uidInput.disabled = false;
                uidInput.placeholder = "Enter 12 Digit UID";
                uidInput.maxLength = 12;
            });

            vidRadio.addEventListener('change', function() {
                uidInput.disabled = false;
                uidInput.placeholder = "Enter 16 Digit VID";
                uidInput.maxLength = 16;
            });
        });
    </script>

    <script>
        document.getElementById('aadhar_consent').addEventListener('click', function(event) {
            const district = document.getElementById('district_code').value;
            const office = document.getElementById('office_id').value;

            // Prevent action if district or office is not selected
            if (!district || !office) {
                event.preventDefault();
                Swal.fire({
                    text: 'Please select both District and Office before agreeing to the terms and conditions.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                this.checked = false;
                return;
            }

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


    {{--<script>--}}
        {{--$(document).ready(function() {--}}

            {{--$('#district_code').on('change', function() {--}}
                {{--// ajaxStart();--}}
                {{--var office_id = $(this).val();--}}
                {{--// console.log(cState);return--}}
                {{--var district_code = $(this).val();--}}

                {{--if (district_code) {--}}
                    {{--$.ajax({--}}
                        {{--url: "{{ route('get-office-reg') }}",--}}
                        {{--type: 'GET',--}}
                        {{--data: {--}}
                            {{--district_code: district_code,--}}
                            {{--_token: '{{ csrf_token() }}'--}}
                        {{--},--}}
                        {{--dataType: 'json',--}}
                        {{--success: function(data) {--}}
                            {{--var dis = '#office_id';--}}
                            {{--console.log(data);--}}
                            {{--$(dis).html('<option value="">--Select Office--</option>');--}}
                            {{--$.each(data.office, function(key, value) {--}}
                                {{--$(dis).append('<option value="' + value.office_id +--}}
                                    {{--'">' + value.office_name + '</option>');--}}
                            {{--});--}}

                        {{--}--}}
                    {{--});--}}
                {{--} else {--}}
                    {{--$('#office_id').empty();--}}
                    {{--// $('#subdistrict').empty();--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}

    <script>
        var token = "{{ csrf_token() }}";
    </script>

@endsection
