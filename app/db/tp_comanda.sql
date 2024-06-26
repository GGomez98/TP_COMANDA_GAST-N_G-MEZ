-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2024 a las 19:54:09
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
  `puntajeRestaurante` int(11) NOT NULL,
  `puntajeMesa` int(11) NOT NULL,
  `puntajeCocinero` int(11) NOT NULL,
  `puntajeMozo` int(11) NOT NULL,
  `descripcion` varchar(66) NOT NULL,
  `idMozo` int(11) NOT NULL,
  `idCocinero` int(11) NOT NULL,
  `idMesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'cliente comiendo'),
(4, 'cliente pagando');

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
(1, 'Agua', 1000, 0),
(2, 'Milanesa', 3000, 3),
(3, 'Cerveza', 3000, 2),
(4, 'Pizza', 8901, 0),
(5, 'Hamburguesa', 1530, 0),
(6, 'Ensalada', 6923, 0),
(7, 'Sushi', 3528, 0),
(8, 'Taco', 7687, 0),
(9, 'Vino', 9881, 0),
(10, 'Refresco', 6669, 0),
(11, 'Agua', 2303, 0),
(12, 'Café', 4406, 0),
(13, 'Té', 6495, 0),
(14, 'Sandwich', 8100, 0),
(15, 'Pastel', 4107, 0),
(16, 'Helado', 3810, 0),
(17, 'Galletas', 3610, 0),
(18, 'Jugo de naranja', 9845, 0),
(19, 'Batido', 3436, 0),
(20, 'Frutas', 7378, 0),
(21, 'Pasta', 3991, 0),
(22, 'Sopa', 7171, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `idEstado` varchar(256) NOT NULL,
  `codigoMesa` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `idEstado`, `codigoMesa`) VALUES
(2, '1', '451as'),
(3, '1', '35f43'),
(4, '1', '654ss'),
(5, '1', '4s4da'),
(6, '1', 'Z6E9v'),
(7, '1', 'vP1PB'),
(8, '1', 'fvwUc'),
(9, '1', 'MTT47'),
(10, '1', 'sAXtl');

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
  `fechaCreacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `idMesa`, `idEstado`, `idMozo`, `codigoPedido`, `fechaCreacion`) VALUES
(1, 2, 1, 3, 's55d6', '0000-00-00'),
(2, 2, 5, 2, '342df', '0000-00-00'),
(3, 4, 1, 2, 's5d4s', '0000-00-00'),
(4, 4, 1, 2, '5d6sd', '0000-00-00'),
(5, 4, 1, 2, 'sd5er', '0000-00-00'),
(6, 5, 1, 2, 'mR5Gg', '0000-00-00'),
(7, 2, 1, 2, 'jhD7O', '0000-00-00'),
(8, 2, 1, 11, 'uZ0fF', '0000-00-00'),
(9, 3, 1, 11, 'zY5Me', '0000-00-00');

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
(5, 'cervecero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productospedidos`
--

CREATE TABLE `productospedidos` (
  `id` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productospedidos`
--

INSERT INTO `productospedidos` (`id`, `idProducto`, `idPedido`) VALUES
(3, 1, 1),
(4, 3, 2),
(5, 2, 2),
(6, 2, 2),
(7, 2, 2),
(8, 2, 3),
(12, 2, 3),
(13, 2, 3);

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
(2, 'pedro', 'dasdqsdw2sd23', 2, NULL),
(3, 'jorge', 'sda2s2f332f2', 3, NULL),
(4, 'cesar', '$2y$10$yGxD1Z.HFXXIX4AmcwLN5uJ7kvaF6l7z2eZ05Cm05wFe0UreGAzsm', 4, NULL),
(5, 'alberto', '$2y$10$JGyJ1BbKmLGcaTIl2KkQguPNNm7YRVHzvtSCh8NYerGhc3nIIXECK', 2, NULL),
(6, 'santiago', '$2y$10$XImH1gZjHgAZcE4dJNoZnuLfAqO2QwiXBrF6YEf.z3ZhEeb8yzE5e', 3, NULL),
(9, 'carlos', '$2y$10$SEnQAoTCUcsL8M4a.I2r9uIBH0Xdzx0hSHmC7/bW4gcm8zxRk5XQq', 5, NULL),
(10, 'abel', '$2y$10$fO7/cipDqASxp/4bKRabg.s0T5/N1BXz2UqnEIAgvZ5zMPmg8WEFK', 1, NULL),
(11, 'Luciano', '$2y$10$VWeAjrLtLEoJZ7yGAzseOOlRkMFyBXCNpcgVLZPB8NFEORIJqn8eK', 2, NULL),
(13, 'Marcos', '$2y$10$1P9TyjGkVIdASMoyB3b7SOyCNVDj6HcZu1Lv12PTF38muLcvYctuG', 3, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estadospedido`
--
ALTER TABLE `estadospedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productospedidos`
--
ALTER TABLE `productospedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
