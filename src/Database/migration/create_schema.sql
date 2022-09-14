CREATE DATABASE  IF NOT EXISTS `scandiweb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `scandiweb`;
-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: scandiweb
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.22.04.1

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
-- Table structure for table `ProductAttributes`
--

DROP TABLE IF EXISTS `ProductAttributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ProductAttributes` (
  `FK_ProductID` int unsigned NOT NULL,
  `FK_AttributeID` int unsigned NOT NULL,
  `AttributeValue` varchar(255) NOT NULL,
  PRIMARY KEY (`FK_AttributeID`,`FK_ProductID`),
  KEY `fk_ProductAttributes_1_idx` (`FK_ProductID`),
  KEY `fk_ProductAttributes_2_idx` (`FK_AttributeID`),
  CONSTRAINT `fk_ProductAttributes_1` FOREIGN KEY (`FK_ProductID`) REFERENCES `Products` (`PK_ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ProductAttributes_2` FOREIGN KEY (`FK_AttributeID`) REFERENCES `ProductTypeAttributes` (`PK_AttributeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Contains The Product Specific Attrs.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductAttributes`
--

LOCK TABLES `ProductAttributes` WRITE;
/*!40000 ALTER TABLE `ProductAttributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductAttributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductTypeAttributes`
--

DROP TABLE IF EXISTS `ProductTypeAttributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ProductTypeAttributes` (
  `PK_AttributeID` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key.',
  `AttributeName` varchar(255) NOT NULL COMMENT 'Name of The attribute such as size, weight, ... etc',
  `AttributeMeasureUnit` varchar(255) DEFAULT NULL COMMENT 'The Measurement unit of the attr if any, such as cm, kg, ...etc',
  `BackendDataType` varchar(8) NOT NULL COMMENT 'This specifies the data type of the product attribute value.\\nThere are many different types such as: datetime, date, time, int, float, long, double, varchar/string, boolean, etc.\\n\\nThere is no constraints here on the entry, so the application level should maintain what''s entered here for the data consistency!\\n\\nSince we are using EAV model, the back office system, the admin panel, or whatever code level that inserts here should be aware of the valid entry options to make sure data stay consistent and the integrity of data stays safe.\n\nIt could be modified/enhanced to be either ''Enum'', ''JSON'', or normalized to a new table! But we just got inspired by "Magento 2" implementation of such a case!\n\nOf course this would introduce new tables for each data type as the project evolves!!!',
  `FrontendInputType` varchar(50) NOT NULL COMMENT 'This sets how an attribute should be displayed on frontend. Whether it should be a text, a number,  color, url or a date etc...\nIn case of a dropdown/select, we will need to create 2 new tables for the attribute input type and its options!\n\nSame for backend_type column, it can be enhanced as Enum, Json, or normalized to different table. But this is suffiecient for now and to respect the YAGNI principal, that should work for now.',
  `FrontendLabel` varchar(255) NOT NULL COMMENT 'This is the label used in frontend when the attribute is displayed. Useful to avoid dependency on the attribute name as a label.',
  `IsRequired` tinyint NOT NULL COMMENT 'Weather is compulsory for user to fill up this value in the frontend, and pass it through to the backend to fill it up here.',
  `DefaultValue` varchar(255) DEFAULT NULL COMMENT 'Any default value of an attribute.',
  `Note` varchar(255) DEFAULT NULL COMMENT 'Any comments or notes for the developers!',
  `FK_ProductType` varchar(255) NOT NULL COMMENT 'References the product type Primary Key.',
  PRIMARY KEY (`PK_AttributeID`),
  UNIQUE KEY `PK_AttributeID_UNIQUE` (`PK_AttributeID`),
  UNIQUE KEY `AttributeName_UNIQUE` (`AttributeName`),
  KEY `fk_ProductTypeAttributes_1_idx` (`FK_ProductType`),
  CONSTRAINT `fk_ProductTypeAttributes_1` FOREIGN KEY (`FK_ProductType`) REFERENCES `ProductTypes` (`PK_ProductType`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='This General Purpose Generic table serves UI Form display, data validation, and help frontend devs provide users with some guidance/hints filling out add Product form.\n\nIt is easy for an insufficiently knowledgeable user to corrupt/introduce inconsistencies&errors in metadata. Therefore, access to metadata must be restricted. Using RDBMS for metadata simplifies the process of maintaining consistency during metadata creation&editing, by leveraging features such as transactions support. Also, if metadata is part of the same DB as data itself, this ensures that it''ll be backed up at least as frequently as data itself, so it can be recovered to a point in time.\n\nThe quality of annotation&documentation within metadata i.e. narrative/explanatory text in the descriptive columns of metadata, must be much higher, to facilitate understanding by various members of dev team. Ensuring metadata quality takes very high priority in the long-term management&maintenance of any design that uses an EAV component.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductTypeAttributes`
--

LOCK TABLES `ProductTypeAttributes` WRITE;
/*!40000 ALTER TABLE `ProductTypeAttributes` DISABLE KEYS */;
INSERT INTO `ProductTypeAttributes` (`PK_AttributeID`, `AttributeName`, `AttributeMeasureUnit`, `BackendDataType`, `FrontendInputType`, `FrontendLabel`, `IsRequired`, `DefaultValue`, `Note`, `FK_ProductType`) VALUES (1,'size','MB','float','number','Size',1,NULL,NULL,'DVD-disc'),(2,'weight','KG','float','number','Weight',1,NULL,NULL,'Book'),(3,'width','CM','float','number','Width',1,NULL,NULL,'Furniture'),(4,'height','CM','float','number','Height',1,NULL,NULL,'Furniture'),(5,'length','CM','float','number','Length',1,NULL,NULL,'Furniture');
/*!40000 ALTER TABLE `ProductTypeAttributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductTypes`
--

DROP TABLE IF EXISTS `ProductTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ProductTypes` (
  `PK_ProductType` varchar(255) NOT NULL COMMENT 'Maps to The Product Type and acts as a primary key. No need to Auto Increment Integer.\nThis would be better for other tables such as Products Table!',
  `Description` varchar(255) NOT NULL COMMENT 'Informative product attribute description to be displayed to the user for proper input!',
  `IsActive` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`PK_ProductType`),
  UNIQUE KEY `PK_ProductType_UNIQUE` (`PK_ProductType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='A Look up of All Possible Types of Products in The System.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductTypes`
--

LOCK TABLES `ProductTypes` WRITE;
/*!40000 ALTER TABLE `ProductTypes` DISABLE KEYS */;
INSERT INTO `ProductTypes` (`PK_ProductType`, `Description`, `IsActive`) VALUES ('Book','Please provide weight in KG!',1),('DVD-disc','Please provide size in MB!',1),('Furniture','Please provide dimensions in HxWxL format.',1),('Glasses','Please provide length in Centimeters!',0);
/*!40000 ALTER TABLE `ProductTypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Products` (
  `PK_ProductID` int unsigned NOT NULL AUTO_INCREMENT,
  `SKU` varchar(64) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Price` decimal(20,6) unsigned NOT NULL,
  `CurrencySymbol` varchar(20) DEFAULT '$',
  `FK_ProductType` varchar(255) NOT NULL,
  PRIMARY KEY (`PK_ProductID`),
  UNIQUE KEY `PK_ProductID_UNIQUE` (`PK_ProductID`),
  UNIQUE KEY `SKU_UNIQUE` (`SKU`),
  KEY `fk_Products_1_idx` (`FK_ProductType`),
  CONSTRAINT `fk_Products_1` FOREIGN KEY (`FK_ProductType`) REFERENCES `ProductTypes` (`PK_ProductType`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Products`
--

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;
/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-09  1:53:02