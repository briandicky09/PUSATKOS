<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class KosController extends Controller
{
    /**
     * Data dummy kos untuk halaman publik.
     * Nantinya diganti dengan query ke model Kos.
     */
    protected function dummyKos(): array
    {
        return [
            [
                'title' => 'Kos Putri Melati',
                'slug' => 'kos-putri-melati',
                'price' => 850000,
                'city' => 'Surabaya',
                'address' => 'Jl. Kalirungkut No. 88, Ruko Rungkut Makmur Blok C, Surabaya',
                'type' => 'Putri',
                'status' => 'Tersedia',
                'thumbnail' => 'assets/img/kos-melati.png',
                'description' => 'Menikmati hunian eksklusif di kawasan Kalirungkut kini semakin mudah. Kost ini menyuguhkan panorama ala hotel berbintang lima dengan nuansa asri dan tenang, meski berada di jantung kota yang dekat dengan berbagai pusat perbelanjaan serta deretan kuliner favorit. Keamanan terjamin berkat sistem one way gate yang memantau setiap akses keluar masuk.',
                'owner_name' => 'Rokhim Wicaksono',
                'owner_phone' => '+62 802-862-1673',
                'owner_email' => 'rokhim@pusatkos.id',
                'owner_photo' => 'assets/img/img-person-05.jpg',
                'facilities' => ['Wi-Fi', 'AC', 'Kamar Mandi Dalam', 'Kasur', 'Lemari', 'Meja Belajar', 'Dapur Bersama', 'Parkir Motor'],
                'features' => [
                    ['icon' => 'fa-wifi', 'name' => 'Wi-Fi'],
                    ['icon' => 'fa-snowflake', 'name' => 'AC'],
                    ['icon' => 'fa-bath', 'name' => 'Kamar Mandi Dalam'],
                    ['icon' => 'fa-bed', 'name' => 'Kasur'],
                    ['icon' => 'fa-utensils', 'name' => 'Dapur Bersama'],
                    ['icon' => 'fa-motorcycle', 'name' => 'Parkir Motor'],
                    ['icon' => 'fa-key', 'name' => 'Kunci Kamar'],
                    ['icon' => 'fa-shield-alt', 'name' => 'Keamanan 24 Jam'],
                ],
                'area' => '12',
                'rooms' => '4 Kamar',
                'bathrooms' => '1 Dalam',
                'bedrooms' => '1',
                'garages' => 'Motor (Gratis)',
                'gallery' => [
                    'assets/img/img-detail-01.jpg',
                    'assets/img/img-detail-02.jpg',
                    'assets/img/img-detail-05.jpg',
                    'assets/img/img-detail-04.jpg',
                    'assets/img/img-detail-03.jpg',
                ],
            ],
            [
                'title' => 'Kos Putra Anggrek',
                'slug' => 'kos-putra-anggrek',
                'price' => 750000,
                'city' => 'Malang',
                'address' => 'Jl. Soekarno Hatta No. 12, Malang',
                'type' => 'Putra',
                'status' => 'Tersedia',
                'thumbnail' => 'assets/img/kos-anggrek.jpg',
                'description' => 'Kos putra dengan lokasi strategis dekat kampus dan pusat kota Malang. Dilengkapi fasilitas modern untuk kenyamanan penghuni. Lingkungan aman dan tenang cocok untuk mahasiswa.',
                'owner_name' => 'Ahmad Fauzi',
                'owner_phone' => '+62 812-3456-7890',
                'owner_email' => 'ahmad@pusatkos.id',
                'owner_photo' => 'assets/img/img-person-05.jpg',
                'facilities' => ['Wi-Fi', 'Kamar Mandi Dalam', 'Kasur', 'Lemari', 'Parkir Motor'],
                'features' => [
                    ['icon' => 'fa-wifi', 'name' => 'Wi-Fi'],
                    ['icon' => 'fa-bath', 'name' => 'Kamar Mandi Dalam'],
                    ['icon' => 'fa-bed', 'name' => 'Kasur'],
                    ['icon' => 'fa-motorcycle', 'name' => 'Parkir Motor'],
                    ['icon' => 'fa-key', 'name' => 'Kunci Kamar'],
                    ['icon' => 'fa-shield-alt', 'name' => 'Keamanan 24 Jam'],
                ],
                'area' => '10',
                'rooms' => '6 Kamar',
                'bathrooms' => '1 Dalam',
                'bedrooms' => '1',
                'garages' => 'Motor (Gratis)',
                'gallery' => [
                    'assets/img/img-detail-02.jpg',
                    'assets/img/img-detail-01.jpg',
                    'assets/img/img-detail-03.jpg',
                    'assets/img/img-detail-04.jpg',
                    'assets/img/img-detail-05.jpg',
                ],
            ],
            [
                'title' => 'Kos Eksklusif Mawar',
                'slug' => 'kos-eksklusif-mawar',
                'price' => 1500000,
                'city' => 'Sidoarjo',
                'address' => 'Jl. Raya Sidoarjo No. 45, Sidoarjo',
                'type' => 'Eksklusif',
                'status' => 'Tersedia',
                'thumbnail' => 'assets/img/kos-mawar.webp',
                'description' => 'Kos eksklusif dengan fasilitas premium. Full furnished, AC, TV, kulkas, dan kamar mandi dalam. Lokasi strategis di pusat kota Sidoarjo dengan akses mudah ke berbagai fasilitas umum.',
                'owner_name' => 'Siti Nurhaliza',
                'owner_phone' => '+62 813-9876-5432',
                'owner_email' => 'siti@pusatkos.id',
                'owner_photo' => 'assets/img/img-person-05.jpg',
                'facilities' => ['Wi-Fi', 'AC', 'TV', 'Kulkas', 'Kamar Mandi Dalam', 'Kasur', 'Lemari', 'Meja Belajar', 'Dapur Bersama', 'Parkir Mobil'],
                'features' => [
                    ['icon' => 'fa-wifi', 'name' => 'Wi-Fi'],
                    ['icon' => 'fa-snowflake', 'name' => 'AC'],
                    ['icon' => 'fa-tv', 'name' => 'TV'],
                    ['icon' => 'fa-bath', 'name' => 'Kamar Mandi Dalam'],
                    ['icon' => 'fa-bed', 'name' => 'Kasur'],
                    ['icon' => 'fa-car', 'name' => 'Parkir Mobil'],
                    ['icon' => 'fa-key', 'name' => 'Kunci Kamar'],
                    ['icon' => 'fa-shield-alt', 'name' => 'Keamanan 24 Jam'],
                ],
                'area' => '16',
                'rooms' => '8 Kamar',
                'bathrooms' => '1 Dalam',
                'bedrooms' => '1',
                'garages' => 'Mobil (Rp50.000)',
                'gallery' => [
                    'assets/img/img-detail-03.jpg',
                    'assets/img/img-detail-01.jpg',
                    'assets/img/img-detail-02.jpg',
                    'assets/img/img-detail-04.jpg',
                    'assets/img/img-detail-05.jpg',
                ],
            ],
        ];
    }

    /**
     * Halaman daftar kos publik.
     */
    public function index(): View
    {
        $listKos = $this->dummyKos();

        return view('kos.index', compact('listKos'));
    }

    /**
     * Halaman detail kos publik.
     */
    public function show(string $slug): View
    {
        $allKos = $this->dummyKos();
        $kos = collect($allKos)->firstWhere('slug', $slug);

        if (!$kos) {
            $kos = $allKos[0];
            $kos['slug'] = $slug;
        }

        // Kos serupa (exclude yang sedang dilihat)
        $similarKos = collect($allKos)->where('slug', '!=', $slug)->values()->take(3)->all();

        return view('kos.show', compact('kos', 'similarKos'));
    }
}
