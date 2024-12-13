-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 02:05 AM
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
-- Database: `student_evaluation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(5, 'admin', '$2y$10$mdo2pr0FUOPgpMKutNdD6uLSMobPvbkdIlGDXjeGbV5ec75eZLqR.');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `grade`, `status`) VALUES
(1, 2, 5, '1.0', 'approved'),
(2, 2, 1, '1.0', 'approved'),
(3, 2, 3, '3.0', 'approved'),
(4, 2, 3, '3.0', 'approved'),
(11, 5, 43, '2.75', 'approved'),
(12, 5, 44, '2.0', 'approved'),
(13, 5, 39, '5.0', 'approved'),
(14, 5, 40, '3.0', 'approved'),
(15, 5, 41, '5.0', 'approved'),
(16, 5, 42, '5.0', 'approved'),
(20, 2, 7, '2.0', 'approved'),
(21, 2, 7, '2.0', 'approved'),
(22, 2, 2, '2.0', 'approved'),
(23, 2, 4, '2.0', 'approved'),
(24, 2, 4, '2.0', 'approved'),
(25, 2, 6, '1.0', 'approved'),
(26, 2, 6, '2.0', 'approved'),
(27, 2, 6, '2.0', 'approved'),
(28, 2, 9, '3.25', 'approved'),
(35, 2, 8, '5.0', 'approved'),
(36, 8, 25, '1.25', 'approved'),
(37, 8, 26, '3.0', 'approved'),
(38, 8, 27, '5.0', 'approved'),
(39, 8, 28, '1.75', 'approved'),
(40, 8, 29, '3.25', 'approved'),
(41, 8, 30, '3.25', 'approved'),
(42, 9, 48, '3.0', 'approved'),
(43, 8, 45, '2.75', 'approved'),
(44, 9, 45, '2.75', 'approved'),
(45, 8, 31, '3.25', 'approved'),
(46, 9, 46, '3', 'approved'),
(47, 9, 47, '3.25', 'approved'),
(52, 10, 5, '3', 'rejected'),
(53, 11, 43, '1.75', 'approved'),
(54, 11, 44, '2.75', 'approved'),
(55, 11, 39, '3.0', 'approved'),
(56, 11, 40, '1.0', 'approved'),
(57, 11, 41, '3.25', 'approved'),
(58, 11, 42, '3.75', 'approved'),
(59, 12, 37, '2', 'approved'),
(60, 12, 36, '1.25', 'approved'),
(61, 12, 35, '5.0', 'approved'),
(62, 12, 34, '5.0', 'approved'),
(63, 12, 32, '5.0', 'approved'),
(64, 12, 33, '5.0', 'approved'),
(65, 12, 38, '5.0', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `grade_submissions`
--

CREATE TABLE `grade_submissions` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `grade` int(11) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `year_level` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `username`, `password`, `name`, `year_level`, `semester`, `email`) VALUES
(1, 'test2', '$2y$10$u2bfEIsOwqUuSU7OhmBgiO0vkDegEzYlJBaEGmNRhu2qfO0Xz/b1C', 'irene oreiro', 3, 1, NULL),
(2, 'test', '$2y$10$MnxLevHUYB7YabUmdJQuSORTgsDJALhPpBlAswhDoarEmslvO1E6W', 'rere', 1, 1, NULL),
(5, 'pogi', '$2y$10$7BW0EOyJxXavodYeMRh8guoxbtJN8HkJ4oaJGBynjMnreKBtcISDu', 'jm', 3, 2, NULL),
(8, 'AbiasanRaymart@gmail.com', '$2y$10$mVvNxs7M/ev.ZeWc9X5ec.KZQxbfLbBikoGbeQA1f0YLiqz8zpT7y', 'Raymart Abiasan', 2, 2, NULL),
(9, 'abc@gmail.com', '$2y$10$zjFniX88MfLQetkV1VAjue6L0pQ6fMwBIgbdeA.nf45Y87RBPsIpS', 'abc', 4, 1, NULL),
(10, '123', '$2y$10$eIGCEaqLV51sUp44ptD7HeromVYSbLr0FkxmwuA5E4grWjVjWVZJm', 'rt', 1, 1, NULL),
(11, 'joshua@gmail.com', '$2y$10$LGDJIZ7tTHI2s8E0hbRB5.7Xfp/bSbYVnUP.9uaKbzG2jHkly58mK', 'joshua Lozano', 3, 2, NULL),
(12, 'Arjie@gmail.com', '$2y$10$Y47hbOeQbqHi94uENfN/De1dw1hJxwEaNfCcgM/j5Qi0ilWaRc9da', 'Arjie Pogi kuno', 3, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `year_level` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `subject_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `year_level`, `semester`, `subject_code`, `subject_name`) VALUES
(1, 1, 1, 'GE1', 'Understanding the Self/Pag-unawa sa Sarili'),
(2, 1, 1, 'GE4', 'Mathematics in the Modern World'),
(3, 1, 1, 'GE5', 'Purposive Communication'),
(4, 1, 1, 'GE8', 'Ethics/Etika'),
(5, 1, 1, 'EMST1', 'Living in the IT Era'),
(6, 1, 1, 'IT101', 'Introduction to Computing'),
(7, 1, 1, 'IT102', 'Computer Programming 1'),
(8, 1, 1, 'PE1', 'Physical Activities Toward Health and Fitness 1: Movement Competency Training'),
(9, 1, 1, 'NSTP1', 'CWTS1/ MS 11&12/ LTS1'),
(10, 1, 2, 'GE2', 'Readings in the Philippines History/ Mga Babasahin Hinggil sa Kasaysayan ng Pilipinas'),
(11, 1, 2, 'GE9', 'Rizal’s Life, Works and Writings/ Ang Buhay at mga Akda ni Rizal'),
(12, 1, 2, 'IT103', 'Computer Programming 2'),
(13, 1, 2, 'IT104', 'Introduction to Human-Computer Interaction'),
(14, 1, 2, 'IT105', 'Web Systems and Technologies 1'),
(15, 1, 2, 'IT106', 'Discrete Mathematics'),
(16, 1, 2, 'PE2', 'Physical Activities Toward Health and Fitness 2: Exercise-based Fitness Activities'),
(17, 1, 2, 'NSTP2', 'CWTS2/ MS 21&22/ LTS2'),
(18, 2, 1, 'GE3', 'The Contemporary World/Ang Kasalukuyang Daigdig'),
(19, 2, 1, 'IT201', 'Platform Technologies'),
(20, 2, 1, 'IT202', 'Object-Oriented Programming'),
(21, 2, 1, 'IT203', 'Integrative Programming and Technologies 1'),
(22, 2, 1, 'IT204', 'Information Management'),
(23, 2, 1, 'IT205', 'Data Structures and Algorithms'),
(24, 2, 1, 'PE3', 'Physical Activities Toward Health and Fitness 3: Sports'),
(25, 2, 2, 'GE6', 'Art Appreciation/Pagpapahalaga sa Sining'),
(26, 2, 2, 'IT206', 'Networking 1'),
(27, 2, 2, 'IT207', 'Advance Database Systems'),
(28, 2, 2, 'IT208', 'Quantitative Methods (incl. Modeling and Simulation)'),
(29, 2, 2, 'IT209', 'Web Systems and Technologies 2'),
(30, 2, 2, 'IT210', 'Systems Integration and Architecture 1'),
(31, 2, 2, 'PE4', 'Physical Activities Toward Health and Fitness 4: Outdoor and Adventure Activities'),
(32, 3, 1, 'GE7', 'Science, Technology and Society'),
(33, 3, 1, 'ESSP1', 'The Entrepreneurial Mind'),
(34, 3, 1, 'IT206', 'Networking 2'),
(35, 3, 1, 'IT301', 'Human-Computer Interaction 2'),
(36, 3, 1, 'IT302', 'Application Development and Emerging Technologies'),
(37, 3, 1, 'IT303', 'Information Assurance and Security 1'),
(38, 3, 1, 'Elective1', 'IT Elective 1'),
(39, 3, 2, 'ESSP3', 'Gender and Society'),
(40, 3, 2, 'IT304', 'Social and Professional Issues'),
(41, 3, 2, 'IT305', 'Information Assurance and Security 2'),
(42, 3, 2, 'IT306', 'Capstone Project 1'),
(43, 3, 2, 'Elective2', 'IT Elective 2'),
(44, 3, 2, 'Elective3', 'IT Elective 3'),
(45, 4, 1, 'IT401', 'System Administration and Maintenance'),
(46, 4, 1, 'IT402', 'Capstone Project 2'),
(47, 4, 1, 'IT403', 'Systems Integration and Architecture 2'),
(48, 4, 1, 'Elective4', 'IT Elective 4'),
(49, 4, 2, 'IT 404', 'Practicum (486 hours)');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `username`, `password`, `status`) VALUES
(8, 'teacher okay', 'test1', '$2y$10$TrT/GzM2eXkl/Mp1G2.DJO8sFY99uvXxlszmAElr8XiZHnetfjcES', 'approved'),
(9, 'orea', 'test01', '$2y$10$eWDt3QI5KKF90fYtkbNZAe.3R/wzYv9kxCZF1n9pdRMO7HD79G1.K', 'approved'),
(10, 'testteacher', 'test2gmail.com', '$2y$10$KbeXGYNlKgJLecyMT2Zfq.caxAn873rebPHiTjYNpiCFreVugjVkq', 'approved'),
(12, 'testteacher', 'test@gmail.com', '$2y$10$dOhlzLKczVVfAZ2a7Ts49uSOU1eKZ5JD1LTalkTVFp.k07rl44GmC', 'approved'),
(13, 'testtesttest', 'testtest@gmail.com', '$2y$10$hrE1Cw47M0UuQ9Rr7.Zk..PAcT1cDN.EN.o62LARA8EeotTNhNGRy', 'approved'),
(14, 'aaaa', 'aaaa', '$2y$10$YwGhSLLYViCj1V1EWEr6QOfxMMuT2zbO35ISALtnbrU6jMyXsl36W', 'approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `grades_ibfk_1` (`student_id`);

--
-- Indexes for table `grade_submissions`
--
ALTER TABLE `grade_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `year_level` (`year_level`,`semester`,`subject_code`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `grade_submissions`
--
ALTER TABLE `grade_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `grade_submissions`
--
ALTER TABLE `grade_submissions`
  ADD CONSTRAINT `grade_submissions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
