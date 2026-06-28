@extends('layouts.user-app')

@section('title', ' Basic Details')

@section('style')
    <style type="text/css">
        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }

        #loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Semi-transparent black background */
            z-index: 9999;
            /* Ensure it appears on top of other content */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            border: 6px solid #f3f3f3;
            /* Light gray border */
            border-top: 6px solid #3498db;
            /* Blue color for the spinner */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .btn-primary {
            background-color: #0f4547;
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
        <div class="row">
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
            <div class="card">
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
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Basic Details&nbsp; (Application No
                                    -
                                    {{ $formdata->application_no }})
                                </span>

                            </div>

                            <form action="{{ route('save-basic-page') }}" enctype="multipart/form-data"
                                class="form-group form needs-validation ml-2 mr-2" id="basic-form" method="post"
                                novalidate>
                                @csrf
                                <div class="mr-3 mt-3"
                                    style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                    <p style="margin: 0;">
                                        <strong>Note:</strong><span class="text-danger">
                                            {{ trans('worker-registration/worker_basic_details.mandatory') }} </span>
                                    </p>
                                </div>
                                <input type="hidden" name="worker_id" value="{{ $formdata->worker_id }}">
                                <div class="form-row mt-4" style="display: flex"><!--start 1-->
                                    <div class="form-group col-md-12">
                                        @php
                                            $aadhaarState = trim(strtolower($getVaultData['state']));
                                            $selectedStateCode = null;
                                            $stateMatched = false;

                                            foreach ($states as $state) {
                                                if (trim(strtolower($state->state_name)) === $aadhaarState) {
                                                    $selectedStateCode = $state->state_code;
                                                    $stateMatched = true;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        <div>
                                            <input type="hidden" name="resident_type" id="resident_type_hidden"
                                                value="{{ $aadhaarState === 'assam' ? 'raa' : 'rao' }}">

                                            <input class="d-none" type="radio" id="raa" name="resident_type"
                                                value="raa"
                                                {{ old('resident_type') == 'raa' || $aadhaarState === 'assam' ? 'checked' : '' }}
                                                {{ $aadhaarState !== 'assam' ? 'readonly' : '' }}>

                                            <input class="d-none" type="radio" id="rao" name="resident_type"
                                                value="rao"
                                                {{ old('resident_type') == 'rao' && $aadhaarState !== 'assam' ? 'checked' : '' }}
                                                {{ $aadhaarState === 'assam' ? 'readonly' : '' }}>

                                            <p class="font-weight-bold">
                                                <i class="fa fa-home" aria-hidden="true"></i>
                                                {{ $aadhaarState === 'assam' ? 'You are a Permanent Resident of Assam' : 'You are not a Permanent Resident of Assam' }}
                                            </p>
                                        </div>

                                        @if (!$stateMatched)
                                            <div class="mt-3 col-md-4">
                                                <label for="state" class="bold ml-3">Select your state:</label>
                                                <select name="state_id" id="state" class="form-control">
                                                    <option value="">-- Select State --</option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->state_code }}">{{ $state->state_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <div class="mt-3 col-md-4">
                                                <label for="state" class="bold ml-3">Your state is:
                                                    <span
                                                        class="text-dark font-weight-bold">{{ ucfirst($getVaultData['state']) }}</span>
                                                </label>
                                                <input type="hidden" name="state_id" value="{{ $selectedStateCode }}">
                                            </div>
                                        @endif

                                        @error('resident_type')
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="d-flex ml-2" style="gap:100px">
                                        @if ($alreadyPaymentStatus === true)
                                            <div class="form-group">
                                                <p><strong>Do you have the Acknowledgment slip with payment details for
                                                        uploading?</strong></p>

                                                <select class="form-control" name="alreadyPaymentStatus"
                                                    id="alreadyPaymentStatus">
                                                    <option value="1" {{ $alreadyPaymentStatus ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                    <option value="0" {{ !$alreadyPaymentStatus ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="">
                                                <div class="upload-container">
                                                    <div class=" align-items-center">
                                                        <p class="mr-2 font-weight-bold">
                                                            Payment Acknowledgement Slip <br />
                                                            <small class="text-danger">
                                                                Note: Payment Acknowledgement Slip is Mandatory
                                                            </small>
                                                        </p>



                                                        <label for="file-upload" class="upload-label">
                                                            <i class="fas fa-upload"></i> Upload
                                                        </label>
                                                        <button id="preview-btn" type="button" class="btn btn-danger ml-2"
                                                            data-bs-toggle="modal" data-bs-target="#previewModal"
                                                            style="display: none;">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>


                                                    </div>

                                                    <input type="file" id="file-upload"
                                                        name="payment_acknowledgement_slip" class="upload-input"
                                                        accept="application/pdf">

                                                    <p class="file-name"></p>
                                                    @if ($errors->has('payment_acknowledgement_slip'))
                                                        <span
                                                            class="text-danger font-weight-normal error-message">{{ $errors->first('payment_acknowledgement_slip') }}</span>
                                                    @endif
                                                </div>


                                            </div>

                                            <!-- Button to Trigger Modal -->


                                            <!-- Bootstrap Modal -->
                                            <div class="modal fade" id="previewModal" tabindex="-1"
                                                aria-labelledby="previewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="previewModalLabel">File Preview
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <iframe id="file-preview" src="" width="100%"
                                                                height="500px" style="border: none;"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger decline-btn"
                                                                data-file-id="discard"
                                                                data-dismiss="modal">Discard</button>
                                                            <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Upload</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>



                                </div> <!--end-->

                                <div class="form-row mt-4"><!--start 1-->

                                    <div class="form-group col-md-3">
                                        <label for="inputFirstName"
                                            class="">{{ trans('worker-registration/worker_basic_details.name') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                               style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control" id="name"
                                            value="{{ $getVaultData['name'] }}" name="name" readonly>

                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="inputLastName"
                                            class="">{{ trans('worker-registration/worker_basic_details.care_of') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control  uc-text-smooth" id="lastname"
                                            value="{{ $getVaultData['careOf'] }}" name="last_name" readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="gender"
                                            class="">{{ trans('worker-registration/worker_basic_details.gender') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                 style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control "
                                            value="{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : ($getVaultData['gender'] == 'T' ? 'Transgender' : 'Unknown')) }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputDob"
                                            class="">{{ trans('worker-registration/worker_basic_details.dob') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" id="dob" class="form-control custom-bottom-border"
                                            name="dob" placeholder=""
                                            value="{{ \Carbon\Carbon::parse($getVaultData['dob'])->format('Y-m-d') }}"
                                            readonly>
                                    </div>

                                </div><!--end-->
                                <div class="form-row mt-4"><!--start 1-->

                                    <div class="form-group col-md-3">
                                        <label for="inputAge"
                                            class="">{{ trans('worker-registration/worker_basic_details.age') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border" id="age"
                                            disabled>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPF"
                                            class="">{{ trans('worker-registration/worker_basic_details.eshram') }}<span
                                                style="color:red;">*</span></label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control custom-bottom-border  @if ($errors->has('eshram_no')) is-invalid @endif"
                                                id="uan" value="{{ old('eshram_no') }}" name="eshram_no"
                                                placeholder="Enter eShram no" maxlength="12">
                                            <div class="input-group-append">
                                                <button class="btn-sm btn-danger" type="button"
                                                    id="verifyButtonEshram">
                                                    <span id="spinner" class="spinner-border spinner-border-sm"
                                                        role="status" aria-hidden="true" style="display: none;"></span>
                                                    <span id="validate">Validate</span>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="error" id="eShramError"></span>
                                        @if ($errors->has('eshram_no'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('eshram_no') }}</span>
                                        @endif
                                    </div>
                                    <div id="loader-overlay" style="display:none;">
                                        <div class="spinner"></div>
                                    </div>




                                    <div class="form-group col-md-3">
                                        <label for="mStatus"
                                            class="">{{ trans('worker-registration/worker_basic_details.marital_status') }}</label><span
                                            style="color:red;">*</span>
                                        <select id="maritalStatus"
                                            class="form-control custom-bottom-border @if ($errors->has('maritial_status_id')) is-invalid @endif"
                                            name="maritial_status_id">
                                            <option value="">
                                                {{ trans('worker-registration/worker_basic_details.selectmarital_status') }}
                                            </option>
                                            @foreach ($marital as $data)
                                                {{-- <option value="{{ $data->marital_code }}">{{ $data->marital_status }}</option> --}}
                                                <option value="{{ $data->marital_code }}"
                                                    @if (old('maritial_status_id') == $data->marital_code) selected @endif>
                                                    {{ $data->marital_status }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('maritial_status_id'))
                                            <span
                                                class="text-danger font-weight-small error-message">{{ $errors->first('maritial_status_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputCategory"
                                            class="">{{ trans('worker-registration/worker_basic_details.category') }}</label><span
                                            style="color:red;">*</span>
                                        <select id="Category"
                                            class="form-control custom-bottom-border  @if ($errors->has('category')) is-invalid @endif"
                                            name="category">
                                            <option value="">
                                                {{ trans('worker-registration/worker_basic_details.selectcategory') }}
                                            </option>
                                            @foreach ($category as $data)
                                                {{-- <option value="{{ $data->category_code }}">{{ $data->category_name }}</option> --}}
                                                <option value="{{ $data->category_code }}"
                                                    @if (old('category') == $data->category_code) selected @endif>
                                                    {{ $data->category_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('category') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->

                                <div class="form-row mt-4"><!--start 1-->

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                            class="">{{ trans('worker-registration/worker_basic_details.contact') }}</label><span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control custom-bottom-border" id="phone"
                                            placeholder="{{ $formdata->phone_no }}" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                            class="">{{ trans('worker-registration/worker_basic_details.education') }}</label><span
                                            class="text-danger">*</span>
                                        <select id="education"
                                            class="form-control custom-bottom-border   @if ($errors->has('education_id')) is-invalid @endif"
                                            name="education_id">
                                            <option value="">
                                                {{ trans('worker-registration/worker_basic_details.selecteducation') }}
                                            </option>
                                            @foreach ($education as $data)
                                                {{-- <option value="{{ $data->education_code }}">{{ $data->education_name }}</option> --}}
                                                <option value="{{ $data->education_code }}"
                                                    @if (old('education_id') == $data->education_code) selected @endif>
                                                    {{ $data->education_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('education_id'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('education_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                            class="">{{ trans('worker-registration/worker_basic_details.blood_group') }}
                                        </label><span class="text-danger">*</span>
                                        <select id="blood_group"
                                            class="form-control custom-bottom-border @if ($errors->has('blood_group')) is-invalid @endif"
                                            name="blood_group">
                                            <option value="">
                                                {{ trans('worker-registration/worker_basic_details.blood_group') }}
                                            </option>
                                            @foreach ($blood as $data)
                                                <option value="{{ $data->id }}"
                                                    @if (old('blood_group') == $data->id) selected @endif>
                                                    {{ $data->blood_group }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('blood_group'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('blood_group') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEsic" class="">Email Id</label>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                            id="email" value="{{ old('email') }}" name="email"
                                            placeholder="{{ trans('worker-registration/worker_basic_details.enteremail') }}">
                                        @if ($errors->has('email'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('email') }}</span>
                                        @endif
                                        <span id="emailError" class="error"></span>
                                    </div>
                                </div><!--end-->
                                <div class="form-row mt-4"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputEsic"
                                            class="">{{ trans('worker-registration/worker_basic_details.retirement') }}</label>
                                        <input type="text" id="retirement_date" class="form-control"
                                            name="date_of_retirement" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pan_availability"
                                            class="">{{ trans('worker-registration/worker_basic_details.pan') }}</label><span
                                            class="text-danger">*</span>
                                        <select
                                            class="form-control custom-bottom-border @if ($errors->has('pan')) is-invalid @endif"
                                            id="pan_availability" onchange="showPANField(this.value)" name="pan">
                                            <option value="">
                                                {{ trans('worker-registration/worker_basic_details.select') }}</option>
                                            <option value="1" {{ old('pan') == '1' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.have') }} </option>
                                            <option value="0" {{ old('pan') == '0' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.donthave') }}</option>
                                        </select>
                                        @if ($errors->has('pan'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('pan') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3" id="pan_field"
                                        style="{{ old('pan') == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="pan_number" class="">
                                            {{ trans('worker-registration/worker_basic_details.pnumber') }}</label>
                                        <span class="text-danger">*</span>

                                        <input type="text"
                                            class="form-control custom-bottom-border uc-text-smooth  @if ($errors->has('pan_no')) is-invalid @endif"
                                            id="pan_number" value="{{ old('pan_no') }}" name="pan_no"
                                            placeholder="{{ trans('worker-registration/worker_basic_details.enterpnumber') }}"
                                            maxlength="10" oninput="this.value = this.value.toUpperCase()">
                                        <span id="panError" class="error"></span>
                                        @if ($errors->has('pan_no'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('pan_no') }}</span>
                                        @endif
                                    </div>
                                    <div class=" form-group col-md-4">
                                        <label for="boc_availability"
                                            class="">{{ trans('worker-registration/worker_basic_details.already_registered') }}</label><span
                                            class="text-danger">*</span>
                                        <select
                                            class="form-control custom-bottom-border  @if ($errors->has('boc')) is-invalid @endif"
                                            id="boc_availability" onchange="showBOCField(this.value)" name="boc">
                                            <option value="">
                                                {{ trans('worker-registration/worker_basic_details.select') }}</option>
                                            <option value="1" {{ old('boc') == '1' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.already_registeredyes') }}
                                            </option>
                                            <option value="0" {{ old('boc') == '0' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.already_registeredno') }}
                                            </option>
                                        </select>
                                        @if ($errors->has('boc'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('boc') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-5" id="boc_field"
                                        style="{{ old('boc') == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="boc_number">Select the State of the board under which
                                            you are registered with</label><span class="text-danger">*</span>
                                        <select class="form-control custom-bottom-border state selectpicker"
                                            id="state" name="other_state" data-live-search="true">
                                            <option value="" selected>Select State</option>
                                            @foreach ($states as $state)
                                                @if ($state->state_code !== 18)
                                                    <option value="{{ $state->state_code }}"
                                                        @if (old('other_state') == $state->state_code) selected @endif>
                                                        {{ $state->state_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>


                                    </div>
                                    <div class="form-group col-md-3" id="boc_number"
                                        style="{{ old('boc') == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="boc_number">BOCW Membership ID</label><span
                                            class="text-danger">*</span>
                                        <input type="text"
                                            class="form-control custom-bottom-border uc-text-smooth   @if ($errors->has('boc_no')) is-invalid @endif"
                                            id="boc_number" value="{{ old('boc_no') }}" name="boc_no"
                                            placeholder="Enter your BOCW Membership ID" maxlength="10">
                                        <span id="bocError" class="error"></span>
                                        @if ($errors->has('boc_no'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('boc_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="has_ration_card">{{ trans('worker-registration/worker_basic_details.ration_card_have') }}</label><span
                                            class="text-danger">*</span>
                                        <select
                                            class="form-control custom-bottom-border  @if ($errors->has('has_ration_card')) is-invalid @endif"
                                            id="has_ration_card" name="has_ration_card">
                                            <option value="">
                                                {{ trans('worker-registration/worker_basic_details.select') }}</option>
                                            <option value="0" {{ old('has_ration_card') == '0' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.donthave') }}
                                            </option>
                                            <option value="1" {{ old('has_ration_card') == '1' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.have') }}
                                            </option>
                                        </select>
                                        @if ($errors->has('has_ration_card'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('has_ration_card') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->
                                <div class="form-row mt-3">

                                    <div class="form-group col-md-3" id="ration_details"
                                        style="{{ old('has_ration_card') == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="ration_no"
                                           >{{ trans('worker-registration/worker_basic_details.ration_card') }}</label><span
                                            style="color:red;">*</span>
                                        <input type="text"
                                            class="form-control custom-bottom-border  @if ($errors->has('ration_no')) is-invalid @endif"
                                            id="ration_no" name="ration_no"
                                            placeholder="{{ trans('worker-registration/worker_basic_details.enterration_card') }}"
                                            value="{{ old('ration_no') }}">
                                        @if ($errors->has('ration_no'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('ration_no') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3" id="ration_type_section"
                                        style="{{ old('has_ration_card') == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="ration_type">{{ trans('worker-registration/worker_basic_details.ration_card_type') }}</label><span
                                            style="color:red;">*</span>
                                        <select
                                            class="form-control custom-bottom-border  @if ($errors->has('ration_type')) is-invalid @endif"
                                            id="ration_type" name="ration_type">
                                            <option value="" selected>
                                                {{ trans('worker-registration/worker_basic_details.select') }}</option>
                                            @foreach ($ration as $key => $rt)
                                                <option value="{{ $rt->ration_code }}">{{ $rt->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('ration_type'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('ration_type') }}</span>
                                        @endif
                                    </div>
                                </div>



                                <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                    <div class="ml-auto d-inline-block align-self-center mr-2">
                                        <a href="{{ route('update-office-address-page') }}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-backward"
                                                aria-hidden="true"></i>&nbsp;
                                            {{ trans('worker-registration/worker-registration-address.previous') }}</a>
                                        <button type="submit" id="submitButtonBasic" class="btn btn-sm btn-primary"
                                            @if (env('APP_DEBUG') == false) disabled @endif
                                            class="btn btn-sm btn-primary">{{ trans('worker-registration/worker_basic_details.savebasicdetails') }}&nbsp;<i
                                            class="fa fa-check-circle" aria-hidden="true"></i></button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="payment-consent" tabindex="-1" role="dialog" aria-labelledby="accountDetailsLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Confirmation</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <p style="padding: 5px;">
                        <strong>
                            Have you previously submitted application for registration by paying Rs. 25/- as registration fee?
                        </strong>
                        <br><br>
                        <span style="font-weight: normal;">
    Note: Click "Yes" only if you had previously registered on the old portal by paying the Rs. 25/- registration fee and your application was not disposed of (i.e., it was not processed).
  </span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="yes-button" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">No</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="acknowledgement-consent" tabindex="-1" role="dialog"
        aria-labelledby="accountDetailsLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Confirmation</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <p style="padding: 5px;"><strong>Do you have the Acknowledgment slip with payment details for uploading?
                        </strong> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="yes-button-ack" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-danger" id="no-btn-ack" data-dismiss="modal">No</button>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="warning" tabindex="-1" role="dialog" aria-labelledby="accountDetailsLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Warning</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <p><strong>Uploading Acknowledgment slip is mandatory for submitting application without paying the
                            registration fee. You can come back later with the Acknowledgment slip to avoid payment of
                            registration fee or pay the registration fee to submit your application now. Do you agree to
                            submit the application now?
                        </strong> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="yes-button-warning"
                        data-dismiss="modal">Yes</button>
                    <a href="{{ route('home.index') }}" type="button" class="btn btn-danger"
                        data-dismiss="modal">No</a>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="acknowledgement-number" tabindex="-1" role="dialog"
        aria-labelledby="accountDetailsLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Payment Details</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                </div>
                <div class="modal-body" style="padding: 5px;">
                    <div>
                        <input type="text" class="form-control" id="acknowledgement_number"
                            placeholder="Please enter acknowledgement number" required>
                    </div>
                    <div class="mt-1">
                        <input type="text" class="form-control" id="transaction_id"
                            placeholder="Please enter transaction Id" required>
                    </div>
                    <div class="mt-1">
                        <input type="date" class="form-control" id="date_of_payment"
                            placeholder="Please enter Payment Date" required>
                    </div>
                    <div class="mt-1">
                        <input type="text" class="form-control" id="amount" placeholder="Please enter amount"
                            required>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="yes-button-ack-no"
                        data-dismiss="modal">Submit</button>
                    {{-- <button type="button" class="btn btn-danger" id="" data-dismiss="modal">No</button> --}}
                </div>


            </div>
        </div>
    </div>
    </div>

@endsection


@section('footer')
    <link rel="stylesheet" href="{{ URL::asset('assets/template/datepicker/jquery-ui.min.css') }}">
    <script src="{{ URL::asset('assets/template/datepicker/jquery-3.7.date.js') }}"></script>
    <script src="{{ URL::asset('assets/template/datepicker/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/basic-style.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/validate-Uan.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/session-timeout.js') }}"></script>
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
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: "Oops!",
                                text: "Something went wrong. Please try again.",
                                icon: "error",
                                confirmButtonText: "OK"
                            }).then(() => {
                                location.reload();
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
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: "Oops!",
                                text: "Something went wrong. Please try again.",
                                icon: "error",
                                confirmButtonText: "OK"
                            }).then(() => {
                                    location.reload();
                            });
                        }
                    });
                }
            });
        });
    </script>
    @if ($alreadyPaymentStatus === false)
        @if (session()->has('worker_id'))
            <script>
                @if (session()->has('ack_no'))
                    const ack_no = true
                @else
                    const ack_no = false
                @endif

                Swal.fire({
                    title: "Success!",
                    icon: "success",
                    html: 'Your Temporary Registration ID: <strong>{{ session('worker_id') }}</strong>.</br> Please note it down for future reference.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (ack_no == false) {
                            @if ($formdata->already_payment_status == true)
                                $('#acknowledgement-consent').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                }).modal('show');
                            @else
                                showNextModal();
                            @endif
                        }
                    }
                });
                if (ack_no == false) {
                    document.addEventListener("click", function() {
                        showNextModal();
                    }, {
                        once: true
                    });
                }

                function showNextModal() {
                    $('#payment-consent').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                }



                document.querySelector('.btn-danger[aria-label="Close"]').addEventListener("click", function() {
                    $('#payment-consent').modal('hide'); // Ensures the modal is hidden
                });
                document.getElementById("yes-button").addEventListener("click", function() {
                    $.ajax({
                        url: "{{ route('update-payement-details') }}", // Update the URL based on your route
                        type: 'GET',
                        success: function(response) {
                            if (response.status === true) {
                                $('#payment-consent').modal('hide');
                                $('#acknowledgement-consent').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                }).modal('show');
                            } else {
                                alert("Something went wrong! Please try again later.");
                            }
                        },

                    });

                });

                document.getElementById("yes-button").addEventListener("click", function() {
                    $.ajax({
                        url: "{{ route('update-payement-details') }}", // Update the URL based on your route
                        type: 'GET',
                        success: function(response) {
                            if (response.status === true) {
                                $('#payment-consent').modal('hide');
                                $('#acknowledgement-consent').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                }).modal('show');
                            } else {
                                alert("Something went wrong! Please try again later.");
                            }
                        },

                    });

                });



                document.getElementById('yes-button-ack-no').addEventListener("click", function() {
                    var ack_no = $("#acknowledgement_number").val();
                    var transaction_id = $("#transaction_id").val();
                    var date_of_payment = $("#date_of_payment").val();
                    var ack_amount_paid = $("#amount").val();

                    if (!ack_no) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Acknowledgement number is required.',
                            confirmButtonText: 'OK',
                        });
                        return;
                    }
                    if (!transaction_id) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Transaction Id is required.',
                            confirmButtonText: 'OK',
                        });
                        return;
                    }
                    if (!date_of_payment) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Payment Date is required.',
                            confirmButtonText: 'OK',
                        });
                        return;
                    }
                    if (!ack_amount_paid) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Amount Paid is required.',
                            confirmButtonText: 'OK',
                        });
                        return;
                    }

                    showLoader();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('update-acknowledgement-number') }}",
                        // cache: false,
                        dataType: 'JSON', // Ensure this route is correct
                        data: {
                            ack_no: ack_no,
                            ack_transaction_id: transaction_id,
                            ack_amount: ack_amount_paid,
                            ack_payment_date: date_of_payment,

                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            hideLoader();

                            if (response.status === true) {
                                $('#acknowledgement-number').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    text: 'Previous Payment Details Updated Successfully',
                                    confirmButtonText: 'OK',
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    text: response.result ||
                                        'Something went wrong! Please try again later.',
                                    confirmButtonText: 'OK',
                                });
                            }
                        },
                        error: function() {
                            hideLoader();
                            Swal.fire({
                                icon: 'error',
                                text: 'Failed to communicate with the server. Please try again later.',
                                confirmButtonText: 'OK',
                            });
                        },
                    });
                });


                document.getElementById("yes-button-ack").addEventListener("click", function() {
                    $('#payment-consent').modal('hide');
                    $('#acknowledgement-consent').modal('hide');
                    $('#acknowledgement-number').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                })

                document.getElementById("no-btn-ack").addEventListener("click", function() {
                    $('#acknowledgement-consent').modal('hide');
                    $('#warning').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                });

                document.getElementById('yes-button-warning').addEventListener("click", function() {
                    $("#warning").modal('hide');
                })
            </script>
        @endif

    @endif

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

    <script></script>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'getskills', // Update the URL based on your route
                type: 'GET',
                success: function(response) {
                    var dropdown = $('#profession');
                    dropdown.empty();
                    dropdown.append('<option value="">--Select a profession--</option>');
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

    <script>
        window.onload = function() {
            // Get the date of birth value
            var dob = document.getElementById('dob').value;

            // Split the date into its components
            var dobComponents = dob.split('-');

            // Check if the date format is YYYY-MM-DD
            if (dobComponents.length === 3) {
                // Extract the year, month, and day
                var year = parseInt(dobComponents[0], 10);
                var month = parseInt(dobComponents[1], 10) - 1; // Months are 0-based in JavaScript Date
                var day = parseInt(dobComponents[2], 10);

                // Calculate the current year
                var currentYear = new Date().getFullYear();

                // Calculate the age
                var age = currentYear - year;
                document.getElementById('age').value = age;

                // Calculate the retirement year
                var retirementYear = year + 60;

                // Create the retirement date
                var retirementDate = new Date(retirementYear, month, day);

                // Format the retirement date as DD-MM-YYYY
                var formattedRetirementDate = String(retirementDate.getDate()).padStart(2, '0') + '-' +
                    String(retirementDate.getMonth() + 1).padStart(2, '0') + '-' +
                    retirementDate.getFullYear();

                // Update the retirement date input field
                document.getElementById('retirement_date').value = formattedRetirementDate;
            } else {
                console.error("Invalid date format. Please use 'YYYY-MM-DD' format.");
            }
        };
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const residentOutsideAssamCheckbox = document.getElementById('resident_of_other');
            const stateIfResidentOutsideAssam = document.getElementById('roo_statement');
            const workingInAssamCheckbox = document.getElementById('resident_of_assam');
            const stateIfWorkingInAssam = document.getElementById('roa_statement');
            const eShramInput = document.getElementById('uan');
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
        function showPANField(value) {
            var panField = document.getElementById("pan_field");
            if (value === "1") {
                panField.style.display = "block";
                // Add validation logic here for pan_no
            } else {
                panField.style.display = "none";
                // Reset validation for pan_no or make it not required
            }
        }
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
                // Reset validation for pan_no or make it not required
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var emailInput = document.getElementById("email");
            var panInput = document.getElementById("pan_number");
            var emailError = document.getElementById("emailError");
            var panError = document.getElementById("panError");
            var myForm = document.getElementById("basic-form");

            // Email validation
            if (emailInput) {
                emailInput.addEventListener("input", function() {
                    var email = emailInput.value.trim();
                    if (email && !isValidEmail(email)) {
                        emailError.textContent = "⚠ Invalid email address";
                        myForm.setAttribute("data-valid-email", "false");
                    } else {
                        emailError.textContent = "";
                        myForm.setAttribute("data-valid-email", "true");
                    }
                });
            }

            // PAN card validation
            if (panInput) {
                panInput.addEventListener("input", function() {
                    var pan = panInput.value.trim();
                    if (pan && !isValidPAN(pan)) {
                        panError.textContent = "⚠ Invalid PAN format.";
                        myForm.setAttribute("data-valid-pan", "false");
                    } else {
                        panError.textContent = "";
                        myForm.setAttribute("data-valid-pan", "true");
                    }
                });
            }

            function isValidEmail(email) {
                // Regular expression for basic email validation
                var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(email);
            }

        });
    </script>


@endsection
