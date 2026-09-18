<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KosFacilityTest extends TestCase
{
    use DatabaseTransactions;

    protected User $ownerA;
    protected User $ownerB;
    protected User $customer;
    protected Facility $facilityWifi;
    protected Facility $facilityAc;
    protected Facility $facilityKasur;
    protected Kos $kosA;
    protected Kos $kosB;
    protected Kos $kosInactive;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup Users
        $this->ownerA = User::create([
            'name' => 'Owner Facility A',
            'email' => 'owner_fac_a_' . uniqid() . '@example.com',
            'phone' => '081244444444',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->ownerB = User::create([
            'name' => 'Owner Facility B',
            'email' => 'owner_fac_b_' . uniqid() . '@example.com',
            'phone' => '081255555555',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customer = User::create([
            'name' => 'Customer Facility',
            'email' => 'customer_fac_' . uniqid() . '@example.com',
            'phone' => '081266666666',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Ensure facilities exist
        $this->facilityWifi = Facility::firstOrCreate(
            ['name' => 'WiFi'],
            ['slug' => 'wifi']
        );
        $this->facilityAc = Facility::firstOrCreate(
            ['name' => 'AC'],
            ['slug' => 'ac']
        );
        $this->facilityKasur = Facility::firstOrCreate(
            ['name' => 'Kasur'],
            ['slug' => 'kasur']
        );

        // Setup Kos A with WiFi and AC
        $titleA = 'Kos Fasilitas A ' . uniqid();
        $this->kosA = Kos::create([
            'owner_id' => $this->ownerA->id,
            'title' => $titleA,
            'slug' => \Illuminate\Support\Str::slug($titleA),
            'description' => 'Kos dengan fasilitas WiFi dan AC.',
            'price' => 1000000.00,
            'type' => 'Putri',
            'city' => 'Surabaya',
            'address' => 'Jl. Fasilitas No. 1',
            'thumbnail' => 'assets/img/kos/1.png',
            'status' => 'active',
        ]);
        $this->kosA->facilities()->sync([$this->facilityWifi->id, $this->facilityAc->id]);

        // Setup Kos B milik Owner B
        $titleB = 'Kos Fasilitas B ' . uniqid();
        $this->kosB = Kos::create([
            'owner_id' => $this->ownerB->id,
            'title' => $titleB,
            'slug' => \Illuminate\Support\Str::slug($titleB),
            'description' => 'Kos milik Owner B.',
            'price' => 900000.00,
            'type' => 'Putra',
            'city' => 'Malang',
            'address' => 'Jl. Fasilitas No. 2',
            'thumbnail' => 'assets/img/kos/2.png',
            'status' => 'active',
        ]);
        $this->kosB->facilities()->sync([$this->facilityKasur->id]);

        // Setup Kos Inactive milik Owner A
        $titleInactive = 'Kos Inaktif Fasilitas ' . uniqid();
        $this->kosInactive = Kos::create([
            'owner_id' => $this->ownerA->id,
            'title' => $titleInactive,
            'slug' => \Illuminate\Support\Str::slug($titleInactive),
            'description' => 'Kos inaktif.',
            'price' => 800000.00,
            'type' => 'Campur',
            'city' => 'Sidoarjo',
            'address' => 'Jl. Fasilitas No. 3',
            'thumbnail' => 'assets/img/kos/3.png',
            'status' => 'inactive',
        ]);
        $this->kosInactive->facilities()->sync([$this->facilityWifi->id]);
    }

    /**
     * 1. Owner dapat melihat daftar fasilitas pada form create.
     */
    public function test_01_owner_can_see_facilities_list_on_create_form(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/create');

        $response->assertStatus(200);
        $response->assertSee('Fasilitas Kos');
        $response->assertSee('WiFi');
        $response->assertSee('AC');
        $response->assertSee('Kamar Mandi Dalam');
        $response->assertSee('Kasur');
        $response->assertSee('Listrik');
    }

    /**
     * 2. Owner dapat membuat Kos dengan beberapa fasilitas.
     * 3. Relasi fasilitas tersimpan di database.
     */
    public function test_02_owner_can_create_kos_with_facilities_and_persists_in_db(): void
    {
        $uniqueSlug = 'kos-baru-berfasilitas-' . uniqid();
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Baru Berfasilitas',
            'slug' => $uniqueSlug,
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 1250000,
            'address' => 'Jl. Baru No. 10',
            'description' => 'Kos lengkap dengan WiFi dan AC.',
            'facilities' => [$this->facilityWifi->id, $this->facilityAc->id],
        ]);

        $response->assertRedirect(route('owner.kos.my'));

        $createdKos = Kos::where('slug', $uniqueSlug)->first();
        $this->assertNotNull($createdKos);
        $this->assertEquals($this->ownerA->id, $createdKos->owner_id);

        $this->assertDatabaseHas('facility_kos', [
            'kos_id' => $createdKos->id,
            'facility_id' => $this->facilityWifi->id,
        ]);
        $this->assertDatabaseHas('facility_kos', [
            'kos_id' => $createdKos->id,
            'facility_id' => $this->facilityAc->id,
        ]);
        $this->assertDatabaseMissing('facility_kos', [
            'kos_id' => $createdKos->id,
            'facility_id' => $this->facilityKasur->id,
        ]);
    }

    /**
     * 4. Owner dapat melihat fasilitas pada detail Kos.
     */
    public function test_04_owner_can_see_facilities_on_kos_detail(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug);

        $response->assertStatus(200);
        $response->assertSee('Fasilitas Kos');
        $response->assertSee('WiFi');
        $response->assertSee('AC');
        $response->assertDontSee('Kasur');
    }

    /**
     * 4b. Tampilan pesan jika kos tidak memiliki fasilitas.
     */
    public function test_04b_owner_sees_empty_message_when_kos_has_no_facilities(): void
    {
        $kosNoFac = Kos::create([
            'owner_id' => $this->ownerA->id,
            'title' => 'Kos Tanpa Fasilitas ' . uniqid(),
            'slug' => 'kos-tanpa-fasilitas-' . uniqid(),
            'price' => 500000.00,
            'type' => 'Putra',
            'city' => 'Gresik',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $kosNoFac->slug);

        $response->assertStatus(200);
        $response->assertSee('Belum ada fasilitas yang ditambahkan.');
    }

    /**
     * 5. Owner dapat membuka form edit dan fasilitas sebelumnya otomatis ter-check.
     */
    public function test_05_owner_can_open_edit_form_and_see_checked_facilities(): void
    {
        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug . '/edit');

        $response->assertStatus(200);
        $response->assertSee('value="' . $this->facilityWifi->id . '"', false);
        $response->assertSee('value="' . $this->facilityAc->id . '"', false);

        // Pastikan checkbox ter-check untuk WiFi dan AC
        $content = $response->getContent();
        $this->assertMatchesRegularExpression('/id="facility-' . $this->facilityWifi->id . '"[^>]*checked/', $content);
        $this->assertMatchesRegularExpression('/id="facility-' . $this->facilityAc->id . '"[^>]*checked/', $content);
    }

    /**
     * 6. Owner dapat menambah fasilitas saat update.
     */
    public function test_06_owner_can_add_facilities_on_update(): void
    {
        // KosA awalnya hanya punya WiFi dan AC, sekarang ditambah Kasur
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'facilities' => [$this->facilityWifi->id, $this->facilityAc->id, $this->facilityKasur->id],
        ]);

        $response->assertRedirect(route('owner.kos.show', $this->kosA->slug));

        $this->assertDatabaseHas('facility_kos', [
            'kos_id' => $this->kosA->id,
            'facility_id' => $this->facilityWifi->id,
        ]);
        $this->assertDatabaseHas('facility_kos', [
            'kos_id' => $this->kosA->id,
            'facility_id' => $this->facilityAc->id,
        ]);
        $this->assertDatabaseHas('facility_kos', [
            'kos_id' => $this->kosA->id,
            'facility_id' => $this->facilityKasur->id,
        ]);
    }

    /**
     * 7. Owner dapat menghapus fasilitas saat update.
     * 8. Update fasilitas menggunakan sync berjalan dengan benar.
     */
    public function test_07_08_owner_can_remove_facility_and_sync_properly(): void
    {
        // KosA awalnya WiFi & AC. Sekarang hanya simpan WiFi (menghapus AC)
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'facilities' => [$this->facilityWifi->id],
        ]);

        $response->assertRedirect(route('owner.kos.show', $this->kosA->slug));

        $this->assertDatabaseHas('facility_kos', [
            'kos_id' => $this->kosA->id,
            'facility_id' => $this->facilityWifi->id,
        ]);
        $this->assertDatabaseMissing('facility_kos', [
            'kos_id' => $this->kosA->id,
            'facility_id' => $this->facilityAc->id,
        ]);
    }

    /**
     * 8b. Owner dapat mengosongkan seluruh fasilitas saat update.
     */
    public function test_08b_owner_can_clear_all_facilities_on_update(): void
    {
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'facilities' => [],
        ]);

        $response->assertRedirect(route('owner.kos.show', $this->kosA->slug));

        $this->assertEquals(0, $this->kosA->facilities()->count());
    }

    /**
     * 9. Customer tidak dapat melakukan CRUD fasilitas / Kos.
     */
    public function test_09_customer_cannot_crud_kos_facilities(): void
    {
        // Customer tidak boleh buka create
        $responseCreate = $this->actingAs($this->customer)->get('/owner/kos/create');
        $responseCreate->assertStatus(403);

        // Customer tidak boleh store
        $responseStore = $this->actingAs($this->customer)->post('/owner/kos/store', [
            'title' => 'Kos Ilegal Customer',
            'type' => 'Putra',
            'city' => 'Surabaya',
            'price' => 500000,
            'facilities' => [$this->facilityWifi->id],
        ]);
        $responseStore->assertStatus(403);

        // Customer tidak boleh edit kos
        $responseEdit = $this->actingAs($this->customer)->get('/owner/kos/' . $this->kosA->slug . '/edit');
        $responseEdit->assertStatus(403);

        // Customer tidak boleh update fasilitas kos
        $responseUpdate = $this->actingAs($this->customer)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'facilities' => [$this->facilityKasur->id],
        ]);
        $responseUpdate->assertStatus(403);
    }

    /**
     * 10. Owner A tidak dapat mengubah fasilitas Kos milik Owner B.
     */
    public function test_10_owner_a_cannot_update_facilities_of_owner_b_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosB->slug . '/update', [
            'title' => 'Pembajakan Kos B',
            'type' => $this->kosB->type,
            'city' => $this->kosB->city,
            'price' => $this->kosB->price,
            'facilities' => [$this->facilityWifi->id, $this->facilityAc->id],
        ]);

        $response->assertStatus(403);

        // Pastikan fasilitas Kos B tidak berubah
        $this->assertDatabaseHas('facility_kos', [
            'kos_id' => $this->kosB->id,
            'facility_id' => $this->facilityKasur->id,
        ]);
        $this->assertDatabaseMissing('facility_kos', [
            'kos_id' => $this->kosB->id,
            'facility_id' => $this->facilityAc->id,
        ]);
    }

    /**
     * 11. ID fasilitas yang tidak valid ditolak.
     */
    public function test_11_invalid_facility_id_is_rejected(): void
    {
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Invalid Facility',
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 700000,
            'facilities' => [999999], // ID yang tidak ada di tabel facilities
        ]);

        $response->assertSessionHasErrors('facilities.0');
    }

    /**
     * 12. Duplicate facility ID ditolak.
     */
    public function test_12_duplicate_facility_id_is_rejected(): void
    {
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Duplicate Facility',
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 700000,
            'facilities' => [$this->facilityWifi->id, $this->facilityWifi->id], // Duplikat
        ]);

        $response->assertSessionHasErrors('facilities.0');
    }

    /**
     * 13. Kos public & member tetap hanya menampilkan Kos active dan fasilitasnya dapat diakses.
     */
    public function test_13_public_and_member_can_view_active_kos_facilities(): void
    {
        // Public akses kos aktif
        $publicResponse = $this->get('/kos/' . $this->kosA->slug);
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('WiFi');
        $publicResponse->assertSee('AC');

        // Member akses kos aktif
        $memberResponse = $this->actingAs($this->customer)->get('/member/kos/' . $this->kosA->slug);
        $memberResponse->assertStatus(200);
        $memberResponse->assertSee('WiFi');
        $memberResponse->assertSee('AC');

        // Kos inaktif tidak boleh tampil (404)
        $publicInactive = $this->get('/kos/' . $this->kosInactive->slug);
        $publicInactive->assertStatus(404);

        $memberInactive = $this->actingAs($this->customer)->get('/member/kos/' . $this->kosInactive->slug);
        $memberInactive->assertStatus(404);
    }
}
