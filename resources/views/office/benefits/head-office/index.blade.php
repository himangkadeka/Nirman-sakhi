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


        @include('office.benefits.head-office.tabs')


        <!-- Tab Content Panels -->
        <div id="incoming" class="tab-content active" data-has-pending="{{ $hasPendingBatch ? 'true' : 'false' }}">
            <h2>Incoming from HRO</h2>
            <div style="margin-bottom:10px;">
                <label for="batchSize">Batch size:</label>
                <input id="batchSize" type="number" value="" min="1" style="width:60px; padding: 4px;" />

                {{-- The button that triggers the JavaScript function --}}
                <button class="btn" onclick="lockBatch()">Lock for Processing</button>
            </div>

            {{-- Your table remains the same --}}
            <table id="">
                <thead>
                    <tr>
                        <th>App ID</th>
                        <th>Worker ID</th>
                        <th>Applicant Name</th>
                        <th>Applicant Phone Number</th>
                        <th>Scheme</th>
                        <th>View</th>
                        <th>Submitted Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submittedApplications as $app)
                        <tr>
                            <td>{{ $app->application_id }}</td>
                            <td>{{ $app->worker->id_card }}</td>
                            <td>{{ $app->getApplicantDetails()->name ?? 'NA'}}</td>
                            <td>{{ $app->worker->phone_no }}</td>
                            <td>{{ $app->benefit->name }}</td>
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
                            <td>{{ $app->submitted_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">No incoming applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $submittedApplications->links() }}
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
        function lockBatch() {
            const incomingContainer = document.getElementById('incoming');
            const hasPending = incomingContainer.dataset.hasPending === 'true';

            if (hasPending) {
                alert(
                    'Action Failed: You have a previously locked batch that is still pending approval. Please complete it before locking a new one.'
                );
                return; // Stop the function
            }

            // 2. Get the batch size from the input field.
            const batchSize = parseInt(document.getElementById('batchSize').value, 10);

            // Validate the input
            if (!batchSize || batchSize <= 0) {
                alert('Please enter a valid, positive number for the batch size.');
                return;
            }

            // Optional: Confirm the action with the user
            if (!confirm(`Are you sure you want to lock the ${batchSize} oldest applications for processing?`)) {
                return;
            }

            // 3. Send the BATCH SIZE to the server. We are no longer sending specific IDs.
            const url = "{{ route('office.head-office.applications.lockBatch') }}";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    // The body of the request now contains the batch_size
                    body: JSON.stringify({
                        batch_size: batchSize
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success');
                        window.location.reload(); // Reload to see the updated application list
                    } else {
                        // Show any error message from the server (e.g., "No applications to lock")
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('A network error occurred. Please try again.');
                });
        }

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
