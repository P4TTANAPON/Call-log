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

--
-- Table structure for table `solve_descriptions`
--

CREATE TABLE `solve_descriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `phase` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `tier` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `solve_descriptions`
--

INSERT INTO `solve_descriptions` (`id`, `created_at`, `updated_at`, `description`, `phase`, `tier`) VALUES
(1, NULL, NULL, 'แนะนำเจ้าหน้าที่ ให้ฝ่ายทะเบียนส่งเรื่องกลับให้รังวัดแก้ไข < จากนั้นฝ่ายรังวัดรับเรื่อง (ได้ รว 12 ใหม่ จากคำขอและวันที่รับเรื่องเดิม) และดำเนินการตามขั้นตอนปกติ', '4', 2),
(2, NULL, NULL, 'สาเหตุเกิดจากเลขบัตรประชาชนของราษฏรเกิดข้อผิดพลาด', '4', 2),
(3, NULL, NULL, 'ติดตั้ง driver เครื่องอ่านบัตร', '4', 2),
(4, NULL, NULL, 'ลบใบเบิกแล้วจัดการสิทธิ์ ให้เป็น จนท ทะเบียน ของระบบวัสดุ  แล้วจึงทำการเบิกใหม่ ', '4', 2),
(5, NULL, NULL, 'ดำเนินการแก้ไขเบอร์ฝ่ายรังวัดตามแจ้ง', '4', 2),
(6, NULL, NULL, 'ติดต่อกลับให้คำแนะนำเจ้าหน้าที่ในการเปลี่ยนช่างและเปลี่ยนวันนัดรังวัด', '4', 2),
(7, NULL, NULL, 'ดำเนินการแก้เรียบร้อย', '4', 2),
(8, NULL, NULL, 'ดำเนินการยกเลิกส่งเงิน ให้เจ้าหน้าที่เรียบร้อย', '4', 2),
(9, NULL, NULL, 'ยกเลิกปิดงบแล้ว ยกเลิกบันทึกเงินคงเหลือ แล้วค้นหาใหม่ ', '4', 2),
(10, NULL, NULL, 'ตรวจสอบแล้วสามารถใช้งานได้ปกติ', '4', 2),
(11, NULL, NULL, 'ให้ใช้วันที่ 1 ได้   แต่ ในหน้านำส่งเงิน ระบุเป็นวันที่ 30/09 ได้ ยอดเงินจะไม่ผิด', '4', 2),
(12, NULL, NULL, 'ขยายสิทธิการใช้งานให้เจ้าหน้าที่  เนื่องจากสิทธิการใช้งานหมดอายุตามปีงบประมาณ', '4', 2),
(13, NULL, NULL, 'แก้ไขงานเดิมเรียบร้อย', '4', 2),
(14, NULL, NULL, 'ยกเลิกให้เจ้าหน้าที่นำส่งใหม่เรียบร้อย', '4', 2),
(15, NULL, NULL, 'แก้ไขให้เจ้าหน้าที่ดำเนินการใหม่เนื่องจากมีการข้ามแท็ป', '4', 2),
(16, NULL, NULL, 'สามารถใช้งานได้ปกติแล้ว', '4', 2),
(17, NULL, NULL, 'เจ้าหน้าที่ลบเอกสารสิทธิ แก้ไขโดนให้เจ้าหน้าที่เพิ่มเอกสารสิทธิใหม่แล้วดำเนินการใหม่', '4', 2),
(18, NULL, NULL, 'รีโมทไปเครื่องดังกล่าวเพื่อแนะนำเจ้าหน้าที่', '4', 2),
(19, NULL, NULL, 'ตรวจสอบและดำเนินการแก้ไขเรียบร้อย', '4', 2),
(20, NULL, NULL, 'เนื่องจากมีการกดข้ามแท็ป แก้ไขให้เจาหน้าที่กดดำเนินการใหม่แล้วจดทะเบียนใหม่', '4', 2),
(21, NULL, NULL, 'ตรวจสอบแล้วปกติและไม่สามารถติดต่อเจ้าหน้าที่ได้', '4', 2),
(22, NULL, NULL, 'แนะนำให้เจ้าหน้าที่ไปที่เมนูกำหนดช่องบริการ แล้วดำเนินการปิดและเปิดช่องบริการอีกครั้ง', '4', 2),
(23, NULL, NULL, 'ตั้งค่าไดรเวอร์เครื่องพิมพ์', '4', 2),
(24, NULL, NULL, 'Reset password  ให้กับ User เนื่องจากลืม Password', '4', 2),
(25, NULL, NULL, 'ตั้งค่า Loq queue system', '4', 2),
(16384, '2022-04-21 06:22:40', '2022-04-21 06:22:40', 'ทดสอบ', '4', 2),
(16385, '2022-04-21 06:31:01', '2022-04-21 06:31:01', 'ทดสอบ ขึ้นบันทัดใหม่ แล้ว save ', '4', 2),
(16386, '2022-04-21 06:58:49', '2022-04-21 06:58:49', 'ให้ดำเนินการ Clone Windows ใหม่', '4', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `solve_descriptions`
--
ALTER TABLE `solve_descriptions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `solve_descriptions`
--
ALTER TABLE `solve_descriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16387;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
