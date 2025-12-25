-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 25, 2025 at 08:12 AM
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
-- Database: `arc`
--

-- --------------------------------------------------------

--
-- Table structure for table `academies`
--

CREATE TABLE `academies` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `instructor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructor_role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academies`
--

INSERT INTO `academies` (`id`, `title`, `slug`, `category`, `price`, `instructor_name`, `instructor_role`, `description`, `thumbnail`, `created_at`, `updated_at`) VALUES
(5, 'Lightning Unreal : Basic', 'lightning-unreal-basic', 'LRC', 150000, 'Dawa\'i Fathulwally', NULL, 'Recorded Digital Course Lighting Dawa\'l Fathulwally Founder of Dream Ratio Studio Understanding lighting in animation from the logic thinking to set up the right way lighting in Unreel \n• 12 Videos \n• Over 9 hours of content \n• Workbook PDF \n•  Exercises and Prompts  \n• Additional Resources List \n• Lifetime Updates', 'thumbnails/QCte6XOm4ObqPPo4ZbpwAwpnNHdUW2uMghBUzCaK.jpg', '2025-12-18 03:58:01', '2025-12-18 03:58:01'),
(6, 'Animation Fundamentals: Bringing Characters to Life', 'animation-fundamentals-bringing-characters-to-life', 'Animation', 150000, 'Dawa\'i Fathulwally', NULL, 'Prinsip dasar animasi (timing, spacing, weight, dan flow)\n\nPosing dan basic movement\n\nPengenalan rigging dan kontrol karakter\n\nWorkflow animasi dari konsep hingga hasil akhir\n\nTips membuat animasi terlihat natural dan menarik', 'thumbnails/4CTVkoj2HDNBbIiakvrIMGpHVzLecpWIL0OtqKN8.jpg', '2025-12-18 08:38:38', '2025-12-18 08:38:38'),
(7, 'Coffee Making ', 'coffee-making', 'Animation', 150000, 'Riki ', NULL, 'Tutorial membuat coffee', NULL, '2025-12-18 20:59:04', '2025-12-18 20:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'i:1;', 1766646991),
('laravel-cache-0ade7c2cf97f75d009975f4d720d1fa6c19f4897:timer', 'i:1766646991;', 1766646991),
('laravel-cache-902ba3cda1883801594b6e1b452790cc53948fda', 'i:1;', 1766634942),
('laravel-cache-902ba3cda1883801594b6e1b452790cc53948fda:timer', 'i:1766634942;', 1766634942),
('laravel-cache-c1dfd96eea8cc2b62785275bca38ac261256e278', 'i:1;', 1766634030),
('laravel-cache-c1dfd96eea8cc2b62785275bca38ac261256e278:timer', 'i:1766634030;', 1766634030),
('laravel-cache-e10fd735ad88f21f45ee9e47870c152d', 'i:1;', 1766647349),
('laravel-cache-e10fd735ad88f21f45ee9e47870c152d:timer', 'i:1766647349;', 1766647349),
('laravel-cache-fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f', 'i:1;', 1766643280),
('laravel-cache-fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f:timer', 'i:1766643280;', 1766643280);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `academy_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint UNSIGNED NOT NULL,
  `academy_id` bigint UNSIGNED NOT NULL,
  `section_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_22_145432_add_two_factor_columns_to_users_table', 1),
(5, '2025_12_16_160329_add_role_to_users_table', 2),
(6, '2025_12_14_094441_add_email_verified_at_to_users_table', 3),
(7, '2025_12_18_025745_create_posts_table', 3),
(8, '2025_12_18_084023_create_academies_table', 4),
(9, '2025_12_18_084236_create_lessons_table', 4),
(10, '2025_12_18_110854_create_enrollments_table', 5),
(11, '2025_12_25_011243_add_profile_fields_to_users_table', 6),
(12, '2025_12_25_045816_add_details_to_users_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `slug`, `thumbnail`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Ciri Khas Animasi Lembut dan Emosional dari Kyoto Animation', 'ciri-khas-animasi-lembut-dan-emosional-dari-kyoto-animation', 'thumbnails/TrbyvfSb7MvDsqGqeK2AiJGdKkyEhBuwYzFQim9n.jpg', 'Mengapa Kyoto Animation Terlihat Berbeda?\n\nDi antara banyak studio anime Jepang, Kyoto Animation (KyoAni) dikenal memiliki visual yang lembut, detail, dan sangat emosional. Kualitas ini tidak hanya terlihat indah secara teknis, tetapi juga mampu membuat penonton merasakan emosi karakter tanpa banyak dialog.\n\nKyoAni bukan sekadar memproduksi anime, mereka membangun pengalaman visual.\n\n1. Gerakan Halus yang Terasa “Hidup”\n\nCiri paling menonjol dari KyoAni adalah smooth animation. Gerakan kecil seperti:\n\ntangan yang gemetar,\n\nmata yang berkedip pelan,\n\nhelaan napas karakter,\n\ndigambar dengan penuh perhatian. Hal ini menciptakan kesan realistis dan manusiawi, sesuatu yang jarang diperhatikan studio lain karena keterbatasan waktu produksi.\n\n2. Ekspresi Emosi Lewat Detail Mikro\n\nKyoAni ahli menyampaikan emosi melalui:\n\nperubahan ekspresi wajah yang sangat halus,\n\nbahasa tubuh natural,\n\njeda visual (pause) yang tepat.\n\nAlih-alih dramatis berlebihan, emosi dibangun secara sunyi namun menghantam perasaan. Penonton sering merasa “terkena” tanpa tahu persis kenapa.\n\n3. Palet Warna Lembut dan Hangat\n\nVisual KyoAni didominasi oleh:\n\nwarna pastel,\n\npencahayaan natural,\n\ngradasi lembut.\n\nPendekatan ini membuat suasana terasa hangat, tenang, dan intim, sangat cocok untuk anime bertema slice of life, drama, dan coming-of-age.\n\n4. Background Art yang Mendukung Mood\n\nLatar belakang tidak pernah sekadar pelengkap. Lingkungan dalam anime KyoAni:\n\nterasa hidup,\n\nkonsisten secara cahaya dan warna,\n\nmemperkuat emosi adegan.\n\nBackground sering digunakan sebagai alat storytelling, bukan hanya dekorasi visual.\n\n5. Fokus pada Cerita Manusia\n\nSecara visual, KyoAni jarang menonjolkan aksi berlebihan. Sebaliknya, mereka menaruh fokus pada:\n\nrelasi antar karakter,\n\nkonflik batin,\n\nmomen sehari-hari yang sederhana.\n\nPendekatan visual ini membuat penonton merasa dekat dan terhubung dengan cerita.\n\nKenapa Ini Penting bagi Pecinta Visual & Desain?\n\nBagi ilustrator, animator, dan desainer visual, karya KyoAni adalah contoh bahwa:\n\ndetail kecil punya dampak besar,\n\nvisual bisa menyampaikan emosi tanpa kata,\n\nkonsistensi gaya lebih penting daripada efek berlebihan.\n\nKyoto Animation membuktikan bahwa kelembutan visual adalah kekuatan, bukan kelemahan.\n\nPenutup\n\nCiri khas animasi Kyoto Animation terletak pada kepekaan visual terhadap emosi manusia. Setiap frame dibuat dengan empati, ketelitian, dan rasa hormat terhadap cerita.\n\nBagi siapa pun yang tertarik pada dunia visual dan desain, karya KyoAni adalah referensi emas tentang bagaimana animasi bisa menjadi bahasa perasaan.', 'published', '2025-12-17 21:51:57', '2025-12-17 21:51:57'),
(2, 2, 'Belajar Animasi Jadi Tren Baru : Dari Hobi Jadi Skill Masa Depan', 'belajar-animasi-jadi-tren-baru-dari-hobi-jadi-skill-masa-depan', 'thumbnails/vU412tbo0pWwgN6ocY5yN3gtocfbE7q3umGIVf4o.png', 'Dalam beberapa tahun terakhir, animasi tidak lagi dianggap sebagai bidang eksklusif untuk studio besar atau profesional senior. Di kalangan Gen Z, belajar animasi justru menjadi salah satu tren paling populer dalam dunia kreatif digital. Mulai dari konten TikTok, YouTube, hingga game dan NFT, animasi hadir sebagai medium ekspresi yang powerful dan penuh peluang.\n\nGen Z dikenal sebagai generasi visual dan digital-native. Mereka tumbuh bersama media sosial, video pendek, dan teknologi kreatif. Tidak heran jika pembelajaran animasi kini banyak diminati karena mampu menggabungkan kreativitas, teknologi, dan storytelling dalam satu skill yang relevan dengan zaman.\n\nKenapa Animasi Viral di Kalangan Gen Z?\n\nSalah satu alasan utama animasi begitu diminati adalah karena hasilnya bisa langsung dilihat dan dibagikan. Gen Z cenderung menyukai proses belajar yang cepat, visual, dan aplikatif. Dengan animasi, mereka bisa menciptakan karakter sendiri, menghidupkan ide, dan langsung mempublikasikannya di platform digital.\n\nSelain itu, banyak kreator animasi di media sosial yang membagikan proses belajar mereka secara terbuka. Hal ini membuat animasi terasa lebih “reachable” dan tidak lagi terlihat rumit atau menakutkan untuk dipelajari oleh pemula.\n\nBelajar Animasi Tidak Harus Mahal dan Ribet\n\nBerbeda dengan anggapan lama, belajar animasi saat ini bisa dimulai dari perangkat yang sederhana dan melalui kelas online. Banyak platform kursus digital yang menawarkan pembelajaran animasi dari level dasar, mulai dari prinsip gerak, posing, hingga animasi karakter 2D dan 3D.\n\nMetode belajar yang fleksibel, berbasis praktik, dan mengikuti tren industri membuat Gen Z merasa lebih nyaman. Mereka bisa belajar sesuai ritme sendiri, sambil tetap produktif dan kreatif.', 'published', '2025-12-18 08:48:09', '2025-12-18 08:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2LcnLrk7GPCLEdTIsRoEwSw39nDu1kC0eHH73qgl', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibnhzcWJYMnEwYWlTQzR4MWNFaFVQaGNISWJFMGhjQXNWYlFhSTBMdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjtzOjU6InJvdXRlIjtzOjk6InVzZXIuaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1766647290),
('MliHdm8FOGaK7g22kDFORSu1OP5n3CucVkP092zN', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMm9QUWVDc3BOWVlkUk5jVjVJY2RaRGRKYUV1OEg4ZllNbFMzbTJTRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZXR0aW5ncy9wcm9maWxlIjtzOjU6InJvdXRlIjtzOjEyOiJwcm9maWxlLmVkaXQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O3M6MzoidXJsIjthOjA6e319', 1766647204);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `birth_date` date DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `major` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_me` text COLLATE utf8mb4_unicode_ci,
  `interests` text COLLATE utf8mb4_unicode_ci,
  `portfolio_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `phone_number`, `gender`, `institution`, `address`, `birth_date`, `avatar`, `role`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`, `city`, `occupation_status`, `school_level`, `institution_name`, `major`, `company_name`, `job_title`, `about_me`, `interests`, `portfolio_link`) VALUES
(1, 'arzeki', NULL, 'anggapriadani12@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '$2y$12$ja0WNhVhrGuoW6w0anazrOfmMeldaJ7XZ0PGTFgwmwAFBhi0w32Mi', NULL, NULL, NULL, NULL, '2025-12-14 02:37:38', '2025-12-14 02:37:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'arzeki', NULL, 'anggapriadani13@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-12-14 02:56:17', '$2y$12$sfGzvwUIfQvoroE5ZUhhG.rXKX7NL0GoaXKuOXHj.bQUPFpM6/GXW', NULL, NULL, NULL, NULL, '2025-12-14 02:55:59', '2025-12-16 10:03:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'user', NULL, 'user@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '$2y$12$KxRYC9yF0CoHXkMKhnRipuPEU1njRw02TolaRLUKgtPUOZi4qTUzm', NULL, NULL, NULL, NULL, '2025-12-16 10:44:59', '2025-12-16 10:44:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'roni', 'wakideen', 'user1@gmail.com', NULL, '08123456789', 'male', 'Mandor', 'Jl.Jalan', '2003-02-01', NULL, 'user', '2025-12-16 10:59:55', '$2y$12$0H2/U/GFk0c8RNZsdH/iteUruI7XuB4csreagOggTwfYXU6aSjZS.', NULL, NULL, NULL, NULL, '2025-12-16 10:59:29', '2025-12-24 22:30:08', 'jakarta', 'Mahasiswa', NULL, 'anu', 'anu', NULL, NULL, 'anu', NULL, 'https://anu.ini'),
(5, 'user2', NULL, 'user2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user', '2025-12-17 20:15:17', '$2y$12$jRAboc1j65bWU/rfCuRXXeNsBDqqGMfNfhZr4QNZSamStk7kz5H3m', NULL, NULL, NULL, NULL, '2025-12-17 20:14:49', '2025-12-17 20:15:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Rahidin', NULL, 'user3@gmail.com', NULL, '081122334455', 'Laki-laki', 'anu', 'jalan', NULL, NULL, 'user', '2025-12-24 20:39:30', '$2y$12$oQkrXdn26U9UNtSI.HMDauX0.phiuQD1NE3bIS4ak3mvCynilVq52', NULL, NULL, NULL, NULL, '2025-12-24 20:38:44', '2025-12-24 20:40:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'wakidun ahad', NULL, 'user4@gmail.com', NULL, '081234567822', 'Laki-laki', 'Itu', 'alamit', NULL, NULL, 'user', '2025-12-24 20:54:42', '$2y$12$/LGd5iTzuBohW.07q0EjWeEiABxoPFALrkFQj6onO2w/NH9Ir4g6O', NULL, NULL, NULL, NULL, '2025-12-24 20:52:28', '2025-12-24 20:55:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'paman', NULL, 'paman@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user', '2025-12-24 23:13:40', '$2y$12$qfb5kRrGVvjffVY3wayVbO7hknp7xhLkSWCdd1Qo7yAWH8IRQx5xq', NULL, NULL, NULL, NULL, '2025-12-24 23:12:27', '2025-12-24 23:13:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'user5', 'user5', 'user5@gmail.com', '081223345838', NULL, 'male', NULL, NULL, '1999-12-12', NULL, 'user', '2025-12-25 00:15:31', '$2y$12$SOr/M6qyY9aDcyTpIYq4kue5qSFThMm2Q4YHJnFo/98L4XcbU6s.K', NULL, NULL, NULL, NULL, '2025-12-25 00:15:07', '2025-12-25 00:20:03', 'jakarta', 'Pelajar', NULL, 'sdn', NULL, NULL, NULL, 'saya', NULL, 'https://anu.inu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academies`
--
ALTER TABLE `academies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `academies_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollments_user_id_foreign` (`user_id`),
  ADD KEY `enrollments_academy_id_foreign` (`academy_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_academy_id_foreign` (`academy_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `academies`
--
ALTER TABLE `academies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_academy_id_foreign` FOREIGN KEY (`academy_id`) REFERENCES `academies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_academy_id_foreign` FOREIGN KEY (`academy_id`) REFERENCES `academies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
