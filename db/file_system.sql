-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 04:29 PM
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
-- Database: `file_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `date`, `name`, `mobile`, `email`, `photo`, `pass`, `status`) VALUES
(1, '2025-02-19', 'Hemant Gowardipe', '9881976415', 'rajugowardipe0@gmail.com', 'profile_1741014284.png', 'hemant@2005', 'Active'),
(15, '2025-02-26', 'Geeta Gowardipe ', '09881976415', 'rajugowardipe94@gmail.com', 'profile_1740571994.jpg', 'raju@134', 'Active'),
(16, '2025-03-03', 'Akanksha Gowardipe ', '9923190543', 'geetagowardipe@gmail.com', 'profile_1741011920.jpg', 'akanksha@2011', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('folder','video','image') NOT NULL,
  `file_size` int(11) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `shareable_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `user_id`, `file_name`, `file_path`, `file_type`, `file_size`, `upload_time`, `uploaded_at`, `shareable_link`) VALUES
(1, 1, 'IMG_20240130_161923_239.jpg', 'uploads/1739953965_IMG_20240130_161923_239.jpg', 'image', 5838749, '2025-02-19 08:32:45', '2025-02-19 09:20:09', NULL),
(2, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954110_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:10', '2025-02-19 09:20:09', NULL),
(3, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954116_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:16', '2025-02-19 09:20:09', NULL),
(4, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954140_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:40', '2025-02-19 09:20:09', NULL),
(5, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954147_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:47', '2025-02-19 09:20:09', NULL),
(6, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954192_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:36:32', '2025-02-19 09:20:09', NULL),
(7, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954229_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:37:09', '2025-02-19 09:20:09', NULL),
(8, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954260_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:37:40', '2025-02-19 09:20:09', NULL),
(9, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954267_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:37:47', '2025-02-19 09:20:09', NULL),
(10, 1, 'Screen Recording 2025-02-19 140933.mp4', 'uploads/1739954384_Screen Recording 2025-02-19 140933.mp4', 'video', 16915255, '2025-02-19 08:39:44', '2025-02-19 09:20:09', NULL),
(11, 1, 'IMG_20250131_155750.jpg', 'uploads/1739958691_IMG_20250131_155750.jpg', 'image', 22790412, '2025-02-19 09:51:31', '2025-02-19 09:51:31', NULL),
(12, 1, 'DSA PLan.pdf', 'uploads/1739971933_DSA PLan.pdf', 'folder', 29706, '2025-02-19 13:32:13', '2025-02-19 13:32:13', NULL),
(13, 1, 'Chhatrapati-Shivaji-Maharaj-The-Fearless-Warrior-Status-Videos.mp4', 'uploads/1739972185_Chhatrapati-Shivaji-Maharaj-The-Fearless-Warrior-Status-Videos.mp4', 'video', 7143580, '2025-02-19 13:36:25', '2025-02-19 13:36:25', NULL),
(14, 1, '10th Marksheet.pdf', 'uploads/1740118818_10th Marksheet.pdf', 'folder', 178900, '2025-02-21 06:20:18', '2025-02-21 06:20:18', NULL),
(15, 1, 'car', 'uploads/1740563588_car_drift.mp4', 'video', 13634329, '2025-02-26 09:53:08', '2025-02-26 09:53:08', NULL),
(16, 1, 'IMG_20250131_155806.jpg', 'uploads/1740564348_IMG_20250131_155806.jpg', 'image', 163342, '2025-02-26 10:05:48', '2025-02-26 10:05:48', NULL),
(17, 15, '20240130_164025.jpg', 'uploads/1740572629_20240130_164025.jpg', 'image', 5953365, '2025-02-26 12:23:49', '2025-02-26 12:23:49', NULL),
(18, 15, 'SITnovatePresentationTemplate.pptx', 'uploads/1740572958_SITnovatePresentationTemplate.pptx', 'folder', 368912, '2025-02-26 12:29:18', '2025-02-26 12:29:18', NULL),
(19, 15, 'IMG-20230223-WA0023.jpg', 'uploads/1740572972_IMG-20230223-WA0023.jpg', 'image', 150482, '2025-02-26 12:29:32', '2025-02-26 12:29:32', NULL),
(20, 1, 'gitprofile.jpg', 'uploads/1740838034_gitprofile.jpg', 'image', 1615855, '2025-03-01 14:07:14', '2025-03-01 14:07:14', NULL),
(21, 15, 'gitprofile.jpg', 'uploads/1740838193_gitprofile.jpg', 'image', 1615855, '2025-03-01 14:09:53', '2025-03-01 14:09:53', NULL),
(22, 1, 'gitprofile (1).jpg', 'uploads/1740852589_gitprofile (1).jpg', 'image', 430051, '2025-03-01 18:09:49', '2025-03-01 18:09:49', NULL),
(23, 1, '20240130_162012.jpg', 'uploads/1740907444_20240130_162012.jpg', 'image', 5932064, '2025-03-02 09:25:37', '2025-03-02 09:25:37', NULL),
(24, 1, '20240130_163954.jpg', 'uploads/1740909051_20240130_163954.jpg', 'image', 5472179, '2025-03-02 09:50:51', '2025-03-02 09:50:51', NULL),
(25, 1, 'IMG_20250131_155810.jpg', 'uploads/1740909325_IMG_20250131_155810.jpg', 'image', 23173543, '2025-03-02 09:55:25', '2025-03-02 09:55:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`id`, `user_id`, `login_time`, `logout_time`, `duration`) VALUES
(2, 1, '2025-03-02 12:17:05', '2025-03-02 12:17:34', 29),
(3, 1, '2025-03-02 12:26:28', '2025-03-02 12:27:24', 56),
(4, 1, '2025-03-02 12:30:48', '2025-03-02 12:35:22', 274),
(5, 15, '2025-03-02 12:43:45', '2025-03-02 12:44:57', 72),
(6, 15, '2025-03-02 12:56:31', '2025-03-02 13:04:33', 482),
(7, 1, '2025-03-02 14:30:27', NULL, 0),
(8, 1, '2025-03-02 14:58:27', '2025-03-02 15:47:33', 2946),
(9, 16, '2025-03-03 19:56:00', '2025-03-03 19:56:58', 58),
(10, 1, '2025-03-03 19:58:07', '2025-03-03 20:03:37', 330),
(11, 1, '2025-03-03 20:32:31', '2025-03-03 20:35:22', 171);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
