-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2026 at 07:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic_c`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `document_no` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` enum('draft','completed','cancelled') NOT NULL DEFAULT 'draft',
  `pdf_path` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `document_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hn_running`
--

CREATE TABLE `hn_running` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `current_number` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_certificates`
--

CREATE TABLE `medical_certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_no` varchar(255) NOT NULL,
  `certificate_date` date NOT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `symptom` text DEFAULT NULL,
  `treatment_recommendation` text DEFAULT NULL,
  `rest_days` int(11) NOT NULL DEFAULT 0,
  `medics_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medics`
--

CREATE TABLE `medics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `license` varchar(255) NOT NULL,
  `signature` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medic_professions`
--

CREATE TABLE `medic_professions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medic_id` bigint(20) UNSIGNED NOT NULL,
  `professions_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_07_08_133111_create_roles_table', 1),
(2, '2026_07_08_133111_create_users_table', 1),
(3, '2026_07_08_133112_create_hn_running_table', 1),
(4, '2026_07_08_133112_create_setting_table', 1),
(5, '2026_07_08_133113_create_medics_table', 1),
(6, '2026_07_08_133114_create_patients_table', 1),
(7, '2026_07_08_133115_create_medic_professions_table', 1),
(8, '2026_07_08_133115_create_visits_table', 1),
(9, '2026_07_08_133116_create_pt28_table', 1),
(10, '2026_07_08_133117_create_pt33_table', 1),
(21, '2026_07_08_153545_create_professions_table', 2),
(23, '2026_07_08_151954_create_documents_table', 2),
(24, '2026_07_10_135158_add_document_date_to_documents_table', 2),
(25, '2026_07_10_154417_create_tabel__visi', 2),
(28, '2026_07_11_072023_remove_patient_id_from_pt28_table', 3),
(29, '2026_07_11_073655_remove_patient_id_from_pt28_table', 4),
(30, '2026_07_11_073934_remove_visit_id_from_pt28_table', 5),
(31, '2026_07_11_074027_remove_detail_fields_from_pt28_table', 6),
(32, '2026_07_11_101911_drop_flower_unit_from_pt28_details_table', 7),
(34, '2026_07_11_175020_add_pdf_path_to_pt28_table', 8),
(36, '2026_07_11_184330_remove_objective_from_pt28_table', 9),
(37, '2026_07_11_200444_add_pdf_path_to_medical_certificates_table', 10),
(38, '2026_07_12_053026_add_ekyc_columns_to_patients_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hn` varchar(255) NOT NULL,
  `cid` varchar(255) NOT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `firstname_en` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `lastname_en` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `card_issue_date` date DEFAULT NULL,
  `card_expire_date` date DEFAULT NULL,
  `card_photo` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `subdistrict` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `hn`, `cid`, `prefix`, `firstname`, `firstname_en`, `lastname`, `lastname_en`, `birthday`, `card_issue_date`, `card_expire_date`, `card_photo`, `age`, `gender`, `nationality`, `address`, `province`, `district`, `subdistrict`, `zipcode`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'HN000001', '3860400061063', 'นาย', 'ภูริวัฒ', 'Puriwat', 'เพชรโสม', 'Phetsom', '1965-12-02', NULL, NULL, NULL, 60, 'ชาย', 'Thai', '2 หมู่ที่ 1 ตำบลท่ามะพลา อำเภอหลังสวน จังหวัดชุมพร', 'ชุมพร', 'หลังสวน', 'ท่ามะพลา', NULL, NULL, NULL, '2026-07-12 07:56:12', '2026-07-12 07:56:12');

-- --------------------------------------------------------

--
-- Table structure for table `professions`
--

CREATE TABLE `professions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `professions`
--

INSERT INTO `professions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'เวชกรรม', NULL, NULL),
(2, 'แพทย์แผนไทย', NULL, NULL),
(3, 'แพทย์แผนไทยประยุกต์', NULL, NULL),
(4, 'ทันตกรรม', NULL, NULL),
(5, 'เภสัชกรรม', NULL, NULL),
(6, 'ผู้ประกอบโรคศิลปะ สาขาการแพทย์แผนจีน', NULL, NULL),
(7, 'หมอพื้นบ้าน', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pt28`
--

CREATE TABLE `pt28` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `document_no` varchar(255) NOT NULL,
  `issue_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pt28_details`
--

CREATE TABLE `pt28_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pt28_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `license_no` varchar(255) DEFAULT NULL,
  `dosage` decimal(10,2) NOT NULL DEFAULT 0.00,
  `objective` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pt33`
--

CREATE TABLE `pt33` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `visit_id` bigint(20) UNSIGNED NOT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `document_no` varchar(255) NOT NULL,
  `issue_date` date NOT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `certificate` text DEFAULT NULL,
  `cannabis_dosage` decimal(10,2) DEFAULT NULL,
  `cannabis_use_days` int(11) DEFAULT NULL,
  `cannabis_dosage_unit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2026-07-08 13:56:55', '2026-07-08 13:56:55');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clinic` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `license` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `clinic`, `address`, `phone`, `license`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'คลินิกการแพทย์แผนไทย', '146/99 ซอยลาดพร้าว 122 (มหาดไทย 1) แยก 18  ถ.ลาดพร้าว แขวงพลับพลา เขตวังทองหลาง กรุงเทพมหานคร  10310', '0123456789', '10108001169', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role_id`, `status`, `created_at`, `updated_at`) VALUES
(3, 'admin112233', 'admin112233', '$2y$12$hXfDxnt2rkAgqMhtGRq.YOSB7nNPDJR.5wPY.WfD84.lYT1nQn7t.', 1, 'active', '2026-07-08 06:56:58', '2026-07-08 06:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `visit_no` varchar(255) NOT NULL,
  `visit_date` date NOT NULL,
  `medic_id` bigint(20) UNSIGNED NOT NULL,
  `symptom` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hn_running`
--
ALTER TABLE `hn_running`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_certificates`
--
ALTER TABLE `medical_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medics`
--
ALTER TABLE `medics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medics_license_unique` (`license`);

--
-- Indexes for table `medic_professions`
--
ALTER TABLE `medic_professions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medic_professions_medic_id_foreign` (`medic_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_hn_unique` (`hn`),
  ADD UNIQUE KEY `patients_cid_unique` (`cid`);

--
-- Indexes for table `professions`
--
ALTER TABLE `professions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pt28`
--
ALTER TABLE `pt28`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pt28_details`
--
ALTER TABLE `pt28_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pt28_details_pt28_id_foreign` (`pt28_id`),
  ADD KEY `pt28_details_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `pt33`
--
ALTER TABLE `pt33`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pt33_patient_id_foreign` (`patient_id`),
  ADD KEY `pt33_visit_id_foreign` (`visit_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visits_patient_id_foreign` (`patient_id`),
  ADD KEY `visits_medic_id_foreign` (`medic_id`),
  ADD KEY `visits_created_by_foreign` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hn_running`
--
ALTER TABLE `hn_running`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_certificates`
--
ALTER TABLE `medical_certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medics`
--
ALTER TABLE `medics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medic_professions`
--
ALTER TABLE `medic_professions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `professions`
--
ALTER TABLE `professions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pt28`
--
ALTER TABLE `pt28`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pt28_details`
--
ALTER TABLE `pt28_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pt33`
--
ALTER TABLE `pt33`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medic_professions`
--
ALTER TABLE `medic_professions`
  ADD CONSTRAINT `medic_professions_medic_id_foreign` FOREIGN KEY (`medic_id`) REFERENCES `medics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pt28_details`
--
ALTER TABLE `pt28_details`
  ADD CONSTRAINT `pt28_details_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pt28_details_pt28_id_foreign` FOREIGN KEY (`pt28_id`) REFERENCES `pt28` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pt33`
--
ALTER TABLE `pt33`
  ADD CONSTRAINT `pt33_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pt33_visit_id_foreign` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visits_medic_id_foreign` FOREIGN KEY (`medic_id`) REFERENCES `medics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visits_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
