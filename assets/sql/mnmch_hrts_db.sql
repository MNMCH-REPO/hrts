-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 06:50 AM
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
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(47, 'DECLINE', 'tickets', 9, 'Declined ticket ID 9 and removed assignment.', 1500, '2025-04-08 21:41:32');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `employee_id`, `subject`, `description`, `status`, `priority`, `category_id`, `assigned_to`, `created_at`, `updated_at`) VALUES
(1, 1, 'Issue with IT support', 'The employee cannot access their work computer.', 'Open', 'High', 1, NULL, '2025-04-08 07:05:34', NULL),
(2, 2, 'HR issue regarding leaves', 'The employee has trouble applying for leaves.', 'In Progress', 'Medium', 2, 2, '2025-04-04 12:45:02', NULL),
(4, 1200, 'Employee Relations concern', 'The employee raised an issue with a colleague.', 'Open', 'Low', 4, 2, '2025-03-12 04:15:00', NULL),
(5, 5, 'Technical issue with the software', 'The employee is unable to run the latest software update.', 'Open', 'Low', 5, 1731, '2025-03-12 04:20:00', NULL),
(6, 6, 'Payroll error', 'The payroll for last month was incorrect.', 'In Progress', 'Medium', 6, 1, '2025-03-12 04:25:00', NULL),
(8, 8, 'Office Equipment malfunction', 'The printer is not working in the office.', 'Resolved', 'Low', 8, NULL, '2025-03-12 04:35:00', NULL),
(9, 1500, 'Training request', 'The employee needs a training session on new software.', 'Open', 'Low', 9, NULL, '2025-03-12 04:40:00', NULL),
(10, 10, 'Health and Safety concern', 'There is a potential safety issue in the office building.', 'Open', 'High', 10, NULL, '2025-04-04 12:40:00', NULL),
(11, 2, 'Printer', 'something crazy shit', 'Open', 'Low', 5, 2, '2025-03-25 18:31:42', NULL),
(12, 2, 'HR Sample', 'HR Text sample', 'Open', 'Low', 2, 2, '2025-04-04 10:20:10', NULL),
(13, 2, 'Test', 'TExt', 'Open', 'Low', 6, 2, '2025-04-04 10:23:11', NULL),
(14, 2, '123', '123', 'Open', 'Low', 1, 2, '2025-04-04 10:25:58', NULL),
(15, 2, 'Printer', 'sample lans 123', 'In Progress', 'Medium', 6, 1799, '2025-04-08 02:45:34', NULL),
(16, 2, 'Printer', 'sample lans 123', 'Open', 'Low', 6, NULL, '2025-04-08 02:47:27', NULL),
(17, 2, '123123', '123123', 'Open', 'Low', 8, NULL, '2025-04-08 02:49:12', NULL),
(18, 2, 'asdasdsad', 'asdasdasdasd', 'Open', 'Low', 8, NULL, '2025-04-08 02:51:09', NULL);

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
(14, 2, 2, 'haksdoasdad asjkdashd;lak', '2025-04-08 03:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Employee','HR','Admin','Disable') NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `department`, `created_at`) VALUES
(1, 'John Mico D. Intacto', 'mico@gmail.com', '$2y$10$lmXq4CSpHjrEd11Itbnh1eyHR4Qz6XZ7NctSRHPrs9yqjCPSZ0RdW', 'Admin', 'HR Department', '2025-03-12 10:44:00'),
(2, 'Earl Gerald Domingo', 'earlgerald@gmail.com', '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja', 'Employee', 'MIS/IT DEPARTMENT', '2025-03-12 03:00:00'),
(5, 'dave', 'dave@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'ER Department', '2025-03-12 03:15:00'),
(6, 'eva', 'eva@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'IT Department', '2025-03-12 03:20:00'),
(7, 'frank', 'frank@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'HR Department', '2025-03-12 03:25:00'),
(8, 'grace', 'grace@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'Billing Department', '2025-03-12 03:30:00'),
(10, 'iris', 'iris@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'IT Department', '2025-03-12 03:40:00'),
(1200, 'carol', 'carol@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'INFORMATION DEPARTMENT', '2025-03-12 03:10:00'),
(1201, 'Charity Lizardo', 'cha@gmail.com', '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW', '', 'HRD DEPARTMENT', '2025-04-07 15:42:56'),
(1234, 'Bonet', 'bonet@gmail.com', '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW', '', 'PHARMACY DEPARTMENT', '2025-04-07 15:45:07'),
(1500, 'hank', 'hank@gmail.com', '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja', 'Employee', 'CASHIER DEPARTMENT', '2025-03-12 03:35:00'),
(1730, 'John Paulo Tagubar', 'paulo@gmail.com', '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW', 'Employee', 'Accounting Department', '2025-03-28 03:09:43'),
(1731, 'Ruzzel Rubien Abdon', 'ruzzel@gmail.com', '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW', 'Employee', 'Accounting Department', '2025-03-29 16:41:42'),
(1799, 'Dominic RM Daqui', 'dominic@gmail.com', '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW', 'Admin', 'MIS/IT DEPARTMENT', '2025-04-07 13:54:32'),
(3001, 'raymond', 'monde@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'EMERGENCY ROOM DEPARTMENT', '2025-03-12 03:05:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_responses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
