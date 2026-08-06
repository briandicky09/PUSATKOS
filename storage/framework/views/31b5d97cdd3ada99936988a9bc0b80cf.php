

<?php $__env->startSection('title', 'Cari Kos - PUSATKOS'); ?>

<?php $__env->startSection('content'); ?>
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('partials.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main id="ts-main">

        <!--BREADCRUMB
        =========================================================================================================-->
        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cari Kos</li>
                    </ol>
                </nav>
            </div>
        </section>

        <!--PAGE TITLE
        =========================================================================================================-->
        <section id="page-title">
            <div class="container">
                <div class="ts-title mb-0">
                    <h1>Daftar Kos</h1>
                    <h5 class="ts-opacity__90">Temukan kos impianmu di seluruh Indonesia</h5>
                </div>
            </div>
        </section>

        <!--CONTENT
        =========================================================================================================-->
        <section id="content">
            <div class="container">
                <div class="row">

                    <?php $__empty_1 = true; $__currentLoopData = $listKos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card ts-item ts-card ts-item__lg">
                            <div class="ts-ribbon"><i class="fa fa-thumbs-up"></i></div>
                            <a href="<?php echo e(route('kos.show', $kos['slug'])); ?>" class="card-img ts-item__image" data-bg-image="<?php echo e(asset($kos['thumbnail'])); ?>">
                                <div class="ts-item__info-badge">Rp <?php echo e(number_format($kos['price'], 0, ',', '.')); ?> /bln</div>
                                <figure class="ts-item__info">
                                    <h4><?php echo e($kos['title']); ?></h4>
                                    <aside><i class="fa fa-map-marker mr-2"></i><?php echo e($kos['city']); ?></aside>
                                </figure>
                            </a>
                            <div class="card-body">
                                <div class="ts-description-lists">
                                    <dl><dt>Tipe</dt><dd><?php echo e($kos['type']); ?></dd></dl>
                                    <dl><dt>Kamar</dt><dd>1</dd></dl>
                                    <dl><dt>K. Mandi</dt><dd>Dalam</dd></dl>
                                </div>
                            </div>
                            <a href="<?php echo e(route('kos.show', $kos['slug'])); ?>" class="card-footer"><span class="ts-btn-arrow">Detail</span></a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <div class="ts-box text-center py-5">
                            <p class="text-muted mb-0">Belum ada kos yang tersedia saat ini.</p>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

    </main>
    <!--end #ts-main-->

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<!--end page-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\PUSATKOS\resources\views/kos/index.blade.php ENDPATH**/ ?>