-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: taskmate_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,'admin@gmail.com','Admin logged in','2026-05-25 18:26:45'),(2,'admin@gmail.com','Profile Updated','2026-05-25 19:01:38'),(3,'admink@gmail.com','Profile Updated','2026-05-25 19:02:45'),(4,'admin@gmail.com','Profile Updated','2026-05-25 19:04:03'),(5,'admin@gmail.com','Profile Updated','2026-05-25 19:11:31');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_tasks`
--

DROP TABLE IF EXISTS `admin_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_tasks`
--

LOCK TABLES `admin_tasks` WRITE;
/*!40000 ALTER TABLE `admin_tasks` DISABLE KEYS */;
INSERT INTO `admin_tasks` VALUES (2,'Prepare Q3 Report','Detailed financial analysis',3,'Pending','2026-06-01','2026-05-26 19:41:06');
/*!40000 ALTER TABLE `admin_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_pinned` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (16,1,NULL,'Koko','Hi',0,'2026-05-30 17:28:24','2026-05-30 17:28:31'),(17,1,NULL,'lii','hhh',0,'2026-05-30 17:28:38','2026-05-30 17:28:41');
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `premium_requests`
--

DROP TABLE IF EXISTS `premium_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `premium_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `premium_requests`
--

LOCK TABLES `premium_requests` WRITE;
/*!40000 ALTER TABLE `premium_requests` DISABLE KEYS */;
INSERT INTO `premium_requests` VALUES (1,1,'kpay','223456','pending','2026-05-30 20:36:31'),(2,1,'kpay','223456','pending','2026-05-30 20:36:33'),(3,1,'kpay','223456','pending','2026-05-30 20:36:34'),(4,1,'kpay','223456','pending','2026-05-30 20:36:35'),(5,1,'kpay','223456','pending','2026-05-30 20:36:36'),(6,1,'kpay','234566','pending','2026-05-30 21:06:37'),(8,1,'kpay','111111','pending','2026-05-30 21:14:27'),(9,1,'kpay','111111','pending','2026-05-30 21:17:13'),(10,1,'kpay','111111','pending','2026-05-30 21:17:15'),(11,1,'kpay','111111','pending','2026-05-30 21:17:15'),(12,1,'kpay','111111','pending','2026-05-30 21:17:16'),(13,1,'kpay','111111','pending','2026-05-30 21:17:16'),(14,1,'kpay','111111','pending','2026-05-30 21:17:16'),(15,1,'kpay','111111','pending','2026-05-30 21:17:16'),(16,1,'kpay','111111','pending','2026-05-30 21:17:16'),(17,1,'wave','111111','pending','2026-05-30 21:20:56'),(18,1,'wave','111111','pending','2026-05-30 21:20:59'),(19,1,'wave','111111','pending','2026-05-30 21:20:59'),(20,1,'wave','111111','pending','2026-05-30 21:20:59'),(21,1,'wave','111111','pending','2026-05-30 21:20:59'),(22,1,'wave','111111','pending','2026-05-30 21:21:00'),(23,1,'wave','111111','pending','2026-05-30 21:21:00'),(24,1,'kpay','111111','pending','2026-05-30 21:25:23'),(25,1,'kpay','111111','pending','2026-05-30 21:30:52'),(26,1,'kpay','111111','pending','2026-05-30 21:36:14'),(27,26,'kpay','1234566','pending','2026-05-31 09:17:50'),(28,1,'kpay','111111','pending','2026-05-31 09:21:29'),(29,1,'kpay','111111','pending','2026-05-31 09:36:58'),(30,1,'kpay','111111','pending','2026-05-31 10:50:05'),(31,1,'kpay','111111','pending','2026-05-31 11:58:18'),(32,1,'kpay','111111','pending','2026-05-31 12:02:51'),(33,1,'kpay','111111','pending','2026-05-31 12:07:46'),(34,1,'kpay','111111','pending','2026-05-31 12:15:39'),(35,1,'kpay','111111','pending','2026-05-31 12:23:50'),(36,1,'kpay','111111','pending','2026-05-31 12:29:45'),(37,1,'kpay','111111','pending','2026-05-31 12:38:54'),(38,60,'kpay','258000','pending','2026-05-31 13:18:29'),(39,1,'kpay','111111','pending','2026-05-31 13:23:01'),(40,50,'kpay','123456','pending','2026-05-31 13:32:32'),(41,50,'kpay','111111','pending','2026-05-31 13:33:49'),(42,50,'kpay','111111','pending','2026-05-31 13:34:34'),(43,1,'kpay','111111','pending','2026-05-31 13:36:18'),(44,1,'kpay','111111','pending','2026-05-31 13:41:09'),(45,1,'kpay','111111a','pending','2026-05-31 13:42:22'),(46,1,'kpay','1','pending','2026-05-31 13:44:37'),(47,1,'kpay','11111','pending','2026-05-31 13:49:12'),(48,1,'wave','123456','pending','2026-05-31 14:53:34'),(49,1,'kpay','123456','pending','2026-05-31 15:03:20'),(50,1,'kpay','222222','pending','2026-05-31 15:07:11'),(51,51,'kpay','123456','pending','2026-05-31 15:08:23'),(52,50,'kpay','333221','pending','2026-05-31 15:14:11'),(53,50,'wave','333221','pending','2026-05-31 15:17:15'),(54,50,'kpay','133551','pending','2026-05-31 15:35:18'),(55,66,'wave','123456','pending','2026-06-01 11:58:33'),(56,66,'wave','123456','approved','2026-06-01 12:28:08'),(57,66,'kpay','111111','approved','2026-06-01 12:29:50');
/*!40000 ALTER TABLE `premium_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reminders`
--

DROP TABLE IF EXISTS `reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reminders` (
  `reminder_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `reminder_date` date NOT NULL,
  `reminder_time` time NOT NULL,
  `urgency_level` enum('high','medium') DEFAULT 'medium',
  `status` enum('active','completed') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_sent` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`reminder_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reminders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reminders`
--

LOCK TABLES `reminders` WRITE;
/*!40000 ALTER TABLE `reminders` DISABLE KEYS */;
INSERT INTO `reminders` VALUES (25,51,'ss',25,'2026-06-01','03:12:00','medium','active','2026-05-31 20:41:27',1);
/*!40000 ALTER TABLE `reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `study_planner`
--

DROP TABLE IF EXISTS `study_planner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `study_planner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `study_planner`
--

LOCK TABLES `study_planner` WRITE;
/*!40000 ALTER TABLE `study_planner` DISABLE KEYS */;
INSERT INTO `study_planner` VALUES (1,1,3,'ddd','2026-05-30 01:30:00','2026-05-30 02:30:00',0),(2,1,3,'ddd','2026-05-30 01:30:00','2026-05-30 02:30:00',0),(3,1,1,'Math Assignment','2026-05-30 02:30:00','2026-05-30 03:30:00',0),(4,1,3,'ddd','2026-05-30 01:30:00','2026-05-30 02:30:00',0),(5,1,3,'ddd','2026-05-30 05:30:00','2026-05-30 06:30:00',1),(6,1,1,'Math Assignment','2026-05-30 02:00:00','2026-05-30 03:00:00',0),(7,1,1,'Math Assignment','2026-05-30 08:30:00','2026-05-30 09:30:00',1),(8,30,6,'Maths Assignment','2026-05-30 05:30:00','2026-05-30 05:55:00',0),(9,30,6,'Maths Assignment','2026-05-30 05:30:00','2026-05-30 05:55:00',0),(10,30,6,'Maths Assignment','2026-05-30 07:00:00','2026-05-30 07:01:00',1),(11,30,6,'AA','2026-05-30 04:30:00','2026-05-30 04:55:00',1),(12,63,7,'Maths Assgn','2026-05-30 01:30:00','2026-05-30 01:55:00',1),(13,63,7,'Maths Assgn','2026-05-29 23:30:00','2026-05-29 23:31:00',0),(14,64,8,'Assignment','2026-05-30 04:30:00','2026-05-30 04:31:00',1),(15,64,8,'Assignment','2026-05-30 02:00:00','2026-05-30 02:01:00',1),(16,64,8,'Assignment','2026-05-30 01:00:00','2026-05-30 01:01:00',1),(17,64,8,'Assignment','2026-05-30 04:30:00','2026-05-30 04:31:00',1),(18,64,8,'sss','2026-05-30 01:30:00','2026-05-30 01:31:00',1),(19,1,3,'ddd','2026-05-31 02:30:00','2026-05-31 02:31:00',1),(20,1,3,'ddd','2026-05-31 02:30:00','2026-05-31 02:31:00',0),(21,1,3,'ddd','2026-05-31 01:30:00','2026-05-31 01:31:00',0);
/*!40000 ALTER TABLE `study_planner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `days` varchar(100) NOT NULL,
  `time_range` varchar(100) NOT NULL,
  `color_code` varchar(7) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,1,'Mathematics','Dr. Emily Carter','Mon, Wed, Fri','09:00 - 10:30 AM','#475BE8','2026-05-29 18:33:48'),(3,1,'IT Technology','Tchl CSK','Mon','6:00 - 7:30 PM','#283333','2026-05-29 19:30:21'),(6,30,'Maths','CSK','Monday','9:00 to 10:00 AM','#000000','2026-05-30 09:55:55'),(7,63,'Maths','Tchl CSK','Monday','10:00 to 12:00 am','#001cf0','2026-05-30 10:47:29'),(10,64,'s','s','s','s','#475BE8','2026-05-30 12:25:03'),(23,65,'Maths','FF','ff','ff','#475BE8','2026-05-30 17:27:45'),(24,51,'Maths','CSK','Monday','9:00 to 10:00','#0017c7','2026-05-31 17:10:54'),(25,51,'History','hh','hh','hh','#475BE8','2026-05-31 19:13:19');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(50) DEFAULT NULL,
  `config_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_key` (`config_key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,'allow_registration','true'),(2,'maintenance_mode','false');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `task_name` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `finished_at` datetime DEFAULT NULL,
  `priority` varchar(10) DEFAULT 'Medium',
  `deadline_date` date DEFAULT NULL,
  `deadline_time` time DEFAULT '09:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (74,0,NULL,'','Pending',1,'2026-05-27 19:16:54',NULL,'Medium',NULL,'09:00:00'),(75,1,NULL,'hi','Completed',1,'2026-05-27 19:16:54','2026-05-27 19:17:02','Medium',NULL,'09:00:00'),(76,0,NULL,'','Pending',1,'2026-05-27 19:20:31',NULL,'Medium',NULL,'09:00:00'),(79,31,NULL,'hhh','Completed',1,'2026-05-27 19:24:12','2026-05-27 19:24:13','Medium',NULL,'09:00:00'),(80,31,NULL,'hhhh','Completed',1,'2026-05-27 19:32:25','2026-05-28 02:25:07','Medium',NULL,'09:00:00'),(81,15,NULL,'ok','Completed',1,'2026-05-28 02:37:27','2026-05-28 02:42:33','Medium',NULL,'09:00:00'),(82,15,NULL,'oo','Completed',1,'2026-05-28 02:40:41','2026-05-28 03:15:59','Medium',NULL,'09:00:00'),(83,15,NULL,'22','Completed',1,'2026-05-28 03:07:37','2026-05-28 03:12:29','Low',NULL,'09:00:00'),(84,15,NULL,'yy','Completed',1,'2026-05-28 03:07:46','2026-05-28 03:15:57','High',NULL,'09:00:00'),(85,15,NULL,'uu','Completed',1,'2026-05-28 03:16:09','2026-05-28 03:16:13','Medium',NULL,'09:00:00'),(86,15,NULL,'hhh','Completed',1,'2026-05-28 03:19:15',NULL,'Low',NULL,'09:00:00'),(87,1,NULL,'maths','Completed',1,'2026-05-28 03:20:02',NULL,'Low',NULL,'09:00:00'),(88,1,NULL,'ko','Completed',1,'2026-05-28 03:27:02',NULL,'Medium',NULL,'09:00:00'),(89,1,NULL,'hh','Completed',1,'2026-05-28 03:27:11',NULL,'Low',NULL,'09:00:00'),(90,1,NULL,'gg','Completed',1,'2026-05-28 03:36:37',NULL,'Low',NULL,'09:00:00'),(91,1,NULL,'ss','Completed',1,'2026-05-28 03:36:47',NULL,'High',NULL,'09:00:00'),(92,1,NULL,'ggg','Completed',1,'2026-05-28 12:17:35',NULL,'Medium',NULL,'09:00:00'),(93,1,NULL,'ss','Completed',1,'2026-05-28 12:21:51',NULL,'Medium',NULL,'09:00:00'),(94,1,NULL,'uu','Completed',1,'2026-05-28 12:30:37',NULL,'Medium',NULL,'09:00:00'),(95,1,NULL,'sss','Pending',1,'2026-05-28 12:35:22','2026-05-28 12:47:57','Medium',NULL,'09:00:00'),(96,1,NULL,'sssss','Pending',1,'2026-05-28 12:50:25',NULL,'Medium',NULL,'09:00:00'),(97,1,NULL,'rr','Completed',1,'2026-05-28 13:44:49','2026-05-28 13:45:09','Medium',NULL,'09:00:00'),(98,1,NULL,'ee','Completed',1,'2026-05-28 13:44:51','2026-05-28 13:45:11','Medium',NULL,'09:00:00'),(99,1,NULL,'ee','Pending',1,'2026-05-28 13:44:53',NULL,'Medium',NULL,'09:00:00'),(100,1,NULL,'ee','Completed',1,'2026-05-28 13:44:54','2026-05-31 20:45:35','Medium',NULL,'09:00:00'),(101,1,NULL,'ee','Completed',1,'2026-05-28 13:44:58','2026-05-31 20:45:36','Medium',NULL,'09:00:00'),(102,1,NULL,'ee','Pending',1,'2026-05-28 13:45:01',NULL,'Medium',NULL,'09:00:00'),(103,1,NULL,'ii','Pending',1,'2026-05-28 13:45:19',NULL,'Medium',NULL,'09:00:00'),(104,1,NULL,'ii','Pending',1,'2026-05-28 13:45:20',NULL,'Medium',NULL,'09:00:00'),(105,1,NULL,'ii','Pending',1,'2026-05-28 13:45:21',NULL,'Medium',NULL,'09:00:00'),(106,1,NULL,'ii','Pending',1,'2026-05-28 13:45:22',NULL,'Medium',NULL,'09:00:00'),(107,1,NULL,'i','Pending',1,'2026-05-28 13:45:23',NULL,'Medium',NULL,'09:00:00'),(108,1,NULL,'i','Pending',1,'2026-05-28 13:45:25',NULL,'Medium',NULL,'09:00:00'),(109,1,NULL,'dd','Pending',1,'2026-05-28 13:51:57',NULL,'Medium',NULL,'09:00:00'),(110,1,NULL,'dd','Pending',1,'2026-05-28 13:51:59',NULL,'Medium',NULL,'09:00:00'),(111,1,NULL,'dd','Pending',1,'2026-05-28 13:52:01',NULL,'Medium',NULL,'09:00:00'),(112,1,NULL,'d','Pending',1,'2026-05-28 13:52:02',NULL,'Medium',NULL,'09:00:00'),(113,1,NULL,'ddd','Pending',1,'2026-05-28 13:52:04',NULL,'Medium',NULL,'09:00:00'),(114,1,NULL,'ss','Pending',1,'2026-05-28 13:53:06',NULL,'Medium',NULL,'09:00:00'),(115,1,NULL,'ss','Pending',1,'2026-05-28 13:53:08',NULL,'Medium',NULL,'09:00:00'),(116,1,NULL,'AA','Pending',1,'2026-05-28 13:53:11',NULL,'Medium',NULL,'09:00:00'),(117,1,NULL,'A','Pending',1,'2026-05-28 13:53:16',NULL,'Medium',NULL,'09:00:00'),(118,1,NULL,'Akmt','Pending',1,'2026-05-28 13:53:23',NULL,'Medium',NULL,'09:00:00'),(119,1,NULL,'dd','Pending',1,'2026-05-28 13:53:52',NULL,'Medium',NULL,'09:00:00'),(120,1,NULL,'dd','Pending',1,'2026-05-28 13:53:54',NULL,'Medium',NULL,'09:00:00'),(121,1,NULL,'hh','Pending',1,'2026-05-28 13:58:43',NULL,'Medium',NULL,'09:00:00'),(122,1,NULL,'hh','Pending',1,'2026-05-28 13:58:45',NULL,'Medium',NULL,'09:00:00'),(123,1,NULL,'hhh','Pending',1,'2026-05-28 13:58:48',NULL,'Medium',NULL,'09:00:00'),(124,1,NULL,'hh','Pending',1,'2026-05-28 13:58:49',NULL,'Medium',NULL,'09:00:00'),(125,1,NULL,'hh','Pending',1,'2026-05-28 13:58:50',NULL,'Medium',NULL,'09:00:00'),(126,1,NULL,'h','Pending',1,'2026-05-28 13:58:52',NULL,'Medium',NULL,'09:00:00'),(127,1,NULL,'hh','Pending',1,'2026-05-28 13:58:53',NULL,'Medium',NULL,'09:00:00'),(128,1,NULL,'ss','Completed',1,'2026-05-28 14:12:12','2026-05-28 14:15:08','Medium',NULL,'09:00:00'),(129,1,NULL,'ss','Pending',1,'2026-05-28 14:12:15',NULL,'Medium',NULL,'09:00:00'),(130,1,NULL,'ss','Pending',1,'2026-05-28 14:12:18',NULL,'Medium',NULL,'09:00:00'),(131,1,NULL,'ss','Pending',1,'2026-05-28 14:14:35',NULL,'Medium',NULL,'09:00:00'),(132,1,NULL,'ss','Pending',1,'2026-05-28 14:14:37',NULL,'Medium',NULL,'09:00:00'),(133,1,NULL,'ss','Pending',1,'2026-05-28 14:14:40',NULL,'Medium',NULL,'09:00:00'),(134,1,NULL,'ss','Pending',1,'2026-05-28 14:14:43',NULL,'Medium',NULL,'09:00:00'),(135,1,NULL,'ss','Pending',1,'2026-05-28 14:14:46',NULL,'Medium',NULL,'09:00:00'),(136,1,NULL,'ss','Pending',1,'2026-05-28 14:14:48',NULL,'Medium',NULL,'09:00:00'),(137,1,NULL,'ss','Pending',1,'2026-05-28 14:16:33',NULL,'Medium',NULL,'09:00:00'),(138,1,NULL,'ss','Pending',1,'2026-05-28 14:16:35',NULL,'Medium',NULL,'09:00:00'),(139,1,NULL,'aa','Pending',1,'2026-05-28 14:16:37',NULL,'Medium',NULL,'09:00:00'),(140,1,NULL,'ss','Pending',1,'2026-05-28 14:17:17',NULL,'Medium',NULL,'09:00:00'),(141,1,NULL,'ss','Pending',1,'2026-05-28 14:17:19',NULL,'Medium',NULL,'09:00:00'),(142,1,NULL,'ss','Pending',1,'2026-05-28 14:17:20',NULL,'Medium',NULL,'09:00:00'),(143,1,NULL,'ss','Pending',1,'2026-05-28 14:17:22',NULL,'Medium',NULL,'09:00:00'),(144,1,NULL,'kmt','Completed',1,'2026-05-28 14:20:23','2026-05-28 14:21:44','Medium',NULL,'09:00:00'),(145,1,NULL,'ss','Pending',1,'2026-05-28 14:20:27',NULL,'Medium',NULL,'09:00:00'),(146,1,NULL,'ss','Pending',1,'2026-05-28 14:20:30',NULL,'Medium',NULL,'09:00:00'),(147,1,NULL,'dd','Completed',1,'2026-05-28 14:20:34','2026-05-28 14:22:16','Medium',NULL,'09:00:00'),(148,1,NULL,'ee','Pending',1,'2026-05-28 14:20:39',NULL,'Medium',NULL,'09:00:00'),(149,1,NULL,'ss','Pending',1,'2026-05-28 14:21:36',NULL,'Medium',NULL,'09:00:00'),(150,1,NULL,'dd','Pending',1,'2026-05-28 14:29:41',NULL,'Medium',NULL,'09:00:00'),(151,1,NULL,'cc','Completed',1,'2026-05-28 14:31:48','2026-05-28 14:35:35','Medium',NULL,'09:00:00'),(152,1,NULL,'hh','Completed',1,'2026-05-28 14:35:10','2026-05-28 15:31:13','Medium',NULL,'09:00:00'),(153,1,NULL,'hh','Completed',1,'2026-05-28 14:35:11','2026-05-28 15:31:14','Medium',NULL,'09:00:00'),(154,1,NULL,'tt','Pending',1,'2026-05-28 14:35:14',NULL,'Medium',NULL,'09:00:00'),(155,1,NULL,'tt','Pending',1,'2026-05-28 14:35:16',NULL,'Medium',NULL,'09:00:00'),(156,1,NULL,'hh','Pending',1,'2026-05-28 14:35:57',NULL,'Medium',NULL,'09:00:00'),(157,1,NULL,'km','Pending',1,'2026-05-28 14:36:04',NULL,'Medium',NULL,'09:00:00'),(159,32,NULL,'hh','Pending',0,'2026-05-28 15:15:06',NULL,'Medium',NULL,'09:00:00'),(160,34,NULL,'hh','Completed',0,'2026-05-28 15:19:08','2026-05-28 15:19:45','Medium',NULL,'09:00:00'),(163,1,NULL,'dd','Pending',1,'2026-05-28 15:49:40',NULL,'Medium',NULL,'09:00:00'),(164,1,NULL,'kmj','Pending',1,'2026-05-28 15:50:05',NULL,'High',NULL,'09:00:00'),(165,1,NULL,'kk','Pending',1,'2026-05-28 15:50:10',NULL,'Low',NULL,'09:00:00'),(166,1,NULL,'hh','Pending',1,'2026-05-28 15:50:21',NULL,'Medium',NULL,'09:00:00'),(167,1,NULL,'hh','Completed',1,'2026-05-28 15:54:54','2026-05-28 15:54:57','Medium',NULL,'09:00:00'),(168,1,NULL,'j','Pending',1,'2026-05-28 17:22:44',NULL,'Medium',NULL,'09:00:00'),(169,1,NULL,'yy','Pending',1,'2026-05-28 17:22:46',NULL,'Medium',NULL,'09:00:00'),(170,1,NULL,'yy','Pending',1,'2026-05-28 17:22:47',NULL,'Medium',NULL,'09:00:00'),(171,1,NULL,'yy','Pending',1,'2026-05-28 17:22:50',NULL,'Medium',NULL,'09:00:00'),(172,50,NULL,'hh','Completed',0,'2026-05-28 19:30:01','2026-05-28 19:30:05','Medium',NULL,'09:00:00'),(173,1,NULL,'dd','Pending',1,'2026-05-29 01:03:06',NULL,'Medium',NULL,'09:00:00'),(174,1,NULL,'hhhhhh','Pending',1,'2026-05-29 01:04:21',NULL,'Medium',NULL,'09:00:00'),(175,1,NULL,'77','Pending',1,'2026-05-29 01:15:13',NULL,'Medium','2026-05-29','09:00:00'),(176,1,NULL,'hh','Pending',1,'2026-05-29 01:15:26',NULL,'Low','2026-05-30','09:00:00'),(177,1,NULL,'gg','Pending',1,'2026-05-29 01:15:41',NULL,'Low','2026-05-29','09:00:00'),(178,1,NULL,'uu','Pending',1,'2026-05-29 01:18:26',NULL,'Medium','2026-05-29','09:00:00'),(179,1,NULL,'ff','Pending',1,'2026-05-29 01:19:06',NULL,'Medium','2026-05-29','09:00:00'),(180,1,NULL,'kmy','Pending',1,'2026-05-29 01:20:31',NULL,'Medium','2026-05-29','09:00:00'),(181,1,NULL,'hh','Pending',1,'2026-05-29 01:23:15',NULL,'Medium','0000-00-00','09:00:00'),(182,1,NULL,'hhh','Pending',1,'2026-05-29 01:23:21',NULL,'Medium','2026-05-30','09:00:00'),(183,1,NULL,'yyy','Pending',1,'2026-05-29 01:23:48',NULL,'Medium','0000-00-00','09:00:00'),(184,1,NULL,'yy','Pending',1,'2026-05-29 01:25:52',NULL,'Medium','2026-05-30','09:00:00'),(185,1,NULL,'yy','Pending',1,'2026-05-29 01:27:56',NULL,'Low','0000-00-00','09:00:00'),(186,1,NULL,'yy','Pending',1,'2026-05-29 01:29:43',NULL,'Medium','2026-05-31','09:00:00'),(187,1,NULL,'yy','Pending',1,'2026-05-29 01:33:00',NULL,'Medium','2026-05-31','09:00:00'),(188,1,NULL,'mathsssss','Pending',1,'2026-05-29 01:33:14',NULL,'Low','2026-05-31','09:00:00'),(189,1,NULL,'hhhh','Pending',1,'2026-05-29 01:34:48',NULL,'Low','2026-05-31','09:00:00'),(190,1,NULL,'gg','Pending',1,'2026-05-29 02:04:38',NULL,'Medium','2026-05-31','09:00:00'),(191,1,NULL,'jj','Pending',1,'2026-05-29 02:22:48',NULL,'Medium','0000-00-00','09:00:00'),(192,1,NULL,'hh','Completed',1,'2026-05-29 02:28:49','2026-05-29 02:45:24','Medium','2026-05-31','09:00:00'),(193,1,NULL,'ss','Pending',1,'2026-05-29 02:47:44',NULL,'Medium','0000-00-00','09:00:00'),(194,1,NULL,'ss','Pending',1,'2026-05-29 02:47:46',NULL,'Medium','0000-00-00','09:00:00'),(195,1,NULL,'gg','Completed',1,'2026-05-29 03:11:10','2026-05-29 03:29:45','Medium','2026-06-01','09:00:00'),(196,1,NULL,'Maths Asisgnment','Pending',1,'2026-05-29 03:35:18',NULL,'High','2026-05-30','09:00:00'),(197,1,NULL,'Englis Tuto','Completed',1,'2026-05-29 03:35:27','2026-05-29 03:37:29','Medium','2026-05-30','09:00:00'),(198,1,NULL,'Practical','Pending',1,'2026-05-29 03:35:38',NULL,'High','2026-05-31','09:00:00'),(199,1,NULL,'Assignment','Pending',1,'2026-05-29 03:35:48',NULL,'High','2026-05-30','09:00:00'),(200,1,NULL,'Reading','Pending',1,'2026-05-29 03:36:00',NULL,'Low','2026-05-31','09:00:00'),(201,1,NULL,'Spekaing','Completed',1,'2026-05-29 03:36:08','2026-05-29 03:36:36','Low','2026-05-30','09:00:00'),(202,1,NULL,'Presnetation','Completed',1,'2026-05-29 03:36:18','2026-05-29 03:36:35','High','2026-05-31','09:00:00'),(203,1,NULL,'Lab','Completed',1,'2026-05-29 03:36:32','2026-05-29 03:36:34','High','0000-00-00','09:00:00'),(204,1,NULL,'Skill','Pending',1,'2026-05-29 03:36:50',NULL,'High','2026-05-31','09:00:00'),(205,1,NULL,'Exam','Pending',1,'2026-05-29 03:37:25',NULL,'Medium','2026-05-31','09:00:00'),(206,1,NULL,'tt','Pending',1,'2026-05-29 03:42:46',NULL,'Medium','2026-05-31','09:00:00'),(207,1,NULL,'Maths','Completed',1,'2026-05-29 15:22:56','2026-05-29 15:23:08','Medium','2026-05-31','09:00:00'),(208,1,NULL,'English','Pending',1,'2026-05-29 15:23:05',NULL,'High','2026-05-31','09:00:00'),(209,1,NULL,'ddd','Pending',1,'2026-05-29 15:39:37',NULL,'Medium','2026-05-31','09:00:00'),(210,1,NULL,'hh','Pending',1,'2026-05-29 15:59:30',NULL,'Medium','2026-05-31','09:00:00'),(211,15,NULL,'oo','Pending',1,'2026-05-29 17:03:43',NULL,'Medium','2026-05-31','09:00:00'),(212,15,NULL,'dddd','Pending',1,'2026-05-29 17:11:20',NULL,'Medium','2026-05-29','09:00:00'),(213,15,NULL,'ssss','Pending',1,'2026-05-29 17:11:33',NULL,'Medium','2026-05-29','09:00:00'),(214,15,NULL,'sss','Pending',1,'2026-05-29 17:11:40',NULL,'Medium','2026-05-29','09:00:00'),(215,15,NULL,'ddd','Pending',1,'2026-05-29 17:17:16',NULL,'High','2026-05-29','09:00:00'),(216,15,NULL,'kmyy','Pending',1,'2026-05-29 17:17:45',NULL,'Medium','2026-05-28','09:00:00'),(217,15,NULL,'dd','Completed',1,'2026-05-29 17:19:00','2026-05-29 17:19:13','Medium','2026-05-29','09:00:00'),(218,15,NULL,'aaa','Pending',1,'2026-05-29 17:19:38',NULL,'Medium','0000-00-00','09:00:00'),(219,15,NULL,'ddd','Pending',1,'2026-05-29 17:26:15',NULL,'Medium','2026-05-31','09:00:00'),(220,59,NULL,'lwinn','Pending',1,'2026-05-29 17:27:59',NULL,'High','2026-05-29','09:00:00'),(221,59,NULL,'li','Completed',1,'2026-05-29 17:28:12','2026-05-29 17:28:15','Medium','2026-05-29','09:00:00'),(222,59,NULL,'lwinn','Pending',1,'2026-05-29 17:32:05',NULL,'Medium','2026-05-29','09:00:00'),(223,59,NULL,'yy','Completed',1,'2026-05-29 17:37:26','2026-05-29 18:18:35','High','2026-05-30','09:00:00'),(224,59,NULL,'oo','Completed',1,'2026-05-29 17:49:10','2026-05-29 18:18:36','Medium','2026-05-30','09:00:00'),(225,59,NULL,'tt','Completed',1,'2026-05-29 18:10:13','2026-05-29 18:18:34','High','2026-05-29','09:00:00'),(226,59,NULL,'yyyyy','Completed',1,'2026-05-29 18:18:02','2026-05-29 18:18:12','Medium','2026-05-29','09:00:00'),(227,59,NULL,'aa','Pending',0,'2026-05-29 18:18:53',NULL,'Medium','2026-05-29','09:00:00'),(228,59,NULL,'aaa','Pending',1,'2026-05-29 18:19:56',NULL,'Medium','0000-00-00','09:00:00'),(229,59,NULL,'aa','Completed',0,'2026-05-29 18:20:01','2026-05-29 18:24:36','Medium','2026-05-29','09:00:00'),(230,59,NULL,'oo','Pending',1,'2026-05-29 18:20:26',NULL,'Medium','0000-00-00','09:00:00'),(231,59,NULL,'aa','Pending',1,'2026-05-29 18:24:33',NULL,'Medium','2026-05-29','09:00:00'),(232,59,NULL,'aaa','Pending',0,'2026-05-29 18:25:02',NULL,'Medium','2026-05-29','09:00:00'),(233,59,NULL,'ok','Pending',0,'2026-05-29 18:39:51',NULL,'Medium','2026-05-30','09:00:00'),(234,59,NULL,'hi','Pending',0,'2026-05-29 18:40:08',NULL,'Medium','2026-05-31','09:00:00'),(235,59,NULL,'iii','Completed',0,'2026-05-29 18:40:17','2026-05-29 19:02:21','Medium','2026-06-01','09:00:00'),(236,59,NULL,'ooo','Completed',0,'2026-05-29 18:40:22','2026-05-29 19:02:22','Medium','2026-06-02','09:00:00'),(237,59,NULL,'ooo','Completed',0,'2026-05-29 18:40:32','2026-05-29 19:02:20','Medium','2026-06-03','09:00:00'),(238,59,NULL,'ok','Pending',0,'2026-05-29 19:02:34',NULL,'Medium','2026-05-29','09:00:00'),(239,1,NULL,'ddd','Pending',1,'2026-05-29 19:43:22',NULL,'High','2026-05-30','09:00:00'),(240,1,NULL,'rr','Pending',1,'2026-05-29 19:44:01',NULL,'Medium','2026-05-29','09:00:00'),(241,1,NULL,'ss','Pending',1,'2026-05-29 19:47:06',NULL,'Medium','2026-05-29','09:00:00'),(242,1,NULL,'sss','Pending',1,'2026-05-29 19:49:54',NULL,'Medium','2026-05-29','09:00:00'),(243,1,NULL,'ss','Pending',1,'2026-05-29 20:02:09',NULL,'Medium','2026-05-29','22:03:00'),(244,1,NULL,'KMTTTT','Pending',1,'2026-05-29 20:03:29',NULL,'High','2026-05-30','22:03:00'),(245,1,NULL,'gg','Pending',1,'2026-05-29 20:31:44',NULL,'Medium','2026-05-29','21:31:00'),(246,1,NULL,'huii','Pending',0,'2026-05-29 21:08:11',NULL,'High','2026-05-30','22:07:00'),(247,1,NULL,'aaa','Pending',0,'2026-05-29 21:08:38',NULL,'Medium','2026-05-30','23:13:00'),(248,1,NULL,'ff','Pending',0,'2026-05-29 21:09:01',NULL,'Medium','2026-05-29','12:08:00'),(249,1,NULL,'ll','Pending',0,'2026-05-29 21:09:12',NULL,'Medium','2026-06-02','15:09:00'),(250,1,NULL,'ttt','Pending',0,'2026-05-29 21:09:25',NULL,'Medium','2026-05-30','22:09:00'),(252,1,NULL,'ddd','Pending',1,'2026-05-29 21:10:20',NULL,'Medium','2026-05-30','15:10:00'),(255,60,NULL,'hihi','Pending',0,'2026-05-29 22:46:59',NULL,'High','2026-05-30','16:46:00'),(256,60,NULL,'hehe','Pending',0,'2026-05-29 22:47:15',NULL,'High','2026-05-30','22:53:00'),(257,60,NULL,'hhh','Pending',0,'2026-05-29 22:49:32',NULL,'Medium','2026-05-29','15:49:00'),(258,60,NULL,'ddd','Completed',0,'2026-05-29 22:49:44','2026-05-31 20:48:01','Medium','2026-05-30','22:54:00'),(259,1,1,'Math Assignment','Completed',1,'2026-05-30 02:06:59','2026-05-31 20:45:27','High','2026-05-30','06:10:00'),(260,1,3,'ddd','Completed',1,'2026-05-30 02:21:18','2026-05-31 20:45:24','Medium','2026-05-30','08:21:00'),(264,61,4,'hhh','Pending',0,'2026-05-30 02:50:13',NULL,'High','2026-05-31','02:53:00'),(265,61,4,'gggg','Pending',0,'2026-05-30 02:51:31',NULL,'High','2026-05-31','08:51:00'),(266,61,NULL,'kk','Pending',0,'2026-05-30 02:51:55',NULL,'High','2026-05-31','02:56:00'),(269,63,7,'Maths Assgn','Pending',0,'2026-05-30 17:17:50',NULL,'High','2026-05-31','22:17:00'),(270,63,7,'Mathssss','Completed',0,'2026-05-30 17:18:04','2026-05-30 17:18:07','Medium','2026-05-30','23:18:00'),(271,64,8,'Assignment','Pending',0,'2026-05-30 17:31:20',NULL,'High','2026-05-30','23:31:00'),(272,64,NULL,'hhh','Completed',0,'2026-05-30 17:32:17','2026-05-30 17:32:19','Medium','2026-05-30','18:32:00'),(273,64,8,'fff','Pending',0,'2026-05-30 18:08:51',NULL,'Medium','2026-05-30','18:12:00'),(274,64,8,'fff','Pending',0,'2026-05-30 18:09:02',NULL,'High','2026-04-30','18:10:00'),(275,64,NULL,'fff','Pending',0,'2026-05-30 18:09:11',NULL,'High','2026-05-31','22:09:00'),(276,64,8,'ddd','Pending',0,'2026-05-30 18:09:29',NULL,'High','2026-05-31','18:15:00'),(277,64,8,'ddd','Completed',0,'2026-05-30 18:09:39','2026-05-30 18:13:01','High','2026-05-31','18:14:00'),(278,64,8,'sss','Completed',0,'2026-05-30 18:09:50','2026-05-30 18:13:00','High','2026-05-31','12:09:00'),(279,64,8,'sss','Completed',0,'2026-05-30 18:09:58','2026-05-30 18:13:00','High','2026-05-31','12:09:00'),(280,51,24,'Hi','Pending',0,'2026-05-31 23:41:21',NULL,'High','2026-05-31','16:41:00');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `study_year` varchar(50) DEFAULT '1st Year',
  `avatar` varchar(255) DEFAULT NULL,
  `account_type` varchar(20) DEFAULT 'normal',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `focus_time` int(11) DEFAULT 25,
  `break_time` int(11) DEFAULT 5,
  `alarm_sound` varchar(100) DEFAULT 'classic_bell',
  `theme_mode` varchar(20) DEFAULT 'light',
  `telegram_chat_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'minthant','Koko','STU-002','ww','Final Year','user_1_1780157439.jpg','free','maungkaungminthant@gmail.com','$2y$10$c7sIx.0jVBhm6Z5KUvjyyuTwtrmukNiueYU0/zBLrqPoHCX/9WSIS','2026-05-24 10:22:00','user',0,'1779781146_k.jpg','active','2026-06-01 22:31:39',1,1,'classic_bell','light','8340253941'),(3,'kmt',NULL,NULL,NULL,'1st Year',NULL,'normal','kmt@gmail.com','$2y$10$hXCofZPd7WsoDxef7VvnmOwSyA4cyBB7ycAvtYawJWPaXx6/s9IBW','2026-05-24 10:38:14','user',1,NULL,'active','2026-05-26 11:04:20',25,5,'classic_bell','light',NULL),(7,'yuta',NULL,NULL,NULL,'1st Year',NULL,'normal','y@gmail.com','$2y$10$NPYNnNzkCKBEA/1quxymk.656uenP9V6jrdtALtqvD0XlpAdXfL6.','2026-05-24 14:53:28','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(8,'k',NULL,NULL,NULL,'1st Year',NULL,'normal','k@gmail.com','$2y$10$Xp7cqavhuuyNHj.AOe04VeTcKruOeU3g6.//0SVNEc4OZeV0SabgG','2026-05-24 15:04:08','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(10,'kitty',NULL,NULL,NULL,'1st Year',NULL,'normal','kitty@gmail.com','$2y$10$fFzFOZXFMfSH8ddWvQoYVO5HPzYs5QuZVpnpvggg.GdqWMrKVu1Zi','2026-05-24 15:08:00','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(11,'aa',NULL,NULL,NULL,'1st Year',NULL,'normal','ohh@gmail.com','$2y$10$P7W11exKefhmkNGzjn8QMe.7Rjnufki2jbOZee3K.g0o3Q/dNdnry','2026-05-24 15:09:09','admin',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(12,'minthant',NULL,NULL,NULL,'1st Year',NULL,'free','aa@gmail.com','$2y$10$itjE1vP7se/WMKtYHqfSh.y68mPrjvyX6w5cMZj4hQgmUQgLVwBo6','2026-05-24 15:12:42','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(14,'K',NULL,NULL,NULL,'1st Year',NULL,'normal','admin@gmail.com','$2y$10$3dVwUUwZ8tBAX5ECjJTABe8e6i7U7tNQSNcVqLjMun0SFbrESoWb2','2026-05-25 09:51:08','admin',0,'1779777608_k.jpg','active','2026-05-29 07:07:41',25,5,'classic_bell','light',NULL),(15,'Lwin',NULL,NULL,NULL,'1st Year',NULL,'normal','lwin@gmail.com','$2y$10$83nGfyMoVBlCAZCUvu5wx.BIY61gt.OlXfLkihdFrP3P3bxYFxz5u','2026-05-25 09:59:24','user',1,NULL,'active','2026-05-30 23:35:27',25,5,'classic_bell','light',NULL),(25,'Admin One',NULL,NULL,NULL,'1st Year',NULL,'normal','admin1@gmail.com','$2y$10$x702w5JmBFpmUYtN8sLPP.dDfSkIbcrKEBGZTXhrhSMT/Ymo.yycS','2026-05-25 18:40:52','admin',0,NULL,'active','2026-05-31 15:17:16',25,5,'classic_bell','light',NULL),(26,'Admin Two',NULL,NULL,NULL,'1st Year',NULL,'normal','admin2@gmail.com','$2y$10$x702w5JmBFpmUYtN8sLPP.dDfSkIbcrKEBGZTXhrhSMT/Ymo.yycS','2026-05-25 18:40:52','admin',0,'1779960435_kmt.jpg','active','2026-06-01 13:57:41',25,5,'classic_bell','light',NULL),(27,'Admin Three',NULL,NULL,NULL,'1st Year',NULL,'normal','admin3@gmail.com','$2y$10$x702w5JmBFpmUYtN8sLPP.dDfSkIbcrKEBGZTXhrhSMT/Ymo.yycS','2026-05-25 18:40:52','admin',0,'1779781233_k.jpg','active','2026-05-29 07:15:42',25,5,'classic_bell','light',NULL),(29,'kmt',NULL,NULL,NULL,'1st Year',NULL,'normal','ky@gmail.com','$2y$10$rxVztyYlGnjzaEHsvaIe7e6T057s3ak4C.CU1mJ03dxDSI2SKcnNi','2026-05-25 20:51:29','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(30,'MT Lwinn',NULL,NULL,NULL,'1st Year','user_30_1780150027.jpg','normal','lwinnx@gmail.com','$2y$10$uXGxJ5kpMy1okGrglGz.Vez/qxJsLDoXbPM4MMmG.aiyY0fbhlmhu','2026-05-27 12:11:48','user',0,NULL,'active','2026-05-30 15:57:11',25,5,'classic_bell','light',NULL),(31,'ako',NULL,NULL,NULL,'1st Year',NULL,'normal','ako@gmail.com','$2y$10$T6CucJbnaoNa/7YPsw6w5ORCOm0sv5qR32Q8wIkrQtE3tZQsSZIZi','2026-05-27 12:53:32','user',0,NULL,'active','2026-05-27 14:54:08',25,5,'classic_bell','light',NULL),(32,'thantk',NULL,NULL,NULL,'1st Year',NULL,'normal','kk@gmail.com','$2y$10$UtSpUBkYD6/trCWNxyeMLusWyuP18TEGMM6cTO/F9Gs0Hz/usCN/2','2026-05-28 08:44:45','user',0,NULL,'active','2026-05-28 10:44:58',25,5,'classic_bell','light',NULL),(34,'Yuuta',NULL,NULL,NULL,'1st Year',NULL,'free','yy@gmail.com','$2y$10$h3jinCXms/kdtM3ZlrVWTuQy44sOLst8k2lG3GnSy3HpUkiks4OSa','2026-05-28 08:48:31','user',0,NULL,'active','2026-05-28 10:48:52',25,5,'classic_bell','light',NULL),(35,'OKOK',NULL,NULL,NULL,'1st Year',NULL,'normal','ok@gmail.c','$2y$10$yJia.BLKsZjTv34Rz4a1heeBZjycT20S5uiw3C./W.hg1RPsECtTS','2026-05-28 09:36:53','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(37,'OKOK',NULL,NULL,NULL,'1st Year',NULL,'normal','ok@gmail.cb','$2y$10$6oJgwc/ycoO0i7su66xSP.fWZ9dSDOFgiFVOy1.PjqGItK8x.uOyG','2026-05-28 09:39:09','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(38,'Okk',NULL,NULL,NULL,'1st Year',NULL,'normal','ok@gmail.co','$2y$10$1Vc8ZsTV57dN3dgkpsJjM.7wdIvSqHRUdJRalRKzz4gOyW5/9rfaa','2026-05-28 09:43:45','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(39,'okkk',NULL,NULL,NULL,'1st Year',NULL,'normal','okk@gmail.co','$2y$10$cjsbzhGPPpyLNOICeazBXe2h00SLzKfzUDgpzkfp9UdN8mKKbUWP6','2026-05-28 09:45:44','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(41,'okkk',NULL,NULL,NULL,'1st Year',NULL,'normal','okk@gmail.cx','$2y$10$fb/dWTuVq0z57Wchl3JduuYOZwBYEwwNjbwbbK/tBVVzetHSZJSEO','2026-05-28 09:49:09','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(48,'KKK',NULL,NULL,NULL,'1st Year',NULL,'normal','okk@gmail.com','$2y$10$avJFNU85kIQO8NZ0hPW6oOmD4kXPR/jr4cX8cX86Zrukl.doeEbdm','2026-05-28 10:01:26','user',0,NULL,'active','2026-05-28 12:01:39',25,5,'classic_bell','light',NULL),(49,'kmt',NULL,NULL,NULL,'1st Year',NULL,'normal','kmtk@gmail.com','$2y$10$.RmX3T7mdvP9yNK43RsdouzXlzAMVpRAuAyHJjW5MNfhmyqJaX4Ge','2026-05-28 12:57:36','user',0,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(50,'haha',NULL,NULL,NULL,'1st Year',NULL,'free','haha@gmail.com','$2y$10$NIBV92pKEGB.G5/EJvdaYeg5vvUY5zOTYKKpn7J3E9EgaPNy8tHbq','2026-05-28 12:59:20','user',0,NULL,'active','2026-05-31 19:02:52',25,5,'classic_bell','light','1810378199'),(51,'hehe',NULL,NULL,NULL,'1st Year',NULL,'pending','hehe@gmail.com','$2y$10$kz9bCRQ83J1WqaACDCUdB.OeOH781QH4JDgcwvS20jKoBSNAc1P.e','2026-05-28 13:04:33','user',1,NULL,'active','2026-05-31 19:03:03',25,5,'classic_bell','light','5722423964'),(52,'fff',NULL,NULL,NULL,'1st Year',NULL,'normal','f@gmail.com','$2y$10$z.NoEsYNALKWxeUFDik/COpNsJWCPr1DWG9m2Gz0rpmO7ArtOYyeW','2026-05-28 13:05:08','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(54,'fff',NULL,NULL,NULL,'1st Year',NULL,'normal','ff@gmail.com','$2y$10$IhekOvycG4GXqdoCOfaBJ.XPp2Cw2Su6/HmGHhe0vDVCgIZSj41Hm','2026-05-28 13:05:18','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(56,'fff',NULL,NULL,NULL,'1st Year',NULL,'normal','fff@gmail.com','$2y$10$3178tVmuh6rQriY43D.KPesaxJr1iDxYOSxoiNlzpIdCIWpPxLqTa','2026-05-28 13:05:28','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(57,'fff',NULL,NULL,NULL,'1st Year',NULL,'normal','ffff@gmail.com','$2y$10$qkOdU8KCCRrF4WU0A0fi6OiB3jxF43rsrn3NqfykuylrKd8QdKOqW','2026-05-28 13:06:11','user',1,NULL,'active',NULL,25,5,'classic_bell','light',NULL),(58,'kkk',NULL,NULL,NULL,'1st Year',NULL,'normal','koko@gmail.com','$2y$10$mPexEGDju1I5FmeAngn0det8hBaGhurOPJm609qGqK6wC3Rt2UDXu','2026-05-29 10:06:44','user',0,NULL,'active','2026-05-29 12:07:04',25,5,'classic_bell','light',NULL),(59,'lll',NULL,NULL,NULL,'1st Year',NULL,'normal','li@gmail.com','$2y$10$SvsturgjIgtYsCl3aDNYv.K1znHFBZZL34y0O/YhE0xXVHPmYbOze','2026-05-29 10:57:32','user',0,NULL,'active','2026-05-29 12:57:40',25,5,'classic_bell','light',NULL),(60,'hihi',NULL,NULL,NULL,'1st Year',NULL,'premium','hihi@gmail.com','$2y$10$GhtRRWfLJabcM.9xc.R3TOY9NuQ07MuRIcupVbUvjBrUZ5NuANiv6','2026-05-29 16:15:24','user',0,NULL,'active','2026-05-31 17:08:11',25,5,'classic_bell','light',NULL),(61,'llll',NULL,NULL,NULL,'1st Year',NULL,'normal','m@gmail.com','$2y$10$yzesKRg3//32Is2rP3srWOrxtDRQHwdmPWUliPl4TIdmJLaWSpgVa','2026-05-29 20:00:52','user',0,NULL,'active','2026-05-29 22:01:02',25,5,'classic_bell','light',NULL),(62,'Chawsu',NULL,NULL,NULL,'1st Year',NULL,'normal','chawsu@gmail.com','$2y$10$.qZPbZFvpbcqQ7QyRenH5engWjQgCCzZCvsumIqOj3O2BAc2DIQIO','2026-05-30 10:09:04','user',0,NULL,'active','2026-05-30 12:09:17',25,5,'classic_bell','light',NULL),(63,'komay',NULL,NULL,NULL,'1st Year',NULL,'normal','komay@gmail.com','$2y$10$Kw28SIAakLkLQwBm6Co6w.KzCK01bY/00i2Ao2e0BcwTuywohfnlS','2026-05-30 10:46:31','admin',0,NULL,'active','2026-05-30 12:46:39',25,5,'classic_bell','light',NULL),(64,'koooo',NULL,NULL,NULL,'1st Year',NULL,'normal','ku@gmail.com','$2y$10$cgtbmdwQl6H5.LtY8CNfHe8AV0R2yx5goD58ZhhY/GCayv1e5bhM6','2026-05-30 11:00:35','user',1,NULL,'active','2026-05-30 13:00:42',25,5,'classic_bell','light',NULL),(65,'xxx',NULL,NULL,NULL,'1st Year','user_65_1780161610.jpg','normal','x@gmail.com','$2y$10$I8LetGKTX.s.fNG2PmMnPedzlGiF0couQCoS7FsQ303WdmlU3b.tO','2026-05-30 16:12:42','user',0,NULL,'active','2026-05-30 18:45:43',25,5,'classic_bell','light',NULL),(66,'Yuuta',NULL,NULL,NULL,'1st Year',NULL,'premium','yuta@gmail.com','$2y$10$UWGg9l6iVOKdQHvE2rDr..Ml3LhYWNkX9KvIgm0AwZn87NhRx5WMy','2026-06-01 11:57:16','user',0,NULL,'active','2026-06-01 13:58:01',25,5,'classic_bell','light',NULL);
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

-- Dump completed on 2026-06-02 22:56:58
