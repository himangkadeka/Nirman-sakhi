@extends('layouts.user-app')

@section('title', ' Home')

@section('style')
    <style>
        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }

        /*label.bold {*/
        /*    font-weight: 500;*/
        /*    font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;*/

        /*}*/

        .btn-primary {
            background-color: #0f4547;
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
            font-size: 11px;
        }

        .custom-bold {
            font-weight: bold;
        }

        .custom-icon {
            color: #007bff;
        }

        .upload-container {
            text-align: center;
        }

        .upload-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        .upload-label:hover {
            background-color: #0056b3;
        }

        .upload-label i {
            font-size: 20px;
        }

        .upload-input {
            display: none;
        }

        .file-name {
            margin-top: 10px;
            font-size: 14px;
            color: #333;
        }
    </style>
@endsection


@section('content')

    @include('components.multistep')
    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            @include('components.session-timeout')
                        </div>

                    </div>
                </div>
            </nav>

            <div class="card mt-1">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ trans('worker-registration/worker-family-details.workername') }}
                                - {{ $getVaultData['name'] }}
                            </span>
                        </div>
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                style="background-color: #2badee;">
                                <span>
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Update Office Applying for&nbsp;
                                    (Onboarding)
                                </span>

                            </div>

                            <form method="POST" action="{{ route('update-existing-office-address') }}" class="p-2">
                                @csrf
                                <div class="form-group col-md-6">
                                    <label>Select District<span class="text-danger">*</span></label>
                                    <select class="form-control" id="district_code_edit" name="district_id" required>
                                        <option value="">--Select District--</option>
                                        @foreach ($dists as $district)
                                            <option value="{{ $district->district_code }}">
                                                {{ $district->district_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Select Office<span class="text-danger">*</span></label>
                                    <select name="office_id" class="form-control" id="office_id_edit" required>
                                        <option value="">
                                            {{ trans('worker-registration/worker_new_registration.select_office') }}
                                        </option>
                                    </select>
                                </div>


                                <div class="row justify-content-center mt-4">

                                    <div class="col-auto">
                                        <button type="submit"
                                            class="btn btn-sm btn-primary">Update Office <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Left side columns -->
    </div>
    </div>
    @include('components.assamese-keyboard')
@endsection


@section('footer')

    <link rel="stylesheet" href="{{ URL::asset('assets/template/datepicker/jquery-ui.min.css') }}">
    <script src="{{ URL::asset('assets/template/datepicker/jquery-3.7.date.js') }}"></script>
    <script src="{{ URL::asset('assets/template/datepicker/jquery-ui.min.js') }}"></script>
    {{--    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script> --}}
    <script>
        document.getElementById('file-upload').addEventListener('change', function(event) {
            const fileInput = event.target;
            const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : "No file chosen";
            document.querySelector('.file-name').textContent = fileName;

            const file = fileInput.files[0];

            if (file && file.type === "application/pdf") {
                const fileURL = URL.createObjectURL(file);
                document.getElementById('file-preview').src = fileURL;

                // Show preview button
                document.getElementById('preview-btn').style.display = 'inline-block';

                // Automatically open the Bootstrap modal
                const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
                previewModal.show();
            } else {
                alert("Please upload a valid PDF file.");
                document.getElementById('preview-btn').style.display = 'none';
            }
        });

        // Handle discard action
        document.querySelector('.decline-btn').addEventListener('click', function() {
            const fileInput = document.getElementById('file-upload');
            fileInput.value = ""; // Clear the file input
            document.querySelector('.file-name').textContent = "No file chosen"; // Reset file name display
            document.getElementById('file-preview').src = ""; // Remove preview
            document.getElementById('preview-btn').style.display = 'none'; // Hide preview button
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#alreadyPaymentStatus').on('change', function() {
                let selectedValue = $(this).val();

                if (selectedValue == "0") { // If "No" is selected
                    $.ajax({
                        url: "{{ route('update-previous-payment-details') }}",
                        type: "GET",
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    title: "Success!",
                                    text: response.result,
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Error: " + response.result,
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: "Oops!",
                                text: "Something went wrong. Please try again.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                }
                if (selectedValue == "1") { // If "No" is selected
                    $.ajax({
                        url: "{{ route('update-payement-details') }}",
                        type: "GET",
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    title: "Success!",
                                    text: response.result,
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Error: " + response.result,
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: "Oops!",
                                text: "Something went wrong. Please try again.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.change-route').change(function() {
                let selectedValue = $(this).val();
                let workerId = $('#workerId').val();

                // console.log("Sending Data:", { route: selectedValue, worker_id: workerId });

                $.ajax({
                    url: "{{ route('change-route') }}",
                    type: "POST",
                    data: {
                        route: selectedValue,
                        worker_id: workerId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        window.location.href = response.redirectUrl;
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById("has_ration_card").addEventListener("change", function() {
            var rationDetails = document.getElementById("ration_details");
            var rationNumber = document.getElementById("ration_no")
            var rationTypeSection = document.getElementById("ration_type_section");
            var rationType = document.getElementById("ration_type");
            if (this.value === "1") {
                rationDetails.style.display = "block";
                rationTypeSection.style.display = "block";
            } else {
                rationNumber.value = '';
                rationType.value = 'empty';
                rationDetails.style.display = "none";
                rationTypeSection.style.display = "none";

            }
        });
    </script>
    <script>
        window.onload = function() {
            // Get the date of birth value
            var dob = document.getElementById('dob').value;

            // Split the date into its components
            var dobComponents = dob.split('-');

            // Check if the date format is yyyy or dd-mm-yyyy
            var yearIndex = dobComponents.length === 1 ? 0 : 2;

            // Extract the year from the date of birth
            var year = dobComponents[yearIndex];

            // Calculate the current year
            var currentYear = new Date().getFullYear();

            // Calculate the age
            var age = currentYear - parseInt(year, 10);


            document.getElementById('age').value = age;


            var retirementYear = parseInt(year, 10) + 60;


            var retirementDate;
            if (dobComponents.length === 1) {
                // If the date format is yyyy
                retirementDate = new Date(retirementYear, 0, 1); // January 1st of the retirement year
            } else {
                // If the date format is dd-mm-yyyy
                var month = dobComponents[1] - 1; // Months are 0-based in JavaScript Date
                var day = dobComponents[0];
                retirementDate = new Date(retirementYear, month, day);
            }

            var day = String(retirementDate.getDate()).padStart(2, '0');
            var month = String(retirementDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            var year = retirementDate.getFullYear();
            var formattedRetirementDate = `${day}-${month}-${year}`;

            // Update the retirement date input field
            document.getElementById('retirement_date').value = formattedRetirementDate;

        };
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const residentOutsideAssamCheckbox = document.getElementById('resident_of_other');
            const stateIfResidentOutsideAssam = document.getElementById('roo_statement');
            const workingInAssamCheckbox = document.getElementById('resident_of_assam');
            const stateIfWorkingInAssam = document.getElementById('roa_statement');
            const eShramInput = document.getElementById('eShram');
            const pfInput = document.getElementById('pf_no');
            const esicInput = document.getElementById('esic_no');

            const pfError = document.getElementById('pfError');
            const esicError = document.getElementById('esicError');
            const eShramError = document.getElementById('eShramError');

            function validateField(input, errorElement) {
                if (!/^\d*$/.test(input.value)) {
                    errorElement.textContent = '⚠ Must contain only numeric values';
                    return false;
                } else {
                    errorElement.textContent = '';
                    return true;
                }
            }
            eShramInput.addEventListener('input', function(event) {
                validateField(eShramInput, eShramError);
            });

            pfInput.addEventListener('input', function(event) {
                validateField(pfInput, pfError);
            });

            esicInput.addEventListener('input', function(event) {
                validateField(esicInput, esicError);
            });

            residentOutsideAssamCheckbox.addEventListener('change', function() {
                stateIfResidentOutsideAssam.style.display = residentOutsideAssamCheckbox.checked ? 'block' :
                    'none';
            });

            workingInAssamCheckbox.addEventListener('change', function() {
                stateIfWorkingInAssam.style.display = workingInAssamCheckbox.checked ? 'block' : 'none';
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'getskills', // Update the URL based on your route
                type: 'GET',
                success: function(response) {
                    var dropdown = $('#profession');
                    dropdown.empty();
                    dropdown.append('<option value="" selected disabled>Select a profession</option>');

                    $.each(response.skills, function(index, skill) {
                        var option = $('<option></option>').attr('value', skill.id).text(skill
                            .skill_name);
                        dropdown.append(option);
                    });
                },
                error: function(error) {
                    console.error('Error fetching skills:', error);
                }
            });
        });
    </script>
    {{--
    <script>
        $(document).ready(function() {
            // Show/hide the state dropdown based on the selected radio button
            $('input[name="resident_type"]').change(function() {
                if ($(this).val() === 'rao' || $(this).val() === 'ars') {
                    $('#state_rao').show();
                } else {
                    $('#state_rao').hide();
                }
            });

            // Capture the value of 'resident_type' when the form is submitted
            $('form').submit(function() {
                $('#resident_type').val($('input[name="resident_type"]:checked').val());
            });
        });
    </script> --}}
    <script>
        // JavaScript to show/hide PAN number field based on selection
        function showPANField(value) {
            var panField = document.getElementById('pan_field');
            var panNumber = document.getElementById('pan_number')
            if (value === '1') {
                panField.style.display = 'block';
            } else {
                panField.style.display = 'none';
                panNumber.value = ''
            }
        }

        // Trigger the function on page load to handle pre-selected option
        document.addEventListener('DOMContentLoaded', function() {
            var selectedOption = document.getElementById('pan_availability').value;
            showPANField(selectedOption);
        });
    </script>
    <script>
        function showBOCField(value) {
            var bocField = document.getElementById("boc_field");
            var bocNumber = document.getElementById("boc_number");

            if (value === "1") {
                bocField.style.display = "block";
                bocNumber.style.display = "block";
                // Add validation logic here for pan_no
            } else {
                bocField.style.display = "none";
                bocNumber.style.display = "none";
                bocNumber.value = ""
                // Reset validation for pan_no or make it not required
            }
        }
    </script>


@endsection
