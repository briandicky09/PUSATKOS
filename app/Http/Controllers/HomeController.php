<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (homepage) PUSATKOS.
     */
    public function index(): View
    {
        // Ambil data kos aktif dari database
        $featuredKos = Kos::where('status', 'active')->latest()->take(6)->get();

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
