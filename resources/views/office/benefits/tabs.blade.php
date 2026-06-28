<div class="tab-buttons">
                    <a href="{{route('office.dashboard.benefit.report')}}" class="tab-button @if(Route::is('office.dashboard.benefit.report')) active @endif" data-tab="tab1">Dashboard & Reports</a>
                    <a href="{{ route('office.dashboard.benefits') }}" class="tab-button @if(Route::is('office.dashboard.benefits')) active @endif" data-tab="tab2">Submitted Applications</a>
                    @if (Auth::user()->role_id == 2)
                        <a href="{{route('office.dashboard.scrutiny.dashboard')}}" class="tab-button @if(Route::is('office.dashboard.scrutiny.dashboard')) active @endif" data-tab="tab3">Scrutiny Scheduling</a>
                        <a href="{{route('office.dashboard.benefit.ho-forwarding')}}" class="tab-button @if(Route::is('office.dashboard.benefit.ho-forwarding')) active @endif" data-tab="tab4">HO Forwarding</a>
                    @endif
                    <a href="" class="tab-button" data-tab="tab5">Application History</a>
                    <a href="" class="tab-button" data-tab="tab6">Notifications</a>
                </div>
