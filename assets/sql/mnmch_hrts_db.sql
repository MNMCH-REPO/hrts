-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 12:33 PM
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
-- Database: `mnmch_hrts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `ticket_id`, `uploaded_by`, `file_path`, `file_name`, `uploaded_at`) VALUES
(47, 26, 1500, 'assets/uploads/cor-bascRvJpVp3r5D.pdf', 'cor-bascRvJpVp3r5D.pdf', '2025-04-19 03:15:24'),
(48, 26, 1500, 'assets/uploads/SHARP F&B ADMIN_20250410_045959.pdf', 'SHARP F&B ADMIN_20250410_045959.pdf', '2025-04-19 03:24:20'),
(49, 26, 1500, 'assets/uploads/DOMINGO EARL GERALD 073.jpg', 'DOMINGO EARL GERALD 073.jpg', '2025-04-19 03:27:49'),
(50, 26, 2, 'assets/uploads/Ae86 static wallpaper.jpg', 'Ae86 static wallpaper.jpg', '2025-04-19 03:30:52'),
(51, 53, 1, 'assets/uploads/DOMINGO EARL GERALD (66).JPG', 'DOMINGO EARL GERALD (66).JPG', '2025-04-22 02:00:19'),
(52, 2, 2, 'assets/uploads/DOMINGO EARL GERALD (66).JPG', 'DOMINGO EARL GERALD (66).JPG', '2025-04-22 02:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL,
  `action_type` varchar(255) NOT NULL,
  `affected_table` enum('users','categories','tickets','ticket_responses','attachments') NOT NULL,
  `affected_id` int(11) NOT NULL,
  `details` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id`, `action_type`, `affected_table`, `affected_id`, `details`, `user_id`, `timestamp`) VALUES
(1, 'UPDATE', 'users', 4000, 'Updated user details: Name=carol, Email=carol@example.com, Role=Employee, Department=HEART STATION DEPARTMENT', 1200, '2025-04-07 09:37:20'),
(2, 'UPDATE', 'users', 1200, 'Updated user details: Name=carol, Email=carol@example.com, Role=Employee, Department=INFORMATION DEPARTMENT', 1, '2025-04-07 09:39:59'),
(3, '', 'users', 1234, 'Created user: Name=Bonet, Email=bonet@gmail.com, Role=HR Rep, Department=PHARMACY DEPARTMENT', 1, '2025-04-07 09:45:07'),
(4, '', 'tickets', 16, 'Created ticket: Subject=Printer, Category=6, Description=sample lans 123', 2, '2025-04-07 20:47:27'),
(5, '', 'tickets', 17, 'Created ticket: Subject=123123, Category=8, Description=123123', 2, '2025-04-07 20:49:12'),
(6, 'CREATE', 'tickets', 18, 'Created ticket: Subject=asdasdsad, Category=8, Description=asdasdasdasd', 2, '2025-04-07 20:51:09'),
(7, 'INSERT', 'ticket_responses', 14, 'Added response to ticket ID 2: haksdoasdad asjkdashd;lak', 2, '2025-04-07 21:01:35'),
(8, 'ASSIGN', 'tickets', 15, 'Assigned ticket ID 15 to user ID 1799 with priority Medium.', 1, '2025-04-07 21:09:14'),
(9, 'ASSIGN', 'tickets', 8, 'Assigned ticket ID 8 to user ID 9 with priority Low.', 1, '2025-04-07 21:10:19'),
(10, 'UPDATE', 'tickets', 8, 'Updated ticket ID 8 status to Resolved.', 1, '2025-04-07 21:12:54'),
(11, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-08 03:23:53'),
(12, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-08 06:15:45'),
(13, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-08 00:15:51'),
(14, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-08 06:16:53'),
(15, 'UPDATE', 'users', 1, 'Updated user details: Name=John Mico D. Intacto, Email=mico@gmail.com, Role=Admin, Department=HR Department', 1, '2025-04-08 00:20:16'),
(16, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-08 00:55:39'),
(19, 'LOGIN', 'users', 9, 'User ID 9 logged in successfully.', 1500, '2025-04-08 07:02:39'),
(20, 'LOGOUT', 'users', 9, 'User ID 9 logged out successfully.', 1500, '2025-04-08 01:02:55'),
(21, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-08 07:03:01'),
(22, 'UPDATE', 'users', 1500, 'Updated user details: Name=hank, Email=hank@gmail.com, Role=Employee, Department=CASHIER DEPARTMENT', 1, '2025-04-08 01:03:30'),
(23, 'ASSIGN', 'tickets', 1, 'Assigned ticket ID 1 to user ID 1500 with priority High.', 1, '2025-04-08 01:04:31'),
(24, 'UPDATE', 'tickets', 1, 'Updated ticket ID 1 status to In Progress.', 1, '2025-04-08 01:04:39'),
(25, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-08 01:05:04'),
(26, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-08 07:05:19'),
(27, 'CONFIRM', 'tickets', 1, 'Confirmed ticket ID 1 and updated status to \"In Progress\".', 1500, '2025-04-08 01:05:34'),
(28, 'DECLINE', 'tickets', 1, 'Declined ticket ID 1 and removed assignment.', 1500, '2025-04-08 01:05:53'),
(29, 'DECLINE', 'tickets', 8, 'Declined ticket ID 8 and removed assignment.', 1500, '2025-04-08 01:09:12'),
(30, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-08 01:09:50'),
(31, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-08 07:09:56'),
(32, 'UPDATE', 'tickets', 1, 'Updated ticket ID 1 status to Open.', 1, '2025-04-08 01:11:05'),
(33, 'UPDATE', 'tickets', 10, 'Updated ticket ID 10 status to Open.', 1, '2025-04-08 01:11:40'),
(34, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-08 07:17:02'),
(35, 'ASSIGN', 'tickets', 1, 'Assigned ticket ID 1 to user ID 2 with priority High.', 1, '2025-04-08 01:17:24'),
(36, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-08 01:36:02'),
(37, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-08 07:37:25'),
(38, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-08 01:38:22'),
(39, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-08 07:38:38'),
(40, 'DECLINE', 'tickets', 1, 'Declined ticket ID 1 and removed assignment.', 2, '2025-04-08 01:39:28'),
(41, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-08 14:56:04'),
(42, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-09 03:26:12'),
(43, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-08 21:38:20'),
(44, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-09 03:39:48'),
(45, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-08 21:40:11'),
(46, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-09 03:40:26'),
(47, 'DECLINE', 'tickets', 9, 'Declined ticket ID 9 and removed assignment.', 1500, '2025-04-08 21:41:32'),
(48, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-09 04:51:59'),
(49, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-08 22:52:59'),
(50, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-09 04:53:28'),
(51, 'DISABLE', 'users', 1201, 'Disabled account with ID 1201.', 1, '2025-04-08 22:59:49'),
(52, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-08 23:06:12'),
(53, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-09 05:06:32'),
(54, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-08 23:06:48'),
(55, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-09 05:07:07'),
(56, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-08 23:07:53'),
(57, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-09 05:08:07'),
(58, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-08 23:08:19'),
(59, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-09 05:08:34'),
(60, 'DISABLE', 'users', 5, 'Disabled account with ID 5.', 1, '2025-04-09 00:30:46'),
(61, 'ENABLE', 'users', 5, 'Enabled account with ID 5.', 1, '2025-04-09 00:41:10'),
(62, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-09 09:12:10'),
(63, 'DISABLE', 'users', 5, 'Disabled account with ID 5.', 1, '2025-04-09 03:15:52'),
(64, 'DISABLE', 'users', 5, 'Disabled account with ID 5.', 1, '2025-04-09 03:29:07'),
(65, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-09 03:44:23'),
(66, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-09 09:45:15'),
(67, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-09 03:57:50'),
(68, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-09 09:58:00'),
(69, 'CREATE', 'tickets', 19, 'Created ticket: Subject=asampel as asdia, Category=2, Description=ajkdashdlkajd', 2, '2025-04-09 04:10:30'),
(70, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-09 10:18:33'),
(71, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-09 04:23:45'),
(72, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-09 10:23:50'),
(73, 'ENABLE', 'users', 5, 'Enabled account with ID 5.', 1, '2025-04-09 04:56:50'),
(74, 'DISABLE', 'users', 5, 'Disabled account with ID 5.', 1, '2025-04-09 04:56:59'),
(75, 'UPDATE', 'users', 1, 'Updated user details: Name=John Mico D. Intacto, Email=mico@gmail.com, Role=Admin, Department=MIS/IT DEPARTMENT', 1, '2025-04-09 08:14:27'),
(76, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-09 08:16:47'),
(77, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-09 14:16:57'),
(78, 'INSERT', 'ticket_responses', 15, 'Added response to ticket ID 9: hadadasd', 1500, '2025-04-09 08:17:26'),
(79, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-09 08:25:05'),
(80, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-09 14:26:20'),
(81, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-09 08:26:35'),
(82, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-09 14:26:38'),
(83, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-10 00:47:00'),
(84, 'ENABLE', 'users', 1201, 'Enabled account with ID 1201.', 1, '2025-04-09 18:54:26'),
(85, 'UPDATE', 'users', 1201, 'Updated user details: Name=Charity Lizardo, Email=cha@gmail.com, Role=HR Rep, Department=H DEPARTMENT', 1, '2025-04-09 18:55:09'),
(86, 'UPDATE', 'users', 1201, 'Updated user details: Name=Charity Lizardo, Email=cha@gmail.com, Role=HR Rep, Department=H DEPARTMENT', 1, '2025-04-09 18:55:20'),
(87, 'UPDATE', 'users', 1234, 'Updated user details: Name=Bonet, Email=bonet@gmail.com, Role=Employee, Department=PHARMACY DEPARTMENT', 1, '2025-04-09 18:55:35'),
(88, 'DISABLE', 'users', 1234, 'Disabled account with ID 1234.', 1, '2025-04-09 18:55:45'),
(89, 'UPDATE', 'users', 1201, 'Updated user details: Name=Charity Lizardo, Email=cha@gmail.com, Role=HR Rep, Department=EYE CENTER DEPARTMENT', 1, '2025-04-09 18:58:46'),
(90, 'DISABLE', 'users', 6, 'Disabled account with ID 6.', 1, '2025-04-09 18:59:01'),
(91, 'ENABLE', 'users', 5, 'Enabled account with ID 5.', 1, '2025-04-09 18:59:49'),
(92, 'DISABLE', 'users', 5, 'Disabled account with ID 5.', 1, '2025-04-09 18:59:56'),
(93, 'DISABLE', 'users', 7, 'Disabled account with ID 7.', 1, '2025-04-09 19:00:09'),
(94, 'ENABLE', 'users', 5, 'Enabled account with ID 5.', 1, '2025-04-09 19:02:25'),
(95, 'CREATE', 'tickets', 20, 'Created ticket: Subject=adadaa, Category=8, Description=adjadasda', 1, '2025-04-09 19:15:43'),
(96, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-10 02:38:54'),
(97, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-09 21:14:41'),
(98, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-10 03:14:52'),
(99, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-09 21:15:25'),
(100, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-10 03:15:29'),
(101, 'ENABLE', 'users', 6, 'Enabled account with ID 6.', 1, '2025-04-09 21:16:28'),
(102, 'ENABLE', 'users', 7, 'Enabled account with ID 7.', 1, '2025-04-09 21:16:37'),
(103, 'ENABLE', 'users', 1234, 'Enabled account with ID 1234.', 1, '2025-04-09 21:16:50'),
(104, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-09 21:18:33'),
(105, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-10 03:18:40'),
(106, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-09 21:20:49'),
(107, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-10 03:20:54'),
(108, 'DISABLE', 'users', 5, 'Disabled account with ID 5.', 1, '2025-04-09 21:21:16'),
(109, 'ENABLE', 'users', 5, 'Enabled account with ID 5.', 1, '2025-04-09 21:21:32'),
(110, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-09 21:21:45'),
(111, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-10 03:21:54'),
(112, 'CREATE', 'tickets', 21, 'Created ticket: Subject=ADASDASDAS, Category=8, Description=ASDASDADS', 1500, '2025-04-09 21:33:14'),
(113, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-10 03:39:54'),
(114, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-09 21:39:57'),
(115, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-10 03:40:06'),
(116, 'CREATE', 'tickets', 22, 'Created ticket: Subject=asdasdaa, Category=10, Description=sdasasd', 1500, '2025-04-09 21:43:19'),
(117, 'CREATE', 'tickets', 23, 'Created ticket: Subject=aggagaagaga, Category=6, Description=asdjkujahsdsadadas', 1500, '2025-04-09 21:47:12'),
(118, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-09 21:54:18'),
(119, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-10 03:54:22'),
(120, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-09 21:55:12'),
(121, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-10 03:55:23'),
(122, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-09 21:55:40'),
(123, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-10 03:55:50'),
(124, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-09 21:56:50'),
(125, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-10 03:57:08'),
(126, 'CREATE', 'tickets', 24, 'Created ticket: Subject=tang ina mo monde, Category=7, Description=tang ina mo mico', 1500, '2025-04-09 21:59:22'),
(127, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-10 05:34:26'),
(128, 'INSERT', 'ticket_responses', 16, 'Added response to ticket ID 19: ashjklashjsdajkl', 2, '2025-04-15 00:00:48'),
(129, 'INSERT', 'ticket_responses', 17, 'Added response to ticket ID 19: asdasd', 2, '2025-04-15 00:02:42'),
(130, 'INSERT', 'ticket_responses', 18, 'Added response to ticket ID 19: asjklasjashjklsadklhjadsklj asldak asd d12310-319312', 2, '2025-04-15 00:02:50'),
(131, 'INSERT', 'attachments', 5, 'Added attachment to ticket ID 19: assets/uploads/u643738716_mnmch_hrts_db.sql', 2, '2025-04-15 00:06:24'),
(132, 'INSERT', 'ticket_responses', 19, 'Added response to ticket ID 19: u643738716_mnmch_hrts_db.sql', 2, '2025-04-15 00:06:24'),
(133, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-15 00:06:35'),
(134, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-15 06:06:46'),
(135, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-15 06:08:00'),
(136, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-15 00:09:31'),
(137, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 06:09:40'),
(138, 'CREATE', 'tickets', 25, 'Created ticket: Subject=Testing 123, Category=6, Description=asjkasjkasjkasdjklasdads', 2, '2025-04-15 00:10:16'),
(139, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-15 00:10:22'),
(140, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-15 06:10:27'),
(141, 'ASSIGN', 'tickets', 25, 'Assigned ticket ID 25 to user ID 1500 with priority Low.', 1, '2025-04-15 00:10:54'),
(142, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-15 00:11:02'),
(143, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-15 06:11:10'),
(144, 'CONFIRM', 'tickets', 25, 'Confirmed ticket ID 25 and updated status to \"In Progress\".', 1500, '2025-04-15 00:11:44'),
(145, 'INSERT', 'ticket_responses', 20, 'Added response to ticket ID 25: Hello tesing 123', 1500, '2025-04-15 00:12:07'),
(146, 'INSERT', 'attachments', 6, 'Added attachment to ticket ID 25: assets/uploads/mnmch_hrts_db.sql', 1500, '2025-04-15 00:12:14'),
(147, 'INSERT', 'ticket_responses', 21, 'Added response to ticket ID 25: mnmch_hrts_db.sql', 1500, '2025-04-15 00:12:14'),
(148, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-15 00:12:18'),
(149, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 06:12:33'),
(150, 'INSERT', 'ticket_responses', 22, 'Added response to ticket ID 25: jklasjasdjklasd', 2, '2025-04-15 00:13:00'),
(151, 'INSERT', 'attachments', 7, 'Added attachment to ticket ID 25: assets/uploads/mnmch_hrts_db.sql', 2, '2025-04-15 00:13:09'),
(152, 'INSERT', 'ticket_responses', 23, 'Added response to ticket ID 25: mnmch_hrts_db.sql', 2, '2025-04-15 00:13:09'),
(153, 'INSERT', 'attachments', 8, 'Added attachment to ticket ID 25: assets/uploads/DOMINGO EARL GERALD (66).JPG', 2, '2025-04-15 00:13:49'),
(154, 'INSERT', 'ticket_responses', 24, 'Added response to ticket ID 25: DOMINGO EARL GERALD (66).JPG', 2, '2025-04-15 00:13:49'),
(155, 'CREATE', 'tickets', 26, 'Created ticket: Subject=Bur, Category=2, Description=ashjashjashjahjasdhjasdhjkashjkasjkdh ada', 2, '2025-04-15 00:14:29'),
(156, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-15 00:14:32'),
(157, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-15 06:14:36'),
(158, 'ASSIGN', 'tickets', 26, 'Assigned ticket ID 26 to user ID 1 with priority Low.', 1, '2025-04-15 00:15:07'),
(159, 'INSERT', 'ticket_responses', 25, 'Added response to ticket ID 26: dasadsasddasdas', 1, '2025-04-15 00:16:37'),
(160, 'INSERT', 'ticket_responses', 26, 'Added response to ticket ID 26: DOMINGO EARL GERALD 073.jpg', 1, '2025-04-15 00:16:48'),
(161, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-15 06:40:09'),
(162, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 06:58:03'),
(163, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-15 01:02:41'),
(164, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 07:04:18'),
(165, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 07:12:50'),
(166, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 07:13:18'),
(167, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-15 07:14:29'),
(168, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-15 01:15:30'),
(169, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 07:16:09'),
(170, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 07:16:40'),
(171, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 07:19:13'),
(172, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 07:19:48'),
(173, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 07:20:13'),
(174, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-15 07:51:34'),
(175, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-15 08:23:52'),
(176, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-15 02:23:56'),
(177, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-15 08:24:05'),
(178, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-15 02:26:50'),
(179, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-15 08:27:00'),
(180, 'UPDATE', 'tickets', 25, 'Updated ticket ID 25 status to Resolved.', 1500, '2025-04-15 02:27:19'),
(181, 'UPDATE', 'tickets', 25, 'Updated ticket ID 25 status to Resolved.', 1500, '2025-04-15 02:27:19'),
(182, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-15 02:34:32'),
(183, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-15 08:34:38'),
(184, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-15 13:51:34'),
(185, 'ASSIGN', 'tickets', 26, 'Assigned ticket ID 26 to user ID 1500 with priority Low.', 1, '2025-04-15 08:13:41'),
(186, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-15 08:13:54'),
(187, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-15 14:14:02'),
(188, 'CONFIRM', 'tickets', 26, 'Confirmed ticket ID 26 and updated status to \"In Progress\".', 1500, '2025-04-15 08:14:10'),
(189, 'UPDATE', 'tickets', 26, 'Updated ticket ID 26 status to Resolved.', 1500, '2025-04-15 08:15:18'),
(190, 'UPDATE', 'tickets', 26, 'Updated ticket ID 26 status to Resolved.', 1500, '2025-04-15 08:15:18'),
(191, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-16 07:47:13'),
(192, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-16 13:54:27'),
(193, 'ASSIGN', 'tickets', 24, 'Assigned ticket ID 24 to user ID 1 with priority Low.', 1, '2025-04-16 08:00:39'),
(194, 'CONFIRM', 'tickets', 24, 'Confirmed ticket ID 24 and updated status to \"In Progress\".', 1, '2025-04-16 08:31:01'),
(195, 'UPDATE', 'tickets', 24, 'Updated ticket ID 24 status to Resolved.', 1, '2025-04-16 08:31:33'),
(196, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-16 14:56:08'),
(197, 'ASSIGN', 'tickets', 23, 'Assigned ticket ID 23 to user ID 1 with priority Low.', 1, '2025-04-16 09:00:56'),
(198, 'CONFIRM', 'tickets', 23, 'Confirmed ticket ID 23 and updated status to \"In Progress\".', 1, '2025-04-16 09:01:27'),
(199, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-16 09:09:06'),
(200, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-16 15:09:22'),
(201, 'INSERT', 'ticket_responses', 27, 'Added response to ticket ID 23: tangina asdfasd', 1500, '2025-04-16 09:10:01'),
(202, 'INSERT', 'ticket_responses', 28, 'Added response to ticket ID 23: asasdasd', 1500, '2025-04-16 09:10:03'),
(203, 'INSERT', 'attachments', 11, 'Added attachment to ticket ID 23: assets/uploads/DOMINGO EARL GERALD 073.jpg', 1500, '2025-04-16 09:10:21'),
(204, 'INSERT', 'ticket_responses', 29, 'Added response to ticket ID 23: DOMINGO EARL GERALD 073.jpg', 1500, '2025-04-16 09:10:22'),
(205, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-16 09:10:27'),
(206, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-16 15:10:32'),
(207, 'INSERT', 'ticket_responses', 30, 'Added response to ticket ID 23: asjnklasjasdsa', 1, '2025-04-16 09:10:45'),
(208, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-17 12:42:04'),
(209, 'INSERT', 'ticket_responses', 31, 'Added response to ticket ID 23: sdasdda', 1, '2025-04-17 06:42:21'),
(210, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-17 06:53:45'),
(211, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-17 12:53:54'),
(212, 'INSERT', 'attachments', 15, 'Added attachment to ticket ID 24: assets/uploads/cor-bascRvJpVp3r5D.pdf', 1500, '2025-04-17 06:54:09'),
(213, 'INSERT', 'attachments', 16, 'Added attachment to ticket ID 23: assets/uploads/2-243-01_Internship-Journal.docx', 1500, '2025-04-17 06:54:57'),
(214, 'INSERT', 'ticket_responses', 32, 'Added response to ticket ID 23: 2-243-01_Internship-Journal.docx', 1500, '2025-04-17 06:54:57'),
(215, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-17 06:55:24'),
(216, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-17 12:55:31'),
(217, 'INSERT', 'ticket_responses', 33, 'Added response to ticket ID 23: asdilasddas', 1, '2025-04-17 06:58:10'),
(218, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-17 06:58:18'),
(219, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-17 12:58:30'),
(220, 'CREATE', 'tickets', 27, 'Created ticket: Subject=Tst april 17, Category=7, Description=tesing 123', 2, '2025-04-17 07:00:01'),
(221, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-17 07:00:19'),
(222, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-17 13:00:22'),
(223, 'ASSIGN', 'tickets', 27, 'Assigned ticket ID 27 to user ID 1 with priority High.', 1, '2025-04-17 07:00:51'),
(224, 'CONFIRM', 'tickets', 27, 'Confirmed ticket ID 27 and updated status to \"In Progress\".', 1, '2025-04-17 07:01:02'),
(225, 'INSERT', 'ticket_responses', 34, 'Added response to ticket ID 27: asdasasdsa', 1, '2025-04-17 07:01:18'),
(226, 'INSERT', 'attachments', 17, 'Added attachment to ticket ID 27: assets/uploads/cor-bascRvJpVp3r5D.pdf', 1, '2025-04-17 07:01:27'),
(227, 'INSERT', 'attachments', 18, 'Added attachment to ticket ID 27: assets/uploads/cor-bascRvJpVp3r5D.pdf', 1, '2025-04-17 07:01:58'),
(228, 'INSERT', 'ticket_responses', 35, 'Added response to ticket ID 27: asaasdasds', 1, '2025-04-17 07:06:11'),
(229, 'INSERT', 'ticket_responses', 43, 'Added response to ticket ID 27: wallpaper 1.jpg', 1, '2025-04-17 07:31:57'),
(230, 'INSERT', 'ticket_responses', 45, 'Added response to ticket ID 27: asdjlasdasdasd', 1, '2025-04-17 07:32:10'),
(231, 'INSERT', 'ticket_responses', 47, 'Added response to ticket ID 27: asasdadaads', 1, '2025-04-17 07:32:11'),
(232, 'INSERT', 'ticket_responses', 49, 'Added response to ticket ID 27: e-sign.psd', 1, '2025-04-17 07:32:19'),
(233, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-18 19:03:55'),
(234, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-18 13:04:22'),
(235, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-18 19:04:39'),
(236, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-18 13:04:52'),
(237, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-18 19:05:06'),
(238, 'CREATE', 'tickets', 28, 'Created ticket: Subject=sample 305, Category=1, Description=testing 123', 2, '2025-04-18 13:05:35'),
(239, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-18 13:06:14'),
(240, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-18 19:06:17'),
(241, 'ASSIGN', 'tickets', 28, 'Assigned ticket ID 28 to user ID 1 with priority Low.', 1, '2025-04-18 13:06:28'),
(242, 'CONFIRM', 'tickets', 28, 'Confirmed ticket ID 28 and updated status to \"In Progress\".', 1, '2025-04-18 13:06:34'),
(243, 'INSERT', 'ticket_responses', 50, 'Added response to ticket ID 28: Testing 123', 1, '2025-04-18 13:07:01'),
(244, 'INSERT', 'ticket_responses', 52, 'Added response to ticket ID 28: cor-bascRvJpVp3r5D.pdf', 1, '2025-04-18 13:09:56'),
(245, 'INSERT', 'ticket_responses', 54, 'Added response to ticket ID 28: SHARP F&B ADMIN_20250410_045959.pdf', 1, '2025-04-18 13:10:20'),
(246, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-18 13:14:12'),
(247, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-18 19:14:22'),
(248, 'INSERT', 'ticket_responses', 55, 'Added response to ticket ID 28: Tsting 123', 2, '2025-04-18 13:14:39'),
(249, 'INSERT', 'attachments', 34, 'Added attachment to ticket ID 28: assets/uploads/2-243-01_Internship-Journal.docx', 2, '2025-04-18 13:14:48'),
(250, 'INSERT', 'ticket_responses', 56, 'Added response to ticket ID 28: 2-243-01_Internship-Journal.docx', 2, '2025-04-18 13:14:48'),
(251, 'INSERT', 'attachments', 35, 'Added attachment to ticket ID 28: assets/uploads/DOMINGO EARL GERALD (66).JPG', 2, '2025-04-18 13:16:03'),
(252, 'INSERT', 'ticket_responses', 57, 'Added response to ticket ID 28: DOMINGO EARL GERALD (66).JPG', 2, '2025-04-18 13:16:03'),
(253, 'INSERT', 'attachments', 36, 'Added attachment to ticket ID 28: assets/uploads/DOMINGO EARL GERALD 073.jpg', 2, '2025-04-18 13:16:20'),
(254, 'INSERT', 'ticket_responses', 58, 'Added response to ticket ID 28: DOMINGO EARL GERALD 073.jpg', 2, '2025-04-18 13:16:21'),
(255, 'INSERT', 'attachments', 37, 'Added attachment to ticket ID 28: assets/uploads/DOMINGO EARL GERALD 073.jpg', 2, '2025-04-18 13:16:23'),
(256, 'INSERT', 'ticket_responses', 59, 'Added response to ticket ID 28: DOMINGO EARL GERALD 073.jpg', 2, '2025-04-18 13:16:23'),
(257, 'INSERT', 'attachments', 38, 'Added attachment to ticket ID 28: assets/uploads/DOMINGO EARL GERALD 073.jpg', 2, '2025-04-18 13:16:24'),
(258, 'INSERT', 'ticket_responses', 60, 'Added response to ticket ID 28: DOMINGO EARL GERALD 073.jpg', 2, '2025-04-18 13:16:24'),
(259, 'INSERT', 'ticket_responses', 61, 'Added response to ticket ID 28: dadaikldasjklasjklajklas', 2, '2025-04-18 13:21:21'),
(260, 'INSERT', 'ticket_responses', 62, 'Added response to ticket ID 28: Tesing 1231212312', 2, '2025-04-18 13:21:38'),
(261, 'INSERT', 'ticket_responses', 63, 'Added response to ticket ID 28: asdhjkadshjahjads', 2, '2025-04-18 13:22:38'),
(262, 'INSERT', 'ticket_responses', 64, 'Added response to ticket ID 28: TEsting asqasdasd ad ad a', 2, '2025-04-18 13:22:45'),
(263, 'INSERT', 'attachments', 39, 'Added attachment to ticket ID 28: assets/uploads/DOMINGO EARL GERALD 073.jpg', 2, '2025-04-18 13:23:01'),
(264, 'INSERT', 'ticket_responses', 65, 'Added response to ticket ID 28: DOMINGO EARL GERALD 073.jpg', 2, '2025-04-18 13:23:01'),
(265, 'INSERT', 'attachments', 40, 'Added attachment to ticket ID 28: assets/uploads/wallpaper 1.jpg', 2, '2025-04-18 13:23:20'),
(266, 'INSERT', 'ticket_responses', 66, 'Added response to ticket ID 28: wallpaper 1.jpg', 2, '2025-04-18 13:23:20'),
(267, 'INSERT', 'ticket_responses', 67, 'Added response to ticket ID 18: jygjgkhljh;', 2, '2025-04-18 13:34:28'),
(268, 'INSERT', 'ticket_responses', 68, 'Added response to ticket ID 26: ghfgfghfghfhgfghfghj', 2, '2025-04-18 13:34:40'),
(269, 'INSERT', 'ticket_responses', 69, 'Added response to ticket ID 26: ghdhgfjh,ghgdhjgf kjygfil cugo', 2, '2025-04-18 13:34:43'),
(270, 'INSERT', 'ticket_responses', 70, 'Added response to ticket ID 26: hjgf jygf iujtg ikuhyilou. ylo;yo8t', 2, '2025-04-18 13:34:45'),
(271, 'INSERT', 'ticket_responses', 71, 'Added response to ticket ID 26: hngfjk ,yg lkug klu gh klu,jkh hk. hikl', 2, '2025-04-18 13:34:48'),
(272, 'INSERT', 'ticket_responses', 72, 'Added response to ticket ID 26: g kjug kjlgu kliugkl hg', 2, '2025-04-18 13:34:50'),
(273, 'INSERT', 'attachments', 41, 'Added attachment to ticket ID 26: assets/uploads/DOMINGO EARL GERALD (66).JPG', 2, '2025-04-18 13:35:43'),
(274, 'INSERT', 'ticket_responses', 73, 'Added response to ticket ID 26: DOMINGO EARL GERALD (66).JPG', 2, '2025-04-18 13:35:43'),
(275, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-18 13:35:54'),
(276, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-18 19:36:18'),
(277, 'INSERT', 'ticket_responses', 74, 'Added response to ticket ID 26: adiouadsdlodasa', 1500, '2025-04-18 20:58:49'),
(278, 'INSERT', 'attachments', 42, 'Added attachment to ticket ID 26: assets/uploads/2-243-01_Internship-Journal.docx', 1500, '2025-04-18 20:59:05'),
(279, 'INSERT', 'ticket_responses', 75, 'Added response to ticket ID 26: 2-243-01_Internship-Journal.docx', 1500, '2025-04-18 20:59:05'),
(280, 'INSERT', 'attachments', 43, 'Added attachment to ticket ID 26: assets/uploads/2-243-01_Internship-Journal.docx', 1500, '2025-04-18 20:59:16'),
(281, 'INSERT', 'ticket_responses', 76, 'Added response to ticket ID 26: i asdaa', 1500, '2025-04-18 20:59:16'),
(282, 'INSERT', 'ticket_responses', 77, 'Added response to ticket ID 26: osssjksksks kjasc sad asd asdas da sd', 1500, '2025-04-18 20:59:33'),
(283, 'INSERT', 'ticket_responses', 78, 'Added response to ticket ID 26: asiouasnjklasdjklhasd ajkl;sd asdjkl;a s', 1500, '2025-04-18 20:59:44'),
(284, 'INSERT', 'attachments', 44, 'Added attachment to ticket ID 26: assets/uploads/cor-bascRvJpVp3r5D.pdf', 1500, '2025-04-18 20:59:57'),
(285, 'INSERT', 'ticket_responses', 79, 'Added response to ticket ID 26: cor-bascRvJpVp3r5D.pdf', 1500, '2025-04-18 20:59:57'),
(286, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-18 21:00:28'),
(287, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-19 03:01:04'),
(288, 'INSERT', 'attachments', 45, 'Added attachment to ticket ID 26: assets/uploads/cor-bascRvJpVp3r5D.pdf', 2, '2025-04-18 21:01:37'),
(289, 'INSERT', 'ticket_responses', 80, 'Added response to ticket ID 26: cor-bascRvJpVp3r5D.pdf', 2, '2025-04-18 21:01:37'),
(290, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-18 21:02:33'),
(291, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-19 03:02:37'),
(292, 'UPDATE', 'users', 1500, 'Updated user details: Name=hank, Email=hank@gmail.com, Role=HR Rep, Department=HR DEPARTMENT', 1, '2025-04-18 21:03:21'),
(293, 'UPDATE', 'users', 1500, 'Updated user details: Name=hank, Email=hank@gmail.com, Role=HR Rep, Department=HR DEPARTMENT', 1, '2025-04-18 21:03:39'),
(294, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-18 21:04:50'),
(295, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-19 03:04:59'),
(296, 'INSERT', 'ticket_responses', 81, 'Added response to ticket ID 26: TAe', 1500, '2025-04-18 21:05:22'),
(297, 'INSERT', 'attachments', 46, 'Added attachment to ticket ID 26: assets/uploads/wallpaper ae86 gif.gif', 1500, '2025-04-18 21:05:30'),
(298, 'INSERT', 'ticket_responses', 82, 'Added response to ticket ID 26: wallpaper ae86 gif.gif', 1500, '2025-04-18 21:05:30'),
(299, 'INSERT', 'attachments', 47, 'Added attachment to ticket ID 26: assets/uploads/cor-bascRvJpVp3r5D.pdf', 1500, '2025-04-18 21:15:24'),
(300, 'INSERT', 'ticket_responses', 83, 'Added response to ticket ID 26: cor-bascRvJpVp3r5D.pdf', 1500, '2025-04-18 21:15:24'),
(301, 'INSERT', 'attachments', 48, 'Added attachment to ticket ID 26: assets/uploads/SHARP F&B ADMIN_20250410_045959.pdf', 1500, '2025-04-18 21:24:20'),
(302, 'INSERT', 'ticket_responses', 84, 'Added response to ticket ID 26: SHARP F&B ADMIN_20250410_045959.pdf', 1500, '2025-04-18 21:24:20'),
(303, 'INSERT', 'attachments', 49, 'Added attachment to ticket ID 26: assets/uploads/DOMINGO EARL GERALD 073.jpg', 1500, '2025-04-18 21:27:49'),
(304, 'INSERT', 'ticket_responses', 85, 'Added response to ticket ID 26: DOMINGO EARL GERALD 073.jpg', 1500, '2025-04-18 21:27:49'),
(305, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-18 21:29:48'),
(306, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-19 03:29:57'),
(307, 'INSERT', 'attachments', 50, 'Added attachment to ticket ID 26: assets/uploads/Ae86 static wallpaper.jpg', 2, '2025-04-18 21:30:52'),
(308, 'INSERT', 'ticket_responses', 86, 'Added response to ticket ID 26: Ae86 static wallpaper.jpg', 2, '2025-04-18 21:30:52'),
(309, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-19 03:48:01'),
(310, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-19 00:00:54'),
(311, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-19 06:01:10'),
(312, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-19 00:03:25'),
(313, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-19 06:03:32'),
(314, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-19 00:20:06'),
(315, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-19 06:20:09'),
(316, 'UPDATE', 'tickets', 23, 'Updated ticket ID 23 status to Resolved.', 1, '2025-04-19 00:20:22'),
(317, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-19 00:20:28'),
(318, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-19 06:20:36'),
(319, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-19 00:30:32'),
(320, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-19 06:30:52'),
(321, 'CREATE', 'tickets', 29, 'Created ticket: Subject=Testing 123 230pm, Category=4, Description=230pm', 2, '2025-04-19 00:31:18'),
(322, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-19 00:31:23'),
(323, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-19 06:31:26'),
(324, 'ASSIGN', 'tickets', 29, 'Assigned ticket ID 29 to user ID 1500 with priority Low.', 1, '2025-04-19 00:31:41'),
(325, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-19 00:31:47'),
(326, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-19 06:31:54'),
(327, 'CONFIRM', 'tickets', 29, 'Confirmed ticket ID 29 and updated status to \"In Progress\".', 1500, '2025-04-19 00:32:07'),
(328, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-19 06:58:38'),
(329, 'UPDATE', 'tickets', 29, 'Updated ticket ID 29 status to Resolved.', 1500, '2025-04-19 01:01:55'),
(330, 'UPDATE', 'tickets', 29, 'Updated ticket ID 29 status to Resolved.', 1500, '2025-04-19 01:01:55'),
(331, 'UPDATE', 'tickets', 29, 'Updated ticket ID 29 status to Resolved.', 1500, '2025-04-19 01:01:55'),
(332, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-19 01:08:04'),
(333, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-19 07:08:15'),
(334, 'CREATE', 'tickets', 30, 'Created ticket: Subject=ahiouasdhiuahiashiadshiloasd, Category=5, Description=ahjklasjhd asd opasduas iljousd a ijlo;d', 2, '2025-04-19 01:11:14'),
(335, 'CREATE', 'tickets', 31, 'Created ticket: Subject=as dkl;jasd jk;a jkl;as jkl;a jkla jklsdklhj; sdjkl;fijopas opuaopu nanopudnopu as pundosaunopd saopun, Category=1, Description=asdoip as l;oa slo;jask aop;j\'l a o;jpas ao;k', 2, '2025-04-19 01:11:35'),
(336, 'CREATE', 'tickets', 32, 'Created ticket: Subject=d jopasdajo ;d asd, Category=2, Description=asdiopuas daiop udsasopu asdas', 2, '2025-04-19 01:11:50'),
(337, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 04:24:44'),
(338, 'ASSIGN', 'tickets', 32, 'Assigned ticket ID 32 to user ID 1 with priority Low.', 1, '2025-04-20 22:25:47'),
(339, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-20 22:26:03'),
(340, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-21 04:26:12'),
(341, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-20 22:26:49'),
(342, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-21 04:26:56'),
(343, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-21 08:57:31'),
(344, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-21 03:01:52'),
(345, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 09:01:54'),
(346, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 03:02:14'),
(347, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-21 09:02:30'),
(348, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-21 03:08:00'),
(349, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 09:08:05'),
(350, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 09:57:37'),
(351, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 04:23:54'),
(352, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-21 10:24:04'),
(353, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-21 04:27:52'),
(354, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 10:27:55'),
(355, 'UPDATE', 'tickets', 28, 'Updated ticket ID 28 status to Resolved.', 1, '2025-04-21 04:34:23'),
(356, 'UPDATE', 'tickets', 27, 'Updated ticket ID 27 status to Resolved.', 1, '2025-04-21 04:43:48'),
(357, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 11:00:27'),
(358, 'CONFIRM', 'tickets', 32, 'Confirmed ticket ID 32 and updated status to \"In Progress\".', 1, '2025-04-21 05:00:39'),
(359, 'UPDATE', 'tickets', 32, 'Updated ticket ID 32 status to Resolved.', 1, '2025-04-21 05:00:50'),
(360, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 05:03:01'),
(361, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-21 11:03:09'),
(362, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 12:15:11'),
(363, 'CREATE', 'tickets', 33, 'Created ticket: Subject=Sample 123 april 21, Category=1, Description=Testing12313123', 1, '2025-04-21 06:20:38'),
(364, 'CREATE', 'tickets', 34, 'Created ticket: Subject=Testing @123, Category=5, Description=asdasdasdasd', 1, '2025-04-21 06:21:34'),
(365, 'CREATE', 'tickets', 35, 'Created ticket: Subject=Testing, Category=9, Description=asdakldasda', 1, '2025-04-21 06:23:31'),
(366, 'CREATE', 'tickets', 36, 'Created ticket: Subject=Testing 4, Category=5, Description=Testing 4', 1, '2025-04-21 06:27:21'),
(367, 'CREATE', 'tickets', 37, 'Created ticket: Subject=Test 5, Category=1, Description=Test5', 1, '2025-04-21 06:30:47'),
(368, 'CREATE', 'tickets', 38, 'Created ticket: Subject=Test 6, Category=8, Description=dsadd', 1, '2025-04-21 06:31:05'),
(369, 'CREATE', 'tickets', 39, 'Created ticket: Subject=tsest 7, Category=8, Description=Tresting', 1, '2025-04-21 06:33:36'),
(370, 'ASSIGN', 'tickets', 39, 'Assigned ticket ID 39 to user ID 2 with priority Low.', 1, '2025-04-21 06:37:51'),
(371, 'ASSIGN', 'tickets', 38, 'Assigned ticket ID 38 to user ID 1799 with priority Low.', 1, '2025-04-21 06:41:23'),
(372, 'ASSIGN', 'tickets', 37, 'Assigned ticket ID 37 to user ID 1500 with priority Low.', 1, '2025-04-21 06:46:23'),
(373, 'ASSIGN', 'tickets', 36, 'Assigned ticket ID 36 to user ID 6 with priority Low.', 1, '2025-04-21 06:49:04'),
(374, 'ASSIGN', 'tickets', 35, 'Assigned ticket ID 35 to user ID 10 with priority Low.', 1, '2025-04-21 06:50:53'),
(375, 'ASSIGN', 'tickets', 33, 'Assigned ticket ID 33 to user ID 8 with priority High.', 1, '2025-04-21 06:54:22'),
(376, 'ASSIGN', 'tickets', 34, 'Assigned ticket ID 34 to user ID 1730 with priority Low.', 1, '2025-04-21 07:03:15'),
(377, 'ASSIGN', 'tickets', 34, 'Assigned ticket ID 34 to user ID 1730 with priority High.', 1, '2025-04-21 07:03:42'),
(378, 'ASSIGN', 'tickets', 34, 'Assigned ticket ID 34 to user ID 1500 with priority Medium.', 1, '2025-04-21 07:04:33'),
(379, 'ASSIGN', 'tickets', 31, 'Assigned ticket ID 31 to user ID 8 with priority High.', 1, '2025-04-21 07:04:54'),
(380, 'ASSIGN', 'tickets', 30, 'Assigned ticket ID 30 to user ID 10 with priority Medium.', 1, '2025-04-21 07:13:02'),
(381, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 07:13:44'),
(382, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-21 13:13:53'),
(383, 'CONFIRM', 'tickets', 37, 'Confirmed ticket ID 37 and updated status to \"In Progress\".', 1500, '2025-04-21 07:14:25'),
(384, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-21 13:16:10'),
(385, 'CONFIRM', 'tickets', 34, 'Confirmed ticket ID 34 and updated status to \"In Progress\".', 1500, '2025-04-21 07:18:36'),
(386, 'UPDATE', 'tickets', 34, 'Updated ticket ID 34 status to Resolved.', 1500, '2025-04-21 07:18:52'),
(387, 'UPDATE', 'tickets', 34, 'Updated ticket ID 34 status to Resolved.', 1500, '2025-04-21 07:18:52'),
(388, 'UPDATE', 'tickets', 34, 'Updated ticket ID 34 status to Resolved.', 1500, '2025-04-21 07:18:52'),
(389, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-21 07:19:59'),
(390, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 13:20:04'),
(391, 'CREATE', 'tickets', 40, 'Created ticket: Subject=Tesdtasdas hank, Category=6, Description=asasdad aa', 1, '2025-04-21 07:20:24'),
(392, 'CREATE', 'tickets', 41, 'Created ticket: Subject=hank hank han k, Category=6, Description=adklajsdkljasdjklasd', 1, '2025-04-21 07:20:40'),
(393, 'CREATE', 'tickets', 42, 'Created ticket: Subject=asdmnkl;adskln,.dsahjkln/asd, Category=6, Description=sdkljasd asd sa', 1, '2025-04-21 07:20:56'),
(394, 'CREATE', 'tickets', 43, 'Created ticket: Subject=dasdadsadsadsasdas, Category=1, Description=asdsadasddas', 1, '2025-04-21 07:21:33'),
(395, 'ASSIGN', 'tickets', 43, 'Assigned ticket ID 43 to user ID 1500 with priority High.', 1, '2025-04-21 07:22:04'),
(396, 'ASSIGN', 'tickets', 42, 'Assigned ticket ID 42 to user ID 1500 with priority Low.', 1, '2025-04-21 07:22:22'),
(397, 'ASSIGN', 'tickets', 41, 'Assigned ticket ID 41 to user ID 1500 with priority Low.', 1, '2025-04-21 07:22:39'),
(398, 'ASSIGN', 'tickets', 40, 'Assigned ticket ID 40 to user ID 1500 with priority Low.', 1, '2025-04-21 07:22:48'),
(399, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 07:22:55'),
(400, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-21 13:23:04'),
(401, 'CONFIRM', 'tickets', 43, 'Confirmed ticket ID 43 and updated status to \"In Progress\".', 1500, '2025-04-21 07:23:12'),
(402, 'UPDATE', 'tickets', 43, 'Updated ticket ID 43 status to Resolved.', 1500, '2025-04-21 07:23:26'),
(403, 'UPDATE', 'tickets', 43, 'Updated ticket ID 43 status to Resolved.', 1500, '2025-04-21 07:23:26'),
(404, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-21 07:31:22'),
(405, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 13:31:25'),
(406, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 07:32:10'),
(407, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-21 13:32:17'),
(408, 'CONFIRM', 'tickets', 42, 'Confirmed ticket ID 42 and updated status to \"In Progress\".', 1500, '2025-04-21 07:32:28'),
(409, 'UPDATE', 'tickets', 42, 'Updated ticket ID 42 status to Resolved.', 1500, '2025-04-21 07:32:39'),
(410, 'UPDATE', 'tickets', 42, 'Updated ticket ID 42 status to Resolved.', 1500, '2025-04-21 07:32:39'),
(411, 'UPDATE', 'tickets', 42, 'Updated ticket ID 42 status to Resolved.', 1500, '2025-04-21 07:32:39'),
(412, 'CONFIRM', 'tickets', 41, 'Confirmed ticket ID 41 and updated status to \"In Progress\".', 1500, '2025-04-21 07:34:26'),
(413, 'UPDATE', 'tickets', 41, 'Updated ticket ID 41 status to Resolved.', 1500, '2025-04-21 07:34:37'),
(414, 'UPDATE', 'tickets', 41, 'Updated ticket ID 41 status to Resolved.', 1500, '2025-04-21 07:34:37'),
(415, 'UPDATE', 'tickets', 41, 'Updated ticket ID 41 status to Resolved.', 1500, '2025-04-21 07:34:37'),
(416, 'CONFIRM', 'tickets', 40, 'Confirmed ticket ID 40 and updated status to \"In Progress\".', 1500, '2025-04-21 07:35:29'),
(417, 'UPDATE', 'tickets', 40, 'Updated ticket ID 40 status to Resolved.', 1500, '2025-04-21 07:35:46'),
(418, 'UPDATE', 'tickets', 40, 'Updated ticket ID 40 status to Resolved.', 1500, '2025-04-21 07:35:46'),
(419, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-21 07:56:07'),
(420, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 13:56:11'),
(421, 'CREATE', 'tickets', 44, 'Created ticket: Subject=wiusksiwksio, Category=7, Description=asdasda ia iksa ias as', 1, '2025-04-21 08:08:09'),
(422, 'CREATE', 'tickets', 45, 'Created ticket: Subject=Tst 123, Category=1, Description=2sksmxiksmxik', 1, '2025-04-21 08:08:28'),
(423, 'CREATE', 'tickets', 46, 'Created ticket: Subject=Asda asdasd asda sds, Category=7, Description=sdldlksadklsdksd', 1, '2025-04-21 08:08:48'),
(424, 'CREATE', 'tickets', 47, 'Created ticket: Subject=asdkas askas ka jak d, Category=7, Description=asd asd adad', 1, '2025-04-21 08:09:01'),
(425, 'CREATE', 'tickets', 48, 'Created ticket: Subject=akdsa d;las ad, Category=4, Description=asd klasjdas da', 1, '2025-04-21 08:09:17'),
(426, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 14:16:11'),
(427, 'ASSIGN', 'tickets', 44, 'Assigned ticket ID 44 to user ID 1500 with priority Medium.', 1, '2025-04-21 08:24:17'),
(428, 'ASSIGN', 'tickets', 45, 'Assigned ticket ID 45 to user ID 1500 with priority High.', 1, '2025-04-21 08:27:01'),
(429, 'ASSIGN', 'tickets', 46, 'Assigned ticket ID 46 to user ID 10 with priority High.', 1, '2025-04-21 08:28:22'),
(430, 'ASSIGN', 'tickets', 47, 'Assigned ticket ID 47 to user hank (ID: 1500) with priority Medium.', 1, '2025-04-21 08:38:57'),
(431, 'ASSIGN', 'tickets', 48, 'Assigned ticket ID 48 to user hank (ID: 1500) with priority High.', 1, '2025-04-21 08:40:25'),
(432, 'CREATE', 'tickets', 49, 'Created ticket: Subject=adasdadas, Category=6, Description=asdsadsad', 1, '2025-04-21 08:41:28'),
(433, 'ASSIGN', 'tickets', 49, 'Assigned ticket ID 49 to user hank (ID: 1500) with priority High.', 1, '2025-04-21 08:43:29'),
(434, 'CREATE', 'tickets', 50, 'Created ticket: Subject=adadadaasdad, Category=7, Description=adadasdasddas', 1, '2025-04-21 08:44:20'),
(435, 'ASSIGN', 'tickets', 50, 'Assigned ticket ID 50 to user hank (ID: 1500) with priority Medium.', 1, '2025-04-21 08:44:33'),
(436, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 08:45:58'),
(437, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-21 14:46:25'),
(438, 'CREATE', 'tickets', 51, 'Created ticket: Subject=hank123, Category=5, Description=asdkl;jakjaadsasd', 2, '2025-04-21 08:46:42'),
(439, 'CREATE', 'tickets', 52, 'Created ticket: Subject=putang ina, Category=1, Description=aklasdk jad;as asda', 2, '2025-04-21 08:46:57'),
(440, 'CREATE', 'tickets', 53, 'Created ticket: Subject=dklnasasknasdk ad a, Category=9, Description=adsklsadj adsa d', 2, '2025-04-21 08:47:11'),
(441, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-21 08:47:15'),
(442, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 14:47:19'),
(443, 'ASSIGN', 'tickets', 51, 'Assigned ticket ID 51 to user John Mico D. Intacto (ID: 1) with priority High.', 1, '2025-04-21 08:47:48'),
(444, 'CONFIRM', 'tickets', 51, 'Confirmed ticket ID 51 and updated status to \"In Progress\".', 1, '2025-04-21 08:54:19'),
(445, 'ASSIGN', 'tickets', 52, 'Assigned ticket ID 52 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 08:58:56'),
(446, 'CONFIRM', 'tickets', 52, 'Confirmed ticket ID 52 and updated status to \"In Progress\".', 1, '2025-04-21 09:02:59'),
(447, 'ASSIGN', 'tickets', 53, 'Assigned ticket ID 53 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 09:08:07'),
(448, 'CONFIRM', 'tickets', 53, 'Confirmed ticket ID 53 and updated status to \"In Progress\".', 1, '2025-04-21 09:08:18'),
(449, 'UPDATE', 'tickets', 51, 'Updated ticket ID 51 status to Resolved.', 1, '2025-04-21 09:09:55'),
(450, 'UPDATE', 'tickets', 52, 'Updated ticket ID 52 status to Resolved.', 1, '2025-04-21 09:13:55'),
(451, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 15:19:58'),
(452, 'UPDATE', 'tickets', 53, 'Updated ticket ID 53 status to Resolved.', 1, '2025-04-21 09:20:11'),
(453, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 09:21:07'),
(454, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 15:21:42'),
(455, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 09:21:45'),
(456, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-21 15:22:09'),
(457, 'CREATE', 'tickets', 54, 'Created ticket: Subject=Sample 123 april 21, Category=8, Description=asmadasda', 2, '2025-04-21 09:22:45'),
(458, 'CREATE', 'tickets', 55, 'Created ticket: Subject=1, Category=6, Description=asdasjd  j j j j iu  opas', 2, '2025-04-21 09:23:00'),
(459, 'CREATE', 'tickets', 56, 'Created ticket: Subject=13456, Category=8, Description=testing 123', 2, '2025-04-21 09:23:11');
INSERT INTO `audit_trail` (`id`, `action_type`, `affected_table`, `affected_id`, `details`, `user_id`, `timestamp`) VALUES
(460, 'CREATE', 'tickets', 57, 'Created ticket: Subject=haktdo, Category=1, Description=testing 123', 2, '2025-04-21 09:23:23'),
(461, 'CREATE', 'tickets', 58, 'Created ticket: Subject=sample 305, Category=8, Description=testing 123', 2, '2025-04-21 09:23:33'),
(462, 'CREATE', 'tickets', 59, 'Created ticket: Subject=sample 305, Category=7, Description=testing 123', 2, '2025-04-21 09:23:45'),
(463, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-21 09:23:49'),
(464, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 15:23:52'),
(465, 'ASSIGN', 'tickets', 54, 'Assigned ticket ID 54 to user John Mico D. Intacto (ID: 1) with priority High.', 1, '2025-04-21 09:24:20'),
(466, 'CONFIRM', 'tickets', 54, 'Confirmed ticket ID 54 and updated status to \"In Progress\".', 1, '2025-04-21 09:24:29'),
(467, 'UPDATE', 'tickets', 54, 'Updated ticket ID 54 status to Resolved.', 1, '2025-04-21 09:24:53'),
(468, 'ASSIGN', 'tickets', 55, 'Assigned ticket ID 55 to user John Mico D. Intacto (ID: 1) with priority Medium.', 1, '2025-04-21 09:27:42'),
(469, 'CONFIRM', 'tickets', 55, 'Confirmed ticket ID 55 and updated status to \"In Progress\".', 1, '2025-04-21 09:28:29'),
(470, 'UPDATE', 'tickets', 55, 'Updated ticket ID 55 status to Resolved.', 1, '2025-04-21 09:30:12'),
(471, 'ASSIGN', 'tickets', 56, 'Assigned ticket ID 56 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 09:39:27'),
(472, 'CONFIRM', 'tickets', 56, 'Confirmed ticket ID 56 and updated status to \"In Progress\".', 1, '2025-04-21 09:39:33'),
(473, 'ASSIGN', 'tickets', 57, 'Assigned ticket ID 57 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 09:40:21'),
(474, 'CONFIRM', 'tickets', 57, 'Confirmed ticket ID 57 and updated status to \"In Progress\".', 1, '2025-04-21 09:41:32'),
(475, 'ASSIGN', 'tickets', 58, 'Assigned ticket ID 58 to user John Mico D. Intacto (ID: 1) with priority High.', 1, '2025-04-21 09:42:28'),
(476, 'CONFIRM', 'tickets', 58, 'Confirmed ticket ID 58 and updated status to \"In Progress\".', 1, '2025-04-21 09:42:36'),
(477, 'ASSIGN', 'tickets', 59, 'Assigned ticket ID 59 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 09:43:59'),
(478, 'CONFIRM', 'tickets', 59, 'Confirmed ticket ID 59 and updated status to \"In Progress\".', 1, '2025-04-21 09:44:06'),
(479, 'CREATE', 'tickets', 60, 'Created ticket: Subject=sdfdfdfsdsf, Category=6, Description=fddsfdfdf', 1, '2025-04-21 09:45:37'),
(480, 'ASSIGN', 'tickets', 60, 'Assigned ticket ID 60 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 09:45:50'),
(481, 'CONFIRM', 'tickets', 60, 'Confirmed ticket ID 60 and updated status to \"In Progress\".', 1, '2025-04-21 09:46:09'),
(482, 'CREATE', 'tickets', 61, 'Created ticket: Subject=asdas, Category=6, Description=sdasdad', 1, '2025-04-21 09:49:35'),
(483, 'ASSIGN', 'tickets', 61, 'Assigned ticket ID 61 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 09:49:47'),
(484, 'CONFIRM', 'tickets', 61, 'Confirmed ticket ID 61 and updated status to \"In Progress\".', 1, '2025-04-21 09:49:59'),
(485, 'CREATE', 'tickets', 62, 'Created ticket: Subject=asdad, Category=6, Description=asda', 1, '2025-04-21 09:53:42'),
(486, 'ASSIGN', 'tickets', 62, 'Assigned ticket ID 62 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 09:53:51'),
(487, 'CONFIRM', 'tickets', 62, 'Confirmed ticket ID 62 and updated status to \"In Progress\".', 1, '2025-04-21 09:54:03'),
(488, 'CREATE', 'tickets', 63, 'Created ticket: Subject=assadaa, Category=6, Description=sdsaddas', 1, '2025-04-21 10:04:10'),
(489, 'ASSIGN', 'tickets', 63, 'Assigned ticket ID 63 to user John Mico D. Intacto (ID: 1) with priority Medium.', 1, '2025-04-21 10:04:22'),
(490, 'CONFIRM', 'tickets', 63, 'Confirmed ticket ID 63 and updated status to \"In Progress\".', 1, '2025-04-21 10:04:32'),
(491, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-21 16:21:35'),
(492, 'CREATE', 'tickets', 64, 'Created ticket: Subject=SDSFSFS, Category=6, Description=SDFDSFDSDSF', 1, '2025-04-21 10:21:53'),
(493, 'ASSIGN', 'tickets', 64, 'Assigned ticket ID 64 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 10:22:10'),
(494, 'CONFIRM', 'tickets', 64, 'Confirmed ticket ID 64 and updated status to \"In Progress\".', 1, '2025-04-21 10:22:20'),
(495, 'CREATE', 'tickets', 65, 'Created ticket: Subject=ccgh, Category=7, Description=cfdf', 1, '2025-04-21 10:33:15'),
(496, 'ASSIGN', 'tickets', 65, 'Assigned ticket ID 65 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 10:33:26'),
(497, 'CONFIRM', 'tickets', 65, 'Confirmed ticket ID 65 and updated status to \"In Progress\".', 1, '2025-04-21 10:33:35'),
(498, 'UPDATE', 'tickets', 64, 'Updated ticket ID 64 status to Resolved.', 1, '2025-04-21 10:36:59'),
(499, 'CREATE', 'tickets', 66, 'Created ticket: Subject=aa, Category=6, Description=a', 1, '2025-04-21 10:40:23'),
(500, 'ASSIGN', 'tickets', 66, 'Assigned ticket ID 66 to user John Mico D. Intacto (ID: 1) with priority High.', 1, '2025-04-21 10:40:40'),
(501, 'CONFIRM', 'tickets', 66, 'Confirmed ticket ID 66 and updated status to \"In Progress\".', 1, '2025-04-21 10:40:50'),
(502, 'CREATE', 'tickets', 67, 'Created ticket: Subject=sadadasdsda, Category=6, Description=aaaa', 1, '2025-04-21 10:45:49'),
(503, 'ASSIGN', 'tickets', 67, 'Assigned ticket ID 67 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 10:46:02'),
(504, 'CONFIRM', 'tickets', 67, 'Confirmed ticket ID 67 and updated status to \"In Progress\".', 1, '2025-04-21 10:46:06'),
(505, 'CREATE', 'tickets', 68, 'Created ticket: Subject=asdaasa, Category=6, Description=sdsasadsad', 1, '2025-04-21 10:46:27'),
(506, 'ASSIGN', 'tickets', 68, 'Assigned ticket ID 68 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 10:47:09'),
(507, 'CONFIRM', 'tickets', 68, 'Confirmed ticket ID 68 and updated status to \"In Progress\".', 1, '2025-04-21 10:47:15'),
(508, 'CREATE', 'tickets', 69, 'Created ticket: Subject=bbbb, Category=5, Description=bbb', 1, '2025-04-21 10:48:08'),
(509, 'ASSIGN', 'tickets', 69, 'Assigned ticket ID 69 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 10:48:18'),
(510, 'CONFIRM', 'tickets', 69, 'Confirmed ticket ID 69 and updated status to \"In Progress\".', 1, '2025-04-21 10:50:16'),
(511, 'UPDATE', 'tickets', 60, 'Updated ticket ID 60 status to Resolved.', 1, '2025-04-21 10:52:17'),
(512, 'UPDATE', 'tickets', 65, 'Updated ticket ID 65 status to In Progress.', 1, '2025-04-21 16:32:10'),
(513, 'CREATE', 'tickets', 70, 'Created ticket: Subject=AAAAA, Category=5, Description=AAAA', 1, '2025-04-21 16:32:50'),
(514, 'ASSIGN', 'tickets', 70, 'Assigned ticket ID 70 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 16:33:00'),
(515, 'CONFIRM', 'tickets', 70, 'Confirmed ticket ID 70 and updated status to \"In Progress\".', 1, '2025-04-21 16:33:07'),
(516, 'CREATE', 'tickets', 71, 'Created ticket: Subject=aaaaaa, Category=8, Description=aaaaaaaaa', 1, '2025-04-21 16:38:59'),
(517, 'ASSIGN', 'tickets', 71, 'Assigned ticket ID 71 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 16:39:08'),
(518, 'CONFIRM', 'tickets', 71, 'Confirmed ticket ID 71 and updated status to \"In Progress\".', 1, '2025-04-21 16:39:22'),
(519, 'CREATE', 'tickets', 72, 'Created ticket: Subject=ahaha, Category=7, Description=ahahaha', 1, '2025-04-21 16:40:56'),
(520, 'ASSIGN', 'tickets', 72, 'Assigned ticket ID 72 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 16:41:07'),
(521, 'CONFIRM', 'tickets', 72, 'Confirmed ticket ID 72 and updated status to \"In Progress\".', 1, '2025-04-21 16:41:13'),
(522, 'CREATE', 'tickets', 73, 'Created ticket: Subject=aaasss, Category=8, Description=aaaaaa', 1, '2025-04-21 16:46:01'),
(523, 'ASSIGN', 'tickets', 73, 'Assigned ticket ID 73 to user John Mico D. Intacto (ID: 1) with priority High.', 1, '2025-04-21 16:46:19'),
(524, 'CONFIRM', 'tickets', 73, 'Confirmed ticket ID 73 and updated status to \"In Progress\".', 1, '2025-04-21 16:46:24'),
(525, 'CREATE', 'tickets', 74, 'Created ticket: Subject=sample 305, Category=8, Description=testing 123', 1, '2025-04-21 16:47:17'),
(526, 'ASSIGN', 'tickets', 74, 'Assigned ticket ID 74 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 16:47:27'),
(527, 'CONFIRM', 'tickets', 74, 'Confirmed ticket ID 74 and updated status to \"In Progress\".', 1, '2025-04-21 16:47:35'),
(528, 'CREATE', 'tickets', 75, 'Created ticket: Subject=sample 305, Category=6, Description=testing 123', 1, '2025-04-21 16:50:36'),
(529, 'ASSIGN', 'tickets', 75, 'Assigned ticket ID 75 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 16:53:05'),
(530, 'CONFIRM', 'tickets', 75, 'Confirmed ticket ID 75 and updated status to \"In Progress\".', 1, '2025-04-21 16:53:10'),
(531, 'UPDATE', 'tickets', 66, 'Updated ticket ID 66 status to Resolved.', 1, '2025-04-21 17:01:36'),
(532, 'UPDATE', 'tickets', 67, 'Updated ticket ID 67 status to Resolved.', 1, '2025-04-21 17:02:11'),
(533, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 00:04:53'),
(534, 'UPDATE', 'tickets', 68, 'Updated ticket ID 68 status to Resolved.', 1, '2025-04-21 18:05:10'),
(535, 'UPDATE', 'tickets', 69, 'Updated ticket ID 69 status to Resolved.', 1, '2025-04-21 18:08:28'),
(536, 'UPDATE', 'tickets', 70, 'Updated ticket ID 70 status to Resolved.', 1, '2025-04-21 18:11:01'),
(537, 'UPDATE', 'tickets', 71, 'Updated ticket ID 71 status to Resolved.', 1, '2025-04-21 18:14:31'),
(538, 'UPDATE', 'tickets', 72, 'Updated ticket ID 72 status to Resolved.', 1, '2025-04-21 18:16:46'),
(539, 'UPDATE', 'tickets', 73, 'Updated ticket ID 73 status to Resolved.', 1, '2025-04-21 18:20:59'),
(540, 'UPDATE', 'tickets', 74, 'Updated ticket ID 74 status to Resolved.', 1, '2025-04-21 18:24:27'),
(541, 'UPDATE', 'tickets', 75, 'Updated ticket ID 75 status to Resolved.', 1, '2025-04-21 18:27:48'),
(542, 'CREATE', 'tickets', 76, 'Created ticket: Subject=qadfghjk, Category=5, Description=wdfghjk', 1, '2025-04-21 18:29:51'),
(543, 'ASSIGN', 'tickets', 76, 'Assigned ticket ID 76 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 18:31:58'),
(544, 'CONFIRM', 'tickets', 76, 'Confirmed ticket ID 76 and updated status to \"In Progress\".', 1, '2025-04-21 18:32:03'),
(545, 'UPDATE', 'tickets', 76, 'Updated ticket ID 76 status to Resolved.', 1, '2025-04-21 18:32:22'),
(546, 'CREATE', 'tickets', 77, 'Created ticket: Subject=srtuy, Category=5, Description=yy', 1, '2025-04-21 18:36:42'),
(547, 'ASSIGN', 'tickets', 77, 'Assigned ticket ID 77 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 18:36:51'),
(548, 'CONFIRM', 'tickets', 77, 'Confirmed ticket ID 77 and updated status to \"In Progress\".', 1, '2025-04-21 18:37:01'),
(549, 'UPDATE', 'tickets', 77, 'Updated ticket ID 77 status to Resolved.', 1, '2025-04-21 18:37:14'),
(550, 'CREATE', 'tickets', 78, 'Created ticket: Subject=fghjkl, Category=5, Description=fdghj', 1, '2025-04-21 18:41:57'),
(551, 'ASSIGN', 'tickets', 78, 'Assigned ticket ID 78 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 18:42:09'),
(552, 'CONFIRM', 'tickets', 78, 'Confirmed ticket ID 78 and updated status to \"In Progress\".', 1, '2025-04-21 18:42:15'),
(553, 'UPDATE', 'tickets', 78, 'Updated ticket ID 78 status to Resolved.', 1, '2025-04-21 18:42:36'),
(554, 'CREATE', 'tickets', 79, 'Created ticket: Subject=fghtgg, Category=6, Description=dfghgj', 1, '2025-04-21 18:44:22'),
(555, 'ASSIGN', 'tickets', 79, 'Assigned ticket ID 79 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 18:44:35'),
(556, 'CONFIRM', 'tickets', 79, 'Confirmed ticket ID 79 and updated status to \"In Progress\".', 1, '2025-04-21 18:44:42'),
(557, 'CREATE', 'tickets', 80, 'Created ticket: Subject=aaaaaa, Category=5, Description=aaaaa', 1, '2025-04-21 18:49:44'),
(558, 'ASSIGN', 'tickets', 80, 'Assigned ticket ID 80 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-21 18:49:54'),
(559, 'CONFIRM', 'tickets', 80, 'Confirmed ticket ID 80 and updated status to \"In Progress\".', 1, '2025-04-21 18:50:01'),
(560, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 01:06:22'),
(561, 'INSERT', 'ticket_responses', 88, 'Added response to ticket ID 53: DOMINGO EARL GERALD (66).JPG', 1, '2025-04-21 20:00:19'),
(562, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 20:00:50'),
(563, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-22 02:01:01'),
(564, 'INSERT', 'attachments', 52, 'Added attachment to ticket ID 2: assets/uploads/DOMINGO EARL GERALD (66).JPG', 2, '2025-04-21 20:02:08'),
(565, 'INSERT', 'ticket_responses', 89, 'Added response to ticket ID 2: DOMINGO EARL GERALD (66).JPG', 2, '2025-04-21 20:02:08'),
(566, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-21 20:03:37'),
(567, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-22 02:03:48'),
(568, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-22 02:06:53'),
(569, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-21 20:10:25'),
(570, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-22 02:10:37'),
(571, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-21 20:11:51'),
(572, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-22 02:13:17'),
(573, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-21 20:14:26'),
(574, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-22 02:14:50'),
(575, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-21 20:16:39'),
(576, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-22 02:16:50'),
(577, 'CONFIRM', 'tickets', 50, 'Confirmed ticket ID 50 and updated status to \"In Progress\".', 1500, '2025-04-21 20:40:43'),
(578, 'UPDATE', 'tickets', 50, 'Updated ticket ID 50 status to Resolved.', 1500, '2025-04-21 20:41:57'),
(579, 'UPDATE', 'tickets', 50, 'Updated ticket ID 50 status to Resolved.', 1500, '2025-04-21 20:41:57'),
(580, 'CONFIRM', 'tickets', 49, 'Confirmed ticket ID 49 and updated status to \"In Progress\".', 1500, '2025-04-21 21:20:51'),
(581, 'CONFIRM', 'tickets', 48, 'Confirmed ticket ID 48 and updated status to \"In Progress\".', 1500, '2025-04-21 21:23:37'),
(582, 'UPDATE', 'tickets', 48, 'Updated ticket ID 48 status to Resolved.', 1500, '2025-04-21 21:25:57'),
(583, 'UPDATE', 'tickets', 48, 'Updated ticket ID 48 status to Resolved.', 1500, '2025-04-21 21:25:57'),
(584, 'UPDATE', 'tickets', 49, 'Updated ticket ID 49 status to Resolved.', 1500, '2025-04-21 21:27:09'),
(585, 'UPDATE', 'tickets', 49, 'Updated ticket ID 49 status to Resolved.', 1500, '2025-04-21 21:27:09'),
(586, 'CONFIRM', 'tickets', 47, 'Confirmed ticket ID 47 and updated status to \"In Progress\".', 1500, '2025-04-21 21:28:45'),
(587, 'UPDATE', 'tickets', 47, 'Updated ticket ID 47 status to Resolved.', 1500, '2025-04-21 21:28:59'),
(588, 'UPDATE', 'tickets', 47, 'Updated ticket ID 47 status to Resolved.', 1500, '2025-04-21 21:28:59'),
(589, 'CONFIRM', 'tickets', 44, 'Confirmed ticket ID 44 and updated status to \"In Progress\".', 1500, '2025-04-21 21:41:55'),
(590, 'UPDATE', 'tickets', 44, 'Updated ticket ID 44 status to Resolved.', 1500, '2025-04-21 21:42:04'),
(591, 'UPDATE', 'tickets', 44, 'Updated ticket ID 44 status to Resolved.', 1500, '2025-04-21 21:42:04'),
(592, 'CONFIRM', 'tickets', 45, 'Confirmed ticket ID 45 and updated status to \"In Progress\".', 1500, '2025-04-21 21:42:18'),
(593, 'UPDATE', 'tickets', 45, 'Updated ticket ID 45 status to Resolved.', 1500, '2025-04-21 21:42:28'),
(594, 'UPDATE', 'tickets', 45, 'Updated ticket ID 45 status to Resolved.', 1500, '2025-04-21 21:42:28'),
(595, 'UPDATE', 'tickets', 37, 'Updated ticket ID 37 status to Resolved.', 1500, '2025-04-21 21:45:21'),
(596, 'UPDATE', 'tickets', 37, 'Updated ticket ID 37 status to Resolved.', 1500, '2025-04-21 21:45:21'),
(597, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-21 21:48:31'),
(598, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 03:48:34'),
(599, 'CREATE', 'tickets', 81, 'Created ticket: Subject=Test 300, Category=4, Description=Test 300', 1, '2025-04-21 21:49:02'),
(600, 'CREATE', 'tickets', 82, 'Created ticket: Subject=Test3001, Category=6, Description=Test301', 1, '2025-04-21 21:49:20'),
(601, 'CREATE', 'tickets', 83, 'Created ticket: Subject=Test 302, Category=6, Description=Test302', 1, '2025-04-21 21:49:48'),
(602, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 21:49:54'),
(603, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 03:50:07'),
(604, 'ASSIGN', 'tickets', 83, 'Assigned ticket ID 83 to user hank (ID: 1500) with priority Low.', 1, '2025-04-21 21:50:23'),
(605, 'ASSIGN', 'tickets', 81, 'Assigned ticket ID 81 to user hank (ID: 1500) with priority Low.', 1, '2025-04-21 21:50:34'),
(606, 'ASSIGN', 'tickets', 82, 'Assigned ticket ID 82 to user hank (ID: 1500) with priority Low.', 1, '2025-04-21 21:50:38'),
(607, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 21:50:55'),
(608, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-22 03:51:08'),
(609, 'CONFIRM', 'tickets', 81, 'Confirmed ticket ID 81 and updated status to \"In Progress\".', 1500, '2025-04-21 21:51:18'),
(610, 'UPDATE', 'tickets', 81, 'Updated ticket ID 81 status to Resolved.', 1500, '2025-04-21 21:51:29'),
(611, 'UPDATE', 'tickets', 81, 'Updated ticket ID 81 status to Resolved.', 1500, '2025-04-21 21:51:29'),
(612, 'CONFIRM', 'tickets', 82, 'Confirmed ticket ID 82 and updated status to \"In Progress\".', 1500, '2025-04-21 21:52:06'),
(613, 'UPDATE', 'tickets', 82, 'Updated ticket ID 82 status to Resolved.', 1500, '2025-04-21 21:52:15'),
(614, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 05:41:38'),
(615, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-21 23:41:42'),
(616, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-22 05:41:52'),
(617, 'CONFIRM', 'tickets', 83, 'Confirmed ticket ID 83 and updated status to \"In Progress\".', 1500, '2025-04-21 23:58:43'),
(618, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-22 00:01:43'),
(619, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 06:01:47'),
(620, 'CREATE', 'tickets', 84, 'Created ticket: Subject=teST 306, Category=6, Description=TEST 306', 1, '2025-04-22 00:02:46'),
(621, 'CREATE', 'tickets', 85, 'Created ticket: Subject=TEXT 307, Category=6, Description=307', 1, '2025-04-22 00:03:06'),
(622, 'CREATE', 'tickets', 86, 'Created ticket: Subject=TEXT 308, Category=8, Description=TEXT 308', 1, '2025-04-22 00:03:23'),
(623, 'ASSIGN', 'tickets', 84, 'Assigned ticket ID 84 to user hank (ID: 1500) with priority Low.', 1, '2025-04-22 00:03:34'),
(624, 'ASSIGN', 'tickets', 85, 'Assigned ticket ID 85 to user hank (ID: 1500) with priority Low.', 1, '2025-04-22 00:03:43'),
(625, 'ASSIGN', 'tickets', 86, 'Assigned ticket ID 86 to user hank (ID: 1500) with priority Low.', 1, '2025-04-22 00:03:47'),
(626, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-22 00:03:52'),
(627, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-22 06:04:04'),
(628, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-22 00:04:22'),
(629, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 06:04:25'),
(630, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-22 00:06:01'),
(631, 'LOGIN', 'users', 1500, 'User ID 1500 logged in successfully.', 1500, '2025-04-22 06:06:11'),
(632, 'CONFIRM', 'tickets', 84, 'Confirmed ticket ID 84 and updated status to \"In Progress\".', 1500, '2025-04-22 00:09:54'),
(633, 'CONFIRM', 'tickets', 85, 'Confirmed ticket ID 85 and updated status to \"In Progress\".', 1500, '2025-04-22 00:11:08'),
(634, 'CONFIRM', 'tickets', 86, 'Confirmed ticket ID 86 and updated status to \"In Progress\".', 1500, '2025-04-22 00:15:44'),
(635, 'UPDATE', 'tickets', 83, 'Updated ticket ID 83 status to Resolved.', 1500, '2025-04-22 00:16:04'),
(636, 'UPDATE', 'tickets', 84, 'Updated ticket ID 84 status to Resolved.', 1500, '2025-04-22 00:16:39'),
(637, 'LOGOUT', 'users', 1500, 'User ID 1500 logged out successfully.', 1500, '2025-04-22 00:16:57'),
(638, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-22 06:17:21'),
(639, 'LOGIN', 'users', 2, 'User ID 2 logged in successfully.', 2, '2025-04-22 07:04:09'),
(640, 'LOGOUT', 'users', 2, 'User ID 2 logged out successfully.', 2, '2025-04-22 01:09:19'),
(641, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 07:09:24');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'IT Support'),
(2, 'HR Issues'),
(3, 'Billing Queries'),
(4, 'Employee Relations'),
(5, 'Technical Support'),
(6, 'Payroll'),
(7, 'Leave Management'),
(8, 'Office Equipment'),
(9, 'Training and Development'),
(10, 'Health and Safety');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Open','In Progress','Resolved','Closed') DEFAULT 'Open',
  `priority` enum('Low','Medium','High') DEFAULT 'Low',
  `category_id` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `employee_id`, `subject`, `description`, `status`, `priority`, `category_id`, `assigned_to`, `created_at`, `start_at`, `updated_at`) VALUES
(1, 1, 'Issue with IT support', 'The employee cannot access their work computer.', 'Open', 'High', 1, NULL, '2025-04-08 07:05:34', NULL, NULL),
(2, 2, 'HR issue regarding leaves', 'The employee has trouble applying for leaves.', 'In Progress', 'Medium', 2, 2, '2025-04-04 12:45:02', NULL, NULL),
(4, 1200, 'Employee Relations concern', 'The employee raised an issue with a colleague.', 'Open', 'Low', 4, 2, '2025-03-12 04:15:00', NULL, NULL),
(5, 5, 'Technical issue with the software', 'The employee is unable to run the latest software update.', 'Open', 'Low', 5, 1731, '2025-03-12 04:20:00', NULL, NULL),
(6, 6, 'Payroll error', 'The payroll for last month was incorrect.', 'In Progress', 'Medium', 6, 1, '2025-03-12 04:25:00', NULL, NULL),
(8, 8, 'Office Equipment malfunction', 'The printer is not working in the office.', 'Resolved', 'Low', 8, NULL, '2025-03-12 04:35:00', NULL, NULL),
(9, 1500, 'Training request', 'The employee needs a training session on new software.', 'Open', 'Low', 9, NULL, '2025-03-12 04:40:00', NULL, NULL),
(10, 10, 'Health and Safety concern', 'There is a potential safety issue in the office building.', 'Open', 'High', 10, NULL, '2025-04-04 12:40:00', NULL, NULL),
(11, 2, 'Printer', 'something crazy shit', 'Open', 'Low', 5, 2, '2025-03-25 18:31:42', NULL, NULL),
(12, 2, 'HR Sample', 'HR Text sample', 'Open', 'Low', 2, 2, '2025-04-04 10:20:10', NULL, NULL),
(13, 2, 'Test', 'TExt', 'Open', 'Low', 6, 2, '2025-04-04 10:23:11', NULL, NULL),
(14, 2, '123', '123', 'Open', 'Low', 1, 2, '2025-04-04 10:25:58', NULL, NULL),
(15, 2, 'Printer', 'sample lans 123', 'In Progress', 'Medium', 6, 1799, '2025-04-08 02:45:34', NULL, NULL),
(16, 2, 'Printer', 'sample lans 123', 'Open', 'Low', 6, NULL, '2025-04-08 02:47:27', NULL, NULL),
(17, 2, '123123', '123123', 'Open', 'Low', 8, NULL, '2025-04-08 02:49:12', NULL, NULL),
(18, 2, 'asdasdsad', 'asdasdasdasd', 'Open', 'Low', 8, NULL, '2025-04-08 02:51:09', NULL, NULL),
(19, 2, 'asampel as asdia', 'ajkdashdlkajd', 'Open', 'Low', 2, NULL, '2025-04-09 10:10:30', NULL, NULL),
(20, 1, 'adadaa', 'adjadasda', 'Open', 'Low', 8, NULL, '2025-04-10 01:15:43', NULL, NULL),
(21, 1500, 'ADASDASDAS', 'ASDASDADS', 'Open', 'Low', 8, NULL, '2025-04-10 03:33:14', NULL, NULL),
(22, 1500, 'asdasdaa', 'sdasasd', 'Open', 'Low', 10, NULL, '2025-04-10 03:43:19', NULL, NULL),
(23, 1500, 'aggagaagaga', 'asdjkujahsdsadadas', 'Resolved', 'Low', 6, 1, '2025-04-10 03:47:12', '2025-04-16 23:01:27', '2025-04-19 06:20:22'),
(24, 1500, 'test', 'test', 'Resolved', 'Low', 7, 1, '2025-04-10 03:59:22', '2025-04-16 22:31:01', '2025-04-16 14:31:33'),
(25, 2, 'Testing 123', 'asjkasjkasjkasdjklasdads', 'Resolved', 'Low', 6, 1500, '2025-04-15 06:10:16', '2025-04-15 14:11:44', '2025-04-15 08:27:19'),
(26, 2, 'Bur', 'ashjashjashjahjasdhjasdhjkashjkasjkdh ada', 'Resolved', 'Low', 2, 1500, '2025-04-15 06:14:29', '2025-04-15 22:14:10', '2025-04-15 14:15:18'),
(27, 2, 'Tst april 17', 'tesing 123', 'Resolved', 'High', 7, 1, '2025-04-17 13:00:01', '2025-04-17 21:01:02', '2025-04-21 10:43:48'),
(28, 2, 'sample 305', 'testing 123', 'Resolved', 'Low', 1, 1, '2025-04-18 19:05:35', '2025-04-19 03:06:34', '2025-04-21 10:34:23'),
(29, 2, 'Testing 123 230pm', '230pm', 'Resolved', 'Low', 4, 1500, '2025-04-19 06:31:18', '2025-04-19 14:32:07', '2025-04-19 07:01:55'),
(30, 2, 'ahiouasdhiuahiashiadshiloasd', 'ahjklasjhd asd opasduas iljousd a ijlo;d', 'Open', 'Medium', 5, 10, '2025-04-19 07:11:14', NULL, NULL),
(31, 2, 'as dkl;jasd jk;a jkl;as jkl;a jkla jklsdklhj; sdjkl;fijopas opuaopu nanopudnopu as pundosaunopd saopun', 'asdoip as l;oa slo;jask aop;j\'l a o;jpas ao;k', 'Open', 'High', 1, 8, '2025-04-19 07:11:35', NULL, NULL),
(32, 2, 'd jopasdajo ;d asd', 'asdiopuas daiop udsasopu asdas', 'Resolved', 'Low', 2, 1, '2025-04-19 07:11:50', '2025-04-21 19:00:39', '2025-04-21 11:00:50'),
(33, 1, 'Sample 123 april 21', 'Testing12313123', 'Open', 'High', 1, 8, '2025-04-21 12:20:38', NULL, NULL),
(34, 1, 'Testing @123', 'asdasdasdasd', 'Resolved', 'Medium', 5, 1500, '2025-04-21 12:21:34', '2025-04-21 21:18:36', '2025-04-21 13:18:52'),
(35, 1, 'Testing', 'asdakldasda', 'Open', 'Low', 9, 10, '2025-04-21 12:23:31', NULL, NULL),
(36, 1, 'Testing 4', 'Testing 4', 'Open', 'Low', 5, 6, '2025-04-21 12:27:21', NULL, NULL),
(37, 1, 'Test 5', 'Test5', 'Resolved', 'Low', 1, 1500, '2025-04-21 12:30:47', '2025-04-21 21:14:24', '2025-04-22 03:45:21'),
(38, 1, 'Test 6', 'dsadd', 'Open', 'Low', 8, 1799, '2025-04-21 12:31:05', NULL, NULL),
(39, 1, 'tsest 7', 'Tresting', 'Open', 'Low', 8, 2, '2025-04-21 12:33:36', NULL, NULL),
(40, 1, 'Tesdtasdas hank', 'asasdad aa', 'Resolved', 'Low', 6, 1500, '2025-04-21 13:20:24', '2025-04-21 21:35:29', '2025-04-21 13:35:46'),
(41, 1, 'hank hank han k', 'adklajsdkljasdjklasd', 'Resolved', 'Low', 6, 1500, '2025-04-21 13:20:40', '2025-04-21 21:34:26', '2025-04-21 13:34:37'),
(42, 1, 'asdmnkl;adskln,.dsahjkln/asd', 'sdkljasd asd sa', 'Resolved', 'Low', 6, 1500, '2025-04-21 13:20:56', '2025-04-21 21:32:28', '2025-04-21 13:32:39'),
(43, 1, 'dasdadsadsadsasdas', 'asdsadasddas', 'Resolved', 'High', 1, 1500, '2025-04-21 13:21:33', '2025-04-21 21:23:12', '2025-04-21 13:23:26'),
(44, 1, 'wiusksiwksio', 'asdasda ia iksa ias as', 'Resolved', 'Medium', 7, 1500, '2025-04-21 14:08:09', '2025-04-22 11:41:55', '2025-04-22 03:42:04'),
(45, 1, 'Tst 123', '2sksmxiksmxik', 'Resolved', 'High', 1, 1500, '2025-04-21 14:08:28', '2025-04-22 11:42:18', '2025-04-22 03:42:28'),
(46, 1, 'Asda asdasd asda sds', 'sdldlksadklsdksd', 'Open', 'High', 7, 10, '2025-04-21 14:08:48', NULL, NULL),
(47, 1, 'asdkas askas ka jak d', 'asd asd adad', 'Resolved', 'Medium', 7, 1500, '2025-04-21 14:09:01', '2025-04-22 11:28:45', '2025-04-22 03:28:59'),
(48, 1, 'akdsa d;las ad', 'asd klasjdas da', 'Resolved', 'High', 4, 1500, '2025-04-21 14:09:17', '2025-04-22 11:23:37', '2025-04-22 03:25:57'),
(49, 1, 'adasdadas', 'asdsadsad', 'Resolved', 'High', 6, 1500, '2025-04-21 14:41:28', '2025-04-22 11:20:51', '2025-04-22 03:27:09'),
(50, 1, 'adadadaasdad', 'adadasdasddas', 'Resolved', 'Medium', 7, 1500, '2025-04-21 14:44:20', '2025-04-22 10:40:43', '2025-04-22 02:41:57'),
(51, 2, 'hank123', 'asdkl;jakjaadsasd', 'Resolved', 'High', 5, 1, '2025-04-21 14:46:42', '2025-04-21 22:54:19', '2025-04-21 15:09:55'),
(52, 2, 'test', 'aklasdk jad;as asda', 'Resolved', 'Low', 1, 1, '2025-04-21 14:46:57', '2025-04-21 23:02:59', '2025-04-21 15:13:55'),
(53, 2, 'dklnasasknasdk ad a', 'adsklsadj adsa d', 'Resolved', 'Low', 9, 1, '2025-04-21 14:47:11', '2025-04-21 23:08:18', '2025-04-21 15:20:11'),
(54, 2, 'Sample 123 april 21', 'asmadasda', 'Resolved', 'High', 8, 1, '2025-04-21 15:22:45', '2025-04-21 23:24:29', '2025-04-21 15:24:53'),
(55, 2, '1', 'asdasjd  j j j j iu  opas', 'Resolved', 'Medium', 6, 1, '2025-04-21 15:23:00', '2025-04-21 23:28:29', '2025-04-21 15:30:12'),
(56, 2, '13456', 'testing 123', 'In Progress', 'Low', 8, 1, '2025-04-21 15:23:11', '2025-04-21 23:39:33', NULL),
(57, 2, 'haktdo', 'testing 123', 'In Progress', 'Low', 1, 1, '2025-04-21 15:23:23', '2025-04-21 23:41:32', NULL),
(58, 2, 'sample 305', 'testing 123', 'In Progress', 'High', 8, 1, '2025-04-21 15:23:33', '2025-04-21 23:42:36', NULL),
(59, 2, 'sample 305', 'testing 123', 'In Progress', 'Low', 7, 1, '2025-04-21 15:23:45', '2025-04-21 23:44:06', NULL),
(60, 1, 'sdfdfdfsdsf', 'fddsfdfdf', 'Resolved', 'Low', 6, 1, '2025-04-21 15:45:37', '2025-04-21 23:46:09', '2025-04-21 16:52:17'),
(61, 1, 'asdas', 'sdasdad', 'In Progress', 'Low', 6, 1, '2025-04-21 15:49:35', '2025-04-21 23:49:59', NULL),
(62, 1, 'asdad', 'asda', 'In Progress', 'Low', 6, 1, '2025-04-21 15:53:42', '2025-04-21 23:54:03', NULL),
(63, 1, 'assadaa', 'sdsaddas', 'In Progress', 'Medium', 6, 1, '2025-04-21 16:04:10', '2025-04-22 00:04:32', NULL),
(64, 1, 'SDSFSFS', 'SDFDSFDSDSF', 'Resolved', 'Low', 6, 1, '2025-04-21 16:21:53', '2025-04-22 00:22:20', '2025-04-21 16:36:59'),
(65, 1, 'ccgh', 'cfdf', 'In Progress', 'Low', 7, 1, '2025-04-21 16:33:15', '2025-04-22 00:33:35', '2025-04-21 22:32:10'),
(66, 1, 'aa', 'a', 'Resolved', 'High', 6, 1, '2025-04-21 16:40:23', '2025-04-22 00:40:50', '2025-04-21 23:01:36'),
(67, 1, 'sadadasdsda', 'aaaa', 'Resolved', 'Low', 6, 1, '2025-04-21 16:45:49', '2025-04-22 00:46:06', '2025-04-21 23:02:11'),
(68, 1, 'asdaasa', 'sdsasadsad', 'Resolved', 'Low', 6, 1, '2025-04-21 16:46:27', '2025-04-22 00:47:15', '2025-04-22 00:05:10'),
(69, 1, 'bbbb', 'bbb', 'Resolved', 'Low', 5, 1, '2025-04-21 16:48:08', '2025-04-22 00:50:16', '2025-04-22 00:08:28'),
(70, 1, 'AAAAA', 'AAAA', 'Resolved', 'Low', 5, 1, '2025-04-21 22:32:50', '2025-04-22 06:33:07', '2025-04-22 00:11:01'),
(71, 1, 'aaaaaa', 'aaaaaaaaa', 'Resolved', 'Low', 8, 1, '2025-04-21 22:38:59', '2025-04-22 06:39:22', '2025-04-22 00:14:31'),
(72, 1, 'ahaha', 'ahahaha', 'Resolved', 'Low', 7, 1, '2025-04-21 22:40:56', '2025-04-22 06:41:13', '2025-04-22 00:16:46'),
(73, 1, 'aaasss', 'aaaaaa', 'Resolved', 'High', 8, 1, '2025-04-21 22:46:01', '2025-04-22 06:46:24', '2025-04-22 00:20:59'),
(74, 1, 'sample 305', 'testing 123', 'Resolved', 'Low', 8, 1, '2025-04-21 22:47:17', '2025-04-22 06:47:35', '2025-04-22 00:24:27'),
(75, 1, 'sample 305', 'testing 123', 'Resolved', 'Low', 6, 1, '2025-04-21 22:50:36', '2025-04-22 06:53:10', '2025-04-22 00:27:48'),
(76, 1, 'qadfghjk', 'wdfghjk', 'Resolved', 'Low', 5, 1, '2025-04-22 00:29:51', '2025-04-22 08:32:03', '2025-04-22 00:32:22'),
(77, 1, 'srtuy', 'yy', 'Resolved', 'Low', 5, 1, '2025-04-22 00:36:42', '2025-04-22 08:37:01', '2025-04-22 00:37:14'),
(78, 1, 'fghjkl', 'fdghj', 'Resolved', 'Low', 5, 1, '2025-04-22 00:41:57', '2025-04-22 08:42:15', '2025-04-22 00:42:36'),
(79, 1, 'fghtgg', 'dfghgj', 'In Progress', 'Low', 6, 1, '2025-04-22 00:44:22', '2025-04-22 08:44:42', NULL),
(80, 1, 'aaaaaa', 'aaaaa', 'In Progress', 'Low', 5, 1, '2025-04-22 00:49:44', '2025-04-22 08:50:01', NULL),
(81, 1, 'Test 300', 'Test 300', 'Resolved', 'Low', 4, 1500, '2025-04-22 03:49:02', '2025-04-22 11:51:18', '2025-04-22 03:51:29'),
(82, 1, 'Test3001', 'Test301', 'Resolved', 'Low', 6, 1500, '2025-04-22 03:49:20', '2025-04-22 11:52:06', '2025-04-22 03:52:15'),
(83, 1, 'Test 302', 'Test302', 'Resolved', 'Low', 6, 1500, '2025-04-22 03:49:48', '2025-04-22 13:58:43', '2025-04-22 06:16:04'),
(84, 1, 'teST 306', 'TEST 306', 'Resolved', 'Low', 6, 1500, '2025-04-22 06:02:46', '2025-04-22 14:09:54', '2025-04-22 06:16:39'),
(85, 1, 'TEXT 307', '307', 'In Progress', 'Low', 6, 1500, '2025-04-22 06:03:06', '2025-04-22 14:11:08', NULL),
(86, 1, 'TEXT 308', 'TEXT 308', 'In Progress', 'Low', 8, 1500, '2025-04-22 06:03:23', '2025-04-22 14:15:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_responses`
--

CREATE TABLE `ticket_responses` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `response_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_responses`
--

INSERT INTO `ticket_responses` (`id`, `ticket_id`, `user_id`, `response_text`, `created_at`) VALUES
(1, 1, 2, 'Hello can you help me with this problem?', '2025-03-19 14:01:03'),
(2, 2, 2, 'HELLO', '2025-03-19 14:48:51'),
(3, 2, 2, 'CAN YOU HELP ME WITH THIS PROBLEM', '2025-03-19 14:49:32'),
(5, 2, 2, 'sample 1', '2025-03-20 03:10:29'),
(6, 2, 2, 'sample v2', '2025-03-20 03:10:31'),
(7, 2, 2, 'sample 3', '2025-03-20 03:10:33'),
(8, 2, 2, 'sample 5', '2025-03-20 03:10:35'),
(9, 2, 2, 'saomoke', '2025-03-20 03:10:36'),
(10, 2, 2, 'test 123', '2025-03-20 06:12:46'),
(11, 2, 2, 'baho', '2025-03-20 06:12:49'),
(12, 4, 2, 'Hello Carol', '2025-04-06 14:45:35'),
(13, 2, 2, 'sameple test123', '2025-04-08 02:59:40'),
(14, 2, 2, 'haksdoasdad asjkdashd;lak', '2025-04-08 03:01:35'),
(15, 9, 1500, 'hadadasd', '2025-04-09 14:17:26'),
(16, 19, 2, 'ashjklashjsdajkl', '2025-04-15 06:00:48'),
(17, 19, 2, 'asdasd', '2025-04-15 06:02:42'),
(18, 19, 2, 'asjklasjashjklsadklhjadsklj asldak asd d12310-319312', '2025-04-15 06:02:50'),
(19, 19, 2, 'u643738716_mnmch_hrts_db.sql', '2025-04-15 06:06:24'),
(20, 25, 1500, 'Hello tesing 123', '2025-04-15 06:12:07'),
(21, 25, 1500, 'mnmch_hrts_db.sql', '2025-04-15 06:12:14'),
(22, 25, 2, 'jklasjasdjklasd', '2025-04-15 06:13:00'),
(23, 25, 2, 'mnmch_hrts_db.sql', '2025-04-15 06:13:09'),
(24, 25, 2, 'DOMINGO EARL GERALD (66).JPG', '2025-04-15 06:13:49'),
(25, 26, 1, 'dasadsasddasdas', '2025-04-15 06:16:37'),
(26, 26, 1, 'DOMINGO EARL GERALD 073.jpg', '2025-04-15 06:16:48'),
(27, 23, 1500, 'test', '2025-04-16 15:10:01'),
(28, 23, 1500, 'asasdasd', '2025-04-16 15:10:03'),
(29, 23, 1500, 'DOMINGO EARL GERALD 073.jpg', '2025-04-16 15:10:22'),
(30, 23, 1, 'asjnklasjasdsa', '2025-04-16 15:10:45'),
(31, 23, 1, 'sdasdda', '2025-04-17 12:42:21'),
(32, 23, 1500, '2-243-01_Internship-Journal.docx', '2025-04-17 12:54:57'),
(33, 23, 1, 'asdilasddas', '2025-04-17 12:58:10'),
(34, 27, 1, 'asdasasdsa', '2025-04-17 13:01:18'),
(35, 27, 1, 'asaasdasds', '2025-04-17 13:06:11'),
(36, 27, 1, '???? File uploaded: <a href=\'assets/uploads/e-sign.psd\' target=\'_blank\'>e-sign.psd</a>', '2025-04-17 13:20:35'),
(37, 27, 1, '???? File uploaded: <a href=\'assets/uploads/DOMINGO EARL GERALD (66).JPG\' target=\'_blank\'>DOMINGO EARL GERALD (66).JPG</a>', '2025-04-17 13:21:08'),
(38, 27, 1, '???? File uploaded: <a href=\'assets/uploads/DOMINGO EARL GERALD (66).JPG\' target=\'_blank\'>DOMINGO EARL GERALD (66).JPG</a>', '2025-04-17 13:21:54'),
(39, 27, 1, 'DOMINGO EARL GERALD (66).JPG', '2025-04-17 13:24:13'),
(40, 27, 1, 'rx7.jpg', '2025-04-17 13:24:47'),
(41, 27, 1, 'wallpaper 1.jpg', '2025-04-17 13:28:15'),
(42, 27, 1, 'wallpaper 1.jpg', '2025-04-17 13:31:57'),
(43, 27, 1, 'wallpaper 1.jpg', '2025-04-17 13:31:57'),
(44, 27, 1, 'wallpaper 1.jpg', '2025-04-17 13:32:10'),
(45, 27, 1, 'asdjlasdasdasd', '2025-04-17 13:32:10'),
(46, 27, 1, 'wallpaper 1.jpg', '2025-04-17 13:32:11'),
(47, 27, 1, 'asasdadaads', '2025-04-17 13:32:11'),
(48, 27, 1, 'e-sign.psd', '2025-04-17 13:32:19'),
(49, 27, 1, 'e-sign.psd', '2025-04-17 13:32:19'),
(50, 28, 1, 'Testing 123', '2025-04-18 19:07:01'),
(51, 28, 1, 'cor-bascRvJpVp3r5D.pdf', '2025-04-18 19:09:56'),
(52, 28, 1, 'cor-bascRvJpVp3r5D.pdf', '2025-04-18 19:09:56'),
(53, 28, 1, 'SHARP F&B ADMIN_20250410_045959.pdf', '2025-04-18 19:10:20'),
(54, 28, 1, 'SHARP F&B ADMIN_20250410_045959.pdf', '2025-04-18 19:10:20'),
(55, 28, 2, 'Tsting 123', '2025-04-18 19:14:39'),
(56, 28, 2, '2-243-01_Internship-Journal.docx', '2025-04-18 19:14:48'),
(57, 28, 2, 'DOMINGO EARL GERALD (66).JPG', '2025-04-18 19:16:03'),
(58, 28, 2, 'DOMINGO EARL GERALD 073.jpg', '2025-04-18 19:16:21'),
(59, 28, 2, 'DOMINGO EARL GERALD 073.jpg', '2025-04-18 19:16:23'),
(60, 28, 2, 'DOMINGO EARL GERALD 073.jpg', '2025-04-18 19:16:24'),
(61, 28, 2, 'dadaikldasjklasjklajklas', '2025-04-18 19:21:21'),
(62, 28, 2, 'Tesing 1231212312', '2025-04-18 19:21:38'),
(63, 28, 2, 'asdhjkadshjahjads', '2025-04-18 19:22:38'),
(64, 28, 2, 'TEsting asqasdasd ad ad a', '2025-04-18 19:22:45'),
(65, 28, 2, 'DOMINGO EARL GERALD 073.jpg', '2025-04-18 19:23:01'),
(66, 28, 2, 'wallpaper 1.jpg', '2025-04-18 19:23:20'),
(67, 18, 2, 'jygjgkhljh;', '2025-04-18 19:34:28'),
(68, 26, 2, 'ghfgfghfghfhgfghfghj', '2025-04-18 19:34:40'),
(69, 26, 2, 'ghdhgfjh,ghgdhjgf kjygfil cugo', '2025-04-18 19:34:43'),
(70, 26, 2, 'hjgf jygf iujtg ikuhyilou. ylo;yo8t', '2025-04-18 19:34:45'),
(71, 26, 2, 'hngfjk ,yg lkug klu gh klu,jkh hk. hikl', '2025-04-18 19:34:48'),
(72, 26, 2, 'g kjug kjlgu kliugkl hg', '2025-04-18 19:34:50'),
(73, 26, 2, 'DOMINGO EARL GERALD (66).JPG', '2025-04-18 19:35:43'),
(74, 26, 1500, 'adiouadsdlodasa', '2025-04-19 02:58:49'),
(75, 26, 1500, '2-243-01_Internship-Journal.docx', '2025-04-19 02:59:05'),
(76, 26, 1500, 'i asdaa', '2025-04-19 02:59:16'),
(77, 26, 1500, 'osssjksksks kjasc sad asd asdas da sd', '2025-04-19 02:59:33'),
(78, 26, 1500, 'asiouasnjklasdjklhasd ajkl;sd asdjkl;a s', '2025-04-19 02:59:43'),
(79, 26, 1500, 'cor-bascRvJpVp3r5D.pdf', '2025-04-19 02:59:57'),
(80, 26, 2, 'cor-bascRvJpVp3r5D.pdf', '2025-04-19 03:01:37'),
(81, 26, 1500, 'TAe', '2025-04-19 03:05:22'),
(82, 26, 1500, 'wallpaper ae86 gif.gif', '2025-04-19 03:05:30'),
(83, 26, 1500, 'cor-bascRvJpVp3r5D.pdf', '2025-04-19 03:15:24'),
(84, 26, 1500, 'SHARP F&B ADMIN_20250410_045959.pdf', '2025-04-19 03:24:20'),
(85, 26, 1500, 'DOMINGO EARL GERALD 073.jpg', '2025-04-19 03:27:49'),
(86, 26, 2, 'Ae86 static wallpaper.jpg', '2025-04-19 03:30:52'),
(87, 53, 1, 'DOMINGO EARL GERALD (66).JPG', '2025-04-22 02:00:19'),
(88, 53, 1, 'DOMINGO EARL GERALD (66).JPG', '2025-04-22 02:00:19'),
(89, 2, 2, 'DOMINGO EARL GERALD (66).JPG', '2025-04-22 02:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Employee','HR','Admin','Super Admin') NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `department`, `status`, `created_at`) VALUES
(1, 'John Mico D. Intacto', 'mico@gmail.com', '$2y$10$lmXq4CSpHjrEd11Itbnh1eyHR4Qz6XZ7NctSRHPrs9yqjCPSZ0RdW', 'Admin', 'MIS/IT DEPARTMENT', 'Active', '2025-03-12 10:44:00'),
(2, 'Earl Gerald Domingo', 'earlgerald@gmail.com', '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja', 'Employee', 'MIS/IT DEPARTMENT', 'Active', '2025-03-12 03:00:00'),
(5, 'dave', 'dave@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'ER Department', 'Inactive', '2025-03-12 03:15:00'),
(6, 'eva', 'eva@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'IT Department', 'Active', '2025-03-12 03:20:00'),
(7, 'frank', 'frank@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'HR Department', 'Active', '2025-03-12 03:25:00'),
(8, 'grace', 'grace@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'Billing Department', 'Active', '2025-03-12 03:30:00'),
(10, 'iris', 'iris@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'IT Department', 'Active', '2025-03-12 03:40:00'),
(1200, 'carol', 'carol@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'INFORMATION DEPARTMENT', 'Active', '2025-03-12 03:10:00'),
(1201, 'Charity Lizardo', 'cha@gmail.com', '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW', '', 'EYE CENTER DEPARTMENT', 'Active', '2025-04-07 15:42:56'),
(1234, 'Bonet', 'bonet@gmail.com', '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW', 'Employee', 'PHARMACY DEPARTMENT', 'Active', '2025-04-07 15:45:07'),
(1500, 'hank', 'hank@gmail.com', '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja', 'HR', 'HR DEPARTMENT', 'Active', '2025-03-12 03:35:00'),
(1730, 'John Paulo Tagubar', 'paulo@gmail.com', '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW', 'Employee', 'Accounting Department', 'Active', '2025-03-28 03:09:43'),
(1731, 'Ruzzel Rubien Abdon', 'ruzzel@gmail.com', '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW', 'Employee', 'Accounting Department', 'Active', '2025-03-29 16:41:42'),
(1799, 'Dominic RM Daquiz', 'dominic@gmail.com', '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja', 'Super Admin', 'MIS/IT DEPARTMENT', 'Active', '2025-04-07 13:54:32'),
(3001, 'raymond', 'monde@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'EMERGENCY ROOM DEPARTMENT', 'Active', '2025-03-12 03:05:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `attachments_ibfk_2` (`uploaded_by`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_trail_ibfk_1` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=642;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attachments_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `ticket_responses` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  ADD CONSTRAINT `ticket_responses_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_responses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
