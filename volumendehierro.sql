-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: volumendehierro
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asistencia` (
  `id_asistencia` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `nombre_clientes` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellido_cliente` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `clase` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dia` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `hora` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_asistencia`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencia`
--

LOCK TABLES `asistencia` WRITE;
/*!40000 ALTER TABLE `asistencia` DISABLE KEYS */;
INSERT INTO `asistencia` VALUES (18,6,'Felipe','Moreno','Yoga','2025-09-18 14:10:38','Lunes','8:00 AM'),(19,6,'Felipe','Moreno','Yoga','2025-09-18 14:10:58','Martes','8:00 PM'),(23,6,'Felipe','Moreno','Zumba','2025-09-18 16:14:08','Miércoles','8:00 PM'),(24,6,'Felipe','Moreno','Cardio Dance','2025-09-18 16:14:16','Jueves','8:00 AM'),(25,6,'Felipe','Moreno','Crossfit','2025-09-18 16:14:25','Viernes','8:00 AM'),(26,6,'Felipe','Moreno','Cardio Dance','2025-09-18 16:14:35','Sábado','6:00 AM'),(27,2,'Elvia','Martinez ','Spinning','2025-09-18 16:17:07','Lunes','6:00 AM'),(28,2,'Elvia','Martinez ','Spinning','2025-09-18 16:17:18','Martes','6:00 PM'),(29,2,'Elvia','Martinez ','Zumba','2025-09-18 16:17:28','Miércoles','8:00 PM'),(30,2,'Elvia','Martinez ','Cardio Dance','2025-09-18 16:17:38','Jueves','8:00 AM');
/*!40000 ALTER TABLE `asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('M','F','Otro') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_registro` date DEFAULT (curdate()),
  `estado` tinyint(1) DEFAULT '1',
  `tipo_cedula` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `cedula` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Andrey ','Quintero Loaiza','andrey125@gmail.com','$2y$10$Q6LBwnhHsgsDKiNznhbLxOzYRp5q/m27Hk2YyzGKTzmxG9zG8juAW','3587897',NULL,'M','2025-09-12',1,'CC','1036259'),(2,'Elvia','Martinez ','elviam@gmail.com','$2y$10$oXspX.5IiLw2axNX4lxXzeTqUqza4Vw7fJw0tAxWD/5GA7IS6y7wq','3145257888',NULL,NULL,'2025-09-15',1,'CC','43715'),(4,'Camilo','Cifuentes','camic@gmail.com','$2y$10$.kSeOSSPwiLkkwadzYjXYeRi6t9ielV8zp9LG64wseJUertWL8l7C','648572',NULL,NULL,'2025-09-15',1,'CC','43678'),(6,'Felipe','Moreno','felipem@gmail.com','$2y$10$sAR4Y1NTWHCT3SvkxLm4sejJRIL6gdWwzpdW0cebmDWgaOjEmG/0y','3155778','2002-09-04','M','2025-09-17',1,'CC','102525'),(7,'Santiago','Torres','santorre@gmail.com','$2y$10$rueDLRQmgNwK0ykvquVJNeIKx9flVw75G0ogMKwZ/G1eBg610/MVy','34155477','2001-03-06','M','2025-09-19',1,'TI','547899'),(8,'Mariana','Castaño','maricat@gmail.com','$2y$10$J/0tBrImzhIOfWcyleJ.0.K7QKbR7BIOkOKkYHuFp0a.EohhW5MBy','31543222','2025-09-18','M','2025-09-19',1,'CC','1026888');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes_membresias`
--

DROP TABLE IF EXISTS `clientes_membresias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes_membresias` (
  `id_cliente_membresia` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `id_membresia` int DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` enum('Activa','Vencida','Cancelada') COLLATE utf8mb4_general_ci DEFAULT 'Activa',
  PRIMARY KEY (`id_cliente_membresia`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_membresia` (`id_membresia`),
  CONSTRAINT `clientes_membresias_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `clientes_membresias_ibfk_2` FOREIGN KEY (`id_membresia`) REFERENCES `membresias` (`id_membresia`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_membresias`
--

LOCK TABLES `clientes_membresias` WRITE;
/*!40000 ALTER TABLE `clientes_membresias` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes_membresias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `tipo_cedula` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cedula` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `puesto` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_contratacion` date DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES (1,'CC','1234567890','Andrey','García','andrey123@gmail.com','$2y$10$N9gMaxny4HREmuLUbJuu0uqqJemNYOQek2QZjGu0x9AY9tQHoaUJS','Administrador','3104567890','2025-09-15',2500000.00),(2,'CC','1023322','Thomas','Cuadrado','Thoma@gmail.com','$2y$10$kyH7EYQS8/IfuRwNv6aWc.izkafm.ZqkHqHbkjkn4riRVMhGjNfZ2','Administrador','31577234',NULL,1200000.00);
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membresias`
--

DROP TABLE IF EXISTS `membresias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membresias` (
  `id_membresia` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `precio` decimal(10,2) NOT NULL,
  `duracion_dias` int NOT NULL,
  PRIMARY KEY (`id_membresia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membresias`
--

LOCK TABLES `membresias` WRITE;
/*!40000 ALTER TABLE `membresias` DISABLE KEYS */;
/*!40000 ALTER TABLE `membresias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_cedula` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `cedula` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'karen','Loaiza','loa@gmail.com','$2y$10$ehkfaf25YKnRM5fJ1o1wwukq4GOt9mufrpqUSXzhm4X3MQZcgLJj.','2025-09-11 21:11:03','','');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-19 15:01:04
