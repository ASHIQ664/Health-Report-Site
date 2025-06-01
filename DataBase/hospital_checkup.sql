-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2025 at 12:33 PM
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
-- Database: `hospital_checkup`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkups`
--

CREATE TABLE `checkups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `temperature` varchar(10) DEFAULT NULL,
  `blood_pressure` varchar(20) DEFAULT NULL,
  `sugar_level` varchar(20) DEFAULT NULL,
  `pain_level` varchar(50) DEFAULT NULL,
  `medicines` text DEFAULT NULL,
  `feeling` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkups`
--

INSERT INTO `checkups` (`id`, `user_id`, `full_name`, `phone`, `temperature`, `blood_pressure`, `sugar_level`, `pain_level`, `medicines`, `feeling`, `created_at`) VALUES
(10, 9, 'ashiq', '9929292', '12', '1', '12', '10', 'ss', 'dd', '2025-05-10 07:32:25'),
(11, 9, 'a', '9929292', '12', '1', '12', '10', 'asd', 'a', '2025-05-17 14:02:50'),
(12, 9, 'a', '9929292', '12', '1', '12', '10', 'asd', 'a', '2025-05-17 14:03:26'),
(13, 9, 'a', '9929292', '12', '1', '12', '10', 'asd', 'a', '2025-05-17 14:03:49'),
(14, 9, 'ax', '9992992', '12', '1', '12', '10', 'a', 'a', '2025-05-23 12:47:59'),
(15, 9, 'ashiq', '9992992', '12', '10', '1', '10', 's', '', '2025-05-31 07:17:04'),
(16, 9, 'ashiq', '9992992', '12', '10', '1', '10', '', '', '2025-05-31 07:33:12'),
(17, 9, 'ashiq', '9992992', '12', '10', '1', '10', '', '', '2025-05-31 07:34:47'),
(18, 9, 'ashiq', '9992992', '12', '10', '1', '10', '', '', '2025-05-31 07:45:14'),
(19, 9, 'ashiq', '9992992', '12', '10', '1', '10', 'djf', '', '2025-05-31 07:50:08'),
(20, 9, 'ashiq', '9992992', '12', '10', '1', '10', '', '', '2025-05-31 07:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `checkup_records`
--

CREATE TABLE `checkup_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `temperature` varchar(10) DEFAULT NULL,
  `blood_pressure` varchar(10) DEFAULT NULL,
  `sugar_level` varchar(10) DEFAULT NULL,
  `pain_level` varchar(10) DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `medications` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_feedback`
--

CREATE TABLE `doctor_feedback` (
  `id` int(11) NOT NULL,
  `checkup_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_feedback`
--

INSERT INTO `doctor_feedback` (`id`, `checkup_id`, `doctor_id`, `feedback`, `created_at`) VALUES
(1, 10, 8, 'hi', '2025-05-10 07:42:33'),
(2, 10, 8, 'hi', '2025-05-10 07:42:39'),
(3, 10, 8, 'hi', '2025-05-10 07:45:07'),
(4, 10, 8, 'hi', '2025-05-10 07:45:13'),
(5, 10, 8, 'hi', '2025-05-10 07:45:22'),
(6, 10, 8, 'hi', '2025-05-10 07:45:37'),
(7, 10, 8, 'hi', '2025-05-10 07:45:41'),
(8, 10, 8, 'hiiiiiii', '2025-05-10 07:45:53'),
(9, 10, 8, 'hi', '2025-05-10 07:48:30'),
(16, 14, 8, 'f', '2025-05-25 09:03:27'),
(17, 14, 8, 'goooooo', '2025-05-25 09:03:46'),
(18, 14, 8, 'goooooo', '2025-05-25 09:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_notes`
--

CREATE TABLE `doctor_notes` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `checkup_id` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `status` enum('paid','unpaid') DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `checkup_id`, `amount`, `status`, `created_at`) VALUES
(1, 9, 13, 5.00, 'paid', '2025-05-17 14:03:49'),
(2, 9, 14, 5.00, 'paid', '2025-05-23 12:47:59'),
(3, 9, 15, 5.00, 'paid', '2025-05-31 07:17:04'),
(4, 9, 16, 5.00, 'paid', '2025-05-31 07:33:12'),
(5, 9, 17, 5.00, 'paid', '2025-05-31 07:34:47'),
(6, 9, 18, 5.00, 'paid', '2025-05-31 07:45:14'),
(7, 9, 19, 5.00, 'paid', '2025-05-31 07:50:08'),
(8, 9, 20, 5.00, 'paid', '2025-05-31 07:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('patient','doctor') DEFAULT 'patient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(3, 'Dr Yaseer', 'yaseer@gmail.com', '$2y$10$.HmKPgFN//daZ74yxcuPJ..oGSCLBUVZiR5syysuMx9IgTRQ5jwEy', 'doctor'),
(8, 'DR. John', 'drjohn@gmail.com', '$2y$10$KOv23lA1Vg8N0oyDPX20auRSxgzvlh90DhVmY/po2bbmEfrqtF0pi', 'doctor'),
(9, 'ashiq', 'ashiqsese@gmail.com', '$2y$10$dRDBJM4fv4/T92oZNPrrOO4yxzjNr4k.ZyMtEohyXrE9oWE.CUfia', 'patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkups`
--
ALTER TABLE `checkups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `checkup_records`
--
ALTER TABLE `checkup_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `doctor_feedback`
--
ALTER TABLE `doctor_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checkup_id` (`checkup_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `checkup_id` (`checkup_id`);

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
-- AUTO_INCREMENT for table `checkups`
--
ALTER TABLE `checkups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `checkup_records`
--
ALTER TABLE `checkup_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_feedback`
--
ALTER TABLE `doctor_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkups`
--
ALTER TABLE `checkups`
  ADD CONSTRAINT `checkups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checkup_records`
--
ALTER TABLE `checkup_records`
  ADD CONSTRAINT `checkup_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `doctor_feedback`
--
ALTER TABLE `doctor_feedback`
  ADD CONSTRAINT `doctor_feedback_ibfk_1` FOREIGN KEY (`checkup_id`) REFERENCES `checkups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_feedback_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  ADD CONSTRAINT `doctor_notes_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `doctor_notes_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`checkup_id`) REFERENCES `checkups` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
