<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KosController extends Controller
{
    /**
     * Halaman daftar kos publik.
     * Hanya menampilkan kos yang berstatus active dan tidak di-soft-delete.
     */
    public function index(Request $request): View
    {
        $query = Kos::query()->where('status', 'active');

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('city', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        $listKos = $query->latest()->get();

        return view('kos.index', compact('listKos'));
    }

    /**
     * Halaman detail kos publik berdasarkan slug.
     * Mengembalikan 404 jika slug tidak ditemukan, status inactive, atau soft-deleted.
     */
    public function show(string $slug): View
    {
        $kos = Kos::with('owner')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Properti kos serupa (aktif, tidak soft-deleted, dan exclude kos saat ini)
        $similarKos = Kos::where('status', 'active')
            ->where('id', '!=', $kos->id)
            ->latest()
            ->take(3)
            ->get();

        return view('kos.show', compact('kos', 'similarKos'));
    }
}
