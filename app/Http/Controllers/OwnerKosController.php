<?php

namespace App\Http\Controllers;

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
        ];

        return view('owner.kos.detail', compact('kos'));
    }
}
