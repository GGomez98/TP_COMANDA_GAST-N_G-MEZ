-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2024 a las 19:04:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp_comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(66) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `puntaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id`, `descripcion`, `idMesa`, `idPedido`, `puntaje`) VALUES
(2, 'Deliciosa comida y excelente servicio', 4, 312, 10),
(3, 'La comida esta muy cara y no era muy buena', 5, 207, 5),
(4, 'Comida aceptable', 2, 315, 7),
(5, 'La comida estaba estupenda y la atencion muy buena', 2, 316, 8),
(6, 'Buena comida a muy buen precio', 2, 317, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `codigoMesa` varchar(5) NOT NULL,
  `fechaIngreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadosmesa`
--

CREATE TABLE `estadosmesa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadosmesa`
--

INSERT INTO `estadosmesa` (`id`, `nombre`) VALUES
(1, 'cerrada'),
(2, 'cliente esperando pedido'),
(3, 'con cliente comiendo'),
(4, 'con cliente pagando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadospedido`
--

CREATE TABLE `estadospedido` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadospedido`
--

INSERT INTO `estadospedido` (`id`, `nombre`) VALUES
(1, 'realizado'),
(2, 'listo para preparar'),
(3, 'en preparacion'),
(4, 'listo para servir'),
(5, 'entregado'),
(6, 'cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `precio` float NOT NULL,
  `idSector` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `nombre`, `precio`, `idSector`) VALUES
(2, 'Milanesa', 3000, 3),
(3, 'Cerveza', 3000, 2),
(42, 'Pizza', 8901, 3),
(43, 'Hamburguesa', 1530, 3),
(44, 'Ensalada', 6923, 3),
(45, 'Sushi', 3528, 3),
(46, 'Taco', 7687, 3),
(47, 'Vino', 9881, 1),
(48, 'Refresco', 6669, 1),
(49, 'Agua', 2303, 1),
(50, 'Café', 4406, 4),
(51, 'Té', 6495, 4),
(52, 'Sandwich', 8100, 3),
(53, 'Pastel', 4107, 4),
(54, 'Helado', 3810, 4),
(55, 'Galletas', 3610, 4),
(56, 'Jugo de naranja', 9845, 3),
(57, 'Batido', 3436, 4),
(58, 'Frutas', 7378, 4),
(59, 'Pasta', 3991, 3),
(60, 'Sopa', 7171, 3),
(61, 'Negroni', 3000, 2),
(62, 'Milanesa a caballo', 5000, 3),
(63, 'Hamburguesa de Garbanzo', 3000, 3),
(64, 'Cerveza Corona', 1000, 2),
(65, 'Daikiri', 2000, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `idEstado` varchar(256) NOT NULL,
  `codigoMesa` varchar(5) NOT NULL,
  `cantidadUso` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `idEstado`, `codigoMesa`, `cantidadUso`) VALUES
(2, '1', '451as', 3),
(3, '1', '35f43', 0),
(4, '1', '654ss', 1),
(5, '1', '4s4da', 1),
(6, '1', 'Z6E9v', 0),
(7, '1', 'vP1PB', 0),
(8, '1', 'fvwUc', 0),
(9, '1', 'MTT47', 0),
(10, '1', 'sAXtl', 0),
(106, '1', 'abcde', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `idMozo` int(11) NOT NULL,
  `codigoPedido` varchar(5) NOT NULL,
  `precioFinal` float UNSIGNED DEFAULT NULL,
  `fechaCreacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `idMesa`, `idEstado`, `idMozo`, `codigoPedido`, `precioFinal`, `fechaCreacion`) VALUES
(207, 5, 5, 65, 'mR5Gg', 56928, '0000-00-00'),
(312, 4, 5, 65, 'sd45a', 14000, '0000-00-00'),
(315, 2, 5, 65, 'eb4h5', 14000, '2024-07-07'),
(316, 2, 5, 65, '5sd6d', 16000, '2024-07-08'),
(317, 2, 5, 65, 'l0u87', 14000, '2024-07-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id`, `nombre`) VALUES
(1, 'Socio'),
(2, 'Mozo'),
(3, 'cocinero'),
(4, 'bartender'),
(5, 'cervecero'),
(7, 'admin'),
(8, 'repostero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productospedidos`
--

CREATE TABLE `productospedidos` (
  `id` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `idUsuarioPreparacion` int(11) NOT NULL,
  `tiempoPreparacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productospedidos`
--

INSERT INTO `productospedidos` (`id`, `idProducto`, `idPedido`, `idEstado`, `idUsuarioPreparacion`, `tiempoPreparacion`) VALUES
(25, 2, 207, 5, 68, 20),
(26, 42, 207, 5, 68, 30),
(27, 43, 207, 5, 68, 30),
(28, 44, 207, 5, 68, 30),
(29, 45, 207, 5, 68, 30),
(30, 46, 207, 5, 68, 30),
(31, 47, 207, 5, 68, 30),
(32, 58, 207, 5, 68, 30),
(33, 52, 207, 5, 68, 30),
(34, 62, 312, 5, 67, 30),
(35, 63, 312, 5, 67, 30),
(36, 63, 312, 5, 67, 30),
(37, 64, 312, 5, 71, 5),
(38, 65, 312, 5, 71, 5),
(39, 62, 314, 1, 72, 0),
(40, 63, 314, 1, 72, 0),
(41, 63, 314, 1, 72, 0),
(42, 64, 314, 1, 72, 0),
(43, 65, 314, 1, 72, 0),
(44, 62, 315, 5, 66, 10),
(45, 63, 315, 5, 66, 10),
(46, 63, 315, 5, 66, 10),
(47, 64, 315, 5, 71, 10),
(48, 65, 315, 5, 71, 10),
(49, 62, 316, 5, 71, 5),
(50, 63, 316, 5, 71, 5),
(51, 63, 316, 5, 71, 5),
(52, 64, 316, 5, 71, 3),
(53, 65, 316, 5, 71, 3),
(54, 100, 316, 4, 71, 3),
(55, 65, 316, 5, 71, 3),
(56, 62, 317, 5, 66, 5),
(57, 63, 317, 5, 66, 5),
(58, 63, 317, 5, 66, 5),
(59, 64, 317, 5, 71, 5),
(60, 65, 317, 5, 71, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`id`, `nombre`) VALUES
(1, 'Barra'),
(2, 'Patio'),
(3, 'Cocina'),
(4, 'Candy Bar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(250) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `idPerfil` int(250) NOT NULL,
  `fechaBaja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `idPerfil`, `fechaBaja`) VALUES
(64, 'juan_perez', '$2y$10$QTpBhVjvSqdiAEFOQXPOKuw6KrRO5dFwFGx8E8UIZlPl1Q7fdqXUS', 1, NULL),
(65, 'maria_gomez', '$2y$10$2BQWa8xWSYWoh52sUkvg7eWQeSJjpBqBo5ZMI.yxI7paoOwTu26Vq', 2, NULL),
(66, 'carlos_lopez', '$2y$10$SrNKdc57zJnM.CNEpcN7xOXe7KhAhHAiTZyQ68oQC2ifLy6u5cD8m', 3, NULL),
(67, 'ana_martinez', '$2y$10$AzefSN7h3Q/N0h9YfrcrdukvyRM4IoC23pJlRtxTumj08.p2v4NHW', 4, NULL),
(68, 'luis_garcia', '$2y$10$NQVKCgtuB91D0e.83BdTkOoPnZUKKmIgi81Pcrb10RbEn55tK0D66', 2, NULL),
(69, 'Marcos', '$2y$10$.neNMIhTavT3iQRa8A/xO.x3WgUECrMNtHE.LNhEyIHTA8wdX/r9e', 7, NULL),
(70, 'Gastón', '$2y$10$lMaDQ.YcUUj7bt30AUZW0eWXUgIOG/XXTz2T9YK59clfsj7VG83bC', 7, NULL),
(71, 'luis_perez', '$2y$10$2SOUxjEKZQS87iUBmAhkEuZhKPcYqT6O1cGnQi.2qPI6xc/FOaCru', 5, NULL),
(72, 'No Asignado', '', 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadosmesa`
--
ALTER TABLE `estadosmesa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadospedido`
--
ALTER TABLE `estadospedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productospedidos`
--
ALTER TABLE `productospedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estadosmesa`
--
ALTER TABLE `estadosmesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `estadospedido`
--
ALTER TABLE `estadospedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productospedidos`
--
ALTER TABLE `productospedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
