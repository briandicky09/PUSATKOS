@extends('layouts.owner')

@section('title', 'Tambah Kos - PUSATKOS')

@section('owner-content')

<div class="card border-0 shadow-sm" style="border-radius: 8px;">
    <div class="card-body p-4 p-md-5">

        <h4 class="mb-4 font-weight-bold text-dark">Tambah Kos Baru</h4>

        {{-- TODO: arahkan action ke route POST owner.kos.store setelah CRUD diimplementasikan --}}
        <form id="form-create-kos" class="ts-form" method="POST" action="#">
            @csrf

            <div class="form-row">

                <!--Nama Kos-->
                <div class="col-md-6 form-group mb-3">
                    <label class="ts-text-small font-weight-bold text-muted mb-1">Nama Kos</label>
                    <input type="text" class="form-control" name="title" placeholder="Contoh: Kos Putri Melati" required>
                </div>

                <!--Tipe Kos-->
                <div class="col-md-6 form-group mb-3">
                    <label class="ts-text-small font-weight-bold text-muted mb-1">Tipe Kos</label>
                    <select class="custom-select" name="type" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Putra">Putra</option>
                        <option value="Putri">Putri</option>
                        <option value="Campur">Campur</option>
                        <option value="Eksklusif">Eksklusif</option>
                    </select>
                </div>

                <!--Kota-->
                <div class="col-md-6 form-group mb-3">
                    <label class="ts-text-small font-weight-bold text-muted mb-1">Kota</label>
                    <input type="text" class="form-control" name="city" placeholder="Contoh: Surabaya" required>
                </div>

                <!--Harga-->
                <div class="col-md-6 form-group mb-3">
                    <label class="ts-text-small font-weight-bold text-muted mb-1">Harga / Bulan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control" name="price" placeholder="850000" required>
                    </div>
                </div>

                <!--Alamat-->
                <div class="col-12 form-group mb-3">
                    <label class="ts-text-small font-weight-bold text-muted mb-1">Alamat Lengkap</label>
                    <input type="text" class="form-control" name="address" placeholder="Jl. Raya Sidoarjo No. 17">
                </div>

                <!--Deskripsi-->
                <div class="col-12 form-group mb-3">
                    <label class="ts-text-small font-weight-bold text-muted mb-1">Deskripsi</label>
                    <textarea class="form-control" name="description" rows="4" placeholder="Ceritakan fasilitas dan keunggulan kos kamu..."></textarea>
                </div>

                <!--Foto-->
                <div class="col-12 form-group mb-4">
                    <label class="ts-text-small font-weight-bold text-muted mb-1">Foto Kos</label>
                    <input type="file" class="form-control-file" name="thumbnail">
                </div>

            </div>
            <!--end form-row-->

            <button type="submit" class="btn btn-primary font-weight-bold px-4">
                <i class="fa fa-save mr-2"></i>Simpan Kos
            </button>
            <a href="{{ route('owner.kos.index') }}" class="btn btn-outline-dark font-weight-bold px-4">Batal</a>

        </form>

    </div>
</div>

@endsection
