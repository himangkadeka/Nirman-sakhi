@extends('layouts.admin-app')

@section('title', 'Office | Application | ' . ucfirst($status))
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', $status)



@section('content')
    <div class="container-fluid">
        <!-- show Latest Application -->

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0 py-1">
                    </div>

                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="row mb-0">
                            <div class="col-12">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-white border-bottom-0 py-1"></div>
                                    <div class="card-body py-2 px-3">

                                        <!-- Loader Section -->
                                        <div id="filterLoader" class="text-center py-3" style="display: none;">
                                            <div class="spinner-border text-primary spinner-border-sm" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <p class="mt-1 mb-0 small text-muted">Filtering applications...</p>
                                        </div>

                                        <!-- Filter + Search in same card -->
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body py-3 px-3">
                                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                                                    <!-- Filter Section -->

                                                    <!-- Search Section -->
                                                    <div class="flex-shrink-0" style="min-width: 280px;">
                                                        <h6 class="mb-2 text-primary font-weight-bold small">
                                                            <i class="fas fa-search mr-1"></i>Search Application
                                                        </h6>
                                                        <form method="GET" id="ackSearchForm" class="d-flex align-items-center">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" name="ack_no" class="form-control"
                                                                       placeholder="Enter Application No"
                                                                       value="{{ $searchAck ?? '' }}" required>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-primary btn-sm" type="submit">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </div>
                                                                @if(!empty(request('ack_no')))
                                                                    <div class="input-group-append">
                                                                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm">
                                                                            <i class="fas fa-times"></i>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div> <!-- End flex container -->
                                            </div>
                                        </div> <!-- End card -->
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>



                        <style>
                            .filter-option {
                                position: relative;
                                margin-bottom: 0;
                            }

                            .filter-option-input {
                                position: absolute;
                                opacity: 0;
                            }

                            .filter-option-label {
                                display: flex;
                                align-items: center;
                                cursor: pointer;
                                padding: 0.5rem 1rem;
                                border-radius: 50px;
                                transition: all 0.3s ease;
                                background-color: #f8f9fa;
                                border: 1px solid #dee2e6;
                            }

                            .filter-option-input:checked + .filter-option-label {
                                background-color: #e9f7fe;
                                border-color: #007bff;
                            }

                            .filter-option-input:focus + .filter-option-label {
                                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                            }

                            .filter-option-check {
                                display: inline-block;
                                width: 18px;
                                height: 18px;
                                border: 2px solid #adb5bd;
                                border-radius: 50%;
                                margin-right: 0.75rem;
                                position: relative;
                                transition: all 0.3s ease;
                            }

                            .filter-option-input:checked + .filter-option-label .filter-option-check {
                                border-color: #007bff;
                                background-color: #007bff;
                            }

                            .filter-option-input:checked + .filter-option-label .filter-option-check::after {
                                content: '';
                                position: absolute;
                                top: 50%;
                                left: 50%;
                                transform: translate(-50%, -50%);
                                width: 8px;
                                height: 8px;
                                background-color: white;
                                border-radius: 50%;
                            }

                            .filter-option-text {
                                font-weight: 500;
                                color: #495057;
                            }

                            .filter-option-input:checked + .filter-option-label .filter-option-text {
                                color: #007bff;
                            }

                            @media (max-width: 768px) {
                                .filter-option {
                                    width: 100%;
                                    margin-bottom: 0.5rem;
                                }

                                .filter-option-label {
                                    justify-content: center;
                                }
                            }
                        </style>

                        <!-- Applications Table -->
                        <div class="table-responsive">
                            @if($applications->total() > 0)
                            <table class="table table-hover table-bordered" id="applicationsTable">
                                <thead class="thead-light">
                                <tr>
                                    <th width="5%">Sl.no</th>
                                    <th width="15%">Application No</th>
                                    <th width="15%">Submitted On</th>
                                    <th width="15%">Status</th>
                                    <th width="10%">Category</th>
                                    <th width="5%" class="text-center">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($applications as $application)
                                    <tr>
                                        <td>{{ ($applications->currentPage() - 1) * $applications->perPage() + $loop->iteration }}</td>
                                        <td>{{ $application->ack_no }}</td>
                                        <td>
                                            @if (
                                                $application->application_status == 'D' ||
                                                $application->application_status == 'G' ||
                                                $application->application_status == 'C' ||
                                                $application->application_status == 'F' ||
                                                $application->application_status == 'B' ||
                                                $application->application_status == 'O' ||
                                                ($application->status == 'A'))
                                                {{ \Carbon\Carbon::parse($application->created_at)->format('d-m-Y') }}
                                            @else
                                                @php
                                                    $statusRecord = $application->getApplicationStatus($application->worker_id, $application->status);
                                                    if (optional($statusRecord)->created_at) {
                                                        $date = \Carbon\Carbon::parse($statusRecord->created_at)->format('d-m-Y');
                                                    } else {
                                                        $date = \Carbon\Carbon::parse($application->created_at)->format('d-m-Y');
                                                    }
                                                @endphp
                                                {{ $date }}
                                            @endif

                                        </td>

                                        <td>
                                            @include('partials.application-status-badge', ['application' => $application])
                                        </td>
                                        <td>
                                            @php
                                                $category = $application->GetCategory($application->worker_id);
                                            @endphp


                                            @if ($application)
                                                <span class="badge badge-info">Renewal</span>

                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @can('preview application')
                                                @if ($application->application_status == 'D')
                                                    <span class="text-muted">N/A</span>
                                                @elseif($application->status == 'F' || $application->application_status == 'F')
                                                    <a href="#"
                                                       class="btn btn-secondary btn-sm view-logs-btn"
                                                       title="View Log"
                                                       data-toggle="modal"
                                                       data-target="#logModal"
                                                       data-worker-id="{{ encrypt($application->worker_id) }}">
                                                        <i class="fas fa-list-alt"></i> Logs
                                                    </a>
                                                @else
                                                    <a href="{{route('office.applications.preview-applications', ['id' => encrypt($application->worker_id)]) }}"
                                                       class="btn btn-sm btn-outline-primary" title="View">
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
                                <div class="card shadow-sm border-0 text-center py-4 my-3">
                                    <div class="card-body">
                                        <i class="fas fa-folder-open fa-3x text-muted"></i>
                                        <h5 class="text-muted mb-1">No Data Found</h5>
                                        <p class="small text-secondary mb-0">
                                            There’s nothing to show here right now.
                                        </p>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <!-- Pagination -->
                    @if($applications->total() > 0)
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }} of {{ $applications->total() }} entries
                            </div>
                            <div>
                                {{ $applications->onEachSide(1)->links() }}
                            </div>
                        </div>
                    @endif


                </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #f8f9fa !important;
        }
        .table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .form-check-input {
            margin-top: 0.15rem;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>
    </div>

    <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logModalLabel">Application Logs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="logModalBody">
                    {{-- Log content will be loaded here by JavaScript --}}
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ URL::asset('assets/template/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('#logModal').on('show.bs.modal', function (event) {


                var button = $(event.relatedTarget);


                var encryptedWorkerId = button.data('worker-id');


                var modalBody = $('#logModalBody');

                var loadingHtml = '<div class="text-center p-4"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div><p class="mt-2">Fetching logs...</p></div>';
                modalBody.html(loadingHtml);

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
                                html = '<table class="table  table-sm">';
                                html += '<thead><tr style="background-color: black;"><th>Remarks</th><th>Timestamp</th></tr></thead>';
                                html += '<tbody>';
                                $.each(response.logs, function(index, log) {
                                    html += `<tr>
                                        <!--<td>${log.application_status}</td>-->
                                        <td>${log.remarks || 'N/A'}</td>
                                        <td>${log.formatted_date}</td>
                                     </tr>`;
                                });
                                html += '</tbody></table>';
                            } else {
                                html = '<div class="alert alert-info">No application logs found.</div>';
                            }
                            modalBody.html(html);
                        } else {
                            modalBody.html(`<div class="alert alert-danger">${response.message}</div>`);
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr);
                        modalBody.html('<div class="alert alert-danger"><strong>Error!</strong> Failed to load logs. Please check the console and try again.</div>');
                    }
                });
            });
        });
    </script>
@endsection
