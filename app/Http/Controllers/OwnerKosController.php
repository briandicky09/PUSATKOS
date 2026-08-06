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
                'thumbnail' => 'assets/img/img-item-thumb-01.jpg',
            ],
            [
                'title' => 'Kos Putra Anggrek',
                'slug' => 'kos-putra-anggrek',
                'price' => 750000,
                'city' => 'Malang',
                'type' => 'Putra',
                'status' => 'Aktif',
                'thumbnail' => 'assets/img/img-item-thumb-02.jpg',
            ],
            [
                'title' => 'Kos Eksklusif Mawar',
                'slug' => 'kos-eksklusif-mawar',
                'price' => 1500000,
                'city' => 'Sidoarjo',
                'type' => 'Eksklusif',
                'status' => 'Nonaktif',
                'thumbnail' => 'assets/img/img-item-thumb-03.jpg',
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
     * Halaman Kos Saya untuk owner.
     */
    public function myKos(): View
    {
        $listKos = $this->dummyKos();

        return view('owner.kos.my', compact('listKos'));
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
            'thumbnail' => 'assets/img/img-item-thumb-01.jpg',
        ];

        return view('owner.kos.show', compact('kos'));
    }
}
