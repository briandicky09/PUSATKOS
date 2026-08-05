<?php $__env->startSection('title', 'Daftar - PUSATKOS'); ?>

<?php $__env->startSection('content'); ?>
<div class="ts-page-wrapper ts-auth-page" id="page-top">

    <!--*********************************************************************************************************-->
    <!--HEADER **************************************************************************************************-->
    <!--*********************************************************************************************************-->
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('partials.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!--end Header-->

    <!--*********************************************************************************************************-->
    <!-- MAIN CONTENT (Split Layout) ****************************************************************************-->
    <!--*********************************************************************************************************-->
    <main id="ts-main" style="background-color: #E0E0E0; margin-top: 0 !important; padding-top: 100px !important; margin-bottom: 0 !important; padding-bottom: 0 !important;">

        <section id="ts-auth" class="pb-5" style="background-color: #E0E0E0; min-height: 80vh; display: flex; align-items: center; margin-bottom: 0 !important;" data-bg-color="#E0E0E0">
            <div class="container py-4">
                <div class="row align-items-center justify-content-between">

                    <!-- KOLOM KIRI: Branding PUSATKOS -->
                    <div class="col-md-6 text-center text-md-center mb-5 mb-md-0 d-flex flex-column align-items-center justify-content-center">
                        <i class="fa fa-home" style="font-size: 8rem; color: #333;"></i>
                        <h1 class="display-4 font-weight-bold mt-3" style="color: #333;">PUSATKOS</h1>
                        <h3 class="font-weight-normal mt-2" style="color: #555;">Cari Kos Impianmu Lebih Mudah</h3>
                    </div>

                    <!-- KOLOM KANAN: Form Pendaftaran -->
                    <div class="col-md-6 col-lg-5">
                        <div class="card ts-card p-4 p-md-5 border-0 shadow-lg" style="border-radius: 8px;">

                            <!-- Judul Card -->
                            <div class="mb-4">
                                <h4 class="mb-1 font-weight-bold">Daftar Akun Baru</h4>
                            </div>

                            
                            <form id="form-register" class="ts-form" method="POST" action="#">
                                <?php echo csrf_field(); ?>

                                <div class="row">
                                    <!--Nama Lengkap-->
                                    <div class="col-md-12 form-group mb-3">
                                        <input type="text" class="form-control" id="reg-nama" name="nama" placeholder="Nama Lengkap" required>
                                    </div>

                                    <!--No HP-->
                                    <div class="col-md-12 form-group mb-3">
                                        <input type="tel" class="form-control" id="reg-hp" name="handphone" placeholder="No. Handphone (08xxxxxxxx)" required>
                                    </div>

                                    <!--Email-->
                                    <div class="col-md-12 form-group mb-3">
                                        <input type="email" class="form-control" id="reg-email" name="email" placeholder="Email" required>
                                    </div>

                                    <!--Password-->
                                    <div class="col-md-6 form-group mb-3">
                                        <input type="password" class="form-control" id="reg-password" name="password" placeholder="Kata Sandi" required>
                                    </div>

                                    <!--Konfirmasi Password-->
                                    <div class="col-md-6 form-group mb-3">
                                        <input type="password" class="form-control" id="reg-password-confirm" name="password_confirmation" placeholder="Ulangi Sandi" required>
                                    </div>
                                </div>
                                <!--end row-->

                                <!-- Checkbox S&K -->
                                <div class="custom-control custom-checkbox mb-4 mt-2">
                                    <input type="checkbox" class="custom-control-input" id="agree-terms" name="agree" required>
                                    <label class="custom-control-label text-muted" for="agree-terms" style="font-size: 13px;">
                                        Saya menyetujui <a href="#" class="text-dark font-weight-bold">Syarat &amp; Ketentuan</a> dan <a href="#" class="text-dark font-weight-bold">Kebijakan Privasi</a>
                                    </label>
                                </div>

                                <!-- TOMBOL DAFTAR (Warna Biru Muda) -->
                                <button type="submit" class="btn text-white w-100 mb-3 font-weight-bold" style="background-color: #38b6ff; border-color: #38b6ff;">
                                    DAFTAR
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

                                <!-- Link Masuk -->
                                <div class="text-center mt-4 ts-text-small">
                                    <p class="mb-0 text-muted">
                                        Sudah punya akun? <a href="<?php echo e(route('login')); ?>" class="font-weight-bold" style="color: #007bff; text-decoration: underline;">Masuk di sini</a>
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
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<!--end .ts-page-wrapper-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinkpad\Downloads\pusatkos-laravel\resources\views/auth/register.blade.php ENDPATH**/ ?>