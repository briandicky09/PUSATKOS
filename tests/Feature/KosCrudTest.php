<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KosCrudTest extends TestCase
{
    use DatabaseTransactions;

    protected User $ownerA;
    protected User $ownerB;
    protected User $customer;
    protected Kos $kosA;
    protected Kos $kosB;
    protected Kos $kosInactive;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Setup User Owner A
        $this->ownerA = User::create([
            'name' => 'Owner Satu',
            'email' => 'owner_satu_' . uniqid() . '@example.com',
            'phone' => '081211111111',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        // 2. Setup User Owner B
        $this->ownerB = User::create([
            'name' => 'Owner Dua',
            'email' => 'owner_dua_' . uniqid() . '@example.com',
            'phone' => '081222222222',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        // 3. Setup User Customer
        $this->customer = User::create([
            'name' => 'Customer Tiga',
            'email' => 'customer_tiga_' . uniqid() . '@example.com',
            'phone' => '081233333333',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // 4. Setup Kos Aktif milik Owner A
        $this->kosA = Kos::create([
            'owner_id' => $this->ownerA->id,
            'title' => 'Kos Melati Satu',
            'slug' => 'kos-melati-satu-' . uniqid(),
            'description' => 'Kos nyaman dan bersih milik Owner A.',
            'price' => 850000.00,
            'type' => 'Putri',
            'city' => 'Surabaya',
            'address' => 'Jl. Melati No. 1',
            'thumbnail' => 'assets/img/kos/1.png',
            'status' => 'active',
        ]);

        // 5. Setup Kos Aktif milik Owner B
        $this->kosB = Kos::create([
            'owner_id' => $this->ownerB->id,
            'title' => 'Kos Anggrek Dua',
            'slug' => 'kos-anggrek-dua-' . uniqid(),
            'description' => 'Kos tenang milik Owner B.',
            'price' => 750000.00,
            'type' => 'Putra',
            'city' => 'Malang',
            'address' => 'Jl. Anggrek No. 2',
            'thumbnail' => 'assets/img/kos/2.png',
            'status' => 'active',
        ]);

        // 6. Setup Kos Inactive milik Owner A
        $this->kosInactive = Kos::create([
            'owner_id' => $this->ownerA->id,
            'title' => 'Kos Mawar Nonaktif',
            'slug' => 'kos-mawar-nonaktif-' . uniqid(),
            'description' => 'Kos sedang renovasi.',
            'price' => 1200000.00,
            'type' => 'Campur',
            'city' => 'Sidoarjo',
            'address' => 'Jl. Mawar No. 3',
            'thumbnail' => 'assets/img/kos/3.png',
            'status' => 'inactive',
        ]);
    }

    /**
     * 1. Owner dapat membuka halaman create.
     */
    public function test_01_owner_can_open_create_page(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/create');
        $response->assertStatus(200);
        $response->assertSee('Tambah Kos Baru');
    }

    /**
     * 2. Owner dapat membuat Kos.
     */
    public function test_02_owner_can_create_kos(): void
    {
        $uniqueSlug = 'kos-indah-baru-' . uniqid();
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Indah Baru',
            'slug' => $uniqueSlug,
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 950000,
            'address' => 'Jl. Indah No. 5',
            'description' => 'Kos baru yang strategis.',
        ]);

        $response->assertRedirect(route('owner.kos.my'));
        $this->assertDatabaseHas('kos', [
            'slug' => $uniqueSlug,
            'owner_id' => $this->ownerA->id,
            'status' => 'active',
        ]);
    }

    /**
     * 3. owner_id otomatis sesuai authenticated user (tidak dapat dispoof).
     */
    public function test_03_owner_id_automatically_assigned_to_authenticated_user(): void
    {
        $uniqueSlug = 'kos-spoof-attempt-' . uniqid();
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Anti Spoof',
            'slug' => $uniqueSlug,
            'type' => 'Putra',
            'city' => 'Surabaya',
            'price' => 800000,
            'owner_id' => $this->ownerB->id, // Mencoba memanipulasi owner_id
        ]);

        $response->assertRedirect(route('owner.kos.my'));
        $this->assertDatabaseHas('kos', [
            'slug' => $uniqueSlug,
            'owner_id' => $this->ownerA->id,
        ]);
        $this->assertDatabaseMissing('kos', [
            'slug' => $uniqueSlug,
            'owner_id' => $this->ownerB->id,
        ]);
    }

    /**
     * 4. Owner dapat melihat Kos miliknya di daftar kos.
     */
    public function test_04_owner_can_view_own_kos_in_list(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/my');
        $response->assertStatus(200);
        $response->assertSee($this->kosA->title);
        $response->assertDontSee($this->kosB->title);
    }

    /**
     * 5. Owner dapat membuka detail Kos miliknya.
     */
    public function test_05_owner_can_open_own_kos_detail(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug);
        $response->assertStatus(200);
        $response->assertSee($this->kosA->title);
        $response->assertSee($this->kosA->city);
    }

    /**
     * 6. Owner dapat membuka form edit Kos miliknya.
     */
    public function test_06_owner_can_open_own_kos_edit_page(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug . '/edit');
        $response->assertStatus(200);
        $response->assertSee('Edit Kos');
        $response->assertSee($this->kosA->title);
    }

    /**
     * 7. Owner dapat update Kos miliknya.
     */
    public function test_07_owner_can_update_own_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => 'Kos Melati Satu Renovasi',
            'type' => 'Putri',
            'city' => 'Surabaya',
            'price' => 900000,
            'address' => 'Jl. Melati No. 1 Updated',
            'description' => 'Fasilitas baru ditambahkan.',
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('kos', [
            'id' => $this->kosA->id,
            'title' => 'Kos Melati Satu Renovasi',
            'price' => 900000.00,
        ]);
    }

    /**
     * 8. Owner dapat soft delete Kos miliknya.
     */
    public function test_08_owner_can_soft_delete_own_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->delete('/owner/kos/' . $this->kosA->slug);
        $response->assertRedirect(route('owner.kos.my'));

        $this->assertSoftDeleted('kos', [
            'id' => $this->kosA->id,
        ]);
    }

    /**
     * 9. Kos yang dihapus tidak muncul pada daftar normal.
     */
    public function test_09_soft_deleted_kos_does_not_appear_in_normal_lists(): void
    {
        $this->kosA->delete();

        // Tidak muncul di daftar Owner
        $responseOwner = $this->actingAs($this->ownerA)->get('/owner/kos/my');
        $responseOwner->assertStatus(200);
        $responseOwner->assertDontSee($this->kosA->title);

        // Tidak muncul di daftar publik
        $responsePublic = $this->get('/kos');
        $responsePublic->assertStatus(200);
        $responsePublic->assertDontSee($this->kosA->title);
    }

    /**
     * 10. Owner tidak dapat mengakses Kos Owner lain (403).
     */
    public function test_10_owner_cannot_access_other_owner_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosB->slug);
        $response->assertForbidden();
    }

    /**
     * 11. Owner tidak dapat update Kos Owner lain (403).
     */
    public function test_11_owner_cannot_update_other_owner_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosB->slug . '/update', [
            'title' => 'Upaya Pembajakan Kos B',
            'type' => 'Putra',
            'city' => 'Malang',
            'price' => 500000,
        ]);

        $response->assertForbidden();
    }

    /**
     * 12. Owner tidak dapat delete Kos Owner lain (403).
     */
    public function test_12_owner_cannot_delete_other_owner_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->delete('/owner/kos/' . $this->kosB->slug);
        $response->assertForbidden();

        $this->assertDatabaseHas('kos', [
            'id' => $this->kosB->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * 13. Customer tidak dapat CRUD Kos (403).
     */
    public function test_13_customer_cannot_crud_kos(): void
    {
        // Customer tidak boleh buka create
        $this->actingAs($this->customer)->get('/owner/kos/create')->assertForbidden();

        // Customer tidak boleh post store
        $this->actingAs($this->customer)->post('/owner/kos/store', [
            'title' => 'Kos Ilegal Customer',
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 500000,
        ])->assertForbidden();

        // Customer tidak boleh edit
        $this->actingAs($this->customer)->get('/owner/kos/' . $this->kosA->slug . '/edit')->assertForbidden();

        // Customer tidak boleh update
        $this->actingAs($this->customer)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => 'Update Ilegal Customer',
            'type' => 'Putri',
            'city' => 'Surabaya',
            'price' => 500000,
        ])->assertForbidden();

        // Customer tidak boleh delete
        $this->actingAs($this->customer)->delete('/owner/kos/' . $this->kosA->slug)->assertForbidden();
    }

    /**
     * 14. Guest tidak dapat masuk area Owner (redirect ke login).
     */
    public function test_14_guest_cannot_access_owner_area(): void
    {
        $this->get('/owner')->assertRedirect(route('login'));
        $this->get('/owner/kos/create')->assertRedirect(route('login'));
        $this->get('/owner/kos/my')->assertRedirect(route('login'));
        $this->get('/owner/kos/' . $this->kosA->slug)->assertRedirect(route('login'));
    }

    /**
     * 15. Public hanya melihat Kos active.
     */
    public function test_15_public_only_sees_active_kos(): void
    {
        $response = $this->get('/kos');
        $response->assertStatus(200);
        $response->assertSee($this->kosA->title);
        $response->assertSee($this->kosB->title);
        $response->assertDontSee($this->kosInactive->title);
    }

    /**
     * 16. Kos inactive tidak muncul di public.
     */
    public function test_16_inactive_kos_does_not_appear_in_public_and_returns_404(): void
    {
        // Di daftar index publik tidak muncul
        $responseIndex = $this->get('/kos');
        $responseIndex->assertDontSee($this->kosInactive->title);

        // Akses detail publik mengembalikan 404
        $responseShow = $this->get('/kos/' . $this->kosInactive->slug);
        $responseShow->assertNotFound();
    }

    /**
     * 17. Slug tidak ditemukan menghasilkan 404.
     */
    public function test_17_nonexistent_slug_returns_404(): void
    {
        $this->get('/kos/slug-kos-yang-pasti-tidak-ada-9999')->assertNotFound();
        $this->actingAs($this->ownerA)->get('/owner/kos/slug-kos-yang-pasti-tidak-ada-9999')->assertNotFound();
    }

    /**
     * 18. Soft-deleted Kos tidak dapat diakses melalui route normal.
     */
    public function test_18_soft_deleted_kos_cannot_be_accessed_via_normal_routes(): void
    {
        $this->kosA->delete();

        // Route publik mengembalikan 404
        $this->get('/kos/' . $this->kosA->slug)->assertNotFound();

        // Route owner mengembalikan 404
        $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug)->assertNotFound();
        $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug . '/edit')->assertNotFound();
    }

    /**
     * 19. Upload file thumbnail berfungsi dan disimpan di storage.
     */
    public function test_19_thumbnail_upload_works_and_persists(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('thumbnail_kos.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Dengan Foto',
            'type' => 'Eksklusif',
            'city' => 'Surabaya',
            'price' => 1200000,
            'thumbnail' => $file,
        ]);

        $response->assertRedirect(route('owner.kos.my'));

        $kos = Kos::where('title', 'Kos Dengan Foto')->latest()->first();
        $this->assertNotNull($kos);
        $this->assertStringStartsWith('storage/kos/', $kos->thumbnail);

        $storedPath = str_replace('storage/', '', $kos->thumbnail);
        Storage::disk('public')->assertExists($storedPath);
    }

    /**
     * 20. Auto-slug unik saat input slug kosong dan penanganan duplicate slug.
     */
    public function test_20_auto_slug_creation_and_duplicate_slug_handling(): void
    {
        // Buat kos pertama tanpa input slug
        $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Bunga Melati',
            'type' => 'Putri',
            'city' => 'Surabaya',
            'price' => 800000,
        ]);

        $kos1 = Kos::where('title', 'Kos Bunga Melati')->first();
        $this->assertEquals('kos-bunga-melati', $kos1->slug);

        // Buat kos kedua dengan judul sama tanpa input slug
        $this->actingAs($this->ownerB)->post('/owner/kos/store', [
            'title' => 'Kos Bunga Melati',
            'type' => 'Putri',
            'city' => 'Surabaya',
            'price' => 850000,
        ]);

        $kos2 = Kos::where('title', 'Kos Bunga Melati')->latest('id')->first();
        $this->assertEquals('kos-bunga-melati-1', $kos2->slug);
    }

    /**
     * 21. Owner dapat mengelola kos miliknya meskipun berstatus inactive.
     */
    public function test_21_owner_can_manage_own_inactive_kos(): void
    {
        // Owner dapat melihat kos inactive miliknya di detail
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosInactive->slug);
        $response->assertStatus(200);
        $response->assertSee($this->kosInactive->title);

        // Owner dapat mengupdate kos inactive miliknya menjadi active
        $responseUpdate = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosInactive->slug . '/update', [
            'title' => $this->kosInactive->title,
            'type' => $this->kosInactive->type,
            'city' => $this->kosInactive->city,
            'price' => $this->kosInactive->price,
            'status' => 'active',
        ]);

        $responseUpdate->assertRedirect();
        $this->kosInactive->refresh();
        $this->assertEquals('active', $this->kosInactive->status);
    }

    /**
     * 22. Member dapat melihat kos aktif dan detailnya, tetapi tidak dapat membuka kos inactive/deleted.
     */
    public function test_22_member_can_view_active_kos_but_not_inactive_or_deleted(): void
    {
        // Member melihat daftar kos aktif
        $responseMember = $this->actingAs($this->customer)->get('/member/kos');
        $responseMember->assertStatus(200);
        $responseMember->assertSee($this->kosA->title);
        $responseMember->assertDontSee($this->kosInactive->title);

        // Member melihat detail kos aktif
        $responseShowActive = $this->actingAs($this->customer)->get('/member/kos/' . $this->kosA->slug);
        $responseShowActive->assertStatus(200);
        $responseShowActive->assertSee($this->kosA->title);

        // Member mencoba membuka kos inactive -> 404
        $responseShowInactive = $this->actingAs($this->customer)->get('/member/kos/' . $this->kosInactive->slug);
        $responseShowInactive->assertNotFound();

        // Member mencoba membuka booking kos inactive -> 404
        $responseBookingInactive = $this->actingAs($this->customer)->get('/member/booking/' . $this->kosInactive->slug);
        $responseBookingInactive->assertNotFound();
    }

    /**
     * 23. Filter pencarian kos publik (keyword, kota, tipe, harga maksimal).
     */
    public function test_23_public_search_filters_work(): void
    {
        // Filter kota Surabaya
        $resCity = $this->get('/kos?city=Surabaya');
        $resCity->assertStatus(200);
        $resCity->assertSee($this->kosA->title);
        $resCity->assertDontSee($this->kosB->title);

        // Filter tipe Putra
        $resType = $this->get('/kos?type=Putra');
        $resType->assertStatus(200);
        $resType->assertSee($this->kosB->title);
        $resType->assertDontSee($this->kosA->title);

        // Filter max_price 800000 (kosA 850.000 tidak muncul, kosB 750.000 muncul)
        $resPrice = $this->get('/kos?max_price=800000');
        $resPrice->assertStatus(200);
        $resPrice->assertSee($this->kosB->title);
        $resPrice->assertDontSee($this->kosA->title);
    }
}
