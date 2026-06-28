<div class="dashboard-bgcolor border-right border-bottom" id="sidebar-wrapper">
    <div class="sidebar-heading text-sm-left b-db-color" style="font-size: 18px">
        <span class="fas fa-user"></span> &nbsp;<span>{{ $getVaultData['name'] ?? 'Worker' }}</span>
            
        </span>
    </div>
    <div class="list-group list-group-flush b-leftmenu">
        <ul id="sortable-menu" class="list-unstyled">
            {{-- @if ($workerData->payment_status !== 'pending') --}}
            <li>
                <a href='{{ route('worker-dashboard') }}'
                   class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Request::is('worker-dashboard') ? 'active' : '' }}">
                    Dashboard <i class="fa fa-tachometer" aria-hidden="true"></i>
                </a>
            </li>
            {{--            @if ($current_date <= $wmf->renewal_date)--}}
            {{--                <li>--}}
            {{--                    <a href='{{ route('payment-table') }}'--}}
            {{--                        class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Request::is('payment-table') ? 'active' : '' }}">--}}
            {{--                        Payment Details<i class="fa fa-credit-card" aria-hidden="true"></i>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--            @endif--}}
            @php
                $sessionDataLeft = session()->get('worker');
        $workerId= $sessionDataLeft->worker_id;
            @endphp

            @if ($sessionDataLeft->already_registered == null && $current_date <= $sessionDataLeft->renewal_date)

                <ul class="list-unstyled">
                    {{--                        @if($renewal_date->lte($current_date)) <!-- Check if renewal_date is in the past -->--}}
                    <li>
                        <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{  Route::currentRouteName() == 'worker-subscription' ? 'active' : '' }}"
                           href='{{ route('worker-subscription') }}'>
                            Subscription Payment <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </a>
                    </li>


                </ul>
            @endif
            @php

                $sessionDataLeft = session()->get('worker');
                   $workerId= $sessionDataLeft->worker_id;

                   if (\App\Models\RenewWorkerForm::where('worker_id', $workerId)->exists()) {
                                   $renewal_data = \App\Models\RenewWorkerForm::where('worker_id', $workerId)->latest()->first();
                                   if ($renewal_data->status != 'F') {
                                       $isRenewal = false;
                                       $isRenewApplied = true;
                                   }
                               }
                               else{

                               $isRenewApplied = false;
                                $isRenewal = false;
                               $isRenewalApproved =false;
                               }

                               if (\App\Models\RenewWorkerForm::where('worker_id', $workerId)->exists())
                               {
                                 $is_app_paid = false;
                                 $renewal_app = \App\Models\RenewWorkerForm::where('worker_id', $workerId)->latest()->first();
                                   if ($renewal_app->status == 'F') {

                                        $isRenewal = false;
                                       $isRenewalApproved = true;
                                        $sub = \App\Models\WorkerSubscription::where('worker_id', $workerId)->latest()->first();

                                    if ($sub)
                                    {
                                        if ($sub->payment_status == 1) {
                                            $is_app_paid = true;
                                        }
                                        else{
                                            $is_app_paid = false;
                                        }
                                    }else{
                                        $is_app_paid = false;
                                    }
                                        $isRenewal = false;
                                        $isRenewApplied = false;
                                   }else{
                                    $isRenewalApproved =false;
                                     $isRenewal = false;
                                     $isRenewApplied = true;
                                      $is_app_paid = false;
                                   }
                               }
            @endphp

            <li>
                <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Route::currentRouteName() == 'my-subscription' ? 'active' : ''  }}"
                   href='{{ route('my-subscription') }}'>
                    My Subscription <i class="fa fa-ticket" aria-hidden="true"></i>
                </a>
            </li>
            @if($isRenewal)
                <li>
                    <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Route::currentRouteName() =='worker-subscription-new' ? 'active' : '' }}"
                       href='{{ route('worker-subscription-new') }}'>
                        Subscription Payment <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </a>

                </li>
            @endif

            {{--@if($isRenewalApproved)--}}
            {{--<li>--}}
            {{--<a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{  Route::currentRouteName() == 'worker-subscription-new' ? 'active' : '' }}"--}}
            {{--href='{{ route('worker-subscription-new') }}'>--}}
            {{--Subscription Payment <i class="fa fa-shopping-cart" aria-hidden="true"></i>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--@endif--}}

            @php
                $isRenewal = false;
                $sessionDataLeft = session()->get('worker');
                $workerId= $sessionDataLeft->worker_id;
                $wmf = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();

                 $id_card_expiry_date = \Carbon\Carbon::parse($wmf->id_card_expiry_date) ;
                    $record['renewal_date'] = $id_card_expiry_date->copy()->addDay();;
                            $renewal_date = $record['renewal_date'];


                            $retirement_date = \Carbon\Carbon::parse($wmf->date_of_retirement) ;
            //                if ($renewal_date>$id_card_expiry_date)
            //                {
            //                    $isRenewal = 'true';
            //
            //                }

                            $current_date = \Carbon\Carbon::now();
                            if($renewal_date<=$current_date){
                               if ($retirement_date == $id_card_expiry_date) {
                                $isRenewal = false;
                            } else {
                                $isRenewal = true;
                            }
                            }

                            if(\App\Models\RenewWorkerForm::where('worker_id',$workerId)->exists()){
                                $renewal_data = \App\Models\RenewWorkerForm::where('worker_id',$workerId)->latest()->first();
                                if($renewal_data->status!='F'){
                                    $isRenewal=false;
                                }
                            }


            if (\App\Models\WorkerSubscription::where('worker_id', $workerId)->exists())
                {

                $sub = \App\Models\WorkerSubscription::where('worker_id', $workerId)->latest()->first();


                                if ($sub->payment_status == '1') {
                                    $is_app_paid = true;
                                }
                                else{
                                    $is_app_paid = false;
                                }
                }

            @endphp
            @if($isRenewal)

                <li>
                    <a href="{{route('renew-application')}}"
                       class="dashboard-bgcolor b-db-color border-bottom b-newpage {{  Route::currentRouteName() == 'renew-application' ? 'active' : '' }}">
                        Renewal <i class="fa fa-tachometer" aria-hidden="true"></i>
                    </a>
                </li>

            @endif
            {{-- @endif --}}

            @php
                $sessionDataLeft = session()->get('worker');
                   $worker_id= $sessionDataLeft->worker_id;
                   if (\App\Models\WorkerSubscription::where('worker_id', $worker_id)->exists()) {
                                   $sub = \App\Models\WorkerSubscription::where('worker_id', $worker_id)->latest()->first();
                                   if ($sub->payment_status == '1') {
                                       $is_paid = true;
                   //                    $isRenewApplied = true;
                                   }
                                   else{
                                       $is_paid = false;
                                   }
                               }
            @endphp
            @if ($sessionDataLeft->already_registered == 1)
                @if ($wmf->status == 'F'  && !$isRenewApplied && !$isRenewalApproved)
                    <li>
                        <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Route::currentRouteName() == 'idcards.index' ? 'active' : '' }}"
                           href="{{ route('idcards.index') }}">
                            ID Card
                        </a>
                    </li>

                @endif
            @else
                @if ($wmf->status == 'F'  && $wmf->active_status == 1 && $is_paid)
                    <li>
                        <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{ Route::currentRouteName() == 'idcards.index' ? 'active' : '' }}"
                           href="{{ route('idcards.index') }}">
                            ID Card
                        </a>
                    </li>

                @endif
            @endif

            @if ($sessionDataLeft->already_registered == 1 && !$isRenewApplied)
                <li>
                    <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{  Route::currentRouteName() == 'worker-subscription-new' ? 'active' : '' }}"
                       href='{{ route('worker-subscription-new') }}'>
                        Subscription Payment<i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </a>
                </li>
            @endif

            @if($sessionDataLeft->is_renewal == 1)
                <li>
                    <a class="dashboard-bgcolor b-db-color border-bottom b-newpage {{  Route::currentRouteName() == 'worker-renewal-history' ? 'active' : '' }}"
                       href='{{ route('worker-renewal-history') }}'>
                        Renewal History<i class="fa fa-history"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
