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
            {{--<form method="GET" action="{{ route('office.mis-data.filter-office-data') }}">--}}
                {{--<div class="d-flex align-items-center justify-content-center">--}}
                    {{--<div class="my-3">--}}
                        {{--<label for="fromDate">From Date:</label>--}}
                        {{--<input type="date" id="fromDate" name="fromDate" class="form-control">--}}
                    {{--</div>--}}
                    {{--<div class="ml-3 my-3">--}}
                        {{--<label for="toDate">To Date:</label>--}}
                        {{--<input type="date" id="toDate" name="toDate" class="form-control">--}}
                    {{--</div>--}}
                    {{--<div class="filterBtn">--}}
                        {{--<button id="filterBtn" type="submit" class="btn btn-primary">Filter</button>--}}
                    {{--</div>--}}
                    {{--<div class="filterBtn">--}}
                        {{--<a href="{{ route('office.mis-data.mis-report','all') }}" class="btn btn-success">All Data</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
            <form method="POST" action="{{ route('office.mis-data.mis-report', ['application_type' => $application_type]) }}">
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
                        <a href="{{ route('office.mis-data.mis-report', ['application_type' => $application_type]) }}"
                           class="btn btn-success btn-sm ms-2">All Data</a>
                    </div>
                </div>
            </form>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="abaocTable" class="table table-sm table-bordered table-hover align-middle text-center nowrap">
                        <thead class="table-dark">
                        <tr>
                            <th>Total</th>
                            <th>Pending</th>
                            <th>Approved</th>
                            <th>Rejected</th>
                            <th>Reverted</th>
                            <th>Re-Submitted</th>
                            <th style="width: 90px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $office->total_count }}</td>
                            <td>{{ $office->pending }}</td>
                            <td>{{ $office->approved }}</td>
                            <td>{{ $office->rejected }}</td>
                            <td>{{ $office->reverted }}</td>
                            <td>{{ $office->revert_resubmitted }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm px-2" onclick="filterDataByUser('{{ $office->office_id }}','{{ $application_type }}')"
                                        data-toggle="modal"
                                        data-target="#userModal">View
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('footer')
@endsection
