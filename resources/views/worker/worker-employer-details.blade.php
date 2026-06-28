@extends('layouts.user-app')

@section('title', ' Home')

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




        .bold {
            font-weight: 600;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 12px;
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

        .custom-date {
            background-color: white
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
    @include('components.multistep')
    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light" style="border-radius: 20px;">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            @include('components.session-timeout')
                        </div>

                    </div>
                </div>
            </nav>
            <div class="card mt-2">
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
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; 90 Days Certificate
                                    Details&nbsp;&nbsp;| (Application No -
                                    {{ $formdata->application_no }})
                                </span>

                            </div>

                            <div class="mr-3 mt-3 ml-3"
                                style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                <p style="margin: 0;">
                                    <strong>Note:</strong><span class="text-danger"> (*) Marked are mandatory fields</span>
                                </p>
                            </div>

                            <form action="{{ route('save-employer-data') }}" class="form-group mr-2 ml-2"
                                enctype="multipart/form-data" method="post" id="employer">
                                @csrf
                                <div class="container-fluid text-center mt-4">
                                    <div class="table-container">
                                        <table class="table" id="user_table">
                                            <thead>
                                                <tr>
                                                    {{-- <th scope="col">Serial No</th> --}}
                                                    <th scope="col" class="bold">Type of Issuer<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Name of Issuing Organization /
                                                        Owner<span class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Issue Date<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Name of Issuing Person<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Contact No of Issuing Person<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Type Of Construction Work<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Is Issuer & Employer Same<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Employer Name (Contact Person)<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Employer Contact Number<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Work Start Date<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Work End Date<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Actual no of Working Days<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Type of Employer<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Profession<span
                                                            class="text-danger">*</span></th>
                                                    <th scope="col" class="bold">Upload Certificate<span
                                                            class="text-danger">*</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="dropdown fixed-width">
                                                        <select name="type_of_issuer[]" class="form-control"
                                                            id="issuer_type_1" onchange="checkIssuer(1)">
                                                            <option value="">Select Issuer</option>
                                                            @foreach ($type_of_issuer as $issuer)
                                                                <option value="{{ $issuer->issuer_code }}">
                                                                    {{ $issuer->issuer_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger success"
                                                            id="type_of_issuer.0_error"></span>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="issuing_org[]"
                                                            class="fixed-width form-control " data-id="1"
                                                            id="issuing_org_1" placeholder="Issuing Organisation">
                                                        <span class="text-danger success issuing_org"
                                                            id="issuing_org.0_error"></span>
                                                    </td>

                                                    <td class="fixed-width">
                                                        <input type="text" placeholder="DD-MM-YYYY" name="issue_date[]"
                                                            value=""
                                                            class="form-control white-background  issue-date issue"
                                                            id="issue_date">
                                                        <span class="text-danger success" id="issue_date.0_error"></span>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="issuing_person[]"
                                                            class="fixed-width form-control  issuing_person"
                                                            data-id="1" id="issuing_person_1"
                                                            placeholder="Issuing Person" />
                                                        <span class="text-danger success"
                                                            id="issuing_person.0_error"></span>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            onkeypress="return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));"
                                                            name="contact_issuing_person[]"
                                                            class="fixed-width form-control  contact_issuing_person"
                                                            data-id="1" id="contact_issuing_person_1" maxlength="10"
                                                            placeholder="Enter 10 digit Phone Number"
                                                            onchange="toogleIssameInput(1)" />
                                                        <span class="text-danger success"
                                                            id="contact_issuing_person.0_error"></span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center" style="min-width: 230px">
                                                            <select
                                                                class="form-control fixed-width error-message @if ($errors->has('type_of_work')) is-invalid @endif"
                                                                name="type_of_work[]" data-id="1" id="type_of_work_1"
                                                                onchange="checkTypeOfWorkOthers(1)">
                                                                <option value="">Select Type of work</option>
                                                                @foreach ($worktype as $work)
                                                                    <option value="{{ $work->work_type_code }}">
                                                                        {{ $work->work_type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="text" name="type_of_work_others[]"
                                                                id="type_of_work_others_1"
                                                                class="ml-4 d-none fixed-width form-control"
                                                                placeholder="Enter Other Type Of Work" />
                                                        </div>
                                                        <span class="text-danger success"
                                                            id="type_of_work.0_error"></span>
                                                    </td>
                                                    <td class="fixed-width">
                                                        <select name="is_same[]" data-id="1" id="issame_1"
                                                            onchange="toogleIssameInput(1)"
                                                            class="form-control  issame readonly-select">
                                                            <option value="">Select
                                                            </option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                        <span class="text-danger success" id="is_same.0_error"></span>
                                                    </td>
                                                    <td>
                                                        <input readonly type="text" name="employer_name_certi[]"
                                                            class="fixed-width form-control  employer_name_certi"
                                                            data-id="1" id="employer_name_certi_1"
                                                            placeholder="Enter Employer Name" />
                                                        <span class="text-danger success"
                                                            id="employer_name_certi.0_error"></span>
                                                    </td>

                                                    <td>
                                                        <input readonly type="text"
                                                            onkeypress="return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));"
                                                            name="employer_contact_number[]"
                                                            class="fixed-width form-control  employer_contact_number"
                                                            data-id="1" id="employer_contact_number_1" maxlength="10"
                                                            placeholder="Enter 10 digit Phone Number" />
                                                        <span class="text-danger success"
                                                            id="employer_contact_number.0_error"></span>
                                                    </td>

                                                    <td class="fixed-width"><input placeholder="DD-MM-YYYY"
                                                            type="text" name="from_date[]" id="from_date_1"
                                                            value="{{ old('from_date[]') }}"
                                                            class="form-control  fixed-width from-date white-background" />
                                                        <span class="text-danger success" id="from_date.0_error"></span>
                                                    </td>

                                                    <td class="fixed-width"><input placeholder="DD-MM-YYYY"
                                                            type="text" name="to_date[]" id="to_date_1"
                                                            value="{{ old('to_date[]') }}"
                                                            class="form-control  fixed-width to-date white-background" />
                                                        <span class="text-danger success" id="to_date.0_error"></span>
                                                    </td>


                                                    <td class="fixed-width"><input type="number" name="date_count[]"
                                                            class="date_count form-control" id="date_count_1"
                                                            placeholder="Working Days" min="0"
                                                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" />
                                                        <span class="text-danger success" id="date_count_error"></span>
                                                    </td>
                                                    </td>
                                                    <td class="fixed-width">
                                                        <select name="type_of_employer[]" id="type_of_employer_1"
                                                            class="form-control fixed-width readonly-select">
                                                            <option value="">Select employer</option>
                                                            @foreach ($type_of_employers as $employers)
                                                                <option value="{{ $employers->employer_code }}">
                                                                    {{ $employers->employer_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger success"
                                                            id="type_of_employer.0_error"></span>
                                                    </td>

                                                    <td class="dropdown fixed-width">
                                                        <div class="d-flex align-items-center" style="min-width: 350px">
                                                            <select name="profession[]" class="form-control"
                                                                id="profession_1" onchange="checkOthers(1)">
                                                                <option value="">Select Profession</option>
                                                                @foreach ($professions as $profession)
                                                                    <option value="{{ $profession->profession_code }}">
                                                                        {{ $profession->profession_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="text" name="profession_others[]"
                                                                id="others_1"
                                                                class="ml-4 d-none fixed-width form-control"
                                                                placeholder="Enter Other Profession" />
                                                        </div>
                                                        <span class="text-danger success"
                                                            id="profession_others.0_error"></span>
                                                    </td>


                                                    <td class="fixed-width">
                                                        <div id="file-inputs">
                                                            <div class="file-input-wrapper mb-3">
                                                                <div>
                                                                    <label for="certificate_proof_0"
                                                                        class="btn-primary mb-0">
                                                                        Choose File
                                                                    </label>
                                                                    <input type="file" name="certificate_proof[]"
                                                                        id="certificate_proof_0"
                                                                        class="form-control d-none" data-id="0"
                                                                        aria-label="Upload Certificate"
                                                                        accept="application/pdf">
                                                                    <button type="button"
                                                                        class="btn-danger btn-sm d-none preview-file-btn"
                                                                        id="preview_file_0">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                                <span class="text-danger small"
                                                                    id="certificate_proof.0_error"></span>
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



                                                        {{-- <input type="hidden" id="modal-file-name-"
                                                            name="modal_file_name">
                                                        <input type="hidden" id="modal-file-size-"
                                                            name="modal_file_size"> --}}

                                                    </td>



                                                    <span id="total_days_span"
                                                        class="text-info font-weight-normal"></span>


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
                                        <a type="submit" href="{{ route('submit-bank') }}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-backward"
                                                aria-hidden="true"></i>&nbsp;
                                            Previous</a>
                                        <button type="submit" class="btn btn-sm btn-primary" id="saveEmployerBtn">
                                            <span id="saveBtnText">
                                                <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                                Save Employer & Certificate
                                            </span>
                                            <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"
                                                role="status" aria-hidden="true"></span>
                                        </button>
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
    <script src="{{ URL::asset('assets/template/js/worker-employer-details-styles.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/session-timeout.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
    <script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('employer');
            const saveBtn = document.getElementById('saveEmployerBtn');
            const saveBtnText = document.getElementById('saveBtnText');
            const saveBtnSpinner = document.getElementById('saveBtnSpinner');

            if (form && saveBtn) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (saveBtn.disabled) return;
                    saveBtn.disabled = true;
                    saveBtnText.classList.add('d-none');
                    saveBtnSpinner.classList.remove('d-none');

                    const formData = new FormData(form);

                    fetch(form.action)
                        .then(response => response.json())
                        .then(data => {
                            saveBtn.disabled = false;
                            saveBtnText.classList.remove('d-none');
                            saveBtnSpinner.classList.add('d-none');

                            if (data.success) {
                                saveBtn.disabled = true;
                                saveBtnText.classList.add('d-none');
                                saveBtnSpinner.classList.remove('d-none');
                            } else {
                                if (data.errors) {
                                    console.error(data.errors);
                                }
                            }
                        })
                        .catch(error => {
                            console.error("Submission Error:", error);
                            saveBtn.disabled = false;
                            saveBtnText.classList.remove('d-none');
                            saveBtnSpinner.classList.add('d-none');
                        });
                });
            }
        });
    </script>

    <script>
        document.addEventListener('change', function(e) {
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
                    const discardButton = document.querySelector('#pdfModal .decline-btn');
                    discardButton.setAttribute('data-file-id', `preview_file_${fileRowId}`);

                    document.getElementById('pdfViewer').src = pdfUrl;
                    $('#pdfModal').modal('show');
                } else {
                    alert('Please upload a valid PDF file.');
                    inputFile.value = '';
                }
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target && (e.target.classList.contains('preview-file-btn') || e.target.closest(
                    '.preview-file-btn'))) {
                const button = e.target.closest('.preview-file-btn');
                const pdfUrl = button.getAttribute('data-pdf-url');

                if (pdfUrl) {
                    document.getElementById('pdfViewer').src = pdfUrl;
                    const discardButton = document.querySelector('#pdfModal .decline-btn');
                    discardButton.setAttribute('data-file-id', button.id);

                    $('#pdfModal').modal('show');
                } else {
                    alert('No file available for preview.');
                }
            }
            if (e.target && e.target.classList.contains('decline-btn')) {
                const button = e.target;
                const fileId = button.getAttribute('data-file-id');
                const fileRowId = fileId.split('_').pop();
                const inputFile = document.getElementById(`certificate_proof_${fileRowId}`);
                const previewButton = document.getElementById(fileId);

                if (inputFile && previewButton) {
                    inputFile.value = '';
                    previewButton.classList.add('d-none');
                    previewButton.removeAttribute('data-pdf-url');
                }
                $('#pdfModal').modal('hide');
            }
        });
    </script>

    <script>
        flatpickr(`input[name="issue_date[]"]`, {
            dateFormat: "d-m-Y",
            maxDate: new Date()
        });

        flatpickr(`input[name="from_date[]"]`, {
            dateFormat: "d-m-Y",
            maxDate: new Date()
        });

        flatpickr(`input[name="to_date[]"]`, {
            dateFormat: "d-m-Y",
            maxDate: new Date()
        });
    </script>

    <script>
        $(document).ready(function() {
            const currentDate = '<?php echo date('Y-m-d'); ?>';
            let count = $('tbody tr').length;
            let dynamicRowsData = [];

            /**
             * Adds a new dynamic row to the table body
             * @param {Number} number - Row identifier
             */
            function dynamic_field(number, data = null) {
                let html = `<tr>
            <td class="dropdown">
                <select name="type_of_issuer[` + count + `]" id="issuer_type_` + number +
                    `" class="form-control fixed-width" onchange="checkIssuer(` + number + `)">
                    <option value="">Select Issuer</option>`;
                @foreach ($type_of_issuer as $issuer)
                    html += `<option value="{{ $issuer->issuer_code }}">{{ $issuer->issuer_name }}</option>`;
                @endforeach
                html += `</select><span class="text-danger success" id="type_of_issuer.` + count + `_error"></span>
            </td>`;
                html += '<td><input placeholder="Issuing Organization" type="text" name="issuing_org[' + count +
                    ']" class="form-control fixed-width" id="issuing_org_' + number + '"/>' +
                    '<span class="text-danger success" id="issuing_org.' + count + '_error"></span></td>';

                html += '<td><input placeholder="DD-MM-YYYY" type="text" name="issue_date[' + count +
                    ']" id="issue_date" data-id="1" class="form-control issue issue-date white-background" max="' +
                    currentDate +
                    '" />' +
                    '<span class="text-danger success" id="issue_date.' + count + '_error"></span></td>';

                html += '<td><input placeholder="Issuing Person" type="text" name="issuing_person[' + count +
                    ']" class="form-control fixed-width" id="issuing_person_' + number + '"/>' +
                    '<span class="text-danger success" id="issuing_person.' + count + '_error"></span></td>';

                html += '<td><input placeholder="Enter 10 digit Phone Number" onchange="toogleIssameInput(' +
                    number + ')" type="text" name="contact_issuing_person[' + count +
                    ']" class="form-control fixed-width" maxlength="10" id="contact_issuing_person_' + number +
                    '">' +
                    '<span class="text-danger success" id="contact_issuing_person.' + count +
                    '_error"></span></td>';

                html += `<td class="dropdown">
                <div class="d-flex align-items-center" style="min-width: 400px;">
                    <select name="type_of_work[` + count + `]"
                            id="type_of_work_` + number + `"
                            class="form-control fixed-width" onChange="checkTypeOfWorkOthers(` + number + `)">
                        <option value="">Select Type Of Work</option>`;

                @foreach ($worktype as $work)
                    html += `<option value="{{ $work->work_type_code }}">{{ $work->work_type_name }}</option>`;
                @endforeach
                html += ` </select>
                                <input type="text"
                                    name="type_of_work_others[` + count + `]"
                                    id="type_of_work_others_` + number + `"
                                    class="ml-4 d-none fixed-width form-control"
                                    placeholder="Enter Other Type Of Work" />
                            </div>
                            <span class="text-danger success" id="type_of_work.` + count + `_error"></span>
                        </td>`;

                html += '<td><select id="issame_' + number + '" name="is_same[' + count +
                    ']" class="form-control" onchange="toogleIssameInput(' + number + ')">';
                html += '<option value="">Select</option>';
                html += '<option value="1">Yes</option>';
                html += '<option value="0">No</option>';
                html += '</select><span class="text-danger success" id="is_same.' + count + '_error"></span></td>';

                html += '<td><input placeholder="Enter Employer Name" type="text" id="employer_name_certi_' +
                    number +
                    '" name="employer_name_certi[' + count +
                    ']" class="form-control fixed-width" maxlength="10" readonly>' +
                    '<span class="text-danger success" id="employer_name_certi.' + count + '_error"></span></td>';

                // html += '<td><input type="text" id="employer_contact_name_' + number +
                //     '" name="employer_contact_name[' + count +
                //     ']" class="form-control fixed-width" maxlength="10" readonly>' +
                //     '<span class="text-danger success" id="employer_contact_name.' + count + '_error"></span></td>';

                html +=
                    '<td><input placeholder="Enter 10 digit Phone Number" type="text" id="employer_contact_number_' +
                    number +
                    '" name="employer_contact_number[' + count +
                    ']" class="form-control fixed-width" maxlength="10" readonly>' +
                    '<span class="text-danger success" id="employer_contact_number.' + count +
                    '_error"></span></td>';

                html += '<td><input placeholder="DD-MM-YYYY" type="text" name="from_date[' + count +
                    ']" id="from_date_' + number +
                    '" data-id="1" class="form-control from-date white-background" max="' + currentDate + '" />' +
                    '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';

                html += '<td><input placeholder="DD-MM-YYYY" type="text" name="to_date[' + count +
                    ']" id="to_date_' + number +
                    '" data-id="1" class="form-control to-date white-background" max="' + currentDate + '" />' +
                    '<span class="text-danger success" id="to_date.' + count + '_error"></span></td>';

                html +=
                    '<td><input placeholder="Working Days" type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" name="date_count[' +
                    count + ']" id="date_count_' + number +
                    '" class="form-control date_count" /></td>';

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

                html += `<td class="dropdown">
                <div class="d-flex align-items-center" style="min-width: 400px">
                <select name="profession[` + count +
                    `]" class="form-control fixed-width" id="profession_` + number +
                    `" onChange="checkOthers(` + number + `)">
                    <option value="">Select Employer</option>`;
                @foreach ($professions as $profession)
                    html +=
                        `<option value="{{ $profession->profession_code }}">{{ $profession->profession_name }}</option>`;
                @endforeach
                html += '</select><input name="profession_others[' + count + ']" type="text" id="others_' + number +
                    '" class="ml-4 d-none fixed-width form-control" placeholder="Enter Other Profession"/></div> <span class="text-danger success" id="profession_others.' +
                    count +
                    '_error"></span></td>';

                html += `
                <td>
                <div id="file-inputs">
                    <div class="file-input-wrapper mb-3">
                    <div>
                        <label for="certificate_proof_${count}" class="btn btn-primary mb-0">Choose File</label>
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
                // html += '<td><button type="submit" class="btn-sm btn-success">Upload</button></td>';

                html +=
                    '<td><button type="button" name="remove" id="" class="btn btn-sm  remove"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button></td></tr>';
                $('tbody').append(html);

                flatpickr(`input[name="issue_date[${count}]"]`, {
                    dateFormat: "d-m-Y", // ddmmyyyy format
                    maxDate: new Date() // Restrict selection to today or earlier
                });

                flatpickr(`input[name="from_date[${count}]"]`, {
                    dateFormat: "d-m-Y", // ddmmyyyy format
                    maxDate: new Date() // Restrict selection to today or earlier
                });

                flatpickr(`input[name="to_date[${count}]"]`, {
                    dateFormat: "d-m-Y", // ddmmyyyy format
                    maxDate: new Date() // Restrict selection to today or earlier
                });
                count++;
            }



            function reAddDynamicRows() {
                for (let i = 0; i < dynamicRowsData.length; i++) {
                    dynamic_field(i + 1, dynamicRowsData[i]); // Passing index as count
                }
            }

            function convertDMYtoYMD(dateStr) {
                const parts = dateStr.split("-");
                if (parts.length !== 3) return null;

                const day = parts[0].padStart(2, '0');
                const month = parts[1].padStart(2, '0');
                const year = parts[2];

                return `${year}-${month}-${day}`;
            }

            function calculateDateDifference(row) {
                var fromDateR = row.find('.from-date').val();
                console.log(fromDate)
                var toDateR = row.find('.to-date').val();
                console.log(toDate)
                var fromDate = convertDMYtoYMD(fromDateR);
                console.log("Converted from date:", fromDate);

                var toDate = convertDMYtoYMD(toDateR);
                console.log("Converted to date:", toDate);

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
                console.log(differenceInDays)
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

            function DateDifference(row) {
                var fromDateRaw = row.find('.from-date').val();
                var fromDate = convertDMYtoYMD(fromDateRaw);
                var toDateRaw = row.find('.to-date').val();
                var toDate = convertDMYtoYMD(toDateRaw);
                var issueDateRaw = row.find('.issue-date').val();
                var issueDate = convertDMYtoYMD(issueDateRaw);

                if (!fromDate || !toDate || !issueDate) {
                    // If any date field is empty, no need for further validation
                    return;
                }

                if (toDate <= fromDate || issueDate > toDate) {
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

            // Validate manually entered working days
            $(document).on('input', '.date_count', function() {
                var row = $(this).closest('tr');
                var workingDays = parseInt($(this).val());
                var fromDateRa = row.find('.from-date').val();
                var fromDate = convertDMYtoYMD(fromDateRa);
                console.log(fromDate);
                var toDateRa = row.find('.to-date').val();
                var toDate = convertDMYtoYMD(toDateRa);
                console.log(toDate);
                if (!fromDate || !toDate || isNaN(workingDays)) {
                    return;
                }

                // Parse dates and set time to midnight
                var from = new Date(fromDate);
                console.log(from);
                var to = new Date(toDate);
                console.log(to);
                from.setHours(0, 0, 0, 0);
                to.setHours(0, 0, 0, 0);

                const differenceInMilliseconds = to - from;
                const maxDays = differenceInMilliseconds / (1000 * 60 * 60 * 24) + 1;
                console.log(maxDays);

                if (workingDays > maxDays) { // Use strict inequality
                    Swal.fire({
                        text: 'The number of working days cannot exceed the duration between From Date and To Date.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $(this).val('');
                }
            });


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
                // var fileInputs = $('input[name="certificate_proof[]"]');
                // var allFilesSelected = true;
                //
                // fileInputs.each(function() {
                //     if (this.files.length === 0) {
                //         allFilesSelected = false;
                //     }
                // });
                //
                // if (!allFilesSelected) {
                //     Swal.fire({
                //         title: 'Missing Files',
                //         text: 'Please upload at least one certificate proof file.',
                //         icon: 'error',
                //         confirmButtonText: 'OK'
                //     });
                //     return; // Stop the submission process
                // }

                var formData = new FormData(this);

                // Debugging formData
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('save-employer-data') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Toastify({
                                text: "Certificate Details Submitted Successfully!",
                                duration: 2000,
                                gravity: "top",
                                position: "right",
                                style: { background: "#28a745" }
                            }).showToast();

                            // Redirect after a short delay so user sees the message
                            setTimeout(function() {
                                window.location.href = "{{ route('submit-employer-details') }}";
                            }, 1500);

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
            if (issuerType == 7 || issuerType == 8 || issuerType == 9) {
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
        function checkOthers(number) {
            var othersSelect = document.getElementById('others_' + number);
            var professionType = document.getElementById('profession_' + number).value;
            console.log(professionType);

            if (professionType == 28) {
                othersSelect.classList.remove('d-none');
            } else {
                othersSelect.classList.add('d-none');
            }
        }

        function checkTypeOfWorkOthers(number) {
            var othersSelect = document.getElementById('type_of_work_others_' + number);
            var workType = document.getElementById('type_of_work_' + number).value;

            if (workType == 5) {
                othersSelect.classList.remove('d-none');
            } else {
                othersSelect.classList.add('d-none');
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
        @if (session('alert_shown'))

            Swal.fire({
            icon: 'success',
            title: 'Family details submitted!',
            text: '{{ session('success ') }}',
            showConfirmButton: false,
            timer: 3000
        });
        @endif
    </script>
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>
@endsection
