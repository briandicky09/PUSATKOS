@extends('layouts.owner')

@section('title', 'Detail Kos - PUSATKOS')

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="mb-1 font-weight-bold text-dark">Detail Kos</h4>
                            <p class="text-muted mb-0">Informasi lengkap properti kos Anda.</p>
                        </div>
                        <a href="{{ route('owner.kos.my') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <img src="{{ asset($kos['thumbnail']) }}" alt="{{ $kos['title'] }}" class="img-fluid rounded mb-3" style="height: 320px; object-fit: cover; width: 100%;">
                            <h5 class="font-weight-bold">{{ $kos['title'] }}</h5>
                            <p class="text-muted">{{ $kos['city'] }} • {{ ucfirst($kos['type']) }}</p>
                            <p>{{ $kos['description'] ?? 'Deskripsi kos belum tersedia.' }}</p>
                        </div>
                        <div class="col-lg-5">
                            <div class="border rounded p-3 mb-3">
                                <h6 class="font-weight-bold">Informasi Harga</h6>
                                <p class="mb-1"><strong>Rp {{ number_format($kos['price'], 0, ',', '.') }}</strong>/bulan</p>
                                <p class="mb-0"><span class="badge {{ $kos['status'] === 'Aktif' ? 'badge-success' : 'badge-secondary' }}">{{ $kos['status'] }}</span></p>
                            </div>
                            <div class="border rounded p-3">
                                <h6 class="font-weight-bold">Aksi</h6>
                                <a href="{{ route('owner.kos.edit', $kos['slug']) }}" class="btn btn-outline-primary btn-sm mb-2 d-block">Edit Kos</a>
                                <a href="#" class="btn btn-outline-danger btn-sm d-block">Hapus Kos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
