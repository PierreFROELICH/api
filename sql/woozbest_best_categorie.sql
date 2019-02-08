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
-- Table structure for table `best_categorie`
--

DROP TABLE IF EXISTS `best_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `best_categorie` (
  `id_best_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `id_best_fk` int(11) NOT NULL,
  `id_mot_cle_fk` int(11) DEFAULT NULL,
  `mot_cle` varchar(45) NOT NULL COMMENT 'Tag tel qu''ecrit par l''utilisateur si faute de grappe on le raproche du vrai tag et on le sbeste dans la table mot_cle_avec_faute',
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id_best_categorie`),
  KEY `tc_best_fk_INDEX` (`id_best_fk`),
  KEY `tc_mot_cle_fk_INDEX` (`id_mot_cle_fk`),
  KEY `tc_mot_cle_origine_INDEX` (`mot_cle`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `best_categorie`
--

LOCK TABLES `best_categorie` WRITE;
/*!40000 ALTER TABLE `best_categorie` DISABLE KEYS */;
INSERT INTO `best_categorie` VALUES (1,12,NULL,'test','2018-06-08 15:52:30','2018-06-08 15:52:30'),(2,12,NULL,'test ddd ddddd','2018-06-08 15:52:30','2018-06-08 15:52:30'),(3,13,NULL,'test','2018-06-08 16:46:32','2018-06-08 16:46:32'),(4,13,NULL,'test ddd ddddd','2018-06-08 16:46:32','2018-06-08 16:46:32'),(5,14,NULL,'test','2018-06-08 16:47:28','2018-06-08 16:47:28'),(6,14,NULL,'test ddd ddddd','2018-06-08 16:47:28','2018-06-08 16:47:28'),(7,15,NULL,'test','2018-06-08 16:49:31','2018-06-08 16:49:31'),(8,15,NULL,'test ddd ddddd','2018-06-08 16:49:31','2018-06-08 16:49:31'),(9,16,NULL,'test','2018-06-08 17:23:46','2018-06-08 17:23:46'),(10,16,NULL,'test ddd ddddd','2018-06-08 17:23:46','2018-06-08 17:23:46'),(11,17,NULL,'test','2018-06-08 17:23:58','2018-06-08 17:23:58'),(12,17,NULL,'test ddd ddddd','2018-06-08 17:23:58','2018-06-08 17:23:58'),(13,18,NULL,'test','2018-06-08 17:25:07','2018-06-08 17:25:07'),(14,18,NULL,'test ddd ddddd','2018-06-08 17:25:07','2018-06-08 17:25:07'),(15,19,NULL,'test','2018-06-08 17:25:38','2018-06-08 17:25:38'),(16,19,NULL,'test ddd ddddd','2018-06-08 17:25:38','2018-06-08 17:25:38'),(17,20,NULL,'test','2018-06-08 17:26:05','2018-06-08 17:26:05'),(18,20,NULL,'test ddd ddddd','2018-06-08 17:26:05','2018-06-08 17:26:05'),(19,21,NULL,'test','2018-06-08 17:26:45','2018-06-08 17:26:45'),(20,21,NULL,'test ddd ddddd','2018-06-08 17:26:45','2018-06-08 17:26:45'),(21,1,NULL,'test vv','2018-06-08 18:11:52','2018-06-08 18:11:52'),(22,1,NULL,'test ddd ddddd','2018-06-08 18:11:52','2018-06-08 18:11:52'),(23,22,NULL,'test','2018-06-08 20:21:27','2018-06-08 20:21:27'),(24,22,NULL,'test ddd ddddd','2018-06-08 20:21:27','2018-06-08 20:21:27');
/*!40000 ALTER TABLE `best_categorie` ENABLE KEYS */;
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
