-- MySQL dump 10.16  Distrib 10.1.24-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: laravel_5-7
-- ------------------------------------------------------
-- Server version	10.1.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Turmeric Powder','turmeric_powder',1,'2019-10-05 16:00:00','2019-10-05 16:00:00'),(2,'Mango Pickle - Ashoka','mango_pickle_-_ashoka',3,'2019-10-05 16:00:00','2019-10-05 16:00:00'),(4,'Tea - Jivraj 9','tea_-_jivraj_9',2,'2019-10-05 16:00:00','2019-10-05 16:00:00'),(5,'Cabbage Kimchi','cabbage_kimchi',4,'2019-10-05 16:00:00','2019-10-05 16:00:00'),(6,'Ice Cream','ice_cream',5,'2019-10-05 16:00:16','2019-10-05 16:00:16'),(7,'Liquid Milk','liquid_milk',6,'2019-10-05 16:01:38','2019-10-05 16:01:38'),(8,'Pane Di Casa','pane_di_casa',7,'2019-10-05 16:04:10','2019-10-05 16:04:10'),(9,'Hamburger Buns','hamburger_buns',7,'2019-10-05 16:04:55','2019-10-05 16:04:55'),(10,'Pumpkin','pumpkin',8,'2019-10-08 02:52:25','2019-10-08 02:52:25'),(11,'Choc Chip Cookie','choc_chip_cookie',9,'2019-10-08 02:54:47','2019-10-08 02:54:47'),(12,'Asparagus','asparagus',8,'2019-10-08 02:55:20','2019-10-08 02:55:20'),(13,'Ruhi','ruhi',10,'2019-10-08 03:01:31','2019-10-08 03:01:31'),(14,'Shutki','shutki',11,'2019-10-08 03:01:57','2019-10-08 03:01:57'),(15,'Body Wash','body_wash',12,'2019-10-10 02:19:41','2019-10-10 02:19:41'),(16,'Egg','egg',13,'2019-10-10 02:30:04','2019-10-10 02:30:04'),(17,'Chewing Gum','chewing_gum',14,'2019-10-10 21:10:14','2019-10-10 21:10:14'),(18,'Orio Cookie','orio_cookie',9,'2019-10-10 21:12:02','2019-10-10 21:12:02'),(19,'Lindt Chocolate','lindt_chocolate',14,'2019-10-10 21:13:12','2019-10-10 21:13:12'),(20,'Hand Wash','hand_wash',12,'2019-10-10 21:16:41','2019-10-10 21:16:41'),(21,'Chicken Stock','chicken_stock',15,'2019-10-10 21:27:09','2019-10-10 21:27:09'),(22,'Jalapeno Sourdough Loaf','jalapeno_sourdough_loaf',7,'2019-10-10 21:29:33','2019-10-10 21:29:33'),(23,'Smith Chips','smith_chips',16,'2019-10-10 21:33:01','2019-10-10 21:33:01'),(30,'File Holder','file_holder',20,'2019-10-15 02:03:09','2019-10-15 02:03:09'),(31,'Salt','salt',21,'2019-10-19 02:08:54','2019-10-19 02:08:54'),(32,'Basil','basil',22,'2019-10-19 02:10:05','2019-10-19 02:10:05'),(33,'Fish Sauce','fish_sauce',23,'2019-10-19 02:13:03','2019-10-19 02:13:03'),(34,'Oyester Sauce','oyester_sauce',23,'2019-10-19 02:13:37','2019-10-19 02:13:37'),(35,'Orange','orange',24,'2019-10-19 02:28:12','2019-10-19 02:28:12'),(36,'Pear','pear',26,'2019-10-19 02:28:38','2019-10-19 02:28:38'),(37,'Watermelon','watermelon',25,'2019-10-19 02:28:48','2019-10-19 02:28:48'),(38,'Coriander','coriander',22,'2019-10-19 02:31:37','2019-10-19 02:31:37'),(39,'Mandarin','mandarin',24,'2019-10-19 02:33:55','2019-10-19 02:33:55'),(40,'Carrot','carrot',8,'2019-10-19 02:52:27','2019-10-19 02:52:27'),(41,'Grape','grape',27,'2019-10-19 02:55:13','2019-10-19 02:55:13'),(42,'Papaya','papaya',27,'2019-10-19 02:57:30','2019-10-19 02:57:30'),(43,'Green Bean','green_bean',8,'2019-10-19 03:04:11','2019-10-19 03:04:11'),(44,'Onion','onion',28,'2019-10-19 03:08:20','2019-10-19 03:08:20'),(45,'Male Fertility Supplement','male_fertility_supplement',29,'2019-10-19 12:31:16','2019-10-19 12:31:16'),(46,'Butter','butter',30,'2019-10-19 20:40:09','2019-10-19 20:40:09'),(47,'Chicken Kebab','chicken_kebab',31,'2019-10-19 20:50:32','2019-10-19 20:50:32'),(48,'Bike Rear Light','bike_rear_light',32,'2019-10-19 21:05:12','2019-10-19 21:05:12'),(49,'Sneaker','sneaker',33,'2019-10-19 21:26:12','2019-10-19 21:26:12'),(50,'Nandos','nandos',34,'2019-10-19 21:29:44','2019-10-19 21:29:44'),(51,'Bra','bra',35,'2019-10-19 21:44:11','2019-10-19 21:44:11'),(52,'Womens Belt','womens_belt',36,'2019-10-19 21:46:55','2019-10-19 21:46:55'),(53,'Womens Scarf','womens_scarf',36,'2019-10-19 21:47:51','2019-10-19 21:47:51'),(54,'Spinach','spinach',37,'2019-10-19 21:54:29','2019-10-19 21:54:29'),(55,'Spring Onion','spring_onion',37,'2019-10-19 21:54:41','2019-10-19 21:54:41'),(56,'Yellow Capsicum','yellow_capsicum',8,'2019-10-19 21:55:09','2019-10-19 21:55:09'),(57,'Haily Melon','haily_melon',25,'2019-10-19 21:55:41','2019-10-19 21:55:41'),(58,'Potato','potato',8,'2019-10-19 22:07:15','2019-10-19 22:07:15'),(59,'Colrabi','colrabi',8,'2019-10-19 22:07:32','2019-10-19 22:07:32'),(60,'Mushroom','mushroom',8,'2019-10-19 22:08:03','2019-10-19 22:08:03'),(61,'Apple','apple',26,'2019-10-19 22:08:15','2019-10-19 22:08:15'),(62,'Print','print',38,'2019-10-19 22:18:57','2019-10-19 22:18:57'),(63,'Zucchini','zucchini',8,'2019-10-19 22:22:39','2019-10-19 22:22:39'),(64,'Chuck On Bone','chuck_on_bone',39,'2019-10-19 23:10:32','2019-10-19 23:10:32'),(65,'Gravy Beef','gravy_beef',39,'2019-10-19 23:13:24','2019-10-19 23:13:24'),(66,'Casual Shoe Brown','casual_shoe_brown',40,'2019-10-19 23:59:14','2019-10-19 23:59:14'),(67,'Mango','mango',41,'2019-10-20 00:05:46','2019-10-20 00:05:46');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-20 22:37:07
