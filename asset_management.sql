-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2026 at 08:41 PM
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
-- Database: `asset_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(1, 1, 'user', '2026-03-30 09:41:56'),
(2, 2, 'superadmin', '2026-05-14 15:06:42'),
(3, 3, 'admin', '2026-05-14 15:06:42'),
(4, 4, 'reader', '2026-05-14 15:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `auth_identities`
--

CREATE TABLE `auth_identities` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) NOT NULL,
  `secret2` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text DEFAULT NULL,
  `force_reset` tinyint(1) NOT NULL DEFAULT 0,
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'email_password', NULL, 'test00@test.de', '$2y$12$iKiMFtIDncsg7UYmUOFJeeKuFQGa.tXjoOyD.X0ecimEArQphnfqm', NULL, NULL, 0, '2026-03-30 09:44:38', '2026-03-30 09:41:56', '2026-03-30 09:44:38'),
(2, 2, 'email_password', NULL, 'superadmin@test.de', '$2y$12$VXLY622r/9UKwyxtVg0svuGf3F6RdjS5HRbapcqvrCdsj0zpaYyBu', NULL, NULL, 0, '2026-05-15 17:18:22', '2026-05-14 15:06:41', '2026-05-15 17:18:22'),
(3, 3, 'email_password', NULL, 'admin@test.de', '$2y$12$it6c01WqWL/rp2nIot3JoOJ3nSdiZPoDvP7h7Aiq/T4JBgZoHcSFi', NULL, NULL, 0, '2026-05-15 16:50:49', '2026-05-14 15:06:42', '2026-05-15 16:50:49'),
(4, 4, 'email_password', NULL, 'reader@test.de', '$2y$12$mkFjYHzK4JkvtSqoy12ODeA4NvIkA1ZXree/cNTyFInEnKz.Rrl42', NULL, NULL, 0, '2026-05-15 07:43:09', '2026-05-14 15:06:42', '2026-05-15 07:43:09');

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
(1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'email_password', 'test00@test.de', 1, '2026-03-30 09:44:38', 1),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'email_password', 'superadmin@test.de', 2, '2026-05-14 15:07:03', 1),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'email_password', 'superadmin@test.de', 2, '2026-05-15 06:36:11', 1),
(4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'email_password', 'reader@test.de', 4, '2026-05-15 07:43:09', 1),
(5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'email_password', 'superadmin@test.de', 2, '2026-05-15 08:47:49', 1),
(6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'email_password', 'admin@test.de', 3, '2026-05-15 09:16:11', 1),
(7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'email_password', 'superadmin@test.de', 2, '2026-05-15 11:53:16', 1),
(8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'email_password', 'superadmin@test.de', 2, '2026-05-15 12:59:57', 1),
(9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'email_password', 'admin@test.de', 3, '2026-05-15 16:50:49', 1),
(10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'email_password', 'superadmin@test.de', 2, '2026-05-15 17:18:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_remember_tokens`
--

CREATE TABLE `auth_remember_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_token_logins`
--

CREATE TABLE `auth_token_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hardware_assets`
--

CREATE TABLE `hardware_assets` (
  `hardwareID` int(11) NOT NULL,
  `hw_name` varchar(150) NOT NULL,
  `hw_type` varchar(150) NOT NULL,
  `hw_function` varchar(150) NOT NULL,
  `hw_manufacturer` varchar(150) NOT NULL,
  `hw_model` varchar(150) NOT NULL,
  `hw_serial_number` varchar(150) NOT NULL,
  `hw_inventory` tinyint(1) DEFAULT NULL,
  `hw_deprecated` tinyint(1) DEFAULT NULL,
  `hw_status` varchar(20) DEFAULT NULL,
  `hw_has_network_interface_card` tinyint(1) DEFAULT NULL,
  `ownerID` int(11) DEFAULT NULL,
  `owner_deputyID` int(11) DEFAULT NULL,
  `admin_deputyID` int(11) DEFAULT NULL,
  `adminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hardware_assets`
--

INSERT INTO `hardware_assets` (`hardwareID`, `hw_name`, `hw_type`, `hw_function`, `hw_manufacturer`, `hw_model`, `hw_serial_number`, `hw_inventory`, `hw_deprecated`, `hw_status`, `hw_has_network_interface_card`, `ownerID`, `owner_deputyID`, `admin_deputyID`, `adminID`) VALUES
(1, 'Bildschirm', 'qweqweeeeeeee', 'qweqweqwe', 'qweqweqweqwe', 'qweqweqewewqe', 'qweqweqweqwe', 1, 1, 'In Verwendung', 1, 333, 333, 333, 333),
(5, 'Test05', 'qweqwe', 'wqeqw', 'weqweqwewqe', 'blabal', '3434423423', 1, 0, 'In Verwendung', 0, 234234, 333, 333, 555),
(9, 'Testbistdudrin', 'qweqwe', 'wqeqw', 'weqweqwewqe', 'blabal', '3434423423', 0, 1, 'In Verwendung', 1, 234234, 333, 333, 555);

-- --------------------------------------------------------

--
-- Table structure for table `hw_assets_nic`
--

CREATE TABLE `hw_assets_nic` (
  `hardwareID` int(11) NOT NULL,
  `mac_adress` varchar(20) NOT NULL,
  `ip_adress` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hw_assets_nic`
--

INSERT INTO `hw_assets_nic` (`hardwareID`, `mac_adress`, `ip_adress`) VALUES
(1, 'No4TestDatensatz', 'No4TestDatensatz'),
(9, 'No4TestDatensatz', '123213fdgdfg');

-- --------------------------------------------------------

--
-- Table structure for table `hw_asset_documents`
--

CREATE TABLE `hw_asset_documents` (
  `documentID` int(10) NOT NULL,
  `hardwareID` int(11) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `stored_filename` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_size` int(10) UNSIGNED NOT NULL,
  `uploaded_at` datetime NOT NULL,
  `document_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hw_asset_documents`
--

INSERT INTO `hw_asset_documents` (`documentID`, `hardwareID`, `original_filename`, `stored_filename`, `mime_type`, `file_size`, `uploaded_at`, `document_type`) VALUES
(11, 5, 'testupload001.pdf', '1778784545_7587857cfae28358db84.pdf', 'application/pdf', 15766, '2026-05-14 18:49:05', 'warranty'),
(12, 9, 'testupload001.pdf', '1778807927_94aa09fea430fee7e505.pdf', 'application/pdf', 15766, '2026-05-15 01:18:47', 'other'),
(13, 9, 'testupload001.pdf', '1778807939_ce217386f6f08dc5f681.pdf', 'application/pdf', 15766, '2026-05-15 01:18:59', 'warranty'),
(14, 9, 'testupload001.pdf', '1778807950_922f9b4a6317101e2826.pdf', 'application/pdf', 15766, '2026-05-15 01:19:10', 'warranty'),
(15, 1, 'testupload001.pdf', '1778834920_70f59ff409ae41297bc9.pdf', 'application/pdf', 15766, '2026-05-15 08:48:40', 'warranty'),
(16, 1, 'testupload001.pdf', '1778846338_100a18df0997f78bac44.pdf', 'application/pdf', 15766, '2026-05-15 11:58:58', 'warranty'),
(17, 1, 'testupload001.pdf', '1778846970_d95493b4d696150e053a.pdf', 'application/pdf', 15766, '2026-05-15 12:09:30', 'warranty'),
(18, 1, 'testupload001.pdf', '1778857656_635ac8848cf61c8b7da7.pdf', 'application/pdf', 15766, '2026-05-15 15:07:36', 'other'),
(20, 5, 'testupload001.pdf', '1778861012_d66dec42c3dadd5a8a63.pdf', 'application/pdf', 15766, '2026-05-15 16:03:32', 'other');

-- --------------------------------------------------------

--
-- Table structure for table `hw_asset_warranties`
--

CREATE TABLE `hw_asset_warranties` (
  `documentID` int(11) NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `expiration_reminder_check` tinyint(1) DEFAULT NULL,
  `reminder_sent` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hw_asset_warranties`
--

INSERT INTO `hw_asset_warranties` (`documentID`, `expiration_date`, `expiration_reminder_check`, `reminder_sent`) VALUES
(14, '2026-04-24', 1, 0),
(15, '2026-04-24', 1, 0),
(17, '2026-05-13', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
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
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1774862370, 1),
(2, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1774862370, 1),
(3, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1774862370, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(9) NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test00', NULL, NULL, 1, NULL, '2026-03-30 09:41:56', '2026-03-30 09:41:56', NULL),
(2, 'superadmin', NULL, NULL, 1, NULL, '2026-05-14 15:06:41', '2026-05-14 15:06:41', NULL),
(3, 'admin', NULL, NULL, 1, NULL, '2026-05-14 15:06:42', '2026-05-14 15:06:42', NULL),
(4, 'reader', NULL, NULL, 1, NULL, '2026-05-14 15:06:42', '2026-05-14 15:06:42', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_secret` (`type`,`secret`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_permissions_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `auth_remember_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hardware_assets`
--
ALTER TABLE `hardware_assets`
  ADD PRIMARY KEY (`hardwareID`);

--
-- Indexes for table `hw_assets_nic`
--
ALTER TABLE `hw_assets_nic`
  ADD PRIMARY KEY (`hardwareID`);

--
-- Indexes for table `hw_asset_documents`
--
ALTER TABLE `hw_asset_documents`
  ADD PRIMARY KEY (`documentID`),
  ADD KEY `fk_hw_asset_documents` (`hardwareID`);

--
-- Indexes for table `hw_asset_warranties`
--
ALTER TABLE `hw_asset_warranties`
  ADD PRIMARY KEY (`documentID`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hardware_assets`
--
ALTER TABLE `hardware_assets`
  MODIFY `hardwareID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hw_asset_documents`
--
ALTER TABLE `hw_asset_documents`
  MODIFY `documentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hw_assets_nic`
--
ALTER TABLE `hw_assets_nic`
  ADD CONSTRAINT `fk_hw_assets_nic` FOREIGN KEY (`hardwareID`) REFERENCES `hardware_assets` (`hardwareID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nic_hardware` FOREIGN KEY (`hardwareID`) REFERENCES `hardware_assets` (`hardwareID`) ON DELETE CASCADE;

--
-- Constraints for table `hw_asset_documents`
--
ALTER TABLE `hw_asset_documents`
  ADD CONSTRAINT `fk_hw_asset_documents` FOREIGN KEY (`hardwareID`) REFERENCES `hardware_assets` (`hardwareID`) ON DELETE CASCADE;

--
-- Constraints for table `hw_asset_warranties`
--
ALTER TABLE `hw_asset_warranties`
  ADD CONSTRAINT `fk_hw_asset_warranties_hw_asset_documents` FOREIGN KEY (`documentID`) REFERENCES `hw_asset_documents` (`documentID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
