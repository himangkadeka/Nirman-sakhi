<div class="tabs">
    <a href="{{ route('office.lc-lm-dashboard.dashboard.index') }}"
        class="tab-button @if (Route::is('office.lc-lm-dashboard.dashboard.index')) active @endif">Budgets Approval</a>
    <a href="{{ route('office.lc-lm-dashboard.applications-tosign') }}"
        class="tab-button @if (Route::is('office.lc-lm-dashboard.applications-tosign')) active @endif">PPA Signing</a>
    {{-- <a href="" class="tab-button">PPA & Voucher</a> --}}
    {{-- <a href="" class="tab-button"> Forward to DLC for Review</a> --}}
</div>
