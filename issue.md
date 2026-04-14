# Issue: Refactoring "Kelola Akun" Menjadi Manajemen Data Detail (Siswa & Guru/BK)

## Deskripsi / Latar Belakang
Pada dashboard admin saat ini, menu **"Kelola Akun"** dirasa kurang memadai karena umumnya hanya berfokus pada informasi terkait keamanan akun (seperti username, email, password, dan role). 

Untuk memenuhi kebutuhan operasional Bimbingan Konseling secara menyeluruh, admin perlu mengelola **profil lengkap** dari setiap pengguna, baik itu Siswa maupun Guru/BK. Oleh karena itu, bagian "Kelola Akun" harus direstrukturisasi menjadi master data yang memisahkan profil berdasarkan tipe penggunanya dengan ketersediaan atribut data yang lengkap.

## Rencana Perubahan (Proposed Changes)
Mengganti entitas "Kelola Akun" menjadi lebih komprehensif, dibagi ke dalam 2 menu/domain utama:
1. **Data Siswa**
2. **Data Guru / BK**

*(Sistem autentikasi/login (tabel `users`) dapat berelasi dengan tabel profil tersebut (seperti `students` dan `teachers` / `counselors`).)*

### 1. Data Siswa (Student Master Data)
Form input, Edit, dan tampilan tabel (Read) untuk Siswa harus diperluas. Data yang diperlukan meliputi:
*   **NIS / NISN** (Nomor Induk Siswa Nasional) - *Unik & wajib*
*   **Nama Lengkap**
*   **Kelas / Rombel** (Rombongan Belajar)
*   **Jenis Kelamin** (L/P)
*   **Tempat, Tanggal Lahir**
*   **Alamat Lengkap**
*   **Nomor Telepon / WhatsApp Siswa**
*   **Nama Orang Tua / Wali**
*   **Nomor Telepon Orang Tua / Wali** *(Penting untuk fitur pemanggilan)*
*   *Foto Profil (Opsional)*

### 2. Data Guru / Guru BK (Teacher / Master Data)
Form input, Edit, dan tampilan tabel (Read) untuk Guru/BK harus mencakup:
*   **NIP / NUPTK** (Opsional/Sesuai ketersediaan)
*   **Nama Lengkap (beserta Gelar)**
*   **Jenis Kelamin**
*   **Alamat Lengkap**
*   **Nomor Telepon / WhatsApp Guru**
*   **Jabatan / Spesialisasi** (Misal: Guru BK Kelas X, Koordinator BK, dll)
*   *Foto Profil (Opsional)*

## Analisis Komponen yang Berdampak (Impact Analysis)

### 1. Database (Migrations & Models)
*   Akan dibutuhkan migrasi baru untuk memperluas skema tabel.
*   **Rekomendasi Rute:** Membuat tabel baru `students` dan `teachers` (beserta Model-nya) yang mana memiliki relasi *One-to-One* (atau *One-to-Many*) dengan tabel `users` (untuk `user_id`). Atau, menambahkan kolom langsung ke tabel `users` meski berisiko membuat kolom sering kosong (null) tergatung rolenya (tidak direkomendasikan).

### 2. Antarmuka Pengguna Admin (Admin UI)
*   **Sidebar Navigation:** Mengganti "Kelola Akun" menjadi "Data Master" atau langsung "Data Siswa" dan "Data Guru/BK".
*   **Halaman Indeks:** Tabel yang lebih kaya informasi (opsi show/hide kolom atau menggunakan DataTables filter data).
*   **Halaman Form (Create & Update):** Desain form harus disesuaikan, karena isian field akan lebih panjang. Dapat dipertimbangkan pemisahan section ke dalam kelompok (Contoh: "Info Akun Login", "Data Diri Siswa", "Data Orang Tua").

### 3. Controller & Validasi
*   Pembuatan controller baru (seperti `StudentDataController` dan `TeacherDataController` di bawah namespace Admin).
*   Pembaruan Request Validation untuk memastikan field seperti NIS atau NIP unik, dan format nomor telepon/tanggal dikirimkan dengan benar.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Admin memiliki akses ke halaman "Data Siswa" yang menampilkan secara utuh data pokok siswa dari database.
- [ ] Admin memiliki akses ke halaman "Data Guru/BK" yang menampilkan data diri para pendidik.
- [ ] Admin dapat mendata profil siswa & guru secara mendetail (Create/Update), sekaligus sistem menyelaraskan kredensial login (akun) ke tabel users jika pengguna baru dibuat.
- [ ] Halaman Admin Dashboard terkait manajemen profil berfungsi mulus tanpa broken link.
