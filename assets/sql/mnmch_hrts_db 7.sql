-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 11:08 AM
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
  `file_name` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `ticket_id`, `uploaded_by`, `file_path`, `file_name`, `uploaded_at`) VALUES
(11, 32, 1794, 'assets/uploads/c008c4995dd6a756ec42b07e3300769e.jpg', 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-05-02 08:03:37'),
(12, 32, 1794, 'assets/uploads/32.jpg', '32.jpg', '2025-05-02 08:11:29'),
(13, 32, 1794, 'assets/uploads/3.jpg', '3.jpg', '2025-05-02 08:20:36'),
(14, 32, 1794, 'assets/uploads/3.jpg', '3.jpg', '2025-05-02 08:26:58'),
(15, 32, 1794, 'assets/uploads/wallpaper ae86 gif.gif', 'wallpaper ae86 gif.gif', '2025-05-02 08:27:13'),
(17, 32, 1794, 'assets/uploads/Ae86 static wallpaper.jpg', 'Ae86 static wallpaper.jpg', '2025-05-02 08:30:37'),
(18, 33, 1794, 'assets/uploads/c008c4995dd6a756ec42b07e3300769e.jpg', 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-05-02 23:44:31'),
(19, 33, 1794, 'assets/uploads/c008c4995dd6a756ec42b07e3300769e.jpg', 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-05-03 00:03:41'),
(20, 33, 1794, 'assets/uploads/Ae86 static wallpaper.jpg', 'Ae86 static wallpaper.jpg', '2025-05-03 00:04:24'),
(21, 33, 1794, 'assets/uploads/32.jpg', '32.jpg', '2025-05-03 00:09:34'),
(22, 27, 3, 'assets/uploads/Ae86 static wallpaper.jpg', 'Ae86 static wallpaper.jpg', '2025-05-03 00:11:03'),
(23, 27, 1168, 'assets/uploads/wallpaper ae86 gif.gif', 'wallpaper ae86 gif.gif', '2025-05-03 00:11:52'),
(30, 27, 1168, 'assets/uploads/PAGKAKALAMEG.mp4', 'PAGKAKALAMEG.mp4', '2025-05-07 15:28:57'),
(31, 27, 1168, 'assets/uploads/sample profile.jpg', 'sample profile.jpg', '2025-05-07 15:29:21'),
(32, 33, 1794, 'assets/uploads/1746666813_sample profile.jpg', '1746666813_sample profile.jpg', '2025-05-08 01:13:33'),
(33, 33, 1794, 'assets/uploads/gt 86.webp', 'gt 86.webp', '2025-05-08 02:29:55'),
(34, 33, 1794, 'assets/uploads/gt86.jpg', 'gt86.jpg', '2025-05-08 02:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL,
  `action_type` varchar(255) NOT NULL,
  `affected_table` enum('users','categories','tickets','ticket_responses','attachments','total_balance','used_balance','leave_requests','leave_attachments') NOT NULL,
  `affected_id` int(11) NOT NULL,
  `details` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id`, `action_type`, `affected_table`, `affected_id`, `details`, `user_id`, `timestamp`) VALUES
(265, 'CREATE', 'users', 1168, 'Created user: Name=DOMINIC RM DAQUIZ, Email=domrmdaquiz01@gmail.com, Role=Employee, Department=MIS/IT DEPARTMENT', 1, '2025-04-16 00:36:02'),
(266, 'CREATE', 'users', 2, 'Created user: Name=HRD-ANA, Email=HRDANA@GMAIL.COM, Role=Admin, Department=HR DEPARTMENT', 1, '2025-04-16 00:37:17'),
(267, 'CREATE', 'users', 3, 'Created user: Name=HRD-RIANNA, Email=HRDRIANNA@GMAIL.COM, Role=HR Rep, Department=HR DEPARTMENT', 1, '2025-04-16 00:37:51'),
(268, 'UPDATE', 'users', 3, 'Updated user details: Name=HRD-RIANNA, Email=HRDRIANNA@GMAIL.COM, Role=HR Rep, Department=H DEPARTMENT', 1, '2025-04-16 00:38:26'),
(269, 'UPDATE', 'users', 3, 'Updated user details: Name=HRD-RIANNA, Email=HRDRIANNA@GMAIL.COM, Role=HR Rep, Department=H DEPARTMENT', 1, '2025-04-16 00:38:41'),
(270, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 16:42:48'),
(271, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 16:59:11'),
(272, 'PASSWORD_RESET', 'users', 1168, 'Password for User ID 1168 was reset to a blank password.', 1, '2025-04-22 17:00:29'),
(273, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-22 17:00:36'),
(274, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-22 17:00:44'),
(275, 'CREATE', 'tickets', 25, 'Created ticket: Subject=payroll adjustment, Category=3, Description=payroll adjustment', 1168, '2025-04-22 17:01:16'),
(276, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 17:01:47'),
(277, 'ASSIGN', 'tickets', 25, 'Assigned ticket ID 25 to user ID 3 with priority Medium.', 1, '2025-04-22 17:02:20'),
(278, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-22 17:10:37'),
(279, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-22 17:11:13'),
(280, 'PASSWORD_RESET', 'users', 3, 'Password for User ID 3 was reset to a blank password.', 1, '2025-04-22 17:11:25'),
(281, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-22 17:11:28'),
(282, 'LOGIN', 'users', 3, 'User ID 3 logged in successfully.', 3, '2025-04-22 17:11:40'),
(283, 'CONFIRM', 'tickets', 25, 'Confirmed ticket ID 25 and updated status to \"In Progress\".', 3, '2025-04-22 17:11:46'),
(284, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-23 02:35:50'),
(285, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-23 02:38:37'),
(286, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-23 02:47:09'),
(287, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-23 02:49:12'),
(288, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-23 02:49:23'),
(289, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-23 02:50:07'),
(290, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-23 02:51:00'),
(291, 'LOGIN', 'users', 3, 'User ID 3 logged in successfully.', 3, '2025-04-23 02:51:56'),
(292, 'LOGIN', 'users', 3, 'User ID 3 logged in successfully.', 3, '2025-04-23 02:52:28'),
(293, 'LOGIN', 'users', 3, 'User ID 3 logged in successfully.', 3, '2025-04-23 06:46:49'),
(294, 'LOGOUT', 'users', 3, 'User ID 3 logged out successfully.', 3, '2025-04-23 06:47:12'),
(295, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-23 06:47:25'),
(296, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-23 06:47:50'),
(297, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-23 06:48:01'),
(298, 'CREATE', 'users', 1793, 'Created user: Name=JULIA LIVED, Email=HRDJULIA@GMAIL.COM, Role=HR Rep, Department=HR DEPARTMENT', 1, '2025-04-23 06:49:02'),
(299, 'UPDATE', 'users', 1793, 'Updated user details: Name=JULIA LIVED, Email=HRDJULIA@GMAIL.COM, Role=HR Rep, Department=HR DEPARTMENT', 1, '2025-04-23 06:49:53'),
(300, 'UPDATE', 'users', 1793, 'Updated user details: Name=JULIA LIVED, Email=HRDJULIA@GMAIL.COM, Role=HR Rep, Department=HR DEPARTMENT', 1, '2025-04-23 06:50:07'),
(301, 'DISABLE', 'users', 1793, 'Disabled account with ID 1793.', 1, '2025-04-23 06:50:42'),
(302, 'ENABLE', 'users', 1793, 'Enabled account with ID 1793.', 1, '2025-04-23 06:51:00'),
(303, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-23 06:51:12'),
(304, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-23 06:51:23'),
(305, 'CREATE', 'tickets', 26, 'Created ticket: Subject=payslip, Category=5, Description=blah', 1168, '2025-04-23 06:51:49'),
(306, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-23 06:51:54'),
(307, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-23 06:52:00'),
(308, 'ASSIGN', 'tickets', 26, 'Assigned ticket ID 26 to user HRD-RIANNA (ID: 3) with priority High.', 1, '2025-04-23 06:52:37'),
(309, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-23 06:52:43'),
(310, 'LOGIN', 'users', 3, 'User ID 3 logged in successfully.', 3, '2025-04-23 06:52:53'),
(311, 'CONFIRM', 'tickets', 26, 'Confirmed ticket ID 26 and updated status to \"In Progress\".', 3, '2025-04-23 06:53:21'),
(312, 'UPDATE', 'tickets', 26, 'Updated ticket ID 26 status to Resolved.', 3, '2025-04-23 06:53:39'),
(313, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-24 03:40:12'),
(314, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-24 01:25:32'),
(315, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-24 07:26:33'),
(316, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-24 01:29:51'),
(317, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-24 07:29:53'),
(318, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-24 08:17:05'),
(319, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-24 02:17:12'),
(320, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-24 08:17:13'),
(321, 'CREATE', '', 1, 'Created leave request: Type=Vacation, Start=2025-04-25, End=2025-04-25, Reason=asd', 1168, '2025-04-24 08:17:24'),
(322, 'CREATE', '', 2, 'Created leave request: Type=Vacation, Start=2025-04-25, End=2025-04-25, Reason=asd', 1168, '2025-04-24 08:19:25'),
(323, 'CREATE', '', 3, 'Created leave request: Type=Emergency Leave, Start=2025-04-25, End=2025-04-25, Reason=agargarg', 1168, '2025-04-24 08:23:52'),
(324, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-24 10:29:34'),
(325, 'INSERT', 'ticket_responses', 33, 'Added response to ticket ID 25: Testing message', 1168, '2025-04-25 02:26:30'),
(326, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-25 02:28:59'),
(327, 'INSERT', 'ticket_responses', 34, 'Added response to ticket ID 25: Testing message', 1168, '2025-04-25 02:29:14'),
(328, 'INSERT', 'ticket_responses', 35, 'Added response to ticket ID 26: dg', 1168, '2025-04-25 02:44:29'),
(329, 'INSERT', 'ticket_responses', 36, 'Added response to ticket ID 26: dg', 1168, '2025-04-25 02:45:37'),
(330, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-24 20:46:47'),
(331, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-25 02:46:55'),
(332, 'CREATE', 'users', 1794, 'Created user: Name=Earl Gerald Domingo, Email=earl@gmail.com, Role=Admin, Department=HR DEPARTMENT', 1, '2025-04-24 20:48:49'),
(333, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-25 03:25:28'),
(334, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-24 22:04:38'),
(335, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 04:05:00'),
(336, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-25 04:53:35'),
(337, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-24 22:53:43'),
(338, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 04:53:52'),
(339, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 05:54:02'),
(340, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 06:56:29'),
(341, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-25 01:18:09'),
(342, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-25 07:18:15'),
(343, 'CREATE', '', 10, 'Created leave request: Type=Vacation, Start=2025-04-26, End=2025-04-28, Reason=Vacation', 1168, '2025-04-25 07:21:21'),
(344, 'CREATE', '', 11, 'Created leave request: Type=Vacation, Start=2025-04-26, End=2025-04-28, Reason=Vacation', 1168, '2025-04-25 07:23:03'),
(345, 'CREATE', '', 12, 'Created leave request: Type=Vacation, Start=2025-04-26, End=2025-04-28, Reason=Vacation', 1168, '2025-04-25 07:23:06'),
(346, 'CREATE', '', 13, 'Created leave request: Type=Vacation, Start=2025-04-26, End=2025-04-28, Reason=Vacation', 1168, '2025-04-25 07:23:15'),
(347, 'CREATE', '', 14, 'Created leave request: Type=Vacation, Start=2025-04-26, End=2025-04-28, Reason=Vacation', 1168, '2025-04-25 07:23:54'),
(348, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-25 01:28:16'),
(349, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 07:28:27'),
(350, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 07:57:12'),
(351, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 09:04:22'),
(352, 'Insert', '', 16, 'Inserted leave request for employee ID 1794 with leave type Earned Leave Credit.', 1794, '2025-04-25 03:57:52'),
(353, 'INSERT', '', 17, 'Inserted leave request for employee ID 1794 with leave type Vacation.', 1794, '2025-04-25 04:00:54'),
(354, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 10:04:52'),
(355, 'Insert', '', 19, 'Inserted leave request for employee ID 1794 with leave type Vacation.', 1794, '2025-04-25 04:06:36'),
(356, 'INSER', '', 20, 'Inserted leave request for employee ID 1794 with leave type Earned Leave Credit.', 1794, '2025-04-25 04:07:46'),
(357, 'INSERT', '', 21, 'Inserted leave request for employee ID 1794 with leave type Emergency Leave.', 1794, '2025-04-25 04:08:38'),
(358, 'Insert', '', 22, 'Inserted leave request for employee ID 1794 with leave type Vacation.', 1794, '2025-04-25 04:12:44'),
(359, 'INSERT', '', 24, 'Inserted leave request for employee ID 1794 with leave type Service Incentive Leave.', 1794, '2025-04-25 04:16:58'),
(360, 'INSERT', '', 25, 'Inserted leave request for employee ID 1794 with leave type Emergency Leave.', 1794, '2025-04-25 04:21:29'),
(361, 'INSERT', '', 26, 'Inserted leave request for employee ID 1794 with leave type Service Incentive Leave.', 1794, '2025-04-25 04:23:34'),
(362, 'INSERT', 'leave_requests', 27, 'Inserted leave request for employee ID 1794 with leave type Emergency Leave.', 1794, '2025-04-25 04:27:04'),
(363, 'INSERT', 'leave_requests', 28, 'Inserted leave request for employee ID 1794 with leave type Vacation.', 1794, '2025-04-25 04:31:24'),
(364, 'INSERT', 'leave_requests', 29, 'Inserted leave request for employee ID 1794 with leave type Service Incentive Leave.', 1794, '2025-04-25 04:31:59'),
(365, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-25 04:33:23'),
(366, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-25 10:33:53'),
(367, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-25 10:34:09'),
(368, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-25 04:36:15'),
(369, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 10:36:22'),
(370, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-25 04:37:30'),
(371, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-25 10:37:37'),
(372, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-25 04:43:02'),
(373, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 10:44:55'),
(374, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-25 04:50:33'),
(375, 'LOGIN', 'users', 3, 'User ID 3 logged in successfully.', 3, '2025-04-25 10:50:38'),
(376, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-25 11:05:28'),
(377, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-25 05:05:53'),
(378, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-25 11:05:59'),
(379, 'ASSIGN', 'tickets', 27, 'Assigned ticket ID 27 to user HRD-RIANNA (ID: 3) with priority Low.', 1, '2025-04-25 05:06:11'),
(380, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-25 05:06:18'),
(381, 'LOGIN', 'users', 3, 'User ID 3 logged in successfully.', 3, '2025-04-25 11:06:28'),
(382, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-25 13:36:26'),
(383, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-26 02:04:24'),
(384, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-25 20:36:41'),
(385, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-26 02:37:02'),
(386, 'CREATE', 'tickets', 28, 'Created ticket: Subject=Printer, Category=1, Description=Printer 1052', 1168, '2025-04-25 20:52:43'),
(387, 'CREATE', 'tickets', 29, 'Created ticket: Subject=Testing 123, Category=1, Description=Printer Testing', 1168, '2025-04-25 21:00:11'),
(388, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-26 03:12:42'),
(389, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-25 21:37:28'),
(390, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-26 03:37:42'),
(391, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-26 05:31:02'),
(392, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-26 07:05:15'),
(393, 'APPROVE', 'leave_requests', 28, 'Approved leave request ID 28.', 1, '2025-04-26 01:55:40'),
(394, 'APPROVE', 'leave_requests', 28, 'Approved leave request ID 28.', 1, '2025-04-26 01:58:36'),
(395, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-26 08:21:22'),
(396, 'APPROVE', 'leave_requests', 28, 'Approved leave request ID 28.', 1, '2025-04-26 02:29:55'),
(397, 'APPROVE', 'leave_requests', 28, 'Approved leave request ID 28.', 1, '2025-04-26 02:32:18'),
(398, 'APPROVE', 'leave_requests', 28, 'Approved leave request ID 28.', 1, '2025-04-26 02:36:37'),
(399, 'APPROVE', 'leave_requests', 28, 'Approved leave request ID 28.', 1, '2025-04-26 02:40:39'),
(400, 'APPROVE', 'leave_requests', 28, 'Approved leave request ID 28.', 1, '2025-04-26 02:48:14'),
(401, 'APPROVE', 'leave_requests', 28, 'Approved leave request ID 28.', 1, '2025-04-26 03:04:31'),
(402, 'APPROVE', 'leave_requests', 29, 'Approved leave request ID 29.', 1, '2025-04-26 03:07:02'),
(403, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-26 03:13:57'),
(404, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-26 09:14:03'),
(405, 'CREATE', 'tickets', 30, 'Created ticket: Subject=Printer Sample, Category=1, Description=Printer connect to', 1168, '2025-04-26 04:35:04'),
(406, 'INSERT', 'leave_requests', 40, 'Inserted leave request for employee ID 1168 with leave type Vacation.', 1168, '2025-04-26 04:38:20'),
(407, 'INSERT', 'leave_requests', 41, 'Inserted leave request for employee ID 1168 with leave type Vacation.', 1168, '2025-04-26 04:51:51'),
(408, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-27 02:19:47'),
(409, 'CREATE', 'tickets', 31, 'Created ticket: Subject=something went wrong, Category=2, Description=Internet no connection', 1168, '2025-04-26 20:20:15'),
(410, 'INSERT', 'leave_requests', 42, 'Inserted leave request for employee ID 1168 with leave type Vacation.', 1168, '2025-04-26 20:26:09'),
(411, 'INSERT', 'leave_requests', 43, 'Inserted leave request for employee ID 1168 with leave type Earned Leave Credit.', 1168, '2025-04-26 20:26:56'),
(412, 'INSERT', 'leave_requests', 44, 'Inserted leave request for employee ID 1168 with leave type Sick Leave.', 1168, '2025-04-26 20:29:49'),
(413, 'INSERT', 'leave_requests', 45, 'Inserted leave request for employee ID 1168 with leave type Earned Leave Credit.', 1168, '2025-04-26 20:31:35'),
(414, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-26 20:31:45'),
(415, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-27 02:32:00'),
(416, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-26 20:36:25'),
(417, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 02:37:00'),
(418, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 03:37:52'),
(419, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 05:56:09'),
(420, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-27 00:02:44'),
(421, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-27 06:04:35'),
(422, 'INSERT', 'leave_requests', 46, 'Inserted leave request for employee ID 1168 with leave type Earned Leave Credit.', 1168, '2025-04-27 00:07:13'),
(423, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-04-27 00:07:22'),
(424, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 06:07:30'),
(425, 'INSERT', 'leave_requests', 47, 'Inserted leave request for employee ID 1 with leave type Birthday Leave.', 1, '2025-04-27 00:42:18'),
(426, 'INSERT', 'leave_requests', 48, 'Inserted leave request for employee ID 1 with leave type Birthday Leave.', 1, '2025-04-27 00:44:37'),
(427, 'INSERT', 'leave_requests', 49, 'Inserted leave request for employee ID 1 with leave type Birthday Leave.', 1, '2025-04-27 00:45:49'),
(428, 'INSERT', 'leave_requests', 50, 'Inserted leave request for employee ID 1 with leave type Maternity Leave.', 1, '2025-04-27 00:48:09'),
(429, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-27 00:51:17'),
(430, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-27 06:51:45'),
(431, 'INSERT', 'leave_requests', 51, 'Inserted leave request for employee ID 1794 with leave type Service Incentive Leave.', 1794, '2025-04-27 00:52:13'),
(432, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-27 06:57:28'),
(433, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-27 00:58:01'),
(434, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 07:12:18'),
(435, 'ASSIGN', 'tickets', 31, 'Assigned ticket ID 31 to user John Mico D. Intacto (ID: 1) with priority Low.', 1, '2025-04-27 01:35:20'),
(436, 'CONFIRM', 'tickets', 31, 'Confirmed ticket ID 31 and updated status to \"In Progress\".', 1, '2025-04-27 01:35:35'),
(437, 'INSERT', 'ticket_responses', 37, 'Added response to ticket ID 31: Test 123', 1, '2025-04-27 01:35:48'),
(438, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-27 01:36:45'),
(439, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-27 07:36:53'),
(440, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-27 01:37:05'),
(441, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-27 07:37:23'),
(442, 'CREATE', 'tickets', 32, 'Created ticket: Subject=Printer, Category=1, Description=Printer 1052', 1794, '2025-04-27 01:37:32'),
(443, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-27 01:40:04'),
(444, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 07:40:13'),
(445, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 08:03:20'),
(446, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 08:22:48'),
(447, 'INSERT', 'ticket_responses', 38, 'Added response to ticket ID 31: !aaa', 1, '2025-04-27 02:27:12'),
(448, 'INSERT', 'ticket_responses', 40, 'Added response to ticket ID 31: c008c4995dd6a756ec42b07e3300769e.jpg', 1, '2025-04-27 02:27:24'),
(449, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 09:03:56'),
(450, 'RESET', 'total_balance', 0, 'Reset all leave balances to 0', 1, '2025-04-27 03:23:48'),
(451, 'RESET', 'users', 0, 'Reset all leave balances to 0', 1, '2025-04-27 03:24:51'),
(452, 'RESET', '', 0, 'Reset all leave balances to 0', 1, '2025-04-27 03:26:28'),
(453, 'RESET', '', 0, 'Reset all leave balances to 0', 1, '2025-04-27 03:37:44'),
(454, 'RESET', '', 0, 'Reset all leave balances to 0', 1, '2025-04-27 03:42:31'),
(455, 'RESET', '', 0, 'Reset all leave balances to 0', 1, '2025-04-27 09:46:19'),
(456, 'RESET', '', 0, 'Reset all leave balances to 0', 1, '2025-04-27 09:48:59'),
(457, 'RESET', '', 0, 'Reset all leave balances to 0', 1, '2025-04-27 09:51:32'),
(458, 'RESET', 'used_balance', 0, 'Reset all leave balances to 0', 1, '2025-04-27 09:52:53'),
(459, 'RESET', 'total_balance', 0, 'Reset all leave balances to 0', 1, '2025-04-27 09:52:53'),
(460, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 10:03:52'),
(461, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-27 10:21:28'),
(462, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-28 01:45:32'),
(463, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-28 02:37:07'),
(464, 'UPDATE', 'users', 1794, 'Updated user details: Name=Earl Gerald Domingo, Email=earl@gmail.com, Role=Employee, Department=HR DEPARTMENT', 1, '2025-04-27 21:11:11'),
(465, 'UPDATE', 'users', 1794, 'Updated user details: Name=Earl Gerald Domingo, Email=earl@gmail.com, Role=HR, Department=HR DEPARTMENT', 1, '2025-04-27 21:11:26'),
(466, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-28 03:37:14'),
(467, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-28 03:39:48'),
(468, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-28 05:00:21'),
(469, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-28 07:35:51'),
(470, 'UPDATE', 'total_balance', 1794, 'Updated leave balances for user ID 1794: SL=15, SIL=12, ELC=0, BL=0, ML=15, PL=15, SPL=15, LWOP=0, BRL=15', 1, '2025-04-28 08:18:57'),
(471, 'UPDATE', 'total_balance', 1794, 'Updated leave balances for user ID 1794: SL=15, SIL=10, ELC=0, BL=0, ML=15, PL=15, SPL=15, LWOP=0, BRL=15', 1, '2025-04-28 08:25:58'),
(472, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-29 01:50:05'),
(473, 'INSERT', 'ticket_responses', 41, 'Added response to ticket ID 31: aaa', 1, '2025-04-29 01:50:19'),
(474, 'INSERT', 'ticket_responses', 43, 'Added response to ticket ID 31: c008c4995dd6a756ec42b07e3300769e.jpg', 1, '2025-04-29 01:50:27'),
(475, 'INSERT', 'leave_requests', 52, 'Inserted leave request for employee ID 1 with leave type Paternity Leave.', 1, '2025-04-29 02:25:41'),
(476, 'APPROVE_LEAVE', 'leave_requests', 52, 'Approved leave request ID 52 for employee ID 1. Leave type: Paternity Leave, Start date: 2025-04-30, End date: 2025-05-05, Days: 6.', 1, '2025-04-29 02:25:58'),
(477, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-29 03:01:01'),
(478, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-29 05:58:53'),
(479, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-04-28 23:59:09'),
(480, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-29 05:59:19'),
(481, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-29 00:08:57'),
(482, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-04-29 06:09:20'),
(483, 'INSERT', 'leave_requests', 53, 'Inserted leave request for employee ID 1168 with leave type Leave Without Pay.', 1168, '2025-04-29 06:13:22'),
(484, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-29 06:14:21'),
(485, 'APPROVE_LEAVE', 'leave_requests', 53, 'Approved leave request ID 53 for employee ID 1168. Leave type: Leave Without Pay, Start date: 2025-05-01, End date: 2025-05-07, Days: 7.', 1, '2025-04-29 07:13:21'),
(486, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-29 07:16:05'),
(487, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-29 07:49:09'),
(488, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-29 07:50:28'),
(489, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-29 07:51:22'),
(490, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-29 01:51:54'),
(491, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-29 07:52:02'),
(492, 'INSERT', 'leave_requests', 54, 'Inserted leave request for employee ID 1 with leave type Leave Without Pay.', 1, '2025-04-29 08:18:41'),
(493, 'APPROVE_LEAVE', 'leave_requests', 54, 'Approved leave request ID 54 for employee ID 1. Leave type: Leave Without Pay, Start date: 2025-04-30, End date: 2025-05-07, Days: 8.', 1, '2025-04-29 08:20:23'),
(494, 'INSERT', 'leave_requests', 55, 'Inserted leave request for employee ID 1 with leave type Leave Without Pay.', 1, '2025-04-29 08:21:41'),
(495, 'APPROVE_LEAVE', 'leave_requests', 55, 'Approved leave request ID 55 for employee ID 1. Leave type: Leave Without Pay, Start date: 2025-05-08, End date: 2025-05-10, Days: 3.', 1, '2025-04-29 08:21:56'),
(496, 'RESET', 'used_balance', 0, 'Reset all leave balances to 0', 1, '2025-04-29 08:22:58'),
(497, 'RESET', 'total_balance', 0, 'Reset all leave balances to 0', 1, '2025-04-29 08:22:58'),
(498, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-29 08:49:37'),
(499, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-04-29 12:51:38'),
(500, 'INSERT', 'leave_requests', 56, 'Inserted leave request for employee ID 1794 with leave type Leave Without Pay.', 1794, '2025-04-29 12:52:33'),
(501, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-04-29 07:16:20'),
(502, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-29 13:16:27'),
(503, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-29 13:52:05'),
(504, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-30 03:37:22'),
(505, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-30 05:38:16'),
(506, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-30 06:43:32'),
(507, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-30 07:49:29'),
(508, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-30 09:04:30'),
(509, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-30 10:05:25'),
(510, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-30 14:08:36'),
(511, 'UPDATE', 'total_balance', 1794, 'Updated leave balances for user ID 1794: SL=5, SIL=5, ELC=1, MIL=0, ML=105, PL=7, SPL=5, BRL=5', 1, '2025-04-30 14:12:19'),
(512, 'UPDATE', 'total_balance', 1794, 'Updated leave balances for user ID 1794: SL=5, SIL=5, ELC=1, MIL=0, ML=105, PL=7, SPL=5, BRL=5', 1, '2025-04-30 14:12:46'),
(513, 'UPDATE', 'total_balance', 1794, 'Updated leave balances for user ID 1794: SL=10, SIL=5, ELC=1, MIL=0, ML=105, PL=7, SPL=5, BRL=5', 1, '2025-04-30 14:15:04'),
(514, 'UPDATE', 'total_balance', 1794, 'Updated leave balances for user ID 1794: SL=10, SIL=5, ELC=1, MIL=0, ML=105, PL=7, SPL=5, BRL=5', 1, '2025-04-30 14:21:56'),
(515, 'UPDATE', 'total_balance', 1794, 'Updated leave balances for user ID 1794: SL=10, SIL=5, ELC=1, MIL=3, ML=105, PL=7, SPL=5, BRL=5', 1, '2025-04-30 14:31:59'),
(516, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-04-30 15:09:01'),
(517, 'APPROVE_LEAVE', 'leave_requests', 56, 'Approved leave request ID 56 for employee ID 1794. Leave type: Leave Without Pay, Start date: 2025-04-30, End date: 2025-05-30, Days: 31.', 1, '2025-04-30 15:25:16'),
(518, 'UPDATE', 'users', 1168, 'Updated user details: Name=DOMINIC, Email=domrmdaquiz01@gmail.com, Role=Employee, Department=MIS/IT DEPARTMENT', 1, '2025-04-30 15:55:22'),
(519, 'DISABLE', 'users', 2, 'Disabled account with ID 2.', 1, '2025-04-30 15:58:39'),
(520, 'ENABLE', 'users', 2, 'Enabled account with ID 2.', 1, '2025-04-30 15:59:28'),
(521, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-01 01:13:53'),
(522, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-01 06:05:41'),
(523, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-01 07:13:12'),
(524, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-01 07:49:29'),
(525, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-01 08:13:32'),
(526, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-01 10:14:00'),
(527, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-02 01:35:39'),
(528, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-02 06:17:21'),
(529, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-02 01:17:01'),
(530, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-02 07:17:11'),
(531, 'INSERT', 'leave_requests', 82, 'Inserted leave request for employee ID 1 with leave type Solo Parent Leave.', 1, '2025-05-02 07:20:48'),
(532, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-02 01:28:58'),
(533, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-02 07:29:08'),
(534, 'INSERT', 'ticket_responses', 44, 'Added response to ticket ID 32: ahiashasdhasd', 1794, '2025-05-02 07:29:19'),
(535, 'INSERT', 'ticket_responses', 45, 'Added response to ticket ID 32: ahiashasdhasd', 1794, '2025-05-02 07:34:44'),
(536, 'INSERT', 'ticket_responses', 46, 'Added response to ticket ID 32: aaa', 1794, '2025-05-02 07:54:36'),
(537, 'INSERT', 'ticket_responses', 47, 'Added response to ticket ID 32: asnkladshjkadshjklads', 1794, '2025-05-02 07:57:35'),
(538, 'INSERT', 'attachments', 11, 'Added attachment to ticket ID 32: assets/uploads/c008c4995dd6a756ec42b07e3300769e.jpg', 1794, '2025-05-02 08:03:37'),
(539, 'INSERT', 'ticket_responses', 48, 'Added response to ticket ID 32: c008c4995dd6a756ec42b07e3300769e.jpg', 1794, '2025-05-02 08:03:37'),
(540, 'INSERT', 'attachments', 12, 'Added attachment to ticket ID 32: assets/uploads/32.jpg', 1794, '2025-05-02 08:11:29'),
(541, 'INSERT', 'ticket_responses', 49, 'Added response to ticket ID 32: 32.jpg', 1794, '2025-05-02 08:11:29'),
(542, 'INSERT', 'attachments', 13, 'Added attachment to ticket ID 32: assets/uploads/3.jpg', 1794, '2025-05-02 08:20:36'),
(543, 'INSERT', 'ticket_responses', 50, 'Added response to ticket ID 32: 3.jpg', 1794, '2025-05-02 08:20:36'),
(544, 'INSERT', 'ticket_responses', 51, 'Added response to ticket ID 32: asghasdhgads', 1794, '2025-05-02 08:26:20'),
(545, 'INSERT', 'attachments', 14, 'Added attachment to ticket ID 32: assets/uploads/3.jpg', 1794, '2025-05-02 08:26:58'),
(546, 'INSERT', 'ticket_responses', 52, 'Added response to ticket ID 32: 3.jpg', 1794, '2025-05-02 08:26:58'),
(547, 'INSERT', 'attachments', 15, 'Added attachment to ticket ID 32: assets/uploads/wallpaper ae86 gif.gif', 1794, '2025-05-02 08:27:13'),
(548, 'INSERT', 'ticket_responses', 53, 'Added response to ticket ID 32: wallpaper ae86 gif.gif', 1794, '2025-05-02 08:27:13'),
(549, 'INSERT', 'attachments', 16, 'Added attachment to ticket ID 32: hrts/assets/uploads/Ae86 static wallpaper.jpg', 1794, '2025-05-02 08:28:00'),
(550, 'INSERT', 'ticket_responses', 54, 'Added response to ticket ID 32: Ae86 static wallpaper.jpg', 1794, '2025-05-02 08:28:00'),
(551, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-02 08:29:33'),
(552, 'INSERT', 'attachments', 17, 'Added attachment to ticket ID 32: assets/uploads/Ae86 static wallpaper.jpg', 1794, '2025-05-02 08:30:37'),
(553, 'INSERT', 'ticket_responses', 55, 'Added response to ticket ID 32: Ae86 static wallpaper.jpg', 1794, '2025-05-02 08:30:37'),
(554, 'INSERT', 'leave_requests', 83, 'Inserted leave request for employee ID 1794 with leave type Paternity Leave.', 1794, '2025-05-02 08:39:04'),
(555, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-02 02:55:23'),
(556, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-02 08:55:30'),
(557, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-02 02:55:35'),
(558, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-02 08:55:41'),
(559, 'APPROVE_LEAVE', 'leave_requests', 83, 'Approved leave request ID 83 for employee ID 1794. Leave type: Paternity Leave, Start date: 2025-05-03, End date: 2025-05-06, Days: 4.', 1794, '2025-05-02 08:58:49'),
(560, 'INSERT', 'leave_requests', 84, 'Inserted leave request for employee ID 1794 with leave type Leave Without Pay.', 1794, '2025-05-02 09:00:46'),
(561, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-02 03:11:42'),
(562, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-02 09:11:49'),
(563, 'CREATE', 'tickets', 33, 'Created ticket: Subject=Testing 123, Category=5, Description=PS', 1794, '2025-05-02 09:12:07'),
(564, 'INSERT', 'leave_requests', 85, 'Inserted leave request for employee ID 1794 with leave type Leave Without Pay.', 1794, '2025-05-02 09:15:03'),
(565, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-02 03:15:10'),
(566, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-02 09:15:19'),
(567, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-02 03:15:24'),
(568, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-02 09:15:52'),
(569, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-02 23:39:46'),
(570, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-02 17:42:41'),
(571, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-02 23:43:09'),
(572, 'INSERT', 'ticket_responses', 56, 'Added response to ticket ID 33: Testin', 1794, '2025-05-02 23:43:41'),
(573, 'INSERT', 'attachments', 18, 'Added attachment to ticket ID 33: assets/uploads/c008c4995dd6a756ec42b07e3300769e.jpg', 1794, '2025-05-02 23:44:31'),
(574, 'INSERT', 'ticket_responses', 57, 'Added response to ticket ID 33: c008c4995dd6a756ec42b07e3300769e.jpg', 1794, '2025-05-02 23:44:31'),
(575, 'INSERT', 'ticket_responses', 58, 'Added response to ticket ID 33: aaa', 1794, '2025-05-03 00:03:28'),
(576, 'INSERT', 'attachments', 19, 'Added attachment to ticket ID 33: assets/uploads/c008c4995dd6a756ec42b07e3300769e.jpg', 1794, '2025-05-03 00:03:41'),
(577, 'INSERT', 'ticket_responses', 59, 'Added response to ticket ID 33: c008c4995dd6a756ec42b07e3300769e.jpg', 1794, '2025-05-03 00:03:41'),
(578, 'INSERT', 'ticket_responses', 60, 'Added response to ticket ID 33: TEsting', 1794, '2025-05-03 00:04:06'),
(579, 'INSERT', 'attachments', 20, 'Added attachment to ticket ID 33: assets/uploads/Ae86 static wallpaper.jpg', 1794, '2025-05-03 00:04:24'),
(580, 'INSERT', 'ticket_responses', 61, 'Added response to ticket ID 33: Ae86 static wallpaper.jpg', 1794, '2025-05-03 00:04:24'),
(581, 'INSERT', 'ticket_responses', 62, 'Added response to ticket ID 33: Testing', 1794, '2025-05-03 00:09:15'),
(582, 'INSERT', 'attachments', 21, 'Added attachment to ticket ID 33: assets/uploads/32.jpg', 1794, '2025-05-03 00:09:34'),
(583, 'INSERT', 'ticket_responses', 63, 'Added response to ticket ID 33: 32.jpg', 1794, '2025-05-03 00:09:34'),
(584, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-02 18:09:56'),
(585, 'LOGIN', 'users', 1793, 'User ID 1793 logged in successfully.', 1793, '2025-05-03 00:10:11'),
(586, 'LOGOUT', 'users', 1793, 'User ID 1793 logged out successfully.', 1793, '2025-05-02 18:10:27'),
(587, 'LOGIN', 'users', 3, 'User ID 3 logged in successfully.', 3, '2025-05-03 00:10:33'),
(588, 'CONFIRM', 'tickets', 27, 'Confirmed ticket ID 27 and updated status to \"In Progress\".', 3, '2025-05-03 00:10:42'),
(589, 'INSERT', 'ticket_responses', 64, 'Added response to ticket ID 27: Testing', 3, '2025-05-03 00:10:54'),
(590, 'INSERT', 'attachments', 22, 'Added attachment to ticket ID 27: assets/uploads/Ae86 static wallpaper.jpg', 3, '2025-05-03 00:11:03'),
(591, 'INSERT', 'ticket_responses', 65, 'Added response to ticket ID 27: Ae86 static wallpaper.jpg', 3, '2025-05-03 00:11:03'),
(592, 'LOGOUT', 'users', 3, 'User ID 3 logged out successfully.', 3, '2025-05-02 18:11:13'),
(593, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-05-03 00:11:19'),
(594, 'INSERT', 'ticket_responses', 66, 'Added response to ticket ID 27: Testing response without error', 1168, '2025-05-03 00:11:40'),
(595, 'INSERT', 'attachments', 23, 'Added attachment to ticket ID 27: assets/uploads/wallpaper ae86 gif.gif', 1168, '2025-05-03 00:11:52'),
(596, 'INSERT', 'ticket_responses', 67, 'Added response to ticket ID 27: wallpaper ae86 gif.gif', 1168, '2025-05-03 00:11:52'),
(597, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-04 10:49:54'),
(598, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-04 06:47:51'),
(599, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-04 12:48:02'),
(600, 'INSERT', 'leave_requests', 97, 'Inserted leave request for employee ID 1794 with leave type Leave Without Pay.', 1794, '2025-05-04 13:07:05'),
(601, 'INSERT', 'leave_requests', 98, 'Inserted leave request for employee ID 1794 with leave type Leave Without Pay.', 1794, '2025-05-04 13:11:09'),
(602, 'INSERT', 'leave_requests', 99, 'Inserted leave request for employee ID 1794 with leave type Sick Leave.', 1794, '2025-05-04 13:16:23'),
(603, 'INSERT', 'leave_attachments', 99, 'Inserted leave attachment approval for employee ID 1794 with leave type Sick Leave.', 1794, '2025-05-04 13:16:23'),
(604, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-04 07:21:01'),
(605, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-04 13:21:10'),
(606, 'INSERT', 'leave_requests', 100, 'Inserted leave request for employee ID 1 with leave type Leave Without Pay.', 1, '2025-05-04 13:21:46'),
(607, 'INSERT', 'leave_attachments', 100, 'Inserted leave attachment approval for employee ID 1 with leave type Leave Without Pay.', 1, '2025-05-04 13:21:46'),
(608, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-04 13:58:31'),
(609, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-05 06:06:20'),
(610, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-06 06:23:12'),
(611, 'INSERT', 'ticket_responses', 68, 'Added response to ticket ID 31: asdsdsaasd', 1, '2025-05-06 06:36:27'),
(612, 'INSERT', 'attachments', 24, 'Added attachment to ticket ID 31: assets/uploads/total_balance.sql', 1, '2025-05-06 06:36:35'),
(613, 'INSERT', 'ticket_responses', 69, 'Added response to ticket ID 31: total_balance.sql', 1, '2025-05-06 06:36:35'),
(614, 'INSERT', 'attachments', 25, 'Added attachment to ticket ID 31: assets/uploads/total_balance.sql', 1, '2025-05-06 06:36:47'),
(615, 'INSERT', 'ticket_responses', 70, 'Added response to ticket ID 31: total_balance.sql', 1, '2025-05-06 06:36:47'),
(616, 'INSERT', 'ticket_responses', 71, 'Added response to ticket ID 31: asasd', 1, '2025-05-06 06:38:08'),
(617, 'INSERT', 'ticket_responses', 72, 'Added response to ticket ID 31: adshjahjadsas', 1, '2025-05-06 06:38:46'),
(618, 'INSERT', 'ticket_responses', 73, 'Added response to ticket ID 31: adshjahjadsas', 1, '2025-05-06 06:38:50'),
(619, 'INSERT', 'ticket_responses', 74, 'Added response to ticket ID 31: adshjahjadsas', 1, '2025-05-06 06:38:51'),
(620, 'INSERT', 'ticket_responses', 75, 'Added response to ticket ID 31: adshjahjadsas', 1, '2025-05-06 06:38:51'),
(621, 'INSERT', 'ticket_responses', 76, 'Added response to ticket ID 31: adshjahjadsas', 1, '2025-05-06 06:38:52'),
(622, 'INSERT', 'ticket_responses', 77, 'Added response to ticket ID 31: adshjahjadsas', 1, '2025-05-06 06:38:53'),
(623, 'INSERT', 'ticket_responses', 78, 'Added response to ticket ID 31: acadsadsads', 1, '2025-05-06 06:39:14'),
(624, 'INSERT', 'ticket_responses', 79, 'Added response to ticket ID 31: asdsasad', 1, '2025-05-06 06:40:01'),
(625, 'INSERT', 'attachments', 26, 'Added attachment to ticket ID 31: assets/uploads/total_balance.sql', 1, '2025-05-06 06:40:09'),
(626, 'INSERT', 'ticket_responses', 80, 'Added response to ticket ID 31: total_balance.sql', 1, '2025-05-06 06:40:09'),
(627, 'INSERT', 'attachments', 27, 'Added attachment to ticket ID 31: assets/uploads/total_balance.sql', 1, '2025-05-06 06:42:13'),
(628, 'INSERT', 'ticket_responses', 81, 'Added response to ticket ID 31: total_balance.sql', 1, '2025-05-06 06:42:13'),
(629, 'INSERT', 'ticket_responses', 82, 'Added response to ticket ID 31: dasadsdsaads', 1, '2025-05-06 06:42:16'),
(630, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-06 07:34:11'),
(631, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-06 15:47:33'),
(632, 'INSERT', 'ticket_responses', 83, 'Added response to ticket ID 31: assadda', 1, '2025-05-06 16:00:24'),
(633, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-07 01:21:48'),
(634, 'INSERT', 'ticket_responses', 84, 'Added response to ticket ID 31: adsasdadsdsa', 1, '2025-05-07 01:22:00'),
(635, 'INSERT', 'attachments', 28, 'Added attachment to ticket ID 31: assets/uploads/total_balance.sql', 1, '2025-05-07 01:22:07'),
(636, 'INSERT', 'ticket_responses', 85, 'Added response to ticket ID 31: total_balance.sql', 1, '2025-05-07 01:22:07'),
(637, 'INSERT', 'ticket_responses', 86, 'Added response to ticket ID 31: asads', 1, '2025-05-07 01:22:10'),
(638, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-07 02:03:53'),
(639, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-07 02:12:53'),
(640, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-07 09:39:38'),
(641, 'REJECT LEAVE REQUEST', 'leave_requests', 100, 'Rejected leave request for Leave ID 100.', 1, '2025-05-07 09:39:57'),
(642, 'INSERT', '', 2, 'Added response to leave request ID 99: adshjkasdhjkads', 1, '2025-05-07 10:06:43'),
(643, 'INSERT', '', 3, 'Added response to leave request ID 99: adsjnkladshjasd', 1, '2025-05-07 10:06:44'),
(644, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-07 10:35:11'),
(645, 'INSERT', 'attachments', 29, 'Added attachment to ticket ID 33: assets/uploads/total_balance.sql', 1, '2025-05-07 10:46:01'),
(646, 'INSERT', 'ticket_responses', 87, 'Added response to ticket ID 33: total_balance.sql', 1, '2025-05-07 10:46:02'),
(647, 'INSERT', 'ticket_responses', 88, 'Added response to ticket ID 33: total_balance.sql', 1, '2025-05-07 11:00:16'),
(648, 'INSERT', 'leave_attachments', 5, 'Added attachment to leave ID 99: assets/uploads/1746616258_sample profile.jpg', 1, '2025-05-07 11:10:58'),
(649, 'INSERT', '', 4, 'Added response to leave request ID 99: sample profile.jpg', 1, '2025-05-07 11:10:58'),
(650, 'INSERT', 'leave_attachments', 6, 'Added attachment to leave ID 99: assets/uploads/1746616369_gt86.jpg', 1, '2025-05-07 11:12:49'),
(651, 'INSERT', '', 5, 'Added response to leave request ID 99: gt86.jpg', 1, '2025-05-07 11:12:49'),
(652, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-07 14:01:42'),
(653, 'REJECT LEAVE REQUEST', 'leave_requests', 99, 'Rejected leave request for Leave ID 99.', 1, '2025-05-07 14:06:05'),
(654, 'INSERT', 'leave_requests', 101, 'Inserted leave request for employee ID 1 with leave type Bereavement Leave.', 1, '2025-05-07 14:13:35'),
(655, 'INSERT', 'leave_attachments', 101, 'Inserted leave attachment approval for employee ID 1 with leave type Bereavement Leave.', 1, '2025-05-07 14:13:35'),
(656, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-07 08:27:11'),
(657, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-07 14:27:19'),
(658, 'INSERT', 'ticket_responses', 89, 'Added response to ticket ID 31: adsdasdas', 1, '2025-05-07 14:48:05'),
(659, 'INSERT', 'ticket_responses', 90, 'Added response to ticket ID 27: Testing', 1, '2025-05-07 15:26:19'),
(660, 'INSERT', 'ticket_responses', 91, 'Added response to ticket ID 27: dsaadsjnbkadshjkads hjkadshjkads', 1, '2025-05-07 15:26:29'),
(661, 'INSERT', 'ticket_responses', 92, 'Added response to ticket ID 33: asddasadsads', 1, '2025-05-07 15:26:55'),
(662, 'INSERT', 'ticket_responses', 93, 'Added response to ticket ID 27: Testing', 1, '2025-05-07 15:27:09'),
(663, 'INSERT', 'ticket_responses', 94, 'Added response to ticket ID 27: 1231', 1, '2025-05-07 15:27:09'),
(664, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-07 09:27:30'),
(665, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-05-07 15:28:15'),
(666, 'INSERT', 'ticket_responses', 95, 'Added response to ticket ID 27: Tesginaa', 1168, '2025-05-07 15:28:41'),
(667, 'INSERT', 'ticket_responses', 96, 'Added response to ticket ID 27: Tesginaa', 1168, '2025-05-07 15:28:44'),
(668, 'INSERT', 'ticket_responses', 97, 'Added response to ticket ID 27: Tesginaa', 1168, '2025-05-07 15:28:45'),
(669, 'INSERT', 'ticket_responses', 98, 'Added response to ticket ID 27: Tesginaa', 1168, '2025-05-07 15:28:45'),
(670, 'INSERT', 'ticket_responses', 99, 'Added response to ticket ID 27: Tesginaa', 1168, '2025-05-07 15:28:46'),
(671, 'INSERT', 'ticket_responses', 100, 'Added response to ticket ID 27: Tesginaa', 1168, '2025-05-07 15:28:46'),
(672, 'INSERT', 'attachments', 30, 'Added attachment to ticket ID 27: assets/uploads/PAGKAKALAMEG.mp4', 1168, '2025-05-07 15:28:57'),
(673, 'INSERT', 'ticket_responses', 101, 'Added response to ticket ID 27: PAGKAKALAMEG.mp4', 1168, '2025-05-07 15:28:57'),
(674, 'INSERT', 'ticket_responses', 102, 'Added response to ticket ID 27: PAGKAKALAMEG.mp4', 1168, '2025-05-07 15:28:59'),
(675, 'INSERT', 'ticket_responses', 103, 'Added response to ticket ID 27: PAGKAKALAMEG.mp4', 1168, '2025-05-07 15:29:00'),
(676, 'INSERT', 'ticket_responses', 104, 'Added response to ticket ID 27: PAGKAKALAMEG.mp4', 1168, '2025-05-07 15:29:00'),
(677, 'INSERT', 'ticket_responses', 105, 'Added response to ticket ID 27: PAGKAKALAMEG.mp4', 1168, '2025-05-07 15:29:00'),
(678, 'INSERT', 'ticket_responses', 106, 'Added response to ticket ID 27: PAGKAKALAMEasdsasG.mp4', 1168, '2025-05-07 15:29:07'),
(679, 'INSERT', 'attachments', 31, 'Added attachment to ticket ID 27: assets/uploads/sample profile.jpg', 1168, '2025-05-07 15:29:21'),
(680, 'INSERT', 'ticket_responses', 107, 'Added response to ticket ID 27: sample profile.jpg', 1168, '2025-05-07 15:29:21'),
(681, 'LOGOUT', 'users', 1168, 'User ID 1168 logged out successfully.', 1168, '2025-05-07 09:30:05'),
(682, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-07 15:30:12'),
(683, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-07 09:38:08'),
(684, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-07 15:38:17'),
(685, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-07 16:47:52'),
(686, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-07 23:24:18'),
(687, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-07 17:25:00'),
(688, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-07 23:25:36'),
(689, 'INSERT', 'ticket_responses', 108, 'Added response to ticket ID 33: dasdadsasd', 1794, '2025-05-08 00:10:04'),
(690, 'INSERT', 'ticket_responses', 109, 'Added response to ticket ID 33: asdasdasdad', 1794, '2025-05-08 00:10:15'),
(691, 'INSERT', 'ticket_responses', 110, 'Added response to ticket ID 33: asdasdasdadad w asd ad', 1794, '2025-05-08 00:10:18'),
(692, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-08 00:58:41'),
(693, 'INSERT', 'ticket_responses', 111, 'Added response to ticket ID 33: Testing', 1794, '2025-05-08 01:06:35'),
(694, 'INSERT', 'ticket_responses', 112, 'Added response to ticket ID 33: Testing', 1794, '2025-05-08 01:06:41'),
(695, 'INSERT', 'ticket_responses', 113, 'Added response to ticket ID 33: Testing Tesing 123', 1794, '2025-05-08 01:06:48'),
(696, 'INSERT', 'ticket_responses', 114, 'Added response to ticket ID 33: Testing Tesing 123', 1794, '2025-05-08 01:06:50'),
(697, 'INSERT', 'ticket_responses', 115, 'Added response to ticket ID 33: Testing Tesing 123', 1794, '2025-05-08 01:06:52'),
(698, 'INSERT', 'ticket_responses', 116, 'Added response to ticket ID 33: adsasdsa', 1794, '2025-05-08 01:06:58'),
(699, 'INSERT', '', 6, 'Added response to leave request ID 99: Testing', 1794, '2025-05-08 01:11:33'),
(700, 'INSERT', 'leave_attachments', 8, 'Added attachment to leave ID 99: assets/uploads/1746666753_sample profile.jpg', 1794, '2025-05-08 01:12:33'),
(701, 'INSERT', '', 7, 'Added response to leave request ID 99: sample profile.jpg', 1794, '2025-05-08 01:12:33'),
(702, 'INSERT', 'leave_attachments', 9, 'Added attachment to leave ID 99: assets/uploads/1746666773_gt86.jpg', 1794, '2025-05-08 01:12:53'),
(703, 'INSERT', '', 8, 'Added response to leave request ID 99: gt86.jpg', 1794, '2025-05-08 01:12:53'),
(704, 'INSERT', 'attachments', 32, 'Added attachment to ticket ID 33: assets/uploads/1746666813_sample profile.jpg', 1794, '2025-05-08 01:13:33'),
(705, 'INSERT', 'ticket_responses', 118, 'Added response to ticket ID 33: sample profile.jpg', 1794, '2025-05-08 01:13:33'),
(706, 'INSERT', 'leave_attachments', 10, 'Added attachment to leave ID 99: assets/uploads/sample profile.jpg', 1794, '2025-05-08 01:15:08'),
(707, 'INSERT', '', 9, 'Added response to leave request ID 99: sample profile.jpg', 1794, '2025-05-08 01:15:08'),
(708, 'INSERT', 'ticket_responses', 119, 'Added response to ticket ID 33: dasda', 1794, '2025-05-08 01:22:10');
INSERT INTO `audit_trail` (`id`, `action_type`, `affected_table`, `affected_id`, `details`, `user_id`, `timestamp`) VALUES
(709, 'INSERT', 'ticket_responses', 120, 'Added response to ticket ID 33: Testing lwop', 1794, '2025-05-08 01:22:19'),
(710, 'INSERT', 'ticket_responses', 121, 'Added response to ticket ID 33: Testginasda2', 1794, '2025-05-08 01:32:25'),
(711, 'INSERT', 'ticket_responses', 122, 'Added response to ticket ID 32: Testins', 1794, '2025-05-08 01:57:20'),
(712, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-08 02:00:12'),
(713, 'INSERT', 'leave_requests', 105, 'Inserted leave request for employee ID 1794 with leave type Leave Without Pay.', 1794, '2025-05-08 02:19:50'),
(714, 'INSERT', 'leave_attachments', 105, 'Inserted leave attachment approval for employee ID 1794 with leave type Leave Without Pay.', 1794, '2025-05-08 02:19:50'),
(715, 'INSERT', '', 10, 'Added response to leave request ID 105: TEsginasda', 1794, '2025-05-08 02:25:57'),
(716, 'INSERT', 'leave_attachments', 12, 'Added attachment to leave ID 105: assets/uploads/gt86.jpg', 1794, '2025-05-08 02:26:10'),
(717, 'INSERT', '', 11, 'Added response to leave request ID 105: gt86.jpg', 1794, '2025-05-08 02:26:10'),
(718, 'INSERT', 'attachments', 33, 'Added attachment to ticket ID 33: assets/uploads/gt 86.webp', 1794, '2025-05-08 02:29:55'),
(719, 'INSERT', 'ticket_responses', 123, 'Added response to ticket ID 33: gt 86.webp', 1794, '2025-05-08 02:29:55'),
(720, 'INSERT', 'attachments', 34, 'Added attachment to ticket ID 33: assets/uploads/gt86.jpg', 1794, '2025-05-08 02:31:33'),
(721, 'INSERT', 'ticket_responses', 124, 'Added response to ticket ID 33: gt86.jpg', 1794, '2025-05-08 02:31:33'),
(722, 'INSERT', '', 12, 'Added response to leave request ID 105: adsghjkadsghjkasd', 1794, '2025-05-08 02:39:56'),
(723, 'INSERT', '', 13, 'Added response to leave request ID 105: TEsoasda sd', 1794, '2025-05-08 02:40:04'),
(724, 'INSERT', '', 14, 'Added response to leave request ID 105: adsjkl;asjkl;ajkl;ads', 1794, '2025-05-08 02:40:08'),
(725, 'INSERT', 'leave_attachments', 13, 'Added attachment to leave ID 105: assets/uploads/gt 86.webp', 1794, '2025-05-08 02:40:16'),
(726, 'INSERT', '', 15, 'Added response to leave request ID 105: gt 86.webp', 1794, '2025-05-08 02:40:16'),
(727, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-07 20:41:06'),
(728, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-08 02:41:16'),
(729, 'INSERT', '', 16, 'Added response to leave request ID 105: TEsaosdas', 1, '2025-05-08 02:41:26'),
(730, 'INSERT', '', 17, 'Added response to leave request ID 105: TEsisasdasds', 1, '2025-05-08 02:43:53'),
(731, 'INSERT', '', 18, 'Added response to leave request ID 105: asdadads', 1, '2025-05-08 02:43:57'),
(732, 'INSERT', 'leave_attachments', 14, 'Added attachment to leave ID 105: assets/uploads/sample profile.jpg', 1, '2025-05-08 02:44:07'),
(733, 'INSERT', '', 19, 'Added response to leave request ID 105: sample profile.jpg', 1, '2025-05-08 02:44:07'),
(734, 'INSERT', '', 20, 'Added response to leave request ID 54: TREsasdsa', 1, '2025-05-08 02:47:09'),
(735, 'INSERT', '', 21, 'Added response to leave request ID 52: ashjkadshjkads', 1, '2025-05-08 02:47:45'),
(736, 'INSERT', '', 22, 'Added response to leave request ID 105: TEsadsa', 1, '2025-05-08 02:47:57'),
(737, 'INSERT', '', 23, 'Added response to leave request ID 105: asdsaghjkasdjghkasd', 1, '2025-05-08 02:48:09'),
(738, 'INSERT', '', 24, 'Added response to leave request ID 105: asdasdas', 1, '2025-05-08 02:48:13'),
(739, 'INSERT', '', 25, 'Added response to leave request ID 105: TEasda', 1, '2025-05-08 02:48:16'),
(740, 'INSERT', '', 26, 'Added response to leave request ID 105: assssssss', 1, '2025-05-08 02:48:24'),
(741, 'INSERT', '', 27, 'Added response to leave request ID 105: TEssdisds', 1, '2025-05-08 02:48:35'),
(742, 'INSERT', '', 28, 'Added response to leave request ID 105: adasd', 1, '2025-05-08 02:48:39'),
(743, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-07 21:01:35'),
(744, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-08 03:01:42'),
(745, 'INSERT', '', 29, 'Added response to leave request ID 105: asdasasd', 1794, '2025-05-08 03:01:49'),
(746, 'INSERT', '', 30, 'Added response to leave request ID 105: Tesings', 1794, '2025-05-08 03:01:55'),
(747, 'INSERT', '', 31, 'Added response to leave request ID 105: TEssds', 1794, '2025-05-08 03:02:09'),
(748, 'INSERT', '', 32, 'Added response to leave request ID 105: sssssss', 1794, '2025-05-08 03:02:13'),
(749, 'INSERT', '', 33, 'Added response to leave request ID 105: ssssss', 1794, '2025-05-08 03:02:14'),
(750, 'INSERT', '', 34, 'Added response to leave request ID 105: s', 1794, '2025-05-08 03:02:14'),
(751, 'INSERT', '', 35, 'Added response to leave request ID 105: s', 1794, '2025-05-08 03:02:14'),
(752, 'INSERT', '', 36, 'Added response to leave request ID 105: s', 1794, '2025-05-08 03:02:15'),
(753, 'INSERT', '', 37, 'Added response to leave request ID 105: s', 1794, '2025-05-08 03:02:15'),
(754, 'INSERT', '', 38, 'Added response to leave request ID 105: s', 1794, '2025-05-08 03:02:15'),
(755, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-07 21:08:02'),
(756, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-08 03:08:11'),
(757, 'INSERT', '', 39, 'Added response to leave request ID 105: Tessdsdsdsds', 1, '2025-05-08 03:08:18'),
(758, 'INSERT', '', 40, 'Added response to leave request ID 105: adsadshjksadhjkdsahjads', 1, '2025-05-08 03:08:30'),
(759, 'INSERT', '', 41, 'Added response to leave request ID 105: adsadsads', 1, '2025-05-08 03:10:56'),
(760, 'INSERT', '', 42, 'Added response to leave request ID 105: Tesinsdsd', 1, '2025-05-08 03:11:03'),
(761, 'INSERT', '', 43, 'Added response to leave request ID 105: asdasdsadsa', 1, '2025-05-08 03:11:07'),
(762, 'INSERT', '', 44, 'Added response to leave request ID 105: rtesdsd', 1, '2025-05-08 03:11:13'),
(763, 'INSERT', '', 45, 'Added response to leave request ID 105: adaads', 1, '2025-05-08 03:18:12'),
(764, 'INSERT', '', 46, 'Added response to leave request ID 105: dsdsds', 1, '2025-05-08 03:18:16'),
(765, 'INSERT', '', 47, 'Added response to leave request ID 105: ddd', 1, '2025-05-08 03:18:18'),
(766, 'INSERT', '', 48, 'Added response to leave request ID 105: dd', 1, '2025-05-08 03:18:20'),
(767, 'INSERT', '', 49, 'Added response to leave request ID 105: d', 1, '2025-05-08 03:18:21'),
(768, 'INSERT', '', 50, 'Added response to leave request ID 105: d', 1, '2025-05-08 03:18:25'),
(769, 'INSERT', '', 51, 'Added response to leave request ID 105: d', 1, '2025-05-08 03:18:26'),
(770, 'INSERT', '', 52, 'Added response to leave request ID 105: 12344', 1, '2025-05-08 03:21:23'),
(771, 'INSERT', '', 53, 'Added response to leave request ID 105: 111', 1, '2025-05-08 03:21:27'),
(772, 'INSERT', '', 54, 'Added response to leave request ID 105: adsadsas', 1, '2025-05-08 03:23:50'),
(773, 'INSERT', '', 55, 'Added response to leave request ID 105: s', 1, '2025-05-08 03:23:53'),
(774, 'INSERT', 'leave_attachments', 15, 'Added attachment to leave ID 105: assets/uploads/Screenshot 2024-11-20 211640.png', 1, '2025-05-08 03:24:15'),
(775, 'INSERT', '', 56, 'Added response to leave request ID 105: Screenshot 2024-11-20 211640.png', 1, '2025-05-08 03:24:15'),
(776, 'INSERT', 'leave_attachments', 16, 'Added attachment to leave ID 105: assets/uploads/Screenshot 2024-11-20 212130.png', 1, '2025-05-08 03:24:42'),
(777, 'INSERT', '', 57, 'Added response to leave request ID 105: Screenshot 2024-11-20 212130.png', 1, '2025-05-08 03:24:42'),
(778, 'INSERT', 'leave_attachments', 17, 'Added attachment to leave ID 105: assets/uploads/5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', 1, '2025-05-08 03:25:13'),
(779, 'INSERT', '', 58, 'Added response to leave request ID 105: 5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', 1, '2025-05-08 03:25:13'),
(780, 'INSERT', 'leave_attachments', 18, 'Added attachment to leave ID 105: assets/uploads/2025-Checklist_Metro-North.pdf', 1, '2025-05-08 03:25:50'),
(781, 'INSERT', '', 59, 'Added response to leave request ID 105: 2025-Checklist_Metro-North.pdf', 1, '2025-05-08 03:25:50'),
(782, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-08 04:30:20'),
(783, 'INSERT', '', 60, 'Added response to leave request ID 105: sss', 1, '2025-05-08 04:30:33'),
(784, 'INSERT', '', 61, 'Added response to leave request ID 105: adads', 1, '2025-05-08 04:34:21'),
(785, 'INSERT', 'leave_attachments', 19, 'Added attachment to leave ID 105: assets/uploads/2025-Checklist_Metro-North.pdf', 1, '2025-05-08 04:34:32'),
(786, 'INSERT', '', 62, 'Added response to leave request ID 105: 2025-Checklist_Metro-North.pdf', 1, '2025-05-08 04:34:32'),
(787, 'INSERT', '', 63, 'Added response to leave request ID 105: hghh', 1, '2025-05-08 04:34:52'),
(788, 'INSERT', '', 64, 'Added response to leave request ID 105: gg\'', 1, '2025-05-08 04:34:58'),
(789, 'INSERT', 'leave_attachments', 20, 'Added attachment to leave ID 105: assets/uploads/certificate of units earned.pdf', 1, '2025-05-08 04:35:45'),
(790, 'INSERT', '', 65, 'Added response to leave request ID 105: certificate of units earned.pdf', 1, '2025-05-08 04:35:45'),
(791, 'INSERT', '', 66, 'Added response to leave request ID 105: aaadsdasads', 1, '2025-05-08 04:37:09'),
(792, 'INSERT', '', 67, 'Added response to leave request ID 105: ahkuasjhadshjads', 1, '2025-05-08 04:38:31'),
(793, 'INSERT', '', 68, 'Added response to leave request ID 105: dshdhdhd', 1, '2025-05-08 04:41:29'),
(794, 'INSERT', '', 69, 'Added response to leave request ID 105: sss', 1, '2025-05-08 04:41:34'),
(795, 'INSERT', '', 70, 'Added response to leave request ID 105: sss', 1, '2025-05-08 04:41:37'),
(796, 'INSERT', '', 71, 'Added response to leave request ID 105: adsad as as', 1, '2025-05-08 04:41:40'),
(797, 'INSERT', '', 72, 'Added response to leave request ID 105: hjkuadhjkads', 1, '2025-05-08 04:53:06'),
(798, 'INSERT', '', 73, 'Added response to leave request ID 105: dhdhdhd', 1, '2025-05-08 04:53:09'),
(799, 'INSERT', '', 74, 'Added response to leave request ID 105: 1233333', 1, '2025-05-08 04:53:13'),
(800, 'INSERT', '', 75, 'Added response to leave request ID 105: Tesisndsd', 1, '2025-05-08 04:55:13'),
(801, 'INSERT', '', 76, 'Added response to leave request ID 105: dsdsdsds', 1, '2025-05-08 04:55:16'),
(802, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-08 05:59:20'),
(803, 'INSERT', '', 77, 'Added response to leave request ID 105: Tesinggsss', 1, '2025-05-08 05:59:32'),
(804, 'INSERT', '', 78, 'Added response to leave request ID 105: sss', 1, '2025-05-08 05:59:35'),
(805, 'INSERT', '', 79, 'Added response to leave request ID 105: aaaa', 1, '2025-05-08 06:05:59'),
(806, 'INSERT', '', 80, 'Added response to leave request ID 105: ss', 1, '2025-05-08 06:06:01'),
(807, 'INSERT', '', 81, 'Added response to leave request ID 105: s', 1, '2025-05-08 06:06:03'),
(808, 'INSERT', '', 82, 'Added response to leave request ID 105: 123', 1, '2025-05-08 06:12:00'),
(809, 'INSERT', '', 83, 'Added response to leave request ID 105: Test 123', 1, '2025-05-08 06:12:42'),
(810, 'INSERT', '', 84, 'Added response to leave request ID 105: Test', 1, '2025-05-08 06:12:47'),
(811, 'INSERT', '', 85, 'Added response to leave request ID 105: 12321312312321312312233321231231123213', 1, '2025-05-08 06:12:55'),
(812, 'INSERT', '', 86, 'Added response to leave request ID 105: s', 1, '2025-05-08 06:12:58'),
(813, 'INSERT', '', 87, 'Added response to leave request ID 105: s', 1, '2025-05-08 06:13:02'),
(814, 'INSERT', '', 88, 'Added response to leave request ID 105: 22', 1, '2025-05-08 06:36:37'),
(815, 'INSERT', '', 89, 'Added response to leave request ID 105: 2', 1, '2025-05-08 06:36:41'),
(816, 'INSERT', '', 90, 'Added response to leave request ID 105: asdfgghjk', 1, '2025-05-08 06:38:27'),
(817, 'INSERT', '', 91, 'Added response to leave request ID 105: adshjadshuasdhjk', 1, '2025-05-08 06:38:36'),
(818, 'INSERT', '', 92, 'Added response to leave request ID 101: hh', 1, '2025-05-08 06:46:05'),
(819, 'INSERT', '', 93, 'Added response to leave request ID 101: jj', 1, '2025-05-08 06:46:10'),
(820, 'INSERT', '', 94, 'Added response to leave request ID 101: uu', 1, '2025-05-08 06:46:14'),
(821, 'INSERT', '', 95, 'Added response to leave request ID 83: hh', 1, '2025-05-08 06:48:12'),
(822, 'INSERT', '', 96, 'Added response to leave request ID 83: uu', 1, '2025-05-08 06:48:23'),
(823, 'INSERT', '', 97, 'Added response to leave request ID 83: jj', 1, '2025-05-08 06:48:31'),
(824, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-08 07:44:45'),
(825, 'INSERT', '', 98, 'Added response to leave request ID 83: RTEssdsdsd', 1, '2025-05-08 07:45:01'),
(826, 'INSERT', '', 99, 'Added response to leave request ID 83: dd', 1, '2025-05-08 07:45:03'),
(827, 'INSERT', '', 100, 'Added response to leave request ID 83: s', 1, '2025-05-08 07:45:07'),
(828, 'INSERT', '', 101, 'Added response to leave request ID 83: ggg', 1, '2025-05-08 07:47:27'),
(829, 'INSERT', '', 102, 'Added response to leave request ID 28: m1', 1, '2025-05-08 07:49:09'),
(830, 'INSERT', '', 103, 'Added response to leave request ID 28: m2', 1, '2025-05-08 07:49:12'),
(831, 'INSERT', '', 104, 'Added response to leave request ID 28: m3', 1, '2025-05-08 07:52:28'),
(832, 'INSERT', '', 105, 'Added response to leave request ID 28: ddd', 1, '2025-05-08 08:01:06'),
(833, 'INSERT', '', 106, 'Added response to leave request ID 28: ss', 1, '2025-05-08 08:18:40'),
(834, 'INSERT', '', 107, 'Added response to leave request ID 28: m6', 1, '2025-05-08 08:19:31'),
(835, 'INSERT', '', 108, 'Added response to leave request ID 28: m7', 1, '2025-05-08 08:22:59'),
(836, 'INSERT', '', 109, 'Added response to leave request ID 28: m9', 1, '2025-05-08 08:23:04'),
(837, 'INSERT', '', 110, 'Added response to leave request ID 28: hahaha', 1, '2025-05-08 08:23:16'),
(838, 'INSERT', '', 111, 'Added response to leave request ID 85: m1', 1, '2025-05-08 08:27:14'),
(839, 'INSERT', '', 112, 'Added response to leave request ID 85: m2', 1, '2025-05-08 08:27:17'),
(840, 'INSERT', '', 113, 'Added response to leave request ID 85: m3', 1, '2025-05-08 08:27:20'),
(841, 'INSERT', '', 114, 'Added response to leave request ID 85: m4', 1, '2025-05-08 08:27:22'),
(842, 'INSERT', '', 115, 'Added response to leave request ID 85: m5', 1, '2025-05-08 08:30:58'),
(843, 'INSERT', '', 116, 'Added response to leave request ID 85: m6', 1, '2025-05-08 08:31:21'),
(844, 'INSERT', '', 117, 'Added response to leave request ID 85: asdad', 1, '2025-05-08 08:35:33'),
(845, 'INSERT', 'leave_attachments', 21, 'Added attachment to leave ID 85: assets/uploads/5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', 1, '2025-05-08 08:35:44'),
(846, 'INSERT', '', 118, 'Added response to leave request ID 85: 5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', 1, '2025-05-08 08:35:44'),
(847, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-08 02:35:52'),
(848, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-08 08:35:58'),
(849, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-08 02:39:27'),
(850, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-08 08:39:33'),
(851, 'INSERT', '', 121, 'Added response to leave request ID 105: Tesdsd', 1, '2025-05-08 08:39:45'),
(852, 'INSERT', '', 122, 'Added response to leave request ID 105: dsds', 1, '2025-05-08 08:39:48'),
(853, 'INSERT', '', 123, 'Added response to leave request ID 105: TResdsds', 1, '2025-05-08 08:40:54'),
(854, 'LOGOUT', 'users', 1, 'User ID 1 logged out successfully.', 1, '2025-05-08 02:42:50'),
(855, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-08 08:42:58'),
(856, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-08 02:54:11'),
(857, 'LOGIN', 'users', 1794, 'User ID 1794 logged in successfully.', 1794, '2025-05-08 08:54:18'),
(858, 'LOGOUT', 'users', 1794, 'User ID 1794 logged out successfully.', 1794, '2025-05-08 02:54:42'),
(859, 'LOGIN', 'users', 3, 'User ID 3 logged in successfully.', 3, '2025-05-08 08:55:07'),
(860, 'LOGOUT', 'users', 3, 'User ID 3 logged out successfully.', 3, '2025-05-08 03:02:36'),
(861, 'LOGIN', 'users', 1168, 'User ID 1168 logged in successfully.', 1168, '2025-05-08 09:02:40');

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
(1, 'Benefits and Claims'),
(2, 'Exit and Offboarding'),
(3, 'HR Policies and Clarifications'),
(4, 'Leave and Attendance'),
(5, 'Payroll Issues'),
(6, 'Performance and Career'),
(7, 'System and Access Issues'),
(8, 'Workplace Behavior and Safety');

-- --------------------------------------------------------

--
-- Table structure for table `leave_attachments`
--

CREATE TABLE `leave_attachments` (
  `id` int(11) NOT NULL,
  `leave_request_id` int(11) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_attachments`
--

INSERT INTO `leave_attachments` (`id`, `leave_request_id`, `uploaded_by`, `file_path`, `file_name`, `uploaded_at`) VALUES
(1, 97, 1794, 'assets/uploads/1746364025_3.jpg', '3.jpg', '2025-05-04 13:07:05'),
(2, 98, 1794, 'assets/uploads/1746364269_3.jpg', '3.jpg', '2025-05-04 13:11:09'),
(3, 99, 1794, 'assets/uploads/1746364583_Ae86_static_wallpaper.jpg', 'Ae86 static wallpaper.jpg', '2025-05-04 13:16:23'),
(4, 100, 1, 'assets/uploads/1746364906_c008c4995dd6a756ec42b07e3300769e.jpg', 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-05-04 13:21:46'),
(5, 99, 1, 'assets/uploads/1746616258_sample profile.jpg', 'sample profile.jpg', '2025-05-08 01:06:06'),
(6, 99, 1, 'assets/uploads/1746616369_gt86.jpg', '1746616369_gt86.jpg', '2025-05-07 11:12:49'),
(7, 101, 1, 'assets/uploads/gt_86.webp', 'gt 86.webp', '2025-05-07 14:13:35'),
(8, 99, 1794, 'assets/uploads/1746666753_sample profile.jpg', '1746666753_sample profile.jpg', '2025-05-08 01:12:33'),
(9, 99, 1794, 'assets/uploads/1746666773_gt86.jpg', '1746666773_gt86.jpg', '2025-05-08 01:12:53'),
(10, 99, 1794, 'assets/uploads/sample profile.jpg', 'sample profile.jpg', '2025-05-08 01:15:08'),
(11, 105, 1794, 'assets/uploads/sample_profile.jpg', 'sample profile.jpg', '2025-05-08 02:19:50'),
(12, 105, 1794, 'assets/uploads/gt86.jpg', 'gt86.jpg', '2025-05-08 02:26:10'),
(13, 105, 1794, 'assets/uploads/gt 86.webp', 'gt 86.webp', '2025-05-08 02:40:16'),
(14, 105, 1, 'assets/uploads/sample profile.jpg', 'sample profile.jpg', '2025-05-08 02:44:07'),
(15, 105, 1, 'assets/uploads/Screenshot 2024-11-20 211640.png', 'Screenshot 2024-11-20 211640.png', '2025-05-08 03:24:15'),
(16, 105, 1, 'assets/uploads/Screenshot 2024-11-20 212130.png', 'Screenshot 2024-11-20 212130.png', '2025-05-08 03:24:42'),
(17, 105, 1, 'assets/uploads/5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', '5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', '2025-05-08 03:25:13'),
(18, 105, 1, 'assets/uploads/2025-Checklist_Metro-North.pdf', '2025-Checklist_Metro-North.pdf', '2025-05-08 03:25:50'),
(19, 105, 1, 'assets/uploads/2025-Checklist_Metro-North.pdf', '2025-Checklist_Metro-North.pdf', '2025-05-08 04:34:32'),
(20, 105, 1, 'assets/uploads/certificate of units earned.pdf', 'certificate of units earned.pdf', '2025-05-08 04:35:45'),
(21, 85, 1, 'assets/uploads/5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', '5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', '2025-05-08 08:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_types` varchar(50) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employee_id`, `leave_types`, `start_date`, `end_date`, `reason`, `status`, `created_at`, `approved_by`, `updated_at`) VALUES
(28, 1794, 'Vacation', '2025-04-26', '2025-04-30', 'Vacation at Boracay', 'Pending', '2025-04-25 04:31:24', 1, '2025-05-02 08:58:26'),
(29, 1794, 'Service Incentive Leave', '2025-04-30', '2025-05-03', 'I need time', 'Approved', '2025-04-25 04:31:59', 1, '2025-04-27 06:01:43'),
(40, 1168, 'Vacation', '2025-04-27', '2025-04-30', 'Vacation nga ni', 'Approved', '2025-04-26 04:38:20', 1, '2025-04-27 06:01:51'),
(41, 1168, 'Vacation', '2025-04-27', '2025-04-30', 'Vacation nga ni', 'Approved', '2025-04-26 04:51:51', 1, '2025-04-27 06:01:34'),
(42, 1168, 'Vacation', '2025-04-28', '2025-04-30', 'Vacation muna ako ', 'Approved', '2025-04-26 20:26:09', 1, '2025-04-27 06:01:03'),
(43, 1168, 'Earned Leave Credit', '2025-04-28', '2025-04-30', 'pass', 'Approved', '2025-04-26 20:26:56', 1, '2025-04-27 03:41:33'),
(44, 1168, 'Sick Leave', '2025-04-28', '2025-04-30', 'Testing bounce', 'Approved', '2025-04-26 20:29:49', 1, '2025-04-27 03:38:07'),
(45, 1168, 'Earned Leave Credit', '2025-04-28', '2025-04-30', 'bounce na ako maam', 'Approved', '2025-04-26 20:31:35', 1, '2025-04-27 03:04:33'),
(46, 1168, 'Earned Leave Credit', '2025-04-28', '2025-04-30', 'ELC', 'Approved', '2025-04-27 00:07:12', 1, '2025-04-27 06:07:42'),
(47, 1, 'Birthday Leave', '2025-04-28', '2025-04-28', 'Birthday ko bossing', 'Approved', '2025-04-27 00:42:18', 1, '2025-04-27 08:13:01'),
(48, 1, 'Birthday Leave', '2025-04-28', '2025-04-28', 'Birthday ko gna ni', 'Approved', '2025-04-27 00:44:37', 1, '2025-04-27 08:13:12'),
(49, 1, 'Birthday Leave', '2025-04-28', '2025-04-28', 'Birthday ko gna ni', 'Approved', '2025-04-27 00:45:49', 1, '2025-04-27 08:13:38'),
(50, 1, 'Maternity Leave', '2025-04-28', '2025-05-08', 'Buntis ako bossing ', 'Approved', '2025-04-27 00:48:09', 1, '2025-04-27 08:23:01'),
(51, 1794, 'Service Incentive Leave', '2025-04-28', '2025-04-30', 'Bounce muna ako boss!', 'Approved', '2025-04-27 00:52:13', 1, '2025-04-27 09:29:11'),
(52, 1, 'Paternity Leave', '2025-04-30', '2025-05-05', 'Bantay bata', 'Approved', '2025-04-28 20:25:41', 1, '2025-04-29 02:25:58'),
(53, 1168, 'Leave Without Pay', '2025-05-01', '2025-05-07', 'Bounce', 'Approved', '2025-04-29 00:13:22', 1, '2025-04-29 07:13:21'),
(54, 1, 'Leave Without Pay', '2025-04-30', '2025-05-07', 'lwop', 'Approved', '2025-04-29 02:18:41', 1, '2025-04-29 08:20:23'),
(55, 1, 'Leave Without Pay', '2025-05-08', '2025-05-10', 'lwop2', 'Approved', '2025-04-29 02:21:41', 1, '2025-04-29 08:21:56'),
(56, 1794, 'Leave Without Pay', '2025-04-30', '2025-05-30', 'Lwop muna', 'Approved', '2025-04-29 06:52:32', 1, '2025-04-30 15:25:16'),
(57, 1794, 'AWOL', '2025-05-01', '2025-05-01', 'AWOL', 'Approved', '2025-05-01 06:41:21', 1, '2025-05-01 06:41:21'),
(58, 1794, 'AWOL', '2025-05-01', '2025-05-01', 'AWOL', 'Approved', '2025-05-01 06:49:59', 1, '2025-05-01 06:49:59'),
(59, 1168, 'AWOL', '2025-05-01', '2025-05-01', 'AWOL', 'Approved', '2025-05-01 06:50:19', 1, '2025-05-01 06:50:19'),
(60, 1168, 'AWOL', '2025-05-01', '2025-05-01', 'AWOL', 'Approved', '2025-05-01 06:50:33', 1, '2025-05-01 06:50:33'),
(61, 1168, 'AWOL', '2025-05-01', '2025-05-01', 'AWOL', 'Approved', '2025-05-01 06:56:20', 1, '2025-05-01 06:56:20'),
(62, 1168, 'AWOL', '2025-05-01', '2025-05-01', 'AWOL', 'Approved', '2025-05-01 06:57:36', 1, '2025-05-01 06:57:36'),
(63, 1168, 'AWOL', '2025-05-01', '2025-05-01', 'AWOL', 'Approved', '2025-05-01 06:58:12', 1, '2025-05-01 06:58:12'),
(64, 1, 'AWOL', '2025-05-01', '2025-05-01', 'Marked as AWOL', 'Approved', '2025-05-01 07:28:44', 1, '2025-05-01 07:28:44'),
(65, 1, 'AWOL', '2025-05-01', '2025-05-01', 'Marked as AWOL', 'Approved', '2025-05-01 07:28:59', 1, '2025-05-01 07:28:59'),
(66, 1, 'AWOL', '2025-05-01', '2025-05-01', 'Marked as AWOL', 'Approved', '2025-05-01 07:29:11', 1, '2025-05-01 07:29:11'),
(76, 2, 'AWOL', '2025-05-01', '2025-05-01', 'AWOL', 'Approved', '2025-05-01 08:24:28', 1, '2025-05-01 08:24:28'),
(77, 3, 'AWOL', '2025-05-02', '2025-05-02', 'AWOL', 'Approved', '2025-05-02 01:38:21', 1, '2025-05-02 01:38:21'),
(78, 3, 'AWOL', '2025-05-02', '2025-05-02', 'AWOL', 'Approved', '2025-05-02 01:38:36', 1, '2025-05-02 01:38:36'),
(79, 3, 'AWOL', '2025-05-02', '2025-05-02', 'AWOL', 'Approved', '2025-05-02 01:43:31', 1, '2025-05-02 01:43:31'),
(80, 2, 'AWOL', '2025-05-02', '2025-05-02', 'AWOL', 'Approved', '2025-05-02 01:51:27', 1, '2025-05-02 01:51:27'),
(81, 1793, 'AWOL', '2025-05-02', '2025-05-02', 'AWOL', 'Approved', '2025-05-02 01:54:21', 1, '2025-05-02 01:54:21'),
(82, 1, 'Solo Parent Leave', '2025-05-03', '2025-05-06', 'SPL', 'Pending', '2025-05-02 01:20:48', NULL, NULL),
(83, 1794, 'Paternity Leave', '2025-05-03', '2025-05-06', 'PL', 'Approved', '2025-05-02 02:39:04', 1794, '2025-05-02 08:58:49'),
(84, 1794, 'Leave Without Pay', '2025-05-03', '2025-05-29', 'nnn', 'Pending', '2025-05-02 03:00:46', NULL, NULL),
(85, 1794, 'Leave Without Pay', '2025-05-16', '2025-05-30', 'LWOP', 'Pending', '2025-05-02 03:15:03', NULL, NULL),
(97, 1794, 'Leave Without Pay', '2025-05-06', '2025-05-15', 'LWOP', 'Pending', '2025-05-04 07:07:05', NULL, NULL),
(98, 1794, 'Leave Without Pay', '2025-05-06', '2025-05-15', 'LWOP', 'Pending', '2025-05-04 13:11:09', NULL, NULL),
(99, 1794, 'Sick Leave', '2025-05-05', '2025-05-06', 'SICK LEAVE', 'Rejected', '2025-05-04 13:16:23', 1, '2025-05-07 14:06:05'),
(100, 1, 'Leave Without Pay', '2025-05-10', '2025-07-24', 'LWOP', 'Rejected', '2025-05-04 13:21:46', 1, '2025-05-07 09:39:57'),
(101, 1, 'Bereavement Leave', '2025-05-08', '2025-05-11', 'asdasddad', 'Pending', '2025-05-07 14:13:35', NULL, NULL),
(105, 1794, 'Leave Without Pay', '2025-05-10', '2025-06-06', 'ADASDASDASDASASD', 'Approved', '2025-05-08 02:19:50', 1, '2025-05-08 02:40:54');

-- --------------------------------------------------------

--
-- Table structure for table `leave_responses`
--

CREATE TABLE `leave_responses` (
  `id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `response_text_leave` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_responses`
--

INSERT INTO `leave_responses` (`id`, `leave_id`, `user_id`, `response_text_leave`, `created_at`) VALUES
(1, 99, 1794, '48\r\n32\r\n1794\r\nc008c4995dd6a756ec42b07e3300769e.jpg\r\n2025-05-02 16:03:37', '2025-05-02 08:03:37'),
(2, 99, 1, 'adshjkasdhjkads', '2025-05-07 10:06:43'),
(3, 99, 1, 'adsjnkladshjasd', '2025-05-07 10:06:44'),
(4, 99, 1, 'sample profile.jpg', '2025-05-07 11:10:58'),
(5, 99, 1, 'gt86.jpg', '2025-05-07 11:12:49'),
(6, 99, 1794, 'Testing', '2025-05-08 01:11:33'),
(7, 99, 1794, 'sample profile.jpg', '2025-05-08 01:12:33'),
(8, 99, 1794, 'gt86.jpg', '2025-05-08 01:12:53'),
(9, 99, 1794, 'sample profile.jpg', '2025-05-08 01:15:08'),
(10, 105, 1794, 'TEsginasda', '2025-05-08 02:25:57'),
(11, 105, 1794, 'gt86.jpg', '2025-05-08 02:26:10'),
(12, 105, 1794, 'adsghjkadsghjkasd', '2025-05-08 02:39:56'),
(13, 105, 1794, 'TEsoasda sd', '2025-05-08 02:40:04'),
(14, 105, 1794, 'adsjkl;asjkl;ajkl;ads', '2025-05-08 02:40:08'),
(15, 105, 1794, 'gt 86.webp', '2025-05-08 02:40:16'),
(16, 105, 1, 'TEsaosdas', '2025-05-08 02:41:26'),
(17, 105, 1, 'TEsisasdasds', '2025-05-08 02:43:53'),
(18, 105, 1, 'asdadads', '2025-05-08 02:43:57'),
(19, 105, 1, 'sample profile.jpg', '2025-05-08 02:44:07'),
(20, 54, 1, 'TREsasdsa', '2025-05-08 02:47:09'),
(21, 52, 1, 'ashjkadshjkads', '2025-05-08 02:47:45'),
(22, 105, 1, 'TEsadsa', '2025-05-08 02:47:57'),
(23, 105, 1, 'asdsaghjkasdjghkasd', '2025-05-08 02:48:09'),
(24, 105, 1, 'asdasdas', '2025-05-08 02:48:13'),
(25, 105, 1, 'TEasda', '2025-05-08 02:48:16'),
(26, 105, 1, 'assssssss', '2025-05-08 02:48:24'),
(27, 105, 1, 'TEssdisds', '2025-05-08 02:48:35'),
(28, 105, 1, 'adasd', '2025-05-08 02:48:39'),
(29, 105, 1794, 'asdasasd', '2025-05-08 03:01:49'),
(30, 105, 1794, 'Tesings', '2025-05-08 03:01:55'),
(31, 105, 1794, 'TEssds', '2025-05-08 03:02:09'),
(32, 105, 1794, 'sssssss', '2025-05-08 03:02:13'),
(33, 105, 1794, 'ssssss', '2025-05-08 03:02:14'),
(34, 105, 1794, 's', '2025-05-08 03:02:14'),
(35, 105, 1794, 's', '2025-05-08 03:02:14'),
(36, 105, 1794, 's', '2025-05-08 03:02:15'),
(37, 105, 1794, 's', '2025-05-08 03:02:15'),
(38, 105, 1794, 's', '2025-05-08 03:02:15'),
(39, 105, 1, 'Tessdsdsdsds', '2025-05-08 03:08:18'),
(40, 105, 1, 'adsadshjksadhjkdsahjads', '2025-05-08 03:08:30'),
(41, 105, 1, 'adsadsads', '2025-05-08 03:10:56'),
(42, 105, 1, 'Tesinsdsd', '2025-05-08 03:11:03'),
(43, 105, 1, 'asdasdsadsa', '2025-05-08 03:11:07'),
(44, 105, 1, 'rtesdsd', '2025-05-08 03:11:13'),
(45, 105, 1, 'adaads', '2025-05-08 03:18:12'),
(46, 105, 1, 'dsdsds', '2025-05-08 03:18:16'),
(47, 105, 1, 'ddd', '2025-05-08 03:18:18'),
(48, 105, 1, 'dd', '2025-05-08 03:18:20'),
(49, 105, 1, 'd', '2025-05-08 03:18:21'),
(50, 105, 1, 'd', '2025-05-08 03:18:25'),
(51, 105, 1, 'd', '2025-05-08 03:18:26'),
(52, 105, 1, '12344', '2025-05-08 03:21:23'),
(53, 105, 1, '111', '2025-05-08 03:21:27'),
(54, 105, 1, 'adsadsas', '2025-05-08 03:23:50'),
(55, 105, 1, 's', '2025-05-08 03:23:53'),
(56, 105, 1, 'Screenshot 2024-11-20 211640.png', '2025-05-08 03:24:15'),
(57, 105, 1, 'Screenshot 2024-11-20 212130.png', '2025-05-08 03:24:42'),
(58, 105, 1, '5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', '2025-05-08 03:25:13'),
(59, 105, 1, '2025-Checklist_Metro-North.pdf', '2025-05-08 03:25:50'),
(60, 105, 1, 'sss', '2025-05-08 04:30:33'),
(61, 105, 1, 'adads', '2025-05-08 04:34:21'),
(62, 105, 1, '2025-Checklist_Metro-North.pdf', '2025-05-08 04:34:32'),
(63, 105, 1, 'hghh', '2025-05-08 04:34:52'),
(64, 105, 1, 'gg\'', '2025-05-08 04:34:58'),
(65, 105, 1, 'certificate of units earned.pdf', '2025-05-08 04:35:45'),
(66, 105, 1, 'aaadsdasads', '2025-05-08 04:37:09'),
(67, 105, 1, 'ahkuasjhadshjads', '2025-05-08 04:38:31'),
(68, 105, 1, 'dshdhdhd', '2025-05-08 04:41:29'),
(69, 105, 1, 'sss', '2025-05-08 04:41:34'),
(70, 105, 1, 'sss', '2025-05-08 04:41:37'),
(71, 105, 1, 'adsad as as', '2025-05-08 04:41:40'),
(72, 105, 1, 'hjkuadhjkads', '2025-05-08 04:53:06'),
(73, 105, 1, 'dhdhdhd', '2025-05-08 04:53:09'),
(74, 105, 1, '1233333', '2025-05-08 04:53:13'),
(75, 105, 1, 'Tesisndsd', '2025-05-08 04:55:13'),
(76, 105, 1, 'dsdsdsds', '2025-05-08 04:55:16'),
(77, 105, 1, 'Tesinggsss', '2025-05-08 05:59:32'),
(78, 105, 1, 'sss', '2025-05-08 05:59:35'),
(79, 105, 1, 'aaaa', '2025-05-08 06:05:59'),
(80, 105, 1, 'ss', '2025-05-08 06:06:01'),
(81, 105, 1, 's', '2025-05-08 06:06:03'),
(82, 105, 1, '123', '2025-05-08 06:12:00'),
(83, 105, 1, 'Test 123', '2025-05-08 06:12:42'),
(84, 105, 1, 'Test', '2025-05-08 06:12:47'),
(85, 105, 1, '12321312312321312312233321231231123213', '2025-05-08 06:12:55'),
(86, 105, 1, 's', '2025-05-08 06:12:58'),
(87, 105, 1, 's', '2025-05-08 06:13:02'),
(88, 105, 1, '22', '2025-05-08 06:36:37'),
(89, 105, 1, '2', '2025-05-08 06:36:41'),
(90, 105, 1, 'asdfgghjk', '2025-05-08 06:38:27'),
(91, 105, 1, 'adshjadshuasdhjk', '2025-05-08 06:38:36'),
(92, 101, 1, 'hh', '2025-05-08 06:46:05'),
(93, 101, 1, 'jj', '2025-05-08 06:46:10'),
(94, 101, 1, 'uu', '2025-05-08 06:46:14'),
(95, 83, 1, 'hh', '2025-05-08 06:48:12'),
(96, 83, 1, 'uu', '2025-05-08 06:48:23'),
(97, 83, 1, 'jj', '2025-05-08 06:48:31'),
(98, 83, 1, 'RTEssdsdsd', '2025-05-08 07:45:01'),
(99, 83, 1, 'dd', '2025-05-08 07:45:03'),
(100, 83, 1, 's', '2025-05-08 07:45:07'),
(101, 83, 1, 'ggg', '2025-05-08 07:47:27'),
(102, 28, 1, 'm1', '2025-05-08 07:49:09'),
(103, 28, 1, 'm2', '2025-05-08 07:49:12'),
(104, 28, 1, 'm3', '2025-05-08 07:52:28'),
(105, 28, 1, 'ddd', '2025-05-08 08:01:06'),
(106, 28, 1, 'ss', '2025-05-08 08:18:40'),
(107, 28, 1, 'm6', '2025-05-08 08:19:31'),
(108, 28, 1, 'm7', '2025-05-08 08:22:59'),
(109, 28, 1, 'm9', '2025-05-08 08:23:04'),
(110, 28, 1, 'hahaha', '2025-05-08 08:23:16'),
(111, 85, 1, 'm1', '2025-05-08 08:27:14'),
(112, 85, 1, 'm2', '2025-05-08 08:27:17'),
(113, 85, 1, 'm3', '2025-05-08 08:27:20'),
(114, 85, 1, 'm4', '2025-05-08 08:27:22'),
(115, 85, 1, 'm5', '2025-05-08 08:30:58'),
(116, 85, 1, 'm6', '2025-05-08 08:31:21'),
(117, 85, 1, 'asdad', '2025-05-08 08:35:33'),
(118, 85, 1, '5ee2cc31-2073-41ef-9a57-78dff20c0d90.jpg', '2025-05-08 08:35:44'),
(119, 98, 1794, 'Test', '2025-05-08 08:38:47'),
(120, 105, 1794, 'TEst', '2025-05-08 08:39:05'),
(121, 105, 1, 'Tesdsd', '2025-05-08 08:39:45'),
(122, 105, 1, 'dsds', '2025-05-08 08:39:48'),
(123, 105, 1, 'TResdsds', '2025-05-08 08:40:54'),
(124, 105, 1794, 'Testsddd', '2025-05-08 08:43:10'),
(125, 105, 1794, 'dsdssd', '2025-05-08 08:43:48'),
(126, 77, 3, 'Tessdddd', '2025-05-08 08:55:14');

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
  `start_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `employee_id`, `subject`, `description`, `status`, `priority`, `category_id`, `assigned_to`, `created_at`, `start_at`, `updated_at`) VALUES
(25, 1168, 'payroll adjustment', 'payroll adjustment', 'In Progress', 'Medium', 3, 3, '2025-04-22 17:01:16', '2025-04-22 17:11:46', NULL),
(26, 1, 'payslip', 'blah', 'Resolved', 'High', 5, 3, '2025-04-23 06:51:49', '2025-04-23 06:53:21', '2025-04-23 06:53:39'),
(27, 1168, 'asd', 'asd', 'In Progress', 'Low', 2, 3, '2025-04-24 08:11:45', '2025-05-03 00:10:42', NULL),
(28, 1168, 'Printer', 'Printer 1052', 'Open', 'Low', 1, NULL, '2025-04-26 02:52:43', NULL, NULL),
(29, 1168, 'Testing 123', 'Printer Testing', 'Open', 'Low', 1, NULL, '2025-04-26 03:00:11', NULL, NULL),
(30, 1168, 'Printer Sample', 'Printer connect to', 'Open', 'Low', 1, NULL, '2025-04-26 10:35:04', NULL, NULL),
(31, 1168, 'something went wrong', 'Internet no connection', 'In Progress', 'Low', 2, 1, '2025-04-27 02:20:15', '2025-04-27 07:35:35', NULL),
(32, 1794, 'Printer', 'Printer 1052', 'In Progress', 'Low', 1, 1, '2025-04-27 07:37:32', '2025-05-08 01:56:11', NULL),
(33, 1794, 'Testing 123', 'PS', 'Open', 'Low', 5, NULL, '2025-05-02 09:12:07', NULL, NULL);

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
(33, 25, 1168, 'Testing message', '2025-04-25 02:26:30'),
(34, 25, 1168, 'Testing message', '2025-04-25 02:29:14'),
(35, 26, 1168, 'dg', '2025-04-25 02:44:29'),
(36, 26, 1168, 'dg', '2025-04-25 02:45:37'),
(44, 32, 1794, 'ahiashasdhasd', '2025-05-02 07:29:19'),
(45, 32, 1794, 'ahiashasdhasd', '2025-05-02 07:34:44'),
(46, 32, 1794, 'aaa', '2025-05-02 07:54:36'),
(47, 32, 1794, 'asnkladshjkadshjklads', '2025-05-02 07:57:35'),
(48, 32, 1794, 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-05-02 08:03:37'),
(49, 32, 1794, '32.jpg', '2025-05-02 08:11:29'),
(50, 32, 1794, '3.jpg', '2025-05-02 08:20:36'),
(51, 32, 1794, 'asghasdhgads', '2025-05-02 08:26:20'),
(52, 32, 1794, '3.jpg', '2025-05-02 08:26:58'),
(53, 32, 1794, 'wallpaper ae86 gif.gif', '2025-05-02 08:27:13'),
(54, 32, 1794, 'Ae86 static wallpaper.jpg', '2025-05-02 08:28:00'),
(55, 32, 1794, 'Ae86 static wallpaper.jpg', '2025-05-02 08:30:37'),
(56, 33, 1794, 'Testin', '2025-05-02 23:43:41'),
(57, 33, 1794, 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-05-02 23:44:31'),
(58, 33, 1794, 'aaa', '2025-05-03 00:03:28'),
(59, 33, 1794, 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-05-03 00:03:41'),
(60, 33, 1794, 'TEsting', '2025-05-03 00:04:06'),
(61, 33, 1794, 'Ae86 static wallpaper.jpg', '2025-05-03 00:04:24'),
(62, 33, 1794, 'Testing', '2025-05-03 00:09:15'),
(63, 33, 1794, '32.jpg', '2025-05-03 00:09:34'),
(64, 27, 3, 'Testing', '2025-05-03 00:10:54'),
(65, 27, 3, 'Ae86 static wallpaper.jpg', '2025-05-03 00:11:03'),
(66, 27, 1168, 'Testing response without error', '2025-05-03 00:11:40'),
(67, 27, 1168, 'wallpaper ae86 gif.gif', '2025-05-03 00:11:52'),
(68, 31, 1, 'asdsdsaasd', '2025-05-06 06:36:27'),
(69, 31, 1, 'total_balance.sql', '2025-05-06 06:36:35'),
(70, 31, 1, 'total_balance.sql', '2025-05-06 06:36:47'),
(71, 31, 1, 'asasd', '2025-05-06 06:38:08'),
(72, 31, 1, 'adshjahjadsas', '2025-05-06 06:38:46'),
(73, 31, 1, 'adshjahjadsas', '2025-05-06 06:38:50'),
(74, 31, 1, 'adshjahjadsas', '2025-05-06 06:38:51'),
(75, 31, 1, 'adshjahjadsas', '2025-05-06 06:38:51'),
(76, 31, 1, 'adshjahjadsas', '2025-05-06 06:38:52'),
(77, 31, 1, 'adshjahjadsas', '2025-05-06 06:38:53'),
(78, 31, 1, 'acadsadsads', '2025-05-06 06:39:14'),
(79, 31, 1, 'asdsasad', '2025-05-06 06:40:01'),
(80, 31, 1, 'total_balance.sql', '2025-05-06 06:40:09'),
(81, 31, 1, 'total_balance.sql', '2025-05-06 06:42:13'),
(82, 31, 1, 'dasadsdsaads', '2025-05-06 06:42:16'),
(83, 31, 1, 'assadda', '2025-05-06 16:00:24'),
(84, 31, 1, 'adsasdadsdsa', '2025-05-07 01:22:00'),
(85, 31, 1, 'total_balance.sql', '2025-05-07 01:22:07'),
(86, 31, 1, 'asads', '2025-05-07 01:22:10'),
(87, 33, 1, 'total_balance.sql', '2025-05-07 10:46:02'),
(88, 33, 1, 'total_balance.sql', '2025-05-07 11:00:16'),
(89, 31, 1, 'adsdasdas', '2025-05-07 14:48:05'),
(90, 27, 1, 'Testing', '2025-05-07 15:26:19'),
(91, 27, 1, 'dsaadsjnbkadshjkads hjkadshjkads', '2025-05-07 15:26:29'),
(92, 33, 1, 'asddasadsads', '2025-05-07 15:26:55'),
(93, 27, 1, 'Testing', '2025-05-07 15:27:09'),
(94, 27, 1, '1231', '2025-05-07 15:27:09'),
(95, 27, 1168, 'Tesginaa', '2025-05-07 15:28:41'),
(96, 27, 1168, 'Tesginaa', '2025-05-07 15:28:44'),
(97, 27, 1168, 'Tesginaa', '2025-05-07 15:28:45'),
(98, 27, 1168, 'Tesginaa', '2025-05-07 15:28:45'),
(99, 27, 1168, 'Tesginaa', '2025-05-07 15:28:46'),
(100, 27, 1168, 'Tesginaa', '2025-05-07 15:28:46'),
(101, 27, 1168, 'PAGKAKALAMEG.mp4', '2025-05-07 15:28:57'),
(102, 27, 1168, 'PAGKAKALAMEG.mp4', '2025-05-07 15:28:59'),
(103, 27, 1168, 'PAGKAKALAMEG.mp4', '2025-05-07 15:29:00'),
(104, 27, 1168, 'PAGKAKALAMEG.mp4', '2025-05-07 15:29:00'),
(105, 27, 1168, 'PAGKAKALAMEG.mp4', '2025-05-07 15:29:00'),
(106, 27, 1168, 'PAGKAKALAMEasdsasG.mp4', '2025-05-07 15:29:07'),
(107, 27, 1168, 'sample profile.jpg', '2025-05-07 15:29:21'),
(108, 33, 1794, 'dasdadsasd', '2025-05-08 00:10:04'),
(109, 33, 1794, 'asdasdasdad', '2025-05-08 00:10:15'),
(110, 33, 1794, 'asdasdasdadad w asd ad', '2025-05-08 00:10:18'),
(111, 33, 1794, 'Testing', '2025-05-08 01:06:35'),
(112, 33, 1794, 'Testing', '2025-05-08 01:06:41'),
(113, 33, 1794, 'Testing Tesing 123', '2025-05-08 01:06:48'),
(114, 33, 1794, 'Testing Tesing 123', '2025-05-08 01:06:50'),
(115, 33, 1794, 'Testing Tesing 123', '2025-05-08 01:06:52'),
(116, 33, 1794, 'adsasdsa', '2025-05-08 01:06:58'),
(118, 33, 1794, 'sample profile.jpg', '2025-05-08 01:13:33'),
(119, 33, 1794, 'dasda', '2025-05-08 01:22:10'),
(120, 33, 1794, 'Testing lwop', '2025-05-08 01:22:19'),
(121, 33, 1794, 'Testginasda2', '2025-05-08 01:32:25'),
(122, 32, 1794, 'Testins', '2025-05-08 01:57:20'),
(123, 33, 1794, 'gt 86.webp', '2025-05-08 02:29:55'),
(124, 33, 1794, 'gt86.jpg', '2025-05-08 02:31:33');

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
  `mil` int(11) NOT NULL,
  `ml` int(11) NOT NULL DEFAULT 0,
  `pl` int(11) NOT NULL DEFAULT 0,
  `awol` int(11) DEFAULT 0,
  `spl` int(11) NOT NULL DEFAULT 0,
  `lwop` int(11) DEFAULT 0,
  `brl` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `total_balance`
--

INSERT INTO `total_balance` (`id`, `user_id`, `sl`, `sil`, `elc`, `mil`, `ml`, `pl`, `awol`, `spl`, `lwop`, `brl`) VALUES
(1, 1, 5, 5, 1, 0, 105, 7, NULL, 5, NULL, 5),
(2, 2, 5, 5, 1, 1, 105, 7, NULL, 5, NULL, 5),
(3, 3, 5, 5, 1, 1, 105, 7, NULL, 5, NULL, 5),
(4, 1168, 5, 5, 1, 1, 105, 7, NULL, 5, NULL, 5),
(5, 1793, 5, 5, 1, 1, 105, 7, NULL, 5, NULL, 5),
(6, 1794, 10, 5, 1, 3, 105, 7, NULL, 5, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `used_balance`
--

CREATE TABLE `used_balance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sl` int(11) NOT NULL DEFAULT 0,
  `sil` int(11) NOT NULL DEFAULT 0,
  `elc` int(11) NOT NULL DEFAULT 0,
  `mil` int(11) NOT NULL DEFAULT 1,
  `ml` int(11) NOT NULL DEFAULT 0,
  `pl` int(11) NOT NULL DEFAULT 0,
  `awol` int(11) DEFAULT 0,
  `spl` int(11) NOT NULL DEFAULT 0,
  `lwop` int(11) DEFAULT 0,
  `brl` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `used_balance`
--

INSERT INTO `used_balance` (`id`, `user_id`, `sl`, `sil`, `elc`, `mil`, `ml`, `pl`, `awol`, `spl`, `lwop`, `brl`) VALUES
(3, 1794, 0, 0, 0, 0, 0, 4, 2, 0, 31, 0),
(4, 1, 0, 0, 0, 0, 0, 0, 5, 0, 0, 0),
(5, 1168, 0, 0, 0, 0, 0, 0, 8, 0, 0, 0),
(6, 2, 0, 0, 0, 1, 0, 0, 5, 0, 0, 0),
(7, 3, 0, 0, 0, 1, 0, 0, 3, 0, 0, 0),
(8, 1793, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Employee','HR','HR HEAD','Admin','Super Admin') NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `department`, `status`, `created_at`) VALUES
(1, 'John Mico D. Intacto', 'mico@gmail.com', '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja', 'Admin', 'MIS/IT DEPARTMENT', 'Active', '2025-03-12 10:44:00'),
(2, 'HRD-ANA', 'HRDANA@GMAIL.COM', '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja', 'Admin', 'HR DEPARTMENT', 'Active', '2025-04-16 06:37:17'),
(3, 'HRD-RIANNA', 'HRDRIANNA@GMAIL.COM', '$2y$10$.1.rdwjB2Frf.lZBt2vSwOAhrxiS2Ni6L8.Vgl0Wr2fTHdvvUucmO', 'HR', 'HR DEPARTMENT', 'Active', '2025-04-16 06:37:51'),
(1168, 'DOMINIC', 'domrmdaquiz01@gmail.com', '$2y$10$IrIQbQ3WPUPBc4Y8kI8sUuw9S6YoQdIO6gCkCgdOdi1VOPhxkJi36', 'Employee', 'MIS/IT DEPARTMENT', 'Active', '2025-04-16 06:36:02'),
(1793, 'JULIA LIVED', 'HRDJULIA@GMAIL.COM', '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja', 'HR', 'HR DEPARTMENT', 'Active', '2025-04-23 06:49:02'),
(1794, 'Earl Gerald Domingo', 'earl@gmail.com', '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja', 'HR', 'HR DEPARTMENT', 'Active', '2025-04-25 02:48:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `uploaded_by_file` (`uploaded_by`);

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
-- Indexes for table `leave_attachments`
--
ALTER TABLE `leave_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_requests_fk_id` (`leave_request_id`),
  ADD KEY `uploaded_by_ID` (`uploaded_by`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `approved_by_ibfk2` (`approved_by`);

--
-- Indexes for table `leave_responses`
--
ALTER TABLE `leave_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_requests_fk_id_response` (`leave_id`),
  ADD KEY `user_id_employee` (`user_id`);

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
-- Indexes for table `total_balance`
--
ALTER TABLE `total_balance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `used_balance`
--
ALTER TABLE `used_balance`
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=862;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `leave_attachments`
--
ALTER TABLE `leave_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `leave_responses`
--
ALTER TABLE `leave_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `total_balance`
--
ALTER TABLE `total_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `used_balance`
--
ALTER TABLE `used_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `ticket_id_attach` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `uploaded_by_file` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_attachments`
--
ALTER TABLE `leave_attachments`
  ADD CONSTRAINT `leave_requests_fk_id` FOREIGN KEY (`leave_request_id`) REFERENCES `leave_requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uploaded_by_ID` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `approved_by_ibfk2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_responses`
--
ALTER TABLE `leave_responses`
  ADD CONSTRAINT `leave_requests_fk_id_response` FOREIGN KEY (`leave_id`) REFERENCES `leave_requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_employee` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  ADD CONSTRAINT `ticket_responses_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_responses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `total_balance`
--
ALTER TABLE `total_balance`
  ADD CONSTRAINT `total_balance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `used_balance`
--
ALTER TABLE `used_balance`
  ADD CONSTRAINT `used_balance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
