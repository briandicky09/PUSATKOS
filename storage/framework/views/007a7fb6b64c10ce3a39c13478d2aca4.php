

<?php $__env->startSection('title', $kos['title'] . ' - PUSATKOS'); ?>

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
                        <li class="breadcrumb-item"><a href="<?php echo e(route('kos.index')); ?>">Cari Kos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e($kos['title']); ?></li>
                    </ol>
                </nav>
            </div>
        </section>

        <!--PAGE TITLE
        =========================================================================================================-->
        <section id="page-title">
            <div class="container">

                <div class="d-block d-sm-flex justify-content-between">

                    <!--Title-->
                    <div class="ts-title mb-0">
                        <h1><?php echo e($kos['title']); ?></h1>
                        <h5 class="ts-opacity__90">
                            <i class="fa fa-map-marker text-primary"></i>
                            <?php echo e($kos['address'] ?? $kos['city']); ?>

                        </h5>
                    </div>

                    <!--Price-->
                    <h3>
                        <span class="badge badge-primary p-3 font-weight-normal ts-shadow__sm">Rp <?php echo e(number_format($kos['price'], 0, ',', '.')); ?> /bln</span>
                    </h3>

                </div>

            </div>
        </section>

        <!--GALLERY CAROUSEL
        =========================================================================================================-->
        <section id="gallery-carousel">

            <div class="owl-carousel ts-gallery-carousel ts-gallery-carousel__multi" data-owl-dots="1"
                data-owl-items="3" data-owl-center="1" data-owl-loop="1">

                <?php $__currentLoopData = $kos['gallery'] ?? ['assets/img/img-detail-01.jpg','assets/img/img-detail-02.jpg','assets/img/img-detail-05.jpg','assets/img/img-detail-04.jpg','assets/img/img-detail-03.jpg']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--Slide-->
                <div class="slide">
                    <div class="ts-image" data-bg-image="<?php echo e(asset($image)); ?>">
                        <a href="<?php echo e(asset($image)); ?>" class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </section>

        <!--CONTENT
        =========================================================================================================-->
        <section id="content">
            <div class="container">
                <div class="row flex-wrap-reverse">

                    <!--LEFT SIDE
                    =============================================================================================-->
                    <div class="col-md-5 col-lg-4">

                        <!--DETAILS
                        =========================================================================================-->
                        <section>
                            <h3>Details</h3>
                            <div class="ts-box">

                                <dl class="ts-description-list__line mb-0">

                                    <dt>Kategori:</dt>
                                    <dd>Kos <?php echo e($kos['type'] ?? '-'); ?></dd>

                                    <dt>Status:</dt>
                                    <dd><?php echo e($kos['status'] ?? 'Tersedia'); ?></dd>

                                    <dt>Luas:</dt>
                                    <dd><?php echo e($kos['area'] ?? '-'); ?> m<sup>2</sup></dd>

                                    <dt>Kamar:</dt>
                                    <dd><?php echo e($kos['rooms'] ?? '-'); ?></dd>

                                    <dt>K. Mandi:</dt>
                                    <dd><?php echo e($kos['bathrooms'] ?? '-'); ?></dd>

                                    <dt>Tempat Tidur:</dt>
                                    <dd><?php echo e($kos['bedrooms'] ?? '-'); ?></dd>

                                    <dt>Parkir:</dt>
                                    <dd><?php echo e($kos['garages'] ?? '-'); ?></dd>

                                </dl>

                            </div>
                        </section>

                        <!--CONTACT THE AGENT
                        =========================================================================================-->
                        <section class="contact-the-agent">
                            <h3>Hubungi Pemilik</h3>

                            <div class="ts-box">

                                <!--Agent Image & Phone-->
                                <div class="ts-center__vertical mb-4">

                                    <!--Image-->
                                    <a href="#" class="ts-circle p-5 mr-4 ts-shadow__sm"
                                        data-bg-image="<?php echo e(asset($kos['owner_photo'] ?? 'assets/img/img-person-05.jpg')); ?>"></a>

                                    <!--Phone contact-->
                                    <figure class="mb-0">
                                        <h5 class="mb-0"><?php echo e($kos['owner_name'] ?? 'Pemilik Kos'); ?></h5>
                                        <p class="mb-0">
                                            <i class="fa fa-phone-square ts-opacity__50 mr-2"></i>
                                            <?php echo e($kos['owner_phone'] ?? '-'); ?>

                                        </p>
                                    </figure>
                                </div>

                                <!--Agent contact form-->
                                <form id="form-agent" class="ts-form">

                                    <!--Name-->
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Nama Anda">
                                    </div>

                                    <!--Email-->
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email Anda">
                                    </div>

                                    <!--Message-->
                                    <div class="form-group">
                                        <textarea class="form-control" id="form-contact-message" rows="3" name="message"
                                            placeholder="Halo, saya ingin bertanya tentang <?php echo e($kos['title']); ?>"></textarea>
                                    </div>

                                    <!--Submit button-->
                                    <div class="form-group clearfix mb-0">
                                        <button type="button" class="btn btn-primary float-right"
                                            id="form-contact-submit" onclick="alert('Fitur hubungi pemilik akan segera tersedia.')">
                                            <i class="fa fa-envelope mr-2"></i>Kirim Pesan
                                        </button>
                                    </div>

                                </form>

                                <!-- TOMBOL HUBUNGI & BOOKING -->
                                <hr class="my-4">

                                <a href="https://wa.me/6280286216730?text=Halo, saya tertarik dengan <?php echo e(urlencode($kos['title'])); ?>"
                                    target="_blank" class="btn btn-success btn-block mb-2">
                                    <i class="fab fa-whatsapp mr-2"></i>Hubungi via WhatsApp
                                </a>

                                <a href="<?php echo e(route('member.invoice.index')); ?>"
                                    class="btn btn-primary btn-block">
                                    <i class="fa fa-calendar-check mr-2"></i>Booking / Sewa Sekarang
                                </a>

                            </div>
                        </section>

                        <!--LOCATION
                        =============================================================================================-->
                        <section id="location">
                            <h3>Lokasi</h3>

                            <div class="ts-box">

                                <dl class="ts-description-list__line mb-0">

                                    <dt><i class="fa fa-map-marker ts-opacity__30 mr-2"></i>Alamat:</dt>
                                    <dd class="border-bottom pb-2"><?php echo e($kos['address'] ?? $kos['city']); ?></dd>

                                    <dt><i class="fa fa-phone-square ts-opacity__30 mr-2"></i>Telepon:</dt>
                                    <dd class="border-bottom pb-2"><?php echo e($kos['owner_phone'] ?? '-'); ?></dd>

                                    <dt><i class="fa fa-envelope ts-opacity__30 mr-2"></i>Email:</dt>
                                    <dd class="border-bottom pb-2"><a href="mailto:<?php echo e($kos['owner_email'] ?? 'hello@pusatkos.id'); ?>"><?php echo e($kos['owner_email'] ?? 'hello@pusatkos.id'); ?></a></dd>

                                    <dt><i class="fa fa-globe ts-opacity__30 mr-2"></i>Website:</dt>
                                    <dd><a href="<?php echo e(route('home')); ?>">pusatkos.id</a></dd>

                                </dl>

                            </div>

                        </section>

                        <!--ACTIONS
                        =============================================================================================-->
                        <section id="actions">

                            <div class="d-flex justify-content-between">

                                <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                    data-placement="top" title="Tambah ke favorit">
                                    <i class="far fa-star"></i>
                                </a>

                                <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                    data-placement="top" title="Cetak">
                                    <i class="fa fa-print"></i>
                                </a>

                                <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                    data-placement="top" title="Bandingkan">
                                    <i class="fa fa-exchange-alt"></i>
                                </a>

                                <a href="#" class="btn btn-light w-100" data-toggle="tooltip" data-placement="top"
                                    title="Bagikan">
                                    <i class="fa fa-share-alt"></i>
                                </a>

                            </div>

                        </section>

                    </div>
                    <!--end col-md-4-->

                    <!--RIGHT SIDE
                    =============================================================================================-->
                    <div class="col-md-7 col-lg-8">

                        <!--QUICK INFO
                        =========================================================================================-->
                        <section id="quick-info">
                            <h3>Info Singkat</h3>

                            <!--Quick Info-->
                            <div class="ts-quick-info ts-box">

                                <!--Row-->
                                <div class="row no-gutters">

                                    <!--Bathrooms-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="<?php echo e(asset('assets/img/icon-quick-info-shower.png')); ?>">
                                            <h6>K. Mandi</h6>
                                            <figure><?php echo e($kos['bathrooms'] ?? '1'); ?></figure>
                                        </div>
                                    </div>

                                    <!--Bedrooms-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="<?php echo e(asset('assets/img/icon-quick-info-bed.png')); ?>">
                                            <h6>Kamar Tidur</h6>
                                            <figure><?php echo e($kos['bedrooms'] ?? '1'); ?></figure>
                                        </div>
                                    </div>

                                    <!--Area-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="<?php echo e(asset('assets/img/icon-quick-info-area.png')); ?>">
                                            <h6>Luas</h6>
                                            <figure><?php echo e($kos['area'] ?? '-'); ?>m<sup>2</sup></figure>
                                        </div>
                                    </div>

                                    <!--Garages-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="<?php echo e(asset('assets/img/icon-quick-info-garages.png')); ?>">
                                            <h6>Parkir</h6>
                                            <figure><?php echo e($kos['garages'] ?? '-'); ?></figure>
                                        </div>
                                    </div>

                                </div>
                                <!--end row-->

                            </div>
                            <!--end ts-quick-info-->

                        </section>

                        <!--DESCRIPTION
                        =========================================================================================-->
                        <section id="description">

                            <h3>Deskripsi</h3>

                            <p><?php echo e($kos['description'] ?? 'Deskripsi belum tersedia.'); ?></p>

                        </section>

                        <!--FEATURES
                        =========================================================================================-->
                        <section id="features">

                            <h3>Fasilitas</h3>

                            <ul class="list-unstyled ts-list-icons ts-column-count-4 ts-column-count-sm-2 ts-column-count-md-2">
                                <?php $__currentLoopData = $kos['features'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <i class="fa <?php echo e($feature['icon']); ?>"></i>
                                    <?php echo e($feature['name']); ?>

                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>

                        </section>

                        <!--MAP PLACEHOLDER
                        =========================================================================================-->
                        <section id="map-location">

                            <h3>Peta Lokasi</h3>

                            <div class="ts-box text-center py-5" style="background-color: #f5f7f9;">
                                <i class="fa fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Peta lokasi akan segera tersedia.</p>
                                <p class="text-muted mb-0"><small><?php echo e($kos['address'] ?? $kos['city']); ?></small></p>
                            </div>

                        </section>

                        <!--AMENITIES
                        =========================================================================================-->
                        <section id="amenities">

                            <h3>Fasilitas Tambahan</h3>

                            <ul class="ts-list-colored-bullets ts-text-color-light ts-column-count-3 ts-column-count-md-2">
                                <?php $__currentLoopData = $kos['facilities'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($facility); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>

                        </section>

                    </div>
                    <!--end col-md-8-->

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

        <!--SIMILAR PROPERTIES
        =============================================================================================================-->
        <?php if(!empty($similarKos)): ?>
        <section id="similar-properties">
            <div class="container">
                <div class="row">

                    <div class="offset-lg-4 col-sm-12 col-lg-8">

                        <hr class="mb-5">

                        <h3>Kos Serupa</h3>

                        <?php $__currentLoopData = $similarKos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $similar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--Item-->
                        <div class="card ts-item ts-item__list ts-card">

                            <?php if($loop->first): ?>
                            <div class="ts-ribbon"><i class="fa fa-thumbs-up"></i></div>
                            <?php endif; ?>

                            <!--Card Image-->
                            <a href="<?php echo e(route('kos.show', $similar['slug'])); ?>" class="card-img ts-item__image"
                                data-bg-image="<?php echo e(asset($similar['thumbnail'])); ?>"></a>

                            <!--Card Body-->
                            <div class="card-body ts-item__body">

                                <figure class="ts-item__info">
                                    <h4><?php echo e($similar['title']); ?></h4>
                                    <aside>
                                        <i class="fa fa-map-marker mr-2"></i>
                                        <?php echo e($similar['city']); ?>

                                    </aside>
                                </figure>

                                <div class="ts-item__info-badge">Rp <?php echo e(number_format($similar['price'], 0, ',', '.')); ?></div>

                                <div class="ts-description-lists">
                                    <dl>
                                        <dt>Luas</dt>
                                        <dd><?php echo e($similar['area'] ?? '12'); ?>m<sup>2</sup></dd>
                                    </dl>
                                    <dl>
                                        <dt>Kamar</dt>
                                        <dd><?php echo e($similar['bedrooms'] ?? '1'); ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>K. Mandi</dt>
                                        <dd>1</dd>
                                    </dl>
                                </div>
                            </div>

                            <!--Card Footer-->
                            <a href="<?php echo e(route('kos.show', $similar['slug'])); ?>" class="card-footer ts-item__footer">
                                <span class="ts-btn-arrow">Detail</span>
                            </a>

                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                </div>
            </div>
        </section>
        <?php endif; ?>

    </main>
    <!--end #ts-main-->

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<!--end page-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\PUSATKOS\resources\views/kos/show.blade.php ENDPATH**/ ?>