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


-- Volcando estructura de base de datos para bd_gainva
CREATE DATABASE IF NOT EXISTS `bd_gainva` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bd_gainva`;

-- Volcando estructura para tabla bd_gainva.almacen
CREATE TABLE IF NOT EXISTS `almacen` (
  `idAlmacen` int unsigned NOT NULL AUTO_INCREMENT,
  `Fk_MA` int DEFAULT NULL,
  `zona` enum('PRINCIPAL','SEGUNDO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cant_stock` int NOT NULL,
  `lote` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fechaVencimiento` date DEFAULT NULL,
  PRIMARY KEY (`idAlmacen`),
  KEY `FK_movimiento_almacen` (`Fk_MA`),
  CONSTRAINT `FK_movimiento_almacen` FOREIGN KEY (`Fk_MA`) REFERENCES `movimiento_almacen` (`idMovimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bd_gainva.almacen: ~1 rows (aproximadamente)
INSERT INTO `almacen` (`idAlmacen`, `Fk_MA`, `zona`, `cant_stock`, `lote`, `fechaVencimiento`) VALUES
	(4, 12, 'PRINCIPAL', 120, '123', '2025-03-27');

-- Volcando estructura para tabla bd_gainva.control_cebado
CREATE TABLE IF NOT EXISTS `control_cebado` (
  `idControl` int NOT NULL AUTO_INCREMENT,
  `idmovimientoAlmacen` int DEFAULT NULL,
  `actualFecha` date DEFAULT NULL,
  `siguienteFecha` date DEFAULT NULL,
  `lote1` varchar(50) DEFAULT NULL,
  `cant1` int DEFAULT NULL,
  `lote2` varchar(50) DEFAULT NULL,
  `cant2` int DEFAULT NULL,
  `lote3` varchar(50) DEFAULT NULL,
  `cant3` int DEFAULT NULL,
  `lote4` varchar(50) DEFAULT NULL,
  `cant4` int DEFAULT NULL,
  PRIMARY KEY (`idControl`),
  KEY `FKmovimiento` (`idmovimientoAlmacen`),
  CONSTRAINT `FKmovimiento` FOREIGN KEY (`idmovimientoAlmacen`) REFERENCES `movimiento_almacen` (`idMovimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bd_gainva.control_cebado: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_gainva.failed_jobs
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

-- Volcando datos para la tabla bd_gainva.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_gainva.insumos
CREATE TABLE IF NOT EXISTS `insumos` (
  `idInsumo` int unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idKarness` int unsigned NOT NULL,
  `control_cebado` enum('Y','N') DEFAULT NULL,
  `control_emergencia` enum('Y','N') DEFAULT NULL,
  `almacenPrincipal` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `almacenSegundo` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`idInsumo`),
  KEY `FKidKarness` (`idKarness`),
  CONSTRAINT `FKidKarness` FOREIGN KEY (`idKarness`) REFERENCES `karness` (`idKarness`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bd_gainva.insumos: ~79 rows (aproximadamente)
INSERT INTO `insumos` (`idInsumo`, `Nombre`, `descripcion`, `idKarness`, `control_cebado`, `control_emergencia`, `almacenPrincipal`, `almacenSegundo`) VALUES
	(1, 'Acido - A Galonera 4L', NULL, 1, 'N', 'N', 'N', 'Y'),
	(2, 'ACIDO - B BICARBONATO  4L', NULL, 1, 'N', 'N', 'N', 'Y'),
	(3, 'ACIDO - DIAFLEX', NULL, 1, 'N', 'N', 'N', 'Y'),
	(4, 'BIG GAG', NULL, 1, 'N', 'N', 'N', 'Y'),
	(5, 'SET DE LINEA', NULL, 1, 'Y', 'Y', 'Y', 'Y'),
	(6, 'FILTRO 1.8', NULL, 1, 'Y', 'Y', 'Y', 'Y'),
	(7, 'FILTRO 2.2', NULL, 1, 'Y', 'N', 'Y', 'Y'),
	(8, 'EQUIPO DE VENOCLISIS', NULL, 1, 'N', 'N', 'Y', 'N'),
	(9, 'FISTULA N°15', NULL, 1, 'N', 'N', 'Y', 'N'),
	(10, 'FISTULA N°16', NULL, 1, 'N', 'N', 'Y', 'Y'),
	(11, 'FISTULA N°17', NULL, 1, 'N', 'N', 'Y', 'N'),
	(12, 'JERINGA 1CC', NULL, 1, 'N', 'N', 'Y', 'N'),
	(13, 'JERINGA 3CC', NULL, 1, 'N', 'N', 'Y', 'N'),
	(14, 'JERINGA 5CC', NULL, 1, 'N', 'N', 'Y', 'N'),
	(15, 'JERINGA 10 CC', NULL, 1, 'N', 'N', 'Y', 'N'),
	(16, 'JERINGA 20CC', NULL, 1, 'N', 'N', 'Y', 'N'),
	(17, 'HEPARINA 1000', NULL, 1, 'N', 'N', 'Y', 'N'),
	(18, 'HEPARINA 5000', NULL, 1, 'N', 'N', 'Y', 'N'),
	(19, 'CLORURO 0.9 1- LITRO', NULL, 1, 'N', 'N', 'Y', 'N'),
	(20, 'MASCARRILLA - SIMPLE', NULL, 1, 'N', 'N', 'Y', 'N'),
	(21, 'GORRO', NULL, 1, 'N', 'N', 'Y', 'N'),
	(22, 'GUANTES "S"', NULL, 1, 'N', 'N', 'Y', 'Y'),
	(23, 'GUANTES "M"', NULL, 1, 'N', 'N', 'Y', 'N'),
	(24, 'GUANTES 7 1 1/2', NULL, 1, 'N', 'N', 'Y', 'Y'),
	(25, 'TEGGADER', NULL, 1, 'N', 'N', 'Y', 'N'),
	(26, 'MICROPORE', NULL, 1, 'N', 'N', 'Y', 'N'),
	(27, 'TRANSPORE', NULL, 1, 'N', 'N', 'Y', 'N'),
	(28, 'BOLSA 10*15', NULL, 1, 'N', 'N', 'Y', 'N'),
	(29, 'BOLSA 8*12', NULL, 1, 'N', 'N', 'Y', 'N'),
	(30, 'BOLSA 14*20', NULL, 1, 'N', 'N', 'Y', 'N'),
	(31, 'PAÑOS DE MAQUINA', NULL, 1, 'N', 'N', 'Y', 'N'),
	(32, 'CLORURO 100 ML', NULL, 2, 'N', 'N', 'Y', 'Y'),
	(33, 'PAPEL CREPADO', NULL, 2, 'N', 'N', 'Y', 'N'),
	(34, 'PAPEL TOALLA Ó INTERFOLEADO', NULL, 2, 'N', 'N', 'Y', 'N'),
	(35, 'GASA', NULL, 2, 'N', 'N', 'Y', 'N'),
	(36, 'ALGODÓN HIDROFILICO', NULL, 2, 'N', 'N', 'Y', 'N'),
	(37, 'ALCOHOL 1LITRO', NULL, 2, 'N', 'N', 'N', 'Y'),
	(38, 'ALCOHOL EN GEL 70X500 ML', NULL, 2, 'N', 'N', 'Y', 'N'),
	(39, 'HISTORIA CLINICA', NULL, 2, 'N', 'N', 'Y', 'N'),
	(40, 'CLOREXIHIDINA Ó HIBICLEN 2%', NULL, 2, 'N', 'N', 'Y', 'N'),
	(41, 'CLOREXIHIDINA Ó HIBICLEN 4%', NULL, 2, 'N', 'N', 'Y', 'N'),
	(42, 'CAJA PUNZO CORTANTE', NULL, 2, 'N', 'N', 'Y', 'N'),
	(43, 'CAJA PUNZO CORTANTE AMARILLO', NULL, 2, 'N', 'N', 'Y', 'N'),
	(44, 'BENCINA', NULL, 2, 'N', 'N', 'Y', 'N'),
	(45, 'MANDILES', NULL, 2, 'N', 'N', 'Y', 'N'),
	(46, 'PAPEL BOND', NULL, 2, 'N', 'N', 'Y', 'N'),
	(47, 'FILTRO DE CARBON', NULL, 2, 'N', 'N', 'Y', 'N'),
	(48, 'FILTRO DE DIAFASE', NULL, 2, 'N', 'N', 'Y', 'N'),
	(49, 'FILTRO 0.45', NULL, 2, 'N', 'N', 'Y', 'N'),
	(50, 'FILTRO 0.02', NULL, 2, 'N', 'N', 'Y', 'N'),
	(51, 'FILTRO MICRO N°5', NULL, 2, 'N', 'N', 'Y', 'N'),
	(52, 'FILTRO DE SEDIMENTO -EMERGENCIA', NULL, 2, 'N', 'N', 'Y', 'N'),
	(53, 'FILTRO CARTUCHO', NULL, 2, 'N', 'N', 'Y', 'N'),
	(54, 'CINTA TESTIGO', NULL, 2, 'N', 'N', 'Y', 'N'),
	(55, 'TEST DE BOWIE', NULL, 2, 'N', 'N', 'Y', 'N'),
	(56, 'AGUJA N°18', NULL, 3, 'N', 'N', 'Y', 'N'),
	(57, 'AGUJA N°21', NULL, 3, 'N', 'N', 'Y', 'N'),
	(58, 'AGUJA N°25', NULL, 3, 'N', 'N', 'Y', 'N'),
	(59, 'ABOCAT N°20', NULL, 3, 'N', 'N', 'Y', 'N'),
	(60, 'ABOCAT N°18', NULL, 3, 'N', 'N', 'Y', 'N'),
	(61, 'LLAVE DE TRIPLE VIA', NULL, 3, 'N', 'N', 'Y', 'N'),
	(62, 'EPINEFRINA 1MG/ML', NULL, 3, 'N', 'N', 'Y', 'N'),
	(63, 'BICARBONATO DE SODIO 8.4%', NULL, 3, 'N', 'N', 'Y', 'N'),
	(64, 'PROTAMINA', NULL, 3, 'N', 'N', 'Y', 'N'),
	(65, 'GLUCONATO DE CALCIO 10%', NULL, 3, 'N', 'N', 'Y', 'N'),
	(66, 'DEXTROSA AL 33%', NULL, 3, 'N', 'N', 'Y', 'N'),
	(67, 'DICLOFENACO 75MG/3ML', NULL, 3, 'N', 'N', 'Y', 'N'),
	(68, 'DIMENHIDRINATO 50MG/5ML', NULL, 3, 'N', 'N', 'Y', 'N'),
	(69, 'CLORFENAMINA', NULL, 3, 'N', 'N', 'Y', 'N'),
	(70, 'HIOSCINA 20MG /ESCOPOLAMINA', NULL, 3, 'N', 'N', 'Y', 'N'),
	(71, 'CAPTOPRIL TAB.', NULL, 3, 'N', 'N', 'Y', 'N'),
	(72, 'PARACETAMOL 500 MG', NULL, 3, 'N', 'N', 'Y', 'N'),
	(73, 'LOSARTAN POTASICO 50 MG X 100 TAB', NULL, 3, 'N', 'N', 'Y', 'N'),
	(74, 'METAMIZOL X 1GR.AMP', NULL, 3, 'N', 'N', 'Y', 'N'),
	(75, 'NIFEDIPINO DE 10 MG', NULL, 3, 'N', 'N', 'Y', 'N'),
	(76, 'DEXAMETASONA 4MG AMP.', NULL, 3, 'N', 'N', 'Y', 'N'),
	(77, 'DIAZEPAM 10 MG/2ML', NULL, 3, 'N', 'N', 'Y', 'N'),
	(78, 'ACCU-CHEK', NULL, 3, 'N', 'N', 'Y', 'N'),
	(79, 'HIDROCORTISONA SUCCINATO 250MG X 10 VIAL-PHARMAGEN', NULL, 3, 'N', 'N', 'Y', 'N');

-- Volcando estructura para tabla bd_gainva.karness
CREATE TABLE IF NOT EXISTS `karness` (
  `idKarness` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`idKarness`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bd_gainva.karness: ~4 rows (aproximadamente)
INSERT INTO `karness` (`idKarness`, `nombre`) VALUES
	(1, 'ALTO'),
	(3, 'BAJO'),
	(2, 'MEDIO'),
	(4, 'OTRO');

-- Volcando estructura para tabla bd_gainva.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_gainva.migrations: ~6 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_02_02_131917_create_permission_tables', 1),
	(6, '2025_02_02_235942_add_apellido_to_users_table', 2);

-- Volcando estructura para tabla bd_gainva.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_gainva.model_has_permissions: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_gainva.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_gainva.model_has_roles: ~2 rows (aproximadamente)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 2),
	(1, 'App\\Models\\User', 6);

-- Volcando estructura para tabla bd_gainva.movimiento_almacen
CREATE TABLE IF NOT EXISTS `movimiento_almacen` (
  `idMovimiento` int NOT NULL AUTO_INCREMENT,
  `fk_insumos` int unsigned NOT NULL,
  `fecha` date NOT NULL,
  `tipo_movimiento` enum('salida','entrada') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cant_movida` int NOT NULL,
  `stock` int DEFAULT NULL,
  `factu_o_boleta` varchar(50) DEFAULT NULL,
  `observacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lote` varchar(50) DEFAULT NULL,
  `proveedor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idMovimiento`),
  KEY `FKidInsumos` (`fk_insumos`),
  CONSTRAINT `FKidInsumos` FOREIGN KEY (`fk_insumos`) REFERENCES `insumos` (`idInsumo`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bd_gainva.movimiento_almacen: ~9 rows (aproximadamente)
INSERT INTO `movimiento_almacen` (`idMovimiento`, `fk_insumos`, `fecha`, `tipo_movimiento`, `cant_movida`, `stock`, `factu_o_boleta`, `observacion`, `lote`, `proveedor`, `updated_at`, `created_at`) VALUES
	(12, 5, '2025-03-27', 'entrada', 120, 120, 'f01-000234', 'completo', '1212', 'fresenius', NULL, NULL),
	(18, 5, '2025-04-19', 'salida', 3, 3, '21321', 'Fecha (I-II-III)', '21131b065', '', '2025-04-19T18:06:52.000000Z', '2025-04-19T18:06:52.000000Z'),
	(20, 5, '2025-04-20', 'salida', 2, 0, '123213123', 'Fecha (I-II-III)', '21131b065', '', '2025-04-20T04:10:55.000000Z', '2025-04-20T04:10:55.000000Z'),
	(21, 2, '2025-04-20', 'salida', 4, 7676, NULL, 'Fecha (I-II-III)', '', '', '2025-04-20T05:18:26.000000Z', '2025-04-20T05:18:26.000000Z'),
	(22, 2, '2025-04-20', 'salida', 4, 7672, NULL, 'Fecha (I-II-III)', '', '', '2025-04-20T13:29:14.000000Z', '2025-04-20T13:29:14.000000Z'),
	(28, 5, '2025-05-01', 'salida', 4, 10, NULL, '21/05/2032 i-ii-iii', '232131', 'Matrix', '2025-05-01 20:09:42', '2025-05-01 20:09:42'),
	(29, 5, '2025-05-02', 'salida', 21, NULL, NULL, 'quetal', '2113213', NULL, '2025-05-02 01:55:06', '2025-05-02 01:55:06');

-- Volcando estructura para tabla bd_gainva.pacientes
CREATE TABLE IF NOT EXISTS `pacientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Nombre` int NOT NULL DEFAULT '0',
  `Apellido` int NOT NULL DEFAULT '0',
  `DNI` int NOT NULL DEFAULT '0',
  `Telefono` int NOT NULL DEFAULT '0',
  `Direccion` int NOT NULL DEFAULT '0',
  `Control` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla bd_gainva.pacientes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_gainva.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_gainva.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_gainva.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_gainva.permissions: ~4 rows (aproximadamente)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'users.index', 'web', '2025-02-04 04:40:36', '2025-02-04 04:40:36'),
	(2, 'users.create', 'web', '2025-02-04 04:40:36', '2025-02-04 04:40:36'),
	(3, 'users.edit', 'web', '2025-02-04 04:40:36', '2025-02-04 04:40:36'),
	(4, 'users.delete', 'web', '2025-02-04 04:40:36', '2025-02-04 04:40:36');

-- Volcando estructura para tabla bd_gainva.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_gainva.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_gainva.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_gainva.roles: ~2 rows (aproximadamente)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'web', '2025-02-03 07:58:40', '2025-02-03 07:58:40'),
	(2, 'Almacen', 'web', '2025-02-03 07:58:40', '2025-02-03 07:58:40'),
	(3, 'Tecnico', 'web', '2025-02-03 07:58:40', '2025-02-03 07:58:40');

-- Volcando estructura para tabla bd_gainva.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_gainva.role_has_permissions: ~4 rows (aproximadamente)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1);

-- Volcando estructura para tabla bd_gainva.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla bd_gainva.users: ~2 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(2, 'userAdmin2', 'admin2', 'admin2@gmail.com', NULL, '$2y$12$93KIJShWfVshdPvH50AxiOBeOapWpOlISuFXCMSznBqf4iLiDMkvy', NULL, '2025-02-03 05:35:33', '2025-02-03 05:39:01'),
	(6, 'manuel', '34343', '2323@gmail.com', NULL, '$2y$12$KejipjjBoQAJfdhSvJqO.OvA2HMWBl/TQXKvUj5Hxpo5qcXqXFin6', NULL, '2025-05-06 19:23:23', '2025-05-06 19:23:23');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
