-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 7, 2020 at 08:48 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--
-- --------------------------------------------------------
--
-- Table structure for table `user`
--

CREATE TABLE `user_seq`
(
  `user_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user` (
  `user_id` varchar(10) NOT NULL UNIQUE,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `token` varchar(20),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER $$
CREATE TRIGGER tg_user_insert
BEFORE INSERT ON user
FOR EACH ROW
BEGIN
  INSERT INTO user_seq VALUES (NULL);
  SET NEW.user_id = CONCAT('USER', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Insert data for table `user`
--

INSERT INTO `user` (`email`, `password`, `user_type`) VALUES
('sdwsec4grp5@gmail.com', 'sec4grp5', 'Admin');

-- --------------------------------------------------------
--
-- Table structure for table `runner`
--

CREATE TABLE `runner_seq`
(
  `rn_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`rn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `runner` (
  `rn_id` varchar(10) NOT NULL UNIQUE,
  `rn_name` varchar(255) NOT NULL,
  `rn_ic` varchar(50) NOT NULL,
  `rn_icpath` varchar(255) NOT NULL,
  `rn_imgpath` varchar(255),
  `rn_licensepath` varchar(255) NOT NULL,
  `phone_num` varchar(50) NOT NULL,
  `rn_gender` varchar(50) NOT NULL,
  `rn_address` varchar(255) NOT NULL,
  `status` varchar(50) NULL,
  `email` varchar(255) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  PRIMARY KEY (`rn_id`),
  CONSTRAINT `fk_rn_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER $$
CREATE TRIGGER tg_runner_insert
BEFORE INSERT ON runner
FOR EACH ROW
BEGIN
  INSERT INTO runner_seq VALUES (NULL);
  SET NEW.rn_id = CONCAT('RN', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Table structure for table `customer`
--

CREATE TABLE `customer_seq`
(
  `cus_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`cus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `customer` (
  `cus_id` varchar(10) NOT NULL UNIQUE,
  `username` varchar(50) NOT NULL,
  `cus_name` varchar(255) NOT NULL,
  `cus_imgpath` varchar(255),
  `phone_num` varchar(50) NOT NULL,
  `cus_gender` varchar(20) NOT NULL,
  `cus_address` varchar(255) NOT NULL,
  `cus_dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  PRIMARY KEY (`cus_id`),
  CONSTRAINT `fk_cus_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER $$
CREATE TRIGGER tg_customer_insert
BEFORE INSERT ON customer
FOR EACH ROW
BEGIN
  INSERT INTO customer_seq VALUES (NULL);
  SET NEW.cus_id = CONCAT('CUS', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Table structure for table `service provider`
--

CREATE TABLE `sp_seq`
(
  `sp_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `sp` (
  `sp_id` varchar(10) NOT NULL UNIQUE,
  `sp_name` varchar(255) NOT NULL,
  `sp_ic` varchar(50) NOT NULL,
  `sp_icpath` varchar(255) NOT NULL, 
  `sp_imgpath` varchar(255), 
  `phone_num` varchar(50) NOT NULL,
  `sp_address` varchar(255) NOT NULL,
  `sp_shop_name` varchar(100) NOT NULL,
  `status` varchar(50) NULL,
  `email` varchar(255) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  PRIMARY KEY (`sp_id`),
  CONSTRAINT `fk_sp_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER $$
CREATE TRIGGER tg_sp_insert
BEFORE INSERT ON sp
FOR EACH ROW
BEGIN
  INSERT INTO sp_seq VALUES (NULL);
  SET NEW.sp_id = CONCAT('SP', LPAD(LAST_INSERT_ID(), 3, '0'));
END$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Table structure for table `service provider's bank`
--

CREATE TABLE `sp_bank` (
  `acc_id` int(16) NOT NULL UNIQUE AUTO_INCREMENT,
  `accnum` int(16) NOT NULL ,
  `accname` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  PRIMARY KEY (`acc_id`),
  CONSTRAINT `fk_sp_bank_id` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `customer's bank`
--

CREATE TABLE `cus_bank` (
  `acc_id` int(16) NOT NULL UNIQUE AUTO_INCREMENT,
  `accnum` int(16) NOT NULL ,
  `accname` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `cus_id` varchar(10) NOT NULL,
  PRIMARY KEY (`acc_id`),
  CONSTRAINT `fk_cus_bank_id` FOREIGN KEY (`cus_id`) REFERENCES `customer`(`cus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `runner's bank`
--

CREATE TABLE `rn_bank` (
  `acc_id` int(16) NOT NULL UNIQUE AUTO_INCREMENT,
  `accnum` int(16) NOT NULL ,
  `accname` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `rn_id` varchar(10) NOT NULL,
  PRIMARY KEY (`acc_id`),
  CONSTRAINT `fk_rn_bank_id` FOREIGN KEY (`rn_id`) REFERENCES `runner`(`rn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `food`
--

CREATE TABLE `food_seq`
(
  `fd_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`fd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `food` (
  `fd_id` varchar(10) NOT NULL UNIQUE,
  `fd_name` varchar(255) NOT NULL,
  `fd_detail` varchar(255) NOT NULL,
  `fd_price` float(2) NOT NULL,
  `fd_imgid` varchar(50) NOT NULL,
  `fd_coverpath` varchar(255) NOT NULL,
  `fd_quantity` int(11) NOT NULL,
  `fd_variation` varchar(50) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  PRIMARY KEY (`fd_id`),
  CONSTRAINT `fk_fd_spid` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER $$
CREATE TRIGGER tg_food_insert
BEFORE INSERT ON food
FOR EACH ROW
BEGIN
  INSERT INTO food_seq VALUES (NULL);
  SET NEW.fd_id = CONCAT('FD', LPAD(LAST_INSERT_ID(), 5, '0'));
END$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine_seq`
(
  `med_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`med_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `medicine` (
  `med_id` varchar(10) NOT NULL UNIQUE,
  `med_name` varchar(255) NOT NULL,
  `med_detail` varchar(255) NOT NULL,
  `med_price` float(2) NOT NULL,
  `med_imgid` varchar(50) NOT NULL,
  `med_coverpath` varchar(255) NOT NULL,
  `med_quantity` int(11) NOT NULL,
  `med_variation` varchar(50) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  PRIMARY KEY (`med_id`),
  CONSTRAINT `fk_med_spid` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER $$
CREATE TRIGGER tg_med_insert
BEFORE INSERT ON medicine
FOR EACH ROW
BEGIN
  INSERT INTO medicine_seq VALUES (NULL);
  SET NEW.med_id = CONCAT('MED', LPAD(LAST_INSERT_ID(), 5, '0'));
END$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Table structure for table `pet`
--

CREATE TABLE `pet_seq`
(
  `pet_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `pet` (
  `pet_id` varchar(10) NOT NULL UNIQUE,
  `pet_name` varchar(255) NOT NULL,
  `pet_detail` varchar(255) NOT NULL,
  `pet_price` float(2) NOT NULL,
  `pet_imgid` varchar(50) NOT NULL,
  `pet_coverpath` varchar(255) NOT NULL,
  `pet_quantity` int(11) NOT NULL,
  `pet_variation` varchar(50) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  PRIMARY KEY (`pet_id`),
  CONSTRAINT `fk_pet_spid` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER $$
CREATE TRIGGER tg_pet_insert
BEFORE INSERT ON pet
FOR EACH ROW
BEGIN
  INSERT INTO pet_seq VALUES (NULL);
  SET NEW.pet_id = CONCAT('PET', LPAD(LAST_INSERT_ID(), 5, '0'));
END$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Table structure for table `goods`
--

CREATE TABLE `goods_seq`
(
  `gd_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`gd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `goods` (
  `gd_id` varchar(10) NOT NULL UNIQUE,
  `gd_name` varchar(255) NOT NULL,
  `gd_detail` varchar(255) NOT NULL,
  `gd_price` float(2) NOT NULL,
  `gd_imgid` varchar(50) NOT NULL,
  `gd_coverpath` varchar(255) NOT NULL,
  `gd_quantity` int(11) NOT NULL,
  `gd_variation` varchar(50) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  PRIMARY KEY (`gd_id`),
  CONSTRAINT `fk_gd_spid` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) AUTO_INCREMENT=00001 ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER $$
CREATE TRIGGER tg_goods_insert
BEFORE INSERT ON goods
FOR EACH ROW
BEGIN
  INSERT INTO goods_seq VALUES (NULL);
  SET NEW.gd_id = CONCAT('GD', LPAD(LAST_INSERT_ID(), 5, '0'));
END$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Table structure for table `food's image`
--

CREATE TABLE `fd_image` (
  `fd_imgid` int(11) NOT NULL UNIQUE AUTO_INCREMENT,
  `imgpath` varchar(255) NOT NULL,
  `get_imgid` varchar(10) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  PRIMARY KEY (`fd_imgid`),
  CONSTRAINT `fk_fd_imgid` FOREIGN KEY (`get_imgid`) REFERENCES `food`(`fd_id`),
  CONSTRAINT `fk_fdimg_spid` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) AUTO_INCREMENT=00001 ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `medicine's image`
--

CREATE TABLE `med_image` (
  `med_imgid` int NOT NULL UNIQUE AUTO_INCREMENT,
  `imgpath` varchar(255) NOT NULL,
  `get_imgid` varchar(10) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  PRIMARY KEY (`med_imgid`),
  CONSTRAINT `fk_med_imgid` FOREIGN KEY (`get_imgid`) REFERENCES `medicine`(`med_id`),
  CONSTRAINT `fk_medimg_spid` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) AUTO_INCREMENT=00001 ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `goods's image`
--

CREATE TABLE `gd_image` (
  `gd_imgid` int NOT NULL UNIQUE AUTO_INCREMENT,
  `imgpath` varchar(255) NOT NULL,
  `get_imgid` varchar(10) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  PRIMARY KEY (`gd_imgid`),
  CONSTRAINT `fk_gd_imgid` FOREIGN KEY (`get_imgid`) REFERENCES `goods`(`gd_id`),
  CONSTRAINT `fk_gdimg_spid` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) AUTO_INCREMENT=00001 ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `pet's image`
--

CREATE TABLE `pet_image` (
  `pet_imgid` int NOT NULL UNIQUE AUTO_INCREMENT,
  `imgpath` varchar(255) NOT NULL,
  `get_imgid` varchar(10) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  PRIMARY KEY (`pet_imgid`),
  CONSTRAINT `fk_pet_imgid` FOREIGN KEY (`get_imgid`) REFERENCES `pet`(`pet_id`),
  CONSTRAINT `fk_petimg_spid` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) AUTO_INCREMENT=00001 ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int NOT NULL UNIQUE AUTO_INCREMENT,
  `product_id` varchar(10) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` float(2) NOT NULL,
  `product_imgpath` varchar(255) NOT NULL,
  `product_quantity` int NOT NULL,
  `order_time` varchar(255) NULL,
  `status` varchar(255) NULL,
  `total_price` float(2) NULL,
  `type` varchar(10) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  `cus_id` varchar(10) NOT NULL,
  PRIMARY KEY (`cart_id`),
  CONSTRAINT `fk_cartsp_id` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`),
  CONSTRAINT `fk_cartcus_id` FOREIGN KEY (`cus_id`) REFERENCES `customer`(`cus_id`)
) AUTO_INCREMENT=00001 ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int NOT NULL UNIQUE AUTO_INCREMENT,
  `total_price` float(2) NOT NULL,
  `date` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `cus_id` varchar(10) NOT NULL,
  PRIMARY KEY (`payment_id`),
  CONSTRAINT `fk_paycus_id` FOREIGN KEY (`cus_id`) REFERENCES `customer`(`cus_id`)
) AUTO_INCREMENT=00001 ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `ordered`
--

CREATE TABLE `ordered` (
  `order_id` int NOT NULL UNIQUE AUTO_INCREMENT,
  `product_id` varchar(10) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` float(2) NOT NULL,
  `product_quantity` int NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `order_time` varchar(255) NOT NULL,
  `order_droptime` varchar(255) NULL,
  `total_price` float(2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rn_id` varchar(10) NULL,
  `sp_id` varchar(10) NOT NULL,
  `cus_id` varchar(10) NOT NULL,
  PRIMARY KEY (`order_id`),
  CONSTRAINT `fk_orderrn_id` FOREIGN KEY (`rn_id`) REFERENCES `runner`(`rn_id`),  
  CONSTRAINT `fk_ordercus_id` FOREIGN KEY (`cus_id`) REFERENCES `customer`(`cus_id`),
  CONSTRAINT `fk_ordersp_id` FOREIGN KEY (`sp_id`) REFERENCES `sp`(`sp_id`)
) AUTO_INCREMENT=00001 ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
