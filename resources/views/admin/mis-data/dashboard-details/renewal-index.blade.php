@extends('layouts.admin-app')

@section('title', 'Admin | Office Wise Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Office Wise Data')

@section('style')
    <style>
        /* Compact Table Styling */
        table.table {
            font-size: 0.85rem;
        }

        table.table th,
        table.table td {
            padding: 6px 10px !important;
            vertical-align: middle !important;
        }

        /* Compact Buttons */
        .btn-sm {
            padding: 3px 8px !important;
            font-size: 0.8rem;
        }

        /* Modal Scroll and Compact Body */
        .modal-body {
            padding: 10px;
        }

        /* Filters */
        #dateFilter {
            width: 200px;
        }

        .filterBtn {
            margin: 30px 0px 0px 20px;
        }

        .thead-dark th {
            background-color: #343a40;
            color: #fff;
            text-align: center;
        }

        .thead-light th {
            background-color: #f8f9fa;
            text-align: center;
        }

        td, th {
            text-align: center;
            white-space: nowrap;
        }

        /* Reduce modal header size */
        .modal-header {
            padding: 8px 12px;
        }

        .modal-title {
            font-size: 1rem;
        }

        .close {
            font-size: 1.2rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Date Picker Filter -->
            <form method="POST" action="{{ route('admin.dashboard-data.index', ['application_type' => $application_type]) }}">
                @csrf
                <div class="d-flex align-items-end justify-content-center gap-3 flex-wrap">
                    <div class="my-3">
                        <label for="fromDate">From Date:</label>
                        <input type="date" id="fromDate" name="fromDate" class="form-control form-control-sm"
                               value="{{ request('fromDate') }}">
                    </div>
                    <div class="my-3">
                        <label for="toDate">To Date:</label>
                        <input type="date" id="toDate" name="toDate" class="form-control form-control-sm"
                               value="{{ request('toDate') }}">
                    </div>
                    <div class="my-3">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="{{ route('admin.dashboard-data.index', ['application_type' => $application_type]) }}"
                           class="btn btn-success btn-sm ms-2">All Data</a>
                    </div>
                </div>
            </form>

            <div class="col-md-12 table-responsive">
                <table id="abaocTable" class="table table-bordered table-striped text-nowrap display nowrap">
                    <thead class="thead-dark">
                    <tr>
                        <th>Sno.</th>
                        <th>Office Name</th>
                        <th>Total Apps</th>
                        <th>Pending</th>
                        <th>Approved</th>
                        {{--<th>Rejected</th>--}}
                        <th>Reverted</th>
                        <th>Re-Submitted</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="tableData">
                    @foreach ($offices as $office)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.officewise.user-data', $office->office_id) }}">
                                    {{ $office->office_name }}
                                </a>
                            </td>
                            <td>{{ $office->total_count }}</td>
                            <td>{{ $office->pending }}</td>
                            <td>{{ $office->approved }}</td>
                            {{--<td>{{ $office->rejected }}</td>--}}
                            <td>{{ $office->reverted }}</td>
                            <td>{{ $office->revert_resubmitted }}</td>
                            <td>
                                <button class="btn btn-info btn-sm"
                                        onclick="filterDataByUser('{{ $office->office_id }}','{{ $application_type }}')"
                                        data-toggle="modal" data-target="#userModal">
                                    View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- User Modal -->
                <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="userModalLabel">User Wise Data</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Sno.</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Total</th>
                                        <th>Pending</th>
                                        <th>Approved</th>
                                        <th>Rejected</th>
                                        <th>Reverted</th>
                                        <th>Re-Submitted</th>
                                    </tr>
                                    </thead>
                                    <tbody id="userTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function filterDataByUser(officeId, application_type) {
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;

            $.ajax({
                url: "{{ route('admin.dashboard-data-renewal.user-wise-data-renewal') }}",
                method: 'POST',
                data: {
                    fromDate: fromDate,
                    toDate: toDate,
                    office_id: officeId,
                    application_type: application_type,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    const users = response.data || response;
                    const tbody = $('#userTableBody');
                    tbody.html('');

                    if (users.length === 0) {
                        tbody.append('<tr><td colspan="9" class="text-center">No user data available.</td></tr>');
                    } else {
                        $.each(users, function(index, user) {
                            const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${user.firstname} ${user.lastname}</td>
                            <td>${user.role_id || '-'}</td>
                            <td>${user.total_count}</td>
                            <td>${user.pendingApplicationCount}</td>
                            <td>${user.approvedApplicationCount}</td>
                            <td>${user.rejectedApplicationCount}</td>
                            <td>${user.revertedApplicationCount}</td>
                            <td>${user.revert_resubmitted}</td>
                        </tr>`;
                            tbody.append(row);
                        });
                    }

                    $('#userModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching user data:", error);
                }
            });
        }
    </script>
@endsection

@section('footer')
@endsection
