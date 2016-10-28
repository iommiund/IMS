-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: itsrms_iommiunderwood
-- ------------------------------------------------------
-- Server version	5.6.21

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

DROP DATABASE IF EXISTS itsrms_iommiunderwood;
CREATE DATABASE itsrms_iommiunderwood;
USE itsrms_iommiunderwood;

--
-- Table structure for table `help`
--

DROP TABLE IF EXISTS `help`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `help` (
  `help_id` int(11) NOT NULL AUTO_INCREMENT,
  `help_subject` varchar(100) NOT NULL,
  `help_content` text NOT NULL,
  `help_level_id` int(11) NOT NULL,
  PRIMARY KEY (`help_id`),
  UNIQUE KEY `un_help_subject` (`help_subject`),
  KEY `fk_help_level_id` (`help_level_id`),
  CONSTRAINT `fk_help_level_id` FOREIGN KEY (`help_level_id`) REFERENCES `help_levels` (`help_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `help`
--

LOCK TABLES `help` WRITE;
/*!40000 ALTER TABLE `help` DISABLE KEYS */;
INSERT INTO `help` VALUES (4,'Low in stock view','When navigating to the Main page, you will be presented with two views, the view at the top shows which resources are idle in one of the two stores in the company (Store A and Store B), and have a total quantity of less then 10.\r\n\r\nThis view is provided to encourage a proactive approach, so that you as a user can take action if items are getting low in stock. ',1),(5,'Last 10 transactions','When navigating to the Main page, you will be presented with two views, the view at the bottom shows the last 10 transactions that happened.\r\n\r\nThis is useful as it keeps you updated of the resource movements and it provides a quick audit trail if needed.',1),(6,'Adding a resource to the system','To add a new or existing resource to the system, click on the Add Resource button from the top menu.\r\n\r\nYou will be presented with a page requesting the following information:\r\n\r\n- Brand: Select from drop down the brand of the resource that is being added.\r\n\r\n- Resource Type: Select from drop down the type of the resource that is being added.\r\n\r\n- Model: Select from drop down the model of the resource that is being added.\r\n\r\n- Serial Number: Input a unique value that is the serial number which is printed on the bar-code of the resource \r\nbeing added.\r\n\r\n- State: Select from drop down the state of the resource being added.\r\n\r\n- Condition: Select from drop down the condition of the resource that is being added.\r\n\r\n- Status: Select from drop down the status of the resource that is being added.\r\n\r\n- Current Owner: Select from drop down the current owner of the resource that is being added.\r\n\r\n- Location: Select from drop down the current location of the resource that is being added.\r\n\r\n- Current Value: Requires user input, can only contain numbers, this is the current â‚¬ value of the resource.\r\n\r\nIn case you need to select an attribute that is not available in the drop down, contact a Super User and ask for an attribute to be added.',1),(7,'Search resources','To search an existing resource to the system, click the Search button from the top menu.\r\n\r\nYou will be presented with a page containing two selections and a user input.\r\n\r\nThe first selection is the parameter you are going to search with, for example, if you will be searching a resource by Description select the parameter.\r\n\r\nThe second selection lets you choose whether you want a perfect match to the description you are going to input, whether you do not want the result to match your input, or whether the result contains part of the text you input.\r\n\r\nThe input field requires you to type the value that you will be searching.\r\n\r\nWhen complete click SEARCH.\r\n\r\nSuggested Topic: Search Results',1),(8,'Search results','After doing a search, the application will display all search results which contains the latest update for each resource being displayed.\r\n\r\nThe view contains the following:\r\n\r\n- Description: Concatenates the resource brand, type and model to form the description of the resource.\r\n\r\n- S/N: The serial number for each resource, also contains a link to view all history for that particular resource where you can also update the resource.\r\n\r\n- State: Displays the current state of each resource.\r\n\r\n- Condition: Displays the current condition of each resource.\r\n\r\n- Status: Displays the current status of each resource.\r\n\r\n- Owner: Concatinates the owner name, surname and type to provide a description of the owner. Note that the Owner can also be a department.\r\n\r\n- Location: Displays the current location of each resource.\r\n\r\nSuggested Topics: View resource history & Update resource',1),(9,'View resource history','While viewing search results, clicking the serial number will get you to view the full history for that resource. \r\n\r\nThe description for the resource will be on top, this is followed by the serial number and an Update Resource button which takes you to the Update Resource Screen and is discussed in another topic.\r\n\r\nA table will show the full history for the resource being viewed, the latest update is always on top to minimise the need for scrolling in case a resource has a long history.\r\n\r\nSuggested Topics: Update resource & Search results',1),(10,'Update resource','To update a resource you need to first search the resource from the Search page, then click on the serial number of the resource displayed in the search results.\r\n\r\nOnce in the update resource screen, you will be allowed to update the following attributes for the resource:\r\n\r\n- State: Select a new state for the resource.\r\n\r\n- Condition: Select a new condition for the resource.\r\n\r\n- Status: Select a new status for the resource.\r\n\r\n- Location: Select a new location for the resource.\r\n\r\n- Owner: Select a new owner for the resource.\r\n\r\nThe following validation is in place:\r\n\r\n- If either the state or condition is not new, you cannot change this back to new.\r\n\r\n- If a resource is set as destroyed, you cannot do any further updates to the resource.\r\n\r\n- When changing the resource to destroyed, you need to set the following combination, failing to do so will display an error:\r\n\r\n     - State: Destroyed\r\n     - Condition: Destroyed - Beyond Repair\r\n     - Status: Destroyed\r\n     - Location: Destroyed\r\n     - Owner: Recycling Plant - External Entity\r\n\r\nSuggested Topics: Search resources,  Search results, View resource history',1),(11,'Reset own password','If you wish to reset your own password, click on the Profile button from the top menu, a profile page will be displayed.\r\n\r\nThe profile page contains a button called \'Reset Password\', click this button.\r\n\r\nHere you will see your username is a static value and cannot be changed.\r\n\r\nOld Password: Type your current password\r\nNew Password: Type your new password\r\n\r\nClick submit',1),(12,'Add a new user','To add a new user go to Admin > Add User\r\n\r\nFill in the following details:\r\n-Name\r\n-Surname\r\n-Email\r\n-Username\r\n-Password\r\n\r\nREGISTER the new user.\r\n\r\nValidation:\r\n- Empty fields are not permitted\r\n- Username and email must be unique',2),(13,'Change user status','Changing the status of a user means permitting or denying access to the application for the selected user. To change the status of a user go to Admin > Change User Status\r\n\r\nSelect a user from the first list which shows the username for each user.\r\n\r\nSelect the new status for the user which is either disable or enable.\r\n\r\nclick CHANGE STATUS.',2),(14,'Change user profile','Changing the profile for a user means maximising or minimising functionality, a Super User has access to all functions while a Standard User does not. \r\n\r\nTo change the profile of a user go to Admin > Change User Profile.\r\n\r\nSelect a user from the first list which shows the username for each user.\r\n\r\nSelect the new profile for the user which is Standard User or Super User.\r\n\r\nclick CHANGE PROFILE.',2),(15,'Add resource attributes','Adding an attribute means making more selections available to users when adding or updating a resource.\r\n\r\nTo add new attributes navigate to Admin > Add resource attributes.\r\n\r\nThis page is divided into two sections, in the first section you can choose what you need to add, for example: to add a brand select brand and add the brand name underneath.\r\n\r\nTo add an attribute selected on top click the ADD button.\r\n\r\nThe second section is to add a new owner, where you are required to type the owner Name, Surname and select the Owner Type. When ready click ADD OWNER',2),(16,'Delete resource attributes','Deleting an attribute means making less selections available to users when adding or updating a resource.\r\n\r\nTo delete attributes navigate to Admin > Delete resource attributes.\r\n\r\nSelect what you wish to delete, for example a Brand, then type the brand name and click DELETE.\r\n\r\nIf a value is already used, meaning there are resources with that \'Brand\', you will not be able to delete it.',2),(17,'Add a new help topic','To add a new help topic navigate to Admin > Add Help Topic.\r\n\r\nType in a subject which must not already exist.\r\n\r\nSelect the level of the Topic, advanced topics can only be read by Super Users.\r\n\r\nType the content of the topic being added.\r\n\r\nClick ADD.',2),(18,'Delete a help topic','To delete a help topic navigate to Admin > Add Help Topic.\r\n\r\nSelect the subject of the topic to be deleted.\r\n\r\nClick DELETE',2),(19,'Modify a help topic','To Modify a help topic navigate to Admin > Add Help Topic.\r\n\r\nA list will show the subject of each topic and the topic level, clicking the subject will shown the contents of that topic inside a form where you will be able to update any value.\r\n\r\nWhen ready click MODIFY.',2);
/*!40000 ALTER TABLE `help` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `help_levels`
--

DROP TABLE IF EXISTS `help_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `help_levels` (
  `help_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `help_level` varchar(50) NOT NULL,
  `help_level_description` varchar(200) NOT NULL,
  PRIMARY KEY (`help_level_id`),
  UNIQUE KEY `un_help_level` (`help_level`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `help_levels`
--

LOCK TABLES `help_levels` WRITE;
/*!40000 ALTER TABLE `help_levels` DISABLE KEYS */;
INSERT INTO `help_levels` VALUES (1,'Normal','Used to show help content for standard users'),(2,'Advanced','Used to show help content for super users');
/*!40000 ALTER TABLE `help_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `owner_types`
--

DROP TABLE IF EXISTS `owner_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `owner_types` (
  `owner_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_type` varchar(50) NOT NULL,
  PRIMARY KEY (`owner_type_id`),
  UNIQUE KEY `un_owner_type` (`owner_type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `owner_types`
--

LOCK TABLES `owner_types` WRITE;
/*!40000 ALTER TABLE `owner_types` DISABLE KEYS */;
INSERT INTO `owner_types` VALUES (1,'Department'),(3,'Department Manager'),(6,'External Entity'),(4,'Repair Centre'),(2,'User');
/*!40000 ALTER TABLE `owner_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `owners`
--

DROP TABLE IF EXISTS `owners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `owners` (
  `owner_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_name` varchar(50) NOT NULL,
  `owner_surname` varchar(50) NOT NULL,
  `owner_type` varchar(50) NOT NULL,
  PRIMARY KEY (`owner_id`),
  KEY `fk_owner_type` (`owner_type`),
  CONSTRAINT `fk_owner_type` FOREIGN KEY (`owner_type`) REFERENCES `owner_types` (`owner_type`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `owners`
--

LOCK TABLES `owners` WRITE;
/*!40000 ALTER TABLE `owners` DISABLE KEYS */;
INSERT INTO `owners` VALUES (1,'Iommi','Underwood','User'),(2,'Simon','Baldacchino','User'),(3,'Brian','Micallef','Department Manager'),(4,'Kenny','Schembri','User'),(5,'IT','Support','Department'),(6,'Darren','Gatt','Department Manager'),(7,'Anne','Buttigieg','Department Manager'),(10,'Recycling','Plant','External Entity');
/*!40000 ALTER TABLE `owners` ENABLE KEYS */;
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
  UNIQUE KEY `un_brand` (`resource_brand`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_brands`
--

LOCK TABLES `resource_brands` WRITE;
/*!40000 ALTER TABLE `resource_brands` DISABLE KEYS */;
INSERT INTO `resource_brands` VALUES (1,'Acer'),(6,'Aoc'),(4,'Asus'),(7,'BenQ'),(20,'Cisco'),(9,'DELL'),(17,'Epson'),(5,'Fujitsu'),(23,'GIGABYTE'),(8,'HP'),(18,'IBM'),(11,'Lenovo'),(12,'LG'),(13,'Microsoft'),(21,'MSI'),(14,'Nec'),(3,'Philips'),(19,'Razer'),(10,'Samsung'),(16,'SONY'),(15,'Toshiba'),(2,'ViewSonic');
/*!40000 ALTER TABLE `resource_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_conditions`
--

DROP TABLE IF EXISTS `resource_conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_conditions` (
  `resource_condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_condition` varchar(50) NOT NULL,
  PRIMARY KEY (`resource_condition_id`),
  UNIQUE KEY `un_resouce_condition` (`resource_condition`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_conditions`
--

LOCK TABLES `resource_conditions` WRITE;
/*!40000 ALTER TABLE `resource_conditions` DISABLE KEYS */;
INSERT INTO `resource_conditions` VALUES (2,'Almost Brand New'),(1,'Brand New'),(6,'Damaged'),(7,'Damaged - Beyond Repair'),(3,'Damaged - Functions Well'),(5,'Damaged - Needs Repair'),(4,'Scratched');
/*!40000 ALTER TABLE `resource_conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_history`
--

DROP TABLE IF EXISTS `resource_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_history` (
  `rh_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `resource_description` varchar(200) NOT NULL,
  `resource_serial_number` varchar(50) NOT NULL,
  `resource_state` varchar(50) NOT NULL,
  `resource_condition` varchar(50) NOT NULL,
  `resource_status` varchar(50) NOT NULL,
  `owner_description` varchar(100) NOT NULL,
  `resource_location` varchar(50) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rh_id`),
  KEY `fk_resource_id` (`resource_id`),
  KEY `fk_username` (`username`),
  KEY `fk_resource_state` (`resource_state`),
  KEY `fk_resource_condition` (`resource_condition`),
  KEY `fk_resource_status` (`resource_status`),
  KEY `resource_location` (`resource_location`),
  CONSTRAINT `fk_resource_condition` FOREIGN KEY (`resource_condition`) REFERENCES `resource_conditions` (`resource_condition`),
  CONSTRAINT `fk_resource_id` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`),
  CONSTRAINT `fk_resource_state` FOREIGN KEY (`resource_state`) REFERENCES `resource_states` (`resource_state`),
  CONSTRAINT `fk_resource_status` FOREIGN KEY (`resource_status`) REFERENCES `resource_statuses` (`resource_status`),
  CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  CONSTRAINT `resource_history_ibfk_1` FOREIGN KEY (`resource_location`) REFERENCES `resource_locations` (`resource_location`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_history`
--

LOCK TABLES `resource_history` WRITE;
/*!40000 ALTER TABLE `resource_history` DISABLE KEYS */;
INSERT INTO `resource_history` VALUES (1,27,'iommi','Microsoft Keyboard ComfortCurve 3000','035301620225','Used','Almost Brand New','In Use','Iommi Underwood - User','Technology - IT Billing & Operations ','2015-06-21 16:45:48'),(2,28,'iommi','DELL Laptop LATTITUDE E5540','4H88WZ1','Used','Almost Brand New','In Use','Iommi Underwood - User','Technology - IT Billing & Operations','2015-06-22 17:16:39'),(3,29,'iommi','Razer Mouse COPPERHEAD','050200','Used','Scratched','In Use','Iommi Underwood - User','Technology - IT Billing & Operations','2015-06-22 20:43:44'),(4,30,'iommi','Samsung Monitor SyncMaster S24B350','036587421','Used','Scratched','In Use','Iommi Underwood - User','Technology - IT Billing & Operations','2015-06-23 16:15:14'),(5,31,'iommi','Cisco IP Phone 7975','PH11329F8TC','New','Brand New','In Use','Anne Buttigieg - Department Manager','CEO Office','2015-06-29 09:22:08'),(6,32,'matta','Cisco IP Phone 7916 Expansion Module','CH1512B2C2','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-06-29 09:26:25'),(12,32,'matta','Cisco IP Phone 7916 Expansion Module','CH1512B2C2','Used','Almost Brand New','In Use','Anne Buttigieg - Department Manager','CEO Office','2015-07-05 13:26:59'),(13,27,'matta','Microsoft Keyboard ComfortCurve 3000','035301620225','Used','Damaged','In Repair','IT Support - Department','Technology - IT Support','2015-07-05 13:32:23'),(14,33,'matta','Microsoft Keyboard ComfortCurve 3000','035301620226','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:44:25'),(15,34,'matta','Microsoft Keyboard ComfortCurve 3000','035301620227','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:44:33'),(16,35,'matta','Microsoft Keyboard ComfortCurve 3000','035301620228','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:44:38'),(17,36,'matta','Microsoft Keyboard ComfortCurve 3000','035301620229','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:44:43'),(18,37,'matta','Microsoft Keyboard ComfortCurve 3000','035301620230','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:44:49'),(19,38,'matta','Microsoft Keyboard ComfortCurve 3000','035301620231','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:44:54'),(20,39,'matta','Microsoft Keyboard ComfortCurve 3000','035301620232','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:44:59'),(21,40,'matta','Microsoft Keyboard ComfortCurve 3000','035301620233','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:45:04'),(22,41,'matta','Microsoft Keyboard ComfortCurve 3000','035301620234','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:45:08'),(23,42,'matta','Microsoft Keyboard ComfortCurve 3000','035301620235','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:45:13'),(24,43,'matta','Microsoft Keyboard ComfortCurve 3000','035301620236','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:45:20'),(25,44,'matta','Microsoft Keyboard ComfortCurve 3000','035301620237','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:45:35'),(26,45,'matta','Microsoft Keyboard ComfortCurve 3000','035301620238','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:45:41'),(27,46,'matta','Microsoft Keyboard ComfortCurve 3000','035301620239','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:45:46'),(28,47,'matta','Microsoft Keyboard ComfortCurve 3000','035301620240','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-05 13:45:53'),(29,31,'iommi','Cisco IP Phone 7975','PH11329F8TC','Used','Almost Brand New','In Use','Anne Buttigieg - Department Manager','CEO Office','2015-07-08 06:17:26'),(30,27,'rcamm','Microsoft Keyboard ComfortCurve 3000','035301620225','Used','Almost Brand New','In Use','Iommi Underwood - User','Technology - IT Support','2015-07-10 08:19:58'),(31,27,'dgatt','Microsoft Keyboard ComfortCurve 3000','035301620225','Used','Scratched','In Use','Iommi Underwood - User','Technology - IT Support','2015-07-11 07:50:44'),(32,48,'dgatt','Cisco IP Phone 7940','PH11329F8TD','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:28:44'),(33,49,'dgatt','Cisco IP Phone 7940','PH11329F8TE','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:29:08'),(34,50,'dgatt','Cisco IP Phone 7940','PH11329F8TF','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:29:14'),(35,51,'dgatt','Cisco IP Phone 7940','PH11329F8TG','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:29:40'),(36,52,'dgatt','Cisco IP Phone 7940','PH11329F8TH','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:33:01'),(37,53,'dgatt','Cisco IP Phone 7940','PH11329F8TI','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:33:05'),(38,54,'dgatt','Cisco IP Phone 7940','PH11329F8TJ','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:33:12'),(39,55,'cfarr','DELL Laptop LATTITUDE E5540','4H88WZ2','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 08:37:10'),(40,56,'cfarr','DELL Laptop LATTITUDE E5540','4H88WZ3','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 08:37:15'),(41,57,'cfarr','DELL Laptop LATTITUDE E5540','4H88WZ4','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 08:37:19'),(42,58,'cfarr','DELL Laptop LATTITUDE E5540','4H88WZ5','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 08:37:24'),(43,59,'cfarr','DELL Laptop LATTITUDE E5540','4H88WZ6','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 08:37:29'),(44,60,'cfarr','DELL Laptop LATTITUDE E5540','4H88WZ7','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 08:37:35'),(45,61,'cfarr','DELL Laptop Docking Station E-Port Plus','T0J2133851','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:45:16'),(46,62,'cfarr','DELL Laptop Docking Station E-Port Plus','T0J2133852','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:45:23'),(47,63,'cfarr','DELL Laptop Docking Station E-Port Plus','T0J2133853','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:45:28'),(48,64,'cfarr','DELL Laptop Docking Station E-Port Plus','T0J2133854','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:45:33'),(49,65,'cfarr','DELL Laptop Docking Station E-Port Plus','T0J2133855','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:45:37'),(50,66,'cfarr','DELL Laptop Docking Station E-Port Plus','T0J2133856','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:45:43'),(51,67,'cfarr','DELL Laptop Docking Station E-Port Plus','T0J2133857','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 08:45:48'),(52,67,'cfarr','DELL Laptop Docking Station E-Port Plus','T0J2133857','Used','Almost Brand New','In Use','Iommi Underwood - User','Technology - IT Support','2015-07-11 08:47:12'),(53,68,'kzamm','Microsoft Mouse Sculpt Comfort','121110987450','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:53:17'),(54,69,'kzamm','Microsoft Mouse Sculpt Comfort','121110987451','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:53:23'),(55,70,'kzamm','Microsoft Mouse Sculpt Comfort','121110987452','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:53:28'),(56,71,'kzamm','Microsoft Mouse Sculpt Comfort','121110987453','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:53:35'),(57,72,'kzamm','Microsoft Mouse Sculpt Comfort','121110987454','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:53:39'),(58,73,'kzamm','Microsoft Mouse Sculpt Comfort','121110987455','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:53:43'),(59,74,'kzamm','Microsoft Mouse Sculpt Comfort','121110987456','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:53:48'),(60,75,'kzamm','Microsoft Mouse Sculpt Comfort','121110987457','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:54:10'),(61,76,'kzamm','Microsoft Mouse Sculpt Comfort','121110987458','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:54:23'),(62,77,'kzamm','Microsoft Mouse Sculpt Comfort','121110987459','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store A','2015-07-11 11:54:45'),(63,78,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158E','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:18:45'),(64,79,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158F','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:18:51'),(65,80,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158G','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:18:55'),(66,81,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158H','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:18:59'),(67,82,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158I','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:05'),(68,83,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158J','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:10'),(69,84,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158K','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:15'),(70,85,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158L','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:19'),(71,86,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158M','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:24'),(72,87,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158N','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:29'),(73,88,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158O','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:33'),(74,89,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158P','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:37'),(75,90,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158Q','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:42'),(76,91,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158R','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:46'),(77,92,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158S','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:50'),(78,93,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158T','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:55'),(79,94,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158W','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:19:59'),(80,95,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158X','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:20:03'),(81,96,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158Y','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:20:07'),(82,97,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158Z','New','Brand New','Idle','IT Support - Department','Technology - IT Support - Store B','2015-07-11 12:20:12'),(83,78,'kzamm','Acer Monitor G7 G237HLbi','G2374UR300158E','Used','Almost Brand New','In Use','Simon Baldacchino - User','Sales - Telesales','2015-07-11 12:23:16'),(84,48,'kzamm','Cisco IP Phone 7940','PH11329F8TD','Used','Almost Brand New','In Use','Simon Baldacchino - User','Sales - Telesales','2015-07-11 12:23:53'),(85,61,'kzamm','DELL Laptop Docking Station E-Port Plus','T0J2133851','Used','Almost Brand New','Sold','Simon Baldacchino - User','Sales - Telesales','2015-07-11 12:24:25'),(86,55,'kzamm','DELL Laptop LATTITUDE E5540','4H88WZ2','Used','Almost Brand New','In Use','Simon Baldacchino - User','Sales - Telesales','2015-07-11 12:24:57'),(87,33,'kzamm','Microsoft Keyboard ComfortCurve 3000','035301620226','Used','Almost Brand New','In Use','Simon Baldacchino - User','Sales - Telesales','2015-07-11 12:25:26'),(88,68,'kzamm','Microsoft Mouse Sculpt Comfort','121110987450','Used','Almost Brand New','In Use','Simon Baldacchino - User','Sales - Telesales','2015-07-11 12:26:00'),(89,61,'kzamm','DELL Laptop Docking Station E-Port Plus','T0J2133851','Used','Almost Brand New','In Use','Simon Baldacchino - User','Sales - Telesales','2015-07-11 12:27:38'),(90,79,'lcami','Acer Monitor G7 G237HLbi','G2374UR300158F','Used','Almost Brand New','In Use','Brian Micallef - Department Manager','Sales - Outdoor - D2D','2015-07-11 12:33:47'),(91,49,'lcami','Cisco IP Phone 7940','PH11329F8TE','Used','Almost Brand New','In Use','Brian Micallef - Department Manager','Sales - Outdoor - D2D','2015-07-11 12:34:11'),(92,62,'lcami','DELL Laptop Docking Station E-Port Plus','T0J2133852','Used','Almost Brand New','In Use','Brian Micallef - Department Manager','Sales - Outdoor - D2D','2015-07-11 12:34:47'),(93,56,'lcami','DELL Laptop LATTITUDE E5540','4H88WZ3','Used','Almost Brand New','In Use','Brian Micallef - Department Manager','Sales - Outdoor - D2D','2015-07-11 12:35:11'),(94,34,'lcami','Microsoft Keyboard ComfortCurve 3000','035301620227','Used','Almost Brand New','In Use','Brian Micallef - Department Manager','Sales - Outdoor - D2D','2015-07-11 12:35:47'),(95,69,'lcami','Microsoft Mouse Sculpt Comfort','121110987451','Used','Almost Brand New','In Use','Brian Micallef - Department Manager','Sales - Outdoor - D2D','2015-07-11 12:36:14'),(96,80,'lcami','Acer Monitor G7 G237HLbi','G2374UR300158G','Used','Almost Brand New','In Use','Kenny Schembri - User','Sales - B2B','2015-07-11 12:38:10'),(97,50,'lcami','Cisco IP Phone 7940','PH11329F8TF','Used','Almost Brand New','In Use','Kenny Schembri - User','Sales - B2B','2015-07-11 12:38:32'),(98,63,'lcami','DELL Laptop Docking Station E-Port Plus','T0J2133853','Used','Almost Brand New','In Use','Kenny Schembri - User','Sales - B2B','2015-07-11 12:38:54'),(99,57,'lcami','DELL Laptop LATTITUDE E5540','4H88WZ4','Used','Almost Brand New','In Use','Kenny Schembri - User','Sales - B2B','2015-07-11 12:39:18'),(100,35,'lcami','Microsoft Keyboard ComfortCurve 3000','035301620228','Used','Almost Brand New','In Use','Kenny Schembri - User','Sales - B2B','2015-07-11 12:39:47'),(101,70,'lcami','Microsoft Mouse Sculpt Comfort','121110987452','Used','Almost Brand New','In Use','Kenny Schembri - User','Sales - B2B','2015-07-11 12:40:16'),(102,27,'kzamm','Microsoft Keyboard ComfortCurve 3000','035301620225','Used','Damaged - Needs Repair','In Repair','IT Support - Department','Technology - IT Support','2015-07-13 10:55:42'),(103,27,'kzamm','Microsoft Keyboard ComfortCurve 3000','035301620225','Destroyed','Damaged - Beyond Repair','Destroyed','Recycling Plant - External Entity','Destroyed','2015-07-13 10:56:50'),(105,36,'kzamm','Microsoft Keyboard ComfortCurve 3000','035301620229','Used','Almost Brand New','In Use','Iommi Underwood - User','Technology - IT Billing & Operations','2015-07-13 11:00:12');
/*!40000 ALTER TABLE `resource_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_locations`
--

DROP TABLE IF EXISTS `resource_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_locations` (
  `resource_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_location` varchar(50) NOT NULL,
  PRIMARY KEY (`resource_location_id`),
  UNIQUE KEY `un_resource_location` (`resource_location`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_locations`
--

LOCK TABLES `resource_locations` WRITE;
/*!40000 ALTER TABLE `resource_locations` DISABLE KEYS */;
INSERT INTO `resource_locations` VALUES (32,'CEO Office'),(1,'Customer Care'),(33,'Destroyed'),(2,'Field - Dispatch'),(3,'Field - Line'),(4,'Field - Radio'),(5,'Field - Service'),(6,'Finance - Accounts'),(7,'Finance - Credit Control'),(8,'Internal Controls'),(10,'Marketing'),(11,'Sales - B2B'),(14,'Sales - Outdoor - D2D'),(13,'Sales - Outdoor - Mobile Van'),(12,'Sales - Outdoor - Trade Fair'),(15,'Sales - Resale - Me Mobile'),(16,'Sales - Resale - Stop Shop'),(20,'Sales - Retail - Gozo'),(19,'Sales - Retail - Naxxar'),(17,'Sales - Retail - Paola'),(18,'Sales - Retail - Valletta'),(22,'Sales - Telesales'),(23,'Technology - Business Inteligence'),(24,'Technology - Core Networks'),(25,'Technology - IT Billing & Operations'),(30,'Technology - IT Support'),(28,'Technology - IT Support - Store A'),(31,'Technology - IT Support - Store B'),(26,'Technology - Radio'),(27,'Technology - Software Development'),(21,'Warehouse - Gozo'),(9,'Warehouse - Main');
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
  `resource_model` varchar(50) NOT NULL,
  PRIMARY KEY (`resource_model_id`),
  UNIQUE KEY `un_resource_model` (`resource_model`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_models`
--

LOCK TABLES `resource_models` WRITE;
/*!40000 ALTER TABLE `resource_models` DISABLE KEYS */;
INSERT INTO `resource_models` VALUES (7,'7916 Expansion Module'),(8,'7940'),(5,'7942G'),(6,'7975'),(4,'ComfortCurve 3000'),(3,'COPPERHEAD'),(9,'E-Port Plus'),(11,'G7 G237HLbi'),(2,'LATTITUDE E5540'),(10,'Sculpt Comfort'),(1,'SyncMaster S24B350');
/*!40000 ALTER TABLE `resource_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_states`
--

DROP TABLE IF EXISTS `resource_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_states` (
  `resource_state_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_state` varchar(50) NOT NULL,
  PRIMARY KEY (`resource_state_id`),
  UNIQUE KEY `un_state` (`resource_state`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_states`
--

LOCK TABLES `resource_states` WRITE;
/*!40000 ALTER TABLE `resource_states` DISABLE KEYS */;
INSERT INTO `resource_states` VALUES (7,'Destroyed'),(1,'New'),(6,'Recycled'),(2,'Used');
/*!40000 ALTER TABLE `resource_states` ENABLE KEYS */;
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
  UNIQUE KEY `un_resource_status` (`resource_status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_statuses`
--

LOCK TABLES `resource_statuses` WRITE;
/*!40000 ALTER TABLE `resource_statuses` DISABLE KEYS */;
INSERT INTO `resource_statuses` VALUES (6,'Destroyed'),(1,'Idle'),(2,'In Repair'),(3,'In Use'),(5,'Sold'),(4,'Waiting Repair');
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
  UNIQUE KEY `un_resource_type` (`resource_type`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_types`
--

LOCK TABLES `resource_types` WRITE;
/*!40000 ALTER TABLE `resource_types` DISABLE KEYS */;
INSERT INTO `resource_types` VALUES (10,'Barcode Reader'),(17,'IP Phone'),(2,'Keyboard'),(4,'Laptop'),(7,'Laptop Docking Station'),(1,'Monitor'),(3,'Mouse'),(12,'Multi Functional Printer P/S/C'),(6,'PC Tower'),(8,'Port Replicator'),(9,'Printer'),(11,'scanner'),(5,'Tablet'),(13,'USB Hub');
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
  `resource_brand` varchar(50) NOT NULL,
  `resource_type` varchar(50) NOT NULL,
  `resource_model` varchar(50) NOT NULL,
  `resource_serial_number` varchar(50) NOT NULL,
  `resource_creation_date` date NOT NULL,
  `resource_initial_value` int(11) NOT NULL,
  `resource_current_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`resource_id`),
  UNIQUE KEY `un_resource_serial_number` (`resource_serial_number`),
  KEY `fk_resource_brand` (`resource_brand`),
  KEY `fk_resource_type` (`resource_type`),
  KEY `fk_resource_model` (`resource_model`),
  CONSTRAINT `fk_resource_brand` FOREIGN KEY (`resource_brand`) REFERENCES `resource_brands` (`resource_brand`),
  CONSTRAINT `fk_resource_model` FOREIGN KEY (`resource_model`) REFERENCES `resource_models` (`resource_model`),
  CONSTRAINT `fk_resource_type` FOREIGN KEY (`resource_type`) REFERENCES `resource_types` (`resource_type`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resources`
--

LOCK TABLES `resources` WRITE;
/*!40000 ALTER TABLE `resources` DISABLE KEYS */;
INSERT INTO `resources` VALUES (27,'Microsoft','Keyboard','ComfortCurve 3000','035301620225','2015-06-21',20,NULL),(28,'DELL','Laptop','LATTITUDE E5540','4H88WZ1','2015-06-22',790,NULL),(29,'Razer','Mouse','COPPERHEAD','050200','2015-06-22',15,NULL),(30,'Samsung','Monitor','SyncMaster S24B350','036587421','2015-06-23',195,NULL),(31,'Cisco','IP Phone','7975','PH11329F8TC','2015-06-29',310,NULL),(32,'Cisco','IP Phone','7916 Expansion Module','CH1512B2C2','2015-06-29',200,NULL),(33,'Microsoft','Keyboard','ComfortCurve 3000','035301620226','2015-07-05',20,NULL),(34,'Microsoft','Keyboard','ComfortCurve 3000','035301620227','2015-07-05',20,NULL),(35,'Microsoft','Keyboard','ComfortCurve 3000','035301620228','2015-07-05',20,NULL),(36,'Microsoft','Keyboard','ComfortCurve 3000','035301620229','2015-07-05',20,NULL),(37,'Microsoft','Keyboard','ComfortCurve 3000','035301620230','2015-07-05',20,NULL),(38,'Microsoft','Keyboard','ComfortCurve 3000','035301620231','2015-07-05',20,NULL),(39,'Microsoft','Keyboard','ComfortCurve 3000','035301620232','2015-07-05',20,NULL),(40,'Microsoft','Keyboard','ComfortCurve 3000','035301620233','2015-07-05',20,NULL),(41,'Microsoft','Keyboard','ComfortCurve 3000','035301620234','2015-07-05',20,NULL),(42,'Microsoft','Keyboard','ComfortCurve 3000','035301620235','2015-07-05',20,NULL),(43,'Microsoft','Keyboard','ComfortCurve 3000','035301620236','2015-07-05',20,NULL),(44,'Microsoft','Keyboard','ComfortCurve 3000','035301620237','2015-07-05',20,NULL),(45,'Microsoft','Keyboard','ComfortCurve 3000','035301620238','2015-07-05',20,NULL),(46,'Microsoft','Keyboard','ComfortCurve 3000','035301620239','2015-07-05',20,NULL),(47,'Microsoft','Keyboard','ComfortCurve 3000','035301620240','2015-07-05',20,NULL),(48,'Cisco','IP Phone','7940','PH11329F8TD','2015-07-11',250,NULL),(49,'Cisco','IP Phone','7940','PH11329F8TE','2015-07-11',250,NULL),(50,'Cisco','IP Phone','7940','PH11329F8TF','2015-07-11',250,NULL),(51,'Cisco','IP Phone','7940','PH11329F8TG','2015-07-11',250,NULL),(52,'Cisco','IP Phone','7940','PH11329F8TH','2015-07-11',250,NULL),(53,'Cisco','IP Phone','7940','PH11329F8TI','2015-07-11',250,NULL),(54,'Cisco','IP Phone','7940','PH11329F8TJ','2015-07-11',250,NULL),(55,'DELL','Laptop','LATTITUDE E5540','4H88WZ2','2015-07-11',790,NULL),(56,'DELL','Laptop','LATTITUDE E5540','4H88WZ3','2015-07-11',790,NULL),(57,'DELL','Laptop','LATTITUDE E5540','4H88WZ4','2015-07-11',790,NULL),(58,'DELL','Laptop','LATTITUDE E5540','4H88WZ5','2015-07-11',790,NULL),(59,'DELL','Laptop','LATTITUDE E5540','4H88WZ6','2015-07-11',790,NULL),(60,'DELL','Laptop','LATTITUDE E5540','4H88WZ7','2015-07-11',790,NULL),(61,'DELL','Laptop Docking Station','E-Port Plus','T0J2133851','2015-07-11',170,NULL),(62,'DELL','Laptop Docking Station','E-Port Plus','T0J2133852','2015-07-11',170,NULL),(63,'DELL','Laptop Docking Station','E-Port Plus','T0J2133853','2015-07-11',170,NULL),(64,'DELL','Laptop Docking Station','E-Port Plus','T0J2133854','2015-07-11',170,NULL),(65,'DELL','Laptop Docking Station','E-Port Plus','T0J2133855','2015-07-11',170,NULL),(66,'DELL','Laptop Docking Station','E-Port Plus','T0J2133856','2015-07-11',170,NULL),(67,'DELL','Laptop Docking Station','E-Port Plus','T0J2133857','2015-07-11',170,NULL),(68,'Microsoft','Mouse','Sculpt Comfort','121110987450','2015-07-11',25,NULL),(69,'Microsoft','Mouse','Sculpt Comfort','121110987451','2015-07-11',25,NULL),(70,'Microsoft','Mouse','Sculpt Comfort','121110987452','2015-07-11',25,NULL),(71,'Microsoft','Mouse','Sculpt Comfort','121110987453','2015-07-11',25,NULL),(72,'Microsoft','Mouse','Sculpt Comfort','121110987454','2015-07-11',25,NULL),(73,'Microsoft','Mouse','Sculpt Comfort','121110987455','2015-07-11',25,NULL),(74,'Microsoft','Mouse','Sculpt Comfort','121110987456','2015-07-11',25,NULL),(75,'Microsoft','Mouse','Sculpt Comfort','121110987457','2015-07-11',25,NULL),(76,'Microsoft','Mouse','Sculpt Comfort','121110987458','2015-07-11',25,NULL),(77,'Microsoft','Mouse','Sculpt Comfort','121110987459','2015-07-11',25,NULL),(78,'Acer','Monitor','G7 G237HLbi','G2374UR300158E','2015-07-11',120,NULL),(79,'Acer','Monitor','G7 G237HLbi','G2374UR300158F','2015-07-11',120,NULL),(80,'Acer','Monitor','G7 G237HLbi','G2374UR300158G','2015-07-11',120,NULL),(81,'Acer','Monitor','G7 G237HLbi','G2374UR300158H','2015-07-11',120,NULL),(82,'Acer','Monitor','G7 G237HLbi','G2374UR300158I','2015-07-11',120,NULL),(83,'Acer','Monitor','G7 G237HLbi','G2374UR300158J','2015-07-11',120,NULL),(84,'Acer','Monitor','G7 G237HLbi','G2374UR300158K','2015-07-11',120,NULL),(85,'Acer','Monitor','G7 G237HLbi','G2374UR300158L','2015-07-11',120,NULL),(86,'Acer','Monitor','G7 G237HLbi','G2374UR300158M','2015-07-11',120,NULL),(87,'Acer','Monitor','G7 G237HLbi','G2374UR300158N','2015-07-11',120,NULL),(88,'Acer','Monitor','G7 G237HLbi','G2374UR300158O','2015-07-11',120,NULL),(89,'Acer','Monitor','G7 G237HLbi','G2374UR300158P','2015-07-11',120,NULL),(90,'Acer','Monitor','G7 G237HLbi','G2374UR300158Q','2015-07-11',120,NULL),(91,'Acer','Monitor','G7 G237HLbi','G2374UR300158R','2015-07-11',120,NULL),(92,'Acer','Monitor','G7 G237HLbi','G2374UR300158S','2015-07-11',120,NULL),(93,'Acer','Monitor','G7 G237HLbi','G2374UR300158T','2015-07-11',120,NULL),(94,'Acer','Monitor','G7 G237HLbi','G2374UR300158W','2015-07-11',120,NULL),(95,'Acer','Monitor','G7 G237HLbi','G2374UR300158X','2015-07-11',120,NULL),(96,'Acer','Monitor','G7 G237HLbi','G2374UR300158Y','2015-07-11',120,NULL),(97,'Acer','Monitor','G7 G237HLbi','G2374UR300158Z','2015-07-11',120,NULL);
/*!40000 ALTER TABLE `resources` ENABLE KEYS */;
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
  UNIQUE KEY `un_user_status` (`user_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
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
  PRIMARY KEY (`user_type_id`),
  UNIQUE KEY `un_user_type` (`user_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` VALUES (2,'Standard User'),(1,'Super User');
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_type_id` int(11) NOT NULL DEFAULT '2',
  `user_status_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `un_email` (`email`),
  UNIQUE KEY `un_username` (`username`),
  KEY `fk_user_type_id` (`user_type_id`),
  KEY `fk_user_status_id` (`user_status_id`),
  CONSTRAINT `fk_user_status_id` FOREIGN KEY (`user_status_id`) REFERENCES `user_statuses` (`user_status_id`),
  CONSTRAINT `fk_user_type_id` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (8,'Russell','Camilleri','rcamm@itdep.com','rcamm','f7c20b3e6847db57880d10f24ff396ff',2,1),(9,'James','Cassar','jcass@itdep.com','jcass','dc411f978cb6765fff94495dfea1f4b3',2,2),(10,'Iommi','Underwood','iommi@itdep.com','iommi','eebe11d291033c61b9ffba9601e5d6e3',1,1),(11,'Mark','Attard','matta@itdep.com','matta','423c8f5dd72b2ab6d7c3ac2f098c33ed',2,1),(12,'Kyle','Zammit','kzamm@itdep.com','kzamm','1703461c0284e84d7b4e0fcf1681777b',2,1),(13,'Danijel','Cajic','dcaji@itdep.com','dcaji','9591e7e295f80e31616877b3148c13b7',2,1),(14,'Michael','Fava','mfava@itdep.com','mfava','583fb9383df04225f368d7435c6a0441',2,1),(15,'Darren','Gatt','dgatt@itdep.com','dgatt','73fe5165e54069d9069c071a737a6cbf',2,1),(16,'Ryan','Cassar','rcass@itdep.com','rcass','50b75b016497baca15c15cb53d1aacfe',2,1),(18,'Ryan','Scicluna','rscic@itdep.com','rscic','84942f24573d2ef8b0cff8f933301dff',2,1),(22,'Luke','Camilleri','lcami@itdep.com','lcami','c848d53ec4a4c5559f03bbe769d78779',2,1),(23,'Clayton','Farrugia','cfarr@itdep.com','cfarr','d8cdb87bdc894e520f73706fad33b442',2,1),(25,'Stephen','Ciantar','scian@itdep.com','scian','2e8535947e35ff81b9fbf8d564ecdc53',2,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-29 21:56:16
