@extends('layouts.app')

@section('title', 'Masuk - PUSATKOS')

@section('content')
<div class="ts-page-wrapper ts-auth-page" id="page-top">

    <!--*********************************************************************************************************-->
    <!-- TOP NAVBAR (Fixed Top agar PASTI selalu muncul saat di-scroll) *****************************************-->
    <!--*********************************************************************************************************-->
    <!--*********************************************************************************************************-->
    <!--HEADER **************************************************************************************************-->
    <!--*********************************************************************************************************-->
    @include('partials.navbar')

    @include('partials.alert')
    <!--end Header-->

    <!--*********************************************************************************************************-->
    <!-- MAIN CONTENT (Split Layout) ****************************************************************************-->
    <!--*********************************************************************************************************-->
    
    <!-- FIX DOBEL: Tambahkan background-color abu-abu ke dalam tag main agar jarak padding ikut berwarna abu-abu -->
    <main id="ts-main" style="background-color: #E0E0E0; margin-top: 0 !important; padding-top: 75px !important; margin-bottom: 0 !important; padding-bottom: 0 !important;">

        <!-- Latar belakang abu-abu muda menyatu langsung dengan footer -->
        <section id="ts-auth" class="pb-5" style="background-color: #E0E0E0; min-height: 80vh; display: flex; align-items: center; margin-bottom: 0 !important;" data-bg-color="#E0E0E0">
            <div class="container py-4">
                <div class="row align-items-center justify-content-between">

                    <!-- KOLOM KIRI: Branding PUSATKOS -->
                    <div class="col-md-6 text-center text-md-center mb-5 mb-md-0 d-flex flex-column align-items-center justify-content-center">
                        <i class="fa fa-home" style="font-size: 8rem; color: #333;"></i>
                        <h1 class="display-4 font-weight-bold mt-3" style="color: #333;">PUSATKOS</h1>
                        <h3 class="font-weight-normal mt-2" style="color: #555;">Cari Kos Impianmu Lebih Mudah</h3>
                    </div>

                    <!-- KOLOM KANAN: Form Login -->
                    <div class="col-md-6 col-lg-5">
                        <div class="card ts-card p-4 p-md-5 border-0 shadow-lg" style="border-radius: 8px;">

                            <!-- Judul Card -->
                            <div class="mb-4">
                                <h4 class="mb-1 font-weight-bold">Masuk ke Akun Kamu</h4>
                            </div>

                            {{-- TODO: arahkan action ke route POST login setelah autentikasi diimplementasikan --}}
                            <form id="form-login" class="ts-form" method="POST" action="#">
                                @csrf

                                <!--Email-->
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" id="login-email" name="email" placeholder="Email (nama@email.com)" required>
                                </div>

                                <!--Password-->
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Kata Sandi" required>
                                </div>

                                <!--Remember + Forgot-->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remember-me" name="remember">
                                        <label class="custom-control-label ts-text-small text-muted" for="remember-me">Ingat saya</label>
                                    </div>
                                    <a href="#" class="ts-text-small font-weight-bold" style="color: #007bff;">Lupa kata sandi?</a>
                                </div>

                                <!-- TOMBOL MASUK (Warna Biru Muda) -->
                                <button type="submit" class="btn text-white w-100 mb-3 font-weight-bold" style="background-color: #38b6ff; border-color: #38b6ff;">
                                    MASUK
                                </button>

                                <!-- Divider -->
                                <div class="d-flex align-items-center mb-3">
                                    <hr class="flex-grow-1">
                                    <span class="mx-2 text-muted ts-text-small">ATAU</span>
                                    <hr class="flex-grow-1">
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <a href="#" class="btn btn-outline-dark w-100">
                                            <i class="fab fa-facebook-f mr-1"></i> Facebook
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" class="btn btn-outline-dark w-100">
                                            <i class="fab fa-google mr-1"></i> Google
                                        </a>
                                    </div>
                                </div>

                                <!-- Link Daftar (Biru Link) -->
                                <div class="text-center mt-4 ts-text-small">
                                    <p class="mb-0 text-muted">
                                        Belum punya akun? <a href="{{ route('register') }}" class="font-weight-bold" style="color: #007bff; text-decoration: underline;">Daftar di sini</a>
                                    </p>
                                </div>

                            </form>

                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>
        <!--end ts-auth-->

    </main>
    <!--end #ts-main-->

    <!--*********************************************************************************************************-->
    <!--************ FOOTER *************************************************************************************-->
    <!--*********************************************************************************************************-->
    
    @include('partials.footer')

</div>
<!--end .ts-page-wrapper-->
@endsection
