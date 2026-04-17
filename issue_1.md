# Issue #1: Fitur Notifikasi Otomatis (Reminder) 10 Menit Sebelum Sesi Bimbingan

## 📌 Deskripsi / Latar Belakang
Klien (Client) menginginkan adanya sistem pengingat (reminder) bagi pengguna agar tidak terlewat sesi bimbingan konseling yang telah dijadwalkan. Pengingat ini harus otomatis dikirimkan mendekati waktu pelaksanaan sesi konseling.

## 🎯 Target / Kriteria Penerimaan (Acceptance Criteria)
- [ ] Sistem dapat mendeteksi jadwal bimbingan konseling yang berstatus `disetujui` (approved).
- [ ] Sistem akan mengirimkan notifikasi secara otomatis tepat **10 menit sebelum** waktu (`waktu`) bimbingan dimulai.
- [ ] Notifikasi dapat dikirimkan kepada **Siswa** dan **Guru BK** yang bersangkutan.
- [ ] Metode pengiriman notifikasi terdefinisi (bisa melalui Notifikasi Database/In-App, Email, atau WhatsApp).

## 🛠️ Analisis Implementasi & Kebutuhan Teknis

1. **Struktur Data Saat Ini**: 
   Data jadwal disimpan dalam tabel `konselings` dengan kolom `tanggal` (date) dan `waktu` (string). Untuk penghitungan waktu "10 menit sebelum", format kolom `waktu` harus dipastikan valid (contoh: `"09:00"`, `"14:30"`) sehingga dapat digabungkan dengan `tanggal` menjadi `datetime` (misal menggunakan Carbon).

2. **Pendekatan Penjadwalan (Scheduling)**:
   - **Opsi A (Task Scheduling / Cron Job)**: Membuat Laravel Command (misal: `php artisan schedule:run`) yang berjalan setiap menit ( `* * * * *` ). Command ini akan melakukan query ke tabel `konselings` mencari sesi dengan jadwal `waktu - 10 menit == waktu_saat_ini` dan mengirimkan *Notification*.
   - **Opsi B (Pusher / Realtime)**: Menggunakan WebSockets. Namun ini lebih cocok untuk realtime action daripada trigger berdasarkan waktu.
   - **Opsi C (Polling dari Frontend)**: Frontend mengecek apakah ada jadwal terdekat (kurang direkomendasikan karena boros resource server).
   
   **Rekomendasi Terbaik**: Menggunakan **Laravel Task Scheduling** yang di-hook ke cron job server.

3. **Komponen yang Perlu Dibuat / Diubah**:
   - Class `Notification` baru (misal: `App\Notifications\SessionReminderNotification`).
   - Command baru (misal: `App\Console\Commands\SendSessionReminders`).
   - Mendaftarkan command di `bootstrap/app.php` atau `routes/console.php` (tergantung versi Laravel) untuk dieksekusi `->everyMinute()`.

## ❓ Pertanyaan Terbuka untuk Diskusi
1. Apakah notifikasi ini akan dikirim dalam bentuk **Email**, **WhatsApp**, atau cukup **Notifikasi di dalam Web (Lonceng/Alert)**?
2. Apakah format isian di kolom `waktu` sejauh ini konsisten menggunakan format jam `HH:MM`? (Jika teksnya bebas seperti *"Siang setelah istirahat"*, maka fitur ini akan sulit dibuat otomatis secara akurat).
