-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: rental_management_system
-- ------------------------------------------------------
-- Server version	8.0.32

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
-- Table structure for table `leaseagreement`
--

DROP TABLE IF EXISTS `leaseagreement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leaseagreement` (
  `lease_id` int NOT NULL AUTO_INCREMENT,
  `property_number` int NOT NULL,
  `renter_name` varchar(50) NOT NULL,
  `home_phone` varchar(20) NOT NULL,
  `work_phone` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `monthly_rent` decimal(10,2) NOT NULL,
  PRIMARY KEY (`lease_id`),
  KEY `property_number` (`property_number`),
  CONSTRAINT `leaseagreement_ibfk_1` FOREIGN KEY (`property_number`) REFERENCES `rentalproperty` (`property_number`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaseagreement`
--

LOCK TABLES `leaseagreement` WRITE;
/*!40000 ALTER TABLE `leaseagreement` DISABLE KEYS */;
INSERT INTO `leaseagreement` VALUES (1,1,'John Doe','555-111-1111','555-222-2222','2022-01-01','2022-12-31',3000.00,2000.00),(2,2,'Emily Johnson','555-333-3333','555-444-4444','2022-02-01','2022-11-30',2000.00,1500.00),(3,3,'Emily Johnson','555-555-5555','555-666-6666','2022-03-01','2022-10-31',3500.00,2500.00),(4,4,'Sophia Davis','555-777-7777','555-888-8888','2022-04-01','2022-09-30',2500.00,1800.00),(5,5,'William Wilson','555-999-9999','555-000-0000','2022-05-01','2022-08-31',3000.00,2200.00),(6,6,'Olivia Taylor','555-111-2222','555-333-4444','2022-06-01','2022-07-31',2000.00,1600.00),(7,7,'James Anderson','555-555-1234','555-555-6789','2022-07-01','2022-06-30',3500.00,2100.00),(8,8,'Ava Thomas','555-777-9999','555-999-1234','2022-08-01','2022-05-31',2500.00,1700.00),(9,9,'John Doe','555-111-4444','555-444-7777','2022-09-01','2022-04-30',3000.00,2400.00),(17,10,'John Doe','6693880982','6693880982','2023-06-01','2023-06-30',1000.00,725.00);
/*!40000 ALTER TABLE `leaseagreement` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-02 18:25:51
