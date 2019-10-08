-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2019 at 04:07 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_5-7`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_code`, `created_at`, `updated_at`) VALUES
(1, 'Spice', 'spice', '2019-10-05 13:45:30', '2019-10-05 13:45:30'),
(2, 'Beverage', 'beverage', '2019-10-05 13:47:12', '2019-10-05 13:47:12'),
(3, 'Condiment', 'condiment', '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(4, 'Side Dish', 'side_dish', '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(5, 'Dairy', 'dairy', '2019-10-05 16:00:30', '2019-10-05 16:00:30'),
(6, 'Greains Breads Cereals', 'greains_breads_cereals', '2019-10-05 16:03:40', '2019-10-05 16:03:40'),
(7, 'Vegetable', 'vegetable', '2019-10-08 02:52:05', '2019-10-08 02:52:05'),
(8, 'Snack', 'snack', '2019-10-08 02:54:03', '2019-10-08 02:54:03'),
(9, 'Fish', 'fish', '2019-10-08 03:00:25', '2019-10-08 03:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `item_id`, `quantity`, `unit_id`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 200.00, 1, 2.25, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(2, 1, 2, 500.00, 1, 2.99, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(3, 1, 4, 908.00, 1, 10.95, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(4, 2, 5, 450.00, 1, 5.00, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(5, 3, 6, 2.00, 3, 4.90, '2019-10-08 02:45:43', '2019-10-08 02:45:43'),
(7, 3, 9, 6.00, 4, 2.50, '2019-10-08 02:47:58', '2019-10-08 02:47:58'),
(8, 3, 8, 1.00, 4, 2.49, '2019-10-08 02:49:37', '2019-10-08 02:49:37'),
(9, 3, 7, 2.00, 3, 2.39, '2019-10-08 02:50:16', '2019-10-08 02:50:16'),
(10, 4, 10, 1.03, 2, 3.62, '2019-10-08 02:57:15', '2019-10-08 02:57:15'),
(11, 4, 11, 500.00, 1, 1.99, '2019-10-08 02:57:41', '2019-10-08 02:57:41'),
(12, 4, 12, 1.00, 5, 1.00, '2019-10-08 02:59:33', '2019-10-08 02:59:33'),
(13, 5, 13, 2.00, 2, 13.00, '2019-10-08 03:06:14', '2019-10-08 03:06:14'),
(14, 5, 14, 250.00, 1, 5.00, '2019-10-08 03:06:50', '2019-10-08 03:06:50');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_summaries`
--

CREATE TABLE `invoice_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `value` double(8,2) DEFAULT NULL,
  `invoice_date` datetime NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_summaries`
--

INSERT INTO `invoice_summaries` (`id`, `invoice_no`, `value`, `invoice_date`, `store_id`, `created_at`, `updated_at`) VALUES
(1, '45676', 16.19, '2019-10-04 00:00:00', 1, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(2, '11909181843211', 5.00, '2019-09-18 00:00:00', 2, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(3, '3298-084-788', 12.28, '2019-10-01 00:00:00', 3, '2019-10-08 02:44:25', '2019-10-08 02:50:16'),
(4, '3298-082-6264', 6.61, '2019-10-08 00:00:00', 3, '2019-10-08 02:56:31', '2019-10-08 02:59:33'),
(5, 'S0159037', 18.00, '2019-10-08 00:00:00', 4, '2019-10-08 03:05:39', '2019-10-08 03:06:50');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcat_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_name`, `item_code`, `subcat_id`, `created_at`, `updated_at`) VALUES
(1, 'Turmeric Powder', 'turmeric_powder', 1, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(2, 'Mango Pickle - Ashoka', 'mango_pickle_-_ashoka', 3, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(4, 'Tea - Jivraj 9', 'tea_-_jivraj_9', 2, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(5, 'Cabbage Kimchi', 'cabbage_kimchi', 4, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(6, 'Ice Cream', 'ice_cream', 5, '2019-10-05 16:00:16', '2019-10-05 16:00:16'),
(7, 'Liquid Milk', 'liquid_milk', 6, '2019-10-05 16:01:38', '2019-10-05 16:01:38'),
(8, 'Pane Di Casa', 'pane_di_casa', 7, '2019-10-05 16:04:10', '2019-10-05 16:04:10'),
(9, 'Hamburger Buns', 'hamburger_buns', 7, '2019-10-05 16:04:55', '2019-10-05 16:04:55'),
(10, 'Pumpkin', 'pumpkin', 8, '2019-10-08 02:52:25', '2019-10-08 02:52:25'),
(11, 'Choc Chip Cookie', 'choc_chip_cookie', 9, '2019-10-08 02:54:47', '2019-10-08 02:54:47'),
(12, 'Asparagus', 'asparagus', 8, '2019-10-08 02:55:20', '2019-10-08 02:55:20'),
(13, 'Ruhi', 'ruhi', 10, '2019-10-08 03:01:31', '2019-10-08 03:01:31'),
(14, 'Shutki', 'shutki', 11, '2019-10-08 03:01:57', '2019-10-08 03:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_09_01_120659_create_projects_table', 1),
(4, '2019_09_03_104156_create_categories_table', 1),
(5, '2019_09_18_010347_create_subcategories_table', 1),
(6, '2019_09_20_061249_create_items_table', 1),
(7, '2019_09_24_082224_create_stores_table', 1),
(8, '2019_09_25_052452_create_units_table', 1),
(9, '2019_09_26_035905_create_invoice-summaries_table', 1),
(10, '2019_09_26_040020_create_invoice-details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suburb` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `store_name`, `store_code`, `address`, `suburb`, `abn`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Carnegie Indian Express', 'carnegie_indian_express', NULL, 'carnegie', NULL, NULL, '2019-10-05 13:48:29', '2019-10-05 13:48:29'),
(2, 'OK MART', 'ok_mart', NULL, 'carnegie', NULL, NULL, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(3, 'Woolworths', 'woolworths', NULL, 'carnegie', NULL, NULL, '2019-10-05 16:05:11', '2019-10-05 16:05:11'),
(4, 'Bengal Traders Halal Supermarket', 'bengal_traders_halal_supermarket', NULL, 'Huntingdale', NULL, NULL, '2019-10-08 03:03:32', '2019-10-08 03:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subcat_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcat_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `subcat_name`, `subcat_code`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Deshi Spice', 'deshi_spice', 1, '2019-10-05 13:46:57', '2019-10-05 13:46:57'),
(2, 'Tea', 'tea', 2, '2019-10-05 13:47:29', '2019-10-05 13:47:29'),
(3, 'Pickle', 'pickle', 3, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(4, 'Vegetable', 'vegetable', 4, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(5, 'Desert', 'desert', 4, '2019-10-05 16:00:00', '2019-10-05 16:00:00'),
(6, 'Milk', 'milk', 5, '2019-10-05 16:01:08', '2019-10-05 16:01:08'),
(7, 'Bread', 'bread', 6, '2019-10-05 16:03:47', '2019-10-05 16:03:47'),
(8, 'Fresh Vegetable', 'fresh_vegetable', 7, '2019-10-08 02:52:15', '2019-10-08 02:52:15'),
(9, 'Cookie', 'cookie', 8, '2019-10-08 02:54:31', '2019-10-08 02:54:31'),
(10, 'Fresh Fish', 'fresh_fish', 9, '2019-10-08 03:01:10', '2019-10-08 03:01:10'),
(11, 'Dry Fish', 'dry_fish', 9, '2019-10-08 03:01:48', '2019-10-08 03:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `unit_code`, `created_at`, `updated_at`) VALUES
(1, 'Gram', 'gm', NULL, NULL),
(2, 'Kg', 'kg', NULL, NULL),
(3, 'Liter', 'liter', NULL, NULL),
(4, 'Each', 'ea', NULL, NULL),
(5, 'Bunch', 'bunch', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'yeasir', 'rodham_bandaras@hotmail.com', NULL, '$2y$10$lQriz7M/M5vWN1nbk.sV7u14uXP.mk5dVEW2t4uFLzppr8d0kI2T2', NULL, '2019-10-08 02:01:12', '2019-10-08 02:01:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_category_code_unique` (`category_code`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_details_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_details_item_id_foreign` (`item_id`),
  ADD KEY `invoice_details_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `invoice_summaries`
--
ALTER TABLE `invoice_summaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_summaries_invoice_no_unique` (`invoice_no`),
  ADD KEY `invoice_summaries_store_id_foreign` (`store_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_item_code_unique` (`item_code`),
  ADD KEY `items_subcat_id_foreign` (`subcat_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stores_store_code_unique` (`store_code`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subcategories_subcat_code_unique` (`subcat_code`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_unit_code_unique` (`unit_code`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `invoice_summaries`
--
ALTER TABLE `invoice_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_details_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoice_summaries` (`id`),
  ADD CONSTRAINT `invoice_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `invoice_details_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `invoice_summaries`
--
ALTER TABLE `invoice_summaries`
  ADD CONSTRAINT `invoice_summaries_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_subcat_id_foreign` FOREIGN KEY (`subcat_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
