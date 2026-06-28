@extends('layouts.admin-app')

@section('title', 'Admin | PFC Wise Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'PFC Wise Data')

@section('style')
    <style>
        .user-info {
            background-color: #F5F5F5;
            /* Light gray background */
            padding: 10px;
            border-radius: 5px;
        }

        .bg-info {
            background-color: #17a2b8 !important;
            color: white;
        }




        .bg-warning {
            background-color: !important;
            color: white;
        }

        .bg-danger {
            /* background-color: #17a2b8 !important; */
            color: white;
        }




        .bg-success {
            /* background-color: !important; */
            color: white;
        }

        .bg-secondary {
            color: white;
        }

        .bg-primary {
            color: white;
        }

        #sortable-cards {
            display: flex;
            flex-wrap: wrap;
            /* Ensures responsiveness */
            justify-content: space-between;
            /* Distributes evenly */
        }

        .b-customize {
            flex: 1;
            /* Each column takes equal width */
            min-width: 100px;
            /* Ensures proper responsiveness on smaller screens */
            max-width: 19%;
            /* Controls width to maintain equal distribution */
        }

        @media(max-width:2560px) {
            .b-dbcard {
                height: 88px;
                display: flex;
                margin-bottom: 10px;
                border-radius: 12px;
                align-items: center;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid">


        <div class="row  text-center py-4 " id="sortable-cards" style="width:100%;">
            <div class="b-customize">
                <div class="p-2 b-dbcard" style="background-color: #f29292;">

                    <div class="" style="color: white;">
                        <p class="text-center font-weight-bold" style="font-size: 14px;">No. of Transactions
                        </p>
                        <h3 class="text-center font-weight-bold" style="margin-top: -5px; font-size: 13px;">
                            {{ $totalTransactions }}</h3>
                        <div class="text-left" style="margin: 5px 0px 5px;">
                            <span class="badge badge-success"></span>
                            <span style="font-size:12px;"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" b-customize">
                <div class=" p-2 b-dbcard" style="background-color: #0cb0aa;">

                    <div class="" style="color: white;">
                        <p class="text-center font-weight-bold" style="font-size: 14px;">New Registration
                        </p>
                        <h3 class="text-center font-weight-bold" style="margin-top: -5px; font-size: 13px;">
                            {{ $totalNewWorkers }}</h3>
                        <div class="text-left" style="margin: 10px 0px 5px;">
                            <span class="badge badge-success"></span>
                            <span style="font-size:12px;"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" b-customize">
                <div class=" p-2 b-dbcard" style="background-color: #3dc6cb;">

                    <div class="" style="color: white;">
                        <p class="text-center font-weight-bold" style="font-size: 14px;">Onboarding
                        </p>
                        <h3 class="text-center font-weight-bold" style="margin-top: -5px; font-size: 13px;">
                            {{ $totalOnboarding }}</h3>
                        <div class="text-left" style="margin: 10px 0px 5px;">
                            <span class="badge badge-success"></span>
                            <span style="font-size:12px;"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" b-customize">
                <div class="  p-2 b-dbcard" style="background-color: #edd289;">

                    <div class="" style="color: white;">
                        <p class="text-center font-weight-bold" style="font-size: 14px;">Subscription
                        </p>
                        <h3 class="text-center font-weight-bold" style="margin-top: -5px; font-size: 13px;">
                            {{ $totalSubscriptions }}</h3>
                        <div class="text-center" style="margin: 10px 0px 5px;">
                            <span class="badge badge-success"></span>
                            <span style="font-size:12px;"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="b-customize">
                <div class="p-2 b-dbcard" style="background-color: #4848489e;">

                    <div class="" style="color: white;">
                        <p class="text-center font-weight-bold" style="font-size: 14px;">Renewal
                        </p>
                        <h3 class="text-center font-weight-bold" style="margin-top: -5px; font-size: 13px;">
                            {{ $totalRenewals }}</h3>
                        <div class="text-left" style="margin: 10px 0px 5px;">
                            <span class="badge badge-success"></span>
                            <span style="font-size:12px;"></span>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        {{--<div class="row">--}}

            {{--<div class="col-md-12 table-responsive">--}}

                {{--<table id="abaocTable0" class="table table-bordered text-nowrap display nowrap">--}}
                    {{--<thead class="thead-dark">--}}
                    {{--<tr>--}}
                        {{--<th>Sno.</th>--}}
                        {{--<th>PFC/CSC Name</th>--}}
                        {{--<th>User Type</th>--}}
                        {{--<th>Total No. of Transactions</th>--}}
                        {{--<th>Onboarding Registration</th>--}}
                        {{--<th>New Worker Registration</th>--}}
                        {{--<th>Worker Subscription</th>--}}
                        {{--<th>Worker Renewal</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--@foreach ($pfcs as $pfc)--}}
                        {{--<tr>--}}
                            {{--<td>{{ $loop->iteration }}</td>--}}
                            {{--<td>{{ $pfc->kiosk_name ? $pfc->kiosk_name : 'NA' }}</td>--}}
                            {{--<td>{{ $pfc->user_type }}</td>--}}
                            {{--<td>{{ $pfc->getCount($pfc->kiosk_registration_id) }}</td>--}}
                            {{--<td>{{ $pfc->getOnboardingCount($pfc->kiosk_registration_id) }}</td>--}}
                            {{--<td>{{ $pfc->getNewWorkerCount($pfc->kiosk_registration_id) }}</td>--}}
                            {{--<td>{{ $pfc->getSubscriptionCount($pfc->kiosk_registration_id) }}</td>--}}
                            {{--<td>{{ $pfc->getRenewalCount($pfc->kiosk_registration_id) }}</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="row">

            <div class="col-md-12 table-responsive">
                <form method="GET" action="{{ route('admin.pfcwise.index') }}" class="mb-3">
                    <div class="input-group my-3">
                        <div class="col-8">
                            <a href="{{ route('admin.pfcwise.export', 'csv') }}"
                               class="btn btn-secondary btn-sm">
                                CSV</a>

                            <a href="{{ route('admin.pfcwise.export', 'xlsx') }}" class="btn btn-secondary btn-sm">
                                Excel</a>
                            <a href="{{ route('admin.pfcwise.export', 'pdf') }}" class="btn btn-secondary btn-sm">
                                PDF</a>
                        </div>
                        <div class="col-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by Worker ID"
                                   value="{{ request('search') }}" style="max-width:90%;">
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>

                </form>

                <table id="" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                    <tr>
                        <th>Sno.</th>
                        <th>PFC/CSC Name</th>
                        <th>User Type</th>
                        <th>Total No. of Transactions</th>
                        <th>Onboarding Registration</th>
                        <th>New Worker Registration</th>
                        <th>Worker Subscription</th>
                        <th>Worker Renewal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($pfcs as $pfc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pfc->kiosk_name ? $pfc->kiosk_name : 'NA' }}</td>
                            <td>{{ $pfc->user_type }}</td>
                            <td>{{ $pfc->getCountTemp($pfc->kiosk_registration_id) }}
                            </td>
                            <td>{{ $pfc->getOnboardingCountTemp($pfc->kiosk_registration_id)  }}
                            </td>
                            <td>{{ $pfc->getNewWorkerCountTemp($pfc->kiosk_registration_id)  }}</td>
                            <td>{{ $pfc->getSubscriptionCount($pfc->kiosk_registration_id) }}</td>
                            <td>{{ $pfc->getRenewalCount($pfc->kiosk_registration_id) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $pfcs->links() }}
    </div>

@endsection
