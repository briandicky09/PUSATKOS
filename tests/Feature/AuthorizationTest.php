<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $ownerA;
    protected User $ownerB;
    protected User $customer;
    protected Kos $kosA;
    protected Kos $kosB;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Setup User Owner A
        $this->ownerA = User::create([
            'name' => 'Owner Alpha',
            'email' => 'owner_a_' . uniqid() . '@example.com',
            'phone' => '081200000001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        // 2. Setup User Owner B
        $this->ownerB = User::create([
            'name' => 'Owner Beta',
            'email' => 'owner_b_' . uniqid() . '@example.com',
            'phone' => '081200000002',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        // 3. Setup User Customer
        $this->customer = User::create([
            'name' => 'Customer Charlie',
            'email' => 'customer_' . uniqid() . '@example.com',
            'phone' => '081200000003',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // 4. Setup Kos milik Owner A
        $this->kosA = Kos::create([
            'owner_id' => $this->ownerA->id,
            'title' => 'Kos Melati Alpha',
            'slug' => 'kos-melati-alpha-' . uniqid(),
            'description' => 'Kos nyaman milik Owner A.',
            'price' => 850000.00,
            'type' => 'Putri',
            'city' => 'Surabaya',
            'address' => 'Jl. Alpha No. 1',
            'thumbnail' => 'assets/img/kos/1.png',
            'status' => 'active',
        ]);

        // 5. Setup Kos milik Owner B
        $this->kosB = Kos::create([
            'owner_id' => $this->ownerB->id,
            'title' => 'Kos Anggrek Beta',
            'slug' => 'kos-anggrek-beta-' . uniqid(),
            'description' => 'Kos strategis milik Owner B.',
            'price' => 750000.00,
            'type' => 'Putra',
            'city' => 'Malang',
            'address' => 'Jl. Beta No. 2',
            'thumbnail' => 'assets/img/kos/2.png',
            'status' => 'active',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | A. ROLE-BASED ACCESS CONTROL (PERIMETER & ROUTE PROTECTION)
    |--------------------------------------------------------------------------
    */

    /**
     * 1. Guest tidak boleh mengakses area /owner, harus diredirect ke login.
     */
    public function test_01_guest_cannot_access_owner_area(): void
    {
        $response = $this->get('/owner');
        $response->assertRedirect(route('login'));
    }

    /**
     * 2. Guest tidak boleh mengakses area /member, harus diredirect ke login.
     */
    public function test_02_guest_cannot_access_member_area(): void
    {
        $response = $this->get('/member');
        $response->assertRedirect(route('login'));
    }

    /**
     * 3. Customer boleh mengakses area /member.
     */
    public function test_03_customer_can_access_member_area(): void
    {
        $response = $this->actingAs($this->customer)->get('/member');
        $response->assertStatus(200);
    }

    /**
     * 4. Customer dilarang mengakses dashboard /owner (403 Forbidden).
     */
    public function test_04_customer_cannot_access_owner_dashboard(): void
    {
        $response = $this->actingAs($this->customer)->get('/owner');
        $response->assertForbidden();
    }

    /**
     * 5. Customer dilarang mengakses halaman form tambah kos owner (403 Forbidden).
     */
    public function test_05_customer_cannot_access_owner_kos_create_page(): void
    {
        $response = $this->actingAs($this->customer)->get('/owner/kos/create');
        $response->assertForbidden();
    }

    /**
     * 6. Customer dilarang mengirim request create kos (403 Forbidden).
     */
    public function test_06_customer_cannot_submit_kos_store(): void
    {
        $response = $this->actingAs($this->customer)->post('/owner/kos/store', [
            'title' => 'Kos Ilegal Customer',
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 500000,
        ]);
        $response->assertForbidden();
    }

    /**
     * 7. Owner boleh mengakses area /owner.
     */
    public function test_07_owner_can_access_owner_area(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner');
        $response->assertStatus(200);
    }

    /**
     * 8. Owner dilarang mengakses area /member (403 Forbidden).
     */
    public function test_08_owner_cannot_access_member_area(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/member');
        $response->assertForbidden();
    }

    /*
    |--------------------------------------------------------------------------
    | B. OWNERSHIP AUTHORIZATION & IDOR PREVENTION
    |--------------------------------------------------------------------------
    */

    /**
     * 9. Owner A hanya melihat kos miliknya di halaman Kos Saya (/owner/kos/my).
     */
    public function test_09_owner_only_sees_own_kos_in_list(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/my');
        $response->assertStatus(200);
        $response->assertSee($this->kosA->title);
        $response->assertDontSee($this->kosB->title);
    }

    /**
     * 10. Owner A dapat melihat detail kos miliknya.
     */
    public function test_10_owner_can_view_own_kos_detail(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug);
        $response->assertStatus(200);
        $response->assertSee($this->kosA->title);
    }

    /**
     * 11. Owner A DILARANG melihat detail kos milik Owner B via manipulasi slug (403 Forbidden).
     */
    public function test_11_owner_cannot_view_other_owner_kos_detail(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosB->slug);
        $response->assertForbidden();
    }

    /**
     * 12. Owner A dapat mengakses halaman edit kos miliknya.
     */
    public function test_12_owner_can_access_own_kos_edit_page(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug . '/edit');
        $response->assertStatus(200);
        $response->assertSee($this->kosA->title);
    }

    /**
     * 13. Owner A DILARANG mengakses halaman edit kos milik Owner B via slug (403 Forbidden).
     */
    public function test_13_owner_cannot_access_other_owner_kos_edit_page(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosB->slug . '/edit');
        $response->assertForbidden();
    }

    /**
     * 14. Owner A dapat mengupdate kos miliknya.
     */
    public function test_14_owner_can_update_own_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => 'Kos Melati Alpha Terupdate',
            'type' => 'Putri',
            'city' => 'Surabaya',
            'price' => 900000,
            'address' => 'Jl. Alpha No. 1 Updated',
            'description' => 'Fasilitas baru diperbarui.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('kos', [
            'id' => $this->kosA->id,
            'title' => 'Kos Melati Alpha Terupdate',
            'price' => 900000.00,
        ]);
    }

    /**
     * 15. Owner A DILARANG mengupdate kos milik Owner B (403 Forbidden).
     */
    public function test_15_owner_cannot_update_other_owner_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosB->slug . '/update', [
            'title' => 'Percobaan Pembajakan Kos B',
            'type' => 'Putra',
            'city' => 'Malang',
            'price' => 100000,
        ]);

        $response->assertForbidden();

        // Pastikan kos milik B tidak berubah di database
        $this->assertDatabaseMissing('kos', [
            'id' => $this->kosB->id,
            'title' => 'Percobaan Pembajakan Kos B',
        ]);
        $this->assertDatabaseHas('kos', [
            'id' => $this->kosB->id,
            'title' => 'Kos Anggrek Beta',
        ]);
    }

    /**
     * 16. Owner A dapat menghapus kos miliknya (Soft Delete).
     */
    public function test_16_owner_can_delete_own_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->delete('/owner/kos/' . $this->kosA->slug);

        $response->assertRedirect(route('owner.kos.my'));

        // Kos di-soft delete, bukan dihapus permanen
        $this->assertSoftDeleted('kos', [
            'id' => $this->kosA->id,
        ]);
    }

    /**
     * 17. Owner A DILARANG menghapus kos milik Owner B (403 Forbidden).
     */
    public function test_17_owner_cannot_delete_other_owner_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->delete('/owner/kos/' . $this->kosB->slug);

        $response->assertForbidden();

        // Kos milik B tidak terhapus
        $this->assertNotSoftDeleted('kos', [
            'id' => $this->kosB->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | C. SERVER-SIDE OWNER_ID & SPOOFING PREVENTION
    |--------------------------------------------------------------------------
    */

    /**
     * 18. Saat Owner membuat kos baru, owner_id otomatis diisi ID authenticated user.
     */
    public function test_18_owner_creates_kos_assigns_authenticated_owner_id(): void
    {
        $slug = 'kos-baru-alpha-' . uniqid();
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Baru Alpha',
            'slug' => $slug,
            'type' => 'Eksklusif',
            'city' => 'Surabaya',
            'price' => 1500000,
            'address' => 'Jl. Baru No. 10',
            'description' => 'Kos baru.',
        ]);

        $response->assertRedirect(route('owner.kos.my'));

        $this->assertDatabaseHas('kos', [
            'slug' => $slug,
            'owner_id' => $this->ownerA->id,
        ]);
    }

    /**
     * 19. Form create tidak boleh bisa memanipulasi owner_id ke owner lain.
     */
    public function test_19_owner_cannot_spoof_owner_id_on_create(): void
    {
        $slug = 'kos-spoof-' . uniqid();
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Coba Spoof',
            'slug' => $slug,
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 600000,
            'owner_id' => $this->ownerB->id, // Mencoba assign ke Owner B
        ]);

        $response->assertRedirect(route('owner.kos.my'));

        // Tetap harus tercatat sebagai milik Owner A (Auth::id()), BUKAN Owner B
        $this->assertDatabaseHas('kos', [
            'slug' => $slug,
            'owner_id' => $this->ownerA->id,
        ]);
        $this->assertDatabaseMissing('kos', [
            'slug' => $slug,
            'owner_id' => $this->ownerB->id,
        ]);
    }

    /**
     * 20. Form update tidak boleh bisa memindahkan kepemilikan kos ke owner lain.
     */
    public function test_20_owner_cannot_change_owner_id_on_update(): void
    {
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'owner_id' => $this->ownerB->id, // Mencoba memindahkan kepemilikan ke Owner B
        ]);

        $response->assertRedirect();

        // owner_id tetap milik Owner A
        $this->kosA->refresh();
        $this->assertEquals($this->ownerA->id, $this->kosA->owner_id);
    }

    /*
    |--------------------------------------------------------------------------
    | D. EDGE CASES & 404 HANDLING
    |--------------------------------------------------------------------------
    */

    /**
     * 21. Mengakses slug kos yang tidak ada di database mengembalikan 404, bukan 403.
     */
    public function test_21_nonexistent_kos_slug_returns_404_not_403(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/slug-kos-palsu-123456');
        $response->assertNotFound();
    }

    /**
     * 22. Mengakses kos yang sudah di-soft delete mengembalikan 404.
     */
    public function test_22_soft_deleted_kos_returns_404(): void
    {
        $this->kosA->delete();

        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug);
        $response->assertNotFound();
    }
}
