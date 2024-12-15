-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2024 at 05:57 AM
-- Server version: 8.0.36
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
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_05_122537_m_identitas_diri', 1),
(6, '2024_11_05_124335_m_jenis_pengguna', 1),
(7, '2024_11_05_124356_m_periode', 2),
(8, '2024_11_05_124406_m_jenis_pelatihan_sertifikasi', 3),
(9, '2024_11_05_124414_m_mata_kuliah', 4),
(10, '2024_11_05_124426_m_bidang_minat', 5),
(11, '2024_11_05_124435_m_vendor_pelatihan', 6),
(12, '2024_11_05_124447_m_vendor_sertifikasi', 7),
(13, '2024_11_05_131822_m_pelatihan', 8),
(14, '2024_11_05_131829_m_sertifikasi', 9),
(17, '2024_11_05_131851_t_tagging_mk_pelatihan', 12),
(18, '2024_11_05_131857_t_tagging_bd_pelatihan', 13),
(19, '2024_11_05_131905_t_tagging_bd_sertifikasi', 14),
(20, '2024_11_05_131912_t_tagging_mk_sertifikasi', 15),
(21, '2024_12_01_120451_t_detailmkdosen', 16),
(22, '2024_12_01_120501_t_detailbddosen', 17),
(23, '2024_12_01_120552_t_detailpelatihan', 18),
(24, '2024_12_01_120559_t_detailsertifikasi', 19),
(25, '2024_11_05_131806_t_peserta_pelatihan', 20),
(26, '2024_11_05_131815_t_peserta_sertifikasi', 21);

-- --------------------------------------------------------

--
-- Table structure for table `m_akun_user`
--

CREATE TABLE `m_akun_user` (
  `id_user` bigint UNSIGNED NOT NULL,
  `id_identitas` bigint UNSIGNED NOT NULL,
  `id_jenis_pengguna` bigint UNSIGNED NOT NULL,
  `id_periode` bigint UNSIGNED NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_akun_user`
--

INSERT INTO `m_akun_user` (`id_user`, `id_identitas`, `id_jenis_pengguna`, `id_periode`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 'dengkulbabi', '$2y$12$VMGPt77xtUH/O7dprzgvGeSErlTPIUkSKPbOsHpORxIc1Ao1SCZOu', '2024-11-23 16:43:38', '2024-11-23 16:43:38'),
(2, 2, 1, 2, 'topekaja', '$2y$12$nzdpapUbnG4ioEHCGPS2jecCR32.ifBRekrillVIL4fX/Dhh4miFO', '2024-11-27 12:27:35', '2024-11-27 12:27:35'),
(3, 4, 4, 2, 'yolandaeka', '$2y$12$eXPGawhmSO5GHjgy5mK5mejK5pU9cZhYMZ5IervxqmWvlj1b8kyie', '2024-11-27 22:04:17', '2024-11-27 22:04:17'),
(5, 5, 3, 1, 'dickyaja', '$2y$12$zSbTjbGrizRU5rR08eDMt.R7A7eXG8X7fRQUSC80fRo4gcsRDezgW', '2024-12-03 09:04:07', '2024-12-03 09:04:07'),
(6, 6, 3, 1, 'yuliananta', '$2y$12$xYjS9AE.Vjz8ZqJfy135nu0Lc4LPy4hTXRZh0yNi98Gdrq95pNyUS', '2024-12-04 17:59:00', '2024-12-04 17:59:00'),
(7, 4, 1, 1, 'admin123', '$2y$12$mM0.CHl5JEtCRPOrHQHzlubRZKioFb2/1//oa1MvV3kYdrCM6mYd.', '2024-12-04 19:12:47', '2024-12-04 19:12:47');

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
(1, 'Artificial Intelligence', 'AI', 'Penelitian terkait kecerdasan buatan dan machine learning.', '2024-12-02 06:57:21', NULL),
(2, 'Data Science', 'DS', 'Penelitian terkait pengolahan data, big data, dan statistik.', '2024-12-02 06:57:21', NULL),
(3, 'Computer Vision', 'CV', 'Penelitian terkait pengenalan pola, image processing, dan visual computing.', '2024-12-02 06:57:21', NULL),
(4, 'Cyber Security', 'CS', 'Penelitian terkait keamanan jaringan dan kriptografi.', '2024-12-02 06:57:21', NULL),
(5, 'Internet of Things (IoT)', 'IOT', 'Penelitian terkait perangkat IoT dan sensor.', '2024-12-02 06:57:21', NULL),
(6, 'Software Engineering', 'SE', 'Pengembangan dan pemeliharaan perangkat lunak.', '2024-12-02 06:57:21', NULL),
(7, 'Robotics', 'ROB', 'Penelitian dan pengembangan teknologi robotik.', '2024-12-02 06:57:21', NULL),
(8, 'Augmented Reality (AR)', 'AR', 'Penelitian terkait teknologi augmented reality.', '2024-12-04 03:21:14', NULL),
(9, 'Big Data', 'BD', 'Penelitian terkait pengolahan data dalam skala besar.', '2024-12-04 03:21:14', NULL),
(10, 'Clustering', 'CL', 'Penelitian tentang metode pengelompokan data.', '2024-12-04 03:21:14', NULL),
(11, 'Cognitive Artificial Intelligence', 'CAI', 'Penelitian terkait kecerdasan buatan kognitif.', '2024-12-04 03:21:14', NULL),
(12, 'Data Analysis', 'DA', 'Penelitian dan teknik analisis data.', '2024-12-04 03:21:14', NULL),
(13, 'Data Mining', 'DM', 'Penelitian terkait penggalian informasi dari data.', '2024-12-04 03:21:14', NULL),
(14, 'Data Warehouse', 'DW', 'Penelitian tentang penyimpanan data terstruktur.', '2024-12-04 03:21:14', NULL),
(15, 'Decision Support System', 'DSS', 'Penelitian sistem pendukung keputusan.', '2024-12-04 03:21:14', NULL),
(16, 'Deep Learning', 'DL', 'Penelitian metode pembelajaran mendalam.', '2024-12-04 03:21:14', NULL),
(17, 'Defense Technology', 'DT', 'Penelitian teknologi pertahanan.', '2024-12-04 03:21:14', NULL),
(18, 'Enterprise Resource Planning (ERP)', 'ERP', 'Penelitian tentang sistem perencanaan sumber daya perusahaan.', '2024-12-04 03:21:14', NULL),
(19, 'Fake News Detection', 'FND', 'Penelitian terkait deteksi berita palsu.', '2024-12-04 03:21:14', NULL),
(20, 'Game', 'GM', 'Penelitian tentang pengembangan aplikasi permainan.', '2024-12-04 03:21:14', NULL),
(21, 'Geographic Information System (GIS)', 'GIS', 'Penelitian terkait sistem informasi geografis.', '2024-12-04 03:21:14', NULL),
(22, 'Human Computer Interaction (HCI)', 'HCI', 'Penelitian interaksi manusia dan komputer.', '2024-12-04 03:21:14', NULL),
(23, 'Information Fusion', 'IF', 'Penelitian penggabungan informasi dari berbagai sumber.', '2024-12-04 03:21:14', NULL),
(24, 'Information Retrieval', 'IR', 'Penelitian teknik pencarian informasi.', '2024-12-04 03:21:14', NULL),
(25, 'Large Language Model (LLM)', 'LLM', 'Penelitian tentang model bahasa skala besar.', '2024-12-04 03:21:14', NULL),
(26, 'Learning Engineering', 'LE', 'Penelitian tentang pengembangan metode pembelajaran.', '2024-12-04 03:21:14', NULL),
(27, 'Learning Engineering Technology (LET)', 'LET', 'Penelitian teknologi pembelajaran.', '2024-12-04 03:21:14', NULL),
(28, 'Natural Language Processing (NLP)', 'NLP', 'Penelitian tentang pemrosesan bahasa alami.', '2024-12-04 03:21:14', NULL),
(29, 'Optical Character Recognition (OCR)', 'OCR', 'Penelitian tentang pengenalan karakter optik.', '2024-12-04 03:21:14', NULL),
(30, 'Pattern Recognition', 'PR', 'Penelitian tentang pengenalan pola.', '2024-12-04 03:21:14', NULL),
(31, 'Quality Assurance', 'QA', 'Penelitian tentang jaminan kualitas.', '2024-12-04 03:21:14', NULL),
(32, 'Recommender System', 'RS', 'Penelitian tentang sistem rekomendasi.', '2024-12-04 03:21:14', NULL),
(33, 'Reinforcement Learning', 'RL', 'Penelitian pembelajaran penguatan.', '2024-12-04 03:21:14', NULL),
(34, 'Semantic Analysis', 'SEM', 'Penelitian tentang analisis semantik.', '2024-12-04 03:21:14', NULL),
(35, 'Sentiment Analysis', 'SA', 'Penelitian analisis sentimen.', '2024-12-04 03:21:14', NULL),
(36, 'Syntactic Analysis', 'SYA', 'Penelitian tentang analisis sintaksis.', '2024-12-04 03:21:14', NULL),
(37, 'Sistem Prediksi', 'SP', 'Penelitian tentang sistem prediksi.', '2024-12-04 03:21:14', NULL),
(38, 'Technology Enhanced Learning', 'TEL', 'Penelitian tentang pembelajaran berbasis teknologi.', '2024-12-04 03:21:14', NULL),
(39, 'Text Mining', 'TM', 'Penelitian penggalian informasi dari teks.', '2024-12-04 03:21:14', NULL),
(40, 'Text Processing', 'TP', 'Penelitian tentang pengolahan teks.', '2024-12-04 03:21:14', NULL),
(41, 'Text Summarization', 'TS', 'Penelitian tentang ringkasan teks.', '2024-12-04 03:21:14', NULL),
(42, 'Topic Modelling', 'TMOD', 'Penelitian tentang pemodelan topik.', '2024-12-04 03:21:14', NULL),
(43, 'UMKM', 'UMKM', 'Penelitian terkait pengembangan usaha mikro, kecil, dan menengah.', '2024-12-04 03:21:14', NULL),
(44, 'Virtual Reality (VR)', 'VR', 'Penelitian terkait teknologi realitas virtual.', '2024-12-04 03:21:14', NULL),
(45, 'Visualisasi', 'VIS', 'Penelitian terkait visualisasi data dan informasi.', '2024-12-04 03:21:14', NULL),
(46, 'Wireless Technology', 'WT', 'Penelitian terkait teknologi nirkabel.', '2024-12-04 03:21:14', NULL),
(47, 'Biometrics', 'BIO', 'Penelitian tentang biometrik.', '2024-12-04 03:21:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_detailbddosen`
--

CREATE TABLE `m_detailbddosen` (
  `id_detailbd` int UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_bd` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_detailbddosen`
--

INSERT INTO `m_detailbddosen` (`id_detailbd`, `id_user`, `id_bd`) VALUES
(1, 5, 1),
(2, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `m_detailmkdosen`
--

CREATE TABLE `m_detailmkdosen` (
  `id_detailmk` int UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_mk` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_detailmkdosen`
--

INSERT INTO `m_detailmkdosen` (`id_detailmk`, `id_user`, `id_mk`) VALUES
(1, 5, 3),
(2, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `m_identitas_diri`
--

CREATE TABLE `m_identitas_diri` (
  `id_identitas` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NIP` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('laki','perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_profil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_identitas_diri`
--

INSERT INTO `m_identitas_diri` (`id_identitas`, `nama_lengkap`, `NIP`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_telp`, `email`, `foto_profil`, `created_at`, `updated_at`) VALUES
(1, 'Rizki Arya Prayoga', '211762051', 'Malang', '2003-01-01', 'laki', 'Jl. Candi Telaga Wangi No. 81', '081515430129', 'rizkiarya79@yahoo.com', NULL, '2024-12-02 06:57:20', NULL),
(2, 'Topek', '2241762051', 'Sidoarjo', '2003-11-01', 'laki', 'Jl. Suhat bro no. 123', '081515430129', 'topegila@gmail.com', NULL, NULL, NULL),
(3, 'Yusak Akhnuh Marchio Trinanda', '7323682366', 'Malang', '2003-03-30', 'laki', 'Jl. Candi telaga wangi no.81', '081805171121', 'rizkiarya79@yahoo.com', NULL, '2024-11-27 12:22:44', '2024-11-27 12:22:44'),
(4, 'Yolanda EKa', '2341762051', 'Malang', '2003-01-01', 'perempuan', 'Jl. Candi telaga wangi no.81', '081805171121', 'rizkiarya79@yahoo.com', 'profil-pic.png', '2024-11-27 22:03:55', '2024-11-27 22:03:55'),
(5, 'M. Dicky Prasetyo', '2041762051', 'Sulawesi', '2003-04-24', 'laki', 'JL. Soekarno Hatta No. 6', '081515430129', 'Dickyaja@gmail.com', 'profil-pic.png', '2024-12-02 23:23:52', '2024-12-02 23:45:39'),
(6, 'Ahmadi Yuli Ananta, ST., MM.', '198107052005011002', 'Malang', '1981-07-05', 'laki', 'Jl. Raya No. 1, Malang', '081234567890', 'ahmadi@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(7, 'Annisa Taufika Firdausi, ST., MT', '198107052005011017', 'Malang', '1988-10-10', 'perempuan', 'Jl. Raya No. 2, Malang', '081234567891', 'annisa.taufika@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(8, 'Ariadi Retno Tri Hayati Ririd, S.Kom., M.Kom', '198108102005012002', 'Blitar', '1981-08-10', 'perempuan', 'Jl. Raya No. 3, Blitar', '081234567892', 'ariadi.retno@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(9, 'Arief Prasetyo, S.Kom', '197903132008121002', 'Surabaya', '1979-03-13', 'laki', 'Jl. Raya No. 4, Surabaya', '081234567893', 'arief.prasetyo@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(10, 'Atiqah Nurul Asri, S.Pd., M.Pd', '197606252005012001', 'Sidoarjo', '1976-06-25', 'perempuan', 'Jl. Raya No. 5, Sidoarjo', '081234567894', 'atiqah.nurul@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(11, 'Banni Satria Andoko, S.Kom., M.Si', '198108092010121002', 'Malang', '1981-08-09', 'laki', 'Jl. Raya No. 6, Malang', '081234567895', 'ando@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(12, 'Budi Harijanto, ST., MMkom', '196201051990031002', 'Pasuruan', '1962-01-05', 'laki', 'Jl. Raya No. 7, Pasuruan', '081234567896', 'budi.harijanto@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(13, 'Cahya Rahmad, ST., M.Kom., Dr. Eng', '197202022005011002', 'Malang', '1972-02-02', 'laki', 'Jl. Raya No. 8, Malang', '081234567897', 'cahya.rahmad@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(14, 'Deddy Kusbianto Purwoko Aji, Ir., M.MKom', '196211281988111001', 'Malang', '1962-11-28', 'laki', 'Jl. Raya No. 9, Malang', '081234567898', 'deddy_kusbianto@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(15, 'Dhebys Suryani H, S.Kom., MT', '198311092014042001', 'Malang', '1962-11-28', 'perempuan', 'Jl. Raya No. 10, Malang', '081234567899', 'dehbys@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(16, 'Dimas Wahyu Wibowo, ST., MT', '1962112819881110', 'Malang', '1962-11-28', 'laki', 'Jl. Raya No. 11, Malang', '081234567900', 'dimaswibowo@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(17, 'Dwi Puspitasari, S.Kom., M.Kom', '197911152005012002', 'Malang', '1979-11-15', 'perempuan', 'Jl. Raya No. 12, Malang', '081234567901', 'dwi.puspitasari@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(18, 'Dyah Ayu Irawati, ST., M.Cs', '198407082008122001', 'Jember', '1984-07-08', 'perempuan', 'Jl. Raya No. 13, Jember', '081234567902', 'dyah.ayu@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(19, 'Ekojono, ST., M.Kom', '195912081985031004', 'Bojonegoro', '1959-12-08', 'laki', 'Jl. Raya No. 14, Bojonegoro', '081234567903', 'ekojono2@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(20, 'Ely Setyo Astuti, ST., MT', '197605152009122001', 'Madiun', '1976-05-15', 'perempuan', 'Jl. Raya No. 15, Madiun', '081234567904', 'Ely_SetyoAstuti@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(21, 'Erfan Rohadi, ST., M.Eng., Ph.D', '197201232008011006', 'Surabaya', '1972-01-23', 'laki', 'Jl. Raya No. 16, Surabaya', '081234567905', 'erfanr@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(22, 'Faisal Rahutomo ST., M.Kom., Dr.Eng', '197711162005011008', 'Malang', '1977-11-16', 'laki', 'Jl. Raya No. 17, Malang', '081234567906', 'faisal@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(23, 'Gunawan Budi Prasetyo, ST., MMT', '197704242008121001', 'Sidoarjo', '1977-04-24', 'laki', 'Jl. Raya No. 18, Sidoarjo', '081234567907', 'gunawan.budi@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(24, 'Hendra Pradibta, SE., M.Sc', '198305212006041003', 'Probolinggo', '1983-05-21', 'laki', 'Jl. Raya No. 19, Probolinggo', '081234567908', 'hendra.pardibta@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(25, 'Imam Fahrur Rozi, ST., MT', '198406102008121004', 'Malang', '1984-06-10', 'laki', 'Jl. Raya No. 20, Malang', '081234567909', 'imam.rozi@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(26, 'Indra Dharma Wijaya, ST., MMT', '197305102008011010', 'Malang', '1973-05-10', 'laki', 'Jl. Raya No. 21, Malang', '081234567910', 'indra.dharma@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(27, 'Luqman Affandi, S.Kom., MMSI', '197305102008011013', 'Malang', '1973-02-10', 'laki', 'Jl. Raya No. 22, Malang', '081234567911', 'luqmanaffandi@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(28, 'Mungki Astiningrum, ST., M.Kom', '197710302005012001', 'Blitar', '1977-10-30', 'perempuan', 'Jl. Raya No. 23, Blitar', '081234567912', 'mungki.astingrum@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(29, 'Pramana Yoga Saputra, S.KOM., MM', '197710302005012021', 'Malang', '1977-10-25', 'laki', 'Jl. Raya No. 24, Malang', '081234567913', 'pramanayoga@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(30, 'Putra Prima Arhandi, ST., M.Kom', '198611032014041001', 'Malang', '1986-11-03', 'laki', 'Jl. Raya No. 25, Malang', '081234567914', 'putraprima@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(31, 'Rawansyah, Drs., M.Pd', '195906201994031001', 'Madiun', '1959-06-20', 'laki', 'Jl. Raya No. 26, Madiun', '081234567915', 'rawansyah@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(32, 'Ridwan Rismanto, SST., M.KOM', '198603182012121001', 'Malang', '1986-03-18', 'laki', 'Jl. Raya No. 27, Malang', '081234567916', 'rismanto@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(33, 'Rudy Ariyanto, ST, M.Cs', '197111101999031002', 'Surabaya', '1971-11-10', 'laki', 'Jl. Raya No. 28, Surabaya', '081234567917', 'ariyantorudy@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(34, 'Sekar Arum Tjhin, ST., M.T', '198106132005011004', 'Malang', '1981-06-13', 'perempuan', 'Jl. Raya No. 29, Malang', '081234567918', 'sekar.tjhin@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(35, 'Siti Nur Aisyah, S.Kom., M.Kom', '198609232010121001', 'Malang', '1986-09-23', 'perempuan', 'Jl. Raya No. 30, Malang', '081234567919', 'aisyah.nur@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(36, 'Widaningsih, S.Psi, SH., MH', '198103182010122002', 'Dosen', '1981-03-18', 'perempuan', 'Jl. Raya No. 31, Malang', '081234567920', 'widaningsih@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(37, 'Yan Watequlis Syaifudin, ST., MMT', '198101052005011005', 'Dosen', '1981-01-05', 'laki', 'Jl. Raya No. 32, Malang', '081234567921', 'qulis@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(38, 'Yushintia Pramitarini, S.ST., M.T', '198101052005011038', 'Dosen', '1981-01-09', 'perempuan', 'Jl. Raya No. 33, Malang', '081234567922', 'yushintia@polinema.ac.id', 'profil-pic.png', NULL, NULL),
(39, 'Yuri Ariyanto, S.Kom., M.Kom', '198007162010121002', 'Dosen', '1980-07-16', 'laki', 'Jl. Raya No. 34, Malang', '081234567923', 'yuri@polinema.ac.id', 'profil-pic.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_jenis_pelatihan_sertifikasi`
--

CREATE TABLE `m_jenis_pelatihan_sertifikasi` (
  `id_jenis_pelatihan_sertifikasi` bigint UNSIGNED NOT NULL,
  `nama_jenis_sertifikasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_pendek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_jenis_pelatihan_sertifikasi`
--

INSERT INTO `m_jenis_pelatihan_sertifikasi` (`id_jenis_pelatihan_sertifikasi`, `nama_jenis_sertifikasi`, `deskripsi_pendek`, `created_at`, `updated_at`) VALUES
(1, 'Data Science', 'Pelatihan yang fokus pada analisis data dan pembelajaran mesin.', '2024-12-02 06:57:21', NULL),
(2, 'Data Mining', 'Pelatihan yang mengajarkan teknik untuk mengeksplorasi dan menganalisis data besar.', '2024-12-02 06:57:21', NULL),
(3, 'Machine Learning', 'Pelatihan tentang algoritma dan teknik untuk membangun model pembelajaran otomatis.', '2024-12-02 06:57:21', NULL),
(4, 'Big Data', 'Pelatihan mengenai pengelolaan dan analisis data dalam skala besar.', '2024-12-02 06:57:21', NULL),
(5, 'Artificial Intelligence', 'Pelatihan tentang pengembangan sistem yang dapat meniru kecerdasan manusia.', '2024-12-02 06:57:21', NULL),
(6, 'Keahlian', 'Sertifikasi keahlian', NULL, NULL),
(7, 'Profesi', 'Sertifikasi profesi', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_jenis_pengguna`
--

CREATE TABLE `m_jenis_pengguna` (
  `id_jenis_pengguna` bigint UNSIGNED NOT NULL,
  `nama_jenis_pengguna` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_jenis_pengguna` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_jenis_pengguna`
--

INSERT INTO `m_jenis_pengguna` (`id_jenis_pengguna`, `nama_jenis_pengguna`, `kode_jenis_pengguna`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'ADM', '2024-12-02 06:57:21', NULL),
(2, 'Super Admin', 'SDM', '2024-12-02 06:57:21', NULL),
(3, 'Dosen', 'DSN', '2024-12-02 06:57:21', NULL),
(4, 'Pemimpin', 'PMP', '2024-12-02 06:57:21', NULL);

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
(1, 'Machine Learning', 'RTI205004', 'Pengenalan konsep machine learning dan penerapannya.', '2024-12-02 06:57:21', NULL),
(2, 'Data Mining', 'RTI205005', 'Teknik dan algoritma untuk mengekstraksi informasi dari data.', '2024-12-02 06:57:21', NULL),
(3, 'Computer Vision', 'RTI206007', 'Dasar-dasar computer vision dan aplikasi dalam kehidupan nyata.', '2024-12-02 06:57:21', NULL),
(4, 'Network Security', 'RTI204006', 'Konsep keamanan jaringan dan kriptografi.', '2024-12-02 06:57:21', NULL),
(5, 'IoT Systems', 'RTI206004', 'Pengenalan teknologi IoT dan penerapannya.', '2024-12-02 06:57:21', NULL),
(6, 'Software Engineering', 'RTI202005', 'Prinsip-prinsip pengembangan perangkat lunak.', '2024-12-02 06:57:21', NULL),
(7, 'Robotics and Automation', 'RTI205003', 'Dasar-dasar robotika dan otomatisasi.', '2024-12-02 06:57:21', NULL),
(8, 'Pancasila', 'RTI201001', 'Pengenalan dan implementasi nilai-nilai Pancasila.', '2024-12-04 03:35:46', NULL),
(9, 'Teknik Dokumentasi', 'RTI201002', 'Teknik dokumentasi perangkat lunak.', '2024-12-04 03:35:46', NULL),
(10, 'Ilmu Komunikasi Dan Organisasi', 'RTI201003', 'Dasar-dasar komunikasi dan organisasi.', '2024-12-04 03:35:46', NULL),
(11, 'Aplikasi Komputer Perkantoran', 'RTI201004', 'Penggunaan aplikasi komputer untuk perkantoran.', '2024-12-04 03:35:46', NULL),
(12, 'Bahasa Inggris 1', 'RTI201005', 'Peningkatan kemampuan bahasa Inggris dasar.', '2024-12-04 03:35:46', NULL),
(13, 'Konsep Teknologi Informasi', 'RTI201006', 'Dasar-dasar teknologi informasi.', '2024-12-04 03:35:46', NULL),
(14, 'Matematika Diskrit', 'RTI201007', 'Konsep matematika diskrit dan aplikasinya.', '2024-12-04 03:35:46', NULL),
(15, 'Keselamatan Dan Kesehatan Kerja', 'RTI201008', 'Prinsip K3 dalam dunia kerja.', '2024-12-04 03:35:46', NULL),
(16, 'Dasar Pemrograman', 'RTI201009', 'Fundamental pemrograman komputer.', '2024-12-04 03:35:46', NULL),
(17, 'Praktikum Dasar Pemrograman', 'RTI201010', 'Praktikum untuk memahami dasar pemrograman.', '2024-12-04 03:35:46', NULL),
(18, 'Agama', 'RTI202001', 'Pemahaman nilai-nilai agama dalam kehidupan.', '2024-12-04 03:35:46', NULL),
(19, 'Kewarganegaraan', 'RTI202002', 'Pendidikan kewarganegaraan untuk mahasiswa.', '2024-12-04 03:35:46', NULL),
(20, 'Bahasa Inggris 2', 'RTI202003', 'Peningkatan kemampuan bahasa Inggris lanjut.', '2024-12-04 03:35:46', NULL),
(21, 'Sistem Operasi', 'RTI202004', 'Dasar-dasar sistem operasi.', '2024-12-04 03:35:46', NULL),
(22, 'Rekayasa Perangkat Lunak', 'RTI202005', 'Konsep dan prinsip rekayasa perangkat lunak.', '2024-12-04 03:35:46', NULL),
(23, 'Aljabar Linier', 'RTI202006', 'Dasar-dasar aljabar linier.', '2024-12-04 03:35:46', NULL),
(24, 'Basis Data', 'RTI202007', 'Dasar-dasar pengelolaan basis data.', '2024-12-04 03:35:46', NULL),
(25, 'Praktikum Basis Data', 'RTI202008', 'Praktikum pengelolaan basis data.', '2024-12-04 03:35:46', NULL),
(26, 'Algoritma Dan Struktur Data', 'RTI202009', 'Konsep algoritma dan struktur data.', '2024-12-04 03:35:46', NULL),
(27, 'Praktikum Algoritma Dan Struktur Data', 'RTI202010', 'Praktikum algoritma dan struktur data.', '2024-12-04 03:35:46', NULL),
(28, 'Desain Antarmuka', 'RTI203001', 'Dasar-dasar desain antarmuka pengguna.', '2024-12-04 03:35:46', NULL),
(29, 'Analisis Dan Desain Berorientasi Objek', 'RTI203002', 'Metodologi analisis dan desain objek.', '2024-12-04 03:35:46', NULL),
(30, 'Kecerdasan Buatan', 'RTI203003', 'Dasar kecerdasan buatan dan penerapannya.', '2024-12-04 03:35:46', NULL),
(31, 'Desain & Pemrograman Web', 'RTI203004', 'Prinsip desain dan pemrograman web.', '2024-12-04 03:35:46', NULL),
(32, 'Basis Data Lanjut', 'RTI203005', 'Konsep lanjutan dalam basis data.', '2024-12-04 03:35:46', NULL),
(33, 'Matematika 3', 'RTI203006', 'Matematika lanjutan untuk informatika.', '2024-12-04 03:35:46', NULL),
(34, 'Pemrograman Berbasis Objek', 'RTI203007', 'Konsep pemrograman berorientasi objek.', '2024-12-04 03:35:46', NULL),
(35, 'Praktikum Pemrograman Berbasis Objek', 'RTI203008', 'Praktikum berorientasi objek.', '2024-12-04 03:35:46', NULL),
(36, 'Sistem Manajemen Kualitas', 'RTI203009', 'Prinsip manajemen kualitas.', '2024-12-04 03:35:46', NULL),
(37, 'Sistem Informasi Bisnis', 'RTI204010', 'Pengantar konsep sistem informasi dalam konteks bisnis dan pengambilan keputusan berbasis data.', '2024-12-04 16:13:29', NULL),
(38, 'Manajemen Sistem Informasi', 'RTI204011', 'Manajemen sumber daya teknologi informasi dalam perusahaan dan organisasi bisnis.', '2024-12-04 16:13:29', NULL),
(39, 'E-Business', 'RTI204012', 'Konsep dan implementasi teknologi informasi dalam e-business.', '2024-12-04 16:13:29', NULL),
(40, 'Sistem Pendukung Keputusan', 'RTI204013', 'Aplikasi teknologi informasi untuk mendukung pengambilan keputusan manajerial.', '2024-12-04 16:13:29', NULL),
(41, 'Enterprise Resource Planning', 'RTI204014', 'Konsep dan implementasi sistem ERP dalam mendukung proses bisnis.', '2024-12-04 16:13:29', NULL),
(42, 'Analisis Sistem Informasi', 'RTI204015', 'Metode analisis kebutuhan sistem informasi dalam organisasi.', '2024-12-04 16:13:29', NULL),
(43, 'Pengelolaan Proyek Sistem Informasi', 'RTI204016', 'Manajemen proyek pengembangan sistem informasi.', '2024-12-04 16:13:29', NULL),
(44, 'Transformasi Digital', 'RTI204017', 'Strategi dan tantangan dalam transformasi digital perusahaan.', '2024-12-04 16:13:29', NULL),
(45, 'Manajemen Rantai Pasok', 'RTI204018', 'Penerapan teknologi informasi dalam manajemen rantai pasok.', '2024-12-04 16:13:29', NULL),
(46, 'Audit Sistem Informasi', 'RTI204019', 'Konsep dan teknik audit pada sistem informasi bisnis.', '2024-12-04 16:13:29', NULL),
(47, 'Manajemen Data dan Informasi', 'RTI204020', 'Teknik pengelolaan data untuk mendukung pengambilan keputusan bisnis.', '2024-12-04 16:13:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_pelatihan`
--

CREATE TABLE `m_pelatihan` (
  `id_pelatihan` bigint UNSIGNED NOT NULL,
  `nama_pelatihan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_vendor_pelatihan` bigint UNSIGNED NOT NULL,
  `id_jenis_pelatihan_sertifikasi` bigint UNSIGNED NOT NULL,
  `level_pelatihan` enum('Nasional','Internasional') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_pelatihan`
--

INSERT INTO `m_pelatihan` (`id_pelatihan`, `nama_pelatihan`, `id_vendor_pelatihan`, `id_jenis_pelatihan_sertifikasi`, `level_pelatihan`, `created_at`, `updated_at`) VALUES
(1, 'Enterprise IT Architecture with TOGAF', 1, 2, 'Internasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(2, 'Chief Information Officer', 2, 1, 'Internasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(3, 'Data Management and Data Governance', 3, 3, 'Nasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(4, 'Business Analysis Essentials', 4, 4, 'Internasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(5, 'IT Management Essentials', 5, 5, 'Nasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(6, 'COBIT 2019', 6, 1, 'Internasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(7, 'IT Risk Management', 7, 2, 'Nasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(8, 'Governance of Enterprise IT', 8, 3, 'Internasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(9, 'Pengelolaan Layanan Teknologi Informasi', 9, 4, 'Nasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(10, 'IT Infrastructure Library Foundation 4', 10, 5, 'Internasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(11, 'IT Asset Management', 11, 1, 'Nasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(12, 'ITSM Manager', 12, 2, 'Internasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(13, 'IT Project Management', 13, 3, 'Nasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(14, 'Pengelolaan Keamanan Informasi', 14, 4, 'Internasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(15, 'ISMS Lead to Implement ISO 27001', 15, 5, 'Internasional', '2024-12-04 06:05:22', '2024-12-04 06:05:22'),
(19, 'Pelatihan Coba', 1, 1, 'Nasional', '2024-12-09 21:32:58', '2024-12-09 21:32:58'),
(20, 'Pelatihan Coba', 5, 2, 'Nasional', '2024-12-09 21:41:15', '2024-12-09 21:41:15'),
(21, 'Pelatihan Coba', 4, 1, 'Internasional', '2024-12-09 21:48:12', '2024-12-09 21:48:12'),
(22, 'Pelatihan Coba', 2, 3, 'Nasional', '2024-12-09 21:53:46', '2024-12-09 21:53:46'),
(23, 'Pelatihan Coba', 4, 2, 'Internasional', '2024-12-09 21:55:42', '2024-12-09 21:55:42'),
(24, 'Pelatihan Coba', 4, 3, 'Nasional', '2024-12-09 21:58:37', '2024-12-09 21:58:37'),
(25, 'Pelatihan lagi', 2, 2, 'Nasional', '2024-12-10 05:47:43', '2024-12-10 05:47:43'),
(26, 'Pelatihan lagi', 2, 2, 'Nasional', '2024-12-10 05:50:48', '2024-12-10 05:50:48'),
(28, 'Pelatihan lagi', 1, 1, 'Nasional', '2024-12-10 05:52:56', '2024-12-10 05:52:56'),
(29, 'Pelatihan lagi', 1, 1, 'Nasional', '2024-12-10 05:57:13', '2024-12-10 05:57:13'),
(30, 'Pelatihan lagi', 2, 2, 'Nasional', '2024-12-10 06:01:37', '2024-12-10 06:01:37'),
(31, 'Pelatihan lagi', 2, 1, 'Nasional', '2024-12-10 06:07:36', '2024-12-10 06:07:36'),
(32, 'Pelatihan lagi', 1, 2, 'Nasional', '2024-12-10 06:18:22', '2024-12-10 06:18:22'),
(33, 'Pelatihan lagi', 2, 2, 'Nasional', '2024-12-10 06:22:41', '2024-12-10 06:22:41'),
(35, 'Pelatihan lagi', 1, 2, 'Nasional', '2024-12-10 07:32:01', '2024-12-10 07:32:01');

-- --------------------------------------------------------

--
-- Table structure for table `m_periode`
--

CREATE TABLE `m_periode` (
  `id_periode` bigint UNSIGNED NOT NULL,
  `nama_periode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tahun_periode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_periode` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_periode`
--

INSERT INTO `m_periode` (`id_periode`, `nama_periode`, `tanggal_mulai`, `tanggal_selesai`, `tahun_periode`, `deskripsi_periode`, `created_at`, `updated_at`) VALUES
(1, '2024/2025', '2024-01-01', '2025-01-01', 'Ganjil', 'Periode 2024/2025 Tahun ganjil', '2024-12-02 06:57:21', NULL),
(2, '2025/2026', '2025-01-01', '2026-01-01', 'Genap', 'Periode 2025/2026 Tahun genap', '2024-12-02 06:57:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_sertifikasi`
--

CREATE TABLE `m_sertifikasi` (
  `id_sertifikasi` bigint UNSIGNED NOT NULL,
  `nama_sertifikasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_vendor_sertifikasi` bigint UNSIGNED NOT NULL,
  `id_jenis_pelatihan_sertifikasi` bigint UNSIGNED NOT NULL,
  `level_sertifikasi` enum('Nasional','Internasional') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_sertifikasi`
--

INSERT INTO `m_sertifikasi` (`id_sertifikasi`, `nama_sertifikasi`, `id_vendor_sertifikasi`, `id_jenis_pelatihan_sertifikasi`, `level_sertifikasi`, `created_at`, `updated_at`) VALUES
(1, 'Certified Ethical Hacker (CEH)', 6, 1, 'Internasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(2, 'Certified Network Defender (CND)', 6, 1, 'Internasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(3, 'MikroTik Certified Network Associate (MTCNA)', 7, 2, 'Nasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(4, 'Cisco Certified Network Associate (CCNA)', 8, 2, 'Internasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(5, 'Microsoft Certified: Azure Administrator', 9, 3, 'Internasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(6, 'Microsoft Certified: Data Analyst', 9, 3, 'Internasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(7, 'Red Hat Certified System Administrator (RHCSA)', 10, 4, 'Internasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(8, 'EPI Certified Data Centre Specialist (CDCS)', 11, 5, 'Internasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(9, 'Pearson Vue ITIL Foundation', 11, 5, 'Internasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(10, 'Pearson Vue Project Management Professional (PMP)', 11, 5, 'Internasional', '2024-12-04 06:24:34', '2024-12-04 06:24:34'),
(11, 'Sertifikasi Barru', 1, 1, 'Nasional', '2024-12-11 22:31:33', '2024-12-11 22:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `m_vendor_pelatihan`
--

CREATE TABLE `m_vendor_pelatihan` (
  `id_vendor_pelatihan` bigint UNSIGNED NOT NULL,
  `nama_vendor_pelatihan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_vendor_pelatihan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota_vendor_pelatihan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notelp_vendor_pelatihan` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `web_vendor_pelatihan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_vendor_pelatihan`
--

INSERT INTO `m_vendor_pelatihan` (`id_vendor_pelatihan`, `nama_vendor_pelatihan`, `alamat_vendor_pelatihan`, `kota_vendor_pelatihan`, `notelp_vendor_pelatihan`, `web_vendor_pelatihan`, `created_at`, `updated_at`) VALUES
(1, 'PT. Edukasi Mandiri', 'Jl. Pendidikan No. 10, Jakarta', 'Jakarta', '021-12345678', 'www.edukasimandiri.com', '2024-12-02 06:57:21', NULL),
(2, 'CV. Teknologi Canggih', 'Jl. Teknologi No. 5, Bandung', 'Bandung', '022-87654321', 'www.teknologicanggih.com', '2024-12-02 06:57:21', NULL),
(3, 'Yayasan Pelatihan Kreatif', 'Jl. Kreatif No. 20, Yogyakarta', 'Yogyakarta', '0274-1234567', 'www.pelatihankreatif.org', '2024-12-02 06:57:21', NULL),
(4, 'Lembaga Pelatihan Profesional', 'Jl. Profesional No. 15, Surabaya', 'Surabaya', '031-7654321', 'www.pelatihanprofesional.com', '2024-12-02 06:57:21', NULL),
(5, 'Institut Pelatihan Digital', 'Jl. Digital No. 30, Bali', 'Denpasar', '0361-9876543', 'www.pelatihandigital.id', '2024-12-02 06:57:21', NULL),
(6, 'TOGAF Academy', 'Jl. Merdeka No.1', 'Jakarta', '081234567890', 'www.togafacademy.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(7, 'CIO Training Center', 'Jl. Sudirman No.2', 'Bandung', '081345678901', 'www.ciotc.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(8, 'Data Governance Institute', 'Jl. Soekarno Hatta No.3', 'Surabaya', '081456789012', 'www.dgi.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(9, 'Business Analysis Academy', 'Jl. Diponegoro No.4', 'Yogyakarta', '081567890123', 'www.baacademy.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(10, 'IT Management Hub', 'Jl. Gajah Mada No.5', 'Malang', '081678901234', 'www.itmh.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(11, 'COBIT Center', 'Jl. Panglima Polim No.6', 'Jakarta', '081789012345', 'www.cobitcenter.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(12, 'Risk Management Academy', 'Jl. HOS Cokroaminoto No.7', 'Semarang', '081890123456', 'www.rma.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(13, 'Enterprise IT Governance', 'Jl. Ahmad Yani No.8', 'Medan', '081901234567', 'www.eitg.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(14, 'Teknologi Informasi Service', 'Jl. Kartini No.9', 'Bandung', '082012345678', 'www.tis.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(15, 'ITIL Foundation Academy', 'Jl. Imam Bonjol No.10', 'Jakarta', '082123456789', 'www.itilfa.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(16, 'Asset Management Solutions', 'Jl. Gatot Subroto No.11', 'Surabaya', '082234567890', 'www.ams.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(17, 'ITSM Training Center', 'Jl. Letjen S Parman No.12', 'Malang', '082345678901', 'www.itsmtc.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(18, 'Project Management Institute', 'Jl. HR Rasuna Said No.13', 'Jakarta', '082456789012', 'www.pmi.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(19, 'Keamanan Informasi Center', 'Jl. Veteran No.14', 'Yogyakarta', '082567890123', 'www.kic.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(20, 'ISO 27001 Implementation', 'Jl. Teuku Umar No.15', 'Bandung', '082678901234', 'www.iso27001.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(21, 'Information Security Training', 'Jl. Sisingamangaraja No.16', 'Medan', '082789012345', 'www.ist.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(22, 'System Auditor Academy', 'Jl. Wahidin No.17', 'Semarang', '082890123456', 'www.saa.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(23, 'Security Protection Solutions', 'Jl. MT Haryono No.18', 'Jakarta', '082901234567', 'www.sps.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(24, 'Cloud Analyst Hub', 'Jl. Pattimura No.19', 'Malang', '083012345678', 'www.cah.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(25, 'Cloud Essentials Academy', 'Jl. Sultan Agung No.20', 'Surabaya', '083123456789', 'www.cea.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(26, 'Microsoft Azure Academy', 'Jl. RA Kartini No.21', 'Jakarta', '083234567890', 'www.msazure.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(27, 'AWS Training Center', 'Jl. Diponegoro No.22', 'Bandung', '083345678901', 'www.aws.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37'),
(28, 'Azure Administrator Hub', 'Jl. MH Thamrin No.23', 'Jakarta', '083456789012', 'www.azureadmin.com', '2024-12-04 06:03:37', '2024-12-04 06:03:37');

-- --------------------------------------------------------

--
-- Table structure for table `m_vendor_sertifikasi`
--

CREATE TABLE `m_vendor_sertifikasi` (
  `id_vendor_sertifikasi` bigint UNSIGNED NOT NULL,
  `nama_vendor_sertifikasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_vendor_sertifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota_vendor_sertifikasi` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notelp_vendor_sertifikasi` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `web_vendor_sertifikasi` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_vendor_sertifikasi`
--

INSERT INTO `m_vendor_sertifikasi` (`id_vendor_sertifikasi`, `nama_vendor_sertifikasi`, `alamat_vendor_sertifikasi`, `kota_vendor_sertifikasi`, `notelp_vendor_sertifikasi`, `web_vendor_sertifikasi`, `created_at`, `updated_at`) VALUES
(1, 'PT. Sertifikasi Utama', 'Jl. Sertifikasi No. 1, Jakarta', 'Jakarta', '021-12345678', 'www.sertifikasiutama.com', '2024-12-02 06:57:21', NULL),
(2, 'CV. Edukasi Bersertifikat', 'Jl. Edukasi No. 10, Bandung', 'Bandung', '022-87654321', 'www.edukasibersertifikat.com', '2024-12-02 06:57:21', NULL),
(3, 'Lembaga Sertifikasi Profesional', 'Jl. Profesional No. 5, Yogyakarta', 'Yogyakarta', '0274-1234567', 'www.sertifikasiprofesional.org', '2024-12-02 06:57:21', NULL),
(4, 'Institut Sertifikasi Digital', 'Jl. Digital No. 15, Surabaya', 'Surabaya', '031-7654321', 'www.sertifikasidigital.com', '2024-12-02 06:57:21', NULL),
(5, 'Yayasan Sertifikasi Mandiri', 'Jl. Mandiri No. 20, Denpasar', 'Bali', '0361-9876543', 'www.sertifikasimandiri.id', '2024-12-02 06:57:21', NULL),
(6, 'EC-Council', 'Jl. Cyber Security No.10', 'Jakarta', '081234567890', 'www.eccouncil.org', '2024-12-04 06:12:20', '2024-12-04 06:12:20'),
(7, 'Mikrotik', 'Jl. Router Control No.11', 'Bandung', '081345678901', 'www.mikrotik.com', '2024-12-04 06:12:20', '2024-12-04 06:12:20'),
(8, 'Cisco', 'Jl. Networking No.12', 'Surabaya', '081456789012', 'www.cisco.com', '2024-12-04 06:12:20', '2024-12-04 06:12:20'),
(9, 'Microsoft', 'Jl. Software Solution No.13', 'Yogyakarta', '081567890123', 'www.microsoft.com', '2024-12-04 06:12:20', '2024-12-04 06:12:20'),
(10, 'RedHat', 'Jl. Open Source No.14', 'Malang', '081678901234', 'www.redhat.com', '2024-12-04 06:12:20', '2024-12-04 06:12:20'),
(11, 'EPI', 'Jl. Data Center No.15', 'Semarang', '081789012345', 'www.epi-ap.com', '2024-12-04 06:12:20', '2024-12-04 06:12:20'),
(12, 'Pearson Vue', 'Jl. Certification Test No.16', 'Medan', '081890123456', 'www.pearsonvue.com', '2024-12-04 06:12:20', '2024-12-04 06:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_detailpelatihan`
--

CREATE TABLE `t_detailpelatihan` (
  `id_detail_pelatihan` bigint UNSIGNED NOT NULL,
  `id_pelatihan` bigint UNSIGNED NOT NULL,
  `id_periode` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `lokasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quota_peserta` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya` int NOT NULL,
  `no_pelatihan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_pelatihan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_disetujui` enum('iya','tidak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_by` enum('admin','dosen') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_tugas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_detailpelatihan`
--

INSERT INTO `t_detailpelatihan` (`id_detail_pelatihan`, `id_pelatihan`, `id_periode`, `id_user`, `tanggal_mulai`, `tanggal_selesai`, `lokasi`, `quota_peserta`, `biaya`, `no_pelatihan`, `bukti_pelatihan`, `status_disetujui`, `input_by`, `surat_tugas`, `created_at`, `updated_at`) VALUES
(2, 6, 1, 6, '2024-12-01', '2024-12-05', 'Jakarta', NULL, 122222, 'SERTIF12346000988', 'bukti_6_21.pdf', NULL, 'dosen', NULL, '2024-12-05 16:20:08', '2024-12-11 11:03:10'),
(4, 8, 1, 6, '2024-12-01', '2024-12-03', 'NTT', NULL, 1000000, 'SERTIF12346000985', NULL, NULL, 'dosen', NULL, '2024-12-05 16:26:05', '2024-12-05 16:26:05'),
(5, 11, 1, 6, '2024-12-01', '2024-12-04', 'Malang', NULL, 8000000, 'SERTIF12346000983', NULL, NULL, 'dosen', NULL, '2024-12-05 16:51:52', '2024-12-05 16:51:52'),
(6, 4, 1, 6, '2024-12-01', '2024-12-02', 'jakarta', NULL, 900000, 'SERTIF12346000982', 'bukti_6_7.png', NULL, 'dosen', NULL, '2024-12-05 16:54:16', '2024-12-05 16:54:16'),
(7, 1, 1, 6, '2024-12-24', '2024-12-31', 'NTT', NULL, 80000, '345678900009', 'bukti_6_8.pdf', NULL, 'dosen', NULL, '2024-12-08 18:30:36', '2024-12-08 18:30:37'),
(11, 19, 1, 6, '2024-12-11', '2024-12-11', 'Jakarta', NULL, 800000, 'SERTIF12346000989', 'bukti_6_19.pdf', NULL, 'dosen', NULL, '2024-12-09 21:32:58', '2024-12-09 21:32:58'),
(12, 20, 1, 6, '2024-12-12', '2024-12-20', 'malang', NULL, 5000, 'SERTIF12346000989', 'bukti_6_20.pdf', NULL, 'dosen', NULL, '2024-12-09 21:41:15', '2024-12-09 21:41:15'),
(13, 21, 1, 6, '2024-12-11', '2024-12-27', 'malang', NULL, 5000, 'SERTIF12346000983', 'bukti_6_21.pdf', NULL, 'dosen', NULL, '2024-12-09 21:48:12', '2024-12-09 21:48:12'),
(14, 22, 1, 6, '2024-12-12', '2024-12-25', 'malang', NULL, 50000, 'SERTIF12346000985', 'bukti_6_22.pdf', NULL, 'dosen', NULL, '2024-12-09 21:53:46', '2024-12-09 21:53:47'),
(15, 23, 1, 6, '2024-12-11', '2024-12-27', 'malang', NULL, 5000, 'SERTIF12346000987', 'bukti_6_23.pdf', NULL, 'dosen', NULL, '2024-12-09 21:55:42', '2024-12-09 21:55:42'),
(17, 25, 1, 6, '2024-12-11', '2024-12-11', 'Jakarta', NULL, 60000, '5678900000oooo', 'bukti_6_25.pdf', NULL, 'dosen', NULL, '2024-12-10 05:47:43', '2024-12-11 11:00:28'),
(18, 26, 1, 6, '2024-12-11', '2024-12-11', 'Semarang', NULL, 60000, '5678900000oooo', 'bukti_6_26.pdf', NULL, 'dosen', NULL, '2024-12-10 05:50:48', '2024-12-10 05:50:49'),
(20, 28, 1, 6, '2024-12-10', '2024-12-11', 'Semarang', NULL, 50000, '345678900000', 'bukti_6_28.pdf', NULL, 'dosen', NULL, '2024-12-10 05:52:56', '2024-12-10 05:52:56'),
(21, 29, 1, 6, '2024-12-11', '2024-12-12', 'Semarang', NULL, 6000, '345678900op', 'bukti_6_29.pdf', NULL, 'dosen', NULL, '2024-12-10 05:57:13', '2024-12-10 05:57:13'),
(22, 30, 1, 6, '2024-12-11', '2024-12-11', 'Jakarta', NULL, 40000, '45678900', 'bukti_6_30.pdf', NULL, 'dosen', NULL, '2024-12-10 06:01:37', '2024-12-10 06:01:37'),
(23, 31, 1, 6, '2024-12-17', '2024-12-11', 'Semarang', NULL, 60000, '567899900', 'bukti_6_31.pdf', NULL, 'dosen', NULL, '2024-12-10 06:07:36', '2024-12-10 06:07:36'),
(24, 32, 1, 6, '2024-12-03', '2024-12-11', 'Bandung', NULL, 455567890, '456789000', 'bukti_6_32.pdf', NULL, 'dosen', NULL, '2024-12-10 06:18:22', '2024-12-10 06:18:22'),
(25, 33, 1, 6, '2024-12-11', '2024-12-11', '5780000', NULL, 60009, '7099990000', 'bukti_6_33.pdf', NULL, 'dosen', NULL, '2024-12-10 06:22:41', '2024-12-10 06:22:41'),
(27, 35, 1, 6, '2024-12-10', '2024-12-11', 'Malang', NULL, 56789000, 'SERTIF12346000988', 'bukti_6_23.pdf', NULL, 'dosen', NULL, '2024-12-10 07:32:01', '2024-12-10 07:32:01'),
(28, 2, 1, 6, '2024-12-11', '2024-12-11', 'Jakarta', NULL, 9000, 'SERTIF12346000985', 'bukti_6_24.pdf', NULL, 'dosen', NULL, '2024-12-10 07:34:26', '2024-12-11 11:00:52'),
(30, 1, 1, 6, '2024-12-11', '2024-12-13', 'Malang', NULL, 6789000, 'SERTIFFFF', 'bukti_6_22.pdf', NULL, 'dosen', NULL, '2024-12-11 20:25:47', '2024-12-11 20:25:47'),
(31, 1, 1, 7, '2024-12-13', '2024-12-21', 'Jakarta', '10', 700000, 'SERTIF70000', 'bukti_6_23.pdf', NULL, 'admin', 'suratugas1.pdf', '2024-12-11 22:19:06', '2024-12-11 22:19:06'),
(33, 1, 1, 6, '2024-12-13', '2024-12-21', 'Jakarta', NULL, 700000, 'SERTIF70000', 'bukti_6_23.pdf', NULL, 'dosen', NULL, '2024-12-12 20:53:50', '2024-12-12 20:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `t_detailsertifikasi`
--

CREATE TABLE `t_detailsertifikasi` (
  `id_detail_sertifikasi` bigint UNSIGNED NOT NULL,
  `id_sertifikasi` bigint UNSIGNED NOT NULL,
  `id_periode` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `lokasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quota_peserta` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya` int NOT NULL,
  `no_sertifikasi` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_sertifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_kadaluarsa` date DEFAULT NULL,
  `status_disetujui` enum('iya','tidak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_by` enum('admin','dosen') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_tugas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_detailsertifikasi`
--

INSERT INTO `t_detailsertifikasi` (`id_detail_sertifikasi`, `id_sertifikasi`, `id_periode`, `id_user`, `tanggal_mulai`, `tanggal_selesai`, `lokasi`, `quota_peserta`, `biaya`, `no_sertifikasi`, `bukti_sertifikasi`, `tanggal_kadaluarsa`, `status_disetujui`, `input_by`, `surat_tugas`, `created_at`, `updated_at`) VALUES
(2, 11, 1, 6, '2024-12-25', '2024-12-27', 'Jakarta', NULL, 0, 'SERTIFFFFFF', 'bukti_6_2.pdf', '2025-01-08', NULL, 'dosen', NULL, '2024-12-11 22:31:33', '2024-12-11 22:31:33'),
(3, 10, 1, 7, '2024-12-13', '2024-12-27', 'Semarang', '5', 7000000, NULL, NULL, NULL, NULL, 'admin', 'suratugas1.pdf', NULL, NULL),
(4, 10, 1, 6, '2024-12-13', '2024-12-27', 'Semarang', NULL, 7000000, 'SERTIFFF678', 'bukti_6_3.pdf', '2024-12-31', NULL, 'dosen', NULL, '2024-12-12 22:07:52', '2024-12-12 22:07:52');

-- --------------------------------------------------------

--
-- Table structure for table `t_peserta_pelatihan`
--

CREATE TABLE `t_peserta_pelatihan` (
  `id_peserta` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_detail_pelatihan` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_peserta_pelatihan`
--

INSERT INTO `t_peserta_pelatihan` (`id_peserta`, `id_user`, `id_detail_pelatihan`) VALUES
(1, 6, 31),
(2, 5, 31),
(3, 6, 24);

-- --------------------------------------------------------

--
-- Table structure for table `t_peserta_sertifikasi`
--

CREATE TABLE `t_peserta_sertifikasi` (
  `id_peserta` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_detail_sertifikasi` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_peserta_sertifikasi`
--

INSERT INTO `t_peserta_sertifikasi` (`id_peserta`, `id_user`, `id_detail_sertifikasi`) VALUES
(1, 6, 3),
(2, 3, 3);

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

--
-- Dumping data for table `t_tagging_bd_pelatihan`
--

INSERT INTO `t_tagging_bd_pelatihan` (`id_tagging_bd`, `id_pelatihan`, `id_bd`, `created_at`, `updated_at`) VALUES
(1, 19, 12, '2024-12-09 21:32:58', '2024-12-09 21:32:58'),
(2, 19, 14, '2024-12-09 21:32:58', '2024-12-09 21:32:58'),
(3, 20, 12, '2024-12-09 21:41:15', '2024-12-09 21:41:15'),
(4, 20, 14, '2024-12-09 21:41:15', '2024-12-09 21:41:15'),
(5, 21, 12, '2024-12-09 21:48:12', '2024-12-09 21:48:12'),
(6, 21, 14, '2024-12-09 21:48:12', '2024-12-09 21:48:12'),
(7, 22, 12, '2024-12-09 21:53:47', '2024-12-09 21:53:47'),
(8, 22, 14, '2024-12-09 21:53:47', '2024-12-09 21:53:47'),
(9, 23, 12, '2024-12-09 21:55:42', '2024-12-09 21:55:42'),
(10, 23, 14, '2024-12-09 21:55:42', '2024-12-09 21:55:42'),
(11, 24, 12, '2024-12-09 21:58:37', '2024-12-09 21:58:37'),
(12, 24, 14, '2024-12-09 21:58:37', '2024-12-09 21:58:37'),
(15, 26, 17, '2024-12-10 05:50:49', '2024-12-10 05:50:49'),
(16, 26, 19, '2024-12-10 05:50:49', '2024-12-10 05:50:49'),
(17, 28, 30, '2024-12-10 05:52:56', '2024-12-10 05:52:56'),
(18, 28, 32, '2024-12-10 05:52:56', '2024-12-10 05:52:56'),
(19, 29, 28, '2024-12-10 05:57:13', '2024-12-10 05:57:13'),
(20, 29, 30, '2024-12-10 05:57:13', '2024-12-10 05:57:13'),
(21, 30, 17, '2024-12-10 06:01:37', '2024-12-10 06:01:37'),
(22, 30, 19, '2024-12-10 06:01:37', '2024-12-10 06:01:37'),
(23, 31, 32, '2024-12-10 06:07:36', '2024-12-10 06:07:36'),
(24, 31, 34, '2024-12-10 06:07:36', '2024-12-10 06:07:36'),
(25, 32, 24, '2024-12-10 06:18:22', '2024-12-10 06:18:22'),
(26, 32, 26, '2024-12-10 06:18:22', '2024-12-10 06:18:22'),
(27, 33, 24, '2024-12-10 06:22:41', '2024-12-10 06:22:41'),
(28, 33, 26, '2024-12-10 06:22:41', '2024-12-10 06:22:41'),
(29, 35, 14, '2024-12-10 07:32:01', '2024-12-10 07:32:01'),
(30, 35, 16, '2024-12-10 07:32:01', '2024-12-10 07:32:01'),
(39, 25, 17, '2024-12-11 11:00:28', '2024-12-11 11:00:28'),
(40, 25, 19, '2024-12-11 11:00:28', '2024-12-11 11:00:28'),
(45, 6, 26, '2024-12-11 11:03:10', '2024-12-11 11:03:10'),
(46, 6, 28, '2024-12-11 11:03:10', '2024-12-11 11:03:10');

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

--
-- Dumping data for table `t_tagging_bd_sertifikasi`
--

INSERT INTO `t_tagging_bd_sertifikasi` (`id_tagging_bd`, `id_sertifikasi`, `id_bd`, `created_at`, `updated_at`) VALUES
(1, 1, 28, '2024-12-11 21:15:34', '2024-12-11 21:15:34'),
(2, 1, 30, '2024-12-11 21:15:34', '2024-12-11 21:15:34'),
(3, 11, 24, '2024-12-11 22:31:33', '2024-12-11 22:31:33'),
(4, 11, 26, '2024-12-11 22:31:33', '2024-12-11 22:31:33');

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

--
-- Dumping data for table `t_tagging_mk_pelatihan`
--

INSERT INTO `t_tagging_mk_pelatihan` (`id_tagging_mk`, `id_pelatihan`, `id_mk`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-12-04 16:34:14', NULL),
(2, 1, 2, '2024-12-04 16:34:14', NULL),
(3, 2, 3, '2024-12-04 16:34:14', NULL),
(4, 2, 4, '2024-12-04 16:34:14', NULL),
(5, 3, 5, '2024-12-04 16:34:14', NULL),
(6, 3, 6, '2024-12-04 16:34:14', NULL),
(7, 4, 7, '2024-12-04 16:34:14', NULL),
(8, 4, 8, '2024-12-04 16:34:14', NULL),
(9, 5, 9, '2024-12-04 16:34:14', NULL),
(10, 5, 10, '2024-12-04 16:34:14', NULL),
(11, 19, 10, '2024-12-09 21:32:58', '2024-12-09 21:32:58'),
(12, 19, 12, '2024-12-09 21:32:58', '2024-12-09 21:32:58'),
(13, 20, 10, '2024-12-09 21:41:15', '2024-12-09 21:41:15'),
(14, 20, 12, '2024-12-09 21:41:15', '2024-12-09 21:41:15'),
(15, 21, 10, '2024-12-09 21:48:12', '2024-12-09 21:48:12'),
(16, 21, 12, '2024-12-09 21:48:12', '2024-12-09 21:48:12'),
(17, 22, 10, '2024-12-09 21:53:47', '2024-12-09 21:53:47'),
(18, 22, 12, '2024-12-09 21:53:47', '2024-12-09 21:53:47'),
(19, 23, 10, '2024-12-09 21:55:42', '2024-12-09 21:55:42'),
(20, 23, 12, '2024-12-09 21:55:42', '2024-12-09 21:55:42'),
(21, 24, 10, '2024-12-09 21:58:37', '2024-12-09 21:58:37'),
(22, 24, 12, '2024-12-09 21:58:37', '2024-12-09 21:58:37'),
(23, 25, 22, '2024-12-10 05:47:44', '2024-12-10 05:47:44'),
(24, 25, 24, '2024-12-10 05:47:44', '2024-12-10 05:47:44'),
(25, 26, 22, '2024-12-10 05:50:49', '2024-12-10 05:50:49'),
(26, 26, 24, '2024-12-10 05:50:49', '2024-12-10 05:50:49'),
(27, 28, 24, '2024-12-10 05:52:56', '2024-12-10 05:52:56'),
(28, 28, 26, '2024-12-10 05:52:56', '2024-12-10 05:52:56'),
(29, 29, 22, '2024-12-10 05:57:13', '2024-12-10 05:57:13'),
(30, 29, 24, '2024-12-10 05:57:13', '2024-12-10 05:57:13'),
(31, 30, 22, '2024-12-10 06:01:37', '2024-12-10 06:01:37'),
(32, 30, 24, '2024-12-10 06:01:37', '2024-12-10 06:01:37'),
(33, 31, 26, '2024-12-10 06:07:36', '2024-12-10 06:07:36'),
(34, 31, 28, '2024-12-10 06:07:36', '2024-12-10 06:07:36'),
(35, 32, 20, '2024-12-10 06:18:22', '2024-12-10 06:18:22'),
(36, 32, 22, '2024-12-10 06:18:22', '2024-12-10 06:18:22'),
(37, 33, 22, '2024-12-10 06:22:41', '2024-12-10 06:22:41'),
(38, 33, 24, '2024-12-10 06:22:41', '2024-12-10 06:22:41'),
(39, 35, 18, '2024-12-10 07:32:01', '2024-12-10 07:32:01'),
(40, 35, 20, '2024-12-10 07:32:01', '2024-12-10 07:32:01'),
(41, 6, 22, '2024-12-11 11:01:34', '2024-12-11 11:01:34'),
(42, 6, 24, '2024-12-11 11:01:34', '2024-12-11 11:01:34');

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
-- Dumping data for table `t_tagging_mk_sertifikasi`
--

INSERT INTO `t_tagging_mk_sertifikasi` (`id_tagging_mk`, `id_sertifikasi`, `id_mk`, `created_at`, `updated_at`) VALUES
(1, 1, 22, '2024-12-11 21:15:34', '2024-12-11 21:15:34'),
(2, 1, 24, '2024-12-11 21:15:34', '2024-12-11 21:15:34'),
(3, 11, 16, '2024-12-11 22:31:33', '2024-12-11 22:31:33'),
(4, 11, 18, '2024-12-11 22:31:33', '2024-12-11 22:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
  ADD KEY `m_akun_user_id_identitas_foreign` (`id_identitas`),
  ADD KEY `m_akun_user_id_jenis_pengguna_foreign` (`id_jenis_pengguna`);

--
-- Indexes for table `m_bidang_minat`
--
ALTER TABLE `m_bidang_minat`
  ADD PRIMARY KEY (`id_bd`);

--
-- Indexes for table `m_detailbddosen`
--
ALTER TABLE `m_detailbddosen`
  ADD PRIMARY KEY (`id_detailbd`),
  ADD KEY `m_detailbddosen_id_user_index` (`id_user`),
  ADD KEY `m_detailbddosen_id_bd_index` (`id_bd`);

--
-- Indexes for table `m_detailmkdosen`
--
ALTER TABLE `m_detailmkdosen`
  ADD PRIMARY KEY (`id_detailmk`),
  ADD KEY `m_detailmkdosen_id_user_index` (`id_user`),
  ADD KEY `m_detailmkdosen_id_mk_index` (`id_mk`);

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
  ADD KEY `m_pelatihan_id_jenis_pelatihan_sertifikasi_index` (`id_jenis_pelatihan_sertifikasi`);

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
  ADD KEY `m_sertifikasi_id_jenis_pelatihan_sertifikasi_index` (`id_jenis_pelatihan_sertifikasi`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `t_detailpelatihan`
--
ALTER TABLE `t_detailpelatihan`
  ADD PRIMARY KEY (`id_detail_pelatihan`),
  ADD KEY `t_detailpelatihan_id_pelatihan_index` (`id_pelatihan`),
  ADD KEY `t_detailpelatihan_id_periode_index` (`id_periode`),
  ADD KEY `t_detailpelatihan_id_user_index` (`id_user`);

--
-- Indexes for table `t_detailsertifikasi`
--
ALTER TABLE `t_detailsertifikasi`
  ADD PRIMARY KEY (`id_detail_sertifikasi`),
  ADD KEY `t_detailsertifikasi_id_sertifikasi_index` (`id_sertifikasi`),
  ADD KEY `t_detailsertifikasi_id_periode_index` (`id_periode`),
  ADD KEY `t_detailsertifikasi_id_user_index` (`id_user`);

--
-- Indexes for table `t_peserta_pelatihan`
--
ALTER TABLE `t_peserta_pelatihan`
  ADD PRIMARY KEY (`id_peserta`),
  ADD KEY `t_peserta_pelatihan_id_user_index` (`id_user`),
  ADD KEY `t_peserta_pelatihan_id_detail_pelatihan_index` (`id_detail_pelatihan`);

--
-- Indexes for table `t_peserta_sertifikasi`
--
ALTER TABLE `t_peserta_sertifikasi`
  ADD PRIMARY KEY (`id_peserta`),
  ADD KEY `t_peserta_sertifikasi_id_user_index` (`id_user`),
  ADD KEY `t_peserta_sertifikasi_id_detail_sertifikasi_index` (`id_detail_sertifikasi`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `m_akun_user`
--
ALTER TABLE `m_akun_user`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `m_bidang_minat`
--
ALTER TABLE `m_bidang_minat`
  MODIFY `id_bd` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `m_detailbddosen`
--
ALTER TABLE `m_detailbddosen`
  MODIFY `id_detailbd` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_detailmkdosen`
--
ALTER TABLE `m_detailmkdosen`
  MODIFY `id_detailmk` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_identitas_diri`
--
ALTER TABLE `m_identitas_diri`
  MODIFY `id_identitas` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `m_jenis_pelatihan_sertifikasi`
--
ALTER TABLE `m_jenis_pelatihan_sertifikasi`
  MODIFY `id_jenis_pelatihan_sertifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `m_jenis_pengguna`
--
ALTER TABLE `m_jenis_pengguna`
  MODIFY `id_jenis_pengguna` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_mata_kuliah`
--
ALTER TABLE `m_mata_kuliah`
  MODIFY `id_mk` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `m_pelatihan`
--
ALTER TABLE `m_pelatihan`
  MODIFY `id_pelatihan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `m_periode`
--
ALTER TABLE `m_periode`
  MODIFY `id_periode` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_sertifikasi`
--
ALTER TABLE `m_sertifikasi`
  MODIFY `id_sertifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `m_vendor_pelatihan`
--
ALTER TABLE `m_vendor_pelatihan`
  MODIFY `id_vendor_pelatihan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `m_vendor_sertifikasi`
--
ALTER TABLE `m_vendor_sertifikasi`
  MODIFY `id_vendor_sertifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_detailpelatihan`
--
ALTER TABLE `t_detailpelatihan`
  MODIFY `id_detail_pelatihan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `t_detailsertifikasi`
--
ALTER TABLE `t_detailsertifikasi`
  MODIFY `id_detail_sertifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_peserta_pelatihan`
--
ALTER TABLE `t_peserta_pelatihan`
  MODIFY `id_peserta` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_peserta_sertifikasi`
--
ALTER TABLE `t_peserta_sertifikasi`
  MODIFY `id_peserta` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_tagging_bd_pelatihan`
--
ALTER TABLE `t_tagging_bd_pelatihan`
  MODIFY `id_tagging_bd` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `t_tagging_bd_sertifikasi`
--
ALTER TABLE `t_tagging_bd_sertifikasi`
  MODIFY `id_tagging_bd` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_tagging_mk_pelatihan`
--
ALTER TABLE `t_tagging_mk_pelatihan`
  MODIFY `id_tagging_mk` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `t_tagging_mk_sertifikasi`
--
ALTER TABLE `t_tagging_mk_sertifikasi`
  MODIFY `id_tagging_mk` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_akun_user`
--
ALTER TABLE `m_akun_user`
  ADD CONSTRAINT `m_akun_user_id_identitas_foreign` FOREIGN KEY (`id_identitas`) REFERENCES `m_identitas_diri` (`id_identitas`),
  ADD CONSTRAINT `m_akun_user_id_jenis_pengguna_foreign` FOREIGN KEY (`id_jenis_pengguna`) REFERENCES `m_jenis_pengguna` (`id_jenis_pengguna`);

--
-- Constraints for table `m_detailbddosen`
--
ALTER TABLE `m_detailbddosen`
  ADD CONSTRAINT `m_detailbddosen_id_bd_foreign` FOREIGN KEY (`id_bd`) REFERENCES `m_bidang_minat` (`id_bd`),
  ADD CONSTRAINT `m_detailbddosen_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `m_akun_user` (`id_user`);

--
-- Constraints for table `m_detailmkdosen`
--
ALTER TABLE `m_detailmkdosen`
  ADD CONSTRAINT `m_detailmkdosen_id_mk_foreign` FOREIGN KEY (`id_mk`) REFERENCES `m_mata_kuliah` (`id_mk`),
  ADD CONSTRAINT `m_detailmkdosen_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `m_akun_user` (`id_user`);

--
-- Constraints for table `m_pelatihan`
--
ALTER TABLE `m_pelatihan`
  ADD CONSTRAINT `m_pelatihan_id_jenis_pelatihan_sertifikasi_foreign` FOREIGN KEY (`id_jenis_pelatihan_sertifikasi`) REFERENCES `m_jenis_pelatihan_sertifikasi` (`id_jenis_pelatihan_sertifikasi`),
  ADD CONSTRAINT `m_pelatihan_id_vendor_pelatihan_foreign` FOREIGN KEY (`id_vendor_pelatihan`) REFERENCES `m_vendor_pelatihan` (`id_vendor_pelatihan`);

--
-- Constraints for table `m_sertifikasi`
--
ALTER TABLE `m_sertifikasi`
  ADD CONSTRAINT `m_sertifikasi_id_jenis_pelatihan_sertifikasi_foreign` FOREIGN KEY (`id_jenis_pelatihan_sertifikasi`) REFERENCES `m_jenis_pelatihan_sertifikasi` (`id_jenis_pelatihan_sertifikasi`),
  ADD CONSTRAINT `m_sertifikasi_id_vendor_sertifikasi_foreign` FOREIGN KEY (`id_vendor_sertifikasi`) REFERENCES `m_vendor_sertifikasi` (`id_vendor_sertifikasi`);

--
-- Constraints for table `t_detailpelatihan`
--
ALTER TABLE `t_detailpelatihan`
  ADD CONSTRAINT `t_detailpelatihan_id_pelatihan_foreign` FOREIGN KEY (`id_pelatihan`) REFERENCES `m_pelatihan` (`id_pelatihan`),
  ADD CONSTRAINT `t_detailpelatihan_id_periode_foreign` FOREIGN KEY (`id_periode`) REFERENCES `m_periode` (`id_periode`),
  ADD CONSTRAINT `t_detailpelatihan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `m_akun_user` (`id_user`);

--
-- Constraints for table `t_detailsertifikasi`
--
ALTER TABLE `t_detailsertifikasi`
  ADD CONSTRAINT `t_detailsertifikasi_id_periode_foreign` FOREIGN KEY (`id_periode`) REFERENCES `m_periode` (`id_periode`),
  ADD CONSTRAINT `t_detailsertifikasi_id_sertifikasi_foreign` FOREIGN KEY (`id_sertifikasi`) REFERENCES `m_sertifikasi` (`id_sertifikasi`),
  ADD CONSTRAINT `t_detailsertifikasi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `m_akun_user` (`id_user`);

--
-- Constraints for table `t_peserta_pelatihan`
--
ALTER TABLE `t_peserta_pelatihan`
  ADD CONSTRAINT `t_peserta_pelatihan_id_detail_pelatihan_foreign` FOREIGN KEY (`id_detail_pelatihan`) REFERENCES `t_detailpelatihan` (`id_detail_pelatihan`),
  ADD CONSTRAINT `t_peserta_pelatihan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `m_akun_user` (`id_user`);

--
-- Constraints for table `t_peserta_sertifikasi`
--
ALTER TABLE `t_peserta_sertifikasi`
  ADD CONSTRAINT `t_peserta_sertifikasi_id_detail_sertifikasi_foreign` FOREIGN KEY (`id_detail_sertifikasi`) REFERENCES `t_detailsertifikasi` (`id_detail_sertifikasi`),
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
