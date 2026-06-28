@extends('layouts.user-app')

@section('title', 'Registration')

@section('style')
    <style type="text/css">
        body {
            background-color: #f1f1f1;
        }

        .bar1,
        .bar2,
        .bar3 {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
            transition: 0.4s;
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

        .card {
            -webkit-box-shadow: -2px 2px 0px 1px rgba(15, 58, 71, 1);
            -moz-box-shadow: -2px 2px 0px 1px rgba(15, 58, 71, 1);
            box-shadow: -2px 2px 0px 1px rgba(15, 58, 71, 1);

        }

        /*box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;*/



        .card-title {
            background-image: url("/assets/template/images/frombannercopy.jpg");
            height: 100px;
            background-repeat: no-repeat, no-repeat;
            background-position: center;
            text-align: center;
            color: white;
            /*width:;*/

        }

        .custom-navbar {
            border-bottom: 2px solid #eee;
        }

        .custom-container {
            max-width: 1200px;
        }

        .custom-flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-left-content {
            display: flex;
            flex-direction: column;
        }

        .custom-heading {
            margin-bottom: 0.5rem;
        }

        .custom-bold {
            font-weight: bold;
        }

        .custom-icon {
            color: #007bff;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-md-12">
                <nav class="custom-navbar navbar-light bg-light p-3" style="border-radius: 20px;">
                    <div class="custom-container">
                        <div class="custom-flex-container">
                            <div class="custom-left-content">
                                <h6 class="custom-heading">Registration - Construction Worker</h6>
{{--                                <h6 class="custom-bold">--}}
{{--                                    <i class="custom-icon fas fa-file-alt pr-2"></i>Application No - {{ $formdata->application_no }}--}}
{{--                                </h6>--}}
                            </div>

                        </div>
                    </div>
                </nav>

                <div class="card form-card mt-3">
                    <div class="card-body">
                        <p class="text-danger">* All are Mandatory Fields/সকলোবোৰ বাধ্যতামূলক ক্ষেত্ৰ </p>
                        <div class="form-group mt-2">

                            <label class="control-label bold col-sm-4 col-md-3">DISTRICT/জিলা<span class="text-danger" style="font-size:1.5em">*</span> </label>
                            <div class="col-sm-8 col-md-9">
                                <select name="district" class="form-control custom-bottom-border" id="district_code">
                                    <option value="">Select District/জিলা নিৰ্বাচন কৰক</option>
                                    @foreach ($dists as $district)
                                        <option value="{{ $district->district_code }}">
                                            {{ $district->district_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="error text-danger" id="districtError"></p>
                                @if ($errors->has('district'))
                                    <span class="text-warning font-weight-normal">{{ $errors->first('district') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label bold col-sm-4 col-md-3" for="office">OFFICE/কাৰ্যালয়<span class="text-danger" style="font-size:1.5em">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <select name="office_id" class="form-control custom-bottom-border" id="office_id">
                                    <option value="">Select Office/কাৰ্যালয় নিৰ্বাচন কৰক</option>
                                </select>
                                <p class="error text-danger" id="office_idError"></p>
                                @if ($errors->has('office_id'))
                                    <span class="text-warning font-weight-normal">{{ $errors->first('office_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label bold col-sm-4 col-md-3" for="phone_no">CONTACT NUMBER/যোগাযোগ নম্বৰ<span class="text-danger" style="font-size:1.5em">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control  custom-bottom-border" id="phone_no" name="phone_no"
                                           placeholder="Enter Phone No" maxlength="10" inputmode="numeric" pattern="\d*" />
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-primary checkRecord" type="button">Check Record/ৰেকৰ্ড পৰীক্ষা কৰক</button>
                                    </div>
                                </div>
                                <p class="error text-danger" id="phone_noError"></p>
                                @if ($errors->has('phone_no'))
                                    <span class="text-warning font-weight-normal">{{ $errors->first('phone_no') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group" id="aadhaarSection">
                            <label class="control-label bold col-sm-4 col-md-3" for="uid">AADHAAR NUMBER/আধাৰ নম্বৰ<span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control  custom-bottom-border" id="uid" name="uid" placeholder="Enter 12 Digit UID" maxlength="12" inputmode="numeric" pattern="\d*" />
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-primary" type="button" id="verifyButton">Generate OTP/OTP সৃষ্টি কৰক</button>
                                    </div>
                                </div>
                                <span id="adhaarnoError" class="error-message text-danger"></span>
                                <p class="error text-danger" id="uidError"></p>
                                @if ($errors->has('uid'))
                                    <span class="text-warning font-weight-normal">{{ $errors->first('uid') }}</span>
                                @endif
                            </div>
                        </div>
                        <div id="otpVerification" style="display: none">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="consent" required>
                                        <label class="control-label bold" for="consent">
                                            Please check to give Aadhaar consent
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label bold col-sm-12" for="dynamicPin">
                                    Successfully Generated One Time Password (OTP)
                                </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control custom-bottom-border" id="dynamicPin" name="dynamicPin" placeholder="Enter OTP" readonly />
                                    <span id="otpError" class="error-message text-danger"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-sm btn-success" id="submitOTP">Verify</button>
                                    <button type="button" class="btn btn-sm btn-secondary ml-2" id="resendOtpButton" disabled>Resend OTP</button>
                                    <span id="otpTimer" class="ml-2"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group captcha" style="display: none">
                            <div class="d-flex align-items-center">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger btn-sm reload-captcha ml-2">
                                    &#x21bb;
                                </button>
                            </div>
                        </div>
                        <div class="form-group mb-4 captcha-submit" style="display: none">
                            <input id="offcaptcha" type="text" class="form-control custom-bottom-border" placeholder="Enter Captcha" name="captcha">
                            <span class="text-danger bold" id="captcha_error"></span>
                        </div>
                        <div class="d-flex justify-content-center py-2 regBtn">
                            <button type="button" id="register-btn-worker" class="btn btn-primary btn-sm" style="display: none">
                                <i class="fas fa-sign-in-alt"></i>&nbsp;<span id="register-btn-text">Register Now</span>
                            </button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">

                                <strong>{!! $message !!} </strong>

                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        {{-- @if ($message = Session::get('success')) --}}
                        {{-- <a href="{{route('generate-uan',['id'=>encrypt($id)])}}" target="_blank" class="btn btn-success">Print Acknowledgement</a> --}}

                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footer')
    <link rel="stylesheet" href="{{ URL::asset('assets/template/datepicker/jquery-ui.min.css') }}">
    <script src="{{ URL::asset('assets/template/datepicker/jquery-3.7.date.js') }}"></script>
    <script src="{{ URL::asset('assets/template/datepicker/jquery-ui.min.js') }}"></script>
    <script>
        // Initialize the datepicker
        $(document).ready(function() {
            var defaultYear = 1993;
            $("#dob").datepicker({
                defaultDate: new Date(defaultYear, 0, 1),
                dateFormat: "mm/dd/yy",
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0", // Allow selecting DOB up to 100 years ago from the current year
                onSelect: function(selectedDate) {
                    calculateAge(selectedDate);
                    validateAge(selectedDate);
                }
            });
        });

        // Calculate age
        function calculateAge(selectedDate) {
            var dob = new Date(selectedDate);
            var year = dob.getFullYear();
            var curYear = new Date().getFullYear();
            var age = curYear - year;
            $("#age").val(age);
        }

        // Validate age
        function validateAge(selectedDate) {
            var dob = new Date(selectedDate);
            var year = dob.getFullYear();
            var curYear = new Date().getFullYear();
            var age = curYear - year;

            if (age < 18 || age > 55) {
                // Show SweetAlert message
                Swal.fire({
                    title: 'Age Validation',
                    text: 'Worker Age must be between 18 and 55 years old.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });

                // Clear the datepicker value and age value
                $("#dob").val('');
                $("#age").val('');
            }
        }
    </script>
    <script>
        const formatInput = (e) => {
            let el = e.target;
            let inputValue = el.value;

            // Get the cursor position
            let cursorPosition = el.selectionStart;

            // Get the word that the cursor is currently in
            let wordStart = inputValue.lastIndexOf(' ', cursorPosition - 1) + 1;
            let wordEnd = inputValue.indexOf(' ', cursorPosition);
            if (wordEnd === -1) {
                wordEnd = inputValue.length;
            }
            let currentWord = inputValue.substring(wordStart, wordEnd);

            // Capitalize the current word
            let formattedWord = currentWord.charAt(0).toUpperCase() + currentWord.slice(1);

            // Replace the current word with the formatted one
            let newValue = inputValue.substring(0, wordStart) + formattedWord + inputValue.substring(wordEnd);

            // Update the value and cursor position
            el.value = newValue;
            el.setSelectionRange(cursorPosition, cursorPosition);
        };

        document.querySelectorAll(".uc-text-smooth").forEach(function(current) {
            current.addEventListener("input", formatInput);
        });
    </script>

@endsection

