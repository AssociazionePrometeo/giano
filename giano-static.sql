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
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (1,'Ingresso',1,1),(2,'Sala Riunioni',1,1);
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,1,'1','1','1','1','1','1','1','1','1'),(2,2,'0','1','1','1','0','0','0','1','1'),(3,3,'0','0','0','0','0','0','0','1','1');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `system`
--

LOCK TABLES `system` WRITE;
/*!40000 ALTER TABLE `system` DISABLE KEYS */;
/*!40000 ALTER TABLE `system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'112314',1,1),(2,'4324',3,1),(3,'47beet',2,1),(4,'47beeb',1,0);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `type_device`
--

LOCK TABLES `type_device` WRITE;
/*!40000 ALTER TABLE `type_device` DISABLE KEYS */;
INSERT INTO `type_device` VALUES (1,'Porta');
/*!40000 ALTER TABLE `type_device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `type_user`
--

LOCK TABLES `type_user` WRITE;
/*!40000 ALTER TABLE `type_user` DISABLE KEYS */;
INSERT INTO `type_user` VALUES (1,'administrator'),(2,'manager'),(3,'user');
/*!40000 ALTER TABLE `type_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@fb7.it','admin','6e6bc4e49dd477ebc98ef4046c067b5f','Fablab',1,'+393336666666','2016-09-26','2017-10-31','2016-10-03',1),(2,'manager','manager@fb7.it','manager','6e6bc4e49dd477ebc98ef4046c067b5f','Fablab',2,'+393354444444','2016-09-26','2017-10-31','2016-09-26',1),(3,'user','user@fb7.it','user','6e6bc4e49dd477ebc98ef4046c067b5f','Fablab',3,'+393489999999','2016-09-26','2017-10-31','2016-09-29',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'giano'
--

--
-- Dumping routines for database 'giano'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-03 14:02:39
