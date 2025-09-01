-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: hotel
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `breakfast`
--

DROP TABLE IF EXISTS `breakfast`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `breakfast` (
  `breakfast_id` int NOT NULL AUTO_INCREMENT,
  `breakfast_image` varchar(255) DEFAULT NULL,
  `breakfast_name` varchar(100) DEFAULT NULL,
  `breakfast_status` int DEFAULT NULL,
  `breakfast_type` varchar(100) DEFAULT NULL,
  `breakfast_available_from` varchar(100) DEFAULT NULL,
  `breakfast_available_to` varchar(100) DEFAULT NULL,
  `breakfast_nutritional_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`breakfast_id`),
  UNIQUE KEY `breakfast_name` (`breakfast_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breakfast`
--

LOCK TABLES `breakfast` WRITE;
/*!40000 ALTER TABLE `breakfast` DISABLE KEYS */;
INSERT INTO `breakfast` VALUES (1,'items_images/1750857304_idly.jpeg','Idly',1,'veg','09:00','10:30',NULL),(2,'items_images/1750253152_dosai.jpeg','Dosa',0,'veg','10:00','11:00',NULL),(3,'items_images/1750253266_poori.jpeg','Poori',1,'veg','09:00','11:00',NULL),(4,'items_images/1750697103_vadai.jpeg','Medu Vadai',1,'veg','08:00','11:00',NULL),(5,'items_images/1750350304_aapam-meat.jpeg','Aapam',1,'non-veg','09:00','10:30',NULL),(6,'items_images/1750350631_idiyappam-meat.jpeg','Idiyaapam',1,'non-veg','09:30','10:30',NULL),(9,'items_images/1750697174_idly-meat.jpeg','Idly-Meat',1,'non-veg','10:00','12:00',NULL),(10,'items_images/1750857500_parotta-meat.jpeg','Parotta-Meat',1,'non-veg','10:00','18:00',NULL),(11,'items_images/1750857566_chapathi.jpeg','Chapathi ',1,'non-veg','10:40','18:00',NULL);
/*!40000 ALTER TABLE `breakfast` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-09  7:17:43
