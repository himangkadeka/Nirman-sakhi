@extends('layouts.user-app')

@section('title', 'Renewal')

@section('style')
    <style type="text/css">
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

        .btn-primary {
            background-color: #0f4547;
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
        .table th {
            font-size: 12px;
        }

        .table thead tr {
            border-top: 2px solid #ffc0b4;
        }

        .table thead th {
            border-bottom: 2px solid black;
        }
    </style>
    @endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="col-md-12">

            <nav class="custom-navbar navbar-light p-3" style="border-radius: 20px;">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            <h6 class="custom-heading">Renewal - Construction Worker&nbsp;|&nbsp;পঞ্জীয়ন - নিৰ্মাণ
                                শ্ৰমিক</h6>
                            <h6 class="custom-bold">
                                <i class="custom-icon fas fa-file-alt pr-2"></i>Application No -
                                {{ $application_no }}
                            </h6>
                        </div>
                        {{--                        <div class="custom-right-content"> --}}
                        {{--                            <h6 class="custom-heading"> --}}
                        {{--                                <i class="custom-icon fas fa-clock"></i> Session Uptime - --}}
                        {{--                            </h6> --}}
                        {{--                        </div> --}}
                    </div>
                </div>
            </nav>
            <div class="card mt-1">
                <div class="card-body">

                    <div class="container">
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #248f8f;">
                <span>
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Update Basic Details&nbsp;|&nbsp;মূল বিৱৰণসমূহ আপডেইট কৰক
                </span>
                            </div>

                            <form action="{{route('save-basic-data')}}" class="form-group ml-2 mr-2" method="post" style="background-color: #f9f9f9; padding: 10px; color: #333;">
                                @csrf
                                <input type="hidden" name="worker_id" value="{{$formdata->worker_id}}">
                                <div class="form-row" style="display: flex">
                                    <!--start 1-->
                                    <div class="form-group col-md-12">
                                        <div class="mr-3 mt-3" style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                            <p style="margin: 0;">
                                                <strong>Note:</strong><span class="text-danger"> (*) Marked are mandatory fields /
                                            সকলোবোৰ বাধ্যতামূলক ক্ষেত্ৰ</span>
                                            </p>
                                        </div>

                                        <div class="mt-2 alert alert-info">
                                            <label for="">Resident Type :</label>
                                            <input class="form-check-input mr-2 d-none" type="radio" id="raa"
                                                   name="resident_type" value="raa"
                                                {{ old('resident_type') == 'raa' || $getVaultData['state'] == 'Assam' ? 'checked' : '' }}
                                                {{ $getVaultData['state'] != 'Assam' ? 'disabled' : '' }}>

                                            <input class="form-check-input ml-2 d-none" type="radio" id="rao"
                                                   name="resident_type" value="rao"
                                                {{ old('resident_type') == 'rao' && $getVaultData['state'] != 'Assam' ? 'checked' : '' }}
                                                {{ $getVaultData['state'] == 'Assam' ? 'disabled' : '' }}>

                                            <p style="font-weight:bold">{{ old('resident_type') == 'raa' || $getVaultData['state'] == 'Assam' ? 'Permanent Resident of Assam' : 'Resident Of Other State' }} </p>
                                        </div>
                                        <div class="mt-2" id="state_rao" style="{{ $formdata->resident_type === 'rao' ? 'display: block;' : 'display: none;' }}">
                                            <label for="state" class="bold ml-3">Select State</label><span
                                                style="color:red;">*</span>
                                            <select class="form-control custom-bottom-border state" id="state" name="state_id">--}}
                                                @if($formdata->state_id)
                                                    <option value="{{$formdata->state_id}}">{{$formdata->state_id}}</option>
                                                @else
                                                    <option value="">Select State</option>
                                                @endif
                                                @foreach($states as $state)
                                                    <option value="{{ $state->state_code }}" {{ $formdata->state_id == $state->state_code ? 'selected' : '' }}>{{ $state->state_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state_id')
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @error('resident_type')
                                        <span class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div> <!--end-->
                                <div class="form-row"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputFirstName" class="bold">Full Name</label><span
                                            class="text-danger font-italic font-weight" style="font-size: 12px;">* (As Per Aadhaar)</span>
                                        <input type="text" class="form-control custom-bottom-border" id="firstname"
                                               value="{{ $getVaultData['name'] }}" name="first_name" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputLastName" class="bold">Care Of</label><span
                                            class="text-danger font-italic font-weight" style="font-size: 12px;">* (As Per Aadhaar)</span>
                                        <input type="text" class="form-control custom-bottom-border" id="lastname" value="{{ $getVaultData['careOf'] }}" readonly>

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="gender" class="bold">Gender</label><span
                                            class="text-danger font-italic font-weight" style="font-size: 12px;">* (As Per Aadhaar)</span>
                                        <input type="text" class="form-control custom-bottom-border"   value="{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : ($getVaultData['gender'] == 'T' ? 'Transgender' : 'Unknown')) }}" readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="gender" class="bold">UID No</label><span
                                            class="text-danger font-italic font-weight" style="font-size: 12px;">* (As Per Aadhaar)</span>
                                        <input type="text" class="form-control custom-bottom-border" value="{{ $getVaultData['uID'] }}" readonly>
                                    </div>
                                </div><!--end-->
                                <div class="form-row mt-3"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputDob" class="bold">Date Of Birth</label><span
                                            class="text-danger font-italic font-weight" style="font-size: 12px;">* (As Per Aadhaar)</span>
                                        <input type="text"  class="form-control custom-bottom-border" name="dob" id="dob"  value="{{$getVaultData['dob']}}" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAge" class="bold">Age(In Years)</label>
                                        <input type="text" class="form-control custom-bottom-border" id="age" value="" placeholder="" disabled>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="mStatus" class="bold">Marital Status</label><span style="color:red;">*</span>
                                        <select id="inputState" class="form-control custom-bottom-border" name="maritial_status_id">
                                            <option value="{{$formdata->marital_code}}">{{$formdata->marital_status}} </option>
                                            @foreach ($marital as $key => $mar)
                                                <option value="{{$mar->marital_code}}">{{$mar->marital_status}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('maritial_status_id'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('maritial_status_id') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="inputCategory" class="bold">Category</label><span style="color:red;">*</span>
                                        <select id="inputCategory" class="form-control custom-bottom-border" name="category">
                                            <option value="{{$formdata->category_code}}">{{$formdata->category_name}} </option>
                                            @foreach ($category as $key => $cat)
                                                <option value="{{$cat->category_code}}">{{$cat->category_name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('category') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->
                                <div class="form-row mt-3"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone" class="bold">Phone Number</label><span
                                            class="text-danger">*
                                </span>
                                        <input type="text" class="form-control custom-bottom-border" id="phone" placeholder="{{$formdata->phone_no}}"
                                               disabled>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPF" class="bold">eShram Number(UAN)<span style="color:red;">*</span></label>
                                        <input type="text" class="form-control custom-bottom-border" id="eshram" value="{{$formdata->eshram_no}}" name="eshram_no" placeholder="">
                                        <span class="error" id="eShramError"></span>
                                        @if ($errors->has('eshram_no'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('eshram_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone" class="bold">Education Details</label><span
                                            class="text-danger">*
                                </span>
                                        <select id="inputCategory" class="form-control custom-bottom-border" name="education_id">
                                            <option value="{{$formdata->education_code}}">{{$formdata->education_name}} </option>
                                            @foreach ($education as $key => $edu)
                                                <option value="{{$edu->education_code}}">{{$edu->education_name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('education_id'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('education_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPF" class="bold">Profession</label><span class="text-danger">*</span>
                                        <select id="" name="skill_id" class="form-control custom-bottom-border">
                                            <option value="{{$formdata->skill_code}}">{{$formdata->skill_name}} </option>
                                            @foreach ($skills as $key => $sk)
                                                <option value="{{$sk->skill_code}}">{{$sk->skill_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!--end-->
                                <div class="form-row mt-3"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone" class="bold">Blood Group
                                        </label><span class="text-danger">*</span>
                                        <select id="inputCategory" class="form-control custom-bottom-border"
                                                name="blood_group">
                                            <option value="{{$formdata->id}}">{{$formdata->blood_group}} </option>
                                            @foreach ($blood as $key => $bg)
                                                <option value="{{$bg->id}}">{{$bg->blood_group}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('blood_group'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('blood_group') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEsic" class="bold">Email-Id</label>
                                        <input type="text" class="form-control custom-bottom-border" id="email" value="{{$formdata->email}}" name="email" placeholder="Enter Email Id">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pan_availability" class="bold">Do you have a PAN number?</label><span class="text-danger">*</span>
                                        <select class="form-control custom-bottom-border" id="pan_availability" onchange="showPANField(this.value)" name="pan">
                                            <option value="1" {{ $formdata->pan == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ $formdata->pan == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                        @if ($errors->has('pan'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('pan') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3" id="pan_field" style="{{ $formdata->pan == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="pan_number" class="bold">PAN number</label>
                                        <input type="text" class="form-control custom-bottom-border capital " id="pan_number" value="{{ $formdata->pan_no }}" name="pan_no" placeholder="Enter Your Pan No" maxlength="10">
                                        <span id="panError" class="error"></span>
                                        @if ($errors->has('pan_no'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('pan_no') }}</span>
                                        @endif
                                    </div>
                                    <div class=" form-group col-md-3">
                                        <label for="boc_availability" class="bold">Already registered in other State?</label><span class="text-danger">*</span>
                                        <select class="form-control custom-bottom-border" id="boc_availability" onchange="showBOCField(this.value)" name="boc">
                                            <option value="">Select</option>
                                            <option value="1" {{ $formdata->boc == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ $formdata->boc == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                        @if ($errors->has('boc'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('boc') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3" id="boc_field" style="{{ $formdata->boc == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="boc_number" class="bold">BOCW ID</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control custom-bottom-border capital " id="boc_number" value="{{ $formdata->boc_no }}" name="boc_no" placeholder="Enter Your Pan No" maxlength="10">
                                        <span id="bocError" class="error"></span>
                                        @if ($errors->has('boc_no'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('boc_no') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->
                                <div class="form-row mt-3"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="has_ration_card" class="bold">Do you have a Ration Card?</label><span
                                            class="text-danger">*
                                </span>
                                        <select class="form-control custom-bottom-border" id="has_ration_card"
                                                name="has_ration_card">
                                            <option value="0" {{ $formdata->has_ration_card == '0' ? 'selected' : '' }}>No
                                            </option>
                                            <option value="1" {{ $formdata->has_ration_card == '1' ? 'selected' : '' }}>Yes
                                            </option>
                                        </select>
                                        @error('has_ration_card')
                                        <span class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3" id="ration_details"
                                         style="{{ $formdata->has_ration_card == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="ration_no" class="bold">Ration Card Number</label><span
                                            style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border" id="ration_no"
                                               name="ration_no" placeholder="Enter ration card no"
                                               value="{{ isset($formdata->ration_no) ? $formdata->ration_no : '' }}">
                                        @error('ration_no')
                                        <span class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3" id="ration_type_section"
                                         style="{{ $formdata->has_ration_card == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="ration_type" class="bold">Ration Card Type</label><span
                                            style="color:red;">*</span>
                                        <select class="form-control custom-bottom-border" id="ration_type" name="ration_type">
                                            @if(!empty($formdata->ration_type))
                                                {{-- Preselected option if form is in edit mode --}}
                                                <option value="{{ $formdata->ration_type }}" selected>{{ $formdata->name }}</option>
                                            @else
                                                {{-- Default placeholder option --}}
                                                <option value="" selected>Select</option>
                                            @endif

                                            {{-- Dynamically generated options --}}
                                            @foreach ($ration as $rt)
                                                @if($rt->ration_code != $formdata->ration_type)
                                                    <option value="{{ $rt->ration_code }}">{{ $rt->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('ration_type')
                                        <span class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                        @enderror
                                    </div>


                                </div><!--end-->

                                <div class="row justify-content-center mt-5">

                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Update Basic Details&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

    <link rel="stylesheet" href="{{URL::asset('assets/template/datepicker/jquery-ui.min.css')}}">
    <script src="{{URL::asset('assets/template/datepicker/jquery-3.7.date.js')}}"></script>
    <script src="{{URL::asset('assets/template/datepicker/jquery-ui.min.js')}}"></script>
    <script src="{{URL::asset('assets/template/js/getVaultData.js')}}"></script>
    <script>
        document.getElementById("has_ration_card").addEventListener("change", function() {
            var rationDetails = document.getElementById("ration_details");
            var rationTypeSection = document.getElementById("ration_type_section");
            if (this.value === "1") {
                rationDetails.style.display = "block";
                rationTypeSection.style.display = "block";
            } else {
                rationDetails.style.display = "none";
                rationTypeSection.style.display = "none";
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
            eShramInput.addEventListener('input', function (event) {
                validateField(eShramInput, eShramError);
            });

            pfInput.addEventListener('input', function (event) {
                validateField(pfInput, pfError);
            });

            esicInput.addEventListener('input', function (event) {
                validateField(esicInput, esicError);
            });

            residentOutsideAssamCheckbox.addEventListener('change', function () {
                stateIfResidentOutsideAssam.style.display = residentOutsideAssamCheckbox.checked ? 'block' : 'none';
            });

            workingInAssamCheckbox.addEventListener('change', function () {
                stateIfWorkingInAssam.style.display = workingInAssamCheckbox.checked ? 'block' : 'none';
            });
        });
    </script>

    <script>
        window.onload = function () {
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

            // Update the age input field
            document.getElementById('age').value = age;
        };
    </script>

    <script>
        $(document).ready(function () {
            $.ajax({
                url: 'getskills', // Update the URL based on your route
                type: 'GET',
                success: function (response) {
                    var dropdown = $('#profession');
                    dropdown.empty();
                    dropdown.append('<option value="" selected disabled>Select a profession</option>');

                    $.each(response.skills, function (index, skill) {
                        var option = $('<option></option>').attr('value', skill.id).text(skill.skill_name);
                        dropdown.append(option);
                    });
                },
                error: function (error) {
                    console.error('Error fetching skills:', error);
                }
            });
        });
    </script>

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
    </script>
    <script>
        // JavaScript to show/hide PAN number field based on selection
        function showPANField(value) {
            var panField = document.getElementById('pan_field');
            if (value === '1') {
                panField.style.display = 'block';
            } else {
                panField.style.display = 'none';
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
            if (value === "1") {
                bocField.style.display = "block";
                // Add validation logic here for pan_no
            } else {
                bocField.style.display = "none";
                // Reset validation for pan_no or make it not required
            }
        }
        </script>
 @endsection
