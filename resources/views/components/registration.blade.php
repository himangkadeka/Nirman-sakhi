<style>
    /* Add your custom styles here */
    /*.custom-bottom-border {*/
    /*    border-bottom: 2px solid #ced4da;*/
    /*}*/

    .download {
            background-color: #009cdb;
            !important;


        }
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

<div class="modal fade " id="register-modal" tabindex="-1" role="dialog" aria-labelledby="register-modalLabel"
    aria-hidden="true">
    {{-- <div class="modal-dialog modal-dialog-centered modal-xl"> --}}
        <div class="modal-dialog modal-dialog-centered" style="max-width: 80%;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block border-bottom-0 bg-success" >
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('worker-registration/worker_register_form.worker_reg_form') }}</h5>
                <button type="button" class="close position-absolute hide-new" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Page 1: Welcome Message -->




                    <div class="row">

                        <div class="col-md-12 pr-5" style="background-color: #96c3de6d;">
                            <div class="text-left d-block p-2">
                                <h3 class="text-center">
                                    {{ trans('worker-registration/worker_register_form.reg_criteria') }}</h3>


                                <ol>
                                    <li>{{ trans('worker-registration/worker_register_form.criteria_text_new_1') }}
                                    </li>
                                    <li>{{ trans('worker-registration/worker_register_form.criteria_text_new_2') }}
                                    </li>
                                    <li>{{ trans('worker-registration/worker_register_form.criteria_text_new_3') }}
                                    </li>
                                    <li>{{ trans('worker-registration/worker_register_form.criteria_text_new_4') }}
                                    </li>
                                    {{-- <a href="https://eshram.gov.in/" class="text-secondary ">Note: Workers who don’t have eshram can Register here </a> --}}
                                    <li>{{ trans('worker-registration/worker_register_form.criteria_text_new_5') }}
                                    </li>
                                </ol>
                                <span class="text-primary ml-4"
                                    style="">{{ trans('worker-registration/worker_register_form.documents') }}</span>
                                <ol>
                                    <li>{{ trans('worker-registration/worker_register_form.documents1') }}</li>
                                    <li>{{ trans('worker-registration/worker_register_form.documents2') }}</li>
                                    <li>{{ trans('worker-registration/worker_register_form.documents3') }}  <a class="text-primary" href="{{ route('download', '90_day_BOC_work_certificate.pdf') }}">
                                        <button class="btn download btn-sm btn-warning">
                                            <i class="fa fa-download" style="color:white" aria-hidden="true"></i>
                                            <span style="color:white;">Download</span>
                                        </button>
                                    </a></li>



                                    <li>{{ trans('worker-registration/worker_register_form.documents4') }}</li>
                                    <li>{{ trans('worker-registration/worker_register_form.documents5') }}</li>

                                </ol>

                                <div class="px-4"><strong>Note:</strong> Copies of only original documents shall be allowed for scanning and uploading.</div>

                            </div>
                        </div>
                    </div>
                <div class="text-center mt-2">
                    <input type="checkbox" id="terms-checkbox" onchange="toggleButtonNew()">
                    <label for="terms-checkbox">I have read and agree to the Terms and Conditions.</label>
                </div>

                    <!-- Tab panes -->
                    <div class="text-center mt-2">
                        <a href="{{ route('new-register') }}" id="new-register-button"
                           class="btn btn-primary btn-sm text-center disabled-link"
                           style="background-color: #ec6e47; border:1px solid #ec6e47; pointer-events: none; opacity: 0.6;">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;
                            {{ trans('worker-registration/worker_register_form.reg_now') }}
                        </a>


                    </div>
            </div>
        </div>
    </div>
</div>

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
    $('#register-modal').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset'); // Reset all form fields
        $(this).find('form').find('.form-control').removeClass('is-invalid');

    });
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
