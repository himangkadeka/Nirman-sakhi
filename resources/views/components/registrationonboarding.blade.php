<style>
    /* Add your custom styles here */
    /*.custom-bottom-border {*/
    /*    border-bottom: 2px solid #ced4da;*/
    /*}*/
    .otp-inputs {
        display: flex;
        justify-content: space-between;
        width: 220px;
        /* Adjust as needed */
        margin-bottom: 20px;
        /* Add some space below the inputs */
    }

    .audio-control {
        cursor: pointer;
        font-size: 40px;
        /* Adjust the size of the icon */
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

    .error-message {
        font-size: 0.875em;
    }

    .bold {
        font-weight: bold;
    }

    .invalid-input {
        border-color: #dc3545 !important;
    }

    .btn-primary,
    .btn-warning,
    .btn-success,
    .btn-danger,
    .btn-secondary {
        border-radius: 20px;
        padding: 0.3em 1em;
    }

    .input-group-append .btn {
        margin-left: -1px;
    }

    .pdf-container {
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .modal-title {
        font-size: 1.25em;
        font-weight: bold;
    }

    .control-label {
        font-weight: bold;
    }

    .custom-bottom-border {
        border-bottom: 2px solid #ddd;
    }

    .error-message {
        font-size: 0.875em;
    }

    /*.otp-inputs {*/
    /*    display: flex;*/
    /*    justify-content: space-between;*/
    /*    gap: 5px;*/
    /*}*/
    /*.otp-input {*/
    /*    width: 40px;*/
    /*    height: 40px;*/
    /*    text-align: center;*/
    /*}*/
    .form-check-input {
        margin-top: 0.3em;
    }

    .form-check-label {
        cursor: pointer;
    }

    .input-group-append .btn {
        margin-left: 5px;
    }

    .input-group-append .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-success:hover,
    .btn-success:focus {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-secondary:hover,
    .btn-secondary:focus {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .text-danger.hover-trigger:hover {
        text-decoration: underline;
        cursor: pointer;
    }

    /*.modal-footer .btn {*/
    /*    width: 100%;*/
    /*}*/

    .modal-body-tc {
        max-height: 400px;
        /* Adjust this value as needed */
        overflow-y: auto;
    }
</style>

<div class="modal fade" id="onboardingregister-modal" tabindex="-1" role="dialog" aria-labelledby="register-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block border-bottom-0 bg-success">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('worker-registration/worker_register_form.worker_reg_form') }}</h5>
                <button type="button" class="close position-absolute hide-new" style="right: 15px; top: 8px;"
                    data-dismiss="modal" id="closeMe">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Page 1: Welcome Message -->

                <div class="row">

                    <div class="col-md-12 pr-5" style="background-color: #96c3de6d;">
                        <div class="text-left d-block p-2">
                            <h5 class="text-center">
                                {{ trans('worker-registration/worker_register_form.reg_criteria_onboarding') }}</h5>


                            <ol>
                                <li>{{ trans('worker-registration/worker_register_form.criteria_text_old1') }}
                                    {{-- </li><span> <a href="https://eshram.gov.in/" class="text-secondary ">Note: Workers who don’t have eshram can Register here </a></span> --}}
                            </ol>
                            <span class="text-primary ml-4"
                                style="text-decoration: underline;">{{ trans('worker-registration/worker_register_form.documents') }}</span>
                            <ol>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old1') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old2') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old3') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old4') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old5') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old6') }}</li>
                            </ol>
                            <div class="px-4"><strong>Note:</strong> Copies of only original documents shall be
                                allowed for scanning and uploading.</div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <input type="checkbox" id="terms-checkbox-old" onchange="toggleButtonOld()">
                    <label for="terms-checkbox">I have read and agree to the Terms and Conditions.</label>
                </div>

                <!-- Tab panes -->
                <div class="text-center mt-2">
                    <a href="{{ route('check-before-onboarding') }}" id="old-register-button"
                        class="btn btn-primary btn-sm text-center disabled-link"
                        style="background-color: #ec6e47; border:1px solid #ec6e47; pointer-events: none; opacity: 0.6;">
                        <i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;
                        {{ trans('worker-registration/worker_register_form.click_here') }}
                    </a>
                </div>

                {{-- <div id="page-1" class="page active">
                    <h3 class="text-center">{{ trans('worker-registration/worker_register_form.reg_criteria') }}</h3>
                    <table class="table table-bordered table-sm table-striped">
                        <tbody style="font-family: sans-serif">
                                                       <tr>
                                <th>{{ trans('worker-registration/worker_register_form.already_reg_worker') }}</th>
                                <td>
                                    <ol>
                                        <li>{{ trans('worker-registration/worker_register_form.criteria_text_old1') }}
                                        </li>

                                    </ol>
                                    <span class="text-primary"
                                        style="text-decoration: underline;">{{ trans('worker-registration/worker_register_form.documents') }}</span>
                                    <ol>
                                        <li>{{ trans('worker-registration/worker_register_form.documents_old1') }}</li>
                                        <li>{{ trans('worker-registration/worker_register_form.documents_old2') }}</li>
                                        <li>{{ trans('worker-registration/worker_register_form.documents_old3') }}</li>
                                        <li>{{ trans('worker-registration/worker_register_form.documents_old4') }}</li>

                                    </ol>
                                </td>
                                <td><a href="{{ route('check-before-onboarding') }}" type="button" id="already-registered-button"
                                        class="btn btn-primary btn-sm text-center"><i class="fa fa-sign-in"
                                            aria-hidden="true"></i>&nbsp;{{ trans('worker-registration/worker_register_form.click_here') }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}


                <!-- Page 2: New Register Form -->
                <div class="login-tab page" id="page-2" style="display: none;">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab"
                                href="#workerRegister">{{ trans('registration_modal.new_register_btn') }}</a>
                        </li>

                        {{--                        <li class="nav-item"> --}}
                        {{--                            <a class="nav-link" data-toggle="tab" href="#alreadyRegister" id="open-already-registered">{{ trans('registration_modal.already_registered_btn') }}</a> --}}
                        {{--                        </li> --}}
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content mt-3">
                        <!-- Worker Register -->
                        <div class="tab-pane container active" id="workerRegister">
                            <div id="workerregistermsg"></div>
                            <p class="text-danger">* All are Mandatory Fields / সকলোবোৰ বাধ্যতামূলক ক্ষেত্ৰ </p>
                            <div class="form-group row">
                                <label class="control-label bold col-sm-4 col-md-3">DISTRICT / জিলা<span
                                        class="text-danger" style="font-size:1.5em">*</span> </label>
                                <div class="col-sm-8 col-md-9">
                                    <select name="district"
                                        class="form-control custom-bottom-border  @if ($errors->has('district')) is-invalid @endif"
                                        id="district_code">
                                        <option value="">Select District </option>
                                        @foreach ($dists as $district)
                                            <option value="{{ $district->district_code }}">
                                                {{ $district->district_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="error text-danger" id="districtError"></p>
                                    @if ($errors->has('district'))
                                        <span
                                            class="text-warning font-weight-normal">{{ $errors->first('district') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label bold col-sm-4 col-md-3" for="office">OFFICE<span
                                        class="text-danger" style="font-size:1.5em">*</span></label>
                                <div class="col-sm-8 col-md-9">
                                    <select name="office_id"
                                        class="form-control custom-bottom-border  @if ($errors->has('office_id')) is-invalid @endif"
                                        id="office_id">
                                        <option value="">Select Office </option>
                                    </select>
                                    <p class="error text-danger" id="office_idError"></p>
                                    @if ($errors->has('office_id'))
                                        <span
                                            class="text-warning font-weight-normal">{{ $errors->first('office_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label bold col-sm-4 col-md-3" for="phone_no">CONTACT NUMBER<span
                                        class="text-danger" style="font-size:1.5em">*</span></label>
                                <div class="col-sm-8 col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control custom-bottom-border" id="phone_no"
                                            name="phone_no" placeholder="Enter Phone No " maxlength="10"
                                            inputmode="numeric" pattern="\d*" />
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary checkRecord" type="button">Check
                                                Record</button>
                                        </div>
                                    </div>
                                    <p class="error text-danger" id="phone_noError"></p>
                                    @if ($errors->has('phone_no'))
                                        <span
                                            class="text-warning font-weight-normal">{{ $errors->first('phone_no') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div id="aadhaarSection">
                                <div class="form-group row">
                                    <label for="" class="bold control-label col-sm-4 col-md-3">AADHAAR
                                        CONSENT</label>
                                    <div class="col-sm-8 col-md-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="y"
                                                id="aadhar_consent" name="aadhar_consent" required>
                                            <label class="control-label bold" for="aadhar_consent" id="terms_label">
                                                I agree to the <span class="text-danger hover-trigger"
                                                    id="terms">Terms</span> and <span
                                                    class="text-danger hover-trigger"
                                                    id="conditions">Conditions</span> of UIDAI
                                            </label>
                                        </div>

                                        <div class="modal fade" id="termsModal" tabindex="-1" role="dialog"
                                            aria-labelledby="termsModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="termsModalLabel">Aadhaar Terms &
                                                            Conditions</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body-tc">
                                                        <p>
                                                            {{--                                                        <div class="audio-control" onclick="playAudio()"> --}}
                                                            {{--                                                            <i class="fas fa-volume-up"></i> <!-- Font Awesome speaker icon --> --}}
                                                            {{--                                                        </div> --}}
                                                        <ol>


                                                            <li>Hiiiiiii I understand that my Aadhaar number, biometric
                                                                information and/or One-Time Password
                                                                (OTP) and demographic information, as understood
                                                                under the Aadhaar (Targeted
                                                                Delivery of Financial and Other Subsidies, Benefits
                                                                and Services) Act, 2016 and
                                                                regulations framed thereunder, is being collected by
                                                                the Assam Building and Other
                                                                Construction Workers Welfare Board(ABOCWWB) for the
                                                                following purposes:</li>
                                                            <ol type="a">
                                                                <li>Authenticating my identity by way of the Aadhaar
                                                                    number authentication system</li>
                                                                <li>Registering on the Nirman Sakhi Portal for Assam
                                                                    Building and Other
                                                                    Construction Worker’s ID and for availing
                                                                    benefits under the Building and Other
                                                                    Construction Workers Act 1996;</li>
                                                                <li>Seeding of Aadhaar number with my bank account;
                                                                </li>
                                                                <li>Assessing my status of “Unorganised” worker and
                                                                    eligibility across Government
                                                                    programmes run by the Assam Building and Other
                                                                    Construction Workers’ Welfare
                                                                    Board under the Building and Other Construction
                                                                    Workers Act 1996, or other
                                                                    similar welfare programmes run by other
                                                                    Departments/Ministries of the Central
                                                                    Government and State Governments;</li>
                                                                <li>Delivering the benefits of various schemes of
                                                                    Departments/Ministries of Union
                                                                    and State Governments framed for welfare of
                                                                    citizens;</li>
                                                                <li>Sharing of my Aadhaar number and demographic
                                                                    information with other
                                                                    Departments/Ministries of the Central
                                                                    Government, State Governments and local bodies
                                                                    for
                                                                    formulation or implementation of suitable
                                                                    welfare scheme(s);</li>
                                                                <li>Cross-verifying the collected Aadhaar number and
                                                                    associated identity information
                                                                    with the Aadhaar-seeded database of other
                                                                    Departments/Ministries of the Central
                                                                    Government and State Governments associated with
                                                                    the welfare scheme(s);</li>
                                                                <li>Measuring trends related to disbursement and
                                                                    effectiveness of social welfare
                                                                    benefits and services and improving the quality
                                                                    of such benefits and services;</li>
                                                                <li>Resolving security or technical issues
                                                                    associated with disbursement of social
                                                                    welfare benefits and services;</li>
                                                                <li>Strengthening digital platforms to ensure good
                                                                    governance and preventing
                                                                    dissipation of social welfare benefits;</li>
                                                                <li>Detecting, preventing, and otherwise addressing
                                                                    malpractices and harmful conduct
                                                                    associated with disbursement of social welfare
                                                                    benefits and services; and</li>
                                                                <li>All such purposes incidental thereto.</li>
                                                            </ol>
                                                            <li>
                                                                I understand that the Assam Building and Other
                                                                Construction Workers’ Welfare Board
                                                                shall create an Aadhaar-seeded database containing
                                                                my Aadhaar number, biometric
                                                                and/or One-Time Password (OTP) and demographic
                                                                information for all or any of the
                                                                purposes enlisted in paragraphs 1 (a)-(l) of this
                                                                consent form, that the Assam Building
                                                                and Other Construction Workers’ Welfare Board shall
                                                                ensure that requisite mechanisms
                                                                have been put in place to ensure safety, security
                                                                and privacy of such information in
                                                                accordance with applicable laws and regulations and
                                                                the Assam Building and Other
                                                                Construction Workers’ Welfare Board shall not share
                                                                my biometric information with
                                                                anyone for any reason whatsoever, or use it for any
                                                                purpose other than authentication.
                                                            </li>

                                                            <li>
                                                                I understand that in case of failure to authenticate
                                                                due
                                                                to illness, injury or infirmity owing
                                                                to old age or otherwise or any technical reasons,
                                                                the Assam
                                                                Building and Other
                                                                Construction Workers’ Welfare Board shall allow the
                                                                following alternate means of
                                                                identification for availing benefits under the Bocw
                                                                act
                                                                1996:

                                                                <ol type="a">
                                                                    <li>Voter ID card;</li>
                                                                    <li>Ration card;</li>
                                                                    <li>Passport;</li>
                                                                    <li>Driving License;</li>
                                                                    <li>Any Photo Identity Card issued by the
                                                                        Central Government, State Governments, or
                                                                        Union Territory Administrations; Certificate
                                                                        of identity with photograph issued by a
                                                                        Gazetted Officer on an official letterhead.
                                                                    </li>
                                                                </ol>
                                                            </li>
                                                            <li>
                                                                I have no objection to authenticating myself with
                                                                Aadhaar
                                                                based authentication system
                                                                and give my consent to provide my Aadhaar Number,
                                                                biometric
                                                                information and/ or One-
                                                                Time password (OTP) and demographic information for
                                                                Aadhaar
                                                                based authentication
                                                                for the purposes enlisted in paragraphs 1 (a)-(l) of
                                                                this
                                                                consent form and for creation of an
                                                                Aadhaar-seeded database as described in Paragraph 2
                                                                of this
                                                                consent form.
                                                            </li>
                                                        </ol>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-dismiss="modal">I understand</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label bold col-sm-4 col-md-3" for="uid">AADHAAR
                                        NUMBER<span class="text-danger">*</span></label>
                                    <div class="col-sm-8 col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control custom-bottom-border"
                                                id="uid" name="uid" placeholder="Enter 12 Digit UID "
                                                maxlength="12" inputmode="numeric" pattern="\d*"
                                                autocomplete="off" />
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-primary" type="button"
                                                    id="verifyButton">
                                                    <span id="spinner" class="spinner-border spinner-border-sm"
                                                        role="status" aria-hidden="true"
                                                        style="display: none;"></span>
                                                    <span id="buttonText">Generate OTP</span>
                                                </button>
                                            </div>
                                        </div>
                                        <span id="adhaarnoError" class="error-message text-danger"></span>
                                        <p class="error text-danger" id="uidError"></p>
                                        @if ($errors->has('uid'))
                                            <span
                                                class="text-warning font-weight-normal">{{ $errors->first('uid') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="otpVerification" style="display: none">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="" class="bold control-label col-sm-5 col-md-6">CONSENT FOR
                                            OTP</label>
                                        <span class="text-danger">*</span>
                                    </div>
                                    <div class="col-md-8">

                                        <div class="col-sm-12">

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="y"
                                                    id="consent" name="consent" required>

                                                I agree to the <span class="text-danger">Terms</span> and <span
                                                    class="text-danger">Conditions</span> of UIDAI
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <label class="control-label bold col-sm-12" for="dynamicPin">
                                            Successfully Generated One Time Password (OTP)
                                        </label>
                                        <div class="col-sm-12">
                                            {{--                                        <input type="text" class="form-control form-control-sm custom-bottom-border" id="dynamicPin" name="dynamicPin" placeholder="Enter OTP " readonly /> --}}
                                            <div id="otpInputs" class="otp-inputs">

                                                <input type="text" class="otp-input" maxlength="1" disabled />
                                                <input type="text" class="otp-input" maxlength="1" disabled />
                                                <input type="text" class="otp-input" maxlength="1" disabled />
                                                <input type="text" class="otp-input" maxlength="1" disabled />
                                                <input type="text" class="otp-input" maxlength="1" disabled />
                                                <input type="text" class="otp-input" maxlength="1" disabled />

                                            </div>
                                            <span id="otpError" class="error-message text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-6">
                                        <div class="col-sm-8">
                                            <button type="button" class="btn btn-sm btn-success"
                                                id="submitOTP">Submit OTP&nbsp;<i class="fa fa-check-circle"
                                                    aria-hidden="true"></i></button>
                                            <button type="button" class="btn btn-sm btn-secondary ml-2"
                                                id="resendOtpButton" disabled>Resend OTP&nbsp;<i class="fa fa-refresh"
                                                    aria-hidden="true"></i> </button>
                                            <span id="otpTimer" class="ml-2"></span>
                                            <div id="spinner-old-auth" style="display:none;">
                                                <i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Please
                                                Wait...
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center py-2 regBtn">
                                <button type="button" id="register-btn-worker" class="btn btn-primary btn-sm"
                                    style="display: none">
                                    <i class="fas fa-sign-in-alt"></i>&nbsp;<span id="register-btn-text">Register
                                        Now</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--modal end-->
<!-- Second Modal (already-registered-modal) -->
{{-- <div class="modal fade" id="already-registered-modal"> --}}
{{--    <div class="modal-dialog modal-dialog-centered modal-xl"> --}}
{{--        <div class="modal-content"> --}}
{{--            <div class="modal-header"> --}}
{{--                <h5 class="modal-title">Already Registered Worker Migration / ইতিমধ্যে পঞ্জীয়নভুক্ত শ্ৰমিক প্ৰব্ৰজন</h5> --}}
{{--                <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
{{--            </div> --}}
{{--            <div class="modal-body"> --}}
{{--                <div class="form-group row"> --}}
{{--                    <label class="control-label bold col-sm-4 col-md-3">DISTRICT / জিলা<span class="text-danger">*</span></label> --}}
{{--                    <div class="col-sm-8 col-md-9"> --}}
{{--                        <select name="district" class="form-control custom-bottom-border @if ($errors->has('district')) is-invalid @endif" id="district_code"> --}}
{{--                            <option value="">Select District </option> --}}
{{--                            @foreach ($dists as $district) --}}
{{--                                <option value="{{ $district->district_code }}"> --}}
{{--                                    {{ $district->district_name }} --}}
{{--                                </option> --}}
{{--                            @endforeach --}}
{{--                        </select> --}}
{{--                        <p class="error text-danger" id="districtError"></p> --}}
{{--                        @if ($errors->has('district')) --}}
{{--                            <span class="text-warning font-weight-normal">{{ $errors->first('district') }}</span> --}}
{{--                        @endif --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="form-group row"> --}}
{{--                    <label class="control-label bold col-sm-4 col-md-3" for="office">OFFICE<span class="text-danger">*</span></label> --}}
{{--                    <div class="col-sm-8 col-md-9"> --}}
{{--                        <select name="office_id" class="form-control custom-bottom-border @if ($errors->has('office_id')) is-invalid @endif" id="office_id"> --}}
{{--                            <option value="">Select Office </option> --}}
{{--                        </select> --}}
{{--                        <p class="error text-danger" id="office_idError"></p> --}}
{{--                        @if ($errors->has('office_id')) --}}
{{--                            <span class="text-warning font-weight-normal">{{ $errors->first('office_id') }}</span> --}}
{{--                        @endif --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="form-group row"> --}}
{{--                    <label class="control-label bold col-sm-4 col-md-3" for="phone_no">CONTACT NUMBER<span class="text-danger">*</span></label> --}}
{{--                    <div class="col-sm-8 col-md-9"> --}}
{{--                        <div class="input-group"> --}}
{{--                            <input type="text" class="form-control custom-bottom-border" id="phone_no_old" name="phone_no_old" placeholder="Enter Phone No" maxlength="10" inputmode="numeric" pattern="\d*" /> --}}
{{--                            <div class="input-group-append"> --}}
{{--                                <button class="btn btn-primary checkRecord" type="button">Check Record</button> --}}
{{--                            </div> --}}
{{--                        </div> --}}
{{--                        <p class="error text-danger" id="phone_noError"></p> --}}
{{--                        @if ($errors->has('phone_no_old')) --}}
{{--                            <span class="text-warning font-weight-normal">{{ $errors->first('phone_no_old') }}</span> --}}
{{--                        @endif --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div id="aadhaarSectionOld"> --}}
{{--                    <div class="form-group row"> --}}
{{--                        <label class="bold control-label col-sm-4 col-md-3">AADHAAR CONSENT</label> --}}
{{--                        <div class="col-sm-8 col-md-9"> --}}
{{--                            <div class="form-check"> --}}
{{--                                <input class="form-check-input" type="checkbox" value="y" id="aadhar_consent_old" name="aadhar_consent_old" required> --}}
{{--                                <label class="control-label bold" for="aadhar_consent"> --}}
{{--                                    I agree to the <span class="text-danger hover-trigger">Terms</span> and <span class="text-danger hover-trigger">Conditions</span> of UIDAI --}}
{{--                                </label> --}}
{{--                            </div> --}}
{{--                        </div> --}}
{{--                    </div> --}}
{{--                    <div class="form-group row"> --}}
{{--                        <label class="control-label bold col-sm-4 col-md-3" for="uid">AADHAAR NUMBER<span class="text-danger">*</span></label> --}}
{{--                        <div class="col-sm-8 col-md-9"> --}}
{{--                            <div class="input-group"> --}}
{{--                                <input type="text" class="form-control custom-bottom-border" id="uid_old" name="uid_old" placeholder="Enter 12 Digit UID" maxlength="12" inputmode="numeric" pattern="\d*" /> --}}
{{--                                <div class="input-group-append"> --}}
{{--                                    <button class="btn btn-primary" type="button" id="verifyButton"> --}}
{{--                                        <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span> --}}
{{--                                        <span id="buttonText">Generate OTP</span> --}}
{{--                                    </button> --}}
{{--                                </div> --}}
{{--                            </div> --}}
{{--                            <span id="adhaarnoError" class="error-message text-danger"></span> --}}
{{--                            <p class="error text-danger" id="uidError"></p> --}}
{{--                            @if ($errors->has('uid_old')) --}}
{{--                                <span class="text-warning font-weight-normal">{{ $errors->first('uid_old') }}</span> --}}
{{--                            @endif --}}
{{--                        </div> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div id="otpVerification" style="display: none"> --}}
{{--                    <div class="form-group row"> --}}
{{--                        <label class="bold control-label col-sm-4 col-md-3">CONSENT FOR OTP<span class="text-danger">*</span></label> --}}
{{--                        <div class="col-sm-8 col-md-9"> --}}
{{--                            <div class="form-check"> --}}
{{--                                <input class="form-check-input" type="checkbox" value="y" id="consent_old" name="consent" required> --}}
{{--                                <label class="control-label bold" for="consent"> --}}
{{--                                    I agree to the <span class="text-danger">Terms</span> and <span class="text-danger">Conditions</span> of UIDAI --}}
{{--                                </label> --}}
{{--                            </div> --}}
{{--                        </div> --}}
{{--                    </div> --}}
{{--                    <div class="form-group row"> --}}
{{--                        <label class="control-label bold col-sm-12" for="dynamicPin">Successfully Generated One Time Password (OTP)</label> --}}
{{--                        <div class="col-sm-12 otp-inputs"> --}}
{{--                            <input type="text" class="otp-input" maxlength="1" disabled /> --}}
{{--                            <input type="text" class="otp-input" maxlength="1" disabled /> --}}
{{--                            <input type="text" class="otp-input" maxlength="1" disabled /> --}}
{{--                            <input type="text" class="otp-input" maxlength="1" disabled /> --}}
{{--                            <input type="text" class="otp-input" maxlength="1" disabled /> --}}
{{--                            <input type="text" class="otp-input" maxlength="1" disabled /> --}}
{{--                        </div> --}}
{{--                        <span id="otpError" class="error-message text-danger"></span> --}}
{{--                    </div> --}}
{{--                    <div class="form-group row"> --}}
{{--                        <div class="col-md-8 offset-md-4"> --}}
{{--                            <button type="button" class="btn btn-success" id="submitOTP">Submit OTP&nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i></button> --}}
{{--                            <button type="button" class="btn btn-secondary ml-2" id="resendOtpButton" disabled>Resend OTP&nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></button> --}}
{{--                            <span id="otpTimer" class="ml-2"></span> --}}
{{--                        </div> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="d-flex justify-content-center py-2 regBtn"> --}}
{{--                    <button type="button" id="register-btn-worker" class="btn btn-primary btn-sm" style="display: none"> --}}
{{--                        <i class="fas fa-sign-in-alt"></i>&nbsp;<span id="register-btn-text">Register Now / এতিয়াই পঞ্জীয়ন কৰক</span> --}}
{{--                    </button> --}}
{{--                </div> --}}
{{--            </div> --}}
{{--            <div class="modal-footer"> --}}
{{--                <button id="backToFirstModalBtn" class="btn btn-warning btn-sm">Go Back</button> --}}
{{--            </div> --}}
{{--        </div> --}}
{{--    </div> --}}
{{-- </div> --}}
{{-- <script> --}}
{{--    $(document).ready(function() { --}}
{{--        // When clicking the button in the first modal to open the second modal --}}
{{--        $('#open-already-registered').click(function() { --}}
{{--            // Hide the first modal --}}
{{--            $('#register-modal').removeClass('show').hide(); --}}
{{--            // Show the backdrop --}}
{{--            $('.modal-backdrop').remove(); --}}
{{--            // Show the second modal --}}
{{--            $('#already-registered-modal').addClass('show').show(); --}}
{{--        }); --}}

{{--        // When clicking the button in the second modal to go back to the first modal --}}
{{--        $('#backToFirstModalBtn').click(function() { --}}
{{--            // Hide the second modal --}}
{{--            $('#already-registered-modal').removeClass('show').hide(); --}}
{{--            // Show the backdrop --}}
{{--            $('.modal-backdrop').remove(); --}}
{{--            // Show the first modal --}}
{{--            $('#register-modal').addClass('show').show(); --}}
{{--        }); --}}

{{--    }); --}}

{{-- </script> --}}
<audio id="audio-player" src="{{ URL::asset('assets/template/audio consent/aadhaar_consent_audio.mpeg') }}"
    preload="auto"></audio>
<script>
    function playAudio() {
        var audio = document.getElementById('audio-player');
        audio.play();
    }
</script>
<script>
    document.getElementById('aadhar_consent').addEventListener('change', function() {
        if (this.checked) {
            $('#termsModal').modal('show');
        }
    });
</script>

<script>
    $('#ongoingregister-modal').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset'); // Reset all form fields
        $(this).find('form').find('.form-control').removeClass('is-invalid');

    });
</script>
<script>
    function toggleButtonOld() {
        const checkbox = document.getElementById('terms-checkbox-old');
        const button = document.getElementById('old-register-button');

        if (checkbox.checked) {
            button.classList.remove('disabled-link');
            button.style.pointerEvents = 'auto';
            button.style.opacity = '1';
        } else {
            button.classList.add('disabled-link');
            button.style.pointerEvents = 'none';
            button.style.opacity = '0.6';
        }
    }
</script>
<script>
    // Prevent non-numeric input for phone_no and uid fields
    document.getElementById('phone_no').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('uid').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>

<script>
    var token = "{{ csrf_token() }}";
</script>
{{-- <script> --}}
{{--    $(document).ready(function() { --}}
{{--        // Function to toggle PDF modal --}}
{{--        function togglePDFModal() { --}}
{{--            var modal = new bootstrap.Modal(document.getElementById('pdfModal')); --}}
{{--            modal.show(); --}}
{{--        } --}}

{{--        // Event listener to show PDF modal on checkbox click --}}
{{--        $('#aadhar_consent').change(function() { --}}
{{--            if ($(this).is(':checked')) { --}}
{{--                togglePDFModal(); --}}
{{--            } --}}
{{--        }); --}}

{{--        // Close button in PDF modal --}}
{{--        $('#close-pdf-modal').click(function() { --}}
{{--            $('#pdfModal').modal('hide'); --}}
{{--        }); --}}

{{--        // Ensure proper closing of PDF modal --}}
{{--        $('#pdfModal').on('hidden.bs.modal', function (e) { --}}
{{--            // Reset the checkbox state if needed --}}
{{--            $('#aadhar_consent').prop('checked', false); --}}
{{--        }); --}}

{{--        // Ensure unique modal handling --}}
{{--        $('#register-modal').on('hidden.bs.modal', function (e) { --}}
{{--            // Ensure PDF modal is closed when register modal is closed --}}
{{--            $('#pdfModal').modal('hide'); --}}
{{--        }); --}}
{{--    }); --}}
{{-- </script> --}}
