@extends('layouts.owner')

@section('title', 'Manajemen Kos - PUSATKOS')

@section('owner-content')
<div class="card border-0 shadow-sm" style="border-radius: 8px;">
    <div class="card-body p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 font-weight-bold text-dark">Manajemen Kos</h4>
                <p class="text-muted mb-0">Pantau dan kelola semua kos yang Anda miliki.</p>
            </div>
            <a href="{{ route('owner.kos.create') }}" class="btn btn-primary">+ Tambah Kos</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Kos</th>
                        <th>Kota</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listKos as $kos)
                        <tr>
                            <td>
                                <strong>{{ $kos['title'] }}</strong><br>
                                <small class="text-muted">{{ ucfirst($kos['type']) }}</small>
                            </td>
                            <td>{{ $kos['city'] }}</td>
                            <td>Rp {{ number_format($kos['price'], 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $kos['status'] === 'Aktif' ? 'badge-success' : 'badge-secondary' }}">{{ $kos['status'] }}</span>
                            </td>
                            <td>
                                <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
