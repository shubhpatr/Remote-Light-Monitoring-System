-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2021 at 03:18 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aarnova`
--

-- --------------------------------------------------------

--
-- Table structure for table `status_table`
--

CREATE TABLE `status_table` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lift_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status_table`
--

INSERT INTO `status_table` (`id`, `lift_name`, `status`, `created_at`, `updated_at`) VALUES
(9, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:46:01', '2021-01-16 12:46:01'),
(10, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:46:13', '2021-01-16 12:46:13'),
(11, 'Suvastika_R&D', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:46:18', '2021-01-16 12:46:18'),
(12, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:46:59', '2021-01-16 12:46:59'),
(13, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:47:43', '2021-01-16 12:47:43'),
(14, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:47:48', '2021-01-16 12:47:48'),
(15, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:54:15', '2021-01-16 12:54:15'),
(16, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:54:20', '2021-01-16 12:54:20'),
(17, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:54:25', '2021-01-16 12:54:25'),
(18, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 12:54:37', '2021-01-16 12:54:37'),
(19, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 13:34:17', '2021-01-16 13:34:17'),
(20, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 13:44:42', '2021-01-16 13:44:42'),
(21, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 20:41:58', '2021-01-16 20:41:58'),
(22, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 20:42:04', '2021-01-16 20:42:04'),
(23, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 20:42:09', '2021-01-16 20:42:09'),
(24, 'SDC001', 'Output current high fault/warning due to Y phase,Short circuit fault/shutdown,300% load', '2021-01-16 20:51:05', '2021-01-16 20:51:05'),
(25, 'Suvastika_R&D', 'Output voltage high fault,Output voltage fail fault', '2021-01-16 20:51:11', '2021-01-16 20:51:11'),
(26, 'Suvastika_R&D', 'Battery voltage high fault/shutdown', '2021-01-16 20:51:16', '2021-01-16 20:51:16'),
(27, 'Suvastika_R&D', 'Output Current high warning,Output current high fault/warning due to B phase,200% load', '2021-01-16 20:51:21', '2021-01-16 20:51:21'),
(28, 'Suvastika_R&D', 'Inverter OFF', '2021-01-16 20:51:26', '2021-01-16 20:51:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `status_table`
--
ALTER TABLE `status_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `status_table`
--
ALTER TABLE `status_table`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
