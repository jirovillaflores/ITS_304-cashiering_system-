-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 16, 2025 at 11:16 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `quantity`, `total_amount`, `status`, `address`, `contact`) VALUES
(1, 4, 1, 12000.00, 'Approved', 'Jugno, Amlan, Negros Oriental', '0987654321'),
(2, 4, 1, 12000.00, 'Approved', 'Jugno, Amlan, Negros Oriental', '0987654321'),
(3, 4, 1, 15000.00, 'pending', 'Jugno, Amlan, Negros Oriental', '09561968942'),
(4, 4, 1, 12000.00, 'pending', 'Siaton, Negros Oriental', '09872231087'),
(5, 4, 1, 12000.00, 'pending', 'Palanas, Sta. Cruz Viejo, Tanjay City, Negros Oriental', '2132'),
(6, 4, 1, 15000.00, 'pending', 'Jugno, Amlan, Negros Oriental', '2132'),
(7, 4, 1, 1090.00, 'pending', 'Palanas, Sta. Cruz Viejo, Tanjay City, Negros Oriental', '0987654321'),
(8, 3, 1, 1090.00, 'pending', 'Jugno, Amlan, Negros Oriental', '0987654321'),
(9, 3, 1, 1090.00, 'pending', 'Canlargo, Bais City, Negros Oriental', '0987654321');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `pr_id` int NOT NULL AUTO_INCREMENT,
  `pr_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pr_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`pr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pr_id`, `pr_name`, `pr_price`) VALUES
(1, 'jfefbewoibfewo', 90.00),
(2, 'jfefbewoibfewo', 90.00),
(3, 'jfefbewoibfewo', 90.00),
(4, 'kubfeuwfbweub', 112.00),
(5, 'kubfeuwfbweub', 112.00);

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
