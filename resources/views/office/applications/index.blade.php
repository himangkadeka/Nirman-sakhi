@extends('layouts.admin-app')

@section('title', 'Office | Application | ' . ucfirst($status))
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', $status)
@section('style')
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
        #filterLoader {
            transition: all 0.3s ease;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.25em;
        }

        #applicationsTable, .pagination {
            transition: opacity 0.3s ease;
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
        table.thead-dark th{
            color: black !important;
        }
        /* Table base */
        #applicationsTable {
            border: 1px solid #d6d9dc;
            font-size: 13px;
            background-color: #fff;
        }

        /* Header (soft govt blue/grey) */
        #applicationsTable thead th {
            background: linear-gradient(to bottom, #eef3f8, #e3eaf2);
            color: #2c3e50;
            text-align: center;
            font-weight: 600;
            border: 1px solid #d6d9dc !important;
            padding: 8px;
            vertical-align: middle;
            font-size: 12.5px;
        }

        /* Body */
        #applicationsTable tbody td {
            border: 1px solid #e1e5ea !important;
            padding: 8px;
            vertical-align: middle;
            color: #2f2f2f;
        }

        /* Row hover (subtle) */
        #applicationsTable.table-hover tbody tr:hover {
            background-color: #f5f9fd;
        }

        /* Zebra striping (gov portals use this often) */
        #applicationsTable tbody tr:nth-child(even) {
            background-color: #fafbfd;
        }

        /* Badges (soft colors instead of black box) */
        #applicationsTable .badge {
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: 500;
        }

        /* Override specific badge colors */
        .badge-primary {
            background-color: #2e86de !important;
        }

        .badge-info {
            background-color: #17a2b8 !important;
        }

        /* Buttons (clean govt style) */
        #applicationsTable .btn {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 3px;
        }

        /* Primary button */
        #applicationsTable .btn-outline-primary {
            border: 1px solid #2e86de;
            color: #2e86de;
        }

        #applicationsTable .btn-outline-primary:hover {
            background-color: #2e86de;
            color: #fff;
        }

        /* Secondary (logs button) */
        #applicationsTable .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        #applicationsTable .btn-secondary:hover {
            background-color: #5a6268;
        }

        /* Icons */
        #applicationsTable .btn i {
            font-size: 12px;
        }

        /* Action column alignment */
        #applicationsTable td.text-center {
            white-space: nowrap;
        }

        /* Header uppercase subtle */
        #applicationsTable thead th {
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Pagination styling */
        .pagination .page-link {
            color: #2e86de;
            border: 1px solid #d6d9dc;
        }

        .pagination .active .page-link {
            background-color: #2e86de;
            border-color: #2e86de;
            color: #fff;
        }
        #applicationsTable {
            min-width: 1000px; /* adjust based on your columns */
            width: 100%;
            white-space: nowrap; /* keeps columns in one line */
        }

        /* Keep cells from wrapping */
        #applicationsTable th,
        #applicationsTable td {
            white-space: nowrap;
        }

        /* Optional: nicer scrollbar (modern browsers) */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c7cd;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- show Latest Application -->

        <div class="row">
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
                        {{--<div class="card border-0 shadow-sm">--}}
                            <div class="card-body py-3 px-3">
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                                    <!-- Filter Section -->
                                    <div class="flex-grow-1">
                                        <h6 class="mb-2 text-primary font-weight-bold small">
                                            <i class="fas fa-filter mr-1"></i>Filter Applications
                                        </h6>

                                        <div class="d-flex flex-wrap align-items-center gap-3">
                                            <!-- All Applications -->
                                            <div class="filter-option small">
                                                <input type="radio" name="registrationFilter" id="filterAll" value="all"
                                                       {{ $currentFilter === 'all' ? 'checked' : '' }} class="filter-option-input">
                                                <label for="filterAll" class="filter-option-label">
                                                    <span class="filter-option-check"></span>
                                                    <span class="filter-option-text">All</span>
                                                </label>
                                            </div>

                                            <!-- New Register -->
                                            <div class="filter-option small">
                                                <input type="radio" name="registrationFilter" id="filterNew" value="New Register"
                                                       {{ $currentFilter === 'New Register' ? 'checked' : '' }} class="filter-option-input">
                                                <label for="filterNew" class="filter-option-label">
                                                    <span class="filter-option-check"></span>
                                                    <span class="filter-option-text">New Register</span>
                                                </label>
                                            </div>

                                            <!-- On Boarding -->
                                            <div class="filter-option small">
                                                <input type="radio" name="registrationFilter" id="filterOnboarding" value="On Boarding"
                                                       {{ $currentFilter === 'On Boarding' ? 'checked' : '' }} class="filter-option-input">
                                                <label for="filterOnboarding" class="filter-option-label">
                                                    <span class="filter-option-check"></span>
                                                    <span class="filter-option-text">Onboarding</span>
                                                </label>
                                            </div>

                                            <!-- Re-Submitted -->
                                            {{--@if(isset($application) && ($application->application_status == 'G' || $application->status == 'G'))--}}
                                                {{--<div class="filter-option small">--}}
                                                    {{--<input type="radio" name="registrationFilter" id="filterResubmitted" value="Re-Submitted"--}}
                                                           {{--{{ $currentFilter === 'Re-Submitted' ? 'checked' : '' }} class="filter-option-input">--}}
                                                    {{--<label for="filterResubmitted" class="filter-option-label">--}}
                                                        {{--<span class="filter-option-check"></span>--}}
                                                        {{--<span class="filter-option-text">Re-Submitted</span>--}}
                                                    {{--</label>--}}
                                                {{--</div>--}}
                                            {{--@endif--}}
                                        </div>
                                    </div>

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
                {{--</div>--}}
            </div>
        </div>







        <!-- Applications Table -->
                        <div class="table-responsive mt-2">
                            @if($applications->total() > 0)
                                <table class="table table-hover table-bordered table-sm" id="applicationsTable">
                                <thead class="">
                                <tr>
                                    <th width="5%">Sl.no</th>
                                    <th width="15%">Application No</th>
                                    <th width="15%">Timestamp</th>
                                    <th width="15%">Status</th>
                                    <th width="20%">Category</th>
                                    <th width="20%">Location</th>
                                    <th width="20%">Remarks</th>
                                    <th width="10%" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($applications as $application)
                                    <tr>
                                        <td>{{ ($applications->currentPage() - 1) * $applications->perPage() + $loop->iteration }}</td>
                                        <td>{{ $application->ack_no }}</td>
                                        <td>
                                            @if (
                                                $application->application_status == 'D' ||$application->application_status == 'G' ||
                                                $application->application_status == 'C' ||$application->application_status == 'B' ||$application->status == 'O' )
                                                {{ \Carbon\Carbon::parse($application->updated_at)->format('d-m-Y') }}

                                                @elseif($application->application_status == 'F' || $application->status == 'F')
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

                                                {{-- Remove this line in production --}}
                                                {{-- {{ dd($statusRecord) }} --}}

                                                {{ $date }}
                                            @endif
                                        </td>

                                        <td>
                                            @include('partials.application-status', ['application' => $application])
                                        </td>
                                        <td>

                                            {{--@if ($application->status == 'F' || $application->application_status == 'F')--}}
                                                @if($application->already_registered == 1)
                                                    <span class="badge badge-info">Onboarding</span>
                                                @else
                                                    <span class="badge badge-primary">New Register</span>
                                                @endif
                                            {{--@endif--}}

                                            {{--{{$application}}--}}

                                        </td>
                                        <td>
                                            {{ trim(($application->getReceiver->firstname ?? '') . ' ' . ($application->getReceiver->lastname ?? '')) ?: 'NA' }}


                                        </td>
                                        <td class="text-center">
                                            @if ( ($application->status == 'G' || $application->application_status == 'G') ||  ($application->status == 'D' || $application->application_status == 'D'))
                                                {{$application->remarks}}
                                                @endif
                                        </td>
                                        <td class="text-center">
                                            @can('preview application')
                                                @if ( ($application->status == 'G' || $application->application_status == 'G') ||  ($application->status == 'D' || $application->application_status == 'D'))
                                                    <a href="#"
                                                       class="btn btn-secondary btn-sm view-logs-btn"
                                                       title="View Log"
                                                       data-toggle="modal"
                                                       data-target="#logModal"
                                                       data-worker-id="{{ encrypt($application->worker_id) }}">
                                                        <i class="fas fa-list-alt"></i> Logs
                                                    </a>
                                                    {{--<a href="{{ route('office.applications.preview', ['id' => encrypt($application->worker_id)]) }}"--}}
                                                       {{--class="btn btn-sm btn-outline-primary"--}}
                                                       {{--title="View">--}}
                                                        {{--<i class="fas fa-eye"></i>--}}
                                                    {{--</a>--}}
                                                @elseif($application->status == 'F' || $application->application_status == 'F')
                                                    <div class="d-flex align-items-center">
                                                        <a href="#"
                                                           class="btn btn-secondary btn-sm view-logs-btn mr-2"
                                                           title="View Log"
                                                           data-toggle="modal"
                                                           data-target="#logModal"
                                                           data-worker-id="{{ encrypt($application->worker_id) }}">
                                                            <i class="fas fa-list-alt"></i>
                                                        </a>

                                                        <a href="{{ route('office.applications.preview', ['id' => encrypt($application->worker_id)]) }}"
                                                           class="btn btn-sm btn-outline-primary"
                                                           title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>


                                                @else
                                                    <a href="{{route('office.applications.preview', ['id' => encrypt($application->worker_id)])}} "
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
                        @if($applications->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                                <div class="text-muted small">
                                    {{--Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }} of {{ $applications->total() }} entries--}}
                                </div>
                                <div>
                                    {{ $applications->onEachSide(1)->links() }}
                                </div>
                            </div>

                            {{--<!-- ✅ Add this small page info text -->--}}
                            {{--<div class="text-center page-info mt-2">--}}
                                {{--Page {{ $applications->currentPage() }} of {{ $applications->lastPage() }}--}}
                            {{--</div>--}}
                        @endif

                    </div>
                </div>
            </div>
        </div>
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

                let url = "{{ route('office.applications.logs-api', ['id' => ':id']) }}";
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
                                html += '<thead class="bg-primary"><tr><th>User</th><th>Status</th><th>Remarks</th><th>Timestamp</th></tr></thead>';
                                html += '<tbody>';
                                $.each(response.logs, function(index, log) {
                                    html += `<tr>
                                        <td>${log.application_from_user ?? 'Applicant'}</td>
                                        <td>${log.application_status}</td>
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

    <script>
        $(document).ready(function() {
            $('input[name="registrationFilter"]').change(function() {
                $('#filterLoader').show();
                $('#applicationsTable').hide();
                $('.pagination').hide();

                const filter = $(this).val();
                console.log(filter);
                const currentUrl = window.location.href.split('?')[0];
                window.location.href = currentUrl + '?filter=' + filter;
            });


            $(window).on('load', function() {
                $('#filterLoader').hide();
            });
        });
    </script>
@endsection



