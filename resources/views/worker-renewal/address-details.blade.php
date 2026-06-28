@extends('layouts.user-app')

@section('title', ' Renewal | Address')

@section('style')
    <style>
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
{{--    @include('components.multistep')--}}

    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light p-3" style="border-radius: 20px;">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            <h6 class="custom-heading">Registration - Construction Worker&nbsp;|&nbsp;পঞ্জীয়ন - নিৰ্মাণ
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
                    <div class="container-fluid">
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                 style="background-color: #248f8f;">
                                <span>
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Update Address
                                    Details&nbsp;|&nbsp;ঠিকনাৰ বিৱৰণ আপডেইট কৰক
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i> Worker Name - {{ $getVaultData['name'] }}
                                </span>
                            </div>
                            <div class="mr-2 mt-3 ml-2"
                                 style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                <p style="margin: 0;">
                                    <strong>Note:</strong><span class="text-danger"> (*) Marked are mandatory fields /
                                        সকলোবোৰ বাধ্যতামূলক ক্ষেত্ৰ</span>
                                </p>
                            </div>

                            <form action="{{ route('save-residential-details') }}" class="ml-2 mr-2" method="post">
                                @csrf
                                <div class="mt-3" style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                    <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                        Permanent Address
                                    </span>
                                        <span style="color: #495057; margin-left: 8px;">| স্থায়ী ঠিকানা:</span>
                                    </h5>
                                    <div class="form-row mt-5"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputFirstName" class="bold">State</label><span
                                                class="text-danger font-italic font-weight" style="font-size: 12px;">* (As
                                            Aadhaar)</span>
                                            <input type="text" class="form-control custom-bottom-border" id="p_state"
                                                   value="{{ $getVaultData['state'] ?? 'NA' }}" readonly>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputLastName" class="bold">District</label><span
                                                class="text-danger font-italic font-weight" style="font-size: 12px;">* (As
                                            Aadhaar)</span>
                                            <input type="text" class="form-control custom-bottom-border" id="p_Dist"
                                                   value="{{ $getVaultData['district'] ?: 'NA' }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPassword4" class="bold">Subdistrict</label><span
                                                class="text-danger font-italic font-weight" style="font-size: 12px;">* (As
                                            Aadhaar)</span>
                                            <input type="text" class="form-control custom-bottom-border"
                                                   value="{{ $getVaultData['subDistrict'] ?: 'NA' }}" id="p_subD" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="permanentRoad" class="bold">Post Office</label><span
                                                class="text-danger font-italic font-weight" style="font-size: 12px;">* (As
                                            Aadhaar)</span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   id="p_post" value="{{ $getVaultData['postOffice'] ?: 'NA' }}" readonly>
                                            <span id="p_roadError" class="error"></span>
                                        </div>

                                    </div>

                                    <div class="form-row mt-3"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputMstatus" class="bold">Area|Village</label><span
                                                class="text-danger font-italic font-weight" style="font-size: 12px;">* (As
                                            Aadhaar)</span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   placeholder="Enter city" id="p_area_vill"
                                                   value="{{ $getVaultData['village'] ?: 'NA' }}" readonly>
                                        </div>



                                        <div class="form-group col-md-3">
                                            <label for="gender" class="bold">Street</label><span
                                                class="text-danger font-italic font-weight" style="font-size: 12px;">* (As
                                            Aadhaar)</span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   id="p_street" name="p_area" value="{{ $getVaultData['street'] ?: 'NA' }}"
                                                   placeholder="Enter area" readonly>
                                            <span id="p_areaError" class="error"></span>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputDob" class="bold">Locality</label><span
                                                class="text-danger font-italic font-weight" style="font-size: 12px;">* (As
                                            Aadhaar)</span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   id="p_locality" value="{{ $getVaultData['locality'] ?: 'NA' }}"
                                                   placeholder="Enter area" readonly>

                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="inputAge" class="bold">Landmark</label><span
                                                class="text-danger font-italic font-weight" style="font-size: 12px;">* (As
                                            Aadhaar)</span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   id="p_landmark" name="p_area" value="{{ $getVaultData['landMark'] ?: 'NA' }}"
                                                   placeholder="Enter area" readonly>
                                        </div>

                                    </div>


                                    <div class="form-row mt-3"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputAge" class="bold">Pin Code&nbsp;|&nbsp;পিন ক'ড</label><span
                                                class="text-danger font-italic font-weight" style="font-size: 12px;">* (As
                                            Aadhaar)</span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   id="p_pin" name="p_area" value="{{ $getVaultData['pinCode'] ?: 'NA' }}"
                                                   placeholder="Enter area" readonly>
                                            @if ($errors->has('p_circle'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('p_circle') }}</span>
                                            @endif
                                        </div>


                                    </div><!--end-->
                                </div>


                                <!--spinner -->
                                <div class=" d-flex justify-content-center align-items-center mb-4 mt-3">

                                    <div class="">
                                        <div class="d-flex align-items-center" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                            <input type="hidden" name="do" value="0">
                                            <input class="ml-3" type="checkbox" name="do" value="1"
                                                   class="form-check-input styled-checkbox"
                                                {{ $formdata->do == 1 ? 'checked' : '' }}>
                                            <label for="copyAddressCheckbox" class="ml-3 mr-3 mb-0">
                                                <span style="font-size: 1rem; font-weight: 600; color: #495057;">Copy Permanent Address as Present Address</span>
                                                <br>
                                                <span style="font-size: 0.875rem; color: #6c757d;">স্থায়ী ঠিকনাক বৰ্তমান ঠিকনা হিচাপে কপি কৰক</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-3" style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Present Address
                                        </span>
                                        <span style="color: #495057; margin-left: 8px;">| বৰ্তমানৰ ঠিকনা:</span>
                                    </h5>
                                    <div class="form-row mt-5"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="currentResidence" class="bold">Type Of
                                                Residence&nbsp;|&nbsp;বাসস্থানৰ ধৰণ </label><span style="color:red;">*</span>
                                            <select class="form-control custom-bottom-border" name="c_residence"
                                                    id="currentResidence">

                                                <option value="{{ $formdata->c_residence }}">{{ $formdata->residence_name }}
                                                </option>
                                                @foreach ($residence as $key => $res)
                                                    <option value="{{ $res->residence_code }}">{{ $res->residence_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('c_residence'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_residence') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputLastName" class="bold">Type Of House&nbsp;|&nbsp;ঘৰৰ
                                                ধৰণ</label><span style="color:red;">*</span>
                                            <select class="form-control custom-bottom-border" name="c_house_type"
                                                    id="currentHouse">
                                                <option value="{{ $formdata->c_house_type }}">{{ $formdata->house_type }}
                                                </option>
                                                @foreach ($house as $key => $hs)
                                                    <option value="{{ $hs->house_code }}">{{ $hs->house_type }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('c_house_type'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_house_type') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPassword4" class="bold">House No&nbsp;|&nbsp;ঘৰৰ নম্বৰ </label>
                                            <input type="text" class="form-control custom-bottom-border"
                                                   id="currentBuilding" name="c_house_no" placeholder="Enter house/building no"
                                                   value="{{ $formdata->c_house_no }}">
                                            <span class="error" id="c_houseError"></span>
                                            @if ($errors->has('c_house_no'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_house_no') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="gender" class="bold">Area|Village&nbsp;|&nbsp;এলেকা|গাঁও
                                            </label><span style="color:red;">*</span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   id="currentArea" name="c_area" value="{{ $formdata->c_area }}"
                                                   placeholder="Enter area">
                                            <span id="areaError" class="error"></span>
                                            @if ($errors->has('c_area'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_area') }}</span>
                                            @endif
                                        </div>
                                    </div><!--end-->

                                    <div class="form-row mt-3"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="currentCity"
                                                   class="bold">Locality&nbsp;|&nbsp;স্থানীয়তা</label><span
                                                style="color:red;">*</span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   name="c_city" id="currentCity" value="{{ $formdata->c_city }}"
                                                   placeholder="Enter city">
                                            <span id="c_cityError" class="error"></span>
                                            @if ($errors->has('c_city'))
                                                <span
                                                    class="text-danger font-weight normal error-message">{{ $errors->first('c_city') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="road" class="bold">Road&nbsp;|&nbsp;পথ</label>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   id="currentRoad" name="c_road" value="{{ $formdata->c_road }}"
                                                   placeholder="Enter road">
                                            <span id="c_roadError" class="error"></span>
                                            @if ($errors->has('c_road'))
                                                <span
                                                    class="text-danger font-weight normal error-message">{{ $errors->first('c_road') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputDob" class="bold">State&nbsp;|&nbsp;ৰাজ্য </label><span
                                                style="color:red;">*</span>
                                            <input type="text" class="form-control custom-bottom-border state"
                                                   data-id="c" id="currentState" name="c_state" placeholder="Enter State"
                                                   value="{{ $formdata->c_state }}">
                                            @if ($errors->has('c_state'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_state') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputAge" class="bold">District&nbsp;|&nbsp;জিলা</label>
                                            <input type="text" class="form-control custom-bottom-border dist"
                                                   data-id="c" id="currentDist" name="c_district"
                                                   placeholder="Enter District" value="{{ $formdata->c_district }}">
                                            @if ($errors->has('c_district'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_district') }}</span>
                                            @endif
                                        </div>
                                    </div><!--end-->
                                    <div class="form-row mt-3"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputAge" class="bold">Revenue Circle&nbsp;|&nbsp;ৰাজহ চক্ৰ </label>
                                            <input type="text" class="form-control custom-bottom-border circle"
                                                   data-id="c" id="currentCircle" name="c_circle"
                                                   placeholder="Enter Revenue Circle" value="{{ $formdata->c_circle }}">
                                            @if ($errors->has('c_circle'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_circle') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputCategory" class="bold">Post
                                                Office&nbsp;|&nbsp;ডাকঘৰ</label><span style="color:red;">*</span>
                                            <input type="text" class="form-control custom-bottom-border post"
                                                   data-id="c" id="currentPost" name="c_post_office"
                                                   placeholder="Enter Post Office" value="{{ $formdata->c_post_office }}">
                                            @if ($errors->has('c_post_office'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_post_office') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">Pin Code&nbsp;|&nbsp;পিন ক'ড</label>
                                            <input type="text" class="form-control custom-bottom-border pin"
                                                   id="currentPin" data-id="c" name="c_pin"
                                                   value="{{ $formdata->c_pin }}" placeholder="Enter pin code" maxlength="6">
                                            @if ($errors->has('c_pin'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_pin') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">Landmark&nbsp;|&nbsp;ল্যাণ্ডমাৰ্ক</label>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   name="landmark" id="landmark" value="{{ $formdata->landmark }}"
                                                   placeholder="Enter landmark">
                                            @if ($errors->has('landmark'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('landmark') }}</span>
                                            @endif
                                        </div>

                                    </div><!--end-->
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                    <div class="ml-auto d-inline-block align-self-center mr-2">
{{--                                        <a type="submit" href="{{ route('renewal-homepage') }}"--}}
{{--                                           class="btn btn-sm btn-warning"><i class="fa fa-backward"--}}
{{--                                                                             aria-hidden="true"></i>&nbsp;--}}
{{--                                            Previous</a>--}}
                                        <button type="submit" class="btn btn-sm btn-primary"><i
                                                class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                            Update Residential Details</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
            <!-- Modal -->
        </div>
    </div>

@endsection


@section('footer')


    <script src="{{ URL::asset('assets/template/vendor/jquery/ajax-jquery-3.7.min.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/getgetVaultData.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('copyAddressCheckbox');
            if (checkbox.checked) {
                copyPermanentToCurrent(true);
            }
        });

        function copyPermanentToCurrent(readonly = false) {
            const permanentFields = {
                state: document.getElementById('p_state').value,
                district: document.getElementById('p_Dist').value,
                subDistrict: document.getElementById('p_subD').value,
                postOffice: document.getElementById('p_post').value,
                area_vill: document.getElementById('p_area_vill').value,
                street: document.getElementById('p_street').value,
                locality: document.getElementById('p_locality').value,
                landmark: document.getElementById('p_landmark').value,
                pin: document.getElementById('p_pin').value,
                building: document.getElementById('p_buildingName').value
            };

            const currentFields = {
                state: document.getElementById('currentState'),
                district: document.getElementById('currentDist'),
                subDistrict: document.getElementById('currentCircle'),
                postOffice: document.getElementById('currentPost'),
                area_vill: document.getElementById('currentArea'),
                street: document.getElementById('currentRoad'),
                locality: document.getElementById('currentCity'),
                landmark: document.getElementById('landmark'),
                pin: document.getElementById('currentPin'),
                building: document.getElementById('currentBuildingName')
            };

            for (let key in permanentFields) {
                currentFields[key].value = permanentFields[key];
                currentFields[key].readOnly = readonly;
            }
        }

        function clearCurrentAddress() {
            const currentFields = {
                state: document.getElementById('currentState'),
                district: document.getElementById('currentDist'),
                subDistrict: document.getElementById('currentCircle'),
                postOffice: document.getElementById('currentPost'),
                area_vill: document.getElementById('currentArea'),
                street: document.getElementById('currentRoad'),
                locality: document.getElementById('currentCity'),
                landmark: document.getElementById('landmark'),
                pin: document.getElementById('currentPin'),
                building: document.getElementById('currentBuildingName')
            };

            for (let key in currentFields) {
                currentFields[key].value = '';
                currentFields[key].readOnly = false;
            }
        }

        function handleCheckboxClick() {
            const checkbox = document.getElementById('copyAddressCheckbox');
            if (checkbox.checked) {
                copyPermanentToCurrent(true);
            } else {
                clearCurrentAddress();
            }
        }
    </script>


    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/getgetVaultData.js') }}"></script>
    <script>
        @if (session('alert_shown'))

        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('copyAddressCheckbox');
            if (checkbox.checked) {
                copyPermanentToCurrent(true);
            }
        });

        function copyPermanentToCurrent(readonly = false) {
            const permanentFields = {
                state: document.getElementById('p_state').value,
                district: document.getElementById('p_Dist').value,
                subDistrict: document.getElementById('p_subD').value,
                postOffice: document.getElementById('p_post').value,
                area_vill: document.getElementById('p_area_vill').value,
                street: document.getElementById('p_street').value,
                locality: document.getElementById('p_locality').value,
                landmark: document.getElementById('p_landmark').value,
                pin: document.getElementById('p_pin').value,
                building: document.getElementById('p_buildingName').value
            };

            const currentFields = {
                state: document.getElementById('currentState'),
                district: document.getElementById('currentDist'),
                subDistrict: document.getElementById('currentCircle'),
                postOffice: document.getElementById('currentPost'),
                area_vill: document.getElementById('currentArea'),
                street: document.getElementById('currentRoad'),
                locality: document.getElementById('currentCity'),
                landmark: document.getElementById('landmark'),
                pin: document.getElementById('currentPin'),
                building: document.getElementById('currentBuildingName')
            };

            for (let key in permanentFields) {
                currentFields[key].value = permanentFields[key];
                currentFields[key].readOnly = readonly;
            }
        }

        function clearCurrentAddress() {
            const currentFields = {
                state: document.getElementById('currentState'),
                district: document.getElementById('currentDist'),
                subDistrict: document.getElementById('currentCircle'),
                postOffice: document.getElementById('currentPost'),
                area_vill: document.getElementById('currentArea'),
                street: document.getElementById('currentRoad'),
                locality: document.getElementById('currentCity'),
                landmark: document.getElementById('landmark'),
                pin: document.getElementById('currentPin'),
                building: document.getElementById('currentBuildingName')
            };

            for (let key in currentFields) {
                currentFields[key].value = '';
                currentFields[key].readOnly = false;
            }
        }

        function handleCheckboxClick() {
            const checkbox = document.getElementById('copyAddressCheckbox');
            const radios = document.querySelectorAll('input[name="type_of_document"]');

            if (checkbox.checked) {
                radios.forEach((radio) => {
                    radio.disabled = true;
                });
                copyPermanentToCurrent(true);
            } else {
                radios.forEach((radio) => {
                    radio.disabled = false;
                });
                clearCurrentAddress();
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentAreaInput = document.getElementById('currentArea');
            const currentCityInput = document.getElementById('currentCity');
            const currentRoadInput = document.getElementById('currentRoad');
            const permanentAreaInput = document.getElementById('permanentArea');
            const permanentCityInput = document.getElementById('permanentCity');
            const permanentRoadInput = document.getElementById('permanentRoad');

            const areaError = document.getElementById('areaError');
            const p_areaError = document.getElementById('p_areaError');
            const c_cityError = document.getElementById('c_cityError');
            const p_cityError = document.getElementById('p_cityError');
            const c_roadError = document.getElementById('c_roadError');
            const p_roadError = document.getElementById('p_roadError');

            function validateAddressInput(input, errorElement) {
                if (!/^[^\d]*$/.test(input.value)) {
                    errorElement.textContent = '⚠ Cannot contain numerical values';
                    return false;
                } else {
                    errorElement.textContent = '';
                    return true;
                }
            }

            currentAreaInput.addEventListener('input', function(event) {
                validateAddressInput(currentAreaInput, areaError);
            });
            permanentAreaInput.addEventListener('input', function(event) {
                validateAddressInput(permanentAreaInput, p_areaError);
            });

            currentCityInput.addEventListener('input', function(event) {
                validateAddressInput(currentCityInput, c_cityError);
            });

            permanentCityInput.addEventListener('input', function(event) {
                validateAddressInput(permanentCityInput, p_cityError);
            });

            currentRoadInput.addEventListener('input', function(event) {
                validateAddressInput(currentRoadInput, c_roadError);
            });
            permanentRoadInput.addEventListener('input', function(event) {
                validateAddressInput(permanentRoadInput, p_roadError);
            });

        });
    </script>
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



@endsection
