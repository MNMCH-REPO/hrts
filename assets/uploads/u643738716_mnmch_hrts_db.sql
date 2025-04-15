-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 12:33 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u643738716_mnmch_hrts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE IF NOT EXISTS `audit_trail` (
  `id` int(11) NOT NULL,
  `action_type` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `affected_table` enum('users','categories','tickets','ticket_responses','attachments') NOT NULL,
  `affected_id` int(11) NOT NULL,
  `details` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Paycheck'),
(2, 'Printer'),
(3, 'IT Support'),
(4, 'HR Issues'),
(5, 'Billing Queries'),
(6, 'Employee Relations'),
(7, 'Technical Support'),
(8, 'Payroll'),
(9, 'Leave Management'),
(10, 'Office Equipment'),
(11, 'Training and Development'),
(12, 'Health and Safety');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Open','In Progress','Resolved') DEFAULT 'Open',
  `priority` enum('Low','Medium','High') DEFAULT 'Low',
  `category_id` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `employee_id`, `subject`, `description`, `status`, `priority`, `category_id`, `assigned_to`, `created_at`, `updated_at`) VALUES
(4, 1, 'Paycheck', 'The paycheck was miscalculated. Fix that please Thank you!', 'Open', 'Medium', 1, 2, '2025-03-07 17:51:41', '2025-03-07 17:51:41'),
(5, 1, 'Printer', 'Printer was not connected to computer', 'Open', 'Medium', 2, 2, '2025-03-14 17:07:20', '2025-03-14 17:07:20'),
(6, 1, 'Paycheck', 'miscalculated', 'Open', 'High', 1, 2, '2025-03-14 17:07:50', '2025-03-14 17:07:50'),
(17, 1, 'Issue with IT support', 'The employee cannot access their work computer.', 'Open', 'High', 1, NULL, '2025-03-12 04:00:00', '2025-03-12 04:00:00'),
(18, 2, 'HR issue regarding leaves', 'The employee has trouble applying for leaves.', 'Open', 'Medium', 2, 3, '2025-03-12 04:05:00', '2025-03-20 01:50:19'),
(19, 3, 'Billing discrepancy', 'There is a mismatch in the billing statement for last month.', 'Open', 'High', 3, NULL, '2025-03-12 04:10:00', '2025-03-12 04:10:00'),
(20, 4, 'Employee Relations concern', 'The employee raised an issue with a colleague.', 'Open', 'Medium', 4, NULL, '2025-03-12 04:15:00', '2025-03-12 04:15:00'),
(21, 5, 'Technical issue with the software', 'The employee is unable to run the latest software update.', 'Open', 'High', 5, NULL, '2025-03-12 04:20:00', '2025-03-12 04:20:00'),
(22, 6, 'Payroll error', 'The payroll for last month was incorrect.', 'Open', 'High', 6, NULL, '2025-03-12 04:25:00', '2025-03-12 04:25:00'),
(23, 7, 'Leave Management problem', 'The employee cannot view their leave balance correctly.', 'Open', 'Low', 7, NULL, '2025-03-12 04:30:00', '2025-03-12 04:30:00'),
(24, 8, 'Office Equipment malfunction', 'The printer is not working in the office.', 'Open', 'Low', 8, NULL, '2025-03-12 04:35:00', '2025-03-12 04:35:00'),
(25, 9, 'Training request', 'The employee needs a training session on new software.', 'Open', 'Medium', 9, NULL, '2025-03-12 04:40:00', '2025-03-12 04:40:00'),
(26, 10, 'Health and Safety concern', 'There is a potential safety issue in the office building.', 'Open', 'High', 10, NULL, '2025-03-12 04:45:00', '2025-03-12 04:45:00'),
(37, 1, 'System Login Issue', 'Unable to login to the system, showing an error.', 'Open', 'High', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(38, 1, 'Email Not Sending', 'Emails are stuck in outbox.', 'Open', 'Medium', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(39, 1, 'Password Reset Request', 'Forgot password and need assistance resetting.', 'Open', 'Low', 4, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(40, 1, 'Application Crash', 'Software keeps crashing on launch.', 'Open', 'High', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(41, 1, 'Monitor Flickering', 'Screen flickers frequently.', 'Open', 'Medium', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(42, 1, 'Software License Issue', 'License expired and needs renewal.', 'Open', 'High', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(43, 1, 'Request for VPN Access', 'Need VPN access to work remotely.', 'Open', 'Medium', 4, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(44, 1, 'Slow Computer', 'System running extremely slow.', 'Open', 'High', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(45, 1, 'Request for New Keyboard', 'Current keyboard is malfunctioning.', 'Open', 'Low', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(46, 1, 'Network Issues', 'Internet connectivity is unstable.', 'Open', 'High', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(47, 22, 'Software Installation', 'Request to install new software.', 'Open', 'Medium', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(48, 22, 'Antivirus Update Needed', 'Antivirus software needs updating.', 'Open', 'High', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(49, 24, 'Network Connectivity', 'Frequent WiFi disconnection.', 'Open', 'High', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(50, 24, 'Account Locked', 'Locked out of work account.', 'Open', 'High', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(51, 24, 'Printer Not Working', 'Printer in IT department is not responding.', 'Open', 'Low', 4, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(52, 27, 'Phone Not Working', 'Desk phone is not working.', 'Open', 'Medium', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(53, 27, 'Request for New Mouse', 'Current mouse is faulty.', 'Open', 'Low', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(54, 27, 'Scanner Malfunction', 'Unable to scan documents.', 'Open', 'High', 4, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(55, 28, 'Billing Error', 'Incorrect billing charges.', 'Open', 'High', 5, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(56, 28, 'New Employee Onboarding', 'Request for system access for a new hire.', 'Open', 'Medium', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(57, 30, 'Data Backup Request', 'Need to back up important data.', 'Open', 'High', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(58, 30, 'File Recovery Needed', 'Accidentally deleted files need recovery.', 'Open', 'High', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(59, 1, 'Email Configuration Issue', 'Email setup not working properly.', 'Open', 'Medium', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(60, 1, 'Lost Laptop', 'Laptop missing, need assistance.', 'Open', 'High', 4, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(61, 1, 'Request for Additional Storage', 'Need more cloud storage space.', 'Open', 'Medium', 5, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(62, 1, 'Database Error', 'Database query returning incorrect results.', 'Open', 'High', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(63, 1, 'New Software Access', 'Requesting access to new application.', 'Open', 'Medium', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(64, 1, 'Workstation Not Booting', 'Computer not turning on.', 'Open', 'High', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(65, 1, 'USB Ports Not Working', 'USB ports not recognizing devices.', 'Open', 'Low', 4, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(66, 1, 'Projector Not Working', 'Projector not displaying properly.', 'Open', 'Medium', 5, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(67, 1, 'Slow Internet Speed', 'Internet speed is significantly slow.', 'Open', 'High', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(68, 1, 'Document Printing Error', 'Printing documents results in errors.', 'Open', 'Medium', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(69, 1, 'Request for Second Monitor', 'Need a dual-monitor setup.', 'Open', 'Low', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(70, 1, 'Broken Headset', 'Requesting a replacement for a broken headset.', 'Open', 'Low', 4, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(71, 1, 'Request for Software Training', 'Need training for new software.', 'Open', 'Medium', 5, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(72, 1, 'Timekeeping System Down', 'Unable to log work hours.', 'Open', 'High', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(73, 1, 'Unresponsive Webpage', 'Web app not loading properly.', 'Open', 'Medium', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(74, 1, 'System Update Failure', 'Failed to install system updates.', 'Open', 'High', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(75, 1, 'Mobile App Not Syncing', 'Mobile app not syncing with the server.', 'Open', 'Medium', 4, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(76, 1, 'Request for New Docking Station', 'Need a new docking station for my laptop.', 'Open', 'Low', 5, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(77, 22, 'Timeclock System Glitch', 'Timeclock does not recognize my entry.', 'Open', 'Medium', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(78, 22, 'Badge Not Scanning', 'Work badge not scanning at entry.', 'Open', 'High', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(79, 24, 'ERP System Access Issue', 'ERP system not granting full access.', 'Open', 'Medium', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(80, 24, 'Power Surge Damage', 'Computer damaged after a power surge.', 'Open', 'High', 4, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(81, 27, 'Webcam Not Working', 'Unable to use webcam for meetings.', 'Open', 'Low', 5, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(82, 28, 'Finance Software Issue', 'Software not calculating totals correctly.', 'Open', 'High', 1, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(83, 30, 'Incorrect Payroll Entry', 'Payroll calculation is incorrect.', 'Open', 'High', 2, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37'),
(84, 30, 'Project Management Tool Access', 'Requesting access to project tracking tool.', 'Open', 'Medium', 3, NULL, '2025-03-20 12:12:37', '2025-03-20 12:12:37');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_responses`
--

CREATE TABLE IF NOT EXISTS `ticket_responses` (
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
(1, 4, 1, 'Paycheck was not computed correctly', '2025-03-11 09:18:48'),
(2, 4, 2, 'Hello, can you tell me more about the problem.', '2025-03-12 11:20:07'),
(48, 1, 3, 'Investigating the login issue. Will update soon.', '2025-03-20 12:20:28'),
(49, 1, 22, 'Still unable to access the system. Please assist.', '2025-03-20 12:20:28'),
(50, 2, 3, 'Email issue noted. Checking the mail server.', '2025-03-20 12:20:28'),
(51, 3, 24, 'Password reset link not working. Please send another.', '2025-03-20 12:20:28'),
(52, 4, 3, 'Checking application logs for crash reports.', '2025-03-20 12:20:28'),
(53, 5, 1, 'Screen flickering is getting worse.', '2025-03-20 12:20:28'),
(54, 6, 28, 'License renewal request has been forwarded to IT.', '2025-03-20 12:20:28'),
(55, 7, 1, 'VPN access request submitted for approval.', '2025-03-20 12:20:28'),
(56, 8, 3, 'Try clearing cache and restarting the system.', '2025-03-20 12:20:28'),
(57, 9, 30, 'New keyboard request has been approved.', '2025-03-20 12:20:28'),
(58, 10, 24, 'WiFi disconnecting frequently, please check.', '2025-03-20 12:20:28'),
(59, 11, 3, 'Software installation request in progress.', '2025-03-20 12:20:28'),
(60, 12, 1, 'Antivirus update needed soon.', '2025-03-20 12:20:28'),
(61, 13, 3, 'Resetting account credentials.', '2025-03-20 12:20:28'),
(62, 14, 27, 'Still unable to print documents.', '2025-03-20 12:20:28'),
(63, 15, 22, 'Printer issue forwarded to the IT department.', '2025-03-20 12:20:28'),
(64, 16, 1, 'Phone is still not functioning.', '2025-03-20 12:20:28'),
(65, 17, 3, 'New mouse request is being processed.', '2025-03-20 12:20:28'),
(66, 18, 24, 'Scanner still not responding.', '2025-03-20 12:20:28'),
(67, 19, 3, 'Billing team is reviewing the charges.', '2025-03-20 12:20:28'),
(68, 20, 30, 'New hire onboarding request approved.', '2025-03-20 12:20:28'),
(69, 21, 3, 'Data backup request in progress.', '2025-03-20 12:20:28'),
(70, 22, 1, 'Files were deleted accidentally. Need recovery.', '2025-03-20 12:20:28'),
(71, 23, 3, 'Email configuration issue noted.', '2025-03-20 12:20:28'),
(72, 24, 1, 'Laptop is still missing.', '2025-03-20 12:20:28'),
(73, 25, 3, 'Checking database query for errors.', '2025-03-20 12:20:28'),
(74, 26, 24, 'Need access to new software.', '2025-03-20 12:20:28'),
(75, 27, 3, 'System update attempt failed.', '2025-03-20 12:20:28'),
(76, 28, 22, 'Projector still not displaying properly.', '2025-03-20 12:20:28'),
(77, 29, 30, 'Slow internet issue under investigation.', '2025-03-20 12:20:28'),
(78, 30, 3, 'Printing errors being checked.', '2025-03-20 12:20:28'),
(79, 31, 1, 'Requesting second monitor for dual setup.', '2025-03-20 12:20:28'),
(80, 32, 3, 'Headset replacement request submitted.', '2025-03-20 12:20:28'),
(81, 33, 24, 'Training for new software scheduled.', '2025-03-20 12:20:28'),
(82, 34, 3, 'Timekeeping system issue being checked.', '2025-03-20 12:20:28'),
(83, 35, 22, 'Webpage still not loading properly.', '2025-03-20 12:20:28'),
(84, 36, 3, 'System updates causing failure.', '2025-03-20 12:20:28'),
(85, 37, 1, 'Mobile app sync still failing.', '2025-03-20 12:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Employee','HR','Admin') NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `department`, `created_at`) VALUES
(1, 'Earl Gerald Domingo', 'earl@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'Admitting Department', '2025-03-07 15:47:06'),
(2, 'Raymond Gonzales', 'raymond@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'Human Resource Department', '2025-03-07 17:47:34'),
(3, 'Mico', 'mico@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Admin', 'IT Department', '2025-03-10 00:51:49'),
(22, 'prince', 'prince@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'IT Department', '2025-03-19 13:23:00'),
(23, 'malik', 'malik@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'Billing Department', '2025-03-19 13:23:00'),
(24, 'alice', 'alice@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'IT Department', '2025-03-19 13:23:00'),
(25, 'bob', 'bob@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'HR Department', '2025-03-19 13:23:00'),
(26, 'carol', 'carol@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'Billing Department', '2025-03-19 13:23:00'),
(27, 'dave', 'dave@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'ER Department', '2025-03-19 13:23:00'),
(28, 'eva', 'eva@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'IT Department', '2025-03-19 13:23:00'),
(29, 'frank', 'frank@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'HR Department', '2025-03-19 13:23:00'),
(30, 'grace', 'grace@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'Billing Department', '2025-03-19 13:23:00'),
(40, 'carol', 'carol@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'Billing Department', '2025-03-12 03:10:00'),
(41, 'dave', 'dave@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'ER Department', '2025-03-12 03:15:00'),
(42, 'eva', 'eva@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'IT Department', '2025-03-12 03:20:00'),
(43, 'frank', 'frank@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'HR Department', '2025-03-12 03:25:00'),
(44, 'grace', 'grace@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'Billing Department', '2025-03-12 03:30:00'),
(45, 'hank', 'hank@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'ER Department', '2025-03-12 03:35:00'),
(46, 'iris', 'iris@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'IT Department', '2025-03-12 03:40:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  ADD CONSTRAINT `ticket_responses_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_responses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
