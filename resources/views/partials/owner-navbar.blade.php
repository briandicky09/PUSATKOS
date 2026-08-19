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

                <ul class="navbar-nav ml-auto d-flex flex-row align-items-center">
                    <!-- Notification Dropdown -->
                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link" href="#" id="notificationOwnerDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell fa-lg text-dark"></i>
                            <span class="badge badge-danger badge-pill position-absolute" style="top: 5px; right: 0; font-size: 0.6rem;">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" aria-labelledby="notificationOwnerDropdown" style="width: 320px; padding: 0; border-radius: 8px;">
                            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                <h6 class="mb-0 font-weight-bold">Notifikasi</h6>
                                <a href="#" class="text-dark" onclick="event.stopPropagation(); $(this).closest('.dropdown-menu').removeClass('show');"><i class="fa fa-times"></i></a>
                            </div>
                            <div class="p-2 border-bottom bg-light">
                                <span class="badge badge-pill border px-3 py-2 bg-white text-dark"><i class="fa fa-info-circle mr-1"></i> Utama</span>
                            </div>
                            <div class="text-center py-5">
                                <i class="fa fa-envelope-open-text fa-4x mb-3" style="color: #dee2e6 !important;"></i>
                                <h6 class="font-weight-bold text-dark mt-2">Belum ada notifikasi...</h6>
                                <p class="text-muted small mb-0 px-4">Belum ada notifikasi. Ketika ada notifikasi baru, akan muncul di halaman ini.</p>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Profile Dropdown/Icon -->
                    <li class="nav-item">
                        <a class="nav-link p-0" href="#">
                            <img src="{{ asset('assets/svg/logo-profil.png') }}" alt="Profil Owner" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</header>
