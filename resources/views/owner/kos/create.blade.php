@extends('layouts.app')

@section('title', 'Tambah Kos - PUSATKOS')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">
    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">
        <section class="py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h2 class="mb-1">Tambah Kos Baru</h2>
                        <p class="text-muted mb-0">Lengkapi data kos agar tampil konsisten dengan halaman owner lain.</p>
                    </div>
                    <a href="{{ route('owner.kos.manage') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>

                <div class="card ts-card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form id="form-create-kos" class="ts-form" method="POST" action="{{ route('owner.kos.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="border rounded p-3 p-md-4 mb-4">
                                <h6 class="font-weight-bold text-dark mb-3">Informasi Dasar</h6>

                                <div class="form-row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="ts-text-small font-weight-bold text-muted mb-1">Nama Kos</label>
                                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Contoh: Kos Putri Melati" required>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label class="ts-text-small font-weight-bold text-muted mb-1">Tipe Kos</label>
                                        <select class="custom-select" name="type" required>
                                            <option value="">Pilih Tipe</option>
                                            <option value="Putra" {{ old('type') === 'Putra' ? 'selected' : '' }}>Putra</option>
                                            <option value="Putri" {{ old('type') === 'Putri' ? 'selected' : '' }}>Putri</option>
                                            <option value="Campur" {{ old('type') === 'Campur' ? 'selected' : '' }}>Campur</option>
                                            <option value="Eksklusif" {{ old('type') === 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label class="ts-text-small font-weight-bold text-muted mb-1">Kota</label>
                                        <input type="text" class="form-control" name="city" value="{{ old('city') }}" placeholder="Contoh: Surabaya" required>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label class="ts-text-small font-weight-bold text-muted mb-1">Harga / Bulan</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="850000" required>
                                        </div>
                                    </div>

                                    <div class="col-12 form-group mb-0">
                                        <label class="ts-text-small font-weight-bold text-muted mb-1">Alamat Lengkap</label>
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Jl. Raya Sidoarjo No. 17">
                                    </div>
                                </div>
                            </div>

                            <div class="border rounded p-3 p-md-4 mb-4">
                                <h6 class="font-weight-bold text-dark mb-3">Deskripsi & Foto</h6>

                                <div class="form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Deskripsi</label>
                                    <textarea class="form-control" name="description" rows="4" placeholder="Ceritakan fasilitas dan keunggulan kos kamu...">{{ old('description') }}</textarea>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Foto Kos</label>
                                    <input type="file" class="form-control-file" name="thumbnail">
                                </div>
                            </div>

                            <div class="d-flex flex-wrap">
                                <button type="submit" class="btn btn-primary font-weight-bold px-4 mr-2 mb-2">
                                    <i class="fa fa-save mr-2"></i>Simpan Kos
                                </button>
                                <a href="{{ route('owner.kos.manage') }}" class="btn btn-outline-dark font-weight-bold px-4 mb-2">Batal</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
</div>

@endsection
