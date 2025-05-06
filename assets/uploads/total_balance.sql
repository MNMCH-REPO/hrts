-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 08:25 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mnmch_hrts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `total_balance`
--

CREATE TABLE `total_balance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sl` int(11) NOT NULL DEFAULT 0,
  `sil` int(11) NOT NULL DEFAULT 0,
  `elc` int(11) NOT NULL DEFAULT 0,
  `bl` int(11) NOT NULL DEFAULT 1,
  `ml` int(11) NOT NULL DEFAULT 0,
  `pl` int(11) NOT NULL DEFAULT 0,
  `s` int(11) NOT NULL DEFAULT 0,
  `spl` int(11) NOT NULL DEFAULT 0,
  `lwop` int(11) NOT NULL DEFAULT 0,
  `brl` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `total_balance`
--

INSERT INTO `total_balance` (`id`, `user_id`, `sl`, `sil`, `elc`, `bl`, `ml`, `pl`, `s`, `spl`, `lwop`, `brl`) VALUES
(1, 1168, 5, 5, 5, 5, 5, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `total_balance`
--
ALTER TABLE `total_balance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `total_balance`
--
ALTER TABLE `total_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `total_balance`
--
ALTER TABLE `total_balance`
  ADD CONSTRAINT `total_balance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
