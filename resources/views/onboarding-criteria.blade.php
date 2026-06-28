@extends('layouts.user-app')

@section('title', ' Onboarding | Criteria')

@section('style')
<style>
    .services {
        width: 100%;
        min-height: 100vh;
        background: #f7f7f7;
        padding: 50px 0px;
        padding-top:0px
    }

    .badges a:hover {
        text-decoration: none;
        color: var(--hover-color)
    }

    .badges a:last-child:hover {
        color: var(--primary-color);
        cursor: default;
    }

    .services-content {
        margin-top: 35px;
    }

    .services-content h1 {
        font-weight: 600
    }

    .left-content h5 {
        margin: 20px 0px 10px 0px;
        font-weight: 600;
        text-align: left;
        color: #333;

    }

    .content-area {
        display: flex;
        gap: 30px;
        margin-top: 40px;
        position: relative;
    }

    .content-area .left-content {
        flex: 7;
    }

    .content-area .right-content {
        flex: 3;
        height: 400px;
        position: sticky;
        top: 10px;
        padding: 20px;
        border-radius: 10px;
        transition: 0.2s linear;
        border: 1px solid rgb(147, 146, 146);
        border-width: 3px 1px;
    }
    .content-area .right-content:hover{box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);background: linear-gradient(90deg, #ffffff, #f5f6ff);border: 1px solid green; border-width: 3px 1px;}

    .right-content .description {
        margin-top: 20px;
        text-align: justify;
    }

    .right-content .description p:last-of-type {
        font-weight: 600;
        font-size: 18px;
        margin-left: 30px;
    }


    .right-content .description h5 {
        margin-bottom: 10px
    }

    @media (max-width: 768px) {
        .content-area {
            flex-direction: column;
        }

        .content-area .left-content,
        .content-area .right-content {
            flex: none;
            width: 100%;
        }
    }

    .services-process {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
    }

    .services-process h5 {
        font-weight: 600;
        margin-bottom: 20px;
        margin-top: 30px;
    }

    .services-process ul {
        list-style: none;
        counter-reset: list-counter;
        padding: 0;
        border-bottom: 1px solid #d7d7d7;
    }

    .services-process ul li {
        counter-increment: list-counter;
        position: relative;
        padding-left: 38px;
        margin-bottom: 35px;
    }

    .services-process ul li::before {
        content: counter(list-counter);
        position: absolute;
        left: 0;
        line-height: 25px;
        font-weight: 500;
        color: #fff;
        width: 25px;
        height: 25px;
        background: #1367e6;
        border-radius: 50%;
        text-align: center;
        outline: 3px solid #3588bf57;
    }

    .services-process ul li::after {
        content: "";
        position: absolute;
        left: 10px;
        top: 30px;
        width: 4px;
        height: 25px;
        background: black;
        border-radius: 10px;
    }

    .services-process ul li:last-child::after {
        display: none;
    }

    .start-services {
        display: flex;
        justify-content: space-between;
        height: 50px;
        align-items: center;
        border-bottom: 1px solid #d7d7d7;
        padding-bottom: 15px;
    }

    .start-services button {
        border-radius: 5px;
        padding: 7px 15px;
        position: relative;
    }


    .start-services .bi-arrow-right {
        font-size: 20px;
        position: relative;
        top: 3px;
        left: 4px;
    }

    .start-services .bi-file-earmark-arrow-down {
        font-size: 30px;
        cursor: pointer
    }

    .start-services .bi-file-earmark-arrow-down:hover {
        transform: scale(1.2);
        transition: .4s linear;
        color: var(--secondary-color)
    }

    .required-documents {
        border-bottom: 1px solid #d7d7d7;
        padding-bottom: 10px;
    }

    .eligibility-criteria>ol {
        margin-left: 5px;
    }

    .eligibility-criteria ol li {
        margin-bottom: 10px
    }

    .required-documents ul {
        margin-left: 5px;
    }

    .left-content h5 {
        margin-bottom: 20px;
    }

    .eligibility-criteria {
        border-bottom: 1px solid #d7d7d7;
        padding-bottom: 10px;
    }

    .service-duration {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(45%, 1fr));
        gap: 20px;
        margin-top: 30px;
        margin-bottom: 30px;
        border-bottom: 1px solid #d7d7d7;
        padding-bottom: 20px;
    }

    .card {
    border-radius: 15px;
    background: #2196f31c;
    padding: 15px;
}

    .service-duration .card {
        padding: 15px 20px 10px 40px;
        position: relative;
        background: transparent;
        transition: 0.3s;
    }

    .service-duration .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        background: #fff
    }

    .service-duration .card h6 {
        font-weight: 600;
        font-size: 18px;
    }

    .service-duration .card p {
        margin: 0px
    }

    .service-duration .card .bi {
        position: absolute;
        left: 10px;
        font-size: 20px;
        top: 10px;
        color: var(--primary-color);
    }

    .service-duration .card:nth-child(2) p {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 40px;
        font-weight: 500;
    }

    .service-duration .card:nth-child(2) p span {
        animation: fifty 2s linear infinite;
    }
    .newheading img {
    width: 45px;
    height: 45px;
    filter: drop-shadow(3px 3px 1px #fff);
    }
    .newheading h3 {
    font-weight: 700;
    text-align: center;
    color: #0a0b0c;
    text-shadow: -2px -2px 2px rgba(255, 255, 255, .1), 2px 2px 2px rgb(255 255 255);
    }

    @keyframes fifty {
        0% {
            color: initial;
        }

        50% {
            color: #595cfd;
        }

        100% {
            color: #122182;
        }
    }


    .service-duration .card ul {
        margin-left: 20px;
        padding: 0px;
    }

    .accordion-button i {
        font-size: 20px;
        margin-right: 10px;
        color: #3F51B5;
    }

    .eligibility-criteria>ol li {
        text-align: justify;
    }
    .startbtn {
        color: white;
    }
    .newheading {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 10px;
    }
    .card-body {
    background: #fff;
    border-radius: 15px;
    }
    .eligi {background: #f2f2f2;}
    .eligi, .docu, .radiocheck {
    padding: 10px;
    border-radius: 8px;
    border-bottom: 1px solid #7a7a7a;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    transition: 0.4s linear;
    }
    .docu {
    background: #f6f6f6;
    margin-top: 15px;
    }
    .radiocheck {
    background: #f2f2f2;
    margin-top: 15px;
    }
    .eligi:hover, .docu:hover, .radiocheck:hover {
    transform: translateX(-8px);
    }
    .form-check-label {font-size: 19px;}
    .esharam-radio {
    background: #b2ddff;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding: 4px 8px;
    border-radius: 50px;
    text-transform: uppercase;
    outline: 5px solid #d2eaff9c;
    font-size: 9px;
    transition: 0.3s linear;
    }
    .esharam-radio:hover {outline: 8px solid #bddffc9c;}
    .fch {
    width: 500px;
    margin:0 auto;
    display: block;
    margin-bottom: 25px;
    background: linear-gradient(45deg, #e0ecf7a3, transparent);
    }
    .form-check-label {font-size: 19px;}
    input[type="checkbox"], input[type="radio"] {
    transform: scale(1.5);
    margin-top: 9px;
    cursor: pointer;
    }
    .btn {
    border-radius: 50px !important;
    border-bottom: 2px solid #3e3d3d;
    }
    #old-register-button{background: #1367e6;}

    @media (max-width: 768px) {
        .content-area .left-content, .content-area .right-content {
            flex: none;
            width: 100%;
            padding: 0px 15px;
        }
        h1{
            font-size: 22px;
        }
        #btn-onboarding{
            text-align: center;
        }
    .check{
        display: flex
    ;
        align-items: center;
        gap: 15px;
    }
    }
</style>

@endsection


@section('content')
<section class="services">
    <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <div class="container">
                <ol class="breadcrumb bg-light p-2 rounded">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">e-Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">Onboarding Registration</li>
            </ol>
            </div>
        </nav>
    <div class="container">
        

        <!-- Main Content Area -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="newheading">
                            <img src="{{ asset('assets/template/images/onboarding.png') }}"> <h3 class="mb-3">Onboarding</h3>
                        </div>
                    <div class="card-body">
                        <!-- Criteria Heading -->
                        <div class="eligi">
                            <h5 class="text-primary">
                                <i class="bi bi-award"></i> {{ trans('worker-registration/worker_register_form.reg_criteria_onboarding') }}
                            </h5>
                            <ol class="ps-3">
                                <li>{{ trans('worker-registration/worker_register_form.criteria_text_old1') }}</li>
                            </ol>
                        </div>

                        <!-- Required Documents -->
                        <div class="docu">
                            <h5 class="text-primary"><i class="bi bi-suitcase-lg-fill"></i> {{ trans('worker-registration/worker_register_form.documents') }}</h5>
                            <ol class="ps-3">
                                <li>{{ trans('worker-registration/worker_register_form.documents_old1') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old2') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old3') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old4') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old5') }}</li>
                                <li>{{ trans('worker-registration/worker_register_form.documents_old6') }}</li>
                            </ol>
                            <div class="alert alert-warning mt-2">
                                <strong>Note:</strong> Copies of only original documents shall be allowed for scanning and uploading.
                            </div>
                        </div>
                        <div class="radiocheck">
                            <div class="d-flex align-items-center">
                            <h5 class="form-check-label p-3 fw-bold text-primary me-3" style="cursor: pointer;">
                                <i class="bi bi-credit-card"></i> Do you have an e-Shram card?
                            </h5>
                            <div class="esharam-radio">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="eshramRadio" id="eshramYes" onchange="toggleButtonNew()">
                                    <label class="form-check-label" for="eshramYes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="eshramRadio" id="eshramNo" onchange="toggleButtonNew()">
                                    <label class="form-check-label" for="eshramNo">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="eshram-prompt" class="alert alert-warning text-center" style="display: none;">
                            Please register on the e-Shram website first:
                            <a href="https://eshram.gov.in/" target="_blank">https://eshram.gov.in/</a>
                        </div>

                        <!-- Terms & Buttons -->
                        <div class="form-check text-center  bg-light rounded p-3 fch">
                            <label for="terms-checkbox" class="form-check-label d-inline-flex align-items-center fw-bold text-primary" style="cursor: pointer;">
                                <input class="form-check-input me-2" type="checkbox" id="terms-checkbox" onchange="toggleButtonNew()">
                                I have read and agree to the Terms and Conditions.
                            </label>
                        </div>


                        <div class="text-center d-flex justify-content-center align-items-center flex-wrap gap-2 mt-3 mb-3 w-100" id="btn-onboarding" style="gap:10px">
                            <a href="{{ route('check-before-onboarding') }}"
                               id="old-register-button"
                               class="btn btn-sm disabled-link text-white"
                               style="pointer-events: none; opacity: 0.6;"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Proceed to Onboarding
                            </a>

                            <a href="{{ route('home.index') }}" class="btn btn-sm btn-danger"><i class="bi bi-house-door-fill"></i> Exit to Homepage
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
{{--<script>--}}
    {{--function toggleButtonNew() {--}}
        {{--const checkbox = document.getElementById('terms-checkbox');--}}
        {{--const button = document.getElementById('old-register-button');--}}

        {{--if (checkbox.checked) {--}}
            {{--button.classList.remove('disabled-link');--}}
            {{--button.style.pointerEvents = 'auto';--}}
            {{--button.style.opacity = '1';--}}
        {{--} else {--}}
            {{--button.classList.add('disabled-link');--}}
            {{--button.style.pointerEvents = 'none';--}}
            {{--button.style.opacity = '0.6';--}}
        {{--}--}}
    {{--}--}}
{{--</script>--}}
<script>
    function toggleButtonNew() {
        const eshramYes = document.getElementById('eshramYes');
        const eshramNo = document.getElementById('eshramNo');
        const termsCheckbox = document.getElementById('terms-checkbox');
        const newRegisterButton = document.getElementById('old-register-button');
        const eshramPromptDiv = document.getElementById('eshram-prompt');

        if (eshramNo.checked) {
            // Display the Bootstrap alert
            eshramPromptDiv.style.display = 'block';
            // Show the JavaScript confirm dialog
            showEShramPrompt();
        } else {
            eshramPromptDiv.style.display = 'none';
        }

        if (eshramYes.checked && termsCheckbox.checked) {
            newRegisterButton.classList.remove('disabled-link');
            newRegisterButton.style.pointerEvents = 'auto';
            newRegisterButton.style.opacity = '1';
        } else {
            newRegisterButton.classList.add('disabled-link');
            newRegisterButton.style.pointerEvents = 'none';
            newRegisterButton.style.opacity = '0.6';
        }
    }

    function showEShramPrompt() {
        const message = "Please register on the e-Shram website first. Click OK to be redirected.";
        if (window.confirm(message)) {
            window.open("https://eshram.gov.in/", "_blank");
        }
    }
</script>


@section('footer')

@endsection
