{{-- @extends('layouts.admin-app')

@section('title', 'Applications Received by ' . ($user->firstname . ' ' . $user->lastname ?? 'Officer'))

@section('style')
    <style>
        :root {
            --primary-blue: #1a73e8;
            --primary-blue-dark: #1557b0;
            --success-green: #34a853;
            --danger-red: #ea4335;
            --warning-orange: #ff6b35;
            --light-gray: #f8f9fa;
            --border-gray: #dadce0;
            --text-dark: #202124;
            --text-medium: #5f6368;
            --white: #ffffff;
        }

        .officer-header {
            background: var(--white);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-blue);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            border-radius: 2px;
        }

        .officer-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-blue-dark);
            margin: 0;
        }

        .filter-info {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: #e8f0fe;
            border-radius: 20px;
            margin-top: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary-blue);
        }

        .applications-table-wrapper {
            background: var(--white);
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            border-radius: 2px;
            overflow-x: auto;
        }

        .table-officer {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .table-officer thead {
            background: var(--primary-blue);
            color: var(--white);
        }

        .table-officer thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            white-space: nowrap;
        }

        .table-officer tbody tr {
            transition: background 0.2s ease;
            border-bottom: 1px solid var(--border-gray);
        }

        .table-officer tbody tr:nth-child(even) {
            background: var(--light-gray);
        }

        .table-officer tbody tr:hover {
            background: #e8f0fe;
        }

        .table-officer tbody td {
            padding: 1rem;
            color: var(--text-dark);
            border: 1px solid var(--border-gray);
        }

        .rank-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .rank-received {
            background: #e8f0fe;
            color: var(--primary-blue);
        }

        .rank-action {
            background: #e6f4ea;
            color: var(--success-green);
        }

        .fifo-compliant {
            background: var(--success-green);
            color: white;
        }

        .fifo-non-compliant {
            background: var(--danger-red);
            color: white;
        }

        .fifo-pending {
            background: var(--warning-orange);
            color: white;
        }

        .duration-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .duration-normal {
            background: #e6f4ea;
            color: var(--success-green);
        }

        .duration-warning {
            background: #fef3e0;
            color: var(--warning-orange);
        }

        .duration-critical {
            background: #fce8e6;
            color: var(--danger-red);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-medium);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: var(--primary-blue);
            color: white;
            text-decoration: none;
            border-radius: 2px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
        }

        .back-button:hover {
            background: var(--primary-blue-dark);
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <a href="{{ route('admin.get-application-status') }}?fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
            class="btn btn-secondary btn-sm">
            ← Back to Dashboard
        </a>


        <div class="officer-header">
            <h2 class="officer-name">Applications Received by {{ $user->firstname . ' ' . $user->lastname }}</h2>
            <p style="color: var(--text-medium); margin: 0.5rem 0 0 0;">
                Total Applications: <strong>{{ $applications->count() }}</strong>
                @if (isset($registrationType) && $registrationType)
                    <span class="filter-info">
                        📋 Filter: {{ $registrationType === 'onboarding' ? 'Onboarding' : 'New Registration' }}
                    </span>
                @endif
            </p>
        </div>

        <div class="applications-table-wrapper">
            <div class="col-8"><a
                    href="{{ route('admin.export-application-status', 'csv') }}?user={{ $user->id }}&type={{ request('type') }}&fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
                    class="btn btn-secondary btn-sm">CSV</a>

                <a href="{{ route('admin.export-application-status', 'xlsx') }}?user={{ $user->id }}&type={{ request('type') }}&fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
                    class="btn btn-secondary btn-sm">Excel</a>
                <a href="{{ route('admin.export-application-status', 'pdf') }}?user={{ $user->id }}&type={{ request('type') }}&fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
                    class="btn btn-danger btn-sm">PDF</a>


            </div>



            <table class="table-officer">
                <thead>
                    <tr>
                        <th>Application No</th>
                        <th>Registration Type</th>
                        <th>Date of Received</th>
                        <th>Duration (Days)</th>
                        <th>Rank in Received Order</th>
                        <th>Action Taken Date</th>
                        <th>Rank (Action Taken)</th>
                        <th>FIFO Compliant</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        @php
                            $duration = \Carbon\Carbon::parse($app->created_at)->diffInDays(\Carbon\Carbon::now());
                            $durationClass =
                                $duration <= 7
                                    ? 'duration-normal'
                                    : ($duration <= 30
                                        ? 'duration-warning'
                                        : 'duration-critical');


                            $isOnboarding = $app->mainWorker && $app->mainWorker->already_registered == 1;
                            $regType = $isOnboarding ? 'Onboarding' : 'New Registration';


                            $actionTakenDate = $app->updated_at != $app->created_at ? $app->updated_at : null;


                            $fifoStatus = $app->fifo_status;

                            $fifoClass = match ($fifoStatus) {
                                'Yes' => 'fifo-compliant',
                                'No' => 'fifo-non-compliant',
                                default => 'fifo-pending',
                            };

                        @endphp
                        <tr>
                            <td><strong>{{ $app->application_no ?? 'N/A' }}</strong></td>
                            <td>
                                <span class="rank-badge {{ $isOnboarding ? 'rank-action' : 'rank-received' }}">
                                    {{ $regType }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($app->created_at)->format('d-m-Y h:i A') }}</td>
                            <td>
                                <span class="duration-badge {{ $durationClass }}">
                                    {{ $duration }} days
                                </span>
                            </td>
                            <td>
                                <span class="rank-badge rank-received">
                                    #{{ $app->received_rank }}
                                </span>
                            </td>
                            <td>
                                @if ($actionTakenDate)
                                    {{ \Carbon\Carbon::parse($actionTakenDate)->format('d-m-Y h:i A') }}
                                @else
                                    <span style="color: var(--text-medium);">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if (isset($app->action_taken_rank))
                                    <span class="rank-badge rank-action">
                                        #{{ $app->action_taken_rank }}
                                    </span>
                                @else
                                    <span style="color: var(--text-medium);">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="rank-badge {{ $fifoClass }}">
                                    {{ $fifoStatus }}
                                </span>
                            </td>

                            <td><strong>{{ $app->status_text }}</strong></td>



                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <div style="font-size: 3rem; opacity: 0.3;">📋</div>
                                <p>No applications found for this
                                    officer{{ isset($registrationType) && $registrationType ? ' with selected filter' : '' }}.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection --}}

@extends('layouts.admin-app')

@section('title', 'Applications Received by ' . ($user->firstname . ' ' . $user->lastname ?? 'Officer'))

@section('style')
    <style>
        :root {
            --primary-blue: #1a73e8;
            --primary-blue-dark: #1557b0;
            --success-green: #34a853;
            --danger-red: #ea4335;
            --warning-orange: #ff6b35;
            --light-gray: #f8f9fa;
            --border-gray: #dadce0;
            --text-dark: #202124;
            --text-medium: #5f6368;
            --white: #ffffff;
        }

        .officer-header {
            background: var(--white);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-blue);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            border-radius: 2px;
        }

        .officer-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-blue-dark);
            margin: 0;
        }

        .filter-info {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: #e8f0fe;
            border-radius: 20px;
            margin-top: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary-blue);
        }

        .applications-table-wrapper {
            background: var(--white);
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            border-radius: 2px;
            overflow-x: auto;
        }

        .table-officer {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .table-officer thead {
            background: var(--primary-blue);
            color: var(--white);
        }

        .table-officer thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            white-space: nowrap;
        }

        .table-officer tbody tr {
            transition: background 0.2s ease;
            border-bottom: 1px solid var(--border-gray);
        }

        .table-officer tbody tr:nth-child(even) {
            background: var(--light-gray);
        }

        .table-officer tbody tr:hover {
            background: #e8f0fe;
        }

        .table-officer tbody td {
            padding: 1rem;
            color: var(--text-dark);
            border: 1px solid var(--border-gray);
        }

        .rank-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .rank-received {
            background: #e8f0fe;
            color: var(--primary-blue);
        }

        .rank-action {
            background: #e6f4ea;
            color: var(--success-green);
        }

        .fifo-compliant {
            background: var(--success-green);
            color: white;
        }

        .fifo-non-compliant {
            background: var(--danger-red);
            color: white;
        }

        .fifo-pending {
            background: var(--warning-orange);
            color: white;
        }

        .duration-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .duration-normal {
            background: #e6f4ea;
            color: var(--success-green);
        }

        .duration-warning {
            background: #fef3e0;
            color: var(--warning-orange);
        }

        .duration-critical {
            background: #fce8e6;
            color: var(--danger-red);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-medium);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: var(--primary-blue);
            color: white;
            text-decoration: none;
            border-radius: 2px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
        }

        .back-button:hover {
            background: var(--primary-blue-dark);
            color: white;
        }


        /* History Button */
        .btn-history {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.75rem;
            background: #e8f0fe;
            color: var(--primary-blue);
            border: 1px solid #c5d8fb;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .btn-history:hover {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding: 1rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 28px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e0e7ff;
        }

        .timeline-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.25rem;
            position: relative;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            z-index: 1;
            border: 2px solid white;
            box-shadow: 0 0 0 2px #c7d2fe;
        }

        .icon-submitted {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .icon-forwarded {
            background: #d1fae5;
            color: #065f46;
        }

        .icon-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .icon-approved {
            background: #bbf7d0;
            color: #14532d;
        }

        .icon-reverted {
            background: #fef3c7;
            color: #92400e;
        }

        .icon-default {
            background: #e0e7ff;
            color: #3730a3;
        }

        .timeline-content {
            background: #f8faff;
            border: 1px solid #e0e7ff;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            flex: 1;
        }

        .timeline-status {
            font-weight: 700;
            font-size: 0.875rem;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
        }

        .timeline-meta {
            font-size: 0.8rem;
            color: var(--text-medium);
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem 1.25rem;
        }

        .modal-title-app {
            font-size: 1rem;
            font-weight: 700;
            color: white;
        }

        .modal-app-no {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <a href="{{ route('admin.get-application-status') }}?fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
            class="btn btn-secondary btn-sm">
            ← Back to Dashboard
        </a>

        <div class="officer-header">
            <h2 class="officer-name">Applications Received by {{ $user->firstname . ' ' . $user->lastname }}</h2>
            <p style="color: var(--text-medium); margin: 0.5rem 0 0 0;">
                Total Applications: <strong>{{ $applications->count() }}</strong>
                @if (isset($registrationType) && $registrationType)
                    <span class="filter-info">
                        📋 Filter: {{ $registrationType === 'onboarding' ? 'Onboarding' : 'New Registration' }}
                    </span>
                @endif
            </p>
        </div>

        <div class="applications-table-wrapper">
            <div class="col-8">
                <a href="{{ route('admin.export-application-status', 'csv') }}?user={{ $user->id }}&type={{ request('type') }}&fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
                    class="btn btn-secondary btn-sm">CSV</a>

                <a href="{{ route('admin.export-application-status', 'xlsx') }}?user={{ $user->id }}&type={{ request('type') }}&fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
                    class="btn btn-secondary btn-sm">Excel</a>

                <a href="{{ route('admin.export-application-status', 'pdf') }}?user={{ $user->id }}&type={{ request('type') }}&fromDate={{ request('fromDate') }}&toDate={{ request('toDate') }}"
                    class="btn btn-danger btn-sm">PDF</a>
            </div>

            <table class="table-officer">
                <thead>
                    <tr>
                        <th>Application No</th>
                        <th>Registration Type</th>
                        {{-- <th>Forwarded From</th> --}}
                        <th>Date of Received</th>
                        <th>Duration (Days)</th>
                        <th>Rank in Received Order</th>
                        <th>Action Taken Date</th>
                        <th>Rank (Action Taken)</th>
                        <th>FIFO Compliant</th>
                        <th>Status</th>
                        <th>History</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        @php
                            // Calculate duration from original received date
                            $duration = \Carbon\Carbon::parse($app->original_received_at)->diffInDays(
                                \Carbon\Carbon::now(),
                            );
                            $durationClass =
                                $duration <= 7
                                    ? 'duration-normal'
                                    : ($duration <= 30
                                        ? 'duration-warning'
                                        : 'duration-critical');

                            // Determine registration type
                            $isOnboarding = $app->mainWorker && $app->mainWorker->already_registered == 1;
                            $regType = $isOnboarding ? 'Onboarding' : 'New Registration';

                            // Determine FIFO compliance
                            $fifoStatus = $app->fifo_status;

                            $fifoClass = match ($fifoStatus) {
                                'Yes' => 'fifo-compliant',
                                'No' => 'fifo-non-compliant',
                                default => 'fifo-pending',
                            };

                        @endphp
                        <tr>
                            <td><strong>{{ $app->application_no ?? 'N/A' }}</strong></td>
                            <td>
                                <span class="rank-badge {{ $isOnboarding ? 'rank-action' : 'rank-received' }}">
                                    {{ $regType }}
                                </span>
                            </td>
                            {{-- <td>{{ $app->forwarded_from_display }}</td> --}}
                            <td>{{ \Carbon\Carbon::parse($app->original_received_at)->format('d-m-Y h:i A') }}</td>
                            <td>
                                <span class="duration-badge {{ $durationClass }}">
                                    {{ $duration }} days
                                </span>
                            </td>
                            <td>
                                <span class="rank-badge rank-received">
                                    #{{ $app->received_rank }}
                                </span>
                            </td>
                            <td>
                                @if ($app->has_action_taken && $app->latest_updated_at)
                                    {{ \Carbon\Carbon::parse($app->latest_updated_at)->format('d-m-Y h:i A') }}
                                @else
                                    <span style="color: var(--text-medium);">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if ($app->has_action_taken && isset($app->action_taken_rank))
                                    <span class="rank-badge rank-action">
                                        #{{ $app->action_taken_rank }}
                                    </span>
                                @else
                                    <span style="color: var(--text-medium);">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="rank-badge {{ $fifoClass }}">
                                    {{ $fifoStatus }}
                                </span>
                            </td>
                            <td><strong>{{ $app->status_text }}</strong></td>
                            <td>
                                <button class="btn-history view-history-btn" data-app-no="{{ $app->application_no }}">
                                    🕓 History
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="empty-state">
                                <div style="font-size: 3rem; opacity: 0.3;">📋</div>
                                <p>No applications found for this
                                    officer{{ isset($registrationType) && $registrationType ? ' with selected filter' : '' }}.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- ✅ History Modal --}}
    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <div class="modal-header" style="background: var(--primary-blue); border: none; padding: 1rem 1.5rem;">
                    <div>
                        <div class="modal-title-app">Application History</div>
                        <div class="modal-app-no" id="historyModalAppNo"></div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="historyModalBody" style="padding: 1.5rem; max-height: 70vh; overflow-y: auto;">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted">Loading history...</p>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e0e7ff; padding: 0.75rem 1.5rem;">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@section('footer')
<script>
$(document).ready(function() {

    const iconMap = {
        'A': { cls: 'icon-submitted', symbol: '📝' },
        'B': { cls: 'icon-forwarded', symbol: '➡️' },
        'C': { cls: 'icon-forwarded', symbol: '➡️' },
        'D': { cls: 'icon-rejected',  symbol: '✖'  },
        'E': { cls: 'icon-reverted',  symbol: '↩'  },
        'F': { cls: 'icon-approved',  symbol: '✔'  },
        'G': { cls: 'icon-reverted',  symbol: '↩'  },
        'H': { cls: 'icon-reverted',  symbol: '↩'  },
        'O': { cls: 'icon-default',   symbol: '🏢' },
        'M': { cls: 'icon-default',   symbol: '👤' },
        'N': { cls: 'icon-default',   symbol: '👤' },
        'R': { cls: 'icon-forwarded', symbol: '🔄' },
        'X': { cls: 'icon-rejected',  symbol: '✖'  },
    };

    // ── Open modal + load history ────────────────────────────────
    $(document).on('click', '.view-history-btn', function() {
        const appNo = $(this).data('app-no');

        $('#historyModalAppNo').text('App No: ' + appNo);
        $('#historyModalBody').html(
            '<div class="text-center py-4">' +
            '<div class="spinner-border text-primary" role="status"></div>' +
            '<p class="mt-2 text-muted">Loading history...</p>' +
            '</div>'
        );

        $('#historyModal').addClass('show').css('display', 'block');
        $('body').addClass('modal-open');
        $('<div class="modal-backdrop fade show"></div>').appendTo('body');

        $.ajax({
            url: '{{ route('admin.application-history', ':appNo') }}'.replace(':appNo', appNo),
            type: 'GET',
            success: function(response) {
                if (!response.success || !response.history.length) {
                    $('#historyModalBody').html(
                        '<div class="alert alert-info">No history found for this application.</div>'
                    );
                    return;
                }

                var html = '<div class="timeline">';

                response.history.forEach(function(item, index) {
                    var icon   = iconMap[item.status_raw] || { cls: 'icon-default', symbol: '•' };
                    var isLast = index === response.history.length - 1;

                    // ── Build To section — completely hidden for terminal statuses ──
                    var toSection = '';
                    if (item.is_terminal !== true) {
                        var toVal = item.to ? String(item.to).trim() : '';
                        if (toVal !== '' && toVal !== 'null' && toVal !== 'undefined') {
                            toSection = '<span>➡️ <strong>To:</strong>&nbsp;' + toVal + '</span>';
                        }
                    }

                    html += '<div class="timeline-item">';
                    html += '<div class="timeline-icon ' + icon.cls + '">' + icon.symbol + '</div>';
                    html += '<div class="timeline-content"' + (isLast ? ' style="border-color:#bbf7d0;background:#f0fdf4;"' : '') + '>';
                    html += '<div class="timeline-status">' + item.status + '</div>';
                    html += '<div class="timeline-meta">';
                    html += '<span>👤 <strong>From:</strong>&nbsp;' + item.from + '</span>';
                    html += toSection;
                    html += '<span>🕓&nbsp;' + item.date + '</span>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                });

                html += '</div>';
                $('#historyModalBody').html(html);
            },
            error: function() {
                $('#historyModalBody').html(
                    '<div class="alert alert-danger">Failed to load history. Please try again.</div>'
                );
            }
        });
    });

    // ── Close modal ──────────────────────────────────────────────
    $(document).on('click', '[data-dismiss="modal"]', function() {
        $('#historyModal').removeClass('show').css('display', 'none');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    $(document).on('click', '.modal-backdrop', function() {
        $('#historyModal').removeClass('show').css('display', 'none');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#historyModal').hasClass('show')) {
            $('#historyModal').removeClass('show').css('display', 'none');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
    });

});
</script>
@endsection
@endsection
