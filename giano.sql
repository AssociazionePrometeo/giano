DROP DATABASE IF EXISTS `giano`;
CREATE DATABASE  IF NOT EXISTS `giano` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `giano`;
-- MySQL dump 10.16  Distrib 10.1.16-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: giano
-- ------------------------------------------------------
-- Server version	10.1.16-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_devices_1_idx` (`type`),
  CONSTRAINT `fk_type_device` FOREIGN KEY (`type`) REFERENCES `type_device` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cardcodeid` int(11) NOT NULL,
  `date_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_log_userid_idx` (`userid`),
  KEY `fk_log_cardcode_idx` (`cardcodeid`),
  CONSTRAINT `fk_log_cardcode` FOREIGN KEY (`cardcodeid`) REFERENCES `tags` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_log_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `type_user` int(11) NOT NULL,
  `permissions` enum('0','1') NOT NULL DEFAULT '0',
  `insert_devices` enum('0','1') NOT NULL DEFAULT '0',
  `insert_tags` enum('0','1') NOT NULL DEFAULT '0',
  `insert_users` enum('0','1') NOT NULL DEFAULT '0',
  `delete_devices` enum('0','1') NOT NULL DEFAULT '0',
  `delete_tags` enum('0','1') NOT NULL DEFAULT '0',
  `delete_users` enum('0','1') NOT NULL DEFAULT '0',
  `insert_reservation` enum('0','1') NOT NULL DEFAULT '0',
  `delete_reservation` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_type_user_idx` (`type_user`),
  CONSTRAINT `fk_type_user` FOREIGN KEY (`type_user`) REFERENCES `type_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deviceid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `from_time` timestamp NULL DEFAULT NULL,
  `to_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`deviceid`,`userid`),
  KEY `fk_reservation_userid_idx` (`userid`),
  KEY `fk_reservation_deviceid_idx` (`deviceid`),
  CONSTRAINT `fk_reservation_deviceid` FOREIGN KEY (`deviceid`) REFERENCES `devices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservation_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system`
--

DROP TABLE IF EXISTS `system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system` (
  `site name` mediumtext NOT NULL,
  `site url` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `cardcode` text NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `status` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_userid_tags_idx` (`userid`),
  CONSTRAINT `fk_userid_tags` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `type_device`
--

DROP TABLE IF EXISTS `type_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `type_user`
--

DROP TABLE IF EXISTS `type_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userid` int(25) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL DEFAULT '',
  `email_address` varchar(25) DEFAULT '',
  `username` varchar(25) NOT NULL DEFAULT '',
  `PASSWORD` varchar(255) NOT NULL DEFAULT '',
  `info` text,
  `user_level` int(11) NOT NULL DEFAULT '3',
  `mobile_number` text NOT NULL,
  `signup_date` date NOT NULL,
  `end_date` date NOT NULL,
  `last_login` date DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `fk_user_level_idx` (`user_level`),
  CONSTRAINT `fk_user_level` FOREIGN KEY (`user_level`) REFERENCES `type_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Membership Information';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'giano'
--

--
-- Dumping routines for database 'giano'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-03 14:05:47
