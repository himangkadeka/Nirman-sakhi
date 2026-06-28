<div class="tabs">
    <a href="{{ route('office.accounts.dashboard.index') }}"
        class="tab-button @if (Route::is('office.accounts.dashboard.index')) active @endif">Incoming</a>
    <a href="{{ route('office.accounts.forwarded-to-dlc') }}"
        class="tab-button @if (Route::is('office.accounts.forwarded-to-dlc')) active @endif">Forwarded To DLC</a>
    <a href="{{ route('office.accounts.received-ppa') }}" class="tab-button @if (Route::is('office.accounts.received-ppa')) active @endif">Received PPA & Voucher</a>
    <a href="{{ route('office.accounts.forwardToDlcForReview') }}" class="tab-button @if (Route::is('office.accounts.forwardToDlcForReview')) active @endif"> Forward to DLC for Review</a>
</div>
