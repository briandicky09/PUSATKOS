
<header id="ts-header" class="fixed-top">

    <!-- SECONDARY NAVIGATION
    =============================================================================================================-->
    <nav id="ts-secondary-navigation" class="navbar p-0">
        <div class="container justify-content-end justify-content-sm-between">

            <!--Left Side-->
            <div class="navbar-nav d-none d-sm-block">
                <span class="mr-4">
                    <i class="fa fa-phone-square mr-1"></i>
                    0800-1-PUSATKOS
                </span>
                <a href="mailto:hello@pusatkos.id">
                    <i class="fa fa-envelope mr-1"></i>
                    hello@pusatkos.id
                </a>
            </div>

            <!--Right Side-->
            <div class="navbar-nav flex-row">
                <a href="<?php echo e(route('login')); ?>" class="nav-link px-3">Masuk</a>
                <a href="<?php echo e(route('register')); ?>" class="nav-link px-3 border-left">Daftar</a>
            </div>
            <!--end navbar-nav-->
        </div>
        <!--end container-->
    </nav>

    <!--PRIMARY NAVIGATION
    =============================================================================================================-->
    <nav id="ts-primary-navigation" class="navbar navbar-expand-md navbar-light">
        <div class="container">

            <!--Brand Logo-->
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <span class="pk-logo"><i class="fa fa-home mr-2"></i>PUSATKOS</span>
            </a>

            <!--Responsive Collapse Button-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrimary" aria-controls="navbarPrimary" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--Collapsing Navigation-->
            <div class="collapse navbar-collapse" id="navbarPrimary">

                <ul class="navbar-nav">
                    <li class="nav-item <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Home <?php if(request()->routeIs('home')): ?><span class="sr-only">(current)</span><?php endif; ?></a>
                    </li>
                    <li class="nav-item <?php echo e(request()->routeIs('kos.index') || request()->routeIs('search.kos') || request()->is('kos') ? 'active' : ''); ?>">
                        <a class="nav-link <?php echo e(request()->routeIs('kos.index') || request()->routeIs('search.kos') || request()->is('kos') ? 'active' : ''); ?>" href="<?php echo e(route('kos.index')); ?>">Cari Kos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('home')); ?>#promo">Promo</a>
                    </li>
                    <li class="nav-item <?php echo e(request()->routeIs('artikel') ? 'active' : ''); ?>">
                        <a class="nav-link <?php echo e(request()->routeIs('artikel') ? 'active' : ''); ?>" href="<?php echo e(route('artikel')); ?>">Artikel <?php if(request()->routeIs('artikel')): ?><span class="sr-only">(current)</span><?php endif; ?></a>
                    </li>
                    <li class="nav-item <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>">
                        <a class="nav-link <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">Tentang <?php if(request()->routeIs('about')): ?><span class="sr-only">(current)</span><?php endif; ?></a>
                    </li>
                    <li class="nav-item <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>">
                        <a class="nav-link <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>" href="<?php echo e(route('contact')); ?>">Kontak <?php if(request()->routeIs('contact')): ?><span class="sr-only">(current)</span><?php endif; ?></a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto d-none d-md-flex">
                    <li class="nav-item">
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-dark btn-sm mr-2">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-sm">Daftar</a>
                    </li>
                </ul>

            </div>
            <!--end navbarPrimary-->

        </div>
        <!--end container-->
    </nav>
    <!--end #ts-primary-navigation-->

</header>
<?php /**PATH C:\Users\USER\PUSATKOS\resources\views/partials/navbar.blade.php ENDPATH**/ ?>