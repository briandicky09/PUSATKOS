@extends('layouts.owner')

@section('title', 'Edit Kos - PUSATKOS')

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="mb-1">Edit Kos</h2>
                    <p class="text-muted mb-0">Perbarui data properti kos Anda agar tetap relevan.</p>
                </div>
                <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="btn btn-outline-secondary">Kembali</a>
            </div>

            <div class="card ts-card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <form id="form-edit-kos" class="ts-form" method="POST" action="{{ route('owner.kos.update', $kos['slug']) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="border rounded p-3 p-md-4 mb-4">
                            <h6 class="font-weight-bold text-dark mb-3">Informasi Dasar</h6>

                            <div class="form-row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Nama Kos</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $kos['title']) }}" placeholder="Contoh: Kos Putri Melati" required>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Tipe Kos</label>
                                    <select class="custom-select" name="type" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="Putra" {{ old('type', $kos['type']) === 'Putra' ? 'selected' : '' }}>Putra</option>
                                        <option value="Putri" {{ old('type', $kos['type']) === 'Putri' ? 'selected' : '' }}>Putri</option>
                                        <option value="Campur" {{ old('type', $kos['type']) === 'Campur' ? 'selected' : '' }}>Campur</option>
                                        <option value="Eksklusif" {{ old('type', $kos['type']) === 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Kota</label>
                                    <input type="text" class="form-control" name="city" value="{{ old('city', $kos['city']) }}" placeholder="Contoh: Surabaya" required>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Harga / Bulan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control" name="price" value="{{ old('price', $kos['price']) }}" placeholder="850000" required>
                                    </div>
                                </div>

                                <div class="col-12 form-group mb-0">
                                    <label class="ts-text-small font-weight-bold text-muted mb-1">Alamat Lengkap</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address', $kos['address'] ?? '') }}" placeholder="Jl. Raya Sidoarjo No. 17">
                                </div>
                            </div>
                        </div>

                        <div class="border rounded p-3 p-md-4 mb-4">
                            <h6 class="font-weight-bold text-dark mb-3">Deskripsi & Foto</h6>

                            <div class="form-group mb-3">
                                <label class="ts-text-small font-weight-bold text-muted mb-1">Deskripsi</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Ceritakan fasilitas dan keunggulan kos kamu...">{{ old('description', $kos['description'] ?? '') }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label class="ts-text-small font-weight-bold text-muted mb-1">Foto Kos</label>
                                <input type="file" class="form-control-file" name="thumbnail">
                                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti foto saat ini.</small>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap">
                            <button type="submit" class="btn btn-primary font-weight-bold px-4 mr-2 mb-2">
                                <i class="fa fa-save mr-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="btn btn-outline-dark font-weight-bold px-4 mb-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
