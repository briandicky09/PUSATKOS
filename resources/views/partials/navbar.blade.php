{{-- Header / Navbar PUSATKOS --}}
<header id="ts-header" class="fixed-top">

    <!-- SECONDARY NAVIGATION
    =============================================================================================================-->
    <nav id="ts-secondary-navigation" class="navbar p-0">
        <div class="container justify-content-end justify-content-sm-between">

            <!--Left Side-->
            <div class="navbar-nav d-none d-sm-block">
                <span class="mr-4">
                    <i class="fa fa-phone-square mr-1"></i>
                    0800-1-PUSATKOS
                </span>
                <a href="mailto:hello@pusatkos.id">
                    <i class="fa fa-envelope mr-1"></i>
                    hello@pusatkos.id
                </a>
            </div>

            <!--Right Side-->
            <div class="navbar-nav flex-row">
                @unless(request()->is('member*'))
                <a href="{{ route('login') }}" class="nav-link px-3">Masuk</a>
                <a href="{{ route('register') }}" class="nav-link px-3 border-left">Daftar</a>
                @endunless
            </div>
            <!--end navbar-nav-->
        </div>
        <!--end container-->
    </nav>

    <!--PRIMARY NAVIGATION
    =============================================================================================================-->
    <nav id="ts-primary-navigation" class="navbar navbar-expand-md navbar-light">
        <div class="container">

            <!--Brand Logo-->
            @php $isMemberArea = request()->is('member*'); @endphp
            <a class="navbar-brand" href="{{ $isMemberArea ? url('/member' . route('home', [], false)) : route('home') }}">
                <span class="pk-logo"><i class="fa fa-home mr-2"></i>PUSATKOS</span>
            </a>

            <!--Responsive Collapse Button-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrimary" aria-controls="navbarPrimary" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--Collapsing Navigation-->
            <div class="collapse navbar-collapse" id="navbarPrimary">

                <ul class="navbar-nav">
                    <li class="nav-item {{ (request()->routeIs('home') || request()->routeIs('member.home') || request()->is('member')) ? 'active' : '' }}">
                        <a class="nav-link {{ (request()->routeIs('home') || request()->routeIs('member.home') || request()->is('member')) ? 'active' : '' }}" href="{{ $isMemberArea ? url('/member' . route('home', [], false)) : route('home') }}">Home @if(request()->routeIs('home') || request()->routeIs('member.home'))<span class="sr-only">(current)</span>@endif</a>
                    </li>
                    <li class="nav-item {{ (request()->routeIs('kos.index') || request()->routeIs('member.kos.index') || request()->routeIs('search.kos') || request()->routeIs('member.search.kos') || request()->is('kos') || request()->is('member/kos') || request()->is('member/search')) ? 'active' : '' }}">
                        <a class="nav-link {{ (request()->routeIs('kos.index') || request()->routeIs('member.kos.index') || request()->routeIs('search.kos') || request()->routeIs('member.search.kos') || request()->is('kos') || request()->is('member/kos') || request()->is('member/search')) ? 'active' : '' }}" href="{{ $isMemberArea ? url('/member' . route('kos.index', [], false)) : route('kos.index') }}">Cari Kos</a>
                    </li>
                    <li class="nav-item {{ (request()->routeIs('promo') || request()->routeIs('member.promo') || request()->is('member/promo')) ? 'active' : '' }}">
                        <a class="nav-link {{ (request()->routeIs('promo') || request()->routeIs('member.promo') || request()->is('member/promo')) ? 'active' : '' }}" href="{{ $isMemberArea ? url('/member' . route('promo', [], false)) : route('promo') }}">Promo @if(request()->routeIs('promo') || request()->routeIs('member.promo'))<span class="sr-only">(current)</span>@endif</a>
                    </li>
                    @php
                        $isMoreActive = request()->routeIs('artikel', 'member.artikel', 'about', 'member.about', 'contact', 'member.contact') || request()->is('member/artikel', 'member/tentang', 'member/kontak');
                    @endphp
                    <li class="nav-item dropdown {{ $isMoreActive ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle {{ $isMoreActive ? 'active' : '' }}" href="#" id="moreDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Lainnya
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropdown">
                            <a class="dropdown-item" href="{{ $isMemberArea ? url('/member' . route('artikel', [], false)) : route('artikel') }}">Artikel</a>
                            <a class="dropdown-item" href="{{ $isMemberArea ? url('/member' . route('about', [], false)) : route('about') }}">Tentang</a>
                            <a class="dropdown-item" href="{{ $isMemberArea ? url('/member' . route('contact', [], false)) : route('contact') }}">Kontak</a>
                        </div>
                    </li>
                </ul>

                @if(!$isMemberArea)
                <ul class="navbar-nav ml-auto d-none d-md-flex">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm mr-2">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                    </li>
                </ul>
                @else
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link member-profile-toggle dropdown-toggle" href="#" id="memberProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Menu profil">
                            <img src="{{ asset('assets/svg/logo-profil.png') }}" alt="Profil" class="member-profile__logo">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right member-profile-menu" aria-labelledby="memberProfileDropdown">
                            <a class="dropdown-item" href="{{ route('member.profile') }}">Profil saya</a>
                            <a class="dropdown-item" href="{{ route('member.invoice.index') }}">Riwayat Transaksi</a>
                            <a class="dropdown-item" href="{{ route('member.contact') }}">Pusat bantuan</a>
                            <div class="dropdown-divider"></div>
                            <form id="form-logout" action="{{ route('member.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
                @endif

            </div>
            <!--end navbarPrimary-->

        </div>
        <!--end container-->
    </nav>
    <!--end #ts-primary-navigation-->

    @if($isMemberArea)
    <a href="{{ route('member.pesan') }}" class="member-floating-chat" aria-label="Pesan">
        <img src="{{ asset('assets/svg/logo-pesan.png') }}" alt="Logo pesan" class="member-floating-chat__logo">
    </a>
    @endif

</header>
