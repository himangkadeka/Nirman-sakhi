@extends('layouts.admin-app')

@section('title', 'Office | Application | Benefit Overview')
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Benefit Overview Dashboard')

{{-- Page-specific styles are placed in the 'header' section --}}
@section('header')
    <style>
        tr.row-approved {
            background-color: #e6ffed !important;
            border-left: 3px solid #28a745;
        }

        tr.row-reverted {
            background-color: #ffebee !important;
            border-left: 3px solid #dc3545;
        }

        /* Style for the selected action button */
        .action-btn.active {
            transform: scale(1.1);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }

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
        }

        .nirman-sahi-dashboard-container th,
        .nirman-sahi-dashboard-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
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
        @include('office.benefits.dealing-assistant.tabs')

        <div id="incoming" class="tab-content active">
            <h2>Incoming Applications</h2>

            <table id="incomingTable">
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
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submittedApplications as $app)
                        <tr id="app-row-{{ $app->id }}">
                            <td>{{ $app->application_id }}</td>
                            <td>{{ $app->worker->id_card }}</td>
                            <td>{{ $app->getApplicantDetails()->name ?? 'NA' }}</td>
                            <td>{{ $app->worker->phone_no }}</td>
                            <td>{{ $app->benefit->name }}</td>
                            <td>{{$app->sanctioned_amount}}</td>
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
                            <td>{{ $app->submitted_at??'--' }}</td>
                            <td>
                                <div class="btn-group w-100">
                                    <button class="btn btn-outline-success btn-sm action-btn approve-btn"
                                        data-id="{{ $app->id }}" title="Mark as Valid">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm action-btn revert-btn"
                                        data-id="{{ $app->id }}" title="Revert to HO">
                                        <i class="fas fa-reply"></i> R
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center;">No incoming applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- This is the bottom action bar from your image --}}
            <div class="d-flex justify-content-end align-items-center mt-3 p-2 border-top">
                <button type="button" class="btn btn-secondary me-2" id="resetActionsBtn">Reset</button>
                <button type="button" class="btn btn-success" id="submitBatchBtn">
                    Submit Transactions (<span id="stagedCounter">0</span>)
                </button>
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
                    <p>Please provide a reason for reverting this application.</p>
                    <textarea class="form-control" id="revertComment" rows="4" placeholder="e.g., Missing required document..."
                        required></textarea>
                    <div class="text-danger mt-1" id="commentError" style="display: none;">A comment is required.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveRevertBtn">Save Comment</button>
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
                    <p>Please provide a mandatory reason for reverting this application.</p>
                    <form id="revertForm">
                        <div class="mb-3">
                            <label for="revertComment" class="form-label">Comment</label>
                            <textarea class="form-control" id="revertComment" rows="4"
                                placeholder="e.g., Required documents are missing or unclear..." required></textarea>
                            <div class="text-danger mt-1" id="commentError" style="display: none;">A comment is required.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveRevertBtn">Save Comment</button>
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
            // This object stores the user's choices before submitting.
            let stagedActions = {};

            // --- Get references to all the important elements ---
            const submitBtn = document.getElementById('submitBatchBtn');
            const resetBtn = document.getElementById('resetActionsBtn');
            const counterSpan = document.getElementById('stagedCounter');

            // --- Modal-specific elements ---
            const revertModalElement = document.getElementById('revertModal');
            const revertModal = new bootstrap.Modal(revertModalElement); // Create a Bootstrap modal instance
            const saveRevertBtn = document.getElementById('saveRevertBtn');
            const revertCommentTextarea = document.getElementById('revertComment');
            const commentErrorDiv = document.getElementById('commentError');
            let currentRevertId = null; // Variable to track which application the modal is for

            // --- Core UI and State Management Functions ---
            const updateUiForRow = (appId, action) => {
                // ... (This function remains the same as the previous answer)
                const row = document.getElementById(`app-row-${appId}`);
                if (!row) return;
                row.classList.remove('row-approved', 'row-reverted');
                row.querySelectorAll('.action-btn').forEach(btn => btn.classList.remove('active'));
                if (action === 'approve') {
                    row.classList.add('row-approved');
                    row.querySelector('.approve-btn').classList.add('active');
                } else if (action === 'revert') {
                    row.classList.add('row-reverted');
                    row.querySelector('.revert-btn').classList.add('active');
                }
            };

            const updateCounter = () => {
                counterSpan.textContent = Object.keys(stagedActions).length;
            };

            const stageAction = (id, action, comment = null) => {
                stagedActions[id] = {
                    action,
                    comment
                };
                updateUiForRow(id, action);
                updateCounter();
            };


            // --- Event Listeners ---

            // For "Approve" buttons
            document.querySelectorAll('.approve-btn').forEach(button => {
                button.addEventListener('click', function() {
                    stageAction(this.dataset.id, 'approve');
                });
            });

            // For "Revert" buttons - THIS IS THE UPDATED PART
            document.querySelectorAll('.revert-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // 1. Store the ID of the app we're about to revert
                    currentRevertId = this.dataset.id;

                    // 2. If a comment already exists for this revert, show it
                    if (stagedActions[currentRevertId] && stagedActions[currentRevertId].comment) {
                        revertCommentTextarea.value = stagedActions[currentRevertId].comment;
                    }

                    // 3. Show the modal
                    revertModal.show();
                });
            });

            // For the MODAL'S "Save Comment" button
            saveRevertBtn.addEventListener('click', function() {
                const comment = revertCommentTextarea.value.trim();

                // Validation
                if (!comment) {
                    commentErrorDiv.style.display = 'block';
                    return;
                }

                // Stage the action with the comment and hide the modal
                stageAction(currentRevertId, 'revert', comment);
                revertModal.hide();
            });

            // Clean up the modal when it's hidden
            revertModalElement.addEventListener('hidden.bs.modal', function() {
                revertCommentTextarea.value = '';
                currentRevertId = null;
                commentErrorDiv.style.display = 'none';
            });

            // For the "Reset" button (remains the same)
            resetBtn.addEventListener('click', function() {
                // ... (logic from previous answer)
                if (confirm('Are you sure you want to clear all your selections?')) {
                    stagedActions = {};
                    document.querySelectorAll('tr[id^="app-row-"]').forEach(row => {
                        row.classList.remove('row-approved', 'row-reverted');
                        row.querySelectorAll('.action-btn').forEach(btn => btn.classList.remove(
                            'active'));
                    });
                    updateCounter();
                }
            });

            // For the final "Submit Transactions" button
            submitBtn.addEventListener('click', function() {
                const actionsToSubmit = Object.values(stagedActions).map((value, index) => ({
                    id: Object.keys(stagedActions)[index],
                    ...value
                }));

                if (actionsToSubmit.length === 0) {
                    alert('Please select an action for at least one application.');
                    return;
                }

                if (!confirm(`You are about to submit ${actionsToSubmit.length} actions. Continue?`)) {
                    return;
                }

                this.disabled = true;
                this.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Processing...`;

                fetch("{{ route('office.head-office-da.processBatch') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            actions: actionsToSubmit
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Show success or error from server
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success');
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Submission Error:', error);
                        Swal.fire('A network error occurred.');
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML =
                            `Submit Transactions (<span id="stagedCounter">${counterSpan.textContent}</span>)`;
                    });
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
    </script>
@endsection
