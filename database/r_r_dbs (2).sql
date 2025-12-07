-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 07, 2025 at 03:10 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `r&r_dbs`
--

-- --------------------------------------------------------

--
-- Table structure for table `cuslist`
--

DROP TABLE IF EXISTS `cuslist`;
CREATE TABLE IF NOT EXISTS `cuslist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mobile` varchar(13) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `addr` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cit` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `civ` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuslist`
--

INSERT INTO `cuslist` (`id`, `mobile`, `lname`, `fname`, `mname`, `addr`, `cit`, `civ`, `gen`, `filename`) VALUES
(1, '09438796045', 'Poe', 'Joemarie', 'Kadusale', 'Maaslum, Manjuyod, Negros Oriental', 'Filipino', 'Single', 'Male', '541598390_1452109289173031_8360374272984826409_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cus_pay`
--

DROP TABLE IF EXISTS `cus_pay`;
CREATE TABLE IF NOT EXISTS `cus_pay` (
  `cid` int NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bill` decimal(10,2) NOT NULL,
  `pay` decimal(10,2) NOT NULL,
  `mchange` decimal(10,2) NOT NULL,
  `bdate` datetime NOT NULL,
  `VAT` decimal(10,2) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cus_pay`
--

INSERT INTO `cus_pay` (`cid`, `cname`, `bill`, `pay`, `mchange`, `bdate`, `VAT`) VALUES
(1, 'Poe, Joemarie Kadusale', 0.00, 0.00, 0.00, '0000-00-00 00:00:00', 0.00),
(3, 'Japin, Jiro Tritin', 0.00, 0.00, 0.00, '0000-00-00 00:00:00', 0.00),
(4, 'Cheon, Venz Horace Baldonado', 0.00, 0.00, 0.00, '0000-00-00 00:00:00', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `quantity`, `total_amount`, `status`, `address`, `contact`) VALUES
(1, 4, 1, 12000.00, 'Approved', 'Jugno, Amlan, Negros Oriental', '0987654321'),
(2, 4, 1, 12000.00, 'Approved', 'Jugno, Amlan, Negros Oriental', '0987654321'),
(3, 4, 1, 15000.00, 'pending', 'Jugno, Amlan, Negros Oriental', '09561968942'),
(4, 4, 1, 12000.00, 'pending', 'Siaton, Negros Oriental', '09872231087'),
(5, 4, 1, 12000.00, 'pending', 'Palanas, Sta. Cruz Viejo, Tanjay City, Negros Oriental', '2132'),
(6, 4, 1, 15000.00, 'pending', 'Jugno, Amlan, Negros Oriental', '2132');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product`, `price`) VALUES
(1, 'Coco Lumber (1 * 2  * 8)', 30.00),
(2, 'COCO LUMBER (1 * 2  * 10)', 38.00),
(3, 'Coco Lumber (1 * 2  * 12)', 46.00),
(4, 'Coco Lumber (2 * 2  * 8)', 61.00),
(5, 'Coco Lumber (2 * 2  * 10)', 76.00),
(6, 'Coco Lumber (2 * 2  * 12)', 92.00),
(7, 'Coco Lumber (2 * 3  * 8)', 92.00),
(8, 'Coco Lumber (2 * 3  * 10)', 115.00),
(9, 'Coco Lumber (2 * 3 * 12)', 138.00),
(10, 'Coco Lumber (2 * 4  * 8)', 122.00),
(11, 'Coco Lumber (2 * 4  * 10)', 153.00),
(12, 'Coco Lumber (2 * 4  * 12)', 184.00),
(13, 'Coco Lumber (4 * 4  * 8)', 245.00),
(14, 'Coco Lumber (4 * 4  * 10)', 306.00),
(15, 'Coco Lumber (4 * 4  * 12)', 368.00),
(16, 'SAND (1 SACK)', 44.00),
(17, 'GRAVEL (1 SACK) ', 52.00),
(18, 'HOLLOW BLOCK', 13.00),
(19, 'CEMENT (1 SACK)', 181.00),
(20, 'COMMON NAILS ( 1\" )', 75.00),
(21, 'COMMON NAILS ( 1 1/2\" ) ', 70.00),
(22, 'COMMON NAILS ( 2\" )', 65.00),
(23, 'COMMON NAILS ( 2 1/2\" )', 65.00),
(24, 'COMMON NAILS ( 3\" )', 62.00),
(25, 'COMMON NAILS ( 4\" )', 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_solds`
--

DROP TABLE IF EXISTS `product_solds`;
CREATE TABLE IF NOT EXISTS `product_solds` (
  `s_id` int NOT NULL AUTO_INCREMENT,
  `s_item` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `s_price` decimal(10,2) NOT NULL,
  `s_qty` int NOT NULL,
  `s_total` decimal(10,2) NOT NULL,
  `s_cus` int NOT NULL,
  `s_date` datetime NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_solds`
--

INSERT INTO `product_solds` (`s_id`, `s_item`, `s_price`, `s_qty`, `s_total`, `s_cus`, `s_date`) VALUES
(1, 'COCO LUMBER (1 * 2  * 12)', 46.00, 1, 46.00, 1, '2025-06-04 00:00:00'),
(2, 'COCO LUMBER (2 * 4  * 10)', 153.00, 3, 459.00, 1, '2025-06-04 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `sale_id` int NOT NULL AUTO_INCREMENT,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `sale_vat` decimal(10,2) DEFAULT NULL,
  `sale_total` decimal(10,2) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `pass`, `created_at`) VALUES
(1, 'jirotritinvillaflores@gmail.com', '$2y$10$qz/iye2dDW5MMivo77Eh6e6HNO86L60kSsboCNqZh2VFdEGAs1oUq', '2025-11-23 21:00:44'),
(4, 'parkjihyo1997@gmail.com', '$2y$10$LJwxwTOy.ZFj7LbtRMPaU.FEA6vSB9nOh.X1BN8fZXZmoBSZpzR3K', '2025-12-06 10:52:49'),
(3, 'imnayeon@gmail.com', '$2y$10$MvjScPbqtjsmHxyqP1vctuhuIcL9UebCpjyx.h4sRdOnozYEnVCy.', '2025-11-26 07:20:40');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
