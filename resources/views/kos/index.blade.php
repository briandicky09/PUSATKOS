@extends('layouts.app')

@section('title', 'Cari Kos - PUSATKOS')

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

                    @forelse($listKos as $kos)
                    <div class="col-sm-6 col-lg-4">
                        <div class="card ts-item ts-card ts-item__lg">
                            <div class="ts-ribbon"><i class="fa fa-thumbs-up"></i></div>
                            <a href="{{ route('kos.show', $kos['slug']) }}" class="card-img ts-item__image" data-bg-image="{{ asset($kos['thumbnail']) }}">
                                <div class="ts-item__info-badge">Rp {{ number_format($kos['price'], 0, ',', '.') }} /bln</div>
                                <figure class="ts-item__info">
                                    <h4>{{ $kos['title'] }}</h4>
                                    <aside><i class="fa fa-map-marker mr-2"></i>{{ $kos['city'] }}</aside>
                                </figure>
                            </a>
                            <div class="card-body">
                                <div class="ts-description-lists">
                                    <dl><dt>Tipe</dt><dd>{{ $kos['type'] }}</dd></dl>
                                    <dl><dt>Kamar</dt><dd>1</dd></dl>
                                    <dl><dt>K. Mandi</dt><dd>Dalam</dd></dl>
                                </div>
                            </div>
                            <a href="{{ route('kos.show', $kos['slug']) }}" class="card-footer"><span class="ts-btn-arrow">Detail</span></a>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="ts-box text-center py-5">
                            <p class="text-muted mb-0">Belum ada kos yang tersedia saat ini.</p>
                        </div>
                    </div>
                    @endforelse

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

    </main>
    <!--end #ts-main-->

    @include('partials.footer')

</div>
<!--end page-->
@endsection
