
<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <a href="<?php echo e(route('customer.kos.index')); ?>"
               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('customer.kos.index') ? 'active' : ''); ?>">
                <i class="fa fa-bed mr-2"></i> Kos Saya
            </a>
            <a href="<?php echo e(route('customer.invoice.index')); ?>"
               class="list-group-item list-group-item-action <?php echo e(request()->routeIs('customer.invoice.*') ? 'active' : ''); ?>">
                <i class="fa fa-file-invoice mr-2"></i> Tagihan / Invoice
            </a>
            <a href="<?php echo e(route('home')); ?>" class="list-group-item list-group-item-action">
                <i class="fa fa-home mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Thinkpad\Downloads\pusatkos-laravel\resources\views/partials/customer-sidebar.blade.php ENDPATH**/ ?>