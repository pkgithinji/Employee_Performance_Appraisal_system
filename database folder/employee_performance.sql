-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2024 at 03:58 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_performance`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `recommendation_engine`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `recommendation_engine` (`vscore` VARCHAR(50)) RETURNS VARCHAR(50) CHARSET latin1 NO SQL
begin
declare vrecommend varchar(50);


select description  into vrecommend from recommendations where vscore between min_score and max_score ;


return vrecommend;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `common_kpi`
--

DROP TABLE IF EXISTS `common_kpi`;
CREATE TABLE IF NOT EXISTS `common_kpi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `description` varchar(150) NOT NULL,
  `period` varchar(20) NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `common_kpi`
--

INSERT INTO `common_kpi` (`id`, `code`, `description`, `period`, `created_on`) VALUES
(1, 'Professional Development', 'Number of training sessions and courses completed', '2023/2024', '2024-06-16 12:39:03'),
(7, 'Innovativeness', 'Number of new Ideas by the employee', '2023/2024', '2024-06-16 13:09:50'),
(8, 'Time Management', 'Percentage of days employee is present and punctual to duties assigned.', '2023/2024', '2024-06-16 13:23:21');

-- --------------------------------------------------------

--
-- Table structure for table `corporate_objectives`
--

DROP TABLE IF EXISTS `corporate_objectives`;
CREATE TABLE IF NOT EXISTS `corporate_objectives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `description` varchar(150) NOT NULL,
  `period` varchar(20) NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `corporate_objectives`
--

INSERT INTO `corporate_objectives` (`id`, `code`, `description`, `period`, `created_on`) VALUES
(1, 'Increase customer base by 20%', 'Increase customer base by 20%', '2023/2024', '2024-07-14 09:38:20'),
(2, 'Increase revenue by 15%', 'Increase revenue by 15%', '2023/2024', '2024-07-14 09:41:05'),
(5, 'Reduce ICT Operational Expenses by 30%', 'Reduce ICT Operational Expenses by 30%', '2023/2024', '2024-07-14 13:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DepartmentName` varchar(150) DEFAULT NULL,
  `DepartmentShortName` varchar(100) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `DepartmentName`, `DepartmentShortName`, `CreationDate`) VALUES
(4, 'IT', 'IT', '2024-06-11 02:54:45'),
(5, 'HR', 'HR', '2024-07-03 11:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

DROP TABLE IF EXISTS `designation`;
CREATE TABLE IF NOT EXISTS `designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `description` varchar(150) NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `code`, `description`, `created_on`) VALUES
(2, 'Data Clerks', 'Data Clerks', '2024-06-12 17:25:11'),
(3, 'Cleaner', 'Cleaner', '2024-06-12 17:52:16'),
(4, 'Electrician', 'Electrician', '2024-07-03 09:18:30'),
(5, 'IT Officer', 'IT Officer', '2024-07-10 20:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `EmailId` varchar(200) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phonenumber` char(11) NOT NULL,
  `Status` int(1) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `location` varchar(200) NOT NULL,
  `is_supervisor` tinyint(1) DEFAULT '0',
  `supervisor_id` int(11) DEFAULT '0',
  `designation` int(11) DEFAULT '0',
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `FirstName`, `LastName`, `EmailId`, `Gender`, `Dob`, `Department`, `Address`, `Phonenumber`, `Status`, `RegDate`, `location`, `is_supervisor`, `supervisor_id`, `designation`) VALUES
(1, 'Mercy', 'Mukiri', 'mukirimercy3@gmail.com', 'Female', '14 December, 1999', 'IT', 'Meru', '0248865955', 1, '2024-01-10 09:06:59', 'NO-IMAGE-AVAILABLE.jpg', 0, 5, 0),
(2, 'Catherine', 'Kaimenyi', 'ckaimenyi@gmail.com', 'Female', '15 June, 1996', 'ICT', 'Nyandarua', '8587944255', 1, '2022-04-10 05:40:02', 'photo2.jpg', 0, 5, 0),
(4, 'Boniface', 'Mwiti', 'mwiti.boniface@gmail.com', 'Male', '11 January, 2002', 'IT', 'Nakuru', '587944255', 1, '2020-08-04 07:00:02', 'NO-IMAGE-AVAILABLE.jpg', 1, 5, 0),
(5, 'Steven', 'Sang', 'stevesang@gmail.com', 'Male', '17 May, 1993', 'IT', 'Kericho', '587944255', 1, '2018-07-04 05:36:22', 'photo5.jpg', 0, 5, 0),
(6, 'John', 'Kamau', 'testadmin@gmail.com', 'Female', '13 July, 2000', 'IT', 'Kinangop', '587944255', 1, '2001-11-10 13:40:02', 'NO-IMAGE-AVAILABLE.jpg', 0, 5, 0),
(7, 'Johnstone', 'Oduor', 'joduor56@gmail.com', 'Male', '6 August, 1983', 'IT', 'Kakamega', '0596667981', 1, '2018-08-16 13:40:02', '', 1, 5, 0),
(8, 'Patrick', 'Munuhe', 'pmunuhe@gmail.com', 'female', '1 March, 1986', 'IT', 'Kongowea', '587944258', 1, '2017-11-10 13:40:02', 'NO-IMAGE-AVAILABLE.jpg', 0, 9, 0),
(9, 'Pascalina', 'Wangui', 'pwangi@gmail.com', 'female', '01 July 2024', 'IT', '23', '072430000', 1, '2024-07-10 20:05:59', 'NO-IMAGE-AVAILABLE.jpg', 1, 5, 0),
(10, 'James', 'Njoroge', 'jnjoro@gmail.com', 'male', '09 July 2080', 'HR', '23', '072430000', 1, '2024-07-11 05:13:47', 'NO-IMAGE-AVAILABLE.jpg', 1, 9, 0),
(11, 'Mary', 'Chepkoech', 'mchepkoech@gmail.com', 'female', '09 July 2080', 'IT', '23', '072430001', 1, '2024-07-11 05:15:10', 'NO-IMAGE-AVAILABLE.jpg', 1, 9, 0),
(12, 'Peter', 'kamau', 'pkamash@gmail.com', 'male', '01 February 2000', 'IT', '23', '72430007', 1, '2024-07-11 09:51:05', 'NO-IMAGE-AVAILABLE.jpg', 0, 9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `employee_objectives`
--

DROP TABLE IF EXISTS `employee_objectives`;
CREATE TABLE IF NOT EXISTS `employee_objectives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `objective_code` varchar(200) DEFAULT NULL,
  `details` text,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `period` varchar(50) DEFAULT NULL,
  `kpi_indicator` text NOT NULL,
  `unit_of_measure` varchar(50) NOT NULL,
  `target` text NOT NULL,
  `user_id` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_objectives`
--

INSERT INTO `employee_objectives` (`id`, `objective_code`, `details`, `CreationDate`, `period`, `kpi_indicator`, `unit_of_measure`, `target`, `user_id`) VALUES
(14, 'Create a post graduate tracking tool', 'Create a post graduate tracking tool to track progress of postgraduate projects and thesis', '2024-07-04 06:33:02', '2023/2024', 'Prototypes', 'Pieces', 'Beta Version by 30 June  2024', '1'),
(15, 'Upgrade Koha to v18.0', 'Upgrade Koha to v18.0', '2024-07-04 21:30:31', '2023/2024', 'upgraded version', 'Pieces', 'v18.0 installed', '1'),
(17, 'Create a new AD', 'Create a new AD', '2024-07-09 05:06:33', '2023/2024', 'New AD', 'Pieces', 'by 30th June 2024', '1'),
(18, 'Create asset register', 'create asset register', '2024-07-13 23:03:30', '2023/2024', 'Asset register', 'pieces', '100% recorded assets', '3'),
(19, 'Repair broken down computers in computer lab', 'Repair broken down computers in computer lab', '2024-07-13 23:05:06', '2023/2024', 'Working pcs', 'pieces', '99% working pcs', '3'),
(20, 'Test', 'Test', '2024-07-15 08:29:55', '2023/2024', 'Test report', 'pieces', 'test target', '1');

-- --------------------------------------------------------

--
-- Table structure for table `employee_rating`
--

DROP TABLE IF EXISTS `employee_rating`;
CREATE TABLE IF NOT EXISTS `employee_rating` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `evaluation_period` varchar(50) NOT NULL,
  `evaluatee_id` int(30) NOT NULL,
  `evaluation_item_code` varchar(30) NOT NULL,
  `evaluation_item_category` varchar(20) DEFAULT NULL,
  `evaluator_id` int(30) DEFAULT NULL,
  `self_score` int(11) NOT NULL DEFAULT '0',
  `self_evaluation_date` date DEFAULT NULL,
  `evaluator_evaluation_date` date DEFAULT NULL,
  `evaluator_score` int(11) DEFAULT '0',
  `agreedscore_submitted_on` date DEFAULT NULL,
  `agreedscore_submittedby` int(30) DEFAULT NULL,
  `self_evaluation_remarks` text,
  `evaluator_remarks` text,
  `hr_remarks` text,
  `agreed_score` int(11) DEFAULT '0',
  `has_conflict` int(11) DEFAULT '0',
  `hrpersonnel_id` int(30) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_rating`
--

INSERT INTO `employee_rating` (`id`, `evaluation_period`, `evaluatee_id`, `evaluation_item_code`, `evaluation_item_category`, `evaluator_id`, `self_score`, `self_evaluation_date`, `evaluator_evaluation_date`, `evaluator_score`, `agreedscore_submitted_on`, `agreedscore_submittedby`, `self_evaluation_remarks`, `evaluator_remarks`, `hr_remarks`, `agreed_score`, `has_conflict`, `hrpersonnel_id`, `date_created`) VALUES
(26, '2023/2024', 3, 'C8', 'CommonMetric', 4, 1, '2024-07-13', '2024-07-14', 2, '2024-07-14', 4, NULL, '', NULL, 4, 0, NULL, '2024-07-14 02:05:41'),
(25, '2023/2024', 3, 'C7', 'CommonMetric', 4, 5, '2024-07-13', '2024-07-14', 1, '2024-07-14', 4, NULL, '', NULL, 3, 0, NULL, '2024-07-14 02:05:41'),
(24, '2023/2024', 3, 'C1', 'CommonMetric', 4, 3, '2024-07-13', '2024-07-14', 4, '2024-07-14', 4, NULL, '', NULL, 2, 0, NULL, '2024-07-14 02:05:41'),
(23, '2023/2024', 3, '19', 'TargetMetric', 4, 4, '2024-07-13', '2024-07-14', 3, '2024-07-14', 4, NULL, '', NULL, 4, 0, NULL, '2024-07-14 02:05:41'),
(22, '2023/2024', 3, '18', 'TargetMetric', 4, 4, '2024-07-13', '2024-07-14', 5, '2024-07-14', 4, NULL, '', NULL, 5, 0, NULL, '2024-07-14 02:05:41'),
(18, '2023/2024', 1, '17', 'TargetMetric', 3, 4, '2024-07-10', '2024-07-11', 4, '2024-07-11', 3, NULL, '', NULL, 4, 0, NULL, '2024-07-10 06:24:57'),
(19, '2023/2024', 1, 'C1', 'CommonMetric', 3, 3, '2024-07-10', '2024-07-11', 3, '2024-07-11', 3, NULL, '', NULL, 3, 0, NULL, '2024-07-10 06:24:57'),
(20, '2023/2024', 1, 'C7', 'CommonMetric', 3, 1, '2024-07-10', '2024-07-11', 2, '2024-07-11', 3, NULL, '', NULL, 2, 0, NULL, '2024-07-10 06:24:57'),
(21, '2023/2024', 1, 'C8', 'CommonMetric', 3, 3, '2024-07-10', '2024-07-11', 1, '2024-07-11', 3, NULL, '', NULL, 2, 0, NULL, '2024-07-10 06:24:57');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_periods`
--

DROP TABLE IF EXISTS `evaluation_periods`;
CREATE TABLE IF NOT EXISTS `evaluation_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text,
  `description` mediumtext,
  `date_from` varchar(200) NOT NULL,
  `date_to` varchar(200) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0',
  `objectives_submission_startdate` date DEFAULT NULL,
  `objectives_submission_enddate` date DEFAULT NULL,
  `self_evaluation_startdate` date DEFAULT NULL,
  `self_evaluation_enddate` date DEFAULT NULL,
  `supervisor_evaluation_startdate` date DEFAULT NULL,
  `supervisor_evaluation_enddate` date DEFAULT NULL,
  `agreedscore_submission_startdate` date DEFAULT NULL,
  `agreedscore_submission_enddate` date DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `last_modification_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_periods`
--

INSERT INTO `evaluation_periods` (`id`, `code`, `description`, `date_from`, `date_to`, `CreationDate`, `status`, `objectives_submission_startdate`, `objectives_submission_enddate`, `self_evaluation_startdate`, `self_evaluation_enddate`, `supervisor_evaluation_startdate`, `supervisor_evaluation_enddate`, `agreedscore_submission_startdate`, `agreedscore_submission_enddate`, `created_by`, `last_modified_by`, `last_modification_date`) VALUES
(3, '2023/2024', '2023/2024 FY', '2023-07-01', '2024-06-30', '2024-06-16 14:48:48', 1, '2023-07-01', '2023-07-30', '2024-06-01', '2024-06-10', '2024-06-11', '2024-06-20', '2024-06-21', '2024-06-28', NULL, '1', '2024-07-14'),
(4, '2022/2023', '2022/2023 FY', '2022-07-01', '2023-06-30', '2024-06-23 17:44:57', 0, '2022-07-01', '2022-08-01', '2023-06-01', '2023-06-10', '2023-06-11', '2023-06-20', '2023-06-21', '2023-06-28', NULL, '1', '2024-07-13'),
(5, '2020/2021', '2020/2021 FY', '2020-07-01', '2021-06-30', '2024-07-13 19:07:02', 0, '2020-07-01', '2020-08-01', '2021-06-01', '2021-06-10', '2021-06-11', '2021-06-20', '2021-06-21', '2021-06-28', '', '1', '2024-07-13');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `page_name` varchar(50) DEFAULT NULL,
  `can_create` tinyint(1) DEFAULT '0',
  `can_view` tinyint(1) DEFAULT '0',
  `can_update` tinyint(1) DEFAULT '0',
  `can_delete` tinyint(1) DEFAULT '0',
  `last_modified_by` int(11) DEFAULT NULL,
  `last_modified_on` datetime DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `role_id`, `page_name`, `can_create`, `can_view`, `can_update`, `can_delete`, `last_modified_by`, `last_modified_on`, `created_on`, `created_by`) VALUES
(6, 4, 'roles', 0, 0, 0, 0, 2, '2024-07-02 23:23:03', '2024-07-02 23:23:03', 2),
(5, 4, 'departments', 0, 0, 0, 0, 2, '2024-07-02 23:23:03', '2024-07-02 23:23:03', 2),
(7, 4, 'evaluation_periods', 0, 0, 0, 0, 2, '2024-07-02 23:23:03', '2024-07-02 23:23:03', 2),
(8, 4, 'designations', 0, 0, 0, 0, 2, '2024-07-02 23:23:03', '2024-07-02 23:23:03', 2),
(15, 2, 'evaluation_periods', 0, 0, 0, 0, 2, '2024-07-03 08:08:13', '2024-07-03 08:08:13', 2),
(14, 2, 'roles', 0, 0, 0, 0, 2, '2024-07-03 08:08:13', '2024-07-03 08:08:13', 2),
(13, 2, 'departments', 1, 1, 1, 1, 2, '2024-07-03 08:08:13', '2024-07-03 08:08:13', 2),
(16, 2, 'designations', 0, 0, 0, 0, 2, '2024-07-03 08:08:13', '2024-07-03 08:08:13', 2);

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

DROP TABLE IF EXISTS `recommendations`;
CREATE TABLE IF NOT EXISTS `recommendations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `min_score` decimal(10,2) DEFAULT '0.00',
  `max_score` decimal(10,2) DEFAULT '0.00',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`id`, `min_score`, `max_score`, `description`) VALUES
(1, '1.00', '1.99', 'Start Performance Improvement Programme'),
(2, '2.00', '2.99', 'Start Performance Improvement Programme'),
(3, '3.00', '3.99', 'Do certifications, more training'),
(4, '4.00', '4.99', 'Promote');

-- --------------------------------------------------------

--
-- Table structure for table `scores_setup`
--

DROP TABLE IF EXISTS `scores_setup`;
CREATE TABLE IF NOT EXISTS `scores_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `description` varchar(150) NOT NULL,
  `points` int(11) NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scores_setup`
--

INSERT INTO `scores_setup` (`id`, `code`, `description`, `points`, `created_on`) VALUES
(1, 'Outstanding', 'Work performance is consistently of exceptional quality', 5, '2024-06-15 04:43:47'),
(2, 'Exceeds Expectations ', 'Work performance exceeds what is normally expected for the position. ', 4, '2024-06-15 04:44:43'),
(3, 'Meets Expectations ', 'Work performance meets the job requirements and expectations. ', 3, '2024-06-15 04:45:05'),
(4, 'Below Expectations', 'Work performance falls short of the job requirements and rarely meets expectations but is willing to overcome deficiencies', 2, '2024-06-15 04:45:51'),
(5, 'Far Below Expectations ', 'Work performance is inadequate and consistently falls below the standards of performance', 1, '2024-06-15 04:46:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `last_modified_by` varchar(20) NOT NULL,
  `last_modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emp_id` int(11) NOT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `created_by` (`created_by`),
  KEY `role_id` (`role_id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `first_name`, `last_name`, `status`, `created_at`, `created_by`, `role_id`, `last_modified_by`, `last_modified_on`, `emp_id`, `reset_token`) VALUES
(1, 'testadmin@gmail.com', '60fe6016a1d05f2b609632aff6945654', 'John', 'Kamau', 1, '2024-07-02 07:34:32', 2, 1, '1', '2024-07-16 06:19:23', 6, '02d8a7ade0a87fdbf2e55606c67e2c8a9d095cef1646b6e48fa4dd575e68d35aea955285a0dac44d5885d7a224d3f0138d6f'),
(2, 'mwiti.boniface@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Boniface', 'Mwiti', 1, '2024-07-10 06:02:59', 1, 2, '1', '2024-07-14 10:46:39', 4, NULL),
(3, 'pmunuhe@gmail.com', '0aa2e902cc1c132638edfff9c91a1049', 'Patrick', 'Munuhe', 1, '2024-07-11 12:20:32', 1, 3, '1', '2024-07-16 06:17:35', 8, NULL),
(4, 'pwangi@gmail.com', 'bb9befdb6fa62cbd3db3b4f7db257c29', 'Pascalina', 'Wangui', 1, '2024-07-13 07:04:09', 1, 2, '1', '2024-07-16 06:21:23', 9, NULL),
(5, 'jnjoro@gmail.com', 'ae306ab08addd97185f7a1bebe3b3a00', 'James', 'Njoroge', 1, '2024-07-15 11:36:58', 1, 4, '1', '2024-07-16 06:16:04', 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role_name`, `status`) VALUES
(1, 'Administrator', 1),
(2, 'Supervisor', 1),
(3, 'Evaluatee', 1),
(4, 'HR', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
