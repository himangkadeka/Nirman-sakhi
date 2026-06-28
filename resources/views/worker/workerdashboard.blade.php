@include('layout.workerheader')

<!-- Professional Font: Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Modern visual refresh — only CSS, no HTML changes */

    :root {
        --primary: #0d6efd;
        --muted: #64748b;
        --bg: #f4f7fa;
        --card: #ffffff;
        --accent-1: #667eea;
        --accent-2: #764ba2;
        --surface-border: #e6eefc;
    }

    body {
        background: linear-gradient(180deg, var(--bg), #ffffff 60%);
        color: #0f1724;
        font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, Arial;
        -webkit-font-smoothing: antialiased;
    }

    /* Header */
    .dashboard-header {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(255, 255, 255, 0.9));
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 12px 22px;
        margin-bottom: 18px;
        box-shadow: 0 10px 30px rgba(2, 6, 23, 0.04);
        align-items: center;
    }

    #session-timer {
        border-radius: 999px;
        padding: 6px 14px;
        font-weight: 700;
        background: linear-gradient(90deg, #fff7f8, #fff);
        color: #b91c1c;
        border: 1px solid #fecdd3;
        box-shadow: 0 6px 20px rgba(185, 28, 28, 0.05);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Card containers */
    .rounded-card {
        background: var(--card);
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.04);
        box-shadow: 0 18px 40px rgba(2, 6, 23, 0.05);
        overflow: hidden;
        margin-bottom: 18px;
    }

    .section-header-govt {
        background: linear-gradient(90deg, var(--govt-navy), #0b4a5b);
        color: #fff;
        padding: 14px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        box-shadow: inset 0 -2px 0 rgba(255, 255, 255, 0.02);
    }

    .section-header-govt h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    /* Details grid */
    .detail-grid {
        display: grid;
        gap: 16px;
        padding: 20px;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    .detail-item {
        background: linear-gradient(180deg, #fff, #fbfdff);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px 14px;
        box-shadow: 0 8px 22px rgba(102, 126, 234, 0.03);
        border-bottom: 4px solid #ccc;
    }

    .detail-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        margin-bottom: 6px;
        letter-spacing: 0.04em;
    }

    .detail-value {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #071123;
    }

    /* Badges */
    .badge-pill-govt {
        padding: 6px 12px;
        border-radius: 999px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .bg-active-pill {
        background: #ecfccb;
        color: #166534;
        border: 1px solid #d9f99d;
    }

    .bg-expired-pill {
        background: #fff1f2;
        color: #9f1239;
        border: 1px solid #fecaca;
    }

    .bg-warning-pill {
        background: #fffbeb;
        color: #92400e;
        border: 1px solid #fef3c7;
    }

    .bg-download-pill {
        background: #f8fafc;
        color: #f97316;
        border: 1px solid #fbe6d6;
    }

    .bg-submit-pill {
         background: #e6eefc;
         color: #0f1724;
         border: 1px solid #dbeafe;
     }
    .bg-apply-pill {
        background: #000000;
        color: #DBEAFE;
        border: 1px solid #dbeafe;
        text-decoration: none;
    }

    /* Tables and containers */


    .govt-table thead th {
        background: linear-gradient(90deg, var(--govt-navy), #0b4a5b);
        color: #fff;
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        padding: 12px 14px;
    }

    .govt-table tbody td {
        padding: 12px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        background: transparent;
    }

    .govt-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.03), rgba(118, 75, 162, 0.02));
        transform: translateY(-2px);
        transition: all .18s ease;
    }

    /* Notice & download sections */
    .notice-card-govt {
        background: linear-gradient(180deg, #fff7f3, #fff9f0);
        border: 1px solid #fcd29b;
        padding: 12px 14px;
        border-radius: 10px;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .download-section {
        background: linear-gradient(90deg, #f1fbff, #ffffff);
        border: 1px dashed rgba(13, 110, 253, 0.12);
        padding: 16px;
        border-radius: 10px;
        text-align: center;
        margin: 12px 0;
    }

    .btn-govt-primary,
    .btn-primary {
        background: linear-gradient(90deg, var(--govt-blue), #064e9a);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        font-weight: 700;
        box-shadow: 0 10px 28px rgba(6, 78, 154, 0.12);
        transition: transform .14s, box-shadow .14s;
    }

    .btn-govt-primary:hover,
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 40px rgba(6, 78, 154, 0.16);
    }

    .payment-cta-box {
        background: linear-gradient(180deg, #fffaf0, #fff8f0);
        border-radius: 10px;
        padding: 16px;
        border: 2px dashed #f6ad55;
        text-align: center;
    }

    .profile-details-box {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px;
        box-shadow: 0 10px 30px rgba(2, 6, 23, 0.03);
    }
    button.grievance{
            background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
    color: white;
    padding: 10px;
    }

    /* Compact table for small screens */
    @media (max-width: 767.98px) {
        .detail-grid {
            grid-template-columns: 1fr;
            padding: 12px;
            gap: 12px;
        }

        .dashboard-header {
            padding: 10px 12px;
        }

        .govt-table thead th {
            font-size: 0.72rem;
            padding: 10px;
        }

        .govt-table tbody td {
            padding: 10px;
            font-size: 0.95rem;
        }

        .download-section {
            padding: 12px;
        }
    }
</style>

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background:transparent; padding:0;">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active">Overview</li>
                </ol>
            </nav>
            <span id="session-timer" class="shadow-sm">
                <i class="fas fa-clock me-1"></i> Session : --:--
            </span>
        </div>

        @php $current_date = now(); @endphp

        <div class="container worker-dashboard">
            @if ($wmf->already_registered == 1)
                <div class="rounded-card">
                    <div class="card-body p-0">
                        <div class="worker-profile">
                            <!-- Profile Overview Section -->
                            <section>
                                <div class="section-header-govt">
                                    <h3><i class="fa fa-user-shield me-2"></i> Profile Overview</h3>
                                    <span class="badge bg-success px-3 py-2">ID Card: {{ $wmf->id_card }}</span>
                                </div>

                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <span class="detail-label">Beneficiary Name</span>
                                        <p class="detail-value">{{ $getVaultData['name'] }}</p>
                                    </div>
                                    <div class="detail-item">
                                        <p class="detail-label">Date of Birth</p>
                                        <p class="detail-value">{{ $getVaultData['dob'] }}</p>
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Membership Status</span>
                                        <div class="mt-1">

                                            @if ($wmf->active_status == '2')
                                                <span class="badge-pill-govt bg-expired-pill">Suspended</span>
                                            @elseif (\Carbon\Carbon::parse($wmf->date_of_retirement)->lt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge-pill-govt bg-expired-pill">Retired</span>
                                                <p class="text-muted small mt-1">Retired on
                                                    {{ \Carbon\Carbon::parse($wmf->date_of_retirement)->format('d-m-Y') }}
                                                </p>
                                            @elseif (!$isRenewApplied && \Carbon\Carbon::parse($wmf->id_card_expiry_date)->lt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge-pill-govt bg-expired-pill">Expired</span>
                                                <p class="text-muted small mt-1">Expired on
                                                    {{ \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') }}
                                                </p>
                                            @elseif($isRenewApplied && \Carbon\Carbon::parse($wmf->id_card_expiry_date)->lt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge-pill-govt bg-expired-pill">Renewal Applied</span>
                                                <p class="text-muted small mt-1">Expired on
                                                    {{ \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') }}
                                                </p>
                                            @elseif (\Carbon\Carbon::parse($wmf->subscription_validity_date)->gt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge-pill-govt bg-expired-pill">Active</span>
                                                {{-- @elseif($wmf->active_status == '1' && $is_paid) --}}
                                                {{-- <span class="badge-pill-govt bg-active-pill">Active</span> --}}
                                            @elseif($wmf->active_status == '1' && !$is_paid && !$isRenewalApproved)
                                                <span class="badge-pill-govt bg-expired-pill">Expired</span>
                                            @elseif($wmf->active_status == '1' && $isRenewalApproved && !$is_app_paid)
                                                <span class="badge-pill-govt bg-expired-pill">Inactive</span>
                                            @elseif (\Carbon\Carbon::parse($wmf->subscription_validity_date)->lt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge-pill-govt bg-warning-pill">Payment Lapsed</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Subscription Paid Upto</span>
                                        <p class="detail-value">
                                            @if ($is_retired)
                                                {{ \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') }}
                                            @elseif(!$first_paid && !$is_paid)
                                                {{ \Carbon\Carbon::parse($wmf->subscription_validity_date)->format('d-m-Y') }}
                                            @elseif($first_paid && !$is_paid)
                                                {{ \Carbon\Carbon::parse($last_sub)->format('d-m-Y') }}
                                            @elseif($first_paid && $is_paid)
                                                {{ \Carbon\Carbon::parse($wmf->subscription_validity_date)->format('d-m-Y') }}
                                            @endif
                                        </p>
                                    </div>

                                    @if (!$is_retired)
                                        <div class="detail-item">
                                            <span class="detail-label">Date of Renewal</span>
                                            <p class="detail-value">
                                                {{ \Carbon\Carbon::parse($wmf->id_card_expiry_date)->addDay()->format('d-m-Y') }}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="detail-item">
                                        <span class="detail-label">Date of Registration</span>
                                        <p class="detail-value">
                                            {{ \Carbon\Carbon::parse($wmf->last_registration_date)->format('d-m-Y') }}
                                        </p>
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Date of Retirement</span>
                                        <p class="detail-value">
                                            {{ \Carbon\Carbon::parse($wmf->date_of_retirement)->format('d-m-Y') }}</p>
                                    </div>

                                    @if ($isRenewApplied)
                                        <div class="detail-item">
                                            <span class="detail-label">Extended Validity (After Approval)</span>
                                            <p class="detail-value">
                                                @php
                                                    if (
                                                        !empty($wmf->renewal_date) &&
                                                        !empty($wmf->date_of_retirement)
                                                    ) {
                                                        $today = \Carbon\Carbon::today();
                                                        $cardValidityDate = \Carbon\Carbon::parse(
                                                            $wmf->id_card_expiry_date,
                                                        );
                                                        $retirementDate = \Carbon\Carbon::parse(
                                                            $wmf->date_of_retirement,
                                                        );
                                                        while ($cardValidityDate->lt($today)) {
                                                            $cardValidityDate->addYears(2);
                                                        }
                                                        $finalDate = $retirementDate->lte($cardValidityDate)
                                                            ? $retirementDate
                                                            : $cardValidityDate;
                                                        echo $finalDate->format('d-m-Y');
                                                    } else {
                                                        echo 'NA';
                                                    }
                                                @endphp
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Alerts -->
                                <div class="px-4">
                                    @if ($isRenewal)
                                        @if (\Carbon\Carbon::parse($wmf->subscription_validity_date)->lt(\Carbon\Carbon::parse($wmf->id_card_expiry_date)))
                                            <div class="notice-card-govt">
                                                <span class="text-danger fw-bold"><i
                                                        class="fa fa-exclamation-triangle me-2"></i>Please clear your
                                                    pending subscription dues before renewal</span>
                                                <a href="{{ route('worker-subscription-new') }}"
                                                    class="btn btn-sm btn-primary ms-3 bounce-button">Click Here <i
                                                        class="fa fa-share-square-o"></i></a>
                                            </div>
                                        @endif

                                        @if (\Carbon\Carbon::parse($wmf->subscription_validity_date)->equalTo(\Carbon\Carbon::parse($wmf->id_card_expiry_date)))
                                            @if ($isSubscriptionApplied)
                                                @if ($is_paid)
                                                    <div class="alert alert-success border-0 py-2"><i
                                                            class="fa fa-check-square-o me-2"></i>Subscription Dues
                                                        Cleared Up to
                                                        {{ \Carbon\Carbon::parse($wmf->subscription_validity_date)->format('d-m-Y') }}
                                                    </div>
                                                @else
                                                    <div class="notice-card-govt"><span
                                                            class="text-dark fw-bold">Subscription Payment is
                                                            Pending</span> <a href="{{ route('my-subscription') }}"
                                                            class="btn btn-sm btn-outline-danger ms-3 bounce-button">Click
                                                            Here <i class="fa fa-share-square-o"></i></a></div>
                                                @endif
                                            @endif

                                            @if (\Carbon\Carbon::parse($wmf->id_card_expiry_date)->lessThan(\Carbon\Carbon::today()))
                                                <div class="notice-card-govt">
                                                    @if ($isWorkbookApplied)
                                                        <span class="text-dark fw-bold">Your Renewal Application is
                                                            Pending</span> <a href="{{ route('renew-application') }}"
                                                            class="btn btn-sm btn-warning ms-3 bounce-button">Complete
                                                            <i class="fa fa-share-square-o"></i></a>
                                                    @else
                                                        <span class="text-dark fw-bold">ID Card Expired on
                                                            {{ \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') }}
                                                            — Please Renew!</span> <a
                                                            href="{{ route('renew-application') }}"
                                                            class="btn btn-sm btn-outline-danger ms-3 bounce-button">Click
                                                            Here <i class="fa fa-share-square-o"></i></a>
                                                    @endif
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </section>

                            @if ($isRenewApplied)
                                <section class="p-4 border-top">
                                    <div class="rounded-card border-0 shadow-none mb-0">
                                        <div class="card-highlight-blue p-3 rounded">
                                            <h6 class="fw-bold mb-3"><i
                                                    class="bi bi-clock-history text-primary me-2"></i> Renewal
                                                Application Status</h6>

                                            @if ($renewal_status)
                                                <div class="govt-table-container">
                                                    <table class="table govt-table mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th>Status</th>
                                                            <th>Date</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                @if ($renewal_status->status == 'A')
                                                                    <span class="badge-pill-govt bg-submit-pill">Submitted</span>

                                                                @elseif($renewal_status->status == 'G')
                                                                    <span class="badge-pill-govt bg-expired-pill">Reverted</span>

                                                                @elseif($renewal_status->resubmit_status == 1)
                                                                    <span class="badge-pill-govt bg-warning-pill">Resubmitted</span>

                                                                @elseif($renewal_status->status == 'F')
                                                                    <span class="badge-pill-govt bg-active-pill">Approved</span>

                                                                @else
                                                                    <span class="badge-pill-govt bg-active-pill">Processing</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                {{ \Carbon\Carbon::parse($renewal_status->created_at)->format('d M Y, h:i A') }}
                                                            </td>

                                                            <td class="text-center">
                                                                @if ($renewal_status->status === 'A')
                                                                    <a href="{{ route('download-acknowledgement-renewal') }}"
                                                                       class="badge-pill-govt bg-submit-pill">
                                                                        <i class="fa fa-download"></i>&nbsp;Acknowledgement
                                                                    </a>

                                                                @elseif(
                                                                    $renewal_status->status === 'G')
                                                                    <a href="{{ route('renew-application') }}"
                                                                       class="badge-pill-govt bg-apply-pill">
                                                                        Re-submit
                                                                    </a>

                                                                @else
                                                                    <a href="#"
                                                                       class="badge-pill-govt bg-submit-pill">
                                                                        <i class="fa fa-search"></i>&nbsp;History
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted mb-0">No renewal status found.</p>
                                            @endif
                                        </div>
                                    </div>
                                </section>
                            @endif

                            <!-- ID Card Download Logic (INTEGRATED HERE) -->
                            <!-- ID Card Download Logic (INTEGRATED HERE) -->
                            <section class="border-top pb-2">
                                @if ($isRenewalApproved && $wmf->active_status == 1 && !$is_app_paid)
                                    <div class="notice-card-govt mx-4 mt-4">
                                        <span class="text-dark fw-bold">Dear User, your Subscription Payment is
                                            Pending</span>
                                        <a href="{{ route('my-subscription') }}"
                                            class="btn btn-sm btn-outline-danger ms-3 bounce-button">Click Here to Pay
                                            <i class="fa fa-share-square-o"></i></a>
                                    </div>
                                @endif

                                @if ($isRenewalApproved)
                                    <div class="px-4 pt-4">
                                        @if ($is_retired)
                                            @if ($subscription_clear)
                                                @if ($wmf->status == 'F' && $wmf->active_status == 1 && $is_app_paid)
                                                    <div class="download-section">
                                                        <p class="detail-label">Your ID Card is ready</p>
                                                        <a href="{{ route('idcards.index') }}"
                                                            class="btn btn-govt-navy btn-primary px-4"><i
                                                                class="fa fa-download me-2"></i>Download ID Card</a>
                                                    </div>
                                                @endif
                                            @else
                                                @if ($is_app_paid && !$duesCleared)
                                                    <div class="notice-card-govt">
                                                        <span class="text-dark fw-bold">Subscription Payment
                                                            Required</span>
                                                        <a href="{{ route('worker-subscription-new') }}"
                                                            class="btn btn-sm btn-outline-danger ms-3">Click here to
                                                            Pay</a>
                                                    </div>
                                                    @if ($wmf->status == 'F' && $wmf->active_status == 1 && $is_app_paid)
                                                        <div class="download-section">
                                                            <p class="detail-label">Your ID Card is ready</p>
                                                            <div class="mt-3"><a
                                                                    href="{{ route('idcards.index') }}"
                                                                    class="btn btn-govt-navy btn-primary px-4"><i
                                                                        class="fa fa-download me-2"></i>Download ID
                                                                    Card</a></div>
                                                    @endif
                                                @endif
                                            @endif
                                        @else
                                            @if ($is_app_paid && !$duesCleared)

                                                <div class="download-section">
                                                    <p class="detail-label">Click bellow to Pay subscription</p>
                                                    <a href="{{ route('worker-subscription-new') }}"
                                                        class="btn btn-sm btn-outline-danger">Payment Link&nbsp;<i
                                                            class="fa fa-share-square-o"></i></a>
                                                </div>

                                                @if ($wmf->status == 'F' && $wmf->active_status == 1 && $is_app_paid)
                                                    <div class="download-section">
                                                        <p class="detail-label">Your ID Card is ready</p>
                                                        <a href="{{ route('idcards.index') }}"
                                                            class="btn btn-govt-navy btn-primary px-4"><i
                                                                class="fa fa-download me-2"></i>&nbsp;Download ID
                                                            Card</a>
                                                    </div>
                                                @endif
                                            @endif
                                            @if ($wmf->status == 'F' && $wmf->active_status == 1 && $is_app_paid && $duesCleared)
                                                <div class="download-section">
                                                    <p class="detail-label">Your ID Card is ready</p>
                                                    <a href="{{ route('idcards.index') }}"
                                                        class="btn btn-govt-navy btn-primary px-4"><i
                                                            class="fa fa-download me-2"></i>Download ID Card</a>
                                                </div>
                                            @endif
                                            {{--<div class="govt-table-container">--}}
                                                {{--<table class="table govt-table mb-0">--}}

                                                    {{--<thead>--}}
                                                        {{--<tr>--}}
                                                            {{--<th>Renewal Status</th>--}}
                                                            {{--<th>Date</th>--}}
                                                            {{--<th class="text-center">Action</th>--}}
                                                        {{--</tr>--}}
                                                    {{--</thead>--}}
                                                    {{--<tbody>--}}
                                                        {{--@foreach ($renewal_app_status as $status)--}}
                                                            {{--<tr>--}}
                                                                {{--<td>--}}
                                                                    {{--@if ($status->application_status === 'A')--}}
                                                                        {{--<span--}}
                                                                            {{--class="badge-pill-govt bg-submit-pill">Submitted</span>--}}
                                                                        {{-- @elseif($status->application_status === 'G') <span class="badge-pill-govt bg-expired-pill">Reverted</span> --}}
                                                                        {{-- @elseif($status->resubmit_status == 1) <span class="badge-pill-govt bg-warning-pill">Resubmitted</span> --}}
                                                                    {{--@elseif($status->application_status === 'F')--}}
                                                                        {{--<span--}}
                                                                            {{--class="badge-pill-govt bg-active-pill">Approved</span>--}}
                                                                    {{--@else--}}
                                                                        {{--<span--}}
                                                                            {{--class="badge-pill-govt bg-download-pill">Processing</span>--}}
                                                                    {{--@endif--}}
                                                                {{--</td>--}}
                                                                {{--<td>{{ \Carbon\Carbon::parse($status->created_at)->format('d M Y, h:i A') }}--}}
                                                                {{--</td>--}}
                                                                {{--<td class="text-center">--}}
                                                                    {{--@if ($status->application_status === 'A')--}}
                                                                        {{--<a href="{{ route('download-acknowledgement-renewal') }}"--}}
                                                                            {{--class="badge-pill-govt bg-download-pill"><i--}}
                                                                                {{--class="fa fa-download"></i>&nbsp;Acknowledgement</a>--}}
                                                                    {{--@elseif(--}}
                                                                        {{--$status->id === $latestStatus->id &&--}}
                                                                            {{--$latestStatus->application_status === 'G' &&--}}
                                                                            {{--$latestStatus->resubmit_status != 1)--}}
                                                                        {{--<a href="{{ route('renew-application') }}"--}}
                                                                            {{--class="btn btn-sm btn-outline-primary">Re-submit</a>--}}
                                                                    {{--@elseif($status->application_status === 'F')--}}
                                                                        {{--<span class="text-muted">Please pay membership--}}
                                                                            {{--amount to download new card</span>--}}
                                                                    {{--@endif--}}
                                                                {{--</td>--}}
                                                            {{--</tr>--}}
                                                        {{--@endforeach--}}
                                                    {{--</tbody>--}}
                                                {{--</table>--}}
                                            {{--</div>--}}
                                        @endif
                                    </div>
                                @endif
                            </section>

                            <!-- Available Schemes -->
                            <section class="p-4 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold m-0">Available Schemes</h5>


                                    {{-- <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Filter Schemes</button>
                                        <ul class="dropdown-menu border-0 shadow">
                                            <li><a class="dropdown-item" href="#">All Schemes</a></li>
                                            <li><a class="dropdown-item" href="#">Eligible</a></li>
                                        </ul>
                                    </div> --}}
                                </div>
                                <div class="govt-table-container">
                                    @if (\App\Models\Benefit::where('status', true)->count() > 0)
                                        @include('worker.benefits.components.benefit-list')
                                    @endif
                                    {{-- <table class="table govt-table table-hover">
                                        <thead><tr><th style="text-align:left">Scheme Name</th><th>Status</th><th>Actions</th></tr></thead>
                                        <tbody><tr><td colspan="3" class="text-center py-4 text-muted">No schemes available at the moment</td></tr></tbody>
                                    </table> --}}
                                </div>
                            </section>

                            <!-- Tracker -->
                            <section class="p-4 border-top">
                                <h5 class="fw-bold mb-3"><i class="bi bi-box2-heart"></i> Application Tracker</h5>
                                <div class="govt-table-container">
                                    <table class="table govt-table bg-white">
                                        <thead>
                                            <tr>
                                                <th>Application ID</th>
                                                <th>Scheme</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        @include('worker.benefits.components.application-tracker')
                                    </table>
                                </div>
                            </section>

                            <!-- Notifications -->
                            <section class="p-4 border-top">
                                <h5 class="fw-bold mb-3"><i class="bi bi-bell"></i> Notifications</h5>
                                <div class="alert alert-light border shadow-sm">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-megaphone text-primary fs-5 me-3 mt-1"></i>
                                        <div>
                                            <p class="mb-1 fw-bold">Penalty Waiver Notice</p>
                                            <p class="text-muted small mb-0">Penalty charges waived from 3rd July 2025
                                                to 2nd July 2026 as per ABOCWWB’s decision.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Grievance -->
                            <section class="p-4 border-top">
                                <h5 class="fw-bold mb-3"><i class="bi bi-bandaid"></i> Grievance Redressal</h5>
                                <div class="card border-0 bg-light p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-headset fs-2 text-primary me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Need assistance?</h6>
                                            <p class="mb-2 small text-muted">Our support team is here to help with any
                                                issues or questions.</p>
                                            <button class="btn grievance"><i
                                                    class="bi bi-plus-circle me-1"></i> Submit Grievance</button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            @else
                <!-- NEW-Registered Member Section -->

                <div class="container worker-dashboard">
                    <div class="card rounded-card shadow-sm border-0">
                        <div class="card-body p-0"> <!-- Removed padding to allow header to touch edges -->

                            <!-- Header Section with Dark Govt Bar -->
                            <div class="section-header-govt">
                                <h3><i class="fa fa-user-shield me-2"></i> Profile Overview</h3>
                                <span class="badge bg-success px-3 py-2">ID Card: {{ $wmf->id_card }}</span>
                            </div>

                            <div class="p-4">
                                <!-- Profile Details Grid -->
                                <div class="profile-details-box mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="detail-label">Beneficiary Name</p>
                                            <p class="detail-value text-uppercase">{{ $getVaultData['name'] }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="detail-label">Date of Birth</p>
                                            <p class="detail-value">{{ $getVaultData['dob'] }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="detail-label"><strong>Membership Status</strong></p>
                                            @if ($wmf->active_status == '2')
                                                <span class="badge-pill-govt bg-expired-pill">Suspended</span>
                                            @elseif (\Carbon\Carbon::parse($wmf->date_of_retirement)->lt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge-pill-govt bg-expired-pill">Retired</span>
                                                <p class="text-muted small mt-1">Retired on
                                                    {{ \Carbon\Carbon::parse($wmf->date_of_retirement)->format('d-m-Y') }}
                                                </p>
                                            @elseif (\Carbon\Carbon::parse($wmf->id_card_expiry_date)->lt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge-pill-govt bg-expired-pill">Expired</span>
                                                <p class="text-muted small mt-1">Expired on
                                                    {{ \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') }}
                                                </p>
                                            @elseif (\Carbon\Carbon::parse($wmf->subscription_validity_date)->gt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge-pill-govt bg-expired-pill">Active</span>
                                            @elseif($wmf->active_status == '1' && $is_paid)
                                                <span class="badge-pill-govt bg-expired-pill">Active</span>
                                            @elseif($wmf->active_status == '1' && !$is_paid && !$isRenewalApproved)
                                                <span class="badge-pill-govt bg-expired-pill">Expired</span>
                                            @elseif($wmf->active_status == '1' && $isRenewalApproved && !$is_app_paid)
                                                <span class="badge-pill-govt bg-expired-pill">Inactive</span>
                                            @elseif (\Carbon\Carbon::parse($wmf->subscription_validity_date)->lt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge-pill-govt bg-expired-pill">Lapsed</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mt-3 border-top pt-3">
                                        <div class="col-md-4">
                                            <p class="detail-label">Card Validity Date</p>
                                            <p class="detail-value">
                                                {{ \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') }}
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="detail-label">Subscription Paid Upto</p>
                                            <p class="detail-value">
                                                {{ $wmf->subscription_validity_date ? \Carbon\Carbon::parse($wmf->subscription_validity_date)->format('d-m-Y') : 'NOT SUBSCRIBED' }}
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="detail-label">Date of Retirement</p>
                                            <p class="detail-value">
                                                {{ \Carbon\Carbon::parse($wmf->date_of_retirement)->format('d-m-Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>


                                <!-- Subscription Payment Alert -->
                                <div class="payment-cta-box p-4 mb-5 text-center">
                                    <p class="detail-label mb-2">Subscription Status</p>
                                    @if ($wmf->active_status == '0')
                                        <div class="d-flex flex-column align-items-center">
                                            <h5 class="text-danger fw-bold mb-3">
                                                <i class="fa fa-exclamation-circle"></i> Please Pay Your Subscription
                                                Fees to Avail Benefits
                                            </h5>
                                            <a href="{{ route('worker-subscription') }}"
                                                class="btn btn-govt-primary btn-lg px-5 bounce-button">
                                                Pay Now <i class="fa fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    @elseif($wmf->active_status == '1')
                                        <span class="badge badge-govt-success p-2 px-4">FEES PAID</span>
                                    @endif

                                    @if ($wmf->active_status == '1' && $remaining_months_to_pay <= 3)
                                        <div class="mt-4">
                                            <a href="{{ route('idcards.index') }}" class="btn btn-outline-dark">
                                                <i class="fa fa-download me-2"></i> Download ID Card
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Available Schemes Section -->
                                <!-- Available Schemes -->
                                <section class="p-4 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold m-0">Available Schemes</h5>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown">Filter Schemes</button>
                                            <ul class="dropdown-menu border-0 shadow">
                                                <li><a class="dropdown-item" href="#">All Schemes</a></li>
                                                <li><a class="dropdown-item" href="#">Eligible</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="govt-table-container">
                                        <table class="table govt-table table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:left">Scheme Name</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="3" class="text-center py-4 text-muted">No schemes
                                                        available at the moment</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </section>

                                <!-- Tracker -->
                                <section class="p-4 border-top">
                                    <h5 class="fw-bold mb-3">Application Tracker</h5>
                                    <div class="govt-table-container">
                                        <table class="table govt-table">
                                            <thead>
                                                <tr>
                                                    <th>Application ID</th>
                                                    <th>Scheme</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">No active
                                                        applications</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </section>

                                <!-- Notifications -->
                                <section class="p-4 border-top">
                                    <h5 class="fw-bold mb-3">Notifications</h5>
                                    <div class="alert alert-light border shadow-sm">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-megaphone text-primary fs-5 me-3 mt-1"></i>
                                            <div>
                                                <p class="mb-1 fw-bold">Penalty Waiver Notice</p>
                                                <p class="text-muted small mb-0">Penalty charges waived from 3rd July
                                                    2025 to 2nd July 2026 as per ABOCWWB’s decision.</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Grievance -->
                                <section class="p-4 border-top">
                                    <h5 class="fw-bold mb-3">Grievance Redressal</h5>
                                    <div class="card border-0 bg-light p-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-headset fs-2 text-primary me-3"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1">Need assistance?</h6>
                                                <p class="mb-2 small text-muted">Our support team is here to help with
                                                    any issues or questions.</p>
                                                <button class="btn btn-primary btn-sm"><i
                                                        class="bi bi-plus-circle me-1"></i>Submit Grievance</button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    </div>
</div>
@endif

<style>
    /* Official Govt Theme - Dark Black/Navy Style */
    :root {
        --govt-dark: #1a1a1a;
        /* The "Black Header" color */
        --govt-navy: #002e5b;
        --govt-blue: #0056b3;
        --border-color: #dee2e6;
    }

    .govt-header-dark {
        background: var(--govt-dark);
        border-bottom: 4px solid var(--govt-blue);
        border-radius: 8px 8px 0 0;
    }

    .section-title-govt-dark {
        background: #f1f1f1;
        padding: 10px 15px;
        border-left: 5px solid var(--govt-dark);
        font-weight: 700;
        color: var(--govt-dark);
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .profile-details-box {
        background: #ffffff;
        border: 1px solid var(--border-color);
        padding: 20px;
        border-radius: 6px;
    }

    .detail-label {
        color: #6c757d;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .detail-value {
        color: #212529;
        font-weight: 600;
        font-size: 1.05rem;
    }

    /* Govt Style Badges */
    .badge-govt-success {
        background-color: #e6fffa;
        color: #006d5b;
        border: 1px solid #b2f5ea;
        padding: 6px 12px;
    }

    .badge-govt-danger {
        background-color: #fff5f5;
        color: #c53030;
        border: 1px solid #fed7d7;
        padding: 6px 12px;
    }

    /* Sleek Tables */
    .govt-sleek-table thead th {
        background: var(--govt-navy);
        color: white;
        font-size: 0.8rem;
        text-transform: uppercase;
        padding: 12px;
        border: none;
    }

    .btn-govt-primary {
        background: var(--govt-blue);
        color: white;
        border-radius: 4px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-govt-primary:hover {
        background: var(--govt-navy);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .payment-cta-box {
        background: #fffaf0;
        border: 2px dashed #f6ad55;
        border-radius: 8px;
    }

    .text-navy {
        color: var(--govt-navy);
    }

    /* Bounce animation for Pay Button */
    @keyframes bounceIn {
        0% {
            transform: scale(0.95);
        }

        50% {
            transform: scale(1.02);
        }

        100% {
            transform: scale(1);
        }
    }

    .bounce-button {
        animation: bounceIn 2s infinite ease-in-out;
    }
</style>

<div class="modal fade" id="trackingModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trackingModalLabel">Application Tracking History</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="tracking-modal-body">
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Fetching tracking details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Signout Modal -->
<div class="modal fade" id="signout-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0"><button type="button" class="btn-close"
                    data-bs-dismiss="modal"></button></div>
            <div class="modal-body p-5 text-center">
                <h4 class="fw-bold mb-3">Sign Out?</h4>
                <p class="text-muted mb-4">Are you sure you want to Log Out from the portal?</p>
                <form action="{{ route('user-logout') }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4 mx-2 shadow-sm">Sign Out</button>
                </form>
                <button class="btn btn-light border px-4 mx-2" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Welcome</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success border-0 mb-0"><strong>{!! $message !!}</strong></div>
                @endif
            </div>
        </div>
    </div>
</div>
</div></div></div>
@include('components.footer')
<script src="{{ URL::asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
<script>
    @if ($message = Session::get('success'))
        $(document).ready(function() {
            var myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
        });
    @endif

    function updateTime() {
        var h = new Date().getHours();
        var m = new Date().getMinutes();
        var s = new Date().getSeconds();
        h = (h < 10 ? "0" : "") + h;
        m = (m < 10 ? "0" : "") + m;
        s = (s < 10 ? "0" : "") + s;
        if (document.getElementById('currentTime')) document.getElementById('currentTime').textContent = h + ":" + m +
            ":" + s;
    }
    setInterval(updateTime, 1000);

    let expiryTime = new Date("{{ $expiresAt }}").getTime();

    function updateTimer() {
        let now = new Date().getTime();
        let distance = expiryTime - now;
        if (distance <= 0) {
            document.getElementById("session-timer").innerHTML = "Expired";
            return;
        }
        let mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let secs = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("session-timer").innerHTML =
            `<i class="fas fa-clock me-1"></i> Session: ${mins}m ${secs}s`;
    }
    setInterval(updateTimer, 1000);


</script>

<script>
    $(document).ready(function() {
        $('.track-button').on('click', function() {
            var applicationId = $(this).data('application-id');
            var trackingModal = new bootstrap.Modal(document.getElementById('trackingModal'));
            var modalBody = $('#tracking-modal-body');

            modalBody.html(
                '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div><p class="mt-2">Fetching tracking details...</p></div>'
            );
            trackingModal.show();

            $.ajax({
                url: 'worker/applications/track/' + applicationId,
                type: 'GET',
                success: function(response) {
                    modalBody.html(response.html);
                },
                error: function(xhr) {
                    var errorMsg =
                        '<div class="alert alert-danger">Sorry, an error occurred while fetching the tracking history. Please try again.</div>';
                    modalBody.html(errorMsg);
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
