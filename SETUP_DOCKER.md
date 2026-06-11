# Panduan Menjalankan Website dengan Docker Desktop

Dokumen ini menjelaskan langkah-langkah untuk membungkus aplikasi **BantuApaAja** menggunakan Docker agar bisa dijalankan di **Docker Desktop** dan diakses oleh orang lain (dalam satu jaringan lokal / Wi-Fi, atau secara publik).

---

## File Docker yang Telah Ditambahkan

Kami telah menambahkan konfigurasi Docker berikut ke dalam project Anda:
1. **[Dockerfile](file:///d:/TUGAS-AKHIR-PWF/Dockerfile)**: Menggunakan multi-stage build. Pertama mengompilasi aset front-end (Tailwind, Alpine, Vite) menggunakan Node.js, kemudian menyiapkannya di Apache HTTP Server + PHP 8.2 yang dioptimasi untuk produksi.
2. **[docker-compose.yml](file:///d:/TUGAS-AKHIR-PWF/docker-compose.yml)**: Mendefinisikan service `app` (Laravel) dan `db` (MySQL 8.0) agar berjalan bersama-sama di dalam jaringan virtual Docker yang terisolasi.
3. **[docker-entrypoint.sh](file:///d:/TUGAS-AKHIR-PWF/docker-entrypoint.sh)**: Script otomatis untuk menunggu database MySQL siap, menjalankan migrasi skema tabel, dan mengoptimasi cache konfigurasi Laravel sebelum server web aktif.
4. **[.dockerignore](file:///d:/TUGAS-AKHIR-PWF/.dockerignore)**: Memastikan file cache local, vendor PHP, dan node_modules tidak ikut terbawa ke dalam Docker image agar proses build cepat dan ukuran image tetap kecil.

---

## Langkah-Langkah Menjalankan di Docker Desktop

### 1. Prasyarat
* Pastikan aplikasi **Docker Desktop** sudah terinstal dan berjalan di komputer Anda.
* Pastikan file `.env` di direktori utama Anda memiliki variabel `APP_KEY` yang terisi (kunci enkripsi ini akan otomatis terbaca oleh docker-compose).

### 2. Membangun & Menjalankan Kontainer
Buka terminal (PowerShell, Command Prompt, atau Git Bash) di direktori utama project (`d:\TUGAS-AKHIR-PWF`) dan jalankan perintah berikut:

```bash
docker-compose up --build -d
```

* **Penjelasan Perintah**:
  * `--build`: Memaksa docker untuk melakukan compile aset frontend dan build PHP image baru.
  * `-d`: Menjalankan kontainer di latar belakang (detached mode) sehingga terminal Anda tetap bebas digunakan.

Setelah perintah selesai berjalan, buka aplikasi **Docker Desktop**. Anda akan melihat aplikasi bernama `tugas-akhir-pwf` dengan dua kontainer di dalamnya: `tugas_akhir_pwf_app` dan `tugas_akhir_pwf_db`.

---

## Cara Mengakses Website

### 1. Akses dari Komputer Anda Sendiri (Localhost)
Buka browser Anda dan akses alamat berikut:
```
http://localhost:8000
```
Website akan langsung terbuka dan database sudah otomatis ter-migrasi serta terisi data wilayah (Indonesia regions seeder) melalui script entrypoint.

### 2. Akses dari Orang Lain di Jaringan Wi-Fi/Lokal yang Sama
Agar orang lain di kantor, rumah, atau sekolah Anda (yang terhubung ke router Wi-Fi yang sama) bisa mengakses website Anda:

1. **Cari IP Address Lokal Komputer Anda**:
   * Di Windows, buka PowerShell/CMD lalu jalankan perintah `ipconfig`.
   * Temukan baris `IPv4 Address` pada adaptor Wi-Fi Anda (misalnya: `192.168.1.15`).

2. **Akses dari Device Lain**:
   * Di HP atau Laptop milik orang lain yang terhubung ke Wi-Fi yang sama, buka browser dan ketik:
     ```
     http://<IP-Address-Lokal-Anda>:8000
     # Contoh: http://192.168.1.15:8000
     ```

> **Catatan Penting (Windows Firewall)**:
> Jika orang lain tidak bisa membuka alamat tersebut, biasanya Windows Defender Firewall di komputer Anda memblokir koneksi masuk.
> * **Solusi**: Nonaktifkan sementara Firewall untuk *Private Network* Anda, atau tambahkan *Inbound Rule* baru di Firewall untuk mengizinkan port `8000` diakses dari luar.

### 3. Akses secara Publik oleh Semua Orang di Internet
Jika Anda ingin mendemonstrasikannya ke orang lain yang berada di luar jaringan (di internet), cara termudah dan tercepat tanpa menyewa server (VPS) adalah menggunakan tool tunneling seperti **ngrok** atau **Pinggy**:

#### Menggunakan Pinggy (Tanpa Perlu Menginstal Apapun)
Jalankan perintah ini di terminal komputer Anda:
```bash
ssh -p 443 -R0:localhost:8000 a.pinggy.io
```
Terminal akan menampilkan alamat URL publik (misal: `https://xxxx.pinggy.link`) yang dapat diakses oleh **siapa saja di seluruh dunia**.

#### Menggunakan Ngrok (Gratis & Stabil)
1. Unduh dan instal [ngrok](https://ngrok.com/).
2. Jalankan perintah berikut di terminal:
   ```bash
   ngrok http 8000
   ```
3. Salin URL publik `Forwarding` yang disediakan (misal: `https://a1b2-34-56.ngrok-free.app`) dan bagikan ke orang lain.

---

## Perintah Tambahan yang Berguna

* **Menghentikan Kontainer**:
  ```bash
  docker-compose down
  ```
* **Melihat Log Aplikasi**:
  ```bash
  docker-compose logs -f app
  ```
* **Masuk ke Terminal PHP di Dalam Kontainer (untuk jalankan artisan manual)**:
  ```bash
  docker-compose exec app bash
  ```
* **Meriset/Menghapus Data Database**:
  Jika Anda ingin memulai database dari nol lagi, matikan kontainer bersamaan dengan volumenya:
  ```bash
  docker-compose down -v
  ```
