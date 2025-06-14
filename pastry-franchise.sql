-- MySQL dump 10.13  Distrib 8.4.4, for macos15 (arm64)
--
-- Host: localhost    Database: pastry-franchise
-- ------------------------------------------------------
-- Server version	8.4.4

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

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `expires_at` datetime GENERATED ALWAYS AS ((`created_at` + interval 15 day)) STORED,
  PRIMARY KEY (`id`),
  KEY `coupons_users_FK` (`user_id`),
  CONSTRAINT `coupons_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favourite_shops`
--

DROP TABLE IF EXISTS `favourite_shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favourite_shops` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `shop_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favourite_shops_shops_FK` (`shop_id`),
  KEY `favourite_shops_users_FK` (`user_id`),
  CONSTRAINT `favourite_shops_shops_FK` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favourite_shops_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favourite_shops`
--

LOCK TABLES `favourite_shops` WRITE;
/*!40000 ALTER TABLE `favourite_shops` DISABLE KEYS */;
/*!40000 ALTER TABLE `favourite_shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `shop_id` int DEFAULT NULL,
  `reservation_time` datetime DEFAULT NULL,
  `number_of_guests` int DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `shop_id` (`shop_id`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `shop_id` int DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `shop_id` (`shop_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shops` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `opens_at` time DEFAULT NULL,
  `closes_at` time DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
INSERT INTO `shops` VALUES (1,'So i čokolada','Čobanija 1','Sarajevo','062 878 310','08:00:00','22:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/cute.jpg'),(2,'Slastičarna Palma','Porodice Ribar 5','Sarajevo','033 714-700','08:00:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/palma-1.jpg'),(3,'Talks & Giggles','Hamdije Kreševljakovića 61','Sarajevo','062 945 148','10:00:00','22:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/talks-giggles-1.jpg'),(4,'Slastičarna Ramis','Sarači 1','Sarajevo','033 535-947','09:00:00','22:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/ramis-1.jpg'),(5,'Mrvica','Paromlinska 53h','Sarajevo','062 887 777','06:30:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/mrvica-1.jpg'),(6,'Slastičarna Egipat','Ferhadija 29','Sarajevo','033 237-287','09:00:00','21:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/egipat-1.jpg'),(7,'Aldi','Zagrebačka 6','Mostar','063 689 308','07:00:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/cute2.jpg'),(8,'Dolce & Co','Stari Most bb','Mostar','061 935 333','08:00:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/aaa1.jpg'),(9,'Egoist','Kralja Tvrtka 9','Mostar','036 311-200','09:00:00','22:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/egoist-1.jpg'),(10,'Slastičarna Dora','Kralja Tomislava 11','Mostar','036 342-807','06:30:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/dora-1.jpg'),(11,'Azzurro','Braće Fejića 19','Mostar','062 769 488','07:00:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/azzuro-1.jpg'),(12,'Slastičarna AS','Onešćukova BB','Mostar','063 689 310','09:00:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/aaa3.jpg'),(13,'Dolce Vita','Jevrejska 3','Banja Luka','065 346 349','07:00:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/cute3.jpg'),(14,'Sladoled kod Slavice','Prvog krajiškog korpusa 34','Banja Luka','065 099-199','08:00:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/sladoled-kod-slavice-1.jpg'),(15,'Slastičarna Kiki','Miloša Obilića 6','Banja Luka','065 095 199','08:00:00','22:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/kiki-1.jpg'),(16,'Plazma','Vojvode Radomira Putnika 15','Banja Luka','051 229 111','09:00:00','23:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/aaa2.jpg'),(17,'Mattino','Sime Matavulja 18','Banja Luka','064 238 529','10:00:00','21:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/mattino-1.jpg'),(18,'Medeno','Bulevar vojvode Stepe Stepanovića 80','Banja Luka','064 221 529','07:30:00','22:00:00','Welcome, your neighborhood pastry haven where tradition meets indulgence. Nestled in the heart of Sarajevo, our shop offers a cozy atmosphere filled with the rich aroma of freshly baked goods. We specialize in handcrafted pastries, from buttery croissants and fruit-filled tarts to decadent chocolate éclairs and signature baklava. Every item is made daily using locally sourced ingredients and time-honored recipes passed down through generations. Whether you\'re stopping in for your morning coffee and a warm pastry or picking up a custom cake for a celebration, you\'ll be met with friendly smiles and exceptional service.','assets/img/shops/medeno-1.jpg');
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `loyalty_points` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (25,'Pastry Admin','pastry.admin@admin.com','$2y$10$KfdEIahVemiCPsHirBurGOcgNLEDAU4bX3NwOpPFdNK8D51WNT6Fm','12345678','admin',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'pastry-franchise'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-14 18:41:47
