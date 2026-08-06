

<?php $__env->startSection('title', 'Cari Kos - PUSATKOS'); ?>

<?php $__env->startSection('content'); ?>
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('partials.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main id="ts-main">

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

        <section id="page-title">
            <div class="container">
                <div class="ts-title mb-0">
                    <h1>Cari Kos</h1>
                    <h5 class="ts-opacity__90">Temukan kos impianmu di seluruh Indonesia dengan pencarian yang mudah.</h5>
                </div>
            </div>
        </section>

        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <aside class="card p-4 shadow-sm">
                            <h3 class="h5 mb-3">Filter Pencarian</h3>
                            <form action="<?php echo e(route('search.kos')); ?>" method="GET">
                                <div class="form-group">
                                    <label for="keyword">Kata Kunci</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Kota, alamat, atau nama kos">
                                </div>
                                <div class="form-group">
                                    <label for="type">Tipe Kos</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="">Semua</option>
                                        <option value="putra">Putra</option>
                                        <option value="putri">Putri</option>
                                        <option value="campur">Campur</option>
                                        <option value="eksklusif">Eksklusif</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="city">Kota</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Contoh: Surabaya">
                                </div>
                                <div class="form-group">
                                    <label for="max_price">Harga Maksimal</label>
                                    <input type="number" class="form-control" id="max_price" name="max_price" placeholder="Contoh: 1000000">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Cari Kos</button>
                            </form>
                        </aside>
                    </div>

                    <div class="col-lg-8">
                        <div class="row">
                            <?php $__empty_1 = true; $__currentLoopData = $listKos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-md-6 mb-4">
                                <div class="card ts-item ts-card ts-item__lg h-100">
                                    <div class="ts-ribbon"><i class="fa fa-thumbs-up"></i></div>
                                    <a href="<?php echo e(route('kos.show', $kos['slug'])); ?>" class="card-img ts-item__image" data-bg-image="<?php echo e(asset($kos['thumbnail'])); ?>">
                                        <div class="ts-item__info-badge">Rp <?php echo e(number_format($kos['price'], 0, ',', '.')); ?> /bln</div>
                                        <figure class="ts-item__info">
                                            <h4><?php echo e($kos['title']); ?></h4>
                                            <aside><i class="fa fa-map-marker mr-2"></i><?php echo e($kos['city']); ?></aside>
                                        </figure>
                                    </a>
                                    <div class="card-body">
                                        <p class="text-muted mb-3"><?php echo e(Str::limit($kos['description'], 120)); ?></p>
                                        <div class="ts-description-lists">
                                            <dl><dt>Tipe</dt><dd><?php echo e($kos['type']); ?></dd></dl>
                                            <dl><dt>Kamar</dt><dd><?php echo e($kos['bedrooms'] ?? '1'); ?></dd></dl>
                                            <dl><dt>K. Mandi</dt><dd><?php echo e($kos['bathrooms'] ?? 'Dalam'); ?></dd></dl>
                                        </div>
                                    </div>
                                    <a href="<?php echo e(route('kos.show', $kos['slug'])); ?>" class="card-footer"><span class="ts-btn-arrow">Lihat Detail</span></a>
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
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\PUSATKOS\resources\views/kos/index.blade.php ENDPATH**/ ?>