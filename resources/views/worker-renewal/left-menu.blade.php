<div class="dashboard-bgcolor border-right border-bottom" id="sidebar-wrapper">
    <div class="sidebar-heading text-sm-left b-db-color" style="font-size: 18px">
        <span class="fas fa-user"></span> &nbsp;<span>{{$getVaultData['name']}}</span>
    </div>
    <div class="list-group list-group-flush b-leftmenu">
        <ul id="sortable-menu" class="list-unstyled">
            {{-- @if ($wmf->payment_status !== 'pending') --}}
{{--            <li>--}}
{{--                <a href='{{ route('worker-dashboard') }}'--}}
{{--                   class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Request::is('worker-dashboard') ? 'active' : '' }}">--}}
{{--                    Dashboard <i class="fa fa-tachometer" aria-hidden="true"></i>--}}
{{--                </a>--}}
{{--            </li>--}}
            @if ($current_date <= $wmf->renewal_date)
                <li>
                    <a href='{{ route('payment-table') }}'
                       class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Request::is('payment-table') ? 'active' : '' }}">
                        Payment Details<i class="fa fa-credit-card" aria-hidden="true"></i>
                    </a>
                </li>
            @endif

            @if ($wmf->status === 'F' && $current_date <= $wmf->renewal_date)
                <li class="sub-menu">
                    <a href="javascript:void(0)" class="dashboard-bgcolor border-bottom b-db-color b-newpage">
                        Subscription <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </a>
                    <ul class="list-unstyled">
                        <li>
                            <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Request::is('worker-subscription') ? 'active' : '' }}"
                               href='{{ route('worker-subscription') }}'>
                                Subscription <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Request::is('my-subscription') ? 'active' : '' }}"
                               href='{{ route('my-subscription') }}'>
                                My Subscription <i class="fa fa-ticket" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                @if ($current_date <= $wmf->renewal_date)
                    <li class="sub-menu">
                        <a href="javascript:void(0)"
                           class="dashboard-bgcolor border-bottom b-db-color b-newpage {{ Request::is('worker-claimed-schemes') ? 'active' : '' }}">
                            90 Days Certificate <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </a>
                        <ul class="list-unstyled">
                            <li>
                                <a href='{{ route('all-ninety-days-certificate') }}'
                                   class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Request::is('ninety-days-certificate') ? 'active' : '' }}">
                                    All Certificates
                                </a>
                            </li>
                            <li>
                                <a href='{{ route('create-new-certificate') }}' class="dashboard-bgcolor b-db-color border-bottom b-newpage">
                                    Create New Certificate
                                </a>
                            </li>
                            <li>
                                <a class="dashboard-bgcolor b-db-color border-bottom b-newpage" href='{{route('upload-new-certificate')}}'>
                                    Upload Certificate
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
            {{-- @endif --}}

            @if ($renewal_date->gt($current_date) && $wmf->status === 'F' && $wmf->active_status == 1)
                <li>
                    <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Request::is('idcards.index') ? 'active' : '' }}"
                       href="{{ route('idcards.index') }}">
                        ID Card
                    </a>
                </li>
                <li>
                    <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Request::is('receipts.index') ? 'active' : '' }}"
                       href="{{ route('receipts.index') }}">
                        View Receipts
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:void(0)"
                       class="dashboard-bgcolor border-bottom b-db-color b-newpage {{ Request::is('worker-claimed-schemes') ? 'active' : '' }}">
                        Schemes <i class="fa fa-files-o right"></i>
                    </a>
                    <ul class="list-unstyled">
                        <li>
                            <a class="b-newpage {{ Request::is('worker-claimed-schemes') ? 'active' : '' }}"
                               href='{{ route('worker-claimed-schemes') }}'>
                                Claimed Schemes
                            </a>
                        </li>
                        <li>
                            <a class="b-newpage {{ Request::is('worker-list') ? 'active' : '' }}" href='#'>
                                List
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
