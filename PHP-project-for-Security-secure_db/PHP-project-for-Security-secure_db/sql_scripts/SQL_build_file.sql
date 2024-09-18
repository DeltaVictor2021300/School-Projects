-- Drop the database if it exists
DROP DATABASE IF EXISTS `cst8257project`;

-- Create the database
CREATE DATABASE IF NOT EXISTS `cst8257project` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cst8257project`;

-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
-- Host: localhost    Database: cst8257project
-- ------------------------------------------------------
-- Server version 8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Table structure for table `accessibility`

DROP TABLE IF EXISTS `accessibility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accessibility` (
  `Accessibility_Code` varchar(16) NOT NULL,
  `Description` varchar(128) NOT NULL,
  PRIMARY KEY (`Accessibility_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Dumping data for table `accessibility`

LOCK TABLES `accessibility` WRITE;
/*!40000 ALTER TABLE `accessibility` DISABLE KEYS */;
INSERT INTO `accessibility` VALUES ('private', 'Accessible only by the owner'), ('shared', 'Accessible by the owner and friends');
/*!40000 ALTER TABLE `accessibility` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `friendshipstatus`

DROP TABLE IF EXISTS `friendshipstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friendshipstatus` (
  `Status_Code` varchar(16) NOT NULL,
  `Description` varchar(120) NOT NULL,
  PRIMARY KEY (`Status_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Dumping data for table `friendshipstatus`

LOCK TABLES `friendshipstatus` WRITE;
/*!40000 ALTER TABLE `friendshipstatus` DISABLE KEYS */;
INSERT INTO `friendshipstatus` VALUES ('accepted', 'The request to become a friend has been accepted'), ('request', 'A request has been sent to become a friend');
/*!40000 ALTER TABLE `friendshipstatus` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `user`

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `UserId` varchar(16) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `Phone` varchar(16) NOT NULL,
  `Password` varchar(256) NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table structure for table `album`

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `album` (
  `Album_Id` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(256) NOT NULL,
  `Description` varchar(3000) DEFAULT NULL,
  `Owner_Id` varchar(16) NOT NULL,
  `Accessibility_Code` varchar(16) NOT NULL,
  PRIMARY KEY (`Album_Id`),
  KEY `Owner` (`Owner_Id`),
  KEY `Accessibility` (`Accessibility_Code`),
  CONSTRAINT `Album_Accessibility_FK` FOREIGN KEY (`Accessibility_Code`) REFERENCES `accessibility` (`Accessibility_Code`),
  CONSTRAINT `Album_User_FK` FOREIGN KEY (`Owner_Id`) REFERENCES `user` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table structure for table `picture`

DROP TABLE IF EXISTS `picture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `picture` (
  `Picture_Id` int NOT NULL AUTO_INCREMENT,
  `Album_Id` int NOT NULL,
  `File_Name` varchar(256) NOT NULL,
  `Title` varchar(256) NOT NULL,
  `Description` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`Picture_Id`),
  KEY `Album_Id_Index` (`Album_Id`),
  CONSTRAINT `Picture_Album_FK` FOREIGN KEY (`Album_Id`) REFERENCES `album` (`Album_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table structure for table `comment`

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment` (
  `Comment_Id` int NOT NULL AUTO_INCREMENT,
  `Author_Id` varchar(16) NOT NULL,
  `Picture_Id` int NOT NULL,
  `Comment_Text` varchar(3000) NOT NULL,
  PRIMARY KEY (`Comment_Id`),
  KEY `Author_Index` (`Author_Id`),
  KEY `Comment_Picture_Index` (`Picture_Id`),
  CONSTRAINT `Comment_Picture_FK` FOREIGN KEY (`Picture_Id`) REFERENCES `picture` (`Picture_Id`),
  CONSTRAINT `Comment_User_FK` FOREIGN KEY (`Author_Id`) REFERENCES `user` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table structure for table `friendship`

DROP TABLE IF EXISTS `friendship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friendship` (
  `Friend_RequesterId` varchar(16) NOT NULL,
  `Friend_RequesteeId` varchar(16) NOT NULL,
  `Status` varchar(16) NOT NULL,
  PRIMARY KEY (`Friend_RequesterId`, `Friend_RequesteeId`),
  KEY `FriendShip_Student_FK2` (`Friend_RequesteeId`),
  KEY `Status` (`Status`),
  CONSTRAINT `Friendship_Status_FK` FOREIGN KEY (`Status`) REFERENCES `friendshipstatus` (`Status_Code`),
  CONSTRAINT `FriendShip_User_FK1` FOREIGN KEY (`Friend_RequesterId`) REFERENCES `user` (`UserId`),
  CONSTRAINT `FriendShip_User_FK2` FOREIGN KEY (`Friend_RequesteeId`) REFERENCES `user` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Restore original session settings
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Filling out the DB Tables

USE `cst8257project`;

-- Insert data into User table
INSERT INTO `user` (`UserId`, `Name`, `Phone`, `Password`) VALUES
('user01', 'Alice Smith', '555-0101', 'password1'),
('user02', 'Bob Johnson', '555-0102', 'password2'),
('user03', 'Charlie Brown', '555-0103', 'password3'),
('user04', 'David Williams', '555-0104', 'password4'),
('user05', 'Eve Davis', '555-0105', 'password5'),
('user06', 'Frank Miller', '555-0106', 'password6'),
('user07', 'Grace Wilson', '555-0107', 'password7'),
('user08', 'Hannah Moore', '555-0108', 'password8'),
('user09', 'Ian Taylor', '555-0109', 'password9'),
('user10', 'Jack Anderson', '555-0110', 'password10');

-- Reset the auto-increment counter for the album table
ALTER TABLE `album` AUTO_INCREMENT = 1;

-- Insert data into Album table
INSERT INTO `album` (`Title`, `Description`, `Owner_Id`, `Accessibility_Code`) VALUES
('Album 1', 'First album description', 'user01', 'private'),
('Album 2', 'Second album description', 'user02', 'shared'),
('Album 3', 'Third album description', 'user03', 'private'),
('Album 4', 'Fourth album description', 'user04', 'shared'),
('Album 5', 'Fifth album description', 'user05', 'private');

-- Reset the auto-increment counter for the picture table
ALTER TABLE `picture` AUTO_INCREMENT = 1;

-- Insert data into Picture table
INSERT INTO `picture` (`Album_Id`, `File_Name`, `Title`, `Description`) VALUES
(1, 'image1.jpg', 'Image 1', 'Description for image 1'),
(1, 'image2.jpg', 'Image 2', 'Description for image 2'),
(2, 'image3.jpg', 'Image 3', 'Description for image 3'),
(2, 'image4.jpg', 'Image 4', 'Description for image 4'),
(3, 'image5.jpg', 'Image 5', 'Description for image 5');

-- Reset the auto-increment counter for the comment table
ALTER TABLE `comment` AUTO_INCREMENT = 1;

-- Insert data into Comment table
INSERT INTO `comment` (`Author_Id`, `Picture_Id`, `Comment_Text`) VALUES
('user01', 1, 'This is a comment from Alice on Image 1'),
('user02', 2, 'This is a comment from Bob on Image 2'),
('user03', 3, 'This is a comment from Charlie on Image 3'),
('user04', 4, 'This is a comment from David on Image 4'),
('user05', 5, 'This is a comment from Eve on Image 5');

-- Insert data into Friendship table
INSERT INTO `friendship` (`Friend_RequesterId`, `Friend_RequesteeId`, `Status`) VALUES
('user01', 'user02', 'accepted'),
('user03', 'user04', 'request'),
('user05', 'user06', 'accepted'),
('user07', 'user08', 'request'),
('user09', 'user10', 'accepted');
