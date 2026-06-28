@extends('layouts.admin-app')

@section('title', 'Admin | Track Application')
@section('breadcrumb_item_1', 'Application')
@section('breadcrumb_item_2', 'Registration/Onboarding')
@section('style')
    <style>
        .border-left-primary { border-left: 4px solid #007bff; }
        .border-left-success { border-left: 4px solid #28a745; }
        .border-left-warning { border-left: 4px solid #ffc107; }
        .border-left-danger  { border-left: 4px solid #dc3545; }

        .card { border-radius: 6px; }

        /* ── Base Table ── */
        .table { background: #fff; margin-bottom: 0 !important; }
        .table th {
            background: #f1f3f5;
            font-weight: 600;
            font-size: 12px;
            white-space: nowrap;
            vertical-align: middle;
        }
        .table td {
            font-size: 10px;
            font-weight: 600;
            vertical-align: middle;
        }

        /* ── DataTables ScrollX Fix ── */
        .dataTables_wrapper { width: 100%; }

        .dataTables_scroll {
            overflow-x: auto;
            border: 1px solid #dee2e6;
        }

        /* Force equal widths on header & body tables */
        .dataTables_scrollHead,
        .dataTables_scrollBody {
            width: 100% !important;
        }

        .dataTables_scrollHeadInner {
            width: 100% !important;
            padding-right: 0 !important;
        }

        .dataTables_scrollHeadInner table,
        .dataTables_scrollBody table {
            width: 100% !important;
            margin: 0 !important;
            table-layout: fixed !important;  /* KEY FIX */
        }

        /* ── Borders ── */
        table.dataTable {
            border-collapse: collapse !important;
        }

        table.dataTable th,
        table.dataTable td {
            border: 1px solid #dee2e6 !important;
            box-sizing: border-box;
        }

        /* ── Column Widths (MUST match JS) ── */
        #applicationsTable th:nth-child(1),
        #applicationsTable td:nth-child(1) { width: 45px; text-align: center; }

        #applicationsTable th:nth-child(2),
        #applicationsTable td:nth-child(2) { width: 150px; }

        #applicationsTable th:nth-child(3),
        #applicationsTable td:nth-child(3) { width: 150px; }

        #applicationsTable th:nth-child(4),
        #applicationsTable td:nth-child(4) { width: 150px; }

        #applicationsTable th:nth-child(5),
        #applicationsTable td:nth-child(5) { width: 100px; text-align: center; }

        /* Small font for status badges */
        #applicationsTable td:nth-child(5) .badge,
        #applicationsTable td:nth-child(5) span {
            font-size: 10px !important;
            padding: 3px 6px !important;
            font-weight: 500;
        }

        #applicationsTable th:nth-child(6),
        #applicationsTable td:nth-child(6) { width: 90px; text-align: center; }

        #applicationsTable th:nth-child(7),
        #applicationsTable td:nth-child(7) { width: 160px; }

        #applicationsTable th:nth-child(8),
        #applicationsTable td:nth-child(8) { width: 130px; }

        #applicationsTable th:nth-child(9),
        #applicationsTable td:nth-child(9) { width: 100px; }

        #applicationsTable th:nth-child(10),
        #applicationsTable td:nth-child(10) { width: 80px; text-align: center; font-size: 10px; }

        #applicationsTable th:nth-child(11),
        #applicationsTable td:nth-child(11) { width: 80px; text-align: center; }

        /* ── Modal Table ── */
        #trackTable th { background: #f8f9fa; font-weight: 600; }

        /* ── Badge ── */
        .badge { font-size: 11px; padding: 4px 8px; }
    </style>
@endsection


@section('content')
    <div class="container-fluid">

        <!-- SUMMARY CARDS -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card border-left-primary shadow-sm">
                    <div class="card-body py-2">
                        <div class="text-xs text-primary font-weight-bold">TOTAL</div>
                        <div class="h5 mb-0" id="totalCount">0</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-warning shadow-sm">
                    <div class="card-body py-2">
                        <div class="text-xs text-warning font-weight-bold">PENDING</div>
                        <div class="h5 mb-0" id="pendingCount">0</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-success shadow-sm">
                    <div class="card-body py-2">
                        <div class="text-xs text-success font-weight-bold">APPROVED</div>
                        <div class="h5 mb-0" id="approvedCount">0</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-danger shadow-sm">
                    <div class="card-body py-2">
                        <div class="text-xs text-danger font-weight-bold">REJECTED</div>
                        <div class="h5 mb-0" id="rejectedCount">0</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTERS -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-3">
                        <select id="status_filter" class="form-control form-control-sm">
                            <option value="">All Status</option>
                            <option value="A">Approved</option>
                            <option value="P">Pending</option>
                            <option value="R">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="from_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="to_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <button id="filterBtn" class="btn btn-sm btn-primary w-100">Apply Filter</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card shadow-sm">
            <div class="card-body p-2">
                <table id="applicationsTable"
                       class="table table-sm table-bordered table-hover w-100">
                    <thead class="text-center">
                    <tr>
                        <th>Sl</th>
                        <th>Worker ID</th>
                        <th>Ack No</th>
                        <th>ID Card</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>RTPS Status</th>
                        <th>Office</th>
                        <th>Location</th>
                        <th>Created</th>
                        <th>Action</th>
                        <th>View</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>

    <!-- Track Modal -->
    <div class="modal fade" id="trackModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Application Tracking</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-sm" id="trackTable">
                        <thead>
                        <tr>
                            <th>Status</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let table = $('#applicationsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.trackapp.list') }}",
                    data: function (d) {
                        d.status = $('#status_filter').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                ordering: true,
                pageLength: 25,
                columns: [
                    {
                        data: null,
                        name: 'serial_no',
                        orderable: false,
                        searchable: false,
                        width: '45px',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'worker_id', width: '170px' },
                    { data: 'ack_no', width: '170px' },
                    { data: 'id_card', width: '170px' },
                    { data: 'status', width: '80px', className: 'text-center' },
                    { data: 'payment_status', width: '90px', className: 'text-center' },
                    { data: 'rtps_trans_id', width: '90px', className: 'text-center' },
                    { data: 'office_id', width: '160px' },
                    { data: 'application_receiver_user_id', width: '80px' },
                    { data: 'created_at', width: '100px' },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        width: '80px',
                        className: 'text-center'
                    },
                    {
                        data: 'view',
                        orderable: false,
                        searchable: false,
                        width: '80px',
                        className: 'text-center'
                    }
                ],
                // Fix alignment after each draw
                drawCallback: function() {
                    $(this).DataTable().columns.adjust();
                },
                initComplete: function() {
                    let api = this.api();
                    setTimeout(function() {
                        api.columns.adjust();
                    }, 100);
                }
            });

            // Recalculate on resize
            $(window).on('resize', function() {
                table.columns.adjust();
            });

            // Filter Button
            $('#filterBtn').click(function () {
                table.draw();
            });

            // Load Summary
            function loadSummary() {
                $.get("{{ route('admin.trackapp.summary') }}", function (res) {
                    $('#totalCount').text(res.total);
                    $('#approvedCount').text(res.approved);
                    $('#pendingCount').text(res.pending);
                    $('#rejectedCount').text(res.rejected);
                });
            }
            loadSummary();

            // Track Button
            $(document).on('click', '.btn-track', function () {
                let workerId = $(this).data('id');
                let url = "{{ route('admin.trackapp.track', ':id') }}".replace(':id', workerId);

                $.get(url, function (res) {
                    let html = '';
                    res.forEach(function (item) {
                        html += `
                            <tr>
                                <td>${item.application_status ? item.application_status : '-'}</td>
                                <td>${item.sender_user_id ? item.sender_user_id : '-'}</td>
                                <td>${item.application_receiver_user_id ? item.application_receiver_user_id : '-'}</td>
                                <td>${item.created_at}</td>
                            </tr>
                        `;
                    });
                    $('#trackTable tbody').html(html);
                    $('#trackModal').modal('show');
                });
            });

            // View Button
            $(document).on('click', '.btn-view', function () {
                let encryptedId = $(this).data('id');
                let url = "{{ route('admin.trackapp.previewadmin', ':id') }}".replace(':id', encryptedId);
                window.open(url, '_blank');
            });
        });
    </script>
@endsection