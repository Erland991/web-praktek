-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Apr 2026 pada 10.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_monitoring_aset`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aplikasi_master`
--

CREATE TABLE `aplikasi_master` (
  `id` int(11) NOT NULL,
  `nama_app` varchar(255) DEFAULT NULL,
  `pic_id` int(11) DEFAULT NULL,
  `divisi_id` int(11) DEFAULT NULL,
  `status` enum('Development','Production','Maintenance') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `aset`
--

CREATE TABLE `aset` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_aset` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aset`
--

INSERT INTO `aset` (`id`, `nama_aset`, `kategori`, `status`, `pic`, `deskripsi`, `created_at`, `updated_at`) VALUES
(2, 'Sistem Managemen Aplikasi', 'Hardware', 'Aktif', 'Erland', NULL, '2026-04-13 10:27:27', '2026-04-14 07:45:31'),
(4, 'Aplikasi Monitoring V1', 'Data', 'Aktif', 'otsheyy', NULL, '2026-04-13 13:01:49', '2026-04-14 01:35:28'),
(5, 'MY UNPAM', 'Server', 'Aktif', 'rendi', NULL, '2026-04-14 08:18:12', '2026-04-14 08:18:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id` int(5) UNSIGNED NOT NULL,
  `nama_divisi` varchar(100) NOT NULL,
  `kode_divisi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id`, `nama_divisi`, `kode_divisi`) VALUES
(11, 'Mineral & Batubara', 'MO'),
(12, 'Minyak & Gas Bumi', 'OG'),
(13, 'Infrastruktur', 'PI'),
(14, 'Institusi & Kelembagaan', 'IK'),
(15, 'Lingkungan', 'LIG'),
(16, 'Teknologi Informasi', 'TI'),
(17, 'Sumber Daya Manusia', 'SDM'),
(18, 'Keuangan', 'KEU');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(5) UNSIGNED NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `divisi_id` int(5) UNSIGNED NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(3, '2026-04-13-090252', 'App\\Database\\Migrations\\CreateDivisi', 'default', 'App', 1776073124, 1),
(4, '2026-04-13-090302', 'App\\Database\\Migrations\\CreateKaryawan', 'default', 'App', 1776073124, 1),
(5, '2026-04-13-090312', 'App\\Database\\Migrations\\UpdateUsers', 'default', 'App', 1776073124, 1),
(6, '2026-04-13-092813', 'App\\Database\\Migrations\\CreateAset', 'default', 'App', 1776073124, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `progres_log`
--

CREATE TABLE `progres_log` (
  `id` int(11) NOT NULL,
  `aplikasi_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pesan_update` text DEFAULT NULL,
  `persentase` int(11) DEFAULT NULL,
  `tgl_update` datetime DEFAULT current_timestamp(),
  `is_approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Admin','User','Viewer') DEFAULT 'User',
  `status_karyawan` enum('Tetap','Kontrak','Magang') DEFAULT 'Tetap',
  `role_id` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `divisi` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nip`, `username`, `password`, `role`, `status_karyawan`, `role_id`, `nama_lengkap`, `divisi`, `created_at`, `updated_at`) VALUES
(3, '12345', 'hanif', '$2y$10$j5ZdRuhCNiVqpylr1kIeuOj4krQq2ZFxiXo7/gbP0g9CNdjA5oW4y', 'Admin', 'Tetap', NULL, 'kak hanif', 'Teknologi Informasi', NULL, NULL),
(6, NULL, 'erland', 'admin123', 'Admin', 'Tetap', NULL, 'erland Radithya Putra Priono', NULL, '2026-04-13 12:28:14', '2026-04-13 12:28:14'),
(7, '123345', 'erland', 'admin123', 'Admin', 'Tetap', NULL, 'Erland Radithya Putra Priono', 'Keuangan', NULL, NULL),
(8, '1233444', 'rendi', 'admin123', 'User', 'Tetap', NULL, 'rendi wijaya', 'Sumber Daya Manusia', NULL, NULL),
(9, '12345', 'riski', '$2y$10$FnHgldsa7ulExKCracEPhOPm0sgrMKxKQnawgBxOwH.fBVjyjbAXW', 'Admin', 'Tetap', NULL, 'Riski kurniawan', 'Infrastruktur', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aplikasi_master`
--
ALTER TABLE `aplikasi_master`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aset`
--
ALTER TABLE `aset`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_divisi_id_foreign` (`divisi_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `progres_log`
--
ALTER TABLE `progres_log`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aplikasi_master`
--
ALTER TABLE `aplikasi_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `aset`
--
ALTER TABLE `aset`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `progres_log`
--
ALTER TABLE `progres_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
