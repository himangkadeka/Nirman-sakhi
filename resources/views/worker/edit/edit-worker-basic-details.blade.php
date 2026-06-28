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
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Update Basic Details&nbsp;
                                    (New Registration)
                                </span>

                            </div>
                            <form action="{{ route('update-basic-data') }}" class="form-group ml-2 mr-2" method="post">
                                @if ($remarks)
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
                                        <div class="form-group col-md-6 mt-4">
                                            <div class="card shadow-sm border border-danger rounded-3 p-3 bg-light">
                                                <label for="registration_type" class="form-label text-danger font-weight-bold mb-2">
                                                    Select Registration Type According to Remarks:
                                                </label>
                                                <select class="form-control change-route" name="registration_type"
                                                        id="registration_type">
                                                    <option value="{{ $formdata->already_registered }}" disabled selected>
                                                        {{ $formdata->already_registered == 1 ? 'Onboarding' : 'New Registration' }}
                                                    </option>

                                                    <option value="0">New Registration</option>
                                                    <option value="1">On Boarding</option>
                                                </select>

                                                <small class="form-text text-muted mt-2">
                                                    Please select the appropriate type based on the provided remarks and reasons.
                                                </small>
                                            </div>
                                        </div>

                                    </div>

                                @endif


                                <div class="mr-3 mt-3"
                                    style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                    <p style="margin: 0;">
                                        <strong>Note:</strong><span class="text-danger">
                                            {{ trans('worker-registration/worker_basic_details.mandatory') }}</span>
                                    </p>
                                </div>
                                @csrf
                                <input type="hidden" id="workerId" name="worker_id" value="{{ $formdata->worker_id }}">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-row mt-4" style="display: flex">
                                    <!--start 1-->
                                    <div class="form-group col-md-8">
                                        @php
                                            // Ensure getVaultData['state'] is available
                                            $aadhaarState = trim($getVaultData['state'] ?? '');

                                            // Find the matching state_code based on the Aadhaar state name
                                            $selectedStateCode = $formdata->state_id;
                                            foreach ($states as $state) {
                                                if (strcasecmp(trim($state->state_name), $aadhaarState) === 0) {
                                                    $selectedStateCode = $state->state_code;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        <div>
                                            <!-- Hidden input to ensure resident_type is always submitted -->
                                            <input type="hidden" name="resident_type" id="resident_type_hidden"
                                                value="{{ $aadhaarState == 'Assam' ? 'raa' : 'rao' }}">

                                            <!-- Radio buttons for resident type -->
                                            <input class="d-none" type="radio" id="raa" name="resident_type"
                                                value="raa"
                                                {{ old('resident_type', $formdata->resident_type ?? '') == 'raa' || $aadhaarState == 'Assam' ? 'checked' : '' }}
                                                {{ $aadhaarState != 'Assam' ? 'readonly' : '' }}>

                                            <input class="d-none" type="radio" id="rao" name="resident_type"
                                                value="rao"
                                                {{ old('resident_type', $formdata->resident_type ?? '') == 'rao' && $aadhaarState != 'Assam' ? 'checked' : '' }}
                                                {{ $aadhaarState == 'Assam' ? 'readonly' : '' }}>

                                            <!-- Display resident status message -->
                                            <p class="font-weight-bold">
                                                <i class="fa fa-home" aria-hidden="true"></i>
                                                {{ $aadhaarState == 'Assam' ? 'You are a Permanent Resident of Assam' : 'You are not a Permanent Resident of Assam' }}
                                            </p>
                                        </div>

                                        @if ($aadhaarState != 'Assam')
                                            <div class="mt-3 col-md-4">
                                                <label for="state" class="bold ml-3">Your state is:
                                                    <span class="text-dark font-weight-bold">{{ $aadhaarState }}</span>
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
                                                <p><strong>Do you have the previous Acknowledgment slip with payment details
                                                        for
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
                                            <div class="d">
                                                <div class="upload-container">
                                                    <div class=" align-items-center">
                                                        <p class="mr-2 font-weight-bold">
                                                            Payment Acknowledgement Slip <br />
                                                            <small class="text-danger">
                                                                Note: Payment Acknowledgement Slip is Mandatory
                                                            </small>
                                                        </p>



                                                        <label for="file-upload" class="upload-label">
                                                            <i class="fas fa-upload"></i> Update
                                                        </label>
                                                        <button id="preview-btn" type="button" class="btn btn-danger ml-2"
                                                            data-bs-toggle="modal" data-bs-target="#previewModal"
                                                            style="display: none;">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>

                                                        <a class="btn btn-warning btn-sm ml-2" target="_blank"
                                                            href="{{ route('get-payment-ack-slip', ['id' => mt_rand(1, 1000)]) }}">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </div>

                                                    <input type="file" id="file-upload"
                                                        name="payment_acknowledgement_slip" class="upload-input"
                                                        accept="application/pdf">

                                                    <p class="file-name"></p>



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
                                                                data-dismiss="modal">Update</button>
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
                                            >{{ trans('worker-registration/worker_basic_details.name') }}
                                        </label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                      style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border" id="firstname"
                                            value="{{ $getVaultData['name'] }}" name="first_name" readonly>

                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="inputLastName"
                                            >{{ trans('worker-registration/worker_basic_details.care_of') }}
                                        </label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                      style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border" id="lastname"
                                            value="{{ $getVaultData['careOf'] }}" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="gender"
                                            >{{ trans('worker-registration/worker_basic_details.gender') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                         style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control"
                                            value="{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : ($getVaultData['gender'] == 'T' ? 'Transgender' : 'Unknown')) }}"
                                            readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputDob"
                                            >{{ trans('worker-registration/worker_basic_details.dob') }}
                                        </label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                      style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border" name="dob"
                                            id="dob" value="{{ $getVaultData['dob'] }}" readonly>

                                    </div>

                                </div><!--end-->

                                <div class="form-row mt-4"><!--start 1-->

                                    <div class="form-group col-md-3">
                                        <label for="inputAge"
                                            >{{ trans('worker-registration/worker_basic_details.age') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                      style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border" id="age"
                                            value="" placeholder="" disabled>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="mStatus"
                                            >{{ trans('worker-registration/worker_basic_details.marital_status') }}
                                        </label><span style="color:red;">*</span>
                                        <select id="inputState" class="form-control custom-bottom-border"
                                            name="maritial_status_id">
                                            <option value="{{ $formdata->marital_code }}">
                                                {{ $formdata->marital_status }} </option>
                                            @foreach ($marital as $key => $mar)
                                                <option value="{{ $mar->marital_code }}">{{ $mar->marital_status }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('maritial_status_id'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('maritial_status_id') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="inputCategory"
                                            >{{ trans('worker-registration/worker_basic_details.category') }}
                                        </label><span style="color:red;">*</span>
                                        <select id="inputCategory" class="form-control custom-bottom-border"
                                            name="category">
                                            <option value="{{ $formdata->category_code }}">
                                                {{ $formdata->category_name }} </option>
                                            @foreach ($category as $key => $cat)
                                                <option value="{{ $cat->category_code }}">{{ $cat->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('category') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPF"
                                            >{{ trans('worker-registration/worker_basic_details.eshram') }}<span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                 style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">Verified</span></label>
                                        <input type="text" class="form-control custom-bottom-border" id="eshram"
                                            value="{{ $formdata->eshram_no }}" name="eshram_no" maxlength="12" readonly>
                                        <span class="error" id="eShramError"></span>
                                        @if ($errors->has('eshram_no'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('eshram_no') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->

                                <div class="form-row mt-4"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                            >{{ trans('worker-registration/worker_basic_details.contact') }}
                                        </label><span class="text-danger">*
                                        </span>
                                        <input type="text" class="form-control custom-bottom-border" id="phone"
                                            placeholder="{{ $formdata->phone_no }}" disabled>

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                            >{{ trans('worker-registration/worker_basic_details.education') }}</label><span
                                            class="text-danger">*
                                        </span>
                                        <select id="inputCategory" class="form-control custom-bottom-border"
                                            name="education_id">
                                            <option value="{{ $formdata->education_code }}">
                                                {{ $formdata->education_name }} </option>
                                            @foreach ($education as $key => $edu)
                                                <option value="{{ $edu->education_code }}">{{ $edu->education_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('education_id'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('education_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                            >{{ trans('worker-registration/worker_basic_details.blood_group') }}
                                        </label><span class="text-danger">*</span>
                                        <select id="inputCategory" class="form-control custom-bottom-border"
                                            name="blood_group">
                                            <option value="{{ $formdata->id }}">{{ $formdata->blood_group }}
                                            </option>
                                            @foreach ($blood as $key => $bg)
                                                <option value="{{ $bg->id }}">{{ $bg->blood_group }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('blood_group'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('blood_group') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEsic"
                                            >{{ trans('worker-registration/worker_basic_details.retirement') }}</label>
                                        <input type="text" id="retirement_date" class="form-control"
                                            name="date_of_retirement" readonly>
                                    </div>
                                </div><!--end-->

                                <div class="form-row mt-4"><!--start 1-->

                                    <div class="form-group col-md-2">
                                        <label for="inputEsic" >Email-Id</label>
                                        <input type="text" class="form-control custom-bottom-border" id="email"
                                            value="{{ $formdata->email }}" name="email"
                                            placeholder="{{ trans('worker-registration/worker_basic_details.enteremail') }}">
                                        @if ($errors->has('email'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="pan_availability"
                                            >{{ trans('worker-registration/worker_basic_details.pan') }}
                                        </label><span class="text-danger">*</span>
                                        <select class="form-control custom-bottom-border" id="pan_availability"
                                            onchange="showPANField(this.value)" name="pan">
                                            <option value="1" {{ $formdata->pan == '1' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.have') }}
                                            </option>
                                            <option value="0" {{ $formdata->pan == '0' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.donthave') }}
                                            </option>
                                        </select>
                                        @if ($errors->has('pan'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('pan') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3" id="pan_field"
                                        style="{{ $formdata->pan == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="pan_number"
                                            >{{ trans('worker-registration/worker_basic_details.pan_no') }}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control custom-bottom-border capital "
                                            id="pan_number" value="{{ $formdata->pan_no }}" name="pan_no"
                                            placeholder="{{ trans('worker-registration/worker_basic_details.enterpnumber') }}"
                                            maxlength="10">
                                        <span id="panError" class="error"></span>
                                        @if ($errors->has('pan_no'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('pan_no') }}</span>
                                        @endif
                                    </div>

                                    <div class=" form-group col-md-4">
                                        <label for="boc_availability"
                                            >{{ trans('worker-registration/worker_basic_details.already_registered') }}
                                        </label><span class="text-danger">*</span>
                                        <select class="form-control custom-bottom-border" id="boc_availability"
                                            onchange="showBOCField(this.value)" name="boc">
                                            <option value="">
                                                {{ trans('worker-registration/worker_basic_details.select') }}</option>
                                            <option value="1" {{ $formdata->boc == '1' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.already_registeredyes') }}
                                            </option>
                                            <option value="0" {{ $formdata->boc == '0' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.already_registeredno') }}
                                            </option>
                                        </select>
                                        @if ($errors->has('boc'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('boc') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->

                                <div class="form-row mt-4">
                                    <div class="col-md-4" id="boc_field"
                                        style="{{ $formdata->boc == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="other_state" >Select the State of the board under which
                                            you are registered with</label><span style="color:red;">*</span>
                                        <select class="form-control custom-bottom-border state" id="state"
                                            name="other_state">
                                            @if ($formdata->other_state)
                                                <option value="{{ $formdata->other_state }}">
                                                    {{ $formdata->state_name }}</option>
                                            @else
                                                <option value="">Select State
                                                </option>
                                            @endif
                                            @foreach ($states as $state)
                                                @if ($state->state_code != 18)
                                                    <option value="{{ $state->state_code }}"
                                                        {{ $formdata->other_state == $state->state_code ? 'selected' : '' }}>
                                                        {{ $state->state_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('state_id')
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-3" id="boc_number"
                                        style="{{ $formdata->boc == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="boc_number" >BOCW Membership ID</label><span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control custom-bottom-border capital "
                                            id="boc_number" value="{{ $formdata->boc_no }}" name="boc_no"
                                            placeholder="{{ trans('worker-registration/worker_basic_details.enterboc') }}"
                                            maxlength="10">
                                        <span id="bocError" class="error"></span>
                                        @if ($errors->has('boc_no'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('boc_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="has_ration_card"
                                            >{{ trans('worker-registration/worker_basic_details.ration_card_have') }}</label><span
                                            class="text-danger">*
                                        </span>
                                        <select class="form-control custom-bottom-border" id="has_ration_card"
                                            name="has_ration_card">
                                            <option value="0"
                                                {{ $formdata->has_ration_card == '0' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.donthave') }}
                                            </option>
                                            <option value="1"
                                                {{ $formdata->has_ration_card == '1' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.have') }}
                                            </option>
                                        </select>
                                        @error('has_ration_card')
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="form-row mt-4">
                                    <div class="form-group col-md-3" id="ration_details"
                                        style="{{ $formdata->has_ration_card == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="ration_no"
                                            >{{ trans('worker-registration/worker_basic_details.ration_card') }}</label><span
                                            style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border" id="ration_no"
                                            name="ration_no"
                                            placeholder="{{ trans('worker-registration/worker_basic_details.enterration_card') }}"
                                            value="{{ isset($formdata->ration_no) ? $formdata->ration_no : '' }}">
                                        @error('ration_no')
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3" id="ration_type_section"
                                        style="{{ $formdata->has_ration_card == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="ration_type"
                                            >{{ trans('worker-registration/worker_basic_details.ration_card_type') }}</label><span
                                            style="color:red;">*</span>
                                        <select class="form-control custom-bottom-border" id="ration_type"
                                            name="ration_type">
                                            @if (!empty($formdata->ration_type))
                                                {{-- Preselected option if form is in edit mode --}}
                                                <option value="{{ $formdata->ration_type }}" selected>
                                                    {{ $formdata->name }}</option>
                                            @else
                                                {{-- Default placeholder option --}}
                                                <option value="0" selected>
                                                    {{ trans('worker-registration/worker_basic_details.select') }}
                                                </option>
                                            @endif

                                            {{-- Dynamically generated options --}}
                                            @foreach ($ration as $rt)
                                                @if ($rt->ration_code != $formdata->ration_type)
                                                    <option value="{{ $rt->ration_code }}">{{ $rt->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @error('ration_type')
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                    <div class="ml-auto d-inline-block align-self-center mr-2">
                                        <a href="{{ route('update-office-address-page') }}" class="btn btn-sm btn-warning"><i
                                                class="fa fa-backward" aria-hidden="true"></i>&nbsp;
                                            {{ trans('worker-registration/worker-registration-address.previous') }}</a>
                                        <button type="submit"
                                            class="btn btn-sm btn-primary">{{ trans('worker-registration/worker_basic_details.update') }}
                                            &nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </div>
 
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
                console.log('hi');
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
