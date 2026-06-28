@extends('layouts.admin-app')

@section('title', 'Admin | Worker Registration Status')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Worker Registration Status')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <form method="GET" action="{{ route('admin.workerdata.index') }}" class="mb-3">
                    <div class="input-group my-3">
                        <div class="col-8">
                            <a href="{{ route('admin.workerdata.export', 'csv') }}" class="btn btn-secondary btn-sm">
                                CSV</a>

                            <a href="{{ route('admin.workerdata.export', 'xlsx') }}" class="btn btn-secondary btn-sm">
                                Excel</a>
                            <a href="{{ route('admin.workerdata.export', 'pdf') }}" class="btn btn-secondary btn-sm">
                                PDF</a>
                        </div>
                        <div class="col-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by Worker ID"
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
                            <th>Acknowledgement Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workerdata as $worker)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $worker->ack_no }}</td>
                                <td>
                                    @if ($worker->status === 'A')
                                        Application Submitted
                                    @elseif($worker->status == 'B')
                                        Forwarded By DA
                                    @elseif(($worker->status == 'B') & ($worker->da_forward == 1))
                                        Sent By DA
                                    @elseif($worker->status == 'B' && $worker->pull_back == 1)
                                        Pulled Back
                                    @elseif($worker->status == 'C')
                                        Forwarded By RO
                                    @elseif($worker->status == 'D')
                                        Application Rejected
                                    @elseif($worker->status == 'E')
                                        Pulled Back from DA
                                    @elseif($worker->status == 'F')
                                        Application Approved
                                    @elseif($worker->status == 'G')
                                        Application Reverted
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $workerdata->links() }}
    </div>

@endsection
