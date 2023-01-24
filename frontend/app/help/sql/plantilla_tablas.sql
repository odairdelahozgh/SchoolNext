-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2022 a las 21:53:45
-- Versión del servidor: 5.7.17
-- Versión de PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: iglesia_linaje
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla plantilla
--

DROP TABLE IF EXISTS snxt_plantilla;
CREATE TABLE snxt_plantilla (
  id bigint(20) NOT NULL,
  nombre varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  uuid varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  is_active tinyint(1) NOT NULL DEFAULT '1',
  orden bigint(20) DEFAULT NULL,
  created_at datetime DEFAULT CURRENT_TIMESTAMP,
  created_by bigint(20) DEFAULT NULL,
  updated_at datetime DEFAULT CURRENT_TIMESTAMP,
  updated_by bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--
INSERT INTO snxt_plantilla (id, nombre, uuid, is_active, orden, created_at, updated_at, created_by, updated_by) VALUES
(1, 'nombre 1', NULL, 1, 1, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1),
(2, 'nombre 2', NULL, 0, 2, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1),
(3, 'nombre 3', NULL, 1, 3, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1),
(4, 'nombre 4', NULL, 0, 4, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1),
(5, 'nombre 5', NULL, 1, 5, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1);


--
-- Indices de la tabla plantilla
--
ALTER TABLE snxt_plantilla
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY uuid_idx (uuid);

--
-- AUTO_INCREMENT de la tabla plantilla
--
ALTER TABLE snxt_plantilla
  MODIFY id bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
