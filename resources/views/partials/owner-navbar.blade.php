{{-- Navbar khusus area owner --}}
<header id="ts-header" class="fixed-top">

    <nav id="ts-secondary-navigation" class="navbar p-0">
        <div class="container justify-content-end justify-content-sm-between">
            <div class="navbar-nav d-none d-sm-block">
                <span class="mr-4">
                    <i class="fa fa-briefcase mr-1"></i>
                    Owner Center
                </span>
                <a href="mailto:owner@pusatkos.id">
                    <i class="fa fa-envelope mr-1"></i>
                    owner@pusatkos.id
                </a>
            </div>

            <div class="navbar-nav flex-row align-items-center">
                <span class="nav-link px-3 d-none d-md-inline text-muted">Mode Owner</span>
                <a href="{{ route('home') }}" class="nav-link px-3 border-left">Lihat Halaman Publik</a>
            </div>
        </div>
    </nav>

    <nav id="ts-primary-navigation" class="navbar navbar-expand-md navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('owner.dashboard') }}">
                <span class="pk-logo"><i class="fa fa-building mr-2"></i>PUSATKOS Owner</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarOwner" aria-controls="navbarOwner" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarOwner">
                <ul class="navbar-nav">
                    <li class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}" href="{{ route('owner.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('owner.kos.my') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->routeIs('owner.kos.my') ? 'active' : '' }}" href="{{ route('owner.kos.my') }}">Kos Saya</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('owner.kos.create') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->routeIs('owner.kos.create') ? 'active' : '' }}" href="{{ route('owner.kos.create') }}">Tambah Kos</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</header>
