-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2024 at 10:33 AM
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
-- Database: `project1`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activityID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `semYear` varchar(20) DEFAULT NULL,
  `activityName` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activityID`, `userID`, `semYear`, `activityName`, `remarks`, `createdDate`) VALUES
(38, 66, 'Year 1/Sem 1', 'Website Portfolio Contest', 'test1', '2023-12-29 16:00:15'),
(39, 66, 'Year 4/Sem 2', 'Coding Contest', 'test2', '2023-12-29 16:00:54'),
(40, 66, 'Year 2/Sem 2', 'Hackathon', 'lalalala', '2023-12-29 16:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `ch_id` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `semYear` varchar(20) DEFAULT NULL,
  `challenge` text DEFAULT NULL,
  `plan` text DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`ch_id`, `userID`, `semYear`, `challenge`, `plan`, `remark`, `createdDate`) VALUES
(13, 66, 'Year 1/Sem 1', 'new to everything', 'adapt', 'test1', '2023-12-29 16:02:14'),
(14, 66, 'Year 4/Sem 2', 'Gave up on adapting', 'null', 'null', '2023-12-29 16:02:29'),
(15, 66, 'Year 3/Sem 1', 'what am i doing here', 'null', 'null', '2023-12-29 16:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `kpi_indicators`
--

CREATE TABLE `kpi_indicators` (
  `kpi_id` int(11) NOT NULL,
  `indicator_name` varchar(255) NOT NULL,
  `indicator_type` varchar(255) NOT NULL,
  `faculty_kpi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kpi_indicators`
--

INSERT INTO `kpi_indicators` (`kpi_id`, `indicator_name`, `indicator_type`, `faculty_kpi`) VALUES
(1, 'CGP', 'CGP', '≥3.00'),
(2, 'Faculty Level', 'Student Activities', '4'),
(3, 'University Level', 'Student Activities', '4'),
(4, 'National Level', 'Student Activities', '1'),
(5, 'International Level', 'Student Activities', '1'),
(6, 'Faculty Level', 'Competition', '2'),
(7, 'University Level', 'Competition', '2'),
(8, 'National Level', 'Competition', '1'),
(9, 'International Level', 'Competition', '1'),
(10, 'Leadership', 'Leadership', '2'),
(11, 'Graduate Aim', 'Graduate Aim', 'On Time'),
(12, 'Professional Certification', 'Professional Certification', '≥1'),
(13, 'Employability', 'Employability', 'Within 3 months after Industrial Training'),
(14, 'Mobility Program', 'Mobility Program', '1');

-- --------------------------------------------------------

--
-- Table structure for table `kpi_values`
--

CREATE TABLE `kpi_values` (
  `kpi_value_id` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `kpi_id` int(11) DEFAULT NULL,
  `semester` int(50) DEFAULT NULL,
  `year` int(50) DEFAULT NULL,
  `student_aim` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kpi_values`
--

INSERT INTO `kpi_values` (`kpi_value_id`, `userID`, `kpi_id`, `semester`, `year`, `student_aim`, `value`, `remark`, `createdDate`) VALUES
(86, 66, 1, 1, 1, '3.67', '4', '4', '2023-12-29 15:56:12'),
(87, 66, 1, 2, 1, '3.67', '3.3', 'test', '2023-12-29 15:56:33'),
(88, 66, 1, 1, 2, '4', '3', 'test2', '2023-12-29 15:57:04'),
(89, 66, 1, 2, 2, '3.33', '3', '3', '2023-12-29 15:57:24'),
(91, 66, 1, 1, 3, '3.67', '3.5', 'test4', '2023-12-29 15:57:55'),
(92, 66, 1, 1, 4, '3.3', '3.67', 'wew', '2023-12-29 15:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `program` varchar(50) DEFAULT NULL,
  `mentor` varchar(255) DEFAULT NULL,
  `motto` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT 'cute.jpg',
  `phone_number` varchar(20) DEFAULT NULL,
  `state_of_origin` varchar(50) DEFAULT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `intake_batch` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `userID`, `username`, `program`, `mentor`, `motto`, `profile_photo`, `phone_number`, `state_of_origin`, `home_address`, `intake_batch`) VALUES
(66, 66, 'SIEW KHAI JUN', 'Software Engineering', 'DR. CHIN KIM ON', 'learn earlier lalala', 'cutie.jpg', '011-39847577', 'Selangor', '12', ''),
(69, 69, '', '', '', '', 'cute.jpg', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `matricNo` varchar(20) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `registrationDate` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `matricNo`, `userEmail`, `userPassword`, `registrationDate`) VALUES
(66, 'BI21110201', 'siewkhaijun57@gmail.com', '$2y$10$aZ4VgWET5TPa9LzsclCJQeTRGH0MbcWv6NX76V9F5bnmurpZvw0X.', '2023-12-29'),
(69, 'BI21110202', 'dongdong@gmail.com', '$2y$10$GJJmbDcfSIykspjGFTPdae/aJzetVDzpLunY.NqSDPHd.eHVFbCbS', '2024-02-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activityID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`ch_id`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `kpi_indicators`
--
ALTER TABLE `kpi_indicators`
  ADD PRIMARY KEY (`kpi_id`,`indicator_type`);

--
-- Indexes for table `kpi_values`
--
ALTER TABLE `kpi_values`
  ADD PRIMARY KEY (`kpi_value_id`),
  ADD KEY `userID` (`userID`),
  ADD KEY `kpi_id` (`kpi_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `ch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kpi_indicators`
--
ALTER TABLE `kpi_indicators`
  MODIFY `kpi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kpi_values`
--
ALTER TABLE `kpi_values`
  MODIFY `kpi_value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `kpi_values`
--
ALTER TABLE `kpi_values`
  ADD CONSTRAINT `kpi_values_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `kpi_values_ibfk_2` FOREIGN KEY (`kpi_id`) REFERENCES `kpi_indicators` (`kpi_id`) ON DELETE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
