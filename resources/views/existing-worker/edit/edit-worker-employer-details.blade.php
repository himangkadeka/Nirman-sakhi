@extends('layouts.user-app')

@section('title', ' | Update |Employer Details')

@section('style')
    <style>
        .readonly-select {
            background-color: #e9ecef;
            color: #6c757d;
            pointer-events: none;
            cursor: not-allowed;
        }

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


        .custom-bottom-border {
            border-top: none !important;
            border-right: none !important;
            border-left: none !important;
            border-bottom: 1px solid #ced4da !important;
            /* You can customize the color */
            border-radius: 8px !important;
            /* Remove border-radius if needed */
        }


        .bold {
            font-weight: 600;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 14px;
            /*color: #186cb8;*/
            color: #219fa4;
            /*color: #7ea1a2;*/
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
    @include('components.multistep')

    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-md-12">
                <nav class="custom-navbar navbar-light p-3" style="border-radius: 20px;">
                    <div class="custom-container">
                        <div class="custom-flex-container">
                            <div class="custom-left-content">
                                <h6 class="custom-heading">Registration - Construction Worker&nbsp;|&nbsp;পঞ্জীয়ন - নিৰ্মাণ
                                    শ্ৰমিক</h6>
                                <h6 class="custom-bold">
                                    <i class="custom-icon fas fa-file-alt pr-2"></i>Application No - {{ $application_no }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                    style="background-color: #2badee;">
                                    <span>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Update 90 Days
                                        Certificate Details
                                    </span>
                                    <span>
                                        <i class="fa fa-user" aria-hidden="true"></i> Worker Name -
                                        {{ $getVaultData['name'] }}
                                    </span>
                                </div>
                                <div class="mr-3 mt-3 ml-3"
                                    style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                    <p style="margin: 0;">
                                        <strong>Note:</strong><span class="text-danger"> (*) Marked are Mandatory
                                            Fields</span>
                                    </p>
                                </div>
                                @if($remarks)
                                    <div>
                                        <div class="revert">

                                            <div class="ml-2">
                                                <h5 class="text-primary">For the following reasons application has been reverted:</h5>
                                                <p>
                                                <ul>
                                                    @foreach ($remarks->getReasons($remarks->worker_id) as $remark)
                                                        <li class="text-danger">{{$remark->reason}}</li>
                                                    @endforeach
                                                </ul>
                                                </p>
                                            </div>

                                            <div class="ml-2">
                                                <h5 class="text-primary">Remarks from Officers:</h5>
                                                <p class="text-danger">{{$remarks->remarks}}</p>
                                            </div>
                                        </div>



                                    </div>
                                @endif
                                <form action="{{ route('update-employer-data') }}" class="form-group ml-2 mr-2"
                                    enctype="multipart/form-data" method="post" id="employer">

                                    @csrf
                                    <div class="container-fluid text-center mt-4">
                                        <div class="table-container">
                                            <table class="table" id="user_table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="bold">Type of Employer <span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">Employer Name<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">Employer Contact Number<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">Issue Date<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">Type of Construction Work<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">From Date<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">To Date<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">No of Days<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">Profession<span
                                                                class="text-danger">*</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($twc as $key => $certificate)
                                                        <tr>
                                                            <td class="fixed-width"><select name="type_of_employer[]"
                                                                    class="form-control fixed-width"
                                                                    id="type_of_employer_1">
                                                                    <option value="{{ $certificate->type_of_employer }}">
                                                                        {{ $certificate->empname }}</option>
                                                                    @foreach ($type_of_employers as $employers)
                                                                        @if ($certificate->type_of_employer != $employers->employer_code)
                                                                            <option value="{{ $employers->employer_code }}">
                                                                                {{ $employers->employer_name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger success"
                                                                    id="type_of_employer.0_error"></span>
                                                            </td>

                                                            <td class="fixed-width"><input type="text"
                                                                    name="employer_name_certi[]"
                                                                    value="{{ $certificate->emp }}" class="form-control"
                                                                    id="employer_name_certi_{{ $loop->index + 1 }}" />
                                                                <span class="text-danger success"
                                                                    id="employer_name.0_error"></span>
                                                            </td>

                                                            <td class="fixed-width"><input type="text"
                                                                    onkeypress="return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));"
                                                                    name="employer_contact_number[]"
                                                                    value="{{ $certificate->employer_contact_number }}"
                                                                    class="form-control"
                                                                    id="employer_contact_number_{{ $loop->index + 1 }}" />
                                                                <span class="text-danger success"
                                                                    id="employer_contact_number.0_error"></span>
                                                            </td>

                                                            <td class="fixed-width">
                                                                <input type="date" name="issue_date[]"
                                                                    value="{{ $certificate->issue_date }}"
                                                                    class="form-control issue" />
                                                                <span class="text-danger success"
                                                                    id="issue_date.0_error"></span>
                                                            </td>

                                                            <td>
                                                                <select
                                                                    class="form-control fixed-width error-message @if ($errors->has('type_of_work')) is-invalid @endif"
                                                                    name="type_of_work[]" data-id="1"
                                                                    id="type_of_work_1">
                                                                    <option value="{{ $certificate->type_of_work }}">
                                                                        {{ $certificate->work_type_name }}</option>
                                                                    @foreach ($worktype as $work)
                                                                        <option value="{{ $work->work_type_code }}">
                                                                            {{ $work->work_type_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger success"
                                                                    id="type_of_work.0_error"></span>
                                                            </td>




                                                            <td class="fixed-width"><input type="date"
                                                                    name="from_date[]"
                                                                    value="{{ $certificate->from_date }}"
                                                                    class="form-control fixed-width from-date" />
                                                                <span class="text-danger success"
                                                                    id="from_date.0_error"></span>
                                                            </td>

                                                            <td class="fixed-width"><input type="date"
                                                                    name="to_date[]" value="{{ $certificate->to_date }}"
                                                                    class="form-control fixed-width to-date" />
                                                                <span class="text-danger success"
                                                                    id="to_date.0_error"></span>
                                                            </td>

                                                            <td class="fixed-width"><input type="text"
                                                                    name="date_count[]" onchange="checkWorkingDays(1)"
                                                                    class="date_count form-control" id="date_count_1"
                                                                    placeholder="Working Days"
                                                                    value="{{ $certificate->date_count }}" />
                                                                <span class="text-danger success"
                                                                    id="date_count_error"></span>
                                                            </td>


                                                            <span id="total_days_span"
                                                                class="text-info font-weight-normal"></span>



                                                            <td class="dropdown fixed-width">
                                                                <select name="profession[]" class="form-control"
                                                                    id="profession_1">
                                                                    <option value="{{ $certificate->profession_code }}">
                                                                        {{ $certificate->profession_name }}</option>
                                                                    @foreach ($professions as $profession)
                                                                        <option
                                                                            value="{{ $profession->profession_code }}">
                                                                            {{ $profession->profession_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger success"
                                                                    id="profession.0_error"></span>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="button" name="add" id="add"
                                        class="btn btn-sm btn-info mt-3"><i class="fa fa-plus-circle"></i>&nbsp;Add New
                                        Row</button>

                                    <div class="mt-4 ml-4">
                                        <div class="mt-4 p-3 border rounded shadow-sm bg-light" style="max-width: 500px;">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0">Work Experience Certificate</h5>

                                                <button type="button" name="add-more" id="add-more"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-plus-circle mr-2"></i>Add More
                                                </button>
                                            </div>
                                            <div>
                                                @php
                                                    $serialNumber = 1;
                                                @endphp
                                                @if ($ndc->isEmpty())
                                                    <p>No certificates found for this worker.</p>
                                                @else
                                                    <ul class="list-group">
                                                        @foreach ($ndc as $certificate)
                                                            <li class="list-group-item">
                                                                <strong>Certificate Proof {{ $serialNumber++ }} :</strong>
                                                                <a
                                                                    href="{{ route('show-cert-proof', ['id' => $certificate->id]) }}"><button
                                                                        type="button" class="btn btn-sm remove-file"><i
                                                                            class="fa fa-eye text-primary"></i></button></a>
                                                                <button type="button" class="btn btn-sm remove-file"><i
                                                                        class="fa fa-trash text-danger"></i></button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>

                                            <div id="file-inputs">
                                                <div class="file-input-wrapper mb-3">
                                                    <div class="file-preview mt-2">
                                                        <span id="file-name-0" class="text-muted"></span>
                                                        <button type="button"
                                                            class="btn btn-sm btn-link text-danger remove-file"
                                                            style="display: none;">Remove</button>
                                                    </div>
                                                    <span class="text-danger small" id="certificate_proof_0_error"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog"
                                            aria-labelledby="pdfModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe id="pdfViewer" style="width: 100%; height: 500px;"
                                                            frameborder="0"></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="discardFile"
                                                            class="btn btn-danger">Discard</button>
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-dismiss="modal">Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                        <div class="ml-auto d-inline-block align-self-center mr-2">
                                            <a type="submit" href="{{ route('submit-bank-details') }}"
                                                class="btn btn-sm btn-warning"><i class="fa fa-backward"
                                                    aria-hidden="true"></i>&nbsp;
                                                Previous</a>
                                            <button type="submit" class="btn btn-sm btn-primary"><i
                                                    class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                                Update Employer & Certificate</button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer')
    {{-- <script src="{{URL::asset('assets/template/vendor/jquery/ajax-jquery-3.7.min.js')}}"></script> --}}
    <link rel="stylesheet" href="{{ URL::asset('assets/template/datepicker/jquery-ui.min.css') }}">
    <script src="{{ URL::asset('assets/template/datepicker/jquery-3.7.date.js') }}"></script>
    <script src="{{ URL::asset('assets/template/datepicker/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const currentDate = '<?php echo date('Y-m-d'); ?>';
            let count = $('tbody tr').length;
            let dynamicRowsData = [];

            function dynamic_field(number, data = null) {
                let html = `<tr>`;
                html += `<td class="dropdown">
                <select name="type_of_employer[` + count +
                    `]" class="form-control fixed-width" id="type_of_employer_` + number +
                    `">
                    <option value="">Select Employer</option>`;
                @foreach ($type_of_employers as $employer)
                    html +=
                        `<option value="{{ $employer->employer_code }}">{{ $employer->employer_name }}</option>`;
                @endforeach
                html += '</select><span class="text-danger success" id="type_of_employer.' + count +
                    '_error"></span></td>';

                html += '<td><input type="text" id="employer_name_certi_' + number +
                    '" name="employer_name_certi[' + count +
                    ']" class="form-control fixed-width">' +
                    '<span class="text-danger success" id="employer_name_certi.' + count + '_error"></span></td>';

                html += '<td><input type="text" id="employer_contact_number_' + number +
                    '" name="employer_contact_number[' + count +
                    ']" class="form-control fixed-width" maxlength="10">' +
                    '<span class="text-danger success" id="employer_contact_number.' + count +
                    '_error"></span></td>';

                html += '<td><input type="date" name="issue_date[' + count +
                    ']" id="issue_date" data-id="1" class="form-control issue issue-date" max="' + currentDate +
                    '" />' +
                    '<span class="text-danger success" id="issue_date.' + count + '_error"></span></td>';

                html += `<td class="dropdown">
                <select name="type_of_work[` + count + `]" class="form-control fixed-width">
                    <option value="">Select Type of Work</option>`;
                @foreach ($worktype as $work)
                    html +=
                        `<option value="{{ $work->work_type_code }}">{{ $work->work_type_name }}</option>`;
                @endforeach
                html += '</select><span class="text-danger success" id="type_of_work.' + count +
                    '_error"></span></td>';

                html += '<td><input type="date" name="from_date[' + count + ']" id="from_date_' + number +
                    '" data-id="1" class="form-control from-date" max="' + currentDate + '" />' +
                    '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';

                html += '<td><input type="date" name="to_date[' + count + ']" id="to_date_' + number +
                    '" data-id="1" class="form-control to-date" max="' + currentDate + '" />' +
                    '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';

                html += '<td><input type="text" name="date_count[' + count + ']" id="date_count_' + number +
                    '" class="form-control date_count" /></td>';



                html += `<td class="dropdown">
                <select name="profession[` + count +
                    `]" class="form-control fixed-width" id="profession_` + number +
                    `">
                    <option value="">Select Employer</option>`;
                @foreach ($professions as $profession)
                    html +=
                        `<option value="{{ $profession->profession_code }}">{{ $profession->profession_name }}</option>`;
                @endforeach
                html += '</select><span class="text-danger success" id="profession.' + count +
                    '_error"></span></td>';
                // html += '<td><button type="submit" class="btn-sm btn-success">Upload</button></td>';

                html +=
                    '<td><button type="button" name="remove" id="" class="btn btn-sm  remove"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button></td></tr>';
                $('tbody').append(html);
                count++;
            }

            function reAddDynamicRows() {
                for (let i = 0; i < dynamicRowsData.length; i++) {
                    dynamic_field(i + 1, dynamicRowsData[i]); // Passing index as count
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
                // row.find('.days-difference').text('Days Difference: ' + differenceInDays.toFixed(0));
                // row.find('.date_count').val(differenceInDays.toFixed(0));

                calculateTotalDays();
            }

            function calculateTotalDays() {
                var totalDays = 0;
                $('.date_count').each(function() {
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

                $('.from-date').not(currentRow.find('.from-date')).each(function() {
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

            $(document).on('input', '.date_count', function() {
                var row = $(this).closest('tr');
                var workingDays = parseInt($(this).val());
                var fromDate = row.find('.from-date').val();
                var toDate = row.find('.to-date').val();

                if (!fromDate || !toDate || isNaN(workingDays)) {
                    return;
                }

                const differenceInMilliseconds = new Date(toDate) - new Date(fromDate);
                const maxDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);

                if (workingDays > maxDays) {
                    Swal.fire({
                        text: 'The number of working days cannot exceed the difference between From Date and To Date.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $(this).val('');
                }
            });

            function DateDifference(row) {
                var fromDate = row.find('.from-date').val();
                var toDate = row.find('.to-date').val();
                var issueDate = row.find('.issue-date').val();

                if (!fromDate || !toDate || !issueDate) {
                    // If any date field is empty, no need for further validation
                    return;
                }

                if (toDate <= fromDate || issueDate < toDate) {
                    var errorMessage = toDate <= fromDate ? "To Date cannot be less than or equal to From Date." :
                        "Issue Date cannot be less than To Date.";
                    Swal.fire({
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    row.find('.issue-date').val('');
                }
            }

            // Event listener for adding a new row
            $(document).on('click', '#add', function() {
                let count = $('#user_table tbody tr').length + 1;
                dynamic_field(count);
                calculateTotalDays();
            });

            // Event listener for removing a row
            $(document).on('click', '.remove', function() {
                $(this).closest("tr").remove();
                calculateTotalDays();
            });

            // Calculate date differences and total days on date change
            $('#user_table').on('change', '.from-date, .to-date', function() {
                const row = $(this).closest('tr');
                calculateDateDifference(row);
            });

            $('#user_table').on('change', '.issue-date', function() {
                const row = $(this).closest('tr');
                DateDifference(row);
            });

            // Form submission with AJAX
            $('#employer').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                calculateTotalDays();
                var totalDays = parseFloat($('#total_days_span').text().replace('Total Days: ', ''));
                if (totalDays < 90) {
                    Swal.fire({
                        title: 'Certificate Duration',
                        text: 'Total number of days should be 90 days or more.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return; // Stop the submission process
                }
                // var form_data = new FormData($('form'));
                // console.log(form_data);

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('update-existing-employer-details') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            console.log(response.success);
                            window.location.href = "{{ route('submit-existing-employers') }}";
                        } else {
                            if (response.msg === 'true') {
                                Toastify({
                                    text: 'Issue number already exists',
                                    duration: 5000, // Duration in milliseconds
                                    close: true, // Show close button
                                    gravity: "top", // Position of the toast (top or bottom)
                                    position: "right", // Position on the screen (left, right, center)
                                    style: {
                                        background: "#FF4C4C" // Error color (e.g., red)
                                    },
                                }).showToast();
                            } else {
                                if (response.errors) {
                                    Toastify({
                                        text: 'Validation Error Found',
                                        duration: 5000, // Duration in milliseconds
                                        close: true, // Show close button
                                        gravity: "top", // Position of the toast (top or bottom)
                                        position: "right", // Position on the screen (left, right, center)
                                        style: {
                                            background: "#FF4C4C" // Error color (e.g., red)
                                        },
                                    }).showToast();
                                    console.log(response.errors);
                                    $.each(response.errors, function(field, messages) {
                                        const escapedKey = field.replace('.', '\\.');
                                        $("#" + escapedKey + '_error').html(messages[
                                            0]);
                                    });
                                }
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while processing your request.');
                    }
                });
            });

            // Re-add dynamic rows after page reload if dynamicRowsData is not empty
            if (dynamicRowsData.length > 0) {
                reAddDynamicRows();
            }

            // Calculate date differences and total days for existing rows on page load
            $('#user_table').find('tr').each(function() {
                calculateDateDifference($(this));
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

                // Check if the current date appears only once in the array
                return dates.indexOf(date) === dates.lastIndexOf(date);
            }

            // Event listener for change in issue date inputs
            $(document).on('change', '.issue-date', function() {
                let currentDate = $(this).val();

                if (!isDateUnique(currentDate)) {
                    // Display error message using SweetAlert (Swal)
                    Swal.fire({
                        title: 'Issue Date',
                        text: 'Issue date must be unique.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $(this).val(''); // Clear the input field if date is not unique
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

        updateMaxAttribute();
    </script>

    <script>
        function toogleIssameInput(number) {
            var isSameDropdown = document.getElementById('issame_' + number);
            var selectedIndex = isSameDropdown.selectedIndex;
            var selectedOption = isSameDropdown.options[selectedIndex].value;
            // var orgInput = document.getElementById('issuing_org_' + number);
            var personInput = document.getElementById('issuing_person_' + number);
            var contactInput = document.getElementById('contact_issuing_person_' + number);
            var employerNameInput = document.getElementById('employer_name_certi_' + number);
            // var employerContactNameInput = document.getElementById('employer_contact_name_' + number);
            var employerContactNumberInput = document.getElementById('employer_contact_number_' + number);

            if (selectedOption === '1') {
                employerNameInput.value = personInput.value;
                // employerContactNameInput.value = personInput.value;
                employerContactNumberInput.value = contactInput.value;

                employerNameInput.readOnly = true;
                // employerContactNameInput.readOnly = true;
                employerContactNumberInput.readOnly = true;
            } else {
                employerNameInput.readOnly = false;
                // employerContactNameInput.readOnly = false;
                employerContactNumberInput.readOnly = false;

                employerNameInput.value = '';
                // employerContactNameInput.value = '';
                employerContactNumberInput.value = '';
            }
        }
    </script>

    <script>
        function checkIssuer(number) {
            var issuerSelect = document.getElementById('issuer_type_' + number);
            var issuerType = document.getElementById('issuer_type_' + number).value;
            var isSameSelect = document.getElementById('issame_' + number);
            var employerNameInput = document.getElementById('employer_name_certi_' + number);
            var employerContactNumberInput = document.getElementById('employer_contact_number_' + number);
            var employerSelect = document.getElementById("type_of_employer_" + number);

            if (issuerType !== "") {
                var issuerIndex = issuerSelect.selectedIndex;
                if (issuerIndex > 0 && issuerIndex <= 4) {
                    employerSelect.selectedIndex = issuerIndex;
                    employerSelect.addEventListener('mousedown', preventInteraction);
                    employerSelect.classList.add('readonly-select');
                } else {
                    employerSelect.selectedIndex = 0;
                    employerSelect.removeEventListener('mousedown', preventInteraction);
                    employerSelect.classList.remove('readonly-select');
                }
            } else {
                employerSelect.selectedIndex = 0;
                employerSelect.removeEventListener('mousedown', preventInteraction);
                employerSelect.classList.remove('readonly-select');
            }
            if (issuerType == 7 || issuerType == 8) {
                isSameSelect.value = '0';
                isSameSelect.readOnly = true;
                employerNameInput.readOnly = false;
                employerContactNumberInput.readOnly = false;
                isSameSelect.addEventListener('mousedown', preventInteraction);
                isSameSelect.classList.add('readonly-select');
            } else if (issuerType >= 1 && issuerType <= 4) {
                isSameSelect.value = '1';
                isSameSelect.readOnly = true;
                employerNameInput.readOnly = true;
                employerContactNumberInput.readOnly = true;
                isSameSelect.addEventListener('mousedown', preventInteraction);
                isSameSelect.classList.add('readonly-select');
            } else {
                isSameSelect.readOnly = false;
                isSameSelect.value = '';
                isSameSelect.removeEventListener('mousedown', preventInteraction);
                isSameSelect.classList.remove('readonly-select');
            }
        }

        function preventInteraction(e) {
            e.preventDefault();
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
            toggleEmployerDetails();
        });
    </script>

    <script>
        function checkWorkingDays(number) {
            const fromDateInputs = document.getElementById('.from-date_' + number);
            const toDateInputs = document.getElementById('.to-date_' + number);
            const dateCountInputs = document.getElementById('.date_count_' + number);

            function calculateDateDifference(fromDate, toDate) {
                const from = new Date(fromDate);
                const to = new Date(toDate);
                const diffTime = to - from;
                return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            }

            function validateDateCount() {
                for (let i = 0; i < fromDateInputs.length; i++) {
                    const fromDate = fromDateInputs[i].value;
                    const toDate = toDateInputs[i].value;
                    const dateCount = parseInt(dateCountInputs[i].value, 10);

                    if (fromDate && toDate && !isNaN(dateCount)) {
                        const maxDays = calculateDateDifference(fromDate,
                            toDate);

                        if (dateCount > maxDays) {
                            dateCountInputs[i].classList.add('is-invalid');
                            document.getElementById('date_count_error').innerText =
                                'Working days cannot be more than the date range.';
                        } else {
                            dateCountInputs[i].classList.remove('is-invalid');
                            document.getElementById('date_count_error').innerText = '';
                        }
                    } else {
                        dateCountInputs[i].classList.remove('is-invalid');
                        document.getElementById('date_count_error').innerText = '';
                    }
                }
            }

            fromDateInputs.forEach(input => {
                input.addEventListener('change', validateDateCount);
            });

            toDateInputs.forEach(input => {
                input.addEventListener('change', validateDateCount);
            });

            dateCountInputs.forEach(input => {
                input.addEventListener('input', validateDateCount);
            });
        };
    </script>
    <script>
        let fileIndex = 1;
        let currentInputFile = null; // Store the current file input element for discard functionality

        document.getElementById('add-more').addEventListener('click', function() {
            const fileInputWrapper = document.createElement('div');
            fileInputWrapper.classList.add('file-input-wrapper', 'mt-2');

            fileInputWrapper.innerHTML = `
        <div class="d-flex align-items-center">
            <input type="file" name="certificate_proof[]" id="certificate_proof_${fileIndex}" class="form-control fixed-width" data-id="${fileIndex}" accept="application/pdf">
            <span class="text-danger small" id="certificate_proof_${fileIndex}_error"></span>
            <i class="fa fa-trash text-danger remove-file ml-3"></i>
        </div>
    `;

            document.getElementById('file-inputs').appendChild(fileInputWrapper);
            fileIndex++;
        });

        document.getElementById('file-inputs').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-file')) {
                const wrapper = e.target.closest('.file-input-wrapper');
                wrapper.remove();
            }
        });

        document.getElementById('file-inputs').addEventListener('change', function(e) {
            if (e.target && e.target.type === 'file') {
                const inputFile = e.target;
                const file = inputFile.files[0];
                currentInputFile = inputFile; // Keep track of the current input element
                if (file && file.type === 'application/pdf') {
                    const pdfUrl = URL.createObjectURL(file);
                    document.getElementById('pdfViewer').src = pdfUrl;
                    $('#pdfModal').modal('show');
                } else {
                    alert('Please upload a valid PDF file.');
                    inputFile.value = '';
                }
            }
        });

        document.getElementById('discardFile').addEventListener('click', function() {
            if (currentInputFile) {
                currentInputFile.value = '';
                $('#pdfModal').modal('hide');
                currentInputFile = null;
            }
        });
    </script>
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>
@endsection
