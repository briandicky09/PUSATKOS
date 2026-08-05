<?php $__env->startSection('title', 'Kos Saya - PUSATKOS'); ?>

<?php $__env->startSection('customer-content'); ?>

<div class="row mb-4">
    <div class="col-12">
        <h4 class="font-weight-bold text-dark mb-0">Kos yang Sedang Disewa</h4>
    </div>
</div>

<div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $rentedKos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 8px; overflow: hidden;">
            <img src="<?php echo e(asset($kos['thumbnail'])); ?>" class="card-img-top" alt="Foto Kos" style="height: 200px; object-fit: cover; background-color: #ccc;">
            <div class="card-body">
                <span class="badge text-white mb-2 px-2 py-1" style="background-color: #0000ff;">Kos <?php echo e($kos['type']); ?></span>
                <h5 class="card-title font-weight-bold mb-1 text-dark"><?php echo e($kos['title']); ?></h5>
                <p class="text-muted ts-text-small mb-2"><i class="fa fa-map-marker-alt mr-1"></i> <?php echo e($kos['city']); ?></p>
                <p class="text-muted ts-text-small mb-3"><i class="fa fa-calendar mr-1"></i> <?php echo e($kos['periode']); ?></p>
                <h5 class="font-weight-bold text-dark mb-0">Rp <?php echo e(number_format($kos['price'], 0, ',', '.')); ?> <span class="text-muted font-weight-normal ts-text-small">/ bulan</span></h5>
            </div>
            <div class="card-footer bg-white border-top-0 pb-4 pt-0">
                <a href="<?php echo e(route('owner.kos.show', $kos['slug'])); ?>" class="btn btn-outline-dark w-100 font-weight-bold" style="border-radius: 4px;">Lihat Detail</a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12">
        <div class="card border-0 shadow-sm p-5 text-center">
            <p class="text-muted mb-3">Kamu belum menyewa kos apa pun saat ini.</p>
            <a href="<?php echo e(route('owner.kos.index')); ?>" class="btn btn-primary">Cari Kos Sekarang</a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinkpad\Downloads\pusatkos-laravel\resources\views/customer/kos/index.blade.php ENDPATH**/ ?>