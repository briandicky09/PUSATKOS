

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
    <!-- MAIN CONTENT (Register Page) ****************************************************************************-->
    <!--*********************************************************************************************************-->
    <main id="ts-main" style="background-image: url('<?php echo e(asset('assets/img/gambar-koss.jpeg')); ?>'); background-size: cover; background-position: center center; background-repeat: no-repeat; min-height: calc(100vh + 160px); margin-top: 0 !important; padding: 0 !important; background-color: transparent;">

        <section id="ts-auth" class="py-5" style="position: relative; min-height: calc(100vh + 160px); display: flex; align-items: center; justify-content: center; margin-bottom: 0 !important; background: transparent;">
            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.28); z-index: 1;"></div>
            <div class="container py-5" style="position: relative; z-index: 2;">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5">
                        <div class="card ts-card p-4 p-md-5 border-0 shadow-lg" style="border-radius: 8px; background: rgba(255,255,255,0.96); backdrop-filter: blur(10px);">

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\PUSATKOS\resources\views/auth/register.blade.php ENDPATH**/ ?>