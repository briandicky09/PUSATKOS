<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (homepage) PUSATKOS.
     */
    public function index(): View
    {
        // Data dummy kos unggulan yang ditampilkan di homepage.
        $featuredKos = [
            [
                'title' => 'Kos Putri Melati',
                'slug' => 'kos-putri-melati',
                'price' => 850000,
                'city' => 'Surabaya',
                'type' => 'Putri',
                'thumbnail' => 'assets/img/img-item-thumb-01.jpg',
            ],
            [
                'title' => 'Kos Putra Anggrek',
                'slug' => 'kos-putra-anggrek',
                'price' => 750000,
                'city' => 'Malang',
                'type' => 'Putra',
                'thumbnail' => 'assets/img/img-item-thumb-02.jpg',
            ],
            [
                'title' => 'Kos Eksklusif Mawar',
                'slug' => 'kos-eksklusif-mawar',
                'price' => 1500000,
                'city' => 'Sidoarjo',
                'type' => 'Eksklusif',
                'thumbnail' => 'assets/img/img-item-thumb-03.jpg',
            ],
        ];

        return view('home.index', compact('featuredKos'));
    }

    /**
     * Tampilkan halaman tentang PUSATKOS.
     */
    public function about(): View
    {
        return view('owner.tentang');
    }
}
