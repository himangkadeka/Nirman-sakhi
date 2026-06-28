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


                    <div class="tab-panel active" id="tab2">
                        <div class="card p-4 shadow-lg border-0 rounded">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2 class="mb-0 fw-bold text-primary">Submitted Applications</h2>
                                <button class="btn btn-primary shadow-sm px-3 py-2"
                                    onclick="openModal('filterSubmittedModal')">
                                    <i class="fas fa-filter me-2"></i> Filter Applications
                                </button>
                            </div>

                            <!-- Inner Tabs for Schemes -->
                            <ul class="nav nav-pills mb-3" id="schemeTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active benefit-filter-link"
                                        href="{{ route('office.dashboard.benefits.filter') }}">All Schemes</a>
                                </li>
                                @foreach ($availableBenefits as $benefit)
                                    <li class="nav-item">
                                        <a class="nav-link benefit-filter-link"
                                            href="{{ route('office.dashboard.benefits.filter', ['benefit_id' => $benefit->id]) }}">
                                            {{ $benefit->name }}
                                        </a>
                                    </li>
                                @endforeach


                            </ul>

                            <!-- Main Content Area - This will show the filtered results -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active">
                                    <h4 class="mb-3 fw-semibold text-secondary" id="applicationsListHeader">
                                        List of Applications for All Schemes
                                    </h4>
                                    <div class="card bg-light mb-3 p-2" id="bulkActionContainer" style="display: none;">
                                        <div class="d-flex align-items-center">
                                            <strong class="me-3">
                                                <span id="selectedCount">0</span> application(s) selected
                                            </strong> &nbsp;
                                            <button class="btn btn-success btn-sm" id="bulkForwardButton">
                                                <i class="fas fa-share me-2"></i> Forward Selected to RO
                                            </button>
                                            <!-- You can add other bulk action buttons here later -->
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover align-middle" id="applicationsTable">
                                            <thead class="table-dark">
                                                <tr>
                                                    @if (Auth::user()->role_id != 4)
                                                        <th><input type="checkbox" id="selectAllCheckbox"></th>
                                                    @endif
                                                    <th>App ID</th>
                                                    <th>Name</th>
                                                    <th>Application Date</th>
                                                    <th>Contact</th>
                                                    <th>Bank Details</th>
                                                    <th>Preview & Forwarding</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="applicationsTableBody">
                                                @include('office.benefits._applications_table', [
                                                    'submittedApplications' => $submittedApplications,
                                                ])
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4" id="paginationContainer">
                                        {{ $submittedApplications->links() }}
                                    </div>

                                    @if (!empty($data['forwardedApplications']) && $data['forwardedApplications']->count())
                                        <div class="card bg-light mt-5">
                                            <h4 class="mb-3 fw-semibold text-secondary" id="applicationsListHeader">
                                                List of Applications Forwarded to RO
                                            </h4>

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle"
                                                    id="applicationsTable">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            @if (Auth::user()->role_id != 4)
                                                                <th><input type="checkbox" id="selectAllCheckbox"></th>
                                                            @endif
                                                            <th>App ID</th>
                                                            <th>Name</th>
                                                            <th>Application Date</th>
                                                            <th>Contact</th>
                                                            <th>Bank Details</th>
                                                            <th>Preview & Forwarding</th>
                                                            <th class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="applicationsTableBody">
                                                        @include('office.benefits._applications_table', [
                                                            'submittedApplications' =>
                                                                $data['forwardedApplications'],
                                                        ])
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-4" id="paginationContainer">
                                                {{ $data['forwardedApplications']->links() }}
                                            </div>

                                        </div>
                                    @endif
                                </div>

                                {{-- Additional application panels: Approved, Rejected, Reverted --}}
                                @if (!empty($data['approvedApplications']) && $data['approvedApplications']->count())
                                    <div class="card bg-light mt-5 p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fw-semibold text-success">Approved Applications</h4>
                                            <div>
                                                <button class="btn btn-info btn-sm me-2"
                                                    onclick="openModal('filterApprovedModal')">Filter Approved</button>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="downloadExcel('approvedTable', 'ApprovedApplications')">Download
                                                    Excel</button>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover align-middle" id="approvedTable">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>App ID</th>
                                                        <th>Applicant Name</th>
                                                        <th>Scheme</th>
                                                        <th>Approval Date</th>
                                                        <th>Approved By</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @include('office.benefits._applications_table', [
                                                        'submittedApplications' => $data['approvedApplications'],
                                                    ])
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">{{ $data['approvedApplications']->links() }}</div>
                                    </div>
                                @endif

                                @if (!empty($data['rejectedApplications']) && $data['rejectedApplications']->count())
                                    <div class="card bg-light mt-5 p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fw-semibold text-danger">Rejected Applications</h4>
                                            <div>
                                                <button class="btn btn-info btn-sm me-2"
                                                    onclick="openModal('filterRejectedModal')">Filter Rejected</button>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="downloadExcel('rejectedTable', 'RejectedApplications')">Download
                                                    Excel</button>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover align-middle" id="rejectedTable">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>App ID</th>
                                                        <th>Applicant Name</th>
                                                        <th>Scheme</th>
                                                        <th>Rejection Date</th>
                                                        <th>Rejected By</th>
                                                        <th>Remarks</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @include('office.benefits._applications_table', [
                                                        'submittedApplications' => $data['rejectedApplications'],
                                                    ])
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">{{ $data['rejectedApplications']->links() }}</div>
                                    </div>
                                @endif

                                @if (!empty($data['revertedApplications']) && $data['revertedApplications']->count())
                                    <div class="card bg-light mt-5 p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fw-semibold text-secondary">Reverted Applications</h4>
                                            <div>
                                                <button class="btn btn-info btn-sm me-2"
                                                    onclick="openModal('filterRevertedModal')">Filter Reverted</button>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="downloadExcel('revertedTable', 'RevertedApplications')">Download
                                                    Excel</button>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover align-middle" id="revertedTable">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>App ID</th>
                                                        <th>Applicant Name</th>
                                                        <th>Scheme</th>
                                                        <th>Reversion Date</th>
                                                        <th>Reverted By</th>
                                                        <th>Remarks</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @include('office.benefits._applications_table', [
                                                        'submittedApplications' => $data['revertedApplications'],
                                                    ])
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">{{ $data['revertedApplications']->links() }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>






                    <div class="tab-panel" id="tab5">
                        <div class="container-fluid mt-4">
                            <div class="card shadow">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Application History</h5>
                                    <div>
                                        <button class="btn btn-outline-primary btn-sm me-2"
                                            onclick="openModal('filterHistoryModal')">
                                            Filter History
                                        </button>
                                        <button class="btn btn-outline-success btn-sm"
                                            onclick="downloadExcel('historyTable', 'ApplicationHistory')">
                                            Download Excel
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <!-- Application History Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>App ID</th>
                                                    <th>Submitted</th>
                                                    <th>Forwarded by Head RO</th>
                                                    <th>Action Date</th>
                                                    <th>Applicant Name</th>
                                                    <th>Benefit</th>
                                                    <th>Status</th>
                                                    <th>Remarks</th>
                                                    <th>View Log</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>APP4001</td>
                                                    <td>2025-04-01</td>
                                                    <td>2025-04-02</td>
                                                    <td>2025-04-04</td>
                                                    <td>Ajay Singh</td>
                                                    <td>Medical Assistance</td>
                                                    <td><span class="badge bg-warning text-dark">Forwarded</span></td>
                                                    <td>-</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary"
                                                            onclick="viewLog('APP4001')">
                                                            View Log
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Scrutiny Documents Upload History -->
                                    <h5 class="mt-4">Scrutiny Documents Upload History</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>Upload Date</th>
                                                    <th>Document Type</th>
                                                    <th>Uploaded By</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2025-01-20</td>
                                                    <td>Meeting Minutes</td>
                                                    <td>Admin</td>
                                                    <td>Approved by committee</td>
                                                </tr>
                                                <tr>
                                                    <td>2025-01-20</td>
                                                    <td>Attendance Sheet</td>
                                                    <td>Admin</td>
                                                    <td>Complete</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-panel" id="tab6">
                        <div class="container-fluid mt-4">
                            <div class="card shadow">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Notifications</h5>
                                    <button class="btn btn-outline-success btn-sm"
                                        onclick="downloadExcel('notificationsList', 'Notifications')">
                                        Download Excel
                                    </button>
                                </div>

                                <div class="card-body">
                                    <ul id="notificationsList" class="list-group">
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-send-check-fill text-primary me-2"></i>
                                            Application <strong>APP4001</strong> has been forwarded to Finance Office.
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-file-earmark-text-fill text-warning me-2"></i>
                                            Application <strong>APP3001</strong> has been updated after document
                                            resubmission.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- ======================= NEW FORWARD TO RO MODAL ======================= --}}
    <div class="modal fade" id="forwardToRoModal" tabindex="-1" aria-labelledby="forwardToRoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forwardToRoModalLabel">Forward Application(s) to Regional Officer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="forwardRoForm">
                        {{-- This hidden input will store the application IDs to be forwarded --}}
                        <input type="hidden" name="application_ids_json" id="applicationIdsToForward">
                        <div class="mb-3">
                            <label for="role_select" class="form-label">Select Role</label>
                            <select class="form-control" id="role_select" name="role_id" required>
                                <option value="" selected disabled>- Select a Role -</option>
                                {{-- This part is correct, using the $roles collection --}}
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="role_id_error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="user_select" class="form-label">Select Regional Officer (RO)</label>
                            <!-- This dropdown will be populated by JavaScript. It starts disabled. -->
                            <select class="form-control" id="user_select" name="user_id" required disabled>
                                <option value="" selected disabled>- First, select a role -</option>
                                {{-- We do NOT loop through users here. JS will handle it. --}}
                            </select>
                            <div class="invalid-feedback" id="user_id_error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="forward_comment" class="form-label">Comment</label>
                            <textarea class="form-control" id="forward_comment" name="comment" rows="3" required></textarea>
                            <div class="invalid-feedback" id="comment_error"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitForwardRoBtn">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                            style="display: none;"></span>
                        Submit
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logModalLabel">Application Action Log</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="sendBackModal" tabindex="-1" aria-labelledby="sendBackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendBackModalLabel">Send Application Back</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You are about to send this application back to <strong id="send-back-officer-name"></strong>.</p>
                    <form id="sendBackForm">
                        {{-- Hidden inputs to store IDs for the submission --}}
                        <input type="hidden" id="applicationIdToSendBack">
                        <input type="hidden" id="targetUserIdToSendBack">

                        <div class="mb-3">
                            <label for="send_back_comment" class="form-label">Comment (Required)</label>
                            <textarea class="form-control" id="send_back_comment" name="comment" rows="4" required
                                placeholder="Please provide a clear reason for sending the application back."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="submitSendBackBtn">Yes, Send Back</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to approve this application? This is a final action.</p>
                    <form id="approveForm">
                        <input type="hidden" id="applicationIdToApprove">

                        <div class="mb-3">
                            <label for="approve_comment" class="form-label">Comment (Optional)</label>
                            <textarea class="form-control" id="approve_comment" name="comment" rows="3"
                                placeholder="You can add an optional approval note here."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="submitApproveBtn">Yes, Approve</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You are about to reject this application. This action is final.</p>
                    <p class="text-danger"><strong>You must provide a reason for the rejection.</strong> This comment will
                        be visible in the logs.</p>
                    <form id="rejectForm">
                        <input type="hidden" id="applicationIdToReject">
                        <div class="mb-3">
                            <label for="reject_comment" class="form-label">Rejection Reason (Required)</label>
                            <textarea class="form-control" id="reject_comment" name="comment" rows="4" required
                                placeholder="e.g., Ineligible due to age criteria, missing required documents, etc."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="submitRejectBtn">Yes, Reject Application</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- Put this at the bottom of your index.blade.php file --}}


    {{-- Scrutinu JS --}}





@endsection



<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        // This holds the user data passed from the controller for the dropdowns
        const allForwardableUsers = @json($users);

        // --- Element Selectors ---
        const tableBody = document.getElementById('applicationsTableBody');
        const paginationContainer = document.getElementById('paginationContainer');
        const header = document.getElementById('applicationsListHeader');
        const schemeTabsContainer = document.getElementById('schemeTabs');
        const forwardModalEl = document.getElementById('forwardToRoModal');
        const forwardModal = new bootstrap.Modal(forwardModalEl);
        const roleSelect = document.getElementById('role_select');
        const userSelect = document.getElementById('user_select');
        const bulkActionContainer = document.getElementById('bulkActionContainer');
        const selectedCountSpan = document.getElementById('selectedCount');
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        let selectedApplicationIds = [];

        // ===================================================================
        // 1. CORE FUNCTION TO REFRESH THE APPLICATIONS TABLE VIA AJAX
        // ===================================================================
        function fetchAndUpdateApplications(url) {
            tableBody.innerHTML =
                '<tr><td colspan="8" class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div></td></tr>';
            if (paginationContainer) paginationContainer.innerHTML = '';

            // If no URL is passed, use the URL of the currently active tab or the current page
            const finalUrl = url || document.querySelector('#schemeTabs a.active')?.href || window.location
                .href;

            fetch(finalUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = data.table_html;
                    if (paginationContainer) paginationContainer.innerHTML = data.pagination_html;
                    if (header) header.innerText = `List of Applications for ${data.benefit_name}`;
                    // Re-initialize logic for the new dynamic content
                    updateCheckboxLogic();
                    initializeTooltips();
                })
                .catch(error => {
                    console.error('Error fetching applications:', error);
                    tableBody.innerHTML =
                        '<tr><td colspan="8" class="text-center text-danger py-4">Failed to load applications. Please try again.</td></tr>';
                });
        }

        // ===================================================================
        // 2. EVENT DELEGATION FOR DYNAMIC BUTTONS (Preview, Track, Single Forward)
        // ===================================================================
        tableBody.addEventListener('click', function(event) {

            const pullBackButton = event.target.closest('.pull-back-btn');
            if (pullBackButton) {
                event.preventDefault();
                const appId = pullBackButton.dataset.id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will pull the application back to your pending list.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, pull it back!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route('office.dashboard.benefit.pull-back') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    application_id: appId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Pulled Back!', data.message, 'success');
                                    // Refresh the UI - this triggers your existing fetchAndUpdateApplications function
                                    fetchAndUpdateApplications();
                                    // If you have multiple lists (forwarded/submitted), refresh the whole page or relevant sections
                                    window.location.reload();
                                } else {
                                    Swal.fire('Error!', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Request Failed',
                                    'Could not communicate with the server.', 'error');
                            });
                    }
                });
            }

            // --- Preview Modal Logic ---
            const previewButton = event.target.closest('.preview-button');
            if (previewButton) {
                event.preventDefault();
                const applicationId = previewButton.dataset.id;
                const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
                const modalBody = $(
                    '#previewModal .modal-body'); // Using jQuery for Bootstrap compatibility
                const modalTitle = $('#previewModal .modal-title');

                modalTitle.text('Application Preview');
                modalBody.html(
                    '<div class="text-center p-5"><div class="spinner-border" role="status"></div><p class="mt-2"></p></div>'
                );
                previewModal.show();

                // Using jQuery's AJAX since it's already on the page for tooltips
                $.ajax({
                    url: '/office/dashboard/applications/' + applicationId + '/preview',
                    type: 'GET',
                    success: function(response) {
                        modalBody.html(response.html);
                        modalTitle.text('Preview for Application: ' + response
                            .application_id);
                    },
                    error: function(xhr) {
                        modalBody.html(
                            '<div class="alert alert-danger">Failed to load preview data. Please try again.</div>'
                        );
                        console.error(xhr.responseText);
                    }
                });
            }

            const viewLogButton = event.target.closest('.view-log-btn');
            if (viewLogButton) {
                event.preventDefault();
                const applicationId = viewLogButton.dataset.id;
                const logModal = new bootstrap.Modal(document.getElementById('logModal'));
                const modalBody = $('#logModal .modal-body'); // Using jQuery for simplicity

                // Show the modal with a loading spinner
                modalBody.html(
                    '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Fetching history...</p></div>'
                );
                logModal.show();

                // Fetch the log data from the server
                $.ajax({
                    url: '/office/dashboard/applications/' + applicationId +
                        '/log', // This is the route we will create next
                    type: 'GET',
                    success: function(response) {
                        // Replace the spinner with the timeline HTML from the server
                        modalBody.html(response.html);
                    },
                    error: function(xhr) {
                        // Show an error message if something goes wrong
                        modalBody.html(
                            '<div class="alert alert-danger">Failed to load action log.</div>'
                        );
                        console.error(xhr.responseText);
                    }
                });
            }
            const sendBackButton = event.target.closest('.send-back-single-btn');
            if (sendBackButton) {
                event.preventDefault();
                const sendBackModal = new bootstrap.Modal(document.getElementById('sendBackModal'));

                // Get data from the button's data attributes
                const appId = sendBackButton.dataset.id;
                const targetId = sendBackButton.dataset.previousUserId;
                const targetName = sendBackButton.dataset.previousUserName;

                if (!targetId) {
                    Swal.fire('Error',
                        'Cannot determine who to send the application back to. The log may be missing.',
                        'error');
                    return;
                }

                // Populate the modal with the dynamic data
                document.getElementById('send-back-officer-name').textContent = targetName;
                document.getElementById('applicationIdToSendBack').value = appId;
                document.getElementById('targetUserIdToSendBack').value = targetId;
                document.getElementById('send_back_comment').value = ''; // Clear previous comment

                sendBackModal.show();
            }

            const approveButton = event.target.closest('.approve-single-btn');
            if (approveButton) {
                event.preventDefault();
                const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));

                // Get application ID from the button and put it in the modal's hidden input
                const appId = approveButton.dataset.id;
                document.getElementById('applicationIdToApprove').value = appId;

                // Clear previous comment and show the modal
                document.getElementById('approve_comment').value = '';
                approveModal.show();
            }

            const rejectButton = event.target.closest('.reject-single-btn');
            if (rejectButton) {
                event.preventDefault();
                const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));

                const appId = rejectButton.dataset.id;
                document.getElementById('applicationIdToReject').value = appId;
                document.getElementById('reject_comment').value = ''; // Clear old comments

                rejectModal.show();
            }
            // --- Single Forward Button Logic ---
            const singleForwardButton = event.target.closest('.forward-single-btn');
            if (singleForwardButton) {
                openForwardModal([singleForwardButton.dataset.id]);
            }
        });

        document.getElementById('submitRejectBtn').addEventListener('click', function() {
            const submitBtn = this;
            const formData = {
                application_id: document.getElementById('applicationIdToReject').value,
                comment: document.getElementById('reject_comment').value,
                _token: '{{ csrf_token() }}'
            };

            // Frontend validation to ensure a comment is provided
            if (!formData.comment || formData.comment.trim().length < 10) {
                Swal.fire('Reason Required',
                    'Please enter a clear reason for rejection (at least 10 characters).', 'warning'
                );
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Rejecting...';

            fetch('{{ route('office.dashboard.benefit.reject') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
                        Swal.fire('Success!', data.message, 'success');
                        // Refresh the table to remove the application from the user's list
                        fetchAndUpdateApplications();
                    } else {
                        // Display the specific validation error from the backend if available
                        Swal.fire('Error!', data.message || 'An unknown error occurred.', 'error');
                    }
                })
                .catch(error => Swal.fire('Request Failed!', 'Could not connect.', 'error'))
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Yes, Reject Application';
                });
        });
        document.getElementById('submitApproveBtn').addEventListener('click', function() {
            const submitBtn = this;
            const formData = {
                application_id: document.getElementById('applicationIdToApprove').value,
                comment: document.getElementById('approve_comment').value,
                _token: '{{ csrf_token() }}'
            };

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Approving...';

            fetch('{{ route('office.dashboard.benefit.approve') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('approveModal')).hide();
                        Swal.fire('Success!', data.message, 'success');
                        // Refresh the table to remove the application from the list
                        fetchAndUpdateApplications();
                    } else {
                        Swal.fire('Error!', data.message || 'An unknown error occurred.', 'error');
                    }
                })
                .catch(error => Swal.fire('Request Failed!', 'Could not connect.', 'error'))
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Yes, Approve';
                });
        });

        document.getElementById('submitSendBackBtn').addEventListener('click', function() {
            const submitBtn = this;
            const formData = {
                application_id: document.getElementById('applicationIdToSendBack').value,
                target_user_id: document.getElementById('targetUserIdToSendBack').value,
                comment: document.getElementById('send_back_comment').value,
                _token: '{{ csrf_token() }}'
            };

            if (!formData.comment) {
                Swal.fire('Required',
                    'Please enter a comment explaining why the application is being sent back.',
                    'warning');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Sending...';

            fetch('{{ route('office.dashboard.benefit.send-back') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('sendBackModal'))
                            .hide();
                        Swal.fire('Success!', data.message, 'success');
                        // Refresh the main table to remove the application from the current user's list
                        fetchAndUpdateApplications();
                    } else {
                        Swal.fire('Error!', data.message || 'An unknown error occurred.', 'error');
                    }
                })
                .catch(error => Swal.fire('Request Failed!', 'Could not connect.', 'error'))
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Yes, Send Back';
                });
        });
        schemeTabsContainer.addEventListener('click', (event) => {
            const tabLink = event.target.closest('a.benefit-filter-link');
            if (tabLink) {
                event.preventDefault();
                schemeTabsContainer.querySelectorAll('a.benefit-filter-link').forEach(l => l.classList
                    .remove('active'));
                tabLink.classList.add('active');
                fetchAndUpdateApplications(tabLink.href);
            }
        });

        // Event delegation for pagination links
        paginationContainer.addEventListener('click', (event) => {

            const pageLink = event.target.closest('a.page-link');

            if (pageLink && pageLink.href) {
                event.preventDefault();
                fetchAndUpdateApplications(pageLink.href);
            }
        });

        // ===================================================================
        // 4. HELPER FUNCTIONS (Tooltips, Checkboxes, Modal Logic)
        // ===================================================================
        function initializeTooltips() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                var oldtip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
                if (oldtip) oldtip.dispose(); // Remove old instance to prevent conflicts
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        function updateCheckboxLogic() {
            const appCheckboxes = document.querySelectorAll('.app-checkbox');
            if (selectAllCheckbox) selectAllCheckbox.checked = false;

            function updateBulkUI() {
                const selectedCheckboxes = document.querySelectorAll('.app-checkbox:checked');
                const count = selectedCheckboxes.length;
                if (selectedCountSpan) selectedCountSpan.textContent = count;
                if (bulkActionContainer) bulkActionContainer.style.display = count > 0 ? 'block' : 'none';
                if (selectAllCheckbox) selectAllCheckbox.checked = count > 0 && count === appCheckboxes.length;
            }

            appCheckboxes.forEach(checkbox => checkbox.addEventListener('change', updateBulkUI));

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', () => {
                    appCheckboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
                    updateBulkUI();
                });
            }
            updateBulkUI();
        }

        function openForwardModal(ids) {
            if (!ids || ids.length === 0) {
                Swal.fire('No Selection', 'Please select at least one application.', 'warning');
                return;
            }
            selectedApplicationIds = ids;
            document.getElementById('forwardRoForm').reset();
            userSelect.innerHTML = '<option value="" selected disabled>- First, select a role -</option>';
            userSelect.disabled = true;
            forwardModal.show();
        }

        // ===================================================================
        // 5. EVENT LISTENERS FOR MODAL INTERACTIONS
        // ===================================================================
        document.getElementById('bulkForwardButton')?.addEventListener('click', () => {
            const ids = Array.from(document.querySelectorAll('.app-checkbox:checked')).map(cb => cb
                .dataset.id);
            openForwardModal(ids);
        });

        roleSelect.addEventListener('change', function() {
            const selectedRoleId = parseInt(this.value, 10);
            userSelect.innerHTML = '';

            if (!selectedRoleId) {
                userSelect.innerHTML =
                    '<option value="" selected disabled>- First, select a role -</option>';
                userSelect.disabled = true;
                return;
            }

            const filteredUsers = allForwardableUsers.filter(user => user.role_id === selectedRoleId);

            if (filteredUsers.length > 0) {
                userSelect.innerHTML =
                    '<option value="" selected disabled>- Select an Officer -</option>';
                filteredUsers.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent =
                        `${user.username} (${user.firstname} ${user.lastname})`;
                    userSelect.appendChild(option);
                });
                userSelect.disabled = false;
            } else {
                userSelect.innerHTML =
                    '<option value="" selected disabled>- No officers found for this role -</option>';
                userSelect.disabled = true;
            }
        });

        document.getElementById('submitForwardRoBtn').addEventListener('click', function() {
            const submitBtn = this;
            const formData = {
                application_ids: selectedApplicationIds,
                user_id: userSelect.value,
                comment: document.getElementById('forward_comment').value,
                _token: '{{ csrf_token() }}'
            };

            if (!formData.user_id || !formData.comment) {
                Swal.fire('Incomplete', 'Please select an officer and enter a comment.', 'error');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm"></span> Submitting...';

            fetch('{{ route('office.dashboard.benefit.forward') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        forwardModal.hide();
                        Swal.fire('Success!', data.message, 'success');
                        fetchAndUpdateApplications();
                    } else {
                        Swal.fire('Error!', data.message || 'An unknown error occurred.', 'error');
                    }
                })
                .catch(error => Swal.fire('Request Failed!', 'Could not connect.', 'error'))
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Submit';
                });
        });

        // ===================================================================
        // 6. INITIALIZE PAGE ON FIRST LOAD
        // ===================================================================
        updateCheckboxLogic();
        initializeTooltips();
    });
</script>



<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        const tabButtons = document.querySelectorAll(".tab-button");
        const tabPanels = document.querySelectorAll(".tab-panel");

        tabButtons.forEach((button) => {
            button.addEventListener("click", () => {
                // Remove active class from all buttons and panels
                tabButtons.forEach((btn) => btn.classList.remove("active"));
                tabPanels.forEach((panel) => panel.classList.remove("active"));

                // Add active class to clicked button and corresponding panel
                button.classList.add("active");
                const tabId = button.dataset.tab;
                document.getElementById(tabId).classList.add("active");
            });
        });
    });
</script>
