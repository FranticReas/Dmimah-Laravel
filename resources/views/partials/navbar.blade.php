<nav class="navbar navbar-expand px-4 py-2">
    <div class="d-flex align-items-center me-3">
        <a href="{{ route('dashboard.index') }}">
            <img src="{{ asset('images/logodonat1.png') }}" alt="Dmamah" class="logo-navbar-toggle">
        </a>
    </div>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ms-auto align-items-center gap-3">
            <li>
                <span class="fw-semibold" style="font-size:0.9rem;color:#1c1410;">
                    {{ auth()->user()->name }}
                </span>
            </li>
            <li class="nav-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                    <img src="{{ asset('images/mybini.jpeg') }}" class="avatar img-fluid rounded-circle" alt="avatar">
                </a>
                <div class="dropdown-menu dropdown-menu-end rounded-3 border-0 shadow mt-2" style="min-width:180px;">
                    <div class="px-3 py-2 border-bottom mb-1">
                        <small class="text-muted d-block" style="font-size:0.72rem;">Masuk sebagai</small>
                        <strong style="font-size:0.85rem;">{{ auth()->user()->name }}</strong>
                    </div>
                    <a href="{{ route('register') }}" class="dropdown-item" style="font-size:0.85rem;">
                        <ion-icon name="person-add-outline"
                            style="vertical-align:middle;margin-right:6px;"></ion-icon>Register
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item text-danger" style="font-size:0.85rem;">
                        <ion-icon name="log-out-outline"
                            style="vertical-align:middle;margin-right:6px;"></ion-icon>Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>