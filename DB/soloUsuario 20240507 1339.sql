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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='archivo de usuarios';

--
-- Dumping data for table `multimarket`.`usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`user_id`,`firstname`,`lastname`,`email`,`login`,`password`,`usuario_foto`,`caja_id`,`created_at`,`dateofbirth`,`telefono`,`departamento`,`estatus`,`tipo`,`company_id`,`location`,`colmena_conexion`,`state`,`city`,`country`,`nombre_completo`,`pregunta_clave`,`respuesta_clave`,`tarjeta_presentacion`,`gender`,`rif`,`tcarea`,`tcnumber`) VALUES 
 (1,'Administrador Ppal','De CiudadHive','ciudadhive@gmail.com','ciudadhive@gmail.com','$2y$10$DuMw9s52hxi01c2tnA5pfewoFpHxAv4UovPtagI3k1rlj9dhsFyr6','Administrador_18.jpg',1,'2024-04-12 00:00:00','1963-05-22 00:00:00','0414-4840676','Administrador principal de la aplicacion',1,'ADMINISTRATOR',1212,'Residencias Las Trinitarias Torre 9 Planta Apto PBB, Ciudad Alianza',1000,'CA','VALENCIA','VEN','Administrador Ppal De CiudadHive','cual es tu nombre?','usuario de ciudadhive',' ','M','V-7065079','0414','4840676'),
 (2,'Carlos','Peraza','carlosperazavz@gmail.com','carlosperazavz@gmail.com','$2y$10$oMBj1uqWpkmUbJUAnIw76OLVyrmO7v9riCoW6Aojv9huuViLl1Eh6','Carlos_67.png',1,'2024-04-12 00:00:00','1963-05-22 00:00:00','0414-4840676','Administrador principal de la aplicacion',1,'ASISTENTE',1212,'Residencias Las Trinitarias Torre 9 Planta Apto PBB, Ciudad Alianza',1000,'CA','VALENCIA','VEN','Administrador Principal De ciudadhive','cual es tu nombre?','Carlos',' ','M','V-7065079','0414','4840676'),
 (8,'Virginia','Sanchez','josegomez@gmail.com','josegomez@gmail.com','$2y$10$.KN93Vu/iHz7VFgl8.DxweQZtJQFicnBii0oF0kxGvnOwBNpuzYm.','1234_VirginiaSanchez_24.png',0,'2024-05-07 00:00:00','2024-05-07 00:00:00','','Ventas',1,'VENDOR',1234,'Carribbean Suits\r\nTucasa',1000,'FALCON','Boca de Aroa','Venezuela','Virginia Sanchez','cual es tu nombre?','usuario de ciudadhive',' ','F','7065079','412','4560079');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
