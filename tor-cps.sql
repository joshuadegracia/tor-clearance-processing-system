-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2018 at 05:45 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvgfc_db`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(23, 'user', '81dc9bdb52d04dc20036dbd8313ed055', 0, 2015102102);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_ID`, `admin_lastname`, `admin_firstname`, `admin_middlename`, `admin_department`, `admin_role`) VALUES
(10000001, 'Sensei', 'Koro', '', 'Program Chair Department', 'Property Custodian'),
(10000002, 'Izumi', 'Sagiri', '', 'Library', 'Librarian'),
(10000003, 'Ryuzaki', 'Lawliet', '', 'SPS/Guidance', 'Guidance Councilor'),
(10000004, 'Yagami', 'Light', '', 'Finance', 'Finance Officer'),
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blacklist`
--

INSERT INTO `blacklist` (`blacklist_ID`, `remark`, `student_ID`, `departmentID`, `admin_ID`) VALUES
(76, '2 Chairs', 2015102102, 16, 10000001),
(79, 'bad moral', 2015102102, 15, 10000003);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(115, 'Clear', 2015102102, 17, 10000004);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` int(10) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  `dep_visibility` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `department_name`, `dep_visibility`) VALUES
(14, 'Library', 1),
(15, 'SPS/Guidance', 1),
(16, 'Program Chair Department', 1),
(17, 'Finance', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requester`
--

INSERT INTO `requester` (`info_ID`, `date`, `student_lastname`, `student_firstname`, `student_middlename`, `birthday`, `contactNo`, `student_course`, `status`, `year_graduated_lastAttended`, `student_visibility`, `student_ID`) VALUES
(104, '2018-12-01 22:39:49', 'GARDNER', 'RACHEL', '', '1996-06-27', '09973578333', 'BSN', 'Graduate', '2016', 1, 2015102101),
(105, '2018-12-01 22:42:47', 'GARDNER', 'RACHEL', '', '1996-06-27', '09973578333', 'BSN', 'Graduate', '2016', 1, 2015102101),
(106, '2018-12-01 22:42:47', 'GARDNER', 'RACHEL', '', '1996-06-27', '09973578333', 'BSN', 'Graduate', '2016', 1, 2015102101),
(107, '2018-12-01 22:42:53', 'GARDNER', 'RACHEL', '', '1996-06-27', '09973578333', 'BSN', 'Graduate', '2016', 1, 2015102101),
(108, '2018-12-01 23:35:01', 'FOSTER', 'ISAAC', '', '1994-04-17', '09973578330', 'BSC', 'Graduate', '2016', 1, 2015102102);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`student_ID`, `lastname`, `firstname`, `middlename`, `course`, `visibility`) VALUES
(2015102101, 'GARDNER', 'RACHEL', '', 'BSN', 1),
(2015102102, 'FOSTER', 'ISAAC', '', 'BSIT', 1),
(2015102103, 'MASON', 'EDWARD', '', 'BSA', 1),
(2015102104, 'DICKENS', 'DANIEL', '', 'BSN', 1),
(2015102105, 'WARD', 'CATHERINE', '', 'BSC', 1),
(2015102106, 'GRAY', 'ABRAHAM', '', 'BSE', 1);

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
  MODIFY `account_No` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `blacklist_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `clearance`
--
ALTER TABLE `clearance`
  MODIFY `clearance_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `requester`
--
ALTER TABLE `requester`
  MODIFY `info_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
