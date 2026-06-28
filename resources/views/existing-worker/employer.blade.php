@extends('layouts.user-app')

@section('title', 'Employer Details')

@section('style')
    <style>
        .table th {
            font-size: 12px;
        }

        .table-container {
            overflow-x: auto;
        }

        .fixed-width {
            min-width: 200px;
            /* Adjust the width as needed */
        }

        .fixed {
            min-width: 100px;
            /* Adjust the width as needed */
        }

        .table thead tr {
            border-top: 2px solid #ffc0b4;
        }

        .table thead th {
            border-bottom: 2px solid black;
        }

        body {
            background-color: #f1f1f1;
        }

        * {

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
        .bold{
            font-weight: 600;
            font-family:"Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 14px;
            /*color: #186cb8;*/
            color: #219fa4;
            /*color: #7ea1a2;*/
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
    </style>
@endsection
@section('content')
    @include('components.multistep-existing')
    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light p-3" >
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            <h6 class="custom-heading">Registration - Construction Worker/পঞ্জীয়ন - নিৰ্মাণ শ্ৰমিক</h6>
                            <h6 class="custom-bold">
                                <i class="custom-icon fas fa-file-alt pr-2"></i>Application No/আবেদন নং - {{ $application_no }}
                            </h6>
                        </div>
                        {{--                            <div class="custom-right-content">--}}
                        {{--                                <h6 class="custom-heading">--}}
                        {{--                                    <i class="custom-icon fas fa-clock"></i> Session Uptime/অধিবেশন আপটাইম ---}}
                        {{--                                </h6>--}}
                        {{--                            </div>--}}
                    </div>
                </div>
            </nav>
            <div class="card mt-1">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #248f8f;">
                <span>
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Employer | Certificate Details
                </span>
                            </div>
                            <p class="text-danger ml-2"> <i class="fa fa-bullhorn" aria-hidden="true"></i>&nbsp; (*) Marked are mandatory fields / সকলোবোৰ বাধ্যতামূলক ক্ষেত্ৰ </p>
                            <form action="{{ route('save-employer-data') }}" class="form-group ml-2 mr-2" enctype="multipart/form-data"
                                  method="post" id="employer">
                                @csrf
                                {{-- <input type="hidden" name="worker_id" value="{{$formdata->worker_id}}"> --}}
                                <div class="form-group ml-4">
                                    <label class="bold" style="font-size: 16px;"><span class ="text-danger">Q.1A.</span>&nbsp;Do you have any Current employer?</label><span style="color:red;">*</span>
                                    <div class="ml-5">
                                        <input type="radio" id="employerYes" name="current_employer" value="1" {{ old('current_employer') == '1' ? 'checked' : '' }}>
                                        <label for="employerYes" class="pr-2">Yes</label>
                                        <input type="radio" id="employerNo" class="pl-5" name="current_employer" value="0" {{ old('current_employer') == '0' ? 'checked' : '' }}>
                                        <label for="employerNo">No</label>
                                    </div>
                                    <span class="text-danger success" id="current_employer_error" style="font-size: 14px;"></span>
                                </div>

                                <div id="employerDetails" style="display:none;">
                                    <div class="form-row mt-4"><!--start 1-->
                                        <div class="form-group col-md-4">
                                            <label for="inputContractor" class="bold">Board</label><span style="color:red;">*</span>
                                            <select name="board" class="form-control">
                                                <option value="">Select employer</option>
                                                @foreach ($type_of_employers as $employers)
                                                    <option value="{{ $employers->employer_code }}">{{ $employers->employer_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="error" id="boardError"></span>
                                            <span class="text-danger success" id="board_error"></span>

                                        </div>
                                    </div><!--end-->
                                    <div class="form-row mt-4"><!--start 1-->
                                        <div class="form-group col-md-4">
                                            <label for="inputEmpName" class="bold">Employer Name/নিয়োগকৰ্তাৰ নাম</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control custom-bottom-border"
                                                   id="emp_name" value="{{ old('employer_name') }}" name="employer_name"
                                                   placeholder="Enter employer name">
                                            <span class="error" id="empNameError"></span>
                                            <span class="text-danger success" id="employer_name_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputWork" class="bold">Type of Work/কামৰ প্ৰকাৰ</label><span class="text-danger">*</span>
                                            <select id="inputWork" class="form-control custom-bottom-border error-message"
                                                    name="type_of_work">
                                                <option value="">Select Type of work</option>
                                                @foreach ($worktype as $work)
                                                    <option value="{{ $work->work_type_code }}">{{ $work->work_type_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger success" id="type_of_work_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="workplace" class="bold">Workplace/কৰ্মক্ষেত্ৰ</label><span
                                                class="text-danger">*</span>
                                            <input type="text" id="workplace" name="workplace"
                                                   class="form-control custom-bottom-border"
                                                   value="{{ old('workplace') }}" placeholder="Enter workplace">
                                            <span class="error" id="workError"></span>
                                            <span class="text-danger success" id="workplace_error"></span>
                                        </div>

                                    </div><!--end-->
                                    <div class="form-row mt-4"><!--start 1-->
                                        <div class="form-group col-md-4">
                                            <label for="inputMobile" class="bold">Employers Contact No/নিয়োগকৰ্তাৰ যোগাযোগ
                                                নং</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control custom-bottom-border" id="phone_no"
                                                   name="mobile_no" placeholder="Enter Valid Contact no" value="{{ old('mobile_no') }}"
                                                   maxlength="10">
                                            <span class="error text-danger" id="phone_noError"></span>
                                            <span class="text-danger success" id="mobile_no_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="mStatus" class="bold">District/জিলা</label><span class="text-danger">*</span>
                                            <select id="inputState" class="form-control custom-bottom-border dist" id="district"
                                                    data-id="d" name="district">
                                                <option value="">Select District</option>
                                                @foreach ($districts as $dist)
                                                    <option value="{{ $dist->district_code }}"
                                                            @if (old('district') == $dist->district_code) selected @endif>{{ $dist->district_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger success" id="district_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputDob" class="bold">Sub-District/মহকুমা</label><span
                                                style="color:red;">*</span>
                                            <select class="form-control custom-bottom-border" data-id="d" name="subdistrict"
                                                    id="subdist">
                                                <option value="">Select Sub-district</option>
                                            </select>
                                            <span class="text-danger success" id="subdistrict_error"></span>
                                        </div>

                                    </div><!--end-->
                                    <div class="form-row mt-4"><!--start 1-->
                                        <div class="form-group col-md-4">
                                            <label for="inputAge" class="bold">City/চহৰ</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control custom-bottom-border"
                                                   id="city" name="city" value="{{ old('city') }}"
                                                   placeholder="Enter town/city">
                                            <span class="error" id="cityError"></span>
                                            <span class="text-danger success" id="city_error"></span>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputCategory" class="bold">Pin code/পিন ক'ড </label><span
                                                style="color:red;">*</span>
                                            <input type="text" class="form-control custom-bottom-border" name="pin_code"
                                                   value="{{ old('pin_code') }}" placeholder="Enter pin code" maxlength="6"
                                                   id="pincode">
                                            <span class="error" id="pinError"></span>
                                            <span class="text-danger success" id="pin_code_error"></span>
                                        </div>
                                        <div class="form-group col-md-4 input-container" style="">

                                            <label for="inputPhone" class="bold" >Date of Joining/যোগদানৰ
                                                তাৰিখ</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control custom-bottom-border"
                                                   data-provide="datepicker" placeholder="DD-MM-YYYY " value="{{ old('doj') }}"
                                                   id="doj" name="doj">
                                            <span class="text-danger success" id="doj_error"></span>
                                        </div>

                                    </div><!--end-->
                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-4">
                                            <label for="inputPF" class="bold">Nature of work/কামৰ প্ৰকৃতি/</label><span class="text-danger">*</span>
                                            <select id="" class="form-control custom-bottom-border"
                                                    name="nature_of_work">
                                                <option value="">Select Nature of work</option>
                                                @foreach ($worknature as $now)
                                                    <option value="{{ $now->nature_of_work_code }}">{{ $now->nature_of_work }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger success" id="nature_of_work_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPhone" class="bold">MGNREGA Registration No/এম জি এনৰেগা পঞ্জীয়ন
                                                নং
                                            </label><span class="text-danger">*</span>
                                            <input type="text" class="form-control custom-bottom-border"
                                                   id="mgnrega" value="{{ old('mgnrega_no') }}" name="mgnrega_no"
                                                   placeholder="Enter mgnrega no">
                                            <span class="error" id="mgnregaError"></span>
                                            <span class="text-danger success" id="mgnrega_no_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="container-fluid text-center mt-4">
                                    <div class="card-header" style="border-top: 2px solid #0f3a47;">
                                        <h5 style="color: #076f6b;">90 Days Working Certificate/৯০ দিনৰ কামৰ প্ৰমাণ পত্ৰ</h5>
                                        <h5><span id="total_days_span" class="text-warning font-weight-normal"></span></h5>
                                    </div>
                                    <div class="table-container">
                                        <table class="table" id="user_table">
                                            <thead>
                                            <tr>
                                                {{-- <th scope="col">Serial No</th> --}}
                                                <th scope="col" class="bold">Type of Issuer/ইছ্যুকাৰীৰ প্ৰকাৰ<span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Name of Issuing Organization/ইছ্যু কৰা
                                                    সংস্থাৰ নাম<span class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Issue Number/ইছ্যু নম্বৰ<span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Issue Date/ইছ্যুৰ তাৰিখ<span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Name of Issuing Person/ইছ্যু কৰা ব্যক্তিৰ নাম <span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Contact No of Issuing Person/ইছ্যু কৰা ব্যক্তিৰ যোগাযোগ নং <span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Is Issuer and Employee Same
                                                    (Yes/No)?/ইছ্যুকাৰী আৰু কৰ্মচাৰী একে নেকি(হয়/নহয়)?<span class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Employer Name/নিয়োগকৰ্তাৰ নাম<span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Employer Contact Name/নিয়োগকৰ্তাৰ যোগাযোগৰ নাম<span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Employer Contact Number/নিয়োগকৰ্তাৰ যোগাযোগ নম্বৰ<span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">From Date / তাৰিখৰ পৰা<span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">To Date / তাৰিখলৈকে<span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">No of Days / দিনৰ সংখ্যা<span
                                                        class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Type of Employer / নিয়োগকৰ্তাৰ
                                                    প্ৰকাৰ<span class="text-danger">*</span></th>
                                                <th scope="col" class="bold">Action</th>
                                                <!-- Repeat headers as needed -->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                {{-- <input type="hidden" name="worker_id[]" value="{{$formdata->worker_id}}" class="form-control"/> --}}
                                                {{-- <td class="bold font-weight-normal">1</td> --}}
                                                <td class="dropdown fixed-width">
                                                    <select name="type_of_issuer[]" class="form-control">
                                                        <option value="">Select Issuer</option>
                                                        @foreach ($type_of_issuer as $issuer)
                                                            <option value="{{ $issuer->issuer_code }}">
                                                                {{ $issuer->issuer_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger success" id="type_of_issuer.0_error"></span>
                                                </td>
                                                <td>
                                                    <input type="text" name="issuing_org[]"
                                                           class="fixed-width form-control" data-id="1" id="issuing_org_1">
                                                    <span class="text-danger success issuing_org" id="issuing_org.0_error" style="font-size: 14px;"></span>
                                                </td>
                                                <td class="fixed-width"><input type="text" name="issue_no[]"
                                                                               value="{{ old('issue_no[]') }}" class="form-control issueNo" />
                                                    <span class="text-danger success" id="issue_no.0_error" style="font-size: 14px;"></span>
                                                </td>
                                                <td class="fixed-width">
                                                    <input type="date" name="issue_date[]" value=""
                                                           class="form-control issue-date" >
                                                    <span class="text-danger success" id="issue_date.0_error" style="font-size: 14px;"></span>
                                                </td>
                                                <td>
                                                    <input type="text" name="issuing_person[]"
                                                           class="fixed-width form-control issuing_person" data-id="1" id="issuing_person_1" />
                                                    <span class="text-danger success" id="issuing_person.0_error" style="font-size: 14px;"></span>
                                                </td>
                                                <td>
                                                    <input type="text" onkeypress="return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));" name="contact_issuing_person[]"
                                                           class="fixed-width form-control contact_issuing_person" data-id="1" id="contact_issuing_person_1" maxlength="10"/>
                                                    <span class="text-danger success"
                                                          id="contact_issuing_person.0_error" style="font-size: 14px;"></span>
                                                </td>
                                                <td class="fixed-width">
                                                    <select name="is_same[]" data-id="1" id="issame_1" onchange="toogleIssameInput(1)"
                                                            class="form-control issame">
                                                        <option value="">Select</option>
                                                        <option value="1">Yes/হয়</option>
                                                        <option value="0">No/নহয়</option>
                                                    </select>
                                                    <span class="text-danger success" id="is_same.0_error" style="font-size: 14px;"></span>
                                                </td>
                                                <td>
                                                    <input readonly type="text" name="employer_name_certi[]"
                                                           class="fixed-width form-control employer_name_certi" data-id="1" id="employer_name_certi_1"/>
                                                    <span class="text-danger success"
                                                          id="employer_name_certi.0_error" style="font-size: 14px;"></span>
                                                </td>
                                                <td>
                                                    <input readonly type="text" name="employer_contact_name[]"
                                                           class="fixed-width form-control employer_contact_name" data-id="1" id="employer_contact_name_1"/>
                                                    <span class="text-danger success"
                                                          id="employer_contact_name.0_error" style="font-size: 14px;"></span>
                                                </td>
                                                <td>
                                                    <input readonly type="text" onkeypress="return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));" name="employer_contact_number[]"
                                                           class="fixed-width form-control employer_contact_number" data-id="1" id="employer_contact_number_1" maxlength="10" inputmode="numeric" pattern="\d*"/>
                                                    <span class="text-danger success"
                                                          id="employer_contact_number.0_error" style="font-size: 14px;"></span>
                                                </td>

                                                <td class="fixed-width"><input type="date" name="from_date[]" data-id="1"
                                                                               value="{{ old('from_date[]') }}" id="from_date_1"
                                                                               class="form-control fixed-width from-date" />
                                                    <span class="text-danger success" id="from_date.0_error" style="font-size: 14px;"></span>
                                                </td>

                                                <td class="fixed-width"><input type="date" name="to_date[]" data-id="1"
                                                                               value="{{ old('to_date[]') }}" id=""
                                                                               class="form-control fixed-width to-date" />
                                                    <span class="text-danger success" id="to_date.0_error" style="font-size: 14px;"></span>
                                                </td>

                                                <td class="fixed"><input type="text" id="dateCount"
                                                                         class="form-control date_count" />
                                                </td>
                                                <td class="fixed-width"><select name="type_of_employer[]"
                                                                                class="form-control fixed-width">
                                                        <option value="">Select employer</option>
                                                        @foreach ($type_of_employers as $employers)
                                                            <option value="{{ $employers->employer_code }}">
                                                                {{ $employers->employer_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger success"
                                                          id="type_of_employer.0_error" style="font-size: 14px;"></span>
                                                </td>
                                                <td>
                                                    <button type="button" name="remove" id=""
                                                            class="btn btn-sm btn-danger remove"><i class="fa fa-trash"
                                                                                                    aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Additional rows -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="button" name="add" id="add" class="btn btn-sm btn-info mt-3"><i
                                        class="fa fa-plus-circle"></i>&nbsp;Add New Row</button>
                                <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                    <div class="ml-auto d-inline-block align-self-center mr-2">
                                        <a type="submit" href="{{route('submit-bank-details')}}"
                                           class="btn btn-sm btn-warning"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;
                                            Previous</a>
                                        <button type="submit"
                                                class="btn btn-sm btn-primary"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                            Save Employer & Certificate</button>
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
    {{--    <script>--}}
    {{--        $(document).ready(function() {--}}
    {{--            const currentDate = '<?php echo date('Y-m-d'); ?>';--}}
    {{--            let count = 1;--}}
    {{--            let dynamicRowsData = [];--}}
    {{--            function dynamic_field(number, data = null)--}}
    {{--            {--}}
    {{--                let html = `<tr>--}}
    {{--                <td class="dropdown">--}}
    {{--                    <select name="type_of_issuer[` + count + `]" class="form-control fixed-width">--}}
    {{--                        <option value="">Select Issuer</option>`;--}}
    {{--                @foreach ($type_of_issuer as $issuer)--}}
    {{--                    html += `<option value="{{ $issuer->issuer_code }}">{{ $issuer->issuer_name }}</option>`;--}}
    {{--                @endforeach--}}
    {{--                    html += `</select><span class="text-danger success"  id="type_of_issuer.`+ count +`_error"></span>--}}
    {{--                </td>`;--}}

    {{--                html += '<td><input type="text" name="issuing_org[' + count + ']" class="form-control fixed-width issuing_org" id="issuing_org_' + number +'"/>' +--}}
    {{--                    '<span class="text-danger success"  id="issuing_org.' + count + '_error"></span></td>';--}}

    {{--                html += '<td><input type="text" name="issue_no[' + count + ']" class="form-control fixed-width"/>'+--}}
    {{--                    '<span class="text-danger success"  id="issue_no.' + count + '_error"></span></td>';--}}

    {{--                html += '<td><input type="date" name="issue_date[' + count + ']" id="issue_date" data-id="1" class="form-control issue-date"  max="' + currentDate + '"  />'+--}}
    {{--                    '<span class="text-danger success"  id="issue_date.' + count + '_error"></span></td>';--}}

    {{--                html += '<td><input type="text" name="issuing_person[' + count + ']" class="form-control fixed-width issuing_person" id="issuing_person_' + number +'"/>'+--}}
    {{--                    '<span class="text-danger success"  id="issuing_person.' + count + '_error"></span></td>';--}}

    {{--                html += '<td><input type="text" name="contact_issuing_person[' + count + ']" class="form-control fixed-width contact_issuing_person" maxlength="10" id="contact_issuing_person_' + number +'">'+--}}
    {{--                    '<span class="text-danger success"  id="contact_issuing_person.' + count + '_error"></span></td>';--}}

    {{--                html += '<td><select id="issame_' + number + '" name="is_same[' + count + ']" class="form-control issame" onchange="toogleIssameInput(' + number + ')">';--}}
    {{--                html += '<option value="">Select</option>';--}}
    {{--                html += '<option value="1">Yes</option>';--}}
    {{--                html += '<option value="0">No</option>';--}}
    {{--                html += '</select><span class="text-danger success"  id="is_same.' + count + '_error"></span></td>';--}}

    {{--                html += '<td><input type="text" id="employer_name_certi_'  + number + '" name="employer_name_certi[' + count + ']" class="form-control employer_name_certi fixed-width"> ' +--}}
    {{--                    '<span class="text-danger success"  id="employer_name_certi.' + count + '_error" style="font-size: 14px;"></span></td>';--}}

    {{--                html += '<td><input type="text" id="employer_contact_name_'  + number + '" name="employer_contact_name[' + count + ']" class="form-control employer_contact_name fixed-width">'+--}}
    {{--                    '<span class="text-danger success"  id="employer_contact_name.' + count + '_error"></span></td>';--}}

    {{--                html += '<td><input type="text" id="employer_contact_number_'  + number + '" name="employer_contact_number[' + count + ']" class="form-control employer_contact_number fixed-width" maxlength="10" >' +--}}
    {{--                    '<span class="text-danger success"  id="employer_contact_number.' + count + '_error"></span></td>';--}}

    {{--                html+= '<td><input type="date" name="from_date[' + count + ']" id="from_date_' + number + '" class="form-control from-date"  max="' + currentDate + '"  />' +--}}
    {{--                    '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';--}}

    {{--                html +='<td><input type="date" name="to_date[' + count + ']" id="to_date_' + number + '" data-id="1" class="form-control to-date to_date"  max="' + currentDate + '"  />' +--}}
    {{--                    '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';--}}

    {{--                html += '<td><input type="text"  id="dateCount" class="form-control date_count" /></td>';--}}

    {{--                html+=`<td class="dropdown">--}}
    {{--                    <select name="type_of_employer[` + count + `]" class="form-control fixed-width">--}}
    {{--                        <option value="">Select Employer</option>`;--}}

    {{--                @foreach ($type_of_employers as $emp)--}}
    {{--                    html += `<option value="{{ $emp->employer_code }}">{{ $emp->employer_name }}</option>`;--}}
    {{--                @endforeach--}}
    {{--                    html += '</select><span class="text-danger success"  id="type_of_employerr.' + count + '_error"></span></td>';--}}

    {{--                html += '<td><button type="button" name="remove" id="" class="btn btn-sm btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';--}}
    {{--                $('tbody').append(html);--}}
    {{--                count++;--}}
    {{--            }--}}

    {{--            // Event listener for form submission--}}
    {{--            $('#employer').submit(function(event) {--}}
    {{--                event.preventDefault();--}}
    {{--                $('.success').html('');--}}
    {{--                $('tbody tr').each(function(index, element) {--}}
    {{--                    let rowData = {--}}
    {{--                        typeOfIssuer: $(element).find('input[name="type_of_issuer[]"]').val(),--}}
    {{--                        issuerOrg: $(element).find('input[name="issuing_org[]"]').val(),--}}
    {{--                        issueNo: $(element).find('input[name="issue_no[]"]').val(),--}}
    {{--                        issueDate: $(element).find('input[name="issue_date[]"]').val(),--}}
    {{--                        issuingPerson: $(element).find('input[name="issuing_person[]"]').val(),--}}
    {{--                        contactIssuingPerson: $(element).find(--}}
    {{--                            'input[name="contact_issuing_person[]"]').val(),--}}
    {{--                        isSame: $(element).find('input[name="is_same[]"]').val(),--}}
    {{--                        employerNameCerti: $(element).find(--}}
    {{--                            'input[name="employer_name_certi[]"]').val(),--}}
    {{--                        employerContactName: $(element).find(--}}
    {{--                            'input[name="employer_contact_name[]"]').val(),--}}
    {{--                        employerContactNumber: $(element).find(--}}
    {{--                            'input[name="employer_contact_number[]"]').val(),--}}
    {{--                        from_date: $(element).find('input[name="from_date[]"]').val(),--}}
    {{--                        to_date: $(element).find('input[name="to_date[]"]').val(),--}}
    {{--                        typeOfEmployer: $(element).find('input[name="type_of_employer[]"]')--}}
    {{--                            .val(),--}}
    {{--                    };--}}
    {{--                    dynamicRowsData.push(rowData);--}}
    {{--                });--}}
    {{--                const formData = $(this).serialize();--}}
    {{--                $.ajax({--}}
    {{--                    url: "{{ route('save-existing-employer') }}",--}}
    {{--                    method: 'POST',--}}
    {{--                    data: formData,--}}
    {{--                    success: function(response) {--}}
    {{--                        if (response.success) {--}}
    {{--                            console.log(response.success)--}}
    {{--                            window.location.href = "{{ route('submit-existing-employers') }}";--}}
    {{--                        } else {--}}
    {{--                            if (response.msg === 'true') {--}}
    {{--                                toastr.error('Issue number already exists');--}}
    {{--                            } else {--}}
    {{--                                if (response.errors) {--}}
    {{--                                    console.log(response.errors)--}}
    {{--                                    $.each(response.errors, function(field, messages) {--}}
    {{--                                        const escapedKey = field.replace('.', '\\.');--}}
    {{--                                        $("#" + escapedKey + '_error').html(messages[--}}
    {{--                                            0]);--}}
    {{--                                    });--}}
    {{--                                }--}}
    {{--                            }--}}
    {{--                        }--}}
    {{--                    },--}}
    {{--                    error: function(xhr, status, error) {--}}

    {{--                        alert('An error occurred while processing your request.');--}}
    {{--                    }--}}
    {{--                });--}}
    {{--            });--}}

    {{--            function reAddDynamicRows() {--}}
    {{--                for (let i = 0; i < dynamicRowsData.length; i++) {--}}
    {{--                    dynamic_field(count, dynamicRowsData[i]);--}}
    {{--                }--}}
    {{--            }--}}

    {{--            // Call reAddDynamicRows function after the page reloads if dynamicRowsData is not empty--}}
    {{--            if (dynamicRowsData.length > 0) {--}}
    {{--                reAddDynamicRows();--}}
    {{--            }--}}

    {{--            $('#user_table').on('change', '.from-date, .to-date', function() {--}}
    {{--                const row = $(this).closest('tr');--}}
    {{--                // console.log("Row:", row);--}}
    {{--                calculateDateDifference(row);--}}

    {{--            });--}}
    {{--            $('#user_table').on('change', '.issue-date', function() {--}}
    {{--                const row = $(this).closest('tr');--}}
    {{--                const issueDate = $(this).val();--}}
    {{--                console.log("Issue Date:", issueDate);--}}
    {{--                DateDifference(row);--}}
    {{--            });--}}

    {{--            function DateDifference(row) {--}}
    {{--                var fromDate = row.find('.from-date').val();--}}
    {{--                var toDate = row.find('.to-date').val();--}}
    {{--                var issueDate = row.find('.issue-date').val();--}}

    {{--                console.log("From Date:", fromDate);--}}
    {{--                console.log("To Date:", toDate);--}}
    {{--                console.log("Issue Date:", issueDate);--}}

    {{--                if (!toDate || !fromDate || !issueDate) {--}}
    {{--                    // If any date field is empty, no need for further validation--}}
    {{--                    return;--}}
    {{--                }--}}

    {{--                if (toDate <= fromDate || issueDate < toDate) {--}}
    {{--                    // Display an error message if dates are invalid--}}
    {{--                    var errorMessage = toDate <= fromDate ? "To Date cannot be less than or equal to From Date." :--}}
    {{--                        "Issue Date cannot be less than To Date.";--}}
    {{--                    Swal.fire({--}}
    {{--                        text: errorMessage,--}}
    {{--                        icon: 'error',--}}
    {{--                        confirmButtonText: 'OK'--}}
    {{--                    });--}}
    {{--                    row.find('.issue-date').val('');--}}
    {{--                }--}}

    {{--                // Calculate date difference or perform any other necessary actions--}}
    {{--            }--}}

    {{--            function calculateDateDifference(row) {--}}
    {{--                var fromDate = row.find('.from-date').val();--}}
    {{--                var toDate = row.find('.to-date').val();--}}

    {{--                console.log("From Date:", fromDate);--}}
    {{--                console.log("To Date:", toDate);--}}
    {{--                if (!toDate || !fromDate) {--}}
    {{--                    // If "to" date is empty, no need for further validation--}}
    {{--                    return;--}}
    {{--                }--}}

    {{--                if (fromDate === toDate) {--}}
    {{--                    // alert("From Date and To Date cannot be the same.");--}}
    {{--                    Swal.fire({--}}
    {{--                        text: 'From Date and To Date cannot be the same.',--}}
    {{--                        icon: 'error',--}}
    {{--                        confirmButtonText: 'OK'--}}
    {{--                    });--}}
    {{--                    row.find('.from-date').val('');--}}
    {{--                    row.find('.to-date').val('');--}}
    {{--                    row.find('.days-difference').text('');--}}
    {{--                    row.find('.date_count').val('');--}}
    {{--                    return;--}}
    {{--                }--}}
    {{--                if (toDate < fromDate) {--}}
    {{--                    // Show an error message if to date is less than from date--}}
    {{--                    Swal.fire({--}}
    {{--                        text: 'To Date cannot be less than From Date.',--}}
    {{--                        icon: 'error',--}}
    {{--                        confirmButtonText: 'OK'--}}
    {{--                    });--}}
    {{--                    row.find('.from-date').val('');--}}
    {{--                    row.find('.to-date').val('');--}}
    {{--                    row.find('.days-difference').text('');--}}
    {{--                    row.find('.date_count').val('');--}}
    {{--                    return;--}}
    {{--                }--}}


    {{--                const isTimePeriodDuplicate = checkForDuplicateTimePeriod(row);--}}

    {{--                if (isTimePeriodDuplicate) {--}}
    {{--                    // alert("The time period must not be the same for other dynamically added rows.");--}}
    {{--                    // You can customize the validation error handling here--}}
    {{--                    Swal.fire({--}}
    {{--                        title: 'Error',--}}
    {{--                        text: 'Cannot Select Same Time Period!',--}}
    {{--                        icon: 'error',--}}
    {{--                        confirmButtonText: 'OK'--}}
    {{--                    });--}}
    {{--                    row.find('.from-date').val('');--}}
    {{--                    row.find('.to-date').val('');--}}
    {{--                    row.find('.days-difference').text('');--}}
    {{--                    row.find('.date_count').val('');--}}
    {{--                    return;--}}
    {{--                }--}}
    {{--                if (fromDate && toDate) {--}}

    {{--                    const differenceInMilliseconds = new Date(toDate) - new Date(fromDate);--}}
    {{--                    const differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);--}}
    {{--                    //getting the days difference--}}
    {{--                    row.find('.days-difference').text('Days Difference: ' + differenceInDays.toFixed(0));--}}
    {{--                    // Update the value of the date_count input field--}}
    {{--                    row.find('.date_count').val(differenceInDays.toFixed(0));--}}

    {{--                } else {--}}
    {{--                    row.find('.days-difference').text('');--}}
    {{--                    row.find('.date_count').val('');--}}

    {{--                }--}}
    {{--                calculateTotalDays();--}}
    {{--            }--}}

    {{--            function checkForDuplicateTimePeriod(currentRow) {--}}
    {{--                var isDuplicate = false;--}}
    {{--                var currentFromDate = new Date(currentRow.find('.from-date').val());--}}
    {{--                var currentToDate = new Date(currentRow.find('.to-date').val());--}}

    {{--                // Iterate through existing rows--}}
    {{--                $('.from-date').not(currentRow.find('.from-date')).each(function() {--}}
    {{--                    var existingFromDate = new Date($(this).val());--}}
    {{--                    var existingToDate = new Date($(this).closest('tr').find('.to-date').val());--}}

    {{--                    // Check if the current date range overlaps with existing date ranges--}}
    {{--                    if (--}}
    {{--                        (currentFromDate >= existingFromDate && currentFromDate <= existingToDate) ||--}}
    {{--                        (currentToDate >= existingFromDate && currentToDate <= existingToDate)--}}
    {{--                    ) {--}}
    {{--                        isDuplicate = true;--}}
    {{--                        return false; // Exit the loop if a duplicate is found--}}
    {{--                    }--}}
    {{--                });--}}

    {{--                return isDuplicate;--}}
    {{--            }--}}
    {{--            // Function to calculate total days--}}
    {{--            function calculateTotalDays() {--}}
    {{--                var totalDays = 0;--}}

    {{--                // Iterate through each row--}}
    {{--                $('.date_count').each(function() {--}}
    {{--                    val = parseInt($(this).val());--}}
    {{--                    if (isNaN(val)) {--}}
    {{--                        val = 0;--}}
    {{--                    }--}}
    {{--                    console.log(val);--}}
    {{--                    totalDays += val;--}}
    {{--                });--}}
    {{--                // Update the total days in the span tag--}}
    {{--                $('#total_days_span').text('Total Days: ' + totalDays);--}}

    {{--                // Check if the total days is less than 90 and show a message--}}
    {{--                if (totalDays < 90) {--}}
    {{--                    $('#total_days_span').addClass('text-danger').append(' (Total days should be at least 90)');--}}
    {{--                } else {--}}
    {{--                    $('#total_days_span').removeClass('text-danger');--}}
    {{--                }--}}
    {{--            }--}}
    {{--            // Trigger the calculation on input change--}}
    {{--            $('#user_table').on('change', '.from-date, .to-date', function() {--}}
    {{--                // calculateTotalDays();--}}
    {{--            });--}}

    {{--            $(document).on('click', '#add', function() {--}}
    {{--                let count = $('#user_table tbody tr').length + 1;--}}
    {{--                dynamic_field(count);--}}
    {{--                calculateTotalDays(); // Recalculate total days after adding a row--}}
    {{--            });--}}
    {{--            // Event handler for removing rows--}}
    {{--            $(document).on('click', '.remove', function() {--}}
    {{--                $(this).closest("tr").remove();--}}
    {{--                calculateTotalDays(); // Recalculate total days after removing a row--}}
    {{--            });--}}
    {{--            $('form').on('submit', function(e) {--}}
    {{--                // Calculate total days before form submission--}}
    {{--                var fromDates = $('.from-date').map(function() {--}}
    {{--                    return $(this).val();--}}
    {{--                }).get();--}}

    {{--                var toDates = $('.to-date').map(function() {--}}
    {{--                    return $(this).val();--}}
    {{--                }).get();--}}

    {{--                // Check if any "from" or "to" date is empty--}}
    {{--                if (fromDates.some(date => !date) || toDates.some(date => !date)) {--}}
    {{--                    // Show an error message if any date is missing--}}
    {{--                    // Swal.fire({--}}
    {{--                    //     title: 'Error',--}}
    {{--                    //     text: 'Please enter both From Date and To Date.',--}}
    {{--                    //     icon: 'error',--}}
    {{--                    //     confirmButtonText: 'OK'--}}
    {{--                    // });--}}
    {{--                    e.preventDefault(); // Prevent form submission--}}
    {{--                    return;--}}
    {{--                }--}}
    {{--                calculateTotalDays();--}}

    {{--                // Check if the total days is less than 90--}}
    {{--                var totalDays = parseFloat($('#total_days_span').text().replace('Total Days: ', ''));--}}
    {{--                if (totalDays < 90) {--}}
    {{--                    // Show an alert or perform other actions to notify the user--}}
    {{--                    Swal.fire({--}}
    {{--                        title: 'Certificate Duration',--}}
    {{--                        text: 'Total no of days should be 90 days or more.',--}}
    {{--                        icon: 'error',--}}
    {{--                        confirmButtonText: 'OK'--}}
    {{--                    });--}}
    {{--                    e.preventDefault(); // Prevent form submission--}}
    {{--                }--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
    <script>
        $(document).ready(function() {
            const currentDate = '<?php echo date('Y-m-d'); ?>';
            let count = $('tbody tr').length;
            let dynamicRowsData = [];

            function dynamic_field(number, data = null) {
                let html = `<tr>
            <td class="dropdown">
                <select name="type_of_issuer[` + count + `]" class="form-control fixed-width">
                    <option value="">Select Issuer</option>`;
                @foreach ($type_of_issuer as $issuer)
                    html += `<option value="{{ $issuer->issuer_code }}">{{ $issuer->issuer_name }}</option>`;
                @endforeach
                    html += `</select><span class="text-danger success" id="type_of_issuer.` + count + `_error"></span>
            </td>`;
                html += '<td><input type="text" name="issuing_org[' + count + ']" class="form-control fixed-width" id="issuing_org_' + number + '"/>' +
                    '<span class="text-danger success" id="issuing_org.' + count + '_error"></span></td>';

                html += '<td><input type="text" name="issue_no[' + count + ']" class="form-control fixed-width"/>' +
                    '<span class="text-danger success" id="issue_no.' + count + '_error"></span></td>';

                html += '<td><input type="date" name="issue_date[' + count + ']" id="issue_date" data-id="1" class="form-control issue issue-date" max="' + currentDate + '" />' +
                    '<span class="text-danger success" id="issue_date.' + count + '_error"></span></td>';

                html += '<td><input type="text" name="issuing_person[' + count + ']" class="form-control fixed-width" id="issuing_person_' + number + '"/>' +
                    '<span class="text-danger success" id="issuing_person.' + count + '_error"></span></td>';

                html += '<td><input type="text" name="contact_issuing_person[' + count + ']" class="form-control fixed-width" maxlength="10" id="contact_issuing_person_' + number + '">' +
                    '<span class="text-danger success" id="contact_issuing_person.' + count + '_error"></span></td>';

                html += '<td><select id="issame_' + number + '" name="is_same[' + count + ']" class="form-control" onchange="toogleIssameInput(' + number + ')">>';
                html += '<option value="">Select</option>';
                html += '<option value="1">Yes</option>';
                html += '<option value="0">No</option>';
                html += '</select><span class="text-danger success" id="is_same.' + count + '_error"></span></td>';

                html += '<td><input type="text" id="employer_name_certi_' + number + '" name="employer_name_certi[' + count + ']" class="form-control fixed-width" maxlength="10" readonly>' +
                    '<span class="text-danger success" id="employer_name_certi.' + count + '_error"></span></td>';

                html += '<td><input type="text" id="employer_contact_name_' + number + '" name="employer_contact_name[' + count + ']" class="form-control fixed-width" maxlength="10" readonly>' +
                    '<span class="text-danger success" id="employer_contact_name.' + count + '_error"></span></td>';

                html += '<td><input type="text" id="employer_contact_number_' + number + '" name="employer_contact_number[' + count + ']" class="form-control fixed-width" maxlength="10" readonly>' +
                    '<span class="text-danger success" id="employer_contact_number.' + count + '_error"></span></td>';

                html += '<td><input type="date" name="from_date[' + count + ']" id="from_date_' + number + '" data-id="1" class="form-control from-date" max="' + currentDate + '" />' +
                    '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';

                html += '<td><input type="date" name="to_date[' + count + ']" id="to_date_' + number + '" data-id="1" class="form-control to-date" max="' + currentDate + '" />' +
                    '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';

                html += '<td><input type="text" id="dateCount" class="form-control date_count" /></td>';

                html += `<td class="dropdown">
                <select name="type_of_employer[` + count + `]" class="form-control fixed-width">
                    <option value="">Select Employer</option>`;
                @foreach ($type_of_employers as $employer)
                    html += `<option value="{{ $employer->employer_code }}">{{ $employer->employer_name }}</option>`;
                @endforeach
                    html += '</select><span class="text-danger success" id="type_of_employer.' + count + '_error"></span></td>';

                html += '<td><button type="button" name="remove" id="" class="btn btn-sm btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
                $('tbody').append(html);
                count++;
            }

            function reAddDynamicRows() {
                for (let i = 0; i < dynamicRowsData.length; i++) {
                    dynamic_field(i + 1, dynamicRowsData[i]);  // Passing index as count
                }
            }

            function calculateDateDifference(row) {
                var fromDate = row.find('.from-date').val();
                var toDate = row.find('.to-date').val();

                if (!fromDate || !toDate) {
                    row.find('.days-difference').text('');
                    row.find('.date_count').val('');
                    return;
                }

                if (fromDate === toDate) {
                    Swal.fire({
                        text: 'From Date and To Date cannot be the same.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    row.find('.from-date').val('');
                    row.find('.to-date').val('');
                    row.find('.days-difference').text('');
                    row.find('.date_count').val('');
                    return;
                }

                // if (checkForDuplicateTimePeriod(row)) {
                //     Swal.fire({
                //         title: 'Error',
                //         text: 'Cannot Select Same Time Period!',
                //         icon: 'error',
                //         confirmButtonText: 'OK'
                //     });
                //     row.find('.from-date').val('');
                //     row.find('.to-date').val('');
                //     row.find('.days-difference').text('');
                //     row.find('.date_count').val('');
                //     return;
                // }

                const differenceInMilliseconds = new Date(toDate) - new Date(fromDate);
                const differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);
                row.find('.days-difference').text('Days Difference: ' + differenceInDays.toFixed(0));
                row.find('.date_count').val(differenceInDays.toFixed(0));

                calculateTotalDays();
            }

            function calculateTotalDays() {
                var totalDays = 0;
                $('.date_count').each(function () {
                    var val = parseInt($(this).val());
                    if (isNaN(val)) {
                        val = 0;
                    }
                    totalDays += val;
                });
                $('#total_days_span').text('Total Days: ' + totalDays);
                if (totalDays < 90) {
                    $('#total_days_span').addClass('text-danger').append(' (Total days should be at least 90)');
                } else {
                    $('#total_days_span').removeClass('text-danger');
                }
            }

            function checkForDuplicateTimePeriod(currentRow) {
                var isDuplicate = false;
                var currentFromDate = new Date(currentRow.find('.from-date').val());
                var currentToDate = new Date(currentRow.find('.to-date').val());

                $('.from-date').not(currentRow.find('.from-date')).each(function () {
                    var existingFromDate = new Date($(this).val());
                    var existingToDate = new Date($(this).closest('tr').find('.to-date').val());
                    if (
                        (currentFromDate >= existingFromDate && currentFromDate <= existingToDate) ||
                        (currentToDate >= existingFromDate && currentToDate <= existingToDate)
                    ) {
                        isDuplicate = true;
                        return false;
                    }
                });

                return isDuplicate;
            }

            function DateDifference(row) {
                var fromDate = row.find('.from-date').val();
                var toDate = row.find('.to-date').val();
                var issueDate = row.find('.issue-date').val();

                if (!fromDate || !toDate || !issueDate) {
                    // If any date field is empty, no need for further validation
                    return;
                }

                if (toDate <= fromDate || issueDate < toDate) {
                    var errorMessage = toDate <= fromDate ? "To Date cannot be less than or equal to From Date." : "Issue Date cannot be less than To Date.";
                    Swal.fire({
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    row.find('.issue-date').val('');
                }
            }

            // Event listener for adding a new row
            $(document).on('click', '#add', function () {
                let count = $('#user_table tbody tr').length + 1;
                dynamic_field(count);
                calculateTotalDays();
            });

            // Event listener for removing a row
            $(document).on('click', '.remove', function () {
                $(this).closest("tr").remove();
                calculateTotalDays();
            });

            // Calculate date differences and total days on date change
            $('#user_table').on('change', '.from-date, .to-date', function () {
                const row = $(this).closest('tr');
                calculateDateDifference(row);
            });

            $('#user_table').on('change', '.issue-date', function () {
                const row = $(this).closest('tr');
                DateDifference(row);
            });

            // Form submission with AJAX
            $('#employer').on('submit', function (e) {
                e.preventDefault();  // Prevent default form submission

                calculateTotalDays();
                var totalDays = parseFloat($('#total_days_span').text().replace('Total Days: ', ''));
                if (totalDays < 90) {
                    Swal.fire({
                        title: 'Certificate Duration',
                        text: 'Total number of days should be 90 days or more.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;  // Stop the submission process
                }

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('save-existing-employer') }}',
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            console.log(response.success);
                            window.location.href = "{{ route('submit-existing-employers') }}";
                        } else {
                            if (response.msg === 'true') {
                                toastr.error('Issue number already exists');
                            } else {
                                if (response.errors) {
                                    console.log(response.errors);
                                    $.each(response.errors, function (field, messages) {
                                        const escapedKey = field.replace('.', '\\.');
                                        $("#" + escapedKey + '_error').html(messages[0]);
                                    });
                                }
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred while processing your request.');
                    }
                });
            });

            // Re-add dynamic rows after page reload if dynamicRowsData is not empty
            if (dynamicRowsData.length > 0) {
                reAddDynamicRows();
            }

            // Calculate date differences and total days for existing rows on page load
            $('#user_table').find('tr').each(function () {
                calculateDateDifference($(this));
            });
        });

    </script>
    <script>
        // Initialize the datepicker
        $(document).ready(function() {
            $("#doj").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0", // Allow selecting DOB up to 100 years ago from the current year
                maxDate: 0 // Prevent future dates
            });
        });
    </script>
    <script>
        function ajaxStart() {
            // Show the loader when an AJAX request starts
            $("#loader").show();
        };

        function ajaxStop() {
            // Hide the loader when all AJAX requests are complete
            $("#loader").hide();
        };
        $(document).ready(function() {

            $('.dist').on('change', function() {
                ajaxStart();
                var cDist = $(this).data('id');
                var district_code = $(this).val();

                if (district_code) {
                    $.ajax({
                        url: 'get-subdistricts',
                        type: 'GET',
                        data: {
                            district_code: district_code,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            ajaxStop();
                            if (cDist == 'd') {
                                var dis = '#subdist';
                            }
                            console.log(data)
                            $(dis).html('<option value="">--Select Sub-District--</option>');
                            $.each(data.subdist, function(key, value) {
                                $(dis).append('<option value="' + value
                                    .subdistrict_code + '">' + value
                                    .subdistrict_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subdist').empty();
                    // $('#subdistrict').empty();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to check if the date already exists in the table
            function isDateUnique(date) {
                let dates = [];
                $('.issue-date').each(function() {
                    dates.push($(this).val());
                });

                return dates.indexOf(date) === dates.lastIndexOf(date);
            }

            $(document).on('change', '.issue', function() {
                let currentDate = $(this).val();

                if (!isDateUnique(currentDate)) {
                    // alert('Issue date must be unique.');
                    Swal.fire({
                        title: 'Issue Date',
                        text: 'Issue date cannot be same!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $(this).val('');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to check if the issue number is unique
            function isIssueNoUnique(issueNo) {
                let issueNos = [];
                $('.issueNo').each(function() {
                    issueNos.push($(this).val());
                });

                return issueNos.indexOf(issueNo) === issueNos.lastIndexOf(issueNo);
            }

            // Event delegation for dynamically added issue number fields
            $(document).on('change', '.issueNo', function() {
                let currentIssueNo = $(this).val();

                if (!isIssueNoUnique(currentIssueNo)) {
                    Swal.fire({
                        title: 'Issue Number',
                        text: 'Issue number cannot be same!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $(this).val('');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pinCode = document.getElementById('pincode');
            const mgnrega = document.getElementById('mgnrega');
            const empName = document.getElementById('emp_name');
            const city = document.getElementById('city');
            const board = document.getElementById('board');
            const workplace = document.getElementById('workplace');

            const pinCodeErr = document.getElementById('pinError');
            const mgnregaErr = document.getElementById('mgnregaError');
            const empNameErr = document.getElementById('empError');
            const cityErr = document.getElementById('cityError');
            const boardError = document.getElementById('boardError');
            const workplaceError = document.getElementById('workError');

            function validateField(input, errorElement) {
                if (!/^\d*$/.test(input.value)) {
                    errorElement.textContent = '⚠ Must contain only numeric values';
                    return false;
                } else {
                    errorElement.textContent = '';
                    return true;
                }
            }

            function validate(input, errorElement) {
                if (!/^[^\d]*$/.test(input.value)) {
                    errorElement.textContent = '⚠ Cannot contain numerical values';
                    return false;
                } else {
                    errorElement.textContent = '';
                    return true;
                }
            }

            pinCode.addEventListener('input', function(event) {
                validateField(pinCode, pinCodeErr);
            });
            empName.addEventListener('input', function(event) {
                validate(empName, empNameErr);
            });

            mgnrega.addEventListener('input', function(event) {
                validateField(mgnrega, mgnregaErr);
            });

            board.addEventListener('input', function(event) {
                validate(board, boardError);
            });
            city.addEventListener('input', function(event) {
                validate(city, cityErr);
            });
            workplace.addEventListener('input', function(event) {
                validate(workplace, workplaceError);
            })


        });
    </script>
    <script>
        function updateMaxAttribute() {
            var today = new Date().toISOString().split('T')[0];

            $('input[type="date"]').each(function() {
                $(this).attr('max', today);
            });
        }

        // Call the function initially
        updateMaxAttribute();
    </script>

    <script>
        function toogleIssameInput(number) {
            // Get the dropdown element
            var isSameDropdown = document.getElementById('issame_' + number);

            var selectedIndex = isSameDropdown.selectedIndex;
            var selectedOption = isSameDropdown.options[selectedIndex].value;

            // Get the input fields
            var orgInput = document.getElementById('issuing_org_' + number);
            var personInput = document.getElementById('issuing_person_' + number);
            var contactInput = document.getElementById('contact_issuing_person_' + number);
            var employerNameInput = document.getElementById('employer_name_certi_' + number);
            var employerContactNameInput = document.getElementById('employer_contact_name_' + number);
            var employerContactNumberInput = document.getElementById('employer_contact_number_' + number);

            // If "Yes" is selected, copy and paste the values
            if (selectedOption === '1') {
                employerNameInput.value = orgInput.value;
                employerContactNameInput.value = personInput.value;
                employerContactNumberInput.value = contactInput.value;

                // Make the employer fields read-only if copied
                employerNameInput.readOnly = true;
                employerContactNameInput.readOnly = true;
                employerContactNumberInput.readOnly = true;
            } else {
                // If "No" is selected, make the employer fields writable
                employerNameInput.readOnly = false;
                employerContactNameInput.readOnly = false;
                employerContactNumberInput.readOnly = false;

                employerNameInput.value = '';
                employerContactNameInput.value = '';
                employerContactNumberInput.value = '';
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            function toggleEmployerDetails() {
                if ($('input[name="current_employer"]:checked').val() == 1) {
                    $('#employerDetails').show();
                } else {
                    $('#employerDetails').hide();
                }
            }

            $('input[name="current_employer"]').change(toggleEmployerDetails);
            toggleEmployerDetails(); // Initialize on page load
        });
    </script>
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>

@endsection
