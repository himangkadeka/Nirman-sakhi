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

        <div id="processing" class="tab-content active">
            <h2>Application Processing</h2>

            {{-- NEW: Add this button for the bulk action --}}
            <div class="mb-3">
                <button type="button" class="btn btn-success" id="openAssignModalBtn">Assign Selected to DA</button>
            </div>

            <table id="processingTable"> {{-- Give your table an ID --}}
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAllCheckbox"></th>
                        <th>App ID</th>
                        <th>Worker ID</th>
                        <th>Applicant Name</th>
                        <th>Applicant Phone Number</th>
                        <th>Scheme</th>
                        <th>View</th>
                        <th>Submitted Date</th>
                        {{-- REMOVED: The action column is replaced by the main button --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($processingApplications as $app)
                        {{-- Use a specific variable for this tab --}}
                        <tr>
                            {{-- The data-id attribute is crucial for JavaScript --}}
                            <td><input type="checkbox" class="app-checkbox" data-id="{{ $app->id }}"></td>
                            <td>{{ $app->application_id }}</td>
                            <td>{{ $app->worker->id_card }}</td>
                            <td>{{ $app->getApplicantDetails()->name ?? 'NA' }}</td>
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
                            <td colspan="8" style="text-align: center;">No applications are currently in processing.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $processingApplications->links() }}
            </div>
        </div>


    </div>



    <div class="modal fade" id="assignToDaModal" tabindex="-1" aria-labelledby="assignToDaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- Renamed title for clarity --}}
                    <h5 class="modal-title" id="assignToDaModalLabel">Assign Application(s) to Dealing Assistant</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- The form will be handled by JavaScript, no 'action' or 'method' needed --}}
                    <form id="assignDaForm">
                        <input type="hidden" name="application_ids" id="applicationIdsToAssign">
                        <div class="mb-3">
                            <label for="da_user_select" class="form-label">Select Dealing Assistant</label>
                            {{-- Renamed ID for clarity --}}
                            <select class="form-control" id="da_user_select" name="da_user_id" required>
                                <option value="" selected disabled>- Select a DA -</option>
                                @foreach ($dealingAssistants as $da)
                                    {{-- Changed variable to $da for clarity --}}
                                    <option value="{{ $da->id }}">{{ $da->firstname }} {{ $da->lastname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="assign_comment" class="form-label">Comment (Optional)</label>
                            <textarea class="form-control" id="assign_comment" name="comment" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitAssignmentBtn">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                            style="display: none;"></span>
                        Assign
                    </button>
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
            // --- Checkbox Logic ---
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const rowCheckboxes = document.querySelectorAll('#processingTable .app-checkbox');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });
            }

            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    } else if (document.querySelectorAll('#processingTable .app-checkbox:checked')
                        .length === rowCheckboxes.length) {
                        selectAllCheckbox.checked = true;
                    }
                });
            });

            // --- Modal Logic ---
            const assignModalElement = document.getElementById('assignToDaModal');
            const assignModal = new bootstrap.Modal(assignModalElement);
            const openModalBtn = document.getElementById('openAssignModalBtn');
            const submitAssignmentBtn = document.getElementById('submitAssignmentBtn');
            const hiddenInput = document.getElementById('applicationIdsToAssign');
            const assignForm = document.getElementById('assignDaForm');

            // 1. Open the modal
            if (openModalBtn) {
                openModalBtn.addEventListener('click', function() {
                    const selectedIds = Array.from(document.querySelectorAll('.app-checkbox:checked')).map(
                        cb => cb.dataset.id);

                    if (selectedIds.length === 0) {
                        alert('Please select at least one application to assign.');
                        return;
                    }

                    // Put the selected IDs into the hidden form field
                    hiddenInput.value = JSON.stringify(selectedIds);
                    assignModal.show();
                });
            }

            // 2. Submit the assignment
            if (submitAssignmentBtn) {
                submitAssignmentBtn.addEventListener('click', function() {
                    const daSelect = document.getElementById('da_user_select');

                    // Basic validation
                    if (!daSelect.value) {
                        alert('Please select a Dealing Assistant.');
                        return;
                    }

                    const spinner = this.querySelector('.spinner-border');
                    spinner.style.display = 'inline-block';
                    this.disabled = true;

                    const formData = {
                        application_ids: JSON.parse(hiddenInput.value),
                        da_user_id: daSelect.value,
                        comment: document.getElementById('assign_comment').value
                    };

                    fetch("{{ route('office.head-office.applications.assignToDa') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify(formData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success!', data.message, 'success');
                                assignModal.hide();
                                window.location.reload();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('A network or server error occurred.');
                        })
                        .finally(() => {
                            // Hide spinner and re-enable button
                            spinner.style.display = 'none';
                            this.disabled = false;
                        });
                });
            }

            // Optional: Reset form when modal is closed
            assignModalElement.addEventListener('hidden.bs.modal', function() {
                assignForm.reset();
                hiddenInput.value = '';
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
