-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 02, 2023 at 11:03 AM
-- Server version: 8.0.28
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sharda`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `AttendanceID` int NOT NULL AUTO_INCREMENT,
  `SystemID` int NOT NULL,
  `LectureID` int NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `LectureDate` date NOT NULL,
  PRIMARY KEY (`AttendanceID`),
  UNIQUE KEY `unique_attendance` (`LectureID`,`LectureDate`,`SystemID`),
  KEY `SystemID` (`SystemID`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AttendanceID`, `SystemID`, `LectureID`, `Status`, `LectureDate`) VALUES
(1, 2021300628, 1, 1, '2023-02-06'),
(2, 2021300628, 2, 1, '2023-02-06'),
(3, 2021355631, 7, 1, '2023-02-06'),
(4, 2021300628, 1, 1, '2023-02-13'),
(5, 2021300628, 3, 0, '2023-02-06'),
(47, 2021373298, 1, 0, '2023-02-06'),
(48, 2021355631, 1, 1, '2023-02-06'),
(55, 2021300628, 1, 1, '2023-02-11'),
(56, 2021373298, 1, 1, '2023-02-11'),
(81, 2021300628, 1, 1, '2023-02-12'),
(82, 2021373298, 1, 1, '2023-02-12'),
(161, 2021373298, 1, 1, '2023-02-13'),
(167, 2021300628, 2, 0, '2023-02-11'),
(168, 2021300628, 2, 0, '2023-02-12');

-- --------------------------------------------------------

--
-- Table structure for table `lecture`
--

DROP TABLE IF EXISTS `lecture`;
CREATE TABLE IF NOT EXISTS `lecture` (
  `LectureID` int NOT NULL AUTO_INCREMENT,
  `LectureName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `LectureCode` varchar(6) NOT NULL,
  `LectureDay` tinyint(1) NOT NULL,
  `LectureSlot` tinyint(1) NOT NULL,
  `Section` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`LectureID`),
  KEY `Section` (`Section`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lecture`
--

INSERT INTO `lecture` (`LectureID`, `LectureName`, `LectureCode`, `LectureDay`, `LectureSlot`, `Section`) VALUES
(1, 'Computer Networks', 'CSE252', 1, 1, 'E'),
(2, 'Database Management System', 'CSE249', 1, 2, 'E'),
(3, 'Advanced Java Lab', 'CSP014', 1, 3, 'E'),
(4, 'Advanced Java', 'CSE014', 1, 4, 'E'),
(5, 'ARP', 'ARP208', 1, 8, 'E'),
(6, 'TOC', 'CSE251', 2, 1, 'E'),
(7, 'Computer Networks', 'CSE252', 1, 1, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `SystemID` int NOT NULL,
  `StudentName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `StudentAge` int NOT NULL,
  `Section` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`SystemID`),
  KEY `idx_student_section` (`Section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`SystemID`, `StudentName`, `StudentAge`, `Section`) VALUES
(2021300628, 'Akshat Gautam', 18, 'E'),
(2021355631, 'Ayush Aggarwal', 19, 'C'),
(2021373298, 'Anubhav Singh', 20, 'E');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

DROP TABLE IF EXISTS `userlogin`;
CREATE TABLE IF NOT EXISTS `userlogin` (
  `SystemID` int NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`SystemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`SystemID`, `Password`) VALUES
(2021300628, '$2y$10$8VVzWXo7/3KMHDbRw7ItkuvKKdXqroGnODrcCsim/6pQo.gIlweCK'),
(2021355631, '$2y$10$8VVzWXo7/3KMHDbRw7ItkuvKKdXqroGnODrcCsim/6pQo.gIlweCK'),
(2021373298, '$2y$10$9hnZJ5gvixhqgS5JN80A2u2w37Hi929me7D.rjfVU9BJw14136ijW');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`SystemID`) REFERENCES `student` (`SystemID`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`LectureID`) REFERENCES `lecture` (`LectureID`);

--
-- Constraints for table `lecture`
--
ALTER TABLE `lecture`
  ADD CONSTRAINT `lecture_ibfk_1` FOREIGN KEY (`Section`) REFERENCES `student` (`Section`);

--
-- Constraints for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD CONSTRAINT `userlogin_ibfk_1` FOREIGN KEY (`SystemID`) REFERENCES `student` (`SystemID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
