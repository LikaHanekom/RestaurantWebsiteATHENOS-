-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 13, 2026 at 10:24 AM
-- Server version: 8.0.37
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactinquiry`
--

DROP TABLE IF EXISTS `contactinquiry`;
CREATE TABLE IF NOT EXISTS `contactinquiry` (
  `inquiry_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `contact_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`inquiry_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `location_id` int NOT NULL AUTO_INCREMENT,
  `location_name` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `features` json DEFAULT NULL,
  `capacity` int DEFAULT '50',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`location_id`),
  KEY `idx_province` (`province`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `province`, `address`, `phone`, `email`, `features`, `capacity`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Blueberry', 'Gauteng', 'Shop 12, Blueberry Square, Blue Hills, Midrand', '+27 (0) 11 310 2200', 'blueberry@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\"]', 85, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(2, 'Harvest Place', 'Gauteng', 'Corner Harvest Rd & Main Ave, Centurion', '+27 (0) 12 345 6789', 'harvest@athenos.co.za', '[\"takeaway\", \"on-site\", \"liquor\"]', 120, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(3, 'Montecasino', 'Gauteng', 'Montecasino Boulevard, Fourways, Johannesburg', '+27 (0) 11 511 1234', 'montecasino@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\", \"liquor\", \"smoking\"]', 200, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(4, 'Morningside', 'Gauteng', 'Rivonia Rd & Outspan Rd, Morningside, Sandton', '+27 (0) 11 884 5698', 'morningside@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\"]', 95, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(5, 'Newmarket', 'Gauteng', 'Newmarket Street, Alberton North', '+27 (0) 10 005 4789', 'newmarket@athenos.co.za', '[\"takeaway\", \"on-site\", \"liquor\"]', 75, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(6, 'Silverstar Casino', 'Gauteng', 'R28 & N14, Muldersdrift, Mogale City', '+27 (0) 11 662 1300', 'silverstar@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"liquor\", \"smoking\"]', 180, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(7, 'Waterfall Corner', 'Gauteng', 'Woodmead Drive & Magwa Cres, Waterfall City', '+27 (0) 11 234 7788', 'waterfall@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\"]', 110, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(8, 'Camps Bay', 'Western Cape', 'Victoria Road, Camps Bay, Cape Town', '+27 (0) 21 438 8890', 'campsbay@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"liquor\", \"on-site\"]', 150, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(9, 'Century City', 'Western Cape', 'Bridgeways Precinct, Century City', '+27 (0) 21 551 2390', 'centurycity@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\", \"liquor\"]', 130, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(10, 'Durbanville', 'Western Cape', 'C/o Oxford St & Wellington Rd, Durbanville', '+27 (0) 21 976 4321', 'durbanville@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"on-site\"]', 90, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(11, 'Franschhoek', 'Western Cape', 'Huguenot Street, Franschhoek', '+27 (0) 21 876 5432', 'franschhoek@athenos.co.za', '[\"takeaway\", \"liquor\", \"on-site\"]', 70, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(12, 'George', 'Western Cape', 'York Street, George CBD', '+27 (0) 44 874 0012', 'george@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\"]', 85, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(13, 'GrandWest', 'Western Cape', 'GrandWest Casino, Goodwood, Cape Town', '+27 (0) 21 535 1111', 'grandwest@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"liquor\", \"smoking\"]', 220, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(14, 'Hermanus', 'Western Cape', 'Marine Drive, Hermanus', '+27 (0) 28 312 3456', 'hermanus@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"on-site\"]', 80, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(15, 'Mouille Point', 'Western Cape', 'Beach Road, Mouille Point, Cape Town', '+27 (0) 21 433 2211', 'mouillepoint@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\", \"liquor\"]', 100, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(16, 'Paarl', 'Western Cape', 'Main Street, Paarl', '+27 (0) 21 863 9988', 'paarl@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"on-site\"]', 75, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(17, 'Rondebosch', 'Western Cape', 'Main Road, Rondebosch, Cape Town', '+27 (0) 21 689 3456', 'rondebosch@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\"]', 95, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(18, 'Somerset West', 'Western Cape', 'Broadway Boulevard, Somerset West', '+27 (0) 21 852 1432', 'somersetwest@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"liquor\"]', 110, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(19, 'Steenberg', 'Western Cape', 'Steenberg Village, Tokai', '+27 (0) 21 701 2456', 'steenberg@athenos.co.za', '[\"takeaway\", \"on-site\", \"wheelchair\"]', 65, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(20, 'Stellenbosch', 'Western Cape', 'Dorps Street, Stellenbosch', '+27 (0) 21 887 4321', 'stellenbosch@athenos.co.za', '[\"takeaway\", \"delivery\", \"liquor\", \"wheelchair\"]', 120, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(21, 'Willowbridge', 'Western Cape', 'Willowbridge Centre, Carl Cronje Dr, Bellville', '+27 (0) 21 914 3700', 'willowbridge@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\"]', 105, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(22, 'Worcester', 'Western Cape', 'High Street, Worcester', '+27 (0) 23 342 1987', 'worcester@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"on-site\"]', 70, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(23, 'Kimberley', 'Northern Cape', 'Du Toitspan Road, Kimberley', '+27 (0) 53 832 1441', 'kimberley@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"on-site\"]', 60, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(24, 'Kloof', 'KwaZulu-Natal', 'Village Road, Kloof, Durban', '+27 (0) 31 764 8765', 'kloof@athenos.co.za', '[\"takeaway\", \"delivery\", \"wheelchair\", \"liquor\"]', 95, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(25, 'Oceans', 'KwaZulu-Natal', 'Oceans Mall, Umhlanga Rocks', '+27 (0) 31 566 9900', 'oceans@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"liquor\", \"on-site\"]', 140, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23'),
(26, 'Walmer', 'Eastern Cape', '17 6th Avenue, Walmer, Gqeberha', '+27 (0) 41 581 2244', 'walmer@athenos.co.za', '[\"takeaway\", \"wheelchair\", \"on-site\"]', 80, 1, '2026-05-15 08:25:23', '2026-05-15 08:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `menuitem`
--

DROP TABLE IF EXISTS `menuitem`;
CREATE TABLE IF NOT EXISTS `menuitem` (
  `menu_item_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(150) NOT NULL,
  `product_description` text,
  `product_price` decimal(10,2) NOT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `product_category` enum('starter','main','dessert','drink') NOT NULL,
  `created_by` int NOT NULL,
  PRIMARY KEY (`menu_item_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `reservation_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `party_size` int NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservation_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_location_id` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `location_id`, `reservation_date`, `reservation_time`, `party_size`, `status`, `date_created`) VALUES
(1, NULL, NULL, NULL, NULL, 26, '2026-05-26', '18:00:00', 8, 'confirmed', '2026-05-25 10:56:20'),
(2, NULL, NULL, NULL, NULL, 26, '2026-06-13', '14:00:00', 8, 'confirmed', '2026-06-06 11:06:27'),
(3, 1, NULL, NULL, NULL, 26, '2026-06-14', '12:00:00', 8, 'pending', '2026-06-13 12:02:26'),
(4, NULL, 'Alika Hanekom', 'alikahanekom@gmail.com', '0742732934', 26, '2026-06-18', '00:00:12', 8, 'pending', '2026-06-13 12:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int NOT NULL AUTO_INCREMENT,
  `menu_item_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `review_comment` text,
  `review_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `menu_item_id` (`menu_item_id`),
  KEY `user_id` (`user_id`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` enum('customer','admin','staff') NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_role`) VALUES
(1, 'Alika', 'alikahanekom@gmail.com', '$2y$10$6zzT0tBtpo58/HyEr9Jcce5g2XAtJFlkKds64u4F0vQFIWuQ36Cpm', 'customer'),
(2, 'Adriaan', 'adriaansteyn3310@gmail.com', '$2y$10$O2MefxRrytp22hCUntUO.Og3q3qtBlPgsdFXj5UkUIs/pMcK4qr3a', 'customer'),
(3, 'Hanlie', 'hanekomhanlie@gmail.com', '$2y$10$KqgTlGIj6oQhbtKvfhjhceZSMLkBu4B7V6o0i0pW16PXlrhGYlg7y', 'customer'),
(4, 'Admin', 'admin@gmail.com', '$2y$10$PpOnKjhDcSCf5d9F31Lt.O.Qbb4PH5bPIgCasLNEdhsmpuNGGyfpS', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `website_content`
--

DROP TABLE IF EXISTS `website_content`;
CREATE TABLE IF NOT EXISTS `website_content` (
  `content_id` int NOT NULL AUTO_INCREMENT,
  `content_key` varchar(100) NOT NULL,
  `content_type` enum('text','image') NOT NULL,
  `content_value` text NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`content_id`),
  UNIQUE KEY `content_key` (`content_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contactinquiry`
--
ALTER TABLE `contactinquiry`
  ADD CONSTRAINT `contactinquiry_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `menuitem`
--
ALTER TABLE `menuitem`
  ADD CONSTRAINT `menuitem_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`menu_item_id`) REFERENCES `menuitem` (`menu_item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
