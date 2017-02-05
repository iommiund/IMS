-- MySQL dump 10.16  Distrib 10.1.16-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: ims
-- ------------------------------------------------------
-- Server version	10.1.16-MariaDB

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
-- Current Database: `ims`
--

/*!40000 DROP DATABASE IF EXISTS `ims`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ims` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ims`;

--
-- Table structure for table `customer_account_statuses`
--

DROP TABLE IF EXISTS `customer_account_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_account_statuses` (
  `customer_account_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_account_status` varchar(50) NOT NULL,
  PRIMARY KEY (`customer_account_status_id`),
  UNIQUE KEY `uq_customer_account_status` (`customer_account_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_account_statuses`
--

LOCK TABLES `customer_account_statuses` WRITE;
/*!40000 ALTER TABLE `customer_account_statuses` DISABLE KEYS */;
INSERT INTO `customer_account_statuses` VALUES (2,'Disabled'),(1,'Enabled');
/*!40000 ALTER TABLE `customer_account_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_accounts`
--

DROP TABLE IF EXISTS `customer_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_accounts` (
  `customer_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(50) NOT NULL,
  `customer_surname` varchar(50) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_dob` date NOT NULL,
  `nationality_id` int(11) NOT NULL,
  `customer_account_status_id` int(11) NOT NULL,
  PRIMARY KEY (`customer_account_id`),
  UNIQUE KEY `uq_customer_email` (`customer_email`),
  KEY `fk_nationality_id` (`nationality_id`),
  KEY `fk_customer_account_status_id` (`customer_account_status_id`),
  CONSTRAINT `fk_customer_account_status_id` FOREIGN KEY (`customer_account_status_id`) REFERENCES `customer_account_statuses` (`customer_account_status_id`),
  CONSTRAINT `fk_nationality_id` FOREIGN KEY (`nationality_id`) REFERENCES `nationalities` (`nationality_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_accounts`
--

LOCK TABLES `customer_accounts` WRITE;
/*!40000 ALTER TABLE `customer_accounts` DISABLE KEYS */;
INSERT INTO `customer_accounts` VALUES (1,'Veronica','Galea','VeronicaGalea@fakemailaddress.com','1976-01-01',106,1),(2,'Chantelle','Fenech','ChantelleFenech@fakemailaddress.com','1993-02-19',106,1),(3,'Maria','Sciberras','MariaSciberras@fakemailaddress.com','1946-12-12',106,1),(4,'Keith','Pace','KeithPace@fakemailaddress.com','1982-06-29',106,1),(5,'Charles','Spiteri','CharlesSpiteri@fakemailaddress.com','1984-05-04',106,1),(6,'Salvina','Vella','SalvinaVella@fakemailaddress.com','1947-08-15',106,2),(7,'Josmar','Said','JosmarSaid@fakemailaddress.com','1994-07-17',106,1),(8,'Daniel','Cordina','DanielCordina@fakemailaddress.com','1984-12-12',106,1),(9,'Johnathan','Vella','JohnathanVella@fakemailaddress.com','1986-01-01',106,1),(10,'Nicholas','Azzopardi','NicholasAzzopardi@fakemailaddress.com','1977-07-24',106,1),(11,'Lorianne','Fava','LorianneFava@fakemailaddress.com','1990-07-17',106,1),(12,'Lara','Delceppo','LaraDelceppo@fakemailaddress.com','2011-01-01',106,2),(13,'Carmel','Cutajar','CarmelCutajar@fakemailaddress.com','1958-01-01',106,1),(14,'Asia','Degabriele','AsiaDegabriele@fakemailaddress.com','1972-01-01',106,1),(15,'Filippa','Umbreen','FilippaUmbreen@fakemailaddress.com','1934-01-01',106,1),(16,'Peter','Abela','PeterAbela@fakemailaddress.com','1940-10-22',106,1),(17,'Anthony','Sinclair','AnthonySinclair@fakemailaddress.com','1962-05-16',106,1),(18,'Maria','Tanti','MariaTanti@fakemailaddress.com','1983-03-20',106,2),(19,'Pierre','Muscat','PierreMuscat@fakemailaddress.com','1970-10-28',106,1),(20,'Daniel','Teyssier','DanielTeyssier@fakemailaddress.com','1984-08-19',106,1),(21,'Heather','Attard','HeatherAttard@fakemailaddress.com','1981-01-01',106,1),(22,'Marlene','Cortis','MarleneCortis@fakemailaddress.com','1962-01-01',106,1),(23,'Antonia','Parnis','AntoniaParnis@fakemailaddress.com','1949-01-01',106,1),(24,'Jurgen','Cauchi','JurgenCauchi@fakemailaddress.com','1987-08-15',106,2),(25,'Shawn','Pavanello','ShawnPavanello@fakemailaddress.com','1982-01-01',106,1),(26,'James','Abela','JamesAbela@fakemailaddress.com','1983-10-06',106,1),(27,'Andy','Magro','AndyMagro@fakemailaddress.com','1970-04-20',106,1),(28,'Antonella','Brassel','AntonellaBrassel@fakemailaddress.com','1985-08-15',106,1),(29,'Adrian','Formosa','AdrianFormosa@fakemailaddress.com','1978-11-17',106,1),(30,'Anton','Zerafa','AntonZerafa@fakemailaddress.com','1991-12-12',106,2),(31,'Roslyn','Azzopardi','RoslynAzzopardi@fakemailaddress.com','1975-05-12',106,1),(32,'Anna','Ciantar','AnnaCiantar@fakemailaddress.com','1952-04-14',106,1),(33,'Mario','Borg','MarioBorg@fakemailaddress.com','1972-05-16',106,1),(34,'Lorraine','Ellul','LorraineEllul@fakemailaddress.com','1988-06-02',106,1),(35,'Marko','Muscat','MarkoMuscat@fakemailaddress.com','1990-09-19',106,1),(36,'Miriam','Stefanac','MiriamStefanac@fakemailaddress.com','1963-05-01',106,2),(37,'Melvin','Camilleri','MelvinCamilleri@fakemailaddress.com','1971-12-12',106,1),(38,'Matthew','Fenech','MatthewFenech@fakemailaddress.com','1990-09-19',106,1),(39,'Rosaria','Linskill','RosariaLinskill@fakemailaddress.com','1954-01-01',106,1),(40,'Michael','Allen','MichaelAllen@fakemailaddress.com','2011-01-01',106,1),(41,'Lindsey','Briffa','LindseyBriffa@fakemailaddress.com','1994-01-01',106,1),(42,'Redeemer','Grixti','RedeemerGrixti@fakemailaddress.com','1993-01-01',106,2),(43,'Gejtano','Farrugia','GejtanoFarrugia@fakemailaddress.com','2009-10-10',106,1),(44,'Jacqueline','Cutajar','JacquelineCutajar@fakemailaddress.com','1970-05-10',106,1),(45,'Gianluca','Deguara','GianlucaDeguara@fakemailaddress.com','1976-05-28',106,1),(46,'Christie','Scarponi','ChristieScarponi@fakemailaddress.com','1991-12-12',106,1),(47,'Theodor','Buhagiar','TheodorBuhagiar@fakemailaddress.com','1970-08-01',106,1),(48,'Agnes','Forberg','AgnesForberg@fakemailaddress.com','1960-09-20',106,2),(49,'Lee','Tabone','LeeTabone@fakemailaddress.com','1990-02-28',106,1),(50,'Rachelle','Sammut','RachelleSammut@fakemailaddress.com','1977-02-21',106,1),(51,'Helen','Borg','HelenBorg@fakemailaddress.com','1968-05-19',106,1),(52,'Sarah','Bezzina','SarahBezzina@fakemailaddress.com','1976-07-17',106,1),(53,'Mary','Cutajar','MaryCutajar@fakemailaddress.com','1950-08-01',106,1),(54,'David','Said','DavidSaid@fakemailaddress.com','1986-11-04',106,2),(55,'Samir','Grixti','SamirGrixti@fakemailaddress.com','1980-04-05',106,1),(56,'Zulfqur','Gehel','ZulfqurGehel@fakemailaddress.com','1971-09-07',106,1),(57,'Rudi','Ahmad','RudiAhmad@fakemailaddress.com','1985-12-13',106,1),(58,'Jason','Roles','JasonRoles@fakemailaddress.com','1972-01-01',106,1),(59,'Jason','Galea','JasonGalea@fakemailaddress.com','1972-11-12',106,1),(60,'Roberta','Cutajar','RobertaCutajar@fakemailaddress.com','1987-12-12',106,2),(61,'Yvette','Attard','YvetteAttard@fakemailaddress.com','1972-05-29',106,1),(62,'Thomas','Spiteri','ThomasSpiteri@fakemailaddress.com','1946-02-10',106,1),(63,'Melissa','Welch','MelissaWelch@fakemailaddress.com','1984-01-01',106,1),(64,'John','Xuereb','JohnXuereb@fakemailaddress.com','1947-05-19',106,1),(65,'Maria','Vella','MariaVella@fakemailaddress.com','1969-07-23',106,1),(66,'Miriam','Grech','MiriamGrech@fakemailaddress.com','1986-01-01',106,2),(67,'Emmanuel','Mula','EmmanuelMula@fakemailaddress.com','2029-01-01',106,1),(68,'Pascal','Delia','PascalDelia@fakemailaddress.com','1990-07-06',106,1),(69,'Alfred','Baettig','AlfredBaettig@fakemailaddress.com','1955-05-19',106,1),(70,'Rose','Scicluna','RoseScicluna@fakemailaddress.com','1946-10-06',106,1),(71,'Marius','Bartolo','MariusBartolo@fakemailaddress.com','1981-05-15',106,1),(72,'Matthew','Caruana','MatthewCaruana@fakemailaddress.com','1991-10-12',106,2),(73,'Adrian','Baldacchino','AdrianBaldacchino@fakemailaddress.com','1976-01-31',106,1),(74,'Gladys','Ellul','GladysEllul@fakemailaddress.com','1944-02-10',106,1),(75,'Antoine','Brownrigg','AntoineBrownrigg@fakemailaddress.com','1982-01-01',106,1),(76,'Ibrahim','Zahra','IbrahimZahra@fakemailaddress.com','1980-01-01',106,1),(77,'Charles','Hussein','CharlesHussein@fakemailaddress.com','1970-01-19',106,1),(78,'Mary','Falzon','MaryFalzon@fakemailaddress.com','1956-12-14',106,2),(79,'Alejandro','Azzopardi','AlejandroAzzopardi@fakemailaddress.com','1985-12-10',106,1),(80,'Alain','Morenas','AlainMorenas@fakemailaddress.com','1948-01-10',106,1),(81,'Richard','Salvary','RichardSalvary@fakemailaddress.com','1990-05-15',106,1),(82,'Christine','Bergmair','ChristineBergmair@fakemailaddress.com','1983-04-03',106,1),(83,'Louise','Harmer','LouiseHarmer@fakemailaddress.com','2012-02-01',106,1),(84,'Yakob','Micallef','YakobMicallef@fakemailaddress.com','1981-01-01',106,2),(85,'Michael','Tonna','MichaelTonna@fakemailaddress.com','1951-01-12',106,1),(86,'Maria','Hartland','MariaHartland@fakemailaddress.com','1961-01-01',106,1),(87,'Sylvana','Vella','SylvanaVella@fakemailaddress.com','1964-12-12',106,1),(88,'Maria','Fiteni','MariaFiteni@fakemailaddress.com','1983-01-01',106,1),(89,'Doris','Farrugia','DorisFarrugia@fakemailaddress.com','1973-03-24',106,1),(90,'Anthony','Borg','AnthonyBorg@fakemailaddress.com','1943-05-16',106,2),(91,'Michael','Rizzo','MichaelRizzo@fakemailaddress.com','1993-07-17',106,1),(92,'Lorenza','Hinchy','LorenzaHinchy@fakemailaddress.com','1952-02-03',106,1),(93,'Istvan','Cooper','IstvanCooper@fakemailaddress.com','1987-12-12',106,1),(94,'Cirinna','Polgar','CirinnaPolgar@fakemailaddress.com','1975-05-16',106,1),(95,'Margaret','Corradino','MargaretCorradino@fakemailaddress.com','1969-01-01',106,1),(96,'Neil','Saliba','NeilSaliba@fakemailaddress.com','1988-05-19',106,2),(97,'Oleksandr','Muscat','OleksandrMuscat@fakemailaddress.com','1981-03-13',106,1),(98,'Stephanie','Ilchuk','StephanieIlchuk@fakemailaddress.com','1995-01-04',106,1),(99,'Jurgen','Cordina','JurgenCordina@fakemailaddress.com','1975-05-19',106,1),(100,'Markus','Calleja','MarkusCalleja@fakemailaddress.com','1970-10-28',106,1),(104,'Jason','Barbara','JasonBarbara@fakemailaddress.com','1987-10-22',106,1);
/*!40000 ALTER TABLE `customer_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nationalities`
--

DROP TABLE IF EXISTS `nationalities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nationalities` (
  `nationality_id` int(11) NOT NULL AUTO_INCREMENT,
  `nationality` varchar(50) NOT NULL,
  PRIMARY KEY (`nationality_id`),
  UNIQUE KEY `uq_nationality` (`nationality`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nationalities`
--

LOCK TABLES `nationalities` WRITE;
/*!40000 ALTER TABLE `nationalities` DISABLE KEYS */;
INSERT INTO `nationalities` VALUES (1,'Afghanistan'),(2,'Albania'),(3,'Algeria'),(4,'Andorra'),(5,'Angola'),(6,'Antigua and Barbuda'),(7,'Argentina'),(8,'Armenia'),(9,'Australia'),(10,'Austria'),(11,'Azerbaijan'),(12,'Bahamas'),(13,'Bahrain'),(14,'Bangladesh'),(15,'Barbados'),(16,'Belarus'),(17,'Belgium'),(18,'Belize'),(19,'Benin'),(20,'Bhutan'),(21,'Bolivia'),(22,'Bosnia and Herzegovina'),(23,'Botswana'),(24,'Brazil'),(25,'Brunei Darussalam'),(26,'Bulgaria'),(27,'Burkina Faso'),(28,'Burundi'),(29,'Cabo Verde'),(30,'Cambodia'),(31,'Cameroon'),(32,'Canada'),(33,'Central African Republic'),(34,'Chad'),(35,'Chile'),(36,'China'),(37,'Colombia'),(38,'Comoros'),(39,'Cong'),(40,'Congo'),(41,'Costa Rica'),(43,'Croatia'),(44,'Cuba'),(45,'Cyprus'),(46,'Czech Republic'),(47,'Denmark'),(48,'Djibouti'),(49,'Dominica'),(50,'Dominican Republic'),(51,'Ecuador'),(52,'Egypt'),(53,'El Salvador'),(54,'Equatorial Guinea'),(55,'Eritrea'),(56,'Estonia'),(57,'Ethiopia'),(58,'Fiji'),(59,'Finland'),(60,'France'),(61,'Gabon'),(62,'Gambia'),(63,'Georgia'),(64,'Germany'),(65,'Ghana'),(66,'Greece'),(67,'Grenada'),(68,'Guatemala'),(69,'Guinea'),(70,'Guinea-Bissau'),(71,'Guyana'),(72,'Haiti'),(73,'Honduras'),(74,'Hungary'),(75,'Iceland'),(76,'India'),(77,'Indonesia'),(78,'Iran'),(79,'Iraq'),(80,'Ireland'),(81,'Israel'),(82,'Italy'),(42,'Ivory Coast'),(83,'Jamaica'),(84,'Japan'),(85,'Jordan'),(86,'Kazakhstan'),(87,'Kenya'),(88,'Kiribati'),(89,'Kuwait'),(90,'Kyrgyzstan'),(91,'Laos'),(92,'Latvia'),(93,'Lebanon'),(94,'Lesotho'),(95,'Liberia'),(96,'Libya'),(97,'Liechtenstein'),(98,'Lithuania'),(99,'Luxembourg'),(100,'Macedonia'),(101,'Madagascar'),(102,'Malawi'),(103,'Malaysia'),(104,'Maldives'),(105,'Mali'),(106,'Malta'),(107,'Marshall Islands'),(108,'Mauritania'),(109,'Mauritius'),(110,'Mexico'),(111,'Micronesia'),(112,'Monaco'),(113,'Mongolia'),(114,'Montenegro'),(115,'Morocco'),(116,'Mozambique'),(117,'Myanmar'),(118,'Namibia'),(119,'Nauru'),(120,'Nepal'),(121,'Netherlands'),(122,'New Zealand'),(123,'Nicaragua'),(124,'Niger'),(125,'Nigeria'),(126,'North Korea'),(127,'Norway'),(128,'Oman'),(129,'Pakistan'),(130,'Palau'),(131,'Panama'),(132,'Papua New Guinea'),(133,'Paraguay'),(134,'Peru'),(135,'Philippines'),(136,'Poland'),(137,'Portugal'),(138,'Qatar'),(139,'Republic of Moldova'),(140,'Romania'),(141,'Russian Federation'),(142,'Rwanda'),(143,'Saint Kitts and Nevis'),(144,'Saint Lucia'),(145,'Saint Vincent and the Grenadines'),(146,'Samoa'),(147,'San Marino'),(148,'Sao Tome and Principe'),(149,'Saudi Arabia'),(150,'Senegal'),(151,'Serbia'),(152,'Seychelles'),(153,'Sierra Leone'),(154,'Singapore'),(155,'Slovakia'),(156,'Slovenia'),(157,'Solomon Islands'),(158,'Somalia'),(159,'South Africa'),(160,'South Korea'),(161,'South Sudan'),(162,'Spain'),(163,'Sri Lanka'),(164,'Sudan'),(165,'Suriname'),(166,'Swaziland'),(167,'Sweden'),(168,'Switzerland'),(169,'Syrian Arab Republic'),(170,'Tajikistan'),(171,'Tanzania'),(172,'Thailand'),(173,'Timor-Leste'),(174,'Togo'),(175,'Tonga'),(176,'Trinidad and Tobago'),(177,'Tunisia'),(178,'Turkey'),(179,'Turkmenistan'),(180,'Tuvalu'),(181,'UAE'),(182,'Uganda'),(183,'UK'),(184,'Ukraine'),(185,'Uruguay'),(186,'USA'),(187,'Uzbekistan'),(188,'Vanuatu'),(189,'Venezuela'),(190,'Vietnam'),(191,'Yemen'),(192,'Zambia'),(193,'Zimbabwe');
/*!40000 ALTER TABLE `nationalities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resouce_model_identifiers`
--

DROP TABLE IF EXISTS `resouce_model_identifiers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resouce_model_identifiers` (
  `resource_model_identifier_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_model_identifier` varchar(50) NOT NULL,
  `resource_model_id` int(11) NOT NULL,
  `resource_sn_length` int(11) NOT NULL,
  `voucher_value_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`resource_model_identifier_id`),
  UNIQUE KEY `uq_resource_model_identifier` (`resource_model_identifier`),
  KEY `fk_resource_model_id2` (`resource_model_id`),
  KEY `fk_voucher_value_id_idx` (`voucher_value_id`),
  CONSTRAINT `fk_resource_model_id2` FOREIGN KEY (`resource_model_id`) REFERENCES `resource_models` (`resource_model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resouce_model_identifiers`
--

LOCK TABLES `resouce_model_identifiers` WRITE;
/*!40000 ALTER TABLE `resouce_model_identifiers` DISABLE KEYS */;
INSERT INTO `resouce_model_identifiers` VALUES (1,'385729',6,14,NULL),(2,'395729',7,14,NULL),(3,'357350',5,14,NULL),(4,'24767D',1,12,NULL),(5,'7CB21B',1,12,NULL),(6,'BCC810',1,12,NULL),(7,'E448C7',1,12,NULL),(8,'895376',3,12,NULL),(9,'109868',2,12,NULL),(10,'505000',4,12,5),(11,'510000',4,12,10),(12,'520000',4,12,20),(13,'550000',4,12,50);
/*!40000 ALTER TABLE `resouce_model_identifiers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_brands`
--

DROP TABLE IF EXISTS `resource_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_brands` (
  `resource_brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_brand` varchar(50) NOT NULL,
  PRIMARY KEY (`resource_brand_id`),
  UNIQUE KEY `uq_resource_brand` (`resource_brand`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_brands`
--

LOCK TABLES `resource_brands` WRITE;
/*!40000 ALTER TABLE `resource_brands` DISABLE KEYS */;
INSERT INTO `resource_brands` VALUES (4,'Apple'),(1,'Cisco'),(5,'FutureCards'),(6,'Gemalto SIM'),(2,'Nagra'),(3,'Samsung');
/*!40000 ALTER TABLE `resource_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_location_types`
--

DROP TABLE IF EXISTS `resource_location_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_location_types` (
  `resource_location_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_location_type` varchar(50) NOT NULL,
  PRIMARY KEY (`resource_location_type_id`),
  UNIQUE KEY `uq_resource_location_type` (`resource_location_type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_location_types`
--

LOCK TABLES `resource_location_types` WRITE;
/*!40000 ALTER TABLE `resource_location_types` DISABLE KEYS */;
INSERT INTO `resource_location_types` VALUES (3,'Customer'),(2,'Field Technician'),(4,'Mobile Location'),(1,'Physical Location');
/*!40000 ALTER TABLE `resource_location_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_locations`
--

DROP TABLE IF EXISTS `resource_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_locations` (
  `resource_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_location_name` varchar(50) NOT NULL,
  `resource_location_description` varchar(200) NOT NULL,
  `resource_location_type_id` int(11) NOT NULL,
  PRIMARY KEY (`resource_location_id`),
  UNIQUE KEY `uq_resource_location_name` (`resource_location_name`),
  UNIQUE KEY `uq_resource_location_description` (`resource_location_description`),
  KEY `fk_resource_location_type_id` (`resource_location_type_id`),
  CONSTRAINT `fk_resource_location_type_id` FOREIGN KEY (`resource_location_type_id`) REFERENCES `resource_location_types` (`resource_location_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_locations`
--

LOCK TABLES `resource_locations` WRITE;
/*!40000 ALTER TABLE `resource_locations` DISABLE KEYS */;
INSERT INTO `resource_locations` VALUES (1,'Main Warehouse','Company main warehouse where resource is delivered from vendor',1),(2,'Paola Branch','Company branch in Paola, Malta',1),(3,'Valletta Branch','Company branch in Valletta, Malta',1),(4,'Naxxar Branch','Company branch in Naxxar, Malta',1),(5,'Service Technician','Company Service Technician, is assigned inventory to replace customer premises equipment',2),(6,'Installation Technician','Company Installation Technician, is assigned inventory to install as customer premises equipment',2),(7,'Customer','Customer is assigned inventory as customer premises equipment',3),(11,'Mobile Unit','Company mobile unit used in events',4);
/*!40000 ALTER TABLE `resource_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_models`
--

DROP TABLE IF EXISTS `resource_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_models` (
  `resource_model_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_brand_id` int(11) NOT NULL,
  `resource_type_id` int(11) NOT NULL,
  `resource_model` varchar(50) NOT NULL,
  PRIMARY KEY (`resource_model_id`),
  UNIQUE KEY `uq_resource_model` (`resource_model`),
  KEY `fk_resource_brand_id` (`resource_brand_id`),
  KEY `fk_resource_type_id_idx` (`resource_type_id`),
  CONSTRAINT `fk_resource_brand_id` FOREIGN KEY (`resource_brand_id`) REFERENCES `resource_brands` (`resource_brand_id`),
  CONSTRAINT `fk_resource_type_id` FOREIGN KEY (`resource_type_id`) REFERENCES `resource_types` (`resource_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_models`
--

LOCK TABLES `resource_models` WRITE;
/*!40000 ALTER TABLE `resource_models` DISABLE KEYS */;
INSERT INTO `resource_models` VALUES (1,1,5,'EPC3925'),(2,2,1,'NV'),(3,6,3,'SIM128K'),(4,5,4,'TUV'),(5,3,2,'Galaxy S7'),(6,4,2,'iPhone 6S 16GB'),(7,4,2,'iPhone 7 Plus'),(9,1,5,'EPC3925s'),(10,2,1,'HSC 100');
/*!40000 ALTER TABLE `resource_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_statuses`
--

DROP TABLE IF EXISTS `resource_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_statuses` (
  `resource_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_status` varchar(50) NOT NULL,
  PRIMARY KEY (`resource_status_id`),
  UNIQUE KEY `uq_resource_status` (`resource_status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_statuses`
--

LOCK TABLES `resource_statuses` WRITE;
/*!40000 ALTER TABLE `resource_statuses` DISABLE KEYS */;
INSERT INTO `resource_statuses` VALUES (2,'Allocated'),(1,'Available'),(6,'Destroyed'),(5,'In Repair'),(3,'Reserved'),(4,'Sold');
/*!40000 ALTER TABLE `resource_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_types`
--

DROP TABLE IF EXISTS `resource_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_types` (
  `resource_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_type` varchar(50) NOT NULL,
  PRIMARY KEY (`resource_type_id`),
  UNIQUE KEY `uq_resource_type` (`resource_type`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_types`
--

LOCK TABLES `resource_types` WRITE;
/*!40000 ALTER TABLE `resource_types` DISABLE KEYS */;
INSERT INTO `resource_types` VALUES (5,'Internet and VoIP Modem'),(2,'Mobile Handset'),(4,'Mobile Prepaid Top-Up Voucher'),(3,'Mobile Sim Card'),(1,'TV Set-Top Box');
/*!40000 ALTER TABLE `resource_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_status_id` int(11) NOT NULL,
  `resource_type_id` int(11) NOT NULL,
  `resource_location_id` int(11) NOT NULL,
  `customer_account_id` int(11) DEFAULT NULL,
  `resource_unique_value` varchar(50) NOT NULL,
  `resource_model_id` int(11) NOT NULL,
  `voucher_value_id` int(11) DEFAULT NULL,
  `last_transaction_id` int(11) DEFAULT NULL,
  `resource_latitude` float(10,6) DEFAULT NULL,
  `resource_longitude` float(10,6) DEFAULT NULL,
  PRIMARY KEY (`resource_id`),
  KEY `fk_resource_status_id` (`resource_status_id`),
  KEY `fk_resource_type_id` (`resource_type_id`),
  KEY `fk_resource_location_id` (`resource_location_id`),
  KEY `fk_customer_account_id` (`customer_account_id`),
  KEY `fk_resource_model_id` (`resource_model_id`),
  KEY `fk_voucher_value_id` (`voucher_value_id`),
  KEY `fk_last_transaction_id` (`last_transaction_id`),
  CONSTRAINT `fk_customer_account_id` FOREIGN KEY (`customer_account_id`) REFERENCES `customer_accounts` (`customer_account_id`),
  CONSTRAINT `fk_last_transaction_id` FOREIGN KEY (`last_transaction_id`) REFERENCES `transactions` (`transaction_id`),
  CONSTRAINT `fk_resource_location_id` FOREIGN KEY (`resource_location_id`) REFERENCES `resource_locations` (`resource_location_id`),
  CONSTRAINT `fk_resource_model_id` FOREIGN KEY (`resource_model_id`) REFERENCES `resource_models` (`resource_model_id`),
  CONSTRAINT `fk_resource_status_id` FOREIGN KEY (`resource_status_id`) REFERENCES `resource_statuses` (`resource_status_id`),
  CONSTRAINT `fk_voucher_value_id` FOREIGN KEY (`voucher_value_id`) REFERENCES `voucher_values` (`voucher_value_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resources`
--

LOCK TABLES `resources` WRITE;
/*!40000 ALTER TABLE `resources` DISABLE KEYS */;
INSERT INTO `resources` VALUES (4,1,5,1,NULL,'24767D000001',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `resources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_resource`
--

DROP TABLE IF EXISTS `temp_resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_resource` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_unique_value` varchar(50) NOT NULL,
  `resource_brand_id` int(11) DEFAULT NULL,
  `resource_model_id` int(11) DEFAULT NULL,
  `resource_type_id` int(11) DEFAULT NULL,
  `resource_model_identifier` varchar(45) DEFAULT NULL,
  `current_sn_length` int(11) DEFAULT NULL,
  `req_sn_length` int(11) DEFAULT NULL,
  `exists_flag` int(11) DEFAULT NULL,
  `voucher_value_id` varchar(4) DEFAULT NULL,
  `vr_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`resource_id`),
  UNIQUE KEY `resource_unique_value_UNIQUE` (`resource_unique_value`),
  KEY `fk_vr_id` (`vr_id`),
  CONSTRAINT `fk_vr_id` FOREIGN KEY (`vr_id`) REFERENCES `validation_results` (`vr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_resource`
--

LOCK TABLES `temp_resource` WRITE;
/*!40000 ALTER TABLE `temp_resource` DISABLE KEYS */;
INSERT INTO `temp_resource` VALUES (117,'24767D000001',1,1,5,'24767D',12,12,1,'',2),(118,'505000000001',5,4,4,'505000',12,12,0,'5',1),(119,'24767D000002',1,1,5,'24767D',12,12,0,'',1),(120,'24767D000003',1,1,5,'24767D',12,12,0,'',1),(121,'24767D000004',1,1,5,'24767D',12,12,0,'',1),(122,'24767D000005',1,1,5,'24767D',12,12,0,'',1),(123,'24767D000006',1,1,5,'24767D',12,12,0,'',1),(124,'24767D000007',1,1,5,'24767D',12,12,0,'',1),(125,'24767D000008',1,1,5,'24767D',12,12,0,'',1),(126,'24767D000009',1,1,5,'24767D',12,12,0,'',1),(127,'24767D000010',1,1,5,'24767D',12,12,0,'',1),(128,'24767D000011',1,1,5,'24767D',12,12,0,'',1),(129,'24767D000012',1,1,5,'24767D',12,12,0,'',1),(130,'24767D000013',1,1,5,'24767D',12,12,0,'',1),(131,'24767D000014',1,1,5,'24767D',12,12,0,'',1),(132,'24767D000015',1,1,5,'24767D',12,12,0,'',1),(133,'24767D000016',1,1,5,'24767D',12,12,0,'',1);
/*!40000 ALTER TABLE `temp_resource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_statuses`
--

DROP TABLE IF EXISTS `transaction_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_statuses` (
  `transaction_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`transaction_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_statuses`
--

LOCK TABLES `transaction_statuses` WRITE;
/*!40000 ALTER TABLE `transaction_statuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_types`
--

DROP TABLE IF EXISTS `transaction_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_types` (
  `transaction_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`transaction_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_types`
--

LOCK TABLES `transaction_types` WRITE;
/*!40000 ALTER TABLE `transaction_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `resource_status_id` int(11) NOT NULL,
  `resource_location_id` int(11) NOT NULL,
  `customer_account_id` int(11) DEFAULT NULL,
  `initiation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transaction_type_id` int(11) NOT NULL,
  `transaction_status_id` int(11) NOT NULL,
  `closing_uid` int(11) DEFAULT NULL,
  `closing_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `resource_latitude` float(10,6) DEFAULT NULL,
  `resource_longitude` float(10,6) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `fk_uid_tr` (`uid`),
  KEY `fk_resource_id_tr` (`resource_id`),
  KEY `fk_transaction_type_id` (`transaction_type_id`),
  KEY `fk_transaction_status_id` (`transaction_status_id`),
  CONSTRAINT `fk_resource_id_tr` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`),
  CONSTRAINT `fk_transaction_status_id` FOREIGN KEY (`transaction_status_id`) REFERENCES `transaction_statuses` (`transaction_status_id`),
  CONSTRAINT `fk_transaction_type_id` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_types` (`transaction_type_id`),
  CONSTRAINT `fk_uid_tr` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_statuses`
--

DROP TABLE IF EXISTS `user_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_statuses` (
  `user_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_status` varchar(50) NOT NULL,
  PRIMARY KEY (`user_status_id`),
  UNIQUE KEY `uq_user_status` (`user_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_statuses`
--

LOCK TABLES `user_statuses` WRITE;
/*!40000 ALTER TABLE `user_statuses` DISABLE KEYS */;
INSERT INTO `user_statuses` VALUES (2,'Disabled'),(1,'Enabled');
/*!40000 ALTER TABLE `user_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_types` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(50) NOT NULL,
  `user_permissions` tinytext,
  PRIMARY KEY (`user_type_id`),
  UNIQUE KEY `uq_user_type` (`user_type`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` VALUES (1,'Admin','{\"access\": 1, \"admin\": 1, \"changeUserStatus\":1, \"changeUserType\":1, \"addUser\":1, \"addLocation\":1, \"addLocationType\":1, \"changeLocationType\":1, \"addResourceType\":1, \"addResourceStatus\":1, \"addResourceModel\":1, \"addResourceBrand\":1}'),(2,'Location Manager','{\"access\":1, \"stockLevels\":1, \"search\":1, \"viewResource\":1, \"viewResourceHistory\":1, \"transferResourceLocation\":1, \"viewCustomer\":1, \"viewPendingTransfers\":1, \"acceptTransfer\":1, \"rejectTransfer\":1}'),(3,'POS User','{\"access\":1, \"search\":1, \"viewResource\":1, \"sellResource\":1, \"viewResourceHistory\":1, \"newCustomer\":1, \"updateCustomerStatus\":1, \"viewCustomer\":1, \"installResource\":1, \"replaceResource\":1}'),(4,'Field User','{\"access\":1, \"search\":1, \"viewResource\":1, \"viewResourceHistory\":1, \"viewCustomer\":1}'),(6,'Warehouse User','{\"access\":1, \"stockLevels\":1, \"newInventory\":1, \"search\":1, \"viewResource\":1, \"viewResourceHistory\":1, \"transferResourceLocation\":1, \"viewCustomer\":1, \"viewPendingTransfers\":1, \"acceptTransfer\":1, \"rejectTransfer\":1}'),(7,'Reporting User','{\"access\":1, \"reports\":1}'),(8,'Super User','{\r \"allAccess\": 1}'),(9,'Disabled','{\"disabled\":1}');
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `user_status_id` int(11) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uq_email` (`email`),
  UNIQUE KEY `uq_username` (`username`),
  KEY `fk_user_type_id` (`user_type_id`),
  KEY `fk_user_status_id` (`user_status_id`),
  CONSTRAINT `fk_user_status_id` FOREIGN KEY (`user_status_id`) REFERENCES `user_statuses` (`user_status_id`),
  CONSTRAINT `fk_user_type_id` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Iommi','Underwood','iommi@fakecompany.com','iommi','73accacc88e0b33165ad6dce68bf0833ac62270cb7c7097ba8f95aa5b3fe3906','|þ!BØjhµK°$Ìã¢qOiÎe•,vÃü!>',8,1),(2,'Russell','Camilleri','rcamm@fakecompany.com','rcamm','1e456859b29138592fe7838205d0d868c762f5561242b1be3d9c4f4db950e9af','›O¼‹”Ì{±PÓW0soe€¬þ¾(i ÞÜâÚÞ ',3,1),(3,'James','Cassar','jcass@fakecompany.com','jcass','d807c992883215878f737e8d8d666b4d7a0137799ce710f0c253a44a8a14eecd','sÝx>Ê¥Õ‹µ\"vVòy 8BQ˜i¬É]±ýlî',9,2),(4,'Kyle','Zammit','kzamm@fakecompany.com','kzamm','779080ec01c45c77b6db3a20643b866ea857736394647531bc502d2d9b16c46e','Ž›/]˜‡)dWãÆ\0Dÿº0‰/#ýIky‹8ðP',9,2),(5,'Danijel','Cajic','dcaji@fakecompany.com','dcaji','54877fc579b2809e8ccf43209b11336365466735543692391d06842e0c8da6ec','þ‚#GóŠ¬ÆÅ«RtmÍÑG“.U/¿T~Ó',9,2),(6,'Michael','Fava','mfava@fakecompany.com','mfava','471e85d24320350bf4225774d70782ea4c99de19300a8098c265758bba5f1481','^È7xdHì—|\"ò¤RÊË\"»Ù%òÃQ2ÁÞ‡Üh',9,2),(7,'Darren','Gatt','dgatt@fakecompany.com','dgatt','cba05a614c6b6389e6e2126df3029c73bd2a44ec6d98752f6af458bea8a0a876','æu¦ö6³5œü ähâªè5¿4: éÃìFí%,&',9,2),(8,'Ryan','Cassar','rcass@fakecompany.com','rcass','0b2297d43746206ec5c94b3d93937df0d9ef43060efda243b5bce064d0cd4584','Më/-!›Æí¯¯„˜ÂeÝf0=¨€Êùç¾Hgq|ÿ',9,2),(9,'Ryan','Scicluna','rscic@fakecompany.com','rscic','2a335b3614317a5c74ac1f23b7ea5e20dd785367106fed2e0135e1d3638cbe6a',',ºHrÅ£8¾a:\r8_9óv(ø¢-S2qÀ×ë¹ê»x',9,2),(10,'Luke','Camilleri','lcami@fakecompany.com','lcami','17d7e11a3b940803bfb11afd479f42dad4605bda3a631ba69fb734aefb121578',':éu}Ï>Q„þNJÌe5æ+Û!¡Ï·;YmY9°Rä',9,2),(11,'Clayton','Farrugia','cfarr@fakecompany.com','cfarr','ba75d0c73bd4cd6067e3ac6b03dbe3ef9737a5a83f47567ffa48fb1763ab4e54','¨+Â¥BåR$Q¼6óîGÜBcu\"\n}À5‚r@ú',9,2),(12,'Stephen','Ciantar','scian@fakecompany.com','scian','6221a0886ed4df87918ba07d9f4f22da54ed99ccd1ab1a0d1d18e7efc23d0711','h\ræ/ámÄ©Iêk$Œ{‹¬ä^çodô¹c×Ã-[Ý',9,2),(13,'Jake','Borg','jborg@fakecompany.com','jborg','327b5b990468ea6f6388241196d363944b7da7af3683e743f01bfb3935efb7f2','ˆ}¯vœ–f/ÓHbÅ\0™Ç5Å‹ØvZl<¸ZâÁwƒ',9,2),(14,'Emanuel','Mallia','emall@fakecompany.com','emall','c33b4fc486e6bf8c84bf02d1c3fbe9a86b91029b0a75f8be942ef9a9273461db','q§ÉË±£R¶é\"&<é–ZŽ›Š«Ý ño€M¯ê9(',9,2),(15,'Melvin','Pace','pacem@fakecompany.com','pacem','14fbac87489d0f1b84328ebb66f38d9f375ffc9d41ecb2612181299ec2f57114','ù¯ìžgûíÖ-Ù§îïÜ3±V–Š‚½çCÓv',9,2),(18,'Kevin','Abela','kabela@fakecompany.com','kabela','bfc5ddf7b4711a73bce041696c7591132fff8a0e8ada95b6e0cc35389e81e855','‡yXïãÕQÝ|\'üœTÍNÎÈë%w®–@–bááÍ',9,2),(19,'Julian','Falzon','jfalz@fakecompany.com','jfalz','30c50b5aa6da5147860fcfcdf9dd94482015e97a26dc06442c0d2e202c7b4c31','2û–ƒþà	§¿\0X…Ú\\ëR+œA¯É¦úTáM¡žÇŸ',9,2),(20,'Peter','Borg','pborg@fakecompany.com','pborg','e641a7b0f3ff5e62f304166beffe82624428a1a92fbc80f4eb22d3f4650c7613','1J,Úî™íHµ¯¼f¤¸NMÒ-æÀWð¼ÿá€',9,2),(21,'Joseph','Muscat','jmusc@fakecompany.com','jmusc','916976d67011786628fa61a392bdea8bbd1a6842a6133bd968c5fc242be66288',';™çgÇk“ndÉÃÇÚäï¿c!Ä_’+¿Ï[›Æ¥2›',9,2),(22,'System','Administrator','admin@fakecompany.com','admin','24ef5b3a9af9ee611fc2dabfecc924aaf0c2c0d1f02ede12cd2d8c4f714c84be','Ç†ï}W7/ÄAÃûDª¥´©Þ!ÆVÿÿ×€ùvÏ7V—',1,1),(23,'Location','Manager','locationmanager@fakecompany.com','locmng','1a588468655e64b89116a3e3b03b0cd90e242bbc68be242986dfde3ff159ddc1','N?{É*ÀÒ¯Q»#vhÉÐölrëQ Ã$Ë6“',2,1),(24,'POS','User','posuser@fakecompany.com','posuser','543b9097f7df0ac1e208f7f335171e2c067fa15d1c43c2ccf35e624733c00aa0','\rÕx–úÖ…ÜÅxzÕ ›ÞTCŸk¬Zªébƒå\0ØÙÖ',3,1),(25,'Field','User','fielduser@fakecompany.com','fielduser','86841a94f2cada64f8231e1b8bcec4978a1d4a49e32d273a26f0c18b113a71fc','Ññ8˜ÕTdw¢UÂ#Ëÿ3çá[EÖ°l]8ÊÍLø4÷',4,1),(26,'Warehouse','Uder','warehouseuser@fakecompany.com','whuser','03b493342a4502ce8d11975f632a067eb99c763cbaee4fab5ea787538791730f','«D\rïß‘}Îÿ‡øŠ…ÿ¶¯å\ZZ“u˜Oå^',6,1),(27,'Reporting','User','reportinguser@fakecompany.com','rptuser','08abe02cee409ca87e627d2aa29b1df30bac36d0c0052619f8d132e8e8b689c2','—:¸_»ù‚Û6òÇ_â—¸ƒ\"¹Õ¾›Ç.\r;ñë¬ÿÇ€',7,1),(28,'Super','User','superuser@fakecompany.com','superuser','28562279f081539712707d1048d5af1e3f6853e3beee0c20489236bd8578b122','§±o¹)õøD7þÙ £ë·6BEÉAÏÑlCòG_æ98×',8,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_session`
--

DROP TABLE IF EXISTS `users_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_session` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `hash` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`session_id`),
  KEY `fk_user_session_id_idx` (`uid`),
  CONSTRAINT `fk_user_session_id` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_session`
--

LOCK TABLES `users_session` WRITE;
/*!40000 ALTER TABLE `users_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `validation_results`
--

DROP TABLE IF EXISTS `validation_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validation_results` (
  `vr_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`vr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `validation_results`
--

LOCK TABLES `validation_results` WRITE;
/*!40000 ALTER TABLE `validation_results` DISABLE KEYS */;
INSERT INTO `validation_results` VALUES (1,'OK'),(2,'Resource exists'),(3,'Model does not exist'),(4,'Incorrect serial number length');
/*!40000 ALTER TABLE `validation_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher_values`
--

DROP TABLE IF EXISTS `voucher_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voucher_values` (
  `voucher_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_value` varchar(4) NOT NULL,
  PRIMARY KEY (`voucher_value_id`),
  UNIQUE KEY `uq_voucher_value` (`voucher_value`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher_values`
--

LOCK TABLES `voucher_values` WRITE;
/*!40000 ALTER TABLE `voucher_values` DISABLE KEYS */;
INSERT INTO `voucher_values` VALUES (10,'10'),(20,'20'),(5,'5'),(50,'50');
/*!40000 ALTER TABLE `voucher_values` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-05 11:25:50
