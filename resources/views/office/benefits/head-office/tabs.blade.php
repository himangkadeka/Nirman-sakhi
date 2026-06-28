<div class="tabs">
    <a href="{{ route('office.head-office.dashboard.index') }}" class="tab-button @if(Route::is('office.accounts.dashboard.index')) active @endif">Account Processing</a>
    <a href="{{ route('office.head-office.dashboard.processing') }}" class="tab-button @if(Route::is('office.head-office.dashboard.processing')) active @endif">Forward to HO DA</a>
    <a href="{{ route('office.head-office.dashboard.hda-reviewed') }}" class="tab-button @if(Route::is('office.head-office.dashboard.hda-reviewed')) active @endif">HO DA Review</a>
    <a href="{{ route('office.head-office.dashboard.accounts') }}" class="tab-button @if(Route::is('office.head-office.dashboard.accounts')) active @endif"> Accounts</a>
    <a href="{{route('office.head-office.dashboard.lm-approved')}}" class="tab-button @if(Route::is('office.head-office.dashboard.lm-approved')) active @endif"> LM Approved</a>
    <a href="{{route('office.head-office.dashboard.ppa-dispatch')}}" class="tab-button @if(Route::is('office.head-office.dashboard.ppa-dispatch')) active @endif">PPA Dispatch</a>
    <a href="{{route('office.head-office.dashboard.lm-signed')}}" class="tab-button @if(Route::is('office.head-office.dashboard.lm-signed')) active @endif"> PPA Received</a>
    {{-- <a href="{{route('office.head-office.dashboard.lm-approved')}}" class="tab-button @if(Route::is('office.head-office.dashboard.lm-approved')) active @endif"> MIS</a> --}}
        {{-- <button onclick="openTab(event,'history')">9. History</button>--}}
</div>
