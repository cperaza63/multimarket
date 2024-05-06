-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.25-MariaDB


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema multimarket
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ multimarket;
USE multimarket;

--
-- Table structure for table `multimarket`.`caja`
--

DROP TABLE IF EXISTS `caja`;
CREATE TABLE `caja` (
  `caja_id` int(5) NOT NULL AUTO_INCREMENT,
  `caja_numero` int(5) NOT NULL,
  `caja_nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `caja_efectivo` decimal(30,2) NOT NULL,
  PRIMARY KEY (`caja_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`caja`
--

/*!40000 ALTER TABLE `caja` DISABLE KEYS */;
INSERT INTO `caja` (`caja_id`,`caja_numero`,`caja_nombre`,`caja_efectivo`) VALUES 
 (1,1,'Caja Principal','0.00');
/*!40000 ALTER TABLE `caja` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `categoria_id` int(7) NOT NULL AUTO_INCREMENT,
  `categoria_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_ubicacion` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`categoria`
--

/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `cliente_id` int(10) NOT NULL AUTO_INCREMENT,
  `cliente_tipo_documento` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_numero_documento` varchar(35) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_apellido` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_provincia` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_ciudad` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_direccion` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`cliente`
--

/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`cliente_id`,`cliente_tipo_documento`,`cliente_numero_documento`,`cliente_nombre`,`cliente_apellido`,`cliente_provincia`,`cliente_ciudad`,`cliente_direccion`,`cliente_telefono`,`cliente_email`) VALUES 
 (1,'Otro','N/A','Publico','General','N/A','N/A','N/A','N/A','N/A');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `empresa_id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`empresa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`empresa`
--

/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`market`
--

DROP TABLE IF EXISTS `market`;
CREATE TABLE `market` (
  `market_id` int(11) NOT NULL AUTO_INCREMENT,
  `market_nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `market_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `market_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `market_direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`market_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`market`
--

/*!40000 ALTER TABLE `market` DISABLE KEYS */;
/*!40000 ALTER TABLE `market` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `producto_id` int(20) NOT NULL AUTO_INCREMENT,
  `producto_codigo` varchar(77) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_stock_total` int(25) NOT NULL,
  `producto_tipo_unidad` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_precio_compra` decimal(30,2) NOT NULL,
  `producto_precio_venta` decimal(30,2) NOT NULL,
  `producto_marca` varchar(35) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_modelo` varchar(35) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_foto` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_id` int(7) NOT NULL,
  PRIMARY KEY (`producto_id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`producto`
--

/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `user_id` int(7) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `lastname` varchar(50) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `login` varchar(30) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `password` varchar(535) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `usuario_foto` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `caja_id` int(5) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `dateofbirth` datetime DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `departamento` varchar(80) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'USUARIO',
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `location` text COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `colmena_conexion` int(10) unsigned NOT NULL DEFAULT 1000,
  `state` varchar(40) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'CA',
  `city` varchar(80) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'VALENCIA',
  `country` varchar(10) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'VEN',
  `nombre_completo` varchar(250) COLLATE utf8_spanish2_ci NOT NULL DEFAULT ' ',
  `pregunta_clave` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'cual es tu nombre?',
  `respuesta_clave` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'usuario de ciudadhive',
  `tarjeta_presentacion` varchar(250) COLLATE utf8_spanish2_ci NOT NULL DEFAULT ' ',
  `gender` varchar(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'M',
  `rif` varchar(20) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'V-',
  `tcarea` varchar(10) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0',
  `tcnumber` varchar(10) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `caja_id` (`caja_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='archivo de usuarios';

--
-- Dumping data for table `multimarket`.`usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`user_id`,`firstname`,`lastname`,`email`,`login`,`password`,`usuario_foto`,`caja_id`,`created_at`,`dateofbirth`,`telefono`,`departamento`,`estatus`,`tipo`,`company_id`,`location`,`colmena_conexion`,`state`,`city`,`country`,`nombre_completo`,`pregunta_clave`,`respuesta_clave`,`tarjeta_presentacion`,`gender`,`rif`,`tcarea`,`tcnumber`) VALUES 
 (1,'Administrador Principal','De CiudadHive','ciudadhive@gmail.com','ciudadhive@gmail.com','$2y$10$oMBj1uqWpkmUbJUAnIw76OLVyrmO7v9riCoW6Aojv9huuViLl1Eh6','Administrador_18.png',1,'2024-04-12 00:00:00','1963-05-22 00:00:00','0414-4840676','Administrador principal de la aplicacion',1,'ADMINISTRATOR',1212,'Residencias Las Trinitarias Torre 9 Planta Apto PBB, Ciudad Alianza',1000,'CA','VALENCIA','VEN','Administrador Principal De ciudadhive','cual es tu nombre?','usuario de ciudadhive',' ','M','V-7065079','0414','4840676'),
 (2,'Carlos','Peraza','carlosperazavz@gmail.com','carlosperazavz@gmail.com','$2y$10$Jgm6xFb5Onz/BMdIkNK2Tur8yg/NYEMb/tdnhoV7kB1BwIG4R05D2','Carlos_67.png',1,'2024-04-12 00:00:00','1963-05-22 00:00:00','0414-4840676','Administrador suplente',1,'ASISTENTE',1212,'Residencias Las Trinitarias Torre 9 Planta Apto PBB, Ciudad Alianza',1000,'CA','VALENCIA','VEN','Carlos Peraza','cual es tu nombre?','usuario de ciudadhive',' ','M','V-','0414','4840676');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`venta`
--

DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta` (
  `venta_id` int(30) NOT NULL AUTO_INCREMENT,
  `venta_codigo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `venta_fecha` date NOT NULL,
  `venta_hora` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `venta_total` decimal(30,2) NOT NULL,
  `venta_pagado` decimal(30,2) NOT NULL,
  `venta_cambio` decimal(30,2) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `caja_id` int(5) NOT NULL,
  PRIMARY KEY (`venta_id`),
  UNIQUE KEY `venta_codigo` (`venta_codigo`),
  KEY `usuario_id` (`usuario_id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `caja_id` (`caja_id`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`user_id`),
  CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`),
  CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`caja_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`venta`
--

/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`venta_detalle`
--

DROP TABLE IF EXISTS `venta_detalle`;
CREATE TABLE `venta_detalle` (
  `venta_detalle_id` int(100) NOT NULL AUTO_INCREMENT,
  `venta_detalle_cantidad` int(10) NOT NULL,
  `venta_detalle_precio_compra` decimal(30,2) NOT NULL,
  `venta_detalle_precio_venta` decimal(30,2) NOT NULL,
  `venta_detalle_total` decimal(30,2) NOT NULL,
  `venta_detalle_descripcion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `venta_codigo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_id` int(20) NOT NULL,
  PRIMARY KEY (`venta_detalle_id`),
  KEY `venta_id` (`venta_codigo`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `venta_detalle_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`),
  CONSTRAINT `venta_detalle_ibfk_3` FOREIGN KEY (`venta_codigo`) REFERENCES `venta` (`venta_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`venta_detalle`
--

/*!40000 ALTER TABLE `venta_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_detalle` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
