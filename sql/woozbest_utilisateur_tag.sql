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
-- Table structure for table `utilisateur_tag`
--

DROP TABLE IF EXISTS `utilisateur_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur_tag` (
  `id_utilisateur_tag` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur_fk` int(11) NOT NULL,
  `id_mot_cle_fk` int(11) DEFAULT NULL,
  `mot_cle` varchar(45) NOT NULL,
  `type` enum('calcule','utilisateur') NOT NULL DEFAULT 'utilisateur',
  `poids` int(11) DEFAULT '100',
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur_tag`),
  KEY `ut_id_utilisateur_fk` (`id_utilisateur_fk`),
  KEY `ut_id_mot_cle_fk` (`id_mot_cle_fk`),
  KEY `ut_mot_cle` (`mot_cle`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur_tag`
--

LOCK TABLES `utilisateur_tag` WRITE;
/*!40000 ALTER TABLE `utilisateur_tag` DISABLE KEYS */;
INSERT INTO `utilisateur_tag` VALUES (14,2,NULL,'test ddd ddddd','calcule',19,'2018-06-09 19:53:35','2018-06-09 19:59:33'),(15,2,NULL,'test','utilisateur',31,'2018-06-09 19:53:35','2018-06-09 19:58:09'),(16,2,NULL,'test vv','calcule',11,'2018-06-09 19:53:35','2018-06-09 19:59:33'),(17,4,NULL,'test ddd ddddd','calcule',19,'2018-06-09 19:53:35','2018-06-09 19:59:33'),(18,4,NULL,'test','utilisateur',50,'2018-06-09 19:53:35','2018-06-09 19:58:09'),(19,2,NULL,'test','calcule',69,'2018-06-09 19:59:33','2018-06-09 19:59:33'),(20,4,NULL,'test','calcule',81,'2018-06-09 19:59:33','2018-06-09 19:59:33');
/*!40000 ALTER TABLE `utilisateur_tag` ENABLE KEYS */;
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
