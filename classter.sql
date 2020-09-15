-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2020 at 08:26 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classter`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announce_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `class_id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `edited` tinyint(1) NOT NULL DEFAULT 0,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announce_id`, `title`, `description`, `class_id`, `author_id`, `edited`, `reg_date`) VALUES
(4, '                             ff           ', '                                  ff      ', 1, 1, 0, '2020-09-15 14:51:46'),
(5, '                          test kale che have              ', '                                    ane vacahani aavjo\r\n    ', 3, 2, 0, '2020-09-15 18:23:25');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(10) UNSIGNED NOT NULL,
  `branch_name` varchar(20) NOT NULL,
  `hod_id` int(10) UNSIGNED DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `hod_id`, `reg_date`) VALUES
(1, 'COMPS', NULL, '2020-08-27 12:08:24'),
(2, 'IT', NULL, '2020-08-27 12:08:24'),
(3, 'CIVIL', NULL, '2020-08-27 12:08:34'),
(4, 'EXTC', 5, '2020-09-15 06:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(10) UNSIGNED NOT NULL,
  `name` char(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `teacher_id` int(10) UNSIGNED NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `name`, `subject`, `branch_id`, `teacher_id`, `reg_date`) VALUES
(1, 'SE-A', 'DS', 1, 1, '2020-09-15 12:48:22'),
(3, 'SE-C', 'DS', 1, 2, '2020-09-15 18:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` varchar(1000) DEFAULT NULL,
  `announce_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED DEFAULT NULL,
  `faculty_id` int(10) UNSIGNED DEFAULT NULL,
  `edited` tinyint(1) NOT NULL DEFAULT 0,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `announce_id`, `student_id`, `faculty_id`, `edited`, `reg_date`) VALUES
(1, 'hello boiiiii', 2, NULL, 1, 0, '2020-09-15 13:06:29'),
(2, '<a href=\"https://getbootstrap.com/docs/4.0/components/forms/\">https://getbootstrap.com/docs/4.0/components/forms/</a>', 2, NULL, 1, 0, '2020-09-15 13:07:36'),
(3, '<a href=\"https://drive.google.com/file/d/1pj5n1kkLutsuBRz3tzpwExHd-bijpfYv/view\">https://drive.google.com/file/d/1pj5n1kkLutsuBRz3tzpwExHd-bijpfYv/view</a>', 3, NULL, 1, 0, '2020-09-15 13:10:51'),
(4, 'hi', 1, NULL, 1, 0, '2020-09-15 13:20:32'),
(5, 'h', 1, NULL, 1, 0, '2020-09-15 13:49:44'),
(6, 'h', 1, NULL, 1, 0, '2020-09-15 14:04:37'),
(7, 'h', 1, NULL, 1, 0, '2020-09-15 14:04:54'),
(8, 'h', 1, NULL, 1, 0, '2020-09-15 14:07:12'),
(9, 'h', 1, NULL, 1, 0, '2020-09-15 14:08:35'),
(10, 'h', 1, NULL, 1, 0, '2020-09-15 14:09:13'),
(11, 'h', 1, NULL, 1, 0, '2020-09-15 14:09:50'),
(12, 'h', 1, NULL, 1, 0, '2020-09-15 14:11:53'),
(13, 'h', 1, NULL, 1, 0, '2020-09-15 14:13:02'),
(14, 'h', 1, NULL, 1, 0, '2020-09-15 14:13:20'),
(15, 'h', 1, NULL, 1, 0, '2020-09-15 14:13:46'),
(16, 'h', 1, NULL, 1, 0, '2020-09-15 14:14:00'),
(17, 'h', 1, NULL, 1, 0, '2020-09-15 14:14:36'),
(18, 'h', 1, NULL, 1, 0, '2020-09-15 14:15:08'),
(19, 'h', 1, NULL, 1, 0, '2020-09-15 14:15:52'),
(20, 'h', 1, NULL, 1, 0, '2020-09-15 14:16:07'),
(35, 'su vachvanu che?', 5, NULL, 2, 0, '2020-09-15 18:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `statuscode`
--

CREATE TABLE `statuscode` (
  `position` char(30) NOT NULL,
  `secret_code` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statuscode`
--

INSERT INTO `statuscode` (`position`, `secret_code`, `reg_date`) VALUES
('admin', 'abc123', '2020-08-25 16:56:21'),
('hod', '123abc', '2020-08-25 16:56:56'),
('teacher', '111abc', '2020-08-25 16:56:21'),
('viewer', 'NULL', '2020-08-25 16:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(10) UNSIGNED NOT NULL,
  `roll_no` int(10) UNSIGNED NOT NULL,
  `fullname` char(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `cgpa` float NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `roll_no`, `fullname`, `email`, `phone`, `cgpa`, `password`, `reg_date`) VALUES
(1, 2, 'Palak desai', 'palak1@gmail.com', '+919999955554', 10, 'b44dda1dadd351948fcace1856ed97366e679239', '2020-09-15 12:50:58'),
(2, 4, 'Foram', 'palak@gmail.com', '+919999922222', 8.9, 'b44dda1dadd351948fcace1856ed97366e679239', '2020-09-15 18:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `student_class`
--

CREATE TABLE `student_class` (
  `class_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_class`
--

INSERT INTO `student_class` (`class_id`, `student_id`) VALUES
(1, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `position` char(30) DEFAULT 'viewer',
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`user_id`, `username`, `email_id`, `password`, `position`, `reg_date`) VALUES
(1, 'Meet Turakhia', 'meet@gmail.com', 'b44dda1dadd351948fcace1856ed97366e679239', 'teacher', '2020-09-15 12:47:38'),
(2, 'Vasantiben', 'vasantiben@gmail.com', 'b44dda1dadd351948fcace1856ed97366e679239', 'teacher', '2020-09-15 18:21:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announce_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD UNIQUE KEY `branch_name` (`branch_name`),
  ADD KEY `hod_id` (`hod_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `announce_id` (`announce_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `statuscode`
--
ALTER TABLE `statuscode`
  ADD UNIQUE KEY `position` (`position`),
  ADD UNIQUE KEY `secret_code` (`secret_code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_class`
--
ALTER TABLE `student_class`
  ADD KEY `class_id` (`class_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announce_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `announcements_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `userdetails` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
