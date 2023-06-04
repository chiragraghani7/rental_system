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
-- Table structure for table `rentalproperty`
--

DROP TABLE IF EXISTS `rentalproperty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rentalproperty` (
  `property_number` int NOT NULL,
  `owner_id` int NOT NULL,
  `supervisor_id` int NOT NULL,
  `street` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `num_rooms` int NOT NULL,
  `monthly_rent` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `start_date` date DEFAULT NULL,
  `name` varchar(50) NOT NULL DEFAULT 'Avalon the Alameda',
  PRIMARY KEY (`property_number`),
  KEY `owner_id` (`owner_id`),
  KEY `supervisor_id` (`supervisor_id`),
  CONSTRAINT `rentalproperty_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `propertyowner` (`owner_id`),
  CONSTRAINT `rentalproperty_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `employee` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rentalproperty`
--

LOCK TABLES `rentalproperty` WRITE;
/*!40000 ALTER TABLE `rentalproperty` DISABLE KEYS */;
INSERT INTO `rentalproperty` VALUES (1,2,2,'1234 Elm Street','New York','10001',3,2200.00,'leased','2022-01-01','Avalon the Alameda'),(2,2,2,'5678 Oak Avenue','Los Angeles','90001',2,1500.00,'Rented','2022-02-01','Avalon the Alameda'),(3,3,3,'910 Pine Road','Los Angeles','60601',2,2500.00,'Rented','2022-03-01','Avalon the Alameda'),(4,4,4,'4567 Maple Drive','Houston','77001',2,1800.00,'Rented','2022-04-01','Avalon the Alameda'),(5,5,5,'7890 Cedar Lane','Miami','33101',3,2200.00,'Rented','2022-05-01','Avalon the Alameda'),(6,6,6,'2345 Birch Avenue','San Francisco','94101',2,1600.00,'Rented','2022-06-01','Avalon the Alameda'),(7,7,7,'9012 Willow Street','Seattle','98101',3,2100.00,'Rented','2022-07-01','Avalon the Alameda'),(8,8,8,'3456 Spruce Drive','Boston','02101',2,1700.00,'Rented','2022-08-01','Avalon the Alameda'),(9,2,2,'6789 Pine Road','Denver','80201',4,2400.00,'Rented','2022-09-01','Avalon the Alameda'),(10,10,10,'0123 Magnolia Lane','Atlanta','30301',3,1900.00,'Rented','2022-10-01','Avalon the Alameda'),(11,4,2,'123 Main St','Cityville','12345',3,1500.00,'Rented','2023-06-01','Avalon the Alameda');
/*!40000 ALTER TABLE `rentalproperty` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `check_supervisor_properties` BEFORE INSERT ON `rentalproperty` FOR EACH ROW BEGIN
    DECLARE property_count INT;
    
    SELECT COUNT(*) INTO property_count
    FROM RentalProperty
    WHERE supervisor_id = NEW.supervisor_id;
    
    IF property_count > 3 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'A supervisor cannot supervise more than three rental properties at a time.';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-03 19:43:51
