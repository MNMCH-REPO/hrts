-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2025 at 04:15 AM
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
(9, 31, 1, 'assets/uploads/c008c4995dd6a756ec42b07e3300769e.jpg', 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-04-27 08:27:24'),
(10, 31, 1, 'assets/uploads/c008c4995dd6a756ec42b07e3300769e.jpg', 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-04-29 01:50:27');

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL,
  `action_type` varchar(255) NOT NULL,
  `affected_table` enum('users','categories','tickets','ticket_responses','attachments','total_balance','used_balance','leave_requests') NOT NULL,
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
(521, 'LOGIN', 'users', 1, 'User ID 1 logged in successfully.', 1, '2025-05-01 01:13:53');

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
(1, 'Printer'),
(2, 'Internet'),
(3, 'Bizbox'),
(4, 'PC Hardware'),
(5, 'Other Request');

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
(28, 1794, 'Vacation', '2025-04-26', '2025-04-30', 'Vacation at Boracay', 'Approved', '2025-04-25 04:31:24', 1, '2025-04-27 02:57:16'),
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
(56, 1794, 'Leave Without Pay', '2025-04-30', '2025-05-30', 'Lwop muna', 'Approved', '2025-04-29 06:52:32', 1, '2025-04-30 15:25:16');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `leave_type_id` int(11) DEFAULT NULL,
  `leave_request_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `employee_id`, `subject`, `description`, `status`, `priority`, `category_id`, `assigned_to`, `created_at`, `start_at`, `updated_at`, `leave_type_id`, `leave_request_id`) VALUES
(25, 1168, 'payroll adjustment', 'payroll adjustment', 'In Progress', 'Medium', 3, 3, '2025-04-22 17:01:16', '2025-04-22 17:11:46', NULL, NULL, NULL),
(26, 1168, 'payslip', 'blah', 'Resolved', 'High', 5, 3, '2025-04-23 06:51:49', '2025-04-23 06:53:21', '2025-04-23 06:53:39', NULL, NULL),
(27, 1168, 'asd', 'asd', 'Open', 'Low', 2, 3, '2025-04-24 08:11:45', NULL, NULL, NULL, NULL),
(28, 1168, 'Printer', 'Printer 1052', 'Open', 'Low', 1, NULL, '2025-04-26 02:52:43', NULL, NULL, NULL, NULL),
(29, 1168, 'Testing 123', 'Printer Testing', 'Open', 'Low', 1, NULL, '2025-04-26 03:00:11', NULL, NULL, NULL, NULL),
(30, 1168, 'Printer Sample', 'Printer connect to', 'Open', 'Low', 1, NULL, '2025-04-26 10:35:04', NULL, NULL, NULL, NULL),
(31, 1168, 'something went wrong', 'Internet no connection', 'In Progress', 'Low', 2, 1, '2025-04-27 02:20:15', '2025-04-27 07:35:35', NULL, NULL, NULL),
(32, 1794, 'Printer', 'Printer 1052', 'Open', 'Low', 1, NULL, '2025-04-27 07:37:32', NULL, NULL, NULL, NULL);

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
(37, 31, 1, 'Test 123', '2025-04-27 07:35:48'),
(38, 31, 1, '!aaa', '2025-04-27 08:27:12'),
(39, 31, 1, 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-04-27 08:27:24'),
(40, 31, 1, 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-04-27 08:27:24'),
(41, 31, 1, 'aaa', '2025-04-29 01:50:19'),
(42, 31, 1, 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-04-29 01:50:27'),
(43, 31, 1, 'c008c4995dd6a756ec42b07e3300769e.jpg', '2025-04-29 01:50:27');

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
(3, 1794, 0, 0, 0, 0, 0, 0, 0, 0, 31, 0),
(4, 1, 0, 0, 0, 0, 0, 0, 5, 0, 0, 0),
(5, 1168, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0),
(6, 2, 0, 0, 0, 1, 0, 0, 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Employee','HR','HR HEAD','Admin') NOT NULL,
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
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `approved_by_ibfk2` (`approved_by`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `fk_leave_type` (`leave_type_id`),
  ADD KEY `leave_request_id` (`leave_request_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=522;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `total_balance`
--
ALTER TABLE `total_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `used_balance`
--
ALTER TABLE `used_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uploaded_by_file` FOREIGN KEY (`uploaded_by`) REFERENCES `ticket_responses` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `approved_by_ibfk2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_leave_type` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`leave_request_id`) REFERENCES `leave_requests` (`id`) ON DELETE SET NULL;

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
