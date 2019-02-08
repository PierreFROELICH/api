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
-- Table structure for table `best`
--

DROP TABLE IF EXISTS `best`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `best` (
  `id_best` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur_fk` int(11) NOT NULL,
  `titre` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `url_image` varchar(128) DEFAULT NULL,
  `nb_like` int(11) DEFAULT NULL,
  `date_dernier_like` datetime DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `status` enum('brouillon','publie','supprime') DEFAULT 'brouillon',
  `date_publication` datetime DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  `date_suppression` datetime DEFAULT NULL,
  PRIMARY KEY (`id_best`),
  KEY `best_id_utilisateur_FK` (`id_utilisateur_fk`),
  KEY `best_nb_like` (`nb_like`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `best`
--

LOCK TABLES `best` WRITE;
/*!40000 ALTER TABLE `best` DISABLE KEYS */;
INSERT INTO `best` VALUES (1,2,'titre @aa3 #test $aaa @abc/def','dddd @aaa http://test.com  testurl.com ddd','0ba80739434a19ffcfda38cc88602497045b1ab13b5ac2f2b8ffe90a9962242c_2018-05-24.png',0,NULL,1.1,1.2,'brouillon',NULL,'2018-02-16 00:00:00','2018-06-08 18:17:50',NULL),(2,3,'test2','eee','sss',1,'2018-06-04 18:29:29',NULL,NULL,'publie',NULL,'2018-02-16 00:00:00','2018-06-07 19:20:13',NULL),(3,4,'titre','titre','C:\\MonSIte\\woozbest\\api/storage//temp\\d066f00b1d77df0ed9e8484408c4528f86d04858598d8eef9e60e12f7bf1151e_2018-03-29 (2).png',0,NULL,0,0,'brouillon',NULL,'2018-06-08 14:12:56','2018-06-08 14:12:56',NULL),(4,4,'titre','dddd','9e958908417720d9f67e8a22164fe966870227f3bc90a2fdff3fcbfaf96cf3a6_2018-03-29 (2).png',0,NULL,NULL,NULL,'brouillon',NULL,'2018-06-08 15:10:45','2018-06-08 15:10:45',NULL),(5,4,'titre','dddd','2f04cbf011662f774f2adce839fe697170b34874608b89a28640bc8708a73ba5_2018-03-29 (2).png',0,NULL,1.1,1.2,'brouillon',NULL,'2018-06-08 15:12:35','2018-06-08 15:12:35',NULL),(6,4,'titre','dddd','75a9d206bd0688fe4e451bce5f695e4ee7ca81a8af88e9b295edb1bf05c0dfa3_2018-03-29 (2).png',0,NULL,1.1,1.2,'brouillon',NULL,'2018-06-08 15:14:54','2018-06-08 15:14:54',NULL),(7,4,'titre','dddd','9eabf001a954c9d9ea5f0ca8364d824e3b36301f43435ec2a8fcb843ecb1be4e_2018-03-29 (2).png',0,NULL,1.1,1.2,'brouillon',NULL,'2018-06-08 15:16:55','2018-06-08 15:16:55',NULL),(8,4,'titre','dddd','ab52a0f22fb905329dd70eef8d120eda6b63e2a1c4caf1f0c68960f13840d84c_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 15:18:33','2018-06-08 15:18:33','2018-06-08 15:18:33',NULL),(9,4,'titre','dddd','a12320f0abdcba47daa66175de56b00d81a18ddb8186763f404671f69c92939a_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 15:31:58','2018-06-08 15:31:58','2018-06-08 15:31:58',NULL),(10,4,'titre','dddd','f709cf4cb5c03b02d3ddd2c8932f0a3a9d01a13c3e356a65701f3a2a89286fe6_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 15:43:20','2018-06-08 15:43:20','2018-06-08 15:43:20',NULL),(11,4,'titre @payalba #test $aaa @abc/def','dddd','9f4836e93c33cb653902a5b02d86da375912b8ee6d194dc208055e0ddc79edc4_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 15:51:27','2018-06-08 15:51:27','2018-06-08 15:51:27',NULL),(12,4,'titre @payalba #test $aaa @abc/def','dddd','200d681e9bde5b05324184416b8ab3578d8938276aba340cfbbbfb590e6101b8_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 15:52:30','2018-06-08 15:52:30','2018-06-08 15:52:30',NULL),(13,4,'titre @payalba #test $aaa @abc/def','dddd','b10f36964d438f3e82cbd4ead8d0528c85e1374ef57d55a20b624e5e420f634c_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 16:46:32','2018-06-08 16:46:32','2018-06-08 16:46:32',NULL),(14,4,'titre @payalba #test $aaa @abc/def','dddd','193046503bae48f75634be23273b6b14db7fa5c93725f70bc26ff8497c8a6302_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 16:47:28','2018-06-08 16:47:28','2018-06-08 16:47:28',NULL),(15,4,'titre @payalba #test $aaa @abc/def','dddd @aaa http://test.com  testurl.com','678a9b8b198fb3ad3a47f989b120a64d231d6e9c1c14184cd14028b4efbabf85_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 16:49:31','2018-06-08 16:49:31','2018-06-08 16:49:31',NULL),(16,4,'titre @payalba #test $aaa @abc/def','dddd @aaa http://test.com  testurl.com','42fffc7e99f14d18f75edd5115fcf0cf99a01786a62a281e7f483f449910c07f_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 17:23:46','2018-06-08 17:23:46','2018-06-08 17:23:46',NULL),(17,4,'titre @payalba #test $aaa @abc/def','dddd @aaa http://test.com  testurl.com','4fce55ed300d712ff29048e724a46b654ada973197722aa626b70d9e750f4025_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 17:23:58','2018-06-08 17:23:58','2018-06-08 17:23:58',NULL),(18,4,'titre @payalba #test $aaa @abc/def','dddd @aaa http://test.com  testurl.com','01cbc3c23d087f864238ce41a35f96467a66cd5e3843f8e90f6fe298bbb05b22_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 17:25:07','2018-06-08 17:25:07','2018-06-08 17:25:07',NULL),(19,4,'titre @payalba #test $aaa @abc/def','dddd @aaa http://test.com  testurl.com','e104fb54ce00fca59a5811e11050b9978290f594f4a79669813c1d54eccebb3d_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 17:25:38','2018-06-08 17:25:38','2018-06-08 17:25:38',NULL),(20,4,'titre @payalba #test $aaa @abc/def','dddd @aaa http://test.com  testurl.com','f764cd823dd8d54ae60c570b831c5ed39656b2894f68e77353e66320a5360b77_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 17:26:05','2018-06-08 17:26:05','2018-06-08 17:26:05',NULL),(21,4,'titre @payalba #test $aaa @abc/def','dddd @aaa http://test.com  testurl.com','47e3521879107a862a51ed6c93bd7744653c45c727d3e4689f1851b7c2ae80c4_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 17:26:44','2018-06-08 17:26:44','2018-06-08 17:26:44',NULL),(22,4,'titre @payalba #test $aaa @abc/def','dddd @aaa http://test.com  testurl.com','3c00e6b24965ac299f318ba7497ccda4f580eb83a2c4d3121687906d9ea89d5e_2018-03-29 (2).png',0,NULL,1.1,1.2,'publie','2018-06-08 20:21:27','2018-06-08 20:21:27','2018-06-08 20:21:27',NULL);
/*!40000 ALTER TABLE `best` ENABLE KEYS */;
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
