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
        @include('office.benefits.dlc-dashboard.tabs')

        <div id="accounts" class="tab-content active">

            {{-- NEW: PPA Signing Workflow Section --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Signed PPA</h4>
                </div>
                <div class="card-body">
                    <p>The following batches are ready for Forwarding.</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Batch ID</th>
                                    <th>No. of Applications</th>
                                    <th>Date Dispatched</th>
                                    <th>Signed At</th>
                                    <th class="text-center">Signed PPA</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingSignatureBatches as $batch)
                                    <tr>
                                        <td><strong>{{ $batch->batch_id }}</strong></td>
                                        <td>{{ $batch->application_count }}</td>
                                        <td>{{ \Carbon\Carbon::parse($batch->dispatched_at)->format('d-M-Y H:i A') }}</td>
                                        <td>
                                            {{-- Use the new efficient collection. Check if the key exists first. --}}
                                            @if (isset($ppaBatchFiles[$batch->batch_id]))
                                                {{ \Carbon\Carbon::parse($ppaBatchFiles[$batch->batch_id]->accounts_signed_at)->format('d-M-Y H:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('office.accounts.ppa-signed.download', ['batch_id' => $batch->batch_id]) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-download"></i> Download Signed PPA
                                                </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                {{-- This button now triggers the new JS --}}
                                                <button class="btn btn-sm btn-success forward-to-lc-btn"
                                                    data-batch-id="{{ $batch->batch_id }}">
                                                    <i class="fas fa-check"></i> Forward To LC for Sign
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-3">There are no batches awaiting signature.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Your existing summary and applications tables --}}
            <h3>Budget Summary by Scheme</h3>
            <table id="accountsSummaryTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Scheme</th>
                        <th>Total Sanctioned Amount</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Using number_format for consistency --}}
                    @forelse ($budgetSummary as $summaryItem)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $summaryItem->scheme_name }}</td>
                            <td>{{ number_format($summaryItem->total_budget, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">No budget summary available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <h3 style="margin-top:20px;">Applications List</h3>
            <table id="applicationsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>App ID</th>
                        <th>Worker ID</th>
                        <th>Applicant Name</th>
                        <th>Applicant Phone Number</th>
                        <th>Scheme</th>
                        <th>Sanctioned Amount</th>
                        <th>Submitted Date</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $app->application_id }}</td>
                            <td>{{ $app->worker->id_card }}</td>
                            <td>{{ $app->getApplicantDetails()->name ?? 'NA' }}</td>
                            <td>{{ $app->worker->phone_no }}</td>
                            <td>{{ $app->benefit->name }}</td>
                            <td>{{ number_format($app->sanctioned_amount, 2) }}</td>
                            <td>{{ $app->submitted_at??'--' }}</td>
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
                                    {{-- <button class="btn btn-success btn-sm shadow-sm forward-single-btn"
                                        data-id="{{ $app->id }}" data-bs-toggle="tooltip" title="Forward to LC">
                                        <i class="fas fa-share"></i>
                                    </button> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center;">No applications found in the accounts queue.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $applications->links() }}
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Get Modal Elements ---
            const confirmationModalEl = document.getElementById('confirmationModal');
            const confirmationModal = new bootstrap.Modal(confirmationModalEl);
            const confirmationMessage = document.getElementById('confirmationModalMessage');
            const confirmActionBtn = document.getElementById('confirmActionBtn');

            // ===================================================================
            // 1. REUSABLE, PROMISE-BASED CONFIRMATION FUNCTION
            // ===================================================================
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
                        if (e.target === confirmationModalEl) {
                            resolve(false);
                            confirmationModalEl.removeEventListener('hidden.bs.modal', cancelHandler);
                        }
                    };
                    confirmationModalEl.addEventListener('hidden.bs.modal', cancelHandler);
                });
            }

            // ===================================================================
            // 2. MAIN EVENT LISTENER FOR ALL ACTIONS (USING EVENT DELEGATION)
            // ===================================================================
            document.body.addEventListener('click', async function(event) {
                const forwardButton = event.target.closest('.forward-to-lc-btn');

                if (forwardButton) {
                    event.preventDefault();

                    const batchId = forwardButton.dataset.batchId;
                    const message =
                        `Are you sure you want to forward Batch ID: ${batchId} to the LC for signature?`;
                    const confirmed = await showConfirmation(message);

                    if (confirmed) {
                        const originalButtonText = forwardButton.innerHTML;
                        forwardButton.disabled = true;
                        forwardButton.innerHTML =
                            `<span class="spinner-border spinner-border-sm"></span> Forwarding...`;

                        // THIS IS THE CORRECTED LINE
                        fetch("{{ route('office.dlc-dashboard.forwardToLcForSign') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    batch_id: batchId
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.text().then(text => {
                                        throw new Error(text || 'Server error')
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    Swal.fire("Success!", data.message, 'success').then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    throw new Error(data.message || 'An unknown error occurred.');
                                }
                            })
                            .catch(error => {
                                console.error('Forwarding Error:', error);
                                // This check helps debug if the server is still sending HTML
                                if (error.message.includes('<!DOCTYPE')) {
                                    Swal.fire('Routing Error',
                                        'The server returned an HTML page instead of a valid response. Please check the route name and logs.',
                                        'error');
                                } else {
                                    Swal.fire('Error!', error.message, 'error');
                                }
                            })
                            .finally(() => {
                                forwardButton.disabled = false;
                                forwardButton.innerHTML = originalButtonText;
                            });
                    }
                }
            });

            // No need for tooltip initialization as there are no tooltips in the provided HTML.
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
