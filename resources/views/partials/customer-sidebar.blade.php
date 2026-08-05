{{-- Sidebar navigasi untuk area Customer --}}
<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <a href="{{ route('customer.kos.index') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('customer.kos.index') ? 'active' : '' }}">
                <i class="fa fa-bed mr-2"></i> Kos Saya
            </a>
            <a href="{{ route('search.kos') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('search.kos') ? 'active' : '' }}">
                <i class="fa fa-search mr-2"></i> Cari Kos
            </a>
            <a href="{{ route('customer.invoice.index') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('customer.invoice.*') ? 'active' : '' }}">
                <i class="fa fa-file-invoice mr-2"></i> Tagihan / Invoice
            </a>
            <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                <i class="fa fa-home mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
