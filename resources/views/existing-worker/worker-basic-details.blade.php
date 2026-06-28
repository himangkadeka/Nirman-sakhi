@extends('layouts.user-app')

@section('title', ' Basic Details')

@section('style')
    <style>
        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }
        label{
            font-size: 14px !important;
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

        .bar1,
        .bar2,
        .bar3 {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
            transition: 0.4s;
        }

        /*.form-group select.form-control {*/
        /*    height: calc(1.5em + .75rem + 2px) !important; !* Adjust the height to match the input fields *!*/
        /*    padding: .375rem .75rem !important;  !* Adjust padding to match the input fields *!*/
        /*    font-size: 1rem !important;  !* Ensure font size is consistent *!*/
        /*    line-height: 1.5 !important;  !* Ensure line height is consistent *!*/
        /*}*/
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

    @include('components.multistep-existing')
    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light p-3">
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
                    <div class="d-flex justify-content-center align-items-center mb-1">
                        <span>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            {{ trans('worker-registration/worker-family-details.workername') }}
                            - {{ $getVaultData['name'] }}
                        </span>

                    </div>
                    <div class="d-flex justify-content-center align-items-center mb-3">

                        <span>

                            {{ trans('worker-registration/worker_basic_details.id_card') }}
                            - <span class="font-weight-bold">{{ $xyz->worker_id }}</span>
                        </span>
                    </div>
                    <div class="card rounded-card">
                        <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                            style="background-color: #2badee;">
                            <span>
                                <i class="fa fa-plus-circle"
                                    aria-hidden="true"></i>&nbsp;{{ trans('worker-registration/worker_basic_details.title') }}
                            </span>
                        </div>
                        <form action="{{ route('save-existing-basic-page') }}"
                            class="form-group ml-2 mr-2  form needs-validation" method="post" novalidate>
                            <div class="mr-3 mt-3"
                                style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker_basic_details.note') }}:</strong><span
                                        class="text-danger">
                                        {{ trans('worker-registration/worker_basic_details.mandatory') }}</span>
                                </p>
                            </div>
                            @csrf
                            <input type="hidden" name="worker_id" value="{{ $xyz->worker_id }}">
                            @if ($errors->has('worker_id'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span><strong>{{ $errors->first('worker_id') }}</strong></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-row mt-3" style="display: flex"><!--start 1-->
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
                                            <label for="state" class="ml-3">Your State is:
                                                <span
                                                    class="text-dark font-weight-bold">{{ $aadhaarState }}</span>
                                            </label>
                                            <input type="hidden" name="state_id" value="{{ $selectedStateCode }}">
                                        </div>
                                    @endif

                                    @error('resident_type')
                                        <span
                                            class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>


                            <div class="form-row mt-4">
                                <div class="form-group col-md-3">
                                    <label for="inputFirstName"
                                        class="">{{ trans('worker-registration/worker_basic_details.name') }}</label>
                                    <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input type="text" class="form-control" id="name"
                                        value="{{ $getVaultData['name'] }}" name="name" readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputLastName"
                                        class="">{{ trans('worker-registration/worker_basic_details.care_of') }}</label>
                                    <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>

            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input type="text" class="form-control" id="care_of"
                                        value="{{ $getVaultData['careOf'] }}" name="care_of" readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputDob"
                                        class="">{{ trans('worker-registration/worker_basic_details.dob') }}</label>
                                    <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input type="text" id="dob" class="form-control" name="dob"
                                        value="{{ \Carbon\Carbon::parse($getVaultData['dob'])->format('Y-m-d') }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="gender"
                                        class="">{{ trans('worker-registration/worker_basic_details.gender') }}</label>
                                    <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input type="text" class="form-control" id="gender_uid"
                                        value="{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : ($getVaultData['gender'] == 'T' ? 'Transgender' : 'Unknown')) }}"
                                        readonly>
                                </div>
                            </div>


                            <div class="form-row mt-4">
                                <div class="form-group col-md-3">
                                    <label for="inputAge"
                                           class="">{{ trans('worker-registration/worker_basic_details.age') }}</label>
                                    <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                        {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input type="text" class="form-control" name="age_aadhar" id="age" readonly>
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="inputFirstName"
                                        class="">{{ trans('worker-registration/worker_basic_details.name') }}</label>
                                    <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                    <input placeholder="Enter Name" type="text" class="form-control" id="f_name_old"
                                        value="{{ $name ?? '' }}"
                                        name="old_name"
                                        >
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputLastName"
                                        class="">{{ trans('worker-registration/worker_basic_details.care_of') }}</label>
                                    <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                    <input placeholder="Enter Care of" type="text" class="form-control"
                                        id="care_of_old"
                                        value="{{ $careOf ?? '' }}"
                                        name="care_of_old">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputDob"
                                        class="">{{ trans('worker-registration/worker_basic_details.dob') }}</label>
                                    <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                    @php
                                        $dobValue =
                                            isset($apiResponse->dob) && $apiResponse->dob !== 'NA'
                                                ? \Carbon\Carbon::parse($apiResponse->dob)->format('d-m-Y')
                                                : '';
                                    @endphp

                                    @if ($dobValue === '' || $dobValue === 'NA')
                                        <input placeholder="Enter Date of Birth" type="text" id="old_dob"
                                            class="form-control " name="old_dob">
                                    @else
                                        <input placeholder="Enter Date of Birth" type="text" id="old_dob"
                                            class="form-control" name="old_dob" value="{{ $dobValue }}" >
                                    @endif
                                </div>


                            </div>





                            <div class="form-row mt-4"><!--start 3-->
                                <div class="form-group col-md-3">
                                    <label for="gender"
                                           class="">{{ trans('worker-registration/worker_basic_details.gender') }}</label>
                                    <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                    @php
                                        $genderValue = isset($apiResponse->gender)
                                            ? $gender->firstWhere('gender_code', $apiResponse->gender)->gender_name ??
                                                'NA'
                                            : 'NA';
                                    @endphp

                                    @if ($genderValue === 'NA' || empty($genderValue))
                                        <select class="form-control" id="gender_old" name="gender_id">
                                            <option value="">Select Gender</option>
                                            @foreach ($gender as $g)
                                                <option value="{{ $g->gender_code }}">{{ $g->gender_name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" class="form-control" id="gender_old" name="gender_id"
                                               value="{{ $genderValue }}" >
                                    @endif
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="inputOldAge"
                                        class="">{{ trans('worker-registration/worker_basic_details.age') }}</label>
                                    <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                    <input type="text" class="form-control" id="old_age" disabled>
                                </div>

                                <div class="form-group col-md-3" id="eshram-field">
                                    <label for="inputPF"
                                        class="">{{ trans('worker-registration/worker_basic_details.eshram') }}<span
                                            style="color:red;">*</span></label>
                                    <div class="input-group mt-1">
                                        <input type="text"
                                            class="form-control custom-bottom-border  @if ($errors->has('eshram_no')) is-invalid @endif"
                                            id="uan" value="{{ old('eshram_no') }}" name="eshram_no"
                                            placeholder="Enter eShram no" maxlength="12">
                                        <div class="input-group-append">
                                            <button class="btn-sm btn-primary" type="button" id="verifyButtonEshram">
                                                <span id="spinner" class="spinner-border spinner-border-sm"
                                                    role="status" aria-hidden="true" style="display: none;"></span>
                                                <span id="validate">Validate</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="loader-overlay" style="display:none;">
                                    <div class="spinner"></div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="mStatus"
                                        class="">{{ trans('worker-registration/worker_basic_details.marital_status') }}</label>
                                    <span style="color:red;">*</span>
                                    <select id="inputState" class="form-control" name="maritial_status_id">
                                        <option value="">Select Marital Status</option>
                                        @foreach ($marital as $data)
                                            <option value="{{ $data->marital_code }}"
                                                {{ old('maritial_status_id', $apiResponse->marital_status ?? '') == $data->marital_code ? 'selected' : '' }}>
                                                {{ $data->marital_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('maritial_status_id'))
                                        <span
                                            class="text-danger font-weight-small error-message">{{ $errors->first('maritial_status_id') }}</span>
                                    @endif
                                </div>

                            </div>


                            <div class="form-row mt-4"><!--start 1-->
                                <div class="form-group col-md-3">
                                    <label for="inputPhone"
                                        class="">{{ trans('worker-registration/worker_basic_details.contact') }}</label>
                                    <input type="text" class="form-control custom-bottom-border" id="phone"
                                        placeholder="{{ $xyz->phone_no }}" readonly>

                                </div>
                                <div class="form-group col-md-3 mt-1">
                                    <label for="inputCategory"
                                        class="">{{ trans('worker-registration/worker_basic_details.category') }}</label><span
                                        style="color:red;">*</span>
                                    <select id="inputCategory" class="form-control custom-bottom-border" name="category">
                                        <option value="">Select Category</option>
                                        @foreach ($category as $category)
                                            <option value="{{ $category->category_code }}"
                                                @if ($category->category_code == ($apiResponse->category_id ?? '')) selected @endif>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('category'))
                                        <span
                                            class="text-danger font-weight-normal error-message">{{ $errors->first('category') }}</span>
                                    @endif
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="inputPhone"
                                        class="">{{ trans('worker-registration/worker_basic_details.education') }}</label><span
                                        style="color:red;">*</span>
                                    <select id="inputCategory" class="form-control" name="education_id">
                                        <option value ="">Select Education</option>
                                        @foreach ($education as $data)
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
                                        class="">{{ trans('worker-registration/worker_basic_details.blood_group') }}</label><span
                                        style="color:red;">*</span>
                                    <select id="inputCategory" class="form-control" name="blood_group">
                                        <option value="">Select Blood Group</option>
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
                            </div><!--end-->
                            <div class="form-row mt-4">
                                <!-- Card Issue Date -->
                                <div class="form-group col-md-3">
                                    <label for="inputPhone"
                                        class="">{{ trans('worker-registration/worker_basic_details.issuedate') }}</label><span
                                        class="text-danger font-italic" style="font-size: 12px;">*</span>
                                    <input placeholder="YYYY-MM-DD" type="text" class="form-control white-background"
                                        id="last_registration_date" value="{{ old('last_registration_date') }}"
                                        name="last_registration_date" max="@php echo date('Y-m-d'); @endphp">
                                    @if ($errors->has('last_registration_date'))
                                        <span
                                            class="text-danger font-weight-normal error-message">{{ $errors->first('last_registration_date') }}</span>
                                    @endif
                                    <small class="text-muted">Note: As Per Existing ID Card</small>
                                </div>

                                <!-- Card Validity Date -->
                                <div class="form-group col-md-3">
                                    <label for="card_expiry"
                                        class="">{{ trans('worker-registration/worker_basic_details.validitydate') }}</label><span
                                        style="color:red;">*</span>
                                    <input placeholder="YYYY-MM-DD" type="text" class="form-control white-background"
                                        id="card_validity_date" value="{{ old('card_validity_date') }}"
                                        name="card_validity_date">
                                    @if ($errors->has('card_validity_date'))
                                        <span
                                            class="text-danger font-weight-normal error-message">{{ $errors->first('card_validity_date') }}</span>
                                    @endif
                                    <small class="text-muted">Note: Must set as one day less than the exact 2-year gap.</small>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="subscription_field">Do you have Subscription Receipt</label><span class="text-danger">*</span>
                                    <select class="form-control" id="subscription_field" name="subscription_receipt">
                                        <option value="">Select</option>
                                        <option value="1" {{ old('subscription_receipt') == '1' ? 'selected' : '' }}>
                                            {{ trans('worker-registration/worker_basic_details.panyes') }}
                                        </option>
                                        <option value="0" {{ old('subscription_receipt') == '0' ? 'selected' : '' }}>
                                            {{ trans('worker-registration/worker_basic_details.panno') }}
                                        </option>
                                    </select>
                                    @if ($errors->has('subscription_receipt'))
                                        <span class="text-danger font-weight-normal error-message">{{ $errors->first('subscription_receipt') }}</span>
                                    @endif
                                </div>

                                <!-- Date Of Payment -->

                                <div class="form-group col-md-3 subscription-details">
                                    <label>{{ trans('worker-registration/worker_basic_details.amount') }}</label><span style="color:red;">*</span>
                                    <input type="text" name="subscription_amount_paid" class="form-control" placeholder="Enter amount"
                                           value="{{ old('subscription_amount_paid') }}">
                                    @if ($errors->has('subscription_amount_paid'))
                                        <span class="text-danger font-weight-normal error-message">{{ $errors->first('subscription_amount_paid') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3 subscription-details">
                                    <label>{{ trans('worker-registration/worker_basic_details.subscription_date') }}</label><span style="color:red;">*</span>
                                    <input type="text" placeholder="YYYY-MM-DD" class="form-control white-background"
                                           id="subscription_payment_date" value="{{ old('subscription_payment_date') }}"
                                           name="subscription_payment_date">
                                    @if ($errors->has('subscription_payment_date'))
                                        <span class="text-danger font-weight-normal error-message">{{ $errors->first('subscription_payment_date') }}</span>
                                    @endif
                                </div>


                                <div class="form-group col-md-3 mt-1">
                                    <label for="inputEsic"
                                        class="">{{ trans('worker-registration/worker_basic_details.retirement') }}</label>
                                    <input type="text" id="retirement_date" class="form-control"
                                        name="date_of_retirement" readonly>
                                </div>



                                <div class="form-group col-md-3">
                                    <label for="inputPhone" class="">Profession</label><span
                                        style="color:red;">*</span>
                                    <select id="profession_1" class="form-control" name="profession"
                                        onchange="checkOthers()">
                                        <option value="" {{ old('profession', '') === '' ? 'selected' : '' }}>Select
                                            Profession</option>
                                        @foreach ($professions as $profession)
                                            <option value="{{ $profession->profession_code }}">

                                                {{ $profession->profession_name }}
                                            </option>
                                        @endforeach


                                    </select>
                                    @if ($errors->has('profession'))
                                        <span
                                            class="text-danger font-weight-normal error-message">{{ $errors->first('profession') }}</span>
                                    @endif
                                </div>

                                <div class="form-group col-md-3 d-none" id="others_1">
                                    <label for="inputPhone" class="">Other Profession</label><span
                                        style="color:red;">*</span>
                                    <input type="text" name="profession_others" class=" fixed-width form-control"
                                        placeholder="Enter Other Profession" />
                                    @if ($errors->has('profession_others'))
                                        <span
                                            class="text-danger font-weight-normal error-message">{{ $errors->first('profession_others') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pan_availability"
                                           class="">{{ trans('worker-registration/worker_basic_details.pan') }}</label><span
                                            class="text-danger">*</span>
                                    <select class="form-control " id="pan_availability"
                                            onchange="showPANField(this.value)" name="pan">
                                        <option value="">Select</option>
                                        <option value="1" {{ old('pan') == '1' ? 'selected' : '' }}>
                                            {{ trans('worker-registration/worker_basic_details.panyes') }}</option>
                                        <option value="0" {{ old('pan') == '0' ? 'selected' : '' }}>
                                            {{ trans('worker-registration/worker_basic_details.panno') }}</option>
                                    </select>
                                    @if ($errors->has('pan'))
                                        <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('pan') }}</span>
                                    @endif
                                </div>
                            </div><!--end-->
                            <div class="form-row mt-4"><!--start 1-->


                                <div class="form-group col-md-3" id="pan_field"
                                    style="{{ old('pan') == '1' ? 'display: block;' : 'display: none;' }}">
                                    <label for="pan_number"
                                        class="">{{ trans('worker-registration/worker_basic_details.pnumber') }}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control  uc-text-smooth" id="pan_number"
                                        value="{{ old('pan_no') }}" name="pan_no" placeholder="Enter your PAN number"
                                        maxlength="10" oninput="this.value = this.value.toUpperCase()">
                                    <span id="panError" class="error"></span>
                                    @if ($errors->has('pan_no'))
                                        <span
                                            class="text-danger font-weight-normal error-message">{{ $errors->first('pan_no') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="boc_availability" class="">
                                        {{ trans('worker-registration/worker_basic_details.already_registered') }}
                                    </label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control custom-bottom-border" id="boc_availability"
                                        name="boc" onchange="showBOCField(this.value)">
                                        <option value="">Select</option>
                                        <option value="1" {{ old('boc') == '1' ? 'selected' : '' }}>
                                            {{ trans('worker-registration/worker_basic_details.already_registeredyes') }}
                                        </option>
                                        <option value="0" {{ old('boc') == '0' ? 'selected' : '' }}>
                                            {{ trans('worker-registration/worker_basic_details.already_registeredno') }}
                                        </option>
                                    </select>
                                    @if ($errors->has('boc'))
                                        <span class="text-danger font-weight-normal error-message">
                                            {{ $errors->first('boc') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Additional Fields -->
                                <div class="form-group col-md-5 boc_field" id="boc_field"
                                    style="{{ old('boc') == '1' ? 'display: block;' : 'display: none;' }}">
                                    <label for="state" class="">
                                        Select the State of the board under which you are registered with
                                    </label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control custom-bottom-border state selectpicker" id="state"
                                        name="other_state" data-live-search="true">
                                        <option value="" selected>Select State</option>
                                        @foreach ($states as $state)
                                            @if ($state->state_code !== 18)
                                                <option value="{{ $state->state_code }}"
                                                    {{ old('other_state') == $state->state_code ? 'selected' : '' }}>
                                                    {{ $state->state_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3 boc_field" id="boc_number"
                                    style="{{ old('boc') == '1' ? 'display: block;' : 'display: none;' }}">
                                    <label for="boc_number" class="">BOCW Membership ID</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                        id="boc_number" value="{{ old('boc_no') }}" name="boc_no"
                                        placeholder="Enter your BOCW Membership ID" maxlength="10">
                                    <span id="bocError" class="error"></span>
                                    @if ($errors->has('boc_no'))
                                        <span class="text-danger font-weight-normal error-message">
                                            {{ $errors->first('boc_no') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="has_ration_card" class="">{{ trans('worker-registration/worker_basic_details.ration_card_have') }}</label><span
                                        class="text-danger">*</span>
                                    <select class="form-control custom-bottom-border" id="has_ration_card"
                                        name="has_ration_card">
                                        <option value="">Select</option>
                                        <option value="0" {{ old('has_ration_card') == '0' ? 'selected' : '' }}>
                                            {{ trans('worker-registration/worker_basic_details.donthave') }}
                                        </option>
                                        <option value="1" {{ old('has_ration_card') == '1' ? 'selected' : '' }}>
                                            {{ trans('worker-registration/worker_basic_details.have') }}
                                        </option>
                                    </select>
                                    @error('has_ration_card')
                                        <span class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3" id="ration_details"
                                    style="{{ old('has_ration_card') == '1' ? 'display: block;' : 'display: none;' }}">
                                    <label for="ration_no"
                                        class="">{{ trans('worker-registration/worker_basic_details.ration_card') }}</label><span
                                        style="color:red;">*</span>
                                    <input type="text" class="form-control custom-bottom-border" id="ration_no"
                                        name="ration_no" placeholder="Enter Ration Card Number"
                                        value="{{ old('ration_no') }}">
                                    @error('ration_no')
                                        <span class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3" id="ration_type_section"
                                    style="{{ old('has_ration_card') == '1' ? 'display: block;' : 'display: none;' }}">
                                    <label for="ration_type"
                                        class="">{{ trans('worker-registration/worker_basic_details.ration_card_type') }}</label><span
                                        style="color:red;">*</span>
                                    <select class="form-control custom-bottom-border" id="ration_type"
                                        name="ration_type">
                                        <option value="" selected>Select</option>
                                        @foreach ($ration as $key => $rt)
                                            <option value="{{ $rt->ration_code }}">{{ $rt->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('ration_type')
                                        <span class="text-danger font-weight-normal error-message">{{ $message }}</span>
                                    @enderror
                                </div>




                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                <div class="ml-auto d-inline-block align-self-center mr-2">
                                    <a href="{{ route('update-existing-office-address-page') }}" class="btn btn-sm btn-warning"><i
                                            class="fa fa-backward" aria-hidden="true"></i>&nbsp;
                                        {{ trans('worker-registration/worker-registration-address.previous') }}</a>
                                    <button type="submit" class="btn btn-sm btn-primary" id="submitButtonBasic"
                                            @if (env('APP_DEBUG') == false) disabled  @endif>Save Basic
                                        Details&nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i></button>

                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div><!-- End Left side columns -->
    </div>

@endsection
<script src="{{ URL::asset('assets/template/vendor/jquery/ajax-jquery-3.7.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/basic-style.js') }}"></script>
{{-- <script src="{{ URL::asset('assets/template/js/session-timeout.js') }}"></script> --}}
<script src="{{ URL::asset('assets/template/js/validate-Uan.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
<script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>

@section('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            checkOthers(); // Call on page load to check the profession value
        });

        function checkOthers() {
            var othersSelect = document.getElementById('others_1');
            var professionType = document.getElementById('profession_1').value;
            if (parseInt(professionType) === 28) { // Convert to number before comparing
                othersSelect.classList.remove('d-none');
            } else {
                othersSelect.classList.add('d-none');
            }
        }

        flatpickr('#card_validity_date', {
            dateFormat: "Y-m-d",
            defaultDate: "",
            maxDate: "2027-01-07"
        });
        flatpickr('#last_registration_date', {
            dateFormat: "Y-m-d",
            maxDate: "2025-01-08",
            minDate: null,
            defaultDate: "",
        });
        flatpickr('#subscription_payment_date', {
            dateFormat: "Y-m-d",
            defaultDate: "",
        });

        flatpickr('#old_dob', {
            dateFormat: "d-m-Y",
            defaultDate: "",
        });

        function parseDateFromFlatpickr(dateString) {
            if (!dateString) return null;
            const [day, month, year] = dateString.split('-').map(Number);
            return new Date(year, month - 1, day); // Convert to Date object
        }

        function formatDateToDMY(date) {
            if (!date || isNaN(date)) return '';
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        function validateDates() {
            const issueDateField = document.getElementById('last_registration_date');
            const validityDateField = document.getElementById('card_validity_date');
            const renewalDateGroup = document.getElementById('renewal_date_group');
            const renewalDateField = document.getElementById('last_renewal_date');

            const issueDate = parseDateFromFlatpickr(issueDateField.value);
            const validityDate = parseDateFromFlatpickr(validityDateField.value);
            const renewalDate = renewalDateField.value ? parseDateFromFlatpickr(renewalDateField.value) : null;

            // Format the dates as d-m-y
            const formattedIssueDate = formatDateToDMY(issueDate);
            const formattedValidityDate = formatDateToDMY(validityDate);
            const formattedRenewalDate = renewalDate ? formatDateToDMY(renewalDate) : '';

            console.log(`Issue Date: ${formattedIssueDate}`);
            console.log(`Validity Date: ${formattedValidityDate}`);
            console.log(`Renewal Date: ${formattedRenewalDate}`);

            if (!issueDate || !validityDate) {
                renewalDateGroup.style.display = 'none';
                renewalDateField.removeAttribute('required');
                renewalDateField.value = '';
                return;
            }

            const oneDay = 1000 * 60 * 60 * 24;

            // Helper function to check if a year is a leap year
            function isLeapYear(year) {
                return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
            }

            // Calculate the adjusted validity date
            const adjustedValidityDate = new Date(validityDate.getTime() + oneDay);
            const differenceInDays = Math.ceil((adjustedValidityDate - issueDate) / oneDay);

            const startYear = issueDate.getFullYear();
            const endYear = adjustedValidityDate.getFullYear();

            let daysInPeriod = 0;
            let leapYearInRange = false;

            // Check if the start or end year is a leap year or if the period spans a leap year
            for (let year = startYear; year <= endYear; year++) {

                // Check if the year is a leap year and set the flag accordingly
                if (isLeapYear(year)) {
                    leapYearInRange = true; // Set this to true if any year in range is a leap year
                }

                if (year === startYear && year === endYear) {
                    // If the range is within the same year, calculate the difference in days
                    daysInPeriod = differenceInDays;
                } else if (year === startYear) {
                    // If the range starts in this year, calculate the remaining days in this year
                    const daysRemainingInStartYear = new Date(year + 1, 0, 1) - issueDate;
                    daysInPeriod += daysRemainingInStartYear / oneDay;
                } else if (year === endYear) {
                    // If the range ends in this year, calculate the days in this year until the validity date
                    const daysUntilEndYear = adjustedValidityDate - new Date(year, 0, 1);
                    daysInPeriod += daysUntilEndYear / oneDay;
                } else {
                    // For full years in between, count the full days of the year (365 or 366)
                    daysInPeriod += isLeapYear(year) ? 366 : 365;
                }
            }

            // Debugging logs to check the leap year detection and day calculation
            console.log("Start Year: ", startYear);
            console.log("End Year: ", endYear);
            console.log("Leap Year in Range: ", leapYearInRange);
            console.log("Total Days in Period: ", daysInPeriod);
            if (leapYearInRange) {
                daysInPeriod -= 2;
                if (daysInPeriod >= 730) {
                    renewalDateGroup.style.display = 'block';
                    renewalDateField.setAttribute('required', 'required');
                    if (renewalDate && renewalDate >= validityDate) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Renewal Date',
                            text: `The last renewal date (${formattedRenewalDate}) must be less than the card validity date (${formattedValidityDate}).`,
                        });
                        renewalDateField.value = ''; // Clear invalid renewal date
                    }
                } else if (daysInPeriod === 729) {
                    renewalDateGroup.style.display = 'none';
                    renewalDateField.removeAttribute('required');
                    renewalDateField.value = '';
                } else if (daysInPeriod < 729) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Date Range',
                        text: `The duration between card issue date (${formattedIssueDate}) and card validity date (${formattedValidityDate}) cannot be less than 2 years.`,
                    });
                    validityDateField.value = '';
                    renewalDateGroup.style.display = 'none';
                    renewalDateField.removeAttribute('required');
                    renewalDateField.value = '';
                }

            } else {
                // Otherwise, subtract 1 day
                daysInPeriod -= 1;
                if (daysInPeriod >= 730) {
                    renewalDateGroup.style.display = 'block';
                    renewalDateField.setAttribute('required', 'required');
                    if (renewalDate && renewalDate >= validityDate) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Renewal Date',
                            text: `The last renewal date (${formattedRenewalDate}) must be less than the card validity date (${formattedValidityDate}).`,
                        });
                        renewalDateField.value = ''; // Clear invalid renewal date
                    }
                } else if (daysInPeriod < 729) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Date Range',
                        text: `The duration between card issue date (${formattedIssueDate}) and card validity date (${formattedValidityDate}) cannot be less than 2 years.`,
                    });
                    validityDateField.value = '';
                    renewalDateGroup.style.display = 'none';
                    renewalDateField.removeAttribute('required');
                    renewalDateField.value = '';
                } else if (daysInPeriod === 729) {
                    renewalDateGroup.style.display = 'none';
                    renewalDateField.removeAttribute('required');
                    renewalDateField.value = '';
                }

            }

            console.log(daysInPeriod);
        }
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
                // var age = 60;
                var submitButton = document.getElementById('submitButtonBasic'); // Submit button
                var eshramInput = document.getElementById('uan');
                var eshramValidateButton = document.getElementById('verifyButtonEshram');
                var eshramInput = document.getElementById('eshram-field');
                // var age =60;
                 function toggleEshramField() {

                if (!isNaN(age) && age >= 59) {
                    submitButton.removeAttribute('disabled');
                    eshramInput.style.display = 'none'; // Hide the eShram input field
                } else {
                    submitButton.setAttribute('disabled', 'true');
                    eshramInput.style.display = 'block'; // Show the eShram input field
                }
            }

            // Initial check on page load
            toggleEshramField();

            // Add event listener to age input
            document.getElementById('age').addEventListener('input', toggleEshramField);


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
        // Function to calculate and update age
        function calculateAge() {
            var old_dob = document.getElementById('old_dob').value;
            console.log(old_dob);

            // Check if date of birth is provided
            if (old_dob) {
                var dobComponentsold = old_dob.split('-'); // Split by '-'

                // In 'd-m-y' format, year is the third component (index 2)
                var yearIndexold = dobComponentsold.length === 3 ? 2 : 0;
                var yearold = dobComponentsold[yearIndexold];

                var currentYearold = new Date().getFullYear();

                // Update the age input field
                document.getElementById('old_age').value = currentYearold - parseInt(yearold, 10);
            } else {
                // Handle case where date of birth is not provided
                document.getElementById('old_age').value = '';
            }
        }

        // Calculate age on page load
        calculateAge();

        // Update age when date of birth changes
        document.getElementById('old_dob').addEventListener('change', calculateAge);
    </script>

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
        function showSubscriptionField(value) {
            var subscriptionField = document.getElementById("subscription_field");
            if (value === "1") {
                subscriptionField.style.display = "block";
                // Add validation logic here for pan_no
            } else {
                subscriptionField.style.display = "none";
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
                bocNumber.value = ""
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

            // function isValidPAN(pan) {
            //     // Regular expression for PAN card number validation
            //     var regex = /^[A-Za-z]{5}\d{4}[A-Za-z]{1}$/;
            //     return regex.test(pan);
            // }
        });
    </script>
    <script>
        const forceKeyPressUppercase = (e) => {
            let el = e.target;
            let charInput = e.keyCode;
            if ((charInput >= 97) && (charInput <= 122)) { // lowercase
                if (!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
                    let newChar = charInput - 32;
                    let start = el.selectionStart;
                    let end = el.selectionEnd;
                    el.value = el.value.substring(0, start) + String.fromCharCode(newChar) + el.value.substring(end);
                    el.setSelectionRange(start + 1, start + 1);
                    e.preventDefault();
                }
            }
        };

        document.querySelectorAll(".uc-text-smooth").forEach(function(current) {
            current.addEventListener("keypress", forceKeyPressUppercase);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const subscriptionField = document.getElementById('subscription_field');
            const details = document.querySelectorAll('.subscription-details');

            function toggleDetails() {
                if (subscriptionField.value === '0') {
                    details.forEach(el => el.style.display = 'none');
                } else {
                    details.forEach(el => el.style.display = 'block');
                }
            }

            // Run on page load (handles old() values)
            toggleDetails();

            // Run on change
            subscriptionField.addEventListener('change', toggleDetails);
        });
    </script>
@endsection
