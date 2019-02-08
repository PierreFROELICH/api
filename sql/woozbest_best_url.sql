-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: woozbest
-- ------------------------------------------------------
-- Server version	5.7.19

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
-- Table structure for table `best_url`
--

DROP TABLE IF EXISTS `best_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `best_url` (
  `id_best_url` int(11) NOT NULL AUTO_INCREMENT,
  `id_best_fk` int(11) NOT NULL,
  `url` varchar(45) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id_best_url`),
  KEY `tturl_id_best_fk_INDEX` (`id_best_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `best_url`
--

LOCK TABLES `best_url` WRITE;
/*!40000 ALTER TABLE `best_url` DISABLE KEYS */;
INSERT INTO `best_url` VALUES (5,15,'http://test.com','2018-06-08 16:49:31','2018-06-08 16:49:31'),(6,15,'testurl.com','2018-06-08 16:49:31','2018-06-08 16:49:31'),(7,16,'http://test.com','2018-06-08 17:23:46','2018-06-08 17:23:46'),(8,16,'testurl.com','2018-06-08 17:23:46','2018-06-08 17:23:46'),(9,17,'http://test.com','2018-06-08 17:23:58','2018-06-08 17:23:58'),(10,17,'testurl.com','2018-06-08 17:23:58','2018-06-08 17:23:58'),(11,18,'http://test.com','2018-06-08 17:25:07','2018-06-08 17:25:07'),(12,18,'testurl.com','2018-06-08 17:25:07','2018-06-08 17:25:07'),(13,19,'http://test.com','2018-06-08 17:25:38','2018-06-08 17:25:38'),(14,19,'testurl.com','2018-06-08 17:25:38','2018-06-08 17:25:38'),(15,20,'http://test.com','2018-06-08 17:26:05','2018-06-08 17:26:05'),(16,20,'testurl.com','2018-06-08 17:26:05','2018-06-08 17:26:05'),(17,21,'http://test.com','2018-06-08 17:26:45','2018-06-08 17:26:45'),(18,21,'testurl.com','2018-06-08 17:26:45','2018-06-08 17:26:45'),(19,1,'http://test.com','2018-06-08 17:59:49','2018-06-08 17:59:49'),(20,1,'testurl.com','2018-06-08 17:59:49','2018-06-08 17:59:49'),(21,22,'http://test.com','2018-06-08 20:21:27','2018-06-08 20:21:27'),(22,22,'testurl.com','2018-06-08 20:21:27','2018-06-08 20:21:27');
/*!40000 ALTER TABLE `best_url` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-11 21:27:54
