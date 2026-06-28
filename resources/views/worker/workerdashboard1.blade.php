@include('layout.workerheader')
<style>
    /* Custom styles */
    .table {
        font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
        font-size: 15px;
    }

    body {}

    th,
    td {
        text-align: center;
    }

    th {
        background-color: #f8f9fa;
        color: #333;

    }

    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tbody tr:hover {
        background-color: #e9ecef;
    }

    .worker-profile h3 {
        font-size: 22px;
        font-weight: 600;
        border-bottom: 1px solid #b2b1b1;
        padding-bottom: 5px;
        color: #135c8c;
        margin-bottom: 12px;
    }

    .select-scheme li {
        margin-bottom: 18px;
    }

    .select-scheme li a {
        text-decoration: none;
        padding: 7px 15px;
        background-color: #0d95e8;
        border-radius: 4px;
        margin-left: 20px;
        color: white;
        font-weight: 300;
        transition: 0.3s linear;
        border-bottom: 2px solid darkslateblue
    }

    .select-scheme li a:hover {
        background-color: #de2717
    }

    /* Bounce animation */
    @keyframes bounceIn {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }

        60% {
            transform: scale(1.05);
            opacity: 1;
        }

        100% {
            transform: scale(1);
        }
    }

    @keyframes bounceOut {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(0.9);
            opacity: 0;
        }
    }

    .bounce-button {
        animation: bounceIn 0.5s ease;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .bounce-button:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        /* subtle red shadow */
    }

    /* Optional: bounce out on mouse leave */
    .bounce-button:active {
        animation: bounceOut 0.3s ease;
    }


    .application-status-tracker,
    .notification {
        margin-top: 50px;
    }

    .grivance {
        margin-top: 35px
    }

    .notification p {
        margin-bottom: 5px;
    }

    .square {
        border-radius: 0px;
    }

    .worker-dashboard {
        max-width: 1200px;
        margin: 0 auto;
    }

    .rounded-card {
        border-radius: 12px;
        border: none;
    }

    .section-title {
        color: #2c3e50;
        font-weight: 600;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0.5rem;
    }

    .detail-label {
        color: #146e80;
        margin-bottom: 0.2rem;
        font-size: 0.9rem;
    }

    .detail-value {
        font-weight: 500;
        color: #34495e;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .notification-list .alert {
        border-left: 4px solid transparent;
        border-radius: 6px;
        margin-bottom: 0.5rem;
    }

    .card-status {
        border-radius: 12px;
        border: 1px solid #E9ECEF;
        background: #FFF;
        box-shadow: 0px 2px 8px 0px rgba(0, 0, 0, 0.05);
    }

    .status-header {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .status-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F0F7FF;
        border-radius: 8px;
    }

    .status-title h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
    }


    .status-timeline {
        position: relative;
        padding-left: 24px;
    }

    .timeline-progress {
        position: static;
    }

    .timeline-progress::before {
        content: '';
        position: absolute;
        left: 11px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #E9ECEF;
    }

    .progress-step {
        position: relative;
        padding-bottom: 20px;
        padding-left: 10px;
    }

    .progress-step:last-child {
        padding-bottom: 0;
    }

    .step-marker {
        position: absolute;
        left: -24px;
        top: 0;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #E9ECEF;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .progress-step.completed .step-marker {
        background: #0D6EFD;
    }

    .progress-step.active .step-marker {
        background: #0D6EFD;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
    }

    .step-marker::after {
        content: '';
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: white;
    }

    .progress-step.completed .step-marker::after,
    .progress-step.active .step-marker::after {
        content: '\2713';
        font-size: 10px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .step-title {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 2px;
    }

    .step-date {
        font-size: 12px;
        color: #6C757D;
    }

    .status-actions {
        display: flex;
        align-items: center;
    }

    .card-highlight-blue {
        border-left: 4px solid #0d6efd;
        background-color: #f4f8ff;
    }
</style>
<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <ul class="breadcrumb" style="font-family:'Poppins',Sans-Serif ">
            <li><a href="#">Dashboard</a></li>
        </ul>

        @php
            $current_date = now();
        @endphp

        {{-- // CORRECTION: This is the main conditional block. --}}
        @if (isset($wmf) && $wmf->already_registered == 1)
            {{-- // THIS IS THE MODERN DASHBOARD FOR REGISTERED USERS --}}
            <div class="container worker-dashboard" style="font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;">
                <div class="card rounded-card shadow-sm">
                    <div class="card-body p-4">
                        <div class="container worker-profile">
                            <!-- Profile Overview Section -->
                            <section class="mb-5">
                                <h3 class="mb-4 section-title"><i class="fa fa-user"
                                        aria-hidden="true"></i>&nbsp;Profile Overview
                                    @if (isset($wmf->id_card))
                                        <span class="badge badge-success">
                                            {{ $wmf->id_card }}
                                        </span>
                                    @endif
                                </h3>
                                <div class="profile-details">
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <p class="detail-label"><strong>Beneficiary Name</strong></p>
                                            <p class="detail-value">{{ $getVaultData['name'] ?? 'N/A' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p class="detail-label"><strong>Membership Status</strong></p>
                                            @if ($wmf->active_status == '2')
                                                <span class="badge badge-danger">Suspended</span>
                                            @elseif (isset($wmf->date_of_retirement) && \Carbon\Carbon::parse($wmf->date_of_retirement)->lt($current_date))
                                                <span class="badge badge-warning">Retired</span>
                                                <p class="text-muted small mt-1">Retired on
                                                    {{ \Carbon\Carbon::parse($wmf->date_of_retirement)->format('d-m-Y') }}
                                                </p>
                                            @elseif (isset($wmf->id_card_expiry_date) && \Carbon\Carbon::parse($wmf->id_card_expiry_date)->lt($current_date))
                                                <span class="badge badge-warning">Expired</span>
                                                <p class="text-muted small mt-1">Expired on
                                                    {{ \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') }}
                                                </p>
                                            @elseif (isset($wmf->subscription_validity_date) &&
                                                    \Carbon\Carbon::parse($wmf->subscription_validity_date)->gt(\Carbon\Carbon::parse($current_date)))
                                                <span class="badge badge-success">Active</span>
                                            @elseif($wmf->active_status == '1' && (isset($is_paid) && $is_paid))
                                                <span class="badge badge-success">Active</span>
                                            @elseif($wmf->active_status == '1' && !(isset($is_paid) && $is_paid) && !(isset($isRenewalApproved) && $isRenewalApproved))
                                                <span class="badge badge-warning">Expired</span>
                                            @elseif(
                                                $wmf->active_status == '1' &&
                                                    (isset($isRenewalApproved) && $isRenewalApproved) &&
                                                    !(isset($is_app_paid) && $is_app_paid))
                                                <span class="badge badge-warning">Inactive</span>
                                            @elseif (isset($wmf->subscription_validity_date) &&
                                                    \Carbon\Carbon::parse($wmf->subscription_validity_date)->lt($current_date))
                                                <span class="badge badge-warning">Lapsed</span>
                                            @endif
                                        </div>
                                        @if (isset($is_retired) && $is_retired)
                                            <div class="col-md-4">
                                                <p class="detail-label"><strong>Subscription Paid Upto:</strong></p>
                                                <p class="detail-value">
                                                    {{ isset($wmf->id_card_expiry_date) ? \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') : 'N/A' }}
                                                </p>
                                            </div>
                                        @else
                                            @if (!(isset($first_paid) && $first_paid) && !(isset($is_paid) && $is_paid))
                                                <div class="col-md-4">
                                                    <p class="detail-label"><strong>Subscription Paid Upto:</strong></p>
                                                    <p class="detail-value">
                                                        {{ isset($wmf->subscription_validity_date) ? \Carbon\Carbon::parse($wmf->subscription_validity_date)->format('d-m-Y') : 'N/A' }}
                                                    </p>
                                                </div>
                                            @elseif(isset($first_paid) && $first_paid && !(isset($is_paid) && $is_paid))
                                                <div class="col-md-4">
                                                    <p class="detail-label"><strong>Subscription Paid Upto:</strong></p>
                                                    <p class="detail-value">
                                                        {{ isset($last_sub) ? \Carbon\Carbon::parse($last_sub)->format('d-m-Y') : 'N/A' }}
                                                    </p>
                                                </div>
                                            @elseif(isset($first_paid) && $first_paid && (isset($is_paid) && $is_paid))
                                                <div class="col-md-4">
                                                    <p class="detail-label"><strong>Subscription Paid Upto:</strong></p>
                                                    <p class="detail-value">
                                                        {{ isset($wmf->subscription_validity_date) ? \Carbon\Carbon::parse($wmf->subscription_validity_date)->format('d-m-Y') : 'N/A' }}
                                                    </p>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="row mb-2">
                                        @if (!(isset($is_retired) && $is_retired))
                                            <div class="col-md-4">
                                                <p class="detail-label"><strong>Renewal Date</strong></p>
                                                <p class="detail-value">
                                                    {{ isset($wmf->id_card_expiry_date) ? \Carbon\Carbon::parse($wmf->id_card_expiry_date)->addDay()->format('d-m-Y') : 'N/A' }}
                                                </p>
                                            </div>
                                        @endif

                                        <div class="col-md-4">
                                            <p class="detail-label"><strong>Date Of Registration</strong></p>
                                            <p class="detail-value">
                                                {{ isset($wmf->last_registration_date) ? \Carbon\Carbon::parse($wmf->last_registration_date)->format('d-m-Y') : 'N/A' }}
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="detail-label"><strong>Date Of Retirement</strong></p>
                                            <p class="detail-value">
                                                {{ isset($wmf->date_of_retirement) ? \Carbon\Carbon::parse($wmf->date_of_retirement)->format('d-m-Y') : 'N/A' }}
                                            </p>
                                        </div>
                                        @if (isset($isRenewApplied) && $isRenewApplied)
                                            <div class="col-md-4">
                                                <p class="detail-label"><strong>Extended Validity Date<span
                                                            class="text-muted">(After Approval)</span> :</strong></p>

                                                <p class="detail-value">
                                                    @php
                                                        $renewalDate = isset($wmf->renewal_date)
                                                            ? \Carbon\Carbon::parse($wmf->renewal_date)
                                                            : null;
                                                        $twoYearEnd = $renewalDate
                                                            ? $renewalDate->copy()->addYears(2)->subDay()
                                                            : null;
                                                        $retirementDate = isset($wmf->date_of_retirement)
                                                            ? \Carbon\Carbon::parse($wmf->date_of_retirement)
                                                            : null;

                                                        // if retirement date is within 2 years from renewal date
                                                        $finalDate =
                                                            $retirementDate &&
                                                            $twoYearEnd &&
                                                            $retirementDate->lte($twoYearEnd)
                                                                ? $retirementDate
                                                                : $twoYearEnd;
                                                    @endphp

                                                    {{ $finalDate ? $finalDate->format('d-m-Y') : 'N/A' }}
                                                </p>
                                            </div>
                                        @endif

                                        @if (isset($isRenewal) && $isRenewal)
                                            <div class="col-md-8">
                                                @if (isset($wmf->subscription_validity_date) &&
                                                        isset($wmf->id_card_expiry_date) &&
                                                        \Carbon\Carbon::parse($wmf->subscription_validity_date)->lt(\Carbon\Carbon::parse($wmf->id_card_expiry_date)))
                                                    <div class="mb-0 d-inline-flex align-items-center">
                                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                        <span class="text-danger"><i class="fa fa-exclamation-triangle"
                                                                aria-hidden="true"></i>&nbsp;Please clear your pending
                                                            subscription dues before renewal&nbsp;
                                                            <a href="{{ route('worker-subscription-new') }}"
                                                                class="btn btn-outline-primary btn-sm ms-2 bounce-button">Click
                                                                Here <i class="fa fa-share-square-o"
                                                                    aria-hidden="true"></i></a></span>
                                                    </div>
                                                @endif
                                                @if (isset($wmf->subscription_validity_date) &&
                                                        isset($wmf->id_card_expiry_date) &&
                                                        \Carbon\Carbon::parse($wmf->subscription_validity_date)->equalTo(
                                                            \Carbon\Carbon::parse($wmf->id_card_expiry_date)))
                                                    @if (isset($isSubscriptionApplied) && $isSubscriptionApplied)
                                                        @if (isset($is_paid) && $is_paid)
                                                            <div class="mb-0 d-inline-flex align-items-center">
                                                                <i class="fa fa-check-square-o text-success"
                                                                    aria-hidden="true"></i>&nbsp;
                                                                <span class="text-success">
                                                                    Subscription Dues Cleared Up to
                                                                    {{ isset($wmf->subscription_validity_date) ? \Carbon\Carbon::parse($wmf->subscription_validity_date)->format('d-m-Y') : 'N/A' }}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="mb-0 d-inline-flex align-items-center">
                                                                <i class="fa fa-exclamation-circle text-danger"
                                                                    aria-hidden="true"></i>&nbsp;&nbsp;
                                                                <span class="text-dark">
                                                                    Subscription Payment is Pending <a
                                                                        href="{{ route('my-subscription') }}"
                                                                        class="btn btn-outline-danger btn-sm ms-2 bounce-button">Click
                                                                        Here <i class="fa fa-share-square-o"
                                                                            aria-hidden="true"></i></a>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    @if (isset($wmf->id_card_expiry_date) &&
                                                            \Carbon\Carbon::parse($wmf->id_card_expiry_date)->lessThan(\Carbon\Carbon::today()))
                                                        <div class="mt-2 d-inline-flex align-items-center">
                                                            <i class="fa fa-exclamation-circle text-danger"
                                                                aria-hidden="true"></i>&nbsp;
                                                            @if (isset($isWorkbookApplied) && $isWorkbookApplied)
                                                                <span class="me-2">
                                                                    Dear user, Your Renewal Application is pending<a
                                                                        href="{{ route('preview-renewal-data') }}"
                                                                        class="btn btn-outline-danger btn-sm ms-2 bounce-button">
                                                                        Complete Application!
                                                                        <i class="fa fa-share-square-o"
                                                                            aria-hidden="true"></i></a>
                                                                </span>&nbsp;
                                                            @else
                                                                {{-- <span class="me-2">
                                                                    ID Card Expired on {{ isset($wmf->id_card_expiry_date) ? \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') : 'N/A' }} — Please Renew!
                                                                </span>&nbsp;
                                                                <a href="{{ route('renew-application') }}" class="btn btn-outline-danger btn-sm ms-2 bounce-button">
                                                                    Click Here <i class="fa fa-share-square-o" aria-hidden="true"></i>
                                                                </a> --}}
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endif

                                                @if (isset($wmf->id_card_expiry_date) &&
                                                        \Carbon\Carbon::parse($wmf->id_card_expiry_date)->lessThan(\Carbon\Carbon::today()))
                                                    <div class="mt-2 d-inline-flex align-items-center">
                                                        <i class="fa fa-exclamation-circle text-danger"
                                                            aria-hidden="true"></i>&nbsp;
                                                        @if (isset($isWorkbookApplied) && $isWorkbookApplied)
                                                            <span class="me-2">
                                                                Dear user, Your Renewal Application is pending<a
                                                                    href="{{ route('preview-renewal-data') }}"
                                                                    class="btn btn-outline-danger btn-sm ms-2 bounce-button">
                                                                    Complete Application!
                                                                    <i class="fa fa-share-square-o"
                                                                        aria-hidden="true"></i></a>
                                                            </span>&nbsp;
                                                        @else
                                                            <span class="me-2">
                                                                ID Card Expired on
                                                                {{ isset($wmf->id_card_expiry_date) ? \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') : 'N/A' }}
                                                                — Please Renew!
                                                            </span>&nbsp;
                                                            <a href="{{ route('renew-application') }}"
                                                                class="btn btn-outline-danger btn-sm ms-2 bounce-button">
                                                                Click Here <i class="fa fa-share-square-o"
                                                                    aria-hidden="true"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    @if (isset($isRenewalApproved) && $isRenewalApproved && $wmf->active_status == 0)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="detail-label"><strong>Subscription Payment:</strong></p>
                                                <div class="subscription-error-box d-flex align-items-start mb-3">
                                                    <i class="bi bi-x-circle-fill text-danger me-3"
                                                        style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <p class="mb-0" style="font-size: 0.9rem; color: #6c757d;">
                                                            Please pay minimum 3 months of membership subscription to
                                                            access all benefits
                                                        </p><a href="{{ route('worker-subscription-new') }}"
                                                            class="btn btn-outline-danger">
                                                            <i class="bi bi-cash-coin me-2"></i>Click here to Pay
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if (isset($isRenewApplied) && $isRenewApplied)
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card mb-3 shadow-sm card-highlight-blue">



                                                    <div class="card-body p-3">

                                                        <h6 class="mb-3 fw-bold">
                                                            <i class="bi bi-clock-history text-primary me-1"></i>
                                                            Renewal Application Status
                                                        </h6>

                                                        @if ($renewal_app_status->isNotEmpty())
                                                            <div class="table-responsive">
                                                                <table
                                                                    class="table table-sm table-bordered align-middle mb-0">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Status</th>
                                                                            <th>Date</th>
                                                                            <th class="text-center">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                       // @foreach ($renewal_app_status as $status)
                                                                         //   <tr>
                                                                                {{-- STATUS --}}
                                                                           //     <td>
                                                                             //       @if ($status->application_status === 'A')
                                                                               //         <span
                                                                                 //           class="badge bg-success text-light">
                                                                                   //         Submitted to HRO
                                                                                     //   </span>
                                                                                   // @elseif($status->application_status === 'G')
                                                                                     //   <span class="badge bg-danger">
                                                                                       //     Reverted to Applicant
                                                                                       // </span>
                                                                                   // @elseif($status->resubmit_status == 1)
                                                                                    //    <span class="badge bg-success">
                                                                                //            Resubmitted
                                                                                 //       </span>
                                                                                  //  @elseif($status->application_status === 'O')
                                                                                    //    <span class="badge bg-info">
                                                                                      //      Under Processing
                                                                                   //     </span>
                                                                                  //  @elseif($status->application_status === 'F')
                                                                                    //    <span
                                                                                      //      class="badge bg-warning text-dark">
                                                                                        //    Finalized
                                                                                      //  </span>
                                                                                  //  @endif
                                                                              //  </td>

                                                                                {{-- DATE --}}
                                                                              //  <td>
                                                                                //    {{ \Carbon\Carbon::parse($status->created_at)->format('d M Y, h:i A') }}
                                                                              //  </td>

                                                                                {{-- ACTION --}}
                                                                               // <td class="text-center">
                                                                                 //   @if ($status->application_status === 'A')
                                                                                   //     <a href="{{ route('download-acknowledgement-renewal') }}"
                                                                                       // target="_blank"
                                                                                          //  class="btn btn-sm btn-outline-success">
                                                                                          //  <i
                                                                                        //        class="fa fa-download me-1"></i>&nbsp;
                                                                                      //      Receipt
                                                                                    //    </a>
                                                                                  //  @elseif($status->application_status === 'G')
                                                                                      //  @if ($hasBeenResubmitted || $status->resubmit_status == 1)
                                                                                        //    <button
                                                                                           //     class="btn btn-sm btn-secondary"
                                                                                         //       disabled>
                                                                                       //         Resubmitted
                                                                                     //       </button>
                                                                    @foreach($renewal_app_status as $status)
                                                                        <tr>
                                                                            {{-- STATUS --}}
                                                                            <td>
                                                                                @if($status->application_status === 'A')
                                                                                    <span class="badge bg-success text-light">
                                                Submitted to HRO
                                            </span>

                                                                                @elseif($status->application_status === 'G')
                                                                                    <span class="badge bg-danger text-white">
                                                Reverted to Applicant
                                            </span>

                                                                                @elseif($status->resubmit_status == 1)
                                                                                    <span class="badge bg-success text-white">
                                                Resubmitted
                                            </span>

                                                                                @elseif($status->application_status === 'O')
                                                                                    <span class="badge bg-info text-white">
                                                Under Processing
                                            </span>

                                                                                @elseif($status->application_status === 'F')
                                                                                    <span class="badge bg-warning text-dark">
                                                Finalized
                                            </span>
                                                                                @endif
                                                                            </td>

                                                                            {{-- DATE --}}
                                                                            <td>
                                                                                {{ \Carbon\Carbon::parse($status->created_at)->format('d M Y, h:i A') }}
                                                                            </td>

                                                                            {{-- ACTION --}}
                                                                            <td class="text-center">
                                                                                @if($status->application_status === 'A')
                                                                                    <a href="{{ route('download-acknowledgement-renewal') }}"
                                                                                       target="_blank"
                                                                                       class="btn btn-sm">
                                                                                        <i class="fa fa-download me-1"></i>&nbsp; Receipt
                                                                                    </a>

                                                                                @elseif($status->application_status === 'G')
                                                                                    @if($hasBeenResubmitted || $status->resubmit_status == 1)
                                                                                        <button class="btn btn-sm btn-info" disabled>
                                                                                            Resubmitted By Applicant
                                                                                        </button>
                                                                                    @else
                                                                                        <a href="{{ route('renew-application') }}"
                                                                                           class="btn btn-sm btn-outline-primary">
                                                                                            Re-submit
                                                                                        </a>
                                                                                    @endif
                                                                                @else
                                                                                    Under Processing
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <p class="text-muted mb-0">No renewal application status
                                                                found.</p>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endif

                                    @if (isset($isRenewalApproved) &&
                                            $isRenewalApproved &&
                                            $wmf->active_status == 1 &&
                                            !(isset($is_app_paid) && $is_app_paid))
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="detail-label"><strong>Subscription Payment:</strong></p>
                                                <div class="mb-0 d-inline-flex align-items-center">
                                                    <i class="fa fa-exclamation-circle text-danger"
                                                        aria-hidden="true"></i>&nbsp;&nbsp;
                                                    <span class="text-dark">
                                                        Dear User, your Subscription Payment is Pending <a
                                                            href="{{ route('my-subscription') }}"
                                                            class="btn btn-outline-danger btn-sm ms-2 bounce-button">Click
                                                            Here to Pay<i class="fa fa-share-square-o"
                                                                aria-hidden="true"></i></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if (isset($isRenewalApproved) && $isRenewalApproved)
                                    @if (isset($is_retired) && $is_retired)
                                        {{-- Retired case --}}
                                        @if (isset($subscription_clear) && $subscription_clear)
                                            {{-- Cleared → show only ID Card --}}
                                            @if ($wmf->status == 'F' && $wmf->active_status == 1 && (isset($is_app_paid) && $is_app_paid))
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="detail-label"><strong>BOCW ID Card:</strong></p>
                                                        <a href="{{ route('idcards.index') }}"
                                                            class="btn btn-outline-primary">
                                                            <i class="bi bi-card-text me-2"></i>Download ID Card
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            {{-- Not cleared → show Payment + ID Card --}}
                                            @if (isset($is_app_paid) && $is_app_paid && !(isset($duesCleared) && $duesCleared))
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="detail-label"><strong>Subscription Payment:</strong>
                                                        </p>
                                                        <div
                                                            class="subscription-error-box d-flex align-items-start mb-3">
                                                            <i class="bi bi-x-circle-fill text-danger me-3"
                                                                style="font-size: 1.5rem;"></i>
                                                            <div>
                                                                <p class="mb-0"
                                                                    style="font-size: 0.9rem; color: #6c757d;">
                                                                    {{-- Add explanatory text here --}}
                                                                </p>
                                                                <a href="{{ route('worker-subscription-new') }}"
                                                                    class="btn btn-outline-danger">
                                                                    Click here to Pay <i class="fa fa-share-square-o"
                                                                        aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if ($wmf->status == 'F' && $wmf->active_status == 1 && (isset($is_app_paid) && $is_app_paid))
                                                        <div class="col-md-12">
                                                            <p class="detail-label"><strong>BOCW ID Card:</strong></p>
                                                            <a href="{{ route('idcards.index') }}"
                                                                class="btn btn-outline-primary">
                                                                <i class="bi bi-card-text me-2"></i>Download ID Card
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        {{-- Not retired case (existing logic) --}}
                                        @if (isset($is_app_paid) && $is_app_paid && !(isset($duesCleared) && $duesCleared))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="detail-label"><strong>Subscription Payment:</strong></p>
                                                    <div class="subscription-error-box d-flex align-items-start mb-3">
                                                        <i class="bi bi-x-circle-fill text-danger me-3"
                                                            style="font-size: 1.5rem;"></i>
                                                        <div>
                                                            <p class="mb-0"
                                                                style="font-size: 0.9rem; color: #6c757d;">
                                                                {{-- Add explanatory text here --}}
                                                            </p>
                                                            <a href="{{ route('worker-subscription-new') }}"
                                                                class="btn btn-outline-danger">
                                                                Click here to Pay <i class="fa fa-share-square-o"
                                                                    aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($wmf->status == 'F' && $wmf->active_status == 1 && (isset($is_app_paid) && $is_app_paid))
                                                    <div class="col-md-12">
                                                        <p class="detail-label"><strong>BOCW ID Card:</strong></p>
                                                        <a href="{{ route('idcards.index') }}"
                                                            class="btn btn-outline-primary">
                                                            <i class="bi bi-card-text me-2"></i>Download ID Card
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        @if (
                                            $wmf->status == 'F' &&
                                                $wmf->active_status == 1 &&
                                                (isset($is_app_paid) && $is_app_paid) &&
                                                (isset($duesCleared) && $duesCleared))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="detail-label"><strong>BOCW ID Card:</strong></p>
                                                    <a href="{{ route('idcards.index') }}"
                                                        class="btn btn-outline-primary">
                                                        <i class="bi bi-card-text me-2"></i>Download ID Card
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif

                                @if (isset($isRenewalApproved) &&
                                        $isRenewalApproved &&
                                        (isset($is_app_paid) && $is_app_paid) &&
                                        !(isset($duesCleared) && $duesCleared))
                                    {{-- Added missing check for duesCleared --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="detail-label"><strong>Subscription Payment:</strong></p>
                                            <div class="subscription-error-box d-flex align-items-start mb-3">
                                                <i class="bi bi-x-circle-fill text-danger me-3"
                                                    style="font-size: 1.5rem;"></i>
                                                <div>
                                                    <p class="mb-0" style="font-size: 0.9rem; color: #6c757d;">
                                                        {{-- Please pay for lapsed months with additional 3 months of membership subscription to access all benefits --}}
                                                    </p>
                                                    <a href="{{ route('worker-subscription-new') }}"
                                                        class="btn btn-outline-danger">
                                                        Click here to Pay <i class="fa fa-share-square-o"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </section>
                            @if (\App\Models\Benefit::where('status', true)->count() > 0)
                                @include('worker.benefits.components.benefit-list')
                            @endif
                            <!-- Notifications Section -->
                            <section class="mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3 class="section-title">Notifications</h3>
                                    <button class="btn btn-sm btn-outline-secondary">Mark all as read</button>
                                </div>
                                <div class="notification-list">
                                    <div class="alert alert-light">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="bi bi-megaphone text-primary"></i>
                                            </div>
                                            <div>
                                                <p class="mb-1">Penalty Waiver Notice</p>
                                                <p class="text-muted small mb-0"> Penalty charges for subscription are
                                                    waived from <strong>3rd July 2025</strong> to <strong>2nd July
                                                        2026</strong>
                                                    as per ABOCWWB’s decision. No penalty will be applied during this
                                                    period. Further updates will be notified by the Board.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Grievance Section -->
                            <section>
                                <h3 class="mb-3 section-title">Grievance Redressal</h3>
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="bi bi-headset fs-3 text-primary"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">Need assistance?</h5>
                                                <p class="mb-3">Our support team is here to help with any issues or
                                                    questions you may have.</p>
                                                <button class="btn btn-primary">
                                                    <i class="bi bi-plus-circle me-2"></i>Submit Grievance
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container worker-dashboard"
                style="font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;">
                <div class="card rounded-card shadow-sm">
                    <div class="card-body p-4">
                        <div class="container worker-profile">
                            <h3>Profile Overview</h3>

                            <div class="profile-details">
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <p class="detail-label"><strong>Beneficiary Name</strong></p>
                                        <p class="detail-value">{{ $getVaultData['name'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="detail-label"><strong>Date Of Birth</strong></p>
                                        <p class="detail-value">{{ $getVaultData['dob'] ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <p class="detail-label"><strong>Membership Status</strong></p>
                                        @if (isset($wmf->active_status) && $wmf->active_status == '1')
                                            <span class="badge badge-success">Active</span>
                                        @elseif (isset($wmf->active_status) && $wmf->active_status == '0')
                                            <span class="badge badge-danger">Inactive</span>
                                        @elseif (isset($wmf->date_of_retirement) &&
                                                \Carbon\Carbon::parse($wmf->date_of_retirement)->lt(\Carbon\Carbon::parse($current_date)))
                                            <span class="badge badge-warning">Retired</span>
                                            <p class="text-muted small mt-1">Retired on
                                                {{ isset($wmf->date_of_retirement) ? \Carbon\Carbon::parse($wmf->date_of_retirement)->format('d-m-Y') : 'N/A' }}
                                            </p>
                                        @elseif (isset($wmf->id_card_expiry_date) &&
                                                \Carbon\Carbon::parse($wmf->id_card_expiry_date)->lt(\Carbon\Carbon::parse($current_date)))
                                            <span class="badge badge-warning">Expired</span>
                                            <p class="text-muted small mt-1">Expired on
                                                {{ isset($wmf->id_card_expiry_date) ? \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') : 'N/A' }}
                                            </p>
                                        @elseif(isset($wmf->active_status) &&
                                                $wmf->active_status == '1' &&
                                                !(isset($is_paid) && $is_paid) &&
                                                !(isset($isRenewalApproved) && $isRenewalApproved))
                                            <span class="badge badge-warning">Expired</span>
                                        @elseif(isset($wmf->active_status) &&
                                                $wmf->active_status == '1' &&
                                                (isset($isRenewalApproved) && $isRenewalApproved) &&
                                                !(isset($is_app_paid) && $is_app_paid))
                                            <span class="badge badge-warning">Inactive</span>
                                        @elseif (isset($wmf->subscription_validity_date) &&
                                                \Carbon\Carbon::parse($wmf->subscription_validity_date)->lt(\Carbon\Carbon::parse($current_date)))
                                            <span class="badge badge-warning">Lapsed</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <p class="detail-label"><strong>Card Validity date</strong></p>
                                        <p class="detail-value">
                                            {{ isset($wmf->id_card_expiry_date) ? \Carbon\Carbon::parse($wmf->id_card_expiry_date)->format('d-m-Y') : 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="detail-label"><strong>Subscription Validity date</strong></p>
                                        <p class="detail-value">
                                            {{ isset($wmf->subscription_validity_date) && $wmf->subscription_validity_date ? \Carbon\Carbon::parse($wmf->subscription_validity_date)->format('d-m-Y') : 'Yet to Subscribe' }}
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="detail-label"><strong>Retirement date</strong></p>
                                        <p class="detail-value">
                                            {{ isset($wmf->date_of_retirement) ? \Carbon\Carbon::parse($wmf->date_of_retirement)->format('d-m-Y') : 'N/A' }}
                                        </p>
                                    </div>

                                    <div class="col-md-4">
                                        <p class="detail-label"><strong>Subscription Status</strong></p>
                                        <p class="detail-value">
                                            @if (isset($wmf->active_status) && $wmf->active_status == '0')
                                                <span class="text-danger font-weight-bold">Please Pay your
                                                    Subscription fees to avail benefits</span>
                                                <a href="{{ route('worker-subscription') }}"
                                                    class="btn btn-sm btn-primary square">Pay
                                                    Now</a><br>
                                            @elseif(isset($wmf->active_status) && $wmf->active_status == '1')
                                                <span class="badge badge-success">Paid</span>
                                            @endif
                                        </p>
                                    </div>

                                    @if (isset($wmf->active_status) &&
                                            $wmf->active_status == '1' &&
                                            (isset($remaining_months_to_pay) && $remaining_months_to_pay <= 3))
                                        <div class="col-md-12"> {{-- Added col-md-12 for better structure --}}
                                            <p>
                                                <a href="{{ route('idcards.index') }}"
                                                    class="btn btn-sm btn-primary">Click to download/view ID Card</a>
                                            </p>
                                            <p>
                                                Do you want to pay your remaining months' subscription in advanced?
                                                @if (isset($remaining_months_to_pay) && $remaining_months_to_pay > 0)
                                                    <a href="{{ route('worker-subscription') }}"
                                                        class="btn btn-sm btn-danger">Pay now</a>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <h3>Benefits Overview</h3>
                            <p>Select a Scheme</p>
                            <table class="table w-100 shadow">
                                <thead>
                                    <th>Schemes</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @if (isset($benefits) && $benefits->isNotEmpty())
                                        @foreach ($benefits as $benefit)
                                            <tr>
                                                <td>{{ $benefit->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary square" href="#">View</a>
                                                    <a class="btn btn-sm btn-danger square"
                                                        href="{{ route('worker.apply-now', $benefit->id) }}">Apply
                                                        Now</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">No benefits found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="application-status-tracker">
                                <h3>Application Status Tracker</h3>
                                <table class="table w-100 shadow">
                                    <thead>
                                        <th>#</th>
                                        <th>Application ID</th>
                                        <th>Scheme</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @if (isset($applications) && $applications->isNotEmpty())
                                            @foreach ($applications as $application)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $application->application_id ?? 'N/A' }}</td>
                                                    <td>{{ $application->benefit->name ?? 'N/A' }}</td>
                                                    <td>Submitted</td>
                                                    <td><a class="btn btn-sm btn-primary square"
                                                            href="{{ route('worker.print-application') }}">Print
                                                            Application</a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">No applications found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="notification">
                                <h3>Notifications</h3>
                                <p>Coming Soon</p>
                            </div>

                            <div class="grivance">
                                <h3>Grievance</h3>
                                <p>Coming Soon.</p>
                                <button class="btn btn-primary">Lodge</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- /#wrapper -->

<!-- Modals -->
<div class="modal fade" id="signout-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-5 border-bottom-0">
                <h3 class="modal-title">Sign Out?</h3>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="text-center">Are you sure you want to Log Out?</p>
                <div class="text-center py-4">
                    <form action="{{ route('user-logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
                        <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="trackingModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trackingModalLabel">Application Tracking History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Welcome to the dashboard!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <strong>{!! $message !!} </strong>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('components.footer')
<script src="{{ URL::asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
<script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route('application.status') }}')
            .then(response => response.json())
            .then(data => {
                // Ensure the element exists before trying to access textContent
                const applicationStatusElement = document.getElementById('applicationStatus');
                if (applicationStatusElement) {
                    applicationStatusElement.textContent = data.status;
                }
            })
            .catch(error => {
                const applicationStatusElement = document.getElementById('applicationStatus');
                if (applicationStatusElement) {
                    applicationStatusElement.textContent = 'Error loading status';
                }
            });
    });
</script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
<script>
    @if ($message = Session::get('success'))
        $(document).ready(function() {
            $('#successModal').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        });
    @endif
</script>
<script>
    function updateTime() {
        var currentTimeElement = document.getElementById('currentTime');
        if (!currentTimeElement) return; // Guard against null element
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        hours = (hours < 10 ? "0" : "") + hours;
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;

        var timeString = hours + ":" + minutes + ":" + seconds;
        currentTimeElement.textContent = timeString;
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
</body>

</html>
