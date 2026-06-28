@extends('layouts.admin-app')

@section('title', 'Admin | Payment Reports')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Payment Reports')

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

        /* Summary cards */
        .summary-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 14px;
        }
        .summary-card {
            background: #f8f9fa;
            border: 0.5px solid #e9ecef;
            border-radius: 4px;
            padding: 10px 12px;
            border-left-width: 2px;
            border-left-style: solid;
        }
        .summary-card.total { border-left-color: #185FA5; }
        .summary-card.reg   { border-left-color: #0F6E56; }
        .summary-card.sub   { border-left-color: #854F0B; }
        .summary-card .card-label {
            font-size: 10px; font-weight: 500; color: #6c757d;
            text-transform: uppercase; letter-spacing: 0.04em;
        }
        .summary-card .card-value  { font-size: 15px; font-weight: 500; color: #212529; margin-top: 3px; }
        .summary-card .card-sub    { font-size: 10px; color: #6c757d; margin-top: 2px; }

        /* Toolbar */
        .toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin-bottom: 10px; }
        .export-group { display: flex; gap: 4px; align-items: center; }
        .export-label { font-size: 11px; color: #6c757d; margin-right: 2px; }
        .btn-export {
            font-size: 11px; padding: 3px 8px; border: 0.5px solid #ced4da;
            border-radius: 3px; background: #f8f9fa; color: #495057; text-decoration: none; line-height: 1.4;
        }
        .btn-export:hover { background: #e9ecef; color: #212529; text-decoration: none; }
        .search-group { display: flex; gap: 4px; align-items: center; }
        .search-group input.form-control {
            font-size: 11px; padding: 4px 8px; height: auto;
            border-radius: 3px; border: 0.5px solid #ced4da; width: 180px;
        }
        .btn-search {
            font-size: 11px; padding: 4px 10px;
            border: 0.5px solid #B5D4F4; border-radius: 3px;
            background: #E6F1FB; color: #185FA5;
        }
        .btn-search:hover { background: #B5D4F4; }

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
        .tbl-gov .amount { font-weight: 500; font-variant-numeric: tabular-nums; }

        /* Badges */
        .badge-gov { display: inline-block; font-size: 10px; padding: 1px 6px; border-radius: 2px; font-weight: 500; border: 0.5px solid transparent; }
        .b-success { background: #E1F5EE; color: #0F6E56; border-color: #9FE1CB; }
        .b-danger  { background: #FCEBEB; color: #A32D2D; border-color: #F7C1C1; }
        .b-warning { background: #FAEEDA; color: #854F0B; border-color: #FAC775; }
        .b-info    { background: #E6F1FB; color: #185FA5; border-color: #B5D4F4; }
        .b-reg     { background: #E6F1FB; color: #185FA5; border-color: #B5D4F4; }
        .b-sub     { background: #FAEEDA; color: #854F0B; border-color: #FAC775; }

        /* Action buttons */
        .btn-act {
            font-size: 10px; padding: 2px 7px; border: 0.5px solid #ced4da;
            border-radius: 2px; background: #f8f9fa; color: #495057;
            cursor: pointer; text-decoration: none; display: inline-block;
            margin-right: 2px; line-height: 1.5;
        }
        .btn-act:hover { background: #e9ecef; }
        .btn-act-blue { border-color: #B5D4F4; background: #E6F1FB; color: #185FA5; }
        .btn-act-blue:hover { background: #B5D4F4; }
        .btn-act-red  { border-color: #F7C1C1; background: #FCEBEB; color: #A32D2D; }
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
            background: #E6F1FB; color: #185FA5;
            border-color: #B5D4F4; font-weight: 500;
        }

        /* Modal */
        .modal-content { border: 0.5px solid #dee2e6; border-radius: 4px; }
        .modal-header {
            background: #f1f3f5; border-bottom: 0.5px solid #dee2e6;
            padding: 8px 12px;
        }
        .modal-header .modal-title { font-size: 12px; font-weight: 500; color: #212529; }
        .modal-header .close { font-size: 14px; color: #6c757d; }
        .modal-body { padding: 12px; }
        .modal-body label { font-size: 10.5px; font-weight: 500; color: #6c757d; display: block; margin-bottom: 4px; }
        .modal-body .form-control { font-size: 11px; padding: 4px 8px; height: 28px; border: 0.5px solid #ced4da; border-radius: 3px; }
        .modal-footer { padding: 8px 12px; border-top: 0.5px solid #e9ecef; }
        .btn-modal-primary {
            font-size: 11px; padding: 4px 12px; border: 0.5px solid #9FE1CB;
            border-radius: 3px; background: #E1F5EE; color: #0F6E56; font-weight: 500;
        }
        .btn-modal-primary:hover { background: #9FE1CB; }
        .btn-modal-cancel {
            font-size: 11px; padding: 4px 10px; border: 0.5px solid #ced4da;
            border-radius: 3px; background: #f8f9fa; color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="page-header">
            <div>
                <div class="breadcrumb-sub">MIS Data</div>
                <div class="page-title">Payment Reports</div>
            </div>
            <div class="record-count">Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }} records</div>
        </div>

        {{-- Summary cards --}}
        <div class="summary-row">
            <div class="summary-card total">
                <div class="card-label">Total Payment Received</div>
                <div class="card-value">Rs. {{ number_format($total) }} /-</div>
                <div class="card-sub">All payment types combined</div>
            </div>
            <div class="summary-card reg">
                <div class="card-label">Registration</div>
                <div class="card-value">Rs. {{ number_format($totalRegistration) }} /-</div>
                <div class="card-sub">New registrations</div>
            </div>
            <div class="summary-card sub">
                <div class="card-label">Subscription</div>
                <div class="card-value">Rs. {{ number_format($totalSubscription) }} /-</div>
                <div class="card-sub">Renewal subscriptions</div>
            </div>
        </div>

        {{-- Toolbar --}}
        <form method="GET" action="{{ route('admin.paymentdata.index') }}">
            <div class="toolbar">
                <div class="export-group">
                    <span class="export-label">Export:</span>
                    <a href="{{ route('admin.paymentdata.export', 'csv') }}"  class="btn-export">CSV</a>
                    <a href="{{ route('admin.paymentdata.export', 'xlsx') }}" class="btn-export">Excel</a>
                    <a href="{{ route('admin.paymentdata.export', 'pdf') }}"  class="btn-export">PDF</a>
                </div>
                <div class="search-group">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by Worker ID" value="{{ request('search') }}">
                    <button class="btn-search" type="submit">Search</button>
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
                    <th>Party Name</th>
                    <th>Transaction ID</th>
                    <th>Pay. Type</th>
                    <th>Pay. Status</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Bank</th>
                    <th>GRN</th>
                    <th>PRN</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td class="sno">{{ $loop->iteration }}</td>
                        <td class="wid">{{ $payment->worker_id }}</td>
                        <td>{{ $payment->PARTYNAME }}</td>
                        <td>{{ $payment->DEPARTMENT_ID }}</td>
                        <td>
                            @if ($payment->payment_type == 1)
                                <span class="badge-gov b-reg">Registration</span>
                            @else
                                <span class="badge-gov b-sub">Subscription</span>
                            @endif
                        </td>
                        <td>
                            @if ($payment->STATUS == 'Y')
                                <span class="badge-gov b-success">Success</span>
                            @elseif ($payment->STATUS == 'N')
                                <span class="badge-gov b-danger">Failed</span>
                            @elseif ($payment->STATUS == 'A')
                                <span class="badge-gov b-warning">Aborted</span>
                            @else
                                <span class="badge-gov b-info">Pending</span>
                            @endif
                        </td>
                        <td>{{ $payment->status ?? '—' }}</td>
                        <td class="amount">Rs. {{ $payment->AMOUNT }}</td>
                        <td>{{ $payment->BANKNAME }}</td>
                        <td>{{ $payment->GRN ?? '—' }}</td>
                        <td>{{ $payment->PRN ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->updated_at)->format('d-m-Y') }}</td>
                        <td>
                            <button type="button" class="btn-act btn-act-blue"
                                    data-toggle="modal"
                                    data-target="#editStatusModal"
                                    onclick="openEditModal('{{ $payment->id }}', '{{ $payment->STATUS }}')">
                                Edit
                            </button>
                            <form action="{{ route('admin.paymentdata.destroy', $payment->id) }}"
                                  method="POST" style="display:inline-block;"
                                  onsubmit="return confirm('Delete this payment record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-act btn-act-red">
                                    <i class="fa fa-trash" style="font-size:10px"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-row">
            <div class="pg-info">Page {{ $payments->currentPage() }} of {{ $payments->lastPage() }}</div>
            {{ $payments->links() }}
        </div>

    </div>

    {{-- Edit Status Modal --}}
    <div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <form id="editStatusForm" method="POST" action="{{ route('admin.paymentdata.update-payment-status') }}">
                @csrf
                <input type="hidden" name="payment_id" id="edit_payment_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title">Update Payment Status</span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="payment_status">Select Status</label>
                        <select class="form-control" name="payment_status" id="payment_status" required>
                            <option value="">-- Select Status --</option>
                            <option value="Y">Success</option>
                            <option value="N">Failed</option>
                            <option value="A">Aborted</option>
                            <option value="P">Pending</option>
                        </select>
                    </div>
                    <div class="modal-footer" style="justify-content:flex-end;gap:6px">
                        <button type="button" class="btn-modal-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-modal-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, status) {
            document.getElementById('edit_payment_id').value = id;
            document.getElementById('payment_status').value = status;
        }
    </script>
@endsection