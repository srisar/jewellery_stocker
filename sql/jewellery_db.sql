-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5909
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for jewellery_stock
CREATE DATABASE IF NOT EXISTS `jewellery_stock` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `jewellery_stock`;

-- Dumping structure for table jewellery_stock.bills
CREATE TABLE IF NOT EXISTS `bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_date` date DEFAULT NULL,
  `customer_name` varchar(200) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `bill_total` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table jewellery_stock.bills: ~0 rows (approximately)
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;

-- Dumping structure for table jewellery_stock.bill_items
CREATE TABLE IF NOT EXISTS `bill_items` (
  `bill_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table jewellery_stock.bill_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `bill_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `bill_items` ENABLE KEYS */;

-- Dumping structure for table jewellery_stock.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table jewellery_stock.categories: ~9 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
REPLACE INTO `categories` (`id`, `category_name`, `added_on`, `updated_at`) VALUES
	(1, 'Bangle', '2020-03-05 20:37:20', '2020-03-05 20:37:20'),
	(2, 'Earring', '2020-03-05 20:37:20', '2020-03-05 20:37:20'),
	(3, 'Necklace', '2020-03-05 20:37:20', '2020-03-05 20:37:20'),
	(4, 'Bracelet', '2020-03-05 20:37:20', '2020-03-05 20:37:20'),
	(5, 'Pendents', '2020-03-05 20:37:20', '2020-03-05 20:37:20'),
	(6, 'Ring', '2020-03-05 20:37:20', '2020-03-05 20:37:20'),
	(7, 'Chain', '2020-03-05 20:37:20', '2020-03-05 20:37:20'),
	(8, 'Baby Item', '2020-03-05 20:37:20', '2020-03-05 20:51:20'),
	(9, 'Other', '2020-03-05 20:37:20', '2020-03-05 20:37:20');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table jewellery_stock.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `gold_quality` int(11) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `stock_price` double DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `added_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `items_categories_id_fk` (`category_id`),
  CONSTRAINT `items_categories_id_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table jewellery_stock.items: ~4 rows (approximately)
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
REPLACE INTO `items` (`id`, `item_name`, `description`, `gold_quality`, `weight`, `quantity`, `stock_price`, `category_id`, `added_on`, `updated_at`) VALUES
	(1, 'BAS 1', 'Yellow gold', 22, 27.926, 2, 35000, 1, '2020-03-05 20:55:04', '2020-03-06 08:17:44'),
	(2, 'BAS 5', 'Yellow gold', 22, 30.31, 1, 38500, 1, '2020-03-05 21:04:56', '2020-03-06 08:04:40'),
	(3, 'NKZ 14', 'Yellow gold with cubic zirconia', 20, 13.3, 4, 28450, 3, '2020-03-05 21:06:08', '2020-03-06 18:53:10'),
	(4, 'NKZ 11', 'Yellow gold with cubic zirconia', 20, 30.6, 2, 32500, 3, '2020-03-05 21:06:51', '2020-03-07 10:37:55');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;

-- Dumping structure for table jewellery_stock.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_title` varchar(255) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `order_amount` double DEFAULT NULL,
  `initial_payment` double DEFAULT NULL,
  `added_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table jewellery_stock.orders: ~0 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table jewellery_stock.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `password_string` varchar(255) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table jewellery_stock.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `username`, `first_name`, `last_name`, `profile_pic`, `password_string`, `created_on`, `updated_at`) VALUES
	(1, 'admin', 'Srisaravana', 'Manicaraka', NULL, '$2y$10$xwBj2n4PGlDPjppoPwwGyO1s8Hm7r1l2sug5WhYFNDMe0j9Wcl70O', '2020-02-28 11:09:09', '2020-02-28 15:38:50');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
