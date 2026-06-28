<div class="tabs">
    <a href="{{ route('office.dlc-dashboard.dashboard.index') }}"
        class="tab-button @if (Route::is('office.dlc-dashboard.dashboard.index')) active @endif">Received from Finance</a>
    <a href="{{ route('office.dlc-dashboard.forwardedToLc') }}"
        class="tab-button @if (Route::is('office.dlc-dashboard.forwardedToLc')) active @endif">Forwarded to LC</a>
    <a href="{{ route('office.dlc-dashboard.signedPPA') }}" class="tab-button @if (Route::is('office.dlc-dashboard.signedPPA')) active @endif">PPA & Voucher</a>
    {{-- <a href="" class="tab-button"> Forward to DLC for Review</a> --}}
</div>
