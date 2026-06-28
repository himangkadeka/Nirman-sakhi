@extends('layouts.user-app')

@section('title', 'Renewal|Workbook Details')

@section('style')
    <style>
        .table input.form-control,
        .table select.form-select {
            min-width: 160px;
            padding: 6px 10px;
            font-size: 14px;
        }
        .fixed-width-up{
            min-width: 180px;
        }
        /* Table Header Style */
        .table thead th {
            font-size: 14px;
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

        #add {
            border-radius: 1.5rem;
            transition: background-color 0.3s, transform 0.2s;
        }

        #add:hover {
            background-color: black;
            color: #FFFFFF;/* slightly darker than .btn-info */
            transform: scale(1.02);
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

        /* Responsive tweaks */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table th,
            .table td {
                white-space: nowrap;
            }

            .table input.form-control,
            .table select.form-select {
                min-width: 140px;
            }
        }

        /* Custom spacing for file input buttons */
        .file-input-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }


        /* Style error messages */
        .text-danger.small {
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        /* Date input style */
        input[type="text"].from-date,
        input[type="text"].to-date {
            background-color: #f9f9f9;
        }

        /* Style modal PDF viewer if needed */
        #pdfViewer {
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .worker-dashboard {
            width: 100% !important;
            max-width: 100% !important; /* This removes the 1200px limit */
            margin: 0;
            padding-top: 0px;

        }

    </style>
@endsection


@section('content')

    <div class="container-fluid worker-dashboard mb-4">
        <div class="row">
            <div class="col-md-12">
                <nav class="custom-navbar navbar-light p-3" style="border-radius: 20px;">
                </nav>
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                     style="background-color: #248f8f;">
                                    <span>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Update Workbook
                                    </span>
                                    <span>
                                        <i class="fa fa-user" aria-hidden="true"></i> Worker Name -
                                        {{ $getVaultData['name'] }}
                                    </span>
                                </div>
                                <div class="mr-3 mt-3 ml-3"
                                     style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                    <p style="margin: 0;">
                                        <strong>Note:</strong><span class="text-danger"> (*) Marked are mandatory fields</span>
                                    </p>
                                </div>
                                <form class="form-group ml-2 mr-2"
                                      enctype="multipart/form-data" method="post" id="employer">
                                    @csrf
                                    <div class="container-fluid text-center mt-4">
                                        <div class="container">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped align-middle" id="user_table">
                                                    <thead class="table-light text-center">
                                                    <tr>
                                                        <th>Type Of Construction Work <span class="text-danger">*</span></th>
                                                        <th>Start Date <span class="text-danger">*</span></th>
                                                        <th>End Date <span class="text-danger">*</span></th>
                                                        <th>Working Days <span class="text-danger">*</span></th>
                                                        <th>Employer Name <span class="text-danger">*</span></th>
                                                        <th>Contact Number <span class="text-danger">*</span></th>
                                                        <th>Employer Type <span class="text-danger">*</span></th>
                                                        <th>Profession <span class="text-danger">*</span></th>
                                                        <th>Workbook <span class="text-danger">*</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for ($i = 0; $i < $total_years_since_last_renewal; $i++)

                                                        <tr>
                                                            <!-- Type of Work -->
                                                            <td>
                                                                <select name="type_of_work[]" id="type_of_work_{{ $i+1 }}" class="form-select form-control">
                                                                    <option value="">Select</option>
                                                                    @foreach ($worktype as $work)
                                                                        <option value="{{ $work->work_type_code }}">{{ $work->work_type_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="text-danger small" id="type_of_work.{{ $i }}_error"></div>
                                                            </td>

                                                            <!-- Start Date -->
                                                            <td>
                                                                <input type="text" name="from_date[]" id="from_date_{{ $i+1 }}" class="form-control" placeholder="DD-MM-YYYY"
                                                                       value="{{ $date_ranges[$i]['from'] }}" readonly="">
                                                                <div class="text-danger small" id="from_date.{{ $i }}_error"></div>
                                                            </td>

                                                            <!-- End Date -->
                                                            <td>
                                                                <input type="text" name="to_date[]" id="to_date_{{ $i+1 }}" class="form-control" placeholder="DD-MM-YYYY"
                                                                       value="{{ $date_ranges[$i]['to'] }}" readonly>
                                                                <div class="text-danger small" id="to_date.{{ $i }}_error"></div>
                                                            </td>

                                                            <!-- Working Days -->
                                                            <td>
                                                                <input type="number" name="date_count[]" id="date_count_{{ $i+1 }}" class="form-control" min="0">
                                                                <div class="text-danger small" id="date_count.{{ $i }}_error"></div>
                                                            </td>

                                                            <!-- Employer Name -->
                                                            <td>
                                                                <input type="text" name="employer_name_certi[]" id="employer_name_certi_{{ $i+1 }}" class="form-control">
                                                                <div class="text-danger small" id="employer_name_certi.{{ $i }}_error"></div>
                                                            </td>

                                                            <!-- Contact Number -->
                                                            <td>
                                                                <input type="text" name="employer_contact_number[]" id="employer_contact_number_{{ $i+1 }}" class="form-control" maxlength="10" onkeypress="return /\d/.test(event.key)">
                                                                <div class="text-danger small" id="employer_contact_number.{{ $i }}_error"></div>
                                                            </td>

                                                            <!-- Employer Type -->
                                                            <td>
                                                                <select name="type_of_employer[]" id="type_of_employer_{{ $i+1 }}" class="form-select form-control">
                                                                    <option value="">Select</option>
                                                                    @foreach ($type_of_employers as $employers)
                                                                        <option value="{{ $employers->employer_code }}">{{ $employers->employer_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="text-danger small" id="type_of_employer.{{ $i }}_error"></div>
                                                            </td>

                                                            <!-- Profession -->
                                                            <td>
                                                                <select name="profession[]" id="profession_{{ $i+1 }}" class="form-select form-control" onchange="checkOthers({{ $i+1 }})">
                                                                    <option value="">Select</option>
                                                                    @foreach ($professions as $profession)
                                                                        <option value="{{ $profession->profession_code }}">{{ $profession->profession_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="text" name="profession_others[]" id="others_{{ $i+1 }}" class="form-control mt-2 d-none" placeholder="Other Profession">
                                                                <div class="text-danger small" id="profession_others.{{ $i }}_error"></div>
                                                                <div class="text-danger small" id="profession.{{ $i }}_error"></div>
                                                            </td>

                                                            <td class="fixed-width-up">
                                                                <div id="file-inputs">
                                                                    <div class="file-input-wrapper mb-3">
                                                                        <div>
                                                                            <label for="certificate_proof_{{$i+1}}" class="btn btn-primary btn-sm mb-0">
                                                                                Choose File
                                                                            </label>

                                                                            <input type="file" name="certificate_proof[]"
                                                                                   id="certificate_proof_{{$i+1}}"
                                                                                   class="form-control d-none"
                                                                                   data-id="{{$i+1}}"
                                                                                   accept="application/pdf">
                                                                            <button type="button"
                                                                                    class="btn btn-danger d-none preview-file-btn"
                                                                                    id="preview_file_{{$i+1}}">
                                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                                            </button>
                                                                        </div>
                                                                        <span class="text-danger small"
                                                                              id="certificate_proof.{{$i+1}}_error"></span>
                                                                    </div>
                                                                </div>

                                                                <!-- Modal for PDF Preview -->
                                                                <div class="modal fade" id="pdfModal" tabindex="-1"
                                                                     role="dialog" aria-labelledby="pdfModalLabel"
                                                                     aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="pdfModalLabel">PDF
                                                                                    Preview</h5>
                                                                                <button type="button" class="close"
                                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <iframe id="pdfViewer"
                                                                                        style="width: 100%; height: 500px;"
                                                                                        frameborder="0"></iframe>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                        class="btn btn-danger decline-btn"
                                                                                        data-file-id="preview_file_0"
                                                                                        data-bs-dismiss="modal">Discard</button>
                                                                                <button type="button" class="btn btn-primary"
                                                                                        data-bs-dismiss="modal">Upload</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </td>
                                                        </tr>

                                                    @endfor
                                                    </tbody>

                                                </table>
                                            </div>



                                            <!-- Modal -->
                                            <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">PDF Preview</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <iframe id="pdfViewer" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger decline-btn" data-file-id="" data-input-id="" data-bs-dismiss="modal">Discard</button>
                                                            <button type="button" class="btn btn-primary confirm-upload-btn" data-bs-dismiss="modal">Upload</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{--<button type="button" name="add" id="add" class="btn btn-danger btn-sm mt-3 ml-2 shadow-sm d-flex align-items-center gap-1">--}}
                                        {{--<i class="fa fa-plus-circle"></i>&nbsp;--}}
                                        {{--<span>Add New Row</span>--}}
                                    {{--</button>--}}

                                    <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                        <div class="ml-auto d-inline-block align-self-center mr-2">
                                            {{--<a type="submit" href="{{ route('preview-renewal-application') }}"--}}
                                               {{--class="btn btn-sm btn-warning"><i class="fa fa-backward"--}}
                                                                                 {{--aria-hidden="true"></i>&nbsp;--}}
                                                {{--Previous</a>--}}
                                            <button type="submit" class="btn btn-sm btn-primary"><i
                                                        class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                                Save Workbook Details</button>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                        <button  class="btn btn-sm btn-primary" id="btnSaveRenewal" style="display: none;">
                                            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp; Submit Renewal Application
                                        </button>

                                    </div>
<!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this item?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                                                </div>
                                            </div>
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
    <link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
    <script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        document.addEventListener('change', function (e) {
            if (e.target && e.target.type === 'file' && e.target.id.startsWith('certificate_proof_')) {
                const inputFile = e.target;
                const file = inputFile.files[0];
                const inputIdParts = inputFile.id.split('_');
                const fileRowId = inputIdParts[inputIdParts.length - 1];

                if (file && file.type === 'application/pdf') {
                    const pdfUrl = URL.createObjectURL(file);

                    const previewButton = document.getElementById(`preview_file_${fileRowId}`);
                    previewButton.classList.remove('d-none');
                    previewButton.setAttribute('data-pdf-url', pdfUrl);

                    const discardBtn = document.querySelector('#pdfModal .decline-btn');
                    discardBtn.setAttribute('data-file-id', `preview_file_${fileRowId}`);
                    discardBtn.setAttribute('data-input-id', `certificate_proof_${fileRowId}`);

                    // Just preview
                    document.getElementById('pdfViewer').src = pdfUrl;
                    const uploadBtn = document.querySelector('.confirm-upload-btn');
                    uploadBtn.setAttribute('data-bs-dismiss', 'modal'); // just closes modal
                    $('#pdfModal').modal('show');
                } else {
                    alert('Please upload a valid PDF file.');
                    inputFile.value = '';
                }
            }
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.preview-file-btn')) {
                const button = e.target.closest('.preview-file-btn');
                const pdfUrl = button.getAttribute('data-pdf-url');

                if (pdfUrl) {
                    document.getElementById('pdfViewer').src = pdfUrl;

                    const discardButton = document.querySelector('#pdfModal .decline-btn');
                    discardButton.setAttribute('data-file-id', button.id);

                    const inputId = button.id.replace('preview_file_', 'certificate_proof_');
                    discardButton.setAttribute('data-input-id', inputId);

                    $('#pdfModal').modal('show');
                } else {
                    alert('No file available for preview.');
                }
            }

            // Discard logic
            if (e.target && e.target.classList.contains('decline-btn')) {
                const fileId = e.target.getAttribute('data-file-id');
                const inputId = e.target.getAttribute('data-input-id');

                const inputFile = document.getElementById(inputId);
                const previewButton = document.getElementById(fileId);

                if (inputFile && previewButton) {
                    inputFile.value = '';
                    previewButton.classList.add('d-none');
                    previewButton.removeAttribute('data-pdf-url');
                }

                document.getElementById('pdfViewer').src = '';
                $('#pdfModal').modal('hide');
            }

            // Upload confirmation (do nothing — file already selected in form)
            if (e.target && e.target.classList.contains('confirm-upload-btn')) {
                // Optional: show a toast or visual confirmation
                console.log('File will be uploaded with form submission');
            }
        });
    </script>



    <script>
        $(document).ready(function() {
            const currentDate = '<?php echo date('Y-m-d'); ?>';
            let count = $('tbody tr').length;
            let dynamicRowsData = [];

            function dynamic_field(number, data = null) {
                let html = `<tr>
            <td class="dropdown">
                <select name="type_of_work[` + count + `]" class="form-control fixed-width">
                    <option value="">Select</option>`;
                @foreach ($worktype as $work)
                    html +=
                    `<option value="{{ $work->work_type_code }}">{{ $work->work_type_name }}</option>`;
                @endforeach
                    html += '</select><span class="text-danger small success" id="type_of_work.' + count +
                    '_error"></span></td>';
                html += '<td><input type="text" name="from_date[' + count + ']" id="from_date_' + number +
                    '" data-id="1" placeholder="DD-MM-YYYY" class="form-control from-date" max="' + currentDate + '" />' +
                    '<span class="text-danger small success" id="to_date.' + count + '_error"></span></td>';

                html += '<td><input type="text" placeholder="DD-MM-YYYY" name="to_date[' + count + ']" id="to_date_' + number +
                    '" data-id="1" class="form-control to-date" max="' + currentDate + '" />' +
                    '<span class="text-danger small success" id="to_date.' + count + '_error"></span></td>';

                html += '<td><input type="text" name="date_count[' + count + ']" id="date_count_' + number +
                    '" class="form-control small date_count" />' +
                    '<span class="text-danger small success" id="to_date.' + count + '_error"></span></td>';

//                html += '<td><select id="issame_' + number + '" name="is_same[' + count +
//                    ']" class="form-control" onchange="toogleIssameInput(' + number + ')">>';
//                html += '<option value="">Select</option>';
//                html += '<option value="1">Yes</option>';
//                html += '<option value="0">No</option>';
//                html += '</select><span class="text-danger success" id="is_same.' + count + '_error"></span></td>';

                html += '<td><input type="text" id="employer_name_certi_' + number +
                    '" name="employer_name_certi[' + count +
                    ']" class="form-control fixed-width" maxlength="10">' +
                    '<span class="text-danger small success" id="employer_name_certi.' + count + '_error"></span></td>';

                html += '<td><input type="text" id="employer_contact_number_' + number +
                    '" name="employer_contact_number[' + count +
                    ']" class="form-control fixed-width" maxlength="10">' +
                    '<span class="text-danger small success" id="employer_contact_number.' + count +
                    '_error"></span></td>';



                html += `<td class="dropdown">
                <select name="type_of_employer[` + count +
                    `]" class="form-control fixed-width" id="type_of_employer_` + number +
                    `">
                    <option value="">Select</option>`;
                @foreach ($type_of_employers as $employer)
                    html +=
                    `<option value="{{ $employer->employer_code }}">{{ $employer->employer_name }}</option>`;
                @endforeach
                    html += '</select><span class="text-danger small success" id="type_of_employer.' + count +
                    '_error"></span></td>';

                // html += '<td><button type="submit" class="btn-sm btn-success">Upload</button></td>';
                html += `<td class="dropdown">
                <div class="d-flex align-items-center">
                <select name="profession[` + count +
                    `]" class="form-control fixed-width" id="profession_` + number +
                    `" onChange="checkOthers(` + number + `)">
                    <option value="">Select</option>`;
                @foreach ($professions as $profession)
                    html +=
                    `<option value="{{ $profession->profession_code }}">{{ $profession->profession_name }}</option>`;
                @endforeach
                    html += '</select><input name="profession_others[' + count + ']" type="text" id="others_' + number +
                    '" class="ml-4 d-none fixed-width form-control" placeholder="Enter Other Profession"/></div> <span class="text-danger small success" id="profession.' +
                    count +
                    '_error"></span></td>';
                html += `<td>
                <div id="file-inputs">
                    <div class="file-input-wrapper mb-3">
                    <div>
                        <label for="certificate_proof_${count}">Choose File</label>
                        <input type="file" name="certificate_proof[${count}]" id="certificate_proof_${count}"
                            class="form-control d-none" data-id="${count}"
                            aria-label="Upload Certificate" accept="application/pdf">
                        <button type="button" class="btn btn-danger d-none preview-file-btn" id="preview_file_${count}">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                    <span class="text-danger small" id="certificate_proof.${count}_error"></span>
                    </div>
                </div>
                </td>`;


                html +=
                    '<td><button type="button" name="remove" id="" class="btn btn-sm  remove"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button></td></tr>';
                $('tbody').append(html);

//                flatpickr(`input[name="from_date[${count}]"]`, {
//                    dateFormat: "d-m-Y", // ddmmyyyy format
//                    maxDate: new Date() // Restrict selection to today or earlier
//                });
//
//                flatpickr(`input[name="to_date[${count}]"]`, {
//                    dateFormat: "d-m-Y", // ddmmyyyy format
//                    maxDate: new Date() // Restrict selection to today or earlier
//                });
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


                const differenceInMilliseconds = new Date(toDate) - new Date(fromDate);
                const differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);
                row.find('.days-difference').text('Days Difference: ' + differenceInDays.toFixed(0));
                row.find('.date_count').val(differenceInDays.toFixed(0));

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

            function DateDifference(row) {
                var fromDate = row.find('.from-date').val();
                var toDate = row.find('.to-date').val();
//                var issueDate = row.find('.issue-date').val();

                if (!fromDate || !toDate) {
                    // If any date field is empty, no need for further validation
                    return;
                }

                if (toDate <= fromDate) {
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
                    url: '{{ route('save-workbook-details') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            console.log(response.success);

                            window.location.href = "{{ route('preview-renewal-application', ['worker_id' => session('worker')->worker_id ?? '']) }}";
                            document.getElementById('btnSaveRenewal').style.display = 'inline-block';
                        } else {
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
        function updateMaxAttribute() {
            var today = new Date().toISOString().split('T')[0];
            $('input[type="date"]').each(function() {
                $(this).attr('max', today);
            });
        }

        updateMaxAttribute();
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
        function checkOthers(number) {
            var othersSelect = document.getElementById('others_' + number);
            var professionType = document.getElementById('profession_' + number).value;
            console.log(professionType);

            if (professionType === 28) {
                othersSelect.classList.remove('d-none');
            } else {
                othersSelect.classList.add('d-none');
            }
        }
    </script>
    <script>
        let fileIndex = 1; // Start indexing from 1 (or set to highest existing index)

        // Add more file inputs
        document.getElementById('add-more').addEventListener('click', function() {
            const fileInputWrapper = document.createElement('div');
            fileInputWrapper.classList.add('file-input-wrapper', 'mt-2');

            // Create unique IDs
            const inputId = `certificate_proof_${fileIndex}`;
            const errorId = `certificate_proof_${fileIndex}_error`;

            // Template for new file input
            fileInputWrapper.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <input type="file" name="certificate_proof[]" id="${inputId}" class="form-control fixed-width" data-id="${fileIndex}">
                <span class="text-danger" id="${errorId}"></span>
                <button type="button" class="btn btn-sm btn-outline-danger remove-file" title="Remove File">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;

            // Append to container
            document.getElementById('file-inputs').appendChild(fileInputWrapper);

            fileIndex++; // Increment for next input
        });

        // Delegate removal of file inputs
        document.getElementById('file-inputs').addEventListener('click', function(e) {
            if (e.target.closest('.remove-file')) {
                const wrapper = e.target.closest('.file-input-wrapper');
                if (wrapper) wrapper.remove();
            }
        });
    </script>

    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>
@endsection
