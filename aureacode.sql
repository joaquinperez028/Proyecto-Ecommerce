-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2024 a las 17:02:50
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
-- Base de datos: `aureacode`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `preguntaSeguridad` varchar(100) DEFAULT NULL,
  `respuestaSeguridad` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`ID`, `nombre`, `password`, `rol`, `preguntaSeguridad`, `respuestaSeguridad`, `email`, `id_usuario`) VALUES
(1, 'superAdmin', '$2y$10$L5AX7nSWT2bBa//MrsP0k.sdMFwb5VOhB3jv/3mBOPAYEhrHlIvwu', 'superAdmin', 'Nombre de tu primer mascota', 'Patroclo', 'superAdmin@aureacode.com', 1),
(30, 'Admin', '$2y$10$3UAheVaL5QRUwxO1GZMH8.TsIBMQ9EjXzWCfWfg0kUMEJrvJnWApa', 'Admin', 'Dibujo animado favorito', 'Admin', 'admin@aureacode.com', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `ID_Carrito` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`ID_Carrito`, `estado`, `fecha_creacion`, `ID_Usuario`) VALUES
(33, 'Terminado', '2024-11-01', 1),
(34, 'Terminado', '2024-11-13', 1),
(35, 'Terminado', '2024-11-13', 1),
(36, 'Terminado', '2024-11-14', 8),
(37, 'Terminado', '2024-11-14', 8),
(38, 'activo', '2024-11-14', 7),
(39, 'Terminado', '2024-11-14', 8),
(40, 'activo', '2024-11-14', 8),
(41, 'Terminado', '2024-11-14', 1),
(44, 'Terminado', '2024-11-14', 1),
(45, 'Terminado', '2024-11-14', 1),
(46, 'Terminado', '2024-11-14', 1),
(48, 'activo', '2024-11-14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_Categoria` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_Categoria`, `Nombre`) VALUES
(23, 'Conjuntos'),
(24, 'Boddy'),
(26, 'Remera'),
(27, 'Buzo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `preguntaSeguridad` varchar(100) DEFAULT NULL,
  `respuestaSeguridad` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID`, `nombre`, `password`, `rol`, `preguntaSeguridad`, `respuestaSeguridad`, `email`) VALUES
(1, 'superAdmin', '$2y$10$L5AX7nSWT2bBa//MrsP0k.sdMFwb5VOhB3jv/3mBOPAYEhrHlIvwu', 'superAdmin', 'Nombre de tu primer mascota', 'superAdmin', 'superAdmin@aureacode.com'),
(7, 'Admin', '$2y$10$3UAheVaL5QRUwxO1GZMH8.TsIBMQ9EjXzWCfWfg0kUMEJrvJnWApa', 'Admin', 'Dibujo animado favorito', 'Admin', 'admin@aureacode.com'),
(8, 'Cliente', '$2y$10$xkCpy53tykP5tle0fOlPxOiN5Agwd8sB3BrQxSU4LpI7er8M1TdzS', 'Cliente', 'Lugar donde cursaste primaria', 'cliente', 'cliente@aureacode.com'),
(9, 'Tortu', '$2y$10$UNm9DS184pICW3Vk4m45bu6b2lvd487VuvK51Ut.kkvgMHZsuDuMO', 'Cliente', 'Dibujo animado favorito', 'HxH', 'tortugaalpan@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenproducto`
--

CREATE TABLE `imagenproducto` (
  `id_imagen` int(11) NOT NULL,
  `ruta_imagen` varchar(255) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenproducto`
--

INSERT INTO `imagenproducto` (`id_imagen`, `ruta_imagen`, `producto_id`) VALUES
(72, 'assets/imagenes/conjunto-rosa2.JPG', 60),
(73, 'assets/imagenes/conjunto-rosa1.JPG', 60),
(74, 'assets/imagenes/buzo-gris2.JPG', 61),
(75, 'assets/imagenes/buzo-gris1.JPG', 61),
(76, 'assets/imagenes/boddy-negro.JPG', 62),
(77, 'assets/imagenes/buzo-negro.JPG', 63),
(78, 'assets/imagenes/remeraBasica2.JPG', 64),
(79, 'assets/imagenes/remeraBasica1.JPG', 64),
(80, 'assets/imagenes/ConjuntoNegro2.JPG', 65);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordencompra`
--

CREATE TABLE `ordencompra` (
  `ID_Orden` int(11) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `apellido` varchar(40) DEFAULT NULL,
  `cedula` int(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `departamento` varchar(40) DEFAULT NULL,
  `ciudad` varchar(40) DEFAULT NULL,
  `dir_envio` varchar(50) DEFAULT NULL,
  `telefono` int(10) DEFAULT NULL,
  `tipo_pago` varchar(30) DEFAULT NULL,
  `tipo_envio` varchar(30) DEFAULT NULL,
  `fecha` date DEFAULT curdate(),
  `ID_Pedido` int(11) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordencompra`
--

INSERT INTO `ordencompra` (`ID_Orden`, `nombre`, `apellido`, `cedula`, `email`, `departamento`, `ciudad`, `dir_envio`, `telefono`, `tipo_pago`, `tipo_envio`, `fecha`, `ID_Pedido`, `ID_Usuario`) VALUES
(9, 'Cliente', 'Prueba', 12345678, 'superAdmin@aureacode.com', 'Colonia', 'Juan Lacaze', 'Utu Juan Lacaze', 123456789, 'Transferencia', 'EnvioDac', '2024-11-13', 27, 1),
(10, 'Cliente', 'Prueba', 12345678, 'superAdmin@aureacode.com', 'Artigas', 'Juan Lacaze', 'Utu Juan Lacaze', 123456789, 'Transferencia', 'EnvioDac', '2024-11-13', 28, 1),
(11, 'Matias', 'Gutierrez', 12345678, 'cliente@aureacode.com', 'Colonia', 'Juan Lacaze', 'Utu', 92325635, 'Transferencia', 'RetiroEnLocal', '2024-11-14', 29, 8),
(12, 'Pablo', 'Piriz', 12345678, 'cliente@aureacode.com', 'Colonia', 'Rosario', 'Siempre viva 12', 123456789, 'Transferencia', 'EnvioDac', '2024-11-14', 30, 8),
(13, 'Prueba', 'Prueba', 12345678, 'cliente@aureacode.com', 'Colonia', 'Prueb', 'Prueba', 123456778, 'Transferencia', 'EnvioDac', '2024-11-14', 31, 8),
(14, 'prueb', 'prueba', 2147483647, 'superAdmin@aureacode.com', 'Colonia', 'asdasd', 'asdas', 123123123, 'Transferencia', 'EnvioDac', '2024-11-14', 32, 1),
(15, 'Pau', 'Lopez', 46854, 'superAdmin@aureacode.com', 'Colonia', 'JLL', 'no se', 99765654, 'Transferencia', 'RetiroEnLocal', '2024-11-14', 33, 1),
(16, 'pepito', 'gimenez', 65387967, 'superAdmin@aureacode.com', 'Colonia', 'juan lacaze', 'rivera', 98346753, 'PagoLocal', 'RetiroEnLocal', '2024-11-14', 36, 1),
(17, 'Joaquín', 'Sosa', 56929802, 'superAdmin@aureacode.com', 'Colonia', 'Juan Lacaze', 'CO VI FAB SAB', 92024626, 'PagoLocal', 'RetiroEnLocal', '2024-11-14', 37, 1),
(18, 'prueba', 'prueba', 123124914, 'superAdmin@aureacode.com', 'Colonia', 'asdas', 'asdas', 123532142, 'Transferencia', 'EnvioDac', '2024-11-14', 38, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ID_Pedido` int(11) NOT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `Total` decimal(10,0) DEFAULT NULL,
  `procesado` tinyint(1) DEFAULT 0,
  `ID_Carrito` int(11) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`ID_Pedido`, `estado`, `Total`, `procesado`, `ID_Carrito`, `ID_Usuario`) VALUES
(27, 'Completado', 2000, 1, 33, 1),
(28, 'Completado', 800, 1, 34, 1),
(29, 'Completado', 1990, 1, 36, 8),
(30, 'Completado', 1990, 1, 37, 8),
(31, 'Completado', 14980, 1, 39, 8),
(32, 'Completado', 3990, 1, 35, 1),
(33, 'Completado', 3990, 1, 41, 1),
(36, 'Completado', 800, 1, 44, 1),
(37, 'Completado', 1900, 1, 45, 1),
(38, 'Procesando Pago', 2000, 0, 46, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_Producto` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `tipoStock` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `Precio` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(200) DEFAULT NULL,
  `ID_Administrador` int(11) DEFAULT NULL,
  `ID_Categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_Producto`, `Nombre`, `tipoStock`, `estado`, `Color`, `Precio`, `Descripcion`, `ID_Administrador`, `ID_Categoria`) VALUES
(60, 'Conjunto Rosado ', 'produccion', 'En produccion', 'rosa', '2000', 'Conjunto rosado \r\n80% algodón \r\n20% poliéster\r\nIdeal para actividad física', 1, 23),
(61, 'Buzo gris', 'fisico', 'Stock controlado', 'gris', '1300', 'Buzo gris corte Oversize 90% algodón 10% Poliéster	', 1, 27),
(62, 'Boddy Negro', 'fisico', 'Stock controlado', 'negro', '1990', 'Boddy negro ajustado al cuerpo\r\n90% algodón\r\n10% poliéster', 1, 24),
(63, 'Buzo negro', 'produccion', 'En produccion', 'negro', '1800', 'Buzo negro clasico\r\n80% Algodón\r\n20% Poliéster', 1, 27),
(64, 'Remera basica', 'produccion', 'En produccion', 'rojo,azul,negro,blanco', '800', 'Remera basica corte clasico\r\n90% Algodón\r\n10% Poliéster', 1, 26),
(65, 'Buzo Negro', 'produccion', 'En produccion', 'negro', '1900', 'Buzo negro, street style.', 1, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ranking`
--

CREATE TABLE `ranking` (
  `ID_Producto` int(11) NOT NULL,
  `veces_vendido` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ranking`
--

INSERT INTO `ranking` (`ID_Producto`, `veces_vendido`) VALUES
(60, 4),
(62, 6),
(63, 5),
(64, 2),
(65, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `ID_Stock` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `Talle` varchar(10) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`ID_Stock`, `producto_id`, `Talle`, `Cantidad`) VALUES
(25, 60, 'S', NULL),
(26, 60, 'M', NULL),
(27, 60, 'L', NULL),
(28, 61, 'L', 12),
(29, 61, 'XL', 15),
(30, 62, 'XS', 10),
(31, 62, 'S', 10),
(32, 62, 'M', 10),
(33, 62, 'L', 6),
(34, 62, 'XL', 8),
(35, 63, 'M', NULL),
(36, 63, 'L', NULL),
(37, 64, 'S', NULL),
(38, 64, 'M', NULL),
(39, 64, 'L', NULL),
(40, 64, 'XL', NULL),
(41, 65, 'M', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unioncarritoproducto`
--

CREATE TABLE `unioncarritoproducto` (
  `ID_unionCarritoProducto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `color` varchar(25) DEFAULT NULL,
  `talle` varchar(25) DEFAULT NULL,
  `precioUnitario` decimal(10,0) DEFAULT NULL,
  `ID_Carrito` int(11) DEFAULT NULL,
  `ID_Productos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unioncarritoproducto`
--

INSERT INTO `unioncarritoproducto` (`ID_unionCarritoProducto`, `cantidad`, `color`, `talle`, `precioUnitario`, `ID_Carrito`, `ID_Productos`) VALUES
(48, 1, 'rosa', 'L', 2000, 33, 60),
(49, 1, 'rojo', 'L', 800, 34, 64),
(50, 1, 'negro', 'L', 1990, 36, 62),
(51, 1, 'negro', 'L', 1990, 37, 62),
(52, 2, 'negro', 'XL', 1990, 39, 62),
(53, 5, 'negro', 'M', 1800, 39, 63),
(54, 1, 'rosa', 'L', 2000, 39, 60),
(55, 1, 'rosa', 'L', 2000, 35, 60),
(56, 1, 'negro', 'L', 1990, 35, 62),
(57, 1, 'rosa', 'L', 2000, 41, 60),
(58, 1, 'negro', 'L', 1990, 41, 62),
(62, 1, 'rojo', 'L', 800, 44, 64),
(63, 1, 'negro', 'M', 1900, 45, 65),
(64, 1, 'rosa', 'M', 2000, 46, 60);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuario` (`id_usuario`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`ID_Carrito`),
  ADD KEY `fk_id_usuario` (`ID_Usuario`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- Indices de la tabla `imagenproducto`
--
ALTER TABLE `imagenproducto`
  ADD PRIMARY KEY (`id_imagen`) USING BTREE,
  ADD KEY `fkprod` (`producto_id`);

--
-- Indices de la tabla `ordencompra`
--
ALTER TABLE `ordencompra`
  ADD PRIMARY KEY (`ID_Orden`),
  ADD KEY `fk_pedido` (`ID_Pedido`),
  ADD KEY `fkUsuario` (`ID_Usuario`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ID_Pedido`),
  ADD KEY `fk_idusu` (`ID_Usuario`),
  ADD KEY `fk_idcarro` (`ID_Carrito`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `ID_Administrador` (`ID_Administrador`),
  ADD KEY `producto_ibfk_2` (`ID_Categoria`);

--
-- Indices de la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD UNIQUE KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ID_Stock`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `unioncarritoproducto`
--
ALTER TABLE `unioncarritoproducto`
  ADD PRIMARY KEY (`ID_unionCarritoProducto`),
  ADD KEY `fk_id_carrito` (`ID_Carrito`),
  ADD KEY `fk_id_producto` (`ID_Productos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `ID_Carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `imagenproducto`
--
ALTER TABLE `imagenproducto`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `ordencompra`
--
ALTER TABLE `ordencompra`
  MODIFY `ID_Orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID_Pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `ID_Stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `unioncarritoproducto`
--
ALTER TABLE `unioncarritoproducto`
  MODIFY `ID_unionCarritoProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `clientes` (`ID`);

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_id_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `clientes` (`ID`);

--
-- Filtros para la tabla `imagenproducto`
--
ALTER TABLE `imagenproducto`
  ADD CONSTRAINT `fkprod` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`ID_Producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ordencompra`
--
ALTER TABLE `ordencompra`
  ADD CONSTRAINT `fkUsuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `clientes` (`ID`),
  ADD CONSTRAINT `fk_pedido` FOREIGN KEY (`ID_Pedido`) REFERENCES `pedido` (`ID_Pedido`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_idcarro` FOREIGN KEY (`ID_Carrito`) REFERENCES `carrito` (`ID_Carrito`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_idusu` FOREIGN KEY (`ID_Usuario`) REFERENCES `clientes` (`ID`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`ID_Administrador`) REFERENCES `administrador` (`ID`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID_Categoria`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD CONSTRAINT `fk_prod` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID_Producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`ID_Producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `unioncarritoproducto`
--
ALTER TABLE `unioncarritoproducto`
  ADD CONSTRAINT `fk_id_carrito` FOREIGN KEY (`ID_Carrito`) REFERENCES `carrito` (`ID_Carrito`),
  ADD CONSTRAINT `fk_id_producto` FOREIGN KEY (`ID_Productos`) REFERENCES `producto` (`ID_Producto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
