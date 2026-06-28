@extends('layouts.admin-app')

@section('title', 'Office | Application | ' . ucfirst('Benefit Overview'))
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Digital Signature')
@section('header')
    {{-- header for file link --}}
@endsection

<style>
    .tab-panel {
        min-height: 500px;
        /* Or whatever height works for your content */
        position: relative;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100;
    }

    .tab-container {
        width: 90%;
        margin: 50px auto;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .tab-container button:focus {
        outline: none
    }

    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #ddd;
    }

    .tab-button {
        padding: 10px 5px;
        background: #156092;
        border: none;
        border-right: 1px solid #2d94d9;
        cursor: pointer;
        flex: 1;
        transition: all 0.3s;
        color: white;
    }

    .tab-button:hover {
        background: #2196f3;
    }

    .tab-button.active {
        background: #2196f3;
        color: white;
        outline: none;
        border: none;
    }

    .tab-content {
        padding: 20px;
    }

    .tab-panel {
        display: none;
    }

    .tab-panel.active {
        display: block;
        animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>


@section('content')

    <div class="container-fluid">
        <div>
            <div class="tab-container">
                @include('office.benefits.tabs')
                <div class="tab-content">


                    <div class="tab-panel active" id="tab4">
                        <div class="container-fluid mt-4">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                                    <h5 class="mb-0 text-primary"><i class="fas fa-gavel me-2"></i> Scrutiny Meeting Results
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <label for="meetingDateFilter" class="me-2 fw-bold mb-0">Select Meeting
                                            Date:</label>
                                        <form method="GET" action="{{ route('office.dashboard.benefit.ho-forwarding') }}"
                                            id="dateFilterForm" class="mb-0">
                                            <select class="form-select form-select-sm border-primary" id="meetingDateFilter"
                                                name="meeting_date"
                                                onchange="document.getElementById('dateFilterForm').submit()">
                                                @if ($availableDates->isEmpty())
                                                    <option disabled>No meetings scheduled</option>
                                                @else
                                                    @foreach ($availableDates as $date)
                                                        <option value="{{ $date }}"
                                                            {{ $selectedDate == $date ? 'selected' : '' }}>
                                                            {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </form>
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if ($hoForwardingApplications->isEmpty())
                                        <div class="alert alert-info text-center">
                                            No applications found for the selected meeting date.
                                        </div>
                                    @else
                                        <form id="meetingResultsForm">
                                            @csrf
                                            <input type="hidden" name="meeting_date" value="{{ $selectedDate }}">

                                            <div class="table-responsive mb-4">
                                                <table id="hoForwardingTable"
                                                    class="table table-striped table-bordered align-middle">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>App ID</th>
                                                            <th>Applicant Details</th>
                                                            <th>Scheme</th>
                                                            <th>Sanctioned Amount</th>
                                                            <th>Action</th>
                                                            <th width="200px">Decision <span class="text-danger">*</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hoForwardingApplications as $submission)
                                                            <tr>
                                                                <td>{{ $submission->application_id }}</td>
                                                                <td>
                                                                    <strong>{{ $submission->getApplicantDetails()->name ?? 'N/A' }}</strong><br>
                                                                    <small
                                                                        class="text-muted">{{ $submission->worker->districtName->name ?? '' }}</small>
                                                                </td>
                                                                <td>{{ $submission->benefit->name ?? 'N/A' }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <span class="sanctioned-display" data-id="{{ $submission->id }}">{{ $submission->sanctioned_amount ?? '--' }}</span>&nbsp;&nbsp;
                                                                        <input type="text" class="form-control form-control-sm sanctioned-input d-none" data-id="{{ $submission->id }}" value="{{ $submission->sanctioned_amount ?? '' }}" style="width:120px;">
                                                                        <input type="hidden" name="sanctioned_amounts[{{ $submission->id }}]" class="sanctioned-hidden" data-id="{{ $submission->id }}" value="{{ $submission->sanctioned_amount ?? '' }}">

                                                                        @if($submission->benefit->name!='EA')
                                                                            <div class="btn-group btn-group-sm" role="group">
                                                                                <button type="button" class="btn btn-outline-primary edit-amount-btn" data-id="{{ $submission->id }}" title="Edit Amount">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </button>
                                                                                <button type="button" class="btn btn-success save-amount-btn d-none" data-id="{{ $submission->id }}" title="Save Amount">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                                <button type="button" class="btn btn-secondary cancel-amount-btn d-none" data-id="{{ $submission->id }}" title="Cancel">
                                                                                    <i class="fas fa-times"></i>
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="btn-group shadow-sm rounded-3">
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm preview-button"
                                                                            data-id="{{ $submission->application_id }}"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Preview Application">
                                                                            <i class="fas fa-eye"></i>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm view-log-btn"
                                                                            data-id="{{ $submission->id }}"
                                                                            data-bs-toggle="tooltip"
                                                                            title="View Action Log">
                                                                            <i class="fas fa-history"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <select name="decisions[{{ $submission->id }}]"
                                                                        class="form-select form-select-sm" required>
                                                                        <option value="" selected disabled>Select
                                                                            Action...</option>
                                                                        <option value="forward">Forward to HO</option>
                                                                        <option value="revert">Revert (Send Back)</option>
                                                                        <option value="reject">Reject Application</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <hr>

                                            <h5 class="mb-3">Upload Meeting Documents</h5>
                                            <div class="row g-3 bg-light p-3 rounded">
                                                <div class="col-md-6">
                                                    <label class="form-label">Meeting Minutes <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" name="meetingMinutes"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Attendance Sheet <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" name="attendanceSheet"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Accepted List <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" name="acceptedList" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Rejected List <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" name="rejectedList" required>
                                                </div>
                                            </div>

                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg px-5"
                                                    id="submitMeetingBtn">
                                                    <span class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true" style="display: none;"></span>
                                                    <span class="btn-text">Submit Meeting Results</span>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="card mt-5 shadow border-top border-success border-4">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-success"><i class="fas fa-history me-2"></i> Scrutiny Meeting
                                        History & Reports</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Meeting Date</th>
                                                    <th>Processed By</th>
                                                    <th>Meeting Documents</th>
                                                    <th class="text-center">Application Report</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($uploadHistory as $history)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ \Carbon\Carbon::parse($history->submission_date)->format('F j, Y') }}</strong>
                                                        </td>
                                                        <td>{{ $history->user->username ?? 'N/A' }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('office.dashboard.benefits.ho-forwarding.document.show', ['document' => $history->id, 'type' => 'minutes']) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-secondary btn-sm"
                                                                    data-bs-toggle="tooltip" title="Meeting Minutes">
                                                                    <i class="fas fa-file-pdf"></i> Minutes
                                                                </a>
                                                                <a href="{{ route('office.dashboard.benefits.ho-forwarding.document.show', ['document' => $history->id, 'type' => 'attendance']) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-secondary btn-sm"
                                                                    data-bs-toggle="tooltip" title="Attendance Sheet">
                                                                    <i class="fas fa-users"></i> Attendance
                                                                </a>
                                                                <a href="{{ route('office.dashboard.benefits.ho-forwarding.document.show', ['document' => $history->id, 'type' => 'accepted']) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-secondary btn-sm"
                                                                    data-bs-toggle="tooltip" title="Accepted List">
                                                                    <i class="fas fa-check-circle"></i> Accepted
                                                                </a>
                                                                <a href="{{ route('office.dashboard.benefits.ho-forwarding.document.show', ['document' => $history->id, 'type' => 'rejected']) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-secondary btn-sm"
                                                                    data-bs-toggle="tooltip" title="Rejected List">
                                                                    <i class="fas fa-times-circle"></i> Rejected
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('office.dashboard.benefits.ho-forwarding.export-report', ['date' => $history->submission_date]) }}"
                                                                class="btn btn-success btn-sm shadow-sm">
                                                                <i class="fas fa-file-excel me-1"></i> Download App Report
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted py-4">
                                                            <i class="fas fa-folder-open mb-2 fs-4"></i><br>
                                                            No past meetings or documents have been recorded yet.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content border-0 rounded-4 shadow-lg">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title fw-bold" id="previewModalLabel"><i
                                    class="fas fa-file-alt text-primary me-2"></i>Application Preview</h5>
                            <button type="button" class="btn-close" data-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center p-5">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2 text-muted">Loading application data...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content border-0 rounded-4 shadow-lg">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title fw-bold" id="logModalLabel"><i
                                    class="fas fa-history text-secondary me-2"></i>Application Action Log</h5>
                            <button type="button" class="btn-close" data-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="log-modal-body">
                            <div class="text-center p-5">
                                <div class="spinner-border text-secondary" role="status"></div>
                                <p class="mt-2 text-muted">Fetching application history...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                $(function() {
                    // --- Inline edit handlers for sanctioned amount ---
                    $(document).on('click', '.edit-amount-btn', function() {
                        const id = $(this).data('id');
                        $(`.sanctioned-display[data-id="${id}"]`).addClass('d-none');
                        $(`.sanctioned-input[data-id="${id}"]`).removeClass('d-none');
                        $(this).addClass('d-none');
                        $(`.save-amount-btn[data-id="${id}"]`).removeClass('d-none');
                        $(`.cancel-amount-btn[data-id="${id}"]`).removeClass('d-none');
                    });

                    $(document).on('click', '.cancel-amount-btn', function() {
                        const id = $(this).data('id');
                        const hidden = $(`.sanctioned-hidden[data-id="${id}"]`).val();
                        $(`.sanctioned-input[data-id="${id}"]`).val(hidden).addClass('d-none');
                        $(`.sanctioned-display[data-id="${id}"]`).removeClass('d-none');
                        $(`.edit-amount-btn[data-id="${id}"]`).removeClass('d-none');
                        $(`.save-amount-btn[data-id="${id}"]`).addClass('d-none');
                        $(this).addClass('d-none');
                    });

                    $(document).on('click', '.save-amount-btn', function() {
                        const id = $(this).data('id');
                        const input = $(`.sanctioned-input[data-id="${id}"]`);
                        let val = input.val().trim();
                        // Normalize empty to empty string
                        if (val === '') val = '';
                        // Basic numeric validation (allow decimals)
                        if (val !== '' && !/^[0-9]+(\.[0-9]{1,2})?$/.test(val)) {
                            Swal.fire('Invalid Amount', 'Please enter a valid number (up to 2 decimals).', 'warning');
                            return;
                        }
                        // Update display and hidden input
                        $(`.sanctioned-hidden[data-id="${id}"]`).val(val);
                        $(`.sanctioned-display[data-id="${id}"]`).text(val === '' ? '--' : val).removeClass('d-none');
                        input.addClass('d-none');

                        $(`.edit-amount-btn[data-id="${id}"]`).removeClass('d-none');
                        $(`.save-amount-btn[data-id="${id}"]`).addClass('d-none');
                        $(`.cancel-amount-btn[data-id="${id}"]`).addClass('d-none');
                    });

                    // --- Checkbox and Bulk Button Logic ---
                    const selectAllCheckbox = $('#selectAllHO');
                    const itemCheckboxes = $('.ho-checkbox');
                    const bulkButtons = $('.bulk-action-btn');

                    function updateBulkButtonState() {
                        const anyChecked = itemCheckboxes.is(':checked');
                        bulkButtons.prop('disabled', !anyChecked);
                    }

                    selectAllCheckbox.on('change', function() {
                        itemCheckboxes.prop('checked', $(this).is(':checked'));
                        updateBulkButtonState();
                    });

                    itemCheckboxes.on('change', function() {
                        updateBulkButtonState();
                    });

                    // --- Bulk Action Handler ---
                    bulkButtons.on('click', function() {
                        const action = $(this).data('action');
                        const selectedIds = [];
                        itemCheckboxes.filter(':checked').each(function() {
                            selectedIds.push($(this).data('id'));
                        });

                        if (selectedIds.length === 0) {
                            Swal.fire('No Selection', 'Please select at least one application.', 'warning');
                            return;
                        }

                        Swal.fire({
                            title: `Confirm Action: ${action.charAt(0).toUpperCase() + action.slice(1)}`,
                            text: `Are you sure you want to ${action} ${selectedIds.length} application(s)? This action cannot be undone.`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: `Yes, ${action} them!`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                performBulkAction(action, selectedIds);
                            }
                        });
                    });

                    $(document).on('submit', '#meetingResultsForm', function(e) {
                        e.preventDefault(); // FORCE the page to not reload
                        console.log("Form submit triggered!");

                        // Ensure all dropdowns have a decision selected
                        let allSelected = true;
                        $('select[name^="decisions"]').each(function() {
                            if (!$(this).val()) allSelected = false;
                        });

                        if (!allSelected) {
                            Swal.fire('Incomplete',
                                'Please select a decision (Forward/Revert/Reject) for every application in the list.',
                                'warning');
                            return;
                        }

                        console.log("Validation passed. Preparing to send data...");

                        const submitBtn = $('#submitMeetingBtn');
                        const formData = new FormData(document.getElementById('meetingResultsForm'));

                        // Ensure sanctioned amounts are explicitly appended (in case inputs are hidden)
                        $('.sanctioned-hidden').each(function() {
                            const id = $(this).data('id');
                            const val = $(this).val();
                            formData.set(`sanctioned_amounts[${id}]`, val);
                        });

                        submitBtn.prop('disabled', true);
                        submitBtn.find('.spinner-border').show();
                        submitBtn.find('.btn-text').text('Processing...');

                        $.ajax({
                            // Ensure this matches your web.php route exactly!
                            url: '{{ route('office.dashboard.benefits.ho-forwarding.process-meeting') }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                console.log("Server responded with Success:", response);
                                Swal.fire('Success!', response.message, 'success').then(() => location
                                    .reload());
                            },
                            error: function(xhr) {
                                console.error("Server threw an error:", xhr);

                                let errorMsg = 'An unexpected error occurred.';
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    errorMsg = Object.values(xhr.responseJSON.errors).map(e => e.join(
                                        '<br>')).join('<br>');
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }

                                Swal.fire('Submission Failed', errorMsg, 'error');
                            },
                            complete: function() {
                                submitBtn.prop('disabled', false);
                                submitBtn.find('.spinner-border').hide();
                                submitBtn.find('.btn-text').text('Submit Meeting Results');
                            }
                        });
                    });

                    // PREVIEW BUTTON LOGIC
                    $(document).on('click', '.preview-button', function(event) {
                        event.preventDefault();
                        const applicationId = $(this).data('id');
                        const previewModalInstance = new bootstrap.Modal(document.getElementById('previewModal'));
                        const modalBody = $('#previewModal .modal-body');
                        const modalTitle = $('#previewModal .modal-title');

                        modalTitle.html('<i class="fas fa-file-alt text-primary me-2"></i> Application Preview');
                        modalBody.html(
                            '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading...</p></div>'
                            );
                        previewModalInstance.show();

                        $.ajax({
                            url: '/office/dashboard/applications/' + applicationId + '/preview',
                            type: 'GET',
                            success: function(response) {
                                modalBody.html(response.html);
                                modalTitle.html(
                                    '<i class="fas fa-file-alt text-primary me-2"></i> Preview: ' +
                                    response.application_id);
                            },
                            error: function() {
                                modalBody.html(
                                    '<div class="alert alert-danger m-3">Failed to load preview data. Please try again.</div>'
                                    );
                            }
                        });
                    });

                    // VIEW LOG BUTTON LOGIC
                    $(document).on('click', '.view-log-btn', function(event) {
                        event.preventDefault();
                        const applicationId = $(this).data('id');
                        const logModalInstance = new bootstrap.Modal(document.getElementById('logModal'));
                        const modalBody = $('#logModal .modal-body');

                        modalBody.html(
                            '<div class="text-center p-5"><div class="spinner-border text-secondary" role="status"></div><p class="mt-2">Fetching history...</p></div>'
                            );
                        logModalInstance.show();

                        $.ajax({
                            url: '/office/dashboard/applications/' + applicationId + '/log',
                            type: 'GET',
                            success: function(response) {
                                modalBody.html(response.html);
                            },
                            error: function() {
                                modalBody.html(
                                    '<div class="alert alert-danger m-3">Failed to load action log.</div>'
                                    );
                            }
                        });
                    });


                    function performBulkAction(action, ids) {
                        $.ajax({
                            url: '{{ route('office.dashboard.benefits.ho-forwarding.bulk-action') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                application_ids: ids,
                                action: action
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Processing...',
                                    text: 'Please wait.',
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                });
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Success!', response.message, 'success').then(() => location
                                        .reload());
                                } else {
                                    Swal.fire('Error!', response.message || 'An unknown error occurred.',
                                        'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Request Failed', 'Could not connect to the server.', 'error');
                            }
                        });
                    }

                    // --- Document Upload Handler ---
                    $('#hoDocumentsForm').on('submit', function(e) {
                        e.preventDefault();
                        const form = $(this);
                        const submitBtn = $('#uploadDocsBtn');
                        const formData = new FormData(this);

                        submitBtn.prop('disabled', true);
                        submitBtn.find('.spinner-border').show();
                        submitBtn.find('.btn-text').text('Uploading...');

                        $.ajax({
                            url: '{{ route('office.dashboard.benefits.ho-forwarding.upload') }}',
                            type: 'POST',
                            data: formData,
                            processData: false, // Important for file uploads
                            contentType: false, // Important for file uploads
                            success: function(response) {
                                Swal.fire('Success!', response.message, 'success').then(() => location
                                    .reload());
                            },
                            error: function(xhr) {
                                let errorMsg = 'An unexpected error occurred.';
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    errorMsg = Object.values(xhr.responseJSON.errors).map(e => e.join(
                                        '<br>')).join('<br>');
                                }
                                Swal.fire('Upload Failed', errorMsg, 'error');
                            },
                            complete: function() {
                                submitBtn.prop('disabled', false);
                                submitBtn.find('.spinner-border').hide();
                                submitBtn.find('.btn-text').text('Upload Documents');
                            }
                        });
                    });
                });
            </script>
        @endsection
