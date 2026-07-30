<img width="1366" height="768" alt="image" src="https://github.com/user-attachments/assets/82fb8644-a1fd-4692-871f-d2b4564cd156" />

# SIMRS - Sistem Informasi Manajemen Rumah Sakit

Aplikasi manajemen rumah sakit berbasis web menggunakan Laravel.

## Fitur

- **Manajemen Pasien** - CRUD data pasien
- **Manajemen Dokter** - Data dokter dan jadwal praktik
- **PoliKlinik** - Master data poliklinik
- **Ruangan & Tempat Tidur** - Kategori ruangan, manajemen ruangan, dan transfer tempat tidur
- **Obat-obatan** - Kategori obat dan stok obat
- **Laboratorium** - Jenis tes lab, permintaan, dan hasil lab
- **Radiologi** - Jenis tes radiologi, permintaan, dan hasil radiologi
- **Layanan Medis** - Master data layanan medis
- **Asuransi** - Data asuransi pasien
- **Registrasi** - Pendaftaran pasien
- **Kunjungan** - Rawat jalan, rawat inap, dan IGD
- **Rekam Medis** - Catatan medis pasien
- **Resep Obat** - Pembuatan dan pengelolaan resep
- **Tagihan & Pembayaran** - Tagihan pasien dan pembayaran
- **Rujukan** - Manajemen rujukan pasien
- **Laporan** - Laporan harian dan keuangan
- **Role Management** - CheckRole middleware untuk akses berbasis peran

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL / MariaDB / PostgreSQL
- Node.js & NPM (untuk frontend)

## Instalasi

```bash
# Clone repository
git clone https://github.com/habiutomo/simrs-laravel.git
cd simrs-laravel

# Install dependencies PHP
composer install

# Install dependencies frontend
npm install

# Copy environment
cp .env.example .env

# Generate key
php artisan key:generate

# Konfigurasi database di file .env, lalu jalankan migrasi
php artisan migrate --seed

# Jalankan aplikasi
php artisan serve
```

## Teknologi

- Laravel 11
- Blade Templates
- MySQL Database
- Bootstrap (via Vite)
