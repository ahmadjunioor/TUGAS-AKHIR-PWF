# Panduan Installasi Project: Bantu-Apa-Aja

Panduan ini ditujukan untuk developer/teman yang ingin menjalankan project **Bantu-Apa-Aja** di komputer/laptop lokal mereka. Project ini dibangun menggunakan **Laravel 11**, **Tailwind CSS**, dan **MySQL**.

---

## 1. Persyaratan Sistem (Prerequisites)
Pastikan komputer Anda sudah terinstall:
- **PHP** versi 8.2 atau lebih baru.
- **Composer** (untuk install dependensi backend Laravel).
- **Node.js & NPM** (untuk compile frontend Tailwind CSS).
- **MySQL / MariaDB** (bisa menggunakan XAMPP, Laragon, dll).

---

## 2. Langkah Installasi

### A. Persiapan File
1. *Clone* atau *Copy* seluruh folder project ini ke lokal komputer Anda (biasanya di `htdocs` untuk XAMPP atau `www` untuk Laragon).
2. Buka Terminal / Command Prompt, lalu masuk ke folder project:
   ```bash
   cd path/to/Bantu-Apa-Aja
   ```
3. Install dependensi Backend dan Frontend:
   ```bash
   composer install
   npm install
   ```

### B. Konfigurasi Environment & Database
1. Salin/copy file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   *(Atau bisa copy-paste manual file-nya dan *rename* jadi `.env`)*
2. Buka file `.env` yang baru dibuat di Code Editor, lalu sesuaikan konfigurasi koneksi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bantu_apa_aja    # <- Nama database bebas, pastikan Anda membuatnya dulu di PhpMyAdmin
   DB_USERNAME=root             # <- Username MySQL lokal Anda (biasanya root)
   DB_PASSWORD=Mnbvcxz123.      # <- Isi password MySQL Anda (kosongkan jika tidak ada password)
   ```
3. Generate Application Key Laravel:
   ```bash
   php artisan key:generate
   ```

### C. Pembuatan Database & Seeding Data
Sebelum lanjut, pastikan Anda sudah **membuat database kosong** bernama `bantu_apa_aja` (atau sesuai nama di `.env`) di PhpMyAdmin atau Database Manager lokal Anda.

Jika database sudah dibuat, jalankan perintah berurutan berikut di Terminal:

1. **Jalankan Migrasi Database & Seeder Utama:**
   Perintah ini akan membuat struktur tabel (Users, Transactions, dll) sekaligus memasukkan data *Superadmin* dan *Kategori Jasa*.
   ```bash
   php artisan migrate:fresh --seed
   ```
2. **Jalankan Seeder Wilayah Indonesia (Dropdown Provinsi/Kota):**
   Project ini menggunakan *package* dari `laravolt/indonesia` untuk data Provinsi, Kota, dan Kecamatan. Install datanya dengan perintah khusus ini (membutuhkan waktu beberapa detik/menit karena datanya sangat banyak):
   ```bash
   php artisan laravolt:indonesia:seed
   ```

### D. Menjalankan Aplikasi
1. Jalankan server Frontend untuk me-*compile* Tailwind CSS:
   ```bash
   npm run dev
   ```
2. Buka **Terminal Baru** (biarkan terminal pertama tetap berjalan), lalu jalankan local server Laravel:
   ```bash
   php artisan serve
   ```
3. Aplikasi kini bisa diakses di browser melalui link: **`http://localhost:8000`**

---

## 3. Data Akun Default
Setelah database di-seed, Anda dapat langsung *Login* menggunakan akun **Superadmin** berikut:
- **Email:** `superadmin@bantuin.com`
- **Password:** `password123`

Untuk role *Customer* dan *Vendor*, silakan coba lakukan registrasi akun baru melalui halaman Register di aplikasi.

***Selamat mencoba & ngoding!*** 🎉
