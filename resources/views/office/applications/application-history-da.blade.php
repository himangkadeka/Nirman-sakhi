@extends('layouts.admin-app')

@section('title', 'Office | Application | ' . ucfirst($status))
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', $status)

@section('content')
    <div class="container-fluid">
        <!-- Applications Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bold">
                            <i class="fas fa-file-alt mr-2"></i>Applications
                        </h6>
                        <div class="d-flex">
                            <!-- Filter Dropdown -->
                            <div class="dropdown mr-2">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                                    <h6 class="dropdown-header">Application Status</h6>
                                    <a class="dropdown-item" href="#" data-filter="">All Applications</a>
                                    <a class="dropdown-item" href="#" data-filter="New Register">New Register</a>
                                    <a class="dropdown-item" href="#" data-filter="Re-Submitted">Re-Submitted</a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header">Application Type</h6>
                                    <a class="dropdown-item" href="#" data-filter="New">New Applications</a>
                                    <a class="dropdown-item" href="#" data-filter="Renewal">Renewal Applications</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            @if($applications->total() > 0)
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="py-2 px-3" width="5%">#</th>
                                        <th class="py-2 px-3" width="15%">App No</th>
                                        <th class="py-2 px-3" width="15%">Received On</th>
                                        <th class="py-2 px-3" width="15%">Reviewed On</th>
                                        <th class="py-2 px-3" width="10%">Avg Time</th>
                                        <th class="py-2 px-3" width="15%">Status</th>
                                        <th class="py-2 px-3" width="15%">Category</th>
                                        <th class="py-2 px-3 text-center" width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($applications as $application)
                                        <tr>
                                            <td class="py-2 px-3">{{ ($applications->currentPage() - 1) * $applications->perPage() + $loop->iteration }}</td>
                                            <td class="py-2 px-3">{{ $application->ack_no }}</td>
                                            <td class="py-2 px-3">
                                                @if($application->receiver_created_at)
                                                    {{ \Carbon\Carbon::parse($application->receiver_created_at)->format('d M Y, H:i') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="py-2 px-3">
                                                @if (
                                                    $application->application_status == 'D' ||
                                                    $application->application_status == 'G' ||
                                                    $application->application_status == 'C' ||
                                                    $application->application_status == 'F' ||
                                                    $application->application_status == 'B' ||
                                                    $application->application_status == 'O' ||
                                                    ($application->status == 'A'))
                                                    {{ \Carbon\Carbon::parse($application->created_at)->format('d M Y, H:i') }}
                                                @else
                                                    @php
                                                        $statusRecord = $application->getApplicationStatus($application->worker_id, $application->status);
                                                        if (optional($statusRecord)->created_at) {
                                                            $date = \Carbon\Carbon::parse($statusRecord->created_at);
                                                        } else {
                                                            $date = \Carbon\Carbon::parse($application->created_at);
                                                        }
                                                    @endphp
                                                    {{ $date->format('d M Y, H:i') }}
                                                @endif
                                            </td>

                                            <td class="py-2 px-3">
                                                @if($application->receiver_created_at)
                                                    @php
                                                        $diffMinutes = \Carbon\Carbon::parse($application->created_at)
                                                                        ->diffInMinutes(\Carbon\Carbon::parse($application->receiver_created_at));
                                                    @endphp
                                                    {{ $diffMinutes }} min
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="py-2 px-3">
                                                @include('partials.application-status-badge', ['application' => $application])
                                            </td>
                                            <td class="py-2 px-3">
                                                @php
                                                    $category = $application->GetCategory($application->worker_id);
                                                @endphp
                                                @if ($application)
                                                    <span class="badge badge-info">Renewal</span>
                                                @endif
                                            </td>
                                            <td class="py-2 px-3 text-center">
                                                @can('preview application')
                                                    @if ($application->status == 'G' || $application->application_status == 'D')
                                                        <span class="text-muted">N/A</span>
                                                    @elseif($application->status == 'F' || $application->application_status == 'F')
                                                        <a href="#"
                                                           class="btn btn-xs btn-outline-secondary view-logs-btn"
                                                           title="View Log"
                                                           data-toggle="modal"
                                                           data-target="#logModal"
                                                           data-worker-id="{{ encrypt($application->worker_id) }}">
                                                            <i class="fas fa-list-alt"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{route('office.applications.preview-applications', ['id' => encrypt($application->worker_id)]) }}"
                                                           class="btn btn-xs btn-outline-primary" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Data Found</h5>
                                    <p class="small text-secondary">
                                        There are no applications matching your criteria.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Pagination -->
                        @if($applications->total() > 0)
                            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top">
                                <div class="text-muted small">
                                    Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }} of {{ $applications->total() }} entries
                                </div>
                                <div>
                                    {{ $applications->onEachSide(1)->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Modal -->
    <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h5 class="modal-title" id="logModalLabel">Application Logs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0" id="logModalBody">
                    <div class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Loading logs...</p>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            // Filter dropdown items
            $('.dropdown-item[data-filter]').click(function(e) {
                e.preventDefault();
                const filterValue = $(this).data('filter');
                // Implement your filter logic here
                console.log('Filter by:', filterValue);
                // You would typically reload the table with the new filter
            });

            // Log modal
            $('#logModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var encryptedWorkerId = button.data('worker-id');
                var modalBody = $('#logModalBody');

                modalBody.html(`
                    <div class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Loading logs...</p>
                    </div>
                `);

                let url = "{{ route('office.applications-renewal.logs-api-renew', ['id' => ':id']) }}";
                url = url.replace(':id', encryptedWorkerId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let html = '';
                            if (response.logs && response.logs.length > 0) {
                                html = '<div class="table-responsive"><table class="table table-sm table-striped mb-0">';
                                html += '<thead class="thead-light"><tr><th class="py-2 px-3">Remarks</th><th class="py-2 px-3">Timestamp</th></tr></thead>';
                                html += '<tbody>';
                                $.each(response.logs, function(index, log) {
                                    html += `<tr>
                                        <td class="py-2 px-3">${log.remarks || 'N/A'}</td>
                                        <td class="py-2 px-3">${log.formatted_date}</td>
                                     </tr>`;
                                });
                                html += '</tbody></table></div>';
                            } else {
                                html = '<div class="alert alert-info m-3">No application logs found.</div>';
                            }
                            modalBody.html(html);
                        } else {
                            modalBody.html(`<div class="alert alert-danger m-3">${response.message}</div>`);
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr);
                        modalBody.html('<div class="alert alert-danger m-3">Failed to load logs. Please try again.</div>');
                    }
                });
            });
        });
    </script>

    <style>
        .card {
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .table {
            font-size: 0.85rem;
        }
        .table thead th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
        }
        .table td, .table th {
            vertical-align: middle;
            padding: 0.5rem 0.75rem;
        }
        .badge {
            font-size: 0.7rem;
            font-weight: 500;
            padding: 0.35em 0.5em;
        }
        .btn-xs {
            padding: 0.2rem 0.3rem;
            font-size: 0.7rem;
            line-height: 1.2;
        }
        .dropdown-item {
            font-size: 0.85rem;
        }
        .dropdown-header {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
        }
        .pagination {
            margin-bottom: 0;
        }
        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
@endsection