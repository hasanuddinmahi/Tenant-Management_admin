<div class="sidebar" id="sidebar" style="width: 250px;">
    <div class="p-3">
        {{-- <h4 class="text-white text-center">Dashboard</h4>
        <hr class="bg-secondary"/> --}}
    </div>
    <ul class="nav flex-column px-3">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('booking*') ? 'active' : '' }}" href="/booking"><i class="bi bi-envelope"></i> <span>Booking</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('tenant*') ? 'active' : '' }}" href="/tenant"><i class="bi bi-people"></i> <span>Tenant</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('maintenance*') ? 'active' : '' }}" href="/maintenance"><i class="bi bi-gear"></i> <span>Maintenance</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('apartment*') ? 'active' : '' }}" href="/apartment"><i class="bi bi-question-circle"></i> <span>Apartment</span></a>
        </li>
    </ul>
</div>
