-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2024 at 05:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pbl`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2024_11_05_122537_m_identitas_diri', 1),
(8, '2024_11_05_124335_m_jenis_pengguna', 2),
(9, '2024_11_05_124356_m_periode', 3),
(10, '2024_11_05_124343_m_akun_user', 4),
(11, '2024_11_05_124414_m_mata_kuliah', 5),
(12, '2024_11_05_124426_m_bidang_minat', 6),
(13, '2024_11_05_124435_m_vendor_pelatihan', 7),
(14, '2024_11_05_124447_m_vendor_sertifikasi', 8),
(15, '2024_11_05_124406_m_jenis_pelatihan_sertifikasi', 9),
(16, '2024_11_05_131822_m_pelatihan', 10),
(17, '2024_11_05_131829_m_sertifikasi', 11),
(18, '2024_11_05_131806_t_peserta_pelatihan', 12),
(19, '2024_11_05_131815_t_peserta_sertifikasi', 13),
(20, '2024_11_05_131851_t_tagging_mk_pelatihan', 14),
(21, '2024_11_05_131857_t_tagging_bd_pelatihan', 15),
(22, '2024_11_05_131905_t_tagging_bd_sertifikasi', 16),
(23, '2024_11_05_131912_t_tagging_mk_sertifikasi', 17);

-- --------------------------------------------------------

--
-- Table structure for table `m_akun_user`
--

CREATE TABLE `m_akun_user` (
  `id_user` bigint UNSIGNED NOT NULL,
  `id_identitas` bigint UNSIGNED NOT NULL,
  `id_jenis_pengguna` bigint UNSIGNED NOT NULL,
  `id_periode` bigint UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_bidang_minat`
--

CREATE TABLE `m_bidang_minat` (
  `id_bd` bigint UNSIGNED NOT NULL,
  `nama_bd` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_bd` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_bd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_bidang_minat`
--

INSERT INTO `m_bidang_minat` (`id_bd`, `nama_bd`, `kode_bd`, `deskripsi_bd`, `created_at`, `updated_at`) VALUES
(1, 'Artificial Intelligence', 'AI', 'Penelitian terkait kecerdasan buatan dan machine learning.', '2024-11-07 08:52:01', NULL),
(2, 'Data Science', 'DS', 'Penelitian terkait pengolahan data, big data, dan statistik.', '2024-11-07 08:52:01', NULL),
(3, 'Computer Vision', 'CV', 'Penelitian terkait pengenalan pola, image processing, dan visual computing.', '2024-11-07 08:52:01', NULL),
(4, 'Cyber Security', 'CS', 'Penelitian terkait keamanan jaringan dan kriptografi.', '2024-11-07 08:52:01', NULL),
(5, 'Internet of Things (IoT)', 'IOT', 'Penelitian terkait perangkat IoT dan sensor.', '2024-11-07 08:52:01', NULL),
(6, 'Software Engineering', 'SE', 'Pengembangan dan pemeliharaan perangkat lunak.', '2024-11-07 08:52:01', NULL),
(7, 'Robotics', 'ROB', 'Penelitian dan pengembangan teknologi robotik.', '2024-11-07 08:52:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_identitas_diri`
--

CREATE TABLE `m_identitas_diri` (
  `id_identitas` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NIP` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('laki','perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_profil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_identitas_diri`
--

INSERT INTO `m_identitas_diri` (`id_identitas`, `nama_lengkap`, `NIP`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_telp`, `email`, `foto_profil`, `created_at`, `updated_at`) VALUES
(1, 'Rizki Arya Prayoga', '211762051', 'Malang', '2003-01-01', 'laki', 'Jl. Candi Telaga Wangi No. 81', '081515430129', 'rizkiarya79@yahoo.com', NULL, '2024-11-07 08:52:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_jenis_pelatihan_sertifikasi`
--

CREATE TABLE `m_jenis_pelatihan_sertifikasi` (
  `id_jenis_pelatihan_sertifikasi` bigint UNSIGNED NOT NULL,
  `nama_jenis_setifikasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_pendek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_jenis_pelatihan_sertifikasi`
--

INSERT INTO `m_jenis_pelatihan_sertifikasi` (`id_jenis_pelatihan_sertifikasi`, `nama_jenis_setifikasi`, `deskripsi_pendek`, `created_at`, `updated_at`) VALUES
(1, 'Data Science', 'Pelatihan yang fokus pada analisis data dan pembelajaran mesin.', '2024-11-07 08:52:01', NULL),
(2, 'Data Mining', 'Pelatihan yang mengajarkan teknik untuk mengeksplorasi dan menganalisis data besar.', '2024-11-07 08:52:01', NULL),
(3, 'Machine Learning', 'Pelatihan tentang algoritma dan teknik untuk membangun model pembelajaran otomatis.', '2024-11-07 08:52:01', NULL),
(4, 'Big Data', 'Pelatihan mengenai pengelolaan dan analisis data dalam skala besar.', '2024-11-07 08:52:01', NULL),
(5, 'Artificial Intelligence', 'Pelatihan tentang pengembangan sistem yang dapat meniru kecerdasan manusia.', '2024-11-07 08:52:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_jenis_pengguna`
--

CREATE TABLE `m_jenis_pengguna` (
  `id_jenis_pengguna` bigint UNSIGNED NOT NULL,
  `nama_jenis_pengguna` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_jenis_pengguna` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_jenis_pengguna`
--

INSERT INTO `m_jenis_pengguna` (`id_jenis_pengguna`, `nama_jenis_pengguna`, `kode_jenis_pengguna`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'ADM', '2024-11-07 08:52:01', NULL),
(2, 'Super Admin', 'SDM', '2024-11-07 08:52:01', NULL),
(3, 'Dosen', 'DSN', '2024-11-07 08:52:01', NULL),
(4, 'Pemimpin', 'PMP', '2024-11-07 08:52:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_mata_kuliah`
--

CREATE TABLE `m_mata_kuliah` (
  `id_mk` bigint UNSIGNED NOT NULL,
  `nama_mk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_mk` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_mk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_mata_kuliah`
--

INSERT INTO `m_mata_kuliah` (`id_mk`, `nama_mk`, `kode_mk`, `deskripsi_mk`, `created_at`, `updated_at`) VALUES
(1, 'Machine Learning', 'ML101', 'Pengenalan konsep machine learning dan penerapannya.', '2024-11-07 08:52:01', NULL),
(2, 'Data Mining', 'DM102', 'Teknik dan algoritma untuk mengekstraksi informasi dari data.', '2024-11-07 08:52:01', NULL),
(3, 'Computer Vision', 'CV201', 'Dasar-dasar computer vision dan aplikasi dalam kehidupan nyata.', '2024-11-07 08:52:01', NULL),
(4, 'Network Security', 'NS202', 'Konsep keamanan jaringan dan kriptografi.', '2024-11-07 08:52:01', NULL),
(5, 'IoT Systems', 'IOT303', 'Pengenalan teknologi IoT dan penerapannya.', '2024-11-07 08:52:01', NULL),
(6, 'Software Engineering', 'SE101', 'Prinsip-prinsip pengembangan perangkat lunak.', '2024-11-07 08:52:01', NULL),
(7, 'Robotics and Automation', 'RA305', 'Dasar-dasar robotika dan otomatisasi.', '2024-11-07 08:52:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_pelatihan`
--

CREATE TABLE `m_pelatihan` (
  `id_pelatihan` bigint UNSIGNED NOT NULL,
  `nama_pelatihan` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_vendor_pelatihan` bigint UNSIGNED NOT NULL,
  `id_jenis_pelatihan_sertifikasi` bigint UNSIGNED NOT NULL,
  `id_periode` bigint UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `level_pelatihan` enum('nasional','internasional') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quota_peserta` int NOT NULL,
  `no_pelatihan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_pelatihan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_disetujui` enum('iya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_by` enum('admin','dosen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_periode`
--

CREATE TABLE `m_periode` (
  `id_periode` bigint UNSIGNED NOT NULL,
  `nama_periode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tahun_periode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_periode` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_periode`
--

INSERT INTO `m_periode` (`id_periode`, `nama_periode`, `tanggal_mulai`, `tanggal_selesai`, `tahun_periode`, `deskripsi_periode`, `created_at`, `updated_at`) VALUES
(1, '2024/2025', '2024-01-01', '2025-01-01', 'Ganjil', 'Periode 2024/2025 Tahun ganjil', '2024-11-07 08:52:01', NULL),
(2, '2025/2026', '2025-01-01', '2026-01-01', 'Genap', 'Periode 2025/2026 Tahun genap', '2024-11-07 08:52:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_sertifikasi`
--

CREATE TABLE `m_sertifikasi` (
  `id_sertifikasi` bigint UNSIGNED NOT NULL,
  `nama_sertifikasi` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_vendor_sertifikasi` bigint UNSIGNED NOT NULL,
  `id_jenis_pelatihan_sertifikasi` bigint UNSIGNED NOT NULL,
  `id_periode` bigint UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `level_sertifikasi` enum('nasional','internasional') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quota_peserta` int NOT NULL,
  `no_sertifikasi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_sertifikasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_kadaluarsa` date NOT NULL,
  `status_disetujui` enum('iya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_by` enum('admin','dosen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_vendor_pelatihan`
--

CREATE TABLE `m_vendor_pelatihan` (
  `id_vendor_pelatihan` bigint UNSIGNED NOT NULL,
  `nama_vendor_pelatihan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_vendor_pelatihan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota_vendor_pelatihan` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notelp_vendor_pelatihan` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `web_vendor_pelatihan` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_vendor_pelatihan`
--

INSERT INTO `m_vendor_pelatihan` (`id_vendor_pelatihan`, `nama_vendor_pelatihan`, `alamat_vendor_pelatihan`, `kota_vendor_pelatihan`, `notelp_vendor_pelatihan`, `web_vendor_pelatihan`, `created_at`, `updated_at`) VALUES
(1, 'PT. Edukasi Mandiri', 'Jl. Pendidikan No. 10, Jakarta', 'Jakarta', '021-12345678', 'www.edukasimandiri.com', '2024-11-07 08:52:01', NULL),
(2, 'CV. Teknologi Canggih', 'Jl. Teknologi No. 5, Bandung', 'Bandung', '022-87654321', 'www.teknologicanggih.com', '2024-11-07 08:52:01', NULL),
(3, 'Yayasan Pelatihan Kreatif', 'Jl. Kreatif No. 20, Yogyakarta', 'Yogyakarta', '0274-1234567', 'www.pelatihankreatif.org', '2024-11-07 08:52:01', NULL),
(4, 'Lembaga Pelatihan Profesional', 'Jl. Profesional No. 15, Surabaya', 'Surabaya', '031-7654321', 'www.pelatihanprofesional.com', '2024-11-07 08:52:01', NULL),
(5, 'Institut Pelatihan Digital', 'Jl. Digital No. 30, Bali', 'Denpasar', '0361-9876543', 'www.pelatihandigital.id', '2024-11-07 08:52:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_vendor_sertifikasi`
--

CREATE TABLE `m_vendor_sertifikasi` (
  `id_vendor_sertifikasi` bigint UNSIGNED NOT NULL,
  `nama_vendor_sertifikasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_vendor_sertifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota_vendor_sertifikasi` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notelp_vendor_sertifikasi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `web_vendor_sertifikasi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_vendor_sertifikasi`
--

INSERT INTO `m_vendor_sertifikasi` (`id_vendor_sertifikasi`, `nama_vendor_sertifikasi`, `alamat_vendor_sertifikasi`, `kota_vendor_sertifikasi`, `notelp_vendor_sertifikasi`, `web_vendor_sertifikasi`, `created_at`, `updated_at`) VALUES
(1, 'PT. Sertifikasi Utama', 'Jl. Sertifikasi No. 1, Jakarta', 'Jakarta', '021-12345678', 'www.sertifikasiutama.com', '2024-11-07 08:52:01', NULL),
(2, 'CV. Edukasi Bersertifikat', 'Jl. Edukasi No. 10, Bandung', 'Bandung', '022-87654321', 'www.edukasibersertifikat.com', '2024-11-07 08:52:01', NULL),
(3, 'Lembaga Sertifikasi Profesional', 'Jl. Profesional No. 5, Yogyakarta', 'Yogyakarta', '0274-1234567', 'www.sertifikasiprofesional.org', '2024-11-07 08:52:01', NULL),
(4, 'Institut Sertifikasi Digital', 'Jl. Digital No. 15, Surabaya', 'Surabaya', '031-7654321', 'www.sertifikasidigital.com', '2024-11-07 08:52:01', NULL),
(5, 'Yayasan Sertifikasi Mandiri', 'Jl. Mandiri No. 20, Denpasar', 'Bali', '0361-9876543', 'www.sertifikasimandiri.id', '2024-11-07 08:52:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_peserta_pelatihan`
--

CREATE TABLE `t_peserta_pelatihan` (
  `id_peserta` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_pelatihan` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_peserta_sertifikasi`
--

CREATE TABLE `t_peserta_sertifikasi` (
  `id_peserta` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_sertifikasi` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_tagging_bd_pelatihan`
--

CREATE TABLE `t_tagging_bd_pelatihan` (
  `id_tagging_bd` bigint UNSIGNED NOT NULL,
  `id_pelatihan` bigint UNSIGNED NOT NULL,
  `id_bd` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_tagging_bd_sertifikasi`
--

CREATE TABLE `t_tagging_bd_sertifikasi` (
  `id_tagging_bd` bigint UNSIGNED NOT NULL,
  `id_sertifikasi` bigint UNSIGNED NOT NULL,
  `id_bd` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_tagging_mk_pelatihan`
--

CREATE TABLE `t_tagging_mk_pelatihan` (
  `id_tagging_mk` bigint UNSIGNED NOT NULL,
  `id_pelatihan` bigint UNSIGNED NOT NULL,
  `id_mk` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_tagging_mk_sertifikasi`
--

CREATE TABLE `t_tagging_mk_sertifikasi` (
  `id_tagging_mk` bigint UNSIGNED NOT NULL,
  `id_sertifikasi` bigint UNSIGNED NOT NULL,
  `id_mk` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_akun_user`
--
ALTER TABLE `m_akun_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `m_akun_user_id_identitas_index` (`id_identitas`),
  ADD KEY `m_akun_user_id_jenis_pengguna_index` (`id_jenis_pengguna`),
  ADD KEY `m_akun_user_id_periode_index` (`id_periode`);

--
-- Indexes for table `m_bidang_minat`
--
ALTER TABLE `m_bidang_minat`
  ADD PRIMARY KEY (`id_bd`);

--
-- Indexes for table `m_identitas_diri`
--
ALTER TABLE `m_identitas_diri`
  ADD PRIMARY KEY (`id_identitas`),
  ADD UNIQUE KEY `m_identitas_diri_nip_unique` (`NIP`);

--
-- Indexes for table `m_jenis_pelatihan_sertifikasi`
--
ALTER TABLE `m_jenis_pelatihan_sertifikasi`
  ADD PRIMARY KEY (`id_jenis_pelatihan_sertifikasi`);

--
-- Indexes for table `m_jenis_pengguna`
--
ALTER TABLE `m_jenis_pengguna`
  ADD PRIMARY KEY (`id_jenis_pengguna`);

--
-- Indexes for table `m_mata_kuliah`
--
ALTER TABLE `m_mata_kuliah`
  ADD PRIMARY KEY (`id_mk`);

--
-- Indexes for table `m_pelatihan`
--
ALTER TABLE `m_pelatihan`
  ADD PRIMARY KEY (`id_pelatihan`),
  ADD KEY `m_pelatihan_id_vendor_pelatihan_index` (`id_vendor_pelatihan`),
  ADD KEY `m_pelatihan_id_jenis_pelatihan_sertifikasi_index` (`id_jenis_pelatihan_sertifikasi`),
  ADD KEY `m_pelatihan_id_periode_index` (`id_periode`);

--
-- Indexes for table `m_periode`
--
ALTER TABLE `m_periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indexes for table `m_sertifikasi`
--
ALTER TABLE `m_sertifikasi`
  ADD PRIMARY KEY (`id_sertifikasi`),
  ADD KEY `m_sertifikasi_id_vendor_sertifikasi_index` (`id_vendor_sertifikasi`),
  ADD KEY `m_sertifikasi_id_jenis_pelatihan_sertifikasi_index` (`id_jenis_pelatihan_sertifikasi`),
  ADD KEY `m_sertifikasi_id_periode_index` (`id_periode`);

--
-- Indexes for table `m_vendor_pelatihan`
--
ALTER TABLE `m_vendor_pelatihan`
  ADD PRIMARY KEY (`id_vendor_pelatihan`);

--
-- Indexes for table `m_vendor_sertifikasi`
--
ALTER TABLE `m_vendor_sertifikasi`
  ADD PRIMARY KEY (`id_vendor_sertifikasi`);

--
-- Indexes for table `t_peserta_pelatihan`
--
ALTER TABLE `t_peserta_pelatihan`
  ADD PRIMARY KEY (`id_peserta`),
  ADD KEY `t_peserta_pelatihan_id_user_index` (`id_user`),
  ADD KEY `t_peserta_pelatihan_id_pelatihan_index` (`id_pelatihan`);

--
-- Indexes for table `t_peserta_sertifikasi`
--
ALTER TABLE `t_peserta_sertifikasi`
  ADD PRIMARY KEY (`id_peserta`),
  ADD KEY `t_peserta_sertifikasi_id_user_index` (`id_user`),
  ADD KEY `t_peserta_sertifikasi_id_sertifikasi_index` (`id_sertifikasi`);

--
-- Indexes for table `t_tagging_bd_pelatihan`
--
ALTER TABLE `t_tagging_bd_pelatihan`
  ADD PRIMARY KEY (`id_tagging_bd`),
  ADD KEY `t_tagging_bd_pelatihan_id_pelatihan_index` (`id_pelatihan`),
  ADD KEY `t_tagging_bd_pelatihan_id_bd_index` (`id_bd`);

--
-- Indexes for table `t_tagging_bd_sertifikasi`
--
ALTER TABLE `t_tagging_bd_sertifikasi`
  ADD PRIMARY KEY (`id_tagging_bd`),
  ADD KEY `t_tagging_bd_sertifikasi_id_sertifikasi_index` (`id_sertifikasi`),
  ADD KEY `t_tagging_bd_sertifikasi_id_bd_index` (`id_bd`);

--
-- Indexes for table `t_tagging_mk_pelatihan`
--
ALTER TABLE `t_tagging_mk_pelatihan`
  ADD PRIMARY KEY (`id_tagging_mk`),
  ADD KEY `t_tagging_mk_pelatihan_id_pelatihan_index` (`id_pelatihan`),
  ADD KEY `t_tagging_mk_pelatihan_id_mk_index` (`id_mk`);

--
-- Indexes for table `t_tagging_mk_sertifikasi`
--
ALTER TABLE `t_tagging_mk_sertifikasi`
  ADD PRIMARY KEY (`id_tagging_mk`),
  ADD KEY `t_tagging_mk_sertifikasi_id_sertifikasi_index` (`id_sertifikasi`),
  ADD KEY `t_tagging_mk_sertifikasi_id_mk_index` (`id_mk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `m_akun_user`
--
ALTER TABLE `m_akun_user`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_bidang_minat`
--
ALTER TABLE `m_bidang_minat`
  MODIFY `id_bd` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `m_identitas_diri`
--
ALTER TABLE `m_identitas_diri`
  MODIFY `id_identitas` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_jenis_pelatihan_sertifikasi`
--
ALTER TABLE `m_jenis_pelatihan_sertifikasi`
  MODIFY `id_jenis_pelatihan_sertifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_jenis_pengguna`
--
ALTER TABLE `m_jenis_pengguna`
  MODIFY `id_jenis_pengguna` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_mata_kuliah`
--
ALTER TABLE `m_mata_kuliah`
  MODIFY `id_mk` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `m_pelatihan`
--
ALTER TABLE `m_pelatihan`
  MODIFY `id_pelatihan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_periode`
--
ALTER TABLE `m_periode`
  MODIFY `id_periode` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_sertifikasi`
--
ALTER TABLE `m_sertifikasi`
  MODIFY `id_sertifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_vendor_pelatihan`
--
ALTER TABLE `m_vendor_pelatihan`
  MODIFY `id_vendor_pelatihan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_vendor_sertifikasi`
--
ALTER TABLE `m_vendor_sertifikasi`
  MODIFY `id_vendor_sertifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_peserta_pelatihan`
--
ALTER TABLE `t_peserta_pelatihan`
  MODIFY `id_peserta` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_peserta_sertifikasi`
--
ALTER TABLE `t_peserta_sertifikasi`
  MODIFY `id_peserta` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_tagging_bd_pelatihan`
--
ALTER TABLE `t_tagging_bd_pelatihan`
  MODIFY `id_tagging_bd` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_tagging_bd_sertifikasi`
--
ALTER TABLE `t_tagging_bd_sertifikasi`
  MODIFY `id_tagging_bd` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_tagging_mk_pelatihan`
--
ALTER TABLE `t_tagging_mk_pelatihan`
  MODIFY `id_tagging_mk` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_tagging_mk_sertifikasi`
--
ALTER TABLE `t_tagging_mk_sertifikasi`
  MODIFY `id_tagging_mk` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_akun_user`
--
ALTER TABLE `m_akun_user`
  ADD CONSTRAINT `m_akun_user_id_identitas_foreign` FOREIGN KEY (`id_identitas`) REFERENCES `m_identitas_diri` (`id_identitas`),
  ADD CONSTRAINT `m_akun_user_id_jenis_pengguna_foreign` FOREIGN KEY (`id_jenis_pengguna`) REFERENCES `m_jenis_pengguna` (`id_jenis_pengguna`),
  ADD CONSTRAINT `m_akun_user_id_periode_foreign` FOREIGN KEY (`id_periode`) REFERENCES `m_periode` (`id_periode`);

--
-- Constraints for table `m_pelatihan`
--
ALTER TABLE `m_pelatihan`
  ADD CONSTRAINT `m_pelatihan_id_jenis_pelatihan_sertifikasi_foreign` FOREIGN KEY (`id_jenis_pelatihan_sertifikasi`) REFERENCES `m_jenis_pelatihan_sertifikasi` (`id_jenis_pelatihan_sertifikasi`),
  ADD CONSTRAINT `m_pelatihan_id_periode_foreign` FOREIGN KEY (`id_periode`) REFERENCES `m_periode` (`id_periode`),
  ADD CONSTRAINT `m_pelatihan_id_vendor_pelatihan_foreign` FOREIGN KEY (`id_vendor_pelatihan`) REFERENCES `m_vendor_pelatihan` (`id_vendor_pelatihan`);

--
-- Constraints for table `m_sertifikasi`
--
ALTER TABLE `m_sertifikasi`
  ADD CONSTRAINT `m_sertifikasi_id_jenis_pelatihan_sertifikasi_foreign` FOREIGN KEY (`id_jenis_pelatihan_sertifikasi`) REFERENCES `m_jenis_pelatihan_sertifikasi` (`id_jenis_pelatihan_sertifikasi`),
  ADD CONSTRAINT `m_sertifikasi_id_periode_foreign` FOREIGN KEY (`id_periode`) REFERENCES `m_periode` (`id_periode`),
  ADD CONSTRAINT `m_sertifikasi_id_vendor_sertifikasi_foreign` FOREIGN KEY (`id_vendor_sertifikasi`) REFERENCES `m_vendor_sertifikasi` (`id_vendor_sertifikasi`);

--
-- Constraints for table `t_peserta_pelatihan`
--
ALTER TABLE `t_peserta_pelatihan`
  ADD CONSTRAINT `t_peserta_pelatihan_id_pelatihan_foreign` FOREIGN KEY (`id_pelatihan`) REFERENCES `m_pelatihan` (`id_pelatihan`),
  ADD CONSTRAINT `t_peserta_pelatihan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `m_akun_user` (`id_user`);

--
-- Constraints for table `t_peserta_sertifikasi`
--
ALTER TABLE `t_peserta_sertifikasi`
  ADD CONSTRAINT `t_peserta_sertifikasi_id_sertifikasi_foreign` FOREIGN KEY (`id_sertifikasi`) REFERENCES `m_sertifikasi` (`id_sertifikasi`),
  ADD CONSTRAINT `t_peserta_sertifikasi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `m_akun_user` (`id_user`);

--
-- Constraints for table `t_tagging_bd_pelatihan`
--
ALTER TABLE `t_tagging_bd_pelatihan`
  ADD CONSTRAINT `t_tagging_bd_pelatihan_id_bd_foreign` FOREIGN KEY (`id_bd`) REFERENCES `m_bidang_minat` (`id_bd`),
  ADD CONSTRAINT `t_tagging_bd_pelatihan_id_pelatihan_foreign` FOREIGN KEY (`id_pelatihan`) REFERENCES `m_pelatihan` (`id_pelatihan`);

--
-- Constraints for table `t_tagging_bd_sertifikasi`
--
ALTER TABLE `t_tagging_bd_sertifikasi`
  ADD CONSTRAINT `t_tagging_bd_sertifikasi_id_bd_foreign` FOREIGN KEY (`id_bd`) REFERENCES `m_bidang_minat` (`id_bd`),
  ADD CONSTRAINT `t_tagging_bd_sertifikasi_id_sertifikasi_foreign` FOREIGN KEY (`id_sertifikasi`) REFERENCES `m_sertifikasi` (`id_sertifikasi`);

--
-- Constraints for table `t_tagging_mk_pelatihan`
--
ALTER TABLE `t_tagging_mk_pelatihan`
  ADD CONSTRAINT `t_tagging_mk_pelatihan_id_mk_foreign` FOREIGN KEY (`id_mk`) REFERENCES `m_mata_kuliah` (`id_mk`),
  ADD CONSTRAINT `t_tagging_mk_pelatihan_id_pelatihan_foreign` FOREIGN KEY (`id_pelatihan`) REFERENCES `m_pelatihan` (`id_pelatihan`);

--
-- Constraints for table `t_tagging_mk_sertifikasi`
--
ALTER TABLE `t_tagging_mk_sertifikasi`
  ADD CONSTRAINT `t_tagging_mk_sertifikasi_id_mk_foreign` FOREIGN KEY (`id_mk`) REFERENCES `m_mata_kuliah` (`id_mk`),
  ADD CONSTRAINT `t_tagging_mk_sertifikasi_id_sertifikasi_foreign` FOREIGN KEY (`id_sertifikasi`) REFERENCES `m_sertifikasi` (`id_sertifikasi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
