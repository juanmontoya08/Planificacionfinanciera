-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-07-2018 a las 15:12:56
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `impresiones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invento_items`
--

CREATE TABLE `invento_items` (
  `id` int(11) NOT NULL,
  `archivo` varchar(100) NOT NULL,
  `usuario` int(11) NOT NULL,
  `caras` int(1) NOT NULL,
  `tipo` int(1) NOT NULL,
  `desde` int(6) NOT NULL,
  `hasta` int(6) NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `date_added` datetime DEFAULT '0000-00-00 00:00:00',
  `id_proyect` int(11) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invento_proyect`
--

CREATE TABLE `invento_proyect` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `invento_proyect`
--

INSERT INTO `invento_proyect` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Sin Proyecto', 'Sin proyecto'),
(2, 'MADR-CISP', 'PROYECTO MADR-CISP'),
(3, 'ANT-CISP', 'PROYECTO ANT-CISP'),
(4, 'ESTRUCTURA-CISP', 'PROYECTO ESTRUCTURA'),
(5, 'PUEDES-CISP', 'PROYECTO PUEDES-CISP'),
(6, 'ESAP-CISP', 'PROYECTO ESAP-CISP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invento_settings`
--

CREATE TABLE `invento_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `val` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `invento_settings`
--

INSERT INTO `invento_settings` (`id`, `name`, `val`) VALUES
(1, 'site_title', 'Invento - %page%'),
(2, 'site_logo', 'media/img/logo3x.png'),
(3, 'allow_userchange', 'y'),
(4, 'allow_namechange', 'n'),
(5, 'allow_emailchange', 'n'),
(6, 'installed', 'n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invento_users`
--

CREATE TABLE `invento_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  `name` varchar(300) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(1) NOT NULL,
  `date_added` date DEFAULT '0000-00-00',
  `proyect` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `invento_users`
--

INSERT INTO `invento_users` (`id`, `username`, `password`, `name`, `email`, `role`, `date_added`, `proyect`) VALUES
(1, 'admin', '2531da937505f99df100a99240e0e38a', 'Admin', 'miilomontoya87@gmail.com', 1, '2017-04-01', 1),
(2, 'prueba', '2531da937505f99df100a99240e0e38a', 'prueba', 'jcospina@cispcolombia.org', 4, '2018-07-16', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `invento_items`
--
ALTER TABLE `invento_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `invento_proyect`
--
ALTER TABLE `invento_proyect`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `invento_settings`
--
ALTER TABLE `invento_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `invento_users`
--
ALTER TABLE `invento_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `invento_items`
--
ALTER TABLE `invento_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invento_proyect`
--
ALTER TABLE `invento_proyect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `invento_settings`
--
ALTER TABLE `invento_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `invento_users`
--
ALTER TABLE `invento_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
