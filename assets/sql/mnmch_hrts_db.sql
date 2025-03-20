-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 12:23 PM
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

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Open','In Progress','Resolved','Closed') DEFAULT 'Open',
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
(1, 1, 'Issue with IT support', 'The employee cannot access their work computer.', 'Open', 'High', 1, NULL, '2025-03-12 04:00:00', '2025-03-12 04:00:00'),
(2, 2, 'HR issue regarding leaves', 'The employee has trouble applying for leaves.', 'Open', 'Medium', 2, 3, '2025-03-12 04:05:00', '2025-03-20 01:50:19'),
(3, 3, 'Billing discrepancy', 'There is a mismatch in the billing statement for last month.', 'Open', 'High', 3, NULL, '2025-03-12 04:10:00', '2025-03-12 04:10:00'),
(4, 4, 'Employee Relations concern', 'The employee raised an issue with a colleague.', 'Open', 'Medium', 4, NULL, '2025-03-12 04:15:00', '2025-03-12 04:15:00'),
(5, 5, 'Technical issue with the software', 'The employee is unable to run the latest software update.', 'Open', 'High', 5, NULL, '2025-03-12 04:20:00', '2025-03-12 04:20:00'),
(6, 6, 'Payroll error', 'The payroll for last month was incorrect.', 'Open', 'High', 6, NULL, '2025-03-12 04:25:00', '2025-03-12 04:25:00'),
(7, 7, 'Leave Management problem', 'The employee cannot view their leave balance correctly.', 'Open', 'Low', 7, NULL, '2025-03-12 04:30:00', '2025-03-12 04:30:00'),
(8, 8, 'Office Equipment malfunction', 'The printer is not working in the office.', 'Open', 'Low', 8, NULL, '2025-03-12 04:35:00', '2025-03-12 04:35:00'),
(9, 9, 'Training request', 'The employee needs a training session on new software.', 'Open', 'Medium', 9, NULL, '2025-03-12 04:40:00', '2025-03-12 04:40:00'),
(10, 10, 'Health and Safety concern', 'There is a potential safety issue in the office building.', 'Open', 'High', 10, NULL, '2025-03-12 04:45:00', '2025-03-12 04:45:00');

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
(1, 1, 2, 'Hello can you help me with this problem?', '2025-03-19 14:01:03'),
(2, 2, 2, 'HELLO', '2025-03-19 14:48:51'),
(3, 2, 2, 'CAN YOU HELP ME WITH THIS PROBLEM', '2025-03-19 14:49:32'),
(4, 2, 3, 'CAN YOU TELL ME MORE ABOUT THE PROBLEM?\r\n', '2025-03-19 14:50:29'),
(5, 2, 2, 'sample 1', '2025-03-20 03:10:29'),
(6, 2, 2, 'sample v2', '2025-03-20 03:10:31'),
(7, 2, 2, 'sample 3', '2025-03-20 03:10:33'),
(8, 2, 2, 'sample 5', '2025-03-20 03:10:35'),
(9, 2, 2, 'saomoke', '2025-03-20 03:10:36'),
(10, 2, 2, 'test 123', '2025-03-20 06:12:46'),
(11, 2, 2, 'baho', '2025-03-20 06:12:49');

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
(1, 'mico', 'mico@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Admin', 'HR', '2025-03-12 10:44:00'),
(2, 'earl', 'earl@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'IT Department', '2025-03-12 03:00:00'),
(3, 'raymond', 'raymond@gmail.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'HR Department', '2025-03-12 03:05:00'),
(4, 'carol', 'carol@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'Billing Department', '2025-03-12 03:10:00'),
(5, 'dave', 'dave@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'ER Department', '2025-03-12 03:15:00'),
(6, 'eva', 'eva@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'IT Department', '2025-03-12 03:20:00'),
(7, 'frank', 'frank@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'HR Department', '2025-03-12 03:25:00'),
(8, 'grace', 'grace@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'Billing Department', '2025-03-12 03:30:00'),
(9, 'hank', 'hank@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'Employee', 'ER Department', '2025-03-12 03:35:00'),
(10, 'iris', 'iris@example.com', '$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.', 'HR', 'IT Department', '2025-03-12 03:40:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
