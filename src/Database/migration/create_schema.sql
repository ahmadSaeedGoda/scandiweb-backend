-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 27, 2022 at 12:56 PM
-- Server version: 10.5.16-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scandiweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ProductAttributes`
--

CREATE TABLE `ProductAttributes` (
  `FK_ProductID` int(10) UNSIGNED NOT NULL,
  `FK_AttributeID` int(10) UNSIGNED NOT NULL,
  `AttributeValue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Contains The Product Specific Attrs.';

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `PK_ProductID` int(10) UNSIGNED NOT NULL,
  `SKU` varchar(64) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Price` decimal(20,6) UNSIGNED NOT NULL,
  `CurrencySymbol` varchar(20) DEFAULT '$',
  `FK_ProductType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ProductTypeAttributes`
--

CREATE TABLE `ProductTypeAttributes` (
  `PK_AttributeID` int(10) UNSIGNED NOT NULL COMMENT 'Primary Key.',
  `AttributeName` varchar(255) NOT NULL COMMENT 'Name of The attribute such as size, weight, ... etc',
  `AttributeMeasureUnit` varchar(255) DEFAULT NULL COMMENT 'The Measurement unit of the attr if any, such as cm, kg, ...etc',
  `BackendDataType` varchar(8) NOT NULL COMMENT 'This specifies the data type of the product attribute value.\\nThere are many different types such as: datetime, date, time, int, float, long, double, varchar/string, boolean, etc.\\n\\nThere is no constraints here on the entry, so the application level should maintain what''s entered here for the data consistency!\\n\\nSince we are using EAV model, the back office system, the admin panel, or whatever code level that inserts here should be aware of the valid entry options to make sure data stay consistent and the integrity of data stays safe.\n\nIt could be modified/enhanced to be either ''Enum'', ''JSON'', or normalized to a new table! But we just got inspired by "Magento 2" implementation of such a case!\n\nOf course this would introduce new tables for each data type as the project evolves!!!',
  `FrontendInputType` varchar(50) NOT NULL COMMENT 'This sets how an attribute should be displayed on frontend. Whether it should be a text, a number,  color, url or a date etc...\nIn case of a dropdown/select, we will need to create 2 new tables for the attribute input type and its options!\n\nSame for backend_type column, it can be enhanced as Enum, Json, or normalized to different table. But this is suffiecient for now and to respect the YAGNI principal, that should work for now.',
  `FrontendLabel` varchar(255) NOT NULL COMMENT 'This is the label used in frontend when the attribute is displayed. Useful to avoid dependency on the attribute name as a label.',
  `IsRequired` tinyint(4) NOT NULL COMMENT 'Weather is compulsory for user to fill up this value in the frontend, and pass it through to the backend to fill it up here.',
  `DefaultValue` varchar(255) DEFAULT NULL COMMENT 'Any default value of an attribute.',
  `Note` varchar(255) DEFAULT NULL COMMENT 'Any comments or notes for the developers!',
  `FK_ProductType` varchar(255) NOT NULL COMMENT 'References the product type Primary Key.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='This General Purpose Generic table serves UI Form display, data validation, and help frontend devs provide users with some guidance/hints filling out add Product form.\n\nIt is easy for an insufficiently knowledgeable user to corrupt/introduce inconsistencies&errors in metadata. Therefore, access to metadata must be restricted. Using RDBMS for metadata simplifies the process of maintaining consistency during metadata creation&editing, by leveraging features such as transactions support. Also, if metadata is part of the same DB as data itself, this ensures that it''ll be backed up at least as frequently as data itself, so it can be recovered to a point in time.\n\nThe quality of annotation&documentation within metadata i.e. narrative/explanatory text in the descriptive columns of metadata, must be much higher, to facilitate understanding by various members of dev team. Ensuring metadata quality takes very high priority in the long-term management&maintenance of any design that uses an EAV component.';

--
-- Dumping data for table `ProductTypeAttributes`
--

INSERT INTO `ProductTypeAttributes` (`PK_AttributeID`, `AttributeName`, `AttributeMeasureUnit`, `BackendDataType`, `FrontendInputType`, `FrontendLabel`, `IsRequired`, `DefaultValue`, `Note`, `FK_ProductType`) VALUES
(1, 'size', 'MB', 'numeric', 'number', 'Size', 1, NULL, NULL, 'DVD'),
(2, 'weight', 'KG', 'numeric', 'number', 'Weight', 1, NULL, NULL, 'Book'),
(3, 'width', 'CM', 'numeric', 'number', 'Width', 1, NULL, NULL, 'Furniture'),
(4, 'height', 'CM', 'numeric', 'number', 'Height', 1, NULL, NULL, 'Furniture'),
(5, 'length', 'CM', 'numeric', 'number', 'Length', 1, NULL, NULL, 'Furniture');

-- --------------------------------------------------------

--
-- Table structure for table `ProductTypes`
--

CREATE TABLE `ProductTypes` (
  `PK_ProductType` varchar(255) NOT NULL COMMENT 'Maps to The Product Type and acts as a primary key. No need to Auto Increment Integer.\nThis would be better for other tables such as Products Table!',
  `Description` varchar(255) NOT NULL COMMENT 'Informative product attribute description to be displayed to the user for proper input!',
  `IsActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='A Look up of All Possible Types of Products in The System.';

--
-- Dumping data for table `ProductTypes`
--

INSERT INTO `ProductTypes` (`PK_ProductType`, `Description`, `IsActive`) VALUES
('Book', 'Please provide weight in KG!', 1),
('DVD', 'Please provide size in MB!', 1),
('Furniture', 'Please provide dimensions in HxWxL format.', 1),
('Glasses', 'Please provide length in Centimeters!', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ProductAttributes`
--
ALTER TABLE `ProductAttributes`
  ADD PRIMARY KEY (`FK_AttributeID`,`FK_ProductID`),
  ADD KEY `fk_ProductAttributes_1_idx` (`FK_ProductID`),
  ADD KEY `fk_ProductAttributes_2_idx` (`FK_AttributeID`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`PK_ProductID`),
  ADD UNIQUE KEY `PK_ProductID_UNIQUE` (`PK_ProductID`),
  ADD UNIQUE KEY `SKU_UNIQUE` (`SKU`),
  ADD KEY `fk_Products_1_idx` (`FK_ProductType`);

--
-- Indexes for table `ProductTypeAttributes`
--
ALTER TABLE `ProductTypeAttributes`
  ADD PRIMARY KEY (`PK_AttributeID`),
  ADD UNIQUE KEY `PK_AttributeID_UNIQUE` (`PK_AttributeID`),
  ADD UNIQUE KEY `AttributeName_UNIQUE` (`AttributeName`),
  ADD KEY `fk_ProductTypeAttributes_1_idx` (`FK_ProductType`);

--
-- Indexes for table `ProductTypes`
--
ALTER TABLE `ProductTypes`
  ADD PRIMARY KEY (`PK_ProductType`),
  ADD UNIQUE KEY `PK_ProductType_UNIQUE` (`PK_ProductType`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `PK_ProductID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProductTypeAttributes`
--
ALTER TABLE `ProductTypeAttributes`
  MODIFY `PK_AttributeID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key.', AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ProductAttributes`
--
ALTER TABLE `ProductAttributes`
  ADD CONSTRAINT `fk_ProductAttributes_1` FOREIGN KEY (`FK_ProductID`) REFERENCES `Products` (`PK_ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ProductAttributes_2` FOREIGN KEY (`FK_AttributeID`) REFERENCES `ProductTypeAttributes` (`PK_AttributeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `fk_Products_1` FOREIGN KEY (`FK_ProductType`) REFERENCES `ProductTypes` (`PK_ProductType`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ProductTypeAttributes`
--
ALTER TABLE `ProductTypeAttributes`
  ADD CONSTRAINT `fk_ProductTypeAttributes_1` FOREIGN KEY (`FK_ProductType`) REFERENCES `ProductTypes` (`PK_ProductType`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
