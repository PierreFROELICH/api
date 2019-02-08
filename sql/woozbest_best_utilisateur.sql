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
-- Table structure for table `best_utilisateur`
--

DROP TABLE IF EXISTS `best_utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `best_utilisateur` (
  `id_best_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `id_best_fk` int(11) NOT NULL,
  `id_utilisateur_fk` int(11) DEFAULT NULL,
  `pseudo` varchar(45) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id_best_utilisateur`),
  KEY `ttu_id_best_fk_INDEX` (`id_best_fk`),
  KEY `ttu_id_utilisateur_fk_INDEX` (`id_utilisateur_fk`),
  KEY `ttccc_pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `best_utilisateur`
--

LOCK TABLES `best_utilisateur` WRITE;
/*!40000 ALTER TABLE `best_utilisateur` DISABLE KEYS */;
INSERT INTO `best_utilisateur` VALUES (5,14,NULL,'payalba','2018-06-08 16:47:28','2018-06-08 16:47:28'),(6,14,NULL,'abc','2018-06-08 16:47:28','2018-06-08 16:47:28'),(7,15,NULL,'payalba','2018-06-08 16:49:31','2018-06-08 16:49:31'),(8,15,NULL,'abc','2018-06-08 16:49:31','2018-06-08 16:49:31'),(9,15,1,'aaa','2018-06-08 16:49:31','2018-06-08 16:49:31'),(10,16,NULL,'payalba','2018-06-08 17:23:46','2018-06-08 17:23:46'),(11,16,NULL,'abc','2018-06-08 17:23:46','2018-06-08 17:23:46'),(12,16,1,'aaa','2018-06-08 17:23:46','2018-06-08 17:23:46'),(13,17,NULL,'payalba','2018-06-08 17:23:58','2018-06-08 17:23:58'),(14,17,NULL,'abc','2018-06-08 17:23:58','2018-06-08 17:23:58'),(15,17,1,'aaa','2018-06-08 17:23:58','2018-06-08 17:23:58'),(16,18,NULL,'payalba','2018-06-08 17:25:07','2018-06-08 17:25:07'),(17,18,NULL,'abc','2018-06-08 17:25:07','2018-06-08 17:25:07'),(18,18,1,'aaa','2018-06-08 17:25:07','2018-06-08 17:25:07'),(19,19,NULL,'payalba','2018-06-08 17:25:38','2018-06-08 17:25:38'),(20,19,NULL,'abc','2018-06-08 17:25:38','2018-06-08 17:25:38'),(21,19,1,'aaa','2018-06-08 17:25:38','2018-06-08 17:25:38'),(22,20,NULL,'payalba','2018-06-08 17:26:05','2018-06-08 17:26:05'),(23,20,NULL,'abc','2018-06-08 17:26:05','2018-06-08 17:26:05'),(24,20,1,'aaa','2018-06-08 17:26:05','2018-06-08 17:26:05'),(25,21,NULL,'payalba','2018-06-08 17:26:45','2018-06-08 17:26:45'),(26,21,NULL,'abc','2018-06-08 17:26:45','2018-06-08 17:26:45'),(27,21,1,'aaa','2018-06-08 17:26:45','2018-06-08 17:26:45'),(28,1,NULL,'aa3','2018-06-08 17:59:49','2018-06-08 17:59:49'),(29,1,NULL,'abc','2018-06-08 17:59:49','2018-06-08 17:59:49'),(30,1,1,'aaa','2018-06-08 17:59:49','2018-06-08 17:59:49'),(31,22,NULL,'payalba','2018-06-08 20:21:27','2018-06-08 20:21:27'),(32,22,NULL,'abc','2018-06-08 20:21:27','2018-06-08 20:21:27'),(33,22,1,'aaa','2018-06-08 20:21:27','2018-06-08 20:21:27');
/*!40000 ALTER TABLE `best_utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-11 21:27:56
