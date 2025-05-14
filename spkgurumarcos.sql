/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `guru_kelas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` bigint unsigned NOT NULL,
  `kelas_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_kelas_guru_id_foreign` (`guru_id`),
  KEY `guru_kelas_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `guru_kelas_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `guru_kelas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `guru_mata_pelajaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` bigint unsigned NOT NULL,
  `mata_pelajaran_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_mata_pelajaran_guru_id_foreign` (`guru_id`),
  KEY `guru_mata_pelajaran_mata_pelajaran_id_foreign` (`mata_pelajaran_id`),
  CONSTRAINT `guru_mata_pelajaran_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `guru_mata_pelajaran_mata_pelajaran_id_foreign` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajarans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `gurus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nip` int NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_jam_mengajar` int NOT NULL,
  `jumlah_presensi` int NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gurus_nip_unique` (`nip`),
  KEY `gurus_user_id_foreign` (`user_id`),
  CONSTRAINT `gurus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `kelas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelas_nama_kelas_unique` (`nama_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `kriterias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot_kriteria` int NOT NULL,
  `jenis` enum('Benefit','Cost') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cara_penilaian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `mata_pelajarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_mata_pelajaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mata_pelajarans_nama_mata_pelajaran_unique` (`nama_mata_pelajaran`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaian_kepsek_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penilaian_id` bigint unsigned NOT NULL,
  `pernyataan_id` bigint unsigned NOT NULL,
  `nilai` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_kepsek_detail_penilaian_id_foreign` (`penilaian_id`),
  KEY `penilaian_kepsek_detail_pernyataan_id_foreign` (`pernyataan_id`),
  CONSTRAINT `penilaian_kepsek_detail_penilaian_id_foreign` FOREIGN KEY (`penilaian_id`) REFERENCES `penilaian_oleh_kepala_sekolah` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_kepsek_detail_pernyataan_id_foreign` FOREIGN KEY (`pernyataan_id`) REFERENCES `pernyataan_kepala_sekolah` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaian_oleh_kepala_sekolah` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kepala_sekolah_id` bigint unsigned NOT NULL,
  `guru_id` bigint unsigned NOT NULL,
  `nilai_akhir` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_oleh_kepala_sekolah_kepala_sekolah_id_foreign` (`kepala_sekolah_id`),
  KEY `penilaian_oleh_kepala_sekolah_guru_id_foreign` (`guru_id`),
  CONSTRAINT `penilaian_oleh_kepala_sekolah_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`),
  CONSTRAINT `penilaian_oleh_kepala_sekolah_kepala_sekolah_id_foreign` FOREIGN KEY (`kepala_sekolah_id`) REFERENCES `gurus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaian_oleh_rekan_sejawats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penilai_id` bigint unsigned NOT NULL,
  `guru_id` bigint unsigned NOT NULL,
  `nilai_akhir` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_oleh_rekan_sejawats_penilai_id_foreign` (`penilai_id`),
  KEY `penilaian_oleh_rekan_sejawats_guru_id_foreign` (`guru_id`),
  CONSTRAINT `penilaian_oleh_rekan_sejawats_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`),
  CONSTRAINT `penilaian_oleh_rekan_sejawats_penilai_id_foreign` FOREIGN KEY (`penilai_id`) REFERENCES `gurus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaian_rekan_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penilaian_id` bigint unsigned NOT NULL,
  `pernyataan_id` bigint unsigned NOT NULL,
  `nilai` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_rekan_details_penilaian_id_foreign` (`penilaian_id`),
  KEY `penilaian_rekan_details_pernyataan_id_foreign` (`pernyataan_id`),
  CONSTRAINT `penilaian_rekan_details_penilaian_id_foreign` FOREIGN KEY (`penilaian_id`) REFERENCES `penilaian_oleh_rekan_sejawats` (`id`),
  CONSTRAINT `penilaian_rekan_details_pernyataan_id_foreign` FOREIGN KEY (`pernyataan_id`) REFERENCES `pernyataan_rekan_sejawats` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaian_siswa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `guru_id` bigint unsigned NOT NULL,
  `jam_masuk` int DEFAULT NULL,
  `jam_tugas` int DEFAULT NULL,
  `jam_tidak_masuk` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_siswa_siswa_id_foreign` (`siswa_id`),
  KEY `penilaian_siswa_guru_id_foreign` (`guru_id`),
  CONSTRAINT `penilaian_siswa_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_siswa_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaianadmins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` bigint unsigned NOT NULL,
  `administrasi` bigint unsigned DEFAULT NULL,
  `presensi_realita` double DEFAULT NULL,
  `sertifikat_pengembangan` int DEFAULT NULL,
  `kegiatan_sosial` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaianadmins_guru_id_foreign` (`guru_id`),
  KEY `penilaianadmins_administrasi_foreign` (`administrasi`),
  CONSTRAINT `penilaianadmins_administrasi_foreign` FOREIGN KEY (`administrasi`) REFERENCES `sub_kriterias` (`id_sub_kriteria`) ON DELETE SET NULL,
  CONSTRAINT `penilaianadmins_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `perhitungans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` bigint unsigned NOT NULL,
  `administrasi` bigint unsigned DEFAULT NULL,
  `supervisi` double DEFAULT NULL,
  `kehadiran_dikelas` double DEFAULT NULL,
  `presensi` double DEFAULT NULL,
  `sertifikat_pengembangan` double DEFAULT NULL,
  `kegiatan_sosial` double DEFAULT NULL,
  `rekan_sejawat` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `perhitungans_guru_id_foreign` (`guru_id`),
  KEY `perhitungans_administrasi_foreign` (`administrasi`),
  CONSTRAINT `perhitungans_administrasi_foreign` FOREIGN KEY (`administrasi`) REFERENCES `sub_kriterias` (`id_sub_kriteria`) ON DELETE SET NULL,
  CONSTRAINT `perhitungans_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pernyataan_kepala_sekolah` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pernyataan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pernyataan_rekan_sejawats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pernyataan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `siswas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswas_kelas_id_foreign` (`kelas_id`),
  KEY `siswas_user_id_foreign` (`user_id`),
  CONSTRAINT `siswas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `siswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sub_kriterias` (
  `id_sub_kriteria` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kriteria_id` bigint unsigned NOT NULL,
  `nama_sub_kriteria` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot_sub_kriteria` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_sub_kriteria`),
  KEY `sub_kriterias_kriteria_id_foreign` (`kriteria_id`),
  CONSTRAINT `sub_kriterias_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriterias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_guru@gmail.com|127.0.0.1', 'i:1;', 1746855319);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_guru@gmail.com|127.0.0.1:timer', 'i:1746855319;', 1746855319);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_guru1@gmail.com|127.0.0.1', 'i:2;', 1746855310);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_guru1@gmail.com|127.0.0.1:timer', 'i:1746855310;', 1746855310),
('laravel_cache_manajemen@gmail.com|127.0.0.1', 'i:1;', 1746785130),
('laravel_cache_manajemen@gmail.com|127.0.0.1:timer', 'i:1746785130;', 1746785130),
('laravel_cache_sis@gmail.com|127.0.0.1', 'i:1;', 1746552442),
('laravel_cache_sis@gmail.com|127.0.0.1:timer', 'i:1746552442;', 1746552442);





INSERT INTO `guru_kelas` (`id`, `guru_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);
INSERT INTO `guru_kelas` (`id`, `guru_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(2, 2, 1, NULL, NULL);
INSERT INTO `guru_kelas` (`id`, `guru_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(3, 2, 2, NULL, NULL);
INSERT INTO `guru_kelas` (`id`, `guru_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(5, 4, 1, NULL, NULL),
(6, 5, 1, NULL, NULL),
(10, 8, 1, NULL, NULL);

INSERT INTO `guru_mata_pelajaran` (`id`, `guru_id`, `mata_pelajaran_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL);
INSERT INTO `guru_mata_pelajaran` (`id`, `guru_id`, `mata_pelajaran_id`, `created_at`, `updated_at`) VALUES
(2, 2, 1, NULL, NULL);
INSERT INTO `guru_mata_pelajaran` (`id`, `guru_id`, `mata_pelajaran_id`, `created_at`, `updated_at`) VALUES
(3, 2, 2, NULL, NULL);
INSERT INTO `guru_mata_pelajaran` (`id`, `guru_id`, `mata_pelajaran_id`, `created_at`, `updated_at`) VALUES
(4, 4, 1, NULL, NULL),
(5, 4, 2, NULL, NULL),
(6, 4, 3, NULL, NULL),
(7, 5, 1, NULL, NULL),
(12, 8, 1, NULL, NULL);

INSERT INTO `gurus` (`id`, `nip`, `jabatan`, `jumlah_jam_mengajar`, `jumlah_presensi`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 111, 'Guru', 1, 1, 12, '2025-04-25 03:58:26', '2025-04-25 03:58:26');
INSERT INTO `gurus` (`id`, `nip`, `jabatan`, `jumlah_jam_mengajar`, `jumlah_presensi`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 112, 'Guru', 2, 2, 13, '2025-04-25 03:59:21', '2025-04-25 03:59:21');
INSERT INTO `gurus` (`id`, `nip`, `jabatan`, `jumlah_jam_mengajar`, `jumlah_presensi`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 114, 'Guru', 20, 20, 15, '2025-04-26 11:58:38', '2025-04-26 11:58:38');
INSERT INTO `gurus` (`id`, `nip`, `jabatan`, `jumlah_jam_mengajar`, `jumlah_presensi`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 999, 'Kepala Sekolah', 0, 0, 16, '2025-04-30 17:08:07', '2025-04-30 17:08:07'),
(8, 4112, 'Guru', 10, 10, 23, '2025-05-10 05:38:00', '2025-05-10 05:38:00');





INSERT INTO `kelas` (`id`, `nama_kelas`, `created_at`, `updated_at`) VALUES
(1, '10 IPA 1', NULL, NULL);
INSERT INTO `kelas` (`id`, `nama_kelas`, `created_at`, `updated_at`) VALUES
(2, '10 IPA 2', NULL, NULL);


INSERT INTO `kriterias` (`id`, `nama_kriteria`, `bobot_kriteria`, `jenis`, `cara_penilaian`, `created_at`, `updated_at`) VALUES
(1, 'Supervisi Guru', 18, 'Benefit', 'Input Nilai oleh Kepala Sekolah', NULL, NULL);
INSERT INTO `kriterias` (`id`, `nama_kriteria`, `bobot_kriteria`, `jenis`, `cara_penilaian`, `created_at`, `updated_at`) VALUES
(2, 'Administrasi', 15, 'Benefit', 'Pilih Sub Kriteria oleh Manajemen', NULL, NULL);
INSERT INTO `kriterias` (`id`, `nama_kriteria`, `bobot_kriteria`, `jenis`, `cara_penilaian`, `created_at`, `updated_at`) VALUES
(3, 'Presensi', 17, 'Benefit', 'Input Data oleh Manajemen', NULL, NULL);
INSERT INTO `kriterias` (`id`, `nama_kriteria`, `bobot_kriteria`, `jenis`, `cara_penilaian`, `created_at`, `updated_at`) VALUES
(4, 'Kehadiran Kelas', 15, 'Benefit', 'Input Data oleh Siswa', NULL, NULL),
(5, 'Sertifikat Pengembangan Kompetensi', 12, 'Benefit', 'Input Data oleh Manajemen', NULL, NULL),
(6, 'Kegiatan Sosial', 13, 'Benefit', 'Input Data oleh Manajemen', NULL, NULL),
(7, 'Penilaian Antar Rekan Sejawat', 10, 'Benefit', 'Input Nilai oleh Rekan Sejawat', NULL, NULL);

INSERT INTO `mata_pelajarans` (`id`, `nama_mata_pelajaran`, `created_at`, `updated_at`) VALUES
(1, 'IPA', NULL, NULL);
INSERT INTO `mata_pelajarans` (`id`, `nama_mata_pelajaran`, `created_at`, `updated_at`) VALUES
(2, 'KIMIA', NULL, NULL);
INSERT INTO `mata_pelajarans` (`id`, `nama_mata_pelajaran`, `created_at`, `updated_at`) VALUES
(3, 'Biologi', NULL, NULL);

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2025_04_07_045549_create_kriterias_table', 1),
(5, '2025_04_07_053146_create_sub_kriterias_table', 1),
(6, '2025_04_15_063253_create_siswas_table', 1),
(7, '2025_04_15_081115_create_gurus_table', 1),
(8, '2025_04_16_072739_create_permission_tables', 1),
(9, '2025_04_20_111316_add_user_id_to_gurus_table', 1),
(10, '2025_04_24_144030_create_gurus_table', 2),
(11, '2025_04_24_152144_create_siswas_table', 3),
(12, '2025_04_24_152643_create_kelas_table', 4),
(13, '2025_04_24_155638_create_siswas_table', 5),
(14, '2025_04_24_174257_create_mata_pelajarans_table', 6),
(15, '2025_04_25_024446_create_guru_kelas_table', 7),
(16, '2025_04_25_030258_create_guru_mata_pelajaran_table', 8),
(17, '2025_04_25_035020_create_gurus_table', 9),
(18, '2025_04_26_063827_create_perhitungans_table', 10),
(19, '2025_04_26_080954_create_perhitungans_table', 11),
(20, '2025_04_26_081821_create_perhitungans_table', 12),
(21, '2025_04_26_082614_create_perhitungans_table', 13),
(22, '2025_04_26_085348_create_perhitungans_table', 14),
(23, '2025_04_26_133054_create_penilaianadmins_table', 15),
(24, '2025_04_26_135720_create_penilaianadmins_table', 16),
(25, '2025_04_28_074242_create_penilaian_siswa_table', 17),
(26, '2025_05_01_102145_create_pernyataan_kepala_sekolah_table', 18),
(27, '2025_05_01_102232_create_penilaian_oleh_kepala_sekolah_table', 18),
(28, '2025_05_01_102303_create_penilaian_kepsek_detail_table', 18),
(29, '2025_05_01_195526_create_penilaian_oleh_kepala_sekolah_table', 19),
(30, '2025_05_02_105423_create_penilaian_oleh_rekan_sejawats_table', 20),
(31, '2025_05_02_105510_create_pernyataan_rekan_sejawats_table', 20),
(32, '2025_05_02_105902_create_penilaian_rekan_details_table', 21);



INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 3);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(4, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(2, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(4, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 23);



INSERT INTO `penilaian_kepsek_detail` (`id`, `penilaian_id`, `pernyataan_id`, `nilai`, `created_at`, `updated_at`) VALUES
(9, 3, 1, 4, '2025-05-02 07:51:23', '2025-05-02 07:51:23');
INSERT INTO `penilaian_kepsek_detail` (`id`, `penilaian_id`, `pernyataan_id`, `nilai`, `created_at`, `updated_at`) VALUES
(10, 3, 2, 2, '2025-05-02 07:51:23', '2025-05-02 07:51:23');
INSERT INTO `penilaian_kepsek_detail` (`id`, `penilaian_id`, `pernyataan_id`, `nilai`, `created_at`, `updated_at`) VALUES
(13, 1, 1, 2, '2025-05-02 08:39:42', '2025-05-02 08:39:42');
INSERT INTO `penilaian_kepsek_detail` (`id`, `penilaian_id`, `pernyataan_id`, `nilai`, `created_at`, `updated_at`) VALUES
(14, 1, 2, 4, '2025-05-02 08:39:42', '2025-05-02 08:39:42'),
(15, 2, 1, 3, '2025-05-02 08:45:55', '2025-05-02 08:45:55'),
(16, 2, 2, 4, '2025-05-02 08:45:55', '2025-05-02 08:45:55');

INSERT INTO `penilaian_oleh_kepala_sekolah` (`id`, `kepala_sekolah_id`, `guru_id`, `nilai_akhir`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 75, '2025-05-01 20:18:57', '2025-05-02 08:39:42');
INSERT INTO `penilaian_oleh_kepala_sekolah` (`id`, `kepala_sekolah_id`, `guru_id`, `nilai_akhir`, `created_at`, `updated_at`) VALUES
(2, 5, 2, 87.5, '2025-05-02 07:51:15', '2025-05-02 08:45:55');
INSERT INTO `penilaian_oleh_kepala_sekolah` (`id`, `kepala_sekolah_id`, `guru_id`, `nilai_akhir`, `created_at`, `updated_at`) VALUES
(3, 5, 4, 75, '2025-05-02 07:51:23', '2025-05-02 07:51:23');

INSERT INTO `penilaian_oleh_rekan_sejawats` (`id`, `penilai_id`, `guru_id`, `nilai_akhir`, `created_at`, `updated_at`) VALUES
(9, 1, 2, 50, '2025-05-02 15:59:15', '2025-05-02 15:59:53');
INSERT INTO `penilaian_oleh_rekan_sejawats` (`id`, `penilai_id`, `guru_id`, `nilai_akhir`, `created_at`, `updated_at`) VALUES
(10, 1, 4, 75, '2025-05-06 09:40:42', '2025-05-06 09:41:08');
INSERT INTO `penilaian_oleh_rekan_sejawats` (`id`, `penilai_id`, `guru_id`, `nilai_akhir`, `created_at`, `updated_at`) VALUES
(11, 1, 5, 100, '2025-05-06 09:40:47', '2025-05-06 09:40:47');
INSERT INTO `penilaian_oleh_rekan_sejawats` (`id`, `penilai_id`, `guru_id`, `nilai_akhir`, `created_at`, `updated_at`) VALUES
(12, 2, 1, 50, '2025-05-06 09:41:53', '2025-05-06 09:41:53'),
(13, 2, 4, 75, '2025-05-06 09:42:01', '2025-05-06 09:42:01'),
(14, 2, 5, 100, '2025-05-06 09:42:06', '2025-05-06 09:42:06'),
(15, 4, 1, 25, '2025-05-06 09:42:35', '2025-05-06 09:42:35'),
(16, 4, 2, 75, '2025-05-06 09:42:42', '2025-05-06 09:42:42'),
(17, 4, 5, 100, '2025-05-06 09:42:45', '2025-05-06 09:42:45');

INSERT INTO `penilaian_rekan_details` (`id`, `penilaian_id`, `pernyataan_id`, `nilai`, `created_at`, `updated_at`) VALUES
(21, 9, 1, 2, '2025-05-02 15:59:53', '2025-05-02 15:59:53');
INSERT INTO `penilaian_rekan_details` (`id`, `penilaian_id`, `pernyataan_id`, `nilai`, `created_at`, `updated_at`) VALUES
(22, 9, 2, 0, '2025-05-02 15:59:53', '2025-05-02 15:59:53');
INSERT INTO `penilaian_rekan_details` (`id`, `penilaian_id`, `pernyataan_id`, `nilai`, `created_at`, `updated_at`) VALUES
(25, 11, 1, 2, '2025-05-06 09:40:47', '2025-05-06 09:40:47');
INSERT INTO `penilaian_rekan_details` (`id`, `penilaian_id`, `pernyataan_id`, `nilai`, `created_at`, `updated_at`) VALUES
(26, 11, 2, 2, '2025-05-06 09:40:47', '2025-05-06 09:40:47'),
(27, 10, 1, 1, '2025-05-06 09:41:08', '2025-05-06 09:41:08'),
(28, 10, 2, 2, '2025-05-06 09:41:08', '2025-05-06 09:41:08'),
(29, 12, 1, 1, '2025-05-06 09:41:53', '2025-05-06 09:41:53'),
(30, 12, 2, 1, '2025-05-06 09:41:53', '2025-05-06 09:41:53'),
(31, 13, 1, 2, '2025-05-06 09:42:01', '2025-05-06 09:42:01'),
(32, 13, 2, 1, '2025-05-06 09:42:01', '2025-05-06 09:42:01'),
(33, 14, 1, 2, '2025-05-06 09:42:06', '2025-05-06 09:42:06'),
(34, 14, 2, 2, '2025-05-06 09:42:06', '2025-05-06 09:42:06'),
(35, 15, 1, 1, '2025-05-06 09:42:35', '2025-05-06 09:42:35'),
(36, 15, 2, 0, '2025-05-06 09:42:35', '2025-05-06 09:42:35'),
(37, 16, 1, 2, '2025-05-06 09:42:42', '2025-05-06 09:42:42'),
(38, 16, 2, 1, '2025-05-06 09:42:42', '2025-05-06 09:42:42'),
(39, 17, 1, 2, '2025-05-06 09:42:45', '2025-05-06 09:42:45'),
(40, 17, 2, 2, '2025-05-06 09:42:45', '2025-05-06 09:42:45');

INSERT INTO `penilaian_siswa` (`id`, `siswa_id`, `guru_id`, `jam_masuk`, `jam_tugas`, `jam_tidak_masuk`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 10, 10, '2025-04-28 08:44:49', '2025-04-28 13:53:25');
INSERT INTO `penilaian_siswa` (`id`, `siswa_id`, `guru_id`, `jam_masuk`, `jam_tugas`, `jam_tidak_masuk`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 15, 5, 5, '2025-04-28 10:12:49', '2025-04-28 13:51:05');
INSERT INTO `penilaian_siswa` (`id`, `siswa_id`, `guru_id`, `jam_masuk`, `jam_tugas`, `jam_tidak_masuk`, `created_at`, `updated_at`) VALUES
(3, 1, 4, 15, 20, 10, '2025-04-28 13:35:20', '2025-05-06 17:35:53');
INSERT INTO `penilaian_siswa` (`id`, `siswa_id`, `guru_id`, `jam_masuk`, `jam_tugas`, `jam_tidak_masuk`, `created_at`, `updated_at`) VALUES
(4, 2, 2, 40, 30, 12, '2025-05-06 09:46:48', '2025-05-06 09:46:48'),
(5, 4, 1, 2, 2, 1, '2025-05-10 04:00:07', '2025-05-10 04:00:07');

INSERT INTO `penilaianadmins` (`id`, `guru_id`, `administrasi`, `presensi_realita`, `sertifikat_pengembangan`, `kegiatan_sosial`, `created_at`, `updated_at`) VALUES
(1, 1, 21, 5, 2, 1, '2025-04-26 15:07:09', '2025-05-06 17:38:59');
INSERT INTO `penilaianadmins` (`id`, `guru_id`, `administrasi`, `presensi_realita`, `sertifikat_pengembangan`, `kegiatan_sosial`, `created_at`, `updated_at`) VALUES
(2, 2, 22, 4, 2, 1, '2025-04-26 15:09:56', '2025-05-06 17:42:51');
INSERT INTO `penilaianadmins` (`id`, `guru_id`, `administrasi`, `presensi_realita`, `sertifikat_pengembangan`, `kegiatan_sosial`, `created_at`, `updated_at`) VALUES
(4, 4, 21, 15, 0, 2, '2025-04-26 15:11:49', '2025-05-06 17:36:41');
INSERT INTO `penilaianadmins` (`id`, `guru_id`, `administrasi`, `presensi_realita`, `sertifikat_pengembangan`, `kegiatan_sosial`, `created_at`, `updated_at`) VALUES
(5, 5, 21, 2, 1, 1, '2025-05-09 17:21:31', '2025-05-09 17:21:31');

INSERT INTO `perhitungans` (`id`, `guru_id`, `administrasi`, `supervisi`, `kehadiran_dikelas`, `presensi`, `sertifikat_pengembangan`, `kegiatan_sosial`, `rekan_sejawat`, `created_at`, `updated_at`) VALUES
(10, 4, 21, 75, 2, 2, 0, 2, NULL, '2025-05-06 17:35:53', '2025-05-06 17:36:41');
INSERT INTO `perhitungans` (`id`, `guru_id`, `administrasi`, `supervisi`, `kehadiran_dikelas`, `presensi`, `sertifikat_pengembangan`, `kegiatan_sosial`, `rekan_sejawat`, `created_at`, `updated_at`) VALUES
(11, 1, 21, 75, 200, 1, 2, 1, NULL, '2025-05-06 17:38:59', '2025-05-10 04:00:07');
INSERT INTO `perhitungans` (`id`, `guru_id`, `administrasi`, `supervisi`, `kehadiran_dikelas`, `presensi`, `sertifikat_pengembangan`, `kegiatan_sosial`, `rekan_sejawat`, `created_at`, `updated_at`) VALUES
(12, 2, 22, 87.5, 1, 1, 2, 1, NULL, '2025-05-06 17:42:51', '2025-05-06 17:42:51');



INSERT INTO `pernyataan_kepala_sekolah` (`id`, `pernyataan`, `created_at`, `updated_at`) VALUES
(1, 'Menyiapkan peserta didik secara psikis dan fisik untuk mengikuti proses pembelajaran', NULL, NULL);
INSERT INTO `pernyataan_kepala_sekolah` (`id`, `pernyataan`, `created_at`, `updated_at`) VALUES
(2, 'Memberi motivasi belajar siswa secara kontekstual sesuai manfaat dan aplikasi materi ajar dalam kehidupan sehari-hari, dengan memberikan contoh dan perbandingan lokal, nasional dan internasional', NULL, NULL);


INSERT INTO `pernyataan_rekan_sejawats` (`id`, `pernyataan`, `created_at`, `updated_at`) VALUES
(1, 'Guru mentaati peraturan yang berlaku di sekolah', NULL, NULL);
INSERT INTO `pernyataan_rekan_sejawats` (`id`, `pernyataan`, `created_at`, `updated_at`) VALUES
(2, 'Guru bekerja sesuai jadwal yang ditetapkan', NULL, NULL);




INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', NULL, NULL);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'KepalaSekolah', 'web', NULL, NULL);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(3, 'Guru', 'web', NULL, NULL);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'Siswa', 'web', NULL, NULL);

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DZtyB324DdD6ZRWflTBWpjktuomVA4MNDCdCocNX', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY29NRWRvRVVjb05Ib2hQdWJVSjlrcG9od2FieUwzcEcxdnE4ZGgxQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXRhcGVuaWxhaWFuIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1746883329);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('oTWNerStfdMfh8oJQtosRfWCH7OdYFNjSn1Z3ipj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWVsUHlHZ083NmdXR21velZ0MDdQN1ByUGlOb0dBOW10QjZ1U0haSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1746876351);


INSERT INTO `siswas` (`id`, `kelas_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-04-24 16:19:53', '2025-04-26 16:35:40');
INSERT INTO `siswas` (`id`, `kelas_id`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 2, 17, '2025-05-06 09:44:52', '2025-05-06 09:44:52');
INSERT INTO `siswas` (`id`, `kelas_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 2, 19, '2025-05-08 04:32:34', '2025-05-08 04:32:34');
INSERT INTO `siswas` (`id`, `kelas_id`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 1, 21, '2025-05-09 10:06:36', '2025-05-09 10:06:36');

INSERT INTO `sub_kriterias` (`id_sub_kriteria`, `kriteria_id`, `nama_sub_kriteria`, `bobot_sub_kriteria`, `created_at`, `updated_at`) VALUES
(21, 2, 'Lengkap', 4, NULL, NULL);
INSERT INTO `sub_kriterias` (`id_sub_kriteria`, `kriteria_id`, `nama_sub_kriteria`, `bobot_sub_kriteria`, `created_at`, `updated_at`) VALUES
(22, 2, 'Cukup', 3, NULL, NULL);
INSERT INTO `sub_kriterias` (`id_sub_kriteria`, `kriteria_id`, `nama_sub_kriteria`, `bobot_sub_kriteria`, `created_at`, `updated_at`) VALUES
(23, 2, 'Kurang', 2, NULL, NULL);
INSERT INTO `sub_kriterias` (`id_sub_kriteria`, `kriteria_id`, `nama_sub_kriteria`, `bobot_sub_kriteria`, `created_at`, `updated_at`) VALUES
(31, 3, 'Sangat Baik', 4, NULL, NULL),
(32, 3, 'Baik', 3, NULL, NULL),
(33, 3, 'Cukup', 2, NULL, NULL),
(34, 3, 'Kurang', 1, NULL, NULL),
(41, 4, 'Sangat Baik', 4, NULL, NULL),
(42, 4, 'Baik', 3, NULL, NULL),
(43, 4, 'Cukup', 2, NULL, NULL),
(44, 4, 'Kurang', 1, NULL, NULL);

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Manajemen', 'manajemen@mail.com', NULL, '$2y$12$lTXsk4VhxxTOsgt3xgEc5ee.da1yWG.Zvr0tnu..tmL5ebE/4lona', NULL, '2025-04-24 10:00:15', '2025-04-24 10:00:15');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'dhiza', 'dhiza@mail.com', NULL, '$2y$12$EgitOaEL/8vv8tDgNRdUxeUOzYA/.Wkpc.IryAFK47IeACC/TEhPG', NULL, '2025-04-24 14:49:53', '2025-04-24 14:49:53');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'siswa', 'siswa@mail.com', NULL, '$2y$12$NHYmQVdyuukrp8G4uEDBsuuWmZNQplHKbRrMYssZH2qDdLMteASAK', NULL, '2025-04-24 15:47:50', '2025-04-24 15:47:50');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'siswa', 'sis@mail.com', NULL, '$2y$12$fbR4lbWwNKOVUcGXxr/Sle85zt4cuKVnVnFLA89ISwp0WcOjKBZ5C', NULL, '2025-04-24 16:19:53', '2025-04-26 16:33:56'),
(6, 'putri', 'putri@gmail.com', NULL, '$2y$12$Y/BMwxJ7j/J6P8PS/sq26uU7Luz00V6fk9vb7yW891.hAGAWq67Ry', NULL, '2025-04-24 16:29:49', '2025-04-24 16:29:49'),
(8, 'aa', 'aa@mail.com', NULL, '$2y$12$1mKt1LUXPjCs.37Kb8RvR.R5B/p00VaP6sfS8UvZZAqroVDEfinmK', NULL, '2025-04-24 18:16:25', '2025-04-24 18:16:25'),
(9, 'keps', 'keps@gmail.com', NULL, '$2y$12$9qb.yjkG5ldfWjM.lTx2Pe4R2fWGzmaTyMABLHRA2Y8jak24i4hxO', NULL, '2025-04-24 18:28:51', '2025-04-24 18:28:51'),
(12, 'guru', 'guru@mail.com', NULL, '$2y$12$KmYKDvrR4f1k2cLKHfamjuva.TC2A8.rhi3RzfVdl9xSqjRQKwr.C', NULL, '2025-04-25 03:58:26', '2025-04-25 03:58:26'),
(13, 'guru1', 'guru1@mail.com', NULL, '$2y$12$OKE4PNwzIhApYwuWdYtMxusgf70tfT8Mll1CXhdRT/YVxSZluL1Sm', NULL, '2025-04-25 03:59:21', '2025-04-25 03:59:21'),
(14, 'guru2', 'guru2@mail.com', NULL, '$2y$12$hHm28GA7nsMAgxiE28cqq.L.qnxwGuVKcK4jqnXIVt8OfRj0KXpEm', NULL, '2025-04-26 09:10:55', '2025-04-26 09:10:55'),
(15, 'guru3', 'guru3@mail.com', NULL, '$2y$12$xMLf2HhwvvCYDZuTwHi02O8TUsc0.whi2ndn0j6XsAf85krIXEnX2', NULL, '2025-04-26 11:58:38', '2025-04-26 11:58:38'),
(16, 'kepsek', 'kepsek@mail.com', NULL, '$2y$12$Id3HQuBIG9YMmRr/79YCH.s3y.fNToX50cx7.7SJ4OZZ853vrIZNi', NULL, '2025-04-30 17:08:06', '2025-04-30 17:08:06'),
(17, 'Siswa 2', 'siswa2@mail.com', NULL, '$2y$12$Sn/OtmGt/8E0BsyiNTnTB.W.al4VLqgNfWlsIlinR2/d8oLp7U5Ee', NULL, '2025-05-06 09:44:52', '2025-05-06 09:44:52'),
(18, 'guru4', 'guru4@mail.com', NULL, '$2y$12$QY6E1rZfeDTxiQf1y5uad.WThS8wWi2eNKDnVdMNpf/ZiF9lFGuv2', NULL, '2025-05-08 04:31:55', '2025-05-08 04:31:55'),
(19, 'siswa 3', 'siswa3@mail.com', NULL, '$2y$12$RoLmXRVjDSMztfji3KpXtuyMdYJtK9LUS8Id/8nbv5H2dV5phf4r.', NULL, '2025-05-08 04:32:34', '2025-05-08 04:32:34'),
(21, 'Eugene Feilian Putra Rangga', 'gege.eugene702@gmail.com', NULL, '$2y$12$Q1kvBMDPohE3mmHl./gIyOfWZ1GXrbxrYxhXBgSbebwaY4PqRWnZW', NULL, '2025-05-09 10:06:36', '2025-05-09 10:06:36'),
(23, 'Eugene Feilian Putra Rangga', 'eugenefeilianputrarangga@gmail.com', NULL, '$2y$12$O2DCwiDHuLWItuvDApFHq.QqHu2CsBXOOHyXSts/tFUigj1RgGo3u', NULL, '2025-05-10 05:38:00', '2025-05-10 05:38:00');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;