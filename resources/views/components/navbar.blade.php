<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <button class="btn btn-outline-secondary me-2" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand" href="#">Admin Panel</a>

        <div class="d-flex align-items-center ms-auto gap-3">
            <!-- Language Selector -->
            {{-- <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    🌐 {{ strtoupper(app()->getLocale()) }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">🇺🇸 English</a></li>
                    <li><a class="dropdown-item" href="{{ route('language.switch', 'fr') }}">🇫🇷 Français</a></li>
                </ul>
            </div> --}}


            <!-- User Profile Dropdown -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <img src="https://via.placeholder.com/40" alt="Profile" class="profile-img me-2 rounded-circle" style="width: 32px; height: 32px;"> --}}
                    <span class="d-none d-sm-inline">John Doe</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-bell me-2"></i> Notifications</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
