@extends('layouts.admin-app')

@section('title', 'Office | Application | ' . ucfirst('Benefit Overview'))
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Digital Signature')
@section('header')
    {{-- header for file link --}}
@endsection

<style>
    .tab-panel {
        min-height: 500px;
        /* Or whatever height works for your content */
        position: relative;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100;
    }

    .tab-container {
        width: 90%;
        margin: 50px auto;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .tab-container button:focus {
        outline: none
    }

    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #ddd;
    }

    .tab-button {
        padding: 10px 5px;
        background: #156092;
        border: none;
        border-right: 1px solid #2d94d9;
        cursor: pointer;
        flex: 1;
        transition: all 0.3s;
        color: white;
    }

    .tab-button:hover {
        background: #2196f3;
    }

    .tab-button.active {
        background: #2196f3;
        color: white;
        outline: none;
        border: none;
    }

    .tab-content {
        padding: 20px;
    }

    .tab-panel {
        display: none;
    }

    .tab-panel.active {
        display: block;
        animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>


@section('content')

    <div class="container-fluid">
        <div>
            <div class="tab-container">
                @include('office.benefits.tabs')
                <div class="tab-content">

                    <div class="tab-panel active" id="tab1">
                        <div class="container-fluid mt-4">
                            <div class="card shadow">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Dashboard & Reports</h5>
                                    <div>
                                        <button class="btn btn-outline-primary btn-sm me-2"
                                            onclick="openModal('filterReportsModal')">
                                            Filter Dashboard
                                        </button>
                                        <button class="btn btn-outline-success btn-sm"
                                            onclick="downloadExcel('reportsTable', 'DashboardReports')">
                                            Download Excel
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <!-- Summary Grid -->
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="card summary-card text-center p-3 shadow-sm"
                                                title="Click to drill down to scheme, district, age & gender details"
                                                onclick="openDrillDown()">
                                                <h6 class="text-muted">Total Applications</h6>
                                                <h3 class="fw-bold">150</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card summary-card text-center p-3 shadow-sm"
                                                onclick="alert('Medical Assistance drilldown (placeholder)')">
                                                <h6 class="text-muted">Medical Assistance</h6>
                                                <h3 class="fw-bold">60</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card summary-card text-center p-3 shadow-sm"
                                                onclick="alert('General Pension drilldown (placeholder)')">
                                                <h6 class="text-muted">General Pension</h6>
                                                <h3 class="fw-bold">40</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card summary-card text-center p-3 shadow-sm"
                                                onclick="alert('Rejected Applications drilldown (placeholder)')">
                                                <h6 class="text-muted">Rejected Applications</h6>
                                                <h3 class="fw-bold">10</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card summary-card text-center p-3 shadow-sm"
                                                onclick="alert('Accepted Applications drilldown (placeholder)')">
                                                <h6 class="text-muted">Accepted Applications</h6>
                                                <h3 class="fw-bold">120</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card summary-card text-center p-3 shadow-sm"
                                                onclick="alert('Avg. Processing Time drilldown (placeholder)')">
                                                <h6 class="text-muted">Avg. Processing Time</h6>
                                                <h3 class="fw-bold">3 Days</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Table Section -->
                                    <h5 class="mt-4">Application Timeline Details</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered mt-3">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>App ID</th>
                                                    <th>Submitted</th>
                                                    <th>RO Forwarded</th>
                                                    <th>RO Approval Date</th>
                                                    <th>HO Forward Date</th>
                                                    <th>Total Days</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>MEJA25CENKAM001</td>
                                                    <td>2025-01-15</td>
                                                    <td>2025-01-16</td>
                                                    <td>2025-01-18</td>
                                                    <td>2025-01-20</td>
                                                    <td>5</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>







@endsection
