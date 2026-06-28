@extends('layouts.admin-app')

@section('title', 'Admin | District Wise Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'District Wise Data')
@section('style')
    <style>
        .bg-info {
            color: white;
        }

        .b-dbcard {
            width: 250px;
        }






    </style>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            {{--<div class="text-center py-4" id="sortable-cards" style="width: 10%;">--}}
                {{--<div class="b-customize ">--}}
                    {{--<div class=" p-2 b-dbcard" style="background-color: #3dc6cb;">--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="col-md-12 table-responsive">

                 {{--<form method="GET" action="{{ route('admin.districtwise.index') }}" class="mb-3">--}}
                    {{--<div class="input-group my-3">--}}
                        {{--<div class="col-8"><a href="{{ route('admin.districtwise.export', 'csv') }}"--}}
                                {{--class="btn btn-secondary btn-sm"> CSV</a>--}}

                            {{--<a href="{{ route('admin.districtwise.export', 'xlsx') }}" class="btn btn-secondary btn-sm">--}}
                                {{--Excel</a>--}}
                            {{--<a href="{{ route('admin.districtwise.export', 'pdf') }}" class="btn btn-secondary btn-sm"> PDF</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-3">--}}
                            {{--<input type="text" name="search" class="form-control" placeholder="Search by Worker ID"--}}
                                {{--value="{{ request('search') }}" style="max-width:90%;">--}}
                        {{--</div>--}}
                        {{--<div class="col">--}}
                            {{--<button class="btn btn-primary" type="submit">Search</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</form>--}}


                <table id="abaocTable" class="table table-bordered table-striped text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>District Name</th>
                            <th>Total New Register</th>
                            <th>Total Onboarding</th>
                            <th>Total Count</th>
                            <th>Total Approved</th>
                            <th>Total Pending</th>
                            <th>Total Reverted</th>
                            <th>Total Resubmitted</th>
                            <th>Total Rejected</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($districts as $district)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $district->district_name }}</td>
                                <td>{{ $district->new_count }}</td>
                                <td>{{ $district->onboarding_count }}</td>
                                <td>{{ $district->total_count }}</td>
                                <td>{{ $district->approved_count }}</td>
                                <td>{{ $district->pending_count }}</td>
                                <td>{{ $district->reverted_count }}</td>
                                <td>{{ $district->resubmitted_count }}</td>
                                <td>{{ $district->rejected_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
