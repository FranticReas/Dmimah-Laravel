<aside id="sidebar" :class="{ collapsed: sidebarCollapsed }">
    <div class="d-flex justify-content-between align-items-center p-4">
        <div class="sidebar-logo">
            <a href="{{ route('dashboard.index') }}">
                <img src="{{ asset('images/logodonat.png') }}" alt="Dmamah" class="logo-img">
            </a>
        </div>
        <button class="toggle-btn" type="button" @click="toggleSidebar">
            <ion-icon :name="sidebarCollapsed ? 'menu' : 'close-outline'"></ion-icon>
        </button>
    </div>

    <ul class="sidebar-nav">
        <li class="sidebar-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}" class="sidebar-link">
                <ion-icon name="home-outline"></ion-icon><span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('customer.*') ? 'active' : '' }}">
            <a href="{{ route('customer.index') }}" class="sidebar-link">
                <ion-icon name="people-outline"></ion-icon><span>Customer</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('product.*') ? 'active' : '' }}">
            <a href="{{ route('product.index') }}" class="sidebar-link">
                <ion-icon name="cube-outline"></ion-icon><span>Produk</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('order.*') ? 'active' : '' }}">
            <a href="{{ route('order.index') }}" class="sidebar-link">
                <ion-icon name="cart-outline"></ion-icon><span>Orders</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('stock.*') ? 'active' : '' }}">
            <a href="{{ route('stock.index') }}" class="sidebar-link">
                <ion-icon name="clipboard-outline"></ion-icon><span>Stock</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="sidebar-link">
            <ion-icon name="log-out-outline"></ion-icon><span>Logout</span>
        </a>
    </div>
</aside>