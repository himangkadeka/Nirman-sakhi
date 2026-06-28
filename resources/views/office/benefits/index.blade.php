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
                                                    'showCheckboxes' => true,
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
                                                            {{-- @if (Auth::user()->role_id != 4)
                                                                <th><input type="checkbox" id="selectAllCheckbox"></th>
                                                            @endif --}}
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
                                                            'showCheckboxes' => false,
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
                                                        {{-- <th>Remarks</th> --}}
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

                                @if (!empty($data['sendBackApplications']) && $data['sendBackApplications']->count())
                                    <div class="card bg-light mt-5 p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fw-semibold text-secondary">Send Back Applications</h4>
                                            <div>
                                                {{-- <button class="btn btn-info btn-sm me-2"
                                                    onclick="openModal('filterRevertedModal')">Filter Reverted</button>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="downloadExcel('revertedTable', 'sendBackApplications')">Download
                                                    Excel</button> --}}
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
                                                        'submittedApplications' => $data['sendBackApplications'],
                                                    ])
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">{{ $data['sendBackApplications']->links() }}</div>
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
                                                    onclick="downloadExcel('revertedTable', 'revertedApplications')">Download
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
                                                        {{-- <th>Remarks</th> --}}
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


    <div class="modal fade" id="revertModal" tabindex="-1" aria-labelledby="revertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="revertModalLabel">Revert Application</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You are about to revert this application back to the applicant.</p>
                    <form id="revertForm">
                        <input type="hidden" id="applicationIdToRevert">
                        <div class="mb-3">
                            <label for="revert_comment" class="form-label">Reason for Revert (Required)</label>
                            <textarea class="form-control" id="revert_comment" name="comment" rows="4" required
                                placeholder="Please explain what needs to be fixed or updated by the applicant..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="submitRevertBtn">Yes, Revert Application</button>
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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


    <div class="modal fade" id="sendBackModal" tabindex="-1" aria-labelledby="sendBackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendBackModalLabel">Send Application Back</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="submitRejectBtn">Yes, Reject Application</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- Put this at the bottom of your index.blade.php file --}}


    {{-- Scrutinu JS --}}





@endsection


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        // Data passed from controller
        const allForwardableUsers = @json($users);

        // --- Element Selectors ---
        // Change: Select the main container so buttons in ALL tables (Forwarded, Approved, etc.) work
        const mainContentArea = document.querySelector('.tab-content');

        const paginationContainer = document.getElementById('paginationContainer');
        const header = document.getElementById('applicationsListHeader');
        const schemeTabsContainer = document.getElementById('schemeTabs');

        // Modals
        const forwardModal = new bootstrap.Modal(document.getElementById('forwardToRoModal'));
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        const logModal = new bootstrap.Modal(document.getElementById('logModal'));
        const sendBackModal = new bootstrap.Modal(document.getElementById('sendBackModal'));
        const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
        const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));

        const roleSelect = document.getElementById('role_select');
        const userSelect = document.getElementById('user_select');
        const bulkActionContainer = document.getElementById('bulkActionContainer');
        const selectedCountSpan = document.getElementById('selectedCount');
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');

        let selectedApplicationIds = [];
        const schemeLinks = document.querySelectorAll('.benefit-filter-link');

        schemeLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Stop the browser from leaving the page

                // 1. Update the visual 'active' state of the clicked tab
                schemeLinks.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');

                // 2. Fetch the URL from the clicked link
                const url = this.getAttribute('href');

                // 3. Trigger your existing AJAX function
                fetchAndUpdateApplications(url);
            });
        });

        // ===================================================================
        // 1. CORE FUNCTION TO REFRESH THE APPLICATIONS TABLE VIA AJAX
        // ===================================================================
        function fetchAndUpdateApplications(url) {
            const tableBody = document.getElementById('applicationsTableBody');
            tableBody.innerHTML =
                '<tr><td colspan="8" class="text-center py-5"><div class="spinner-border text-primary"></div></td></tr>';

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
                    updateCheckboxLogic();
                    initializeTooltips();
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.innerHTML =
                        '<tr><td colspan="8" class="text-center text-danger">Failed to load applications.</td></tr>';
                });
        }

        // ===================================================================
        // 2. GLOBAL EVENT DELEGATION (Works for ALL tables on the page)
        // ===================================================================
        document.addEventListener('click', function(event) {
            // ===================================================================
            // NEW: BULK FORWARD ACTION
            // ===================================================================
            const bulkForwardBtn = document.getElementById('bulkForwardButton');
            if (bulkForwardBtn) {
                bulkForwardBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Find all checked boxes
                    const checkedBoxes = document.querySelectorAll('.app-checkbox:checked');

                    // Map over them to grab the application IDs from the dataset
                    const ids = Array.from(checkedBoxes).map(box => box.dataset.id);

                    // If we have selected items, open the forward modal with the array of IDs
                    if (ids.length > 0) {
                        openForwardModal(ids);
                    } else {
                        Swal.fire('Warning',
                            'Please select at least one application to forward.', 'warning');
                    }
                });
            }

            const revertBtn = event.target.closest('.revert-single-btn');
            if (revertBtn) {
                document.getElementById('applicationIdToRevert').value = revertBtn.dataset.id;
                document.getElementById('revert_comment').value = '';
                new bootstrap.Modal(document.getElementById('revertModal')).show();
            }

            // --- Pull Back Logic ---
            const pullBtn = event.target.closest('.pull-back-btn');
            if (pullBtn) {
                event.preventDefault();
                const appId = pullBtn.dataset.id;
                Swal.fire({
                    title: 'Pull Back Application?',
                    text: "This will move the application back to your pending list.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, pull it back!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        performAction('{{ route('office.dashboard.benefit.pull-back') }}', {
                            application_id: appId
                        });
                    }
                });
            }

            // --- Preview Logic ---
            const previewBtn = event.target.closest('.preview-button');
            if (previewBtn) {
                const appId = previewBtn.dataset.id;
                $('#previewModal .modal-body').html(
                    '<div class="text-center p-5"><div class="spinner-border"></div></div>');
                previewModal.show();
                $.get('/office/dashboard/applications/' + appId + '/preview', function(response) {
                    $('#previewModal .modal-body').html(response.html);
                    $('#previewModal .modal-title').text('Preview: ' + response.application_id);
                });
            }

            // --- Log/History Logic ---
            const logBtn = event.target.closest('.view-log-btn');
            if (logBtn) {
                const appId = logBtn.dataset.id;
                $('#logModal .modal-body').html(
                    '<div class="text-center p-5"><div class="spinner-border"></div></div>');
                logModal.show();
                $.get('/office/dashboard/applications/' + appId + '/log', function(response) {
                    $('#logModal .modal-body').html(response.html);
                });
            }

            // --- Forward Logic ---
            const fwdBtn = event.target.closest('.forward-single-btn');
            if (fwdBtn) openForwardModal([fwdBtn.dataset.id]);

            // --- Approve Logic ---
            const appBtn = event.target.closest('.approve-single-btn');
            if (appBtn) {
                document.getElementById('applicationIdToApprove').value = appBtn.dataset.id;
                document.getElementById('approve_comment').value = '';
                approveModal.show();
            }

            // --- Reject Logic ---
            const rejBtn = event.target.closest('.reject-single-btn');
            if (rejBtn) {
                document.getElementById('applicationIdToReject').value = rejBtn.dataset.id;
                document.getElementById('reject_comment').value = '';
                rejectModal.show();
            }

            // --- Send Back Logic ---
            const backBtn = event.target.closest('.send-back-single-btn');
            if (backBtn) {
                document.getElementById('send-back-officer-name').textContent = backBtn.dataset
                    .previousUserName;
                document.getElementById('applicationIdToSendBack').value = backBtn.dataset.id;
                document.getElementById('targetUserIdToSendBack').value = backBtn.dataset
                    .previousUserId;
                sendBackModal.show();
            }
        });

        // ===================================================================
        // 3. REUSABLE FETCH POST HELPER
        // ===================================================================
        function performAction(url, data) {
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(resData => {
                    if (resData.success) {
                        Swal.fire('Success', resData.message, 'success').then(() => window.location
                            .reload());
                    } else {
                        Swal.fire('Error', resData.message, 'error');
                    }
                })
                .catch(() => Swal.fire('Error', 'Connection failed', 'error'));
        }

        // ===================================================================
        // 4. MODAL SUBMISSIONS
        // ===================================================================
        document.getElementById('submitSendBackBtn').addEventListener('click', function() {
            const data = {
                application_id: document.getElementById('applicationIdToSendBack').value,
                target_user_id: document.getElementById('targetUserIdToSendBack').value,
                comment: document.getElementById('send_back_comment').value,
            };

            // Validation
            if (!data.comment || data.comment.trim() === "") {
                return Swal.fire('Error', 'Please provide a comment for sending back.', 'error');
            }

            // Use the helper function to perform the AJAX request
            performAction('{{ route('office.dashboard.benefit.send-back') }}', data);
        });

        // Forward Submission
        document.getElementById('submitForwardRoBtn').addEventListener('click', function() {
            const data = {
                application_ids: selectedApplicationIds,
                user_id: userSelect.value,
                comment: document.getElementById('forward_comment').value
            };
            if (!data.user_id || !data.comment) return Swal.fire('Error', 'Fields required', 'error');
            performAction('{{ route('office.dashboard.benefit.forward') }}', data);
        });

        // Revert Submission
        const submitRevertBtn = document.getElementById('submitRevertBtn');
        if (submitRevertBtn) {
            submitRevertBtn.addEventListener('click', function() {
                const data = {
                    application_id: document.getElementById('applicationIdToRevert').value,
                    comment: document.getElementById('revert_comment').value
                };

                if (data.comment.trim() === '') {
                    return Swal.fire('Error', 'Please provide a reason for reverting the application.',
                        'error');
                }

                // Note: Make sure this route exists in your web.php!
                performAction('{{ route('office.dashboard.benefit.revert') }}', data);
            });
        }

        // Approve Submission
        document.getElementById('submitApproveBtn').addEventListener('click', function() {
            const data = {
                application_id: document.getElementById('applicationIdToApprove').value,
                comment: document.getElementById('approve_comment').value
            };
            performAction('{{ route('office.dashboard.benefit.approve') }}', data);
        });

        // Reject Submission
        document.getElementById('submitRejectBtn').addEventListener('click', function() {
            const data = {
                application_id: document.getElementById('applicationIdToReject').value,
                comment: document.getElementById('reject_comment').value
            };
            if (data.comment.length < 10) return Swal.fire('Error', 'Reason too short', 'error');
            performAction('{{ route('office.dashboard.benefit.reject') }}', data);
        });

        // Role Select Logic
        roleSelect.addEventListener('change', function() {
            const rid = parseInt(this.value);
            const filtered = allForwardableUsers.filter(u => u.role_id === rid);
            userSelect.innerHTML = '<option value="" disabled selected>Select Officer</option>';
            filtered.forEach(u => {
                userSelect.innerHTML +=
                    `<option value="${u.id}">${u.username} (${u.firstname})</option>`;
            });
            userSelect.disabled = false;
        });

        // Checkbox Logic
        function updateCheckboxLogic() {
            const boxes = document.querySelectorAll('.app-checkbox');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', () => {
                    boxes.forEach(b => b.checked = selectAllCheckbox.checked);
                    toggleBulkUI();
                });
            }
            boxes.forEach(b => b.addEventListener('change', toggleBulkUI));
        }

        function toggleBulkUI() {
            const checked = document.querySelectorAll('.app-checkbox:checked');
            if (bulkActionContainer) bulkActionContainer.style.display = checked.length > 0 ? 'block' : 'none';
            if (selectedCountSpan) selectedCountSpan.textContent = checked.length;
        }

        function openForwardModal(ids) {
            selectedApplicationIds = ids;
            forwardModal.show();
        }

        function initializeTooltips() {
    try {
        // 1. Check if the bootstrap global object and Tooltip module actually exist
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');

            tooltipTriggerList.forEach(tooltipTriggerEl => {
                // 2. Safely check if getInstance exists before attempting to use it
                if (typeof bootstrap.Tooltip.getInstance === 'function') {
                    const existingTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
                    if (existingTooltip) {
                        existingTooltip.dispose();
                    }
                }

                // 3. Initialize the new tooltip
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        } else {
            console.warn("Bootstrap Tooltip module is missing. Tooltips will not display.");
        }
    } catch (error) {
        // 4. Catch any unexpected errors so they don't break the rest of your app (like your tabs)
        console.error("Tooltip initialization bypassed due to error:", error);
    }
}

        // Init
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
