@extends('layouts.app')

@section('title', $kos['title'] . ' - PUSATKOS')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">

        <!--BREADCRUMB
        =========================================================================================================-->
        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kos.index') }}">Cari Kos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $kos['title'] }}</li>
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
                        <h1>{{ $kos['title'] }}</h1>
                        <h5 class="ts-opacity__90">
                            <i class="fa fa-map-marker text-primary"></i>
                            {{ $kos['address'] ?? $kos['city'] }}
                        </h5>
                    </div>

                    <!--Price-->
                    <h3>
                        <span class="badge badge-primary p-3 font-weight-normal ts-shadow__sm">Rp {{ number_format($kos['price'], 0, ',', '.') }} /bln</span>
                    </h3>

                </div>

            </div>
        </section>

        <!--GALLERY CAROUSEL
        =========================================================================================================-->
        <section id="gallery-carousel">

            <div class="owl-carousel ts-gallery-carousel ts-gallery-carousel__multi" data-owl-dots="1"
                data-owl-items="3" data-owl-center="1" data-owl-loop="1">

                @foreach($kos['gallery'] ?? ['assets/img/img-detail-01.jpg','assets/img/img-detail-02.jpg','assets/img/img-detail-05.jpg','assets/img/img-detail-04.jpg','assets/img/img-detail-03.jpg'] as $image)
                <!--Slide-->
                <div class="slide">
                    <div class="ts-image" data-bg-image="{{ asset($image) }}">
                        <a href="{{ asset($image) }}" class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
                    </div>
                </div>
                @endforeach

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
                                    <dd>Kos {{ $kos['type'] ?? '-' }}</dd>

                                    <dt>Status:</dt>
                                    <dd>{{ $kos['status'] ?? 'Tersedia' }}</dd>

                                    <dt>Luas:</dt>
                                    <dd>{{ $kos['area'] ?? '-' }} m<sup>2</sup></dd>

                                    <dt>Kamar:</dt>
                                    <dd>{{ $kos['rooms'] ?? '-' }}</dd>

                                    <dt>K. Mandi:</dt>
                                    <dd>{{ $kos['bathrooms'] ?? '-' }}</dd>

                                    <dt>Tempat Tidur:</dt>
                                    <dd>{{ $kos['bedrooms'] ?? '-' }}</dd>

                                    <dt>Parkir:</dt>
                                    <dd>{{ $kos['garages'] ?? '-' }}</dd>

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
                                        data-bg-image="{{ asset($kos['owner_photo'] ?? 'assets/img/img-person-05.jpg') }}"></a>

                                    <!--Phone contact-->
                                    <figure class="mb-0">
                                        <h5 class="mb-0">{{ $kos['owner_name'] ?? 'Pemilik Kos' }}</h5>
                                        <p class="mb-0">
                                            <i class="fa fa-phone-square ts-opacity__50 mr-2"></i>
                                            {{ $kos['owner_phone'] ?? '-' }}
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
                                            placeholder="Halo, saya ingin bertanya tentang {{ $kos['title'] }}"></textarea>
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

                                <a href="https://wa.me/6280286216730?text=Halo, saya tertarik dengan {{ urlencode($kos['title']) }}"
                                    target="_blank" class="btn btn-success btn-block mb-2">
                                    <i class="fab fa-whatsapp mr-2"></i>Hubungi via WhatsApp
                                </a>

                                <a href="{{ route('member.invoice.index') }}"
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
                                    <dd class="border-bottom pb-2">{{ $kos['address'] ?? $kos['city'] }}</dd>

                                    <dt><i class="fa fa-phone-square ts-opacity__30 mr-2"></i>Telepon:</dt>
                                    <dd class="border-bottom pb-2">{{ $kos['owner_phone'] ?? '-' }}</dd>

                                    <dt><i class="fa fa-envelope ts-opacity__30 mr-2"></i>Email:</dt>
                                    <dd class="border-bottom pb-2"><a href="mailto:{{ $kos['owner_email'] ?? 'hello@pusatkos.id' }}">{{ $kos['owner_email'] ?? 'hello@pusatkos.id' }}</a></dd>

                                    <dt><i class="fa fa-globe ts-opacity__30 mr-2"></i>Website:</dt>
                                    <dd><a href="{{ route('home') }}">pusatkos.id</a></dd>

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
                                            data-bg-image="{{ asset('assets/img/icon-quick-info-shower.png') }}">
                                            <h6>K. Mandi</h6>
                                            <figure>{{ $kos['bathrooms'] ?? '1' }}</figure>
                                        </div>
                                    </div>

                                    <!--Bedrooms-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="{{ asset('assets/img/icon-quick-info-bed.png') }}">
                                            <h6>Kamar Tidur</h6>
                                            <figure>{{ $kos['bedrooms'] ?? '1' }}</figure>
                                        </div>
                                    </div>

                                    <!--Area-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="{{ asset('assets/img/icon-quick-info-area.png') }}">
                                            <h6>Luas</h6>
                                            <figure>{{ $kos['area'] ?? '-' }}m<sup>2</sup></figure>
                                        </div>
                                    </div>

                                    <!--Garages-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="{{ asset('assets/img/icon-quick-info-garages.png') }}">
                                            <h6>Parkir</h6>
                                            <figure>{{ $kos['garages'] ?? '-' }}</figure>
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

                            <p>{{ $kos['description'] ?? 'Deskripsi belum tersedia.' }}</p>

                        </section>

                        <!--FEATURES
                        =========================================================================================-->
                        <section id="features">

                            <h3>Fasilitas</h3>

                            <ul class="list-unstyled ts-list-icons ts-column-count-4 ts-column-count-sm-2 ts-column-count-md-2">
                                @foreach($kos['features'] ?? [] as $feature)
                                <li>
                                    <i class="fa {{ $feature['icon'] }}"></i>
                                    {{ $feature['name'] }}
                                </li>
                                @endforeach
                            </ul>

                        </section>

                        <!--MAP PLACEHOLDER
                        =========================================================================================-->
                        <section id="map-location">

                            <h3>Peta Lokasi</h3>

                            <div class="ts-box text-center py-5" style="background-color: #f5f7f9;">
                                <i class="fa fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Peta lokasi akan segera tersedia.</p>
                                <p class="text-muted mb-0"><small>{{ $kos['address'] ?? $kos['city'] }}</small></p>
                            </div>

                        </section>

                        <!--AMENITIES
                        =========================================================================================-->
                        <section id="amenities">

                            <h3>Fasilitas Tambahan</h3>

                            <ul class="ts-list-colored-bullets ts-text-color-light ts-column-count-3 ts-column-count-md-2">
                                @foreach($kos['facilities'] ?? [] as $facility)
                                <li>{{ $facility }}</li>
                                @endforeach
                            </ul>

                        </section>

                    </div>
                    <!--end col-md-8-->

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

        <!--REVIEWS
        =============================================================================================================-->
        <section id="reviews" class="pk-reviews">
            <div class="container">
                <div class="row">
                    <div class="offset-lg-4 col-sm-12 col-lg-8 pk-detail-section">
                        <hr class="mb-3">

                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                            <div>
                                <h3 class="mb-1">Ulasan Penghuni</h3>
                                <p class="text-muted mb-0">Pengalaman penghuni di {{ $kos['title'] }}</p>
                            </div>
                            <div class="pk-reviews__summary">
                                <i class="fa fa-star"></i>
                                <strong>{{ number_format($kos['rating'] ?? 0, 1) }}</strong>
                                <span>({{ $kos['review_count'] ?? 0 }} ulasan)</span>
                            </div>
                        </div>

                        <div class="ts-box pk-reviews__breakdown mb-4">
                            <div class="row">
                                @foreach($kos['rating_breakdown'] ?? [] as $rating)
                                <div class="col-md-6 mb-3 mb-md-2">
                                    <div class="pk-review-score">
                                        <span>{{ $rating['label'] }}</span>
                                        <span class="pk-review-score__stars" aria-label="Rating {{ $rating['score'] }} dari 5">
                                            @for($star = 1; $star <= 5; $star++)
                                                <i class="fa fa-star{{ $star <= round($rating['score']) ? '' : '-o' }}"></i>
                                            @endfor
                                        </span>
                                        <strong>{{ number_format($rating['score'], 1) }}</strong>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @foreach($kos['reviews'] ?? [] as $review)
                        <article class="pk-review-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-center">
                                    <div class="pk-review-item__avatar"><i class="fa fa-user"></i></div>
                                    <div>
                                        <h5 class="mb-1">{{ $review['name'] }}</h5>
                                        <small class="text-muted">{{ $review['date'] }}</small>
                                    </div>
                                </div>
                                <span class="pk-review-item__score"><i class="fa fa-star"></i> {{ number_format($review['score'], 1) }}</span>
                            </div>
                            <p class="mb-0 mt-4">{{ $review['comment'] }}</p>

                            @if(!empty($review['reply']))
                            <div class="pk-review-item__reply">
                                <strong>Balasan dari Pemilik Kos</strong>
                                <p class="mb-0 mt-1">{{ $review['reply'] }}</p>
                            </div>
                            @endif
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!--SIMILAR PROPERTIES
        =============================================================================================================-->
        @if(!empty($similarKos))
        <section id="similar-properties">
            <div class="container">
                <div class="row">

                    <div class="offset-lg-4 col-sm-12 col-lg-8 pk-detail-section">

                        <hr class="mb-5">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="mb-0">Kos Serupa</h3>
                            <span class="text-muted pk-similar-count">{{ count($similarKos) }} pilihan</span>
                        </div>

                        @foreach($similarKos as $similar)
                        <!--Item-->
                        <div class="card ts-item ts-item__list ts-card pk-similar-card">

                            @if($loop->first)
                            <div class="ts-ribbon"><i class="fa fa-thumbs-up"></i></div>
                            @endif

                            <!--Card Image-->
                            <a href="{{ route('kos.show', $similar['slug']) }}" class="card-img ts-item__image"
                                data-bg-image="{{ asset($similar['thumbnail']) }}"></a>

                            <!--Card Body-->
                            <div class="card-body ts-item__body">

                                <figure class="ts-item__info">
                                    <h4>{{ $similar['title'] }}</h4>
                                    <aside>
                                        <i class="fa fa-map-marker mr-2"></i>
                                        {{ $similar['city'] }}
                                    </aside>
                                </figure>

                                <div class="ts-item__info-badge">Rp {{ number_format($similar['price'], 0, ',', '.') }}</div>

                                <div class="ts-description-lists">
                                    <dl>
                                        <dt>Luas</dt>
                                        <dd>{{ $similar['area'] ?? '12' }}m<sup>2</sup></dd>
                                    </dl>
                                    <dl>
                                        <dt>Kamar</dt>
                                        <dd>{{ $similar['bedrooms'] ?? '1' }}</dd>
                                    </dl>
                                    <dl>
                                        <dt>K. Mandi</dt>
                                        <dd>1</dd>
                                    </dl>
                                </div>
                            </div>

                            <!--Card Footer-->
                            <a href="{{ route('kos.show', $similar['slug']) }}" class="card-footer ts-item__footer">
                                <span class="ts-btn-arrow">Detail</span>
                            </a>

                        </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </section>
        @endif

    </main>
    <!--end #ts-main-->

    @include('partials.footer')

</div>
<!--end page-->
@endsection
