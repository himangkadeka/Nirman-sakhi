@extends('layouts.admin-app')

@section('title', 'Admin | Dashboard')
@section('breadcrumb_item_1', 'Admin')
@section('breadcrumb_item_2', 'Dashboard')

@section('style')
    <style>
        /* Modern dashboard theme — CSS only (no HTML changes) */
        :root {
            --bg-0: #f6fbff;
            --bg-1: #ffffff;
            --primary-1: #3b82f6;
            --primary-2: #2563eb;
            --accent: #7c3aed;
            --muted: #64748b;
            --card-bg: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(37, 99, 235, 0.08);
            --shadow-1: 0 6px 24px rgba(9, 30, 66, 0.06);
        }

        /* Container */
        .dashboard-container {
            background: linear-gradient(180deg, var(--bg-0), var(--bg-1));
            padding: 28px;
            border-radius: 14px;
            box-shadow: var(--shadow-1);
            border: 1px solid rgba(99, 102, 241, 0.03);
        }

        /* Title / section */
        .section-title {
        font-weight: 700;
        color: #0f1724;
        font-size:20px;
        border-left: 4px solid linear-gradient(90deg, var(--primary-1), var(--accent));
        margin-bottom:30px;
        position: relative;
        margin-top:20px;

        }

        /* subtle decoration line */
        .section-title::after {
            content: "";
            position: absolute;
            left: 0;
            top: 100%;
            height: 6px;
            width: 60px;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--primary-1), var(--accent));
            transform: translateY(12px);
            opacity: 0.12;
            
        }

        /* Card grid & layout */
        .summary-row {
            margin: 0 -8px;
            display: flex;
            flex-wrap: wrap;
            gap:5px;
        }

        .summary-row .col-lg-3,
        .summary-row .col-md-4,
        .summary-row .col-sm-6 {
            padding: 8px;
            flex: 1 1 220px;
            max-width: 25%;
            box-sizing: border-box;
        }

        @media (max-width: 992px) {

            .summary-row .col-lg-3,
            .summary-row .col-md-4 {
                max-width: 33.333%;
            }
        }

        @media (max-width: 768px) {

            .summary-row .col-lg-3,
            .summary-row .col-md-4,
            .summary-row .col-sm-6 {
                max-width: 50%;
            }
        }

        @media (max-width: 480px) {

            .summary-row .col-lg-3,
            .summary-row .col-md-4,
            .summary-row .col-sm-6 {
                max-width: 100%;
            }
        }

        /* Dashboard card appearance */
        .dashboard-card {
            border-radius: 14px;
            padding: 18px 18px 20px 18px;
            text-align: left;
            position: relative;
            box-shadow: 0 8px 28px rgba(15, 23, 42, 0.04);
            transition: transform .22s ease, box-shadow .22s ease;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.86), rgba(255, 255, 255, 0.82));
            border: 1px solid var(--glass-border);
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
        }

        /* Icon style (uses existing i element) */
        .dashboard-card i {
            position: absolute;
            top: 14px;
            right: 16px;
            font-size: 26px;
            opacity: 0.22;
            transition: transform .22s ease, opacity .22s ease;
            color: #000;
        }

        .dashboard-card:hover i {
            opacity: 0.16;
            transform: scale(1.06);
        }

        /* Text inside card */
        .dashboard-card p {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.2px;
            text-transform: none;
            opacity: 0.95;
        }

        .dashboard-card h4 {
            margin: 6px 0 0 0;
            font-weight: 800;
            font-size: 20px;
            color: #ffffff;
            letter-spacing: 0.2px;
        }

        /* Color variants keep existing class names but refine */
        .bg-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0ea5a1 100%);
            color: #fff;
        }

        .bg-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: #fff;
        }

        .bg-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
        }

        .bg-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #111;
        }

        .bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            color: #fff;
        }

        .bg-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: #fff;
        }

        /* Make numeric highlight look nicer */
        .dashboard-card h4 {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(4px);
            font-weight: 700;
        }

        /* Small helper for the top summary white card */
        .d-flex.align-items-center.bg-white.border.rounded.shadow-sm.p-3.mb-3 {
            gap: 18px;
            align-items: center;
            justify-content: flex-start;
        }

        .d-flex.align-items-center.bg-white.border.rounded.shadow-sm.p-3.mb-3 i {
            opacity: 1;
            color: var(--primary-2);
            font-size: 1.6rem;
        }

        .d-flex.align-items-center.bg-white.border.rounded.shadow-sm.p-3.mb-3 h4 {
            color: var(--primary-2);
            margin: 0;
        }

        /* Link behavior */
        .summary-row a {
            text-decoration: none;
            display: block;
            height: 100%;
        }

        /* Accessibility: ensure sufficient contrast for warning cards */
        .bg-warning p,
        .bg-warning h4 {
            color: #0b1320;
        }

        /* Footer spacing */
        .dashboard-container>.row:last-child {
            margin-bottom: 6px;
        }
        .dashboard-card{box-shadow: rgb(226 224 224 / 40%) 0px 5px, rgb(208 208 208 / 40%) 0px 5px}
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="dashboard-container">

            {{-- Overall Office Wise Section --}}
            <h3 class="section-title">Overall Office Wise Data</h3>

            <div class="d-flex align-items-center bg-white border rounded shadow-sm p-3 mb-3">
                <i class="bi bi-inbox-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                <div class="text-center">
                    <p class="mb-0 text-muted  fw-semibold">Applications Received Today</p>
                    <h4 class="fw-bold text-primary mb-0">{{ $todaysCount }}</h4>
                </div>
                <br>
                <i class="bi bi-clipboard2-plus"></i>
                <div class="text-center">
                    <p class="mb-0 text-muted">Daily Avg</p>
                    <h4 class="fw-bold text-primary mb-0">{{ $dailyAvg }}</h4>
                </div>
            </div>

            <div class="row summary-row text-center">
                <a href="{{ route('admin.dashboard-data.index', 'all') }}" class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-info">
                        <i class="fas fa-file-alt"></i>
                        <p>Total Applications</p>
                        <h4>{{ $rowCount }}</h4>
                    </div>
                </a>
                <a href="{{ route('admin.dashboard-data.index', 'onboarding') }}" class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-primary">
                        <i class="fas fa-user-plus"></i>
                        <p>Onboarding Applications</p>
                        <h4>{{ $totalOnboarding }}</h4>
                    </div>
                </a>
                <a href="{{ route('admin.dashboard-data.index', 'new') }}" class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-warning">
                        <i class="fas fa-plus-circle"></i>
                        <p>New Applications</p>
                        <h4>{{ $totalNew }}</h4>
                    </div>
                </a>
                <a href="{{ route('admin.dashboard-data-renewal.index', 'renewal') }}" class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-success">
                        <i class="fas fa-sync-alt"></i>
                        <p>Renewal Applications</p>
                        <h4>{{ $totalRenewal }}</h4>
                    </div>
                </a>
            </div>

            {{-- Overall Data --}}
            <h3 class="section-title">Overall Data Summary</h3>

            <div class="row summary-row text-center">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-secondary">
                        <i class="bi bi-bag-heart-fill"></i>
                        <p>Total Pending</p>
                        <h4>{{ $countPending }}</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-danger">
                        <i class="bi bi-balloon-heart-fill"></i>
                        <p>Onboarding Pending</p>
                        <h4>{{ $totalPendingOnboarding }}</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-info">
                        <i class="bi bi-bookmark-star-fill"></i>
                        <p>New Pending</p>
                        <h4>{{ $totalPendingNew }}</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-success">
                        <i class="fas fa-check-circle"></i>
                        <p>Approved</p>
                        <h4>{{ $countApproved }}</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-info">
                        <i class="fas fa-user-check"></i>
                        <p>Onboarding Approved</p>
                        <h4>{{ $approveOnboarding }}</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-warning">
                        <i class="fas fa-check"></i>
                        <p>New Approved</p>
                        <h4>{{ $approveNew }}</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-danger">
                        <i class="fas fa-times-circle"></i>
                        <p>Total Rejected</p>
                        <h4>{{ $countRejected }}</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-warning">
                        <i class="bi bi-stars"></i>
                        <p>Total Reverted</p>
                        <h4>{{ $countReverted }}</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card bg-primary">
                        <i class="fas fa-redo"></i>
                        <p>Resubmitted</p>
                        <h4>{{ $resubmit_count }}</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
