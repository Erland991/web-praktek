-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jul 2026 pada 05.31
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
-- Struktur dari tabel `absensi_kehadiran`
--

CREATE TABLE `absensi_kehadiran` (
  `id` int(11) UNSIGNED NOT NULL,
  `aplikasi_id` int(11) UNSIGNED DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `acara` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(100) NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `peserta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`peserta`)),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi_kehadiran`
--

INSERT INTO `absensi_kehadiran` (`id`, `aplikasi_id`, `user_id`, `acara`, `tanggal`, `waktu`, `tempat`, `peserta`, `created_at`, `updated_at`) VALUES
(1, NULL, 8, 'makan bersama', '2026-05-27', '09.00', 'AEON', '[{\"nama\":\"Erland\",\"jabatan\":\"IT\",\"hp\":\"1234\",\"email\":\"siwit123@gmail.com\"},{\"nama\":\"rendy\",\"jabatan\":\"IT\",\"hp\":\"1223\",\"email\":\"sapi223@gmail.com\"}]', '2026-05-26 02:35:12', '2026-05-26 02:35:12'),
(2, NULL, 2, 'makan bersama', '2026-05-26', '09.00', 'AEON', '[{\"nama\":\"Erland\",\"jabatan\":\"IT\",\"hp\":\"1234\",\"email\":\"erland3112@gmail.com\"}]', '2026-05-26 03:55:01', '2026-05-26 03:55:01'),
(3, 4, 4, 'Pembahasan Aplikasi: Sistem Managemen Aplikasi', '2026-05-26', '07:58 - Selesai', 'Ruang Rapat / Online', '[{\"nama\":\"Fitri Rosari\",\"jabatan\":\"User\",\"hp\":\"112233\",\"email\":\"nyanya@gmail.com\"},{\"nama\":\"Erland Radithya Putra Priono\",\"jabatan\":\"PIC Proyek\",\"hp\":\"223344\",\"email\":\"atata@gmail.com\"},{\"nama\":\"Rendi\",\"jabatan\":\"IT\",\"hp\":\"1234\",\"email\":\"adada@gmail.com\"}]', '2026-05-26 08:00:40', '2026-05-26 08:00:40'),
(4, NULL, 9, 'rapat', '2026-06-07', '12.00', 'PT SURVEYOR INDONESIA', '[{\"nama\":\"Lando\",\"jabatan\":\"IT\",\"hp\":\"313123\",\"email\":\"pipi@gmail.com\"}]', '2026-06-07 12:45:13', '2026-06-07 12:45:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aplikasi_master`
--

CREATE TABLE `aplikasi_master` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_app` varchar(255) DEFAULT NULL,
  `pic_id` int(11) DEFAULT NULL,
  `divisi_id` int(11) DEFAULT NULL,
  `status` enum('Development','Production','Maintenance') DEFAULT 'Development',
  `deskripsi` text DEFAULT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_target` date DEFAULT NULL,
  `versi_current` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `sdlc_checklist` text DEFAULT NULL,
  `delete_request` tinyint(1) DEFAULT 0,
  `delete_reason` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aplikasi_master`
--

INSERT INTO `aplikasi_master` (`id`, `nama_app`, `pic_id`, `divisi_id`, `status`, `deskripsi`, `tgl_mulai`, `tgl_target`, `versi_current`, `created_at`, `updated_at`, `sdlc_checklist`, `delete_request`, `delete_reason`) VALUES
(12, 'SIMPA Enterprise', 7, 19, 'Production', 'Sistem Informasi Manajemen Proyek Aplikasi PT Surveyor Indonesia', '2025-01-01', '2026-07-31', '1.0.0', '2026-06-04 02:27:00', '2026-06-04 02:27:00', NULL, 0, NULL),
(13, 'HCIS (Human Capital)', 8, 21, 'Production', 'Human Capital Information System untuk rekrutmen dan penggajian', '2024-05-10', '2025-12-31', '2.1.4', '2026-06-04 02:27:00', '2026-06-04 02:27:00', NULL, 0, NULL),
(14, 'E-Procurement Surveyor', 7, 26, 'Development', 'Aplikasi tender dan pengadaan barang/jasa perusahaan', '2026-01-15', '2026-10-30', '0.5.0', '2026-06-04 02:27:00', '2026-06-04 02:27:00', NULL, 0, NULL),
(15, 'Nadine (Naskah Dinas Elektronik)', 8, 24, 'Production', 'Aplikasi persuratan digital terpusat BUMN', '2023-08-20', '2024-01-01', '3.0.1', '2026-06-04 02:27:00', '2026-06-04 02:27:00', NULL, 0, NULL),
(16, 'M-Survey Mobile', 7, 23, 'Development', 'Aplikasi mobile untuk surveyor lapangan terintegrasi GPS', '2026-03-01', '2026-12-15', '0.8.2', '2026-06-04 02:27:00', '2026-06-04 02:27:00', NULL, 0, NULL),
(17, 'SIMKeu Terpadu', 8, 20, 'Maintenance', 'Sistem Informasi Keuangan dan Akuntansi', '2022-01-01', '2022-12-31', '5.2.0', '2026-06-04 02:27:00', '2026-06-04 02:27:00', NULL, 0, NULL),
(18, 'Aplikasi Pemasaran SFA', 5, 19, 'Development', 'Sales Force Automation untuk Divisi Pengembangan Bisnis', '2026-05-01', '2027-01-01', '0.1.0', '2026-06-04 02:27:00', '2026-06-25 06:16:46', NULL, 0, NULL),
(19, 'PTSI', 5, 19, 'Development', 'Aplikasi PT Surveyor Indonesia', '2026-06-09', '2026-06-09', NULL, '2026-06-09 03:16:09', '2026-06-09 03:16:09', '[\"8\"]', 0, NULL),
(20, 'PTSI', 5, 19, 'Maintenance', 'sdsdadasd', '2026-06-18', '2026-06-18', NULL, '2026-06-18 08:10:58', '2026-06-25 06:13:56', NULL, 0, NULL),
(21, 'PTSI', 5, 19, 'Development', 'dasdasdadasdasdsadasdasdasdasdasdasdasdasdasddasdassdasd', '2026-06-19', '2026-06-19', NULL, '2026-06-19 11:48:16', '2026-06-25 06:13:22', NULL, 0, NULL),
(22, 'SI Surveyor', 2, 19, 'Development', 'rerewrtrweww', '2026-06-22', '2026-06-23', NULL, '2026-06-21 17:56:12', '2026-06-21 17:56:12', '[\"8\"]', 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `aplikasi_modul`
--

CREATE TABLE `aplikasi_modul` (
  `id` int(11) UNSIGNED NOT NULL,
  `aplikasi_id` int(11) UNSIGNED NOT NULL,
  `nama_modul` varchar(255) NOT NULL,
  `bobot_kesulitan` int(11) DEFAULT 1,
  `persentase` int(11) DEFAULT 0,
  `status` enum('Pending','In Progress','Done') DEFAULT 'Pending',
  `tgl_mulai` date DEFAULT NULL,
  `tgl_target` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aplikasi_modul`
--

INSERT INTO `aplikasi_modul` (`id`, `aplikasi_id`, `nama_modul`, `bobot_kesulitan`, `persentase`, `status`, `tgl_mulai`, `tgl_target`, `created_at`, `updated_at`) VALUES
(7, 12, 'Autentikasi & Otorisasi', 10, 100, 'Pending', NULL, NULL, '2026-06-04 02:27:00', '2026-06-04 02:27:00'),
(8, 12, 'Dashboard Executive', 20, 100, 'Pending', NULL, NULL, '2026-06-04 02:27:00', '2026-06-04 02:27:00'),
(9, 12, 'Master Data Management', 30, 100, 'Pending', NULL, NULL, '2026-06-04 02:27:00', '2026-06-04 02:27:00'),
(10, 12, 'Integrasi API Client', 40, 50, 'Pending', NULL, NULL, '2026-06-04 02:27:00', '2026-06-04 02:27:00'),
(11, 19, 'wduyewuyedywu', 50, 100, 'Pending', NULL, NULL, NULL, '2026-06-09 03:16:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aset`
--

CREATE TABLE `aset` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_aset` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `pic` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `delete_request` tinyint(1) DEFAULT 0,
  `delete_reason` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aset`
--

INSERT INTO `aset` (`id`, `nama_aset`, `kategori`, `status`, `pic`, `deskripsi`, `created_at`, `updated_at`, `delete_request`, `delete_reason`) VALUES
(10, 'e-Billing System', 'Aplikasi Keuangan', 'Aktif', 'Budi Santoso', 'Sistem Penagihan Elektronik', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(11, 'Tax Management', 'Aplikasi Keuangan', 'Maintenance', 'Siti Aminah', 'Manajemen Pajak Perusahaan', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(12, 'Payroll System', 'Aplikasi Keuangan', 'Aktif', 'Siti Aminah', 'Sistem Penggajian Karyawan', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(13, 'Budgeting App', 'Aplikasi Keuangan', 'Development', 'Budi Santoso', 'Aplikasi Penyusunan Anggaran', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(14, 'SIMPA Enterprise', 'Aplikasi Manajemen', 'Aktif', 'Budi Santoso', 'Manajemen Proyek Aplikasi', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(15, 'Risk Management', 'Aplikasi Manajemen', 'Aktif', 'Siti Aminah', 'Sistem Manajemen Risiko', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(16, 'Asset Tracker', 'Aplikasi Manajemen', 'Maintenance', 'Budi Santoso', 'Pelacakan Aset Fisik', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(17, 'Document Controller', 'Aplikasi Manajemen', 'Aktif', 'Siti Aminah', 'Pengendali Dokumen Mutu', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(18, 'M-Survey', 'Aplikasi Mobile', 'Maintenance', 'Budi Santoso', 'Mobile Field Survey', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(19, 'MySurveyor App', 'Aplikasi Mobile', 'Aktif', 'Siti Aminah', 'Aplikasi Employee Self Service', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(20, 'Sales Force Mobile', 'Aplikasi Mobile', 'Development', 'Budi Santoso', 'Aplikasi Tenaga Penjualan', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(21, 'E-Procurement Surveyor', 'Aplikasi Pengadaan', 'Maintenance', 'Budi Santoso', 'Sistem Lelang / Tender', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(22, 'Vendor Management', 'Aplikasi Pengadaan', 'Aktif', 'Siti Aminah', 'Manajemen Data Vendor', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(23, 'Nadine', 'Aplikasi Perkantoran', 'Aktif', 'Siti Aminah', 'Naskah Dinas Elektronik', '2026-06-04 02:27:00', '2026-06-04 02:27:00', 0, NULL),
(26, 'SI Surveyor', 'Data', 'Aktif', 'rendi', 'rerewrtrweww', '2026-06-21 17:55:26', '2026-06-21 17:55:26', 0, NULL),
(27, 'PPTSI', 'Server', 'Aktif', 'Kevin', 'Aplikasi Server PTSI', '2026-06-24 02:30:01', '2026-06-24 02:30:01', 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_divisi` varchar(20) DEFAULT NULL,
  `nama_divisi` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id`, `kode_divisi`, `nama_divisi`, `created_at`, `updated_at`) VALUES
(19, 'DTI', 'Teknologi Informasi', NULL, NULL),
(20, 'DAK', 'Akuntansi & Keuangan', NULL, NULL),
(21, 'SDM', 'Sumber Daya Manusia', NULL, NULL),
(22, 'DPB', 'Pengembangan Bisnis', NULL, NULL),
(23, 'DOP', 'Operasi', NULL, NULL),
(24, 'SEC', 'Sekretariat Perusahaan', NULL, NULL),
(25, 'HUK', 'Hukum (Legal)', NULL, NULL),
(26, 'PENG', 'Pengadaan (Procurement)', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `implementasi_data`
--

CREATE TABLE `implementasi_data` (
  `id` int(11) UNSIGNED NOT NULL,
  `aplikasi_id` int(11) DEFAULT NULL,
  `tgl_rilis` date DEFAULT NULL,
  `lingkungan` enum('Staging','Production') DEFAULT 'Production',
  `changelog` text DEFAULT NULL,
  `url_akses` varchar(255) DEFAULT NULL,
  `petugas_it` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `implementasi_data`
--

INSERT INTO `implementasi_data` (`id`, `aplikasi_id`, `tgl_rilis`, `lingkungan`, `changelog`, `url_akses`, `petugas_it`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-05-26', 'Production', 'dadas', '', 'rendi', '2026-05-26 03:31:12', NULL),
(2, 2, '2026-05-26', 'Production', 'fsdfsdfs', '', 'rendi', '2026-05-26 03:49:10', NULL),
(3, 19, '2026-06-10', 'Production', 'twtwtwt', 'https://www.ptsi.co.id/', 'Kevin', '2026-06-09 03:18:06', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_cobit_19`
--

CREATE TABLE `master_cobit_19` (
  `id` int(11) UNSIGNED NOT NULL,
  `domain` varchar(100) DEFAULT 'SDLC',
  `kode_proses` varchar(10) DEFAULT NULL,
  `nama_proses` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tujuan_audit` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `master_cobit_19`
--

INSERT INTO `master_cobit_19` (`id`, `domain`, `kode_proses`, `nama_proses`, `deskripsi`, `tujuan_audit`, `created_at`, `updated_at`) VALUES
(1, 'SDLC Monitoring', 'C1', 'Permintaan Pengembangan', NULL, NULL, '2026-05-26 02:30:37', NULL),
(2, 'SDLC Monitoring', 'C2', 'Persetujuan Pengembangan', NULL, NULL, '2026-05-26 02:30:37', NULL),
(3, 'SDLC Monitoring', 'C3', 'Perencanaan Proyek', NULL, NULL, '2026-05-26 02:30:37', NULL),
(4, 'SDLC Monitoring', 'C4', 'Perencanaan Kebutuhan', NULL, NULL, '2026-05-26 02:30:37', NULL),
(5, 'SDLC Monitoring', 'C5', 'Analisis Desain', NULL, NULL, '2026-05-26 02:30:37', NULL),
(6, 'SDLC Monitoring', 'C6', 'Quality Assurance Testing', NULL, NULL, '2026-05-26 02:30:37', NULL),
(7, 'SDLC Monitoring', 'C7', 'User Acceptance Testing (UAT)', NULL, NULL, '2026-05-26 02:30:37', NULL),
(8, 'SDLC Monitoring', 'C8', 'Serah Terima Aplikasi', NULL, NULL, '2026-05-26 02:30:37', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_kpi`
--

CREATE TABLE `master_kpi` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_kpi` varchar(255) DEFAULT NULL,
  `target` decimal(10,2) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `divisi_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `master_kpi`
--

INSERT INTO `master_kpi` (`id`, `nama_kpi`, `target`, `satuan`, `tahun`, `divisi_id`, `created_at`, `updated_at`) VALUES
(9, 'Uptime Server & Aplikasi Utama', 99.90, '%', '2026', 19, '2026-06-04 02:27:00', NULL),
(10, 'Kecepatan Penanganan Tiket IT (SLA)', 90.00, '%', '2026', 19, '2026-06-04 02:27:00', NULL),
(11, 'Penyelesaian Proyek IT Tepat Waktu', 85.00, '%', '2026', 19, '2026-06-04 02:27:00', NULL),
(12, 'Tingkat Ketersediaan Backup Data', 100.00, '%', '2026', 19, '2026-06-04 02:27:00', NULL),
(13, 'Tingkat Keamanan Siber (Security Score)', 95.00, 'Poin', '2026', 19, '2026-06-04 02:27:00', NULL),
(14, 'Tingkat Kepuasan Layanan IT', 4.50, 'Skala 5', '2026', 19, '2026-06-04 02:27:00', NULL),
(15, 'Pencapaian Pendapatan Divisi', 100.00, '%', '2026', 23, '2026-06-04 02:27:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `judul`, `pesan`, `is_read`, `created_at`) VALUES
(1, 1, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 24. Alasan: aplikasi sudah tidak terpakai lagi', 0, '2026-06-25 05:11:31'),
(2, 3, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 24. Alasan: aplikasi sudah tidak terpakai lagi', 1, '2026-06-25 05:11:31'),
(3, 6, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 24. Alasan: aplikasi sudah tidak terpakai lagi', 0, '2026-06-25 05:11:31'),
(4, 10, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 24. Alasan: aplikasi sudah tidak terpakai lagi', 1, '2026-06-25 05:11:31'),
(5, 5, 'Penghapusan Aplikasi Disetujui', 'Pengajuan penghapusan aplikasi Anda telah disetujui oleh Admin/PM.', 1, '2026-06-25 05:12:18'),
(6, 1, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 19. Alasan: sudah ada pengganti nya', 0, '2026-06-25 05:14:04'),
(7, 3, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 19. Alasan: sudah ada pengganti nya', 1, '2026-06-25 05:14:04'),
(8, 6, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 19. Alasan: sudah ada pengganti nya', 0, '2026-06-25 05:14:04'),
(9, 10, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 19. Alasan: sudah ada pengganti nya', 1, '2026-06-25 05:14:04'),
(10, 1, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 25. Alasan: rusak', 0, '2026-06-25 05:18:39'),
(11, 3, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 25. Alasan: rusak', 1, '2026-06-25 05:18:39'),
(12, 6, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 25. Alasan: rusak', 0, '2026-06-25 05:18:39'),
(13, 10, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 25. Alasan: rusak', 1, '2026-06-25 05:18:39'),
(14, 5, 'Penghapusan Aplikasi Disetujui', 'Pengajuan penghapusan aplikasi Anda telah disetujui oleh Admin/PM.', 0, '2026-06-25 05:26:38'),
(15, 5, 'Penghapusan Aplikasi Ditolak', 'Pengajuan penghapusan aplikasi Anda ditolak oleh Admin/PM.', 0, '2026-06-25 05:26:48'),
(16, 1, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 19. Alasan: sudah ada pengganti', 0, '2026-06-25 05:50:02'),
(17, 3, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 19. Alasan: sudah ada pengganti', 1, '2026-06-25 05:50:02'),
(18, 6, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 19. Alasan: sudah ada pengganti', 0, '2026-06-25 05:50:02'),
(19, 10, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 19. Alasan: sudah ada pengganti', 1, '2026-06-25 05:50:02'),
(20, 5, 'Penghapusan Aplikasi Ditolak', 'Pengajuan penghapusan aplikasi Anda ditolak oleh Admin/PM.', 0, '2026-06-25 05:51:04'),
(21, 1, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 20. Alasan: sudah tidak terpakai dan tidak terupdate lagi', 0, '2026-06-25 06:34:06'),
(22, 3, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 20. Alasan: sudah tidak terpakai dan tidak terupdate lagi', 0, '2026-06-25 06:34:06'),
(23, 6, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 20. Alasan: sudah tidak terpakai dan tidak terupdate lagi', 0, '2026-06-25 06:34:06'),
(24, 10, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 20. Alasan: sudah tidak terpakai dan tidak terupdate lagi', 0, '2026-06-25 06:34:06'),
(25, 5, 'Penghapusan Aplikasi Ditolak', 'Pengajuan penghapusan aplikasi Anda ditolak oleh Admin/PM.', 0, '2026-06-25 06:34:49'),
(26, 1, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 18. Alasan: sudah tidak terpakai dengan alasan tidak dapet update lagi', 0, '2026-06-25 06:38:40'),
(27, 3, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 18. Alasan: sudah tidak terpakai dengan alasan tidak dapet update lagi', 0, '2026-06-25 06:38:40'),
(28, 6, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 18. Alasan: sudah tidak terpakai dengan alasan tidak dapet update lagi', 0, '2026-06-25 06:38:40'),
(29, 10, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 18. Alasan: sudah tidak terpakai dengan alasan tidak dapet update lagi', 0, '2026-06-25 06:38:40'),
(30, 1, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 27. Alasan: suda tida diunakan', 0, '2026-06-29 07:01:07'),
(31, 3, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 27. Alasan: suda tida diunakan', 0, '2026-06-29 07:01:07'),
(32, 6, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 27. Alasan: suda tida diunakan', 0, '2026-06-29 07:01:07'),
(33, 10, 'Pengajuan Penghapusan Aplikasi', 'Kevin mengajukan penghapusan aplikasi ID: 27. Alasan: suda tida diunakan', 0, '2026-06-29 07:01:07'),
(34, 5, 'Penghapusan Aplikasi Ditolak', 'Pengajuan penghapusan aplikasi Anda ditolak oleh Admin/PM.', 0, '2026-07-02 04:31:43'),
(35, 5, 'Penghapusan Aplikasi Ditolak', 'Pengajuan penghapusan aplikasi Anda ditolak oleh Admin/PM.', 0, '2026-07-02 04:31:47'),
(36, 5, 'Penghapusan Aplikasi Ditolak', 'Pengajuan penghapusan aplikasi Anda ditolak oleh Admin/PM.', 0, '2026-07-02 04:40:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notula_rapat`
--

CREATE TABLE `notula_rapat` (
  `id` int(11) UNSIGNED NOT NULL,
  `aplikasi_id` int(11) UNSIGNED DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `no_dokumen` varchar(100) DEFAULT NULL,
  `revisi` varchar(50) DEFAULT NULL,
  `tgl_revisi` date DEFAULT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `status` enum('Draft','Final') DEFAULT 'Draft',
  `is_approved` tinyint(1) DEFAULT 0,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `pembahasan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pembahasan`)),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `approval_method` varchar(20) DEFAULT 'manual',
  `approval_user1_id` int(11) UNSIGNED DEFAULT NULL,
  `approval_user2_id` int(11) UNSIGNED DEFAULT NULL,
  `doc_status` varchar(20) DEFAULT 'draft',
  `revision_notes` text DEFAULT NULL,
  `approval_history` text DEFAULT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL,
  `attendance_list` text DEFAULT NULL,
  `agenda` varchar(255) DEFAULT NULL,
  `peserta` text DEFAULT NULL,
  `hasil_pembahasan` text DEFAULT NULL,
  `nama_disiapkan` varchar(100) DEFAULT NULL,
  `jabatan_disiapkan` varchar(100) DEFAULT NULL,
  `nama_setuju1` varchar(100) DEFAULT NULL,
  `jabatan_setuju1` varchar(100) DEFAULT NULL,
  `is_approved1` tinyint(1) DEFAULT 0,
  `nama_setuju2` varchar(100) DEFAULT NULL,
  `jabatan_setuju2` varchar(100) DEFAULT NULL,
  `is_approved2` tinyint(1) DEFAULT 0,
  `is_final` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notula_rapat`
--

INSERT INTO `notula_rapat` (`id`, `aplikasi_id`, `user_id`, `no_dokumen`, `revisi`, `tgl_revisi`, `tanggal`, `tempat`, `status`, `is_approved`, `approved_by`, `approved_at`, `pembahasan`, `created_at`, `updated_at`, `approval_method`, `approval_user1_id`, `approval_user2_id`, `doc_status`, `revision_notes`, `approval_history`, `parent_id`, `attendance_list`, `agenda`, `peserta`, `hasil_pembahasan`, `nama_disiapkan`, `jabatan_disiapkan`, `nama_setuju1`, `jabatan_setuju1`, `is_approved1`, `nama_setuju2`, `jabatan_setuju2`, `is_approved2`, `is_final`) VALUES
(1, 1, 8, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 03:06:09', NULL, 'manual', NULL, NULL, 'final', NULL, '[{\"timestamp\":\"2026-05-26T03:15:31+00:00\",\"user_id\":\"8\",\"user_name\":\"rendi wijaya\",\"action\":\"approved_by_1\",\"target\":\"notula\",\"doc_status\":\"draft\"},{\"timestamp\":\"2026-05-26T03:15:33+00:00\",\"user_id\":\"8\",\"user_name\":\"rendi wijaya\",\"action\":\"approved_by_2\",\"target\":\"notula\",\"doc_status\":\"draft\"}]', NULL, '[{\"name\":\"rendi wijaya\",\"role\":\"User\",\"status\":\"Hadir\"}]', 'Pembahasan Proyek: SIMPA Enterprise', 'rendi wijaya (IT), PM (PM), Tim Terkait', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi SIMPA Enterprise\",\"pic\":\"\",\"target\":\"\"}]', 'rendi wijaya', 'User', '', 'Project Manager', 1, '', 'Manajer Divisi ', 1, 1),
(2, 1, 8, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 03:16:51', NULL, 'manual', NULL, NULL, 'draft', NULL, NULL, NULL, '[]', 'Pembahasan Proyek: SIMPA Enterprise', 'rendi wijaya (IT), PM (PM), Tim Terkait', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi SIMPA Enterprise\",\"pic\":\"rendi wijaya\",\"target\":\"2026-05-26\"}]', 'rendi wijaya', 'User', '', 'Project Manager', 0, '', 'Manajer Divisi ', 0, 0),
(3, 1, 8, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 03:17:19', NULL, 'manual', 1, 1, 'draft', NULL, NULL, NULL, '[]', 'Quick MoM: SIMPA Enterprise', 'rendi wijaya (IT), PM (PM), Tim Terkait', '[{\"item\":\"01\",\"hasil\":\"Ringkasan hasil rapat dan keputusan utama\",\"pic\":\"rendi wijaya\",\"target\":\"2026-06-02\"},{\"item\":\"02\",\"hasil\":\"Tindak lanjut sistem \\/ aplikasi yang dibahas\",\"pic\":\"rendi wijaya\",\"target\":\"2026-06-09\"},{\"item\":\"03\",\"hasil\":\"Rencana komunikasi dan notifikasi kepada pemangku kepentingan\",\"pic\":\"Tim IT\",\"target\":\"2026-06-16\"}]', 'rendi wijaya', 'User', 'Administrator', 'Admin', 0, 'Administrator', 'Admin', 0, 0),
(4, 2, 2, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 03:54:04', '2026-07-02 04:49:40', 'manual', 3, 2, 'approved', NULL, NULL, NULL, '[]', 'Pembahasan Proyek: Aplikasi Monitoring', 'rendi (IT), rendi (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi Aplikasi Monitoring\",\"pic\":\"rendi\",\"target\":\"2026-05-26\"}]', 'rendi', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'rendi', 'User', 1, 1),
(5, 2, 2, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 03:57:42', '2026-07-02 04:49:36', 'manual', 3, 2, 'approved', NULL, NULL, NULL, '[]', 'Quick MoM: Aplikasi Monitoring', 'rendi (IT), rendi (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Ringkasan hasil rapat dan keputusan utama\",\"pic\":\"rendi\",\"target\":\"2026-06-02\"},{\"item\":\"02\",\"hasil\":\"Tindak lanjut sistem \\/ aplikasi yang dibahas\",\"pic\":\"rendi\",\"target\":\"2026-06-09\"},{\"item\":\"03\",\"hasil\":\"Rencana komunikasi dan notifikasi kepada pemangku kepentingan\",\"pic\":\"Tim IT\",\"target\":\"2026-06-16\"}]', 'rendi', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'rendi', 'User', 1, 1),
(6, 4, 4, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 07:54:32', NULL, 'automatic', 3, 2, 'final', NULL, '[{\"timestamp\":\"2026-05-26T07:55:24+00:00\",\"user_id\":\"4\",\"user_name\":\"Fitri Rosari\",\"action\":\"approved_by_1\",\"target\":\"notula\",\"doc_status\":\"final\"},{\"timestamp\":\"2026-05-26T07:55:25+00:00\",\"user_id\":\"4\",\"user_name\":\"Fitri Rosari\",\"action\":\"approved_by_2\",\"target\":\"notula\",\"doc_status\":\"final\"}]', NULL, '[]', 'Pembahasan Proyek: Sistem Managemen Aplikasi', 'Fitri Rosari (IT), Fitri Rosari (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi Sistem Managemen Aplikasi\",\"pic\":\"Fitri Rosari\",\"target\":\"2026-05-26\"}]', 'Fitri Rosari', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'rendi', 'User', 1, 1),
(7, 4, 4, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 07:54:55', NULL, 'manual', NULL, NULL, 'draft', NULL, NULL, NULL, '[]', 'Pembahasan Proyek: Sistem Managemen Aplikasi', 'Fitri Rosari (IT), Fitri Rosari (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi Sistem Managemen Aplikasi\",\"pic\":\"Fitri Rosari\",\"target\":\"2026-05-26\"}]', 'Fitri Rosari', 'User', 'Fitri Rosari', 'Project Manager', 0, '', 'Manajer Divisi Teknologi Informasi', 0, 0),
(8, 4, 4, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 07:56:39', '2026-07-02 04:49:30', 'manual', 3, 2, 'approved', NULL, NULL, NULL, '[]', 'Quick MoM: Sistem Managemen Aplikasi', 'Fitri Rosari (IT), Fitri Rosari (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Ringkasan hasil rapat dan keputusan utama\",\"pic\":\"Fitri Rosari\",\"target\":\"2026-06-02\"},{\"item\":\"02\",\"hasil\":\"Tindak lanjut sistem \\/ aplikasi yang dibahas\",\"pic\":\"Fitri Rosari\",\"target\":\"2026-06-09\"},{\"item\":\"03\",\"hasil\":\"Rencana komunikasi dan notifikasi kepada pemangku kepentingan\",\"pic\":\"Tim IT\",\"target\":\"2026-06-16\"}]', 'Fitri Rosari', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'rendi', 'User', 1, 1),
(9, 4, 4, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 07:56:47', NULL, 'automatic', 4, NULL, 'final', NULL, '[{\"timestamp\":\"2026-05-26T07:57:35+00:00\",\"user_id\":\"4\",\"user_name\":\"Fitri Rosari\",\"action\":\"approved_by_1\",\"target\":\"notula\",\"doc_status\":\"draft\"},{\"timestamp\":\"2026-05-26T07:57:44+00:00\",\"user_id\":\"4\",\"user_name\":\"Fitri Rosari\",\"action\":\"approved_by_2\",\"target\":\"notula\",\"doc_status\":\"draft\"}]', NULL, '[]', 'Quick MoM: Sistem Managemen Aplikasi', 'Fitri Rosari (IT), Fitri Rosari (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Ringkasan hasil rapat dan keputusan utama\",\"pic\":\"Fitri Rosari\",\"target\":\"2026-06-02\"},{\"item\":\"02\",\"hasil\":\"Tindak lanjut sistem \\/ aplikasi yang dibahas\",\"pic\":\"Fitri Rosari\",\"target\":\"2026-06-09\"},{\"item\":\"03\",\"hasil\":\"Rencana komunikasi dan notifikasi kepada pemangku kepentingan\",\"pic\":\"Tim IT\",\"target\":\"2026-06-16\"}]', 'Fitri Rosari', 'User', 'Fitri Rosari', 'Project Manager', 1, '', 'Manajer Divisi Teknologi Informasi', 1, 1),
(10, 4, 4, NULL, NULL, NULL, '2026-05-26', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-05-26 08:08:34', NULL, 'automatic', 3, 2, 'final', NULL, '[{\"timestamp\":\"2026-05-26T08:09:04+00:00\",\"user_id\":\"4\",\"user_name\":\"Fitri Rosari\",\"action\":\"approved_by_1\",\"target\":\"notula\",\"doc_status\":\"final\"},{\"timestamp\":\"2026-05-26T08:09:05+00:00\",\"user_id\":\"4\",\"user_name\":\"Fitri Rosari\",\"action\":\"approved_by_2\",\"target\":\"notula\",\"doc_status\":\"final\"}]', NULL, '[]', 'Quick MoM: Sistem Managemen Aplikasi', 'Fitri Rosari (IT), Fitri Rosari (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Ringkasan hasil rapat dan keputusan utama\",\"pic\":\"Fitri Rosari\",\"target\":\"2026-06-02\"},{\"item\":\"02\",\"hasil\":\"Tindak lanjut sistem \\/ aplikasi yang dibahas\",\"pic\":\"Fitri Rosari\",\"target\":\"2026-06-09\"},{\"item\":\"03\",\"hasil\":\"Rencana komunikasi dan notifikasi kepada pemangku kepentingan\",\"pic\":\"Tim IT\",\"target\":\"2026-06-16\"}]', 'Fitri Rosari', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'rendi', 'User', 1, 1),
(11, 13, 8, NULL, NULL, NULL, '2026-06-04', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-06-04 02:41:59', NULL, 'automatic', 3, 6, 'final', NULL, '[{\"timestamp\":\"2026-06-04T02:43:08+00:00\",\"user_id\":\"8\",\"user_name\":\"Siti Aminah\",\"action\":\"approved_by_1\",\"target\":\"notula\",\"doc_status\":\"final\"},{\"timestamp\":\"2026-06-04T02:43:09+00:00\",\"user_id\":\"8\",\"user_name\":\"Siti Aminah\",\"action\":\"approved_by_2\",\"target\":\"notula\",\"doc_status\":\"final\"}]', NULL, '[]', 'Pembahasan Proyek: HCIS (Human Capital)', 'Siti Aminah (IT), Siti Aminah (PM), Tim Sumber Daya Manusia', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi HCIS (Human Capital)\",\"pic\":\"Siti Aminah\",\"target\":\"2026-06-04\"}]', 'Siti Aminah', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'Rendy Wijaya', 'Admin', 1, 1),
(12, 19, 5, NULL, NULL, NULL, '2026-06-09', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-06-09 08:42:37', NULL, 'automatic', 3, 10, 'final', NULL, '[{\"timestamp\":\"2026-06-09T08:43:12+00:00\",\"user_id\":\"5\",\"user_name\":\"Kevin\",\"action\":\"approved_by_1\",\"target\":\"notula\",\"doc_status\":\"final\"},{\"timestamp\":\"2026-06-09T08:43:14+00:00\",\"user_id\":\"5\",\"user_name\":\"Kevin\",\"action\":\"approved_by_2\",\"target\":\"notula\",\"doc_status\":\"final\"}]', NULL, '[]', 'Pembahasan Proyek: PTSI', 'Kevin (IT), Kevin (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi PTSI\",\"pic\":\"Kevin\",\"target\":\"2026-06-10\"}]', 'Kevin', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'Felicia Putri', 'PM', 1, 1),
(13, 19, 5, NULL, NULL, NULL, '2026-06-18', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-06-18 08:52:27', '2026-06-19 11:17:48', 'automatic', 3, 2, 'approved', NULL, NULL, NULL, '[]', 'Pembahasan Proyek: PTSI', 'Kevin (IT), Kevin (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi PTSI\",\"pic\":\"Kevin\",\"target\":\"\"}]', 'Kevin', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'rendi', 'User', 1, 1),
(14, 19, 5, NULL, NULL, NULL, '2026-06-19', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-06-19 12:25:01', '2026-06-21 18:05:58', 'automatic', 3, 6, 'approved', NULL, NULL, NULL, '[]', 'Quick MoM: PTSI', 'Kevin (IT), Kevin (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Ringkasan hasil rapat dan keputusan utama\",\"pic\":\"Kevin\",\"target\":\"2026-06-26\"},{\"item\":\"02\",\"hasil\":\"Tindak lanjut sistem \\/ aplikasi yang dibahas\",\"pic\":\"Kevin\",\"target\":\"2026-07-03\"},{\"item\":\"03\",\"hasil\":\"Rencana komunikasi dan notifikasi kepada pemangku kepentingan\",\"pic\":\"Tim IT\",\"target\":\"2026-07-10\"}]', 'Kevin', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'Rendy Wijaya', 'Admin', 1, 1),
(15, 19, 5, NULL, NULL, NULL, '2026-06-19', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-06-19 12:26:15', '2026-06-19 12:27:25', 'manual', NULL, 3, 'draft', NULL, NULL, NULL, '[]', 'Quick MoM: PTSI', 'Kevin (IT), Kevin (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Ringkasan hasil rapat dan keputusan utama\",\"pic\":\"Kevin\",\"target\":\"2026-06-26\"},{\"item\":\"02\",\"hasil\":\"Tindak lanjut sistem \\/ aplikasi yang dibahas\",\"pic\":\"Kevin\",\"target\":\"2026-07-03\"},{\"item\":\"03\",\"hasil\":\"Rencana komunikasi dan notifikasi kepada pemangku kepentingan\",\"pic\":\"Tim IT\",\"target\":\"2026-07-10\"}]', 'Kevin', 'User', 'Kevin', 'Project Manager', 0, 'Erland Radithya Putra Priono', 'Admin', 1, 0),
(16, 22, 2, NULL, NULL, NULL, '2026-06-21', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-06-21 18:02:17', '2026-06-21 18:05:52', 'automatic', 6, 3, 'approved', NULL, NULL, NULL, '[]', 'Pembahasan Proyek: SI Surveyor', 'rendi (IT), rendi (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi SI Surveyor\",\"pic\":\"rendi\",\"target\":\"2026-06-22\"}]', 'rendi', 'User', 'Rendy Wijaya', 'Admin', 1, 'Erland Radithya Putra Priono', 'Admin', 1, 1),
(17, 22, 2, NULL, NULL, NULL, '2026-06-21', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-06-21 18:07:48', '2026-06-21 18:08:53', 'manual', 6, 3, 'approved', NULL, NULL, NULL, '[]', 'Quick MoM: SI Surveyor', 'rendi (IT), rendi (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Ringkasan hasil rapat dan keputusan utama\",\"pic\":\"rendi\",\"target\":\"2026-06-28\"},{\"item\":\"02\",\"hasil\":\"Tindak lanjut sistem \\/ aplikasi yang dibahas\",\"pic\":\"rendi\",\"target\":\"2026-07-05\"},{\"item\":\"03\",\"hasil\":\"Rencana komunikasi dan notifikasi kepada pemangku kepentingan\",\"pic\":\"Tim IT\",\"target\":\"2026-07-12\"}]', 'rendi', 'User', 'Rendy Wijaya', 'Admin', 1, 'Erland Radithya Putra Priono', 'Admin', 1, 1),
(18, 19, 5, NULL, NULL, NULL, '2026-06-24', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-06-24 02:43:03', '2026-06-24 03:50:26', 'automatic', 3, 6, 'final', NULL, NULL, NULL, '[]', 'Pembahasan Proyek: PTSI', 'Kevin (IT), Kevin (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi PTSI\",\"pic\":\"Kevin\",\"target\":\"\"}]', 'Kevin', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'Rendy Wijaya', 'Admin', 0, 0),
(19, 19, 5, NULL, NULL, NULL, '2026-07-03', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-07-02 04:47:58', '2026-07-02 04:49:25', 'automatic', 2, 3, 'approved', NULL, NULL, NULL, '[]', 'Pembahasan Proyek: PTSI', 'Kevin (IT), Kevin (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi PTSI\",\"pic\":\"Kevin\",\"target\":\"\"}]', 'Kevin', 'User', 'Rendy Wijaya', 'User', 1, 'Erland Radithya Putra Priono', 'Admin', 1, 1),
(20, 19, 5, NULL, NULL, NULL, '2026-07-02', 'Ruang Rapat Utama', 'Draft', 0, NULL, NULL, NULL, '2026-07-02 04:59:30', '2026-07-02 05:01:17', 'manual', 3, 2, 'approved', NULL, NULL, NULL, '[]', 'Pembahasan Proyek: PTSI', 'Kevin (IT), Kevin (PM), Tim Teknologi Informasi', '[{\"item\":\"01\",\"hasil\":\"Review Progress Aplikasi PTSI\",\"pic\":\"Kevin\",\"target\":\"\"}]', 'Kevin', 'User', 'Erland Radithya Putra Priono', 'Admin', 1, 'Rendy Wijaya', 'User', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan_aplikasi`
--

CREATE TABLE `permintaan_aplikasi` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_app` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `latar_belakang` text DEFAULT NULL,
  `tgl_target` date DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `nama_disiapkan` varchar(100) DEFAULT NULL,
  `jabatan_disiapkan` varchar(100) DEFAULT NULL,
  `tgl_disiapkan` datetime DEFAULT NULL,
  `approval_user_id` int(11) UNSIGNED DEFAULT NULL,
  `nama_setuju` varchar(100) DEFAULT NULL,
  `jabatan_setuju` varchar(100) DEFAULT NULL,
  `tgl_setuju` datetime DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `doc_status` varchar(20) DEFAULT 'draft',
  `tgl_mulai_pengembangan` date DEFAULT NULL,
  `aplikasi_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `uraian_tambahan` text DEFAULT NULL,
  `lampiran` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `permintaan_aplikasi`
--

INSERT INTO `permintaan_aplikasi` (`id`, `nama_app`, `deskripsi`, `latar_belakang`, `tgl_target`, `user_id`, `nama_disiapkan`, `jabatan_disiapkan`, `tgl_disiapkan`, `approval_user_id`, `nama_setuju`, `jabatan_setuju`, `tgl_setuju`, `is_approved`, `doc_status`, `tgl_mulai_pengembangan`, `aplikasi_id`, `created_at`, `updated_at`, `uraian_tambahan`, `lampiran`) VALUES
(1, 'PTSI', 'sdsdadasd', 'dadasdada', '2026-06-18', 5, 'Kevin', 'User', '2026-06-18 07:55:32', 3, 'Erland Radithya Putra Priono', 'Admin', '2026-06-18 08:10:58', 1, 'approved', '2026-06-18', 20, '2026-06-18 07:55:32', '2026-06-18 08:10:58', NULL, NULL),
(2, 'PTSI', 'dasdasdadasdasdsadasdasdasdasdasdasdasdasdasddasdassdasd', 'sadsdasdasdasdasasasdasdasdsdasdasasdasdasdasdasdasdasdasdasdasdasd', '2026-06-19', 5, 'Kevin', 'User', '2026-06-19 11:44:40', 3, 'Erland Radithya Putra Priono', 'Admin', '2026-06-19 11:48:16', 1, 'approved', '2026-06-19', 21, '2026-06-19 11:44:40', '2026-06-19 11:48:16', 'asdasdasdasdsadddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd'),
(3, 'SI Surveyor', 'fasfasfafsfafasf', 'dasdasffasfa', '2026-06-22', 2, 'rendi', 'User', '2026-06-21 18:11:01', 6, 'Rendy Wijaya', 'Admin', '2026-06-21 18:11:44', 1, 'approved', '2026-06-21', 23, '2026-06-21 18:11:01', '2026-06-21 18:11:44', 'asfasfasfasfasfafaf', 'afasfafasfafsfasfaasf');

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
  `tgl_update` datetime DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `file_lampiran` varchar(255) DEFAULT NULL,
  `komentar_admin` text DEFAULT NULL,
  `cobit_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modul_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `progres_log`
--

INSERT INTO `progres_log` (`id`, `aplikasi_id`, `user_id`, `pesan_update`, `persentase`, `tgl_update`, `is_approved`, `file_lampiran`, `komentar_admin`, `cobit_id`, `updated_at`, `created_at`, `modul_id`) VALUES
(1, 1, 8, 'Mengajukan inisiasi awal dan perancangan database arsitektur SIMPA Enterprise.', 15, '2026-05-26 02:32:18', 2, 'sample_arsitektur.pdf', '', 1, '2026-05-26 03:31:55', NULL, NULL),
(2, 2, 2, 'fyfytfytfy', 100, '2026-05-26 03:51:16', 2, '1779767476_cd3d23c2150dfc4e83ce.png', '', 8, '2026-05-26 03:52:31', NULL, NULL),
(3, 4, 4, 'hgcdhgch', 100, '2026-05-26 07:51:13', 2, NULL, '', 8, '2026-05-26 07:52:49', NULL, NULL),
(4, 4, 4, 'yrdytrdyrdtrd', 100, '2026-05-26 08:04:24', 2, '1779782664_f49e9c0d337e1e4fb2e5.png', '', 8, '2026-05-26 08:05:11', NULL, NULL),
(5, 6, 8, 'dsdjsdjsdjdj', 50, '2026-06-04 02:21:27', 2, '1780539687_75f50d8260b8d5bd12db.png', '', 1, '2026-06-04 02:22:52', NULL, NULL),
(6, 13, 8, 'jseweiej', 100, '2026-06-04 02:39:06', 2, '1780540746_e841114e2ca5e20a7932.png', '', 8, '2026-06-04 02:40:14', NULL, NULL),
(7, 19, 5, 'uda selesai semua', 100, '2026-06-09 03:20:38', 2, '1780975238_2ca146d3d86834047bb3.png', 'approve', 8, '2026-06-09 08:25:09', NULL, 11),
(8, 22, 2, 'dgfdshgfdhsgfjdhs', 50, '2026-06-21 17:57:23', 2, '1782064643_e152e60e327f54855d13.png', 'hgfdghfe', NULL, '2026-06-21 17:58:15', NULL, NULL),
(9, 22, 2, 'eeqweqweqw', 100, '2026-06-21 17:59:28', 2, '1782064768_a54941dda83bfc3c75b2.jpeg', '', NULL, '2026-06-21 18:00:14', NULL, NULL),
(10, 24, 5, 'Suda memenui Permintaan Perusaaan', 100, '2026-06-24 02:33:07', 2, '1782268387_7a6b6fb6badbe7757a97.png', 'setuju', NULL, '2026-06-24 03:49:12', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `aksi` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `system_logs`
--

INSERT INTO `system_logs` (`id`, `user_id`, `username`, `aksi`, `keterangan`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 8, 'rendi', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: SIMPA Enterprise', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:06:10', NULL),
(2, 8, 'rendi', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: SIMPA Enterprise', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:16:51', NULL),
(3, 8, 'rendi', 'BUAT NOTULA', 'Menyimpan notula rapat: Quick MoM: SIMPA Enterprise', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:17:19', NULL),
(4, 1, 'admin', 'TAMBAH ASET', 'Menambahkan aset: Aplikasi Monitoring V1 (PIC: rendi)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:21:17', NULL),
(5, 1, 'admin', 'UPDATE KARYAWAN', 'Memperbarui data id: 2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:27:46', NULL),
(6, 1, 'admin', 'TAMBAH KARYAWAN', 'Menambahkan karyawan: Erland Radithya Putra Priono', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:29:03', NULL),
(7, 1, 'admin', 'UPDATE KARYAWAN', 'Memperbarui data id: 3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:29:19', NULL),
(8, 3, 'erland', 'RELEASE APP', 'Mencatat rilis aplikasi ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:31:12', NULL),
(9, 3, 'erland', 'APPROVE KADIV (TAHAP 1)', 'Meninjau progres log ID: 1. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:31:40', NULL),
(10, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 1. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:31:55', NULL),
(11, 3, 'erland', 'TAMBAH MASTER APP', 'Menambahkan aplikasi master: Aplikasi Monitoring', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:45:43', NULL),
(12, 3, 'erland', 'RELEASE APP', 'Mencatat rilis aplikasi ID: 2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:49:10', NULL),
(13, 2, 'rendi', 'UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: 2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:51:16', NULL),
(14, 3, 'erland', 'APPROVE KADIV (TAHAP 1)', 'Meninjau progres log ID: 2. Catatan: hghghg', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:52:24', NULL),
(15, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 2. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:52:31', NULL),
(16, 2, 'rendi', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: Aplikasi Monitoring', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:54:04', NULL),
(17, 2, 'rendi', 'BUAT NOTULA', 'Menyimpan notula rapat: Quick MoM: Aplikasi Monitoring', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 03:57:42', NULL),
(18, 2, 'rendi', 'TAMBAH MASTER APP', 'Menambahkan aplikasi master: Aplikasi Monitoring V1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 04:08:25', NULL),
(19, 3, 'erland', 'HAPUS ASET', 'Menghapus aset id: 3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:46:38', NULL),
(20, 3, 'erland', 'HAPUS ASET', 'Menghapus aset id: 3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:46:48', NULL),
(21, 3, 'erland', 'TAMBAH ASET', 'Menambahkan aset: Sistem Managemen Aplikasi (PIC: Fitri)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:47:30', NULL),
(22, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:48:53', NULL),
(23, 3, 'erland', 'TAMBAH MASTER APP', 'Menambahkan aplikasi master: Sistem Managemen Aplikasi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:49:37', NULL),
(24, 4, 'fitri', 'UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:51:13', NULL),
(25, 3, 'erland', 'APPROVE KADIV (TAHAP 1)', 'Meninjau progres log ID: 3. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:52:40', NULL),
(26, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 3. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:52:49', NULL),
(27, 4, 'fitri', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: Sistem Managemen Aplikasi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:54:32', NULL),
(28, 4, 'fitri', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: Sistem Managemen Aplikasi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:54:55', NULL),
(29, 4, 'fitri', 'BUAT NOTULA', 'Menyimpan notula rapat: Quick MoM: Sistem Managemen Aplikasi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:56:39', NULL),
(30, 4, 'fitri', 'BUAT NOTULA', 'Menyimpan notula rapat: Quick MoM: Sistem Managemen Aplikasi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 07:56:47', NULL),
(31, 4, 'fitri', 'UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 08:04:24', NULL),
(32, 3, 'erland', 'APPROVE KADIV (TAHAP 1)', 'Meninjau progres log ID: 4. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 08:05:04', NULL),
(33, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 4. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 08:05:11', NULL),
(34, 3, 'erland', 'TAMBAH ASET', 'Menambahkan aset: Aplikasi Rendering (PIC: Kevin)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 08:06:04', NULL),
(35, 3, 'erland', 'HAPUS ASET', 'Menghapus aset id: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 08:07:38', NULL),
(36, 4, 'fitri', 'BUAT NOTULA', 'Menyimpan notula rapat: Quick MoM: Sistem Managemen Aplikasi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 08:08:34', NULL),
(37, 3, 'erland', 'TAMBAH KARYAWAN', 'Menambahkan karyawan: Rendy Wijaya', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 08:15:14', NULL),
(38, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-26 08:15:35', NULL),
(39, 3, 'erland', 'TAMBAH KPI', 'Menambahkan KPI: ketersediaan layanan', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-01 08:58:18', NULL),
(40, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:15:48', NULL),
(41, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:16:05', NULL),
(42, 8, 'siti', 'UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: 6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:21:27', NULL),
(43, 3, 'erland', 'APPROVE KADIV (TAHAP 1)', 'Meninjau progres log ID: 5. Catatan: ddd', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:22:43', NULL),
(44, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 5. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:22:52', NULL),
(45, 8, 'siti', 'UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: 13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:39:06', NULL),
(46, 3, 'erland', 'APPROVE KADIV (TAHAP 1)', 'Meninjau progres log ID: 6. Catatan: thhhbh', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:40:05', NULL),
(47, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 6. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:40:14', NULL),
(48, 8, 'siti', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: HCIS (Human Capital)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 02:41:59', NULL),
(49, 3, 'erland', 'TAMBAH KARYAWAN', 'Menambahkan karyawan: Lando Putra Priono', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 03:02:45', NULL),
(50, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 03:02:55', NULL),
(51, 3, 'erland', 'TAMBAH KARYAWAN', 'Menambahkan karyawan: Felicia Putri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 03:10:11', NULL),
(52, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-04 03:11:35', NULL),
(53, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-07 12:33:18', NULL),
(54, 3, 'erland', 'TAMBAH APLIKASI', 'Menambahkan aplikasi: PTSI (PIC: Kevin)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-09 02:50:14', NULL),
(55, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-09 03:14:28', NULL),
(56, 3, 'erland', 'TAMBAH MASTER APP', 'Menambahkan aplikasi master: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-09 03:16:09', NULL),
(57, 3, 'erland', 'RELEASE APP', 'Mencatat rilis aplikasi ID: 19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-09 03:18:06', NULL),
(58, 5, 'kevin', 'UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: 19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-09 03:20:38', NULL),
(59, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 7. Catatan: approve', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-09 08:25:09', NULL),
(60, 5, 'kevin', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-06-09 08:42:37', NULL),
(61, 5, 'kevin', 'PERMINTAAN APLIKASI', 'Mengajukan/Mengupdate permintaan aplikasi: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-18 07:55:32', NULL),
(62, 3, 'erland', 'APPROVE PERMINTAAN', 'Menyetujui permintaan aplikasi: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-18 08:10:59', NULL),
(63, 5, 'kevin', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-18 08:52:27', NULL),
(64, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 13 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 11:17:09', NULL),
(65, 2, 'rendi', 'APPROVE NOTULA', 'Menyetujui notula ID: 13 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 11:17:48', NULL),
(66, 5, 'kevin', 'PERMINTAAN APLIKASI', 'Mengajukan/Mengupdate permintaan aplikasi: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 11:44:40', NULL),
(67, 3, 'erland', 'APPROVE PERMINTAAN', 'Menyetujui permintaan aplikasi: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 11:48:16', NULL),
(68, 5, 'kevin', 'BUAT NOTULA', 'Menyimpan notula rapat: Quick MoM: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 12:25:01', NULL),
(69, 5, 'kevin', 'BUAT NOTULA', 'Menyimpan notula rapat: Quick MoM: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 12:26:15', NULL),
(70, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 15 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 12:27:25', NULL),
(71, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 14 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 12:27:32', NULL),
(72, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 5 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 12:27:36', NULL),
(73, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 8 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 12:27:40', NULL),
(74, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 4 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-19 12:27:43', NULL),
(75, 3, 'erland', 'TAMBAH APLIKASI', 'Menambahkan aplikasi: Surveyor Web (PIC: Kevin)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 17:26:29', NULL),
(76, 3, 'erland', 'TAMBAH APLIKASI', 'Menambahkan aplikasi: SI Surveyor (PIC: rendi)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 17:55:26', NULL),
(77, 3, 'erland', 'TAMBAH MASTER APP', 'Menambahkan aplikasi master: SI Surveyor', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 17:56:12', NULL),
(78, 2, 'rendi', 'UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: 22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 17:57:23', NULL),
(79, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 8. Catatan: hgfdghfe', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 17:58:15', NULL),
(80, 2, 'rendi', 'UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: 22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 17:59:28', NULL),
(81, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 9. Catatan: ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:00:14', NULL),
(82, 2, 'rendi', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: SI Surveyor', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:02:17', NULL),
(83, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 16 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:03:36', NULL),
(84, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:05:13', NULL),
(85, 6, 'rendy', 'APPROVE NOTULA', 'Menyetujui notula ID: 16 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:05:52', NULL),
(86, 6, 'rendy', 'APPROVE NOTULA', 'Menyetujui notula ID: 14 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:05:58', NULL),
(87, 2, 'rendi', 'BUAT NOTULA', 'Menyimpan notula rapat: Quick MoM: SI Surveyor', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:07:48', NULL),
(88, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 17 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:08:27', NULL),
(89, 6, 'rendy', 'APPROVE NOTULA', 'Menyetujui notula ID: 17 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:08:53', NULL),
(90, 2, 'rendi', 'PERMINTAAN APLIKASI', 'Mengajukan/Mengupdate permintaan aplikasi: SI Surveyor', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:11:01', NULL),
(91, 6, 'rendy', 'APPROVE PERMINTAAN', 'Menyetujui permintaan aplikasi: SI Surveyor', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-21 18:11:44', NULL),
(92, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-23 08:08:41', NULL),
(93, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-23 08:10:13', NULL),
(94, 3, 'erland', 'UPDATE KARYAWAN', 'Memperbarui data id: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-23 08:11:39', NULL),
(95, 3, 'erland', 'TAMBAH APLIKASI', 'Menambahkan aplikasi: PPTSI (PIC: Kevin)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-24 02:30:01', NULL),
(96, 3, 'erland', 'TAMBAH MASTER APP', 'Menambahkan aplikasi master: PPTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-24 02:31:00', NULL),
(97, 5, 'kevin', 'UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: 24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-24 02:33:07', NULL),
(98, 5, 'kevin', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-24 02:43:03', NULL),
(99, 3, 'erland', 'APPROVE FINAL (TAHAP 2)', 'Meninjau progres log ID: 10. Catatan: setuju', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-24 03:49:12', NULL),
(100, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 18 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-24 03:50:26', NULL),
(101, 10, 'Felis', 'HAPUS APLIKASI', 'Menghapus aplikasi id: 9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-24 03:57:48', NULL),
(102, 5, 'kevin', 'PENGAJUAN HAPUS', 'User mengajukan penghapusan aplikasi id: 24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 05:11:31', NULL),
(103, 3, 'erland', 'HAPUS APLIKASI', 'Admin/PM menyetujui penghapusan aplikasi id: 24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 05:12:18', NULL),
(104, 5, 'kevin', 'PENGAJUAN HAPUS', 'User mengajukan penghapusan aplikasi id: 19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 05:14:04', NULL),
(105, 5, 'kevin', 'PENGAJUAN HAPUS', 'User mengajukan penghapusan aplikasi id: 25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 05:18:39', NULL),
(106, 3, 'erland', 'HAPUS APLIKASI', 'Admin/PM menyetujui penghapusan aplikasi id: 25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 05:26:38', NULL),
(107, 3, 'erland', 'TOLAK HAPUS', 'Admin/PM menolak penghapusan aplikasi id: 19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 05:26:48', NULL),
(108, 5, 'kevin', 'PENGAJUAN HAPUS', 'User mengajukan penghapusan aplikasi id: 19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 05:50:02', NULL),
(109, 10, 'Felis', 'TOLAK HAPUS', 'Admin/PM menolak penghapusan aplikasi id: 19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 05:51:04', NULL),
(110, 3, 'erland', 'EDIT MASTER APP', 'Mengubah aplikasi master id: 23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 06:12:42', NULL),
(111, 3, 'erland', 'EDIT MASTER APP', 'Mengubah aplikasi master id: 21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 06:13:22', NULL),
(112, 3, 'erland', 'EDIT MASTER APP', 'Mengubah aplikasi master id: 20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 06:13:56', NULL),
(113, 3, 'erland', 'EDIT MASTER APP', 'Mengubah aplikasi master id: 18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 06:16:46', NULL),
(114, 5, 'kevin', 'HAPUS MASTER APP', 'Menghapus aplikasi master id: 24 Alasan: Tanpa alasan', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 06:25:14', NULL),
(115, 5, 'kevin', 'PENGAJUAN HAPUS', 'User mengajukan penghapusan aplikasi id: 20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 06:34:06', NULL),
(116, 3, 'erland', 'TOLAK HAPUS', 'Admin/PM menolak penghapusan aplikasi id: 20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 06:34:49', NULL),
(117, 5, 'kevin', 'PENGAJUAN HAPUS', 'User mengajukan penghapusan aplikasi id: 18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-25 06:38:40', NULL),
(118, 5, 'kevin', 'PENGAJUAN HAPUS', 'User mengajukan penghapusan aplikasi id: 27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-29 07:01:07', NULL),
(119, 3, 'erland', 'TOLAK HAPUS', 'Admin/PM menolak penghapusan aplikasi id: 27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:31:43', NULL),
(120, 3, 'erland', 'TOLAK HAPUS', 'Admin/PM menolak penghapusan aplikasi id: 27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:31:47', NULL),
(121, 3, 'erland', 'TOLAK HAPUS', 'Admin/PM menolak penghapusan aplikasi id: 18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:40:18', NULL),
(122, 5, 'kevin', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:48:04', NULL),
(123, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 19 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:48:51', NULL),
(124, 2, 'rendi', 'APPROVE NOTULA', 'Menyetujui notula ID: 19 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:49:25', NULL),
(125, 2, 'rendi', 'APPROVE NOTULA', 'Menyetujui notula ID: 8 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:49:30', NULL),
(126, 2, 'rendi', 'APPROVE NOTULA', 'Menyetujui notula ID: 5 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:49:36', NULL),
(127, 2, 'rendi', 'APPROVE NOTULA', 'Menyetujui notula ID: 4 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:49:40', NULL),
(128, 5, 'kevin', 'BUAT NOTULA', 'Menyimpan notula rapat: Pembahasan Proyek: PTSI', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 04:59:32', NULL),
(129, 3, 'erland', 'APPROVE NOTULA', 'Menyetujui notula ID: 20 slot-1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 05:00:35', NULL),
(130, 2, 'rendi', 'APPROVE NOTULA', 'Menyetujui notula ID: 20 slot-2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-07-02 05:01:17', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `divisi` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'default.png',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `divisi_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nip`, `nama_lengkap`, `jenis_kelamin`, `username`, `password`, `role`, `divisi`, `photo`, `created_at`, `updated_at`, `divisi_id`) VALUES
(1, '11111', 'Administrator', 'L', 'admin', '$2y$10$0IbAqwC57U5bANOm5OQAIuuBf6ir7mDWRXQQBUimWgB9nZ5SvADii', 'Admin', 'Teknologi Informasi', '1779766096_7a43f98b135bec4b5a7f.png', NULL, NULL, NULL),
(2, '1233444', 'Rendy Wijaya', 'L', 'rendi', '$2y$10$kh8j5O.yCb0nR/vKpYoHBOsXlb/xgpiPnbeMqyMomTqXC6IoB.LeK', 'User', 'Teknologi Informasi', '1779767511_76199a36883bff013653.png', NULL, NULL, NULL),
(3, '1233444', 'Erland Radithya Putra Priono', 'L', 'erland', '$2y$10$j231w0HoR1MTxADq.De57eBoT.loFu3FtAc6r8t6OsXX/4GH9ja2i', 'Admin', 'Teknologi Informasi', '1779767417_4a2d41feb4428fc68add.png', NULL, NULL, NULL),
(4, '223344', 'Fitri Rosari', 'L', 'fitri', '$2y$10$8gei6SWPC959gu6iC43b2Of11jN4Z39y4M7NoGeUn7cloGXu/Wg2O', 'User', 'Teknologi Informasi', '1779781913_f10bb645e2e1f31d303a.png', NULL, NULL, NULL),
(5, '223355', 'Kevin', 'L', 'kevin', '$2y$10$YxR09f7I9CvjTV26Fj.mReN1g5HnjDJpqjccZnXCs3oVN.nngyNou', 'User', 'Teknologi Informasi', 'default.png', NULL, NULL, NULL),
(6, '1233444', 'Rendy Wijaya', 'L', 'rendy', '$2y$10$PLgqx58.niXlGdd2XMJbWufvikNMS/zVumVpUIy20Lh/0Z.anX102', 'Admin', 'Teknologi Informasi', 'default.png', NULL, NULL, NULL),
(7, 'SI10001', 'Budi Santoso', 'L', 'budi', '$2y$10$J76mnVHAHyp5MwlosWLrou.BvPLR/aC.NfUQ9kwZxHExEwcsIBPje', 'User', 'Teknologi Informasi', NULL, NULL, NULL, NULL),
(8, 'SI10002', 'Siti Aminah', 'L', 'siti', '$2y$10$YsJcR63uBFKwW84NFv6HbujafQlUqVB4TweYssi1wieDhHFvVLWgO', 'User', 'Akuntansi & Keuangan', NULL, NULL, NULL, NULL),
(9, '334477', 'Lando Putra Priono', 'L', 'Lando', '$2y$10$7niJpu3.CKEq6uh2bAy7vuZZowxKSLhfDPQLlasH3w8kQ95udBsJW', 'Viewer', 'Operasi', 'default.png', NULL, NULL, NULL),
(10, '55566677', 'Felicia Putri', 'L', 'Felis', '$2y$10$NrllUSeAGmic34Vp86w8h.vBFtdU9UsjTORKyaXXVmFtpq3HWiFTq', 'PM', 'Teknologi Informasi', 'default.png', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi_kehadiran`
--
ALTER TABLE `absensi_kehadiran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aplikasi_master`
--
ALTER TABLE `aplikasi_master`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aplikasi_modul`
--
ALTER TABLE `aplikasi_modul`
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
-- Indeks untuk tabel `implementasi_data`
--
ALTER TABLE `implementasi_data`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_cobit_19`
--
ALTER TABLE `master_cobit_19`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_kpi`
--
ALTER TABLE `master_kpi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notula_rapat`
--
ALTER TABLE `notula_rapat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permintaan_aplikasi`
--
ALTER TABLE `permintaan_aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `progres_log`
--
ALTER TABLE `progres_log`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi_kehadiran`
--
ALTER TABLE `absensi_kehadiran`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `aplikasi_master`
--
ALTER TABLE `aplikasi_master`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `aplikasi_modul`
--
ALTER TABLE `aplikasi_modul`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `aset`
--
ALTER TABLE `aset`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `implementasi_data`
--
ALTER TABLE `implementasi_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `master_cobit_19`
--
ALTER TABLE `master_cobit_19`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `master_kpi`
--
ALTER TABLE `master_kpi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `notula_rapat`
--
ALTER TABLE `notula_rapat`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `permintaan_aplikasi`
--
ALTER TABLE `permintaan_aplikasi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `progres_log`
--
ALTER TABLE `progres_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
