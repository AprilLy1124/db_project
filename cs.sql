-- MySQL dump 10.13  Distrib 5.7.22, for macos10.13 (x86_64)
--
-- Host: localhost    Database: cs
-- ------------------------------------------------------
-- Server version	5.7.22

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
-- Table structure for table `USER`
--

DROP TABLE IF EXISTS `USER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USER` (
  `Email` varchar(50) NOT NULL,
  `Username` char(50) NOT NULL,
  `Password` char(40) NOT NULL,
  `User_type` tinyint(4) NOT NULL,
  PRIMARY KEY (`Username`),
  UNIQUE KEY `PSK` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER`
--

LOCK TABLES `USER` WRITE;
/*!40000 ALTER TABLE `USER` DISABLE KEYS */;
INSERT INTO `USER` VALUES ('anthony.dinozzo@ncis.mil.gov','adinozzo','56d102aedbaecbad96020fbac6eb4956e63f6c7b',2),('zuckerburg@fb.com','admin1','87596a5c283863da839fd5b63ca69e5619b4f442',0),('michael@gmail.com','admin2','69746390a55d565d562d80cc9433bcb541205927',0),('yliu3074@gatech.edu','april','7e240de74fb1ed08fa08d38063f6a6a91462a815',1),('bobbilly@harvard.edu','billybob','265d375682055e4e30ca281dae8db03496b3cea6',2),('ceo@gatech.edu','ceo','25d669c792a98ad9895af320308d09bb472c84b5',0),('farmerJoe@gmail.com','farmowner','6a4918e198e609d5a065c9f4ccdf0ceab6efda3e',1),('gardenerSteve@hotmail.com','gardenowner','2a0f66ad17454ac73a2a639ba7887b3ac3bb43bd',1),('bill@yahoo.com','greenguy','14400de41171757e276d189a19d19118ccf8fa66',2),('flowerpower@gmail.com','iloveflowers','965bfc0e26835d9acfb749a15fc484f0f5b38cc8',2),('liuy2013@icloud.com','ly','7e240de74fb1ed08fa08d38063f6a6a91462a815',2),('orchardOwen@myspace.com','orchardowner','63c725c7a631555bd526cb97b0efef958c50fab3',1),('aaa@aaa.com','randompeople','7c222fb2927d828af22f592134e8932480637c0d',2),('yamada.riyo@navy.mil.gov','riyoy1996','242c4b01e7961b27ad64c0f91dbaf4f10941aca4',2);
/*!40000 ALTER TABLE `USER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `I_Name` varchar(50) NOT NULL,
  `IsApproved` tinyint(4) NOT NULL,
  `Item_Type` varchar(15) NOT NULL,
  PRIMARY KEY (`I_Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES ('Almond',1,'NUT'),('Apple',1,'FRUIT'),('Banana',1,'FRUIT'),('Broccoli',1,'VEGETABLE'),('Carrot',1,'VEGETABLE'),('Cashew',1,'NUT'),('Cheetah',1,'ANIMAL'),('Chicken',1,'ANIMAL'),('Corn',1,'VEGETABLE'),('Cow',1,'ANIMAL'),('Daffodil',1,'FLOWER'),('Daisy',1,'FLOWER'),('Dog',1,'ANIMAL'),('Eggplant',1,'VEGETABLE'),('Fig',0,'NUT'),('Garlic',1,'VEGETABLE'),('Goat',1,'ANIMAL'),('Kiwi',1,'FRUIT'),('Mongoose',0,'ANIMAL'),('Monkey',1,'ANIMAL'),('Onion',1,'VEGETABLE'),('Orange',1,'FRUIT'),('Peach',1,'FRUIT'),('Peanut',1,'NUT'),('Peas',1,'VEGETABLE'),('Peruvian Lily',1,'FLOWER'),('Pete',0,'ANIMAL'),('Pig',1,'ANIMAL'),('Pineapple',0,'FRUIT'),('Pineapple Sage',0,'FLOWER'),('Potato',0,'VEGETABLE'),('Rose',1,'FLOWER'),('Salami',0,'VEGETABLE'),('Sunflower',1,'FLOWER'),('Tomato',0,'FRUIT');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property` (
  `Name` varchar(50) NOT NULL,
  `ID` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `Size_Acres` decimal(10,2) NOT NULL,
  `St_Address` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `ZIP` char(5) NOT NULL,
  `IsPublic` tinyint(4) NOT NULL,
  `IsComm` tinyint(4) NOT NULL,
  `User_Name` varchar(50) NOT NULL,
  `Admin_Name` varchar(50) DEFAULT NULL,
  `Property_Type` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `PSK` (`Name`),
  KEY `UFK` (`User_Name`),
  KEY `UFKK` (`Admin_Name`),
  CONSTRAINT `UFK` FOREIGN KEY (`User_Name`) REFERENCES `USER` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `UFKK` FOREIGN KEY (`Admin_Name`) REFERENCES `USER` (`Username`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property`
--

LOCK TABLES `property` WRITE;
/*!40000 ALTER TABLE `property` DISABLE KEYS */;
INSERT INTO `property` VALUES ('Atwood Street Garden',00000,1.00,'Atwood Street SW','Atlanta','30308',1,0,'gardenowner','admin1','GARDEN'),('East Lake Urban Farm',00001,20.00,'2nd Avenue','Atlanta','30317',0,1,'farmowner','admin1','FARM'),('Georgia Tech Garden',00002,0.50,'Spring Street SW','Atlanta','30308',1,0,'orchardowner','admin2','GARDEN'),('Georgia Tech Orchard',00003,0.50,'Spring Street SW','Atlanta','30308',1,0,'orchardowner','admin1','ORCHARD'),('Woodstock Community Garden',00004,5.00,'1804 Bouldercrest Road','Woodstock','30188',1,0,'gardenowner',NULL,'GARDEN'),('Kenari Company Farm',00005,3.00,'100 Hightower Road','Roswell','30076',1,1,'farmowner','admin1','FARM'),('Some garden',00008,33.00,'what ever you like road','somecity','33333',1,1,'april',NULL,'GARDEN');
/*!40000 ALTER TABLE `property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_has_item`
--

DROP TABLE IF EXISTS `property_has_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_has_item` (
  `P_ID` int(5) unsigned zerofill NOT NULL,
  `I_Name` varchar(50) NOT NULL,
  PRIMARY KEY (`P_ID`,`I_Name`),
  KEY `PIFKK` (`I_Name`),
  CONSTRAINT `PIFK` FOREIGN KEY (`P_ID`) REFERENCES `PROPERTY` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PIFKK` FOREIGN KEY (`I_Name`) REFERENCES `ITEM` (`I_Name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_has_item`
--

LOCK TABLES `property_has_item` WRITE;
/*!40000 ALTER TABLE `property_has_item` DISABLE KEYS */;
INSERT INTO `property_has_item` VALUES (00003,'Almond'),(00003,'Apple'),(00000,'Broccoli'),(00005,'Broccoli'),(00004,'Carrot'),(00003,'Cashew'),(00005,'Cashew'),(00001,'Chicken'),(00005,'Chicken'),(00000,'Corn'),(00001,'Corn'),(00008,'Corn'),(00005,'Cow'),(00000,'Daisy'),(00008,'Daisy'),(00000,'Onion'),(00001,'Onion'),(00003,'Peanut'),(00002,'Peas'),(00002,'Peruvian Lily'),(00005,'Sunflower'),(00008,'Sunflower');
/*!40000 ALTER TABLE `property_has_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visit`
--

DROP TABLE IF EXISTS `visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visit` (
  `U_ID` varchar(50) NOT NULL,
  `P_ID` int(5) unsigned zerofill NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Rating` int(11) NOT NULL,
  PRIMARY KEY (`U_ID`,`P_ID`),
  KEY `VFKK` (`P_ID`),
  CONSTRAINT `VFK` FOREIGN KEY (`U_ID`) REFERENCES `USER` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `VFKK` FOREIGN KEY (`P_ID`) REFERENCES `PROPERTY` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit`
--

LOCK TABLES `visit` WRITE;
/*!40000 ALTER TABLE `visit` DISABLE KEYS */;
INSERT INTO `visit` VALUES ('billybob',00000,'2018-11-12 17:00:01',5),('billybob',00002,'2017-10-24 11:31:12',1),('billybob',00003,'2017-10-23 20:21:49',3),('greenguy',00000,'2018-03-03 16:12:10',2),('greenguy',00002,'2018-01-23 22:12:34',4),('greenguy',00005,'2018-01-03 00:21:10',2),('iloveflowers',00000,'2018-02-14 17:21:12',5),('randompeople',00000,'2018-04-27 09:10:22',4),('randompeople',00003,'2018-04-27 08:54:16',2),('randompeople',00005,'2018-04-27 08:07:37',5),('riyoy1996',00005,'2017-10-29 02:11:13',4);
/*!40000 ALTER TABLE `visit` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-27 23:33:18
