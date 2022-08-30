-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 08, 2021 at 11:24 AM
-- Server version: 5.7.24
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ifao_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `absences`
--

DROP TABLE IF EXISTS `absences`;
CREATE TABLE IF NOT EXISTS `absences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `leave_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `day` date DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `leave_id` (`leave_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absences`
--

INSERT INTO `absences` (`id`, `employee_id`, `leave_id`, `created_at`, `day`, `updated_at`) VALUES
(2, 1, NULL, '2021-11-07 00:00:00', '2021-11-07', '2021-11-07 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `day` date NOT NULL,
  `from` time NOT NULL,
  `to` time DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `overtime` int(11) DEFAULT NULL,
  `net` float DEFAULT NULL,
  `net_percentage` float DEFAULT NULL,
  `has_permission` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_scheduale_id` int(11) NOT NULL,
  `overtime_profile_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_scheduale_id` (`work_scheduale_id`),
  KEY `overtime_profile_id` (`overtime_profile_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `full_name_en`, `code`, `image`, `work_scheduale_id`, `overtime_profile_id`, `created_at`, `updated_at`) VALUES
(1, 'maryam', '12345', NULL, 1, 1, '2021-11-06 21:47:18', '2021-11-06 21:47:18'),
(2, 'employee_2', '12345678', NULL, 1, 1, '2021-11-06 22:09:31', '2021-11-06 22:09:31');

-- --------------------------------------------------------

--
-- Table structure for table `employee_input_fields`
--

DROP TABLE IF EXISTS `employee_input_fields`;
CREATE TABLE IF NOT EXISTS `employee_input_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `is_mandatory` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_leaves`
--

DROP TABLE IF EXISTS `employee_leaves`;
CREATE TABLE IF NOT EXISTS `employee_leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `approved_by` (`approved_by`),
  KEY `permission_id` (`leave_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_permissions`
--

DROP TABLE IF EXISTS `employee_permissions`;
CREATE TABLE IF NOT EXISTS `employee_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `day` date NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `approved_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `permission_id` (`permission_id`),
  KEY `approved_by` (`approved_by`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

DROP TABLE IF EXISTS `leaves`;
CREATE TABLE IF NOT EXISTS `leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_paid` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `over_time_profiles`
--

DROP TABLE IF EXISTS `over_time_profiles`;
CREATE TABLE IF NOT EXISTS `over_time_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_two_hours_ratio` float NOT NULL,
  `next_hours_ratio` float NOT NULL,
  `weekend_days_ratio` float NOT NULL,
  `holidays_ratio` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `over_time_profiles`
--

INSERT INTO `over_time_profiles` (`id`, `name`, `first_two_hours_ratio`, `next_hours_ratio`, `weekend_days_ratio`, `holidays_ratio`, `created_at`, `updated_at`) VALUES
(1, 'normal', 1.35, 1.7, 2, 3, '2021-11-06 21:50:43', '2021-11-06 21:50:43');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_paid` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_settings`
--

DROP TABLE IF EXISTS `report_settings`;
CREATE TABLE IF NOT EXISTS `report_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variables` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report_settings`
--

INSERT INTO `report_settings` (`id`, `variables`, `created_at`, `updated_at`) VALUES
(1, 'a:5:{i:0;s:10:\"attendance\";i:1;s:7:\"absence\";i:2;s:15:\"employee/leaves\";i:3;s:20:\"employee/permissions\";i:4;s:9:\"vacations\";}', '2021-11-04 10:56:09', '2021-11-04 11:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `authorities`, `created_at`, `updated_at`) VALUES
(13, 'admin', 'a:14:{i:0;s:8:\"presence\";i:1;s:9:\"employees\";i:2;s:9:\"work_days\";i:3;s:13:\"vacation_days\";i:4;s:16:\"permission_types\";i:5;s:19:\"permission_requests\";i:6;s:17:\"assign_Permission\";i:7;s:20:\"attendance_departure\";i:8;s:6:\"report\";i:9;s:6:\"backup\";i:10;s:8:\"settings\";i:11;s:5:\"users\";i:12;s:12:\"create_users\";i:13;s:18:\"Create_users_roles\";}', '2021-09-27 14:02:37', '2021-09-29 08:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 13, 'admin', 'admin@ifao.com', NULL, '$2y$10$cuJ8pTzkROiO50LqjdQnBet9yiKXuZ5N51eXd8SZd/jdyx9v062Xu', 13, '2021-06-06 23:13:05', '2021-09-27 14:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `vacations`
--

DROP TABLE IF EXISTS `vacations`;
CREATE TABLE IF NOT EXISTS `vacations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vacations`
--

INSERT INTO `vacations` (`id`, `name`, `from`, `to`, `created_at`, `updated_at`) VALUES
(1, 'holidays', '2021-11-08', '2021-11-10', '2021-11-06 20:25:56', '2021-11-06 20:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `work_schedule_profiles`
--

DROP TABLE IF EXISTS `work_schedule_profiles`;
CREATE TABLE IF NOT EXISTS `work_schedule_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `work_days` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_schedule_profiles`
--

INSERT INTO `work_schedule_profiles` (`id`, `name`, `work_days`, `start`, `end`, `created_at`, `updated_at`) VALUES
(1, '11-5', 'a:6:{i:0;s:8:\"Saturday\";i:1;s:6:\"Sunday\";i:2;s:6:\"Monday\";i:3;s:7:\"Tuesday\";i:4;s:9:\"Wednesday\";i:5;s:8:\"Thursday\";}', '00:00:00', '02:00:00', '2021-11-06 21:43:37', '2021-11-06 22:48:21');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
