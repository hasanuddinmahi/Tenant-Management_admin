<div class="sidebar" id="sidebar" style="width: 250px;">
    <div class="p-3">
        {{-- <h4 class="text-white text-center">Dashboard</h4>
        <hr class="bg-secondary"/> --}}
    </div>
    <ul class="nav flex-column px-3">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard"><i
                    class="fa-solid fa-compass"></i><span>Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('booking*') ? 'active' : '' }}" href="/booking"><i
                    class="fa-solid fa-briefcase"></i><span>Booking</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('tenant*') ? 'active' : '' }}" href="/tenant"><i
                    class="fa-solid fa-users"></i><span>Tenant</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('expense*') ? 'active' : '' }}" href="/expense"><i
                    class="fa-solid fa-gears"></i> <span>Expense</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('apartment*') ? 'active' : '' }}" href="/apartment"><i
                    class="fa-solid fa-building"></i> <span>Apartment</span></a>
        </li>
    </ul>
</div>
