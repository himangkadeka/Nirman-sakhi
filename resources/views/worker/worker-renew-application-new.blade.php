@include('layout.workerheader')
@php
    use Carbon\Carbon;
@endphp
<style>

    .box{
        width: 98%;
        margin: 5px 5px 5px 5px;
    }

    tr.experience {
        border-left: 3px solid #fd3b4d; /* Blue accent border on left */
    }
    /* Consistent input widths */
    .table input.form-control,
    .table select.form-select {
        min-width: 160px;
        padding: 6px 10px;
        font-size: 13px;
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
        font-size: 12px;
        font-weight: 600;
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
        font-size: 13px;
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

    .preview-file-btn {
        padding: 4px 8px;
    }

    /* Style error messages */
    /*.text-danger.small {*/
    /*font-size: 12px;*/
    /*margin-top: 4px;*/
    /*display: block;*/
    /*}*/

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
    .text-danger small{
        font-size: 12px;
    }


</style>
<div class="d-flex" id="wrapper">
@include('worker.leftmenu')
<!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')
        {{--<ul class="breadcrumb">--}}
        {{--<li><a href="{{ route('worker-dashboard') }}">Dashboard</a></li>--}}
        {{--<li>Renewal</li>--}}
        {{--</ul>--}}


        <form class="needs-validation" enctype="multipart/form-data" method="post" id="employer" novalidate>
            @csrf
            <div class="container">
                <div class="card shadow-sm">
                    <div class="card-header text-dark">
                        <h6 class="mb-0"><i class="fas fa-briefcase"></i> Work Experience Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle" id="user_table">
                                <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap">Type Of Construction Work <span class="text-danger">*</span></th>
                                    <th class="text-nowrap">Start Date <span class="text-danger">*</span></th>
                                    <th class="text-nowrap">End Date <span class="text-danger">*</span></th>
                                    <th class="text-nowrap">Working Days <span class="text-danger">*</span></th>
                                    <th class="text-nowrap">Employer Name <span class="text-danger">*</span></th>
                                    <th class="text-nowrap">Employer Contact <span class="text-danger">*</span></th>
                                    <th class="text-nowrap">Type Of Employer <span class="text-danger">*</span></th>
                                    <th class="text-nowrap">Profession <span class="text-danger">*</span></th>
                                    <th class="text-nowrap">Workbook <span class="text-danger">*</span></th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(sizeof($twc)>0)
                                    @foreach($twc as $key => $workbook)
                                        <tr class="align-middle">
                                            <!-- Type of Work -->
                                            <td>
                                                <div class="input-group">
                                                    <select class="form-control @if ($errors->has('type_of_work')) is-invalid @endif"
                                                            name="type_of_work[]" id="type_of_work_{{ $loop->index + 1 }}"
                                                            onchange="checkTypeOfWorkOthers({{ $loop->index + 1 }})">
                                                        <option value="{{ $workbook->type_of_work }}" selected>
                                                            {{ $workbook->work_type_name }}
                                                        </option>
                                                        @foreach ($worktype as $work)
                                                            @if ($work->work_type_code != $workbook->type_of_work)
                                                                <option value="{{ $work->work_type_code }}">
                                                                    {{ $work->work_type_name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="type_of_work_others[]"
                                                           id="type_of_work_others_{{ $loop->index + 1 }}"
                                                           class="form-control d-none" placeholder="Specify work type">
                                                </div>
                                                <div class="text-danger" id="type_of_work.{{ $loop->index }}_error"></div>
                                            </td>

                                            <!-- Dates -->
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    <input type="text" name="from_date[]" value="{{ $workbook->from_date }}"
                                                           class="form-control datepicker" placeholder="DD-MM-YYYY"
                                                           id="from_date_{{ $loop->index + 1 }}">
                                                </div>
                                                <div class="text-danger" id="from_date.{{ $loop->index }}_error"></div>
                                            </td>

                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    <input type="text" name="to_date[]" value="{{ $workbook->to_date }}"
                                                           class="form-control datepicker" placeholder="DD-MM-YYYY"
                                                           id="to_date_{{ $loop->index + 1 }}">
                                                </div>
                                                <div class="text-danger" id="to_date.{{ $loop->index }}_error"></div>
                                            </td>

                                            <td>
                                                <input type="number" name="date_count[]" value="{{ $workbook->date_count }}"
                                                       class="form-control" placeholder="Days" min="1">
                                                <div class="text-danger" id="date_count.{{ $loop->index }}_error"></div>
                                            </td>

                                            <!-- Employer Info -->
                                            <td>
                                                <input type="text" name="employer_name_certi[]" value="{{ $workbook->emp }}"
                                                       class="form-control" placeholder="Employer name"
                                                       id="employer_name_certi_{{ $loop->index + 1 }}">
                                                <div class="text-danger" id="employer_name.{{ $loop->index }}_error"></div>
                                            </td>

                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    <input type="text" name="employer_contact_number[]"
                                                           value="{{ $workbook->employer_contact_number }}"
                                                           class="form-control" placeholder="Contact number"
                                                           maxlength="10" pattern="[0-9]{10}"
                                                           id="employer_contact_number_{{ $loop->index + 1 }}">
                                                </div>
                                                <div class="text-danger" id="employer_contact_number.{{ $loop->index }}_error"></div>
                                            </td>

                                            <td>
                                                <select name="type_of_employer[]" class="form-control"
                                                        id="type_of_employer_{{ $loop->index + 1 }}">
                                                    <option value="{{ $workbook->type_of_employer }}">
                                                        {{ $workbook->empname }}</option>
                                                    @foreach ($type_of_employers as $employers)
                                                        @if ($workbook->type_of_employer != $employers->employer_code)
                                                            <option value="{{ $employers->employer_code }}">
                                                                {{ $employers->employer_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="text-danger" id="type_of_employer.{{ $loop->index }}_error"></div>
                                            </td>

                                            <!-- Profession -->
                                            <td>
                                                <div class="input-group">
                                                    <select name="profession[]" class="form-control"
                                                            id="profession_{{ $loop->index + 1 }}" onchange="checkOthers({{ $loop->index + 1 }})">
                                                        <option value="{{ $workbook->profession }}" selected>
                                                            {{ $workbook->profession_name }}
                                                        </option>
                                                        @foreach ($professions as $profession)
                                                            @if ($profession->profession_code != $workbook->profession)
                                                                <option value="{{ $profession->profession_code }}">
                                                                    {{ $profession->profession_name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="profession_others[]"
                                                           id="others_{{ $loop->index + 1 }}"
                                                           value="{{ $workbook->profession_others ?? ''}}"
                                                           class="form-control d-none" placeholder="Other profession">
                                                </div>
                                                <div class="text-danger" id="profession.{{ $loop->index }}_error"></div>
                                            </td>

                                            <!-- File Upload -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <label for="certificate_proof_{{ $key }}" class="btn btn-sm btn-outline-primary me-2 mb-0">
                                                        <i class="fas fa-upload me-1"></i> Upload
                                                    </label>
                                                    <input type="hidden" name="certificate_proof_id[]"
                                                           value="{{ $workbook->certificate_proof_id }}">
                                                    <input type="file" name="certificate_proof[]"
                                                           id="certificate_proof_{{ $key }}" class="d-none"
                                                           accept="application/pdf">

                                                    @if($workbook->certificate_proof_id)
                                                        <a href="{{ route('view-work-book', ['id' => $workbook->certificate_proof_id]) }}"
                                                           class="btn btn-sm btn-outline-success me-2" target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif

                                                    <button type="button" class="btn btn-sm btn-outline-danger d-none preview-file-btn"
                                                            id="preview_file_{{ $key }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="text-danger" id="certificate_proof.{{ $key }}_error"></div>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @for ($i = 0; $i < $total_years_since_last_renewal; $i++)
                                        <tr class="align-middle">
                                            <!-- Type of Work -->
                                            <td>
                                                <select name="type_of_work[{{$i}}]" id="type_of_work_{{ $i }}"
                                                        class="form-control form-select" onchange="checkTypeOfWorkOthers({{ $i }})">
                                                    <option value="">Select work type</option>
                                                    @foreach ($worktype as $work)
                                                        <option value="{{ $work->work_type_code }}">
                                                            {{ $work->work_type_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="type_of_work_others[{{$i}}]"
                                                       id="type_of_work_others_{{ $i }}"
                                                       class="form-control mt-1 d-none" placeholder="Specify work type">
                                                <div class="text-danger" id="type_of_work_{{ $i }}_error"></div>
                                            </td>

                                            <!-- Dates -->
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="from_date[{{$i}}]"
                                                           value="{{ $date_ranges[$i]['from'] }}"
                                                           class="form-control datepicker" placeholder="DD-MM-YYYY"
                                                           id="from_date_{{ $i }}" readonly>
                                                </div>
                                                {{--<div class="text-danger" id="from_date_{{ $i }}_error"></div>--}}
                                            </td>

                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="to_date[{{$i}}]"
                                                           value="{{ $date_ranges[$i]['to'] }}"
                                                           class="form-control datepicker" placeholder="DD-MM-YYYY"
                                                           id="to_date_{{ $i }}" readonly>
                                                </div>
                                                {{--<div class="text-danger" id="to_date_{{ $i }}_error"></div>--}}
                                            </td>

                                            <td>
                                                <input type="number" name="date_count[{{$i}}]"
                                                       class="form-control" placeholder="Days" min="1"
                                                       id="date_count_{{ $i }}">
                                                <div class="text-danger" id="date_count_{{ $i }}_error"></div>
                                            </td>

                                            <!-- Employer Info -->
                                            <td>
                                                <input type="text" name="employer_name_certi[{{$i}}]"
                                                       class="form-control" placeholder="Employer name"
                                                       id="employer_name_certi_{{ $i }}">
                                                <div class="text-danger" id="employer_name_certi_{{ $i }}_error"></div>
                                            </td>

                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="employer_contact_number[{{$i}}]"
                                                           class="form-control" placeholder="Contact number"
                                                           maxlength="10" pattern="[0-9]{10}"
                                                           id="employer_contact_number_{{ $i }}">
                                                </div>
                                                <div class="text-danger" id="employer_contact_number_{{ $i }}_error"></div>
                                            </td>

                                            <td>
                                                <select name="type_of_employer[{{$i}}]" class="form-control form-select"
                                                        id="type_of_employer_{{ $i }}">
                                                    <option value="">Select employer type</option>
                                                    @foreach ($type_of_employers as $employers)
                                                        <option value="{{ $employers->employer_code }}">
                                                            {{ $employers->employer_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger" id="type_of_employer_{{ $i }}_error"></div>
                                            </td>

                                            <!-- Profession -->
                                            <td>
                                                <div class="input-group">
                                                    <select name="profession[{{$i}}]" class="form-control form-select"
                                                            id="profession_{{ $i }}" onchange="checkOthers({{ $i }})">
                                                        <option value="">Select profession</option>
                                                        @foreach ($professions as $profession)
                                                            <option value="{{ $profession->profession_code }}">
                                                                {{ $profession->profession_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="profession_others[{{$i}}]"
                                                           id="others_{{ $i }}"
                                                           class="form-control d-none" placeholder="Other profession">
                                                </div>
                                                <div class="text-danger" id="profession_{{ $i }}_error"></div>
                                            </td>

                                            <!-- File Upload -->
                                            <td class="fixed-width-up">
                                                <div id="file-inputs">
                                                    <div class="file-input-wrapper mb-3">
                                                        <div>
                                                            <label for="certificate_proof_{{ $i }}" class="btn btn-sm btn-outline-primary me-2 mb-0">
                                                                <i class="fas fa-upload me-1"></i> Upload
                                                            </label>
                                                            <input type="file" name="certificate_proof[{{$i}}]"
                                                                   id="certificate_proof_{{ $i }}"
                                                                   class="form-control d-none"
                                                                   data-id="{{ $i }}"
                                                                   accept="application/pdf">
                                                            <button type="button" class="btn btn-sm btn-danger d-none preview-file-btn"
                                                                    id="preview_file_{{ $i }}">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                        <span class="text-danger"
                                                              id="certificate_proof_{{ $i }}_error"></span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="fixed-width-up">
                                                <button type="button" class="btn btn-outline-primary add-more-experience" data-row-index="{{ $i }}">
                                                    <i class="fas fa-plus-circle me-1"></i> Add More
                                                </button>

                                            </td>
                                        </tr>
                                    @endfor
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Save Workbook Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PDF Preview Modal -->
            <div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Document Preview</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <iframe id="pdfViewer" style="width: 100%; height: 70vh; border: none;"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary decline-btn" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Close
                            </button>
                            <button type="button" class="btn btn-primary confirm-upload-btn">
                                <i class="fas fa-check me-1"></i> Confirm Upload
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <style>
            .card {
                border-radius: 0.5rem;
                border: none;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .card-header {
                border-radius: 0.5rem 0.5rem 0 0 !important;
            }

            .table th {
                font-weight: 600;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border-bottom: 2px solid #dee2e6;
            }

            .form-control, .form-control {
                border-radius: 0.25rem;
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
            }

            .input-group-text {
                background-color: #f8f9fa;
            }

            .btn {
                border-radius: 0.25rem;
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .datepicker {
                background-color: white;
                cursor: pointer;
            }

            .text-danger {
                font-size: 0.75rem;
            }

            .table-hover tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
            }

            .preview-file-btn {
                transition: all 0.2s;
            }

            .preview-file-btn:hover {
                transform: scale(1.05);
            }
        </style>
    </div>
</div>


<!-- /#page-content-wrapper -->
<!-- /#wrapper -->
<!-- Signup Modal -->
<!--view application details-->
<div class="modal fade" id="signout-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block p-5 border-bottom-0">
                <h3 class="modal-title">Sign Out?</h3>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center">Are you sure you want to Log Out?</p>
                <div class="text-center py-4">
                    <form action="{{ route('user-logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
                        <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@include('components.footer')
<link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
<script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>





<script>

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
        let count = $('tbody tr').length ;

        function addNewRow(insertAfter = null) {
            let rowIndex = count;
            console.log(rowIndex)
            const newRowHtml = `
        <tr class="align-middle experience">
            <td>
                <select name="type_of_work[${rowIndex}]" id="type_of_work_${rowIndex}" class="form-control" onchange="checkTypeOfWorkOthers(${rowIndex})">
                    <option value="">Select work type</option>
                    @foreach ($worktype as $work)
                <option value="{{ $work->work_type_code }}">{{ $work->work_type_name }}</option>
                    @endforeach
                </select>
                <input type="text" name="type_of_work_others[${rowIndex}]" id="type_of_work_others_${rowIndex}" class="form-control mt-1 d-none" placeholder="Specify work type">
                <div class="text-danger" id="type_of_work_${rowIndex}_error"></div>
            </td>

            <td>
                <div class="input-group">
                    <input type="date" name="from_date[${rowIndex}]" class="form-control" placeholder="DD-MM-YYYY" id="from_date_${rowIndex}">
                </div>
                <div class="text-danger" id="from_date_${rowIndex}_error"></div>
            </td>

            <td>
                <div class="input-group">
                    <input type="date" name="to_date[${rowIndex}]" class="form-control" placeholder="DD-MM-YYYY" id="to_date_${rowIndex}">
                </div>
                <div class="text-danger" id="to_date_${rowIndex}_error"></div>
            </td>

            <td>
                <input type="number" name="date_count[${rowIndex}]" class="form-control" placeholder="Days" min="1" id="date_count_${rowIndex}">
                <div class="text-danger" id="date_count_${rowIndex}_error"></div>
            </td>

            <td>
                <input type="text" name="employer_name_certi[${rowIndex}]" class="form-control" placeholder="Employer name" id="employer_name_certi_${rowIndex}">
                <div class="text-danger" id="employer_name_certi_${rowIndex}_error"></div>
            </td>

            <td>
                <div class="input-group">
                    <input type="text" name="employer_contact_number[${rowIndex}]" class="form-control" placeholder="Contact number" maxlength="10" pattern="[0-9]{10}" id="employer_contact_number_${count}">
                </div>
                <div class="text-danger" id="employer_contact_number_${rowIndex}_error"></div>
            </td>

            <td>
                <select name="type_of_employer[${rowIndex}]" class="form-control" id="type_of_employer_${rowIndex}">
                    <option value="">Select employer type</option>
                    @foreach ($type_of_employers as $employers)
                <option value="{{ $employers->employer_code }}">{{ $employers->employer_name }}</option>
                    @endforeach
                </select>
                <div class="text-danger" id="type_of_employer.${rowIndex}_error"></div>
            </td>

            <td>
                <div class="input-group">
                    <select name="profession[${rowIndex}]" class="form-control" id="profession_${rowIndex}" onchange="checkOthers(${rowIndex})">
                        <option value="">Select profession</option>
                        @foreach ($professions as $profession)
                <option value="{{ $profession->profession_code }}">{{ $profession->profession_name }}</option>
                        @endforeach
                </select>
                <input type="text" name="profession_others[${rowIndex}]" id="others_${rowIndex}" class="form-control d-none" placeholder="Other profession">
                </div>
                <div class="text-danger" id="profession_${rowIndex}_error"></div>
            </td>

            <td class="fixed-width-up">
                <div id="file-inputs">
                    <div class="file-input-wrapper mb-3">
                        <div>
                            <label for="certificate_proof_${rowIndex}" class="btn btn-sm btn-outline-primary me-2 mb-0">
                                <i class="fas fa-upload me-1"></i> Upload
                            </label>
                            <input type="file" name="certificate_proof[${rowIndex}]" id="certificate_proof_${rowIndex}" class="form-control d-none" data-id="${rowIndex}" accept="application/pdf">
                            <button type="button" class="btn btn-sm btn-danger d-none preview-file-btn" id="preview_file_${rowIndex}">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        <span class="text-danger" id="certificate_proof_${rowIndex}_error"></span>
                    </div>
                </div>
            </td>
            <td>
            <button type="button" class="btn btn-sm btn-outline-danger remove-row ms-1">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>`;

            if (insertAfter) {
                $(insertAfter).after(newRowHtml);
            } else {
                $('tbody').append(newRowHtml);
            }


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


        $(document).on('click', '.add-more-experience', function() {
            addNewRow($(this).closest('tr'));
        });


        $(document).on('click', '.remove-row', function() {
            if ($('tbody tr').length > 1) {
                $(this).closest('tr').remove();
                calculateTotalDays();
            } else {
                Swal.fire({
                    text: 'You must have at least one experience entry.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        });

        // Date calculation functions
        function calculateDateDifference(row) {
            const fromDate = row.find('.from-date').val();
            const toDate = row.find('.to-date').val();

            if (!fromDate || !toDate) return;

            if (fromDate === toDate) {
                Swal.fire({
                    text: 'From Date and To Date cannot be the same.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                row.find('.from-date').val('');
                row.find('.to-date').val('');
                row.find('.date_count').val('');
                return;
            }

            const diffInMs = new Date(toDate) - new Date(fromDate);
            const diffInDays = diffInMs / (1000 * 60 * 60 * 24);
            row.find('.date_count').val(Math.round(diffInDays));
        }

        function calculateTotalDays() {
            let totalDays = 0;
            $('input[name="date_count[]"]').each(function() {
                const val = parseInt($(this).val()) || 0;
                totalDays += val;
            });
            $('#total_days_span').text('Total Days: ' + totalDays);

            if (totalDays < 90) {
                $('#total_days_span').addClass('text-danger')
                    .append(' (Minimum 90 days required)');
            } else {
                $('#total_days_span').removeClass('text-danger');
            }
        }

        // Date change handlers
        $(document).on('change', '.from-date, .to-date', function() {
            calculateDateDifference($(this).closest('tr'));
            calculateTotalDays();
        });
        // Form submission handler
        $('#employer').on('submit', function(e) {
            e.preventDefault();
            calculateTotalDays();

//            const totalDays = parseInt($('#total_days_span').text().replace('Total Days: ', '')) || 0;
//            if (totalDays < 90) {
//                Swal.fire({
//                    title: 'Insufficient Experience',
//                    text: 'You must have at least 90 days of work experience.',
//                    icon: 'error',
//                    confirmButtonText: 'OK'
//                });
//                return;
//            }

            const formData = new FormData(this);

            $.ajax({
                url: '{{ route('save-workbook-application') }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        window.location.href = "{{ route('preview-renewal-data') }}";
                    } else {
//                        $('.text-danger').html('');
                        // Handle validation errors
//                        $.each(response.errors, function(field, messages) {
//                            const escapedKey = field.replace('.', '\\.');
//                            $("#" + escapedKey + '_error').html(messages[0]);
//                        });
                        if (response.errors) {
                            console.log('Validation errors:', response.errors);

                            // Delay a bit to ensure DOM is ready (if rows just added)
                            setTimeout(() => {
                                $('.text-danger').html('');
                                $('input, select, textarea').removeClass('is-invalid');

                                let firstErrorField = null;

                                $.each(response.errors, function (field, messages) {
                                    const message = messages[0];

                                    if (field.includes('.')) {
                                        const [baseName, index] = field.split('.');
                                        const selector = `[name="${baseName}[${index}]"]`;
                                        const input = $(selector);

                                        console.log(`Field: ${field}, Selector: ${selector}, Found: ${input.length}`);

                                        if (input.length) {
                                            input.addClass('is-invalid');
                                            if (!firstErrorField) firstErrorField = input;

                                            const errorElement = input.closest('tr').find(`#${baseName}_${index}_error`);
                                            if (errorElement.length) {
                                                errorElement.html(message);
                                            } else {
                                                input.after(`<span class="text-danger">${message}</span>`);
                                            }
                                        }
                                    }
                                });

                                if (firstErrorField) {
                                    $('html, body').animate({
                                        scrollTop: firstErrorField.offset().top - 100
                                    }, 600);
                                    firstErrorField.focus();
                                }
                            }, 50);
                        }


                    }
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });

    // These functions would be defined elsewhere in your code
    function checkTypeOfWorkOthers(rowId) {
        // Your implementation
    }

    function checkOthers(rowId) {
        // Your implementation
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pdfViewer = document.getElementById('pdfViewer');
        const pdfModalElement = document.getElementById('pdfModal');
        const pdfModal = new bootstrap.Modal(pdfModalElement);
        let currentInput = null;
        let fileMap = {};

        // File input change handler
        document.body.addEventListener('change', function (event) {
            if (event.target.matches('input[type="file"][name^="certificate_proof["]')) {
                const file = event.target.files[0];
                if (file && file.type === "application/pdf") {
                    const inputId = event.target.id;
                    const pdfURL = URL.createObjectURL(file);
                    pdfViewer.setAttribute('src', pdfURL);

                    currentInput = event.target;
                    currentInput.dataset.previewUrl = pdfURL;

                    pdfModal.show();
                } else {
                    alert("Please select a valid PDF file.");
                    event.target.value = '';
                }
            }
        });


        // Upload (keep file and show preview icon)
        document.querySelector('.confirm-upload-btn').addEventListener('click', function () {
            if (currentInput) {
                const inputId = currentInput.id;
                const rowIndex = inputId.split('_').pop(); // Get number from ID
                const previewBtn = document.getElementById('preview_file_' + rowIndex);

                // Store the object URL for later preview
                fileMap[inputId] = currentInput.dataset.previewUrl;

                // Show the preview button
                previewBtn.classList.remove('d-none');

                // Add event to preview button (only once)
                previewBtn.onclick = function () {
                    const url = fileMap[inputId];
                    if (url) {
                        pdfViewer.setAttribute('src', url);
                        pdfModal.show();
                    }
                };
            }

            pdfViewer.setAttribute('src', '');
            pdfModal.hide();
        });

        // Discard (clear file input + modal)
        document.querySelector('.decline-btn').addEventListener('click', function () {
            if (currentInput) {
                currentInput.value = '';
                delete fileMap[currentInput.id];

                const rowIndex = currentInput.id.split('_').pop();
                const previewBtn = document.getElementById('preview_file_' + rowIndex);
                previewBtn.classList.add('d-none'); // Hide preview button
            }

            pdfViewer.setAttribute('src', '');
            pdfModal.hide();
        });

        // Also clear iframe on manual close
        pdfModalElement.addEventListener('hidden.bs.modal', function () {
            pdfViewer.setAttribute('src', '');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pdfViewer = document.getElementById('pdfViewer');
        const pdfModalElement = document.getElementById('pdfModal');
        const pdfModal = new bootstrap.Modal(pdfModalElement);
        let currentInput = null;
        let fileMap = {};

        // ✅ Handle change on ANY dynamically added file input
        document.addEventListener('change', function (event) {
            const input = event.target;

            if (input.matches('input[type="file"][name="certificate_proof[]"]')) {
                const file = input.files[0];
                if (file && file.type === "application/pdf") {
                    const inputId = input.id;
                    const pdfURL = URL.createObjectURL(file);

                    pdfViewer.setAttribute('src', pdfURL);
                    currentInput = input;
                    currentInput.dataset.previewUrl = pdfURL;

                    pdfModal.show();
                } else {
                    alert("Please select a valid PDF file.");
                    input.value = '';
                }
            }
        });

        // ✅ Confirm upload
        document.querySelector('.confirm-upload-btn').addEventListener('click', function () {
            if (currentInput) {
                const inputId = currentInput.id;
                const rowIndex = inputId.split('_').pop();
                const previewBtn = document.getElementById('preview_file_' + rowIndex);

                fileMap[inputId] = currentInput.dataset.previewUrl;

                // Show and bind preview button
                previewBtn.classList.remove('d-none');
                previewBtn.onclick = function () {
                    const url = fileMap[inputId];
                    if (url) {
                        pdfViewer.setAttribute('src', url);
                        pdfModal.show();
                    }
                };
            }

            pdfViewer.setAttribute('src', '');
            pdfModal.hide();
        });

        // ❌ Cancel upload
        document.querySelector('.decline-btn').addEventListener('click', function () {
            if (currentInput) {
                currentInput.value = '';
                delete fileMap[currentInput.id];

                const rowIndex = currentInput.id.split('_').pop();
                const previewBtn = document.getElementById('preview_file_' + rowIndex);
                previewBtn.classList.add('d-none');
            }

            pdfViewer.setAttribute('src', '');
            pdfModal.hide();
        });

        // Clear iframe when modal is closed
        pdfModalElement.addEventListener('hidden.bs.modal', function () {
            pdfViewer.setAttribute('src', '');
        });
    });
</script>
