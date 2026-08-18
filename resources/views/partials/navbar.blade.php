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
                    <li class="nav-item {{ (request()->routeIs('artikel') || request()->routeIs('member.artikel') || request()->is('member/artikel')) ? 'active' : '' }}">
                        <a class="nav-link {{ (request()->routeIs('artikel') || request()->routeIs('member.artikel') || request()->is('member/artikel')) ? 'active' : '' }}" href="{{ $isMemberArea ? url('/member' . route('artikel', [], false)) : route('artikel') }}">Artikel @if(request()->routeIs('artikel') || request()->routeIs('member.artikel'))<span class="sr-only">(current)</span>@endif</a>
                    </li>
                    <li class="nav-item {{ (request()->routeIs('about') || request()->routeIs('member.about') || request()->is('member/tentang')) ? 'active' : '' }}">
                        <a class="nav-link {{ (request()->routeIs('about') || request()->routeIs('member.about') || request()->is('member/tentang')) ? 'active' : '' }}" href="{{ $isMemberArea ? url('/member' . route('about', [], false)) : route('about') }}">Tentang @if(request()->routeIs('about') || request()->routeIs('member.about'))<span class="sr-only">(current)</span>@endif</a>
                    </li>
                    <li class="nav-item {{ (request()->routeIs('contact') || request()->routeIs('member.contact') || request()->is('member/kontak')) ? 'active' : '' }}">
                        <a class="nav-link {{ (request()->routeIs('contact') || request()->routeIs('member.contact') || request()->is('member/kontak')) ? 'active' : '' }}" href="{{ $isMemberArea ? url('/member' . route('contact', [], false)) : route('contact') }}">Kontak @if(request()->routeIs('contact') || request()->routeIs('member.contact'))<span class="sr-only">(current)</span>@endif</a>
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
                <ul class="navbar-nav ml-auto d-none d-md-flex">
                    <li class="nav-item">
                        <form id="form-logout" action="{{ url('/member/logout') }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                        </form>
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
