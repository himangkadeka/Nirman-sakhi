<script src="{{ URL::asset('assets/encrypt/crypto-js.min.js') }}"></script>
<script src="{{ URL::asset('assets/encrypt/Encryption.js') }}"></script>


<script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
<script>
    function myFunction(x) {
        x.classList.toggle("change");
    }
</script>
<script type="text/javascript">
    function encryptPassword(role_id) {
        if (role_id == 1) {
            var password = $("#login-pwd-1").val();
        } else {
            var password = $("#off-login-pwd-1").val();
        }

        var nonceValue = 'nonce_value';
        // Encrypt form data
        let encryption = new Encryption();
        var passwordEncrypted = encryption.encrypt(password, nonceValue);

        if (role_id == 1) {
            $("#login-pwd-1").val(passwordEncrypted);
        } else {
            $("#off-login-pwd-1").val(passwordEncrypted);
        }

    }
</script>
<!-- Menu Toggle Script -->
<style>
    /* Login Modal Styling */
    #login-modal .modal-content {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    #login-modal .modal-header {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        padding: 25px 20px 15px;
        position: relative;
    }

    #login-modal .modal-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
    }

    #login-modal .close {
        font-size: 28px;
        color: #7f8c8d;
        opacity: 1;
        transition: all 0.3s ease;
    }

    #login-modal .close:hover {
        color: #e74c3c;
        transform: scale(1.1);
    }

    /* Modal Image Notice */
    .modal-image {
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .modal-image:hover {
        transform: translateY(-2px);
    }

    .modal-image h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .modal-image p {
        font-size: 14px;
        margin-bottom: 0;
    }

    /* Tab Styling */
    .login-tab .nav-tabs {
        border-bottom: 2px solid #e0e6ed;
        margin-bottom: 20px;
    }

    .login-tab .nav-tabs .nav-link {
        border: none;
        color: #7f8c8d;
        font-weight: 500;
        padding: 10px 20px;
        margin-right: 5px;
        border-radius: 5px 5px 0 0;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .login-tab .nav-tabs .nav-link:hover {
        color: #3498db;
        background-color: rgba(52, 152, 219, 0.1);
        border: none;
        text-decoration: none;
    }

    .login-tab .nav-tabs .nav-link.active {
        color: #3498db;
        background-color: rgba(52, 152, 219, 0.1);
        border: none;
        position: relative;
    }

    .login-tab .nav-tabs .nav-link.active:after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #3498db;
    }

    /* Form Styling */
    #login-modal .form-group {
        margin-bottom: 20px;
    }

    #login-modal .form-control {
        height: 45px;
        border: 1px solid #e0e6ed;
        border-radius: 6px;
        padding: 10px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: none;
    }

    #login-modal .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    #login-modal label.bold {
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
    }

    /* Button Styling */
    #login-modal .btn {
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 15px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .form-control {
        border: 1px solid #d1d9e6;
        /*box-shadow: inset 2px 2px 5px #f0f2f5,*/
        /*inset -2px -2px 5px #ffffff;*/
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2),
            inset 2px 2px 5px #f0f2f5,
            inset -2px -2px 5px #ffffff;
    }

    .btn {
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(52, 152, 219, 0.3);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-outlined-primary {
        background-color: transparent;
        border: 1px solid #3498db;
        color: #3498db;
    }

    .btn-outlined-primary:hover {
        background-color: rgba(52, 152, 219, 0.1);
        box-shadow: 0 4px 8px rgba(52, 152, 219, 0.2);
    }

    #login-modal .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
    }

    #login-modal .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }

    #login-modal .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    #login-modal .btn-outlined-primary {
        background-color: transparent;
        border: 1px solid #3498db;
        color: #3498db;
    }

    #login-modal .btn-outlined-primary:hover {
        background-color: rgba(52, 152, 219, 0.1);
        transform: translateY(-2px);
    }

    #login-modal .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }

    #login-modal .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
        transform: translateY(-2px);
    }

    #login-modal .btn i {
        margin-right: 8px;
        font-size: 14px;
    }

    /* OTP Input Styling */
    .input-field-otp,
    .input-field-otp-office,
    .input-field-otp-admin {
        display: flex;
        column-gap: 10px;
        margin-top: 10px;
    }

    .input-field-otp input,
    .input-field-otp-office input,
    .input-field-otp-admin input {
        height: 50px;
        width: 45px;
        border-radius: 6px;
        outline: none;
        font-size: 18px;
        text-align: center;
        border: 1px solid #e0e6ed;
        transition: all 0.3s ease;
    }

    .input-field-otp input:focus,
    .input-field-otp-office input:focus,
    .input-field-otp-admin input:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    /* Link Styling */
    #login-modal a {
        color: #3498db;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    #login-modal a:hover {
        color: #2980b9;
        text-decoration: none;
    }

    .b-notreg {
        font-size: 14px;
        margin-top: -10px;
    }

    /* Captcha Styling */
    .captcha {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        border: 1px solid #e0e6ed;
    }

    .reload-captcha {
        margin-left: 10px;
        border-radius: 6px;
    }

    .captcha span {
        margin-right: 10px;
    }

    .reload-captcha {
        padding: 5px 10px;
        font-size: 16px;
    }

    /* Text Styling */
    .text-danger {
        color: #e74c3c !important;
    }

    .text-success {
        color: #2ecc71 !important;
    }

    label.bold {
        display: block !important;
        font-weight: 600 !important;
        color: #2c3e50 !important;
        margin-bottom: 8px !important;
        font-size: 14px !important;

        position: relative !important;

    }

    #general_error {
        transition: all 0.3s ease;
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
        #login-modal .modal-dialog {
            margin: 10px;
        }

        .login-tab .nav-tabs .nav-link {
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            color: #5e6e82;
        }

        .input-field-otp input,
        .input-field-otp-office input,
        .input-field-otp-admin input {
            height: 40px;
            width: 35px;
            font-size: 16px;
        }
    }

    /* Animation for OTP inputs */
    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20%,
        60% {
            transform: translateX(-5px);
        }

        40%,
        80% {
            transform: translateX(5px);
        }
    }

    .shake {
        animation: shake 0.5s;
        border-color: #e74c3c !important;
    }
</style>

<div class="modal fade" id="login-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header text-center d-block  border-bottom-0">
                <h6 class="modal-title" id="exampleModalLabel"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;LOGIN
                </h6>
                <button type="button" class="close position-absolute" style="right: 15px; top: 20px;"
                    data-bs-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->

            <div class="modal-body">
                <div class="col-md-12 mb-2 modal-image" style="padding: 10px;">
                    <h3>Please Note:</h3>
                    <p>Use Different tabs for different Stakeholders Login.</p>
                </div>

                <div class="login-tab">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#workerLogin">Worker Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#officialLogin">Official Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#adminLogin">Admin Login</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container active" id="workerLogin">
                            <div id="workeruserloginmsg" class="text-danger"></div>
                            <form id="worker-login-form" action="{{ route('auth.worker') }}" method="POST"
                                style="position: relative">
                                @csrf
                                <div class="form-group mt-4">
                                    <label for="phone_no" class="bold">Worker ID Card No</label>
                                    <input type="text" class="form-control" id="id_card"
                                        placeholder="Please Enter your ID Card No" name="id_card"
                                        value="{{ old('id_card') }}" autocomplete="off">
                                    <span id="otp_sent_message"></span>
                                </div>

                                {{-- new registration and onboarding registration modal open --}}
                                {{-- <span style="font-size: 15px;">Not yet registered on Nirman Sakhi?</span> --}}
                                {{-- <br> --}}
                                {{-- <span>Follow below links to register now.</span> --}}
                                {{-- <div><a href="#" --}}
                                {{-- style="font-size:13px; bottom:8px; color:#0073ec;" --}}
                                {{-- data-bs-toggle="modal" --}}
                                {{-- data-bs-target="#register-modal"> --}}
                                {{-- New Registration --}}
                                {{-- </a></div> --}}
                                {{-- <div> <a href="#" --}}
                                {{-- style="font-size:13px; bottom:8px; color:#0073ec;" --}}
                                {{-- data-bs-toggle="modal" --}}
                                {{-- data-bs-target="#onboardingregister-modal"> --}}
                                {{-- Onboarding Registration --}}
                                {{-- </a></div> --}}


                                {{-- new registration and onboarding registration modal close  --}}

                                <div class="d-flex justify-content-center" id="get_otp_button">
                                    <button type="submit" id="get_otp" class="get_button btn-sm btn btn-primary"><i
                                            class="fas fa-sign-in-alt"></i>&nbspLogin through OTP</button>
                                </div>
                            </form>


                            <div class="" id="otp_form" style="display: none;">
                                <div class="form-group otp">
                                    <label for="phone_no" class="bold">Please Enter OTP</label>
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
                                            class="fas fa-sign-in-alt"></i>&nbspVerify OTP</button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <p id="resend_timer"> Resend OTP in <span id="timer_1" class="text-success">180
                                        </span> Seconds</p>
                                    <button type="button" id="resend_otp"
                                        class="resend_button btn btn-outlined-primary" style="display: none;"
                                        disabled>&nbspResend OTP</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane container fade" id="officialLogin">
                            <div id="officialLogin_form">

                                <form id="office-login-form" action="{{ route('auth.office') }}" method="post"
                                    class="mt-3">
                                    @csrf
                                    <div class="form-group ">
                                        <label for="offusername" class="bold">Username:</label>
                                        <input type="text" class="form-control" id="offusername"
                                            placeholder="Enter Username" name="username"
                                            value="{{ old('username') }}">
                                        <span class="text-danger bold" id=username_error></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="off-login-pwd-1" class="bold">Password:</label>
                                        <input type="password" class="form-control" id="off-login-pwd-1"
                                            onblur="return encryptPassword(2)" placeholder="Enter password"
                                            name="password" autocomplete="off">
                                        <span class="text-danger bold" id=password_error></span>
                                    </div>
                                    <div class="form-group mt-4 mb-4">
                                        <div class="captcha ">
                                            <span
                                                style="margin-right: 10px;float: left;margin-top: 2px;">{!! captcha_img() !!}</span>
                                            <button type="button" class="btn btn-danger reload-captcha">
                                                &#x21bb;
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <input id="offcaptcha" type="text" class="form-control"
                                            placeholder="Enter Captcha" name="captcha">
                                        <span class="text-danger bold" id="captcha_error"></span>
                                    </div>
                                    <p class="text-right b-notreg text-danger">Forgot Password? Click <a
                                            href="{{ route('password.forget-password') }}">Here</a> to reset.</p>
                                    <div id="general_error" style="display:none;"></div>
                                    <div class="d-flex justify-content-center py-4">
                                        <button type="submit" class="btn btn-primary b-btn">Log
                                            In</button>
                                    </div>
                                </form>
                            </div>

                            <div class="" id="otp_form_official" style="display:none">
                                <div class="d-flex justify-content-center py-4">
                                    <p class="text-center">Hi <span class="text-success bold" id="username"></span>,
                                        We have sent you One Time Password to your registered Mobile Number ending with
                                        +91******<span class="text-success bold" id="mobile"></span></p>
                                </div>


                                <div class="form-group otp-office">
                                    <label for="input-field-otp-office" class="bold">Please Enter OTP</label>
                                    <div class="input-field-otp-office">
                                        <input type="number" id="otp_office_1" />
                                        <input type="number" id="otp_office_2" disabled />
                                        <input type="number" id="otp_office_3" disabled />
                                        <input type="number" id="otp_office_4" disabled />
                                        <input type="number" id="otp_office_5" disabled />
                                        <input type="number" id="otp_office_6" disabled />
                                    </div>

                                </div>
                                <div class="d-flex justify-content-center py-4">
                                    <span id="resent_msg_office"></span>
                                </div>
                                <div class="d-flex justify-content-center py-4">

                                    <button type="button" id="verify_otp_office"
                                        class="verify_button_office btn btn-primary"><i
                                            class="fas fa-sign-in-alt"></i>&nbspVerify OTP</button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <p id="resend_timer_office"> Resend OTP in <span id="timer_office_1"
                                            class="text-success">180 </span> Seconds</p>
                                    <button type="button" id="resend_otp_office"
                                        class="resend_office_button btn btn-outlined-primary" style="display: none;"
                                        disabled>&nbspResend OTP</button>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane container fade" id="adminLogin">

                            <div id="adminLogin_form">
                                <form id="admin-login" action="{{ route('auth.admin') }}" method="post"
                                    class="mt-3">
                                    @csrf
                                    <div class="form-group ">
                                        <label for="username" class="bold">Username:</label>
                                        <input type="text" class="form-control" id="username-admin"
                                            placeholder="Enter Username" name="username"
                                            value="{{ old('username') }}">
                                        <span class="text-danger bold" id=username_error_admin></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="login-pwd-1" class="bold">Password:</label>
                                        <input type="password" class="form-control" id="login-pwd-1"
                                            onblur="return encryptPassword(1)" placeholder="Enter password"
                                            name="password" autocomplete="off">
                                        <span class="text-danger bold" id=password_error_admin></span>
                                    </div>
                                    <div class="form-group mt-4 mb-4">
                                        <div class="captcha ">
                                            <span
                                                style="margin-right: 10px;float: left;margin-top: 2px;">{!! captcha_img() !!}</span>
                                            <button type="button" class="btn btn-danger reload-captcha">
                                                &#x21bb;
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <input id="captcha" type="text" class="form-control"
                                            placeholder="Enter Captcha" name="captcha">
                                        <span class="text-danger bold" id="captcha_error_admin"></span>
                                    </div>
                                    <!-- <p class="text-right b-notreg ">Don't have an account? <a href="">Sign Up</a></p> -->
                                    <div class="d-flex justify-content-center py-4">
                                        <button type="submit" class="btn btn-primary b-btn"
                                            id="admin-login-button">Log
                                            In</button>
                                    </div>
                                </form>
                            </div>
                            <div class="" id="otp_form_admin" style="display:none;">
                                <div class="d-flex justify-content-center py-4">
                                    <p class="text-center">Hi <span class="text-success bold"
                                            id="username_admin"></span>, We have sent you One Time Password to your
                                        registered Mobile Number ending with +91******<span class="text-success bold"
                                            id="mobile_admin"></span></p>
                                </div>


                                <div class="form-group otp-admin">
                                    <label for="input-field-otp-admin" class="bold">Please Enter OTP</label>
                                    <div class="input-field-otp-admin">
                                        <input type="number" id="otp_admin_1" />
                                        <input type="number" id="otp_admin_2" disabled />
                                        <input type="number" id="otp_admin_3" disabled />
                                        <input type="number" id="otp_admin_4" disabled />
                                        <input type="number" id="otp_admin_5" disabled />
                                        <input type="number" id="otp_admin_6" disabled />
                                    </div>

                                </div>
                                <div class="d-flex justify-content-center py-4">
                                    <span id="resent_msg_admin"></span>
                                </div>
                                <div class="d-flex justify-content-center py-4">

                                    <button type="button" id="verify_otp_admin"
                                        class="verify_button_admin btn btn-primary"><i
                                            class="fas fa-sign-in-alt"></i>&nbspVerify OTP</button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <p id="resend_timer_admin"> Resend OTP in <span id="timer_admin"
                                            class="text-success"></span> Seconds</p>
                                    <button type="button" id="resend_otp_admin"
                                        class="resend_admin_button btn btn-outlined-primary" style="display: none;"
                                        disabled>&nbspResend OTP</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<!--New Registration Modal Start-->
{{-- @include('components.registration') --}}
<!--New Registration modal end-->

<!--Onboarding Registration Modal Start-->
{{-- @include('components.registrationonboarding') --}}

<form id="resendOtpFrom" action="{{ route('auth.send-otp') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="username" id="username_input">
</form>
