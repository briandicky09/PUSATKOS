<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use DatabaseTransactions;

    protected User $owner;
    protected User $customerA;
    protected User $customerB;
    protected Kos $kosActive;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Invoice Test',
            'email' => 'owner_inv_' . uniqid() . '@example.com',
            'phone' => '081299991001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customerA = User::create([
            'name' => 'Customer A Inv',
            'email' => 'customer_inv_a_' . uniqid() . '@example.com',
            'phone' => '081299991002',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->customerB = User::create([
            'name' => 'Customer B Inv',
            'email' => 'customer_inv_b_' . uniqid() . '@example.com',
            'phone' => '081299991003',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->kosActive = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Melati Invoice Test',
            'slug' => 'kos-melati-inv-' . uniqid(),
            'description' => 'Kos aktif untuk pengujian invoice.',
            'price' => 850000.00,
            'type' => 'Putri',
            'city' => 'Surabaya',
            'address' => 'Jl. Melati No. 12',
            'thumbnail' => 'assets/img/kos/1.png',
            'status' => 'active',
        ]);
    }

    /**
     * Helper untuk membuat booking sukses melalui request HTTP.
     */
    protected function makeBooking(User $customer, array $overrides = []): Booking
    {
        $payload = array_merge([
            'tenant_name' => 'Penyewa ' . $customer->name,
            'tenant_phone' => '081234567890',
            'tenant_email' => $customer->email,
            'start_date' => now()->addDays(3)->format('Y-m-d'),
            'duration_months' => 2,
            'notes' => 'Catatan booking invoice test',
        ], $overrides);

        $response = $this->actingAs($customer)
            ->post('/member/booking/' . $this->kosActive->slug, $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        return Booking::where('customer_id', $customer->id)
            ->where('kos_id', $this->kosActive->id)
            ->latest('id')
            ->firstOrFail();
    }

    /**
     * 1. Customer dapat melihat halaman daftar invoice.
     */
    public function test_01_customer_can_see_invoice_page(): void
    {
        $response = $this->actingAs($this->customerA)->get(route('member.invoice.index'));

        $response->assertStatus(200);
        $response->assertSee('Invoice Saya');
    }

    /**
     * 2. Invoice otomatis dibuat ketika booking berhasil.
     */
    public function test_02_invoice_automatically_created_when_booking_succeeds(): void
    {
        $booking = $this->makeBooking($this->customerA);

        $this->assertDatabaseHas('invoices', [
            'booking_id' => $booking->id,
            'customer_id' => $this->customerA->id,
            'kos_id' => $this->kosActive->id,
            'status' => 'unpaid',
        ]);
    }

    /**
     * 3. Invoice memiliki booking_id yang benar.
     */
    public function test_03_invoice_has_correct_booking_id(): void
    {
        $booking = $this->makeBooking($this->customerA);

        $invoice = Invoice::where('booking_id', $booking->id)->first();

        $this->assertNotNull($invoice);
        $this->assertEquals($booking->id, $invoice->booking_id);
    }

    /**
     * 4. Invoice memiliki customer_id dari authenticated user.
     */
    public function test_04_invoice_has_customer_id_from_authenticated_user(): void
    {
        // Mencoba mengirim customer_id milik customer lain via payload
        $booking = $this->makeBooking($this->customerA, [
            'customer_id' => $this->customerB->id,
        ]);

        $invoice = Invoice::where('booking_id', $booking->id)->first();

        $this->assertNotNull($invoice);
        $this->assertEquals($this->customerA->id, $invoice->customer_id);
        $this->assertNotEquals($this->customerB->id, $invoice->customer_id);
    }

    /**
     * 5. Invoice mengambil nominal dari booking.
     */
    public function test_05_invoice_takes_amount_from_booking(): void
    {
        $booking = $this->makeBooking($this->customerA, [
            'duration_months' => 3,
        ]);

        $invoice = Invoice::where('booking_id', $booking->id)->firstOrFail();

        $this->assertEquals((float) $booking->subtotal, (float) $invoice->amount);
        $this->assertEquals((float) $booking->admin_fee, (float) $invoice->admin_fee);
        $this->assertEquals((float) $booking->total_amount, (float) $invoice->total_amount);
    }

    /**
     * 6. Invoice memiliki status unpaid saat pertama dibuat.
     */
    public function test_06_invoice_has_unpaid_status_when_created(): void
    {
        $booking = $this->makeBooking($this->customerA);

        $invoice = Invoice::where('booking_id', $booking->id)->firstOrFail();

        $this->assertEquals('unpaid', $invoice->status);
    }

    /**
     * 7. Nomor invoice dibuat otomatis oleh server.
     */
    public function test_07_invoice_number_generated_server_side(): void
    {
        $booking = $this->makeBooking($this->customerA);

        $invoice = Invoice::where('booking_id', $booking->id)->firstOrFail();

        $this->assertNotEmpty($invoice->invoice_number);
        $this->assertStringStartsWith('INV-' . now()->format('Ym') . '-', $invoice->invoice_number);
    }

    /**
     * 8. Nomor invoice unik antar invoice.
     */
    public function test_08_invoice_number_is_unique(): void
    {
        $booking1 = $this->makeBooking($this->customerA);
        $booking2 = $this->makeBooking($this->customerA);

        $invoice1 = Invoice::where('booking_id', $booking1->id)->firstOrFail();
        $invoice2 = Invoice::where('booking_id', $booking2->id)->firstOrFail();

        $this->assertNotEquals($invoice1->invoice_number, $invoice2->invoice_number);
    }

    /**
     * 9. Customer dapat melihat invoice miliknya.
     */
    public function test_09_customer_can_see_own_invoice(): void
    {
        $booking = $this->makeBooking($this->customerA);
        $invoice = Invoice::where('booking_id', $booking->id)->firstOrFail();

        $response = $this->actingAs($this->customerA)
            ->get(route('member.invoice.show', $invoice->invoice_number));

        $response->assertStatus(200);
        $response->assertSee($invoice->invoice_number);
        $response->assertSee($this->kosActive->title);
    }

    /**
     * 10. Customer tidak dapat melihat invoice customer lain (403 Forbidden).
     */
    public function test_10_customer_cannot_see_other_customer_invoice(): void
    {
        $bookingB = $this->makeBooking($this->customerB);
        $invoiceB = Invoice::where('booking_id', $bookingB->id)->firstOrFail();

        // Customer A mencoba mengakses invoice milik Customer B
        $response = $this->actingAs($this->customerA)
            ->get(route('member.invoice.show', $invoiceB->invoice_number));

        $response->assertStatus(403);
    }

    /**
     * 11. Guest tidak dapat mengakses invoice.
     */
    public function test_11_guest_cannot_access_invoice(): void
    {
        $responseIndex = $this->get(route('member.invoice.index'));
        $responseIndex->assertRedirect(route('login'));

        $responseShow = $this->get('/member/invoice/INV-202609-0001');
        $responseShow->assertRedirect(route('login'));
    }

    /**
     * 12. Owner tidak dapat mengakses invoice member (403 Forbidden).
     */
    public function test_12_owner_cannot_access_member_invoice(): void
    {
        $responseIndex = $this->actingAs($this->owner)->get(route('member.invoice.index'));
        $responseIndex->assertStatus(403);

        $responseShow = $this->actingAs($this->owner)->get('/member/invoice/INV-202609-0001');
        $responseShow->assertStatus(403);
    }

    /**
     * 13. Invoice list tidak lagi menggunakan dummy data.
     */
    public function test_13_invoice_list_uses_database_data_not_dummy(): void
    {
        $booking = $this->makeBooking($this->customerA, [
            'tenant_name' => 'Nama Spesifik DB',
        ]);
        $invoice = Invoice::where('booking_id', $booking->id)->firstOrFail();

        $response = $this->actingAs($this->customerA)->get(route('member.invoice.index'));

        $response->assertStatus(200);
        $response->assertSee($invoice->invoice_number);
        // Memastikan data dummy lama (Dewi Sartika) tidak muncul
        $response->assertDontSee('Dewi Sartika');
    }

    /**
     * 14. Invoice detail mengambil data asli database.
     */
    public function test_14_invoice_detail_takes_real_database_data(): void
    {
        $booking = $this->makeBooking($this->customerA, [
            'tenant_name' => 'Rahmat Hidayat Asli',
            'tenant_phone' => '081288887777',
            'tenant_email' => 'rahmat_asli@example.com',
            'duration_months' => 2,
        ]);
        $invoice = Invoice::where('booking_id', $booking->id)->firstOrFail();

        $response = $this->actingAs($this->customerA)
            ->get(route('member.invoice.show', $invoice->invoice_number));

        $response->assertStatus(200);
        $response->assertSee($invoice->invoice_number);
        $response->assertSee('Rahmat Hidayat Asli');
        $response->assertSee('081288887777');
        $response->assertSee('rahmat_asli@example.com');
        $response->assertSee($this->kosActive->title);
        $response->assertSee($this->kosActive->address);
        $response->assertSee(number_format($invoice->total_amount, 0, ',', '.'));
    }

    /**
     * 15. Booking gagal tidak menghasilkan invoice (DB transaction rollback).
     */
    public function test_15_booking_failure_does_not_create_invoice(): void
    {
        $initialInvoiceCount = Invoice::count();

        // Mengirim request dengan data tidak valid (start_date lampau)
        $response = $this->actingAs($this->customerA)
            ->post('/member/booking/' . $this->kosActive->slug, [
                'tenant_name' => 'Gagal Booking',
                'tenant_phone' => '081234567890',
                'tenant_email' => 'gagal@example.com',
                'start_date' => now()->subDays(5)->format('Y-m-d'),
                'duration_months' => 1,
            ]);

        $response->assertSessionHasErrors(['start_date']);
        $this->assertEquals($initialInvoiceCount, Invoice::count());
    }

    /**
     * 16. Tidak terjadi duplicate invoice untuk satu booking.
     */
    public function test_16_duplicate_invoice_protection_for_single_booking(): void
    {
        $booking = $this->makeBooking($this->customerA);

        // Invoice pertama sudah terbentuk
        $this->assertEquals(1, Invoice::where('booking_id', $booking->id)->count());

        // Memanggil createFromBooking kembali pada booking yang sama harus ditolak
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invoice duplicate');

        Invoice::createFromBooking($booking);
    }

    /**
     * 17. Data invoice tetap konsisten dengan booking.
     */
    public function test_17_invoice_data_remains_consistent_with_booking(): void
    {
        $booking = $this->makeBooking($this->customerA, [
            'duration_months' => 4,
        ]);
        $invoice = Invoice::where('booking_id', $booking->id)->firstOrFail();

        $this->assertEquals($booking->subtotal, $invoice->amount);
        $this->assertEquals($booking->admin_fee, $invoice->admin_fee);
        $this->assertEquals($booking->total_amount, $invoice->total_amount);
        $this->assertEquals($booking->customer_id, $invoice->customer_id);
        $this->assertEquals($booking->kos_id, $invoice->kos_id);
    }

    /**
     * 18. Nomor invoice yang tidak ada mengembalikan 404 Not Found.
     */
    public function test_18_nonexistent_invoice_returns_404(): void
    {
        $response = $this->actingAs($this->customerA)
            ->get('/member/invoice/INV-999999-9999');

        $response->assertStatus(404);
    }
}
