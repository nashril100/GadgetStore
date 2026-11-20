<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
    aria-label="Navigasi utama">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-mobile-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Gadget Store</div>
    </a>

    <hr class="sidebar-divider my-0">

    <div class="sidebar-heading">Menu utama</div>

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Katalog</div>

    <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('products.index') }}">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Semua produk</span>
        </a>
    </li>

    @if (auth()->user()->isAdmin())
        <li class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <i class="fas fa-fw fa-tags"></i>
                <span>Kategori</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Kelola data</div>

        <li class="nav-item {{ request()->routeIs('products.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('products.create') }}">
                <i class="fas fa-fw fa-plus-circle"></i>
                <span>Tambah produk</span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('categories.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('categories.create') }}">
                <i class="fas fa-fw fa-folder-plus"></i>
                <span>Tambah kategori</span>
            </a>
        </li>

    @endif

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Akun</div>

    <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profile.edit') }}">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Profil saya</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('settings.index') }}">
            <i class="fas fa-fw fa-sliders-h"></i>
            <span>Pengaturan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('activity.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('activity.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat aktivitas</span>
        </a>
    </li>

    <div class="sidebar-card d-none d-lg-flex">
        <i class="fas fa-user-circle fa-2x mb-2"></i>
        <div class="sidebar-card-title text-center">{{ auth()->user()->name }}</div>
        <p class="mb-2">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Pengguna' }}</p>
        <a class="btn btn-sm btn-outline-light btn-block" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt mr-1"></i> Keluar
        </a>
    </div>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" aria-label="Ciutkan navigasi"></button>
    </div>
</ul>
