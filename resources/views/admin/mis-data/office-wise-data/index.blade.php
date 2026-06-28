@extends('layouts.admin-app')

@section('title', 'Admin | Office Wise Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Office Wise Data')

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
            <form method="GET" action="{{ route('admin.officewise.filter-data') }}">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="my-3">
                        <label for="fromDate">From Date:</label>
                        <input type="date" id="fromDate" name="fromDate" class="form-control"
                            value="{{ request('fromDate') }}">
                    </div>
                    <div class="ml-3 my-3">
                        <label for="toDate">To Date:</label>
                        <input type="date" id="toDate" name="toDate" class="form-control"
                            value="{{ request('toDate') }}">
                    </div>
                    <div class="filterBtn">
                        <button id="filterBtn" type="submit" class="btn btn-primary">Filter</button>
                    </div>
                    <div class="filterBtn">
                        <a href="{{ route('admin.officewise.index') }}" class="btn btn-success">All Data</a>
                    </div>
                </div>
            </form>

            <div class="col-md-12 table-responsive">

                <form method="GET" action="{{ route('admin.officewise.filter-data') }}" class="mb-3">
                    <input type="hidden" name="fromDate" value="{{ request('fromDate') }}">
                    <input type="hidden" name="toDate" value="{{ request('toDate') }}">

                    <div class="input-group my-3">
                        {{-- <div class="col-8">
                            <a href="{{ route('admin.officewise.export', 'csv') }}"
                                class="btn btn-secondary btn-sm"> CSV</a>

                            <a href="{{ route('admin.officewise.export', 'xlsx') }}" class="btn btn-secondary btn-sm">
                                Excel</a>
                            <a href="{{ route('admin.officewise.export', 'pdf') }}" class="btn btn-secondary btn-sm">
                                PDF</a>
                        </div> --}}
                        <div class="col-8">
                            <a href="{{ route('admin.officewise.export', ['type' => 'csv', 'fromDate' => request('fromDate'), 'toDate' => request('toDate'), 'search' => request('search')]) }}"
                                class="btn btn-secondary btn-sm"> CSV</a>

                            <a href="{{ route('admin.officewise.export', ['type' => 'xlsx', 'fromDate' => request('fromDate'), 'toDate' => request('toDate'), 'search' => request('search')]) }}"
                                class="btn btn-secondary btn-sm"> Excel</a>

                            <a href="{{ route('admin.officewise.export', ['type' => 'pdf', 'fromDate' => request('fromDate'), 'toDate' => request('toDate'), 'search' => request('search')]) }}"
                                class="btn btn-secondary btn-sm"> PDF</a>
                        </div>

                        <div class="col-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by Office"
                                value="{{ request('search') }}" style="max-width:90%;">
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>

                </form>


                <table id="" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Office Name</th>
                            <th>Total No. of Applications</th>
                            <th>New Registration</th>
                            <th>Onboarding Applications</th>
                            <th>Pending Applications</th>
                            <th>New Registered Approved Applications</th>
                            <th>Onboarding Approved Applications</th>
                            <th>Total Approved</th>
                            <th>Rejected Applications</th>
                            <th>Reverted Applications</th>
                        </tr>
                    </thead>
                    <tbody id="tableData">
                        @foreach ($offices as $office)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a
                                        href="{{ route('admin.officewise.user-data', $office->office_id) }}">{{ $office->office_name }}</a>
                                </td>
                                <td>{{ isset($fromDate) ? $office->total_count : $office->getCount($office->office_id) }}
                                </td>
                                <td>{{ isset($fromDate) ? $office->new_registrations : $office->newRegistrationsCount($office->office_id) }}
                                </td>
                                <td>{{ isset($fromDate) ? $office->onboarding : $office->alreadyRegisteredCount($office->office_id) }}
                                </td>
                                <td>{{ isset($fromDate) ? $office->pending : $office->pendingApplicationCount($office->office_id) }}
                                </td>
                                <td>{{ isset($fromDate) ? $office->new_approved : $office->newApprovedApplicationCount($office->office_id) }}
                                </td>
                                <td>{{ isset($fromDate) ? $office->on_approved : $office->OnApprovedApplicationCount($office->office_id) }}
                                </td>
                                <td>{{ isset($fromDate) ? $office->new_approved + $office->on_approved : $office->approvedApplicationCount($office->office_id) }}
                                </td>
                                <td>{{ isset($fromDate) ? $office->rejected : $office->rejectedApplicationCount($office->office_id) }}
                                </td>
                                <td>{{ isset($fromDate) ? $office->reverted : $office->revertedApplicationCount($office->office_id) }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $offices->links() }}

    </div>

@endsection

@section('footer')
@endsection
