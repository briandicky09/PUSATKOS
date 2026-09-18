<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\KosPhoto;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KosPhotoTest extends TestCase
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
        Storage::fake('public');

        // Setup Users
        $this->ownerA = User::create([
            'name' => 'Owner Photo A',
            'email' => 'owner_photo_a_' . uniqid() . '@example.com',
            'phone' => '081277777771',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->ownerB = User::create([
            'name' => 'Owner Photo B',
            'email' => 'owner_photo_b_' . uniqid() . '@example.com',
            'phone' => '081277777772',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customer = User::create([
            'name' => 'Customer Photo',
            'email' => 'customer_photo_' . uniqid() . '@example.com',
            'phone' => '081277777773',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Setup Kos A milik Owner A
        $titleA = 'Kos Galeri A ' . uniqid();
        $this->kosA = Kos::create([
            'owner_id' => $this->ownerA->id,
            'title' => $titleA,
            'slug' => \Illuminate\Support\Str::slug($titleA),
            'description' => 'Kos galeri milik Owner A.',
            'price' => 1100000.00,
            'type' => 'Putri',
            'city' => 'Surabaya',
            'address' => 'Jl. Galeri No. 1',
            'thumbnail' => 'assets/img/kos/1.png',
            'status' => 'active',
        ]);

        // Setup Kos B milik Owner B
        $titleB = 'Kos Galeri B ' . uniqid();
        $this->kosB = Kos::create([
            'owner_id' => $this->ownerB->id,
            'title' => $titleB,
            'slug' => \Illuminate\Support\Str::slug($titleB),
            'description' => 'Kos milik Owner B.',
            'price' => 950000.00,
            'type' => 'Putra',
            'city' => 'Malang',
            'address' => 'Jl. Galeri No. 2',
            'thumbnail' => 'assets/img/kos/2.png',
            'status' => 'active',
        ]);
    }

    /**
     * 1. Owner dapat membuat Kos tanpa foto galeri.
     */
    public function test_01_owner_can_create_kos_without_photos(): void
    {
        $uniqueSlug = 'kos-tanpa-foto-' . uniqid();
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Tanpa Foto',
            'slug' => $uniqueSlug,
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 800000,
        ]);

        $response->assertRedirect(route('owner.kos.my'));
        $createdKos = Kos::where('slug', $uniqueSlug)->first();
        $this->assertNotNull($createdKos);
        $this->assertEquals(0, $createdKos->photos()->count());
    }

    /**
     * 2. Owner dapat membuat Kos dengan banyak foto (multiple upload).
     * 3. Path foto yang tersimpan di DB relatif terhadap disk public (kos/photos/...).
     * 4. File benar-benar ada di storage public.
     * 5. Photos memiliki consecutive sort_order (1, 2, 3...).
     */
    public function test_02_owner_can_create_kos_with_multiple_photos_and_valid_sort_order(): void
    {
        $file1 = UploadedFile::fake()->create('kamar_tidur.jpg', 100, 'image/jpeg');
        $file2 = UploadedFile::fake()->create('kamar_mandi.png', 100, 'image/png');
        $file3 = UploadedFile::fake()->create('dapur.webp', 100, 'image/webp');

        $uniqueSlug = 'kos-banyak-foto-' . uniqid();
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Banyak Foto',
            'slug' => $uniqueSlug,
            'type' => 'Putri',
            'city' => 'Surabaya',
            'price' => 1200000,
            'photos' => [$file1, $file2, $file3],
        ]);

        $response->assertRedirect(route('owner.kos.my'));

        $createdKos = Kos::where('slug', $uniqueSlug)->first();
        $this->assertNotNull($createdKos);
        $photos = $createdKos->photos;
        $this->assertCount(3, $photos);

        // Verifikasi urutan sort_order dan format path
        $expectedSort = 1;
        foreach ($photos as $photo) {
            $this->assertEquals($expectedSort++, $photo->sort_order);

            // Path harus relatif terhadap disk public: 'kos/photos/...'
            $this->assertStringStartsWith('kos/photos/', $photo->photo_path);
            $this->assertStringNotContainsString('storage/', $photo->photo_path);

            // File fisik harus ada di storage public
            Storage::disk('public')->assertExists($photo->photo_path);

            // URL accessor harus valid
            $this->assertStringContainsString('storage/' . $photo->photo_path, $photo->url);
        }
    }

    /**
     * 6. Unique constraint: kombinasi kos_id + photo_path tidak boleh duplicate di DB.
     */
    public function test_06_unique_constraint_prevents_duplicate_kos_id_and_photo_path(): void
    {
        KosPhoto::create([
            'kos_id' => $this->kosA->id,
            'photo_path' => 'kos/photos/sample_unique.jpg',
            'sort_order' => 1,
        ]);

        $this->expectException(QueryException::class);

        // Duplikat kos_id + photo_path yang sama harus melempar QueryException
        KosPhoto::create([
            'kos_id' => $this->kosA->id,
            'photo_path' => 'kos/photos/sample_unique.jpg',
            'sort_order' => 2,
        ]);
    }

    /**
     * 7. Foto muncul pada halaman detail Owner.
     */
    public function test_07_photos_appear_on_owner_detail_page(): void
    {
        $photo = $this->kosA->photos()->create([
            'photo_path' => 'kos/photos/detail_test.jpg',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->ownerA)->get('/owner/kos/' . $this->kosA->slug);

        $response->assertStatus(200);
        $response->assertSee('Galeri Foto Kos');
        $response->assertSee($photo->url, false);
    }

    /**
     * 8. Foto muncul pada detail Public dan Member.
     */
    public function test_08_photos_appear_on_public_and_member_detail_page(): void
    {
        $photo1 = $this->kosA->photos()->create([
            'photo_path' => 'kos/photos/public_test_1.jpg',
            'sort_order' => 1,
        ]);
        $photo2 = $this->kosA->photos()->create([
            'photo_path' => 'kos/photos/public_test_2.jpg',
            'sort_order' => 2,
        ]);

        // Detail Publik
        $publicResponse = $this->get('/kos/' . $this->kosA->slug);
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee($photo1->url, false);
        $publicResponse->assertSee($photo2->url, false);

        // Detail Member
        $memberResponse = $this->actingAs($this->customer)->get('/member/kos/' . $this->kosA->slug);
        $memberResponse->assertStatus(200);
        $memberResponse->assertSee($photo1->url, false);
        $memberResponse->assertSee($photo2->url, false);
    }

    /**
     * 9. Galeri publik menggunakan fallback jika kos belum memiliki foto galeri.
     */
    public function test_09_public_gallery_uses_fallback_when_kos_has_no_photos(): void
    {
        $response = $this->get('/kos/' . $this->kosA->slug);
        $response->assertStatus(200);
        $response->assertSee('gallery-carousel');
    }

    /**
     * 10. Owner dapat menambahkan foto baru pada Edit (sort_order melanjutkan urutan terakhir).
     */
    public function test_10_owner_can_add_more_photos_on_edit_with_continued_sort_order(): void
    {
        // Buat 2 foto awal
        $this->kosA->photos()->create([
            'photo_path' => 'kos/photos/awal_1.jpg',
            'sort_order' => 1,
        ]);
        $this->kosA->photos()->create([
            'photo_path' => 'kos/photos/awal_2.jpg',
            'sort_order' => 2,
        ]);

        // Upload foto baru ke-3 dan ke-4 saat edit
        $newFile1 = UploadedFile::fake()->create('baru_3.jpg', 100, 'image/jpeg');
        $newFile2 = UploadedFile::fake()->create('baru_4.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'photos' => [$newFile1, $newFile2],
        ]);

        $response->assertRedirect(route('owner.kos.show', $this->kosA->slug));

        $photos = $this->kosA->fresh()->photos;
        $this->assertCount(4, $photos);

        $sortOrders = $photos->pluck('sort_order')->toArray();
        $this->assertEquals([1, 2, 3, 4], $sortOrders);
    }

    /**
     * 11. Owner dapat menghapus foto tertentu pada Edit, dan file fisik ikut terhapus dari storage.
     */
    public function test_11_owner_can_delete_specific_photo_and_physical_file_is_removed(): void
    {
        // Buat file palsu di disk public
        Storage::disk('public')->put('kos/photos/hapus_me.jpg', 'dummy content');
        Storage::disk('public')->put('kos/photos/tetap_ada.jpg', 'dummy content');

        $photoToDelete = $this->kosA->photos()->create([
            'photo_path' => 'kos/photos/hapus_me.jpg',
            'sort_order' => 1,
        ]);
        $photoToKeep = $this->kosA->photos()->create([
            'photo_path' => 'kos/photos/tetap_ada.jpg',
            'sort_order' => 2,
        ]);

        Storage::disk('public')->assertExists('kos/photos/hapus_me.jpg');
        Storage::disk('public')->assertExists('kos/photos/tetap_ada.jpg');

        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'delete_photos' => [$photoToDelete->id],
        ]);

        $response->assertRedirect(route('owner.kos.show', $this->kosA->slug));

        // Verifikasi DB
        $this->assertDatabaseMissing('kos_photos', ['id' => $photoToDelete->id]);
        $this->assertDatabaseHas('kos_photos', ['id' => $photoToKeep->id]);

        // Verifikasi file fisik: yang dihapus hilang, yang disimpan tetap ada
        Storage::disk('public')->assertMissing('kos/photos/hapus_me.jpg');
        Storage::disk('public')->assertExists('kos/photos/tetap_ada.jpg');
    }

    /**
     * 12. Owner A tidak dapat menghapus foto milik Kos Owner B (Anti-IDOR).
     */
    public function test_12_owner_a_cannot_delete_photo_belonging_to_owner_b_kos(): void
    {
        Storage::disk('public')->put('kos/photos/owner_b_secret.jpg', 'owner b content');

        $photoOwnerB = $this->kosB->photos()->create([
            'photo_path' => 'kos/photos/owner_b_secret.jpg',
            'sort_order' => 1,
        ]);

        // Owner A mencoba update Kos miliknya sendiri (kosA), tetapi menyusupkan ID foto milik kosB
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'delete_photos' => [$photoOwnerB->id],
        ]);

        $response->assertRedirect(route('owner.kos.show', $this->kosA->slug));

        // Foto milik Kos Owner B HARUS TETAP ADA di DB dan storage
        $this->assertDatabaseHas('kos_photos', ['id' => $photoOwnerB->id]);
        Storage::disk('public')->assertExists('kos/photos/owner_b_secret.jpg');
    }

    /**
     * 13. Owner A tidak dapat melakukan update pada Kos milik Owner B sama sekali (403).
     */
    public function test_13_owner_a_cannot_access_or_update_owner_b_kos(): void
    {
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosB->slug . '/update', [
            'title' => 'Pembajakan Kos B',
            'type' => $this->kosB->type,
            'city' => $this->kosB->city,
            'price' => $this->kosB->price,
        ]);

        $response->assertStatus(403);
    }

    /**
     * 14. Customer tidak dapat mengunggah atau menghapus foto kos (403).
     */
    public function test_14_customer_cannot_crud_kos_photos(): void
    {
        $file = UploadedFile::fake()->create('hack.jpg', 100, 'image/jpeg');

        $responseStore = $this->actingAs($this->customer)->post('/owner/kos/store', [
            'title' => 'Kos Ilegal',
            'type' => 'Putra',
            'city' => 'Surabaya',
            'price' => 500000,
            'photos' => [$file],
        ]);
        $responseStore->assertStatus(403);

        $responseUpdate = $this->actingAs($this->customer)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'photos' => [$file],
        ]);
        $responseUpdate->assertStatus(403);
    }

    /**
     * 15. File bukan gambar ditolak oleh validasi.
     */
    public function test_15_non_image_file_is_rejected(): void
    {
        $fakePdf = UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf');

        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Invalid Photo',
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 700000,
            'photos' => [$fakePdf],
        ]);

        $response->assertSessionHasErrors('photos.0');
    }

    /**
     * 15b. Format gambar yang tidak didukung (misal: GIF) ditolak oleh validasi mimes.
     */
    public function test_15b_unsupported_image_format_is_rejected(): void
    {
        $fakeGif = UploadedFile::fake()->create('animasi.gif', 100, 'image/gif');

        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Invalid Format Photo',
            'type' => 'Campur',
            'city' => 'Surabaya',
            'price' => 700000,
            'photos' => [$fakeGif],
        ]);

        $response->assertSessionHasErrors('photos.0');
    }

    /**
     * 15c. ID foto yang tidak ada di tabel kos_photos ditolak pada delete_photos.
     */
    public function test_15c_nonexistent_photo_id_in_delete_photos_is_rejected(): void
    {
        $response = $this->actingAs($this->ownerA)->put('/owner/kos/' . $this->kosA->slug . '/update', [
            'title' => $this->kosA->title,
            'type' => $this->kosA->type,
            'city' => $this->kosA->city,
            'price' => $this->kosA->price,
            'delete_photos' => [999999],
        ]);

        $response->assertSessionHasErrors('delete_photos.0');
    }

    /**
     * 16. Existing thumbnail tetap berfungsi dan terpisah dari foto galeri.
     */
    public function test_16_existing_thumbnail_remains_functional_and_separate_from_gallery(): void
    {
        $thumbFile = UploadedFile::fake()->create('thumbnail.jpg', 100, 'image/jpeg');
        $galleryFile = UploadedFile::fake()->create('gallery.jpg', 100, 'image/jpeg');

        $uniqueSlug = 'kos-thumb-and-gallery-' . uniqid();
        $response = $this->actingAs($this->ownerA)->post('/owner/kos/store', [
            'title' => 'Kos Thumb & Galeri',
            'slug' => $uniqueSlug,
            'type' => 'Putra',
            'city' => 'Surabaya',
            'price' => 900000,
            'thumbnail' => $thumbFile,
            'photos' => [$galleryFile],
        ]);

        $response->assertRedirect(route('owner.kos.my'));

        $createdKos = Kos::where('slug', $uniqueSlug)->first();
        $this->assertNotNull($createdKos);

        // Thumbnail tersimpan dengan format existing: 'storage/kos/...'
        $this->assertStringStartsWith('storage/kos/', $createdKos->getRawOriginal('thumbnail'));

        // Galeri foto tersimpan dengan format 'kos/photos/...'
        $photo = $createdKos->photos()->first();
        $this->assertNotNull($photo);
        $this->assertStringStartsWith('kos/photos/', $photo->photo_path);
    }
}
