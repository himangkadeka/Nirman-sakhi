@extends('layouts.admin-app')

@section('title', 'Admin | User Wise Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'User Wise Data')

@section('style')
    <style>
        .bg-info {
            color: white;
        }

        .b-dbcard {
            width: 150px;
        }

        #dateFilter {
            width: 200px;
        }

        .filterBtn {
            margin: 30px 0px 0px 20px;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <!-- Date Picker Filter -->
            <form method="GET" action="{{ route('admin.officewise.filter-user-data') }}">
                <input type="hidden" name="office_id" value="{{ $office_id }}">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="my-3">
                        <label for="fromDate">From Date:</label>
                        <input type="date" id="fromDate" name="fromDate" class="form-control" value="{{ $fromDate ?? '' }}">
                    </div>
                    <div class="ml-3 my-3">
                        <label for="toDate">To Date:</label>
                        <input type="date" id="toDate" name="toDate" class="form-control" value="{{ $toDate ?? '' }}">
                    </div>
                    <div class="filterBtn">
                        <button id="filterBtn" type="submit" class="btn btn-primary">Filter</button>
                    </div>
                    <div class="filterBtn">
                        <a href="{{ route('admin.officewise.user-data', $office_id) }}" class="btn btn-success">All Data</a>
                    </div>
                </div>
            </form>

            <div class="col-md-12 table-responsive">
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>User Name</th>
                            <th>Full Name</th>
                            <th>Office Name</th>
                            <th>Role</th>
                            <th>Total Count</th>
                            <th>New Registration</th>
                            <th>Onboarding Applications</th>
                            <th>Pending Applications </th>
                            <th>Approved New Applications</th>
                            <th>Approved Onboarding Applications</th>
                        </tr>
                    </thead>
                    <tbody id="tableData">
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                <td>{{ $user->office->office_name }}</td>
                                <td>
                                    @if ($user->role_id == 2)
                                        <span class="badge badge-primary">{{ $user->role->name }}</span>
                                    @elseif ($user->role_id == 3)
                                        <span class="badge badge-warning">{{ $user->role->name }}</span>
                                    @else
                                        <span class="badge badge-info">{{ $user->role->name }}</span>
                                    @endif
                                </td>
                                <td>{{ isset($fromDate) ? $user->total_count : $user->getCount($office_id, $user->id, $user->role_id) }}</td>
                                <td>{{ isset($fromDate) ? $user->new_registrations : $user->newUserRegistrationsCount($office_id, $user->id, $user->role_id) }}</td>
                                <td>{{ isset($fromDate) ? $user->onboarding : $user->alreadyUserRegisteredCount($office_id, $user->id, $user->role_id) }}</td>
                                <td>{{ isset($fromDate) ? $user->pending : $user->pendingUserApplicationCount($office_id, $user->id, $user->role_id) }}</td>
                                <td>{{ isset($fromDate) ? $user->new_approved : $user->newApprovedUserApplicationCount($office_id, $user->id, $user->role_id) }}</td>
                                <td>{{ isset($fromDate) ? $user->on_approved : $user->OnApprovedUserApplicationCount($office_id, $user->id, $user->role_id) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateFilter = document.getElementById("dateFilter");
            const tableRows = document.querySelectorAll("#tableData tr");

            dateFilter.addEventListener("change", function() {
                let selectedDate = this.value;

                tableRows.forEach(row => {
                    let rowDate = row.cells[row.cells.length - 1].textContent
                .trim(); // Last column (Date)

                    if (!selectedDate || rowDate.includes(selectedDate)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>
@endsection
