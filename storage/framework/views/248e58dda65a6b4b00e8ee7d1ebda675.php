<?php $__env->startSection('content'); ?>
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('partials.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <section class="pt-5 mt-5 pb-5" style="margin-top: 90px;">
        <div class="container">
            <div class="row">

                <!--Sidebar Owner-->
                <div class="col-lg-3">
                    <?php echo $__env->make('partials.owner-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!--Content-->
                <div class="col-lg-9">
                    <?php echo $__env->yieldContent('owner-content'); ?>
                </div>

            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    <?php echo $__env->make('partials.footer', ['noMarginFooter' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinkpad\Downloads\pusatkos-laravel\resources\views/layouts/owner.blade.php ENDPATH**/ ?>