<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Halaman profil member.
     */
    public function profile(): View
    {
        return view('member.profile.index', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Data dummy invoice untuk member.
     * Nantinya diganti dengan query ke model Invoice.
     */
    protected function dummyInvoices(): array
    {
        return [
            [
                'invoice_number' => 'INV-2026-08-0001',
                'kos' => 'Kos Putri Melati',
                'kos_slug' => 'kos-putri-melati',
                'tenant_name' => 'Dewi Sartika',
                'tenant_email' => 'dewi@email.com',
                'tenant_phone' => '+62 812-3456-7890',
                'amount' => 850000,
                'admin_fee' => 25000,
                'tax' => 0,
                'total' => 875000,
                'status' => 'Lunas',
                'payment_method' => 'Transfer Bank BCA',
                'booking_date' => '1 Agustus 2026',
                'check_in' => '5 Agustus 2026',
                'check_out' => '5 September 2026',
                'duration' => '1 Bulan',
                'due_date' => '3 Agustus 2026',
                'paid_at' => '2 Agustus 2026',
            ],
            [
                'invoice_number' => 'INV-2026-07-0003',
                'kos' => 'Kos Putri Melati',
                'kos_slug' => 'kos-putri-melati',
                'tenant_name' => 'Dewi Sartika',
                'tenant_email' => 'dewi@email.com',
                'tenant_phone' => '+62 812-3456-7890',
                'amount' => 850000,
                'admin_fee' => 25000,
                'tax' => 0,
                'total' => 875000,
                'status' => 'Lunas',
                'payment_method' => 'E-Wallet GoPay',
                'booking_date' => '28 Juni 2026',
                'check_in' => '5 Juli 2026',
                'check_out' => '5 Agustus 2026',
                'duration' => '1 Bulan',
                'due_date' => '30 Juni 2026',
                'paid_at' => '29 Juni 2026',
            ],
            [
                'invoice_number' => 'INV-2026-08-0005',
                'kos' => 'Kos Eksklusif Mawar',
                'kos_slug' => 'kos-eksklusif-mawar',
                'tenant_name' => 'Dewi Sartika',
                'tenant_email' => 'dewi@email.com',
                'tenant_phone' => '+62 812-3456-7890',
                'amount' => 1500000,
                'admin_fee' => 25000,
                'tax' => 0,
                'total' => 1525000,
                'status' => 'Belum Dibayar',
                'payment_method' => '-',
                'booking_date' => '5 Agustus 2026',
                'check_in' => '10 Agustus 2026',
                'check_out' => '10 September 2026',
                'duration' => '1 Bulan',
                'due_date' => '8 Agustus 2026',
                'paid_at' => null,
            ],
            [
                'invoice_number' => 'INV-2026-06-0002',
                'kos' => 'Kos Putra Anggrek',
                'kos_slug' => 'kos-putra-anggrek',
                'tenant_name' => 'Dewi Sartika',
                'tenant_email' => 'dewi@email.com',
                'tenant_phone' => '+62 812-3456-7890',
                'amount' => 750000,
                'admin_fee' => 25000,
                'tax' => 0,
                'total' => 775000,
                'status' => 'Kadaluarsa',
                'payment_method' => '-',
                'booking_date' => '1 Juni 2026',
                'check_in' => '5 Juni 2026',
                'check_out' => '5 Juli 2026',
                'duration' => '1 Bulan',
                'due_date' => '3 Juni 2026',
                'paid_at' => null,
            ],
        ];
    }

    /**
     * Halaman daftar invoice member.
     */
    public function invoice(): View
    {
        $invoices = $this->dummyInvoices();

        return view('member.invoice.index', compact('invoices'));
    }

    /**
     * Halaman detail invoice member.
     */
    public function invoiceDetail(string $nomor): View
    {
        $invoice = collect($this->dummyInvoices())->firstWhere('invoice_number', $nomor);

        if (!$invoice) {
            $invoice = $this->dummyInvoices()[0];
            $invoice['invoice_number'] = $nomor;
        }

        return view('member.invoice.show', compact('invoice'));
    }

    /**
     * Halaman notifikasi member.
     */
    public function notifikasi(): View
    {
        $notifications = [
            [
                'title' => 'Tagihan Baru',
                'message' => 'Tagihan untuk Kos Putri Melati bulan ini telah terbit. Segera lakukan pembayaran.',
                'time' => '2 jam yang lalu',
                'is_read' => false,
                'icon' => 'fa-file-invoice text-danger',
            ],
            [
                'title' => 'Pengingat Pembayaran',
                'message' => 'Jatuh tempo pembayaran tagihan Kos Putri Melati adalah 3 hari lagi.',
                'time' => '1 hari yang lalu',
                'is_read' => true,
                'icon' => 'fa-clock text-warning',
            ],
            [
                'title' => 'Booking Dikonfirmasi',
                'message' => 'Booking Anda untuk Kos Putri Melati telah dikonfirmasi oleh pemilik.',
                'time' => '3 hari yang lalu',
                'is_read' => true,
                'icon' => 'fa-check text-success',
            ],
        ];

        return view('member.notifikasi.index', compact('notifications'));
    }
}
