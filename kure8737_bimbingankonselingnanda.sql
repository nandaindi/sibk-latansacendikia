-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 04 Apr 2026 pada 20.50
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bimbingankonselingnanda`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikels`
--

CREATE TABLE `artikels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `konten` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `penulis_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `artikels`
--

INSERT INTO `artikels` (`id`, `judul`, `slug`, `konten`, `gambar`, `penulis_id`, `created_at`, `updated_at`) VALUES
(1, 'tes', 'tes-69a831af982c9', '<p>kopi itu enak tes</p>', 'artikels/Q7xWaUL9emhRxhhf963wK9dB3QaglfXf0YZrIGEW.jpg', 3, '2026-02-28 16:53:02', '2026-03-04 13:20:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `konselings`
--

CREATE TABLE `konselings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('online','offline') NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(255) DEFAULT NULL,
  `link_meet` varchar(255) DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak','selesai','tidak_hadir','dipanggil') DEFAULT 'pending',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `alasan_tolak` text DEFAULT NULL,
  `catatan_bk` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bk_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `konselings`
--

INSERT INTO `konselings` (`id`, `user_id`, `jenis`, `tanggal`, `waktu`, `link_meet`, `status`, `is_read`, `alasan_tolak`, `catatan_bk`, `created_at`, `updated_at`, `bk_id`) VALUES
(7, 5, 'offline', '2026-02-28', '01:15', NULL, 'selesai', 0, NULL, 'Problem:\ntes\n\nSolution:\ntes\n\nNote:\ntes', '2026-02-27 18:14:58', '2026-02-27 18:27:06', 3),
(8, 4, 'offline', '2026-02-28', '09:00', NULL, 'selesai', 1, NULL, 'Problem:\ntes\n\nSolution:\ntes\n\nNote:\ntes', '2026-02-27 18:23:20', '2026-03-04 16:48:36', 3),
(9, 4, 'offline', '2026-02-28', '09:00', NULL, 'tidak_hadir', 0, NULL, 'Topik: tes\n\nCatatan: tes', '2026-02-28 14:31:08', '2026-02-28 14:32:08', 3),
(10, 4, 'offline', '2026-02-28', '00:00', NULL, 'tidak_hadir', 0, NULL, 'Topik: tes\n\nCatatan: tes', '2026-02-28 14:33:29', '2026-02-28 14:34:02', 3),
(11, 4, 'offline', '2026-03-01', '09:00', NULL, 'selesai', 1, NULL, 'Problem:\ntes\n\nSolution:\ntes\n\nNote:\ntes', '2026-02-28 14:35:07', '2026-03-04 16:48:34', 3),
(12, 4, 'online', '2026-02-28', '21:40', 'https://meet.google.com/nox-rtdq-iqs', 'selesai', 1, NULL, NULL, '2026-02-28 14:38:42', '2026-03-04 16:48:30', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_laporan` varchar(255) NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `search_key` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `laporans`
--

INSERT INTO `laporans` (`id`, `nama_laporan`, `author_id`, `tanggal`, `search_key`, `created_at`, `updated_at`) VALUES
(1, 'Laporan Konseling Semester Ganjil', 2, '2025-07-02', 'Rabu, 2 Juli 2025', '2026-02-26 17:10:09', '2026-02-26 17:10:09'),
(2, 'Rekap Kunjungan BK Juli 2025', 2, '2025-07-15', 'Selasa, 15 Juli 2025', '2026-02-26 17:10:09', '2026-02-26 17:10:09'),
(3, 'Laporan Konseling: Siswa Lain', 3, '2026-02-28', 'Saturday, 28 February 2026', '2026-02-27 18:27:06', '2026-02-27 18:27:06'),
(4, 'Laporan Konseling: Nanda Indi Lestari', 3, '2026-02-28', 'Saturday, 28 February 2026', '2026-02-27 22:30:45', '2026-02-27 22:30:45'),
(5, 'Laporan Konseling: Nanda Indi Lestari', 3, '2026-02-28', 'Saturday, 28 February 2026', '2026-02-28 14:37:03', '2026-02-28 14:37:03'),
(6, 'Laporan Konseling: Nanda Indi Lestari', 3, '2026-02-28', 'Saturday, 28 February 2026', '2026-02-28 14:51:47', '2026-02-28 14:51:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_26_223323_create_konselings_table', 1),
(5, '2026_02_26_223324_create_laporans_table', 1),
(6, '2026_02_27_001900_add_alasan_tolak_to_konselings_table', 2),
(7, '2026_02_27_131150_create_pesan_chats_table', 3),
(8, '2026_02_27_174839_add_tidak_hadir_status_to_konselings_table', 4),
(9, '2026_02_28_010754_add_bk_id_to_konselings_table', 5),
(10, '2026_02_28_043647_add_jurusan_to_users_table', 6),
(11, '2026_02_28_044853_create_artikels_table', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('eni@example.com', '$2y$12$TVwLVVBKufvEnUh2Soa7Aeb9sGGDJwp4Puapo8IaR9JAMlaMSkiia', '2026-03-04 15:28:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan_chats`
--

CREATE TABLE `pesan_chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `konseling_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pesan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesan_chats`
--

INSERT INTO `pesan_chats` (`id`, `konseling_id`, `user_id`, `pesan`, `created_at`, `updated_at`) VALUES
(7, 12, 3, 'haloo nanda', '2026-02-28 14:42:13', '2026-02-28 14:42:13'),
(8, 12, 4, 'iyaa haloo', '2026-02-28 14:42:41', '2026-02-28 14:42:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('UY4fheDsndyXEavTYxxiDQg7Cg0GDSpwhOKbWI8Y', NULL, '127.0.0.1', 'curl/7.53.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWDNMcGtOdjNOb3NsNkpTckRXeTkxeGgzV2tTTUpmMzdzSHNMRjRnRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC90ZXN0LW1haWwiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1772637933),
('X8zLFDq79NJpvf1nFqcebawetaCFsn1tIl41U3XF', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicW5wY3FnUVZpbThtV0lnZW5BRTRzT0V1VFlnYnA3RkNjYnZFU0F4UCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1772649424);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','bk','siswa') NOT NULL DEFAULT 'siswa',
  `nis` varchar(255) DEFAULT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `nis`, `kelas`, `jurusan`, `telepon`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin', 'admin@example.com', NULL, '$2y$12$QRw1orRtNSqHok2pisA4Zu9By96UCKlS7pbnF9FDfUa6ow.1iOucm', 'admin', NULL, NULL, NULL, '081234567890', NULL, 'D6FCHFukyM4b6PqMwyUMG2Ocl7xRDBtpzmoggE2qju104h6gwO6ro1tpF3At', '2026-02-26 17:10:08', '2026-02-26 17:10:08'),
(2, 'Eni Kustiyorini, S.Psi', 'Eni Kustiyorini', 'eni@example.com', NULL, '$2y$12$JH0Lol1adBOaWDqYAftMbeZx8QKQt6GeSAjDMGAsDte2HxFKea1bi', 'bk', NULL, NULL, NULL, '089876543210', NULL, NULL, '2026-02-26 17:10:08', '2026-02-26 17:10:08'),
(3, 'Devina Rayining Tias, S.Psi', 'devina.bk', 'devina@example.com', NULL, '$2y$12$33JLO6brJNOVhVABoMfe2OveBCfroWolhm/VUiXPF3H1NNUINmuve', 'bk', NULL, NULL, NULL, '082233445566', 'avatars/rJiUbVUWo161fMDEJsblpasNGJrvGdTdbDpPMKq6.png', NULL, '2026-02-26 17:10:09', '2026-02-27 22:07:51'),
(4, 'Nanda Indi Lestari', 'nanda', 'nanda@example.com', NULL, '$2y$12$zAwVidoZ4yxt2ESLIxr5b.pk.uW1ue5cFtkjah4QWLQ3s89R1/OtW', 'siswa', '123456', 'X', 'rekayasa perangkat lunak', NULL, 'avatars/k7lckrEIX4RwCAV2hLj7AY6yoORFSKmVICvGGLYX.png', NULL, '2026-02-26 17:10:09', '2026-02-27 21:43:55'),
(5, 'Siswa Lain', 'siswa', 'siswa@example.com', NULL, '$2y$12$YJMfg133h9GyMnBOoqdl3uuPwwNZxQ170JqPAt4Ctc7Wsg5tRY/rO', 'siswa', '654321', 'XI', 'otomotif', NULL, NULL, NULL, '2026-02-26 17:10:09', '2026-02-28 14:55:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `artikels`
--
ALTER TABLE `artikels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `artikels_slug_unique` (`slug`),
  ADD KEY `artikels_penulis_id_foreign` (`penulis_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `konselings`
--
ALTER TABLE `konselings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `konselings_user_id_foreign` (`user_id`),
  ADD KEY `konselings_bk_id_foreign` (`bk_id`);

--
-- Indeks untuk tabel `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporans_author_id_foreign` (`author_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pesan_chats`
--
ALTER TABLE `pesan_chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesan_chats_konseling_id_foreign` (`konseling_id`),
  ADD KEY `pesan_chats_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `artikels`
--
ALTER TABLE `artikels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `konselings`
--
ALTER TABLE `konselings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pesan_chats`
--
ALTER TABLE `pesan_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `artikels`
--
ALTER TABLE `artikels`
  ADD CONSTRAINT `artikels_penulis_id_foreign` FOREIGN KEY (`penulis_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `konselings`
--
ALTER TABLE `konselings`
  ADD CONSTRAINT `konselings_bk_id_foreign` FOREIGN KEY (`bk_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `konselings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporans`
--
ALTER TABLE `laporans`
  ADD CONSTRAINT `laporans_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesan_chats`
--
ALTER TABLE `pesan_chats`
  ADD CONSTRAINT `pesan_chats_konseling_id_foreign` FOREIGN KEY (`konseling_id`) REFERENCES `konselings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesan_chats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
