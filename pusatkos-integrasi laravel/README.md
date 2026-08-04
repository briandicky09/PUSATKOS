# PUSATKOS - Laravel 12

Hasil konversi template frontend **PUSATKOS-LandingPage-part3** menjadi struktur project **Laravel 12** (Blade + Bootstrap bawaan template), tanpa mengubah desain.

## Isi project ini

Project ini berisi bagian-bagian yang **spesifik untuk PUSATKOS** (hasil konversi):

- `app/Http/Controllers/` — HomeController, AuthController, OwnerKosController, CustomerKosController
- `app/Models/` — Kos, Invoice, User
- `routes/web.php` — semua route sesuai spesifikasi
- `resources/views/` — seluruh layout, partial, dan halaman Blade
- `public/assets/` — seluruh CSS, JS, font, gambar dari template ZIP asli (tidak diubah)
- `composer.json`, `artisan`, `bootstrap/app.php`, `bootstrap/providers.php`, `public/index.php`, `.env.example` — kerangka dasar Laravel 12

Karena project ini dibangun manual di lingkungan tanpa akses ke Packagist/Composer, file-file **skeleton standar Laravel** (folder `config/*.php` selain `app.php`, `database/migrations` bawaan, `tests/`, dsb) **belum disertakan**. File-file itu identik di semua project Laravel 12 baru dan paling aman diambil dari installer resmi Laravel, seperti langkah di bawah.

## Cara menjalankan

### 1. Buat skeleton Laravel 12 resmi di folder terpisah

```bash
composer create-project laravel/laravel:^12.0 pusatkos-fresh
```

### 2. Salin folder project ini ke atas skeleton tersebut

Salin (timpa) folder-folder berikut dari project **pusatkos-laravel** (hasil konversi ini) ke dalam `pusatkos-fresh`:

```
app/Http/Controllers/
app/Models/
routes/web.php
resources/views/
public/assets/
```

Contoh (dari dalam folder pusatkos-fresh):

```bash
cp -r ../pusatkos-laravel/app/Http/Controllers/* app/Http/Controllers/
cp -r ../pusatkos-laravel/app/Models/* app/Models/
cp ../pusatkos-laravel/routes/web.php routes/web.php
rm -rf resources/views && cp -r ../pusatkos-laravel/resources/views resources/views
cp -r ../pusatkos-laravel/public/assets public/assets
```

### 3. Install dependency & jalankan

```bash
composer install
php artisan key:generate
php artisan serve
```

Buka `http://localhost:8000`.

> Jika Anda sudah punya Laravel 12 terinstall dan hanya ingin lihat isi konversinya, seluruh logika ada di `app/`, `routes/web.php`, dan `resources/views/` — cukup salin ketiga folder itu.

## Struktur Route

| Method | URI                      | Nama Route             | Controller                          |
|--------|---------------------------|-------------------------|--------------------------------------|
| GET    | `/`                        | `home`                  | HomeController@index                 |
| GET    | `/login`                   | `login`                 | AuthController@showLogin             |
| GET    | `/register`                | `register`               | AuthController@showRegister          |
| GET    | `/owner/kos`                | `owner.kos.index`        | OwnerKosController@index             |
| GET    | `/owner/kos/create`          | `owner.kos.create`       | OwnerKosController@create            |
| GET    | `/owner/kos/{slug}`          | `owner.kos.show`         | OwnerKosController@show              |
| GET    | `/customer/kos`              | `customer.kos.index`     | CustomerKosController@index          |
| GET    | `/customer/invoice`          | `customer.invoice.index` | CustomerKosController@invoice        |

## Mapping halaman template → Blade

| Template ZIP     | Blade View                              | Route                    |
|-------------------|-------------------------------------------|----------------------------|
| `index.html`       | `resources/views/home/index.blade.php`     | `home`                     |
| `login.html`        | `resources/views/auth/login.blade.php`      | `login`                    |
| `register.html`      | `resources/views/auth/register.blade.php`    | `register`                 |
| `search.html`         | `resources/views/owner/kos/index.blade.php`   | `owner.kos.index`          |
| `detail-01.html`       | `resources/views/owner/kos/show.blade.php`     | `owner.kos.show`           |
| `payment.html`          | `resources/views/customer/invoice/index.blade.php` | `customer.invoice.index`   |
| *(tidak ada di template)* | `resources/views/owner/kos/create.blade.php`    | `owner.kos.create`         |
| *(tidak ada di template)* | `resources/views/customer/kos/index.blade.php`   | `customer.kos.index`       |

Dua halaman terakhir (`owner/kos/create` dan `customer/kos/index`) belum ada di template ZIP, jadi dibuat baru dengan gaya visual (card, ts-form, warna, spacing) yang konsisten dengan halaman lain di template.

## Data dummy

Semua halaman saat ini menggunakan **data dummy** dari masing-masing Controller (belum terhubung database):

- `HomeController` → `$featuredKos`
- `OwnerKosController` → `$listKos`, `$kos`
- `CustomerKosController` → `$rentedKos`, `$invoices`

Model `Kos`, `Invoice`, dan `User` sudah dibuat namun masih kosong (belum ada migration/query), siap dikembangkan ke CRUD, autentikasi, booking, dan pembayaran sungguhan di tahap berikutnya.

## Catatan penting

- Desain, warna, layout, dan seluruh asset (CSS/JS/font/gambar) **tidak diubah** — 100% memakai file dari ZIP.
- Semua path asset memakai `{{ asset('assets/...') }}`.
- Semua link antar halaman memakai `{{ route(...) }}`.
- Layout dipisah: `layouts/app.blade.php` (halaman publik), `layouts/owner.blade.php` & `layouts/customer.blade.php` (halaman dengan sidebar area akun).
- Partial: `navbar`, `footer`, `alert`, `owner-sidebar`, `customer-sidebar`.
- Form login/register/tambah-kos/booking sudah diberi `@csrf` dan `action` placeholder (`action="#"`) dengan komentar `TODO`, siap dihubungkan ke route POST + validasi ketika autentikasi/CRUD diimplementasikan.
