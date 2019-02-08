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
-- Table structure for table `best_tag`
--

DROP TABLE IF EXISTS `best_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `best_tag` (
  `id_best_tag` int(11) NOT NULL AUTO_INCREMENT,
  `id_best_fk` int(11) NOT NULL,
  `id_mot_cle_fk` int(11) DEFAULT NULL,
  `mot_cle` varchar(45) NOT NULL COMMENT 'Tag tel qu''ecrit par l''utilisateur si faute de grappe on le raproche du vrai tag et on le sbeste dans la table tag_avec_faute',
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id_best_tag`),
  KEY `tt_id_best_fk_INDEX` (`id_best_fk`),
  KEY `tt_id_mot_cle_fk_INDEX` (`id_mot_cle_fk`),
  KEY `tt_mot_cle_origine` (`mot_cle`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `best_tag`
--

LOCK TABLES `best_tag` WRITE;
/*!40000 ALTER TABLE `best_tag` DISABLE KEYS */;
INSERT INTO `best_tag` VALUES (1,7,NULL,'test','2018-06-08 15:16:55','2018-06-08 15:16:55'),(2,7,NULL,'test ddd ddddd','2018-06-08 15:16:55','2018-06-08 15:16:55'),(3,8,NULL,'test','2018-06-08 15:18:33','2018-06-08 15:18:33'),(4,8,NULL,'test ddd ddddd','2018-06-08 15:18:33','2018-06-08 15:18:33'),(5,13,NULL,'test','2018-06-08 16:46:33','2018-06-08 16:46:33'),(6,14,NULL,'test','2018-06-08 16:47:28','2018-06-08 16:47:28'),(7,15,NULL,'test','2018-06-08 16:49:31','2018-06-08 16:49:31'),(8,16,NULL,'test','2018-06-08 17:23:46','2018-06-08 17:23:46'),(9,17,NULL,'test','2018-06-08 17:23:58','2018-06-08 17:23:58'),(10,18,NULL,'test','2018-06-08 17:25:07','2018-06-08 17:25:07'),(11,19,NULL,'test','2018-06-08 17:25:38','2018-06-08 17:25:38'),(12,20,NULL,'test','2018-06-08 17:26:05','2018-06-08 17:26:05'),(13,21,NULL,'test','2018-06-08 17:26:45','2018-06-08 17:26:45'),(14,1,NULL,'test','2018-06-08 18:05:51','2018-06-08 18:05:51'),(15,22,NULL,'test','2018-06-08 20:21:27','2018-06-08 20:21:27');
/*!40000 ALTER TABLE `best_tag` ENABLE KEYS */;
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
