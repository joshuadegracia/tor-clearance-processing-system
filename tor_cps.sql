-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Oct 16, 2025 at 05:40 PM
-- Server version: 11.8.2-MariaDB
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tor_cps`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_No` int(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `admin_ID` int(10) NOT NULL,
  `student_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_No`, `type`, `password`, `admin_ID`, `student_ID`) VALUES
(14, 'master', '81dc9bdb52d04dc20036dbd8313ed055', 12345678, 0),
(17, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 10000001, 0),
(18, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 10000002, 0),
(20, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 10000003, 0),
(21, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 10000004, 0),
(22, 'user', '81dc9bdb52d04dc20036dbd8313ed055', 0, 2015102101),
(23, 'user', '81dc9bdb52d04dc20036dbd8313ed055', 0, 2015102102),
(24, 'admin', 'e3afed0047b08059d0fada10f400c1e5', 10000005, 0),
(27, 'user', '81dc9bdb52d04dc20036dbd8313ed055', 0, 2015102107),
(28, 'user', '81dc9bdb52d04dc20036dbd8313ed055', 0, 2015102108);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_ID` int(10) NOT NULL,
  `admin_lastname` varchar(50) NOT NULL,
  `admin_firstname` varchar(50) NOT NULL,
  `admin_middlename` varchar(50) NOT NULL,
  `admin_department` varchar(50) NOT NULL,
  `admin_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_ID`, `admin_lastname`, `admin_firstname`, `admin_middlename`, `admin_department`, `admin_role`) VALUES
(10000001, 'Sensei', 'Koro', '', 'Program Chair Department', 'Property Custodian'),
(10000002, 'Izumi', 'Sagiri', '', 'Library', 'Librarian'),
(10000003, 'Ryuzaki', 'Lawliet', '', 'SPS/Guidance', 'Guidance Councilor'),
(10000004, 'Yagami', 'Light', '', 'Finance', 'Finance Officer'),
(10000005, 'Admin', 'Admin', 'Admin', 'Program Chair Department', 'Property Custodian'),
(12345678, 'Admin', 'Master', '', 'All', 'Master Admin');

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `blacklist_ID` int(10) NOT NULL,
  `remark` varchar(100) NOT NULL,
  `student_ID` int(10) NOT NULL,
  `departmentID` int(10) NOT NULL,
  `admin_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `blacklist`
--

INSERT INTO `blacklist` (`blacklist_ID`, `remark`, `student_ID`, `departmentID`, `admin_ID`) VALUES
(76, 'Two Chairs', 2015102102, 16, 10000001),
(79, 'Bad moral', 2015102102, 15, 10000003),
(81, 'Loitering', 2015102107, 16, 10000001),
(82, '3 Lost Books', 2015102107, 14, 10000002),
(83, 'Mental Health Issue', 2015102107, 15, 10000003);

-- --------------------------------------------------------

--
-- Table structure for table `clearance`
--

CREATE TABLE `clearance` (
  `clearance_ID` int(10) NOT NULL,
  `clearance_status` varchar(50) NOT NULL,
  `student_ID` int(10) NOT NULL,
  `departmentID` int(10) NOT NULL,
  `admin_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clearance`
--

INSERT INTO `clearance` (`clearance_ID`, `clearance_status`, `student_ID`, `departmentID`, `admin_ID`) VALUES
(105, 'Clear', 2015102101, 16, 10000001),
(107, 'Clear', 2015102101, 14, 10000002),
(108, 'Clear', 2015102101, 15, 10000003),
(109, 'Clear', 2015102101, 17, 10000004),
(110, 'Not Clear', 2015102102, 16, 10000001),
(113, 'Clear', 2015102102, 14, 10000002),
(114, 'Not Clear', 2015102102, 15, 10000003),
(115, 'Clear', 2015102102, 17, 10000004),
(123, 'Not Clear', 2015102107, 16, 10000001),
(124, 'Clear', 2015102108, 16, 10000001),
(127, 'Not Clear', 2015102107, 14, 10000002),
(129, 'Clear', 2015102108, 14, 10000002),
(130, 'Not Clear', 2015102107, 15, 10000003),
(131, 'Clear', 2015102108, 15, 10000003),
(132, 'Clear', 2015102108, 17, 10000004),
(133, 'Not Clear', 2015102107, 17, 10000004);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`) VALUES
(1, 'BSN', 'Bachelor of Science in Nursing'),
(2, 'BSIT', 'Bachelor of Science in Information Technology'),
(3, 'BSC', 'Bachelor of Science in Criminology'),
(4, 'BSE', 'Bachelor of Science in Education'),
(5, 'BSA', 'Bachelor of Science in Accountancy');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` int(10) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  `dep_visibility` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `department_name`, `dep_visibility`) VALUES
(14, 'Library', 1),
(15, 'SPS/Guidance', 1),
(16, 'Program Chair Department', 1),
(17, 'Finance', 1),
(18, 'Internet Service', 1),
(19, 'Health Service', 1);

-- --------------------------------------------------------

--
-- Table structure for table `requester`
--

CREATE TABLE `requester` (
  `info_ID` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `student_lastname` varchar(50) NOT NULL,
  `student_firstname` varchar(50) NOT NULL,
  `student_middlename` varchar(50) NOT NULL,
  `birthday` varchar(50) NOT NULL,
  `contactNo` varchar(50) NOT NULL,
  `student_course` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `year_graduated_lastAttended` varchar(50) NOT NULL,
  `student_visibility` int(11) NOT NULL,
  `student_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `requester`
--

INSERT INTO `requester` (`info_ID`, `date`, `student_lastname`, `student_firstname`, `student_middlename`, `birthday`, `contactNo`, `student_course`, `status`, `year_graduated_lastAttended`, `student_visibility`, `student_ID`) VALUES
(1, '2025-10-16 15:59:19', 'DE GRACIA', 'JOSHUA', 'WENCESLAO', '1990-04-10', '09186484491', 'BSIT', 'Undergraduate', '2010', 1, 2015102107),
(2, '2025-10-16 16:13:08', 'DE GRACIA', 'JOSHUA', 'WENCESLAO', '1990-04-10', '09186484491', 'BSIT', 'Graduate', '2010', 1, 2015102108);

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `student_ID` int(10) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  `visibility` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`student_ID`, `lastname`, `firstname`, `middlename`, `course`, `visibility`) VALUES
(2015102101, 'GARDNER', 'RACHEL', '', 'BSN', 1),
(2015102102, 'FOSTER', 'ISAAC', 'WALA XANG APILYEDO', 'BSIT', 1),
(2015102103, 'MASON', 'EDWARD', '', 'BSA', 1),
(2015102104, 'DICKENS', 'DANIEL', '', 'BSN', 1),
(2015102105, 'WARD', 'CATHERINE', '', 'BSC', 1),
(2015102106, 'GRAY', 'ABRAHAM', '', 'BSE', 1),
(2015102107, 'DE GRACIA', 'JOSHUA', 'WENCESLAO', 'BSIT', 1),
(2015102108, 'DE GRACIA', 'JOSHUA', 'WENCESLAO', 'BSIT', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_No`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`blacklist_ID`);

--
-- Indexes for table `clearance`
--
ALTER TABLE `clearance`
  ADD PRIMARY KEY (`clearance_ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `requester`
--
ALTER TABLE `requester`
  ADD PRIMARY KEY (`info_ID`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`student_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_No` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `blacklist_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `clearance`
--
ALTER TABLE `clearance`
  MODIFY `clearance_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `requester`
--
ALTER TABLE `requester`
  MODIFY `info_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
