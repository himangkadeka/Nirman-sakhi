@extends('layouts.admin-app')

@section('title', 'Office | Dashboard')
@section('breadcrumb_item_1', 'Office')
@section('breadcrumb_item_2', 'Dashboard')
@section('style')
    <style>
        .card {
            border-radius: 0.35rem;
            transition: all 0.3s;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.3rem 0.75rem rgba(0, 0, 0, 0.1) !important;
        }
        .border-left-primary {
            border-left: 0.2rem solid #4e73df !important;
        }
        .border-left-warning {
            border-left: 0.2rem solid #f6c23e !important;
        }
        .border-left-success {
            border-left: 0.2rem solid #1cc88a !important;
        }
        .border-left-info {
            border-left: 0.2rem solid #36b9cc !important;
        }
        .border-left-danger {
            border-left: 0.2rem solid #e74a3b !important;
        }
        .border-left-secondary {
            border-left: 0.2rem solid #050596 !important;
        }
        .border-left-dark {
            border-left: 0.2rem solid #5a5c69 !important;
        }
        .border-left-purple {
            border-left: 0.2rem solid #9376db !important;
        }
        .btn-purple {
            background-color: #9376db;
            color: white;
        }
        .row.g-4 > [class^="col-"] {
            padding-right: calc(var(--bs-gutter-x) * 0.5);
            padding-left: calc(var(--bs-gutter-x) * 0.5);
            margin-bottom: 0.75rem;
        }

        .blink {
            animation: blinker 2.5s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
        .collapsible {
            background-color: #3d3f44;
            color: white;
            cursor: pointer;
            padding: 12px 15px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 16px;
            margin-top: 10px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        /* Hover effect */
        .collapsible:hover {
            background-color: #2e59d9;
        }

        /* Active state */
        .collapsible.active {
            background-color: #2e59d9;
            margin-bottom: 0;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        /* Icon styling */
        .collapsible .icon {
            margin-right: 10px;
            transition: transform 0.3s;
        }

        /* Rotate icon when active */
        .collapsible.active .icon {
            transform: rotate(180deg);
        }

        /* Content styling */
        .content {
            padding: 15px;
            display: none;
            overflow: hidden;
            background-color: white;
            border: 1px solid #e3e6f0;
            border-top: none;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        /* Animation for smoother opening */
        .content {
            animation: fadeIn 0.3s ease-out;
        }
        .bg-light{
            background: #e9e7ec!important;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid">



        <!-- Content Row -->
        <button class="collapsible">
            <i class="fas fa-chevron-down icon"></i> New Registration
        </button>
        <div class="content">
            <div class="my-1" id="b-homedb">
                <div class="container-fluid">
                    <div class="row g-4">
                        <!-- Total Applications Received -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-left-primary shadow h-100">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 0.65rem;">
                                                Total</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $rowCount }}</div>
                                        </div>
                                        <div class="col-auto">
                                            @if ($userDetails->role_id == 2 || $userDetails->role_id == 3 || $userDetails->role_id == 4)
                                                <a href="{{ route('office.applications.index', 'totalreceived') }}" class="btn btn-sm btn-primary py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            @elseif($userDetails->role_id == 5)
                                                <a href="{{ route('office.applications.index', 'receivedReroute') }}" class="btn btn-sm btn-primary py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- New Applications Received -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-left-warning shadow h-100">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 0.65rem;">
                                                Pending</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countPending }}</div>
                                        </div>
                                        <div class="col-auto">
                                            @if ($userDetails->role_id == 2 || $userDetails->role_id == 3 || $userDetails->role_id == 4)
                                                <a href="{{ route('office.applications.index', 'received') }}" class="btn btn-sm btn-warning py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-sm btn-primary py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @if ($userDetails->role_id == 2 || $userDetails->role_id == 3)
                        <!-- Applications Forwarded -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-info shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Forwarded for review</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countForwarded }}</div>
                                            </div>
                                            <div class="col-auto">

                                                <a href="{{ route('office.applications.index', 'forwarded') }}" class="btn btn-sm btn-info py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($userDetails->role_id == 4)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-info shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 0.65rem;">Verified
                                                </div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countForwarded }}</div>
                                            </div>
                                            <div class="col-auto">

                                                <a href="{{ route('office.applications.index', 'forwarded') }}" class="btn btn-sm btn-info py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($userDetails->role_id == 2 || $userDetails->role_id == 3)
                        <!-- Applications Approved -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-success shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Approved</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countApproved }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications.index', 'approved') }}" class="btn btn-sm btn-success py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications Rejected -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-danger shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Rejected</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countRejected }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications.index', 'rejected') }}" class="btn btn-sm btn-danger py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications Reverted -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-secondary shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Reverted</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countReverted }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications.index', 'reverted') }}" class="btn btn-sm btn-secondary py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications Reviewed By DA -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-info shadow h-100" style="border-left-color: #76b5c5 !important;">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 0.65rem; color: #76b5c5;">
                                                    Reviewed By DA</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countReviewed }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications.index', 'forwardedByDa') }}" class="btn btn-sm py-1 px-2" style="background-color: #76b5c5; color: white;">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications Pulled Back -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-dark shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Pulled Back</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countPullBack }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications.index', 'pulledback') }}" class="btn btn-sm btn-dark py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications Resubmitted -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-purple shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-purple text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Resubmitted</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countResubmitted }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications.index', 'resubmitted') }}" class="btn btn-sm btn-purple py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-danger shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Re-Routed</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countReRouted }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications.index', 'rerouted') }}" class="btn btn-sm btn-danger py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @if ($userDetails->role_id != 5)
            <button class="collapsible">
                <i class="fas fa-chevron-down icon"></i> Renewal
            </button>
            <div class="content">
                <div class="my-1" id="b-homedb">
                    <div class="container-fluid">
                        <div class="row g-4">
                            <!-- Total Applications Received -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-primary shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Total Applications</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countRenewal }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications-renewal.index', 'totalreceivedRenewal') }}" class="btn btn-sm btn-primary py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- New Applications Received -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-warning shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Pending Applications</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $renewal_Pending }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications-renewal.index', 'receivedRenewal') }}" class="btn btn-sm btn-warning py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications Forwarded -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-left-info shadow h-100">
                                    <div class="card-body p-3">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 0.65rem;">
                                                    Applications Forwarded</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countForwardedRenewal }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('office.applications-renewal.index', 'forwardedRenewal') }}" class="btn btn-sm btn-info py-1 px-2">
                                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @if ($userDetails->role_id == 2 || $userDetails->role_id == 3)
                            <!-- Applications Approved -->
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="card border-left-success shadow h-100">
                                        <div class="card-body p-3">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 0.65rem;">
                                                        Applications Approved</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countApprovedRenewal }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{ route('office.applications-renewal.index', 'approvedRenewal') }}" class="btn btn-sm btn-success py-1 px-2">
                                                        <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Applications Rejected -->
                                {{--<div class="col-xl-3 col-lg-4 col-md-6">--}}
                                    {{--<div class="card border-left-danger shadow h-100">--}}
                                        {{--<div class="card-body p-3">--}}
                                            {{--<div class="row no-gutters align-items-center">--}}
                                                {{--<div class="col mr-2">--}}
                                                    {{--<div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 0.65rem;">--}}
                                                        {{--Applications Rejected</div>--}}
                                                    {{--<div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countRejectedRenewal }}</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-auto">--}}
                                                    {{--<a href="#" class="btn btn-sm btn-danger py-1 px-2">--}}
                                                        {{--<i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="card border-left-purple shadow h-100">
                                        <div class="card-body p-3">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-purple text-uppercase mb-1" style="font-size: 0.65rem;">
                                                        Resubmitted</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countResubmittedRenewal }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{ route('office.applications-renewal.index', 'resubmittedRenewal') }}" class="btn btn-sm btn-purple py-1 px-2">
                                                        <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Applications Reverted -->
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="card border-left-secondary shadow h-100">
                                        <div class="card-body p-3">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1" style="font-size: 0.65rem;">
                                                        Applications Reverted</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countRevertedRenewal }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{ route('office.applications-renewal.index', 'RevertedtoApplicantByRo') }}" class="btn btn-sm btn-secondary py-1 px-2">
                                                        <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Applications Reviewed By DA -->
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="card border-left-info shadow h-100" style="border-left-color: #76b5c5 !important;">
                                        <div class="card-body p-3">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 0.65rem; color: #76b5c5;">
                                                        Reviewed By DA</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countReviewedRenewal }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{ route('office.applications-renewal.index', 'forwardedByDaRenewal') }}" class="btn btn-sm py-1 px-2" style="background-color: #76b5c5; color: white;">
                                                        <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Applications Pulled Back -->
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="card border-left-dark shadow h-100">
                                        <div class="card-body p-3">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1" style="font-size: 0.65rem;">
                                                        Pulled Back</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">{{ $countPullBackRenewal }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{ route('office.applications-renewal.index', 'pullBackRenewal') }}" class="btn btn-sm btn-dark py-1 px-2">
                                                        <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Applications Resubmitted -->

                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </div>

    <!-- show new registered Application -->
    <div class="container-fluid mt-2">
        <!-- New Applications Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-file-alt mr-2"></i>New Applications
                </h6>
            </div>

            <div class="card-body p-0">

                {{-- Pagination is now at the top of the card body --}}
                {{--@if ($data->hasPages())--}}
                {{--<div class="p-3">--}}
                {{--{{ $data->links() }}--}}
                {{--</div>--}}
                {{--@endif--}}

                @if ($data->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover my-table" style="font-size: 0.85rem;">
                            <thead class="bg-light">
                            <tr>
                                <th class="text-center py-2">Sl.no</th>
                                <th class="text-center py-2">Acknowledgement No</th>
                                <th class="text-center py-2">Status</th>
                                <th class="text-center py-2">Date</th>
                                <th class="text-center py-2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $application)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">{{ $application->ack_no }}</td>
                                    <td class="text-center align-middle">
                                        @if ($application->status == 'A' || $application->status == 'R')
                                            <span class="badge badge-danger">Pending</span>
                                        @elseif($application->status == 'O' && $application->da_forward == 1)
                                            <span class="badge badge-info">Reviewed By DA</span>
                                        @elseif($application->status == 'O')
                                            <span class="badge badge-primary">Forwarded By HRO</span>
                                        @elseif($application->status == 'C')
                                            <span class="badge badge-primary">Forwarded By RO</span>
                                        @elseif($application->status == 'C' && $application->da_forward == 1)
                                            <span class="badge badge-info">Reviewed By DA</span>
                                        @elseif($application->status == 'B' && $application->pull_back == 1)
                                            <span class="badge badge-warning">Pulled Back</span>
                                        @elseif($application->status == 'B' && $application->da_forward == 1)
                                            <span class="badge badge-info">Reviewed By RO</span>
                                        @elseif($application->status == 'M' && $application->re_route == 1)
                                            <span class="badge badge-primary">Re Routed</span>
                                        @elseif($application->status == 'N' && $application->re_route == 1)
                                            <span class="badge badge-primary">Forwarded by Head</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                    <span class="badge badge-light text-dark">
                                        @if ($application->status == 'A')
                                            {{ \Carbon\Carbon::parse($application->created_at)->format('d-m-Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($application->getApplicationStatus($application->worker_id, $application->status)->created_at)->format('d-m-Y') }}
                                        @endif
                                    </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('office.applications.preview', ['id' => encrypt($application->worker_id)]) }}"
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if ($userDetails->role_id == 2 || $userDetails->role_id == 3)
                            <div class="card-footer bg-light d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-danger btn-sm blink" id="openNewRegButton">
                                    <i class="fas fa-paper-plane mr-1"></i> Forward Bulk Applications
                                </button>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="m-3">No new applications to display</div>
                @endif
            </div>

            {{-- Footer now only contains the bulk action button --}}

        </div>



        <!-- Onboarding Applications Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-user-plus mr-2"></i>Onboarding Applications
                </h6>
            </div>
            <div class="card-body p-0">
                @if (count($onboarding_data) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover my-table" style="font-size: 0.85rem;">
                            <thead class="bg-light">
                            <tr>
                                <th class="text-center py-2">Sl.no</th>
                                <th class="text-center py-2">Acknowledgement No</th>
                                <th class="text-center py-2">Status</th>
                                <th class="text-center py-2">Date</th>
                                <th class="text-center py-2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($onboarding_data as $key => $onboarding)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">{{ $onboarding->ack_no }}</td>
                                    <td class="text-center align-middle">
                                        @if ($onboarding->status == 'A' || $onboarding->status == 'R')
                                            <span class="badge badge-danger">Pending</span>
                                        @elseif($onboarding->status == 'O' && $onboarding->da_forward == 1)
                                            <span class="badge badge-info">Reviewed By DA</span>
                                        @elseif($onboarding->status == 'O')
                                            <span class="badge badge-primary">Forwarded By HRO</span>
                                        @elseif($onboarding->status == 'C')
                                            <span class="badge badge-primary">Forwarded By RO</span>
                                        @elseif($onboarding->status == 'C' && $onboarding->da_forward == 1)
                                            <span class="badge badge-info">Reviewed By DA</span>
                                        @elseif($onboarding->status == 'B' && $onboarding->pull_back == 1)
                                            <span class="badge badge-warning">Pulled Back</span>
                                        @elseif($onboarding->status == 'B' && $onboarding->da_forward == 1)
                                            <span class="badge badge-info">Reviewed By RO</span>
                                        @elseif($onboarding->status == 'M' && $onboarding->re_route == 1)
                                            <span class="badge badge-secondary">Re Routed</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                <span class="badge badge-light text-dark">
                                    @if ($onboarding->status == 'A')
                                        {{ \Carbon\Carbon::parse($onboarding->created_at)->format('d-m-Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($onboarding->getApplicationStatus($onboarding->worker_id, $onboarding->status)->created_at)->format('d-m-Y') }}
                                    @endif
                                </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('office.applications.preview', ['id' => encrypt($onboarding->worker_id)]) }}"
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{--@if ($onboarding_data->hasPages())--}}
                    {{--<div class="d-flex justify-content-center mt-3">--}}
                    {{--{{ $onboarding_data->links() }}--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    @if ($userDetails->role_id == 2 || $userDetails->role_id == 3)
                        <div class="text-right mt-3 mr-3">
                            <button type="button" class="btn btn-danger btn-sm blink" id="openOnboardingModalButton">
                                <i class="fas fa-paper-plane mr-1"></i> Forward Bulk Applications
                            </button>
                        </div>
                    @endif
                @else
                    <div class="m-3">No onboarding applications to display</div>
                @endif
            </div>
        </div>

        <!-- Resubmitted Applications Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-redo mr-2"></i>Resubmitted Applications
                </h6>
            </div>
            <div class="card-body p-0">
                @if (count($resubmitted_data) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0 my-table" style="font-size: 0.85rem;">
                            <thead class="bg-light">
                            <tr>
                                <th class="text-center py-2">Sl.no</th>
                                <th class="text-center py-2">Application No</th>
                                <th class="text-center py-2">Status</th>
                                <th class="text-center py-2">Time</th>
                                <th class="text-center py-2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($resubmitted_data as $key => $resubmitted)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">{{ $resubmitted->ack_no }}</td>
                                    <td class="text-center align-middle">
                                        @if ($resubmitted->status == 'B' || $resubmitted->status == 'R')
                                            <span class="badge badge-danger">Pending</span>
                                        @elseif($resubmitted->status == 'B')
                                            <span class="badge badge-primary">Forwarded To RO</span>
                                        @elseif($resubmitted->status == 'O')
                                            <span class="badge badge-primary">Forwarded To HRO</span>
                                        @elseif($resubmitted->status == 'C')
                                            <span class="badge badge-primary">Forwarded By RO</span>
                                        @elseif($resubmitted->status == 'O' && $resubmitted->da_forward == 1)
                                            <span class="badge badge-info">Reviewed By DA</span>
                                        @elseif($resubmitted->status == 'B' && $resubmitted->da_forward == 1)
                                            <span class="badge badge-info">Reviewed By RO</span>
                                        @elseif($resubmitted->status == 'B' && $resubmitted->pull_back == 1)
                                            <span class="badge badge-warning">Pulled Back</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                <span class="badge badge-light text-dark">
                                    @if ($resubmitted->status == 'B' || $resubmitted->status == 'A')
                                        {{ \Carbon\Carbon::parse($resubmitted->created_at)->format('d-m-Y') }}
                                    @elseif($resubmitted->status == 'O')
                                        {{ \Carbon\Carbon::parse($resubmitted->forward_to_ro)->format('d-m-Y') }}
                                    @elseif($resubmitted->status == 'C')
                                        {{ \Carbon\Carbon::parse($resubmitted->forward_to_da)->format('d-m-Y') }}
                                    @endif
                                </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('office.applications.preview', ['id' => encrypt($resubmitted->worker_id)]) }}"
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($userDetails->role_id == 2 || $userDetails->role_id == 3)
                        <div class="text-right mt-3 mr-3">
                            <button type="button" class="btn btn-danger btn-sm blink" id="openResubmitModalButton">
                                <i class="fas fa-paper-plane mr-1"></i> Forward Bulk Applications
                            </button>
                        </div>
                    @endif
                @else
                    <div class="m-3">No resubmitted applications to display</div>
                @endif
            </div>
        </div>

        <!-- Renewal Applications Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-sync-alt mr-2"></i>Renewal Applications
                </h6>
            </div>
            <div class="card-body p-0">
                @if (count($dataRen) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0 my-table" style="font-size: 0.85rem;">
                            <thead class="bg-light">
                            <tr>
                                <th class="text-center py-2">Sl.no</th>
                                <th class="text-center py-2">Application No</th>
                                <th class="text-center py-2">Status</th>
                                <th class="text-center py-2">Time</th>
                                <th class="text-center py-2">Tag</th>
                                <th class="text-center py-2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dataRen as $key => $renew)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">{{ $renew->ack_no }}</td>
                                    <td class="text-center align-middle">
                                        @if ($renew->status == 'A')
                                            <span class="badge badge-danger">Pending</span>
                                        @elseif($renew->status == 'B')
                                            <span class="badge badge-primary">Forwarded To RO</span>
                                        @elseif($renew->status == 'C')
                                            <span class="badge badge-primary">Forwarded By RO</span>
                                        @elseif($renew->status == 'O' && $renew->da_forward == null)
                                            <span class="badge badge-primary">Forwarded By HRO</span>
                                        @elseif($renew->status == 'O' && $renew->da_forward == 1)
                                            <span class="badge badge-info">Reviewed By DA</span>
                                        @elseif($renew->status == 'B' && $renew->pull_back == 1)
                                            <span class="badge badge-warning">Pulled Back</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                <span class="badge badge-light text-dark">
                                    @if ($renew->status == 'A')
                                        {{ \Carbon\Carbon::parse($renew->created_at)->format('d-m-Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($renew->getApplicationStatus($renew->worker_id, $renew->status)->created_at)->format('d-m-Y') }}
                                    @endif
                                </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-success">Renewal</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('office.applications.preview-applications', ['id' => encrypt($renew->worker_id)]) }}"
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($userDetails->role_id == 2 || $userDetails->role_id == 3)
                        <div class="text-right mt-3 mr-3">
                            <button type="button" class="btn btn-danger btn-sm blink" id="openRenewalModalButton">
                                <i class="fas fa-paper-plane mr-1"></i> Forward Bulk Applications
                            </button>
                        </div>
                    @endif
                @else
                    <div class="m-3">No renewal applications to display</div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .card-header {
            border-bottom: 1px solid rgba(0,0,0,.1);
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #f8f9fa !important;
        }
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
        }
        .blink {
            animation: blink 1.5s infinite;
        }
        @keyframes blink {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                opacity: 1;
            <!-- Modal -->
            }
        }
    </style>




    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!--Show pull back application-->


    {{-- <div class="row my-5 mx-sm-5">
        <div class="col-md-12">
            <h4 class="text-center">Total Application Received</h4>
            <div style="margin-top:40px">
                <canvas id="verticalBarChart" width="700" height="400"></canvas>
            </div>
        </div>

    </div> --}}



    <div class="modal fade" id="xxxxx" tabindex="-1" role="dialog" aria-labelledby="onboardingModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="onboardingModalLabel"><i class="fa fa-paper-plane"
                                                                         aria-hidden="true"></i>&nbsp;Forward Bulk Applications</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="xxxx">
                        <div class="form-group">
                            <label for="numApplications" class="bold">Number of Applications you want to send
                                :</label>
                            <input type="number" id="numApplications" name="num_applications" class="form-control"
                                   placeholder="Enter number of applications you want to send" min="1" required>
                        </div>
                        <p id="maxApplicationsHelp" class="form-text text-muted font-weight-bold">
                            Total no of applications: <span
                                    class="badge badge-danger font-weight-bold">{{ $onboarding_Pending }}</span>
                        </p>
                        <div class="form-group">
                            <label for="" class="bold">Choose Role :</label>
                            <select name="receiver_role_id" class="form-control ro-select" id="" required>
                                @if (!$roles)
                                    <option value="">No Role Found</option>
                                @else
                                    <option value="" selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                @endif


                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Choose Username :</label>
                            <select name="user_id" id="" class="form-control user-dropdown" required>
                                <option value="">Select User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Enter Remarks :</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Close</button>
                    <button type="button" class="btn btn-warning" id="ddddd"><i
                                class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;Submit</button>
                </div>
            </div>
        </div>
    </div>




    <!--Re Submitted modal-->
    <div class="modal fade" id="reSubmitModal" tabindex="-1" role="dialog" aria-labelledby="resubmittedModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resubmittedModalLabel"><i class="fa fa-paper-plane"
                                                                          aria-hidden="true"></i>&nbsp;Forward Resubmitted Applications</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modalFormResubmit">
                        <div class="form-group">
                            <label for="numApplications" class="bold">Number of Applications you want to send
                                :</label>
                            <input type="number" id="numApplications" name="num_applications" class="form-control"
                                   placeholder="Enter number of applications you want to send" min="1" required>
                        </div>
                        <p id="maxApplicationsHelp" class="form-text text-muted font-weight-bold">
                            Total no of applications: <span
                                    class="badge badge-danger font-weight-bold">{{ $resubmitted_Pending }}</span>
                        </p>
                        <input type="hidden" name="type" value="3">
                        <div class="form-group">
                            <label for="" class="bold">Choose Role :</label>
                            <select name="receiver_role_id" class="form-control ro-select" id="" required>
                                @if (!$roles)
                                    <option value="">No Role Found</option>
                                @else
                                    <option value="" selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                @endif


                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Choose Username :</label>
                            <select name="user_id" id="" class="form-control user-dropdown" required>
                                <option value="">Select User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Enter Remarks :</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Close</button>
                    <button type="button" class="btn btn-warning" id="submitResubmittedModalButton"><i
                                class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="onboardingModal" tabindex="-1" role="dialog" aria-labelledby="onboardingModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="onboardingModalLabel"><i class="fa fa-paper-plane"
                                                                         aria-hidden="true"></i>&nbsp;Forward Onboarding Applications</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modalFormOnboarding">
                        <div class="form-group">
                            <label for="numApplications" class="bold">Number of Applications you want to send
                                :</label>
                            <input type="number" id="numApplications" name="num_applications" class="form-control"
                                   placeholder="Enter number of applications you want to send" min="1" required>
                        </div>
                        <p id="maxApplicationsHelp" class="form-text text-muted font-weight-bold">
                            Total no of applications: <span
                                    class="badge badge-danger font-weight-bold">{{ $onboarding_Pending }}</span>
                        </p>
                        <input type="hidden" name="type" value="2">
                        <div class="form-group">
                            <label for="" class="bold">Choose Role :</label>
                            <select name="receiver_role_id" class="form-control ro-select" id="" required>
                                @if (!$roles)
                                    <option value="">No Role Found</option>
                                @else
                                    <option value="" selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                @endif


                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Choose Username :</label>
                            <select name="user_id" id="" class="form-control user-dropdown" required>
                                <option value="">Select User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Enter Remarks :</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Close</button>
                    <button type="button" class="btn btn-warning" id="submitOnboardingModalButton"><i
                                class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="regModal1" tabindex="-1" role="dialog" aria-labelledby="resubmittedModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resubmittedModalLabel"><i class="fa fa-paper-plane"
                                                                          aria-hidden="true"></i>&nbsp;Forward New Applications</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modalFormReg">
                        <div class="form-group">
                            <label for="numApplications" class="bold">Number of Applications you want to send
                                :</label>
                            <input type="number" id="numApplications" name="num_applications" class="form-control"
                                   placeholder="Enter number of applications you want to send" min="1" required>
                        </div>
                        <p id="maxApplicationsHelp" class="form-text text-muted font-weight-bold">
                            Total no of applications: <span
                                    class="badge badge-danger font-weight-bold">{{ $new_Pending }}</span>
                        </p>
                        <input type="hidden" name="type" value="1">
                        <div class="form-group">
                            <label for="" class="bold">Choose Role :</label>
                            <select name="receiver_role_id" class="form-control ro-select" id="" required>
                                @if (!$roles)
                                    <option value="">No Role Found</option>
                                @else
                                    <option value="" selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                @endif


                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Choose Username :</label>
                            <select name="user_id" id="" class="form-control user-dropdown" required>
                                <option value="">Select User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Enter Remarks :</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Close</button>
                    <button type="button" class="btn btn-warning" id="submitRegModalButton"><i
                                class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--Renewal Modal-->
    <div class="modal fade" id="renewalModal" tabindex="-1" role="dialog" aria-labelledby="renewalModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resubmittedModalLabel"><i class="fa fa-paper-plane"
                                                                          aria-hidden="true"></i>&nbsp;Forward Renewal Applications</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modalFormRenewal">
                        <div class="form-group">
                            <label for="numApplications" class="bold">Number of Applications you want to send
                                :</label>
                            <input type="number" id="numApplications" name="num_applications" class="form-control"
                                   placeholder="Enter number of applications you want to send" min="1" required>
                        </div>
                        <p id="maxApplicationsHelp" class="form-text text-muted font-weight-bold">
                            Total no of applications: <span
                                    class="badge badge-danger font-weight-bold">{{ $renewal_Pending }}</span>
                        </p>
                        <input type="hidden" name="type" value="4">
                        <div class="form-group">
                            <label for="" class="bold">Choose Role :</label>
                            <select name="receiver_role_id" class="form-control ro-select" id="" required>
                                @if (!$roles)
                                    <option value="">No Role Found</option>
                                @else
                                    <option value="" selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                @endif


                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Choose Username :</label>
                            <select name="user_id" id="" class="form-control user-dropdown" required>
                                <option value="">Select User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="bold">Enter Remarks :</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter remarks" required></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Close</button>
                    <button type="button" class="btn btn-warning" id="submitRenewalModalButton"><i
                                class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const NewRegModalElement = document.getElementById("regModal1");
            const NewRegModalButton = document.getElementById("openNewRegButton");

            if (NewRegModalElement && NewRegModalButton) {
                const NewRegModal = new bootstrap.Modal(NewRegModalElement);

                NewRegModalButton.addEventListener("click", function () {
                    NewRegModalElement.setAttribute('aria-hidden', 'false'); // Ensure aria-hidden is false when modal opens
                    NewRegModal.show();

                });

                NewRegModalElement.addEventListener('hidden.bs.modal', function () {
                    NewRegModalElement.setAttribute('aria-hidden', 'true');
                    NewRegModalButton.focus(); // Return focus to the button that opened the modal
                });
            }
        });

    </script>
    <script>
        $('#submitRegModalButton').click(function (event) {
            event.preventDefault();
            // console.log($('#modalFormNew').serialize());
            $.ajax({
                type: 'POST',
                url: "{{ route('office.applications.send') }}",
                data: $('#modalFormReg').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                success: function (response) {
                    console.log("AJAX success response:", response);
                    if (response.status === true) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            showConfirmButton: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = "{{ route('office.dashboard.index') }}";
                            }
                        });

                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON;
                    let errorMessage = "Something went wrong.";

                    if (errors && errors.message) {
                        errorMessage = errors.message; // General error message
                    } else if (errors && errors.errors) {
                        errorMessage = Object.values(errors.errors).join("\n"); // Display validation errors
                    }

                    Swal.fire({
                        title: "Validation Error!",
                        text: errorMessage,
                        icon: "warning"
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const onBoardModalElement = document.getElementById("onboardingModal");
            console.log(onBoardModalElement);
            // Ensure the modal exists before proceeding
            if (onBoardModalElement) {
                const onBoardModal = new bootstrap.Modal(onBoardModalElement);
                const onBoardModalButton = document.getElementById("openOnboardingModalButton");

                if (onBoardModalButton) {
                    onBoardModalButton.addEventListener("click", function () {
                        onBoardModal.show();
                    });
                } else {
                    console.error("Button with ID 'openNewModalButton' not found.");
                }
            } else {
                console.error("Modal with ID 'NewRegModal' not found.");
            }
        });

    </script>
    <script>
        $(document).ready(function () {

            $('#submitOnboardingModalButton').click(function (event) {
                event.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('office.applications.send') }}",
                    data: $('#modalFormOnboarding').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log("AJAX success response:", response);
                        if (response.status === true) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    location.href = "{{ route('office.dashboard.index') }}";
                                }
                            });

                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON;
                        let errorMessage = "Something went wrong.";

                        if (errors && errors.message) {
                            errorMessage = errors.message;
                        } else if (errors && errors.errors) {
                            errorMessage = Object.values(errors.errors).join("\n");
                        }

                        Swal.fire({
                            title: "Validation Error!",
                            text: errorMessage,
                            icon: "warning"
                        });
                    }
                });

            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const reSubmitModalElement = document.getElementById("reSubmitModal");
            console.log(reSubmitModalElement);
            // Ensure the modal exists before proceeding
            if (reSubmitModalElement) {
                const reSubmitModal = new bootstrap.Modal(reSubmitModalElement);
                const reSubmitModalButton = document.getElementById("openResubmitModalButton");

                if (reSubmitModalButton) {
                    reSubmitModalButton.addEventListener("click", function () {
                        reSubmitModal.show();
                    });
                } else {
                    console.error("Button with ID 'openNewModalButton' not found.");
                }
            } else {
                console.error("Modal with ID 'NewRegModal' not found.");
            }
        });

    </script>
    <script>
        $(document).ready(function () {

            $('#submitResubmittedModalButton').click(function (event) {
                event.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('office.applications.send') }}",
                    data: $('#modalFormResubmit').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log("AJAX success response:", response);
                        if (response.status === true) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // $('#reSubmitModal').modal('hide'); // Close modal
                                    location.href = "{{ route('office.dashboard.index') }}";
                                }
                            });

                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    }
                    ,
                    error: function (xhr) {
                        let errors = xhr.responseJSON;
                        let errorMessage = "Something went wrong.";

                        if (errors && errors.message) {
                            errorMessage = errors.message; // General error message
                        } else if (errors && errors.errors) {
                            errorMessage = Object.values(errors.errors).join("\n");
                        }

                        Swal.fire({
                            title: "Validation Error!",
                            text: errorMessage,
                            icon: "warning"
                        });
                    }
                });

            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const renewalModalElement = document.getElementById("renewalModal");
            console.log(renewalModalElement);
            // Ensure the modal exists before proceeding
            if (renewalModalElement) {
                const renewalModal = new bootstrap.Modal(renewalModalElement);
                const renewalModalButton = document.getElementById("openRenewalModalButton");

                if (renewalModalButton) {
                    renewalModalButton.addEventListener("click", function () {
                        renewalModal.show();
                    });
                } else {
                    console.error("Button with ID 'openNewModalButton' not found.");
                }
            } else {
                console.error("Modal with ID 'NewRegModal' not found.");
            }
        });

    </script>
    <script>
        $(document).ready(function () {

            $('#submitRenewalModalButton').click(function (event) {
                event.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('office.applications.send') }}",
                    data: $('#modalFormRenewal').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log("AJAX success response:", response);
                        if (response.status === true) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // $('#reSubmitModal').modal('hide'); // Close modal
                                    location.href = "{{ route('office.dashboard.index') }}";
                                }
                            });

                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    }
                    ,
                    error: function (xhr) {
                        let errors = xhr.responseJSON;
                        let errorMessage = "Something went wrong.";

                        if (errors && errors.message) {
                            errorMessage = errors.message; // General error message
                        } else if (errors && errors.errors) {
                            errorMessage = Object.values(errors.errors).join("\n");
                        }

                        Swal.fire({
                            title: "Validation Error!",
                            text: errorMessage,
                            icon: "warning"
                        });
                    }
                });

            });
        });
    </script>

    <script>
            <?php
            // Assuming $chartData is an array of objects with 'year', 'month', and 'count' properties

            // Find the current year
            $currentYear = date('Y');

            // Prepare an array to hold the count of applications for each month
            $months = [];
            foreach ($chartData as $item) {
                // Only consider data for the current year
                if ($item->year == $currentYear) {
                    $months[$item->year][$item->month] = $item->count;
                }
            }

            // Create an array with all months of the current year and initialize the count to 0
            $allMonths = [];
            for ($month = 1; $month <= 12; $month++) {
                $allMonths[$currentYear][$month] = isset($months[$currentYear][$month]) ? $months[$currentYear][$month] : 0;
            }

            // Define colors for each month
            $monthColors = ['#3272b8', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9900', '#ff9966', '#33cc33', '#ff3399', '#3399ff', '#6666ff'];

            // Prepare the data for chart
            $labels = [];
            $data = [];
            $backgroundColors = [];
            foreach ($allMonths[$currentYear] as $month => $count) {
                // Get the three-letter abbreviation of the month
                $monthAbbreviation = date('M', strtotime("$currentYear-$month-01"));
                $labels[] = $monthAbbreviation . " $currentYear";
                $data[] = $count;
                // Assign background color for each month
                $backgroundColors[] = $monthColors[$month - 1]; // Subtracting 1 because months are 1-indexed but arrays are 0-indexed
            }
            ?>

        var ctx1 = document.getElementById('verticalBarChart');
        if (ctx1) {
            var myChart1 = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                        data: <?php echo json_encode($data); ?>,
                        backgroundColor: <?php echo json_encode($backgroundColors); ?>,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'No. of applications received',
                                fontSize: '16',
                                fontColor: '#000' // Set label color here
                            },
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Months',
                                fontSize: '16',
                                fontColor: '#000' // Set label color here
                            }
                        }]
                    },
                    legend: {
                        display: false // Hide the legend
                    }
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.ro-select').on('change', function() {
                var selectedRoleId = $(this).val();

                // Clear existing options in the user dropdown
                $('.user-dropdown').empty().append('<option value="">Loading...</option>');

                $.ajax({
                    url: '{{ route('office.dashboard.get-user-by-role') }}', // Replace with your API endpoint
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        role_id: selectedRoleId
                    },
                    success: function(response) {
                        // Clear the loading option
                        if (response.status == true) {
                            $('.user-dropdown').empty();

                            if (response.results && response.results.length > 0) {
                                // Append new options dynamically
                                $('.user-dropdown').append(
                                    '<option value="" disabled selected>Select User</option>'
                                );
                                response.results.forEach(function(user) {
                                    $('.user-dropdown').append('<option value="' + user
                                            .id +
                                        '">' + user.firstname +' '+user.lastname+ '</option>');
                                });
                            } else {
                                $('.user-dropdown').append(
                                    '<option value="">No Users Found</option>');
                            }
                        }
                    },
                    error: function() {
                        $('.user-dropdown').empty().append(
                            '<option value="">Error fetching users</option>');
                    }
                });
            });
        });


        $(document).ready(function() {
            $('.application-checkbox').on('change', function() {
                // Check if any checkbox is selected
                if ($('.application-checkbox:checked').length > 0) {
                    $('#openModalButton').removeClass('hidden');
                } else {
                    $('#openModalButton').addClass('hidden');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.my-table').DataTable({
                "paging": true, // Enable pagination
                "lengthChange": true, // Allow the user to change the number of items per page
                "searching": true, // Enable search functionality
                "ordering": true, // Enable column sorting
                "info": true, // Show information about the table (e.g., "Showing 1 to 10 of 50 entries")
                "autoWidth": false, // Disable automatic column width calculation
                "responsive": true, // Enable responsive design for mobile devices
                "language": {
                    "paginate": {
                        "previous": "Previous", // Customize pagination text
                        "next": "Next" // Customize pagination text
                    },
                    "search": "Search:", // Customize search label
                    "lengthMenu": "Show _MENU_ Applications per page", // Customize length menu label
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries" // Customize info text
                }
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var coll = document.getElementsByClassName("collapsible");

            for (var i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }

            // Open first collapsible by default
            if (coll.length > 0) {
                coll[0].classList.add("active");
                coll[0].nextElementSibling.style.display = "block";
            }
        });
    </script>
@endsection