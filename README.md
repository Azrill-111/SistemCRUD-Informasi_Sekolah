# Sistem Informasi Sekolah

Aplikasi web sederhana berbasis **Laravel 13** (arsitektur MVC) untuk mengelola dan
menampilkan informasi sekolah. Admin mengelola data informasi (CRUD), sedangkan
user/siswa hanya dapat membaca daftar dan detail informasi.

> `// Dikerjakan secara mandiri` — lihat baris pertama `routes/web.php`.

## Fitur

- **Satu halaman login** untuk admin dan user.
  - Admin → diarahkan ke **Dashboard Admin**
  - User/siswa → diarahkan ke **Halaman Informasi**
- **Multi-role access control**: kolom `role` (`admin` / `user`) + middleware `admin`,
  sehingga user/siswa **tidak bisa** membuka URL admin (respon `403`).
- **CRUD informasi** oleh admin: tambah, lihat, ubah, hapus (termasuk unggah gambar opsional).
- **Validasi input** memakai Form Request (`StoreInformasiRequest` / `UpdateInformasiRequest`).
- **Halaman user read-only** yang membaca langsung dari database, sehingga data yang
  dihapus admin otomatis hilang dari tampilan user.
- **UI minimalist & responsif** (putih / abu / hitam) memakai **Tailwind CSS CDN**.

## Akun default (hasil seeder)

| Role  | Email                 | Password   |
|-------|-----------------------|------------|
| Admin | `admin@sekolah.test`  | `password` |
| User  | `user@sekolah.test`   | `password` |

Seeder juga membuat 3 data informasi awal.

## Kebutuhan sistem

- PHP **≥ 8.4.1** (proyek ini dijalankan dengan PHP 8.5.8 milik Laragon)
- MySQL (Laragon MySQL 8.4.3) / SQLite
- Composer

## Struktur MVC

| Bagian | Berkas |
|---|---|
| Migration | `database/migrations/0001_01_01_000000_create_users_table.php` (ditambah kolom `role`), `database/migrations/2026_10_16_000001_create_informasis_table.php` |
| Seeder | `database/seeders/DatabaseSeeder.php` |
| Model | `app/Models/User.php`, `app/Models/Informasi.php` |
| Middleware | `app/Http/Middleware/EnsureUserIsAdmin.php` (alias `admin`, terdaftar di `bootstrap/app.php`) |
| Form Request | `app/Http/Requests/StoreInformasiRequest.php`, `app/Http/Requests/UpdateInformasiRequest.php` |
| Controller | `app/Http/Controllers/Auth/LoginController.php`, `app/Http/Controllers/Admin/DashboardController.php`, `app/Http/Controllers/Admin/InformasiController.php`, `app/Http/Controllers/InformasiController.php` |
| Routes | `routes/web.php` |
| View | `resources/views/layouts/`, `resources/views/auth/`, `resources/views/informasi/`, `resources/views/admin/`, `resources/views/partials/`, `resources/views/errors/403.blade.php` |
| Test | `tests/Feature/SistemInformasiTest.php` |

## Daftar route

| Method | URL | Nama route | Akses |
|---|---|---|---|
| GET | `/` | `home` | redirect sesuai role |
| GET / POST | `/login` | `login`, `login.attempt` | tamu |
| POST | `/logout` | `logout` | login |
| GET | `/informasi` | `informasi.index` | login (user & admin) |
| GET | `/informasi/{informasi}` | `informasi.show` | login (user & admin) |
| GET | `/admin/dashboard` | `admin.dashboard` | admin |
| GET/POST/PUT/DELETE | `/admin/informasi*` | `admin.informasi.*` | admin |

## Cara menjalankan (Laragon)

1. Pastikan **Laragon → PHP → Version** memilih **php-8.5.8-Win32-vs17-x64**
   (Laragon hanya menyediakan PHP 8.3.30, sedangkan dependency proyek minta ≥ 8.4.1).
2. Database: buat database MySQL bernama `informasi_sekolah` (nama sudah diset di `.env`).
3. Jalankan migrasi + seeder:

   ```sh
   php artisan migrate:fresh --seed
   ```

4. Buat symlink penyimpanan gambar:

   ```sh
   php artisan storage:link
   ```

5. Akses `http://informasi-sekolah.test` (vhost otomatis Laragon) atau
   `php artisan serve` lalu buka `http://127.0.0.1:8000`.

## Perintah lain

```sh
php artisan test          # 13 feature test (auth, hak akses, CRUD, sinkronisasi data)
vendor/bin/pint           # perapian gaya kode
```

## Catatan konfigurasi

- `pint.json` menonaktifkan rule `blank_line_after_opening_tag` agar komentar
  `// Dikerjakan secara mandiri` tetap berada tepat di baris paling atas `routes/web.php`.
- `APP_LOCALE=id` + `Carbon::setLocale()` di `AppServiceProvider` agar tanggal
  tampil dalam Bahasa Indonesia.
- **Laravel Boost** (`laravel/boost`) terpasang sebagai dev dependency sesuai `AGENTS.md`,
  memakai PHP 8.5.8 Laragon. Boost membuat `AGENTS.md`, `CLAUDE.md`, `.mcp.json`,
  `opencode.json`, `boost.json`, folder `.agents/`, `.claude/`, dan `.cursor/`.
  Boost tidak dipakai oleh aplikasi saat berjalan (hanya alat bantu pengembangan).
