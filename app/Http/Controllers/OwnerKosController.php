<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OwnerKosController extends Controller
{
    /**
     * Data dummy kos milik owner. Nantinya diganti dengan query ke model Kos.
     */
    protected function dummyKos(): array
    {
        return [
            [
                'title' => 'Kos Putri Melati',
                'slug' => 'kos-putri-melati',
                'price' => 850000,
                'city' => 'Surabaya',
                'type' => 'Putri',
                'status' => 'Aktif',
                'thumbnail' => 'assets/img/kos/1.png',
            ],
            [
                'title' => 'Kos Putra Anggrek',
                'slug' => 'kos-putra-anggrek',
                'price' => 750000,
                'city' => 'Malang',
                'type' => 'Putra',
                'status' => 'Aktif',
                'thumbnail' => 'assets/img/kos/2.png',
            ],
            [
                'title' => 'Kos Eksklusif Mawar',
                'slug' => 'kos-eksklusif-mawar',
                'price' => 1500000,
                'city' => 'Sidoarjo',
                'type' => 'Eksklusif',
                'status' => 'Nonaktif',
                'thumbnail' => 'assets/img/kos/3.png',
            ],
        ];
    }

    /**
     * Dashboard owner.
     */
    public function dashboard(): View
    {
        $listKos = $this->dummyKos();
        $totalKos = count($listKos);
        $kosAktif = collect($listKos)->where('status', 'Aktif')->count();
        $kosNonaktif = $totalKos - $kosAktif;
        $rataHarga = (int) round(collect($listKos)->avg('price') ?? 0);
        $recentKos = array_slice($listKos, 0, 3);

        return view('owner.dashboard', compact('totalKos', 'kosAktif', 'kosNonaktif', 'rataHarga', 'recentKos'));
    }

    /**
     * Halaman daftar kos milik owner.
     */
    public function index(): View
    {
        $listKos = $this->dummyKos();

        return view('owner.kos.index', compact('listKos'));
    }

    /**
     * Form tambah kos baru.
     */
    public function create(): View
    {
        return view('owner.kos.create');
    }

    /**
     * Simpan kos baru (versi sementara, tanpa database).
     */
    public function store(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'address' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        session()->flash('success', 'Kos berhasil ditambahkan.');

        return redirect()->route('owner.kos.my');
    }

    /**
     * Halaman Kos Saya untuk owner.
     */
    public function myKos(): View
    {
        $listKos = $this->dummyKos();

        return view('owner.kos.my', compact('listKos'));
    }

    /**
     * Halaman manajemen kos untuk owner.
     */
    public function manage(): View
    {
        $listKos = $this->dummyKos();

        return view('owner.kos.manage', compact('listKos'));
    }

    /**
     * Halaman penilaian kos untuk owner.
     */
    public function penilaian(): View
    {
        $ratings = [
            [
                'kos' => 'Kos Putri Melati',
                'slug' => 'kos-putri-melati',
                'rating' => 4.8,
                'total' => 24,
                'latest' => 'Tempatnya bersih dan pemilik sangat responsif.',
                'reviewer' => 'Dewi Sartika',
                'date' => '18 Agustus 2026',
            ],
            [
                'kos' => 'Kos Putra Anggrek',
                'slug' => 'kos-putra-anggrek',
                'rating' => 4.5,
                'total' => 16,
                'latest' => 'Lokasi strategis, fasilitas sesuai dengan deskripsi.',
                'reviewer' => 'Rizky Maulana',
                'date' => '12 Agustus 2026',
            ],
            [
                'kos' => 'Kos Eksklusif Mawar',
                'slug' => 'kos-eksklusif-mawar',
                'rating' => 4.2,
                'total' => 9,
                'latest' => 'Kamar nyaman, semoga pilihan fasilitasnya bertambah.',
                'reviewer' => 'Anisa Putri',
                'date' => '5 Agustus 2026',
            ],
        ];

        $totalUlasan = collect($ratings)->sum('total');
        $rataRating = round(collect($ratings)->avg('rating'), 1);

        return view('owner.kos.penilaian', compact('ratings', 'totalUlasan', 'rataRating'));
    }

    /**
     * Halaman laporan statistik owner.
     */
    public function statistik(): View
    {
        $summary = [
            'pendapatan' => 31250000,
            'booking' => 42,
            'tingkat_hunian' => 78,
            'pertumbuhan' => 12.5,
        ];

        $monthlyRevenue = [
            ['month' => 'Mar', 'value' => 4200000],
            ['month' => 'Apr', 'value' => 5100000],
            ['month' => 'Mei', 'value' => 4600000],
            ['month' => 'Jun', 'value' => 5800000],
            ['month' => 'Jul', 'value' => 5300000],
            ['month' => 'Agu', 'value' => 7000000],
        ];

        $kosPerformance = [
            ['title' => 'Kos Putri Melati', 'occupancy' => 92, 'booking' => 18, 'revenue' => 15300000],
            ['title' => 'Kos Putra Anggrek', 'occupancy' => 81, 'booking' => 15, 'revenue' => 11250000],
            ['title' => 'Kos Eksklusif Mawar', 'occupancy' => 60, 'booking' => 9, 'revenue' => 13500000],
        ];

        return view('owner.laporan.statistik', compact('summary', 'monthlyRevenue', 'kosPerformance'));
    }

    /**
     * Form edit kos milik owner.
     */
    public function edit(string $slug): View
    {
        $kos = collect($this->dummyKos())->firstWhere('slug', $slug) ?? [
            'title' => 'Kos Putri Melati',
            'slug' => $slug,
            'price' => 850000,
            'city' => 'Surabaya',
            'type' => 'Putri',
            'status' => 'Aktif',
            'thumbnail' => 'assets/img/kos/1.png',
            'description' => 'Deskripsi kos belum tersedia.',
            'address' => 'Jl. Raya Sidoarjo No. 17',
        ];

        return view('owner.kos.edit', compact('kos'));
    }

    /**
     * Update kos milik owner.
     */
    public function update(Request $request, string $slug): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'address' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        session()->flash('success', 'Data kos berhasil diperbarui.');

        return redirect()->route('owner.kos.show', $slug);
    }

    /**
     * Halaman detail kos milik owner.
     */
    public function show(string $slug): View
    {
        $kos = collect($this->dummyKos())->firstWhere('slug', $slug) ?? [
            'title' => 'Kos Putri Melati',
            'slug' => $slug,
            'price' => 850000,
            'city' => 'Surabaya',
            'type' => 'Putri',
            'status' => 'Aktif',
            'thumbnail' => 'assets/img/kos/1.png',
            'description' => 'Deskripsi kos belum tersedia.',
            'address' => 'Jl. Raya Sidoarjo No. 17',
        ];

        return view('owner.kos.detail', compact('kos'));
    }

    /**
     * Halaman notifikasi owner.
     */
    public function notifikasi(): View
    {
        $notifications = [
            [
                'title' => 'Pesanan Baru',
                'message' => 'Ada pesanan baru untuk Kos Putri Melati dari Dewi Sartika.',
                'time' => '10 menit yang lalu',
                'is_read' => false,
                'icon' => 'fa-bell text-primary',
            ],
            [
                'title' => 'Pembayaran Berhasil',
                'message' => 'Pembayaran untuk INV-2026-08-0001 telah berhasil dikonfirmasi.',
                'time' => '1 jam yang lalu',
                'is_read' => true,
                'icon' => 'fa-check-circle text-success',
            ],
            [
                'title' => 'Pertanyaan Baru',
                'message' => 'Ada pesan pertanyaan baru terkait Kos Putra Anggrek.',
                'time' => '1 hari yang lalu',
                'is_read' => true,
                'icon' => 'fa-envelope text-info',
            ],
        ];

        return view('owner.notifikasi.index', compact('notifications'));
    }
}
