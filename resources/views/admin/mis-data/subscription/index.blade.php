@extends('layouts.admin-app')

@section('title', 'Admin | Subscription Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Subscription Data')

@section('style')
    <style>
        * { box-sizing: border-box; }

        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .breadcrumb-sub { font-size: 11px; font-weight: 500; color: #6c757d; letter-spacing: 0.04em; text-transform: uppercase; }
        .page-title     { font-size: 13px; font-weight: 500; color: #212529; margin-top: 1px; }
        .record-count   { font-size: 10px; color: #6c757d; }

        /* Toolbar */
        .toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin-bottom: 10px; }
        .search-group { display: flex; gap: 4px; align-items: center; }
        .search-group input.form-control {
            font-size: 11px; padding: 4px 8px; height: auto;
            border-radius: 3px; border: 0.5px solid #ced4da; width: 300px;
        }
        .btn-search {
            font-size: 11px; padding: 4px 10px;
            border: 0.5px solid #B5D4F4; border-radius: 3px;
            background: #E6F1FB; color: #185FA5;
        }
        .btn-search:hover { background: #B5D4F4; }
        .btn-reset {
            font-size: 11px; padding: 4px 10px;
            border: 0.5px solid #ced4da; border-radius: 3px;
            background: #f8f9fa; color: #495057; text-decoration: none; display: inline-block;
        }
        .btn-reset:hover { background: #e9ecef; color: #212529; text-decoration: none; }

        /* Table */
        .tbl-outer { border: 0.5px solid #dee2e6; border-radius: 4px; overflow: hidden; overflow-x: auto; }
        .tbl-gov { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 0; }
        .tbl-gov thead tr { background: #f1f3f5; border-bottom: 1px solid #ced4da; }
        .tbl-gov thead th {
            padding: 6px 8px; font-size: 10.5px; font-weight: 500; color: #6c757d;
            white-space: nowrap; border-right: 0.5px solid #e9ecef;
            letter-spacing: 0.02em; text-transform: uppercase; vertical-align: middle;
        }
        .tbl-gov thead th:last-child { border-right: none; }
        .tbl-gov tbody tr { border-bottom: 0.5px solid #e9ecef; }
        .tbl-gov tbody tr:last-child { border-bottom: none; }
        .tbl-gov tbody tr:hover { background: #f8f9fa; }
        .tbl-gov tbody td {
            padding: 5px 8px; font-size: 11px; color: #212529;
            white-space: nowrap; border-right: 0.5px solid #e9ecef; vertical-align: middle;
        }
        .tbl-gov tbody td:last-child { border-right: none; }
        .tbl-gov .sno    { color: #6c757d; }
        .tbl-gov .wid    { font-weight: 500; }
        .tbl-gov .amount { font-variant-numeric: tabular-nums; }
        .tbl-gov .empty-row td { text-align: center; color: #6c757d; padding: 20px 8px; font-size: 11px; }

        /* Badges */
        .badge-gov { display: inline-block; font-size: 10px; padding: 1px 6px; border-radius: 2px; font-weight: 500; border: 0.5px solid transparent; }
        .b-success { background: #E1F5EE; color: #0F6E56; border-color: #9FE1CB; }
        .b-danger  { background: #FCEBEB; color: #A32D2D; border-color: #F7C1C1; }
        .b-warning { background: #FAEEDA; color: #854F0B; border-color: #FAC775; }
        .b-info    { background: #E6F1FB; color: #185FA5; border-color: #B5D4F4; }

        /* Action buttons */
        .btn-act {
            font-size: 10px; padding: 2px 7px; border: 0.5px solid #ced4da;
            border-radius: 2px; background: #f8f9fa; color: #495057;
            cursor: pointer; display: inline-block; margin-right: 2px;
            line-height: 1.5; text-decoration: none;
        }
        .btn-act:hover { background: #e9ecef; text-decoration: none; }
        .btn-act-amber { border-color: #FAC775; background: #FAEEDA; color: #854F0B; }
        .btn-act-amber:hover { background: #FAC775; }
        .btn-act-red   { border-color: #F7C1C1; background: #FCEBEB; color: #A32D2D; }
        .btn-act-red:hover { background: #F7C1C1; }

        /* Pagination */
        .pagination-row { display: flex; align-items: center; justify-content: space-between; margin-top: 8px; }
        .pg-info { font-size: 10.5px; color: #6c757d; }
        .pagination > li > a,
        .pagination > li > span {
            font-size: 11px; padding: 3px 8px; border: 0.5px solid #dee2e6;
            border-radius: 3px !important; color: #495057;
            background: #fff; margin: 0 1px; line-height: 1.5;
        }
        .pagination > li.active > a,
        .pagination > li.active > span {
            background: #E6F1FB; color: #185FA5; border-color: #B5D4F4; font-weight: 500;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="page-header">
            <div>
                <div class="breadcrumb-sub">MIS Data</div>
                <div class="page-title">Subscription Data</div>
            </div>
            <div class="record-count">
                Showing {{ $data->firstItem() }}–{{ $data->lastItem() }} of {{ $data->total() }} records
            </div>
        </div>

        {{-- Toolbar --}}
        <form method="GET" action="{{ route('admin.get-subscription') }}">
            <div class="toolbar">
                <div class="search-group">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search by Application No or ID Card No">
                    <button class="btn-search" type="submit">Search</button>
                    <a href="{{ route('admin.get-subscription') }}" class="btn-reset">Reset</a>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="tbl-outer">
            <table class="tbl-gov">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Worker ID</th>
                    <th>ID Card No.</th>
                    <th>Transaction ID</th>
                    <th>Total Amount</th>
                    <th>From Period</th>
                    <th>To Period</th>
                    <th>Pay. Status</th>
                    <th>Amount Paid</th>
                    <th>Fine</th>
                    <th>Delayed Months</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $worker)
                    <tr>
                        <td class="sno">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                        <td class="wid">{{ $worker->worker_id }}</td>
                        <td>{{ $worker->id_card_no }}</td>
                        <td>{{ $worker->transaction_id }}</td>
                        <td class="amount">{{ $worker->total_amount }}</td>
                        <td>{{ $worker->from_period }}</td>
                        <td>{{ $worker->to_period }}</td>
                        <td>
                            @php $ps = strtolower($worker->payment_status ?? ''); @endphp
                            <span class="badge-gov
                            {{ $ps === 'paid' || $ps === 'success'  ? 'b-success' :
                              ($ps === 'failed' || $ps === 'unpaid' ? 'b-danger'  :
                              ($ps === 'pending'                    ? 'b-info'    : 'b-warning')) }}">
                            {{ ucfirst($worker->payment_status ?? '—') }}
                        </span>
                        </td>
                        <td class="amount">{{ $worker->amount_paid }}</td>
                        <td class="amount">{{ $worker->fine ?? '—' }}</td>
                        <td>{{ $worker->no_of_delayed_months ?? '—' }}</td>
                        <td>{{ $worker->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.subscription.edit', $worker->id) }}"
                               class="btn-act btn-act-amber">Edit</a>

                            <form action="{{ route('admin.subscription.destroy', $worker->id) }}"
                                  method="POST" style="display:inline-block;"
                                  onsubmit="return confirm('Delete this subscription record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-act btn-act-red">
                                    <i class="fa fa-trash" style="font-size:10px"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="13">No records found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-row">
            <div class="pg-info">Page {{ $data->currentPage() }} of {{ $data->lastPage() }}</div>
            {{ $data->appends(['search' => request('search')])->links() }}
        </div>

    </div>
@endsection