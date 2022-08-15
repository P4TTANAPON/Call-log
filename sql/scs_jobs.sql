-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2022 at 03:58 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_calllog`
--

-- --------------------------------------------------------

CREATE TABLE `scs_jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `create_user_id` int(10) UNSIGNED NOT NULL,
  `job_id` int(10) UNSIGNED NOT NULL,
  `serial_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_part_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `malfunction` text COLLATE utf8_unicode_ci NOT NULL,
  `cause` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `hw_ph1_id` int(10) UNSIGNED DEFAULT NULL,
  `hw_ph2_id` int(10) UNSIGNED DEFAULT NULL,
  `action_dtm` datetime DEFAULT NULL,
  `start_dtm` datetime DEFAULT NULL,
  `operator_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hw_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `scs_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scs_jobs_create_user_id_foreign` (`create_user_id`),
  ADD KEY `scs_jobs_job_id_foreign` (`job_id`),
  ADD KEY `scs_jobs_serial_number_index` (`serial_number`);

ALTER TABLE `scs_jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `scs_jobs`
  ADD CONSTRAINT `scs_jobs_create_hd_id_foreign` FOREIGN KEY (`hw_id`) REFERENCES `hardware_items` (`id`),
  ADD CONSTRAINT `scs_jobs_create_user_id_foreign` FOREIGN KEY (`create_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `scs_jobs_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);


