<style>
    .download {
        background-color: #009cdb;
        !important;


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

    #sample-2 {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        padding: 0 18px;
        height: 340px;
    }

    #sample-2 div {
        flex: 1;
    }

    #sample-2 div img {
        width: 96%;
        border: 2px dashed #ccc;
        border-color: green;
        padding: 5px;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        border-radius: 10px;
        float: right;
    }

    #sample-2 div:nth-child(2)>img {
        width: 57%;
        transform: rotate(-90deg) translate(31%, 24%);
        float: left;
    }

    p.areyou {

        padding-bottom: 5px;
        width: fit-content;
        margin-bottom: 10px;
        font-weight: 500;
        color: green;
        font-size: 18px;
    }

    p.areyou1 {

        margin-top: 0px;
        padding-bottom: 10px;
        width: fit-content;
        margin-bottom: 10px;
        font-weight: 500;
        color: green;
        border-bottom: 1px solid #959393;
    }

    .sample-btn {
        width: 100%;
        text-align: center;
        margin-bottom: 20px;
    }


    @media(max-width: 768px) {
        #exampleModalLabel{font-size: medium;text-align: center}
        #sample-2 {
            flex-direction: column;
            height: 100%;
        }

        #sample-2 div:nth-child(2)>img {
            width: 60%;
            transform: rotate(-90deg) translate(22%, 23%);
        }

        .sample-msg {
            padding: 5px;
        }

        #sample-2 div:nth-child(2) {
            max-height: 230px;
        }

        .sample-btn {
            position: relative;
            top: 0px;
        }
    }

    p.msg-sample {
        margin-bottom: 10px;
        font-weight: 500;
        color: black;
        font-size: 15px;
        text-align: center;
        display: block;
    }

    p.msg-sample1 {
        border-bottom: 1px solid #959393;
        padding-bottom: 15px;
        /* margin-bottom: 20px; */
        font-weight: bold;
        color: black;
        font-size: 13px;
        text-align: center;
        display: block;
    }

    .yesno {
        text-decoration: underline
    }

    .blink {
        animation: blink 1s infinite;
        /* 1s duration, infinite loop */
        font-size: 32px;
        font-weight: bold;
        color: red;
    }

    @keyframes blink {
        0% {
            color: black;
        }

        50% {
            color: red;
        }

        100% {
            color: black;
        }
    }
    .areyou, .areyou1{font-size: 14px;}
</style>

<div class="modal fade" id="initiating-modal" tabindex="-1" role="dialog" aria-labelledby="initiating-modal-modalLabel"
    aria-hidden="true">
    {{-- <div class="modal-dialog modal-dialog-centered modal-xl"> --}}
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="background:#2196f3">
                <h5 class="modal-title text-white" id="exampleModalLabel" style="font-weight: 500;"> <img
                        src="{{ asset('assets/template/images/worker.png') }}" class="preworker"> Pre-Registered
                    (Onboarding) Worker Check and Registration
                    Process</h5>
                <button type="button" class="close position-absolute hide-new" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body p-3">
                <!-- Page 1: Welcome Message -->




                <div class="row">

                    <div class="d-block">
                        <p class="areyou"><i class="bi bi-patch-question-fill"></i> &nbsp; Are You a registered worker
                            of Assam BOCW Board, and you have either of these
                            types of ID Cards ?</p>
                        <p class="areyou1"><i class="bi bi-patch-question-fill"></i> &nbsp; আপুনি অসম বিল্ডিং আৰু
                            অন্যান্য নিৰ্মাণ শ্ৰমিক কল্যাণ ব'ৰ্ড ৰ পঞ্জীয়নভুক্ত
                            শ্ৰমিক হয় নেকি, আৰু এই ধৰণৰ যিকোনো আইডি কাৰ্ড আছে নেকি?</p>

                    </div>
                </div>
            </div>
            <div id="sample-2">
                <div><img src="{{ asset('assets/template/images/demo2.jpg') }}" alt="Image 1"></div>
                <div><img src="{{ asset('assets/template/images/bocw-sample-card.jpg') }}" alt="Image 1"></div>
            </div>
            <div class="sample-msg">
                <p class="msg-sample blink">If You have these type of card Click on <span class="yesno">YES</span>
                    otherwise
                    click <span class="yesno">NO</span></p>
                <p class="msg-sample1 blink">যদি আপোনাৰ হাতত এই ধৰণৰ কাৰ্ড আছে তেন্তে YES ত ক্লিক কৰক অন্যথা NO ক্লিক
                    কৰক</p>
            </div>
            <div class="sample-btn">


                <button type="button" class="btn btn-success" id="question-2-yes" data-dismiss="modal">Yes&nbsp;<i
                        class="fa fa-check-circle" aria-hidden="true"></i></button>

                <a href="{{ route('home.new-registration-criteria') }}" class="btn btn-danger ml-2">No&nbsp;<i
                        class="fa fa-times-circle-o" aria-hidden="true"></i></a>
            </div>

            {{--                <div class="row"> --}}
            {{--                    <div class="col-md-6"> --}}
            {{--                        <img src="{{ asset('assets/template/images/demo2.jpg') }}" alt="Image 1" width="100%"> --}}
            {{--                    </div> --}}
            {{--                    <div class="col-md-6"> --}}
            {{--                        <img src="{{ asset('assets/template/images/bocw-sample-card.jpg') }}" alt="Image 1" id="sample-2"> --}}
            {{--                    </div> --}}
            {{--                </div> --}}

            <!-- Tab panes -->
            {{--                <div class="text-center mt-2"> --}}
            {{--                    <a href="{{ route('new-register') }}" id="new-register-button" --}}
            {{--                       class="btn btn-primary btn-sm text-center disabled-link" --}}
            {{--                       style="background-color: #ec6e47; border:1px solid #ec6e47; pointer-events: none; opacity: 0.6;"> --}}
            {{--                        <i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp; --}}
            {{--                        {{ trans('worker-registration/worker_register_form.reg_now') }} --}}
            {{--                    </a> --}}


            {{--                </div> --}}
        </div>
    </div>
</div>
<div class="modal fade" id="consentOnboarding" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-3">
            <div class="modal-header p-0 mb-3">
                <div class="d-flex">
                    <h5 class="modal-title" id="accountDetailsLabel">Confirmation</h5>
                    {{-- <img src="{{ URL::asset('assets/template/images/confirmation.png') }}" alt="Confirmation image"
                        style="width:35px;margin:15px"> --}}
                    <i class="bi bi-check-circle" style="font-size: 25px;color:green;margin-left:7px"></i>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You need to apply through the Onboarding registration process. Proceed to go to the
                    Onboarding registration page.
                </p>
            </div>
            <div class="modal-footer">
                @if (session()->has('pfcData'))
                    <a href="https://sewasetu.assam.gov.in/iservices/myapplications/list" class="btn btn-primary">Return
                        To Sewasetu Portal for Onboarding </a>
                @else
                    <a href="{{ route('home.onboarding-criteria') }}" class="btn btn-primary">Proceed to Onboarding
                        &nbsp; <i class="fa fa-paper-plane"></i></a>
                @endif
                <button type="submit" id="cancel-btn" class="btn btn-danger">Cancel &nbsp; <i
                        class="bi bi-x-lg"></i></button>
            </div>

        </div>
    </div>
</div>

{{-- </script> --}}


<script>
    $('#initiating-modal').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset'); // Reset all form fields
        $(this).find('form').find('.form-control').removeClass('is-invalid');

    });
</script>
<script>
    $("#cancel-btn").on('click', function() {
        $('#initiating-modal').modal('show');
        $('#consentOnboarding').modal('hide');
    })
</script>
<script>
    $(document).ready(function() {
        // Hide modal on page load
        $('#consentOnboarding').modal('hide');

        // Open modal when button is clicked
        $("#question-2-yes").on('click', function() {
            $("#languageModal").hide();
            $("#initiating-modal").modal('hide');
            $('#consentOnboarding').modal('show');
        });
    });
</script>

<script>
    $("#question-no").on('click', function() {
        $('#register-modal').modal('show');
    })
</script>


<script>
    function toggleButtonNew() {
        const checkbox = document.getElementById('terms-checkbox');
        const button = document.getElementById('new-register-button');

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
    var token = "{{ csrf_token() }}";
</script>
