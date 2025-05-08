-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sis_inventario
CREATE DATABASE IF NOT EXISTS `sis_inventario` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sis_inventario`;

-- Volcando estructura para tabla sis_inventario.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla sis_inventario.cache: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sis_inventario.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla sis_inventario.cache_locks: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sis_inventario.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.categorias: ~6 rows (aproximadamente)
INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
	(1, 'Equipos Electromecánicos', '2017-12-21 20:53:29'),
	(2, 'Taladros', '2017-12-21 20:53:29'),
	(3, 'Andamios', '2017-12-21 20:53:29'),
	(4, 'Generadores de energía', '2017-12-21 20:53:29'),
	(5, 'Equipos para construcción', '2017-12-21 20:53:29'),
	(6, 'Martillos mecánicos', '2017-12-21 23:06:40');

-- Volcando estructura para tabla sis_inventario.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `documento` int NOT NULL,
  `email` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `telefono` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.clientes: ~10 rows (aproximadamente)
INSERT INTO `clientes` (`id`, `nombre`, `documento`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `compras`, `ultima_compra`, `fecha`) VALUES
	(3, 'Juan Villegas', 2147483647, 'juan@hotmail.com', '(300) 341-2345', 'Calle 23 # 45 - 56', '1980-11-02', 19, '2025-04-20 19:51:48', '2025-04-21 00:51:48'),
	(4, 'Pedro Pérez', 2147483647, 'pedro@gmail.com', '(399) 876-5432', 'Calle 34 N33 -56', '1970-08-07', 14, '2025-04-20 18:40:01', '2025-04-20 23:40:01'),
	(5, 'Miguel Murillo', 325235235, 'miguel@hotmail.com', '(254) 545-3446', 'calle 34 # 34 - 23', '1976-03-04', 33, '2025-04-20 18:12:10', '2025-04-20 23:12:10'),
	(6, 'Margarita Londoño', 34565432, 'margarita@hotmail.com', '(344) 345-6678', 'Calle 45 # 34 - 56', '1976-11-30', 19, '2019-05-25 01:10:41', '2019-05-25 06:10:41'),
	(7, 'Julian Ramirez', 786786545, 'julian@hotmail.com', '(675) 674-5453', 'Carrera 45 # 54 - 56', '1980-04-05', 14, '2017-12-26 17:26:28', '2017-12-26 22:26:28'),
	(8, 'Stella Jaramillo', 65756735, 'stella@gmail.com', '(435) 346-3463', 'Carrera 34 # 45- 56', '1956-06-05', 9, '2017-12-26 17:25:55', '2017-12-26 22:25:55'),
	(9, 'Eduardo López', 2147483647, 'eduardo@gmail.com', '(534) 634-6565', 'Carrera 67 # 45sur', '1978-03-04', 15, '2019-06-20 15:33:23', '2019-06-20 20:33:23'),
	(10, 'Ximena Restrepo', 436346346, 'ximena@gmail.com', '(543) 463-4634', 'calle 45 # 23 - 45', '1956-03-04', 18, '2017-12-26 17:25:08', '2017-12-26 22:25:08'),
	(11, 'David Guzman', 43634643, 'david@hotmail.com', '(354) 574-5634', 'carrera 45 # 45 ', '1967-05-04', 10, '2017-12-26 17:24:50', '2017-12-26 22:24:50'),
	(12, 'Gonzalo Pérez', 436346346, 'gonzalo@yahoo.com', '(235) 346-3464', 'Carrera 34 # 56 - 34', '1967-08-09', 24, '2017-12-25 17:24:24', '2017-12-27 00:30:12');

-- Volcando estructura para tabla sis_inventario.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla sis_inventario.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sis_inventario.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla sis_inventario.jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sis_inventario.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla sis_inventario.job_batches: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sis_inventario.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla sis_inventario.migrations: ~1 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1);

-- Volcando estructura para tabla sis_inventario.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla sis_inventario.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sis_inventario.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_categoria` int NOT NULL,
  `codigo` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `imagen` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `stock` int NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.productos: ~60 rows (aproximadamente)
INSERT INTO `productos` (`id`, `id_categoria`, `codigo`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `ventas`, `fecha`) VALUES
	(1, 1, '101', 'Aspiradora Industrial ', 'vistas/img/productos/101/105.png', 13, 1000, 1200, 2, '2017-12-24 01:11:04'),
	(2, 1, '102', 'Plato Flotante para Allanadora', 'vistas/img/productos/102/940.jpg', 6, 4500, 6300, 3, '2017-12-26 15:04:11'),
	(3, 1, '103', 'Compresor de Aire para pintura', 'vistas/img/productos/103/763.jpg', 8, 3000, 4200, 12, '2017-12-26 15:03:22'),
	(4, 1, '104', 'Cortadora de Adobe sin Disco ', 'vistas/img/productos/104/957.jpg', 16, 4000, 5600, 4, '2017-12-26 15:03:22'),
	(5, 1, '105', 'Cortadora de Piso sin Disco ', 'vistas/img/productos/105/630.jpg', 13, 1540, 2156, 7, '2017-12-26 15:03:22'),
	(6, 1, '106', 'Disco Punta Diamante ', 'vistas/img/productos/106/635.jpg', 15, 1100, 1540, 5, '2017-12-26 15:04:38'),
	(7, 1, '107', 'Extractor de Aire ', 'vistas/img/productos/107/848.jpg', 12, 1540, 2156, 8, '2017-12-26 15:04:11'),
	(8, 1, '108', 'Guadañadora ', 'vistas/img/productos/108/163.jpg', 13, 1540, 2156, 7, '2017-12-26 15:03:52'),
	(9, 1, '109', 'Hidrolavadora Eléctrica ', 'vistas/img/productos/109/769.jpg', 15, 2600, 3640, 5, '2017-12-26 15:05:09'),
	(10, 1, '110', 'Hidrolavadora Gasolina', 'vistas/img/productos/110/582.jpg', 18, 2210, 3094, 2, '2017-12-26 15:05:09'),
	(11, 1, '111', 'Motobomba a Gasolina', 'vistas/img/productos/default/anonymous.png', 20, 2860, 4004, 0, '2017-12-21 21:56:28'),
	(12, 1, '112', 'Motobomba El?ctrica', 'vistas/img/productos/default/anonymous.png', 20, 2400, 3360, 0, '2017-12-21 21:56:28'),
	(13, 1, '113', 'Sierra Circular ', 'vistas/img/productos/default/anonymous.png', 20, 1100, 1540, 0, '2017-12-21 21:56:28'),
	(14, 1, '114', 'Disco de tugsteno para Sierra circular', 'vistas/img/productos/default/anonymous.png', 20, 4500, 6300, 0, '2017-12-21 21:56:28'),
	(15, 1, '115', 'Soldador Electrico ', 'vistas/img/productos/default/anonymous.png', 20, 1980, 2772, 0, '2017-12-21 21:56:28'),
	(16, 1, '116', 'Careta para Soldador', 'vistas/img/productos/default/anonymous.png', 20, 4200, 5880, 0, '2017-12-21 21:56:28'),
	(17, 1, '117', 'Torre de iluminacion ', 'vistas/img/productos/default/anonymous.png', 20, 1800, 2520, 0, '2017-12-21 21:56:28'),
	(18, 2, '201', 'Martillo Demoledor de Piso 110V', 'vistas/img/productos/default/anonymous.png', 20, 5600, 7840, 0, '2017-12-21 21:56:28'),
	(19, 2, '202', 'Muela o cincel martillo demoledor piso', 'vistas/img/productos/default/anonymous.png', 20, 9600, 13440, 0, '2017-12-21 21:56:28'),
	(20, 2, '203', 'Taladro Demoledor de muro 110V', 'vistas/img/productos/default/anonymous.png', 20, 3850, 5390, 0, '2017-12-21 21:56:28'),
	(21, 2, '204', 'Muela o cincel martillo demoledor muro', 'vistas/img/productos/default/anonymous.png', 20, 9600, 13440, 0, '2017-12-21 21:56:28'),
	(22, 2, '205', 'Taladro Percutor de 1/2 Madera y Metal', 'vistas/img/productos/default/anonymous.png', 20, 8000, 11200, 0, '2017-12-21 22:28:24'),
	(23, 2, '206', 'Taladro Percutor SDS Plus 110V', 'vistas/img/productos/default/anonymous.png', 20, 3900, 5460, 0, '2017-12-21 21:56:28'),
	(24, 2, '207', 'Taladro Percutor SDS Max 110V (Mineria)', 'vistas/img/productos/default/anonymous.png', 20, 4600, 6440, 0, '2017-12-21 21:56:28'),
	(25, 3, '301', 'Andamio colgante', 'vistas/img/productos/default/anonymous.png', 20, 1440, 2016, 0, '2017-12-21 21:56:28'),
	(26, 3, '302', 'Distanciador andamio colgante', 'vistas/img/productos/default/anonymous.png', 20, 1600, 2240, 0, '2017-12-21 21:56:28'),
	(27, 3, '303', 'Marco andamio modular ', 'vistas/img/productos/default/anonymous.png', 20, 900, 1260, 0, '2017-12-21 21:56:28'),
	(28, 3, '304', 'Marco andamio tijera', 'vistas/img/productos/default/anonymous.png', 20, 100, 140, 0, '2017-12-21 21:56:28'),
	(29, 3, '305', 'Tijera para andamio', 'vistas/img/productos/default/anonymous.png', 20, 162, 226, 0, '2017-12-21 21:56:28'),
	(30, 3, '306', 'Escalera interna para andamio', 'vistas/img/productos/default/anonymous.png', 20, 270, 378, 0, '2017-12-21 21:56:28'),
	(31, 3, '307', 'Pasamanos de seguridad', 'vistas/img/productos/default/anonymous.png', 20, 75, 105, 0, '2017-12-21 21:56:28'),
	(32, 3, '308', 'Rueda giratoria para andamio', 'vistas/img/productos/default/anonymous.png', 20, 168, 235, 0, '2017-12-21 21:56:28'),
	(33, 3, '309', 'Arnes de seguridad', 'vistas/img/productos/default/anonymous.png', 20, 1750, 2450, 0, '2017-12-21 21:56:28'),
	(34, 3, '310', 'Eslinga para arnes', 'vistas/img/productos/default/anonymous.png', 20, 175, 245, 0, '2017-12-21 21:56:28'),
	(35, 3, '311', 'Plataforma Met?lica', 'vistas/img/productos/default/anonymous.png', 20, 420, 588, 0, '2017-12-21 21:56:28'),
	(36, 4, '401', 'Planta Electrica Diesel 6 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3500, 4900, 0, '2017-12-21 21:56:28'),
	(37, 4, '402', 'Planta Electrica Diesel 10 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3550, 4970, 0, '2017-12-21 21:56:28'),
	(38, 4, '403', 'Planta Electrica Diesel 20 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3600, 5040, 0, '2017-12-21 21:56:28'),
	(39, 4, '404', 'Planta Electrica Diesel 30 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3650, 5110, 0, '2017-12-21 21:56:28'),
	(40, 4, '405', 'Planta Electrica Diesel 60 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3700, 5180, 0, '2017-12-21 21:56:28'),
	(41, 4, '406', 'Planta Electrica Diesel 75 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3750, 5250, 0, '2017-12-21 21:56:28'),
	(42, 4, '407', 'Planta Electrica Diesel 100 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3800, 5320, 0, '2017-12-21 21:56:28'),
	(43, 4, '408', 'Planta Electrica Diesel 120 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3850, 5390, 0, '2017-12-21 21:56:28'),
	(44, 5, '501', 'Escalera de Tijera Aluminio ', 'vistas/img/productos/default/anonymous.png', 20, 350, 490, 0, '2017-12-21 21:56:28'),
	(45, 5, '502', 'Extension Electrica ', 'vistas/img/productos/default/anonymous.png', 20, 370, 518, 0, '2017-12-21 21:56:28'),
	(46, 5, '503', 'Gato tensor', 'vistas/img/productos/default/anonymous.png', 20, 380, 532, 0, '2017-12-21 21:56:28'),
	(47, 5, '504', 'Lamina Cubre Brecha ', 'vistas/img/productos/default/anonymous.png', 20, 380, 532, 0, '2017-12-21 21:56:28'),
	(48, 5, '505', 'Llave de Tubo', 'vistas/img/productos/default/anonymous.png', 20, 480, 672, 0, '2017-12-21 21:56:28'),
	(49, 5, '506', 'Manila por Metro', 'vistas/img/productos/default/anonymous.png', 20, 600, 840, 0, '2017-12-21 21:56:28'),
	(50, 5, '507', 'Polea 2 canales', 'vistas/img/productos/default/anonymous.png', 19, 900, 1260, 1, '2025-04-21 00:51:48'),
	(51, 5, '508', 'Tensor', 'vistas/img/productos/508/500.jpg', 19, 100, 140, 1, '2017-12-26 22:26:51'),
	(52, 5, '509', 'Bascula ', 'vistas/img/productos/509/878.jpg', 12, 130, 182, 8, '2017-12-26 22:26:51'),
	(53, 5, '510', 'Bomba Hidrostatica', 'vistas/img/productos/510/870.jpg', 8, 770, 1078, 12, '2017-12-26 22:26:51'),
	(54, 5, '511', 'Chapeta', 'vistas/img/productos/511/239.jpg', 16, 660, 924, 4, '2017-12-26 22:27:42'),
	(55, 5, '512', 'Cilindro muestra de concreto', 'vistas/img/productos/512/266.jpg', 15, 400, 560, 5, '2025-04-20 23:39:11'),
	(56, 5, '513', 'Cizalla de Palanca', 'vistas/img/productos/513/445.jpg', 2, 450, 630, 18, '2019-05-25 06:10:41'),
	(57, 5, '514', 'Cizalla de Tijera', 'vistas/img/productos/514/249.jpg', 16, 580, 812, 18, '2025-04-20 23:38:35'),
	(58, 5, '515', 'Coche llanta neumatica', 'vistas/img/productos/515/174.jpg', 14, 420, 588, 6, '2025-04-20 23:17:07'),
	(59, 5, '516', 'Cono slump', 'vistas/img/productos/516/228.jpg', 9, 140, 196, 12, '2025-04-21 00:31:51'),
	(60, 5, '517', 'Cortadora de Baldosin', 'vistas/img/productos/517/746.jpg', 3, 930, 1302, 17, '2025-04-20 22:23:08');

-- Volcando estructura para tabla sis_inventario.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla sis_inventario.sessions: ~1 rows (aproximadamente)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('LaGjkZj64s7TNxODsy7KrvBkmGu3QtDLxkAizTVy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUZJYVFlZ092dmRuZzVvTW4xVXdvUk1jaExVNFBlT2VsZFpTaHMzdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1745161034),
	('Uu2mVCns1R9iEQSF2YzdBhAu7Ibe6LdUvTKfoEPM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXg4cDRURDNqOGdybTB0RHZQZGc4dGdtNUxIS0tYYTJFZ28zMWlaZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1745174744);

-- Volcando estructura para tabla sis_inventario.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla sis_inventario.users: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sis_inventario.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `usuario` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `perfil` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `foto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `estado` int NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.usuarios: ~4 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
	(1, 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/191.jpg', 1, '2025-04-20 09:58:30', '2025-04-20 14:58:30'),
	(57, 'Juan Fernando Urrego', 'juan', '$2a$07$asxx54ahjppf45sd87a5auwRi.z6UsW7kVIpm0CUEuCpmsvT2sG6O', 'Vendedor', 'vistas/img/usuarios/juan/461.jpg', 1, '2018-02-06 16:58:50', '2019-06-20 20:28:19'),
	(58, 'Julio Gómez', 'julio', '$2a$07$asxx54ahjppf45sd87a5auQhldmFjGsrgUipGlmQgDAcqevQZSAAC', 'Especial', 'vistas/img/usuarios/julio/100.png', 1, '2018-02-06 17:09:22', '2019-05-25 06:06:39'),
	(59, 'Ana Gonzalez', 'ana', '$2a$07$asxx54ahjppf45sd87a5auLd2AxYsA/2BbmGKNk2kMChC3oj7V0Ca', 'Vendedor', 'vistas/img/usuarios/ana/260.png', 1, '2017-12-26 19:21:40', '2019-05-25 06:06:42');

-- Volcando estructura para tabla sis_inventario.ventas
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_vendedor` int NOT NULL,
  `productos` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `delivery_costo` int DEFAULT '0',
  `total` float NOT NULL,
  `metodo_pago` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delivery` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.ventas: ~27 rows (aproximadamente)
INSERT INTO `ventas` (`id`, `codigo`, `id_cliente`, `id_vendedor`, `productos`, `impuesto`, `neto`, `delivery_costo`, `total`, `metodo_pago`, `fecha`, `delivery`) VALUES
	(17, 10001, 3, 1, '[{"id":"1","descripcion":"Aspiradora Industrial ","cantidad":"2","stock":"13","precio":"1200","total":"2400"},{"id":"2","descripcion":"Plato Flotante para Allanadora","cantidad":"2","stock":"7","precio":"6300","total":"12600"},{"id":"3","descripcion":"Compresor de Aire para pintura","cantidad":"1","stock":"19","precio":"4200","total":"4200"}]', 3648, 19200, 0, 22848, 'Efectivo', '2018-02-02 01:11:04', NULL),
	(18, 10002, 4, 59, '[{"id":"5","descripcion":"Cortadora de Piso sin Disco ","cantidad":"2","stock":"18","precio":"2156","total":"4312"},{"id":"4","descripcion":"Cortadora de Adobe sin Disco ","cantidad":"1","stock":"19","precio":"5600","total":"5600"},{"id":"6","descripcion":"Disco Punta Diamante ","cantidad":"1","stock":"19","precio":"1540","total":"1540"},{"id":"7","descripcion":"Extractor de Aire ","cantidad":"1","stock":"19","precio":"2156","total":"2156"}]', 2585.52, 13608, 0, 16193.5, 'TC-34346346346', '2018-02-02 14:57:20', NULL),
	(19, 10003, 5, 59, '[{"id":"8","descripcion":"Guadañadora ","cantidad":"1","stock":"19","precio":"2156","total":"2156"},{"id":"9","descripcion":"Hidrolavadora Eléctrica ","cantidad":"1","stock":"19","precio":"3640","total":"3640"},{"id":"7","descripcion":"Extractor de Aire ","cantidad":"1","stock":"18","precio":"2156","total":"2156"}]', 1510.88, 7952, 0, 9462.88, 'Efectivo', '2018-01-18 14:57:40', NULL),
	(20, 10004, 5, 59, '[{"id":"3","descripcion":"Compresor de Aire para pintura","cantidad":"5","stock":"14","precio":"4200","total":"21000"},{"id":"4","descripcion":"Cortadora de Adobe sin Disco ","cantidad":"1","stock":"18","precio":"5600","total":"5600"},{"id":"5","descripcion":"Cortadora de Piso sin Disco ","cantidad":"1","stock":"17","precio":"2156","total":"2156"}]', 5463.64, 28756, 0, 34219.6, 'TD-454475467567', '2018-01-25 14:58:09', NULL),
	(21, 10005, 6, 57, '[{"id":"4","descripcion":"Cortadora de Adobe sin Disco ","cantidad":"1","stock":"17","precio":"5600","total":"5600"},{"id":"5","descripcion":"Cortadora de Piso sin Disco ","cantidad":"1","stock":"16","precio":"2156","total":"2156"},{"id":"3","descripcion":"Compresor de Aire para pintura","cantidad":"5","stock":"9","precio":"4200","total":"21000"}]', 5463.64, 28756, 0, 34219.6, 'TC-6756856867', '2018-01-09 14:59:07', NULL),
	(22, 10006, 10, 1, '[{"id":"3","descripcion":"Compresor de Aire para pintura","cantidad":"1","stock":"8","precio":"4200","total":"4200"},{"id":"4","descripcion":"Cortadora de Adobe sin Disco ","cantidad":"1","stock":"16","precio":"5600","total":"5600"},{"id":"5","descripcion":"Cortadora de Piso sin Disco ","cantidad":"3","stock":"13","precio":"2156","total":"6468"},{"id":"6","descripcion":"Disco Punta Diamante ","cantidad":"1","stock":"18","precio":"1540","total":"1540"}]', 3383.52, 17808, 0, 21191.5, 'Efectivo', '2018-01-26 15:03:22', NULL),
	(23, 10007, 9, 1, '[{"id":"6","descripcion":"Disco Punta Diamante ","cantidad":"1","stock":"17","precio":"1540","total":"1540"},{"id":"7","descripcion":"Extractor de Aire ","cantidad":"1","stock":"17","precio":"2156","total":"2156"},{"id":"8","descripcion":"Guadañadora ","cantidad":"6","stock":"13","precio":"2156","total":"12936"},{"id":"9","descripcion":"Hidrolavadora Eléctrica ","cantidad":"1","stock":"18","precio":"3640","total":"3640"}]', 3851.68, 20272, 0, 24123.7, 'TC-357547467346', '2017-11-30 15:03:53', NULL),
	(24, 10008, 12, 1, '[{"id":"2","descripcion":"Plato Flotante para Allanadora","cantidad":"1","stock":"6","precio":"6300","total":"6300"},{"id":"7","descripcion":"Extractor de Aire ","cantidad":"5","stock":"12","precio":"2156","total":"10780"},{"id":"6","descripcion":"Disco Punta Diamante ","cantidad":"1","stock":"16","precio":"1540","total":"1540"},{"id":"9","descripcion":"Hidrolavadora Eléctrica ","cantidad":"1","stock":"17","precio":"3640","total":"3640"}]', 4229.4, 22260, 0, 26489.4, 'TD-35745575', '2017-12-25 15:04:11', NULL),
	(25, 10009, 11, 1, '[{"id":"10","descripcion":"Hidrolavadora Gasolina","cantidad":"1","stock":"19","precio":"3094","total":"3094"},{"id":"9","descripcion":"Hidrolavadora Eléctrica ","cantidad":"1","stock":"16","precio":"3640","total":"3640"},{"id":"6","descripcion":"Disco Punta Diamante ","cantidad":"1","stock":"15","precio":"1540","total":"1540"}]', 1572.06, 8274, 0, 9846.06, 'TD-5745745745', '2017-08-15 15:04:38', NULL),
	(26, 10010, 8, 1, '[{"id":"9","descripcion":"Hidrolavadora Eléctrica ","cantidad":"1","stock":"15","precio":"3640","total":"3640"},{"id":"10","descripcion":"Hidrolavadora Gasolina","cantidad":"1","stock":"18","precio":"3094","total":"3094"}]', 1279.46, 6734, 0, 8013.46, 'Efectivo', '2017-12-07 15:05:09', NULL),
	(27, 10011, 7, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"19","precio":"1302","total":"1302"},{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"19","precio":"196","total":"196"},{"id":"58","descripcion":"Coche llanta neumatica","cantidad":"1","stock":"19","precio":"588","total":"588"},{"id":"57","descripcion":"Cizalla de Tijera","cantidad":"1","stock":"19","precio":"812","total":"812"}]', 550.62, 2898, 0, 3448.62, 'Efectivo', '2017-12-25 22:23:38', NULL),
	(28, 10012, 12, 57, '[{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"18","precio":"196","total":"196"},{"id":"58","descripcion":"Coche llanta neumatica","cantidad":"1","stock":"18","precio":"588","total":"588"},{"id":"54","descripcion":"Chapeta","cantidad":"1","stock":"19","precio":"924","total":"924"},{"id":"53","descripcion":"Bomba Hidrostatica","cantidad":"1","stock":"19","precio":"1078","total":"1078"}]', 529.34, 2786, 0, 3315.34, 'TC-3545235235', '2017-12-25 22:24:24', NULL),
	(29, 10013, 11, 57, '[{"id":"54","descripcion":"Chapeta","cantidad":"1","stock":"18","precio":"924","total":"924"},{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"17","precio":"196","total":"196"},{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"5","stock":"14","precio":"1302","total":"6510"}]', 1449.7, 7630, 0, 9079.7, 'TC-425235235235', '2017-12-26 22:24:50', NULL),
	(30, 10014, 10, 57, '[{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"16","precio":"196","total":"196"},{"id":"54","descripcion":"Chapeta","cantidad":"1","stock":"17","precio":"924","total":"924"},{"id":"53","descripcion":"Bomba Hidrostatica","cantidad":"10","stock":"9","precio":"1078","total":"10780"}]', 2261, 11900, 0, 14161, 'Efectivo', '2017-12-26 22:25:09', NULL),
	(31, 10015, 9, 57, '[{"id":"57","descripcion":"Cizalla de Tijera","cantidad":"3","stock":"16","precio":"812","total":"2436"}]', 462.84, 2436, 0, 2898.84, 'Efectivo', '2017-12-26 22:25:33', NULL),
	(32, 10016, 8, 57, '[{"id":"58","descripcion":"Coche llanta neumatica","cantidad":"1","stock":"17","precio":"588","total":"588"},{"id":"57","descripcion":"Cizalla de Tijera","cantidad":"5","stock":"11","precio":"812","total":"4060"},{"id":"56","descripcion":"Cizalla de Palanca","cantidad":"1","stock":"19","precio":"630","total":"630"}]', 1002.82, 5278, 0, 6280.82, 'TD-4523523523', '2017-12-26 22:25:55', NULL),
	(33, 10017, 7, 57, '[{"id":"57","descripcion":"Cizalla de Tijera","cantidad":"4","stock":"7","precio":"812","total":"3248"},{"id":"52","descripcion":"Bascula ","cantidad":"3","stock":"17","precio":"182","total":"546"},{"id":"55","descripcion":"Cilindro muestra de concreto","cantidad":"2","stock":"18","precio":"560","total":"1120"},{"id":"56","descripcion":"Cizalla de Palanca","cantidad":"1","stock":"18","precio":"630","total":"630"}]', 1053.36, 5544, 0, 6597.36, 'Efectivo', '2017-12-26 22:26:28', NULL),
	(34, 10018, 6, 57, '[{"id":"51","descripcion":"Tensor","cantidad":"1","stock":"19","precio":"140","total":"140"},{"id":"52","descripcion":"Bascula ","cantidad":"5","stock":"12","precio":"182","total":"910"},{"id":"53","descripcion":"Bomba Hidrostatica","cantidad":"1","stock":"8","precio":"1078","total":"1078"}]', 404.32, 2128, 0, 2532.32, 'Efectivo', '2017-12-26 22:26:51', NULL),
	(35, 10019, 5, 57, '[{"id":"56","descripcion":"Cizalla de Palanca","cantidad":"15","stock":"3","precio":"630","total":"9450"},{"id":"55","descripcion":"Cilindro muestra de concreto","cantidad":"1","stock":"17","precio":"560","total":"560"}]', 1901.9, 10010, 0, 11911.9, 'Efectivo', '2017-12-26 22:27:13', NULL),
	(36, 10020, 4, 57, '[{"id":"55","descripcion":"Cilindro muestra de concreto","cantidad":"1","stock":"16","precio":"560","total":"560"},{"id":"54","descripcion":"Chapeta","cantidad":"1","stock":"16","precio":"924","total":"924"}]', 281.96, 1484, 0, 1765.96, 'TC-46346346346', '2017-12-26 22:27:42', NULL),
	(37, 10021, 3, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"13","precio":"1302","total":"1302"},{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"15","precio":"196","total":"196"}]', 149.8, 1498, 0, 1647.8, 'Efectivo', '2018-02-06 22:47:02', NULL),
	(38, 10022, 6, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"12","precio":"1302","total":"1302"},{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"14","precio":"196","total":"196"},{"id":"58","descripcion":"Coche llanta neumatica","cantidad":"1","stock":"16","precio":"588","total":"588"},{"id":"57","descripcion":"Cizalla de Tijera","cantidad":"1","stock":"19","precio":"812","total":"812"},{"id":"56","descripcion":"Cizalla de Palanca","cantidad":"1","stock":"2","precio":"630","total":"630"}]', 141.12, 3528, 0, 3669.12, 'Efectivo', '2019-05-25 06:10:41', NULL),
	(39, 10023, 9, 1, '[{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"13","precio":"196","total":"196"},{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"11","precio":"1302","total":"1302"},{"id":"57","descripcion":"Cizalla de Tijera","cantidad":"1","stock":"18","precio":"812","total":"812"}]', 277.2, 2310, 0, 2587.2, 'Efectivo', '2019-06-20 20:33:23', NULL),
	(40, 10024, 3, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"10","precio":"1302","total":"1302"}]', 39.06, 1302, 0, 1341.06, 'Efectivo', '2025-04-19 04:17:55', NULL),
	(41, 10025, 3, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"9","precio":"1302","total":"1302"}]', 78.12, 1302, 0, 1380.12, 'Efectivo', '2025-04-19 04:18:55', NULL),
	(42, 10026, 3, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"8","precio":"1302","total":"1302"}]', 13.02, 1302, 0, 1315.02, 'Efectivo', '2025-04-19 04:20:31', NULL),
	(43, 10027, 3, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"7","precio":"1302","total":"1302"}]', 13.02, 1302, 0, 1315.02, 'TC-2312', '2025-04-19 04:21:42', NULL),
	(44, 10028, 3, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"6","precio":"1302","total":"1302"}]', 234.36, 1302, 0, 1536.36, 'Efectivo', '2025-04-19 07:38:09', NULL),
	(45, 10029, 3, 1, '[{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"12","precio":"196","total":"196"}]', 35.28, 196, 0, 231.28, 'Efectivo', '2025-04-19 07:41:21', NULL),
	(46, 10030, 4, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"5","precio":"1302","total":"1302"}]', 234.36, 1302, 0, 1536.36, 'Efectivo', '2025-04-19 07:44:53', NULL),
	(47, 10031, 4, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"4","precio":"1302","total":"1302"}]', 234.36, 1302, 0, 0, 'Efectivo', '2025-04-20 18:58:32', NULL),
	(48, 10032, 4, 1, '[{"id":"60","descripcion":"Cortadora de Baldosin","cantidad":"1","stock":"3","precio":"1302","total":"1302"}]', 234.36, 1302, 0, 1536.36, 'Efectivo', '2025-04-20 22:23:08', NULL),
	(49, 10033, 3, 1, '[{"id":"58","descripcion":"Coche llanta neumatica","cantidad":"1","stock":"15","precio":"588","total":"588"}]', 105.84, 588, 0, 693.84, 'Efectivo', '2025-04-20 23:08:17', NULL),
	(50, 10034, 5, 1, '[{"id":"57","descripcion":"Cizalla de Tijera","cantidad":"1","stock":"17","precio":"812","total":"812"}]', 146.16, 812, 0, 958.16, 'Efectivo', '2025-04-20 23:12:10', NULL),
	(51, 10035, 3, 1, '[{"id":"58","descripcion":"Coche llanta neumatica","cantidad":"1","stock":"14","precio":"588","total":"588"}]', 105.84, 588, 0, 693.84, 'Efectivo', '2025-04-20 23:17:07', NULL),
	(52, 10036, 3, 1, '[{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"11","precio":"196","total":"196"}]', 35.28, 196, 0, 231.28, 'Efectivo', '2025-04-20 23:26:02', '{"nombre":"212123","direccion":"213123","referencias":"12313","telefono":"324234","costo":"0324"}'),
	(53, 10037, 4, 1, '[{"id":"57","descripcion":"Cizalla de Tijera","cantidad":"1","stock":"16","precio":"812","total":"812"}]', 146.16, 812, 0, 958.16, 'Efectivo', '2025-04-20 23:33:31', '[null]'),
	(54, 10037, 4, 1, '[{"id":"57","descripcion":"Cizalla de Tijera","cantidad":"1","stock":"16","precio":"812","total":"812"}]', 146.16, 812, 0, 958.16, 'Efectivo', '2025-04-20 23:38:35', ''),
	(55, 10038, 4, 1, '[{"id":"55","descripcion":"Cilindro muestra de concreto","cantidad":"1","stock":"15","precio":"560","total":"560"}]', 100.8, 560, 0, 660.8, 'Efectivo', '2025-04-20 23:39:11', '{"nombre":"23424324","direccion":"32423342334","referencias":"324242","telefono":"234234","costo":"0"}'),
	(56, 10039, 4, 1, '[{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"10","precio":"196","total":"196"}]', 35.28, 196, 0, 231.28, 'Efectivo', '2025-04-20 23:40:01', ''),
	(57, 10040, 3, 1, '[{"id":"59","descripcion":"Cono slump","cantidad":"1","stock":"9","precio":"196","total":"196"}]', 0, 0, 0, 23.2, 'Efectivo', '2025-04-21 00:31:51', '{"nombre":"","direccion":"","referencias":"","telefono":"","costo":"023.2"}'),
	(58, 10041, 3, 1, '[{"id":"50","descripcion":"Polea 2 canales","cantidad":"1","stock":"19","precio":"1260","total":"1260"}]', 226.8, 1260, 12, 1498.8, 'Efectivo', '2025-04-21 00:51:48', '{"nombre":"12","direccion":"12","referencias":"12","telefono":"12","costo":"12"}');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
