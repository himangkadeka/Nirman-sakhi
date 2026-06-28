@include('layout.workerheader')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@php
    use Carbon\Carbon;
@endphp
<style>

        /* ========== MODERN GOVT-STYLE UI ========== */
    :root {
        --primary: #0b5e5e;
        --primary-dark: #084c4c;
        --primary-light: #e6f4f4;
        --accent: #2c7da0;
        --gray-bg: #f8fafc;
        --border-light: #e2e8f0;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
    }
    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--govt-bg);
        color: #334155;
    }


    .workbook-entry {
        background: white;
        transition: all 0.2s ease;
        padding: 1.25rem;
        border-radius: 1rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .workbook-entry:hover {
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        margin-bottom: 0.4rem;
        color: var(--text-dark);
        letter-spacing: 0.3px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .form-label i {
        font-size: 0.75rem;
        color: var(--primary);
    }

    .form-control, .form-select {
        border-radius: 0.75rem;
        border: 1px solid var(--border-light);
        /*padding: 0.6rem 0.85rem;*/
        font-size: 0.875rem;
        transition: all 0.2s;
        background-color: #fff;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(11, 94, 94, 0.1);
        outline: none;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: var(--danger);
        background-image: none;
    }

    .disabled {
        pointer-events: none;
        opacity: 0.6;
        cursor: not-allowed;
    }

    .text-warning {
        color: var(--warning);
        font-size: 0.75rem;
        font-weight: 500;
    }

    .datepicker {
        z-index: 1151 !important;
    }

    /* Custom Button Styles */
    .custom-btn {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border-radius: 0.75rem;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        color: white;
    }

    .custom-btn:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #063a3a 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(11, 94, 94, 0.2);
    }

    .custom-btn-outline {
        background: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
        border-radius: 0.75rem;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .custom-btn-outline:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
    }

    .bg-light {
        background: var(--gray-bg) !important;
    }

    .fw-bold {
        font-weight: 600;
    }

    /* Card & Header Styling */
    .card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header {
        background: black;
        color: white;
        padding: 1rem 1.5rem;
        border-bottom: none;
    }

    .card-header h6 {
        font-weight: 600;
        letter-spacing: 0.5px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-header h6 i {
        font-size: 1.1rem;
    }

    .card-body {
        padding: 1.75rem;
    }

    /* Experience Label Badge */
    .experience-label {
        background: linear-gradient(135deg, var(--primary-light) 0%, #f0f9f9 100%);
        border-radius: 1rem;
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
        border-left: 4px solid var(--primary);
    }

    .experience-badge {
        background: var(--primary);
        color: white;
        border-radius: 2rem;
        padding: 0.25rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 600;
        margin-right: 0.75rem;
    }

    /* File Upload Styling */
    .file-upload-area {
        border: 1px dashed var(--border-light);
        border-radius: 1rem;
        padding: 0.75rem;
        background: var(--gray-bg);
        transition: all 0.2s;
    }

    .file-upload-area:hover {
        border-color: var(--primary);
        background: #fff;
    }

    .btn-sm-icon {
        padding: 0.4rem 0.8rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
    }

    /* Date Range Info */
    .date-range-info {
        background: var(--primary-light);
        border-radius: 0.75rem;
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        color: var(--primary-dark);
        font-weight: 500;
    }

    /* Modal Enhancements */
    .modal-content {
        border: none;
        border-radius: 1.25rem;
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        .workbook-entry {
            padding: 0.75rem;
        }
        .form-label {
            font-size: 0.7rem;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .workbook-entry {
        animation: fadeIn 0.3s ease-out;
    }
    .worker-dashboard {
        width: 100% !important;
        max-width: 100% !important; /* This removes the 1200px limit */
        margin: 0;
        padding-top: 0px;

    }
        .revert-remarks-box {
            background: linear-gradient(135deg, #fff5f5 0%, #fef2f2 100%);
            border: 1px solid #fecaca;
            border-left: 5px solid #ef4444;
            border-radius: 1rem;
            padding: 1.25rem;
            margin: 1rem 1rem 0;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);
        }

        .revert-remarks-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .revert-remarks-header i {
            color: #ef4444;
            font-size: 1.25rem;
        }

        .revert-alert {
            background: #fff8f8;
            border-left: 4px solid #dc3545;
            border-radius: 8px;
            padding: 12px 15px;
            margin: 15px 20px 0;
            font-size: 14px;
        }

        .revert-alert .title {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .revert-alert ul {
            margin: 5px 0 0 18px;
            padding: 0;
        }

        .revert-alert li {
            color: #6c757d;
            margin-bottom: 2px;
        }
        .revert-reasons-list li {
            background: #fff;
            border: 1px solid #fee2e2;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            color: #991b1b;
            position: relative;
            padding-left: 2.5rem;
        }

        .revert-reasons-list li::before {
            content: "\f071";
            font-family: "Font Awesome 5 Free";
            font-weight: 800;
            position: absolute;
            left: 1rem;
            color: #ef4444;
        }
        .btn-submit-workbook,
        .btn-clear-workbook{
            color:#fff;
            border:none;
            border-radius:12px;
            padding:12px 24px;
            font-size:15px;
            font-weight:600;
            transition:all .3s ease;
            display:inline-flex;
            align-items:center;
            gap:8px;
        }

        /* Save Button */
        .btn-submit-workbook{
            background:linear-gradient(135deg,#0b5e5e,#2c7da0);
            box-shadow:0 4px 15px rgba(44,125,160,.25);
        }

        .btn-submit-workbook:hover{
            transform:translateY(-2px);
            color:#fff;
            box-shadow:0 8px 25px rgba(44,125,160,.35);
        }

        /* Clear Button */
        .btn-clear-workbook{
            background:linear-gradient(135deg,#dc3545,#b02a37);
            padding:12px 18px;
        }

        .btn-clear-workbook:hover{
            transform:translateY(-2px);
            color:#fff;
            box-shadow:0 8px 25px rgba(220,53,69,.35);
        }

        .btn-submit-workbook i,
        .btn-clear-workbook i{
            font-size:14px;
        }
</style>
<div class="d-flex" id="wrapper">
@include('worker.leftmenu')
<!-- Page Content -->
    <div id="page-content-wrapper">
@include('components.worker.ui.navbar')
        <form class="needs-validation" enctype="multipart/form-data" method="post" id="employer" novalidate>
            @csrf
        <div class="container worker-dashboard">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fa fa-pencil-square" aria-hidden="true"></i>&nbsp;Update Work Experience Details</h6>
                </div>
                @php($remarks ??= null)

                @if ($remarks)
                    <div class="revert-alert">
                        <div class="title">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Reverted Remarks
                        </div>

                        <div>{{ $remarks->remarks }}</div>

                        @if(count($remarks->getReasons($wmf->worker_id)))
                            <ul>
                                @foreach ($remarks->getReasons($wmf->worker_id) as $remark)
                                    <li>{{ $remark->reason }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
                <input type="hidden" id="worker_id" value="{{ $wmf->worker_id }}">
                <div class="card-body">
                    <div class="workbook-entries">
                        @if (sizeof($twc) > 0)
                            @foreach ($twc as $key => $workbook)

                                @if ($workbook->current_range)
                                    <div class=" mb-4 p-3 border rounded workbook-entry-container"
                                         data-group-id="{{ $workbook->group_id }}"
                                         data-row-id="{{ $workbook->row_id }}">
                                        {{--
                                            REQUIREMENT MET: This header is ONLY displayed for parent rows (0.0, 1.0, etc.)
                                            It is SKIPPED for child rows (0.1, 1.1, etc.) because $workbook->is_parent will be false.
                                        --}}
                                        @if ($workbook->is_parent)
                                            <div class="experience-label d-flex align-items-center justify-content-between bg-light rounded shadow-sm p-3 border-start border-primary border-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-briefcase text-primary me-2 fs-5"></i>
                                                    <span class="fw-bold text-dark">
                                        Working Record Book Details:
                                                        {{-- CORRECTED: Use the safe $workbook->current_range variable --}}
                                                        <span class="text-primary">{{ $workbook->current_range['from'] }}</span> to
                                        <span class="text-primary">{{ $workbook->current_range['to'] }}</span>
                                    </span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row g-2 mb-1 pt-2">
                                            {{--<div class="d-flex align-items-center mb-2">--}}
                                 {{--<span class="badge badge-danger shadow-sm experience-badge">--}}
                                    {{--#{{ $key + 1 }}--}}
                                {{--</span> --}}
                                                {{--<span class="text-dark fw-bold">Experience Entry</span>--}}
                                            {{--</div>--}}

                                            <!-- Type of Work -->
                                            <div class="col-md-3 px-2 mt-1">
                                                <label class="form-label">Type Of Construction Work <span style="color: red">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-control @if ($errors->has('type_of_work')) is-invalid @endif" name="type_of_work[{{$workbook->row_id}}]" id="type_of_work_{{ $workbook->row_id }}" onchange="checkTypeOfWorkOthers({{ $workbook->row_id }})">
                                                        <option value="{{ $workbook->type_of_work ?? '' }}" selected>
                                                            {{ $workbook->work_type_name ?? 'Select Type' }}
                                                        </option>
                                                        @foreach ($worktype as $work)
                                                            @if ($work->work_type_code != ($workbook->type_of_work ?? null))
                                                                <option value="{{ $work->work_type_code }}">{{ $work->work_type_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="type_of_work_others[{{$workbook->row_id}}]" id="type_of_work_others_{{ $workbook->row_id }}" class="form-control d-none" placeholder="Specify work type">
                                                </div>
                                                <div class="text-danger" id="type_of_work_{{ str_replace('.', '_', $workbook->row_id) }}_error"></div>
                                            </div>

                                            <!-- Dates -->
                                            <div class="col-md-3 px-2 mt-1">
                                                <label class="form-label">Start Date <span style="color: red">*</span></label>
                                                <div class="input-group">
                                                    {{-- CORRECTED: Use $workbook->current_range, format date correctly, and remove invalid '.0' --}}
                                                    <input type="date" name="from_date[{{$workbook->row_id}}]" value="{{ $workbook->from_date ? \Carbon\Carbon::parse($workbook->from_date)->format('Y-m-d') : '' }}" class="form-control" placeholder="DD-MM-YYYY" id="from_date_{{ $workbook->row_id }}"
                                                           min="{{ \Carbon\Carbon::parse($workbook->current_range['from'])->format('Y-m-d') }}"
                                                           max="{{ \Carbon\Carbon::parse($workbook->current_range['to'])->format('Y-m-d') }}"
                                                           onchange="validateExperienceDates('{{ $workbook->row_id}}')">
                                                    <span class="text-danger" id="from_date_{{ str_replace('.', '_', $workbook->row_id) }}_error"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-3 px-2 mt-1">
                                                <label class="form-label">End Date <span style="color: red">*</span></label>
                                                <div class="input-group">
                                                    {{-- CORRECTED: Use $workbook->current_range, format date correctly, and remove invalid '.0' --}}
                                                    <input type="date" name="to_date[{{$workbook->row_id}}]" value="{{ $workbook->to_date ? \Carbon\Carbon::parse($workbook->to_date)->format('Y-m-d') : '' }}" class="form-control" placeholder="DD-MM-YYYY" id="to_date_{{ $workbook->row_id }}"
                                                           min="{{ \Carbon\Carbon::parse($workbook->current_range['from'])->format('Y-m-d') }}"
                                                           max="{{ \Carbon\Carbon::parse($workbook->current_range['to'])->format('Y-m-d') }}"
                                                           onchange="validateExperienceDates('{{ $workbook->row_id}}')">
                                                    <span class="text-danger" id="to_date_{{ str_replace('.', '_', $workbook->row_id) }}_error"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-3 px-2 mt-1">
                                                <label class="form-label">Actual Days Worked <span style="color: red">*</span></label>
                                                <input
                                                        type="number"
                                                        name="date_count[{{ $workbook->row_id }}]"
                                                        id="date_count_{{ $workbook->row_id }}"
                                                        value="{{ $workbook->date_count ?? '' }}"
                                                        class="form-control"
                                                        placeholder="Days"
                                                        min="1"
                                                        onblur="validateDateCount('{{ $workbook->row_id }}')"
                                                >
                                                <div class="text-danger" id="date_count_{{ str_replace('.', '_', $workbook->row_id) }}_error"></div>
                                            </div>

                                            {{-- CORRECTED: This whole informational div now only shows for parent rows and uses the safe variable --}}
                                            @if($workbook->is_parent)
                                                <div class="col-12 mb-3" data-workbook-range="{{ $workbook->row_id }}" data-start="{{ $workbook->current_range['from'] }}" data-end="{{ $workbook->current_range['to'] }}">
                                                    <p class="text-muted">
                                                        Workbook Date Range:
                                                        <span class="text-primary">{{ $workbook->current_range['from'] }}</span>
                                                        to
                                                        <span class="text-primary">{{ $workbook->current_range['to'] }}</span>
                                                    </p>
                                                </div>
                                        @endif


                                        <!-- Employer Info (No changes needed here) -->
                                            <div class="col-md-3 px-2 mt-1">
                                                <label class="form-label">Employer Name <span style="color: red">*</span></label>
                                                <input
                                                        type="text"
                                                        name="employer_name_certi[{{ $workbook->row_id }}]"
                                                        value="{{ $workbook->emp ?? '' }}"
                                                        class="form-control"
                                                        placeholder="Employer name"
                                                        id="employer_name_certi_{{ $workbook->row_id }}"
                                                >
                                                <div class="text-danger" id="employer_name_certi_{{ str_replace('.', '_', $workbook->row_id) }}_error"></div>
                                            </div>
                                                <div class="col-md-3 px-2 mt-1">
                                                    <label class="form-label">Employer Contact <span style="color: red">*</span></label>
                                                    <div class="input-group">
                                                        <input
                                                                type="text"
                                                                name="employer_contact_number[{{ $workbook->row_id }}]"
                                                                value="{{ $workbook->employer_contact_number ?? '' }}"
                                                                class="form-control"
                                                                placeholder="Contact number"
                                                                maxlength="10"
                                                                pattern="[0-9]{10}"
                                                                id="employer_contact_number_{{ $workbook->row_id }}"
                                                        >
                                                    </div>
                                                    <div class="text-danger" id="employer_contact_number_{{ str_replace('.', '_', $workbook->row_id) }}_error"></div>
                                                </div>


                                                <div class="col-md-3 px-2 mt-1">
                                                    <label class="form-label">Type Of Employer <span style="color: red">*</span></label>

                                                    <select name="type_of_employer[{{ $workbook->row_id }}]" class="form-control" id="type_of_employer_{{ $workbook->row_id }}">

                                                        <option value="">-- Select Employer --</option>

                                                        @foreach ($type_of_employers as $employers)
                                                            <option
                                                                    value="{{ $employers->employer_code }}"
                                                                    {{ ($workbook->type_of_employer ?? '') == $employers->employer_code ? 'selected' : '' }}
                                                            >
                                                                {{ $employers->employer_name }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                    <div class="text-danger" id="type_of_employer_{{ str_replace('.', '_', $workbook->row_id) }}_error"></div>
                                                </div>


                                                <div class="col-md-3 px-2 mt-1">
                                                    <label class="form-label">Profession <span style="color: red">*</span></label>

                                                    <div class="input-group">
                                                        <select
                                                                name="profession[{{ $workbook->row_id }}]"
                                                                class="form-control"
                                                                id="profession_{{ $workbook->row_id }}"
                                                                onchange="checkOthers('{{ $workbook->row_id }}')"
                                                        >
                                                            <option value="">-- Select Profession --</option>

                                                            @foreach ($professions as $profession)
                                                                <option
                                                                        value="{{ $profession->profession_code }}"
                                                                        {{ ($workbook->profession ?? '') == $profession->profession_code ? 'selected' : '' }}
                                                                >
                                                                    {{ $profession->profession_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <input
                                                                type="text"
                                                                name="profession_others[{{ $workbook->row_id }}]"
                                                                id="others_{{ $workbook->row_id }}"
                                                                value="{{ $workbook->profession_others ?? '' }}"
                                                                class="form-control d-none"
                                                                placeholder="Other profession"
                                                        >
                                                    </div>

                                                    <div class="text-danger" id="profession_{{ str_replace('.', '_', $workbook->row_id) }}_error"></div>
                                                </div>
                                                <!-- File Upload (No changes needed here) -->
                                                <div class="col-md-6 px-1 mt-2">
                                                    <label class="form-label">Working Record Book
                                                        @if($workbook->is_parent) <span style="color: red">*</span>
                                                        @endif</label>
                                                    <div id="file-inputs">
                                                        <div class="file-input-wrapper mb-3">
                                                            <div>
                                                                <label for="certificate_proof_{{ $workbook->row_id }}" class="btn btn-sm btn-outline-primary me-2 mb-0">
                                                                    <i class="fas fa-upload me-1"></i>
                                                                    Upload (Max 1MB) </label>
                                                                @if($workbook->is_parent ?? '')<small class="text-danger d-block mb-1"> Ensure a minimum of 90 days of work-record documents each completed year are uploaded. </small>
                                                                @endif
                                                                <input type="hidden" name="certificate_proof_id[{{$workbook->row_id ?? ''}}]" value="{{ $workbook->certificate_proof_id ?? ''}}">
                                                                <input type="file" name="certificate_proof[{{ $workbook->row_id ?? ''}}]" id="certificate_proof_{{ $workbook->row_id ?? ''}}" class="form-control d-none" data-id="{{ $workbook->row_id ?? ''}}" accept="application/pdf,image/jpeg,image/jpg" onchange="validateFile(this)">
                                                                @if($workbook->certificate_proof ?? '') <a href="{{ route('view-work-book', ['id' => $workbook->id ?? '']) }}" class="btn btn-sm btn-primary" target="_blank" id="view_file_{{ $workbook->row_id ?? '' }}"> View <i class="fa fa-external-link" aria-hidden="true"></i>
                                                                </a> @else <span class="text-muted small"></span>
                                                                @endif <button type="button" class="btn btn-sm btn-success d-none preview-file-btn" id="preview_file_{{ $workbook->row_id ?? ''}}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </button> <button type="button" class="btn btn-sm btn-danger d-none delete-file-btn" id="delete_file_{{ $workbook->row_id ?? ''}}" onclick="deleteSelectedFile('{{ $workbook->row_id ?? ''}}')"> <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </button> <span class="ms-2 text-secondary small file-name" id="file_name_{{ $workbook->row_id ?? ''}}">

                                                                </span>
                                                            </div>
                                                            <span class="text-danger" id="certificate_proof_{{ str_replace('.', '_', $workbook->row_id) }}_error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            <!-- Add More Button (No changes needed here) -->
                                                @if ($workbook->is_parent)
                                            <div class="col-md-12  d-flex justify-content-end">
                                                <button type="button" class="btn btn-outline-primary add-more-experience" data-row-index="{{ $workbook->group_id }}">
                                                    <i class="fas fa-plus-circle me-1"></i> Add More Experience
                                                </button>
                                            </div>
                                                    @endif
                                        </div>
                                    </div>
                                @else
                                    {{-- This message will appear if there's a data mismatch, preventing a crash. --}}
                                    <div class="alert alert-danger">
                                        <strong>Data Mismatch:</strong> Workbook entry with row ID <strong>{{ $workbook->row_id }}</strong> was found, but a corresponding date range could not be located. Please check data integrity.
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p>No workbooks available.</p>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <button type="button"
                                class="btn btn-clear-workbook"
                                id="clearWorkbookBtn">
                            <i class="fas fa-trash-alt"></i>
                            Clear Data
                        </button>

                        <button type="submit" class="btn btn-submit-workbook">
                            <i class="fas fa-file-signature"></i>
                            Save & Continue
                            <i class="fas fa-arrow-right"></i>
                        </button>

                    </div>
                </div>
                </div>
            </div>
        </form>

        </div>
            <div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Document Preview</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <iframe id="pdfViewer" style="width: 100%; height: 70vh; border: none;"></iframe>
                            <img id="imageViewer" class="w-100 d-none" style="max-height:500px;" />
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#clearDataModal">
                                <i class="fas fa-trash-alt me-2"></i>
                                Clear All Data
                            </button>
                            <button type="button" class="btn btn-primary confirm-upload-btn">
                                <i class="fas fa-check me-1"></i> Confirm Upload
                            </button>
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
    $('#clearWorkbookBtn').on('click', function () {

        Swal.fire({
            title: 'Clear Workbook Data?',
            text: "All entered workbook records will be removed.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Clear Data'
        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: "{{ route('clear-workbook-data') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    worker_id: "{{ $wmf->worker_id }}"
                },

                beforeSend: function () {

                    $('#clearWorkbookBtn')
                        .prop('disabled', true)
                        .html(`
                        <span class="spinner-border spinner-border-sm me-1"></span>
                        Clearing...
                    `);
                },

                success: function (response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                },

                error: function (xhr) {

                    Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: xhr.responseJSON?.message || 'Something went wrong.'
                });
                },

                complete: function () {

                    $('#clearWorkbookBtn')
                        .prop('disabled', false)
                        .html(`
                        <i class="fas fa-trash-alt me-2"></i>
                        Clear All Data
                    `);
                }
            });

        });
    });
</script>
<script>
    /**
     * Helper function to convert a date string from DD-MM-YYYY to YYYY-MM-DD
     * which is required for the min/max attributes of an HTML date input.
     * @param {string} dateStr - The date string in DD-MM-YYYY format.
     * @returns {string} The date string in YYYY-MM-DD format.
     */
    function formatDateForInput(dateStr) {
        if (!dateStr || dateStr.length !== 10) return '';
        const parts = dateStr.split('-');
        if (parts.length !== 3) return '';
        // parts are [DD, MM, YYYY], return as [YYYY, MM, DD]
        return `${parts[2]}-${parts[1]}-${parts[0]}`;
    }

    /**
     * Generates the HTML for a new workbook entry.
     */
    function generateWorkbookEntry(index, parentIndex) {
        const dateRanges = @json($date_ranges);
        const range = dateRanges[parentIndex] || { from: '', to: '' };
        const covertedIndex = index.toString().replace(/\./g, '_');


        return `
            <div class="mb-4 p-3 border rounded workbook-entry-container added-entry"
                 data-group-id="${parentIndex}"
                 data-row-id="${index}">
                <div class="row g-2 mb-1 workbook-entry">



            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Type Of Construction Work <span style="color: red">*</span></label>
            <select name="type_of_work[${index}]" id="type_of_work_${covertedIndex}" class="form-control form-select">
            <option value="">Select work type</option>
                @foreach ($worktype as $work)
            <option value="{{ $work->work_type_code }}">{{ $work->work_type_name }}</option>
                @endforeach
            </select>
            <input type="text" name="type_of_work_others[${index}]" id="type_of_work_others_${covertedIndex}" class="form-control mt-1 d-none" placeholder="Specify work type">
            <div class="text-danger" id="type_of_work_${covertedIndex}_error"></div>
            </div>


            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Start Date <span style="color: red">*</span></label>
            <input type="date" name="from_date[${index}]" class="form-control" id="from_date_${covertedIndex}"
            min="${formatDateForInput(range.from)}"
            max="${formatDateForInput(range.to)}">
             <div class="text-danger" id="from_date_${covertedIndex}_error"></div>
            </div>
            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">End Date <span style="color: red">*</span></label>
            <input type="date" name="to_date[${index}]" class="form-control" id="to_date_${covertedIndex}"
            min="${formatDateForInput(range.from)}"
            max="${formatDateForInput(range.to)}">
            <div class="text-danger" id="to_date_${covertedIndex}_error"></div>
            </div>


            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Actual days Worked<span style="color: red">*</span></label>
            <input type="number" name="date_count[${index}]" id="date_count_${covertedIndex}" class="form-control" placeholder="Days" min="1">
             <div class="text-danger" id="date_count_${covertedIndex}_error"></div>
            </div>

            <div class="col-12 mb-3" data-workbook-range="${index}"
             data-start="${range.from}"
             data-end="${range.to}">
            <p class="text-muted">
                Workbook Date Range:
                <span class="text-primary">${range.from}</span> to
                <span class="text-primary">${range.to}</span>
            </p>
        </div>


            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Employer Name <span style="color: red">*</span></label>
            <input type="text" name="employer_name_certi[${index}]" class="form-control" placeholder="Employer name"
            id="employer_name_certi_${covertedIndex}">
             <div class="text-danger" id="employer_name_certi_${covertedIndex}_error"></div>
            </div>


            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Employer Contact <span style="color: red">*</span></label>
            <input type="text" name="employer_contact_number[${index}]" id="employer_contact_number_${covertedIndex}" class="form-control" placeholder="Contact number" maxlength="10"
            >
              <div class="text-danger" id="employer_contact_number_${covertedIndex}_error"></div>
            </div>


            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Type Of Employer <span style="color: red">*</span></label>
            <select name="type_of_employer[${index}]" class="form-control form-select" id="type_of_employer_${covertedIndex}">
            <option value="">Select employer type</option>
                @foreach ($type_of_employers as $employers)
            <option value="{{ $employers->employer_code }}">{{ $employers->employer_name }}</option>
                @endforeach
            </select>
             <div class="text-danger" id="type_of_employer_${covertedIndex}_error"></div>
            </div>


            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Profession <span style="color: red">*</span></label>
            <select name="profession[${index}]" class="form-control form-select" id="profession_${covertedIndex}">
            <option value="">Select profession</option>
                @foreach ($professions as $profession)
            <option value="{{ $profession->profession_code }}">{{ $profession->profession_name }}</option>
                @endforeach
            </select>
             <div class="text-danger" id="profession_${covertedIndex}_error"></div>
            </div>


            <div class="col-md-6 px-1 mt-2">
    <label class="form-label">Working Record Book</label>
    <div id="file-inputs">
        <div class="file-input-wrapper mb-3">
            <div class="d-flex align-items-center">


            <label for="certificate_proof_${covertedIndex}" class="btn btn-sm btn-outline-primary me-2 mb-0">
            <i class="fas fa-upload me-2"></i> Upload (Max 1MB)
            </label>


            <input type="file"
            name="certificate_proof[${index}]"
            id="certificate_proof_${covertedIndex}"
            class="form-control d-none"
            data-id="${index}"
            accept="application/pdf,image/jpeg,image/jpg"
            onchange="validateFiles(this)">
<input type="hidden" name="certificate_proof_id[${index}]" value="0">

            <button type="button"
            class="btn btn-sm btn-success ml-2 d-none preview-file-btn"
            id="preview_file_${covertedIndex}"
            data-bs-toggle="tooltip"
            title="Preview PDF">
            <i class="fa fa-eye" aria-hidden="true"></i>
            </button>


            <button type="button"
            class="btn btn-sm btn-danger ml-2 d-none delete-file-btn"
            id="delete_file_${covertedIndex}"
            onclick="deleteSelectedFile('${index}')"
            data-bs-toggle="tooltip"
            title="Remove File">
            <i class="fa fa-trash" aria-hidden="true"></i>
            </button>


            <span class="ms-2 ml-3 text-secondary small file-name" id="file_name_${covertedIndex}"></span>
            </div>


            <span class="text-danger" id="certificate_proof_${covertedIndex}_error"></span>
            </div>
            </div>
            </div>


            <div class="col-md-12 d-flex justify-content-end">

            <button type="button" class="btn btn-outline-danger ms-2" onclick="removeEntry(this)">
            <i class="fas fa-trash-alt me-1"></i> Remove
            </button>
            </div>
            </div>
            </div>
            `;
    }

    // This object will store the current child count for each parent group.
    let childCounters = {};

    $(document).on('click', '.add-more-experience', function() {
        // Get the parent group index (e.g., 0, 1) from the button's data attribute.
        const parentIndex = $(this).data('row-index');
        console.log(parentIndex)

        // --- THE CRITICAL LOGIC FOR UPDATE FORMS ---
        // If this is the first time we click "Add More" for this group, we must
        // scan the DOM to find the highest existing child index.
        if (childCounters[parentIndex] === undefined) {
            let maxChildIndex = 0;
            // Find all existing entries belonging to this parent group.
            $(`.workbook-entry-container[data-group-id="${parentIndex}"]`).each(function() {
                // Get the full row ID (e.g., "0.1") from the data attribute.
                const fullRowId = $(this).data('row-id').toString();
                console.log(fullRowId)
                const parts = fullRowId.split('.');

                // If it's a child ID (like "0.1"), check its number.
                if (parts.length === 2) {
                    const childPart = parseInt(parts[1], 10);
                    if (childPart > maxChildIndex) {
                        maxChildIndex = childPart;
                    }
                }
            });
            // Initialize this group's counter to the highest found index.
            childCounters[parentIndex] = maxChildIndex;
            console.log(maxChildIndex)
        }
        // --- END OF CRITICAL LOGIC ---

        // Now, increment the counter to get the number for the NEW entry.
        childCounters[parentIndex]++;

        // Create the new child index string (e.g., "0.2").
        const newChildIndex = `${parentIndex}.${childCounters[parentIndex]}`;
        console.log(newChildIndex)

        // Generate the new HTML block.
        const newEntryHTML = generateWorkbookEntry(newChildIndex, parentIndex);

        // Find the LAST entry in the group and append the new one after it for proper ordering.
         $(`.workbook-entry-container[data-group-id="${parentIndex}"]`).last().after(newEntryHTML);
    });

    function removeEntry(button) {
        if (confirm('Are you sure you want to remove this entry?')) {
            // We only allow removing entries that were added dynamically.
            $(button).closest('.added-entry').remove();
        }
    }

    // Your other helper functions (checkOthers, etc.) can remain as they are.

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const workerPhone = '{{ $wmf->phone_no }}';
        document.body.addEventListener('keyup', function (e) {
            const input = e.target;

            if (input.matches('input[name^="employer_contact_number"]')) {
                const inputId = input.id.replace(/\./g, '_');
                console.log(inputId)
                const errorDiv = document.getElementById(inputId + '_error');
                const value = input.value.trim();

                // Reset previous error
                errorDiv.textContent = "";
                input.classList.remove('is-invalid');

                // Validation 1: Same as worker phone
                if (value === workerPhone) {
                    errorDiv.textContent = "Employer's contact number cannot be the same as your registered contact number.";
                    input.classList.add('is-invalid');
                }

                // Validation 2: Not exactly 10 digits
                else if (!/^\d{10}$/.test(value)) {
                    if (/[a-zA-Z]/.test(value)) {
                        errorDiv.textContent = "Alphabets are not allowed in contact number.";
                    } else {
                        errorDiv.textContent = "Contact number must be exactly 10 digits.";
                    }
                    input.classList.add('is-invalid');
                }

                // Validation 3: Must start with 6, 7, 8, or 9
                else if (!/^[6-9]/.test(value)) {
                    errorDiv.textContent = "Contact number must start with 9, 8, 7, or 6";
                    input.classList.add('is-invalid');
                }
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.addEventListener('keyup', function (e) {
            const input = e.target;

            // Check if the input name starts with "employer_name_certi"
            if (input.matches('input[name^="employer_name_certi"]')) {
                const inputId = input.id.replace(/\./g, '_');
                console.log(inputId)
                const errorDiv = document.getElementById(inputId + '_error');
                const value = input.value.trim();

                // Reset previous error
                errorDiv.textContent = "";
                input.classList.remove('is-invalid');

                // Validation
                if (value.length < 3) {
                    errorDiv.textContent = "Employer name must be at least 4 characters long.";
                    input.classList.add('is-invalid');
                } else if (!/^[a-zA-Z\s]+$/.test(value)) {
                    errorDiv.textContent = "Only alphabetic characters and spaces are allowed.";
                    input.classList.add('is-invalid');
                }
            }
        });
    });
</script>
<script>
    $('#employer').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitButton = form.find('button[type="submit"]');
        const originalButtonHtml = submitButton.html();

        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...');
        const formData = new FormData(this);

        let cleanedFormData = new FormData();
        for (let [key, value] of formData.entries()) {
            // Only add files that have a name and a size > 0
            if (value instanceof File) {
                if (value.size > 0) {
                    cleanedFormData.append(key, value);
                }
            } else {
                // Keep all your text inputs
                cleanedFormData.append(key, value);
            }
        }



        $.ajax({
            url: '{{ route('update-workbook-application') }}',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response.success) {
                    window.location.href = "{{ route('preview-renewal-data') }}";
                } else {
                    // Re-enable button
                    submitButton.prop('disabled', false).html(originalButtonHtml);

                    if (response.errors) {
                        $('.text-danger').html('');

                        $.each(response.errors, function(field, messages) {
                            const matches = field.match(/^([a-zA-Z_]+)\.(\d+)\.(\d+)$/);

                            if (matches) {
                                const fieldName = matches[1];
                                const groupIndex = matches[2];
                                const subIndex = matches[3];

                                const errorDivId =
                                    `#${fieldName}_${groupIndex}_${subIndex}_error`;

                                if ($(errorDivId).length) {
                                    $(errorDivId).html(messages[0]);
                                }
                            } else {
                                // fallback for flat or single-level fields
                                const fallbackMatches = field.match(
                                    /^([a-zA-Z_]+)\.(\d+)$/);
                                if (fallbackMatches) {
                                    const fieldName = fallbackMatches[1];
                                    const index = fallbackMatches[2];
                                    const errorDivId = `#${fieldName}_${index}_error`;

                                    if ($(errorDivId).length) {
                                        $(errorDivId).html(messages[0]);
                                    }
                                } else {
                                    const errorDivId = `#${field}_error`;
                                    if ($(errorDivId).length) {
                                        $(errorDivId).html(messages[0]);
                                    }
                                }
                            }
                        });


                    }



                }
            },
            error: function(xhr) {
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>
<script>
    function formatDMYToYMD(dateString) {
        if (!dateString) return null;

        const [day, month, year] = dateString.split('-');
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    }
    function formatYMDToDMY(dateString) {
        if (!dateString) return null;

        const [year, month, day] = dateString.split('-');
        return `${day.padStart(2, '0')}-${month.padStart(2, '0')}-${year}`;
    }

    function validateExperienceDates(index) {
        console.log(index)
        const covertedIndex = index.toString().replace('.', '_');
        console.log(covertedIndex)
        const fromDateInput = document.getElementById(`from_date_${covertedIndex}`);
        console.log(fromDateInput)
        const toDateInput = document.getElementById(`to_date_${covertedIndex}`);
        const fromDate = fromDateInput.value;
        const toDate = toDateInput.value;

        const fromErrorEl = document.getElementById(`from_date_${covertedIndex}_error`);
        const toErrorEl = document.getElementById(`to_date_${covertedIndex}_error`);
        fromErrorEl.textContent = '';
        toErrorEl.textContent = '';

        const workbookElement = document.querySelector('[data-workbook-range="' + covertedIndex + '"]');
        console.log(workbookElement)
        const workbookStart = formatDMYToYMD(workbookElement.dataset.start);
        const workbookEnd = formatDMYToYMD(workbookElement.dataset.end);

        // Basic range validation
        if (fromDate < workbookStart || fromDate > workbookEnd) {
            fromErrorEl.textContent = `Date must be between ${workbookElement.dataset.start} and ${workbookElement.dataset.end}`;
            fromDateInput.value = '';
            return;
        }

        if (toDate < workbookStart || toDate > workbookEnd) {
            toErrorEl.textContent = `Date must be between ${workbookElement.dataset.start} and ${workbookElement.dataset.end}`;
            toDateInput.value = '';
            return;
        }

        if (fromDate && toDate && fromDate > toDate) {
            toErrorEl.textContent = 'To date cannot be before From date';
            toDateInput.value = '';
            return;
        }

        // Overlap check
        const allFromInputs = document.querySelectorAll('input[name^="from_date["]');
        const allToInputs = document.querySelectorAll('input[name^="to_date["]');

        for (let i = 0; i < allFromInputs.length; i++) {
            const inputFrom = allFromInputs[i];
            const inputTo = allToInputs[i];

            if (inputFrom.id === fromDateInput.id) continue; // Skip current input

            const otherFrom = inputFrom.value;
            const otherTo = inputTo.value;

            if (!otherFrom || !otherTo) continue;

            // Check if ranges overlap
            const overlap =
                (fromDate <= otherTo && toDate >= otherFrom) || // overlapping condition
                (otherFrom <= toDate && otherTo >= fromDate);

            if (overlap) {
                fromErrorEl.textContent = 'Date range overlaps with another entry';
                toErrorEl.textContent = 'Date range overlaps with another entry';
                fromDateInput.value = '';
                toDateInput.value = '';
                break;
            }
        }
    }

</script>
<script>
    function validateDateCount(index) {
        const isDaysValid = validateDays();
        if (!isDaysValid) {
           return;
        }

        const covertedIndex = index.toString().replace('.', '_');

        const fromDate = document.getElementById(`from_date_${covertedIndex}`).value;

        const toDate = document.getElementById(`to_date_${covertedIndex}`).value;

        const countInput = document.getElementById(`date_count_${covertedIndex}`);

        const count = parseInt(countInput.value);
        const errorField = document.getElementById(`date_count_${covertedIndex}_error`);
        errorField.textContent = '';

        if (!fromDate || !toDate || isNaN(count)) return;

        const from = new Date(fromDate);
        const to = new Date(toDate);



        const actualDays = Math.floor((to - from) / (1000 * 60 * 60 * 24)) + 1;


        if (count > actualDays) {

            document.getElementById(`date_count_${covertedIndex}_error`).textContent =
                'Working Days must not be more than the actual duration';

            document.getElementById(`date_count_${covertedIndex}`).value = '';
            console.log(actualDays)
            console.log(count)

            countInput.value = "";
            countInput.focus();
        }
    }
</script>

<script>

    function validateDays() {
        const elements = [...document.querySelectorAll('[id^="date_count_"]')];

        const groupSums = {};
        let isValid = true;


        elements.forEach(el => {
            const errorEl = document.getElementById(el.id + '_error');
            if (errorEl) {
                errorEl.innerText = '';
            }
        });

        // Group and sum
        elements.forEach(el => {
            const parts = el.id.split('_');
            if (parts.length === 4) {
                const groupKey = parts[2];
                const value = parseFloat(el.value) || 0;

                if (!groupSums[groupKey]) {
                    groupSums[groupKey] = 0;
                }

                groupSums[groupKey] += value;
            }
        });

        // Validate
        Object.entries(groupSums).forEach(([key, sum]) => {
            if (sum < 90) {
                isValid = false;
                const relatedInputs = [...document.querySelectorAll(`[id^="date_count_${key}_"]`)];
//                console.log(relatedInputs)
                relatedInputs.forEach(input => {
                    const errorId = input.id + '_error';
                    const errorEl = document.getElementById(errorId);
                    if (errorEl) {
                        console.log(errorId);
                        errorEl.innerText = 'Total experience in this group must be at least 90 days.';
                        console.log(errorEl.innerText)

                    }
                });
            }
        });

        return isValid;
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pdfViewer = document.getElementById('pdfViewer');
        const pdfModalElement = document.getElementById('pdfModal');
        const pdfModal = new bootstrap.Modal(pdfModalElement);
        let currentInput = null;
        let fileMap = {};

        document.body.addEventListener('change', function (event) {
            if (event.target.matches('input[type="file"][name^="certificate_proof["]')) {
                const file = event.target.files[0];
                const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg'];
                const maxSize = 1 * 1024 * 1024; // 1 MB

                if (file) {
                    const inputId = event.target.id;

                    // Check file type
                    if (!validTypes.includes(file.type)) {
                        alert("Only PDF or JPG/JPEG files are allowed.");
                        event.target.value = '';
                        return;
                    }

                    // Check file size
                    if (file.size > maxSize) {
                        alert("File size should not exceed 1MB.");
                        event.target.value = '';
                        return;
                    }

                    const fileURL = URL.createObjectURL(file);
                    const rowIndex = inputId.split('certificate_proof_').pop();
                    const previewBtn = document.getElementById('preview_file_' + rowIndex);

                    currentInput = event.target;
                    currentInput.dataset.previewUrl = fileURL;
                    fileMap[inputId] = fileURL;

                    // Show file in modal
                    pdfViewer.setAttribute('src', fileURL);
                    pdfModal.show();
                }
            }

        });

        document.querySelector('.confirm-upload-btn').addEventListener('click', function () {
            if (currentInput) {
                const inputId = currentInput.id;
                const rowIndex = inputId.split('certificate_proof_').pop();
                const previewBtn = document.getElementById('preview_file_' + rowIndex);

                previewBtn.classList.remove('d-none');

                previewBtn.onclick = function () {
                    const url = fileMap[inputId];
                    const fileType = currentInput.files[0].type;

                    if (fileType === "application/pdf") {
                        pdfViewer.setAttribute('src', url);
                        pdfModal.show();
                    } else {
                        pdfViewer.setAttribute('src', url);
                        pdfModal.show();
                    }
                };
            }

            pdfViewer.setAttribute('src', '');
            pdfModal.hide();
        });

        document.querySelector('.decline-btn').addEventListener('click', function () {
            if (currentInput) {
                currentInput.value = '';
                delete fileMap[currentInput.id];

                const rowIndex = currentInput.id.split('certificate_proof_').pop();
                const previewBtn = document.getElementById('preview_file_' + rowIndex);
                previewBtn.classList.add('d-none');
            }

            pdfViewer.setAttribute('src', '');
            pdfModal.hide();
        });

        pdfModalElement.addEventListener('hidden.bs.modal', function () {
            pdfViewer.setAttribute('src', '');
        });
    });
</script>

<script>
    function validateFile(input) {
        const file = input.files[0];
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg'];
        const maxSize = 1 * 1024 * 1024; // 1MB

        const dataId = input.dataset.id;

        const covertedIndex = dataId.toString().replace('.', '_');
        const errorElement = document.getElementById(`certificate_proof_${covertedIndex}_error`);
        const previewBtn = document.getElementById(`preview_file_${dataId}`);
        const deleteBtn = document.getElementById(`delete_file_${dataId}`);
        const fileNameSpan = document.getElementById(`file_name_${dataId}`);
        const viewLink = document.getElementById(`view_file_${dataId}`);
        console.log(dataId)


        if (file) {
            if (!allowedTypes.includes(file.type)) {
                errorElement.textContent = 'Only PDF, JPG, and JPEG files are allowed.';
//                input.value = '';
                previewBtn.classList.add('d-none');
                deleteBtn.classList.add('d-none');
                if (fileNameSpan) fileNameSpan.textContent = '';
                if (viewLink) viewLink.classList.remove('d-none');  // Show View again if error
                return;
            }

            if (file.size > maxSize) {
                errorElement.textContent = 'File size must be less than 1MB.';
//                input.value = '';
                previewBtn.classList.add('d-none');
                deleteBtn.classList.add('d-none');
                if (fileNameSpan) fileNameSpan.textContent = '';
                if (viewLink) viewLink.classList.remove('d-none');
                return;
            }

            // Success case
            errorElement.textContent = '';
            previewBtn.classList.remove('d-none');
            deleteBtn.classList.remove('d-none');
            if (fileNameSpan) fileNameSpan.textContent = file.name;

            if (viewLink) viewLink.classList.add('d-none');  // <--- Hide View button when new file chosen
        } else {
            errorElement.textContent = '';
            previewBtn.classList.add('d-none');
            deleteBtn.classList.add('d-none');
            if (fileNameSpan) fileNameSpan.textContent = '';
            if (viewLink) viewLink.classList.remove('d-none');  // Show back the View button if no file
        }
    }

    function deleteSelectedFile(dataId) {
        const covertedIndex = dataId.toString().replace('.', '_');
        const fileInput = document.getElementById(`certificate_proof_${dataId}`);
        const previewBtn = document.getElementById(`preview_file_${dataId}`);
        const deleteBtn = document.getElementById(`delete_file_${dataId}`);
        const fileNameSpan = document.getElementById(`file_name_${dataId}`);
        const errorElement = document.getElementById(`certificate_proof_${covertedIndex}_error`);
        const viewLink = document.getElementById(`view_file_${dataId}`);

        // Clear input and UI
        fileInput.value = '';
        if (viewLink) viewLink.classList.remove('d-none');
        previewBtn.classList.add('d-none');
        deleteBtn.classList.add('d-none');
        if (fileNameSpan) fileNameSpan.textContent = '';
        if (errorElement) errorElement.textContent = '';
    }

</script>

<script>
    function validateFiles(input) {
        const file = input.files[0];
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg'];
        const maxSize = 1 * 1024 * 1024; // 1MB

        const dataId = input.dataset.id;
        console.log(dataId)

        const covertedIndex = dataId.toString().replace('.', '_');
        console.log(covertedIndex)
        const errorElement = document.getElementById(`certificate_proof_${covertedIndex}_error`);
        const previewBtn = document.getElementById(`preview_file_${covertedIndex}`);
        const deleteBtn = document.getElementById(`delete_file_${covertedIndex}`);
        const fileNameSpan = document.getElementById(`file_name_${covertedIndex}`);
        const viewLink = document.getElementById(`view_file_${covertedIndex}`);
//        console.log(dataId)


        if (file) {
            if (!allowedTypes.includes(file.type)) {
                errorElement.textContent = 'Only PDF, JPG, and JPEG files are allowed.';
                input.value = '';
                previewBtn.classList.add('d-none');
                deleteBtn.classList.add('d-none');
                if (fileNameSpan) fileNameSpan.textContent = '';
                if (viewLink) viewLink.classList.remove('d-none');  // Show View again if error
                return;
            }

            if (file.size > maxSize) {
                errorElement.textContent = 'File size must be less than 1MB.';
                input.value = '';
                previewBtn.classList.add('d-none');
                deleteBtn.classList.add('d-none');
                if (fileNameSpan) fileNameSpan.textContent = '';
                if (viewLink) viewLink.classList.remove('d-none');
                return;
            }

            // Success case
            errorElement.textContent = '';
            previewBtn.classList.remove('d-none');
            deleteBtn.classList.remove('d-none');
            if (fileNameSpan) fileNameSpan.textContent = file.name;

            if (viewLink) viewLink.classList.add('d-none');  // <--- Hide View button when new file chosen
        } else {
            errorElement.textContent = '';
            previewBtn.classList.add('d-none');
            deleteBtn.classList.add('d-none');
            if (fileNameSpan) fileNameSpan.textContent = '';
            if (viewLink) viewLink.classList.remove('d-none');  // Show back the View button if no file
        }
    }

    function deleteSelectedFile(dataId) {
        const covertedIndex = dataId.toString().replace('.', '_');
        const fileInput = document.getElementById(`certificate_proof_${covertedIndex}`);
        const previewBtn = document.getElementById(`preview_file_${covertedIndex}`);
        const deleteBtn = document.getElementById(`delete_file_${covertedIndex}`);
        const fileNameSpan = document.getElementById(`file_name_${covertedIndex}`);
        const errorElement = document.getElementById(`certificate_proof_${covertedIndex}_error`);
        const viewLink = document.getElementById(`view_file_${covertedIndex}`);

        // Clear input and UI
        fileInput.value = '';
        if (viewLink) viewLink.classList.remove('d-none');
        previewBtn.classList.add('d-none');
        deleteBtn.classList.add('d-none');
        if (fileNameSpan) fileNameSpan.textContent = '';
        if (errorElement) errorElement.textContent = '';
    }

</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pdfViewer = document.getElementById('pdfViewer'); // Assuming iframe
        const imageViewer = document.getElementById('imageViewer'); // Add this element in modal (img tag)
        const pdfModalElement = document.getElementById('pdfModal');
        const pdfModal = new bootstrap.Modal(pdfModalElement);

        let currentInput = null;
        let fileMap = {};

        document.addEventListener('change', function (event) {
            const input = event.target;

            if (input.matches('input[type="file"][name="certificate_proof[]"]')) {
                const file = input.files[0];

                if (file && (file.type === "application/pdf" || file.type === "image/jpeg")) {
                    const inputId = input.id;
                    const fileURL = URL.createObjectURL(file);

                    currentInput = input;
                    currentInput.dataset.previewUrl = fileURL;
                    currentInput.dataset.fileType = file.type;

                    // Show the appropriate viewer
                    if (file.type === "application/pdf") {
                        pdfViewer.classList.remove('d-none');
                        imageViewer.classList.add('d-none');
                        pdfViewer.setAttribute('src', fileURL);
                    } else {
                        pdfViewer.classList.add('d-none');
                        imageViewer.classList.remove('d-none');
                        imageViewer.setAttribute('src', fileURL);
                    }

                    pdfModal.show();
                } else {
                    alert("Please select a valid PDF or JPG file.");
                    input.value = '';
                }
            }
        });

        document.querySelector('.confirm-upload-btn').addEventListener('click', function () {
            if (currentInput) {
                const inputId = currentInput.id;
                const rowIndex = inputId.split('_').pop();
                const previewBtn = document.getElementById('preview_file_' + rowIndex);

                fileMap[inputId] = {
                    url: currentInput.dataset.previewUrl,
                    type: currentInput.dataset.fileType
                };

                previewBtn.classList.remove('d-none');
                previewBtn.onclick = function () {
                    const fileData = fileMap[inputId];
                    if (fileData) {
                        if (fileData.type === "application/pdf") {
                            pdfViewer.classList.remove('d-none');
                            imageViewer.classList.add('d-none');
                            pdfViewer.setAttribute('src', fileData.url);
                        } else {
                            pdfViewer.classList.add('d-none');
                            imageViewer.classList.remove('d-none');
                            imageViewer.setAttribute('src', fileData.url);
                        }
                        pdfModal.show();
                    }
                };
            }

            pdfViewer.setAttribute('src', '');
            imageViewer.setAttribute('src', '');
            pdfModal.hide();
        });

        document.querySelector('.decline-btn').addEventListener('click', function () {
            if (currentInput) {
                currentInput.value = '';
                delete fileMap[currentInput.id];

                const rowIndex = currentInput.id.split('_').pop();
                const previewBtn = document.getElementById('preview_file_' + rowIndex);
                previewBtn.classList.add('d-none');
            }

            pdfViewer.setAttribute('src', '');
            imageViewer.setAttribute('src', '');
            pdfModal.hide();
        });

        pdfModalElement.addEventListener('hidden.bs.modal', function () {
            pdfViewer.setAttribute('src', '');
            imageViewer.setAttribute('src', '');
        });
    });
</script>
