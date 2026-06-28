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
                        <h6 class="mb-0">
                            <i class="fas fa-book-open me-2"></i> Working Record Book
                            <span class="badge bg-light text-dark ms-2 rounded-pill">Renewal Application</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="workbook-entries">
                        @for ($i = 0; $i < $total_years_since_last_renewal; $i++)
                                    <div class=" mb-2 p-3 border rounded">

                                        <div
                                            class="experience-label d-flex align-items-center justify-content-between bg-light rounded shadow-sm p-3 border-start border-primary border-4">
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-danger shadow-sm experience-badge"
                                                    id="experience_tag_{{ $i }}">
                                                    #{{ $i + 1 }}
                                                </span>&nbsp;
                                                <i class="fas fa-briefcase text-primary me-2 fs-5"></i>
                                                <span class="fw-bold text-dark"

                                                      id="experience_tag_{{ $i }}_0">
                                                    Working Record Book Details: <span
                                                        class="text-primary">{{ $date_ranges[$i]['from'] }}</span> to
                                                    <span class="text-primary">{{ $date_ranges[$i]['to'] }}</span>
                                                </span>
                                            </div>
                                        </div>


                                        <div class="row g-2 mb-1 workbook-entry">
                                            <!-- Type of Work -->
                                            <div class="col-md-3 px-1 mt-2">
                                                <label class="form-label">Type Of Construction Work <span
                                                        style="color: red">*</span></label>
                                                <select name="type_of_work[{{ $i }}.0]"
                                                    id="type_of_work_{{ $i }}_0"
                                                    class="form-control form-select"
                                                    onchange="checkTypeOfWorkOthers({{ $i }}.0)">
                                                    <option value="">Select work type</option>
                                                    @foreach ($worktype as $work)
                                                        <option value="{{ $work->work_type_code }}">
                                                            {{ $work->work_type_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="text"
                                                    name="type_of_work_others[{{ $i }}.0]"
                                                    id="type_of_work_others_{{ $i }}_0"
                                                    class="form-control mt-1 d-none" placeholder="Specify work type">
                                                <div class="text-danger"
                                                    id="type_of_work_{{ $i }}_0_error"></div>
                                            </div>

                                            <!-- Dates -->
                                            <div class="col-md-3 px-1 mt-2">
                                                <label class="form-label">From Date <span
                                                        style="color: red">*</span></label>
                                                <input type="date" name="from_date[{{ $i }}.0]"
                                                    id="from_date_{{ $i }}_0" class="form-control"
                                                    min="{{ $date_ranges[$i]['from'] }}.0"
                                                    max="{{ $date_ranges[$i]['to'] }}.0"
                                                    onchange="validateExperienceDates('{{ $i }}.0')">
                                                <span class="text-danger"
                                                    id="from_date_{{ $i }}_0_error"></span>
                                            </div>

                                            <div class="col-md-3 px-1 mt-2">
                                                <label class="form-label">To Date <span
                                                        style="color: red">*</span></label>
                                                <input type="date" name="to_date[{{ $i }}.0]"
                                                    id="to_date_{{ $i }}_0" class="form-control"
                                                    min="{{ $date_ranges[$i]['from'] }}"
                                                    max="{{ $date_ranges[$i]['to'] }}"
                                                    onchange="validateExperienceDates('{{ $i }}.0')">
                                                <span class="text-danger"
                                                    id="to_date_{{ $i }}_0_error"></span>
                                            </div>





                                            <div class="col-md-3 px-1 mt-2">
                                                <label class="form-label">Actual Days Worked <span
                                                        style="color: red">*</span></label>
                                                <input type="number" name="date_count[{{ $i }}.0]"
                                                    class="form-control" placeholder="Days" min="1"
                                                    id="date_count_{{ $i }}_0"
                                                    onblur="validateDateCount('{{ $i }}_0')">

                                                <div class="text-danger" id="date_count_{{ $i }}_0_error">
                                                </div>
                                            </div>

                                            <div class="col-12 mb-3" data-workbook-range="{{ $i }}.0"
                                                data-start="{{ $date_ranges[$i]['from'] }}"
                                                data-end="{{ $date_ranges[$i]['to'] }}">
                                                <p class="text-muted">
                                                    Workbook Date Range:
                                                    <span class="text-primary">{{ $date_ranges[$i]['from'] }}</span>
                                                    to
                                                    <span class="text-primary">{{ $date_ranges[$i]['to'] }}</span>
                                                </p>
                                            </div>

                                            <!-- Employer Info -->
                                            <div class="col-md-3 px-1 mt-2">
                                                <label class="form-label">Employer Name <span
                                                        style="color: red">*</span></label>
                                                <input type="text"
                                                    name="employer_name_certi[{{ $i }}.0]"
                                                    class="form-control" placeholder="Employer name"
                                                    id="employer_name_certi_{{ $i }}_0">
                                                <div class="text-danger"
                                                    id="employer_name_certi_{{ $i }}_0_error"></div>
                                            </div>

                                            <div class="col-md-3 px-1 mt-2">
                                                <label class="form-label">Employer Contact <span
                                                        style="color: red">*</span></label>
                                                <div class="input-group">
                                                    <input type="text"
                                                        name="employer_contact_number[{{ $i }}.0]"
                                                        class="form-control" placeholder="Contact number"
                                                        maxlength="10" pattern="[0-9]{10}"
                                                        id="employer_contact_number_{{ $i }}_0">
                                                </div>
                                                <div class="text-danger"
                                                    id="employer_contact_number_{{ $i }}_0_error"></div>
                                            </div>

                                            <div class="col-md-3 px-1 mt-2">
                                                <label class="form-label">Type Of Employer <span
                                                        style="color: red">*</span></label>
                                                <select name="type_of_employer[{{ $i }}.0]"
                                                    class="form-control form-select"
                                                    id="type_of_employer_{{ $i }}_0">
                                                    <option value="">Select employer type</option>
                                                    @foreach ($type_of_employers as $employers)
                                                        <option value="{{ $employers->employer_code }}">
                                                            {{ $employers->employer_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger"
                                                    id="type_of_employer_{{ $i }}_0_error"></div>
                                            </div>

                                            <!-- Profession -->
                                            <div class="col-md-3 px-1 mt-2">
                                                <label class="form-label">Profession <span
                                                        style="color: red">*</span></label>
                                                <div class="input-group">
                                                    <select name="profession[{{ $i }}.0]"
                                                        class="form-control form-select"
                                                        id="profession_{{ $i }}_0"
                                                        onchange="checkOthers({{ $i }})">
                                                        <option value="">Select profession</option>
                                                        @foreach ($professions as $profession)
                                                            <option value="{{ $profession->profession_code }}">
                                                                {{ $profession->profession_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text"
                                                        name="profession_others[{{ $i }}.0]"
                                                        id="others_{{ $i }}_0" class="form-control d-none"
                                                        placeholder="Other profession">
                                                </div>
                                                <div class="text-danger" id="profession_{{ $i }}_0_error">
                                                </div>
                                            </div>

                                            <!-- File Upload -->
                                            <div class="col-md-6 px-1 mt-2">
                                                <label class="form-label">Working Record Book <span style="color: red">*</span></label>
                                                <div id="file-inputs">
                                                    <div class="file-input-wrapper mb-3">
                                                        <div>
                                                            <label for="certificate_proof_{{ $i }}_0" class="btn btn-sm btn-outline-primary me-2 mb-0">
                                                                <i class="fas fa-upload me-1"></i> Upload (Max 1MB)
                                                            </label>
                                                            <small class="text-danger d-block mb-1" style="font-weight: 600">Please upload workbook data showing at least 90 days of work
                                                                completed during the period
                                                                <span
                                                                        class="text-primary">{{ $date_ranges[$i]['from'] }}</span> to
                                                                <span class="text-primary">{{ $date_ranges[$i]['to'] }}</span>
                                                            </small>
                                                            <small class="text-muted d-block">Only PDF JPG & JPEG files accepted</small>

                                                            <input type="file"
                                                                   name="certificate_proof[{{ $i }}.0]"
                                                                   id="certificate_proof_{{ $i }}_0"
                                                                   class="form-control d-none"
                                                                   data-id="{{ $i }}_0"
                                                                   accept="application/pdf,image/jpeg,image/jpg"
                                                                   onchange="validateFile(this)">

                                                            <button type="button"
                                                                    class="btn btn-sm btn-success d-none preview-file-btn"
                                                                    id="preview_file_{{ $i }}_0">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </button>

                                                            <button type="button"
                                                                    class="btn btn-sm btn-danger d-none delete-file-btn"
                                                                    id="delete_file_{{ $i }}_0"
                                                                    onclick="deleteSelectedFile('{{ $i }}_0')">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>

                                                            <span class="ms-2 text-secondary small file-name" id="file_name_{{ $i }}_0"></span>
                                                        </div>
                                                        <span class="text-danger" id="certificate_proof_{{ $i }}_0_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12  d-flex justify-content-end">
                                                <button type="button"
                                                    class="btn btn-outline-primary add-more-experience"
                                                    data-row-index="{{ $i }}">
                                                    <i class="fas fa-plus-circle me-1"></i> Add More Experience
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                @endfor
                                    <div class="d-flex justify-content-end mt-4">
                                        <div>
                                            <button type="submit" class="btn btn-success custom-btn">
                                                <i class="fas fa-save me-1"></i> Save Workbook Details
                                            </button>
                                        </div>
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
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <iframe id="pdfViewer" style="width: 100%; height: 70vh; border: none;"></iframe>
                            <img id="imageViewer" class="w-100 d-none" style="max-height:500px;" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary decline-btn" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Clear
                            </button>
                            <button type="button" class="btn btn-primary confirm-upload-btn">
                                <i class="fas fa-check me-1"></i> Confirm Upload
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

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
{{-- <button type="button" onclick="validateDays()">test button</button> --}}


@include('components.footer')
<link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
<script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const workerPhone = '{{ $wmf->phone_no }}';

        // Attach event listener to the parent container (adjust selector if needed)
        document.body.addEventListener('keyup', function (e) {
            const input = e.target;

            // Check if input matches the employer contact number field pattern
            if (input.matches('input[name^="employer_contact_number"]')) {
                const inputId = input.id;
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
                const inputId = input.id;
                const errorDiv = document.getElementById(inputId + '_error');
                const value = input.value.trim();

                // Reset previous error
                errorDiv.textContent = "";
                input.classList.remove('is-invalid');

                // Validation
                if (value.length < 3) {
                    errorDiv.textContent = "Employer name must be at least 3 characters long.";
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
                    // Re-enable button
                    submitButton.prop('disabled', false).html(originalButtonHtml);

                    if (response.errors) {
                        $('.text-danger').html('');

                        $.each(response.errors, function(field, messages) {
                            const matches = field.match(/^([a-zA-Z0-9_]+)\.(\d+)\.(\d+)$/);

                            if (matches) {
                                const fieldName = matches[1];
                                const groupIndex = matches[2];
                                const subIndex = matches[3];
//                                const errorDivId = `#${field.replace(/\./g, '_')}_error`;
                                const errorDivId = `#${fieldName}_${groupIndex}_${subIndex}_error`;

                                if ($(errorDivId).length) {
                                    $(errorDivId).html(messages[0]);
                                }
                            } else {
                                const fallbackMatches = field.match(/^([a-zA-Z_]+)\.(\d+)$/);
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
                // Re-enable button
                submitButton.prop('disabled', false).html(originalButtonHtml);
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>



<script>

    function validateDays() {
        const elements = [...document.querySelectorAll('[id^="date_count_"]')];
        console.log(elements)

        const groupSums = {};
        let isValid = true;

        // Clear all error messages first
        elements.forEach(el => {
            const errorEl = document.getElementById(el.id + '_error');
            console.log(errorEl)
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
                relatedInputs.forEach(input => {
                    const errorId = input.id + '_error';
                    const errorEl = document.getElementById(errorId);
                    if (errorEl) {
                        console.log(errorId);
                        errorEl.innerText = 'Total experience in this group must be at least 90 days.';
                    }
                });
            }
        });

        return isValid;
    }
</script>



<script>


    let totalExperienceCount = 0;


        totalExperienceCount = {{ $total_years_since_last_renewal }};



    function generateWorkbookEntry(index, oldIndex) {
        const dateRanges = @json($date_ranges);
        const range = dateRanges[oldIndex] || {
            from: '',
            to: ''
        };

        const covertedIndex = index.toString().replace('.', '_');

        return `
            <div class="mb-4 p-3 border rounded">


                <div class="row g-2 mb-1 workbook-entry">

            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Type Of Construction Work <span style="color: red">*</span></label>
            <select name="type_of_work[${index}]" id="type_of_work_${covertedIndex}" class="form-control form-select" onchange="checkTypeOfWorkOthers(${index})">
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
            <div class="input-group">
            <input type="date" name="from_date[${index}]" class="form-control" placeholder="DD-MM-YYYY" id="from_date_${covertedIndex}" min="${range.from}" max="${range.to}"
             onchange="validateExperienceDates(${index})">
            </div>
            <div class="text-danger" id="from_date_${covertedIndex}_error"></div>
            </div>
            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">End Date <span style="color: red">*</span></label>
            <div class="input-group">
            <input type="date" name="to_date[${index}]" class="form-control" placeholder="DD-MM-YYYY" min="${range.from}" max="${range.to}"
                       onchange="validateExperienceDates(${index})" id="to_date_${covertedIndex}">
            </div>
            <div class="text-danger" id="to_date_${covertedIndex}_error"></div>
            </div>



            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Actual days Worked<span style="color: red">*</span></label>
            <input type="number" name="date_count[${index}]" class="form-control" onblur="validateDateCount('${covertedIndex}')"  placeholder="Days" min="1" id="date_count_${covertedIndex}">
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
            <input type="text" name="employer_name_certi[${index}]" class="form-control" placeholder="Employer name" id="employer_name_certi_${covertedIndex}">
            <div class="text-danger" id="employer_name_certi_${covertedIndex}_error"></div>
            </div>

            <div class="col-md-3 px-1 mt-2">
            <label class="form-label">Employer Contact <span style="color: red">*</span></label>
            <div class="input-group">
            <input type="text" name="employer_contact_number[${index}]" class="form-control" placeholder="Contact number" maxlength="10" pattern="[0-9]{10}" id="employer_contact_number_${covertedIndex}">
            </div>
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
            <div class="input-group">
            <select name="profession[${index}]" class="form-control form-select" id="profession_${covertedIndex}" onchange="checkOthers(${index})">
            <option value="">Select profession</option>
                @foreach ($professions as $profession)
            <option value="{{ $profession->profession_code }}">{{ $profession->profession_name }}</option>
                @endforeach
            </select>
            <input type="text" name="profession_others[${index}]" id="others_${covertedIndex}" class="form-control d-none" placeholder="Other profession">
            </div>
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
            onchange="validateFile(this)">


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
    let experienceClickCount = {};
    let indexClick = {};
    $(document).on('click', '.add-more-experience', function() {
        const newIndex = totalExperienceCount++;
        console.log(newIndex)
        const rowIndex = $(this).data('row-index');
        console.log(rowIndex)
        if (!experienceClickCount[rowIndex]) {
            experienceClickCount[rowIndex] = 0;

        }

        experienceClickCount[rowIndex]++;
        indexClick[rowIndex] = rowIndex + '.' + experienceClickCount[rowIndex]
        const rowindex = indexClick[rowIndex];
        console.log(indexClick[rowIndex])

        console.log(experienceClickCount[rowIndex]);

        const newEntryHTML = generateWorkbookEntry(rowindex, rowIndex);

        $(this).closest('.workbook-entry').parent().append(newEntryHTML);
    });


    function removeEntry(button) {
        if ($('.workbook-entry').length > 1 && confirm('Are you sure you want to remove this entry?')) {
            $(button).closest('.mb-4').remove();
        }
    }


    function checkOthers(index) {
        const professionSelect = $(`#profession_${index}`);
        const othersInput = $(`#others_${index}`);

        if (professionSelect.val() === 'OTHERS') {
            othersInput.removeClass('d-none').prop('required', true);
        } else {
            othersInput.addClass('d-none').prop('required', false);
        }
    }


    function checkTypeOfWorkOthers(index) {
        const workTypeSelect = $(`#type_of_work_${index}`);
        const othersInput = $(`#type_of_work_others_${index}`);

        if (workTypeSelect.val() === 'Others') {
            othersInput.removeClass('d-none').prop('required', true);
        } else {
            othersInput.addClass('d-none').prop('required', false);
        }
    }
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
        const covertedIndex = index.toString().replace('.', '_');
        const fromDateInput = document.getElementById(`from_date_${covertedIndex}`);
        const toDateInput = document.getElementById(`to_date_${covertedIndex}`);
        const fromDate = fromDateInput.value;
        const toDate = toDateInput.value;

        const fromErrorEl = document.getElementById(`from_date_${covertedIndex}_error`);
        const toErrorEl = document.getElementById(`to_date_${covertedIndex}_error`);
        fromErrorEl.textContent = '';
        toErrorEl.textContent = '';

        const workbookElement = document.querySelector('[data-workbook-range="' + index + '"]');
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

        if (fromDate && toDate) {
            console.log('hii')
            const baseIndex = index.toString().split('.')[0];
            console.log(baseIndex)
            const addMoreBtn = document.querySelector(`.add-more-experience[data-row-index="${baseIndex}"]`);
            console.log(addMoreBtn)

            const coversFullYear = fromDate <= workbookStart && toDate >= workbookEnd;

            if(addMoreBtn)
            {
                if(coversFullYear)
                {
                    addMoreBtn.disabled = true;
                    addMoreBtn.classList.add('disabled');
                    addMoreBtn.title = "Cannot add more experiences - this entry already covers the full year block";

                    if (!document.getElementById(`full_year_warning_${covertedIndex}`)) {
                        const warningMsg = document.createElement('div');
                        warningMsg.className = 'text-warning small mt-1';
                        warningMsg.id = `full_year_warning_${covertedIndex}`;
                        warningMsg.textContent = 'This entry covers the full year block - no more experiences can be added for this period';
                        workbookElement.appendChild(warningMsg);

                    }else{
                        addMoreBtn.disabled = false;
                        addMoreBtn.classList.remove('disabled');
                        addMoreBtn.title = "";

                        const warningMsg = document.getElementById(`full_year_warning_${covertedIndex}`);
                        if (warningMsg) {
                            warningMsg.remove();
                        }
                    }
                }
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
        if (actualDays < 0) {
            errorField.textContent = 'To Date must be after From Date';
            countInput.value = '';
            countInput.focus();
            return;
        }

        if (count > actualDays) {

            document.getElementById(`date_count_${covertedIndex}_error`).textContent =
                'Working Days must not be more than the actual duration';

            document.getElementById(`date_count_${covertedIndex}`).value = '';

            countInput.value = "";
            countInput.focus();
        }
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
        const previewBtn = document.getElementById(`preview_file_${covertedIndex}`);
        const deleteBtn = document.getElementById(`delete_file_${covertedIndex}`);
        const fileNameSpan = document.getElementById(`file_name_${covertedIndex}`);

        if (file) {
            if (!allowedTypes.includes(file.type)) {
                errorElement.textContent = 'Only PDF, JPG, and JPEG files are allowed.';
                input.value = '';
                previewBtn.classList.add('d-none');
                deleteBtn.classList.add('d-none');
                if (fileNameSpan) fileNameSpan.textContent = '';
                return;
            }

            if (file.size > maxSize) {
                errorElement.textContent = 'File size must be less than 1MB.';
                input.value = '';
                previewBtn.classList.add('d-none');
                deleteBtn.classList.add('d-none');
                if (fileNameSpan) fileNameSpan.textContent = '';
                return;
            }

            // Success case
            errorElement.textContent = '';
            previewBtn.classList.remove('d-none');
            deleteBtn.classList.remove('d-none');
            if (fileNameSpan) fileNameSpan.textContent = file.name;
        } else {
            errorElement.textContent = '';
            previewBtn.classList.add('d-none');
            deleteBtn.classList.add('d-none');
            if (fileNameSpan) fileNameSpan.textContent = '';
        }
    }

    function deleteSelectedFile(dataId) {
        const covertedIndex = dataId.toString().replace('.', '_');
        const fileInput = document.getElementById(`certificate_proof_${covertedIndex}`);
        const previewBtn = document.getElementById(`preview_file_${covertedIndex}`);
        const deleteBtn = document.getElementById(`delete_file_${covertedIndex}`);
        const fileNameSpan = document.getElementById(`file_name_${covertedIndex}`);
        const errorElement = document.getElementById(`certificate_proof_${covertedIndex}_error`);

        // Clear input and UI
        fileInput.value = '';
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

