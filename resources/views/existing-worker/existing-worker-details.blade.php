@extends('layouts.user-app')

@section('title', ' Existing Worker')

@section('style')
    <style>
        .otp-inputs {
            display: flex;
            justify-content: space-between;
            width: 220px;
            /* Adjust as needed */
            margin-bottom: 20px;
            /* Add some space below the inputs */
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

        .custom-bordered-box {
            border: 2px solid #dee2e6;
            padding: 20px;
            border-radius: 5px;
        }

        .custom-table {
            width: 100%;
        }

        .custom-table th,
        .custom-table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .custom-table th {
            width: 20%;
            text-align: left;
        }

        .custom-table td {
            width: 30%;
        }

        .custom-bottom-border {
            border-top: none;
            border-right: none;
            border-left: none;
            border-bottom: 1px solid #ced4da;
            /* You can customize the color */
            border-radius: 0;
            /* Remove border-radius if needed */
        }

        ::placeholder {
            font-size: 15px;
            /* You can adjust the font size as needed */
            /* Additional styles if needed */
        }

        .aadhar-input {
            width: 100%;
            /* Adjust the width as needed */
        }

        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }


        label.bold {
            font-weight: 600;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

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

        .white-background {
            background-color: #fff !important;
            color: #000;
            cursor: pointer;
        }

        /* Removes the greyed-out readonly style in some browsers */
        .white-background[readonly] {
            background-color: #fff !important;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid mb-4 mt-2">
        <div class="col-md-12">
            <div class="card mt-1">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                style="background-color: #2badee;">
                                <span>
                                    <i class="fa fa-plus-circle"
                                        aria-hidden="true"></i>&nbsp;{{ trans('worker-registration/verify-worker-details.alreadyregworker') }}
                                </span>
                            </div>
                            <div class="mr-2 mt-3 ml-2"
                                style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-bank-details.note') }}:</strong>
                                </p>
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-bank-details.1') }}.</strong><span
                                        class="text-danger">
                                        {{ trans('worker-registration/worker-bank-details.mandatory') }}</span>
                                </p>

                                {{-- <p style="margin: 0;">
                                    <strong>2.</strong><span class="text-danger"> If no details found after searching your
                                        ID Card, you can enter register now and proceed for next stage.</span>
                                </p> --}}
                            </div>
                            <form action="{{ route('ext-worker-reg') }}"
                                class="form-group ml-2 mr-2 mt-4 form needs-validation" method="post" novalidate>

                                @csrf
                                @if ($errors->has('worker_id'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <span><strong>{{ $errors->first('worker_id') }}</strong></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="row justify-content-md-center mt-2 ml-5">
                                    <div class="form-group col-md-3 col-sm-4 ">
                                        <label for="inputDob"
                                            class="">{{ trans('worker-registration/verify-worker-details.entervalid') }}</label>&nbsp;<span
                                            class="text-danger" style="font-size:20px;">*</span>
                                        <input type="text" class="form-control" name="worker_id" id="id_card_name"
                                            value="{{ old('worker_id') }}" placeholder="Enter your ABOCW ID Card Number"
                                            oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center mb-3">
                                    <button type="button" class="btn btn-sm btn-warning ext-reg"
                                        id="submit-form check-data" aria-label="Proceed">
                                        <i class="fas fa-spinner fa-spin d-none"
                                            id="loading-spinner-already-registered-modal"></i>
                                        &nbsp;Fetch worker data&nbsp;<i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                    <div id="spinner-old" style="display:none;">
                                        <i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Please Wait...
                                    </div>
                                </div>

                                <div class="custom-bordered-box">
                                    <div class="form-row" id="aadhaar_data">
                                        <div class="form-group col-md-3">
                                            <label for="inputFirstName"
                                                class="">{{ trans('worker-registration/verify-worker-details.name') }}</label>
                                            <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                ({{ trans('worker-registration/verify-worker-details.aadhaar') }})</span>
                                            <input type="text" class="form-control" id="aadhaar_name"
                                                value="{{ $uid_data->name }}" name="name" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputLastName"
                                                class="">{{ trans('worker-registration/verify-worker-details.careof') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                ({{ trans('worker-registration/verify-worker-details.aadhaar') }})</span>
                                            <input type="text" class="form-control  uc-text-smooth" id="care_of"
                                                value="{{ $uid_data->careOf }}" name="care_of" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="gender"
                                                class="">{{ trans('worker-registration/verify-worker-details.gender') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                      style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                ({{ trans('worker-registration/verify-worker-details.aadhaar') }})</span>
                                            <input type="text" class="form-control" id="gender"
                                                value="{{ $uid_data->gender == 'M' ? 'Male' : ($uid_data->gender == 'F' ? 'Female' : ($uid_data->gender == 'T' ? 'Transgender' : 'Unknown')) }}"
                                                readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputDob"
                                                class="">{{ trans('worker-registration/verify-worker-details.dob') }}</label>
                                            <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                ({{ trans('worker-registration/verify-worker-details.aadhaar') }})</span>
                                            <input type="text" id="dob" class="form-control" name="dob"
                                                placeholder="" value="{{ $uid_data->dob }}" readonly>
                                        </div>

                                    </div>
                                    <div id="worker-info" class="form-row mt-3" style="display: none;">
                                        <div class="form-group col-md-3">
                                            <label for="inputDob"
                                                class="">{{ trans('worker-registration/verify-worker-details.name') }}</label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" class="form-control changer" name="old_name"
                                                id="worker_name" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputDob"
                                                class="">{{ trans('worker-registration/verify-worker-details.careof') }}</label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" class="form-control changer" name="old_fathers_name"
                                                id="worker_care_of" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputDob"
                                                class="">{{ trans('worker-registration/verify-worker-details.gender') }}</label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" class="form-control changer" name="old_gender"
                                                id="worker_gender" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputDob"
                                                class="">{{ trans('worker-registration/verify-worker-details.dob') }}</label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" class="form-control changer" name="old_dob"
                                                id="worker_dob" readonly>
                                        </div>
                                    </div>
                                </div>



                                <div class="row justify-content-center mt-5">

                                    <div class="col-auto">
                                        <a href="{{ route('home.index') }}" class="btn btn-sm btn-danger">Exit to
                                            Homepage&nbsp; <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" id="saveBtnEx" class="btn btn-sm btn-primary ml-3"
                                            disabled>
                                            Register Now&nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </div>

    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">
                        {{ trans('worker-registration/verify-worker-details.confirmreg') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ trans('worker-registration/verify-worker-details.question') }}
                </div>
                <div class="modal-footer">
                    <a href="{{ route('home.index') }}" type="button" class="btn btn-danger"
                        data-dismiss="modal">Cancel</a>
                    <button type="button" id="confirmBtn" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Proceed with Aadhaar Data Modal -->
    <div class="modal fade" id="proceedWithAadhaarModal" tabindex="-1" role="dialog"
        aria-labelledby="proceedWithAadhaarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="proceedWithAadhaarModalLabel">
                        {{ trans('worker-registration/verify-worker-details.mismatch') }}</h5>

                </div>
                <div class="modal-body">
                    {{ trans('worker-registration/verify-worker-details.mismatchbody') }}<br></br>
                    You can either proceed with this mismatch or update your Aadhaar data, and then submit your
                    application.
                </div>
                <div class="modal-footer">
                    Do you agree to apply now?
                    <button type="button" class="btn btn-danger"
                        id="cancelAadhaarProceed">{{ trans('worker-registration/verify-worker-details.no') }}</button>
                    <button type="button" class="btn btn-success"
                        id="proceedWithAadhaarData">{{ trans('worker-registration/verify-worker-details.yes') }}</button>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('footer')
    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
    <script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>

    <script>
        document.getElementById('saveBtnEx').addEventListener('click', function() {
            // Trigger the form submission
            document.getElementById('saveBtnEx').closest('form').submit();
        });
    </script>
    <script>
        $('.ext-reg').on('click', function(e) {
            e.preventDefault();
            if ($('#id_card_name').val().trim() === '') {
                alert('Please enter BOCW ID Card');
                return;
            }
            $('#spinner-old').show();
            $.ajax({
                url: "{{ route('check-old-worker-exists') }}",
                type: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'worker_id': $("#id_card_name").val(),
                },
                dataType: 'json',
                success: function(response) {
                    // $('#spinner-old').hide();
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error
                        });

                        $('#worker-info').hide();
                        resetWorkerInfo();
                        $('#spinner-old').hide();
                    } else if (response.redirect) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.msg
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    } else {
                        submitForm();
                    }
                },
                error: function(error) {
                    // spinner.addClass('d-none');
                    // $('#spinner-old').hide();
                    console.log('AJAX Error:', error);
                    // Handle error (optional)
                }
            });
        });

        function submitForm() {
            // var spinner = $('#loading-spinner-register-modal');
            // spinner.removeClass('d-none');

            $.ajax({
                url: "http://103.158.205.175/testapi/getOneUser.php",
                type: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id_card': $("#id_card_name").val(),
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'warning',
                            text: "Please fill the blank fields/boxes with the details from your ABOCW ID Card"
                        });
                        $('#worker-info').show();
                    } else if (response.message === "No records found!") {
                        Swal.fire({
                            icon: 'warning',
                            text: "Please fill the blank fields/boxes with the details from your ABOCW ID Card"
                        });
                        $('#worker-info').show();
                        $('#id_card').removeAttr('readonly');
                        $('#worker_name').removeAttr('readonly');
                        $('#worker_care_of').removeAttr('readonly');
                        $('#worker_dob').removeAttr('readonly').replaceWith(`
                            <input id="worker_dob" name="old_dob" class="form-control white-background changer" placeholder="DD-MM-YYYY" />
                        `);
                        flatpickr('#worker_dob', {
                            dateFormat: "d-m-Y",
                            maxDate: "today",
                            defaultDate: "",
                        });
                        $('#worker_gender').removeAttr('readonly');
                        $('#worker_gender').replaceWith(`
                        <select id="worker_gender" class="form-control" name="old_gender">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                    `);
                        $('#worker_age').removeAttr('readonly');
                        $('#spinner-old').hide();
                    } else {
                        // Populate the input fields with the response data
                        $('#worker-info').show();
                        $('#id_card').val(response.id_card).removeAttr('readonly');;
                        $('#worker_name').val(response.Name).removeAttr('readonly');;
                        $('#worker_care_of').val(response.father_husband).removeAttr('readonly');;

                        // Reformat the date to 'DD-MM-YYYY'
                        var dob = response.dob;
                        var parts = dob.split('-');
                        var formattedDob = parts[2] + '-' + parts[1] + '-' + parts[0];
                        $('#worker_dob').val(formattedDob);

                        // Handling gender text
                        var genderText = '';
                        if (response.gender === '1') {
                            genderText = 'Male';
                        } else if (response.gender === '2') {
                            genderText = 'Female';
                        } else {
                            genderText = 'Others';
                        }
                        $('#worker_gender').val(genderText);
                        $('#worker_age').val(response.age);
                        $('#worker-info').show();
                        setSession(response);
                        checkMatchingFields();
                        $('#saveBtnEx').removeAttr('disabled');
                    }
                    $('#spinner-old').hide();
                },
                error: function(error) {
                    console.log('AJAX Error:', error);
                    Swal.fire({
                        icon: 'warning',
                        text: "Please fill the blank fields/boxes with the details from your ABOCW ID Card"
                    });
                    $('#worker-info').show();
                    $('#id_card').removeAttr('readonly');
                    $('#worker_name').removeAttr('readonly');
                    $('#worker_care_of').removeAttr('readonly');
                    $('#worker_dob').removeAttr('readonly').replaceWith(`
                            <input id="worker_dob" name="old_dob" class="form-control white-background changer" placeholder="DD-MM-YYYY" />
                        `);
                    flatpickr('#worker_dob', {
                        dateFormat: "d-m-Y",
                        maxDate: "today",
                        defaultDate: "",
                    });
                    $('#worker_gender').removeAttr('readonly');
                    $('#worker_gender').replaceWith(`
                        <select id="worker_gender" name="old_gender" class="form-control">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            <option value="3">Others</option>
                        </select>
                    `);
                    $('#worker_age').removeAttr('readonly');
                    $('#spinner-old').hide();

                }
            });
        }

        function setSession(data) {

            $.ajax({
                url: "{{ route('set-response-data') }}",
                type: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'data': data,
                },
                dataType: 'json',
                success: function(response) {
                    // $('#spinner-old').hide();
                    console.log(response)

                },
                error: function(error) {
                    // spinner.addClass('d-none');
                    // $('#spinner-old').hide();
                    console.log('AJAX Error:', error);
                    // Handle error (optional)
                }
            });
        }

        function checkMatchingFields() {
            var nameMatches = highlightField('#worker_name', '#aadhaar_name');
            var careOfMatches = highlightField('#worker_care_of', '#care_of');
            var genderMatches = highlightField('#worker_gender', '#gender');
            var workerGender = $('#worker_gender option:selected').text();
            var dobMatches = highlightField('#worker_dob', '#dob');

            if (nameMatches && genderMatches && dobMatches) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'All fields match with Aadhaar data.',
                });
            } else {
                // Show the modal asking if they want to proceed with Aadhaar data
                $('#proceedWithAadhaarModal').modal('show');
            }
        }

        // Handling the "Yes" button in the modal
        document.getElementById('proceedWithAadhaarData').addEventListener('click', function() {
            // Simply dismiss the modal without showing a Swal alert
            $('#proceedWithAadhaarModal').modal('hide');
            // Add further actions here like form submission or other logic if needed
        });

        // Handling the "No" button in the modal
        document.getElementById('cancelAadhaarProceed').addEventListener('click', function() {
            // Hide the modal
            $('#proceedWithAadhaarModal').modal('hide');
            // Show the Swal alert after the modal is dismissed
            Swal.fire({
                icon: 'error',
                title: '{{ trans('worker-registration/verify-worker-details.pleasecorrecttitle') }}',
                text: '{{ trans('worker-registration/verify-worker-details.pleasecorrecttext') }}',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href =
                        '{{ route('home.index') }}'; // Replace with your desired redirect URL
                }
            });
        });

        function highlightField(workerField, aadharField) {
            var workerValue = $(workerField).val().trim();
            var aadharValue = $(aadharField).val().trim();
            var isMatch = false;

            if (workerField === '#worker_dob' || aadharField === '#worker_dob') {
                var workerDateParts = workerValue.split('-');
                var workerFormattedDate = workerDateParts[2] + '-' + workerDateParts[1] + '-' + workerDateParts[0];

                var aadharDateParts = aadharValue.split('-');
                var aadharFormattedDate = aadharDateParts[2] + '-' + aadharDateParts[1] + '-' + aadharDateParts[0];

                isMatch = workerFormattedDate === aadharFormattedDate;
            } else if (workerField === '#worker_gender' || aadharField === '#worker_gender') {
                var genderMap = {
                    '1': 'Male',
                    '2': 'Female',
                    '3': 'Others'
                };
                isMatch = genderMap[workerValue] === aadharValue;
            } else {
                isMatch = workerValue === aadharValue;
            }

            if (!isMatch) {
                $(workerField).addClass('border-danger').removeClass('border-success');
            } else {
                $(workerField).removeClass('border-danger').addClass('border-success');
            }

            return isMatch;
        }


        function resetWorkerInfo() {
            $('#id_card').val('');
            $('#worker_name').val('');
            $('#worker_care_of').val('');
            $('#worker_dob').val('');
            $('#worker_gender').val('');
            $('#worker_age').val('');
        }
    </script>
    <script>
        document.getElementById('dataCorrectCheckbox').addEventListener('change', function() {
            var aadhaarSection = document.getElementById('aadhaarSection');
            if (this.checked) {
                aadhaarSection.style.display = 'flex';
            } else {
                aadhaarSection.style.display = 'none';
            }
        });
    </script>
    <script>
        var token = "{{ csrf_token() }}";
    </script>

    <script>
        $(document).on('change', '.changer', function(e) {
            var workerName = document.getElementById('worker_name');
            var workerCareOf = document.getElementById("worker_care_of");
            var workerDob = document.getElementById("worker_dob");
            var workerGender = document.getElementById("worker_gender");
            var saveBtnEx = document.getElementById("saveBtnEx");

            if (workerName.value !== "" && workerCareOf.value !== "" && workerDob.value !== "" && workerGender
                .value !== "") {
                checkMatchingFields();
                saveBtnEx.removeAttribute('disabled');
                const workerData = {
                    Name: workerName.value,
                    father_husband: workerCareOf.value,
                    dob: workerDob.value,
                    gender: workerGender.value
                };
                setSession(workerData);
            } else {
                saveBtnEx.setAttribute('disabled', 'disabled');
            }
        });
    </script>

@endsection
