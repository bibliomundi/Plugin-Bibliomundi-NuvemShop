-- --------------------------------------------------------

-- Server version:               5.5.53 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for nuvemshop
DROP DATABASE IF EXISTS `nuvemshop`;
CREATE DATABASE IF NOT EXISTS `nuvemshop` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `nuvemshop`;

-- Dumping structure for table nuvemshop.categories_mapping
CREATE TABLE IF NOT EXISTS `categories_mapping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tiendanube_id` int(11) NOT NULL,
  `bbm_id_category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nuvem_id_category` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table nuvemshop.categories_mapping: ~39 rows (approximately)
DELETE FROM `categories_mapping`;
/*!40000 ALTER TABLE `categories_mapping` DISABLE KEYS */;
INSERT INTO `categories_mapping` (`id`, `tiendanube_id`, `bbm_id_category`, `nuvem_id_category`, `created_at`, `updated_at`) VALUES
	(1, 430437, 'LAW087000', 1951722, NULL, NULL),
	(2, 430437, '500', 1951723, NULL, NULL),
	(3, 430437, 'TRV026040', 1951724, NULL, NULL),
	(4, 430437, 'B869.2', 1951725, NULL, NULL),
	(5, 430437, 'BIB002070', 1951726, NULL, NULL),
	(6, 430437, '420', 1951727, NULL, NULL),
	(7, 430437, 'OCC029000', 1951728, NULL, NULL),
	(8, 430437, 'B869.6', 1951729, NULL, NULL),
	(9, 430437, 'STU003000', 1951730, NULL, NULL),
	(10, 430437, '860', 1951731, NULL, NULL),
	(11, 430437, 'ANT002000', 1951732, NULL, NULL),
	(12, 430437, '920', 1951733, NULL, NULL),
	(13, 430437, 'ART019000', 1951734, NULL, NULL),
	(14, 430437, '520', 1951735, NULL, NULL),
	(15, 430437, 'ART016010', 1958632, NULL, NULL),
	(16, 430437, '010', 1958633, NULL, NULL),
	(17, 430437, '010', 1958634, NULL, NULL),
	(18, 430437, 'YAF001020', 1962578, NULL, NULL),
	(19, 430437, 'FIC028110', 1962579, NULL, NULL),
	(20, 430437, 'JUV001000', 1962580, NULL, NULL),
	(21, 430437, 'B869.3', 1962581, NULL, NULL),
	(22, 430437, '028.5', 1962583, NULL, NULL),
	(23, 430437, 'B869', 1962584, NULL, NULL),
	(24, 430437, 'POE001000', 1962585, NULL, NULL),
	(25, 430437, 'JUV012020', 1962586, NULL, NULL),
	(26, 430437, '869', 1962587, NULL, NULL),
	(27, 430437, 'POE023000', 1962588, NULL, NULL),
	(28, 430437, 'POE000000', 1962752, NULL, NULL),
	(29, 430437, 'B869.1', 1962753, NULL, NULL),
	(30, 430437, 'FIC049050', 1962754, NULL, NULL),
	(31, 430437, 'FIC022090', 1962755, NULL, NULL),
	(32, 430437, 'FIC002000', 1962756, NULL, NULL),
	(33, 430437, 'FIC029000', 1962757, NULL, NULL),
	(34, 430437, 'FIC028010', 1962758, NULL, NULL),
	(35, 430437, 'YAF006000', 1962759, NULL, NULL),
	(36, 430437, 'FIC027110', 1962760, NULL, NULL),
	(37, 430437, 'FIC052000', 1962761, NULL, NULL),
	(38, 430437, 'FIC028090', 1962762, NULL, NULL),
	(39, 430437, 'YAF052000', 1971953, NULL, NULL);
/*!40000 ALTER TABLE `categories_mapping` ENABLE KEYS */;

-- Dumping structure for table nuvemshop.email_templates
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nuvemshop_id` int(11) NOT NULL,
  `from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header` text COLLATE utf8mb4_unicode_ci,
  `footer` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table nuvemshop.email_templates: ~1 rows (approximately)
DELETE FROM `email_templates`;
/*!40000 ALTER TABLE `email_templates` DISABLE KEYS */;
INSERT INTO `email_templates` (`id`, `nuvemshop_id`, `from_name`, `from_address`, `subject`, `header`, `footer`, `content`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Viet Hoang', 'viet.hoang@vn.devinition.com', 'Download links from BiblioMundi-NuvemShop', '<p><a href="http://nuvemshop-bibliomundi.demo.devinition.com" target="_blank">BiblioMundi - NuvemShop</a></p>', '<p>&copy; 2017 NuvemShop-BiblioMundi. All rights reserved.</p>', '<p>Dear [RecipientName],</p>\r\n\r\n<p>Thank you for buying our product. Here is your download links:</p>\r\n\r\n<p>[DownloadLinks]</p>\r\n\r\n<p>Best Regards,</p>\r\n\r\n<p>BibiloMundi-NuvemShop Team</p>', '2017-03-31 07:30:59', '2017-03-31 07:30:59');
/*!40000 ALTER TABLE `email_templates` ENABLE KEYS */;

-- Dumping structure for table nuvemshop.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table nuvemshop.migrations: ~8 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2017_03_15_041418_create_settings_table', 2),
	(9, '2017_03_17_080201_create_numvemshops_table', 3),
	(14, '2017_03_21_110749_create_product_mapping_table', 4),
	(15, '2017_03_21_110807_create_category_mapping_table', 4),
	(16, '2017_03_21_084511_create_webhooks_table', 5),
	(17, '2017_03_30_073136_create_email_templates_table', 5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table nuvemshop.nuvemshops
CREATE TABLE IF NOT EXISTS `nuvemshops` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiendanube_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nuvemshops_client_id_unique` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table nuvemshop.nuvemshops: ~1 rows (approximately)
DELETE FROM `nuvemshops`;
/*!40000 ALTER TABLE `nuvemshops` DISABLE KEYS */;
INSERT INTO `nuvemshops` (`id`, `client_id`, `client_secret`, `tiendanube_id`, `access_token`, `created_at`, `updated_at`) VALUES
	(1, '479', 'qyy3NSARFQj8xei2EY6lqflbX1fs4OKPwHjbxEwnofYynFmV', '430437', 'b81c4875d1d72a44149f4cac747fd2617b99b27d', '2017-03-20 08:36:55', '2017-04-26 10:51:05');
/*!40000 ALTER TABLE `nuvemshops` ENABLE KEYS */;

-- Dumping structure for table nuvemshop.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table nuvemshop.password_resets: ~2 rows (approximately)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('admin@yopmail.com', '$2y$10$jArLv3uxEZ.vDaArB3bCPefy3WfGtsRTGdMbaEczugI4qPyrM4MFS', '2017-04-13 08:54:49'),
	('dung.luong@vn.devinition.com', '$2y$10$pkXzUD7YBxkSn2cdUOGUieadU7AAaG5kvS/gHg/1he.DyM/I9jS9e', '2017-04-13 09:31:43');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table nuvemshop.products_mapping
CREATE TABLE IF NOT EXISTS `products_mapping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tiendanube_id` int(11) NOT NULL,
  `bbm_id_product` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nuvem_id_product` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table nuvemshop.products_mapping: ~0 rows (approximately)
DELETE FROM `products_mapping`;
/*!40000 ALTER TABLE `products_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_mapping` ENABLE KEYS */;

-- Dumping structure for table nuvemshop.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table nuvemshop.settings: ~4 rows (approximately)
DELETE FROM `settings`;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
	(1, 'bbm_client_id', '7a054eaf414b232de9df7f1a15b03c8890e89290', '2017-03-17 09:37:00', '2017-04-21 07:11:04'),
	(2, 'bbm_client_secret', 'c63f5cef76feef95cddf83298647479926c38a01', '2017-03-17 09:37:00', '2017-04-21 07:33:48'),
	(3, 'bbm_operation', 'complete', '2017-03-17 09:37:00', '2017-04-12 09:01:43'),
	(4, 'bbm_environment', 'production', '2017-03-17 09:37:00', '2017-04-21 10:09:00');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table nuvemshop.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table nuvemshop.users: ~5 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@yopmail.com', '$2y$10$pvjjvFoQQ14vfeVSmu5ATuo431tuKSf/etHUGGU4DITJVMQ4xQNDK', 'giR3kNBMUxA1HbH31QLETqBumLpWU1wZ2yBcJdXw3ATudaWCkw5Alkavcga9', '2017-03-15 08:43:50', '2017-03-15 08:43:50'),
	(2, 'Vietdaica', 'viet.hoang@yopmail.com', '$2y$10$j.nYwA4o4/ynrfKGLuVFBOZ45PWRxSdZls1C9NoQbY5/34nwxVlQu', 'rK7OxJnxhptaJ3H5aOROMDNthaLwxB1PZqnYClrheKJkKQM3AcT9o1Z5TWuB', '2017-03-15 10:10:15', '2017-03-15 10:10:15'),
	(4, 'triet.trinh', 'triet.trinh@vn.devinition.com', '$2y$10$FIAyil/nX0vARNFL.RpJ2.SRhcxHxwoYFkD76pBQ2/YI5tzynpTcC', NULL, '2017-03-17 11:45:44', '2017-03-17 11:45:44'),
	(5, 'dung.luong', 'dung.luong@vn.devinition.com', '$2y$10$mQ3.aY53MBoMbSG0ipRNiOB7GkfB7pl.EGqsth.Q93m5PUFosBqlS', NULL, '2017-03-27 09:24:58', '2017-03-27 09:24:58'),
	(6, 'Dung', 'dung.nguyen@yopmail.com', '$2y$10$hXpItM6GxSAj9GOBt.ox8.esFL3Wbd7Id1nc1Ocy4JpZJsuLb/CPS', 'tkjqvCvv5GJ6NDHjUMyM3xOOpiLppUwUSdq0IulcGFamPoLdGDclcZb0zU2w', '2017-03-29 04:30:07', '2017-03-29 04:30:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table nuvemshop.webhooks
CREATE TABLE IF NOT EXISTS `webhooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nuvemshop_id` int(11) NOT NULL,
  `tienda_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table nuvemshop.webhooks: ~5 rows (approximately)
DELETE FROM `webhooks`;
/*!40000 ALTER TABLE `webhooks` DISABLE KEYS */;
INSERT INTO `webhooks` (`id`, `nuvemshop_id`, `tienda_id`, `status`, `event`, `url`, `created_at`, `updated_at`) VALUES
	(16, 1, '48848', 'Active', 'order/created', 'http://nuvemshop-bibliomundi.demo.devinition.com/callback/order/created', '2017-03-23 08:30:22', '2017-04-11 06:50:11'),
	(20, 1, '48852', 'Active', 'product/created', 'http://nuvemshop-bibliomundi.demo.devinition.com/callback/product/created', '2017-03-23 10:56:13', '2017-04-12 10:24:22'),
	(22, 1, '48854', 'Active', 'product/deleted', 'http://nuvemshop-bibliomundi.demo.devinition.com/callback/product/deleted', '2017-03-23 11:04:26', '2017-04-12 10:23:58'),
	(23, 1, '49636', 'Active', 'order/paid', 'http://nuvemshop-bibliomundi.demo.devinition.com/callback/order/paid', '2017-04-11 06:31:04', '2017-04-11 06:31:09'),
	(24, 1, '49669', 'Active', 'category/deleted', 'http://nuvemshop-bibliomundi.demo.devinition.com/callback/category/deleted', '2017-04-12 10:24:49', '2017-04-12 10:24:50');
/*!40000 ALTER TABLE `webhooks` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
