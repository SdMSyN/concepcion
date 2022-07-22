-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2016 a las 15:30:20
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `concepcion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

CREATE TABLE IF NOT EXISTS `almacenes` (
  `id` int(11) NOT NULL,
  `created` date NOT NULL,
  `user_create` int(11) NOT NULL,
  `updated` date NOT NULL,
  `user_update` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tienda_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=992 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `created` date NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `img` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costales`
--

CREATE TABLE IF NOT EXISTS `costales` (
  `id` int(11) NOT NULL,
  `tienda_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE IF NOT EXISTS `estatus` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_info`
--

CREATE TABLE IF NOT EXISTS `pedidos_info` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tienda_id` int(11) NOT NULL,
  `nombre_cliente` varchar(150) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(5) NOT NULL,
  `total` float(8,2) NOT NULL,
  `est_pedido_id` int(11) NOT NULL,
  `est_pedido_pago_id` int(11) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `hora_entrega_inicial` time NOT NULL,
  `hora_entrega_final` time NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_pagos`
--

CREATE TABLE IF NOT EXISTS `pedidos_pagos` (
  `id` int(11) NOT NULL,
  `pedido_info_id` int(11) NOT NULL,
  `pago` float(8,2) NOT NULL,
  `recibido` float(8,2) NOT NULL,
  `cambio` float(8,2) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_prod`
--

CREATE TABLE IF NOT EXISTS `pedidos_prod` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `pedido_info_id` int(11) NOT NULL,
  `cantidad` int(7) NOT NULL,
  `costo_unitario` float(8,2) NOT NULL,
  `costo_total` float(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_est`
--

CREATE TABLE IF NOT EXISTS `pedido_est` (
  `id` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_est_pago`
--

CREATE TABLE IF NOT EXISTS `pedido_est_pago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE IF NOT EXISTS `perfiles` (
  `id` int(11) NOT NULL,
  `perfil` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` float(8,2) NOT NULL,
  `img` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codigo_barras` varchar(20) NOT NULL,
  `pan_frio` tinyint(1) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `subcategoria_id` int(11) NOT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `updated_by_user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1301 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sobrantes`
--

CREATE TABLE IF NOT EXISTS `sobrantes` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `tienda_ida` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE IF NOT EXISTS `subcategorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `created` date NOT NULL,
  `create_by` int(11) NOT NULL,
  `updated` date NOT NULL,
  `update_by` int(11) NOT NULL,
  `img` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=705 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiendas`
--

CREATE TABLE IF NOT EXISTS `tiendas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `cp` int(5) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `num_sess` int(2) NOT NULL,
  `latitud` varchar(20) NOT NULL,
  `longitud` varchar(20) NOT NULL,
  `password` varchar(15) NOT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL,
  `activo` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ap` varchar(30) NOT NULL,
  `am` varchar(30) NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  `password` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `num_int` varchar(10) DEFAULT NULL,
  `num_ext` varchar(10) DEFAULT NULL,
  `colonia` varchar(50) DEFAULT NULL,
  `municipio` varchar(40) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL,
  `fec_nac` date DEFAULT NULL,
  `activo` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_info`
--

CREATE TABLE IF NOT EXISTS `ventas_info` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tienda_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(5) NOT NULL,
  `pago` float(8,2) NOT NULL,
  `total` float(8,2) NOT NULL,
  `cambio` float(8,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6295 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_prod`
--

CREATE TABLE IF NOT EXISTS `ventas_prod` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `venta_info_id` int(11) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `costo_unitario` varchar(10) NOT NULL,
  `costo_total` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39441 DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id`), ADD KEY `producto_id` (`producto_id`), ADD KEY `tienda_id` (`tienda_id`), ADD KEY `user_update` (`user_update`), ADD KEY `user_create` (`user_create`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `nombre` (`nombre`), ADD KEY `created_by_user_id` (`created_by_user_id`);

--
-- Indices de la tabla `costales`
--
ALTER TABLE `costales`
  ADD PRIMARY KEY (`id`), ADD KEY `tienda_id` (`tienda_id`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos_info`
--
ALTER TABLE `pedidos_info`
  ADD PRIMARY KEY (`id`), ADD KEY `usuario_id` (`usuario_id`), ADD KEY `tienda_id` (`tienda_id`);

--
-- Indices de la tabla `pedidos_pagos`
--
ALTER TABLE `pedidos_pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos_prod`
--
ALTER TABLE `pedidos_prod`
  ADD PRIMARY KEY (`id`), ADD KEY `producto_id` (`producto_id`), ADD KEY `venta__info_id` (`pedido_info_id`);

--
-- Indices de la tabla `pedido_est`
--
ALTER TABLE `pedido_est`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido_est_pago`
--
ALTER TABLE `pedido_est_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`), ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `sobrantes`
--
ALTER TABLE `sobrantes`
  ADD PRIMARY KEY (`id`), ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `nombre` (`nombre`), ADD KEY `categoria_id` (`categoria_id`), ADD KEY `create_by` (`create_by`), ADD KEY `update_by` (`update_by`);

--
-- Indices de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user` (`user`), ADD KEY `perfil_id` (`perfil_id`);

--
-- Indices de la tabla `ventas_info`
--
ALTER TABLE `ventas_info`
  ADD PRIMARY KEY (`id`), ADD KEY `usuario_id` (`usuario_id`), ADD KEY `tienda_id` (`tienda_id`);

--
-- Indices de la tabla `ventas_prod`
--
ALTER TABLE `ventas_prod`
  ADD PRIMARY KEY (`id`), ADD KEY `producto_id` (`producto_id`), ADD KEY `venta__info_id` (`venta_info_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=992;
--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `costales`
--
ALTER TABLE `costales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `pedidos_info`
--
ALTER TABLE `pedidos_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `pedidos_pagos`
--
ALTER TABLE `pedidos_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT de la tabla `pedidos_prod`
--
ALTER TABLE `pedidos_prod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedido_est`
--
ALTER TABLE `pedido_est`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `pedido_est_pago`
--
ALTER TABLE `pedido_est_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1301;
--
-- AUTO_INCREMENT de la tabla `sobrantes`
--
ALTER TABLE `sobrantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=705;
--
-- AUTO_INCREMENT de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `ventas_info`
--
ALTER TABLE `ventas_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6295;
--
-- AUTO_INCREMENT de la tabla `ventas_prod`
--
ALTER TABLE `ventas_prod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39441;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacenes`
--
ALTER TABLE `almacenes`
ADD CONSTRAINT `almacenes_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
ADD CONSTRAINT `almacenes_ibfk_2` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`);

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`created_by_user_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `costales`
--
ALTER TABLE `costales`
ADD CONSTRAINT `costales_ibfk_1` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `sobrantes`
--
ALTER TABLE `sobrantes`
ADD CONSTRAINT `sobrantes_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
ADD CONSTRAINT `subcategorias_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
ADD CONSTRAINT `subcategorias_ibfk_2` FOREIGN KEY (`create_by`) REFERENCES `usuarios` (`id`),
ADD CONSTRAINT `subcategorias_ibfk_3` FOREIGN KEY (`update_by`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`perfil_id`) REFERENCES `perfiles` (`id`);

--
-- Filtros para la tabla `ventas_info`
--
ALTER TABLE `ventas_info`
ADD CONSTRAINT `ventas_info_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
ADD CONSTRAINT `ventas_info_ibfk_2` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`);

--
-- Filtros para la tabla `ventas_prod`
--
ALTER TABLE `ventas_prod`
ADD CONSTRAINT `ventas_prod_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
ADD CONSTRAINT `ventas_prod_ibfk_2` FOREIGN KEY (`venta_info_id`) REFERENCES `ventas_info` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
