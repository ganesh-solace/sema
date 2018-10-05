/*
SQLyog Community v13.1.1 (64 bit)
MySQL - 5.7.19 : Database - wire_frames
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`wire_frames` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `wire_frames`;

/*Table structure for table `brand_price_adjustment_bridge` */

DROP TABLE IF EXISTS `brand_price_adjustment_bridge`;

CREATE TABLE `brand_price_adjustment_bridge` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `BrandID` bigint(20) NOT NULL,
  `SellerID` bigint(20) NOT NULL,
  `TypeID` enum('Markup','Test','add') NOT NULL,
  `AmountTypeID` enum('Percentage','Cash') NOT NULL,
  `BaseID` enum('Jobber Price') NOT NULL,
  `Amount` decimal(12,2) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `Status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `price_adjustment_seller_FK` (`SellerID`),
  KEY `price_adjustment_brand_FK` (`BrandID`),
  KEY `price_adjustment_type_FK` (`TypeID`),
  KEY `price_adjustment_amount_type_FK` (`AmountTypeID`),
  KEY `price_adjustment_price_base_FK` (`BaseID`),
  CONSTRAINT `price_adjustment_brand_FK` FOREIGN KEY (`BrandID`) REFERENCES `brands` (`ID`),
  CONSTRAINT `price_adjustment_seller_FK` FOREIGN KEY (`SellerID`) REFERENCES `sellers` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `brand_price_adjustment_bridge` */

insert  into `brand_price_adjustment_bridge`(`ID`,`BrandID`,`SellerID`,`TypeID`,`AmountTypeID`,`BaseID`,`Amount`,`CreatedDate`,`ModifiedDate`,`Status`) values 
(1,1,1,'Markup','Percentage','Jobber Price',150.00,'2018-10-03 11:04:58','2018-10-03 11:04:58',1),
(2,1,2,'Markup','Percentage','Jobber Price',200.00,'2018-10-03 11:04:58','2018-10-03 11:04:58',1),
(5,5,2,'Markup','Percentage','Jobber Price',10.00,'2018-10-05 12:58:55','2018-10-05 12:58:55',0),
(6,5,2,'Markup','Percentage','Jobber Price',20.00,'2018-10-05 13:34:51','2018-10-05 13:34:51',0),
(7,5,2,'Test','Percentage','Jobber Price',30.00,'2018-10-05 13:35:26','2018-10-05 13:35:26',0),
(8,5,2,'Markup','Percentage','Jobber Price',30.00,'2018-10-05 13:35:39','2018-10-05 13:35:39',0),
(9,5,2,'Markup','Percentage','Jobber Price',30.00,'2018-10-05 13:51:05','2018-10-05 13:51:05',1);

/*Table structure for table `brand_seller_bridge` */

DROP TABLE IF EXISTS `brand_seller_bridge`;

CREATE TABLE `brand_seller_bridge` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `BrandID` bigint(20) NOT NULL,
  `SellerID` bigint(20) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `status` int(1) DEFAULT NULL COMMENT '0 inactive, 1 active, 2 closed',
  `CreatedBy` bigint(20) DEFAULT NULL,
  `ModifiedBy` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `brand_seller_brand_FK` (`BrandID`),
  KEY `brand_seller_seller_FK` (`SellerID`),
  CONSTRAINT `brand_seller_brand_FK` FOREIGN KEY (`BrandID`) REFERENCES `brands` (`ID`),
  CONSTRAINT `brand_seller_seller_FK` FOREIGN KEY (`SellerID`) REFERENCES `sellers` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `brand_seller_bridge` */

insert  into `brand_seller_bridge`(`ID`,`BrandID`,`SellerID`,`CreatedDate`,`ModifiedDate`,`status`,`CreatedBy`,`ModifiedBy`) values 
(30,5,1,'2018-10-05 06:21:28','2018-10-05 06:21:28',0,1,1),
(31,5,2,'2018-10-05 06:21:58','2018-10-05 06:21:58',1,1,1);

/*Table structure for table `brands` */

DROP TABLE IF EXISTS `brands`;

CREATE TABLE `brands` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Code` varchar(50) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `NumberOfItem` varchar(200) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `Status` int(1) DEFAULT NULL COMMENT '0 inactive, 1 active, 2 closed',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `brands` */

insert  into `brands`(`ID`,`Code`,`Name`,`Description`,`NumberOfItem`,`CreatedDate`,`ModifiedDate`,`Status`) values 
(1,'B-01','BD Suspension','Suspension product brand','12','2018-10-01 06:52:31','2018-10-03 06:39:42',1),
(2,'B-02','BD Suspension','Suspension product brand','3','2018-10-01 06:52:40','2018-10-01 06:52:40',1),
(5,'B-03','AirLyft','AirLyft','32','2018-10-01 06:52:40','2018-10-05 06:00:42',1),
(6,'B-06','Backrack','Backrack','3','0000-00-00 00:00:00','2018-10-05 06:48:05',1),
(7,'B-07','Mishimoto','Mishimoto','23','2018-10-05 06:51:33','2018-10-05 06:51:33',1);

/*Table structure for table `seller_price_amount_type` */

DROP TABLE IF EXISTS `seller_price_amount_type`;

CREATE TABLE `seller_price_amount_type` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `seller_price_amount_type` */

/*Table structure for table `seller_price_base` */

DROP TABLE IF EXISTS `seller_price_base`;

CREATE TABLE `seller_price_base` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `seller_price_base` */

/*Table structure for table `seller_price_type` */

DROP TABLE IF EXISTS `seller_price_type`;

CREATE TABLE `seller_price_type` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `seller_price_type` */

/*Table structure for table `sellers` */

DROP TABLE IF EXISTS `sellers`;

CREATE TABLE `sellers` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Code` varchar(50) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `BusinessName` varchar(200) DEFAULT NULL,
  `JPSellerID` varchar(200) DEFAULT NULL,
  `WebstoreURL` varchar(150) DEFAULT NULL,
  `JPFTPName` varchar(200) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `sellers` */

insert  into `sellers`(`ID`,`Code`,`Name`,`Description`,`BusinessName`,`JPSellerID`,`WebstoreURL`,`JPFTPName`,`CreatedDate`,`ModifiedDate`) values 
(1,'S-01','Maracco','Best seller','THunder Maraccos','maracco','maraccos.com','maraccos','2018-10-03 11:02:57','2018-10-03 11:02:57'),
(2,'S-02','TBauto','TB Auto','Thnder Bay Auto Parts','tbauto','tbautoparts.com','tbauto','2018-10-03 11:04:58','2018-10-03 11:04:58');

/*Table structure for table `sema_brand_class_bridge` */

DROP TABLE IF EXISTS `sema_brand_class_bridge`;

CREATE TABLE `sema_brand_class_bridge` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `BrandID` bigint(20) NOT NULL,
  `ClassID` bigint(20) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `Status` tinyint(1) DEFAULT '1' COMMENT '0 inactive 1 active',
  PRIMARY KEY (`ID`),
  KEY `brands_class_brand_FK` (`BrandID`),
  KEY `brands_class_classID_FK` (`ClassID`),
  CONSTRAINT `brands_class_brand_FK` FOREIGN KEY (`BrandID`) REFERENCES `brands` (`ID`),
  CONSTRAINT `brands_class_classID_FK` FOREIGN KEY (`ClassID`) REFERENCES `sema_class` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `sema_brand_class_bridge` */

insert  into `sema_brand_class_bridge`(`ID`,`BrandID`,`ClassID`,`CreatedDate`,`ModifiedDate`,`Status`) values 
(1,1,1,'2018-10-01 06:52:31','2018-10-01 06:52:31',0),
(2,1,3,'2018-10-01 06:52:31','2018-10-01 06:52:31',0),
(3,2,1,'2018-10-01 06:52:40','2018-10-01 06:52:40',0),
(4,2,3,'2018-10-01 06:52:40','2018-10-01 06:52:40',0),
(5,1,1,'2018-10-03 06:37:51','2018-10-03 06:37:51',0),
(6,1,3,'2018-10-03 06:37:51','2018-10-03 06:37:51',0),
(7,1,1,'2018-10-03 06:37:57','2018-10-03 06:37:57',0),
(8,1,3,'2018-10-03 06:37:57','2018-10-03 06:37:57',0),
(9,1,1,'2018-10-03 06:39:42','2018-10-03 06:39:42',1),
(10,1,3,'2018-10-03 06:39:42','2018-10-03 06:39:42',1),
(11,5,3,'2018-10-05 06:00:42','2018-10-05 06:00:42',1),
(12,6,2,'2018-10-05 06:47:34','2018-10-05 06:47:34',0),
(13,6,2,'2018-10-05 06:48:05','2018-10-05 06:48:05',1),
(14,7,1,'2018-10-05 06:51:33','2018-10-05 06:51:33',1);

/*Table structure for table `sema_class` */

DROP TABLE IF EXISTS `sema_class`;

CREATE TABLE `sema_class` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Code` varchar(50) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `sema_class` */

insert  into `sema_class`(`ID`,`Code`,`Name`,`Description`,`CreatedDate`,`ModifiedDate`) values 
(1,'SBC-01','Platinum','Platinum','2018-09-28 13:03:29','2018-09-28 13:03:34'),
(2,'SBC-02','Gold','Gold','2018-09-28 13:03:29','2018-09-28 13:03:29'),
(3,'SBC-03','Silver','Silver','2018-09-28 13:03:29','2018-09-28 13:03:29');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `ID` bigint(20) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`ID`,`Name`,`password`,`Description`,`Status`,`Email`) values 
(1,'admin','202cb962ac59075b964b07152d234b70','test',1,'admin@gmail.com'),
(2,'ankita','e66055e8e308770492a44bf16e875127','test',1,'ankita@gmail.com');

/*Table structure for table `wire_frame_details` */

DROP TABLE IF EXISTS `wire_frame_details`;

CREATE TABLE `wire_frame_details` (
  `meta_key` varchar(150) DEFAULT NULL,
  `meta_value` varchar(50000) DEFAULT NULL,
  `meta_status` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `wire_frame_details` */

insert  into `wire_frame_details`(`meta_key`,`meta_value`,`meta_status`) values 
('Unique Item ID','B15 Part Number',1),
('Part Name','ACES Part Type ID',1),
('Title','Title',1),
('Price','D40_RET Retail',1),
('Quantity','Quantity',1),
('Condition','',1),
('Condition','',1),
('Description','\"C10_ABR Product Desc\",\"C10_SHO Product Desc\",\"C10_INV Product Desc\",\"C10_DEF AAIA Part Type Desc\",\"C10_LAB Label Desc\",\"C10_DES Product Desc\",\"C10_SHP Shipping Desc\",\"C10_SLA Slang Desc\",\"C10_UNS UN/SPSC Desc\",\"C10_VMR VMRS Desc\",\"C10_EXT Product Desc\",\"C10_MKT Marketing Desc\"',1),
('HTML Description','',1),
('Product SKU','B10 Item-Level GTIN',1),
('Brand','B25 Brand Label',1),
('Brand','B25 Brand Label',1),
('Brand','B25 Brand Label',1),
('ACES Part Type ID','ACES Part Type ID',1),
('warranty','E10_WS1',1),
('Payment Methods','Payment Methods',1);

/* Procedure structure for procedure `Test` */

/*!50003 DROP PROCEDURE IF EXISTS  `Test` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Test`()
BEGIN

	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
