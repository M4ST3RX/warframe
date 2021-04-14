-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: 142.93.194.192:3306
-- Generation Time: Apr 14, 2021 at 09:54 AM
-- Server version: 8.0.20
-- PHP Version: 7.3.21-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warframe`
--

-- --------------------------------------------------------

--
-- Table structure for table `craftings`
--

CREATE TABLE `craftings` (
  `id` bigint UNSIGNED NOT NULL,
  `blueprint` bigint UNSIGNED NOT NULL,
  `input_items` json NOT NULL,
  `output_item` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount` int NOT NULL,
  `price` int NOT NULL DEFAULT '0',
  `time` int NOT NULL DEFAULT '0',
  `rush` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `craftings`
--

INSERT INTO `craftings` (`id`, `blueprint`, `input_items`, `output_item`, `created_at`, `updated_at`, `amount`, `price`, `time`, `rush`) VALUES
(309, 947, '{\"945\": \"1\", \"946\": \"1\", \"1590\": \"1\"}', 57, '2021-04-14 08:58:09', '2021-04-14 08:58:09', 1, 0, 0, 0),
(308, 946, '{\"942\": \"1\", \"943\": \"1\", \"944\": \"1\", \"1578\": \"1\"}', 945, '2021-04-14 08:57:37', '2021-04-14 08:57:37', 1, 0, 0, 0),
(307, 945, '{\"939\": \"1\", \"940\": \"1\", \"941\": \"1\", \"1578\": \"1\"}', 946, '2021-04-14 08:57:01', '2021-04-14 08:57:01', 1, 0, 0, 0),
(306, 944, '{\"1564\": \"500\", \"1571\": \"500\", \"1573\": \"1\", \"1574\": \"1\"}', 944, '2021-04-14 08:56:13', '2021-04-14 08:56:13', 1, 0, 0, 0),
(305, 943, '{\"1562\": \"1000\", \"1571\": \"300\", \"1574\": \"1\"}', 943, '2021-04-14 08:55:40', '2021-04-14 08:55:40', 1, 0, 0, 0),
(304, 942, '{\"1561\": \"150\", \"1562\": \"150\", \"1571\": \"500\", \"1576\": \"1\"}', 942, '2021-04-14 08:53:31', '2021-04-14 08:53:31', 1, 0, 0, 0),
(303, 941, '{\"1563\": \"500\", \"1569\": \"500\", \"1573\": \"1\", \"1575\": \"1\"}', 941, '2021-04-14 08:52:13', '2021-04-14 08:52:13', 1, 0, 0, 0),
(302, 940, '{\"1569\": \"300\", \"1570\": \"1000\", \"1575\": \"1\"}', 940, '2021-04-14 08:50:20', '2021-04-14 08:50:20', 1, 0, 0, 0),
(301, 939, '{\"1561\": \"150\", \"1569\": \"500\", \"1570\": \"150\", \"1576\": \"1\"}', 939, '2021-04-14 08:49:23', '2021-04-14 08:49:23', 1, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `craftings`
--
ALTER TABLE `craftings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `craftings`
--
ALTER TABLE `craftings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
