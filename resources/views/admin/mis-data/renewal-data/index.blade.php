@extends('layouts.admin-app')

@section('title', 'Admin | Renewal Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Renewal Data')

@section('content')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-5">
                <form method="GET" action="{{ route('admin.renewaldata.index') }}">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                               placeholder="Search by App No or ID Card">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm" type="submit">Search</button>
                            <a href="{{ route('admin.renewaldata.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-sm table-hover mb-1" style="font-size: 0.82rem;">
                    <thead class="thead-dark">
                    <tr>
                        <th class="py-1 px-2" style="width: 40px;">#</th>
                        <th class="py-1 px-2">Temp App No</th>
                        <th class="py-1 px-2">Ack No</th>
                        <th class="py-1 px-2">ID Card</th>
                        <th class="py-1 px-2">Status</th>
                        <th class="py-1 px-2">Office</th>
                        <th class="py-1 px-2">Date</th>
                        <th class="py-1 px-2">Action</th>


                    </tr>
                    </thead>
                    <tbody>
                    @forelse($workerdata as $worker)
                        <tr>
                            <td class="py-1 px-2">{{ $loop->iteration + ($workerdata->currentPage() - 1) * $workerdata->perPage() }}</td>
                            <td class="py-1 px-2 text-nowrap">{{ $worker->worker_id }}</td>
                            <td class="py-1 px-2 text-nowrap">{{ $worker->ack_no }}</td>
                            <td class="py-1 px-2 text-nowrap">{{ $worker->id_card }}</td>
                            <td class="py-1 px-2">
                                @switch($worker->status)
                                @case('A') <span class="badge badge-light border">Submitted</span> @break
                                @case('B')
                                @if($worker->da_forward == 1)
                                    <span class="badge badge-info">HRO</span>
                                @elseif($worker->pull_back == 1)
                                    <span class="badge badge-warning">Pulled Back</span>
                                @else
                                    <span class="badge badge-primary">Fwd by DA</span>
                                @endif
                                @break
                                @case('C') <span class="badge badge-primary">DA</span> @break
                                @case('D') <span class="badge badge-danger">Rejected</span> @break
                                @case('E') <span class="badge badge-warning">Pulled from DA</span> @break
                                @case('F') <span class="badge badge-success">Approved</span> @break
                                @case('G') <span class="badge badge-secondary">Reverted</span> @break
                                @endswitch
                            </td>
                            <td class="py-1 px-2">{{ $worker->officeName->office_name ?? '-' }}</td>
                            <td class="py-1 px-2">{{ $worker->created_at->format('d-m-Y') }}</td>
                            <td><a href="{{ route('admin.renewaldata.open-renewal-app', ['id' => encrypt($worker->worker_id)]) }}"
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-2">No records found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-end mt-2">
                    {{ $workerdata->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection