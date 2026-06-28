@extends('layouts.user-app')

@section('title', 'Update Basic Details')

@section('style')
    <style>
        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }

        .btn-primary {
            background-color: #0f4547;
        }
        label{
            font-size: 14px;
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

        .revert-remarks-box {
            padding: 20px;
            margin: 30px auto;
            max-width: 600px;
            background-color: #f9f9f9;
            border-left: 5px solid #dc3545;
            /* Red left border */
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

    @include('components.multistep-existing')
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
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Update Basic Details&nbsp;
                                </span>
                            </div>
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
                                            <label for="registration_type"
                                                class="form-label text-danger font-weight-bold mb-2">
                                                Select Registration Type According to Remarks:
                                            </label>
                                            <select class="form-control change-route" name="registration_type"
                                                id="registration_type">
                                                <option value="{{ $formdata->form->already_registered }}" disabled selected>
                                                    {{ $formdata->form->already_registered == 1 ? 'Onboarding' : 'New Registration' }}
                                                </option>

                                                <option value="0">New Registration</option>
                                                <option value="1">On Boarding</option>
                                            </select>
                                            <small class="form-text text-muted mt-2">
                                                Please select the appropriate type based on the provided remarks and
                                                reasons.
                                            </small>
                                        </div>
                                    </div>


                                </div>
                            @endif

                            @if ($remarks)
                                <!-- Bootstrap Modal -->
                                <div class="modal fade" id="remarksModal" tabindex="-1" role="dialog"
                                    aria-labelledby="remarksModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="remarksModalLabel">Remarks</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Existing BOCW Card</label>
                                                    <input type="text" name="worker_id" id="existing-card-no"
                                                        class="form-control"
                                                        placeholder="Please Enter your BOCW ID card number"
                                                        oninput="this.value = this.value.toUpperCase()">
                                                    <input type="hidden" name="already_registered" value="1"
                                                        id="already_registered" class="form-control">
                                                    <input type="hidden" id="worker_id_revert" name="worker_id"
                                                        value="{{ $xyz->worker_id }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" id="existing-bocw-reg"
                                                    data-dismiss="modal">Submit</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <form action="{{ route('update-existing-basic-data') }}"
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
                                <div class="form-row mt-3" style="display: flex"><!--start 1-->
                                    <div class="form-group col-md-12">
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
                                                <label for="state ml-3">Your state is:
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
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-row mt-4"><!--start 2-->
                                    <div class="form-group col-md-3">
                                        <label for="inputFirstName"
                                            class="">{{ trans('worker-registration/worker_basic_details.name') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                               style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control" id="f_name_uid"
                                            value="{{ $getVaultData['name'] }}" name="name" readonly>
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label for="inputLastName"
                                            class="">{{ trans('worker-registration/worker_basic_details.care_of') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control" id="care_of"
                                            value="{{ $getVaultData['careOf'] }}" name="care_of" readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="gender"
                                            class="">{{ trans('worker-registration/worker_basic_details.gender') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control" id="gender_uid"
                                            value="{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : ($getVaultData['gender'] == 'T' ? 'Transgender' : 'Unknown')) }}"
                                            readonly>
                                    </div>

                                    <input type="hidden" id="retirement_date" class="form-control"
                                        value="{{ $formdata->date_of_retirement }}" name="date_of_retirement" readonly>
                                    <div class="form-group col-md-3">
                                        <label for="inputDob"
                                            class="">{{ trans('worker-registration/worker_basic_details.dob') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" id="dob" class="form-control" name="dob"
                                            value="{{ \Carbon\Carbon::parse($getVaultData['dob'])->format('Y-m-d') }}"
                                            readonly>
                                    </div>



                                </div>

                                @if ($remarks)
                                    <div class="form-row mt-4"><!--start 4-->
                                        <div class="form-group col-md-3">
                                            <label for="inputFirstName">
                                                {{ trans('worker-registration/worker_basic_details.name') }}
                                            </label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" class="form-control" id="f_name_old"
                                                value="{{ $formdata->old_name }}" name="old_name" required>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputLastName">
                                                {{ trans('worker-registration/worker_basic_details.care_of') }}
                                            </label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" class="form-control" id="care_of_old"
                                                value="{{ $formdata->old_care_of }}" name="care_of_old" required>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="gender" class="">
                                                {{ trans('worker-registration/worker_basic_details.gender') }}
                                            </label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            {{--@if (optional($formdata->gender->gender_name == 'NA') || empty(optional($formdata->gender->gender_name)))--}}
                                                {{--<select class="form-control" id="gender_old" name="gender_id" required>--}}
                                                    {{--<option value="">Select Gender</option>--}}
                                                    {{--@foreach ($gender as $g)--}}
                                                        {{--<option value="{{ $g->gender_code }}">{{ $g->gender_name }}</option>--}}
                                                    {{--@endforeach--}}
                                                {{--</select>--}}
                                            <select id="inputCategory" class="form-control custom-bottom-border" name="gender_id">
                                                @if (!empty($formdata) && optional($formdata->gender)->gender_code)
                                                    <option value="{{ $formdata->gender->gender_code }}" selected>
                                                        {{ $formdata->gender->gender_name }}
                                                    </option>
                                                @else
                                                    <option value="" selected disabled>Select Gender</option>
                                                @endif

                                                @if (!empty($gender) && count($gender) > 0)
                                                    @foreach ($gender as $g)
                                                        <option value="{{ $g->gender_code }}">{{ $g->gender_name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled>No gender data available</option>
                                                @endif
                                            </select>



                                            {{--@else--}}
                                                {{--<input type="text" class="form-control" id="gender_old"--}}
                                                       {{--name="gender_id" value="{{$formdata->gender->gender_name}}" readonly>--}}
                                            {{--@endif--}}


                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputDob" class="">
                                                {{ trans('worker-registration/worker_basic_details.dob') }}
                                            </label>
                                            <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="date" id="old_dob"
                                                class="form-control custom-bottom-border" name="old_dob" placeholder=""
                                                value="{{ $formdata->old_dob }}" required>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row mt-4"><!--start 4-->
                                        <div class="form-group col-md-3">
                                            <label for="inputFirstName"
                                                class="">{{ trans('worker-registration/worker_basic_details.name') }}</label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" class="form-control" id="f_name_old"
                                                value="{{ $formdata->old_name }}" name="old_name" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputLastName"
                                                class="">{{ trans('worker-registration/worker_basic_details.care_of') }}</label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" class="form-control" id="care_of_old"
                                                value="{{ $formdata->old_care_of }}" name="care_of_old" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="gender"
                                                class="">{{ trans('worker-registration/worker_basic_details.gender') }}</label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" class="form-control" id="gender_uid"
                                                value="{{ $formdata->gender->gender_name }}" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputDob" class="">
                                                {{ trans('worker-registration/worker_basic_details.dob') }}</label>
                                            <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
        {{ trans('worker-registration/worker_basic_details.olddatabase') }}
    </span>
                                            <input type="text" id="old_dob"
                                                class="form-control" name="old_dob" placeholder="NA"
                                                value="{{ $formdata->old_dob }}">
                                        </div>


                                    </div>
                                @endif


                                <div class="form-row mt-4">
                                    <div class="form-group col-md-3">
                                        <label for="inputAge">{{ trans('worker-registration/worker_basic_details.age') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control" name="age_aadhar" id="age"
                                            readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="mStatus">{{ trans('worker-registration/worker_basic_details.marital_status') }}</label><span
                                            class="text-danger font-italic font-weight" style="font-size: 12px;">*</span>
                                        <select id="inputState" class="form-control custom-bottom-border"
                                            name="maritial_status_id">
                                            <option value="{{ $formdata->maritalStatus->marital_code }}">{{ $formdata->maritalStatus->marital_status}}
                                            </option>
                                            @foreach ($marital as $key => $mar)
                                                <option value="{{ $mar->marital_code }}">{{ $mar->marital_status }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('maritial_status_id'))
                                            <span
                                                class="text-danger font-weight-small error-message">{{ $errors->first('maritial_status_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputCategory">{{ trans('worker-registration/worker_basic_details.category') }}</label><span
                                            class="text-danger font-italic font-weight" style="font-size: 12px;">*</span>
                                        <select id="inputCategory" class="form-control custom-bottom-border"
                                            name="category">
                                            <option value="{{ $formdata->cateGory->category_code }}" selected>
                                                {{ $formdata->cateGory->category_name }}
                                            </option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->category_code }}">{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('category') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone">{{ trans('worker-registration/worker_basic_details.contact') }}
                                        </label>
                                        <input type="text" class="form-control custom-bottom-border" id="phone"
                                            placeholder="{{ $xyz->phone_no }}" readonly>

                                    </div>

                                </div>

                                <div class="form-row mt-4"><!--start 1-->
                                    @if ($formdata->eshram_no != null)
                                        <div class="form-group col-md-3" id="eshram-field">
                                            <label for="inputPF">{{ trans('worker-registration/worker_basic_details.eshram') }}</label>
                                            <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">Verified</span>
                                            <input type="text" class="form-control" id="eShram"
                                                value="{{ $formdata->eshram_no }}" name="eshram_no" maxlength="12"
                                                readonly>
                                            <span class="error" id="eShramError"></span>
                                            @if ($errors->has('eshram_no'))
                                                <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('eshram_no') }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone">{{ trans('worker-registration/worker_basic_details.education') }}</label><span
                                            style="color:red;">*</span>
                                        <select id="inputCategory" class="form-control custom-bottom-border"
                                            name="education_id">
                                            <option value="{{ $formdata->education->education_code }}">
                                                {{ $formdata->education->education_name }} </option>
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
                                        <label for="inputPhone">{{ trans('worker-registration/worker_basic_details.blood_group') }}</label><span
                                            style="color:red;">*</span>
                                        <select id="inputCategory" class="form-control custom-bottom-border"
                                            name="blood_group">
                                            <option value="{{ $formdata->bloodGroup->id }}">{{ $formdata->bloodGroup->blood_group }} </option>
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
                                        <label for="inputPhone">{{ trans('worker-registration/worker_basic_details.issuedate') }}</label>
                                        <span style="color:red;">*</span>
                                        <input type="text" placeholder="DD-MM-YYYY"
                                            class="form-control white-background" id="last_registration_date"
                                            value="{{ $formdata->last_registration_date }}"
                                            name="last_registration_date">
                                        @if ($errors->has('last_registration_date'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('last_registration_date') }}</span>
                                        @endif
                                    </div>

                                </div><!--end-->
                                <div class="form-row mt-4">
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone">{{ trans('worker-registration/worker_basic_details.validitydate') }}</label>
                                        <span style="color:red;">*</span>
                                        <input type="text" placeholder="DD-MM-YYYY"
                                            class="form-control white-background" id="card_validity_date"
                                            value="{{ $formdata->card_validity_date }}
                                                "
                                            name="card_validity_date">
                                        @if ($errors->has('card_validity_date'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('card_validity_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="subscription_field" class="">Do you have Subscription Receipt</label><span class="text-danger">*</span>
                                        <select class="form-control" id="subscription_field" name="subscription_receipt">
                                            <option value="">Select</option>
                                            <option value="1" {{ $formdata->subscription_receipt == '1' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.have') }}
                                            </option>
                                            <option value="0" {{ $formdata->subscription_receipt == '0' ? 'selected' : '' }}>
                                                {{ trans('worker-registration/worker_basic_details.donthave') }}
                                            </option>
                                        </select>
                                        @if ($errors->has('subscription_receipt'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('subscription_receipt') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3" id="subscription_date_group">
                                        <label for="subscription_payment_date">{{ trans('worker-registration/worker_basic_details.subscription_date') }}</label><span style="color:red;">*</span>
                                        <input type="text" placeholder="DD-MM-YYYY" class="form-control white-background" id="subscription_payment_date"
                                               name="subscription_payment_date" value="{{ $formdata->subscription_payment_date }}">
                                        @if ($errors->has('subscription_payment_date'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('subscription_payment_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3" id="subscription_amount_group">
                                        <label for="subscription_amount_paid">{{ trans('worker-registration/worker_basic_details.amount') }}</label><span style="color:red;">*</span>
                                        <input type="text" name="subscription_amount_paid" class="form-control" id="subscription_amount_paid" value="{{ $formdata->subscription_amount_paid }}">
                                        @if ($errors->has('subscription_amount_paid'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('subscription_amount_paid') }}</span>
                                        @endif
                                    </div>





                                </div>

                                <div class="form-row mt-4"><!--start 1-->

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone">Profession</label><span
                                                style="color:red;">*</span>
                                        <select class="form-control" name="profession" id="profession_1" onchange="checkOthers()">
                                            @if (!empty($formdata) && optional($formdata->Profession)->profession_code)
                                                <option value="{{ $formdata->Profession->profession_code }}" selected>
                                                    {{ $formdata->Profession->profession_name }}
                                                </option>
                                            @else
                                                <option value="" selected disabled>Select Profession</option>
                                            @endif

                                            @if (!empty($professions) && count($professions) > 0)
                                                @foreach ($professions as $profession)
                                                    <option value="{{ $profession->profession_code }}">{{ $profession->profession_name }}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled>No profession data available</option>
                                            @endif
                                        </select>

                                    @if ($errors->has('profession'))
                                            <span
                                                    class="text-danger font-weight-normal error-message">{{ $errors->first('profession') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3 d-none" id="others_1">
                                        <label for="inputPhone">Other Profession</label><span
                                            style="color:red;">*</span>
                                        <input value="{{ $formdata->profession_others }}" type="text"
                                            name="profession_others" class=" fixed-width form-control"
                                            placeholder="Enter Other Profession" />
                                        @if ($errors->has('profession_others'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('profession_others') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="inputEsic">Email-Id</label>
                                        <input type="text" class="form-control custom-bottom-border" id="email"
                                            value="{{ $formdata->email }}" name="email"
                                            placeholder="{{ trans('worker-registration/worker_basic_details.enteremail') }}">
                                        @if ($errors->has('email'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="pan_availability">{{ trans('worker-registration/worker_basic_details.pan') }}
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
                                        <label for="pan_number">{{ trans('worker-registration/worker_basic_details.pan_no') }}</label>
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
                                        <label for="boc_availability">{{ trans('worker-registration/worker_basic_details.already_registered') }}
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
                                    <div class="col-md-5" id="boc_field"
                                        style="{{ $formdata->boc == '1' ? 'display: block;' : 'display: none;' }}">
                                        <label for="other_state">Select the State of the board under which
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
                                        <label for="boc_number">BOCW Membership ID</label><span
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
                                        <label for="has_ration_card">{{ trans('worker-registration/worker_basic_details.ration_card_have') }}</label><span
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
                                        <label for="ration_no">{{ trans('worker-registration/worker_basic_details.ration_card') }}</label><span
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
                                        <label for="ration_type">{{ trans('worker-registration/worker_basic_details.ration_card_type') }}</label><span
                                            style="color:red;">*</span>
                                        <select class="form-control custom-bottom-border" id="ration_type"
                                            name="ration_type">
                                            @if (!empty($formdata->ration_type))
                                                {{-- Preselected option if form is in edit mode --}}
                                                <option value="{{ $formdata->rationType->ration_code }}" selected>
                                                    {{ $formdata->rationType->name }}</option>
                                            @else
                                                {{-- Default placeholder option --}}
                                                <option value="" selected>
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
                                        <a href="{{ route('update-existing-office-address-page') }}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-backward"
                                                aria-hidden="true"></i>&nbsp;
                                            {{ trans('worker-registration/worker-registration-address.previous') }}</a>
                                        <button type="submit" class="btn btn-sm btn-primary" id="submitBtn">Update Basic
                                            Details&nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i></button>
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
<script src="{{ URL::asset('assets/template/vendor/jquery/ajax-jquery-3.7.min.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
<script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>

@include('components.assamese-keyboard')

@section('footer')
    <script>
        function toggleSubscriptionFields() {
            const subscriptionField = document.getElementById('subscription_field');
            const dateGroup = document.getElementById('subscription_date_group');
            const amountGroup = document.getElementById('subscription_amount_group');
            const dateInput = document.getElementById('subscription_payment_date');
            const amountInput = document.getElementById('subscription_amount_paid');

            if(subscriptionField.value === '1') {
                dateGroup.style.display = 'block';
                amountGroup.style.display = 'block';
            } else {
                dateGroup.style.display = 'none';
                amountGroup.style.display = 'none';
                dateInput.value = '';
                amountInput.value = '';
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', toggleSubscriptionFields);

        // Run on change
        document.getElementById('subscription_field').addEventListener('change', toggleSubscriptionFields);
    </script>

    <script>
        $(document).ready(function() {
            $('.change-route').change(function() {
                let selectedValue = $(this).val();
                let workerId = $('#worker_id_revert').val();

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
        $(document).ready(function() {
            $('#remarksModal').modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
        });

        document.getElementById('existing-bocw-reg').addEventListener("click", function() {
            var existing_id = $("#existing-card-no").val();
            var worker_id_revert = $("#worker_id_revert").val();
            var already_registered = $("#already-registered").val();


            if (!existing_id) {
                Swal.fire({
                    icon: 'error',
                    text: 'Existing ID Card No is required.',
                    confirmButtonText: 'OK',
                });
                return;
            }


            showLoader();
            $.ajax({
                type: "POST",
                url: "{{ route('update-bocw-reg-number') }}",

                dataType: 'JSON',
                data: {

                    existing_id: existing_id,
                    worker_id_revert: worker_id_revert,
                    already_registered: already_registered,

                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    hideLoader();

                    if (response.status === true) {
                        $('#remarksModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            text: 'Details Updated Successfully',
                            confirmButtonText: 'OK',
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
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            checkOthers();
        });

        function checkOthers() {
            var othersSelect = document.getElementById("others_1");
            var professionType = document.getElementById("profession_1").value;

            if (professionType === "28") {
                othersSelect.classList.remove("d-none");
            } else {
                othersSelect.classList.add("d-none");
            }
        }
    </script>

    <script>
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
            dateFormat: "Y-m-d",
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

            // Subtract days based on whether the duration spans a leap year
            if (leapYearInRange) {
                // If the duration spans a leap year, subtract 2 days
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

        // Call validateDates on page load if data is already present
        window.onload = function() {
            validateDates();
        };

        // Attach validateDates to onchange events
        document.getElementById('last_registration_date').addEventListener('change', validateDates);
        document.getElementById('card_validity_date').addEventListener('change', validateDates);
        if (document.getElementById('last_renewal_date')) {
            document.getElementById('last_renewal_date').addEventListener('change', validateDates);
        }
    </script>

    <script>
        window.onload = function() {
            const dobInput = document.getElementById('dob');
            const ageInput = document.getElementById('age');
            const retirementInput = document.getElementById('retirement_date');

            if (!dobInput || !dobInput.value) return;

            // Get DOB in yyyy-mm-dd
            const dob = dobInput.value.trim();
            const [year, month, day] = dob.split('-').map(Number);

            // Calculate age based only on the year
            const today = new Date();
            const age = today.getFullYear() - year;

            ageInput.value = age;

            // Calculate retirement date (60 years after DOB)
            const retirementYear = year + 60;
            const retirementDate = new Date(retirementYear, month - 1, day);

            // Format retirement date as yyyy-mm-dd
            const formattedRetirementDate = retirementDate.toISOString().slice(0, 10);
            retirementInput.value = formattedRetirementDate;

            // Debug log
            console.log('DOB:', dob);
            console.log('Age (year-based):', age);
            console.log('Retirement Date:', formattedRetirementDate);
        };
    </script>


    <script>
        // Function to calculate and update age
        function calculateAge() {
            var old_dob = document.getElementById('old_dob').value;

            // Check if date of birth is provided
            if (old_dob) {
                var dobComponentsold = old_dob.split('-');
                var yearIndexold = dobComponentsold.length === 1 ? 0 :
                    0; // Year will always be at index 0 in 'YYYY-MM-DD' format
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
    <script></script>
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
@endsection
