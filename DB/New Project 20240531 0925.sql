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
-- Table structure for table `multimarket`.`company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `company_name` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_description` text COLLATE utf8_spanish2_ci NOT NULL DEFAULT '\'',
  `company_email` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_logo` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_card` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_banner1` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_banner2` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_banner3` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_user` int(10) unsigned NOT NULL DEFAULT 0,
  `company_phone` varchar(80) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `company_address` text COLLATE utf8_spanish2_ci NOT NULL DEFAULT '\'',
  `company_country` varchar(5) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_state` varchar(5) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_city` int(10) unsigned NOT NULL DEFAULT 0,
  `company_type` varchar(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'E' COMMENT 'Usuario-Empresa-Corporacion-Delivery',
  `company_rif` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `company_red1` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'facebook',
  `company_red_valor1` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'https://www.facebook.com/ciudadhivemarket/',
  `company_red2` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'instagram',
  `company_red_valor2` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'https://www.instagram.com/ciudadcolmena/',
  `company_red3` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'tiktok',
  `company_red_valor3` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'https://www.tiktok.com/es/',
  `company_web` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'https://',
  `company_latitude` double NOT NULL DEFAULT 0,
  `company_longitude` double NOT NULL DEFAULT 0,
  `company_tipo_delivery` varchar(10) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0' COMMENT '0:noDelivery, 1:delivery flat, 3-delvery distancia.peso, 4-delivery-distancia-valor',
  `company_tarifa_delivery` double NOT NULL DEFAULT 0,
  `company_horario_desde` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '08:00|08:00|08:00|08:00|08:00|08:00|08:00',
  `company_horario_hasta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '18:00|18:00|18:00|18:00|18:00|18:00|18:00',
  `company_iva` double NOT NULL DEFAULT 0 COMMENT 'IVA dentro del precio',
  `company_servicio_email` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'mail.ciudadhive.com',
  `company_servicio_email_envio` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'info@ciudadhive.com',
  `company_servicio_email_password` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'ceph7065079',
  `company_servicio_email_puerto` int(10) unsigned NOT NULL DEFAULT 587,
  `company_slogan` varchar(250) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_logo_witdh` int(10) unsigned NOT NULL DEFAULT 200,
  `company_logo_height` int(10) unsigned NOT NULL DEFAULT 80,
  `company_pdf` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `company_youtube_index` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '' COMMENT 'solo lo que va despues de v=',
  `company_contrato` int(10) unsigned NOT NULL DEFAULT 0,
  `company_contrato_vencimiento` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `company_market_cat` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `company_membresia` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`company`
--

/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` (`company_id`,`company_name`,`company_description`,`company_email`,`company_logo`,`company_card`,`company_banner1`,`company_banner2`,`company_banner3`,`company_user`,`company_phone`,`company_estatus`,`company_address`,`company_country`,`company_state`,`company_city`,`company_type`,`company_rif`,`created_at`,`company_red1`,`company_red_valor1`,`company_red2`,`company_red_valor2`,`company_red3`,`company_red_valor3`,`company_web`,`company_latitude`,`company_longitude`,`company_tipo_delivery`,`company_tarifa_delivery`,`company_horario_desde`,`company_horario_hasta`,`company_iva`,`company_servicio_email`,`company_servicio_email_envio`,`company_servicio_email_password`,`company_servicio_email_puerto`,`company_slogan`,`company_logo_witdh`,`company_logo_height`,`company_pdf`,`company_youtube_index`,`company_contrato`,`company_contrato_vencimiento`,`company_market_cat`,`company_membresia`) VALUES 
 (5,'AP LURES','Tienda Nautica que vende Articulos de Pesca','josegomez@gmail.com','company_logo-5_80.jpg','company_card-5_29.png','company_banner1-5_51.png','company_banner2-5_89.png','company_banner3-5_64.jpg',2,'04124560079',1,'Resiencias Martinica 2 Piso 11 apto 11b\r\nValles de Camoruco','VEN','CA',45414,'E','J316732630','2024-05-13 00:00:00','facebook','https://www.facebook.com/ciudadhivemarket','instagram','https://www.instagram.com/ciudadcolmena/','tiktok','https://www.tiktok.com/es/','https://ciudadhive.com',10.264109,-67.894393,'0',0,'08:00|08:00|08:00|08:00|08:00|08:00|08:00','18:00|18:00|18:00|18:00|18:00|18:00|18:00',16,'mail.ciudadhive.com','info@ciudadhive.com','ceph7065079',587,'El mejor sitio para hacer negocios',200,80,'company_pdf-5_27.pdf','-VOBp-pGUQk&t=7s',0,'1900-01-01 00:00:00','72',9);
/*!40000 ALTER TABLE `company` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_bancos`
--

DROP TABLE IF EXISTS `company_bancos`;
CREATE TABLE `company_bancos` (
  `banco_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(80) COLLATE utf8_spanish_ci NOT NULL DEFAULT '' COMMENT 'codigo del banco',
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `banco_foto` varchar(145) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `unidad` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`banco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla company_bancos';

--
-- Dumping data for table `multimarket`.`company_bancos`
--

/*!40000 ALTER TABLE `company_bancos` DISABLE KEYS */;
INSERT INTO `company_bancos` (`banco_id`,`codigo`,`nombre`,`banco_foto`,`estatus`,`company_id`,`unidad`) VALUES 
 (75,'banesco','Banco Banesco','banesco_58.png',1,5,0),
 (77,'100banco','100 BANCO','100banco_61.png',1,5,0);
/*!40000 ALTER TABLE `company_bancos` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_categorias`
--

DROP TABLE IF EXISTS `company_categorias`;
CREATE TABLE `company_categorias` (
  `categoria_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(80) COLLATE utf8_spanish_ci NOT NULL DEFAULT '' COMMENT 'codigo cat o subcat',
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `categoria_foto` varchar(145) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `unidad` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'si hay unidad es categoria',
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla company_categorias';

--
-- Dumping data for table `multimarket`.`company_categorias`
--

/*!40000 ALTER TABLE `company_categorias` DISABLE KEYS */;
INSERT INTO `company_categorias` (`categoria_id`,`codigo`,`nombre`,`categoria_foto`,`estatus`,`company_id`,`unidad`) VALUES 
 (84,'senuelos','Señuelos','senuelos_98.png',1,5,0),
 (85,'sen-agua-salada','Señuelos de Agua Salada','subcat-5-sen-agua-salada_77.png',1,5,84),
 (86,'3m','3M','subcat-5-3m_54.png',1,5,84);
/*!40000 ALTER TABLE `company_categorias` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_clientes`
--

DROP TABLE IF EXISTS `company_clientes`;
CREATE TABLE `company_clientes` (
  `cliente_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_name` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `cliente_description` text COLLATE utf8_spanish2_ci NOT NULL DEFAULT '\'',
  `cliente_email` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `cliente_logo` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_card` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_banner1` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_banner2` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_banner3` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_phone` varchar(80) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `cliente_estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `cliente_address` text COLLATE utf8_spanish2_ci NOT NULL DEFAULT '\'',
  `cliente_country` varchar(5) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `cliente_state` varchar(5) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `cliente_city` int(10) unsigned NOT NULL DEFAULT 0,
  `cliente_rif` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `cliente_red1` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_red_valor1` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_red2` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_red_valor2` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_red3` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_red_valor3` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_web` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cliente_latitude` double NOT NULL DEFAULT 0,
  `cliente_longitude` double NOT NULL DEFAULT 0,
  `cliente_horario_desde` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '08:00|08:00|08:00|08:00|08:00|08:00|08:00',
  `cliente_horario_hasta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '18:00|18:00|18:00|18:00|18:00|18:00|18:00',
  `cliente_logo_witdh` int(10) unsigned NOT NULL DEFAULT 200,
  `cliente_logo_height` int(10) unsigned NOT NULL DEFAULT 80,
  `cliente_pdf` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `cliente_youtube_index` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'solo lo que va despues de v=',
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`company_clientes`
--

/*!40000 ALTER TABLE `company_clientes` DISABLE KEYS */;
INSERT INTO `company_clientes` (`cliente_id`,`cliente_name`,`cliente_description`,`cliente_email`,`cliente_logo`,`cliente_card`,`cliente_banner1`,`cliente_banner2`,`cliente_banner3`,`cliente_phone`,`cliente_estatus`,`cliente_address`,`cliente_country`,`cliente_state`,`cliente_city`,`cliente_rif`,`created_at`,`cliente_red1`,`cliente_red_valor1`,`cliente_red2`,`cliente_red_valor2`,`cliente_red3`,`cliente_red_valor3`,`cliente_web`,`cliente_latitude`,`cliente_longitude`,`cliente_horario_desde`,`cliente_horario_hasta`,`cliente_logo_witdh`,`cliente_logo_height`,`cliente_pdf`,`cliente_youtube_index`,`company_id`) VALUES 
 (5,'MIKE PERAZA PHOTO','DONDE QUIERA QUE ESTAS TE LA TOMO','mikeperazaphoto@gmail.com','5_22.png','','','','','04124560079',1,'Valencia Residnecias Martinica 2','VEN','CA',45414,'j215421547','2024-05-29 00:00:00','facebook','https://www.facebook.com/ciudadhivemarket/','instagram','https://www.instagram.com/ciudadcolmena/','tiktok','https://www.tiktok.com/es/','https://',0,0,'08:00|08:00|08:00|08:00|08:00|08:00|08:00','18:00|18:00|18:00|18:00|18:00|18:00|18:00',200,80,'','',5),
 (6,'DRA MARIANELLA','MEDICO PEDIATRA','ramsbott20o@gmail.com','6_98.png','cliente_card-6_29.jpg','cliente_banner1-6_17.jpg','cliente_banner2-6_15.jpg','cliente_banner3-6_44.jpg','04140441790',1,'Valencia Residnecias Martinica 2','VEN','CA',45414,'J21548764','2024-05-29 00:00:00','facebook','https://www.facebook.com/ciudadhivemarket/','instagram','https://www.instagram.com/ciudadcolmena/','tiktok','https://www.tiktok.com/es/','https://',10.4813461,-66.82159810000002,'04:15|04:15|04:15|04:15|04:15|04:15|04:15','15:00|15:00|15:00|15:00|15:00|15:00|15:00',200,80,'cliente_pdf-6_91.pdf','',5);
/*!40000 ALTER TABLE `company_clientes` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_control`
--

DROP TABLE IF EXISTS `company_control`;
CREATE TABLE `company_control` (
  `control_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `codigo` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `control_foto` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `unidad` int(10) unsigned NOT NULL DEFAULT 0,
  `control_card` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL,
  `control_banner1` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL,
  `control_banner2` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL,
  `control_banner3` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL,
  `country` varchar(5) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'VEN',
  PRIMARY KEY (`control_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tablde control empreaa';

--
-- Dumping data for table `multimarket`.`company_control`
--

/*!40000 ALTER TABLE `company_control` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_control` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_marcas`
--

DROP TABLE IF EXISTS `company_marcas`;
CREATE TABLE `company_marcas` (
  `marca_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(80) COLLATE utf8_spanish_ci NOT NULL DEFAULT '' COMMENT 'codigo de marca',
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `marca_foto` varchar(145) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `unidad` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'si hay unidad es modelo',
  PRIMARY KEY (`marca_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla company_marca_modelo';

--
-- Dumping data for table `multimarket`.`company_marcas`
--

/*!40000 ALTER TABLE `company_marcas` DISABLE KEYS */;
INSERT INTO `company_marcas` (`marca_id`,`codigo`,`nombre`,`marca_foto`,`estatus`,`company_id`,`unidad`) VALUES 
 (75,'harris','Capitan Harrys','marca-5-75_55.png',1,5,0),
 (77,'Capitan_gorra','Gorra de Capitan','modelo-5-Capitan_gorra_94.png',1,5,75);
/*!40000 ALTER TABLE `company_marcas` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_productos`
--

DROP TABLE IF EXISTS `company_productos`;
CREATE TABLE `company_productos` (
  `producto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `producto_name` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `producto_description` text COLLATE utf8_spanish2_ci NOT NULL DEFAULT '\'',
  `producto_epi` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `producto_logo` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `producto_card` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `producto_banner1` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `producto_banner2` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `producto_banner3` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `producto_inventiable` tinyint(1) NOT NULL DEFAULT 1,
  `producto_estatus` tinyint(1) NOT NULL DEFAULT 1,
  `producto_proveedor` int(10) unsigned NOT NULL DEFAULT 0,
  `producto_precio` double NOT NULL DEFAULT 0,
  `producto_anterior` double NOT NULL DEFAULT 0,
  `producto_costo` double NOT NULL DEFAULT 0,
  `producto_margen_utilidad` double NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `producto_reorden` int(10) unsigned DEFAULT NULL,
  `producto_pedido` int(10) unsigned DEFAULT NULL,
  `producto_stock` int(10) unsigned DEFAULT NULL,
  `producto_peso` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `producto_unidad` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `producto_precio_final` double DEFAULT NULL,
  `producto_tax` double DEFAULT NULL,
  `producto_aplica_flete` tinyint(1) NOT NULL DEFAULT 0,
  `producto_mostrar_peso` tinyint(1) NOT NULL DEFAULT 0,
  `producto_mostrar_carrito` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '08:00|08:00|08:00|08:00|08:00|08:00|08:00',
  `producto_horario_hasta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '18:00|18:00|18:00|18:00|18:00|18:00|18:00',
  `producto_usado` tinyint(1) NOT NULL DEFAULT 0,
  `producto_height` int(10) unsigned NOT NULL DEFAULT 80,
  `producto_width` int(10) unsigned NOT NULL DEFAULT 0,
  `producto_year` int(10) unsigned NOT NULL DEFAULT 0,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `producto_cambio_precio` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `producto_excento_tax` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`company_productos`
--

/*!40000 ALTER TABLE `company_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_productos` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_productos_descuentos`
--

DROP TABLE IF EXISTS `company_productos_descuentos`;
CREATE TABLE `company_productos_descuentos` (
  `descuento_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `producto_id` int(10) unsigned NOT NULL DEFAULT 0,
  `desde` int(10) unsigned NOT NULL DEFAULT 0,
  `hasta` int(10) unsigned NOT NULL DEFAULT 0,
  `valor` int(10) unsigned NOT NULL DEFAULT 0,
  `unidad` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`descuento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla company_productos_descuentos';

--
-- Dumping data for table `multimarket`.`company_productos_descuentos`
--

/*!40000 ALTER TABLE `company_productos_descuentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_productos_descuentos` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_productos_etiquetas`
--

DROP TABLE IF EXISTS `company_productos_etiquetas`;
CREATE TABLE `company_productos_etiquetas` (
  `etiqueta_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `producto_id` int(10) unsigned NOT NULL DEFAULT 0,
  `etiqueta` varchar(145) COLLATE utf8_spanish_ci NOT NULL DEFAULT ' ',
  `secuencia` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`etiqueta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla company_productos_etiquetas';

--
-- Dumping data for table `multimarket`.`company_productos_etiquetas`
--

/*!40000 ALTER TABLE `company_productos_etiquetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_productos_etiquetas` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_productos_interes`
--

DROP TABLE IF EXISTS `company_productos_interes`;
CREATE TABLE `company_productos_interes` (
  `interes_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `producto_id` int(10) unsigned NOT NULL DEFAULT 0,
  `producto_hijo` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`interes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla company_producto_interes';

--
-- Dumping data for table `multimarket`.`company_productos_interes`
--

/*!40000 ALTER TABLE `company_productos_interes` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_productos_interes` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_proveedores`
--

DROP TABLE IF EXISTS `company_proveedores`;
CREATE TABLE `company_proveedores` (
  `proveedor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `proveedor_name` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `proveedor_description` text COLLATE utf8_spanish2_ci NOT NULL DEFAULT '\'',
  `proveedor_email` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `proveedor_logo` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_card` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_banner1` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_banner2` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_banner3` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_phone` varchar(80) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `proveedor_estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `proveedor_address` text COLLATE utf8_spanish2_ci NOT NULL DEFAULT '\'',
  `proveedor_country` varchar(5) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `proveedor_state` varchar(5) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `proveedor_city` int(10) unsigned NOT NULL DEFAULT 0,
  `proveedor_rif` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `proveedor_red1` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_red_valor1` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_red2` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_red_valor2` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_red3` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_red_valor3` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_web` varchar(145) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `proveedor_latitude` double NOT NULL DEFAULT 0,
  `proveedor_longitude` double NOT NULL DEFAULT 0,
  `proveedor_horario_desde` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '08:00|08:00|08:00|08:00|08:00|08:00|08:00',
  `proveedor_horario_hasta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '18:00|18:00|18:00|18:00|18:00|18:00|18:00',
  `proveedor_logo_witdh` int(10) unsigned NOT NULL DEFAULT 200,
  `proveedor_logo_height` int(10) unsigned NOT NULL DEFAULT 80,
  `proveedor_pdf` varchar(145) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `proveedor_youtube_index` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'solo lo que va despues de v=',
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`proveedor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `multimarket`.`company_proveedores`
--

/*!40000 ALTER TABLE `company_proveedores` DISABLE KEYS */;
INSERT INTO `company_proveedores` (`proveedor_id`,`proveedor_name`,`proveedor_description`,`proveedor_email`,`proveedor_logo`,`proveedor_card`,`proveedor_banner1`,`proveedor_banner2`,`proveedor_banner3`,`proveedor_phone`,`proveedor_estatus`,`proveedor_address`,`proveedor_country`,`proveedor_state`,`proveedor_city`,`proveedor_rif`,`created_at`,`proveedor_red1`,`proveedor_red_valor1`,`proveedor_red2`,`proveedor_red_valor2`,`proveedor_red3`,`proveedor_red_valor3`,`proveedor_web`,`proveedor_latitude`,`proveedor_longitude`,`proveedor_horario_desde`,`proveedor_horario_hasta`,`proveedor_logo_witdh`,`proveedor_logo_height`,`proveedor_pdf`,`proveedor_youtube_index`,`company_id`) VALUES 
 (4,'TELESYS','negocio de telecomunicaciones','cpdigitalsolution@yahoo.com.ve','4_32.png','proveedor_card-4_97.png','proveedor_banner1-4_77.png','proveedor_banner2-4_27.png','proveedor_banner3-4_43.png','04144840676',1,'Residencias LAs Trinitarias torre 9 Planta Baja Apto PBB\r\nCiudad Alianza','VEN','CA',45414,'J316732630','2024-05-28 00:00:00','facebook','https://www.facebook.com/ciudadhivemarket/','instagram','https://www.instagram.com/ciudadcolmena/','tiktok','https://www.tiktok.com/es/','https://',10.218231,-67.916698,'08:00|08:00|08:00|08:00|08:00|08:00|08:00','18:00|18:00|18:00|18:00|18:00|18:00|18:00',200,80,'proveedor_pdf-4_7.pdf','',5);
/*!40000 ALTER TABLE `company_proveedores` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`company_sub_productos`
--

DROP TABLE IF EXISTS `company_sub_productos`;
CREATE TABLE `company_sub_productos` (
  `subproducto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `producto_id` int(10) unsigned NOT NULL DEFAULT 0,
  `titulo_atributo1` int(10) unsigned NOT NULL DEFAULT 0,
  `titulo_atributo2` int(10) unsigned NOT NULL DEFAULT 0,
  `valor_atributo1` int(10) unsigned NOT NULL DEFAULT 0,
  `valor_atributo2` int(10) unsigned NOT NULL DEFAULT 0,
  `costo_unidad` int(10) unsigned NOT NULL DEFAULT 0,
  `stock` int(10) unsigned NOT NULL DEFAULT 0,
  `unidad_medida` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`subproducto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla company_sub_productos';

--
-- Dumping data for table `multimarket`.`company_sub_productos`
--

/*!40000 ALTER TABLE `company_sub_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_sub_productos` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`control`
--

DROP TABLE IF EXISTS `control`;
CREATE TABLE `control` (
  `control_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `codigo` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `control_foto` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  `unidad` int(10) unsigned NOT NULL DEFAULT 0,
  `control_card` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL,
  `control_banner1` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL,
  `control_banner2` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL,
  `control_banner3` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL,
  `country` varchar(5) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'VEN',
  PRIMARY KEY (`control_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tablde control general';

--
-- Dumping data for table `multimarket`.`control`
--

/*!40000 ALTER TABLE `control` DISABLE KEYS */;
INSERT INTO `control` (`control_id`,`tipo`,`codigo`,`nombre`,`control_foto`,`valor`,`estatus`,`company_id`,`unidad`,`control_card`,`control_banner1`,`control_banner2`,`control_banner3`,`country`) VALUES 
 (1,'market','comida','COMIDA','','',1,0,0,'','','','','VEN'),
 (2,'market','ciudadhive','CIUDADHIVE','2_52.png','',1,0,0,'','','','','VEN'),
 (3,'market','autos','AUTOS','control_foto-3_15.png','',1,0,0,'','','','','VEN'),
 (4,'market','ferreteria','FERRETERIA','','',1,0,0,'','','','','VEN'),
 (6,'market','industria','INDUSTRIA','','',1,0,0,'','','','','VEN'),
 (7,'market','medico','MEDICINA','','',1,0,0,'','','','','VEN'),
 (8,'market','salud','SALUD','','',1,0,0,'','','','','VEN'),
 (9,'market','nautica','NAUTICA','control_foto-9_10.png','',1,0,0,'','','','','VEN'),
 (10,'market','delhogar','DEL HOGAR','','',1,0,0,'','','','','VEN'),
 (11,'market','tecnoligia','TECNOLOGIA','','',1,0,0,'','','','','VEN'),
 (12,'market','vestidos','VESTIDOS','','',1,0,0,'','','','','VEN'),
 (15,'market','deporte','DEPORTE','','',1,0,0,'','','','','VEN'),
 (21,'market_cat','autos nuevos','autonuevos y bonitos','autos_nuevos_48.png','',1,0,3,'','','','','VEN');
INSERT INTO `control` (`control_id`,`tipo`,`codigo`,`nombre`,`control_foto`,`valor`,`estatus`,`company_id`,`unidad`,`control_card`,`control_banner1`,`control_banner2`,`control_banner3`,`country`) VALUES 
 (22,'market_cat','autos usados','usados pero sirve los carros','control_foto-22_6.png','',1,0,3,'','','','','VEN'),
 (23,'market_cat','comida cacera','comida cacera','comida_cacera_73.jpg','',1,0,1,'','','','','VEN'),
 (24,'unidades','unidades','Unidades','','',1,0,0,'','','','','VEN'),
 (25,'unidades','litros','Litros','','',1,0,0,'','','','','VEN'),
 (27,'unidades','kilos','Kilogramos','','',1,0,0,'','','','','VEN'),
 (28,'unidades','afiliacion-anual','Afiliacion Anual','','',1,0,0,'','','','','VEN'),
 (29,'unidades','afiliacion-mensual','Afiliacion Mensual','','',1,0,0,'','','','','VEN'),
 (30,'unidades','pago-mensual','Pago Mensual','','',1,0,0,'','','','','VEN'),
 (31,'unidades','servicio','Servicio','','',1,0,0,'','','','','VEN'),
 (32,'unidades','servicio-mes','Servicio Mensual','','',1,0,0,'','','','','VEN'),
 (33,'unidades','trabajo','Trabajo','','',1,0,0,'','','','','VEN');
INSERT INTO `control` (`control_id`,`tipo`,`codigo`,`nombre`,`control_foto`,`valor`,`estatus`,`company_id`,`unidad`,`control_card`,`control_banner1`,`control_banner2`,`control_banner3`,`country`) VALUES 
 (34,'unidades','combo','Combo','','',1,0,0,'','','','','VEN'),
 (35,'monedas','USD','US$','','',1,0,0,'','','','','VEN'),
 (36,'monedas','BSD','BSD','','',1,0,0,'','','','','VEN'),
 (37,'monedas','EUR','EUR','','',1,0,0,'','','','','VEN'),
 (38,'monedas','$CO','$COL','','',1,0,0,'','','','','VEN'),
 (39,'bancos','100banco','100BANCO','control_foto-39_55.jpg','',1,0,0,'control_card-39_75.png','control_banner1-39_85.jpg','control_banner2-39_89.png','control_banner3-39_55.png','VEN'),
 (40,'bancos','bancamiga','BANCAMIGA','control_foto-40_26.png','',1,0,0,'','','','','VEN'),
 (41,'bancos','banco-activo','BANCO ACTIVO','','',1,0,0,'','','','','VEN'),
 (42,'bancos','banco-agricola-venezuela','BANCO AGRICOLA DE VENEZUELA','','',1,0,0,'','','','','VEN'),
 (43,'bancos','banco-pueblo-soberano','BANCO DEL PUEBLO SOBERANO','','',1,0,0,'','','','','VEN'),
 (44,'bancos','banco-del-tesoro','BANCO DEL TESORO','','',1,0,0,'','','','','VEN');
INSERT INTO `control` (`control_id`,`tipo`,`codigo`,`nombre`,`control_foto`,`valor`,`estatus`,`company_id`,`unidad`,`control_card`,`control_banner1`,`control_banner2`,`control_banner3`,`country`) VALUES 
 (45,'bancos','bancrecer','BANCRECER','','',1,0,0,'','','','','VEN'),
 (46,'bancos','banesco','BANESCO','','',1,0,0,'','','','','VEN'),
 (47,'bancos','banfanb','BANFANB','','',1,0,0,'','','','','VEN'),
 (48,'bancos','bangente','BANGENTE','','',1,0,0,'','','','','VEN'),
 (49,'bancos','banplus','BANPLUS','','',1,0,0,'','','','','VEN'),
 (50,'bancos','bbva-provincial','BBVA PROVINCIAL','','',1,0,0,'','','','','VEN'),
 (51,'bancos','bicentenario','BICENTNERARIO','','',1,0,0,'','','','','VEN'),
 (52,'bancos','bnc','BNC','','',1,0,0,'','','','','VEN'),
 (53,'bancos','bod','BANCO OCCIDENTAL DE DESCUENTO','','',1,0,0,'','','','','VEN'),
 (54,'bancos','caribe','BANCO DEL CARIBE','','',1,0,0,'','','','','VEN'),
 (55,'bancos','caroni','BANCO DEL CARONI','','',1,0,0,'','','','','VEN'),
 (56,'bancos','citibank','CITIBANK','','',1,0,0,'','','','','VEN'),
 (57,'bancos','corpbanca','CORP BANCA','','',1,0,0,'','','','','VEN');
INSERT INTO `control` (`control_id`,`tipo`,`codigo`,`nombre`,`control_foto`,`valor`,`estatus`,`company_id`,`unidad`,`control_card`,`control_banner1`,`control_banner2`,`control_banner3`,`country`) VALUES 
 (58,'bancos','del sur','DEL SUR','','',1,0,0,'','','','','VEN'),
 (59,'delivery','tienda','Recoje en tienda','','',1,0,0,'','','','','VEN'),
 (60,'delivery','flat','Tarifa Unida','','',1,0,0,'','','','','VEN'),
 (61,'delivery','peso-distanca','Peso/Distancia','','',1,0,0,'','','','','VEN'),
 (62,'delivery','valor-distancia','Valor/Distancia','','',1,0,0,'','','','','VEN'),
 (63,'delivery','distancia','Por Distancia','','',1,0,0,'','','','','VEN'),
 (64,'vehiculos','moto','Moto','','',1,0,0,'','','','','VEN'),
 (65,'vehiculos','bicicleta','Bicicleta','','',1,0,0,'','','','','VEN'),
 (66,'vehiculos','auto','Autómovil','','',1,0,0,'','','','','VEN'),
 (67,'vehiculos','suv','Camioneta SUV','','',1,0,0,'','','','','VEN'),
 (68,'vehiculos','pick-up','Camioneta Pick Up','','',1,0,0,'','','','','VEN'),
 (69,'vehiculos','camion','Camión','','',1,0,0,'','','','','VEN');
INSERT INTO `control` (`control_id`,`tipo`,`codigo`,`nombre`,`control_foto`,`valor`,`estatus`,`company_id`,`unidad`,`control_card`,`control_banner1`,`control_banner2`,`control_banner3`,`country`) VALUES 
 (70,'vehiculos','aereo','Aéreo','','',1,0,0,'','','','','VEN'),
 (71,'vehiculos','maritimo','Marítimo','','',1,0,0,'','','','','VEN'),
 (72,'market_cat','articulos-pesca','Articulos de pesca','control_foto-72_19.png','',1,0,9,'','','','','VEN'),
 (73,'market_cat','equipo_pesca','Equipo de Pesca','control_foto-73_36.png','',1,0,9,'','','','','VEN'),
 (74,'market_cat','salvamento','Equipos de Salvamento','control_foto-74_83.png','',1,0,9,'','','','','VEN'),
 (75,'etiquetas','resaltante','Los mas resaltantes','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (76,'etiquetas','bucados','Los mas buscados','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (77,'etiquetas','ultimos','Ultimos incorporados','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (78,'etiquetas','especiales','Especiales','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (79,'etiquetas','vendidos','Los mas vendidos','','',1,0,2,NULL,NULL,NULL,NULL,'VEN');
INSERT INTO `control` (`control_id`,`tipo`,`codigo`,`nombre`,`control_foto`,`valor`,`estatus`,`company_id`,`unidad`,`control_card`,`control_banner1`,`control_banner2`,`control_banner3`,`country`) VALUES 
 (80,'control','market_cat','Categorias de market','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (81,'control','market','Market Place','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (82,'control','unidades','Unidades de Medida','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (83,'control','monedas','Tipo de Moneda','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (84,'control','contratos','Tipo de Contratos','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (85,'control','bancos','Tipo de Bancos','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (86,'control','delivery','Tipos de Delivery','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (87,'control','vehiculos','Tipo de Vehiculos','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (88,'control','etiquetas','Tipo de Etiquetas','','',1,0,2,NULL,NULL,NULL,NULL,'VEN'),
 (89,'control','control','Tipo de tablas de control','','',1,0,2,NULL,NULL,NULL,NULL,'VEN');
/*!40000 ALTER TABLE `control` ENABLE KEYS */;


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
-- Table structure for table `multimarket`.`proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor` (
  `proveedor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(80) COLLATE utf8_spanish_ci NOT NULL DEFAULT '' COMMENT 'codigo de proeedor',
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `proveedor_foto` varchar(145) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `estatus` int(10) unsigned NOT NULL DEFAULT 1,
  `company_id` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`proveedor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla company_proveedor';

--
-- Dumping data for table `multimarket`.`proveedor`
--

/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;


--
-- Table structure for table `multimarket`.`ubicacion`
--

DROP TABLE IF EXISTS `ubicacion`;
CREATE TABLE `ubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(3) NOT NULL DEFAULT 'VEN',
  `state_abbreviation` varchar(2) DEFAULT NULL,
  `state_name` varchar(60) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `capital` varchar(1) NOT NULL DEFAULT '' COMMENT '*',
  `latitude` varchar(15) DEFAULT NULL,
  `longitude` varchar(15) DEFAULT NULL,
  `zipcode` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zipcode` (`zipcode`) USING BTREE,
  KEY `City` (`city`) USING BTREE,
  KEY `State` (`state_abbreviation`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=46827 DEFAULT CHARSET=utf8 COMMENT='pais-edo-city';

--
-- Dumping data for table `multimarket`.`ubicacion`
--

/*!40000 ALTER TABLE `ubicacion` DISABLE KEYS */;
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46358,'VEN','NU','NUEVA ESPARTA','ISLA DE COCHE','','0','0',6301),
 (46357,'VEN','NU','NUEVA ESPARTA','ISLA DE MARGARITA','*','0','0',6301),
 (46355,'VEN','NU','NUEVA ESPARTA','ISLA CUBAGUA','','0','0',6301),
 (46331,'VEN','MO','MONAGAS','ACOSTA','','0','0',6201),
 (46329,'VEN','MO','MONAGAS','AGUASAY','','0','0',6201),
 (46328,'VEN','MO','MONAGAS','ARAGUA DE MATURIN','','0','0',6201),
 (46325,'VEN','MO','MONAGAS','BARRACAS DEL ORINOCO','','0','0',6201),
 (46324,'VEN','MO','MONAGAS','BOLIVAR','','0','0',6201),
 (46320,'VEN','MO','MONAGAS','CAICARA DE MATURIN','','0','0',6201),
 (46318,'VEN','MO','MONAGAS','CARIPE','','0','0',6201),
 (46317,'VEN','MO','MONAGAS','CARIPITO','','0','0',6201),
 (46316,'VEN','MO','MONAGAS','CEDEÑO','','0','0',6201),
 (46314,'VEN','MO','MONAGAS','EL COROZO','','0','0',6201),
 (46312,'VEN','MO','MONAGAS','EZEQUIEL ZAMORA','','0','0',6201),
 (46308,'VEN','MO','MONAGAS','LIBERTADOR','','0','0',6201);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46306,'VEN','MO','MONAGAS','MATURIN','*','0','0',6201),
 (46302,'VEN','MO','MONAGAS','OTROS','','0','0',6201),
 (46301,'VEN','MO','MONAGAS','PIAR','','0','0',6201),
 (46298,'VEN','MO','MONAGAS','PUNCELES','','0','0',6201),
 (46297,'VEN','MO','MONAGAS','PUNTA DE MATA','','0','0',6201),
 (46296,'VEN','MO','MONAGAS','QUIRIQUIRE','','0','0',6201),
 (46295,'VEN','MO','MONAGAS','SAN ANTONIO DE MATURIN','','0','0',6201),
 (46294,'VEN','MO','MONAGAS','SANTA BARBARA','','0','0',6201),
 (46293,'VEN','MO','MONAGAS','SOTILLO','','0','0',6201),
 (46292,'VEN','MO','MONAGAS','TEMBLADOR','','0','0',6201),
 (46289,'VEN','MO','MONAGAS','URACOA','','0','0',6201),
 (46258,'VEN','MI','MIRANDA','CARRIZAL','','0','0',1061),
 (46255,'VEN','MI','MIRANDA','COSTA MIRANDINA','','0','0',1061),
 (46251,'VEN','MI','MIRANDA','GUARENAS','','0','0',1061),
 (46249,'VEN','MI','MIRANDA','GUATIRE','','0','0',1061),
 (46247,'VEN','MI','MIRANDA','LOS TEQUES','*','0','0',1061);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46246,'VEN','MI','MIRANDA','SAN ANTONIO','','0','0',1061),
 (46245,'VEN','MI','MIRANDA','VALLES DEL TUY','','0','0',1061),
 (46099,'VEN','ME','MERIDA','TOVAR','','0','0',5101),
 (46096,'VEN','ME','MERIDA','SANTO DOMINGO','','0','0',5101),
 (46095,'VEN','ME','MERIDA','SANTA ELENA DE ARENALES','','0','0',5101),
 (46094,'VEN','ME','MERIDA','SANTA CRUZ DE MORA','','0','0',5101),
 (46092,'VEN','ME','MERIDA','SAN JUAN DE LAGUNILLAS','','0','0',5101),
 (46086,'VEN','ME','MERIDA','MERIDA','*','0','0',5101),
 (46083,'VEN','ME','MERIDA','MUCUCHIES','','0','0',5101),
 (46082,'VEN','ME','MERIDA','MUCUCHACHI','','0','0',5101),
 (46080,'VEN','ME','MERIDA','MESA BOLIVAR','','0','0',5101),
 (46065,'VEN','ME','MERIDA','LA MESA DE EJIDO','','0','0',5101),
 (46060,'VEN','ME','MERIDA','JAJI','','0','0',5101),
 (46056,'VEN','ME','MERIDA','EL VIGIA','','0','0',5101),
 (46053,'VEN','ME','MERIDA','EJIDO','','0','0',5101),
 (46046,'VEN','ME','MERIDA','BAILADORES','','0','0',5101);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45987,'VEN','GU','GUARICO','ALTAGRACIA DE ORITUCO','','0','0',2301),
 (45976,'VEN','GU','GUARICO','CAZORLA','','0','0',2301),
 (45973,'VEN','GU','GUARICO','CHAGUARAMAS','','0','0',2301),
 (45969,'VEN','GU','GUARICO','EL CALVARIO','','0','0',2301),
 (45967,'VEN','GU','GUARICO','EL RASTRO','','0','0',2301),
 (45966,'VEN','GU','GUARICO','EL SOCORRO','','0','0',2301),
 (45964,'VEN','GU','GUARICO','EL SOMBREO','','0','0',2301),
 (45962,'VEN','GU','GUARICO','GUARDATINAJAS','','0','0',2301),
 (45961,'VEN','GU','GUARICO','GUAYABAL','','0','0',2301),
 (45959,'VEN','GU','GUARICO','LAS MERCEDES','','0','0',2301),
 (45958,'VEN','GU','GUARICO','LEZAMA','','0','0',2301),
 (45957,'VEN','GU','GUARICO','LIBERTAD DE ORITUCO','','0','0',2301),
 (45955,'VEN','GU','GUARICO','ORTIZ','','0','0',2301),
 (45953,'VEN','GU','GUARICO','OTRAS POBLACIONES','','0','0',2301),
 (45951,'VEN','GU','GUARICO','PARAPARA','','0','0',2301),
 (45929,'VEN','FA','FALCON','ACOSTA','','0','0',4101);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45925,'VEN','FA','FALCON','BOLIVAR','','0','0',4101),
 (45923,'VEN','FA','FALCON','BUCHIVACOA','','0','0',4101),
 (45922,'VEN','FA','FALCON','CACIQUE MANAURE','','0','0',4101),
 (45920,'VEN','FA','FALCON','CHICHIRIVICHE','','0','0',4101),
 (45919,'VEN','FA','FALCON','COLINA','','0','0',4101),
 (45918,'VEN','FA','FALCON','DABAJURO','','0','0',4101),
 (45915,'VEN','FA','FALCON','DEMOCRACIA','','0','0',4101),
 (45914,'VEN','FA','FALCON','FALCON','','0','0',4101),
 (45913,'VEN','FA','FALCON','FEDERACION','','0','0',4101),
 (45912,'VEN','FA','FALCON','JACURA','','0','0',4101),
 (45911,'VEN','FA','FALCON','LOS TAQUES','','0','0',4101),
 (45910,'VEN','FA','FALCON','MAUROA','','0','0',4101),
 (45905,'VEN','FA','FALCON','MIRANDA (CORO)','','0','0',4101),
 (45899,'VEN','FA','FALCON','MONSEÑOR ITURRIZA','','0','0',4101),
 (45894,'VEN','FA','FALCON','MORROCOY','','0','0',4101),
 (45892,'VEN','FA','FALCON','PALMASOLA','','0','0',4101);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45891,'VEN','FA','FALCON','PETIT','','0','0',4101),
 (45889,'VEN','FA','FALCON','PUNTO FIJO','','0','0',4101),
 (46781,'VEN','LA','LARA','ANDRES ELOY BLANCO','','0','0',6400),
 (46782,'VEN','LA','LARA','BARQUISIMETO','*','0','0',6400),
 (46783,'VEN','LA','LARA','CABUDARE','','0','0',6400),
 (46784,'VEN','LA','LARA','CRESPO','','0','0',6400),
 (46785,'VEN','LA','LARA','JIMENEZ','','0','0',6400),
 (46786,'VEN','LA','LARA','LOMAS DE TABURE','','0','0',6400),
 (46787,'VEN','LA','LARA','MORAN','','0','0',6400),
 (46788,'VEN','LA','LARA','PUERTAS DEL SOL','','0','0',6400),
 (46789,'VEN','LA','LARA','SIMON PLANAS','','0','0',6400),
 (46790,'VEN','LA','LARA','TORRES','','0','0',6400),
 (46791,'VEN','LA','LARA','URDANETA','','0','0',6400),
 (45649,'VEN','DI','DISTRITO CAPITAL','CARACAS - SUCRE (SUR)','','0','0',1000),
 (45648,'VEN','DI','DISTRITO CAPITAL','CARACAS - SUCRE (NORESTE)','','0','0',1000),
 (45647,'VEN','DI','DISTRITO CAPITAL','CARACAS - SUCRE (ESTE)','','0','0',1000);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45646,'VEN','DI','DISTRITO CAPITAL','CARACAS - SUCRE (CENTRO)','','0','0',1000),
 (45645,'VEN','DI','DISTRITO CAPITAL','CARACAS - SUCRE','','0','0',1000),
 (45644,'VEN','DI','DISTRITO CAPITAL','CARACAS - LIBERTADOR (SUROESTE)','','0','0',1000),
 (45642,'VEN','DI','DISTRITO CAPITAL','CARACAS - LIBERTADOR (SURESTE)','','0','0',1000),
 (45641,'VEN','DI','DISTRITO CAPITAL','CARACAS - LIBERTADOR (SUR)','','0','0',1000),
 (45640,'VEN','DI','DISTRITO CAPITAL','CARACAS - LIBERTADOR (NORESTE)','','0','0',1000),
 (45638,'VEN','DI','DISTRITO CAPITAL','CARACAS - LIBERTADOR','','0','0',1000),
 (45637,'VEN','DI','DISTRITO CAPITAL','CARACAS - BARUTA (SUROESTE)','','0','0',1000),
 (45636,'VEN','DI','DISTRITO CAPITAL','CARACAS - EL HATILLO (SUR)','','0','0',1000),
 (45635,'VEN','DI','DISTRITO CAPITAL','CARACAS - EL HATILLO (NORTE)','','0','0',1000),
 (45633,'VEN','DI','DISTRITO CAPITAL','CARACAS - CHACAO  (NORTE)','','0','0',1000),
 (45630,'VEN','DI','DISTRITO CAPITAL','CARACAS - BARUTA (NORTE)','','0','0',1000);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45629,'VEN','DI','DISTRITO CAPITAL','CARACAS - BARUTA (ESTE)','','0','0',1000),
 (45486,'VEN','DI','DISTRITO CAPITAL','CARACAS - BARUTA (CENTRAL)','','0','0',1223),
 (45485,'VEN','DI','DISTRITO CAPITAL','CARACAS - BARUTA','','0','0',1000),
 (45480,'VEN','DE','DELTA AMACURO','ANTONIO DIAZ (CURIAPO)','','0','0',6401),
 (45477,'VEN','DE','DELTA AMACURO','CASACOIMA (SIERRA IMATACA)','','0','0',6401),
 (45476,'VEN','DE','DELTA AMACURO','PEDERNALES (PEDERNALES)','','0','0',6401),
 (45475,'VEN','DE','DELTA AMACURO','TUCUPITA (TUCUPITA)','*','0','0',6401),
 (46767,'VEN','DF','DEPENDENCIAS FEDERALES','ARCHIP. LAS AVES','','0','0',7000),
 (45471,'VEN','CO','COJEDES','CIUDAD DE COJEDES','','0','0',2201),
 (45469,'VEN','CO','COJEDES','VALLECITO','','0','0',2207),
 (45468,'VEN','CO','COJEDES','TINACO','','0','0',2206),
 (45463,'VEN','CO','COJEDES','LAS VEGAS','','0','0',2204),
 (45460,'VEN','CO','COJEDES','GUADARRAMA','','0','0',2213);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45459,'VEN','CO','COJEDES','EL PAO','','0','0',2214),
 (45458,'VEN','CO','COJEDES','EL BAUL','','0','0',2213),
 (45457,'VEN','CO','COJEDES','EL AMPARO','','0','0',2216),
 (45454,'VEN','CO','COJEDES','ARISMENDI','','0','0',2213),
 (46773,'VEN','DF','DEPENDENCIAS FEDERALES','ISLA LA ORCHILA','','0','0',7000),
 (46774,'VEN','DF','DEPENDENCIAS FEDERALES','ISLA LA SOLA','','0','0',7000),
 (46775,'VEN','DF','DEPENDENCIAS FEDERALES','ISLA LA TORTUGA','','0','0',7000),
 (46776,'VEN','DF','DEPENDENCIAS FEDERALES','ISLA LOS TESTIGOS','','0','0',7000),
 (46777,'VEN','DF','DEPENDENCIAS FEDERALES','ISLA LOS FRAILES','','0','0',7000),
 (46778,'VEN','DF','DEPENDENCIAS FEDERALES','ISLA LOS HERMANOS','','0','0',7000),
 (45436,'VEN','CA','CARABOBO','LIBERTADOR (TOCUYITO)','','0','0',2039),
 (45413,'VEN','CA','CARABOBO','SAN JOAQUIN (SAN JOAQUIN)','','0','0',2001),
 (45405,'VEN','CA','CARABOBO','PUERTO CABELLO (PUERTO CABELLO)','','0','0',2001),
 (45391,'VEN','CA','CARABOBO','CARLOS ARVELO (GUIGUE)','','0','0',2001);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45389,'VEN','CA','CARABOBO','NAGUANAGUA (NAGUANAGUA)','','0','0',2001),
 (45388,'VEN','CA','CARABOBO','MONTALBAN (MONTALBAN)','','0','0',2001),
 (45387,'VEN','CA','CARABOBO','MIARANDA (MIRANDA)','','0','0',2001),
 (45386,'VEN','CA','CARABOBO','LOS GUAYOS (LOS GUAYOS)','','0','0',2001),
 (45385,'VEN','CA','CARABOBO','JUAN JOSE MORA (MORON)','','0','0',2001),
 (45384,'VEN','CA','CARABOBO','GUACARA (GUACARA)','','0','0',2001),
 (45383,'VEN','CA','CARABOBO','DIEGO IBARRA (MARIARA)','','0','0',2001),
 (45377,'VEN','BO','BOLIVAR','VISTA HERMOSA','','0','0',8001),
 (45375,'VEN','BO','BOLIVAR','TUMEREMO','','0','0',8057),
 (45365,'VEN','BO','BOLIVAR','PUERTO ORDAZ','','0','0',8050),
 (45363,'VEN','BO','BOLIVAR','MATANZAS','','0','0',8001),
 (45351,'VEN','BO','BOLIVAR','GUASIPATI','','0','0',8050),
 (45350,'VEN','BO','BOLIVAR','EL PAO','','0','0',8050),
 (45346,'VEN','BO','BOLIVAR','EL DORADO','','0','0',8050),
 (45345,'VEN','BO','BOLIVAR','EL CALLAO','','0','0',8056);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45339,'VEN','BA','BARINAS','ALBERTO ARVELO T. (SABANETA)','','0','0',5201),
 (45331,'VEN','BA','BARINAS','ANDRES ELOY GLANCO (EL CANTON)','','0','0',5201),
 (45326,'VEN','BA','BARINAS','ANTONIO JOSE DE SUCRE (SOCOPO)','','0','0',5201),
 (45323,'VEN','BA','BARINAS','ARISMENDI (ARISMENDI)','','0','0',5203),
 (45321,'VEN','BA','BARINAS','BARINAS (BARINAS)','*','0','0',5216),
 (45316,'VEN','BA','BARINAS','BOLIVAR (BARINITAS)','','0','0',5201),
 (45314,'VEN','BA','BARINAS','CRUZ PAREDES (BARRANCAS)','','0','0',5201),
 (45313,'VEN','BA','BARINAS','EZEQUIEL ZAMORA (SANTA BARBARA)','','0','0',5201),
 (45310,'VEN','BA','BARINAS','OBISPOS (OBISPOS)','','0','0',5201),
 (45309,'VEN','BA','BARINAS','OTROS','','0','0',5201),
 (45305,'VEN','BA','BARINAS','PEDRAZA (CIUDAD BOLIVAR)','','0','0',5214),
 (45303,'VEN','BA','BARINAS','ROJAS (LIBERTAD)','','0','0',5201),
 (45300,'VEN','BA','BARINAS','SOSA (CIUDAD DE NUTRIAS)','','0','0',5201),
 (45298,'VEN','AR','ARAGUA','SAN MATEO (BOLIVAR)','','0','0',2101);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45295,'VEN','AR','ARAGUA','CAMATAGUA','','0','0',2335),
 (45294,'VEN','AR','ARAGUA','SANTA RITA (FCO. LINAREA ALCANTARA)','','0','0',2301),
 (45290,'VEN','AR','ARAGUA','MARACAY (GIRARDOT)','*','0','0',2113),
 (45289,'VEN','AR','ARAGUA','SANTA CRUZ DE ARAGUA (JOSE ANGEL LAMAS)','','0','0',2112),
 (45288,'VEN','AR','ARAGUA','LA VICTORIA (JOSE FELIX RIBAS)','','0','0',2128),
 (45286,'VEN','AR','ARAGUA','EL CONCEJO (JOSE RAFAEL REVEGA)','','0','0',2112),
 (45283,'VEN','AR','ARAGUA','PALO NEGRO (LIBERTADOR)','','0','0',2118),
 (45282,'VEN','AR','ARAGUA','EL LIMON (MARIO BRICEÑO IRRAGORRY)','','0','0',2119),
 (45279,'VEN','AR','ARAGUA','OCUMARE DE LA COSTA DE ORO','','0','0',2117),
 (45278,'VEN','AR','ARAGUA','SAN CASIMIRO','','0','0',2105),
 (45277,'VEN','AR','ARAGUA','SAN SEBASTIAN','','0','0',2126),
 (45275,'VEN','AR','ARAGUA','TURMERO (SANTIAGO MARIÑO)','','0','0',2122),
 (45274,'VEN','AR','ARAGUA','LAS TEJERIAS (SANTOS MICHELENA)','','0','0',2101);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45273,'VEN','AP','APURE','ACHAGUAS (ACHAGUAS)','','0','0',7001),
 (45272,'VEN','AP','APURE','BIRUACA (BIRUACA)','','0','0',7001),
 (45271,'VEN','AP','APURE','MUÑOZ (BRUZUAL)','','0','0',7004),
 (45269,'VEN','AP','APURE','OTRAS POBLACIONES','','0','0',7001),
 (45268,'VEN','AP','APURE','PEDRO CAMEJO (SAN JUAN DE PAYARA)','','0','0',7001),
 (45267,'VEN','AP','APURE','PAEZ (GUASDUALITO)','','0','0',7001),
 (45266,'VEN','AP','APURE','ROMULO GALLEGOS (ELORZA)','','0','0',7010),
 (45264,'VEN','AP','APURE','SAN FERNANDO (SAN FERNANDO DE APURE)','*','0','0',7001),
 (45248,'VEN','AN','ANZOATEGUI','ANACO','','0','0',6032),
 (45247,'VEN','AN','ANZOATEGUI','ARAGUA DE BARCELONA','','0','0',6001),
 (45246,'VEN','AN','ANZOATEGUI','BARCELONA','*','0','0',6057),
 (45243,'VEN','AN','ANZOATEGUI','LECHERIAS','','0','0',6001),
 (45241,'VEN','AN','ANZOATEGUI','OTRAS POBLACIONES','','0','0',6001),
 (45240,'VEN','AN','ANZOATEGUI','PUERTO LA CRUZ','','0','0',6027);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45238,'VEN','AN','ANZOATEGUI','SAN PABLO','','0','0',6001),
 (45232,'VEN','AN','ANZOATEGUI','SABANA DE UCHIRE','','0','0',6001),
 (45231,'VEN','AN','ANZOATEGUI','PIRITU','','0','0',6022),
 (45230,'VEN','AN','ANZOATEGUI','PUERTO PIRITU','','0','0',6022),
 (45226,'VEN','AN','ANZOATEGUI','PARIAGUAN','','0','0',6052),
 (45205,'VEN','AN','ANZOATEGUI','CLARINES','','0','0',6008),
 (46108,'VEN','ME','MERIDA','OTRAS POBLACIONES','','0','0',5101),
 (46779,'VEN','GU','GUARICO','CANTAGALLO','','0','0',2301),
 (46780,'VEN','GU','GUARICO','CAMAGUAN','','0','0',2301),
 (46098,'VEN','ME','MERIDA','TIMOTES','','0','0',5101),
 (46097,'VEN','ME','MERIDA','TABAY','','0','0',5101),
 (46093,'VEN','ME','MERIDA','SAN RAFAEL DE MUCUCHIES','','0','0',5101),
 (46090,'VEN','ME','MERIDA','SAN JACINTO','','0','0',5101),
 (46089,'VEN','ME','MERIDA','PUEBL NUEVO','','0','0',5101),
 (46061,'VEN','ME','MERIDA','LA AZULITA','','0','0',5101),
 (46044,'VEN','ME','MERIDA','APARTADEROS','','0','0',5101);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45859,'VEN','DI','DISTRITO CAPITAL','CARACAS - CHACAO (SUR)','','0','0',1000),
 (46765,'VEN','DI','DISTRITO CAPITAL','CARACAS','*','0','0',1000),
 (45643,'VEN','DI','DISTRITO CAPITAL','CARACAS - LIBERTADOR (OESTE)','','0','0',1000),
 (45639,'VEN','DI','DISTRITO CAPITAL','CARACAS - LIBERTADOR (CENTRO)','','0','0',1000),
 (45634,'VEN','DI','DISTRITO CAPITAL','CARACAS - EL HATILLO','','0','0',1000),
 (45632,'VEN','DI','DISTRITO CAPITAL','CARACAS - CHACAO','','0','0',1000),
 (45631,'VEN','DI','DISTRITO CAPITAL','CARACAS - BARUTA (SUR)','','0','0',1000),
 (45596,'VEN','DI','DISTRITO CAPITAL','CARACAS - SUCRE (NORTE)','','0','0',1000),
 (46793,'VEN','TA','TACHIRA','SAN CRISTOBAL','*','0','0',5001),
 (46794,'VEN','GU','GUARICO','SAN JUAN DE LOS MORROS','*','0','0',2301),
 (45414,'VEN','CA','CARABOBO','VALENCIA (GRAN VALENCIA)','*','0','0',2001),
 (45406,'VEN','CA','CARABOBO','SAN DIEGO (SAN DIEGO)','','0','0',2001),
 (45382,'VEN','CA','CARABOBO','BEJUMA (BEJUMA)','','0','0',2001);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45380,'VEN','BO','BOLIVAR','OTRAS POBLACIONES','','0','0',8001),
 (45378,'VEN','BO','BOLIVAR','CIUDAD GUAYANA','','0','0',8050),
 (45376,'VEN','BO','BOLIVAR','UPATA','','0','0',8052),
 (45371,'VEN','BO','BOLIVAR','SANTA ELENA DE UAIREN','','0','0',8011),
 (45368,'VEN','BO','BOLIVAR','SAN FELIX','','0','0',8051),
 (45343,'VEN','BO','BOLIVAR','CIUDAD PIAR','','0','0',8003),
 (45342,'VEN','BO','BOLIVAR','CIUDAD BOLIVAR','*','0','0',8001),
 (46766,'VEN','BO','BOLIVAR','CAICARA DEL ORINOCO','','0','0',8001),
 (45297,'VEN','AR','ARAGUA','CAGUA (SUCRE)','','0','0',2340),
 (45296,'VEN','AR','ARAGUA','LA COLONIA TOVAR (TOVAR)','','0','0',2338),
 (45293,'VEN','AR','ARAGUA','BARBACOAS (URDANETA)','','0','0',2127),
 (45292,'VEN','AR','ARAGUA','VILLA DE CURA (ZAMORA)','','0','0',2122),
 (46795,'VEN','FA','FALCON','CORO','*','0','0',4101),
 (46796,'VEN','FA','FALCON','CUMAREBO','','0','0',4101),
 (46797,'VEN','CO','COJEDES','TINAQUILLO','','0','0',2201);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46798,'VEN','MI','MIRANDA','CHARALLAVE','','0','0',1061),
 (45249,'VEN','AN','ANZOATEGUI','ZUATA','','0','0',6057),
 (45214,'VEN','AN','ANZOATEGUI','GUANTA','','0','0',6014),
 (45212,'VEN','AN','ANZOATEGUI','EL TIGRE','','0','0',6050),
 (45210,'VEN','AN','ANZOATEGUI','EL PAO','','0','0',6001),
 (45201,'VEN','AN','ANZOATEGUI','BOCA DE UCHIRE','','0','0',6005),
 (46768,'VEN','DF','DEPENDENCIAS FEDERALES','ARCHIP. LOS MONJES','','0','0',7000),
 (46769,'VEN','DF','DEPENDENCIAS FEDERALES','ARCHIP. LOS ROQUES','*','0','0',7000),
 (46770,'VEN','DF','DEPENDENCIAS FEDERALES','ISLA DE AVES','','0','0',7000),
 (46771,'VEN','DF','DEPENDENCIAS FEDERALES','ISLA DE PATOS','','0','0',7000),
 (46772,'VEN','DF','DEPENDENCIAS FEDERALES','ISLA LA BLANQUILLA','','0','0',7000),
 (45472,'VEN','CO','COJEDES','OTRAS POBLACIONES','','0','0',2201),
 (45467,'VEN','CO','COJEDES','SAN CARLOS','*','0','0',2201),
 (45461,'VEN','CO','COJEDES','LA AGUADITA','','0','0',2207);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (45456,'VEN','CO','COJEDES','COJEDITOS','','0','0',2201),
 (46389,'VEN','PO','PORTUGUESA','ACARIGUA','*','0','0',3301),
 (46390,'VEN','PO','PORTUGUESA','AGUA BLANCA','','0','0',3301),
 (46392,'VEN','PO','PORTUGUESA','ARAURE','','0','0',3301),
 (46393,'VEN','PO','PORTUGUESA','BISCUCUY','','0','0',3301),
 (46394,'VEN','PO','PORTUGUESA','BOCONOITO','','0','0',3301),
 (46398,'VEN','PO','PORTUGUESA','EL PLAYON','','0','0',3301),
 (46399,'VEN','PO','PORTUGUESA','GUANARE','','0','0',3301),
 (46400,'VEN','PO','PORTUGUESA','GUANARITO','','0','0',3301),
 (46406,'VEN','PO','PORTUGUESA','OSPINO','','0','0',3301),
 (46407,'VEN','PO','PORTUGUESA','PAPELON','','0','0',3301),
 (46409,'VEN','PO','PORTUGUESA','PIRITU PORTUGUESA','','0','0',3301),
 (46410,'VEN','PO','PORTUGUESA','SAN RAFAEL DE ONOTO','','0','0',3301),
 (46411,'VEN','PO','PORTUGUESA','SAN CARLOS','','0','0',3301),
 (46413,'VEN','PO','PORTUGUESA','VIA BARQUISIMETO-ACARIGUA','','0','0',3301);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46414,'VEN','PO','PORTUGUESA','VILLA BRUZUAL','','0','0',3301),
 (46415,'VEN','PO','PORTUGUESA','LA CONCEPCION','','0','0',3301),
 (46416,'VEN','PO','PORTUGUESA','LA TRINIDAD','','0','0',3301),
 (46417,'VEN','PO','PORTUGUESA','PARAISO DE CHABASQUEN','','0','0',3301),
 (46419,'VEN','PO','PORTUGUESA','OTRAS POBLACIONES','','0','0',3301),
 (46421,'VEN','SU','SUCRE','ALTOS DE SANTA FE','','0','0',6150),
 (46422,'VEN','SU','SUCRE','ARAYA','','0','0',6150),
 (46423,'VEN','SU','SUCRE','ALTOS DE SUCRE','','0','0',6150),
 (46424,'VEN','SU','SUCRE','ARAPO','','0','0',6150),
 (46425,'VEN','SU','SUCRE','CAIGUIRE','','0','0',6150),
 (46428,'VEN','SU','SUCRE','CARIACO','','0','0',6150),
 (46429,'VEN','SU','SUCRE','CARUPANO','','0','0',6150),
 (46430,'VEN','SU','SUCRE','CASANAY','','0','0',6150),
 (46432,'VEN','SU','SUCRE','CUMANACOA','','0','0',6150),
 (46433,'VEN','SU','SUCRE','CUMANA','*','0','0',6150),
 (46437,'VEN','SU','SUCRE','EL PILAR','','0','0',6150);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46441,'VEN','SU','SUCRE','GOLFO DE CARIACO','','0','0',6150),
 (46442,'VEN','SU','SUCRE','GUIRIA','','0','0',6150),
 (46443,'VEN','SU','SUCRE','IRAPA','','0','0',6150),
 (46444,'VEN','SU','SUCRE','LOS BORDONES','','0','0',6150),
 (46445,'VEN','SU','SUCRE','MACARAPANA','','0','0',6150),
 (46448,'VEN','SU','SUCRE','MARIGUITAR','','0','0',6150),
 (46449,'VEN','SU','SUCRE','MOCHIMA','','0','0',6150),
 (46450,'VEN','SU','SUCRE','NUEVA CUMANA','','0','0',6150),
 (46451,'VEN','SU','SUCRE','OTRAS POBLACIONES','','0','0',6150),
 (46452,'VEN','SU','SUCRE','PARC. MIRANDA','','0','0',6150),
 (46453,'VEN','SU','SUCRE','PLAYA COLORADA','','0','0',6150),
 (46454,'VEN','SU','SUCRE','RIO CARIBE','','0','0',6150),
 (46455,'VEN','SU','SUCRE','RIO CARIBE - PLAYA MEDINA','','0','0',6150),
 (46459,'VEN','SU','SUCRE','SAN JUAN DE UNARE','','0','0',6150),
 (46460,'VEN','SU','SUCRE','SAN JUAN DE LAS GALDONAS','','0','0',6150),
 (46461,'VEN','SU','SUCRE','SAN JOSE DE AEROCUAR','','0','0',6150);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46466,'VEN','SU','SUCRE','TUNAPUY','','0','0',6150),
 (46478,'VEN','SU','SUCRE','UNARE','','0','0',6150),
 (46479,'VEN','SU','SUCRE','VIA CARIACO-CASANAY','','0','0',6150),
 (46484,'VEN','SU','SUCRE','YAGUARAPARO','','0','0',6150),
 (46485,'VEN','TA','TACHIRA','ANDRES BELLO','','0','0',5001),
 (46486,'VEN','TA','TACHIRA','ANTONIO ROMULO COSTA','','0','0',5001),
 (46487,'VEN','TA','TACHIRA','AYACUCHO','','0','0',5001),
 (46488,'VEN','TA','TACHIRA','BOLIVAR','','0','0',5001),
 (46489,'VEN','TA','TACHIRA','CARDENAS','','0','0',5001),
 (46490,'VEN','TA','TACHIRA','FERNANDEZ FEO','','0','0',5001),
 (46491,'VEN','TA','TACHIRA','FRANCISCO DE MIRANDA','','0','0',5001),
 (46492,'VEN','TA','TACHIRA','GARCIA DE HEVIA','','0','0',5001),
 (46493,'VEN','TA','TACHIRA','GUASIMOS','','0','0',5001),
 (46494,'VEN','TA','TACHIRA','INDEPENDENCIA','','0','0',5001),
 (46495,'VEN','TA','TACHIRA','JOSE MARIA VARGAS','','0','0',5001),
 (46496,'VEN','TA','TACHIRA','JUNIN','','0','0',5001);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46497,'VEN','TA','TACHIRA','LIBERTAD','','0','0',5001),
 (46498,'VEN','TA','TACHIRA','JAUREGUI','','0','0',5001),
 (46499,'VEN','TA','TACHIRA','LIBERTADOR','','0','0',5001),
 (46500,'VEN','TA','TACHIRA','LOBATERA','','0','0',5001),
 (46501,'VEN','TA','TACHIRA','MICHELENA','','0','0',5001),
 (46502,'VEN','TA','TACHIRA','PANAMERICANO','','0','0',5001),
 (46503,'VEN','TA','TACHIRA','SAMUEL DARIO MALDONADO','','0','0',5001),
 (46559,'VEN','TR','TRUJILLO','ANDRES BELLO (SANTA ISABEL)','','0','0',5001),
 (46560,'VEN','TR','TRUJILLO','BOCONO','','0','0',5001),
 (46561,'VEN','TR','TRUJILLO','BOLIVAR (SABANA GRANDE)','','0','0',5001),
 (46562,'VEN','TR','TRUJILLO','CANDELARIA (CHEJENDE)','','0','0',5001),
 (46563,'VEN','TR','TRUJILLO','CARACHE','','0','0',5001),
 (46564,'VEN','TR','TRUJILLO','EL COROZO','','0','0',5001),
 (46565,'VEN','TR','TRUJILLO','ESCUQUE','','0','0',5001),
 (46566,'VEN','TR','TRUJILLO','EL PARADERO','','0','0',5001);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46567,'VEN','TR','TRUJILLO','CAMPO ELIAS','','0','0',5001),
 (46568,'VEN','TR','TRUJILLO','LA CEIBA (SANTA APOLONIA)','','0','0',5001),
 (46569,'VEN','TR','TRUJILLO','LA PUERTA','','0','0',5001),
 (46570,'VEN','TR','TRUJILLO','MIRANDA (EL DIVIDIVE)','','0','0',5001),
 (46571,'VEN','TR','TRUJILLO','MONTE CARMELO','','0','0',5001),
 (46572,'VEN','TR','TRUJILLO','MOTATAN','','0','0',5001),
 (46573,'VEN','TR','TRUJILLO','OTRAS POBLACIONES','','0','0',5001),
 (46574,'VEN','TR','TRUJILLO','PANPARITO','','0','0',5001),
 (46575,'VEN','TR','TRUJILLO','PAMPAN','','0','0',5001),
 (46576,'VEN','TR','TRUJILLO','BETIJOQUE','','0','0',5001),
 (46577,'VEN','TR','TRUJILLO','SAN RAFAEL DE (CARVAJAL)','','0','0',5001),
 (46578,'VEN','TR','TRUJILLO','SUCRE (SABANA DE MENDOZA)','','0','0',5001),
 (46579,'VEN','TR','TRUJILLO','TRUJILLO','','0','0',5001),
 (46580,'VEN','TR','TRUJILLO','URDANETA (LA QUEBRADA)','','0','0',5001),
 (46581,'VEN','TR','TRUJILLO','VALERA (VALERA)','*','0','0',5001);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46631,'VEN','VA','VARGAS','CARABALLEDA','','0','0',1160),
 (46632,'VEN','VA','VARGAS','CARAYACA','','0','0',1160),
 (46633,'VEN','VA','VARGAS','CARLOS SOUBLETTE','','0','0',1160),
 (46634,'VEN','VA','VARGAS','CARUAO','','0','0',1160),
 (46635,'VEN','VA','VARGAS','CATIA LA MAR','','0','0',1160),
 (46636,'VEN','VA','VARGAS','LA GUAIRA','*','0','0',1160),
 (46637,'VEN','VA','VARGAS','MACUTO','','0','0',1160),
 (46638,'VEN','VA','VARGAS','MAIQUETIA','','0','0',1160),
 (46639,'VEN','VA','VARGAS','NAIGUATA','','0','0',1160),
 (46640,'VEN','VA','VARGAS','PARQUE NACIONAL EL AVILA','','0','0',1160),
 (46651,'VEN','YA','YARACUY','AROA','','0','0',3201),
 (46652,'VEN','YA','YARACUY','BORAURE','','0','0',3201),
 (46654,'VEN','YA','YARACUY','CHIVACOA','','0','0',3201),
 (46655,'VEN','YA','YARACUY','COROCOTE','','0','0',3201),
 (46659,'VEN','YA','YARACUY','FARRIAR','','0','0',3201),
 (46660,'VEN','YA','YARACUY','GUAMA','','0','0',3201);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46662,'VEN','YA','YARACUY','INDEPENCIA','','0','0',3201),
 (46666,'VEN','YA','YARACUY','NIRGUA','','0','0',3201),
 (46667,'VEN','YA','YARACUY','SABANA DE PARRA','','0','0',3201),
 (46668,'VEN','YA','YARACUY','OTRAS POBLACIONES','','0','0',3201),
 (46669,'VEN','YA','YARACUY','SAN FELIPE','*','0','0',3201),
 (46670,'VEN','YA','YARACUY','SAN PABLO','','0','0',3201),
 (46673,'VEN','YA','YARACUY','URACHICHE','','0','0',3201),
 (46674,'VEN','YA','YARACUY','YARITAGUA','','0','0',3201),
 (46676,'VEN','YA','YARACUY','QUIRIQUIRE','','0','0',3201),
 (46677,'VEN','ZU','ZULIA','MARACAIBO','*','0','0',4001),
 (46678,'VEN','ZU','ZULIA','BARALT','','0','0',4001),
 (46799,'VEN','GU','GUARICO','CALABOZO','','0','0',2301),
 (46681,'VEN','ZU','ZULIA','CABIMAS','','0','0',4001),
 (46682,'VEN','ZU','ZULIA','COLON','','0','0',4001),
 (46683,'VEN','ZU','ZULIA','FRANCISCO JAVIER PULGAR','','0','0',4001),
 (46684,'VEN','ZU','ZULIA','JESUS MARIA SEMPRUN','','0','0',4001);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46685,'VEN','ZU','ZULIA','LA CAÑADA DE URDANETA','','0','0',4001),
 (46704,'VEN','ZU','ZULIA','LAGUNILLAS','','0','0',4001),
 (46710,'VEN','ZU','ZULIA','MACHIQUES DE PERIJA','','0','0',4001),
 (46711,'VEN','ZU','ZULIA','PAEZ','','0','0',4001),
 (46712,'VEN','ZU','ZULIA','ROSARIO DE PERIJA','','0','0',4001),
 (46720,'VEN','ZU','ZULIA','VALMORE RODRIGUEZ','','0','0',4001),
 (46723,'VEN','ZU','ZULIA','SAN RAFAEL DEL MOJAN','','0','0',4001),
 (46724,'VEN','ZU','ZULIA','SAN FRANCISCO','','0','0',4001),
 (46725,'VEN','ZU','ZULIA','SANTA RITA','','0','0',4001),
 (46726,'VEN','ZU','ZULIA','SIMON BOLIVAR','','0','0',4001),
 (46727,'VEN','ZU','ZULIA','SANTA RITA','','0','0',4001),
 (46728,'VEN','ZU','ZULIA','SUCRE','','0','0',4001),
 (46731,'VEN','ZU','ZULIA','ALMIRANTE PADILLA','','0','0',4001),
 (46734,'VEN','ZU','ZULIA','CATATUMBO','','0','0',4001),
 (46736,'VEN','ZU','ZULIA','JESUS ENRIQUE LOSSADA','','0','0',4001),
 (46749,'VEN','ZU','ZULIA','MARA','','0','0',4001);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46750,'VEN','ZU','ZULIA','MIRANDA','','0','0',4001),
 (46751,'VEN','ZU','ZULIA','MORALITO','','0','0',4001),
 (46754,'VEN','ZU','ZULIA','OTRAS POBLACIONES','','0','0',4001),
 (46755,'VEN','AM','AMAZONAS','MAROA ALTO ORINOCO (LA ESMERALDA)','','0','0',7101),
 (46756,'VEN','AM','AMAZONAS','ATABAPO (SAN FERNANDO DE ATABAPO)','','0','0',7101),
 (46757,'VEN','AM','AMAZONAS','ATURES (PUERTO AYACUCHO)','*','0','0',7101),
 (46758,'VEN','AM','AMAZONAS','AUTANA (ISLA RATON)','','0','0',7101),
 (46759,'VEN','AM','AMAZONAS','MANAPIARE (SAN JUAN DE MANAPIARE)','','0','0',7101),
 (46760,'VEN','AM','AMAZONAS','MAROA (MAROA)','','0','0',7101),
 (46761,'VEN','AM','AMAZONAS','OTRAS POBLACIONES','','0','0',7101),
 (46762,'VEN','AM','AMAZONAS','RIO NEGRO (SAN CARLOS DE RIO NEGRO)','','0','0',7101),
 (46800,'VEN','GU','GUARICO','VALLE LA PASCUA','','0','0',2301),
 (46802,'VEN','AM','AMAZONAS','',' ','0','0',0),
 (46803,'VEN','ZU','ZULIA','',' ','0','0',0);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46804,'VEN','GU','GUARICO','',' ','0','0',0),
 (46805,'VEN','YA','YARACUY','',' ','0','0',0),
 (46806,'VEN','VA','VARGAS','',' ','0','0',0),
 (46807,'VEN','TR','TRUJILLO','',' ','0','0',0),
 (46808,'VEN','TA','TACHIRA','',' ','0','0',0),
 (46809,'VEN','SU','SUCRE','',' ','0','0',0),
 (46810,'VEN','PO','PORTUGUESA','PORTUGUESA',' ','0','0',0),
 (46811,'VEN','CO','COJEDES','',' ','0','0',0),
 (46812,'VEN','DF','DEPENDENCIAS FEDERALES','',' ','0','0',0),
 (46814,'VEN','AN','ANZOATEGUI','',' ','0','0',0),
 (46815,'VEN','NE','NUEVA ESPARTA','',' ','0','0',0),
 (46816,'VEN','MO','MONAGAS','',' ','0','0',0),
 (46817,'VEN','CA','CARABOBO','',' ','0','0',0),
 (46818,'VEN','AR','ARAGUA','',' ','0','0',0),
 (46819,'VEN','FA','FALCON','',' ','0','0',0),
 (46820,'VEN','ME','MERIDA','',' ','0','0',0),
 (46821,'VEN','MI','MIRANDA','',' ','0','0',0),
 (46822,'VEN','BO','BOLIVAR','',' ','0','0',0),
 (46823,'VEN','LA','LARA','',' ','0','0',0);
INSERT INTO `ubicacion` (`id`,`country`,`state_abbreviation`,`state_name`,`city`,`capital`,`latitude`,`longitude`,`zipcode`) VALUES 
 (46824,'VEN','DI','DISTRITO CAPITAL','',' ','0','0',0),
 (46825,'VEN','AP','APURE','','','0','0',0),
 (46826,'VEN','DE','DELTA AMACURO','','','0','0',0);
/*!40000 ALTER TABLE `ubicacion` ENABLE KEYS */;


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
  `state` varchar(5) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '0',
  `city` int(10) unsigned NOT NULL DEFAULT 0,
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='archivo de usuarios';

--
-- Dumping data for table `multimarket`.`usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`user_id`,`firstname`,`lastname`,`email`,`login`,`password`,`usuario_foto`,`caja_id`,`created_at`,`dateofbirth`,`telefono`,`departamento`,`estatus`,`tipo`,`company_id`,`location`,`colmena_conexion`,`state`,`city`,`country`,`nombre_completo`,`pregunta_clave`,`respuesta_clave`,`tarjeta_presentacion`,`gender`,`rif`,`tcarea`,`tcnumber`) VALUES 
 (1,'Administrador','De CiudadHive','ciudadhive@gmail.com','ciudadhive@gmail.com','$2y$10$DuMw9s52hxi01c2tnA5pfewoFpHxAv4UovPtagI3k1rlj9dhsFyr6','Administrador_18.png',1,'2024-04-12 00:00:00','1963-05-22 00:00:00','0414-4840676','Administrador principal de la aplicacion',1,'ADMINISTRATOR',1,'Residencias Las Trinitarias Torre 9 Planta Apto PBB, Ciudad Alianza',1000,'CA',45414,'VEN','Administrador Ppal De CiudadHive','cual es tu nombre?','usuario de ciudadhive',' ','M','V-7065079','0414','4840676'),
 (2,'Carlos','Peraza','carlosperazavz@gmail.com','carlosperazavz@gmail.com','$2y$10$DuMw9s52hxi01c2tnA5pfewoFpHxAv4UovPtagI3k1rlj9dhsFyr6','Carlos_67.png',1,'2024-04-12 00:00:00','1963-05-22 00:00:00','0414-4840676','Administrador principal de la aplicacion',1,'ADMINISTRATOR',5,'Residencias Las Trinitarias Torre 9 Planta Apto PBB, Ciudad Alianza',1000,'CA',45414,'VEN','Carlos Peraza','cual es tu nombre?','Carlos',' ','M','V-7065079','0414','4840676'),
 (8,'Miguel','Peraza','mikeperazaphoto@gmail.com','josegomez@gmail.com','$2y$10$.KN93Vu/iHz7VFgl8.DxweQZtJQFicnBii0oF0kxGvnOwBNpuzYm.','1234_VirginiaSanchez_24.jpg',0,'2024-05-07 00:00:00','1961-05-07 00:00:00','','Admiinistracion',1,'ASISTENTE',5,'Valencia Residnecias Martinica 2',1000,'CA',45414,'VEN','Miguel Peraza','cual es tu nombre?','usuario de ciudadhive',' ','M','7065079','414','4560079');
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


--
-- View structure for view `multimarket`.`vista_ubicacion`
--

DROP VIEW IF EXISTS `vista_ubicacion`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `multimarket`.`vista_ubicacion` AS select `multimarket`.`ubicacion`.`id` AS `id`,`multimarket`.`ubicacion`.`country` AS `country`,`multimarket`.`ubicacion`.`state_abbreviation` AS `state_abbreviation`,`multimarket`.`ubicacion`.`state_name` AS `state_name`,`multimarket`.`ubicacion`.`city` AS `city`,`multimarket`.`ubicacion`.`capital` AS `capital`,`multimarket`.`ubicacion`.`latitude` AS `latitude`,`multimarket`.`ubicacion`.`longitude` AS `longitude`,`multimarket`.`ubicacion`.`zipcode` AS `zipcode` from `multimarket`.`ubicacion`;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
