-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2019 a las 01:49:52
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `traz-prod-trazasoft`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frm_formularios`
--

CREATE TABLE `frm_formularios` (
  `form_id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tst_plantillas`
--

CREATE TABLE `tst_plantillas` (
  `plan_id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `eliminado` tinyint(4) DEFAULT '0',
  `fec_alta` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tst_plantillas`
--

INSERT INTO `tst_plantillas` (`plan_id`, `nombre`, `descripcion`, `eliminado`, `fec_alta`, `usuario`) VALUES
(1, 'Plantilla 1', NULL, 0, '2019-05-13 19:30:22', NULL),
(2, 'Plantilla 2', NULL, 0, '2019-05-13 19:30:22', NULL),
(3, 'Plantilla 3', NULL, 0, '2019-05-13 19:30:22', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tst_recetas`
--

CREATE TABLE `tst_recetas` (
  `rece_id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tst_rel_tareas_plantillas`
--

CREATE TABLE `tst_rel_tareas_plantillas` (
  `plan_id` int(11) NOT NULL,
  `tare_id` int(11) NOT NULL,
  `eliminar` tinyint(4) DEFAULT '0',
  `fec_alta` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tst_rel_tareas_plantillas`
--

INSERT INTO `tst_rel_tareas_plantillas` (`plan_id`, `tare_id`, `eliminar`, `fec_alta`, `usuario`) VALUES
(1, 1, 0, '2019-05-13 19:23:17', NULL),
(1, 2, 0, '2019-05-13 19:23:17', NULL),
(1, 3, 0, '2019-05-13 19:23:17', NULL),
(2, 1, 0, '2019-05-13 19:23:17', NULL),
(2, 2, 0, '2019-05-13 19:23:17', NULL),
(3, 1, 0, '2019-05-13 19:23:17', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tst_subtareas`
--

CREATE TABLE `tst_subtareas` (
  `suta_id` int(11) NOT NULL,
  `tare_id` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `duracion_std` varchar(45) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `empr_id` int(11) DEFAULT NULL,
  `eliminado` tinyint(4) DEFAULT '0',
  `fec_alta` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tst_subtareas`
--

INSERT INTO `tst_subtareas` (`suta_id`, `tare_id`, `nombre`, `descripcion`, `duracion_std`, `form_id`, `empr_id`, `eliminado`, `fec_alta`, `usuario`) VALUES
(1, '1', 'Sub 1', 'Descripcion 1', '1', 1, 1, 0, '2019-05-13 18:05:27', NULL),
(2, '1', 'Sub 2', 'Descripcion 2', '2', 2, 2, 0, '2019-05-13 18:05:27', NULL),
(3, '1', 'Sub 3', 'Descripcion 3', '3', 3, 3, 0, '2019-05-13 18:05:27', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tst_tareas`
--

CREATE TABLE `tst_tareas` (
  `tare_id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `duracion_std` varchar(45) DEFAULT NULL,
  `rece_id` varchar(45) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `empr_id` int(11) DEFAULT NULL,
  `eliminado` tinyint(4) DEFAULT '0',
  `fec_alta` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario` varchar(30) DEFAULT 'CURRENT_USER()'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tst_tareas`
--

INSERT INTO `tst_tareas` (`tare_id`, `nombre`, `descripcion`, `duracion_std`, `rece_id`, `form_id`, `empr_id`, `eliminado`, `fec_alta`, `usuario`) VALUES
(1, 'Tarea 1', 'Descripcion 1', '10', '1', 1, 1, 0, '2019-05-13 13:32:04', 'CURRENT_USER()'),
(2, 'Tarea 2', 'Descripcion 2', '20', '2', 2, 2, 0, '2019-05-13 13:32:04', 'CURRENT_USER()'),
(3, 'Tarea 3', 'Descripcion 3', '30', '3', 3, 3, 0, '2019-05-13 13:32:04', 'CURRENT_USER()');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `frm_formularios`
--
ALTER TABLE `frm_formularios`
  ADD PRIMARY KEY (`form_id`);

--
-- Indices de la tabla `tst_plantillas`
--
ALTER TABLE `tst_plantillas`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indices de la tabla `tst_recetas`
--
ALTER TABLE `tst_recetas`
  ADD PRIMARY KEY (`rece_id`);

--
-- Indices de la tabla `tst_rel_tareas_plantillas`
--
ALTER TABLE `tst_rel_tareas_plantillas`
  ADD PRIMARY KEY (`plan_id`,`tare_id`);

--
-- Indices de la tabla `tst_subtareas`
--
ALTER TABLE `tst_subtareas`
  ADD PRIMARY KEY (`suta_id`);

--
-- Indices de la tabla `tst_tareas`
--
ALTER TABLE `tst_tareas`
  ADD PRIMARY KEY (`tare_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tst_plantillas`
--
ALTER TABLE `tst_plantillas`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tst_recetas`
--
ALTER TABLE `tst_recetas`
  MODIFY `rece_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tst_subtareas`
--
ALTER TABLE `tst_subtareas`
  MODIFY `suta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tst_tareas`
--
ALTER TABLE `tst_tareas`
  MODIFY `tare_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
