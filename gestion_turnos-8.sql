-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-11-2024 a las 22:14:50
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_turnos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `telefono`, `email`, `foto`) VALUES
(2, 'Juan García', '987654321', 'juan@mail.com', NULL),
(23, 'jjaass', '232322', 'ajnsajnasj@ansjsns.com', NULL),
(44, 'jaj', '1122', 'ajaj@jaja.com', 'uploads/_DSC5415.jpg'),
(63, 'anasnas', '1212', 'jansjnas@jnansjas.com', NULL),
(67, 'anasnas', '1212', 'jansjnas@jnansjas.com', NULL),
(233, 'jjaass', '232322', 'ajnsajnasj@ansjsns.com', NULL),
(321, 'juanchi', '12222', '122@jaja.com', 'uploads/marian2.jpeg'),
(322, 'asasasa', '322323', '1212asbasj@jhashjsa.com', 'uploads/m4.jpeg'),
(323, 'ajhassa', '27263623732', 'jhsajahsj@jahjsa.com', 'uploads/m1.jpeg'),
(324, 'Juan García', '987654321', 'juan@mail.com', NULL),
(325, 'Juan García', '987654321', 'juan@mail.com', NULL),
(326, 'jjaass', '232322', 'ajnsajnasj@ansjsns.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id_turno` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha_turno` date DEFAULT NULL,
  `hora_turno` time DEFAULT NULL,
  `finalizado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id_turno`, `id_cliente`, `fecha_turno`, `hora_turno`, `finalizado`) VALUES
(55, 44, '2024-10-02', '11:11:00', 0),
(56, 44, '2024-03-01', '10:00:00', 0),
(63, 44, '2024-03-01', '10:00:00', 0),
(66, 44, '2024-03-01', '11:00:00', 0),
(67, 44, '2024-03-01', '12:00:00', 0),
(69, 44, '2024-07-01', '10:11:00', 0),
(70, 2, '2024-11-14', '11:11:00', 0),
(71, 63, '2024-11-08', '03:03:00', 0),
(72, 44, '2024-03-01', '13:00:00', 0),
(73, 44, '2024-03-01', '10:00:00', 0),
(74, 44, '2024-03-01', '10:00:00', 0),
(75, 44, '2024-03-01', '10:00:00', 0),
(76, 44, '2024-03-01', '10:00:00', 0),
(77, 44, '2024-03-01', '10:00:00', 0),
(78, 44, '2024-03-01', '10:00:00', 0),
(79, 2, '2024-12-12', '12:12:12', 0),
(80, 2, '2024-12-12', '12:12:12', 0),
(81, 44, '2024-12-12', '12:12:12', 0),
(84, 2, '2022-12-12', '12:13:13', 0),
(86, 44, '2019-12-13', '12:13:11', 0),
(87, 44, '2012-12-12', '12:12:12', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`) VALUES
(1, 'webadmin', '$2y$10$Xxy87ae1/GhzUWqfX6FanOPneJlBr/Lk306/1fPCd7h.9O1AHi3ey'),
(2, 'inaki@hola.com', '$2y$10$ChL0oFh99tZDrEnJgRLGCe4lMrG3Od.Vna4XOFamuSzyd7dbWxey6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`id_turno`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id_turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD CONSTRAINT `turnos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
