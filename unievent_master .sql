-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 29, 2024 at 08:33 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `driver_management`
--
CREATE DATABASE IF NOT EXISTS `driver_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `driver_management`;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `license_number` varchar(200) NOT NULL,
  `contact_info` varchar(200) NOT NULL,
  `accident` int NOT NULL,
  `found_guilty` int NOT NULL,
  `suspension_start` date NOT NULL,
  `suspension_end` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `license_number` (`license_number`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `license_number`, `contact_info`, `accident`, `found_guilty`, `suspension_start`, `suspension_end`) VALUES
(1, 'wiskes', 'munya1234', '0886939996 from nanana village', 0, 0, '2024-10-24', '2024-11-23'),
(2, 'peter munyapa', '123456mn', '0886939996 from nanana village', 0, 0, '2024-10-24', '2024-11-23'),
(3, 'christopher munyapa', 'chr123', 'manana vg p.o box 39', 0, 0, '2024-10-24', '2024-11-23'),
(4, 'frank', '348mk', 'manana vg p.o box 39', 0, 0, '0000-00-00', '0000-00-00'),
(5, 'mose', '199', 'maakskowq', 0, 0, '2024-10-25', '2024-11-24'),
(6, 'kite', 'skddi8', 'iuwieuie384', 1, 1, '0000-00-00', '0000-00-00'),
(7, 'kennedy', '2www', 'asj;oajd', 1, 1, '2024-10-25', '2024-11-24'),
(8, 'symon', '00089', 'nsjsdshjah', 0, 0, '0000-00-00', '0000-00-00'),
(9, 'inno', 'owow7', 'manana vg p.o box 39', 1, 1, '2024-10-25', '2024-11-24'),
(10, 'lena', '34oook', 'howsa', 1, 1, '2024-10-25', '2024-11-24'),
(11, 'james', 'james245', 'maakskowq', 1, 0, '0000-00-00', '0000-00-00'),
(12, 'Alisa Conrad', '865', 'Laudantium dolores ', 1, 0, '0000-00-00', '0000-00-00'),
(13, 'Laurel Navarro', '318', 'Adipisicing asperior', 1, 1, '2024-10-25', '2024-11-24');
--
-- Database: `event_management`
--
CREATE DATABASE IF NOT EXISTS `event_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `event_management`;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `organizer_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `organizer_id` (`organizer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `organizer_id`) VALUES
(1, 'Football', 1);

-- --------------------------------------------------------

--
-- Table structure for table `organizers`
--

DROP TABLE IF EXISTS `organizers`;
CREATE TABLE IF NOT EXISTS `organizers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `organizers`
--

INSERT INTO `organizers` (`id`, `name`) VALUES
(1, 'vamp');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
CREATE TABLE IF NOT EXISTS `registrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `user_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `event_id`, `user_name`) VALUES
(1, 1, 'Benja');
--
-- Database: `file`
--
CREATE DATABASE IF NOT EXISTS `file` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `file`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Benjamin Mwambakulu', 'bit-023-22@must.ac.mw', '$2y$10$yIf6ZRMAo8qJlryNTqwoveUlk25njaBJTum/FS8cNj8BTnTI4MXSy', '2024-10-28 06:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `approved_events`
--

DROP TABLE IF EXISTS `approved_events`;
CREATE TABLE IF NOT EXISTS `approved_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `price_category` enum('Free','Custom') NOT NULL,
  `event_price` decimal(10,2) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `event_poster` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `approved_events`
--

INSERT INTO `approved_events` (`id`, `event_name`, `event_date`, `event_venue`, `event_description`, `price_category`, `event_price`, `start_time`, `end_time`, `event_poster`, `created_at`) VALUES
(2, 'Lani Garner', '2024-10-28', 'Culpa sit sit conse', 'Ipsum sequi sint err', 'Free', 640.00, '04:31:00', '17:08:00', '671f461424bf1.webp', '2024-10-28 08:07:05');

-- --------------------------------------------------------

--
-- Table structure for table `archived_events`
--

DROP TABLE IF EXISTS `archived_events`;
CREATE TABLE IF NOT EXISTS `archived_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `price_category` enum('Free','Custom') NOT NULL,
  `event_price` decimal(10,2) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `event_poster` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `archived_events`
--

INSERT INTO `archived_events` (`id`, `event_name`, `event_date`, `event_venue`, `event_description`, `price_category`, `event_price`, `start_time`, `end_time`, `event_poster`, `created_at`) VALUES
(1, 'Michael Sykes', '2024-10-29', 'Sit odio reprehender', 'Repellendus Dolor a', 'Free', 729.00, '19:44:00', '13:31:00', '671f34d4de50e.webp', '2024-10-28 06:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_feedback`
--

DROP TABLE IF EXISTS `event_feedback`;
CREATE TABLE IF NOT EXISTS `event_feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `event_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_general_ci,
  `feedback_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_feedback`
--

INSERT INTO `event_feedback` (`id`, `user_id`, `event_id`, `rating`, `feedback`, `feedback_date`) VALUES
(1, 1, 1, 5, 'i enjoyed the event is well organized', '2024-10-28 07:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

DROP TABLE IF EXISTS `event_registrations`;
CREATE TABLE IF NOT EXISTS `event_registrations` (
  `registration_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`registration_id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_registrations`
--

INSERT INTO `event_registrations` (`registration_id`, `user_id`, `event_id`, `registration_date`) VALUES
(1, 1, 1, '2024-10-28 06:55:12'),
(2, 1, 2, '2024-10-28 08:07:31');

-- --------------------------------------------------------

--
-- Table structure for table `event_requests`
--

DROP TABLE IF EXISTS `event_requests`;
CREATE TABLE IF NOT EXISTS `event_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `price_category` varchar(50) NOT NULL,
  `event_price` decimal(10,2) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `event_poster` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `phone_number` varchar(10) DEFAULT NULL,
  `profile_pic` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`, `phone_number`, `profile_pic`) VALUES
(1, 'vamp2o5', 'bit-023-22@must.ac.mw', '$2y$10$A9Wf3jlmuJSop3YVlK/EQur6s7ydom5RtLMQByB1rfhZ2NVnIa522', '2024-10-28 06:50:32', '2024-10-28 08:08:31', '0885705304', '../profile_pictures/graduationStudents.webp');
--
-- Database: `fleet`
--
CREATE DATABASE IF NOT EXISTS `fleet` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `fleet`;

-- --------------------------------------------------------

--
-- Table structure for table `fleets`
--

DROP TABLE IF EXISTS `fleets`;
CREATE TABLE IF NOT EXISTS `fleets` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Route` varchar(20) NOT NULL,
  `Date` date NOT NULL,
  `Departure` time NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `eve`
--

DROP TABLE IF EXISTS `eve`;
CREATE TABLE IF NOT EXISTS `eve` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `targeted_people` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `eve`
--

INSERT INTO `eve` (`id`, `event_name`, `event_description`, `targeted_people`, `event_date`, `start_time`, `end_time`, `location`, `price`) VALUES
(1, 'Maia Houston', 'Cupiditate tempore ', 'Enim explicabo Quae', '2012-01-18', '17:02:00', '10:21:00', 'Quod est eos atque ', 10);
--
-- Database: `unievent_master`
--
CREATE DATABASE IF NOT EXISTS `unievent_master` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `unievent_master`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approved_events`
--

DROP TABLE IF EXISTS `approved_events`;
CREATE TABLE IF NOT EXISTS `approved_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `price_category` enum('Free','Custom') NOT NULL,
  `event_price` decimal(10,2) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `event_poster` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `approved_events`
--

INSERT INTO `approved_events` (`id`, `user_id`, `event_name`, `event_date`, `event_venue`, `event_description`, `price_category`, `event_price`, `start_time`, `end_time`, `event_poster`, `created_at`) VALUES
(1, 0, 'Music Performance', '2024-12-24', 'Quibusdam earum est', 'Praesentium nulla qu', 'Custom', 920.00, '20:13:00', '13:53:00', '67203097e401a.webp', '2024-10-29 00:51:24'),
(3, 0, 'Hackerthon', '2025-02-27', 'Excepteur dolor eius', 'Necessitatibus ea ab', 'Custom', 6300.00, '09:32:00', '15:41:00', '6720314a9e563.webp', '2024-10-29 00:51:33'),
(4, 0, 'Graduation Ceremony', '2025-01-30', 'Molestias sint Nam ', 'Aperiam obcaecati vo', 'Free', 236.00, '20:31:00', '15:30:00', '672031684ff0e.webp', '2024-10-29 00:51:37'),
(5, 0, 'Football Match', '2024-12-04', 'Culpa eveniet quia', 'Officiis aliquam adi', 'Free', 0.00, '21:31:00', '23:16:00', '67203122c7cc4.webp', '2024-10-29 00:51:41'),
(15, 0, 'Norman Clarke', '2024-11-07', 'Nisi labore qui aper', 'Ea ut quia sed volup', 'Custom', 124.00, '06:34:00', '08:08:00', '6720f7b55722d.webp', '2024-10-29 14:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `archived_events`
--

DROP TABLE IF EXISTS `archived_events`;
CREATE TABLE IF NOT EXISTS `archived_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `price_category` enum('Free','Custom') NOT NULL,
  `event_price` decimal(10,2) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `event_poster` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `archived_events`
--

INSERT INTO `archived_events` (`id`, `event_name`, `event_date`, `event_venue`, `event_description`, `price_category`, `event_price`, `start_time`, `end_time`, `event_poster`, `created_at`) VALUES
(1, 'Ali Gillespie', '1993-05-18', 'Voluptas id accusam', 'Architecto eos vel p', 'Custom', 535.00, '12:07:00', '03:08:00', '672032ee73f9d.webp', '2024-10-29 00:58:10'),
(2, 'Kennan Johnston', '2018-04-29', 'Duis omnis atque sap', 'Minima sint id repr', 'Custom', 159.00, '10:47:00', '20:55:00', '672032e27b796.webp', '2024-10-29 00:58:10'),
(3, 'Kareem Newton', '2019-06-03', 'Illum exercitatione', 'Fugiat dolorum temp', 'Free', 17.00, '13:59:00', '19:27:00', '6720328d6c3f8.webp', '2024-10-29 00:58:10'),
(4, 'Zia Dodson', '2022-10-28', 'Molestias enim aliqu', 'Adipisci consectetur', 'Free', 656.00, '00:53:00', '22:55:00', '672032a4cddc8.webp', '2024-10-29 00:58:10'),
(5, 'Justine Young', '1987-08-04', 'Est aut non consequa', 'Repellendus Eos ar', 'Custom', 624.00, '23:10:00', '14:36:00', '672032cd132e7.webp', '2024-10-29 00:58:10'),
(6, 'Gospel Music', '2024-11-09', 'Anim quas aspernatur', 'Voluptatem Aliquam ', 'Free', 0.00, '23:51:00', '05:25:00', '672030ceaec2a.webp', '2024-10-29 01:01:04'),
(7, 'Hammett Wise', '1970-07-04', 'Officiis qui veritat', 'Pariatur Ad ut dolo', 'Custom', 639.00, '03:36:00', '04:42:00', '6720f51f771d9.webp', '2024-10-29 14:46:23'),
(8, 'Beatrice Green', '2013-08-02', 'Sunt commodi et in p', 'Officia excepteur el', 'Free', 404.00, '02:38:00', '16:33:00', '6720f61b94ef3.webp', '2024-10-29 14:50:03'),
(9, 'Joshua May', '2001-03-31', 'Et labore at perfere', 'Assumenda dolor ut a', 'Free', 684.00, '23:41:00', '00:34:00', '6720f722a4456.webp', '2024-10-29 14:54:26'),
(10, 'Lana Boyle', '2024-10-29', 'Est ad nisi et nobis', 'Quos eaque amet omn', 'Free', 732.00, '04:30:00', '03:45:00', '6720f78ab7d99.webp', '2024-10-29 14:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_responded` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_feedback`
--

DROP TABLE IF EXISTS `event_feedback`;
CREATE TABLE IF NOT EXISTS `event_feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `event_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `feedback` text,
  `feedback_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `event_media`
--

DROP TABLE IF EXISTS `event_media`;
CREATE TABLE IF NOT EXISTS `event_media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `media_type` enum('image','video','other') NOT NULL,
  `media_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_media`
--

INSERT INTO `event_media` (`id`, `event_id`, `media_type`, `media_path`) VALUES
(1, 1, 'image', 'plants.heic'),
(2, 1, 'image', 'plants.heic'),
(3, 6, 'image', 'Gospel.webp'),
(4, 6, 'image', 'graduationStudents.webp'),
(5, 1, 'image', 'careerFair.webp');

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

DROP TABLE IF EXISTS `event_registrations`;
CREATE TABLE IF NOT EXISTS `event_registrations` (
  `registration_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`registration_id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_registrations`
--

INSERT INTO `event_registrations` (`registration_id`, `user_id`, `event_id`, `registration_date`) VALUES
(1, 1, 2, '2024-10-29 01:00:49'),
(2, 1, 1, '2024-10-29 04:47:58');

-- --------------------------------------------------------

--
-- Table structure for table `event_requests`
--

DROP TABLE IF EXISTS `event_requests`;
CREATE TABLE IF NOT EXISTS `event_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_description` text,
  `price_category` varchar(50) DEFAULT NULL,
  `event_price` decimal(10,2) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `event_poster` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_requests`
--

INSERT INTO `event_requests` (`id`, `user_id`, `event_name`, `event_date`, `event_venue`, `event_description`, `price_category`, `event_price`, `start_time`, `end_time`, `event_poster`, `created_at`) VALUES
(11, 1, 'Ethan Carey', '2024-10-29', 'Ducimus omnis aliqu', 'Ut enim ducimus ea ', 'Custom', 190.00, '04:41:00', '19:14:00', '672135b3733bc.webp', '2024-10-29 19:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

DROP TABLE IF EXISTS `responses`;
CREATE TABLE IF NOT EXISTS `responses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message_id` int NOT NULL,
  `admin_response` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `phone_number` varchar(10) DEFAULT NULL,
  `profile_pic` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`, `phone_number`, `profile_pic`) VALUES
(1, 'Benjamin Mwambakulu', 'bit-023-22@must.ac.mw', '$2y$10$m4pLToyZqu1p8tngWIyIye.iqq.Gw4kkeniJOOSjvOllpOayuS0cu', '2024-10-29 00:45:03', '2024-10-29 00:46:00', '0885705304', '../profile_pictures/hackerthon.webp');
--
-- Database: `yathu_ija_bus_line`
--
CREATE DATABASE IF NOT EXISTS `yathu_ija_bus_line` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `yathu_ija_bus_line`;

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

DROP TABLE IF EXISTS `buses`;
CREATE TABLE IF NOT EXISTS `buses` (
  `bus_id` int NOT NULL AUTO_INCREMENT,
  `number_plate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `capacity` int NOT NULL,
  `insurance_id` int DEFAULT NULL,
  `cof_id` int DEFAULT NULL,
  `bus_status` enum('available','in_use','maintenance','reserved','out_of_service') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'available',
  `tank_capacity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`bus_id`),
  UNIQUE KEY `number_plate` (`number_plate`) USING BTREE,
  KEY `insurance_id` (`insurance_id`),
  KEY `cof_id` (`cof_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`bus_id`, `number_plate`, `capacity`, `insurance_id`, `cof_id`, `bus_status`, `tank_capacity`, `created_at`, `updated_at`) VALUES
(1, '980', 14, 1, 1, 'in_use', 66, '2024-10-25 02:28:39', '2024-10-25 02:28:39'),
(2, '824', 64, 2, 2, 'reserved', 86, '2024-10-25 08:00:48', '2024-10-25 08:00:48'),
(3, '556', 17, 3, 3, 'available', 24, '2024-10-25 08:20:31', '2024-10-25 08:20:31'),
(4, '740', 7, 4, 4, 'available', 47, '2024-10-25 08:21:31', '2024-10-25 08:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `cof`
--

DROP TABLE IF EXISTS `cof`;
CREATE TABLE IF NOT EXISTS `cof` (
  `cof_id` int NOT NULL AUTO_INCREMENT,
  `issuing_authority` varchar(255) NOT NULL,
  `certificate_number` varchar(50) NOT NULL,
  `expiration_date` date NOT NULL,
  `cof_cost` float(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cof_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cof`
--

INSERT INTO `cof` (`cof_id`, `issuing_authority`, `certificate_number`, `expiration_date`, `cof_cost`, `created_at`, `updated_at`) VALUES
(1, 'Aut esse doloremque', '419', '1973-01-21', 75.00, '2024-10-25 02:28:39', '2024-10-25 02:28:39'),
(2, 'Nulla et veniam rei', '875', '1977-06-16', 26.00, '2024-10-25 08:00:48', '2024-10-25 08:00:48'),
(3, 'Aut sed quasi conseq', '308', '2011-03-12', 60.00, '2024-10-25 08:20:31', '2024-10-25 08:20:31'),
(4, 'Rerum velit non quas', '250', '1997-03-18', 19.00, '2024-10-25 08:21:31', '2024-10-25 08:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `cost`
--

DROP TABLE IF EXISTS `cost`;
CREATE TABLE IF NOT EXISTS `cost` (
  `cost_id` int NOT NULL AUTO_INCREMENT,
  `date_of_cost` date NOT NULL,
  `cost_description` varchar(255) NOT NULL,
  `source_of_cost` enum('fuel','maintenance','others') NOT NULL,
  `cost_amount` decimal(10,2) NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cost_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cost`
--

INSERT INTO `cost` (`cost_id`, `date_of_cost`, `cost_description`, `source_of_cost`, `cost_amount`, `notes`, `created_at`) VALUES
(1, '2021-08-17', 'Dolorum mollit ut ip', 'others', 70.00, NULL, '2024-10-25 08:20:53'),
(2, '1984-05-14', 'Quaerat ut eiusmod r', 'fuel', 20.00, NULL, '2024-10-26 00:50:39'),
(3, '1975-02-09', 'Sint laborum natus d', 'others', 68.00, NULL, '2024-10-26 00:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

DROP TABLE IF EXISTS `driver`;
CREATE TABLE IF NOT EXISTS `driver` (
  `driver_id` int NOT NULL AUTO_INCREMENT,
  `driver_name` varchar(100) DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  PRIMARY KEY (`driver_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_reports`
--

DROP TABLE IF EXISTS `financial_reports`;
CREATE TABLE IF NOT EXISTS `financial_reports` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `report_date` date NOT NULL,
  `total_revenue` decimal(10,2) DEFAULT '0.00',
  `total_cost` decimal(10,2) DEFAULT '0.00',
  `total_bookings` int DEFAULT '0',
  `pending_payments` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fleet_reports`
--

DROP TABLE IF EXISTS `fleet_reports`;
CREATE TABLE IF NOT EXISTS `fleet_reports` (
  `fleet_report_id` int NOT NULL AUTO_INCREMENT,
  `report_date` date NOT NULL,
  `total_distance` decimal(10,2) DEFAULT '0.00',
  `fuel_cost` decimal(10,2) DEFAULT '0.00',
  `maintenance_cost` decimal(10,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`fleet_report_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_bus_bookings`
--

DROP TABLE IF EXISTS `group_bus_bookings`;
CREATE TABLE IF NOT EXISTS `group_bus_bookings` (
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `leader_id` int NOT NULL,
  `departure_date` date NOT NULL,
  `return_date` date NOT NULL,
  `pickup_location_id` int NOT NULL,
  `destination_id` int NOT NULL,
  `bus_id` int NOT NULL,
  `payment_status` enum('Pending','Completed','Canceled') DEFAULT 'Pending',
  `payment_method` enum('Bank Transfer','Mobile Money') NOT NULL,
  `payment_proof` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `notes` text,
  PRIMARY KEY (`booking_id`),
  KEY `leader_id` (`leader_id`),
  KEY `pickup_location_id` (`pickup_location_id`),
  KEY `destination_id` (`destination_id`),
  KEY `bus_id` (`bus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_leaders`
--

DROP TABLE IF EXISTS `group_leaders`;
CREATE TABLE IF NOT EXISTS `group_leaders` (
  `leader_id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`leader_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance`
--

DROP TABLE IF EXISTS `insurance`;
CREATE TABLE IF NOT EXISTS `insurance` (
  `insurance_id` int NOT NULL AUTO_INCREMENT,
  `insurance_provider` varchar(255) NOT NULL,
  `policy_number` varchar(100) NOT NULL,
  `expiration_date` date NOT NULL,
  `insurance_cost` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`insurance_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `insurance`
--

INSERT INTO `insurance` (`insurance_id`, `insurance_provider`, `policy_number`, `expiration_date`, `insurance_cost`, `created_at`, `updated_at`) VALUES
(1, 'Vel voluptates quia ', '739', '2023-11-17', 30, '2024-10-25 02:28:39', '2024-10-25 02:28:39'),
(2, 'Minus quasi quaerat ', '45', '2008-06-21', 85, '2024-10-25 08:00:48', '2024-10-25 08:00:48'),
(3, 'Et autem voluptatem', '944', '2002-03-29', 68, '2024-10-25 08:20:31', '2024-10-25 08:20:31'),
(4, 'Nihil voluptatem nul', '311', '1981-04-03', 81, '2024-10-25 08:21:31', '2024-10-25 08:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `location_id` int NOT NULL AUTO_INCREMENT,
  `location_name` varchar(100) NOT NULL,
  PRIMARY KEY (`location_id`),
  UNIQUE KEY `location_name` (`location_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `revenue`
--

DROP TABLE IF EXISTS `revenue`;
CREATE TABLE IF NOT EXISTS `revenue` (
  `revenue_id` int NOT NULL AUTO_INCREMENT,
  `date_of_revenue` date NOT NULL,
  `revenue_description` varchar(255) NOT NULL,
  `source_of_revenue` enum('tickets','busBookings','others') NOT NULL,
  `revenue_amount` decimal(10,2) NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`revenue_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `revenue`
--

INSERT INTO `revenue` (`revenue_id`, `date_of_revenue`, `revenue_description`, `source_of_revenue`, `revenue_amount`, `notes`, `created_at`) VALUES
(1, '2014-05-27', 'Aut sit aperiam sapi', 'tickets', 51000.00, NULL, '2024-10-25 07:56:29'),
(2, '1973-09-04', 'Sit esse ea et in', 'others', 74.00, NULL, '2024-10-26 00:50:13'),
(3, '1995-07-27', 'Pariatur Praesentiu', 'busBookings', 87.00, NULL, '2024-10-26 00:50:19'),
(4, '1992-10-26', 'Inventore excepturi ', 'tickets', 54.00, NULL, '2024-10-26 00:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `trip_reports`
--

DROP TABLE IF EXISTS `trip_reports`;
CREATE TABLE IF NOT EXISTS `trip_reports` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `bus_id` int DEFAULT NULL,
  `driver_id` int DEFAULT NULL,
  `trip_date` date DEFAULT NULL,
  `distance_travelled` decimal(10,2) DEFAULT NULL,
  `note` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`),
  KEY `bus_id` (`bus_id`),
  KEY `driver_id` (`driver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trip_reports`
--

INSERT INTO `trip_reports` (`report_id`, `bus_id`, `driver_id`, `trip_date`, `distance_travelled`, `note`, `created_at`) VALUES
(1, 1, 0, '1973-06-22', 0.00, 'Ex aperiam tempora i', '2024-10-25 02:29:07'),
(2, 1, 0, '1973-06-22', 39.00, 'Ex aperiam tempora i', '2024-10-25 02:30:08'),
(3, 1, 0, '2022-01-08', 27.00, 'Eveniet sed vel quo', '2024-10-25 02:30:21'),
(4, 1, 0, '2011-12-06', 80.00, 'Nisi sit unde amet ', '2024-10-25 03:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `phone_number` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
