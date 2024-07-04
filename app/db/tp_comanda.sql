-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2024 a las 07:07:34
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
(4, 'cliente pagando'),
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
(61, 'Negroni', 3000, 2);

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
(4, '2', '654ss'),
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
(132, 2, 1, 0, 'PZWTJ', '0000-00-00'),
(133, 5, 1, 0, 'uv5H9', '0000-00-00'),
(134, 3, 1, 0, '0ayXs', '0000-00-00'),
(135, 2, 1, 0, 'Wc4pH', '0000-00-00'),
(136, 2, 1, 0, 'N0wxA', '0000-00-00'),
(137, 5, 1, 0, '5v5jM', '0000-00-00'),
(138, 4, 1, 0, 'Azziy', '0000-00-00'),
(139, 5, 1, 0, 'HA251', '0000-00-00'),
(140, 3, 1, 0, 'YHacw', '0000-00-00'),
(141, 3, 1, 0, 'CbFQB', '0000-00-00'),
(142, 5, 1, 0, 'X0V3C', '0000-00-00'),
(143, 3, 1, 0, 'UvfYy', '0000-00-00'),
(144, 4, 1, 0, 'pfL9B', '0000-00-00'),
(145, 5, 1, 0, 'IfNgj', '0000-00-00'),
(146, 5, 1, 0, 'VXYkf', '0000-00-00'),
(147, 2, 1, 0, 'DgYsZ', '0000-00-00'),
(148, 4, 1, 0, '1o7qy', '0000-00-00'),
(149, 4, 1, 0, 'h5VEW', '0000-00-00'),
(150, 3, 1, 0, 'Bwukg', '0000-00-00'),
(151, 2, 1, 0, 'uDRiw', '0000-00-00'),
(152, 3, 1, 0, 'qI7YW', '0000-00-00'),
(153, 2, 1, 0, 'hHDhG', '0000-00-00'),
(154, 5, 1, 0, 'T6diD', '0000-00-00'),
(155, 2, 1, 0, 'hyfPa', '0000-00-00'),
(156, 5, 1, 0, 'Qsky4', '0000-00-00'),
(157, 3, 1, 0, 'lQVah', '0000-00-00'),
(158, 2, 1, 0, 'ZbnkT', '0000-00-00'),
(159, 4, 1, 0, '83FuG', '0000-00-00'),
(160, 4, 1, 0, 'rcnFg', '0000-00-00'),
(161, 3, 1, 0, 'fKanH', '0000-00-00'),
(162, 4, 1, 0, 'ksKVx', '0000-00-00'),
(163, 3, 1, 0, 'm4VsC', '0000-00-00'),
(164, 5, 1, 0, '6OWV3', '0000-00-00'),
(165, 2, 1, 0, 'W0R3Y', '0000-00-00'),
(166, 4, 1, 0, 'Di89L', '0000-00-00'),
(167, 5, 1, 0, 'KbTjF', '0000-00-00'),
(168, 4, 1, 0, 'PiheA', '0000-00-00'),
(169, 2, 1, 0, 'I2GhX', '0000-00-00'),
(170, 3, 1, 0, 'OWNmy', '0000-00-00'),
(171, 4, 1, 0, 'SN5gl', '0000-00-00'),
(172, 4, 1, 0, 'TMDWN', '0000-00-00'),
(173, 4, 1, 0, 'v4a5j', '0000-00-00'),
(174, 5, 1, 0, 'PZeer', '0000-00-00'),
(175, 3, 1, 0, 'gSg3j', '0000-00-00'),
(176, 2, 1, 0, 'QU9ky', '0000-00-00'),
(177, 4, 1, 0, 'uGMbc', '0000-00-00'),
(178, 5, 1, 0, 'MfB1Q', '0000-00-00'),
(179, 3, 1, 0, 'ORbMl', '0000-00-00'),
(180, 5, 1, 0, 'Lybwk', '0000-00-00'),
(181, 2, 1, 0, '6a0oT', '0000-00-00'),
(182, 3, 1, 0, 'sDAOS', '0000-00-00'),
(183, 4, 1, 0, 'P053Z', '0000-00-00'),
(184, 3, 1, 0, 'yNLNY', '0000-00-00'),
(185, 5, 1, 0, 'HhhO4', '0000-00-00'),
(186, 5, 1, 0, 'vvtQW', '0000-00-00'),
(187, 3, 1, 0, 'iAQGV', '0000-00-00'),
(188, 5, 1, 0, 'sQuen', '0000-00-00'),
(189, 4, 1, 0, 'ENDWy', '0000-00-00'),
(190, 3, 1, 0, 'imgD3', '0000-00-00'),
(191, 5, 1, 0, 'htrCk', '0000-00-00'),
(192, 3, 1, 0, 'rsX4u', '0000-00-00'),
(193, 2, 1, 0, 'dK43p', '0000-00-00'),
(194, 4, 1, 0, 'oRw6U', '0000-00-00'),
(195, 2, 1, 0, 'G9RWE', '0000-00-00'),
(196, 4, 1, 0, 'MRPeI', '0000-00-00'),
(197, 2, 1, 0, 'ZI1qD', '0000-00-00'),
(198, 2, 1, 0, 'FvQq5', '0000-00-00'),
(199, 3, 1, 0, 'kFlmK', '0000-00-00'),
(200, 5, 1, 0, '711OU', '0000-00-00'),
(201, 2, 1, 0, 'mMsiD', '0000-00-00'),
(202, 3, 1, 0, 'ZUZvF', '0000-00-00'),
(203, 4, 1, 0, 'g3EWg', '0000-00-00'),
(204, 5, 1, 0, '3VAw1', '0000-00-00'),
(205, 4, 1, 0, 'FtTEN', '0000-00-00'),
(206, 4, 1, 0, 'TcjTe', '0000-00-00'),
(207, 5, 1, 65, 'mR5Gg', '0000-00-00'),
(208, 2, 1, 65, 'jhD7O', '0000-00-00'),
(209, 2, 1, 65, 'uZ0fF', '0000-00-00'),
(210, 3, 1, 65, 'zY5Me', '0000-00-00'),
(211, 5, 1, 68, 'TuKiE', '0000-00-00'),
(212, 2, 1, 68, 'AKhY3', '0000-00-00'),
(213, 3, 1, 65, 'amyp6', '0000-00-00'),
(214, 4, 1, 68, '1rzvb', '0000-00-00'),
(215, 3, 1, 65, 'mWCAe', '0000-00-00'),
(216, 2, 1, 65, 'Ofzdu', '0000-00-00'),
(217, 4, 1, 65, 'RSGty', '0000-00-00'),
(218, 2, 1, 65, 'kNdPq', '0000-00-00'),
(219, 5, 1, 65, 'h27oZ', '0000-00-00'),
(220, 2, 1, 65, 'qUdDo', '0000-00-00'),
(221, 4, 1, 68, 'bKkGb', '0000-00-00'),
(222, 4, 1, 65, 'Tyk7x', '0000-00-00'),
(223, 2, 1, 65, 'OvGDy', '0000-00-00'),
(224, 2, 1, 68, 'IcAi8', '0000-00-00'),
(225, 3, 1, 65, 'b5bSm', '0000-00-00'),
(226, 4, 1, 68, 'pl2NF', '0000-00-00'),
(227, 3, 1, 65, 'fjs9o', '0000-00-00'),
(228, 4, 1, 68, 'iqzk4', '0000-00-00'),
(229, 4, 1, 65, 'a5Ekr', '0000-00-00'),
(230, 4, 1, 65, 'QftGL', '0000-00-00'),
(231, 4, 1, 65, 'gXrsP', '0000-00-00'),
(232, 2, 1, 65, 'PZWTJ', '0000-00-00'),
(233, 5, 1, 65, 'uv5H9', '0000-00-00'),
(234, 3, 1, 65, '0ayXs', '0000-00-00'),
(235, 2, 1, 65, 'Wc4pH', '0000-00-00'),
(236, 2, 1, 65, 'N0wxA', '0000-00-00'),
(237, 5, 1, 68, '5v5jM', '0000-00-00'),
(238, 4, 1, 68, 'Azziy', '0000-00-00'),
(239, 5, 1, 65, 'HA251', '0000-00-00'),
(240, 3, 1, 65, 'YHacw', '0000-00-00'),
(241, 3, 1, 65, 'CbFQB', '0000-00-00'),
(242, 5, 1, 65, 'X0V3C', '0000-00-00'),
(243, 3, 1, 65, 'UvfYy', '0000-00-00'),
(244, 4, 1, 65, 'pfL9B', '0000-00-00'),
(245, 5, 1, 65, 'IfNgj', '0000-00-00'),
(246, 5, 1, 68, 'VXYkf', '0000-00-00'),
(247, 2, 1, 65, 'DgYsZ', '0000-00-00'),
(248, 4, 1, 65, '1o7qy', '0000-00-00'),
(249, 4, 1, 65, 'h5VEW', '0000-00-00'),
(250, 3, 1, 65, 'Bwukg', '0000-00-00'),
(251, 2, 1, 65, 'uDRiw', '0000-00-00'),
(252, 3, 1, 65, 'qI7YW', '0000-00-00'),
(253, 2, 1, 65, 'hHDhG', '0000-00-00'),
(254, 5, 1, 68, 'T6diD', '0000-00-00'),
(255, 2, 1, 68, 'hyfPa', '0000-00-00'),
(256, 5, 1, 68, 'Qsky4', '0000-00-00'),
(257, 3, 1, 68, 'lQVah', '0000-00-00'),
(258, 2, 1, 65, 'ZbnkT', '0000-00-00'),
(259, 4, 1, 68, '83FuG', '0000-00-00'),
(260, 4, 1, 65, 'rcnFg', '0000-00-00'),
(261, 3, 1, 65, 'fKanH', '0000-00-00'),
(262, 4, 1, 68, 'ksKVx', '0000-00-00'),
(263, 3, 1, 68, 'm4VsC', '0000-00-00'),
(264, 5, 1, 65, '6OWV3', '0000-00-00'),
(265, 2, 1, 65, 'W0R3Y', '0000-00-00'),
(266, 4, 1, 68, 'Di89L', '0000-00-00'),
(267, 5, 1, 68, 'KbTjF', '0000-00-00'),
(268, 4, 1, 65, 'PiheA', '0000-00-00'),
(269, 2, 1, 65, 'I2GhX', '0000-00-00'),
(270, 3, 1, 68, 'OWNmy', '0000-00-00'),
(271, 4, 1, 65, 'SN5gl', '0000-00-00'),
(272, 4, 1, 65, 'TMDWN', '0000-00-00'),
(273, 4, 1, 65, 'v4a5j', '0000-00-00'),
(274, 5, 1, 68, 'PZeer', '0000-00-00'),
(275, 3, 1, 65, 'gSg3j', '0000-00-00'),
(276, 2, 1, 68, 'QU9ky', '0000-00-00'),
(277, 4, 1, 68, 'uGMbc', '0000-00-00'),
(278, 5, 1, 68, 'MfB1Q', '0000-00-00'),
(279, 3, 1, 65, 'ORbMl', '0000-00-00'),
(280, 5, 1, 68, 'Lybwk', '0000-00-00'),
(281, 2, 1, 65, '6a0oT', '0000-00-00'),
(282, 3, 1, 65, 'sDAOS', '0000-00-00'),
(283, 4, 1, 65, 'P053Z', '0000-00-00'),
(284, 3, 1, 68, 'yNLNY', '0000-00-00'),
(285, 5, 1, 68, 'HhhO4', '0000-00-00'),
(286, 5, 1, 65, 'vvtQW', '0000-00-00'),
(287, 3, 1, 68, 'iAQGV', '0000-00-00'),
(288, 5, 1, 65, 'sQuen', '0000-00-00'),
(289, 4, 1, 65, 'ENDWy', '0000-00-00'),
(290, 3, 1, 65, 'imgD3', '0000-00-00'),
(291, 5, 1, 68, 'htrCk', '0000-00-00'),
(292, 3, 1, 68, 'rsX4u', '0000-00-00'),
(293, 2, 1, 68, 'dK43p', '0000-00-00'),
(294, 4, 1, 65, 'oRw6U', '0000-00-00'),
(295, 2, 1, 65, 'G9RWE', '0000-00-00'),
(296, 4, 1, 65, 'MRPeI', '0000-00-00'),
(297, 2, 1, 68, 'ZI1qD', '0000-00-00'),
(298, 2, 1, 65, 'FvQq5', '0000-00-00'),
(299, 3, 1, 68, 'kFlmK', '0000-00-00'),
(300, 5, 1, 65, '711OU', '0000-00-00'),
(301, 2, 1, 65, 'mMsiD', '0000-00-00'),
(302, 3, 1, 68, 'ZUZvF', '0000-00-00'),
(303, 4, 1, 68, 'g3EWg', '0000-00-00'),
(304, 5, 1, 65, '3VAw1', '0000-00-00'),
(305, 4, 1, 68, 'FtTEN', '0000-00-00'),
(306, 4, 1, 68, 'TcjTe', '0000-00-00'),
(307, 4, 1, 65, 'd4f5s', '0000-00-00'),
(308, 4, 1, 65, 'd4f5s', '0000-00-00'),
(309, 4, 1, 65, 'd4f5s', '0000-00-00'),
(310, 4, 1, 65, 'd4f5s', '0000-00-00'),
(311, 4, 1, 65, 'd4f5s', '0000-00-00');

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
(7, 'admin');

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
(25, 2, 207, 1, 64, 0),
(26, 42, 207, 1, 65, 0),
(27, 43, 207, 1, 64, 0),
(28, 44, 207, 1, 0, 0),
(29, 45, 207, 1, 0, 0),
(30, 46, 207, 1, 0, 0);

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
(71, 'luis_perez', '$2y$10$2SOUxjEKZQS87iUBmAhkEuZhKPcYqT6O1cGnQi.2qPI6xc/FOaCru', 5, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productospedidos`
--
ALTER TABLE `productospedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
