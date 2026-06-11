# BantuApaAja — Panduan Setup

Marketplace jasa terinspirasi alur [Sejasa.com](https://sejasa.com).

## Alur Bisnis

1. **Pelanggan** membuat permintaan jasa → status `open`
2. **Vendor** (setelah verifikasi admin) mengirim penawaran (maks. 5) → otomatis `bidding_closed` jika penuh
3. **Pelanggan** memilih penawaran & bayar via saldo virtual (escrow) → `assigned`
4. **Vendor** mulai kerja → `in_progress` → tandai selesai → `awaiting_confirmation`
5. **Pelanggan** konfirmasi → dana cair ke vendor → `completed`
6. Sengketa → `disputed` → superadmin refund atau release

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate
# Atur DB di .env, lalu:
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install && npm run build
php artisan serve
```

## Akun Default

| Role | Email | Password |
|------|-------|----------|
| Superadmin | superadmin@bantuin.com | password123 |

## Peran Pengguna

- **customer** — dashboard pelanggan, buat request, terima penawaran
- **vendor** — daftar mitra, kirim penawaran, kelola pekerjaan
- **superadmin** — `/admin/dashboard` verifikasi vendor & sengketa
