@extends('layouts.user-app')

@section('title', ' Address')

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

        .revert-remarks-box {
            padding: 20px;
            margin: 30px auto;
            max-width: 600px;
            background-color: #f9f9f9;
            border-left: 5px solid #dc3545; /* Red left border */
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .section-title {
            margin-bottom: 10px;
            font-weight: 500;
            font-size: 15px;
        }

        .revert-text {
            font-size: 13px;
            margin-bottom: 15px;
        }

        .revert-reasons-list {
            list-style: disc inside;
            padding-left: 0;
            margin: 0;
        }

        .revert-reasons-list li {
            font-size: 13px;
            margin-bottom: 8px;
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
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Update Address Details&nbsp;
                                    (Application No -
                                    {{ $formdata->application_no }})
                                </span>

                            </div>


                            @if($remarks)
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="revert-remarks-box">
                                            <div class="section">
                                                <h5 class="section-title text-primary">Remarks for Reverted Application</h5>
                                                <p class="text-danger revert-text">{{ $remarks->remarks }}</p>
                                            </div>

                                            <div class="section mt-3">
                                                <h5 class="section-title text-primary">Reasons for Revert</h5>
                                                <ul class="revert-reasons-list">
                                                    @foreach ($remarks->getReasons($formdata->worker_id) as $remark)
                                                        <li class="text-danger">{{ $remark->reason }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
@endif

                            <div class="mr-2 ml-2"
                                style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.note') }}:</strong>
                                </p>
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-documents-details.1') }}</strong><span
                                        class="text-danger">
                                        {{ trans('worker-registration/worker-documents-details.mandatory') }}</span>
                                </p>
                                <p style="margin: 0;">
                                    <strong>2.</strong><span class="text-danger">
                                        You must have your present residential address or work location in Assam
                                    </span>
                                </p>
                            </div>

                            <form action="{{ route('update-worker-address') }}" class="ml-2 mr-2" method="post">

                                @csrf
                                <div class="mt-3"
                                    style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            {{ trans('worker-registration/worker-registration-address.paddress') }}
                                        </span>
                                        {{-- <span style="color: #495057; margin-left: 8px;">| স্থায়ী ঠিকানা:</span> --}}
                                    </h5>
                                    <div class="form-row mt-5"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputFirstName"
                                                >{{ trans('worker-registration/worker-registration-address.state') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                   style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                            <input type="text" class="form-control custom-bottom-border" id="p_state"
                                                value="{{ $getVaultData['state'] ?? 'NA' }}" readonly>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputLastName"
                                                >{{ trans('worker-registration/worker-registration-address.district') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                      style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                            <input type="text" class="form-control custom-bottom-border" id="p_Dist"
                                                value="{{ $getVaultData['district'] ?: 'NA' }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPassword4"
                                                >{{ trans('worker-registration/worker-registration-address.subdistrict') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                         style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                            <input type="text" class="form-control custom-bottom-border"
                                                value="{{ $getVaultData['subDistrict'] ?: 'NA' }}" id="p_subD" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="permanentRoad"
                                                >{{ trans('worker-registration/worker-registration-address.postoffice') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                        style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                id="p_post" value="{{ $getVaultData['postOffice'] ?: 'NA' }}" readonly>
                                            <span id="p_roadError" class="error"></span>
                                        </div>

                                    </div>

                                    <div class="form-row mt-3"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputMstatus"
                                                >{{ trans('worker-registration/worker-registration-address.villagearea') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                         style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                placeholder="Enter city" id="p_area_vill"
                                                value="{{ $getVaultData['village'] ?: 'NA' }}" readonly>
                                        </div>



                                        {{-- <div class="form-group col-md-3">
                                        <label for="gender" >{{ trans('worker-registration/worker-registration-address.street') }}</label><span
                                            class="text-danger font-italic font-weight" style="font-size: 12px;">* ({{ trans('worker-registration/worker-registration-address.aadhaar') }}
                                            )</span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                            id="p_street" name="p_area" value="{{ $getVaultData['street'] ?: 'NA' }}"
                                            placeholder="Enter area" readonly>
                                        <span id="p_areaError" class="error"></span>
                                    </div> --}}
                                        <div class="form-group col-md-3">
                                            <label for="inputDob"
                                                >{{ trans('worker-registration/worker-registration-address.locality') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                      style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                id="p_locality" value="{{ $getVaultData['locality'] ?: 'NA' }}"
                                                placeholder="Enter area" readonly>

                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="inputAge"
                                                >{{ trans('worker-registration/worker-registration-address.landmark') }}</label>

                                            <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                id="p_landmark" name="p_area"
                                                value="{{ $getVaultData['landMark'] ?: 'NA' }}" placeholder="Enter area"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputAge"
                                            >{{ trans('worker-registration/worker-registration-address.pin') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                             style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                   id="p_pin" name="p_area"
                                                   value="{{ $getVaultData['pinCode'] ?: 'NA' }}" placeholder="Enter area"
                                                   readonly>
                                            @if ($errors->has('p_circle'))
                                                <span
                                                        class="text-danger font-weight-normal error-message">{{ $errors->first('p_circle') }}</span>
                                            @endif
                                        </div>

                                    </div>


                                    <div class="form-row mt-3"><!--start 1-->



                                    </div><!--end-->
                                </div>


                                <!--spinner -->
                                <div class=" d-flex justify-content-center align-items-center mb-4 mt-3">
                                    <div class="">
                                        <div class="d-flex align-items-center"
                                            style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                            <input type="hidden" name="do" value="0">
                                            <input class="ml-3" type="checkbox" name="do" value="1"
                                                class="form-check-input styled-checkbox"
                                                {{ $formdata->do == 1 ? 'checked' : '' }} onclick="handleCheckboxClick()"
                                                id="copyAddressCheckbox">
                                            <label for="copyAddressCheckbox" class="ml-3 mr-3 mb-0">
                                                <span
                                                    style="font-size: 1rem; font-weight: 600; color: #495057;">{{ trans('worker-registration/worker-registration-address.copyaddress') }}</span>
                                                <br>
                                                {{-- <span style="font-size: 0.875rem; color: #6c757d;">স্থায়ী ঠিকনাক বৰ্তমান ঠিকনা হিচাপে কপি কৰক</span> --}}
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-3"
                                    style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            {{ trans('worker-registration/worker-registration-address.presentaddress') }}
                                        </span>
                                    </h5>
                                    <div class="d-flex align-items-center mt-4">
                                        <div>
                                            Type of Document<span class="text-danger">*</span>
                                        </div>
                                        <div class="ml-4">
                                            <input type="radio" id="ninety_days" name="type_of_document"
                                                value="1" {{ $formdata->type_of_document === 1 ? 'checked' : '' }}
                                                {{ $formdata->do == 1 ? 'disabled' : '' }}>
                                            <label for="ninety_days">90 Days Work Experience Certificate /
                                                Workbook</label><br>

                                            <input type="radio" id="other_doc" name="type_of_document" value="0"
                                                {{ $formdata->type_of_document === 0 ? 'checked' : '' }}
                                                {{ $formdata->do == 1 ? 'disabled' : '' }}>
                                            <label for="other_doc">Driving License / Voter ID card / Ration card / Bank passbook</label><br>
                                        </div>


                                    </div>
                                    <div class="form-row mt-5"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="currentResidence"
                                                >{{ trans('worker-registration/worker-registration-address.residencetype') }}
                                            </label><span style="color:red;">*</span>
                                            <select class="form-control custom-bottom-border" name="c_residence"
                                                id="currentResidence">

                                                <option value="{{ $formdata->c_residence }}">
                                                    {{ $formdata->residence_name }}
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
                                            <label for="inputLastName"
                                                >{{ trans('worker-registration/worker-registration-address.housetype') }}</label><span
                                                style="color:red;">*</span>
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
                                            <label for="inputPassword4"
                                                >{{ trans('worker-registration/worker-registration-address.houseno') }}</label>
                                            <input type="text" class="form-control custom-bottom-border"
                                                id="currentBuilding" name="c_house_no"
                                                placeholder="{{ trans('worker-registration/worker-registration-address.enterhouse') }}"
                                                value="{{ $formdata->c_house_no }}">
                                            <span class="error" id="c_houseError"></span>
                                            @if ($errors->has('c_house_no'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_house_no') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="currentCity"
                                                >{{ trans('worker-registration/worker-registration-address.locality') }}</label>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                name="c_city" id="currentCity" value="{{ $formdata->c_city }}"
                                                placeholder="{{ trans('worker-registration/worker-registration-address.enterlocality') }}">
                                            <span id="c_cityError" class="error"></span>
                                            @if ($errors->has('c_city'))
                                                <span
                                                    class="text-danger font-weight normal error-message">{{ $errors->first('c_city') }}</span>
                                            @endif
                                        </div>

                                    </div><!--end-->

                                    <div class="form-row mt-3"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="gender"
                                                >{{ trans('worker-registration/worker-registration-address.villagearea') }}
                                            </label><span style="color:red;">*</span>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                id="currentArea" name="c_area" value="{{ $formdata->c_area }}"
                                                placeholder="{{ trans('worker-registration/worker-registration-address.enterarea') }}">
                                            <span id="areaError" class="error"></span>
                                            @if ($errors->has('c_area'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_area') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone"
                                                >{{ trans('worker-registration/worker-registration-address.landmark') }}</label>
                                            <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                                name="landmark" id="landmark" value="{{ $formdata->landmark }}"
                                                placeholder="{{ trans('worker-registration/worker-registration-address.enterlandmark') }}">
                                            @if ($errors->has('landmark'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('landmark') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputCategory"
                                                >{{ trans('worker-registration/worker-registration-address.postoffice') }}
                                            </label><span style="color:red;">*</span>
                                            <input type="text" class="form-control custom-bottom-border post"
                                                data-id="c" id="currentPost" name="c_post_office"
                                                placeholder="{{ trans('worker-registration/worker-registration-address.enterpostoffice') }}"
                                                value="{{ $formdata->c_post_office }}">
                                            @if ($errors->has('c_post_office'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_post_office') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputAge"
                                                >{{ trans('worker-registration/worker-registration-address.subdistrict') }}</label>
                                            <input type="text" class="form-control custom-bottom-border circle"
                                                data-id="c" id="currentCircle" name="c_circle"
                                                placeholder="{{ trans('worker-registration/worker-registration-address.entersubdistrict') }}"
                                                value="{{ $formdata->c_circle }}">
                                            @if ($errors->has('c_circle'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_circle') }}</span>
                                            @endif
                                        </div>


                                    </div><!--end-->
                                    <div class="form-row mt-3"><!--start 1-->
                                        <div class="form-group col-md-3">
                                            <label for="inputAge"
                                                >{{ trans('worker-registration/worker-registration-address.district') }}</label>
                                            <select
                                                class="form-control custom-bottom-border uc-text-smooth @if ($errors->has('c_district')) is-invalid @endif"
                                                data-id="c" id="currentDist" name="c_district">
                                                <option value="">
                                                    {{ trans('worker-registration/worker_new_registration.select_district') }}
                                                </option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->district_code }}"
                                                        @if (isset($formdata->c_district) && $formdata->c_district == $district->district_code) selected @endif>
                                                        {{ $district->district_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputDob"
                                                >{{ trans('worker-registration/worker-registration-address.state') }}</label><span
                                                style="color:red;">*</span>
                                            <input type="text" class="form-control custom-bottom-border state"
                                                data-id="c" id="currentState" name="c_state"
                                                placeholder="{{ trans('worker-registration/worker-registration-address.enterstate') }}"
                                                value="{{ $formdata->c_state }}" onchange="validateCurrentState()">
                                            @if ($errors->has('c_state'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_state') }}</span>
                                            @endif
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="inputPhone"
                                                >{{ trans('worker-registration/worker-registration-address.pin') }}</label>
                                            <input type="text" class="form-control custom-bottom-border pin"
                                                id="currentPin" data-id="c" name="c_pin"
                                                value="{{ $formdata->c_pin }}"
                                                placeholder="{{ trans('worker-registration/worker-registration-address.enterpin') }}"
                                                maxlength="6">
                                            @if ($errors->has('c_pin'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('c_pin') }}</span>
                                            @endif
                                        </div>


                                    </div><!--end-->
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                    <div class="ml-auto d-inline-block align-self-center mr-2">
                                        <a type="submit" href="{{ route('main-page') }}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-backward"
                                                aria-hidden="true"></i>&nbsp;
                                            {{ trans('worker-registration/worker-registration-address.previous') }}</a>
                                        <button type="submit" id="submitBtn" class="btn btn-sm btn-primary" disabled><i
                                                class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                            {{ trans('worker-registration/worker-registration-address.updateresidentialaddress') }}
                                        </button>
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
        window.onload = validateCurrentState;

        function validateCurrentState() {
            const currentState = document.getElementById('currentState').value.trim().toLowerCase();
            const submitBtn = document.getElementById('submitBtn');

            if (currentState === 'assam') {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        function alertCurrentState() {

            const submitBtn = document.getElementById('submitBtn');

            if (currentState !== 'assam') {
                Swal.fire({
                    icon: 'warning',
                    text: 'Your present address must be from Assam in order to register with ABOCWWB'
                });


            } else {

            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            validateCurrentState(); // Call the function on load to check the current state value
        });

        function copyPermanentToCurrent(readonly = false) {
            const permanentFields = {
                state: document.getElementById('p_state').value,
                district: document.getElementById('p_Dist').value.trim(),
                subDistrict: document.getElementById('p_subD').value,
                postOffice: document.getElementById('p_post').value,
                area_vill: document.getElementById('p_area_vill').value,
                locality: document.getElementById('p_locality').value,
                landmark: document.getElementById('p_landmark').value,
                pin: document.getElementById('p_pin').value,
            };

            const currentFields = {
                state: document.getElementById('currentState'),
                district: document.getElementById('currentDist'),
                subDistrict: document.getElementById('currentCircle'),
                postOffice: document.getElementById('currentPost'),
                area_vill: document.getElementById('currentArea'),
                locality: document.getElementById('currentCity'),
                landmark: document.getElementById('landmark'),
                pin: document.getElementById('currentPin'),
            };

            const districtMap = @json($districts).reduce((map, district) => {
                map[district.district_name.trim().toLowerCase()] = district.district_code;
                return map;
            }, {});

            for (let key in permanentFields) {
                if (key === 'district') {
                    const dropdown = currentFields[key];
                    const districtName = permanentFields[key].trim().toLowerCase();

                    if (districtName === 'na') {
                        dropdown.value = '';
                        dropdown.disabled = false;
                    } else {
                        const districtCode = districtMap[districtName];

                        if (districtCode) {
                            dropdown.value = districtCode;
                        } else {
                            console.warn(`District name "${districtName}" not found in dropdown.`);
                            dropdown.value = '';
                        }

                    }
                } else {
                    if (permanentFields[key] === 'NA') {
                        currentFields[key].value = '';
                        currentFields[key].readOnly = false;
                    } else {
                        currentFields[key].value = permanentFields[key];
                        currentFields[key].readOnly = readonly;
                    }
                }
            }
        }

        function clearCurrentAddress() {
            const currentFields = {
                state: document.getElementById('currentState'),
                district: document.getElementById('currentDist'),
                subDistrict: document.getElementById('currentCircle'),
                postOffice: document.getElementById('currentPost'),
                area_vill: document.getElementById('currentArea'),
                locality: document.getElementById('currentCity'),
                landmark: document.getElementById('landmark'),
                pin: document.getElementById('currentPin'),
            };

            for (let key in currentFields) {
                const field = currentFields[key];
                if (key === 'district') {
                    field.value = '';
                    field.disabled = false;
                } else {
                    field.value = '';
                    field.readOnly = false;
                }
            }
        }

        function handleCheckboxClick() {
            const checkbox = document.getElementById('copyAddressCheckbox');
            const radios = document.querySelectorAll('input[name="type_of_document"]');
            const permanentState = document.getElementById('p_state').value.trim().toLowerCase();

            if (checkbox.checked) {


                if (permanentState !== 'assam') {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Your present address must be from Assam in order to register with ABOCWWB'
                    });
                    checkbox.checked = false;
                } else {
                    radios.forEach((radio) => {
                        radio.disabled = true;
                    });
                    copyPermanentToCurrent(true);
                }
            } else {
                radios.forEach((radio) => {
                    radio.disabled = false;
                });
                clearCurrentAddress();
            }
        }
    </script>

    <script>
        function ajaxStart() {
            // Show the loader when an AJAX request starts
            console.log('loadershow')
            $("#loader").show();
        };

        function ajaxStop() {
            // Hide the loader when all AJAX requests are complete
            console.log('loaderhide')
            $("#loader").hide();
        };
        //district
        $(document).ready(function() {

            $('.state').on('change', function() {
                ajaxStart();
                var cState = $(this).data('id');
                // console.log(cState);return

                var state_code = $(this).val();

                if (state_code) {
                    $.ajax({
                        url: 'get-districts',
                        type: 'GET',
                        data: {
                            state_code: state_code,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            ajaxStop();
                            if (cState == 'c') {
                                var dis = '#currentDist';
                            } else if (cState == 'p') {
                                var dis = '#permanentDist';
                            }
                            console.log(data)
                            $(dis).html('<option value="">--Select District--</option>');
                            $.each(data.districts, function(key, value) {
                                $(dis).append('<option value="' + value.district_code +
                                    '">' + value.district_name + '</option>');
                            });

                        }
                    });
                } else {
                    $('#currentDist').empty();
                    // $('#subdistrict').empty();
                }
            });
        });
        //subdistrict & postoffc
        $(document).ready(function() {
            $('.dist').on('change', function() {
                ajaxStart();
                var cDist = $(this).data('id');
                var district_code = $(this).val();
                if (cDist == 'c') {
                    var state_code = $('#currentState').val();
                } else if (cDist == 'p') {
                    var state_code = $('#permanentState').val();
                }
                if (district_code) {
                    $.ajax({
                        url: 'get-subdistricts-postoffc',
                        type: 'GET',
                        data: {
                            state_code: state_code,
                            district_code: district_code,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            ajaxStop();
                            if (cDist == 'c') {
                                var pos = '#currentPost';
                                var dis = '#currentCircle';
                            } else if (cDist == 'p') {
                                var dis = '#permanentCircle';
                                var pos = '#permanentPost';
                            }
                            console.log(data)
                            $(dis).html('<option value="">--Select Sub-district--</option>');
                            $.each(data.subdist, function(key, value) {
                                $(dis).append('<option value="' + value
                                    .subdistrict_code + '">' + value
                                    .subdistrict_name + '</option>');
                            });
                            $(pos).html('<option value="">--Select Post-office--</option>');
                            $.each(data.postoffice, function(key, value) {
                                $(pos).append('<option value="' + value.post_office_id +
                                    '">' + value.post_office_name + '</option>');
                            });
                        }
                    });
                } else {

                    $('#currentCircle').empty();
                }
            });
        });
        //postoffice
        $(document).ready(function() {
            $('.post').on('change', function() {
                ajaxStart();
                var cPost = $(this).data('id');
                var post_code = $(this).val();
                if (cPost == 'c') {
                    var state_code = $('#currentState').val();
                    var district_code = $('#currentDist').val();

                } else if (cPost == 'p') {
                    var state_code = $('#permanentState').val();
                    var district_code = $('#permanentDist').val();

                }
                if (post_code) {
                    $.ajax({
                        url: 'get-pincode',
                        type: 'get',
                        data: {
                            state_code: state_code,
                            district_code: district_code,
                            poid: post_code,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            ajaxStop();
                            if (cPost == 'c') {
                                var pin = '#currentPin';
                            } else if (cPost == 'p') {
                                var pin = '#permanentPin';
                            }
                            console.log(data)
                            $(pin).val(data.pincode.pin_code);

                        }
                    });
                } else {

                    $('#currentCircle').empty();
                }
            });
        });

        /** Ration Type **/
        $(document).ready(function() {
            $.ajax({
                url: 'getrationtype', // Update the URL based on your route
                type: 'GET',
                success: function(response) {
                    var dropdown = $('#ration_type');
                    dropdown.empty();
                    dropdown.append('<option value="" >Select Ration Type</option>');

                    $.each(response.ration_type, function(index, rationType) {
                        var option = $('<option></option>').attr('value', rationType
                            .ration_code).text(rationType.name);
                        dropdown.append(option);
                    });
                },
                error: function(error) {
                    console.error('Error fetching skills:', error);
                }
            });
        });
    </script>
    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
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
            const currentBuilding = document.getElementById('currentBuilding');
            const permanentBuilding = document.getElementById('permanentBuilding');
            const c_houseError = document.getElementById('c_houseError');
            const p_houseError = document.getElementById('p_houseError');

            function validateAddress(input, errorElement) {
                if (!/^\d*$/.test(input.value)) {
                    errorElement.textContent = '⚠ Must contain only numeric values';
                    return false;
                } else {
                    errorElement.textContent = '';
                    return true;
                }
            }

            currentBuilding.addEventListener('input', function(event) {
                validateAddress(currentBuilding, c_houseError);
            });
            permanentBuilding.addEventListener('input', function(event) {
                validateAddress(permanentBuilding, p_houseError);
            });
        });
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
