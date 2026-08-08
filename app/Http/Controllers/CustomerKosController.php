<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CustomerKosController extends Controller
{
    /**
     * Halaman kos yang sedang disewa customer.
     */
    public function index(): View
    {
        $rentedKos = [
            [
                'title' => 'Kos Putri Melati',
                'slug' => 'kos-putri-melati',
                'price' => 850000,
                'city' => 'Surabaya',
                'type' => 'Putri',
                'thumbnail' => 'assets/img/kos/1.png',
                'periode' => 'Berakhir 12 September 2026',
            ],
        ];

        return view('customer.kos.index', compact('rentedKos'));
    }

    /**
     * Halaman tagihan/invoice customer.
     */
    public function invoice(): View
    {
        $invoices = [
            [
                'invoice_number' => 'INV/2026/08/0001',
                'kos' => 'Kos Putri Melati',
                'amount' => 850000,
                'status' => 'Belum Dibayar',
                'due_date' => '10 Agustus 2026',
            ],
            [
                'invoice_number' => 'INV/2026/07/0001',
                'kos' => 'Kos Putri Melati',
                'amount' => 850000,
                'status' => 'Lunas',
                'due_date' => '10 Juli 2026',
            ],
        ];

        return view('customer.invoice.index', compact('invoices'));
    }
}
