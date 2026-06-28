@extends('layouts.user-app')

@section('title', ' Preview')

@section('style')

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }

        .btn-primary {
            color: white;
        }
        tr td{
            font-size: 14px;
            text-align: center;
        }

        a.href {
            text-decoration: none;
            /* Remove the default underline */
            color: #219fa4;
            /* Set the link color */
            transition: color 0.2s;
            /* Smooth color transition on hover */
        }

        a.href:hover {
            color: #ff6b6b;
            /* Change the color on hover */
        }

        h5 {
            color: #076f6b;
            position: relative;
            display: inline-block;
        }

        h5.preview-color {
            color: #076f6b;
        }

        h5::after {
            content: "";
            display: block;
            width: 100%;
            height: 2px;
            background-color: #ffbf49;
            position: absolute;
            bottom: -5px;
            left: 0;
            transform: scaleX(1);
            transform-origin: bottom left;
            transition: transform 0.3s ease;
        }
        /*label.bold{*/
            /*font-weight: 600;*/
            /*font-size: 14px;*/
        /*}*/

        h5:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        i {
            margin-right: 5px;
        }

        .custom-form {
            border: 2px solid rgba(0, 0, 0, .075);
            /* Border color - a shade of blue */
            border-radius: 10px;
            /* Border radius for rounded corners */
            padding: 20px;
            /* Padding inside the form */
            margin-top: 10px;
            /* Margin to separate the form from other elements */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add a subtle box shadow */
            /*background-color: #f4f4f4;*/
            /* Background color - a light gray */
        }


        .form-group {
            margin-bottom: 15px;
            /* Margin between form groups */
        }

        .table th {
            font-size: 10px;
        }

        .table-container {
            overflow-x: auto;
        }

        .fixed-width {
            min-width: 200px;
            /* Adjust the width as needed */
        }

        .fixed {
            min-width: 200px;
            /* Adjust the width as needed */
        }

        .table thead th {
            border-bottom: 1px solid black;

        }
        body{
            background-color: #f1f1f1;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
        }
        .form-control {
            height: 30px;
            /* Adjust the height as needed */
        }
        .table input.form-control,
        .table select.form-select {
            min-width: 160px;
            padding: 6px 10px;
            font-size: 12px;
        }
        .fixed-width-up{
            min-width: 200px;
        }
        /* Table Header Style */
        .table thead th {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            padding: 10px 8px;
            background-color: white;
            vertical-align: middle;
            white-space: nowrap;
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border-bottom: 1px solid #dee2e6;
        }


        /* Additional spacing for fields with conditional inputs */
        .table td {
            vertical-align: middle;
        }

        /* Conditional text fields like 'Other Profession' */
        .table input.d-none,
        .table input[type="text"].d-none {
            display: none !important;
        }

        /* Button adjustments */
        .table .btn-sm {
            padding: 4px 10px;
            font-size: 12px;
        }

        /* Input field placeholder styling */
        .table input::placeholder {
            color: #6c757d;
            font-size: 12px;
        }
        /*.bold {*/
            /*font-weight: 500;*/
            /*font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;*/
            /*font-size: 13px;*/
            /*!*color: #186cb8;*!*/
            /*color: #8b5050 !important;*/
            /*!*color: #7ea1a2;*!*/
        /*}*/
        .edit-icon {
            position: relative;
            top: 0;
            right: 0;
            text-decoration: none;

        }
        .edit-icon:hover {
            text-decoration: none; /* Ensures no underline on hover */

        }
        .app-photo{
            width: 122px;
            height: 200px;
            border-radius: 10px;
            box-shadow: -2px 2px #4b4a4a;
            filter: brightness(1.3);
            display: block;
            margin: 0 auto;
            margin-bottom: 15px;
        }
        .heading-with-photo{
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
            text-align: center;
        }

        body,.form-control-plaintext{font-size:14px;}
        .familydob{
            padding: 3px;
            display: flex;
            width:105px;
            height: 50px;
            align-items: center;
            justify-content: center;
        }
        .user-photo{
            position: relative;
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
            display: block;
            box-shadow: -3px 3px #ccc;
        }

        .user-photo-box{
            background: #d6d9dd;
            border-radius: 8px;
            width: 110px;
            position: absolute;
            top: 78px;
            right: 30px;
        }


        /*.bold {*/
            /*font-weight: 500;*/
            /*font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;*/
            /*font-size: 14px;*/
            /*!*color: #186cb8;*!*/
            /*color: #219fa4;*/
            /*!*color: #7ea1a2;*!*/
        /*}*/
        /* Wrapper boxes */
        .reverted-box, .photo-box {
            padding: 20px;
            margin: 30px auto;
            /*max-width: 600px;*/
            background-color: #f9f9f9;
            border-left: 5px solid #dc3545; /* Red left border */
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Section titles */
        .reverted-box h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #0d6efd; /* Bootstrap primary color */
        }

        /* Remarks and list */
        .reverted-box ul {
            padding-left: 1.2rem;
            margin-bottom: 1rem;
        }

        .reverted-box li {
            color: #dc3545; /* Bootstrap danger color */
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
        }

        /* Officer remarks paragraph */
        .reverted-box p.text-danger {
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        /* Note styling */
        .reverted-box .note {
            font-style: italic;
            color: #6c757d; /* Bootstrap muted color */
            font-size: 0.9rem;
        }

        /* Image box */
        .photo-box img {
            height: 200px;
            width: 150px;
            object-fit: cover;
            border-radius: 0.25rem;
            border: 1px solid #ccc;
        }

    </style>
@endsection


@section('content')
    @include('components.multistep')

    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-wrapper">
                            <h4 class="text-center font-weight-bold" style="color: #2badee;">
                                {{ trans('worker-registration/worker-data-preview.apppreview') }}</h4>
                        </div>


                        @if ($remarks)
                            <div class="row mt-3">
                                <!-- Left Section: Remarks and Reasons -->
                                <div class="form-group col-md-6">
                                    <div class="reverted-box">
                                        <h5 class="text-primary mb-3">
                                            For the following reasons, the application has been reverted:
                                        </h5>

                                        <ul class="pl-3">
                                            @foreach ($remarks->getReasons($remarks->worker_id) as $remark)
                                                <li class="text-danger">{{ $remark->reason }}</li>
                                            @endforeach
                                        </ul>

                                        <div class="mt-4">
                                            <h5 class="text-primary">Remarks from Officers:</h5>
                                            <p class="text-danger mb-2">{{ $remarks->remarks }}</p>
                                        </div>

                                        <p class="text-muted font-italic mb-0">
                                            <strong>Note:</strong> Please correct all the fields before final submission.
                                        </p>
                                    </div>
                                </div>

                                <!-- Right Section: Applicant Photo -->
                                <div class="form-group col-md-6 d-flex align-items-start justify-content-center mt-3">
                                    <div class="card border-0 shadow-sm p-2">
                                        <img src="data:image/jpeg;base64,{{ $aadhar_photo }}" alt="Applicant Photo"
                                             class="img-fluid rounded" style="height: 200px; width: 150px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>

                        @else
                            <div class="mt-3" style="display: flex; justify-content:center">
                                @if (!empty($aadhar_photo))
                                    <img src="data:image/jpeg;base64,{{$aadhar_photo}}"
                                         alt="Applicant Photo"
                                         class="app-photo"
                                         style="width: 120px; height: 160px; border-radius: 8px; object-fit: cover;">
                                @else
                                    <p>No photo available.</p>
                                @endif
                            </div>


                        @endif
                        {{--                    <h5 style="border-bottom:2px solid #0b0e25;width: 25%;" class="mt-3"><i class="fa fa-info-circle" aria-hidden="true"></i>Basic Details:</h5> --}}
                        <div class="form-row mt-2"><!--start 1-->
                            <div class="form-check col-md-12" style="text-align: center;">
                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Worker Basic Details
                                        </span>
                                </h5>
                            </div>
                        </div>
                        <div class="custom-form">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label
                                       >{{ trans('worker-registration/worker-data-preview.workerstatus') }}</label>
                                    @if ($worker_details->basicDetail->resident_type === 'rao')
                                        <input type="text" class="form-control" value="Migrant Worker" readonly>
                                    @else
                                        <input type="text" class="form-control" value="Resident Worker" readonly>
                                    @endif
                                </div>
                                @if ($worker_details->basicDetail->resident_type == 'rao')
                                    <div class="form-group col-md-3">
                                        <label>State</label>
                                        <input type="text" class="form-control" placeholder=""
                                            value="{{ $getVaultData['state'] }}" readonly />
                                    </div>
                                @endif
                                <div class="form-group col-md-5 position-relative">
                                    <label>Office Applied At</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="office_name_display"
                                            value="{{ $worker_details->officeName->office_name }}" readonly />
                                        <div class="input-group-append">
                                            <button type="button" class="btn-primary btn-sm border" data-toggle="modal"
                                                data-target="#editOfficeModal">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bootstrap Modal -->
                                <div class="modal fade" id="editOfficeModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editOfficeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document"> <!-- Centered modal -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-white">Update Office</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="updateOfficeForm">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Select District<span class="text-danger">*</span></label>
                                                        <select class="form-control" id="district_code_edit"
                                                            name="district_id" required>
                                                            <option value="">--Select District--</option>
                                                            @foreach ($dists as $district)
                                                                <option value="{{ $district->district_code }}">
                                                                    {{ $district->district_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Select Office<span class="text-danger">*</span></label>
                                                        <select name="office_id" class="form-control" id="office_id_edit"
                                                            required>
                                                            <option value="">
                                                                {{ trans('worker-registration/worker_new_registration.select_office') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" id="updateOfficeBtn"
                                                    class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="form-row mt-2"><!--start 1-->
                                <div class="form-group col-md-3">
                                    <label for="inputFirstName"
                                       >{{ trans('worker-registration/worker-data-preview.name') }}</label>
                                    <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                        {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input class="form-control uc-text-smooth" value="{{ $getVaultData['name'] }}"
                                        readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputLastName">Care Of</label>
                                    <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                        {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input class="form-control  uc-text-smooth" value="{{ $getVaultData['careOf'] }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="gender"
                                       >{{ trans('worker-registration/worker-data-preview.gender') }}</label>
                                    <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                        {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input type="text" class="form-control  uc-text-smooth"
                                        value="{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : ($getVaultData['gender'] == 'T' ? 'Transgender' : 'Unknown')) }}"
                                        readonly>

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputDob"
                                       >{{ trans('worker-registration/worker-data-preview.dob') }}</label>
                                    <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                        {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input type="text" id="dob" class="form-control  datepicker" name="dob"
                                        value="{{ $getVaultData['dob'] }}" disabled>
                                </div>

                            </div><!--end-->

                            <div class="form-row"><!--start 1-->

                                <div class="form-group col-md-3">
                                    <label for="inputAdhaar"
                                       >{{ trans('worker-registration/worker-data-preview.aadhaar') }}</label>
                                    <input type="text" id="dob" class="form-control"
                                        value="{{ $getVaultDatauID }}" disabled>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputAge"
                                    >{{ trans('worker-registration/worker-data-preview.age') }}
                                    </label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                        {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                    <input type="text" class="form-control custom-bottom-border" id="age"
                                        value="" placeholder="" disabled>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPhone"
                                       >{{ trans('worker-registration/worker-data-preview.mobile') }}
                                    </label>
                                    <input type="text" class="form-control " value="{{ $worker_details->phone_no }}"
                                        disabled>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="mStatus"
                                       >{{ trans('worker-registration/worker-data-preview.marital') }}</label>
                                    <input type="text" class="form-control "
                                        value="{{ $worker_details->basicDetail->maritalStatus->marital_status }}"
                                        readonly>
                                </div>
                            </div><!--end-->

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputCategory"
                                       >{{ trans('worker-registration/worker-data-preview.category') }}</label>
                                    <input type="text" class="form-control " id="age"
                                        value="{{ $worker_details->basicDetail->cateGory->category_name }}" disabled>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPF"
                                       >{{ trans('worker-registration/worker-data-preview.eshram') }}</label>
                                    <span class="badge bg-danger text-light position-relative top-0 end-0 mt-1 me-1"
                                          style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                        Verified
        </span>
                                    <input type="text" class="form-control  uc-text-smooth"
                                        value="{{ $worker_details->basicDetail->eshram_no }}" readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPF"
                                       >{{ trans('worker-registration/worker-data-preview.blood') }}</label>
                                    <input type="text" class="form-control  uc-text-smooth"
                                        value="{{ $worker_details->basicDetail->bloodGroup->blood_group }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPhone"
                                       >{{ trans('worker-registration/worker-data-preview.education') }}</label>
                                    <input type="text" class="form-control  uc-text-smooth"
                                        value="{{ $worker_details->basicDetail->education->education_name }}" readonly>
                                </div>
                            </div>

                            <div class="form-row"><!--start 1-->
                                <div class="form-group col-md-3">
                                    <label for="inputEsic">Email </label>
                                    <input type="text" class="form-control  uc-text-smooth"
                                        value="{{ $worker_details->basicDetail->email ?: 'NA' }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPhone"
                                       >{{ trans('worker-registration/worker-data-preview.panyes') }}</label>
                                    <input type="text" class="form-control "
                                        value="{{ $worker_details->basicDetail->pan == 1 ? 'Yes' : 'No' }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPhone"
                                       >{{ trans('worker-registration/worker-data-preview.alreadyreg') }}</label>
                                    <input type="text" class="form-control "
                                        value="{{ $worker_details->basicDetail->boc == 1 ? 'Yes' : 'No' }}" readonly>
                                </div>

                            </div><!--end-->
                            <div class="form-row"><!--start 1-->

                                @if ($worker_details->basicDetail->pan == 1)
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                           >{{ trans('worker-registration/worker-data-preview.pan') }}</label>
                                        <input type="text" class="form-control "
                                            value="{{ $worker_details->basicDetail->pan_no }}" readonly>
                                    </div>
                                @endif


                                @if ($worker_details->basicDetail->boc == '1')
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                           >{{ trans('worker-registration/worker-data-preview.boc') }}</label>
                                        <input type="text" class="form-control "
                                            value="{{ $worker_details->basicDetail->boc_no }}" id="pan_no"
                                            name="pan_no" readonly>
                                    </div>
                                @endif
                            </div><!--end-->
                            <div class="form-row"><!--start 1-->
                                <div class="form-group col-md-4">
                                    <label for="inputPF"
                                       >{{ trans('worker-registration/worker-data-preview.rationcardyes') }}</label>
                                    <input type="text" class="form-control "
                                        value="{{ $worker_details->basicDetail->has_ration_card == 1 ? 'Yes' : 'No' }}"readonly>
                                </div>
                                @if ($worker_details->basicDetail->has_ration_card == 1)
                                    <div class="form-group col-md-3">
                                        <label for="inputPF"
                                           >{{ trans('worker-registration/worker-data-preview.rationcardno') }}</label>
                                        <input type="text" class="form-control " id="ration_no" name="ration_no"
                                            value="{{ $worker_details->basicDetail->ration_no }}" placeholder=""
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPF"
                                           >{{ trans('worker-registration/worker-data-preview.rationcardtype') }}</label>
                                        <input type="text" class="form-control " id="ration" name="ration_type"
                                            value="{{ $worker_details->basicDetail->rationType->name }}" placeholder=""
                                            readonly>
                                    </div>
                                @endif
                            </div>
                            <div class="form-row  mt-4"><!--start 1-->
                                <div class="form-check col-md-12" style="text-align: center;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Permanent Residential Details
                                        </span>
                                    </h5>
                                </div>
                            </div>
                            <div class="custom-form">
                                <div class="form-row mt-5"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputFirstName"
                                           >{{ trans('worker-registration/worker-data-preview.state') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}</span>
                                        <input type="text" class="form-control custom-bottom-border" id="p_state"
                                            value="{{ $getVaultData['state'] }}" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputLastName"
                                           >{{ trans('worker-registration/worker-data-preview.district') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}</span>
                                        <input type="text" class="form-control custom-bottom-border" id="p_Dist"
                                            value="{{ $getVaultData['district'] ?: 'NA' }}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPassword4"
                                           >{{ trans('worker-registration/worker-data-preview.subdistrict') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border"
                                            value="{{ $getVaultData['subDistrict'] ?: 'NA' }}" id="p_subD" readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="permanentRoad"
                                           >{{ trans('worker-registration/worker-data-preview.postoffice') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                            id="p_post" value="{{ $getVaultData['postOffice'] ?: 'NA' }}" readonly>
                                        <span id="p_roadError" class="error"></span>
                                    </div>


                                </div><!--end-->
                                <div class="form-row mt-1"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputMstatus"
                                           >{{ trans('worker-registration/worker-data-preview.village') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                        style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" id="permanentCity"
                                            class="form-control custom-bottom-border uc-text-smooth"
                                            placeholder="Enter city" id="p_vill"
                                            value="{{ $getVaultData['village'] ?: 'NA' }}" readonly>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="gender"
                                           >{{ trans('worker-registration/worker-data-preview.street') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                       style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                            id="p_street" name="p_area" value="{{ $getVaultData['street'] ?: 'NA' }}"
                                            placeholder="Enter area" readonly>
                                        <span id="p_areaError" class="error"></span>
                                        @if ($errors->has('p_area'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('p_area') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputDob"
                                           >{{ trans('worker-registration/worker-data-preview.locality') }}</label><span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
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
                                           >{{ trans('worker-registration/worker-data-preview.landmark') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                            id="p_landmark" name="p_area"
                                            value="{{ $getVaultData['landMark'] ?: 'NA' }}" placeholder="Enter area"
                                            readonly>
                                        @if ($errors->has('p_district'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('p_district') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->
                                <div class="form-row mt-1"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputAge"
                                           >{{ trans('worker-registration/worker-data-preview.pincode') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                            id="p_pin" name="p_area" value="{{ $getVaultData['pinCode'] ?: 'NA' }}"
                                            placeholder="Enter area" readonly>
                                        @if ($errors->has('p_circle'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('p_circle') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputCategory"
                                           >{{ trans('worker-registration/worker-data-preview.postoffice') }}</label>
                                        <span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                              style="font-size: 10px; padding: 6px 10px; border-radius: 12px;">
    <i class="fa fa-check-circle"></i>
                                            {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth"
                                            id="p_office" name="p_area"
                                            value="{{ $getVaultData['postOffice'] ?: 'NA' }}" placeholder="Enter area"
                                            readonly>
                                    </div>

                                </div><!--end-->
                            </div><!--end-->

                            <div class="form-row mb-4 mt-3"><!--start 1-->
                                <div class="form-check col-md-12" style="text-align: center;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Current Residential Details
                                        </span>
                                    </h5>
                                </div>
                            </div><!--end-->
                            <div class="custom-form">
                                <div class="form-row"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputFirstName"
                                           >{{ trans('worker-registration/worker-data-preview.residencetype') }}</label>
                                        <input type="text" class="form-control "
                                            value="{{ $worker_details->address->currentResidence->residence_name ?: 'NA' }}"
                                            id="esic_no" name="esic_no" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputLastName"
                                           >{{ trans('worker-registration/worker-data-preview.housetype') }}</label>
                                        <input type="text" class="form-control "
                                            value="{{ $worker_details->address->currentHouse->house_type ?: 'NA' }}"
                                            id="esic_no" name="esic_no" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPassword4"
                                           >{{ trans('worker-registration/worker-data-preview.houseno') }}</label>
                                        <input type="text" class="form-control "
                                            value="{{ $worker_details->address->c_house_no ?: 'NA' }}"
                                            id="currentBuilding" name="c_house_no" placeholder="" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="gender"
                                           >{{ trans('worker-registration/worker-data-preview.area_village') }}</label>
                                        <input type="text" class="form-control  uc-text-smooth"
                                            value="{{ $worker_details->address->c_area ?: 'NA' }}" id="currentArea"
                                            name="c_area" readonly>
                                    </div>
                                </div><!--end-->
                                <div class="form-row"><!--start 1-->

                                    <div class="form-group col-md-3">
                                        <label for="inputMstatus"
                                           >{{ trans('worker-registration/worker-data-preview.city') }}</label>
                                        <input type="text" class="form-control  uc-text-smooth"
                                            value="{{ $worker_details->address->c_city ?: 'NA' }}" name="c_city"
                                            id="currentCity" disabled>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAdhaar"
                                           >{{ trans('worker-registration/worker-data-preview.road') }}</label>
                                        <input type="text" class="form-control  uc-text-smooth"
                                            value="{{ $worker_details->address->c_road ?: 'NA' }}" id="currentRoad"
                                            name="c_road" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputDob"
                                           >{{ trans('worker-registration/worker-data-preview.state') }}</label>
                                        <input type="text" class="form-control  uc-text-smooth"
                                            value="{{ $worker_details->address->c_state ?: 'NA' }}" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAge"
                                           >{{ trans('worker-registration/worker-data-preview.district') }}</label>
                                        <input type="text" class="form-control  uc-text-smooth"
                                            value="{{ $worker_details->address->currentDistrict->district_name ?: 'NA' }}"
                                            readonly>

                                    </div>
                                </div><!--end-->
                                <div class="form-row"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputAge"
                                           >{{ trans('worker-registration/worker-data-preview.revenuecircle') }}</label>
                                        <input type="text" class="form-control  uc-text-smooth"
                                            value="{{ $worker_details->address->c_circle ?: 'NA' }}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputCategory"
                                           >{{ trans('worker-registration/worker-data-preview.postoffice') }}</label>

                                        <input type="text" class="form-control"
                                            value="{{ $worker_details->address->c_post_office }}" readonly />

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                           >{{ trans('worker-registration/worker-data-preview.pincode') }}</label>
                                        <input type="text" class="form-control " id="currentPin"
                                            value="{{ $worker_details->address->c_pin ?: 'NA' }}" name="c_pin"
                                            placeholder="" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputPhone"
                                           >{{ trans('worker-registration/worker-data-preview.landmark') }}</label>
                                        <input type="text" class="form-control " name="landmark"
                                            value="{{ $worker_details->address->landmark ?: 'NA' }}" id="landmark"
                                            readonly>
                                    </div>
                                </div><!--end-->

                            </div>
                            {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;Bank Details:</h5> --}}
                            <div class="form-row mt-4"><!--start 1-->
                                <div class="form-check col-md-12" style="text-align: center;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                           Bank Details
                                        </span>
                                    </h5>

                                </div>
                            </div><!--end-->
                            <div class="custom-form">
                                <div class="form-row mt-4"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label for="inputBank"
                                           >{{ trans('worker-registration/worker-bank-details.bankname') }}</label>
                                        <input type="text" class="form-control  uc-text-smooth"
                                            value="{{ $worker_details->bankDetail->bank_name }}" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputBranch"
                                           >{{ trans('worker-registration/worker-bank-details.branch') }}</label>
                                        <input type="text" class="form-control  uc-text-smooth"
                                            value="{{ $worker_details->bankDetail->branch_name }}" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputBankAddress"
                                           >{{ trans('worker-registration/worker-bank-details.bankaddress') }}</label>
                                        <input type="text" class="form-control  uc-text-smooth"
                                            value="{{ $worker_details->bankDetail->bank_address }}" readonly>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAcc"
                                           >{{ trans('worker-registration/worker-bank-details.accountnumber') }}</label>
                                        <input type="text" class="form-control " id="account_no" name="account_no"
                                            value="{{ $worker_details->bankDetail->account_no }}" placeholder=""
                                            readonly>
                                    </div>
                                </div><!--end-->
                            </div>
                            {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-users" aria-hidden="true"></i>&nbspFamily Details:</h5> --}}
                            <div class="form-row mb-4 mt-4"><!--start 1-->
                                <div class="form-check col-md-12" style="text-align: center;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                          Family Details
                                        </span>
                                    </h5>

                                </div>
                            </div><!--end-->
                            <div class="custom-form">
                                <div class="row">
                                    <div class="col">
                                        <div class="table-container">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-family-details.serialno') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-family-details.fname') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-family-details.lname') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-family-details.dob') }}
                                                        </th>
                                                        {{--                                            <th scope="col">Age</th> --}}
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-family-details.gname') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-family-details.relation') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-data-preview.nominee') }}(Y/N)
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-family-details.nomineeshare') }}
                                                        </th>
                                                        <th scope="col">Registered Worker</th>
                                                        <th scope="col">State of the Board</th>
                                                        <th scope="col">BOCW ID</th>
                                                        <!-- Repeat headers as needed -->
                                                    </tr>
                                                    <tr>
                                                        @foreach ($worker_details->familyDetails as $familyMember)
                                                            <td>{{ $loop->iteration }}</td>

                                                            <td class="fixed">{{ $familyMember->first_name }}</td>
                                                            <td class="fixed">{{ $familyMember->last_name }}</td>
                                                            <td class="fixed">
                                                                {{ \Carbon\Carbon::parse($familyMember->dob)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="fixed-width">
                                                                {{ $familyMember->guardain_name ?: 'NA' }}</td>

                                                            <td class="fixed-width">
                                                                @if ($familyMember->relation === 17)
                                                                    {{ $familyMember->relation_others ?? 'NA' }}
                                                                @else
                                                                    {{ $familyMember->relationDetails->relation_name }}
                                                                @endif
                                                            </td>

                                                            <td class="fixed">
                                                                {{ $familyMember->nominee == 1 ? 'Yes' : 'No' }}</td>
                                                            <td class="fixed">
                                                                {{ $familyMember->nominee_percentage ?: 'NA' }}</td>

                                                            <td class="fixed-width">
                                                                {{ $familyMember->already_registered == 1 ? 'Yes' : 'No' }}
                                                            </td>
                                                            <td class="fixed-width">
                                                                {{ $familyMember->already_registered_state ? $familyMember->stateDetails->state_name : 'NA' }}
                                                            </td>
                                                            <td class="fixed-width">
                                                                {{ $familyMember->bocwwb_id ?: 'NA' }}</td>
                                                    </tr>
                                                    @endforeach
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row mb-4 mt-4"><!--start 1-->
                                <div class="form-check col-md-12" style="text-align: center;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                          90 Days Certificate Details
                                        </span>
                                    </h5>

                                </div>
                            </div><!--end-->
                            <div class="custom-form">
                                <div class="row">
                                    <div class="col">
                                        <div class="table-container">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        {{-- <th scope="col">Serial No</th> --}}
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.issuertype') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.orgname') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.issuedate') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.issuepersonname') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.issuepersoncontact') }}
                                                        </th>

                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.employername') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.employercontactno') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.startdate') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.enddate') }}
                                                        </th>

                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.employertype') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.profession') }}
                                                        </th>
                                                        <th scope="col">
                                                            {{ trans('worker-registration/worker-employer-details.90daysworkingcertificate') }}
                                                        </th>
                                                        <!-- Repeat headers as needed -->
                                                    </tr>
                                                    @foreach ($worker_details->certificates as $certificate)
                                                        <tr>
                                                            <td class="fixed-width">
                                                                {{ $certificate->typeOfIssuer->issuer_name }}</td>
                                                            <td class="fixed-width">
                                                                {{ $certificate->issuing_org }}</td>
                                                            <td class="fixed-width">
                                                                {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="fixed-width">
                                                                {{ $certificate->issuing_person }}</td>
                                                            <td class="fixed-width">
                                                                {{ $certificate->contact_issuing_person }}</td>
                                                            <td class="fixed-width">
                                                                {{ $certificate->employer_name }}</td>
                                                            <td class="fixed-width">
                                                                {{ $certificate->employer_contact_number }}</td>
                                                            <td class="fixed-width">
                                                                {{ \Carbon\Carbon::parse($certificate->from_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="fixed-width">
                                                                {{ \Carbon\Carbon::parse($certificate->to_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="fixed-width">
                                                                {{ $certificate->typeOfEmployer->employer_name }}</td>
                                                            <td class="fixed-width">
                                                                @if ($certificate->professions->profession_code == 28)
                                                                    {{ $certificate->profession_others ?? $certificate->professions->profession_name }}
                                                                @else
                                                                    {{ $certificate->professions->profession_name }}
                                                                @endif
                                                            </td>
                                                            <td class="fixed-width">
                                                                <a href="{{ route('get-cert-proof', ['id' => $certificate->id]) }}"
                                                                    class="href" target="_blank">
                                                                    <i class="fa fa-external-link"
                                                                        aria-hidden="true"></i>&nbsp;View Certificate
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-4 mt-4"><!--start 1-->
                                <div class="form-check col-md-12" style="text-align: center;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                          Other Schemes availed
                                        </span>
                                    </h5>
                                </div>
                            </div><!--end-->
                            <div class="custom-form">
                                <div class="row">
                                    <div class="col">
                                        <div class="table-container">
                                            @if ($worker_details->schemeDetails->isEmpty())
                                                <tr>
                                                    <td colspan="5">No Scheme Availed</td>
                                                </tr>
                                            @else
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">
                                                                {{ trans('worker-registration/worker-data-preview.schemes') }}
                                                            </th>
                                                            <th scope="col">
                                                                {{ trans('worker-registration/worker-schemes-details.regno') }}
                                                            </th>
                                                            <th scope="col">
                                                                {{ trans('worker-registration/worker-schemes-details.regdate') }}
                                                            </th>
                                                        </tr>

                                                        @foreach ($worker_details->schemeDetails as $schemes)
                                                            @if ($schemes->enrolled == '0')
                                                                <tr>
                                                                    <td>No data to display</td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td>{{ $schemes->scheme->scheme_name }}</td>
                                                                    <td>{{ $schemes->registration_id }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($schemes->date)->format('d-m-y') }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                            @endif
                                            </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-file"  aria-hidden="true"></i>&nbsp;Uploaded Documents:</h5> --}}
                            <div class="form-row mb-4 mt-4"><!--start 1-->
                                <div class="form-check col-md-12" style="text-align: center;">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                         Uploaded Documents
                                        </span>
                                    </h5>

                                </div>
                            </div><!--end-->
                            <div class="custom-form">
                                <div class="table-responsive mt-2">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col">Type Of Documents</th>
                                                <th scope="col">Attachments</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if ($worker_details->address->do !== 1 && $worker_details->address->type_of_document !== 1)
                                                <tr>

                                                    <td>Present Address Proof</td>
                                                    <td><a href="{{ route('get-res-proof', ['id' => mt_rand(1, 1000)]) }}"
                                                            class="href" target="_blank"><i class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Present Address
                                                            proof</a>
                                                    </td>

                                                </tr>
                                            @endif

                                            <tr>

                                                <td>Bank Passbook Copy (Aadhar Linked Bank Account)</td>
                                                <td><a href="{{ route('get-bank-copy', ['id' => mt_rand(1, 1000)]) }}"
                                                        class="href" target="_blank"><i class="fa fa-external-link"
                                                            aria-hidden="true"></i>&nbsp;View Worker bank Copy</a></td>

                                            </tr>

                                            @if ($has_ack_no == true)
                                                <tr>
                                                    <td>Acknowledgement Slip</td>
                                                    <td><a href="{{ route('get-payment-ack-slip', ['id' => mt_rand(1, 1000)]) }}"
                                                            class="href" target="_blank"><i class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Acknowledgement
                                                            Slip</a></td>

                                                </tr>
                                            @endif


                                            @if ($has_ration_card == 1)
                                                <tr>

                                                    <td>Ration card</td>
                                                    <td><a href="{{ route('get-ration_card', ['id' => mt_rand(1, 1000)]) }}"
                                                            class="href" target="_blank"><i class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Ration Card</a></td>

                                                </tr>
                                            @endif
                                            @if ($has_pan == 1)
                                                <tr>

                                                    <td>Pan card</td>
                                                    <td><a href="{{ route('get-pan_card', ['id' => mt_rand(1, 1000)]) }}"
                                                            class="href" target="_blank"><i class="fa fa-external-link"
                                                                aria-hidden="true"></i>&nbsp;View Pan Card</a></td>

                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                </div>


                            </div>
                            <div class="row justify-content-center mt-3">

                                <div class="col-auto mr-2">
                                    <a href="{{ route('submit-schemes-details') }}" class="btn btn-sm btn-success"><i
                                            class="fa fa-backward" aria-hidden="true"></i>Edit for Correction</a>
                                </div>
                                <div class="col-auto mr-2">
                                    <a href="{{ route('download-final-preview-pdf') }}" target="_blank"
                                        class="btn btn-sm btn-warning"><i class="fa fa-download"
                                            aria-hidden="true"></i>&nbsp;Download PDF&nbsp;</a>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#exampleModal"><i class="fa fa-check-circle"></i>&nbsp;
                                    Final Submit
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-center d-block bg-primary">
                                                <h3 class="modal-title text-white " id="exampleModalLabel">Warning
                                                </h3>


                                            </div>
                                            <div class="modal-body">
                                                <h3 class="text-center">Are you ready to submit? </h3>
                                                <h6 class="text-danger mt-3 p-2">Note: No changes can be made after the
                                                    final
                                                    Submission. Check all details carefully!</h6>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">No</button>
                                                <a href="{{ route('save-final-data') }}" class="btn btn-success">Yes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function printPage() {
                    window.print();
                }
            </script>
        </div>
    </div><!-- End Left side columns -->

@endsection


@section('footer')

    <script>
        $(document).ready(function() {
            $('#updateOfficeBtn').on('click', function() {
                let district_id = $('#district_code_edit').val();
                let office_id = $('#office_id_edit').val();

                if (!district_id || !office_id) {
                    alert('Please select both District and Office.');
                    return;
                }

                $.ajax({
                    url: "{{ route('update-office') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        district_id: district_id,
                        office_id: office_id
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                text: 'Office Successfully updated',
                                icon: 'success',
                            }).then(() => {
                                $('#editOfficeModal').removeClass('show').hide();
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();
                                $('#office_name_display').val(response.office_name);
                            });

                        } else {
                            Swal.fire({
                                text: response.message,
                                icon: 'success',
                            }).then(() => {
                                $('#editOfficeModal').removeClass('show').hide();
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();
                            });
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while updating. Please try again.');
                    }
                });
            });
        });
    </script>

    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
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

            // Update the age input field
            document.getElementById('age').value = age;
        };
    </script>
@endsection
