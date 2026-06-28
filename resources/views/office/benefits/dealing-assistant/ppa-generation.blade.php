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

        <div id="dlc-content" class="tab-content active">


            {{-- THE CORRECTED BUTTON --}}


            <h3 style="margin-top:20px;">
                    Applications For PPA Generations

            </h3>

             <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Payment Processing (PPA)</h5>
                    <div class="row">
                        {{-- Part 1: Download Button --}}
                        <div class="col-md-6 border-end">
                            <h6>Step 1: Download PPA Excel</h6>
                            <p>Download the list of all applications ready for payment processing.</p>
                            <a href="{{ route('office.head-office-da.ppa.export') }}" class="btn btn-success"
                               @if ($applications->isEmpty()) disabled @endif>
                                <i class="fas fa-file-excel"></i> Download for PPA
                            </a>
                        </div>
                        {{-- Part 2: Upload Form --}}
                        <div class="col-md-6">
                             <h6>Step 2: Upload PPA File</h6>
                             <p>After processing, upload the final PPA file here to update all applications.</p>
                             <form action="{{ route('office.head-office-da.ppa.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="ppa_batch_id" class="form-label">Batch ID / Reference</label>
                                    <input type="text" class="form-control" id="ppa_batch_id" name="ppa_batch_id" required>
                                </div>
                                <div class="mb-3">
                                    <label for="ppa_file" class="form-label">PPA File (PDF, Excel)</label>
                                    <input class="form-control" type="file" id="ppa_file" name="ppa_file" required>
                                 </div>
                                 <div class="mb-3">
                                     <label for="ppa_comment" class="form-label">Comment (Optional)</label>
                                     <textarea class="form-control" id="ppa_comment" name="comment" rows="2"></textarea>
                                 </div>
                                <button type="submit" class="btn btn-primary"
                                    {{-- @if ($applications->isEmpty()) disabled @endif --}}
                                    >
                                    <i class="fas fa-upload"></i> Upload & Update Status
                                </button>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="text-secondary">Application Details</h4>
            <table id="applicationsTable">
                <thead>
                    <tr>
                        <th>App ID</th>
                        <th>Worker ID Card</th>
                        <th>Scheme</th>
                        <th>Sanctioned Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr>
                            <td>{{ $app->application_id }}</td>
                            <td>{{ $app->worker->id_card }}</td>
                            <td>{{ $app->benefit->name }}</td>
                            <td>{{ number_format($app->sanctioned_amount, 2) }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm shadow-sm preview-button"
                                        data-id="{{ $app->id }}" data-bs-toggle="tooltip" title="Preview Application">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm shadow-sm view-log-btn"
                                        data-id="{{ $app->id }}" data-bs-toggle="tooltip" title="View Action Log">
                                        <i class="fas fa-history"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">No applications found in the accounts queue.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $applications->links() }}
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

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmationModalMessage">Are you sure you want to proceed?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Get references to all necessary elements ---
            const applicationsTable = document.getElementById('applicationsTable');
            const previewModalEl = document.getElementById('previewModal');
            const previewModal = new bootstrap.Modal(previewModalEl);
            const logModalEl = document.getElementById('logModal');
            const logModal = new bootstrap.Modal(logModalEl);
            const confirmationModalEl = document.getElementById('confirmationModal');
            const confirmationModal = new bootstrap.Modal(confirmationModalEl);
            const confirmationMessage = document.getElementById('confirmationModalMessage');
            const confirmActionBtn = document.getElementById('confirmActionBtn');

            if (!applicationsTable) return;

            // --- Reusable, promise-based confirmation modal function ---
            function showConfirmation(message) {
                return new Promise((resolve) => {
                    confirmationMessage.textContent = message;
                    confirmationModal.show();

                    const confirmHandler = () => {
                        confirmationModal.hide();
                        resolve(true);
                        confirmActionBtn.removeEventListener('click', confirmHandler);
                    };
                    confirmActionBtn.addEventListener('click', confirmHandler);

                    const cancelHandler = (e) => {
                        // This check ensures we only resolve(false) when the modal is fully hidden, not just starting to hide
                        if (e.target === confirmationModalEl) {
                            resolve(false);
                            confirmationModalEl.removeEventListener('hidden.bs.modal', cancelHandler);
                        }
                    };
                    confirmationModalEl.addEventListener('hidden.bs.modal', cancelHandler);
                });
            }

            // --- Reusable function to perform the Forward action ---
            function performForwardAction(applicationId, buttonElement) {
                const originalButtonContent = buttonElement.innerHTML;
                buttonElement.disabled = true;
                buttonElement.innerHTML = `<span class="spinner-border spinner-border-sm"></span>`;

                fetch("{{ route('office.lc-lm-dashboard.forwardToLMorApproved') }}", { // Make sure this route name is correct!
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            application_id: applicationId
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Server responded with an error.');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Success!", data.message, "success");
                            window.location.reload();
                        } else {
                            throw new Error(data.message || 'An unknown error occurred.');
                        }
                    })
                    .catch(error => {
                        console.error('Forwarding Error:', error);
                        Swal.fire('Error!', error.message, 'error');
                        buttonElement.disabled = false;
                        buttonElement.innerHTML = originalButtonContent;
                    });
            }

            // --- Main Event Listener for all button clicks ---
            // CORRECTED: Added the 'async' keyword here
            applicationsTable.addEventListener('click', async function(event) {
                const button = event.target.closest('button');
                if (!button) return;

                const applicationId = button.dataset.id;

                // --- Preview Logic (using fetch) ---
                if (button.classList.contains('preview-button')) {
                    const modalBody = previewModalEl.querySelector('.modal-body');
                    modalBody.innerHTML =
                        `<div class="text-center p-5"><div class="spinner-border"></div><p>Loading...</p></div>`;
                    previewModal.show();

                    fetch(`/office/dashboard/applications/${applicationId}/preview`)
                        // CORRECTED: Change .text() to .json() to parse the JSON response
                        .then(response => response.json())
                        .then(data => {
                            // CORRECTED: Access the 'html' property from the parsed data object
                            modalBody.innerHTML = data.html;
                        })
                        .catch(error => {
                            console.error('Preview Error:', error);
                            modalBody.innerHTML =
                                `<div class="alert alert-danger">Failed to load preview.</div>`;
                        });
                }

                // --- Log Logic (using fetch) ---
                if (button.classList.contains('view-log-btn')) {
                    const modalBody = logModalEl.querySelector('.modal-body');
                    modalBody.innerHTML =
                        `<div class="text-center p-5"><div class="spinner-border"></div><p>Fetching history...</p></div>`;
                    logModal.show();

                    fetch(`/office/dashboard/applications/${applicationId}/log`)
                        // CORRECTED: Change .text() to .json()
                        .then(response => response.json())
                        .then(data => {
                            // CORRECTED: Access the 'html' property
                            modalBody.innerHTML = data.html;
                        })
                        .catch(error => {
                            console.error('Log Error:', error);
                            modalBody.innerHTML =
                                `<div class="alert alert-danger">Failed to load logs.</div>`;
                        });
                }

                // --- Forward Logic (using async/await) ---
                if (button.classList.contains('forward-single-btn')) {
                    const confirmed = await showConfirmation(
                        'Are you sure you want to Proceed?'
                    );
                    if (confirmed) {
                        performForwardAction(applicationId, button);
                    }
                }
            });

            // --- Initialize Bootstrap Tooltips ---
            function initializeTooltips() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    const oldTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
                    if (oldTooltip) {
                        oldTooltip.dispose();
                    }
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
            initializeTooltips();
        });
    </script>
@endsection
