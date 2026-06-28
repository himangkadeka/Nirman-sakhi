@extends('layouts.admin-app')

@section('title', 'Office | Application | Preview')
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Preview Renewal')

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
        .bold {
            font-weight: 500;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 13px;
            /*color: #186cb8;*/
            color: #8b5050 !important;
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

        /*.highlight-aadhaar{*/
        /*    background: #f7f7f7;*/
        /*    margin-bottom: 10px;*/
        /*    padding: 10px 4px;*/
        /*}*/
        /*.highlight-oldData{*/
        /*    background: #dadada;*/
        /*    margin-bottom: 10px;*/
        /*    padding: 10px 4px;*/
        /*}*/

        .blink {
            animation: blink-animation 0.5s steps(2, start) infinite;
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
    </style>
@endsection

@section('content')
    <div>
        <div class="container-fluid" id="b-homedb" style="font-family: Helvetica, Arial, sans-serif ";>
            <div class="col-md-12">
                <!-- Header with title + clock -->
                <div class="d-flex justify-content-between align-items-center p-3 mb-4 rounded shadow-sm"
                     style="background: linear-gradient(90deg, #f8f9fa, #ffffff); border: 1px solid #e9ecef;">
                    <h4 class="mb-0 font-weight-bold text-dark">
                        <i class="fas fa-sync-alt text-primary mr-2"></i> Renewal Applications
                    </h4>
                    <div id="digitalClock"
                         class="px-3 py-1 rounded text-white font-weight-bold"
                         style="background-color: #007bff; font-size: 1rem; min-width: 130px; text-align: center;">
                    </div>
                </div>
                @if (!$renewalRemarks->isEmpty())
                    <ul class="remarks-officer-list">
                        <span class="remarks-title"><i class="fas fa-sync-alt text-primary mr-2"></i>Forwarding Remarks:</span>
                        @foreach ($renewalRemarks as $remark)

                            <li class="remarks-officer-item">
                                Sender:
                                <strong>
                                    {{ $remark->getSenderUserName->firstname ?? '' }}
                                    {{ $remark->getSenderUserName->lastname ?? '' }}
                                </strong>Receiver :
                                <strong>
                                    {{ $remark->getReceiver->firstname ?? '' }}
                                    {{ $remark->getReceiver->lastname ?? '' }}
                                </strong> —
                                <span class="text-info">{{ $remark->remarks }}</span> —
                                Timestamp:
                                <span class="text-primary font-weight-bold">
                        {{ $remark->created_at->format('d M Y, h:i A') }}
                    </span>
                            </li>
                        @endforeach
                    </ul>
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
                            @if ($resubmit_remarks)
                                <ul class="revert-list">

                                    <li class="revert-reason">{{ $resubmit_remarks->remarks}}</li>Timestamp: <span class="text-primary font-weight-bold">
                                    {{ $remark->created_at->format('d M Y, h:i A') }}
                                </span>
                                </ul>
                            @endif
                        </div>
                    </div>

                @endif

                {{--@if ($resubmit_remarks)--}}
                {{--<div class="revert-container">--}}
                {{--<div class="revert-box">--}}
                {{--<span class="revert-title">Application Reverted for the Following Reasons:</span>--}}
                {{--<ul class="revert-list">--}}
                {{--@foreach ($resubmit_remarks as $remark)--}}
                {{--<li class="revert-reason">{{ $remark->remarks}}</li>Timestamp: <span class="text-primary font-weight-bold">--}}
                {{--{{ $remark->created_at->format('d M Y, h:i A') }}--}}
                {{--</span>--}}
                {{--@endforeach--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--@endif--}}



                <div class="custom-form">
                    <div class="form-row heading-with-photo d-flex align-items-center justify-content-between p-3"
                         style="background: #f8f9fa; border-radius: 8px;">

                        <!-- Applicant Photo -->
                        <img src="data:image/jpeg;base64,{{$base64Image}}"
                             alt="Applicant Photo"
                             class="app-photo"
                             style="width: 140px; height: 180px; border-radius: 8px; object-fit: cover;">

                    </div>
                    <div>
                        <div class="form-row mt-3 mb-2"><!--start 1-->
                            <div class="form-check col-md-12" style="text-align: center;">
                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Renewal Details
                                        </span>
                                </h5>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="form-group col-md-3">
                                <label class="bold">Application Type </label>
                                <span class="text-dark">
                                @if ($worker_details->is_renewal == 1)
                                        <span class="form-control-plaintext">Renewal</span>
                                    @endif
                            </span>

                            </div>



                            <div class="form-group col-md-3">
                                <label class="bold">Existing ID Card </label>
                                <span class="form-control-plaintext text-danger">{{ $worker_details->id_card }}</span>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="bold">Worker Status</label>
                                @if (isset($worker_details->basicDetail) && $worker_details->basicDetail->resident_type == 'rao')
                                    <span class="form-control-plaintext">Migrant Worker</span>
                                @else
                                    <span class="form-control-plaintext">Resident Worker</span>
                                @endif
                            </div>
                            @if (isset($worker_details->basicDetail) && $worker_details->basicDetail->resident_type == 'rao')
                                <div class="form-group col-md-3">
                                    <label class="bold">State</label>
                                    <input type="text" class="form-control" placeholder=""
                                           value="{{ $getVaultData['state'] ?? 'N/A' }}" readonly />
                                </div>
                            @endif
                        </div>



                        <div class="form-row">

                            <!-- ID Card Issue -->
                            <div class="form-group col-md-3">
                                <label class="bold">Registration Date </label>
                                <span class="form-control-plaintext">
            {{  \Carbon\Carbon::parse($worker_details->last_registration_date)->format('d-m-Y') }}
        </span>
                            </div>

                            <!-- Card Validity Date -->
                            <div class="form-group col-md-3">
                                <label class="bold">Card Validity Date</label>
                                <span class="form-control-plaintext">
            {{ \Carbon\Carbon::parse($worker_details->id_card_expiry_date)->format('d-m-Y')}}
        </span>
                            </div>

                            <!-- Subscription Paid Upto -->
                            <div class="form-group col-md-3">
                                <label class="bold">Subscription Paid Upto</label>
                                <span class="form-control-plaintext" id="subscription_validity_date_display">
            {{Carbon\Carbon::parse($worker_details->subscription_validity_date)->format('d-m-Y') }}
        </span>
                            </div>


                            <div class="form-group col-md-3">
                                <label class="bold">Date Of Retirement</label>
                                <span class="form-control-plaintext" id="subscription_validity_date_display">
            {{Carbon\Carbon::parse($worker_details->date_of_retirement)->format('d-m-Y')}}
        </span>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="custom-form mr-1 ml-1">
                    <div class="form-row mt-2"><!--start 1-->
                        <div class="form-check col-md-12">
                            <h5 class="mt-4 d-flex" style="color: #007bff;">
            <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                Membership Subscription Book details
            </span>
                            </h5>

                            <!-- Notice design starts here -->
                            <div class="alert alert-info mt-3" role="alert" style=" margin: 0 auto; font-size: 15px;">
                                <strong>Penalty Waiver Notice:</strong> Penalty charges for subscription are waived from
                                <strong>3rd July 2025</strong> to <strong>2nd July 2026</strong> as per ABOCWWB’s decision.
                                No penalty will be applied during this period. Further updates will be notified by the Board.
                            </div>
                            <!-- Notice design ends here -->
                        </div>
                    </div>
                    <!--end-->
                    <div class="row">
                        <div class="col">
                            <div class="table-container">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="bold">Serial No</th>
                                        <th scope="col" class="bold">Transaction Id</th>
                                        <th scope="col" class="bold">From Period</th>
                                        <th scope="col" class="bold">To Period</th>
                                        {{--                                            <th scope="col" class="bold">Age</th> --}}
                                        <th scope="col" class="bold">Membership Subscription</th>
                                        <th scope="col" class="bold">Fine</th>
                                        <th scope="col" class="bold">Amount Paid</th>
                                        <th scope="col" class="bold">Timestamp</th>

                                        <!-- Repeat headers as needed -->
                                    </tr>
                                    <tr>
                                        @foreach ($subscription_data as $subscription)
                                            <td>{{ $loop->iteration }}</td>

                                            <td class="fixed-width">{{ $subscription->transaction_id ?? 'N/A' }}
                                            </td>
                                            <td class="fixed-width">{{ $subscription->from_period }}</td>
                                            <td class="fixed-width">{{ $subscription->to_period }}</td>
                                            <td class="fixed-width">{{ $subscription->amount_paid - $subscription->fine }}</td>
                                            <td class="fixed-width">{{ $subscription->fine }}</td>
                                            <td class="fixed-width">{{ $subscription->amount_paid }}</td>
                                            <td class="fixed-width">{{ $subscription->updated_at }}</td>

                                    </tr>
                                    @endforeach
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="custom-form">

                    <div class="form-row mt-3 mb-2"><!--start 1-->
                        <div class="form-check col-md-12" style="text-align: center;">
                            <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Basic Details
                                        </span>
                            </h5>
                        </div>
                    </div>



                    {{--<div class="form-row">--}}
                    {{--<div class="form-group col-md-3">--}}
                    {{--<label class="bold">Last Subscription Payment Date</label>--}}
                    {{--<span class="form-control-plaintext-plaintext">{{$worker_details->basicDetail->subscription_payment_date}}</span>--}}
                    {{--</div>--}}
                    {{--<div class="form-group col-md-3">--}}
                    {{--<label class="bold">Subscription Payment Amount</label>--}}
                    {{--<span--}}
                    {{--class="form-control-plaintext">{{ $worker_details->basicDetail->subscription_amount_paid }}</span>--}}
                    {{--</div>--}}
                    {{--</div>--}}



                    <div class="form-row highlight-aadhaar"><!--start 1-->
                        <div class="form-group col-md-3">
                            <label for="inputFirstName" class="bold">Name</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                             style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                            <span class="form-control-plaintext">{{ $getVaultData['name'] }}</span>

                        </div>


                        <div class="form-group col-md-3">
                            <label for="inputLastName" class="bold">Care Of</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                               style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                            <span class="form-control-plaintext">{{ $getVaultData['careOf'] }}</span>

                        </div>
                        <div class="form-group col-md-3">
                            <label for="gender" class="bold">Gender</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                       style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                            {{--                            <input type="text" class="form-control  uc-text-smooth" id="uid_gender" --}}
                            {{--                                value="{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : 'Others') }}" --}}
                            {{--                                readonly> --}}
                            <span
                                    class="form-control-plaintext">{{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : 'Others') }}</span>

                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputDob" class="bold">{{ trans('worker-registration/worker-data-preview.dob') }}</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                                                                             style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                                {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                            <span class="form-control-plaintext" id="dob"  data-dob="{{ $getVaultData['dob'] }}">{{ $getVaultData['dob'] }}</span>
                        </div>
                    </div>



                    <!--end-->


                    <div class="form-row"><!--start 1-->

                        <div class="form-group col-md-3">
                            <label for="inputAdhaar" class="bold">Aadhaar No</label>
                            {{--                            <input type="text" id="dob" class="form-control" --}}
                            {{--                                value="{{ $getVaultData['uID'] }}" disabled> --}}
                            <span class="form-control-plaintext">{{ $getVaultData['uID'] }}</span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputAge" class="bold">{{ trans('worker-registration/worker-data-preview.age') }}</label>
                            <span class="form-control-plaintext" id="age"></span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputPhone" class="bold">Contact Number</label>
                            {{--                            <input type="text" class="form-control " value="{{ $worker_details->phone_no }}" --}}
                            {{--                                disabled> --}}
                            <span class="form-control-plaintext">{{ $worker_details->phone_no }}</span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="mStatus" class="bold">Marital Status</label>
                            {{--                            <input type="text" class="form-control " --}}
                            {{--                                value="{{ $worker_details->basicDetail->maritalStatus->marital_status }}" readonly> --}}
                            <span
                                    class="form-control-plaintext">{{ $worker_details->basicDetail->maritalStatus->marital_status }}</span>
                        </div>
                    </div><!--end-->

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputCategory" class="bold">Category</label>
                            {{--                            <input type="text" class="form-control " id="age" --}}
                            {{--                                value="{{ $worker_details->basicDetail->cateGory->category_name }}" disabled> --}}
                            <span
                                    class="form-control-plaintext">{{ $worker_details->basicDetail->cateGory->category_name }}</span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputPF" class="bold">e-Shram Number</label>
                            {{--                            <input type="text" class="form-control  uc-text-smooth" --}}
                            {{--                                value="{{ $worker_details->basicDetail->eshram_no }}" readonly> --}}
                            <span class="form-control-plaintext">
                                {{ $worker_details->basicDetail->eshram_no ?? 'NA' }}
                            </span>

                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputPF" class="bold">Blood Group</label>
                            {{--                            <input type="text" class="form-control  uc-text-smooth" --}}
                            {{--                                value="{{ $worker_details->basicDetail->bloodGroup->blood_group }}" readonly> --}}
                            <span
                                    class="form-control-plaintext">{{ $worker_details->basicDetail->bloodGroup->blood_group }}</span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPhone" class="bold">Education Details</label>
                            {{--                            <input type="text" class="form-control  uc-text-smooth" --}}
                            {{--                                value="{{ $worker_details->basicDetail->education->education_name }}" readonly> --}}
                            <span
                                    class="form-control-plaintext">{{ $worker_details->basicDetail->education->education_name }}</span>
                        </div>
                    </div>

                    <div class="form-row"><!--start 1-->


                        <div class="form-group col-md-3">
                            <label for="inputEsic" class="bold">Email </label>
                            {{--                            <input type="text" class="form-control  uc-text-smooth" --}}
                            {{--                                value="{{ $worker_details->basicDetail->email ?? __('N/A') }}" readonly> --}}
                            <span class="form-control-plaintext">{{ $worker_details->basicDetail->email ?: 'N/A' }}</span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPhone" class="bold">PAN Available</label>
                            {{--                            <input type="text" class="form-control " --}}
                            {{--                                value="{{ $worker_details->basicDetail->pan == 1 ? 'Yes' : 'No' }}" readonly> --}}
                            <span
                                    class="form-control-plaintext">{{ $worker_details->basicDetail->pan == 1 ? 'Yes' : 'No' }}</span>
                        </div>
                        @if ($worker_details->basicDetail->pan == 1)
                            <div class="form-group col-md-3">
                                <label for="inputPhone" class="bold">PAN Number</label>
                                {{--                                <input type="text" class="form-control " --}}
                                {{--                                    value="{{ $worker_details->basicDetail->pan_no }}" readonly> --}}
                                <span class="form-control-plaintext">{{ $worker_details->basicDetail->pan_no }}</span>
                            </div>
                        @endif
                        <div class="form-group col-md-4">
                            <label for="inputPhone" class="bold">Already Registered With Other State BOC</label>
                            {{--                            <input type="text" class="form-control " --}}
                            {{--                                value="{{ $worker_details->basicDetail->boc == 1 ? 'Yes' : 'No' }}" readonly> --}}
                            <span
                                    class="form-control-plaintext">{{ $worker_details->basicDetail->boc == 1 ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                    <!--end-->
                    <div class="form-row"><!--start 1-->
                        @if ($worker_details->basicDetail->boc == '1')
                            <div class="form-group col-md-4">
                                <label for="inputPhone" class="bold">Name Of State(BOCW Board)</label>
                                {{--                                <input type="text" class="form-control " --}}
                                {{--                                    value="{{ $worker_details->basicDetail->otherState->state_name }}" id="pan_no" --}}
                                {{--                                    name="pan_no" readonly> --}}
                                <span
                                        class="form-control-plaintext">{{ $worker_details->basicDetail->otherState->state_name }}</span>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputPhone" class="bold">BOC Number</label>
                                {{--                                <input type="text" class="form-control " --}}
                                {{--                                    value="{{ $worker_details->basicDetail->boc_no }}" id="pan_no" name="pan_no" --}}
                                {{--                                    readonly> --}}
                                <span class="form-control-plaintext">{{ $worker_details->basicDetail->boc_no }}</span>
                            </div>
                        @endif
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-4">
                            <label for="inputPF" class="bold">Ration Card </label>
                            {{--                            <input type="text" class="form-control " --}}
                            {{--                                value="{{ $worker_details->basicDetail->has_ration_card == 1 ? 'Yes' : 'No' }}"readonly> --}}
                            <span
                                    class="form-control-plaintext">{{ $worker_details->basicDetail->has_ration_card == 1 ? 'Yes' : 'No' }}</span>
                        </div>
                        @if ($worker_details->basicDetail->has_ration_card == 1)
                            <div class="form-group col-md-3">
                                <label for="inputPF" class="bold">Ration Card Number</label>
                                {{--                                <input type="text" class="form-control " id="ration_no" name="ration_no" --}}
                                {{--                                    value="{{ $worker_details->basicDetail->ration_no }}" placeholder="" readonly> --}}
                                <span class="form-control-plaintext">{{ $worker_details->basicDetail->ration_no }}</span>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPF" class="bold">Ration Card Type</label>
                                {{--                                <input type="text" class="form-control " id="ration" name="ration_type" --}}
                                {{--                                    value="{{ $worker_details->basicDetail->rationType->name }}" placeholder="" readonly> --}}
                                <span
                                        class="form-control-plaintext">{{ $worker_details->basicDetail->rationType->name }}</span>
                            </div>
                        @endif
                        @if ($worker_details->already_registered == 1)
                            @if ($worker_details->basicDetail->profession === 28)
                                <div class="form-group col-md-3">
                                    <label for="inputPhone" class="bold">Profession</label>
                                    {{--                                    <input type="text" class="form-control " --}}
                                    {{--                                        value="{{ $worker_details->basicDetail->profession_others ?? 'NA' }}" readonly> --}}
                                    <span
                                            class="form-control-plaintext">{{ $worker_details->basicDetail->profession_others ?? 'NA' }}</span>
                                </div>
                            @else
                                <div class="form-group col-md-3">
                                    <label for="inputPhone" class="bold">Profession</label>
                                    {{--                                    <input type="text" class="form-control " --}}
                                    {{--                                        value="{{ $worker_details->basicDetail->Profession->profession_name ?? 'NA' }}" --}}
                                    {{--                                        readonly> --}}
                                    <span
                                            class="form-control-plaintext">{{ $worker_details->basicDetail->Profession->profession_name ?? 'NA' }}</span>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="custom-form mr-2 ml-2">
        <div class="form-row  mb-4"><!--start 1-->
            <div class="form-check col-md-12" style="text-align: center;">
                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Permanent Address Details
                                        </span>
                </h5>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputFirstName" class="bold">State</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" class="form-control " name="landmark" --}}
                {{--                        value="{{ $getVaultData['state'] ?? 'N/A' }}" id="landmark" readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['state'] ?? 'N/A' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputLastName" class="bold">District</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                    style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" class="form-control " name="landmark" --}}
                {{--                        value="{{ $getVaultData['district'] ?? 'N/A' }}" id="landmark" readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['district'] ?? 'N/A' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputPassword4" class="bold">Sub District </label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                          style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" class="form-control  uc-text-smooth" --}}
                {{--                        value="{{ $getVaultData['subDistrict'] ?? 'N/A' }}" id="permanentBuilding" name="p_house_no" --}}
                {{--                        readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['subDistrict'] ?? 'N/A' }}</span>
            </div>

            <div class="form-group col-md-3">
                <label for="gender" class="bold">Post Office </label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                 style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" class="form-control  uc-text-smooth" id="permanentArea" name="p_area" --}}
                {{--                        value="{{ $getVaultData['postOffice'] ?? 'N/A' }}" readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['postOffice'] ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="form-row"><!--start 1-->
            <div class="form-group col-md-3">
                <label for="inputMstatus" class="bold">Road/Street</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                      style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" id="permanentCity" class="form-control" name="p_city" --}}
                {{--                        value="{{ $getVaultData['street'] ?? 'N/A' }}" readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['street'] ?? 'N/A' }}</span>
            </div>

            <div class="form-group col-md-3">
                <label for="inputAdhaar" class="bold">Locality</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                  style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" class="form-control uc-text-smooth" id="permanentRoad" name="p_road" --}}
                {{--                        value="{{ $getVaultData['locality'] ?? 'N/A' }}" readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['locality'] ?? 'N/A' }}</span>
            </div>

            <div class="form-group col-md-3">
                <label for="inputDob" class="bold">Village</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                              style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" class="form-control " value="{{ $getVaultData['village'] ?? 'N/A' }}" --}}
                {{--                        readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['village'] ?? 'N/A' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputAge" class="bold">Landmark</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                               style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" class="form-control " value=" {{ $getVaultData['landMark'] ?? 'N/A' }}" --}}
                {{--                        readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['landMark'] ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="form-row"><!--start 1-->
            <div class="form-group col-md-3">
                <label for="inputPhone" class="bold">Building Name</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                      style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" class="form-control " id="permanentPin" --}}
                {{--                        value="{{ $getVaultData['buildingName'] ?? 'N/A' }}" name="p_pin" placeholder="" readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['buildingName'] ?? 'N/A' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputPhone" class="bold">Pin Code</label>&nbsp;<span class="badge bg-success text-light position-relative top-0 end-0 mt-1 me-1"
                                                                                 style="font-size: 10px; padding: 6px 10px; border-radius: 2px;">
    <i class="fa fa-check-circle"></i>
                    {{ trans('worker-registration/worker_basic_details.aadhaar') }}
        </span>
                {{--                    <input type="text" class="form-control " id="permanentPin" --}}
                {{--                        value="{{ $getVaultData['pinCode'] ?? 'N/A' }}" name="p_pin" placeholder="" readonly> --}}
                <span class="form-control-plaintext">{{ $getVaultData['pinCode'] ?? 'N/A' }}</span>
            </div>
        </div>
    </div>



    <div class="custom-form mr-1 ml-1">
        <div class="form-row mb-4 mt-3"><!--start 1-->
            <div class="form-check col-md-12" style="text-align: center;">
                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Current Address Details
                                        </span>
                </h5>
            </div>
        </div><!--end-->
        <div class="form-row"><!--start 1-->
            <div class="form-group col-md-3">
                <label for="inputFirstName" class="bold">Type Of Residence </label>
                {{--                    <input type="text" class="form-control " --}}
                {{--                        value="{{ $worker_details->address->currentResidence->residence_name ?? 'NA' }}" id="esic_no" --}}
                {{--                        name="esic_no" readonly> --}}
                <span
                        class="form-control-plaintext">{{ $worker_details->address->currentResidence->residence_name ?? 'NA' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputLastName" class="bold">Type Of House</label>
                {{--                    <input type="text" class="form-control " --}}
                {{--                        value="{{ $worker_details->address->currentHouse->house_type ?? 'NA' }}" id="esic_no" --}}
                {{--                        name="esic_no" readonly> --}}
                <span
                        class="form-control-plaintext">{{ $worker_details->address->currentHouse->house_type ?? 'NA' }}</span>

            </div>
            <div class="form-group col-md-3">
                <label for="inputPassword4" class="bold">House No./Building No. </label>
                {{--                    <input type="text" class="form-control " --}}
                {{--                        value="{{ $worker_details->address->c_house_no ?? 'NA' }}" id="currentBuilding" --}}
                {{--                        name="c_house_no" placeholder="" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->address->c_house_no ?? 'NA' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="gender" class="bold">Area/Village </label>
                {{--                    <input type="text" class="form-control  uc-text-smooth" --}}
                {{--                        value="{{ $worker_details->address->c_area ?? 'NA' }}" id="currentArea" name="c_area" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->address->c_area ?? 'NA' }}</span>
            </div>
        </div><!--end-->
        <div class="form-row"><!--start 1-->

            <div class="form-group col-md-3">
                <label for="inputMstatus" class="bold">City</label>
                {{--                    <input type="text" class="form-control  uc-text-smooth" --}}
                {{--                        value="{{ $worker_details->address->c_city ?? 'NA' }}" name="c_city" id="currentCity" disabled> --}}
                <span class="form-control-plaintext">{{ $worker_details->address->c_city ?? 'NA' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputAdhaar" class="bold">Road</label>
                {{--                    <input type="text" class="form-control  uc-text-smooth" --}}
                {{--                        value="{{ $worker_details->address->c_road ?? 'NA' }}" id="currentRoad" name="c_road" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->address->c_road ?? 'NA' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputDob" class="bold">State </label>
                {{--                    <input type="text" class="form-control  uc-text-smooth" --}}
                {{--                        value="{{ $worker_details->address->c_state ?? 'NA' }}" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->address->c_state ?? 'NA' }}</span>

            </div>
            <div class="form-group col-md-3">
                <label for="inputAge" class="bold">District</label>
                {{--                    <input type="text" class="form-control  uc-text-smooth" --}}
                {{--                        value="{{ $worker_details->address->currentDistrict->district_name ?? 'NA' }}" readonly> --}}
                <span
                        class="form-control-plaintext">{{ $worker_details->address->currentDistrict->district_name ?? 'NA' }}</span>

            </div>
        </div><!--end-->
        <div class="form-row"><!--start 1-->
            <div class="form-group col-md-3">
                <label for="inputAge" class="bold">Revenue Circle </label>
                {{--                    <input type="text" class="form-control  uc-text-smooth" --}}
                {{--                        value="{{ $worker_details->address->c_circle ?? 'NA' }}" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->address->c_circle ?? 'NA' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputCategory" class="bold">Post Office </label>
                {{--                    <input type="text" class="form-control" --}}
                {{--                        value="{{ $worker_details->address->c_post_office ?? 'NA' }}" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->address->c_post_office ?? 'NA' }}</span>

            </div>
            <div class="form-group col-md-3">
                <label for="inputPhone" class="bold">Pin Code</label>
                {{--                    <input type="text" class="form-control " id="currentPin" --}}
                {{--                        value="{{ $worker_details->address->c_pin ?? 'NA' }}" name="c_pin" placeholder="" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->address->c_pin ?? 'NA' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputPhone" class="bold">Landmark</label>
                {{--                    <input type="text" class="form-control " name="landmark" --}}
                {{--                        value="{{ $worker_details->address->landmark ?? __('N/A') }}" id="landmark" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->address->landmark ?? __('N/A') }}</span>
            </div>
        </div><!--end-->
    </div>



    <div class="custom-form mr-1 ml-1">
        <div class="form-row mt-2"><!--start 1-->
            <div class="form-check col-md-12" style="text-align: center;">
                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Bank Details
                                        </span>
                </h5>
            </div>
        </div><!--end-->
        <div class="form-row mt-4"><!--start 1-->
            <div class="form-group col-md-3">
                <label for="inputAge" class="bold">Bank Name </label>
                {{--                    <input type="text" class="form-control  uc-text-smooth" --}}
                {{--                        value="{{ $worker_details->address->c_circle ?? 'NA' }}" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->bankDetail->bank_name ?? 'NA' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputCategory" class="bold">Bank Name</label>
                {{--                    <input type="text" class="form-control" --}}
                {{--                        value="{{ $worker_details->address->c_post_office ?? 'NA' }}" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->bankDetail->branch_name ?? 'NA' }}</span>

            </div>
            <div class="form-group col-md-3">
                <label for="inputPhone" class="bold">Bank Address</label>
                {{--                    <input type="text" class="form-control " id="currentPin" --}}
                {{--                        value="{{ $worker_details->address->c_pin ?? 'NA' }}" name="c_pin" placeholder="" readonly> --}}
                <span class="form-control-plaintext" style="white-space: normal; word-wrap: break-word;">{{ $worker_details->bankDetail->bank_address ?? 'NA' }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputPhone" class="bold">Account Number</label>
                {{--                    <input type="text" class="form-control " name="landmark" --}}
                {{--                        value="{{ $worker_details->address->landmark ?? __('N/A') }}" id="landmark" readonly> --}}
                <span class="form-control-plaintext">{{ $worker_details->bankDetail->account_no ?? 'NA' }}</span>
            </div>

        </div><!--end-->
    </div>



    <div class="custom-form mr-1 ml-1">
        <div class="form-row  mt-2"><!--start 1-->
            <div class="form-check col-md-12" style="text-align: center;">
                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Family Details
                                        </span>
                </h5>
            </div>
        </div><!--end-->
        <div class="row">
            <div class="col">
                <div class="table-container">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col" class="bold">Serial No</th>
                            <th scope="col" class="bold">First Name</th>
                            <th scope="col" class="bold">Last Name</th>
                            <th scope="col" class="bold">DOB</th>
                            {{--                                            <th scope="col" class="bold">Age</th> --}}
                            <th scope="col" class="bold">Guardian Name</th>
                            <th scope="col" class="bold">Relation</th>

                            <th scope="col" class="bold">Nominee(Y/N)</th>
                            <th scope="col" class="bold">Nominee Share</th>
                            <th scope="col" class="bold">Already Registered With Other State BOCW Board?</th>
                            <th scope="col" class="bold">Name Of The State(BOCW Board)</th>
                            <th scope="col" class="bold">BOCW ID</th>
                            <!-- Repeat headers as needed -->
                        </tr>
                        <tr>
                            @foreach ($worker_details->familyDetails as $familyMember)
                                <td>{{ $loop->iteration }}</td>

                                <td class="fixed-width">{{ $familyMember->first_name }}
                                </td>
                                <td class="fixed-width">{{ $familyMember->last_name }}</td>
                                <td class="fixed-width">
                                    {{ \Carbon\Carbon::parse($familyMember->dob)->format('d-m-Y') }}
                                </td>
                                <td class="fixed-width">
                                    {{ $familyMember->guardian_name ?? __('N/A') }}
                                </td>
                                <td class="fixed">
                                    @if ($familyMember->relation === 17)
                                        {{ $familyMember->relation_others ?? 'NA' }}
                                    @else
                                        {{ $familyMember->relationDetails->relation_name }}
                                    @endif
                                </td>

                                <td class="fixed-width">
                                    {{ $familyMember->nominee == 1 ? 'Yes' : 'No' }}
                                </td>
                                <td class="fixed-width">
                                    {{ $familyMember->nominee_percentage ?? __('N/A') }}
                                </td>

                                <td class="fixed-width">
                                    {{ $familyMember->already_registered == 1 ? 'Yes' : 'No' }}
                                </td>
                                <td class="fixed-width">
                                    {{ $familyMember->stateDetails->state_name ?? __('N/A') }}
                                </td>
                                <td class="fixed-width">
                                    {{ $familyMember->bocwwb_id ?? __('N/A') }}</td>
                        </tr>
                        @endforeach
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @if ($worker_details->already_registered != 1)
        <div class="custom-form mr-1 ml-1">
            <div class="form-row  mt-2"><!--start 1-->
                <div class="form-check col-md-12" style="text-align: center;">
                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            90 Days Certificate Details
                                        </span>
                    </h5>
                </div>
            </div><!--end-->
            <div class="row">
                <div class="col">
                    <div class="table-container">
                        <table class="table">
                            <thead>
                            <tr>
                                {{--                                        <th scope="col">Serial No</th> --}}
                                <th scope="col" class="bold">Type of Employer</th>
                                <th scope="col" class="bold">Type of Issuer</th>
                                <th scope="col" class="bold">Name of Issuing Organization</th>
                                <th scope="col" class="bold">Issue Date</th>
                                <th scope="col" class="bold">Name of Issuing Person</th>
                                <th scope="col" class="bold">Contact No of Issuing Person</th>
                                <th scope="col" class="bold">Type Of Construction Work</th>
                                <th scope="col" class="bold">Employer Name</th>
                                {{--                                <th scope="col" class="bold">Employer Contact Name</th> --}}
                                <th scope="col" class="bold">Employer Contact Number</th>
                                <th scope="col" class="bold">Work Start Date</th>
                                <th scope="col" class="bold">Work End Date</th>
                                <th scope="col" class="bold">Actual No Of Working Days<span
                                            class="text-danger">*</span></th>

                                <th scope="col" class="bold">Profession</th>
                                <th scope="col" class="bold">90 Days Certificate</th>
                                <!-- Repeat headers as needed -->
                            </tr>
                            @foreach ($worker_details->certificates as $index => $certificate)
                                <tr>
                                    <td class="fixed-width">
                                        {{ $certificate->typeOfEmployer->employer_name ?: 'NA' }}</td>

                                    <td class="fixed-width">

                                        {{ $certificate->typeOfIssuer->issuer_name ?? __('N/A') }}</td>

                                    <td class="fixed-width">
                                        {{ $certificate->issuing_org }}</td>


                                    <td class="fixed-width">
                                        {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d-m-Y') }}</td>


                                    <td class="fixed-width">
                                        {{ $certificate->issuing_person }}</td>
                                    <td class="fixed-width">
                                        {{ $certificate->contact_issuing_person }}</td>

                                    <td class="fixed-width">
                                        {{ $certificate->typeOfWork->work_type_name ?: '' }}</td>
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
                                        {{ $certificate->date_count }}
                                    </td>
                                    <td class="fixed-width">
                                        @if ($certificate->professions->profession_code == 28)
                                            {{ $certificate->profession_others ?? $certificate->professions->profession_name }}
                                        @else
                                            {{ $certificate->professions->profession_name }}
                                    </td>
                                    @endif
                                    <td class="fixed-width">
                                        <a href="{{ route('certificate-proof-new', ['worker_id' => encrypt($worker_details->worker_id)]) }}"
                                           class="href" target="_blank">
                                            <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View
                                            Certificate
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
                                <th scope="col" class="bold">Schemes</th>
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
    <div class="custom-form">
        <div class="form-row  mt-2"><!--start 1-->
            <div class="form-check col-md-12" style="text-align: center;">
                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Working Record Book Details
                                        </span>
                </h5>
            </div>
        </div><!--end-->

        <div class="row">
            <div class="col">
                <div class="table-container">
                    <table class="table">
                        <thead>
                        <tr>
                            {{-- <th scope="col">Serial No</th> --}}

                            <th>Type Of Construction Work <span class="text-danger">*</span></th>
                            <th>Start Date <span class="text-danger">*</span></th>
                            <th>End Date <span class="text-danger">*</span></th>
                            <th>Working Days <span class="text-danger">*</span></th>
                            <th>Employer Name <span class="text-danger">*</span></th>
                            <th>Contact Number <span class="text-danger">*</span></th>
                            <th>Employer Type <span class="text-danger">*</span></th>
                            <th>Profession <span class="text-danger">*</span></th>
                            <th>Workbook <span class="text-danger">*</span></th>
                            <!-- Repeat headers as needed -->
                        </tr>
                        @foreach ($worker_details->workbooks as $workbook)
                            <tr>

                                <td class="fixed-width">
                                    {{ $workbook->typeOfWork->work_type_name }}</td>

                                <td class="fixed-width">
                                    {{ \Carbon\Carbon::parse($workbook->from_date)->format('d-m-Y') }}
                                </td>
                                <td class="fixed-width">
                                    {{ \Carbon\Carbon::parse($workbook->to_date)->format('d-m-Y') }}
                                </td>
                                <td class="fixed-width">
                                    {{$workbook->date_count}}
                                </td>
                                <td class="fixed-width">
                                    {{ $workbook->employer_name }}</td>
                                <td class="fixed-width">
                                    {{ $workbook->employer_contact_number }}</td>
                                <td class="fixed-width">
                                    {{ $workbook->typeOfEmployer->employer_name }}</td>
                                <td class="fixed-width">
                                    @if ($workbook->professions->profession_code == 28)
                                        {{ $workbook->profession_others ?? $workbook->professions->profession_name }}
                                    @else
                                        {{ $workbook->professions->profession_name }}
                                    @endif
                                </td>
                                <td class="fixed-width">
                                    <a href="{{ route('view-work-book', ['id' => $workbook->id]) }}"
                                       class="href" target="_blank">
                                        <i class="fa fa-external-link"
                                           aria-hidden="true"></i>&nbsp;View Workbook
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


    {{--                    <h5 style="color: #ffbf49;" class="mt-3"><i class="fa fa-file"  aria-hidden="true"></i>&nbsp;Uploaded Documents:</h5> --}}

    <div class="custom-form mr-1 ml-1">
        <div class="form-row  mt-2"><!--start 1-->
            <div class="form-check col-md-12" style="text-align: center;">
                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Uploaded Attachment
                                        </span>
                </h5>
            </div>
        </div><!--end-->
        <div class="table-responsive mt-2">
            <table class="table">
                <thead>
                <tr>
                    {{--                                        <th scope="col" class="bold">Sl.No</th> --}}
                    <th scope="col" class="bold">Type Of Documents</th>
                    <th scope="col" class="bold">Attachments</th>
                </tr>
                </thead>
                <tbody>

                @if ($worker_details->already_registered == 1)
                    <tr>

                        <td>Latest ID Card</td>
                        <td><a href="{{ route('office.dsc.download-id-card', encrypt($worker_details->worker_id)) }}" title="Download" target="_blank">
                                <i class="fa fa-file-pdf" aria-hidden="true"></i>
                            </a></td>

                    </tr>
                @endif
                </tbody>
            </table>

        </div>


    </div>
    <hr>
    <!--HRO-->
    @if (Auth::user()->role_id == 2 && ($worker_renewal_details->status == 'A' || $worker_renewal_details->status == 'B'))
        <div class="d-flex justify-content-center mt-4 mb-3">
            <a class="btn btn-primary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#approve-modal">
                <i class="fa fa-check"></i> Approve
            </a>

            {{--<a class="btn btn-danger btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"--}}
            {{--data-target="#reject-modal">--}}
            {{--<i class="fa fa-times"></i> Reject--}}
            {{--</a>--}}
            <a class="btn btn-success btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#forward-modal">
                <i class="fa fa-arrow-right"></i> Forward
            </a>
            <a class="btn btn-danger btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#revertback-modal">
                <i class="fa fa-undo"></i> Revert
            </a>
            <a class="btn btn-warning btn-sm text-white mx-1" href="{{ route('office.dashboard.index') }}">
                <i class="fa fa-backward"></i> Dashboard
            </a>
        </div>
    @endif

    <!--RO-->
    @if (Auth::user()->role_id == 3 && $worker_renewal_details->status == 'O' && $worker_renewal_details->da_forward != 1)
        <div class="d-flex justify-content-center mt-4 mb-3">
            <a class="btn btn-primary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#approve-modal">
                <i class="fa fa-check"></i> Approve
            </a>

            {{--<a class="btn btn-danger btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"--}}
            {{--data-target="#reject-modal">--}}
            {{--<i class="fa fa-times"></i> Reject--}}
            {{--</a>--}}
            <a class="btn btn-success btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#forward-modal">
                <i class="fa fa-arrow-right"></i> Forward
            </a>

            {{--@if ($worker_details->already_registered == 1)--}}
            {{--<a class="btn btn-warning btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"--}}
            {{--data-target="#reroute-modal-existing">--}}
            {{--<i class="fa fa-arrow-right"></i> Re-Route--}}
            {{--</a>--}}
            {{--@else--}}
            {{--<a class="btn btn-warning btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"--}}
            {{--data-target="#reroute-modal-new">--}}
            {{--<i class="fa fa-arrow-right"></i> Re-Route--}}
            {{--</a>--}}
            {{--@endif--}}

            <a class="btn btn-danger btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#revertback-modal">
                <i class="fa fa-undo"></i> Revert
            </a>
            <a class="btn btn-warning btn-sm text-white mx-1" href="{{ route('office.dashboard.index') }}">
                <i class="fa fa-backward"></i> Dashboard
            </a>
        </div>
        <!-- HRO-->
    @elseif (Auth::user()->role_id == 3 && $worker_renewal_details->status == 'O' && $worker_renewal_details->da_forward == 1)
        <div class="d-flex justify-content-center mt-4 mb-3">

            <a class="btn btn-primary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#approve-modal">
                <i class="fa fa-check"></i> Approve
            </a>
            {{--<a class="btn btn-danger btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"--}}
            {{--data-target="#reject-modal">--}}
            {{--<i class="fa fa-times"></i> Reject--}}
            {{--</a>--}}
            <a class="btn btn-success btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#forward-modal">
                <i class="fa fa-arrow-right"></i> Forward
            </a>

            <a class="btn btn-secondary btn-sm mx-1 text-white" href="javascript:void(0);" data-toggle="modal"
               data-target="#forward-modal-hro">
                <i class="fa fa-undo"></i> Send Back
            </a>

            <a class="btn btn-danger btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#revertback-modal">
                <i class="fa fa-undo"></i> Revert
            </a>
            <a class="btn btn-warning btn-sm text-white mx-1" href="{{ route('office.dashboard.index') }}">
                <i class="fa fa-backward"></i> Dashboard
            </a>
        </div>


        <!---Renewal Modal -->
    @elseif(Auth::user()->role_id == 3 && $worker_renewal_details->status == 'R')
        <div class="d-flex justify-content-center mt-4 mb-3">
            <a class="btn btn-primary btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#approve-modal">
                <i class="fa fa-check"></i> Approve
            </a>
            {{--<a class="btn btn-danger btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"--}}
            {{--data-target="#reject-modal">--}}
            {{--<i class="fa fa-times"></i> Reject--}}
            {{--</a>--}}
            <a class="btn btn-success btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#forward-modal">
                <i class="fa fa-arrow-right"></i> Forward
            </a>
            <a class="btn btn-danger btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#revertback-modal">
                <i class="fa fa-undo"></i> Revert
            </a>


            <a class="btn btn-warning btn-sm text-white mx-1" href="{{ route('office.dashboard.index') }}">
                <i class="fa fa-backward"></i> Dashboard
            </a>
        </div>
    @elseif (Auth::user()->role_id == 5 && $worker_renewal_details->status == 'M')
        <div class="d-flex justify-content-center mt-4 mb-3">

            <a class="btn btn-success btn-sm text-white mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#forward-modal_reroute">
                <i class="fa fa-arrow-right"></i> Forward
            </a>
            <a class="btn btn-warning btn-sm text-white mx-1" href="{{ route('office.dashboard.index') }}">
                <i class="fa fa-backward"></i> Dashboard
            </a>
        </div>

        <!--if pulled Back From RO-->

        <!--(Auth::user()->role_id == 3 && $worker_details_renew->status == 'O'-->
    @elseif(Auth::user()->role_id == 3 && $worker_renewal_details->status == 'O')
        <div class="d-flex justify-content-center mt-2 mb-3">
            <a class="btn btn-success btn-sm mx-1" href="javascript:void(0);" data-toggle="modal"
               data-target="#approve-modal">
                <i class="fa fa-check-circle"></i> Approve
            </a>
            {{--<a class="btn btn-danger btn-sm mx-1 text-white" href="javascript:void(0);" data-toggle="modal"--}}
            {{--data-target="#reject-modal">--}}
            {{--<i class="fa fa-times-circle"></i> Reject--}}
            {{--</a>--}}
            <a class="btn btn-warning btn-sm mx-1 text-white" href="{{ route('office.dashboard.index') }}">
                <i class="fa fa-times"></i> Dashboard
            </a>
        </div>
    @elseif(Auth::user()->role_id == 3 && $worker_renewal_details->status == 'C')
        <div class="d-flex justify-content-center mt-2 mb-3">
            <a class="btn btn-success btn-sm mx-1 text-white" href="javascript:void(0);" data-toggle="modal"
               data-target="#pullback-modal">
                <i class="fa fa-cloud-download-alt"></i> Pull Back Application
            </a>
            <a class="btn btn-danger btn-sm mx-1 text-white" href="{{ route('office.dashboard.index') }}">
                <i class="fa fa-times"></i> Dashboard
            </a>
        </div>
    @elseif(
        (Auth::user()->role_id == 2 && $worker_renewal_details->status == 'C') ||
            (Auth::user()->role_id == 2 && $worker_renewal_details->status == 'O'))
        <div class="d-flex justify-content-center mt-2 mb-3">
            <a class="btn btn-success btn-sm mx-1 text-white" href="javascript:void(0);" data-toggle="modal"
               data-target="#pullback-modal">
                <i class="fa fa-cloud-download-alt"></i> Pull Back Application
            </a>
            <a class="btn btn-danger btn-sm mx-1 text-white" href="{{ route('office.dashboard.index') }}">
                <i class="fa fa-times"></i> Dashboard
            </a>
        </div>
    @elseif(Auth::user()->role_id == 4 && $worker_renewal_details->status == 'C')
        <div class="d-flex justify-content-center mt-2 mb-3">
            <a class="btn btn-success btn-sm mx-1 text-white" href="javascript:void(0);" data-toggle="modal"
               data-target="#forward-modal-ro">
                <i class="fa fa-undo"></i> Send Back
            </a>
            <a class="btn btn-danger btn-sm mx-1 text-white" href="{{ route('office.dashboard.index') }}">
                <i class="fa fa-home"></i> Dashboard
            </a>
        </div>
    @endif
    <div class="modal fade" id="forward-modal" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0 bg-primary">
                    <h5 class="modal-title text-white">Send Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                            data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">Forward the application to respective officers</p>

                    @if (Auth::user()->role_id == 2)
                        <form action="{{ route('forward_application_to_ro_da') }}" method="POST">
                            @elseif(Auth::user()->role_id == 3)
                                <form action="{{ route('forward_application') }}" method="POST">
                                    @else
                                    @endif

                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="application_id" value="{{ $worker_renewal_details->worker_id }}">
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
                <div class="modal-header text-center d-block p-2 border-bottom-0 bg-primary">
                    <h5 class="modal-title text-white">Approve Renewal Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                            data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">



                    <form action="{{ route('approve_renew-application') }}" method="POST">

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




    <div class="modal fade" id="forward-modal-ro" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title text-dark">Send Back Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                            data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"></p>
                    <form action="{{ route('send-application-back-re') }}" method="POST">
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
                    <h5 class="modal-title text-white">Send Back Application Renewal</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                            data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"></p>
                    <form action="{{ route('send-application-back-hro-renewal') }}" method="POST">
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
                    <h5 class="modal-title text-white">Forward Application</h5>
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
                    <h5 class="modal-title text-white">Forward Application</h5>
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
                <div class="modal-header text-center d-block p-2 border-bottom-0 bg-primary">
                    <h5 class="modal-title text-white">Revert Back Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                            data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('application-revert-renewal') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="control-label bold col-md-8" for="reasons">Select Reasons for Revert
                                Application:</label>
                            @if ($worker_details->already_registered == 1)
                                @foreach ($rejectReasonsRenew as $reason)
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
                    <h5 class="modal-title text-white">Re-route Application</h5>
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
                                <select id="districtcode" name="district_code" class="form-control">
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
                    <h5 class="modal-title text-white">Re-route Application</h5>
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

    <!--forward from state office -->
    <div class="modal fade" id="forward-modal_reroute" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title text-white">Forward Application</h5>
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
    <!--forward to ro-->
    <div class="modal fade" id="pullback-modal" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center d-block p-2 border-bottom-0">
                    <h5 class="modal-title text-dark">Pullback Application</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                            data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"></p>
                    <form action="{{ route('application-pullback-renewal') }}" method="POST">
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
                    <h5 class="modal-title text-white">Reject Application</h5>
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

@endsection
<script src="{{ URL::asset('assets/template/js/getVaultOffice.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/jquery-3.7.0.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
<script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>

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
    document.addEventListener('DOMContentLoaded', function() {
        const approveButton = document.getElementById('approve-btn');
        console.log(approveButton)

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

            $('#approve-modal-ex').modal('show');
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
<script>
    function updateClock() {
        const now = new Date();
        const date = now.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        const time = now.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('digitalClock').textContent = `${date}  ${time}`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

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
