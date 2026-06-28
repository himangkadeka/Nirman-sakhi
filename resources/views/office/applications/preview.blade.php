@extends('layouts.admin-app')

@section('title', 'Office | Application | Preview')
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Preview')

@section('style')
    <style>

        @media print {
            .no-print {
                display: none !important;
            }
        }
        :root {
            --govt-navy: #1e293b;
            --govt-blue: #0d6efd;
            --govt-bg: #f4f7fa;
            --border-color: #e2e8f0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--govt-bg);
            color: #334155;
        }
        .btn-primary {
            color: white;
        }
        tr td{
            font-size: 14px;
            text-align: center;
        }
        table th {
            font-size: 15px !important;
            font-weight: 600 !important;
            color: #333 !important;
            background-color: #f9f9f9;
            vertical-align: middle !important;
            padding: 10px 12px !important;
        }
        table td {
            font-size: 14px;
            color: #212529;
            padding: 8px 12px !important;
        }
        .table-light th {
            background-color: #e9f3ff !important;
            color: #0d6efd !important;
        }
        .table-danger th {
            background-color: #fdeaea !important;
            color: #dc3545 !important;
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
        .gradient-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 22px;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            text-decoration: none; /* remove underline */
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .gradient-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
            text-decoration: none;
            color: #fff;
        }

        .gradient-btn i {
            font-size: 16px;
        }
        /* Sticky floating action bar */
        .action-bar {
            position: sticky;
            bottom: 0;
            z-index: 1000;

            background: #d9e2e7;
            padding: 10px 12px 10px 12px;
            border-top: 1px solid #dee2e6;

            /* Optional shadow for elevation */
            box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
        }

        /* Make buttons wrap nicely on small screens */
        .action-bar .btn {
            min-width: 110px;
        }

        /* Optional: spacing fix */
        .action-bar .btn + .btn {
            margin-left: 6px;
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
        label.bold{
            font-weight: 600;
            font-size: 14px;
        }

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
        /* Button */
        .gradient-btn {
            display: inline-block;
            padding: 6px 14px;
            font-size: 13px;
            color: #fff;
            border-radius: 6px;
            background: linear-gradient(45deg, #0d6efd, #6610f2);
            text-decoration: none;
        }

        /* Timeline wrapper */
        .timeline {
            position: relative;
            margin-top: 20px;
            padding-left: 30px;
        }

        /* Vertical line */
        .timeline::before {
            content: '';
            position: absolute;
            left: 14px;
            top: 0;
            width: 2px;
            height: 100%;
            background: #dee2e6;
        }

        /* Timeline item */
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        /* Marker (dot) */
        .timeline-marker {
            position: absolute;
            left: -22px;
            top: 8px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        /* Colors */
        .timeline-badge-primary {
            background: #0d6efd;
        }

        .timeline-badge-warning {
            background: #ffc107;
        }

        /* Content box */
        .timeline-content {
            background: #ffffff;
            padding: 12px 15px;
            border-radius: 10px;
            border-left: 3px solid #0d6efd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: 0.2s;
        }

        /* Hover effect */
        .timeline-content:hover {
            transform: translateY(-2px);
        }

        /* Header */
        .timeline-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        /* User */
        .timeline-user {
            font-weight: 600;
            font-size: 13px;
            color: #212529;
        }

        /* Badge */
        .timeline-badge {
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 4px;
            color: #fff;
        }

        /* Text */
        .timeline-text {
            font-size: 13px;
            color: #fa4c2c;
            margin-bottom: 6px;
        }

        /* Footer */
        .timeline-footer {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #6c757d;
        }

        /* Time */
        .timeline-time {
            color: #adb5bd;
        }

        .custom-form-1 {
            border: 1px solid rgba(0, 0, 0, .075);
            /* Border color - a shade of blue */
            border-radius: 10px;
            /* Border radius for rounded corners */
            padding: 20px;
            /* Padding inside the form */
            margin-top: 10px;
            /* Margin to separate the form from other elements */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add a subtle box shadow */
            background-color: #f4f4f4;
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
        /*body{*/
            /*background-color: #f1f1f1;*/
            /*font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;*/
        /*}*/
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
        .bold {
            font-weight: 500;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 13px;
            /*color: #186cb8;*/
            /*color: #8b5050 !important;*/
            /*color: #7ea1a2;*/
        }
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

        @keyframes blink-animation {
            50% {
                background-color: #ffdddd;
                /* Light red background for the blink effect */
            }
        }


        .revert-container {
            padding: 20px;
            margin: 30px auto;
            background-color: #f9f9f9;
            border-left: 5px solid #dc3545;
            /* Bootstrap 'danger' color */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .revert-title {
            color: #0d6efd;
            /* Bootstrap 'primary' */
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .revert-list {
            padding-left: 20px;
            margin: 0;
            font-size: 13px;
        }

        .revert-reason {

            margin-bottom: 8px;
            margin-top: 8px;
            line-height: 1.6;
        }

        .remarks-officer-list {
            list-style: none;
            padding: 20px;
            margin: 30px auto;
            background-color: #fefefe;
            border-left: 5px solid #0d6efd;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .remarks-title {
            font-size: 14px;
            font-weight: 600;
            color: #0d6efd;
            margin-bottom: 10px;
            display: block;
        }

        .remarks-officer-item {
            padding: 10px 0;
            border-bottom: 1px solid #e1e1e1;
            font-size: 13px;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* 🔹 Reduce harsh alert look inside inputs */
        input.alert {
            background-color: #fff !important;
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }

        /* 🔹 Subtle highlight for editable important fields */
        .highlight_date input.form-control {
            background-color: #f8fbff;
            border: 1px solid #cfe2ff;
            transition: all 0.2s ease-in-out;
        }

        .highlight_date input.form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 2px rgba(13,110,253,0.1);
        }

        /* 🔹 Improve alert boxes (make them compact + modern) */
        .alert {
            border-radius: 6px !important;
            font-size: 13px;
            padding: 8px 10px !important;
        }

        /* 🔹 Make warning alerts softer (less aggressive yellow) */
        .alert-warning {
            background-color: #fff8e5 !important;
            border-left: 3px solid #ffc107 !important;
            border-top: none;
            border-right: none;
            border-bottom: none;
            color: #856404 !important;
        }

        /* 🔹 Improve danger alerts */
        .alert-danger {
            background-color: #fff0f0 !important;
            border-left: 3px solid #dc3545 !important;
            border-top: none;
            border-right: none;
            border-bottom: none;
        }

        /* 🔹 Spacing between fields */
        .form-group {
            margin-bottom: 18px;
        }

        /* 🔹 Label styling */
        .form-group label {
            font-weight: 600;
            font-size: 13px;
            color: #495057;
        }

        /* 🔹 Section note (top red message) */
        .text-danger {
            font-size: 13px;
        }

        /* 🔹 Make disabled input look intentional */
        input[disabled] {
            background-color: #f1f3f5 !important;
            cursor: not-allowed;
            opacity: 0.9;
        }

        /* 🔹 Improve revert box (remarks section) */


        .revert-title {
            font-weight: 600;
            color: #dc3545;
        }

        .revert-list {
            margin: 6px 0 0 15px;
            padding: 0;
            font-size: 13px;
        }

        /* 🔹 Improve button */
        .gradient-btn {
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 13px;
        }
        /* 🔷 Modern Sticky Action Bar */
        .action-bar-modern {
            position: sticky;
            bottom: 10px;
            z-index: 1050;

            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;

            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(6px);

            padding: 8px 10px;
            border-radius: 10px;

            border: 1px solid #e3e6ea;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        /* 🔹 Compact buttons */
        .action-bar-modern .btn {
            padding: 5px 10px !important;
            font-size: 12px !important;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* 🔹 Icon size */
        .action-bar-modern .btn i {
            font-size: 12px;
        }

        /* 🔹 Primary action highlight */
        .action-bar-modern .btn-primary {
            box-shadow: 0 2px 6px rgba(13,110,253,0.25);
        }

        /* 🔹 Danger emphasis */
        .action-bar-modern .btn-danger {
            box-shadow: 0 2px 6px rgba(220,53,69,0.2);
        }

        /* 🔹 Hover effect */
        .action-bar-modern .btn:hover {
            transform: translateY(-1px);
            transition: 0.15s ease;
        }

        /* 🔹 Mobile optimization */
        @media (max-width: 768px) {
            .action-bar-modern {
                justify-content: space-between;
            }

            .action-bar-modern .btn {
                flex: 1 1 48%;
                justify-content: center;
            }
        }

    </style>
@endsection

@section('content')
    <div>
        <div class="container-fluid" id="b-homedb" style="font-family: Helvetica, Arial, sans-serif ";>
            <div class="col-md-12">
                @if ($worker_details->already_registered == 1)
                    <div id="alert-container" class="alert-container mt-1">
                        <div id="error-alert" class="alert alert-danger d-none" role="alert">

                        </div>
                    </div>
                @endif


                @if ($remarks)
                    <div class="revert-container">
                        <div class="revert-box">
                            <span class="revert-title">Application Reverted for the Following Reasons:</span>
                            <ul class="revert-list">
                                @foreach ($remarks->getReasons($worker_details->worker_id) as $remark)
                                    <li class="revert-reason">{{ $remark->reason }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                @endif

            <!-- Somewhere in your Blade -->
                <a href="javascript:void(0)"
                   class="show-remarks gradient-btn"
                   data-worker="{{ $worker_details->worker_id }}">
                    View Remarks
                </a>




                <!-- Container where remarks will be loaded -->
                <div id="remarks-container"></div>


                <div class="custom-form">

                    <div class="form-row heading-with-photo d-flex align-items-center justify-content-between p-3"
                         style="background: #f8f9fa; border-radius: 8px;">
                        <!-- Applicant Photo -->
                        <div class="photo-container" style="position: relative; text-align: center;">
                            <img src="data:image/jpeg;base64,{{$base64Image}}"
                                 alt="Applicant Photo"
                                 class="app-photo"
                                 style="width: 120px; height: 160px; border-radius: 8px; object-fit: cover;">
                            <!-- Watermark -->
                            <div class="watermark"
                                 style="position: relative; bottom: -10px; left: 50%; transform: translateX(-50%); color: #28a745; font-size: 12px; font-weight: bold; background: rgba(255, 255, 255, 0.8); padding: 2px 8px; border-radius: 4px;">
                                Aadhar Verified
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-3 mb-2"><!--start 1-->
                        <div class="form-check col-md-12" style="text-align: center;">
                            <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Application Details
                                        </span>
                            </h5>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-md-3">
                            <label class="">Application Type </label>
                            <span class="text-dark">
                                @if (!$isRenewal)
                                    @if ($worker_details->already_registered == 1)
                                        <span class="form-control-plaintext">On Boarding</span>
                                    @else
                                        <span class="form-control-plaintext">New Registration</span>
                                    @endif
                                @endif
                            </span>
                            @if ($worker_details->renewal_status == 1)
                                <span class="form-control-plaintext">Renewal</span>
                            @endif
                        </div>
                        @if (!$isRenewal)
                            @if ($worker_details->already_registered == 1)
                                @if ($cardData)
                                    <div class="form-group col-md-3">
                                        <label class="">Existing ID Card </label>
                                        <span class="form-control-plaintext">{{ $worker_details->worker_id }}</span>

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="">Existing ID Card </label>
                                        <a href="{{ route('boc-card', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                                           class="btn btn-outline-primary btn-sm d-inline-flex align-items-center"
                                           target="_blank">
                                            <i class="fa fa-id-card me-2" aria-hidden="true"></i>
                                            View ID Card
                                            <i class="fa fa-external-link-alt ms-2"></i>
                                        </a>

                                    </div>
                                @else
                                    <div class="form-group col-md-3">
                                        <label class="">Existing ID Card </label>
                                        <span class="form-control-plaintext">{{ $worker_details->worker_id }}</span>
                                    </div>
                                @endif
                            @endif
                        @else
                            <div class="form-group col-md-3">
                                <label class="">Existing ID Card </label>
                                <span class="form-control-plaintext">{{ $worker_details->id_card }}</span>
                            </div>
                        @endif
                        <div class="form-group col-md-3">
                            <label class="">Worker Status</label>
                            @if (isset($worker_details->basicDetail) && $worker_details->basicDetail->resident_type == 'rao')
                                <span class="form-control-plaintext">Migrant Worker</span>
                            @else
                                <span class="form-control-plaintext">Resident Worker</span>
                            @endif
                        </div>
                        @if (isset($worker_details->basicDetail) && $worker_details->basicDetail->resident_type == 'rao')
                            <div class="form-group col-md-3">
                                <label class="">State</label>
                                <input type="text" class="form-control" placeholder=""
                                       value="{{ $getVaultData['state'] ?? 'N/A' }}" readonly />
                            </div>
                        @endif
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="">Date Of Application</label>
                            <span class="form-control-plaintext">{{ $app_date->created_at}}</span>

                        </div>
                    </div>

                    @if ($worker_details->already_registered == 1)
                        <div class="alert alert-light border-start border-primary border-3 py-2 px-3 mt-2">
                            <small class="text-dark">
                                <i class="bi bi-info-circle me-1"></i>
                                Please verify <strong>Registration Date</strong>, <strong>Card Validity Date</strong>, and
                                <strong>Subscription Validity Date</strong> before approval.
                            </small>
                        </div>

                        <div class="form-row highlight_date">

                            {{-- Registration Date --}}
                            <div class="form-group col-md-4">
                                <label class="">Registration/Card Issue Date</label>
                                <span style="color:red;">*</span>

                                <input type="date"
                                       class="form-control alert alert-warning"
                                       placeholder="YYYY-MM-DD"
                                       value="{{ !empty($worker_details->last_registration_date) ? \Carbon\Carbon::parse($worker_details->last_registration_date)->format('Y-m-d') : '' }}"
                                       id="last_registration_date"
                                       name="last_registration_date">
                                <div class="alert alert-warning d-flex align-items-start gap-2 py-2 px-3 mt-2">
                                    <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                                    <div>
                                        <strong>Officers can modify the dates according to the documents provided by Worker.</strong>
                                    </div>
                                </div>
                                {{--<small class="text-danger">--}}
                                    {{--Officers can modify the dates according to the documents provided by Worker.--}}
                                {{--</small>--}}
                            </div>


                            {{-- Card Validity Date --}}
                            <div class="form-group col-md-4">
                                <label class="">Card Validity Date</label>
                                <span style="color:red;">*</span>

                                <input type="date"
                                       class="form-control alert alert-warning"
                                       placeholder="YYYY-MM-DD"
                                       value="{{ isset($worker_details->id_card_expiry_date) && !empty($worker_details->id_card_expiry_date)
                        ? \Carbon\Carbon::parse($worker_details->id_card_expiry_date)->format('Y-m-d')
                        : '' }}"
                                       id="card_validity_date"
                                       name="card_validity_date" />
                                <div class="alert alert-warning d-flex align-items-start gap-2 py-2 px-3 mt-2">
                                    <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                                    <div>
                                        Tips :
                                        <strong>The validity date should be one day less than the last Issue date.</strong>
                                    </div>
                                </div>

                            </div>


                            {{-- Subscription Paid Upto --}}
                            @if($worker_details->basicDetail->subscription_receipt == 0 && !$subscription_receipt)

                                <div class="form-group col-md-4">
                                    <label class="">Subscription Paid Upto</label>
                                    <span style="color:red;">*</span>

                                    {{-- Locked field --}}
                                    <input type="date"
                                           class="form-control"
                                           id="subscription_validity_date"
                                           value="{{ \Carbon\Carbon::parse($worker_details->last_registration_date)->format('Y-m-d') }}"
                                           min="{{ \Carbon\Carbon::parse($worker_details->last_registration_date)->format('Y-m-d') }}"
                                           max="{{ \Carbon\Carbon::parse($worker_details->last_registration_date)->format('Y-m-d') }}"
                                           disabled />

                                    {{-- Hidden field for form submission --}}
                                    <input type="hidden"
                                           id="subscription_validity_hidden"
                                           name="subscription_validity_date"
                                           value="{{ \Carbon\Carbon::parse($worker_details->last_registration_date)->format('Y-m-d') }}">
                                    <div class="alert alert-warning d-flex align-items-start gap-2 py-2 px-3 mt-2">
                                        <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                                        <div>
                                            Subscription receipt not provided.
                                            <strong>Validity defaults to registration date.</strong>
                                        </div>
                                    </div>
                                    {{--<small class="text-danger">--}}
                                        {{--“Since no subscription receipt was submitted, the subscription validity is considered up to the registration date.”--}}
                                    {{--</small>--}}
                                </div>

                            @else

                                {{-- Normal Selection --}}
                                <div class="form-group col-md-4">
                                    <label class="">Subscription Paid Upto</label>
                                    <span style="color:red;">*</span>

                                    <input type="date"
                                           placeholder="YYYY-MM-DD"
                                           class="form-control"
                                           id="subscription_validity_date"
                                           name="subscription_validity_date"
                                           value="{{ !empty($worker_details->subscription_validity_date)
                            ? \Carbon\Carbon::parse($worker_details->subscription_validity_date)->format('Y-m-d')
                            : '' }}"
                                           onchange="validateDates()" />

                                    <small class="text-danger">
                                        Note: The subscription paid upto cannot be less than 2 years before Card validity date.
                                    </small>

                                </div>

                            @endif

                        </div>

                    @if ($worker_details->already_registered == 1 && $worker_details->basicDetail->subscription_receipt == 1 && $subscription_receipt)
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label class="">Last Subscription Payment Date</label>
                                    <span
                                            class="form-control-plaintext">{{ \Carbon\Carbon::parse($worker_details->basicDetail->subscription_payment_date)->format('d-m-Y')  }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="">Subscription Payment Amount</label>
                                    <span
                                            class="form-control-plaintext">{{ $worker_details->basicDetail->subscription_amount_paid }}</span>
                                </div>
                            </div>
                        @elseif($worker_details->already_registered == 1 && $worker_details->basicDetail->subscription_receipt == 0 && $subscription_receipt)
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label class="">Last Subscription Payment Date</label>
                                    <span
                                            class="form-control-plaintext">{{ \Carbon\Carbon::parse($worker_details->basicDetail->subscription_payment_date)->format('d-m-Y')  }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="">Subscription Payment Amount</label>
                                    <span
                                            class="form-control-plaintext">{{ $worker_details->basicDetail->subscription_amount_paid }}</span>
                                </div>
                            </div>
                        @endif

                        @if ($worker_details->already_registered == 1 && $worker_details->basicDetail->subscription_receipt == 1 && $subscription_receipt)
                            <tr>

                                <td>Subscription Receipt Copy</td>
                                <td><a href="{{ route('subscription-view', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                                       class="href" target="_blank"><i class="fa fa-external-link"
                                                                       aria-hidden="true"></i>&nbspView Attachment</a></td>

                            </tr>
                        @elseif ($worker_details->already_registered == 1 && $worker_details->basicDetail->subscription_receipt == 0 && $subscription_receipt)
                            <tr>

                                <td>Subscription Receipt Copy</td>
                                <td><a href="{{ route('subscription-view', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                                       class="href" target="_blank"><i class="fa fa-external-link"
                                                                       aria-hidden="true"></i>&nbspView Attachment</a></td>

                            </tr>
                        @endif

                </div>
                @endif

            </div>
        </div>
    </div>
            <div class="custom-form">
                <div class="text-center mb-4">
                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;"> <span style="border-left: 4px solid #007bff; padding-left: 10px;"> Basic Details </span> </h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                        <tr class="table-light">
                            <th colspan="4" class="text-center text-primary">Aadhaar Details</th>
                        </tr>
                        <tr>
                            <th>Name</th> <td>{{ $getVaultData['name'] }}</td>
                            <th>Care Of</th> <td>{{ $getVaultData['careOf'] }}</td>
                        </tr>
                        @php
                            use Carbon\Carbon;

                            $dob = Carbon::parse($getVaultData['dob']);
                            $applicationDate = Carbon::parse($app_date->created_at);

                            $diff = $dob->diff($applicationDate);

                            $ageYears = $diff->y;
                            $ageMonths = $diff->m;
                        @endphp
                        <tr>
                            <th>Gender</th>
                            <td>{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : 'Others') }}</td>
                            <th>Date of Birth</th>
                            <td id="dob" data-dob="{{ $getVaultData['dob'] }}">{{ $getVaultData['dob'] }}</td>
                        </tr>

                        @if ($worker_details->already_registered == 1)
                            <tr class="table-danger"> <th colspan="4" class="text-center text-danger">Old Database Details</th>
                            </tr>
                            <tr>
                                <th>Name </th>
                                <td>{{ $worker_details->basicDetail->old_name ?? 'NA' }}</td>
                                <th>Care Of </th>
                                <td>{{ $worker_details->basicDetail->old_care_of ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Gender </th>
                                <td>{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : 'Others') }}</td>
                                <th>Date of Birth</th> <td>{{ \Carbon\Carbon::parse($worker_details->basicDetail->old_dob)->format('d-m-Y') ?: 'NA' }}</td>
                            </tr> @endif <tr class="table-light"> <th colspan="4" class="text-center text-primary">Other Basic Information</th>
                        </tr>
                        <tr>
                            <th>Aadhaar No</th> <td>{{ $getVaultData['uID'] }}</td>
                            <th>Age on the date of Application</th>
                            <td id="">{{$ageYears}} years {{$ageMonths}} months</td> </tr>
                        <tr> <th>Contact Number</th>
                            <td>{{ $worker_details->phone_no }}</td> <th>Marital Status</th> <td>{{ $worker_details->basicDetail->maritalStatus->marital_status }}</td> </tr> <tr> <th>Category</th> <td>{{ $worker_details->basicDetail->cateGory->category_name }}</td> <th>UAN Number</th> <td>{{ $worker_details->basicDetail->eshram_no ?? 'NA' }}</td> </tr> <tr> <th>Blood Group</th> <td>{{ $worker_details->basicDetail->bloodGroup->blood_group }}</td> <th>Education</th> <td>{{ $worker_details->basicDetail->education->education_name }}</td> </tr> <tr> <th>Email</th> <td>{{ $worker_details->basicDetail->email ?: 'N/A' }}</td> <th>PAN Available</th> <td>{{ $worker_details->basicDetail->pan == 1 ? 'Yes' : 'No' }}</td> </tr> @if ($worker_details->basicDetail->pan == 1) <tr> <th>PAN Number</th> <td>{{ $worker_details->basicDetail->pan_no }}</td> <th>PAN Card Docs</th> <td> <a href="{{ route('pan_card', ['worker_id' => encrypt($worker_details->worker_id)]) }}" target="_blank" class="btn btn-outline-primary btn-sm"> <i class="fa fa-id-card me-2"></i> View PAN Card <i class="fa fa-external-link-alt ms-2"></i> </a> </td> </tr> @endif <tr> <th>Already Registered With Other State BOC</th> <td>{{ $worker_details->basicDetail->boc == 1 ? 'Yes' : 'No' }}</td> @if ($worker_details->basicDetail->boc == '1') <th>State (BOCW Board)</th> <td>{{ $worker_details->basicDetail->otherState->state_name }}</td> @else <td colspan="2"></td> @endif </tr> @if ($worker_details->basicDetail->boc == '1') <tr> <th>BOC Number</th> <td>{{ $worker_details->basicDetail->boc_no }}</td> <td colspan="2"></td> </tr> @endif <tr> <th>Ration Card</th> <td>{{ $worker_details->basicDetail->has_ration_card == 1 ? 'Yes' : 'No' }}</td> @if ($worker_details->basicDetail->has_ration_card == 1) <th>Ration Card Number</th> <td>{{ $worker_details->basicDetail->ration_no }}</td> @endif </tr> @if ($worker_details->basicDetail->has_ration_card == 1) <tr> <th>Ration Card Type</th> <td>{{ $worker_details->basicDetail->rationType->name }}</td> <th>Ration Card Docs</th> <td> <a href="{{ route('ration_card', ['worker_id' => encrypt($worker_details->worker_id)]) }}" target="_blank" class="btn btn-outline-primary btn-sm"> <i class="fa fa-id-card me-2"></i> View Ration Card <i class="fa fa-external-link-alt ms-2"></i> </a> </td> </tr> @endif @if ($worker_details->already_registered == 1) <tr> <th>Profession</th> <td colspan="3"> {{ $worker_details->basicDetail->profession === 28 ? ($worker_details->basicDetail->profession_others ?? 'NA') : ($worker_details->basicDetail->Profession->profession_name ?? 'NA') }} </td> </tr> @endif </tbody> </table> </div> </div>
        {{--</div>--}}


            <div class="custom-form">
                <div class="text-center mb-4">
                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
            <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                Permanent Residential Details
            </span>
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                        <tr class="table-light">
                            <th colspan="4" class="text-center text-primary">Aadhaar Address Details</th>
                        </tr>

                        <tr>
                            <th>State</th>
                            <td>{{ $getVaultData['state'] ?? 'N/A' }}</td>

                            <th>District</th>
                            <td>{{ $getVaultData['district'] ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Sub District</th>
                            <td>{{ $getVaultData['subDistrict'] ?? 'N/A' }}</td>

                            <th>Post Office</th>
                            <td>{{ $getVaultData['postOffice'] ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Road/Street</th>
                            <td>{{ $getVaultData['street'] ?? 'N/A' }}</td>

                            <th>Locality</th>
                            <td>{{ $getVaultData['locality'] ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Village</th>
                            <td>{{ $getVaultData['village'] ?? 'N/A' }}</td>

                            <th>Landmark</th>
                            <td>{{ $getVaultData['landMark'] ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Building Name</th>
                            <td>{{ $getVaultData['buildingName'] ?? 'N/A' }}</td>

                            <th>Pin Code</th>
                            <td>{{ $getVaultData['pinCode'] ?? 'N/A' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="custom-form mt-5">
                <div class="text-center mb-4">
                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
            <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                Current Residential Details
            </span>
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                        <tr class="table-light">
                            <th colspan="4" class="text-center text-primary">Current Address Details</th>
                        </tr>

                        <tr>
                            <th>Type of Residence</th>
                            <td>{{ $worker_details->address->currentResidence->residence_name ?? 'N/A' }}</td>

                            <th>Type of House</th>
                            <td>{{ $worker_details->address->currentHouse->house_type ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>House No./Building No.</th>
                            <td>{{ $worker_details->address->c_house_no ?? 'N/A' }}</td>

                            <th>Area/Village</th>
                            <td>{{ $worker_details->address->c_area ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>City</th>
                            <td>{{ $worker_details->address->c_city ?? 'N/A' }}</td>

                            <th>Road</th>
                            <td>{{ $worker_details->address->c_road ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>State</th>
                            <td>{{ $worker_details->address->c_state ?? 'N/A' }}</td>

                            <th>District</th>
                            <td>{{ $worker_details->address->currentDistrict->district_name ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Revenue Circle</th>
                            <td>{{ $worker_details->address->c_circle ?? 'N/A' }}</td>

                            <th>Post Office</th>
                            <td>{{ $worker_details->address->c_post_office ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Pin Code</th>
                            <td>{{ $worker_details->address->c_pin ?? 'N/A' }}</td>

                            <th>Landmark</th>
                            <td>{{ $worker_details->address->landmark ?? 'N/A' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>







            <div class="custom-form mr-1 ml-1">
                <div class="text-center mb-4">
                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
            <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                Bank Details
            </span>
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                        <tr>
                            <th>Bank Name</th>
                            <td>{{ $worker_details->bankDetail->bank_name ?? 'N/A' }}</td>

                            <th>Branch Name</th>
                            <td>{{ $worker_details->bankDetail->branch_name ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Bank Address</th>
                            <td>{{ $worker_details->bankDetail->bank_address ?? 'N/A' }}</td>

                            <th>Account Number</th>
                            <td>{{ $worker_details->bankDetail->account_no ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>IFSC Code</th>
                            <td>{{ $worker_details->bankDetail->ifsc_code ?? 'N/A' }}</td>

                            <th>Passbook</th>
                            <td>
                                <a href="{{ route('bank-pass', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                                   class="btn btn-outline-primary btn-sm d-inline-flex align-items-center"
                                   target="_blank">
                                    <i class="fa fa-university me-2" aria-hidden="true"></i>
                                    View Bank Passbook
                                    <i class="fa fa-external-link-alt ms-2"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>




            <div class="custom-form mr-1 ml-1">
                <div class="text-center mb-4">
                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
            <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                Family Details
            </span>
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Serial No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of Birth</th>
                            <th>Guardian Name</th>
                            <th>Relation</th>
                            <th>Nominee (Y/N)</th>
                            <th>Nominee Share</th>
                            <th>Already Registered with Other State BOCW Board?</th>
                            <th>Name of the State (BOCW Board)</th>
                            <th>BOCW ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($worker_details->familyDetails as $familyMember)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $familyMember->first_name ?? 'N/A' }}</td>
                                <td>{{ $familyMember->last_name ?? 'N/A' }}</td>
                                <td>
                                    {{ $familyMember->dob ? \Carbon\Carbon::parse($familyMember->dob)->format('d-m-Y') : 'N/A' }}
                                </td>
                                <td>{{ $familyMember->guardian_name ?? 'N/A' }}</td>
                                <td>
                                    @if ($familyMember->relation === 17)
                                        {{ $familyMember->relation_others ?? 'N/A' }}
                                    @else
                                        {{ $familyMember->relationDetails->relation_name ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>{{ $familyMember->nominee == 1 ? 'Yes' : 'No' }}</td>
                                <td>{{ $familyMember->nominee_percentage ?? 'N/A' }}</td>
                                <td>{{ $familyMember->already_registered == 1 ? 'Yes' : 'No' }}</td>
                                <td>{{ $familyMember->stateDetails->state_name ?? 'N/A' }}</td>
                                <td>{{ $familyMember->bocwwb_id ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">No family details found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>



        @if ($worker_details->already_registered != 1)
                <div class="custom-form mr-1 ml-1">
                    <div class="text-center mb-4">
                        <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
            <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                90 Days Certificate Details
            </span>
                        </h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Type of Employer</th>
                                <th>Type of Issuer</th>
                                <th>Name of Issuing Organization</th>
                                <th>Issue Date</th>
                                <th>Name of Issuing Person</th>
                                <th>Contact No of Issuing Person</th>
                                <th>Type of Construction Work</th>
                                <th>Employer Name</th>
                                <th>Employer Contact Number</th>
                                <th>Work Start Date</th>
                                <th>Work End Date</th>
                                <th>Actual No. of Working Days</th>
                                <th>Profession</th>
                                <th>90 Days Certificate</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($worker_details->certificates as $certificate)
                                <tr>
                                    <td>{{ $certificate->typeOfEmployer->employer_name ?? 'N/A' }}</td>
                                    <td>{{ $certificate->typeOfIssuer->issuer_name ?? 'N/A' }}</td>
                                    <td>{{ $certificate->issuing_org ?? 'N/A' }}</td>
                                    <td>
                                        {{ $certificate->issue_date ? \Carbon\Carbon::parse($certificate->issue_date)->format('d-m-Y') : 'N/A' }}
                                    </td>
                                    <td>{{ $certificate->issuing_person ?? 'N/A' }}</td>
                                    <td>{{ $certificate->contact_issuing_person ?? 'N/A' }}</td>
                                    <td>{{ $certificate->typeOfWork->work_type_name ?? 'N/A' }}</td>
                                    <td>{{ $certificate->employer_name ?? 'N/A' }}</td>
                                    <td>{{ $certificate->employer_contact_number ?? 'N/A' }}</td>
                                    <td>
                                        {{ $certificate->from_date ? \Carbon\Carbon::parse($certificate->from_date)->format('d-m-Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $certificate->to_date ? \Carbon\Carbon::parse($certificate->to_date)->format('d-m-Y') : 'N/A' }}
                                    </td>
                                    <td>{{ $certificate->date_count ?? 'N/A' }}</td>
                                    <td>
                                        @if ($certificate->professions->profession_code == 28)
                                            {{ $certificate->profession_others ?? $certificate->professions->profession_name ?? 'N/A' }}
                                        @else
                                            {{ $certificate->professions->profession_name ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('certificate-proof-new', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                                           target="_blank"
                                           class="btn btn-outline-primary btn-sm d-inline-flex align-items-center">
                                            <i class="fa fa-file-alt me-2"></i> View Certificate
                                            <i class="fa fa-external-link-alt ms-2"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center text-muted">No certificate details available.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @endif



    <div class="custom-form">
        <div class="form-row  mt-2"><!--start 1-->
            <div class="form-check col-md-12" style="text-align: center;">
                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Schemes Details
                                        </span>
                </h5>
            </div>
        </div><!--end-->
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
                                    <th scope="col" class="">Schemes</th>
                                    <th scope="col" class="bold">Registration No</th>
                                    <th scope="col" class="bold">Date of Registration
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
                                            <td>{{ \Carbon\Carbon::parse($schemes->date)->format('d-m-Y') }}
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

    @if ($worker_details->already_registered != 1)
        @if ($worker_details->already_payment_status == false)
            <div class="custom-form mr-2 ml-2">
                <div class="form-row  mb-4"><!--start 1-->
                    <div class="form-check col-md-12" style="text-align: center;">
                        <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Payment Details
                                        </span>
                        </h5>
                    </div>
                </div>
                <div class="form-row">

                    @if(!empty($paymentDetails?->csc_txn_id))

                        <div class="form-group col-md-3">
                            <label class="bold">CSC ID</label><br> :
                            {{ $paymentDetails->csc_id ?? 'NA' }}
                        </div>

                        <div class="form-group col-md-3">
                            <label class="bold">CSC Transaction ID</label><br> :
                            {{ $paymentDetails->csc_txn_id ?? 'NA' }}
                        </div>

                        <div class="form-group col-md-3">
                            <label class="bold">Merchant Receipt No</label><br> :
                            {{ $paymentDetails->merchant_receipt_no ?? 'NA' }}
                        </div>

                        <div class="form-group col-md-3">
                            <label class="bold">Transaction Date</label><br> :
                            {{ $paymentDetails->merchant_txn_datetime ?? 'NA' }}
                        </div>

                    @else

                        <div class="form-group col-md-4">
                            <label class="bold">Date</label><br> :
                            {{ $paymentDetails?->created_at ?? 'NA' }}
                        </div>

                        <div class="form-group col-md-4">
                            <label class="bold">Transaction ID</label><br> :
                            {{ $paymentDetails?->DEPARTMENT_ID ?? 'NA' }}
                        </div>

                        <div class="form-group col-md-4">
                            <label class="bold">GRN</label><br> :
                            {{ $paymentDetails?->GRN ?? 'NA' }}
                        </div>

                    @endif

                    <div class="form-group col-md-4">
                        <label class="bold">Total Application Fees</label><br> :
                        Rs 25 /-
                    </div>

                </div>
            </div>
        @elseif ($worker_details->already_payment_status == true)
            <div class="custom-form mr-2 ml-2">
                <div class="form-row  mb-4"><!--start 1-->
                    <div class="form-check col-md-12" style="text-align: center;">
                        <h5 class="preview-color"><i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;Payment
                            Details:</h5>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPassword4" class="bold">Previous Acknowledgement Number </label> <br /> :
                        {{ $worker_details->previous_acknowledgement_number ?? 'N/A' }}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4" class="bold">Transaction ID </label> <br /> :
                        {{ $worker_details->ack_transaction_id ?? 'N/A' }}
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPassword4" class="bold">Payment Date </label> <br /> :
                        {{ \Carbon\Carbon::parse($worker_details->ack_payment_date)->format('d-m-Y') ?? 'NA' }}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputFirstName" class="bold">Total Application fees</label> <br /> : Rs 25 /-
                    </div>
                </div>
            </div>
        @endif
    @endif

    {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-file"  aria-hidden="true"></i>&nbsp;Uploaded Documents:</h5> --}}

    <div class="custom-form mr-1 ml-1">
        <div class="form-row mt-2">
            <div class="form-check col-md-12" style="text-align: center;">
                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                    Uploaded Documents Details
                </span>
                </h5>
            </div>
        </div>
        <div class="table-responsive mt-2">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col" class="bold">Type Of Documents</th>
                    <th scope="col" class="bold">Attachments</th>
                </tr>
                </thead>
                <tbody>

                @if ($worker_details?->already_registered == 1)
                    <tr>
                        <td>BOC ID Card</td>
                        <td>
                            <a href="{{ route('boc-card', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                               class="href" target="_blank">
                                <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View Attachment
                            </a>
                        </td>
                    </tr>
                @endif

                {{-- FIX: Added ?-> null-safe operator --}}
                @if (!$worker_details?->address?->do && !$worker_details?->address?->type_of_document)
                    <tr>
                        <td>Present Address Proof</td>
                        <td>
                            <a href="{{ route('res-proof', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                               class="href" target="_blank">
                                <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View Attachment
                            </a>
                        </td>
                    </tr>
                @endif

                {{-- FIX: Added ?-> null-safe operator --}}
                @if ($worker_details?->already_registered == 1 && $worker_details?->basicDetail?->subscription_receipt == 1 && $subscription_receipt)
                    <tr>
                        <td>Subscription Receipt Copy</td>
                        <td>
                            <a href="{{ route('subscription-view', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                               class="href" target="_blank">
                                <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View Attachment
                            </a>
                        </td>
                    </tr>
                @elseif ($worker_details?->already_registered == 1 && $worker_details?->basicDetail?->subscription_receipt == 0 && $subscription_receipt)
                    <tr>
                        <td>Subscription Receipt Copy</td>
                        <td>
                            <a href="{{ route('subscription-view', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                               class="href" target="_blank">
                                <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View Attachment
                            </a>
                        </td>
                    </tr>
                @endif

                <tr>
                    <td>Worker Bank Passbook Copy</td>
                    <td>
                        <a href="{{ route('bank-pass', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                           class="href" target="_blank">
                            <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View Attachment
                        </a>
                    </td>
                </tr>

                @if ($worker_details?->already_payment_status == true)
                    <tr>
                        <td>Previous Payment Acknowledgement Slip</td>
                        <td>
                            <a href="{{ route('ack-pay-slip', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                               class="href" target="_blank">
                                <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View Attachment
                            </a>
                        </td>
                    </tr>
                @endif

                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <!--HRO-->
    <div class="d-flex justify-content-center mt-4 mb-3 action-bar-modern">
        @if (Auth::user()->role_id == 2 && ($worker_details->status == 'A' || $worker_details->status == 'B'))
            <div class="d-flex justify-content-center mt-4 mb-3">
                @if ($worker_details->already_registered == 1)
                    @can('approve onboardingapplication')
                        <a class="btn btn-primary btn-sm mx-1" id="approve-btn" href="javascript:void(0);">
                            <i class="fa fa-check"></i> Approve
                        </a>
                    @endcan
                @else
                    <a class="btn btn-primary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                       data-target="#approve-modal">
                        <i class="fa fa-check"></i> Approve
                    </a>
                @endif
                @if ($worker_details->already_registered == 1)
                    <a class="btn btn-warning btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                       data-target="#reroute-modal-existing">
                        <i class="fa fa-arrow-right"></i> Re-Route
                    </a>
                @else
                    <a class="btn btn-warning btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                       data-target="#reroute-modal-new">
                        <i class="fa fa-arrow-right"></i> Re-Route
                    </a>
                @endif

                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#reject-modal">
                    <i class="fa fa-times"></i> Reject
                </a>
                <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#forward-modal">
                    <i class="fa fa-arrow-right"></i> Forward
                </a>
                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#revertback-modal">
                    <i class="fa fa-undo"></i> Revert
                </a>
                <a class="btn btn-warning btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-backward"></i> Dashboard
                </a>
            </div>
        @endif

    <!--RO-->
        @if (Auth::user()->role_id == 3 && $worker_details->status == 'O' && $worker_details->da_forward != 1)
            <div class="d-flex justify-content-center mt-4 mb-3">
                @if ($worker_details->already_registered == 1)
                    @can('approve onboardingapplication')
                        <a class="btn btn-primary btn-sm mx-1" id="approve-btn" href="javascript:void(0);">
                            <i class="fa fa-check"></i> Approve
                        </a>
                    @endcan
                @else
                    <a class="btn btn-primary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                       data-target="#approve-modal">
                        <i class="fa fa-check"></i> Approve
                    </a>
                @endif
                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#reject-modal">
                    <i class="fa fa-times"></i> Reject
                </a>
                <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#forward-modal">
                    <i class="fa fa-arrow-right"></i> Forward
                </a>

                @if ($worker_details->already_registered == 1)
                    <a class="btn btn-warning btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                       data-target="#reroute-modal-existing">
                        <i class="fa fa-arrow-right"></i> Re-Route
                    </a>
                @else
                    <a class="btn btn-warning btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                       data-target="#reroute-modal-new">
                        <i class="fa fa-arrow-right"></i> Re-Route
                    </a>
                @endif

                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#revertback-modal">
                    <i class="fa fa-undo"></i> Revert
                </a>
                <a class="btn btn-warning btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-backward"></i> Dashboard
                </a>
            </div>
            <!-- HRO-->
        @elseif (Auth::user()->role_id == 3 && $worker_details->status == 'O' && $worker_details->da_forward == 1)
            <div class="d-flex justify-content-center mt-4 mb-3">
                @if ($worker_details->already_registered == 1)
                    @can('approve onboardingapplication')
                        <a class="btn btn-primary btn-sm mx-1" id="approve-btn" href="javascript:void(0);">
                            <i class="fa fa-check"></i> Approve
                        </a>
                    @endcan
                @else
                    <a class="btn btn-primary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                       data-target="#approve-modal">
                        <i class="fa fa-check"></i> Approve
                    </a>
                @endif
                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#reject-modal">
                    <i class="fa fa-times"></i> Reject
                </a>
                <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#forward-modal">
                    <i class="fa fa-arrow-right"></i> Forward
                </a>

                <a class="btn btn-secondary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#forward-modal-hro">
                    <i class="fa fa-undo"></i> Send Back
                </a>

                @if ($worker_details->already_registered == 1)
                    <a class="btn btn-warning btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                       data-target="#reroute-modal-existing">
                        <i class="fa fa-arrow-right"></i> Re-Route
                    </a>
                @else
                    <a class="btn btn-warning btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                       data-target="#reroute-modal-new">
                        <i class="fa fa-arrow-right"></i> Re-Route
                    </a>
                @endif

                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#revertback-modal">
                    <i class="fa fa-undo"></i> Revert
                </a>
                <a class="btn btn-warning btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-backward"></i> Dashboard
                </a>
            </div>


            <!---Renewal Modal -->
        @elseif(Auth::user()->role_id == 3 && $worker_details->status == 'R')
            <div class="d-flex justify-content-center mt-4 mb-3">
                <a class="btn btn-primary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#approve-modal">
                    <i class="fa fa-check"></i> Approve
                </a>
                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#reject-modal">
                    <i class="fa fa-times"></i> Reject
                </a>
                <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#forward-modal">
                    <i class="fa fa-arrow-right"></i> Forward
                </a>
                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#revertback-modal">
                    <i class="fa fa-undo"></i> Revert
                </a>


                <a class="btn btn-warning btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-backward"></i> Dashboard
                </a>
            </div>
        @elseif (Auth::user()->role_id == 5 && $worker_details->status == 'M')
            <div class="d-flex justify-content-center mt-4 mb-3">

                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#forward-modal_reroute">
                    <i class="fa fa-check"></i> Take Action
                </a>

                <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#forward-to-da-modal-reroute">
                    <i class="fa fa-arrow-right"></i> Forward To Review
                </a>
                <a class="btn btn-warning btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-backward"></i> Dashboard
                </a>
            </div>


        @elseif(Auth::user()->role_id == 18 && $worker_details->status == 'N')

            <div class="d-flex justify-content-center mt-4 mb-3">

                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#forward-modal_reroute_HO">
                    <i class="fa fa-paper-plane"></i> Forward to Head Office
                </a>

                {{--<a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"--}}
                {{--data-target="#forward-to-da-modal-reroute">--}}
                {{--<i class="fa fa-arrow-right"></i> Forward To Review--}}
                {{--</a>--}}
                <a class="btn btn-warning btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-retweet"></i> Dashboard
                </a>
            </div>

            <!--if pulled Back From RO-->
            {{-- @elseif(Auth::user()->role_id == 2 && $worker_details->status == 'B')
                <div class="d-flex justify-content-center mt-2 mb-3">
                    @if ($worker_details->already_registered == 1)
                        <a class="btn btn-primary btn-sm mx-1" id="approve-btn" href="javascript:void(0);">
                            <i class="fa fa-check"></i> Approve
                        </a>
                    @else
                        <a class="btn btn-primary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                            data-target="#approve-modal">
                            <i class="fa fa-check"></i> Approve
                        </a>
                    @endif
                    <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                        data-target="#forward-modal">
                        <i class="fa fa-arrow-right"></i> Forward
                    </a>
                    <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                        data-target="#reject-modal">
                        <i class="fa fa-times-circle"></i> Reject
                    </a>
                    <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                        data-target="#revertback-modal">
                        <i class="fa fa-undo"></i> Revert
                    </a>
                    <a class="btn btn-warning btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                        <i class="fa fa-times"></i> Dashboard
                    </a>
                </div> --}}
        <!--(Auth::user()->role_id == 3 && $worker_details_renew->status == 'O'-->
        @elseif(Auth::user()->role_id == 3 && $worker_details->status == 'O')
            <div class="d-flex justify-content-center mt-2 mb-3">
                <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#approve-modal">
                    <i class="fa fa-check-circle"></i> Approve
                </a>
                <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#reject-modal">
                    <i class="fa fa-times-circle"></i> Reject
                </a>
                <a class="btn btn-warning btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-times"></i> Dashboard
                </a>
            </div>
        @elseif(Auth::user()->role_id == 3 && $worker_details->status == 'C')
            <div class="d-flex justify-content-center mt-2 mb-3">
                <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#pullback-modal">
                    <i class="fa fa-cloud-download-alt"></i> Pull Back Application
                </a>
                <a class="btn btn-danger btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-times"></i> Dashboard
                </a>
            </div>
        @elseif(
            (Auth::user()->role_id == 2 && $worker_details->status == 'C') ||
                (Auth::user()->role_id == 2 && $worker_details->status == 'O'))
            <div class="d-flex justify-content-center mt-2 mb-3">
                <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#pullback-modal">
                    <i class="fa fa-cloud-download-alt"></i> Pull Back Application
                </a>
                <a class="btn btn-danger btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-times"></i> Dashboard
                </a>
            </div>
        @elseif(Auth::user()->role_id == 4 && $worker_details->status == 'C')
            <div class="d-flex justify-content-center mt-2 mb-3">
                <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
                   data-target="#forward-modal-ro">
                    <i class="fa fa-undo"></i> Send Back
                </a>
                <a class="btn btn-danger btn-sm mx-1" href="{{ route('office.dashboard.index') }}">
                    <i class="fa fa-home"></i> Dashboard
                </a>
            </div>

        @endif
    </div>
    <div class="modal fade" id="forward-modal" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Send Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">Forward the application to respective officer</p>
                    @if ($worker_details->renewal_status == null)
                        @if (Auth::user()->role_id == 2)
                            <form action="{{ route('forward_application_to_ro_da') }}" method="POST">
                            @elseif(Auth::user()->role_id == 3 && $worker_details->status == 'O')
                                <form action="{{ route('forward_application') }}" method="POST">
                                @else
                                    <form action="{{ route('forward_renew-application') }}" method="POST">
                        @endif
                    @endif
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="application_id" value="{{ $worker_details->worker_id }}">
                        <label for="" class="bold">Role:</label>

                        <select name="role_id" class="form-control" id="ro-select">

                            @if (!$roles)
                                <option value="">No Role Found</option>
                            @else
                                <option value="" selected disabled>Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            @endif

                        </select>

                    </div>
                    <div class="form-group">
                        <label for=""class="bold">User:</label>
                        <select name="user_id" class="form-control" id="user-dropdown">
                            <option value="">Select User</option>
                            {{-- @if (Auth::user()->role_id == 2)
                                    @foreach ($username as $users)
                                        <option style="font-weight: bold;" value="{{ $users->id }}">
                                            {{ $users->username }} ({{ $users->role->name }})</option>
                                    @endforeach
                                @elseif(Auth::user()->role_id == 3)
                                    @foreach ($da as $dauser)
                                        <option style="font-weight: bold;" value="{{ $dauser->id }}">
                                            {{ $dauser->username }} ({{ $dauser->role->name }})</option>
                                    @endforeach
                                @endif --}}
                        </select>
                    </div>
                    <div class="form-group">

                        <label class="control-label bold col-md-8" for="office">Remarks:</label>
                        <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                        @if ($errors->has('remarks'))
                            <span
                                class="text-danger font-weight-normal error-message">{{ $errors->first('remarks') }}</span>
                        @endif
                    </div>



                    <div class="text-center py-2">
                        <button type="submit" class="btn btn-primary b-btn mx-2">
                            <i class="fa fa-check-circle"></i> Submit
                        </button>
                        <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i>Cancel</button>
                    </div>
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Approve modal-->
    <div class="modal fade" id="approve-modal" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Approve Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    @if ($worker_details->renewal_status == null)
                        <form action="{{ route('approve_application') }}" method="POST">
                        @else
                            <form action="{{ route('approve_renew-application') }}" method="POST">
                    @endif
                    @csrf
                    <div class="form-group">
                        <label class="control-label bold col-md-12 text-center" for="office">Do you want to Approve the Application ?</label>
                        <div class="col-md-12 mt-2">
                            <input type="hidden" name="application_id" value="{{ $worker_details->worker_id }}">

                            {{--<textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>--}}
                        </div>
                    </div>

                    <div class="text-center py-2">
                        <button type="submit" class="btn btn-primary b-btn mx-2">
                            <i class="fa fa-check-circle"></i> Submit
                        </button>
                        <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i>Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approve-modal-ex" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Approve Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    @if ($worker_details->renewal_status == null)
                        <form action="{{ route('approve_application-onboarding') }}" method="POST">
                        @else
                            <form action="{{ route('approve_renew-application') }}" method="POST">
                    @endif
                    @csrf
                    <div class="form-group">
                        <label class="control-label bold col-md-12 text-center" for="office">Do you want to Approve the Application ?</label>
                        <div class="col-md-12 mt-2">
                            <input type="hidden" name="application_id" value="{{ $worker_details->worker_id }}">

                            <input type="hidden" name="card_validity_date" id="hidden_card_validity_date">
                            <input type="hidden" name="subscription_validity_date"
                                id="hidden_subscription_validity_date">
                            <input type="hidden" name="last_registration_date" id="hidden_last_registration_date">
                            <input type="hidden" name="last_renewal_date" id="hidden_last_renewal_date">

                            {{--<textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>--}}
                        </div>
                    </div>

                    <div class="text-center py-2">
                        <button type="submit" class="btn btn-primary b-btn mx-2">
                            <i class="fa fa-check-circle"></i> Yes
                        </button>
                        <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i>No</button>
                    </div>
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="forward-modal-ro" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Send Back Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"></p>
                    <form action="{{ route('send-application-back') }}" method="POST">
                        @csrf
                        <div class="form-group">

                            <div class="col-md-12">
                                <input type="hidden" name="application_id" value="{{ $worker_details->worker_id }}">
                                <label class="control-label bold col-md-8" for="office">Role:</label>
                                <select name="role_id" class="form-control" id="role_id">
                                    @if (!$roleDa)
                                        <option value="" selected>No Role Found</option>
                                    @else
                                        <option value="{{ $roleDa->id }}"selected>{{ $roleDa->name }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label bold col-md-8" for="office">User:</label>
                                <select name="user_id" class="form-control" id="user_id">
                                    @if (!$userDa)
                                        <option value="" selected>No User Found</option>
                                    @else
                                        <option value="{{ $userDa->id }}" selected>{{ $userDa->username }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                            </div>
                            <div class="text-center py-2">
                                <button type="submit" class="btn btn-primary b-btn mx-2">
                                    <i class="fa fa-check-circle"></i> Submit
                                </button>
                                <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                        class="fa fa-times-circle"></i>Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="forward-modal-hro" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Send Back Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"></p>
                    <form action="{{ route('send-application-back-hro') }}" method="POST">
                        @csrf
                        <div class="form-group">

                            <div class="col-md-12">
                                <input type="hidden" name="application_id"
                                    value="{{ $worker_details->worker_id }}">
                                <label class="control-label bold col-md-8" for="office">Role:</label>
                                <select name="role_id" class="form-control" id="role_id">
                                    @if (!$roleHro)
                                        <option value="" selected>No Role Found</option>
                                    @else
                                        <option value="{{ $roleHro->id }}"selected>{{ $roleHro->name }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label bold col-md-8" for="office">User:</label>
                                <select name="user_id" class="form-control" id="user_id">
                                    @if (!$userHro)
                                        <option value="" selected>No User Found</option>
                                    @else
                                        <option value="{{ $userHro->id }}" selected>{{ $userHro->username }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                            </div>
                            <div class="text-center py-2">
                                <button type="submit" class="btn btn-primary b-btn mx-2">
                                    <i class="fa fa-check-circle"></i> Submit
                                </button>
                                <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                        class="fa fa-times-circle"></i>Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="forward-modal-ro" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Forward Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">Forward the application to RO</p>
                    @if ($worker_details->renewal_status == null)
                        <form action="" method="POST">
                        @else
                            <form action="{{ route('forward-renew-ro-application') }}" method="POST">
                    @endif
                    @csrf
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="hidden" name="application_id" value="{{ $worker_details->worker_id }}">
                            <label class="control-label bold col-md-8" for="office">Select User:</label>
                            <select name="role_id" class="form-control" id="role_id">
                                @if (!$ro)
                                    <option value=""selected>Role Not Found</option>
                                @else
                                    @foreach ($ro as $users)
                                        <option value="{{ $ro->role_id }}">{{ $ro->role->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="control-label bold col-md-8" for="office">Remarks:</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                        </div>
                    </div>
                    <div class="text-center py-2">
                        <button type="submit" class="btn btn-primary b-btn mx-2">
                            <i class="fa fa-check-circle"></i> Submit
                        </button>
                        <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i>Cancel</button>
                    </div>
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="forward-modal-ro" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Forward Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">Forward the application to RO</p>
                    @if ($worker_details->renewal_status == null)
                        <form action="" method="POST">
                        @else
                            <form action="{{ route('forward-renew-ro-application') }}" method="POST">
                    @endif
                    @csrf
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="hidden" name="application_id" value="{{ $worker_details->worker_id }}">
                            <label class="control-label bold col-md-8" for="office">Select User:</label>
                            <select name="role_id" class="form-control" id="role_id">
                                @if (!$ro)
                                    <option value=""selected>Role Not Found</option>
                                @else
                                    @foreach ($ro as $users)
                                        <option value="{{ $ro->role_id }}">{{ $ro->role->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="control-label bold col-md-8" for="office">Remarks:</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                        </div>
                    </div>
                    <div class="text-center py-2">
                        <button type="submit" class="btn btn-primary b-btn mx-2">
                            <i class="fa fa-check-circle"></i> Submit
                        </button>
                        <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i>Cancel</button>
                    </div>
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Reject modal-->
    <!--Revert to worker -->
    <div class="modal fade" id="revertback-modal" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Revert Back Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('application-revert') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="control-label bold col-md-8" for="reasons">Select Reasons for Revert
                                Application:</label>
                            @if ($worker_details->already_registered == 1)
                                @foreach ($revertReasonsOn as $reason)
                                    <div class="form-check d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" id="reason1"
                                            name="revert_reasons[]" value="{{ $reason->id }}">
                                        <label class="form-check-label"
                                            for="revert-{{ $reason->id }}">{{ $reason->reason }}</label>
                                    </div>
                                @endforeach
                            @elseif($worker_details->already_registered == null)
                                @foreach ($revertReasons as $reason)
                                    <div class="form-check d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" id="reason1"
                                            name="revert_reasons[]" value="{{ $reason->id }}">
                                        <label class="form-check-label"
                                            for="revert-{{ $reason->id }}">{{ $reason->reason }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="hidden" name="application_id"
                                    value="{{ $worker_details->worker_id }}">
                                <input type="hidden" name="revert_back" value="1">
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="control-label bold col-md-8" for="office">Remarks:(Please specifically
                                mention the discrepancy in the documents and other issues
                                in the remark section after choosing the above reasons)</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter remarks"></textarea>
                        </div>

                        <div class="text-center py-2">
                            <button type="submit" class="btn btn-primary b-btn mx-2">
                                <i class="fa fa-check-circle"></i> Submit
                            </button>
                            <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                    class="fa fa-times-circle"></i>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--reroute-->
    <div class="modal fade" id="reroute-modal-existing" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Re-route Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"></p>
                    <form action="{{ route('application-reroute-existing') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="hidden" name="application_id"
                                    value="{{ $worker_details->worker_id }}">
                                <input type="hidden" name="re_route" value="1">
                            </div>
                            <div class="col-md-12">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="control-label bold">District</label>
                                <select id="districtcode"  name="district_code" class="form-control districtcode">
                                    <option value="">Select District</option>
                                    @foreach ($dists as $district)
                                        <option value="{{ $district->district_code }}">{{ $district->district_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="error text-danger" id="districtError"></p>
                                @if ($errors->has('district'))
                                    <span
                                        class="text-warning font-weight-normal">{{ $errors->first('district') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="control-label bold col-md-8" for="office">Office:</label>
                                <select id="office_id" name="office_id" class="form-control">
                                    <option value="">Select Office</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                            </div>
                        </div>
                        <div class="text-center py-2">
                            <button type="submit" class="btn btn-primary b-btn mx-2">
                                <i class="fa fa-check-circle"></i> Submit
                            </button>
                            <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                    class="fa fa-times-circle"></i>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reroute-modal-new" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Re-route Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"></p>
                    <form action="{{ route('application-reroute-new-reg') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="hidden" name="application_id"
                                    value="{{ $worker_details->worker_id }}">
                                <input type="hidden" name="re_route" value="1">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label bold col-md-8" for="office">Select Role:</label>
                                <select name="role_id" class="form-control" id="role_id">
                                    @if (!$officeAdmin)
                                        <option value="" selected>Role Not Found</option>
                                    @else
                                        @foreach ($officeAdmin as $xyz)
                                            <option value="{{ $xyz->role_id }}">{{ $xyz->role->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="control-label bold col-md-8" for="office">Select User:</label>
                                <select name="user_id" class="form-control" id="user_id">
                                    @if (!$officeAdmin)
                                        <option value="" selected>User Not Found</option>
                                    @else
                                        @foreach ($officeAdmin as $xyz)
                                            <option value="{{ $xyz->id }}">{{ $xyz->username }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                <input type="hidden" name="district_code" value="618">
                                <input type="hidden" name="office_id" value="67">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="control-label bold" for="office">Remarks:</label>
                                <textarea name="remarks" class="form-control" placeholder="Enter remarks"></textarea>
                            </div>
                        </div>
                        <div class="text-center py-2">
                            <button type="submit" class="btn btn-primary b-btn mx-2">
                                <i class="fa fa-check-circle"></i> Submit
                            </button>
                            <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                    class="fa fa-times-circle"></i>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--forward from state office Head to HDA -->
    <div class="modal fade" id="forward-modal_reroute" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Forward Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"></p>
                    <form action="{{ route('application-forward-after-reroute') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="hidden" name="application_id"
                                    value="{{ $worker_details->worker_id }}">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="control-label bold">District</label>
                                <select id="district-code" name="district_code" class="form-control">
                                    <option value="">Select District</option>
                                    @foreach ($dists as $district)
                                        <option value="{{ $district->district_code }}">
                                            {{ $district->district_name }}</option>
                                    @endforeach
                                </select>
                                <p class="error text-danger" id="districtError"></p>
                                @if ($errors->has('district_code'))
                                    <span
                                        class="text-warning font-weight-normal">{{ $errors->first('district_code') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label class="control-label bold " for="office">Office:</label>
                                <select id="office_code" name="office_id_r" class="form-control">
                                    <option value="">Select Office</option>
                                </select>
                                @if ($errors->has('office_id_r'))
                                    <span
                                        class="text-warning font-weight-normal">{{ $errors->first('office_id_r') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="control-label bold" for="office">Remarks:</label>
                                <textarea name="remarks" class="form-control" placeholder="Enter remarks"></textarea>
                            </div>
                        </div>
                        <div class="text-center py-2">
                            <button type="submit" class="btn btn-primary b-btn mx-2">
                                <i class="fa fa-check-circle"></i> Submit
                            </button>
                            <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                    class="fa fa-times-circle"></i>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <!--forward to da head office -->
        <div class="modal fade" id="forward-to-da-modal-reroute" aria-hidden="true" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center d-block p-2 border-bottom-0">
                        <h5 class="modal-title">Forward Application</h5>
                        <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                                data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p class="text-center"></p>
                        <form action="{{ route('application-reroute-forward-da') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="hidden" name="application_id"
                                           value="{{ $worker_details->worker_id }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label bold col-md-8" for="office">Select Role:</label>
                                    <select name="role_id" class="form-control" id="role_id">
                                        @if (!$office_da)
                                            <option value="" selected>Role Not Found</option>
                                        @else
                                            @foreach ($office_da as $xyz)
                                                <option value="{{ $xyz->role_id }}">{{ $xyz->role->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label class="control-label bold col-md-8" for="office">Select User:</label>
                                    <select name="user_id" class="form-control" id="user_id">
                                        @if (!$office_da)
                                            <option value="" selected>User Not Found</option>
                                        @else
                                            @foreach ($office_da as $xyz)
                                                <option value="{{ $xyz->id }}">{{ $xyz->username }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    {{--<input type="hidden" name="district_code" value="618">--}}
                                    {{--<input type="hidden" name="office_id" value="67">--}}
                                </div>

                                <div class="col-md-12 mt-2">
                                    <label class="control-label bold" for="office">Remarks:</label>
                                    <textarea name="remarks" class="form-control" placeholder="Enter remarks"></textarea>
                                </div>
                            </div>
                            <div class="text-center py-2">
                                <button type="submit" class="btn btn-primary b-btn mx-2">
                                    <i class="fa fa-check-circle"></i> Submit
                                </button>
                                <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                            class="fa fa-times-circle"></i>Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--forward to HO FROM HDA office -->
        <div class="modal fade" id="forward-modal_reroute_HO" aria-hidden="true" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center d-block p-2 border-bottom-0">
                        <h5 class="modal-title">Return To DLC</h5>
                        <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                                data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p class="text-center"></p>
                        <form action="{{ route('forward-to-ho-from-da') }}" method="POST">
                            @csrf
                            <div class="form-group">

                                <div class="col-md-12">
                                    <input type="hidden" name="application_id" value="{{ $worker_details->worker_id }}">
                                    <label class="control-label bold col-md-8" for="office">Role:</label>
                                    <select name="role_id" class="form-control" id="role_id">
                                        @if (!$roleDa)
                                            <option value="" selected>No Role Found</option>
                                        @else
                                            <option value="{{ $roleDa->id }}"selected>{{ $roleDa->name }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label bold col-md-8" for="office">User:</label>
                                    <select name="user_id" class="form-control" id="user_id">
                                        @if (!$userDa)
                                            <option value="" selected>No User Found</option>
                                        @else
                                            <option value="{{ $userDa->id }}" selected>{{ $userDa->username }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                    <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                                </div>
                                <div class="text-center py-2">
                                    <button type="submit" class="btn btn-primary b-btn mx-2">
                                        <i class="fa fa-check-circle"></i> Submit
                                    </button>
                                    <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                                class="fa fa-times-circle"></i>Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!--forward to ro-->
    <div class="modal fade" id="pullback-modal" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Pullback Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"></p>
                    <form action="{{ route('application-pullback') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12 mb-2">
                                <input type="hidden" name="application_id"
                                    value="{{ $worker_details->worker_id }}">
                                <input type="hidden" name="pull_back" value="1">
                                <label class="control-label bold col-md-8" for="office">Role</label>
                                <select name="role_id" class="form-control" id="role_id">

                                    <option value="{{ $pullDa->role_id }}">{{ $pullDa->role->name }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label bold col-md-8" for="office">User:</label>
                                <select name="user_id" class="form-control" id="user_id">
                                    @if (!$userDa)
                                        <option value="" selected>No User Found</option>
                                    @else
                                        <option value="{{ $userDa->id }}" selected>{{ $userDa->username }}
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="control-label bold col-md-8" for="office">Remarks:</label>
                                <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                            </div>
                        </div>
                        <div class="text-center py-2">
                            <button type="submit" class="btn btn-primary b-btn mx-2">
                                <i class="fa fa-check-circle"></i> Submit
                            </button>
                            <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                    class="fa fa-times-circle"></i>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reject-modal" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title">Reject Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <form action="{{ route('reject_application') }}" method="POST">
                        @csrf
                        <input type="hidden" name="application_id" value="{{ $worker_details->worker_id }}">
                        @if ($worker_details->already_registered == 1)
                            <div class="form-group">
                                <label class="control-label bold col-md-8" for="reasons">Select Reasons for
                                    Rejection:</label>
                                @foreach ($rejectReasonsOn as $reason)
                                    <div class="form-check d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" id="reason1"
                                            name="reject_reasons[]" value="{{ $reason->id }}">
                                        <label class="form-check-label"
                                            for="reject-{{ $reason->id }}">{{ $reason->reason }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="form-group">
                                <label class="control-label bold col-md-8" for="reasons">Select Reasons for
                                    Rejection:</label>
                                @foreach ($rejectReasons as $reason)
                                    <div class="form-check d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" id="reason1"
                                            name="reject_reasons[]" value="{{ $reason->id }}">
                                        <label class="form-check-label"
                                            for="reject-{{ $reason->id }}">{{ $reason->reason }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label bold col-md-8" for="office">Remarks:(Please specifically
                                mention the discrepancy in the documents and other issues
                                in the remark section after choosing the above reasons)</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                        </div>
                        <div class="text-center py-2">
                            <button type="submit" class="btn btn-primary b-btn mx-2">
                                <i class="fa fa-check-circle"></i> Submit
                            </button>
                            <button class="btn btn-danger mx-3" data-dismiss="modal"><i
                                    class="fa fa-times-circle"></i>Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div></div>
    <!--PullBack-->
    <!--forward to ro-->

@endsection
<script src="{{ URL::asset('assets/template/js/getVaultOffice.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/jquery-3.7.0.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
<script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize flatpickr for each input field
        flatpickr('#last_registration_date', {
            dateFormat: "Y-m-d",
            defaultDate: "",
            maxDate: "08-01-2025"
        });
        flatpickr('#card_validity_date', {
            dateFormat: "Y-m-d",
            defaultDate: "",
            maxDate: "08-01-2027"
        });
        flatpickr('#subscription_validity_date', {
            dateFormat: "Y-m-d",
            defaultDate: "",
        });


        // Function to calculate the difference between two dates in year

    });
</script>
{{-- <script> --}}
{{--    const approveButton = document.getElementById('approve-btn'); --}}
{{--    const lastRenewalDateInput = document.getElementById('last_renewal_date'); --}}
{{--    const lastRegistrationDateInput = document.getElementById('last_registration_date'); --}}
{{--    const cardValidityDateInput = document.getElementById('card_validity_date'); --}}
{{--    const subscriptionValidityDateInput = document.getElementById('subscription_validity_date'); --}}


{{--    function parseDateFromFlatpickr(dateString) { --}}
{{--        if (!dateString) return null; --}}
{{--        const [day, month, year] = dateString.split('-').map(Number); --}}
{{--        return new Date(year, month - 1, day); // Convert to Date object --}}
{{--    } --}}

{{--    function formatDateToDMY(date) { --}}
{{--        if (!date || isNaN(date)) return ''; --}}
{{--        const day = String(date.getDate()).padStart(2, '0'); --}}
{{--        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed --}}
{{--        const year = date.getFullYear(); --}}
{{--        return `${day}-${month}-${year}`; --}}
{{--    } --}}

{{--    function validateDates() { --}}
{{--        const issueDateField = document.getElementById('last_registration_date'); --}}
{{--        const validityDateField = document.getElementById('card_validity_date'); --}}
{{--        const renewalDateGroup = document.getElementById('renewal_date_group'); --}}
{{--        const renewalDateField = document.getElementById('last_renewal_date'); --}}

{{--        const issueDate = parseDateFromFlatpickr(issueDateField.value); --}}
{{--        const validityDate = parseDateFromFlatpickr(validityDateField.value); --}}
{{--        const renewalDate = renewalDateField.value ? parseDateFromFlatpickr(renewalDateField.value) : null; --}}

{{--        const formattedIssueDate = formatDateToDMY(issueDate); --}}
{{--        const formattedValidityDate = formatDateToDMY(validityDate); --}}
{{--        const formattedRenewalDate = renewalDate ? formatDateToDMY(renewalDate) : ''; --}}

{{--        console.log(`Issue Date: ${formattedIssueDate}`); --}}
{{--        console.log(`Validity Date: ${formattedValidityDate}`); --}}
{{--        console.log(`Renewal Date: ${formattedRenewalDate}`); --}}

{{--        if (!issueDate || !validityDate) { --}}
{{--            renewalDateGroup.style.display = 'none'; --}}
{{--            renewalDateField.removeAttribute('required'); --}}
{{--            renewalDateField.value = ''; --}}
{{--            return; --}}
{{--        } --}}

{{--        const oneDay = 1000 * 60 * 60 * 24; --}}

{{--        function isLeapYear(year) { --}}
{{--            return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0); --}}
{{--        } --}}

{{--        const adjustedValidityDate = new Date(validityDate.getTime() + oneDay); --}}
{{--        const differenceInDays = Math.ceil((adjustedValidityDate - issueDate) / oneDay); --}}

{{--        const startYear = issueDate.getFullYear(); --}}
{{--        const endYear = adjustedValidityDate.getFullYear(); --}}

{{--        let daysInPeriod = 0; --}}
{{--        let leapYearInRange = false; --}}

{{--        // Check if the start or end year is a leap year or if the period spans a leap year --}}
{{--        for (let year = startYear; year <= endYear; year++) { --}}

{{--            // Check if the year is a leap year and set the flag accordingly --}}
{{--            if (isLeapYear(year)) { --}}
{{--                leapYearInRange = true; // Set this to true if any year in range is a leap year --}}
{{--            } --}}

{{--            if (year === startYear && year === endYear) { --}}
{{--                // If the range is within the same year, calculate the difference in days --}}
{{--                daysInPeriod = differenceInDays; --}}
{{--            } else if (year === startYear) { --}}
{{--                // If the range starts in this year, calculate the remaining days in this year --}}
{{--                const daysRemainingInStartYear = new Date(year + 1, 0, 1) - issueDate; --}}
{{--                daysInPeriod += daysRemainingInStartYear / oneDay; --}}
{{--            } else if (year === endYear) { --}}
{{--                // If the range ends in this year, calculate the days in this year until the validity date --}}
{{--                const daysUntilEndYear = adjustedValidityDate - new Date(year, 0, 1); --}}
{{--                daysInPeriod += daysUntilEndYear / oneDay; --}}
{{--            } else { --}}
{{--                // For full years in between, count the full days of the year (365 or 366) --}}
{{--                daysInPeriod += isLeapYear(year) ? 366 : 365; --}}
{{--            } --}}
{{--        } --}}
{{--        console.log("Start Year: ", startYear); --}}
{{--        console.log("End Year: ", endYear); --}}
{{--        console.log("Leap Year in Range: ", leapYearInRange); --}}
{{--        console.log("Total Days in Period: ", daysInPeriod); --}}

{{--        // Subtract days based on whether the duration spans a leap year --}}
{{--        if (leapYearInRange) { --}}
{{--            // If the duration spans a leap year, subtract 2 days --}}
{{--            daysInPeriod -= 2; --}}
{{--            if (daysInPeriod >= 730) { --}}
{{--                renewalDateGroup.style.display = 'block'; --}}
{{--                renewalDateField.setAttribute('required', 'required'); --}}
{{--                if (renewalDate && renewalDate >= validityDate) { --}}
{{--                    Swal.fire({ --}}
{{--                        icon: 'error', --}}
{{--                        title: 'Invalid Renewal Date', --}}
{{--                        text: `The last renewal date (${formattedRenewalDate}) must be less than the card validity date (${formattedValidityDate}).`, --}}
{{--                    }); --}}
{{--                    renewalDateField.value = ''; // Clear invalid renewal date --}}
{{--                } --}}
{{--            } else if (daysInPeriod === 729) { --}}
{{--                renewalDateGroup.style.display = 'none'; --}}
{{--                renewalDateField.removeAttribute('required'); --}}
{{--                renewalDateField.value = ''; --}}
{{--            } else if (daysInPeriod < 729) { --}}
{{--                Swal.fire({ --}}
{{--                    icon: 'error', --}}
{{--                    title: 'Invalid Date Range', --}}
{{--                    text: `The duration between card issue date (${formattedIssueDate}) and card validity date (${formattedValidityDate}) cannot be less than 2 years.`, --}}
{{--                }); --}}
{{--                validityDateField.value = ''; --}}
{{--                renewalDateGroup.style.display = 'none'; --}}
{{--                renewalDateField.removeAttribute('required'); --}}
{{--                renewalDateField.value = ''; --}}
{{--            } --}}

{{--        } else { --}}
{{--            // Otherwise, subtract 1 day --}}
{{--            daysInPeriod -= 1; --}}
{{--            if (daysInPeriod >= 730) { --}}
{{--                renewalDateGroup.style.display = 'block'; --}}
{{--                renewalDateField.setAttribute('required', 'required'); --}}
{{--                if (renewalDate && renewalDate >= validityDate) { --}}
{{--                    Swal.fire({ --}}
{{--                        icon: 'error', --}}
{{--                        title: 'Invalid Renewal Date', --}}
{{--                        text: `The last renewal date (${formattedRenewalDate}) must be less than the card validity date (${formattedValidityDate}).`, --}}
{{--                    }); --}}
{{--                    renewalDateField.value = ''; // Clear invalid renewal date --}}
{{--                } --}}
{{--            } else if (daysInPeriod < 729) { --}}
{{--                Swal.fire({ --}}
{{--                    icon: 'error', --}}
{{--                    title: 'Invalid Date Range', --}}
{{--                    text: `The duration between card issue date (${formattedIssueDate}) and card validity date (${formattedValidityDate}) cannot be less than 2 years.`, --}}
{{--                }); --}}
{{--                renewalDateGroup.style.display = 'none'; --}}
{{--                renewalDateField.removeAttribute('required'); --}}
{{--                renewalDateField.value = ''; --}}
{{--            } else if (daysInPeriod === 729) { --}}
{{--                renewalDateGroup.style.display = 'none'; --}}
{{--                renewalDateField.removeAttribute('required'); --}}
{{--                renewalDateField.value = ''; --}}
{{--            } --}}

{{--        } --}}

{{--        console.log(daysInPeriod); --}}
{{--    } --}}
{{-- </script> --}}
<script>
    function validateDates() {
        let cardValidityDate = document.getElementById("card_validity_date").value;
        let subscriptionValidityDate = document.getElementById("subscription_validity_date").value;

        if (cardValidityDate && subscriptionValidityDate) {
            let cardDate = new Date(cardValidityDate);
            let subscriptionDate = new Date(subscriptionValidityDate);

            // Calculate the minimum allowed subscription date (2 years before card date)
            let minSubscriptionDate = new Date(cardDate);
            minSubscriptionDate.setFullYear(minSubscriptionDate.getFullYear() - 2);

            if (subscriptionDate < minSubscriptionDate) {
                alert("Subscription Validity Date cannot be less than 2 years from Card Validity Date.");


                document.getElementById("subscription_validity_date").value = "";
            }
        }
    }
</script>
<script>
    $(document).on('click', '.show-remarks', function () {

        let workerId = $(this).data('worker');

        // Loader
        $("#remarks-container").html(`
        <div class="text-center p-4">
            <div class="spinner-border text-primary"></div>
            <div class="mt-2 text-muted">Loading timeline...</div>
        </div>
    `);

        $.ajax({
            url: "/worker/" + encodeURIComponent(workerId) + "/remarks",
            type: "GET",

            success: function (response) {

                let html = '<div class="timeline">';

                let allRemarks = [];

                // Merge both arrays
                if (response.renewalRemarks) {
                    allRemarks = allRemarks.concat(response.renewalRemarks);
                }

                if (response.remarksMain) {
                    allRemarks = allRemarks.concat(response.remarksMain);
                }

                // No data case
                if (allRemarks.length === 0) {
                    $("#remarks-container").html(`
                    <div class="text-center text-muted p-4">
                        No remarks found.
                    </div>
                `);
                    return;
                }

                // Sort latest first
                allRemarks.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                // Loop
                allRemarks.forEach(function (remark) {

                    const sender = remark.sender_name ?? 'Unknown User';

                    // Handle both structures safely
                    const receiver =
                        remark.receiver_name ??
                            `${remark.get_receiver?.firstname ?? ''} ${remark.get_receiver?.lastname ?? ''}`.trim() ??
                                'N/A';

                    const text = remark.remarks ?? '';

                    const isPrevious =
                        remark.user_was_transferred &&
                        remark.timeline === 'Previous User';

                    const badgeClass = isPrevious
                        ? 'timeline-badge-warning'
                        : 'timeline-badge-primary';

                    const label = isPrevious ? 'Previous' : 'Current';

                    const time = remark.created_at
                        ? new Date(remark.created_at).toLocaleString('en-IN', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true,
                        })
                        : '';

                    html += `
                    <div class="timeline-item">

                        <div class="timeline-marker ${badgeClass}"></div>

                        <div class="timeline-content">

                            <div class="timeline-header">
                                <span class="timeline-user">${sender}</span>
                                <span class="timeline-badge ${badgeClass}">
                                    ${label}
                                </span>
                            </div>

                            <div class="timeline-text">
                                ${text}
                            </div>

                            <div class="timeline-footer">
                                <span>To: <strong>${receiver}</strong></span>
                                <span class="timeline-time">${time}</span>
                            </div>

                        </div>
                    </div>
                `;
                });

                html += '</div>';

                $("#remarks-container").html(html);
            },

            error: function () {
                $("#remarks-container").html(`
                <div class="text-danger p-3 text-center">
                    Failed to load remarks. Try again.
                </div>
            `);
            }
        });
    });
</script>








<script>
    document.addEventListener('DOMContentLoaded', function() {
        const approveButton = document.getElementById('approve-btn');
//        console.log(approveButton);
        const modal = $('#approve-modal-ex');
        const closeButton = document.querySelector('#approve-modal-ex .close');
        const cancelButton = document.querySelector('#approve-modal-ex .btn-danger');

        if (!approveButton) {
            console.error('Approve button not found in the DOM.');
            return;
        }

        approveButton.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default behavior

            // Fetch input elements
            const lastRegDateInput = document.getElementById('last_registration_date');
            console.log(lastRegDateInput)
            const cardValidityDateInput = document.getElementById('card_validity_date');
            console.log(cardValidityDateInput)
            const subscriptionValidityDateInput = document.getElementById('subscription_validity_date');

            // Parse dates
            const lastRegDate = lastRegDateInput.value;
            const cardValidityDate = cardValidityDateInput.value;
            const subscriptionValidityDate = subscriptionValidityDateInput.value;


            // Validation logic
            if (!lastRegDate) {
                alert('Check Last Issue Date, Card validity date and Subscription Validity Date');
                lastRegDateInput.focus();
                return;
            }
            if (!cardValidityDate) {
                alert('Card Validity Date is required.');
                cardValidityDateInput.focus();
                return;
            }
            if (!subscriptionValidityDate) {
                alert(
                    'Subscription Validity Date is required.Check Card Validity date and Last Issue Date'
                );
                subscriptionValidityDateInput.focus();
                return;
            }

            document.getElementById('hidden_card_validity_date').value =
                cardValidityDate;
            console.log(cardValidityDate);
            document.getElementById('hidden_subscription_validity_date').value =
                subscriptionValidityDate;
            console.log(subscriptionValidityDate)
            document.getElementById('hidden_last_registration_date').value =
                lastRegDate;
            // If all validations pass, open the modal
            console.log('All validations passed. Opening modal...');

            modal.modal('show');
        });
        [closeButton, cancelButton].forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                 modal.modal('hide');
            });
        });

        // Initialize Flatpickr for date inputs
        flatpickr('#card_validity_date', {
            dateFormat: "Y-m-d",
            defaultDate: "",
            maxDate: "2027-01-07" // Use YYYY-MM-DD format for maxDate
        });


        flatpickr('#subscription_validity_date', {
            dateFormat: "Y-m-d",

            defaultDate: "",
            maxDate: "2027-01-08"
        });

        flatpickr('#last_registration_date', {
            dateFormat: "Y-m-d",
            defaultDate: "",
            maxDate: "2025-01-08"
        });

        /**
         * Converts a date string in d-m-Y format to a JavaScript Date object.
         * @param {string} dateString - The date string in d-m-Y format.
         * @returns {Date|null} - A JavaScript Date object or null if parsing fails.
         */
        function parseDate(dateString) {
            const parts = dateString.split('-'); // Split the date into [day, month, year]
            if (parts.length !== 3) return null; // Ensure it's in the correct format
            const day = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1; // Months are 0-based in JS
            const year = parseInt(parts[2], 10);
            return new Date(year, month, day);
        }

        /**
         * Formats a JavaScript Date object to an input-compatible string (YYYY-MM-DD).
         * @param {Date} date - The date to format.
         * @returns {string} - The formatted date string.
         */
        // function formatDateToInput(date) {
        //     const year = date.getFullYear();
        //     const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        //     const day = String(date.getDate()).padStart(2, '0');
        //     return `${year}-${month}-${day}`;
        // }

        // Fetch input elements
        // const subscriptionValidityDateInput = document.getElementById('subscription_validity_date');
        // const lastRegDateInput = document.getElementById('last_registration_date');
        // const cardValidityDateInput = document.getElementById('card_validity_date');
        //
        //
        //
        // // Ensure subscription validity date aligns with the last registration date
        // subscriptionValidityDateInput.addEventListener('change', function() {
        //     if (!lastRegDateInput.value || !cardValidityDateInput.value) {
        //         console.error('Last Registration Date or Card Validity Date is not set.');
        //         return;
        //     }
        //
        //     const lastRegDate = parseDate(lastRegDateInput.value);
        //     let subscriptionValidityDate = parseDate(subscriptionValidityDateInput.value);
        //     const cardValidityDate = parseDate(cardValidityDateInput.value);
        //
        //
        //     if (!lastRegDate || !subscriptionValidityDate || !cardValidityDate) {
        //         console.error('Invalid date format.');
        //         return;
        //     }
        //
        //     // 1. Check if the day of subscription validity date matches the day of card validity date (cycle date)
        //     if (subscriptionValidityDate.getDate() !== subscriptionValidityDate.getDate()) {
        //         let newDate = new Date(subscriptionValidityDate);
        //         newDate.setDate(s.getDate());
        //
        //         // If the new date overflows (e.g., trying to set 31st in a month with <31 days), adjust to last valid date
        //         if (newDate.getMonth() !== subscriptionValidityDate.getMonth()) {
        //             newDate.setDate(
        //             0); // Sets to last day of previous month (i.e., last valid day of intended month)
        //         }
        //
        //         // alert('The day of the Subscription Validity Date must match the day of the ID Card Validity Date (Cycle Date).');
        //         subscriptionValidityDateInput.value = formatDateToDMY(newDate);
        //         console.log('Subscription Validity Date adjusted to:', subscriptionValidityDateInput
        //             .value);
        //     }
        //
        //
        // });
        // const lastRenewalDateInput = document.getElementById('last_renewal_date');
        // lastRenewalDateInput.addEventListener('change', function() {
        //     if (!lastRegDateInput.value || !cardValidityDateInput.value) {
        //         console.error('Last Registration Date or Card Validity Date is not set.');
        //         return;
        //     }
        //
        //     const lastRegDate = parseDate(lastRegDateInput.value);
        //
        //     const lastRenewalDate = parseDate(lastRenewalDateInput.value);
        //
        //     if (!lastRegDate || isNaN(lastRegDate) ) {
        //         console.error('Invalid date format.');
        //         return;
        //     }
        // });
        // Add click event listener for approve button

    });
</script>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dobStr = document.getElementById('dob').dataset.dob;
        const age = calculateAgeFromDDMMYYYY(dobStr);
        document.getElementById('age').textContent = age;
    });

    function calculateAgeFromDDMMYYYY(dobString) {
        const parts = dobString.split("-");
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1;
        const year = parseInt(parts[2], 10);

        const dob = new Date(year, month, day);
        const today = new Date();

        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        return age;
    }
</script>
{{-- <script> --}}
{{--    document.addEventListener('DOMContentLoaded', (event) => { --}}
{{--        // Function to parse date strings --}}
{{--        function parseDate(dateString) { --}}
{{--            if (!dateString || dateString === "NA") return null; // Return null for empty or 'NA' values --}}
{{--            const parts = dateString.split('-'); --}}
{{--            return new Date(parts[2], parts[1] - 1, parts[0]); // Assuming DD-MM-YYYY format --}}
{{--        } --}}

{{--        // Select fields --}}
{{--        const aadhaarDob = document.getElementById('uid_dob')?.value; --}}
{{--        const oldDob = document.getElementById('old_dob')?.value; --}}
{{--        const aadhaarDobDate = parseDate(aadhaarDob); --}}
{{--        const oldDobDate = parseDate(oldDob); --}}
{{--        const aadhaarName = document.getElementById('uid_name')?.value; --}}
{{--        const oldName = document.getElementById('old_name')?.value || "NA"; --}}
{{--        const aadhaarCareOf = document.getElementById('uid_care_of')?.value; --}}
{{--        const oldCareOf = document.getElementById('old_care_of')?.value || "NA"; --}}
{{--        const aadhaarGender = document.getElementById('uid_gender')?.value; --}}
{{--        const oldGender = document.getElementById('old_gender')?.value || "NA"; --}}

{{--        let hasMismatch = false; --}}
{{--        let oldDataMissing = false; --}}

{{--        // Helper function to add/remove classes --}}
{{--        function updateClass(elementId, classToAdd) { --}}
{{--            const element = document.getElementById(elementId); --}}
{{--            if (element) { --}}
{{--                element.classList.remove('highlight-mismatch', 'highlight-match'); --}}
{{--                element.classList.add(classToAdd); --}}
{{--            } --}}
{{--        } --}}

{{--        // Compare and highlight mismatches --}}
{{--        if (oldName === "NA" || oldCareOf === "NA" || oldGender === "NA" || oldDob === "NA") { --}}
{{--            oldDataMissing = true; --}}
{{--        } --}}

{{--        if (!oldDataMissing) { --}}
{{--            if (aadhaarName !== oldName) { --}}
{{--                updateClass('uid_name', 'highlight-mismatch'); --}}
{{--                updateClass('old_name', 'highlight-mismatch'); --}}
{{--                hasMismatch = true; --}}
{{--            } else { --}}
{{--                updateClass('uid_name', 'highlight-match'); --}}
{{--                updateClass('old_name', 'highlight-match'); --}}
{{--            } --}}

{{--            if (aadhaarCareOf !== oldCareOf) { --}}
{{--                updateClass('uid_care_of', 'highlight-mismatch'); --}}
{{--                updateClass('old_care_of', 'highlight-mismatch'); --}}
{{--                hasMismatch = true; --}}
{{--            } else { --}}
{{--                updateClass('uid_care_of', 'highlight-match'); --}}
{{--                updateClass('old_care_of', 'highlight-match'); --}}
{{--            } --}}

{{--            if (aadhaarGender !== oldGender) { --}}
{{--                updateClass('uid_gender', 'highlight-mismatch'); --}}
{{--                updateClass('old_gender', 'highlight-mismatch'); --}}
{{--                hasMismatch = true; --}}
{{--            } else { --}}
{{--                updateClass('uid_gender', 'highlight-match'); --}}
{{--                updateClass('old_gender', 'highlight-match'); --}}
{{--            } --}}

{{--            if (!aadhaarDobDate || !oldDobDate || aadhaarDobDate.getTime() !== oldDobDate.getTime()) { --}}
{{--                updateClass('uid_dob', 'highlight-mismatch'); --}}
{{--                updateClass('old_dob', 'highlight-mismatch'); --}}
{{--                hasMismatch = true; --}}
{{--            } else { --}}
{{--                updateClass('uid_dob', 'highlight-match'); --}}
{{--                updateClass('old_dob', 'highlight-match'); --}}
{{--            } --}}
{{--        } --}}

{{--        const alert = document.getElementById('error-alert'); --}}
{{--        if (oldDataMissing) { --}}
{{--            alert.textContent = "Previous data not found!"; --}}
{{--            alert.classList.remove('d-none'); --}}
{{--        } else if (hasMismatch) { --}}
{{--            alert.textContent = "Check Aadhaar Fields with Existing ID Card Field!"; --}}
{{--            alert.classList.remove('d-none'); --}}
{{--        } else { --}}
{{--            alert.classList.add('d-none'); --}}
{{--        } --}}
{{--    }); --}}
{{-- </script> --}}


<script>
    $(document).ready(function() {
        $('#districtcode').on('change', function() {
            var districtCode = $(this).val();
            console.log('Selected District Code: ' + districtCode);


            if (districtCode) {

                $.ajax({
                    url: host + 'worker/get-office',
                    type: 'GET',
                    data: {
                        district_code: districtCode,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(data) {
                        var dis = '#office_id';
                        console.log(data);
                        $(dis).html('<option value="">Select Office</option>');
                        $.each(data.office, function(key, value) {
                            console.log(value.office_name)
                            $(dis).append('<option value="' + value.office_id +
                                '">' + value.office_name + '</option>');
                        });

                    }
                });
            } else {
                $('#office_code').empty();
                $('#office_code').append('<option value="">Select Office</option>');
            }
        });
    });

    $(document).ready(function() {
        $('#ro-select').on('change', function() {
            var selectedRoleId = $(this).val();

            // Clear existing options in the user dropdown
            $('#user-dropdown').empty().append('<option value="">Loading...</option>');

            $.ajax({
                url: '{{ route('office.dashboard.get-user-by-role') }}', // Replace with your API endpoint
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    role_id: selectedRoleId
                },
                success: function(response) {
                    // Clear the loading option
                    if (response.status == true) {
                        $('#user-dropdown').empty();

                        if (response.results && response.results.length > 0) {
                            // Append new options dynamically
                            $('#user-dropdown').append(
                                '<option value="" disabled selected>Select User</option>'
                            );
                            response.results.forEach(function(user) {
                                $('#user-dropdown').append('<option value="' + user
                                        .id +
                                    '">' + user.firstname + ' ' + user
                                        .lastname + '</option>');
                            });
                        } else {
                            $('#user-dropdown').append(
                                '<option value="">No Users Found</option>');
                        }
                    }
                },
                error: function() {
                    $('#user-dropdown').empty().append(
                        '<option value="">Error fetching users</option>');
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const lastRegistrationInput = document.getElementById('last_registration_date');
        const subscriptionInput = document.getElementById('subscription_validity_date');
        const subscriptionHidden = document.getElementById('subscription_validity_hidden');

        // Blade-controlled condition
        const lockSubscription = @json(
        $worker_details->basicDetail->subscription_receipt == 0 && !$subscription_receipt
    );

        if (lockSubscription && lastRegistrationInput) {
            lastRegistrationInput.addEventListener('change', function () {

                if (subscriptionInput) {
                    subscriptionInput.value = this.value;
                    subscriptionInput.min = this.value;
                    subscriptionInput.max = this.value;
                }

                if (subscriptionHidden) {
                    subscriptionHidden.value = this.value;
                }
            });
        }

    });
</script>

