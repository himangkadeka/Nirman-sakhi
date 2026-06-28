@extends('layouts.admin-app')

@section('title', 'Admin | Id Card Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Id Card Data')

@section('style')
    <style>
        * { box-sizing: border-box; }

        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .page-header .breadcrumb-sub {
            font-size: 11px;
            font-weight: 500;
            color: #6c757d;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .page-header .page-title {
            font-size: 13px;
            font-weight: 500;
            color: #212529;
            margin-top: 2px;
        }
        .record-count {
            font-size: 10px;
            color: #6c757d;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }
        .export-group {
            display: flex;
            gap: 4px;
            align-items: center;
        }
        .export-label {
            font-size: 11px;
            color: #6c757d;
            margin-right: 2px;
        }
        .btn-export {
            font-size: 11px;
            padding: 3px 8px;
            border: 0.5px solid #ced4da;
            border-radius: 3px;
            background: #f8f9fa;
            color: #495057;
            text-decoration: none;
            line-height: 1.4;
        }
        .btn-export:hover {
            background: #e9ecef;
            color: #212529;
            text-decoration: none;
        }
        .search-group {
            display: flex;
            gap: 4px;
            align-items: center;
        }
        .search-group input.form-control {
            font-size: 11px;
            padding: 4px 8px;
            height: auto;
            border-radius: 3px;
            border: 0.5px solid #ced4da;
            width: 180px;
        }
        .btn-search {
            font-size: 11px;
            padding: 4px 10px;
            border: 0.5px solid #B5D4F4;
            border-radius: 3px;
            background: #E6F1FB;
            color: #185FA5;
        }
        .btn-search:hover {
            background: #B5D4F4;
        }

        /* Table */
        .tbl-outer {
            border: 0.5px solid #dee2e6;
            border-radius: 4px;
            overflow: hidden;
            overflow-x: auto;
        }
        .tbl-gov {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            table-layout: auto;
            margin-bottom: 0;
        }
        .tbl-gov thead tr {
            background: #f1f3f5;
            border-bottom: 1px solid #ced4da;
        }
        .tbl-gov thead th {
            padding: 6px 8px;
            font-size: 10.5px;
            font-weight: 500;
            color: #6c757d;
            white-space: nowrap;
            border-right: 0.5px solid #e9ecef;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            vertical-align: middle;
        }
        .tbl-gov thead th:last-child { border-right: none; }
        .tbl-gov tbody tr {
            border-bottom: 0.5px solid #e9ecef;
        }
        .tbl-gov tbody tr:last-child { border-bottom: none; }
        .tbl-gov tbody tr:hover { background: #f8f9fa; }
        .tbl-gov tbody td {
            padding: 5px 8px;
            font-size: 11px;
            color: #212529;
            white-space: nowrap;
            border-right: 0.5px solid #e9ecef;
            vertical-align: middle;
        }
        .tbl-gov tbody td:last-child { border-right: none; }
        .tbl-gov .sno { color: #6c757d; }
        .tbl-gov .worker-id { font-weight: 500; }

        /* Badges */
        .badge-gov {
            display: inline-block;
            font-size: 10px;
            padding: 1px 6px;
            border-radius: 2px;
            font-weight: 500;
            border: 0.5px solid transparent;
        }
        .badge-active   { background: #EAF3DE; color: #3B6D11; border-color: #C0DD97; }
        .badge-pending  { background: #FAEEDA; color: #854F0B; border-color: #FAC775; }
        .badge-paid     { background: #E1F5EE; color: #0F6E56; border-color: #9FE1CB; }
        .badge-unpaid   { background: #FCEBEB; color: #A32D2D; border-color: #F7C1C1; }
        .badge-issued   { background: #E6F1FB; color: #185FA5; border-color: #B5D4F4; }
        .badge-default  { background: #f1f3f5; color: #495057; border-color: #dee2e6; }

        /* Action buttons */
        .btn-act {
            font-size: 10px;
            padding: 2px 7px;
            border: 0.5px solid #ced4da;
            border-radius: 2px;
            background: #f8f9fa;
            color: #495057;
            text-decoration: none;
            display: inline-block;
            margin-right: 2px;
            line-height: 1.5;
        }
        .btn-act:hover {
            background: #e9ecef;
            color: #212529;
            text-decoration: none;
        }
        .btn-act-blue {
            border-color: #B5D4F4;
            background: #E6F1FB;
            color: #185FA5;
        }
        .btn-act-blue:hover { background: #B5D4F4; }

        /* Pagination */
        .pagination-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
        }
        .pagination-row .page-count-info {
            font-size: 10.5px;
            color: #6c757d;
        }
        .pagination > li > a,
        .pagination > li > span {
            font-size: 11px;
            padding: 3px 8px;
            border: 0.5px solid #dee2e6;
            border-radius: 3px !important;
            color: #495057;
            background: #fff;
            margin: 0 1px;
            line-height: 1.5;
        }
        .pagination > li.active > a,
        .pagination > li.active > span {
            background: #E6F1FB;
            color: #185FA5;
            border-color: #B5D4F4;
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="page-header">
            <div>
                <div class="breadcrumb-sub">MIS Data</div>
                <div class="page-title">ID Card Data</div>
            </div>
            <div class="record-count">Showing {{ $datas->firstItem() }}–{{ $datas->lastItem() }} of {{ $datas->total() }} records</div>
        </div>

        <form method="GET" action="{{ route('admin.dataupdate.index') }}">
            <div class="toolbar">
                <div class="export-group">
                    <span class="export-label">Export:</span>
                    <a href="{{ route('admin.dataupdate.exportdata', 'csv') }}"  class="btn-export">CSV</a>
                    <a href="{{ route('admin.dataupdate.exportdata', 'xlsx') }}" class="btn-export">Excel</a>
                    <a href="{{ route('admin.dataupdate.exportdata', 'pdf') }}"  class="btn-export">PDF</a>
                </div>
                <div class="search-group">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by Worker ID"
                           value="{{ request('search') }}">
                    <button class="btn-search" type="submit">Search</button>
                </div>
            </div>
        </form>

        <div class="tbl-outer">
            <table class="tbl-gov">
                <thead>
                <tr>
                    <th>#</th>
                    <th>App. Number</th>
                    <th>Ack No.</th>
                    <th>Office Code</th>
                    <th>Receiver ID</th>
                    <th>Sender ID</th>
                    <th>ID Card</th>
                    <th>Alr. Pay.</th>
                    <th>Status</th>
                    <th>Pay. Status</th>
                    <th>RTPS</th>
                    <th>Resubmit</th>
                    <th>Phone</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td class="sno">{{ $loop->iteration }}</td>
                        <td class="worker-id">{{ $data->worker_id }}</td>
                        <td>{{ $data->ack_no }}</td>
                        <td>{{ $data->office_id }}</td>
                        <td>{{ $data->application_receiver_user_id }}</td>
                        <td>{{ $data->application_sender_user_id }}</td>
                        <td>
                            @if($data->id_card)
                                <span class="badge-gov badge-issued">{{ $data->id_card }}</span>
                            @else
                                <span class="badge-gov badge-pending">—</span>
                            @endif
                        </td>
                        <td>
                            @php $ap = strtolower($data->already_payment_status ?? ''); @endphp
                            <span class="badge-gov {{ $ap === 'paid' ? 'badge-paid' : ($ap === 'unpaid' ? 'badge-unpaid' : 'badge-default') }}">
                            {{ $data->already_payment_status ?? '—' }}
                        </span>
                        </td>
                        <td>
                            @php $st = strtolower($data->status ?? ''); @endphp
                            <span class="badge-gov {{ $st === 'active' ? 'badge-active' : ($st === 'pending' ? 'badge-pending' : 'badge-default') }}">
                            {{ $data->status ?? '—' }}
                        </span>
                        </td>
                        <td>
                            @php $ps = strtolower($data->payment_status ?? ''); @endphp
                            <span class="badge-gov {{ $ps === 'paid' ? 'badge-paid' : ($ps === 'unpaid' ? 'badge-unpaid' : 'badge-default') }}">
                            {{ $data->payment_status ?? '—' }}
                        </span>
                        </td>
                        <td>{{ $data->rtps_trans_id ?? '—' }}</td>
                        <td>{{ $data->resubmit_status ?? '—' }}</td>
                        <td>{{ $data->phone_no }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</td>
                        <td>
                            <a class="btn-act" href="{{ route('admin.dataupdate.edit', $data->id) }}" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn-act btn-act-blue" href="{{ route('admin.dataupdate.edit-family-details', $data->id) }}">Family</a>
                            <a class="btn-act btn-act-blue" href="{{ route('admin.dataupdate.edit-certificate-details', $data->id) }}">Cert.</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-row">
            <div class="page-count-info">Page {{ $datas->currentPage() }} of {{ $datas->lastPage() }}</div>
            {{ $datas->links() }}
        </div>

    </div>
@endsection