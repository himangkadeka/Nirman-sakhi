@extends('layouts.admin-app')

@section('title', 'Application Audit Trail')

@section('style')

    <style>
        .audit-table{
            font-size:12px;
        }

        .audit-table th{
            background:#f8f9fa;
            font-size:11px;
            padding:8px;
            white-space:nowrap;
        }

        .audit-table td{
            padding:8px;
            vertical-align:middle;
        }

        .timeline{
            position:relative;
            margin-left:12px;
            padding-left:18px;
        }

        .timeline:before{
            content:'';
            position:absolute;
            left:4px;
            top:0;
            bottom:0;
            width:1px;
            background:#d6d6d6;
        }

        .timeline-item{
            position:relative;
            margin-bottom:10px;
        }

        .timeline-dot{
            position:absolute;
            left:-17px;
            top:12px;
            width:8px;
            height:8px;
            border-radius:50%;
            background:#0d6efd;
        }

        .audit-card{
            border:1px solid #e9ecef;
            border-radius:6px;
            box-shadow:none;
        }

        .audit-card .card-header{
            padding:6px 10px;
            min-height:auto;
        }

        .audit-card .card-body{
            padding:10px;
        }

        .audit-label{
            color:#6c757d;
            font-size:10px;
            text-transform:uppercase;
            margin-bottom:2px;
        }

        .audit-value{
            font-size:12px;
            font-weight:600;
        }

        .badge-status{
            font-size:10px;
            padding:4px 8px;
            border-radius:12px;
        }

        .compact-info{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:10px;
        }

        .compact-info div{
            min-width:0;
        }

        .detail-table{
            font-size:11px;
            margin-bottom:0;
        }

        .detail-table th{
            width:180px;
            background:#f8f9fa;
            padding:5px 8px;
        }

        .detail-table td{
            padding:5px 8px;
        }

        .search-box{
            height:34px;
            font-size:13px;
        }

        .btn-compact{
            padding:4px 10px;
            font-size:12px;
        }

        .audit-card hr{
            margin:8px 0;
        }


        .audit-text{
            font-size:12px;
            margin-top:2px;
        }

        .audit-link{
            font-size:12px;
            font-weight:600;
            text-decoration:none;
        }

        .db-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:4px;
            font-size:11px;
        }

        .db-item{
            border:1px solid #eee;
            padding:4px 8px;
            border-radius:4px;
        }

        .db-key{
            color:#6c757d;
            font-size:10px;
        }

        .db-value{
            font-weight:600;
        }

        .audit-search-input{
            height:42px;
            padding-left:40px;
            border-radius:25px;
            border:1px solid #dcdcdc;
            font-size:13px;
        }

        .audit-search-input:focus{
            box-shadow:none;
            border-color:#0d6efd;
        }

        .search-icon{
            position:absolute;
            left:15px;
            top:13px;
            color:#6c757d;
            z-index:10;
        }
        @media(max-width:768px){

            .compact-info{
                grid-template-columns:repeat(2,1fr);
            }

            .audit-table{
                font-size:11px;
            }
        }

    </style>

@endsection

@section('content')

    <div class="container-fluid">

        <div class="card shadow-sm mb-4">

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body py-2">

                    <form method="GET">

                        <div class="row align-items-center">

                            <div class="col-md-8">

                                <div class="position-relative">

                                    <i class="fa fa-search search-icon"></i>

                                    <input
                                            type="text"
                                            name="search"
                                            class="form-control audit-search-input"
                                            placeholder="Search Worker ID, Ack No, Application No..."
                                            value="{{ request('search') }}"
                                    >

                                </div>

                            </div>

                            <div class="col-md-4 text-right">

                                <button class="btn btn-primary btn-sm px-4">
                                    Search
                                </button>

                                <a href="{{ url()->current() }}"
                                   class="btn btn-light btn-sm">
                                    Reset
                                </a>

                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
        <div class="card shadow-sm">

            <div class="card-header bg-white">

                <h5 class="mb-0">
                    Application Audit History
                </h5>

            </div>

            <div class="card-body p-0">

                <table class="table table-hover audit-table mb-0">

                    <thead>

                    <tr>
                        <th>Worker ID</th>
                        <th>Ack No</th>
                        <th>Current Status</th>
                        <th>Total Movements</th>
                        <th>Last Updated</th>
                        <th width="120">Action</th>
                    </tr>

                    </thead>

                    <tbody>

                    @foreach($groupedApplications as $app)

                        @php
                            $latest = $latestRecords[$app->latest_id];
                        @endphp
                        <tr>

                            <td>{{ $latest->worker_id }}</td>

                            <td>{{ $latest->ack_no }}</td>

                            <td>
        <span class="badge badge-success">
            {{ $latest->application_status }}
        </span>
                            </td>

                            <td>
                                {{ $app->total_movements }}
                            </td>

                            <td>
                                {{ optional($latest->created_at)->format('d-M-Y h:i A') }}
                            </td>

                            <td>

                                <button
                                        class="btn btn-outline-primary btn-sm"
                                        data-toggle="collapse"
                                        data-target="#history{{ $latest->id }}"
                                >
                                    History
                                </button>

                            </td>

                        </tr>
                        <tr>

                            <td colspan="6" class="p-0 border-0">

                                <div
                                        id="history{{ $latest->id }}"
                                        class="collapse bg-light"
                                >

                                    <div class="p-3">

                                        <div class="timeline">

                                            @foreach($historyData[$latest->worker_id] ?? [] as $row)

                                                <div class="timeline-item">

                                                    <div class="timeline-dot"></div>

                                                    <div class="card audit-card">

                                                        <div class="card-header bg-white py-2">

                                                            <div class="d-flex justify-content-between">

                                                                <strong>
                                                                    {{ $row->application_status }}
                                                                </strong>

                                                                <small class="text-muted">
                                                                    {{ optional($row->created_at)->format('d-M-Y h:i A') }}
                                                                </small>

                                                            </div>

                                                        </div>

                                                        <div class="card-body py-2">

                                                            <div class="row">

                                                                <div class="col-md-3">
                                                                    <small class="text-muted">Ack No</small>
                                                                    <div>{{ $row->ack_no }}</div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <small class="text-muted">Sender Role</small>
                                                                    <div>{{ $row->sender_role_id }}</div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <small class="text-muted">Receiver Role</small>
                                                                    <div>{{ $row->application_receiver_role_id }}</div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <small class="text-muted">Application No</small>
                                                                    <div>{{ $row->application_no }}</div>
                                                                </div>

                                                            </div>

                                                            @if($row->remarks)
                                                                <hr class="my-2">
                                                                <strong>Remarks:</strong>
                                                                {{ $row->remarks }}
                                                            @endif

                                                            @if($row->reasons)
                                                                <hr class="my-2">
                                                                <strong>Reasons:</strong>
                                                                {{ $row->reasons }}
                                                            @endif

                                                            <div class="mt-2">

                                                                <a
                                                                        href="javascript:void(0)"
                                                                        data-toggle="collapse"
                                                                        data-target="#fullrow{{ $row->id }}"
                                                                >
                                                                    View Complete Row
                                                                </a>

                                                            </div>

                                                            <div
                                                                    id="fullrow{{ $row->id }}"
                                                                    class="collapse mt-2"
                                                            >

                                                                <table class="table table-sm table-bordered">

                                                                    @foreach($row->getAttributes() as $field => $value)

                                                                        <tr>

                                                                            <th width="250">
                                                                                {{ $field }}
                                                                            </th>

                                                                            <td>
                                                                                {{ $value ?? '-' }}
                                                                            </td>

                                                                        </tr>

                                                                    @endforeach

                                                                </table>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                            </td>

                        </tr>
                    @endforeach



                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-3">

            {{ $groupedApplications->links() }}

        </div>

    </div>

@endsection