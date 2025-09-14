-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 14, 2025 at 10:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_gainva`
--

-- --------------------------------------------------------

--
-- Table structure for table `almacen`
--

CREATE TABLE `almacen` (
  `idAlmacen` int UNSIGNED NOT NULL,
  `zona` enum('PRINCIPAL','SECUNDARIO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `idInsumo` int UNSIGNED NOT NULL DEFAULT '0',
  `fecha_guardado` date NOT NULL,
  `cant_stock` int NOT NULL,
  `lote` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fechaVencimiento` date DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `almacen`
--

INSERT INTO `almacen` (`idAlmacen`, `zona`, `idInsumo`, `fecha_guardado`, `cant_stock`, `lote`, `fechaVencimiento`, `updated_at`, `created_at`) VALUES
(14, 'PRINCIPAL', 5, '2025-05-01', 10, '2211313', NULL, '2025-05-29 07:05:42', '2025-05-29 02:29:07'),
(15, 'PRINCIPAL', 5, '2025-05-01', 14, '2211313-6', NULL, '2025-05-30 04:25:43', '2025-05-29 03:50:52'),
(16, 'PRINCIPAL', 6, '2025-05-01', 986, '2131223b231', NULL, '2025-05-31 04:44:23', '2025-05-29 05:29:36'),
(17, 'PRINCIPAL', 9, '2025-05-01', 0, '123132', NULL, '2025-05-30 14:50:55', '2025-05-30 14:49:14'),
(18, 'PRINCIPAL', 9, '2025-05-01', 0, NULL, NULL, '2025-05-30 14:51:29', '2025-05-30 14:51:10'),
(19, 'PRINCIPAL', 8, '2025-05-01', 551, NULL, NULL, '2025-05-31 05:39:25', '2025-05-31 04:57:55'),
(20, 'PRINCIPAL', 8, '2025-06-01', 540, NULL, NULL, '2025-06-10 00:56:33', '2025-06-01 19:50:17'),
(21, 'PRINCIPAL', 9, '2025-06-01', 0, '123132', NULL, '2025-06-01 19:50:21', '2025-06-01 19:50:21'),
(22, 'PRINCIPAL', 9, '2025-06-01', 0, NULL, NULL, '2025-06-01 19:50:21', '2025-06-01 19:50:21'),
(23, 'PRINCIPAL', 5, '2025-06-01', 10, '2211313', NULL, '2025-06-21 04:49:24', '2025-06-01 19:51:17'),
(24, 'PRINCIPAL', 5, '2025-06-01', 489, '2211313-6', NULL, '2025-06-21 04:49:47', '2025-06-01 19:51:17'),
(25, 'PRINCIPAL', 6, '2025-06-01', 970, '2131223b231', NULL, '2025-06-22 07:31:42', '2025-06-01 19:51:26'),
(26, 'SECUNDARIO', 5, '2025-06-01', 1194, '211231221', NULL, '2025-06-01 19:59:30', '2025-06-01 19:59:07'),
(27, 'PRINCIPAL', 5, '2025-06-01', 496, '2010212', NULL, '2025-06-21 04:50:02', '2025-06-10 00:53:54'),
(28, 'PRINCIPAL', 5, '2025-06-01', 13, 'f012-123456', NULL, '2025-06-21 04:50:55', '2025-06-21 04:50:43'),
(29, 'PRINCIPAL', 5, '2025-07-01', 0, '2211313', NULL, '2025-07-05 21:00:19', '2025-07-01 00:28:21'),
(30, 'PRINCIPAL', 5, '2025-07-01', 470, '2211313-6', NULL, '2025-07-06 04:28:24', '2025-07-01 00:28:21'),
(31, 'PRINCIPAL', 5, '2025-07-01', 373, '2010212', NULL, '2025-07-05 18:25:24', '2025-07-01 00:28:21'),
(32, 'PRINCIPAL', 5, '2025-07-01', 0, 'f012-123456', NULL, '2025-07-06 04:16:46', '2025-07-01 00:28:21'),
(33, 'PRINCIPAL', 6, '2025-07-01', 857, '2131223b231', NULL, '2025-07-06 04:28:24', '2025-07-01 00:28:27'),
(34, 'PRINCIPAL', 8, '2025-07-01', 485, NULL, NULL, '2025-07-05 21:00:20', '2025-07-01 00:28:36'),
(35, 'PRINCIPAL', 9, '2025-07-01', 0, '123132', NULL, '2025-07-01 00:28:40', '2025-07-01 00:28:40'),
(36, 'PRINCIPAL', 9, '2025-07-01', 100, NULL, NULL, '2025-07-06 03:57:41', '2025-07-01 00:28:40'),
(37, 'SECUNDARIO', 5, '2025-07-01', 1194, '211231221', NULL, '2025-07-01 00:29:19', '2025-07-01 00:29:19'),
(38, 'PRINCIPAL', 12, '2025-07-01', 9, NULL, NULL, '2025-07-05 18:25:24', '2025-07-05 03:59:49'),
(39, 'PRINCIPAL', 7, '2025-07-01', 88, 'f012-123456', NULL, '2025-07-06 04:28:24', '2025-07-06 03:57:07'),
(40, 'PRINCIPAL', 10, '2025-07-01', 100, NULL, NULL, '2025-07-06 03:58:00', '2025-07-06 03:58:00'),
(41, 'PRINCIPAL', 5, '2025-07-01', 100, 'f01,123', NULL, '2025-07-06 04:18:22', '2025-07-06 04:18:22'),
(42, 'PRINCIPAL', 5, '2025-07-01', 7, 'f5-12312', NULL, '2025-07-06 04:21:37', '2025-07-06 04:21:37'),
(43, 'PRINCIPAL', 5, '2025-08-01', 0, '2211313', NULL, '2025-08-29 05:42:16', '2025-08-29 05:42:16'),
(44, 'PRINCIPAL', 5, '2025-08-01', 454, '2211313-6', NULL, '2025-08-29 06:09:36', '2025-08-29 05:42:16'),
(45, 'PRINCIPAL', 5, '2025-08-01', 373, '2010212', NULL, '2025-08-29 05:42:16', '2025-08-29 05:42:16'),
(46, 'PRINCIPAL', 5, '2025-08-01', 0, 'f012-123456', NULL, '2025-08-29 05:42:16', '2025-08-29 05:42:16'),
(47, 'PRINCIPAL', 5, '2025-08-01', 100, 'f01,123', NULL, '2025-08-29 05:42:16', '2025-08-29 05:42:16'),
(48, 'PRINCIPAL', 5, '2025-08-01', 2, 'f5-12312', NULL, '2025-08-29 06:13:43', '2025-08-29 05:42:16'),
(49, 'PRINCIPAL', 6, '2025-08-01', 857, '2131223b231', NULL, '2025-08-29 05:42:53', '2025-08-29 05:42:53'),
(50, 'PRINCIPAL', 7, '2025-08-01', 88, 'f012-123456', NULL, '2025-08-29 05:42:55', '2025-08-29 05:42:55'),
(51, 'PRINCIPAL', 5, '2025-09-01', 0, '2211313', NULL, '2025-09-01 14:35:56', '2025-09-01 14:35:56'),
(52, 'PRINCIPAL', 5, '2025-09-01', 454, '2211313-6', NULL, '2025-09-01 14:35:56', '2025-09-01 14:35:56'),
(53, 'PRINCIPAL', 5, '2025-09-01', 373, '2010212', NULL, '2025-09-01 14:35:56', '2025-09-01 14:35:56'),
(54, 'PRINCIPAL', 5, '2025-09-01', 0, 'f012-123456', NULL, '2025-09-01 14:35:56', '2025-09-01 14:35:56'),
(55, 'PRINCIPAL', 5, '2025-09-01', 100, 'f01,123', NULL, '2025-09-01 14:35:56', '2025-09-01 14:35:56'),
(56, 'PRINCIPAL', 5, '2025-09-01', 2, 'f5-12312', NULL, '2025-09-01 14:35:56', '2025-09-01 14:35:56'),
(57, 'PRINCIPAL', 5, '2025-09-01', 400, '2131446iui', NULL, '2025-09-01 14:36:43', '2025-09-01 14:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `control_cebado`
--

CREATE TABLE `control_cebado` (
  `idControl` int NOT NULL,
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
  `status` enum('Y','N','D') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `fk_insumos` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `control_cebado`
--

INSERT INTO `control_cebado` (`idControl`, `actualFecha`, `siguienteFecha`, `lote1`, `cant1`, `lote2`, `cant2`, `lote3`, `cant3`, `lote4`, `cant4`, `status`, `updated_at`, `created_at`, `fk_insumos`) VALUES
(1, '2025-06-11', '2025-06-12', '2010212', 5, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '2025-06-11', '2025-06-11', 5),
(3, '2025-06-20', '2025-06-21', NULL, NULL, '2211313-6', 7, NULL, NULL, NULL, NULL, 'N', '2025-06-20', '2025-06-20', 5),
(4, '2025-06-20', '2025-06-21', NULL, NULL, '2211313-6', 4, NULL, NULL, NULL, NULL, 'N', '2025-06-20', '2025-06-20', 5),
(5, '2025-06-20', '2025-06-21', NULL, NULL, '2010212', 5, NULL, NULL, NULL, NULL, 'N', '2025-06-20', '2025-06-20', 5),
(6, '2025-06-20', '2025-06-21', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-20', '2025-06-20', 5),
(7, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(8, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(9, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(10, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(11, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(12, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(13, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(14, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(15, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(16, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(17, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(18, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(19, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(20, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(21, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(22, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(23, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(24, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(25, '2025-06-21', '2025-06-23', NULL, NULL, '2010212', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(26, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(27, '2025-06-21', '2025-06-23', '2010212', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(39, '2025-06-21', '2025-06-23', NULL, NULL, NULL, NULL, '2211313', 1, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(40, '2025-06-21', '2025-06-23', NULL, NULL, '2211313-6', 1, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(41, '2025-06-21', '2025-06-23', '2010212', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '2025-06-21', '2025-06-21', 5),
(42, '2025-06-21', '2025-06-23', NULL, NULL, NULL, NULL, NULL, NULL, 'f012-123456', 2, 'N', '2025-06-21', '2025-06-21', 5),
(43, '2025-06-22', '2025-06-23', '2131223b231', 6, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '2025-06-22', '2025-06-22', 6),
(44, '2025-07-05', '2025-07-07', '2010212', 123, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '2025-07-05', '2025-07-05', 5),
(45, '2025-07-05', '2025-07-07', '2131223b231', 4, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '2025-07-05', '2025-07-05', 6),
(46, '2025-07-05', '2025-07-07', NULL, NULL, NULL, NULL, '2211313', 10, NULL, NULL, 'N', '2025-07-05', '2025-07-05', 5),
(47, '2025-07-05', '2025-07-07', '2131223b231', 97, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '2025-07-05', '2025-07-05', 6),
(48, '2025-07-05', '2025-07-07', NULL, NULL, NULL, NULL, NULL, NULL, 'f012-123456', 12, 'N', '2025-07-05', '2025-07-05', 5),
(49, '2025-07-06', '2025-07-07', NULL, NULL, NULL, NULL, NULL, NULL, 'f012-123456', 1, 'N', '2025-07-06', '2025-07-06', 5),
(50, '2025-07-06', '2025-07-07', NULL, NULL, '2211313-6', 12, NULL, NULL, NULL, NULL, 'N', '2025-07-06', '2025-07-06', 5),
(51, '2025-07-06', '2025-07-07', '2131223b231', 12, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '2025-07-06', '2025-07-06', 6),
(52, '2025-07-06', '2025-07-07', 'f012-123456', 12, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '2025-07-06', '2025-07-06', 7),
(53, '2025-08-29', '2025-08-30', NULL, NULL, '2211313-6', 10, NULL, NULL, NULL, NULL, 'N', '2025-08-29', '2025-08-29', 5),
(54, '2025-08-29', '2025-08-30', NULL, NULL, '2211313-6', 3, NULL, NULL, NULL, NULL, 'N', '2025-08-29', '2025-08-29', 5),
(55, '2025-08-29', '2025-08-30', NULL, NULL, '2211313-6', 3, NULL, NULL, NULL, NULL, 'N', '2025-08-29', '2025-08-29', 5),
(56, '2025-08-29', '2025-08-30', NULL, NULL, NULL, NULL, NULL, NULL, 'f5-12312', 5, 'N', '2025-08-29', '2025-08-29', 5);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insumos`
--

CREATE TABLE `insumos` (
  `idInsumo` int UNSIGNED NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idKarness` int UNSIGNED NOT NULL,
  `control_cebado` enum('Y','N') DEFAULT NULL,
  `control_emergencia` enum('Y','N') DEFAULT NULL,
  `almacenPrincipal` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `almacenSegundo` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `insumos`
--

INSERT INTO `insumos` (`idInsumo`, `Nombre`, `descripcion`, `idKarness`, `control_cebado`, `control_emergencia`, `almacenPrincipal`, `almacenSegundo`, `updated_at`, `created_at`) VALUES
(1, 'Acido - A Galonera 4L', NULL, 1, 'N', 'N', 'N', 'Y', NULL, NULL),
(2, 'ACIDO - B BICARBONATO  4L', NULL, 1, 'N', 'N', 'N', 'Y', NULL, NULL),
(3, 'ACIDO - DIAFLEX', NULL, 1, 'N', 'N', 'N', 'Y', NULL, NULL),
(4, 'BIG GAG', NULL, 1, 'N', 'N', 'N', 'Y', NULL, NULL),
(5, 'SET DE LINEA', NULL, 1, 'Y', 'Y', 'Y', 'Y', NULL, NULL),
(6, 'FILTRO 1.8', NULL, 1, 'Y', 'Y', 'Y', 'Y', NULL, NULL),
(7, 'FILTRO 2.2', NULL, 1, 'Y', 'N', 'Y', 'Y', NULL, NULL),
(8, 'EQUIPO DE VENOCLISIS', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(9, 'FISTULA N°15', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(10, 'FISTULA N°16', NULL, 1, 'N', 'N', 'Y', 'Y', NULL, NULL),
(11, 'FISTULA N°17', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(12, 'JERINGA 1CC', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(13, 'JERINGA 3CC', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(14, 'JERINGA 5CC', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(15, 'JERINGA 10 CC', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(16, 'JERINGA 20CC', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(17, 'HEPARINA 1000', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(18, 'HEPARINA 5000', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(19, 'CLORURO 0.9 1- LITRO', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(20, 'MASCARRILLA - SIMPLE', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(21, 'GORRO', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(22, 'GUANTES \"S\"', NULL, 1, 'N', 'N', 'Y', 'Y', NULL, NULL),
(23, 'GUANTES \"M\"', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(24, 'GUANTES 7 1 1/2', NULL, 1, 'N', 'N', 'Y', 'Y', NULL, NULL),
(25, 'TEGGADER', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(26, 'MICROPORE', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(27, 'TRANSPORE', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(28, 'BOLSA 10*15', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(29, 'BOLSA 8*12', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(30, 'BOLSA 14*20', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(31, 'PAÑOS DE MAQUINA', NULL, 1, 'N', 'N', 'Y', 'N', NULL, NULL),
(32, 'CLORURO 100 ML', NULL, 2, 'N', 'N', 'Y', 'Y', NULL, NULL),
(33, 'PAPEL CREPADO', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(34, 'PAPEL TOALLA Ó INTERFOLEADO', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(35, 'GASA', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(36, 'ALGODÓN HIDROFILICO', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(37, 'ALCOHOL 1LITRO', NULL, 2, 'N', 'N', 'N', 'Y', NULL, NULL),
(38, 'ALCOHOL EN GEL 70X500 ML', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(39, 'HISTORIA CLINICA', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(40, 'CLOREXIHIDINA Ó HIBICLEN 2%', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(41, 'CLOREXIHIDINA Ó HIBICLEN 4%', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(42, 'CAJA PUNZO CORTANTE', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(43, 'CAJA PUNZO CORTANTE AMARILLO', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(44, 'BENCINA', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(45, 'MANDILES', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(46, 'PAPEL BOND', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(47, 'FILTRO DE CARBON', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(48, 'FILTRO DE DIAFASE', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(49, 'FILTRO 0.45', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(50, 'FILTRO 0.02', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(51, 'FILTRO MICRO N°5', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(52, 'FILTRO DE SEDIMENTO -EMERGENCIA', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(53, 'FILTRO CARTUCHO', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(54, 'CINTA TESTIGO', NULL, 2, 'N', 'N', 'Y', 'N', NULL, NULL),
(55, 'TEST DE BOWIE', NULL, 2, 'N', 'N', 'Y', 'N', '2025-06-02', NULL),
(56, 'AGUJA N°18', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(57, 'AGUJA N°21', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(58, 'AGUJA N°25', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(59, 'ABOCAT N°20', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(60, 'ABOCAT N°18', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(61, 'LLAVE DE TRIPLE VIA', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(62, 'EPINEFRINA 1MG/ML', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(63, 'BICARBONATO DE SODIO 8.4%', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(64, 'PROTAMINA', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(65, 'GLUCONATO DE CALCIO 10%', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(66, 'DEXTROSA AL 33%', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(67, 'DICLOFENACO 75MG/3ML', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(68, 'DIMENHIDRINATO 50MG/5ML', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(69, 'CLORFENAMINA', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(70, 'HIOSCINA 20MG /ESCOPOLAMINA', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(71, 'CAPTOPRIL TAB.', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(72, 'PARACETAMOL 500 MG', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(73, 'LOSARTAN POTASICO 50 MG X 100 TAB', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(74, 'METAMIZOL X 1GR.AMP', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(75, 'NIFEDIPINO DE 10 MG', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(76, 'DEXAMETASONA 4MG AMP.', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(77, 'DIAZEPAM 10 MG/2ML', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(78, 'ACCU-CHEK', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(79, 'HIDROCORTISONA SUCCINATO 250MG X 10 VIAL-PHARMAGEN', NULL, 3, 'N', 'N', 'Y', 'N', NULL, NULL),
(82, 'Puristeril', NULL, 3, 'N', 'N', 'N', 'Y', '2025-06-22', '2025-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `inventario`
--

CREATE TABLE `inventario` (
  `idInsumo` int UNSIGNED NOT NULL,
  `cant_atencion` int DEFAULT NULL,
  `tipo_cantidad` enum('s','d') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventario`
--

INSERT INTO `inventario` (`idInsumo`, `cant_atencion`, `tipo_cantidad`) VALUES
(1, 15, 'd'),
(2, 15, 'd'),
(3, 46, 'd'),
(4, 46, 'd'),
(5, 60, 'd'),
(6, 50, 'd'),
(7, 20, 'd'),
(8, 50, 'd'),
(9, 35, 'd'),
(10, 51, 'd'),
(11, 45, 'd'),
(12, 12, 'd'),
(13, 45, 'd'),
(14, 78, 'd'),
(15, 45, 'd'),
(16, 13, 'd'),
(17, 35, 'd'),
(18, 30, 'd'),
(19, 50, 'd'),
(20, 50, 'd'),
(21, 35, 'd'),
(22, 45, 'd'),
(23, 45, 'd'),
(24, 50, 'd'),
(25, 40, 's'),
(26, 20, 's'),
(27, 15, 's'),
(28, 3, 'd'),
(29, 3, 'd'),
(30, 3, 'd'),
(31, 47, 'd'),
(32, 50, 'd'),
(33, 20, 'd'),
(34, 47, 'd'),
(35, 2, 'd'),
(36, 1, 'd'),
(37, 2, 'd'),
(38, 1, 's'),
(39, 6, 's'),
(40, 12, 'd'),
(41, 32, 'd'),
(42, 31, 'd'),
(43, 12, 'd'),
(44, 3, 'd'),
(45, 12, 'd'),
(46, 9, 'd'),
(47, 20, 'd'),
(48, 21, 'd'),
(49, 25, 'd'),
(50, 15, 'd'),
(51, 0, 'd'),
(52, 0, 'd'),
(53, 0, 'd'),
(54, 0, 'd'),
(55, 0, 'd'),
(56, 0, 'd'),
(57, 0, 'd'),
(58, 0, 'd'),
(59, 0, 'd'),
(60, 0, 'd'),
(61, 0, 'd'),
(62, 0, 'd'),
(63, 0, 'd'),
(64, 0, 'd'),
(65, 0, 'd'),
(66, 0, 'd'),
(67, 0, 'd'),
(68, 0, 'd'),
(69, 0, 'd'),
(70, 0, 'd'),
(71, 0, 'd'),
(72, 0, 'd'),
(73, 0, 'd'),
(74, 0, 'd'),
(75, 0, 'd'),
(76, 0, 'd'),
(77, 0, 'd'),
(78, 0, 'd'),
(79, 0, 'd'),
(82, 6, 's');

-- --------------------------------------------------------

--
-- Table structure for table `karness`
--

CREATE TABLE `karness` (
  `idKarness` int UNSIGNED NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karness`
--

INSERT INTO `karness` (`idKarness`, `nombre`) VALUES
(1, 'ALTO'),
(3, 'BAJO'),
(2, 'MEDIO'),
(4, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_02_02_131917_create_permission_tables', 1),
(6, '2025_02_02_235942_add_apellido_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Table structure for table `movimiento_almacen`
--

CREATE TABLE `movimiento_almacen` (
  `idMovimiento` int NOT NULL,
  `fk_insumos` int UNSIGNED NOT NULL,
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
  `almacen` enum('PRINCIPAL','SECUNDARIO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `movimiento_almacen`
--

INSERT INTO `movimiento_almacen` (`idMovimiento`, `fk_insumos`, `fecha`, `tipo_movimiento`, `cant_movida`, `stock`, `factu_o_boleta`, `observacion`, `lote`, `proveedor`, `updated_at`, `created_at`, `almacen`) VALUES
(58, 5, '2025-05-29', 'entrada', 3, NULL, NULL, '12313', '2211313', '121332', '2025-05-29 02:16:44', '2025-05-29 02:16:44', 'PRINCIPAL'),
(65, 5, '2025-05-29', 'entrada', 3, NULL, NULL, '12313123dsdfsadf', '2211313', 'daadfadfadf', '2025-05-29 02:29:07', '2025-05-29 02:29:07', 'PRINCIPAL'),
(66, 5, '2025-05-29', 'entrada', 3, NULL, NULL, '12313d', '2211313', '1231e', '2025-05-29 02:30:23', '2025-05-29 02:30:23', 'PRINCIPAL'),
(67, 5, '2025-05-29', 'entrada', 5, NULL, NULL, '123123', '2211313', '123123', '2025-05-29 03:42:42', '2025-05-29 03:42:42', 'PRINCIPAL'),
(68, 5, '2025-05-29', 'entrada', 3, NULL, NULL, 'eds', '2211313-6', 'ddsdsd', '2025-05-29 03:50:52', '2025-05-29 03:50:52', 'PRINCIPAL'),
(70, 5, '2025-05-29', 'salida', 6, NULL, NULL, '12313', '2211313', NULL, '2025-05-29 05:26:40', '2025-05-29 05:26:40', 'PRINCIPAL'),
(71, 5, '2025-05-29', 'salida', 5, NULL, NULL, '123213', '2211313', NULL, '2025-05-29 05:26:40', '2025-05-29 05:26:40', 'PRINCIPAL'),
(72, 5, '2025-05-29', 'entrada', 5, NULL, NULL, '123123123', '2211313', '123123123', '2025-05-29 05:27:06', '2025-05-29 05:27:06', 'PRINCIPAL'),
(73, 6, '2025-05-29', 'entrada', 1000, NULL, NULL, 'Entrada de filtros', '2131223b231', 'FRESENIUS', '2025-05-30 15:20:57', '2025-05-29 05:29:36', 'PRINCIPAL'),
(74, 6, '2025-05-29', 'salida', 5, NULL, NULL, '123', '2131223b231', NULL, '2025-05-29 05:30:05', '2025-05-29 05:30:05', 'PRINCIPAL'),
(75, 5, '2025-05-29', 'entrada', 5, NULL, NULL, '123123', '2211313', '123123', '2025-05-29 07:05:42', '2025-05-29 07:05:42', 'PRINCIPAL'),
(76, 5, '2025-05-29', 'entrada', 5, NULL, NULL, '123123', '2211313-6', '123123', '2025-05-29 07:05:53', '2025-05-29 07:05:53', 'PRINCIPAL'),
(77, 5, '2025-05-29', 'entrada', 5, NULL, NULL, '123123', '2211313-6', '123123', '2025-05-29 07:06:16', '2025-05-29 07:06:16', 'PRINCIPAL'),
(78, 5, '2025-05-29', 'entrada', 5, NULL, '123123', '123123', '2211313-6', '123123', '2025-05-31 05:38:34', '2025-05-29 07:06:29', 'PRINCIPAL'),
(82, 5, '2025-05-30', 'salida', 4, NULL, NULL, '123', '2211313-6', NULL, '2025-05-30 04:25:43', '2025-05-30 04:25:43', 'PRINCIPAL'),
(84, 9, '2025-05-30', 'entrada', 5, NULL, NULL, '1231313', NULL, '12312323', '2025-05-30 14:51:10', '2025-05-30 14:51:10', 'PRINCIPAL'),
(85, 9, '2025-05-30', 'salida', 5, NULL, NULL, '123', NULL, NULL, '2025-05-30 14:51:29', '2025-05-30 14:51:29', 'PRINCIPAL'),
(86, 6, '2025-05-30', 'salida', 5, NULL, NULL, '123', '2131223b231', NULL, '2025-05-30 15:22:00', '2025-05-30 15:22:00', 'PRINCIPAL'),
(90, 6, '2025-05-30', 'salida', 2, NULL, NULL, '31/05/2025 (I-II-III)', '2131223b231', NULL, '2025-05-31 04:43:45', '2025-05-31 04:43:45', 'PRINCIPAL'),
(91, 6, '2025-05-31', 'salida', 2, NULL, NULL, '02/06/2025 (I-II-III)', '2131223b231', NULL, '2025-05-31 04:44:23', '2025-05-31 04:44:23', 'PRINCIPAL'),
(92, 8, '2025-05-31', 'entrada', 550, NULL, NULL, 'ENTRADA DE INSUMOS', NULL, 'MEDICAD', '2025-05-31 04:57:55', '2025-05-31 04:57:55', 'PRINCIPAL'),
(93, 8, '2025-05-31', 'salida', 3, NULL, NULL, '02/06/2025 (I-II-III)', NULL, NULL, '2025-05-31 04:58:10', '2025-05-31 04:58:10', 'PRINCIPAL'),
(94, 8, '2025-05-31', 'entrada', 4, NULL, 'F001-12132', 'ENTRADA DE INSUMOS', NULL, 'MEDICAD', '2025-05-31 05:39:25', '2025-05-31 05:39:25', 'PRINCIPAL'),
(95, 6, '2025-06-01', 'salida', 3, NULL, NULL, '02/06/2025 (I-II-III)', '2131223b231', NULL, '2025-06-01 19:51:40', '2025-06-01 19:51:40', 'PRINCIPAL'),
(96, 5, '2025-06-01', 'salida', 4, NULL, NULL, '02/06/2025 (I-II-III)', '2211313', NULL, '2025-06-01 19:51:55', '2025-06-01 19:51:55', 'PRINCIPAL'),
(97, 8, '2025-06-01', 'salida', 6, NULL, NULL, '02/06/2025 (I-II-III)', NULL, NULL, '2025-06-01 19:52:13', '2025-06-01 19:52:13', 'PRINCIPAL'),
(99, 5, '2025-06-01', 'entrada', 1200, NULL, 'f011-12312', 'ENTRADA DE INSUMOS', '211231221', 'MEDICAD', '2025-06-01 19:59:07', '2025-06-01 19:59:07', 'SECUNDARIO'),
(100, 5, '2025-06-01', 'salida', 6, NULL, NULL, '02/06/2025 (I-II-III)', '211231221', NULL, '2025-06-01 19:59:30', '2025-06-01 19:59:30', 'SECUNDARIO'),
(101, 5, '2025-06-10', 'entrada', 123, NULL, 'F001-12132', 'ENTRADA DE INSUMOS', '2010212', 'MEDICAD', '2025-06-10 00:53:54', '2025-06-10 00:53:54', 'PRINCIPAL'),
(105, 8, '2025-06-10', 'salida', 5, NULL, NULL, '11/06/2025 (I-II-III)', NULL, NULL, '2025-06-10 00:56:33', '2025-06-10 00:56:33', 'PRINCIPAL'),
(108, 5, '2025-06-10', 'salida', 5, NULL, NULL, '11/06/2025 (I-II-III)', '2010212', NULL, '2025-06-10 00:59:48', '2025-06-10 00:59:48', 'PRINCIPAL'),
(109, 6, '2025-06-10', 'salida', 7, NULL, NULL, '11/06/2025 (I-II-III)', '2131223b231', NULL, '2025-06-10 02:44:23', '2025-06-10 02:44:23', 'PRINCIPAL'),
(110, 5, '2025-06-11', 'entrada', 400, NULL, '123123', 'ENTRADA DE INSUMOS', '2010212', 'Maximo', '2025-06-11 01:52:55', '2025-06-11 01:52:55', 'PRINCIPAL'),
(112, 5, '2025-06-11', 'salida', 5, NULL, NULL, '12/06/2025 (I-II-III)', '2010212', NULL, '2025-06-11 01:59:07', '2025-06-11 01:59:07', 'PRINCIPAL'),
(113, 5, '2025-06-20', 'salida', 6, NULL, NULL, '21/06/2025 (I-II-III)', '2211313', NULL, '2025-06-20 19:46:34', '2025-06-20 19:46:34', 'PRINCIPAL'),
(118, 5, '2025-06-20', 'salida', 7, NULL, NULL, '21/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-20 20:49:05', '2025-06-20 20:49:05', 'PRINCIPAL'),
(119, 5, '2025-06-20', 'salida', 4, NULL, NULL, '21/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-20 23:50:37', '2025-06-20 23:50:37', 'PRINCIPAL'),
(120, 5, '2025-06-20', 'salida', 5, NULL, NULL, '21/06/2025 (I-II-III)', '2010212', NULL, '2025-06-20 23:50:56', '2025-06-20 23:50:56', 'PRINCIPAL'),
(121, 5, '2025-06-20', 'salida', 1, NULL, NULL, '21/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-20 23:52:05', '2025-06-20 23:52:05', 'PRINCIPAL'),
(122, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 00:09:11', '2025-06-21 00:09:11', 'PRINCIPAL'),
(123, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 00:12:44', '2025-06-21 00:12:44', 'PRINCIPAL'),
(124, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 00:14:08', '2025-06-21 00:14:08', 'PRINCIPAL'),
(126, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 00:20:59', '2025-06-21 00:20:59', 'PRINCIPAL'),
(127, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 00:30:39', '2025-06-21 00:30:39', 'PRINCIPAL'),
(128, 5, '2025-06-21', 'entrada', 500, NULL, '123123', 'ENTRADA DE INSUMOS', '2211313-6', 'MEDICAD', '2025-06-21 00:33:18', '2025-06-21 00:33:18', 'PRINCIPAL'),
(129, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 00:33:29', '2025-06-21 00:33:29', 'PRINCIPAL'),
(130, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 00:51:02', '2025-06-21 00:51:02', 'PRINCIPAL'),
(131, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 00:54:32', '2025-06-21 00:54:32', 'PRINCIPAL'),
(132, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 00:57:48', '2025-06-21 00:57:48', 'PRINCIPAL'),
(133, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 01:02:07', '2025-06-21 01:02:07', 'PRINCIPAL'),
(134, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 01:06:00', '2025-06-21 01:06:00', 'PRINCIPAL'),
(135, 5, '2025-06-21', 'entrada', 15, NULL, '123123', 'ENTRADA DE INSUMOS', '2211313', 'MEDICAD', '2025-06-21 01:07:21', '2025-06-21 01:07:21', 'PRINCIPAL'),
(136, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 01:08:57', '2025-06-21 01:08:57', 'PRINCIPAL'),
(137, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 01:15:18', '2025-06-21 01:15:18', 'PRINCIPAL'),
(138, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 01:35:12', '2025-06-21 01:35:12', 'PRINCIPAL'),
(139, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 01:43:43', '2025-06-21 01:43:43', 'PRINCIPAL'),
(140, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 01:53:39', '2025-06-21 01:53:39', 'PRINCIPAL'),
(141, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 01:56:02', '2025-06-21 01:56:02', 'PRINCIPAL'),
(142, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 01:58:53', '2025-06-21 01:58:53', 'PRINCIPAL'),
(143, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 02:01:10', '2025-06-21 02:01:10', 'PRINCIPAL'),
(144, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 02:01:40', '2025-06-21 02:01:40', 'PRINCIPAL'),
(145, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 02:02:39', '2025-06-21 02:02:39', 'PRINCIPAL'),
(147, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 02:14:27', '2025-06-21 02:14:27', 'PRINCIPAL'),
(148, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313', NULL, '2025-06-21 02:17:19', '2025-06-21 02:17:19', 'PRINCIPAL'),
(149, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313', NULL, '2025-06-21 02:24:25', '2025-06-21 02:24:25', 'PRINCIPAL'),
(151, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313', NULL, '2025-06-21 02:51:18', '2025-06-21 02:51:18', 'PRINCIPAL'),
(157, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313', NULL, '2025-06-21 04:46:35', '2025-06-21 04:46:35', 'PRINCIPAL'),
(158, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313', NULL, '2025-06-21 04:49:24', '2025-06-21 04:49:24', 'PRINCIPAL'),
(159, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2211313-6', NULL, '2025-06-21 04:49:47', '2025-06-21 04:49:47', 'PRINCIPAL'),
(160, 5, '2025-06-21', 'salida', 1, NULL, NULL, '23/06/2025 (I-II-III)', '2010212', NULL, '2025-06-21 04:50:02', '2025-06-21 04:50:02', 'PRINCIPAL'),
(161, 5, '2025-06-21', 'entrada', 15, NULL, 'fv-1234', 'ENTRADA DE INSUMOS', 'f012-123456', 'MEDICAD', '2025-06-21 04:50:43', '2025-06-21 04:50:43', 'PRINCIPAL'),
(162, 5, '2025-06-21', 'salida', 2, NULL, NULL, '23/06/2025 (I-II-III)', 'f012-123456', NULL, '2025-06-21 04:50:54', '2025-06-21 04:50:54', 'PRINCIPAL'),
(163, 6, '2025-06-22', 'salida', 6, NULL, NULL, '23/06/2025 (I-II-III)', '2131223b231', NULL, '2025-06-22 07:31:42', '2025-06-22 07:31:42', 'PRINCIPAL'),
(164, 12, '2025-07-05', 'entrada', 200, NULL, 'f01-89821', 'ENTRADA DE INSUMOS', NULL, 'MEDICAD', '2025-07-05 03:59:49', '2025-07-05 03:59:49', 'PRINCIPAL'),
(165, 12, '2025-07-05', 'salida', 190, NULL, NULL, '07/07/2025 (I-II-III)', NULL, NULL, '2025-07-05 04:00:20', '2025-07-05 04:00:20', 'PRINCIPAL'),
(166, 5, '2025-07-05', 'salida', 123, NULL, NULL, '2025-07-05 (I-II-III)', '2010212', NULL, '2025-07-05 18:25:24', '2025-07-05 18:25:24', 'PRINCIPAL'),
(167, 6, '2025-07-05', 'salida', 4, NULL, NULL, '2025-07-05 (I-II-III)', '2131223b231', NULL, '2025-07-05 18:25:24', '2025-07-05 18:25:24', 'PRINCIPAL'),
(168, 8, '2025-07-05', 'salida', 1, NULL, NULL, '2025-07-05 (I-II-III)', NULL, NULL, '2025-07-05 18:25:24', '2025-07-05 18:25:24', 'PRINCIPAL'),
(169, 12, '2025-07-05', 'salida', 1, NULL, NULL, '2025-07-05 (I-II-III)', NULL, NULL, '2025-07-05 18:25:24', '2025-07-05 18:25:24', 'PRINCIPAL'),
(170, 5, '2025-07-05', 'salida', 10, NULL, NULL, '2025-07-05 (I-II-III)', '2211313', NULL, '2025-07-05 21:00:19', '2025-07-05 21:00:19', 'PRINCIPAL'),
(171, 6, '2025-07-05', 'salida', 97, NULL, NULL, '2025-07-05 (I-II-III)', '2131223b231', NULL, '2025-07-05 21:00:20', '2025-07-05 21:00:20', 'PRINCIPAL'),
(172, 8, '2025-07-05', 'salida', 54, NULL, NULL, '2025-07-05 (I-II-III)', NULL, NULL, '2025-07-05 21:00:20', '2025-07-05 21:00:20', 'PRINCIPAL'),
(173, 5, '2025-07-05', 'salida', 12, NULL, NULL, '2025-07-05 (I-II-III)', 'f012-123456', NULL, '2025-07-05 23:02:40', '2025-07-05 23:02:40', 'PRINCIPAL'),
(174, 7, '2025-07-06', 'entrada', 100, NULL, 'F001-12132', 'ENTRADA DE INSUMOS', 'f012-123456', 'MEDICAD', '2025-07-06 03:57:07', '2025-07-06 03:57:07', 'PRINCIPAL'),
(175, 9, '2025-07-06', 'entrada', 100, NULL, 'F001-12132', 'ENTRADA DE INSUMOS', NULL, 'MEDICAD', '2025-07-06 03:57:41', '2025-07-06 03:57:41', 'PRINCIPAL'),
(176, 10, '2025-07-06', 'entrada', 100, NULL, 'F001-12132', 'ENTRADA DE INSUMOS', NULL, 'MEDICAD', '2025-07-06 03:58:00', '2025-07-06 03:58:00', 'PRINCIPAL'),
(177, 5, '2025-07-06', 'salida', 1, NULL, NULL, '07/07/2025 (I-II-III)', 'f012-123456', NULL, '2025-07-06 04:16:46', '2025-07-06 04:16:46', 'PRINCIPAL'),
(178, 5, '2025-07-06', 'entrada', 100, NULL, '123123', 'ENTRADA DE INSUMOS', 'f01,123', 'MEDICAD', '2025-07-06 04:18:22', '2025-07-06 04:18:22', 'PRINCIPAL'),
(179, 5, '2025-07-06', 'salida', 7, NULL, NULL, '123', '2211313-6', NULL, '2025-07-06 04:21:11', '2025-07-06 04:21:11', 'PRINCIPAL'),
(180, 5, '2025-07-06', 'entrada', 7, NULL, 'F001-12132', 'ENTRADA DE INSUMOS', 'f5-12312', 'MEDICAD', '2025-07-06 04:21:37', '2025-07-06 04:21:37', 'PRINCIPAL'),
(181, 5, '2025-07-06', 'salida', 12, NULL, NULL, '2025-07-06 (I-II-III)', '2211313-6', NULL, '2025-07-06 04:28:24', '2025-07-06 04:28:24', 'PRINCIPAL'),
(182, 6, '2025-07-06', 'salida', 12, NULL, NULL, '2025-07-06 (I-II-III)', '2131223b231', NULL, '2025-07-06 04:28:24', '2025-07-06 04:28:24', 'PRINCIPAL'),
(183, 7, '2025-07-06', 'salida', 12, NULL, NULL, '2025-07-06 (I-II-III)', 'f012-123456', NULL, '2025-07-06 04:28:24', '2025-07-06 04:28:24', 'PRINCIPAL'),
(184, 5, '2025-08-29', 'salida', 10, NULL, NULL, '30/08/2025 (I-II-III)', '2211313-6', NULL, '2025-08-29 05:42:39', '2025-08-29 05:42:39', 'PRINCIPAL'),
(185, 5, '2025-08-29', 'salida', 3, NULL, NULL, '30/08/2025 (I-II-III)', '2211313-6', NULL, '2025-08-29 06:09:10', '2025-08-29 06:09:10', 'PRINCIPAL'),
(186, 5, '2025-08-29', 'salida', 3, NULL, NULL, '30/08/2025 (I-II-III)', '2211313-6', NULL, '2025-08-29 06:09:36', '2025-08-29 06:09:36', 'PRINCIPAL'),
(187, 5, '2025-08-29', 'salida', 5, NULL, NULL, '30/08/2025 (I-II-III)', 'f5-12312', NULL, '2025-08-29 06:13:43', '2025-08-29 06:13:43', 'PRINCIPAL'),
(188, 5, '2025-09-01', 'entrada', 400, NULL, 'fgdfsg', 'ENTRADA DE INSUMOS', '2131446iui', 'MEDICAD', '2025-09-01 14:36:43', '2025-09-01 14:36:43', 'PRINCIPAL');

-- --------------------------------------------------------

--
-- Table structure for table `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int NOT NULL,
  `Nombre` int NOT NULL DEFAULT '0',
  `Apellido` int NOT NULL DEFAULT '0',
  `DNI` int NOT NULL DEFAULT '0',
  `Telefono` int NOT NULL DEFAULT '0',
  `Direccion` int NOT NULL DEFAULT '0',
  `Control` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'users.index', 'web', '2025-02-04 04:40:36', '2025-02-04 04:40:36'),
(2, 'users.create', 'web', '2025-02-04 04:40:36', '2025-02-04 04:40:36'),
(3, 'users.edit', 'web', '2025-02-04 04:40:36', '2025-02-04 04:40:36'),
(4, 'users.delete', 'web', '2025-02-04 04:40:36', '2025-02-04 04:40:36'),
(5, 'almacen.index', 'web', '2025-06-02 17:50:10', '2025-06-02 17:50:11'),
(6, 'almacen.create', 'web', '2025-06-02 17:50:22', '2025-06-02 17:50:23'),
(7, 'almacen.edit', 'web', '2025-06-02 17:50:37', '2025-06-02 17:50:38'),
(8, 'almacen.delete', 'web', '2025-06-02 17:50:49', '2025-06-02 17:50:50'),
(9, 'control_cebado.index', 'web', '2025-06-02 17:51:30', '2025-06-02 17:51:30'),
(10, 'control_cebado.create', 'web', '2025-06-02 17:51:45', '2025-06-02 17:51:46'),
(11, 'control_cebado.edit', 'web', '2025-06-02 17:51:56', '2025-06-02 17:51:57'),
(12, 'control_cebado.delete', 'web', '2025-06-02 17:52:02', '2025-06-02 17:52:03'),
(13, 'inventario.index', 'web', '2025-06-02 17:52:46', '2025-06-02 17:52:47'),
(14, 'inventario.create', 'web', '2025-06-02 17:53:00', '2025-06-02 17:53:03'),
(15, 'inventario.edit', 'web', '2025-06-02 17:53:15', '2025-06-02 17:53:16'),
(16, 'inventario.delete', 'web', '2025-06-02 17:53:39', '2025-06-02 17:53:40'),
(17, 'permisos.index', 'web', '2025-06-02 17:54:54', '2025-06-02 17:54:55'),
(18, 'permisos.create', 'web', '2025-06-02 17:55:14', '2025-06-02 17:55:15'),
(19, 'permisos.edit', 'web', '2025-06-02 17:55:24', '2025-06-02 17:55:25'),
(20, 'permisos.delete', 'web', '2025-06-02 17:55:36', '2025-06-02 17:55:37'),
(21, 'role.index', 'web', '2025-06-02 17:55:55', '2025-06-02 17:55:56'),
(22, 'role.create', 'web', '2025-06-02 17:56:07', '2025-06-02 17:56:08'),
(23, 'role.edit', 'web', '2025-06-02 17:56:19', '2025-06-02 17:56:19'),
(24, 'role.delete', 'web', '2025-06-02 17:56:31', '2025-06-02 17:56:31'),
(25, 'petitorio.index', 'web', '2025-06-23 19:09:41', '2025-06-23 19:09:41'),
(26, 'petitorio.create', 'web', '2025-06-23 19:09:42', '2025-06-23 19:09:42'),
(27, 'petitorio.edit', 'web', '2025-06-23 19:09:43', '2025-06-23 19:09:44'),
(28, 'petitorio.delete', 'web', '2025-06-23 19:09:45', '2025-06-23 19:09:46'),
(29, 'petitorio.rectificador', 'web', '2025-07-01 00:35:52', '2025-07-01 00:35:53'),
(30, 'petitorio.borrador', 'web', '2025-07-01 00:36:14', '2025-07-01 00:36:15'),
(31, 'petitorio.confirmacion', 'web', '2025-07-01 00:36:40', '2025-07-01 00:36:41'),
(32, 'petitorio.show', 'web', '2025-07-05 18:55:34', '2025-07-05 18:55:35'),
(33, 'movimiento.create', 'web', '2025-07-05 22:21:58', '2025-07-05 22:21:59'),
(34, 'movimiento.edit', 'web', '2025-07-05 22:22:22', '2025-07-05 22:22:23'),
(35, 'movimiento.delete', 'web', '2025-07-05 22:22:34', '2025-07-05 22:22:35');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petitorio`
--

CREATE TABLE `petitorio` (
  `idpetitorio` int UNSIGNED NOT NULL,
  `fecha_servicio` date DEFAULT NULL,
  `fecha_creado` date DEFAULT NULL,
  `insumos_cant` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status_proceso` enum('borrador','rectificado','confirmado','cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status_confirmacion` enum('Y','N') DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `petitorio`
--

INSERT INTO `petitorio` (`idpetitorio`, `fecha_servicio`, `fecha_creado`, `insumos_cant`, `status_proceso`, `status_confirmacion`, `observacion`, `updated_at`, `created_at`) VALUES
(10, '2025-12-12', '2025-07-05', '[{\"idProducto\":1,\"nombre\":\"Acido - A Galonera 4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":2,\"nombre\":\"ACIDO - B BICARBONATO  4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":3,\"nombre\":\"ACIDO - DIAFLEX\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":4,\"nombre\":\"BIG GAG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":5,\"nombre\":\"SET DE LINEA\",\"stock\":\"1008\",\"cantidad_salida\":10,\"control_lote\":\"Y\",\"lotes_asignados\":[{\"lote\":\"2211313\",\"cantidad_disponible\":10,\"cantidad\":10}]},{\"idProducto\":6,\"nombre\":\"FILTRO 1.8\",\"stock\":\"970\",\"cantidad_salida\":97,\"control_lote\":\"Y\",\"lotes_asignados\":[{\"lote\":\"2131223b231\",\"cantidad_disponible\":966,\"cantidad\":97}]},{\"idProducto\":7,\"nombre\":\"FILTRO 2.2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":8,\"nombre\":\"EQUIPO DE VENOCLISIS\",\"stock\":\"540\",\"cantidad_salida\":54,\"control_lote\":\"N\"},{\"idProducto\":9,\"nombre\":\"FISTULA N\\u00b015\",\"stock\":\"0\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":10,\"nombre\":\"FISTULA N\\u00b016\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":11,\"nombre\":\"FISTULA N\\u00b017\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":12,\"nombre\":\"JERINGA 1CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":13,\"nombre\":\"JERINGA 3CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":14,\"nombre\":\"JERINGA 5CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":15,\"nombre\":\"JERINGA 10 CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":16,\"nombre\":\"JERINGA 20CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":17,\"nombre\":\"HEPARINA 1000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":18,\"nombre\":\"HEPARINA 5000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":19,\"nombre\":\"CLORURO 0.9 1- LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":20,\"nombre\":\"MASCARRILLA - SIMPLE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":21,\"nombre\":\"GORRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":22,\"nombre\":\"GUANTES \\\"S\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":23,\"nombre\":\"GUANTES \\\"M\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":24,\"nombre\":\"GUANTES 7 1 1\\/2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":25,\"nombre\":\"TEGGADER\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":26,\"nombre\":\"MICROPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":27,\"nombre\":\"TRANSPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":28,\"nombre\":\"BOLSA 10*15\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":29,\"nombre\":\"BOLSA 8*12\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":30,\"nombre\":\"BOLSA 14*20\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":31,\"nombre\":\"PA\\u00d1OS DE MAQUINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":32,\"nombre\":\"CLORURO 100 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":33,\"nombre\":\"PAPEL CREPADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":34,\"nombre\":\"PAPEL TOALLA \\u00d3 INTERFOLEADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":35,\"nombre\":\"GASA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":36,\"nombre\":\"ALGOD\\u00d3N HIDROFILICO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":37,\"nombre\":\"ALCOHOL 1LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":38,\"nombre\":\"ALCOHOL EN GEL 70X500 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":39,\"nombre\":\"HISTORIA CLINICA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":40,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 2%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":41,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":42,\"nombre\":\"CAJA PUNZO CORTANTE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":43,\"nombre\":\"CAJA PUNZO CORTANTE AMARILLO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":44,\"nombre\":\"BENCINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":45,\"nombre\":\"MANDILES\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":46,\"nombre\":\"PAPEL BOND\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":47,\"nombre\":\"FILTRO DE CARBON\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":48,\"nombre\":\"FILTRO DE DIAFASE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":49,\"nombre\":\"FILTRO 0.45\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":50,\"nombre\":\"FILTRO 0.02\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":51,\"nombre\":\"FILTRO MICRO N\\u00b05\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":52,\"nombre\":\"FILTRO DE SEDIMENTO -EMERGENCIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":53,\"nombre\":\"FILTRO CARTUCHO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":54,\"nombre\":\"CINTA TESTIGO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":55,\"nombre\":\"TEST DE BOWIE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":56,\"nombre\":\"AGUJA N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":57,\"nombre\":\"AGUJA N\\u00b021\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":58,\"nombre\":\"AGUJA N\\u00b025\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":59,\"nombre\":\"ABOCAT N\\u00b020\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":60,\"nombre\":\"ABOCAT N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":61,\"nombre\":\"LLAVE DE TRIPLE VIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":62,\"nombre\":\"EPINEFRINA 1MG\\/ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":63,\"nombre\":\"BICARBONATO DE SODIO 8.4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":64,\"nombre\":\"PROTAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":65,\"nombre\":\"GLUCONATO DE CALCIO 10%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":66,\"nombre\":\"DEXTROSA AL 33%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":67,\"nombre\":\"DICLOFENACO 75MG\\/3ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":68,\"nombre\":\"DIMENHIDRINATO 50MG\\/5ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":69,\"nombre\":\"CLORFENAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":70,\"nombre\":\"HIOSCINA 20MG \\/ESCOPOLAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":71,\"nombre\":\"CAPTOPRIL TAB.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":72,\"nombre\":\"PARACETAMOL 500 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":73,\"nombre\":\"LOSARTAN POTASICO 50 MG X 100 TAB\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":74,\"nombre\":\"METAMIZOL X 1GR.AMP\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":75,\"nombre\":\"NIFEDIPINO DE 10 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":76,\"nombre\":\"DEXAMETASONA 4MG AMP.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":77,\"nombre\":\"DIAZEPAM 10 MG\\/2ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":78,\"nombre\":\"ACCU-CHEK\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":79,\"nombre\":\"HIDROCORTISONA SUCCINATO 250MG X 10 VIAL-PHARMAGEN\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":82,\"nombre\":\"Puristeril\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"}]', 'confirmado', 'Y', 'Prueba 1', '2025-07-05', '2025-07-05'),
(12, '2005-05-05', '2025-07-05', '[{\"idProducto\":1,\"nombre\":\"Acido - A Galonera 4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":2,\"nombre\":\"ACIDO - B BICARBONATO  4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":3,\"nombre\":\"ACIDO - DIAFLEX\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":4,\"nombre\":\"BIG GAG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":5,\"nombre\":\"SET DE LINEA\",\"stock\":\"1008\",\"cantidad_salida\":123,\"control_lote\":\"Y\",\"lotes_asignados\":[{\"lote\":\"2010212\",\"cantidad_disponible\":496,\"cantidad\":123}]},{\"idProducto\":6,\"nombre\":\"FILTRO 1.8\",\"stock\":\"970\",\"cantidad_salida\":4,\"control_lote\":\"Y\",\"lotes_asignados\":[{\"lote\":\"2131223b231\",\"cantidad_disponible\":970,\"cantidad\":4}]},{\"idProducto\":7,\"nombre\":\"FILTRO 2.2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":8,\"nombre\":\"EQUIPO DE VENOCLISIS\",\"stock\":\"540\",\"cantidad_salida\":1,\"control_lote\":\"N\"},{\"idProducto\":9,\"nombre\":\"FISTULA N\\u00b015\",\"stock\":\"0\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":10,\"nombre\":\"FISTULA N\\u00b016\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":11,\"nombre\":\"FISTULA N\\u00b017\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":12,\"nombre\":\"JERINGA 1CC\",\"stock\":\"10\",\"cantidad_salida\":1,\"control_lote\":\"N\"},{\"idProducto\":13,\"nombre\":\"JERINGA 3CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":14,\"nombre\":\"JERINGA 5CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":15,\"nombre\":\"JERINGA 10 CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":16,\"nombre\":\"JERINGA 20CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":17,\"nombre\":\"HEPARINA 1000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":18,\"nombre\":\"HEPARINA 5000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":19,\"nombre\":\"CLORURO 0.9 1- LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":20,\"nombre\":\"MASCARRILLA - SIMPLE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":21,\"nombre\":\"GORRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":22,\"nombre\":\"GUANTES \\\"S\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":23,\"nombre\":\"GUANTES \\\"M\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":24,\"nombre\":\"GUANTES 7 1 1\\/2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":25,\"nombre\":\"TEGGADER\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":26,\"nombre\":\"MICROPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":27,\"nombre\":\"TRANSPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":28,\"nombre\":\"BOLSA 10*15\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":29,\"nombre\":\"BOLSA 8*12\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":30,\"nombre\":\"BOLSA 14*20\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":31,\"nombre\":\"PA\\u00d1OS DE MAQUINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":32,\"nombre\":\"CLORURO 100 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":33,\"nombre\":\"PAPEL CREPADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":34,\"nombre\":\"PAPEL TOALLA \\u00d3 INTERFOLEADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":35,\"nombre\":\"GASA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":36,\"nombre\":\"ALGOD\\u00d3N HIDROFILICO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":37,\"nombre\":\"ALCOHOL 1LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":38,\"nombre\":\"ALCOHOL EN GEL 70X500 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":39,\"nombre\":\"HISTORIA CLINICA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":40,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 2%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":41,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":42,\"nombre\":\"CAJA PUNZO CORTANTE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":43,\"nombre\":\"CAJA PUNZO CORTANTE AMARILLO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":44,\"nombre\":\"BENCINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":45,\"nombre\":\"MANDILES\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":46,\"nombre\":\"PAPEL BOND\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":47,\"nombre\":\"FILTRO DE CARBON\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":48,\"nombre\":\"FILTRO DE DIAFASE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":49,\"nombre\":\"FILTRO 0.45\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":50,\"nombre\":\"FILTRO 0.02\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":51,\"nombre\":\"FILTRO MICRO N\\u00b05\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":52,\"nombre\":\"FILTRO DE SEDIMENTO -EMERGENCIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":53,\"nombre\":\"FILTRO CARTUCHO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":54,\"nombre\":\"CINTA TESTIGO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":55,\"nombre\":\"TEST DE BOWIE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":56,\"nombre\":\"AGUJA N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":57,\"nombre\":\"AGUJA N\\u00b021\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":58,\"nombre\":\"AGUJA N\\u00b025\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":59,\"nombre\":\"ABOCAT N\\u00b020\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":60,\"nombre\":\"ABOCAT N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":61,\"nombre\":\"LLAVE DE TRIPLE VIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":62,\"nombre\":\"EPINEFRINA 1MG\\/ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":63,\"nombre\":\"BICARBONATO DE SODIO 8.4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":64,\"nombre\":\"PROTAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":65,\"nombre\":\"GLUCONATO DE CALCIO 10%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":66,\"nombre\":\"DEXTROSA AL 33%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":67,\"nombre\":\"DICLOFENACO 75MG\\/3ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":68,\"nombre\":\"DIMENHIDRINATO 50MG\\/5ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":69,\"nombre\":\"CLORFENAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":70,\"nombre\":\"HIOSCINA 20MG \\/ESCOPOLAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":71,\"nombre\":\"CAPTOPRIL TAB.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":72,\"nombre\":\"PARACETAMOL 500 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":73,\"nombre\":\"LOSARTAN POTASICO 50 MG X 100 TAB\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":74,\"nombre\":\"METAMIZOL X 1GR.AMP\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":75,\"nombre\":\"NIFEDIPINO DE 10 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":76,\"nombre\":\"DEXAMETASONA 4MG AMP.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":77,\"nombre\":\"DIAZEPAM 10 MG\\/2ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":78,\"nombre\":\"ACCU-CHEK\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":79,\"nombre\":\"HIDROCORTISONA SUCCINATO 250MG X 10 VIAL-PHARMAGEN\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":82,\"nombre\":\"Puristeril\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"}]', 'confirmado', 'N', 'rrrrr', '2025-07-05', '2025-07-05'),
(13, '3434-12-12', '2025-07-05', '[{\"idProducto\":1,\"nombre\":\"Acido - A Galonera 4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":2,\"nombre\":\"ACIDO - B BICARBONATO  4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":3,\"nombre\":\"ACIDO - DIAFLEX\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":4,\"nombre\":\"BIG GAG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":5,\"nombre\":\"SET DE LINEA\",\"stock\":\"885\",\"cantidad_salida\":1,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":6,\"nombre\":\"FILTRO 1.8\",\"stock\":\"966\",\"cantidad_salida\":1,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":7,\"nombre\":\"FILTRO 2.2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":8,\"nombre\":\"EQUIPO DE VENOCLISIS\",\"stock\":\"539\",\"cantidad_salida\":1,\"control_lote\":\"N\"},{\"idProducto\":9,\"nombre\":\"FISTULA N\\u00b015\",\"stock\":\"0\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":10,\"nombre\":\"FISTULA N\\u00b016\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":11,\"nombre\":\"FISTULA N\\u00b017\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":12,\"nombre\":\"JERINGA 1CC\",\"stock\":\"9\",\"cantidad_salida\":1,\"control_lote\":\"N\"},{\"idProducto\":13,\"nombre\":\"JERINGA 3CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":14,\"nombre\":\"JERINGA 5CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":15,\"nombre\":\"JERINGA 10 CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":16,\"nombre\":\"JERINGA 20CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":17,\"nombre\":\"HEPARINA 1000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":18,\"nombre\":\"HEPARINA 5000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":19,\"nombre\":\"CLORURO 0.9 1- LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":20,\"nombre\":\"MASCARRILLA - SIMPLE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":21,\"nombre\":\"GORRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":22,\"nombre\":\"GUANTES \\\"S\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":23,\"nombre\":\"GUANTES \\\"M\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":24,\"nombre\":\"GUANTES 7 1 1\\/2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":25,\"nombre\":\"TEGGADER\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":26,\"nombre\":\"MICROPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":27,\"nombre\":\"TRANSPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":28,\"nombre\":\"BOLSA 10*15\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":29,\"nombre\":\"BOLSA 8*12\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":30,\"nombre\":\"BOLSA 14*20\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":31,\"nombre\":\"PA\\u00d1OS DE MAQUINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":32,\"nombre\":\"CLORURO 100 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":33,\"nombre\":\"PAPEL CREPADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":34,\"nombre\":\"PAPEL TOALLA \\u00d3 INTERFOLEADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":35,\"nombre\":\"GASA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":36,\"nombre\":\"ALGOD\\u00d3N HIDROFILICO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":37,\"nombre\":\"ALCOHOL 1LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":38,\"nombre\":\"ALCOHOL EN GEL 70X500 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":39,\"nombre\":\"HISTORIA CLINICA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":40,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 2%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":41,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":42,\"nombre\":\"CAJA PUNZO CORTANTE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":43,\"nombre\":\"CAJA PUNZO CORTANTE AMARILLO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":44,\"nombre\":\"BENCINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":45,\"nombre\":\"MANDILES\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":46,\"nombre\":\"PAPEL BOND\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":47,\"nombre\":\"FILTRO DE CARBON\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":48,\"nombre\":\"FILTRO DE DIAFASE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":49,\"nombre\":\"FILTRO 0.45\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":50,\"nombre\":\"FILTRO 0.02\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":51,\"nombre\":\"FILTRO MICRO N\\u00b05\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":52,\"nombre\":\"FILTRO DE SEDIMENTO -EMERGENCIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":53,\"nombre\":\"FILTRO CARTUCHO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":54,\"nombre\":\"CINTA TESTIGO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":55,\"nombre\":\"TEST DE BOWIE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":56,\"nombre\":\"AGUJA N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":57,\"nombre\":\"AGUJA N\\u00b021\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":58,\"nombre\":\"AGUJA N\\u00b025\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":59,\"nombre\":\"ABOCAT N\\u00b020\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":60,\"nombre\":\"ABOCAT N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":61,\"nombre\":\"LLAVE DE TRIPLE VIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":62,\"nombre\":\"EPINEFRINA 1MG\\/ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":63,\"nombre\":\"BICARBONATO DE SODIO 8.4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":64,\"nombre\":\"PROTAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":65,\"nombre\":\"GLUCONATO DE CALCIO 10%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":66,\"nombre\":\"DEXTROSA AL 33%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":67,\"nombre\":\"DICLOFENACO 75MG\\/3ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":68,\"nombre\":\"DIMENHIDRINATO 50MG\\/5ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":69,\"nombre\":\"CLORFENAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":70,\"nombre\":\"HIOSCINA 20MG \\/ESCOPOLAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":71,\"nombre\":\"CAPTOPRIL TAB.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":72,\"nombre\":\"PARACETAMOL 500 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":73,\"nombre\":\"LOSARTAN POTASICO 50 MG X 100 TAB\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":74,\"nombre\":\"METAMIZOL X 1GR.AMP\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":75,\"nombre\":\"NIFEDIPINO DE 10 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":76,\"nombre\":\"DEXAMETASONA 4MG AMP.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":77,\"nombre\":\"DIAZEPAM 10 MG\\/2ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":78,\"nombre\":\"ACCU-CHEK\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":79,\"nombre\":\"HIDROCORTISONA SUCCINATO 250MG X 10 VIAL-PHARMAGEN\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":82,\"nombre\":\"Puristeril\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"}]', 'cancelado', 'N', '123123', '2025-07-05', '2025-07-05'),
(14, '2025-07-06', '2025-07-05', '[{\"idProducto\":1,\"nombre\":\"Acido - A Galonera 4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":2,\"nombre\":\"ACIDO - B BICARBONATO  4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":3,\"nombre\":\"ACIDO - DIAFLEX\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":4,\"nombre\":\"BIG GAG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":5,\"nombre\":\"SET DE LINEA\",\"stock\":\"875\",\"cantidad_salida\":12,\"control_lote\":\"Y\",\"lotes_asignados\":[{\"lote\":\"f012-123456\",\"cantidad_disponible\":13,\"cantidad\":12}]},{\"idProducto\":6,\"nombre\":\"FILTRO 1.8\",\"stock\":\"869\",\"cantidad_salida\":0,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":7,\"nombre\":\"FILTRO 2.2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":8,\"nombre\":\"EQUIPO DE VENOCLISIS\",\"stock\":\"485\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":9,\"nombre\":\"FISTULA N\\u00b015\",\"stock\":\"0\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":10,\"nombre\":\"FISTULA N\\u00b016\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":11,\"nombre\":\"FISTULA N\\u00b017\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":12,\"nombre\":\"JERINGA 1CC\",\"stock\":\"9\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":13,\"nombre\":\"JERINGA 3CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":14,\"nombre\":\"JERINGA 5CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":15,\"nombre\":\"JERINGA 10 CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":16,\"nombre\":\"JERINGA 20CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":17,\"nombre\":\"HEPARINA 1000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":18,\"nombre\":\"HEPARINA 5000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":19,\"nombre\":\"CLORURO 0.9 1- LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":20,\"nombre\":\"MASCARRILLA - SIMPLE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":21,\"nombre\":\"GORRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":22,\"nombre\":\"GUANTES \\\"S\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":23,\"nombre\":\"GUANTES \\\"M\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":24,\"nombre\":\"GUANTES 7 1 1\\/2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":25,\"nombre\":\"TEGGADER\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":26,\"nombre\":\"MICROPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":27,\"nombre\":\"TRANSPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":28,\"nombre\":\"BOLSA 10*15\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":29,\"nombre\":\"BOLSA 8*12\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":30,\"nombre\":\"BOLSA 14*20\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":31,\"nombre\":\"PA\\u00d1OS DE MAQUINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":32,\"nombre\":\"CLORURO 100 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":33,\"nombre\":\"PAPEL CREPADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":34,\"nombre\":\"PAPEL TOALLA \\u00d3 INTERFOLEADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":35,\"nombre\":\"GASA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":36,\"nombre\":\"ALGOD\\u00d3N HIDROFILICO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":37,\"nombre\":\"ALCOHOL 1LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":38,\"nombre\":\"ALCOHOL EN GEL 70X500 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":39,\"nombre\":\"HISTORIA CLINICA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":40,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 2%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":41,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":42,\"nombre\":\"CAJA PUNZO CORTANTE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":43,\"nombre\":\"CAJA PUNZO CORTANTE AMARILLO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":44,\"nombre\":\"BENCINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":45,\"nombre\":\"MANDILES\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":46,\"nombre\":\"PAPEL BOND\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":47,\"nombre\":\"FILTRO DE CARBON\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":48,\"nombre\":\"FILTRO DE DIAFASE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":49,\"nombre\":\"FILTRO 0.45\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":50,\"nombre\":\"FILTRO 0.02\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":51,\"nombre\":\"FILTRO MICRO N\\u00b05\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":52,\"nombre\":\"FILTRO DE SEDIMENTO -EMERGENCIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":53,\"nombre\":\"FILTRO CARTUCHO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":54,\"nombre\":\"CINTA TESTIGO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":55,\"nombre\":\"TEST DE BOWIE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":56,\"nombre\":\"AGUJA N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":57,\"nombre\":\"AGUJA N\\u00b021\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":58,\"nombre\":\"AGUJA N\\u00b025\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":59,\"nombre\":\"ABOCAT N\\u00b020\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":60,\"nombre\":\"ABOCAT N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":61,\"nombre\":\"LLAVE DE TRIPLE VIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":62,\"nombre\":\"EPINEFRINA 1MG\\/ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":63,\"nombre\":\"BICARBONATO DE SODIO 8.4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":64,\"nombre\":\"PROTAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":65,\"nombre\":\"GLUCONATO DE CALCIO 10%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":66,\"nombre\":\"DEXTROSA AL 33%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":67,\"nombre\":\"DICLOFENACO 75MG\\/3ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":68,\"nombre\":\"DIMENHIDRINATO 50MG\\/5ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":69,\"nombre\":\"CLORFENAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":70,\"nombre\":\"HIOSCINA 20MG \\/ESCOPOLAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":71,\"nombre\":\"CAPTOPRIL TAB.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":72,\"nombre\":\"PARACETAMOL 500 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":73,\"nombre\":\"LOSARTAN POTASICO 50 MG X 100 TAB\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":74,\"nombre\":\"METAMIZOL X 1GR.AMP\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":75,\"nombre\":\"NIFEDIPINO DE 10 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":76,\"nombre\":\"DEXAMETASONA 4MG AMP.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":77,\"nombre\":\"DIAZEPAM 10 MG\\/2ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":78,\"nombre\":\"ACCU-CHEK\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":79,\"nombre\":\"HIDROCORTISONA SUCCINATO 250MG X 10 VIAL-PHARMAGEN\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":82,\"nombre\":\"Puristeril\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"}]', 'confirmado', 'Y', 'dfdf. ya realizado el cambio para confirmar', '2025-07-05', '2025-07-05'),
(15, '2025-12-12', '2025-07-06', '[{\"idProducto\":1,\"nombre\":\"Acido - A Galonera 4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":2,\"nombre\":\"ACIDO - B BICARBONATO  4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":3,\"nombre\":\"ACIDO - DIAFLEX\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":4,\"nombre\":\"BIG GAG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":5,\"nombre\":\"SET DE LINEA\",\"stock\":\"962\",\"cantidad_salida\":12,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":6,\"nombre\":\"FILTRO 1.8\",\"stock\":\"869\",\"cantidad_salida\":12,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":7,\"nombre\":\"FILTRO 2.2\",\"stock\":\"100\",\"cantidad_salida\":12,\"control_lote\":\"Y\",\"lotes_asignados\":[]},{\"idProducto\":8,\"nombre\":\"EQUIPO DE VENOCLISIS\",\"stock\":\"485\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":9,\"nombre\":\"FISTULA N\\u00b015\",\"stock\":\"100\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":10,\"nombre\":\"FISTULA N\\u00b016\",\"stock\":\"100\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":11,\"nombre\":\"FISTULA N\\u00b017\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":12,\"nombre\":\"JERINGA 1CC\",\"stock\":\"9\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":13,\"nombre\":\"JERINGA 3CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":14,\"nombre\":\"JERINGA 5CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":15,\"nombre\":\"JERINGA 10 CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":16,\"nombre\":\"JERINGA 20CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":17,\"nombre\":\"HEPARINA 1000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":18,\"nombre\":\"HEPARINA 5000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":19,\"nombre\":\"CLORURO 0.9 1- LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":20,\"nombre\":\"MASCARRILLA - SIMPLE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":21,\"nombre\":\"GORRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":22,\"nombre\":\"GUANTES \\\"S\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":23,\"nombre\":\"GUANTES \\\"M\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":24,\"nombre\":\"GUANTES 7 1 1\\/2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":25,\"nombre\":\"TEGGADER\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":26,\"nombre\":\"MICROPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":27,\"nombre\":\"TRANSPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":28,\"nombre\":\"BOLSA 10*15\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":29,\"nombre\":\"BOLSA 8*12\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":30,\"nombre\":\"BOLSA 14*20\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":31,\"nombre\":\"PA\\u00d1OS DE MAQUINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":32,\"nombre\":\"CLORURO 100 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":33,\"nombre\":\"PAPEL CREPADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":34,\"nombre\":\"PAPEL TOALLA \\u00d3 INTERFOLEADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":35,\"nombre\":\"GASA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":36,\"nombre\":\"ALGOD\\u00d3N HIDROFILICO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":37,\"nombre\":\"ALCOHOL 1LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":38,\"nombre\":\"ALCOHOL EN GEL 70X500 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":39,\"nombre\":\"HISTORIA CLINICA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":40,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 2%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":41,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":42,\"nombre\":\"CAJA PUNZO CORTANTE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":43,\"nombre\":\"CAJA PUNZO CORTANTE AMARILLO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":44,\"nombre\":\"BENCINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":45,\"nombre\":\"MANDILES\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":46,\"nombre\":\"PAPEL BOND\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":47,\"nombre\":\"FILTRO DE CARBON\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":48,\"nombre\":\"FILTRO DE DIAFASE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":49,\"nombre\":\"FILTRO 0.45\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":50,\"nombre\":\"FILTRO 0.02\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":51,\"nombre\":\"FILTRO MICRO N\\u00b05\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":52,\"nombre\":\"FILTRO DE SEDIMENTO -EMERGENCIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":53,\"nombre\":\"FILTRO CARTUCHO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":54,\"nombre\":\"CINTA TESTIGO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":55,\"nombre\":\"TEST DE BOWIE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":56,\"nombre\":\"AGUJA N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":57,\"nombre\":\"AGUJA N\\u00b021\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":58,\"nombre\":\"AGUJA N\\u00b025\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":59,\"nombre\":\"ABOCAT N\\u00b020\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":60,\"nombre\":\"ABOCAT N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":61,\"nombre\":\"LLAVE DE TRIPLE VIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":62,\"nombre\":\"EPINEFRINA 1MG\\/ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":63,\"nombre\":\"BICARBONATO DE SODIO 8.4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":64,\"nombre\":\"PROTAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":65,\"nombre\":\"GLUCONATO DE CALCIO 10%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":66,\"nombre\":\"DEXTROSA AL 33%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":67,\"nombre\":\"DICLOFENACO 75MG\\/3ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":68,\"nombre\":\"DIMENHIDRINATO 50MG\\/5ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":69,\"nombre\":\"CLORFENAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":70,\"nombre\":\"HIOSCINA 20MG \\/ESCOPOLAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":71,\"nombre\":\"CAPTOPRIL TAB.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":72,\"nombre\":\"PARACETAMOL 500 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":73,\"nombre\":\"LOSARTAN POTASICO 50 MG X 100 TAB\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":74,\"nombre\":\"METAMIZOL X 1GR.AMP\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":75,\"nombre\":\"NIFEDIPINO DE 10 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":76,\"nombre\":\"DEXAMETASONA 4MG AMP.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":77,\"nombre\":\"DIAZEPAM 10 MG\\/2ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":78,\"nombre\":\"ACCU-CHEK\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":79,\"nombre\":\"HIDROCORTISONA SUCCINATO 250MG X 10 VIAL-PHARMAGEN\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":82,\"nombre\":\"Puristeril\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"}]', 'rectificado', 'N', 'oBSERVACION', '2025-09-05', '2025-07-06');
INSERT INTO `petitorio` (`idpetitorio`, `fecha_servicio`, `fecha_creado`, `insumos_cant`, `status_proceso`, `status_confirmacion`, `observacion`, `updated_at`, `created_at`) VALUES
(16, '1222-02-12', '2025-07-06', '[{\"idProducto\":1,\"nombre\":\"Acido - A Galonera 4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":2,\"nombre\":\"ACIDO - B BICARBONATO  4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":3,\"nombre\":\"ACIDO - DIAFLEX\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":4,\"nombre\":\"BIG GAG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":5,\"nombre\":\"SET DE LINEA\",\"stock\":\"962\",\"cantidad_salida\":12,\"control_lote\":\"Y\",\"lotes_asignados\":[{\"lote\":\"2211313-6\",\"cantidad_disponible\":482,\"cantidad\":12}]},{\"idProducto\":6,\"nombre\":\"FILTRO 1.8\",\"stock\":\"869\",\"cantidad_salida\":12,\"control_lote\":\"Y\",\"lotes_asignados\":[{\"lote\":\"2131223b231\",\"cantidad_disponible\":869,\"cantidad\":12}]},{\"idProducto\":7,\"nombre\":\"FILTRO 2.2\",\"stock\":\"100\",\"cantidad_salida\":12,\"control_lote\":\"Y\",\"lotes_asignados\":[{\"lote\":\"f012-123456\",\"cantidad_disponible\":100,\"cantidad\":12}]},{\"idProducto\":8,\"nombre\":\"EQUIPO DE VENOCLISIS\",\"stock\":\"485\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":9,\"nombre\":\"FISTULA N\\u00b015\",\"stock\":\"100\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":10,\"nombre\":\"FISTULA N\\u00b016\",\"stock\":\"100\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":11,\"nombre\":\"FISTULA N\\u00b017\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":12,\"nombre\":\"JERINGA 1CC\",\"stock\":\"9\",\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":13,\"nombre\":\"JERINGA 3CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":14,\"nombre\":\"JERINGA 5CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":15,\"nombre\":\"JERINGA 10 CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":16,\"nombre\":\"JERINGA 20CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":17,\"nombre\":\"HEPARINA 1000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":18,\"nombre\":\"HEPARINA 5000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":19,\"nombre\":\"CLORURO 0.9 1- LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":20,\"nombre\":\"MASCARRILLA - SIMPLE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":21,\"nombre\":\"GORRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":22,\"nombre\":\"GUANTES \\\"S\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":23,\"nombre\":\"GUANTES \\\"M\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":24,\"nombre\":\"GUANTES 7 1 1\\/2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":25,\"nombre\":\"TEGGADER\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":26,\"nombre\":\"MICROPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":27,\"nombre\":\"TRANSPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":28,\"nombre\":\"BOLSA 10*15\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":29,\"nombre\":\"BOLSA 8*12\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":30,\"nombre\":\"BOLSA 14*20\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":31,\"nombre\":\"PA\\u00d1OS DE MAQUINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":32,\"nombre\":\"CLORURO 100 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":33,\"nombre\":\"PAPEL CREPADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":34,\"nombre\":\"PAPEL TOALLA \\u00d3 INTERFOLEADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":35,\"nombre\":\"GASA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":36,\"nombre\":\"ALGOD\\u00d3N HIDROFILICO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":37,\"nombre\":\"ALCOHOL 1LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":38,\"nombre\":\"ALCOHOL EN GEL 70X500 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":39,\"nombre\":\"HISTORIA CLINICA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":40,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 2%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":41,\"nombre\":\"CLOREXIHIDINA \\u00d3 HIBICLEN 4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":42,\"nombre\":\"CAJA PUNZO CORTANTE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":43,\"nombre\":\"CAJA PUNZO CORTANTE AMARILLO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":44,\"nombre\":\"BENCINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":45,\"nombre\":\"MANDILES\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":46,\"nombre\":\"PAPEL BOND\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":47,\"nombre\":\"FILTRO DE CARBON\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":48,\"nombre\":\"FILTRO DE DIAFASE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":49,\"nombre\":\"FILTRO 0.45\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":50,\"nombre\":\"FILTRO 0.02\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":51,\"nombre\":\"FILTRO MICRO N\\u00b05\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":52,\"nombre\":\"FILTRO DE SEDIMENTO -EMERGENCIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":53,\"nombre\":\"FILTRO CARTUCHO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":54,\"nombre\":\"CINTA TESTIGO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":55,\"nombre\":\"TEST DE BOWIE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":56,\"nombre\":\"AGUJA N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":57,\"nombre\":\"AGUJA N\\u00b021\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":58,\"nombre\":\"AGUJA N\\u00b025\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":59,\"nombre\":\"ABOCAT N\\u00b020\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":60,\"nombre\":\"ABOCAT N\\u00b018\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":61,\"nombre\":\"LLAVE DE TRIPLE VIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":62,\"nombre\":\"EPINEFRINA 1MG\\/ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":63,\"nombre\":\"BICARBONATO DE SODIO 8.4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":64,\"nombre\":\"PROTAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":65,\"nombre\":\"GLUCONATO DE CALCIO 10%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":66,\"nombre\":\"DEXTROSA AL 33%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":67,\"nombre\":\"DICLOFENACO 75MG\\/3ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":68,\"nombre\":\"DIMENHIDRINATO 50MG\\/5ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":69,\"nombre\":\"CLORFENAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":70,\"nombre\":\"HIOSCINA 20MG \\/ESCOPOLAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":71,\"nombre\":\"CAPTOPRIL TAB.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":72,\"nombre\":\"PARACETAMOL 500 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":73,\"nombre\":\"LOSARTAN POTASICO 50 MG X 100 TAB\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":74,\"nombre\":\"METAMIZOL X 1GR.AMP\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":75,\"nombre\":\"NIFEDIPINO DE 10 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":76,\"nombre\":\"DEXAMETASONA 4MG AMP.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":77,\"nombre\":\"DIAZEPAM 10 MG\\/2ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":78,\"nombre\":\"ACCU-CHEK\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":79,\"nombre\":\"HIDROCORTISONA SUCCINATO 250MG X 10 VIAL-PHARMAGEN\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"},{\"idProducto\":82,\"nombre\":\"Puristeril\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\"}]', 'confirmado', 'Y', '122112', '2025-07-06', '2025-07-06'),
(17, '2026-02-12', '2025-09-05', '[{\"idProducto\":1,\"nombre\":\"Acido - A Galonera 4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":2,\"nombre\":\"ACIDO - B BICARBONATO  4L\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":3,\"nombre\":\"ACIDO - DIAFLEX\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":4,\"nombre\":\"BIG GAG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":5,\"nombre\":\"SET DE LINEA\",\"stock\":\"1329\",\"cantidad_salida\":5,\"control_lote\":\"Y\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":6,\"nombre\":\"FILTRO 1.8\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"Y\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":7,\"nombre\":\"FILTRO 2.2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"Y\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":8,\"nombre\":\"EQUIPO DE VENOCLISIS\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":9,\"nombre\":\"FISTULA N°15\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":10,\"nombre\":\"FISTULA N°16\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":11,\"nombre\":\"FISTULA N°17\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":12,\"nombre\":\"JERINGA 1CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":13,\"nombre\":\"JERINGA 3CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":14,\"nombre\":\"JERINGA 5CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":15,\"nombre\":\"JERINGA 10 CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":16,\"nombre\":\"JERINGA 20CC\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":17,\"nombre\":\"HEPARINA 1000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":18,\"nombre\":\"HEPARINA 5000\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":19,\"nombre\":\"CLORURO 0.9 1- LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":20,\"nombre\":\"MASCARRILLA - SIMPLE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":21,\"nombre\":\"GORRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":22,\"nombre\":\"GUANTES \\\"S\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":23,\"nombre\":\"GUANTES \\\"M\\\"\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":24,\"nombre\":\"GUANTES 7 1 1/2\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":25,\"nombre\":\"TEGGADER\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":26,\"nombre\":\"MICROPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":27,\"nombre\":\"TRANSPORE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":28,\"nombre\":\"BOLSA 10*15\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":29,\"nombre\":\"BOLSA 8*12\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":30,\"nombre\":\"BOLSA 14*20\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":31,\"nombre\":\"PAÑOS DE MAQUINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":32,\"nombre\":\"CLORURO 100 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":33,\"nombre\":\"PAPEL CREPADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":34,\"nombre\":\"PAPEL TOALLA Ó INTERFOLEADO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":35,\"nombre\":\"GASA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":36,\"nombre\":\"ALGODÓN HIDROFILICO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":37,\"nombre\":\"ALCOHOL 1LITRO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":38,\"nombre\":\"ALCOHOL EN GEL 70X500 ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":39,\"nombre\":\"HISTORIA CLINICA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":40,\"nombre\":\"CLOREXIHIDINA Ó HIBICLEN 2%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":41,\"nombre\":\"CLOREXIHIDINA Ó HIBICLEN 4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":42,\"nombre\":\"CAJA PUNZO CORTANTE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":43,\"nombre\":\"CAJA PUNZO CORTANTE AMARILLO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":44,\"nombre\":\"BENCINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":45,\"nombre\":\"MANDILES\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":46,\"nombre\":\"PAPEL BOND\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":47,\"nombre\":\"FILTRO DE CARBON\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":48,\"nombre\":\"FILTRO DE DIAFASE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":49,\"nombre\":\"FILTRO 0.45\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":50,\"nombre\":\"FILTRO 0.02\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":51,\"nombre\":\"FILTRO MICRO N°5\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":52,\"nombre\":\"FILTRO DE SEDIMENTO -EMERGENCIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":53,\"nombre\":\"FILTRO CARTUCHO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":54,\"nombre\":\"CINTA TESTIGO\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":55,\"nombre\":\"TEST DE BOWIE\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":56,\"nombre\":\"AGUJA N°18\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":57,\"nombre\":\"AGUJA N°21\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":58,\"nombre\":\"AGUJA N°25\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":59,\"nombre\":\"ABOCAT N°20\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":60,\"nombre\":\"ABOCAT N°18\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":61,\"nombre\":\"LLAVE DE TRIPLE VIA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":62,\"nombre\":\"EPINEFRINA 1MG/ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":63,\"nombre\":\"BICARBONATO DE SODIO 8.4%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":64,\"nombre\":\"PROTAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":65,\"nombre\":\"GLUCONATO DE CALCIO 10%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":66,\"nombre\":\"DEXTROSA AL 33%\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":67,\"nombre\":\"DICLOFENACO 75MG/3ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":68,\"nombre\":\"DIMENHIDRINATO 50MG/5ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":69,\"nombre\":\"CLORFENAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":70,\"nombre\":\"HIOSCINA 20MG /ESCOPOLAMINA\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":71,\"nombre\":\"CAPTOPRIL TAB.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":72,\"nombre\":\"PARACETAMOL 500 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":73,\"nombre\":\"LOSARTAN POTASICO 50 MG X 100 TAB\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":74,\"nombre\":\"METAMIZOL X 1GR.AMP\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":75,\"nombre\":\"NIFEDIPINO DE 10 MG\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":76,\"nombre\":\"DEXAMETASONA 4MG AMP.\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":77,\"nombre\":\"DIAZEPAM 10 MG/2ML\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":78,\"nombre\":\"ACCU-CHEK\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":79,\"nombre\":\"HIDROCORTISONA SUCCINATO 250MG X 10 VIAL-PHARMAGEN\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]},{\"idProducto\":82,\"nombre\":\"Puristeril\",\"stock\":0,\"cantidad_salida\":0,\"control_lote\":\"N\",\"estado_guardado\":\"N\",\"movimientos_guardad\":[]}]', 'borrador', 'N', NULL, '2025-09-05', '2025-09-05');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2025-02-03 07:58:40', '2025-02-03 07:58:40'),
(2, 'Almacen', 'web', '2025-02-03 07:58:40', '2025-02-03 07:58:40'),
(3, 'Tecnico', 'web', '2025-02-03 07:58:40', '2025-02-03 07:58:40'),
(4, 'jefatura_medica', 'web', '2025-06-22 08:45:42', '2025-06-22 08:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(5, 2),
(6, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(25, 2),
(27, 2),
(29, 2),
(32, 2),
(9, 3),
(25, 3),
(32, 3),
(5, 4),
(9, 4),
(25, 4),
(26, 4),
(27, 4),
(28, 4),
(32, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dni` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `dni`) VALUES
(2, 'Administrador', 'admin2', 'admin2@gmail.com', NULL, '$2y$12$93KIJShWfVshdPvH50AxiOBeOapWpOlISuFXCMSznBqf4iLiDMkvy', 'FXrEfOChL1eed3DiooiB0HCPWBDP3IyWMNndwXO0e6Djpg4kUu6EeZVPJgmL', '2025-02-03 05:35:33', '2025-05-29 12:01:20', NULL),
(6, 'almacen-PEDRO', 'Perez', '2323@gmail.com', NULL, '$2y$12$1uGKlz7.mhy1VoDctXgiquFV1KvUqJ36j/RgObThAvlUpRhgWaFgG', NULL, '2025-05-06 19:23:23', '2025-07-06 04:53:33', NULL),
(7, 'tecnico- Maria', 'Torres', 'maria@gmail.com', NULL, '$2y$12$F2yUr27Irz0NfLSD9kGjyuqRr0sXUbLGDfcTpgoS3KR3pJjIl5Nfy', NULL, '2025-07-06 02:01:28', '2025-07-06 04:53:44', NULL),
(8, 'jefe_medico - Pablo', 'Smith', 'juan@gmail.com', NULL, '$2y$12$dSJBI3JtJBHCzfd/E/GqFeOM7P5g97lafwImpwB3MmYkCg2Xo0vTu', NULL, '2025-07-06 02:02:11', '2025-07-06 04:53:57', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`idAlmacen`),
  ADD KEY `idInsumo` (`idInsumo`);

--
-- Indexes for table `control_cebado`
--
ALTER TABLE `control_cebado`
  ADD PRIMARY KEY (`idControl`),
  ADD KEY `fk_insumos` (`fk_insumos`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`idInsumo`),
  ADD KEY `FKidKarness` (`idKarness`);

--
-- Indexes for table `inventario`
--
ALTER TABLE `inventario`
  ADD KEY `fk_insumo` (`idInsumo`);

--
-- Indexes for table `karness`
--
ALTER TABLE `karness`
  ADD PRIMARY KEY (`idKarness`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `movimiento_almacen`
--
ALTER TABLE `movimiento_almacen`
  ADD PRIMARY KEY (`idMovimiento`),
  ADD KEY `FKidInsumos` (`fk_insumos`);

--
-- Indexes for table `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `petitorio`
--
ALTER TABLE `petitorio`
  ADD PRIMARY KEY (`idpetitorio`) USING BTREE;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `almacen`
--
ALTER TABLE `almacen`
  MODIFY `idAlmacen` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `control_cebado`
--
ALTER TABLE `control_cebado`
  MODIFY `idControl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insumos`
--
ALTER TABLE `insumos`
  MODIFY `idInsumo` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `karness`
--
ALTER TABLE `karness`
  MODIFY `idKarness` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movimiento_almacen`
--
ALTER TABLE `movimiento_almacen`
  MODIFY `idMovimiento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petitorio`
--
ALTER TABLE `petitorio`
  MODIFY `idpetitorio` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `idInsumo` FOREIGN KEY (`idAlmacen`) REFERENCES `insumos` (`idInsumo`);

--
-- Constraints for table `control_cebado`
--
ALTER TABLE `control_cebado`
  ADD CONSTRAINT `fk_insumos` FOREIGN KEY (`fk_insumos`) REFERENCES `insumos` (`idInsumo`);

--
-- Constraints for table `insumos`
--
ALTER TABLE `insumos`
  ADD CONSTRAINT `FKidKarness` FOREIGN KEY (`idKarness`) REFERENCES `karness` (`idKarness`);

--
-- Constraints for table `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_insumo` FOREIGN KEY (`idInsumo`) REFERENCES `insumos` (`idInsumo`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movimiento_almacen`
--
ALTER TABLE `movimiento_almacen`
  ADD CONSTRAINT `FKidInsumos` FOREIGN KEY (`fk_insumos`) REFERENCES `insumos` (`idInsumo`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
