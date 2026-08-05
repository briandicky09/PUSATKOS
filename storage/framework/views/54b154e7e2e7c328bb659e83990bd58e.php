<?php $__env->startSection('title', 'Cari Kos - PUSATKOS'); ?>

<?php $__env->startSection('content'); ?>
<div class="ts-page-wrapper" id="page-top">

    <!--*********************************************************************************************************-->
    <!--HEADER **************************************************************************************************-->
    <!--*********************************************************************************************************-->
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('partials.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!--end Header-->

    <!--*********************************************************************************************************-->
    <!-- MAIN CONTENT PENCARIAN *********************************************************************************-->
    <!--*********************************************************************************************************-->
    <main id="ts-main" style="background-color: #E0E0E0; margin-top: 0 !important; padding-top: 110px !important; padding-bottom: 50px !important; min-height: 80vh;">

        <div class="container py-4">
            <div class="row">

                <!-- Sidebar Filter -->
                <div class="col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
                        <div class="card-body p-4">
                            <h4 class="mb-4 font-weight-bold text-dark">Cari Kos</h4>
                            <form action="<?php echo e(route('search.kos')); ?>" method="GET">
                                <div class="form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-2">Lokasi atau Nama Kos</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i class="fa fa-map-marker-alt text-muted"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-left-0 pl-0" name="keyword" placeholder="Contoh: Surabaya, Sidoarjo..." style="padding: 12px 15px;">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-2">Tipe Kos</label>
                                    <select class="form-control" name="type" style="height: auto; padding: 12px 15px;">
                                        <option value="">Semua Tipe</option>
                                        <option value="putra">Putra</option>
                                        <option value="putri">Putri</option>
                                        <option value="campur">Campur</option>
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="ts-text-small font-weight-bold text-muted mb-2">Rentang Harga</label>
                                    <select class="form-control" name="price" style="height: auto; padding: 12px 15px;">
                                        <option value="">Semua Harga</option>
                                        <option value="murah">< Rp 1.000.000</option>
                                        <option value="menengah">Rp 1.000.000 - Rp 2.000.000</option>
                                        <option value="mahal">> Rp 2.000.000</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn text-white w-100 font-weight-bold" style="background-color: #0000ff; border-color: #0000ff; padding: 12px 0;">
                                    <i class="fa fa-search mr-2"></i>Cari
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                        <div class="card-body p-4">
                            <h5 class="font-weight-bold mb-3">Filter Cepat</h5>
                            <a href="<?php echo e(route('search.kos', ['type' => 'putra'])); ?>" class="btn btn-outline-dark btn-block mb-2">Kos Putra</a>
                            <a href="<?php echo e(route('search.kos', ['type' => 'putri'])); ?>" class="btn btn-outline-dark btn-block mb-2">Kos Putri</a>
                            <a href="<?php echo e(route('search.kos', ['type' => 'campur'])); ?>" class="btn btn-outline-dark btn-block mb-2">Kos Campur</a>
                            <a href="<?php echo e(route('search.kos', ['price' => 'murah'])); ?>" class="btn btn-outline-dark btn-block">Harga < Rp 1.000.000</a>
                        </div>
                    </div>
                </div>

                <!-- Listing Kos -->
                <div class="col-lg-9">
                    <div class="row mb-4">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bold text-dark mb-0">Rekomendasi Kos Terbaik (<?php echo e(count($listKos)); ?> Ditemukan)</h5>
                            <div class="d-flex align-items-center">
                                <label class="ts-text-small text-muted mb-0 mr-2 d-none d-sm-block">Urutkan:</label>
                                <select class="form-control form-control-sm border-0 shadow-sm" style="border-radius: 4px;">
                                    <option>Paling Relevan</option>
                                    <option>Harga Terendah</option>
                                    <option>Harga Tertinggi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php $__currentLoopData = $listKos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 8px; overflow: hidden;">
                                <img src="<?php echo e(asset($kos['thumbnail'])); ?>" class="card-img-top" alt="Foto Kos" style="height: 220px; object-fit: cover; background-color: #ccc;">
                                <div class="card-body">
                                    <span class="badge text-white mb-2 px-2 py-1" style="background-color: #0000ff;">Kos <?php echo e($kos['type']); ?></span>
                                    <span class="badge badge-<?php echo e($kos['status'] === 'Aktif' ? 'success' : 'secondary'); ?> mb-2 px-2 py-1 ml-1"><?php echo e($kos['status']); ?></span>
                                    <h5 class="card-title font-weight-bold mb-1 text-dark"><?php echo e($kos['title']); ?></h5>
                                    <p class="text-muted ts-text-small mb-3"><i class="fa fa-map-marker-alt mr-1"></i> <?php echo e($kos['city']); ?></p>

                                    <div class="d-flex align-items-center mb-3 text-muted ts-text-small">
                                        <span class="mr-3"><i class="fa fa-wifi mr-1"></i> WiFi</span>
                                        <span class="mr-3"><i class="fa fa-bed mr-1"></i> Kasur</span>
                                        <span><i class="fa fa-bath mr-1"></i> K. Mandi Dalam</span>
                                    </div>

                                    <h5 class="font-weight-bold text-dark mb-0">Rp <?php echo e(number_format($kos['price'], 0, ',', '.')); ?> <span class="text-muted font-weight-normal ts-text-small">/ bulan</span></h5>
                                </div>
                                <div class="card-footer bg-white border-top-0 pb-4 pt-0">
                                    <a href="<?php echo e(route('owner.kos.show', $kos['slug'])); ?>" class="btn btn-outline-dark w-100 font-weight-bold" style="border-radius: 4px;">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--end container-->
    </main>
    <!--end #ts-main-->

    <!--*********************************************************************************************************-->
    <!--************ FOOTER *************************************************************************************-->
    <!--*********************************************************************************************************-->
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<!--end .ts-page-wrapper-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinkpad\Downloads\pusatkos-laravel\resources\views/owner/kos/index.blade.php ENDPATH**/ ?>