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

    /* Modern Form & Modal Styling */
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        background-color: #fcfcfc;
        padding: 1rem 1.5rem;
    }

    .custom-form-control {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        background-color: #fcfcfc;
        transition: all 0.2s ease-in-out;
    }

    .custom-form-control:focus {
        border-color: #3b82f6;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .custom-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }

    .custom-label i {
        color: #6366f1;
        margin-right: 8px;
        font-size: 1.1rem;
    }

    .info-alert {
        background-color: #eff6ff;
        border-left: 4px solid #3b82f6;
        color: #1e3a8a;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .btn-modern {
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-modern:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .file-upload-wrapper {
        background: #ffffff;
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.2s;
    }

    .file-upload-wrapper:hover {
        border-color: #3b82f6;
        background: #f8fafc;
    }
</style>


@section('content')

    <div class="container-fluid">
        <div class="tab-container">
            @include('office.benefits.tabs')
            <div class="tab-content">
                {{-- Ensure this tab-panel is active based on your tab logic --}}

                <div class="tab-panel active" id="tab3">

                    {{-- ==================== LIST 1: PENDING SCHEDULING ==================== --}}
                    <div class="card shadow p-4 mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0 text-primary"><i class="fas fa-clipboard-list me-2"></i>Pending Scrutiny
                                Scheduling</h4>
                            <button id="openCommitteeBtn" class="btn btn-outline-info btn-sm shadow-sm">
                                <i class="fas fa-users-cog me-1"></i> Manage Committee Members
                            </button>
                        </div>
                        <p class="text-muted">Select approved/rejected applications below to forward them to the Scrutiny
                            Committee.</p>

                        <div class="table-responsive">
                            <table id="scrutinyTable" class="table table-bordered table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" id="selectAllScrutinyCheckbox"></th>
                                        <th>App ID</th>
                                        <th>Applicant Name</th>
                                        <th>Benefit Scheme</th>
                                        <th>Submission Date</th>
                                        <th>Current Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="scrutinyTableBody">
                                    @forelse($pendingScrutinyApplications as $submission)
                                        <tr>
                                            <td><input type="checkbox" class="scrutiny-checkbox"
                                                    data-id="{{ $submission->id }}"></td>
                                            <td>{{ $submission->application_id }}</td>
                                            <td>{{ $submission->getApplicantDetails()->name ?? 'N/A' }}</td>
                                            <td>{{ $submission->benefit->name ?? 'N/A' }}</td>
                                            <td>{{ $submission->created_at->format('Y-m-d') }}</td>
                                            <td><span
                                                    class="badge bg-info text-dark">{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-sm shadow-sm preview-button"
                                                    data-id="{{ $submission->application_id }}" data-bs-toggle="tooltip"
                                                    title="Preview Application">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-secondary btn-sm shadow-sm view-log-btn"
                                                    data-id="{{ $submission->id }}" data-bs-toggle="tooltip"
                                                    title="View Action Log">
                                                    <i class="fas fa-history"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">No pending applications
                                                for scrutiny.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {!! $pendingScrutinyApplications->appends(request()->except('pending_page'))->links() !!}
                        </div>

                        <div class="mt-2">
                            <button class="btn btn-primary" id="sendToScrutinyBtn">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                    style="display: none;"></span>
                                <i class="fas fa-share-square me-2"></i>
                                <span class="btn-text">Send Selected to Scrutiny Committee</span>
                            </button>
                        </div>
                    </div>

                    {{-- ==================== LIST 2: ALREADY SCHEDULED ==================== --}}
                    {{-- ==================== LIST 2: ALREADY SCHEDULED ==================== --}}
                    <div class="card shadow p-4 border-top border-warning border-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0 text-warning"><i class="fas fa-calendar-check me-2"></i>Scheduled for Scrutiny
                            </h4>
                        </div>
                        <p class="text-muted">These applications are currently under scrutiny. Use the action menu to
                            reschedule them if necessary.</p>

                        <div class="table-responsive">
                            <table id="scheduledScrutinyTable" class="table table-bordered table-hover align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th><input type="checkbox" id="selectAllScheduledCheckbox"></th>
                                        <th>App ID</th>
                                        <th>Applicant Name</th>
                                        <th>Benefit Scheme</th>
                                        <th>Status Date</th>
                                        <th>Meeting Date</th>
                                        <th>Current Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="scheduledScrutinyTableBody">
                                    @forelse($scheduledScrutinyApplications as $submission)
                                        <tr>
                                            <td><input type="checkbox" class="scheduled-checkbox"
                                                    data-id="{{ $submission->id }}"></td>
                                            <td>{{ $submission->application_id }}</td>
                                            <td>{{ $submission->getApplicantDetails()->name ?? 'N/A' }}</td>
                                            <td>{{ $submission->benefit->name ?? 'N/A' }}</td>
                                            <td>{{ $submission->updated_at->format('Y-m-d') }}</td>
                                            <td>
                                                @if ($submission->scrutiny_meeting_date)
                                                    <span class="text-primary fw-bold">
                                                        {{ \Carbon\Carbon::parse($submission->scrutiny_meeting_date)->format('F j, Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Not Scheduled</span>
                                                @endif
                                            </td>
                                            <td><span class="badge bg-warning text-dark">Under Scrutiny</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button class="btn btn-primary btn-sm shadow-sm preview-button"
                                                        data-id="{{ $submission->application_id }}"
                                                        data-bs-toggle="tooltip" title="Preview Application">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-secondary btn-sm shadow-sm view-log-btn"
                                                        data-id="{{ $submission->id }}" data-bs-toggle="tooltip"
                                                        title="View Action Log">
                                                        <i class="fas fa-history"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-warning btn-sm shadow-sm reschedule-btn"
                                                        data-id="{{ $submission->id }}" data-bs-toggle="tooltip"
                                                        title="Reschedule Scrutiny">
                                                        <i class="fas fa-calendar-alt"></i> Reschedule
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">No scheduled applications
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {!! $scheduledScrutinyApplications->appends(request()->except('scheduled_page'))->links() !!}
                        </div>

                        <div class="mt-2">
                            <button class="btn btn-warning" id="bulkRescheduleBtn">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span class="btn-text">Reschedule Selected</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sendToCommitteeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-envelope-open-text text-primary me-2"></i> Notify
                        Scrutiny Committee</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="info-alert">
                        <i class="fas fa-info-circle me-1"></i> You are about to forward the selected applications. The
                        committee will be notified via email with the subject and message below. An Excel report will be
                        automatically attached.
                    </div>
                    <form id="sendToCommitteeForm">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="meeting_date" class="custom-label"><i class="fas fa-calendar-day"></i>
                                    Scrutiny Meeting Date <span class="text-danger ms-1">*</span></label>
                                <input type="date" class="form-control custom-form-control" id="meeting_date"
                                    name="meeting_date" min="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-12">
                                <label for="email_subject" class="custom-label"><i class="fas fa-heading"></i> Email
                                    Subject <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control custom-form-control fw-semibold text-primary"
                                    id="email_subject" name="subject"
                                    value="Applications for Scrutiny Review - {{ now()->format('F j, Y') }}" required>
                            </div>

                            <div class="col-md-12">
                                <label for="email_message" class="custom-label"><i class="fas fa-align-left"></i> Message
                                    Body <span class="text-danger ms-1">*</span></label>
                                <textarea class="form-control custom-form-control" id="email_message" name="message" rows="5" required>Please find the attached list of applications that have been forwarded for review by the Scrutiny Committee.</textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-modern border"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-modern" id="submitCommitteeNotificationBtn">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"
                            style="display: none;"></span>
                        <i class="fas fa-paper-plane me-1"></i> <span class="btn-text">Send Notification</span>
                    </button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Application Preview</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Content will be loaded here via JavaScript --}}
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Loading application data...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logModalLabel">Application Action Log</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="log-modal-body">
                    {{-- This is a placeholder that shows while data is loading --}}
                    <div class="text-center p-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Fetching application history...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-calendar-check text-warning me-2"></i> Reschedule
                        Scrutiny Meeting</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="info-alert" style="background-color: #fffbeb; border-color: #f59e0b; color: #92400e;">
                        <i class="fas fa-exclamation-triangle me-1"></i> Provide the new details to reschedule this
                        application. A new email notification will be sent to the committee instantly.
                    </div>
                    <form id="rescheduleForm">
                        <input type="hidden" id="reschedule_application_id" name="application_id">

                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="reschedule_date" class="custom-label"><i
                                        class="fas fa-calendar-plus text-warning"></i> New Meeting Date <span
                                        class="text-danger ms-1">*</span></label>
                                <input type="date" class="form-control custom-form-control" id="reschedule_date"
                                    name="meeting_date" min="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-12">
                                <label for="reschedule_subject" class="custom-label"><i
                                        class="fas fa-heading text-warning"></i> New Subject <span
                                        class="text-danger ms-1">*</span></label>
                                <input type="text"
                                    class="form-control custom-form-control fw-semibold text-warning-emphasis"
                                    id="reschedule_subject" name="subject"
                                    value="RESCHEDULED: Application for Scrutiny Review - {{ now()->addDays(5)->format('F j, Y') }}"
                                    required>
                            </div>

                            <div class="col-md-12">
                                <label for="reschedule_message" class="custom-label"><i
                                        class="fas fa-align-left text-warning"></i> Reason for Reschedule <span
                                        class="text-danger ms-1">*</span></label>
                                <textarea class="form-control custom-form-control" id="reschedule_message" name="message" rows="4" required
                                    placeholder="Please state the reason for rescheduling and confirm the new time..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-modern border"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning btn-modern" id="submitRescheduleBtn">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"
                            style="display: none;"></span>
                        <i class="fas fa-save me-1"></i> <span class="btn-text">Confirm Reschedule</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="manageCommitteeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-users-cog text-primary me-2"></i> Manage Scrutiny
                        Committee</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">

                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-header bg-primary text-white rounded-top-4 py-3">
                            <h6 class="mb-0 fw-bold" id="memberFormTitle"><i class="fas fa-user-plus me-2"></i>Add New
                                Member</h6>
                        </div>
                        <div class="card-body p-4">
                            <form id="addCommitteeMemberForm">
                                <input type="hidden" id="edit_member_id" value="">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="custom-label" for="member_name"><i
                                                class="fas fa-user text-secondary"></i> Full Name <span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control custom-form-control shadow-sm"
                                            id="member_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="custom-label" for="member_email"><i
                                                class="fas fa-envelope text-secondary"></i> Email Address <span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="email" class="form-control custom-form-control shadow-sm"
                                            id="member_email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="custom-label" for="member_designation"><i
                                                class="fas fa-id-badge text-secondary"></i> Designation</label>
                                        <input type="text" class="form-control custom-form-control shadow-sm"
                                            id="member_designation">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="custom-label" for="member_department"><i
                                                class="fas fa-id-badge text-secondary"></i> Department</label>
                                        <input type="text" class="form-control custom-form-control shadow-sm"
                                            id="member_department">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="custom-label" for="member_phone"><i
                                                class="fas fa-phone-alt text-secondary"></i> Phone Number</label>
                                        <input type="text" class="form-control custom-form-control shadow-sm"
                                            id="member_phone">
                                    </div>

                                    <div class="col-12 text-end mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-light btn-modern px-4 me-2 d-none"
                                            id="cancelEditBtn">
                                            Cancel Edit
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-modern px-4"
                                            id="saveMemberBtn">
                                            <i class="fas fa-plus-circle me-2"></i><span class="btn-text">Add Member to
                                                Committee</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 mt-2">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2 shadow-sm"
                            style="width: 35px; height: 35px;">
                            <i class="fas fa-list-ul"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-secondary">&nbsp;Current Committee Members</h5>
                    </div>

                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 bg-white">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary small fw-bold py-3 px-4">Member Details
                                        </th>
                                        <th class="text-uppercase text-secondary small fw-bold py-3">Contact Info</th>
                                        <th class="text-uppercase text-secondary small fw-bold text-center py-3"
                                            width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="committeeMembersTableBody">
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            <div class="spinner-border spinner-border-sm text-primary me-2"></div> Loading
                                            members...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modern px-4" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(function() {
            const scrutinyTableBody = $('#scrutinyTableBody');
            const scheduledTableBody = $('#scheduledScrutinyTableBody'); // New table body
            const selectAllCheckbox = $('#selectAllScrutinyCheckbox');
            const selectAllScheduledCheckbox = $('#selectAllScheduledCheckbox'); // New select all

            const sendBtn = $('#sendToScrutinyBtn');
            const bulkRescheduleBtn = $('#bulkRescheduleBtn'); // New bulk btn

            const committeeModal = new bootstrap.Modal(document.getElementById('sendToCommitteeModal'));
            const rescheduleModal = new bootstrap.Modal(document.getElementById('rescheduleModal'));

            let selectedApplicationIds = [];
            let rescheduleApplicationIds = []; // Array to handle single OR bulk reschedule

            // SCRUTINY MANAGEMNET



            // ==========================================
            // TABLE 1: PENDING SCRUTINY LOGIC
            // ==========================================
            selectAllCheckbox.on('click', function() {
                scrutinyTableBody.find('.scrutiny-checkbox').prop('checked', this.checked);
            });

            scrutinyTableBody.on('click', '.scrutiny-checkbox', function() {
                if (!this.checked) selectAllCheckbox.prop('checked', false);
            });

            sendBtn.on('click', function() {
                selectedApplicationIds = [];
                scrutinyTableBody.find('.scrutiny-checkbox:checked').each(function() {
                    selectedApplicationIds.push($(this).data('id'));
                });

                if (selectedApplicationIds.length === 0) {
                    Swal.fire('No Selection', 'Please select at least one application to send.', 'warning');
                    return;
                }
                committeeModal.show();
            });

            // ==========================================
            // TABLE 2: ALREADY SCHEDULED (BULK RESCHEDULE)
            // ==========================================
            selectAllScheduledCheckbox.on('click', function() {
                scheduledTableBody.find('.scheduled-checkbox').prop('checked', this.checked);
            });

            scheduledTableBody.on('click', '.scheduled-checkbox', function() {
                if (!this.checked) selectAllScheduledCheckbox.prop('checked', false);
            });

            bulkRescheduleBtn.on('click', function() {
                rescheduleApplicationIds = []; // Reset
                scheduledTableBody.find('.scheduled-checkbox:checked').each(function() {
                    rescheduleApplicationIds.push($(this).data('id'));
                });

                if (rescheduleApplicationIds.length === 0) {
                    Swal.fire('No Selection', 'Please select at least one application to reschedule.',
                        'warning');
                    return;
                }
                rescheduleModal.show();
            });

            // Single Item Reschedule Button (Works for individual rows)
            $(document).on('click', '.reschedule-btn', function(event) {
                event.preventDefault();
                rescheduleApplicationIds = [$(this).data('id')]; // Array with just one ID
                rescheduleModal.show();
            });

            // ==========================================
            // GLOBAL MODALS (Preview & View Log)
            // ==========================================



            // PREVIEW - Works for both tables
            $(document).on('click', '.preview-button', function(event) {
                event.preventDefault();
                const applicationId = $(this).data('id');
                const previewModalInstance = new bootstrap.Modal(document.getElementById('previewModal'));
                const modalBody = $('#previewModal .modal-body');
                const modalTitle = $('#previewModal .modal-title');

                modalTitle.text('Application Preview');
                modalBody.html(
                    '<div class="text-center p-5"><div class="spinner-border" role="status"></div><p class="mt-2">Loading...</p></div>'
                );
                previewModalInstance.show();

                $.ajax({
                    url: '/office/dashboard/applications/' + applicationId + '/preview',
                    type: 'GET',
                    success: function(response) {
                        modalBody.html(response.html);
                        modalTitle.text('Preview for Application: ' + response.application_id);
                    },
                    error: function(xhr) {
                        modalBody.html(
                            '<div class="alert alert-danger">Failed to load preview data. Please try again.</div>'
                        );
                    }
                });
            });

            // VIEW LOG - Works for both tables
            $(document).on('click', '.view-log-btn', function(event) {
                event.preventDefault();
                const applicationId = $(this).data('id');
                const logModalInstance = new bootstrap.Modal(document.getElementById('logModal'));
                const modalBody = $('#logModal .modal-body');

                modalBody.html(
                    '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Fetching history...</p></div>'
                );
                logModalInstance.show();

                $.ajax({
                    url: '/office/dashboard/applications/' + applicationId + '/log',
                    type: 'GET',
                    success: function(response) {
                        modalBody.html(response.html);
                    },
                    error: function(xhr) {
                        modalBody.html(
                            '<div class="alert alert-danger">Failed to load action log.</div>'
                        );
                    }
                });
            });

            // ==========================================
            // SUBMIT AJAX FORMS
            // ==========================================

            // Submit "Send To Committee" Form
            $('#submitCommitteeNotificationBtn').on('click', function() {
                const submitBtn = $(this);
                const meetingDate = $('#meeting_date').val();
                const subject = $('#email_subject').val().trim();
                const message = $('#email_message').val().trim();

                if (!meetingDate || !subject || !message) {
                    Swal.fire('Required Fields', 'Please provide a meeting date, subject, and message.',
                        'warning');
                    return;
                }

                submitBtn.find('.spinner-border').show();
                submitBtn.find('.btn-text').text('Sending...');
                submitBtn.prop('disabled', true);

                $.ajax({
                    url: '{{ route('office.dashboard.benefit.scrutiny.send') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        application_ids: selectedApplicationIds,
                        subject: subject,
                        message: message,
                        meeting_date: meetingDate,
                    },
                    success: function(response) {
                        committeeModal.hide();
                        if (response.success) {
                            Swal.fire('Success!', response.message, 'success').then(() =>
                                location.reload());
                        } else {
                            Swal.fire('Error!', response.message ||
                                'An unknown error occurred.', 'error');
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr
                            .responseJSON.message : 'An unexpected error occurred.';
                        Swal.fire('Request Failed!', errorMsg, 'error');
                    },
                    complete: function() {
                        submitBtn.find('.spinner-border').hide();
                        submitBtn.find('.btn-text').text('Send Notification');
                        submitBtn.prop('disabled', false);
                    }
                });
            });

            function formatReadableDate(dateString) {
                if (!dateString) return '';
                // Split to avoid Javascript timezone shifting bugs
                const [year, month, day] = dateString.split('-');
                const dateObj = new Date(year, month - 1, day);
                return dateObj.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

            // 1. For Initial Scheduling Modal
            $('#meeting_date').on('change', function() {
                const selectedDate = $(this).val();
                if (selectedDate) {
                    const formattedDate = formatReadableDate(selectedDate);
                    $('#email_subject').val('Applications for Scrutiny Review - ' + formattedDate);
                }
            });

            // 2. For Reschedule Modal
            $('#reschedule_date').on('change', function() {
                const selectedDate = $(this).val();
                if (selectedDate) {
                    const formattedDate = formatReadableDate(selectedDate);
                    $('#reschedule_subject').val('RESCHEDULED: Application for Scrutiny Review - ' +
                        formattedDate);
                }
            });

            // Submit "Reschedule" Form
            $('#submitRescheduleBtn').on('click', function() {
                const submitBtn = $(this);
                const meetingDate = $('#reschedule_date').val();
                const subject = $('#reschedule_subject').val().trim();
                const message = $('#reschedule_message').val().trim();

                if (!meetingDate || !subject || !message) {
                    Swal.fire('Required Fields', 'Please provide a new meeting date, subject, and message.',
                        'warning');
                    return;
                }

                submitBtn.find('.spinner-border').show();
                submitBtn.find('.btn-text').text('Rescheduling...');
                submitBtn.prop('disabled', true);

                $.ajax({
                    url: '{{ route('office.dashboard.benefit.scrutiny.reschedule') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        application_ids: rescheduleApplicationIds, // Now passing an ARRAY
                        subject: subject,
                        message: message,
                        meeting_date: meetingDate,
                    },
                    success: function(response) {
                        rescheduleModal.hide();
                        if (response.success) {
                            Swal.fire('Success!', response.message, 'success').then(() =>
                                location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr
                            .responseJSON.message : 'An unexpected error occurred.';
                        Swal.fire('Request Failed!', errorMsg, 'error');
                    },
                    complete: function() {
                        submitBtn.find('.spinner-border').hide();
                        submitBtn.find('.btn-text').text('Confirm Reschedule');
                        submitBtn.prop('disabled', false);
                    }
                });
            });

            // ==========================================
            // COMMITTEE MEMBER MANAGEMENT LOGIC
            // ==========================================
            const manageCommitteeModal = new bootstrap.Modal(document.getElementById('manageCommitteeModal'));

            // Open Modal & Load Data
            $('#openCommitteeBtn').on('click', function(e) {
                e.preventDefault();
                manageCommitteeModal.show();
                loadCommitteeMembers();
                resetMemberForm(); // Clear form if it was left in edit mode
            });

            // Fetch Members
            function loadCommitteeMembers() {
                const tbody = $('#committeeMembersTableBody');
                $.ajax({
                    url: '{{ route("office.dashboard.benefit.scrutiny.members.list") }}',
                    type: 'GET',
                    success: function(response) {
                        tbody.empty();
                        if (response.members.length === 0) {
                            tbody.append('<tr><td colspan="3" class="text-center py-4 text-muted">No committee members added yet.</td></tr>');
                            return;
                        }

                        response.members.forEach(member => {
                            const initial = member.name ? member.name.charAt(0).toUpperCase() : '?';
                            const safeDesignation = member.designation || '';
                            const safeDepartment = member.department || '';
                            const safePhone = member.phone || '';

                            tbody.append(`
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold fs-5 shadow-sm" style="width: 35px; height: 35px;">
                                                ${initial}
                                            </div>
                                            <div class="ml-3">
                                                <div class="fw-bold text-dark fs-6">${member.name}</div>
                                                <div class="small text-muted"><i class="fas fa-briefcase me-1"></i> ${safeDesignation || 'No Designation'}</div>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="small mb-1 text-dark"><i class="fas fa-envelope text-primary me-2"></i> ${member.email}</div>
                                        <div class="small text-dark"><i class="fas fa-phone-alt text-success me-2"></i> ${safePhone || 'N/A'}</div>
                                        <div class="small text-muted"><i class="fas fa-home me-1"></i> ${safeDepartment || 'No Designation'}</div>
                                    </td>
                                    <td class="text-center py-3">
                                        <button class="btn btn-sm btn-outline-primary edit-member-btn  shadow-sm me-1"
                                            data-id="${member.id}" data-name="${member.name}" data-email="${member.email}"
                                            data-designation="${safeDesignation}" data-department="${safeDepartment}" data-phone="${safePhone}"
                                            title="Edit Member" style="width: 28px; height: 28px; padding: 0; line-height: 36px;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger delete-member-btn  shadow-sm"
                                            data-id="${member.id}" title="Remove Member" style="width: 28px; height: 28px; padding: 0; line-height: 36px;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });
            }

            // Helper to reset form back to "Add" mode
            function resetMemberForm() {
                $('#addCommitteeMemberForm')[0].reset();
                $('#edit_member_id').val('');
                $('#memberFormTitle').html('<i class="fas fa-user-plus me-2"></i>Add New Member');
                $('#saveMemberBtn .btn-text').text('Add Member to Committee');
                $('#saveMemberBtn i').removeClass('fa-save').addClass('fa-plus-circle');
                $('#cancelEditBtn').addClass('d-none');
            }

            // Click Edit Button
            $(document).on('click', '.edit-member-btn', function() {
                // Populate the form with the clicked row's data
                $('#edit_member_id').val($(this).data('id'));
                $('#member_name').val($(this).data('name'));
                $('#member_email').val($(this).data('email'));
                $('#member_designation').val($(this).data('designation'));
                $('#member_department').val($(this).data('department'));
                $('#member_phone').val($(this).data('phone'));

                // Change UI to Edit Mode
                $('#memberFormTitle').html('<i class="fas fa-user-edit me-2"></i>Edit Member');
                $('#saveMemberBtn .btn-text').text('Update Member');
                $('#saveMemberBtn i').removeClass('fa-plus-circle').addClass('fa-save');
                $('#cancelEditBtn').removeClass('d-none');
            });

            // Click Cancel Edit Button
            $('#cancelEditBtn').on('click', function() {
                resetMemberForm();
            });

            // Add OR Update Member (Dynamic Submit)
            $('#addCommitteeMemberForm').on('submit', function(e) {
                e.preventDefault();
                const btn = $('#saveMemberBtn');
                const btnText = btn.find('.btn-text');
                const originalText = btnText.text();

                btn.prop('disabled', true);
                btnText.text('Saving...');

                // Determine if we are Adding or Updating
                const memberId = $('#edit_member_id').val();
                const isUpdate = memberId !== "";
                const ajaxUrl = isUpdate
                    ? `/office/dashboard/benefits/scrutiny-members/${memberId}`
                    : '{{ route("office.dashboard.benefit.scrutiny.members.store") }}';

                // If updating, Laravel requires _method PUT
                const payload = {
                    _token: '{{ csrf_token() }}',
                    name: $('#member_name').val(),
                    email: $('#member_email').val(),
                    designation: $('#member_designation').val(),
                    department: $('#member_department').val(),
                    phone: $('#member_phone').val(),
                };

                if (isUpdate) payload._method = 'PUT';

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST', // Always POST for Ajax, payload._method tells Laravel it's a PUT
                    data: payload,
                    success: function(response) {
                        if(response.success) {
                            resetMemberForm();
                            loadCommitteeMembers(); // Refresh table
                            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: response.message, showConfirmButton: false, timer: 3000 });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to save member. Please check your inputs.', 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        btnText.text(originalText);
                    }
                });
            });

            // Delete Member
            $(document).on('click', '.delete-member-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Remove Member?',
                    text: "They will no longer receive scrutiny notifications.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove them'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/office/dashboard/benefits/scrutiny-members/${id}`,
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function(response) {
                                resetMemberForm(); // Clear form just in case they were editing the deleted user
                                loadCommitteeMembers();
                                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: response.message, showConfirmButton: false, timer: 3000 });
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
