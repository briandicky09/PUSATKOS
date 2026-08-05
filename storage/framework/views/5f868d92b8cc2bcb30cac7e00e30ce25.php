
<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <a href="<?php echo e(route('owner.kos.index')); ?>"
               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('owner.kos.*') ? 'active' : ''); ?>">
                <i class="fa fa-building mr-2"></i> Kos Saya
            </a>
            <a href="<?php echo e(route('owner.kos.create')); ?>"
               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('owner.kos.create') ? 'active' : ''); ?>">
                <i class="fa fa-plus-circle mr-2"></i> Tambah Kos
            </a>
            <a href="<?php echo e(route('home')); ?>" class="list-group-item list-group-item-action">
                <i class="fa fa-home mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Thinkpad\Downloads\pusatkos-laravel\resources\views/partials/owner-sidebar.blade.php ENDPATH**/ ?>