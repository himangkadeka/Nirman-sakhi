<ul class="nav nav-tabs mt-4">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('profile.basic') ? 'active' : '' }}" href="{{ route('profile.basic') }}">Basic Details</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('profile.family') ? 'active' : '' }}" href="{{ route('profile.family') }}">Family Details</a>
    </li>
</ul>
