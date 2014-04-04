-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 31, 2013 at 12:20 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `geomatics`
--
CREATE DATABASE `geomatics` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `geomatics`;

-- --------------------------------------------------------

--
-- Table structure for table `ip_info`
--

CREATE TABLE IF NOT EXISTS `ip_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(20) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ip_info`
--

INSERT INTO `ip_info` (`id`, `ip_address`, `description`) VALUES
(1, '127.0.0.1', 'work'),
(2, '136.159.122.225', 'main office'),
(3, '70.75.188.183', 'my home access');

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE IF NOT EXISTS `student_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `study_type` enum('Full-time','Part-time') DEFAULT NULL,
  `supervisor_id` varchar(50) NOT NULL,
  `cosupervisor_id` varchar(50) NOT NULL,
  `degree_type` enum('MEng (Course-based)','MEng (Thesis-based)','MSc','PhD') NOT NULL,
  `status_in_canada` enum('Visa','PR','Canadian') NOT NULL,
  `start_date` date NOT NULL,
  `research_stream` enum('Earth Observation','Positioning, Navigation and Wireless Location','Digital Imaging','GIS and Land Tenure') NOT NULL,
  `appointment_of_supervisory_committee` enum('Yes','No') NOT NULL,
  `sin_expiry` date DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `office_location` varchar(50) DEFAULT NULL,
  `office_tel` varchar(50) DEFAULT NULL,
  `fee_differential_return` enum('Yes','No') NOT NULL,
  `msc_to_phd` enum('Yes','No') NOT NULL,
  `entrance_gpa` varchar(10) DEFAULT NULL,
  `final_gpa` varchar(10) DEFAULT NULL,
  `course_requirements` enum('MEng 10 half-courses (at least 6 are graduate courses)','MSc 5 half-courses (at least 4 are graduate courses)','PhD 3 graduate half-courses','PhD 2 graduate half-courses after transfer from MSc program (7 courses in total)') NOT NULL,
  `course_requirement_completed` varchar(50) DEFAULT NULL,
  `engo605_presentation_complete` varchar(50) DEFAULT NULL,
  `engo607_presentation_complete` varchar(50) DEFAULT NULL,
  `engo609_presentation_complete` varchar(50) DEFAULT NULL,
  `major_awards` varchar(2000) DEFAULT NULL,
  `fgs_award_date` varchar(2000) DEFAULT NULL,
  `fgs_award_amount` varchar(2000) DEFAULT NULL,
  `travel_award_date` varchar(2000) DEFAULT NULL,
  `travel_award_amount` varchar(2000) DEFAULT NULL,
  `travel_award_claim` varchar(2000) DEFAULT NULL,
  `technical_writing_complete` varchar(100) DEFAULT NULL,
  `engo_605_seminar_report_name` varchar(2000) DEFAULT NULL,
  `engo_605_seminar_report_date` varchar(2000) DEFAULT NULL,
  `engo_605_seminar_report_completed` enum('Yes','No') DEFAULT NULL,
  `engo_607_seminar_report_name` varchar(2000) DEFAULT NULL,
  `engo_607_seminar_report_date` varchar(2000) DEFAULT NULL,
  `engo_607_seminar_report_completed` enum('Yes','No') DEFAULT NULL,
  `engo_609_seminar_report_name` varchar(50) DEFAULT NULL,
  `engo_609_seminar_report_date` varchar(2000) DEFAULT NULL,
  `engo_609_seminar_report_completed` enum('Yes','No') DEFAULT NULL,
  `thesis_proposal_approve` varchar(100) DEFAULT NULL,
  `candidacy_date` date DEFAULT NULL,
  `defense_date` date DEFAULT NULL,
  `expected_convocation` date DEFAULT NULL,
  `province_country` varchar(50) DEFAULT NULL,
  `last_degree` varchar(50) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`student_id`),
  KEY `supervisor_id` (`supervisor_id`),
  KEY `cosupervisor_id` (`cosupervisor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id`, `student_id`, `first_name`, `last_name`, `gender`, `study_type`, `supervisor_id`, `cosupervisor_id`, `degree_type`, `status_in_canada`, `start_date`, `research_stream`, `appointment_of_supervisory_committee`, `sin_expiry`, `email`, `office_location`, `office_tel`, `fee_differential_return`, `msc_to_phd`, `entrance_gpa`, `final_gpa`, `course_requirements`, `course_requirement_completed`, `engo605_presentation_complete`, `engo607_presentation_complete`, `engo609_presentation_complete`, `major_awards`, `fgs_award_date`, `fgs_award_amount`, `travel_award_date`, `travel_award_amount`, `travel_award_claim`, `technical_writing_complete`, `engo_605_seminar_report_name`, `engo_605_seminar_report_date`, `engo_605_seminar_report_completed`, `engo_607_seminar_report_name`, `engo_607_seminar_report_date`, `engo_607_seminar_report_completed`, `engo_609_seminar_report_name`, `engo_609_seminar_report_date`, `engo_609_seminar_report_completed`, `thesis_proposal_approve`, `candidacy_date`, `defense_date`, `expected_convocation`, `province_country`, `last_degree`, `end_date`, `phone`) VALUES
(11, '3333', 'Juliana', 'Portman', 'Male', 'Full-time', 'Andrew Hunter', 'Ayman Habib', 'MSc', 'Visa', '2010-09-06', 'Earth Observation', 'No', '2012-09-28', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '2012-09-04', NULL),
(12, '5555555', 'Rio', 'Ferdinand', 'Female', 'Part-time', 'Andrew Hunter', '', 'PhD', 'Visa', '2010-09-01', 'GIS and Land Tenure', 'No', '2015-09-14', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', '2', 'PhD 3 graduate half-courses', '2012-09-03', 'No', '2012-09-23', '2012-09-30', '', '', '', '2013-02-01;2013-03-01;2013-10-15', '800;500;200', 'Yes;No;No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, '2012-09-27', '2012-10-17', '2012-11-27', '0000-00-00', 'NULL', 'NULL', '0000-00-00', '403-220-1552'),
(14, '33333', 'Peter', 'McDonald', 'Male', 'Full-time', 'Ayman Habib', '', 'PhD', 'Visa', '2012-10-01', 'Earth Observation', 'No', '2012-10-27', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '2012-10-08', NULL),
(15, '10159935', 'Olivia', 'Prez', 'Female', 'Part-time', 'Andrew Hunter', '', 'MSc', 'Canadian', '2012-10-01', 'Positioning, Navigation and Wireless Location', 'No', '2012-10-31', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', NULL),
(16, '10255569', 'Jason', 'Paul', 'Male', 'Full-time', 'Andrew Hunter', '', 'PhD', 'PR', '2012-10-02', 'Digital Imaging', 'No', '2012-10-31', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', '3.54', 'MEng 10 half-courses (at least 6 are graduate courses)', '', '', '', 'No', '', '', '', '', '', 'No', 'Waived', 'Sina T.', '2012-10-09', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', '403'),
(18, '232323', 'Natasha', 'Holmes', 'Female', 'Part-time', 'Andrew Hunter', '', 'MSc', 'Visa', '2012-09-30', 'Earth Observation', 'No', '2012-10-27', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', 'AITF;MLS', '2012-10-02;2012-10-14', '500;850', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '2012-12-04', NULL),
(19, '10001000', 'Janet', 'Smith', 'Female', 'Full-time', 'Andrew Hunter', '', 'PhD', 'Visa', '2010-01-01', 'Earth Observation', 'Yes', '2013-01-01', 'NULL', 'NULL', 'NULL', 'Yes', 'No', '3.50', '3.77', 'PhD 3 graduate half-courses', '2011/04/30', '2011/06/30', '2012/09/25', 'No', '', '', '', '', '', 'Yes', '2010/11/30', 'Lari;Sheta;Knoechel', '2012-12-02', NULL, 'Mosstijiri', '2012-11-05', NULL, '', '', NULL, '2012-10-07', '2011-08-01', '2011-12-23', '0000-00-00', 'Iran', 'Iran', '0000-00-00', NULL),
(21, '10001001', 'Philip', 'Long', 'Male', 'Full-time', 'Andrew Hunter', '', 'MSc', 'Canadian', '2009-01-01', 'Earth Observation', 'No', '2009-01-01', 'NULL', 'NULL', 'NULL', 'No', 'No', '3.2', '3.3', 'MSc 5 half-courses (at least 4 are graduate courses)', '2009-12-31', '2009-12-31', 'No', 'No', '', '', '', '', '', 'No', 'Waived', 'Janet Smith;Philip Yang', '2010/01/01;2011/02/28', NULL, '', '', NULL, '', '', NULL, '', '0000-00-00', '2011-01-11', '0000-00-00', 'Canada', 'Canada', '2011-01-31', NULL),
(22, '20001000', 'Billy', 'Butler', 'Male', 'Full-time', 'Andrew Hunter', '', 'MSc', 'Visa', '2009-04-01', 'GIS and Land Tenure', 'No', '2013-04-15', 'bbutler@ucalgary.ca', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '2012-10-09;2013-02-05', '500;900', 'Yes;Yes', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', NULL),
(23, '20002001', 'Catherine', 'Campbell', 'Female', 'Full-time', 'Andrew Hunter', '', 'PhD', 'Canadian', '2007-05-01', 'Earth Observation', 'No', '0000-00-00', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', NULL),
(24, '20002003', 'Daryl', 'Dawson', 'Male', 'Full-time', 'Andrew Hunter', '', 'PhD', 'Canadian', '2012-07-01', 'GIS and Land Tenure', 'No', '2001-01-01', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', '2013-03-04', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', NULL),
(25, '20002004', 'Eleanor', 'Elliott', 'Female', 'Part-time', 'Andrew Hunter', '', 'PhD', 'Canadian', '2012-09-01', 'GIS and Land Tenure', 'No', '2001-01-01', 'minch@ucalgary.ca', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', NULL),
(26, '20002005', 'Francis', 'Fox', 'Male', 'Full-time', 'Xin Wang', '', 'PhD', 'PR', '2013-01-01', 'GIS and Land Tenure', 'No', '2001-01-01', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', NULL),
(27, '1245789', 'Antonio', 'Pinto', 'Male', 'Full-time', 'Andrew Hunter', '', 'MSc', 'PR', '2013-05-01', 'GIS and Land Tenure', 'No', '0000-00-00', 'apinto@ucalgary.ca', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', NULL),
(28, '548975451', 'Lia', 'Hou', 'Male', 'Full-time', 'Andrew Hunter', '', 'MSc', 'Visa', '2013-04-01', 'Earth Observation', 'No', '0000-00-00', 'NULL', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', NULL),
(29, '128923455', 'Billy', 'Eliot', 'Male', 'Full-time', 'Andrew Hunter', '', 'PhD', 'Canadian', '2013-05-01', 'Earth Observation', 'No', '0000-00-00', 'beliot@ucalgary.ca', 'NULL', 'NULL', 'No', 'No', 'NULL', 'NULL', 'MEng 10 half-courses (at least 6 are graduate courses)', 'No', 'No', 'No', 'No', '', '', '', '', '', 'No', 'Waived', '', '', NULL, '', '', NULL, '', '', NULL, 'N/A', '0000-00-00', '0000-00-00', '0000-00-00', 'NULL', 'NULL', '0000-00-00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_info`
--

CREATE TABLE IF NOT EXISTS `supervisor_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `supervisor_info`
--

INSERT INTO `supervisor_info` (`id`, `first_name`, `last_name`) VALUES
(1, 'Andrew', 'Hunter'),
(2, 'Steve', 'Liang'),
(3, 'Ayman', 'Habib'),
(4, 'Mike', 'Barry'),
(5, 'Xin', 'Wang'),
(12, 'Danielle', 'Marceau'),
(13, 'Quazi', 'Hassan');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `signup_date` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `access_level` enum('Admin','Editor','Viewer') NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `id` (`user_id`,`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `last_name`, `email`, `signup_date`, `last_login`, `username`, `password`, `access_level`) VALUES
(1, 'Marcia', 'Rempel', 'marcia.rempel@ucalgary.ca', '2012-10-29 00:00:00', '0000-00-00 00:00:00', 'admin', '202cb962ac59075b964b07152d234b70', 'Admin'),
(2, 'Viewer', 'User', 'viewer@user.com', '2012-11-09 14:00:27', NULL, 'viewer', '202cb962ac59075b964b07152d234b70', 'Viewer'),
(3, 'Editor', 'User', 'editor@user.com', '2012-11-09 14:00:48', NULL, 'editor', '202cb962ac59075b964b07152d234b70', 'Editor');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
