<div class="tabs">
    <a href="{{ route('office.head-office-da.dashboard.index') }}" class="tab-button @if(Route::is('office.head-office-da.dashboard.index')) active @endif">Incoming</a>
    <a href="{{ route('office.head-office-da.ppa-generation') }}" class="tab-button @if(Route::is('office.head-office-da.ppa-generation')) active @endif">PPA Generation</a>
    <a href="{{route('office.head-office-da.final-disbursed')}}" class="tab-button @if(Route::is('office.head-office-da.final-disbursed')) active @endif">Final Disbursed</a>

</div>
