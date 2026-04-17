# SiBK Latansa Cendekia (Sistem Bimbingan Konseling)

Aplikasi web Bimbingan Konseling untuk mengelola pendataan dan pemanggilan siswa. Website ini dibangun menggunakan framework **Laravel**.

## Fitur Utama

- **Akses Siswa**: Mengajukan konseling online, melihat riwayat panggilan/konseling, dan membaca membaca artikel edukasi dari sekolah.
- **Akses Guru BK**: Melakukan pemanggilan siswa, mencatat riwayat pemanggilan, mengelola hasil laporan/sesi konseling, serta mengunggah artikel edukasi ke siswa.
- **Akses Admin**: Mengelola master data akun (Siswa & Guru BK), memonitor hasil evaluasi bimbingan, dan rekap keseluruhan data Bimbingan Konseling.

## Syarat Server Lokal / Kebutuhan Sistem

- PHP >= 8.2
- Composer
- Database MySQL atau MariaDB
- Node.js & NPM (untuk nge-build asset frontend / Vite)

## Cara Instalasi & Menjalankan Project

1. **Siapkan Project**
   Buka terminal/CMD lalu arahkan ke folder project ini.

2. **Install Package Laravel (Vendor)**
   ```bash
   composer install
   ```

3. **Install Package Node (Node Modules) dan Build Asset**
   ```bash
   npm install
   npm run build
   ```

4. **Konfigurasi Environment (.env)**
   Copy file `.env.example` ke file baru dan beri nama `.env`.
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` tersebut dan sesuaikan bagian database-nya:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_kamu
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Catatan: pastikan kamu sudah membuat database kosong di phpMyAdmin/MySQL-mu dengan nama yang sama).*

5. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database & Seeder**
   Untuk membuat tabel sekaligus memasukkan data dummy awal (seperti akun default admin/siswa), jalankan:
   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan Aplikasi**
   Setelah semua langkah di atas selesai, nyalakan server bawaan Laravel:
   ```bash
   php artisan serve
   ```
   Aplikasi sekarang sudah bisa dibuka di browser: `http://localhost:8000`.

## Akun Login Default (bila menggunakan Seeder)
Pastikan melihat isi file `database/seeders/DatabaseSeeder.php` untuk mengetahui email dan password apa saja yang di-generate agar bisa langsung mencoba login. Biasanya password default-nya adalah `password`.
