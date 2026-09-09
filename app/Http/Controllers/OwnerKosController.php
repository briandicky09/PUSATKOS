<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKosRequest;
use App\Http\Requests\UpdateKosRequest;
use App\Models\Kos;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OwnerKosController extends Controller
{
    use AuthorizesRequests;

    /**
     * Dashboard owner.
     */
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $listKos = $user->kos()->latest()->get();
        $totalKos = $listKos->count();
        $kosAktif = $listKos->where('status', 'active')->count();
        $kosNonaktif = $listKos->where('status', 'inactive')->count();
        $rataHarga = (int) round($listKos->avg('price') ?? 0);
        $recentKos = $listKos->take(3);

        return view('owner.dashboard', compact('totalKos', 'kosAktif', 'kosNonaktif', 'rataHarga', 'recentKos'));
    }

    /**
     * Halaman daftar kos milik owner.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Kos::class);
        $listKos = $request->user()->kos()->latest()->get();

        return view('owner.kos.index', compact('listKos'));
    }

    /**
     * Form tambah kos baru.
     */
    public function create(): View
    {
        $this->authorize('create', Kos::class);

        return view('owner.kos.create');
    }

    /**
     * Simpan kos baru milik owner yang sedang login.
     * owner_id otomatis di-inject dari authenticated user (server-side).
     */
    public function store(StoreKosRequest $request): RedirectResponse
    {
        // Otorisasi dicek di StoreKosRequest & KosPolicy::create
        $validated = $request->validated();

        // Mencegah manipulasi owner_id dari frontend
        unset($validated['owner_id']);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Pastikan slug unik (termasuk cek soft-deleted records)
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Kos::withTrashed()->where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('kos', 'public');
            $validated['thumbnail'] = 'storage/' . $path;
        } else {
            $validated['thumbnail'] = 'assets/img/kos/1.png';
        }

        $validated['status'] = 'active';

        // Simpan kos dengan owner_id mutlak dari user yang sedang login
        $kos = $request->user()->kos()->create($validated);

        return redirect()->route('owner.kos.my')->with('success', 'Kos berhasil ditambahkan.');
    }

    /**
     * Halaman Kos Saya untuk owner.
     */
    public function myKos(Request $request): View
    {
        $this->authorize('viewAny', Kos::class);
        $listKos = $request->user()->kos()->latest()->get();

        return view('owner.kos.my', compact('listKos'));
    }

    /**
     * Halaman manajemen kos untuk owner.
     */
    public function manage(Request $request): View
    {
        $this->authorize('viewAny', Kos::class);
        $listKos = $request->user()->kos()->latest()->get();

        return view('owner.kos.manage', compact('listKos'));
    }

    /**
     * Halaman detail kos milik owner.
     */
    public function show(Kos $kos): View
    {
        $this->authorize('view', $kos);

        return view('owner.kos.detail', compact('kos'));
    }

    /**
     * Form edit kos milik owner.
     */
    public function edit(Kos $kos): View
    {
        $this->authorize('update', $kos);

        return view('owner.kos.edit', compact('kos'));
    }

    /**
     * Update data kos milik owner.
     */
    public function update(UpdateKosRequest $request, Kos $kos): RedirectResponse
    {
        $this->authorize('update', $kos);

        $validated = $request->validated();

        // Mencegah perubahan owner_id melalui request payload
        unset($validated['owner_id']);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('kos', 'public');
            $validated['thumbnail'] = 'storage/' . $path;
        }

        $kos->update($validated);

        return redirect()->route('owner.kos.show', $kos->slug)->with('success', 'Data kos berhasil diperbarui.');
    }

    /**
     * Hapus kos milik owner menggunakan Soft Delete.
     */
    public function destroy(Kos $kos): RedirectResponse
    {
        $this->authorize('delete', $kos);

        $kos->delete();

        return redirect()->route('owner.kos.my')->with('success', 'Kos berhasil dihapus.');
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
