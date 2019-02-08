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
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(256) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `pseudo` varchar(45) NOT NULL,
  `telephone` varchar(16) DEFAULT NULL,
  `mdp` varchar(255) NOT NULL,
  `date_mdp` datetime NOT NULL,
  `token_session` varchar(64) DEFAULT NULL,
  `debut_session` datetime DEFAULT NULL,
  `token_mdp_oublie` varchar(64) DEFAULT NULL,
  `date_mdp_oublie` datetime DEFAULT NULL,
  `guid` varchar(45) NOT NULL,
  `date_guid` datetime DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `id_langue_fk` int(11) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  `date_suppression` datetime DEFAULT NULL,
  `status` enum('en_attente_validation','certifie','suspendu','banni','a_supprimer') DEFAULT 'en_attente_validation',
  `celebrite` int(11) DEFAULT '0' COMMENT 'Chiffre indiquant le niveau de célébrité de la personne plus c''est haut plus on peut avoir confiance',
  `date_validation_cgu` datetime DEFAULT NULL,
  `version_cgu` int(11) DEFAULT '1',
  `url_image` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `pseudo_UNIQUE` (`pseudo`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `token_session_INDEX` (`token_session`),
  KEY `guid_INDEX` (`guid`),
  KEY `status_INDEX` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'test@test.com','aa','bb','aaa','0130222','$2y$10$CDN.H.h013ApI9N6S4zY..sbFV3sJC0MicgktXzIWl/CM1zhdzxL.','2000-01-01 02:04:00','504e8046247c9ff99c8537aeee846780ee6c762c768761e58cab434e40843648','2018-05-27 13:25:31',NULL,'2000-01-01 02:04:00','2',NULL,NULL,NULL,NULL,'2000-01-01 02:04:00','2018-06-04 18:59:28',NULL,'en_attente_validation',1,NULL,1,NULL),(2,'test1@test.com','t','py','aaa0','0684816160','$2y$10$TIwKVvq5207KA6zCa38UROiK2yEbEZp.6CYGOfatgD73tNOSqe/aa','2018-05-27 16:46:14','f8c303a6b76716a1ad8dfeadb66ea700f53e6401830f46a72b8e95731505907b','2018-05-31 12:09:37',NULL,NULL,'47099f9c-61d0-11e8-bd14-00e04c680ee1','2018-05-27 17:06:54',NULL,NULL,NULL,'2018-05-27 16:46:14','2018-05-31 12:09:37',NULL,'en_attente_validation',0,'2018-05-27 16:46:14',1,NULL),(3,'test2@test.com',NULL,NULL,'aaa1',NULL,'$2y$10$Niw5Ab7d5QiI6aX4.3zE5eKoW7FFPsD.W.bFGDlyay5Qn9Dd.Mq4G','2018-05-27 17:06:54',NULL,NULL,NULL,NULL,'a94671d1-61d1-11e8-bd14-00e04c680ee1','2018-05-27 17:06:54',NULL,NULL,NULL,'2018-05-27 17:06:54','2018-06-04 18:29:29',NULL,'en_attente_validation',1,'2018-05-27 17:06:54',1,NULL),(4,'test3@test.com',NULL,NULL,'aaa2',NULL,'$2y$10$ythU2d2HspU0gT3bd1mav.JZQnvhGBzZq5tI/e/MYNkfyQge/AuNy','2018-05-27 17:07:59','a7e292715a4c99e9a85606809202dc21aa872927bd71df63904bb86ca76a137e','2018-06-07 19:18:50',NULL,NULL,'80970036-61d0-11e8-bd14-00e04c680ee1','2018-05-27 17:07:59',NULL,NULL,NULL,'2018-05-27 17:07:59','2018-06-08 20:21:27',NULL,'en_attente_validation',150,'2018-05-27 17:07:59',1,NULL),(5,'test4@test.com',NULL,NULL,'aaa4',NULL,'$2y$10$1izYLaTBxLJ5LvJV7PNG7e0Vfv933eyBwy0lAT7bkfDWaeW9MYZP6','2018-05-28 11:12:22',NULL,NULL,NULL,NULL,'fd020d65-6267-11e8-bd14-00e04c680ee1','2018-05-28 11:12:22',NULL,NULL,NULL,'2018-05-28 11:12:22','2018-05-28 11:12:22',NULL,'en_attente_validation',0,'2018-05-28 11:12:22',1,NULL),(6,'test9@test.com',NULL,NULL,'aaa9',NULL,'$2y$10$pstKOOwxifqYEKNjOMK5ku9k7zjOlOs0Ld4gvOH5xSrgEao1V7.RG','2018-06-05 20:33:25',NULL,NULL,NULL,NULL,'b26f1a50-68ff-11e8-9635-00e04c680ee1','2018-06-05 20:33:25',NULL,NULL,NULL,'2018-06-05 20:33:25','2018-06-05 20:33:25',NULL,'en_attente_validation',0,'2018-06-05 20:33:25',1,NULL),(7,'test10@test.com','zzzzzzcdsd',NULL,'aaa10',NULL,'$2y$10$b4Kcgaan.8ieoFaflcPE7uh8D8N5Pm9PGnSGkMsIHRLi3LwDq3rXi','2018-06-05 20:35:46',NULL,NULL,NULL,NULL,'06c06e10-6900-11e8-9635-00e04c680ee1','2018-06-05 20:35:46',NULL,NULL,NULL,'2018-06-05 20:35:46','2018-06-05 20:35:46',NULL,'en_attente_validation',0,'2018-06-05 20:35:46',1,NULL),(8,'test11@test.com',NULL,NULL,'aaa11',NULL,'$2y$10$b5GQxDYiUMcKkyXveRe8guA4ceB1FeKrd92b1KLSYrUps.wCloTii','2018-06-05 20:36:21',NULL,NULL,NULL,NULL,'1b474712-6900-11e8-9635-00e04c680ee1','2018-06-05 20:36:21',NULL,NULL,NULL,'2018-06-05 20:36:21','2018-06-05 20:36:21',NULL,'en_attente_validation',0,'2018-06-05 20:36:21',1,NULL),(9,'test12@test.com','zzzzzzcdsd',NULL,'aaa12',NULL,'$2y$10$ArkWFPPQhTjgwUR/Mt9G5uizFkBaGb5bmHwbS.bJu/5N9ri3D7ziG','2018-06-05 20:37:03',NULL,NULL,NULL,NULL,'34a72530-6900-11e8-9635-00e04c680ee1','2018-06-05 20:37:03',NULL,NULL,NULL,'2018-06-05 20:37:03','2018-06-05 20:37:03',NULL,'en_attente_validation',0,'2018-06-05 20:37:03',1,NULL),(10,'test13@test.com','zzzzzzcdsd','eeee','aaa13',NULL,'$2y$10$mI5teZPesPVwsf9gXwwlMeOUs3CiLv8pFcmHzYJj6VRbXIeJPCzV.','2018-06-05 20:37:47',NULL,NULL,NULL,NULL,'4eb778e4-6900-11e8-9635-00e04c680ee1','2018-06-05 20:37:47',NULL,NULL,NULL,'2018-06-05 20:37:47','2018-06-05 20:37:47',NULL,'en_attente_validation',0,'2018-06-05 20:37:47',1,NULL);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-11 21:27:55
