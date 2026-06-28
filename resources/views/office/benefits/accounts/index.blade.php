@extends('layouts.admin-app')

@section('title', 'Office | Application | Benefit Overview')
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Benefit Overview Dashboard')

{{-- Page-specific styles are placed in the 'header' section --}}
@section('header')
    <style>
        /* Scoping all styles to this specific component to avoid conflicts with the main admin layout. */
        .nirman-sahi-dashboard-container {
            font-family: Arial, sans-serif;
            color: #333;
            margin-top: 15px;
            /* Optional: Adjusts spacing if the admin layout has its own padding */

        }

        .nirman-sahi-dashboard-container .page-specific-header {
            background: #1466ff;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .nirman-sahi-dashboard-container .logout {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            color: #1466ff;
            border: 1px solid #1466ff;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .nirman-sahi-dashboard-container .search-bar {
            margin-bottom: 15px;
            text-align: right;
        }

        .nirman-sahi-dashboard-container .search-bar input {
            padding: 8px;
            width: 280px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .nirman-sahi-dashboard-container .tabs {
            display: flex;
            flex-wrap: wrap;
            border-bottom: 3px solid #1466ff;
            margin-bottom: 0;
        }

        .nirman-sahi-dashboard-container .tabs .tab-button {
            /* CHANGED from 'button' to '.tab-button' */
            flex-grow: 1;
            padding: 12px 10px;
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-bottom: none;
            cursor: pointer;
            transition: background .3s, color .3s;
            font-size: 14px;
            margin-right: 4px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;

            /* ADD these two lines to override default <a> tag styles */
            color: #333;
            /* Set default text color */
            text-decoration: none;
            /* Remove the underline */
        }

        .nirman-sahi-dashboard-container .tabs .tab-button.active {
            background: #1466ff;
            color: #fff;
            border-color: #1466ff;
        }

        .nirman-sahi-dashboard-container .tabs .tab-button:hover:not(.active) {
            background: #e0e0e0;
        }

        .nirman-sahi-dashboard-container .tab-content {
            display: none;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
            margin-bottom: 20px;
        }

        .nirman-sahi-dashboard-container .tab-content.active {
            display: block;
        }

        .nirman-sahi-dashboard-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
            overflow: visible !important;
        }

        .nirman-sahi-dashboard-container th,
        .nirman-sahi-dashboard-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
            overflow: visible !important;
        }

        .nirman-sahi-dashboard-container th {
            background: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        .nirman-sahi-dashboard-container tr:nth-child(even) {
            background: #f9f9f9;
        }

        .nirman-sahi-dashboard-container .btn {
            background-color: #1466ff;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin: 2px;
        }

        .nirman-sahi-dashboard-container .btn:hover {
            background-color: #45a049;
        }

        .nirman-sahi-dashboard-container .btn.btn-revert {
            background-color: #f44336;
        }

        .nirman-sahi-dashboard-container .btn.btn-revert:hover {
            background-color: #d32f2f;
        }

        .nirman-sahi-dashboard-container .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .nirman-sahi-dashboard-container .summary-card {
            background: #fff;
            border: 1px solid #ddd;
            border-left: 5px solid #1466ff;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .nirman-sahi-dashboard-container .summary-card h3 {
            color: #555;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .nirman-sahi-dashboard-container .summary-card p {
            font-size: 24px;
            font-weight: bold;
            color: #1466ff;
        }

        .nirman-sahi-dashboard-container .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px 0;
            flex-wrap: wrap;
        }

        .nirman-sahi-dashboard-container .pagination-container a,
        .nirman-sahi-dashboard-container .pagination-container span {
            color: #1466ff;
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ddd;
            text-decoration: none;
            transition: background-color .3s;
            border-radius: 4px;
            cursor: pointer;
        }

        .nirman-sahi-dashboard-container .pagination-container span.disabled {
            color: #aaa;
            cursor: not-allowed;
            background-color: #f9f9f9;
        }

        .nirman-sahi-dashboard-container .pagination-container a:hover:not(.active) {
            background-color: #f1f1f1;
        }

        .nirman-sahi-dashboard-container .pagination-container .active {
            background-color: #1466ff;
            color: white;
            border-color: #1466ff;
        }

    </style>
@endsection

@section('content')
    <div class="nirman-sahi-dashboard-container mx-5">
        @include('office.benefits.accounts.tabs')

        <div id="accounts" class="tab-content active">
            <h2>Accounts Office Processing</h2>

            <h3>Budget Summary by Scheme</h3>
            <table id="accountsSummaryTable">
                <thead>
                    <tr>
                        <th>Scheme</th>
                        <th>Total Sanctioned Amount</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Using number_format for consistency --}}
                    @forelse ($budgetSummary as $summaryItem)
                        <tr>
                            <td>{{ $summaryItem->scheme_name }}</td>
                            <td>{{ number_format($summaryItem->total_budget, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="text-align: center;">No budget summary available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- THE CORRECTED BUTTON --}}
            <a href="{{ route('office.head-office.accounts.export') }}" id="exportAccounts" class="btn btn-success"
                style="margin-top:8px;"
                @if ($applications->isEmpty()) aria-disabled="true"
       onclick="event.preventDefault();"
       style="pointer-events: none; opacity: 0.65; margin-top:8px;" @endif>
                <i class="fas fa-file-excel"></i> Download Excel
            </a>

            <h3 style="margin-top:20px;">Applications Forwarded to Accounts</h3>
            <table id="applicationsTable">
                <thead>
                    <tr>
                        <th>App ID</th>
                        <th>Worker ID</th>
                        <th>Applicant Name</th>
                        <th>Applicant Phone Number</th>
                        <th>Scheme</th>
                        <th>Sanctioned Amount</th>
                        <th>View</th>
                        <th>Submitted Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr>
                            <td>{{ $app->application_id }}</td>
                            <td>{{ $app->worker->id_card }}</td>
                            <td>{{ $app->getApplicantDetails()->name ?? 'NA' }}</td>
                            <td>{{ $app->worker->phone_no }}</td>
                            <td>{{ $app->benefit->name }}</td>
                            <td>{{ number_format($app->sanctioned_amount, 2) }}</td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm rounded-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm preview-button"
                                        data-id="{{ $app->application_id }}" data-bs-toggle="tooltip"
                                        title="Preview Application">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm view-log-btn"
                                        data-id="{{ $app->id }}" data-bs-toggle="tooltip" title="View Action Log">
                                        <i class="fas fa-history"></i>
                                    </button>
                                </div>
                            </td>
                            <td>{{ $app->submitted_at? \Carbon\Carbon::parse($app->submitted_at)->format('d-m-Y h:i A'):'--' }}</td>

                            <td>
                                {{-- Use a button group for better styling and organization --}}
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
    id="actionDropdown{{ $app->id }}"
    data-toggle="dropdown"
    data-bs-toggle="dropdown"
    data-boundary="window"
    data-bs-boundary="window"
    aria-expanded="false">
    Actions
</button>
                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $app->id }}">
                                        <li><a class="dropdown-item decision-option" href="#" data-id="{{ $app->id }}" data-decision="approve">Approve & Send to DLC</a></li>
                                        <li><a class="dropdown-item decision-option" href="#" data-id="{{ $app->id }}" data-decision="reject">Reject</a></li>
                                        <li><a class="dropdown-item decision-option" href="#" data-id="{{ $app->id }}" data-decision="revert">Revert</a></li>
                                    </ul>
                                </div>
                                <div class="mt-2 decision-selected small text-muted" id="decisionSelected{{ $app->id }}">No action selected</div>
                                <div class="mt-2 d-none comment-wrapper" id="commentWrapper{{ $app->id }}">
                                    <textarea class="form-control form-control-sm decision-comment" data-id="{{ $app->id }}" placeholder="Enter reason (required for reject/revert)"></textarea>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center;">No applications found in the accounts queue.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    <button id="submitAllDecisions" class="btn btn-primary">Submit All Decisions</button>
                </div>
                <div>
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actionModalLabel">Provide Reason</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>A comment is required for this action.</p>
                    <textarea class="form-control" id="actionComment" rows="4" placeholder="Enter reason here..." required></textarea>
                    <div class="text-danger mt-1" id="commentError" style="display: none;">This field is required.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitActionBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Place this reusable confirmation modal inside your @section('content') --}}
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> {{-- Centered for better UX --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- The confirmation message will be set dynamically by JavaScript --}}
                    <p id="confirmationModalMessage">Are you sure you want to proceed?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    {{-- This button will trigger the actual action --}}
                    <button type="button" class="btn btn-primary" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="previewModalLabel"><i
                            class="fas fa-file-alt text-primary me-2"></i>Application Preview</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
        document.addEventListener('DOMContentLoaded', function() {
            // --- Get references to ALL modal elements ---
            // Modal for Reject/Revert comments
            const actionModalElement = document.getElementById('actionModal');
            const actionModal = new bootstrap.Modal(actionModalElement);
            const modalTitle = document.getElementById('actionModalLabel');
            const modalComment = document.getElementById('actionComment');
            const modalSubmitBtn = document.getElementById('submitActionBtn');
            const commentError = document.getElementById('commentError');

            // NEW: Modal for confirmation
            const confirmationModalElement = document.getElementById('confirmationModal');
            const confirmationModal = new bootstrap.Modal(confirmationModalElement);
            const confirmationMessage = document.getElementById('confirmationModalMessage');
            const confirmActionBtn = document.getElementById('confirmActionBtn');

            // --- State variables ---
            let currentAppId = null;
            let currentAction = null;
            let currentComment = null; // Store comment temporarily

            // --- NEW: Promise-based confirmation function ---
            function showConfirmation(message) {
                return new Promise((resolve) => {
                    // Set the confirmation message
                    confirmationMessage.textContent = message;

                    // Show the modal
                    confirmationModal.show();

                    // Create a one-time click listener for the confirm button
                    const confirmHandler = () => {
                        confirmationModal.hide();
                        resolve(true); // User confirmed
                        confirmActionBtn.removeEventListener('click',
                            confirmHandler); // Clean up listener
                    };
                    confirmActionBtn.addEventListener('click', confirmHandler);

                    // Handle the case where the user cancels (closes modal)
                    confirmationModalElement.addEventListener('hidden.bs.modal', () => {
                        resolve(false); // User canceled
                    }, {
                        once: true
                    }); // Listener runs only once
                });
            }

            // --- Reusable function to send data to the server ---
            function performAction() {
                // Find the button to show the spinner on
                const button = document.querySelector(
                    `.action-btn[data-id="${currentAppId}"][class*="${currentAction}-btn"]`);
                const originalButtonText = button.innerHTML;
                button.disabled = true;
                button.innerHTML = `<span class="spinner-border spinner-border-sm"></span>`;

                fetch("{{ route('office.accounts.processAction') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            application_id: currentAppId,
                            action: currentAction,
                            comment: currentComment
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success');
                            window.location.reload();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                            button.disabled = false;
                            button.innerHTML = originalButtonText;
                        }
                    })
                    .catch(error => {
                        // ... (error handling) ...
                        button.disabled = false;
                        button.innerHTML = originalButtonText;
                    });
            }


            // --- Add event listeners to all action buttons ---

            // 1. For the "Approve" button
            document.querySelectorAll('.approve-btn').forEach(button => {
                button.addEventListener('click', async function() { // Mark function as async
                    const appId = this.dataset.id;
                    const action = 'approve';

                    const confirmed = await showConfirmation(
                        `Are you sure you want to APPROVE this application and send it to DLC?`
                    );

                    if (confirmed) {
                        currentAppId = appId;
                        currentAction = action;
                        currentComment = null; // No comment for approve
                        performAction();
                    }
                });
            });

            // 2. For "Reject" and "Revert" buttons (opens the comment modal first)
            document.querySelectorAll('.reject-btn, .revert-btn').forEach(button => {
                button.addEventListener('click', function() {
                    currentAppId = this.dataset.id;
                    currentAction = this.classList.contains('reject-btn') ? 'reject' : 'revert';
                    modalTitle.textContent = currentAction.charAt(0).toUpperCase() + currentAction
                        .slice(1) + ' Application';
                    actionModal.show();
                });
            });

            // 3. For the comment modal's "Submit" button
            modalSubmitBtn.addEventListener('click', async function() { // Mark function as async
                const comment = modalComment.value.trim();
                if (!comment) {
                    commentError.style.display = 'block';
                    return;
                }

                commentError.style.display = 'none';
                actionModal.hide(); // Hide the comment modal first

                currentComment = comment; // Store the comment

                const confirmed = await showConfirmation(
                    `Are you sure you want to ${currentAction.toUpperCase()} this application with your comment?`
                );

                if (confirmed) {
                    performAction();
                }
            });

            // Clean up comment modal on close
            actionModalElement.addEventListener('hidden.bs.modal', function() {
                modalComment.value = '';
                commentError.style.display = 'none';
            });
        });

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
        // --- Bulk decision UI handlers ---
        $(document).on('click', '.decision-option', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const decision = $(this).data('decision');
            $(`#decisionSelected${id}`).text(decision.toUpperCase());
            if (decision === 'reject' || decision === 'revert') {
                $(`#commentWrapper${id}`).removeClass('d-none');
            } else {
                $(`#commentWrapper${id}`).addClass('d-none');
                $(`.decision-comment[data-id="${id}"]`).val('');
            }
            // mark selection in a hidden input via data attribute
            $(`#decisionSelected${id}`).data('decision', decision);
        });

        $('#submitAllDecisions').on('click', function() {
            const decisions = {};
            const comments = {};
            let anySelected = false;

            $('tr').each(function() {
                const row = $(this);
                const idCell = row.find('td').first();
                const appId = row.find('.approve-btn, .reject-btn, .revert-btn').data('id') || row.find('.decision-option').data('id');
                if (!appId) return; // skip non-data rows
                const decisionTextEl = $(`#decisionSelected${appId}`);
                const decision = decisionTextEl.data('decision');
                if (decision) {
                    anySelected = true;
                    decisions[appId] = decision;
                    const comment = $(`.decision-comment[data-id="${appId}"]`).val() || null;
                    comments[appId] = comment;
                }
            });

            if (!anySelected) {
                Swal.fire('No Decisions', 'Please select at least one action for applications.', 'warning');
                return;
            }

            // Validate comments for required decisions
            for (const [id, dec] of Object.entries(decisions)) {
                if ((dec === 'reject' || dec === 'revert') && (!comments[id] || comments[id].trim() === '')) {
                    Swal.fire('Missing Comment', 'Please provide a reason for reject/revert for application ID ' + id, 'warning');
                    return;
                }
            }

            // Confirm
            Swal.fire({
                title: 'Confirm Submit',
                text: `Submit ${Object.keys(decisions).length} decision(s)?`,
                icon: 'question',
                showCancelButton: true
            }).then((result) => {
                if (!result.isConfirmed) return;

                const payload = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    decisions: decisions,
                    comments: comments
                };

                const btn = $(this);
                btn.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: '{{ route('office.accounts.processBulkActions') }}',
                    method: 'POST',
                    data: payload,
                    success: function(resp) {
                        if (resp.success) {
                            Swal.fire('Success!', resp.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error', resp.message || 'An error occurred', 'error');
                        }
                    },
                    error: function(xhr) {
                        let msg = 'An unexpected error occurred.';
                        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        Swal.fire('Failed', msg, 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).text('Submit All Decisions');
                    }
                });
            });
        });
    </script>
@endsection
