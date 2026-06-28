@extends('layouts.admin-app')

@section('title', 'Admin | Application Status Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Application Status Data')

@section('style')
    <style>
        :root {
            --primary-blue: #1a73e8;
            --primary-blue-dark: #1557b0;
            --primary-blue-light: #4285f4;
            --navy-blue: #0c3c6e;
            --accent-orange: #ff6b35;
            --success-green: #34a853;
            --danger-red: #ea4335;
            --light-gray: #f8f9fa;
            --border-gray: #dadce0;
            --text-dark: #202124;
            --text-medium: #5f6368;
            --text-light: #80868b;
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
            --shadow-md: 0 2px 8px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 4px 12px rgba(0, 0, 0, 0.18);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--light-gray);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
        }

        .container-fluid {
            padding: 1.5rem;
            max-width: 100%;
        }



        /* Page Header Section */
        .page-header-section {
            background: var(--white);
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-blue);
            box-shadow: var(--shadow-sm);
            border-radius: 2px;
        }

        .page-main-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--navy-blue);
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-main-title::before {
            content: '';
            width: 6px;
            height: 24px;
            background: var(--accent-orange);
            border-radius: 2px;
        }

        .page-description {
            color: var(--text-medium);
            font-size: 0.95rem;
            margin: 0;
            line-height: 1.5;
        }

        /* Filter Cards */
        .filter-section {
            background: var(--white);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-gray);
            box-shadow: var(--shadow-sm);
            border-radius: 2px;
        }

        .filter-section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--light-gray);
        }

        .filter-icon {
            width: 36px;
            height: 36px;
            background: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.1rem;
            border-radius: 2px;
        }

        .filter-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--navy-blue);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Date Filter Form */
        .date-filter-form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: end;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .form-group label .required {
            color: var(--gov-red);
            margin-left: 2px;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--border-gray);
            background: var(--white);
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
            color: var(--text-dark);
            border-radius: 2px;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3E%3Cpath fill='%231a73e8' d='M8 11L3 6h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 12px;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        .form-select:hover {
            border-color: var(--primary-blue-light);
        }

        .form-select:disabled {
            background-color: var(--light-gray);
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Button Group */
        .button-group {
            display: flex;
            gap: 0.75rem;
            align-items: end;
        }

        .btn-gov {
            padding: 0.625rem 1.5rem;
            border: none;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 2px;
            white-space: nowrap;
        }

        .btn-gov:active {
            transform: translateY(1px);
        }

        .btn-primary-gov {
            background: var(--primary-blue);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary-gov:hover {
            background: var(--primary-blue-dark);
            box-shadow: var(--shadow-md);
        }

        .btn-success-gov {
            background: var(--success-green);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .btn-success-gov:hover {
            background: #2d8a47;
            box-shadow: var(--shadow-md);
            color: var(--white);
        }

        .btn-icon {
            font-size: 1rem;
        }

        /* Filter Grid */
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
        }

        .filter-field label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .filter-field label::before {
            content: '';
            width: 3px;
            height: 14px;
            background: var(--accent-orange);
            border-radius: 1px;
        }

        /* Accordion */
        .accordion {
            background: var(--white);
            border: 1px solid var(--border-gray);
            box-shadow: var(--shadow-sm);
            border-radius: 2px;
        }

        .accordion-item {
            border-bottom: 1px solid var(--border-gray);
        }

        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-header {
            margin: 0;
        }

        .accordion-button {
            padding: 1.25rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--navy-blue);
            background: var(--white);
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .accordion-button.collapsed {
            background: var(--white);
        }

        .accordion-button:not(.collapsed) {
            background: var(--primary-blue);
            color: var(--white);
        }

        .accordion-button:hover {
            background: var(--light-gray);
        }

        .accordion-button:not(.collapsed):hover {
            background: var(--primary-blue-dark);
        }

        .accordion-button::after {
            content: '';
            width: 1.25rem;
            height: 1.25rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 20 20'%3E%3Cpath fill='%231a73e8' d='M10 12l-5-5h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            transition: transform 0.2s ease;
        }

        .accordion-button:not(.collapsed)::after {
            transform: rotate(180deg);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 20 20'%3E%3Cpath fill='%23ffffff' d='M10 12l-5-5h10z'/%3E%3C/svg%3E");
        }

        .accordion-collapse {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-collapse.show {
            max-height: 5000px;
        }

        .accordion-body {
            padding: 1.5rem;
            background: var(--light-gray);
            border-top: 2px solid var(--accent-orange);
        }

        /* Table Styles */
        .table-government {
            width: 100%;
            background: var(--white);
            border: 1px solid var(--border-gray);
            border-collapse: collapse;
            box-shadow: var(--shadow-sm);
        }

        .table-government thead {
            background: var(--primary-blue);
            color: var(--white);
        }

        .table-government thead th {
            padding: 0.875rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: left;
        }

        .table-government tbody tr {
            transition: background 0.2s ease;
        }

        .table-government tbody tr:nth-child(even) {
            background: var(--light-gray);
        }

        .table-government tbody tr:hover {
            background: #e8f0fe;
        }

        .table-government tbody td {
            padding: 0.875rem 1rem;
            color: var(--text-dark);
            font-size: 0.95rem;
            border: 1px solid var(--border-gray);
        }

        .btn-view-gov {
            padding: 0.5rem 1rem;
            background: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            border-radius: 2px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-view-gov:hover {
            background: var(--primary-blue-dark);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }

        /* Info Banner */
        .info-banner {
            background: #e8f0fe;
            border-left: 4px solid var(--primary-blue);
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
            border-radius: 2px;
        }

        .info-banner strong {
            color: var(--primary-blue);
        }

        /* Loading State */
        .loading-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--white);
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-light);
            background: var(--white);
            border: 2px dashed var(--border-gray);
            border-radius: 2px;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-medium);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }



            .date-filter-form {
                flex-direction: column;
            }

            .form-group {
                width: 100%;
            }

            .button-group {
                width: 100%;
                flex-direction: column;
            }

            .btn-gov {
                width: 100%;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .table-government {
                font-size: 0.875rem;
            }

            .table-government thead th,
            .table-government tbody td {
                padding: 0.625rem;
            }
        }

        /* Accessibility */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
            }

            .btn-gov,
            .button-group {
                display: none;
            }
        }

        .filter-card {
            background: #ffffff;
            padding: 20px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            align-items: end;
        }

        .filter-field label {
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
            display: block;
        }

        .form-select {
            height: 42px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 6px 10px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-select:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.15);
        }

        .filter-action {
            display: flex;
            justify-content: flex-end;
        }

        .export-btn {
            background: linear-gradient(135deg, #343a40, #212529);
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            transition: 0.3s ease;
        }

        .export-btn:hover {
            background: linear-gradient(135deg, #000, #333);
            transform: translateY(-1px);
        }

        .export-btn:disabled,
        .btn-disabled {
            background: #ccc !important;
            cursor: not-allowed;
            opacity: 0.6;
            transform: none !important;
        }

        .report-btn-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* grid-auto-flow: column; */
            gap: 10px;
            align-items: stretch;
        }


        /* Base button */
        .report-btn {
            border: none;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
            height: 100%;
        }

        /* Hover effect */
        .report-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
        }

        /* Click effect */
        .report-btn:active {
            transform: scale(0.97);
        }

        /* Colors */
        .report-btn.blue {
            background: linear-gradient(135deg, #729ace, #166cdc);
        }

        .report-btn.green {
            background: linear-gradient(135deg, #78bd88, #1cbf42);
        }

        .report-btn.yellow {
            background: linear-gradient(135deg, #e4c565, #f0b324);
            color: #ffffff;
        }

        /* Icon styling */
        .report-btn span {
            font-size: 16px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-section">
            <h2 class="page-main-title">Application Status Dashboard</h2>
            <p class="page-description">Monitor and track application status across various offices, roles, and officers.
                Use filters below to view specific data.</p>
        </div>
        <div class="filter-section mb-4">
            <div class="filter-section-header">
                <div class="filter-icon">⚡</div>
                <h3 class="filter-section-title">ONE-CLICK FIFO REPORTS (All Offices)</h3>
            </div>

            <div class="info-banner mb-3">
                <strong>Note:</strong>
                These reports automatically apply <b>All Offices</b> and <b>All Officers</b>.
                Please select <b>From Date</b> and <b>To Date</b> above before exporting.
            </div>

            <div class="report-btn-grid">
                {{-- HRO --}}
                {{-- <div class="col-md-4"> --}}
                <button class="report-btn blue" onclick="runOneClickExport('HRO','new')">
                    HRO – New Registration
                </button>
                <button class="report-btn green" onclick="runOneClickExport('RO','new')">
                    RO – New Registration
                </button>
                <button class="report-btn yellow" onclick="runOneClickExport('DA','new')">
                    DA – New Registration
                </button>
                {{-- </div>
                <div class="col-md-4"> --}}
                <button class="report-btn blue" onclick="runOneClickExport('HRO','onboarding')">
                    HRO – Onboarding
                </button>
                {{-- </div>


                <div class="col-md-4"> --}}

                {{-- </div>
                <div class="col-md-4"> --}}
                <button class="report-btn green" onclick="runOneClickExport('RO','onboarding')">
                    RO – Onboarding
                </button>
                {{-- </div>


                <div class="col-md-4"> --}}

                {{-- </div>
                <div class="col-md-4"> --}}
                <button class="report-btn yellow" onclick="runOneClickExport('DA','onboarding')">
                    DA – Onboarding
                </button>
                {{-- </div> --}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">


                    <div>
                        {{-- <div class="fw-semibold text-muted mb-1" style="font-size: 0.85rem;">
                    EXPORT ALL
                </div>
                <a href="{{ route('admin.export-all', 'csv') }}" onclick="" class="btn btn-secondary btn-sm me-1">CSV</a>
                <a href="{{ route('admin.export-all', 'xlsx') }}" onclick="" class="btn btn-secondary btn-sm me-1">Excel</a>
                <a href="{{ route('admin.export-all', 'pdf') }}" onclick="" class="btn btn-danger btn-sm">PDF</a>
            </div> --}}

                    </div>
                </div>

            </div>
        </div>

        {{-- <div class="col-8">
            <a href="{{ url('admin/export-combined/csv') }}?fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
                class="btn btn-secondary btn-sm">CSV</a>

            <a href="{{ url('admin/export-combined/xlsx') }}?fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
                class="btn btn-secondary btn-sm">Excel</a>

            <a href="{{ url('admin/export-combined/pdf') }}?fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
                class="btn btn-danger btn-sm">PDF</a>
        </div> --}}
        <!-- Date Filter Section -->
        <form method="GET" action="{{ route('admin.get-application-status') }}">
            <div class="filter-section">
                <div class="filter-section-header">
                    <div class="filter-icon">📅</div>
                    <h3 class="filter-section-title">Date Range Filter</h3>
                </div>

                <div class="date-filter-form">
                    <div class="form-group">
                        <label for="fromDate">From Date</label>
                        <input type="date" id="fromDate" name="fromDate" value="{{ request('fromDate') }}">
                    </div>

                    <div class="form-group">
                        <label for="toDate">To Date</label>
                        <input type="date" id="toDate" name="toDate" value="{{ request('toDate') }}">
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn-gov btn-primary-gov">
                            <span class="btn-icon">🔍</span>
                            Apply Filter
                        </button>
                        <a href="{{ route('admin.get-application-status') }}" class="btn-gov btn-success-gov">
                            <span class="btn-icon">↻</span>
                            Reset All
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Main Filter Section -->
        <div class="filter-section">
            <div class="filter-section-header">
                <div class="filter-icon">⚙️</div>
                <h3 class="filter-section-title">Application Filters</h3>

            </div>

            <div class="filter-card">
                <div class="filter-grid">
                    <div class="filter-field">
                        <label>Office</label>
                        <select id="office_id" class="form-select" onchange="loadRoles(this.value); toggleExportButton()"
                            name="office_id">
                            <option value="">-- Select Office --</option>
                            @forelse ($offices as $office)
                                <option value="{{ $office->office_id }}">
                                    {{ $office->office_name }}
                                </option>
                            @empty
                                <option value="">No Offices Available</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="filter-field">
                        <label>Role</label>
                        <select id="role_id" class="form-select" onchange="loadOfficers(this.value); toggleExportButton()"
                            name="role_id">
                            <option value="">-- Select Role --</option>
                        </select>
                    </div>
                    <div class="filter-action">
                        <button id="exportBtn" class="btn btn-dark btn-sm export-btn" onclick="runRoleBasedExport()"
                            disabled>
                            Export Role-wise Report
                        </button>{{-- <button class="btn btn-dark btn-sm" onclick="runRoleBasedExport('xlsx')">
                        Export Role-wise Report
                    </button> --}}
                    </div>

                    <div class="filter-field">
                        <label>Officer</label>
                        <select id="officer_id" class="form-select" name="officer_id" onchange="toggleExportButton()">
                            <option value="">-- Select Officer --</option>
                        </select>
                    </div>

                    <div class="filter-field">
                        <label>Registration Type</label>
                        <select id="registration_type" class="form-select"
                            onchange="redirectWithFilters(); toggleExportButton()" name="registration_type">
                            <option value="">-- Select Type --</option>
                            <option value="onboarding">Onboarding</option>
                            <option value="new">New Registration</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="accordion" id="officerAccordion">
                    <!-- Dynamic content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    {{-- <script>
// Clear localStorage when page loads
document.addEventListener('DOMContentLoaded', function () {
    // Clear all saved selections when landing on this page
    localStorage.removeItem('office_id');
    localStorage.removeItem('role_id');
    localStorage.removeItem('officer_id');
    localStorage.removeItem('registration_type');

    // Reset all dropdowns to default
    document.getElementById('office_id').value = '';
    document.getElementById('role_id').innerHTML = '<option value="">-- Select Role --</option>';
    document.getElementById('officer_id').innerHTML = '<option value="">-- Select Officer --</option>';
    document.getElementById('registration_type').value = '';

    /* Accordion functionality */
    var accordionButtons = document.querySelectorAll('.accordion-button');
    accordionButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var target = document.querySelector(targetId);

            if (target) {
                this.classList.toggle('collapsed');
                target.classList.toggle('show');
            }
        });
    });
});

function redirectWithFilters() {
    var officeId = document.getElementById('office_id').value;
    var roleId = document.getElementById('role_id').value;
    var officerId = document.getElementById('officer_id').value;
    var registrationType = document.getElementById('registration_type').value;

    var fromDate = document.getElementById('fromDate').value;
    var toDate = document.getElementById('toDate').value;

    if (!officeId || !roleId || !officerId || !registrationType) {
        alert('Please select Office, Role, Officer, and Registration Type.');
        return;
    }

    let url = 'officer-applications/' + officerId +
        '?type=' + registrationType +
        '&fromDate=' + fromDate +
        '&toDate=' + toDate;

    window.location.href = url;
}

/* Load Officers by Role */
function loadOfficers(roleId) {
    var officeId = document.getElementById('office_id').value;
    var officerSelect = document.getElementById('officer_id');

    officerSelect.innerHTML = '<option value="">Loading...</option>';

    if (!roleId || !officeId) {
        officerSelect.innerHTML = '<option value="">-- Select Officer --</option>';
        return;
    }

    fetch('/admin/get-application-status-by-role/' + roleId + '?office=' + officeId)
        .then(function(res) { return res.json(); })
        .then(function(data) {
            officerSelect.innerHTML = '<option value="">-- Select Officer --</option>';

            if (!data.officers || data.officers.length === 0) {
                officerSelect.innerHTML += '<option value="">No officers found</option>';
                return;
            }

            data.officers.forEach(function(o) {
                officerSelect.innerHTML += '<option value="' + o.id + '">' + o.firstname + ' ' + o.lastname + '</option>';
            });
        });
}

/* Load Roles by Office */
function loadRoles(officeId) {
    var roleSelect = document.getElementById('role_id');
    var officerSelect = document.getElementById('officer_id');

    roleSelect.innerHTML = '<option value="">-- Select Role --</option>';
    officerSelect.innerHTML = '<option value="">-- Select Officer --</option>';

    if (!officeId) return;

    fetch('/admin/get-roles-by-office/' + officeId)
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.length === 0) {
                roleSelect.innerHTML += '<option value="">No roles for this office</option>';
                return;
            }

            data.forEach(function(role) {
                roleSelect.innerHTML += '<option value="' + role.id + '">' + role.name + '</option>';
            });
        });
}
</script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we're returning from officer applications page
            const urlParams = new URLSearchParams(window.location.search);
            const isReturning = urlParams.has('fromDate') || urlParams.has('toDate');

            // Only clear localStorage if NOT returning from officer applications
            if (!isReturning && !sessionStorage.getItem('preserveFilters')) {
                localStorage.removeItem('office_id');
                localStorage.removeItem('role_id');
                localStorage.removeItem('officer_id');
                localStorage.removeItem('registration_type');

                // Reset all dropdowns to default
                document.getElementById('office_id').value = '';
                document.getElementById('role_id').innerHTML = '<option value="">-- Select Role --</option>';
                document.getElementById('officer_id').innerHTML = '<option value="">-- Select Officer --</option>';
                document.getElementById('registration_type').value = '';
            } else {
                // Restore saved values
                restoreSavedFilters();
                // Clear the session flag
                sessionStorage.removeItem('preserveFilters');
            }

            /* Accordion functionality */
            var accordionButtons = document.querySelectorAll('.accordion-button');
            accordionButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var targetId = this.getAttribute('data-target');
                    var target = document.querySelector(targetId);

                    if (target) {
                        this.classList.toggle('collapsed');
                        target.classList.toggle('show');
                    }
                });
            });
        });

        function restoreSavedFilters() {
            var savedOffice = localStorage.getItem('office_id');
            var savedRole = localStorage.getItem('role_id');
            var savedOfficer = localStorage.getItem('officer_id');
            var savedRegType = localStorage.getItem('registration_type');

            if (savedOffice) {
                document.getElementById('office_id').value = savedOffice;
                loadRoles(savedOffice, function() {
                    if (savedRole) {
                        document.getElementById('role_id').value = savedRole;
                        loadOfficers(savedRole, function() {
                            if (savedOfficer) {
                                document.getElementById('officer_id').value = savedOfficer;
                            }
                        });
                    }
                });
            }

            if (savedRegType) {
                document.getElementById('registration_type').value = savedRegType;
            }
        }

        function redirectWithFilters() {
            var officeId = document.getElementById('office_id').value;
            var roleId = document.getElementById('role_id').value;
            var officerId = document.getElementById('officer_id').value;
            var registrationType = document.getElementById('registration_type').value;

            var fromDate = document.getElementById('fromDate').value;
            var toDate = document.getElementById('toDate').value;

            if (!officeId || !roleId || !officerId || !registrationType) {
                alert('Please select Office, Role, Officer, and Registration Type.');
                return;
            }

            // Save selections to localStorage
            localStorage.setItem('office_id', officeId);
            localStorage.setItem('role_id', roleId);
            localStorage.setItem('officer_id', officerId);
            localStorage.setItem('registration_type', registrationType);

            // Set flag to preserve filters on return
            sessionStorage.setItem('preserveFilters', 'true');

            let url = 'officer-applications/' + officerId +
                '?type=' + registrationType +
                '&fromDate=' + fromDate +
                '&toDate=' + toDate;

            window.location.href = url;
        }

        /* Load Officers by Role */
        function loadOfficers(roleId, callback) {
            var officeId = document.getElementById('office_id').value;
            var officerSelect = document.getElementById('officer_id');

            officerSelect.innerHTML = '<option value="">Loading...</option>';

            if (!roleId || !officeId) {
                officerSelect.innerHTML = '<option value="">-- Select Officer --</option>';
                return;
            }

            // Save role selection
            localStorage.setItem('role_id', roleId);

            fetch('/admin/get-application-status-by-role/' + roleId + '?office=' + officeId)
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    officerSelect.innerHTML = '<option value="">-- Select Officer --</option>';

                    if (!data.officers || data.officers.length === 0) {
                        officerSelect.innerHTML += '<option value="">No officers found</option>';
                        return;
                    }

                    data.officers.forEach(function(o) {
                        officerSelect.innerHTML += '<option value="' + o.id + '">' + o.firstname + ' ' + o
                            .lastname + '</option>';
                    });

                    if (callback) callback();
                });
        }

        /* Load Roles by Office */
        function loadRoles(officeId, callback) {
            var roleSelect = document.getElementById('role_id');
            var officerSelect = document.getElementById('officer_id');

            roleSelect.innerHTML = '<option value="">-- Select Role --</option>';
            officerSelect.innerHTML = '<option value="">-- Select Officer --</option>';

            if (!officeId) return;

            // Save office selection
            localStorage.setItem('office_id', officeId);

            fetch('/admin/get-roles-by-office/' + officeId)
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    if (data.length === 0) {
                        roleSelect.innerHTML += '<option value="">No roles for this office</option>';
                        return;
                    }

                    data.forEach(function(role) {
                        roleSelect.innerHTML += '<option value="' + role.id + '">' + role.name + '</option>';
                    });

                    if (callback) callback();
                });
        }

        //Export in index.blade.php file
        function runExport(format) {
            // Get values from dropdowns
            const officeId = document.getElementById('office_id').value;
            const roleId = document.getElementById('role_id').value;
            const officerId = document.getElementById('officer_id').value;
            const regType = document.getElementById('registration_type').value;
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;

            // Build the query string
            let baseUrl = "{{ route('admin.export-combined-application-status', '') }}/" + format;
            let params = new URLSearchParams({
                office_id: officeId,
                role_id: roleId,
                officer_id: officerId,
                registration_type: regType,
                fromDate: fromDate,
                toDate: toDate
            });

            window.location.href = baseUrl + '?' + params.toString();
        }

        function runRoleBasedExport() {
            const officeId = document.getElementById('office_id').value;
            const roleId = document.getElementById('role_id').value;

            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;

            if (!officeId || !roleId) {
                alert('Please select Office and Role.');
                return;
            }

            let baseUrl = "{{ route('admin.export-office-role-applications') }}";

            let params = new URLSearchParams({
                office_id: officeId,
                role_id: roleId, // ✅ SAME AS OLD SYSTEM
                fromDate: fromDate,
                toDate: toDate
            });

            window.location.href = baseUrl + '?' + params.toString();
        }

        function toggleExportButton() {
            const office = document.getElementById('office_id').value;
            const role = document.getElementById('role_id').value;
            const officer = document.getElementById('officer_id').value;
            const type = document.getElementById('registration_type').value;

            const exportBtn = document.getElementById('exportBtn');

            // ✅ Enable ONLY if office + role selected
            // ❌ Disable if officer or type is selected
            if (office && role && !officer && !type) {
                exportBtn.disabled = false;
                exportBtn.classList.remove('btn-disabled');
            } else {
                exportBtn.disabled = true;
                exportBtn.classList.add('btn-disabled');
            }
        }
    </script>
    <script>
        function runOneClickExport(role, regType) {
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;

            if (!fromDate || !toDate) {
                alert('Please select From Date and To Date.');
                return;
            }

            let baseUrl = "{{ route('admin.application-status.one-click-export') }}";

            let params = new URLSearchParams({
                role: role,
                type: regType,
                fromDate: fromDate,
                toDate: toDate
            });

            window.location.href = baseUrl + '?' + params.toString();
        }
    </script>
@endsection
